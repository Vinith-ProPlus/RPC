<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class tableConfigController extends Controller{
	public function slug($text){
		$divider = '-';
		// replace non letter or digits by divider
		$text = preg_replace('~[^\pL\d]+~u', $divider, $text);
		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);
		// trim
		$text = trim($text, $divider);
		// remove duplicate divider
		$text = preg_replace('~-+~', $divider, $text);
		// lowercase
		$text = strtolower($text);
		if (empty($text)) {return 'n-a';}
		return $text;
	}
    private function getPath($tableName,$UserID,$Module){
        $tableName=$this->slug($tableName);
        $UserID=$this->slug($UserID);
        $Module=$this->slug($Module);

        $storagePath = storage_path()."/datatable/".$UserID."/".$Module;
        if(!file_exists($storagePath)){
            mkdir($storagePath,0777,true);
        }
        
        $path=$storagePath."/".$tableName.".json";
        return $path;
    }
    private function getDefaultPath($tableName,$Module){
        $tableName=$this->slug($tableName);
        $Module=$this->slug($Module);

        $storagePath = storage_path()."/datatable/default/".$Module;
        if(!file_exists($storagePath)){
            mkdir($storagePath,0777,true);
        }
        
        $path=$storagePath."/".$tableName.".json";
        return $path;
    }
    public function getTableConfig(Request $req,$UserID,$Module){
        try {
            $file=$this->getPath($req->tableName,$UserID,$Module);
            $defaultFile=$this->getDefaultPath($req->tableName,$Module);
            if(file_exists($file)){
                $result=file_get_contents($file);
                $result=json_decode($result,true);
                return ["status"=>true,"config"=>$result];
            }elseif(file_exists($defaultFile)){
                $result=file_get_contents($defaultFile);
                $result=json_decode($result,true);
                return ["status"=>true,"config"=>$result];
            }else{
                return ["status"=>false,"config"=>[]];    
            }
            
        } catch (\Exception $e) {
            return ["status"=>false,"config"=>[],"error"=>$e];
        }
    }
    public function saveTableConfig(Request $req,$UserID,$Module){
        try {
            $file=$this->getPath($req->tableName,$UserID,$Module);
            file_put_contents($file, $req->config);
            return ["status"=>true];
        } catch (\Exception $e) {
            return ["status"=>false];
        }
    }
}
