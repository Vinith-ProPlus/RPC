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
use Helper;
use ValidUnique;
use logs;
use activeMenuNames;
use docTypes;
use cruds;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class TaxController extends Controller{
	private $general;
	private $UserID;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $Settings;
    private $Menus;
    public function __construct(){
		$this->ActiveMenuName=activeMenuNames::Tax->value;
		$this->PageTitle="Tax";
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
	
	public function createTableAndInsertValues($tableName, $columns = [], $primaryKey, $values = [],$DocNum, $isDo)
	{
		if($isDo){
			if (Schema::hasTable($tableName)) {
				// return response()->json(['message' => "Table '{$tableName}' created and values inserted successfully."]);
				Schema::dropIfExists($tableName);
			}
	
			Schema::create($tableName, function (Blueprint $table) use ($columns, $primaryKey) {
				foreach ($columns as $column) {
					switch ($column['type']) {
						case 'varchar':
							$table->string($column['name'], $column['length'])->default($column['default'])->nullable($column['nullable']);
							break;
	
						case 'enum':
							$table->enum($column['name'], $column['options'])->default($column['default']);
							break;
	
						case 'int':
							$table->integer($column['name'])->default($column['default']);
							break;
	
						case 'timestamp':
							$table->timestamp($column['name'])->default($column['default'])->nullable($column['nullable']);
							break;
					}
				}
	
				$table->primary($primaryKey);
			});
	
			try {
				if($tableName == 'tbl_construction_service_category'){
					foreach ($values as $item) {
						$data = [
							'ConServCatID' => DocNum::getDocNum($DocNum,"",Helper::getCurrentFY()),
							'ConServCatName' => $item,
							'CreatedBy'=>$this->UserID
						];
		
						$status = DB::table($tableName)->insert($data);
						if($status){
							
						DocNum::updateDocNum($DocNum);
						}
					}
				}
				if($tableName == 'tbl_construction_services'){
					foreach ($values as $key=>$item) {
						foreach ($item as $row){
							$data = [
								'ConServID' => DocNum::getDocNum($DocNum,"",Helper::getCurrentFY()),
								'ConServName' => $row,
								'ConServCatID' => $key,
								'CreatedBy'=>$this->UserID
							];
			
							$status = DB::table($tableName)->insert($data);
							if($status){
								DocNum::updateDocNum($DocNum);
							}
						}
					}
				}
				return response()->json(['message' => "Table '{$tableName}' created and values inserted successfully."]);
			} catch (\Exception $e) {
				return response()->json(['error' => $e->getMessage()], 500);
			}
		}
	}
    public function view(Request $req){
		/* $tableName = 'tbl_construction_service_category';
		$columns = [
			['name' => 'ConServCatID', 'type' => 'varchar', 'length' => 50, 'default' => null, 'nullable' => false],
			['name' => 'ConServCatName', 'type' => 'varchar', 'length' => 50, 'default' => null, 'nullable' => true],
			['name' => 'ActiveStatus', 'type' => 'enum', 'options' => ['Active', 'Inactive'], 'default' => 'Active'],
			['name' => 'DFlag', 'type' => 'int', 'default' => 0],
			['name' => 'CreatedBy', 'type' => 'varchar', 'length' => 50, 'default' => null, 'nullable' => true],
			['name' => 'UpdatedBy', 'type' => 'varchar', 'length' => 50, 'default' => null, 'nullable' => true],
			['name' => 'DeletedBy', 'type' => 'varchar', 'length' => 50, 'default' => null, 'nullable' => true],
			['name' => 'CreatedOn', 'type' => 'timestamp', 'default' => DB::raw('CURRENT_TIMESTAMP'), 'nullable' => false],
			['name' => 'UpdatedOn', 'type' => 'timestamp', 'default' => null, 'nullable' => true],
			['name' => 'DeletedOn', 'type' => 'timestamp', 'default' => null, 'nullable' => true],
		];

		$primaryKey = 'ConServCatID';
		$DocNum = 'Construction-Service-Category';

		$values = [
			'Pre-construction',
			'Post-construction',
			'Rental Service'
		]; */

		$tableName = 'tbl_construction_service';
		$columns = [
			['name' => 'ConServID', 'type' => 'varchar', 'length' => 50, 'default' => null, 'nullable' => false],
			['name' => 'ConServName', 'type' => 'varchar', 'length' => 50, 'default' => null, 'nullable' => true],
			['name' => 'ConServCatID', 'type' => 'varchar', 'length' => 50, 'default' => null, 'nullable' => true],
			['name' => 'ActiveStatus', 'type' => 'enum', 'options' => ['Active', 'Inactive'], 'default' => 'Active'],
			['name' => 'DFlag', 'type' => 'int', 'default' => 0],
			['name' => 'CreatedBy', 'type' => 'varchar', 'length' => 50, 'default' => null, 'nullable' => true],
			['name' => 'UpdatedBy', 'type' => 'varchar', 'length' => 50, 'default' => null, 'nullable' => true],
			['name' => 'DeletedBy', 'type' => 'varchar', 'length' => 50, 'default' => null, 'nullable' => true],
			['name' => 'CreatedOn', 'type' => 'timestamp', 'default' => DB::raw('CURRENT_TIMESTAMP'), 'nullable' => false],
			['name' => 'UpdatedOn', 'type' => 'timestamp', 'default' => null, 'nullable' => true],
			['name' => 'DeletedOn', 'type' => 'timestamp', 'default' => null, 'nullable' => true],
		];

		$primaryKey = 'ConServID';
		$DocNum = 'Construction-Services';

		$values = [
			'CSC2425-0000001' => [
				'Site Survey (Levelling) – Drone / Digital',
				'Layout Approval',
				'DTCP Approval',
				'Model Plan (Vastu)',
				'Vacant Land Tax',
				'Stability Certificate',
				'Blue Print',
				'Elevation',
				'3D Modelling',
				'Structural Design',
				'Elevation (Interior/Exterior)',
				'Soil Test',
				'Lift Installation Planner',
				'Clearing the site – excavation of debris',
				'Clearing the site – Demolition service',
				'Anti-Termite Treatment',
				'Fencing'
			],
			'CSC2425-0000002' => [
				'Lay the Roofing Material',
				'Roof repair services',
				'Exterior Cladding',
				'Landscaping Services',
				'Flooring Solutions',
				'Interior Design\'s',
				'Tailor made Furniture',
				'Electrical Services',
				'Plumbing Services',
				'Window maintenance & Repair',
				'Pool Services',
				'Pest Control',
				'Solar Installation',
				'Valuation of building',
				'Completion Certificate',
				'Camera',
				'Automation'
			],
			'CSC2425-0000003' => [
				'JCB',
				'Bore well',
				'Tractor',
				'Centering Material',
				'Grain Service',
				'Readymix Vehicle'
			],
		];

		// $this->createTableAndInsertValues($tableName, $columns, $primaryKey, $values, $DocNum, false);

        if($this->general->isCrudAllow($this->CRUD,"view")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
            return view('app.master.product.tax.view',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"add")==true){
			return Redirect::to('/admin/master/product/tax/create');
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
            return view('app.master.product.tax.trash',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/admin/master/product/tax/');
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
            return view('app.master.product.tax.tax',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/master/product/tax/');
        }else{
            return view('errors.403');
        }
    }
    public function edit(Request $req,$TaxID){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=true;
			$FormData['EditData']=DB::Table('tbl_tax')->where('DFlag',0)->Where('TaxID',$TaxID)->get();
			if(count($FormData['EditData'])>0){
				return view('app.master.product.tax.tax',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/master/product/tax/');
        }else{
            return view('errors.403');
        }
    }
    public function Save(Request $req){
	
		if($this->general->isCrudAllow($this->CRUD,"add")==true){
			$OldData=array();$NewData=array();$TaxID="";
			$rules=array(
				'TaxName' =>['required','max:50',new ValidUnique(array("TABLE"=>"tbl_tax","WHERE"=>" TaxName='".$req->TaxName."'  "),"This Tax Name is already taken.")],
				'Percentage'=>['required','numeric','min:0','max:100',new ValidUnique(array("TABLE"=>"tbl_tax","WHERE"=>" TaxPercentage='".$req->Percentage."'  "),"This Tax Percentage is already taken.")],
			)				;
			$message=array(
				'TaxName.required'=>"Tax Name is required",
				'TaxName.max'=>"Tax Name may not be greater than 100 characters",
				'Percentage.required'=>"Tax Percentage is required",
				'Percentage.numeric'=>"The Tax Percentage must be numeric value.",
				'Percentage.min'=>"The Tax Percentage is must be equal or greater than 0",
				'Percentage.max'=>"The Tax Percentage is not greater than 100",
			);
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Tax Create Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			try {
				
				$TaxID = DocNum::getDocNum(docTypes::Tax->value,"",Helper::getCurrentFY());
				$data=array(
					"TaxID"=>$TaxID,
					"TaxName"=>$req->TaxName,
					"TaxPercentage"=>$req->Percentage,
					"ActiveStatus"=>$req->ActiveStatus,
					"CreatedBy"=>$this->UserID,
					"CreatedOn"=>date("Y-m-d H:i:s")
				);
				$status=DB::Table('tbl_tax')->insert($data);
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DocNum::updateDocNum(docTypes::Tax->value);
				DB::commit();
				$NewData=DB::table('tbl_tax')->where('TaxID',$TaxID)->get();
				$logData=array("Description"=>"New Tax Created ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::ADD->value,"ReferID"=>$TaxID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Tax Created Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Tax Create Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
    public function update(Request $req,$TaxID){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OldData=array();$NewData=array();
			$rules=array(
				'TaxName' =>['required','max:50',new ValidUnique(array("TABLE"=>"tbl_tax","WHERE"=>" TaxName='".$req->TaxName."'  and TaxID<>'".$TaxID."' "),"This Tax Name is already taken.")],
				'Percentage'=>['required','numeric','min:0','max:100',new ValidUnique(array("TABLE"=>"tbl_tax","WHERE"=>" TaxPercentage='".$req->Percentage."' and TaxID<>'".$TaxID."' "),"This Tax Percentage is already taken.")],
			)				;
			$message=array(
				'TaxName.required'=>"Tax Name is required",
				'TaxName.max'=>"Tax Name may not be greater than 100 characters",
				'Percentage.required'=>"Tax Percentage is required",
				'Percentage.numeric'=>"The Tax Percentage must be numeric value.",
				'Percentage.min'=>"The Tax Percentage is must be equal or greater than 0",
				'Percentage.max'=>"The Tax Percentage is not greater than 100",
			);
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Tax Update Failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			try {
				$OldData=DB::table('tbl_tax')->where('TaxID',$TaxID)->get();

				$data=array(
					"TaxID"=>$TaxID,
					"TaxName"=>$req->TaxName,
					"TaxPercentage"=>$req->Percentage,
					"ActiveStatus"=>$req->ActiveStatus,
					"UpdatedBy"=>$this->UserID,
					"UpdatedOn"=>date("Y-m-d H:i:s")
				);

				$status=DB::Table('tbl_tax')->where('TaxID',$TaxID)->update($data);
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_tax')->get();
				$logData=array("Description"=>"Tax Updated ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE->value,"ReferID"=>$TaxID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Tax Updated Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Tax Update Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
	
	public function Delete(Request $req,$TaxID){

		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_tax')->where('TaxID',$TaxID)->get();
				$status=DB::table('tbl_tax')->where('TaxID',$TaxID)->update(array("DFlag"=>1,"DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Tax has been Deleted ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::DELETE->value,"ReferID"=>$TaxID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Tax Deleted Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Tax Delete Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function Restore(Request $req,$TaxID){
	
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_tax')->where('TaxID',$TaxID)->get();
				$status=DB::table('tbl_tax')->where('TaxID',$TaxID)->update(array("DFlag"=>0,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_tax')->where('TaxID',$TaxID)->get();
				$logData=array("Description"=>"Tax has been Restored ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::RESTORE->value,"ReferID"=>$TaxID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Tax Restored Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Tax Restore Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'TaxID', 'dt' => '0' ),
				array( 'db' => 'TaxName', 'dt' => '1' ),
				array( 'db' => 'TaxPercentage', 'dt' => '2','formatter' => function( $d, $row ) { return Helper::NumberFormat($d,$this->Settings['percentage-decimals']);} ),
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
						'db' => 'TaxID', 
						'dt' => '4',
						'formatter' => function( $d, $row ) {
							$html='';
							if($this->general->isCrudAllow($this->CRUD,"edit")==true){
								$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].'  mr-10 btnEdit" data-original-title="Edit"><i class="fa fa-pencil"></i></button>';
							}
							if($this->general->isCrudAllow($this->CRUD,"delete")==true){
								$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-danger '.$this->general->UserInfo['Theme']['button-size'].'  btnDelete" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
							}
							return $html;
						} 
				)
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_tax';
			$data['PRIMARYKEY']='TaxID';
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
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'TaxID', 'dt' => '0' ),
				array( 'db' => 'TaxName', 'dt' => '1' ),
				array( 'db' => 'TaxPercentage', 'dt' => '2','formatter' => function( $d, $row ) { return Helper::NumberFormat($d,$this->Settings['percentage-decimals']);} ),
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
					'db' => 'TaxID', 
					'dt' => '4',
					'formatter' => function( $d, $row ) {
						$html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success btn-sm  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
						return $html;
					} 
			)
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_tax';
			$data['PRIMARYKEY']='TaxID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" DFlag=1";
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}

	public static function GetTax(request $req){
		return DB::Table('tbl_tax')->where('ActiveStatus','Active')->where('DFlag',0)->get();
	}
}
