<?php

namespace App\Http\Controllers\api\customer;

use App\helper\helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use Auth;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use ValidUnique;
use ValidDB;
use DocNum;
use docTypes;
use logs;
use PHPUnit\TextUI\Help;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\select;

class GuestController extends Controller{
    private $generalDB;
    private $tmpDB;
    private $currfyDB;
    private $FileTypes;

    public function __construct(){
		$this->generalDB=Helper::getGeneralDB();
		$this->tmpDB=Helper::getTmpDB();
        $this->currfyDB=Helper::getCurrFYDB();
		$this->FileTypes=Helper::getFileTypes(array("category"=>array("Images","Documents")));
    }

    public function getPostalCodeID(Request $request)
    {
        if (!$request->filled('Pincode')) {
            return ['status' => false, 'message' => "Pincode is required!"];
        }
        if (!$request->filled('DeviceID')) {
            return ['status' => false, 'message' => "DeviceID is required!"];
        }
        try{
            $exist = DB::table('tbl_mobile_guest_users')->where('DeviceID', $request->DeviceID)->where('PinCode', $request->Pincode)->exists();
            if (!$exist) {
                DB::table('tbl_mobile_guest_users')->insert(['DeviceID' => $request->DeviceID,
                    'PinCode' => $request->Pincode]);
            }
        } catch (Exception $exception){
            logger("Error in GuestController@getPostalCodeID: ". $exception->getMessage());
        }
        $PostalCodeData = DB::table($this->generalDB . 'tbl_postalcodes')
            ->where('PostalCode', $request->Pincode)
            ->first();
        if (!$PostalCodeData || $PostalCodeData->DFlag == 1) {
            return ['status' => false, 'message' => "Pincode Does Not Exist!"];
        }
        if ($PostalCodeData->ActiveStatus === 'Inactive') {
            return ['status' => false, 'message' => "Entered Pincode is not active!"];
        }
        return ['status' => true, 'PostalCodeID' => $PostalCodeData->PID, 'message' => 'Pincode put successfully'];
    }

    public function GetCategory(Request $req)
    {
        $pageNo = $req->PageNo ?? 1;
        $perPage = 15;
        $query = DB::table('tbl_product_category as PC')
            ->where('PC.ActiveStatus', 'Active')
            ->where('PC.DFlag', 0);
        if ($req->PostalCodeID) {
            $AllVendors = $this->getAvailableVendors($req->PostalCodeID);
            $query->join('tbl_vendors_product_mapping as VPM', 'PC.PCID', '=', 'VPM.PCID')
                ->where('VPM.Status', 1)
                ->whereIn('VPM.VendorID', $AllVendors);
        }
        if ($req->filled('SearchText')) {
            $query->where('PC.PCName', 'like', '%' . $req->SearchText . '%');
        }
        $PCategories = $query->groupBy('PC.PCID', 'PC.PCName', 'PC.PCImage')
            ->select('PC.PCID', 'PC.PCName', DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PC.PCImage, ""), "assets/images/no-image-b.png")) AS CategoryImage'))
            ->paginate($perPage, ['*'], 'page', $pageNo);
        return response()->json([
            'status' => true,
            'data' => $PCategories->items(),
            'CurrentPage' => $PCategories->currentPage(),
            'LastPage' => $PCategories->lastPage(),
        ]);
    }

    public function GetSubCategory(Request $req)
    {
        $PCIDs = is_array($req->PCID) ? $req->PCID : [$req->PCID];
        $pageNo = $req->PageNo ?? 1;
        $perPage = 15;
        $SubCategory = DB::table('tbl_product_subcategory as PSC')
            ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
            ->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
            ->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)
            ->whereIn('PSC.PCID', $PCIDs);
        if ($req->PostalCodeID) {
            $AllVendors = $this->getAvailableVendors($req->PostalCodeID);
            $SubCategory->leftJoin('tbl_vendors_product_mapping as VPM', 'VPM.PSCID', 'PSC.PSCID')
                ->where('VPM.Status', 1)->whereIn('VPM.VendorID', $AllVendors);
        }
        if ($req->has('SearchText') && !empty($req->SearchText)) {
            $SubCategory->where('PSC.PSCName', 'like', '%' . $req->SearchText . '%');
        }
        $PSubCategories = $SubCategory->groupBy('PSC.PSCID', 'PSCName', 'PC.PCID', 'PCName', 'PSCImage')
            ->select(
                'PSC.PSCID',
                'PSCName',
                'PC.PCID',
                'PCName',
                DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PSCImage, ""), "assets/images/no-image-b.png")) AS SubCategoryImage')
            )->paginate($perPage, ['*'], 'page', $pageNo);
        return response()->json([
            'status' => true,
            'data' => $PSubCategories->items(),
            'CurrentPage' => $PSubCategories->currentPage(),
            'LastPage' => $PSubCategories->lastPage(),
        ]);
    }

    public function GetProducts(Request $req)
    {
        $PCIDs = is_array($req->PCID) ? $req->PCID : [$req->PCID];
        $PSCIDs = is_array($req->PSCID) ? $req->PSCID : [$req->PSCID];
        $pageNo = $req->PageNo ?? 1;
        $perPage = 15;
        $products = DB::table('tbl_products as P')
            ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
            ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
            ->leftJoin('tbl_uom as U', 'U.UID', 'P.UID')
            ->where('P.ActiveStatus', 'Active')
            ->where('P.DFlag', 0)
            ->where('PC.ActiveStatus', 'Active')
            ->where('PC.DFlag', 0)
            ->where('PSC.ActiveStatus', 'Active')
            ->where('PSC.DFlag', 0)
            ->whereIn('PSC.PCID', $PCIDs)
            ->whereIn('P.SCID', $PSCIDs);
        if ($req->PostalCodeID) {
            $AllVendors = $this->getAvailableVendors($req->PostalCodeID);
            $products->join('tbl_vendors_product_mapping as VPM', 'VPM.ProductID', 'P.ProductID')
                ->where('VPM.Status', 1)
                ->whereIn('VPM.VendorID', $AllVendors);
        }
        if ($req->has('SearchText') && !empty($req->SearchText)) {
            $products->where('P.ProductName', 'like', '%' . $req->SearchText . '%');
        }
        $Products = $products->groupBy('PSC.PSCID', 'PSCName', 'PC.PCID', 'PCName', 'P.ProductID', 'ProductName', 'ProductImage', 'UName', 'UCode', 'U.UID', 'P.VideoURL')
            ->select(
                'PSC.PSCID',
                'PSCName',
                'PC.PCID',
                'PCName',
                'P.ProductID',
                'ProductName',
                'UName',
                'UCode',
                'U.UID',
                'P.VideoURL',
                DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage')
            )->paginate($perPage, ['*'], 'page', $pageNo);
        return response()->json([
            'status' => true,
            'data' => $Products->items(),
            'CurrentPage' => $Products->currentPage(),
            'LastPage' => $Products->lastPage(),
        ]);
    }

    public function getGuestHome(Request $req)
    {
        $CustomerHome = [];
        $products = DB::table('tbl_products as P')
            ->leftJoin('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
            ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
            ->leftJoin('tbl_uom as U', 'U.UID', 'P.UID')
            ->where('P.ActiveStatus', 'Active')
            ->where('P.DFlag', 0)
            ->where('PC.ActiveStatus', 'Active')
            ->where('PC.DFlag', 0)
            ->where('PSC.ActiveStatus', 'Active')
            ->where('PSC.DFlag', 0)
            ->groupBy('PSC.PSCID', 'PSCName', 'PC.PCID', 'PCName', 'P.ProductID', 'ProductName', 'ProductImage', 'UName', 'UCode', 'U.UID', 'P.VideoURL')
            ->select(
                'PSC.PSCID',
                'PSCName',
                'PC.PCID',
                'PCName',
                'P.ProductID',
                'ProductName',
                'UName',
                'UCode',
                'U.UID',
                'P.VideoURL',
                DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage')
            );
        $PCategories = DB::table('tbl_product_category as PC')
            ->where('PC.ActiveStatus', 'Active')
            ->where('PC.DFlag', 0)
            ->groupBy('PC.PCID', 'PC.PCName', 'PC.PCImage')
            ->select(
                'PC.PCID',
                'PC.PCName',
                DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS CategoryImage')
            );
        if ($req->PostalCodeID) {
            $AllVendors = $this->getAvailableVendors($req->PostalCodeID);

            $products->join('tbl_vendors_product_mapping as VPM', 'VPM.ProductID', 'P.ProductID')
                ->where('VPM.Status', 1)
                ->whereIn('VPM.VendorID', $AllVendors);

            $PCategories->join('tbl_vendors_product_mapping as VPM', 'VPM.PCID', 'PC.PCID')
                ->where('VPM.Status', 1)
                ->whereIn('VPM.VendorID', $AllVendors);
        }
        $CustomerHome['RecommendedProducts'] = $products->inRandomOrder()->take(5)->get();
        $CustomerHome['PCategories'] = $PCategories->inRandomOrder()->take(5)->get();
        return response()->json(['status' => true, 'data' => $CustomerHome]);
    }

    public function getAllProducts(Request $req)
    {
        $pageNo = $req->PageNo ?? 1;
        $perPage = 10;
        $query = DB::table('tbl_products as P')
            ->leftJoin('tbl_product_subcategory as PSC', 'P.SCID', 'PSC.PSCID')
            ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
            ->select('P.ProductID', 'P.ProductName', 'PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName', 'ProductImage')
            ->groupBy('P.ProductID', 'P.ProductName', 'PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName', 'ProductImage');
        if ($req->PostalCodeID) {
            $AllVendors = $this->getAvailableVendors($req->PostalCodeID);
            $query->rightJoin('tbl_vendors_product_mapping as VPM', 'P.ProductID', 'VPM.ProductID')
                ->where('VPM.Status', 1)
                ->whereIn('VPM.VendorID', $AllVendors);
        }
        if ($req->SearchText) {
            $query->where('P.ProductName', 'like', '%' . $req->SearchText . '%');
        }
        $Products = $query->paginate($perPage, ['*'], 'page', $pageNo);
        foreach ($Products as $row) {
            $row->ProductImage = file_exists($row->ProductImage) ? url('/') . '/' . $row->ProductImage : null;
        }
        return response()->json([
            'status' => true,
            'data' => $Products->items(),
            'CurrentPage' => $Products->currentPage(),
            'LastPage' => $Products->lastPage(),
        ]);
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

    public function getGuestHomeSearch(Request $req){
        if ($req->PostalCodeID) {
            if($req->SearchText){
                $AllVendors = $this->getAvailableVendors($req->PostalCodeID);

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
            if($req->SearchText){

                $PCategories = DB::table('tbl_product_category as PC')
                    ->where('PC.PCName', 'like', '%' . $req->SearchText . '%')
                    ->groupBy('PC.PCID', 'PC.PCName')
                    ->select('PC.PCID', 'PC.PCName')->take(3)->get();

                $PSCategories = DB::table('tbl_product_subcategory as PSC')
                    ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
                    ->where('PSC.PSCName', 'like', '%' . $req->SearchText . '%')
                    ->groupBy('PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName')
                    ->select('PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName')->take(3)->get();

                $Products = DB::table('tbl_products as P')
                    ->leftJoin('tbl_product_subcategory as PSC', 'P.SCID', 'PSC.PSCID')
                    ->leftJoin('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
                    ->where('P.ProductName', 'like', '%' . $req->SearchText . '%')
                    ->groupBy('P.ProductID', 'P.ProductName', 'PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName')
                    ->select('P.ProductID', 'P.ProductName', 'PC.PCID', 'PC.PCName', 'PSC.PSCID', 'PSC.PSCName')->take(3)->get();

                $ProductData = ['PCategories'=>$PCategories,'PSCategories'=>$PSCategories,'Products'=>$Products];

                return response()->json(['status' => true, 'data' => $ProductData ]);
            }
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
}
