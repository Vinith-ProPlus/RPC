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

class QuoteEnquiryController extends Controller{
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
		$this->ActiveMenuName=activeMenuNames::QuoteEnquiry->value;
		$this->PageTitle="Quote Enquiry";
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
            return view('app.transaction.quote-enquiry.view',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"add")==true){
			return Redirect::to('admin/transaction/quote-enquiry/create');
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
            return view('app.transaction.quote-enquiry.trash',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('admin/transaction/quote-enquiry/');
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
			$FormData['Customers'] = DB::Table('tbl_customer')
			->where('DFlag', 0)->where('ActiveStatus', 'Active')
			->get();
            return view('app.transaction.quote-enquiry.quote',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/transaction/quote-enquiry/');
        }else{
            return view('errors.403');
        }
    }
    public function ImageQuoteCreate(Request $req){
        if($this->general->isCrudAllow($this->CRUD,"add")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=false;
			$FormData['QNo']=DocNum::getInvNo($this->ActiveMenuName);
            return view('app.transaction.quote-enquiry.image-quote',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/transaction/quote-enquiry/');
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
				return view('app.transaction.quote-enquiry.quote',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('admin/transaction/quote-enquiry/');
        }else{
            return view('errors.403');
        }
    }
    public function QuoteView(Request $req,$EnqID){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=false;
			$FormData['Settings']=$this->Settings;
			$EnqData=DB::Table($this->currfyDB.'tbl_enquiry as E')
			->leftJoin('tbl_customer as CU', 'CU.CustomerID', 'E.CustomerID')
			->leftJoin($this->generalDB.'tbl_countries as C','C.CountryID','CU.CountryID')
			->leftJoin($this->generalDB.'tbl_states as S', 'S.StateID', 'CU.StateID')
			->leftJoin($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'CU.DistrictID')
			->leftJoin($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'CU.TalukID')
			->leftJoin($this->generalDB.'tbl_cities as CI', 'CI.CityID', 'CU.CityID')
			->leftJoin($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'CU.PostalCodeID')
			->leftJoin($this->generalDB.'tbl_countries as DC','DC.CountryID','E.DCountryID')
			->leftJoin($this->generalDB.'tbl_states as DS', 'DS.StateID', 'E.DStateID')
			->leftJoin($this->generalDB.'tbl_districts as DD', 'DD.DistrictID', 'E.DDistrictID')
			->leftJoin($this->generalDB.'tbl_taluks as DT', 'DT.TalukID', 'E.DTalukID')
			->leftJoin($this->generalDB.'tbl_cities as DCI', 'DCI.CityID', 'E.DCityID')
			->leftJoin($this->generalDB.'tbl_postalcodes as DPC', 'DPC.PID', 'E.DPostalCodeID')
			->whereNot('E.Status','Cancelled')->Where('E.EnqID',$EnqID)
			->select('EnqID','EnqNo','EnqDate','VendorIDs','Status','ReceiverName','ReceiverMobNo','ExpectedDeliveryDate','CU.Email','DPostalCodeID','E.PostalCodeID','E.Address','C.CountryName','S.StateName','D.DistrictName','T.TalukName','CI.CityName','PC.PostalCode','DAddress','DC.CountryName as DCountryName','DS.StateName as DStateName','DD.DistrictName as DDistrictName','DT.TalukName as DTalukName','DCI.CityName as DCityName','DPC.PostalCode as DPostalCode')
			->first();
			$FormData['EnqData']=$EnqData;
			if($EnqData){
				$VendorQuote = [];
				$FinalQuoteData = [];
				$PData=DB::table($this->currfyDB.'tbl_enquiry_details as ED')->leftJoin('tbl_products as P','P.ProductID','ED.ProductID')->leftJoin('tbl_uom as UOM','UOM.UID','ED.UOMID')->where('ED.EnqID',$EnqID)->select('ED.ProductID','ED.CID','ED.SCID','ED.Qty','P.ProductName','UOM.UID','UOM.UName','UOM.UCode')->get();
				if(count($PData) > 0){
					foreach($PData as $row){
						$row->AvailableVendors=[];
						$AllVendors = DB::table('tbl_vendors as V')->join('tbl_vendors_service_locations as VSL','V.VendorID','VSL.VendorID')->leftJoin('tbl_vendor_ratings as VR','VR.VendorID','V.VendorID')->where('V.ActiveStatus',"Active")->where('V.isApproved',1)->where('V.DFlag',0)->where('VSL.PostalCodeID',$FormData['EnqData']->DPostalCodeID)->select('V.VendorID','V.VendorName','VR.OverAll')->get();
						if(count($AllVendors)>0){
							foreach($AllVendors as $item){
								$isProductAvailable= DB::Table('tbl_vendors_product_mapping')->where('Status',1)->Where('VendorID',$item->VendorID)->where('ProductID',$row->ProductID)->first();
									if($isProductAvailable){
										$row->AvailableVendors[] = [
											"VendorID" => $item->VendorID,
											"VendorName" => $item->VendorName,
											"OverAll" => $item->OverAll,
											"ProductID" => $isProductAvailable->ProductID,
										];
									}
							}
						}
					}
				}
				if($EnqData->Status == "Quote Requested" && $EnqData->VendorIDs && count(unserialize($EnqData->VendorIDs)) > 0){
					$VendorQuote = DB::Table($this->currfyDB.'tbl_vendor_quotation as VQ')->join('tbl_vendors as V','V.VendorID','VQ.VendorID')/* ->where('VQ.Status','Sent') */->where('VQ.EnqID',$EnqID)->select('VQ.VendorID','V.VendorName','VQ.VQuoteID','VQ.Status','VQ.AdditionalCost')->get();
					foreach($VendorQuote as $row){
						$row->ProductData = DB::table($this->currfyDB.'tbl_vendor_quotation_details as VQD')->where('VQuoteID',$row->VQuoteID)
						->select('DetailID','ProductID','Price','VQuoteID')
						->get();
					}
				}elseif($EnqData->Status == "Converted to Quotation"){
					$FinalQuoteData = DB::Table($this->currfyDB.'tbl_quotation_details as QD')->join($this->currfyDB.'tbl_quotation as Q','Q.QID','QD.QID')->join('tbl_vendors as V','V.VendorID','QD.VendorID')->join('tbl_products as P','P.ProductID','QD.ProductID')->join('tbl_uom as UOM','UOM.UID','P.UID')->where('Q.EnqID',$EnqID)->get();
				}

				$FormData['PData'] = $PData;
				$FormData['VendorQuote'] = $VendorQuote;
				$FormData['FinalQuoteData'] = $FinalQuoteData;
				// return $FormData['VendorQuote'];
				return view('app.transaction.quote-enquiry.quote-view', $FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('admin/transaction/quote-enquiry/');
        }else{
            return view('errors.403');
        }
    }

    public function RequestQuote(Request $req,$EnqID){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OldData=$NewData=[];
			DB::beginTransaction();
			$status=false;
			try {
				$SelectedVendors = json_decode($req->SelectedVendors, true);
				foreach ($SelectedVendors as $VendorID) {
					$isQuoteRequested =  DB::table($this->currfyDB . 'tbl_vendor_quotation')->where('VendorID',$VendorID)->where('EnqID',$EnqID)->first();
					if(!$isQuoteRequested){
						$VQuoteID = DocNum::getDocNum(docTypes::VendorQuotation->value, $this->currfyDB,Helper::getCurrentFy());
						$data = [
							"VQuoteID" => $VQuoteID,
							"VendorID" => $VendorID,
							"EnqID" => $EnqID,
							"QReqOn" => date('Y-m-d'),
							"QReqBy" => $this->UserID,
							"CreatedBy" => $this->UserID,
							"CreatedOn" => date("Y-m-d H:i:s"),
						];
						$status = DB::table($this->currfyDB . 'tbl_vendor_quotation')->insert($data);
						if ($status) {
							$ProductDetails = json_decode($req->ProductDetails);
							foreach ($ProductDetails as $item) {
								$isProductMapped = DB::table('tbl_vendors_product_mapping')->where('ProductID', $item->ProductID)->where('VendorID', $VendorID)->where('Status', 1)->exists();
								if ($isProductMapped) {
									$DetailID = DocNum::getDocNum(docTypes::VendorQuotationDetails->value, $this->currfyDB, Helper::getCurrentFy());
									$data1 = [
										"DetailID" => $DetailID,
										"VQuoteID" => $VQuoteID,
										"ProductID" => $item->ProductID,
										"Qty" => $item->Qty,
									];

									$status = DB::table($this->currfyDB . 'tbl_vendor_quotation_details')->insert($data1);
									if ($status) {
										DocNum::updateDocNum(docTypes::VendorQuotationDetails->value, $this->currfyDB);
									}
								}
							}
							DocNum::updateDocNum(docTypes::VendorQuotation->value, $this->currfyDB);
						}
					}
				}
				$status = DB::table($this->currfyDB.'tbl_enquiry')->where('EnqID',$EnqID)->update(['Status'=>'Quote Requested','VendorIDs'=>serialize($SelectedVendors),"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")]);
			}catch(Exception $e) {
				$status=false;
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table($this->currfyDB.'tbl_vendor_quotation as VQ')->join($this->currfyDB.'tbl_vendor_quotation_details as VQD','VQD.VQuoteID','VQ.VQuoteID')->where('VQ.EnqID',$EnqID)->get();
				$logData=array("Description"=>"Quotation Request Sent","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::ADD->value,"ReferID"=>$EnqID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Quotation Request Sent Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Quotation Request Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}

	public function AddQuotePrice(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			DB::beginTransaction();
			try {
				$OldData=$NewData=[];
				$ProductData = json_decode($req->ProductData);
				// return $ProductData;
				$data=[
					'SubTotal'=>$req->SubTotal ?? 0,
					'TaxAmount'=>$req->TaxAmount ?? 0,
					'TotalAmount'=>$req->TotalAmount ?? 0,
					'LabourCost'=>$req->LabourCost ?? 0,
					'TransportCost'=>$req->TransportCost ?? 0,
					'AdditionalCost'=>$req->TransportCost + $req->LabourCost ?? 0,
					'Status' => 'Sent',
					'QSentOn'=>date('Y-m-d'),
					'UpdatedBy'=>$this->UserID,
					'UpdatedOn'=>date('Y-m-d H:i:s')
				];
				$status = DB::Table($this->currfyDB.'tbl_vendor_quotation')->where('VendorID',$req->VendorID)->where('VQuoteID',$req->VQuoteID)->update($data);
				if($status){
					foreach($ProductData as $item){
						$PDetails= DB::table('tbl_products as P')->leftJoin('tbl_tax as T', 'T.TaxID', 'P.TaxID')->where('ProductID',$item->ProductID)->first();
						$data=[
							'Taxable'=>$item->Taxable ?? 0,
							'TaxAmt'=>$item->TaxAmt ?? 0,
							'TaxID'=>$PDetails->TaxID ?? 0,
							'TaxPer'=>$PDetails->TaxPercentage ?? 0,
							'TaxType'=>$PDetails->TaxType ?? 0,
							'TotalAmt'=>$item->TotalAmt ?? 0,
							'Price'=>$item->Price ?? 0,
							'Status'=>'Price Sent',
							'UpdatedOn'=>date('Y-m-d H:i:s')
						];
						$status = DB::Table($this->currfyDB.'tbl_vendor_quotation_details')->where('VQuoteID',$req->VQuoteID)->where('ProductID',$item->ProductID)->update($data);
					}
				}
			}catch(Exception $e) {
				$status=false;
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table($this->currfyDB.'tbl_vendor_quotation_details')->where('VQuoteID',$req->VQuoteID)->get();
				$logData=array("Description"=>"Vendor Quote Price Updated","ModuleName"=>"Quote Enquiry","Action"=>"Add","ReferID"=>$req->VQuoteID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return response()->json(['status' => true ,'message' => "Quote Price Updated Successfully!"]);
			}else{
				DB::rollback();
				return response()->json(['status' => false,'message' => "Quote Price Update Failed!"]);
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
		
	}

	public function RejectQuote(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			DB::beginTransaction();
			try {
				$status = DB::Table($this->currfyDB.'tbl_vendor_quotation')->where('VendorID',$req->VendorID)->where('VQuoteID',$req->VQuoteID)->update(['Status'=>'Rejected','UpdatedOn'=>date('Y-m-d H:i:s')]);
			}catch(Exception $e) {
				$status=false;
			}
			if($status==true){
				DB::commit();
				return response()->json(['status' => true ,'message' => "Quote Rejected Successfully!"]);
			}else{
				DB::rollback();
				return response()->json(['status' => false,'message' => "Quote Reject Failed!"]);
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}

	public function DeleteQuoteItem(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			DB::beginTransaction();
			try {
				$status = DB::Table($this->currfyDB.'tbl_quotation_details')->where('DetailID',$req->DetailID)->update(['isCancelled'=>1,'CancelledBy'=>$this->UserID,'CancelledOn'=>date('Y-m-d'),'UpdatedOn'=>date('Y-m-d H:i:s')]);
				if($status){
					$QData = DB::table($this->currfyDB.'tbl_quotation_details as QD')->leftJoin($this->currfyDB.'tbl_quotation as Q','Q.QID','QD.QID')->where('QD.QID',$req->QID)->where('QD.isCancelled',0)->get();
						$totalTaxable = 0;
						$totalTaxAmount = 0;
						$totalCGST = 0;
						$totalSGST = 0;
						$totalIGST = 0;
						$totalQuoteValue = 0;
						foreach ($QData as $item) {
							$totalTaxable += $item->Taxable;
							$totalTaxAmount += $item->TaxAmt;
							$totalCGST += $item->CGSTAmt;
							$totalSGST += $item->SGSTAmt;
							$totalIGST += $item->IGSTAmt;
							$totalQuoteValue += $item->TotalAmt;
						}
						$data=[
							'SubTotal' => $totalTaxable,
							'TaxAmount' => $totalTaxAmount,
							'CGSTAmount' => $totalCGST,
							'SGSTAmount' => $totalSGST,
							'IGSTAmount' => $totalIGST,
							'TotalAmount' => $totalQuoteValue,
							'OverAllAmount' => $totalQuoteValue + $QData[0]->AdditionalCost,
							'UpdatedOn' => date('Y-m-d H:i:s'),
							'UpdatedBy' => $this->UserID,
						];
						$status=DB::table($this->currfyDB.'tbl_quotation')->where('QID',$req->QID)->update($data);
				}
			}catch(Exception $e) {
				$status=false;
			}
			if($status==true){
				DB::commit();
				return response()->json(['status' => true ,'message' => "Quote Item Rejected Successfully!"]);
			}else{
				DB::rollback();
				return response()->json(['status' => false,'message' => "Quote Item Reject Failed!"]);
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}

    public function QuoteConvert(Request $req,$EnqID){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OldData=array();$NewData=array();
			DB::beginTransaction();
			try {
				$EnqData = DB::table($this->currfyDB.'tbl_enquiry_details as ED')->join($this->currfyDB.'tbl_enquiry as E','E.EnqID','ED.EnqID')->where('ED.EnqID',$EnqID)->get();
				$FinalQuote = json_decode($req->FinalQuote);

				$AdditionalCostData = json_decode($req->AdditionalCost);
				$AdditionalCost = 0;
				foreach($AdditionalCostData as $cost){
					$AdditionalCost += $cost->ACost;
				}
				$isEnqIDExists = DB::table($this->currfyDB.'tbl_quotation')->where('EnqID',$EnqID)->exists();
				if(!$isEnqIDExists){
					$QID = DocNum::getDocNum(docTypes::Quotation->value, $this->currfyDB,Helper::getCurrentFy());
					$totalTaxable = 0;
					$totalTaxAmount = 0;
					$totalCGST = 0;
					$totalSGST = 0;
					$totalIGST = 0;
					$totalQuoteValue = 0;
					foreach ($FinalQuote as $item) {
						$ProductDetails = DB::table('tbl_products as P')->leftJoin('tbl_tax as T', 'T.TaxID', 'P.TaxID')->where('P.ProductID', $item->ProductID)->select('P.TaxType', 'T.TaxPercentage','P.TaxID')->first();
						$Amt = $item->Qty * $item->FinalPrice;
						if($ProductDetails->TaxType == 'Include'){
							$taxAmount =  $Amt * ($ProductDetails->TaxPercentage / 100);
							$taxableAmount = $Amt - $taxAmount;
						}else{
							$taxAmount =  $Amt * ($ProductDetails->TaxPercentage / 100);
							$taxableAmount = $Amt;
						}

						$cgstPercentage = $sgstPercentage = $ProductDetails->TaxPercentage / 2;
						$cgstAmount = $sgstAmount = $taxAmount / 2;

						$totalAmount = $taxableAmount + $taxAmount;

						$totalTaxable += $taxableAmount;
						$totalTaxAmount += $taxAmount;
						$totalCGST += $cgstAmount;
						$totalSGST += $sgstAmount;
						$totalQuoteValue += $totalAmount;

						$QDetailID = DocNum::getDocNum(docTypes::QuotationDetails->value, $this->currfyDB,Helper::getCurrentFy());
						$data1=[
							"DetailID" => $QDetailID,
							"QID" => $QID,
							"VQDetailID" => $item->DetailID,
							"ProductID" => $item->ProductID,
							"TaxType" => $ProductDetails->TaxType,
							"Qty" => $item->Qty,
							"Price" => $item->FinalPrice,
							"TaxAmt" => $taxAmount,
							"Taxable" => $taxableAmount,
							"CGSTPer" => $cgstPercentage,
							"SGSTPer" => $sgstPercentage,
							"CGSTAmt" => $cgstAmount,
							"SGSTAmt" => $sgstAmount,
							"TotalAmt" => $totalAmount,
							"VendorID" => $item->VendorID,
							'CreatedOn'=>date('Y-m-d H:i:s'),
							'CreatedBy'=>$this->UserID,
						];
						$status = DB::table($this->currfyDB.'tbl_quotation_details')->insert($data1);
						if($status){
							DocNum::updateDocNum(docTypes::QuotationDetails->value, $this->currfyDB);
						}
					}
					if ($status) {
						$data=[
							'QID' => $QID,
							'EnqID' => $EnqID,
							'QNo' =>DocNum::getInvNo(docTypes::Quotation->value),
							'QDate' => date('Y-m-d'),
							'QExpiryDate' => date('Y-m-d', strtotime('+15 days')),
							'CustomerID' => $EnqData[0]->CustomerID,
							'ReceiverName' => $EnqData[0]->ReceiverName,
							'ReceiverMobNo' => $EnqData[0]->ReceiverMobNo,
							// 'ExpectedDeliveryDate' => $EnqData[0]->ExpectedDeliveryDate,
							'DAddress' => $EnqData[0]->DAddress,
							'DCountryID' => $EnqData[0]->DCountryID,
							'DStateID' => $EnqData[0]->DStateID,
							'DDistrictID' => $EnqData[0]->DDistrictID,
							'DTalukID' => $EnqData[0]->DTalukID,
							'DCityID' => $EnqData[0]->DCityID,
							'DPostalCodeID' => $EnqData[0]->DPostalCodeID,
							'SubTotal' => $totalTaxable,
							'TaxAmount' => $totalTaxAmount,
							'CGSTAmount' => $totalCGST,
							'SGSTAmount' => $totalSGST,
							'IGSTAmount' => $totalIGST,
							'TotalAmount' => $totalQuoteValue,
							'AdditionalCost' => $AdditionalCost,
							'OverAllAmount' => $totalQuoteValue + $AdditionalCost,
							'AdditionalCostData' => serialize($AdditionalCostData),
							'CreatedOn' => date('Y-m-d H:i:s'),
							'CreatedBy' => $this->UserID,
						];
						$status=DB::table($this->currfyDB.'tbl_quotation')->insert($data);
					}
				}
				$status = DB::table($this->currfyDB.'tbl_enquiry')->where('EnqID',$EnqID)->update(['Status'=>'Converted to Quotation','UpdatedOn'=>date('Y-m-d'),'UpdatedBy'=>$this->UserID]);

			}catch(Exception $e) {
				$status=false;
			}
			if($status==true){
				DB::commit();
				DocNum::updateDocNum(docTypes::Quotation->value, $this->currfyDB);
				DocNum::updateInvNo(docTypes::Quotation->value);
				$NewData=DB::table($this->currfyDB.'tbl_quotation_details as QD')->join($this->currfyDB.'tbl_quotation as Q','QD.QID','Q.QID')->where('QD.QID',$QID)->get();
				$logData=array("Description"=>"Quotation Converted","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE->value,"ReferID"=>$QID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Quotation Converted Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Quotation Convert Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
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
						$html = "";
						if($d=="New"){
							$html="<span class='badge badge-info m-1'>".$d."</span>";
						}elseif($d=="Converted to Quotation"){
							$html="<span class='badge badge-secondary m-1'>".$d."</span>";
						}elseif($d=="Quote Requested"){
							$html="<span class='badge badge-primary m-1'>".$d."</span>";
						}elseif($d=="Accepted"){
							$html="<span class='badge badge-success m-1'>".$d."</span>";
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
								// $html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-info '.$this->general->UserInfo['Theme']['button-size'].'  mr-10 btnView" data-original-title="View Quotation"><i class="fa fa-eye"></i></button>';
								$html.='<button type="button" data-id="'.$d.'" class="btn btn-outline-info '.$this->general->UserInfo['Theme']['button-size'].'  mr-10 btnView">View Enquiry</button>';
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
			$data['TABLE']=$this->currfyDB . 'tbl_enquiry';
			$data['PRIMARYKEY']='EnqID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']="Status != 'Cancelled'";
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}

	public function QTableView(Request $request){
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
								$html.='<button type="button" data-id="'.$d.'" class="btn btn-outline-info '.$this->general->UserInfo['Theme']['button-size'].'  mr-10 btnView">View Enquiry</button>';
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
			$data['TABLE']=$this->currfyDB . 'tbl_quotation';
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

	public function GetCustomers(Request $req){
		$Customers = DB::Table('tbl_customer as CU')
			->join($this->generalDB.'tbl_countries as C','C.CountryID','CU.CountryID')
			->join($this->generalDB.'tbl_states as S', 'S.StateID', 'CU.StateID')
			->join($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'CU.DistrictID')
			->join($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'CU.TalukID')
			->join($this->generalDB.'tbl_cities as CI', 'CI.CityID', 'CU.CityID')
			->join($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'CU.PostalCodeID')
			->where('CU.DFlag', 0)->where('CU.ActiveStatus', 'Active')
			->select('CU.*','C.CountryName','S.StateName','D.DistrictName','T.TalukName','CI.CityName','PC.PostalCode')
			->get();

			/* foreach($Customers as $customer){
				$billingAddressParts = array_map('trim', [
					$customer->Address,
					$customer->CityName,
					$customer->TalukName,
					$customer->DistrictName,
					$customer->StateName,
					$customer->CountryName,
					$customer->PostalCode
				]);
				$customer->BillingAddress = json_encode($billingAddressParts);

				$customer->DeliverAddress = [];
				$ShippingAddresses = DB::table('tbl_customer_address as CA')
					->join($this->generalDB.'tbl_countries as C','C.CountryID','CA.CountryID')
					->join($this->generalDB.'tbl_states as S', 'S.StateID', 'CA.StateID')
					->join($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'CA.DistrictID')
					->join($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
					->join($this->generalDB.'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
					->join($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
					->where('CA.CustomerID', $customer->CustomerID)
					->select('CA.*','C.CountryName','S.StateName','D.DistrictName','T.TalukName','CI.CityName','PC.PostalCode')
					->get();

				foreach($ShippingAddresses as $shippingAddress){
					$addressParts = array_map('trim', [
						$shippingAddress->Address,
						$shippingAddress->CityName,
						$shippingAddress->TalukName,
						$shippingAddress->DistrictName,
						$shippingAddress->StateName,
						$shippingAddress->CountryName,
						$shippingAddress->PostalCode
					]);
					$customer->DeliverAddress[] = json_encode($addressParts);
				}

				$customer->DeliverAddress = count($customer->DeliverAddress) > 0 ? json_encode($customer->DeliverAddress) : [];
			} */

		return $Customers;
	}

	public function GetVendorQuote(request $req){
		$QuoteReqData = DB::table($this->currfyDB.'tbl_vendor_quotation as VQ')
		->leftJoin($this->currfyDB.'tbl_enquiry as E','E.EnqID','VQ.EnqID')
        ->where('VQ.VendorID',$req->VendorID)->where('VQ.EnqID',$req->EnqID)
        ->select('VQ.VQuoteID','E.EnqNo')
        ->first();

        $QuoteReqData->ProductData = DB::table($this->currfyDB.'tbl_vendor_quotation_details as VQD')->leftJoin('tbl_vendors_product_mapping as VPM','VPM.ProductID','VQD.ProductID')
            ->leftJoin('tbl_products as P','P.ProductID','VQD.ProductID')
            ->leftJoin('tbl_tax as T', 'T.TaxID', 'P.TaxID')
            ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'P.CID')
            ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
            ->leftJoin('tbl_uom as U', 'U.UID', 'P.UID')
            ->where('P.ActiveStatus', 'Active')->where('P.DFlag', 0)->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
            ->where('VQD.VQuoteID',$QuoteReqData->VQuoteID)/* ->where('VQD.Status',NULL) */
            ->where('VPM.VendorID',$req->VendorID)
            ->select('VQD.DetailID','P.ProductName','P.ProductID','VQD.Qty', 'PC.PCName', 'PC.PCID', 'PSC.PSCName','U.UName','U.UCode','U.UID', 'PSC.PSCID','VPM.VendorPrice','P.TaxType','P.TaxID','T.TaxPercentage','T.TaxName')
            ->get();
		return $QuoteReqData;
	}


	public function GetVendorQuoteDetails(request $req){
		$VendorDB = Helper::getVendorDB($req->VendorID, $this->UserID);
		return DB::Table($VendorDB.'tbl_quotation_sent_details as QSD')->join('tbl_products as P','P.ProductID','QSD.ProductID')->join('tbl_uom as UOM','UOM.UID','QSD.UOMID')->where('QSD.QuoteSentID',$req->QuoteSentID)
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
