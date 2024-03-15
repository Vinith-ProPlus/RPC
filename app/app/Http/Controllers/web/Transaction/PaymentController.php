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

class PaymentController extends Controller{
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
		$this->ActiveMenuName=activeMenuNames::Payments->value;
		$this->PageTitle="Payments";
        $this->middleware('auth');    
		$this->middleware(function ($request, $next) {
			$this->UserID=auth()->user()->UserID;
			$this->general=new general($this->UserID,$this->ActiveMenuName);
			$this->Menus=$this->general->loadMenu();
			$this->CRUD=$this->general->getCrudOperations($this->ActiveMenuName);
			$this->Settings=$this->general->getSettings();
			$this->generalDB=Helper::getGeneralDB();
			$this->currfyDB=Helper::getCurrFYDB();
			$this->logDB=Helper::getLogDB();
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
			$FormData['Setting']=$this->Settings;

            return view('app.transaction.payments.view',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"add")==true){
			return Redirect::to('/admin/transaction/payments/create');
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
            return view('app.transaction.payments.trash',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/admin/transaction/payments/');
        }else{
            return view('errors.403');
        }
    }
	
    public function advancePaymentView(Request $req){
        if($this->general->isCrudAllow($this->CRUD,"add")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=false;
			$FormData['Settings']=$this->Settings;
			return view('app.transaction.payments.advance',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/admin/transaction/payments');
        }else{
            return view('errors.403');
        }
    }
    public function AdvanceEdit(Request $req,$TranNo){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=true;
			$FormData['TranNo']=$TranNo;
			$FormData['Settings']=$this->Settings;
			$FormData['EditData']=$this->getPayments(array("TranNo"=>$TranNo,"PaymentType"=>"Advance"));

			return view('app.transaction.payments.advance',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/admin/transaction/payments');
        }else{
            return view('errors.403');
        }
    }
    public function invoicePaymentView(Request $req){
        if($this->general->isCrudAllow($this->CRUD,"add")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=false;
			$FormData['Settings']=$this->Settings;

			return view('app.transaction.payments.create',$FormData);
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
			return Redirect::to('/admin/transaction/payments');
        }else{
            return view('errors.403');
        }
    }
    public function Edit(Request $req,$TranNo){
        if($this->general->isCrudAllow($this->CRUD,"edit")==true){
            $FormData=$this->general->UserInfo;
            $FormData['menus']=$this->Menus;
            $FormData['crud']=$this->CRUD;
			$FormData['ActiveMenuName']=$this->ActiveMenuName;
			$FormData['PageTitle']=$this->PageTitle;
			$FormData['isEdit']=true;
			$FormData['TranNo']=$TranNo;
			$FormData['EditData']=$this->getPayments(array("TranNo"=>$TranNo));
			if(count($FormData['EditData'])>0){
				return view('app.transaction.payments.create',$FormData);
			}else{
				return view('errors.403');
			}
        }elseif($this->general->isCrudAllow($this->CRUD,"view")==true){
            return Redirect::to('/admin/transaction/payments/');
        }else{
            return view('errors.403');
        }
    }
    public function getVendor(Request $req){
		return DB::table('tbl_vendors')->where('ActiveStatus', 'Active')->where('DFlag', 0)->orderBy('VendorName', 'asc')->get();
	}
	
    public function getOrders(Request $req){ // invoice Payment
        $sql="SELECT H.OrderID,H.OrderNo,H.VendorID,H.OrderDate,H.Taxable,H.CGSTAmount,H.SGSTAmount,H.IGSTAmount,H.TotalAmount,H.LessFromAdvance,H.PaidAmount,H.TotalPaidAmount,0 as BalanceAmount,0 as AdvanceAmt,0 as PayLessFromAdvance,0 as PayPaidAmount,0 as PayTotalPaidAmount FROM tbl_purchase_invoice as H ";
		$sql.=" Where H.PaymentStatus<>1 ";
		if($req->VendorID!=""){
			$sql.=" and H.VendorID='".$req->VendorID."'";
		}
		if($req->TranNo!=""){
			$sql.=" UNION SELECT H.OrderID,H.OrderNo,H.VendorID,H.OrderDate,H.Taxable,H.CGSTAmount,H.SGSTAmount,H.IGSTAmount,H.TotalAmount,H.LessFromAdvance,H.PaidAmount,H.TotalPaidAmount,0 as BalanceAmount,0 as AdvanceAmt,0 as PayLessFromAdvance,0 as PayPaidAmount,0 as PayTotalPaidAmount FROM tbl_purchase_invoice as H ";
			$sql.=" Where H.PaymentStatus=1 and OrderID in(SELECT DISTINCT(OrderID) as OrderID FROM tbl_payment_details where TranNo='".$req->TranNo."')";
			if($req->VendorID!=""){
				$sql.=" and H.VendorID='".$req->VendorID."'";
			}
		}
		$result=DB::SELECT($sql);
		for($i=0;$i<count($result);$i++){
			//get Balance Amount
			$sql="SELECT SUM(IFNULL(LessFromAdvance,0)) as LessFromAdvance,SUM(IFNULL(PaidAmount,0)) as PaidAmount,SUM(IFNULL(Amount,0)) as TotalPaidAmount FROM tbl_payment_details where OrderID='".$result[$i]->OrderID."'";
			if($req->TranNo!=""){
				$sql.=" and TranNo<>'".$req->TranNo."'";
			}
			$temp=DB::SELECT($sql);
			if(count($temp)>0){
				$result[$i]->LessFromAdvance=$temp[0]->LessFromAdvance;
				$result[$i]->PaidAmount=$temp[0]->PaidAmount;
				$result[$i]->TotalPaidAmount=$temp[0]->TotalPaidAmount;
			}
			$result[$i]->BalanceAmount=floatval($result[$i]->TotalAmount)-floatval($result[$i]->TotalPaidAmount);
			//get Payment paid on this invoice for edit 
			
			if($req->TranNo!=""){
				$sql="SELECT SUM(IFNULL(LessFromAdvance,0)) as LessFromAdvance,SUM(IFNULL(PaidAmount,0)) as PaidAmount,SUM(IFNULL(Amount,0)) as TotalPaidAmount FROM tbl_payment_details where OrderID='".$result[$i]->OrderID."'";
				$sql.=" and TranNo='".$req->TranNo."'";
				$temp=DB::SELECT($sql);
				if(count($temp)>0){
					$result[$i]->PayLessFromAdvance=$temp[0]->LessFromAdvance;
					$result[$i]->PayPaidAmount=$temp[0]->PaidAmount;
					$result[$i]->PayTotalPaidAmount=$temp[0]->TotalPaidAmount;
				}
			}

			//get Advance Amount
			$sql=" SELECT TranNo,TotalAmount as Debit,0 as Credit FROM tbl_payments Where VendorID='".$result[$i]->VendorID."'  and PaymentType='Advance'";
			$sql.=" UNION";
			$sql.=" SELECT AdvID,0 as debit,Amount as Credit From tbl_advance_amount_log Where LedgerID='".$result[$i]->VendorID."' and TranType='Payments' ";
			if($req->TranNo!=""){
				$sql.=" and PaymentID<>'".$req->TranNo."'";
			}
			$sql=" SELECT SUM(Debit)-Sum(Credit) as Balance FROM( ".$sql." ) as T";
			$temp=DB::SELECT($sql);
			if(count($temp)>0){
				$result[$i]->AdvanceAmt=$temp[0]->Balance;
			}

		}
		return $result;
    }
    public function getPayments($data=array()){
        $return=array();
        $sql="SELECT H.TranNo,H.TranDate,H.PaymentType,H.VendorID,V.VendorName,V.MobileNumber,V.AlternateMobile,V.Email,V.GSTNo,V.PanNumber,H.MOP,H.MOPRefNo,H.ChequeDate,H.TotalAmount FROM tbl_payments as H LEFT JOIN tbl_vendors as V ON V.VendorID=H.VendorID";
        $sql.=" Where 1=1 ";
        if(is_array($data)){
            if(array_key_exists("TranNo",$data)){$sql.=" and H.TranNo='".$data['TranNo']."'";}
            if(array_key_exists("TranDate",$data)){$sql.=" and H.TranNo='".$data['TranDate']."'";}
            if(array_key_exists("PaymentType",$data)){$sql.=" and H.PaymentType='".$data['PaymentType']."'";}
            if(array_key_exists("VendorID",$data)){$sql.=" and H.VendorID='".$data['VendorID']."'";}
        }
        $result=DB::SELECT($sql);
        for($i=0;$i<count($result);$i++){
            $sql="SELECT D.DetailID,D.TranNo,D.OrderID,PI.OrderNo,PI.OrderDate,PI.TotalAmount,D.LessFromAdvance,D.PaidAmount,D.Amount FROM tbl_payment_details as D  LEFT JOIN tbl_purchase_invoice as PI On PI.OrderID=D.OrderID ";
            $sql.=" Where D.TranNo='".$result[$i]->TranNo."'";
            $t=DB::SELECT($sql);
            $Details=array();
            for($j=0;$j<count($t);$j++){
                $Details[]=array(
                    "DetailID"=>$t[$j]->DetailID,
                    "TranNo"=>$t[$j]->TranNo,
                    "OrderID"=>$t[$j]->OrderID,
                    "OrderNo"=>$t[$j]->OrderNo,
                    "OrderDate"=>$t[$j]->OrderDate,
                    "TotalAmount"=>$t[$j]->TotalAmount,
                    "Amount"=>$t[$j]->Amount,
                    "PaidAmount"=>$t[$j]->PaidAmount,
                    "LessFromAdvance"=>$t[$j]->LessFromAdvance,
                );
            }
            $return[]=array(
                "TranNo"=>$result[$i]->TranNo,
                "TranDate"=>$result[$i]->TranDate,
                "PaymentType"=>$result[$i]->PaymentType,
                "VendorID"=>$result[$i]->VendorID,
                "VendorName"=>$result[$i]->VendorName,
                "MobileNumber"=>$result[$i]->MobileNumber,
                "AlternateMobile"=>$result[$i]->AlternateMobile,
                "Email"=>$result[$i]->Email,
                "GSTNo"=>$result[$i]->GSTNo,
                "PanNumber"=>$result[$i]->PanNumber,
                "MOP"=>$result[$i]->MOP,
                "MOPRefNo"=>$result[$i]->MOPRefNo,
                "ChequeDate"=>$result[$i]->ChequeDate,
                "TotalAmount"=>$result[$i]->TotalAmount,
                "Details"=>$Details
            );
        }
        return $return;
    }
	public function Save(Request $req){ return $req;
		if($this->general->isCrudAllow($this->CRUD,"add")==true){
			$OldData=$NewData=[];
			$TranNo="";
			$rules=array(
                'TranDate' => 'required|date|before:'.date('Y-m-d',strtotime('+1 days')),
                'MOP' => 'required'
			);
			$message=array(
				'TranDate.required'=>"Payment Date is required",
				'TranDate.date'=>"Payment Date must be Date",
				'MOP.required'=>"Mode Of Payment is required"
			);
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"payment save failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			try {
				$TranNo = DocNum::getDocNum(docTypes::Payments->value, $this->currfyDB,Helper::getCurrentFy());
				$data=array(
                    "TranNo"=>$TranNo,
                    "TranDate"=>$req->TranDate,
                    "VendorID"=>$req->Vendor,
                    "PaymentType"=>$req->PaymentType,
                    "MOP"=>$req->MOP,
                    "MOPRefNo"=>$req->MOPRefNo,
                    "ChequeDate"=>$req->ChequeDate,
                    "TotalAmount"=>floatval($req->TotalAmount),
                    "CreatedOn"=>date("Y-m-d H:i:s"),
                    "CreatedBy"=>$this->UserID
				);
				$status=DB::Table('tbl_payments')->insert($data);
                if($status){
                    $Details=json_decode($req->Details,true);
                    for($i=0;$i<count($Details);$i++){
                        if($status){
							$DetailID = DocNum::getDocNum(docTypes::PaymentDetails->value, $this->currfyDB,Helper::getCurrentFy());
                            $data=array(
                                "DetailID"=>$DetailID,
                                "TranNo"=>$TranNo,
                                "OrderID"=>$Details[$i]['OrderID'],
                                "LessFromAdvance"=>floatval($Details[$i]['LessFromAdvance']),
                                "PaidAmount"=>floatval($Details[$i]['PaidAmount']),
                                "Amount"=>floatval($Details[$i]['Amount']),
                                "CreatedOn"=>date("Y-m-d H:i:s")
                            );
                            $status=DB::Table('tbl_payment_details')->insert($data);
                            if($status){
								DocNum::updateDocNum(docTypes::PaymentDetails->value, $this->currfyDB);
                                $status=$this->general->PurchasePaymentUpdates($req->Vendor,$Details[$i]['OrderID']);
                            }
							if($status){
								$tdata=array("TranType"=>"Payments","LedgerID"=>$req->Vendor,"PaymentID"=>$TranNo,"DetailID"=>$DetailID,"Amount"=>floatval($Details[$i]['LessFromAdvance']));
								$status=$this->general->AdvanceAmountUsedLog($tdata);
							}
                        }
                    }
                }
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DocNum::updateDocNum(docTypes::Payments->value, $this->currfyDB);
				$NewData=$this->getPayments(array("TranNo"=>$TranNo));
				$logData=array("Description"=>"New payment created successfully","ModuleName"=>$this->ActiveMenuName,"Action"=>"Add","ReferID"=>$TranNo,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				$this->logs->Store($logData);
				DB::commit();
				return array('status'=>true,'message'=>"Payment created successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Payment create Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}	
	}
    public function update(request $req,$TranNo){
		if($this->general->isCrudAllow($this->CRUD,"edit")==true){
			$OldData=$this->getPayments(array("TranNo"=>$TranNo));$NewData=array();
			$ValidDB=array();
			$currentAdvanceAmount=0;
			if(count($OldData)>0){
				$currentAdvanceAmount=floatval($OldData[0]['TotalAmount']);
			}
			//Vendor
			$ValidDB['Vendor']['TABLE']="tbl_vendors";
			$ValidDB['Vendor']['ErrMsg']="Vendor does not exists.";
			$ValidDB['Vendor']['WHERE'][]=array("COLUMN"=>"VendorID","CONDITION"=>"=","VALUE"=>$req->Vendor);
			$ValidDB['Vendor']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>1);
			$ValidDB['Vendor']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);
			$rules=array(
				'Vendor' =>['required',new ValidDB($ValidDB['Vendor'])],
                'TranDate' => 'required|date|before:'.date('Y-m-d',strtotime('+1 days')),
                'MOP' => 'required'
			)				;
			$message=array(
				'Vendor.required'=>"Vendor is required",
				'TranDate.required'=>"Payment Date is required",
				'TranDate.date'=>"Payment Date must be Date",
				'MOP.required'=>"Mode Of Payment is required"
			);
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Payment update failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			try {
				$data=array(
                    "TranDate"=>date("Y-m-d",strtotime($req->TranDate)),
                    "VendorID"=>$req->Vendor,
                    "MOP"=>$req->MOP,
                    "MOPRefNo"=>$req->MOPRefNo,
                    "ChequeDate"=>date("Y-m-d",strtotime($req->ChequeDate)),
                    "TotalAmount"=>floatval($req->TotalAmount),
                    "UpdatedOn"=>date("Y-m-d H:i:s"),
                    "UpdatedBy"=>$this->UserID
				);
				$status=DB::Table('tbl_payments')->where('TranNo',$TranNo)->update($data);
                $DetailIDs=array();
                if($status){
                    $Details=json_decode($req->Details,true);
                    for($i=0;$i<count($Details);$i++){
                        if($status){
							$DetailID="";
                            $t=DB::Table('tbl_payment_details')->where('OrderID',$Details[$i]['OrderID'])->where('TranNo',$TranNo)->get();
                            if(count($t)>0){
								$DetailID=$t[0]->DetailID;
                                $DetailIDs[]=$t[0]->DetailID;
                                $data=array(
									"OrderID"=>$Details[$i]['OrderID'],
									"LessFromAdvance"=>floatval($Details[$i]['LessFromAdvance']),
									"PaidAmount"=>floatval($Details[$i]['PaidAmount']),
									"Amount"=>floatval($Details[$i]['Amount']),
                                    "UpdatedOn"=>date("Y-m-d H:i:s")
                                );
                                $status=DB::Table('tbl_payment_details')->where('DetailID',$t[0]->DetailID)->update($data);
                                if($status){
                                    $status=$this->general->PurchasePaymentUpdates($req->Vendor,$Details[$i]['OrderID']);
                                }
                            }else{
								$DetailID = DocNum::getDocNum(docTypes::PaymentDetails->value, $this->currfyDB, Helper::getCurrentFy());
                                $DetailIDs[]=$DetailID;
                                $data=array(
                                    "DetailID"=>$DetailID,
                                    "TranNo"=>$TranNo,
									"OrderID"=>$Details[$i]['OrderID'],
									"LessFromAdvance"=>floatval($Details[$i]['LessFromAdvance']),
									"PaidAmount"=>floatval($Details[$i]['PaidAmount']),
									"Amount"=>floatval($Details[$i]['Amount']),
                                    "CreatedOn"=>date("Y-m-d H:i:s")
                                );
                                $status=DB::Table('tbl_payment_details')->insert($data);
                                if($status){
									DocNum::updateDocNum(docTypes::PaymentDetails->value, $this->currfyDB);
                                    $status=$this->general->PurchasePaymentUpdates($req->Vendor,$Details[$i]['OrderID']);
                                }
                            }
							if($status ){
								$tdata=array("TranType"=>"Payments","TranNo"=>$TranNo,"LedgerID"=>$req->Vendor,"PaymentID"=>$TranNo,"DetailID"=>$DetailID,"Amount"=>floatval($Details[$i]['LessFromAdvance']));
								$status=$this->general->AdvanceAmountUsedLog($tdata);
							}
                        }
                    }
                }
                if(($status)&&(count($DetailIDs)>0)){
                    $sql="Select * From tbl_payment_details  Where TranNo='".$TranNo."'  and DetailID not in('".implode("','",$DetailIDs)."')";
                    $result=DB::SELECT($sql);
                    if(count($result)>0){
                        $sql="Delete From tbl_payment_details  Where TranNo='".$TranNo."'  and DetailID not in('".implode("','",$DetailIDs)."')";
                        $status=DB::DELETE($sql);
                        for($i=0;$i<count($result);$i++){
                            if($status){
                                $status=$this->general->PurchasePaymentUpdates($req->Vendor,$result[$i]->OrderID,$result[$i]->OrderID);
                            }
                        }
                    }
                }
				if($status==true && $this->Settings['APRARP']==true && $req->PaymentType=="Advance" && floatval($currentAdvanceAmount)>floatval($req->TotalAmount)){
					$this->general->UpdateAdvancePayment($TranNo,$req->Vendor,floatval($req->TotalAmount));
				}
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				$NewData=$this->getPayments(array("TranNo"=>$TranNo));
				$logData=array("Description"=>"Payment modified ","ModuleName"=>$this->ActiveMenuName,"Action"=>"Update","ReferID"=>$TranNo,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				$this->logs->Store($logData);
				DB::commit();
				return array('status'=>true,'message'=>"Payment updated successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Payment update Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
    }
	public function TableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"view")==true){
			$ServerSideProcess=new ServerSideProcess();
			$columns = array(
				array( 'db' => 'H.TranNo', 'dt' => '0' ),
				array( 'db' => 'H.Trandate', 'dt' => '1','formatter' => function( $d, $row ) {return date($this->Settings['DATE-FORMAT'],strtotime($d));}),
				array( 'db' => 'V.VendorName', 'dt' => '2' ),
				array( 'db' => 'H.MOP', 'dt' => '3' ),
				array( 'db' => 'H.MOPRefNo', 'dt' => '4' ),
				array( 'db' => 'H.PaymentType', 'dt' => '5' ),
				array( 'db' => 'H.TotalAmount', 'dt' => '6','formatter' => function( $d, $row ) {return Helper::NumberFormat($d,$this->Settings['PRICE-DECIMALS']);}),
				array( 'db' => 'H.TranNo',
						'dt' => '7',
						'formatter' => function( $d, $row ) {
							$html='';
							if($row['PaymentType']=="Order"){
								$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-info btn-sm -success mr-10 btnDetailView" data-original-title="Edit"><i class="fa fa-eye"></i></button>';
							}
                            if($this->general->isCrudAllow($this->CRUD,"edit")==true){
                                $html.='<button type="button" data-id="'.$d.'" data-payment-type="'.$row['PaymentType'].'" class="btn  btn-outline-success btn-sm -success mr-10 btnEdit" data-original-title="Edit"><i class="fa fa-pencil"></i></button>';
                            }
                            if($this->general->isCrudAllow($this->CRUD,"delete")==true){
                                $html.='<button type="button" data-id="'.$d.'" data-payment-type="'.$row['PaymentType'].'" class="btn  btn-outline-danger btn-sm -success btnDelete" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                            }
							return $html;
						}
					),
				array( 'db' => 'H.PaymentType', 'dt' => '8' )
			);
			$columns1 = array(
				array( 'db' => 'TranNo', 'dt' => '0' ),
				array( 'db' => 'Trandate', 'dt' => '1','formatter' => function( $d, $row ) {return date($this->Settings['DATE-FORMAT'],strtotime($d));} ),
				array( 'db' => 'VendorName', 'dt' => '2' ),
				array( 'db' => 'MOP', 'dt' => '3' ),
				array( 'db' => 'MOPRefNo', 'dt' => '4' ),
				array( 
					'db' => 'PaymentType', 
					'dt' => '5',
					'formatter' => function( $d, $row ) {
						if($d=="Advance"){
							return "<span class='badge badge-info m-1'>".$d."</span>";
						}else{
							return "<span class='badge badge-primary m-1'>".$d."</span>";
						}
					}
				),
				array( 'db' => 'TotalAmount', 'dt' => '6','formatter' => function( $d, $row ) {return Helper::NumberFormat($d,$this->Settings['PRICE-DECIMALS']);} ),
				array(
						'db' => 'TranNo',
						'dt' => '7',
						'formatter' => function( $d, $row ) {
							$html='';
							if($row['PaymentType']=="Order"){
								$html.='<button type="button" data-id="'.$d.'" class="btn  btn-outline-info btn-sm -success mr-10 btnDetailView" data-original-title="Edit"><i class="fa fa-eye"></i></button>';
							}
                            
                            if($this->general->isCrudAllow($this->CRUD,"edit")==true){
                                $html.='<button type="button" data-id="'.$d.'" data-payment-type="'.$row['PaymentType'].'" class="btn  btn-outline-success btn-sm -success mr-10 btnEdit" data-original-title="Edit"><i class="fa fa-pencil"></i></button>';
                            }
                            if($this->general->isCrudAllow($this->CRUD,"delete")==true){
                                $html.='<button type="button" data-id="'.$d.'" data-payment-type="'.$row['PaymentType'].'" class="btn  btn-outline-danger btn-sm -success btnDelete" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                            }
							return $html;
						}
                ),
				array( 'db' => 'PaymentType', 'dt' => '8' )
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_payments as H LEFT JOIN tbl_vendors as V ON V.VendorID=H.VendorID';
			$data['PRIMARYKEY']='H.TranNo';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns1;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" H.DFlag=0 ";
			return $ServerSideProcess->SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function getOrderDetails(Request $req,$OrderID){
		$sql="SELECT GH.GRNo,PO.PONo,GD.ProductID,P.PName, U.UCode, GD.Quantity as GRQty, PD.Qty as POQty,  GD.Price, GD.TaxType, GD.TaxPer, GD.Taxable, GD.TaxAmount, GD.CGSTPer, GD.CGSTAmount, GD.SGSTPer, GD.SGSTAmount, GD.IGSTPer, GD.IGSTAmount, GD.Amount FROM tbl_purchase_order_gr as GH LEFT JOIN tbl_purchase_order_gr_details as GD ON GD.TranNo=GH.TranNo  LEFT JOIN tbl_products as P ON P.PID=GD.ProductID LEFT JOIN tbl_uom as U ON U.UID=P.UOM LEFT JOIN tbl_purchase_order as PO ON PO.PurchaseID=GD.POID LEFT JOIN tbl_purchase_order_details as PD ON PD.PurchaseID=PO.PurchaseID  and PD.DetailID=GD.PODetailID WHERE GH.TranNo In(Select GRID From tbl_purchase_invoice_details Where OrderID='".$OrderID."') Order By PO.PurchaseID,GH.TranNo,GD.ProductID asc;";

		$formdata=$this->general->UserInfo;
		$formdata['data']=DB::SELECT($sql);
		return view('app.transaction.payments.inv-details',$formdata);
	}
	public function Delete(Request $req,$TranNo){
		$OldData=$this->getPayments(array("TranNo"=>$TranNo));$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"delete")==true){
			DB::beginTransaction();
			$status=true;
			try{
				if($OldData[0]['PaymentType']=="Advance"){
					$temp=DB::Table('tbl_advance_amount_log')->where('AdvID',$TranNo)->get();
					for($i=0;$i<count($temp);$i++){
						$sql="Update tbl_payment_details Set LessFromAdvance=LessFromAdvance-".$temp[$i]->Amount." Where TranNo='".$temp[$i]->PaymentID."' and DetailID='".$temp[$i]->DetailID."'";
						DB::Update($sql);

						$sql="Update tbl_payment_details SET Amount=LessFromAdvance+PaidAmount Where TranNo='".$result[$i]->PaymentID."' and DetailID='".$result[$i]->DetailID."'";
						DB::Update($sql);
						
						$sql="Update tbl_payments SET TotalAmount= (SELECT SUM(IFNULL(Amount,0)) as Amount FROM tbl_payment_details where TranNo='".$result[$i]->PaymentID."') Where TranNo='".$result[$i]->PaymentID."'";
						DB::Update($sql);

						
						$sql="Update tbl_advance_amount_log SET Amount= 0 Where TranNo='".$temp[$i]->TranNo."'";
						DB::Update($sql);
						
					}
					$this->general->UpdateAdvanceAmount("Payments",$OldData[0]['VendorID']);

					DB::table('tbl_advance_amount_log')->where('AdvID',$TranNo)->delete();
				}else{
					
					$temp=DB::Table('tbl_advance_amount_log')->where('PaymentID',$TranNo)->get();
					for($i=0;$i<count($temp);$i++){
						$sql="Update tbl_advance_amount_log SET Amount= 0 Where TranNo='".$temp[$i]->TranNo."'";
						DB::Update($sql);
					}
					$this->general->UpdateAdvanceAmount("Payments",$OldData[0]['VendorID']);
					DB::Table('tbl_advance_amount_log')->where('PaymentID',$TranNo)->delete();

					
				}

				$status=DB::table('tbl_payments')->where('TranNo',$TranNo)->delete();
				if($status){
					$temp=DB::Table('tbl_payment_details')->where('TranNo',$TranNo)->get();
					if(count($temp)>0){
						$status=DB::Table('tbl_payment_details')->where('TranNo',$TranNo)->delete();
					}
				}
                if($status){
                    $Details=$OldData[0]['Details'];
                    for($i=0;$i<count($Details);$i++){
                        $status=$this->general->PurchasePaymentUpdates($OldData[0]['VendorID'],$Details[$i]['OrderID']);
                    }
					
                }
			}catch(Exception $e) {

			}
			if($status==true){
				DB::commit();
                $NewData=$this->getPayments(array("TranNo"=>$TranNo));
				$logData=array("Description"=>"Payment(".$TranNo.") has been Deleted ","ModuleName"=>$this->ActiveMenuName,"Action"=>"Delete","ReferID"=>$TranNo,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				$this->logs->Store($logData);
				return array('status'=>true,'message'=>"Payment deleted successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Payment delete failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
    public function getDetails(Request $req){
        $FormData=array();
		$FormData['Settings']=$this->Settings;
        $FormData['Data']=$this->getPayments(array('TranNo'=>$req->TranNo));
        return view('app.transaction.payments.details',$FormData);
    }
	/*
    public function save(request $req){
		if($this->general->isCrudAllow($this->CRUD,"add")==true){
            $UINfo=$this->general->UserInfo;
			$OldData=array();$NewData=array();$TranNo="";
			$ValidDB=array();
			//Vendor
			$ValidDB['Vendor']['TABLE']="tbl_vendors";
			$ValidDB['Vendor']['ErrMsg']="Vendor does not exists.";
			$ValidDB['Vendor']['WHERE'][]=array("COLUMN"=>"VendorID","CONDITION"=>"=","VALUE"=>$req->Vendor);
			$ValidDB['Vendor']['WHERE'][]=array("COLUMN"=>"ActiveStatus","CONDITION"=>"=","VALUE"=>1);
			$ValidDB['Vendor']['WHERE'][]=array("COLUMN"=>"DFlag","CONDITION"=>"=","VALUE"=>0);
			$rules=array(
				'Vendor' =>['required',new ValidDB($ValidDB['Vendor'])],
                'TranDate' => 'required|date|before:'.date('Y-m-d',strtotime('+1 days')),
                'MOP' => 'required'
			)				;
			$message=array(
				'Vendor.required'=>"Vendor is required",
				'TranDate.required'=>"Payment Date is required",
				'TranDate.date'=>"Payment Date must be Date",
				'MOP.required'=>"Mode Of Payment is required"
			);
			$validator = Validator::make($req->all(), $rules,$message);
			
			if ($validator->fails()) {
				return array('status'=>false,'message'=>"Payment create failed",'errors'=>$validator->errors());			
			}
			DB::beginTransaction();
			$status=false;
			try {
				$TranNo = DocNum::getDocNum(docTypes::Payments->value, $this->currfyDB,Helper::getCurrentFy());
				$data=array(
                    "TranNo"=>$TranNo,
                    "TranDate"=>date("Y-m-d",strtotime($req->TranDate)),
                    "VendorID"=>$req->Vendor,
                    "MOP"=>$req->MOP,
                    "MOPRefNo"=>$req->MOPRefNo,
                    "ChequeDate"=>date("Y-m-d",strtotime($req->ChequeDate)),
                    "TotalAmount"=>floatval($req->TotalAmount),
                    "CreatedOn"=>date("Y-m-d H:i:s"),
                    "CreatedBy"=>$this->UserID
				);
				$status=DB::Table('tbl_payments')->insert($data);
                if($status){
                    $Details=json_decode($req->Details,true);
                    for($i=0;$i<count($Details);$i++){
                        if($status){
							$DetailID = DocNum::getDocNum(docTypes::PaymentDetails->value, $this->currfyDB,Helper::getCurrentFy());
                            $data=array(
                                "DetailID"=>$DetailID,
                                "TranNo"=>$TranNo,
                                "OrderID"=>$Details[$i]['OrderID'],
                                "OrderID"=>$Details[$i]['OrderID'],
                                "PaidAmount"=>floatval($Details[$i]['Amount']),
                                "CreatedOn"=>date("Y-m-d H:i:s")
                            );
                            $status=DB::Table('tbl_payment_details')->insert($data);
                            if($status){
								DocNum::updateDocNum(docTypes::PaymentDetails->value, $this->currfyDB);
                                $status=$this->general->PurchasePaymentUpdates($req->Vendor,$Details[$i]['OrderID'],$Details[$i]['OrderID']);
                            }
                        }
                    }
                }
			}catch(Exception $e) {
				$status=false;
			}

			if($status==true){
				DocNum::updateDocNum(docTypes::Payments->value, $this->currfyDB);
				$NewData=$this->getPayments(array("TranNo"=>$TranNo));
				$logData=array("Description"=>"New Payment Created ","ModuleName"=>$this->ActiveMenuName,"Action"=>"Add","ReferID"=>$TranNo,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				$this->logs->Store($logData);
				DB::commit();
				return array('status'=>true,'message'=>"Payment created successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Payment create Failed");
			}
		}else{
			return array('status'=>false,'message'=>'Access denined');
		}
    }
	public function Restore(Request $req,$TranNo){
		$OldData=$this->getPayments(array("TranNo"=>$TranNo));$NewData=array();
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			DB::beginTransaction();
			$status=false;
			try{
				$status=DB::table('tbl_payments')->where('TranNo',$TranNo)->update(array("DFlag"=>0,"UpdatedBy"=>$this->UserID,"UpdatedOn"=>date("Y-m-d H:i:s")));
                if($status){
                    $Details=$OldData[0]['Details'];
                    for($i=0;$i<count($Details);$i++){
                        $status=$this->general->PurchasePaymentUpdates($OldData[0]['VendorID'],$Details[$i]['OrderID']);
                    }
                }
			}catch(Exception $e) {

			}
			if($status==true){
				DB::commit();
				$NewData=$this->getPayments(array("TranNo"=>$TranNo));
				$logData=array("Description"=>"Payment(".$TranNo.") has been restored ","ModuleName"=>$this->ActiveMenuName,"Action"=>"Restore","ReferID"=>$TranNo,"OldData"=>$OldData,"NewData"=>$NewData,"UserID"=>$this->UserID,"IP"=>$req->ip());
				$this->logs->Store($logData);
				return array('status'=>true,'message'=>"Payment restored successfully");
			}else{
				DB::rollback();
				return array('status'=>false,'message'=>"Payment restore failed");
			}
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}
	public function TrashTableView(Request $request){
		if($this->general->isCrudAllow($this->CRUD,"restore")==true){
			$ServerSideProcess=new ServerSideProcess();
			$columns = array(
				array( 'db' => 'H.TranNo', 'dt' => '0' ),
				array( 'db' => 'H.Trandate', 'dt' => '1','formatter' => function( $d, $row ) {return date($this->Settings['DATE-FORMAT'],strtotime($d));} ),
				array( 'db' => 'V.VendorName', 'dt' => '2' ),
				array( 'db' => 'H.MOP', 'dt' => '3' ),
				array( 'db' => 'H.MOPRefNo', 'dt' => '4' ),
				array( 'db' => 'H.TotalAmount', 'dt' => '5','formatter' => function( $d, $row ) {return Helper::NumberFormat($d,$this->Settings['PRICE-DECIMALS']);} ),
				array(
						'db' => 'H.TranNo',
						'dt' => '6',
						'formatter' => function( $d, $row ) {
                            $html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success btn-sm  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
							return $html;
						}
                )
			);
			$columns1 = array(
				array( 'db' => 'TranNo', 'dt' => '0' ),
				array( 'db' => 'Trandate', 'dt' => '1','formatter' => function( $d, $row ) {return date($this->Settings['DATE-FORMAT'],strtotime($d));} ),
				array( 'db' => 'VendorName', 'dt' => '2' ),
				array( 'db' => 'MOP', 'dt' => '3' ),
				array( 'db' => 'MOPRefNo', 'dt' => '4' ),
				array( 'db' => 'TotalAmount', 'dt' => '5','formatter' => function( $d, $row ) {return Helper::NumberFormat($d,$this->Settings['PRICE-DECIMALS']);} ),
				array(
						'db' => 'TranNo',
						'dt' => '6',
						'formatter' => function( $d, $row ) {
                            $html='<button type="button" data-id="'.$d.'" class="btn btn-outline-success btn-sm  m-2 btnRestore"> <i class="fa fa-repeat" aria-hidden="true"></i> </button>';
							return $html;
						}
                )
			);
			$data=array();
			$data['POSTDATA']=$request;
			$data['TABLE']='tbl_payments as H LEFT JOIN tbl_vendors as V ON V.VendorID=H.VendorID';
			$data['PRIMARYKEY']='H.TranNo';
			$data['COLUMNS']=$columns;
			$data['COLUMNS1']=$columns1;
			$data['GROUPBY']=null;
			$data['WHERERESULT']=null;
			$data['WHEREALL']=" H.DFlag=1 ";
			return $ServerSideProcess->SSP( $data);
		}else{
			return response(array('status'=>false,'message'=>"Access Denied"), 403);
		}
	}*/
}