<?php

namespace App\Http\Controllers\api\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use Auth;
use Helper;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use ValidUnique;
use ValidDB;
use DocNum;
use docTypes;
use logs;

class CustomerTransactionAPIController extends Controller{
    private $generalDB;
    private $logDB;
    private $currfyDB;
    private $tmpDB;
    private $FileTypes;
	private $UserID;
	private $ReferID;

    public function __construct(){
		$this->generalDB=Helper::getGeneralDB();
        $this->logDB=Helper::getLogDB();
		$this->currfyDB=Helper::getCurrFYDB();
		$this->tmpDB=Helper::getTmpDB();
		$this->FileTypes=Helper::getFileTypes(array("category"=>array("Images","Documents")));
        $this->middleware('auth:api');
        $this->middleware(function ($request, $next) {
			$this->UserID=auth()->user()->UserID;
			$this->ReferID=auth()->user()->ReferID;
			return $next($request);
		});
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
            DocNum::updateInvNo("Quote-Enquiry");
            DB::table('tbl_customer_cart')->where('CustomerID',$CustomerID)->delete();
            return response()->json(['status' => true,'message' => "Order Placed Successfully"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Order Placing Failed!"]);
        }
    }
    public function PlaceOrder1(Request $req){
        DB::beginTransaction();
        $status=false;
        $CustomerID=$this->ReferID;
        try {
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
            $data=[
                'EnqID' => $EnqID,
                'EnqNo' =>DocNum::getInvNo("Quote-Enquiry"),
                'EnqDate' => date('Y-m-d'),
                'EnqExpiryDate' => date('Y-m-d', strtotime('+15 days')),
                'CustomerID' => $CustomerID,
                'ReceiverName' => $req->ReceiverName,
                'ReceiverMobNo' => $req->ReceiverMobNo,
                'ExpectedDeliveryDate' => $req->ExpectedDeliveryDate,
                'Address' => $req->Address,
                'CountryID' => $req->CountryID,
                'StateID' => $req->StateID,
                'DistrictID' => $req->DistrictID,
                'TalukID' => $req->TalukID,
                'CityID' => $req->CityID,
                'PostalCodeID' => $req->PostalCodeID,
                'DAddress' => $req->Address,
                'DCountryID' => $req->CountryID,
                'DStateID' => $req->StateID,
                'DDistrictID' => $req->DistrictID,
                'DTalukID' => $req->TalukID,
                'DCityID' => $req->CityID,
                'DPostalCodeID' => $req->PostalCodeID,
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
        $QuoteEnq=$query
        ->select('E.EnqID','E.EnqNo','E.EnqDate','E.EnqExpiryDate','E.ReceiverName','E.ReceiverMobNo','E.ExpectedDeliveryDate','E.Status AS EnqStatus','Q.Status AS QStatus','Q.QID','Q.QNo','Q.QExpiryDate','Q.QDate','Q.TaxAmount','Q.SubTotal','Q.CGSTAmount','Q.SGSTAmount','Q.IGSTAmount','Q.TotalAmount','Q.AdditionalCost','Q.OverAllAmount','CU.CustomerName as CancelledBy')
        ->get();
        
        foreach($QuoteEnq as $quote){
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
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'P.CID')
                ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
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
            $AcceptedQData = DB::table($this->currfyDB . 'tbl_quotation_details as QD')->leftJoin($this->currfyDB . 'tbl_quotation as Q','Q.QID','QD.QID')->where('QD.QID',$req->QID)->get();
            $isQIDExists = DB::table($this->currfyDB . 'tbl_order')->where('QID',$req->QID)->exists();
            if(!$isQIDExists){
                $OrderID = DocNum::getDocNum(docTypes::Order->value, $this->currfyDB,Helper::getCurrentFy());
                $data=[
                    'OrderID' => $OrderID,
                    'QID' => $req->QID,
                    'OrderNo' =>DocNum::getInvNo(docTypes::Order->value),
                    'OrderDate' => date('Y-m-d'),
                    'CustomerID' => $AcceptedQData[0]->CustomerID,
                    'ReceiverName' => $AcceptedQData[0]->ReceiverName,
                    'ReceiverMobNo' => $AcceptedQData[0]->ReceiverMobNo,
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
                    'DiscountPercent' => $AcceptedQData[0]->DiscountPercent,
                    'DiscountAmount' => $AcceptedQData[0]->DiscountAmount,
                    'CGSTAmount' => $AcceptedQData[0]->CGSTAmount,
                    'SGSTAmount' => $AcceptedQData[0]->SGSTAmount,
                    'IGSTAmount' => $AcceptedQData[0]->IGSTAmount,
                    'TotalAmount' => $AcceptedQData[0]->TotalAmount,
                    'OverAllAmount' => $AcceptedQData[0]->OverAllAmount,
                    'AdditionalCost' => $AcceptedQData[0]->AdditionalCost,
                    'AdditionalCostData' => $AcceptedQData[0]->AdditionalCostData,
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
                            'ProductID'=>$item->ProductID,
                            'Qty'=>$item->Qty,
                            'Price'=>$item->Price,
                            'VendorID' => $item->VendorID,
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
                            'CreatedOn'=>date('Y-m-d'),
                            'CreatedBy' => $CustomerID,
                        ];
                        $status = DB::table($this->currfyDB . 'tbl_order_details')->insert($data1);
                        if($status){
                            DocNum::updateDocNum(docTypes::OrderDetails->value,$this->currfyDB);
                        }
                    }
                }
            }else{
                return response()->json(['status' => false,'message' => "Quote already converted to Order!"]);
            }
            if($status){
                $status = DB::Table($this->currfyDB.'tbl_quotation')->where('QID',$req->QID)->update(['Status'=>'Accepted','AcceptedOn'=>date('Y-m-d'),'UpdatedOn'=>date('Y-m-d H:i:s')]);
                $status = DB::Table($this->currfyDB.'tbl_enquiry')->where('EnqID',$req->EnqID)->update(['Status'=>'Accepted','UpdatedOn'=>date('Y-m-d H:i:s')]);
            }
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
        ->leftJoin('tbl_customer_address as CA','CA.AID','O.AID');
        if($req->Status){
            $query->where('O.Status',$req->Status);
        }
        $OrderData=$query
        ->select('O.OrderID','O.OrderNo','O.OrderDate','O.ReceiverName','O.ReceiverMobNo','O.Status','O.TaxAmount','O.SubTotal','O.CGSTAmount','O.SGSTAmount','O.IGSTAmount','O.TotalAmount','O.AdditionalCost','O.NetAmount','O.isRated','O.DeliveredOn','O.ExpectedDelivery','O.PaymentStatus','CU.CompleteAddress as BillingAddress','CA.CompleteAddress as ShippingAddress')
        ->get();
        
        foreach($OrderData as $order){
            $order->TotalUnit = DB::table($this->currfyDB.'tbl_order_details')->where('OrderID',$order->OrderID)->sum('Qty');
            $order->ProductData = DB::table($this->currfyDB.'tbl_order_details as OD')
                ->leftJoin('tbl_products as P','P.ProductID','OD.ProductID')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'P.CID')
                ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
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
            $isOrderCompleted = DB::Table($this->currfyDB.'tbl_order')->where('OrderID',$req->OrderID)->where('Status','Delivered')->exists();
            if(!$isOrderCompleted){
                return response()->json(['status' => false,'message' => "Order is not Delivered!"]);
            }else{
                $status = DB::Table($this->currfyDB.'tbl_order')->where('OrderID',$req->OrderID)->update(['Ratings'=>$req->Ratings,'Review'=>$req->Review,'isRated'=>1,'RatedOn'=>date('Y-m-d'),'UpdatedOn'=>date('Y-m-d H:i:s')]);
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
                    ->where('VPM.Status',1)->where('P.CID',$row->PCID)->where('P.SCID',$item->PSCID)->WhereIn('VPM.VendorID',$AllVendors)
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
