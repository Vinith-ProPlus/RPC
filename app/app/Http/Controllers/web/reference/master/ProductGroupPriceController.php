<?php

namespace App\Http\Controllers\master;

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
use Hash;
use cruds;
use ValidUnique;
use ValidDB;
use logs;
use Helper;
use activeMenuNames;
use docTypes;
class ProductGroupPriceController extends Controller{
	private $general;
	private $UserID;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $Settings;
	private $FileTypes;
    private $Menus;
    public function __construct(){
		$this->ActiveMenuName=activeMenuNames::ProductGroupPrice->value;
		$this->PageTitle="Product Group Price";
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
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['menus']=$this->Menus;
			$FormData['crud']=$this->CRUD;
			return view('master.product-group-price.view',$FormData);
		}elseif($this->general->isCrudAllow($this->CRUD,"Add")==true){
			return Redirect::to('/master/product-group-price/create');
		}else{
			return view('errors.403');
		}
	}
	public function groupPriceView(request $req,$ProductID){
        $sql="SELECT H.GroupID,H.GroupName,H.isDefault,H.ActiveStatus,'".$ProductID."'  as ProductID,0 as CostPrice,'Amount' as PriceType,0 as Price,0 as SalesPrice,0 as isShow,0 as isShowLoginUsers FROM tbl_customer_groups as H ";
        $EditData=DB::SELECT($sql);
        for($i=0;$i<count($EditData);$i++){
            $t=DB::Table('tbl_customer_group_price')->where('GroupID',$EditData[$i]->GroupID)->where('ProductID',$ProductID)->get();
            if(count($t)>0){
                $EditData[$i]->CostPrice=$t[0]->CostPrice;
                $EditData[$i]->PriceType=$t[0]->PriceType;
                $EditData[$i]->Price=$t[0]->Price;
                $EditData[$i]->SalesPrice=$t[0]->SalesPrice;
                $EditData[$i]->isShow=$t[0]->isShow;
                $EditData[$i]->isShowLoginUsers=$t[0]->isShowLoginUsers;
            }
        }

		$FormData=$this->general->UserInfo;
		$FormData['menus']=$this->Menus;
		$FormData['crud']=$this->CRUD;
		$FormData['ActiveMenuName']=$this->ActiveMenuName;
		$FormData['PageTitle']=$this->PageTitle;
		$FormData['FileTypes']=$this->FileTypes;
		$FormData['ProductID']=$ProductID;
		$FormData['EditData']=$EditData; 
		if(count($FormData['EditData'])>0){
			$FormData['EditData']=$FormData['EditData'];
			return view('master.product-group-price.group-prices',$FormData);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}	
	}
	private function getProducts($data=array()){
		$sql =" SELECT P.ProductID, P.ProductCode, P.ProductName, P.CategoryID, C.CName as CategoryName, P.SubCategoryID, SC.SCName as SubCategoryName, P.GradeID, PG.Grade, P.UOMID, U.UName, U.UCode, P.TaxID, T.TaxName, T.TaxPercentage, ";
		$sql.=" P.TaxType, P.MRP, P.PurchasePrice, P.SalesPrice, P.MinQty, P.MaxQty, P.DecimalPlaces, P.ProductImage, P.ActiveStatus, P.DFlag, P.CreatedOn, P.UpdatedOn, P.DeletedOn, P.CreatedBy, P.UpdatedBy, P.DeletedBy ";
		$sql.=" FROM tbl_products as P LEFT JOIN tbl_product_grades as PG ON PG.GID=P.GradeID LEFT JOIN tbl_category as C ON C.CID=P.CategoryID LEFT JOIN tbl_subcategory as SC ON SC.SCID=P.SubCategoryID ";
		$sql.=" LEFT JOIN tbl_tax as T ON T.TaxID=P.TaxID LEFT JOIN tbl_uom as U ON U.UID=P.UOMID ";
		$sql.=" Where 1=1 ";
		if(is_array($data)){
			if(array_key_exists("ProductID",$data)){$sql.=" and P.ProductID='".$data['ProductID']."'";}
			if(array_key_exists("ProductName",$data)){$sql.=" and P.ProductName='".$data['ProductName']."'";}
			if(array_key_exists("CategoryID",$data)){$sql.=" and P.CategoryID='".$data['CategoryID']."'";}
			if(array_key_exists("SubCategoryID",$data)){$sql.=" and P.SubCategoryID='".$data['SubCategoryID']."'";}
			if(array_key_exists("GradeID",$data)){$sql.=" and P.GradeID='".$data['GradeID']."'";}
			if(array_key_exists("UOMID",$data)){$sql.=" and P.UOMID='".$data['UOMID']."'";}
			if(array_key_exists("TaxID",$data)){$sql.=" and P.TaxID='".$data['TaxID']."'";}
			if(array_key_exists("ActiveStatus",$data)){$sql.=" and P.ActiveStatus='".$data['ActiveStatus']."'";}
			if(array_key_exists("DFlag",$data)){$sql.=" and P.DFlag='".$data['DFlag']."'";}
		}
		$sql.=" Order By P.ProductName ";
		$result=DB::SELECT($sql);
		for($i=0;$i<count($result);$i++){
			$sql="SELECT GP.SLNO, GP.GroupID, CG.GroupName, CG.isDefault, GP.ProductID, GP.Price ,GP.isShow, GP.isShowLoginUsers, GP.CreatedOn, GP.UpdatedOn, GP.CreatedBy, GP.UpdatedBy FROM tbl_customer_group_price as GP LEFT JOIN tbl_customer_groups as CG ON CG.GroupID=GP.GroupID";
			$sql.=" Where GP.ProductID='".$result[$i]->ProductID."' Order By GP.GroupID";
			$GroupPrices=DB::SELECT($sql);
			$result[$i]->groupPrices=$GroupPrices;

			$galleryImages=DB::Table('tbl_product_gallery')->where('ProductID',$result[$i]->ProductID)->get();
			$result[$i]->galleryImages=$galleryImages;
		}
		return $result;
	}
	public function UpdateGroupPrices(Request $req,$ProductID){
		$OldData=$this->getProducts(array("ProductID"=>$ProductID));$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			
			DB::beginTransaction();
			$status=true;
			try {
				$groupPrices=json_decode($req->groupPrices);
				for($i=0;$i<count($groupPrices);$i++){
					if($status){
						$t=DB::Table('tbl_customer_group_price')->where('ProductID',$ProductID)->where('GroupID',$groupPrices[$i]->groupID)->get();
						if(count($t)>0){

							$tdata=array(
								"Price"=>$groupPrices[$i]->price,
								"isShow"=>$groupPrices[$i]->isShow,
								"isShowLoginUsers"=>$groupPrices[$i]->isShowLoginUsers,
								"UpdatedBy"=>$this->UserID,
								"UpdatedOn"=>date("Y-m-d H:i:s")
							);
							$status=DB::Table('tbl_customer_group_price')->where('ProductID',$ProductID)->where('GroupID',$groupPrices[$i]->groupID)->update($tdata);
						}else{
							$tdata=array(
								"SLNO"=>DocNum::getDocNum(docTypes::CustomerGroupPrice->value),
								"GroupID"=>$groupPrices[$i]->groupID,
								"ProductID"=>$ProductID,
								"Price"=>$groupPrices[$i]->price,
								"isShow"=>$groupPrices[$i]->isShow,
								"isShowLoginUsers"=>$groupPrices[$i]->isShowLoginUsers,
								"CreatedBy"=>$this->UserID,
								"CreatedOn"=>date("Y-m-d H:i:s")
							);
							$status=DB::Table('tbl_customer_group_price')->insert($tdata);
							if($status){
								DocNum::updateDocNum(docTypes::CustomerGroupPrice->value);
							}
						}
					}
				}
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DB::commit();
				$NewData=$this->getProducts(array("ProductID"=>$ProductID));
				$logData=array("Description"=>"Update Group Price","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE->value,"ReferID"=>$ProductID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Updated Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Update Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'P.ProductName', 'dt' => '0' ),
				array( 'db' => 'P.ProductCode', 'dt' => '1' ),
				array( 'db' => 'PG.Grade', 'dt' => '2' ),
				array( 'db' => 'C.CName', 'dt' => '3' ),
				array( 'db' => 'SC.SCName', 'dt' => '4' ),
				array( 'db' => 'P.PurchasePrice', 'dt' => '5','formatter' => function( $d, $row ) { return Helper::NumberFormat($d,$this->Settings['price-decimals']);}  ),
				array( 'db' => 'P.CostPrice', 'dt' => '6','formatter' => function( $d, $row ) { return Helper::NumberFormat($d,$this->Settings['price-decimals']);} ),
				array( 
						'db' => 'P.ActiveStatus', 
						'dt' => '7',
						'formatter' => function( $d, $row ) {
							if($d=="Active"){
								return "<span class='badge badge-success m-1'>Active</span>";
							}else{
								return "<span class='badge badge-danger m-1'>Inactive</span>";
							}
						} 
                    ),
				array( 
						'db' => 'P.ProductID', 
						'dt' => '8',
						'formatter' => function( $d, $row ) {
							$html='';
							$html.='<button type="button" data-id="'.$d.'"  data-name="'.$row['ProductName'].'" data-code="'.$row['ProductCode'].'" class="btn  btn-outline-primary  '.$this->general->UserInfo['Theme']['button-size'].' m-5 mr-10 btnGroupPriceDetails" data-original-title="Edit"><i class="fa fa-eye"></i></button>';
							return $html;
						} 
				)
			);
			$columns1 = array(
				array( 'db' => 'ProductName', 'dt' => '0' ),
				array( 'db' => 'ProductCode', 'dt' => '1' ),
				array( 'db' => 'Grade', 'dt' => '2' ),
				array( 'db' => 'CName', 'dt' => '3' ),
				array( 'db' => 'SCName', 'dt' => '4' ),
				array( 'db' => 'PurchasePrice', 'dt' => '5','formatter' => function( $d, $row ) { return Helper::NumberFormat($d,$this->Settings['price-decimals']);}  ),
				array( 'db' => 'CostPrice', 'dt' => '6','formatter' => function( $d, $row ) { return Helper::NumberFormat($d,$this->Settings['price-decimals']);}  ),
				array( 
						'db' => 'ActiveStatus', 
						'dt' => '7',
						'formatter' => function( $d, $row ) {
							if($d=="Active"){
								return "<span class='badge badge-success m-1'>Active</span>";
							}else{
								return "<span class='badge badge-danger m-1'>Inactive</span>";
							}
						} 
                    ),
				array( 
						'db' => 'ProductID', 
						'dt' => '8',
						'formatter' => function( $d, $row ) {
							$html='';
							$html.='<button type="button" data-name="'.$row['ProductName'].'" data-code="'.$row['ProductCode'].'" data-id="'.$d.'" class="btn  btn-outline-primary  '.$this->general->UserInfo['Theme']['button-size'].' m-5 mr-10 btnGroupPriceDetails" data-original-title="Edit"><i class="fa fa-eye"></i></button>';
							return $html;
						} 
				)
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_products as P LEFT JOIN tbl_product_grades as PG ON PG.GID=P.GradeID LEFT JOIN tbl_category as C ON C.CID=P.CategoryID LEFT JOIN tbl_subcategory as SC ON SC.SCID=P.SubCategoryID LEFT JOIN tbl_tax as T ON T.TaxID=P.TaxID LEFT JOIN tbl_uom as U ON U.UID=P.UOMID';
			$data['PRIMARYKEY']='P.ProductID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns1;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" P.DFlag=0 ";
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}

}
