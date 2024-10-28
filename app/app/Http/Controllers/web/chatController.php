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
        $products = DB::table('tbl_products as P')->join('tbl_product_subcategory as PSC','PSC.PSCID','P.SCID')->join('tbl_product_category as PC','PC.PCID','PSC.PCID')->join('tbl_uom as UOM','UOM.UID','P.UID')
		->where('P.DFlag',0)->where('P.ActiveStatus','Active')
		->where('PSC.DFlag',0)->where('PSC.ActiveStatus','Active')
		->where('PC.DFlag',0)->where('PC.ActiveStatus','Active')
		->select('P.ProductName','P.ProductID','PC.PCID','PC.PCName','PSC.PSCID','PSC.PSCName','P.PRate','P.Description', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'))
		->take(10)
		->get();
		foreach ($products as $product) {
			$imageUrl = $product->ProductImage;
		
			$headers = @get_headers($imageUrl);
			if (!$headers || strpos($headers[0], '404') !== false) {
				$product->ProductImage = url('assets/images/no-image-b.png');
			}
		}
		
		$FormData['Products'] = $products;
		$FormData['PCategory'] = DB::table('tbl_product_category')->where('DFlag',0)->where('ActiveStatus','Active')->get();
		$FormData['PSCategory'] = DB::table('tbl_product_subcategory')->where('DFlag',0)->where('ActiveStatus','Active')->get();
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
		DB::Table($this->SupportDB."tbl_chat")->where('ChatID',$ChatID)->update(["isRead"=>1]);
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
			if($return[$i]->Type=="Attachments"){
				$return[$i]->Attachments=url('/'.$return[$i]->Attachments);
			}
			
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
				"Attachments"=>$req->attachments,
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
				}else if($req->type=="Attachment"){
					$LastMessage="sent a attachment file";
				}else if($req->type=="Quotation"){
					$LastMessage="sent a Quotattion";
				}else if($req->type=="Products"){
					$LastMessage="sent Products links";
				}
				$status=DB::Table($this->SupportDB.'tbl_chat')->where('ChatID',$ChatID)->update($data);
			}
			//event(new chatApp($req->message));
			$req->MessageID=$SLNO;
			$msg=$this->getChatHistory($req,$ChatID);
			event(new chatApp($req->messageTo,json_encode(["type"=>"load_message","message"=>$msg])));
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
	public function sendAttachment(Request $req,$ChatID){
		DB::beginTransaction();$SLNO="";
		$status=false;
		$LastMessageOn=now();
		
		$LastMessage="";
		try {
			
			$AttachmentURL="";
			$dir="uploads/chat/".$ChatID."/";
			if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
			if($req->hasFile('attachments')){
				$file = $req->file('attachments');
				$fileName=md5($file->getClientOriginalName() . time());
				$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
				$file->move($dir, $fileName1);  
				$AttachmentURL=$dir.$fileName1;
			}
			$SLNO=DocNum::getDocNum(docTypes::ChatMessage->value);
			$data=array(
				"SLNO"=>$SLNO,
				"ChatID"=>$ChatID,
				"SendFrom"=>$req->messageFrom,
				"SendTo"=>$req->messageTo,
				"Message"=>$req->message==""?"sent a attachment file":$req->message,
				"Attachments"=>$AttachmentURL,
				"Type"=>"Attachment",
				"CreatedOn"=>now(),
				"DeliveredOn"=>now()
			);
			$status=DB::Table($this->SupportDB.'tbl_chat_message')->insert($data);
			if($status){
				DocNum::updateDocNum(docTypes::ChatMessage->value);
				$data=[
					"isRead"=>0,
					"LastMessageOn"=>$LastMessageOn,
					"LastMessage"=>$req->message==""?"sent a attachment file":$req->message
				];
				$status=DB::Table($this->SupportDB.'tbl_chat')->where('ChatID',$ChatID)->update($data);
			}
			//event(new chatApp($req->message));
			$req->MessageID=$SLNO;
			$msg=$this->getChatHistory($req,$ChatID);
			event(new chatApp($req->messageTo,json_encode(["type"=>"load_message","message"=>$msg])));
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
	public function deleteChat(Request $req,$ChatID){
		DB::Table($this->SupportDB.'tbl_chat')->where('ChatID',$ChatID)->Update(['Status'=>'Deleted',"DeletedOn"=>now(),"DeletedBy"=>$this->UserID]);
	}
	public function blockChat(Request $req,$ChatID){
		DB::Table($this->SupportDB.'tbl_chat')->where('ChatID',$ChatID)->Update(['Status'=>'Blocked',"BlockedOn"=>now(),"BlockedBy"=>$this->UserID]);
	}
	public function unblockChat(Request $req,$ChatID){
		DB::Table($this->SupportDB.'tbl_chat')->where('ChatID',$ChatID)->Update(['Status'=>'Active',"UpdatedOn"=>now()]);
	}
}
