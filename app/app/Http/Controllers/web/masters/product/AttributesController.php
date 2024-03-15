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
use Hash;
use cruds;
use ValidUnique;
use ValidDB;
use logs;
use Helper;
use activeMenuNames;
use App\Models\DocNum as ModelsDocNum;
use docTypes;
class AttributesController extends Controller{
	private $general;
	private $UserID;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $Settings;
	private $FileTypes;
    private $Menus;
	private $generalDB;
    public function __construct(){
		$this->ActiveMenuName=activeMenuNames::Attributes->value;
		$this->PageTitle="Attributes";
        $this->middleware('auth');
		$this->FileTypes=Helper::getFileTypes(array("category"=>array("Images")));
		$this->generalDB=Helper::getGeneralDB();
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
			return view('app.master.product.attributes.view',$FormData);
		}elseif($this->general->isCrudAllow($this->CRUD,"Add")==true){
			return Redirect::to('/admin/master/product/attributes/create');
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
            return view('app.master.product.attributes.trash',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/admin/master/product/attributes/');
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
			$FormData['FileTypes']=$this->FileTypes;
            return view('app.master.product.attributes.create',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/master/product/attributes/');
        }else{
            return view('errors.403');
        }
    }
    public function edit(Request $req,$AttrID){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=true;
			$FormData['FileTypes']=$this->FileTypes;
			$FormData['AttrID']=$AttrID;
			$FormData['EditData']=DB::Table('tbl_attributes')->where('DFlag',0)->Where('AttrID',$AttrID)->get();
			$FormData['EditValuesData']=DB::Table('tbl_attributes_details')->where('DFlag',0)->Where('AttrID',$AttrID)->get();
			$FormData['EditAttrValCtgyData']=DB::Table('tbl_attributes_category_mapping as AVCM')->join('tbl_attributes_details as AD','AD.ValueID','AVCM.ValueID')->join('tbl_product_category as PC','PC.PCID','AVCM.PCID')->join('tbl_product_subcategory as PSC','PSC.PSCID','AVCM.PSCID')->where('AVCM.DFlag',0)->where('AD.DFlag',0)->Where('AVCM.AttrID',$AttrID)->get();
			if(count($FormData['EditData'])>0){
				return view('app.master.product.attributes.create',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/master/product/attributes/');
        }else{
            return view('errors.403');
        }
    }
    public function save(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"add")==true){
			$OldData=array();$NewData=array();$AttrID="";
			$rules=array(
				'AttrName' =>['required','min:3','max:50',new ValidUnique(array("TABLE"=>''.'tbl_attributes',"WHERE"=>" AttrName='".$req->AttrName."'  "),"This Attribute Name is already taken.")],
			)				;
			$message=array();
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Attribute Create Failed",'errors'=>$validator->errors());
			}
			DB::beginTransaction();
			$status=false;
			try {
				$Values = json_decode($req->VData);
				$AttrID=DocNum::getDocNum(docTypes::Attributes->value,"",Helper::getCurrentFY());
				$data=array(
					"AttrID"=>$AttrID,
					"AttrName"=>$req->AttrName,
					"Values"=>serialize($Values),
					"ActiveStatus"=>$req->ActiveStatus,
					"CreatedBy"=>$this->UserID,
					"CreatedOn"=>date("Y-m-d H:i:s")
				);
				$status=DB::Table('tbl_attributes')->insert($data);
				if($status){
					foreach($Values->ExistingValues as $row){
						$ValueID = DocNum::getDocNum(docTypes::AttributeValues->value,"",Helper::getCurrentFY());
						$dir="uploads/master/product/attributes/".$AttrID."/".$ValueID."/";
						if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
						$images=array();
						$ValueLogo="";
						$Img=$row->ValueLogo;
						if (isset($Img->uploadPath)) {
							if(file_exists($Img->uploadPath)){
								$fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
								copy($Img->uploadPath,$dir.$fileName1);
								$ValueLogo=$dir.$fileName1;
								unlink($Img->uploadPath);
							}
						}
						if(file_exists($ValueLogo)){
							$images=helper::ImageResize($ValueLogo,$dir);
						}
						$data=[];
						$data=[
							"ValueID"=>$ValueID,
							"AttrID"=>$AttrID,
							"Values"=>$row->ValueName,
							"ValueLogo"=>$ValueLogo,
							"Images"=>serialize($images),
							"CreatedBy"=>$this->UserID,
							"CreatedOn"=>date("Y-m-d H:i:s"),
						];
						$status=DB::Table('tbl_attributes_details')->insert($data);
						if($status){
							$CategoryData=$row->CategoryData->Categories;
							foreach($CategoryData->CategoryIDs as $item){
								$DetailID = DocNum::getDocNum(docTypes::AttributeValueCategory->value,"",Helper::getCurrentFY());
								$data=[];
								$data=[
									"DetailID"=>$DetailID,
									"AttrID"=>$AttrID,
									"ValueID"=>$ValueID,
									"PCID"=>$item->PCID,
									"PSCID"=>$item->PSCID,
									"CreatedBy"=>$this->UserID,
									"CreatedOn"=>date("Y-m-d H:i:s"),
								];
								$status=DB::Table('tbl_attributes_category_mapping')->insert($data);
								if($status){
									DocNum::updateDocNum(docTypes::AttributeValueCategory->value);
								}
							}
							DocNum::updateDocNum(docTypes::AttributeValues->value);
						}
					}
				}
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DocNum::updateDocNum(docTypes::Attributes->value);
				$NewData=DB::table('tbl_attributes as a')->join('tbl_attributes_details as ad','ad.AttrID','a.AttrID')->where('a.AttrID',$AttrID)->get();
				$logData=array("Description"=>"New Attribute Created","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::ADD->value,"ReferID"=>$AttrID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				DB::commit();
				return array('status'=>true,'message'=>"Attribute Created Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Attribute Create Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
		return json_decode($req->VData);
		// return $req;
	}
    public function update(Request $req,$AttrID){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OldData=array();$NewData=array();
        
			$rules=array(
				'AttrName' =>['required','max:50',new ValidUnique(array("TABLE"=>'tbl_attributes',"WHERE"=>" AttrName='".$req->AttrName."' and AttrID<>'".$AttrID."'  "),"This Attribute Name is already taken.")],
			)				;
			$message=array();
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Attribute Update Failed",'errors'=>$validator->errors());
			}
			DB::beginTransaction();
			$status=false;
			try {
				$Values = json_decode($req->VData);
				$OldData=DB::table('tbl_attributes as a')->join('tbl_attributes_details as ad','ad.AttrID','a.AttrID')->join('tbl_attributes_category_mapping as avcm','avcm.AttrID','a.AttrID')->where('a.AttrID',$AttrID)->get();
				$data=array(
					"AttrName"=>$req->AttrName,
					"Values"=>serialize($Values),
					"ActiveStatus"=>$req->ActiveStatus,
					"UpdatedBy"=>$this->UserID,
					"UpdatedOn"=>date("Y-m-d H:i:s")
				);
				$status=DB::Table('tbl_attributes')->where('AttrID',$AttrID)->update($data);
				if($status){
					if(count($Values->DeletedValueIDs)>0){
						DB::table('tbl_attributes_details')->where('AttrID',$AttrID)->whereIn('ValueID',$Values->DeletedValueIDs)->update(["DFlag"=>1,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")]);
						DB::table('tbl_attributes_category_mapping')->where('AttrID',$AttrID)->whereIn('ValueID',$Values->DeletedValueIDs)->update(["DFlag"=>1,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")]);
					}
					foreach($Values->ExistingValues as $row){
						if($row->ValueID){
							$dir="uploads/master/product/attributes/".$AttrID."/".$row->ValueID."/";
							if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
							$images=array();
							$ValueLogo="";
							$Img=$row->ValueLogo;
							if($Img->isLogoRemoved == 1 && $Img->existingLogoPath){
								unlink($Img->existingLogoPath);
							}elseif($Img->isLogoRemoved == 0){
								if($Img->existingLogoPath=="" && isset($Img->uploadPath)){
									if (file_exists($Img->uploadPath)) {
										$fileName1 = $Img->fileName !== "" ? $Img->fileName : Helper::RandomString(10) . "png";
										copy($Img->uploadPath, $dir . $fileName1);
										$ValueLogo = $dir . $fileName1;
										unlink($Img->uploadPath);
									}
								}elseif(isset($Img->uploadPath) && $Img->existingLogoPath){
									unlink($Img->existingLogoPath);
									$fileName1 = $Img->fileName !== "" ? $Img->fileName : Helper::RandomString(10) . "png";
									copy($Img->uploadPath, $dir . $fileName1);
									$ValueLogo = $dir . $fileName1;
									unlink($Img->uploadPath);
								}else{
									$ValueLogo = $Img->existingLogoPath;
								}
							}
							if(file_exists($ValueLogo)){
								$images=helper::ImageResize($ValueLogo,$dir);
							}
							$data=[];
							$data=[
								"AttrID"=>$AttrID,
								"Values"=>$row->ValueName,
								"ValueLogo"=>$ValueLogo,
								"Images"=>serialize($images),
								"CreatedBy"=>$this->UserID,
								"CreatedOn"=>date("Y-m-d H:i:s"),
							];
							$status=DB::Table('tbl_attributes_details')->where('AttrID',$AttrID)->where('ValueID',$row->ValueID)->update($data);
							if($status){
								$CategoryData=$row->CategoryData->Categories;
								$DeletedCategoryIDs=$row->CategoryData->DeletedDetailIDs;
								if(count($DeletedCategoryIDs)>0){
									DB::table('tbl_attributes_category_mapping')->where('AttrID',$AttrID)->whereIn('DetailID',$DeletedCategoryIDs)->update(["DFlag"=>1,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")]);
								}
								foreach($CategoryData->CategoryIDs as $item){
									$isCategoriesExists=DB::table('tbl_attributes_category_mapping')->where('AttrID',$AttrID)->where("ValueID",$row->ValueID)->where('PCID',$item->PCID)->where('PSCID',$item->PSCID)->exists();
									if($isCategoriesExists){
										$status = DB::table('tbl_attributes_category_mapping')->where('AttrID',$AttrID)->where('ValueID',$row->ValueID)->where('PCID',$item->PCID)->where('PSCID',$item->PSCID)->update(["DFlag"=>0,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")]);
									}else{
										$DetailID = DocNum::getDocNum(docTypes::AttributeValueCategory->value,"",Helper::getCurrentFY());
										$data=[];
										$data=[
											"DetailID"=>$DetailID,
											"AttrID"=>$AttrID,
											"ValueID"=>$row->ValueID,
											"PCID"=>$item->PCID,
											"PSCID"=>$item->PSCID,
											"CreatedBy"=>$this->UserID,
											"CreatedOn"=>date("Y-m-d H:i:s"),
										];
										$status=DB::Table('tbl_attributes_category_mapping')->insert($data);
										if($status){
											DocNum::updateDocNum(docTypes::AttributeValueCategory->value);
										}
									}
								}
							}
						}else{
							$isAttrValueExists=DB::table('tbl_attributes_details')->where('AttrID',$AttrID)->where('Values',$row->ValueName)->exists();
							if($isAttrValueExists){
								$AttrValueID=DB::table('tbl_attributes_details')->where('AttrID',$AttrID)->where('Values',$row->ValueName)->value('ValueID');
								$status = DB::table('tbl_attributes_details')->where('ValueID',$AttrValueID)->update(['DFlag'=>0,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")]);
								if($status){
									$CategoryData=$row->CategoryData->Categories;
									foreach($CategoryData->CategoryIDs as $item){
										$isCategoriesExists=DB::table('tbl_attributes_category_mapping')->where('AttrID',$AttrID)->where("ValueID",$AttrValueID)->where('PCID',$item->PCID)->where('PSCID',$item->PSCID)->exists();
										if($isCategoriesExists){
											$status = DB::table('tbl_attributes_category_mapping')->where('AttrID',$AttrID)->where('ValueID',$AttrValueID)->where('PCID',$item->PCID)->where('PSCID',$item->PSCID)->update(["DFlag"=>0,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")]);
										}else{
											$DetailID = DocNum::getDocNum(docTypes::AttributeValueCategory->value,"",Helper::getCurrentFY());
											$data=[];
											$data=[
												"DetailID"=>$DetailID,
												"AttrID"=>$AttrID,
												"ValueID"=>$AttrValueID,
												"PCID"=>$item->PCID,
												"PSCID"=>$item->PSCID,
												"CreatedBy"=>$this->UserID,
												"CreatedOn"=>date("Y-m-d H:i:s"),
											];
											$status=DB::Table('tbl_attributes_category_mapping')->insert($data);
											if($status){
												DocNum::updateDocNum(docTypes::AttributeValueCategory->value);
											}
										}
									}
								}
							}else{
								$images=array();
								$ValueLogo="";
								$ValueID = DocNum::getDocNum(docTypes::AttributeValues->value,"",Helper::getCurrentFY());
								$dir="uploads/master/product/attributes/".$AttrID."/".$ValueID."/";
								if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
								$Img=$row->ValueLogo;
								if (isset($Img->uploadPath)) {
									if(file_exists($Img->uploadPath)){
										$fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";	
										copy($Img->uploadPath,$dir.$fileName1);
										$ValueLogo=$dir.$fileName1;
										unlink($Img->uploadPath);
									}
								}
								if(file_exists($ValueLogo)){
									$images=helper::ImageResize($ValueLogo,$dir);
								}
								$data=[];
								$data=[
									"ValueID"=>$ValueID,
									"AttrID"=>$AttrID,
									"Values"=>$row->ValueName,
									"ValueLogo"=>$ValueLogo,
									"Images"=>serialize($images),
									"CreatedBy"=>$this->UserID,
									"CreatedOn"=>date("Y-m-d H:i:s"),
								];
								$status=DB::Table('tbl_attributes_details')->insert($data);
								if($status){
									$CategoryData=$row->CategoryData->Categories;
									foreach($CategoryData->CategoryIDs as $item){
										$DetailID = DocNum::getDocNum(docTypes::AttributeValueCategory->value,"",Helper::getCurrentFY());
										$data=[];
										$data=[
											"DetailID"=>$DetailID,
											"AttrID"=>$AttrID,
											"ValueID"=>$ValueID,
											"PCID"=>$item->PCID,
											"PSCID"=>$item->PSCID,
											"CreatedBy"=>$this->UserID,
											"CreatedOn"=>date("Y-m-d H:i:s"),
										];
										$status=DB::Table('tbl_attributes_category_mapping')->insert($data);
										if($status){
											DocNum::updateDocNum(docTypes::AttributeValueCategory->value);
										}
									}
									DocNum::updateDocNum(docTypes::AttributeValues->value);
								}
							}
						}
					}
					$status = true;
				}
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				$NewData=DB::table('tbl_attributes as a')->join('tbl_attributes_details as ad','ad.AttrID','a.AttrID')->join('tbl_attributes_category_mapping as avcm','avcm.AttrID','a.AttrID')->where('a.AttrID',$AttrID)->get();
				$logData=array("Description"=>"Attribute Updated ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE->value,"ReferID"=>$AttrID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				DB::commit();
				return array('status'=>true,'message'=>"Attribute Updated Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Attribute Update Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
	
	public function ActiveStatus(Request $req,$AttrID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_attributes')->where('AttrID',$AttrID)->get();
				$status=DB::table('tbl_attributes')->where('AttrID',$AttrID)->update(array("ActiveStatus"=>$req->ActiveStatus,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Attribute has been Updated ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE->value,"ReferID"=>$AttrID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Attribute Updated Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Attribute Update Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function Delete(Request $req,$AttrID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_attributes')->where('AttrID',$AttrID)->get();
				$status=DB::table('tbl_attributes')->where('AttrID',$AttrID)->update(array("DFlag"=>1,"DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Attribute has been Deleted ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::DELETE->value,"ReferID"=>$AttrID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Attribute Deleted Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Attribute Delete Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function Restore(Request $req,$AttrID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_attributes')->where('AttrID',$AttrID)->get();
				$status=DB::table('tbl_attributes')->where('AttrID',$AttrID)->update(array("DFlag"=>0,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_attributes')->where('AttrID',$AttrID)->get();
				$logData=array("Description"=>"Attribute has been Restored ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::RESTORE->value,"ReferID"=>$AttrID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Attribute Restored Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Attribute Restore Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TableView(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'AttrID', 'dt' => '0' ),
				array( 'db' => 'AttrName', 'dt' => '1' ),
				array( 'db' => 'ActiveStatus', 'dt' => '2',
					'formatter' => function( $d, $row ) {
						if($d=="Active"){
							return "<span class='badge badge-success m-1'>Active</span>";
						}else{
							return "<span class='badge badge-danger m-1'>Inactive</span>";
						}
					} 
				),
				array( 'db' => 'AttrID', 'dt' => '3',
					'formatter' => function( $d, $row ) {
						$html='';
						if($this->general->isCrudAllow($this->CRUD,"edit")==true){
							if($row['ActiveStatus']=="Active"){
								$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-dark '.$this->general->UserInfo['Theme']['button-size'].' m-5 mr-10 btnActive" data-original-title="Active"><i class="fa fa-eye-slash"></i></button>';
							}else{
								$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-info '.$this->general->UserInfo['Theme']['button-size'].' m-5 mr-10 btnActive" data-original-title="Inactive"><i class="fa fa-eye"></i></button>';
							}
							$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].' m-5 mr-10 btnEdit" data-original-title="Edit"><i class="fa fa-pencil"></i></button>';
						}
						if($this->general->isCrudAllow($this->CRUD,"delete")==true){
							$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-danger '.$this->general->UserInfo['Theme']['button-size'].' m-5 btnDelete" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
						}
						return $html;
					} 
				)
			);
			$Where = " DFlag=0 ";
			if($req->ActiveStatus != ""){
				$Where.=" and ActiveStatus = '$req->ActiveStatus'";
			}
			$data=array();
			$data['POSTDATA']=$req;
			$data['TABLE']='tbl_attributes';
			$data['PRIMARYKEY']='AttrID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=$Where;
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TrashTableView(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			$columns = array(
				array( 'db' => 'AttrID', 'dt' => '0' ),
				array( 'db' => 'AttrName', 'dt' => '1' ),
				array( 'db' => 'ActiveStatus', 'dt' => '2',
					'formatter' => function( $d, $row ) {
						if($d=="Active"){
							return "<span class='badge badge-success m-1'>Active</span>";
						}else{
							return "<span class='badge badge-danger m-1'>Inactive</span>";
						}
					} 
				),
				array( 'db' => 'AttrID', 'dt' => '3',
					'formatter' => function( $d, $row ) {
						$html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].'  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
						return $html;
					} 
				)
			);
			$data=array();
			$data['POSTDATA']=$req;
			$data['TABLE']='tbl_attributes';
			$data['PRIMARYKEY']='AttrID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" DFlag=1 ";
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}

	public static function GetAttribute(request $req){
		return DB::Table('tbl_attributes')->where('ActiveStatus','Active')->where('DFlag',0)->get();
	}
	public static function GetAttrValue(request $req){
		return DB::Table('tbl_attributes_details')->where('AttrID',$req->AttrID)->get();
	}	
}
