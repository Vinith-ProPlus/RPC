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
class VendorTypeController extends Controller{
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
		$this->ActiveMenuName=activeMenuNames::VendorType->value;
		$this->PageTitle="Vendor Type";
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
            return view('app.master.vendor.vendor-type.view',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"add")==true){
			return Redirect::to('/admin/master/vendor/vendor-type/create');
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
            return view('app.master.vendor.vendor-type.trash',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/admin/master/vendor/vendor-type/');
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
            return view('app.master.vendor.vendor-type.create',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/vendor-master/vendor-type/');
        }else{
            return view('errors.403');
        }
    }
    public function edit(Request $req,$VendorTypeID){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=true;
			$FormData['FileTypes']=$this->FileTypes;
			$FormData['EditData']=DB::Table('tbl_vendor_type')->where('DFlag',0)->Where('VendorTypeID',$VendorTypeID)->get();
			if(count($FormData['EditData'])>0){
				return view('app.master.vendor.vendor-type.create',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/vendor-master/category');	
        }else{
            return view('errors.403');
        }
    }
    public function save(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"add")==true){
			$OldData=array();$NewData=array();$VendorTypeID="";
			$rules=array(
				'VendorType' =>['required','max:50',new ValidUnique(array("TABLE"=>"tbl_vendor_type","WHERE"=>" VendorType='".$req->VendorType."'  "),"This Vendor Type Name is already taken.")],
			);
			$message=array(
				'VendorType.required'=>"Vendor Type Name is required",
				'VendorType.min'=>"Vendor Type Name must be greater than 2 characters",
				'VendorType.max'=>"Vendor Type Name may not be greater than 100 characters",
				'STImage.mimes'=>"The Vendor Type image field must be a file of type: ".implode(", ",$this->FileTypes['category']['Images'])."."
			);
			if($req->hasFile('STImage')){
				$rules['STImage']='mimes:'.implode(",",$this->FileTypes['category']['Images']);
			}
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Vendor Type Create Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			$images=array();
			try {
				$STImage="";
				$VendorTypeID=DocNum::getDocNum(docTypes::VendorType->value,"",Helper::getCurrentFY());
				$dir="uploads/vendor-master/vendor-type/".$VendorTypeID."/";
				if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
				if($req->hasFile('STImage')){
					$file = $req->file('STImage');
					$fileName=md5($file->getClientOriginalName() . time());
					$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
					$file->move($dir, $fileName1);  
					$STImage=$dir.$fileName1;
				}else if(Helper::isJSON($req->STImage)==true){
					$Img=json_decode($req->STImage);
					if(file_exists($Img->uploadPath)){
						$fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
						copy($Img->uploadPath,$dir.$fileName1);
						$STImage=$dir.$fileName1;
						unlink($Img->uploadPath);
					}
				}
				if(file_exists($STImage)){
					$images=helper::ImageResize($STImage,$dir);
				}
				$data=array(
					"VendorTypeID"=>$VendorTypeID,
					"VendorType"=>$req->VendorType,
					'STImage'=>$STImage,
					"Images"=>serialize($images),
					"ActiveStatus"=>$req->ActiveStatus,
					"CreatedBy"=>$this->UserID,
					"CreatedOn"=>date("Y-m-d H:i:s")
				);
				$status=DB::Table('tbl_vendor_type')->insert($data);
				if($status){
					DB::commit();
					$status=dynamicField::add(docTypes::VendorType->value,$req,"tbl_vendor_type","VendorTypeID",$VendorTypeID,$this->UserID);
					if(DB::transactionLevel()==0){
						DB::beginTransaction();
					}
				}
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DocNum::updateDocNum(docTypes::VendorType->value);
				DB::commit();
				$NewData=DB::table('tbl_vendor_type')->where('VendorTypeID',$VendorTypeID)->get();
				$logData=array("Description"=>"New Vendor Type Created ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::ADD->value,"ReferID"=>$VendorTypeID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Vendor Type Created Successfully");
			}else{
				DB::rollback();
				//Helper::removeFile($STImage);
				foreach($images as $KeyName=>$Img){
					Helper::removeFile($Img['url']);
				}
				return array('status'=>false,'message'=>"Vendor Type Create Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
    public function update(Request $req,$VendorTypeID){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OldData=array();$NewData=array();
			$rules=array(
				'VendorType' =>['required','max:50',new ValidUnique(array("TABLE"=>"tbl_vendor_type","WHERE"=>" VendorType='".$req->VendorType."' and VendorTypeID<>'".$VendorTypeID."'  "),"This Vendor Type Name is already taken.")]
			)				;
			$message=array(
				'VendorType.required'=>"Vendor Type Name is required",
				'VendorType.min'=>"Vendor Type Name must be greater than 2 characters",
				'VendorType.max'=>"Vendor Type Name may not be greater than 100 characters",
				'STImage.mimes'=>"The Vendor Type image field must be a file of type: ".implode(", ",$this->FileTypes['category']['Images'])."."
			);
			if($req->hasFile('STImage')){
				$rules['STImage']='mimes:'.implode(",",$this->FileTypes['category']['Images']);
			}
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Vendor Type Update Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			$currSTImage=array();
			$images=array();
			try {
				$OldData=DB::table('tbl_vendor_type')->where('VendorTypeID',$VendorTypeID)->get();
				$STImage="";
				$dir="uploads/vendor-master/vendor-type/".$VendorTypeID."/";
				if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
				if($req->hasFile('STImage')){
					$file = $req->file('STImage');
					$fileName=md5($file->getClientOriginalName() . time());
					$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
					$file->move($dir, $fileName1);  
					$STImage=$dir.$fileName1;
				}else if(Helper::isJSON($req->STImage)==true){
					$Img=json_decode($req->STImage);
					if(file_exists($Img->uploadPath)){
						$fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
						copy($Img->uploadPath,$dir.$fileName1);
						$STImage=$dir.$fileName1;
						unlink($Img->uploadPath);
					}
				}
				if(file_exists($STImage)){
					$images=helper::ImageResize($STImage,$dir);
				}
				if(($STImage!="" || intval($req->removeSTImage)==1) && Count($OldData)>0){ 
					$currSTImage=$OldData[0]->Images!=""?unserialize($OldData[0]->Images):array();
				}
				$data=array(
					"VendorType"=>$req->VendorType,
					"ActiveStatus"=>$req->ActiveStatus,
					"UpdatedBy"=>$this->UserID,
					"UpdatedOn"=>date("Y-m-d H:i:s")
				);
				if($STImage!=""){
					$data['STImage']=$STImage;
					$data['Images']=serialize($images);
				}else if(intval($req->removeSTImage)==1){
					$data['STImage']="";
					$data['Images']=serialize(array());
				}
				$status=DB::Table('tbl_vendor_type')->where('VendorTypeID',$VendorTypeID)->update($data);
				if($status){
					DB::commit();
					$status=dynamicField::add(docTypes::VendorType->value,$req,"tbl_vendor_type","VendorTypeID",$VendorTypeID,$this->UserID);
					if(DB::transactionLevel()==0){
						DB::beginTransaction();
					}
				}
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_vendor_type')->where('VendorTypeID',$VendorTypeID)->get();
				$logData=array("Description"=>"Vendor Type Updated ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE->value,"ReferID"=>$VendorTypeID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				//Helper::removeFile($currSTImage);
				
				foreach($currSTImage as $KeyName=>$Img){
					Helper::removeFile($Img['url']);
				}
				return array('status'=>true,'message'=>"Vendor Type Updated Successfully");
			}else{
				DB::rollback();
				foreach($images as $KeyName=>$Img){
					Helper::removeFile($Img['url']);
				}
				return array('status'=>false,'message'=>"Vendor Type Update Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
	public function Delete(Request $req,$VendorTypeID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_vendor_type')->where('VendorTypeID',$VendorTypeID)->get();
				$status=DB::table('tbl_vendor_type')->where('VendorTypeID',$VendorTypeID)->update(array("DFlag"=>1,"DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Vendor Type has been Deleted ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::DELETE->value,"ReferID"=>$VendorTypeID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Vendor Type Deleted Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Vendor Type Delete Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function Restore(Request $req,$VendorTypeID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_vendor_type')->where('VendorTypeID',$VendorTypeID)->get();
				$status=DB::table('tbl_vendor_type')->where('VendorTypeID',$VendorTypeID)->update(array("DFlag"=>0,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_vendor_type')->where('VendorTypeID',$VendorTypeID)->get();
				$logData=array("Description"=>"Vendor Type has been Restored ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::RESTORE->value,"ReferID"=>$VendorTypeID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Vendor Type Restored Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Vendor Type Restore Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'VendorTypeID', 'dt' => '0' ),
				array( 'db' => 'VendorType', 'dt' => '1' ),
				array( 'db' => 'ActiveStatus', 'dt' => '2',
					'formatter' => function( $d, $row ) {
						if($d=="Active"){
							return "<span class='badge badge-success m-1'>Active</span>";
						}else{
							return "<span class='badge badge-danger m-1'>Inactive</span>";
						}
					} 
				),
				array( 'db' => 'VendorTypeID', 'dt' => '3',
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
			$data['TABLE']='tbl_vendor_type';
			$data['PRIMARYKEY']='VendorTypeID';
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
				array( 'db' => 'VendorTypeID', 'dt' => '0' ),
				array( 'db' => 'VendorType', 'dt' => '1' ),
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
					'db' => 'VendorTypeID', 
					'dt' => '3',
					'formatter' => function( $d, $row ) {
						$html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].'  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
						return $html;
					} 
				)
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_vendor_type';
			$data['PRIMARYKEY']='VendorTypeID';
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
	public function GetNewVendorType(Request $req){
		$Theme=$this->getThemesOption();
		return view("modals.vendorCategory",array("Theme"=>$Theme,"FileTypes"=>$this->FileTypes));
	}
	public static function GetVendorType(request $req){
		return DB::Table('tbl_vendor_type')->where('ActiveStatus','Active')->where('DFlag',0)->get();
	}
}
