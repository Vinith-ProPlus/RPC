<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Controllers\web\masters\general\TaluksController;
use App\Http\Controllers\web\Settings\ChatSuggestionsController;
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
    private $CurrFyDB;
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
        $this->supportDB = Helper::getSupportDB();
        $this->generalDB = Helper::getGeneralDB();
        $this->tmpDB = Helper::getTmpDB();
        $this->logDB = Helper::getLogDB();
        $this->CurrFyDB = Helper::getCurrFYDB();
        $this->PCategories = DB::Table('tbl_product_category')->where('ActiveStatus', 'Active')->where('DFlag', 0)->select('PCName', 'PCID', 'PCImage')->get();
        $this->FileTypes = Helper::getFileTypes(array("category" => array("Images", "Documents")));
        $this->Company = DB::table('tbl_company_settings')->select('KeyName', 'KeyValue')->get()->pluck('KeyValue', 'KeyName')->toArray();
        $this->Company['AddressData'] = DB::table($this->generalDB.'tbl_cities as CI')
            ->leftJoin($this->generalDB.'tbl_postalcodes as PC', 'PC.PID', 'CI.PostalID')
            ->leftJoin($this->generalDB.'tbl_taluks as T', 'T.TalukID', 'CI.TalukID')
            ->leftJoin($this->generalDB.'tbl_districts as D', 'D.DistrictID', 'CI.DistrictID')
            ->leftJoin($this->generalDB.'tbl_states as S', 'S.StateID', 'CI.StateID')
            ->leftJoin($this->generalDB.'tbl_countries as C','C.CountryID','CI.CountryID')->where('CI.CityID',$this->Company['CityID'])
            ->select('C.CountryName','S.StateName','D.DistrictName','T.TalukName','CI.CityName', 'PC.PostalCode')
            ->first();
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->UserData = Helper::getUserInfo(Auth()->user()->UserID);
            $this->UserID = auth()->user()->UserID;
            $this->ReferID = auth()->user()->ReferID;
            $this->general=new general($this->UserID,$this->ActiveMenuName);
            $this->Menus=$this->general->loadMenu();
            $this->CRUD=$this->general->getCrudOperations($this->ActiveMenuName);
            $this->Settings=$this->general->getSettings();
            $this->shippingAddress = DB::table('tbl_customer_address as CA')->where('CustomerID',$this->ReferID)->where('CA.DFlag',0)
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
        $FormData['Company'] = $this->Company;
        $PCatagories = DB::Table('tbl_product_category')->where('ActiveStatus', 'Active')->where('DFlag', 0)->select('PCName', 'PCID', 'PCImage')
            ->inRandomOrder()->take(10)->get();
        $FormData['PCategories'] = $PCatagories;
        $FormData['isRegister'] = false;
        $FormData['Cart'] = $this->getCart();
        $FormData['ShippingAddress'] = $this->shippingAddress;
        return view('home.quotations', $FormData);
    }

    public function quotationData(Request $request)
    {
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
        $data['TABLE'] = $this->CurrFyDB . 'tbl_enquiry';
        $data['PRIMARYKEY'] = 'EnqID';
        $data['COLUMNS'] = $columns;
        $data['COLUMNS1'] = $columns;
        $data['GROUPBY'] = null;
        $data['WHERERESULT'] = null;
        $data['WHEREALL'] = "";
//            $data['WHEREALL']=" CustomerID = '".$this->ReferID ."' and Status != 'Cancelled'";
        return SSP::SSP($data);
    }

    public function myAccount(Request $request)
    {
        $FormData['Company'] = $this->Company;
        $PCatagories = DB::Table('tbl_product_category')->where('ActiveStatus', 'Active')->where('DFlag', 0)
            ->select('PCName', 'PCID',
                DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
            ->inRandomOrder()->take(10)->get();
        $FormData['PCategories'] = $PCatagories;
        $FormData['isRegister'] = false;
        $FormData['Cart'] = $this->getCart();
        $FormData['ShippingAddress'] = $this->shippingAddress;
        $chatExist = DB::table($this->supportDB.'tbl_chat')->where('sendFrom', $this->UserID)->exists();
        if(!$chatExist) {
            $chatStatus = DB::table($this->supportDB . 'tbl_chat')->insert([
                "ChatID" => DocNum::getDocNum(docTypes::Chat->value),
                "sendFrom" => $this->UserID,
                "sendTo" => "Admin",
                "Status" => "Active",
                "isRead" => 0,
                "LastMessageOn" => now(),
                "CreatedOn" => now(),
            ]);
            if($chatStatus) {
                DocNum::updateDocNum(docTypes::Chat->value);
            }
        }

        $FormData['Chat'] = DB::table($this->supportDB.'tbl_chat')->where('sendFrom', $this->UserID)->first();
        $FormData['chatMessageCount'] = DB::table($this->supportDB.'tbl_chat_message')->where('ChatID', $FormData['Chat']->ChatID)->count();
        if($FormData['chatMessageCount'] === 0){
            $FormData['ChatSuggestions'] = DB::Table('tbl_chat_suggestions')->where('ActiveStatus', 'Active')->where('DFlag', 0)->get();
        }
        return view('home.my-account', $FormData);
    }

    public function wishlist(Request $request)
    {
        $FormData['Company'] = $this->Company;
        $PCatagories = DB::Table('tbl_product_category')->where('ActiveStatus', 'Active')->where('DFlag', 0)
            ->select('PCName', 'PCID',
                DB::raw('CONCAT("' . url('/') . '/", COALESCE(NULLIF(PCImage, ""), "assets/images/no-image-b.png")) AS PCImage'))
            ->inRandomOrder()->take(10)->get();
        $FormData['PCategories'] = $PCatagories;
        $FormData['isRegister'] = false;
        $FormData['Cart'] = $this->getCart();
        $FormData['ShippingAddress'] = $this->shippingAddress;
        return view('home.wishlist', $FormData);
    }

	public function getCart(){
        $Cart = DB::table('tbl_customer_cart as C')->join('tbl_products as P','P.ProductID','C.ProductID')
        ->join('tbl_product_subcategory as PSC', 'PSC.PSCID', 'P.SCID')
        ->join('tbl_product_category as PC', 'PC.PCID', 'PSC.PCID')
        ->join('tbl_uom as U', 'U.UID', 'P.UID')
        ->where('C.CustomerID', $this->ReferID)->where('P.ActiveStatus', 'Active')->where('P.DFlag', 0)->where('PC.ActiveStatus', 'Active')->where('PC.DFlag', 0)->where('PSC.ActiveStatus', 'Active')->where('PSC.DFlag', 0)
        ->select('P.ProductName', 'P.ProductID', 'C.Qty', 'PC.PCName', 'PC.PCID', 'PSC.PSCName', 'U.UName',
            'U.UCode', 'U.UID', 'PSC.PSCID','P.ProductImage')->get()->map(function ($cart) {
            $cart->ProductImage = (new Helper)->fileCheckAndUrl($cart->ProductImage, 'assets/images/no-image-b.png');
            return $cart;
        });
        return $Cart;
    }
}
