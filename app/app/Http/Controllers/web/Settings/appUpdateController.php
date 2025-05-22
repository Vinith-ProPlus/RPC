<?php
namespace App\Http\Controllers\web\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\DocNum;
use App\Models\general;
use App\Models\ServerSideProcess;
use DB;
use Auth;
use Hash;
use cruds;
use App\Rules\ValidUnique;
use App\Rules\ValidDB;
use logs;

class appUpdateController extends Controller{
	private $general;
	private $DocNum;
	private $UserID;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $Settings;
    private $Menus;
    public function __construct(){
		$this->ActiveMenuName="App-Update";
		$this->PageTitle="App Update";
        $this->middleware('auth');
        $this->DocNum=new DocNum();

		$this->middleware(function ($request, $next) {
			$this->UserID=auth()->user()->UserID;
			$this->LoginType=auth()->user()->LoginType;
			$this->general=new general($this->UserID,$this->ActiveMenuName,auth()->user()->LoginType);
			$this->Menus=$this->general->loadMenu();
			$this->CRUD=$this->general->getCrudOperations($this->ActiveMenuName);
			$this->Settings=$this->general->getSettings();
			return $next($request);
		});
    }
	public function index(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$FormData=$this->general->UserInfo;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['menus']=$this->Menus;
			$FormData['crud']=$this->CRUD;
			$FormData['data']=DB::Table('tbl_app_update')->get();
            if(count($FormData['data'])>0){
                $FormData['data']=$FormData['data'][0];
                return view('app.settings.app-update.index',$FormData);
            }else{
                return view('errors.400');
            }

		}else{
			return view('errors.403');
		}
	}
    public function Update(Request $req,$SLNO){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OldData=$NewData=array();
            $ValidDB=array();
			$rules=array(
                'Title' =>'required|min:3|max:50',
                'Description'=>'required|min:10',
                'NewVersion'=>'required',
                'SubmitText'=>'required|min:2|max:50',
                'IgnoreText'=>'required|min:2|max:50',
                'forceUpdate'=>'required',
                'UpdateTo'=>'required|in:All,IOS,Android',
			);
			$message=array(
                'IOSLink.required'=>'The IOS link field is required.',
                'IOSLink.url'=>'The IOS link must be a valid URL.'
			);
			if($req->hasFile('Image')){
				$rules['Image']='mimes:jpeg,jpg,png,gif';
			}
			if($req->IOSLink!=""){
				$rules['IOSLink']='required|url';
			}
			if($req->AndroidLink!=""){
				$rules['AndroidLink']='required|url';
			}

			$validator = Validator::make($req->all(), $rules,$message);

			if ($validator->fails()) {
				return array('status'=>false,'message'=>"App update save Failed",'errors'=>$validator->errors());
			}
            $OldData=DB::Table('tbl_app_update')->where('SLNO',$SLNO)->get();
			DB::beginTransaction();
			$status=false;
			$Image="";
			try{

				$dir="uploads/mobile/app-update/";
				if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
				if($req->hasFile('Image')){
					$file = $req->file('Image');
					$fileName=md5($file->getClientOriginalName() . time());
					$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
					$file->move($dir,$fileName1);
					$Image=$dir.$fileName1;
				}

				$data=array(
                    "Title"=>$req->Title,
                    "Description"=>$req->Description,
                    "NewVersion"=>$req->NewVersion,
                    "AndroidLink"=>$req->AndroidLink,
                    "IOSLink"=>$req->IOSLink,
                    "SubmitText"=>$req->SubmitText,
                    "IgnoreText"=>$req->IgnoreText,
                    "forceUpdate"=>$req->forceUpdate,
                    "UpdateTo"=>$req->UpdateTo,
					"UpdatedOn"=>date("Y-m-d H:i:s"),
					"UpdatedBy"=>$this->UserID
				);
                if(file_exists($Image)){
                    $data['Image']=$Image;
                }
				$status=DB::Table('tbl_app_update')->where('SLNO',$SLNO)->update($data);
			}catch(Exception $e) {
				$status=false;
			}
			if($status==true){
				DB::commit();
				$NewData=DB::Table('tbl_app_update')->where('SLNO',$SLNO)->get();
				$logData=array("Description"=>"App Update save successfully ","ModuleName"=>$this->ActiveMenuName,"Action"=>"Update","ReferID"=>$SLNO,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
                logs::Store($logData);
				return array('status'=>true,'message'=>"Saved successfully");
			}else{
				if($Image!=""){
					if(file_exists($Image)){
						unlink($Image);
					}
				}
				DB::rollback();
				return array('status'=>false,'message'=>"Save failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
    }
}
