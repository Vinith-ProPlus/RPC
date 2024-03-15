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
class VendorProductMappingController extends Controller{
	private $general;
	private $DocNum;
	private $UserID;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $Settings;
	private $FileTypes;
    private $Menus;
    private $dynamicForms;
    public function __construct(){
		$this->ActiveMenuName=activeMenuNames::VendorProductMapping->value;
		$this->PageTitle="Vendor Product Mapping";
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
            return view('app.master.vendor.vendor-product-mapping.mapping',$FormData);
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
				return view('app.master.vendor.vendor-product-mapping.mapping',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/master/vendor/category');	
        }else{
            return view('errors.403');
        }
    }
    public function update(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OldData=$NewData=[];
			DB::beginTransaction();
			try {
				$OldData=DB::table('tbl_vendors_product_mapping')->where('VendorID',$req->VendorID)->get();
				$ProductData=json_decode($req->ProductData,true);
				$ProductIDs=[];
				foreach($ProductData as $data){
					$ProductIDs[]=$data['ProductID'];
					$t=DB::Table('tbl_vendors_product_mapping')->where('VendorID',$req->VendorID)->Where('ProductID',$data['ProductID'])->first();
					if(!$t){
						$DetailID = DocNum::getDocNum(docTypes::VendorProductMapping->value);
						$tdata=array(
							"DetailID"=>$DetailID,
							"VendorID"=>$req->VendorID,
							"ProductID"=>$data['ProductID'],
							"VendorPrice"=>$data['VendorPrice'],
							"PCID"=>$data['PCID'],
							"PSCID"=>$data['PSCID'],
							"CreatedBy"=>$this->UserID,
							"CreatedOn"=>date("Y-m-d H:i:s")
						);
						$status=DB::Table('tbl_vendors_product_mapping')->insert($tdata);
						if($status){
							DocNum::updateDocNum(docTypes::VendorProductMapping->value);
						}
					}else{
						$ExistingPrice=DB::Table('tbl_vendors_product_mapping')->where('VendorID',$req->VendorID)->Where('ProductID',$data['ProductID'])->value('VendorPrice');
						if($ExistingPrice != $data['VendorPrice']){
							$status=DB::Table('tbl_vendors_product_mapping')->where('VendorID',$req->VendorID)->Where('ProductID',$data['ProductID'])->update(['VendorPrice' => $data['VendorPrice'],"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")]);
						}
					}
				}
				if(count($ProductIDs)>0){
					DB::Table('tbl_vendors_product_mapping')->where('VendorID',$req->VendorID)->WhereIn('ProductID',$ProductIDs)->update(['Status'=>1,'UpdatedOn'=>date('Y-m-d H:i:s'),'UpdatedBy'=>$this->UserID]);
					DB::Table('tbl_vendors_product_mapping')->where('VendorID',$req->VendorID)->WhereNotIn('ProductID',$ProductIDs)->update(['Status'=>0,'UpdatedOn'=>date('Y-m-d H:i:s'),'UpdatedBy'=>$this->UserID]);
				}
				$status=true;
			}catch(Exception $e) {
				$status=false;
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_vendors_product_mapping')->where('VendorID',$req->VendorID)->get();
				$logData=array("Description"=>"Vendor Product Mapped","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE->value,"ReferID"=>$req->VendorID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Vendor Product Mapped Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Vendor Product Mapping Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
	public function getVendorProducts(Request $req){
		return DB::Table('tbl_vendors_product_mapping')->where('Status',1)->Where('VendorID',$req->VendorID)->select('VendorID','ProductID','PCID','PSCID','VendorPrice')->get();
	}

}
