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
class ManageCustomerController extends Controller{
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
		$this->ActiveMenuName=activeMenuNames::Customers->value;
		$this->PageTitle="Manage Customers";
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
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
            return view('master.manage-customers.view',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"add")==true){
			return Redirect::to('/master/manage-customers/create');
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
            return view('master.manage-customers.trash',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/master/manage-customers/');
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
            return view('master.manage-customers.customer',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/master/manage-customers/');
        }else{
            return view('errors.403');
        }
    }
    public function edit(Request $req,$CustomerID){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=true;
			$FormData['FileTypes']=$this->FileTypes;
			$FormData['CustomerID']=$CustomerID;
			$FormData['EditData']=DB::Table('tbl_customers')->where('DFlag',0)->Where('CustomerID',$CustomerID)->get();
			if(count($FormData['EditData'])>0){
				return view('master.manage-customers.customer',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/master/manage-customers/');
        }else{
            return view('errors.403');
        }
    }
    public function save(Request $req){
		if($this->general->isCrudAllow($this->CRUD,"add")==true){

			if($req->PostalCodeText==$req->PostalCode){
				$req->PostalCode = $this->general->CreatePostalCode($req->PostalCodeText,$req->Country,$req->State);
			}
			$OldData=array();$NewData=array();$CustomerID="";
			$ValidDB=array();
			//Cities
			$ValidDB['City']['TABLE']=$this->generalDB."tbl_cities";
			$ValidDB['City']['ErrMsg']="City name does  not exist";
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"CityID","CONDITION"=>"=","VALUE"=>$req->City);
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$req->State);
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->Country);
			
			//States
			$ValidDB['State']['TABLE']=$this->generalDB."tbl_states";
			$ValidDB['State']['ErrMsg']="State name does  not exist";
			$ValidDB['State']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$req->State);
			$ValidDB['State']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->Country);
			
			//Country
			$ValidDB['Country']['TABLE']=$this->generalDB."tbl_countries";
			$ValidDB['Country']['ErrMsg']="Country name  does not exist";
			$ValidDB['Country']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->Country);
			
			//Postal Code
			$ValidDB['PostalCode']['TABLE']=$this->generalDB."tbl_postalcodes";
			$ValidDB['PostalCode']['ErrMsg']="Postal Code  does not exist";
			$ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"PID","CONDITION"=>"=","VALUE"=>$req->PostalCode);
			$ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$req->State);
			$ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->Country);

			//Customer groups
			$ValidDB['CustomerGroup']['TABLE']="tbl_customer_groups";
			$ValidDB['CustomerGroup']['ErrMsg']="Customer groups  does not exist";
			$ValidDB['CustomerGroup']['WHERE'][]=array("COLUMN"=>"GroupID","CONDITION"=>"=","VALUE"=>$req->CustomerGroup);
			$ValidDB['CustomerGroup']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>'Active');
			$ValidDB['CustomerGroup']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

			$rules=array(
				'FirstName' =>'required|min:3|max:100',
				'LastName' =>'max:100',
				'State'=>['required',new ValidDB($ValidDB['State'])],
				'City'=>['required',new ValidDB($ValidDB['City'])],
				'Country'=>['required',new ValidDB($ValidDB['Country'])],
				'CustomerGroup'=>['required',new ValidDB($ValidDB['CustomerGroup'])],
				'ActiveStatus'=>'required|in:Active, Inactive',
				'MobileNumber' =>['required',new ValidUnique(array("TABLE"=>"tbl_customers","WHERE"=>" MobileNumber='".$req->MobileNumber."'"),"This Mobile Number is already taken.")],

			);
			$message=array(
				'ProfileImage.mimes'=>"The profile image field must be a file of type: ".implode(", ",$this->FileTypes['category']['Images'])."."
			);
			if($req->Email!=""){$rules['email']='email:filter';}
			if($req->hasFile('ProfileImage')){
				$rules['ProfileImage']='mimes:'.implode(",",$this->FileTypes['category']['Images']);
			}
			if($this->Settings['enable-customer-credit-limit']){
				$rules['isEnableCreditLimit']='required|in:Enabled, Disabled';
				if($req->isEnableCreditLimit=="Enabled"){
					$rules['CreditLimit']='required|numeric|min:0';
				}
				if($this->Settings['allow-customer-credit-over-drafting']){
					$rules['isAllowOverDraft']="required|in:Allow,Not Allow";
				}
				$rules['CreditDays']='required|numeric|min:0';
			}
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Customer Create Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			$images=array();
			try {
				$CImage="";
				$CustomerID=DocNum::getDocNum(docTypes::Customer->value);
				$dir="uploads/master/customer/".$CustomerID."/";
				if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
				if($req->hasFile('ProfileImage')){
					$file = $req->file('ProfileImage');
					$fileName=md5($file->getClientOriginalName() . time());
					$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
					$file->move($dir, $fileName1);  
					$CImage=$dir.$fileName1;
				}else if(Helper::isJSON($req->ProfileImage)==true){
					$Img=json_decode($req->ProfileImage);
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
				$Name=trim($req->FirstName." ".$req->LastName);
				$data=array(
					"CustomerID"=>$CustomerID,
					"CustomerName"=>$Name,
					"FirstName"=>$req->FirstName,
					"LastName"=>$req->LastName,
					"Address"=>$req->Address,
					"CountryID"=>$req->Country,
					"StateID"=>$req->State,
					"CityID"=>$req->City,
					"PostalCodeID"=>$req->PostalCode,
					"GroupID"=>$req->CustomerGroup,
					"GSTNumber"=>$req->GSTNumber,
					"email"=>$req->email,
					"MobileNumber"=>$req->MobileNumber,
					"isEnableCreditLimit"=>$req->isEnableCreditLimit,
					"CreditLimit"=>$req->CreditLimit,
					"isAllowOverDraft"=>$req->isAllowOverDraft,
					"CreditDays"=>$req->CreditDays,
					'ProfileImage'=>$CImage,
					"Images"=>serialize($images),
					"ActiveStatus"=>$req->ActiveStatus,
					"CreatedBy"=>$this->UserID,
					"CreatedOn"=>date("Y-m-d H:i:s")
				);
				$status=DB::Table('tbl_customers')->insert($data);
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DocNum::updateDocNum(docTypes::Customer->value);
				DB::commit();
				$NewData=DB::table('tbl_customers')->where('CustomerID',$CustomerID)->get();
				$logData=array("Description"=>"New Customer Created ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::ADD->value,"ReferID"=>$CustomerID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Customer Created Successfully");
			}else{
				DB::rollback();
				foreach($images as $KeyName=>$Img){
					Helper::removeFile($Img['url']);
				}
				return array('status'=>false,'message'=>"Customer Create Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
    public function update(Request $req,$CustomerID){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			if($req->PostalCodeText==$req->PostalCode){
				$req->PostalCode = $this->general->CreatePostalCode($req->PostalCodeText,$req->Country,$req->State);
			}
			$OldData=array();$NewData=array();
			
			//Cities
			$ValidDB['City']['TABLE']=$this->generalDB."tbl_cities";
			$ValidDB['City']['ErrMsg']="City name does  not exist";
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"CityID","CONDITION"=>"=","VALUE"=>$req->City);
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$req->State);
			$ValidDB['City']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->Country);
			
			//States
			$ValidDB['State']['TABLE']=$this->generalDB."tbl_states";
			$ValidDB['State']['ErrMsg']="State name does  not exist";
			$ValidDB['State']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$req->State);
			$ValidDB['State']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->Country);
			
			//Country
			$ValidDB['Country']['TABLE']=$this->generalDB."tbl_countries";
			$ValidDB['Country']['ErrMsg']="Country name  does not exist";
			$ValidDB['Country']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->Country);
			
			//Postal Code
			$ValidDB['PostalCode']['TABLE']=$this->generalDB."tbl_postalcodes";
			$ValidDB['PostalCode']['ErrMsg']="Postal Code  does not exist";
			$ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"PID","CONDITION"=>"=","VALUE"=>$req->PostalCode);
			$ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"StateID","CONDITION"=>"=","VALUE"=>$req->State);
			$ValidDB['PostalCode']['WHERE'][]=array("COLUMN"=>"CountryID","CONDITION"=>"=","VALUE"=>$req->Country);

			//Customer groups
			$ValidDB['CustomerGroup']['TABLE']="tbl_customer_groups";
			$ValidDB['CustomerGroup']['ErrMsg']="Customer groups  does not exist";
			$ValidDB['CustomerGroup']['WHERE'][]=array("COLUMN"=>"GroupID","CONDITION"=>"=","VALUE"=>$req->CustomerGroup);
			$ValidDB['CustomerGroup']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>'Active');
			$ValidDB['CustomerGroup']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);

			$rules=array(
				'FirstName' =>'required|min:3|max:100',
				'LastName' =>'max:100',
				'State'=>['required',new ValidDB($ValidDB['State'])],
				'City'=>['required',new ValidDB($ValidDB['City'])],
				'Country'=>['required',new ValidDB($ValidDB['Country'])],
				'CustomerGroup'=>['required',new ValidDB($ValidDB['CustomerGroup'])],
				'ActiveStatus'=>'required|in:Active, Inactive',
				'MobileNumber' =>['required',new ValidUnique(array("TABLE"=>"tbl_customers","WHERE"=>" MobileNumber='".$req->MobileNumber."' and CustomerID<>'".$CustomerID."'"),"This Mobile Number is already taken.")],

			);
			$message=array(
				'ProfileImage.mimes'=>"The profile image field must be a file of type: ".implode(", ",$this->FileTypes['category']['Images'])."."
			);
			if($req->Email!=""){$rules['email']='email:filter';}
			if($req->hasFile('ProfileImage')){
				$rules['ProfileImage']='mimes:'.implode(",",$this->FileTypes['category']['Images']);
			}
			if($this->Settings['enable-customer-credit-limit']){
				$rules['isEnableCreditLimit']='required|in:Enabled, Disabled';
				if($req->isEnableCreditLimit=="Enabled"){
					$rules['CreditLimit']='required|numeric|min:0';
				}
				if($this->Settings['allow-customer-credit-over-drafting']){
					$rules['isAllowOverDraft']="required|in:Allow,Not Allow";
				}
				$rules['CreditDays']='required|numeric|min:0';
			}
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Customer Update Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			$currProfileImage=array();
			$images=array();
			try {
				$OldData=DB::table('tbl_customers')->where('CustomerID',$CustomerID)->get();
				$CImage="";
				$dir="uploads/master/customer/".$CustomerID."/";
				if (!file_exists( $dir)) {mkdir( $dir, 0777, true);}
				if($req->hasFile('ProfileImage')){
					$file = $req->file('ProfileImage');
					$fileName=md5($file->getClientOriginalName() . time());
					$fileName1 =  $fileName. "." . $file->getClientOriginalExtension();
					$file->move($dir, $fileName1);  
					$CImage=$dir.$fileName1;
				}else if(Helper::isJSON($req->ProfileImage)==true){
					$Img=json_decode($req->ProfileImage);
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
				if(($CImage!="" || intval($req->removeProfileImage)==1) && Count($OldData)>0){
					$currProfileImage=$OldData[0]->Images!=""?unserialize($OldData[0]->Images):array();
				}
				$Name=trim($req->FirstName." ".$req->LastName);
				$data=array(
					"CustomerName"=>$Name,
					"FirstName"=>$req->FirstName,
					"LastName"=>$req->LastName,
					"Address"=>$req->Address,
					"CountryID"=>$req->Country,
					"StateID"=>$req->State,
					"CityID"=>$req->City,
					"PostalCodeID"=>$req->PostalCode,
					"GroupID"=>$req->CustomerGroup,
					"GSTNumber"=>$req->GSTNumber,
					"email"=>$req->email,
					"MobileNumber"=>$req->MobileNumber,
					"isEnableCreditLimit"=>$req->isEnableCreditLimit,
					"CreditLimit"=>$req->CreditLimit,
					"isAllowOverDraft"=>$req->isAllowOverDraft,
					"CreditDays"=>$req->CreditDays,
					"ActiveStatus"=>$req->ActiveStatus,
					"UpdatedBy"=>$this->UserID,
					"UpdatedOn"=>date("Y-m-d H:i:s")
				);
				if($CImage!=""){
					$data['ProfileImage']=$CImage;
					$data['Images']=serialize($images);
				}else if(intval($req->removeProfileImage)==1){
					$data['ProfileImage']="";
					$data['Images']=serialize(array());
				}
				$status=DB::Table('tbl_customers')->where('CustomerID',$CustomerID)->update($data);
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_customers')->where('CustomerID',$CustomerID)->get();
				$logData=array("Description"=>"Customer Updated ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE->value,"ReferID"=>$CustomerID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				//Helper::removeFile($currProfileImage);
				foreach($currProfileImage as $KeyName=>$Img){
					Helper::removeFile($Img['url']);
				}
				return array('status'=>true,'message'=>"Customer Updated Successfully");
			}else{
				DB::rollback();
				foreach($images as $KeyName=>$Img){
					Helper::removeFile($Img['url']);
				}
				return array('status'=>false,'message'=>"Customer Update Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
	
	public function Delete(Request $req,$CustomerID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_customers')->where('CustomerID',$CustomerID)->get();
				$status=DB::table('tbl_customers')->where('CustomerID',$CustomerID)->update(array("DFlag"=>1,"DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Customer has been Deleted ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::DELETE->value,"ReferID"=>$CustomerID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Customer Deleted Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Customer Delete Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function Restore(Request $req,$CustomerID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_customers')->where('CustomerID',$CustomerID)->get();
				$status=DB::table('tbl_customers')->where('CustomerID',$CustomerID)->update(array("DFlag"=>0,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_customers')->where('CustomerID',$CustomerID)->get();
				$logData=array("Description"=>"Customer has been Restored ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::RESTORE->value,"ReferID"=>$CustomerID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Customer Restored Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Customer Restore Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$ColIndex=0;
			$columns=array();
			$columns1=array();
			$columns[]= array( 
							'db' => 'CU.MobileNumber', 
							'dt' => $ColIndex,
							'formatter' => function( $d, $row ) {
								$MobileNumber=$row['PhoneCode']!=""?"+".$row['PhoneCode']." ":"";
								$MobileNumber.=$d;
								return $MobileNumber;
							}
						);$ColIndex++;
			$columns[]= array( 'db' => 'CU.CustomerName', 'dt' => $ColIndex );$ColIndex++;
			$columns[]= array( 'db' => 'CG.GroupName', 'dt' => $ColIndex );$ColIndex++;
			$columns[]= array( 
							'db' => 'CU.Address', 
							'dt' => $ColIndex,
							'formatter' => function( $d, $row ) {
								$Address=trim($d);
								$Address.=substr($Address,strlen($Address)-1)!=","?", ":" ";
								$Address.=$row['CityName'];
								$Address.=substr($Address,strlen($Address)-1)!=","?", ":" ";
								$Address.=$row['StateName'];
								$Address.=substr($Address,strlen($Address)-1)!=","?", ":" ";
								$Address.=$row['CountryName'];
								$Address.=($Address!="" && $row['PostalCode']!="")?" - ":"";
								$Address.=$row['PostalCode'];
		
								return $Address;
							}
						);$ColIndex++;
			$columns[]= array( 'db' => 'CU.Email', 'dt' => $ColIndex );$ColIndex++;
			if($this->Settings['enable-customer-credit-limit']){
				$columns[]= array( 'db' => 'CU.isEnableCreditLimit', 'dt' => $ColIndex );$ColIndex++;
				$columns[]= array( 
								'db' => 'CU.CreditLimit', 
								'dt' => $ColIndex,
								'formatter' => function( $d, $row ) {
									return Helper::NumberFormat($d,$this->Settings['price-decimals']);
								}
							);$ColIndex++;
			}
			$columns[]= array( 
							'db' => 'CU.ActiveStatus', 
							'dt' => $ColIndex ,
							'formatter' => function( $d, $row ) {
								if($d=="Active"){
									return "<span class='badge badge-success m-1'>Active</span>";
								}else{
									return "<span class='badge badge-danger m-1'>Inactive</span>";
								}
							} 
						);$ColIndex++;
			$columns[]= array(
							'db' => 'CU.CustomerID', 
							'dt' => $ColIndex,
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
						);$ColIndex++;
						
			$columns[]=array( 'db' => 'CI.CityName', 'dt' => $ColIndex );$ColIndex++;
			$columns[]=array( 'db' => 'S.StateName', 'dt' => $ColIndex );$ColIndex++;
			$columns[]=array( 'db' => 'C.CountryName', 'dt' => $ColIndex );$ColIndex++;
			$columns[]=array( 'db' => 'PC.PostalCode', 'dt' => $ColIndex );$ColIndex++;
			$columns[]=array( 'db' => 'C.PhoneCode', 'dt' => $ColIndex);$ColIndex++;

			
			$ColIndex=0;
			$columns1[]= array( 
							'db' => 'MobileNumber', 
							'dt' => $ColIndex,
							'formatter' => function( $d, $row ) {
								$MobileNumber=$row['PhoneCode']!=""?"+".$row['PhoneCode']." ":"";
								$MobileNumber.=$d;
								return $MobileNumber;
							}
						);$ColIndex++;
			$columns1[]= array( 'db' => 'CustomerName', 'dt' => $ColIndex );$ColIndex++;
			$columns1[]= array( 'db' => 'GroupName', 'dt' => $ColIndex );$ColIndex++;
			$columns1[]= array( 
							'db' => 'Address', 
							'dt' => $ColIndex,
							'formatter' => function( $d, $row ) {
								$Address=trim($d);
								$Address.=substr($Address,strlen($Address)-1)!=","?", ":" ";
								$Address.=$row['CityName'];
								$Address.=substr($Address,strlen($Address)-1)!=","?", ":" ";
								$Address.=$row['StateName'];
								$Address.=substr($Address,strlen($Address)-1)!=","?", ":" ";
								$Address.=$row['CountryName'];
								$Address.=($Address!="" && $row['PostalCode']!="")?" - ":"";
								$Address.=$row['PostalCode'];

								return $Address;
							}
						);$ColIndex++;
			$columns1[]= array( 'db' => 'Email', 'dt' => $ColIndex );$ColIndex++;
			if($this->Settings['enable-customer-credit-limit']){
				$columns1[]= array( 'db' => 'isEnableCreditLimit', 'dt' => $ColIndex );$ColIndex++;
				$columns1[]= array( 
								'db' => 'CreditLimit', 
								'dt' => $ColIndex,
								'formatter' => function( $d, $row ) {
									return Helper::NumberFormat($d,$this->Settings['price-decimals']);
								}
							);$ColIndex++;
			}
			$columns1[]= array( 
							'db' => 'ActiveStatus', 
							'dt' => $ColIndex ,
							'formatter' => function( $d, $row ) {
								if($d=="Active"){
									return "<span class='badge badge-success m-1'>Active</span>";
								}else{
									return "<span class='badge badge-danger m-1'>Inactive</span>";
								}
							} 
						);$ColIndex++;
			$columns1[]= array(
							'db' => 'CustomerID', 
							'dt' => $ColIndex,
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
						);$ColIndex++;
						
			$columns1[]=array( 'db' => 'CityName', 'dt' => $ColIndex );$ColIndex++;
			$columns1[]=array( 'db' => 'StateName', 'dt' => $ColIndex );$ColIndex++;
			$columns1[]=array( 'db' => 'CountryName', 'dt' => $ColIndex );$ColIndex++;
			$columns1[]=array( 'db' => 'PostalCode', 'dt' => $ColIndex );$ColIndex++;
			$columns1[]=array( 'db' => 'PhoneCode', 'dt' => $ColIndex);$ColIndex++;

			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_customers as CU left join tbl_customer_groups as CG ON CG.GroupID=CU.GroupID LEFT JOIN '.$this->generalDB.'tbl_countries as C ON C.CountryID=CU.CountryID LEFT JOIN '.$this->generalDB.'tbl_states as S ON S.StateID=CU.StateID LEFT JOIN '.$this->generalDB.'tbl_cities as CI ON CI.CityID=CU.CityID LEFT JOIN '.$this->generalDB.'tbl_postalcodes as PC ON PC.PID=CU.PostalCodeID ';
			$data['PRIMARYKEY']='CU.CustomerID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns1;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" CU.DFlag=0 ";
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TrashTableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			
			$ColIndex=0;
			$columns=array();
			$columns1=array();
			$columns[]= array( 
							'db' => 'CU.MobileNumber', 
							'dt' => $ColIndex,
							'formatter' => function( $d, $row ) {
								$MobileNumber=$row['PhoneCode']!=""?"+".$row['PhoneCode']." ":"";
								$MobileNumber.=$d;
								return $MobileNumber;
							}
						);$ColIndex++;
			$columns[]= array( 'db' => 'CU.CustomerName', 'dt' => $ColIndex );$ColIndex++;
			$columns[]= array( 'db' => 'CG.GroupName', 'dt' => $ColIndex );$ColIndex++;
			$columns[]= array( 
							'db' => 'CU.Address', 
							'dt' => $ColIndex,
							'formatter' => function( $d, $row ) {
								$Address=trim($d);
								$Address.=substr($Address,strlen($Address)-1)!=","?", ":" ";
								$Address.=$row['CityName'];
								$Address.=substr($Address,strlen($Address)-1)!=","?", ":" ";
								$Address.=$row['StateName'];
								$Address.=substr($Address,strlen($Address)-1)!=","?", ":" ";
								$Address.=$row['CountryName'];
								$Address.=($Address!="" && $row['PostalCode']!="")?" - ":"";
								$Address.=$row['PostalCode'];
		
								return $Address;
							}
						);$ColIndex++;
			$columns[]= array( 'db' => 'CU.Email', 'dt' => $ColIndex );$ColIndex++;
			if($this->Settings['enable-customer-credit-limit']){
				$columns[]= array( 'db' => 'CU.isEnableCreditLimit', 'dt' => $ColIndex );$ColIndex++;
				$columns[]= array( 
								'db' => 'CU.CreditLimit', 
								'dt' => $ColIndex,
								'formatter' => function( $d, $row ) {
									return Helper::NumberFormat($d,$this->Settings['price-decimals']);
								}
							);$ColIndex++;
			}
			$columns[]= array( 
							'db' => 'CU.ActiveStatus', 
							'dt' => $ColIndex ,
							'formatter' => function( $d, $row ) {
								if($d=="Active"){
									return "<span class='badge badge-success m-1'>Active</span>";
								}else{
									return "<span class='badge badge-danger m-1'>Inactive</span>";
								}
							} 
						);$ColIndex++;
			$columns[]= array(
							'db' => 'CU.CustomerID', 
							'dt' => $ColIndex,
							'formatter' => function( $d, $row ) {
								$html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].'  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
								return $html;
							} 
						);$ColIndex++;
						
			$columns[]=array( 'db' => 'CI.CityName', 'dt' => $ColIndex );$ColIndex++;
			$columns[]=array( 'db' => 'S.StateName', 'dt' => $ColIndex );$ColIndex++;
			$columns[]=array( 'db' => 'C.CountryName', 'dt' => $ColIndex );$ColIndex++;
			$columns[]=array( 'db' => 'PC.PostalCode', 'dt' => $ColIndex );$ColIndex++;
			$columns[]=array( 'db' => 'C.PhoneCode', 'dt' => $ColIndex);$ColIndex++;

			
			$ColIndex=0;
			$columns1[]= array( 
							'db' => 'MobileNumber', 
							'dt' => $ColIndex,
							'formatter' => function( $d, $row ) {
								$MobileNumber=$row['PhoneCode']!=""?"+".$row['PhoneCode']." ":"";
								$MobileNumber.=$d;
								return $MobileNumber;
							}
						);$ColIndex++;
			$columns1[]= array( 'db' => 'CustomerName', 'dt' => $ColIndex );$ColIndex++;
			$columns1[]= array( 'db' => 'GroupName', 'dt' => $ColIndex );$ColIndex++;
			$columns1[]= array( 
							'db' => 'Address', 
							'dt' => $ColIndex,
							'formatter' => function( $d, $row ) {
								$Address=trim($d);
								$Address.=substr($Address,strlen($Address)-1)!=","?", ":" ";
								$Address.=$row['CityName'];
								$Address.=substr($Address,strlen($Address)-1)!=","?", ":" ";
								$Address.=$row['StateName'];
								$Address.=substr($Address,strlen($Address)-1)!=","?", ":" ";
								$Address.=$row['CountryName'];
								$Address.=($Address!="" && $row['PostalCode']!="")?" - ":"";
								$Address.=$row['PostalCode'];

								return $Address;
							}
						);$ColIndex++;
			$columns1[]= array( 'db' => 'Email', 'dt' => $ColIndex );$ColIndex++;
			if($this->Settings['enable-customer-credit-limit']){
				$columns1[]= array( 'db' => 'isEnableCreditLimit', 'dt' => $ColIndex );$ColIndex++;
				$columns1[]= array( 
								'db' => 'CreditLimit', 
								'dt' => $ColIndex,
								'formatter' => function( $d, $row ) {
									return Helper::NumberFormat($d,$this->Settings['price-decimals']);
								}
							);$ColIndex++;
			}
			$columns1[]= array( 
							'db' => 'ActiveStatus', 
							'dt' => $ColIndex ,
							'formatter' => function( $d, $row ) {
								if($d=="Active"){
									return "<span class='badge badge-success m-1'>Active</span>";
								}else{
									return "<span class='badge badge-danger m-1'>Inactive</span>";
								}
							} 
						);$ColIndex++;
			$columns1[]= array(
							'db' => 'CustomerID', 
							'dt' => $ColIndex,
							'formatter' => function( $d, $row ) {
								$html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].'  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
								return $html;
							} 
						);$ColIndex++;
						
			$columns1[]=array( 'db' => 'CityName', 'dt' => $ColIndex );$ColIndex++;
			$columns1[]=array( 'db' => 'StateName', 'dt' => $ColIndex );$ColIndex++;
			$columns1[]=array( 'db' => 'CountryName', 'dt' => $ColIndex );$ColIndex++;
			$columns1[]=array( 'db' => 'PostalCode', 'dt' => $ColIndex );$ColIndex++;
			$columns1[]=array( 'db' => 'PhoneCode', 'dt' => $ColIndex);$ColIndex++;

			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_customers as CU left join tbl_customer_groups as CG ON CG.GroupID=CU.GroupID LEFT JOIN '.$this->generalDB.'tbl_countries as C ON C.CountryID=CU.CountryID LEFT JOIN '.$this->generalDB.'tbl_states as S ON S.StateID=CU.StateID LEFT JOIN '.$this->generalDB.'tbl_cities as CI ON CI.CityID=CU.CityID LEFT JOIN '.$this->generalDB.'tbl_postalcodes as PC ON PC.PID=CU.PostalCodeID ';
			$data['PRIMARYKEY']='CU.CustomerID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns1;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" CU.DFlag=1 ";
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
}
