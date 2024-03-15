<?php
namespace App\Http\Controllers\Home;

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
class HomeController extends Controller{
	private $general;
	private $UserID;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $Settings;
	private $FileTypes;
    private $Menus;
	private $generalDB;
	
    public function GuestView(Request $req){
		$CompanyData= DB::table('tbl_company_settings')->select('KeyName','KeyValue')->get();
		$Company= [];
		foreach ($CompanyData as $item) {
			$Company[$item->KeyName] = $item->KeyValue;
		}
		$FormData['Company']=$Company;
		$PCatagories = DB::Table('tbl_product_category')->where('ActiveStatus','Active')->where('DFlag',0)->select('PCName','PCID','PCImage')
        ->inRandomOrder()->take(10)->get();

		foreach($PCatagories as $row){
			$row->PCImage = $row->PCImage ? url('/').'/'.$row->PCImage :url('/') . '/'.'assets/images/no-image-b.png';
			$row->PSCData = DB::table('tbl_product_subcategory')->where('ActiveStatus','Active')->where('DFlag',0)->where('PCID',$row->PCID)->select('PSCID','PSCName','PSCImage')->get();
		}

		$RecentProducts = DB::table('tbl_products as P')->leftJoin('tbl_product_subcategory as PSC','PSC.PSCID','P.SCID')->where('P.ActiveStatus','Active')->where('P.DFlag',0)->select('P.ProductID','P.ProductName','P.ProductImage','PSC.PSCName')
        ->inRandomOrder()->take(10)->get()->toArray();

		foreach($RecentProducts as $data){
			// $data->ProductImage = $data->ProductImage ? url('/').'/'.$data->ProductImage :url('/') . '/'.'assets/images/no-image-b.png';
			$data->ProductImage = $data->ProductImage ? 'https://rpc.prodemo.in/'.$data->ProductImage :url('/') . '/'.'assets/images/no-image-b.png';
		}
		$FormData['PCategories']=$PCatagories;
		$FormData['RecentProducts']=$RecentProducts;
		shuffle($RecentProducts);
		$FormData['HotProducts']=$RecentProducts;
		return view('home.guest-home',$FormData);
    }
	
	
}
