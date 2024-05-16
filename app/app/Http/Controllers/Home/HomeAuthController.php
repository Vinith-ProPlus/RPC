<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Controllers\web\Transaction\OrderController;
use App\Http\Controllers\web\Transaction\QuotationController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\DocNum;
use general;
use SSP;
use Illuminate\Support\Facades\Auth;
use App\Rules\ValidUnique;
use logs;
use App\helper\helper;
use App\enums\activeMenuNames;
use App\enums\docTypes;
use App\enums\cruds;
use PHPUnit\TextUI\Help;

class HomeAuthController extends Controller{
	private $generalDB;
    private $tmpDB;
    private $Company;
    private $PCategories;
	private $UserID;
	private $ReferID;
	private $FileTypes;
	private $UserData;
	private $logDB;
	private $supportDB;
    private $CurrFyDB;
    private $shippingAddress;

	public function __construct(){
		$this->generalDB=Helper::getGeneralDB();
		$this->tmpDB=Helper::getTmpDB();
		$this->logDB=Helper::getLogDB();
		$this->supportDB=Helper::getSupportDB();
        $this->CurrFyDB=Helper::getcurrFyDB();
        $this->PCategories = DB::Table('tbl_product_category')->where('ActiveStatus','Active')->where('DFlag',0)
            ->select('PCName','PCID',
                DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
            ->inRandomOrder()->take(10)->get();
		$this->FileTypes=Helper::getFileTypes(array("category"=>array("Images","Documents")));
		$this->Company = DB::table('tbl_company_settings')->select('KeyName', 'KeyValue')->get()->pluck('KeyValue', 'KeyName')->toArray();
        $this->Company['AddressData'] = DB::table($this->generalDB.'tbl_cities as CI')
        ->leftJoin($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'CI.PostalID')
        ->leftJoin($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'CI.TalukID')
        ->leftJoin($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'CI.DistrictID')
        ->leftJoin($this->generalDB.'tbl_states as S', 'S.StateID', 'CI.StateID')
        ->leftJoin($this->generalDB.'tbl_countries as C','C.CountryID','CI.CountryID')->where('CI.CityID',$this->Company['CityID'])
        ->select('C.CountryName','S.StateName','D.DistrictName','T.TalukName','CI.CityName', 'PC.PostalCode')
        ->first();

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
			$this->UserData = Helper::getUserInfo(Auth()->user()->UserID);
			$this->UserID=auth()->user()->UserID;
			$this->ReferID=auth()->user()->ReferID;
            $this->shippingAddress = DB::table('tbl_customer_address as CA')->where('CustomerID',$this->ReferID)->where('CA.DFlag',0)
                ->join($this->generalDB.'tbl_countries as C','C.CountryID','CA.CountryID')
                ->join($this->generalDB.'tbl_states as S', 'S.StateID', 'CA.StateID')
                ->join($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'CA.DistrictID')
                ->join($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
                ->join($this->generalDB.'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
                ->join($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
                ->select('CA.AID', 'CA.Address', 'CA.isDefault', 'CA.CountryID', 'C.CountryName', 'CA.StateID', 'S.StateName', 'CA.DistrictID', 'D.DistrictName', 'CA.TalukID', 'T.TalukName', 'CA.CityID', 'CI.CityName', 'CA.PostalCodeID', 'PC.PostalCode')
                ->get();
			return $next($request);
		});
    }

    public function Home(Request $req){
		$CustomerID = $this->ReferID;
		$FormData['Company']=$this->Company;
		$PCatagories = DB::Table('tbl_product_category')->where('ActiveStatus','Active')->where('DFlag',0)->select('PCName','PCID','PCImage')
        ->inRandomOrder()->take(10)->get();

		foreach($PCatagories as $row){
			$row->PCImage = $row->PCImage ? url('/').'/'.$row->PCImage :url('/') . '/'.'assets/images/no-image-b.png';
			$row->PSCData = DB::table('tbl_product_subcategory')->where('ActiveStatus','Active')->where('DFlag',0)->where('PCID',$row->PCID)->select('PSCID','PSCName','PSCImage')->get();
			foreach($row->PSCData as $item){
				$item->PSCImage = $item->PSCImage ? url('/').'/'.$item->PSCImage :url('/') . '/'.'assets/images/no-image-b.png';
				$item->ProductData = DB::table('tbl_products')->where('ActiveStatus','Active')->where('DFlag',0)->where('CID',$row->PCID)->where('SCID',$item->PSCID)->select('ProductID','ProductName','ProductImage')->get();
				foreach($item->ProductData as $data){
					$data->ProductImage = $data->ProductImage ? url('/').'/'.$data->ProductImage :url('/') . '/'.'assets/images/no-image-b.png';
					$data->gImages=DB::table('tbl_products_gallery')->where('ProductID',$data->ProductID)->select(DB::raw('CONCAT("' . url('/') . '/", gImage) AS gImage'))->get();
				}
			}
		}
		$RecentProducts = DB::table('tbl_products as P')->leftJoin('tbl_product_subcategory as PSC','PSC.PSCID','P.SCID')
            ->where('P.ActiveStatus','Active')->where('P.DFlag',0)
            ->select('P.ProductID','P.ProductName','P.ProductImage','PSC.PSCName')
        ->inRandomOrder()->take(18)->get()->toArray();

		foreach($RecentProducts as $data){
			$data->ProductImage = $data->ProductImage ? url('/').'/'.$data->ProductImage :url('/') . '/'.'assets/images/no-image-b.png';
		}
		$FormData['PCategories']=$PCatagories;
		$FormData['RecentProducts']=$RecentProducts;
		shuffle($RecentProducts);
		$FormData['HotProducts']=$RecentProducts;
		$FormData['isRegister']=false;
		$FormData['Cart']=$this->getCart();

		$FormData['ShippingAddress']=DB::table('tbl_customer_address as CA')->where('CustomerID',$CustomerID)->where('CA.DFlag',0)
		->join($this->generalDB.'tbl_countries as C','C.CountryID','CA.CountryID')
		->join($this->generalDB.'tbl_states as S', 'S.StateID', 'CA.StateID')
		->join($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'CA.DistrictID')
		->join($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
		->join($this->generalDB.'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
		->join($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
		->select('CA.AID', 'CA.Address', 'CA.isDefault', 'CA.CountryID', 'C.CountryName', 'CA.StateID', 'S.StateName', 'CA.DistrictID', 'D.DistrictName', 'CA.TalukID', 'T.TalukName', 'CA.CityID', 'CI.CityName', 'CA.PostalCodeID', 'PC.PostalCode')
		->get();
		// return $FormData['ShippingAddress'];
		return view('home.home',$FormData);
    }

    public function products(Request $req){
		$CustomerID = $this->ReferID;
		$FormData['Company']=$this->Company;
		$PCatagories = DB::Table('tbl_product_category')->where('ActiveStatus','Active')->where('DFlag',0)->select('PCName','PCID','PCImage')
        ->inRandomOrder()->take(10)->get();
		$FormData['PCategories']=$PCatagories;
		$FormData['isRegister']=false;
		$FormData['Cart']=$this->getCart();
		$FormData['ShippingAddress']=DB::table('tbl_customer_address as CA')->where('CustomerID',$CustomerID)->where('CA.DFlag',0)
		->join($this->generalDB.'tbl_countries as C','C.CountryID','CA.CountryID')
		->join($this->generalDB.'tbl_states as S', 'S.StateID', 'CA.StateID')
		->join($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'CA.DistrictID')
		->join($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
		->join($this->generalDB.'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
		->join($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
		->select('CA.AID', 'CA.Address', 'CA.isDefault', 'CA.CountryID', 'C.CountryName', 'CA.StateID', 'S.StateName', 'CA.DistrictID', 'D.DistrictName', 'CA.TalukID', 'T.TalukName', 'CA.CityID', 'CI.CityName', 'CA.PostalCodeID', 'PC.PostalCode')
		->get();
		return view('home.products',$FormData);
    }

    public function quickViewHtml($PID)
    {
        $cartProducts = $this->getCart();
        $customerID = $this->ReferID;
        $product = DB::table('tbl_products as P')->leftJoin('tbl_product_subcategory as PSC','PSC.PSCID','P.SCID')
            ->leftJoin('tbl_product_category as PC','PC.PCID','P.CID')
            ->leftJoin('tbl_wishlists as W', function($join) use ($customerID) {
                $join->on('W.product_id', '=', 'P.ProductID')
                    ->where('W.customer_id', '=', $customerID);
            })
            ->where('P.ActiveStatus','Active')->where('P.DFlag',0)
            ->where('P.ProductID', $PID)
            ->select('P.ProductID','P.ProductName','P.Description', 'PC.PCID', 'PSC.PSCID', 'PC.PCName as CategoryName',
                'PSC.PSCName as SubCategoryName', 'P.ProductImage', 'P.ProductBrochure', 'P.VideoURL',
                DB::raw('IF(W.product_id IS NOT NULL, true, false) AS IsInWishlist'))
            ->first();
        $product->ProductImage = (new Helper)->fileCheckAndUrl($product->ProductImage, 'assets/images/no-image-b.png');
        $product->ProductBrochure = (new Helper)->fileCheckAndUrl($product->ProductBrochure, '');
        $product->GalleryImages = DB::table('tbl_products_gallery')
            ->where('ProductID', $PID)
            ->pluck('gImage')
            ->map(function ($image) {
                return (new Helper)->fileCheckAndUrl($image, 'assets/images/no-image-b.png');
            })
            ->toArray();
        return view('home.quick-view-html', compact('product', 'cartProducts'))->render();
    }

    public function categoriesHtml(Request $request)
    {
        $categories = $this->getCategory($request);
        return view('home.categories-html', compact('categories'))->render();
    }

    public function productsHtml(Request $request)
    {
        $productCount = $request->productCount ?? 12;
        $pageNo = $request->pageNo ?? 1;
        $viewType = $request->viewType ?? 'Grid';
        $orderBy = $request->orderBy ?? '';
        $productsData = $this->getProductDetails($request);
        $productDetails = $productsData['productDetails'];
        $totalProductsCount = $productsData['totalProductsCount'];

        $totalPages = ceil($totalProductsCount / $productCount);
        $range = 3;

        if($pageNo > $totalPages){
            $pageNo = $request->pageNo = $totalPages;
            $productsData = $this->getProductDetails($request);
            $productDetails = $productsData['productDetails'];
        }
        return view('home.products-html', compact('productDetails', 'productCount', 'pageNo', 'totalPages', 'range', 'viewType', 'orderBy'))->render();
    }

    public function Register(Request $req){

		$FormData['Company']=$this->Company;
		$FormData['UserData']=$this->UserData['data'];
		$FormData['PCategories']=$this->PCategories;
		$FormData['isEdit']=false;
		$FormData['isRegister']=true;
		$FormData['Cart']=$this->getCart();
		return view('home.register',$FormData);
    }
    public function Profile(Request $req){
		$CustomerID = $this->ReferID;
		$FormData['Company']=$this->Company;
		$FormData['UserData']=$this->UserData['data'];
		$FormData['PCategories']=$this->PCategories;
		$FormData['isEdit']=true;
		$FormData['isRegister']=false;
		$FormData['Cart']=$this->getCart();
		$FormData['EditData'] = DB::table('tbl_customer')->where('DFlag',0)->Where('CustomerID',$CustomerID)->first();
		$FormData['defaultAddressAID'] = DB::table('tbl_customer_address')->where('DFlag',0)->Where('CustomerID',$CustomerID)->where('isDefault', 1)->pluck('AID')->first();
		if($FormData['EditData']){
			$FormData['EditData']->CustomerImage = $FormData['EditData']->CustomerImage ? url('/').'/'.$FormData['EditData']->CustomerImage : url('/') . '/'.'assets/images/no-image-b.png';
			$FormData['EditData']->PostalCode = DB::table($this->generalDB.'tbl_postalcodes as P')->where('PID',$FormData['EditData']->PostalCodeID)->value('PostalCode');
            $FormData['ShippingAddress']=DB::table('tbl_customer_address as CA')->where('CustomerID',$CustomerID)->where('CA.DFlag',0)
                ->join($this->generalDB.'tbl_countries as C','C.CountryID','CA.CountryID')
                ->join($this->generalDB.'tbl_states as S', 'S.StateID', 'CA.StateID')
                ->join($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'CA.DistrictID')
                ->join($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
                ->join($this->generalDB.'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
                ->join($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
                ->select('CA.AID', 'CA.Address', 'CA.isDefault', 'CA.CountryID', 'C.CountryName', 'CA.StateID', 'S.StateName', 'CA.DistrictID', 'D.DistrictName', 'CA.TalukID', 'T.TalukName', 'CA.CityID', 'CI.CityName', 'CA.PostalCodeID', 'PC.PostalCode')
                ->get();
			$FormData['EditData']->SAddress = DB::table('tbl_customer_address as CA')->where('CustomerID',$CustomerID)->where('CA.DFlag', 0)
			->join($this->generalDB.'tbl_countries as C','C.CountryID','CA.CountryID')
			->join($this->generalDB.'tbl_states as S', 'S.StateID', 'CA.StateID')
			->join($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'CA.DistrictID')
			->join($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
			->join($this->generalDB.'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
			->join($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
			->select('CA.AID', 'CA.Address', 'CA.isDefault', 'CA.CountryID', 'C.CountryName', 'CA.StateID', 'S.StateName', 'CA.DistrictID', 'D.DistrictName', 'CA.TalukID', 'T.TalukName', 'CA.CityID', 'CI.CityName', 'CA.PostalCodeID', 'PC.PostalCode')
			->get();
            $FormData['ShippingAddress']=DB::table('tbl_customer_address as CA')->where('CustomerID',$CustomerID)->where('CA.DFlag',0)
                ->join($this->generalDB.'tbl_countries as C','C.CountryID','CA.CountryID')
                ->join($this->generalDB.'tbl_states as S', 'S.StateID', 'CA.StateID')
                ->join($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'CA.DistrictID')
                ->join($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
                ->join($this->generalDB.'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
                ->join($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
                ->select('CA.AID', 'CA.Address', 'CA.isDefault', 'CA.CountryID', 'C.CountryName', 'CA.StateID', 'S.StateName', 'CA.DistrictID', 'D.DistrictName', 'CA.TalukID', 'T.TalukName', 'CA.CityID', 'CI.CityName', 'CA.PostalCodeID', 'PC.PostalCode')
                ->get();
			// return $FormData['EditData'];
			return view('home.register',$FormData);
		}else{
			return view('errors.403');
		}
    }

	public function Save(Request $req){
		$OldData=array();$NewData=array();$CustomerID="";

		$rules=array(
			'MobileNo1' =>['required','max:10',new ValidUnique(array("TABLE"=>"tbl_customer","WHERE"=>" MobileNo1='".$req->MobileNo1."'  "),"This Mobile Number is already taken.")],
		);
		$message =[];
		$validator = Validator::make($req->all(), $rules,$message);

		if ($validator->fails()) {
			return array('status'=>false,'message'=>"Customer Create Failed",'errors'=>$validator->errors());
		}

		DB::beginTransaction();
		$status=false;
		try {
			$CustomerID=DocNum::getDocNum(docTypes::Customer->value,"",Helper::getCurrentFY());
			$CustomerImage="";
			$dir="uploads/user-and-permissions/customers/".$CustomerID."/";
			if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
			if($req->hasFile('CustomerImage')){
				$file = $req->file('CustomerImage');
				$fileName=md5($file->getClientOriginalName() . time());
				$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
				$file->move($dir, $fileName1);
				$CustomerImage=$dir.$fileName1;
			}else if(Helper::isJSON($req->CustomerImage)==true){
				$Img=json_decode($req->CustomerImage);
				if(file_exists($Img->uploadPath)){
					$fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
					copy($Img->uploadPath,$dir.$fileName1);
					$CustomerImage=$dir.$fileName1;
					unlink($Img->uploadPath);
				}
			}

			$data=array(
				"CustomerID"=>$CustomerID,
				"CustomerName"=>$req->CustomerName,
				'CustomerImage'=>$CustomerImage,
				"MobileNo1"=>$req->MobileNo1,
				"MobileNo2"=>$req->MobileNo2,
				"Email"=>$req->Email,
                "GenderID"=>$req->GenderID,
                "DOB"=>$req->DOB,
                "CusTypeID"=>$req->CusTypeID,
                "ConTypeIDs"=>$req->ConTypeIDs,
				"Address"=>$req->Address,
                "CompleteAddress"=>$req->Address.",".$req->CityID.",".$req->PostalCodeID,
				"PostalCodeID"=>$req->PostalCodeID,
				"CityID"=>$req->CityID,
				"TalukID"=>$req->TalukID,
				"DistrictID"=>$req->DistrictID,
				"StateID"=>$req->StateID,
				"CountryID"=>$req->CountryID,
				"CreatedBy"=>$this->UserID,
				"CreatedOn"=>date("Y-m-d H:i:s")
			);
			$status=DB::Table('tbl_customer')->insert($data);
            DB::Table('tbl_customer_address')->where('CustomerID', $this->UserID)->update(['CustomerID' => $CustomerID]);
//			if($status){
//				$SAddress=json_decode($req->SAddress,true);
//				foreach($SAddress as $row){
//					$AID=DocNum::getDocNum(docTypes::CustomerAddress->value,"",Helper::getCurrentFY());
//					$tmp=array(
//						"AID"=>$AID,
//						"CustomerID"=>$CustomerID,
//						"Address"=>$row['Address'],
//						"PostalCodeID"=>$row['PostalCodeID'],
//						"CityID"=>$row['CityID'],
//						"TalukID"=>$row['TalukID'],
//						"DistrictID"=>$row['DistrictID'],
//						"StateID"=>$row['StateID'],
//						"CountryID"=>$row['CountryID'],
//						"isDefault"=>$row['isDefault'],
//						"CreatedOn"=>date("Y-m-d H:i:s")
//					);
//					$status=DB::Table('tbl_customer_address')->insert($tmp);
//					if($status==true){
//						DocNum::updateDocNum(docTypes::CustomerAddress->value);
//					}
//				}
//			}
			if($status){
                $CustomerName = $req->CustomerName;
                $nameParts = explode(' ', $CustomerName, 2);
                $firstName = $nameParts[0] ?? '';
                $lastName = $nameParts[1] ?? '';

                $Udata=array(
                    "ReferID"=>$CustomerID,
                    "Name" => $CustomerName,
                    "FirstName" => $firstName,
                    "LastName" => $lastName,
					"GenderID"=>$req->GenderID,
					"DOB"=>$req->DOB,
                    "ProfileImage" => $CustomerImage,
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
			DocNum::updateDocNum(docTypes::Customer->value);
			$NewData=(array)DB::table('tbl_customer as C')->join('tbl_customer_address as CA','CA.CustomerID','C.CustomerID')->where('CA.CustomerID',$CustomerID)->where('CA.DFlag',0)->get();
			$logData=array("Description"=>"New Customer Created","ModuleName"=>"Customer","Action"=>"Add","ReferID"=>$CustomerID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
			logs::Store($logData);
			DB::commit();
			return array('status'=>true,'message'=>"Customer Created Successfully");
		}else{
			DB::rollback();
			return array('status'=>false,'message'=>"Customer Create Failed");
		}
	}
	public function Update(Request $req){
		$CustomerID = $this->ReferID;
		$OldData=DB::table('tbl_customer_address as CA')->join('tbl_customer as C','C.CustomerID','CA.CustomerID')->where('CA.CustomerID',$CustomerID)->where('CA.DFlag',0)->get();
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
		$currCustomerImage=array();
		$images=array();
		try {
			$SAddress=json_decode($req->SAddress,true);
			$CustomerImage="";
			$dir="uploads/user-and-permissions/customers/".$CustomerID."/";
			if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
			if($req->hasFile('CustomerImage')){
				$file = $req->file('CustomerImage');
				$fileName=md5($file->getClientOriginalName() . time());
				$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
				$file->move($dir, $fileName1);
				$CustomerImage=$dir.$fileName1;
			}else if(Helper::isJSON($req->CustomerImage)==true){
				$Img=json_decode($req->CustomerImage);
				if(file_exists($Img->uploadPath)){
					$fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
					copy($Img->uploadPath,$dir.$fileName1);
					$CustomerImage=$dir.$fileName1;
					unlink($Img->uploadPath);
				}
			}
			if(file_exists($CustomerImage)){
				$images=Helper::ImageResize($CustomerImage,$dir);
			}
			if(($CustomerImage!="" || intval($req->removeCustomerImage)==1) && Count($OldData)>0){
				$currCustomerImage=$OldData[0]->Images!=""?unserialize($OldData[0]->Images):array();
			}
			$data=array(
				"CustomerName"=>$req->CustomerName,
				"MobileNo1"=>$req->MobileNo1,
				"MobileNo2"=>$req->MobileNo2,
				"Email"=>$req->Email,
                "GenderID"=>$req->GenderID,
                "DOB"=>$req->DOB,
                "CusTypeID"=>$req->CusTypeID,
                "ConTypeIDs"=>$req->ConTypeIDs,
				"Address"=>$req->Address,
				"CompleteAddress"=>$req->Address.",".$req->CityID.",".$req->PostalCodeID,
				"PostalCodeID"=>$req->PostalCodeID,
				"CityID"=>$req->CityID,
				"TalukID"=>$req->TalukID,
				"DistrictID"=>$req->DistrictID,
				"StateID"=>$req->StateID,
				"CountryID"=>$req->CountryID,
				"UpdatedBy"=>$this->UserID,
				"UpdatedOn"=>date("Y-m-d H:i:s")
			);
			if($CustomerImage!=""){
				$data['CustomerImage']=$CustomerImage;
				$data['Images']=serialize($images);
			}else if(intval($req->removeCustomerImage)==1){
				$data['CustomerImage']="";
				$data['Images']=serialize(array());
			}
			$status=DB::Table('tbl_customer')->where('CustomerID',$CustomerID)->update($data);
//			if($status){
//				$AIDs=[];
//				foreach($SAddress as $row){
//					if($row['AID']){
//						$AIDs[] = $row['AID'];
//						$data=array(
//							"Address"=>$row['Address'],
//							"PostalCodeID"=>$row['PostalCodeID'],
//							"CityID"=>$row['CityID'],
//							"TalukID"=>$row['TalukID'],
//							"DistrictID"=>$row['DistrictID'],
//							"StateID"=>$row['StateID'],
//							"CountryID"=>$row['CountryID'],
//							"isDefault"=>$row['isDefault'],
//							"UpdatedOn"=>date("Y-m-d H:i:s")
//						);
//						$status=DB::Table('tbl_customer_address')->where('CustomerID',$CustomerID)->where('AID',$row['AID'])->update($data);
//					}else{
//						$AID=DocNum::getDocNum(docTypes::CustomerAddress->value,"",Helper::getCurrentFY());
//						$AIDs[] = $AID;
//						$tmp=array(
//							"AID"=>$AID,
//							"CustomerID"=>$CustomerID,
//							"Address"=>$row['Address'],
//							"PostalCodeID"=>$row['PostalCodeID'],
//							"CityID"=>$row['CityID'],
//							"TalukID"=>$row['TalukID'],
//							"DistrictID"=>$row['DistrictID'],
//							"StateID"=>$row['StateID'],
//							"CountryID"=>$row['CountryID'],
//							"isDefault"=>$row['isDefault'],
//							"CreatedOn"=>date("Y-m-d H:i:s")
//						);
//						$status=DB::Table('tbl_customer_address')->insert($tmp);
//						if($status==true){
//							DocNum::updateDocNum(docTypes::CustomerAddress->value);
//						}
//					}
//				}
//			}
//			if(count($AIDs)>0){
//				DB::table('tbl_customer_address')->where('CustomerID',$CustomerID)->whereNotIn('AID',$AIDs)->delete();
//			}
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
                    "ProfileImage" => $CustomerImage,
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
				$status=DB::Table('users')->where('UserID',$this->UserID)->where('ReferID',$this->ReferID)->update($Udata);
            }

		}catch(Exception $e) {
			$status=false;
		}
		if($status==true){
			$NewData=DB::table('tbl_customer_address as CA')->join('tbl_customer as C','C.CustomerID','CA.CustomerID')->where('CA.CustomerID',$CustomerID)->where('CA.DFlag',0)->get();
			$logData=array("Description"=>"Customer Updated ","ModuleName"=>"Customer","Action"=>"Update","ReferID"=>$CustomerID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
			logs::Store($logData);
			DB::commit();
			foreach($currCustomerImage as $KeyName=>$Img){
				Helper::removeFile($Img['url']);
			}
			return array('status'=>true,'message'=>"Customer Updated Successfully");
		}else{
			DB::rollback();
			return array('status'=>false,'message'=>"Customer Update Failed");
		}
	}

    public function getCategory(Request $req)
    {
        if ($req->AID) {
            $AllVendors = Helper::getAvailableVendorsForCustomer($req->AID);
            $PCatagories = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'VPM.PCID')
                ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
                ->where('PC.ActiveStatus', "Active")->where('PC.DFlag', 0)
                ->groupBy('PC.PCID', 'PC.PCName', 'PC.PCImage')
                ->select('PC.PCID', 'PC.PCName', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS CategoryImage'))
                ->distinct()->get();
            foreach ($PCatagories as $row) {
                $row->PSCData = DB::table('tbl_vendors_product_mapping as VPM')
                    ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'VPM.PSCID')
                    ->where('VPM.Status', 1)->where('PSC.PCID', $row->PCID)->WhereIn('VPM.VendorID', $AllVendors)
                    ->where('PSC.ActiveStatus', "Active")->where('PSC.DFlag', 0)
                    ->groupBy('PSC.PSCID', 'PSC.PSCName')
                    ->select('PSC.PSCID', 'PSC.PSCName')
                    ->distinct()->get();
                foreach ($row->PSCData as $item) {
                    $item->ProductData = DB::table('tbl_vendors_product_mapping as VPM')
                        ->leftJoin('tbl_products as P', 'P.ProductID', 'VPM.ProductID')
                        ->where('VPM.Status', 1)->where('P.CID', $row->PCID)->where('P.SCID', $item->PSCID)
                        ->WhereIn('VPM.VendorID', $AllVendors)
                        ->where('P.ActiveStatus', "Active")->where('P.DFlag', 0)
                        ->groupBy('P.ProductID', 'P.ProductName', 'P.ProductImage')
                        ->select('P.ProductID', 'P.ProductName', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(P.ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'))
                        ->distinct()->get();
                }
            }
            return $PCatagories;
        } else {
            return [];
        }
    }

    public function getProductDetails(Request $request){
        if($request->AID){
            $customerID = $this->ReferID;
            $productCount = $request->productCount ?? 12;
            $pageNo = $request->pageNo ?? 1;
            $AllVendors = Helper::getAvailableVendorsForCustomer($request->AID);
            $totalProducts = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_products as P', 'P.ProductID', 'VPM.ProductID')
                ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
                ->where('P.ActiveStatus', "Active")
                ->where('P.DFlag', 0)
                ->where('PSC.ActiveStatus', "Active")
                ->where('PSC.DFlag', 0)
                ->where('VPM.Status', 1)
                ->WhereIn('VPM.VendorID', $AllVendors)
                ->when(isset($request->SubCategoryID), function ($query) use ($request) {
                    return $query->where('P.SCID', $request->SubCategoryID);
                })
                ->select('P.ProductID')
                ->distinct()
                ->get();

            $productDetails = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_products as P', 'P.ProductID', 'VPM.ProductID')
                ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
                ->leftJoin('tbl_wishlists as W', function($join) use ($customerID) {
                    $join->on('W.product_id', '=', 'P.ProductID')
                        ->where('W.customer_id', '=', $customerID);
                })
                ->where('P.ActiveStatus', "Active")
                ->where('P.DFlag', 0)
                ->where('PSC.ActiveStatus', "Active")
                ->where('PSC.DFlag', 0)
                ->where('VPM.Status', 1)
                ->WhereIn('VPM.VendorID', $AllVendors)
                ->when(isset($request->SubCategoryID), function ($query) use ($request) {
                    return $query->where('P.SCID', $request->SubCategoryID);
                })
                ->when($request->has('orderBy') && in_array($request->orderBy, ['new', 'popularity']), function ($query) use ($request) {
                    if ($request->orderBy == "new"){
                        return $query->orderBy('P.CreatedOn', 'desc');
                    } elseif ($request->orderBy == "popularity"){
                        return $query->orderBy('P.CreatedOn', 'asc');
                    }
                })
                ->select('P.ProductID', 'P.ProductName', 'P.Description',
                    DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'),
                    DB::raw('IF(W.product_id IS NOT NULL, true, false) AS IsInWishlist'),
                    'PSC.PSCID',
                    'PSC.PSCName as SubCategoryName')
                ->distinct()
                ->skip(($pageNo - 1) * $productCount)
                ->take($productCount)
                ->get();

            return [
                'productDetails' => $productDetails,
                'totalProductsCount' => $totalProducts->count()
            ];
        } else {
            return [
                'productDetails' => [],
                'totalProductsCount' => 0
            ];
        }
    }

    public function Checkout(Request $req){
		$CustomerID = $this->ReferID;
		$FormData['Company']=$this->Company;
		$FormData['UserData']=$this->UserData['data'];
		$FormData['PCategories']=$this->PCategories;
		$FormData['isEdit']=false;
		$FormData['isRegister']=false;
		$FormData['stages'] = DB::Table($this->generalDB.'tbl_stages')
            ->where('DFlag', 0)->where('ActiveStatus', 'Active')
            ->select('StageID', 'StageName')->get();
		$FormData['BuildingMeasurements'] = DB::Table($this->generalDB.'tbl_building_measurements')
            ->where('DFlag', 0)->where('ActiveStatus', 'Active')
            ->select('MeasurementID', 'MeasurementName')->get();
        $customerAid = Session::get('selected_aid');
        $customerDefaultAid = DB::table('tbl_customer_address')
            ->where('CustomerID', $CustomerID)
            ->where('DFlag',0)
            ->where('isDefault', 1)
            ->value('AID');

        if ($customerAid && DB::table('tbl_customer_address')->where('CustomerID', $CustomerID)->where('AID', $customerAid)->where('DFlag',0)->exists()) {
            $AID = $customerAid;
        } else {
            $AID = $customerDefaultAid;
        }
        $FormData['AID']=$AID;

		$FormData['ShippingAddress']=DB::table('tbl_customer_address as CA')->where('CustomerID',$CustomerID)->where('CA.DFlag',0)
		->join($this->generalDB.'tbl_countries as C','C.CountryID','CA.CountryID')
		->join($this->generalDB.'tbl_states as S', 'S.StateID', 'CA.StateID')
		->join($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'CA.DistrictID')
		->join($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
		->join($this->generalDB.'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
		->join($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
		->select('CA.AID', 'CA.Address', 'CA.isDefault', 'CA.CountryID', 'C.CountryName', 'CA.StateID', 'S.StateName', 'CA.DistrictID', 'D.DistrictName', 'CA.TalukID', 'T.TalukName', 'CA.CityID', 'CI.CityName', 'CA.PostalCodeID', 'PC.PostalCode')
		->get();
		$FormData['CustomerData']=DB::table('tbl_customer as CU')->where('CustomerID',$CustomerID)
		->join($this->generalDB.'tbl_countries as C','C.CountryID','CU.CountryID')
		->join($this->generalDB.'tbl_states as S', 'S.StateID', 'CU.StateID')
		->join($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'CU.DistrictID')
		->join($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'CU.TalukID')
		->join($this->generalDB.'tbl_cities as CI', 'CI.CityID', 'CU.CityID')
		->join($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'CU.PostalCodeID')
		->select('CU.Address', 'CU.CountryID', 'C.CountryName', 'CU.StateID', 'S.StateName', 'CU.DistrictID', 'D.DistrictName', 'CU.TalukID', 'T.TalukName', 'CU.CityID', 'CI.CityName', 'CU.PostalCodeID', 'PC.PostalCode','CU.MobileNo1','CU.CustomerName')
		->first();

		$FormData['DeliveryAddress']=DB::table('tbl_customer_address as CA')->where('AID', $AID)->where('CA.DFlag',0)
		->join($this->generalDB.'tbl_countries as C','C.CountryID','CA.CountryID')
		->join($this->generalDB.'tbl_states as S', 'S.StateID', 'CA.StateID')
		->join($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'CA.DistrictID')
		->join($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
		->join($this->generalDB.'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
		->join($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
		->select('CA.AID', 'CA.Address', 'CA.isDefault', 'CA.CountryID', 'C.CountryName', 'CA.StateID', 'S.StateName', 'CA.DistrictID', 'D.DistrictName', 'CA.TalukID', 'T.TalukName', 'CA.CityID', 'CI.CityName', 'CA.PostalCodeID', 'PC.PostalCode')
		->first();

		$FormData['Cart']=$this->getCart();
		if($FormData['Cart'])
		return view('home.checkout',$FormData);
    }

    public function PlaceOrder(Request $req){
        DB::beginTransaction();
        $status=false;
        $CustomerID=$this->ReferID;
        try {
            $CustomerData = DB::table('tbl_customer')->where('CustomerID',$CustomerID)->first();
            $EnqID = DocNum::getDocNum(docTypes::Enquiry->value,$this->CurrFyDB,Helper::getCurrentFY());
            $BuildingImage = "";
            if($req->BuildingImage != null) {
                $dir = "uploads/transaction/enquiry/" . $EnqID . "/";
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                if ($req->hasFile('BuildingImage')) {
                    $file = $req->file('BuildingImage');
                    $fileName = md5($file->getClientOriginalName() . time());
                    $fileName1 = $fileName . "." . $file->getClientOriginalExtension();
                    $file->move($dir, $fileName1);
                    $BuildingImage = $dir . $fileName1;
                } else if (Helper::isJSON($req->BuildingImage) == true) {
                    $Img = json_decode($req->BuildingImage);
                    if (file_exists($Img->uploadPath)) {
                        $fileName1 = $Img->fileName != "" ? $Img->fileName : Helper::RandomString(10) . "png";
                        copy($Img->uploadPath, $dir . $fileName1);
                        $BuildingImage = $dir . $fileName1;
                         unlink($Img->uploadPath);
                    }
                }
            }
            $customerAid = Session::get('selected_aid');
            $customerDefaultAid = DB::table('tbl_customer_address')
                ->where('CustomerID', $CustomerID)
                ->where('DFlag',0)
                ->where('isDefault', 1)
                ->value('AID');

            if ($customerAid && DB::table('tbl_customer_address')->where('CustomerID', $CustomerID)->where('AID', $customerAid)->where('DFlag',0)->where('isDefault', 1)->exists()) {
                $AID = $customerAid;
            } else {
                $AID = $customerDefaultAid;
            }
            $AddressData = DB::table('tbl_customer_address')->where('DFlag',0)->where('AID', $AID)->first();
            $data=[
                'EnqID' => $EnqID,
                'EnqNo' =>DocNum::getInvNo("Quote-Enquiry"),
                'EnqDate' => date('Y-m-d'),
                'EnqExpiryDate' => date('Y-m-d', strtotime('+15 days')),
                'CustomerID' => $CustomerID,
                'ReceiverName' => $req->ReceiverName,
                'ReceiverMobNo' => $req->ReceiverMobNo,
                'ExpectedDeliveryDate' => $req->ExpectedDeliveryDate,
                'AID'=>$AID,
                "DAddress"=>$AddressData->Address,
                "DPostalCodeID"=>$AddressData->PostalCodeID,
                "DCityID"=>$AddressData->CityID,
                "DTalukID"=>$AddressData->TalukID,
                "DDistrictID"=>$AddressData->DistrictID,
                "DStateID"=>$AddressData->StateID,
                "DCountryID"=>$AddressData->CountryID,
                'StageID' => $req->StageID,
                'BuildingMeasurementID' => $req->BuildingMeasurementID,
                'BuildingMeasurement' => $req->BuildingMeasurement,
                'BuildingImage' => $BuildingImage,
                'CreatedOn' => date('Y-m-d H:i:s'),
                'CreatedBy' => $CustomerID,
            ];
            $status=DB::table($this->CurrFyDB.'tbl_enquiry')->insert($data);
            if($status){
                $ProductData = $this->getCart();
                foreach($ProductData as $item){
                    $EnquiryDetailID = DocNum::getDocNum(docTypes::EnquiryDetails->value,$this->CurrFyDB,Helper::getCurrentFY());
                    $data1 = [
                        'DetailID' => $EnquiryDetailID,
                        'EnqID' => $EnqID,
                        'CID' => $item->PCID,
                        'SCID' => $item->PSCID,
                        'ProductID' => $item->ProductID,
                        'Qty' => $item->Qty,
                        'UOMID' => $item->UID,
                        'CreatedOn' => date('Y-m-d H:i:s'),
                        'CreatedBy' => $CustomerID,
                    ];
                    $status = DB::table($this->CurrFyDB.'tbl_enquiry_details')->insert($data1);
                    if($status){
                        DocNum::updateDocNum(docTypes::EnquiryDetails->value,$this->CurrFyDB);
                    }
                }
                DocNum::updateDocNum(docTypes::Enquiry->value,$this->CurrFyDB);
            }
        }catch(Exception $e) {
            logger($e);
            $status=false;
        }
        if($status==true){
            DB::commit();
            $Title = "Quotation Received";
            $Message = "Your quotation has been received. Admin will verify your quotation and get back to you shortly.";
            Helper::saveNotification($CustomerID,$Title,$Message,'Quotation',$EnqID);
            DocNum::updateInvNo("Quote-Enquiry");
            DB::table('tbl_customer_cart')->where('CustomerID',$CustomerID)->delete();
            return response()->json(['status' => true,'message' => "Order Placed Successfully", "EnqID" => $EnqID]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Order Placing Failed!"]);
        }
    }

	public function getCart(){
        $Cart = DB::table('tbl_customer_cart as C')->join('tbl_products as P','P.ProductID','C.ProductID')->join('tbl_product_category as PC', 'PC.PCID', 'P.CID')->join('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')->join('tbl_uom as U', 'U.UID', 'P.UID')
        ->where('C.CustomerID', $this->ReferID)->where('P.ActiveStatus', 'Active')->where('P.DFlag', 0)->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
        ->select('P.ProductName','P.ProductID','C.Qty', 'PC.PCName', 'PC.PCID', 'PSC.PSCName','U.UName','U.UCode','U.UID', 'PSC.PSCID',DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'))->get();

        return $Cart;
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
            return response()->json(['status' => true,'message' => "Product added to Cart Successfully",'data' => $this->getCart()]);
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
            return response()->json(['status' => true,'message' => "Product Deleted Successfully",'data' => $this->getCart()]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Product Deleted Failed!"]);
        }
    }

    public function customerCategoryList(Request $request)
    {
        $CustomerID = $this->ReferID;
        $FormData['Company'] = $this->Company;
        $AllVendors = Helper::getAvailableVendorsForCustomer($request->AID);
        $PCatagories = DB::table('tbl_vendors_product_mapping as VPM')
            ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'VPM.PCID')
            ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
            ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
            ->groupBy('PC.PCID', 'PC.PCName', 'PC.PCImage')
            ->select('PC.PCID', 'PC.PCName',
                DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
            ->inRandomOrder()->get();

        $FormData['PCategories'] = $PCatagories;
        $FormData['isRegister'] = false;
        $FormData['Cart'] = $this->getCart();
        $FormData['ShippingAddress'] = DB::table('tbl_customer_address as CA')->where('CustomerID', $CustomerID)->where('CA.DFlag',0)
            ->join($this->generalDB . 'tbl_countries as C', 'C.CountryID', 'CA.CountryID')
            ->join($this->generalDB . 'tbl_states as S', 'S.StateID', 'CA.StateID')
            ->join($this->generalDB . 'tbl_districts as D', 'D.DistrictID', 'CA.DistrictID')
            ->join($this->generalDB . 'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
            ->join($this->generalDB . 'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
            ->join($this->generalDB . 'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
            ->select('CA.AID', 'CA.Address', 'CA.isDefault', 'CA.CountryID', 'C.CountryName', 'CA.StateID', 'S.StateName', 'CA.DistrictID', 'D.DistrictName', 'CA.TalukID', 'T.TalukName', 'CA.CityID', 'CI.CityName', 'CA.PostalCodeID', 'PC.PostalCode')
            ->get();
        return view('home.customer.category-list', $FormData);
    }

    public function customerCategoryListHtml(Request $request)
    {
        $productCount = ($request->productCount != 'undefined') ? $request->productCount : 12;
        $pageNo = ($request->pageNo != 'undefined') ? $request->pageNo : 1;
        $viewType = $request->viewType ?? 'Grid';
        $orderBy = $request->orderBy ?? '';

        $PCatagoriesData = $this->getCategoryDetails($request);
        $PCatagories = $PCatagoriesData['PCatagories'];
        $totalCategoriesCount = $PCatagoriesData['totalCategoriesCount'];

        $totalPages = ceil($totalCategoriesCount / $productCount);
        $range = 3;
        if($pageNo > $totalPages){
            $pageNo = $request->pageNo = $totalPages;
            $PCatagoriesData = $this->getCategoryDetails($request);
            $PCatagories = $PCatagoriesData['PCatagories'];
        }

        return view('home.customer.category-list-html', compact('PCatagories', 'productCount', 'pageNo', 'viewType', 'orderBy', 'range', 'totalPages'))->render();
    }

    public function getCategoryDetails($request)
    {
        if ($request->AID) {
            $productCount = ($request->productCount != 'undefined') ? $request->productCount : 12;
            $pageNo = ($request->pageNo != 'undefined') ? $request->pageNo : 1;

            $AllVendors = Helper::getAvailableVendorsForCustomer($request->AID);
            $PCatagoriesTotal = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'VPM.PCID')
                ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
                ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
                ->distinct()
                ->select('PC.PCID', 'PC.PCName',
                    DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
                ->get();
            $PCatagories = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'VPM.PCID')
                ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
                ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
                ->when($request->has('orderBy') && in_array($request->orderBy, ['new', 'popularity']), function ($query) use ($request) {
                    if ($request->orderBy == "new") {
                        return $query->orderBy('PC.CreatedOn', 'desc');
                    } elseif ($request->orderBy == "popularity") {
                        return $query->orderBy('PC.CreatedOn', 'asc');
                    }
                })
                ->distinct()
                ->select('PC.PCID', 'PC.PCName',
                    DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
                ->skip(($pageNo - 1) * $productCount)
                ->take($productCount)
                ->get();
            $totalCategoriesCount = $PCatagoriesTotal->count();
            return [
                'PCatagories' => $PCatagories,
                'totalCategoriesCount' => $totalCategoriesCount
            ];
        } else {
            return [
                'PCatagories' => [],
                'totalCategoriesCount' => 0
            ];
        }
    }

    public function customerSubCategoryList(Request $request)
    {
        $CustomerID = $this->ReferID;
        $FormData['Company'] = $this->Company;
        $AllVendors = Helper::getAvailableVendorsForCustomer($request->AID);
        $PCatagories = DB::table('tbl_vendors_product_mapping as VPM')
            ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'VPM.PCID')
            ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
            ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
            ->groupBy('PC.PCID', 'PC.PCName', 'PC.PCImage')
            ->select('PC.PCID', 'PC.PCName',
                DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
            ->inRandomOrder()->get();

        $FormData['CID'] = $request->CID ?? '';
        $FormData['PCategories'] = $PCatagories;
        $FormData['isRegister'] = false;
        $FormData['Cart'] = $this->getCart();
        $FormData['ShippingAddress'] = DB::table('tbl_customer_address as CA')->where('CustomerID', $CustomerID)->where('CA.DFlag',0)
            ->join($this->generalDB . 'tbl_countries as C', 'C.CountryID', 'CA.CountryID')
            ->join($this->generalDB . 'tbl_states as S', 'S.StateID', 'CA.StateID')
            ->join($this->generalDB . 'tbl_districts as D', 'D.DistrictID', 'CA.DistrictID')
            ->join($this->generalDB . 'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
            ->join($this->generalDB . 'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
            ->join($this->generalDB . 'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
            ->select('CA.AID', 'CA.Address', 'CA.isDefault', 'CA.CountryID', 'C.CountryName', 'CA.StateID', 'S.StateName', 'CA.DistrictID', 'D.DistrictName', 'CA.TalukID', 'T.TalukName', 'CA.CityID', 'CI.CityName', 'CA.PostalCodeID', 'PC.PostalCode')
            ->get();
        return view('home.customer.sub-category-list', $FormData);
    }

    public function customerSubCategoryListHtml(Request $request)
    {
        $productCount = ($request->productCount != 'undefined') ? $request->productCount : 12;
        $pageNo = ($request->pageNo != 'undefined') ? $request->pageNo : 1;
        $viewType = $request->viewType ?? 'Grid';
        $orderBy = $request->orderBy ?? '';

        $PSubCatagoriesData = $this->getSubCategoryDetails($request);
        $PSubCatagories = $PSubCatagoriesData['PSubCatagories'];
        $totalSubCategoriesCount = $PSubCatagoriesData['totalSubCategoriesCount'];

        $totalPages = ceil($totalSubCategoriesCount / $productCount);
        $range = 3;
        if($pageNo > $totalPages){
            $pageNo = $request->pageNo = $totalPages;
            $PSubCatagoriesData = $this->getSubCategoryDetails($request);
            $PSubCatagories = $PSubCatagoriesData['PSubCatagories'];
        }
        return view('home.customer.sub-category-list-html', compact('PSubCatagories', 'productCount', 'pageNo', 'viewType', 'orderBy', 'range', 'totalPages'))->render();
    }

    public function getSubCategoryDetails($request)
    {
        if ($request->AID) {
            $productCount = ($request->productCount != 'undefined') ? $request->productCount : 12;
            $pageNo = ($request->pageNo != 'undefined') ? $request->pageNo : 1;
            $AllVendors = Helper::getAvailableVendorsForCustomer($request->AID);
            $PSubCatagoriesTotal = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'VPM.PSCID')
                ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
                ->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
                ->when($request->has('CID') && isset($request->CID), function ($query) use ($request) {
                    $query->where('PSC.PCID', $request->CID);
                })
                ->distinct()
                ->select('PSC.PSCID', 'PSC.PSCName',
                    DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PSCImage, ""), "assets/images/no-image-b.png")) AS PSCImage'))
                ->get();
            $PSubCatagories = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'VPM.PSCID')
                ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
                ->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
                ->when($request->has('CID') && isset($request->CID), function ($query) use ($request) {
                    $query->where('PSC.PCID', $request->CID);
                })
                ->when($request->has('orderBy') && in_array($request->orderBy, ['new', 'popularity']), function ($query) use ($request) {
                    if ($request->orderBy == "new") {
                        return $query->orderBy('PSC.CreatedOn', 'desc');
                    } elseif ($request->orderBy == "popularity") {
                        return $query->orderBy('PSC.CreatedOn', 'asc');
                    }
                })
                ->distinct()
                ->select('PSC.PSCID', 'PSC.PSCName',
                    DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PSCImage, ""), "assets/images/no-image-b.png")) AS PSCImage'))
                ->skip(($pageNo - 1) * $productCount)
                ->take($productCount)
                ->get();

            $totalSubCategoriesCount = $PSubCatagoriesTotal->count();

            return [
                'PSubCatagories' => $PSubCatagories,
                'totalSubCategoriesCount' => $totalSubCategoriesCount
            ];
        } else {
            return [
                'PSubCatagories' => [],
                'totalSubCategoriesCount' => 0
            ];
        }
    }

    public function customerProductsList(Request $request)
    {
        $CustomerID = $this->ReferID;
        $FormData['Company'] = $this->Company;
        $AllVendors = Helper::getAvailableVendorsForCustomer($request->AID);
        $PCatagories = DB::table('tbl_vendors_product_mapping as VPM')
            ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'VPM.PCID')
            ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
            ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
            ->groupBy('PC.PCID', 'PC.PCName', 'PC.PCImage')
            ->select('PC.PCID', 'PC.PCName',
                DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
            ->inRandomOrder()->get();

        $FormData['CID'] = $request->CID ?? '';
        $FormData['PCategories'] = $PCatagories;
        $FormData['isRegister'] = false;
        $FormData['Cart'] = $this->getCart();
        $FormData['ShippingAddress'] = DB::table('tbl_customer_address as CA')->where('CustomerID', $CustomerID)->where('CA.DFlag',0)
            ->join($this->generalDB . 'tbl_countries as C', 'C.CountryID', 'CA.CountryID')
            ->join($this->generalDB . 'tbl_states as S', 'S.StateID', 'CA.StateID')
            ->join($this->generalDB . 'tbl_districts as D', 'D.DistrictID', 'CA.DistrictID')
            ->join($this->generalDB . 'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
            ->join($this->generalDB . 'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
            ->join($this->generalDB . 'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
            ->select('CA.AID', 'CA.Address', 'CA.isDefault', 'CA.CountryID', 'C.CountryName', 'CA.StateID', 'S.StateName', 'CA.DistrictID', 'D.DistrictName', 'CA.TalukID', 'T.TalukName', 'CA.CityID', 'CI.CityName', 'CA.PostalCodeID', 'PC.PostalCode')
            ->get();
        $FormData['SCID'] = $request->SCID ?? '';
        return view('home.customer.products-list', $FormData);
    }

    public function customerProductsListHtml(Request $request)
    {
        $productCount = $request->productCount ?? 12;
        $pageNo = $request->pageNo ?? 1;
        $viewType = $request->viewType ?? 'Grid';
        $orderBy = $request->orderBy ?? '';
        $productsData = $this->getProductDetails($request);
        $productDetails = $productsData['productDetails'];
        $totalProductsCount = $productsData['totalProductsCount'];

        $totalPages = ceil($totalProductsCount / $productCount);
        $range = 3;

        if ($pageNo > $totalPages) {
            $pageNo = $request->pageNo = $totalPages;
            $productsData = $this->getProductDetails($request);
            $productDetails = $productsData['productDetails'];
        }
        return view('home.customer.products-list-html', compact('productDetails', 'productCount', 'pageNo', 'viewType', 'orderBy', 'range', 'totalPages'))->render();
    }

    public function wishlistTableHtml(Request $request)
    {
        $productCount = ((int)($request->productCount) != 0) ? $request->productCount : 12;
        $pageNo = ($request->pageNo != 'undefined') ? $request->pageNo : 1;
        $viewType = $request->viewType ?? 'Grid';
        $orderBy = $request->orderBy ?? '';
        $wishListDetails = $this->getWishlistDetails($request);
        $totalWishListCount = $wishListDetails['totalWishListCount'];
        $wishListDetails = $wishListDetails['wishListDetails'];

        $totalPages = ceil($totalWishListCount / $productCount);
        $range = 3;
        if($pageNo > $totalPages){
            $pageNo = $request->pageNo = $totalPages;
            $wishListDetails = $this->getWishlistDetails($request);
            $wishListDetails = $wishListDetails['wishListDetails'];
        }
        $cartProducts = $this->getCart();
        return view('home.customer.wish-list-html', compact('wishListDetails', 'cartProducts', 'productCount', 'pageNo', 'viewType', 'orderBy', 'range', 'totalPages'))->render();
    }
    public function getWishlistDetails($request)
    {
        if($request->AID){
            $customerID = $this->ReferID;
            $productCount = ((int)($request->productCount) != 0) ? $request->productCount : 12;
            $pageNo = $request->pageNo ?? 1;

            $AllVendors = Helper::getAvailableVendorsForCustomer($request->AID);
            $wishListCount = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_products as P', 'P.ProductID', 'VPM.ProductID')
                ->leftJoin('tbl_wishlists as W', function($join) use ($customerID) {
                    $join->on('W.product_id', '=', 'P.ProductID')
                        ->where('W.customer_id', '=', $customerID);
                })
                ->where('W.customer_id',$customerID)
                ->where('P.ActiveStatus',"Active")
                ->where('P.DFlag',0)
                ->where('VPM.Status', 1)
                ->WhereIn('VPM.VendorID', $AllVendors)
                ->groupBy('P.ProductID', 'P.ProductName', 'P.ProductImage')
                ->select('P.ProductID')
                ->count();

            $wishListDetails = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_products as P', 'P.ProductID', 'VPM.ProductID')
                ->leftJoin('tbl_wishlists as W', function($join) use ($customerID) {
                    $join->on('W.product_id', '=', 'P.ProductID')
                        ->where('W.customer_id', '=', $customerID);
                })
                ->where('W.customer_id',$customerID)
                ->where('P.ActiveStatus',"Active")
                ->where('P.DFlag',0)
                ->where('VPM.Status', 1)
                ->WhereIn('VPM.VendorID', $AllVendors)
                ->when($request->has('orderBy') && in_array($request->orderBy, ['new', 'popularity']), function ($query) use ($request) {
                    if ($request->orderBy == "new"){
                        return $query->orderBy('P.CreatedOn', 'desc');
                    } elseif ($request->orderBy == "popularity"){
                        return $query->orderBy('P.CreatedOn', 'asc');
                    }
                })
                ->groupBy('P.ProductID', 'P.ProductName', 'P.ProductImage')
                ->select('P.ProductID', 'P.ProductName',
                    DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'))
                ->skip(($pageNo - 1) * $productCount)
                ->take($productCount)
                ->get();

            return [
                'wishListDetails' => $wishListDetails,
                'totalWishListCount' => $wishListCount
            ];
        } else {
            return [
                'wishListDetails' => [],
                'totalWishListCount' => 0
            ];
        }
    }

    public function customerHomeSearch(Request $req)
    {
        if ($req->AID) {
            if ($req->SearchText) {
                $AllVendors = Helper::getAvailableVendorsForCustomer($req->AID);

                $PCategories = DB::table('tbl_product_category as PC')
                    ->rightJoin('tbl_vendors_product_mapping as VPM', 'PC.PCID', 'VPM.PCID')
                    ->where('VPM.Status', 1)
                    ->whereIn('VPM.VendorID', $AllVendors)
                    ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
                    ->where('PC.PCName', 'like', '%' . $req->SearchText . '%')
                    ->groupBy('PC.PCID', 'PC.PCName')
                    ->select('PC.PCID', 'PC.PCName')->take(3)->get();

                $PSCategories = DB::table('tbl_product_subcategory as PSC')
                    ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
                    ->rightJoin('tbl_vendors_product_mapping as VPM', 'PSC.PSCID', 'VPM.PSCID')
                    ->where('VPM.Status', 1)
                    ->whereIn('VPM.VendorID', $AllVendors)
                    ->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
                    ->where('PSC.PSCName', 'like', '%' . $req->SearchText . '%')
                    ->groupBy('PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName')
                    ->select('PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName')->take(3)->get();

                $Products = DB::table('tbl_products as P')
                    ->leftJoin('tbl_product_subcategory as PSC', 'P.SCID', 'PSC.PSCID')
                    ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
                    ->rightJoin('tbl_vendors_product_mapping as VPM', 'P.ProductID', 'VPM.ProductID')
                    ->where('VPM.Status', 1)
                    ->whereIn('VPM.VendorID', $AllVendors)
                    ->where('P.ActiveStatus', 'Active')->where('P.DFlag', 0)
                    ->where('P.ProductName', 'like', '%' . $req->SearchText . '%')
                    ->groupBy('P.ProductID', 'P.ProductName', 'PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName')
                    ->select('P.ProductID', 'P.ProductName', 'PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName')->take(3)->get();
                $resultHtml = view('home.customer.search-html', compact('PCategories', 'PSCategories', 'Products'))->render();

                return response()->json(['status' => true, 'searchResults' => $resultHtml]);
            } else {
                return response()->json(['status' => false, 'message' => "search text is empty"]);
            }
        } else {
            return response()->json(['status' => false, 'message' => "Shipping Address is required!"]);
        }
    }

    public function supportTableHtml(Request $request)
    {
        $productCount = ((int)($request->productCount) != 0) ? $request->productCount : 12;
        $pageNo = ($request->pageNo != 'undefined') ? $request->pageNo : 1;
        $viewType = $request->viewType ?? 'List';
        $orderBy = ($request->has('orderBy') && in_array($request->orderBy, ['asc', 'desc'])) ? $request->orderBy : 'desc';

        $supportDetails = $this->getSupportDetails($request);
        $totalSupportCount = $supportDetails['totalSupportCount'];
        $supportDetails = $supportDetails['supportDetails'];

        $totalPages = ceil($totalSupportCount / $productCount);
        $range = 3;
        if($pageNo > $totalPages){
            $pageNo = $request->pageNo = $totalPages;
            $supportDetails = $this->getSupportDetails($request);
            $supportDetails = $supportDetails['supportDetails'];
        }

        return view('home.customer.support-html', compact('supportDetails', 'productCount', 'pageNo', 'viewType', 'orderBy', 'range', 'totalPages'))->render();
    }

    public function getSupportDetails($request)
    {
        $customerID = $this->UserID;
        $productCount = ((int)($request->productCount) != 0) ? $request->productCount : 12;
        $pageNo = $request->pageNo ?? 1;
        $orderBy = ($request->has('orderBy') && in_array($request->orderBy, ['asc', 'desc'])) ? $request->orderBy : 'desc';
        $supportCount = DB::table($this->supportDB.'tbl_support as S')
            ->leftJoin('tbl_support_type as ST', 'ST.SLNO', 'S.SupportType')
            ->leftJoin('users as U', 'U.UserID', 'S.UserID')
            ->where('U.UserID',$customerID)
            ->select('S.SupportID')
            ->count();

        $supportDetails = DB::table($this->supportDB.'tbl_support as S')
            ->leftJoin('tbl_support_type as ST', 'ST.SLNO', 'S.SupportType')
            ->leftJoin('users as U', 'U.UserID', 'S.UserID')
            ->where('U.UserID', $customerID)
            ->orderBy('S.CreatedOn', $orderBy)
            ->select('S.SupportID', 'U.Name', 'ST.SupportType', 'S.Subject', 'S.Priority', 'S.Status', 'S.CreatedOn')
            ->skip(($pageNo - 1) * $productCount)
            ->take($productCount)
            ->get();
        return [
            'supportDetails' => $supportDetails,
            'totalSupportCount' => $supportCount
        ];
    }

    public function quotationTableHtml(Request $request)
    {
        $productCount = ((int)($request->productCount) != 0) ? $request->productCount : 12;
        $pageNo = ($request->pageNo != 'undefined') ? $request->pageNo : 1;
        $viewType = $request->viewType ?? 'List';
        $orderBy = ($request->has('orderBy') && in_array($request->orderBy, ['asc', 'desc'])) ? $request->orderBy : 'desc';

        $quotationDetails = $this->getQuotationDetails($request);
        $totalQuotationCount = $quotationDetails['totalQuotationCount'];
        $quotationDetails = $quotationDetails['quotationDetails'];

        $totalPages = ceil($totalQuotationCount / $productCount);
        $range = 3;
        if($pageNo > $totalPages){
            $pageNo = $request->pageNo = $totalPages;
            $quotationDetails = $this->getQuotationDetails($request);
            $quotationDetails = $quotationDetails['quotationDetails'];
        }
        return view('home.customer.quotations-html', compact('quotationDetails', 'productCount', 'pageNo', 'viewType', 'orderBy', 'range', 'totalPages'))->render();
    }

    public function getQuotationDetails($request)
    {
        $customerID = $this->ReferID;
        $productCount = ((int)($request->productCount) != 0) ? $request->productCount : 12;
        $pageNo = $request->pageNo ?? 1;

        $orderBy = ($request->has('orderBy') && in_array($request->orderBy, ['asc', 'desc'])) ? $request->orderBy : 'desc';
        $quotationCount = DB::table($this->CurrFyDB.'tbl_enquiry as E')
            ->leftJoin('users as U', 'U.UserID', 'E.CustomerID')
            ->where('U.UserID',$customerID)
            ->select('E.EnqNo')
            ->count();

        $quotationDetails = DB::table($this->CurrFyDB.'tbl_enquiry as E')
            ->leftJoin('users as U', 'U.UserID', 'E.CustomerID')
            ->where('E.CustomerID',$customerID)
            ->orderBy('E.CreatedOn', $orderBy)
            ->select('E.EnqNo', 'E.EnqDate', 'E.ExpectedDeliveryDate', 'E.Status', 'E.EnqID')
            ->skip(($pageNo - 1) * $productCount)
            ->take($productCount)
            ->get();
        return [
            'quotationDetails' => $quotationDetails,
            'totalQuotationCount' => $quotationCount
        ];
    }

    public function orderTableHtml(Request $request)
    {
        $productCount = ((int)($request->productCount) != 0) ? $request->productCount : 12;
        $pageNo = ($request->pageNo != 'undefined') ? $request->pageNo : 1;
        $viewType = $request->viewType ?? 'List';
        $orderBy = ($request->has('orderBy') && in_array($request->orderBy, ['asc', 'desc'])) ? $request->orderBy : 'desc';

        $orderDetails = $this->getOrderDetails($request);
        $totalOrderCount = $orderDetails['totalOrderCount'];
        $orderDetails = $orderDetails['orderDetails'];

        $totalPages = ceil($totalOrderCount / $productCount);
        $range = 3;
        if($pageNo > $totalPages){
            $pageNo = $request->pageNo = $totalPages;
            $orderDetails = $this->getOrderDetails($request);
            $orderDetails = $orderDetails['orderDetails'];
        }

        return view('home.customer.orders-html', compact('orderDetails', 'productCount', 'pageNo', 'viewType', 'orderBy', 'range', 'totalPages'))->render();
    }

    public function getOrderDetails($request)
    {
        $customerID = $this->ReferID;
        $productCount = ((int)($request->productCount) != 0) ? $request->productCount : 12;
        $pageNo = $request->pageNo ?? 1;

        $orderBy = ($request->has('orderBy') && in_array($request->orderBy, ['asc', 'desc'])) ? $request->orderBy : 'desc';
        $orderCount = DB::table($this->CurrFyDB.'tbl_order as O')
            ->leftJoin('users as U', 'U.UserID', 'O.CustomerID')
            ->where('O.CustomerID',$customerID)
            ->select('O.OrderNo')
            ->count();

        $orderDetails = DB::table($this->CurrFyDB.'tbl_order as O')
            ->leftJoin('users as U', 'U.UserID', 'O.CustomerID')
            ->where('O.CustomerID',$customerID)
            ->orderBy('O.CreatedOn', $orderBy)
            ->select('O.OrderNo', 'O.OrderDate', 'O.ExpectedDelivery', 'O.NetAmount', 'O.TotalPaidAmount', 'O.BalanceAmount', 'O.Status', 'O.PaymentStatus', 'O.OrderID', 'O.isRated')
            ->skip(($pageNo - 1) * $productCount)
            ->take($productCount)
            ->get();
        return [
            'orderDetails' => $orderDetails,
            'totalOrderCount' => $orderCount
        ];
    }

    public function CustomerOrderView(Request $req,$OrderID){
        $CustomerID = $this->ReferID;
        $FormData['Company'] = $this->Company;
//        $customerAid = Session::get('selected_aid');
//        $customerDefaultAid = DB::table('tbl_customer_address')->where('CustomerID', $CustomerID)->where('isDefault', true)->where('CA.DFlag',0)->first();
//        $AID = isset($customerAid) ? $customerAid : $customerDefaultAid->AID;
        $customerAid = Session::get('selected_aid');
        $customerDefaultAid = DB::table('tbl_customer_address')
            ->where('CustomerID', $CustomerID)
            ->where('isDefault', 1)
            ->where('DFlag',0)
            ->value('AID');

        if ($customerAid && DB::table('tbl_customer_address')->where('CustomerID', $CustomerID)->where('AID', $customerAid)->where('isDefault', 1)->where('DFlag',0)->exists()) {
            $AID = $customerAid;
        } else {
            $AID = $customerDefaultAid;
        }
        $AllVendors = Helper::getAvailableVendorsForCustomer($AID);
        $PCatagories = DB::table('tbl_vendors_product_mapping as VPM')
            ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'VPM.PCID')
            ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
            ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
            ->groupBy('PC.PCID', 'PC.PCName', 'PC.PCImage')
            ->select('PC.PCID', 'PC.PCName',
                DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
            ->inRandomOrder()->get();

        $FormData['PCategories'] = $PCatagories;
        $FormData['isRegister'] = false;
        $FormData['Cart'] = $this->getCart();
        $FormData['ShippingAddress'] = DB::table('tbl_customer_address as CA')->where('CustomerID', $CustomerID)->where('CA.DFlag',0)
            ->join($this->generalDB . 'tbl_countries as C', 'C.CountryID', 'CA.CountryID')
            ->join($this->generalDB . 'tbl_states as S', 'S.StateID', 'CA.StateID')
            ->join($this->generalDB . 'tbl_districts as D', 'D.DistrictID', 'CA.DistrictID')
            ->join($this->generalDB . 'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
            ->join($this->generalDB . 'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
            ->join($this->generalDB . 'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
            ->select('CA.AID', 'CA.Address', 'CA.isDefault', 'CA.CountryID', 'C.CountryName', 'CA.StateID', 'S.StateName', 'CA.DistrictID', 'D.DistrictName', 'CA.TalukID', 'T.TalukName', 'CA.CityID', 'CI.CityName', 'CA.PostalCodeID', 'PC.PostalCode')
            ->get();

            $FormData['OrderID']=$OrderID;
            $FormData['OData']= $this->getCustomerOrder(["OrderID"=>$OrderID]);
            if(count($FormData['OData'])>0){
                $FormData['OData']=$FormData['OData'][0];
                return view('home.customer.order-details', $FormData);
            }else{
                return view('errors.403');
            }
    }

    public function CustomerQuoteView(Request $req, $EnqID)
    {
        $CustomerID = $this->ReferID;
        $quotation = DB::table($this->CurrFyDB . 'tbl_quotation')->where("CustomerID", $CustomerID)->where("EnqID", $EnqID)->first();
        $enquiry = DB::table($this->CurrFyDB . 'tbl_enquiry')->where("CustomerID", $CustomerID)->where("EnqID", $EnqID)->first();
        if ($quotation) {
            return $this->renderQuotationView($quotation);
        } elseif ($enquiry) {
            return $this->renderEnquiryView($EnqID);
        } else {
            return view('errors.403');
        }
    }

    private function renderQuotationView($quotation)
    {
        $FormData = $this->prepareQuoteFormData($quotation->QID);
        return view('home.customer.quote-view', $FormData);
    }

    private function renderEnquiryView($EnqID)
    {
        $FormData = $this->EnquiryDetails($EnqID);
        $FormData['Company'] = $this->Company;
        $PCategories = $this->getRandomProductCategories();
        $FormData['PCategories'] = $PCategories;
        $FormData['isRegister'] = false;
        $FormData['Cart'] = $this->getCart();
        $FormData['ShippingAddress'] = $this->shippingAddress;

        return view('home.customer.enquiry-view', $FormData);
    }

    private function prepareQuoteFormData($QID)
    {
        $FormData['isEdit'] = false;
        $FormData['Company'] = $this->Company;
        $FormData['QData'] = $this->getQuotes(["QID" => $QID]);
        $FormData['QID'] = $QID;
        $FormData['isRegister'] = false;
        $FormData['Cart'] = $this->getCart();
        $PCategories = $this->getRandomProductCategories();
        $FormData['PCategories'] = $PCategories;
        $FormData['ShippingAddress'] = $this->shippingAddress;
        if (count($FormData['QData']) > 0) {
            $FormData['QData'] = $FormData['QData'][0];
        }
        return $FormData;
    }

    private function getRandomProductCategories()
    {
        return DB::table('tbl_product_category')->where('ActiveStatus', 'Active')->where('DFlag', 0)
            ->select('PCName', 'PCID', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
            ->inRandomOrder()->take(10)->get();
    }
    public function getQuotes($data=array()){
        $sql ="SELECT Q.QID, Q.EnqID, Q.QNo, Q.QDate, Q.QExpiryDate, Q.CustomerID, Q.AID, C.CustomerName, C.MobileNo1, C.MobileNo2, C.Email, C.Address as BAddress, C.CountryID as BCountryID, BC.CountryName as BCountryName, ";
        $sql.=" C.StateID as BStateID, BS.StateName as BStateName, C.DistrictID as BDistrictID, BD.DistrictName as BDistrictName, C.TalukID, BT.TalukName as BTalukName, C.CityID as BCityID, BCI.CityName as BCityName, C.PostalCodeID as BPostalCodeID, ";
        $sql.=" BPC.PostalCode as BPostalCode, BC.PhoneCode, Q.ReceiverName, Q.ReceiverMobNo, Q.DAddress, Q.DCountryID, CO.CountryName as DCountryName, Q.DStateID, S.StateName as DStateName, Q.DDistrictID, D.DistrictName as DDistrictName, Q.DTalukID, ";
        $sql.=" T.TalukName as DTalukName, Q.DCityID, CI.CityName as DCityName, Q.DPostalCodeID, PC.PostalCode as DPostalCode, Q.TaxAmount, Q.SubTotal, Q.DiscountType, Q.DiscountPercent as DiscountPercentage, Q.DiscountAmount, Q.CGSTAmount, ";
        $sql.=" Q.SGSTAmount, Q.IGSTAmount, Q.TotalAmount, Q.AdditionalCost, Q.OverAllAmount as NetAmount, Q.AdditionalCostData, Q.Status, Q.AcceptedOn, Q.RejectedOn, Q.ApprovedBy, Q.RejectedBy, Q.RReasonID, RR.RReason, Q.RRDescription ";
        $sql.=" FROM ".$this->CurrFyDB."tbl_quotation as Q LEFT JOIN tbl_customer as C ON C.CustomerID=Q.CustomerID LEFT JOIN ".$this->generalDB."tbl_countries as BC ON BC.CountryID=C.CountryID  ";
        $sql.=" LEFT JOIN ".$this->generalDB."tbl_states as BS ON BS.StateID=C.StateID LEFT JOIN ".$this->generalDB."tbl_districts as BD ON BD.DistrictID=C.DistrictID  ";
        $sql.=" LEFT JOIN ".$this->generalDB."tbl_taluks as BT ON BT.TalukID=C.TalukID LEFT JOIN ".$this->generalDB."tbl_cities as BCI ON BCI.CityID=C.CityID ";
        $sql.=" LEFT JOIN ".$this->generalDB."tbl_postalcodes as BPC ON BPC.PID=C.PostalCodeID LEFT JOIN ".$this->generalDB."tbl_countries as CO ON CO.CountryID=Q.DCountryID  ";
        $sql.=" LEFT JOIN ".$this->generalDB."tbl_states as S ON S.StateID=Q.DStateID LEFT JOIN ".$this->generalDB."tbl_districts as D ON D.DistrictID=Q.DDistrictID ";
        $sql.=" LEFT JOIN ".$this->generalDB."tbl_taluks as T ON T.TalukID=Q.DTalukID LEFT JOIN ".$this->generalDB."tbl_cities as CI ON CI.CityID=Q.DCityID ";
        $sql.=" LEFT JOIN ".$this->generalDB."tbl_postalcodes as PC ON PC.PID=Q.DPostalCodeID LEFT JOIN tbl_reject_reason as RR ON RR.RReasonID=Q.RReasonID ";
        $sql.=" Where 1=1 ";
        if(is_array($data)){
            if(array_key_exists("QID",$data)){$sql.=" AND Q.QID='".$data['QID']."'";}
        }
        $result=DB::SELECT($sql);
        for($i=0;$i<count($result);$i++){
            $result[$i]->AdditionalCostData=unserialize($result[$i]->AdditionalCostData);
            $sql="SELECT QD.DetailID, QD.QID, QD.VQDetailID, QD.ProductID, P.ProductName, P.HSNSAC, P.UID, U.UCode, U.UName, QD.Qty, QD.Price, QD.TaxType, QD.TaxPer, QD.Taxable, QD.DiscountType, QD.DiscountPer, QD.DiscountAmt, QD.TaxAmt, QD.CGSTPer, QD.SGSTPer, QD.IGSTPer, QD.CGSTAmt, QD.SGSTAmt, QD.IGSTAmt, QD.TotalAmt, QD.VendorID, V.VendorName, QD.isCancelled, QD.CancelledBy, QD.CancelledOn, QD.ReasonID, RR.RReason, QD.RDescription  ";
            $sql.=" FROM ".$this->CurrFyDB."tbl_quotation_details as QD LEFT JOIN tbl_products as P ON P.ProductID=QD.ProductID LEFT JOIN tbl_uom as U ON U.UID=P.UID LEFT JOIN tbl_reject_reason as RR ON RR.RReasonID=QD.ReasonID LEFT JOIN tbl_vendors as V ON V.VendorID=QD.VendorID ";
            $sql.=" Where QD.QID='".$result[$i]->QID."' and QD.isCancelled=0 ";
            $result[$i]->Details=DB::SELECT($sql);
            $addCharges=[];
            $result1=DB::Table($this->CurrFyDB.'tbl_vendor_quotation')->Where('EnqID',$result[$i]->EnqID)->get();
            foreach($result1 as $tmp){
                $addCharges[$tmp->VendorID]=Helper::NumberFormat($tmp->AdditionalCost, 2);
            }
            $result[$i]->AdditionalCharges=$addCharges;
        }
        return $result;
    }

    public function EnquiryDetails($EnqID){
        $EnqData = DB::Table($this->CurrFyDB . 'tbl_enquiry as E')
            ->leftJoin('tbl_customer as CU', 'CU.CustomerID', 'E.CustomerID')
            ->leftJoin($this->generalDB.'tbl_countries as C','C.CountryID','CU.CountryID')
            ->leftJoin($this->generalDB.'tbl_states as S', 'S.StateID', 'CU.StateID')
            ->leftJoin($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'CU.DistrictID')
            ->leftJoin($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'CU.TalukID')
            ->leftJoin($this->generalDB.'tbl_cities as CI', 'CI.CityID', 'CU.CityID')
            ->leftJoin($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'CU.PostalCodeID')
            ->leftJoin($this->generalDB.'tbl_countries as DC','DC.CountryID','E.DCountryID')
            ->leftJoin($this->generalDB.'tbl_states as DS', 'DS.StateID', 'E.DStateID')
            ->leftJoin($this->generalDB.'tbl_districts as DD', 'DD.DistrictID', 'E.DDistrictID')
            ->leftJoin($this->generalDB.'tbl_taluks as DT', 'DT.TalukID', 'E.DTalukID')
            ->leftJoin($this->generalDB.'tbl_cities as DCI', 'DCI.CityID', 'E.DCityID')
            ->leftJoin($this->generalDB.'tbl_postalcodes as DPC', 'DPC.PID', 'E.DPostalCodeID')
            ->Where('E.EnqID',$EnqID)
            ->select('EnqID','EnqNo','EnqDate','VendorIDs','Status','ReceiverName','ReceiverMobNo','ExpectedDeliveryDate','CU.Email','DPostalCodeID','E.DPostalCodeID','E.DAddress','C.CountryName','S.StateName','D.DistrictName','T.TalukName','CU.Address','CI.CityName','PC.PostalCode','DAddress','DC.CountryName as DCountryName','DS.StateName as DStateName','DD.DistrictName as DDistrictName','DT.TalukName as DTalukName','DCI.CityName as DCityName','DPC.PostalCode as DPostalCode')
            ->first();
        $FormData['EnqData']=$EnqData;
        if($EnqData){
            $VendorQuote = [];
            $FinalQuoteData = [];
            $PData=DB::table($this->CurrFyDB.'tbl_enquiry_details as ED')->leftJoin('tbl_products as P','P.ProductID','ED.ProductID')->leftJoin('tbl_uom as UOM','UOM.UID','ED.UOMID')->where('ED.EnqID',$EnqID)->select('ED.ProductID','ED.CID','ED.SCID','ED.Qty','P.ProductName','UOM.UID','UOM.UName','UOM.UCode')->get();
            if(count($PData) > 0){
                foreach($PData as $row){
                    $row->AvailableVendors=[];
                    $AllVendors = DB::table('tbl_vendors as V')->join('tbl_vendors_service_locations as VSL','V.VendorID','VSL.VendorID')->leftJoin('tbl_vendor_ratings as VR','VR.VendorID','V.VendorID')->where('V.ActiveStatus',"Active")->where('V.isApproved',1)->where('V.DFlag',0)->where('VSL.PostalCodeID',$FormData['EnqData']->DPostalCodeID)->select('V.VendorID','V.VendorName','VR.OverAll')->get();
                    if(count($AllVendors)>0){
                        foreach($AllVendors as $item){
                            $isProductAvailable= DB::Table('tbl_vendors_product_mapping')->where('Status',1)->Where('VendorID',$item->VendorID)->where('ProductID',$row->ProductID)->first();
                            if($isProductAvailable){
                                $row->AvailableVendors[] = [
                                    "VendorID" => $item->VendorID,
                                    "VendorName" => $item->VendorName,
                                    "OverAll" => $item->OverAll,
                                    "ProductID" => $isProductAvailable->ProductID,
                                ];
                            }
                        }
                    }
                }
            }
            if($EnqData->Status == "Quote Requested" && $EnqData->VendorIDs && count(unserialize($EnqData->VendorIDs)) > 0){
                $VendorQuote = DB::Table($this->CurrFyDB.'tbl_vendor_quotation as VQ')->join('tbl_vendors as V','V.VendorID','VQ.VendorID')/* ->where('VQ.Status','Sent') */->where('VQ.EnqID',$EnqID)->select('VQ.VendorID','V.VendorName','VQ.VQuoteID','VQ.Status','VQ.AdditionalCost')->get();
                foreach($VendorQuote as $row){
                    $row->ProductData = DB::table($this->CurrFyDB.'tbl_vendor_quotation_details as VQD')->where('VQuoteID',$row->VQuoteID)
                        ->select('DetailID','ProductID','Price','VQuoteID')
                        ->get();
                }
            }elseif($EnqData->Status == "Converted to Quotation"){
                $FinalQuoteData = DB::Table($this->CurrFyDB.'tbl_quotation_details as QD')->join($this->CurrFyDB.'tbl_quotation as Q','Q.QID','QD.QID')->join('tbl_vendors as V','V.VendorID','QD.VendorID')->join('tbl_products as P','P.ProductID','QD.ProductID')->join('tbl_uom as UOM','UOM.UID','P.UID')->where('Q.EnqID',$EnqID)->get();
            }

            $FormData['PData'] = $PData;
            $FormData['VendorQuote'] = $VendorQuote;
            $FormData['FinalQuoteData'] = $FinalQuoteData;
            return $FormData;

        }else{
            return '';
        }
    }

    public function getCustomerOrder($data=array()){
        $sql ="SELECT O.OrderID, O.OrderNo, O.OrderDate, O.QID, O.EnqID, O.ExpectedDelivery, O.CustomerID, C.CustomerName, C.MobileNo1, C.MobileNo2, C.Email, C.Address as BAddress, C.CountryID as BCountryID, BC.CountryName as BCountryName, ";
        $sql.=" C.StateID as BStateID, BS.StateName as BStateName, C.DistrictID as BDistrictID, BD.DistrictName as BDistrictName, C.TalukID, BT.TalukName as BTalukName, C.CityID as BCityID, BCI.CityName as BCityName, C.PostalCodeID as BPostalCodeID, ";
        $sql.=" BPC.PostalCode as BPostalCode, BC.PhoneCode, O.ReceiverName, O.ReceiverMobNo, O.DAddress, O.DCountryID, CO.CountryName as DCountryName, O.DStateID, S.StateName as DStateName, O.DDistrictID, D.DistrictName as DDistrictName, O.DTalukID, ";
        $sql.=" T.TalukName as DTalukName, O.DCityID, CI.CityName as DCityName, O.DPostalCodeID, PC.PostalCode as DPostalCode, O.TaxAmount, O.SubTotal, O.DiscountType, O.DiscountPercentage, O.DiscountAmount, O.CGSTAmount, ";
        $sql.=" O.SGSTAmount, O.IGSTAmount, O.TotalAmount, O.AdditionalCost, O.NetAmount, O.PaidAmount, O.BalanceAmount, O.PaymentStatus,  O.AdditionalCostData, O.Status,  O.RejectedOn,  O.RejectedBy, O.ReasonID, RR.RReason, O.RDescription ";
        $sql.=" FROM ".$this->CurrFyDB."tbl_order as O LEFT JOIN tbl_customer as C ON C.CustomerID=O.CustomerID LEFT JOIN ".$this->generalDB."tbl_countries as BC ON BC.CountryID=C.CountryID  ";
        $sql.=" LEFT JOIN ".$this->generalDB."tbl_states as BS ON BS.StateID=C.StateID LEFT JOIN ".$this->generalDB."tbl_districts as BD ON BD.DistrictID=C.DistrictID  ";
        $sql.=" LEFT JOIN ".$this->generalDB."tbl_taluks as BT ON BT.TalukID=C.TalukID LEFT JOIN ".$this->generalDB."tbl_cities as BCI ON BCI.CityID=C.CityID ";
        $sql.=" LEFT JOIN ".$this->generalDB."tbl_postalcodes as BPC ON BPC.PID=C.PostalCodeID LEFT JOIN ".$this->generalDB."tbl_countries as CO ON CO.CountryID=O.DCountryID  ";
        $sql.=" LEFT JOIN ".$this->generalDB."tbl_states as S ON S.StateID=O.DStateID LEFT JOIN ".$this->generalDB."tbl_districts as D ON D.DistrictID=O.DDistrictID ";
        $sql.=" LEFT JOIN ".$this->generalDB."tbl_taluks as T ON T.TalukID=O.DTalukID LEFT JOIN ".$this->generalDB."tbl_cities as CI ON CI.CityID=O.DCityID ";
        $sql.=" LEFT JOIN ".$this->generalDB."tbl_postalcodes as PC ON PC.PID=O.DPostalCodeID LEFT JOIN tbl_reject_reason as RR ON RR.RReasonID=O.ReasonID ";
        $sql.=" Where 1=1 ";
        if(is_array($data)){
            if(array_key_exists("OrderID",$data)){$sql.=" AND O.OrderID='".$data['OrderID']."'";}
        }
        $result=DB::SELECT($sql);
        for($i=0;$i<count($result);$i++){
            $result[$i]->AdditionalCostData=unserialize($result[$i]->AdditionalCostData);
            $sql="SELECT OD.DetailID, OD.OrderID, OD.QID, OD.QDID, OD.VOrderID, OD.ProductID, P.ProductName, P.HSNSAC, P.UID, U.UCode, U.UName, OD.Qty, OD.Price, OD.TaxType, OD.TaxPer, OD.Taxable, OD.DiscountType, OD.DiscountPer, OD.DiscountAmt, OD.TaxAmt, OD.CGSTPer, OD.SGSTPer, OD.IGSTPer, OD.CGSTAmt, OD.SGSTAmt, OD.IGSTAmt, OD.TotalAmt, OD.VendorID, V.VendorName, OD.Status, OD.RejectedBy, OD.RejectedOn, OD.ReasonID, RR.RReason, OD.RDescription, OD.DeliveredOn, OD.DeliveredBy  ";
            $sql.=" FROM ".$this->CurrFyDB."tbl_order_details as OD LEFT JOIN tbl_products as P ON P.ProductID=OD.ProductID LEFT JOIN tbl_uom as U ON U.UID=P.UID LEFT JOIN tbl_reject_reason as RR ON RR.RReasonID=OD.ReasonID LEFT JOIN tbl_vendors as V ON V.VendorID=OD.VendorID ";
            $sql.=" Where OD.OrderID='".$result[$i]->OrderID."' Order By OD.DetailID ";
            $result[$i]->Details=DB::SELECT($sql);
            $addCharges=[];
            $result1=DB::Table($this->CurrFyDB.'tbl_vendor_quotation')->Where('EnqID',$result[$i]->EnqID)->get();
            foreach($result1 as $tmp){
                $addCharges[$tmp->VendorID]=Helper::NumberFormat($tmp->AdditionalCost,2);
            }
            $result[$i]->AdditionalCharges=$addCharges;

        }
        return $result;
    }

    public function profileHtml()
    {
        $CustomerID = $this->ReferID;
        $FormData['Company']=$this->Company;
        $FormData['UserData']=$this->UserData['data'];
        $FormData['PCategories']=$this->PCategories;
        $FormData['isEdit']=true;
        $FormData['isRegister']=true;
        $FormData['Cart']=$this->getCart();
        $FormData['EditData'] = DB::table('tbl_customer')->where('DFlag',0)->Where('CustomerID',$CustomerID)->first();
        $FormData['defaultAddressAID'] = DB::table('tbl_customer_address')->where('DFlag',0)->Where('CustomerID',$CustomerID)->where('isDefault', 1)->where('DFlag',0)->pluck('AID')->first();
        if($FormData['EditData']) {
            $FormData['EditData']->CustomerImage = $FormData['EditData']->CustomerImage ? url('/') . '/' . $FormData['EditData']->CustomerImage : url('/') . '/' . 'assets/images/no-image-b.png';
            $FormData['EditData']->PostalCode = DB::table($this->generalDB . 'tbl_postalcodes as P')->where('PID', $FormData['EditData']->PostalCodeID)->value('PostalCode');
            $FormData['EditData']->SAddress = DB::table('tbl_customer_address as CA')->where('CustomerID', $CustomerID)->where('CA.DFlag', 0)
                ->join($this->generalDB . 'tbl_countries as C', 'C.CountryID', 'CA.CountryID')
                ->join($this->generalDB . 'tbl_states as S', 'S.StateID', 'CA.StateID')
                ->join($this->generalDB . 'tbl_districts as D', 'D.DistrictID', 'CA.DistrictID')
                ->join($this->generalDB . 'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
                ->join($this->generalDB . 'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
                ->join($this->generalDB . 'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
                ->select('CA.AID', 'CA.Address', 'CA.isDefault', 'CA.CountryID', 'C.CountryName', 'CA.StateID', 'S.StateName', 'CA.DistrictID', 'D.DistrictName', 'CA.TalukID', 'T.TalukName', 'CA.CityID', 'CI.CityName', 'CA.PostalCodeID', 'PC.PostalCode')
                ->get();
            return view('home.customer.profile-html', $FormData)->render();
        } else {
            return "<p> Profile not found!</p>";
        }
    }

    public function customerReviewSave(Request $req){
        DB::beginTransaction();
        try {
            $isOrderCompleted = DB::Table($this->CurrFyDB.'tbl_order')->where('OrderID',$req->OrderID)
                ->where('Status','Delivered')->exists();
            if(!$isOrderCompleted){
                return response()->json(['status' => false,'message' => "Order is not Delivered!"]);
            }else{
                DB::Table($this->CurrFyDB.'tbl_order')->where('OrderID',$req->OrderID)
                    ->update(['Ratings'=>$req->Ratings,'Review'=>$req->Review,'isRated'=>1,'RatedOn'=>date('Y-m-d'),
                        'UpdatedOn'=>date('Y-m-d H:i:s')]);
                DB::commit();
                return response()->json(['status' => true ,'message' => "Order Rated Successfully!"]);
            }
        }catch(Exception $e) {
            logger($e);
            DB::rollback();
            return response()->json(['status' => false,'message' => "Order Rating Failed!"]);
        }
    }
    public function UpdateShippingAddress(Request $req){
        $CustomerID = $this->ReferID;
        if(!$CustomerID){
            $CustomerID = auth()->user()->UserID;
        }
        $OldData=$NewData=[];
        $OldData=DB::table('tbl_customer_address')->where('CustomerID',$CustomerID)->where('DFlag',0)->get();
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
                $status = DB::table($this->CurrFyDB.'tbl_not_serving_locations')->insert($data);
                if($status){
                    return response()->json(['status' => false,'message' => "Postal Code does not exist!"]);
                }
            }else{
                DB::beginTransaction();
                $MapData = serialize(json_decode($req->MapData));
                $AID=DocNum::getDocNum(docTypes::CustomerAddress->value,"",Helper::getCurrentFY());
                $address = helper::trimAddress($req->CompleteAddress);
                $data=array(
                    "AID"=>$AID,
                    "CustomerID"=>$CustomerID,
                    "CompleteAddress"=>$req->CompleteAddress,
                    "Address"=>$address,
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
                $status = DB::Table('tbl_customer_address')->insert($data);
                if($status==true){
                    DB::Table('tbl_customer_address')->where('CustomerID',$CustomerID)->whereNot('AID',$AID)->where('DFlag',0)->update(['isDefault' =>0]);
                    DocNum::updateDocNum(docTypes::CustomerAddress->value);
                }
            }
        }catch(Exception $e) {
            logger($e);
            $status=false;
        }
        if($status==true){
            DB::commit();
            DB::Table('tbl_customer_cart')->where('CustomerID',$CustomerID)->delete();
            $NewData=DB::table('tbl_customer_address')->where('CustomerID',$CustomerID)->where('DFlag',0)->get();
            $logData=array("Description"=>"Shipping Address Updated","ModuleName"=>"Customer","Action"=>"Update","ReferID"=>$AID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
            logs::Store($logData);
            return response()->json(['status' => true,'message' => "Shipping Address Updated Successfully", 'AID' => $AID, 'data' => $data]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Shipping Address Update Failed"]);
        }
    }
    public function SetAddressDefault(Request $req){
        $CustomerID = $this->ReferID;
        if(!$CustomerID){
            $CustomerID = auth()->user()->UserID;
        }
        DB::beginTransaction();
        $status=false;
        try {
            $status=DB::Table('tbl_customer_address')->where('CustomerID',$CustomerID)->whereNot('AID',$req->AID)->where('DFlag',0)->update(['isDefault' =>0]);
            $status=DB::Table('tbl_customer_address')->where('CustomerID',$CustomerID)->where('AID',$req->AID)->where('DFlag',0)->update(['isDefault' =>1,'UpdatedBy'=>$CustomerID,'UpdatedOn'=>date("Y-m-d H:i:s")]);
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

    public function DeleteShippingAddress(Request $req){
        $CustomerID = $this->ReferID;
        if(!$CustomerID){
            $CustomerID = auth()->user()->UserID;
        }
        DB::beginTransaction();
        $status=false;
        try {
            $isDefault=DB::Table('tbl_customer_address')->where('CustomerID',$CustomerID)->where('AID',$req->AID)->where('DFlag',0)->where('isDefault',1)->exists();
            if($isDefault){
                return response()->json(['status' => false,'message' => "Default Address cannot be deleted!"]);
            }else{
                $status=DB::Table('tbl_customer_address')->where('CustomerID',$CustomerID)->where('AID',$req->AID)->where('DFlag',0)->update(['DFlag'=>1,'UpdatedBy'=>$CustomerID,'UpdatedOn'=>date('Y-m-d H:i:s')]);
            }
        }catch(Exception $e) {
            logger($e);
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


    public function QuoteCancel(request $req,$QID){
            DB::beginTransaction();
            $tdata=array(
                "Status"=>"Rejected",
                "RReasonID"=>$req->ReasonID,
                "RRDescription"=>$req->Description,
                "RejectedOn"=>now(),
                "RejectedBy"=>$this->UserID
            );
            $status=DB::Table($this->CurrFyDB."tbl_quotation")->where('QID',$QID)->update($tdata);

            if($status==true){
                DB::commit();
                return array('status'=>true,'message'=>"Quote Successfully Canceled");
            }else {
                DB::rollback();
                return array('status' => false, 'message' => "Failed to Cancel Quote");
            }
    }
    public function QuoteItemCancel(request $req,$DetailID){
            DB::beginTransaction();
            $status=false;
            $tdata=array(
                "isCancelled"=>"1",
                "ReasonID"=>$req->ReasonID,
                "RDescription"=>$req->Description,
                "CancelledOn"=>now(),
                "CancelledBy"=>$this->UserID
            );
            //item cancel
            $status=DB::Table($this->CurrFyDB."tbl_quotation_details")->where('QID',$req->QID)->where('DetailID',$DetailID)->update($tdata);

            // Verify if all items have been cancelled. If all items are cancelled, update the status in the main quotation table.
            if($status){
                $t=DB::Table($this->CurrFyDB."tbl_quotation_details")->where('QID',$req->QID)->where('isCancelled',0)->count();
                if(intval($t)<=0){
                    $tdata=array(
                        "Status"=>"Rejected",
                        "RReasonID"=>$req->ReasonID,
                        "RRDescription"=>$req->Description,
                        "RejectedOn"=>now(),
                        "RejectedBy"=>$this->UserID
                    );
                    $status=DB::Table($this->CurrFyDB."tbl_quotation")->where('QID',$req->QID)->update($tdata);
                }
            }

            // Update Tax Amount, Total Amount, Subtotal, and Net Amount for non-cancelled items in the quotation table.
            if($status){
                $tdata=["TaxAmount"=>0,"CGSTAmount"=>0,"IGSTAmount"=>0,"SGSTAmount"=>0,"TotalAmount"=>0,"SubTotal"=>0,"DiscountAmount"=>0,"AdditionalCost"=>0,"OverAllAmount"=>0];
                $sql="SELECT IFNULL(SUM(TaxAmt),0) as TaxAmount, IFNULL(SUM(CGSTAmt),0) as CGSTAmount, IFNULL(SUM(IGSTAmt),0) as IGSTAmount, IFNULL(SUM(SGSTAmt),0) as SGSTAmount, SUM(TotalAmt) as TotalAmount, IFNULL(SUM(Taxable),0) as SubTotal FROM ".$this->CurrFyDB."tbl_quotation_details where QID='".$req->QID."' and isCancelled=0";
                $result=DB::SELECT($sql);
                foreach($result as $tmp){
                    $tdata['TaxAmount']+=floatval($tmp->TaxAmount);
                    $tdata['CGSTAmount']+=floatval($tmp->CGSTAmount);
                    $tdata['IGSTAmount']+=floatval($tmp->IGSTAmount);
                    $tdata['SGSTAmount']+=floatval($tmp->SGSTAmount);
                    $tdata['TotalAmount']+=floatval($tmp->TotalAmount);
                    $tdata['SubTotal']+=floatval($tmp->SubTotal);
                }
                $result=DB::Table($this->CurrFyDB."tbl_quotation")->where('QID',$req->QID)->get();
                foreach($result as $tmp){
                    $tdata['DiscountAmount']+=floatval($tmp->DiscountAmount);
                    $tdata['AdditionalCost']+=floatval($tmp->AdditionalCost);
                }
                $tdata['TotalAmount']=floatval($tdata['SubTotal'])+floatval($tdata['CGSTAmount'])+floatval($tdata['IGSTAmount'])+floatval($tdata['SGSTAmount']);
                $tdata['TotalAmount']-=floatval($tdata['DiscountAmount']);

                $tdata['OverAllAmount']=floatval($tdata['TotalAmount'])+floatval($tdata['AdditionalCost']);
                $tdata['UpdatedOn']=date("Y-m-d",strtotime("1 minutes"));
                $tdata['UpdatedBy']=$this->UserID;
                $status=DB::Table($this->CurrFyDB."tbl_quotation")->where('QID',$req->QID)->update($tdata);
            }
            if($status==true){
                DB::commit();
                return array('status'=>true,'message'=>"Quote Successfully Canceled");
            }else{
                DB::rollback();
                return array('status'=>false,'message'=>"Failed to Cancel Quote");
            }
    }
    public function QuoteApprove(Request $req,$QID){
            $data=$this->getQuotes(["QID"=>$QID]);
            $status=true;
            DB::beginTransaction();
            try {
                if(count($data)>0){
                    $data=$data[0];
                    $OrderID=DocNum::getDocNum(docTypes::Order->value, $this->CurrFyDB,Helper::getCurrentFy());
                    $OrderNo=DocNum::getInvNo(docTypes::Order->value);
                    $tdata=[
                        "OrderID"=>$OrderID,
                        "OrderNo"=>$OrderNo,
                        "OrderDate"=>date("Y-m-d"),
                        "ExpectedDelivery"=>date("Y-m-d",strtotime($req->ExpectedDelivery)),
                        "QID"=>$QID,
                        "EnqID"=>$data->EnqID,
                        "CustomerID"=>$data->CustomerID,
                        "AID"=>$data->AID,
                        "ReceiverName"=>$data->ReceiverName,
                        "ReceiverMobNo"=>$data->ReceiverMobNo,
                        "DAddress"=>$data->DAddress,
                        "DCountryID"=>$data->DCountryID,
                        "DStateID"=>$data->DStateID,
                        "DDistrictID"=>$data->DDistrictID,
                        "DTalukID"=>$data->DTalukID,
                        "DCityID"=>$data->DCityID,
                        "DPostalCodeID"=>$data->DPostalCodeID,
                        "Status"=>"New",
                        "TaxAmount"=>$data->TaxAmount,
                        "SubTotal"=>$data->SubTotal,
                        "DiscountType"=>$data->DiscountType,
                        "DiscountPercentage"=>$data->DiscountPercentage,
                        "DiscountAmount"=>$data->DiscountAmount,
                        "CGSTAmount"=>$data->CGSTAmount,
                        "SGSTAmount"=>$data->SGSTAmount,
                        "IGSTAmount"=>$data->IGSTAmount,
                        "TotalAmount"=>$data->TotalAmount,
                        "AdditionalCost"=>$data->AdditionalCost,
                        "NetAmount"=>$data->NetAmount,
                        "PaidAmount"=>0,
                        "BalanceAmount"=>$data->NetAmount,
                        "PaymentStatus"=>"Unpaid",
                        "AdditionalCostData"=> serialize($data->AdditionalCostData),
                        "CreatedOn"=>now(),
                        "CreatedBy"=>$this->UserID
                    ];
                    $status=DB::table($this->CurrFyDB.'tbl_order')->insert($tdata);
                    $status=DB::table($this->CurrFyDB.'tbl_enquiry')->where('EnqID', $data->EnqID)->update(['status' => 'Accepted']);
                    if($status){
                        DocNum::updateDocNum(docTypes::Order->value, $this->CurrFyDB);
                        DocNum::updateInvNo(docTypes::Order->value);
                        $details=$data->Details;
                        foreach($details as $item){
                            if($status){
                                $DetailID=DocNum::getDocNum(docTypes::OrderDetails->value, $this->CurrFyDB,Helper::getCurrentFy());
                                $tdata=array(
                                    "DetailID"=>$DetailID,
                                    "OrderID"=>$OrderID,
                                    "QID"=>$QID,
                                    "QDID"=>$item->DetailID,
                                    "ProductID"=>$item->ProductID,
                                    "Qty"=>$item->Qty,
                                    "Price"=>$item->Price,
                                    "TaxType"=>$item->TaxType,
                                    "TaxPer"=>$item->TaxPer,
                                    "Taxable"=>$item->Taxable,
                                    "DiscountType"=>$item->DiscountType,
                                    "DiscountPer"=>$item->DiscountPer,
                                    "DiscountAmt"=>$item->DiscountAmt,
                                    "TaxAmt"=>$item->TaxAmt,
                                    "CGSTPer"=>$item->CGSTPer,
                                    "SGSTPer"=>$item->SGSTPer,
                                    "IGSTPer"=>$item->IGSTPer,
                                    "CGSTAmt"=>$item->CGSTAmt,
                                    "SGSTAmt"=>$item->SGSTAmt,
                                    "IGSTAmt"=>$item->IGSTAmt,
                                    "TotalAmt"=>$item->TotalAmt,
                                    "VendorID"=>$item->VendorID,
                                    "CreatedOn"=>now(),
                                    "CreatedBy"=>$this->UserID
                                );
                                $status=DB::table($this->CurrFyDB.'tbl_order_details')->insert($tdata);
                                if($status){
                                    DocNum::updateDocNum(docTypes::OrderDetails->value, $this->CurrFyDB);
                                }
                            }
                        }
                    }
                    //save orders to vendors;
                    $sql="SELECT OrderID,QID,VendorID,Sum(Taxable) as SubTotal,Sum(TaxAmt) as TaxAmount, Sum(CGSTAmt) as CGSTAmount, Sum(SGSTAmt) as SGSTAmount, Sum(IGSTAmt) as IGSTAmount, Sum(TotalAmt) as TotalAmount  FROM ".$this->CurrFyDB."tbl_order_details Where OrderID='".$OrderID."' Group By OrderID,QID,VendorID";
                    $result=DB::SELECT($sql);
                    foreach($result as $item){
                        if($status){
                            $sql="SELECT AdditionalCost FROM ".$this->CurrFyDB."tbl_vendor_quotation Where VendorID='".$item->VendorID."' and EnqID in(Select EnqID From ".$this->CurrFyDB."tbl_quotation Where QID='".$item->QID."')";
                            $tmp=DB::SELECT($sql);
                            $additionalCharges=0;
                            foreach($tmp as $t){
                                $additionalCharges+=floatval($t->AdditionalCost);
                            }
                            $VOrderID=DocNum::getDocNum(docTypes::VendorOrders->value, $this->CurrFyDB,Helper::getCurrentFy());
                            $VOrderNo=DocNum::getInvNo(docTypes::VendorOrders->value);
                            $tdata=[
                                "VOrderID"=>$VOrderID,
                                "OrderID"=>$OrderID,
                                "OrderNo"=>$VOrderNo,
                                "OrderDate"=>date("Y-m-d"),
                                "ExpectedDelivery"=>date("Y-m-d",strtotime($req->ExpectedDelivery)),
                                "QID"=>$QID,
                                "CustomerID"=>$data->CustomerID,
                                "AID"=>$data->AID,
                                "VendorID"=>$item->VendorID,
                                "ReceiverName"=>$data->ReceiverName,
                                "ReceiverMobNo"=>$data->ReceiverMobNo,
                                "DAddress"=>$data->DAddress,
                                "DCountryID"=>$data->DCountryID,
                                "DStateID"=>$data->DStateID,
                                "DDistrictID"=>$data->DDistrictID,
                                "DTalukID"=>$data->DTalukID,
                                "DCityID"=>$data->DCityID,
                                "DPostalCodeID"=>$data->DPostalCodeID,
                                "Status"=>"New",
                                "TaxAmount"=>$item->TaxAmount,
                                "SubTotal"=>$item->SubTotal,
                                "DiscountType"=>"",
                                "DiscountPercentage"=>0,
                                "DiscountAmount"=>0,
                                "CGSTAmount"=>$item->CGSTAmount,
                                "SGSTAmount"=>$item->SGSTAmount,
                                "IGSTAmount"=>$item->IGSTAmount,
                                "TotalAmount"=>$item->TotalAmount,
                                "AdditionalCost"=>$additionalCharges,
                                "NetAmount"=>($item->TotalAmount+$additionalCharges),
                                "PaidAmount"=>0,
                                "BalanceAmount"=>($item->TotalAmount+$additionalCharges),
                                "PaymentStatus"=>"Unpaid",
                                "AdditionalCostData"=> serialize([]),
                                "CreatedOn"=>now(),
                                "CreatedBy"=>$this->UserID
                            ];
                            $status=DB::table($this->CurrFyDB.'tbl_vendor_orders')->insert($tdata);
                            if($status){
                                DocNum::updateDocNum(docTypes::VendorOrders->value, $this->CurrFyDB);
                                DocNum::updateInvNo(docTypes::VendorOrders->value);
                                $Title = "New Order Arrived. Order No " . $VOrderNo . ".";
                                $Message = "You have a new order! Check now for details and fulfill it promptly.";
                                Helper::saveNotification($item->VendorID,$Title,$Message,'Orders',$VOrderID);
                                $status=DB::table($this->CurrFyDB.'tbl_order_details')->where('VendorID',$item->VendorID)->where('QID',$item->QID)->update(["VOrderID"=>$VOrderID,"UpdatedOn"=>now(),"updatedBy"=>$this->UserID]);
                            }
                        }

                    }
                    if($status){
                        $status=DB::Table($this->CurrFyDB."tbl_quotation")->where('QID',$QID)->update(["Status"=>"Accepted","UpdatedOn"=>now(),"UpdatedBy"=>$this->UserID]);
                    }
                }else{
                    $status=false;
                }
            } catch (Exception $e) {
                logger($e);
                $status=false;
                DB::rollback();
                return response(array('status'=>false,'message'=>$e->getMessage()), 500);
            }
            if($status==true){
                DB::commit();
                return array('status'=>true,'message'=>"The quote has been successfully moved to orders.", "OrderID" => $OrderID);
            }else{
                DB::rollback();
                return array('status'=>false,'message'=>"The attempt to move the quote to orders has failed.");
            }
    }

    public function getCancelReasons(Request $req){
        $sql="Select * From tbl_reject_reason Where ActiveStatus='Active' and DFlag=0 and (RReasonFor='All')";
        return DB::Select($sql);
    }

    public function getNotifications(Request $req)
    {
        $pageNo = $req->PageNo ?? 1;
        $perPage = 10;

        $Notifications = DB::table($this->CurrFyDB.'tbl_notifications')
            ->where('ReferID', $this->ReferID)
            ->orderBy('CreatedOn', 'desc')
            ->paginate($perPage, ['*'], 'page', $pageNo);

        return view('home.customer.notification-template', compact('Notifications', 'pageNo'))->render();
    }

    public function customerProductView(Request $request, $ProductID)
    {
//        $FormData = $this->EnquiryDetails($EnqID);
        $cartProducts = $this->getCart();
        $customerID = $this->ReferID;
        $customerAid = Session::get('selected_aid');
        $customerDefaultAid = DB::table('tbl_customer_address')
            ->where('CustomerID', $customerID)
            ->where('isDefault', 1)
            ->where('DFlag',0)
            ->value('AID');

        if ($customerAid && DB::table('tbl_customer_address')->where('CustomerID', $customerID)->where('AID', $customerAid)->where('isDefault', 1)->where('DFlag',0)->exists()) {
            $AID = $customerAid;
        } else {
            $AID = $customerDefaultAid;
        }
        $AllVendors = Helper::getAvailableVendorsForCustomer($AID);
        $product = DB::table('tbl_products as P')->leftJoin('tbl_product_subcategory as PSC','PSC.PSCID','P.SCID')
            ->leftJoin('tbl_product_category as PC','PC.PCID','P.CID')
            ->leftJoin('tbl_wishlists as W', function($join) use ($customerID) {
                $join->on('W.product_id', '=', 'P.ProductID')
                    ->where('W.customer_id', '=', $customerID);
            })
            ->where('P.ActiveStatus','Active')->where('P.DFlag',0)
            ->where('P.ProductID', $ProductID)
            ->select('P.ProductID','P.ProductName','P.ShortDescription','P.Description', 'PC.PCID', 'PSC.PSCID',
                'PC.PCName as CategoryName','PSC.PSCName as SubCategoryName', 'P.ProductImage', 'P.ProductBrochure', 'P.VideoURL',
                DB::raw('IF(W.product_id IS NOT NULL, true, false) AS IsInWishlist'))
            ->first();

        $product->ProductImage = (new Helper)->fileCheckAndUrl($product->ProductImage, 'assets/images/no-image-b.png');
        $product->ProductBrochure = (new Helper)->fileCheckAndUrl($product->ProductBrochure, '');

        $product->GalleryImages = DB::table('tbl_products_gallery')
            ->where('ProductID', $ProductID)
            ->pluck('gImage')
            ->map(function ($image) {
                return (new Helper)->fileCheckAndUrl($image, 'assets/images/no-image-b.png');
            })
            ->toArray();
        $RelatedProducts = DB::table('tbl_vendors_product_mapping as VPM')
            ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'VPM.PCID')
            ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PCID', 'PC.PCID')
            ->leftJoin('tbl_products as P', 'P.SCID', 'PSC.PSCID')
            ->leftJoin('tbl_wishlists as W', function ($join) use ($customerID) {
                $join->on('W.product_id', '=', 'P.ProductID')
                    ->where('W.customer_id', '=', $customerID);
            })
            ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
            ->where('P.ActiveStatus', 'Active')
            ->where('P.DFlag', 0)
            ->select('P.ProductID', 'P.ProductName', 'P.ProductImage', 'PSC.PSCID', 'PSC.PSCName',
                DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(P.ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'),
                DB::raw('IF(W.product_id IS NOT NULL, true, false) AS IsInWishlist'))
            ->inRandomOrder()
            ->take(10)
            ->get();
        $FormData['cartProducts'] = $cartProducts;
        $FormData['product'] = $product;
        $FormData['RelatedProducts'] = $RelatedProducts;
        $FormData['Company'] = $this->Company;
        $PCategories = $this->getRandomProductCategories();
        $FormData['PCategories'] = $PCategories;
        $FormData['isRegister'] = false;
        $FormData['Cart'] = $this->getCart();
        $FormData['ShippingAddress'] = $this->shippingAddress;

        return view('home.product-view', $FormData);
    }
}
