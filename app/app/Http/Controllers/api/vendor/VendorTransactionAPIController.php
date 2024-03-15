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
            ->join('tbl_products as P','P.ProductID','VQD.ProductID')
            ->join('tbl_tax as T', 'T.TaxID', 'P.TaxID')
            ->join('tbl_product_category as PC', 'PC.PCID', 'P.CID')
            ->join('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
            ->join('tbl_uom as U', 'U.UID', 'P.UID')
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
            // return $ProductData;
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

        $query = DB::table($this->currfyDB.'tbl_vendor_quotation as VQ')->join($this->currfyDB.'tbl_enquiry as E','E.EnqID','VQ.EnqID')
        ->where('VQ.VendorID',$VendorID);
        if(count($Status)>0){
            $query->whereIn('VQ.Status',$Status);
        }
        $QuoteReqData = $query->select('VQ.VQuoteID','E.EnqNo','VQ.QReqOn','VQ.TotalAmount','VQ.SubTotal','VQ.TaxAmount','VQ.LabourCost','VQ.TransportCost','VQ.AdditionalCost','VQ.QSentOn','VQ.Status')
        ->paginate($perPage, ['*'], 'page', $pageNo);

        foreach($QuoteReqData as $row){
            $row->ProductData = DB::table($this->currfyDB.'tbl_vendor_quotation_details as VQD')->leftJoin('tbl_vendors_product_mapping as VPM','VPM.ProductID','VQD.ProductID')
            ->join('tbl_products as P','P.ProductID','VQD.ProductID')
            ->join('tbl_tax as T', 'T.TaxID', 'P.TaxID')
            ->join('tbl_product_category as PC', 'PC.PCID', 'P.CID')
            ->join('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
            ->join('tbl_uom as U', 'U.UID', 'P.UID')
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

        $query = DB::table($this->currfyDB.'tbl_withdraw_request')->where('VendorID',$VendorID);
        if($req->Status){
            $query->whereIn('Status',$req->Status);
        }
        $TransactionHistory = $query->select('WithdrawID','ReqOn','ReqAmount','Status')
        ->orderBy('ReqOn','Desc')
        ->get();
        
        return response()->json([
            'status' => true,
            'data' => $TransactionHistory,
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

        $SettlementHistory = DB::table($this->currfyDB.'tbl_payments')->where('VendorID',$VendorID)
        // ->orderBy('ReqOn','Desc')
        ->get();

        return response()->json([
            'status' => true,
            'data' => $SettlementHistory,
        ]);
    }
    public function getTransactionHistoryPagination(Request $req){
        $VendorID = $this->ReferID;
        $pageNo = $req->PageNo ?? 1;
        $perPage = 10;

        $query = DB::table($this->currfyDB.'tbl_withdraw_request')->where('VendorID',$VendorID);
        if($req->Status){
            $query->whereIn('Status',$req->Status);
        }
        $TransactionHistory = $query->select('WithdrawID','ReqOn','ReqAmount','Status')
        ->orderBy('ReqOn','Desc')
        ->paginate($perPage, ['*'], 'page', $pageNo);
        
        return response()->json([
            'status' => true,
            'data' => $TransactionHistory->items(),
            'CurrentPage' => $TransactionHistory->currentPage(),
            'LastPage' => $TransactionHistory->lastPage(),
        ]);
    }
}
