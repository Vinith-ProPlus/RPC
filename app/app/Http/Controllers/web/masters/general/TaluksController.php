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
class TaluksController extends Controller{
	private $general;
	private $UserID;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $Settings;
    private $Menus;
	private $generalDB;
    public function __construct(){
		$this->ActiveMenuName=activeMenuNames::Taluks->value;
		$this->PageTitle="Taluks";
        $this->middleware('auth');
		$this->generalDB=Helper::getGeneralDB();
		$this->middleware(function ($req, $next) {
			$this->UserID=auth()->user()->UserID;
			$this->general=new general($this->UserID,$this->ActiveMenuName);
			$this->Menus=$this->general->loadMenu();
			$this->CRUD=$this->general->getCrudOperations($this->ActiveMenuName);
			$this->Settings=$this->general->getSettings();
			return $next($req);
		});
    }
	public function view(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$FormData=$this->general->UserInfo;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['menus']=$this->Menus;
			$FormData['crud']=$this->CRUD;
			return view('app.master.general.taluks.view',$FormData);
		}elseif($this->general->isCrudAllow($this->CRUD,"Add")==true){
			return Redirect::to('/admin/master/general/taluks/create');
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
            return view('app.master.general.taluks.trash',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/admin/master/general/taluks/');
        }else{
            return view('errors.403');
        }
    }
    public function create(Request $req){
        if($this->general->isCrudAllow($this->CRUD,"add")==true){
			$OtherCruds=array(
				"Country"=>$this->general->getCrudOperations(activeMenuNames::Country->value),
				"States"=>$this->general->getCrudOperations(activeMenuNames::States->value),
				"Districts"=>$this->general->getCrudOperations(activeMenuNames::Districts->value),
			);
            $FormData=$this->general->UserInfo;
			$FormData['OtherCruds']=$OtherCruds;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=false;
            return view('app.master.general.taluks.create',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/master/general/taluks/');
        }else{
            return view('errors.403');
        }
    }
    public function edit(Request $req,$TalukID){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OtherCruds=array(
				"Country"=>$this->general->getCrudOperations(activeMenuNames::Country->value),
				"States"=>$this->general->getCrudOperations(activeMenuNames::States->value),
				"Districts"=>$this->general->getCrudOperations(activeMenuNames::Districts->value),
			);
            $FormData=$this->general->UserInfo;
			$FormData['OtherCruds']=$OtherCruds;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=true;
			$FormData['TalukID']=$TalukID;
			$FormData['EditData']=DB::Table($this->generalDB.'tbl_taluks')->where('DFlag',0)->Where('TalukID',$TalukID)->get();
			if(count($FormData['EditData'])>0){
				return view('app.master.general.taluks.create',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/master/general/taluks/');
        }else{
            return view('errors.403');
        }
    }
	
    public function save(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"add")==true){
			$OldData=array();$NewData=array();$TalukID="";
			$ValidDB=array();
			$ValidDB['Country']['TABLE']=$this->generalDB."tbl_countries";
			$ValidDB['Country']['ErrMsg']="Country name  does not exist";
			$ValidDB['Country']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->CountryID);
			$ValidDB['Country']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>1);
			$ValidDB['Country']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);
			
			$ValidDB['State']['TABLE']=$this->generalDB."tbl_states";
			$ValidDB['State']['ErrMsg']="State name  does not exist";
			$ValidDB['State']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->CountryID);
			$ValidDB['State']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$req->StateID);
			$ValidDB['State']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>1);
			$ValidDB['State']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

			$ValidDB['District']['TABLE']=$this->generalDB."tbl_districts";
			$ValidDB['District']['ErrMsg']="District name  does not exist";
			$ValidDB['District']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->CountryID);
			$ValidDB['District']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$req->StateID);
			$ValidDB['District']['WHERE'][]=array("COLUMN"=>"DistrictID","CONDITION"=>"=","VALUE"=>$req->DistrictID);
			$ValidDB['District']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>1);
			$ValidDB['District']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);
			$rules=array(
				'CountryID' =>['required',$ValidDB['Country']],
				'StateID' =>['required',$ValidDB['State']],
				'DistrictID' =>['required',$ValidDB['District']],
				'TalukName' =>['required','min:3','max:100',new ValidUnique(array("TABLE"=>$this->generalDB."tbl_taluks","WHERE"=>" TalukName='".$req->TalukName."' and CountryID='".$req->CountryID."' and StateID='".$req->StateID."' and DistrictID='".$req->DistrictID."' "),"This Taluk Name is already taken.")],
			);				;
			$message=array();
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Taluk Create Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			try {
				$TalukID=DocNum::getDocNum(docTypes::Taluks->value,"",Helper::getCurrentFY());
				$data=array(
					"TalukID"=>$TalukID,
					"TalukName"=>$req->TalukName,
					"DistrictID"=>$req->DistrictID,
					"StateID"=>$req->StateID,
					"CountryID"=>$req->CountryID,
					"ActiveStatus"=>$req->ActiveStatus,
					"CreatedBy"=>$this->UserID,
					"CreatedOn"=>date("Y-m-d H:i:s")
				);
				$status=DB::Table($this->generalDB.'tbl_taluks')->insert($data);
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DocNum::updateDocNum(docTypes::Taluks->value);
				$NewData=DB::table($this->generalDB.'tbl_taluks')->where('TalukID',$TalukID)->get();
				$logData=array("Description"=>"New Taluk Created","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::ADD->value,"ReferID"=>$TalukID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				DB::commit();
				return array('status'=>true,'message'=>"Taluk Created Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Taluk Create Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
    public function update(Request $req,$TalukID){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OldData=array();$NewData=array();
			$ValidDB=array();
			$ValidDB['Country']['TABLE']=$this->generalDB."tbl_countries";
			$ValidDB['Country']['ErrMsg']="Country name  does not exist";
			$ValidDB['Country']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->CountryID);
			$ValidDB['Country']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>1);
			$ValidDB['Country']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);
			
			$ValidDB['State']['TABLE']=$this->generalDB."tbl_states";
			$ValidDB['State']['ErrMsg']="State name  does not exist";
			$ValidDB['State']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->CountryID);
			$ValidDB['State']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$req->StateID);
			$ValidDB['State']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>1);
			$ValidDB['State']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

			$ValidDB['District']['TABLE']=$this->generalDB."tbl_districts";
			$ValidDB['District']['ErrMsg']="District name  does not exist";
			$ValidDB['District']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->CountryID);
			$ValidDB['District']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$req->StateID);
			$ValidDB['District']['WHERE'][]=array("COLUMN"=>"DistrictID","CONDITION"=>"=","VALUE"=>$req->DistrictID);
			$ValidDB['District']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>1);
			$ValidDB['District']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);
			$rules=array(
				'CountryID' =>['required',$ValidDB['Country']],
				'StateID' =>['required',$ValidDB['State']],
				'DistrictID' =>['required',$ValidDB['District']],
				'TalukName' =>['required','min:3','max:100',new ValidUnique(array("TABLE"=>$this->generalDB."tbl_taluks","WHERE"=>" TalukName='".$req->TalukName."' and CountryID='".$req->CountryID."' and StateID='".$req->StateID."' and DistrictID='".$req->DistrictID."' and TalukID<>'".$TalukID."' "),"This Taluk Name is already taken.")],
			);
			$message=array();
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Taluk Update Failed",'errors'=>$validator->errors());
			}
			DB::beginTransaction();
			$status=false;
			try {
				$OldData=DB::table($this->generalDB.'tbl_taluks')->where('TalukID',$TalukID)->get();
				$data=array(
					"TalukName"=>$req->TalukName,
					"DistrictID"=>$req->DistrictID,
					"StateID"=>$req->StateID,
					"CountryID"=>$req->CountryID,
					"ActiveStatus"=>$req->ActiveStatus,
					"UpdatedBy"=>$this->UserID,
					"UpdatedOn"=>date("Y-m-d H:i:s")
				);
				$status=DB::Table($this->generalDB.'tbl_taluks')->where('TalukID',$TalukID)->update($data);
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				$NewData=DB::table($this->generalDB.'tbl_taluks')->where('TalukID',$TalukID)->get();
				$logData=array("Description"=>"Taluk Updated ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE->value,"ReferID"=>$TalukID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				DB::commit();
				return array('status'=>true,'message'=>"Taluk Updated Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Taluk Update Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
	
	public function Delete(Request $req,$TalukID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table($this->generalDB.'tbl_taluks')->where('TalukID',$TalukID)->get();
				$status=DB::table($this->generalDB.'tbl_taluks')->where('TalukID',$TalukID)->update(array("DFlag"=>1,"DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Taluk has been Deleted ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::DELETE->value,"ReferID"=>$TalukID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Taluk Deleted Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Taluk Delete Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function Restore(Request $req,$TalukID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table($this->generalDB.'tbl_taluks')->where('TalukID',$TalukID)->get();
				$status=DB::table($this->generalDB.'tbl_taluks')->where('TalukID',$TalukID)->update(array("DFlag"=>0,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table($this->generalDB.'tbl_taluks')->where('TalukID',$TalukID)->get();
				$logData=array("Description"=>"Taluk has been Restored ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::RESTORE->value,"ReferID"=>$TalukID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Taluk Restored Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Taluk Restore Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TableView(Request $req){ 
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'T.TalukID', 'dt' => '0' ),
				array( 'db' => 'T.TalukName', 'dt' => '1' ),
				array( 'db' => 'D.DistrictName', 'dt' => '2' ),
				array( 'db' => 'S.StateName', 'dt' => '3' ),
				array( 'db' => 'C.CountryName', 'dt' => '4' ),
				array( 'db' => 'T.ActiveStatus', 'dt' => '5'),
			);
			$columns1 = array(
				array( 'db' => 'TalukID', 'dt' => '0' ),
				array( 'db' => 'TalukName', 'dt' => '1' ),
				array( 'db' => 'DistrictName', 'dt' => '2' ),
				array( 'db' => 'StateName', 'dt' => '3' ),
				array( 'db' => 'CountryName', 'dt' => '4' ),
				array( 'db' => 'ActiveStatus', 'dt' => '5',
					'formatter' => function( $d, $row ) {
						if($d=="Active"){
							return "<span class='badge badge-success m-1'>Active</span>";
						}else{
							return "<span class='badge badge-danger m-1'>Inactive</span>";
						}
					} 
				),
				array( 'db' => 'TalukID', 'dt' => '6',
					'formatter' => function( $d, $row ) {
						$html='';
						if($this->general->isCrudAllow($this->CRUD,"edit")==true){
							$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].' m-5 mr-10 btnEdit" data-original-title="Edit"><i class="fa fa-pencil"></i></button>';
						}
						if($this->general->isCrudAllow($this->CRUD,"delete")==true){
							$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-danger '.$this->general->UserInfo['Theme']['button-size'].' m-5 btnDelete" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
						}
						return $html;
					} 
				)
			);
			$Where = " T.DFlag=0 and T.CountryID = '$req->CountryID' and T.StateID = '$req->StateID'";
			if($req->DistrictID!=""){
				$Where.=" and T.DistrictID = '$req->DistrictID'";
			}
			if($req->ActiveStatus != ""){
				$Where.=" and T.ActiveStatus = '$req->ActiveStatus'";
			}
			$data=array();
			$data['POSTDATA']=$req;
			$data['TABLE']=$this->generalDB.'tbl_taluks as T LEFT JOIN '.$this->generalDB.'tbl_districts as D ON D.DistrictID = T.DistrictID LEFT JOIN '.$this->generalDB.'tbl_states as S ON S.StateID = T.StateID LEFT JOIN '.$this->generalDB.'tbl_countries as C ON C.CountryID = T.CountryID';
			$data['PRIMARYKEY']='TalukID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns1;
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
				array( 'db' => 'T.TalukID', 'dt' => '0' ),
				array( 'db' => 'T.TalukName', 'dt' => '1' ),
				array( 'db' => 'D.DistrictName', 'dt' => '2' ),
				array( 'db' => 'S.StateName', 'dt' => '3' ),
				array( 'db' => 'C.CountryName', 'dt' => '4' ),
				array( 'db' => 'T.ActiveStatus', 'dt' => '5'),
			);
			$columns1 = array(
				array( 'db' => 'TalukID', 'dt' => '0' ),
				array( 'db' => 'TalukName', 'dt' => '1' ),
				array( 'db' => 'DistrictName', 'dt' => '2' ),
				array( 'db' => 'StateName', 'dt' => '3' ),
				array( 'db' => 'CountryName', 'dt' => '4' ),
				array( 'db' => 'ActiveStatus', 'dt' => '5',
					'formatter' => function( $d, $row ) {
						if($d=="Active"){
							return "<span class='badge badge-success m-1'>Active</span>";
						}else{
							return "<span class='badge badge-danger m-1'>Inactive</span>";
						}
					} 
				),
				array( 'db' => 'TalukID', 'dt' => '6',
					'formatter' => function( $d, $row ) {
						$html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].'  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
						return $html;
					} 
				)
			);
			$Where = " T.DFlag=1 ";
			/* if($req->Country!=""){
				$Country=json_decode($req->Country,true);
				if(count($Country)>0){
					$Where.=" and T.CountryID in('".implode("','",$Country)."')";
				}
			}
			if($req->State!=""){
				$State=json_decode($req->State,true);
				if(count($State)>0){
					$Where.=" and T.StateID in('".implode("','",$State)."')";
				}
			} */
			$data=array();
			$data['POSTDATA']=$req;
			$data['TABLE']=$this->generalDB.'tbl_taluks as T LEFT JOIN '.$this->generalDB.'tbl_districts as D ON D.DistrictID = T.DistrictID LEFT JOIN '.$this->generalDB.'tbl_states as S ON S.StateID = T.StateID LEFT JOIN '.$this->generalDB.'tbl_countries as C ON C.CountryID = T.CountryID';
			$data['PRIMARYKEY']='TalukID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns1;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=$Where;
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
}
