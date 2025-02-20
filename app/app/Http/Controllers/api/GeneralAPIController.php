<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use Auth;
use Helper;
use general;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
class GeneralAPIController extends Controller{
	private $generalDB;
    private $tmpDB;
    private $FileTypes;


    public function __construct(){
		$this->generalDB=Helper::getGeneralDB();
		$this->tmpDB=Helper::getTmpDB();
		$this->FileTypes=Helper::getFileTypes(array("category"=>array("Images","Documents")));
    }

    public function getGoogleAuthSecret(request $req){
		$return = [
			'status' => true,
			'data' => DB::table('tbl_socialite_providers')->where('ActiveStatus', 'Active')->select('ProviderName','ClientID','ClientSecret')->first(),
		];
        return $return;
	}
    public function getGender(request $req){
		$return = [
			'status' => true,
			'data' => Helper::getGender(),
		];
        return $return;
	}
    public function getCountry(request $req){
		$return = [
			'status' => true,
			'data' => Helper::getCountry(),
		];
        return $return;
	}
    public function getState(request $req){
		$return = [
			'status' => true,
			'data' => Helper::getState(array("CountryID"=>$req->CountryID)),
		];
        return $return;
	}
    public function getDistrict(request $req){
		$return = [
			'status' => true,
			'data' => Helper::getDistrict(array("CountryID"=>$req->CountryID,"StateID"=>$req->StateID)),
		];
        return $return;
	}
    public function getTaluk(request $req){
		$return = [
			'status' => true,
			'data' => Helper::getTaluk(array("CountryID"=>$req->CountryID,"StateID"=>$req->StateID,"DistrictID"=>$req->DistrictID)),
		];
        return $return;
	}
	public function getCity(Request $req){
		$data = Helper::getCity(["CountryID" => $req->CountryID,"StateID" => $req->StateID,"DistrictID" => $req->DistrictID,"TalukID" => $req->TalukID,"PostalID" => $req->PostalID,"PostalCode" => $req->PostalCode,]);
		if (isset($data['error'])) {
			$return = [
				'status' => false,
				'message' => $data['error'],
				'data' => [],
			];
		} else {
			$return = ['status' => true,'data' => $data];
		}
		return $return;
	}
	public function getPostalCode(request $req){
		$return = [
			'status' => true,
			'data' => Helper::getPostalCode(array("CountryID"=>$req->CountryID,"StateID"=>$req->StateID,"DistrictID"=>$req->DistrictID,"TalukID"=>$req->TalukID)),
		];
        return $return;
	}
	public function getVehicleType(request $req){
		$return = [
			'status' => true,
			'data' => Helper::getVehicleType()
		];
        return $return;
	}
	public function getVehicleBrand(request $req){
		$return = [
			'status' => true,
			'data' => Helper::getVehicleBrand(array("VehicleTypeID"=>$req->VehicleTypeID))
		];
        return $return;
	}
	public function getVehicleModel(request $req){
		$return = [
			'status' => true,
			'data' => Helper::getVehicleModel(array("VehicleTypeID"=>$req->VehicleTypeID,"VehicleBrandID"=>$req->VehicleBrandID))
		];
        return $return;
	}


	public function GetCategory(request $req){
		$PCatagories = DB::Table('tbl_product_category')->where('ActiveStatus','Active')->where('DFlag',0)->select('PCName','PCID')->get()->toArray();
		shuffle($PCatagories);

		$return = [
			'status' => true,
			'data' => $PCatagories
		];
        return $return;
	}
	public function GetSubCategory(request $req){
		$PCID = $req->PCID;
		$PCIDArray = json_decode($PCID, true);
		$PCIDArray = is_array($PCIDArray) ? $PCIDArray : [$PCID];
		$return = [
			'status' => true,
			'data' => DB::table('tbl_product_subcategory')->where('ActiveStatus', 'Active')->where('DFlag', 0)->whereIn('PCID', $PCIDArray)->get(),
		];

		return $return;
	}


	public function GetProducts(request $req){
		$return = [
			'status' => true,
			'data' => DB::Table('tbl_products')->where('ActiveStatus','Active')->where('DFlag',0)->where('CID',$req->PCID)->where('SCID',$req->PSCID)->get(),
		];
        return $return;
	}
	public function getVendorType(request $req){
		$return = [
			'status' => true,
			'data' => DB::Table('tbl_vendor_type')->where('ActiveStatus','Active')->where('DFlag',0)->get(),
		];
        return $return;
	}

	public function tmpFileUpload(Request $req){

		//remove yesterday folder
		$dir="uploads/tmp/".date("Ymd",strtotime("-1 days"))."/";
		if (file_exists( $dir)) {
			$files = glob($dir."*"); // get all file names
			foreach($files as $file){ // iterate files
				if(is_file($file)) {
					unlink($file); // delete file
				}
			}
			rmdir($dir);
		}
		$dir="uploads/tmp/".date("Ymd")."/";
		if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}

		$allowedImageExtensions = ['jpg', 'jpeg', 'png'];
		$allowedDocExtensions = ['pdf', 'doc', 'docx', 'txt','jpg', 'jpeg'];
		$maxFileSize = 10 * 1024 * 1024; // 10 MB

		if ($req->hasFile('image')) {
			$file = $req->file('image');
			$ext = strtolower($file->getClientOriginalExtension());
			$size = $file->getSize();

			if (!in_array(strtolower($ext), $allowedImageExtensions)) {
				return array('status' => false, 'message' => 'Image upload failed', 'errors' => 'Invalid image extension. Allowed extensions: ' . implode(', ', $allowedImageExtensions));
			} elseif ($size > $maxFileSize) {
				return array('status' => false, 'message' => 'Image upload failed', 'errors' => 'Image size exceeds the maximum allowed size of ' . ($maxFileSize / 1024 / 1024) . ' MB.');
			} else {
				$rnd=Helper::RandomString(10)."_".date("YmdHis");
				$tname=md5($file->getClientOriginalName() . time());
				$fileName=$tname. "." . $ext;
				$fileName1 =  $tname. "-tmp." . $ext;
				$file->move($dir, $fileName1);
				$Data = array("uploadPath"=>$dir.$fileName1,"fileName"=>$fileName,"ext"=>$ext,"referData"=>$req->referData);
				return response()->json(['status' => true,'data' => $Data]);
			}
		} elseif ($req->image != "") {
			$rnd = Helper::RandomString(10) . "_" . date("YmdHis");
			$originalExtension = strtolower(pathinfo($req->image, PATHINFO_EXTENSION));
			$fileName = $rnd . "." . $originalExtension;
			$fileName1 = $rnd . "-tmp." . $originalExtension;
			$imgData = $this->getImageData($req->image);
			file_put_contents($dir . $fileName1, $imgData);
			$Data = array("uploadPath" => $dir . $fileName1, "fileName" => $fileName, "ext" => $originalExtension, "referData" => $req->referData);
			return response()->json(['status' => true,'data' => $Data]);
		}

		if ($req->hasFile('doc')) {
			$file = $req->file('doc');
			$ext = strtolower($file->getClientOriginalExtension());
			$size = $file->getSize();

			if (!in_array(strtolower($ext), $allowedDocExtensions)) {
				return array('status' => false, 'message' => 'Document upload failed', 'errors' => 'Invalid document extension. Allowed extensions: ' . implode(', ', $allowedDocExtensions));
			} elseif ($size > $maxFileSize) {
				return array('status' => false, 'message' => 'Document upload failed', 'errors' => 'Document size exceeds the maximum allowed size of ' . ($maxFileSize / 1024 / 1024) . ' MB.');
			} else {
				$rnd = Helper::RandomString(10) . "_" . date("YmdHis");
				$tname = md5($file->getClientOriginalName() . time());
				$fileName = $tname . "." . $file->getClientOriginalExtension();
				$fileName1 = $tname . "-tmp." . $file->getClientOriginalExtension();
				$file->move($dir, $fileName1);
				$Data = array("uploadPath" => $dir . $fileName1,"fileName" => $fileName,"ext" => $ext,"referData" => $req->referData);
				return response()->json(['status' => true,'data' => $Data]);
			}
		} elseif ($req->doc != "") {
			$rnd = Helper::RandomString(10) . "_" . date("YmdHis");
			$originalExtension = strtolower(pathinfo($req->doc, PATHINFO_EXTENSION));
			$fileName = $rnd . "." . $originalExtension;
			$fileName1 = $rnd . "-tmp." . $originalExtension;
			file_put_contents($dir . $fileName1, $req->doc);

			$Data = array("uploadPath" => $dir . $fileName1, "fileName" => $fileName, "ext" => $originalExtension, "referData" => $req->referData);
			return response()->json(['status' => true,'data' => $Data]);
		}
		return response()->json(['status' => false,'data' => []]);
	}
	private function getImageData($base64){
		$base64_str = substr($base64, strpos($base64, ",")+1);
		$image = base64_decode($base64_str);
		return $image;
	}

	public function getStages(Request $req){
        $Stages = DB::Table($this->generalDB.'tbl_stages')->where('ActiveStatus','Active')->where('DFlag',0)
		->select('StageID','StageName','Description')->get();
        return response()->json(['status' => true,'data' => $Stages]);
    }

	public function getBuildingMeasurements(Request $req){
        $Measurements = DB::Table($this->generalDB.'tbl_building_measurements')->where('ActiveStatus','Active')->where('DFlag',0)
		->select('MeasurementID','MeasurementName','Description')->get();
        return response()->json(['status' => true,'data' => $Measurements]);
    }


    public function getRejectReasonType(request $req){
		$return = [
			'status' => true,
			'data' => DB::Table('tbl_reject_reason_type')->where('ActiveStatus','Active')->where('DFlag',0)->select('RRTypeID', 'RRType')->get(),
		];
        return $return;
	}
    public function getRejectReason(request $req){
        $query = DB::table('tbl_reject_reason as RR')->leftJoin('tbl_reject_reason_type as RRT', 'RRT.RRTypeID', 'RR.RRTypeID')->where('RR.ActiveStatus', 'Active')->where('RR.DFlag', 0)->where('RR.isOther', 0);

		if ($req->RRTypeID) {
			$query->where('RR.RRTypeID', $req->RRTypeID);
		}

		$unionQuery = DB::table('tbl_reject_reason')
			->where('isOther', 1)
			->select('RRTypeID', 'RReasonID', 'RReason');

		$query->union($unionQuery);

		$RReason = $query->select('RRT.RRType', 'RR.RReasonID', 'RR.RReason')->get();

		$return = [
			'status' => true,
			'data' =>$RReason,
		];
        return $return;
	}

	public function getSupportType(request $req){
		$return = [
			'status' => true,
			'data' => DB::Table('tbl_support_type')->where('ActiveStatus',1)->where('DFlag',0)->select('SLNO as SupportTypeID', 'SupportType')->get(),
		];
        return $return;
	}

	public function getCMS(request $req){
		$query = DB::Table('tbl_page_content');
		if ($req->has('PageName') && !empty($req->PageName)) {
			$query->where('PageName',$req->PageName);
		}
		$CMS = $query->select('PageName', 'PageContent')->where('DFlag',0)->where('ActiveStatus',1)->get();
		$return = [
			'status' => true,
			'data' => $CMS,
		];
        return $return;
	}

	public function getBannerImages(request $req){
		$BannerImages = DB::Table('tbl_banner_images')->where('BannerType','Mobile')->where('DFlag',0)->select('BannerType', DB::raw('CONCAT("' . url('/') . '/", BannerImage) AS BannerImage'))->get();
		$return = [
			'status' => true,
			'data' => $BannerImages,
		];
        return $return;
	}
	public function getStepperImages(request $req){
		$query = DB::Table('tbl_stepper_images')
		->where('StepperType',$req->StepperType)
		->where('DFlag',0);
		$StepperImages = $query->select('StepperType','Description','StepperTitle', DB::raw('CONCAT("' . url('/') . '/", StepperImage) AS StepperImage'))
		->get();
		$return = [
			'status' => true,
			'data' => $StepperImages,
		];
        return $return;
	}
	public function getMaxFileSize(request $req){
		$MaxFileSize = DB::Table('tbl_settings')->where('KeyName','upload-limit')->value('KeyValue');
		$return = [
			'status' => true,
			'data' => $MaxFileSize
		];
        return $return;
	}

	public function getCoordinates(Request $req){ return 1;
		$address = $req->Address;
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'address' => $address,
            'key' => config('app.map_api_key'),
        ]);

        $data = $response->json();
        if ($data['status'] === 'OK') {
            $location = $data['results'][0]['geometry']['location'];

            $latitude = $location['lat'];
            $longitude = $location['lng'];

            return response()->json(['latitude' => $latitude, 'longitude' => $longitude]);
        }
        return response()->json(['error' => 'Could not retrieve coordinates'], 500);
    }

	public function calculateDistance(Request $request){ return 1;
		$client = new Client();

		$lat1 = $request->input('lat1');
		$lon1 = $request->input('lon1');
		$lat2 = $request->input('lat2');
		$lon2 = $request->input('lon2');

		$response = $client->get('https://maps.googleapis.com/maps/api/distancematrix/json', [
			'query' => [
				'origins' => "11.04836,76.9888101",
				'destinations' => "11.0546892,76.9947768",
				'key' => config('app.map_api_key'),
				'units' => 'metric',
			]
		]);

		$data = json_decode($response->getBody(), true);
		$distance = $data['rows'][0]['elements'][0]['distance']['value'];
		$distanceInKm = $distance / 1000; // convert to kilometers

		return response()->json(['distance_km' => $distanceInKm]);
	}

    public function getCompanyDetails(){
        return collect(DB::Table('tbl_company_settings')->pluck('KeyValue', 'KeyName'));
    }
}
