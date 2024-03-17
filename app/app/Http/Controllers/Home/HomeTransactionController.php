<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\DocNum;
use App\Models\general;
use SSP;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Rules\ValidUnique;
use logs;
use App\helper\helper;
use App\enums\activeMenuNames;
use App\enums\docTypes;
use App\enums\cruds;

class HomeTransactionController extends Controller{
	private $generalDB;
    private $tmpDB;
    private $Company;
    private $PCategories;
	private $UserID;
	private $ReferID;
	private $FileTypes;
	private $UserData;
	private $logDB;
    private $currfyDB;
    private $dateFormat;

    private $general;
    private $ActiveMenuName;
    private $PageTitle;
    private $CRUD;
    private $Settings;
    private $Menus;
    private $shippingAddress;


    public function __construct()
    {
        $this->dateFormat = 'd-M-Y';
        $this->generalDB = Helper::getGeneralDB();
        $this->tmpDB = Helper::getTmpDB();
        $this->logDB = Helper::getLogDB();
        $this->currfyDB = Helper::getCurrFYDB();
        $this->PCategories = DB::Table('tbl_product_category')->where('ActiveStatus', 'Active')->where('DFlag', 0)->select('PCName', 'PCID', 'PCImage')->get()->toArray();
        $this->FileTypes = Helper::getFileTypes(array("category" => array("Images", "Documents")));
        $CompanyData = DB::table('tbl_company_settings')->select('KeyName', 'KeyValue')->get();
        $Company = [];
        foreach ($CompanyData as $item) {
            $Company[$item->KeyName] = $item->KeyValue;
        }
        $this->Company = $Company;
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->UserData = Helper::getUserInfo(Auth()->user()->UserID);
            $this->UserID = auth()->user()->UserID;
            $this->ReferID = auth()->user()->ReferID;
            $this->general=new general($this->UserID,$this->ActiveMenuName);
            $this->Menus=$this->general->loadMenu();
            $this->CRUD=$this->general->getCrudOperations($this->ActiveMenuName);
            $this->Settings=$this->general->getSettings();
            $this->shippingAddress = DB::table('tbl_customer_address as CA')->where('CustomerID',$this->ReferID)
                ->join($this->generalDB.'tbl_countries as C','C.CountryID','CA.CountryID')
                ->join($this->generalDB.'tbl_states as S', 'S.StateID', 'CA.StateID')
                ->join($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'CA.DistrictID')
                ->join($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'CA.TalukID')
                ->join($this->generalDB.'tbl_cities as CI', 'CI.CityID', 'CA.CityID')
                ->join($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'CA.PostalCodeID')
                ->select('CA.AID', 'CA.Address', 'CA.isDefault', 'CA.CountryID', 'C.CountryName', 'CA.StateID', 'S.StateName', 'CA.DistrictID', 'D.DistrictName', 'CA.TalukID', 'T.TalukName', 'CA.CityID', 'CI.CityName', 'CA.PostalCodeID', 'PC.PostalCode')
                ->get();
            return $next($request);
        });
    }

    public function quotations(Request $request)
    {
        $RecentProducts = DB::table('tbl_products as P')->leftJoin('tbl_product_subcategory as PSC','PSC.PSCID','P.SCID')->where('P.ActiveStatus','Active')->where('P.DFlag',0)->select('P.ProductID','P.ProductName','P.ProductImage','PSC.PSCName')
            ->inRandomOrder()->take(18)->get()->toArray();

        foreach($RecentProducts as $data){
            $data->ProductImage = $data->ProductImage ? 'https://rpc.prodemo.in/'.$data->ProductImage :url('/') . '/'.'assets/images/no-image-b.png';
        }
        $CustomerID = $this->ReferID;
        $FormData['Company']=$this->Company;
        $FormData['PCategories']=$this->PCategories;
        $FormData['isRegister']=false;
        $FormData['Cart']=$this->getCart();
        $FormData['ShippingAddress']= $this->shippingAddress;
        return view('home.quotations', $FormData);
    }

    public function quotationData(Request $request)
    {
        logger($request);
        $columns = [
            ['db' => 'EnqNo', 'dt' => '0'],
            ['db' => 'EnqDate', 'dt' => '1', 'formatter' => function ($d, $row) {
                return date($this->dateFormat, strtotime($d));
            }],
            ['db' => 'ExpectedDeliveryDate', 'dt' => '2', 'formatter' => function ($d, $row) {
                return date($this->dateFormat, strtotime($d));
            }],
            [
                'db' => 'Status', 'dt' => '3',
                'formatter' => function ($d, $row) {
                    $badges = [
                        'New' => 'info',
                        'Converted to Quotation' => 'secondary',
                        'Quote Requested' => 'primary',
                        'Accepted' => 'success',
                    ];
                    $class = $badges[$d] ?? '';
                    return "<span class='badge badge-$class m-1'>$d</span>";
                }
            ],
            [
                'db' => 'EnqID', 'dt' => '4',
                'formatter' => function ($d, $row) {
                    $html = '<div>';
                    $html .= '<button type="button" data-id="' . $d . '" class="btn btn-outline-info btn-sm mr-10 btnView">View Enquiry</button>';
                    if ($row['Status'] !== "Allocated") {
                        $html .= '<button type="button" data-id="' . $d . '" class="btn btn-outline-danger btn-sm btnDelete" data-original-title="Delete">Cancel</button>';
                    }
                    $html .= '</div>';
                    return $html;
                }
            ]
        ];

        $data = [];
        $data['POSTDATA'] = $request;
        $data['TABLE'] = $this->currfyDB . 'tbl_enquiry';
        $data['PRIMARYKEY'] = 'EnqID';
        $data['COLUMNS'] = $columns;
        $data['COLUMNS1'] = $columns;
        $data['GROUPBY'] = null;
        $data['WHERERESULT'] = null;
        $data['WHEREALL'] = "";
//            $data['WHEREALL']=" CustomerID = '".$this->ReferID ."' and Status != 'Cancelled'";
        return SSP::SSP($data);
    }

    public function QuoteView(Request $req,$EnqID){
        logger($req);
        logger($EnqID);
//            $FormData=$this->general->UserInfo;
//            $FormData['menus']=$this->Menus;
//            $FormData['crud']=$this->CRUD;
//            $FormData['ActiveMenuName']=$this->ActiveMenuName;
        $FormData['PageTitle'] = $this->PageTitle;
        $CustomerID = $this->ReferID;
        $FormData['Company']=$this->Company;
        $FormData['PCategories']=$this->PCategories;
        $FormData['isEdit'] = false;
        $FormData['isRegister']=false;
        $FormData['Cart']=$this->getCart();
        $FormData['ShippingAddress']= $this->shippingAddress;
        $FormData['Settings'] = $this->Settings;
        $EnqData = DB::Table($this->currfyDB . 'tbl_enquiry as E')
                ->leftJoin('tbl_customer as CU', 'CU.CustomerID', 'E.CustomerID')
                ->leftJoin($this->generalDB.'tbl_countries as C','C.CountryID','CU.CountryID')
                ->leftJoin($this->generalDB.'tbl_states as S', 'S.StateID', 'CU.StateID')
                ->leftJoin($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'CU.DistrictID')
                ->leftJoin($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'CU.TalukID')
                ->leftJoin($this->generalDB.'tbl_cities as CI', 'CI.CityID', 'CU.CityID')
                ->leftJoin($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'CU.PostalCodeID')
                ->leftJoin($this->generalDB.'tbl_countries as DC','DC.CountryID','E.DCountryID')
                ->leftJoin($this->generalDB.'tbl_states as DS', 'DS.StateID', 'E.DStateID')
                ->leftJoin($this->generalDB.'tbl_districts as DD', 'DD.DistrictID', 'E.DDistrictID')
                ->leftJoin($this->generalDB.'tbl_taluks as DT', 'DT.TalukID', 'E.DTalukID')
                ->leftJoin($this->generalDB.'tbl_cities as DCI', 'DCI.CityID', 'E.DCityID')
                ->leftJoin($this->generalDB.'tbl_postalcodes as DPC', 'DPC.PID', 'E.DPostalCodeID')
                ->whereNot('E.Status','Cancelled')->Where('E.EnqID',$EnqID)
                ->select('EnqID','EnqNo','EnqDate','VendorIDs','Status','ReceiverName','ReceiverMobNo','ExpectedDeliveryDate','CU.Email','DPostalCodeID','E.PostalCodeID','E.Address','C.CountryName','S.StateName','D.DistrictName','T.TalukName','CI.CityName','PC.PostalCode','DAddress','DC.CountryName as DCountryName','DS.StateName as DStateName','DD.DistrictName as DDistrictName','DT.TalukName as DTalukName','DCI.CityName as DCityName','DPC.PostalCode as DPostalCode')
                ->first();
            $FormData['EnqData']=$EnqData;
            if($EnqData){
                $VendorQuote = [];
                $FinalQuoteData = [];
                $PData=DB::table($this->currfyDB.'tbl_enquiry_details as ED')->leftJoin('tbl_products as P','P.ProductID','ED.ProductID')->leftJoin('tbl_uom as UOM','UOM.UID','ED.UOMID')->where('ED.EnqID',$EnqID)->select('ED.ProductID','ED.CID','ED.SCID','ED.Qty','P.ProductName','UOM.UID','UOM.UName','UOM.UCode')->get();
                if(count($PData) > 0){
                    foreach($PData as $row){
                        $row->AvailableVendors=[];
                        $AllVendors = DB::table('tbl_vendors as V')->join('tbl_vendors_service_locations as VSL','V.VendorID','VSL.VendorID')->leftJoin('tbl_vendor_ratings as VR','VR.VendorID','V.VendorID')->where('V.ActiveStatus',"Active")->where('V.isApproved',1)->where('V.DFlag',0)->where('VSL.PostalCodeID',$FormData['EnqData']->DPostalCodeID)->select('V.VendorID','V.VendorName','VR.OverAll')->get();
                        if(count($AllVendors)>0){
                            foreach($AllVendors as $item){
                                $isProductAvailable= DB::Table('tbl_vendors_product_mapping')->where('Status',1)->Where('VendorID',$item->VendorID)->where('ProductID',$row->ProductID)->first();
                                if($isProductAvailable){
                                    $row->AvailableVendors[] = [
                                        "VendorID" => $item->VendorID,
                                        "VendorName" => $item->VendorName,
                                        "OverAll" => $item->OverAll,
                                        "ProductID" => $isProductAvailable->ProductID,
                                    ];
                                }
                            }
                        }
                    }
                }
                if($EnqData->Status == "Quote Requested" && $EnqData->VendorIDs && count(unserialize($EnqData->VendorIDs)) > 0){
                    $VendorQuote = DB::Table($this->currfyDB.'tbl_vendor_quotation as VQ')->join('tbl_vendors as V','V.VendorID','VQ.VendorID')/* ->where('VQ.Status','Sent') */->where('VQ.EnqID',$EnqID)->select('VQ.VendorID','V.VendorName','VQ.VQuoteID','VQ.Status','VQ.AdditionalCost')->get();
                    foreach($VendorQuote as $row){
                        $row->ProductData = DB::table($this->currfyDB.'tbl_vendor_quotation_details as VQD')->where('VQuoteID',$row->VQuoteID)
                            ->select('DetailID','ProductID','Price','VQuoteID')
                            ->get();
                    }
                }elseif($EnqData->Status == "Converted to Quotation"){
                    $FinalQuoteData = DB::Table($this->currfyDB.'tbl_quotation_details as QD')->join($this->currfyDB.'tbl_quotation as Q','Q.QID','QD.QID')->join('tbl_vendors as V','V.VendorID','QD.VendorID')->join('tbl_products as P','P.ProductID','QD.ProductID')->join('tbl_uom as UOM','UOM.UID','P.UID')->where('Q.EnqID',$EnqID)->get();
                }

                $FormData['PData'] = $PData;
                $FormData['VendorQuote'] = $VendorQuote;
                $FormData['FinalQuoteData'] = $FinalQuoteData;
                // return $FormData['VendorQuote'];
                return view('home.quote-view', $FormData);
            }else{
                return view('errors.403');
            }
    }

    public function orders(Request $request)
    {
        logger("orders");
        logger($request);
        logger($request->ip());
    }

	public function getCart(){
        $Cart = DB::table('tbl_customer_cart as C')->join('tbl_products as P','P.ProductID','C.ProductID')->join('tbl_product_category as PC', 'PC.PCID', 'P.CID')->join('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')->join('tbl_uom as U', 'U.UID', 'P.UID')
        ->where('C.CustomerID', $this->ReferID)->where('P.ActiveStatus', 'Active')->where('P.DFlag', 0)->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
        ->select('P.ProductName','P.ProductID','C.Qty', 'PC.PCName', 'PC.PCID', 'PSC.PSCName','U.UName','U.UCode','U.UID', 'PSC.PSCID',DB::raw('CONCAT(IF(ProductImage != "", "https://rpc.prodemo.in/", "' . url('/') . '/"), COALESCE(NULLIF(ProductImage, ""), "assets/images/no-image-b.png")) AS ProductImage'))->get();

        return $Cart;
    }
}
