<?php
namespace App\Http\Controllers\web\masters\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DocNum;
use general;
use SSP;
use DB;
use Auth;
use ValidUnique;
use logs;
use Helper;
use activeMenuNames;
use docTypes;
use cruds;
use dynamicField;
class VendorCategoryController extends Controller{
	private $general;
	private $DocNum;
	private $UserID;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $Settings;
	private $FileTypes;
    private $Menus;
    private $dynamicForms;
    public function __construct(){
		$this->ActiveMenuName=activeMenuNames::VendorCategory->value;
		$this->PageTitle="Vendor Category";
        $this->middleware('auth');
		$this->FileTypes=Helper::getFileTypes(array("category"=>array("Images")));
		$this->middleware(function ($request, $next) {
			$this->UserID=auth()->user()->UserID;
			$this->general=new general($this->UserID,$this->ActiveMenuName);
			$this->Menus=$this->general->loadMenu();
			$this->CRUD=$this->general->getCrudOperations($this->ActiveMenuName);
			$this->Settings=$this->general->getSettings();
			return $next($request);
		});
    }
    public function view(Request $req){
        if($this->general->isCrudAllow($this->CRUD,"view")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
            return view('app.master.vendor.category.view',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"add")==true){
			return Redirect::to('/admin/master/vendor/category/create');
        }else{
            return view('errors.403');
        }
    }
    public function TrashView(Request $req){
        if($this->general->isCrudAllow($this->CRUD,"restore")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
            return view('app.master.vendor.category.trash',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/admin/master/vendor/category/');
        }else{
            return view('errors.403');
        }
    }
    public function create(Request $req){
        if($this->general->isCrudAllow($this->CRUD,"add")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=false;
			$FormData['FileTypes']=$this->FileTypes;
            return view('app.master.vendor.category.create',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/master/vendor/category/');
        }else{
            return view('errors.403');
        }
    }
    public function edit(Request $req,$VCID){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=true;
			$FormData['FileTypes']=$this->FileTypes;
			$FormData['EditData']=DB::Table('tbl_vendor_category')->where('DFlag',0)->Where('VCID',$VCID)->get();
			if(count($FormData['EditData'])>0){
				return view('app.master.vendor.category.create',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/master/vendor/category');	
        }else{
            return view('errors.403');
        }
    }
    public function save(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"add")==true){
			$OldData=array();$NewData=array();$VCID="";
			$rules=array(
				'VCName' =>['required','max:50',new ValidUnique(array("TABLE"=>"tbl_vendor_category","WHERE"=>" VCName='".$req->VCName."'  "),"This Vendor Category Name is already taken.")],
			);
			$message=array(
				'VCName.required'=>"Vendor Category Name is required",
				'VCName.min'=>"Vendor Category Name must be greater than 2 characters",
				'VCName.max'=>"Vendor Category Name may not be greater than 100 characters",
				'VCImage.mimes'=>"The Vendor Category image field must be a file of type: ".implode(", ",$this->FileTypes['category']['Images'])."."
			);
			if($req->hasFile('VCImage')){
				$rules['VCImage']='mimes:'.implode(",",$this->FileTypes['category']['Images']);
			}
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Vendor Category Create Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			$images=array();
			try {
				$VCImage="";
				$VCID=DocNum::getDocNum(docTypes::VendorCategory->value,"",Helper::getCurrentFY());
				$dir="uploads/master/vendor/category/".$VCID."/";
				if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
				if($req->hasFile('VCImage')){
					$file = $req->file('VCImage');
					$fileName=md5($file->getClientOriginalName() . time());
					$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
					$file->move($dir, $fileName1);  
					$VCImage=$dir.$fileName1;
				}else if(Helper::isJSON($req->VCImage)==true){
					$Img=json_decode($req->VCImage);
					if(file_exists($Img->uploadPath)){
						$fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
						copy($Img->uploadPath,$dir.$fileName1);
						$VCImage=$dir.$fileName1;
						unlink($Img->uploadPath);
					}
				}
				if(file_exists($VCImage)){
					$images=helper::ImageResize($VCImage,$dir);
				}
				$data=array(
					"VCID"=>$VCID,
					"VCName"=>$req->VCName,
					'VCImage'=>$VCImage,
					"Images"=>serialize($images),
					"ActiveStatus"=>$req->ActiveStatus,
					"CreatedBy"=>$this->UserID,
					"CreatedOn"=>date("Y-m-d H:i:s")
				);
				$status=DB::Table('tbl_vendor_category')->insert($data);
				if($status){
					DB::commit();
					$status=dynamicField::add(docTypes::VendorCategory->value,$req,"tbl_vendor_category","VCID",$VCID,$this->UserID);
					if(DB::transactionLevel()==0){
						DB::beginTransaction();
					}
				}
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DocNum::updateDocNum(docTypes::VendorCategory->value);
				DB::commit();
				$NewData=DB::table('tbl_vendor_category')->where('VCID',$VCID)->get();
				$logData=array("Description"=>"New Vendor Category Created ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::ADD->value,"ReferID"=>$VCID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Vendor Category Created Successfully");
			}else{
				DB::rollback();
				//Helper::removeFile($VCImage);
				foreach($images as $KeyName=>$Img){
					Helper::removeFile($Img['url']);
				}
				return array('status'=>false,'message'=>"Vendor Category Create Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}

	}
    public function update(Request $req,$VCID){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OldData=array();$NewData=array();
			$rules=array(
				'VCName' =>['required','max:50',new ValidUnique(array("TABLE"=>"tbl_vendor_category","WHERE"=>" VCName='".$req->VCName."' and VCID<>'".$VCID."'  "),"This Vendor Category Name is already taken.")]
			)				;
			$message=array(
				'VCName.required'=>"Vendor Category Name is required",
				'VCName.min'=>"Vendor Category Name must be greater than 2 characters",
				'VCName.max'=>"Vendor Category Name may not be greater than 100 characters",
				'VCImage.mimes'=>"The Vendor Category image field must be a file of type: ".implode(", ",$this->FileTypes['category']['Images'])."."
			);
			if($req->hasFile('VCImage')){
				$rules['VCImage']='mimes:'.implode(",",$this->FileTypes['category']['Images']);
			}
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Vendor Category Update Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			$currVCImage=array();
			$images=array();
			try {
				$OldData=DB::table('tbl_vendor_category')->where('VCID',$VCID)->get();
				$VCImage="";
				$dir="uploads/master/vendor/category/".$VCID."/";
				if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
				if($req->hasFile('VCImage')){
					$file = $req->file('VCImage');
					$fileName=md5($file->getClientOriginalName() . time());
					$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
					$file->move($dir, $fileName1);  
					$VCImage=$dir.$fileName1;
				}else if(Helper::isJSON($req->VCImage)==true){
					$Img=json_decode($req->VCImage);
					if(file_exists($Img->uploadPath)){
						$fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
						copy($Img->uploadPath,$dir.$fileName1);
						$VCImage=$dir.$fileName1;
						unlink($Img->uploadPath);
					}
				}
				if(file_exists($VCImage)){
					$images=Helper::ImageResize($VCImage,$dir);
				}
				if(($VCImage!="" || intval($req->removeVCImage)==1) && Count($OldData)>0){ 
					$currVCImage=$OldData[0]->Images!=""?unserialize($OldData[0]->Images):array();
				}
				$data=array(
					"VCName"=>$req->VCName,
					"ActiveStatus"=>$req->ActiveStatus,
					"UpdatedBy"=>$this->UserID,
					"UpdatedOn"=>date("Y-m-d H:i:s")
				);
				if($VCImage!=""){
					$data['VCImage']=$VCImage;
					$data['Images']=serialize($images);
				}else if(intval($req->removeVCImage)==1){
					$data['VCImage']="";
					$data['Images']=serialize(array());
				}
				$status=DB::Table('tbl_vendor_category')->where('VCID',$VCID)->update($data);
				if($status){
					DB::commit();
					$status=dynamicField::add(docTypes::VendorCategory->value,$req,"tbl_vendor_category","VCID",$VCID,$this->UserID);
					if(DB::transactionLevel()==0){
						DB::beginTransaction();
					}
				}
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_vendor_category')->where('VCID',$VCID)->get();
				$logData=array("Description"=>"Vendor Category Updated ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE->value,"ReferID"=>$VCID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				//Helper::removeFile($currVCImage);
				
				foreach($currVCImage as $KeyName=>$Img){
					Helper::removeFile($Img['url']);
				}
				return array('status'=>true,'message'=>"Vendor Category Updated Successfully");
			}else{
				DB::rollback();
				foreach($images as $KeyName=>$Img){
					Helper::removeFile($Img['url']);
				}
				return array('status'=>false,'message'=>"Vendor Category Update Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
	public function Delete(Request $req,$VCID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_vendor_category')->where('VCID',$VCID)->get();
				$status=DB::table('tbl_vendor_category')->where('VCID',$VCID)->update(array("DFlag"=>1,"DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Vendor Category has been Deleted ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::DELETE->value,"ReferID"=>$VCID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Vendor Category Deleted Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Vendor Category Delete Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function Restore(Request $req,$VCID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_vendor_category')->where('VCID',$VCID)->get();
				$status=DB::table('tbl_vendor_category')->where('VCID',$VCID)->update(array("DFlag"=>0,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_vendor_category')->where('VCID',$VCID)->get();
				$logData=array("Description"=>"Vendor Category has been Restored ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::RESTORE->value,"ReferID"=>$VCID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Vendor Category Restored Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Vendor Category Restore Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'VCID', 'dt' => '0' ),
				array( 'db' => 'VCName', 'dt' => '1' ),
				array( 'db' => 'ActiveStatus', 'dt' => '2',
					'formatter' => function( $d, $row ) {
						if($d=="Active"){
							return "<span class='badge badge-success m-1'>Active</span>";
						}else{
							return "<span class='badge badge-danger m-1'>Inactive</span>";
						}
					} 
				),
				array( 'db' => 'VCID', 'dt' => '3',
					'formatter' => function( $d, $row ) {
						$html='';
						if($this->general->isCrudAllow($this->CRUD,"edit")==true){
							$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].' mr-10 btnEdit" data-original-title="Edit"><i class="fa fa-pencil"></i></button>';
						}
						if($this->general->isCrudAllow($this->CRUD,"delete")==true){
							$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-danger '.$this->general->UserInfo['Theme']['button-size'].' btnDelete" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
						}
						return $html;
					} 
				)
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_vendor_category';
			$data['PRIMARYKEY']='VCID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" DFlag=0 ";
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TrashTableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			$columns = array(
				array( 'db' => 'VCID', 'dt' => '0' ),
				array( 'db' => 'VCName', 'dt' => '1' ),
				array( 'db' => 'ActiveStatus', 'dt' => '2',
					'formatter' => function( $d, $row ) {
						if($d=="Active"){
							return "<span class='badge badge-success m-1'>Active</span>";
						}else{
							return "<span class='badge badge-danger m-1'>Inactive</span>";
						}
					} 
				),
				array( 
					'db' => 'VCID', 
					'dt' => '3',
					'formatter' => function( $d, $row ) {
						$html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].'  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
						return $html;
					} 
				)
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_vendor_category';
			$data['PRIMARYKEY']='VCID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" DFlag=1 ";
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}

	// Create Form

	private function getUserID(){
		if(Auth::Check()){
			return auth()->user()->UserID;
		}
		return "";
	}
    private function getThemesOption(){
		$UserID=$this->getUserID();
    	$return=array("button-size"=>"btn-sm","table-size"=>"table-sm","input-size"=>"","switch-size"=>"");
    	$result=DB::Table('tbl_user_theme')->where('UserID',$UserID)->get();
    	if(count($result)>0){
    		for($i=0;$i<count($result);$i++){
    			$return[$result[$i]->Theme_option]=$result[$i]->Theme_Value;
    		}
    	}
    	return $return;
    }
	public function GetNewVendorCategory(Request $req){
		$Theme=$this->getThemesOption();
		return view("modals.vendorCategory",array("Theme"=>$Theme,"FileTypes"=>$this->FileTypes));
	}
	public static function GetVendorCategory(request $req){
		return DB::Table('tbl_vendor_category')->where('ActiveStatus','Active')->where('DFlag',0)->get();
	}
}
