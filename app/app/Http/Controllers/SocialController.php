<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Socialite;
use DocNum;
use Hash;
use DB;
use Helper;
use docTypes;
use Auth;
class SocialController extends Controller{
    public function redirect(Request $req,$provider){
        return Socialite::driver($provider)->redirect();
    }
    public function signup_redirect(Request $req,$provider){
        return Socialite::driver($provider)->redirect();

    }
    private function CreateUser($req,$getInfo,$provider){
        $result=DB::Table('users')->where('Provider',$provider)->where('ProviderID',$getInfo->id)->first();
        if(!$result){
            DB::beginTransaction();
            $avatar="";
            if($provider=="facebook"){
                $avatar= "https://graph.facebook.com/".$getInfo->id."/picture";
            }elseif($provider!="facebook"){
                $avatar=$getInfo->getAvatar();
            }
            $UserID=DocNum::getDocNum(docTypes::Users->value,"",Helper::getCurrentFY());
            
            $pwd1=Hash::make($getInfo->id);
            $pwd2=Helper::EncryptDecrypt("encrypt",$getInfo->id);
            $data=array(
                "UserID"=>$UserID,
                "Name"=>$getInfo->user->name,
                "FirstName"=>$getInfo->user->given_name,
                "LastName"=>$getInfo->user->family_name,
                "UserName"=>$getInfo->user->email,
                "password"=>$pwd1,
                "password1"=>$pwd2,
                "LoginType"=>"Customer",
                "EMail"=>$getInfo->user->email,
                "isLogin"=>1,
                "Provider"=>$provider,
                "ProviderID"=>$getInfo->id,
                "ProfileImage"=>$avatar,
                "CreatedOn"=>date("Y-m-d H:i:s"),
                "CreatedBy"=>$UserID
            );
            $status=DB::Table('users')->insert($data);
            if($status){
                DB::commit();
                DocNum::updateDocNum(docTypes::Users->value);
                return true;
            }else{
                DB::rollback();
                return false;
            }
        }else{
            return true;
        }
    }
    private function SocialAuth($req,$getInfo,$provider){
        
        $result=$this->CreateUser($req,$getInfo,$provider);
        if ($result) {
            $remember_me = true;
            $authResult = Auth::attempt(['Provider' => $provider,'ProviderID' => $getInfo->id,'password' => $getInfo->id,'ActiveStatus' => 'Active','DFlag' => 0,'isLogin' => 1], $remember_me);
            if ($authResult) {
                return Helper::getUserInfo(Auth()->user()->UserID);
            } else {
                return "error.400";
            }
        }
    }
    public function callback(Request $req,$provider){
        
	    $getInfo=null;
	  	try {
			$getInfo = Socialite::driver($provider)->user();
		} catch (InvalidStateException $e) {
			$getInfo = Socialite::driver($provider)->stateless()->user();
		}
        $getInfo->user=json_decode(json_encode($getInfo->user));
		if($getInfo==null){
			return redirect('/auth/redirect/'.$provider);
		}else{
			$getInfo1=(array)$getInfo;
			if((array_key_exists("id",$getInfo1))&&(array_key_exists("email",$getInfo1))&&(array_key_exists("name",$getInfo1))){
			}else{
                return redirect('/auth/redirect/'.$provider);
			}
		}
        $result=$this->SocialAuth($req,$getInfo,$provider);
        // return $result;

        if($result=="auth"){
            return redirect('/auth/redirect/'.$provider);
        }elseif($result['data']->ReferID){
            return redirect('/customer-home');
        }elseif(!$result['data']->ReferID){
            return redirect('/customer-register');
        }else{
            return view("errors.400");
        }
        /*
        if($callback_type=="signup"){
			$avatar="";
			if($provider=="facebook"){
				$avatar= "https://graph.facebook.com/".$getInfo->id."/picture";
			}elseif($provider!="facebook"){
				$avatar=$getInfo->getAvatar();
			}
			$data=array(
				"CompanyName"=>$getInfo->name,
				"ShortCode"=>$Code,
				"Email"=>$getInfo->email,
				"Logo"=>$avatar,
				'SchemeID'=>$SchemeID,
				'email_verify'=>1,
				'provider'=>$provider,
				'provider_id'=>$getInfo->id,
			);
			return $this->Registration($data);
			//return redirect('/app');
        }else{
            //$login=new loginController();
            //return $login->AuthCheck(array("provider_id"=>$getInfo->id),$req->ip(),true);
        }*/
        
    }
}
