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
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Exception\MessagingException;
use logs;
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
    private $CurrFYDB;

    public function __construct(){
		$this->ActiveMenuName="Chat";
        $this->PageTitle="Chat";
        $this->middleware('auth');
		$this->SupportDB=Helper::getSupportDB();
		$this->generalDB=Helper::getGeneralDB();
		$this->CurrFYDB=Helper::getCurrFYDB();
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
        $products = DB::table('tbl_products as P')
			->join('tbl_product_subcategory as PSC','PSC.PSCID','P.SCID')
			->join('tbl_product_category as PC','PC.PCID','PSC.PCID')
			->join('tbl_uom as UOM','UOM.UID','P.UID')
			->where('P.DFlag',0)->where('P.ActiveStatus','Active')
			->where('PSC.DFlag',0)->where('PSC.ActiveStatus','Active')
			->where('PC.DFlag',0)->where('PC.ActiveStatus','Active')
			->select('P.ProductName','P.ProductID','PC.PCID','PC.PCName','PSC.PSCID','PSC.PSCName','P.PRate','P.Description','UOM.UName','UOM.UCode', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'))
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
		$sql ="SELECT C.ChatID, C.sendFrom as sendFromID, SF.Name as sendFromName, SF.MobileNumber, SF.Address, SF.PostalCodeID, PS.PostalCode, SF.CityID, CI.CityID, SF.TalukID, T.TalukName, SF.DistrictID, D.DistrictName, SF.StateID, S.StateName, SF.CountryID, CO.CountryID, C.sendTo, C.Status, C.LastMessage, C.LastMessageOn, C.isRead, C.isAdminRead ";
		$sql.=" FROM ".$this->SupportDB."tbl_chat as C LEFT JOIN users as SF ON SF.UserID=C.sendFrom  LEFT JOIN ".$this->generalDB."tbl_cities as CI ON CI.CityID=SF.CityID ";
		$sql.=" LEFT JOIN ".$this->generalDB."tbl_taluks as T ON T.TalukID=SF.TalukID  LEFT JOIN ".$this->generalDB."tbl_districts as D ON D.DistrictID=SF.DistrictID ";
		$sql.=" LEFT JOIN ".$this->generalDB."tbl_states as S ON S.StateID=SF.StateID LEFT JOIN ".$this->generalDB."tbl_countries as CO ON CO.CountryID=SF.CountryID ";
		$sql.=" LEFT JOIN ".$this->generalDB."tbl_postalcodes as PS ON PS.PID=SF.PostalCodeID Where C.Status<>'Deleted' AND C.isAdminChat = 1";
		$result=DB::SELECT($sql);
		for($i=0;$i<count($result);$i++){
			$LastMessageOnHuman=Carbon::parse($result[$i]->LastMessageOn)->diffForHumans();
			$result[$i]->LastMessageOnHuman = $LastMessageOnHuman;
		}
		return $result;
	}
	public function getAccountDetails(Request $req,$ChatID){
		$sql ="SELECT C.ChatID, C.sendFrom as sendFromID, SF.Name as sendFromName, SF.ReferID as CustomerID, SF.LoginType, SF.email, SF.MobileNumber, SF.Address, SF.PostalCodeID, PS.PostalCode, SF.CityID, CI.CityID, SF.TalukID, ";
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
			$result[$i]->SAddress = DB::table('tbl_customer_address as CA')
				->join($this->generalDB.'tbl_countries as C','C.CountryID','CA.CountryID')
				->join($this->generalDB.'tbl_states as S', 'S.StateID', 'CA.StateID')
				->join($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'CA.DistrictID')
				->join($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
				->join($this->generalDB.'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
				->join($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
				->where('CA.CustomerID',$result[$i]->CustomerID)
				->select('CA.AID', 'CA.Address', 'CA.Latitude', 'CA.Longitude', 'CA.isDefault', 'CA.CountryID', 'C.CountryName', 'CA.StateID', 'S.StateName', 'CA.DistrictID', 'D.DistrictName', 'CA.TalukID', 'T.TalukName', 'CA.CityID', 'CI.CityName', 'CA.PostalCodeID', 'PC.PostalCode')
				// ->take(3)
				->get();
		}
		return $result;
	}
	public function getChatHistory(Request $req, $ChatID){
        $pageLimit = (int)$req->pageLimit ?: 20; // Default records per page
        $pageNo = (int)$req->pageNo ?: 1; // Default to page 1 if not specified
        $offset = ($pageNo - 1) * $pageLimit;// Calculate the offset

		$totalChats = DB::Table($this->SupportDB."tbl_chat_message")->where("ChatID",$ChatID)->count();
		$isLoadMore = ($offset + $pageLimit) < $totalChats;

		$tdata=[];
		if(auth()->user()->LoginType=="Admin"){
			$tdata['adminLastSeenOn']=now();
			$tdata['isAdminRead']=1;
		}else{
			$tdata['isRead']=1;
			$tdata['senderLastSeenOn']=now();
			event(new chatApp('Admin',json_encode(["type"=>"update_last_seen","message"=>now(),"ChatID"=>$ChatID])));
		}
		DB::Table($this->SupportDB."tbl_chat")->where('ChatID',$ChatID)->update($tdata);

		$sql1 ="SELECT *, 'sender' as MType FROM ".$this->SupportDB."tbl_chat_message  WHERE SendTo='Admin' AND Status<>'Deleted' AND ChatID='".$ChatID."'";
		$sql1.=" UNION ";
		$sql1.=" SELECT *, 'reply' as MType FROM ".$this->SupportDB."tbl_chat_message  WHERE SendFrom='Admin' AND Status<>'Deleted' AND ChatID='".$ChatID."'";

		$sql =" SELECT * FROM (".$sql1.") as T  Where 1=1 ";
		if($req->MessageID!=""){
			$sql.=" AND SLNO='".$req->MessageID."'";
		}
        if ($req->searchText != "") {
            $sql .= " AND Message LIKE '%".$req->searchText."%'";
        }
		$sql.=" Order By CreatedOn desc";
		$sql.=" LIMIT $offset, $pageLimit";
		$return= DB::SELECT($sql);
		for($i=0;$i<count($return);$i++){
			if($return[$i]->Type=="Attachment"){
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
		return ["chat"=>$return,"isLoadMore"=>$isLoadMore,"totalChats"=>$totalChats];
	}
	private function getChatMessage($ChatID,$MessageID){
		$sql1 ="SELECT *, 'sender' as MType FROM ".$this->SupportDB."tbl_chat_message  WHERE SendTo='Admin' AND Status<>'Deleted' AND ChatID='".$ChatID."'";
		$sql1.=" UNION ";
		$sql1.=" SELECT *, 'reply' as MType FROM ".$this->SupportDB."tbl_chat_message  WHERE SendFrom='Admin' AND Status<>'Deleted' AND ChatID='".$ChatID."'";

		$sql =" SELECT * FROM (".$sql1.") as T  Where 1=1 ";
		if($MessageID!=""){
			$sql.=" AND SLNO='".$MessageID."'";
		}
		$return= DB::SELECT($sql);
        logger("json_encode(return)");
        logger(json_encode($return));
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
        logger(json_encode($req->all()));
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
            if(isset($req->isAdminChat) && ($req->isAdminChat === "1")){
                DB::Table($this->SupportDB.'tbl_chat')->where('ChatID', $ChatID)->update(['isAdminChat' => 1]);
            }
            logger("data");
            logger($data);
			$status=DB::Table($this->SupportDB.'tbl_chat_message')->insert($data);
			if($status){
				DocNum::updateDocNum(docTypes::ChatMessage->value);
				$data=[
					"isRead"=>$req->messageFrom=="Admin"?0:1,
					"isAdminRead"=>$req->messageFrom=="Admin"?1:0,
					"LastMessageOn"=>$LastMessageOn,
				];
				if($req->messageFrom=="Admin"){
					$data['adminLastSeenOn']=now();
				}else{
					$data['senderLastSeenOn']=now();
				}
				if($req->type=="Text"){
					$LastMessage=$req->message;
				}else if($req->type=="Attachment"){
					$LastMessage="sent a attachment file";
				}else if($req->type=="Quotation"){
					$LastMessage="sent a Quotattion";
				}else if($req->type=="Products"){
					$data['LastMessage']=$req->message;
					$LastMessage="sent Products links";
				}
				$data['LastMessage']=$LastMessage;
				$status=DB::Table($this->SupportDB.'tbl_chat')->where('ChatID',$ChatID)->update($data);
				event(new chatApp($req->messageTo,json_encode(["type"=>"update_last_seen","message"=>now(),"ChatID"=>$ChatID])));
			}
			//event(new chatApp($req->message));
			$req->MessageID=$SLNO;
			$msg=$this->getChatHistory($req,$ChatID);
			event(new chatApp($req->messageTo,json_encode(["type"=>"load_message","message"=>$msg])));
            if ($req->messageTo !== "Admin") {
                $fcmToken = DB::table('users')->where('UserID', $req->messageTo)->value('fcmToken');
                logger("FcmToken: ".$fcmToken);
                $this->sendNotification($LastMessage, $fcmToken);
            }
		}catch(Exception $e) {
			$status=false;
		}
		if($status==true){
			DB::commit();
			$msg=$this->getChatMessage($ChatID,$SLNO);
			event(new chatApp($req->messageTo,json_encode(["type"=>"load_message","isRead"=>$req->messageFrom=="Admin"?0:1,"isAdminRead"=>$req->messageFrom=="Admin"?1:0,"messageFrom"=>$req->messageFrom,"message"=>$msg,"ChatID"=>$ChatID,"LastMessageOn"=>$LastMessageOn,"LastMessage"=>$LastMessage,"LastMessageOnHuman"=>Carbon::parse($LastMessageOn)->diffForHumans()])));

			event(new chatApp($req->messageFrom,json_encode(["type"=>"load_message","isRead"=>$req->messageFrom=="Admin"?0:1,"isAdminRead"=>$req->messageFrom=="Admin"?1:0,"messageFrom"=>$req->messageFrom,"message"=>$msg,"ChatID"=>$ChatID,"LastMessageOn"=>$LastMessageOn,"LastMessage"=>$LastMessage,"LastMessageOnHuman"=>Carbon::parse($LastMessageOn)->diffForHumans()])));
		}else{
			DB::rollback();
		}
		return ['status'=>$status,"SLNO"=>$SLNO,"LastMessage"=>$LastMessage,"LastMessageOn"=>$LastMessageOn,"LastMessageOnHuman"=>Carbon::parse($LastMessageOn)->diffForHumans()];
	}
    protected function sendNotification($message, $fcmToken) {
        // Path to your Firebase service account JSON file
        $serviceAccountPath = storage_path('rpc-google-services.json');

        // Initialize Firebase with the service account
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccountPath);

        // Create FCM messaging
        $messaging = $firebase->createMessaging(); // Use createMessaging() instead of getMessaging()

        // Prepare notification data
        $notification = [
            'title' => 'Admin',
            'body' => $message,
        ];

        // Send the notification
        try {
            // Prepare the CloudMessage object
            $cloudMessage = CloudMessage::withTarget('token', $fcmToken)
                ->withNotification($notification);

            // Send the notification
            $status = $messaging->send($cloudMessage);
            logger("Notification sent log for mobile app: ".json_encode($status));
        } catch (MessagingException $e) {
            logger('Error sending notification: ' . $e->getMessage());
        } catch (\Exception $e) {
            logger('Error sending notification: ' . $e->getMessage());
        }
    }
	public function sendAttachment(Request $req,$ChatID){
		DB::beginTransaction();$SLNO="";
		$status=false;
		$LastMessageOn=now();

		$LastMessage=$req->message==""?"sent a attachment file":$req->message;
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
					"isRead"=>$req->messageFrom=="Admin"?0:1,
					"isAdminRead"=>$req->messageFrom=="Admin"?1:0,
					"LastMessageOn"=>$LastMessageOn,
					"LastMessage"=>$LastMessage
				];
				if($req->messageFrom=="Admin"){
					$data['adminLastSeenOn']=now();

				}else{
					$data['senderLastSeenOn']=now();
				}

				$status=DB::Table($this->SupportDB.'tbl_chat')->where('ChatID',$ChatID)->update($data);
				event(new chatApp($req->messageTo,json_encode(["type"=>"update_last_seen","message"=>now(),"ChatID"=>$ChatID])));
			}
			//event(new chatApp($req->message));
			$req->MessageID=$SLNO;
			$msg=$this->getChatHistory($req,$ChatID);
			event(new chatApp($req->messageTo,json_encode(["type"=>"load_message","message"=>$msg])));
            if ($req->messageTo !== "Admin") {
                $fcmToken = DB::table('users')->where('UserID', $req->messageTo)->value('fcmToken');
                logger("FcmToken: ".$fcmToken);
                $this->sendNotification("A new attachment has been received.", $fcmToken);
            }
		}catch(Exception $e) {
			$status=false;
		}
		if($status==true){
			DB::commit();
			$msg=$this->getChatMessage($ChatID,$SLNO);$msg=$this->getChatMessage($ChatID,$SLNO);
			event(new chatApp($req->messageTo,json_encode(["type"=>"load_message","isRead"=>$req->messageFrom=="Admin"?0:1,"isAdminRead"=>$req->messageFrom=="Admin"?1:0,"messageFrom"=>$req->messageFrom,"message"=>$msg,"ChatID"=>$ChatID,"LastMessageOn"=>$LastMessageOn,"LastMessage"=>$LastMessage,"LastMessageOnHuman"=>Carbon::parse($LastMessageOn)->diffForHumans()])));
			event(new chatApp($req->messageFrom,json_encode(["type"=>"load_message","isRead"=>$req->messageFrom=="Admin"?0:1,"isAdminRead"=>$req->messageFrom=="Admin"?1:0,"messageFrom"=>$req->messageFrom,"message"=>$msg,"ChatID"=>$ChatID,"LastMessageOn"=>$LastMessageOn,"LastMessage"=>$LastMessage,"LastMessageOnHuman"=>Carbon::parse($LastMessageOn)->diffForHumans()])));
		}else{
			DB::rollback();
		}
		return ['status'=>$status,"SLNO"=>$SLNO,"LastMessage"=>$LastMessage,"LastMessageOn"=>$LastMessageOn,"LastMessageOnHuman"=>Carbon::parse($LastMessageOn)->diffForHumans()];
	}

    public function searchChatHistory(Request $req, $ChatID)
    {
        $pageLimit = (int)$req->pageLimit ?: 20;
        $pageNo = (int)$req->pageNo ?: 1;
        $offset = ($pageNo - 1) * $pageLimit;

        $query = DB::table($this->SupportDB . "tbl_chat_message")
            ->where("ChatID", $ChatID)
            ->where("Status", "<>", "Deleted");

        if ($req->searchText) {
            $query->where("Message", "LIKE", "%" . $req->searchText . "%");
        }

        $totalMatches = $query->count();
        $isLoadMore = ($offset + $pageLimit) < $totalMatches;

        $searchResults = $query->orderBy("CreatedOn", "desc")
            ->offset($offset)
            ->limit($pageLimit)
            ->get();

        foreach ($searchResults as $message) {
            $message->CreatedOnHuman = Carbon::parse($message->CreatedOn)->diffForHumans();
        }

        return response()->json(compact('searchResults', 'isLoadMore', 'totalMatches'));
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
	
	public function getQuotes($data=array()){
		$sql ="SELECT Q.QID, Q.EnqID, Q.QNo, Q.QDate, Q.QExpiryDate, Q.QuotePDF, Q.CustomerID, Q.AID, C.CustomerName, C.MobileNo1, C.MobileNo2, C.Email, C.Address as BAddress, C.CountryID as BCountryID, BC.CountryName as BCountryName, ";
		$sql.=" C.StateID as BStateID, BS.StateName as BStateName, C.DistrictID as BDistrictID, BD.DistrictName as BDistrictName, C.TalukID, BT.TalukName as BTalukName, C.CityID as BCityID, BCI.CityName as BCityName, C.PostalCodeID as BPostalCodeID, ";
		$sql.=" BPC.PostalCode as BPostalCode, BC.PhoneCode, Q.ReceiverName, Q.ReceiverMobNo, Q.DAddress, Q.DCountryID, CO.CountryName as DCountryName, Q.DStateID, S.StateName as DStateName, Q.DDistrictID, D.DistrictName as DDistrictName, Q.DTalukID, ";
		$sql.=" T.TalukName as DTalukName, Q.DCityID, CI.CityName as DCityName, Q.DPostalCodeID, PC.PostalCode as DPostalCode, Q.TaxAmount, Q.SubTotal, Q.DiscountType, Q.DiscountPercent as DiscountPercentage, Q.DiscountAmount, Q.CGSTAmount, ";
		$sql.=" Q.SGSTAmount, Q.IGSTAmount, Q.TotalAmount, Q.AdditionalCost, Q.OverAllAmount as NetAmount, Q.AdditionalCostData, Q.Status, Q.AcceptedOn, Q.RejectedOn, Q.ApprovedBy, Q.RejectedBy, Q.RReasonID, RR.RReason, Q.RRDescription ";
		$sql.=" FROM ".$this->CurrFYDB."tbl_quotation as Q LEFT JOIN tbl_customer as C ON C.CustomerID=Q.CustomerID LEFT JOIN ".$this->generalDB."tbl_countries as BC ON BC.CountryID=C.CountryID  ";
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
			$sql.=" FROM ".$this->CurrFYDB."tbl_quotation_details as QD LEFT JOIN tbl_products as P ON P.ProductID=QD.ProductID LEFT JOIN tbl_uom as U ON U.UID=P.UID LEFT JOIN tbl_reject_reason as RR ON RR.RReasonID=QD.ReasonID LEFT JOIN tbl_vendors as V ON V.VendorID=QD.VendorID ";
			$sql.=" Where QD.QID='".$result[$i]->QID."' and QD.isCancelled=0 ";
			$result[$i]->Details=DB::SELECT($sql);
			for($j=0;$j<count($result[$i]->Details);$j++){
				$result[$i]->Details[$j]->VQuoteID="";
				$result1=DB::Table($this->CurrFYDB.'tbl_vendor_quotation')->Where('EnqID',$result[$i]->EnqID)->where('VendorID',$result[$i]->Details[$j]->VendorID)->get();
				if(count($result1)>0){
					$result[$i]->Details[$j]->VQuoteID=$result1[0]->VQuoteID;
				}
			}
			$addCharges=[];
			$result1=DB::Table($this->CurrFYDB.'tbl_vendor_quotation')->Where('EnqID',$result[$i]->EnqID)->get();
			foreach($result1 as $tmp){
				$addCharges[$tmp->VendorID]=Helper::NumberFormat($tmp->AdditionalCost,$this->Settings['price-decimals']);
			}
			$result[$i]->AdditionalCharges=$addCharges;
		}
		return $result;
	}
	public function QuoteConvert(Request $req,$EnqID){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OldData=array();$NewData=array();
			DB::beginTransaction();
			try {
				$EnqData = DB::table($this->CurrFYDB.'tbl_enquiry_details as ED')->join($this->CurrFYDB.'tbl_enquiry as E','E.EnqID','ED.EnqID')->where('ED.EnqID',$EnqID)->get();
				$FinalQuote = json_decode($req->FinalQuote);
				$AdditionalCostData = json_decode($req->AdditionalCost);
				$AdditionalCost = 0;
				if(is_array($AdditionalCostData)){
					foreach($AdditionalCostData as $cost){
						$AdditionalCost += $cost->ACost;
					}
				}
				$QData = DB::table($this->CurrFYDB.'tbl_quotation')->where('EnqID',$EnqID)->first();
				$QID = $QData->QID ?? null;
				if(!$QData){
					$QID = DocNum::getDocNum(docTypes::Quotation->value, $this->CurrFYDB,Helper::getCurrentFy());
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

						$QDetailID = DocNum::getDocNum(docTypes::QuotationDetails->value, $this->CurrFYDB,Helper::getCurrentFy());
						$data1=[
							"DetailID" => $QDetailID,
							"QID" => $QID,
							"VQDetailID" => $item->DetailID,
							"ProductID" => $item->ProductID,
							"TaxType" => $ProductDetails->TaxType,
							"Qty" => $item->Qty,
							"Price" => $item->FinalPrice,
							"TaxAmt" => $taxAmount,
							"TaxPer" => $ProductDetails->TaxPercentage,
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
						$status = DB::table($this->CurrFYDB.'tbl_quotation_details')->insert($data1);
						$isNotifiedVendor = DB::table($this->CurrFYDB.'tbl_quotation_details')->where('QID',$QID)->where('VendorID',$item->VendorID)->where('isCancelled',0)->exists();
						if(!$isNotifiedVendor){
							$VQuoteID = DB::table($this->CurrFYDB.'tbl_vendor_quotation_details')->where('DetailID',$item->DetailID)->value('VQuoteID');
							$Title = "Quotation Accepted";
							$Message = "Great news! Your quotation has been accepted. We'll proceed accordingly. Thank you.";
							Helper::saveNotification($item->VendorID,$Title,$Message,'Quotation',$VQuoteID);
						}
						if($status){
							DocNum::updateDocNum(docTypes::QuotationDetails->value, $this->CurrFYDB);
						}
					}
					if ($status) {
						$QuoteNo = DocNum::getInvNo(docTypes::Quotation->value);
						$data=[
							'QID' => $QID,
							'EnqID' => $EnqID,
							'QNo' => $QuoteNo,
							'QDate' => date('Y-m-d'),
							'QExpiryDate' => date('Y-m-d', strtotime('+15 days')),
							'CustomerID' => $EnqData[0]->CustomerID,
							'ReceiverName' => $EnqData[0]->ReceiverName,
							'ReceiverMobNo' => $EnqData[0]->ReceiverMobNo,
							'AID' => $EnqData[0]->AID,
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
						$status=DB::table($this->CurrFYDB.'tbl_quotation')->insert($data);
						if($status){
							
						}
					}
				}
				$status = DB::table($this->CurrFYDB.'tbl_enquiry')->where('EnqID',$EnqID)->update(['Status'=>'Converted to Quotation','UpdatedOn'=>date('Y-m-d H:i:s'),'UpdatedBy'=>$this->UserID]);

			}catch(Exception $e) {
				$status=false;
			}
			if($status==true){
				DB::commit();
				DocNum::updateDocNum(docTypes::Quotation->value, $this->CurrFYDB);
				DocNum::updateInvNo(docTypes::Quotation->value);

				$NewData=DB::table($this->CurrFYDB.'tbl_quotation_details as QD')->join($this->CurrFYDB.'tbl_quotation as Q','QD.QID','Q.QID')->where('QD.QID',$QID)->get();
				$logData=array("Description"=>"Quotation Converted","ModuleName"=>$this->ActiveMenuName,"Action"=>"Insert","ReferID"=>$QID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);



				$QData = $this->getQuotes(['QID'=>$QID]);
				if (count($QData) > 0) {
					return ['status' => true,'message' => "Quotation Generated Successfully",'QData' => $QData[0]];
				} else {
					return ['status' => false,'message' => "No Quotation found",'QData' => []];
				}
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Quotation Generate Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
	
	public function CreateQuote(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"add")==true){
			DB::beginTransaction();
			$OldData=$NewData=[];
			$status=false;
			try {
				$CustomerID=$req->CustomerID;
				$CustomerData = DB::table('tbl_customer')->where('CustomerID',$CustomerID)->first();
				$AddressData = DB::table('tbl_customer_address')->where('AID',$req->AID)->first();
				$EnqID = DocNum::getDocNum(docTypes::Enquiry->value,$this->CurrFYDB,Helper::getCurrentFY());
				$data=[
					'EnqID' => $EnqID,
					'EnqNo' =>DocNum::getInvNo("Quote-Enquiry"),
					'EnqDate' => date('Y-m-d'),
					'EnqExpiryDate' => date('Y-m-d', strtotime('+15 days')),
					'CustomerID' => $CustomerID,
					'ReceiverName' => $CustomerData->CustomerName,
					'ReceiverMobNo' => $req->ReceiverMobNo,
					'ExpectedDeliveryDate' => $req->ExpDelivery,
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
					'CreatedBy' => $this->UserID,
				];
				$status=DB::table($this->CurrFYDB.'tbl_enquiry')->insert($data);
				if($status){
					$ProductData = $req->ProductData;
					foreach($ProductData as $item){
						$EnquiryDetailID = DocNum::getDocNum(docTypes::EnquiryDetails->value,$this->CurrFYDB,Helper::getCurrentFY());
						$data1=[
							'DetailID' => $EnquiryDetailID,
							'EnqID'=>$EnqID,
							'CID'=>DB::table('tbl_products')->where('ProductID',$item['ProductID'])->value('CID'),
							'SCID'=>DB::table('tbl_products')->where('ProductID',$item['ProductID'])->value('SCID'),
							'ProductID'=>$item['ProductID'],
							'Qty'=>$item['Qty'],
							'UOMID'=>DB::table('tbl_products')->where('ProductID',$item['ProductID'])->value('UID'),
							'CreatedBy' => $this->UserID,
						];
						$status = DB::table($this->CurrFYDB.'tbl_enquiry_details')->insert($data1);
						if($status){
							DocNum::updateDocNum(docTypes::EnquiryDetails->value,$this->CurrFYDB);
						}
					}
					$ChatVendorID = $this->Settings['chat-vendor'];
					logger($ChatVendorID);
					$VendorID = DB::table('tbl_vendors')->where('VendorID', $ChatVendorID)->where('DFlag',0)->where('ActiveStatus','Active')->value('VendorID');
					if(!$VendorID){
						return ['status' => false, 'message' =>'RPC Vendor not found'];
					}
					$CustomerLatLong = DB::table('tbl_customer_address')->where('AID',$req->AID)->where('Latitude','!=',NULL)->where('Longitude','!=',NULL)->select('Latitude','Longitude')->first();
					if(!$CustomerLatLong && !$CustomerLatLong->Latitude && !$CustomerLatLong->Longitude){
						return ['status' => false, 'message' =>'Customer Lat Long doesnt exists!'];
					}

					$StockPoints = DB::table('tbl_vendors_stock_point')->where('VendorID',$VendorID)->where('DFlag',0)->where('ActiveStatus',1)->where('Latitude','!=',NULL)->where('Longitude','!=',NULL)->select('VendorID','StockPointID','Latitude','Longitude')->get();
					if(count($StockPoints) == 0){
						return ['status' => false, 'message' =>'Vendor ('.$VendorID.') Stock points not found'];
					}

					$Distance = Helper::findNearestStockPoint($CustomerLatLong, $StockPoints);
					$VQuoteID = DocNum::getDocNum(docTypes::VendorQuotation->value, $this->CurrFYDB,Helper::getCurrentFy());

					$totalTaxable = 0;
					$totalTaxAmount = 0;
					$totalCGST = 0;
					$totalSGST = 0;
					$totalIGST = 0;
					$totalQuoteValue = 0;
					foreach ($ProductData as $item) {
						$ProductDetails = DB::table('tbl_products as P')->leftJoin('tbl_tax as T', 'T.TaxID', 'P.TaxID')->where('P.ProductID', $item['ProductID'])->select('P.TaxType', 'T.TaxPercentage','P.TaxID')->first();
						$Amt = $item['Qty'] * $item['Price'];
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

						$DetailID = DocNum::getDocNum(docTypes::VendorQuotationDetails->value, $this->CurrFYDB, Helper::getCurrentFy());
						$data=[
							"DetailID" => $DetailID,
							"VQuoteID" => $VQuoteID,
							"ProductID" => $item['ProductID'],
							"Qty" => $item['Qty'],
							'Price'=>$item['Price'],
							'Taxable'=>$taxableAmount,
							'TaxAmt'=>$taxAmount,
							'TaxID'=>$ProductDetails->TaxID,
							'TaxPer'=>$ProductDetails->TaxPercentage,
							'TaxType'=>$ProductDetails->TaxType,
							"CGSTPer" => $cgstPercentage,
							"SGSTPer" => $sgstPercentage,
							"CGSTAmt" => $cgstAmount,
							"SGSTAmt" => $sgstAmount,
							'TotalAmt'=>$totalAmount,
							'Status'=>'Price Sent',
							'UpdatedOn'=>date('Y-m-d H:i:s')
						];
						$status = DB::table($this->CurrFYDB . 'tbl_vendor_quotation_details')->insert($data);
						if ($status) {
							DocNum::updateDocNum(docTypes::VendorQuotationDetails->value, $this->CurrFYDB);
						}
					}

					$data = [
						"VQuoteID" => $VQuoteID,
						"VendorID" => $VendorID,
						"EnqID" => $EnqID,
						"Distance" => $Distance,
						"QReqOn" => date('Y-m-d'),
						"QReqBy" => $this->UserID,
						"CreatedBy" => $this->UserID,
						'SubTotal' => $totalTaxable,
						'TaxAmount' => $totalTaxAmount,
						'TotalAmount' => $totalQuoteValue,
						'LabourCost'=>$req->LabourCost ?? 0,
						'TransportCost'=>$req->TransportCost ?? 0,
						'AdditionalCost'=>$req->TransportCost + $req->LabourCost ?? 0,
						'Status' => 'Sent',
						'QSentOn'=>date('Y-m-d'),
						'UpdatedBy'=>$this->UserID,
						'UpdatedOn'=>date('Y-m-d H:i:s')
					];
					$status = DB::table($this->CurrFYDB . 'tbl_vendor_quotation')->insert($data);
					if ($status) {
						DocNum::updateDocNum(docTypes::VendorQuotation->value, $this->CurrFYDB);
					}
				}
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DB::commit();
				DocNum::updateDocNum(docTypes::Enquiry->value,$this->CurrFYDB);
				DocNum::updateInvNo(docTypes::Enquiry->value);
				$NewData=DB::table($this->CurrFYDB.'tbl_enquiry_details as ED')->leftJoin($this->CurrFYDB.'tbl_enquiry as E','E.EnqID','ED.EnqID')->where('ED.EnqID',$EnqID)->get();
				$logData=array("Description"=>"New Quote Enquiry Created","ModuleName"=>$this->ActiveMenuName,"Action"=>"Add","ReferID"=>$EnqID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);

				$FinalQuote = DB::table($this->CurrFYDB.'tbl_vendor_quotation_details as VQD')
				->join($this->CurrFYDB.'tbl_vendor_quotation as VQ','VQ.VQuoteID','VQD.VQuoteID')
				->where('VQ.EnqID',$EnqID)
				->select('VQD.DetailID','VQ.VQuoteID','VQD.ProductID','VQD.Qty','VQD.Price as FinalPrice','VQ.VendorID')
				->get();
				$newRequest = new Request(['FinalQuote' => $FinalQuote]);
				return $this->QuoteConvert($newRequest, $EnqID);
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Quote Enquiry Create Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}

	}

	public function QuotePDF(Request $req, $QID)
	{
		$FormData = $this->general->UserInfo;
		$FormData['PageTitle'] = 'Quotation';
		$FormData['Settings'] = $this->Settings;
		$FormData['QID'] = $QID;
		$FormData['QData'] = $this->getQuotes(["QID" => $QID]);

		if (count($FormData['QData']) > 0) {
			$FormData['QData'] = $FormData['QData'][0];
			
			return view('app.transaction.quotation.pdf-view', $FormData);
		} else {
			return response()->json(['status' => 'error', 'message' => 'Quote not found'], 404);
		}
	}
	
	public function SaveQuotePDF(Request $req)
	{
		$QID = $req->input('QID');
		$pdfFile = $req->file('pdf');

		$filePath = 'uploads/quotations';
		$fileName = $QID . '.pdf';

		if (!file_exists(public_path($filePath))) {
			mkdir(public_path($filePath), 0777, true);
		}

		$pdfPath = $pdfFile->storeAs($filePath, $fileName, 'public');

		$quotation = DB::table($this->CurrFYDB.'tbl_quotation')->where('QID', $QID)->first();

		if ($quotation) {
			DB::table($this->CurrFYDB.'tbl_quotation')->where('QID', $QID)->update([
				'QuotePDF' => $pdfPath
			]);
			
			return response()->json(['status' => true, 'message' => 'PDF saved successfully.']);
		} else {
			return response()->json(['status' => false, 'message' => 'Quotation not found.'], 404);
		}
	}

}
