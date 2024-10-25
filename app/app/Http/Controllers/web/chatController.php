<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Helper;
use general;
use chatApp;
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
}
