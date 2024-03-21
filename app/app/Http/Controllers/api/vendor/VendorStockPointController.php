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
        $StockPoints = DB::table('tbl_vendors_stock_point as H')
        ->leftJoin($this->generalDB . 'tbl_postalcodes as P', 'P.PID', 'H.PostalID')
        ->leftJoin($this->generalDB . 'tbl_cities as CI', 'CI.CityID', 'H.CityID')
        ->leftJoin($this->generalDB . 'tbl_taluks as T', 'T.TalukID', 'H.TalukID')
        ->leftJoin($this->generalDB . 'tbl_districts as D', 'D.DistrictID', 'H.DistrictID')
        ->leftJoin($this->generalDB . 'tbl_states as S', 'S.StateID', 'H.StateID')
        ->leftJoin($this->generalDB . 'tbl_countries as C', 'C.CountryID', 'H.CountryID')
        ->where('H.VendorID', $this->VendorID)
        ->where('H.DFlag', 0)
        ->select('StockPointID','UUID','H.PointName','CompleteAddress','Address','ServiceBy','Range','Latitude','Longitude','H.PostalID','P.PostalCode','H.CityID','CI.CityName','H.TalukID','T.TalukName','H.DistrictID','D.DistrictName','H.StateID','S.StateName','H.CountryID','C.CountryName')
        ->get();
        foreach($StockPoints as $point){
            if($point->ServiceBy!=='Radius'){
                $ServiceData = DB::table('tbl_vendors_service_locations as VSL')
                ->leftJoin($this->generalDB.'tbl_states as S', 'S.StateID','VSL.StateID')
                ->leftJoin($this->generalDB.'tbl_countries as C','C.CountryID','S.CountryID')
                ->where('ServiceBy',$point->ServiceBy)
                ->where('VSL.DFlag', 0)
                ->where('VSL.StockPointID', $point->StockPointID)
                ->groupBy('VSL.StateID','S.StateName','C.CountryID')
                ->select('VSL.StateID','S.StateName','C.CountryID')
                ->get();
                foreach ($ServiceData as $item) {
                    $item->Districts = DB::table('tbl_vendors_service_locations as VSL')->join($this->generalDB.'tbl_districts as D','D.DistrictID','VSL.DistrictID')->where('VSL.DFlag', 0)->where('VSL.StateID', $item->StateID)->where('ServiceBy',$point->ServiceBy)->where('VSL.StockPointID', $point->StockPointID)->groupBy('VSL.DistrictID','D.DistrictName')->select('VSL.DistrictID','D.DistrictName')->get();
                    foreach ($item->Districts as $row){
                        $row->PostalCodeIDs = DB::table('tbl_vendors_service_locations as VSL')->leftJoin($this->generalDB.'tbl_postalcodes as P','P.PID','VSL.PostalCodeID')->where('VSL.StateID',$item->StateID)->where('VSL.DistrictID',$row->DistrictID)->where('VSL.VendorID',$this->VendorID)->where('VSL.StockPointID', $point->StockPointID)->where('VSL.ServiceBy',$point->ServiceBy)->where('VSL.DFlag', 0)->select('VSL.PostalCodeID','P.PostalCode')->get();
                    }
                }
                $point->ServiceData = $ServiceData;
            }
        }
        
        // $Stockpoints = DB::table('tbl_vendors_stock_point')->where('DFlag',0)->where('VendorID',$this->VendorID)->get();
        return response()->json([ 'status' => true, 'data' => $StockPoints ]);
    }

    public function AddStockpoint(Request $req){
        $OldData = $NewData =[];
        DB::beginTransaction();
        try {
            $MapData = serialize(json_decode($req->MapData));
            $StockPointID = DocNum::getDocNum(docTypes::VendorStockPoint->value,"",Helper::getCurrentFY());
            $data=array(
                "StockPointID"=>$StockPointID,
                "VendorID"=>$this->VendorID,
                "UUID"=>substr(str_shuffle(substr(uniqid(uniqid(), true), 0, 16)), 0, 12),
                "PointName"=>$req->PointName,
                "CompleteAddress"=>$req->CompleteAddress,
                "Address"=>$req->Address,
                "PostalID"=>$req->PostalID,
                "CityID"=>$req->CityID,
                "TalukID"=>$req->TalukID,
                "DistrictID"=>$req->DistrictID,
                "StateID"=>$req->StateID,
                "CountryID"=>$req->CountryID,
                "Latitude"=>$req->Latitude,
                "Longitude"=>$req->Longitude,
                "MapData"=>$MapData,
                "ServiceBy"=>$req->ServiceBy,
                "Range"=>$req->ServiceBy == 'Radius' ? $req->Range : 0,
                "CreatedBy"=>$this->VendorID,
                "CreatedOn"=>date("Y-m-d H:i:s"),
            );
            $status=DB::Table('tbl_vendors_stock_point')->insert($data);
            if($status && $req->ServiceBy != 'Radius'){
                $ServiceData =json_decode($req->ServiceData);
                if($req->ServiceBy == "District"){
                    foreach($ServiceData as $data){
                        foreach($data->Districts as $item){
                            $t=DB::Table('tbl_vendors_service_locations')->where('VendorID',$this->VendorID)->where('StockPointID',$StockPointID)->where('ServiceBy',$req->ServiceBy)->Where('DistrictID',$item->DistrictID)->first();
                            if(!$t){
                                $PostalCodeIDs = DB::table($this->generalDB.'tbl_postalcodes')->where('DistrictID',$item->DistrictID)->where('ActiveStatus','Active')->where('DFlag',0)->pluck('PID')->toArray();
                                if (!empty($PostalCodeIDs)) {
                                    foreach($PostalCodeIDs as $row){
                                        $DetailID = DocNum::getDocNum(docTypes::VendorServiceLocation->value,"",Helper::getCurrentFY());
                                        $tdata=array(
                                            "DetailID"=>$DetailID,
                                            "VendorID"=>$this->VendorID,
                                            "StockPointID"=>$StockPointID,
                                            "ServiceBy"=>$req->ServiceBy,
                                            "StateID" => $data->StateID,
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
                                        "VendorID"=>$this->VendorID,
                                        "StockPointID"=>$StockPointID,
                                        "ServiceBy"=>$req->ServiceBy,
                                        "StateID" => $data->StateID,
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
                }elseif($req->ServiceBy == "PostalCode"){
                    foreach($ServiceData as $data){
                        foreach($data->Districts as $item){
                            foreach($item->PostalCodeIDs as $row){
                                $PostalCodeIDs[] = $row;
                                $t=DB::Table('tbl_vendors_service_locations')->where('VendorID',$this->VendorID)->where('StockPointID',$StockPointID)->where('ServiceBy',$req->ServiceBy)->Where('PostalCodeID',$row)->first();
                                if(!$t){
                                    $DetailID = DocNum::getDocNum(docTypes::VendorServiceLocation->value,"",Helper::getCurrentFY());
                                    $tdata=array(
                                        "DetailID"=>$DetailID,
                                        "VendorID"=>$this->VendorID,
                                        "StockPointID"=>$StockPointID,
                                        "ServiceBy"=>$req->ServiceBy,
                                        "StateID" => $data->StateID,
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
            }
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            DocNum::updateDocNum(docTypes::VendorStockPoint->value);
            $NewData=DB::table('tbl_vendors_stock_point')->where('StockPointID',$StockPointID)->get();
            $logData=array("Description"=>"Vendor Stockpoint Added","ModuleName"=>"Vendor Stockpoint","Action"=>"Add","ReferID"=>$StockPointID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->VendorID,"IP"=>$req->ip());
            logs::Store($logData);
            return response()->json(['status' => true ,'message' => "Vendor Stockpoint Added Successfully!"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Vendor Stockpoint Add Failed!"]);
        }
    }

    public function UpdateStockpoint(Request $req){
        $OldData = $NewData =[];
        $StockPointID = $req->StockPointID;
        DB::beginTransaction();
        try {
            $OldData=$NewData=[];
            $OldData=DB::table('tbl_vendors_stock_point as VSP')->leftJoin('tbl_vendors_service_locations as VSL','VSL.StockPointID','VSP.StockPointID')->where('VSL.DFlag',0)->where('VSP.StockPointID',$req->StockPointID)->first();
            $MapData = serialize(json_decode($req->MapData));
            $data=array(
                "PointName"=>$req->PointName,
                "CompleteAddress"=>$req->CompleteAddress,
                "Address"=>$req->Address,
                "PostalID"=>$req->PostalID,
                "CityID"=>$req->CityID,
                "TalukID"=>$req->TalukID,
                "DistrictID"=>$req->DistrictID,
                "StateID"=>$req->StateID,
                "CountryID"=>$req->CountryID,
                "Latitude"=>$req->Latitude,
                "Longitude"=>$req->Longitude,
                "MapData"=>$MapData,
                "ServiceBy"=>$req->ServiceBy,
                "Range"=>$req->ServiceBy == 'Radius' ? $req->Range : 0,
                "UpdatedBy"=>$this->VendorID,
                "UpdatedOn"=>date("Y-m-d H:i:s"),
            );
            $status=DB::Table('tbl_vendors_stock_point')->where('UUID',$req->UUID)->where('StockPointID',$StockPointID)->update($data);
            if($status && $req->ServiceBy != 'Radius'){
                $ServiceData = json_decode($req->ServiceData);
                if($req->ServiceBy == "District"){
                    $DistrictIDs=[];
                    foreach($ServiceData as $data){
                        foreach($data->Districts as $item){
                            $DistrictIDs[] = $item->DistrictID;
                            $t=DB::Table('tbl_vendors_service_locations')->where('VendorID',$this->VendorID)->where('StockPointID',$StockPointID)->where('ServiceBy',$req->ServiceBy)->Where('DistrictID',$item->DistrictID)->first();
                            if(!$t){
                                $PostalCodeIDs = DB::table($this->generalDB.'tbl_postalcodes')->where('DistrictID',$item->DistrictID)->where('ActiveStatus','Active')->where('DFlag',0)->pluck('PID')->toArray();
                                if (!empty($PostalCodeIDs)) {
                                    foreach($PostalCodeIDs as $row){
                                        $DetailID = DocNum::getDocNum(docTypes::VendorServiceLocation->value,"",Helper::getCurrentFY());
                                        $tdata=array(
                                            "DetailID"=>$DetailID,
                                            "VendorID"=>$this->VendorID,
                                            "StockPointID"=>$StockPointID,
                                            "ServiceBy"=>$req->ServiceBy,
                                            "StateID" => $data->StateID,
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
                                        "VendorID"=>$this->VendorID,
                                        "StockPointID"=>$StockPointID,
                                        "ServiceBy"=>$req->ServiceBy,
                                        "StateID" => $data->StateID,
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
                    if (!empty($DistrictIDs)) {
                        DB::Table('tbl_vendors_service_locations')->where('VendorID',$this->VendorID)->where('StockPointID',$StockPointID)->where('ServiceBy',$req->ServiceBy)->WhereIn('DistrictID',$DistrictIDs)->update(['DFlag'=>0,'UpdatedBy'=>$this->VendorID,'UpdatedOn'=>date('Y-m-d H:i:s')]);
                        DB::Table('tbl_vendors_service_locations')->where('VendorID',$this->VendorID)->where('StockPointID',$StockPointID)->where('ServiceBy',$req->ServiceBy)->WhereNotIn('DistrictID',$DistrictIDs)->update(['DFlag'=>1,'DeletedBy'=>$this->VendorID,'UpdatedOn'=>date('Y-m-d H:i:s')]);
                        $status=true;
                    }
                }elseif($req->ServiceBy == "PostalCode"){
                    $PostalCodeIDs=[];
                    foreach($ServiceData as $data){
                        foreach($data->Districts as $item){
                            foreach($item->PostalCodeIDs as $row){
                                $PostalCodeIDs[] = $row;
                                $t=DB::Table('tbl_vendors_service_locations')->where('VendorID',$this->VendorID)->where('StockPointID',$StockPointID)->where('ServiceBy',$req->ServiceBy)->Where('PostalCodeID',$row)->first();
                                if(!$t){
                                    $DetailID = DocNum::getDocNum(docTypes::VendorServiceLocation->value,"",Helper::getCurrentFY());
                                    $tdata=array(
                                        "DetailID"=>$DetailID,
                                        "VendorID"=>$this->VendorID,
                                        "StockPointID"=>$StockPointID,
                                        "ServiceBy"=>$req->ServiceBy,
                                        "StateID" => $data->StateID,
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
                    if (!empty($PostalCodeIDs)) {
                        DB::Table('tbl_vendors_service_locations')->where('VendorID',$this->VendorID)->where('StockPointID',$StockPointID)->where('ServiceBy',$req->ServiceBy)->WhereIn('PostalCodeID',$PostalCodeIDs)->update(['DFlag'=>0,'UpdatedBy'=>$this->VendorID,'UpdatedOn'=>date('Y-m-d H:i:s')]);
                        DB::Table('tbl_vendors_service_locations')->where('VendorID',$this->VendorID)->where('StockPointID',$StockPointID)->where('ServiceBy',$req->ServiceBy)->WhereNotIn('PostalCodeID',$PostalCodeIDs)->update(['DFlag'=>1,'DeletedBy'=>$this->VendorID,'DeletedOn'=>date('Y-m-d H:i:s')]);
                        $status=true;
                    }
                }
            }
            DB::Table('tbl_vendors_service_locations')->where('VendorID',$this->VendorID)->whereNot('ServiceBy',$req->ServiceBy)->update(['DFlag'=>1,'UpdatedOn'=>date('Y-m-d H:i:s'),'UpdatedBy'=>$this->VendorID]);
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            $NewData=DB::table('tbl_vendors_stock_point as VSP')->leftJoin('tbl_vendors_service_locations as VSL','VSL.StockPointID','VSP.StockPointID')->where('VSL.DFlag',0)->where('VSP.StockPointID',$req->StockPointID)->first();
            $logData=array("Description"=>"Vendor Stockpoint Updated","ModuleName"=>"Vendor Stockpoint","Action"=>"Update","ReferID"=>$StockPointID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->VendorID,"IP"=>$req->ip());
            logs::Store($logData);
            return response()->json(['status' => true ,'message' => "Vendor Stockpoint Updated Successfully!"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Vendor Stockpoint Update Failed!"]);
        }
    }

    public function DeleteStockpoint(Request $req){
        DB::beginTransaction();
        try {
            $OldData=$NewData=[];
            $OldData=DB::table('tbl_vendors_stock_point')->where('VendorID',$this->VendorID)->where('StockPointID',$req->StockPointID)->first();
            $status = DB::Table('tbl_vendors_stock_point')->where('VendorID',$this->VendorID)->where('StockPointID',$req->StockPointID)->update(['DFlag'=>1,'DeletedBy'=>$this->VendorID,'DeletedOn'=>date('Y-m-d H:i:s')]);
            if($status){
                DB::Table('tbl_vendors_service_locations')->where('VendorID',$this->VendorID)->where('StockPointID',$req->StockPointID)->update(['DFlag'=>1,'DeletedBy'=>$this->VendorID,'DeletedOn'=>date('Y-m-d H:i:s')]);
            }
        }catch(Exception $e) {
            $status=false;
        }
        if($status==true){
            DB::commit();
            $NewData=DB::table('tbl_vendors_stock_point')->where('VendorID',$this->VendorID)->where('StockPointID',$req->StockPointID)->first();
            $logData=array("Description"=>"Vendor Stockpoint Deleted","ModuleName"=>"Vendor Stockpoint","Action"=>"Delete","ReferID"=>$req->StockPointID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->VendorID,"IP"=>$req->ip());
            logs::Store($logData);
            return response()->json(['status' => true ,'message' => "Vendor Stockpoint Deleted Successfully!"]);
        }else{
            DB::rollback();
            return response()->json(['status' => false,'message' => "Vendor Stockpoint Delete Failed!"]);
        }
    }
    
}