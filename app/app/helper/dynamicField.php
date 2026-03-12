<?php
namespace App\helper;
use DB;
use Helper;
use DocNum;
use Hamcrest\Arrays\IsArray;

class dynamicField{
    private static $AdditionalTableSuffix="_additional";
    private static $AdditionalDocTypeSuffix="-Additional";
    private static $AdditionalSetting="AdditionalSetting";
    private static $UploadDir="uploads/additional/";
    private static $UpdatedOn="UpdatedOn";
    private static $UpdatedBy="UpdatedBy";
    public static function add($DocType,$req,$TableName,$PrimaryKey,$PrimaryKeyValue,$UserID,$DBName=""){
        self::$UploadDir.=date("Ymd")."/";
        self::createAddionalTable($TableName,$DBName);
        self::addDocNum($DocType);

        self::CreateAdditionalColumns($DBName,$TableName,self::$UpdatedOn,'Timestamp');
        self::CreateAdditionalColumns($DBName,$TableName,self::$UpdatedBy,"VarChar(50)");
        
        self::CreateAdditionalColumns($DBName,$TableName,self::$AdditionalSetting,'text');

        $Data=json_decode($req->AData);
        $AData=self::uploadfile($TableName,$Data,$req);
        return self::save($AData,$TableName,$PrimaryKey,$PrimaryKeyValue,$UserID,$DocType,$DBName);
    }
    private static function createAddionalTable($TableName,$DBName){
        $TableName=$TableName.self::$AdditionalTableSuffix;
        if(Helper::checkTableExists($DBName,$TableName)==false){
            $sql="Create Table ".$TableName."(SLNO VarChar(50) Primary Key,ReferenceNo VarChar(100),ColumnName VarChar(200),ColumnValue Text,ColumnType VarChar(50),CreatedOn Timestamp default CURRENT_TIMESTAMP,CreatedBy VarChar(50),UpdatedOn Timestamp null Default Null,UpdatedBy VarChar(50))";
            DB::Statement($sql);
        }
    }
    private static function CreateAdditionalColumns($DBName,$TableName,$Col,$ColType){
        $sql="SHOW COLUMNS FROM ".$DBName.$TableName." LIKE '".$Col."'";
        $result=DB::SELECT($sql);
        if(count($result)<=0){
            $sql="ALTER TABLE ".$DBName.$TableName." ADD ".$Col." ".$ColType." Null default null;";
            DB::STATEMENT($sql);
        }
    }
    private static function addDocNum($DocType){
        $Prefix="";
        $result=DB::Table('tbl_docnum')->where('DocType',$DocType)->get();
        if(count($result)>0){
            $Prefix=$result[0]->Prefix."A";
        }
        $DocType1=$DocType.self::$AdditionalDocTypeSuffix;
        $result=DB::Table('tbl_docnum')->where('DocType',$DocType1)->get();
        if(count($result)<=0){
            $tdata=array(
                "DocType"=>$DocType1,
                "Prefix"=>$Prefix,
                "Length"=>10,
                "CurrNum"=>1,
                "Suffix"=>"",
                "Year"=>date("Y")
            );
            DB::Table('tbl_docnum')->insert($tdata);
        }
    }
    
    private static function uploadfile($TableName,$AData,$req){
        self::createDir();
        if(isset($AData->inputs)){
            for($i=0;$i<count($AData->inputs);$i++){
                if($AData->inputs[$i]->type=="file"){
                    if($req->hasFile($AData->inputs[$i]->id)){
                        $file=$req->file($AData->inputs[$i]->id);
                        $fileName =self::$UploadDir. md5($AData->inputs[$i]->name . time()) . "." . $file->getClientOriginalExtension();
                        $file->move(self::$UploadDir, $fileName);
                        $AData->inputs[$i]->value=$fileName;
                        $AData->data[$i]->value=$fileName;
                    }
                }
            }
        }
        return $AData;
    }    
    private static function createDir(){
		if (!file_exists( self::$UploadDir)) {mkdir( self::$UploadDir, 0777, true);}
    }
    private static function save($AData,$TableName,$PrimaryKey,$ReferenceNo,$UserID,$DocType,$DBName=""){
        $DocType1=$DocType.self::$AdditionalDocTypeSuffix;
        $status=true;
        $TableName1=$TableName.self::$AdditionalTableSuffix;
        $Names=array();
        if(Helper::checkTableExists($DBName,$TableName)==true){
            if(is_array($AData) && count($AData)>0){
                foreach($AData->data as $index=>$data){
                    if($status){
                        $Names[]=$data->name;
                        $t=DB::Table($DBName.$TableName1)->where('ReferenceNo',$ReferenceNo)->where('ColumnName',$data->name)->get();
                        if(count($t)>0){
                            $tdata=array(
                                "ColumnValue"=>$data->value,
                                "ColumnType"=>$data->type,
                                "UpdatedOn"=>date("Y-m-d H:i:s"),
                                "UpdatedBy"=>$UserID
                            );
                            $status=DB::Table($DBName.$TableName1)->where('SLNO',$t[0]->SLNO)->update($tdata);
                        }else{
                            $SLNO=DocNum::getDocNum($DocType1);
                            $tdata=array(
                                "SLNO"=>$SLNO,
                                "ReferenceNo"=>$ReferenceNo,
                                "ColumnName"=>$data->name,
                                "ColumnValue"=>$data->value,
                                "ColumnType"=>$data->type,
                                "CreatedOn"=>date("Y-m-d H:i:s"),
                                "CreatedBy"=>$UserID
                            );
                            $status=DB::Table($DBName.$TableName1)->insert($tdata);
                            if($status){
                                DocNum::updateDocNum($DocType1);
                            }
                        }
                    }
                }
                if($status){
                    $sql="Select * From ".$DBName.$TableName1." Where ColumnName not in('".implode("','",$Names)."')";
                    $result=DB::SELECT($sql);
                    if(count($result)>0){
                        foreach($result as $index=>$tmp){
                            if($tmp->ColumnType=="file" && file_exists($tmp->ColumnValue)){
                                unlink($tmp->ColumnValue);
                            }
                            DB::Table($DBName.$TableName1)->where('SLNO',$tmp->SLNO)->delete();
                        }
                    }
                }
                if($status){
                    $tdata=array(
                        self::$AdditionalSetting=>serialize($AData),
                        self::$UpdatedOn=>date("Y-m-d H:i:s", strtotime("+2 minutes")),
                        self::$UpdatedBy=>$UserID
                    );
                    $status=DB::Table($TableName)->where($PrimaryKey,$ReferenceNo)->update($tdata);
                }
            }
        }else{
            $status= false;
        }
        return $status;
    }
}