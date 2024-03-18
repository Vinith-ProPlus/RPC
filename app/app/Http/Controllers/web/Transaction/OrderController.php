<?php
namespace App\Http\Controllers\web\Transaction;

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

class OrderController extends Controller{
	private $general;
	private $UserID;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $Settings;
    private $Menus;
	private $generalDB;
	private $logDB;
    private $currfyDB;

    public function __construct(){
		$this->ActiveMenuName=activeMenuNames::Order->value;
		$this->PageTitle="Order";
        $this->middleware('auth');    
		$this->middleware(function ($request, $next) {
			$this->UserID=auth()->user()->UserID;
			$this->general=new general($this->UserID,$this->ActiveMenuName);
			$this->Menus=$this->general->loadMenu();
			$this->CRUD=$this->general->getCrudOperations($this->ActiveMenuName);
			$this->Settings=$this->general->getSettings();
			$this->generalDB=Helper::getGeneralDB();
			$this->logDB=Helper::getLogDB();
			$this->currfyDB=Helper::getCurrFYDB();
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
            return view('app.transaction.order.view',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"add")==true){
			return Redirect::to('/admin/transaction/order/create');
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
            return view('app.transaction.order.trash',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/admin/transaction/order/');
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
            return view('app.transaction.order.quote',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/transaction/order/');
        }else{
            return view('errors.403');
        }
    }
    public function edit(Request $req,$OrderID){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=true;
			$FormData['EditData']=DB::Table($this->currfyDB.'tbl_order')->where('DFlag',0)->Where('OrderID',$OrderID)->get();
			if(count($FormData['EditData'])>0){
				return view('app.transaction.order.quote',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/transaction/order/');
        }else{
            return view('errors.403');
        }
    }
    public function OrderView(Request $req,$OrderID){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=false;
			$OData=DB::Table($this->currfyDB.'tbl_order as O')
			->leftJoin('tbl_customer as CU', 'CU.CustomerID', 'O.CustomerID')
			->leftJoin($this->generalDB.'tbl_countries as C','C.CountryID','CU.CountryID')
			->leftJoin($this->generalDB.'tbl_states as S', 'S.StateID', 'CU.StateID')
			->leftJoin($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'CU.DistrictID')
			->leftJoin($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'CU.TalukID')
			->leftJoin($this->generalDB.'tbl_cities as CI', 'CI.CityID', 'CU.CityID')
			->leftJoin($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'CU.PostalCodeID')
			->leftJoin($this->generalDB.'tbl_countries as DC','DC.CountryID','CU.DCountryID')
			->leftJoin($this->generalDB.'tbl_states as DS', 'DS.StateID', 'CU.DStateID')
			->leftJoin($this->generalDB.'tbl_districts as DD', 'DD.DistrictID', 'CU.DDistrictID')
			->leftJoin($this->generalDB.'tbl_taluks as DT', 'DT.TalukID', 'CU.DTalukID')
			->leftJoin($this->generalDB.'tbl_cities as DCI', 'DCI.CityID', 'CU.DCityID')
			->leftJoin($this->generalDB.'tbl_postalcodes as DPC', 'DPC.PID', 'CU.DPostalCodeID')
			->where('O.DFlag',0)->Where('O.OrderID',$OrderID)
			->select('OrderID','OrderNo','OrderDate','Status','CU.CustomerName','MobileNo1','MobileNo2','Email','DDistrictID','Address','C.CountryName','S.StateName','D.DistrictName','T.TalukName','CI.CityName','PC.PostalCode','DAddress','DC.CountryName as DCountryName','DS.StateName as DStateName','DD.DistrictName as DDistrictName','DT.TalukName as DTalukName','DCI.CityName as DCityName','DPC.PostalCode as DPostalCode')
			->first();
			$FormData['OData']=$OData;
			if($OData){
				$OrderData = DB::Table($this->currfyDB.'tbl_order_details as OD')->join($this->currfyDB.'tbl_order as O','O.OrderID','OD.OrderID')->join('tbl_vendors as V','V.VendorID','O.VendorID')->join('tbl_products as P','P.ProductID','OD.ProductID')->join('tbl_uom as UOM','UOM.UID','OD.UOMID')->where('OD.OrderID',$OrderID)->get();
				$FormData['OrderData'] = $OrderData;
				return view('app.transaction.order.order-view',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/transaction/order/');
        }else{
            return view('errors.403');
        }
    }

    
	
	public function Delivered(Request $req,$OrderID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table($this->currfyDB.'tbl_order')->where('OrderID',$OrderID)->get();
				$status=DB::table($this->currfyDB.'tbl_order')->where('OrderID',$OrderID)->update(array("Status"=>"Delivered","UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Order has been Delivered ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE23->value,"ReferID"=>$OrderID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Order Delivered Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Order Delivery Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function Delete(Request $req,$OrderID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table($this->currfyDB.'tbl_order')->where('OrderID',$OrderID)->get();
				$status=DB::table($this->currfyDB.'tbl_order')->where('OrderID',$OrderID)->update(array("Status"=>"Cancelled","DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$logData=array("Description"=>"Order has been Cancelled ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::DELETE->value,"ReferID"=>$OrderID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Order Cancelled Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Order Cancelled Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function Restore(Request $req,$OrderID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table($this->currfyDB.'tbl_order')->where('OrderID',$OrderID)->get();
				$status=DB::table($this->currfyDB.'tbl_order')->where('OrderID',$OrderID)->update(array("Status"=>"New","UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table($this->currfyDB.'tbl_order')->where('OrderID',$OrderID)->get();
				$logData=array("Description"=>"Order has been Restored ","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::RESTORE->value,"ReferID"=>$OrderID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Order Restored Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Order Restore Failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}

	public function TableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'OrderNo', 'dt' => '0' ),
				array( 'db' => 'OrderDate', 'dt' => '1','formatter' => function( $d, $row ) {return date($this->Settings['date-format'],strtotime($d));}),
				array( 'db' => 'CustomerID', 'dt' => '2','formatter' => function( $d, $row ) {return DB::table('tbl_customer')->where('CustomerID',$d)->value('CustomerName');} ),
				array( 'db' => 'CustomerID', 'dt' => '3','formatter' => function( $d, $row ) {return DB::table('tbl_customer')->where('CustomerID',$d)->value('MobileNo1');} ),
				array( 'db' => 'SubTotal', 'dt' => '4','formatter' => function( $d, $row ) {return Helper::NumberFormat($d,$this->Settings['price-decimals']);}),
				array( 'db' => 'TaxAmount', 'dt' => '5','formatter' => function( $d, $row ) {return Helper::NumberFormat($d,$this->Settings['price-decimals']);}),
				array( 'db' => 'TotalAmount', 'dt' => '6','formatter' => function( $d, $row ) {return Helper::NumberFormat($d,$this->Settings['price-decimals']);}),
				array( 'db' => 'Status','dt' => '7',
					'formatter' => function( $d, $row ) {
						return "<span class='badge badge-info m-1'>".$d."</span>";
					} 
				),
				array( 
						'db' => 'OrderID', 
						'dt' => '8',
						'formatter' => function( $d, $row ) {
							$html='';
							if($this->general->isCrudAllow($this->CRUD,"view")==true){
								// $html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-info '.$this->general->UserInfo['Theme']['button-size'].'  mr-10 btnView" data-original-title="View Order"><i class="fa fa-eye"></i></button>';
								$html.='<button type="button" data-id="'.$d.'" class="btn btn-outline-info '.$this->general->UserInfo['Theme']['button-size'].'  mr-10 btnView">View Order</button>';
							}
							if($row['Status'] =='New'){
								if($this->general->isCrudAllow($this->CRUD,"edit")==true){
									$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-success '.$this->general->UserInfo['Theme']['button-size'].'  mr-10 btnDelivered" data-original-title="Edit">Mark as Delivered</button>';
								}
								if($this->general->isCrudAllow($this->CRUD,"delete")==true){
									$html.='<button type="button" data-id="'.$d.'" class="btn btn-outline-danger '.$this->general->UserInfo['Theme']['button-size'].'  btnDelete" data-original-title="Delete">Cancel</button>';
								}
							}
							return $html;
						} 
				)
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']=$this->currfyDB.'tbl_order';
			$data['PRIMARYKEY']='OrderID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" Status != 'Cancelled'";
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TrashTableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$columns = array(
				array( 'db' => 'OrderNo', 'dt' => '0' ),
				array( 'db' => 'OrderDate', 'dt' => '1','formatter' => function( $d, $row ) {return date($this->Settings['date-format'],strtotime($d));}),
				array( 'db' => 'CustomerName', 'dt' => '2' ),
				array( 'db' => 'MobileNo1', 'dt' => '3' ),
				array( 'db' => 'SubTotal', 'dt' => '4','formatter' => function( $d, $row ) {return Helper::NumberFormat($d,$this->Settings['price-decimals']);}),
				array( 'db' => 'TaxAmt', 'dt' => '5','formatter' => function( $d, $row ) {return Helper::NumberFormat($d,$this->Settings['price-decimals']);}),
				array( 'db' => 'TotalAmount', 'dt' => '6','formatter' => function( $d, $row ) {return Helper::NumberFormat($d,$this->Settings['price-decimals']);}),
				array( 'db' => 'Status','dt' => '7',
					'formatter' => function( $d, $row ) {
						return "<span class='badge badge-danger m-1'>".$d."</span>";
					} 
				),
				array( 'db' => 'VendorID','dt' => '8',
					'formatter' => function( $d, $row ) {
						if($d){
							return DB::table('tbl_vendors')->where('VendorID',$d)->value('VendorName');
						}else{
							return "--";
						}
					}
				),
				array( 
						'db' => 'OrderID', 
						'dt' => '9',
						'formatter' => function( $d, $row ) {
							$html='';
							if($this->general->isCrudAllow($this->CRUD,"restore")==true){
								$html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success btn-sm  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
							}
							return $html;
						} 
				)
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']=$this->currfyDB.'tbl_order';
			$data['PRIMARYKEY']='OrderID';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" Status = 'Cancelled'";
			return SSP::SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}

}
