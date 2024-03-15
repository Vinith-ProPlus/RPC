<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Helper;
use activeMenuNames;
use docTypes;
use general;
class dashboardController extends Controller{
	private $general;
	private $support;
	private $DocNum;
	private $UserID;
	private $ActiveMenuName;
	private $PageTitle;
	private $CRUD;
	private $logs;
	private $Settings;
    private $Menus;
    public function __construct(){
		$this->ActiveMenuName=activeMenuNames::Dashboard->value;
        $this->PageTitle="Dashboard";
        $this->middleware('auth');
		$this->middleware(function ($request, $next) {
			$this->UserID=auth()->user()->UserID;
			$this->general=new general($this->UserID,$this->ActiveMenuName);
			$this->Menus=$this->general->loadMenu();
			$this->CRUD=$this->general->getCrudOperations($this->ActiveMenuName);
			//$this->logs=new logController();
			$this->Settings=$this->general->getSettings();
			return $next($request);
		});
    }
    public function dashboard(Request $req){
        $FormData=$this->general->UserInfo;
        $FormData['ActiveMenuName']=$this->ActiveMenuName;
        $FormData['PageTitle']=$this->PageTitle;
        $FormData['menus']=$this->Menus;
        $FormData['crud']=$this->CRUD;
        return view('app.dashboard',$FormData);
    }
}
