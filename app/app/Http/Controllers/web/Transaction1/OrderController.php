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

class OrderrController extends Controller{
	private $general;
	private $UserID;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $Settings;
    private $Menus;
	private $generalDB;

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
			$FormData['EditData']=DB::Table('tbl_order')->where('DFlag',0)->Where('OrderID',$OrderID)->get();
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
			$OData=DB::Table('tbl_order as O')
			->join($this->generalDB.'tbl_countries as C','C.CountryID','O.CountryID')
			->join($this->generalDB.'tbl_states as S', 'S.StateID', 'O.StateID')
			->join($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'O.DistrictID')
			->join($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'O.TalukID')
			->join($this->generalDB.'tbl_cities as CI', 'CI.CityID', 'O.CityID')
			->join($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'O.PostalCodeID')
			->join($this->generalDB.'tbl_countries as DC','DC.CountryID','O.DCountryID')
			->join($this->generalDB.'tbl_states as DS', 'DS.StateID', 'O.DStateID')
			->join($this->generalDB.'tbl_districts as DD', 'DD.DistrictID', 'O.DDistrictID')
			->join($this->generalDB.'tbl_taluks as DT', 'DT.TalukID', 'O.DTalukID')
			->join($this->generalDB.'tbl_cities as DCI', 'DCI.CityID', 'O.DCityID')
			->join($this->generalDB.'tbl_postalcodes as DPC', 'DPC.PID', 'O.DPostalCodeID')
			->where('O.DFlag',0)->Where('O.OrderID',$OrderID)
			->select('OrderID','OrderNo','OrderDate','VendorID','Status','CustomerName','MobileNo1','MobileNo2','Email','DDistrictID','Address','C.CountryName','S.StateName','D.DistrictName','T.TalukName','CI.CityName','PC.PostalCode','DAddress','DC.CountryName as DCountryName','DS.StateName as DStateName','DD.DistrictName as DDistrictName','DT.TalukName as DTalukName','DCI.CityName as DCityName','DPC.PostalCode as DPostalCode')
			->first();
			$FormData['OData']=$OData;
			if($OData){
				$OrderData = DB::Table('tbl_order_details as OD')->join('tbl_order as O','O.OrderID','OD.OrderID')->join('tbl_vendors as V','V.VendorID','O.VendorID')->join('tbl_products as P','P.ProductID','OD.ProductID')->join('tbl_uom as UOM','UOM.UID','OD.UOMID')->where('OD.OrderID',$OrderID)->get();
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

    public function RequestOrder(Request $req,$OrderID){
		if($this->general->isCrudAllow($this->CRUD,"add")==true){
			$OldData=array();$NewData=array();
			DB::beginTransaction();
			$status=false;
			try {
				DB::beginTransaction();

				$SelectedVendors = json_decode($req->SelectedVendors, true);
				foreach ($SelectedVendors as $row) {
					$VendorID = $row;
					$VendorDB = Helper::getVendorDB($VendorID, $this->UserID);

					if (Helper::checkTableExists($VendorDB, 'tbl_docnum')) {
						Helper::addVendorDocNum($VendorDB, 'tbl_docnum', docTypes::OrderRequest->value, "QR", 8, 1);
						Helper::addVendorDocNum($VendorDB, 'tbl_docnum', docTypes::OrderRequestDetails->value, "QRD", 8, 1);

						$status = DB::statement("CREATE TABLE IF NOT EXISTS {$VendorDB}tbl_order_request (OrderReqID VARCHAR(50) PRIMARY KEY,OrderID VARCHAR(50) NULL,Date DATE,VendorID VARCHAR(50) NULL,Status INT(1) DEFAULT 0,CreatedBy VARCHAR(50) NULL,CreatedOn TIMESTAMP NULL)");
						$status = DB::statement("CREATE TABLE IF NOT EXISTS {$VendorDB}tbl_order_request_details (DetailID VARCHAR(50) PRIMARY KEY,OrderReqID VARCHAR(50) NULL,ProductID VARCHAR(50) NULL,PCID VARCHAR(50) NULL,PSCID VARCHAR(50) NULL,UOMID VARCHAR(50) NULL,Qty DOUBLE,CreatedBy VARCHAR(50) NULL,CreatedOn TIMESTAMP NULL)");

						$OrderReqID = DocNum::getDocNum(docTypes::OrderRequest->value, $VendorDB);
						$data = [
							"OrderReqID" => $OrderReqID,
							"OrderID" => $OrderID,
							"VendorID" => $VendorID,
							"Date" => date('Y-m-d'),
							"CreatedBy" => $this->UserID,
							"CreatedOn" => date("Y-m-d H:i:s"),
						];
						$status = DB::table($VendorDB . 'tbl_order_request')->insert($data);
						if ($status) {
							$ProductDetails = json_decode($req->ProductDetails, true);

							foreach ($ProductDetails as $item) {
								$DetailID = DocNum::getDocNum(docTypes::OrderRequestDetails->value, $VendorDB);
								$data1 = [
									"DetailID" => $DetailID,
									"OrderReqID" => $OrderReqID,
									"ProductID" => $item['ProductID'],
									"PCID" => $item['PCID'],
									"PSCID" => $item['PSCID'],
									"UOMID" => $item['UOMID'],
									"Qty" => $item['Qty'],
								];
								$status = DB::table($VendorDB . 'tbl_order_request_details')->insert($data1);
								if ($status) {
									DocNum::updateDocNum(docTypes::OrderRequestDetails->value, $VendorDB);
								}
							}

							DocNum::updateDocNum(docTypes::OrderRequest->value, $VendorDB);
						}
					}
				}
				$status = DB::table('tbl_order')->where('OrderID',$OrderID)->update(['Status'=>'Order Requested','VendorIDs'=>serialize($SelectedVendors),"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")]);

			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				// DB::commit();
				$NewData=DB::table('tbl_order')->where('OrderID',$OrderID)->get();
				$logData=array("Description"=>"Order Request Sent","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::ADD->value,"ReferID"=>$OrderID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Order Request Sent Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Order Request Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
    public function Allocate(Request $req,$OrderSentID){ return $req;
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OldData=array();$NewData=array();
			try {
				$VendorDB = Helper::getVendorDB($req->VendorID, $this->UserID);
				$status = DB::table($VendorDB.'tbl_order_sent')->where('OrderSentID',$OrderSentID)->update(['Status'=>1]);
				if($status){
					$ProductPrices = DB::table($VendorDB.'tbl_order_sent_details as QSD')->join($VendorDB.'tbl_order_sent as QS','QS.OrderSentID','QSD.OrderSentID')->where('QSD.OrderSentID',$OrderSentID)->select('QS.OrderID','QSD.ProductID','QSD.Price')->get();
					$status = DB::table('tbl_order')->where('OrderID',$ProductPrices[0]->OrderID)->update(['VendorID'=>$req->VendorID]);
					if($status){
						foreach($ProductPrices as $row){
							DB::table('tbl_order_details')->where('OrderID',$row->OrderID)->where('ProductID',$row->ProductID)->update(['Price'=>$row->Price]);
						}
					}
				}
			}catch(Exception $e) {
				$status=false;
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_order')->get();
				$logData=array("Description"=>"Order Allocated","ModuleName"=>$this->ActiveMenuName,"Action"=>cruds::UPDATE->value,"ReferID"=>$OrderID,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				logs::Store($logData);
				return array('status'=>true,'message'=>"Order Allocated Successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Order Allocate Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
	}
	
	public function Delivered(Request $req,$OrderID){
		$OldData=$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$OldData=DB::table('tbl_order')->where('OrderID',$OrderID)->get();
				$status=DB::table('tbl_order')->where('OrderID',$OrderID)->update(array("Status"=>"Delivered","UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
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
				$OldData=DB::table('tbl_order')->where('OrderID',$OrderID)->get();
				$status=DB::table('tbl_order')->where('OrderID',$OrderID)->update(array("Status"=>"Cancelled","DeletedBy"=>$this->UserID,"DeletedOn"=>date("Y-m-d H:i:s")));
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
				$OldData=DB::table('tbl_order')->where('OrderID',$OrderID)->get();
				$status=DB::table('tbl_order')->where('OrderID',$OrderID)->update(array("Status"=>"New","UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
			}catch(Exception $e) {
				
			}
			if($status==true){
				DB::commit();
				$NewData=DB::table('tbl_order')->where('OrderID',$OrderID)->get();
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
				array( 'db' => 'OrderDate', 'dt' => '1','formatter' => function( $d, $row ) {return date($this->Settings['DATE-FORMAT'],strtotime($d));}),
				array( 'db' => 'CustomerName', 'dt' => '2' ),
				array( 'db' => 'MobileNo1', 'dt' => '3' ),
				array( 'db' => 'SubTotal', 'dt' => '4','formatter' => function( $d, $row ) {return Helper::NumberFormat($d,$this->Settings['PRICE-DECIMALS']);}),
				array( 'db' => 'TaxAmt', 'dt' => '5','formatter' => function( $d, $row ) {return Helper::NumberFormat($d,$this->Settings['PRICE-DECIMALS']);}),
				array( 'db' => 'TotalAmount', 'dt' => '6','formatter' => function( $d, $row ) {return Helper::NumberFormat($d,$this->Settings['PRICE-DECIMALS']);}),
				array( 'db' => 'Status','dt' => '7',
					'formatter' => function( $d, $row ) {
						return "<span class='badge badge-danger m-1'>".$d."</span>";
					} 
				),
				array( 'db' => 'VendorID','dt' => '8',
					'formatter' => function( $d, $row ) {
						return DB::table('tbl_vendors')->where('VendorID',$d)->value('VendorName');
					}
				),
				array( 
						'db' => 'OrderID', 
						'dt' => '9',
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
			$data['TABLE']='tbl_order';
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
				array( 'db' => 'OrderDate', 'dt' => '1','formatter' => function( $d, $row ) {return date($this->Settings['DATE-FORMAT'],strtotime($d));}),
				array( 'db' => 'CustomerName', 'dt' => '2' ),
				array( 'db' => 'MobileNo1', 'dt' => '3' ),
				array( 'db' => 'SubTotal', 'dt' => '4','formatter' => function( $d, $row ) {return Helper::NumberFormat($d,$this->Settings['PRICE-DECIMALS']);}),
				array( 'db' => 'TaxAmt', 'dt' => '5','formatter' => function( $d, $row ) {return Helper::NumberFormat($d,$this->Settings['PRICE-DECIMALS']);}),
				array( 'db' => 'TotalAmount', 'dt' => '6','formatter' => function( $d, $row ) {return Helper::NumberFormat($d,$this->Settings['PRICE-DECIMALS']);}),
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
			$data['TABLE']='tbl_order';
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

	public function GetVendorOrderDetails(request $req){
		$VendorDB = Helper::getVendorDB($req->VendorID, $this->UserID);

		return DB::Table($VendorDB.'tbl_order_sent_details as QSD')->join('tbl_products as P','P.ProductID','QSD.ProductID')->join('tbl_uom as UOM','UOM.UID','QSD.UOMID')->where('QSD.OrderSentID',$req->OrderSentID)
		->select('QSD.Price','QSD.Qty','P.ProductName','UOM.UCode','UOM.UName')->get();
	}
	public function GetVendorRatings(request $req){
		return DB::Table('tbl_vendor_ratings')->where('VendorID',$req->VendorID)->select('TotalYears','TotalOrders','CustomerRating','AdminRating','Outstanding','OrderValue','OverAll')->first();
	}

}
