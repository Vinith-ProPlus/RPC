<?php

namespace App\Http\Controllers\web\masters\general;

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
use Hash;
use cruds;
use ValidUnique;
use ValidDB;
use logs;
use Helper;
use activeMenuNames;
use docTypes;
class ConstructionTypeController extends Controller{
	private $general;
	private $UserID;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $Settings;
    private $Menus;
	private $generalDB;
	private $FileTypes;
	
    public function __construct(){
		$this->ActiveMenuName=activeMenuNames::ConstructionType->value;
		$this->PageTitle="Construction Type";
        $this->middleware('auth');
		$this->FileTypes=Helper::getFileTypes(array("category"=>array("Images")));
		$this->generalDB=Helper::getGeneralDB();
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
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['menus']=$this->Menus;
			$FormData['crud']=$this->CRUD;
			return view('app.master.general.construction-type.view',$FormData);
		}elseif($this->general->isCrudAllow($this->CRUD,"Add")==true){
			return Redirect::to('/admin/master/general/construction-type/create');
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
            return view('app.master.general.construction-type.trash',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/admin/master/general/construction-type/');
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
            return view('app.master.general.construction-type.create',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/master/general/construction-type/');
        }else{
            return view('errors.403');
        }
    }
    public function edit(Request $req,$ConTypeID){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=true;
			$FormData['ConTypeID']=$ConTypeID;
			$FormData['FileTypes']=$this->FileTypes;
			$FormData['EditData']=DB::Table('tbl_construction_type')->where('DFlag',0)->Where('ConTypeID',$ConTypeID)->get();
			if(count($FormData['EditData'])>0){
				return view('app.master.general.construction-type.create',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/master/general/construction-type/');
        }else{
            return view('errors.403');
        }
    }
    public function save(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"add")==true){
			$OldData=array();$NewData=array();$ConTypeID="";
			$rules=array(
				'ConTypeName' =>['required','min:2','max:50',new ValidUnique(array("TABLE"=>'tbl_construction_type',"WHERE"=>" ConTypeName='".$req->ConTypeName."'"),"This Construction Type Title is already taken.")],
			);
			$message=array();
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Construction Type Create Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			try {
				$ConTypeLogo = "";
				$ConTypeID=DocNum::getDocNum(docTypes::ConstructionType->value);
				$dir="uploads/master/general/con-type/".$ConTypeID."/";
				if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
				if($req->hasFile('ConTypeLogo')){
					$file = $req->file('ConTypeLogo');
					$fileName=md5($file->getClientOriginalName() . time());
					$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
					$file->move($dir, $fileName1);  
					$ConTypeLogo=$dir.$fileName1;
				}else if(Helper::isJSON($req->ConTypeLogo)==true){
					$Img=json_decode($req->ConTypeLogo);
					if(file_exists($Img->uploadPath)){
						$fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
						copy($Img->uploadPath,$dir.$fileName1);
						$ConTypeLogo=$dir.$fileName1;
						unlink($Img->uploadPath);
					}
				}
				$data=array(
					"ConTypeID"=>$ConTypeID,
					"ConTypeName"=>$req->ConTypeName,
					'ConTypeLogo'=>$ConTypeLogo,
					"Description"=>$req->Description,
					"ActiveStatus"=>$req->ActiveStatus,
					"CreatedBy"=>$this->UserID,
					"CreatedOn"=>date("Y-m-d H:i:s")
				);
				$status=DB::Table('tbl_construction_type')->insert($data);
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DocNum::updateDocNum(docTypes::ConstructionType->value);
				$NewData=DB::table('tbl_construction_type')->where('ConTypeID',$ConTypeID)->get();
				$logData=array("Description"=>"New Construction Type Created","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::ADD->value,"ReferID"=>$ConTypeID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				DB::commit();
				return array('status'=>true,'message'=>"Construction Type Created Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Construction Type Create Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
    public function update(Request $req,$ConTypeID){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OldData=array();$NewData=array();
        
			$rules=array(
				'ConTypeName' =>['required','max:50',new ValidUnique(array("TABLE"=>'tbl_construction_type',"WHERE"=>" ConTypeName='".$req->ConTypeName."' and ConTypeID<>'".$ConTypeID."'  "),"This Construction Type Name is already taken.")],
			);
			$message=array();
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Construction Type Update Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			try {
				$OldData=DB::table('tbl_construction_type')->where('ConTypeID',$ConTypeID)->get();
				$ConTypeLogo = "";
				$dir="uploads/master/general/con-type/".$ConTypeID."/";
				if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
				if($req->hasFile('ConTypeLogo')){
					$file = $req->file('ConTypeLogo');
					$fileName=md5($file->getClientOriginalName() . time());
					$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
					$file->move($dir, $fileName1);  
					$ConTypeLogo=$dir.$fileName1;
				}else if(Helper::isJSON($req->ConTypeLogo)==true){
					$Img=json_decode($req->ConTypeLogo);
					if(file_exists($Img->uploadPath)){
						$fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
						copy($Img->uploadPath,$dir.$fileName1);
						$ConTypeLogo=$dir.$fileName1;
						unlink($Img->uploadPath);
					}
				}
				$data=array(
					"ConTypeName"=>$req->ConTypeName,
					"Description"=>$req->Description,
					"ActiveStatus"=>$req->ActiveStatus,
					"UpdatedBy"=>$this->UserID,
					"UpdatedOn"=>date("Y-m-d H:i:s")
				);
				if($ConTypeLogo!=""){
					$data['ConTypeLogo']=$ConTypeLogo;
				}
				$status=DB::Table('tbl_construction_type')->where('ConTypeID',$ConTypeID)->update($data);
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				$NewData=DB::table('tbl_construction_type')->where('ConTypeID',$ConTypeID)->get();
				$logData=array("Description"=>"Construction Type Updated ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE->value,"ReferID"=>$ConTypeID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				DB::commit();
				return array('status'=>true,'message'=>"Construction Type Updated Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Construction Type Update Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
	
	public function Delete(Request $req,$ConTypeID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_construction_type')->where('ConTypeID',$ConTypeID)->get();
				$status=DB::table('tbl_construction_type')->where('ConTypeID',$ConTypeID)->update(array("DFlag"=>1,"DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Construction Type has been Deleted ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::DELETE->value,"ReferID"=>$ConTypeID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Construction Type Deleted Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Construction Type Delete Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function Restore(Request $req,$ConTypeID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_construction_type')->where('ConTypeID',$ConTypeID)->get();
				$status=DB::table('tbl_construction_type')->where('ConTypeID',$ConTypeID)->update(array("DFlag"=>0,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_construction_type')->where('ConTypeID',$ConTypeID)->get();
				$logData=array("Description"=>"Construction Type has been Restored ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::RESTORE->value,"ReferID"=>$ConTypeID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Construction Type Restored Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Construction Type Restore Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TableView(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'ConTypeID', 'dt' => '0' ),
				array( 'db' => 'ConTypeName', 'dt' => '1' ),
				array( 'db' => 'ActiveStatus', 'dt' => '2',
					'formatter' => function( $d, $row ) {
						if($d=="Active"){
							return "<span class='badge badge-success m-1'>Active</span>";
						}else{
							return "<span class='badge badge-danger m-1'>Inactive</span>";
						}
					} 
				),
				array( 'db' => 'ConTypeID', 'dt' => '3',
					'formatter' => function( $d, $row ) {
						$html='';
						if($this->general->isCrudAllow($this->CRUD,"edit")==true && $row['ConTypeName'] !='Others'){
							$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].' m-5 mr-10 btnEdit" data-original-title="Edit"><i class="fa fa-pencil"></i></button>';
						}
						if($this->general->isCrudAllow($this->CRUD,"delete")==true && $row['ConTypeName'] !='Others'){
							$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-danger '.$this->general->UserInfo['Theme']['button-size'].' m-5 btnDelete" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
						}
						return $html;
					} 
				)
			);
			$Where = " DFlag=0 ";
			$data=array();
			$data['POSTDATA']=$req;
			$data['TABLE']='tbl_construction_type';
			$data['PRIMARYKEY']='ConTypeID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=$Where;
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TrashTableView(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			$columns = array(
				array( 'db' => 'ConTypeID', 'dt' => '0' ),
				array( 'db' => 'ConTypeName', 'dt' => '1' ),
				array( 'db' => 'ActiveStatus', 'dt' => '2',
					'formatter' => function( $d, $row ) {
						if($d=="Active"){
							return "<span class='badge badge-success m-1'>Active</span>";
						}else{
							return "<span class='badge badge-danger m-1'>Inactive</span>";
						}
					} 
				),
				array( 'db' => 'ConTypeID', 'dt' => '3',
					'formatter' => function( $d, $row ) {
						$html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].'  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
						return $html;
					} 
				)
			);
			$data=array();
			$data['POSTDATA']=$req;
			$data['TABLE']='tbl_construction_type';
			$data['PRIMARYKEY']='ConTypeID';
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
	public function GetConstructionType(request $req){
		return DB::Table('tbl_construction_type')->where('ActiveStatus','Active')->where('DFlag',0)->get();
	}

}
