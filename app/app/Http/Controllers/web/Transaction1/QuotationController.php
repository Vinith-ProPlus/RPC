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
			$this->logDB=Helper::getlogDB();
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
			return Redirect::to('/admin/transaction/quotation/create');
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
			return Redirect::to('/admin/transaction/quotation/');
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
			$FormData['QNo']=DocNum::getInvNo($this->PageTitle);
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
			$FormData['EditData']=DB::Table($this->logDB . 'tbl_quotation')->where('DFlag',0)->Where('QID',$QID)->get();
			if(count($FormData['EditData'])>0){
				return view('app.transaction.quotation.quote',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/transaction/quotation/');
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
			$QData=DB::Table($this->logDB . 'tbl_quotation as Q')
			->join($this->generalDB.'tbl_countries as C','C.CountryID','Q.CountryID')
			->join($this->generalDB.'tbl_states as S', 'S.StateID', 'Q.StateID')
			->join($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'Q.DistrictID')
			->join($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'Q.TalukID')
			->join($this->generalDB.'tbl_cities as CI', 'CI.CityID', 'Q.CityID')
			->join($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'Q.PostalCodeID')
			->join($this->generalDB.'tbl_countries as DC','DC.CountryID','Q.DCountryID')
			->join($this->generalDB.'tbl_states as DS', 'DS.StateID', 'Q.DStateID')
			->join($this->generalDB.'tbl_districts as DD', 'DD.DistrictID', 'Q.DDistrictID')
			->join($this->generalDB.'tbl_taluks as DT', 'DT.TalukID', 'Q.DTalukID')
			->join($this->generalDB.'tbl_cities as DCI', 'DCI.CityID', 'Q.DCityID')
			->join($this->generalDB.'tbl_postalcodes as DPC', 'DPC.PID', 'Q.DPostalCodeID')
			->where('Q.DFlag',0)->Where('Q.QID',$QID)
			->select('QID','QNo','QDate','VendorIDs','VendorID','Status','CustomerName','MobileNo1','MobileNo2','Email','DDistrictID','Address','C.CountryName','S.StateName','D.DistrictName','T.TalukName','CI.CityName','PC.PostalCode','DAddress','DC.CountryName as DCountryName','DS.StateName as DStateName','DD.DistrictName as DDistrictName','DT.TalukName as DTalukName','DCI.CityName as DCityName','DPC.PostalCode as DPostalCode')
			->first();
			$FormData['QData']=$QData;
			// return $FormData['QData'];
			if($QData){
				$VendorQuote = [];
				$AllocatedQData = [];
				$PData=DB::table($this->logDB . 'tbl_quotation_details as QD')->join('tbl_products as P','P.ProductID','QD.ProductID')->join('tbl_uom as UOM','UOM.UID','QD.UOMID')->where('QD.QID',$QID)
				// ->select('QD.ProductID')
				->get();
				// return $PData;
				if(count($PData) > 0){
					foreach($PData as $row){
						$AllVendors = DB::table('tbl_vendors as V')->join('tbl_vendors_service_locations as VSL','V.VendorID','VSL.VendorID')->where('V.DFlag',0)->where('VSL.DistrictID',$FormData['QData']->DDistrictID)->select('V.VendorID','V.VendorName')->get();
						if(count($AllVendors)>0){
							$row->AvailableVendors=[];
							foreach($AllVendors as $item){
								$VendorDB= Helper::getVendorDB($item->VendorID,$this->UserID);
								$TableName="tbl_vendors_product_mapping";
								if(Helper::checkTableExists($VendorDB,$TableName)){
									$isProductAvailable= DB::Table($VendorDB.'tbl_vendors_product_mapping')->where('Status',1)->Where('VendorID',$item->VendorID)->where('ProductID',$row->ProductID)->first();
									if($isProductAvailable){
										$row->AvailableVendors[] = [
											"VendorID" => $item->VendorID,
											"VendorName" => $item->VendorName,
											"ProductID" => $isProductAvailable->ProductID,
										];
									}
								}
							}
						}
					}
				}
				if($QData->Status == "Quote Requested" && $QData->VendorIDs && count(unserialize($QData->VendorIDs)) > 0){
					$VendorIDs = unserialize($FormData['QData']->VendorIDs);
					foreach($VendorIDs as $row){
						$VendorID = $row;
						$VendorDB = Helper::getVendorDB($VendorID, $this->UserID);
						Helper::addVendorDocNum($VendorDB, 'tbl_docnum', docTypes::QuoteSent->value, "QS", 8, 1);
							Helper::addVendorDocNum($VendorDB, 'tbl_docnum', docTypes::QuoteSentDetails->value, "QSD", 8, 1);
							$status = DB::statement("CREATE TABLE IF NOT EXISTS {$VendorDB}tbl_quotation_sent (QuoteSentID VARCHAR(50) PRIMARY KEY,QuoteReqID VARCHAR(50),QID VARCHAR(50) NULL,Date DATE,TotalAmount DOUBLE DEFAULT 0,SubTotal DOUBLE DEFAULT 0,TaxAmt DOUBLE DEFAULT 0,CGSTAmt DOUBLE DEFAULT 0,SGSTAmt DOUBLE DEFAULT 0,IGSTAmt DOUBLE DEFAULT 0,VendorID VARCHAR(50) NULL,Status INT(1) DEFAULT 0,CreatedBy VARCHAR(50) NULL,CreatedOn TIMESTAMP NULL)");
							$status = DB::statement("CREATE TABLE IF NOT EXISTS {$VendorDB}tbl_quotation_sent_details (
								`DetailID` varchar(50) PRIMARY KEY,
								`QuoteSentID` varchar(50) DEFAULT NULL,
								`CID` varchar(50) DEFAULT NULL,
								`SCID` varchar(50) DEFAULT NULL,
								`ProductID` varchar(50) DEFAULT NULL,
								`Description` text DEFAULT NULL,
								`Qty` double DEFAULT 0,
								`Price` double DEFAULT NULL,
								`UOMID` varchar(50) DEFAULT NULL,
								`TaxType` enum('Exclude','Include') DEFAULT 'Exclude',
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
							$ReqQData = DB::Table($VendorDB . 'tbl_quotation_request as QR')->join($VendorDB . 'tbl_quotation_request_details as QRD','QRD.QuoteReqID','QR.QuoteReqID')->Where('QR.QID',$QID)->get();
							if (count($ReqQData) > 0) {
								$isQIDExists = DB::table($VendorDB . 'tbl_quotation_sent')->where('QID',$QID)->exists();
								if(!$isQIDExists){
									$QuoteSentID = DocNum::getDocNum(docTypes::QuoteSent->value, $VendorDB);
									$totalTaxable = 0;
									$totalTaxAmount = 0;
									$totalCGST = 0;
									$totalSGST = 0;
									$totalIGST = 0;
									$totalQuoteValue = 0;
									$data = [
										"QuoteSentID" => $QuoteSentID,
										"QuoteReqID" => $ReqQData[0]->QuoteReqID,
										"QID" => $ReqQData[0]->QID,
										"VendorID" => $ReqQData[0]->VendorID,
										"Date" => date('Y-m-d'),
										"CreatedBy" => $this->UserID,
										"CreatedOn" => date("Y-m-d H:i:s"),
									];
									$status = DB::table($VendorDB . 'tbl_quotation_sent')->insert($data);
									if ($status) {
										foreach ($ReqQData as $item) {
											$ProductDetails = DB::table($VendorDB . 'tbl_vendors_product_mapping as VPM')->join('tbl_products as P', 'P.ProductID', 'VPM.ProductID')->join('tbl_tax as T', 'T.TaxID', 'P.TaxID')->where('VPM.ProductID', $item->ProductID)->where('VPM.Status', 1)
												->select('VPM.VendorPrice', 'P.TaxType', 'T.TaxPercentage','P.TaxID')->first();
											$Amt = $item->Qty * $ProductDetails->VendorPrice;
											if($ProductDetails->TaxType == 'Include'){
												$taxAmount =  $Amt * ($ProductDetails->TaxPercentage / 100);
												$taxableAmount = $Amt - $taxAmount;
											}else{
												$taxAmount =  $Amt * ($ProductDetails->TaxPercentage / 100);
												$taxableAmount = $Amt;
											}

											$cgstPercentage = $sgstPercentage = $ProductDetails->TaxPercentage / 2;

											$cgstAmount = $taxAmount / 2;
											$sgstAmount = $taxAmount / 2;

											$totalAmount = $taxableAmount + $taxAmount;

											$totalTaxable += $taxableAmount;
											$totalTaxAmount += $taxAmount;
											$totalCGST += $cgstAmount;
											$totalSGST += $sgstAmount;
											$totalQuoteValue += $totalAmount;
										
											$DetailID = DocNum::getDocNum(docTypes::QuoteSentDetails->value, $VendorDB);
											$data1 = [
												"DetailID" => $DetailID,
												"QuoteSentID" => $QuoteSentID,
												"ProductID" => $item->ProductID,
												"CID" => $item->CID,
												"SCID" => $item->SCID,
												"UOMID" => $item->UOMID,
												"TaxID" => $ProductDetails->TaxID,
												"TaxType" => $ProductDetails->TaxType,
												"Qty" => $item->Qty,
												"Price" => $ProductDetails->VendorPrice,
												"TaxAmount" => $taxAmount,
												"Taxable" => $taxableAmount,
												"CGSTPer" => $cgstPercentage,
												"SGSTPer" => $sgstPercentage,
												"CGSTAmount" => $cgstAmount,
												"SGSTAmount" => $sgstAmount,
												"Amount" => $totalAmount,
											];
										
											$status = DB::table($VendorDB . 'tbl_quotation_sent_details')->insert($data1);
										
											if ($status) {
												DocNum::updateDocNum(docTypes::QuoteSentDetails->value, $VendorDB);
											}
										}
										
										DB::table($VendorDB . 'tbl_quotation_sent')->where('QuoteSentID', $QuoteSentID)->update([
											'SubTotal' => $totalTaxable,
											'TaxAmt' => $totalTaxAmount,
											'CGSTAmt' => $totalCGST,
											'SGSTAmt' => $totalSGST,
											'IGSTAmt' => $totalIGST,
											'TotalAmount' => $totalQuoteValue,
										]);
										DocNum::updateDocNum(docTypes::QuoteSent->value, $VendorDB);
									}
								}
							}
						$isQuoteReceived = DB::Table($VendorDB . 'tbl_quotation_sent')->where('QID',$QID)->where('Status',0)->exists();
						if($isQuoteReceived){
							$Vendors = DB::Table($VendorDB . 'tbl_quotation_sent as QS')->join('tbl_vendors as V','V.VendorID','QS.VendorID')->where('QS.QID',$QID)->first();
							$Vendors->isQuoteReceived = 1;
							$Vendors->ItemCount = DB::table($VendorDB . 'tbl_quotation_sent_details')->where('QuoteSentID',$Vendors->QuoteSentID)->count();
						}else{
							$Vendors = DB::Table('tbl_vendors')->where('VendorID',$VendorID)->select('VendorName')->first();
							$Vendors->isQuoteReceived = 0;
							$Vendors->TotalAmount = 0;
							$Vendors->ItemCount ='';
						}
						$VendorQuote[]=$Vendors;
					}
				}elseif($QData->Status == "Allocated" && $QData->VendorID){
					$AllocatedQData = DB::Table($this->logDB . 'tbl_quotation_details as QD')->join($this->logDB . 'tbl_quotation as Q','Q.QID','QD.QID')->join('tbl_vendors as V','V.VendorID','Q.VendorID')->join('tbl_products as P','P.ProductID','QD.ProductID')->join('tbl_uom as UOM','UOM.UID','QD.UOMID')->where('QD.QID',$QID)->get();
					// return $AllocatedQData;
				}
				
				$FormData['PData'] = $PData;
				$FormData['VendorQuote'] = $VendorQuote;
				$FormData['AllocatedQData'] = $AllocatedQData;
				// return $FormData;
				return view('app.transaction.quotation.quote-view',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/transaction/quotation/');
        }else{
            return view('errors.403');
        }
    }

    public function RequestQuote(Request $req,$QID){	
		if($this->general->isCrudAllow($this->CRUD,"add")==true){
			$OldData=array();$NewData=array();
			DB::beginTransaction();
			$status=false;
			try {
				DB::beginTransaction();

				$SelectedVendors = json_decode($req->SelectedVendors, true);
				foreach ($SelectedVendors as $row) {
					$VendorID = $row;
					$VendorDB = Helper::getVendorDB($VendorID, $this->UserID);

					if (Helper::checkTableExists($VendorDB, 'tbl_docnum')) {
						Helper::addVendorDocNum($VendorDB, 'tbl_docnum', docTypes::QuoteRequest->value, "QR", 8, 1);
						Helper::addVendorDocNum($VendorDB, 'tbl_docnum', docTypes::QuoteRequestDetails->value, "QRD", 8, 1);

						$status = DB::statement("CREATE TABLE IF NOT EXISTS {$VendorDB}tbl_quotation_request (QuoteReqID VARCHAR(50) PRIMARY KEY,QID VARCHAR(50) NULL,Date DATE,VendorID VARCHAR(50) NULL,Status INT(1) DEFAULT 0,CreatedBy VARCHAR(50) NULL,CreatedOn TIMESTAMP NULL)");
						$status = DB::statement("CREATE TABLE IF NOT EXISTS {$VendorDB}tbl_quotation_request_details (DetailID VARCHAR(50) PRIMARY KEY,QuoteReqID VARCHAR(50) NULL,ProductID VARCHAR(50) NULL,CID VARCHAR(50) NULL,SCID VARCHAR(50) NULL,UOMID VARCHAR(50) NULL,Qty DOUBLE,CreatedBy VARCHAR(50) NULL,CreatedOn TIMESTAMP NULL)");

						$isQIDExists = DB::table($VendorDB . 'tbl_quotation_request')->where('QID',$QID)->exists();
						if(!$isQIDExists){
							$QuoteReqID = DocNum::getDocNum(docTypes::QuoteRequest->value, $VendorDB);
							$data = [
								"QuoteReqID" => $QuoteReqID,
								"QID" => $QID,
								"VendorID" => $VendorID,
								"Date" => date('Y-m-d'),
								"CreatedBy" => $this->UserID,
								"CreatedOn" => date("Y-m-d H:i:s"),
							];
							$status = DB::table($VendorDB . 'tbl_quotation_request')->insert($data);
							if ($status) {
								$ProductDetails = json_decode($req->ProductDetails, true);
								foreach ($ProductDetails as $item) {
									$isProductMapped = DB::table($VendorDB . 'tbl_vendors_product_mapping')->where('ProductID', $item['ProductID'])->where('VendorID', $VendorID)->where('Status',1)->exists();
									if($isProductMapped){
										$DetailID = DocNum::getDocNum(docTypes::QuoteRequestDetails->value, $VendorDB);
										$data1 = [
											"DetailID" => $DetailID,
											"QuoteReqID" => $QuoteReqID,
											"ProductID" => $item['ProductID'],
											"CID" => $item['PCID'],
											"SCID" => $item['PSCID'],
											"UOMID" => $item['UOMID'],
											"Qty" => $item['Qty'],
										];
										$status = DB::table($VendorDB . 'tbl_quotation_request_details')->insert($data1);
										if ($status) {
											DocNum::updateDocNum(docTypes::QuoteRequestDetails->value, $VendorDB);
										}
									}
								}
								DocNum::updateDocNum(docTypes::QuoteRequest->value, $VendorDB);
							}
						}
					}
				}
				$status = DB::table($this->logDB . 'tbl_quotation')->where('QID',$QID)->update(['Status'=>'Quote Requested','VendorIDs'=>serialize($SelectedVendors),"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")]);

			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				// DB::commit();
				$NewData=DB::table($this->logDB . 'tbl_quotation')->where('QID',$QID)->get();
				$logData=array("Description"=>"Quotation Request Sent","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::ADD->value,"ReferID"=>$QID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Quotation Request Sent Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Quotation Request Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denied');
		}
	}
    public function Allocate(Request $req,$QuoteSentID){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OldData=array();$NewData=array();
			try {
				$status = DB::statement("CREATE TABLE IF NOT EXISTS tbl_order (
					`OrderID` varchar(50) PRIMARY KEY,
					`OrderNo` varchar(50) DEFAULT NULL,
					`QuoteSentID` varchar(50) DEFAULT NULL,
					`QID` varchar(50) DEFAULT NULL,
					`CustomerName` varchar(50) DEFAULT NULL,
					`MobileNo1` varchar(50) DEFAULT NULL,
					`MobileNo2` varchar(50) DEFAULT NULL,
					`Email` varchar(50) DEFAULT NULL,
					`Address` text  DEFAULT NULL,
					`CountryID` varchar(50)  DEFAULT NULL,
					`StateID` varchar(50)  DEFAULT NULL,
					`DistrictID` varchar(50)  DEFAULT NULL,
					`TalukID` varchar(50)  DEFAULT NULL,
					`CityID` varchar(50)  DEFAULT NULL,
					`PostalCodeID` varchar(50)  DEFAULT NULL,
					`DAddress` varchar(50)  DEFAULT NULL,
					`DCountryID` varchar(50)  DEFAULT NULL,
					`DStateID` varchar(50)  DEFAULT NULL,
					`DDistrictID` varchar(50)  DEFAULT NULL,
					`DTalukID` varchar(50)  DEFAULT NULL,
					`DCityID` varchar(50)  DEFAULT NULL,
					`DPostalCodeID` varchar(50)  DEFAULT NULL,
					`Status` enum('New','Delivered','Cancelled')  NOT NULL DEFAULT 'New',
					`VendorID` varchar(50)  DEFAULT NULL,
					`OrderDate` DATE,
					`SubTotal` double NOT NULL DEFAULT 0,
					`DiscountType` varchar(50) DEFAULT NULL,
					`DiscountPer` double NOT NULL DEFAULT 0,
					`DiscountAmount` double NOT NULL DEFAULT 0,
					`TaxAmt` double NOT NULL DEFAULT 0,
					`CGSTAmt` double NOT NULL DEFAULT 0,
					`SGSTAmt` double NOT NULL DEFAULT 0,
					`IGSTAmt` double NOT NULL DEFAULT 0,
					`TotalAmount` double NOT NULL DEFAULT 0,
					`DFlag` int(1) DEFAULT 0,
					`CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
					`CreatedBy` varchar(50) DEFAULT NULL,
					`UpdatedOn` timestamp NULL DEFAULT NULL,
					`UpdatedBy` varchar(50) DEFAULT NULL,
					`DeletedOn` timestamp NULL DEFAULT NULL,
					`DeletedBy` varchar(50)  DEFAULT NULL
				)");
				$status = DB::statement("CREATE TABLE IF NOT EXISTS tbl_order_details (
					`DetailID` varchar(50) PRIMARY KEY,
					`OrderID` varchar(50) DEFAULT NULL,
					`CID` varchar(50) DEFAULT NULL,
					`SCID` varchar(50) DEFAULT NULL,
					`ProductID` varchar(50) DEFAULT NULL,
					`Description` text DEFAULT NULL,
					`Qty` double DEFAULT 0,
					`Price` double DEFAULT NULL,
					`UOMID` varchar(50) DEFAULT NULL,
					`TaxType` enum('Exclude','Include') DEFAULT 'Exclude',
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
				
				$status = DB::statement("CREATE TABLE IF NOT EXISTS {$this->logDB}tbl_order (
					`OrderID` varchar(50) PRIMARY KEY,
					`QID` varchar(50) DEFAULT NULL,
					`OrderNo` varchar(50) DEFAULT NULL,
					`OrderDate` date DEFAULT NULL,
					`CustomerID` varchar(50) DEFAULT NULL,
					`ReceiverName` varchar(150) DEFAULT NULL,
					`ReceiverMobNo` varchar(15) DEFAULT NULL,
					`DAddress` varchar(50) DEFAULT NULL,
					`DCountryID` varchar(50) DEFAULT NULL,
					`DStateID` varchar(50) DEFAULT NULL,
					`DDistrictID` varchar(50) DEFAULT NULL,
					`DTalukID` varchar(50) DEFAULT NULL,
					`DCityID` varchar(50) DEFAULT NULL,
					`DPostalCodeID` varchar(50) DEFAULT NULL,
					`Status` enum('New','Partially Delivered','Delivered','Cancelled') NOT NULL DEFAULT 'New',
					`TaxAmount` double DEFAULT 0,
					`SubTotal` double NOT NULL DEFAULT 0,
					`DiscountType` varchar(50) DEFAULT NULL,
					`DiscountPercent` double NOT NULL DEFAULT 0,
					`DiscountAmount` double NOT NULL DEFAULT 0,
					`CGSTAmount` double NOT NULL DEFAULT 0,
					`SGSTAmount` double NOT NULL DEFAULT 0,
					`IGSTAmount` double NOT NULL DEFAULT 0,
					`TotalAmount` double NOT NULL DEFAULT 0,
					`AdditionalCost` double NOT NULL DEFAULT 0,
					`AdditionalCostData` text DEFAULT NULL,
					`SelectedOn` date DEFAULT NULL,
					`RejectedOn` date DEFAULT NULL,
					`DFlag` int(1) DEFAULT 0,
					`CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
					`UpdatedOn` timestamp NULL DEFAULT NULL,
					`DeletedOn` timestamp NULL DEFAULT NULL,
					`CreatedBy` varchar(50) DEFAULT NULL,
					`UpdatedBy` varchar(50) DEFAULT NULL,
					`DeletedBy` varchar(50) DEFAULT NULL
				)");
				$status = DB::statement("CREATE TABLE IF NOT EXISTS {$this->logDB}tbl_order_details (
					`DetailID` varchar(50) PRIMARY KEY,
					`OrderID` varchar(50) DEFAULT NULL,
					`ProductID` varchar(50) DEFAULT NULL,
					`Description` text DEFAULT NULL,
					`Qty` double DEFAULT 0,
					`Price` double DEFAULT NULL,
					`TaxType` varchar(50) DEFAULT NULL,
					`TaxPer` double DEFAULT 0,
					`Taxable` double NOT NULL DEFAULT 0,
					`DiscountType` varchar(50) DEFAULT NULL,
					`DiscountPer` double NOT NULL DEFAULT 0,
					`DiscountAmt` double NOT NULL DEFAULT 0,
					`TaxAmt` double NOT NULL DEFAULT 0,
					`CGSTPer` double NOT NULL DEFAULT 0,
					`SGSTPer` double DEFAULT 0,
					`IGSTPer` double NOT NULL DEFAULT 0,
					`CGSTAmt` double NOT NULL DEFAULT 0,
					`SGSTAmt` double NOT NULL DEFAULT 0,
					`IGSTAmt` double NOT NULL DEFAULT 0,
					`TotalAmt` double NOT NULL DEFAULT 0,
					`VendorID` varchar(50) DEFAULT NULL,
					`CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
					`CreatedBy` varchar(50) DEFAULT NULL,
					`UpdatedOn` timestamp NULL DEFAULT NULL,
					`UpdatedBy` varchar(50) DEFAULT NULL
				)");
				$VendorDB = Helper::getVendorDB($req->VendorID, $this->UserID);
				$status = DB::table($VendorDB . 'tbl_quotation_sent')->where('QuoteSentID',$QuoteSentID)->update(['Status'=>1]);

				$SelectedQuoteData = DB::table($VendorDB . 'tbl_quotation_sent_details as QSD')->join($VendorDB . 'tbl_quotation_sent as QS','QS.QuoteSentID','QSD.QuoteSentID')->where('QSD.QuoteSentID',$QuoteSentID)->get();

				$status = DB::table($this->logDB . 'tbl_quotation')->where('QID',$SelectedQuoteData[0]->QID)->update([
					'VendorID'=>$req->VendorID,
					'AllocationDate'=>date('Y-m-d'),
					'SubTotal'=>$SelectedQuoteData[0]->SubTotal,
					'TaxAmt'=>$SelectedQuoteData[0]->TaxAmt,
					'CGSTAmt'=>$SelectedQuoteData[0]->CGSTAmt,
					'SGSTAmt'=>$SelectedQuoteData[0]->SGSTAmt,
					'IGSTAmt'=>$SelectedQuoteData[0]->IGSTAmt,
					'TotalAmount'=>$SelectedQuoteData[0]->TotalAmount,
				]);
				if($status){
					foreach($SelectedQuoteData as $row){
						DB::table($this->logDB . 'tbl_quotation_details')->where('QID',$SelectedQuoteData[0]->QID)->where('ProductID',$row->ProductID)->update([
							'Price'=>$row->Price,
							'Taxable'=>$row->Taxable,
							'TaxAmount'=>$row->TaxAmount,
							'TaxPer'=>$row->TaxPer,
							'TaxID'=>$row->TaxID,
							'TaxType'=>$row->TaxType,
							'CGSTPer'=>$row->CGSTPer,
							'SGSTPer'=>$row->SGSTPer,
							'IGSTPer'=>$row->IGSTPer,
							'CGSTAmount'=>$row->CGSTAmount,
							'SGSTAmount'=>$row->SGSTAmount,
							'IGSTAmount'=>$row->IGSTAmount,
							'Amount'=>$row->Amount,
						]);
					}
				}
				$QID = $SelectedQuoteData[0]->QID;
				$FinalQuoteData = DB::table($this->logDB . 'tbl_quotation_details as QD')->join($this->logDB . 'tbl_quotation as Q','Q.QID','QD.QID')->where('QD.QID',$QID)->where('QD.QID',$QID)->get();
				// return $FinalQuoteData;
				$isQIDExists = DB::table('tbl_order')->where('QID',$QID)->exists();
				if(!$isQIDExists){
					$OrderID = DocNum::getDocNum(docTypes::Order->value);
					$data=[
						'OrderID' => $OrderID,
						'OrderNo' =>"RPC - " . rand(100000, 999999),
						'QuoteSentID' => $QuoteSentID,
						'QID' => $QID,
						'CustomerName' => $FinalQuoteData[0]->CustomerName,
						'MobileNo1' => $FinalQuoteData[0]->MobileNo1,
						'MobileNo2' => $FinalQuoteData[0]->MobileNo2,
						'Email' => $FinalQuoteData[0]->Email,
						'Address' => $FinalQuoteData[0]->Address,
						'CountryID' => $FinalQuoteData[0]->CountryID,
						'StateID' => $FinalQuoteData[0]->StateID,
						'DistrictID' => $FinalQuoteData[0]->DistrictID,
						'TalukID' => $FinalQuoteData[0]->TalukID,
						'CityID' => $FinalQuoteData[0]->CityID,
						'PostalCodeID' => $FinalQuoteData[0]->PostalCodeID,
						'DAddress' => $FinalQuoteData[0]->DAddress,
						'DCountryID' => $FinalQuoteData[0]->DCountryID,
						'DStateID' => $FinalQuoteData[0]->DStateID,
						'DDistrictID' => $FinalQuoteData[0]->DDistrictID,
						'DTalukID' => $FinalQuoteData[0]->DTalukID,
						'DCityID' => $FinalQuoteData[0]->DCityID,
						'DPostalCodeID' => $FinalQuoteData[0]->DPostalCodeID,
						'VendorID' => $FinalQuoteData[0]->VendorID,
						'OrderDate' => date('Y-m-d'),
						'SubTotal' => $FinalQuoteData[0]->SubTotal,
						'DiscountType' => $FinalQuoteData[0]->DiscountType,
						'DiscountPer' => $FinalQuoteData[0]->DiscountPer,
						'DiscountAmount' => $FinalQuoteData[0]->DiscountAmount,
						'TaxAmt' => $FinalQuoteData[0]->TaxAmt,
						'CGSTAmt' => $FinalQuoteData[0]->CGSTAmt,
						'SGSTAmt' => $FinalQuoteData[0]->SGSTAmt,
						'IGSTAmt' => $FinalQuoteData[0]->IGSTAmt,
						'TotalAmount' => $FinalQuoteData[0]->TotalAmount,
						'CreatedOn' => date('Y-m-d'),
						'CreatedBy' => $this->UserID,
					];
					$status=DB::table('tbl_order')->insert($data);
					if($status){
						foreach($FinalQuoteData as $item){
							$OrderDetailID = DocNum::getDocNum(docTypes::OrderDetails->value);
							$data1=[
								'DetailID' => $OrderDetailID,
								'OrderID'=>$OrderID,
								'CID'=>$item->CID,
								'SCID'=>$item->SCID,
								'ProductID'=>$item->ProductID,
								'Qty'=>$item->Qty,
								'Price'=>$item->Price,
								'UOMID'=>$item->UOMID,
								'TaxType'=>$item->TaxType,
								'TaxID'=>$item->TaxID,
								'TaxPer'=>$item->TaxPer,
								'Taxable'=>$item->Taxable,
								'DiscountType'=>$item->DiscountType,
								'DiscountAmount'=>$item->DiscountAmount,
								'TaxAmount'=>$item->TaxAmount,
								'CGSTPer'=>$item->CGSTPer,
								'SGSTPer'=>$item->SGSTPer,
								'IGSTPer'=>$item->IGSTPer,
								'CGSTAmount'=>$item->CGSTAmount,
								'SGSTAmount'=>$item->SGSTAmount,
								'IGSTAmount'=>$item->IGSTAmount,
								'Amount'=>$item->Amount,
								'CreatedOn'=>date('Y-m-d'),
								'CreatedBy'=>$this->UserID,
							];
							$status = DB::table('tbl_order_details')->insert($data1);
							if($status){
								DocNum::updateDocNum(docTypes::OrderDetails->value);
							}
						}
						DocNum::updateDocNum(docTypes::Order->value);
					}
				}	
				DB::table($this->logDB . 'tbl_quotation')->where('QID',$QID)->update(['Status'=>'Allocated']);

			}catch(Exception $e) {
				$status=false;
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table($this->logDB . 'tbl_quotation')->get();
				$logData=array("Description"=>"Quotation Allocated","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE->value,"ReferID"=>$QID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Quotation Allocated Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Quotation Allocate Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denied');
		}
	}
	
	public function Delete(Request $req,$QID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table($this->logDB . 'tbl_quotation')->where('QID',$QID)->get();
				$status=DB::table($this->logDB . 'tbl_quotation')->where('QID',$QID)->update(array("Status"=>"Cancelled","DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Quotation has been Cancelled ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::DELETE->value,"ReferID"=>$QID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
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
	public function Restore(Request $req,$QID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table($this->logDB . 'tbl_quotation')->where('QID',$QID)->get();
				$status=DB::table($this->logDB . 'tbl_quotation')->where('QID',$QID)->update(array("Status"=>"New","UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table($this->logDB . 'tbl_quotation')->where('QID',$QID)->get();
				$logData=array("Description"=>"Quotation has been Restored ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::RESTORE->value,"ReferID"=>$QID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
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
				array( 'db' => 'CustomerName', 'dt' => '2' ),
				array( 'db' => 'MobileNo1', 'dt' => '3' ),
				array( 'db' => 'MobileNo2', 'dt' => '4' ),
				array( 'db' => 'Email', 'dt' => '5' ),
				array( 'db' => 'Status','dt' => '6',
					'formatter' => function( $d, $row ) {
						$html = "";
						if($d=="New"){
							$html="<span class='badge badge-info m-1'>".$d."</span>";
						}elseif($d=="Allocated"){
							$html="<span class='badge badge-secondary m-1'>".$d."</span>";
						}elseif($d=="Quote Requested"){
							$html="<span class='badge badge-success m-1'>".$d."</span>";
						}
						return $html;
					} 
				),
				array( 'db' => 'VendorID','dt' => '7',
					'formatter' => function( $d, $row ) {
						if($d){
							return DB::table('tbl_vendors')->where('VendorID',$d)->value('VendorName');
						}else{
							return "--";
						}
					}
				),
				array( 
						'db' => 'QID', 
						'dt' => '8',
						'formatter' => function( $d, $row ) {
							$html='';
							/* if($this->general->isCrudAllow($this->CRUD,"edit")==true){
								$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].'  mr-10 btnEdit" data-original-title="Edit"><i class="fa fa-pencil"></i></button>';
							} */
							if($this->general->isCrudAllow($this->CRUD,"view")==true){
								// $html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-info '.$this->general->UserInfo['Theme']['button-size'].'  mr-10 btnView" data-original-title="View Quotation"><i class="fa fa-eye"></i></button>';
								$html.='<button type="button" data-id="'.$d.'" class="btn btn-outline-info '.$this->general->UserInfo['Theme']['button-size'].'  mr-10 btnView">View Quotation</button>';
							}
							if($this->general->isCrudAllow($this->CRUD,"delete")==true && $row['Status'] !== "Allocated"){
								$html.='<button type="button" data-id="'.$d.'" class="btn btn-outline-danger '.$this->general->UserInfo['Theme']['button-size'].'  btnDelete" data-original-title="Delete">Cancel</button>';
							}
							return $html;
						} 
				)
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']=$this->logDB . 'tbl_quotation';
			$data['PRIMARYKEY']='QID';
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
				array( 'db' => 'QNo', 'dt' => '0' ),
				array( 'db' => 'QDate', 'dt' => '1','formatter' => function( $d, $row ) {return date($this->Settings['date-format'],strtotime($d));}),
				array( 'db' => 'CustomerName', 'dt' => '2' ),
				array( 'db' => 'MobileNo1', 'dt' => '3' ),
				array( 'db' => 'MobileNo2', 'dt' => '4' ),
				array( 'db' => 'Email', 'dt' => '5' ),
				array( 'db' => 'Status','dt' => '6',
					'formatter' => function( $d, $row ) {
						return "<span class='badge badge-danger m-1'>".$d."</span>";
					} 
				),
				array( 'db' => 'VendorID','dt' => '7',
					'formatter' => function( $d, $row ) {
						if($d){
							return DB::table('tbl_vendors')->where('VendorID',$d)->value('VendorName');
						}else{
							return "--";
						}
					}
				),
				array( 
						'db' => 'QID', 
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
			$data['TABLE']=$this->logDB . 'tbl_quotation';
			$data['PRIMARYKEY']='QID';
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

	public function GetVendorQuoteDetails(request $req){
		$VendorDB = Helper::getVendorDB($req->VendorID, $this->UserID);
		return DB::Table($VendorDB . 'tbl_quotation_sent_details as QSD')->join('tbl_products as P','P.ProductID','QSD.ProductID')->join('tbl_uom as UOM','UOM.UID','QSD.UOMID')->where('QSD.QuoteSentID',$req->QuoteSentID)
		->select('QSD.Amount','QSD.Price','QSD.TaxAmount','QSD.Taxable','QSD.TaxType','QSD.CGSTPer','QSD.SGSTPer','QSD.CGSTAmount','QSD.SGSTAmount','QSD.Qty','P.ProductName','UOM.UCode','UOM.UName')->get();
	}

	public function GetVendorRatings(request $req){
		return DB::Table('tbl_vendor_ratings as VR')->join('tbl_vendors as V','V.VendorID','VR.VendorID')
				->join($this->generalDB.'tbl_states as S','S.StateID','V.StateID')
				->join($this->generalDB.'tbl_districts as D','D.DistrictID','V.DistrictID')
				->join($this->generalDB.'tbl_taluks as T','T.TalukID','V.TalukID')
				->join($this->generalDB.'tbl_cities as C','C.CityID','V.CityID')
				->join($this->generalDB.'tbl_postalcodes as P','P.PID','V.PostalCode')
				->where('VR.VendorID',$req->VendorID)->first();
	}

}
