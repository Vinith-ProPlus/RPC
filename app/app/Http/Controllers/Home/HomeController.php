<?php

namespace App\Http\Controllers\Home;

use SSP;
use logs;
use App\Models\DocNum;
use App\enums\docTypes;
use App\helper\helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller{

	private $generalDB;
    private $tmpDB;
    private $Company;
    private $PostalCode;
    private $PostalCodeID;
	private $DocNum;
    public function __construct(){
        $this->generalDB = Helper::getGeneralDB();
        $this->Company = DB::table('tbl_company_settings')->select('KeyName', 'KeyValue')->get()->pluck('KeyValue', 'KeyName')->toArray();
        $this->Company['AddressData'] = DB::table($this->generalDB.'tbl_cities as CI')
            ->leftJoin($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'CI.PostalID')
            ->leftJoin($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'CI.TalukID')
            ->leftJoin($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'CI.DistrictID')
            ->leftJoin($this->generalDB.'tbl_states as S', 'S.StateID', 'CI.StateID')
            ->leftJoin($this->generalDB.'tbl_countries as C','C.CountryID','CI.CountryID')->where('CI.CityID',$this->Company['CityID'])
            ->select('C.CountryName','S.StateName','D.DistrictName','T.TalukName','CI.CityName', 'PC.PostalCode')
            ->first();

        $this->middleware(function ($request, $next) {
            $this->PostalCode = $request->session()->get('postal_code');
            $this->PostalCodeID = $request->session()->get('postal_code_id');
            return $next($request);
        });
    }
    public function GuestView(Request $req){
        $FormData['Company']=$this->Company;
        $FormData['Banners'] = DB::Table('tbl_banner_images')->where('BannerType', 'Web')->where('DFlag', 0)
            ->select('BannerTitle', 'BannerType', DB::raw('CONCAT("' . url('/') . '/", BannerImage) AS BannerImage'))->get();
        $FormData['steppers'] = DB::Table('tbl_stepper_images')->where('StepperType', 'Web')->where('DFlag', 0)->orderBy('TranNo')
            ->select('StepperTitle', DB::raw('CONCAT("' . url('/') . '/", StepperImage) AS StepperImage'))->get();

        if (auth()->check()) {
            $CustomerID = auth()->user()->ReferID;
            if (empty($CustomerID)) {
                return redirect()->route('customer-register');
            }
            if (!Helper::checkValidCustomer($CustomerID)) {
                return redirect('/customer-profile');
            }
            $customerAid = Session::get('selected_aid');
            $customerDefaultAid = DB::table('tbl_customer_address')
                ->where('CustomerID', $CustomerID)
                ->where('isDefault', 1)
                ->where('DFlag',0)
                ->value('AID');
            if ($customerAid && DB::table('tbl_customer_address')->where('CustomerID', $CustomerID)->where('AID', $customerAid)->where('DFlag',0)->exists()) {
                $AID = $customerAid;
            } else {
                $AID = $customerDefaultAid;
            }
            $AllVendors = Helper::getAvailableVendorsForCustomer($AID);
            $PCatagories = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'VPM.PCID')
                ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
                ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
                ->groupBy('PC.PCName', 'PC.PCID', 'PC.PCImage','PC.ThumbnailImg')
                ->select('PC.PCName', 'PC.PCID', 'PC.PCImage','PC.ThumbnailImg')
                ->inRandomOrder()->take(10)->get();
            foreach ($PCatagories as $row) {
                $row->PCImage = $row->PCImage ? url('/') . '/' . $row->PCImage : url('/') . '/' . 'assets/images/no-image-b.png';
                $row->ThumbnailImg = file_exists($row->ThumbnailImg)  ? $row->ThumbnailImg  : $row->PCImage;
                $row->PSCData = DB::table('tbl_product_subcategory')->where('ActiveStatus', 'Active')->where('DFlag', 0)->where('PCID', $row->PCID)->select('PSCID', 'PSCName', 'PSCImage','ThumbnailImg')->get();
            }
            $RecentProducts = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'VPM.PCID')
                ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PCID', 'PC.PCID')
                ->leftJoin('tbl_products as P', 'P.SCID', 'PSC.PSCID')
                ->leftJoin('tbl_wishlists as W', function ($join) use ($CustomerID) {
                    $join->on('W.product_id', '=', 'P.ProductID')
                        ->where('W.customer_id', '=', $CustomerID);
                })
                ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
                ->where('P.ActiveStatus', 'Active')
                ->where('P.DFlag', 0)
                ->select('P.ProductID', 'P.ProductName', 'P.ProductImage','P.ThumbnailImg', 'PSC.PSCID', 'PSC.PSCName',
                    DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(P.ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'),
                    DB::raw('IF(W.product_id IS NOT NULL, true, false) AS IsInWishlist'))
                ->inRandomOrder()
                ->take(10)
                ->get();

            $FormData['PCategories'] = $PCatagories;
            $FormData['HotProducts'] = $RecentProducts->shuffle();
            $FormData['RecentProducts'] = $RecentProducts->shuffle();
            $FormData['isRegister'] = false;
            $FormData['Cart'] = DB::table('tbl_customer_cart as C')->join('tbl_products as P', 'P.ProductID', 'C.ProductID')
                ->join('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
                ->join('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
                ->join('tbl_uom as U', 'U.UID', 'P.UID')
                ->where('C.CustomerID', $CustomerID)->where('P.ActiveStatus', 'Active')->where('P.DFlag', 0)->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
                ->select('P.ProductName', 'P.ProductID',  'C.Qty', 'PC.PCName', 'PC.PCID', 'PSC.PSCName', 'U.UName',
                    'U.UCode', 'U.UID', 'PSC.PSCID','P.ProductImage','P.ThumbnailImg')->get()->map(function ($cart) {
                    $cart->ProductImage = (new Helper)->fileCheckAndUrl($cart->ProductImage, 'assets/images/no-image-b.png');
                    $cart->ThumbnailImg = file_exists($cart->ThumbnailImg)?$cart->ThumbnailImg:$cart->ProductImage;
                    return $cart;
                });

            $FormData['ShippingAddress'] = DB::table('tbl_customer_address as CA')->where('CA.CustomerID', $CustomerID)->where('CA.DFlag',0)
                ->join($this->generalDB . 'tbl_countries as C', 'C.CountryID', 'CA.CountryID')
                ->join($this->generalDB . 'tbl_states as S', 'S.StateID', 'CA.StateID')
                ->join($this->generalDB . 'tbl_districts as D', 'D.DistrictID', 'CA.DistrictID')
                ->join($this->generalDB . 'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
                ->join($this->generalDB . 'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
                ->join($this->generalDB . 'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
                ->select('CA.AID', 'CA.Address', 'CA.isDefault', 'CA.CountryID', 'C.CountryName', 'CA.StateID',
                    'S.StateName', 'CA.DistrictID', 'D.DistrictName', 'CA.TalukID', 'T.TalukName', 'CA.CityID', 'CI.CityName',
                    'CA.Latitude', 'CA.Longitude', 'CA.PostalCodeID', 'PC.PostalCode')
                ->get();

            return view('home.home', $FormData);
        } else {
            $FormData['PostalCodeID'] = $this->PostalCodeID;
            $FormData['PostalCode'] = $this->PostalCode;
            if($FormData['PostalCodeID']){
                $AllVendors = $this->getAvailableVendors($FormData['PostalCodeID']);

                $PCatagories = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'VPM.PCID')
                ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
                ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
                ->groupBy('PC.PCID', 'PC.PCName', 'PC.PCImage','PC.ThumbnailImg')
                ->select('PC.PCID', 'PC.PCName','PC.ThumbnailImg', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
                ->inRandomOrder()->take(10)->get();
                foreach ($PCatagories as $row) {
                    $row->PSCData = DB::table('tbl_product_subcategory')->where('ActiveStatus', 'Active')->where('DFlag', 0)->where('PCID', $row->PCID)->select('PSCID', 'PSCName', 'PSCImage','ThumbnailImg')->get();
                }
                $RecentProducts = DB::table('tbl_vendors_product_mapping as VPM')
                    ->leftJoin('tbl_products as P','P.ProductID','VPM.ProductID')
                    ->leftJoin('tbl_product_subcategory as PSC','PSC.PSCID','P.SCID')
                    ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
                    ->leftJoin('tbl_uom as U', 'U.UID', 'P.UID')
                    ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
                    ->where('P.ActiveStatus', 'Active')->where('P.DFlag', 0)
                    ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
                    ->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
                    ->groupBy('PSC.PSCID', 'PSCName', 'PC.PCID', 'PCName', 'P.ProductID', 'ProductName', 'ProductImage','UName','UCode','U.UID','P.ThumbnailImg')
                    ->select('PSC.PSCID', 'PSCName','PC.PCID', 'PCName', 'P.ProductID', 'ProductName','UName','UCode','U.UID', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'))
                    ->inRandomOrder()->take(10)
                    ->get();
                $FormData['PCategories'] = $PCatagories;
                $FormData['HotProducts'] = $RecentProducts->shuffle();
                $FormData['RecentProducts'] = $RecentProducts->shuffle();
            }else{
                $PCatagories = DB::Table('tbl_product_category')->where('ActiveStatus', 'Active')->where('DFlag', 0)->select('PCName', 'PCID', 'PCImage','ThumbnailImg')
                ->where('DFlag',0)->inRandomOrder()->take(10)->get();
                foreach ($PCatagories as $row) {
                    $row->PCImage = $row->PCImage ? url('/') . '/' . $row->PCImage : url('/') . '/' . 'assets/images/no-image-b.png';
                    $row->ThumbnailImg = $row->ThumbnailImg ? $row->ThumbnailImg : $row->PCImage;
                    $row->PSCData = DB::table('tbl_product_subcategory')->where('ActiveStatus', 'Active')->where('DFlag', 0)->where('PCID', $row->PCID)->select('PSCID', 'PSCName', 'PSCImage','ThumbnailImg')->get();
                }
                $RecentProducts = DB::table('tbl_products as P')
                    ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
                    ->select('P.ProductID', 'P.ProductName', 'P.ProductImage', 'PSC.PSCName','P.ThumbnailImg', 'PSC.PSCID', 'PSC.PCID',
                        DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(P.ProductImage, ""), "")) AS ProductImage'))
                    ->where('P.DFlag',0)->where('P.ActiveStatus','Active')
                    ->inRandomOrder()->take(10)
                    ->get();
                $FormData['PCategories'] = $PCatagories;
                $FormData['HotProducts'] = $RecentProducts->shuffle();
                $FormData['RecentProducts'] = $RecentProducts->shuffle();
            }
            $FormData['ServiceProvided'] = DB::table('tbl_service_provided')->where('ActiveStatus','Active')->where('DFlag',0)->get();
            $FormData['ConServiceCategories'] = DB::table('tbl_construction_service_category')->where('ActiveStatus','Active')->where('DFlag',0)->get();
            $FormData['AndroidAppUrl'] = DB::table('tbl_settings')->where('KeyName','android-app-url')->value('KeyValue');
            return view('home.guest-home', $FormData);
        }
    }

    public function policies($Slug)
    {
        $pageExists = DB::table('tbl_page_content')->where('Slug', $Slug)->exists();
        if (!$pageExists) {
            return redirect()->route('homepage');
        }
        $FormData['Slug'] = $Slug;
        $FormData['isRegister'] = true;
        $FormData['isEdit'] = false;
        $FormData['Cart'] = [];
        $FormData['Company']=$this->Company;
        $PCatagories = DB::Table('tbl_product_category')->where('ActiveStatus', 'Active')->where('DFlag', 0)
            ->inRandomOrder()->take(10)->get();
        foreach ($PCatagories as $row) {
            $row->PCImage = $row->PCImage ? url('/') . '/' . $row->PCImage : url('/') . '/' . 'assets/images/no-image-b.png';
            $row->ThumbnailImg = $row->ThumbnailImg ?  $row->ThumbnailImg : $row->PCImage;
            $row->PSCData = DB::table('tbl_product_subcategory')->where('ActiveStatus', 'Active')->where('DFlag', 0)->where('PCID', $row->PCID)->select('PSCID', 'PSCName', 'PSCImage','ThumbnailImg')->get();
        }
        $FormData['PCategories'] = $PCatagories;
        if (auth()->check()) {
            $CustomerID = auth()->user()->ReferID;
            if (empty($CustomerID)) {
                return redirect()->route('customer-register');
            }
            $FormData['isRegister'] = false;
            $FormData['Cart'] = DB::table('tbl_customer_cart as C')->join('tbl_products as P', 'P.ProductID', 'C.ProductID')
            ->join('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
            ->join('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
            ->join('tbl_uom as U', 'U.UID', 'P.UID')
                ->where('C.CustomerID', $CustomerID)->where('P.ActiveStatus', 'Active')->where('P.DFlag', 0)->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
                ->select('P.ProductName', 'P.ProductID', 'C.Qty', 'PC.PCName', 'PC.PCID', 'PSC.PSCName', 'U.UName', 'U.UCode', 'U.UID', 'PSC.PSCID','P.ThumbnailImg', DB::raw('CONCAT(IF(ProductImage != "", "https://rpc.prodemo.in/", "' . url('/') . '/"), COALESCE(NULLIF(ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'))->get();
            $FormData['ShippingAddress'] = DB::table('tbl_customer_address as CA')->where('CustomerID', $CustomerID)->where('CA.DFlag',0)
                ->join($this->generalDB . 'tbl_countries as C', 'C.CountryID', 'CA.CountryID')
                ->join($this->generalDB . 'tbl_states as S', 'S.StateID', 'CA.StateID')
                ->join($this->generalDB . 'tbl_districts as D', 'D.DistrictID', 'CA.DistrictID')
                ->join($this->generalDB . 'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
                ->join($this->generalDB . 'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
                ->join($this->generalDB . 'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
                ->select('CA.AID', 'CA.Address', 'CA.isDefault', 'CA.CountryID', 'C.CountryName', 'CA.StateID', 'S.StateName', 'CA.DistrictID', 'D.DistrictName', 'CA.TalukID', 'T.TalukName', 'CA.CityID', 'CI.CityName', 'CA.PostalCodeID', 'PC.PostalCode')
                ->get();
        }
        $FormData['ServiceProvided'] = DB::table('tbl_service_provided')->where('ActiveStatus','Active')->where('DFlag',0)->get();
        $FormData['ConServiceCategories'] = DB::table('tbl_construction_service_category')->where('ActiveStatus','Active')->where('DFlag',0)->get();
        $FormData['AndroidAppUrl'] = DB::table('tbl_settings')->where('KeyName','android-app-url')->value('KeyValue');
        return view('home.policies', $FormData);
    }

    public function policiesContent($slug)
    {
        return DB::table('tbl_page_content')->where('Slug', $slug)->pluck('PageContent')->first();
    }

    public function products(Request $req)
    {
        $FormData['PostalCodeID'] = $this->PostalCodeID;
        $FormData['PostalCode'] = $this->PostalCode;
        if($FormData['PostalCodeID']){
            $AllVendors = $this->getAvailableVendors($FormData['PostalCodeID']);

            $PCatagories = DB::table('tbl_vendors_product_mapping as VPM')
            ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'VPM.PCID')
            ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
            ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
            ->groupBy('PC.PCID', 'PC.PCName', 'PC.PCImage')
            ->select('PC.PCID', 'PC.PCName', 'PC.ThumbnailImg', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
            ->inRandomOrder()->take(10)->get();
        }else{
            $PCatagories = DB::Table('tbl_product_category')->where('ActiveStatus', 'Active')->where('DFlag', 0)->select('PCName', 'PCID', 'PCImage','ThumbnailImg')
                ->inRandomOrder()->take(10)->get();
        }

        $FormData['PCategories'] = $PCatagories;
        $FormData['isRegister'] = false;
        $FormData['Cart'] = [];
        $FormData['Company']=$this->Company;
        $FormData['ServiceProvided'] = DB::table('tbl_service_provided')->where('ActiveStatus','Active')->where('DFlag',0)->get();
        $FormData['ConServiceCategories'] = DB::table('tbl_construction_service_category')->where('ActiveStatus','Active')->where('DFlag',0)->get();
        $FormData['AndroidAppUrl'] = DB::table('tbl_settings')->where('KeyName','android-app-url')->value('KeyValue');

        return view('home.guest-products', $FormData);
    }

    public function quickViewHtml($PID){
        $product = DB::table('tbl_products as P')
            ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
            ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
            ->where('P.ActiveStatus', 'Active')->where('P.DFlag', 0)
            ->where('P.ProductID', $PID)
            ->select('P.ProductID', 'P.ProductName', 'P.Description', 'PC.PCName as CategoryName', 'PSC.PCID',
                'PSC.PSCID', 'PSC.PSCName as SubCategoryName', 'P.ProductImage','P.ThumbnailImg', 'P.ProductBrochure', 'P.VideoURL',
                DB::raw('false AS IsInWishlist'))
            ->first();
        $product->ProductImage = (new Helper)->fileCheckAndUrl($product->ProductImage, 'assets/images/no-image-b.png');
        $product->ThumbnailImg = file_exists($product->ThumbnailImg)?$product->ThumbnailImg:$product->ProductImage;
        $product->ProductBrochure = (new Helper)->fileCheckAndUrl($product->ProductBrochure, '');
        $product->GalleryImages = DB::table('tbl_products_gallery')
            ->where('ProductID', $PID)
            ->pluck('gImage')
            ->map(function ($image) {
                return (new Helper)->fileCheckAndUrl($image, 'assets/images/no-image-b.png');
            })
            ->toArray();
        return view('home.guest-quick-view-html', compact('product'))->render();
    }

    public function categoriesHtml(Request $request){
        $categories = $this->getCategory($request);
        return view('home.categories-html', compact('categories'))->render();
    }

    public function productsHtml(Request $request){
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
        return view('home.guest-products-html', compact('productDetails', 'productCount', 'pageNo', 'totalPages', 'range', 'viewType', 'orderBy'))->render();
    }

    public function getCategory(Request $req){
        $FormData['PostalCodeID'] = $this->PostalCodeID;
        $FormData['PostalCode'] = $this->PostalCode;
        if($FormData['PostalCodeID']){
            $AllVendors = $this->getAvailableVendors($FormData['PostalCodeID']);
            $PCatagories = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'VPM.PCID')
                ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
                ->where('PC.ActiveStatus', "Active")->where('PC.DFlag', 0)
                ->distinct()
                ->select('PC.PCID', 'PC.PCName', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS CategoryImage'),'PC.ThumbnailImg')->get();
            foreach ($PCatagories as $row) {
                $row->PSCData = DB::table('tbl_vendors_product_mapping as VPM')
                    ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'VPM.PSCID')
                    ->where('VPM.Status', 1)->where('PSC.PCID', $row->PCID)->WhereIn('VPM.VendorID', $AllVendors)
                    ->where('PSC.ActiveStatus', "Active")->where('PSC.DFlag', 0)
                    ->distinct()
                    ->select('PSC.PSCID', 'PSC.PSCName','PSC.ThumbnailImg')->get();
                foreach ($row->PSCData as $item) {
                    $item->ProductData = DB::table('tbl_vendors_product_mapping as VPM')
                        ->leftJoin('tbl_products as P', 'P.ProductID', 'VPM.ProductID')
                        ->where('VPM.Status', 1)->where('P.SCID', $item->PSCID)->WhereIn('VPM.VendorID', $AllVendors)
                        ->where('P.ActiveStatus', "Active")->where('P.DFlag', 0)
                        ->distinct()
                        ->select('P.ProductID', 'P.ProductName', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(P.ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'),'P.ThumbnailImg')->get();
                }
            }
        }else{
            $PCatagories = DB::table('tbl_product_category as PC')
                ->where('PC.ActiveStatus', "Active")->where('PC.DFlag', 0)
                ->distinct()
                ->select('PC.PCID', 'PC.PCName', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS CategoryImage'), DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(ThumbnailImg, ""), "")) AS ThumbnailImg'))->get();
            foreach ($PCatagories as $row) {
                $row->PSCData = DB::table('tbl_product_subcategory as PSC')
                    ->where('PSC.PCID', $row->PCID)
                    ->where('PSC.ActiveStatus', "Active")->where('PSC.DFlag', 0)
                    ->distinct()
                    ->select('PSC.PSCID', 'PSC.PSCName','PSC.ThumbnailImg')->get();
                foreach ($row->PSCData as $item) {
                    $item->ProductData = DB::table('tbl_products as P')
                        ->where('P.SCID', $item->PSCID)
                        ->where('P.ActiveStatus', "Active")->where('P.DFlag', 0)
                        ->distinct()
                        ->select('P.ProductID', 'P.ProductName', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(P.ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'), 'P.ThumbnailImg')->get();
                }
            }
        }

        return $PCatagories;
    }
    public function getProductDetails(Request $request){
        $productCount = ($request->productCount != 'undefined') ? $request->productCount : 12;
        $pageNo = ($request->pageNo != 'undefined') ? $request->pageNo : 1;
        $FormData['PostalCodeID'] = $this->PostalCodeID;

        if ($FormData['PostalCodeID']) {
            $AllVendors = $this->getAvailableVendors($FormData['PostalCodeID']);

            $baseQuery = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_products as P', 'P.ProductID', '=', 'VPM.ProductID')
                ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', '=', 'P.SCID')
                ->where('P.ActiveStatus', 'Active')
                ->where('P.DFlag', 0)
                ->where('PSC.ActiveStatus', 'Active')
                ->where('PSC.DFlag', 0)
                ->where('VPM.Status', 1)
                ->whereIn('VPM.VendorID', $AllVendors)
                ->when(isset($request->SubCategoryID), function ($query) use ($request) {
                    return $query->where('P.SCID', $request->SubCategoryID);
                });

            $totalProducts = $baseQuery->distinct()->select('P.ProductID')->get();

            $productDetails = $baseQuery
                ->select('P.ProductID', 'P.ProductName', 'P.Description', 'P.ThumbnailImg',
                    DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(P.ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'),
                    DB::raw('false AS IsInWishlist'),
                    'PSC.PSCID', 'PSC.PSCName as SubCategoryName', 'P.CreatedOn') // Include CreatedOn
                ->when($request->has('orderBy') && in_array($request->orderBy, ['new', 'popularity']), function ($query) use ($request) {
                    if ($request->orderBy == "new") {
                        return $query->orderBy('P.CreatedOn', 'desc');
                    } elseif ($request->orderBy == "popularity") {
                        return $query->orderBy('P.CreatedOn', 'asc');
                    }
                })
                ->skip(($pageNo - 1) * $productCount)
                ->take($productCount)
                ->get();

        } else {
            $baseQuery = DB::table('tbl_products as P')
                ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', '=', 'P.SCID')
                ->where('P.ActiveStatus', 'Active')
                ->where('P.DFlag', 0)
                ->where('PSC.ActiveStatus', 'Active')
                ->where('PSC.DFlag', 0)
                ->when(isset($request->SubCategoryID), function ($query) use ($request) {
                    return $query->where('P.SCID', $request->SubCategoryID);
                });

            $totalProducts = $baseQuery->distinct()->select('P.ProductID')->get();

            $productDetails = $baseQuery
                ->select('P.ProductID', 'P.ProductName', 'P.Description', 'P.ThumbnailImg',
                    DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(P.ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'),
                    DB::raw('false AS IsInWishlist'),
                    'PSC.PSCID', 'PSC.PSCName as SubCategoryName', 'P.CreatedOn') // Include CreatedOn
                ->when($request->has('orderBy') && in_array($request->orderBy, ['new', 'popularity']), function ($query) use ($request) {
                    if ($request->orderBy == "new") {
                        return $query->orderBy('P.CreatedOn', 'desc');
                    } elseif ($request->orderBy == "popularity") {
                        return $query->orderBy('P.CreatedOn', 'asc');
                    }
                })
                ->skip(($pageNo - 1) * $productCount)
                ->take($productCount)
                ->get();
        }

        return [
            'productDetails' => $productDetails,
            'totalProductsCount' => count($totalProducts)
        ];
    }

    public function categoryList(){
        $FormData['PostalCodeID'] = $this->PostalCodeID;
        $FormData['PostalCode'] = $this->PostalCode;
        if($FormData['PostalCodeID']){
            $AllVendors = $this->getAvailableVendors($FormData['PostalCodeID']);

            $PCatagories = DB::table('tbl_vendors_product_mapping as VPM')
            ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'VPM.PCID')
            ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
            ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
            ->groupBy('PC.PCID', 'PC.PCName', 'PC.PCImage','PC.ThumbnailImg')
            ->select('PC.PCID', 'PC.PCName','P.ThumbnailImg', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
            ->inRandomOrder()->take(10)->get();
        }else{
            $PCatagories = DB::Table('tbl_product_category')->where('ActiveStatus', 'Active')->where('DFlag', 0)->select('PCName', 'PCID', 'PCImage','ThumbnailImg')
                ->inRandomOrder()->take(10)->get();
        }

        $FormData['PCategories'] = $PCatagories;
        $FormData['isRegister'] = false;
        $FormData['Cart'] = [];
        $FormData['Company']=$this->Company;

        if (auth()->check()) {
            $CustomerID = auth()->user()->ReferID;
            if (empty($CustomerID)) {
                return redirect()->route('customer-register');
            }
            $FormData['isRegister'] = false;
            $FormData['Cart'] = DB::table('tbl_customer_cart as C')->join('tbl_products as P', 'P.ProductID', 'C.ProductID')
                ->join('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
                ->join('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
                ->join('tbl_uom as U', 'U.UID', 'P.UID')
                ->where('C.CustomerID', $CustomerID)->where('P.ActiveStatus', 'Active')->where('P.DFlag', 0)->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
                ->select('P.ProductName', 'P.ProductID', 'C.Qty', 'PC.PCName', 'PC.PCID', 'PSC.PSCName', 'U.UName', 'U.UCode', 'U.UID', 'PSC.PSCID','P.ThumbnailImg', DB::raw('CONCAT(IF(ProductImage != "", "https://rpc.prodemo.in/", "' . url('/') . '/"), COALESCE(NULLIF(ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'))->get();
            $FormData['ShippingAddress'] = DB::table('tbl_customer_address as CA')->where('CustomerID', $CustomerID)->where('CA.DFlag',0)
                ->join($this->generalDB . 'tbl_countries as C', 'C.CountryID', 'CA.CountryID')
                ->join($this->generalDB . 'tbl_states as S', 'S.StateID', 'CA.StateID')
                ->join($this->generalDB . 'tbl_districts as D', 'D.DistrictID', 'CA.DistrictID')
                ->join($this->generalDB . 'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
                ->join($this->generalDB . 'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
                ->join($this->generalDB . 'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
                ->select('CA.AID', 'CA.Address', 'CA.isDefault', 'CA.CountryID', 'C.CountryName', 'CA.StateID', 'S.StateName', 'CA.DistrictID', 'D.DistrictName', 'CA.TalukID', 'T.TalukName', 'CA.CityID', 'CI.CityName', 'CA.PostalCodeID', 'PC.PostalCode')
                ->get();
        }
        return view('home.category-list', $FormData);
    }

    public function categoryListHtml(Request $request){
        if (isset($request->PostalID) && $request->PostalID != "undefined") {
            $AllVendors = DB::table('tbl_vendors as V')
                ->leftJoin('tbl_vendors_service_locations as VSL', 'V.VendorID', 'VSL.VendorID')
                ->where('V.ActiveStatus', "Active")->where('V.DFlag', 0)
                ->where('VSL.PostalCodeID', $request->PostalID)->groupBy('VSL.VendorID')->pluck('VSL.VendorID')->toArray();
            $PCatagories = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'VPM.PCID')
                ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
                ->groupBy('PC.PCID', 'PC.PCName', 'PC.PCImage','PC.ThumbnailImg')
                ->select('PC.PCName', 'PC.PCID', 'PC.ThumbnailImg',
                    DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PC.PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
                ->inRandomOrder()->get();
        } else {
            $PCatagories = DB::Table('tbl_product_category')->where('ActiveStatus', 'Active')->where('DFlag', 0)
                ->select('PCName', 'PCID', 'ThumbnailImg',
                    DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
                ->inRandomOrder()->get();
        }
        return view('home.category-list-html', compact('PCatagories'))->render();
    }

    public function subCategoryList(Request $request){
        $FormData['PostalCodeID'] = $this->PostalCodeID;
        $FormData['PostalCode'] = $this->PostalCode;
        if($FormData['PostalCodeID']){
            $AllVendors = $this->getAvailableVendors($FormData['PostalCodeID']);

            $PCatagories = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'VPM.PCID')
                ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
                ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
                ->groupBy('PC.PCID', 'PC.PCName', 'PC.PCImage','PC.ThumbnailImg')
                ->select('PC.PCID', 'PC.PCName','PC.ThumbnailImg', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
                ->inRandomOrder()->take(10)->get();
        }else{
            $PCatagories = DB::Table('tbl_product_category')->where('ActiveStatus', 'Active')->where('DFlag', 0)
                ->select('PCName', 'PCID', 'ThumbnailImg',
                    DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
                ->inRandomOrder()->take(10)->get();
        }
        $FormData['PCategories'] = $PCatagories;
        $FormData['CID'] = $request->CID ?? '';
        $FormData['isRegister'] = false;
        $FormData['Cart'] = [];
        $FormData['Company']=$this->Company;

        if (auth()->check()) {
            $CustomerID = auth()->user()->ReferID;
            if (empty($CustomerID)) {
                return redirect()->route('customer-register');
            }
            $FormData['isRegister'] = false;
            $FormData['Cart'] = DB::table('tbl_customer_cart as C')->join('tbl_products as P', 'P.ProductID', 'C.ProductID')
                ->join('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
                ->join('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
                ->join('tbl_uom as U', 'U.UID', 'P.UID')
                ->where('C.CustomerID', $CustomerID)->where('P.ActiveStatus', 'Active')->where('P.DFlag', 0)->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
                ->select('P.ProductName', 'P.ProductID', 'C.Qty', 'PC.PCName', 'PC.PCID', 'PSC.PSCName', 'U.UName', 'U.UCode', 'U.UID', 'PSC.PSCID','P.ThumbnailImg', DB::raw('CONCAT(IF(ProductImage != "", "https://rpc.prodemo.in/", "' . url('/') . '/"), COALESCE(NULLIF(ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'))->get();
            $FormData['ShippingAddress'] = DB::table('tbl_customer_address as CA')->where('CustomerID', $CustomerID)->where('CA.DFlag',0)
                ->join($this->generalDB . 'tbl_countries as C', 'C.CountryID', 'CA.CountryID')
                ->join($this->generalDB . 'tbl_states as S', 'S.StateID', 'CA.StateID')
                ->join($this->generalDB . 'tbl_districts as D', 'D.DistrictID', 'CA.DistrictID')
                ->join($this->generalDB . 'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
                ->join($this->generalDB . 'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
                ->join($this->generalDB . 'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
                ->select('CA.AID', 'CA.Address', 'CA.isDefault', 'CA.CountryID', 'C.CountryName', 'CA.StateID', 'S.StateName', 'CA.DistrictID', 'D.DistrictName', 'CA.TalukID', 'T.TalukName', 'CA.CityID', 'CI.CityName', 'CA.PostalCodeID', 'PC.PostalCode')
                ->get();
        }
        return view('home.sub-category-list', $FormData);
    }

    public function subCategoryListHtml(Request $request){
        if (isset($request->PostalID) && $request->PostalID != "undefined") {
            $AllVendors = DB::table('tbl_vendors as V')
                ->leftJoin('tbl_vendors_service_locations as VSL', 'V.VendorID', 'VSL.VendorID')
                ->where('V.ActiveStatus', "Active")->where('V.DFlag', 0)
                ->where('VSL.PostalCodeID', $request->PostalID)->groupBy('VSL.VendorID')->pluck('VSL.VendorID')->toArray();
            $PSubCatagories = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'VPM.PSCID')
                ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
                ->when(isset($request->CID), function ($query) use ($request){
                    return $query->where('PSC.PCID', $request->CID);
                })
                ->groupBy('PSC.PSCID', 'PSC.PSCName', 'PSC.PSCImage','PSC.ThumbnailImg')
                ->select('PSC.PSCName', 'PSC.PSCID', 'PSC.ThumbnailImg',
                    DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PSC.PSCImage, ""), "assets/images/no-image-b.png")) AS PSCImage'))
                ->inRandomOrder()->get();
        } else {
            $FormData['PostalCodeID'] = $this->PostalCodeID;
            $FormData['PostalCode'] = $this->PostalCode;
            if($FormData['PostalCodeID']){
                $AllVendors = $this->getAvailableVendors($FormData['PostalCodeID']);

                $PSubCatagories = DB::table('tbl_product_subcategory as PSC')
                    ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
                    ->rightJoin('tbl_vendors_product_mapping as VPM', 'PSC.PSCID', 'VPM.PSCID')
                    ->where('VPM.Status', 1)
                    ->whereIn('VPM.VendorID', $AllVendors)
                    ->when(isset($request->CID), function ($query) use ($request){
                        return $query->where('PCID', $request->CID);
                    })
                    ->groupBy('PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName','PSC.ThumbnailImg')
                    ->select('PSCName', 'PSC.PSCID', 'PSC.ThumbnailImg', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PSCImage, ""), "assets/images/no-image-b.png")) AS PSCImage'))
                    ->inRandomOrder()->get();
            }else{
                $PSubCatagories = DB::Table('tbl_product_subcategory')->where('ActiveStatus', 'Active')->where('DFlag', 0)
                    ->when(isset($request->CID), function ($query) use ($request){
                        return $query->where('PCID', $request->CID);
                    })
                    ->select('PSCName', 'PSCID', 'ThumbnailImg', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PSCImage, ""), "assets/images/no-image-b.png")) AS PSCImage'))
                    ->inRandomOrder()->get();
            }
        }

        return view('home.sub-category-list-html', compact('PSubCatagories'))->render();
    }

    public function productsList(Request $request){
        $PCatagories = DB::Table('tbl_product_category')->where('ActiveStatus', 'Active')->where('DFlag', 0)
            ->select('PCName', 'PCID', 'ThumbnailImg',
                DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
            ->inRandomOrder()->take(10)->get();
        $FormData['PCategories'] = $PCatagories;
        $FormData['SCID'] = $request->SCID ?? '';
        $FormData['isRegister'] = false;
        $FormData['Cart'] = [];
        $FormData['Company']=$this->Company;

        if (auth()->check()) {
            $CustomerID = auth()->user()->ReferID;
            if (empty($CustomerID)) {
                return redirect()->route('customer-register');
            }
            $FormData['isRegister'] = false;
            $FormData['Cart'] = DB::table('tbl_customer_cart as C')->join('tbl_products as P', 'P.ProductID', 'C.ProductID')
                ->join('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
                ->join('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
                ->join('tbl_uom as U', 'U.UID', 'P.UID')
                ->where('C.CustomerID', $CustomerID)->where('P.ActiveStatus', 'Active')->where('P.DFlag', 0)->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
                ->select('P.ProductName', 'P.ProductID', 'C.Qty', 'PC.PCName', 'PC.PCID', 'PSC.PSCName', 'U.UName', 'U.UCode', 'U.UID', 'PSC.PSCID','P.ThumbnailImg', DB::raw('CONCAT(IF(ProductImage != "", "https://rpc.prodemo.in/", "' . url('/') . '/"), COALESCE(NULLIF(ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'))->get();
            $FormData['ShippingAddress'] = DB::table('tbl_customer_address as CA')->where('CustomerID', $CustomerID)->where('CA.DFlag',0)
                ->join($this->generalDB . 'tbl_countries as C', 'C.CountryID', 'CA.CountryID')
                ->join($this->generalDB . 'tbl_states as S', 'S.StateID', 'CA.StateID')
                ->join($this->generalDB . 'tbl_districts as D', 'D.DistrictID', 'CA.DistrictID')
                ->join($this->generalDB . 'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
                ->join($this->generalDB . 'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
                ->join($this->generalDB . 'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
                ->select('CA.AID', 'CA.Address', 'CA.isDefault', 'CA.CountryID', 'C.CountryName', 'CA.StateID', 'S.StateName', 'CA.DistrictID', 'D.DistrictName', 'CA.TalukID', 'T.TalukName', 'CA.CityID', 'CI.CityName', 'CA.PostalCodeID', 'PC.PostalCode')
                ->get();
        }
        return view('home.products-list', $FormData);
    }

    public function productsListHtml(Request $request){
        $productCount = ($request->productCount != 'undefined') ? $request->productCount : 12;
        $pageNo = ($request->pageNo != 'undefined') ? $request->pageNo : 1;
        $viewType = $request->viewType ?? 'Grid';
        $orderBy = $request->orderBy ?? '';
        $productsData = $this->getProductDetails($request);

        $productDetails = $productsData['productDetails'];
        $totalProductsCount = $productsData['totalProductsCount'];

        $totalPages = ceil($totalProductsCount / (int)$productCount);
        $range = 3;

        if($pageNo > $totalPages){
            $pageNo = $request->pageNo = $totalPages;
            $productsData = $this->getProductDetails($request);
            $productDetails = $productsData['productDetails'];
        }

        return view('home.products-list-html', compact('productDetails', 'productCount', 'pageNo', 'totalPages', 'range', 'viewType', 'orderBy'))->render();
    }

    public function guestCategoryList(){
        $FormData['PostalCodeID'] = $this->PostalCodeID;
        $FormData['PostalCode'] = $this->PostalCode;
        if($FormData['PostalCodeID']){
            $AllVendors = $this->getAvailableVendors($FormData['PostalCodeID']);

            $PCatagories = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'VPM.PCID')
                ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
                ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
                ->groupBy('PC.PCID', 'PC.PCName', 'PC.PCImage','PC.ThumbnailImg')
                ->select('PC.PCID', 'PC.PCName', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'), 'PC.ThumbnailImg')
                ->inRandomOrder()->take(10)->get();
        }else{
            $PCatagories = DB::Table('tbl_product_category')->where('ActiveStatus', 'Active')->where('DFlag', 0)
                ->select('PCName', 'PCID', 'ThumbnailImg',
                    DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
                ->inRandomOrder()->take(10)->get();
        }
        //dd($PCatagories);
        $FormData['PCategories'] = $PCatagories;
        $FormData['isRegister'] = false;
        $FormData['Cart'] = [];
        $FormData['Company']=$this->Company;
        $FormData['ServiceProvided'] = DB::table('tbl_service_provided')->where('ActiveStatus','Active')->where('DFlag',0)->get();
        $FormData['ConServiceCategories'] = DB::table('tbl_construction_service_category')->where('ActiveStatus','Active')->where('DFlag',0)->get();
        $FormData['AndroidAppUrl'] = DB::table('tbl_settings')->where('KeyName','android-app-url')->value('KeyValue');
        return view('home.guest.category-list', $FormData);
    }

    public function guestCategoryListHtml(Request $request){
        $productCount = ($request->productCount != 'undefined') ? $request->productCount : 12;
        $pageNo = ($request->pageNo != 'undefined') ? $request->pageNo : 1;
        $viewType = $request->viewType ?? 'Grid';
        $orderBy = $request->orderBy ?? '';
        $FormData['PostalCodeID'] = $this->PostalCodeID;
        if($FormData['PostalCodeID']){
            $AllVendors = $this->getAvailableVendors($FormData['PostalCodeID']);
            $PCatagoriesTotal = DB::table('tbl_product_category as PC')
                ->leftJoin('tbl_vendors_product_mapping as VPM', 'PC.PCID', 'VPM.PCID')
                ->leftJoin('tbl_products as P', 'VPM.ProductID', 'P.ProductID')
                ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
                ->where('PC.ActiveStatus', 'Active')
                ->where('PC.DFlag', 0)
                ->where('VPM.Status', 1)
                ->whereIn('VPM.VendorID', $AllVendors)
                ->when($request->has('orderBy') && in_array($request->orderBy, ['new', 'popularity']), function ($query) use ($request) {
                    if ($request->orderBy == "new") {
                        return $query->orderBy('PC.CreatedOn', 'desc');
                    } elseif ($request->orderBy == "popularity") {
                        return $query->orderBy('PC.CreatedOn', 'asc');
                    }
                })
                ->distinct()
                ->select('PC.PCName', 'PC.PCID', 'PC.ThumbnailImg',
                    DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PC.PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
                ->get();
            $PCatagories = DB::table('tbl_product_category as PC')
                ->leftJoin('tbl_vendors_product_mapping as VPM', 'PC.PCID', 'VPM.PCID')
                ->leftJoin('tbl_products as P', 'VPM.ProductID', 'P.ProductID')
                ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
                ->where('PC.ActiveStatus', 'Active')
                ->where('PC.DFlag', 0)
                ->where('VPM.Status', 1)
                ->whereIn('VPM.VendorID', $AllVendors)
                ->when($request->has('orderBy') && in_array($request->orderBy, ['new', 'popularity']), function ($query) use ($request) {
                    if ($request->orderBy == "new") {
                        return $query->orderBy('PC.CreatedOn', 'desc');
                    } elseif ($request->orderBy == "popularity") {
                        return $query->orderBy('PC.CreatedOn', 'asc');
                    }
                })
                ->distinct()
                ->select('PC.PCName', 'PC.PCID', 'PC.ThumbnailImg',
                    DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PC.PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
                ->skip(($pageNo - 1) * $productCount)
                ->take($productCount)
                ->get();

            $totalCategoriesCount = $PCatagoriesTotal->count();
        }else{
            $PCatagories = DB::Table('tbl_product_category')->where('ActiveStatus', 'Active')->where('DFlag', 0)
                ->when($request->has('orderBy') && in_array($request->orderBy, ['new', 'popularity']), function ($query) use ($request) {
                    if ($request->orderBy == "new") {
                        return $query->orderBy('CreatedOn', 'desc');
                    } elseif ($request->orderBy == "popularity") {
                        return $query->orderBy('CreatedOn', 'asc');
                    }
                })
                ->distinct()
                ->select('PCName', 'PCID', 'ThumbnailImg',
                    DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
                ->skip(($pageNo - 1) * $productCount)
                ->take($productCount)
                ->get();
            $totalCategoriesCount = DB::Table('tbl_product_category')->where('ActiveStatus', 'Active')->where('DFlag', 0)->distinct()->count();
        }

        $totalPages = ceil($totalCategoriesCount / $productCount);
        $range = 3;
        return view('home.guest.category-list-html', compact('PCatagories', 'productCount', 'pageNo', 'viewType', 'orderBy', 'range', 'totalPages'))->render();
    }


    public function guestSubCategoryList(Request $request){
        $FormData['PostalCodeID'] = $this->PostalCodeID;
        $FormData['PostalCode'] = $this->PostalCode;
        if($FormData['PostalCodeID']){
            $AllVendors = $this->getAvailableVendors($FormData['PostalCodeID']);

            $PCatagories = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'VPM.PCID')
                ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
                ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
                ->groupBy('PC.PCID', 'PC.PCName', 'PC.PCImage','PC.ThumbnailImg')
                ->select('PC.PCID', 'PC.PCName','PC.ThumbnailImg', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
                ->inRandomOrder()->take(10)->get();
        }else{
            $PCatagories = DB::Table('tbl_product_category')->where('ActiveStatus', 'Active')->where('DFlag', 0)
                ->select('PCName', 'PCID','ThumbnailImg',
                    DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
                ->inRandomOrder()->take(10)->get();
        }
        $FormData['PCategories'] = $PCatagories;
        $FormData['CID'] = $request->CID ?? '';
        $FormData['isRegister'] = false;
        $FormData['Cart'] = [];
        $FormData['Company']=$this->Company;
        $FormData['ServiceProvided'] = DB::table('tbl_service_provided')->where('ActiveStatus','Active')->where('DFlag',0)->get();
        $FormData['ConServiceCategories'] = DB::table('tbl_construction_service_category')->where('ActiveStatus','Active')->where('DFlag',0)->get();
        $FormData['AndroidAppUrl'] = DB::table('tbl_settings')->where('KeyName','android-app-url')->value('KeyValue');
        return view('home.guest.sub-category-list', $FormData);
    }

    public function guestSubCategoryListHtml(Request $request){
        $productCount = ($request->productCount != 'undefined') ? $request->productCount : 12;
        $pageNo = ($request->pageNo != 'undefined') ? $request->pageNo : 1;
        $viewType = $request->viewType ?? 'Grid';
        $orderBy = $request->orderBy ?? '';
        $FormData['PostalCodeID'] = $this->PostalCodeID;
        if($FormData['PostalCodeID']){
            $AllVendors = $this->getAvailableVendors($FormData['PostalCodeID']);
            $PSubCatagoriesTotal = DB::table('tbl_product_category as PC')
                ->leftJoin('tbl_vendors_product_mapping as VPM', 'PC.PCID', 'VPM.PCID')
                ->leftJoin('tbl_products as P', 'VPM.ProductID', 'P.ProductID')
                ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
                ->where('VPM.Status', 1)
                ->whereIn('VPM.VendorID', $AllVendors)
                ->where('PSC.ActiveStatus', 'Active')
                ->where('PSC.DFlag', 0)
                ->when($request->has('orderBy') && in_array($request->orderBy, ['new', 'popularity']), function ($query) use ($request) {
                    if ($request->orderBy == "new") {
                        return $query->orderBy('PSC.CreatedOn', 'desc');
                    } elseif ($request->orderBy == "popularity") {
                        return $query->orderBy('PSC.CreatedOn', 'asc');
                    }
                })
                ->distinct()
                ->select('PSC.PSCName', 'PSC.PSCID','PSC.ThumbnailImg',
                    DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PSC.PSCImage, ""), "assets/images/no-image-b.png")) AS PSCImage'))
                ->get();
            $PSubCatagories = DB::table('tbl_product_category as PC')
                ->leftJoin('tbl_vendors_product_mapping as VPM', 'PC.PCID', 'VPM.PCID')
                ->leftJoin('tbl_products as P', 'VPM.ProductID', 'P.ProductID')
                ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
                ->where('VPM.Status', 1)
                ->whereIn('VPM.VendorID', $AllVendors)
                ->where('PSC.ActiveStatus', 'Active')
                ->where('PSC.DFlag', 0)
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
                ->select('PSC.PSCName', 'PSC.PSCID','PSC.ThumbnailImg',
                    DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PSC.PSCImage, ""), "assets/images/no-image-b.png")) AS PSCImage'))
                ->skip(($pageNo - 1) * $productCount)
                ->take($productCount)
                ->get();

            $totalSubCategoriesCount = $PSubCatagoriesTotal->count();
        }else{
            $PSubCatagories = DB::Table('tbl_product_subcategory')
                ->where('ActiveStatus', 'Active')
                ->where('DFlag', 0)
                ->when($request->has('CID') && isset($request->CID), function ($query) use ($request) {
                    $query->where('PCID', $request->CID);
                })
                ->when($request->has('orderBy') && in_array($request->orderBy, ['new', 'popularity']), function ($query) use ($request) {
                    if ($request->orderBy == "new") {
                        return $query->orderBy('CreatedOn', 'desc');
                    } elseif ($request->orderBy == "popularity") {
                        return $query->orderBy('CreatedOn', 'asc');
                    }
                })
                ->distinct()
                ->select('PSCName', 'PSCID','ThumbnailImg',
                    DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PSCImage, ""), "assets/images/no-image-b.png")) AS PSCImage'))
                ->skip(($pageNo - 1) * $productCount)
                ->take($productCount)
                ->get();
            $totalSubCategoriesCount = DB::Table('tbl_product_subcategory')
                ->where('ActiveStatus', 'Active')->where('DFlag', 0)
                ->distinct()
                ->when($request->has('CID') && isset($request->CID), function ($query) use ($request) {
                    $query->where('PCID', $request->CID);
                })->count();
        }

        $totalPages = ceil($totalSubCategoriesCount / $productCount);
        $range = 3;
        return view('home.guest.sub-category-list-html', compact('PSubCatagories', 'productCount', 'pageNo', 'viewType', 'orderBy', 'range', 'totalPages'))->render();
    }


    public function guestProductsList(Request $request){
        $FormData['PostalCodeID'] = $this->PostalCodeID;
        $FormData['PostalCode'] = $this->PostalCode;
        if($FormData['PostalCodeID']){
            $AllVendors = $this->getAvailableVendors($FormData['PostalCodeID']);

            $PCatagories = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'VPM.PCID')
                ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
                ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
                ->groupBy('PC.PCID', 'PC.PCName', 'PC.PCImage')
                ->select('PC.PCID', 'PC.PCName','PC.ThumbnailImg', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
                ->inRandomOrder()->take(10)->get();
        }else{
            $PCatagories = DB::Table('tbl_product_category')->where('ActiveStatus', 'Active')->where('DFlag', 0)
                ->select('PCName', 'PCID','ThumbnailImg',
                    DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
                ->inRandomOrder()->take(10)->get();
        }
        $FormData['PCategories'] = $PCatagories;
        $FormData['SCID'] = $request->SCID ?? '';
        $FormData['isRegister'] = false;
        $FormData['Cart'] = [];
        $FormData['Company']=$this->Company;
        return view('home.guest.products-list', $FormData);
    }

    public function guestProductsListHtml(Request $request){
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
        return view('home.guest.products-list-html', compact('productDetails', 'productCount', 'pageNo', 'viewType', 'orderBy', 'range', 'totalPages'))->render();
    }

    public function guestHomeSearch(Request $req){
        if ($req->SearchText) {
            $PCategories = DB::table('tbl_product_category as PC')
                ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
                ->where('PC.PCName', 'like', '%' . $req->SearchText . '%')
                ->groupBy('PC.PCID', 'PC.PCName')
                ->select('PC.PCID', 'PC.PCName')->take(3)->get();

            $PSCategories = DB::table('tbl_product_subcategory as PSC')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
                ->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
                ->where('PSC.PSCName', 'like', '%' . $req->SearchText . '%')
                ->groupBy('PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName')
                ->select('PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName')->take(3)->get();

            $Products = DB::table('tbl_products as P')
                ->leftJoin('tbl_product_subcategory as PSC', 'P.SCID', 'PSC.PSCID')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
                ->where('P.ActiveStatus', 'Active')->where('P.DFlag', 0)
                ->where('P.ProductName', 'like', '%' . $req->SearchText . '%')
                ->groupBy('P.ProductID', 'P.ProductName', 'PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName')
                ->select('P.ProductID', 'P.ProductName', 'PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName')->take(3)->get();
            $resultHtml = view('home.guest.search-html', compact('PCategories', 'PSCategories', 'Products'))->render();

            return response()->json(['status' => true, 'searchResults' => $resultHtml]);
        } else {
            return response()->json(['status' => false, 'message' => "search text is empty"]);
        }
    }
    public function setAidInSession(Request $request){
        $aid = $request->input('aid');
        $existingAID = Session::get('selected_aid');
        Session::put('selected_aid', $aid);
        return response()->json(['message' => 'Selected aid set successfully', 'isChanged' => $existingAID != $aid]);
    }
    public function setPostalCodeInSession(Request $request){
        $PostalCodeData = DB::table($this->generalDB.'tbl_postalcodes')->where('PostalCode', $request->Pincode)->first();
        if(!$PostalCodeData){
            return ['status' => false,'message' => "Pincode Does Not Exist!"];
        }elseif($PostalCodeData->DFlag == 1){
            return ['status' => false,'message' => "Pincode Does Not Exist!"];
        }elseif($PostalCodeData->ActiveStatus =='Inactive'){
            return ['status' => false,'message' => "Entered Pincode is not active!"];
        }else{
            Session::put('postal_code_id', $PostalCodeData->PID);
            Session::put('postal_code', $request->Pincode);
            return ['status' => true,'message' => 'Pincode put successfully'];
        }
    }
    public function removePostalCodeInSession(Request $request){
        Session::put('postal_code_id', '');
        Session::put('postal_code', '');
        return ['status' => true,'message' => 'Pincode removed successfully'];
    }

    public function productDescription($PID){
        return DB::table('tbl_products')->where('ProductID', $PID)->pluck('Description')->first();
    }
    public function productShortDescription($PID){
        return DB::table('tbl_products')->where('ProductID', $PID)->pluck('ShortDescription')->first();
    }

    public function guestProductView(Request $request, $ProductID){
        $FormData['PostalCodeID'] = $this->PostalCodeID;
        $FormData['PostalCode'] = $this->PostalCode;
        if($FormData['PostalCodeID']){
            $AllVendors = $this->getAvailableVendors($FormData['PostalCodeID']);

            $PCatagories = DB::table('tbl_vendors_product_mapping as VPM')
            ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'VPM.PCID')
            ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
            ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
            ->groupBy('PC.PCID', 'PC.PCName', 'PC.PCImage')
            ->select('PC.PCID', 'PC.PCName','PC.ThumbnailImg', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
            ->inRandomOrder()->take(10)->get();

            $RelatedProducts = DB::table('tbl_vendors_product_mapping as VPM')
                    ->leftJoin('tbl_products as P','P.ProductID','VPM.ProductID')
                    ->leftJoin('tbl_product_subcategory as PSC','PSC.PSCID','P.SCID')
                    ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
                    ->leftJoin('tbl_uom as U', 'U.UID', 'P.UID')
                    ->where('VPM.Status', 1)->WhereIn('VPM.VendorID', $AllVendors)
                    ->where('P.ActiveStatus', 'Active')->where('P.DFlag', 0)
                    ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
                    ->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
                    ->groupBy('PSC.PSCID', 'PSCName', 'PC.PCID', 'PCName', 'P.ProductID', 'ProductName', 'ProductImage','UName','UCode','U.UID','ThumbnailImg')
                    ->select('PSC.PSCID', 'PSCName','PC.PCID', 'PCName', 'P.ProductID', 'ProductName','UName','UCode','U.UID','P.ThumbnailImg', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'))
                    ->inRandomOrder()->take(10)
                    ->get();
        }else{
            $PCatagories = DB::Table('tbl_product_category')->where('ActiveStatus', 'Active')->where('DFlag', 0)->select('PCName', 'PCID', 'PCImage')
                ->inRandomOrder()->take(10)->get();

            $RelatedProducts = DB::table('tbl_vendors_product_mapping as VPM')
                ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'VPM.PCID')
                ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PCID', 'PC.PCID')
                ->leftJoin('tbl_products as P', 'P.SCID', 'PSC.PSCID')
                ->where('P.ActiveStatus', 'Active')
                ->where('P.DFlag', 0)
                ->select('P.ProductID', 'P.ProductName', 'P.ProductImage', 'PSC.PSCID', 'PSC.PSCName','PSC.ThumbnailImg',
                    DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(P.ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'))
                ->inRandomOrder()
                ->take(10)
                ->get();
        }
        $product = DB::table('tbl_products as P')
            ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
            ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
            ->where('P.ActiveStatus','Active')->where('P.DFlag',0)
            ->where('P.ProductID', $ProductID)
            ->select('P.ProductID','P.ProductName','P.ShortDescription','P.Description', 'PC.PCID', 'PSC.PSCID',
                'PC.PCName as CategoryName','PSC.PSCName as SubCategoryName', 'P.ProductImage','P.ThumbnailImg', 'P.ProductBrochure', 'P.VideoURL')
            ->first();
        if($product) {
            $product->ProductImage = (new Helper)->fileCheckAndUrl($product->ProductImage, 'assets/images/no-image-b.png');
            $product->ThumbnailImg = file_exists($product->ThumbnailImg) ? $product->ThumbnailImg : $product->ProductImage;
            $product->ProductBrochure = (new Helper)->fileCheckAndUrl($product->ProductBrochure, '');

            $product->GalleryImages = DB::table('tbl_products_gallery')
                ->where('ProductID', $ProductID)
                ->pluck('gImage')
                ->map(function ($image) {
                    return (new Helper)->fileCheckAndUrl($image, 'assets/images/no-image-b.png');
                })
                ->toArray();
            $FormData['product'] = $product;
            $FormData['PCategories'] = $PCatagories;
            $FormData['RelatedProducts'] = $RelatedProducts;
            $FormData['isRegister'] = false;
            $FormData['Cart'] = [];
            $FormData['Company'] = $this->Company;
            $FormData['ServiceProvided'] = DB::table('tbl_service_provided')->where('ActiveStatus', 'Active')->where('DFlag', 0)->get();
            $FormData['ConServiceCategories'] = DB::table('tbl_construction_service_category')->where('ActiveStatus', 'Active')->where('DFlag', 0)->get();
            $FormData['AndroidAppUrl'] = DB::table('tbl_settings')->where('KeyName', 'android-app-url')->value('KeyValue');
            return view('home.guest-product-view', $FormData);
        } else {
            return view('errors.404');
        }
    }

    public static function getAvailableVendors($PostalCodeID){
        $AllVendors = DB::table('tbl_vendors as V')
            ->join('tbl_vendors_service_locations as VSL', 'V.VendorID', 'VSL.VendorID')
            ->where('V.isApproved', '1')
            ->where('V.ActiveStatus', "Active")
            ->where('V.DFlag', 0)
            ->where('VSL.DFlag', 0)
            ->where('VSL.PostalCodeID', $PostalCodeID)->groupBy('V.VendorID')->pluck('V.VendorID')->toArray();
        return $AllVendors;
    }

    public static function SavePlanningServices(Request $request){
		$OldData=$NewData=array();

        $rules=array(
            'CustomerName' => 'required|string|max:255',
            'CustomerMobile' => 'required|digits:10',
            'CustomerEmail' => 'nullable|email',
        );

        $message=array(
            'CustomerName.required'=>'Name is required',
            'CustomerMobile.required'=>'Mobile Number is required',
        );

        $validator = Validator::make($request->all(), $rules,$message);

        if ($validator->fails()) {
            return array('status'=>false,'message'=>"Building Plan Form Submission Failed",'errors'=>$validator->errors());
        }

        DB::beginTransaction();
        $status=false;

        try{
            $PServiceID=DocNum::getDocNum(docTypes::PlanningServices->value);
            $data=array(
                'PServiceID'=>$PServiceID,
                'Name'=>$request->CustomerName,
                'MobileNumber'=>$request->CustomerMobile,
                'Email'=>$request->CustomerEmail,
                'ServiceID'=>$request->CustomerServices,
                'StateID'=>$request->StateID,
                'DistrictID'=>$request->DistrictID,
                'Message'=>$request->CustomerMessage,
                'DFlag'=>0,
                'CreatedOn'=>now(),
            );

            $status=DB::Table('tbl_planning_services')->insert($data);

        }catch(\Exception $e) {

        }
        if($status==true){
            DB::commit();
            DocNum::updateDocNum(docTypes::PlanningServices->value);
            return array('status'=>true,'message'=>"Form Submitted Successfully! Will get back to you shortly.","PServiceID"=>$PServiceID);
        }else{
            DB::rollback();
            return array('status'=>false,'message'=>"Building Plan Form Submission Failed");
        }
    }

    public static function SaveConstructionServices(Request $request)
    {
        $rules = [
            'CustomerName' => 'required|string|max:255',
            'CustomerMobile' => 'required|digits:10',
            'ConServiceType' => 'required',
            'ConService' => 'required',
            'CustomerEmail' => 'nullable|email',
        ];
        $message = [
            'CustomerName.required' => 'Name is required',
            'CustomerMobile.required' => 'Mobile Number is required',
            'ConServiceType.required' => 'Construction Service Type is required',
            'ConService.required' => 'Construction Service is required',
        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return array('status' => false, 'message' => "Construction Service Plan Form Submission Failed", 'errors' => $validator->errors());
        }
        DB::beginTransaction();
        $status = false;
        try {
            $CPServiceID = DocNum::getDocNum(docTypes::ConstructionPlanServices->value);
            $data = array(
                'CPServiceID' => $CPServiceID,
                'Name' => $request->CustomerName,
                'MobileNumber' => $request->CustomerMobile,
                'Email' => $request->CustomerEmail,
                'CSCID' => $request->ConServiceType,
                'CSID' => $request->ConService,
                'StateID' => $request->StateID,
                'DistrictID' => $request->DistrictID,
                'Message' => $request->CustomerMessage,
                'DFlag' => 0,
                'CreatedOn' => now(),
            );
            $status = DB::Table('tbl_construction_plan_services')->insert($data);
        } catch (\Exception $e) {
            logger("Error in HomeController@SaveConstructionServices: " . $e->getMessage());
        }
        if ($status) {
            DB::commit();
            DocNum::updateDocNum(docTypes::ConstructionPlanServices->value);
            return array('status' => true, 'message' => "Form Submitted Successfully! Will get back to you shortly.", "CPServiceID" => $CPServiceID);
        }
        DB::rollback();
        return array('status' => false, 'message' => "Construction Service Plan Form Submission Failed");
    }
    public static function SendBecomeVendorWhatsappMsg(Request $request)
    {
        $request->validate([
            'MobileNumber' => 'required|digits:10'
        ], [
            'MobileNumber.required' => 'Mobile Number is required',
            'MobileNumber.digits' => 'Mobile Number must be 10 digits'
        ]);

        try {
            $mobileNumber = "91" . $request->MobileNumber;
            $postData = [
                "to" => $mobileNumber,
                "type" => "template",
                "template" => [
                    "language" => [
                        "policy" => "deterministic",
                        "code" => "en"
                    ],
                    "name" => "rpc_become_a_vendor",
                    "components" => [
                        [
                            "type" => "body"
                        ]
                    ]
                ]
            ];

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://backend.askeva.io/v1/message/send-message?token='.config('app.WHATSAPP_API_KEY'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($postData, JSON_THROW_ON_ERROR),
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json'
                ]
            ]);

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            $responseData = json_decode($response, true);

            if ($httpCode === 200 && isset($responseData['messages'][0]['id'])) {
                return response()->json([
                    "status" => true,
                    "message" => "Mobile application link sent through WhatsApp"
                ]);
            }
            return response()->json([
                "status" => false,
                "message" => "Failed to send mobile link through WhatsApp",
                "error" => $responseData ?? "No response from API"
            ]);
        } catch (\Exception $e) {
            logger("Error in SendBecomeVendorWhatsappMsg: " . $e->getMessage());
            return response()->json([
                "status" => false,
                "message" => "Failed to send WhatsApp message",
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
