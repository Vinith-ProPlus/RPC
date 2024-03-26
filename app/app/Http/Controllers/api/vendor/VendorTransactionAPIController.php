<?php

namespace App\Http\Controllers\api\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use Auth;
use Helper;
use activeMenuNames;
use ValidUnique;
use ValidDB;
use DocNum;
use docTypes;
use logs;
use PHPUnit\TextUI\Help;

class VendorTransactionAPIController extends Controller{
    private $generalDB;
    private $logDB;
    private $currfyDB;
    private $tmpDB;
    private $ActiveMenuName;
    private $FileTypes;
	private $UserID;
	private $ReferID;

    public function __construct(){
		$this->generalDB=Helper::getGeneralDB();
		$this->logDB=Helper::getLogDB();
		$this->currfyDB=Helper::getCurrFYDB();
		$this->tmpDB=Helper::getTmpDB();
        $this->ActiveMenuName=activeMenuNames::Vendors->value;
		$this->FileTypes=Helper::getFileTypes(array("category"=>array("Images","Documents")));
        $this->middleware('auth:api');
        $this->middleware(function ($request, $next) {
			$this->UserID=auth()->user()->UserID;
			$this->ReferID=auth()->user()->ReferID;
			return $next($request);
		});
    }

    public function getQuoteRequest(Request $req){
        $VendorID = $this->ReferID;
        $pageNo = $req->PageNo ?? 1;
        $perPage = 10;

        $QuoteReqData = DB::table($this->currfyDB.'tbl_vendor_quotation as VQ')
        ->leftJoin($this->currfyDB.'tbl_enquiry as E','E.EnqID','VQ.EnqID')
        ->leftJoin('tbl_vendors as V','V.VendorID','VQ.VendorID')
        ->where('VQ.VendorID',$VendorID)->where('VQ.Status','Requested')
        ->select('VQ.VQuoteID','E.EnqNo','V.CommissionPercentage')
        ->paginate($perPage, ['*'], 'page', $pageNo);

        foreach($QuoteReqData as $row){
            $row->ProductData = DB::table($this->currfyDB.'tbl_vendor_quotation_details as VQD')->leftJoin('tbl_vendors_product_mapping as VPM','VPM.ProductID','VQD.ProductID')
            ->leftJoin('tbl_products as P','P.ProductID','VQD.ProductID')
            ->leftJoin('tbl_tax as T', 'T.TaxID', 'P.TaxID')
            ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'P.CID')
            ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
            ->leftJoin('tbl_uom as U', 'U.UID', 'P.UID')
            ->where('P.ActiveStatus', 'Active')->where('P.DFlag', 0)->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
            ->where('VQD.VQuoteID',$row->VQuoteID)->where('VQD.Status',NULL)
            ->where('VPM.VendorID',$VendorID)
            ->select('VQD.DetailID','P.ProductName','P.ProductID','VQD.Qty', 'PC.PCName', 'PC.PCID', 'PSC.PSCName','U.UName','U.UCode','U.UID', 'PSC.PSCID','VPM.VendorPrice','P.TaxType','P.TaxID','T.TaxPercentage','T.TaxName')
            ->get();
        }
        
        return response()->json([
            'status' => true,
            'data' => $QuoteReqData->items(),
            'CurrentPage' => $QuoteReqData->currentPage(),
            'LastPage' => $QuoteReqData->lastPage(),
        ]);
    }

    public function AddQuotePrice(Request $req){
        $VendorID = $this->ReferID;
		DB::beginTransaction();
        try {
            $OldData=$NewData=[];
            $ProductData = json_decode($req->ProductData);
            if($req->isImageQuote){
                $data=[
                    'SubTotal'=>$req->SubTotal,
                    'TaxAmount'=>$req->TaxAmount,
                    'TotalAmount'=>$req->TotalAmount,
                    'LabourCost'=>$req->LabourCost,
                    'TransportCost'=>$req->TransportCost,
                    'AdditionalCost'=>$req->AdditionalCost,
                    'Status' => 'Sent',
                    'QSentOn'=>date('Y-m-d'),
                    'UpdatedBy'=>$VendorID,
                    'UpdatedOn'=>date('Y-m-d H:i:s')
                ];
                $status = DB::Table($this->currfyDB.'tbl_vendor_quotation')->where('VendorID',$VendorID)->where('VQuoteID',$req->VQuoteID)->update($data);
                if($status){
                    foreach($ProductData as $item){
                        $PDetails= DB::table('tbl_products as P')->leftJoin('tbl_tax as T', 'T.TaxID', 'P.TaxID')->where('ProductID',$item->ProductID)->first();
                        $data=[
                            'Taxable'=>$item->Taxable,
                            'TaxAmt'=>$item->TaxAmt,
                            'TaxID'=>$PDetails->TaxID,
                            'TaxPer'=>$PDetails->TaxPercentage,
                            'TaxType'=>$PDetails->TaxType,
                            'TotalAmt'=>$item->TotalAmt,
                            'Price'=>$item->Price,
                            'Status'=>'Price Sent',
                            'UpdatedBy'=>$VendorID,
                            'UpdatedOn'=>date('Y-m-d H:i:s')
                        ];
                        $status = DB::Table($this->currfyDB.'tbl_vendor_quotation_details')->where('VQuoteID',$req->VQuoteID)->where('ProductID',$item->ProductID)->update($data);
                    }
                }
            }else{
                $data=[
                    'SubTotal'=>$req->SubTotal,
                    'TaxAmount'=>$req->TaxAmount,
                    'TotalAmount'=>$req->TotalAmount,
                    'LabourCost'=>$req->LabourCost,
                    'TransportCost'=>$req->TransportCost,
                    'AdditionalCost'=>$req->AdditionalCost,
                    'Status' => 'Sent',
                    'QSentOn'=>date('Y-m-d'),
                    'UpdatedBy'=>$VendorID,
                    'UpdatedOn'=>date('Y-m-d H:i:s')
                ];
                $status = DB::Table($this->currfyDB.'tbl_vendor_quotation')->where('VendorID',$VendorID)->where('VQuoteID',$req->VQuoteID)->update($data);
                if($status){
                    foreach($ProductData as $item){
                        $PDetails= DB::table('tbl_products as P')->leftJoin('tbl_tax as T', 'T.TaxID', 'P.TaxID')->where('ProductID',$item->ProductID)->first();
                        $data=[
                            'Taxable'=>$item->Taxable,
                            'TaxAmt'=>$item->TaxAmt,
                            'TaxID'=>$PDetails->TaxID,
                            'TaxPer'=>$PDetails->TaxPercentage,
                            'TaxType'=>$PDetails->TaxType,
                            'TotalAmt'=>$item->TotalAmt,
                            'Price'=>$item->Price,
                            'Status'=>'Price Sent',
                            'UpdatedBy'=>$VendorID,
                            'UpdatedOn'=>date('Y-m-d H:i:s')
                        ];
                        $status = DB::Table($this->currfyDB.'tbl_vendor_quotation_details')->where('VQuoteID',$req->VQuoteID)->where('ProductID',$item->ProductID)->update($data);
                    }
                }
            }
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            $NewData=DB::table($this->currfyDB.'tbl_vendor_quotation_details')->where('VQuoteID',$req->VQuoteID)->get();
            $logData=array("Description"=>"Vendor Quote Price Updated","ModuleName"=>"Vendor Product Mapping","Action"=>"Add","ReferID"=>$VendorID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$VendorID,"IP"=>$req->ip());
            logs::Store($logData);
            return response()->json(['status' => true ,'message' => "Quote Price Updated Successfully!"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Quote Price Update Failed!"]);
        }
	}
    public function AddQuotePriceOld(Request $req){
        $VendorID = $this->ReferID;
		DB::beginTransaction();
        try {
            $OldData=$NewData=[];
            $ProductData = json_decode($req->ProductData);
            $data=[
                'SubTotal'=>$req->SubTotal,
                'TaxAmount'=>$req->TaxAmount,
                'TotalAmount'=>$req->TotalAmount,
                'LabourCost'=>$req->LabourCost,
                'TransportCost'=>$req->TransportCost,
                'AdditionalCost'=>$req->AdditionalCost,
                'Status' => 'Sent',
                'QSentOn'=>date('Y-m-d'),
                'UpdatedBy'=>$VendorID,
                'UpdatedOn'=>date('Y-m-d H:i:s')
            ];
            $status = DB::Table($this->currfyDB.'tbl_vendor_quotation')->where('VendorID',$VendorID)->where('VQuoteID',$req->VQuoteID)->update($data);
            if($status){
                foreach($ProductData as $item){
                    $PDetails= DB::table('tbl_products as P')->leftJoin('tbl_tax as T', 'T.TaxID', 'P.TaxID')->where('ProductID',$item->ProductID)->first();
                    $data=[
                        'Taxable'=>$item->Taxable,
                        'TaxAmt'=>$item->TaxAmt,
                        'TaxID'=>$PDetails->TaxID,
                        'TaxPer'=>$PDetails->TaxPercentage,
                        'TaxType'=>$PDetails->TaxType,
                        'TotalAmt'=>$item->TotalAmt,
                        'Price'=>$item->Price,
                        'Status'=>'Price Sent',
                        'UpdatedBy'=>$VendorID,
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
            $logData=array("Description"=>"Vendor Quote Price Updated","ModuleName"=>"Vendor Product Mapping","Action"=>"Add","ReferID"=>$VendorID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$VendorID,"IP"=>$req->ip());
            logs::Store($logData);
            return response()->json(['status' => true ,'message' => "Quote Price Updated Successfully!"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Quote Price Update Failed!"]);
        }
	}

    public function RejectQuote(Request $req){
        $VendorID = $this->ReferID;
		DB::beginTransaction();
        try {
            $status = DB::Table($this->currfyDB.'tbl_vendor_quotation')->where('VendorID',$VendorID)->where('VQuoteID',$req->VQuoteID)->update(['Status'=>'Rejected','UpdatedOn'=>date('Y-m-d H:i:s')]);
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
    public function getAllQuotations(Request $req){
        $VendorID = $this->ReferID;
        $Status = json_decode($req->Status) ?? [];
        $pageNo = $req->PageNo ?? 1;
        $perPage = 10;

        $query = DB::table($this->currfyDB.'tbl_vendor_quotation as VQ')->leftJoin($this->currfyDB.'tbl_enquiry as E','E.EnqID','VQ.EnqID')
        ->where('VQ.VendorID',$VendorID);
        if(count($Status)>0){
            $query->whereIn('VQ.Status',$Status);
        }
        $QuoteReqData = $query->select('VQ.VQuoteID','E.EnqNo','VQ.QReqOn','VQ.TotalAmount','VQ.SubTotal','VQ.TaxAmount','VQ.LabourCost','VQ.TransportCost','VQ.AdditionalCost','VQ.QSentOn','VQ.Status','VQ.isImageQuote',DB::raw('CONCAT("' . url('/') . '/", VQ.QuoteImage) AS QuoteImage'))
        ->paginate($perPage, ['*'], 'page', $pageNo);

        foreach($QuoteReqData as $row){
            $row->ProductData = DB::table($this->currfyDB.'tbl_vendor_quotation_details as VQD')->leftJoin('tbl_vendors_product_mapping as VPM','VPM.ProductID','VQD.ProductID')
            ->leftJoin('tbl_products as P','P.ProductID','VQD.ProductID')
            ->leftJoin('tbl_tax as T', 'T.TaxID', 'P.TaxID')
            ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'P.CID')
            ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
            ->leftJoin('tbl_uom as U', 'U.UID', 'P.UID')
            ->where('P.ActiveStatus', 'Active')->where('P.DFlag', 0)->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
            ->where('VQD.VQuoteID',$row->VQuoteID)
            ->where('VPM.VendorID',$VendorID)
            ->select('VQD.DetailID','VQD.Taxable','VQD.TaxAmt','VQD.TotalAmt','P.ProductName','P.ProductID','VQD.Qty', 'PC.PCName', 'PC.PCID', 'PSC.PSCName','U.UName','U.UCode','U.UID', 'PSC.PSCID','VPM.VendorPrice','VQD.Price','P.TaxType','P.TaxID','T.TaxPercentage','T.TaxName')
            ->get();
        }
        
        return response()->json([
            'status' => true,
            'data' => $QuoteReqData->items(),
            'CurrentPage' => $QuoteReqData->currentPage(),
            'LastPage' => $QuoteReqData->lastPage(),
        ]);
    }
    public function getOrders(Request $req){
        $VendorID = $this->ReferID;
        $Status = json_decode($req->Status) ?? [];
        $pageNo = $req->PageNo ?? 1;
        $perPage = 10;

        $query = DB::table($this->currfyDB.'tbl_vendor_orders as VO')->leftJoin($this->currfyDB.'tbl_order as O','O.OrderID','VO.OrderID');
        // ->where('VO.VendorID',$VendorID);
        if(count($Status)>0){
            $query->whereIn('VO.Status',$Status);
        }
        $OrderData = $query->select('VO.VOrderID','O.OrderID','O.OrderNo','O.OrderDate','O.ExpectedDelivery','O.ReceiverName','O.ReceiverMobNo','VO.TotalAmount','VO.SubTotal','VO.TaxAmount','VO.NetAmount','VO.AdditionalCost','VO.Status')->paginate($perPage, ['*'], 'page', $pageNo);

        foreach($OrderData as $row){
            $row->TotalUnit = DB::table($this->currfyDB.'tbl_order_details')->whereNot('Status','Cancelled')->where('OrderID',$row->OrderID)->sum('Qty');
            $row->ProductData = DB::table($this->currfyDB.'tbl_order_details as OD')
            ->leftJoin('tbl_products as P','P.ProductID','OD.ProductID')
            ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'P.CID')
            ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
            ->leftJoin('tbl_uom as U', 'U.UID', 'P.UID')
            ->where('P.ActiveStatus', 'Active')->where('P.DFlag', 0)
            ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
            ->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
            ->where('OD.OrderID',$row->OrderID)
            ->whereNot('Status','Cancelled')
            ->select('OD.DetailID','OD.Taxable','OD.TaxAmt','OD.TotalAmt','P.ProductName','P.ProductID','OD.Qty', 'PC.PCName', 'PC.PCID', 'PSC.PSCName','U.UName','U.UCode','U.UID', 'PSC.PSCID','OD.Price','OD.Status')
            ->get();
        }
        
        return response()->json([
            'status' => true,
            'data' => $OrderData->items(),
            'CurrentPage' => $OrderData->currentPage(),
            'LastPage' => $OrderData->lastPage(),
        ]);
    }
    public function MarkasDelivered(Request $req){
        $VendorID = $this->ReferID;
		DB::beginTransaction();
        try {
            $OrderData =DB::table($this->currfyDB.'tbl_vendor_orders as VO')
                ->leftJoin($this->currfyDB.'tbl_order_details as OD','OD.VOrderID','VO.VOrderID')
                ->leftJoin($this->currfyDB.'tbl_order as O','O.OrderID','VO.OrderID')
                ->leftJoin('tbl_products as P','P.ProductID','OD.ProductID')
                ->where('VO.VOrderID',$req->VOrderID)->where('OD.Status','New')
                ->select('O.OrderNo','O.CustomerID','P.ProductName')
                ->get();

            $OTP=Helper::getOTP(6);
            $status=DB::Table($this->currfyDB."tbl_order_details")->where('VOrderID',$req->VOrderID)->Where('Status','New')->update(['OTP'=>$OTP,"UpdatedOn"=>now(),"UpdatedBy"=>$VendorID]);
            if($status){
                $Title = "Order No " . $OrderData[0]->OrderNo . " marked as delivered";
                $Message = $OTP." is OTP for Delivered Products: ";
                foreach($OrderData as $index => $item) {
                    $Message .= $item->ProductName;
                    if ($index < count($OrderData) - 1) {
                        $Message .= ", ";
                    }
                }
                $Message .= ".";
                Helper::saveNotification($OrderData[0]->CustomerID,$Title,$Message,'Order',$req->VOrderID);
                Helper::sendNotification($OrderData[0]->CustomerID,$Title,$Message);
            }
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            return response()->json(['status' => true ,'message' => "OTP Sent to Customer Successfully!"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Quote Sent Failed!"]);
        }
	}
    public function Delivered(Request $req){
        $VendorID = $this->ReferID;
		DB::beginTransaction();
        try {
            $ExistingOTP =DB::table($this->currfyDB.'tbl_order_details')->where('VOrderID',$req->VOrderID)->where('Status','New')->value('OTP');
            if($ExistingOTP != $req->OTP){
                return response()->json(['status' => false,'message' => "The OTP verification has failed. Please enter the correct OTP."]);
            }else{
                $status = DB::table($this->currfyDB.'tbl_order_details')->where('VOrderID',$req->VOrderID)->where('Status','New')->where('OTP',$req->OTP)->update(['Status'=>'Delivered','DeliveredOn'=>now(),'DeliveredBy'=>$VendorID,'UpdatedOn'=>now(),'UpdatedBy'=>$VendorID]);
                if($status){
                    $status=DB::Table($this->currfyDB."tbl_vendor_orders")->where('VOrderID',$req->VOrderID)->update(['Status'=>'Delivered',"UpdatedOn"=>now(),"UpdatedBy"=>$VendorID]);
                }
                $AllProducts = DB::table($this->currfyDB.'tbl_order_details')->where('OrderID',$req->OrderID)->whereNot('Status','Cancelled')->count();
                $DeliveredProducts = DB::table($this->currfyDB.'tbl_order_details')->where('OrderID',$req->OrderID)->where('Status','Delivered')->count();
                if($AllProducts == $DeliveredProducts){
                    $status = DB::table($this->currfyDB.'tbl_order')->where('OrderID',$req->OrderID)->update(['Status'=>'Delivered','DeliveredOn'=>now(),'UpdatedOn'=>now(),'UpdatedBy'=>$VendorID]);
                }else{
                    $status = DB::table($this->currfyDB.'tbl_order')->where('OrderID',$req->OrderID)->update(['Status'=>'Partially Delivered','UpdatedOn'=>now(),'UpdatedBy'=>$VendorID]);
                }
            }
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            return response()->json(['status' => true ,'message' => "Order Delivered Successfully!"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Order Deliver Failed!"]);
        }
	}

    public function RequestPayment(Request $req){
        $VendorID = $this->ReferID;
		DB::beginTransaction();
        try {
            $OldData=$NewData=[];
            $WithdrawID = DocNum::getDocNum(docTypes::Withdraw->value,$this->currfyDB,Helper::getCurrentFY());

            $data=[
                'WithdrawID'=>$WithdrawID,
                'VendorID'=>$VendorID,
                'ReqAmount'=>$req->ReqAmount,
                'ReqOn'=>date('Y-m-d H:i:s'),
                'CreatedBy'=>$VendorID,
                "CreatedOn"=>date("Y-m-d H:i:s")
            ];
            $status = DB::Table($this->currfyDB.'tbl_withdraw_request')->insert($data);
            
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            DocNum::updateDocNum(docTypes::Withdraw->value,$this->currfyDB);
            $NewData=DB::table($this->currfyDB.'tbl_withdraw_request')->where('WithdrawID',$WithdrawID)->get();
            $logData=array("Description"=>"Vendor Payment Requested","ModuleName"=>"Payment","Action"=>"Add","ReferID"=>$WithdrawID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$VendorID,"IP"=>$req->ip());
            logs::Store($logData);
            return response()->json(['status' => true ,'message' => "Payment Requested Successfully!"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Payment Request Failed!"]);
        }
	}
    public function getTransactionHistory(Request $req){
        $VendorID = $this->ReferID;
        $TransactionHistory = DB::table($this->currfyDB.'tbl_vendor_orders as VO')
        ->leftJoin($this->currfyDB.'tbl_order as O','O.OrderID','VO.OrderID')
        ->where('VO.VendorID',$VendorID)
        ->where('VO.Status','Delivered')
        ->select('VO.VOrderID','O.OrderNo','VO.OrderDate','VO.DeliveredOn','VO.NetAmount')
        ->get();
        $Overall = DB::table($this->currfyDB.'tbl_vendor_orders as VO')->where('VO.VendorID',$VendorID)->where('Status','Delivered')->sum('NetAmount');
        return response()->json([
            'status' => true,
            'data' => ['TransactionHistory'=>$TransactionHistory,'OverAll'=>$Overall],
        ]);
    }
    public function getWithdrawalRequest(Request $req){
        $VendorID = $this->ReferID;

        $query = DB::table($this->currfyDB.'tbl_withdraw_request')->where('VendorID',$VendorID);
        if($req->Status){
            $query->whereIn('Status',$req->Status);
        }
        $WithdrawalRequest = $query->select('WithdrawID','ReqOn','ReqAmount','Status')
        ->orderBy('ReqOn','Desc')
        ->get();
        
        return response()->json([
            'status' => true,
            'data' => $WithdrawalRequest,
        ]);
    }
    public function getSettlementHistory(Request $req){ 
        $VendorID = $this->ReferID;

        $SettlementHistory = DB::table($this->currfyDB.'tbl_payments')
        // ->where('LedgerID',$VendorID)
        // ->orderBy('ReqOn','Desc')
        ->get();

        return response()->json([
            'status' => true,
            'data' => $SettlementHistory,
        ]);
    }
}
