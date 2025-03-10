<?php
namespace App\Http\Controllers\web\masters\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DocNum;
use general;
use SSP;
use DB;
use Auth;
use ValidUnique;
use ValidDB;
use logs;
use Helper;
use activeMenuNames;
use docTypes;
use cruds;
use Illuminate\Support\Facades\Hash;

class VendorsController extends Controller{
	private $general;
	private $DocNum;
	private $UserID;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $Settings;
	private $FileTypes;
    private $Menus;
	private $generalDB;
    public function __construct(){
		$this->ActiveMenuName=activeMenuNames::Vendors->value;
		$this->PageTitle="Vendors";
        $this->middleware('auth');
		$this->FileTypes=Helper::getFileTypes(array("category"=>array("Images","Documents")));
		$this->generalDB=Helper::getGeneralDB();
		$this->middleware(function ($request, $next) {
			$this->UserID=auth()->user()->UserID;
			$this->general=new general($this->UserID,$this->ActiveMenuName);
			$this->Menus=$this->general->loadMenu();
			$this->CRUD=$this->general->getCrudOperations($this->ActiveMenuName);
			$this->Settings=$this->general->getSettings();
			return $next($request);
		});
    }
    public function view(Request $req){
        if($this->general->isCrudAllow($this->CRUD,"view")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
            return view('app.master.vendor.vendors.view',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"add")==true){
			return Redirect::to('/admin/master/vendor/vendors/create');
        }else{
            return view('errors.403');
        }
    }
    public function TrashView(Request $req){
        if($this->general->isCrudAllow($this->CRUD,"restore")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
            return view('app.master.vendor.vendors.trash',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/admin/master/vendor/vendors/');
        }else{
            return view('errors.403');
        }
    }
    public function create(Request $req){
        if($this->general->isCrudAllow($this->CRUD,"add")==true){
            $OtherCruds=array(
				"Country"=>$this->general->getCrudOperations(activeMenuNames::Country->value),
				"States"=>$this->general->getCrudOperations(activeMenuNames::States->value),
				"Districts"=>$this->general->getCrudOperations(activeMenuNames::Districts->value),
				"Taluks"=>$this->general->getCrudOperations(activeMenuNames::Taluks->value),
				"PostalCodes"=>$this->general->getCrudOperations(activeMenuNames::PostalCodes->value),
				"City"=>$this->general->getCrudOperations(activeMenuNames::City->value),
				"Category"=>$this->general->getCrudOperations(activeMenuNames::VendorCategory->value),
			);
            $FormData=$this->general->UserInfo;
			$FormData['OtherCruds']=$OtherCruds;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=false;
			$FormData['FileTypes']=$this->FileTypes;
            return view('app.master.vendor.vendors.create',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/master/vendor/vendors/');
        }else{
            return view('errors.403');
        }
    }
    public function edit(Request $req,$VendorID){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $OtherCruds=array(
				"Country"=>$this->general->getCrudOperations(activeMenuNames::Country->value),
				"States"=>$this->general->getCrudOperations(activeMenuNames::States->value),
				"Districts"=>$this->general->getCrudOperations(activeMenuNames::Districts->value),
				"Taluks"=>$this->general->getCrudOperations(activeMenuNames::Taluks->value),
				"PostalCodes"=>$this->general->getCrudOperations(activeMenuNames::PostalCodes->value),
				"City"=>$this->general->getCrudOperations(activeMenuNames::City->value),
				"Category"=>$this->general->getCrudOperations(activeMenuNames::VendorCategory->value),
			);
            $FormData=$this->general->UserInfo;
			$FormData['OtherCruds']=$OtherCruds;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=true;
			$FormData['FileTypes']=$this->FileTypes;
			$FormData['VendorID']=$VendorID;
			$FormData['data']=$this->getVendor($VendorID);
			if(count($FormData['data'])>0){
				$FormData['data']=$FormData['data'][0];
				return view('app.master.vendor.vendors.create',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/master/vendor/vendors/');
        }else{
            return view('errors.403');
        }
    }
	public function getVendor($VendorID){
		$generalDB=Helper::getGeneralDB();
		$sql =" SELECT V.VendorID, V.VendorName,V.VendorCoName, V.Reference, V.GSTNo, V.CID, VC.VCName, V.VendorType as VendorTypeID, VT.VendorType, V.Email, V.MobileNumber1, V.MobileNumber2, V.Address, V.PostalCode as PostalCodeID, V.ServiceBy, ";
		$sql.=" P.PostalCode, V.CityID, CI.CityName, V.TalukID, T.TalukName, V.DistrictID, D.DistrictName, V.StateID, S.StateName, V.CountryID, C.CountryName, V.CreditLimit, V.CommissionPercentage, V.CreditDays,  V.Logo, V.ActiveStatus, V.DFlag FROM tbl_vendors as V ";
		$sql.=" LEFT JOIN tbl_vendor_category as VC ON VC.VCID=V.CID LEFT JOIN tbl_vendor_type as VT ON VT.VendorTypeID=V.VendorType LEFT JOIN ".$generalDB."tbl_postalcodes as P ON P.PID=V.PostalCode ";
		$sql.=" LEFT JOIN ".$generalDB."tbl_cities as CI ON CI.CityID=V.CityID LEFT JOIN ".$generalDB."tbl_taluks as T ON T.TalukID=V.TalukID LEFT JOIN ".$generalDB."tbl_districts as D ON D.DistrictID=V.DistrictID ";
		$sql.=" LEFT JOIN ".$generalDB."tbl_states as S ON S.StateID=V.StateID  LEFT JOIN ".$generalDB."tbl_countries as C ON C.CountryID=V.CountryID Where V.DFlag=0 and V.VendorID='".$VendorID."'";
		$result=DB::SELECT($sql);
		for($i=0;$i<count($result);$i++){
			//Documents
			$Documents=DB::Table('tbl_vendors_document as VD')->leftJoin('tbl_vendor_required_documents as VRD','VRD.DocName','VD.DocName')->where('VD.VendorID',$result[$i]->VendorID)->select('documents','DisplayName','VD.DocName')->get();
			for($k=0;$k<count($Documents);$k++){
				$Documents[$k]->ext= pathinfo($Documents[$k]->documents,PATHINFO_EXTENSION);
				$Documents[$k]->fileName= basename($Documents[$k]->documents);
				$Documents[$k]->documents=url('/') . '/' . Helper::checkProductImageExists($Documents[$k]->documents);
				$Documents[$k]->DefaultImage=url('/') . '/assets/images/default_document.jpg' ;
			}
			//Vehicles
			$sql ="SELECT VV.VehicleID, VV.VendorID, VV.UUID, VV.VNumber, VV.VType as VTypeID, VT.VehicleType, VV.VBrand as VBrandID, VB.VehicleBrandName, VV.VModel as VModelID, VM.VehicleModel,";
			$sql.=" VV.VLength, VV.VDepth, VV.VWidth, VV.VCapacity, VV.DFlag FROM tbl_vendors_vehicle as VV LEFT JOIN ".$generalDB."tbl_vehicle_type as VT ON VT.VehicleTypeID=VV.VType ";
			$sql.=" LEFT JOIN ".$generalDB."tbl_vehicle_brand as VB ON VB.VehicleBrandID=VV.VBrand LEFT JOIN ".$generalDB."tbl_vehicle_model  as VM ON VM.VehicleModelID=VV.VModel ";
			$sql.=" Where VV.DFlag=0 and VV.VendorID='".$result[$i]->VendorID."'";
			$Vehicles=DB::Select($sql);
			for($j=0;$j<count($Vehicles);$j++){
				//Vehicle Images
				$VehicleImages=DB::Table('tbl_vendors_vehicle_images')->where('VendorID',$result[$i]->VendorID)->where('VehicleID',$Vehicles[$j]->VehicleID)->get();
				for($k=0;$k<count($VehicleImages);$k++){
					$VehicleImages[$k]->ext= pathinfo($VehicleImages[$k]->gImage,PATHINFO_EXTENSION);
					$VehicleImages[$k]->fileName= basename($VehicleImages[$k]->gImage);
					$VehicleImages[$k]->gImage=Helper::checkProductImageExists($VehicleImages[$k]->gImage);
				}
				$Vehicles[$j]->Images=$VehicleImages;
			}
			//Supply details
			$sql="SELECT VS.DetailID, VS.VendorID, VS.PCID, PC.PCName, VS.PSCID, PSC.PSCName, VS.DFlag FROM tbl_vendors_supply as VS LEFT JOIN tbl_product_category as PC ON PC.PCID=VS.PCID ";
			$sql.=" LEFT JOIN tbl_product_subcategory as PSC ON PSC.PSCID=VS.PSCID Where VS.DFlag = 0 and VS.VendorID='".$result[$i]->VendorID."'";
			$SupplyDetails=DB::SELECT($sql);

			//Stock points
			$sql="SELECT H.StockPointID, H.VendorID, IFNULL(H.UUID,'') as UUID, H.ServiceBy , H.PointName, H.Address, H.PostalID, P.PostalCode, H.CityID, CI.CityName, H.TalukID, T.TalukName, H.DistrictID, D.DistrictName, H.StateID, ";
			$sql.=" S.StateName, H.CountryID, C.CountryName FROM tbl_vendors_stock_point as H LEFT JOIN ".$generalDB."tbl_postalcodes as P ON P.PID=H.PostalID ";
			$sql.=" LEFT JOIN ".$generalDB."tbl_cities as CI ON CI.CityID=H.CityID LEFT JOIN ".$generalDB."tbl_taluks as T ON T.TalukID=H.TalukID LEFT JOIN ".$generalDB."tbl_districts as D ON D.DistrictID=H.DistrictID ";
			$sql.=" LEFT JOIN ".$generalDB."tbl_states as S ON S.StateID=H.StateID LEFT JOIN ".$generalDB."tbl_countries as C ON C.CountryID=H.CountryID Where H.VendorID='".$result[$i]->VendorID."' ";
			$StockPoints=DB::SELECT($sql);
			
			//Service locations
			// $ServiceLocations=DB::table('tbl_vendors_service_locations as VSL')->join($generalDB.'tbl_districts as D','D.DistrictID','VSL.DistrictID')->where('VSL.DFlag',0)->where('VSL.VendorID',$result[$i]->VendorID)->get();
			$ServiceLocations = DB::table('tbl_vendors_service_locations as VSL')->join($generalDB.'tbl_states as S', 'S.StateID','VSL.StateID')->join($generalDB.'tbl_countries as C','C.CountryID','S.CountryID')->where('ServiceBy',$result[0]->ServiceBy)->where('VSL.DFlag', 0)->where('VSL.VendorID', $result[$i]->VendorID)->groupBy('VSL.StateID','S.StateName','C.CountryID')->select('VSL.StateID','S.StateName','C.CountryID')->get();
			foreach ($ServiceLocations as $item) {
				$item->Districts = DB::table('tbl_vendors_service_locations as VSL')->join($generalDB.'tbl_districts as D','D.DistrictID','VSL.DistrictID')->where('VSL.DFlag', 0)->where('VSL.StateID', $item->StateID)->where('ServiceBy',$result[0]->ServiceBy)->where('VSL.VendorID', $result[$i]->VendorID)->groupBy('VSL.DistrictID','D.DistrictName')->select('VSL.DistrictID','D.DistrictName')->get();
				foreach ($item->Districts as $row){
					$row->PostalCodeIDs = DB::table('tbl_vendors_service_locations')->where('DFlag',0)->where('StateID',$item->StateID)->where('DistrictID',$row->DistrictID)->where('VendorID',$result[$i]->VendorID)->where('ServiceBy',$result[0]->ServiceBy)->pluck('PostalCodeID')->toArray();
				}
			}
			$result[$i]->StockPoints=$StockPoints;
			$result[$i]->SupplyDetails=$SupplyDetails;
			$result[$i]->Vehicles=$Vehicles;
			$result[$i]->Documents=$Documents;
			$result[$i]->ServiceLocations=[
				'ServiceBy' => $result[0]->ServiceBy,
				'ServiceData' => $ServiceLocations,
			];
		}
		return $result;
	}
	public function getVendorDetails(Request $req){
		return $this->getVendor($req->VendorID);
	}
	public function getVendors(Request $req){
		$result = DB::table('tbl_vendors')->where('DFlag',0)->where('isApproved',1)->where('ActiveStatus','Active')->get();
		foreach($result as $row){
			$row->PCIDs=DB::table('tbl_vendors_supply')->where('VendorID',$row->VendorID)->groupBy('PCID')->pluck('PCID')->toArray();
			$row->PSCIDs=DB::table('tbl_vendors_supply')->where('VendorID',$row->VendorID)->pluck('PSCID')->toArray();
		}
		return $result;
	}
    public function save(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"add")==true){
			$OldData=array();$NewData=array();$VendorID="";
			$ValidDB=array();
			
			$ValidDB['Country']['TABLE']=$this->generalDB."tbl_countries";
			$ValidDB['Country']['ErrMsg']="Country name does not exist";
			$ValidDB['Country']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->CountryID);
			$ValidDB['Country']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>"Active");
			$ValidDB['Country']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

			$ValidDB['State']['TABLE']=$this->generalDB."tbl_states";
			$ValidDB['State']['ErrMsg']="State name does not exist";
			$ValidDB['State']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->CountryID);
			$ValidDB['State']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$req->StateID);
			$ValidDB['State']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>"Active");
			$ValidDB['State']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

			$ValidDB['District']['TABLE']=$this->generalDB."tbl_districts";
			$ValidDB['District']['ErrMsg']="District name does not exist";
			$ValidDB['District']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->CountryID);
			$ValidDB['District']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$req->StateID);
			$ValidDB['District']['WHERE'][]=array("COLUMN"=>"DistrictID","CONDITION"=>"=","VALUE"=>$req->DistrictID);
			$ValidDB['District']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>"Active");
			$ValidDB['District']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

			$ValidDB['Taluk']['TABLE']=$this->generalDB."tbl_taluks";
			$ValidDB['Taluk']['ErrMsg']="Taluk name does not exist";
			$ValidDB['Taluk']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->CountryID);
			$ValidDB['Taluk']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$req->StateID);
			$ValidDB['Taluk']['WHERE'][]=array("COLUMN"=>"DistrictID","CONDITION"=>"=","VALUE"=>$req->DistrictID);
			$ValidDB['Taluk']['WHERE'][]=array("COLUMN"=>"TalukID","CONDITION"=>"=","VALUE"=>$req->TalukID);
			$ValidDB['Taluk']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>"Active");
			$ValidDB['Taluk']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

			$ValidDB['PostalCode']['TABLE']=$this->generalDB."tbl_postalcodes";
			$ValidDB['PostalCode']['ErrMsg']="Postal Code does not exist";
			$ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->CountryID);
			$ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$req->StateID);
			$ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"DistrictID","CONDITION"=>"=","VALUE"=>$req->DistrictID);
			$ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"PID","CONDITION"=>"=","VALUE"=>$req->PostalCodeID);
			$ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>"Active");
			$ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

			$ValidDB['City']['TABLE']=$this->generalDB."tbl_cities";
			$ValidDB['City']['ErrMsg']="City Name does not exist";
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->CountryID);
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$req->StateID);
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"DistrictID","CONDITION"=>"=","VALUE"=>$req->DistrictID);
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"TalukID","CONDITION"=>"=","VALUE"=>$req->TalukID);
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"PostalID","CONDITION"=>"=","VALUE"=>$req->PostalCodeID);
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"CityID","CONDITION"=>"=","VALUE"=>$req->CityID);
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>"Active");
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

			$rules=array(
				'VendorName' =>['required','max:50',new ValidUnique(array("TABLE"=>"tbl_vendors","WHERE"=>" VendorName='".$req->VendorName."'  "),"This Vendor Name is already taken.")],
				// 'GSTNo' =>'required',
				'CID' =>'required',
				'VendorType' =>'required',
				'MobileNumber1' =>'required',
				'CountryID' =>['required',$ValidDB['Country']],
				'StateID' =>['required',$ValidDB['State']],
				'DistrictID' =>['required',$ValidDB['District']],
				'TalukID' =>['required',$ValidDB['Taluk']],
				'PostalCode' =>['required',$ValidDB['PostalCode']],
				'CityID' =>['required',$ValidDB['City']],
			);
			$message=array(
				'Logo.mimes'=>"The Logo field must be a file of type: ".implode(", ",$this->FileTypes['category']['Images'])."."
			);
			if($req->Email!=""){
				$rules['Email'] =['required','email:filter',new ValidUnique(array("TABLE"=>"tbl_vendors","WHERE"=>" EMail='".$req->EMail."' "),"This Email is already taken.")];
			}
			if($req->hasFile('Logo')){
				$rules['Logo']='mimes:'.implode(",",$this->FileTypes['category']['Images']);
			}
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Vendor Create Failed",'errors'=>$validator->errors());
			}
			
			DB::beginTransaction();
			$status=false;
			$Logo="";
			$RemoveImg=array();
			$uploadingImgs=array();
			$isDeleteImage=false;
			try {
				$VendorID=DocNum::getDocNum(docTypes::Vendor->value,"",Helper::getCurrentFY());
				$dir="uploads/master/vendor/manage-vendors/".$VendorID."/";
				$vdir="uploads/master/vendor/manage-vendors/".$VendorID."/vehicles/";
				$dDir="uploads/master/vendor/manage-vendors/".$VendorID."/documents/";
				if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
				if (!file_exists( $vdir)) {mkdir( $vdir, 0777, true);}
				if (!file_exists( $dDir)) {mkdir( $dDir, 0777, true);}
				if($req->hasFile('Logo')){
					$file = $req->file('Logo');
					$fileName=md5($file->getClientOriginalName() . time());
					$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
					$file->move($dir, $fileName1);
					$Logo=$dir.$fileName1;
				}else if(Helper::isJSON($req->ProfileImage)==true){
					$Img=json_decode($req->ProfileImage);
					if(file_exists($Img->uploadPath)){
						$fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
						copy($Img->uploadPath,$dir.$fileName1);
						$Logo=$dir.$fileName1;
						unlink($Img->uploadPath);
					}
				}
				$data=array(
					"VendorID"=>$VendorID,
					"VendorName"=>$req->VendorName,
					"VendorCoName"=>$req->VendorCoName,
					"GSTNo"=>$req->GSTNo,
					"CID"=>$req->CID,
					"VendorType"=>$req->VendorType,
					"Email"=>$req->Email,
					"MobileNumber1"=>$req->MobileNumber1,
					"MobileNumber2"=>$req->MobileNumber2,
					"CreditDays"=>$req->CreditDays,
					"CreditLimit"=>$req->CreditLimit,
					"CommissionPercentage"=>$req->CommissionPercentage,
					"Address"=>$req->Address,
					"CountryID"=>$req->CountryID,
					"StateID"=>$req->StateID,
					"DistrictID"=>$req->DistrictID,
					"TalukID"=>$req->TalukID,
					"CityID"=>$req->CityID,
					"PostalCode"=>$req->PostalCode,
					'Logo'=>$Logo,
					"Reference"=>$req->Reference,
					"ActiveStatus"=>$req->ActiveStatus,
					"isApproved"=>1,
					"CreatedBy"=>$this->UserID,
					"CreatedOn"=>date("Y-m-d H:i:s"),
					"ApprovedBy"=>$this->UserID,
					"ApprovedOn"=>date("Y-m-d H:i:s")
				);
				$status=DB::Table('tbl_vendors')->insert($data);
				//Vehicles
				if($status){
					$VehicleData=json_decode($req->VehicleData);
					foreach($VehicleData as $RowIndex=>$data){
						$VehicleID = DocNum::getDocNum(docTypes::VendorVehicle->value,"",Helper::getCurrentFY());
						$tdata=array(
							"VehicleID"=>$VehicleID,
							"VendorID"=>$VendorID,
							"UUID"=>$data->uuid,
							"VNumber"=>$data->VNo,
							"VType"=>$data->VType,
							"VBrand"=>$data->VBrand,
							"VModel"=>$data->VModel,
							"VLength"=>$data->VLength,
							"VDepth"=>$data->VDepth,
							"VWidth"=>$data->VWidth,
							"VCapacity"=>$data->VCapacity,
							"CreatedBy"=>$this->UserID,
							"CreatedOn"=>date("Y-m-d H:i:s")
						);
						$status=DB::Table('tbl_vendors_vehicle')->insert($tdata);
						if($status){
							DocNum::updateDocNum(docTypes::VendorVehicle->value);
							if (isset($data->Images) && !empty((array)$data->Images)) {
								foreach($data->Images as $ImgID=>$vData){
									if($status){
										if($vData->referData->isTemp =="1" && file_exists($vData->uploadPath) ){
											$fileName1=$vData->fileName!=""?$vData->fileName:Helper::RandomString(10)."png";
											copy($vData->uploadPath,$vdir.$fileName1);
											
											$t=array("gImage"=>$vdir.$fileName1,"ImgID"=>$ImgID);
											$VImages=$vdir.$fileName1;
											$RemoveImg[]=$vData->uploadPath;
											$uploadingImgs[]=$vdir.$fileName1;

											$tmpData=array(
												"SLNO"=>DocNum::getDocNum(docTypes::VendorVehicleImages->value,"",Helper::getCurrentFY()),
												"VendorID"=>$VendorID,
												"VehicleID"=>$VehicleID,
												"UUID"=>$data->uuid,
												"ImgID"=>$ImgID,
												"gImage"=>$VImages,
												"CreatedBy"=>$this->UserID,
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
					}
				}
				//supply details
				$SupplyDetails=json_decode($req->SupplyDetails);
				foreach($SupplyDetails as $RowIndex=>$data){
					if($status){
						$DetailID = DocNum::getDocNum(docTypes::VendorSupply->value,"",Helper::getCurrentFY());
						$tdata=array(
							"DetailID"=>$DetailID,
							"VendorID"=>$VendorID,
							"PCID"=>$data->PCID,
							"PSCID"=>$data->PSCID,
							"CreatedBy"=>$this->UserID,
							"CreatedOn"=>date("Y-m-d H:i:s")
						);
						$status=DB::Table('tbl_vendors_supply')->insert($tdata);
						if($status){
							DocNum::updateDocNum(docTypes::VendorSupply->value);
						}
					}
				}
				
				//Documents
				$Documents=json_decode($req->Documents);
				foreach($Documents as $ImgID=>$Document){
					if($status){
						if($Document->referData->isTemp =="1" && file_exists($Document->uploadPath) ){
							$fileName1=$Document->fileName!=""?$Document->fileName:Helper::RandomString(10)."png";
							copy($Document->uploadPath,$dDir.$fileName1);
							$DocUrl=$dDir.$fileName1;
							$RemoveImg[]=$Document->uploadPath;
							$uploadingImgs[]=$DocUrl;
							$tdata=array(
                                "SLNO"=>DocNum::getDocNum(docTypes::VendorDocuments->value,"",Helper::getCurrentFY()),
                                "VendorID"=>$VendorID,
                                "ImgID"=>$ImgID,
                                "documents"=>$DocUrl,
                                "CreatedBy"=>$this->UserID,
                                "CreatedOn"=>date("Y-m-d H:i:s")
							);
							$status=DB::Table('tbl_vendors_document')->insert($tdata);
							if($status){
								DocNum::updateDocNum(docTypes::VendorDocuments->value);
							}
						}
					}
				}
				$UserID=DocNum::getDocNum(docTypes::Users->value,'',Helper::getCurrentFY());

				$VendorName = $req->VendorName;
                $nameParts = explode(' ', $VendorName, 2);
                $firstName = $nameParts[0] ?? '';
                $lastName = $nameParts[1] ?? '';
				$pwd1=Hash::make($req->Email);
				$data=array(
					"UserID"=>$UserID,
					"ReferID"=>$VendorID,
					"Name"=>$req->VendorName,
					"FirstName"=>$firstName,
					"LastName"=>$lastName,
					"UserName"=>$req->Email,
					"MobileNumber"=>$req->MobileNumber1,
					"Password"=>$pwd1,
					"EMail"=>$req->Email,
					"Address"=>$req->Address,
                    "PostalCodeID"=>$req->PostalCode,
                    "CityID"=>$req->CityID,
                    "TalukID"=>$req->TalukID,
                    "DistrictID"=>$req->DistrictID,
                    "StateID"=>$req->StateID,
                    "CountryID"=>$req->CountryID,
					"isLogin"=>1,
					"LoginType"=>"Vendor",
					"CreatedOn"=>date("Y-m-d H:i:s"),
					"CreatedBy"=>$this->UserID
				);
				$status=DB::Table('users')->insert($data);
			}catch(Exception $e) {
				$status=false;
			}
			if($status==true){
				DocNum::updateDocNum(docTypes::Vendor->value);
				DocNum::updateDocNum(docTypes::Users->value);
				$NewData=$this->getVendor($VendorID);
				DB::commit();
				$logData=array("Description"=>"New Vendor Created ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::ADD->value,"ReferID"=>$VendorID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				foreach($RemoveImg as $index=>$Img){
					Helper::removeFile($Img);
				}
				return array('status'=>true,'message'=>"Vendor Created Successfully","VendorID"=>$VendorID);
			}else{
				DB::rollback();
				foreach($uploadingImgs as $index=>$Img){
					Helper::removeFile($Img);
				}
				return array('status'=>false,'message'=>"Vendor Create Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
	public function update(Request $req,$VendorID){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OldData=array();$NewData=array();
			$ValidDB=array();
			
			$ValidDB['Country']['TABLE']=$this->generalDB."tbl_countries";
			$ValidDB['Country']['ErrMsg']="Country name does not exist";
			$ValidDB['Country']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->CountryID);
			$ValidDB['Country']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>"Active");
			$ValidDB['Country']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

			$ValidDB['State']['TABLE']=$this->generalDB."tbl_states";
			$ValidDB['State']['ErrMsg']="State name does not exist";
			$ValidDB['State']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->CountryID);
			$ValidDB['State']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$req->StateID);
			$ValidDB['State']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>"Active");
			$ValidDB['State']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

			$ValidDB['District']['TABLE']=$this->generalDB."tbl_districts";
			$ValidDB['District']['ErrMsg']="District name does not exist";
			$ValidDB['District']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->CountryID);
			$ValidDB['District']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$req->StateID);
			$ValidDB['District']['WHERE'][]=array("COLUMN"=>"DistrictID","CONDITION"=>"=","VALUE"=>$req->DistrictID);
			$ValidDB['District']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>"Active");
			$ValidDB['District']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

			$ValidDB['Taluk']['TABLE']=$this->generalDB."tbl_taluks";
			$ValidDB['Taluk']['ErrMsg']="Taluk name does not exist";
			$ValidDB['Taluk']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->CountryID);
			$ValidDB['Taluk']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$req->StateID);
			$ValidDB['Taluk']['WHERE'][]=array("COLUMN"=>"DistrictID","CONDITION"=>"=","VALUE"=>$req->DistrictID);
			$ValidDB['Taluk']['WHERE'][]=array("COLUMN"=>"TalukID","CONDITION"=>"=","VALUE"=>$req->TalukID);
			$ValidDB['Taluk']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>"Active");
			$ValidDB['Taluk']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

			$ValidDB['PostalCode']['TABLE']=$this->generalDB."tbl_postalcodes";
			$ValidDB['PostalCode']['ErrMsg']="Postal Code does not exist";
			$ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->CountryID);
			$ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$req->StateID);
			$ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"DistrictID","CONDITION"=>"=","VALUE"=>$req->DistrictID);
			$ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"PID","CONDITION"=>"=","VALUE"=>$req->PostalCodeID);
			$ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>"Active");
			$ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

			$ValidDB['City']['TABLE']=$this->generalDB."tbl_cities";
			$ValidDB['City']['ErrMsg']="City Name does not exist";
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->CountryID);
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$req->StateID);
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"DistrictID","CONDITION"=>"=","VALUE"=>$req->DistrictID);
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"TalukID","CONDITION"=>"=","VALUE"=>$req->TalukID);
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"PostalID","CONDITION"=>"=","VALUE"=>$req->PostalCodeID);
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"CityID","CONDITION"=>"=","VALUE"=>$req->CityID);
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>"Active");
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

			$rules=array(
				'VendorName' =>['required','max:50',new ValidUnique(array("TABLE"=>"tbl_vendors","WHERE"=>" VendorName='".$req->VendorName."' and vendorID<>'".$VendorID."'  "),"This Vendor Name is already taken.")],
				// 'GSTNo' =>'required',
				'CID' =>'required',
				'VendorType' =>'required',
				'MobileNumber1' =>'required',
				'CountryID' =>['required',$ValidDB['Country']],
				'StateID' =>['required',$ValidDB['State']],
				'DistrictID' =>['required',$ValidDB['District']],
				'TalukID' =>['required',$ValidDB['Taluk']],
				'PostalCode' =>['required',$ValidDB['PostalCode']],
				'CityID' =>['required',$ValidDB['City']],
			);
			$message=array(
				'Logo.mimes'=>"The Logo field must be a file of type: ".implode(", ",$this->FileTypes['category']['Images'])."."
			);
			if($req->Email!=""){
				$rules['Email'] =['required','email:filter',new ValidUnique(array("TABLE"=>"tbl_vendors","WHERE"=>" EMail='".$req->EMail."' and vendorID<>'".$VendorID."' "),"This Email is already taken.")];
			}
			if($req->hasFile('Logo')){
				$rules['Logo']='mimes:'.implode(",",$this->FileTypes['category']['Images']);
			}
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Vendor Create Failed",'errors'=>$validator->errors());
			}
			
			DB::beginTransaction();
			$status=false;
			$Logo="";
			$RemoveImg=array();
			$uploadingImgs=array();// if save failed than upload images remove
			$isDeleteImage=false;
			$OldData=$this->getVendor($VendorID);
			try {
				$dir="uploads/master/vendor/manage-vendors/".$VendorID."/";
				$vdir="uploads/master/vendor/manage-vendors/".$VendorID."/vehicles/";
				$dDir="uploads/master/vendor/manage-vendors/".$VendorID."/documents/";
				if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
				if (!file_exists( $vdir)) {mkdir( $vdir, 0777, true);}
				if (!file_exists( $dDir)) {mkdir( $dDir, 0777, true);}
				if($req->hasFile('Logo')){
					$file = $req->file('Logo');
					$fileName=md5($file->getClientOriginalName() . time());
					$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
					$file->move($dir, $fileName1);
					$Logo=$dir.$fileName1;
				}else if(Helper::isJSON($req->ProfileImage)==true){
					$Img=json_decode($req->ProfileImage);
					if(file_exists($Img->uploadPath)){
						$fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
						copy($Img->uploadPath,$dir.$fileName1);
						$Logo=$dir.$fileName1;
						unlink($Img->uploadPath);
					}
				}
				$data=array(
					"VendorName"=>$req->VendorName,
					"VendorCoName"=>$req->VendorCoName,
					"GSTNo"=>$req->GSTNo,
					"CID"=>$req->CID,
					"VendorType"=>$req->VendorType,
					"Email"=>$req->Email,
					"MobileNumber1"=>$req->MobileNumber1,
					"MobileNumber2"=>$req->MobileNumber2,
					"CreditDays"=>$req->CreditDays,
					"CreditLimit"=>$req->CreditLimit,
					"CommissionPercentage"=>$req->CommissionPercentage,
					"Address"=>$req->Address,
					"CountryID"=>$req->CountryID,
					"StateID"=>$req->StateID,
					"DistrictID"=>$req->DistrictID,
					"TalukID"=>$req->TalukID,
					"CityID"=>$req->CityID,
					"PostalCode"=>$req->PostalCode,
					"ActiveStatus"=>$req->ActiveStatus,
					"Reference"=>$req->Reference,
					"UpdatedBy"=>$this->UserID,
					"UpdatedOn"=>date("Y-m-d H:i:s")
				);
				if($Logo!=""){
					$data['Logo']=$Logo;
				}else if($req->removeLogo=="1"){
					$data['Logo']="";
				}
				$status=DB::Table('tbl_vendors')->where('VendorID',$VendorID)->update($data);
				if($status){
					$pwd = Hash::make($req->Email);
					$status=DB::table('users')->where('ReferID',$VendorID)->update(
						[
							"ActiveStatus"=>$req->ActiveStatus,
							"EMail"=>$req->Email,
							"UserName"=>$req->Email,
							"password"=>$pwd,
							"UpdatedBy"=>$this->UserID,
							"UpdatedOn"=>date("Y-m-d H:i:s")
						]
					);
				}
				//Vehicles
				$VehiclesDetail=array();
				if($status){
					$VehicleData=json_decode($req->VehicleData);
					foreach($VehicleData as $RowIndex=>$data){
						if($status){
							$VehiclesDetail[]=$data->uuid;
							$VehicleID = "";
							$t=DB::Table('tbl_vendors_vehicle')->where('VendorID',$VendorID)->where('UUID',$data->uuid)->get();
							if(count($t)>0){
								$VehicleID=$t[0]->VehicleID;
								$tdata=array(
									"VNumber"=>$data->VNo,
									"VType"=>$data->VType,
									"VBrand"=>$data->VBrand,
									"VModel"=>$data->VModel,
									"VLength"=>$data->VLength,
									"VDepth"=>$data->VDepth,
									"VWidth"=>$data->VWidth,
									"VCapacity"=>$data->VCapacity,
									"UpdatedBy"=>$this->UserID,
									"UpdatedOn"=>date("Y-m-d H:i:s")
								);
								$status=DB::Table('tbl_vendors_vehicle')->where('VendorID',$VendorID)->where('UUID',$data->uuid)->update($tdata);
							}else{
								$VehicleID = DocNum::getDocNum(docTypes::VendorVehicle->value,"",Helper::getCurrentFY());
								$tdata=array(
									"VehicleID"=>$VehicleID,
									"VendorID"=>$VendorID,
									"UUID"=>$data->uuid,
									"VNumber"=>$data->VNo,
									"VType"=>$data->VType,
									"VBrand"=>$data->VBrand,
									"VModel"=>$data->VModel,
									"VLength"=>$data->VLength,
									"VDepth"=>$data->VDepth,
									"VWidth"=>$data->VWidth,
									"VCapacity"=>$data->VCapacity,
									"CreatedBy"=>$this->UserID,
									"CreatedOn"=>date("Y-m-d H:i:s")
								);
								$status=DB::Table('tbl_vendors_vehicle')->insert($tdata);
								if($status){
									DocNum::updateDocNum(docTypes::VendorVehicle->value);
								}
							}
							$ImagesDetails=array();
							if($status){
								if (isset($data->Images) && !empty((array)$data->Images)) {
									foreach($data->Images as $ImgID=>$vData){
										$ImagesDetails[]=$ImgID;
										if($status){
											if($vData->referData->isTemp =="1" && file_exists($vData->uploadPath) ){
												$fileName1=$vData->fileName!=""?$vData->fileName:Helper::RandomString(10)."png";
												copy($vData->uploadPath,$vdir.$fileName1);
												
												$t=array("gImage"=>$vdir.$fileName1,"ImgID"=>$ImgID);
												$VImages=$vdir.$fileName1;
												$RemoveImg[]=$vData->uploadPath;
												$uploadingImgs[]=$vdir.$fileName1;
												$t=DB::Table('tbl_vendors_vehicle_images')->where('VendorID',$VendorID)->where('UUID',$data->uuid)->where('ImgID',$ImgID)->get();
												if(count($t)>0){
													$tmpData=array(
														"gImage"=>$VImages,
														"UpdatedBy"=>$this->UserID,
														"UpdatedOn"=>date("Y-m-d H:i:s")
													);
													$status=DB::Table('tbl_vendors_vehicle_images')->where('VendorID',$VendorID)->where('UUID',$data->uuid)->where('ImgID',$ImgID)->update($tmpData);
												}else{
													$tmpData=array(
														"SLNO"=>DocNum::getDocNum(docTypes::VendorVehicleImages->value,"",Helper::getCurrentFY()),
														"VendorID"=>$VendorID,
														"VehicleID"=>$VehicleID,
														"UUID"=>$data->uuid,
														"ImgID"=>$ImgID,
														"gImage"=>$VImages,
														"CreatedBy"=>$this->UserID,
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
							}
							//delete images
							if($status && count($ImagesDetails)>0){
								$sql="Select SLNO,gImage From tbl_vendors_vehicle_images Where VendorID='".$VendorID."' and UUID='".$data->uuid."' and ImgID not in('".implode("','",$ImagesDetails)."')";
								$result=DB::SELECT($sql);
								for($m=0;$m<count($result);$m++){
									if($status){
										$RemoveImg[]=$result[$m]->gImage;
										DB::Table('tbl_vendors_vehicle_images')->where('SLNO',$result[$m]->SLNO)->delete();
									}
								}
							}
						}
					}
				}
				if($status && count($VehiclesDetail)>0){
					$sql="Select * From tbl_vendors_vehicle Where VendorID='".$VendorID."' and UUID not in('".implode("','",$VehiclesDetail)."')";
					$result=DB::SELECT($sql);
					for($m=0;$m<count($result);$m++){
						if($status){
							DB::Table('tbl_vendors_vehicle')->where('UUID',$result[$m]->UUID)->update(array("DFlag"=>1,"DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
						}
					}
				}else if($status && count($VehiclesDetail)==0){
					DB::Table('tbl_vendors_vehicle')->where('VendorID',$VendorID)->update(array("DFlag"=>1,"DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
				}

				//supply details
				$SupplyDetails=json_decode($req->SupplyDetails);
				$PSCIDs=[];
				foreach($SupplyDetails as $data){
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

				//Documents
				$Documents=json_decode($req->Documents);
				$tDocuments=array();
				foreach($Documents as $ImgID=>$Document){
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
									"CreatedBy"=>$this->UserID,
									"CreatedOn"=>date("Y-m-d H:i:s")
								);
								$status=DB::Table('tbl_vendors_document')->where('VendorID',$VendorID)->where('ImgID',$ImgID)->update($tdata);
							}else{
								$tdata=array(
									"SLNO"=>DocNum::getDocNum(docTypes::VendorDocuments->value,"",Helper::getCurrentFY()),
									"VendorID"=>$VendorID,
									"ImgID"=>$ImgID,
									"documents"=>$DocUrl,
									"CreatedBy"=>$this->UserID,
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
					$sql="Select SLNO,documents From tbl_vendors_document Where VendorID='".$VendorID."' and ImgID not in('".implode("','",$tDocuments)."')";
					$result=DB::SELECT($sql);
					for($m=0;$m<count($result);$m++){
						if($status){
							$RemoveImg[]=$result[$m]->documents;
							$status=DB::Table('tbl_vendors_document')->where('SLNO',$result[$m]->SLNO)->delete();
						}
					}
				}
				$isVendorInUser = DB::Table('users')->where('ReferID',$VendorID)->exists();
				if(!$isVendorInUser){
					$UserID=DocNum::getDocNum(docTypes::Users->value,'',Helper::getCurrentFY());

					$VendorName = $req->VendorName;
					$nameParts = explode(' ', $VendorName, 2);
					$firstName = $nameParts[0] ?? '';
					$lastName = $nameParts[1] ?? '';
					$pwd1=Hash::make($req->Email);
					$data=array(
						"UserID"=>$UserID,
						"ReferID"=>$VendorID,
						"Name"=>$req->VendorName,
						"FirstName"=>$firstName,
						"LastName"=>$lastName,
						"UserName"=>$req->Email,
						"MobileNumber"=>$req->MobileNumber1,
						"Password"=>$pwd1,
						"EMail"=>$req->Email,
						"Address"=>$req->Address,
						"PostalCodeID"=>$req->PostalCode,
						"CityID"=>$req->CityID,
						"TalukID"=>$req->TalukID,
						"DistrictID"=>$req->DistrictID,
						"StateID"=>$req->StateID,
						"CountryID"=>$req->CountryID,
						"isLogin"=>1,
						"LoginType"=>"Vendor",
						"CreatedOn"=>date("Y-m-d H:i:s"),
						"CreatedBy"=>$this->UserID
					);
					$status=DB::Table('users')->insert($data);
				}else{
					$VendorName = $req->VendorName;
					$nameParts = explode(' ', $VendorName, 2);
					$firstName = $nameParts[0] ?? '';
					$lastName = $nameParts[1] ?? '';
	
					$pwd1=Hash::make($req->Email);
					$pwd2=Helper::EncryptDecrypt("encrypt",$req->Email);
	
					$data=array(
						"Name"=>$req->VendorName,
						"FirstName"=>$firstName,
						"LastName"=>$lastName,
						"UserName"=>$req->Email,
						"MobileNumber"=>$req->MobileNumber1,
						"Password"=>$pwd1,
						"Password1"=>$pwd2,
						"EMail"=>$req->Email,
						"Address"=>$req->Address,
						"PostalCodeID"=>$req->PostalCode,
						"CityID"=>$req->CityID,
						"TalukID"=>$req->TalukID,
						"DistrictID"=>$req->DistrictID,
						"StateID"=>$req->StateID,
						"CountryID"=>$req->CountryID,
						"UpdatedOn"=>date("Y-m-d H:i:s"),
						"UpdatedBy"=>$this->UserID
					);
					$status=DB::Table('users')->where('ReferID',$VendorID)->update($data);
					DocNum::updateDocNum(docTypes::Users->value);
				}
			}catch(Exception $e) {
				$status=false;
			}
			if($status==true){
				$NewData=$this->getVendor($VendorID);
				DB::commit();
				$logData=array("Description"=>"Vendor Updated ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE->value,"ReferID"=>$VendorID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				foreach($RemoveImg as $index=>$Img){
					Helper::removeFile($Img);
				}
				return array('status'=>true,'message'=>"Vendor Updated Successfully");
			}else{
				DB::rollback();
				foreach($uploadingImgs as $index=>$Img){
					Helper::removeFile($Img);
				}
				return array('status'=>false,'message'=>"Vendor Update Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
	public function Approve(Request $req,$VendorID){ 
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=$this->getVendor($VendorID);
				$status=DB::table('tbl_vendors')->where('VendorID',$VendorID)->update(array("isApproved"=>1,"ApprovedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$Title = "Vendor Application Accepted";
				$Message = "Your vendor details has been approved by the admin. You can now access your vendor home.";
				Helper::saveNotification($VendorID,$Title,$Message,'Approve',$VendorID);
				$logData=array("Description"=>"Vendor has been Approved","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE->value,"ReferID"=>$VendorID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Vendor Approved Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Vendor Approve Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function Delete(Request $req,$VendorID){ 
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=$this->getVendor($VendorID);
				$status=DB::table('users')->where('ReferID',$VendorID)->update(array("DFlag"=>1,"DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
				$status=DB::table('tbl_vendors')->where('VendorID',$VendorID)->update(array("DFlag"=>1,"DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Vendor has been Deleted ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::DELETE->value,"ReferID"=>$VendorID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Vendor Deleted Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Vendor Delete Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function Restore(Request $req,$VendorID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=$this->getVendor($VendorID);
				$status=DB::table('users')->where('ReferID',$VendorID)->update(array("DFlag"=>0,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
				$status=DB::table('tbl_vendors')->where('VendorID',$VendorID)->update(array("DFlag"=>0,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$NewData=$this->getVendor($VendorID);
				$logData=array("Description"=>"Vendor has been Restored","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::RESTORE->value,"ReferID"=>$VendorID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Vendor Restored Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Vendor Restore Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TableView(Request $request){
		$generalDB=Helper::getGeneralDB();
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'V.VendorCoName', 'dt' => '0' ),
				array( 'db' => 'V.VendorName', 'dt' => '1' ),
				array( 'db' => 'V.MobileNumber1', 'dt' => '2' ),
				array( 'db' => 'VT.VendorType', 'dt' => '3' ),
				array( 'db' => 'D.DistrictName', 'dt' => '4' ),
				array( 'db' => 'V.CreatedOn', 'dt' => '5' ),
				array( 'db' => 'V.ActiveStatus', 'dt' => '6'),
				array( 'db' => 'V.VendorID', 'dt' => '7'),
				array( 'db' => 'V.isApproved', 'dt' => '8'),
			);
			$columns1 = array(
				array('db' => 'VendorCoName', 'dt' => '0'),
				array('db' => 'VendorName', 'dt' => '1'),
				array('db' => 'MobileNumber1', 'dt' => '2'),
				array('db' => 'VendorType', 'dt' => '3'),
				array('db' => 'DistrictName', 'dt' => '4'),
				array('db' => 'VendorID', 'dt' => '5',
					'formatter' => function( $d, $row ) {
						$VendorStockPointCount = DB::table('tbl_vendors_stock_point')->where('ActiveStatus',1)->where('DFlag',0)->where('VendorID',$d)->count();
						$StockPointNames = DB::table('tbl_vendors_stock_point')->where('ActiveStatus',1)->where('DFlag',0)->where('VendorID',$d)->pluck('PointName')->toArray();
						$StockPointNamesImploded = implode(",&#10;", array_map('htmlspecialchars', $StockPointNames, array_fill(0, count($StockPointNames), ENT_QUOTES)));
    					return "<span title=\"" . $StockPointNamesImploded . "\" class='badge badge-" . ($VendorStockPointCount > 0 ? "info" : "danger") . " m-1'>" . htmlspecialchars($VendorStockPointCount, ENT_QUOTES, 'UTF-8') . "</span>";
					}

				),
				array('db' => 'CreatedOn', 'dt' => '6', 'formatter' => function ($d, $row) {
					return date($this->Settings['date-format'], strtotime($d));
				}),
				array('db' => 'ActiveStatus','dt' => '7',
					'formatter' => function ($d, $row) {
						if ($row['isApproved'] == 0) {
							return "<span class='badge badge-info m-1'>Not Approved</span>";
						} elseif ($d == "Active") {
							return "<span class='badge badge-success m-1'>Active</span>";
						} else {
							return "<span class='badge badge-danger m-1'>Inactive</span>";
						}
					}
				),
				array( 'db' => 'VendorID', 
					'dt' => '8',
					'formatter' => function( $d, $row ) {
						$html='';
						if($this->general->isCrudAllow($this->CRUD,"edit")==true && $row['isApproved'] == 1){
							// $html.='<button type="button" data-id="'.$d.'" class="btn btn-outline-info '.$this->general->UserInfo['Theme']['button-size'].' me-2 mb-2 btnStockPoint" title="Edit Stock Point"><i class="fa fa-map-marker" aria-hidden="true"></i></button>';
							// $html.='<button type="button" data-id="'.$d.'" class="btn btn-outline-dark '.$this->general->UserInfo['Theme']['button-size'].' me-2 mb-2 btnEditProductMap" title="Edit Product Mapping"><i class="fa fa-dropbox" aria-hidden="true"></i></button>';
							$html.='<button type="button" data-id="'.$d.'" class="btn btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].' me-2 mb-2 btnEdit" title="Edit"><i class="fa fa-pencil"></i></button>';
						}else if ($this->general->isCrudAllow($this->CRUD,"edit")==true && $row['isApproved'] == 0){
							$html.='<button type="button" data-id="'.$d.'" data-vendor-name="'.$row['VendorCoName'].'" class="btn btn-outline-info '.$this->general->UserInfo['Theme']['button-size'].' me-2 mb-2 btnVendorInfo" title="View"><i class="fa fa-eye" aria-hidden="true"></i></button>';
							$html.='<button type="button" data-id="'.$d.'" class="btn btn-outline-primary '.$this->general->UserInfo['Theme']['button-size'].' me-2 mb-2 btnApprove" title="Approve"><i class="fa fa-check" aria-hidden="true"></i></button>';
						}
						if($this->general->isCrudAllow($this->CRUD,"delete")==true){
							$html.='<button type="button" data-id="'.$d.'" class="btn btn-outline-danger '.$this->general->UserInfo['Theme']['button-size'].' mb-2 btnDelete" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
						}
						return $html;
					} 
				),
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_vendors as V LEFT JOIN tbl_vendor_type as VT ON VT.VendorTypeID=V.VendorType LEFT JOIN '.$generalDB.'tbl_districts as D ON D.DistrictID=V.DistrictID';
			$data['PRIMARYKEY']='V.VendorID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns1;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" V.DFlag=0";
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TrashTableView(Request $request){
		$generalDB=Helper::getGeneralDB();
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			$columns = array(
				array( 'db' => 'V.VendorName', 'dt' => '0' ),
				array( 'db' => 'V.MobileNumber1', 'dt' => '1' ),
				array( 'db' => 'V.GSTNo', 'dt' => '2' ),
				array( 'db' => 'VT.VendorType', 'dt' => '3' ),
				array( 'db' => 'V.Address', 'dt' => '4' ),
				array( 'db' => 'CI.CityName', 'dt' => '5' ),
				array( 'db' => 'D.DistrictName', 'dt' => '6'),
				array( 'db' => 'P.PostalCode', 'dt' => '7'),
				array( 'db' => 'V.ActiveStatus', 'dt' => '8'),
				array( 'db' => 'V.VendorID', 'dt' => '9'),
			);
			$columns1 = array(
				array( 'db' => 'VendorName', 'dt' => '0' ),
				array( 'db' => 'MobileNumber1', 'dt' => '1' ),
				array( 'db' => 'GSTNo', 'dt' => '2' ),
				array( 'db' => 'VendorType', 'dt' => '3' ),
				array( 'db' => 'Address', 'dt' => '4' ),
				array( 'db' => 'CityName', 'dt' => '5' ),
				array( 'db' => 'DistrictName', 'dt' => '6'),
				array( 'db' => 'PostalCode', 'dt' => '7'),
				array( 
					'db' => 'ActiveStatus', 
					'dt' => '8',
					'formatter' => function( $d, $row ) {
						if($d=="Active"){
							return "<span class='badge badge-success m-1'>Active</span>";
						}else{
							return "<span class='badge badge-danger m-1'>Inactive</span>";
						}
					} 
				),
				array( 
					'db' => 'VendorID', 
					'dt' => '9',
					'formatter' => function( $d, $row ) {
						$html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].'  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
						return $html;
					} 
				),
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_vendors as V LEFT JOIN tbl_vendor_type as VT ON VT.VendorTypeID=V.VendorType LEFT JOIN '.$generalDB.'tbl_postalcodes as P ON P.PID=V.PostalCode LEFT JOIN '.$generalDB.'tbl_cities as CI ON CI.CityID=V.CityID LEFT JOIN '.$generalDB.'tbl_taluks as T ON T.TalukID=V.TalukID LEFT JOIN '.$generalDB.'tbl_districts as D ON D.DistrictID=V.DistrictID';
			$data['PRIMARYKEY']='V.VendorID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns1;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" V.DFlag=1 ";
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function getVendorCategory(Request $req){
		return DB::Table('tbl_vendor_category')->where('ActiveStatus','Active')->where('DFlag',0)->get();
	}
	public function getVendorType(Request $req){
		return DB::Table('tbl_vendor_type')->where('ActiveStatus','Active')->where('DFlag',0)->get();
	}
	public function UniqueValidation(Request $req){
		$query = DB::Table('tbl_vendors');
		if ($req->MobNo) {
			$query->where('MobileNumber1', $req->MobNo);
		} elseif ($req->CoName) {
			$query->where('VendorCoName',$req->CoName);
		} elseif ($req->Email) {
			$query->where('Email', 'like',$req->Email);
		}
	
		if ($req->VendorID) {
			$query->whereNot('VendorID', $req->VendorID);
		}
	
		$status = $query->first();
		return !$status ? "false" : "true";
	}
	
	public function GetVendorInfo(request $req){
		$VendorInfo = $this->getVendor($req->VendorID);
		return $VendorInfo[0];
	}
}
