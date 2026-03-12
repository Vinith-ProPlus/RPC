<?php

namespace App\Http\Controllers\api;

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

class SupportAPIController extends Controller{
    private $generalDB;
    private $logDB;
    private $supportDB;
    private $FileTypes;
	private $UserID;
	private $ReferID;

    public function __construct(){
		$this->generalDB=Helper::getGeneralDB();
		$this->logDB=Helper::getLogDB();
		$this->supportDB=Helper::getSupportDB();
		$this->FileTypes=Helper::getFileTypes(array("category"=>array("Images","Documents")));
        $this->middleware('auth:api');
        $this->middleware(function ($request, $next) {
			$this->UserID=auth()->user()->UserID;
			$this->ReferID=auth()->user()->ReferID;
			return $next($request);
		});
    }

    public function CreateTicket(Request $req){
        DB::beginTransaction();
        $status=false;
        try {
            if($req->has('SupportID') && $req->SupportID){
                $SupportID = $req->SupportID;
                $status = true;
            }else{
                $SupportID=DocNum::getDocNum(docTypes::Support->value,"",Helper::getCurrentFY());
                $data=array(
                    "SupportID"=>$SupportID,
                    "UserID"=>$this->UserID,
                    "Subject"=>$req->Subject,
                    "TicketFor"=>$req->TicketFor,
                    "Priority"=>$req->Priority,
                    "SupportType"=>$req->SupportType,
                    "DFlag"=>0,
                    "CreatedOn"=>date("Y-m-d H:i:s"),
                    "CreatedBy"=>$this->UserID,
                );
                $status=DB::Table($this->supportDB."tbl_support")->insert($data);
            }

            if($status==true){
                $ReferID=DocNum::getDocNum(docTypes::SupportDetails->value,"",Helper::getCurrentFY());
                $data=array(
                    "SLNO"=>$ReferID,
                    "SupportID"=>$SupportID,
                    "UserID"=>$this->UserID,
                    "Description"=>$req->Description,
                    "DFlag"=>0,
                    "CreatedOn"=>date("Y-m-d H:i:s"),
                    "CreatedBy"=>$this->UserID
                );
                $status=DB::Table($this->supportDB."tbl_support_details")->insert($data);
                if($status==true){
                    DocNum::updateDocNum(docTypes::SupportDetails->value);

                    $Attachments = json_decode($req->Attachments);
                    // return $Attachments;
                    if (is_array($Attachments) && count($Attachments) > 0) {
                        foreach ($Attachments as $item) {
                            $dir = "uploads/support/".$SupportID."/";
                            if (!file_exists($dir)) {
                                mkdir($dir, 0777, true);
                            }

                            $file = $item->uploadPath;
                            $fileName = md5($item->fileName . time()) . "." . $item->ext;
                            $filepath = $dir . $fileName;
                            $FileSize = filesize($file);
                            $AttachmentID = DocNum::getDocNum(docTypes::SupportAttachments->value, "", Helper::getCurrentFY());
                            $data = array(
                                "AttachmentID" => $AttachmentID,
                                "ReferID" => $ReferID,
                                "Module" => "Support",
                                "FileSize" => $FileSize,
                                "UploadDir" => $dir,
                                "UploadFileName" => $fileName,
                                "UploadFileExt" => $item->ext,
                                "UploadUrl" => $filepath,
                                "UserID" => $this->UserID,
                                "CreatedOn" => date("Y-m-d H:i:s")
                            );
                            $status = DB::table($this->supportDB . "tbl_attachment")->insert($data);
                            if ($status == true) {
                                copy($file, $filepath);
                                DocNum::updateDocNum(docTypes::SupportAttachments->value);
                            }
                        }
                    }

                }
            }
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            if(!$req->SupportID){
                DocNum::updateDocNum(docTypes::Support->value);
            }
            return response()->json(['status' => true,'message' => "Support Ticket Sent Successfully"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Support Ticlet Send Failed!"]);
        }
    }

    public function GetTicket(Request $req){

        if($req->has('SupportID') && $req->SupportID){
            $SupportTickets = DB::table($this->supportDB.'tbl_support as S')
            ->leftJoin('users as U','U.UserID','S.UserID')
            ->leftJoin('tbl_support_type as ST','ST.SLNO','S.SupportType')
            ->where('S.UserID', $this->UserID)->where('S.DFlag', 0)->where('S.SupportID', $req->SupportID)
            ->select('S.SupportID','S.Subject','ST.SupportType','S.Priority','U.Name as CreatedBy','S.CreatedOn','S.Status', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(U.ProfileImage, ""), "assets/images/male-icon.png")) AS ProfileImage'))->first();
            
            $SupportTickets->SupportChat = DB::table($this->supportDB.'tbl_support_details as SD')
            ->leftJoin('users as U','U.UserID','SD.UserID')
            ->where('SD.SupportID',$SupportTickets->SupportID)
            ->orderBy('SD.CreatedOn')
            ->select('SD.Description','SD.SLNO','SD.CreatedOn','U.Name as CreatedBy', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(U.ProfileImage, ""), "assets/images/male-icon.png")) AS ProfileImage'))

            ->get();
            foreach($SupportTickets->SupportChat as $row){
                $row->Attachments = DB::table($this->supportDB.'tbl_attachment')->where('ReferID',$row->SLNO)->select(DB::raw('CONCAT("' . url('/') . '/", UploadUrl) AS FileName '))->get();
            }
            return response()->json(['status' => true,'data' => $SupportTickets]);
        }else{
            $pageNo = $req->PageNo ?? 1;
            $perPage = 15;
        
            $SupportTickets = DB::table($this->supportDB.'tbl_support as S')
            ->leftJoin('users as U','U.UserID','S.UserID')
            ->leftJoin('tbl_support_type as ST','ST.SLNO','S.SupportType')->where('S.UserID', $this->UserID)->where('S.DFlag', 0);
        
            if ($req->has('SearchText') && !empty($req->SearchText)) {
                $SupportTickets->where('S.Subject', 'like', '%' . $req->SearchText . '%');
            }
            if ($req->has('Status') && !empty($req->Status)) {
                $SupportTickets->where('S.Status', $req->Status);
            }
            if ($req->has('FromDate') && !empty($req->FromDate) && $req->has('ToDate') && !empty($req->ToDate)) {
                $fromDate = $req->FromDate . ' 00:00:00';
                $toDate = $req->ToDate . ' 23:59:59';
                $SupportTickets->whereBetween('S.CreatedOn', [$fromDate, $toDate]);
            }
            $result = $SupportTickets
            ->select('S.SupportID','S.Subject','ST.SupportType','S.Priority','U.Name as CreatedBy','S.CreatedOn','S.Status', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(U.ProfileImage, ""), "assets/images/male-icon.png")) AS ProfileImage'))
            ->paginate($perPage, ['*'], 'page', $pageNo);

            foreach($result as $item){
                $item->SupportChat = DB::table($this->supportDB.'tbl_support_details as SD')
                    ->leftJoin('users as U','U.UserID','SD.UserID')
                    ->where('SD.SupportID',$item->SupportID)
                    ->orderBy('SD.CreatedOn')

                    ->select('SD.Description','SD.SLNO','SD.CreatedOn','U.Name as CreatedBy', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(U.ProfileImage, ""), "assets/images/male-icon.png")) AS ProfileImage'))
                    ->get();
                    foreach($item->SupportChat as $row){
                        $row->Attachments = DB::table($this->supportDB.'tbl_attachment')->where('ReferID',$row->SLNO)->select(DB::raw('CONCAT("' . url('/') . '/", UploadUrl) AS FileName '))->get();
                    }
            }
            return response()->json(['status' => true,'data' => $result->items(),'CurrentPage' => $result->currentPage(),'LastPage' => $result->lastPage()]);
        }

    }


}