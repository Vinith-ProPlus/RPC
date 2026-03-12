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
use ValidUnique;
use ValidDB;
use logs;
use Helper;
use activeMenuNames;
use docTypes;
use cruds;
class SubCategoryController extends Controller{
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
		$this->ActiveMenuName=activeMenuNames::SubCategory->value;
		$this->PageTitle="Sub Category";
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
            return view('master.sub-category.view',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"add")==true){
			return Redirect::to('/master/sub-category/create');
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
            return view('master.sub-category.trash',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/master/sub-category/');
        }else{
            return view('errors.403');
        }
    }
    public function create(Request $req){
        if($this->general->isCrudAllow($this->CRUD,"add")==true){
			$OtherCruds=array(
				"Category"=>$this->general->getCrudOperations(activeMenuNames::Category->value),
			);
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=false;
			$FormData['FileTypes']=$this->FileTypes;
			$FormData['OtherCruds']=$OtherCruds;
            return view('master.sub-category.create',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/master/sub-category/');
        }else{
            return view('errors.403');
        }
    }
    public function edit(Request $req,$SCID){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OtherCruds=array(
				"Category"=>$this->general->getCrudOperations(activeMenuNames::Category->value),
			);
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=true;
			$FormData['SCID']=$SCID;
			$FormData['FileTypes']=$this->FileTypes;
			$FormData['OtherCruds']=$OtherCruds;
			$FormData['EditData']=DB::Table('tbl_subcategory')->where('DFlag',0)->Where('SCID',$SCID)->get();
			if(count($FormData['EditData'])>0){
				return view('master.sub-category.create',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/master/sub-category/');
        }else{
            return view('errors.403');
        }
    }
	public function getCategory(request $req){
		return DB::Table('tbl_category')->where('ActiveStatus','Active')->where('DFlag',0)->get();
	}
    public function save(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"add")==true){
			$OldData=array();$NewData=array();$SCID="";
			$ValidDB=array();
			//Category
			$ValidDB['Category']['TABLE']="tbl_category";
			$ValidDB['Category']['ErrMsg']="Category name does  not exist";
			$ValidDB['Category']['WHERE'][]=array("COLUMN"=>"CID","CONDITION"=>"=","VALUE"=>$req->Category);
			$ValidDB['Category']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);
			$ValidDB['Category']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>'Active');
			
			$rules=array(
				'SCName' =>['required','max:50',new ValidUnique(array("TABLE"=>"tbl_subcategory","WHERE"=>" SCName='".$req->SCName."'  "),"This Sub Category Name is already taken.")],
				'Category' =>['required',new ValidDB($ValidDB['Category'])],
			)				;
			$message=array(
				'SCName.required'=>"Sub Category Name is required",
				'SCName.min'=>"Sub Category Name must be greater than 2 characters",
				'SCName.max'=>"Sub Category Name may not be greater than 100 characters",
				'SCName.required'=>"Sub Category Image is required",
				'SCImage.mimes'=>"The category image field must be a file of type: ".implode(", ",$this->FileTypes['category']['Images'])."."
			);
            if($req->hasFile('SCImage')){
				$rules['SCImage']='mimes:'.implode(",",$this->FileTypes['category']['Images']);
            }
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Sub Category Create Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			$images=array();
			try {
				$SCImage="";
				$SCID=DocNum::getDocNum(docTypes::SubCategory->value);
				$dir="uploads/master/sub-category/".$SCID."/";
				if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
				if($req->hasFile('SCImage')){
					$file = $req->file('SCImage');
					$fileName=md5($file->getClientOriginalName() . time());
					$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
					$file->move($dir, $fileName1);  
					$SCImage=$dir.$fileName1;
				}else if(Helper::isJSON($req->SCImage)==true){
					$Img=json_decode($req->SCImage);
					if(file_exists($Img->uploadPath)){
						$fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
						copy($Img->uploadPath,$dir.$fileName1);
						$SCImage=$dir.$fileName1;
						unlink($Img->uploadPath);
					}
				}
				if(file_exists($SCImage)){
					$images=helper::ImageResize($SCImage,$dir);
				}
				$data=array(
					"SCID"=>$SCID,
					"SCName"=>$req->SCName,
					"CID"=>$req->Category,
					'SCImage'=>$SCImage,
					"Images"=>serialize($images),
					"ActiveStatus"=>$req->ActiveStatus,
					"CreatedBy"=>$this->UserID,
					"CreatedOn"=>date("Y-m-d H:i:s")
				);
				$status=DB::Table('tbl_subcategory')->insert($data);
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DocNum::updateDocNum(docTypes::SubCategory->value);
				DB::commit();
				$NewData=DB::table('tbl_subcategory')->where('SCID',$SCID)->get();
				$logData=array("Description"=>"New Sub Category Created ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::ADD->value,"ReferID"=>$SCID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Sub Category Created Successfully");
			}else{
				DB::rollback();
				foreach($images as $KeyName=>$Img){
					Helper::removeFile($Img['url']);
				}
				return array('status'=>false,'message'=>"Sub Category Create Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
    public function update(Request $req,$SCID){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OldData=array();$NewData=array();
			$ValidDB=array();
			//Category
			$ValidDB['Category']['TABLE']="tbl_category";
			$ValidDB['Category']['ErrMsg']="Category name does  not exist";
			$ValidDB['Category']['WHERE'][]=array("COLUMN"=>"CID","CONDITION"=>"=","VALUE"=>$req->Category);
			$ValidDB['Category']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);
			$ValidDB['Category']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>'Active');
			$rules=array(
				'SCName' =>['required','max:50',new ValidUnique(array("TABLE"=>"tbl_subcategory","WHERE"=>" SCName='".$req->SCName."' and SCID<>'".$SCID."'  "),"This Sub Category Name is already taken.")],
				'Category' =>['required',new ValidDB($ValidDB['Category'])]
			)				;
			$message=array(
				'CName.required'=>"Category Name is required",
				'CName.min'=>"Category Name must be greater than 2 characters",
				'CName.max'=>"Category Name may not be greater than 100 characters",
				'SCImage.mimes'=>"The category image field must be a file of type: ".implode(", ",$this->FileTypes['category']['Images'])."."
			);
            if($req->hasFile('SCImage')){
				$rules['SCImage']='mimes:'.implode(",",$this->FileTypes['category']['Images']);
            }
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Sub Category Update Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			$currSCImage=array();
			$images=array();
			try {
				$OldData=DB::table('tbl_subcategory')->where('SCID',$SCID)->get();
				$SCImage="";
				$dir="uploads/master/sub-category/".$SCID."/";
				if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
				if($req->hasFile('SCImage')){
					$file = $req->file('SCImage');
					$fileName=md5($file->getClientOriginalName() . time());
					$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
					$file->move($dir, $fileName1);  
					$SCImage=$dir.$fileName1;
				}else if(Helper::isJSON($req->SCImage)==true){
					$Img=json_decode($req->SCImage);
					if(file_exists($Img->uploadPath)){
						$fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
						copy($Img->uploadPath,$dir.$fileName1);
						$SCImage=$dir.$fileName1;
						unlink($Img->uploadPath);
					}
				}
				if(file_exists($SCImage)){
					$images=helper::ImageResize($SCImage,$dir);
				}
				if(($SCImage!="" || intval($req->removeSCImage)==1) && Count($OldData)>0){
					$currSCImage=$OldData[0]->Images!=""?unserialize($OldData[0]->Images):array();
				}
				$data=array(
					"SCName"=>$req->SCName,
					"CID"=>$req->Category,
					"ActiveStatus"=>$req->ActiveStatus,
					"UpdatedBy"=>$this->UserID,
					"UpdatedOn"=>date("Y-m-d H:i:s")
				);
				if($SCImage!=""){
					$data['SCImage']=$SCImage;
					$data['Images']=serialize($images);
				}else if(intval($req->removeSCImage)==1){
					$data['SCImage']="";
					$data['Images']=serialize(array());
				}
				$status=DB::Table('tbl_subcategory')->where('SCID',$SCID)->update($data);
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_subcategory')->where('SCID',$SCID)->get();
				$logData=array("Description"=>"Sub Category Updated ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE->value,"ReferID"=>$SCID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				foreach($currSCImage as $KeyName=>$Img){
					Helper::removeFile($Img['url']);
				}
				return array('status'=>true,'message'=>"Sub Category Updated Successfully");
			}else{
				DB::rollback();
				foreach($images as $KeyName=>$Img){
					Helper::removeFile($Img['url']);
				}
				return array('status'=>false,'message'=>"Sub Category Update Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
	
	public function Delete(Request $req,$SCID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_subcategory')->where('SCID',$SCID)->get();
				$status=DB::table('tbl_subcategory')->where('SCID',$SCID)->update(array("DFlag"=>1,"DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Sub Category has been Deleted ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::DELETE->value,"ReferID"=>$SCID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Sub Category Deleted Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Sub Category Delete Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function Restore(Request $req,$SCID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_subcategory')->where('SCID',$SCID)->get();
				$status=DB::table('tbl_subcategory')->where('SCID',$SCID)->update(array("DFlag"=>0,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_subcategory')->where('SCID',$SCID)->get();
				$logData=array("Description"=>"Sub Category has been Restored ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::RESTORE->value,"ReferID"=>$SCID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Sub Category Restored Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Sub Category Restore Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'SC.SCID', 'dt' => '0' ),
				array( 'db' => 'SC.SCName', 'dt' => '1' ),
				array( 'db' => 'C.CName', 'dt' => '2' ),
				array( 
						'db' => 'SC.ActiveStatus', 
						'dt' => '3',
						'formatter' => function( $d, $row ) {
							if($d=="Active"){
								return "<span class='badge badge-success m-1'>Active</span>";
							}else{
								return "<span class='badge badge-danger m-1'>Inactive</span>";
							}
						} 
                    ),
				array( 
						'db' => 'SC.SCID', 
						'dt' => '4',
						'formatter' => function( $d, $row ) {
							$html='';
							if($this->general->isCrudAllow($this->CRUD,"edit")==true){
								$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-success btn-air-success mr-10 btnEdit" data-original-title="Edit"><i class="fa fa-pencil"></i></button>';
							}
							if($this->general->isCrudAllow($this->CRUD,"delete")==true){
								$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-danger btn-air-success btnDelete" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
							}
							return $html;
						} 
				)
			);
			$columns1 = array(
				array( 'db' => 'SCID', 'dt' => '0' ),
				array( 'db' => 'SCName', 'dt' => '1' ),
				array( 'db' => 'CName', 'dt' => '2' ),
				array( 
						'db' => 'ActiveStatus', 
						'dt' => '3',
						'formatter' => function( $d, $row ) {
							if($d=="Active"){
								return "<span class='badge badge-success m-1'>Active</span>";
							}else{
								return "<span class='badge badge-danger m-1'>Inactive</span>";
							}
						} 
                    ),
				array( 
						'db' => 'SCID', 
						'dt' => '4',
						'formatter' => function( $d, $row ) {
							$html='';
							if($this->general->isCrudAllow($this->CRUD,"edit")==true){
								$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].' mr-10 btnEdit" data-original-title="Edit"><i class="fa fa-pencil"></i></button>';
							}
							if($this->general->isCrudAllow($this->CRUD,"delete")==true){
								$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-danger '.$this->general->UserInfo['Theme']['button-size'].' btnDelete" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
							}
							return $html;
						} 
				)
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_subcategory as SC LEFT JOIN tbl_category as C ON C.CID=SC.CID';
			$data['PRIMARYKEY']='SC.SCID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns1;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" SC.DFlag=0 ";
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TrashTableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			$columns = array(
				array( 'db' => 'SC.SCID', 'dt' => '0' ),
				array( 'db' => 'SC.SCName', 'dt' => '1' ),
				array( 'db' => 'C.CName', 'dt' => '2' ),
				array( 
						'db' => 'SC.ActiveStatus', 
						'dt' => '3',
						'formatter' => function( $d, $row ) {
							if($d=="Active"){
								return "<span class='badge badge-success m-1'>Active</span>";
							}else{
								return "<span class='badge badge-danger m-1'>Inactive</span>";
							}
						} 
                    ),
				array( 
						'db' => 'SC.SCID', 
						'dt' => '4',
						'formatter' => function( $d, $row ) {
							$html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].'  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
							return $html;
						} 
				)
			);
			$columns1 = array(
				array( 'db' => 'SCID', 'dt' => '0' ),
				array( 'db' => 'SCName', 'dt' => '1' ),
				array( 'db' => 'CName', 'dt' => '2' ),
				array( 
						'db' => 'ActiveStatus', 
						'dt' => '3',
						'formatter' => function( $d, $row ) {
							if($d=="Active"){
								return "<span class='badge badge-success m-1'>Active</span>";
							}else{
								return "<span class='badge badge-danger m-1'>Inactive</span>";
							}
						} 
                    ),
				array( 
						'db' => 'SCID', 
						'dt' => '4',
						'formatter' => function( $d, $row ) {
							$html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].'  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
							return $html;
						} 
				)
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_subcategory as SC LEFT JOIN tbl_category as C ON C.CID=SC.CID';
			$data['PRIMARYKEY']='SC.SCID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns1;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" SC.DFlag=1 ";
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
}
