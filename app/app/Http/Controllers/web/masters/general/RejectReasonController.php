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
class RejectReasonController extends Controller{
	private $general;
	private $UserID;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $Settings;
    private $Menus;
	private $generalDB;
	
    public function __construct(){
		$this->ActiveMenuName=activeMenuNames::RejectReason->value;
		$this->PageTitle="Reject Reason";
        $this->middleware('auth');
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
			return view('app.master.general.reject-reason.view',$FormData);
		}elseif($this->general->isCrudAllow($this->CRUD,"Add")==true){
			return Redirect::to('/admin/master/general/reject-reason/create');
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
            return view('app.master.general.reject-reason.trash',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/admin/master/general/reject-reason/');
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
			$FormData['ReasonType']=DB::table('tbl_reject_reason_type')->where('ActiveStatus','Active')->get();
            return view('app.master.general.reject-reason.create',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/master/general/reject-reason/');
        }else{
            return view('errors.403');
        }
    }
    public function edit(Request $req,$RReasonID){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=true;
			$FormData['RReasonID']=$RReasonID;
			$FormData['ReasonType']=DB::table('tbl_reject_reason_type')->where('ActiveStatus','Active')->get();
			$FormData['EditData']=DB::Table('tbl_reject_reason')->where('DFlag',0)->Where('RReasonID',$RReasonID)->get();
			if(count($FormData['EditData'])>0){
				return view('app.master.general.reject-reason.create',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/master/general/reject-reason/');
        }else{
            return view('errors.403');
        }
    }
    public function save(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"add")==true){
			$OldData=array();$NewData=array();$RReasonID="";
			$rules=array(
				'RReason' =>['required','min:2','max:50',new ValidUnique(array("TABLE"=>'tbl_reject_reason',"WHERE"=>" RReason='".$req->RReason."' and RRTypeID='".$req->RRTypeID."' "),"This Reject Reason Title is already taken.")],
			);
			$message=array();
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Reject Reason Create Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			try {
				$RReasonID=DocNum::getDocNum(docTypes::RejectReason->value);
				$data=array(
					"RReasonID"=>$RReasonID,
					"RReason"=>$req->RReason,
					"RRTypeID"=>$req->RRTypeID,
					"Description"=>$req->Description,
					"ActiveStatus"=>$req->ActiveStatus,
					"CreatedBy"=>$this->UserID,
					"CreatedOn"=>date("Y-m-d H:i:s")
				);
				$status=DB::Table('tbl_reject_reason')->insert($data);
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DocNum::updateDocNum(docTypes::RejectReason->value);
				$NewData=DB::table('tbl_reject_reason')->where('RReasonID',$RReasonID)->get();
				$logData=array("Description"=>"New Reject Reason Created","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::ADD->value,"ReferID"=>$RReasonID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				DB::commit();
				return array('status'=>true,'message'=>"Reject Reason Created Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Reject Reason Create Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
    public function update(Request $req,$RReasonID){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OldData=array();$NewData=array();
        
			$rules=array(
				'RReason' =>['required','max:50',new ValidUnique(array("TABLE"=>'tbl_reject_reason',"WHERE"=>" RReason='".$req->RReason."' and RRTypeID='".$req->RRTypeID."' and RReasonID<>'".$RReasonID."'  "),"This Reject Reason Name is already taken.")],
			);
			$message=array();
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Reject Reason Update Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			try {
				$OldData=DB::table('tbl_reject_reason')->where('RReasonID',$RReasonID)->get();
				$data=array(
					"RReason"=>$req->RReason,
					"RRTypeID"=>$req->RRTypeID,
					"Description"=>$req->Description,
					"ActiveStatus"=>$req->ActiveStatus,
					"UpdatedBy"=>$this->UserID,
					"UpdatedOn"=>date("Y-m-d H:i:s")
				);
				$status=DB::Table('tbl_reject_reason')->where('RReasonID',$RReasonID)->update($data);
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				$NewData=DB::table('tbl_reject_reason')->where('RReasonID',$RReasonID)->get();
				$logData=array("Description"=>"Reject Reason Updated ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE->value,"ReferID"=>$RReasonID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				DB::commit();
				return array('status'=>true,'message'=>"Reject Reason Updated Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Reject Reason Update Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
	
	public function Delete(Request $req,$RReasonID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_reject_reason')->where('RReasonID',$RReasonID)->get();
				$status=DB::table('tbl_reject_reason')->where('RReasonID',$RReasonID)->update(array("DFlag"=>1,"DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Reject Reason has been Deleted ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::DELETE->value,"ReferID"=>$RReasonID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Reject Reason Deleted Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Reject Reason Delete Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function Restore(Request $req,$RReasonID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_reject_reason')->where('RReasonID',$RReasonID)->get();
				$status=DB::table('tbl_reject_reason')->where('RReasonID',$RReasonID)->update(array("DFlag"=>0,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_reject_reason')->where('RReasonID',$RReasonID)->get();
				$logData=array("Description"=>"Reject Reason has been Restored ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::RESTORE->value,"ReferID"=>$RReasonID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Reject Reason Restored Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Reject Reason Restore Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TableView(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'RReasonID', 'dt' => '0' ),
				array( 'db' => 'RReason', 'dt' => '1' ),
				array( 'db' => 'RRTypeID', 'dt' => '2',
					'formatter' => function( $d, $row ) {
						return DB::table('tbl_reject_reason_type')->where('RRTypeID',$d)->value('RRType');
					}
			 	),
				array( 'db' => 'ActiveStatus', 'dt' => '3',
					'formatter' => function( $d, $row ) {
						if($d=="Active"){
							return "<span class='badge badge-success m-1'>Active</span>";
						}else{
							return "<span class='badge badge-danger m-1'>Inactive</span>";
						}
					} 
				),
				array( 'db' => 'RReasonID', 'dt' => '4',
					'formatter' => function( $d, $row ) {
						$html='';
						if($this->general->isCrudAllow($this->CRUD,"edit")==true && $row['RReason'] !='Others'){
							$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].' m-5 mr-10 btnEdit" data-original-title="Edit"><i class="fa fa-pencil"></i></button>';
						}
						if($this->general->isCrudAllow($this->CRUD,"delete")==true && $row['RReason'] !='Others'){
							$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-danger '.$this->general->UserInfo['Theme']['button-size'].' m-5 btnDelete" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
						}
						return $html;
					} 
				)
			);
			$Where = " DFlag=0 ";
			$data=array();
			$data['POSTDATA']=$req;
			$data['TABLE']='tbl_reject_reason';
			$data['PRIMARYKEY']='RReasonID';
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
				array( 'db' => 'RReasonID', 'dt' => '0' ),
				array( 'db' => 'RReason', 'dt' => '1' ),
				array( 'db' => 'RRTypeID', 'dt' => '2',
					'formatter' => function( $d, $row ) {
						return DB::table('tbl_reject_reason_type')->where('RRTypeID',$d)->value('RRType');
					}
			 	),
				array( 'db' => 'ActiveStatus', 'dt' => '3',
					'formatter' => function( $d, $row ) {
						if($d=="Active"){
							return "<span class='badge badge-success m-1'>Active</span>";
						}else{
							return "<span class='badge badge-danger m-1'>Inactive</span>";
						}
					} 
				),
				array( 'db' => 'RReasonID', 'dt' => '4',
					'formatter' => function( $d, $row ) {
						$html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].'  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
						return $html;
					} 
				)
			);
			$data=array();
			$data['POSTDATA']=$req;
			$data['TABLE']='tbl_reject_reason';
			$data['PRIMARYKEY']='RReasonID';
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
	public function GetRejectReason(request $req){
		return DB::Table('tbl_reject_reason')->where('ActiveStatus','Active')->where('DFlag',0)->get();
	}

}
