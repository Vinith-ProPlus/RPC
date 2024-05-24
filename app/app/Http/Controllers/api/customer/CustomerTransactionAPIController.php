<?php

namespace App\Http\Controllers\api\customer;

use App\helper\helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use App\Rules\ValidUnique;
use App\Rules\ValidDB;
use App\Models\DocNum;
use App\enums\docTypes;
use logs;

class CustomerTransactionAPIController extends Controller{
    private $generalDB;
    private $logDB;
    private $currfyDB;
    private $tmpDB;
    private $FileTypes;
	private $UserID;
	private $ReferID;
	private $Settings;

    public function __construct(){
		$this->generalDB=Helper::getGeneralDB();
        $this->logDB=Helper::getLogDB();
		$this->currfyDB=Helper::getcurrfyDB();
		$this->tmpDB=Helper::getTmpDB();
        $this->Settings=$this->getSettings();
		$this->FileTypes=Helper::getFileTypes(array("category"=>array("Images","Documents")));
        $this->middleware('auth:api');
        $this->middleware(function ($request, $next) {
			$this->UserID=auth()->user()->UserID;
			$this->ReferID=auth()->user()->ReferID;
			return $next($request);
		});
    }

    public function getSettings(){
		$settings=array();
		$result=DB::Table('tbl_settings')->get();
		for($i=0;$i<count($result);$i++){
			if(strtolower($result[$i]->SType)=="serialize"){
				$settings[$result[$i]->KeyName]=unserialize($result[$i]->KeyValue);
			}elseif(strtolower($result[$i]->SType)=="json"){
				$settings[$result[$i]->KeyName]=json_decode($result[$i]->KeyValue,true);
			}else{
				$settings[$result[$i]->KeyName]=$result[$i]->KeyValue;
			}
		}
		return $settings;
	}

    public function PlaceOrder(Request $req){
        DB::beginTransaction();
        $status=false;
        $CustomerID=$this->ReferID;
        try {
            $CustomerData = DB::table('tbl_customer')->where('CustomerID',$CustomerID)->first();
            $EnqID = DocNum::getDocNum(docTypes::Enquiry->value,$this->currfyDB,Helper::getCurrentFY());
            $BuildingImage = "";
            if($req->BuildingImage != null) {
                $dir = "uploads/transaction/enquiry/" . $EnqID . "/";
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                if ($req->hasFile('BuildingImage')) {
                    $file = $req->file('BuildingImage');
                    $fileName = md5($file->getClientOriginalName() . time());
                    $fileName1 = $fileName . "." . $file->getClientOriginalExtension();
                    $file->move($dir, $fileName1);
                    $BuildingImage = $dir . $fileName1;
                } else if (Helper::isJSON($req->BuildingImage) == true) {
                    $Img = json_decode($req->BuildingImage);
                    if (file_exists($Img->uploadPath)) {
                        $fileName1 = $Img->fileName != "" ? $Img->fileName : Helper::RandomString(10) . "png";
                        copy($Img->uploadPath, $dir . $fileName1);
                        $BuildingImage = $dir . $fileName1;
                        // unlink($Img->uploadPath);
                    }
                }
            }
            $AddressData = DB::table('tbl_customer_address')->where('AID',$req->AID)->first();
            $data=[
                'EnqID' => $EnqID,
                'EnqNo' =>DocNum::getInvNo("Quote-Enquiry"),
                'EnqDate' => date('Y-m-d'),
                'EnqExpiryDate' => date('Y-m-d', strtotime('+15 days')),
                'CustomerID' => $CustomerID,
                'ReceiverName' => $req->ReceiverName,
                'ReceiverMobNo' => $req->ReceiverMobNo,
                'ExpectedDeliveryDate' => $req->ExpectedDeliveryDate,
                'AID'=>$req->AID,
                "DAddress"=>$AddressData->Address,
                "DPostalCodeID"=>$AddressData->PostalCodeID,
                "DCityID"=>$AddressData->CityID,
                "DTalukID"=>$AddressData->TalukID,
                "DDistrictID"=>$AddressData->DistrictID,
                "DStateID"=>$AddressData->StateID,
                "DCountryID"=>$AddressData->CountryID,
                'StageID' => $req->StageID,
                'BuildingMeasurementID' => $req->BuildingMeasurementID,
                'BuildingMeasurement' => $req->BuildingMeasurement,
                'BuildingImage' => $BuildingImage,
                'CreatedOn' => date('Y-m-d H:i:s'),
                'CreatedBy' => $CustomerID,
            ];
            $status=DB::table($this->currfyDB.'tbl_enquiry')->insert($data);
            if($status){
                $ProductData = json_decode($req->ProductData,true);
                foreach($ProductData as $item){
                    $EnquiryDetailID = DocNum::getDocNum(docTypes::EnquiryDetails->value,$this->currfyDB,Helper::getCurrentFY());
                    $data1=[
                        'DetailID' => $EnquiryDetailID,
                        'EnqID'=>$EnqID,
                        'CID'=>$item['PCID'],
                        'SCID'=>$item['PSCID'],
                        'ProductID'=>$item['ProductID'],
                        'Qty'=>$item['Qty'],
                        'UOMID'=>$item['UID'],
                        'CreatedOn'=>date('Y-m-d H:i:s'),
                        'CreatedBy'=>$CustomerID,
                    ];
                    $status = DB::table($this->currfyDB.'tbl_enquiry_details')->insert($data1);
                    if($status){
                        DocNum::updateDocNum(docTypes::EnquiryDetails->value,$this->currfyDB);
                    }
                }
                DocNum::updateDocNum(docTypes::Enquiry->value,$this->currfyDB);
            }
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            $Title = "Quotation Received";
            $Message = "Your quotation has been received. Admin will verify your quotation and get back to you shortly.";
            Helper::saveNotification($CustomerID,$Title,$Message,'Enquiry',$EnqID);
            DocNum::updateInvNo("Quote-Enquiry");
            DB::table('tbl_customer_cart')->where('CustomerID',$CustomerID)->delete();
            return response()->json(['status' => true,'message' => "Order Placed Successfully"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Order Placing Failed!"]);
        }
    }

    public function CancelQuoteEnquiry(Request $req){
        $CustomerID = $this->ReferID;
		DB::beginTransaction();
        try {
            $status = DB::Table($this->currfyDB.'tbl_enquiry')->where('CustomerID',$CustomerID)->where('EnqID',$req->EnqID)->update(['Status'=>'Cancelled','CancelledBy'=>$CustomerID,'UpdatedOn'=>date('Y-m-d H:i:s')]);
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            return response()->json(['status' => true ,'message' => "Quote Cancelled Successfully!"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Quote Cancel Failed!"]);
        }
	}

    public function getQuoteEnquiry(Request $req){
        $Status = $req->Status;
        $EnqStatus = [];
        $QStatus = [];

        if($Status == 'New'){
            $EnqStatus = ['New'];
        }
        if($Status == 'Accepted'){
            $QStatus = ['Accepted'];
            $EnqStatus = ['Accepted'];
        }
        if($Status == 'Cancelled'){
            $QStatus = ['Rejected'];
            $EnqStatus = ['Cancelled'];
        }
        if($Status == 'Pending'){
            $EnqStatus = ['Quote Requested','Converted to Quotation'];
            $QStatus = ['New'];
        }

        $query = DB::table($this->currfyDB.'tbl_enquiry as E')
            ->leftJoin($this->currfyDB.'tbl_quotation as Q','Q.EnqID','E.EnqID')
            ->leftJoin('tbl_customer as CU','CU.CustomerID','E.CancelledBy')
            ->where('E.CustomerID',$this->ReferID);
        if($Status){
            $query->where(function($query) use ($EnqStatus, $QStatus) {
                $query->where(function($query) use ($EnqStatus) {
                    $query->whereIn('E.Status',$EnqStatus);
                })->orWhere(function($query) use ($QStatus) {
                    $query->whereIn('Q.Status',$QStatus);
                });
            });
        }
        if($req->EnqID){
            $query->where('E.EnqID',$req->EnqID);
        }
        $QuoteEnq=$query
        ->select('E.EnqID','E.EnqNo','E.EnqDate','E.EnqExpiryDate','E.ReceiverName','E.ReceiverMobNo','E.ExpectedDeliveryDate',
            'E.Status AS EnqStatus','Q.Status AS QStatus','Q.QID','Q.QNo','Q.QExpiryDate','Q.QDate','Q.TaxAmount','Q.SubTotal',
            'Q.CGSTAmount','Q.SGSTAmount','Q.IGSTAmount','Q.TotalAmount','Q.AdditionalCost','Q.OverAllAmount','CU.CustomerName as CancelledBy')
        ->orderBy('E.CreatedOn','desc')
        ->get();
        $CustomerCreditLimit = DB::table('tbl_customer')->where('CustomerID',$this->ReferID)->value('CreditLimit');
        $CustomerBalanceAmount = DB::table($this->currfyDB.'tbl_order as O')->where('O.CustomerID',$this->ReferID)->where('Status','Delivered')->sum('BalanceAmount');
        $isCreditLimitExceeds = $CustomerBalanceAmount > $CustomerCreditLimit ? true : false;
        foreach($QuoteEnq as $quote){
            $quote->isCreditLimitExceeds = $isCreditLimitExceeds;
            if($quote->EnqStatus == "New"){
                $quote->Status = "New";
            }elseif($quote->EnqStatus == "Cancelled" || $quote->QStatus == "Rejected"){
                $quote->Status = "Cancelled";
            }elseif($quote->QStatus == "Accepted"){
                $quote->Status = "Accepted";
            }else{
                $quote->Status = "Pending";
            }

            $quote->ProductData = DB::table($this->currfyDB.'tbl_enquiry_details as ED')
                ->leftJoin($this->currfyDB.'tbl_quotation as Q','Q.EnqID','ED.EnqID')
                ->leftJoin($this->currfyDB.'tbl_quotation_details as QD', function($join) {
                    $join->on('QD.QID', 'Q.QID')
                         ->on('QD.ProductID', 'ED.ProductID');
                })
                ->leftJoin('tbl_products as P','P.ProductID','ED.ProductID')
                ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
                ->leftJoin('tbl_uom as U','U.UID','P.UID')
                ->leftJoin('users as US','US.UserID','QD.CancelledBy')
                ->where('ED.EnqID',$quote->EnqID)
                ->select('QD.DetailID','P.ProductID','P.ProductName','ED.Qty','QD.Price','QD.Taxable','PC.PCName','PSC.PSCName','QD.isCancelled','US.LoginType as CancelledBy')
                ->get();
        }

        return response()->json(['status' => true,'data' => $QuoteEnq]);
    }

    public function AcceptQuote(Request $req){
        $CustomerID = $this->ReferID;
		DB::beginTransaction();
        try {
            $AcceptedQData = DB::table($this->currfyDB . 'tbl_quotation_details as QD')->leftJoin($this->currfyDB . 'tbl_quotation as Q','Q.QID','QD.QID')->where('QD.QID',$req->QID)->where('QD.isCancelled',0)->get();
            $isQIDExists = DB::table($this->currfyDB . 'tbl_order')->where('QID',$req->QID)->exists();
            if(!$isQIDExists){
                $defaultExpectedDeliveryDate = (int) DB::table('tbl_settings')->where('KeyName','Order-Delivery-Expected-days')->value('KeyValue');
                $expectedDelivery = $req->ExpectedDeliveryDate ?? date('Y-m-d', strtotime('+'.$defaultExpectedDeliveryDate.' days'));
                $OrderID = DocNum::getDocNum(docTypes::Order->value, $this->currfyDB,Helper::getCurrentFy());
                $data=[
                    'OrderID' => $OrderID,
                    'OrderNo' =>DocNum::getInvNo(docTypes::Order->value),
                    'OrderDate' => date('Y-m-d'),
                    'QID' => $req->QID,
                    'EnqID' => $AcceptedQData[0]->EnqID,
                    'CustomerID' => $AcceptedQData[0]->CustomerID,
                    'ReceiverName' => $AcceptedQData[0]->ReceiverName,
                    'ReceiverMobNo' => $AcceptedQData[0]->ReceiverMobNo,
                    "ExpectedDelivery"=>$expectedDelivery,
                    'AID' => $AcceptedQData[0]->AID,
                    'DAddress' => $AcceptedQData[0]->DAddress,
                    'DCountryID' => $AcceptedQData[0]->DCountryID,
                    'DStateID' => $AcceptedQData[0]->DStateID,
                    'DDistrictID' => $AcceptedQData[0]->DDistrictID,
                    'DTalukID' => $AcceptedQData[0]->DTalukID,
                    'DCityID' => $AcceptedQData[0]->DCityID,
                    'DPostalCodeID' => $AcceptedQData[0]->DPostalCodeID,
                    'TaxAmount' => $AcceptedQData[0]->TaxAmount,
                    'SubTotal' => $AcceptedQData[0]->SubTotal,
                    'DiscountType' => $AcceptedQData[0]->DiscountType,
                    'DiscountPercentage' => $AcceptedQData[0]->DiscountPercent,
                    'DiscountAmount' => $AcceptedQData[0]->DiscountAmount,
                    'CGSTAmount' => $AcceptedQData[0]->CGSTAmount,
                    'SGSTAmount' => $AcceptedQData[0]->SGSTAmount,
                    'IGSTAmount' => $AcceptedQData[0]->IGSTAmount,
                    'TotalAmount' => $AcceptedQData[0]->TotalAmount,
                    'AdditionalCost' => $AcceptedQData[0]->AdditionalCost,
                    'NetAmount' => $AcceptedQData[0]->OverAllAmount,
                    'AdditionalCostData' => $AcceptedQData[0]->AdditionalCostData,
                    "PaidAmount"=>0,
                    "BalanceAmount"=>$AcceptedQData[0]->OverAllAmount,
                    "PaymentStatus"=>"Unpaid",
                    'CreatedOn' => date('Y-m-d'),
                    'CreatedBy' => $CustomerID,
                ];
                $status=DB::table($this->currfyDB . 'tbl_order')->insert($data);
                if($status){
                    foreach($AcceptedQData as $item){
                        $OrderDetailID = DocNum::getDocNum(docTypes::OrderDetails->value, $this->currfyDB,Helper::getCurrentFy());
                        $data1=[
                            'DetailID' => $OrderDetailID,
                            'OrderID'=>$OrderID,
                            'QID' => $req->QID,
                            "QDID"=>$item->DetailID,
                            'ProductID'=>$item->ProductID,
                            'Qty'=>$item->Qty,
                            'Price'=>$item->Price,
                            'TaxType'=>$item->TaxType,
                            'TaxPer'=>$item->TaxPer,
                            'Taxable'=>$item->Taxable,
                            'DiscountType'=>$item->DiscountType,
                            'DiscountPer'=>$item->DiscountPer,
                            'DiscountAmt'=>$item->DiscountAmt,
                            'TaxAmt'=>$item->TaxAmt,
                            'CGSTPer'=>$item->CGSTPer,
                            'SGSTPer'=>$item->SGSTPer,
                            'IGSTPer'=>$item->IGSTPer,
                            'CGSTAmt'=>$item->CGSTAmt,
                            'SGSTAmt'=>$item->SGSTAmt,
                            'IGSTAmt'=>$item->IGSTAmt,
                            'TotalAmt'=>$item->TotalAmt,
                            'VendorID' => $item->VendorID,
                            'CreatedOn'=>date('Y-m-d'),
                            'CreatedBy' => $CustomerID,
                        ];
                        $status = DB::table($this->currfyDB . 'tbl_order_details')->insert($data1);
                        if($status){
                            DocNum::updateDocNum(docTypes::OrderDetails->value,$this->currfyDB);
                        }
                    }
                }
                $data=$this->getQuotes(["QID"=>$req->QID]);
                if($status){
                    $status=$this->SaveVendorOrders($data[0],$OrderID,$req->QID,$req->ExpectedDeliveryDate);
                }

            }else{
                return response()->json(['status' => false,'message' => "Quote already converted to Order!"]);
                $status = false;
            }
            if($status){
                $status = DB::Table($this->currfyDB.'tbl_quotation')->where('QID',$req->QID)->update(['Status'=>'Accepted','AcceptedOn'=>date('Y-m-d'),'UpdatedOn'=>date('Y-m-d H:i:s'),"UpdatedBy"=>$CustomerID]);
                $status = DB::Table($this->currfyDB.'tbl_enquiry')->where('EnqID',$req->EnqID)->update(['Status'=>'Accepted','UpdatedOn'=>date('Y-m-d H:i:s'),"UpdatedBy"=>$CustomerID]);
            }
            $status = true;
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            DocNum::updateDocNum(docTypes::Order->value,$this->currfyDB);
            DocNum::updateInvNo(docTypes::Order->value);
            return response()->json(['status' => true ,'message' => "Quote Accepted Successfully!"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Quote Accept Failed!"]);
        }
	}

    public function SaveVendorOrders($QData,$OrderID,$QID,$ExpectedDelivery){
		$status=true;
		$QDetails=DB::Select("Select DISTINCT(VendorID) as VendorID From ".$this->currfyDB."tbl_order_details Where OrderID='".$OrderID."' and Status<>'Cancelled'");
		//SELECT OD.DetailID as ODetailID, OD.QID, OD.QDID, OD.OrderID, OD.ProductID, VQD.Qty, VQD.Price FROM tbl_order_details as OD LEFT JOIN tbl_quotation_details as QD ON QD.DetailID=OD.QDID AND QD.QID=OD.QID LEFT JOIN tbl_vendor_quotation_details as VQD ON VQD.DetailID=QD.VQDetailID AND VQD.ProductID=QD.ProductID;
		foreach($QDetails as $QItem){
			$VendorID=$QItem->VendorID;
			$CommissionPercentage=0;
			$t=DB::Table('tbl_vendors')->where('VendorID',$VendorID)->get();
			if(count($t)>0){
				$CommissionPercentage=$t[0]->CommissionPercentage;
			}
			$VOrderID=DocNum::getDocNum(docTypes::VendorOrders->value, $this->currfyDB,Helper::getCurrentFy());
			$VOrderNo=DocNum::getInvNo(docTypes::VendorOrders->value);
			if($status){
				$sql =" SELECT OD.DetailID as ODetailID, OD.QID, OD.QDID, OD.OrderID, OD.ProductID, VQD.Qty, VQD.Price, VQD.TaxType, VQD.TaxID, VQD.TaxPer, VQD.Taxable, VQD.DiscountType, VQD.DiscountPer, VQD.DiscountAmt, VQD.TaxAmt, VQD.CGSTPer, VQD.SGSTPer, VQD.IGSTPer, VQD.CGSTAmt, VQD.SGSTAmt, VQD.IGSTAmt, VQD.TotalAmt ";
				$sql.=" FROM ".$this->currfyDB."tbl_order_details as OD LEFT JOIN ".$this->currfyDB."tbl_quotation_details as QD ON QD.DetailID=OD.QDID AND QD.QID=OD.QID LEFT JOIN ".$this->currfyDB."tbl_vendor_quotation_details as VQD ON VQD.DetailID=QD.VQDetailID AND VQD.ProductID=QD.ProductID ";
				$sql.=" Where QD.isCancelled = 0 and OD.OrderID='".$OrderID."' and OD.VendorID='".$VendorID."'";
				$result=DB::SELECT($sql);
				$totals=json_decode(json_encode(["TaxAmount"=>0,"SubTotal"=>0,"CGSTAmount"=>0,"SGSTAmount"=>0,"IGSTAmount"=>0,"additionalCharges"=>0,"TotalAmount"=>0]));
				foreach($result as $tdata){
					if($status){
						$DetailID=DocNum::getDocNum(docTypes::VendorOrderDetails->value, $this->currfyDB,Helper::getCurrentFy());
						$data=[
							"DetailID"=>$DetailID,
							"QID"=>$tdata->QID,
							"QDID"=>$tdata->QDID,
							"OrderID"=>$tdata->OrderID,
							"ODetailID"=>$tdata->ODetailID,
							"VOrderID"=>$VOrderID,
							"ProductID"=>$tdata->ProductID,
							"Qty"=>$tdata->Qty,
							"Price"=>$tdata->Price,
							"TaxType"=>$tdata->TaxType,
							"TaxPer"=>$tdata->TaxPer,
							"Taxable"=>$tdata->Taxable,
							"DiscountType"=>$tdata->DiscountType,
							"DiscountPer"=>$tdata->DiscountPer,
							"DiscountAmt"=>$tdata->DiscountAmt,
							"TaxAmt"=>$tdata->TaxAmt,
							"CGSTPer"=>$tdata->CGSTPer,
							"SGSTPer"=>$tdata->SGSTPer,
							"IGSTPer"=>$tdata->IGSTPer,
							"CGSTAmt"=>$tdata->CGSTAmt,
							"SGSTAmt"=>$tdata->SGSTAmt,
							"IGSTAmt"=>$tdata->IGSTAmt,
							"TotalAmt"=>$tdata->TotalAmt,
							"CreatedOn"=>now(),
							"CreatedBy"=>$this->ReferID
						];

						$totals->TaxAmount+=$tdata->TaxAmt;
						$totals->SubTotal+=$tdata->Taxable;
						$totals->CGSTAmount+=$tdata->CGSTAmt;
						$totals->SGSTAmount+=$tdata->SGSTAmt;
						$totals->IGSTAmount+=$tdata->IGSTAmt;
						$status=DB::Table($this->currfyDB.'tbl_vendor_order_details')->insert($data);
						if($status){
							DocNum::updateDocNum(docTypes::VendorOrderDetails->value, $this->currfyDB);
							$status=DB::table($this->currfyDB.'tbl_order_details')->where('DetailID',$tdata->ODetailID)->update(["VOrderID"=>$VOrderID,"VOrderDetailID"=>$DetailID,"UpdatedOn"=>now(),"updatedBy"=>$this->ReferID]);
						}
					}
				}
				if($status){
					$sql="SELECT AdditionalCost FROM ".$this->currfyDB."tbl_vendor_quotation Where VendorID='".$VendorID."' and EnqID in(Select EnqID From ".$this->currfyDB."tbl_quotation Where QID='".$QID."')";
					$tmp=DB::SELECT($sql);
					foreach($tmp as $t){
						$totals->additionalCharges+=floatval($t->AdditionalCost);
					}
					$totals->TotalAmount=floatval($totals->SubTotal)+floatval($totals->CGSTAmount)+floatval($totals->SGSTAmount)+floatval($totals->IGSTAmount);
					$CommissionAmount=(($totals->TotalAmount*$CommissionPercentage)/100);
					$NetAmount=(($totals->TotalAmount-$CommissionAmount)+$totals->additionalCharges);
					$tdata=[
						"VOrderID"=>$VOrderID,
						"OrderID"=>$OrderID,
						"OrderNo"=>$VOrderNo,
						"OrderDate"=>date("Y-m-d"),
						"ExpectedDelivery"=>date("Y-m-d",strtotime($ExpectedDelivery)),
						"QID"=>$QID,
						"CustomerID"=>$QData->CustomerID,
						"AID"=>$QData->AID,
						"VendorID"=>$VendorID,
						"ReceiverName"=>$QData->ReceiverName,
						"ReceiverMobNo"=>$QData->ReceiverMobNo,
						"DAddress"=>$QData->DAddress,
						"DCountryID"=>$QData->DCountryID,
						"DStateID"=>$QData->DStateID,
						"DDistrictID"=>$QData->DDistrictID,
						"DTalukID"=>$QData->DTalukID,
						"DCityID"=>$QData->DCityID,
						"DPostalCodeID"=>$QData->DPostalCodeID,
						"Status"=>"New",
						"TaxAmount"=>$totals->TaxAmount,
						"SubTotal"=>$totals->SubTotal,
						"DiscountType"=>"",
						"DiscountPercentage"=>0,
						"DiscountAmount"=>0,
						"CGSTAmount"=>$totals->CGSTAmount,
						"SGSTAmount"=>$totals->SGSTAmount,
						"IGSTAmount"=>$totals->IGSTAmount,
						"TotalAmount"=>$totals->TotalAmount,
						"CommissionAmount"=>$CommissionAmount,
						"CommissionPercentage"=>$CommissionPercentage,
						"AdditionalCost"=>$totals->additionalCharges,
						"NetAmount"=>$NetAmount,
						"PaidAmount"=>0,
						"BalanceAmount"=>$NetAmount,
						"PaymentStatus"=>"Unpaid",
						"AdditionalCostData"=> serialize([]),
						"CreatedOn"=>now(),
						"CreatedBy"=>$this->ReferID
					];
					$status=DB::table($this->currfyDB.'tbl_vendor_orders')->insert($tdata);
					if($status){
						DocNum::updateDocNum(docTypes::VendorOrders->value, $this->currfyDB);
						DocNum::updateInvNo(docTypes::VendorOrders->value);
						$Title = "New Order Arrived. Order No " . $VOrderNo . ".";
						$Message = "You have a new order! Check now for details and fulfill it promptly.";
						Helper::saveNotification($VendorID,$Title,$Message,'Orders',$VOrderID);
					}
				}
			}
		}
		return $status;
	}

    public function getQuotes($data=array()){
		$sql ="SELECT Q.QID, Q.EnqID, Q.QNo, Q.QDate, Q.QExpiryDate, Q.CustomerID, Q.AID, C.CustomerName, C.MobileNo1, C.MobileNo2, C.Email, C.Address as BAddress, C.CountryID as BCountryID, BC.CountryName as BCountryName, ";
		$sql.=" C.StateID as BStateID, BS.StateName as BStateName, C.DistrictID as BDistrictID, BD.DistrictName as BDistrictName, C.TalukID, BT.TalukName as BTalukName, C.CityID as BCityID, BCI.CityName as BCityName, C.PostalCodeID as BPostalCodeID, ";
		$sql.=" BPC.PostalCode as BPostalCode, BC.PhoneCode, Q.ReceiverName, Q.ReceiverMobNo, Q.DAddress, Q.DCountryID, CO.CountryName as DCountryName, Q.DStateID, S.StateName as DStateName, Q.DDistrictID, D.DistrictName as DDistrictName, Q.DTalukID, ";
		$sql.=" T.TalukName as DTalukName, Q.DCityID, CI.CityName as DCityName, Q.DPostalCodeID, PC.PostalCode as DPostalCode, Q.TaxAmount, Q.SubTotal, Q.DiscountType, Q.DiscountPercent as DiscountPercentage, Q.DiscountAmount, Q.CGSTAmount, ";
		$sql.=" Q.SGSTAmount, Q.IGSTAmount, Q.TotalAmount, Q.AdditionalCost, Q.OverAllAmount as NetAmount, Q.AdditionalCostData, Q.Status, Q.AcceptedOn, Q.RejectedOn, Q.ApprovedBy, Q.RejectedBy, Q.RReasonID, RR.RReason, Q.RRDescription ";
		$sql.=" FROM ".$this->currfyDB."tbl_quotation as Q LEFT JOIN tbl_customer as C ON C.CustomerID=Q.CustomerID LEFT JOIN ".$this->generalDB."tbl_countries as BC ON BC.CountryID=C.CountryID  ";
		$sql.=" LEFT JOIN ".$this->generalDB."tbl_states as BS ON BS.StateID=C.StateID LEFT JOIN ".$this->generalDB."tbl_districts as BD ON BD.DistrictID=C.DistrictID  ";
		$sql.=" LEFT JOIN ".$this->generalDB."tbl_taluks as BT ON BT.TalukID=C.TalukID LEFT JOIN ".$this->generalDB."tbl_cities as BCI ON BCI.CityID=C.CityID ";
		$sql.=" LEFT JOIN ".$this->generalDB."tbl_postalcodes as BPC ON BPC.PID=C.PostalCodeID LEFT JOIN ".$this->generalDB."tbl_countries as CO ON CO.CountryID=Q.DCountryID  ";
		$sql.=" LEFT JOIN ".$this->generalDB."tbl_states as S ON S.StateID=Q.DStateID LEFT JOIN ".$this->generalDB."tbl_districts as D ON D.DistrictID=Q.DDistrictID ";
		$sql.=" LEFT JOIN ".$this->generalDB."tbl_taluks as T ON T.TalukID=Q.DTalukID LEFT JOIN ".$this->generalDB."tbl_cities as CI ON CI.CityID=Q.DCityID ";
		$sql.=" LEFT JOIN ".$this->generalDB."tbl_postalcodes as PC ON PC.PID=Q.DPostalCodeID LEFT JOIN tbl_reject_reason as RR ON RR.RReasonID=Q.RReasonID ";
		$sql.=" Where 1=1 ";
		if(is_array($data)){
			if(array_key_exists("QID",$data)){$sql.=" AND Q.QID='".$data['QID']."'";}
		}
		$result=DB::SELECT($sql);

		for($i=0;$i<count($result);$i++){
			$result[$i]->AdditionalCostData=unserialize($result[$i]->AdditionalCostData);
			$sql="SELECT QD.DetailID, QD.QID, QD.VQDetailID, QD.ProductID, P.ProductName, P.Decimals, P.HSNSAC, P.UID, U.UCode, U.UName, QD.Qty, QD.Price, QD.TaxType, QD.TaxPer, QD.Taxable, QD.DiscountType, QD.DiscountPer, QD.DiscountAmt, QD.TaxAmt, QD.CGSTPer, QD.SGSTPer, QD.IGSTPer, QD.CGSTAmt, QD.SGSTAmt, QD.IGSTAmt, QD.TotalAmt, QD.VendorID, V.VendorName, QD.isCancelled, QD.CancelledBy, QD.CancelledOn, QD.ReasonID, RR.RReason, QD.RDescription  ";
			$sql.=" FROM ".$this->currfyDB."tbl_quotation_details as QD LEFT JOIN tbl_products as P ON P.ProductID=QD.ProductID LEFT JOIN tbl_uom as U ON U.UID=P.UID LEFT JOIN tbl_reject_reason as RR ON RR.RReasonID=QD.ReasonID LEFT JOIN tbl_vendors as V ON V.VendorID=QD.VendorID ";
			$sql.=" Where QD.QID='".$result[$i]->QID."' and QD.isCancelled = 0";
			$result[$i]->Details=DB::SELECT($sql);
			for($j=0;$j<count($result[$i]->Details);$j++){
				$result[$i]->Details[$j]->VQuoteID="";
				$result1=DB::Table($this->currfyDB.'tbl_vendor_quotation')->Where('EnqID',$result[$i]->EnqID)->where('VendorID',$result[$i]->Details[$j]->VendorID)->get();
				if(count($result1)>0){
					$result[$i]->Details[$j]->VQuoteID=$result1[0]->VQuoteID;
				}
			}
			$addCharges=[];
			$result1=DB::Table($this->currfyDB.'tbl_vendor_quotation')->Where('EnqID',$result[$i]->EnqID)->get();

			foreach($result1 as $tmp){
				$addCharges[$tmp->VendorID]=Helper::NumberFormat($tmp->AdditionalCost,$this->Settings['price-decimals']);
			}
			$result[$i]->AdditionalCharges=$addCharges;
		}
		return $result;
	}

    public function RejectQuote(Request $req){
        $CustomerID = $this->ReferID;
		DB::beginTransaction();
        try {
            $status = DB::Table($this->currfyDB.'tbl_quotation')->where('QID',$req->QID)->update(['Status'=>'Rejected','RejectedOn'=>date('Y-m-d'),'UpdatedOn'=>date('Y-m-d H:i:s'),'RReasonID'=>$req->RReasonID,'RRDescription'=>$req->RRDescription]);
            if($status){
                $status = DB::Table($this->currfyDB.'tbl_enquiry')->where('EnqID',$req->EnqID)->update(['Status'=>'Cancelled','DeletedOn'=>date('Y-m-d'),'DeletedBy'=>$CustomerID]);
            }
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
	}

    public function RejectQuoteItem(Request $req){
        $CustomerID = $this->ReferID;
		DB::beginTransaction();
        try {
            $status = DB::Table($this->currfyDB.'tbl_quotation_details')->where('DetailID',$req->DetailID)->update(['isCancelled'=>1, 'CancelledBy'=>$this->ReferID, "ReasonID"=>$req->RReasonID, "RDescription"=>$req->RRDescription,'CancelledOn'=>date('Y-m-d'),'UpdatedOn'=>date('Y-m-d H:i:s')]);
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
                        'UpdatedBy' => $CustomerID,
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
	}

    public function getOrder(Request $req){
        $query = DB::table($this->currfyDB.'tbl_order as O')
        ->leftJoin('tbl_customer as CU','CU.CustomerID','O.CustomerID')
        ->leftJoin('tbl_customer_address as CA','CA.AID','O.AID')->where('O.CustomerID',$this->ReferID);
        if($req->Status){
            $query->where('O.Status',$req->Status);
        }
        if($req->OrderID){
            $query->where('O.OrderID',$req->OrderID);
        }
        $OrderData=$query
        ->select('O.OrderID','O.OrderNo','O.OrderDate','O.ReceiverName','O.ReceiverMobNo','O.Status','O.TaxAmount','O.SubTotal','O.CGSTAmount','O.SGSTAmount','O.IGSTAmount','O.TotalAmount','O.AdditionalCost','O.NetAmount','O.isRated','O.DeliveredOn','O.ExpectedDelivery','O.PaymentStatus','CU.CompleteAddress as BillingAddress','CA.CompleteAddress as ShippingAddress')
        ->orderBy('O.CreatedOn','desc')
        ->get();

        foreach($OrderData as $order){
            $order->TotalUnit = DB::table($this->currfyDB.'tbl_order_details')->where('OrderID',$order->OrderID)->sum('Qty');
            $order->ProductData = DB::table($this->currfyDB.'tbl_order_details as OD')
                ->leftJoin('tbl_products as P','P.ProductID','OD.ProductID')
                ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
                ->leftJoin('tbl_uom as U','U.UID','P.UID')
                ->where('OD.OrderID',$order->OrderID)
                ->whereNot('OD.Status','Cancelled')
                ->select('P.ProductID','P.ProductName','OD.Qty','OD.Price','OD.Taxable','OD.TaxAmt','OD.CGSTPer','OD.SGSTPer','OD.IGSTPer','OD.CGSTAmt','OD.SGSTAmt','OD.IGSTAmt','OD.TotalAmt','U.UName','PC.PCName','PSC.PSCName')
                ->get();
        }
        return response()->json(['status' => true,'data' => $OrderData]);
    }

    public function ReviewOrder(Request $req){
		DB::beginTransaction();
        try {
            $isOrderCompleted = DB::Table($this->currfyDB.'tbl_vendor_orders')->where('VOrderID',$req->VOrderID)->where('Status','Delivered')->exists();
            if(!$isOrderCompleted){
                return response()->json(['status' => false,'message' => "Order is not Delivered!"]);
            }else{
                $status = DB::Table($this->currfyDB.'tbl_vendor_orders')->where('VOrderID',$req->VOrderID)->update(['CustomerRatings'=>$req->Ratings,'CustomerReview'=>$req->Review,'isCustomerRated'=>1,'CustomerRatedOn'=>date('Y-m-d'),'UpdatedOn'=>date('Y-m-d H:i:s')]);
            }
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            return response()->json(['status' => true ,'message' => "Order Rated Successfully!"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Order Rating Failed!"]);
        }
	}

    public function getCategory(Request $req){
        if($req->PostalID){
            $AllVendors = DB::table('tbl_vendors as V')->leftJoin('tbl_vendors_service_locations as VSL','V.VendorID','VSL.VendorID')->where('V.ActiveStatus',"Active")->where('V.DFlag',0)->where('VSL.PostalCodeID',$req->PostalID)->groupBy('VSL.VendorID')->pluck('VSL.VendorID')->toArray();
            $PCatagories= DB::table('tbl_vendors_product_mapping as VPM')
            ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'VPM.PCID')
            ->where('VPM.Status',1)->WhereIn('VPM.VendorID',$AllVendors)
            ->groupBy('PC.PCID', 'PC.PCName','PC.PCImage')
            ->select('PC.PCID','PC.PCName', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS CategoryImage'))->get();
            foreach($PCatagories as $row){
                $row->PSCData = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'VPM.PSCID')
                ->where('VPM.Status',1)->where('PSC.PCID',$row->PCID)->WhereIn('VPM.VendorID',$AllVendors)
                ->groupBy('PSC.PSCID', 'PSC.PSCName')
                ->select('PSC.PSCID','PSC.PSCName')->get();
                foreach($row->PSCData as $item){
					$item->ProductData = DB::table('tbl_vendors_product_mapping as VPM')
                    ->leftJoin('tbl_products as P', 'P.ProductID', 'VPM.ProductID')
                    ->where('VPM.Status',1)->where('P.SCID',$item->PSCID)->WhereIn('VPM.VendorID',$AllVendors)
                    ->groupBy('P.ProductID', 'P.ProductName')
                    ->select('P.ProductID','P.ProductName')->get();
				}
            }
            return $PCatagories;
        }else{
            return [];
        }
    }

}
