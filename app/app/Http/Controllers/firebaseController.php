<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class firebaseController extends Controller{

    public function getFirebaseConfig(Request $req){
        $fConfig=array(
            "apiKey" => config("app.FIREBASE_API_KEY"),
            "authDomain" => config("app.FIREBASE_AUTH_DOMAIN"),
//            "databaseURL"=> config("app.FIREBASE_DATABASE_URL"),
            "projectId" => config("app.FIREBASE_PROJECT_ID"),
            "storageBucket" => config("app.FIREBASE_STORAGE_BUCKET"),
            "messagingSenderId" => config("app.FIREBASE_SENDER_ID"),
            "appId" => config("app.FIREBASE_APP_ID"),
            "measurementId" => config("app.FIREBASE_MEASUREMENT_ID"),
        );
        $UserID=Auth::check() ?  Auth()->user()->UserID : "";
        $LoginType=Auth::check() ?  Auth()->user()->LoginType : "";
        $fcmToken="";
        if($UserID!=""){
            $t=DB::Table('users')->where('UserID',$req->UserID)->get();
            if(count($t)>0){
                $fcmToken=$t[0]->WebFcmToken;
            }
        }
        return array("firebaseConfig"=>$fConfig,"UserID"=>$UserID,"fcmToken"=>$fcmToken,"LoginType"=>$LoginType);
    }

    public function saveFCMToken(Request $req){
        DB::Table('users')->where('UserID',$req->UserID)->update(array("WebFcmToken"=>$req->fcmToken));
    }
}
