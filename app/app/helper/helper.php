<?php
namespace App\helper;
use DB;
use DocNum;
use Illuminate\Support\Facades\Config;
use Session;
use GuzzleHttp\Client;
class helper{
	public static function getMainDB(){
		return config('app.db_main').".";
	}
	public static function getGeneralDB(){
		return config('app.db_general').".";
	}
	public static function getLogDB(){
		return config('app.db_log').".";
	}
	public static function getCurrFYDB(){
		$FY = self::getCurrentFY();
		return "rpc_fy_" . $FY.".";
	}
	public static function getStockDB(){
		return "rpc_stock_fy_2324.";
	}
	public static function getTmpDB(){
		return config('app.db_tmp').".";
	}
	public static function getSupportDB(){
		return config('app.db_support').".";
	}
	public static function getDBPrefix(){
		return config('app.db_prefix');
	}
	public static function getAvailableVendors($AID) {
        $AddressData = DB::table('tbl_customer_address')->where('AID',$AID)->first();
		$AllVendors = DB::table('tbl_vendors as V')
			->join('tbl_vendors_service_locations as VSL', 'V.VendorID', 'VSL.VendorID')
			->where('V.ActiveStatus', "Active")->where('V.DFlag', 0)->where('V.isApproved', '1')
			->where('VSL.DFlag', 0)
			->where('VSL.PostalCodeID', $AddressData->PostalCodeID)->groupBy('V.VendorID')->pluck('V.VendorID')->toArray();
			
		$RadiusVendors = DB::table('tbl_vendors_stock_point as VSP')
			->join('tbl_vendors as V','V.VendorID','VSP.VendorID')
			->where('VSP.ServiceBy','Radius')
			->where('V.ActiveStatus', "Active")->where('V.DFlag',0)
			->where('VSP.DFlag',0)->where('V.isApproved', '1')
			->select('V.VendorID','Latitude','Longitude','Range')->get();
		foreach ($RadiusVendors as $Vendor) {
			$vendorID = self::findVendorsInRange($AddressData, $Vendor);
			if ($vendorID && !in_array($vendorID, $AllVendors)) {
				$AllVendors[] = $vendorID;
			}
		}
		return $AllVendors;
    }
	public static function findVendorsInRange($Customer, $Vendor) {
        $customerLat = $Customer->Latitude;
        $customerLng = $Customer->Longitude;
        $vendorLat = $Vendor->Latitude;
        $vendorLng = $Vendor->Longitude;
        $vendorID = $Vendor->VendorID;
        $range = $Vendor->Range;

        $earthRadius = 6371;
        $dLat = deg2rad($vendorLat - $customerLat);
        $dLon = deg2rad($vendorLng - $customerLng);
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($customerLat)) * cos(deg2rad($vendorLat)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;
        if ($distance <= $range) {
            return $vendorID;
        }else{
            return false;
        }
    }
	public static function findNearestStockPointsss($Customer, $VendorStockPoints) {
		$customerLat = $Customer->Latitude;
		$customerLng = $Customer->Longitude;
		$earthRadius = 6371;
	
		$nearestStockPoints = [];
	
		foreach ($VendorStockPoints as $point) {
			$vendorLat = $point->Latitude;
			$vendorLng = $point->Longitude;
	
			$dLat = deg2rad($vendorLat - $customerLat);
			$dLon = deg2rad($vendorLng - $customerLng);
			$a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($customerLat)) * cos(deg2rad($vendorLat)) * sin($dLon / 2) * sin($dLon / 2);
			$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
			$distance = $earthRadius * $c;
	
			$nearestStockPoints[] = [
				'StockPointID' => $point->StockPointID,
				'Distance' => $distance,
			];
		}
	
		return $nearestStockPoints;
	}
	public static function findNearestStockPoint($Customer, $VendorStockPoints) {
		$customerLat = $Customer->Latitude;
		$customerLng = $Customer->Longitude;
		$minDistance = PHP_INT_MAX;
		$nearestStockPoint = null;
	
		foreach ($VendorStockPoints as $point) {
			$vendorLat = $point->Latitude;
			$vendorLng = $point->Longitude;
	
			$earthRadius = 6371;
			$dLat = deg2rad($vendorLat - $customerLat);
			$dLon = deg2rad($vendorLng - $customerLng);
			$a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($customerLat)) * cos(deg2rad($vendorLat)) * sin($dLon / 2) * sin($dLon / 2);
			$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
			$distance = $earthRadius * $c;
	
			if ($distance < $minDistance) {
				$minDistance = $distance;
				$nearestStockPoint = $point;
			}
		}
		$RouteDistance = self::calculateDistance($Customer,$nearestStockPoint);
		return $RouteDistance;
	}
	
	public static function calculateDistance($Customer, $Vendor){
		$client = new Client();

		$customerLat = $Customer->Latitude;
        $customerLng = $Customer->Longitude;
        $vendorLat = $Vendor->Latitude;
        $vendorLng = $Vendor->Longitude;

		$response = $client->get('https://maps.googleapis.com/maps/api/distancematrix/json', [
			'query' => [
				'origins' => "$customerLat,$customerLng",
            	'destinations' => "$vendorLat,$vendorLng",
				'key' => config('app.map_api_key'),
				'units' => 'metric',
			]
		]);
		$data = json_decode($response->getBody(), true);
		$distance = $data['rows'][0]['elements'][0]['distance']['value'];
		$distanceInKm = $distance / 1000;
		// return response()->json(['distance_km' => $distanceInKm]);
		return $distanceInKm;
	}
	public static function formAddress($Address,$CityID){
		$addressParts = DB::table(self::getGeneralDB().'tbl_cities as CI')
			->leftJoin(self::getGeneralDB().'tbl_postalcodes as PC', 'PC.PID', 'CI.PostalID')
			->leftJoin(self::getGeneralDB().'tbl_taluks as T', 'T.TalukID', 'CI.TalukID')
			->leftJoin(self::getGeneralDB().'tbl_districts as D', 'D.DistrictID', 'T.DistrictID')
			->leftJoin(self::getGeneralDB().'tbl_states as S', 'S.StateID', 'D.StateID')
			->leftJoin(self::getGeneralDB().'tbl_countries as C', 'C.CountryID', 'S.CountryID')
			->where('CI.CityID', $CityID)
			->select('C.CountryName', 'S.StateName', 'D.DistrictName', 'T.TalukName', 'CI.CityName', 'PC.PostalCode')
			->first();

		if ($addressParts) {
			$trimmedAddress = trim($Address);
			$address = substr($trimmedAddress, -1) == ',' ? $trimmedAddress .' ' : $trimmedAddress . ', ';
			$fullAddress = $address . 
					$addressParts->CityName . ', ' .
					$addressParts->TalukName . ', ' .
					$addressParts->DistrictName . ', ' .
					$addressParts->StateName . ', ' .
					$addressParts->CountryName . ' - ' .
					$addressParts->PostalCode;
			return $fullAddress;
		}
	}
	public static function formatAddress($address){
		$parts = explode(',', $address);
		$splittedAddress = [];
		foreach ($parts as $part) {
			$splittedAddress[] = trim((string)$part);
		}
		$formattedAddress[] = implode(', ', array_slice($splittedAddress, 0, -3));
		$formattedAddress = array_merge($formattedAddress, array_slice($splittedAddress, -3));
		return $formattedAddress;
	}
	public static function trimAddress($CompleteAddress){
		$parts = explode(',', $CompleteAddress);
		return trim($parts[0]) .", ". trim($parts[1]);
	}
	
	public static function getVendorDB($VendorID,$UserID){
		$VendorDB = DB::table('tbl_vendors_database')->where('VendorID', $VendorID)->value('DBName');
		if (!$VendorDB) {
			if (self::generateVendorDB($VendorID, $UserID)) {
				$VendorDB = DB::table('tbl_vendors_database')->where('VendorID', $VendorID)->value('DBName');
			}
		}
		return $VendorDB.'.';
	}
	public static function getStockTable($VendorID) {
		$StockDB = self::getStockDB();
	
		$vendorIDParts = explode('-', $VendorID);
	
		$tableName = 'tbl_' . implode('_',$vendorIDParts);
		
		$status = DB::statement("CREATE TABLE IF NOT EXISTS ".$StockDB."tbl_docnum (
			`SLNO` INT AUTO_INCREMENT PRIMARY KEY,
			`DocType` VARCHAR(50) NULL,
			`Prefix` VARCHAR(5) NULL,
			`Length` INT(11) NULL,
			`CurrNum` INT(11) NULL,
			`Suffix` VARCHAR(10),
			`Year` VARCHAR(10) NULL
		)");
	
		$status = DB::statement("CREATE TABLE IF NOT EXISTS ".$StockDB.$tableName." (
			`DetailID` VARCHAR(50) PRIMARY KEY,
			`Date` DATE,
			`VendorID` VARCHAR(50) NULL,
			`StockPointID` VARCHAR(50) NULL,
			`ProductID` VARCHAR(50) NULL,
			`Qty` DOUBLE,
			`CreatedBy` VARCHAR(50) NULL,
			`CreatedOn` TIMESTAMP NULL
		)");

		$VendorIDexists=DB::table($StockDB.'tbl_docnum')->where('DocType', $VendorID)->exists();
		if(!$VendorIDexists){
			$status = DB::table($StockDB . 'tbl_docnum')->insert([
				'DocType' => $VendorID,
				'Prefix' => "VSU",
				'Length' => 10,
				'CurrNum' => 1,
			]);
		}
		return $StockDB.$tableName;
	}	

	public static function generateVendorDB($VendorID,$UserID){
		$DBPrefix="";
		$FYName="";
		$VendorDBName="";
		$ActiveFY=self::getActiveFinancialYear();
		if($ActiveFY->FromDate=="" && $ActiveFY->ToDate==""){
			$t=self::getCurrentFYDates();
			$ActiveFY->FromDate=date("Y-m-d",strtotime($t->FromDate));
			$ActiveFY->ToDate=date("Y-m-d",strtotime($t->ToDate));
		}
		$FYName="fy_".date("y",strtotime($ActiveFY->FromDate)).date("y",strtotime($ActiveFY->ToDate));
		$DBPrefix=self::getDBPrefix();
		$VendorUniqueID=self::generateUniqueVendorID($VendorID);
		$t=DB::table('tbl_vendors')->where('VendorID',$VendorID)->exists();
		if($t){
			$VendorDBName = $DBPrefix.'v_'.$VendorUniqueID.'_'.$FYName;
			$sql = "CREATE DATABASE IF NOT EXISTS $VendorDBName";
			$status = DB::statement($sql);
			$status = true;
			if($status){
				$isVendorIDExists=DB::table('tbl_vendors_database')->where('VendorID', $VendorID)->exists();
				if(!$isVendorIDExists){
					$data = [
						'VendorID' => $VendorID,
						'DBName' => $VendorDBName,
						'VendorUniqueID' => $VendorUniqueID,
						'CreatedBy' => $UserID,
						'CreatedOn' => now(),
					];
					$status = DB::table('tbl_vendors_database')->insert($data);
					if($status){
						return $status;
					}
				}else{
					return ['status' =>false,'message' =>'Vendor Name Exists!'];
				}
			}
		}
	}

	public static function generateUniqueVendorID($VendorID) {
		$isVendorIDExists=DB::table('tbl_vendors_database')->where('VendorID', $VendorID)->exists();
		if(!$isVendorIDExists){
			do {
				$randomID = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 4);
				$isExists = DB::table('tbl_vendors_database')->where('VendorUniqueID', $randomID)->exists();
			} while ($isExists);
			return $randomID;
		}
	}
	
	public static function generateFinancialYearName($FromDate,$ToDate){
		return "FY-".date("y",strtotime($FromDate)).date("y",strtotime($ToDate));
	}
	public static function getLogTableName(){
		$LogDB=self::getLogDB();
		$MainDB=self::getMainDB();
		$return=$MainDB."tbl_log";
		$ActiveFY=self::getActiveFinancialYear();
		if($ActiveFY->FromDate=="" && $ActiveFY->ToDate==""){
			$t=self::getCurrentFYDates();
			$ActiveFY->FromDate=date("Y-m-d",strtotime($t->FromDate));
			$ActiveFY->ToDate=date("Y-m-d",strtotime($t->ToDate));
		}
		$FYName=self::generateFinancialYearName($ActiveFY->FromDate,$ActiveFY->ToDate);
		$FYName=str_replace("-","_",$FYName);
		$FYName=str_replace(" ","_",$FYName); 
		$TableName=$FYName!=""?"tbl_log_".$FYName:"tbl_log";
		if(self::checkTableExists($LogDB,$TableName)==false){
			$sql="CREATE TABLE IF NOT EXISTS ".$LogDB.$TableName." (LogID varchar(50) PRIMARY Key,ReferID varchar(50),Description varchar(255),ModuleName varchar(150),Action varchar(100) ,OldData text,NewData text,IPAddress varchar(100),UserID varchar(50),LogTime timestamp NOT NULL DEFAULT current_timestamp);";
			DB::Statement($sql);
			return self::getLogTableName();
		}
		return $LogDB.$TableName;
	}
	public static function getFinancialYears(){
		$sql="Select SLNo,DBName,FromDate,ToDate,FYName,isCurrent From tbl_financial_year Where ActiveStatus='Active' Order By FromDate";
		return DB::SELECT($sql);
	}
	public static function getCurrentFYDates(){
		$FromDate="";$ToDate="";
		if(date("m")<=4){
			$FromDate="01-Apr-".date("Y",strtotime('-1 year'));
			$ToDate="31-Mar-".date("Y");
		}else{
			$FromDate="01-Apr-".date("Y");
			$ToDate="31-Mar-".date("Y",strtotime("1 year"));
		}
		$FromDate=date("Y-m-d",strtotime($FromDate));
		$ToDate=date("Y-m-d",strtotime($ToDate));

		return json_decode(json_encode(array("FromDate"=>$FromDate,"ToDate"=>$ToDate)));
	}
	public static function getCurrentFY(){
		$FromDate="";$ToDate="";
		if(date("m")<=4){
			$FromDate="01-Apr-".date("Y",strtotime('-1 year'));
			$ToDate="31-Mar-".date("Y");
		}else{
			$FromDate="01-Apr-".date("Y");
			$ToDate="31-Mar-".date("Y",strtotime("1 year"));
		}
		$FromDate=date("y",strtotime($FromDate));
		$ToDate=date("y",strtotime($ToDate));

		return $FromDate.$ToDate;
	}
	public static function getFinancialYearDetails($FYID){
		if($FYID==""){
			$t=self::getCurrentFYDates();
			$FromDate=date("Y-m-d",strtotime($t->FromDate));
			$ToDate=date("Y-m-d",strtotime($t->ToDate));
		}
		$data=array("DBName"=>"","FromDate"=>"","ToDate"=>"","FYName"=>"","FYID"=>"");
		$sql="Select SLNo,DBName,FromDate,ToDate,FYName,isCurrent From  tbl_financial_year Where SLNO='".$FYID."'";
		$result=DB::SELECT($sql);
		if(count($result)>0){
			$data['DBName']=$result[0]->DBName;
			$data['FromDate']=$result[0]->FromDate;
			$data['ToDate']=$result[0]->ToDate;
			$data['FYName']=$result[0]->FYName;
			$data['FYID']=$result[0]->SLNo;
			$data['isCurrent']=$result[0]->isCurrent;
		}
		$data=json_encode($data);

		return json_decode($data);
	}
	public static function ActivateFinancialYear($FYID){
		$keyName=config('app.name')."_financial_year";
		Session::put($keyName,$FYID);
	}
	public static function getActiveFinancialYear(){
		$keyName=config('app.name')."_financial_year";
		$FYID="";
		if (Session::has($keyName)){
			$FYID=Session::get($keyName);
		}else{
			$t=self::getCurrentFYDates();
			$sql="Select SLNo,DBName,FromDate,ToDate,FYName,isCurrent From tbl_financial_year Where FromDate='".date("Y-m-d",strtotime($t->FromDate))."' and ToDate='".date("Y-m-d",strtotime($t->ToDate))."'";
			$result=DB::SELECT($sql);
			if(count($result)>0){
				$FYID=$result[0]->SLNo;
				Session::put($keyName,$FYID);
			}
		}
		return self::getFinancialYearDetails($FYID);
	}
	public static function getCurrentFYDBName(){
		$sql="Select SLNo,DBName,FromDate,ToDate,FYName,isCurrent From  tbl_financial_year Where isCurrent='Yes'";
		$result=DB::SELECT($sql);
		if(count($result)>0){
			return $result[0]->DBName.".";
		}
		return "";
	}
	public static function GDEnabled(){
		if (extension_loaded('gd')) {
			return true;
		}else{
			return false;
		}
	}
    public static function isJSON($string):bool{
		try {
			if($string!=""){
				json_decode($string, true, 512, JSON_THROW_ON_ERROR);
			}else{
				return false;
			}

		} catch (JsonException) {
			return false;
		}

    	return true;
	}
	public static function removeFile($url){
		if(file_exists($url)){
			unlink($url);
		}
	}
	public static function EncryptDecrypt($action, $string){
		$output = false;$action=strtoupper($action);
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'gKWRyB9FZ34jQn1CjSl8';
		$secret_iv = 'wVHvDuqDaXkr0PXROT0E2E3wGJEYcwfFcAi8qgnPOcq2pZcUEjn7wruspR1Z';
		$key = hash('sha256', $secret_key);
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		if($action=='ENCRYPT'){
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = strrev(base64_encode($output));
		}
		elseif($action=='DECRYPT'){
			$output = openssl_decrypt(base64_decode(strrev($string)), $encrypt_method, $key, 0, $iv);;
		}
		return $output;
	}
	public static function RandomString($len){
		$validCharacters = "AaBbCcDdEeFfGgHhIiJjKkLlMmNnPpQqRrSsTtUuXxYyVvWwZz1234567890";
		$validCharNumber = strlen($validCharacters);
		$result ="";
		for ($i = 0; $i < $len; $i++){
			$index = mt_rand(0, $validCharNumber - 1);
			$result .= $validCharacters[$index];
		}
		return $result;
	}
	public static function getOTP($len){
		$validCharacters = "1234567890";
		$validCharNumber = strlen($validCharacters);
		$result ="";
		for ($i = 0; $i < $len; $i++){
			$index = mt_rand(0, $validCharNumber - 1);
			$result .= $validCharacters[$index];
		}
		return $result;
    }
	public static function getDateDifferenceinDays($Date1,$Date2){
		$date1=date_create(date("Y-m-d",strtotime($Date1)));
		$date2=date_create(date("Y-m-d",strtotime($Date2)));
		$diff=date_diff($date1,$date2);
		return $diff->format("%a")+1;
	}
	public static function getDateDifference($Date1,$Date2){
        $start=strtotime($Date1);
        $end=strtotime($Date2);
        $min=($end - $start) / 60;
        return self::MinsToGeneral($min);
	}
	public static function getDateDifferenceInMins($Date1,$Date2){
        $start=strtotime($Date1);
        $end=strtotime($Date2);
        $min=($end - $start) / 60;
        return $min;
	}
	public static function HoursToMins($Duration){
		$t=explode(":",$Duration);
		$mins=intval($t[0])*60;
		if(count($t)>1){
			$mins+$t[1];
		}
		return $mins;
	}
	public static function LPad($String,$Length,$PadString){
		return str_pad($String, $Length, $PadString, STR_PAD_LEFT);
	}
	public static function RPad($String,$Length,$PadString){
		return str_pad($String, $Length, $PadString);
	}
	public static function NumberFormat($Value,$Decimal){
		if($Decimal!="auto"){
			return number_format($Value,$Decimal,".","");
		}else{
			return $Value;
		}
	}
	public static function NumberSteps($Decimal){
		$Value="1";
		if($Decimal!="auto"){
			if($Decimal==0){
				return 1;
			}else{
				return "0.".str_pad($Value,$Decimal,"0",STR_PAD_LEFT);
			}
		}else{
			return $Value;
		}
	}
	public static function checkTableExists($DBName,$TableName){
		$DBName=$DBName==""?self::getMainDB():$DBName;
		$DBName=str_replace(".","",$DBName);
        $sql="SELECT * FROM information_schema.tables WHERE table_schema = '".$DBName."' AND table_name = '".$TableName."' LIMIT 1;";
        $result=DB::SELECT($sql);
        if(count($result)>0){
            return true;
        }
        return false;
	}
	public static function checkDBExists($DBName){
		$DBName=str_replace(".","",$DBName);
		$sql="SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '".$DBName."'";
		$result=DB::SELECT($sql);
        if(count($result)>0){
            return true;
        }
        return false;
	}
	public static function addDocNum($DBName, $Doctype, $Prefix, $Length, $CurrNum) {
		$isDocTypeExists = DB::table($DBName . 'tbl_docnum')->where('DocType', $Doctype)->exists();
		if (!$isDocTypeExists) {
			$status = DB::table($DBName . 'tbl_docnum')->insert([
				'DocType' => $Doctype,
				'Prefix' => $Prefix,
				'Length' => $Length,
				'CurrNum' => $CurrNum,
			]);
		} else {
			$status = true;
		}
		return $status;
	}
	public static function getCountry($data=array()){
		$generalDB=self::getGeneralDB();
		$sql="Select * From ".$generalDB."tbl_countries Where ActiveStatus='Active' and DFlag=0 ";
		if(is_array($data)){
			if(array_key_exists("CountryID",$data)){if($data['CountryID']!=""){$sql.=" and CountryID='".$data['CountryID']."'";}}
			if(array_key_exists("sortname",$data)){if($data['sortname']!=""){$sql.=" and sortname='".$data['sortname']."'";}}
			if(array_key_exists("CountryName",$data)){if($data['CountryName']!=""){$sql.=" and CountryName='".$data['CountryName']."'";}}
			if(array_key_exists("PhoneCode",$data)){if($data['PhoneCode']!=""){$sql.=" and PhoneCode='".$data['PhoneCode']."'";}}
			
		}
		$sql.=" Order By CountryName asc";
		return DB::SELECT($sql);
	}
	public static function getState($data=array()){
		$generalDB=self::getGeneralDB();
		$sql="Select * From ".$generalDB."tbl_states Where ActiveStatus='Active' and DFlag=0 ";
		if(is_array($data)){
			if (array_key_exists("CountryID", $data)) {
				if (is_array($data['CountryID']) && !empty($data['CountryID'])) {
					$sql .= " AND CountryID IN ('" . implode("','", $data['CountryID']) . "')";
				} elseif ($data['CountryID'] != "") {
					$sql .= " AND CountryID='" . $data['CountryID'] . "'";
				}
			}
			if (array_key_exists("StateID", $data)) {
				if (is_array($data['StateID']) && !empty($data['StateID'])) {
					$sql .= " AND StateID IN ('" . implode("','", $data['StateID']) . "')";
				} elseif ($data['StateID'] != "") {
					$sql .= " AND StateID='" . $data['StateID'] . "'";
				}
			}
			if(array_key_exists("StateName",$data)){if($data['StateName']!=""){$sql.=" and StateName='".$data['StateName']."'";}}
		}
		$sql.=" Order By StateName asc";
		return DB::SELECT($sql);
	}
	public static function getDistrict($data=array()){
		$generalDB=self::getGeneralDB();
		$sql="Select * From ".$generalDB."tbl_districts Where ActiveStatus='Active' and DFlag=0 ";
		if(is_array($data)){
			if (array_key_exists("CountryID", $data)) {
				if (is_array($data['CountryID']) && !empty($data['CountryID'])) {
					$sql .= " AND CountryID IN ('" . implode("','", $data['CountryID']) . "')";
				} elseif ($data['CountryID'] != "") {
					$sql .= " AND CountryID='" . $data['CountryID'] . "'";
				}
			}
			if (array_key_exists("StateID", $data)) {
				if (is_array($data['StateID']) && !empty($data['StateID'])) {
					$sql .= " AND StateID IN ('" . implode("','", $data['StateID']) . "')";
				} elseif ($data['StateID'] != "") {
					$sql .= " AND StateID='" . $data['StateID'] . "'";
				}
			}
			if (array_key_exists("DistrictID", $data)) {
				if (is_array($data['DistrictID']) && !empty($data['DistrictID'])) {
					$sql .= " AND DistrictID IN ('" . implode("','", $data['DistrictID']) . "')";
				} elseif ($data['DistrictID'] != "") {
					$sql .= " AND DistrictID='" . $data['DistrictID'] . "'";
				}
			}
			if(array_key_exists("DistrictName",$data)){if($data['DistrictName']!=""){$sql.=" and DistrictName='".$data['DistrictName']."'";}}
			
		}
		$sql.=" Order By DistrictName asc";
		return DB::SELECT($sql);
	}
	public static function getTaluk($data=array()){
		$generalDB=self::getGeneralDB();
		$sql="Select * From ".$generalDB."tbl_taluks Where ActiveStatus='Active' and DFlag=0 ";
		if(is_array($data)){
			if(array_key_exists("CountryID",$data)){if($data['CountryID']!=""){$sql.=" and CountryID='".$data['CountryID']."'";}}
			if(array_key_exists("StateID",$data)){if($data['StateID']!=""){$sql.=" and StateID='".$data['StateID']."'";}}
			if(array_key_exists("DistrictID",$data)){if($data['DistrictID']!=""){$sql.=" and DistrictID='".$data['DistrictID']."'";}}
			if(array_key_exists("TalukID",$data)){if($data['TalukID']!=""){$sql.=" and TalukID='".$data['TalukID']."'";}}
			if(array_key_exists("TalukName",$data)){if($data['TalukName']!=""){$sql.=" and TalukName='".$data['TalukName']."'";}}
			
		}
		$sql.=" Order By TalukName asc";
		return DB::SELECT($sql);
	}
	public static function getCity($data=array()){
		// return $data;
		$generalDB=self::getGeneralDB();
		$sql="Select * From ".$generalDB."tbl_cities Where ActiveStatus='Active' and DFlag=0 ";
		if(is_array($data)){
			if(array_key_exists("CountryID",$data)){if($data['CountryID']!=""){$sql.=" and CountryID='".$data['CountryID']."'";}}
			if(array_key_exists("StateID",$data)){if($data['StateID']!=""){$sql.=" and StateID='".$data['StateID']."'";}}
			if(array_key_exists("DistrictID",$data)){if($data['DistrictID']!=""){$sql.=" and DistrictID='".$data['DistrictID']."'";}}
			if(array_key_exists("TalukID",$data)){if($data['TalukID']!=""){$sql.=" and TalukID='".$data['TalukID']."'";}}
			if(array_key_exists("PostalID",$data)){if($data['PostalID']!=""){$sql.=" and PostalID='".$data['PostalID']."'";}}
			if(array_key_exists("CityID",$data)){if($data['CityID']!=""){$sql.=" and CityID='".$data['CityID']."'";}}
			if(array_key_exists("CityName",$data)){if($data['CityName']!=""){$sql.=" and CityName='".$data['CityName']."'";}}
			if(array_key_exists("PostalCode",$data)){
				if($data['PostalCode']!=""){
					$postalData = self::getPostalCode(["PostalCode" => $data['PostalCode']]);
					if (count($postalData) > 0) {
						$postalID = $postalData[0]->PID;
						$sql .= " AND PostalID='" . $postalID . "'";
					}else{
						return ["error" => "Postal Code does not exist"];
					}
				}
			}
		}
		$sql.=" Order By CityName asc ";
		return DB::SELECT($sql);
	}
	public static function getPostalCode($data=array()){
		$generalDB=self::getGeneralDB();
		$sql="Select * From ".$generalDB."tbl_postalcodes Where ActiveStatus='Active' and DFlag=0 ";
		if(is_array($data)){
			if(array_key_exists("CountryID",$data)){if($data['CountryID']!=""){$sql.=" and CountryID='".$data['CountryID']."'";}}
			if(array_key_exists("StateID",$data)){if($data['StateID']!=""){$sql.=" and StateID='".$data['StateID']."'";}}
			if(array_key_exists("DistrictID",$data)){if($data['DistrictID']!=""){$sql.=" and DistrictID='".$data['DistrictID']."'";}}
			if(array_key_exists("PostalCodeID",$data)){if($data['PostalCodeID']!=""){$sql.=" and PID='".$data['PostalCodeID']."'";}}
			if(array_key_exists("PostalCode",$data)){if($data['PostalCode']!=""){$sql.=" and PostalCode='".$data['PostalCode']."'";}}
			
		}
		$sql.=" Order By PostalCode asc ";
		return DB::SELECT($sql);
	}
	public static function getBankType($data=array()){
		$generalDB=self::getGeneralDB();
		$sql="Select * From ".$generalDB."tbl_type_of_bank Where ActiveStatus='Active' and DFlag=0 ";
		$sql.=" Order By TypeOfBank asc ";
		return DB::SELECT($sql);
	}
	public static function getBanks($data=array()){
		$generalDB=self::getGeneralDB();
		$sql="Select *,b.TypeOfBank as TypeBankID,b.SLNO as BankID From ".$generalDB."tbl_banklist as b LEFT JOIN " . $generalDB . "tbl_type_of_bank as tob ON tob.SLNO = b.TypeOfBank Where b.ActiveStatus='Active' and b.DFlag=0 ";
		if(is_array($data)){
			// if(array_key_exists("BankID",$data)){if($data['BankID']!=""){$sql.=" and b.SLNO='".$data['BankID']."'";}}
			if(array_key_exists("TypeOfBankID",$data)){if($data['TypeOfBankID']!=""){$sql.=" and b.TypeOfBank='".$data['TypeOfBankID']."'";}}
		}
		$sql.=" Order By b.NameOfBanks asc ";
		$result = DB::SELECT($sql);
		if(array_key_exists("OptGroup",$data)){if($data['OptGroup'] == 1){
			$return = [];
			for($i = 0; $i < count($result); $i++){
				$return[$result[$i]->TypeOfBank][]=$result[$i];
			}
			return $return;
		}}else{
			return $result;
		}
	}
	public static function getBankBranch($data=array()){
		$generalDB=self::getGeneralDB();
		$sql="Select * From ".$generalDB."tbl_bank_branches Where ActiveStatus='Active' and DFlag=0 ";
		if(is_array($data)){
			if(array_key_exists("BankID",$data)){if($data['BankID']!=""){$sql.=" and BankID='".$data['BankID']."'";}}
			if(array_key_exists("BranchID",$data)){if($data['BranchID']!=""){$sql.=" and SLNO='".$data['BranchID']."'";}}	
			
		}
		$sql.=" Order By BranchName asc ";
		return DB::SELECT($sql);
	}
	public static function getBankAccountType($data=array()){
		$generalDB=self::getGeneralDB();
		$sql="Select * From ".$generalDB."tbl_bank_account_type Where ActiveStatus='Active' and DFlag=0 ";
		if(is_array($data)){
			if(array_key_exists("AccountTypeID",$data)){if($data['AccountTypeID']!=""){$sql.=" and SLNO='".$data['AccountTypeID']."'";}}
		}
		$sql.=" Order By AccountType asc ";
		return DB::SELECT($sql);
	}
	public static function getGender($data=array()){
		$generalDB=self::getGeneralDB();
		$sql="Select * From ".$generalDB."tbl_genders Where ActiveStatus='Active' and DFlag=0 ";
		if(is_array($data)){
			if(array_key_exists("GID",$data)){if($data['GID']!=""){$sql.=" and GID='".$data['GID']."'";}}
		}
		$sql.=" Order By Gender asc ";
		return DB::SELECT($sql);
	}
	public static function getFileTypes($data=array()){
		$generalDB=self::getGeneralDB();
		$return=array();
		$sql="Select * From ".$generalDB."tbl_file_types Where ActiveStatus='Active' and CategoryActiveStatus='Active' and DFlag=0 ";
		if(is_array($data)){
			if(array_key_exists("category",$data)){
				$sql.=" and Category In ('".implode("','",$data['category'])."')";
			}
		}
		$result=DB::Select($sql);
		for($i=0;$i<count($result);$i++){
			$return["category"][$result[$i]->Category][]=str_replace("*.","",$result[$i]->FileExtension);
			$return["All"][]=str_replace("*","",$result[$i]->FileExtension);
		}
		return $return;
	}
	public static function getResizePercentages(){
		$generalDB=self::getGeneralDB();
		$result=DB::Table($generalDB."tbl_image_resize")->where('ActiveStatus','Active')->where('DFlag',0)->get();
		return $result;
	}
	private static function readImage($url){
		if (file_exists($url)) {
			// Get image information
			$imageInfo = getimagesize($url);
		
			// Check if the image type is supported
			$supportedTypes = [
				IMAGETYPE_PNG,
				IMAGETYPE_JPEG,
				IMAGETYPE_GIF,
				IMAGETYPE_BMP,
				IMAGETYPE_WEBP,
			];
			if ($imageInfo && in_array($imageInfo[2], $supportedTypes)) {
				// Attempt to create the image resource directly from URL
				$image = call_user_func('imagecreatefrom' . image_type_to_extension($imageInfo[2], false), $url);
		
				// Check if the image resource was created successfully
				if ($image !== false) {
					return $image;
				} else {
					return null;
				}
			} else {
				return null;
			}
		}
		return null;
	}
    private static function imgSave($ext,$file,$UploadPath){
        if($ext=="gif"){return  imagegif($file,$UploadPath);}
        elseif($ext=="jpg"){return  imagejpeg($file,$UploadPath);}
        elseif($ext=="jpeg"){return  imagejpeg($file,$UploadPath);}
        elseif($ext=="png"){return  imagepng($file,$UploadPath);}
        elseif($ext=="avif"){imageavif($file,$UploadPath);}
        elseif($ext=="bmp"){return  imagebmp($file,$UploadPath);}
        elseif($ext=="wbmp"){return  imagewbmp($file,$UploadPath);}
        elseif($ext=="webp"){return  imagewebp($file,$UploadPath);}
    }
	private static function ResizeImage($FileUrl,$destination_dir,$new_width,$new_height,$fileName=""){
		$uploadPath="";
		//if(file_exists($FileUrl)){
			$ext = pathinfo($FileUrl, PATHINFO_EXTENSION);
			if($fileName==""){
				$fileName = basename($FileUrl, ".".$ext)."_".$new_width."x".$new_height.".".$ext;
			}
			
			
			if(SELF::GDEnabled()){
				list($width, $height) = getimagesize($FileUrl);
				$dst = imagecreatetruecolor($new_width, $new_height);
				$src=SELF::readImage($FileUrl);
				if($src!=null){
					imagecopyresized($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	
					if (!file_exists( $destination_dir)) {mkdir( $destination_dir, 0777, true);}
					$uploadPath=$destination_dir.$fileName;
					self::imgSave($ext,$dst,$uploadPath);
				}
			}
		//}
		return $uploadPath;
	}
	public static function ImageResize($FileUrl,$destination_dir){
		list($imgWidth, $imgHeight) = getimagesize($FileUrl);
		$ResizePercentages=self::getResizePercentages();
		$resizedImgUrls=array();
		$resizedImgUrls['100']=array("width"=>$imgWidth,"height"=>$imgHeight,"url"=>$FileUrl);
		foreach($ResizePercentages as $index=>$percentage){
			$newWidth=($imgWidth*$percentage->Percentage)/100;
			$newHeight=($imgHeight*$percentage->Percentage)/100;
			
			$ext = pathinfo($FileUrl, PATHINFO_EXTENSION);
			$fileName = basename($FileUrl, ".".$ext)."_".$percentage->Percentage.".".$ext;
			$uploadUrl=self::ResizeImage($FileUrl,$destination_dir,$newWidth,$newHeight,$fileName);
			$resizedImgUrls[$percentage->Percentage]=array("width"=>$newWidth,"height"=>$newHeight,"url"=>$uploadUrl);
		}
		return $resizedImgUrls;
	}
	public static function generateSlug($string) {
		// Remove special characters
		$string = preg_replace('/[^a-zA-Z0-9\s]/', '', $string);
		
		// Convert to lowercase
		$string = strtolower($string);
	
		// Replace spaces with dashes
		$string = str_replace(' ', '-', $string);
	
		// Remove consecutive dashes
		$string = preg_replace('/-+/', '-', $string);
	
		// Trim dashes from the beginning and end
		$string = trim($string, '-');
	
		return $string;
	}
	public static function checkProductImageExists($url){
		$image=file_exists($url)?$url:"assets/images/no-images.jpg";
		return $image;
	}
	
	public static function getVehicleType($data=array()){
		$generalDB=self::getGeneralDB();
		$sql="Select * From ".$generalDB."tbl_vehicle_type Where ActiveStatus='Active' and DFlag=0 ";
		if(is_array($data)){
			if(array_key_exists("VehicleTypeID",$data)){if($data['VehicleTypeID']!=""){$sql.=" and VehicleTypeID='".$data['VehicleTypeID']."'";}}
			if(array_key_exists("VehicleBrandID",$data)){if($data['VehicleBrandID']!=""){$sql.=" and VehicleBrandID='".$data['VehicleBrandID']."'";}}
			if(array_key_exists("VehicleBrandName",$data)){if($data['VehicleBrandName']!=""){$sql.=" and VehicleBrandName='".$data['VehicleBrandName']."'";}}
		}
		$sql.=" Order By VehicleType asc";
		return DB::SELECT($sql);
	}
	public static function getVehicleModel($data=array()){
		$generalDB=self::getGeneralDB();
		$sql="Select * From ".$generalDB."tbl_vehicle_model Where ActiveStatus='Active' and DFlag=0 ";
		if(is_array($data)){
			if(array_key_exists("VehicleTypeID",$data)){if($data['VehicleTypeID']!=""){$sql.=" and VehicleTypeID='".$data['VehicleTypeID']."'";}}
			if(array_key_exists("VehicleBrandID",$data)){if($data['VehicleBrandID']!=""){$sql.=" and VehicleBrandID='".$data['VehicleBrandID']."'";}}
			if(array_key_exists("VehicleModelID",$data)){if($data['VehicleModelID']!=""){$sql.=" and VehicleModelID='".$data['VehicleModelID']."'";}}
			if(array_key_exists("VehicleModel",$data)){if($data['VehicleModel']!=""){$sql.=" and VehicleModel='".$data['VehicleModel']."'";}}
		}
		$sql.=" Order By VehicleModel asc";
		return DB::SELECT($sql);
	}
	public static function getVehicleBrand($data=array()){
		$generalDB=self::getGeneralDB();
		$sql="Select * From ".$generalDB."tbl_vehicle_brand Where ActiveStatus='Active' and DFlag=0 ";
		if(is_array($data)){
			if(array_key_exists("VehicleTypeID",$data)){if($data['VehicleTypeID']!=""){$sql.=" and VehicleTypeID='".$data['VehicleTypeID']."'";}}
			if(array_key_exists("VehicleBrandName",$data)){if($data['VehicleBrandName']!=""){$sql.=" and VehicleBrandName='".$data['VehicleBrandName']."'";}}
		}
		$sql.=" Order By VehicleBrandName asc";
		return DB::SELECT($sql);
	}
	public static function getUserInfo($UserID){
		$generalDB = self::getGeneralDB();

		$userInfo = DB::table('users as U')
			->select('U.ID', 'U.UserID', 'U.ReferID', 'U.LoginType', 'U.RoleID', 'UR.RoleName', 'U.Name', 'U.EMail', 'U.FirstName', 'U.LastName', 'U.DOB', 'U.GenderID', 'G.Gender', 'U.Address', 'U.CityID', 'CI.CityName', 'U.StateID', 'S.StateName', 'U.CountryID', 'CO.CountryName', 'CO.PhoneCode', 'U.PostalCodeID', 'PC.PostalCode', 'U.MobileNumber', 'U.ProfileImage', 'U.ActiveStatus', 'U.DFlag')
			->leftJoin($generalDB . 'tbl_cities AS CI', 'CI.CityID', '=', 'U.CityID')
			->leftJoin($generalDB . 'tbl_countries AS CO', 'CO.CountryID', '=', 'U.CountryID')
			->leftJoin($generalDB . 'tbl_states AS S', 'S.StateID', '=', 'U.StateID')
			->leftJoin($generalDB . 'tbl_postalcodes AS PC', 'PC.PID', '=', 'U.PostalCodeID')
			->leftJoin($generalDB . 'tbl_genders AS G', 'G.GID', '=', 'U.GenderID')
			->leftJoin('tbl_user_roles AS UR', 'UR.RoleID', '=', 'U.RoleID')
			->where('U.UserID', $UserID)
			->first();

		if ($userInfo) {
			// $userInfo->ActiveStatus = intval($userInfo->ActiveStatus) == 1 ? 'Active' : 'Inactive';

			if (!empty($userInfo->ProfileImage) && filter_var($userInfo->ProfileImage, FILTER_VALIDATE_URL)) {
				// Profile image is already a valid URL
			} elseif (empty($userInfo->ProfileImage) || !file_exists($userInfo->ProfileImage)) {
				$userInfo->ProfileImage = strtolower($userInfo->Gender) == "female" ? "assets/images/female-icon.png" : "assets/images/male-icon.png";
			} else {
				$userInfo->ProfileImage = url('/') . "/" . $userInfo->ProfileImage;
			}
			
			return ["status" => true, "data" => $userInfo];
		} else {
			return ["status" => false, "data" => []];
		}
	}

	public static function saveNotification($ReferID,$Title,$Message,$Route,$RouteID){
		$UserID = DB::table('users')->where('ReferID',$ReferID)->value('UserID');
		$NID = DocNum::getDocNum("Notification",self::getCurrFYDB(),self::getCurrentFY());
		$Ndata = [
			'NID'=> $NID,
			'UserID'=> $UserID,
			'ReferID'=> $ReferID,
			'Title'=> $Title,
			'Message'=> $Message,
			'Route'=> $Route,
			'RouteID'=> $RouteID
		];
		$status = DB::table(self::getCurrFYDB().'tbl_notifications')->insert($Ndata);
		if($status){
			DocNum::updateDocNum("Notification",self::getCurrFYDB());
		}
		return $status;
	}

    public static function sendNotification($ReferID,$Title,$Message){
		$UserID = DB::table('users')->where('ReferID',$ReferID)->value('UserID');
        $firebaseToken=array();
        $sql="Select IFNULL(fcmToken,'') as fcmToken,IFNULL(WebFcmToken,'') as WebFcmToken From users where ActiveStatus=1 and DFlag=0 and UserID='".$UserID."'";
        $result = DB::SELECT($sql);
        for($i=0;$i<count($result);$i++){
            if($result[$i]->fcmToken!=""){
                $firebaseToken[]=$result[$i]->fcmToken;    
            }
            if($result[$i]->WebFcmToken!=""){
                $firebaseToken[]=$result[$i]->WebFcmToken;
            }

        }
        if(count($firebaseToken)>0){
           $SERVER_API_KEY = config('app.firebase_server_key');// firebase server key
      
            $data = [
                "registration_ids" => $firebaseToken,
                "notification" => [
                    "title" => $Title,
                    "body" => $Message,  
                ]
            ];
            $dataString = json_encode($data);
            
            $headers = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json',
            ];
        
            $ch = curl_init();
          
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                   
            $response = curl_exec($ch);
            return $response;
        }
    }

	public static function getFYDBInfo($data=null){
		if($data==null){
			$data=['FYDBName' => null,"Year"=>null,"FromYear"=>null,"ToYear"=>null,"isLedgerView"=>false];
        	$data=json_decode(json_encode($data));
		}
        $return=array();$tmp=array();
        if($data->Year!=null && $data->Year!=""){
            $sql="SELECT * FROM tbl_financial_year where (year(Fromdate)='".$data->Year."' OR Year(ToDate)='".$data->Year."')";
            $result=DB::SELECT($sql);
            foreach($result as $item){
                $tmp[]=$item->DBName.".";
            }
		}else if(($data->FromYear!=null && $data->FromYear!="") && ($data->ToYear!=null && $data->ToYear!="")){
            $sql="SELECT * FROM tbl_financial_year where (year(Fromdate)>='".date("Y",strtotime($data->FromYear))."' OR Year(ToDate)<='".date("Y",strtotime($data->ToYear))."')";
            $result=DB::SELECT($sql); 
            foreach($result as $item){
                $tmp[]=$item->DBName.".";
            }
        }else if($data->FYDBName!=null && $data->FYDBName!=""){
            $data->FYDBName=str_replace(".","",$data->FYDBName);
            $sql="SELECT * FROM tbl_financial_year where DBName='".$data->FYDBName."' ";
            $result=DB::SELECT($sql);
            foreach($result as $item){
                $tmp[]=$item->DBName.".";
            }
        }else{
            $tmp[]=self::getCurrentFYDBName();
        }
        foreach($tmp as $item){
            if(self::checkDBExists($item)){   
                $return[]= $item;
            }
        }
        return $return;
    }
	public static function shortenValue($value) {
		$abbreviations = ["", "K", "M", "B", "T"]; // Add more if needed
	
		$abbrevIndex = 0;
		while ($value >= 1000 && $abbrevIndex < count($abbreviations) - 1) {
			$value /= 1000;
			$abbrevIndex++;
		}
	
		return round($value, 1) . $abbreviations[$abbrevIndex];
	}

}
