<?php

namespace App\Http\Controllers\api\customer;

use App\helper\helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use Auth;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use activeMenuNames;
use ValidUnique;
use ValidDB;
use DocNum;
use docTypes;
use logs;
use PHPUnit\TextUI\Help;

use function Laravel\Prompts\select;

class CustomerAuthController extends Controller{
    private $generalDB;
    private $tmpDB;
    private $currfyDB;
    private $ActiveMenuName;
    private $FileTypes;
	private $UserID;
	private $ReferID;

    public function __construct(){
		$this->generalDB=Helper::getGeneralDB();
		$this->tmpDB=Helper::getTmpDB();
        $this->currfyDB=Helper::getCurrFYDB();
        $this->ActiveMenuName=activeMenuNames::ManageCustomers->value;
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
            'MobileNo1' =>['required','max:10',new ValidUnique(array("TABLE"=>"tbl_customer","WHERE"=>" MobileNo1='".$req->MobileNo1."'  "),"This Mobile Number is already taken.")],
            'Email' =>['required','max:50',new ValidUnique(array("TABLE"=>"tbl_customer","WHERE"=>" Email='".$req->Email."'  "),"This Email is already taken.")],
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

                $Udata=array(
                    "ReferID"=>$CustomerID,
                    "Name" => $customerName,
                    "GenderID"=>$req->GenderID,
                    "ProfileImage"=>$CustomerImage,
                    "FirstName" => $firstName,
                    "LastName" => $lastName,
                    "MobileNumber"=>$req->MobileNo1,
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
        ->select('CustomerID','CustomerName','DOB','MobileNo1','Email','CustomerImage','CusTypeID','ConTypeIDs','GenderID','Address','CityID','TalukID','CU.DistrictID','CU.StateID','CU.CountryID','PostalCodeID','P.PostalCode','CU.DFlag','CU.ActiveStatus')
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

    public function GetCategory(Request $req)
    {
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
            $Products = $products->groupBy('PSC.PSCID', 'PSCName', 'PC.PCID', 'PCName', 'P.ProductID', 'ProductName', 'ProductImage','UName','UCode','U.UID')
                ->select('PSC.PSCID', 'PSCName','PC.PCID', 'PCName', 'P.ProductID', 'ProductName','UName','UCode','U.UID', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'))
                ->paginate($perPage, ['*'], 'page', $pageNo);

            foreach ($Products as $row) {
                $row->GalleryImages = DB::table('tbl_products_gallery')
                    ->where('ProductID', $row->ProductID)
                    ->pluck(DB::raw('CONCAT("' . url('/') . '/", gImage) AS gImage'))
                    ->toArray();
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

    public function getCart(Request $req){
        $Cart = DB::table('tbl_customer_cart as C')
        ->leftJoin('tbl_products as P','P.ProductID','C.ProductID')
        ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'P.CID')
        ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
        ->leftJoin('tbl_uom as U', 'U.UID', 'P.UID')
        ->where('C.CustomerID', $this->ReferID)
        ->where('P.ActiveStatus', 'Active')->where('P.DFlag', 0)
        ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
        ->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
        ->select('P.ProductName','C.ProductID','C.Qty', 'PC.PCName', 'PC.PCID', 'PSC.PSCName','U.UName','U.UCode','U.UID', 'PSC.PSCID')->get();

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
                ->groupBy('PSC.PSCID', 'PSCName', 'PC.PCID', 'PCName', 'P.ProductID', 'ProductName', 'ProductImage','UName','UCode','U.UID')
                ->select('PSC.PSCID', 'PSCName','PC.PCID', 'PCName', 'P.ProductID', 'ProductName','UName','UCode','U.UID', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'))
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
    public function getCustomerHomeSearchd(Request $req){
        $PostalID = $req->PostalID ?? DB::table('tbl_customer')->where('CustomerID',$this->ReferID)->value('PostalCodeID');

        if($PostalID && $req->SearchText){
            $AllVendors = DB::table('tbl_vendors as V')->leftJoin('tbl_vendors_service_locations as VSL','V.VendorID','VSL.VendorID')->where('V.ActiveStatus',"Active")->where('V.DFlag',0)->where('VSL.PostalCodeID',$PostalID)->groupBy('VSL.VendorID')->pluck('VSL.VendorID')->toArray();

            $query1 = DB::table('tbl_product_category as PC')
                ->rightJoin('tbl_product_subcategory as PSC', 'PSC.PCID', 'PC.PCID')
                ->rightJoin('tbl_products as P', 'PSC.PSCID', 'P.SCID')
                ->leftJoin('tbl_vendors_product_mapping as VPM', 'P.ProductID', 'VPM.ProductID')
                ->where('VPM.Status', 1)
                ->whereIn('VPM.VendorID', $AllVendors)
                ->where('PC.PCName', 'like', '%' . $req->SearchText . '%')
                ->groupBy('P.ProductID', 'P.ProductName', 'PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName')
                ->select('P.ProductID', 'P.ProductName', 'PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName');

            $query2 = DB::table('tbl_product_subcategory as PSC')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
                ->rightJoin('tbl_products as P', 'P.SCID', 'PSC.PSCID')
                ->leftJoin('tbl_vendors_product_mapping as VPM', 'P.ProductID', 'VPM.ProductID')
                ->where('VPM.Status', 1)
                ->whereIn('VPM.VendorID', $AllVendors)
                ->where('PSC.PSCName', 'like', '%' . $req->SearchText . '%')
                ->groupBy('P.ProductID', 'P.ProductName', 'PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName')
                ->select('P.ProductID', 'P.ProductName', 'PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName');

            $query3 = DB::table('tbl_products as P')
                ->leftJoin('tbl_product_subcategory as PSC', 'P.SCID', 'PSC.PSCID')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
                ->leftJoin('tbl_vendors_product_mapping as VPM', 'P.ProductID', 'VPM.ProductID')
                ->where('VPM.Status', 1)
                ->whereIn('VPM.VendorID', $AllVendors)
                ->where('P.ProductName', 'like', '%' . $req->SearchText . '%')
                ->groupBy('P.ProductID', 'P.ProductName', 'PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName')
                ->select('P.ProductID', 'P.ProductName', 'PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName');

            $ProductData = $query1->union($query2)->union($query3)->get();


            return response()->json(['status' => true, 'data' => $ProductData ]);
        }else{
            return response()->json(['status' => false, 'data' => [] ]);
        }
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

        $Notifications = DB::table($this->currfyDB.'tbl_notifications')
            // ->where('UserID', $this->UserID)
            ->orderBy('CreatedOn','desc')
            ->paginate($perPage, ['*'], 'page', $pageNo);

        return response()->json([
            'status' => true,
            'data' => $Notifications->items(),
            'CurrentPage' => $Notifications->currentPage(),
            'LastPage' => $Notifications->lastPage(),
        ]);
    }

    public function NotificationRead(Request $req){
		DB::beginTransaction();
        try {
            $status = DB::Table($this->currfyDB.'tbl_notifications')
            // ->where('UserID',$this->UserID)
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
}
