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
use ValidUnique;
use logs;
use Helper;
use activeMenuNames;
use docTypes;
use cruds;

class UOMController extends Controller{
	private $general;
	private $DocNum;
	private $UserID;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $logs;
	private $Settings;
    private $Menus;
    public function __construct(){
		$this->ActiveMenuName=activeMenuNames::UOM->value;
		$this->PageTitle="Unit of Measurement";
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
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
            return view('master.uom.view',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"add")==true){
			return Redirect::to('/master/unit-of-measurement/create');
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
            return view('master.uom.trash',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/master/unit-of-measurement/');
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
            return view('master.uom.uom',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/master/unit-of-measurement/');
        }else{
            return view('errors.403');
        }
    }
    public function edit(Request $req,$CID){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=true;
			$FormData['EditData']=DB::Table('tbl_uom')->where('DFlag',0)->Where('UID',$CID)->get();
			if(count($FormData['EditData'])>0){
				return view('master.uom.uom',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/master/unit-of-measurement/');
        }else{
            return view('errors.403');
        }
    }
    public function save(Request $req){ 
		if($this->general->isCrudAllow($this->CRUD,"add")==true){
			$OldData=array();$NewData=array();$CID="";
			$rules=array(
				'UCode' =>['required','max:50',new ValidUnique(array("TABLE"=>"tbl_uom","WHERE"=>" UCode='".$req->UCode."'"),"This Ucode  is already taken.")],
                'UName' =>['required','max:50',new ValidUnique(array("TABLE"=>"tbl_uom","WHERE"=>" UName='".$req->UName."'"),"This UName  is already taken.")]
			)				;
			$message=array(
				'UCode.required'=>"Ucode  is required",
				'UCode.min'=>"Ucode must be greater than 1 characters",
				'UCode.max'=>"Ucode Name may not be greater than 100 characters",
                'UName.required'=>"UName is required",
				'UName.min'=>"UName Name must be greater than 3 characters",
				'UName.max'=>"UName may not be greater than 100 characters"
			);
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"UOM Create Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			try {
	
				$UomID=DocNum::getDocNum(docTypes::UOM->value);
				$data=array(
					"UID"=>$UomID,
					"UCode"=>$req->UCode,
					'UName'=>$req->UName,
					"ActiveStatus"=>$req->ActiveStatus,
					"CreatedBy"=>$this->UserID,
					"CreatedOn"=>date("Y-m-d H:i:s")
				);
				$status=DB::Table('tbl_uom')->insert($data);
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){			
				$NewData=DB::table('tbl_uom')->where('UID',$UomID)->get();
                DocNum::updateDocNum(docTypes::UOM->value);
				DB::commit();
				$logData=array("Description"=>"New UOM Created ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::ADD->value,"ReferID"=>$CID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Uom Created Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Uom Create Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
    public function update(Request $req,$UID){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OldData=array();$NewData=array();
			$rules=array(
				'UCode' =>['required','max:50',new ValidUnique(array("TABLE"=>"tbl_uom","WHERE"=>" UCode='".$req->UCode."' and UID<>'".$UID."' "),"This Ucode is already taken.")],
                'UName' =>['required','max:50',new ValidUnique(array("TABLE"=>"tbl_uom","WHERE"=>" UName='".$req->UName."' and UID<>'".$UID."'"),"This Uname is already taken.")]
			);
			$message=array(
				'UCode.required'=>"Ucode is required",
				'UCode.min'=>"Ucode must be greater than 2 characters",
				'UCode.max'=>"Ucode may not be greater than 100 characters",
                'UName.required'=>"UName is required",
				'UName.min'=>"UName must be greater than 3 characters",
				'UName.max'=>"UName may not be greater than 100 characters"
			);
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"UOM Update Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			try {
				$OldData=DB::table('tbl_uom')->where('UID',$UID)->get();
				
				$data=array(
					"UID"=>$UID,
					"UCode"=>$req->UCode,
					'UName'=>$req->UName,
					"ActiveStatus"=>$req->ActiveStatus,
					"UpdatedBy"=>$this->UserID,
					"UpdatedOn"=>date("Y-m-d H:i:s")
				);

				$status=DB::Table('tbl_uom')->where('UID',$UID)->update($data);
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_uom')->get();
				$logData=array("Description"=>"UOM Updated ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE->value,"ReferID"=>$UID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"UOM Updated Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"UOM Update Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
	
	public function GetUID(request $req){
		
			$return=array();
			$result=DB::table('tbl_uom')->where('ActiveStatus',1)->where('DFlag',0)->orderBy('UID','asc')->get();
			return $result;

	}


	public function Delete(Request $req,$CID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_uom')->where('UID',$CID)->get();
				$status=DB::table('tbl_uom')->where('UID',$CID)->update(array("DFlag"=>1,"DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Uom has been Deleted ","ModuleName"=>$this->ActiveMenuName,"Action"=>"Delete","ReferID"=>$CID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Uom Deleted Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Uom Delete Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function Restore(Request $req,$CID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_uom')->where('UID',$CID)->get();
				$status=DB::table('tbl_uom')->where('UID',$CID)->update(array("DFlag"=>0,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_uom')->where('UID',$CID)->get();
				$logData=array("Description"=>"Uom has been Restored ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::RESTORE->value,"ReferID"=>$CID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Uom Restored Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Uom Restore Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}

	public function TableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'UID', 'dt' => '0' ),
				array( 'db' => 'UName', 'dt' => '1' ),
                array( 'db' => 'UCode', 'dt' => '2' ),
                
				array( 
						'db' => 'ActiveStatus', 
						'dt' => '3',
						'formatter' => function( $d, $row ) {
							if($d=="Active"){
								return "<span class='badge badge-success m-1'>Active</span>";
							}else{
								return "<span class='badge badge-danger m-1'>Inactive</span>";
							}
						} 
                    ),
				array( 
						'db' => 'UID', 
						'dt' => '4',
						'formatter' => function( $d, $row ) {
							$html='';
							if($this->general->isCrudAllow($this->CRUD,"edit")==true){
								$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].'  mr-10 btnEdit" data-original-title="Edit"><i class="fa fa-pencil"></i></button>';
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
			$data['TABLE']='tbl_uom';
			$data['PRIMARYKEY']='UID';
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
				array( 'db' => 'UID', 'dt' => '0' ),
				array( 'db' => 'UName', 'dt' => '1' ),
                array( 'db' => 'UCode', 'dt' => '2' ),
                
				array( 
						'db' => 'ActiveStatus', 
						'dt' => '3',
						'formatter' => function( $d, $row ) {
							if($d=="Active"){
								return "<span class='badge badge-success m-1'>Active</span>";
							}else{
								return "<span class='badge badge-danger m-1'>Inactive</span>";
							}
						} 
                    ),
					array( 
						'db' => 'UID', 
						'dt' => '4',
						'formatter' => function( $d, $row ) {
							$html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].' m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
							return $html;
						} 
				)
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_uom';
			$data['PRIMARYKEY']='UID';
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
