<?php

namespace App\Http\Controllers\api\customer;

use App\enums\docTypes;
use App\Events\chatApp;
use App\helper\helper;
use App\Http\Controllers\Controller;
use App\Models\DocNum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use App\Rules\ValidUnique;
use App\Rules\ValidDB;
use logs;
use PHPUnit\TextUI\Help;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\select;

class CustomerAuthController extends Controller{
    private $generalDB;
    private $tmpDB;
    private $currfyDB;
    private $FileTypes;
	private $UserID;
	private $ReferID;

    public function __construct(){
		$this->generalDB=Helper::getGeneralDB();
		$this->tmpDB=Helper::getTmpDB();
        $this->currfyDB=Helper::getCurrFYDB();
        $this->SupportDB=Helper::getSupportDB();
		$this->FileTypes=Helper::getFileTypes(array("category"=>array("Images","Documents")));
        $this->middleware('auth:api');
        $this->middleware(function ($request, $next) {
			$this->UserID=auth()->user()->UserID;
			$this->ReferID=auth()->user()->ReferID;
			return $next($request);
		});
    }
    public function Register(Request $req){
        $reqData = $req->all();

        $NewData=$OldData=[];
		$ValidDB=[];

        $ValidDB['Country']['TABLE']=$this->generalDB."tbl_countries";
        $ValidDB['Country']['ErrMsg']="Country name does not exist";
        $ValidDB['Country']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$reqData['CountryID']);
        $ValidDB['Country']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>"Active");
        $ValidDB['Country']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

        $ValidDB['State']['TABLE']=$this->generalDB."tbl_states";
        $ValidDB['State']['ErrMsg']="State name does not exist";
        $ValidDB['State']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$reqData['CountryID']);
        $ValidDB['State']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$reqData['StateID']);
        $ValidDB['State']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>"Active");
        $ValidDB['State']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

        $ValidDB['District']['TABLE']=$this->generalDB."tbl_districts";
        $ValidDB['District']['ErrMsg']="District name does not exist";
        $ValidDB['District']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$reqData['CountryID']);
        $ValidDB['District']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$reqData['StateID']);
        $ValidDB['District']['WHERE'][]=array("COLUMN"=>"DistrictID","CONDITION"=>"=","VALUE"=>$reqData['DistrictID']);
        $ValidDB['District']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>"Active");
        $ValidDB['District']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

        $ValidDB['Taluk']['TABLE']=$this->generalDB."tbl_taluks";
        $ValidDB['Taluk']['ErrMsg']="Taluk name does not exist";
        $ValidDB['Taluk']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$reqData['CountryID']);
        $ValidDB['Taluk']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$reqData['StateID']);
        $ValidDB['Taluk']['WHERE'][]=array("COLUMN"=>"DistrictID","CONDITION"=>"=","VALUE"=>$reqData['DistrictID']);
        $ValidDB['Taluk']['WHERE'][]=array("COLUMN"=>"TalukID","CONDITION"=>"=","VALUE"=>$reqData['TalukID']);
        $ValidDB['Taluk']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>"Active");
        $ValidDB['Taluk']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

        $ValidDB['PostalCode']['TABLE']=$this->generalDB."tbl_postalcodes";
        $ValidDB['PostalCode']['ErrMsg']="Postal Code does not exist";
        $ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$reqData['CountryID']);
        $ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$reqData['StateID']);
        $ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"DistrictID","CONDITION"=>"=","VALUE"=>$reqData['DistrictID']);
        $ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"PID","CONDITION"=>"=","VALUE"=>$reqData['PostalCodeID']);
        $ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>"Active");
        $ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

        $ValidDB['City']['TABLE']=$this->generalDB."tbl_cities";
        $ValidDB['City']['ErrMsg']="City Name does not exist";
        $ValidDB['City']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$reqData['CountryID']);
        $ValidDB['City']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$reqData['StateID']);
        $ValidDB['City']['WHERE'][]=array("COLUMN"=>"DistrictID","CONDITION"=>"=","VALUE"=>$reqData['DistrictID']);
        $ValidDB['City']['WHERE'][]=array("COLUMN"=>"TalukID","CONDITION"=>"=","VALUE"=>$reqData['TalukID']);
        $ValidDB['City']['WHERE'][]=array("COLUMN"=>"PostalID","CONDITION"=>"=","VALUE"=>$reqData['PostalCodeID']);
        $ValidDB['City']['WHERE'][]=array("COLUMN"=>"CityID","CONDITION"=>"=","VALUE"=>$reqData['CityID']);
        $ValidDB['City']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>"Active");
        $ValidDB['City']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);


        $rules=array(
            'MobileNo1' =>['required','max:10',new ValidUnique(array("TABLE"=>"users","WHERE"=>" MobileNumber='".$req->MobileNo1."' and LoginType = 'Customer' and UserID <> '".$this->UserID."' "),"This Mobile Number is already taken.")],
            'Email' =>['required','max:50',new ValidUnique(array("TABLE"=>"users","WHERE"=>" EMail='".$req->Email."' and LoginType = 'Customer' and UserID <> '".$this->UserID."' "),"This Email is already taken.")],
        );
        if($req->hasFile('CustomerImage')){
            $rules['CustomerImage']='mimes:'.implode(",",$this->FileTypes['category']['Images']);
        }

        $message=array(
            'CustomerImage.mimes'=>"The Customer Image field must be a file of type: ".implode(", ",$this->FileTypes['category']['Images'])."."
        );
        $validator = Validator::make($req->all(), $rules,$message);

        if ($validator->fails()) {
            return array('status'=>false,'message'=>"Customer Create Failed",'errors'=>$validator->errors());
        }

        DB::beginTransaction();
        $status=false;
        try {
            $CustomerID = DocNum::getDocNum(docTypes::Customer->value, "", Helper::getCurrentFY());
            $CustomerImage = "";
            $dir = "uploads/user-and-permissions/customers/" . $CustomerID . "/";
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            if ($req->hasFile('CustomerImage')) {
                $file = $req->file('CustomerImage');
                $fileName = md5($file->getClientOriginalName() . time());
                $fileName1 = $fileName . "." . $file->getClientOriginalExtension();
                $file->move($dir, $fileName1);
                $CustomerImage = $dir . $fileName1;
            } else if (Helper::isJSON($req->CustomerImage) == true) {
                $Img = json_decode($req->CustomerImage);
                if (file_exists($Img->uploadPath)) {
                    $fileName1 = $Img->fileName != "" ? $Img->fileName : Helper::RandomString(10) . "png";
                    copy($Img->uploadPath, $dir . $fileName1);
                    $CustomerImage = $dir . $fileName1;
                    // unlink($Img->uploadPath);
                }
            }
            $CompleteAddress = Helper::formAddress($req->Address,$req->CityID);
            $data=array(
                "CustomerID"=>$CustomerID,
                "CustomerName"=>$req->CustomerName,
                'CustomerImage'=>$CustomerImage,
                "GenderID"=>$req->GenderID,
                "DOB"=>$req->DOB,
                "MobileNo1"=>$req->MobileNo1,
                "MobileNo2"=>$req->MobileNo2,
                "Email"=>$req->Email,
                "CusTypeID"=>$req->CusTypeID,
                "ConTypeIDs"=>serialize(json_decode($req->ConTypeIDs)),
                "Address"=>$req->Address,
                "CompleteAddress"=>$CompleteAddress,
                "PostalCodeID"=>$req->PostalCodeID,
                "CityID"=>$req->CityID,
                "TalukID"=>$req->TalukID,
                "DistrictID"=>$req->DistrictID,
                "StateID"=>$req->StateID,
                "CountryID"=>$req->CountryID,
                "CreatedBy"=>$CustomerID,
                "CreatedOn"=>date("Y-m-d H:i:s")
            );
            // return $data;
            $status=DB::Table('tbl_customer')->insert($data);
            if($status){
                $customerName = $reqData['CustomerName'];
                $nameParts = explode(' ', $customerName, 2);
                $firstName = $nameParts[0] ?? '';
                $lastName = $nameParts[1] ?? '';
                $pwd1=Hash::make($req->Email);

                $Udata=array(
                    "ReferID"=>$CustomerID,
                    "Name" => $customerName,
                    "GenderID"=>$req->GenderID,
                    "ProfileImage"=>$CustomerImage,
                    "FirstName" => $firstName,
                    "LastName" => $lastName,
                    "MobileNumber"=>$req->MobileNo1,
                    "EMail"=>$req->Email,
                    "UserName"=>$req->Email,
                    "password"=>$pwd1,
                    "Address"=>$req->Address,
                    "PostalCodeID"=>$req->PostalCodeID,
                    "CityID"=>$req->CityID,
                    "TalukID"=>$req->TalukID,
                    "DistrictID"=>$req->DistrictID,
                    "StateID"=>$req->StateID,
                    "CountryID"=>$req->CountryID,
                    "UpdatedBy"=>$CustomerID,
                );
                $status=DB::Table('users')->where('UserID',$this->UserID)->update($Udata);
                if($status){
                    DB::table('tbl_unregistered_users')->where('LoginType','Customer')->where('MobileNumber',$req->MobileNo1)->delete();
                }
            }
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            DocNum::updateDocNum(docTypes::Customer->value);
            $NewData=(array)DB::table('tbl_customer_address as CA')->leftJoin('tbl_customer as C','CA.CustomerID','C.CustomerID')->where('CA.CustomerID',$CustomerID)->get();
            $logData=array("Description"=>"New Customer Created","ModuleName"=>"Customer","Action"=>"Add","ReferID"=>$CustomerID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$CustomerID,"IP"=>$req->ip());
            logs::Store($logData);
            return response()->json(['status' => true,'message' => "Customer Registered Successfully"]);

        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Customer Register Failed"]);
        }
    }

    public function Update(Request $req){
		$CustomerID = $this->ReferID;
		$OldData=DB::table('tbl_customer_address as CA')->leftJoin('tbl_customer as C','C.CustomerID','CA.CustomerID')->where('CA.CustomerID',$CustomerID)->get();
		$NewData=array();

		$rules=array(
			'MobileNo1' =>['required','max:10',new ValidUnique(array("TABLE"=>"tbl_customer","WHERE"=>" MobileNo1='".$req->MobileNo1."' and CustomerID <> '".$CustomerID."' "),"This Mobile Number is already taken.")],
		);

		$message=array();
		$validator = Validator::make($req->all(), $rules,$message);

		if ($validator->fails()) {
			return array('status'=>false,'message'=>"Customer Update Failed",'errors'=>$validator->errors());
		}
		DB::beginTransaction();
		$status=false;
		try {
			$CustomerImage="";
			$dir="uploads/user-and-permissions/customers/".$CustomerID."/";
			if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}

			if($req->CustomerImage && Helper::isJSON($req->CustomerImage)==true){
				$Img=json_decode($req->CustomerImage);
                if (isset($Img->uploadPath) && file_exists($Img->uploadPath)) {
					$fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
					copy($Img->uploadPath,$dir.$fileName1);
					$CustomerImage=$dir.$fileName1;
					// unlink($Img->uploadPath);
				}
			}
			$data=array(
				"CustomerName"=>$req->CustomerName,
				"MobileNo1"=>$req->MobileNo1,
				"MobileNo2"=>$req->MobileNo2,
                "GenderID"=>$req->GenderID,
                "DOB"=>$req->DOB,
				"CusTypeID"=>$req->CusTypeID,
                "ConTypeIDs"=>serialize(json_decode($req->ConTypeIDs)),
				"Address"=>$req->Address,
				"PostalCodeID"=>$req->PostalCodeID,
				"CityID"=>$req->CityID,
				"TalukID"=>$req->TalukID,
				"DistrictID"=>$req->DistrictID,
				"StateID"=>$req->StateID,
				"CountryID"=>$req->CountryID,
				"UpdatedBy"=>$this->UserID,
				"UpdatedOn"=>date("Y-m-d H:i:s")
			);
			if($CustomerImage){
				$data['CustomerImage']=$CustomerImage;
			}
			$status=DB::Table('tbl_customer')->where('CustomerID',$CustomerID)->update($data);
			if($status){
				$AIDs=[];
				if($req->has('SAddress')){
                    $SAddress=json_decode($req->SAddress,true);
                    foreach($SAddress as $row){
                        if($row['AID']){
                            $AIDs[] = $row['AID'];
                            $data=array(
                                "Address"=>$row['Address'],
                                "PostalCodeID"=>$row['PostalCodeID'],
                                "CityID"=>$row['CityID'],
                                "TalukID"=>$row['TalukID'],
                                "DistrictID"=>$row['DistrictID'],
                                "StateID"=>$row['StateID'],
                                "CountryID"=>$row['CountryID'],
                                "isDefault"=>$row['isDefault'],
                                "UpdatedOn"=>date("Y-m-d H:i:s")
                            );
                            $status=DB::Table('tbl_customer_address')->where('CustomerID',$CustomerID)->where('AID',$row['AID'])->update($data);
                        }else{
                            $AID=DocNum::getDocNum(docTypes::CustomerAddress->value,"",Helper::getCurrentFY());
                            $AIDs[] = $AID;
                            $tmp=array(
                                "AID"=>$AID,
                                "CustomerID"=>$CustomerID,
                                "Address"=>$row['Address'],
                                "PostalCodeID"=>$row['PostalCodeID'],
                                "CityID"=>$row['CityID'],
                                "TalukID"=>$row['TalukID'],
                                "DistrictID"=>$row['DistrictID'],
                                "StateID"=>$row['StateID'],
                                "CountryID"=>$row['CountryID'],
                                "isDefault"=>$row['isDefault'],
                                "CreatedOn"=>date("Y-m-d H:i:s")
                            );
                            $status=DB::Table('tbl_customer_address')->insert($tmp);
                            if($status==true){
                                DocNum::updateDocNum(docTypes::CustomerAddress->value);
                            }
                        }
                    }
                }
			}
			if(count($AIDs)>0){
				DB::table('tbl_customer_address')->where('CustomerID',$CustomerID)->whereNotIn('AID',$AIDs)->update(['DFlag'=>1,'UpdatedBy'=>$CustomerID,'UpdatedOn'=>date('Y-m-d H:i:s')]);
			}
			if($status){
                $CustomerName = $req->CustomerName;
                $nameParts = explode(' ', $CustomerName, 2);
                $firstName = $nameParts[0] ?? '';
                $lastName = $nameParts[1] ?? '';

                $Udata=array(
                    "Name" => $CustomerName,
                    "FirstName" => $firstName,
                    "LastName" => $lastName,
					"GenderID"=>$req->GenderID,
					"DOB"=>$req->DOB,
                    "MobileNumber"=>$req->MobileNo1,
					"Address"=>$req->Address,
					"PostalCodeID"=>$req->PostalCodeID,
					"CityID"=>$req->CityID,
					"TalukID"=>$req->TalukID,
					"DistrictID"=>$req->DistrictID,
					"StateID"=>$req->StateID,
					"CountryID"=>$req->CountryID,
					"UpdatedBy"=>$CustomerID,
					"UpdatedOn"=>date("Y-m-d H:i:s")
                );
                if($CustomerImage){
                    $Udata['ProfileImage']=$CustomerImage;
                }
				$status=DB::Table('users')->where('UserID',$this->UserID)->where('ReferID',$CustomerID)->update($Udata);
            }

		}catch(Exception $e) {
			$status=false;
		}
		if($status==true){
			DB::commit();
			$NewData=DB::table('tbl_customer_address as CA')->leftJoin('tbl_customer as C','C.CustomerID','CA.CustomerID')->where('CA.CustomerID',$CustomerID)->get();
			$logData=array("Description"=>"Customer Updated ","ModuleName"=>"Customer","Action"=>"Update","ReferID"=>$CustomerID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
			logs::Store($logData);
            return response()->json(['status' => true,'message' => "Customer Updated Successfully"]);
		}else{
			DB::rollback();
            return response()->json(['status' => false,'message' => "Customer Update Failed"]);
		}
	}
    public function getSAddress(Request $req){
        $CustomerID = $this->ReferID;
        $SAddress = DB::table('tbl_customer_address as CA')->where('CA.CustomerID',$CustomerID)->where('CA.DFlag',0)
        ->leftJoin($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
        ->leftJoin($this->generalDB.'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
        ->leftJoin($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
        ->leftJoin($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'PC.DistrictID')
        ->leftJoin($this->generalDB.'tbl_states as S', 'S.StateID', 'D.StateID')
        ->leftJoin($this->generalDB.'tbl_countries as C','C.CountryID','S.CountryID')
        ->orderBy('CA.CreatedOn','desc')
        ->select('CA.AID', 'CA.Address', 'CA.isDefault', 'CA.CountryID', 'C.CountryName', 'CA.StateID', 'S.StateName', 'CA.DistrictID', 'D.DistrictName', 'CA.TalukID', 'T.TalukName', 'CA.CityID', 'CI.CityName', 'CA.PostalCodeID', 'PC.PostalCode','CA.Latitude', 'CA.Longitude','CA.CompleteAddress','CA.AddressType')
        ->get();

        return response()->json(['status' => true,'data' => $SAddress]);
    }
    public function UpdateSAddress(Request $req){
		$CustomerID = $this->ReferID;
		$OldData=$NewData=[];
		$OldData=DB::table('tbl_customer_address')->where('CustomerID',$CustomerID)->get();
		$status=false;
		try {
            $CityData = DB::table($this->generalDB.'tbl_postalcodes as P')
            ->join($this->generalDB.'tbl_cities as CI', 'CI.PostalID', 'P.PID')
            ->join($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'CI.TalukID')
            ->join($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'P.DistrictID')
            ->join($this->generalDB.'tbl_states as S', 'S.StateID', 'D.StateID')
            ->join($this->generalDB.'tbl_countries as C','C.CountryID','S.CountryID')
            ->where('P.PostalCode',$req->PostalCode)
            ->where('CI.CityID',$req->CityID)
            ->where('P.ActiveStatus','Active')->where('P.DFlag',0)
            ->where('CI.ActiveStatus','Active')->where('CI.DFlag',0)
            ->where('T.ActiveStatus','Active')->where('T.DFlag',0)
            ->where('D.ActiveStatus','Active')->where('D.DFlag',0)
            ->where('S.ActiveStatus','Active')->where('S.DFlag',0)
            ->where('C.ActiveStatus','Active')->where('C.DFlag',0)
            ->select('P.PID as PostalCodeID','CI.CityID','T.TalukID','D.DistrictID','S.StateID','C.CountryID')->first();

            if(!$CityData){
                $data = [
                    'UserID'=>$this->UserID,
                    'CityID'=>$req->CityID,
                    'PostalCode'=>$req->PostalCode,
                    'Latitude'=>$req->Latitude,
                    'Longitude'=>$req->Longitude,
                    'MapData'=>serialize(json_decode($req->MapData))
                ];
                $status = DB::table($this->currfyDB.'tbl_not_serving_locations')->insert($data);
                if($status){
                    return response()->json(['status' => false,'message' => "Postal Code does not exist!"]);
                }
            }else{
                DB::beginTransaction();
                $MapData = serialize(json_decode($req->MapData));
                $AID=DocNum::getDocNum(docTypes::CustomerAddress->value,"",Helper::getCurrentFY());
                $data=array(
                    "AID"=>$AID,
                    "CustomerID"=>$CustomerID,
                    "CompleteAddress"=>$req->CompleteAddress,
                    "Address"=>Helper::trimAddress($req->CompleteAddress),
                    "AddressType"=>$req->AddressType,
                    "PostalCodeID"=>$CityData->PostalCodeID,
                    "CityID"=>$CityData->CityID,
                    "TalukID"=>$CityData->TalukID,
                    "DistrictID"=>$CityData->DistrictID,
                    "StateID"=>$CityData->StateID,
                    "CountryID"=>$CityData->CountryID,
                    "Latitude"=>$req->Latitude,
                    "Longitude"=>$req->Longitude,
                    "MapData"=>$MapData,
                    "isDefault"=>1,
                    "CreatedOn"=>date("Y-m-d H:i:s")
                );
                $status=DB::Table('tbl_customer_address')->insert($data);
                if($status==true){
                    DB::Table('tbl_customer_address')->where('CustomerID',$CustomerID)->whereNot('AID',$AID)->update(['isDefault' =>0]);
                    DocNum::updateDocNum(docTypes::CustomerAddress->value);
                }
            }
		}catch(Exception $e) {
			$status=false;
		}
		if($status==true){
			DB::commit();
            DB::Table('tbl_customer_cart')->where('CustomerID',$CustomerID)->delete();
            $NewData=DB::table('tbl_customer_address')->where('CustomerID',$CustomerID)->get();
			$logData=array("Description"=>"Shipping Address Updated","ModuleName"=>"Customer","Action"=>"Update","ReferID"=>$AID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
			logs::Store($logData);
            return response()->json(['status' => true,'message' => "Shipping Address Updated Successfully"]);
		}else{
			DB::rollback();
            return response()->json(['status' => false,'message' => "Shipping Address Update Failed"]);
		}
	}
    public function SetDefault(Request $req){
        $CustomerID = $this->ReferID;
        DB::beginTransaction();
        $status=false;
        try {
            $status=DB::Table('tbl_customer_address')->where('CustomerID',$CustomerID)->whereNot('AID',$req->AID)->update(['isDefault' =>0]);
            $status=DB::Table('tbl_customer_address')->where('CustomerID',$CustomerID)->where('AID',$req->AID)->update(['isDefault' =>1,'UpdatedBy'=>$CustomerID,'UpdatedOn'=>date("Y-m-d H:i:s")]);
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            DB::Table('tbl_customer_cart')->where('CustomerID',$CustomerID)->delete();
            return response()->json(['status' => true,'message' => "Default Address Set Successfully"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Default Address Set Failed!"]);
        }
    }

    public function DeleteSAddress(Request $req){
        $CustomerID = $this->ReferID;
        DB::beginTransaction();
        $status=false;
        try {
            $isDefault=DB::Table('tbl_customer_address')->where('CustomerID',$CustomerID)->where('AID',$req->AID)->where('isDefault',1)->exists();
            if($isDefault){
                return response()->json(['status' => false,'message' => "Default Address cannot be deleted!"]);
            }else{
                $status=DB::Table('tbl_customer_address')->where('CustomerID',$CustomerID)->where('AID',$req->AID)->update(['DFlag'=>1,'UpdatedBy'=>$CustomerID,'UpdatedOn'=>date('Y-m-d H:i:s')]);
            }
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            return response()->json(['status' => true,'message' => "Shipping Address Deleted Successfully"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Shipping Address Deleted Failed!"]);
        }
    }

    public function CustomerData(request $req){
        $CustomerID = $this->ReferID;
        $CustomerData = DB::Table('tbl_customer as CU')->leftJoin($this->generalDB.'tbl_postalcodes as P','P.PID','CU.PostalCodeID')->where('CU.CustomerID',$CustomerID)
        ->select('CustomerID','CustomerName','DOB','MobileNo1','MobileNo2','Email','CustomerImage','CusTypeID','ConTypeIDs','GenderID','Address','CityID','TalukID','CU.DistrictID','CU.StateID','CU.CountryID','PostalCodeID','P.PostalCode','CU.DFlag','CU.ActiveStatus')
        ->first();
        if(!$CustomerData){
            return response()->json(['status' => false,'message' => "No Customers Found! Contact Admin"]);
        }elseif($CustomerData->DFlag == 1){
            return response()->json(['status' => false,'message' => "Customer has been Deleted! Contact Admin"]);
        }elseif($CustomerData->ActiveStatus =='Inactive'){
            return response()->json(['status' => false,'message' => "You are currently inactive! Contact Admin"]);
        }else{
            $CustomerImagePath = $CustomerData->CustomerImage;
            $CustomerImageURL = file_exists($CustomerImagePath) ? url('/') . '/' . $CustomerData->CustomerImage : url('/') . '/assets/images/no-image-b.png';
            $CustomerData->CustomerImage = $CustomerImageURL;
            $CustomerData->ProfileCompletePercent = 0;
            $CustomerData->ConTypeIDs = unserialize($CustomerData->ConTypeIDs);
            $CustomerData->SAddress = DB::table('tbl_customer_address as CA')->where('CustomerID',$CustomerID)->where('isDefault',1)
            ->leftJoin($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
            ->leftJoin($this->generalDB.'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
            ->leftJoin($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
            ->leftJoin($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'PC.DistrictID')
            ->leftJoin($this->generalDB.'tbl_states as S', 'S.StateID', 'D.StateID')
            ->leftJoin($this->generalDB.'tbl_countries as C','C.CountryID','S.CountryID')
            ->orderBy('CA.CreatedOn','desc')
            ->select('CA.AID', 'CA.Address', 'CA.isDefault', 'CA.CountryID', 'C.CountryName', 'CA.StateID', 'S.StateName', 'CA.DistrictID', 'D.DistrictName', 'CA.TalukID', 'T.TalukName', 'CA.CityID', 'CI.CityName', 'CA.PostalCodeID', 'PC.PostalCode','CA.Latitude', 'CA.Longitude','CA.CompleteAddress','CA.AddressType')
            ->first();
            return response()->json([
                'status' => true,
                'data' => $CustomerData,
            ]);
        }

	}

    public function getConstructionType(request $req){
		$return = [
			'status' => true,
			'data' => DB::Table('tbl_construction_type')->where('ActiveStatus','Active')->where('DFlag',0)
            ->select('ConTypeID', 'ConTypeName', DB::raw('IF(ConTypeLogo IS NOT NULL AND ConTypeLogo != "", CONCAT("' . url('/') . '/", ConTypeLogo), "") AS ConTypeLogo'))
            ->get(),
		];
        return $return;
	}
    public function getCustomerType(request $req){
		$return = [
			'status' => true,
			'data' => DB::Table('tbl_customer_type')->where('ActiveStatus','Active')->where('DFlag',0)->select('CusTypeID', 'CusTypeName')->get(),
		];
        return $return;
	}

    public function GetCategory(Request $req){
        $pageNo = $req->PageNo ?? 1;
        $perPage = 15;
        if ($req->AID) {
            $AllVendors = Helper::getAvailableVendors($req->AID);
            $Category = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'VPM.PCID')
                ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
                ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors);
            if ($req->has('SearchText') && !empty($req->SearchText)) {
                $Category->where('PC.PCName', 'like', '%' . $req->SearchText . '%');
            }
            $PCategories = $Category->groupBy('PC.PCID', 'PC.PCName', 'PC.PCImage')
                ->select('PC.PCID', 'PC.PCName', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS CategoryImage'))
                ->paginate($perPage, ['*'], 'page', $pageNo);
            return response()->json([
                'status' => true,
                'data' => $PCategories->items(),
                'CurrentPage' => $PCategories->currentPage(),
                'LastPage' => $PCategories->lastPage(),
            ]);
        } else {
            return response()->json(['status' => false, 'message' => "Shipping Address is required!"]);
        }
    }
	public function GetSubCategory(request $req){
		$PCID = $req->PCID;
        $PCIDs = is_array($PCID) ? $PCID : [$PCID];

        $pageNo = $req->PageNo ?? 1;
        $perPage = 15;

        if ($req->AID) {
            $AllVendors = Helper::getAvailableVendors($req->AID);

            $SubCategory = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_product_subcategory as PSC','PSC.PSCID','VPM.PSCID')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
                ->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
                ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
                ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)->whereIn('PSC.PCID', $PCIDs);
                if ($req->has('SearchText') && !empty($req->SearchText)) {
                    $SubCategory->where('PSC.PSCName', 'like', '%' . $req->SearchText . '%');
                }
            $PSubCategories = $SubCategory->groupBy('PSC.PSCID', 'PSCName', 'PC.PCID', 'PCName', 'PSCImage')
                ->select('PSC.PSCID', 'PSCName','PC.PCID', '.PCName', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PSCImage, ""), "assets/images/no-image-b.png")) AS SubCategoryImage'))
                ->paginate($perPage, ['*'], 'page', $pageNo);
                return response()->json([
                    'status' => true,
                    'data' => $PSubCategories->items(),
                    'CurrentPage' => $PSubCategories->currentPage(),
                    'LastPage' => $PSubCategories->lastPage(),
                ]);
        }else{
            return response()->json(['status' => false,'message' => "Shipping Address is required!"]);
        }

	}
    public function GetProducts(Request $req){
        $PCID = $req->PCID;
        $PSCID = $req->PSCID;
        $PCIDs = is_array($PCID) ? $PCID : [$PCID];
        $PSCIDs = is_array($PSCID) ? $PSCID : [$PSCID];
        $pageNo = $req->PageNo ?? 1;
        $perPage = 15;

        if ($req->AID) {
            $AllVendors = Helper::getAvailableVendors($req->AID);

            $products = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_products as P','P.ProductID','VPM.ProductID')
                ->leftJoin('tbl_product_subcategory as PSC','PSC.PSCID','P.SCID')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
                ->leftJoin('tbl_uom as U', 'U.UID', 'P.UID')
                ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
                ->where('P.ActiveStatus', 'Active')->where('P.DFlag', 0)
                ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
                ->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
                ->whereIn('PSC.PCID', $PCIDs)->whereIn('P.SCID', $PSCIDs);
                if ($req->has('SearchText') && !empty($req->SearchText)) {
                    $products->where('P.ProductName', 'like', '%' . $req->SearchText . '%');
                }
            $Products = $products->groupBy('PSC.PSCID', 'PSCName', 'PC.PCID', 'PCName', 'P.ProductID', 'ProductName', 'ProductImage','UName','UCode','U.UID','P.VideoURL')
                ->select('PSC.PSCID', 'PSCName','PC.PCID', 'PCName', 'P.ProductID', 'ProductName','UName','UCode','U.UID','P.VideoURL', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'))
                ->paginate($perPage, ['*'], 'page', $pageNo);
            return response()->json([
                'status' => true,
                'data' => $Products->items(),
                'CurrentPage' => $Products->currentPage(),
                'LastPage' => $Products->lastPage(),
            ]);
        }else{
            return response()->json(['status' => false,'message' => "Shipping Address is required!"]);
        }
    }

    public function getCart(Request $req){
        $Cart = DB::table('tbl_customer_cart as C')
        ->leftJoin('tbl_products as P','P.ProductID','C.ProductID')
        ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
        ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
        ->leftJoin('tbl_uom as U', 'U.UID', 'P.UID')
        ->where('C.CustomerID', $this->ReferID)
        ->where('P.ActiveStatus', 'Active')->where('P.DFlag', 0)
        ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
        ->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
        ->select('P.ProductName','C.ProductID','C.Qty', 'PC.PCName', 'PC.PCID', 'PSC.PSCName','U.UName','U.UCode','U.UID', 'PSC.PSCID','P.ProductImage')
            ->get()->map(function ($cart) {
            $cart->ProductImage = (new Helper)->fileCheckAndUrl($cart->ProductImage, 'assets/images/no-image-b.png');
            return $cart;
        });

        return response()->json(['status' => true,'data' => $Cart]);
    }
    public function AddCart(Request $req){
        DB::beginTransaction();
        $status=false;
        try {
            $isProductExists = DB::table('tbl_customer_cart')->where('CustomerID',$this->ReferID)->where('ProductID',$req->ProductID)->exists();
            if($isProductExists){
                return response()->json(['status' => false,'message' => "Product already exists!"]);
            }else{
                $data=array(
                    "CustomerID"=>$this->ReferID,
                    "ProductID"=>$req->ProductID,
                );
                $status=DB::Table('tbl_customer_cart')->insert($data);
            }
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            return response()->json(['status' => true,'message' => "Product added to Cart Successfully"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Product add to Cart Failed!"]);
        }
    }
    public function UpdateCart(Request $req){
        DB::beginTransaction();
        $status=false;
        try {
            $status=DB::Table('tbl_customer_cart')->where('CustomerID',$this->ReferID)->where('ProductID',$req->ProductID)->update(['Qty'=>$req->Qty]);
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            return response()->json(['status' => true,'message' => "Product Update Successfully"]);
        }else{
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => "Product Update Failed!",
            ]);
        }
    }
    public function DeleteCart(Request $req){
        DB::beginTransaction();
        $status=false;
        try {
            $status=DB::Table('tbl_customer_cart')->where('CustomerID',$this->ReferID)->where('ProductID',$req->ProductID)->delete();
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            return response()->json(['status' => true,'message' => "Product Deleted Successfully"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Product Deleted Failed!"]);
        }
    }

    public function getCustomerHome(Request $req){
        if ($req->AID) {
            $CustomerHome = [];

            $AllVendors = Helper::getAvailableVendors($req->AID);

            $products = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_products as P','P.ProductID','VPM.ProductID')
                ->leftJoin('tbl_product_subcategory as PSC','PSC.PSCID','P.SCID')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
                ->leftJoin('tbl_uom as U', 'U.UID', 'P.UID')
                ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
                ->where('P.ActiveStatus', 'Active')->where('P.DFlag', 0)
                ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
                ->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
                ->groupBy('PSC.PSCID', 'PSCName', 'PC.PCID', 'PCName', 'P.ProductID', 'ProductName', 'ProductImage','UName','UCode','U.UID','P.VideoURL')
                ->select('PSC.PSCID', 'PSCName','PC.PCID', 'PCName', 'P.ProductID', 'ProductName','UName','UCode','U.UID','P.VideoURL', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'))
                ->inRandomOrder()->take(5)->get();

            $PCategories = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'VPM.PCID')
                ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
                ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
                ->groupBy('PC.PCID', 'PC.PCName', 'PC.PCImage')
                ->select('PC.PCID', 'PC.PCName', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS CategoryImage'))
                ->inRandomOrder()->take(5)->get();
                $CustomerHome['CurrentOrders'] = [];
                $CustomerHome['CompletedOrders'] = [];
                $CustomerHome['RecommendedProducts'] = $products;
                $CustomerHome['PCategories'] = $PCategories;

            return response()->json(['status' => true, 'data' => $CustomerHome ]);
        }else{
            return response()->json(['status' => false,'message' => "Shipping Address is required!"]);
        }
	}
    public function getAllProducts(Request $req){
        $pageNo = $req->PageNo ?? 1;
        $perPage = 10;
        if ($req->AID) {
            $AllVendors = Helper::getAvailableVendors($req->AID);
            $query = DB::table('tbl_products as P')
                ->leftJoin('tbl_product_subcategory as PSC', 'P.SCID', 'PSC.PSCID')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
                ->rightJoin('tbl_vendors_product_mapping as VPM', 'P.ProductID', 'VPM.ProductID')
                ->where('VPM.Status', 1)
                ->whereIn('VPM.VendorID', $AllVendors);
                if($req->SearchText){
                    $query ->where('P.ProductName', 'like', '%' . $req->SearchText . '%');
                }
                $Products = $query->groupBy('P.ProductID', 'P.ProductName', 'PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName','ProductImage')
                ->select('P.ProductID', 'P.ProductName', 'PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName','ProductImage')
                ->paginate($perPage, ['*'], 'page', $pageNo);

                foreach ($Products as $row) {
                    $row->ProductImage =  file_exists($row->ProductImage) ? url('/') . '/' . $row->ProductImage : null;
                }
                return response()->json([
                    'status' => true,
                    'data' => $Products->items(),
                    'CurrentPage' => $Products->currentPage(),
                    'LastPage' => $Products->lastPage(),
                ]);
        }else{
            return response()->json(['status' => false,'message' => "Shipping Address is required!"]);
        }
	}
    public function getSingleProduct(Request $req){
        $Products = DB::table('tbl_products as P')
            ->leftJoin('tbl_product_subcategory as PSC', 'P.SCID', 'PSC.PSCID')
            ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
            ->leftJoin('tbl_uom as U', 'U.UID', 'P.UID')
            ->where('P.ProductID', $req->ProductID)
            ->select('P.*', 'PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName')->first();
            $Products->ProductImage =  file_exists($Products->ProductImage) ? url('/') . '/' . $Products->ProductImage : url('/') ."assets/images/no-image-b.png";
            $Products->ProductBrochure =  file_exists($Products->ProductBrochure) ? url('/') . '/' . $Products->ProductBrochure : null;
            $Products->GalleryImages = DB::table('tbl_products_gallery')
                ->where('ProductID', $Products->ProductID)
                ->pluck(DB::raw('CONCAT("' . url('/') . '/", gImage) AS gImage'))
                ->toArray();
        return response()->json(['status' => true, 'data' => $Products ]);
	}

    public function getCustomerHomeSearch(Request $req){
        if ($req->AID) {
            if($req->SearchText){
                $AllVendors = Helper::getAvailableVendors($req->AID);

                $PCategories = DB::table('tbl_product_category as PC')
                    ->rightJoin('tbl_vendors_product_mapping as VPM', 'PC.PCID', 'VPM.PCID')
                    ->where('VPM.Status', 1)
                    ->whereIn('VPM.VendorID', $AllVendors)
                    ->where('PC.PCName', 'like', '%' . $req->SearchText . '%')
                    ->groupBy('PC.PCID', 'PC.PCName')
                    ->select('PC.PCID', 'PC.PCName')->take(3)->get();

                $PSCategories = DB::table('tbl_product_subcategory as PSC')
                    ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
                    ->rightJoin('tbl_vendors_product_mapping as VPM', 'PSC.PSCID', 'VPM.PSCID')
                    ->where('VPM.Status', 1)
                    ->whereIn('VPM.VendorID', $AllVendors)
                    ->where('PSC.PSCName', 'like', '%' . $req->SearchText . '%')
                    ->groupBy('PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName')
                    ->select('PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName')->take(3)->get();

                $Products = DB::table('tbl_products as P')
                    ->leftJoin('tbl_product_subcategory as PSC', 'P.SCID', 'PSC.PSCID')
                    ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
                    ->rightJoin('tbl_vendors_product_mapping as VPM', 'P.ProductID', 'VPM.ProductID')
                    ->where('VPM.Status', 1)
                    ->whereIn('VPM.VendorID', $AllVendors)
                    ->where('P.ProductName', 'like', '%' . $req->SearchText . '%')
                    ->groupBy('P.ProductID', 'P.ProductName', 'PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName')
                    ->select('P.ProductID', 'P.ProductName', 'PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName')->take(3)->get();

                $ProductData = ['PCategories'=>$PCategories,'PSCategories'=>$PSCategories,'Products'=>$Products];

                return response()->json(['status' => true, 'data' => $ProductData ]);
            }
        }else{
            return response()->json(['status' => false,'message' => "Shipping Address is required!"]);
        }
	}

    public function getNotifications(Request $req){

        $pageNo = $req->PageNo ?? 1;
        $perPage = 10;

        $Notifications = DB::Table($this->currfyDB.'tbl_notifications as N')->leftJoin($this->currfyDB.'tbl_vendor_orders as VO','VO.VOrderID','N.RouteID')
            ->where('N.UserID', $this->UserID)
            ->orderBy('N.CreatedOn','desc')
            ->select('N.*','VO.isCustomerRated')
            ->paginate($perPage, ['*'], 'page', $pageNo);

        return response()->json([
            'status' => true,
            'data' => $Notifications->items(),
            'CurrentPage' => $Notifications->currentPage(),
            'LastPage' => $Notifications->lastPage(),
        ]);
    }

    public function getNotificationsCount(Request $req){
        $NotificationsCount = DB::table($this->currfyDB.'tbl_notifications')->where('UserID', $this->UserID)->where('ReadStatus',0)->count();
        return response()->json([
            'status' => true,
            'data' => $NotificationsCount,
        ]);
    }

    public function NotificationRead(Request $req){
		DB::beginTransaction();
        try {
            $status = DB::Table($this->currfyDB.'tbl_notifications')
            ->where('UserID',$this->UserID)
            ->where('NID',$req->NID)->update(['ReadStatus' => 1,'ReadOn'=>date('Y-m-d H:i:s')]);
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            return response()->json(['status' => true ,'message' => "Notification Read Successfully!"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Notification Read Failed!"]);
        }
	}

    public function getUserDatawithToken(Request $req){
        $UserData = DB::table('users')->where('UserID', $this->UserID)->first();
        return response()->json(['status' => true, 'data' => $UserData]);
    }

    public function UpdateEmail(request $req){
        if(!$req->Email){
            return response()->json(['status' => false, 'message' => 'Email is required.']);
        }
        $user = Auth::user();
        if(!$req->OTP){
            if($this->isDataExists($req)){
                return response()->json(['status' => false,'message' => "This Email is already taken"]);
            }else{
                $OTP = Helper::getOTP(6);

                $result = Helper::saveEmailOtp($user->EMail,$OTP,"Customer",$user->Name);

                if ($result) {
                    return response()->json(['status' => true, 'message' => 'OTP sent to registered Email successfully']);
                } else {
                    return response()->json(['status' => false, 'message' => 'Failed to send email']);
                }
            }
        }else{
            $OTP = DB::table(Helper::getCurrFYDB().'tbl_email_otps')->where('Email',$user->EMail)->where('isOtpExpired',0)->whereRaw('TIMESTAMPDIFF(MINUTE, CreatedOn, NOW()) <= 2')->value('OTP');
            if(!$OTP){
                return response()->json(['status' => false,'message' => "OTP has Expired!"]);
            }else{
                if($OTP == $req->OTP){
                    if($this->isDataExists($req)){
                        return response()->json(['status' => false,'message' => "This Email is already taken"]);
                    }else{
                        $pwd1=Hash::make($req->Email);
                        $pwd2=Helper::EncryptDecrypt("encrypt",$req->Email);

                        $status = DB::Table('users')->where('UserID',$user->UserID)->update(['UserName'=>$req->Email,'EMail'=>$req->Email,"Password"=>$pwd1,"Password1"=>$pwd2,'UpdatedOn'=>now(),'UpdatedBy'=>$user->UserID]);
                        $status = DB::Table('tbl_customer')->where('CustomerID',$user->ReferID)->update(['Email'=>$req->Email,'UpdatedOn'=>now(),'UpdatedBy'=>$user->ReferID]);
                        if($status){
                            return response()->json(['status' => true,'message' => "Email Updated Successfully"]);
                        }else{
                            return response()->json(['status' => false,'message' => "Email Update Failed!"]);
                        }
                    }
                }else{
                    return response()->json(['status' => false,'message' => "OTP verification failed. Please enter the correct OTP."]);
                }
            }
        }
	}

    public function UpdateMobileNo(request $req){
        if(!$req->MobileNumber){
            return response()->json(['status' => false, 'message' => 'Mobile Number is required.']);
        }
        $user = Auth::user();
        if(!$req->OTP){
            if($this->isDataExists($req)){
                return response()->json(['status' => false,'message' => "This Mobile Number is already taken"]);
            }else{
                $OTP = Helper::getOTP(6);
                $Message = "You are trying to change your mobile number in the RPC software. Please enter $OTP code to verify your request.";
                return Helper::saveSmsOtp($user->MobileNumber,$OTP,$Message,"Customer");
            }
        }else{
            $OTP = DB::table(Helper::getCurrFYDB().'tbl_sms_otps')->where('MobileNumber',$user->MobileNumber)->where('isOtpExpired',0)->value('OTP');
            if(!$OTP){
                return response()->json(['status' => false,'message' => "OTP has Expired!"]);
            }else{
                if($OTP == $req->OTP){
                    if($this->isDataExists($req)){
                        return response()->json(['status' => false,'message' => "This Mobile Number is already taken"]);
                    }else{

                        $status = DB::Table('users')->where('UserID',$user->UserID)->update(['MobileNumber'=>$req->MobileNumber,'UpdatedOn'=>now(),'UpdatedBy'=>$user->UserID]);
                        $status = DB::Table('tbl_customer')->where('CustomerID',$user->ReferID)->update(['MobileNo1'=>$req->MobileNumber,'UpdatedOn'=>now(),'UpdatedBy'=>$user->ReferID]);
                        if($status){
                            return response()->json(['status' => true,'message' => "Mobile Number Updated Successfully"]);
                        }else{
                            return response()->json(['status' => false,'message' => "Mobile Number Update Failed!"]);
                        }
                    }
                }else{
                    return response()->json(['status' => false,'message' => "OTP verification failed. Please enter the correct OTP."]);
                }
            }
        }
	}

    private function isDataExists($req) {
        $query = DB::table('users');
        if($req->Email){
            $query->where('EMail', $req->Email);
        }elseif($req->MobileNumber){
            $query->where('MobileNumber', $req->MobileNumber);
        }else{
            return false;
        }
        return $query->where('LoginType','Customer')->whereNot('UserID',Auth::user()->UserID)->exists();
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

    public function getChatHistory(Request $req)
    {
        $chatExist = DB::table($this->SupportDB.'tbl_chat')->where('sendFrom', $this->UserID)->exists();
        if(!$chatExist) {
            $chatStatus = DB::table($this->SupportDB . 'tbl_chat')->insert([
                "ChatID" => DocNum::getDocNum(docTypes::Chat->value),
                "sendFrom" => $this->UserID,
                "sendTo" => "Admin",
                "Status" => "Active",
                "isRead" => 0,
                "LastMessageOn" => now(),
                "CreatedOn" => now(),
            ]);
            if($chatStatus) {
                DocNum::updateDocNum(docTypes::Chat->value);
            }
        }
        $ChatID = DB::Table($this->SupportDB . "tbl_chat")->where('sendFrom', $this->UserID)->first()?->ChatID;
        logger("ChatID");
        logger($ChatID);
        logger(json_encode($req->all()));
        $pageLimit = (int)$req->pageLimit; // Number of records per page
        $pageNo = (int)$req->pageNo; // Current page number (you can update this as needed)
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
            event(new chatApp($this->UserID,json_encode(["type"=>"update_last_seen","message"=>now(),"ChatID"=>$ChatID])));
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

    public function sendMessage(Request $req){
        DB::beginTransaction();$SLNO="";
        $status=false;
        $LastMessageOn=now();

        $LastMessage="";

        try {
            $chatExist = DB::table($this->SupportDB.'tbl_chat')->where('sendFrom', $this->UserID)->exists();
            if(!$chatExist) {
                $chatStatus = DB::table($this->SupportDB . 'tbl_chat')->insert([
                    "ChatID" => DocNum::getDocNum(docTypes::Chat->value),
                    "sendFrom" => $this->UserID,
                    "sendTo" => "Admin",
                    "Status" => "Active",
                    "isRead" => 0,
                    "LastMessageOn" => now(),
                    "CreatedOn" => now(),
                ]);
                if($chatStatus) {
                    DocNum::updateDocNum(docTypes::Chat->value);
                }
            }
            $ChatID = DB::Table($this->SupportDB . "tbl_chat")->where('sendFrom', $this->UserID)->first()?->ChatID;
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
        }catch(Exception $e) {
            logger("Error in CustomeAuthController@sendMessage: ".$e->getMessage());
            $status=false;
        }
        if($status==true){
            DB::commit();
            $msg=$this->getChatMessage($ChatID,$SLNO);
            event(new chatApp($req->messageTo,json_encode(["type"=>"load_message","isRead"=>$req->messageFrom=="Admin"?0:1,"isAdminRead"=>$req->messageFrom=="Admin"?1:0,"messageFrom"=>$req->messageFrom,"message"=>$msg,"ChatID"=>$ChatID,"LastMessageOn"=>$LastMessageOn,"LastMessage"=>$LastMessage,"LastMessageOnHuman"=>Carbon::parse($LastMessageOn)->diffForHumans()])));
            event(new chatApp($req->messageFrom,json_encode(["type"=>"load_message","isRead"=>$req->messageFrom=="Admin"?0:1,"isAdminRead"=>$req->messageFrom=="Admin"?1:0,"messageFrom"=>$req->messageFrom,"message"=>$msg,"ChatID"=>$ChatID,"LastMessageOn"=>$LastMessageOn,"LastMessage"=>$LastMessage,"LastMessageOnHuman"=>Carbon::parse($LastMessageOn)->diffForHumans()])));
            Helper::sendNotification($req->messageFrom,$req->messageTo,"New message received",$req->message);
        }else{
            DB::rollback();
        }
        return ['status'=>$status,"SLNO"=>$SLNO,"LastMessage"=>$LastMessage,"LastMessageOn"=>$LastMessageOn,"LastMessageOnHuman"=>Carbon::parse($LastMessageOn)->diffForHumans()];
    }

    public function sendAttachment(Request $req){
        DB::beginTransaction();$SLNO="";
        $status=false;
        $LastMessageOn=now();

        $LastMessage=$req->message==""?"sent a attachment file":$req->message;
        try {
            $chatExist = DB::table($this->SupportDB.'tbl_chat')->where('sendFrom', $this->UserID)->exists();
            if(!$chatExist) {
                $chatStatus = DB::table($this->SupportDB . 'tbl_chat')->insert([
                    "ChatID" => DocNum::getDocNum(docTypes::Chat->value),
                    "sendFrom" => $this->UserID,
                    "sendTo" => "Admin",
                    "Status" => "Active",
                    "isRead" => 0,
                    "LastMessageOn" => now(),
                    "CreatedOn" => now(),
                ]);
                if($chatStatus) {
                    DocNum::updateDocNum(docTypes::Chat->value);
                }
            }
            $ChatID = DB::Table($this->SupportDB . "tbl_chat")->where('sendFrom', $this->UserID)->first()?->ChatID;

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
            $req->MessageID=$SLNO;
            $msg=$this->getChatHistory($req,$ChatID);
            event(new chatApp($req->messageTo,json_encode(["type"=>"load_message","message"=>$msg])));
        }catch(Exception $e) {
            logger("Error in CustomerAuthController@sendAttachment: ".$e->getMessage());
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
    public function chatSuggestions(Request $request)
    {
        return DB::Table('tbl_chat_suggestions')->where('ActiveStatus', 'Active')->where('DFlag', 0)->get();
    }
}
