<?php

namespace App\Http\Controllers\Home;

use App\helper\helper;
use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    private $generalDB;
    private $tmpDB;
    private $Company;
    private $PCategories;
    private $UserID;
    private $ReferID;
    private $FileTypes;
    private $UserData;
    private $logDB;

    public function __construct(){
        $this->generalDB=Helper::getGeneralDB();
        $this->tmpDB=Helper::getTmpDB();
        $this->logDB=Helper::getLogDB();
        $this->PCategories= DB::Table('tbl_product_category')->where('ActiveStatus','Active')->where('DFlag',0)->select('PCName','PCID','PCImage')->get()->toArray();
        $this->FileTypes=Helper::getFileTypes(array("category"=>array("Images","Documents")));
        $CompanyData= DB::table('tbl_company_settings')->select('KeyName','KeyValue')->get();
        $Company= [];
        foreach ($CompanyData as $item) {
            $Company[$item->KeyName] = $item->KeyValue;
        }
        $this->Company = $Company;
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->UserData = Helper::getUserInfo(Auth()->user()->UserID);
            $this->UserID=auth()->user()->UserID;
            $this->ReferID=auth()->user()->ReferID;
            return $next($request);
        });
    }
    public function addWishlist(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $validatedData = Validator::make($request->all(), [
                'product_id' => 'required|string|exists:tbl_products,ProductID',
            ]);

            if ($validatedData->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => "Validation Error",
                    'data' => $validatedData->errors()
                ]);
            }

            $product_id = $request->product_id;
            $customer_id = $this->ReferID;

            $wishlist = Wishlist::firstOrCreate(['customer_id' => $customer_id, 'product_id' => $product_id]);
            DB::commit();
            if ($wishlist->wasRecentlyCreated) {
                return response()->json([
                    'status' => true,
                    'message' => "Wishlist item added successfully",
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => "The selected product is already in your wishlist",
            ]);
        } catch (Exception $e) {
            logger($e);
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => "Wishlist item adding failed",
            ]);
        }
    }

    public function removeWishlist(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $validatedData = Validator::make($request->all(), [
                'product_id' => 'required|string|exists:tbl_products,ProductID',
            ]);

            if ($validatedData->fails()) {
                return $this->errorResponse($validatedData->errors(), 'Validation Error', 422);
            }

            $product_id = $request->product_id;
            $customer_id = $this->ReferID;

            $deleted = Wishlist::where('customer_id', $customer_id)
                ->where('product_id', $product_id)
                ->delete();
            DB::commit();
            if ($deleted) {
                return response()->json([
                    'status' => true,
                    'message' => "Wishlist item removed successfully",
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "This product was not listed in your wishlist",
                ]);
            }
        } catch (Exception $e) {
            logger($e);
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => "Wishlist item removing failed",
            ]);
        }
    }
}

