<?php
namespace App\Http\Controllers\web;

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
use Helper;
use ValidUnique;
use logs;
use activeMenuNames;
use docTypes;
use cruds;

class SupportController extends Controller{
	private $general;
	private $UserID;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $Settings;
    private $Menus;
	private $generalDB;
    private $supportDB;

    public function __construct(){
		$this->ActiveMenuName=activeMenuNames::SupportTickets->value;
        $this->PageTitle="Support Tickets";
        $this->middleware('auth');    
		$this->middleware(function ($request, $next) {
			$this->UserID=auth()->user()->UserID;
			$this->general=new general($this->UserID,$this->ActiveMenuName);
			$this->Menus=$this->general->loadMenu();
			$this->CRUD=$this->general->getCrudOperations($this->ActiveMenuName);
			$this->Settings=$this->general->getSettings();
			$this->generalDB=Helper::getGeneralDB();
            $this->supportDB=Helper::getSupportDB();
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
            return view('app.support.view',$FormData);
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
            return view('app.support.trash',$FormData);
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
            return view('app.support.create',$FormData);
        }else{
            return view('errors.403');
        }
    }
    public function edit(Request $req,$SupportID){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=true;
			$FormData['EditData']=DB::Table('tbl_support')->where('DFlag',0)->Where('SupportID',$SupportID)->get();
			if(count($FormData['EditData'])>0){
				return view('app.transaction.order.quote',$FormData);
			}else{
				return view('errors.403');
			}
        }else{
            return view('errors.403');
        }
    }
	
	public function Solved(Request $req,$SupportID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table($this->supportDB.'tbl_support')->where('SupportID',$SupportID)->get();
				$status=DB::table($this->supportDB.'tbl_support')->where('SupportID',$SupportID)->update(array("Status"=>"Solved","UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Ticket has been Solved ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE->value,"ReferID"=>$SupportID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Ticket Solved Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Ticket Solve Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function Delete(Request $req,$SupportID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table($this->supportDB.'tbl_support')->where('SupportID',$SupportID)->get();
				$status=DB::table($this->supportDB.'tbl_support')->where('SupportID',$SupportID)->update(array("DFlag"=>1,"DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Ticket has been Cancelled ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::DELETE->value,"ReferID"=>$SupportID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Ticket Cancelled Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Ticket Cancelled Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function Restore(Request $req,$SupportID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table($this->supportDB.'tbl_support')->where('SupportID',$SupportID)->get();
				$status=DB::table($this->supportDB.'tbl_support')->where('SupportID',$SupportID)->update(array("DFlag"=>0,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table($this->supportDB.'tbl_support')->where('SupportID',$SupportID)->get();
				$logData=array("Description"=>"Ticket has been Restored ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::RESTORE->value,"ReferID"=>$SupportID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Ticket Restored Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Ticket Restore Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}

	public function TableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'SupportID', 'dt' => '0' ),
				array( 'db' => 'TicketDate', 'dt' => '1','formatter' => function( $d, $row ) {return date($this->Settings['DATE-FORMAT'],strtotime($d));}),
				array( 'db' => 'TicketFrom', 'dt' => '2' ),
				array(
                    'db' => 'UserID',
                    'dt' => '3',
                    'formatter' => function($d, $row) {
                        if ($row['TicketFrom'] == 'Vendor') {
                            return DB::table('tbl_vendors')->where('VendorID', $d)->value('VendorName');
                        } else if ($row['TicketFrom'] == 'Customer') {
                            return DB::table('users')->where('UserID', $d)->value('Name');
                        }
                    }
                ),
				array(
                    'db' => 'UserID',
                    'dt' => '4',
                    'formatter' => function($d, $row) {
                        if ($row['TicketFrom'] == 'Vendor') {
                            return DB::table('tbl_vendors')->where('VendorID', $d)->value('MobileNumber1');
                        } else if ($row['TicketFrom'] == 'Customer') {
                            return DB::table('users')->where('UserID', $d)->value('MobileNumber');
                        }
                    }
                ),
				array( 'db' => 'SupportType', 'dt' => '5',
                    'formatter' => function( $d, $row ) {
                        return DB::table('tbl_support_type')->where('SLNO', $d)->value('SupportType');
                    } 
                ),
				array( 'db' => 'Status','dt' => '6',
					'formatter' => function( $d, $row ) {
						$badgeClass = '';
                        switch ($d) {
                            case 'Solved':
                                $badgeClass = 'badge-success';
                                break;
                            case 'Unsolved':
                                $badgeClass = 'badge-danger';
                                break;
                            default:
                                $badgeClass = 'badge-primary';
                                break;
                        }
                        return "<span class='badge {$badgeClass} m-1'>" . $d . "</span>";
					}
				),
				array(
                    'db' => 'Priority',
                    'dt' => '7',
                    'formatter' => function($d, $row) {
                        $badgeClass = '';
                        switch ($d) {
                            case 'Medium':
                                $badgeClass = 'badge-success';
                                break;
                            case 'High':
                                $badgeClass = 'badge-danger';
                                break;
                            default:
                                $badgeClass = 'badge-primary';
                                break;
                        }
                        return "<span class='badge {$badgeClass} m-1'>" . $d . "</span>";
                    }
                ),
                
				array( 
						'db' => 'SupportID',
						'dt' => '8',
						'formatter' => function( $d, $row ) {
							$html='';
							if($this->general->isCrudAllow($this->CRUD,"view")==true){
								$html.='<button type="button" data-id="'.$d.'" class="btn btn-outline-info '.$this->general->UserInfo['Theme']['button-size'].'  mr-10 btnView">View Ticket</button>';
							}
							if($row['Status'] =='New'){
								if($this->general->isCrudAllow($this->CRUD,"edit")==true){
									$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].'  mr-10 btnSolved" data-original-title="Edit">Mark as Solved</button>';
								}
								if($this->general->isCrudAllow($this->CRUD,"delete")==true){
									$html.='<button type="button" data-id="'.$d.'" class="btn btn-outline-danger '.$this->general->UserInfo['Theme']['button-size'].'  btnDelete" data-original-title="Delete">Cancel</button>';
								}
							}
							return $html;
						} 
				)
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']=$this->supportDB.'tbl_support';
			$data['PRIMARYKEY']='SupportID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" DFlag = 0";
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TrashTableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'SupportID', 'dt' => '0' ),
				array( 'db' => 'TicketDate', 'dt' => '1','formatter' => function( $d, $row ) {return date($this->Settings['DATE-FORMAT'],strtotime($d));}),
				array( 'db' => 'TicketFrom', 'dt' => '2' ),
				array(
                    'db' => 'UserID',
                    'dt' => '3',
                    'formatter' => function($d, $row) {
                        if ($row['TicketFrom'] == 'Vendor') {
                            return DB::table('tbl_vendors')->where('VendorID', $d)->value('VendorName');
                        } else if ($row['TicketFrom'] == 'Customer') {
                            return DB::table('users')->where('UserID', $d)->value('Name');
                        }
                    }
                ),
				array(
                    'db' => 'UserID',
                    'dt' => '4',
                    'formatter' => function($d, $row) {
                        if ($row['TicketFrom'] == 'Vendor') {
                            return DB::table('tbl_vendors')->where('VendorID', $d)->value('MobileNumber1');
                        } else if ($row['TicketFrom'] == 'Customer') {
                            return DB::table('users')->where('UserID', $d)->value('MobileNumber');
                        }
                    }
                ),
				array( 'db' => 'SupportType', 'dt' => '5',
                    'formatter' => function( $d, $row ) {
                        return DB::table('tbl_support_type')->where('SLNO', $d)->value('SupportType');
                    } 
                ),
				array( 'db' => 'Status','dt' => '6',
					'formatter' => function( $d, $row ) {
						$badgeClass = '';
                        switch ($d) {
                            case 'Solved':
                                $badgeClass = 'badge-success';
                                break;
                            case 'Unsolved':
                                $badgeClass = 'badge-danger';
                                break;
                            default:
                                $badgeClass = 'badge-primary';
                                break;
                        }
                        return "<span class='badge {$badgeClass} m-1'>" . $d . "</span>";
					}
				),
				array(
                    'db' => 'Priority',
                    'dt' => '7',
                    'formatter' => function($d, $row) {
                        $badgeClass = '';
                        switch ($d) {
                            case 'Medium':
                                $badgeClass = 'badge-success';
                                break;
                            case 'High':
                                $badgeClass = 'badge-danger';
                                break;
                            default:
                                $badgeClass = 'badge-primary';
                                break;
                        }
                        return "<span class='badge {$badgeClass} m-1'>" . $d . "</span>";
                    }
                ),
				array( 
						'db' => 'SupportID', 
						'dt' => '8',
						'formatter' => function( $d, $row ) {
							$html='';
							if($this->general->isCrudAllow($this->CRUD,"restore")==true){
								$html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success btn-sm  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
							}
							return $html;
						} 
				)
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']=$this->supportDB.'tbl_support';
			$data['PRIMARYKEY']='SupportID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" DFlag = 1";
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}

	public function SupportType(Request $req){
		return DB::table('tbl_support_type')->where('DFlag',0)->where('ActiveStatus',1)->get();
	}
	public function SupportDetailsView(Request $req,$SupportID){
		$TicketData = DB::table($this->supportDB.'tbl_support')->where('SupportID',$SupportID)->first();
		$TicketData->Attachments = DB::table($this->supportDB.'tbl_attachment')->where('ReferID',$SupportID)->get();
        return $TicketData;
	}

}
