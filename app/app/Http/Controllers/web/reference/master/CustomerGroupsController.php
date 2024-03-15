<?php

namespace App\Http\Controllers\master;

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
class CustomerGroupsController extends Controller{
	private $general;
	private $UserID;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $Settings;
    private $Menus;
    public function __construct(){
		$this->ActiveMenuName=activeMenuNames::CustomerGroups->value;
		$this->PageTitle="Customer Groups";
        $this->middleware('auth');
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
			return view('master.customer-groups.view',$FormData);
		}elseif($this->general->isCrudAllow($this->CRUD,"Add")==true){
			return Redirect::to('/master/customer-groups/create');
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
            return view('master.customer-groups.trash',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/master/customer-groups/');
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
            return view('master.customer-groups.create',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/master/customer-groups/');
        }else{
            return view('errors.403');
        }
    }
    public function edit(Request $req,$GroupID){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=true;
			$FormData['GroupID']=$GroupID;
			$FormData['EditData']=DB::Table('tbl_customer_groups')->where('DFlag',0)->Where('GroupID',$GroupID)->get();
			if(count($FormData['EditData'])>0){
				return view('master.customer-groups.create',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/master/customer-groups/');
        }else{
            return view('errors.403');
        }
    }
    public function save(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"add")==true){
			$OldData=array();$NewData=array();$GroupID="";
			$rules=array(
				'GroupName' =>['required','max:50',new ValidUnique(array("TABLE"=>"tbl_customer_groups","WHERE"=>" GroupName='".$req->GroupName."'  "),"This Group Name  is already taken.")]
			)				;
			$message=array(
				'GroupName.required'=>"Group Name is required",
				'GroupName.min'=>"Group Name must be greater than 2 characters",
				'GroupName.max'=>"Group Name may not be greater than 100 characters"
			);
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Customer Group  Create Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			try {
				$GroupID=DocNum::getDocNum(docTypes::CustomerGroups->value);
				$data=array(
					"GroupID"=>$GroupID,
					"GroupName"=>$req->GroupName,
					"ActiveStatus"=>$req->ActiveStatus,
					"CreatedBy"=>$this->UserID,
					"CreatedOn"=>date("Y-m-d H:i:s")
				);
				$status=DB::Table('tbl_customer_groups')->insert($data);
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DocNum::updateDocNum(docTypes::CustomerGroups->value);
				DB::commit();
				$NewData=DB::table('tbl_customer_groups')->where('GroupID',$GroupID)->get();
				$logData=array("Description"=>"New Customer Group  Created ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::ADD->value,"ReferID"=>$GroupID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Customer Group Created Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Customer Group Create Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
    public function update(Request $req,$GroupID){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OldData=array();$NewData=array();
        
			$rules=array(
				'GroupName' =>['required','max:50',new ValidUnique(array("TABLE"=>"tbl_customer_groups","WHERE"=>" GroupName='".$req->GroupName."' and GroupID<>'".$GroupID."'  "),"This Group Name  is already taken.")],
			)				;
			$message=array(
				'GroupName.required'=>"Group Name is required",
				'GroupName.min'=>"Group Name must be greater than 2 characters",
				'GroupName.max'=>"Group Name may not be greater than 100 characters"
			);
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Group Name Update Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			try {
              
				$OldData=DB::table('tbl_customer_groups')->where('GroupID',$GroupID)->get();
           
				$data=array(
					"GroupName"=>$req->GroupName,
					"ActiveStatus"=>$req->ActiveStatus,
					"UpdatedBy"=>$this->UserID,
					"UpdatedOn"=>date("Y-m-d H:i:s")
				);
				$status=DB::Table('tbl_customer_groups')->where('GroupID',$GroupID)->update($data);
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_customer_groups')->get();
				$logData=array("Description"=>"Customer Group  Updated ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE->value,"ReferID"=>$GroupID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Customer Group Updated Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Customer Group Update Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
	
	public function Delete(Request $req,$GroupID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_customer_groups')->where('GroupID',$GroupID)->get();
				$status=DB::table('tbl_customer_groups')->where('GroupID',$GroupID)->update(array("DFlag"=>1,"DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Customer Group has been Deleted ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::DELETE->value,"ReferID"=>$GroupID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Customer Group Deleted Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Customer Group Delete Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function Restore(Request $req,$GroupID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_customer_groups')->where('GroupID',$GroupID)->get();
				$status=DB::table('tbl_customer_groups')->where('GroupID',$GroupID)->update(array("DFlag"=>0,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_customer_groups')->where('GroupID',$GroupID)->get();
				$logData=array("Description"=>"Customer Group has been Restored ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::RESTORE->value,"ReferID"=>$GroupID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Customer Group Restored Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Customer Group Restore Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'GroupID', 'dt' => '0' ),
				array( 'db' => 'GroupName', 'dt' => '1' ),
				array( 
						'db' => 'ActiveStatus', 
						'dt' => '2',
						'formatter' => function( $d, $row ) {
							if($d=="Active"){
								return "<span class='badge badge-success m-1'>Active</span>";
							}else{
								return "<span class='badge badge-danger m-1'>Inactive</span>";
							}
						} 
                    ),
				array( 
						'db' => 'GroupID', 
						'dt' => '3',
						'formatter' => function( $d, $row ) {
							$html='';
							if($row['isDefault']==0){
								if($this->general->isCrudAllow($this->CRUD,"edit")==true){
									$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].' m-5 mr-10 btnEdit" data-original-title="Edit"><i class="fa fa-pencil"></i></button>';
								}
								if($this->general->isCrudAllow($this->CRUD,"delete")==true){
									$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-danger '.$this->general->UserInfo['Theme']['button-size'].' m-5 btnDelete" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
								}
							}
							return $html;
						} 
					),
				array( 'db' => 'isDefault', 'dt' => '4' ),
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_customer_groups';
			$data['PRIMARYKEY']='GroupID';
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
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'GroupID', 'dt' => '0' ),
				array( 'db' => 'GroupName', 'dt' => '1' ),
				array( 
						'db' => 'ActiveStatus', 
						'dt' => '2',
						'formatter' => function( $d, $row ) {
							if($d=="Active"){
								return "<span class='badge badge-success m-1'>Active</span>";
							}else{
								return "<span class='badge badge-danger m-1'>Inactive</span>";
							}
						} 
                    ),
				array( 
						'db' => 'GroupID', 
						'dt' => '3',
						'formatter' => function( $d, $row ) {
							$html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].'  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
							return $html;
						} 
				)
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_customer_groups';
			$data['PRIMARYKEY']='GroupID';
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
}
