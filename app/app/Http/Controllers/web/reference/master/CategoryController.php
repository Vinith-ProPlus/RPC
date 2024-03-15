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
use logs;
use Helper;
use activeMenuNames;
use docTypes;
use cruds;
class CategoryController extends Controller{
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
		$this->ActiveMenuName=activeMenuNames::Category->value;
		$this->PageTitle="Category";
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
            return view('master.category.view',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"add")==true){
			return Redirect::to('/master/category/create');
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
            return view('master.category.trash',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/master/category/');
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
            return view('master.category.category',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/master/category/');
        }else{
            return view('errors.403');
        }
    }
    public function edit(Request $req,$CID){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=true;
			$FormData['FileTypes']=$this->FileTypes;
			$FormData['EditData']=DB::Table('tbl_category')->where('DFlag',0)->Where('CID',$CID)->get();
			if(count($FormData['EditData'])>0){
				return view('master.category.category',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/master/category/');
        }else{
            return view('errors.403');
        }
    }
    public function save(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"add")==true){
			$OldData=array();$NewData=array();$CID="";
			$rules=array(
				'CName' =>['required','max:50',new ValidUnique(array("TABLE"=>"tbl_category","WHERE"=>" CName='".$req->CName."'  "),"This Category Name is already taken.")],
			);
			$message=array(
				'CName.required'=>"Category Name is required",
				'CName.min'=>"Category Name must be greater than 2 characters",
				'CName.max'=>"Category Name may not be greater than 100 characters",
				'CImage.mimes'=>"The category image field must be a file of type: ".implode(", ",$this->FileTypes['category']['Images'])."."
			);
			if($req->hasFile('CImage')){
				$rules['CImage']='mimes:'.implode(",",$this->FileTypes['category']['Images']);
			}
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Category Create Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			$images=array();
			try {
				$CImage="";
				$CID=DocNum::getDocNum(docTypes::Category->value);
				$dir="uploads/master/category/".$CID."/";
				if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
				if($req->hasFile('CImage')){
					$file = $req->file('CImage');
					$fileName=md5($file->getClientOriginalName() . time());
					$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
					$file->move($dir, $fileName1);  
					$CImage=$dir.$fileName1;
				}else if(Helper::isJSON($req->CImage)==true){
					$Img=json_decode($req->CImage);
					if(file_exists($Img->uploadPath)){
						$fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
						copy($Img->uploadPath,$dir.$fileName1);
						$CImage=$dir.$fileName1;
						unlink($Img->uploadPath);
					}
				}
				if(file_exists($CImage)){
					$images=helper::ImageResize($CImage,$dir);
				}
				$data=array(
					"CID"=>$CID,
					"CName"=>$req->CName,
					'CImage'=>$CImage,
					"Images"=>serialize($images),
					"ActiveStatus"=>$req->ActiveStatus,
					"CreatedBy"=>$this->UserID,
					"CreatedOn"=>date("Y-m-d H:i:s")
				);
				$status=DB::Table('tbl_category')->insert($data);
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DocNum::updateDocNum(docTypes::Category->value);
				DB::commit();
				$NewData=DB::table('tbl_category')->where('CID',$CID)->get();
				$logData=array("Description"=>"New Category Created ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::ADD->value,"ReferID"=>$CID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Category Created Successfully");
			}else{
				DB::rollback();
				//Helper::removeFile($CImage);
				foreach($images as $KeyName=>$Img){
					Helper::removeFile($Img['url']);
				}
				return array('status'=>false,'message'=>"Category Create Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
    public function update(Request $req,$CID){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OldData=array();$NewData=array();
			$rules=array(
				'CName' =>['required','max:50',new ValidUnique(array("TABLE"=>"tbl_category","WHERE"=>" CName='".$req->CName."' and CID<>'".$CID."'  "),"This Category Name is already taken.")]
			)				;
			$message=array(
				'CName.required'=>"Category Name is required",
				'CName.min'=>"Category Name must be greater than 2 characters",
				'CName.max'=>"Category Name may not be greater than 100 characters",
				'CImage.mimes'=>"The category image field must be a file of type: ".implode(", ",$this->FileTypes['category']['Images'])."."
			);
			if($req->hasFile('CImage')){
				$rules['CImage']='mimes:'.implode(",",$this->FileTypes['category']['Images']);
			}
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Category Update Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			$currCImage=array();
			$images=array();
			try {
				$OldData=DB::table('tbl_category')->where('CID',$CID)->get();
				$CImage="";
				$dir="uploads/master/category/".$CID."/";
				if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
				if($req->hasFile('CImage')){
					$file = $req->file('CImage');
					$fileName=md5($file->getClientOriginalName() . time());
					$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
					$file->move($dir, $fileName1);  
					$CImage=$dir.$fileName1;
				}else if(Helper::isJSON($req->CImage)==true){
					$Img=json_decode($req->CImage);
					if(file_exists($Img->uploadPath)){
						$fileName1=$Img->fileName!=""?$Img->fileName:Helper::RandomString(10)."png";
						copy($Img->uploadPath,$dir.$fileName1);
						$CImage=$dir.$fileName1;
						unlink($Img->uploadPath);
					}
				}
				if(file_exists($CImage)){
					$images=helper::ImageResize($CImage,$dir);
				}
				if(($CImage!="" || intval($req->removeCImage)==1) && Count($OldData)>0){ 
					$currCImage=$OldData[0]->Images!=""?unserialize($OldData[0]->Images):array();
				}
				$data=array(
					"CName"=>$req->CName,
					"ActiveStatus"=>$req->ActiveStatus,
					"UpdatedBy"=>$this->UserID,
					"UpdatedOn"=>date("Y-m-d H:i:s")
				);
				if($CImage!=""){
					$data['CImage']=$CImage;
					$data['Images']=serialize($images);
				}else if(intval($req->removeCImage)==1){
					$data['CImage']="";
					$data['Images']=serialize(array());
				}
				$status=DB::Table('tbl_category')->where('CID',$CID)->update($data);
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_category')->where('CID',$CID)->get();
				$logData=array("Description"=>"Category Updated ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE->value,"ReferID"=>$CID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				//Helper::removeFile($currCImage);
				
				foreach($currCImage as $KeyName=>$Img){
					Helper::removeFile($Img['url']);
				}
				return array('status'=>true,'message'=>"Category Updated Successfully");
			}else{
				DB::rollback();
				foreach($images as $KeyName=>$Img){
					Helper::removeFile($Img['url']);
				}
				return array('status'=>false,'message'=>"Category Update Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
	public function Delete(Request $req,$CID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_category')->where('CID',$CID)->get();
				$status=DB::table('tbl_category')->where('CID',$CID)->update(array("DFlag"=>1,"DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Category has been Deleted ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::DELETE->value,"ReferID"=>$CID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Category Deleted Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Category Delete Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function Restore(Request $req,$CID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_category')->where('CID',$CID)->get();
				$status=DB::table('tbl_category')->where('CID',$CID)->update(array("DFlag"=>0,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_category')->where('CID',$CID)->get();
				$logData=array("Description"=>"Category has been Restored ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::RESTORE->value,"ReferID"=>$CID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Category Restored Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Category Restore Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'CID', 'dt' => '0' ),
				array( 'db' => 'CName', 'dt' => '1' ),
				array( 
						'db' => 'ActiveStatus', 
						'dt' => '2',
						'formatter' => function( $d, $row ) {
							if($d=="Active"){
								return "<span class='badge badge-success m-1'>Active</span>";
							}else{
								return "<span class='badge badge-danger m-1'>Inactive</span>";
							}
						} 
                    ),
				array( 
						'db' => 'CID', 
						'dt' => '3',
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
			$data['TABLE']='tbl_category';
			$data['PRIMARYKEY']='CID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" DFlag=0 ";
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TrashTableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			$columns = array(
				array( 'db' => 'CID', 'dt' => '0' ),
				array( 'db' => 'CName', 'dt' => '1' ),
				array( 
						'db' => 'ActiveStatus', 
						'dt' => '2',
						'formatter' => function( $d, $row ) {
							if($d=="Active"){
								return "<span class='badge badge-success m-1'>Active</span>";
							}else{
								return "<span class='badge badge-danger m-1'>Inactive</span>";
							}
						} 
                    ),
				array( 
						'db' => 'CID', 
						'dt' => '3',
						'formatter' => function( $d, $row ) {
							$html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].'  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
							return $html;
						} 
				)
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_category';
			$data['PRIMARYKEY']='CID';
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
}
