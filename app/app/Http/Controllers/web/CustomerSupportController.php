<?php

namespace App\Http\Controllers\web;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Home\HomeAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\DocNum;
use App\Models\general;
use App\Models\ServerSideProcess;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\helper\helper;
use App\Rules\ValidUnique;
use App\Rules\ValidDB;
use logs;
use Illuminate\Support\Facades\Mail;
use App\enums\docTypes;
use App\enums\activeMenuNames;

class CustomerSupportController extends Controller{
	private $general;
	private $DocNum;
	private $UserID;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $logs;
	private $Settings;
    private $Menus;
	private $AdminID;
	private $generalDB;
	private $supportDB;
    private $LoginType;

    public function __construct(){
		$this->ActiveMenuName=activeMenuNames::SupportTickets->value;
        $this->PageTitle="Support Tickets";
        $this->middleware('auth');
		$this->middleware(function ($request, $next) {
			$this->UserID=auth()->user()->UserID;
			$this->general=new general($this->UserID,$this->ActiveMenuName);
			$this->Menus=$this->general->loadMenu();
			$this->CRUD=$this->general->getCrudOperations($this->ActiveMenuName);
			$this->Settings=$this->general->getSettings();
			$this->generalDB=Helper::getGeneralDB();
            $this->supportDB=Helper::getSupportDB();
			return $next($request);
		});
    }
	public function SupportView(Request $req){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
            $FormData['PageName']="Account Settings Support Details";
            $FormData['crud']=$this->CRUD;
            $FormData['users']=DB::table("users")->where("DFlag",0)->where("ActiveStatus",1)->get();
            return view('home.customer.support.support',$FormData);
    }
    public function SupportDetailsView(Request $req,$SupportID){
		$FormData=$this->general->UserInfo;
		$FormData['ActiveMenuName']=$this->ActiveMenuName;
		$FormData['PageTitle']=$this->PageTitle;
		$FormData['PageName']="Account Settings Support Details";
		$FormData['menus']=$this->Menus;
        $FormData['crud']=$this->CRUD;
        $FormData['SID']=$SupportID;
        $FormData['isRegister']=false;
        $homeAuthController = new HomeAuthController();
        $FormData['Cart'] = $homeAuthController->getCart();
        $PCatagories = DB::Table('tbl_product_category')->where('ActiveStatus', 'Active')->where('DFlag', 0)->select('PCName', 'PCID', 'PCImage')
            ->inRandomOrder()->take(10)->get();
        $FormData['PCategories'] = $PCatagories;
        $generalDB = Helper::getGeneralDB();
        $CustomerID = auth()->user()->ReferID;
        $FormData['ShippingAddress'] = DB::table('tbl_customer_address as CA')->where('CustomerID', $CustomerID)
            ->join($generalDB . 'tbl_countries as C', 'C.CountryID', 'CA.CountryID')
            ->join($generalDB . 'tbl_states as S', 'S.StateID', 'CA.StateID')
            ->join($generalDB . 'tbl_districts as D', 'D.DistrictID', 'CA.DistrictID')
            ->join($generalDB . 'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
            ->join($generalDB . 'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
            ->join($generalDB . 'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
            ->select('CA.AID', 'CA.Address', 'CA.isDefault', 'CA.CountryID', 'C.CountryName', 'CA.StateID', 'S.StateName', 'CA.DistrictID', 'D.DistrictName', 'CA.TalukID', 'T.TalukName', 'CA.CityID', 'CI.CityName', 'CA.PostalCodeID', 'PC.PostalCode')
            ->get();
        $FormData['TUInfo']=$this->ticketUserInfo($SupportID);
        DB::table($this->supportDB.'tbl_support')->where("SupportID",$SupportID)->update(['Status' => 'Opened']);
        $FormData['Support']=DB::table($this->supportDB."tbl_support")->where("SupportID",$SupportID)->get();
        if(count($FormData['Support'])>0){
            $FormData['SupportDetails']=$this->getSupportDetails(array("SupportID"=>$SupportID));
            return view('home.customer.support.support_details',$FormData);
        }else{
            return view('errors.404');
        }

    }
    private function ticketUserInfo($SupportID){
        $return=array(
            "Name"=>"",
            "MobileNumber"=>""
        );
        $sql="SELECT U.LoginType FROM ".$this->supportDB."tbl_support as S LEFT JOIN users as U ON U.UserID=S.CreatedBy  Where S.SupportID='".$SupportID."'";
        $result=DB::SELECT($sql);
        if(count($result)>0){
            if(intval($result[0]->LoginType)==2){
                $sql="SELECT U.UserID, U.Name as UserName,CASE WHEN IFNULL(UI.MobileNumber,'')<>'' THEN CONCAT('+',C.PhoneCode,' ',UI.MobileNumber) ELSE '' END as MobileNumber FROM ".$this->supportDB."tbl_support as S LEFT JOIN users as U ON U.UserID=S.CreatedBy LEFT JOIN users as UI ON UI.UserID=S.CreatedBy LEFT JOIN ".$this->generalDB."tbl_countries as C ON C.CountryID=UI.CountryID Where S.SupportID='".$SupportID."'";
                $tmp=DB::SELECT($sql);
                if(count($tmp)>0){
                    $return=array(
                        "Name"=>$tmp[0]->UserName,
                        "MobileNumber"=>$tmp[0]->MobileNumber
                    );
                }
            }else{
                $sql="SELECT U.UserID, U.Name as UserName,CASE WHEN IFNULL(UI.MobileNumber,'')<>'' THEN CONCAT('+',C.PhoneCode,' ',UI.MobileNumber) ELSE '' END as MobileNumber FROM ".$this->supportDB."tbl_support as S LEFT JOIN users as U ON U.UserID=S.UserID LEFT JOIN users as UI ON UI.UserID=S.UserID LEFT JOIN ".$this->generalDB."tbl_countries as C ON C.CountryID=UI.CountryID Where S.SupportID='".$SupportID."'";
                $tmp=DB::SELECT($sql);
                if(count($tmp)>0){
                    $return=array(
                        "Name"=>$tmp[0]->UserName,
                        "MobileNumber"=>$tmp[0]->MobileNumber
                    );
                }
            }
        }
        return $return;
    }
	public function NewTicket(Request $req){
            // $sql="SELECT U.UserID, U.Name as UserName,CASE WHEN IFNULL(UI.MobileNumber,'')<>'' THEN CONCAT('+',C.PhoneCode,' ',UI.MobileNumber) ELSE '' END as MobileNumber FROM  users as U  LEFT JOIN users as UI ON UI.UserID=U.UserID LEFT JOIN ".$this->generalDB."tbl_countries as C ON C.CountryID=UI.CountryID Where U.LoginType=2 and U.DFlag=0";
            $FormData=$this->general->UserInfo;
            logger("FormData");
            logger($FormData);
            $FormData['PageName']="Account Settings New Support";
            $FormData['Customers']=DB::table('users')->where('DFlag',0)->where('LoginType','Customer')->get();
            $FormData['Vendors']=DB::table('users')->where('DFlag',0)->where('LoginType','Vendor')->get();
            $FormData['SupportType']=DB::Table('tbl_support_type')->where('isAll',0)->where('ActiveStatus',1)->where('DFlag',0)->get();
            $FormData['SaveButtonID']=md5(date("YmdHis"));
            return view('home.customer.support.new',$FormData);
    }
    public function SaveTicket(Request $req){
            $UInfo=$this->general->UserInfo;
            $OldData=$NewData=array();$SupportID="";
            $ValidDB=array();
			$ValidDB['UserID']['TABLE']="users";
			$ValidDB['UserID']['ErrMsg']="User does not exist";
			$ValidDB['UserID']['WHERE'][]=array("COLUMN"=>"UserID","CONDITION"=>"=","VALUE"=>$req->UserID);
			$ValidDB['UserID']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);
            $rules=array(
                'UserID'=>['required',new ValidDB($ValidDB['UserID'])],
                'Subject' =>'required|min:3|max:100',
                'Priority' =>'required',
                'SupportType' =>'required',
                'Description' => 'required|min:3',
                'Attachment1' => 'mimes:jpeg,jpg,png,gif,webp,bmp,pdf,doc,docx',
                'Attachment2' => 'mimes:jpeg,jpg,png,gif,webp,bmp,pdf,doc,docx',
                'Attachment3' => 'mimes:jpeg,jpg,png,gif,webp,bmp,pdf,doc,docx',
                'Attachment4' => 'mimes:jpeg,jpg,png,gif,webp,bmp,pdf,doc,docx'
            );
			$message=array(
                'UserID.required'=>'Customer is required'
			);
            $validator = Validator::make($req->all(), $rules,$message);

            if ($validator->fails()) {
                return array('status'=>false,'message'=>"New support ticket request has been submit failed",'errors'=>$validator->errors());
            }
            DB::beginTransaction();
            $status=false;
            try{
                $SupportID=DocNum::getDocNum(docTypes::Support->value,"",Helper::getCurrentFY());
                $data=array(
                    "SupportID"=>$SupportID,
                    "UserID"=>$req->UserID,
                    "Subject"=>$req->Subject,
                    "TicketFor"=>$req->TicketFor,
                    "Priority"=>$req->Priority,
                    "SupportType"=>$req->SupportType,
                    "DFlag"=>0,
                    "CreatedOn"=>date("Y-m-d H:i:s"),
                    "CreatedBy"=>$this->UserID,
                );
                $status=DB::Table($this->supportDB."tbl_support")->insert($data);
                if($status==true){
                    $status=$this->SaveSupportDetail($req,$SupportID);
                }
                if($status==true){
                    $status1=$this->sendMail($req->SupportType,$SupportID);
                    if($status1==false){
                        DB::rollback();
                        $status=false;
                        return $status1;
                    }else{
                        $status=true;
                    }
                }
            }catch(Exception $e) {
                $status=false;
            }
            if($status==true){
                DocNum::updateDocNum(docTypes::Support->value);
                $NewData=DB::Table($this->supportDB."tbl_support")->where('SupportID',$SupportID)->get();
                $logData=array("Description"=>"New Support request has been submit successfully ","ModuleName"=>"Support","Action"=>"Add","ReferID"=>$SupportID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
                logs::Store($logData);


                DB::commit();
                return array('status'=>true,'message'=>"New support ticket request has been submit successfully");
            }else{
                DB::rollback();
                return array('status'=>false,'message'=>"New support ticket request has been submit  Failed");
            }
    }
    private function SaveSupportDetail($req,$SupportID){
        try{
            $SLNO=DocNum::getDocNum(docTypes::SupportDetails->value,"",Helper::getCurrentFY());
            $data=array(
                "SLNO"=>$SLNO,
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
                for($i=1;$i<=4;$i++){
                    if ($req->hasFile('Attachment'.$i)) {
                        if($status==true){
                            $status=$this->SaveAttachments(request()->file('Attachment'.$i),$SupportID,$SLNO);
                        }
                    }
                }

            }
            if($status){
                $status=DB::Table($this->supportDB."tbl_support")->update(array('status'=>1,"UpdatedOn"=>date("Y-m-d H:i:s")));
            }
            if($status==true){
                $status1=$this->sendMail($req->SupportType,$SupportID);
                if($status1==false){
                    DB::rollback();
                    $status=false;
                    return $status1;
                }else{
                    $status=true;
                }
            }
		}catch(Exception $e) {
        }
        return $status;
    }
    private function SaveAttachments($file,$SupportID,$ReferID){
        //DB::beginTransaction();
        $status=false;
        try{
            $dir="uploads/support/".$SupportID."/";
            if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $filepath=$dir.$fileName;
            $FileSize=$file->getSize();
            $AttachmentID=DocNum::getDocNum(docTypes::SupportAttachments->value,"",Helper::getCurrentFY());
            $data=array("AttachmentID"=>$AttachmentID,"ReferID"=>$ReferID,"Module"=>"Support","FileSize"=>$FileSize,"UploadDir"=>$dir,"UploadFileName"=>$fileName,"UploadFileExt"=>$file->getClientOriginalExtension(),"UploadUrl"=>$filepath,"UserID"=>$this->UserID,"CreatedOn"=>date("Y-m-d H:i:s"));
            $status=DB::table($this->supportDB."tbl_attachment")->insert($data);
            if($status==true){
                $file->move($dir,$fileName);
                DocNum::updateDocNum(docTypes::SupportAttachments->value);
            }
        }catch(Exception $e){

        }
		return $status;
    }
    public function DeleteSupport(Request $req,$SupportID){
        $OldData=$NewData=array();
        DB::beginTransaction();
		$status=false;
		try{
			$OldData=DB::table($this->supportDB."tbl_support")->where('SupportID',$SupportID)->get();
			$status=DB::table($this->supportDB."tbl_support")->where('SupportID',$SupportID)->update(array("DFlag"=>1,"DeletedOn"=>date("Y-m-d H:i:s"),"DeletedBy"=>$this->UserID));
		}catch(Exception $e) {

		}
		if($status==true){
			DB::commit();
			$logData=array("Description"=>"Support Deleted ","ModuleName"=>"Support","Action"=>"Delete","ReferID"=>$SupportID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
			logs::Store($logData);

			return array('status'=>true,'message'=>"Deleted Successfully");
		}else{
			DB::rollback();
			return array('status'=>false,'message'=>"Delete Failed");
		}
    }
    public function ActivateSupport(Request $req,$SupportID){
        $OldData=$NewData=array();
        DB::beginTransaction();
		$status=false;
		try{
			$OldData=DB::table($this->supportDB."tbl_support")->where('SupportID',$SupportID)->get();
			$status=DB::table($this->supportDB."tbl_support")->where('SupportID',$SupportID)->update(array("Status"=>"Opened","DFlag"=>0,"UpdatedOn"=>date("Y-m-d H:i:s"),"UpdatedBy"=>$this->UserID));
		}catch(Exception $e) {

		}
		if($status==true){
            DB::commit();
            $NewData=DB::table($this->supportDB."tbl_support")->where('SupportID',$SupportID)->get();
			$logData=array("Description"=>"Support Reopened ","ModuleName"=>"Support","Action"=>"Update","ReferID"=>$SupportID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
			logs::Store($logData);

			return array('status'=>true,'message'=>"Reopened Successfully");
		}else{
			DB::rollback();
			return array('status'=>false,'message'=>"Reopen Failed");
		}
    }
    public function DeactivateSupport(Request $req,$SupportID){
        $OldData=$NewData=array();
        DB::beginTransaction();
		$status=false;
		try{
			$OldData=DB::table($this->supportDB."tbl_support")->where('SupportID',$SupportID)->get();
			$status=DB::table($this->supportDB."tbl_support")->where('SupportID',$SupportID)->update(array("Status"=>"Closed","DFlag"=>0,"UpdatedOn"=>date("Y-m-d H:i:s"),"UpdatedBy"=>$this->UserID));
		}catch(Exception $e) {

		}
		if($status==true){
            DB::commit();
            $NewData=DB::table($this->supportDB."tbl_support")->where('SupportID',$SupportID)->get();
			$logData=array("Description"=>"Support Reopened ","ModuleName"=>"Support","Action"=>"Update","ReferID"=>$SupportID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
			logs::Store($logData);

			return array('status'=>true,'message'=>"Closed Successfully");
		}else{
			DB::rollback();
			return array('status'=>false,'message'=>"Close Failed");
		}
    }
    private function getSupportDetails($data){
        $sql="SELECT D.SLNO,D.UserID,CASE WHEN IFNULL(U.Name,'') ='' THEN CASE WHEN U.LoginType=2 Then U.Name ELSE 'Team 10HP' end Else U.Name END as Name,U.Email,UI.ProfileImage,D.SupportID,D.Description,D.DeliveryStatus,D.ReadStatus,D.DFlag,D.CreatedOn,D.UpdatedOn,D.DeletedOn,D.CreatedBy,D.UpdatedBy,D.DeletedBy From ".$this->supportDB."tbl_support_details as D left join ".$this->supportDB."tbl_support as H On H.SupportID=D.SupportID Left join users as U ON U.UserID=D.UserID LEFT Join users AS UI ON UI.UserID=U.UserID Where 1=1";
        if(is_array($data)){
            if(array_key_exists("SLNO",$data)){ $sql.=" and D.SLNO='".$data['SLNO']."'";}
            if(array_key_exists("UserID",$data)){ $sql.=" and D.UserID='".$data['UserID']."'";}
            if(array_key_exists("SupportID",$data)){ $sql.=" and D.SupportID='".$data['SupportID']."'";}
        }
        $sql.=" Order By  D.SLNO";
        $result=DB::Select($sql);
        for($i=0;$i<count($result);$i++){
            $result[$i]->Attachments=$this->getAttachment(array("ReferID"=>$result[$i]->SLNO,"Module"=>"Support"));
        }
        return $result;
    }
    private function getAttachment($data){
        $sql="Select AttachmentID,ReferID,Module,UploadDir,UploadFileName,UploadFileExt,UploadUrl,DFlag From ".$this->supportDB."tbl_attachment where DFlag=0 ";
        if(is_array($data)){
            if(array_key_exists("AttachmentID",$data)){$sql.=" and AttachmentID='".$data['AttachmentID']."'";}
            if(array_key_exists("ReferID",$data)){$sql.=" and ReferID='".$data['ReferID']."'";}
            if(array_key_exists("Module",$data)){$sql.=" and Module='".$data['Module']."'";}
        }
        return DB::Select($sql);
    }
    public function SupportDetailsSave(Request $req){
        $SupportID=$req->SID;
        DB::beginTransaction();
        $status=$this->SaveSupportDetail($req,$SupportID);

		if($status==true){
            DB::table($this->supportDB."tbl_support")->where('SupportID',$SupportID)->update(array('Status'=>'Opened',"DFlag"=>0,"UpdatedOn"=>date("Y-m-d H:i:s")));
            DB::commit();

			return array('status'=>true,'message'=>"submit successfully");
		}else{
			DB::rollback();
			return array('status'=>false,'message'=>"submit  Failed");
		}
    }
    public function getDetails(Request $req){
        $data=array("UserID"=>$this->UserID);
        if(isset($req->SupportID)){$data['SupportID']=$req->SupportID;}
        return $this->getSupportDetails($data);
    }
	public function TableView(Request $req){
			$ServerSideProcess=new ServerSideProcess();
			$columns = array(
				array( 'db' => 'S.SupportID', 'dt' => '0' ),
				array( 'db' => 'U.Name', 'dt' => '1'),
				array( 'db' => 'S.Subject', 'dt' => '2' ),
				array( 'db' => 'ST.SupportType', 'dt' => '3' ),
				array( 'db' => 'S.Priority', 'dt' => '4' ),
				array( 'db' => 'S.Status', 'dt' => '5' ),
				array( 'db' => 'S.CreatedOn', 'dt' => '6'),
				array( 'db' => 'S.TicketFor', 'dt' => '7'),
				array( 'db' => 'S.DFlag', 'dt' => '8'),
			);
			$columns1 = array(
				array( 'db' => 'TicketFor', 'dt' => '0',
                    'formatter' =>function($d,$row){
                        return ($d == "Customer") ? "<span class='badge block badge-primary mr-2'> $d </span>" : "<span class='badge block badge-danger mr-2'> $d </span>";

                    }),
				array( 'db' => 'Name', 'dt' => '1'),
				array( 'db' => 'Subject', 'dt' => '2' ),
				array( 'db' => 'SupportType', 'dt' => '3' ),
				array( 'db' => 'Priority', 'dt' => '4', 'formatter' =>function($d,$row){
                    $return='';
                    if($d=="Low"){
                        $return="<span class='badge block badge-info mr-2'> ".$d." </span>";
                    }elseif($d=="Medium"){
                        $return="<span class='badge block badge-warning mr-2'> ".$d." </span>";
                    }elseif($d=="High"){
                        $return="<span class='badge block badge-danger mr-2'> ".$d." </span>";
                    }
                    return $return;
                } ),
				array( 'db' => 'Status', 'dt' => '5' ,'formatter' => function( $d, $row ) {
                    $Status="";
                    if($row['DFlag']==1){
                        $Status="<span class='badge block badge-danger mr-2'> Deleted </span>";
                    }else{
                        if($d=="Opened"){
                            $Status="<span class='badge block badge-success mr-2'> ".$d." </span>";
                        }elseif($d=="Closed"){
                            $Status="<span class='badge block badge-danger mr-2'> ".$d." </span>";
                        }elseif($d=="New"){
                            $Status="<span class='badge block badge-warning mr-2'> ".$d." </span>";
                        }
                    }
					return $Status;
				}),
				array( 'db' => 'CreatedOn', 'dt' => '6','formatter' => function( $d, $row ) {
                    return date("d - M - Y",strtotime($d));
                }),
				array(
					'db' => 'SupportID',
					'dt' => '7',
					'formatter' => function( $d, $row ) {
                        $html='';
                        $html.='<div class="dropdown-hover" style="float:right;padding:10px">';
                            $html.='<span data-id="'.$d.'" class="dropbtn"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></span>';
                            $html.='<div id="'.$d.'" class="dropdown-content" style="right:0">';
                            if($row['DFlag']==1){
                                $html.='<a  data-id="'.$d.'" class="SupportTicketReopen"><i class="fa fa-envelope-open"></i> Reopen </a>';
                            }else{
                                if($row['Status']=="Closed"){
                                    $html.='<a data-id="'.$d.'" class="SupportTicketReopen"><i class="fa fa-envelope-open"></i> Reopen </a>';
                                }else{
                                    $html.='<a data-id="'.$d.'" class="SupportTicketClose"><i class="fa fa-envelope-o"></i> Close </a>';
                                }
                            }
                            $html.='</div>';
                        $html.='</div>';
						return $html;
					}
				),
				array( 'db' => 'SupportID', 'dt' => '8')
			);
            $Where=" 1=1 ";
            $Where.=" and date(S.CreatedOn)>='".date("Y-m-d",strtotime($req->FromDate))."'";
            $Where.=" and date(S.CreatedOn)<='".date("Y-m-d",strtotime($req->ToDate))."'";
            if($req->User!=""){
                $Where.=" and S.UserID='".$req->User."'";
            }
            if($req->TicketFor){
                $Where.=" and S.TicketFor='".$req->TicketFor."'";
            }
            if($req->Priority){
                $Where.=" and S.Priority='".$req->Priority."'";
            }

            if($req->Status && $req->Status == 'Deleted'){
                $Where.=" and S.Status='1' and S.DFlag='0'";
            }elseif($req->Status){
                $Where.=" and S.Status='".$req->Status."' and S.DFlag='0'";
            }
			$data=array();
			$data['POSTDATA']=$req;
			$data['TABLE']=$this->supportDB."tbl_support as S LEFT JOIN tbl_support_type as ST ON ST.SLNO=S.SupportType LEFT JOIN users as U ON U.UserID=S.UserID";
			$data['PRIMARYKEY']='S.SupportID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns1;
			$data['GROUPBY']=null;
            $data['WHERERESULT']=null;
            $data['WHEREALL']=$Where;
			return $ServerSideProcess->SSP( $data);
	}
    private function sendMail($SupportID){
        try{
            $tdata=$this->getSupportDetails(array("SupportID"=>$SupportID));
            if(count($tdata)>0){
                $email=$tdata[0]->Email;
                if($email!=""){
                    $emailContent=DB::table('tbl_email_contents')->where('type','customers-support-notifications')->first();
                    $messageData = ['SupportID'=>$SupportID,'Name'=>$tdata[0]->name,'emailContent'=>$emailContent,'LoginType'=>$this->LoginType,'email'=>$email];
                    Mail::send('emails.support',$messageData,function($message) use($email,$emailContent){$message->to($email)->subject($emailContent->Subject);});
                }
            }
        }
        catch(Exception $e){
            return array('status'=>false,'message'=>'E-Mail has been not sent due to SMTP configuration !!!');
        }
        return array('status'=>true,'message'=>'');
    }

}
