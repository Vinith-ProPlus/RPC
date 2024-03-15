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
class ProductsController extends Controller{
	private $general;
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
			return view('master.products.view',$FormData);
		}elseif($this->general->isCrudAllow($this->CRUD,"Add")==true){
			return Redirect::to('/master/products/create');
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
            return view('master.products.trash',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/master/products/');
        }else{
            return view('errors.403');
        }
    }
    public function create(Request $req){
        if($this->general->isCrudAllow($this->CRUD,"add")==true){
			$OtherCruds=array(
				"Grade"=>$this->general->getCrudOperations(activeMenuNames::ProductGrades->value),
				"Category"=>$this->general->getCrudOperations(activeMenuNames::Category->value),
				"SubCategory"=>$this->general->getCrudOperations(activeMenuNames::SubCategory->value),
				"UOM"=>$this->general->getCrudOperations(activeMenuNames::UOM->value),
				"Tax"=>$this->general->getCrudOperations(activeMenuNames::Tax->value),
				"CustomerGroups"=>$this->general->getCrudOperations(activeMenuNames::CustomerGroups->value),
			);
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=false;
			$FormData['FileTypes']=$this->FileTypes;
			$FormData['OtherCruds']=$OtherCruds;
            return view('master.products.product',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/master/products/');
        }else{
            return view('errors.403');
        }
    }
    public function edit(Request $req,$ProductID){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OtherCruds=array(
				"Grade"=>$this->general->getCrudOperations(activeMenuNames::ProductGrades->value),
				"Category"=>$this->general->getCrudOperations(activeMenuNames::Category->value),
				"SubCategory"=>$this->general->getCrudOperations(activeMenuNames::SubCategory->value),
				"UOM"=>$this->general->getCrudOperations(activeMenuNames::UOM->value),
				"Tax"=>$this->general->getCrudOperations(activeMenuNames::Tax->value),
				"CustomerGroups"=>$this->general->getCrudOperations(activeMenuNames::CustomerGroups->value),
			);
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=true;
			$FormData['FileTypes']=$this->FileTypes;
			$FormData['OtherCruds']=$OtherCruds;
			$FormData['ProductID']=$ProductID;
			$FormData['EditData']=$this->getProducts(array("ProductID"=>$ProductID,"DFlag"=>0));
			if(count($FormData['EditData'])>0){
				$FormData['EditData']=$FormData['EditData'][0];
				return view('master.products.product',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/master/product-grades/');
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
			return view('master.products.group-prices',$FormData);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}	
	}
	private function getProducts($data=array()){
		$sql =" SELECT P.ProductID, P.ProductCode, P.ProductName, P.CategoryID, C.CName as CategoryName, P.SubCategoryID, SC.SCName as SubCategoryName, P.GradeID, PG.Grade, P.UOMID, U.UName, U.UCode, P.TaxID, T.TaxName, T.TaxPercentage, ";
		$sql.=" P.TaxType, P.MRP, P.PurchasePrice, P.CostPrice, P.MinQty, P.MaxQty, P.DecimalPlaces, P.ProductImage, P.Images, P.ActiveStatus, P.DFlag, P.CreatedOn, P.UpdatedOn, P.DeletedOn, P.CreatedBy, P.UpdatedBy, P.DeletedBy ";
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
			$result[$i]->Images=$result[$i]->Images!=""?unserialize($result[$i]->Images):array();

			$sql="SELECT GP.SLNO, GP.GroupID, CG.GroupName, CG.isDefault, GP.ProductID, GP.CostPrice, GP.PriceType, GP.Price, GP.SalesPrice, GP.isShow, GP.isShowLoginUsers, GP.CreatedOn, GP.UpdatedOn, GP.CreatedBy, GP.UpdatedBy FROM tbl_customer_group_price as GP LEFT JOIN tbl_customer_groups as CG ON CG.GroupID=GP.GroupID";
			$sql.=" Where GP.ProductID='".$result[$i]->ProductID."' Order By GP.GroupID";
			$GroupPrices=DB::SELECT($sql); 
			$result[$i]->groupPrices=$GroupPrices;

			$galleryImages=DB::Table('tbl_product_gallery')->where('ProductID',$result[$i]->ProductID)->get();
			for($j=0;$j<count($galleryImages);$j++){
				$galleryImages[$j]->Images=$galleryImages[$j]->Images!=""?unserialize($galleryImages[$j]->Images):array();
			}
			$result[$i]->galleryImages=$galleryImages;
		}
		return $result;
	}
    public function save(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"add")==true){
			$OldData=array();$NewData=array();$ProductID="";
			$ValidDB=array();
			$galleryNames=json_decode($req->GalleryNames,true);
			//Category
			$ValidDB['Category']['TABLE']="tbl_category";
			$ValidDB['Category']['ErrMsg']="Category name does  not exist";
			$ValidDB['Category']['WHERE'][]=array("COLUMN"=>"CID","CONDITION"=>"=","VALUE"=>$req->Category);
			$ValidDB['Category']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);
			$ValidDB['Category']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>'Active');
			//Sub Category
			$ValidDB['SubCategory']['TABLE']="tbl_subcategory";
			$ValidDB['SubCategory']['ErrMsg']="Sub Category name does  not exist";
			$ValidDB['SubCategory']['WHERE'][]=array("COLUMN"=>"SCID","CONDITION"=>"=","VALUE"=>$req->SubCategory);
			$ValidDB['SubCategory']['WHERE'][]=array("COLUMN"=>"CID","CONDITION"=>"=","VALUE"=>$req->Category);
			$ValidDB['SubCategory']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);
			$ValidDB['SubCategory']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>'Active');
			//Grade
			$ValidDB['Grade']['TABLE']="tbl_product_grades";
			$ValidDB['Grade']['ErrMsg']="Grade does  not exist";
			$ValidDB['Grade']['WHERE'][]=array("COLUMN"=>"GID","CONDITION"=>"=","VALUE"=>$req->Grade);
			$ValidDB['Grade']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);
			$ValidDB['Grade']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>'Active');
			//Tax
			$ValidDB['Tax']['TABLE']="tbl_tax";
			$ValidDB['Tax']['ErrMsg']="Tax does  not exist";
			$ValidDB['Tax']['WHERE'][]=array("COLUMN"=>"TaxID","CONDITION"=>"=","VALUE"=>$req->Tax);
			$ValidDB['Tax']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);
			$ValidDB['Tax']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>'Active');
			//UOM
			$ValidDB['UOM']['TABLE']="tbl_uom";
			$ValidDB['UOM']['ErrMsg']="Unit of Measurement does  not exist";
			$ValidDB['UOM']['WHERE'][]=array("COLUMN"=>"UID","CONDITION"=>"=","VALUE"=>$req->UOM);
			$ValidDB['UOM']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);
			$ValidDB['UOM']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>'Active');

			$rules=array(
				'ProductCode'=>['required','min:2','max:30',new ValidUnique(array("TABLE"=>"tbl_products","WHERE"=>" ProductCode='".$req->ProductCode."'  "),"This Product Code  is already taken.")],
				'ProductName' =>['required','min:2','max:150',new ValidUnique(array("TABLE"=>"tbl_products","WHERE"=>" ProductName='".$req->ProductName."'  "),"This Product Name  is already taken.")],
				'Category'=> ['required',new ValidDB($ValidDB['Category'])],
				'SubCategory'=> ['required',new ValidDB($ValidDB['SubCategory'])],
				'Grade'=> ['required',new ValidDB($ValidDB['Grade'])],
				'Tax'=> ['required',new ValidDB($ValidDB['Tax'])],
				'UOM'=> ['required',new ValidDB($ValidDB['UOM'])],
				'TaxType'=>'required|in:Include,Exclude',
				'MRP'=>'required|numeric|min:0',
				'PurchaseRate'=>'required|numeric|min:0',
				'CostPrice'=>'required|numeric|min:0',
				'MinQty'=>'required|numeric|min:0',
				'MaxQty'=>'required|numeric|min:0',
				'Decimals'=>'required|in:auto, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9',
				'ActiveStatus'=>'required|in:Active, Inactive',
			);
			if($req->hasFile('ProductImage')){
				$rules['ProductImage']='mimes:'.implode(",",$this->FileTypes['category']['Images']);
			}
			if(is_array($galleryNames)){
				foreach($galleryNames as $index=>$galleryName){
					if($req->hasFile($galleryName)){
						$rules[$galleryName]='mimes:'.implode(",",$this->FileTypes['category']['Images']);
					}
				}
			}
			$message=array();
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Product Create Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			$ProductImage="";
			$galleryImages=array();
			$pImages=array();
			try {
				$ProductID=DocNum::getDocNum(docTypes::Product->value);
				$dir="uploads/master/products/".$ProductID."/";
				if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
				if($req->hasFile('ProductImage')){
					$file = $req->file('ProductImage');
					$fileName=md5($file->getClientOriginalName() . time());
					$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
					$file->move($dir, $fileName1);
					$ProductImage=$dir.$fileName1;
				}else if(Helper::isJSON($req->ProductImage)==true){
					$Img=json_decode($req->ProductImage);
					if(file_exists($Img->uploadPath)){
						$fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
						copy($Img->uploadPath,$dir.$fileName1);
						$ProductImage=$dir.$fileName1;
						unlink($Img->uploadPath);
					}
				}
				if(is_array($galleryNames)){
					foreach($galleryNames as $index=>$galleryName){
						if($req->hasFile($galleryName)){
							if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
							$file = $req->file($galleryName);
							$fileName=md5($file->getClientOriginalName() . time());
							$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
							$file->move($dir, $fileName1);
							$t=array("gImage"=>$dir.$fileName1,"Images"=>array());
							$t['Images']=helper::ImageResize($dir.$fileName1,$dir);
							$galleryImages[]=$t;
						}
					};
				}
				
				if(Helper::isJSON($req->galleryImages)==true){
					$gImgs=json_decode($req->galleryImages);
					if(is_array($gImgs)){
						foreach($gImgs as $RowIndex=>$gImg){
							if(file_exists($gImg->uploadPath)){
								$fileName1=$gImg->fileName!=""?$gImg->fileName:Helper::RandomString(10)."png";
								copy($gImg->uploadPath,$dir.$fileName1);
								
								$t=array("gImage"=>$dir.$fileName1,"slno"=>$gImg->slno,"Images"=>array());
								$t['Images']=helper::ImageResize($dir.$fileName1,$dir);
								$galleryImages[]=$t;

								//$galleryImages[]=array("Image"=>$dir.$fileName1,"slno"=>$gImg->slno);
							}
						}
					}
				}
				
				if(file_exists($ProductImage)){
					$pImages=helper::ImageResize($ProductImage,$dir);
				}
				$data=array(
					"ProductID"=>$ProductID,
					"ProductCode"=>$req->ProductCode,
					"ProductName"=>$req->ProductName,
					"GradeID"=>$req->Grade,
					"CategoryID"=>$req->Category,
					"SubCategoryID"=>$req->SubCategory,
					"TaxID"=>$req->Tax,
					"UOMID"=>$req->UOM,
					"MRP"=>$req->MRP,
					"PurchasePrice"=>$req->PurchaseRate,
					"CostPrice"=>$req->CostPrice,
					"MinQty"=>$req->MinQty,
					"MaxQty"=>$req->MaxQty,
					"DecimalPlaces"=>$req->Decimals,
					"ProductImage"=>$ProductImage,
					"Images"=>serialize($pImages),
					"ActiveStatus"=>$req->ActiveStatus,
					"CreatedBy"=>$this->UserID,
					"CreatedOn"=>date("Y-m-d H:i:s")
				);
				$status=DB::Table('tbl_products')->insert($data);
				if($status){
					$groupPrices=json_decode($req->groupPrices);
					for($i=0;$i<count($groupPrices);$i++){
						if($status){
							$tdata=array(
								"SLNO"=>DocNum::getDocNum(docTypes::CustomerGroupPrice->value),
								"GroupID"=>$groupPrices[$i]->groupID,
								"ProductID"=>$ProductID,
								"CostPrice"=>$groupPrices[$i]->costPrice,
								"Price"=>$groupPrices[$i]->price,
								"PriceType"=>$groupPrices[$i]->priceType,
								"SalesPrice"=>$groupPrices[$i]->salesPrice,
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
				if(count($galleryImages)>0 && $status==true){
					for($i=0;$i<count($galleryImages);$i++){
						if($status){
							$tdata=array(
								"SLNO"=>DocNum::getDocNum(docTypes::ProductGallery->value),
								"ProductID"=>$ProductID,
								"gImage"=>$galleryImages[$i]['gImage'],
								"Images"=>serialize($galleryImages[$i]['Images']),
								"CreatedBy"=>$this->UserID,
								"CreatedOn"=>date("Y-m-d H:i:s")

							);
							$status=DB::Table('tbl_product_gallery')->insert($tdata);
							if($status){
								DocNum::updateDocNum(docTypes::ProductGallery->value);
							}
						}
					}
				}
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DocNum::updateDocNum(docTypes::Product->value);
				DB::commit();
				$NewData=$this->getProducts(array("ProductID"=>$ProductID));
				$logData=array("Description"=>"New Product Created ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::ADD->value,"ReferID"=>$ProductID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Product Created Successfully");
			}else{
				DB::rollback();
				
				foreach($pImages as $KeyName=>$Img){
					Helper::removeFile($Img['url']);
				}
				foreach($galleryImages as $rowIndex=>$images){
					foreach($images['Images'] as $KeyName=>$Img){
						Helper::removeFile($Img['url']);
					}
				}
				return array('status'=>false,'message'=>"Product Create Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
    public function update(Request $req,$ProductID){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OldData=$this->getProducts(array("ProductID"=>$ProductID));$NewData=array();
			$ValidDB=array();
			$galleryNames=json_decode($req->GalleryNames,true);
			//Category
			$ValidDB['Category']['TABLE']="tbl_category";
			$ValidDB['Category']['ErrMsg']="Category name does  not exist";
			$ValidDB['Category']['WHERE'][]=array("COLUMN"=>"CID","CONDITION"=>"=","VALUE"=>$req->Category);
			$ValidDB['Category']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);
			$ValidDB['Category']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>'Active');
			//Sub Category
			$ValidDB['SubCategory']['TABLE']="tbl_subcategory";
			$ValidDB['SubCategory']['ErrMsg']="Sub Category name does  not exist";
			$ValidDB['SubCategory']['WHERE'][]=array("COLUMN"=>"SCID","CONDITION"=>"=","VALUE"=>$req->SubCategory);
			$ValidDB['SubCategory']['WHERE'][]=array("COLUMN"=>"CID","CONDITION"=>"=","VALUE"=>$req->Category);
			$ValidDB['SubCategory']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);
			$ValidDB['SubCategory']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>'Active');
			//Grade
			$ValidDB['Grade']['TABLE']="tbl_product_grades";
			$ValidDB['Grade']['ErrMsg']="Grade does  not exist";
			$ValidDB['Grade']['WHERE'][]=array("COLUMN"=>"GID","CONDITION"=>"=","VALUE"=>$req->Grade);
			$ValidDB['Grade']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);
			$ValidDB['Grade']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>'Active');
			//Tax
			$ValidDB['Tax']['TABLE']="tbl_tax";
			$ValidDB['Tax']['ErrMsg']="Tax does  not exist";
			$ValidDB['Tax']['WHERE'][]=array("COLUMN"=>"TaxID","CONDITION"=>"=","VALUE"=>$req->Tax);
			$ValidDB['Tax']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);
			$ValidDB['Tax']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>'Active');
			//UOM
			$ValidDB['UOM']['TABLE']="tbl_uom";
			$ValidDB['UOM']['ErrMsg']="Unit of Measurement does  not exist";
			$ValidDB['UOM']['WHERE'][]=array("COLUMN"=>"UID","CONDITION"=>"=","VALUE"=>$req->UOM);
			$ValidDB['UOM']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);
			$ValidDB['UOM']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>'Active');

			$rules=array(
				'ProductCode'=>['required','min:2','max:30',new ValidUnique(array("TABLE"=>"tbl_products","WHERE"=>" ProductCode='".$req->ProductCode."'  and ProductID<>'".$ProductID."'  "),"This Product Code  is already taken.")],
				'ProductName' =>['required','min:2','max:150',new ValidUnique(array("TABLE"=>"tbl_products","WHERE"=>" ProductName='".$req->ProductName."' and ProductID<>'".$ProductID."'  "),"This Product Name  is already taken.")],
				'Category'=> ['required',new ValidDB($ValidDB['Category'])],
				'SubCategory'=> ['required',new ValidDB($ValidDB['SubCategory'])],
				'Grade'=> ['required',new ValidDB($ValidDB['Grade'])],
				'Tax'=> ['required',new ValidDB($ValidDB['Tax'])],
				'UOM'=> ['required',new ValidDB($ValidDB['UOM'])],
				'TaxType'=>'required|in:Include,Exclude',
				'MRP'=>'required|numeric|min:0',
				'PurchaseRate'=>'required|numeric|min:0',
				'CostPrice'=>'required|numeric|min:0',
				'MinQty'=>'required|numeric|min:0',
				'MaxQty'=>'required|numeric|min:0',
				'Decimals'=>'required|in:auto, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9',
				'ActiveStatus'=>'required|in:Active, Inactive',
			);
			if($req->hasFile('ProductImage')){
				$rules['ProductImage']='mimes:'.implode(",",$this->FileTypes['category']['Images']);
			}
			if(is_array($galleryNames)){
				foreach($galleryNames as $index=>$galleryName){
					if($req->hasFile($galleryName)){
						$rules[$galleryName]='mimes:'.implode(",",$this->FileTypes['category']['Images']);
					}
				}
			}
			$message=array();
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Product update Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			$ProductImage="";
			$galleryImages=array();
			$toRemoveImg=array();
			$pImages=array();
			try {
				//$ProductID=DocNum::getDocNum(docTypes::Product->value);
				$dir="uploads/master/products/".$ProductID."/";
				if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
				if($req->hasFile('ProductImage')){
					$file = $req->file('ProductImage');
					$fileName=md5($file->getClientOriginalName() . time());
					$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
					$file->move($dir, $fileName1);
					$ProductImage=$dir.$fileName1;
				}else if(Helper::isJSON($req->ProductImage)==true){
					$Img=json_decode($req->ProductImage);
					if(file_exists($Img->uploadPath)){
						$fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
						copy($Img->uploadPath,$dir.$fileName1);
						$ProductImage=$dir.$fileName1;
						unlink($Img->uploadPath);
					}
				}
				if(is_array($galleryNames)){
					foreach($galleryNames as $index=>$galleryName){
						if($req->hasFile($galleryName)){
							if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
							$file = $req->file($galleryName);
							$fileName=md5($file->getClientOriginalName() . time());
							$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
							$file->move($dir, $fileName1);
							$t=array("gImage"=>$dir.$fileName1,"Images"=>array(),"slno"=>$req[$galleryName."-SLNO"]);
							$t['Images']=helper::ImageResize($dir.$fileName1,$dir);
							$galleryImages[]=$t;

							//$galleryImages[]=array("Image"=>$dir.$fileName1,"slno"=>$req[$galleryName."-SLNO"]);
						}
					};
				}
				if(Helper::isJSON($req->galleryImages)==true){
					$gImgs=json_decode($req->galleryImages);
					if(is_array($gImgs)){
						foreach($gImgs as $RowIndex=>$gImg){
							if(file_exists($gImg->uploadPath)){
								$fileName1=$gImg->fileName!=""?$gImg->fileName:Helper::RandomString(10)."png";
								copy($gImg->uploadPath,$dir.$fileName1);
								
								$t=array("gImage"=>$dir.$fileName1,"slno"=>$gImg->slno,"Images"=>array());
								$t['Images']=helper::ImageResize($dir.$fileName1,$dir);
								$galleryImages[]=$t;

								//$galleryImages[]=array("Image"=>$dir.$fileName1,"slno"=>$gImg->slno);
							}
						}
					}
				}
				if(($ProductImage!="" || intval($req->removeProductImage)==1) && Count($OldData)>0){
					$toRemoveImg[]=$OldData[0]->Images;
				}

				
				if(file_exists($ProductImage)){
					$pImages=helper::ImageResize($ProductImage,$dir);
				}
				$data=array(
					"ProductCode"=>$req->ProductCode,
					"ProductName"=>$req->ProductName,
					"GradeID"=>$req->Grade,
					"CategoryID"=>$req->Category,
					"SubCategoryID"=>$req->SubCategory,
					"TaxID"=>$req->Tax,
					"UOMID"=>$req->UOM,
					"MRP"=>$req->MRP,
					"PurchasePrice"=>$req->PurchaseRate,
					"CostPrice"=>$req->CostPrice,
					"MinQty"=>$req->MinQty,
					"MaxQty"=>$req->MaxQty,
					"DecimalPlaces"=>$req->Decimals,
					"ActiveStatus"=>$req->ActiveStatus,
					"UpdatedBy"=>$this->UserID,
					"UpdatedOn"=>date("Y-m-d H:i:s")
				);
				if($ProductImage!=""){
					$data['ProductImage']=$ProductImage;
					$data['Images']=serialize($pImages);
				}else if(intval($req->removeProductImage)==1){
					$data['ProductImage']="";
					$data['Images']=serialize(array());
				}
				$status=DB::Table('tbl_products')->where('ProductID',$ProductID)->update($data);
				if($status){
					$groupPrices=json_decode($req->groupPrices);
					for($i=0;$i<count($groupPrices);$i++){
						if($status){
							$t=DB::Table('tbl_customer_group_price')->where('ProductID',$ProductID)->where('GroupID',$groupPrices[$i]->groupID)->get();
							if(count($t)>0){

								$tdata=array(
									"CostPrice"=>$groupPrices[$i]->costPrice,
									"Price"=>$groupPrices[$i]->price,
									"PriceType"=>$groupPrices[$i]->priceType,
									"SalesPrice"=>$groupPrices[$i]->salesPrice,
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
									"CostPrice"=>$groupPrices[$i]->costPrice,
									"Price"=>$groupPrices[$i]->price,
									"PriceType"=>$groupPrices[$i]->priceType,
									"SalesPrice"=>$groupPrices[$i]->salesPrice,
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
				}
				if(count($galleryImages)>0 && $status==true){
					for($i=0;$i<count($galleryImages);$i++){
						if($status){
							$t=DB::Table("tbl_product_gallery")->where('SLNO',$galleryImages[$i]['slno'])->get();
							if(count($t)>0 && $galleryImages[$i]['slno']!=""){
								$toRemoveImg[]=$t[0]->Images!=""?unserialize($t[0]->Images):array();//for remove
								$tdata=array(
									"gImage"=>$galleryImages[$i]['gImage'],
									"Images"=>serialize($galleryImages[$i]['Images']),
									"UpdatedBy"=>$this->UserID,
									"UpdatedOn"=>date("Y-m-d H:i:s")
	
								);
								$status=DB::Table('tbl_product_gallery')->where('SLNO',$galleryImages[$i]['slno'])->update($tdata);
							}else{
								$tdata=array(
									"SLNO"=>DocNum::getDocNum(docTypes::ProductGallery->value),
									"ProductID"=>$ProductID,
									"gImage"=>$galleryImages[$i]['gImage'],
									"Images"=>serialize($galleryImages[$i]['Images']),
									"CreatedBy"=>$this->UserID,
									"CreatedOn"=>date("Y-m-d H:i:s")
	
								);
								$status=DB::Table('tbl_product_gallery')->insert($tdata);
								if($status){
									DocNum::updateDocNum(docTypes::ProductGallery->value);
								}
							}
						}
					}
				}
				$galleryDeleted=json_decode($req->galleryDeleted,true);
				if(count($galleryDeleted)>0 && $status==true){
					for($i=0;$i<count($galleryDeleted);$i++){
						if($status){
							$t=DB::Table('tbl_product_gallery')->where('SLNO',$galleryDeleted[$i])->get();
							if(count($t)>0){
								$toRemoveImg[]=$t[0]->Images!=""?unserialize($t[0]->Images):array();//for remove
								$status=DB::Table('tbl_product_gallery')->where('SLNO',$galleryDeleted[$i])->delete();
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
				$logData=array("Description"=>"Product updated successfully","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE->value,"ReferID"=>$ProductID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				
				foreach($toRemoveImg as $rowIndex=>$images){
					foreach($images as $KeyName=>$Img){
						Helper::removeFile($Img['url']);
					}
				}
				return array('status'=>true,'message'=>"Product Updated Successfully");
			}else{
				DB::rollback();
				foreach($pImages as $KeyName=>$Img){
					Helper::removeFile($Img['url']);
				}
				foreach($galleryImages as $rowIndex=>$images){
					foreach($images['Images'] as $KeyName=>$Img){
						Helper::removeFile($Img['url']);
					}
				}
				return array('status'=>false,'message'=>"Product Update Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
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
								"CostPrice"=>$groupPrices[$i]->costPrice,
								"Price"=>$groupPrices[$i]->price,
								"PriceType"=>$groupPrices[$i]->priceType,
								"SalesPrice"=>$groupPrices[$i]->salesPrice,
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
								"CostPrice"=>$groupPrices[$i]->costPrice,
								"Price"=>$groupPrices[$i]->price,
								"PriceType"=>$groupPrices[$i]->priceType,
								"SalesPrice"=>$groupPrices[$i]->salesPrice,
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
	public function Delete(Request $req,$ProductID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=$this->getProducts(array("ProductID"=>$ProductID));
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
				$OldData=$this->getProducts(array("ProductID"=>$ProductID));
				$status=DB::table('tbl_products')->where('ProductID',$ProductID)->update(array("DFlag"=>0,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$NewData=$this->getProducts(array("ProductID"=>$ProductID));
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
							if($this->general->isCrudAllow($this->CRUD,"edit")==true){
								$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].' m-5 mr-10 btnEdit" data-original-title="Edit"><i class="fa fa-pencil"></i></button>';
							}
							if($this->general->isCrudAllow($this->CRUD,"delete")==true){
								$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-danger '.$this->general->UserInfo['Theme']['button-size'].' m-5 btnDelete" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
							}
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
							if($this->general->isCrudAllow($this->CRUD,"edit")==true){
								$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-success  '.$this->general->UserInfo['Theme']['button-size'].' m-5 mr-10 btnEdit" data-original-title="Edit"><i class="fa fa-pencil"></i></button>';
							}
							if($this->general->isCrudAllow($this->CRUD,"delete")==true){
								$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-danger '.$this->general->UserInfo['Theme']['button-size'].' m-5 btnDelete" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
							}
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
	public function TrashTableView(Request $request){
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
							$html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].'  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
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
							$html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].'  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
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
			$data['WHEREALL']=" P.DFlag=1 ";
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}

}
