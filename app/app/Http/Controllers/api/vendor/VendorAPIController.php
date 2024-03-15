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
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use activeMenuNames;
use ValidUnique;
use ValidDB;
use DocNum;
use docTypes;
use Illuminate\Support\Facades\Hash;
use logs;

class VendorAPIController extends Controller{
    private $generalDB;
    private $tmpDB;
    private $ActiveMenuName;
    private $FileTypes;


    public function __construct(){
		$this->generalDB=Helper::getGeneralDB();
		$this->tmpDB=Helper::getTmpDB();
        $this->ActiveMenuName=activeMenuNames::Vendors->value;
		$this->FileTypes=Helper::getFileTypes(array("category"=>array("Images","Documents")));
    }
    public function Login(Request $req){
		$rules=array(
			'email' => 'required|email:filter',
			'password' => 'required',
			'fcmToken' => 'required',
		);
		$message=array(
		    'fcmToken.required'=>'Firebase Cloud Message Token is required'
		);

		$validator = Validator::make($req->all(), $rules,$message);
			
		if ($validator->fails()) {
			return array('status'=>false,'message'=>"Login failed",'errors'=>$validator->errors());			
		}
        $return=array('status'=>false);
        $result=DB::Table('users')->where('UserName',$req->email)->get();
        if(count($result)>0){
            if(($result[0]->DFlag==0)&&($result[0]->ActiveStatus=='Active')&&($result[0]->isLogin==1)){
                if(Auth::attempt(['UserName'=>$req->email,'password'=>$req->password,'ActiveStatus' => 1,'DFlag' => 0,'isLogin' => 1])){
                    $token=auth()->user()->createToken('Token')->accessToken;
					DB::Table('users')->where('UserID',Auth()->user()->UserID)->update(array("fcmToken"=>$req->fcmToken));
                    $userInfo=helper::getUserInfo(Auth()->user()->UserID);
                    
                    $return=array(
						"status"=>true,
						"message"=>"Successfully Logged in",
						"data"=>array(
							"token"=>$token,
							"email"=>Auth()->user()->email,
							"userID"=>Auth()->user()->UserID,
							"isNewUser"=>$userInfo['data']->ReferID?false:true,
							"user_data"=> $userInfo['status']==true?$userInfo['data']:array(),
                        )
					);
                    /* if(count($return['data']['user_data'])>0){
                        $return['data']['user_data']=$return['data']['user_data'][0];
                    } */
                    
                }else{
                    $return['message']='login failed';
                    $return['password']='The user name and password not match.';
                }
            }elseif($result[0]->DFlag==1){
                $return['message']='Your account has been deleted.';
            }elseif($result[0]->ActiveStatus==0){
                $return['message']='Your account has been disabled.';
            }elseif($result[0]->isLogin==0){
                $return['message']='You dont have login rights.';
            }
        }else{
            $return['message']='login failed';
            $return['email']='User name does not exists. please verify user name.';
        }
        return $return;
    }
    public function GoogleRegister(request $req){
        $UserData=DB::Table('users')->where('UserName',$req->Email)->first();
        if($UserData){
            $request = new Request([
                'email' => $req->Email,
                'password' => $req->UID,
                'fcmToken' => $req->fcmToken
            ]);
            return $this->Login($request);
        }else{
            DB::beginTransaction();
            $UserID=DocNum::getDocNum(docTypes::Users->value,'',Helper::getCurrentFY());
            $ProfileImage="";
            $dir="uploads/users/".$UserID."/";
            if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
            if($req->hasFile('ProfileImage')){
                $file = $req->file('ProfileImage');
                $fileName=md5($file->getClientOriginalName() . time());
                $fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
                $file->move($dir, $fileName1);  
                $ProfileImage=$dir.$fileName1;
            }else if(Helper::isJSON($req->ProfileImage)==true){
                $Img=json_decode($req->ProfileImage);
                if(file_exists($Img->uploadPath)){
                    $fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
                    copy($Img->uploadPath,$dir.$fileName1);
                    $ProfileImage=$dir.$fileName1;
                    // unlink($Img->uploadPath);
                }
            }
            $pwd1=Hash::make($req->UID);
            $pwd2=Helper::EncryptDecrypt("encrypt",$req->UID);
            $data=array(
                "UserID"=>$UserID,
                "Name"=>$req->Name,
                "FirstName"=>$req->FirstName,
                "LastName"=>$req->LastName,
                "UserName"=>$req->Email,
                "MobileNumber"=>"",
                "Password"=>$pwd1,
                "Password1"=>$pwd2,
                "EMail"=>$req->Email,
                "isLogin"=>1,
                "LoginType"=>$req->LoginType,
                "ProfileImage"=>$ProfileImage,
                "CreatedOn"=>date("Y-m-d H:i:s"),
                "CreatedBy"=>$UserID
            );
            $status=DB::Table('users')->insert($data);
            if($status){
                DB::commit();
                DocNum::updateDocNum(docTypes::Users->value);
                $request = new Request([
                    'email' => $req->Email,
                    'password' => $req->UID,
                    'fcmToken' => $req->fcmToken
                ]);
                return $this->Login($request);
            }else{
				DB::rollback();
                return response()->json(['status' => false,'message' => "Gmail Registration Failed!"]);
            }
        }
	}
    
}
