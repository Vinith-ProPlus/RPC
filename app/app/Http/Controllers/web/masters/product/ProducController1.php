<?php
namespace App\Http\Controllers\web\masters\product;

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
use ValidDB;
use logs;
use Helper;
use activeMenuNames;
use docTypes;
use cruds;
use Product;
use Session;
class ProductssController extends Controller{
	private $general;
	private $DocNum;
	private $UserID;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $Settings;
	private $FileTypes;
    private $Menus;
    public function __construct(){
		$this->ActiveMenuName=activeMenuNames::Products->value;
		$this->PageTitle="Products";
        $this->middleware('auth');
		$this->FileTypes=Helper::getFileTypes(array("category"=>array("Images","Documents")));
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
            return view('app.master.product.products.view',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"add")==true){
			return Redirect::to('/admin/master/product/products/create');
        }else{
            return view('errors.403');
        }
    }
    public function TrashView(Request $req){
        if($this->general->isCrudAllow($this->CRUD,"restore")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
            return view('app.master.product.products.trash',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/admin/master/product/products/');
        }else{
            return view('errors.403');
        }
    }
    public function create(Request $req){
        if($this->general->isCrudAllow($this->CRUD,"add")==true){
            $OtherCruds=array(
				"Country"=>$this->general->getCrudOperations(activeMenuNames::Country->value),
				"States"=>$this->general->getCrudOperations(activeMenuNames::States->value),
				"Districts"=>$this->general->getCrudOperations(activeMenuNames::Districts->value),
				"Taluks"=>$this->general->getCrudOperations(activeMenuNames::Taluks->value),
				"PostalCodes"=>$this->general->getCrudOperations(activeMenuNames::PostalCodes->value),
				"City"=>$this->general->getCrudOperations(activeMenuNames::City->value),
				"Category"=>$this->general->getCrudOperations(activeMenuNames::ProductCategory->value),
				"SubCategory"=>$this->general->getCrudOperations(activeMenuNames::ProductSubCategory->value),
				"Brands"=>$this->general->getCrudOperations(activeMenuNames::Brands->value),
				"Tax"=>$this->general->getCrudOperations(activeMenuNames::Tax->value),
				"uom"=>$this->general->getCrudOperations(activeMenuNames::UOM->value),
			);
            $FormData=$this->general->UserInfo;
			$FormData['OtherCruds']=$OtherCruds;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=false;
			$FormData['FileTypes']=$this->FileTypes;
            return view('app.master.product.products.create',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/master/product/products/');
        }else{
            return view('errors.403');
        }
    }
    public function edit(Request $req,$ProductID){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $OtherCruds=array(
				"Country"=>$this->general->getCrudOperations(activeMenuNames::Country->value),
				"States"=>$this->general->getCrudOperations(activeMenuNames::States->value),
				"Districts"=>$this->general->getCrudOperations(activeMenuNames::Districts->value),
				"Taluks"=>$this->general->getCrudOperations(activeMenuNames::Taluks->value),
				"PostalCodes"=>$this->general->getCrudOperations(activeMenuNames::PostalCodes->value),
				"City"=>$this->general->getCrudOperations(activeMenuNames::City->value),
				"Category"=>$this->general->getCrudOperations(activeMenuNames::ProductCategory->value),
				"SubCategory"=>$this->general->getCrudOperations(activeMenuNames::ProductSubCategory->value),
				"Brands"=>$this->general->getCrudOperations(activeMenuNames::Brands->value),
				"Tax"=>$this->general->getCrudOperations(activeMenuNames::Tax->value),
				"uom"=>$this->general->getCrudOperations(activeMenuNames::UOM->value),
			);
            $FormData=$this->general->UserInfo;
			$FormData['OtherCruds']=$OtherCruds;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=true;
			$FormData['ProductID']=$ProductID;
			$FormData['FileTypes']=$this->FileTypes;
			$FormData['data']=$this->getProduct($ProductID);
			if(count($FormData['data'])>0){
				$FormData['data']=$FormData['data'][0];
				return view('app.master.product.products.create',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/master/product/products/');
        }else{
            return view('errors.403');
        }
    }
	public function getSaveProcessStatus(Request $req){
		
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');
		Product::getSaveProcessStatus($this->UserID);
	}
	private function getProduct($ProductID){
        $sql="SELECT P.ProductID, P.Slug, P.ProductName, P.ProductType, P.HSNSAC, P.ProductCode, P.VideoURL, P.CID, C.PCName, P.SCID, SC.PSCName, P.UID, U.UName, U.UCode, P.TaxType, P.TaxID, P.PRate, P.SRate, P.Decimals, P.Description, ";
        $sql.=" P.ShortDescription, P.Attributes, P.ProductImage, P.ProductBrochure, P.Images, P.ActiveStatus, P.DFlag FROM tbl_products as P LEFT JOIN tbl_product_category as C ON C.PCID=P.CID ";
        $sql.=" LEFT JOIN tbl_product_subcategory as SC ON SC.PSCID=P.SCID LEFT JOIn tbl_uom as U ON U.UID=P.UID LEFT JOIN tbl_tax as T ON T.TaxID=P.TaxID Where P.ProductID='".$ProductID."'";
		$result=DB::SELECT($sql);
		for($i=0;$i<count($result);$i++){
			$pGallery=DB::Table('tbl_products_gallery')->where('ProductID',$result[$i]->ProductID)->get();
			for($k=0;$k<count($pGallery);$k++){
				$pGallery[$k]->ext= pathinfo($pGallery[$k]->gImage,PATHINFO_EXTENSION);
				$pGallery[$k]->fileName= basename($pGallery[$k]->gImage);
				$pGallery[$k]->Images=unserialize($pGallery[$k]->Images);
				$pGallery[$k]->gImage=Helper::checkProductImageExists($pGallery[$k]->gImage);
			}
			$variaton=DB::Table('tbl_products_variation')->where('ProductID',$result[$i]->ProductID)->get();
			for($j=0;$j<count($variaton);$j++){
				$tmp1=DB::Table('tbl_products_variation_gallery')->where('ProductID',$result[$i]->ProductID)->where('VariationID',$variaton[$j]->VariationID)->get();
				for($k=0;$k<count($tmp1);$k++){
					$tmp1[$k]->ext= pathinfo($tmp1[$k]->gImage,PATHINFO_EXTENSION);
					$tmp1[$k]->fileName= basename($tmp1[$k]->gImage);
					$tmp1[$k]->Images=unserialize($tmp1[$k]->Images);
					$tmp1[$k]->gImage=Helper::checkProductImageExists($tmp1[$k]->gImage);
				}
				$sql="SELECT D.DetailID, D.ProductID, D.VariationID, D.AttributeID, A.AttrName, D.AttributeValueID, AD.Values, D.DFlag FROM tbl_products_variation_details as D LEFT JOIN tbl_attributes_details as AD ON AD.ValueID=D.AttributeValueID and AD.AttrID=D.AttributeID LEFT JOIN tbl_attributes as A On A.AttrID=Ad.AttrID ";
				$sql.=" Where D.ProductID='".$result[$i]->ProductID."' and D.VariationID='".$variaton[$j]->VariationID."'";
				$variaton[$j]->AttributeDetails=DB::Select($sql);
				
				$variaton[$j]->Attributes=unserialize($variaton[$j]->Attributes);
				$variaton[$j]->Images=unserialize($variaton[$j]->Images);
				$variaton[$j]->gallery=$tmp1;
				$variaton[$j]->VImage=Helper::checkProductImageExists($variaton[$j]->VImage);
				$variaton[$j]->VImageExt= pathinfo($variaton[$j]->VImage,PATHINFO_EXTENSION);
				$variaton[$j]->VImageFileName= basename($variaton[$j]->VImage);
			}
			$result[$i]->Attributes=unserialize($result[$i]->Attributes);
			$result[$i]->Images=unserialize($result[$i]->Images);
			$result[$i]->variation=$variaton;
			$result[$i]->gallery=$pGallery;
			$result[$i]->ProductImage=Helper::checkProductImageExists($result[$i]->ProductImage);
		}
		return $result;
	}
    public function getProductDetails(Request $req,$ProductID){
		return $this->getProduct($ProductID);
    }
	public function save(Request $req){
        header('Content-Type: application/json');
        header('Cache-Control: no-cache');
		if($this->general->isCrudAllow($this->CRUD,"add")==true){
			$result= Product::save($req,$this->UserID);
			return response()->json($result);
		}else{
			return response()->json(['status' => false, 'message' => 'Access denied']);
		}
	}
	public function update(Request $req,$ProductID){
        header('Content-Type: application/json');
        header('Cache-Control: no-cache');
		if($this->general->isCrudAllow($this->CRUD,"add")==true){
			$result= Product::save($req,$this->UserID);
			return response()->json($result);
		}else{
			return response()->json(['status' => false, 'message' => 'Access denied']);
		}
	}
	public function Delete(Request $req,$ProductID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=$this->getProduct($ProductID);
				$status=DB::table('tbl_products')->where('ProductID',$ProductID)->update(array("DFlag"=>1,"DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Product has been Deleted ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::DELETE->value,"ReferID"=>$ProductID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Product Deleted Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Product Delete Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function Restore(Request $req,$ProductID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=$this->getProduct($ProductID);
				$status=DB::table('tbl_products')->where('ProductID',$ProductID)->update(array("DFlag"=>0,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$NewData=$this->getProduct($ProductID);
				$logData=array("Description"=>"Product has been Restored ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::RESTORE->value,"ReferID"=>$ProductID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Product Restored Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Product Restore Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'P.ProductName', 'dt' => '0' ),
				array( 'db' => 'C.PCName', 'dt' => '1' ),
				array( 'db' => 'SC.PSCName', 'dt' => '2' ),
				//array( 'db' => 'P.ProductType', 'dt' => '3' ),
				array( 'db' => 'P.PRate', 'dt' => '3' ),
				array( 'db' => 'P.SRate', 'dt' => '4' ),
				array( 'db' => 'P.ActiveStatus', 'dt' => '5'),
				array( 'db' => 'P.ProductID', 'dt' => '6'),
			);
			$columns1 = array(
				array( 'db' => 'ProductName', 'dt' => '0' ),
				array( 'db' => 'PCName', 'dt' => '1' ),
				array( 'db' => 'PSCName', 'dt' => '2' ),
				//array( 'db' => 'ProductType', 'dt' => '3' ),
				array( 'db' => 'PRate', 'dt' => '3','formatter' => function( $d, $row ) { return Helper::NumberFormat($d,$this->Settings['PRICE-DECIMALS']);}),
				array( 'db' => 'SRate', 'dt' => '4','formatter' => function( $d, $row ) { return Helper::NumberFormat($d,$this->Settings['PRICE-DECIMALS']);}),
				array( 
					'db' => 'ActiveStatus', 
					'dt' => '5',
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
					'dt' => '6',
					'formatter' => function( $d, $row ) {
						$html='';
						if($this->general->isCrudAllow($this->CRUD,"edit")==true){
							$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].' mr-10 btnEdit" title="Edit"><i class="fa fa-pencil"></i></button>';
						}
						if($this->general->isCrudAllow($this->CRUD,"delete")==true){
							$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-danger '.$this->general->UserInfo['Theme']['button-size'].' btnDelete" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
						}
						return $html;
					} 
				),
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_products as P left join tbl_product_category as C on C.PCID = P.CID left join tbl_product_subcategory as SC on SC.PSCID = P.SCID';
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

	public function TrashTableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			$columns = array(
				array( 'db' => 'P.ProductName', 'dt' => '0' ),
				array( 'db' => 'C.PCName', 'dt' => '1' ),
				array( 'db' => 'SC.PSCName', 'dt' => '2' ),
				//array( 'db' => 'P.ProductType', 'dt' => '3' ),
				array( 'db' => 'P.PRate', 'dt' => '3' ),
				array( 'db' => 'P.SRate', 'dt' => '4' ),
				array( 'db' => 'P.ActiveStatus', 'dt' => '5',),
				array( 'db' => 'P.ProductID', 'dt' => '6',),
			);
			$columns1 = array(
				array( 'db' => 'ProductName', 'dt' => '0' ),
				array( 'db' => 'PCName', 'dt' => '1' ),
				array( 'db' => 'PSCName', 'dt' => '2' ),
				//array( 'db' => 'ProductType', 'dt' => '3' ),
				array( 'db' => 'PRate', 'dt' => '3','formatter' => function( $d, $row ) { return Helper::NumberFormat($d,$this->Settings['PRICE-DECIMALS']);}),
				array( 'db' => 'SRate', 'dt' => '4','formatter' => function( $d, $row ) { return Helper::NumberFormat($d,$this->Settings['PRICE-DECIMALS']);}),
				array( 
					'db' => 'ActiveStatus', 
					'dt' => '5',
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
					'dt' => '6',
					'formatter' => function( $d, $row ) {
						$html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].'  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
						return $html;
					} 
				),
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_products as P left join tbl_product_category as C on C.PCID = P.CID left join tbl_product_subcategory as SC on SC.PSCID = P.SCID';
			$data['PRIMARYKEY']='P.ProductID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns1;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" P.DFlag=1 ";
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	
	//get
	public function getCategory(request $req){
		return DB::Table('tbl_product_category')->where('DFlag',0)->where('ActiveStatus','Active')->get();
	}
	public function getSubCategory(request $req){
		return DB::Table('tbl_product_subcategory')->Where('PCID',$req->CID)->where('DFlag',0)->where('ActiveStatus','Active')->get();
	}
	public function getBrands(request $req){
		return DB::Table('tbl_brands')->where('DFlag',0)->where('ActiveStatus','Active')->get();
	}
	public function getTax(request $req){
		return DB::Table('tbl_tax')->where('DFlag',0)->where('ActiveStatus','Active')->get();
	}
	public function getUOM(request $req){
		return DB::Table('tbl_uom')->where('DFlag',0)->where('ActiveStatus','Active')->get();
	}
	public function getAttributes(Request $req){
		$sql="Select * From tbl_attributes Where ActiveStatus='Active' and DFlag=0 and AttrID In(Select AttrID From tbl_attributes_category_mapping Where PCID='".$req->PCID."' and PSCID='".$req->PSCID."' And DFlag=0)";
		return DB::SELECT($sql);
	}
	public function getAttributeDetails(Request $req){
		$sql="Select * From tbl_attributes_details Where DFlag=0 and AttrID='".$req->AID."' AND ValueID In(Select ValueID From tbl_attributes_category_mapping Where PCID='".$req->PCID."' and PSCID='".$req->PSCID."' And DFlag=0)";
		return DB::SELECT($sql);
	}
}
