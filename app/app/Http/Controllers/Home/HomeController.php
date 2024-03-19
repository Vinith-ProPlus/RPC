<?php
namespace App\Http\Controllers\Home;

use App\helper\helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use SSP;
use Illuminate\Support\Facades\DB;;
use logs;
class HomeController extends Controller{
    public function GuestView(Request $req)
    {
        $FormData['Company'] = DB::table('tbl_company_settings')->select('KeyName', 'KeyValue')->get()->pluck('KeyValue', 'KeyName')->toArray();
        $FormData['Banners'] = DB::Table('tbl_banner_images')->where('BannerType','Web')
            ->select('BannerTitle','BannerType', DB::raw('CONCAT("' . url('/') . '/", BannerImage) AS BannerImage'))->get();
        $PCatagories = DB::Table('tbl_product_category')->where('ActiveStatus', 'Active')->where('DFlag', 0)->select('PCName', 'PCID', 'PCImage')
            ->inRandomOrder()->take(10)->get();
        foreach ($PCatagories as $row) {
            $row->PCImage = $row->PCImage ? url('/') . '/' . $row->PCImage : url('/') . '/' . 'assets/images/no-image-b.png';
            $row->PSCData = DB::table('tbl_product_subcategory')->where('ActiveStatus', 'Active')->where('DFlag', 0)->where('PCID', $row->PCID)->select('PSCID', 'PSCName', 'PSCImage')->get();
        }
        if (auth()->check()) {
            $CustomerID = auth()->user()->ReferID;
            if (empty($CustomerID)) {
                return redirect()->route('customer-register');
            }
            $RecentProducts = DB::table('tbl_products as P')
                ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
                ->leftJoin('tbl_wishlists as W', function($join) use ($CustomerID) {
                    $join->on('W.product_id', '=', 'P.ProductID')
                        ->where('W.customer_id', '=', $CustomerID);
                })
                ->where('P.ActiveStatus', 'Active')
                ->where('P.DFlag', 0)
                ->select('P.ProductID', 'P.ProductName', 'P.ProductImage', 'PSC.PSCName',
                    DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(P.ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'),
                    DB::raw('IF(W.product_id IS NOT NULL, true, false) AS IsInWishlist'))
                ->inRandomOrder()
                ->take(10)
                ->get()
                ->toArray();

            $FormData['PCategories'] = $PCatagories;
            shuffle($RecentProducts);
            $FormData['HotProducts'] = $RecentProducts;
            $FormData['RecentProducts'] = $RecentProducts;
            $FormData['isRegister'] = false;
            $FormData['Cart'] = DB::table('tbl_customer_cart as C')->join('tbl_products as P', 'P.ProductID', 'C.ProductID')->join('tbl_product_category as PC', 'PC.PCID', 'P.CID')->join('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')->join('tbl_uom as U', 'U.UID', 'P.UID')
                ->where('C.CustomerID', $CustomerID)->where('P.ActiveStatus', 'Active')->where('P.DFlag', 0)->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
                ->select('P.ProductName', 'P.ProductID', 'C.Qty', 'PC.PCName', 'PC.PCID', 'PSC.PSCName', 'U.UName', 'U.UCode', 'U.UID', 'PSC.PSCID', DB::raw('CONCAT(IF(ProductImage != "", "https://rpc.prodemo.in/", "' . url('/') . '/"), COALESCE(NULLIF(ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'))->get();
            $generalDB = Helper::getGeneralDB();
            $FormData['ShippingAddress'] = DB::table('tbl_customer_address as CA')->where('CustomerID', $CustomerID)
                ->join($generalDB . 'tbl_countries as C', 'C.CountryID', 'CA.CountryID')
                ->join($generalDB . 'tbl_states as S', 'S.StateID', 'CA.StateID')
                ->join($generalDB . 'tbl_districts as D', 'D.DistrictID', 'CA.DistrictID')
                ->join($generalDB . 'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
                ->join($generalDB . 'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
                ->join($generalDB . 'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
                ->select('CA.AID', 'CA.Address', 'CA.isDefault', 'CA.CountryID', 'C.CountryName', 'CA.StateID', 'S.StateName', 'CA.DistrictID', 'D.DistrictName', 'CA.TalukID', 'T.TalukName', 'CA.CityID', 'CI.CityName', 'CA.PostalCodeID', 'PC.PostalCode')
                ->get();
            logger($RecentProducts);

            return view('home.home', $FormData);
        } else {
            $RecentProducts = DB::table('tbl_products as P')
                ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
                ->select('P.ProductID', 'P.ProductName', 'P.ProductImage', 'PSC.PSCName',
                    DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(P.ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'))
                ->inRandomOrder()
                ->take(10)
                ->get()
                ->toArray();

            $FormData['PCategories'] = $PCatagories;
            shuffle($RecentProducts);
            $FormData['HotProducts'] = $RecentProducts;
            $FormData['RecentProducts'] = $RecentProducts;
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
        $FormData['Company'] = DB::table('tbl_company_settings')->select('KeyName', 'KeyValue')->get()->pluck('KeyValue', 'KeyName')->toArray();
        $PCatagories = DB::Table('tbl_product_category')->where('ActiveStatus', 'Active')->where('DFlag', 0)->select('PCName', 'PCID', 'PCImage')
            ->inRandomOrder()->take(10)->get();
        foreach ($PCatagories as $row) {
            $row->PCImage = $row->PCImage ? url('/') . '/' . $row->PCImage : url('/') . '/' . 'assets/images/no-image-b.png';
            $row->PSCData = DB::table('tbl_product_subcategory')->where('ActiveStatus', 'Active')->where('DFlag', 0)->where('PCID', $row->PCID)->select('PSCID', 'PSCName', 'PSCImage')->get();
        }
        $FormData['PCategories'] = $PCatagories;
        if (auth()->check()) {
            $CustomerID = auth()->user()->ReferID;
            if (empty($CustomerID)) {
                return redirect()->route('customer-register');
            }
            $FormData['isRegister'] = false;
            $FormData['Cart'] = DB::table('tbl_customer_cart as C')->join('tbl_products as P', 'P.ProductID', 'C.ProductID')->join('tbl_product_category as PC', 'PC.PCID', 'P.CID')->join('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')->join('tbl_uom as U', 'U.UID', 'P.UID')
                ->where('C.CustomerID', $CustomerID)->where('P.ActiveStatus', 'Active')->where('P.DFlag', 0)->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
                ->select('P.ProductName', 'P.ProductID', 'C.Qty', 'PC.PCName', 'PC.PCID', 'PSC.PSCName', 'U.UName', 'U.UCode', 'U.UID', 'PSC.PSCID', DB::raw('CONCAT(IF(ProductImage != "", "https://rpc.prodemo.in/", "' . url('/') . '/"), COALESCE(NULLIF(ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'))->get();
            $generalDB = Helper::getGeneralDB();
            $FormData['ShippingAddress'] = DB::table('tbl_customer_address as CA')->where('CustomerID', $CustomerID)
                ->join($generalDB . 'tbl_countries as C', 'C.CountryID', 'CA.CountryID')
                ->join($generalDB . 'tbl_states as S', 'S.StateID', 'CA.StateID')
                ->join($generalDB . 'tbl_districts as D', 'D.DistrictID', 'CA.DistrictID')
                ->join($generalDB . 'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
                ->join($generalDB . 'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
                ->join($generalDB . 'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
                ->select('CA.AID', 'CA.Address', 'CA.isDefault', 'CA.CountryID', 'C.CountryName', 'CA.StateID', 'S.StateName', 'CA.DistrictID', 'D.DistrictName', 'CA.TalukID', 'T.TalukName', 'CA.CityID', 'CI.CityName', 'CA.PostalCodeID', 'PC.PostalCode')
                ->get();
        }
        return view('home.policies', $FormData);
    }

    public function policiesContent($slug)
    {
        return DB::table('tbl_page_content')->where('Slug', $slug)->pluck('PageContent')->first();
    }
}
