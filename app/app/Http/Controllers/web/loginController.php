<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Helper;
use logs;
use ValidUnique;
use ValidDB;
use DocNum;
use docTypes;
use Illuminate\Support\Facades\Hash;

class loginController extends Controller
{
    public function login(Request $req)
    {
        $remember_me = $req->has('remember') ? true : false;
        $return = array('status' => false);

        $query = DB::table('users')->where('LoginType', $req->LoginType);

        if (isset($req->LoginMethod) && $req->LoginMethod == "MobileNumber") {
            $query->where('MobileNumber', $req->MobileNumber);
        } elseif ($req->LoginMethod == "Email") {
            $query->where('UserName', $req->email);
        }

        $result = $query->first();

        if ($result) {
            if (($result->DFlag == 0) && ($result->ActiveStatus == 'Active') && ($result->isLogin == 1)) {
                logger(json_encode($result));
                $credentials = [
                    'UserName' => $result->UserName,
                    'password' => $result->UserName,
                    'LoginType' => $req->LoginType,
                    'ActiveStatus' => 1,
                    'DFlag' => 0,
                    'isLogin' => 1
                ];
                logger("credentials");
                logger($credentials);
                if (Auth::attempt($credentials, $remember_me)) {
                    logger("Login success");
                    return array("status" => true, "message" => "Login Successfully");
                } else {
                    logger("Login failed");
                    $return['message'] = 'Login failed';
                    $return['password'] = 'The user name and password do not match.';
                }
            } elseif ($result->DFlag == 1) {
                $return['message'] = 'Your account has been deleted.';
            } elseif ($result->ActiveStatus == 0) {
                $return['message'] = 'Your account has been disabled.';
            } elseif ($result->isLogin == 0) {
                $return['message'] = 'You do not have login rights.';
            }
        } else {
            $return['message'] = 'Login failed';
            $return['email'] = 'User name does not exist. Please verify the user name.';
        }
        return $return;
    }

    public function MobileNoRegister(Request $req)
    {
        logger("req req");
        logger($req);
        if (!$req->OTP) {
            $OTP = Helper::getOTP(6);
            logger("jasbch OTP");
            logger($OTP);
            $Message = "Your RPC OTP for login is $OTP. Please enter this code to proceed.";
            Helper::saveSmsOtp($req->MobileNumber, $OTP, $Message, $req->LoginType);
            return response()->json(['status' => true, 'message' => "OTP sent!"]);
        } else {
            $OTP = DB::table(Helper::getCurrFYDB() . 'tbl_sms_otps')->where('MobileNumber', $req->MobileNumber)->where('isOtpExpired', 0)->value('OTP');
            logger("OTP");
            logger($OTP);
            if ($OTP == $req->OTP) {
                $UserData = DB::Table('users')->where('MobileNumber', $req->MobileNumber)->where('LoginType', $req->LoginType)->first();
                logger("wxbjh UserData");
                logger(json_encode($UserData));
                if ($UserData) {
                    logger("User data found");
                    $request = new Request([
                        'MobileNumber' => $UserData->MobileNumber,
                        'LoginType' => $req->LoginType,
                        'LoginMethod' => "MobileNumber"
                    ]);
                    return $this->Login($request);
                } else {
                    logger("User data not found");
                    DB::beginTransaction();
                    $UserID = DocNum::getDocNum(docTypes::Users->value, '', Helper::getCurrentFY());
                    $pwd1 = Hash::make($req->MobileNumber);
                    $data = array(
                        "UserID" => $UserID,
                        "UserName" => $req->MobileNumber,
                        "MobileNumber" => $req->MobileNumber,
                        "password" => $pwd1,
                        "LoginType" => $req->LoginType,
                        "CreatedOn" => date("Y-m-d H:i:s"),
                        "CreatedBy" => $UserID
                    );
                    $status = DB::Table('users')->insert($data);
                    if ($status) {
                        DB::commit();
                        DocNum::updateDocNum(docTypes::Users->value);
                        $request = new Request([
                            'MobileNumber' => $req->MobileNumber,
                            'LoginType' => $req->LoginType,
                            'LoginMethod' => "MobileNumber",
                        ]);
                        return $this->Login($request);
                    } else {
                        DB::rollback();
                        return response()->json(['status' => false, 'message' => "Mobile Number Registration Failed!"]);
                    }
                    return response()->json(['status' => true, 'message' => "OTP Verified Successfully!", 'data' => ['user_data' => ['MobileNumber' => $req->MobileNumber, 'LoginType' => $req->LoginType], 'isNewUser' => true]]);
                }
            } else {
                return response()->json(['status' => false, 'message' => "The OTP verification failed. Please enter the correct OTP."]);
            }
        }
    }
}
