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

class EnquiryController extends Controller{
	private $general;
	private $UserID;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $Settings;
    private $Menus;
	private $generalDB;
	private $logDB;

    public function __construct(){
		$this->ActiveMenuName=activeMenuNames::Enquiry->value;
		$this->PageTitle="Enquiry";
        $this->middleware('auth');    
		$this->middleware(function ($request, $next) {
			$this->UserID=auth()->user()->UserID;
			$this->general=new general($this->UserID,$this->ActiveMenuName);
			$this->Menus=$this->general->loadMenu();
			$this->CRUD=$this->general->getCrudOperations($this->ActiveMenuName);
			$this->Settings=$this->general->getSettings();
			$this->generalDB=Helper::getGeneralDB();
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
			$status = "CREATE TABLE IF NOT EXISTS {$this->logDB}`tbl_enquiry` (
				`EnqID` varchar(50) NOT NULL PRIMARY KEY,
				`EnqNo` varchar(50) DEFAULT NULL,
				`EnqDate` date DEFAULT NULL,
				`CustomerName` varchar(50) DEFAULT NULL,
				`MobileNo1` varchar(15) DEFAULT NULL,
				`MobileNo2` varchar(15) DEFAULT NULL,
				`Email` text DEFAULT NULL,
				`EnqExpiryDate` date DEFAULT NULL,
				`Remarks` text DEFAULT NULL,
				`Address` text DEFAULT NULL,
				`CountryID` varchar(50) DEFAULT NULL,
				`StateID` varchar(50) DEFAULT NULL,
				`DistrictID` varchar(50) DEFAULT NULL,
				`TalukID` varchar(50) DEFAULT NULL,
				`CityID` varchar(50) DEFAULT NULL,
				`PostalCodeID` varchar(50) DEFAULT NULL,
				`DAddress` varchar(50) DEFAULT NULL,
				`DCountryID` varchar(50) DEFAULT NULL,
				`DStateID` varchar(50) DEFAULT NULL,
				`DDistrictID` varchar(50) DEFAULT NULL,
				`DTalukID` varchar(50) DEFAULT NULL,
				`DCityID` varchar(50) DEFAULT NULL,
				`DPostalCodeID` varchar(50) DEFAULT NULL,
				`Status` enum('New','Converted to Quotation','Cancelled') NOT NULL DEFAULT 'New',
				`DFlag` int(1) DEFAULT 0,
				`CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
				`UpdatedOn` timestamp NULL DEFAULT NULL,
				`DeletedOn` timestamp NULL DEFAULT NULL,
				`CreatedBy` varchar(50) DEFAULT NULL,
				`UpdatedBy` varchar(50) DEFAULT NULL,
				`DeletedBy` varchar(50) DEFAULT NULL
			)";
			  DB::statement($status);
			$status = "CREATE TABLE IF NOT EXISTS {$this->logDB}`tbl_enquiry_details` (
				`DetailID` varchar(50) NOT NULL PRIMARY KEY,
				`EnqID` varchar(50) DEFAULT NULL,
				`CID` varchar(50) DEFAULT NULL,
				`SCID` varchar(50) DEFAULT NULL,
				`ProductID` varchar(50) DEFAULT NULL,
				`Description` text DEFAULT NULL,
				`Qty` double DEFAULT 0,
				`UOMID` varchar(50) DEFAULT NULL,
				`CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
				`CreatedBy` varchar(50) DEFAULT NULL,
				`UpdatedOn` timestamp NULL DEFAULT NULL,
				`UpdatedBy` varchar(50) DEFAULT NULL
			)";
			  DB::statement($status);
            return view('app.transaction.enquiry.view',$FormData);
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
            return view('app.transaction.enquiry.trash',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/transaction/enquiry/');
        }else{
            return view('errors.403');
        }
    }
    public function EnqView(Request $req,$EnqID){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=false;
			$EnqData=DB::Table($this->logDB.'tbl_enquiry as E')
			->join($this->generalDB.'tbl_countries as C','C.CountryID','E.CountryID')
			->join($this->generalDB.'tbl_states as S', 'S.StateID', 'E.StateID')
			->join($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'E.DistrictID')
			->join($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'E.TalukID')
			->join($this->generalDB.'tbl_cities as CI', 'CI.CityID', 'E.CityID')
			->join($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'E.PostalCodeID')
			->join($this->generalDB.'tbl_countries as DC','DC.CountryID','E.DCountryID')
			->join($this->generalDB.'tbl_states as DS', 'DS.StateID', 'E.DStateID')
			->join($this->generalDB.'tbl_districts as DD', 'DD.DistrictID', 'E.DDistrictID')
			->join($this->generalDB.'tbl_taluks as DT', 'DT.TalukID', 'E.DTalukID')
			->join($this->generalDB.'tbl_cities as DCI', 'DCI.CityID', 'E.DCityID')
			->join($this->generalDB.'tbl_postalcodes as DPC', 'DPC.PID', 'E.DPostalCodeID')
			->where('E.DFlag',0)->Where('E.EnqID',$EnqID)
			->select('EnqID','EnqNo','EnqDate','CustomerName','MobileNo1','Status','MobileNo2','Email','DDistrictID','Address','C.CountryName','S.StateName','D.DistrictName','T.TalukName','CI.CityName','PC.PostalCode','DAddress','DC.CountryName as DCountryName','DS.StateName as DStateName','DD.DistrictName as DDistrictName','DT.TalukName as DTalukName','DCI.CityName as DCityName','DPC.PostalCode as DPostalCode')
			->first();
			$FormData['EnqData']=$EnqData;
			// return $FormData['EnqData'];
			if($EnqData){
				$PData=DB::table($this->logDB.'tbl_enquiry_details as ED')->join('tbl_products as P','P.ProductID','ED.ProductID')->join('tbl_uom as UOM','UOM.UID','P.UID')->where('ED.EnqID',$EnqID)->get();
				if(count($PData) > 0){
				}
				$FormData['PData'] = $PData;
				return view('app.transaction.enquiry.enq-view',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/transaction/quotation/');
        }else{
            return view('errors.403');
        }
    }

	public function Convert(Request $req,$EnqID){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OldData=array();$NewData=array();
			try {
				$status = DB::statement("CREATE TABLE IF NOT EXISTS {$this->logDB}`tbl_quotation` (
					`QID` varchar(50) PRIMARY KEY NOT NULL,
					`EnqID` varchar(50) DEFAULT NULL,
					`QNo` varchar(50) DEFAULT NULL,
					`QDate` date DEFAULT NULL,
					`CustomerName` varchar(50) DEFAULT NULL,
					`MobileNo1` varchar(15) DEFAULT NULL,
					`MobileNo2` varchar(15) DEFAULT NULL,
					`Email` text DEFAULT NULL,
					`QExpiryDate` date DEFAULT NULL,
					`Remarks` text DEFAULT NULL,
					`Address` text DEFAULT NULL,
					`CountryID` varchar(50) DEFAULT NULL,
					`StateID` varchar(50) DEFAULT NULL,
					`DistrictID` varchar(50) DEFAULT NULL,
					`TalukID` varchar(50) DEFAULT NULL,
					`CityID` varchar(50) DEFAULT NULL,
					`PostalCodeID` varchar(50) DEFAULT NULL,
					`DAddress` varchar(50) DEFAULT NULL,
					`DCountryID` varchar(50) DEFAULT NULL,
					`DStateID` varchar(50) DEFAULT NULL,
					`DDistrictID` varchar(50) DEFAULT NULL,
					`DTalukID` varchar(50) DEFAULT NULL,
					`DCityID` varchar(50) DEFAULT NULL,
					`DPostalCodeID` varchar(50) DEFAULT NULL,
					`Status` enum('New','Quote Requested','Quote Received','Allocated','Cancelled') NOT NULL DEFAULT 'New',
					`VendorID` varchar(50) DEFAULT NULL,
					`AllocationDate` date DEFAULT NULL,
					`VendorIDs` text DEFAULT NULL,
					`TaxAmt` double DEFAULT 0,
					`SubTotal` double NOT NULL DEFAULT 0,
					`DiscountType` varchar(50) DEFAULT NULL,
					`DiscountPer` double NOT NULL DEFAULT 0,
					`DiscountAmount` double NOT NULL DEFAULT 0,
					`CGSTAmt` double NOT NULL DEFAULT 0,
					`SGSTAmt` double NOT NULL DEFAULT 0,
					`IGSTAmt` double NOT NULL DEFAULT 0,
					`TotalAmount` double NOT NULL DEFAULT 0,
					`DFlag` int(1) DEFAULT 0,
					`CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
					`UpdatedOn` timestamp NULL DEFAULT NULL,
					`DeletedOn` timestamp NULL DEFAULT NULL,
					`CreatedBy` varchar(50) DEFAULT NULL,
					`UpdatedBy` varchar(50) DEFAULT NULL,
					`DeletedBy` varchar(50) DEFAULT NULL
				)");

				$status = DB::statement("CREATE TABLE IF NOT EXISTS {$this->logDB}`tbl_quotation_details` (
					`DetailID` varchar(50) PRIMARY KEY NOT NULL,
					`QID` varchar(50) DEFAULT NULL,
					`CID` varchar(50) DEFAULT NULL,
					`SCID` varchar(50) DEFAULT NULL,
					`ProductID` varchar(50) DEFAULT NULL,
					`Description` text DEFAULT NULL,
					`Qty` double DEFAULT 0,
					`Price` double DEFAULT NULL,
					`UOMID` varchar(50) DEFAULT NULL,
					`TaxType` varchar(50) DEFAULT NULL,
					`TaxID` varchar(50) DEFAULT NULL,
					`TaxPer` double DEFAULT 0,
					`Taxable` double NOT NULL DEFAULT 0,
					`DiscountType` varchar(50) DEFAULT NULL,
					`DiscountPer` double NOT NULL DEFAULT 0,
					`DiscountAmount` double NOT NULL DEFAULT 0,
					`TaxAmount` double NOT NULL DEFAULT 0,
					`CGSTPer` double NOT NULL DEFAULT 0,
					`SGSTPer` double DEFAULT 0,
					`IGSTPer` double NOT NULL DEFAULT 0,
					`CGSTAmount` double NOT NULL DEFAULT 0,
					`SGSTAmount` double NOT NULL DEFAULT 0,
					`IGSTAmount` double NOT NULL DEFAULT 0,
					`Amount` double NOT NULL DEFAULT 0,
					`CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
					`CreatedBy` varchar(50) DEFAULT NULL,
					`UpdatedOn` timestamp NULL DEFAULT NULL,
					`UpdatedBy` varchar(50) DEFAULT NULL
				)");
				
				$EnqData = DB::table($this->logDB.'tbl_enquiry_details as ED')->join($this->logDB.'tbl_enquiry as E','E.EnqID','ED.EnqID')->where('ED.EnqID',$EnqID)->get();
				
				// return $EnqData;
				$isEnqIDExists = DB::table($this->logDB.'tbl_quotation')->where('EnqID',$EnqID)->exists();
				if(!$isEnqIDExists){
					$QID = DocNum::getDocNum(docTypes::Quotation->value);
					$data=[
						'QID' => $QID,
						'EnqID' => $EnqID,
						'QNo' =>"RPC/QTN/" . rand(100000, 999999),
						'QDate' => date('Y-m-d'),
						'QExpiryDate' => date('Y-m-d', strtotime('+15 days')),
						'CustomerName' => $EnqData[0]->CustomerName,
						'MobileNo1' => $EnqData[0]->MobileNo1,
						'MobileNo2' => $EnqData[0]->MobileNo2,
						'Email' => $EnqData[0]->Email,
						'Address' => $EnqData[0]->Address,
						'CountryID' => $EnqData[0]->CountryID,
						'StateID' => $EnqData[0]->StateID,
						'DistrictID' => $EnqData[0]->DistrictID,
						'TalukID' => $EnqData[0]->TalukID,
						'CityID' => $EnqData[0]->CityID,
						'PostalCodeID' => $EnqData[0]->PostalCodeID,
						'DAddress' => $EnqData[0]->DAddress,
						'DCountryID' => $EnqData[0]->DCountryID,
						'DStateID' => $EnqData[0]->DStateID,
						'DDistrictID' => $EnqData[0]->DDistrictID,
						'DTalukID' => $EnqData[0]->DTalukID,
						'DCityID' => $EnqData[0]->DCityID,
						'DPostalCodeID' => $EnqData[0]->DPostalCodeID,
						'CreatedOn' => date('Y-m-d'),
						'CreatedBy' => $this->UserID,
					];
					$status=DB::table($this->logDB.'tbl_quotation')->insert($data);
					if($status){
						foreach($EnqData as $item){
							$QuotationDetailID = DocNum::getDocNum(docTypes::QuotationDetails->value);
							$data1=[
								'DetailID' => $QuotationDetailID,
								'QID'=>$QID,
								'CID'=>$item->CID,
								'SCID'=>$item->SCID,
								'ProductID'=>$item->ProductID,
								'Qty'=>$item->Qty,
								'UOMID'=>$item->UOMID,
								'CreatedOn'=>date('Y-m-d'),
								'CreatedBy'=>$this->UserID,
							];
							$status = DB::table($this->logDB.'tbl_quotation_details')->insert($data1);
							if($status){
								DocNum::updateDocNum(docTypes::QuotationDetails->value);
							}
						}
						DocNum::updateDocNum(docTypes::Quotation->value);
					}
				}
				$status = DB::table($this->logDB.'tbl_enquiry')->where('EnqID',$EnqID)->update(['Status'=>'Converted to Quotation','UpdatedOn'=>date('Y-m-d'),'UpdatedBy'=>$this->UserID]);

			}catch(Exception $e) {
				$status=false;
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table($this->logDB.'tbl_quotation_details as QD')->join($this->logDB.'tbl_quotation as Q','QD.QID','Q.QID')->where('QD.QID',$QID)->get();
				$logData=array("Description"=>"Enquiry Converted to Quotation","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::ADD->value,"ReferID"=>$EnqID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Enquiry Converted to Quotation Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Enquiry Convert to Quotation Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denied');
		}
	}

	public function Delete(Request $req,$EnqID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table($this->logDB.'tbl_enquiry')->where('EnqID',$EnqID)->get();
				$status=DB::table($this->logDB.'tbl_enquiry')->where('EnqID',$EnqID)->update(array("Status"=>"Cancelled","DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Enquiry has been Cancelled ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::DELETE->value,"ReferID"=>$EnqID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Enquiry Cancelled Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Enquiry Cancelled Failed");
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
				$OldData=DB::table($this->logDB.'tbl_enquiry')->where('EnqID',$EnqID)->get();
				$status=DB::table($this->logDB.'tbl_enquiry')->where('EnqID',$EnqID)->update(array("Status"=>"New","UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table($this->logDB.'tbl_enquiry')->where('EnqID',$EnqID)->get();
				$logData=array("Description"=>"Enquiry has been Restored ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::RESTORE->value,"ReferID"=>$EnqID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Enquiry Restored Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Enquiry Restore Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}

	public function TableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'EnqNo', 'dt' => '0' ),
				array( 'db' => 'EnqDate', 'dt' => '1','formatter' => function( $d, $row ) {return date($this->Settings['DATE-FORMAT'],strtotime($d));}),
				array( 'db' => 'CustomerName', 'dt' => '2' ),
				array( 'db' => 'MobileNo1', 'dt' => '3' ),
				array( 'db' => 'MobileNo2', 'dt' => '4' ),
				array( 'db' => 'Email', 'dt' => '5' ),
				array( 'db' => 'Status','dt' => '6',
					'formatter' => function( $d, $row ) {
						$html = "";
						if($d=="New"){
							$html="<span class='badge badge-info m-1'>".$d."</span>";
						}elseif($d=="Converted to Quotation"){
							$html="<span class='badge badge-secondary m-1'>".$d."</span>";
						}
						return $html;
					} 
				),
				array( 
						'db' => 'EnqID', 
						'dt' => '7',
						'formatter' => function( $d, $row ) {
							$html='';
							/* if($this->general->isCrudAllow($this->CRUD,"edit")==true){
								$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].'  mr-10 btnEdit" data-original-title="Edit"><i class="fa fa-pencil"></i></button>';
							} */
							if($this->general->isCrudAllow($this->CRUD,"view")==true){
								$html.='<button type="button" data-id="'.$d.'" class="btn btn-outline-info '.$this->general->UserInfo['Theme']['button-size'].'  mr-10 btnView" data-original-title="View Quotation"><i class="fa fa-eye"></i></button>';
								if($row['Status'] == "New"){
									$html.='<button type="button" data-id="'.$d.'" class="btn btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].'  mr-10 btnConvert" data-original-title="Convert to Quote"><i class="fa fa-refresh"></i></button>';
								}
							}
							if($this->general->isCrudAllow($this->CRUD,"delete")==true && $row['Status'] == "New"){
								$html.='<button type="button" data-id="'.$d.'" class="btn btn-outline-danger '.$this->general->UserInfo['Theme']['button-size'].' btnDelete" data-original-title="Delete">Cancel</button>';
							}
							return $html;
						} 
				)
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']=$this->logDB.'tbl_enquiry';
			$data['PRIMARYKEY']='EnqID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" Status != 'Cancelled'";
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TrashTableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'EnqNo', 'dt' => '0' ),
				array( 'db' => 'EnqDate', 'dt' => '1','formatter' => function( $d, $row ) {return date($this->Settings['DATE-FORMAT'],strtotime($d));}),
				array( 'db' => 'CustomerName', 'dt' => '2' ),
				array( 'db' => 'MobileNo1', 'dt' => '3' ),
				array( 'db' => 'MobileNo2', 'dt' => '4' ),
				array( 'db' => 'Email', 'dt' => '5' ),
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
			$data['TABLE']=$this->logDB.'tbl_enquiry';
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
