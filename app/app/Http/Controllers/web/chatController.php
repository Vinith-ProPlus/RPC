<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Helper;
use general;
use App\Events\chatApp;
use DocNum;
use docTypes;
use Carbon\Carbon;
class chatController extends Controller{
	private $general;
	private $support;
	private $DocNum;
	private $UserID;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $logs;
	private $Settings;
    private $FY;
	private $FYDBName;
	private $generalDB;
    private $Menus;
	private $SupportDB;
    public function __construct(){
		$this->ActiveMenuName="Chat";
        $this->PageTitle="Chat";
        $this->middleware('auth');
		$this->SupportDB=Helper::getSupportDB();
		$this->generalDB=Helper::getGeneralDB();
		$this->middleware(function ($request, $next) {
			$this->UserID=auth()->user()->UserID;
			$this->general=new general($this->UserID,$this->ActiveMenuName);
			$this->Menus=$this->general->loadMenu();
			$this->CRUD=$this->general->getCrudOperations($this->ActiveMenuName);
			$this->Settings=$this->general->getSettings();
			return $next($request);
		});
    }
    public function chatView(Request $req){
        $FormData=$this->general->UserInfo;
        $FormData['ActiveMenuName']=$this->ActiveMenuName;
        $FormData['PageTitle']=$this->PageTitle;
        $FormData['menus']=$this->Menus;
        $FormData['crud']=$this->CRUD;
        return view('app.chat.chat',$FormData);
    }
	public function getChatList(Request $req){
		$sql ="SELECT C.ChatID, C.sendFrom as sendFromID, SF.Name as sendFromName, SF.MobileNumber, SF.Address, SF.PostalCodeID, PS.PostalCode, SF.CityID, CI.CityID, SF.TalukID, T.TalukName, SF.DistrictID, D.DistrictName, SF.StateID, S.StateName, SF.CountryID, CO.CountryID, C.sendTo, C.Status, C.LastMessage, C.LastMessageOn, C.isRead ";
		$sql.=" FROM ".$this->SupportDB."tbl_chat as C LEFT JOIN users as SF ON SF.UserID=C.sendFrom  LEFT JOIN ".$this->generalDB."tbl_cities as CI ON CI.CityID=SF.CityID ";
		$sql.=" LEFT JOIN ".$this->generalDB."tbl_taluks as T ON T.TalukID=SF.TalukID  LEFT JOIN ".$this->generalDB."tbl_districts as D ON D.DistrictID=SF.DistrictID ";
		$sql.=" LEFT JOIN ".$this->generalDB."tbl_states as S ON S.StateID=SF.StateID LEFT JOIN ".$this->generalDB."tbl_countries as CO ON CO.CountryID=SF.CountryID ";
		$sql.=" LEFT JOIN ".$this->generalDB."tbl_postalcodes as PS ON PS.PID=SF.PostalCodeID Where C.Status<>'Deleted'";
		$result=DB::SELECT($sql);
		for($i=0;$i<count($result);$i++){
			$LastMessageOnHuman=Carbon::parse($result[$i]->LastMessageOn)->diffForHumans();
			$result[$i]->LastMessageOnHuman = $LastMessageOnHuman;
		}
		return $result;
	}
	public function getAccountDetails(Request $req,$ChatID){
		$sql ="SELECT C.ChatID, C.sendFrom as sendFromID, SF.Name as sendFromName, SF.email, SF.MobileNumber, SF.Address, SF.PostalCodeID, PS.PostalCode, SF.CityID, CI.CityID, SF.TalukID, ";
		$sql.=" T.TalukName, SF.DistrictID, D.DistrictName, SF.StateID, S.StateName, SF.CountryID, CO.CountryName, C.sendTo, C.Status, C.LastMessage, C.LastMessageOn, ";
		$sql.=" C.isRead, SF.CreatedOn as RegisteredOn, C.SenderLastSeenOn, C.AdminLastSeenOn ";
		$sql.=" FROM ".$this->SupportDB."tbl_chat as C LEFT JOIN users as SF ON SF.UserID=C.sendFrom  LEFT JOIN ".$this->generalDB."tbl_cities as CI ON CI.CityID=SF.CityID ";
		$sql.=" LEFT JOIN ".$this->generalDB."tbl_taluks as T ON T.TalukID=SF.TalukID  LEFT JOIN ".$this->generalDB."tbl_districts as D ON D.DistrictID=SF.DistrictID ";
		$sql.=" LEFT JOIN ".$this->generalDB."tbl_states as S ON S.StateID=SF.StateID LEFT JOIN ".$this->generalDB."tbl_countries as CO ON CO.CountryID=SF.CountryID ";
		$sql.=" LEFT JOIN ".$this->generalDB."tbl_postalcodes as PS ON PS.PID=SF.PostalCodeID Where C.Status<>'Deleted' AND C.ChatID='".$ChatID."'";
		$result=DB::SELECT($sql);
		for($i=0;$i<count($result);$i++){
			$RegisteredOnHuman=Carbon::parse($result[$i]->RegisteredOn)->diffForHumans();
			$RegisteredOnHuman=trim(str_replace("ago","",$RegisteredOnHuman));
			$result[$i]->RegisteredOnHuman = $RegisteredOnHuman;
			$result[$i]->SenderLastSeenOnHuman = Carbon::parse($result[$i]->SenderLastSeenOn)->diffForHumans();
			$result[$i]->AdminLastSeenOnHuman = Carbon::parse($result[$i]->AdminLastSeenOn)->diffForHumans();
		}
		return $result;
	}
	public function getChatHistory(Request $req, $ChatID){
		$sql1 ="SELECT *, 'sender' as MType FROM ".$this->SupportDB."tbl_chat_message  WHERE SendTo='Admin' AND Status<>'Deleted' AND ChatID='".$ChatID."'";
		$sql1.=" UNION ";
		$sql1.=" SELECT *, 'reply' as MType FROM ".$this->SupportDB."tbl_chat_message  WHERE SendFrom='Admin' AND Status<>'Deleted' AND ChatID='".$ChatID."'";

		$sql =" SELECT * FROM (".$sql1.") as T  Where 1=1 ";
		if($req->MessageID!=""){
			$sql.=" AND SLNO='".$req->MessageID."'";
		}
		$sql.=" Order By CreatedOn asc";
		$return= DB::SELECT($sql);
		for($i=0;$i<count($return);$i++){
			
			$MsgOnHuman=Carbon::parse($return[$i]->CreatedOn)->diffForHumans();
			$MsgOnHuman=str_replace('minutes','min',$MsgOnHuman);
			$MsgOnHuman=str_replace('seconds','sec',$MsgOnHuman);
			$MsgOnHuman=str_replace('hours','hrs',$MsgOnHuman);
			$MsgOnHuman=str_replace('months','mos',$MsgOnHuman);
			$MsgOnHuman=str_replace('years','yrs',$MsgOnHuman);
			$MsgOnHuman=trim(str_replace('ago','',$MsgOnHuman));
			$return[$i]->CreatedOnHuman=$MsgOnHuman;
		}
		return $return;
	}
	public function sendMessage(Request $req,$ChatID){
		DB::beginTransaction();$SLNO="";
		$status=false;
		$LastMessageOn=now();
		
		$LastMessage="";
		try {
			$SLNO=DocNum::getDocNum(docTypes::ChatMessage->value);
			$data=array(
				"SLNO"=>$SLNO,
				"ChatID"=>$ChatID,
				"SendFrom"=>$req->messageFrom,
				"SendTo"=>$req->messageTo,
				"Message"=>$req->message,
				"Type"=>$req->type,
				"CreatedOn"=>now(),
				"DeliveredOn"=>now()
			);
			$status=DB::Table($this->SupportDB.'tbl_chat_message')->insert($data);
			if($status){
				DocNum::updateDocNum(docTypes::ChatMessage->value);
				$data=[
					"isRead"=>0,
					"LastMessageOn"=>$LastMessageOn,
				];
				if($req->type=="Text"){
					$data['LastMessage']=$req->message;
					$LastMessage=$req->message;
				}
				$status=DB::Table($this->SupportDB.'tbl_chat')->where('ChatID',$ChatID)->update($data);
			}
			//event(new chatApp($req->message));
			event(new chatApp($req->messageTo,"load_message"));
		}catch(Exception $e) {
			$status=false;
		}
		if($status==true){
			DB::commit();
			
		}else{
			DB::rollback();
		}
		return ['status'=>$status,"SLNO"=>$SLNO,"LastMessage"=>$LastMessage,"LastMessageOn"=>$LastMessageOn,"LastMessageOnHuman"=>Carbon::parse($LastMessageOn)->diffForHumans()];
	}
}
