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
class VendorStockUpdateController extends Controller{
	private $general;
	private $DocNum;
	private $UserID;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $Settings;
    private $Menus;
	
    public function __construct(){
		$this->ActiveMenuName=activeMenuNames::VendorStockUpdate->value;
		$this->PageTitle="Vendor Stock Update";
        $this->middleware('auth');
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
			$FormData['isEdit']=false;
            return view('app.master.vendor.vendor-stock-update.stock',$FormData);
        }else{
            return view('errors.403');
        }
    }
    public function edit(Request $req,$VendorID){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=true;
			$FormData['VendorID']=$VendorID;
			$isVendorExists=DB::Table('tbl_vendors')->where('DFlag',0)->where('ActiveStatus','Active')->Where('VendorID',$VendorID)->exists();
			if($isVendorExists){
				return view('app.master.vendor.vendor-stock-update.stock',$FormData);
			}else{
				return view('errors.403');
			}
        }else{
            return view('errors.403');
        }
    }
    public function update(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OldData=$NewData=[];
			DB::beginTransaction();
			try {
				$StockDB= Helper::getStockDB();
				$StockTableName= Helper::getStockTable($req->VendorID);
				$OldData=DB::table($StockTableName)->where('VendorID',$req->VendorID)->where('Date',date("Y-m-d"))->get();
				$StockData=json_decode($req->StockData,true);
				$ProductIDs=[];
				foreach($StockData as $data){
					$ProductIDs[]=$data['ProductID'];
					$t=DB::Table($StockTableName)->where('VendorID',$req->VendorID)->Where('ProductID',$data['ProductID'])->Where('StockPointID',$data['StockPointID'])->where('Date',date("Y-m-d"))->first();
					if(!$t){
						$DetailID = DocNum::getDocNum($req->VendorID,$StockDB,Helper::getCurrentFY());
						$tdata=array(
							"DetailID"=>$DetailID,
							"Date"=>date("Y-m-d"),
							"VendorID"=>$req->VendorID,
							"StockPointID"=>$data['StockPointID'],
							"ProductID"=>$data['ProductID'],
							"Qty"=>$data['Qty'],
							// "Price"=>$data['Price'],
							"CreatedBy"=>$this->UserID,
							"CreatedOn"=>date("Y-m-d H:i:s")
						);
						$status=DB::Table($StockTableName)->insert($tdata);
						if($status){
							DocNum::updateDocNum($req->VendorID,$StockDB);
						}
					}else{
						/* $ExistingPrice=DB::Table($StockTableName)->where('VendorID',$req->VendorID)->Where('ProductID',$data['ProductID'])->Where('StockPointID',$data['StockPointID'])->where('Date',date("Y-m-d"))->value('Price');
						if($ExistingPrice != $data['Price']){
							$status=DB::Table($StockTableName)->where('VendorID',$req->VendorID)->Where('ProductID',$data['ProductID'])->Where('StockPointID',$data['StockPointID'])->where('Date',date("Y-m-d"))->update(['Price' => $data['Price']]);
						} */
						$ExistingQty=DB::Table($StockTableName)->where('VendorID',$req->VendorID)->Where('ProductID',$data['ProductID'])->Where('StockPointID',$data['StockPointID'])->where('Date',date("Y-m-d"))->value('Qty');
						if($ExistingQty != $data['Qty']){
							$status=DB::Table($StockTableName)->where('VendorID',$req->VendorID)->Where('ProductID',$data['ProductID'])->Where('StockPointID',$data['StockPointID'])->where('Date',date("Y-m-d"))->update(['Qty' => $data['Qty']]);
						}
					}
				}
				$status=true;
			}catch(Exception $e) {
				$status=false;
			}
			if($status==true){
				// DB::commit();
				$NewData=DB::table($StockTableName)->where('VendorID',$req->VendorID)->where('Date',date("Y-m-d"))->get();
				$logData=array("Description"=>"Vendor Stock Updated","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE->value,"ReferID"=>$req->VendorID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Vendor Stock Updated Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Vendor Stock Updated Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
	public function getVendorProducts(Request $req){
		$VendorData= DB::Table('tbl_vendors_product_mapping as VPM')
					->join('tbl_products as P','P.ProductID','VPM.ProductID')
					->join('tbl_vendors as V','V.VendorID','VPM.VendorID')
					->join('tbl_product_category as PC','PC.PCID','P.CID')
					->join('tbl_product_subcategory as PSC','PSC.PSCID','P.SCID')
					->join('tbl_uom as UOM','UOM.UID','P.UID')
					->where('VPM.Status',1)->where('P.DFlag',0)->where('P.ActiveStatus','Active')->where('VPM.VendorID',$req->VendorID)
					// ->select('VPM.VendorPrice','PSC.PSCName')
					->get();
		$result=[];
		if(count($VendorData)>0){
			foreach($VendorData as $row){
				$result[$row->PSCName][]=$row;
			}
		}
		$VendorStockPoints= DB::table('tbl_vendors_stock_point')->where('DFlag',0)->where('VendorID',$req->VendorID)->select('DetailID as StockPointID','PointName')->get();
		return ['StockPointData'=>$VendorStockPoints,'ProductData'=>$result];
	}
	public function getVendorStockData(Request $req){
		$StockTableName= Helper::getStockTable($req->VendorID);
		$VendorStockData=[];
		
		$isTodayStockData=DB::Table($StockTableName)->where('Date',date('Y-m-d'))->where('VendorID',$req->VendorID)->first();
		$query= DB::Table($StockTableName)->where('VendorID',$req->VendorID);
		if($isTodayStockData){
			$query->where('Date',date('Y-m-d'));
		}else{
			$query->where('Date', now()->subDay()->toDateString());
		}
		$VendorStockData= $query->select('StockPointID','VendorID','ProductID','Qty')->get();
		
		return $VendorStockData;
	}
	
}
