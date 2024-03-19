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
use ValidUnique;
use ValidDB;
use DocNum;
use docTypes;
use logs;

class VendorStockPointController extends Controller{
    private $generalDB;
    private $tmpDB;
    private $FileTypes;
	private $UserID;
	private $VendorID;

    public function __construct(){
		$this->generalDB=Helper::getGeneralDB();
		$this->tmpDB=Helper::getTmpDB();
		$this->FileTypes=Helper::getFileTypes(array("category"=>array("Images","Documents")));
        $this->middleware('auth:api');
        $this->middleware(function ($request, $next) {
			$this->UserID=auth()->user()->UserID;
			$this->VendorID=auth()->user()->ReferID;
			return $next($request);
		});
    }

    //Stockpoints
    public function getStockpointData(request $req){
        $Stockpoints = DB::table('tbl_vendors_stock_point')->where('DFlag',0)->where('VendorID',$this->VendorID)->get();
        return response()->json([ 'status' => true, 'data' => $Stockpoints ]);
    }

    public function AddStockpoint(Request $req){
        DB::beginTransaction();
        try {
            $PostalCodeData = DB::table($this->generalDB.'tbl_postalcodes as P')
            ->join($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'P.DistrictID')
            ->join($this->generalDB.'tbl_states as S', 'S.StateID', 'D.StateID')
            ->join($this->generalDB.'tbl_countries as C','C.CountryID','S.CountryID')
            ->where('P.PostalCode',$req->PostalCode)
            ->where('P.ActiveStatus','Active')->where('P.DFlag',0)
            ->select('P.PID as PostalCodeID','D.DistrictID','S.StateID','C.CountryID')->first();
            if(!$PostalCodeData){
                return response()->json(['status' => false,'message' => "Postal Code does not exist!"]);
            }else{
                $MapData = serialize($req->all());
                $DetailID = DocNum::getDocNum(docTypes::VendorStockPoint->value,"",Helper::getCurrentFY());
                $data=array(
                    "DetailID"=>$DetailID,
                    "VendorID"=>$this->VendorID,
                    "UUID"=>substr(str_shuffle(substr(uniqid(uniqid(), true), 0, 16)), 0, 12),
                    "PointName"=>$req->PointName,
                    "CompleteAddress"=>$req->CompleteAddress,
                    "PostalID"=>$req->PostalID,
                    "PostalCodeID"=>$PostalCodeData->PostalCodeID,
                    "DistrictID"=>$PostalCodeData->DistrictID,
                    "StateID"=>$PostalCodeData->StateID,
                    "CountryID"=>$PostalCodeData->CountryID,
                    "Latitude"=>$req->Latitude,
                    "Longitude"=>$req->Longitude,
                    "MapData"=>$MapData,
                    "ServiceBy"=>$req->ServiceBy,
                    "CreatedOn"=>date("Y-m-d H:i:s")
                );
                $status=DB::Table('tbl_vendors_stock_point')->insert($data);
                if($status==true){
                        
                    DocNum::updateDocNum(docTypes::VendorStockPoint->value);
                }
            }
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            DocNum::updateDocNum(docTypes::VendorStockpoint->value);
            $NewData=DB::table('tbl_vendors_stock_point_images as VVI')->join('tbl_vendors_stock_point as VV','VV.UUID','VVI.UUID')->where('VV.VendorID',$this->VendorID)->where('VV.StockpointID',$StockpointID)->get();
            $logData=array("Description"=>"Vendor Stockpoint Added","ModuleName"=>"Vendor Stockpoint","Action"=>"Add","ReferID"=>$StockpointID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->VendorID,"IP"=>$req->ip());
            logs::Store($logData);
            return response()->json(['status' => true ,'message' => "Vendor Stockpoint Added Successfully!"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Vendor Stockpoint Add Failed!"]);
        }
    }
    public function UpdateStockpoint(Request $req){
        $StockpointID = $req->StockpointID;

        DB::beginTransaction();
        try {
            $OldData=$NewData=[];
            $OldData=DB::table('tbl_vendors_stock_point_images as VVI')->join('tbl_vendors_stock_point as VV','VV.UUID','VVI.UUID')->where('VV.VendorID',$this->VendorID)->where('VV.StockpointID',$StockpointID)->get();
            // return $this->VendorID;

            $vdir="uploads/master/vendor/manage-vendors/".$this->VendorID."/stock_points/";
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
            $status=DB::Table('tbl_vendors_stock_point')->where('StockpointID',$StockpointID)->update($data);


        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            $NewData=DB::table('tbl_vendors_stock_point_images as VVI')->join('tbl_vendors_stock_point as VV','VV.UUID','VVI.UUID')->where('VV.VendorID',$this->VendorID)->where('VV.StockpointID',$StockpointID)->get();
            $logData=array("Description"=>"Vendor Stockpoint Updated","ModuleName"=>"Vendor Stockpoint","Action"=>"Update","ReferID"=>$StockpointID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->VendorID,"IP"=>$req->ip());
            logs::Store($logData);
            return response()->json(['status' => true ,'message' => "Vendor Stockpoint Updated Successfully!"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Vendor Stockpoint Update Failed!"]);
        }
    }
    public function DeleteStockpoint(Request $req){
        $StockpointID = $req->StockpointID;
        DB::beginTransaction();
        try {
            $OldData=$NewData=[];
            $OldData=DB::table('tbl_vendors_stock_point_images as VVI')->join('tbl_vendors_stock_point as VV','VV.UUID','VVI.UUID')->where('VV.VendorID',$this->VendorID)->where('VV.StockpointID',$StockpointID)->get();
            $status = DB::Table('tbl_vendors_stock_point')->where('VendorID',$this->VendorID)->where('StockpointID',$StockpointID)->update(['DFlag'=>1,'DeletedBy'=>$this->VendorID,'DeletedOn'=>date('Y-m-d H:i:s')]);
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            $NewData=DB::table('tbl_vendors_stock_point_images as VVI')->join('tbl_vendors_stock_point as VV','VV.UUID','VVI.UUID')->where('VV.VendorID',$this->VendorID)->where('VV.StockpointID',$StockpointID)->get();
            $logData=array("Description"=>"Vendor Stockpoint Deleted","ModuleName"=>"Vendor Stockpoint","Action"=>"Delete","ReferID"=>$StockpointID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->VendorID,"IP"=>$req->ip());
            logs::Store($logData);
            return response()->json(['status' => true ,'message' => "Stockpoint Deleted Successfully!"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Stockpoint Delete Failed!"]);
        }
    }
    
}