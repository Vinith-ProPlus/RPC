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
use logs;
use Helper;
use activeMenuNames;
use docTypes;
use cruds;
use dynamicField;
class StockPointsController extends Controller{
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
		$this->ActiveMenuName=activeMenuNames::StockPoints->value;
		$this->PageTitle="Stock Points";
		$this->generalDB=Helper::getGeneralDB();
        $this->middleware('auth');
		$this->FileTypes=Helper::getFileTypes(array("category"=>array("Images")));
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
			$FormData['Vendors']=DB::table('tbl_vendors')->where('DFlag',0)->where('ActiveStatus','Active')->where('isApproved',1)->select('VendorID','VendorName')->get();
            return view('app.master.vendor.stock-points.view',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"add")==true){
			return Redirect::to('/admin/master/vendor/stock-points/create');
        }else{
            return view('errors.403');
        }
    }
    public function create(Request $req){
        if($this->general->isCrudAllow($this->CRUD,"add")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=false;
			$FormData['Vendors']=DB::table('tbl_vendors')->where('DFlag',0)->where('ActiveStatus','Active')->where('isApproved',1)->select('VendorID','VendorName')->get();
			$FormData['FileTypes']=$this->FileTypes;
            return view('app.master.vendor.stock-points.create',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/vendor-master/stock-points/');
        }else{
            return view('errors.403');
        }
    }
    public function edit(Request $req,$StockPointID){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=true;
			$FormData['FileTypes']=$this->FileTypes;
			$FormData['Vendors']=DB::table('tbl_vendors')->where('DFlag',0)->where('ActiveStatus','Active')->where('isApproved',1)->select('VendorID','VendorName')->get();
			$StockPoints = DB::table('tbl_vendors_stock_point as VSP')
			->leftJoin($this->generalDB . 'tbl_postalcodes as P', 'P.PID', 'VSP.PostalID')
			->leftJoin($this->generalDB . 'tbl_cities as CI', 'CI.CityID', 'VSP.CityID')
			->leftJoin($this->generalDB . 'tbl_taluks as T', 'T.TalukID', 'VSP.TalukID')
			->leftJoin($this->generalDB . 'tbl_districts as D', 'D.DistrictID', 'VSP.DistrictID')
			->leftJoin($this->generalDB . 'tbl_states as S', 'S.StateID', 'VSP.StateID')
			->leftJoin($this->generalDB . 'tbl_countries as C', 'C.CountryID', 'VSP.CountryID')
			->where('VSP.StockPointID', $StockPointID)
			->where('VSP.DFlag', 0)
			->select('StockPointID','UUID','VSP.PointName','VSP.VendorID','CompleteAddress','Address','MapData','ServiceBy','Range','Latitude','Longitude','VSP.PostalID','P.PostalCode','VSP.CityID','CI.CityName','VSP.TalukID','T.TalukName','VSP.DistrictID','D.DistrictName','VSP.StateID','S.StateName','VSP.CountryID','C.CountryName')
			->first();
			if($StockPoints->ServiceBy!=='Radius'){
				$ServiceData = DB::table('tbl_vendors_service_locations as VSL')
				->leftJoin($this->generalDB.'tbl_states as S', 'S.StateID','VSL.StateID')
				->leftJoin($this->generalDB.'tbl_countries as C','C.CountryID','S.CountryID')
				->where('ServiceBy',$StockPoints->ServiceBy)
				->where('VSL.DFlag', 0)
				->where('VSL.StockPointID', $StockPoints->StockPointID)
				->groupBy('VSL.StateID','S.StateName','C.CountryID')
				->select('VSL.StateID','S.StateName','C.CountryID')
				->get();
				foreach ($ServiceData as $item) {
					$item->Districts = DB::table('tbl_vendors_service_locations as VSL')->join($this->generalDB.'tbl_districts as D','D.DistrictID','VSL.DistrictID')->where('VSL.DFlag', 0)->where('VSL.StateID', $item->StateID)->where('ServiceBy',$StockPoints->ServiceBy)->where('VSL.StockPointID', $StockPoints->StockPointID)->groupBy('VSL.DistrictID','D.DistrictName')->select('VSL.DistrictID','D.DistrictName')->get();
					foreach ($item->Districts as $row){
						$row->PostalCodeIDs = DB::table('tbl_vendors_service_locations as VSL')->leftJoin($this->generalDB.'tbl_postalcodes as P','P.PID','VSL.PostalCodeID')->where('VSL.StateID',$item->StateID)->where('VSL.DistrictID',$row->DistrictID)->where('VSL.StockPointID', $StockPoints->StockPointID)->where('VSL.ServiceBy',$StockPoints->ServiceBy)->where('VSL.DFlag', 0)->pluck('VSL.PostalCodeID')->toArray();
					}
				}
				$StockPoints->ServiceData = $ServiceData;
			}else{
                $StockPoints->ServiceData = json_encode([]);
            }
			$FormData['EditData']=$StockPoints;

			if($FormData['EditData']){
				return view('app.master.vendor.stock-points.create',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/vendor-master/category');	
        }else{
            return view('errors.403');
        }
    }
    public function save(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"add")==true){
			$OldData=array();$NewData=array();$StockPointID="";
			
			DB::beginTransaction();
			$status=false;
			try {
				$MapData = serialize(json_decode($req->MapData));
                $StockPointID = DocNum::getDocNum(docTypes::VendorStockPoint->value,"",Helper::getCurrentFY());
				$CompleteAddress = Helper::formAddress($req->Address,$req->CityID);
                $data=array(
                    "StockPointID"=>$StockPointID,
                    "VendorID"=>$req->VendorID,
                    "UUID"=>substr(str_shuffle(substr(uniqid(uniqid(), true), 0, 16)), 0, 12),
                    "PointName"=>$req->PointName,
					"CompleteAddress"=>$CompleteAddress,
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
                    "Range"=>$req->Range,
                    "CreatedBy"=>$this->UserID,
                    "CreatedOn"=>date("Y-m-d H:i:s"),
                );
                $status=DB::Table('tbl_vendors_stock_point')->insert($data);
                if($status && $req->ServiceBy != 'Radius'){
                    $ServiceData =json_decode($req->ServiceData);
                    if($req->ServiceBy == "District"){
                        foreach($ServiceData as $data){
                            foreach($data->Districts as $item){
                                $t=DB::Table('tbl_vendors_service_locations')->where('VendorID',$req->VendorID)->where('StockPointID',$StockPointID)->where('ServiceBy',$req->ServiceBy)->Where('DistrictID',$item->DistrictID)->first();
                                if(!$t){
                                    $PostalCodeIDs = DB::table($this->generalDB.'tbl_postalcodes')->where('DistrictID',$item->DistrictID)->where('ActiveStatus','Active')->where('DFlag',0)->pluck('PID')->toArray();
                                    if (!empty($PostalCodeIDs)) {
                                        foreach($PostalCodeIDs as $row){
                                            $DetailID = DocNum::getDocNum(docTypes::VendorServiceLocation->value,"",Helper::getCurrentFY());
                                            $tdata=array(
                                                "DetailID"=>$DetailID,
                                                "VendorID"=>$req->VendorID,
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
                                            "VendorID"=>$req->VendorID,
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
                                    $t=DB::Table('tbl_vendors_service_locations')->where('VendorID',$req->VendorID)->where('StockPointID',$StockPointID)->where('ServiceBy',$req->ServiceBy)->Where('PostalCodeID',$row)->first();
                                    if(!$t){
                                        $DetailID = DocNum::getDocNum(docTypes::VendorServiceLocation->value,"",Helper::getCurrentFY());
                                        $tdata=array(
                                            "DetailID"=>$DetailID,
                                            "VendorID"=>$req->VendorID,
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
				$logData=array("Description"=>"Vendor Stockpoint Added","ModuleName"=>"Vendor Stockpoint","Action"=>"Add","ReferID"=>$StockPointID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Vendor Stockpoint Created Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Vendor Stockpoint Create Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denied');
		}
	}
    public function update(Request $req,$StockPointID){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			DB::beginTransaction();
			$OldData=$NewData=[];
            $OldData=DB::table('tbl_vendors_stock_point as VSP')->leftJoin('tbl_vendors_service_locations as VSL','VSL.StockPointID','VSP.StockPointID')->where('VSP.StockPointID',$req->StockPointID)->get();
            $MapData = serialize(json_decode($req->MapData));
            $CompleteAddress = Helper::formAddress($req->Address,$req->CityID);

            $data=array(
                "PointName"=>$req->PointName,
                "CompleteAddress"=>$CompleteAddress,
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
                "Range"=>$req->Range,
                "UpdatedBy"=>$this->UserID,
                "UpdatedOn"=>date("Y-m-d H:i:s"),
            );
            $status=DB::Table('tbl_vendors_stock_point')->where('StockPointID',$StockPointID)->update($data);
            if($status && $req->ServiceBy != 'Radius'){
                $ServiceData = json_decode($req->ServiceData);
                if($req->ServiceBy == "District"){
                    $DistrictIDs=[];
                    foreach($ServiceData as $data){
                        foreach($data->Districts as $item){
                            $DistrictIDs[] = $item->DistrictID;
                            $t=DB::Table('tbl_vendors_service_locations')->where('VendorID',$req->VendorID)->where('StockPointID',$StockPointID)->where('ServiceBy',$req->ServiceBy)->Where('DistrictID',$item->DistrictID)->first();
                            if(!$t){
                                $PostalCodeIDs = DB::table($this->generalDB.'tbl_postalcodes')->where('DistrictID',$item->DistrictID)->where('ActiveStatus','Active')->where('DFlag',0)->pluck('PID')->toArray();
                                if (!empty($PostalCodeIDs)) {
                                    foreach($PostalCodeIDs as $row){
                                        $DetailID = DocNum::getDocNum(docTypes::VendorServiceLocation->value,"",Helper::getCurrentFY());
                                        $tdata=array(
                                            "DetailID"=>$DetailID,
                                            "VendorID"=>$req->VendorID,
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
                                        "VendorID"=>$req->VendorID,
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
                        DB::Table('tbl_vendors_service_locations')->where('VendorID',$req->VendorID)->where('StockPointID',$StockPointID)->where('ServiceBy',$req->ServiceBy)->WhereIn('DistrictID',$DistrictIDs)->update(['DFlag'=>0,'UpdatedBy'=>$req->VendorID,'UpdatedOn'=>date('Y-m-d H:i:s')]);
                        DB::Table('tbl_vendors_service_locations')->where('VendorID',$req->VendorID)->where('StockPointID',$StockPointID)->where('ServiceBy',$req->ServiceBy)->WhereNotIn('DistrictID',$DistrictIDs)->update(['DFlag'=>1,'DeletedBy'=>$req->VendorID,'UpdatedOn'=>date('Y-m-d H:i:s')]);
                        $status=true;
                    }
                }elseif($req->ServiceBy == "PostalCode"){
                    $PostalCodeIDs=[];
                    foreach($ServiceData as $data){
                        foreach($data->Districts as $item){
                            foreach($item->PostalCodeIDs as $row){
                                $PostalCodeIDs[] = $row;
                                $t=DB::Table('tbl_vendors_service_locations')->where('VendorID',$req->VendorID)->where('StockPointID',$StockPointID)->where('ServiceBy',$req->ServiceBy)->Where('PostalCodeID',$row)->first();
                                if(!$t){
                                    $DetailID = DocNum::getDocNum(docTypes::VendorServiceLocation->value,"",Helper::getCurrentFY());
                                    $tdata=array(
                                        "DetailID"=>$DetailID,
                                        "VendorID"=>$req->VendorID,
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
                        DB::Table('tbl_vendors_service_locations')->where('VendorID',$req->VendorID)->where('StockPointID',$StockPointID)->where('ServiceBy',$req->ServiceBy)->WhereIn('PostalCodeID',$PostalCodeIDs)->update(['DFlag'=>0,'UpdatedBy'=>$req->VendorID,'UpdatedOn'=>date('Y-m-d H:i:s')]);
                        DB::Table('tbl_vendors_service_locations')->where('VendorID',$req->VendorID)->where('StockPointID',$StockPointID)->where('ServiceBy',$req->ServiceBy)->WhereNotIn('PostalCodeID',$PostalCodeIDs)->update(['DFlag'=>1,'DeletedBy'=>$req->VendorID,'DeletedOn'=>date('Y-m-d H:i:s')]);
                        $status=true;
                    }
                }
            }
            DB::Table('tbl_vendors_service_locations')->where('VendorID',$req->VendorID)->whereNot('ServiceBy',$req->ServiceBy)->update(['DFlag'=>1,'UpdatedOn'=>date('Y-m-d H:i:s'),'UpdatedBy'=>$this->UserID]);

			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_vendors_stock_point as VSP')->leftJoin('tbl_vendors_service_locations as VSL','VSL.StockPointID','VSP.StockPointID')->where('VSL.DFlag',0)->where('VSP.StockPointID',$req->StockPointID)->first();
				$logData=array("Description"=>"Vendor Stock point Updated","ModuleName"=>"Vendor Stockpoint","Action"=>"Update","ReferID"=>$StockPointID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$req->VendorID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Vendor Stock point Updated Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Vendor Stock point Update Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
	public function Delete(Request $req,$StockPointID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_vendors_stock_point')->where('StockPointID',$StockPointID)->get();
				$status=DB::table('tbl_vendors_stock_point')->where('StockPointID',$StockPointID)->update(array("DFlag"=>1,"DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Stock Point has been Deleted ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::DELETE->value,"ReferID"=>$StockPointID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Stock Point Deleted Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Stock Point Delete Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function ActiveStatus(Request $req){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_vendors_stock_point')->where('StockPointID',$req->StockPointID)->get();
				$status=DB::table('tbl_vendors_stock_point')->where('StockPointID',$req->StockPointID)->update(array("ActiveStatus"=>$req->ActiveStatus,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Stock Point has been Deleted ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::DELETE->value,"ReferID"=>$req->StockPointID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
                $message = $req->ActiveStatus == 1 ? "Stock Point Activated Successfully" : "Stock Point Deactivated Successfully";
                return array('status' => true, 'message' => $message);
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Stock Point Activate Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function getServiceData(Request $req){
            $SP = DB::table('tbl_vendors_stock_point')
			->where('StockPointID', $req->StockPointID)
			->select('ServiceBy')->first();

            $ServiceData = DB::table('tbl_vendors_service_locations as VSL')
            ->leftJoin($this->generalDB.'tbl_states as S', 'S.StateID','VSL.StateID')
            ->leftJoin($this->generalDB.'tbl_countries as C','C.CountryID','S.CountryID')
            ->where('ServiceBy',$SP->ServiceBy)
            ->where('VSL.DFlag', 0)
            ->where('VSL.StockPointID', $req->StockPointID)
            ->groupBy('VSL.StateID','S.StateName','C.CountryID')
            ->select('VSL.StateID','S.StateName','C.CountryID')
            ->get();
            foreach ($ServiceData as $item) {
                $item->Districts = DB::table('tbl_vendors_service_locations as VSL')->join($this->generalDB.'tbl_districts as D','D.DistrictID','VSL.DistrictID')->where('VSL.DFlag', 0)->where('VSL.StateID', $item->StateID)->where('ServiceBy',$SP->ServiceBy)->where('VSL.StockPointID', $req->StockPointID)->groupBy('VSL.DistrictID','D.DistrictName')->select('VSL.DistrictID','D.DistrictName')->get();
                foreach ($item->Districts as $row){
                    $row->PostalCodeIDs = DB::table('tbl_vendors_service_locations as VSL')->leftJoin($this->generalDB.'tbl_postalcodes as P','P.PID','VSL.PostalCodeID')->where('VSL.StateID',$item->StateID)->where('VSL.DistrictID',$row->DistrictID)->where('VSL.StockPointID', $req->StockPointID)->where('VSL.ServiceBy',$SP->ServiceBy)->where('VSL.DFlag', 0)->pluck('VSL.PostalCodeID')->toArray();
                }
            }
            $SP->ServiceData = $ServiceData;
            return $SP;
	}
	public function TableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'StockPointID', 'dt' => '0' ),
				array( 'db' => 'PointName', 'dt' => '1' ),
				array( 'db' => 'CompleteAddress', 'dt' => '2'),
				array( 'db' => 'ServiceBy', 'dt' => '3',
					'formatter' => function( $d, $row ) {
						$html = "";
						if($d=="Radius"){
							$html="<span class='badge badge-info m-1'>".$d."</span>";
						}elseif($d=="PostalCode"){
							$html="<span class='badge badge-secondary m-1'>".$d."</span>";
						}elseif($d=="District"){
							$html="<span class='badge badge-primary m-1'>".$d."</span>";
						}
						return $html;
					} 
				),
				array(
                    'db' => 'ActiveStatus',
                    'dt' => '4',
                    'formatter' => function($d, $row) {
                        $isEditable = $this->general->isCrudAllow($this->CRUD, "edit");
                
                        if ($isEditable) {
                            $checked = $d == 1 ? 'checked' : '';
                            $statusClass = $d == 1 ? 'bg-success' : 'bg-danger';
                            return '<label class="switch mb-0 mt-5">
                                        <input type="checkbox" ' . $checked . ' class= "btnActiveStatus" data-id="' . $row['StockPointID'] . '">
                                        <span class="switch-state ' . $statusClass . '"></span>
                                    </label>';
                        } else {
                            $badgeClass = $d == 1 ? 'badge-success' : 'badge-danger';
                            $statusText = $d == 1 ? 'Active' : 'Inactive';
                            return "<span class='badge $badgeClass m-1'>$statusText</span>";
                        }
                    }
                ),
				array( 'db' => 'StockPointID', 'dt' => '5',
					'formatter' => function( $d, $row ) {
						$html='';
						if($this->general->isCrudAllow($this->CRUD,"edit")==true){
							$html.='<button type="button" data-id="'.$d.'" class="btn btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].' mr-10 btnEdit" data-original-title="Edit"><i class="fa fa-pencil"></i></button>';
						}
						if($this->general->isCrudAllow($this->CRUD,"delete")==true){
							$html.='<button type="button" data-id="'.$d.'" class="btn btn-outline-danger '.$this->general->UserInfo['Theme']['button-size'].' btnDelete" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
						}
						return $html;
					} 
				)
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_vendors_stock_point';
			$data['PRIMARYKEY']='StockPointID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" VendorID = '".$request->VendorID."' and DFlag = 0 ";
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
}
