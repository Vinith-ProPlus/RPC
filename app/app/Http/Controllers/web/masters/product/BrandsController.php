<?php
namespace App\Http\Controllers\web\masters\product;

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
class BrandsController extends Controller{
	private $general;
	private $DocNum;
	private $UserID;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $Settings;
	private $FileTypes;
    private $Menus;
    public function __construct(){
		$this->ActiveMenuName=activeMenuNames::Brands->value;
		$this->PageTitle="Brands";
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
            return view('app.master.product.brands.view',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"add")==true){
			return Redirect::to('/admin/master/product/brands/create');
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
            return view('app.master.product.brands.trash',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/admin/master/product/brands/');
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
            return view('app.master.product.brands.create',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/master/product/brands/');
        }else{
            return view('errors.403');
        }
    }
    public function edit(Request $req,$BrandID){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=true;
			$FormData['FileTypes']=$this->FileTypes;
			$FormData['EditData']=DB::Table('tbl_brands')->where('DFlag',0)->Where('BrandID',$BrandID)->get();
			if(count($FormData['EditData'])>0){
				return view('app.master.product.brands.create',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/master/product/brands');
        }else{
            return view('errors.403');
        }
    }
    public function save(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"add")==true){
			$OldData=array();$NewData=array();$BrandID="";
			$rules=array(
				'BrandName' =>['required','max:50',new ValidUnique(array("TABLE"=>"tbl_brands","WHERE"=>" BrandName='".$req->BrandName."'  "),"This Brand Name is already taken.")],
			);
			$message=array(
				'BrandName.required'=>"Brand Name is required",
				'BrandName.min'=>"Brand Name must be greater than 2 characters",
				'BrandName.max'=>"Brand Name may not be greater than 100 characters",
				'BrandLogo.mimes'=>"The Brand Logo field must be a file of type: ".implode(", ",$this->FileTypes['category']['Images'])."."
			);
			if($req->hasFile('BrandLogo')){
				$rules['BrandLogo']='mimes:'.implode(",",$this->FileTypes['category']['Images']);
			}
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Brand Create Failed",'errors'=>$validator->errors());
			}
			DB::beginTransaction();
			$status=false;
			$images=array();
			try {
				$BrandLogo="";
				$BrandID=DocNum::getDocNum(docTypes::Brands->value);
				$dir="uploads/master/product/brands/".$BrandID."/";
				if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
				if($req->hasFile('BrandLogo')){
					$file = $req->file('BrandLogo');
					$fileName=md5($file->getClientOriginalName() . time());
					$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
					$file->move($dir, $fileName1);
					$BrandLogo=$dir.$fileName1;
				}else if(Helper::isJSON($req->BrandLogo)==true){
					$Img=json_decode($req->BrandLogo);
					if(file_exists($Img->uploadPath)){
						$fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
						copy($Img->uploadPath,$dir.$fileName1);
						$BrandLogo=$dir.$fileName1;
						unlink($Img->uploadPath);
					}
				}
				if(file_exists($BrandLogo)){
					$images=helper::ImageResize($BrandLogo,$dir);
				}
				$data=array(
					"BrandID"=>$BrandID,
					"BrandName"=>$req->BrandName,
					'BrandLogo'=>$BrandLogo,
					"Images"=>serialize($images),
					"ActiveStatus"=>$req->ActiveStatus,
					"CreatedBy"=>$this->UserID,
					"CreatedOn"=>date("Y-m-d H:i:s")
				);
				$status=DB::Table('tbl_brands')->insert($data);
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DocNum::updateDocNum(docTypes::Brands->value);
				DB::commit();
				$NewData=DB::table('tbl_brands')->where('BrandID',$BrandID)->get();
				$logData=array("Description"=>"New Brand Created ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::ADD->value,"ReferID"=>$BrandID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Brand Created Successfully");
			}else{
				DB::rollback();
				//Helper::removeFile($BrandLogo);
				foreach($images as $KeyName=>$Img){
					Helper::removeFile($Img['url']);
				}
				return array('status'=>false,'message'=>"Brand Create Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
    public function update(Request $req,$BrandID){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OldData=array();$NewData=array();
			$rules=array(
				'BrandName' =>['required','max:50',new ValidUnique(array("TABLE"=>"tbl_brands","WHERE"=>" BrandName='".$req->BrandName."' and BrandID<>'".$BrandID."'  "),"This Brand Name is already taken.")]
			)				;
			$message=array(
				'BrandName.required'=>"Brand Name is required",
				'BrandName.min'=>"Brand Name must be greater than 2 characters",
				'BrandName.max'=>"Brand Name may not be greater than 100 characters",
				'BrandLogo.mimes'=>"The Brand Logo field must be a file of type: ".implode(", ",$this->FileTypes['category']['Images'])."."
			);
			if($req->hasFile('BrandLogo')){
				$rules['BrandLogo']='mimes:'.implode(",",$this->FileTypes['category']['Images']);
			}
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Brand Update Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			$currBLogo=array();
			$images=array();
			try {
				$OldData=DB::table('tbl_brands')->where('BrandID',$BrandID)->get();
				$BrandLogo="";
				$dir="uploads/master/product/brands/".$BrandID."/";
				if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
				if($req->hasFile('BrandLogo')){
					$file = $req->file('BrandLogo');
					$fileName=md5($file->getClientOriginalName() . time());
					$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
					$file->move($dir, $fileName1);
					$BrandLogo=$dir.$fileName1;
				}else if(Helper::isJSON($req->BrandLogo)==true){
					$Img=json_decode($req->BrandLogo);
					if(file_exists($Img->uploadPath)){
						$fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
						copy($Img->uploadPath,$dir.$fileName1);
						$BrandLogo=$dir.$fileName1;
						unlink($Img->uploadPath);
					}
				}
				if(file_exists($BrandLogo)){
					$images=helper::ImageResize($BrandLogo,$dir);
				}
				if(($BrandLogo!="" || intval($req->removeBLogo)==1) && Count($OldData)>0){ 
					$currBLogo=$OldData[0]->Images!=""?unserialize($OldData[0]->Images):array();
				}
				$data=array(
					"BrandName"=>$req->BrandName,
					"ActiveStatus"=>$req->ActiveStatus,
					"UpdatedBy"=>$this->UserID,
					"UpdatedOn"=>date("Y-m-d H:i:s")
				);
				if($BrandLogo!=""){
					$data['BrandLogo']=$BrandLogo;
					$data['Images']=serialize($images);
				}else if(intval($req->removeBLogo)==1){
					$data['BrandLogo']="";
					$data['Images']=serialize(array());
				}
				$status=DB::Table('tbl_brands')->where('BrandID',$BrandID)->update($data);
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_brands')->where('BrandID',$BrandID)->get();
				$logData=array("Description"=>"Brand Updated ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE->value,"ReferID"=>$BrandID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				//Helper::removeFile($currBLogo);
				
				foreach($currBLogo as $KeyName=>$Img){
					Helper::removeFile($Img['url']);
				}
				return array('status'=>true,'message'=>"Brand Updated Successfully");
			}else{
				DB::rollback();
				foreach($images as $KeyName=>$Img){
					Helper::removeFile($Img['url']);
				}
				return array('status'=>false,'message'=>"Brand Update Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
	public function Delete(Request $req,$BrandID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_brands')->where('BrandID',$BrandID)->get();
				$status=DB::table('tbl_brands')->where('BrandID',$BrandID)->update(array("DFlag"=>1,"DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Brand has been Deleted ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::DELETE->value,"ReferID"=>$BrandID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Brand Deleted Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Brand Delete Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function Restore(Request $req,$BrandID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_brands')->where('BrandID',$BrandID)->get();
				$status=DB::table('tbl_brands')->where('BrandID',$BrandID)->update(array("DFlag"=>0,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_brands')->where('BrandID',$BrandID)->get();
				$logData=array("Description"=>"Brand has been Restored ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::RESTORE->value,"ReferID"=>$BrandID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Brand Restored Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Brand Restore Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'BrandID', 'dt' => '0' ),
				array( 'db' => 'BrandName', 'dt' => '1' ),
				array( 'db' => 'ActiveStatus', 'dt' => '2',
					'formatter' => function( $d, $row ) {
						if($d=="Active"){
							return "<span class='badge badge-success m-1'>Active</span>";
						}else{
							return "<span class='badge badge-danger m-1'>Inactive</span>";
						}
					} 
				),
				array( 'db' => 'BrandID', 'dt' => '3',
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
			$data['TABLE']='tbl_brands';
			$data['PRIMARYKEY']='BrandID';
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
				array( 'db' => 'BrandID', 'dt' => '0' ),
				array( 'db' => 'BrandName', 'dt' => '1' ),
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
					'db' => 'BrandID', 
					'dt' => '3',
					'formatter' => function( $d, $row ) {
						$html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].'  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
						return $html;
					} 
				)
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_brands';
			$data['PRIMARYKEY']='BrandID';
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

	public static function GetBrand(request $req){
		return DB::Table('tbl_brands')->where('ActiveStatus','Active')->where('DFlag',0)->get();
	}
	
}
