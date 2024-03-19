<?php
namespace App\Http\Controllers\web\Transaction;

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

class QuotationController extends Controller{
	private $general;
	private $UserID;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $Settings;
    private $Menus;
	private $generalDB;
	private $logDB;
    private $currfyDB;

    public function __construct(){
		$this->ActiveMenuName=activeMenuNames::Quotation->value;
		$this->PageTitle="Quotation";
        $this->middleware('auth');
		$this->middleware(function ($request, $next) {
			$this->UserID=auth()->user()->UserID;
			$this->general=new general($this->UserID,$this->ActiveMenuName);
			$this->Menus=$this->general->loadMenu();
			$this->CRUD=$this->general->getCrudOperations($this->ActiveMenuName);
			$this->Settings=$this->general->getSettings();
			$this->generalDB=Helper::getGeneralDB();
			$this->currfyDB=Helper::getCurrFYDB();
			$this->logDB=Helper::getLogDB();
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
            return view('app.transaction.quotation.view',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"add")==true){
			return Redirect::to('admin/transaction/quotation/create');
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
            return view('app.transaction.quotation.trash',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('admin/transaction/quotation/');
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
			$FormData['QNo']=DocNum::getInvNo($this->ActiveMenuName);
            return view('app.transaction.quotation.quote',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/transaction/quotation/');
        }else{
            return view('errors.403');
        }
    }
    public function edit(Request $req,$QID){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=true;
			$FormData['EditData']=DB::Table('tbl_quotation')->where('DFlag',0)->Where('QID',$QID)->get();
			if(count($FormData['EditData'])>0){
				return view('app.transaction.quotation.quote',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('admin/transaction/quotation/');
        }else{
            return view('errors.403');
        }
    }
    public function QuoteView(Request $req,$QID){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=false;
			$FormData['Settings']=$this->Settings;
			$QData=DB::Table($this->currfyDB.'tbl_quotation as Q')
			->leftJoin('tbl_customer as CU', 'CU.CustomerID', 'Q.CustomerID')
			->leftJoin($this->generalDB.'tbl_countries as C','C.CountryID','CU.CountryID')
			->leftJoin($this->generalDB.'tbl_states as S', 'S.StateID', 'CU.StateID')
			->leftJoin($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'CU.DistrictID')
			->leftJoin($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'CU.TalukID')
			->leftJoin($this->generalDB.'tbl_cities as CI', 'CI.CityID', 'CU.CityID')
			->leftJoin($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'CU.PostalCodeID')
			->leftJoin($this->generalDB.'tbl_countries as DC','DC.CountryID','Q.DCountryID')
			->leftJoin($this->generalDB.'tbl_states as DS', 'DS.StateID', 'Q.DStateID')
			->leftJoin($this->generalDB.'tbl_districts as DD', 'DD.DistrictID', 'Q.DDistrictID')
			->leftJoin($this->generalDB.'tbl_taluks as DT', 'DT.TalukID', 'Q.DTalukID')
			->leftJoin($this->generalDB.'tbl_cities as DCI', 'DCI.CityID', 'Q.DCityID')
			->leftJoin($this->generalDB.'tbl_postalcodes as DPC', 'DPC.PID', 'Q.DPostalCodeID')
			->where('Q.DFlag',0)->Where('Q.QID',$QID)
			->select('QID','QNo','QDate','Status','ReceiverName','ReceiverMobNo','QExpiryDate','CU.Email','DPostalCodeID','CU.PostalCodeID','CU.Address','C.CountryName','S.StateName','D.DistrictName','T.TalukName','CI.CityName','PC.PostalCode','DAddress','DC.CountryName as DCountryName','DS.StateName as DStateName','DD.DistrictName as DDistrictName','DT.TalukName as DTalukName','DCI.CityName as DCityName','DPC.PostalCode as DPostalCode')
			->first();
			$FormData['QData']=$QData;
			if($QData){
				$FormData['FinalQuoteData'] = DB::Table($this->currfyDB.'tbl_quotation_details as QD')->join($this->currfyDB.'tbl_quotation as Q','Q.QID','QD.QID')->join('tbl_vendors as V','V.VendorID','QD.VendorID')->join('tbl_products as P','P.ProductID','QD.ProductID')->join('tbl_uom as UOM','UOM.UID','P.UID')->where('Q.QID',$QID)->get();
				return view('app.transaction.quotation.quote-view', $FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('admin/transaction/quotation/');
        }else{
            return view('errors.403');
        }
    }


	public function Delete(Request $req,$EnqID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table($this->currfyDB.'tbl_enquiry')->where('EnqID',$EnqID)->get();
				$status=DB::table($this->currfyDB.'tbl_enquiry')->where('EnqID',$EnqID)->update(array("Status"=>"Cancelled","DeletedBy"=>$this->UserID,"CancelledBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {

			}
			if($status==true){
				DB::commit();
				$NewData=DB::table($this->currfyDB.'tbl_enquiry')->where('EnqID',$EnqID)->get();
				$logData=array("Description"=>"Quotation has been Cancelled ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::DELETE->value,"ReferID"=>$EnqID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Quotation Cancelled Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Quotation Cancelled Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}

	public function Restore(Request $req,$EnqID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table($this->currfyDB.'tbl_enquiry')->where('EnqID',$EnqID)->get();
				$status=DB::table($this->currfyDB.'tbl_enquiry')->where('EnqID',$EnqID)->update(array("Status"=>"New","UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {

			}
			if($status==true){
				DB::commit();
				$NewData=DB::table($this->currfyDB.'tbl_enquiry')->where('EnqID',$EnqID)->get();
				$logData=array("Description"=>"Quotation has been Restored ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::RESTORE->value,"ReferID"=>$EnqID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Quotation Restored Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Quotation Restore Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}

	public function TableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'QNo', 'dt' => '0' ),
				array( 'db' => 'QDate', 'dt' => '1','formatter' => function( $d, $row ) {return date($this->Settings['date-format'],strtotime($d));}),
				array( 'db' => 'ReceiverName', 'dt' => '2' ),
				array( 'db' => 'ReceiverMobNo', 'dt' => '3' ),
				array( 'db' => 'QExpiryDate', 'dt' => '4','formatter' => function( $d, $row ) {return date($this->Settings['date-format'],strtotime($d));}),
				array( 'db' => 'CustomerID', 'dt' => '5',
					'formatter' => function( $d, $row ) {
						return DB::table('tbl_customer')->where('CustomerID',$d)->value('Email');
					}
				),
				array( 'db' => 'Status','dt' => '6',
					'formatter' => function( $d, $row ) {
						$html = "";
						if($d=="New"){
							$html="<span class='badge badge-info m-1'>".$d."</span>";
						}elseif($d=="Rejected"){
							$html="<span class='badge badge-danger m-1'>".$d."</span>";
						}elseif($d=="Accepted"){
							$html="<span class='badge badge-success m-1'>".$d."</span>";
						}
						return $html;
					}
				),
				array(
						'db' => 'QID',
						'dt' => '7',
						'formatter' => function( $d, $row ) {
							$html='';
							if($this->general->isCrudAllow($this->CRUD,"view")==true){
								$html.='<button type="button" data-id="'.$d.'" class="btn btn-outline-info '.$this->general->UserInfo['Theme']['button-size'].'  mr-10 btnView">View Quotation</button>';
							}
							if($this->general->isCrudAllow($this->CRUD,"delete")==true){
								$html.='<button type="button" data-id="'.$d.'" class="btn btn-outline-danger '.$this->general->UserInfo['Theme']['button-size'].'  btnDelete" data-original-title="Delete">Cancel</button>';
							}
							return $html;
						}
				)
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']=$this->currfyDB . 'tbl_quotation';
			$data['PRIMARYKEY']='QID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']="DFlag = 0";
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}

	public function TrashTableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'EnqNo', 'dt' => '0' ),
				array( 'db' => 'EnqDate', 'dt' => '1','formatter' => function( $d, $row ) {return date($this->Settings['date-format'],strtotime($d));}),
				array( 'db' => 'ReceiverName', 'dt' => '2' ),
				array( 'db' => 'ReceiverMobNo', 'dt' => '3' ),
				array( 'db' => 'ExpectedDeliveryDate', 'dt' => '4','formatter' => function( $d, $row ) {return date($this->Settings['date-format'],strtotime($d));}),
				array( 'db' => 'CustomerID', 'dt' => '5',
					'formatter' => function( $d, $row ) {
						return DB::table('tbl_customer')->where('CustomerID',$d)->value('Email');
					}
				),
				array( 'db' => 'Status','dt' => '6',
					'formatter' => function( $d, $row ) {
						return "<span class='badge badge-danger m-1'>".$d."</span>";
					}
				),
				array(
						'db' => 'EnqID',
						'dt' => '7',
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
			$data['TABLE']=$this->currfyDB . 'tbl_enquiry';
			$data['PRIMARYKEY']='EnqID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" Status = 'Cancelled'";
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}

}
