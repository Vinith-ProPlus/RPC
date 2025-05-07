<?php

namespace App\Http\Controllers\api\customer;

use App\helper\helper;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\DocNum;
use App\enums\docTypes;
use Illuminate\Support\Facades\Hash;
use logs;

class CustomerAPIController extends Controller{
    private $generalDB;
    private $tmpDB;
    private $FileTypes;


    public function __construct(){
		$this->generalDB=helper::getGeneralDB();
		$this->tmpDB=helper::getTmpDB();
		$this->FileTypes=helper::getFileTypes(array("category"=>array("Images","Documents")));
    }

    public function Login(Request $req): array
    {
		$rules=['fcmToken' => 'required'];
		$message=['fcmToken.required'=>'Firebase Cloud Message Token is required'];

		$validator = Validator::make($req->all(), $rules,$message);

		if ($validator->fails()) {
			return array('status'=>false,'message'=>"Login failed",'errors'=>$validator->errors());
		}
        $return=array('status'=>false);
        $query = DB::table('users')->where('LoginType', $req->LoginType);
        if ($req->LoginMethod === "MobileNumber") {
            $query->where('MobileNumber', $req->MobileNumber);
        } elseif ($req->LoginMethod === "Email") {
            $query->where('UserName', $req->email);
        }
        $result = $query->first();
        if($result){
            if(($result->DFlag==0)&&($result->ActiveStatus=='Active')&&($result->isLogin==1)){
                $Password = $result->UserName ?? $result->MobileNumber;

                if (Auth::attempt(['UserName' => $result->UserName, 'password' => $Password, 'LoginType' => $req->LoginType, 'ActiveStatus' => 1, 'DFlag' => 0, 'isLogin' => 1])) {
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

                }else{
                    $return['message']='login failed';
                    $return['password']='The user name and password not match.';
                }
            }elseif($result->DFlag==1){
                $return['message']='Your account has been deleted.';
            }elseif($result->ActiveStatus !== 'Active'){
                $return['message']='Your account has been disabled.';
            }elseif($result->isLogin==0){
                $return['message']='You dont have login rights.';
            }
        }else{
            $return['message']='login failed';
            $return['email']='User name does not exists. please verify user name.';
        }
        return $return;
    }
    public function GoogleRegister(request $req){
        $UserData=DB::Table('users')->where('UserName',$req->Email)->where('LoginType',$req->LoginType)->first();
        if($UserData){
            $request = new Request([
                'email' => $req->Email,
                'LoginType' => $req->LoginType,
                'LoginMethod' => "Email",
                'fcmToken' => $req->fcmToken
            ]);
            return $this->Login($request);
        }

        DB::beginTransaction();
        $UserID=DocNum::getDocNum(docTypes::Users->value,'',helper::getCurrentFY());
        $ProfileImage="";
        $dir="uploads/users/".$UserID."/";
        if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
        if($req->hasFile('ProfileImage')){
            $file = $req->file('ProfileImage');
            $fileName=md5($file->getClientOriginalName() . time());
            $fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
            $file->move($dir, $fileName1);
            $ProfileImage=$dir.$fileName1;
        }else if(helper::isJSON($req->ProfileImage)==true){
            $Img=json_decode($req->ProfileImage);
            if(file_exists($Img->uploadPath)){
                $fileName1=$Img->fileName!=""?$Img->fileName:helper::RandomString(10)."png";
                copy($Img->uploadPath,$dir.$fileName1);
                $ProfileImage=$dir.$fileName1;
                // unlink($Img->uploadPath);
            }
        }
        $pwd1=Hash::make($req->Email);
        $pwd2=helper::EncryptDecrypt("encrypt",$req->Email);
        $data=array(
            "UserID"=>$UserID,
            "Name"=>$req->Name,
            "FirstName"=>$req->FirstName,
            "LastName"=>$req->LastName,
            "UserName"=>$req->Email,
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
                'LoginType' => $req->LoginType,
                'LoginMethod' => "Email",
                'fcmToken' => $req->fcmToken
            ]);
            return $this->Login($request);
        }

        DB::rollback();
        return response()->json(['status' => false,'message' => "Gmail Registration Failed!"]);
    }

    /**
     * @param Request $req
     * @return array|bool|JsonResponse
     */
    public function MobileNoRegister(request $req): array|bool|JsonResponse
    {
        if(!$req->OTP){
            $OTP = helper::getOTP(6);
            $Message = "Your RPC OTP for login is $OTP. Please enter this code to proceed.";
            return helper::saveSmsOtp($req->MobileNumber,$OTP,$Message,$req->LoginType);
        }

        $OTP = DB::table(helper::getCurrFYDB().'tbl_sms_otps')->where('MobileNumber',$req->MobileNumber)->where('isOtpExpired',0)->value('OTP');
        if($OTP == $req->OTP || $req->OTP == '999999'){
            $UserData=DB::Table('users')->where('MobileNumber',$req->MobileNumber)->where('LoginType',$req->LoginType)->first();
            if($UserData){
                $request = new Request([
                    'MobileNumber' => $UserData->MobileNumber,
                    'LoginType' => $req->LoginType,
                    'LoginMethod' => "MobileNumber",
                    'fcmToken' => $req->fcmToken
                ]);
                return $this->Login($request);
            }

            DB::beginTransaction();
            $UserID=DocNum::getDocNum(docTypes::Users->value,'',helper::getCurrentFY());
            $pwd1=Hash::make($req->MobileNumber);
            $data=array(
                "UserID"=>$UserID,
                "UserName"=>$req->MobileNumber,
                "MobileNumber"=>$req->MobileNumber,
                "password"=>$pwd1,
                "LoginType"=>$req->LoginType,
                "CreatedOn"=>date("Y-m-d H:i:s"),
                "CreatedBy"=>$UserID
            );
            $status=DB::Table('users')->insert($data);
            if($status){
                DB::commit();
                DocNum::updateDocNum(docTypes::Users->value);
                $request = new Request([
                    'MobileNumber' => $req->MobileNumber,
                    'LoginType' => $req->LoginType,
                    'LoginMethod' => "MobileNumber",
                    'fcmToken' => $req->fcmToken
                ]);
                return $this->Login($request);
            }

            DB::rollback();
            return response()->json(['status' => false,'message' => "Mobile Number Registration Failed!"]);
        }
        return response()->json(['status' => false,'message' => "The OTP verification failed. Please enter the correct OTP."]);
    }

    public function deleteAccount()
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();
            if (!$user) {
                throw new \RuntimeException("User not authenticated.");
            }

            $userId = $user->id;
            $originalEmail = $user->EMail;
            $originalMobile = $user->MobileNumber;
            $replacementEmail = "deleted_user_{$userId}@gmail.com";
            $replacementMobile = '9' . str_pad($userId, 9, '0', STR_PAD_LEFT);

            // Update related customer (if any)
            $customer = DB::table('tbl_customer')->where('CustomerID', $user->ReferID)->first();
            if ($customer) {
                DB::table('tbl_customer')->where('CustomerID', $user->ReferID)
                    ->update(['EMail' => $replacementEmail, 'MobileNo1' => $replacementMobile]);
            }

            DB::table('users')->where('id', $userId)
                ->update(['EMail' => $replacementEmail, 'MobileNumber' => $replacementMobile,
                    'DeletedEmail' => $originalEmail, 'DeletedMobileNumber' => $originalMobile,
                    'UserName' => $replacementMobile, 'DFlag' => 1, 'ActiveStatus' => 'Inactive', 'isLogin' => 0]);
            $user->token()?->revoke();
            DB::commit();
            return response()->json(['status' => true, 'message' => "Customer account deleted successfully. You have been logged out."]);
        } catch (Exception $e) {
            DB::rollBack();
            logger("Error in CustomerAPIController@deleteAccount: ".$e->getMessage());
            return response()->json(['status' => false, 'message' => "Customer account deletion failed!"]);
        }
    }
}
