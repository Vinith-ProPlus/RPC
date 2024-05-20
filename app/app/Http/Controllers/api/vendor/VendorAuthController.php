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

class VendorAuthController extends Controller{
    private $generalDB;
    private $tmpDB;
    private $ActiveMenuName;
    private $FileTypes;
	private $UserID;
    private $currfyDB;
	private $ReferID;

    public function __construct(){
		$this->generalDB=Helper::getGeneralDB();
		$this->tmpDB=Helper::getTmpDB();
        $this->currfyDB=Helper::getCurrFYDB();
        $this->ActiveMenuName=activeMenuNames::Vendors->value;
		$this->FileTypes=Helper::getFileTypes(array("category"=>array("Images","Documents")));
        $this->middleware('auth:api');
        $this->middleware(function ($request, $next) {
			$this->UserID=auth()->user()->UserID;
			$this->ReferID=auth()->user()->ReferID;
			return $next($request);
		});
    }
    
    public function VendorDocuments(request $req){
        $RequiredDocuments = DB::table('tbl_vendor_required_documents')->get();
        foreach($RequiredDocuments as $item){
            $item->isRequired = $item->isRequired ? true : false;
        }
		$return = [
			'MaxSize' => "2MB",
			'extensions' => ['doc','docx','pdf','png','jpg','jpeg'],
			'Documents' => $RequiredDocuments,
		];
        return response()->json($return);
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

        if (isset($reqData['PCategories'])) {
            $reqData['PCategories'] = json_decode($reqData['PCategories'], true);
        }
        if (isset($reqData['Documents'])) {
            $reqData['Documents'] = json_decode($reqData['Documents'], true);
        }

        $rules = [
            'VendorName' => ['required', 'max:50'],
            'VendorCoName' => ['required','max:50', new ValidUnique(array("TABLE" => "tbl_vendors", "WHERE" => " VendorCoName='" . $reqData['VendorCoName'] . "' "), "This Vendor Company Name is already taken.")],
            'VendorCoWebsite' => ['max:50', new ValidUnique(array("TABLE" => "tbl_vendors", "WHERE" => " VendorCoWebsite='" . $reqData['VendorCoWebsite'] . "' "), "This Vendor Company Website is already taken.")],
            'Email' => ['required', 'email:filter', new ValidUnique(array("TABLE" => "users", "WHERE" => " EMail='" . $reqData['Email'] . "' and LoginType = 'Vendor' and UserID <> '".$this->UserID."' "), "This Email is already taken.")],
            'MobileNumber1' => ['required', 'regex:/^[0-9]{10}$/', new ValidUnique(array("TABLE" => "users", "WHERE" => " MobileNumber='" . $reqData['MobileNumber1'] . "' and LoginType = 'Vendor' and UserID <> '".$this->UserID."' "), "This Mobile Number is already taken.")],
            // 'GSTNo' => ['required', 'regex:/^\d{2}[A-Z]{5}\d{4}[A-Z]{1}\d[Z]{1}[0-9A-Z]{1}$/'],
            'MobileNumber2' => ['nullable', 'regex:/^[0-9]{10}$/'],
            'CountryID' => ['required', new ValidDB($ValidDB['Country'])],
            'StateID' => ['required', new ValidDB($ValidDB['State'])],
            'DistrictID' => ['required', new ValidDB($ValidDB['District'])],
            'TalukID' => ['required', new ValidDB($ValidDB['Taluk'])],
            'PostalCodeID' => ['required', new ValidDB($ValidDB['PostalCode'])],
            'CityID' => ['required', new ValidDB($ValidDB['City'])],
            'PCategories' => 'array|min:1',
        ];

        $messages = [
            'Logo.mimes' => "The Logo field must be a file of type: " . implode(", ", $this->FileTypes['category']['Images']) . ".",
            'VendorCoName.required' => 'Vendor Company Name is required',
            'MobileNumber1.regex' => 'Mobile Number 1 should be 10 digits',
            'MobileNumber2.regex' => 'Mobile Number 2 should be 10 digits',
            // 'GSTNo.regex' => 'Invalid GST Number Format',
            // 'GSTNo.required' => 'GST Number is Required',
            'PCategories.array' => 'Invalid format for categories.',
            'PCategories.min' => 'Select at least one category.',
        ];

        if ($req->hasFile('Logo')) {
            $rules['Logo'] = 'mimes:' . implode(",", $this->FileTypes['category']['Images']);
        }
        $validator = Validator::make($reqData, $rules, $messages);

        $errors = $validator->errors()->toArray();

        $DocErrors = [];
        foreach ($reqData['Documents'] as $key => $data) {
            if (empty($data)) {
                $DocErrors[$key] = "{$key} is mandatory.";
            }
        }

        if (!empty($DocErrors) || !empty($errors)) {
            $resultErrors = !empty($DocErrors) ? ['Documents' => $DocErrors] + $errors : $errors;
            return array('status' => false, 'message' => "Vendor Register Failed", 'errors' => $resultErrors);
        }
        DB::beginTransaction();
        try{
            $Logo="";
            $VendorID=DocNum::getDocNum(docTypes::Vendor->value,"",Helper::getCurrentFY());
            $dir="uploads/master/vendor/manage-vendors/".$VendorID."/";
            $dDir="uploads/master/vendor/manage-vendors/".$VendorID."/documents/";
            if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
            if (!file_exists( $dDir)) {mkdir( $dDir, 0777, true);}
            if($req->hasFile('Logo')){
                $file = $req->file('Logo');
                $fileName=md5($file->getClientOriginalName() . time());
                $fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
                $file->move($dir, $fileName1);
                $Logo=$dir.$fileName1;
            }else if(Helper::isJSON($req->Logo)==true){
                $Img=json_decode($req->Logo);
                if(file_exists($Img->uploadPath)){
                    $fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
                    copy($Img->uploadPath,$dir.$fileName1);
                    $Logo=$dir.$fileName1;
                    // unlink($Img->uploadPath);
                }
            }
            $data = [
                "VendorID" => $VendorID,
                "VendorName" => $reqData['VendorName'],
                "VendorCoName" => $reqData['VendorCoName'],
                "VendorCoWebsite" => $reqData['VendorCoWebsite'],
                "GSTNo" => $reqData['GSTNo'],
                "Email" => $reqData['Email'],
                "PCategories" => serialize($reqData['PCategories']),
                "MobileNumber1" => $reqData['MobileNumber1'],
                "MobileNumber2" => $reqData['MobileNumber2'],
                "Address" => $reqData['Address'],
                "CountryID" => $reqData['CountryID'],
                "StateID" => $reqData['StateID'],
                "DistrictID" => $reqData['DistrictID'],
                "TalukID" => $reqData['TalukID'],
                "CityID" => $reqData['CityID'],
                "PostalCode" => $reqData['PostalCodeID'],
                "Reference" => $reqData['Reference'],
                'Logo' => $Logo,
                "CreatedOn" => date("Y-m-d H:i:s"),
            ];
            $status=DB::Table('tbl_vendors')->insert($data);
            if($status){
                foreach ($reqData['Documents'] as $docName => $docDetails) {
                    if (file_exists($docDetails['uploadPath'])) {

                        $ext = pathinfo($docDetails['uploadPath'], PATHINFO_EXTENSION);
                        $fileName = $docDetails['fileName'] !== "" ? $docDetails['fileName'] : Helper::RandomString(10) . '.' . $ext;
                        $uploadedDocument = $dDir . $fileName;
                
                        copy($docDetails['uploadPath'], $uploadedDocument);
                
                        $data = [
                            "SLNO" => DocNum::getDocNum(docTypes::VendorDocuments->value,"",Helper::getCurrentFY()),
                            'VendorID' => $VendorID,
                            'DocName' => $docName,
                            'documents' => $uploadedDocument,
                            'CreatedOn' => date('Y-m-d H:i:s'),
                        ];
                
                        $status = DB::table('tbl_vendors_document')->insert($data);
                        if ($status) {
                            DocNum::updateDocNum(docTypes::VendorDocuments->value);
                        }
                    }
                }
            }
            if($status){
                $vendorName = $reqData['VendorName'];
                $nameParts = explode(' ', $vendorName, 2);
                $firstName = $nameParts[0] ?? '';
                $lastName = $nameParts[1] ?? '';
                $pwd1=Hash::make($req->Email);

                $Udata=array(
                    "ReferID"=>$VendorID,
                    "Name" => $vendorName,
                    "FirstName" => $firstName,
                    "LastName" => $lastName,
                    "MobileNumber"=>$reqData['MobileNumber1'],
                    "EMail"=>$reqData['Email'],
                    "UserName"=>$reqData['Email'],
                    "password"=>$pwd1,
					"Address" => $reqData['Address'],
                    "CountryID" => $reqData['CountryID'],
                    "StateID" => $reqData['StateID'],
                    "DistrictID" => $reqData['DistrictID'],
                    "TalukID" => $reqData['TalukID'],
                    "CityID" => $reqData['CityID'],
                    "PostalCodeID" => $reqData['PostalCodeID'],
					"UpdatedBy"=>$VendorID,
                );
				$status=DB::Table('users')->where('UserID',$this->UserID)->update($Udata);
            }
        }catch(Exception $e){
            $status=false;
        }
        if($status==true){
            DB::commit();
            DocNum::updateDocNum(docTypes::Vendor->value);
            $NewData=DB::table('tbl_vendors')->where('VendorID',$VendorID)->get();
            $logData=array("Description"=>"New Vendor Created","ModuleName"=>$this->ActiveMenuName,"Action"=>'Add',"ReferID"=>$VendorID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$VendorID,"IP"=>$req->ip());
            logs::Store($logData);
            return array('status'=>true,'message'=>"Vendor Registered Successfully");
        }else{
            DB::rollback();
            return array('status'=>false,'message'=>"Vendor Create Failed");
        }
    }

    public function RegisterUpdate(Request $req){ 
        $VendorID = $this->ReferID;
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

        if (isset($reqData['PCategories'])) {
            $reqData['PCategories'] = json_decode($reqData['PCategories'], true);
        }
        if (isset($reqData['Documents'])) {
            $reqData['Documents'] = json_decode($reqData['Documents'], true);
        }
        if (isset($reqData['SupplyDetails'])) {
            $reqData['SupplyDetails'] = json_decode($reqData['SupplyDetails']);
        }
        // return $reqData;

        $rules = [
            'VendorName' => ['required', 'max:50'],
            'VendorCoName' => ['required','max:50', new ValidUnique(array("TABLE" => "tbl_vendors", "WHERE" => " VendorCoName='" . $reqData['VendorCoName'] . "' and VendorID <>'".$VendorID."' "), "This Vendor Company Name is already taken.")],
            'VendorCoWebsite' => ['max:50', new ValidUnique(array("TABLE" => "tbl_vendors", "WHERE" => " VendorCoWebsite='" . $reqData['VendorCoWebsite'] . "' and VendorID <>'".$VendorID."' "), "This Vendor Company Website is already taken.")],
            // 'GSTNo' => ['required', 'regex:/^\d{2}[A-Z]{5}\d{4}[A-Z]{1}\d[Z]{1}[0-9A-Z]{1}$/'],
            'MobileNumber1' => ['required', 'regex:/^[0-9]{10}$/'],
            'MobileNumber2' => ['nullable', 'regex:/^[0-9]{10}$/'],
            'CountryID' => ['required', new ValidDB($ValidDB['Country'])],
            'StateID' => ['required', new ValidDB($ValidDB['State'])],
            'DistrictID' => ['required', new ValidDB($ValidDB['District'])],
            'TalukID' => ['required', new ValidDB($ValidDB['Taluk'])],
            'PostalCodeID' => ['required', new ValidDB($ValidDB['PostalCode'])],
            'CityID' => ['required', new ValidDB($ValidDB['City'])],
            'PCategories' => 'array|min:1',
        ];

        $messages = [
            'Logo.mimes' => "The Logo field must be a file of type: " . implode(", ", $this->FileTypes['category']['Images']) . ".",
            'VendorCoName.required' => 'Vendor Company Name is required',
            'MobileNumber1.regex' => 'Mobile Number 1 should be 10 digits',
            'MobileNumber2.regex' => 'Mobile Number 2 should be 10 digits',
            // 'GSTNo.regex' => 'Invalid GST Number Format',
            // 'GSTNo.required' => 'GST Number is Required',
            'PCategories.array' => 'Invalid format for categories.',
            'PCategories.min' => 'Select at least one category.',
        ];
        $validator = Validator::make($reqData, $rules, $messages);

        $errors = $validator->errors()->toArray();

        $DocErrors = [];
        if(!empty($reqData['Documents'])){
            foreach ($reqData['Documents'] as $key => $data) {
                if (empty($data)) {
                    $DocErrors[$key] = "{$key} is mandatory.";
                }
            }
        }
        if (!empty($DocErrors) || !empty($errors)) {
            $resultErrors = !empty($DocErrors) ? ['Documents' => $DocErrors] + $errors : $errors;
            return array('status' => false, 'message' => "Vendor Register Failed", 'errors' => $resultErrors);
        }

        DB::beginTransaction();
        try{

            $Logo="";
            $dir="uploads/master/vendor/manage-vendors/".$VendorID."/";
            $dDir="uploads/master/vendor/manage-vendors/".$VendorID."/documents/";
            if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
            if (!file_exists( $dDir)) {mkdir( $dDir, 0777, true);}
            if($req->Logo && Helper::isJSON($req->Logo)==true){
                $Img=json_decode($req->Logo);
                if(file_exists($Img->uploadPath)){
                    $fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
                    copy($Img->uploadPath,$dir.$fileName1);
                    $Logo=$dir.$fileName1;
                    // unlink($Img->uploadPath);
                }
            }
            $data = [
                "VendorName" => $reqData['VendorName'],
                "VendorCoName" => $reqData['VendorCoName'],
                "VendorCoWebsite" => $reqData['VendorCoWebsite'],
                "GSTNo" => $reqData['GSTNo'],
                "PCategories" => serialize($reqData['PCategories']),
                "MobileNumber1" => $reqData['MobileNumber1'],
                "MobileNumber2" => $reqData['MobileNumber2'],
                "Address" => $reqData['Address'],
                "CountryID" => $reqData['CountryID'],
                "StateID" => $reqData['StateID'],
                "DistrictID" => $reqData['DistrictID'],
                "TalukID" => $reqData['TalukID'],
                "CityID" => $reqData['CityID'],
                "PostalCode" => $reqData['PostalCodeID'],
                "Reference" => $reqData['Reference'],
                "UpdatedBy"=>$VendorID,
                "UpdatedOn" => date("Y-m-d H:i:s")
            ];
            if($Logo){
                $data['Logo'] = $Logo;
            }
            $status=DB::Table('tbl_vendors')->where('VendorID',$VendorID)->update($data);
            if($status && !empty($reqData['Documents'])){
                foreach ($reqData['Documents'] as $docName => $docDetails) {
                    if ($docName && file_exists($docDetails['uploadPath'])) { 
                        $ext = pathinfo($docDetails['uploadPath'], PATHINFO_EXTENSION);
                        $fileName = $docDetails['fileName'] !== "" ? $docDetails['fileName'] : Helper::RandomString(10) . '.' . $ext;
                        $uploadedDocument = $dDir . $fileName;
                        copy($docDetails['uploadPath'], $uploadedDocument);
                        $isDocNameExists = DB::table('tbl_vendors_document')->where('VendorID',$VendorID)->where('DocName',$docName)->first();
                        if($isDocNameExists){
                            $status = DB::table('tbl_vendors_document')->where('VendorID',$VendorID)->where('DocName',$docName)->update(['documents'=>$uploadedDocument,'UpdatedBy'=>$VendorID,"UpdatedOn" => date("Y-m-d H:i:s")]);
                        }else{
                            $data = [
                                "SLNO" => DocNum::getDocNum(docTypes::VendorDocuments->value,"",Helper::getCurrentFY()),
                                'VendorID' => $VendorID,
                                'DocName' => $docName,
                                'documents' => $uploadedDocument,
                                'CreatedOn' => date('Y-m-d H:i:s'),
                            ];
                            $status = DB::table('tbl_vendors_document')->insert($data);
                            if ($status) {
                                DocNum::updateDocNum(docTypes::VendorDocuments->value);
                            }
                        }
                    }
                }
            }
            if($status && !empty($reqData['SupplyDetails'])){
                $PSCIDs=[];
                foreach($reqData['SupplyDetails'] as $data){
                    $PSCIDs[]=$data->PSCID;
                    $t=DB::Table('tbl_vendors_supply')->where('VendorID',$VendorID)->Where('PCID',$data->PCID)->Where('PSCID',$data->PSCID)->first();
                    if(!$t){
                        $DetailID = DocNum::getDocNum(docTypes::VendorSupply->value,"",Helper::getCurrentFY());
                        $tdata=array(
                            "DetailID"=>$DetailID,
                            "VendorID"=>$VendorID,
                            "PCID"=>$data->PCID,
                            "PSCID"=>$data->PSCID,
                            "CreatedOn"=>date("Y-m-d H:i:s")
                        );
                        $status=DB::Table('tbl_vendors_supply')->insert($tdata);
                        if($status){
                            DocNum::updateDocNum(docTypes::VendorSupply->value);
                        }
                    }
                }
                if (!empty($PSCIDs)) {
                    DB::Table('tbl_vendors_supply')->where('VendorID',$VendorID)->WhereIn('PSCID',$PSCIDs)->update(['DFlag'=>0,'UpdatedOn'=>date('Y-m-d H:i:s')]);
                    DB::Table('tbl_vendors_supply')->where('VendorID',$VendorID)->WhereNotIn('PSCID',$PSCIDs)->update(['DFlag'=>1,'UpdatedOn'=>date('Y-m-d H:i:s')]);
                    DB::Table('tbl_vendors_product_mapping')->where('VendorID',$VendorID)->WhereNotIn('PSCID',$PSCIDs)->update(['Status'=>0,'UpdatedOn'=>date('Y-m-d H:i:s')]);
                    $status=true;
                }
            }
            if($status){
                $vendorName = $reqData['VendorName'];
                $nameParts = explode(' ', $vendorName, 2);
                $firstName = $nameParts[0] ?? '';
                $lastName = $nameParts[1] ?? '';

                $Udata=array(
                    "Name" => $vendorName,
                    "FirstName" => $firstName,
                    "LastName" => $lastName,
                    "MobileNumber"=>$reqData['MobileNumber1'],
					"Address" => $reqData['Address'],
                    "CountryID" => $reqData['CountryID'],
                    "StateID" => $reqData['StateID'],
                    "DistrictID" => $reqData['DistrictID'],
                    "TalukID" => $reqData['TalukID'],
                    "CityID" => $reqData['CityID'],
                    "PostalCodeID" => $reqData['PostalCodeID'],
					"UpdatedBy"=>$VendorID,
					"UpdatedOn"=>date("Y-m-d H:i:s")
                );
				$status=DB::Table('users')->where('UserID',$this->UserID)->update($Udata);
            }
        }catch(Exception $e){
            $status=false;
        }
        if($status==true){
            DB::commit();
            DocNum::updateDocNum(docTypes::Vendor->value);
            $NewData=DB::table('tbl_vendors')->where('VendorID',$VendorID)->get();
            $logData=array("Description"=>"Vendor Updated","ModuleName"=>$this->ActiveMenuName,"Action"=>'Update',"ReferID"=>$VendorID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$VendorID,"IP"=>$req->ip());
            logs::Store($logData);
            return array('status'=>true,'message'=>"Vendor Updated Successfully");
        }else{
            DB::rollback();
            return array('status'=>false,'message'=>"Vendor Create Failed");
        }
    }

    public function RegisteredDetails(request $req){
        $Data = DB::Table('tbl_vendors')->where('ActiveStatus','Active')->where('VendorID',$this->ReferID)->where('DFlag',0)
        ->select('VendorID','VendorName','VendorCoName','VendorCoWebsite','GSTNo','Reference','PCategories','Email','MobileNumber1','MobileNumber2','Address','PostalCode','CityID','TalukID','DistrictID','StateID','CountryID','ActiveStatus',DB::raw('IF(Logo IS NOT NULL AND Logo != "", CONCAT("' . url('/') . '/", Logo), "") AS Logo'))
        ->first();
        if($Data){
            $Data->Documents = DB::table('tbl_vendors_document as VD')->leftJoin('tbl_vendor_required_documents as VRD','VRD.DocName','VD.DocName')->where('VD.VendorID', $this->ReferID)->select('VD.DocName','VRD.DisplayName', DB::raw('CONCAT("' . url('/') . '/", documents) AS Documents'))->get();
            $Data->PostalCodeID =$Data->PostalCode;
            $Data->PostalCode =DB::table($this->generalDB.'tbl_postalcodes')->where('PID',$Data->PostalCodeID)->value('PostalCode');
            $Data->PCategories =$Data->PCategories ? unserialize($Data->PCategories) : "";
            $Data->SupplyDetails =DB::table('tbl_vendors_supply')->where('VendorID',$this->ReferID)->select('PCID','PSCID')->get();
        }
        return response()->json([ 'status' => true, 'data' => $Data ]);
	}

    public function Update(Request $req){
        $VendorID = $this->ReferID;
        if (json_decode($req->isGeneral) && $req->General) {
            $GeneralData = json_decode($req->General, true);
            $rules = [
                // 'VendorName' => ['required', 'max:50'],
                // 'VendorCoName' => ['required', 'max:50', new ValidUnique(array("TABLE" => "tbl_vendors", "WHERE" => " VendorCoName='" . $GeneralData['VendorCoName'] . "' and VendorID<>'" . $VendorID . "' "), "This Vendor Company Name is already taken.")],
                'MobileNumber1' => ['required', 'regex:/^[0-9]{10}$/'],
                'MobileNumber2' => ['nullable', 'regex:/^[0-9]{10}$/'],
            ];
        
            $messages = [
                // 'VendorCoName.required' => 'Vendor Company Name is required',
                'MobileNumber1.regex' => 'Mobile Number 1 should be 10 digits',
                'MobileNumber2.regex' => 'Mobile Number 2 should be 10 digits',
            ];
            $validator = Validator::make($GeneralData, $rules, $messages);
        
            if ($validator->fails()) {
                return array('status' => false, 'message' => "Vendor Register Failed", 'errors' => $validator->errors());
            } else {
                DB::table($this->tmpDB . 'tbl_vendors')->where('VendorID', $VendorID)->delete();
                $data = [
                    'VendorID'=>$VendorID,
                    'MobileNumber1'=>$GeneralData['MobileNumber1'],
                    'MobileNumber2'=>$GeneralData['MobileNumber2'],
                    'VendorType'=>$GeneralData['VendorType'],
                ];
                $status = DB::table($this->tmpDB . 'tbl_vendors')->insert($data);
                if ($status) {
                    // return response()->json(['status' => true, 'message' => 'General Data Updated']);
                }
            }
        }
        if (json_decode($req->isSupplyDetails) && $req->SupplyDetails) {
            $SupplyDetailsData = json_decode($req->SupplyDetails);
            if (is_array($SupplyDetailsData) && count($SupplyDetailsData) == 0) {
                return array('status' => false, 'message' => "Vendor Register Failed", 'errors' => ['SupplyDetails' => "Select a Product Sub Category"]);
            } else {
                DB::table($this->tmpDB . 'tbl_vendors_supply')->where('VendorID', $VendorID)->delete();
                foreach ($SupplyDetailsData as $item) {
                    $data = array(
                        "VendorID" => $VendorID,
                        "PCID" => $item->PCID,
                        "PSCID" => $item->PSCID,
                    );
                    $status = DB::Table($this->tmpDB . 'tbl_vendors_supply')->insert($data);
                }
                if ($status) {
                    return response()->json(['status' => true, 'message' => 'Supply Details Updated']);
                }
            }
        }
        if (json_decode($req->isStockPoints) && $req->StockPoints) {
            $StockPointsData = json_decode($req->StockPoints);
            if (is_array($StockPointsData) && count($StockPointsData) == 0) {
                return array('status' => false, 'message' => "Vendor Register Failed", 'errors' => ['StockPoints' => "Add a Stock Point"]);
            } else {
                DB::table($this->tmpDB . 'tbl_vendors_stock_point')->where('VendorID', $VendorID)->delete();
                foreach ($StockPointsData as $item) {
                    $Address = Helper::trimAddress($item->Address);
                    $data = array(
                        "VendorID" => $VendorID,
                        "UUID" => substr(str_shuffle(substr(uniqid(uniqid(), true), 0, 16)), 0, 12),
                        "CompleteAddress"=>$item->CompleteAddress,
                        "Latitude"=>$item->Latitude,
                        "Longitude"=>$item->Longitude,
                        "PointName" => $item->PointName,
                        "Address"=>$Address,
                        "PostalID" => $item->PostalID,
                        "CityID" => $item->CityID,
                        "TalukID" => $item->TalukID,
                        "DistrictID" => $item->DistrictID,
                        "StateID" => $item->StateID,
                        "CountryID" => $item->CountryID,
                        "MapData" => serialize(($item->MapData)),
                    );
                    $status = DB::table($this->tmpDB . 'tbl_vendors_stock_point')->insert($data);
                }
                if ($status) {
                    return response()->json(['status' => true, 'message' => 'Stock Points Updated']);
                }
            }
        }
        if (json_decode($req->isVehicles) && $req->Vehicles) {
            $VehiclesData = json_decode($req->Vehicles);
            if (is_array($VehiclesData) && count($VehiclesData) > 0) {
                foreach ($VehiclesData as $item) {
                    // $UUID = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
                    $UUID = isset($item->UUID) && !empty($item->UUID) ? $item->UUID : substr(str_shuffle(substr(uniqid(uniqid(), true), 0, 16)), 0, 12);
                    $VehicleID = isset($item->VehicleID) ? $item->VehicleID : "";
                    $data = array(
                        "VendorID" => $VendorID,
                        "VehicleID" => $VehicleID,
                        "UUID" => $UUID,
                        "VNumber" => $item->VNumber,
                        "VType" => $item->VTypeID,
                        "VBrand" => $item->VBrandID,
                        "VModel" => $item->VModelID,
                        "VLength" => $item->VLength,
                        "VDepth" => $item->VDepth,
                        "VWidth" => $item->VWidth,
                        "VCapacity" => $item->VCapacity,
                    );
                    $status = DB::table($this->tmpDB . 'tbl_vendors_vehicle')->insert($data);
                    if ($status && count($item->Images) > 0) {
                        foreach ($item->Images as $row) {
                            $ImgID = isset($item->ImgID) && !empty($item->ImgID) ? $item->ImgID : substr(str_shuffle(substr(uniqid(uniqid(), true), 0, 16)), 0, 12);
                            $imageData = array(
                                'VendorID' => $VendorID,
                                "VehicleID" => $VehicleID,
                                "UUID" => $UUID,
                                "ImgID" => $ImgID,
                                'gImage' => serialize($row),
                            );
                            $status = DB::table($this->tmpDB . 'tbl_vendors_vehicle_images')->insert($imageData);
                        }
                    }
                }
                if ($status) {
                    return response()->json(['status' => true, 'message' => 'Vehicles Data Updated']);
                }
            }
        }
        if (json_decode($req->isServiceLocations) && $req->ServiceLocations) {
            $ServiceLocationsData=json_decode($req->ServiceLocations);
            $ServiceBy = $ServiceLocationsData->ServiceBy;
            $ServiceData = $ServiceLocationsData->ServiceData;
            if (is_array($ServiceData) && count($ServiceData) == 0) {
                return array('status' => false, 'message' => "Vendor Register Failed", 'errors' => ['ServiceLocations' => "Add a Service Location"]);
            } else {
                DB::table($this->tmpDB.'tbl_vendors_service_locations')->where('VendorID',$VendorID)->delete();
                if($ServiceBy == "District"){
                    foreach($ServiceData as $data){
                        foreach($data->Districts as $item){
                            $tdata=array(
                                "VendorID"=>$VendorID,
                                "ServiceBy"=>$ServiceBy,
                                "StateID" => $data->StateID,
                                "DistrictID"=>$item->DistrictID,
                            );
                            $status=DB::Table($this->tmpDB.'tbl_vendors_service_locations')->insert($tdata);
                        }
                    }
                }elseif($ServiceBy == "PostalCode"){
                    foreach($ServiceData as $data){
                        foreach($data->Districts as $item){
                            foreach($item->PostalCodeIDs as $row){
                                $tdata=array(
                                    "VendorID"=>$VendorID,
                                    "ServiceBy"=>$ServiceBy,
                                    "StateID" => $data->StateID,
                                    "DistrictID"=>$item->DistrictID,
                                    "PostalCodeID"=>$row,
                                );
                                $status=DB::Table($this->tmpDB.'tbl_vendors_service_locations')->insert($tdata);
                            }
                        }
                    }
                }else{
                    $Range = $ServiceLocationsData->Range;
                    $tdata=array(
                        "VendorID"=>$VendorID,
                        "ServiceBy"=>$ServiceBy,
                        "Range" => $Range,
                    );
                    $status=DB::Table($this->tmpDB.'tbl_vendors_service_locations')->insert($tdata);
                }
                if ($status) {
                    return response()->json(['status' => true,'message' => 'Service Locations Updated']);
                }
            }
        }
        if ($req->isAll) {
            $VendorData = $this->getTmpVendorData($VendorID);
            // return $VendorData;
            if($VendorData){
                DB::beginTransaction();
                $status=false;
                $Logo="";
                $UploadedFiles = [];
                $DeletedFiles = [];
                try {
                    $dir="uploads/master/vendor/manage-vendors/".$VendorID."/";
                    $vdir="uploads/master/vendor/manage-vendors/".$VendorID."/vehicles/";
                    $dDir="uploads/master/vendor/manage-vendors/".$VendorID."/documents/";
                    if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
                    if (!file_exists( $vdir)) {mkdir( $vdir, 0777, true);}
                    if (!file_exists( $dDir)) {mkdir( $dDir, 0777, true);}
        
                    if(isset($VendorData->Logo) && $VendorData->hasFile('Logo')){
                        $file = $VendorData->file('Logo');
                        $fileName=md5($file->getClientOriginalName() . time());
                        $fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
                        $file->move($dir, $fileName1);
                        $Logo=$dir.$fileName1;
                    }else if(Helper::isJSON($VendorData->Logo)==true){
                        $Img=json_decode($VendorData->Logo);
                        if(file_exists($Img->uploadPath)){
                            $fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
                            copy($Img->uploadPath,$dir.$fileName1);
                            $Logo=$dir.$fileName1;
                            unlink($Img->uploadPath);
                        }
                    }

                    $data=array(
                        "MobileNumber1"=>$VendorData->MobileNumber1,
                        "MobileNumber2"=>$VendorData->MobileNumber2,
                        "VendorType"=>$VendorData->VendorType,
                        "UpdatedOn"=>date("Y-m-d H:i:s")
                    );
                    if($Logo!=""){
                        $data['Logo']=$Logo;
                    }
                    $status=DB::Table('tbl_vendors')->where('VendorID',$VendorID)->update($data);

                    //Vehicles
                    $VehicleUUIDs=[];
                    if($status && !empty($VendorData->Vehicles)){
                        foreach($VendorData->Vehicles as $data){
                            $VehicleUUIDs[]=$data->UUID;
                            $VehicleID = "";
                            $t=DB::Table('tbl_vendors_vehicle')->where('VendorID',$VendorID)->where('UUID',$data->UUID)->first();
                            if($t){
                                $tdata=array(
                                    "VNumber"=>$data->VNumber,
                                    "VType"=>$data->VType,
                                    "VBrand"=>$data->VBrand,
                                    "VModel"=>$data->VModel,
                                    "VLength"=>$data->VLength,
                                    "VDepth"=>$data->VDepth,
                                    "VWidth"=>$data->VWidth,
                                    "VCapacity"=>$data->VCapacity,
                                    "UpdatedOn"=>date("Y-m-d H:i:s")
                                );
                                $status=DB::Table('tbl_vendors_vehicle')->where('VendorID',$VendorID)->where('UUID',$data->UUID)->update($tdata);
                            }else{
                                $VehicleID = DocNum::getDocNum(docTypes::VendorVehicle->value,"",Helper::getCurrentFY());
                                $tdata=array(
                                    "VehicleID"=>$VehicleID,
                                    "VendorID"=>$VendorID,
                                    "UUID"=>$data->UUID,
                                    "VNumber"=>$data->VNumber,
                                    "VType"=>$data->VType,
                                    "VBrand"=>$data->VBrand,
                                    "VModel"=>$data->VModel,
                                    "VLength"=>$data->VLength,
                                    "VDepth"=>$data->VDepth,
                                    "VWidth"=>$data->VWidth,
                                    "VCapacity"=>$data->VCapacity,
                                    "CreatedOn"=>date("Y-m-d H:i:s")
                                );
                                $status=DB::Table('tbl_vendors_vehicle')->insert($tdata);
                                if($status){
                                    DocNum::updateDocNum(docTypes::VendorVehicle->value);
                                }
                            }
                            $ImgIDs=array();
                            if($status){
                                if (isset($data->Images) && !empty((array)$data->Images)) {
                                    foreach($data->Images as $vImgData){
                                        $ImgIDs[]=$vImgData->ImgID;
                                        $vImg=unserialize($vImgData->gImage);
                                        
                                        // return $vImg->uploadPath;
                                        if(file_exists($vImg->uploadPath) ){

                                            $fileName1=$vImg->fileName!=""?$vImg->fileName:Helper::RandomString(10)."png";
                                            copy($vImg->uploadPath,$vdir.$fileName1);
                                            
                                            $VImages=$vdir.$fileName1;
                                            $t=DB::Table('tbl_vendors_vehicle_images')->where('VendorID',$VendorID)->where('UUID',$data->UUID)->where('ImgID',$vImgData->ImgID)->first();
                                            if($t){
                                                $tmpData=array(
                                                    "gImage"=>$VImages,
                                                    "UpdatedOn"=>date("Y-m-d H:i:s")
                                                );
                                                $status=DB::Table('tbl_vendors_vehicle_images')->where('VendorID',$VendorID)->where('UUID',$data->UUID)->where('ImgID',$vImgData->ImgID)->update($tmpData);
                                            }else{
                                                $tmpData=array(
                                                    "SLNO"=>DocNum::getDocNum(docTypes::VendorVehicleImages->value,"",Helper::getCurrentFY()),
                                                    "VendorID"=>$VendorID,
                                                    "VehicleID"=>$VehicleID,
                                                    "UUID"=>$data->UUID,
                                                    "ImgID"=>$vImgData->ImgID,
                                                    "gImage"=>$VImages,
                                                    "CreatedOn"=>date("Y-m-d H:i:s")
                                                );
                                                $status=DB::Table('tbl_vendors_vehicle_images')->insert($tmpData);
                                                if($status){
                                                    DocNum::updateDocNum(docTypes::VendorVehicleImages->value);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            //delete images
                            if($status && count($ImgIDs)>0){
                                $sql="Select SLNO,gImage From tbl_vendors_vehicle_images Where VendorID='".$VendorID."' and UUID='".$data->UUID."' and ImgID not in('".implode("','",$ImgIDs)."')";
                                $result=DB::SELECT($sql);
                                for($m=0;$m<count($result);$m++){
                                    if($status){
                                        $RemoveImg[]=$result[$m]->gImage;
                                        $status=DB::Table('tbl_vendors_vehicle_images')->where('SLNO',$result[$m]->SLNO)->delete();
                                    }
                                }
                            }
                        }
                        if($status && count($VehicleUUIDs)>0){
                            $sql="Select * From tbl_vendors_vehicle Where VendorID='".$VendorID."' and UUID not in('".implode("','",$VehicleUUIDs)."')";
                            $result=DB::SELECT($sql);
                            for($m=0;$m<count($result);$m++){
                                if($status){
                                    $status=DB::Table('tbl_vendors_vehicle')->where('UUID',$result[$m]->UUID)->update(array("DFlag"=>1,"DeletedOn"=>date("Y-m-d H:i:s")));
                                }
                            }
                        }
                    }

                    //supply details
                    if($status && !empty($VendorData->SupplyDetails)){
                        $PSCIDs=[];
                        foreach($VendorData->SupplyDetails as $data){
                            $PSCIDs[]=$data->PSCID;
                            $t=DB::Table('tbl_vendors_supply')->where('VendorID',$VendorID)->Where('PCID',$data->PCID)->Where('PSCID',$data->PSCID)->first();
                            if(!$t){
                                $DetailID = DocNum::getDocNum(docTypes::VendorSupply->value,"",Helper::getCurrentFY());
                                $tdata=array(
                                    "DetailID"=>$DetailID,
                                    "VendorID"=>$VendorID,
                                    "PCID"=>$data->PCID,
                                    "PSCID"=>$data->PSCID,
                                    "CreatedOn"=>date("Y-m-d H:i:s")
                                );
                                $status=DB::Table('tbl_vendors_supply')->insert($tdata);
                                if($status){
                                    DocNum::updateDocNum(docTypes::VendorSupply->value);
                                }
                            }
                        }
                        if (!empty($PSCIDs)) {
                            DB::Table('tbl_vendors_supply')->where('VendorID',$VendorID)->WhereIn('PSCID',$PSCIDs)->update(['DFlag'=>0,'UpdatedOn'=>date('Y-m-d H:i:s')]);
                            DB::Table('tbl_vendors_supply')->where('VendorID',$VendorID)->WhereNotIn('PSCID',$PSCIDs)->update(['DFlag'=>1,'UpdatedOn'=>date('Y-m-d H:i:s')]);
                            $status=true;
                        }
                    }

                    //stock points details
                    if($status && !empty($VendorData->StockPoints)){
                        foreach($VendorData->StockPoints as $point){
                            $StockPointID = DocNum::getDocNum(docTypes::VendorStockPoint->value,"",Helper::getCurrentFY());
                            //service location details
                            $ServiceBy = $VendorData->ServiceLocations['ServiceBy'];
                            $Range = $VendorData->ServiceLocations['Range'];
                            $ServiceData = $VendorData->ServiceLocations['ServiceData'];
                            if($ServiceBy == "District"){
                                foreach($ServiceData as $sdata){
                                    foreach($sdata->Districts as $item){
                                        $t=DB::Table('tbl_vendors_service_locations')->where('VendorID',$VendorID)->where('StockPointID',$StockPointID)->where('ServiceBy',$ServiceBy)->Where('DistrictID',$item->DistrictID)->first();
                                        if(!$t){
                                            $PostalCodeIDs = DB::table($this->generalDB.'tbl_postalcodes')->where('DistrictID',$item->DistrictID)->where('ActiveStatus','Active')->where('DFlag',0)->pluck('PID')->toArray();
                                            if (!empty($PostalCodeIDs)) {
                                                foreach($PostalCodeIDs as $row){
                                                    $DetailID = DocNum::getDocNum(docTypes::VendorServiceLocation->value,"",Helper::getCurrentFY());
                                                    $tdata=array(
                                                        "DetailID"=>$DetailID,
                                                        "VendorID"=>$VendorID,
                                                        "StockPointID"=>$StockPointID,
                                                        "ServiceBy"=>$ServiceBy,
                                                        "StateID" => $sdata->StateID,
                                                        "DistrictID"=>$item->DistrictID,
                                                        "PostalCodeID"=>$row,
                                                        "CreatedOn"=>date("Y-m-d H:i:s")
                                                    );
                                                    $status=DB::Table('tbl_vendors_service_locations')->insert($tdata);
                                                    if($status){
                                                        DocNum::updateDocNum(docTypes::VendorServiceLocation->value);
                                                    }
                                                }
                                            }else{
                                                $DetailID = DocNum::getDocNum(docTypes::VendorServiceLocation->value,"",Helper::getCurrentFY());
                                                $tdata=array(
                                                    "DetailID"=>$DetailID,
                                                    "VendorID"=>$VendorID,
                                                    "StockPointID"=>$StockPointID,
                                                    "ServiceBy"=>$ServiceBy,
                                                    "StateID" => $sdata->StateID,
                                                    "DistrictID"=>$item->DistrictID,
                                                    "CreatedOn"=>date("Y-m-d H:i:s")
                                                );
                                                $status=DB::Table('tbl_vendors_service_locations')->insert($tdata);
                                                if($status){
                                                    DocNum::updateDocNum(docTypes::VendorServiceLocation->value);
                                                }
                                            }
                                        }
                                    }
                                }
                            }elseif($ServiceBy == "PostalCode"){
                                foreach($ServiceData as $sdata){
                                    foreach($sdata->Districts as $item){
                                        foreach($item->PostalCodeIDs as $row){
                                            $PostalCodeIDs[] = $row;
                                            $t=DB::Table('tbl_vendors_service_locations')->where('VendorID',$VendorID)->where('StockPointID',$StockPointID)->where('ServiceBy',$ServiceBy)->Where('PostalCodeID',$row)->first();
                                            if(!$t){
                                                $DetailID = DocNum::getDocNum(docTypes::VendorServiceLocation->value,"",Helper::getCurrentFY());
                                                $tdata=array(
                                                    "DetailID"=>$DetailID,
                                                    "VendorID"=>$VendorID,
                                                    "StockPointID"=>$StockPointID,
                                                    "ServiceBy"=>$ServiceBy,
                                                    "StateID" => $sdata->StateID,
                                                    "DistrictID"=>$item->DistrictID,
                                                    "PostalCodeID"=>$row,
                                                    "CreatedOn"=>date("Y-m-d H:i:s")
                                                );
                                                $status=DB::Table('tbl_vendors_service_locations')->insert($tdata);
                                                if($status){
                                                    DocNum::updateDocNum(docTypes::VendorServiceLocation->value);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            $tdata=array(
                                "StockPointID"=>$StockPointID,
                                "VendorID"=>$VendorID,
                                "UUID"=>$point->UUID,
                                "PointName"=>$point->PointName,
                                "CompleteAddress"=>$point->CompleteAddress,
                                "Latitude"=>$point->Latitude,
                                "Longitude"=>$point->Longitude,
                                "MapData"=>$point->MapData,
                                "ServiceBy"=>$ServiceBy,
                                "Range"=>$ServiceBy == 'Radius' ? $Range : 0 ,
                                "Address"=>$point->Address,
                                "PostalID"=>$point->PostalID,
                                "CityID"=>$point->CityID,
                                "TalukID"=>$point->TalukID,
                                "DistrictID"=>$point->DistrictID,
                                "StateID"=>$point->StateID,
                                "CountryID"=>$point->CountryID,
                                "CreatedBy"=>$VendorID,
                                "CreatedOn"=>date("Y-m-d H:i:s")
                            );
                            $status=DB::Table('tbl_vendors_stock_point')->insert($tdata);
                            if($status){
                                DocNum::updateDocNum(docTypes::VendorStockPoint->value);
                            }
                        }
                    }

                    //Documents
                    if($status && isset($VendorData->Documents) && !empty($VendorData->Documents)){
                        $tDocuments=array();
                        foreach($VendorData->Documents as $ImgID=>$Document){
                            if($status){
                                $tDocuments[]=$ImgID;
                                if($Document->referData->isTemp =="1" && file_exists($Document->uploadPath) ){
                                    $fileName1=$Document->fileName!=""?$Document->fileName:Helper::RandomString(10)."png";
                                    copy($Document->uploadPath,$dDir.$fileName1);
                                    $DocUrl=$dDir.$fileName1;
                                    $RemoveImg[]=$Document->uploadPath;
                                    $uploadingImgs[]=$DocUrl;
                                    $t=DB::Table('tbl_vendors_document')->where('VendorID',$VendorID)->where('ImgID',$ImgID)->get();
                                    if(count($t)>0){
                                        $tdata=array(
                                            "documents"=>$DocUrl,
                                            "CreatedOn"=>date("Y-m-d H:i:s")
                                        );
                                        $status=DB::Table('tbl_vendors_document')->where('VendorID',$VendorID)->where('ImgID',$ImgID)->update($tdata);
                                    }else{
                                        $tdata=array(
                                            "SLNO"=>DocNum::getDocNum(docTypes::VendorDocuments->value,"",Helper::getCurrentFY()),
                                            "VendorID"=>$VendorID,
                                            "ImgID"=>$ImgID,
                                            "documents"=>$DocUrl,
                                            "CreatedOn"=>date("Y-m-d H:i:s")
                                        );
                                        $status=DB::Table('tbl_vendors_document')->insert($tdata);
                                        if($status){
                                            DocNum::updateDocNum(docTypes::VendorDocuments->value);
                                        }
                                    }
                                }
                            }
                        }
                        if($status && count($tDocuments)>0){
                            $sql="Select SLNO,documents From tbl_vendors_document Where VendorID='".$VendorID."'  and ImgID not in('".implode("','",$tDocuments)."')";
                            $result=DB::SELECT($sql);
                            for($m=0;$m<count($result);$m++){
                                if($status){
                                    $RemoveImg[]=$result[$m]->documents;
                                    $status=DB::Table('tbl_vendors_document')->where('SLNO',$result[$m]->SLNO)->delete();
                                }
                            }
                        }
                    }

                    // $status = true;
                }catch(Exception $e) {
                    $status=false;
                }
                if($status==true){
                    DB::commit();
                    $this->deleteTmpVendorData($VendorID);
                    // $logData=array("Description"=>"Vendor Updated ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE->value,"ReferID"=>$VendorID,"OldData"=>$OldData,"NewData"=>$NewData,"IP"=>$VendorData->ip());
                    foreach($DeletedFiles as $Url){
                        // Helper::removeFile($Img);
                    }
                    return array('status'=>true,'message'=>"Vendor Updated Successfully");
                }else{
                    DB::rollback();
                    foreach($UploadedFiles as $Url){
                        // Helper::removeFile($Img);
                    }
                    return array('status'=>false,'message'=>"Vendor Update Failed");
                }
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'VENDOR UPDATE FAILED',
        ]);
    }

    public function getVendorData(request $req){
        $VendorID = $this->ReferID;
		$VendorData = DB::table('tbl_vendors')->whereNot('VendorType',Null)->where('VendorID',$VendorID)->first();
        if(!$VendorData){
            return response()->json(['status' => false,'message' => "No Vendors Found! Contact Admin"]);
        }elseif($VendorData->DFlag == 1){
            return response()->json(['status' => false,'message' => "Vendor has been Deleted! Contact Admin"]);
        }elseif($VendorData->ActiveStatus =='Inactive'){
            return response()->json(['status' => false,'message' => "You are currently inactive! Contact Admin"]);
        }elseif($VendorData->isApproved == 0){
            return response()->json(['status' => false,'message' => "You are not approved by Admin"]);
        }else{
            $VendorData->PCategories = unserialize($VendorData->PCategories);
            $VendorData->Logo = url('/').'/'.$VendorData->Logo;
            $VendorData->Documents = DB::table('tbl_vendors_document as VD')->leftJoin('tbl_vendor_required_documents as VRD','VRD.DocName','VD.DocName')->where('VD.VendorID', $VendorID)->select('VD.DocName','VRD.DisplayName', DB::raw('CONCAT("' . url('/') . '/", documents) AS Documents'))->get();
            $VendorData->PostalCodeID =$VendorData->PostalCode;
            $VendorData->PostalCode =DB::table($this->generalDB.'tbl_postalcodes')->where('PID',$VendorData->PostalCodeID)->value('PostalCode');

            $Vehicles = DB::table('tbl_vendors_vehicle')->where('DFlag',0)->where('VendorID',$VendorID)->get();
            if(!empty($Vehicles)){
                foreach($Vehicles as $item){
                    $item->Images= DB::table('tbl_vendors_vehicle_images')->where('VendorID',$VendorID)->where('UUID',$item->UUID)->select('VehicleID','UUID',DB::raw('CONCAT("' . url('/') . '/", gImage) as gImage'))->get();
                }
            }
            $VendorData->Vehicles = $Vehicles;

            $VendorData->SupplyDetails = DB::table('tbl_vendors_supply')->where('DFlag',0)->where('VendorID',$VendorID)->get();

            $VendorData->StockPoints = DB::table('tbl_vendors_stock_point')->where('DFlag',0)->where('VendorID',$VendorID)->get();

            $ServiceLocations = [];
            $ServiceLocation = DB::table('tbl_vendors_service_locations')->where('DFlag',0)->where('VendorID',$VendorID)->groupBy('StateID','ServiceBy')->select('StateID','ServiceBy')->get();
            if(count($ServiceLocation)>0){
                $ServiceLocations = [
                    'ServiceBy'=> $ServiceLocation[0]->ServiceBy,
                    'ServiceData'=> [],
                ];
    
                foreach ($ServiceLocation as $item) {
                    $item->Districts = DB::table('tbl_vendors_service_locations')->where('DFlag',0)->where('VendorID', $VendorID)->where('StateID', $item->StateID)->groupBy('DistrictID')->select('DistrictID')->get();
                    foreach ($item->Districts as $row){
                        $postalCodeIDs  = DB::table('tbl_vendors_service_locations')->where('DFlag',0)->where('StateID',$item->StateID)->where('DistrictID',$row->DistrictID)->where('VendorID',$VendorID)->pluck('PostalCodeID')->toArray();
                        if (count($postalCodeIDs) > 0) {
                            $row->PostalCodeIDs = $postalCodeIDs;
                        }
                    }
                    unset($item->ServiceBy);
                    $ServiceLocations['ServiceData'][] = $item;
                }
            }
            $VendorData->ServiceLocations = $ServiceLocations;
            return response()->json(['status' => true,'data' => $VendorData]);
        }
	}

    //Vehicles
    public function getVehicleData(request $req){
        $VendorID = $this->ReferID;

		$Vehicles = DB::table('tbl_vendors_vehicle as VV')
        ->join($this->generalDB.'tbl_vehicle_type as VT','VT.VehicleTypeID','VV.VType')
        ->join($this->generalDB.'tbl_vehicle_brand as VB','VB.VehicleBrandID','VV.VBrand')
        ->join($this->generalDB.'tbl_vehicle_model as VM','VM.VehicleModelID','VV.VModel')
        ->where('VV.DFlag',0)->where('VV.VendorID',$VendorID)
        ->select('VV.VehicleID','VV.UUID','VV.VNumber','VV.VType','VV.VBrand','VV.VModel','VT.VehicleType','VB.VehicleBrandName','VM.VehicleModel','VV.VLength','VV.VDepth','VV.VWidth','VV.VCapacity')
        ->get();
        if(!empty($Vehicles)){
            foreach($Vehicles as $item){
                $item->vImages= DB::table('tbl_vendors_vehicle_images')->where('VendorID',$VendorID)->where('UUID',$item->UUID)->select('VehicleID','UUID','ImgID',DB::raw('CONCAT("' . url('/') . '/", gImage) as gImage'))->get();
            }
        }
        return response()->json([ 'status' => true, 'data' => $Vehicles ]);
	}
    public function AddVehicle(Request $req){
        $VendorID = $this->ReferID;
		DB::beginTransaction();
        try {
            $OldData=$NewData=[];

            $vdir="uploads/master/vendor/manage-vendors/".$VendorID."/vehicles/";
            if (!file_exists( $vdir)) {mkdir( $vdir, 0777, true);}

            $UUID = substr(str_shuffle(substr(uniqid(uniqid(), true), 0, 16)), 0, 12);
            $VehicleID = DocNum::getDocNum(docTypes::VendorVehicle->value,"",Helper::getCurrentFY());
            $data=array(
                "VehicleID"=>$VehicleID,
                "VendorID"=>$VendorID,
                "UUID"=>$UUID,
                "VNumber"=>$req->VNumber,
                "VType"=>$req->VType,
                "VBrand"=>$req->VBrand,
                "VModel"=>$req->VModel,
                "VLength"=>$req->VLength,
                "VDepth"=>$req->VDepth,
                "VWidth"=>$req->VWidth,
                "VCapacity"=>$req->VCapacity,
                "CreatedOn"=>date("Y-m-d H:i:s")
            );
            $status=DB::Table('tbl_vendors_vehicle')->insert($data);

            $vImages=json_decode($req->vImages);
            if ($status && count($vImages) > 0) {
                foreach ($vImages as $vImg) {
                    if(file_exists($vImg->uploadPath) ){
                        $fileName1=$vImg->fileName!=""?$vImg->fileName:Helper::RandomString(10)."png";
                        copy($vImg->uploadPath,$vdir.$fileName1);
                        
                        $ImgID = substr(str_shuffle(substr(uniqid(uniqid(), true), 0, 16)), 0, 12);
                        $VImages=$vdir.$fileName1;
                        $Data=array(
                            "SLNO"=>DocNum::getDocNum(docTypes::VendorVehicleImages->value,"",Helper::getCurrentFY()),
                            "VendorID"=>$VendorID,
                            "VehicleID"=>$VehicleID,
                            "UUID"=>$UUID,
                            "ImgID"=>$ImgID,
                            "gImage"=>$VImages,
                            "CreatedOn"=>date("Y-m-d H:i:s")
                        );
                        $status=DB::Table('tbl_vendors_vehicle_images')->insert($Data);
                        if($status){
                            DocNum::updateDocNum(docTypes::VendorVehicleImages->value);
                        }
                    }
                }
            }
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            DocNum::updateDocNum(docTypes::VendorVehicle->value);
            $NewData=DB::table('tbl_vendors_vehicle_images as VVI')->join('tbl_vendors_vehicle as VV','VV.UUID','VVI.UUID')->where('VV.VendorID',$VendorID)->where('VV.VehicleID',$VehicleID)->get();
            $logData=array("Description"=>"Vendor Vehicle Added","ModuleName"=>"Vendor Vehicle","Action"=>"Add","ReferID"=>$VehicleID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$VendorID,"IP"=>$req->ip());
            logs::Store($logData);
            return response()->json(['status' => true ,'message' => "Vendor Vehicle Added Successfully!"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Vendor Vehicle Add Failed!"]);
        }
	}
    public function UpdateVehicle(Request $req){
        $VendorID = $this->ReferID;
        $VehicleID = $req->VehicleID;

		DB::beginTransaction();
        try {
            $OldData=$NewData=[];
            $OldData=DB::table('tbl_vendors_vehicle_images as VVI')->join('tbl_vendors_vehicle as VV','VV.UUID','VVI.UUID')->where('VV.VendorID',$VendorID)->where('VV.VehicleID',$VehicleID)->get();
            // return $VendorID;

            $vdir="uploads/master/vendor/manage-vendors/".$VendorID."/vehicles/";
            if (!file_exists( $vdir)) {mkdir( $vdir, 0777, true);}

            $data=array(
                "VNumber"=>$req->VNumber,
                "VType"=>$req->VType,
                "VBrand"=>$req->VBrand,
                "VModel"=>$req->VModel,
                "VLength"=>$req->VLength,
                "VDepth"=>$req->VDepth,
                "VWidth"=>$req->VWidth,
                "VCapacity"=>$req->VCapacity,
                "UpdatedOn"=>date("Y-m-d H:i:s")
            );
            $status=DB::Table('tbl_vendors_vehicle')->where('VehicleID',$VehicleID)->update($data);

            $vImages=json_decode($req->vImages);
            if ($status && count($vImages) > 0) {
                $ImgIDs = [];
                foreach ($vImages as $vImg) {
                    if (isset($vImg->ImgID) && $vImg->ImgID) {
                        $ImgIDs[] = $vImg->ImgID;
                    } elseif(isset($vImg->uploadPath) && $vImg->uploadPath) {
                        $ImgID = substr(str_shuffle(substr(uniqid(uniqid(), true), 0, 16)), 0, 12);
                        if (file_exists($vImg->uploadPath)) {
                            $fileName1 = $vImg->fileName != "" ? $vImg->fileName : Helper::RandomString(10) . "png";
                            copy($vImg->uploadPath, $vdir . $fileName1);
                            $VImages = $vdir . $fileName1;
                            $Data = [
                                "SLNO" => DocNum::getDocNum(docTypes::VendorVehicleImages->value,"",Helper::getCurrentFY()),
                                "VendorID" => $VendorID,
                                "VehicleID" => $VehicleID,
                                "UUID" => $OldData[0]->UUID,
                                "ImgID" => $ImgID,
                                "gImage" => $VImages,
                                "CreatedOn" => date("Y-m-d H:i:s")
                            ];

                            $status = DB::Table('tbl_vendors_vehicle_images')->insertOrIgnore($Data);
                            if ($status) {
                                DocNum::updateDocNum(docTypes::VendorVehicleImages->value);
                            }
                            $ImgIDs[] = $ImgID;
                        }
                    }
                }
                DB::Table('tbl_vendors_vehicle_images')->where('VendorID', $VendorID)->where('VehicleID', $VehicleID)->whereNotIn('ImgID', $ImgIDs)->delete();

            }else if(count($vImages) == 0){
                DB::Table('tbl_vendors_vehicle_images')->where('VendorID', $VendorID)->where('VehicleID', $VehicleID)->delete();
            }
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            $NewData=DB::table('tbl_vendors_vehicle_images as VVI')->join('tbl_vendors_vehicle as VV','VV.UUID','VVI.UUID')->where('VV.VendorID',$VendorID)->where('VV.VehicleID',$VehicleID)->get();
            $logData=array("Description"=>"Vendor Vehicle Updated","ModuleName"=>"Vendor Vehicle","Action"=>"Update","ReferID"=>$VehicleID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$VendorID,"IP"=>$req->ip());
            logs::Store($logData);
            return response()->json(['status' => true ,'message' => "Vendor Vehicle Updated Successfully!"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Vendor Vehicle Update Failed!"]);
        }
	}

    public function DeleteVehicle(Request $req){
        $VendorID = $this->ReferID;
        $VehicleID = $req->VehicleID;
        DB::beginTransaction();
        try {
            $OldData=$NewData=[];
            $OldData=DB::table('tbl_vendors_vehicle_images as VVI')->join('tbl_vendors_vehicle as VV','VV.UUID','VVI.UUID')->where('VV.VendorID',$VendorID)->where('VV.VehicleID',$VehicleID)->get();
            $status = DB::Table('tbl_vendors_vehicle')->where('VendorID',$VendorID)->where('VehicleID',$VehicleID)->update(['DFlag'=>1,'DeletedBy'=>$VendorID,'DeletedOn'=>date('Y-m-d H:i:s')]);
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            $NewData=DB::table('tbl_vendors_vehicle_images as VVI')->join('tbl_vendors_vehicle as VV','VV.UUID','VVI.UUID')->where('VV.VendorID',$VendorID)->where('VV.VehicleID',$VehicleID)->get();
            $logData=array("Description"=>"Vendor Vehicle Deleted","ModuleName"=>"Vendor Vehicle","Action"=>"Delete","ReferID"=>$VehicleID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$VendorID,"IP"=>$req->ip());
            logs::Store($logData);
            return response()->json(['status' => true ,'message' => "Vehicle Deleted Successfully!"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Vehicle Delete Failed!"]);
        }
    }
    
    public function getTmpVendorData($VendorID){
		$VendorData = DB::table($this->tmpDB.'tbl_vendors')->where('VendorID',$VendorID)->first();
        if($VendorData){
            $Vehicles = DB::table($this->tmpDB.'tbl_vendors_vehicle')->where('VendorID',$VendorID)->get();
            if(!empty($Vehicles)){
                foreach($Vehicles as $item){
                    $item->Images= DB::table($this->tmpDB.'tbl_vendors_vehicle_images')->where('VendorID',$VendorID)->where('UUID',$item->UUID)->get();
                }
            }
            $VendorData->Vehicles = $Vehicles;
            $VendorData->SupplyDetails = DB::table($this->tmpDB.'tbl_vendors_supply')->where('VendorID',$VendorID)->get();
            $VendorData->StockPoints = DB::table($this->tmpDB.'tbl_vendors_stock_point')->where('VendorID',$VendorID)->get();

            $ServiceLocation = DB::table($this->tmpDB.'tbl_vendors_service_locations')->where('VendorID',$VendorID)->groupBy('StateID','ServiceBy','Range')->select('StateID','ServiceBy','Range')->get();
            $ServiceLocations = [
                'ServiceBy'=> $ServiceLocation[0]->ServiceBy,
                'Range'=> $ServiceLocation[0]->Range,
                'ServiceData'=> [],
            ];
			foreach ($ServiceLocation as $item) {
				$item->Districts = DB::table($this->tmpDB.'tbl_vendors_service_locations')->where('VendorID', $VendorID)->where('StateID', $item->StateID)->groupBy('DistrictID')->select('DistrictID')->get();
				foreach ($item->Districts as $row){
					$postalCodeIDs  = DB::table($this->tmpDB.'tbl_vendors_service_locations')->where('StateID',$item->StateID)->where('DistrictID',$row->DistrictID)->where('VendorID',$VendorID)->pluck('PostalCodeID')->toArray();
                    if (count($postalCodeIDs) > 0) {
                        $row->PostalCodeIDs = $postalCodeIDs;
                    }
                }
                unset($item->ServiceBy);
                $ServiceLocations['ServiceData'][] = $item;
			}
            $VendorData->ServiceLocations = $ServiceLocations;
            
            return $VendorData;
        }
	}

    public function CreateTmpVendorTables() {
        $status = DB::statement("CREATE TABLE IF NOT EXISTS {$this->tmpDB}`tbl_vendors` (
            `VendorID` varchar(50) PRIMARY KEY NOT NULL,
            `VendorName` varchar(150) DEFAULT NULL,
            `VendorCoName` text DEFAULT NULL,
            `VendorCoWebsite` text DEFAULT NULL,
            `Reference` text DEFAULT NULL,
            `GSTNo` varchar(50) DEFAULT NULL,
            `PCategories` text DEFAULT NULL,
            `VendorType` varchar(50) DEFAULT NULL,
            `Email` varchar(150) DEFAULT NULL,
            `MobileNumber1` varchar(50) DEFAULT NULL,
            `MobileNumber2` varchar(50) DEFAULT NULL,
            `Address` text DEFAULT NULL,
            `PostalCode` varchar(50) DEFAULT NULL,
            `CityID` varchar(50) DEFAULT NULL,
            `TalukID` varchar(50) DEFAULT NULL,
            `DistrictID` varchar(50) DEFAULT NULL,
            `StateID` varchar(50) DEFAULT NULL,
            `CountryID` varchar(50) DEFAULT NULL,
            `Logo` text DEFAULT NULL,
            `CreatedOn` datetime DEFAULT CURRENT_TIMESTAMP
        )");
        $status = DB::statement("CREATE TABLE IF NOT EXISTS {$this->tmpDB}`tbl_vendors_supply` (
            `DetailID` INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
            `VendorID` varchar(50) DEFAULT NULL,
            `PCID` varchar(50) DEFAULT NULL,
            `PSCID` varchar(50) DEFAULT NULL,
            `CreatedOn` datetime DEFAULT CURRENT_TIMESTAMP
        )");
        $status = DB::statement("CREATE TABLE IF NOT EXISTS {$this->tmpDB}`tbl_vendors_stock_point` (
            `SNo` INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
            `StockPointID` varchar(50) DEFAULT NULL,
            `UUID` varchar(50) DEFAULT NULL,
            `VendorID` varchar(50) DEFAULT NULL,
            `PointName` varchar(150) DEFAULT NULL,
            `Address` text DEFAULT NULL,
            `PostalID` varchar(50) DEFAULT NULL,
            `CityID` varchar(50) DEFAULT NULL,
            `TalukID` varchar(50) DEFAULT NULL,
            `DistrictID` varchar(50) DEFAULT NULL,
            `StateID` varchar(50) DEFAULT NULL,
            `CountryID` varchar(50) DEFAULT NULL,
            `CreatedOn` datetime DEFAULT CURRENT_TIMESTAMP
        )");
        $status = DB::statement("CREATE TABLE IF NOT EXISTS {$this->tmpDB}`tbl_vendors_vehicle` (
            `SNo` INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
            `VendorID` varchar(50) DEFAULT NULL,
            `VehicleID` varchar(50) DEFAULT NULL,
            `UUID` varchar(150) DEFAULT NULL,
            `VNumber` varchar(50) DEFAULT NULL,
            `VType` varchar(50) DEFAULT NULL,
            `VBrand` varchar(50) DEFAULT NULL,
            `VModel` varchar(50) DEFAULT NULL,
            `VLength` varchar(50) DEFAULT NULL,
            `VDepth` varchar(50) DEFAULT NULL,
            `VWidth` varchar(50) DEFAULT NULL,
            `VCapacity` varchar(50) DEFAULT NULL,
            `CreatedOn` datetime DEFAULT CURRENT_TIMESTAMP
        )");
        $status = DB::statement("CREATE TABLE IF NOT EXISTS {$this->tmpDB}`tbl_vendors_vehicle_images` (
            `SNo` INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
            `SLNo` varchar(50) DEFAULT NULL,
            `VendorID` varchar(50) DEFAULT NULL,
            `VehicleID` varchar(50) DEFAULT NULL,
            `UUID` varchar(150) DEFAULT NULL,
            `ImgID` varchar(50) DEFAULT NULL,
            `gImage` text DEFAULT NULL,
            `CreatedOn` datetime DEFAULT CURRENT_TIMESTAMP
        )");
        $status = DB::statement("CREATE TABLE IF NOT EXISTS {$this->tmpDB}`tbl_vendors_service_locations` (
            `SNo` INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
            `VendorID` varchar(50) DEFAULT NULL,
            `ServiceBy` enum('District','PostalCode','Radius') NOT NULL DEFAULT 'PostalCode',
            `Latitude` varchar(100) DEFAULT NULL,
            `Longitude` varchar(100) DEFAULT NULL,
            `Raduis` int(50) DEFAULT NULL,
            `PostalCodeID` varchar(50) DEFAULT NULL,
            `DistrictID` varchar(50) DEFAULT NULL,
            `StateID` varchar(50) DEFAULT NULL,
            `CreatedOn` datetime DEFAULT CURRENT_TIMESTAMP
        )");
        return $status;
    }

    public function deleteTmpVendorData($VendorID) {
        DB::table($this->tmpDB.'tbl_vendors_vehicle_images')->where('VendorID', $VendorID)->delete();
    
        DB::table($this->tmpDB.'tbl_vendors_vehicle')->where('VendorID', $VendorID)->delete();
    
        DB::table($this->tmpDB.'tbl_vendors_supply')->where('VendorID', $VendorID)->delete();
    
        DB::table($this->tmpDB.'tbl_vendors_stock_point')->where('VendorID', $VendorID)->delete();
    
        DB::table($this->tmpDB.'tbl_vendors_service_locations')->where('VendorID', $VendorID)->delete();
    
        DB::table($this->tmpDB.'tbl_vendors')->where('VendorID', $VendorID)->delete();
    }

    public function Validation(Request $req){
        if ($req->has('General') && $req->General != null) {
            $GeneralData = json_decode($req->General, true);
            $ValidDB=[];
                        
            $ValidDB['Country']['TABLE']=$this->generalDB."tbl_countries";
            $ValidDB['Country']['ErrMsg']="Country name does not exist";
            $ValidDB['Country']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$GeneralData['CountryID']);
            $ValidDB['Country']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>"Active");
            $ValidDB['Country']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

            $ValidDB['State']['TABLE']=$this->generalDB."tbl_states";
            $ValidDB['State']['ErrMsg']="State name does not exist";
            $ValidDB['State']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$GeneralData['CountryID']);
            $ValidDB['State']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$GeneralData['StateID']);
            $ValidDB['State']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>"Active");
            $ValidDB['State']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

            $ValidDB['District']['TABLE']=$this->generalDB."tbl_districts";
            $ValidDB['District']['ErrMsg']="District name does not exist";
            $ValidDB['District']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$GeneralData['CountryID']);
            $ValidDB['District']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$GeneralData['StateID']);
            $ValidDB['District']['WHERE'][]=array("COLUMN"=>"DistrictID","CONDITION"=>"=","VALUE"=>$GeneralData['DistrictID']);
            $ValidDB['District']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>"Active");
            $ValidDB['District']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

            $ValidDB['Taluk']['TABLE']=$this->generalDB."tbl_taluks";
            $ValidDB['Taluk']['ErrMsg']="Taluk name does not exist";
            $ValidDB['Taluk']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$GeneralData['CountryID']);
            $ValidDB['Taluk']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$GeneralData['StateID']);
            $ValidDB['Taluk']['WHERE'][]=array("COLUMN"=>"DistrictID","CONDITION"=>"=","VALUE"=>$GeneralData['DistrictID']);
            $ValidDB['Taluk']['WHERE'][]=array("COLUMN"=>"TalukID","CONDITION"=>"=","VALUE"=>$GeneralData['TalukID']);
            $ValidDB['Taluk']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>"Active");
            $ValidDB['Taluk']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

            $ValidDB['PostalCode']['TABLE']=$this->generalDB."tbl_postalcodes";
            $ValidDB['PostalCode']['ErrMsg']="Postal Code does not exist";
            $ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$GeneralData['CountryID']);
            $ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$GeneralData['StateID']);
            $ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"DistrictID","CONDITION"=>"=","VALUE"=>$GeneralData['DistrictID']);
            $ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"PID","CONDITION"=>"=","VALUE"=>$GeneralData['PostalCodeID']);
            $ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>"Active");
            $ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

            $ValidDB['City']['TABLE']=$this->generalDB."tbl_cities";
            $ValidDB['City']['ErrMsg']="City Name does not exist";
            $ValidDB['City']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$GeneralData['CountryID']);
            $ValidDB['City']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$GeneralData['StateID']);
            $ValidDB['City']['WHERE'][]=array("COLUMN"=>"DistrictID","CONDITION"=>"=","VALUE"=>$GeneralData['DistrictID']);
            $ValidDB['City']['WHERE'][]=array("COLUMN"=>"TalukID","CONDITION"=>"=","VALUE"=>$GeneralData['TalukID']);
            $ValidDB['City']['WHERE'][]=array("COLUMN"=>"PostalID","CONDITION"=>"=","VALUE"=>$GeneralData['PostalCodeID']);
            $ValidDB['City']['WHERE'][]=array("COLUMN"=>"CityID","CONDITION"=>"=","VALUE"=>$GeneralData['CityID']);
            $ValidDB['City']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>"Active");
            $ValidDB['City']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

            $rules = [
                'VendorName' => ['required', 'max:50', new ValidUnique(array("TABLE" => "tbl_vendors", "WHERE" => " VendorName='" . $GeneralData['VendorName'] . "' and VendorID<>'".$GeneralData['VendorID']."'  "), "This Vendor Name is already taken.")],
                'VendorCoName' => ['required','max:50', new ValidUnique(array("TABLE" => "tbl_vendors", "WHERE" => " VendorCoName='" . $GeneralData['VendorCoName'] . "' "), "This Vendor Company Name is already taken.")],
                'VendorCoWebsite' => ['max:50', new ValidUnique(array("TABLE" => "tbl_vendors", "WHERE" => " VendorCoWebsite='" . $GeneralData['VendorCoWebsite'] . "' "), "This Vendor Company Website is already taken.")],
                // 'GSTNo' => ['required', 'regex:/^\d{2}[A-Z]{5}\d{4}[A-Z]{1}\d[Z]{1}[0-9A-Z]{1}$/'],
                'Email' => ['required', 'email:filter', new ValidUnique(array("TABLE" => "users", "WHERE" => " EMail='" . $GeneralData['EMail'] . "' and LoginType = 'Vendor' and UserID <> '".$this->UserID."' "), "This Email is already taken.")],
                'MobileNumber1' => ['required', 'regex:/^[0-9]{10}$/', new ValidUnique(array("TABLE" => "users", "WHERE" => " MobileNumber='" . $GeneralData['MobileNumber1'] . "' and LoginType = 'Vendor' and UserID <> '".$this->UserID."' "), "This Mobile Number is already taken.")],
                'MobileNumber2' => ['nullable', 'regex:/^[0-9]{10}$/'],
                'CountryID' => ['required', new ValidDB($ValidDB['Country'])],
                'StateID' => ['required', new ValidDB($ValidDB['State'])],
                'DistrictID' => ['required', new ValidDB($ValidDB['District'])],
                'TalukID' => ['required', new ValidDB($ValidDB['Taluk'])],
                'PostalCodeID' => ['required', new ValidDB($ValidDB['PostalCode'])],
                'CityID' => ['required', new ValidDB($ValidDB['City'])],
            ];

            $messages = [
                'Logo.mimes' => "The Logo field must be a file of type: " . implode(", ", $this->FileTypes['category']['Images']) . ".",
                'VendorCoName.required' => 'Vendor Company Name is required',
                'MobileNumber1.regex' => 'Mobile Number 1 should be 10 digits',
                'MobileNumber2.regex' => 'Mobile Number 2 should be 10 digits',
                // 'GSTNo.regex' => 'Invalid GST Number Format',
                // 'GSTNo.required' => 'GST Number is Required',
            ];

            if ($req->hasFile('Logo')) {
                $rules['Logo'] = 'mimes:' . implode(",", $this->FileTypes['category']['Images']);
            }

            $validator = Validator::make($GeneralData, $rules, $messages);

            if ($validator->fails()) {
                return array('status' => false, 'message' => "Vendor Register Failed", 'errors' => $validator->errors());
            }
        }
    }

    //Product Mapping
    
    public function getVendorMappedProducts(Request $req){
        $VendorID = $this->ReferID;

        $pageNo = $req->PageNo ?? 1;
        $perPage = 10;

        $StockTableName = Helper::getStockTable($VendorID);
        $VendorProductData = DB::table('tbl_vendors_product_mapping as VPM')
            ->join('tbl_products as P', 'P.ProductID', 'VPM.ProductID')
            ->join('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
            ->join('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
            ->join('tbl_uom as U', 'U.UID', 'P.UID')
            ->leftJoin(DB::raw("(SELECT ProductID, SUM(Qty) AS TotalQty FROM $StockTableName WHERE Date = '".date('Y-m-d')."' GROUP BY ProductID) AS VSP"), 'VSP.ProductID', 'P.ProductID')
            ->where('VPM.Status', 1)
            ->where('VPM.VendorID', $VendorID)
            ->where('P.ActiveStatus', 'Active')
            ->where('P.DFlag', 0)
            ->where('PC.ActiveStatus', 'Active')
            ->where('PC.DFlag', 0)
            ->where('PSC.ActiveStatus', 'Active')
            ->where('PSC.DFlag', 0)
            ->select('VPM.VendorID','P.ProductID','VPM.VendorPrice','P.ProductName','P.ProductID as ProductID','PC.PCName','PC.PCID','PSC.PSCID', 'PSC.PSCName', 'U.UName', 'U.UCode', 'P.VideoURL','ProductImage','ProductBrochure')
            ->paginate($perPage, ['*'], 'page', $pageNo);

        foreach ($VendorProductData as $row) {
            $row->ProductImage =  file_exists($row->ProductImage) ? url('/') . '/' . $row->ProductImage : null;
            $row->ProductBrochure =  file_exists($row->ProductBrochure) ? url('/') . '/' . $row->ProductBrochure : null;
        }
        return response()->json([
            'status' => true,
            'data' => $VendorProductData->items(),
            'CurrentPage' => $VendorProductData->currentPage(),
            'LastPage' => $VendorProductData->lastPage(),
        ]);
    }

    public function AddProduct(Request $req){
        $VendorID = $this->ReferID;
		DB::beginTransaction();
        try {
            $OldData=DB::table('tbl_vendors_product_mapping')->where('VendorID',$VendorID)->where('ProductID',$req->ProductID)->get();

            $isProductMapped=DB::Table('tbl_vendors_product_mapping')->where('VendorID',$VendorID)->Where('ProductID',$req->ProductID)->where('Status',1)->first();
            $isProductDeleted=DB::Table('tbl_vendors_product_mapping')->where('VendorID',$VendorID)->Where('ProductID',$req->ProductID)->where('Status',0)->first();
            if($isProductMapped){
                return response()->json(['status' => false,'message' => "Product Already Mapped!"]);
            }elseif($isProductDeleted){
               $status = DB::Table('tbl_vendors_product_mapping')->where('VendorID',$VendorID)->where('ProductID',$req->ProductID)->update(['VendorPrice' => $req->VendorPrice ? $req->VendorPrice : 0,'Status'=>1,'UpdatedOn'=>date('Y-m-d H:i:s')]);
            }else{
                $DetailID = DocNum::getDocNum(docTypes::VendorProductMapping->value,"",Helper::getCurrentFY());
                $tdata=array(
                    "DetailID"=>$DetailID,
                    "VendorID"=>$VendorID,
                    "ProductID"=>$req->ProductID,
                    "VendorPrice"=>$req->VendorPrice,
                    "PCID"=>$req->PCID,
                    "PSCID"=>$req->PSCID,
                );
                $status=DB::Table('tbl_vendors_product_mapping')->insert($tdata);
                if($status){
                    DocNum::updateDocNum(docTypes::VendorProductMapping->value);
                }
            }
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            $NewData=DB::table('tbl_vendors_product_mapping')->where('VendorID',$VendorID)->where('ProductID',$req->ProductID)->get();
            $logData=array("Description"=>"Vendor Product Mapped","ModuleName"=>"Vendor Product Mapping","Action"=>"Add","ReferID"=>$VendorID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$VendorID,"IP"=>$req->ip());
            logs::Store($logData);
            return response()->json(['status' => true ,'message' => "Product Mapped Successfully!"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Product Mapping Failed!"]);
        }
	}

    public function UpdateProduct(Request $req){
        $VendorID = $this->ReferID;
		DB::beginTransaction();
        try {
            $OldData=DB::table('tbl_vendors_product_mapping')->where('VendorID',$VendorID)->where('ProductID',$req->ProductID)->get();
            $status = DB::Table('tbl_vendors_product_mapping')->where('VendorID',$VendorID)->where('ProductID',$req->ProductID)->update(['VendorPrice' => $req->VendorPrice,'UpdatedOn'=>date('Y-m-d H:i:s')]);
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            $NewData=DB::table('tbl_vendors_product_mapping')->where('VendorID',$VendorID)->where('ProductID',$req->ProductID)->get();
            $logData=array("Description"=>"Vendor Product Price Updated","ModuleName"=>"Vendor Product Mapping","Action"=>"Add","ReferID"=>$VendorID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$VendorID,"IP"=>$req->ip());
            logs::Store($logData);
            return response()->json(['status' => true ,'message' => "Product Price Updated Successfully!"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Product Price Update Failed!"]);
        }
	}

    public function DeleteProduct(Request $req){
        $VendorID = $this->ReferID;
		DB::beginTransaction();
        try {
            $OldData=DB::table('tbl_vendors_product_mapping')->where('VendorID',$VendorID)->where('ProductID',$req->ProductID)->get();
            $status = DB::Table('tbl_vendors_product_mapping')->where('VendorID',$VendorID)->where('ProductID',$req->ProductID)->update(['Status'=>0,'UpdatedOn'=>date('Y-m-d H:i:s')]);
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            $NewData=DB::table('tbl_vendors_product_mapping')->where('VendorID',$VendorID)->where('ProductID',$req->ProductID)->get();
            $logData=array("Description"=>"Vendor Product Deleted","ModuleName"=>"Vendor Product Mapping","Action"=>"Delete","ReferID"=>$VendorID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$VendorID,"IP"=>$req->ip());
            logs::Store($logData);
            return response()->json(['status' => true ,'message' => "Product Deleted Successfully!"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Product Delete Failed!"]);
        }
	}

    // Stock Points

    public function getVendorStockData(Request $req){
        $VendorID = $this->ReferID;
        $StockTableName = Helper::getStockTable($VendorID);
        $VendorStockPoints= DB::table('tbl_vendors_stock_point')->where('DFlag',0)->where('VendorID',$VendorID)->select('StockPointID','PointName')->get();
        foreach ($VendorStockPoints as $point) {
            $point->LastUpdatedDate = DB::table($StockTableName)
                ->where('StockPointID', $point->StockPointID)
                ->max('Date');
        }
		return response()->json(['status' => true, 'data' => $VendorStockPoints ]);
	}

    public function getVendorStockProducts(Request $req){
        $pageNo = $req->PageNo ?? 1;
        $perPage = 15;

        $VendorID = $this->ReferID;
        $StockTableName = Helper::getStockTable($VendorID);
        $LastUpdatedDate = DB::table($StockTableName)->where('StockPointID', $req->StockPointID)->max('Date');

        $query = DB::table('tbl_vendors_product_mapping as VPM')
            ->leftJoin('tbl_vendors_stock_point as VSP','VSP.VendorID', 'VPM.VendorID')
            ->leftJoin($StockTableName . ' as SP', function ($join) use ($LastUpdatedDate) {
                $join->on('SP.StockPointID', '=', 'VSP.StockPointID')
                ->on('SP.ProductID', '=', 'VPM.ProductID');
                if ($LastUpdatedDate) {
                    $join->where('SP.Date', '=', $LastUpdatedDate);
                }
            })
            ->leftJoin('tbl_products as P', 'P.ProductID', '=', 'VPM.ProductID')
            ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
            ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
            ->leftJoin('tbl_uom as U', 'U.UID', '=', 'P.UID')
            ->where('VSP.StockPointID', $req->StockPointID)
            ->where('VSP.DFlag', 0)
            ->where('VPM.Status', 1)
            ->where('VPM.VendorID', $VendorID);
        if ($req->SearchText) {
            $query->where('P.ProductName', 'like', '%' . $req->SearchText . '%');
        }
        $query->select('VSP.StockPointID', 'P.ProductID', 'P.ProductName', 'PC.PCName', 'PC.PCID', 'PSC.PSCID', 'PSC.PSCName', 'U.UName', 'U.UCode', 'P.VideoUrl', DB::raw('IFNULL(SP.Qty, 0) AS Qty'));
        
        if ($req->SortType) {
            if ($req->SortType == 'NameAsc') {
                $query->orderBy('P.ProductName', 'asc');
            } elseif ($req->SortType == 'NameDesc') {
                $query->orderBy('P.ProductName', 'desc');
            } elseif ($req->SortType == 'QtyAsc') {
                $query->orderBy('SP.Qty', 'asc');
            } elseif ($req->SortType == 'QtyDesc') {
                $query->orderBy('SP.Qty', 'desc');
            }
        }
        $VendorStockProducts = $query->paginate($perPage, ['*'], 'page', $pageNo);
    
        return response()->json([
            'status' => true,
            'data' => $VendorStockProducts->items(),
            'CurrentPage' => $VendorStockProducts->currentPage(),
            'LastPage' => $VendorStockProducts->lastPage(),
        ]);
	}

    public function getVendorStockData1(Request $req){
        $VendorID = $this->ReferID;
        $StockTableName = Helper::getStockTable($VendorID);
        $VendorStockPoints= DB::table('tbl_vendors_stock_point')->where('DFlag',0)->where('VendorID',$VendorID)->select('StockPointID','PointName')->get();
        foreach ($VendorStockPoints as $point) {
            $point->LastUpdatedDate = DB::table($StockTableName)
                ->where('StockPointID', $point->StockPointID)
                ->max('Date');
        
            $point->ProductData = DB::table('tbl_vendors_product_mapping as VPM')
                ->join('tbl_products as P', 'P.ProductID', 'VPM.ProductID')
                ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
                ->join('tbl_uom as U', 'U.UID', 'P.UID')
                ->leftJoin($StockTableName . ' as SP', function ($join) use ($point) {
                    $join->on('SP.ProductID', 'P.ProductID')
                        ->where('SP.StockPointID', $point->StockPointID)
                        ->where('SP.Date', $point->LastUpdatedDate);
                })
                ->where('VPM.VendorID', $VendorID)
                ->where('VPM.Status', 1)
                ->select('P.ProductID', 'P.ProductName', 'PC.PCName', 'PC.PCID', 'PSC.PSCID', 'PSC.PSCName', 'U.UName', 'U.UCode')
                ->addSelect(DB::raw('IFNULL(SP.Qty, 0) AS Qty'))
                ->get();
        }
        
		return response()->json(['status' => true, 'data' => $VendorStockPoints ]);
	}

    public function UpdateStockData(Request $req){
        $VendorID = $this->ReferID;
		$OldData=$NewData=[];
        DB::beginTransaction();
        try {
            $StockDB= Helper::getStockDB();
            $StockTableName= Helper::getStockTable($VendorID);
            $OldData=DB::table($StockTableName)->where('VendorID',$VendorID)->where('Date',date("Y-m-d"))->get();

            $ProductData = json_decode($req->ProductData);
            $LastUpdatedDate = DB::table($StockTableName)->where('StockPointID', $req->StockPointID)->max('Date');
            
            $query= DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_vendors_stock_point as VSP','VSP.VendorID', 'VPM.VendorID')
                ->leftJoin($StockTableName . ' as SP', function ($join) use ($LastUpdatedDate) {
                    $join->on('SP.StockPointID', '=', 'VSP.StockPointID')
                    ->on('SP.ProductID', '=', 'VPM.ProductID');
                    if ($LastUpdatedDate) {
                        $join->where('SP.Date', '=', $LastUpdatedDate);
                    }
                })
            ->where('VSP.StockPointID', $req->StockPointID)
            ->where('VPM.Status', 1)
            ->where('VPM.VendorID', $VendorID);
            $MappedProducts = $query->select('VPM.ProductID',DB::raw('IFNULL(SP.Qty, 0) AS Qty'))->get();
            // return $MappedProducts;
            $productDataMap = [];
            foreach ($ProductData as $Uproduct) {
                $productDataMap[$Uproduct->ProductID] = $Uproduct->Qty;
            }
            foreach ($MappedProducts as $Mproduct) {
                $finalQty = isset($productDataMap[$Mproduct->ProductID]) ? $productDataMap[$Mproduct->ProductID] : $Mproduct->Qty;

                $t = DB::Table($StockTableName)->where('VendorID', $VendorID)->Where('ProductID', $Mproduct->ProductID)->Where('StockPointID', $req->StockPointID)->where('Date', date("Y-m-d"))->first();
                if (!$t) {
                    $detailID = DocNum::getDocNum($VendorID, $StockDB, Helper::getCurrentFY());
                    $tdata = [
                        "DetailID" => $detailID,
                        "Date" => date("Y-m-d"),
                        "VendorID" => $VendorID,
                        "StockPointID" => $req->StockPointID,
                        "ProductID" => $Mproduct->ProductID,
                        "Qty" => $finalQty,
                        "CreatedBy" => $VendorID,
                    ];
                    $status = DB::Table($StockTableName)->insert($tdata);
                    if ($status) {
                        DocNum::updateDocNum($VendorID, $StockDB);
                    }
                } else {
                    DB::Table($StockTableName)->where('VendorID', $VendorID)->Where('StockPointID', $req->StockPointID)->Where('ProductID', $Mproduct->ProductID)->where('Date', date("Y-m-d"))->update(['Qty' => $finalQty]);
                }
            }
            $status=true;
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            // DB::commit();
            $NewData=DB::table($StockTableName)->where('VendorID',$VendorID)->where('Date',date("Y-m-d"))->get();
            $logData=array("Description"=>"Vendor Stock Updated","ModuleName"=>"Vendor Stock Update","Action"=>"Update","ReferID"=>$VendorID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$VendorID,"IP"=>$req->ip());
            logs::Store($logData);
            return response()->json(['status' => true ,'message' => "Vendor Stock Updated Successfully!"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Vendor Stock Update Failed!"]);
        }
	}

    // Vendor Home

    public function getVendorHome(Request $req){
        $VendorID = $this->ReferID;
        $VendorHome = [];
        $StockTableName = Helper::getStockTable($VendorID);
        $VendorStockPoints= DB::table('tbl_vendors_stock_point')->where('DFlag',0)->where('VendorID',$VendorID)->select('StockPointID','PointName')->take(3)->get();
        foreach ($VendorStockPoints as $point) {
            $point->LastUpdatedDate = DB::table($StockTableName)
                ->where('StockPointID', $point->StockPointID)
                ->max('Date');
        
            $point->ProductData = DB::table('tbl_vendors_product_mapping as VPM')
                ->join('tbl_products as P', 'P.ProductID', 'VPM.ProductID')
                ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
                ->join('tbl_uom as U', 'U.UID', 'P.UID')
                ->leftJoin($StockTableName . ' as SP', function ($join) use ($point) {
                    $join->on('SP.ProductID', 'P.ProductID')
                        ->where('SP.StockPointID', $point->StockPointID)
                        ->where('SP.Date', $point->LastUpdatedDate);
                })
                ->where('VPM.VendorID', $VendorID)
                ->where('VPM.Status', 1)
                ->select('P.ProductID', 'P.ProductName', 'PC.PCName', 'PC.PCID', 'PSC.PSCID', 'PSC.PSCName', 'U.UName', 'U.UCode')
                ->addSelect(DB::raw('IFNULL(SP.Qty, 0) AS Qty'))->take(1)
                ->get();
        }
        $VendorHome['CurrentOrders'] = DB::table($this->currfyDB.'tbl_vendor_orders as VO')->leftJoin($this->currfyDB.'tbl_order as O','O.OrderID','VO.OrderID')
        ->where('VO.VendorID',$VendorID)->whereIn('VO.Status',['New','Partially Delivered'])
        ->select('VO.VOrderID','O.OrderID','O.OrderNo','O.OrderDate','O.ExpectedDelivery','O.ReceiverName','O.ReceiverMobNo','VO.TotalAmount','VO.SubTotal','VO.TaxAmount','VO.NetAmount','VO.AdditionalCost','VO.Status')
        ->orderBy('VO.CreatedOn','desc')
        ->take(3)->get();
        foreach($VendorHome['CurrentOrders'] as $row){
            $row->TotalUnit = DB::table($this->currfyDB.'tbl_order_details')->whereNot('Status','Cancelled')->where('OrderID',$row->OrderID)->sum('Qty');
            $row->ProductData = DB::table($this->currfyDB.'tbl_order_details as OD')
            ->leftJoin('tbl_products as P','P.ProductID','OD.ProductID')
            ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
            ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
            ->leftJoin('tbl_uom as U', 'U.UID', 'P.UID')
            ->where('P.ActiveStatus', 'Active')->where('P.DFlag', 0)
            ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
            ->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
            ->where('OD.OrderID',$row->OrderID)
            ->whereNot('Status','Cancelled')
            ->select('OD.DetailID','OD.Taxable','OD.TaxAmt','OD.TotalAmt','P.ProductName','P.ProductID','OD.Qty', 'PC.PCName', 'PC.PCID', 'PSC.PSCName','U.UName','U.UCode','U.UID', 'PSC.PSCID','OD.Price','OD.Status')
            ->get();
        }
        $VendorHome['CompletedOrders'] = DB::table($this->currfyDB.'tbl_vendor_orders as VO')->leftJoin($this->currfyDB.'tbl_order as O','O.OrderID','VO.OrderID')
        ->where('VO.VendorID',$VendorID)->where('VO.Status','Delivered')
        ->orderBy('VO.CreatedOn','desc')
        ->select('VO.VOrderID','O.OrderID','O.OrderNo','O.OrderDate','O.ExpectedDelivery','O.ReceiverName','O.ReceiverMobNo','VO.TotalAmount','VO.SubTotal','VO.TaxAmount','VO.NetAmount','VO.AdditionalCost','VO.Status')
        ->take(3)->get();
        foreach($VendorHome['CompletedOrders'] as $row){
            $row->TotalUnit = DB::table($this->currfyDB.'tbl_order_details')->whereNot('Status','Cancelled')->where('OrderID',$row->OrderID)->sum('Qty');
            $row->ProductData = DB::table($this->currfyDB.'tbl_order_details as OD')
            ->leftJoin('tbl_products as P','P.ProductID','OD.ProductID')
            ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
            ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
            ->leftJoin('tbl_uom as U', 'U.UID', 'P.UID')
            ->where('P.ActiveStatus', 'Active')->where('P.DFlag', 0)
            ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
            ->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
            ->where('OD.OrderID',$row->OrderID)
            ->whereNot('Status','Cancelled')
            ->select('OD.DetailID','OD.Taxable','OD.TaxAmt','OD.TotalAmt','P.ProductName','P.ProductID','OD.Qty', 'PC.PCName', 'PC.PCID', 'PSC.PSCName','U.UName','U.UCode','U.UID', 'PSC.PSCID','OD.Price','OD.Status')
            ->get();
        }
        $VendorHome['VendorStockData'] = $VendorStockPoints;
        $VendorHome['VendorStockPoints'] = DB::table('tbl_vendors_stock_point as VSP')
        ->leftJoin($this->generalDB.'tbl_countries as C','C.CountryID','VSP.CountryID')
        ->leftJoin($this->generalDB.'tbl_states as S', 'S.StateID', 'VSP.StateID')
        ->leftJoin($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'VSP.DistrictID')
        ->leftJoin($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'VSP.TalukID')
        ->leftJoin($this->generalDB.'tbl_cities as CI', 'CI.CityID', 'VSP.CityID')
        ->leftJoin($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'VSP.PostalID')
        ->where('VSP.DFlag',0)->where('VSP.VendorID',$VendorID)
        ->select('VSP.StockPointID','PointName','C.CountryName','S.StateName','D.DistrictName','T.TalukName','CI.CityName','PC.PostalCode')
        ->get();
        
		return response()->json(['status' => true, 'data' => $VendorHome ]);
	}

    public function getNotifications(Request $req){

        $pageNo = $req->PageNo ?? 1;
        $perPage = 10;

        $Notifications = DB::table($this->currfyDB.'tbl_notifications')
            ->where('UserID', $this->UserID)
            ->orderBy('CreatedOn','desc')
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

    public function getVendorProductSearch(Request $req){
        $VendorID = $this->ReferID;

        $Products = DB::table('tbl_products as P')
        ->leftJoin('tbl_product_subcategory as PSC', 'P.SCID', 'PSC.PSCID')
        ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
        ->leftJoin('tbl_tax as T', 'T.TaxID', 'P.TaxID')
        ->rightJoin('tbl_vendors_product_mapping as VPM', 'P.ProductID', 'VPM.ProductID')
        ->where('VPM.Status', 1)
        ->where('VPM.VendorID', $VendorID)
        ->where('P.ProductName', 'like', '%' . $req->SearchText . '%')
        // ->groupBy('P.ProductID', 'P.ProductName', 'PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName','T.TaxPercentage','P.TaxType','VPM.VendorPrice')
        ->select('P.ProductID', 'P.ProductName', 'PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName','T.TaxPercentage','P.TaxType','VPM.VendorPrice')->get();

        return response()->json(['status' => true, 'data' => $Products ]);
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

                $result = Helper::saveEmailOtp($user->EMail,$OTP,"Vendor",$user->Name);

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
                        $status = DB::Table('tbl_vendors')->where('VendorID',$user->ReferID)->update(['Email'=>$req->Email,'UpdatedOn'=>now(),'UpdatedBy'=>$user->ReferID]);
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
    
                $Message = "You are trying to change your mobile number in the RPC vendor app. Please enter $OTP code to verify your request. Do not share this OTP with anyone for security reasons.";
                return Helper::saveSmsOtp($user->MobileNumber,$OTP,$Message,"Vendor");
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
                        $status = DB::Table('tbl_vendors')->where('VendorID',$user->ReferID)->update(['MobileNumber1'=>$req->MobileNumber,'UpdatedOn'=>now(),'UpdatedBy'=>$user->ReferID]);
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
        return $query->where('LoginType','Vendor')->whereNot('UserID',Auth::user()->UserID)->exists();
    }
    
}