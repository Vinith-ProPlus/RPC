<?php
namespace App\helper;

use DB;
use Helper;
class Ledgers{
    public static function getLedger($data=[]){
        $data=array_merge(['FYDBName' => null,"Year"=>null,"FromYear"=>null,"ToYear"=>null,"isLedgerView"=>false], $data);
        $data=json_decode(json_encode($data));

        $FYDBName=helper::getFYDBInfo($data);
        $tmpDB=Helper::getTmpDB();
        $tmpDBName=Helper::getTmpDB();
        $TableName=self::getTableName($tmpDBName);
        //dd($FYDBName);
        foreach($FYDBName as $DBName){
            self::Insert($DBName,$tmpDBName,$TableName);
        }
        
        $data=array("DBName"=>$tmpDBName,"TableName"=>$TableName);
        return  json_decode(json_encode($data));
    }
    private static function Insert($FYDBName,$tmpDBName,$TableName){
        //Customer Orders
        $sql="Insert Into ".$tmpDBName.$TableName."(PaymentType,TranNo,TranDate,LedgerID,Debit,Credit,LedgerType,Description)";
        $sql.="SELECT 'Order',OrderID,OrderDate,CustomerID,NetAmount as Debit,0 as Credit,'Customer' as LedgerType,CONCAT('Order #', OrderID, '.') AS Description FROM ".$FYDBName."tbl_order  Where Status<>'Cancelled' Order By OrderDate";
        DB::Insert($sql); 
        
        //Vendor Orders
        $sql="Insert Into ".$tmpDBName.$TableName."(PaymentType,TranNo,TranDate,LedgerID,Debit,Credit,LedgerType,Description)";
        $sql.="SELECT 'Order',VOrderID,OrderDate,VendorID,0 as Debit,NetAmount as Credit,'Vendor' as LedgerType,CONCAT('Order #', VOrderID, '.') AS Description FROM ".$FYDBName."tbl_vendor_orders  Where Status<>'Cancelled'  Order By OrderDate";
        DB::Insert($sql);
        
        //Payments
        $sql="Insert Into ".$tmpDBName.$TableName."(PaymentType,TranNo,TranDate,LedgerID,Debit,Credit,LedgerType,Description)";
        $sql.="SELECT  PaymentType,TranNo,TranDate,LedgerID,TotalAmount as Debit,0 as Credit,'Vendor' as LedgerType,CONCAT('Payment Paid to  Vendor #', TranNo, '.') AS Description FROM ".$FYDBName."tbl_payments  Order By TranDate";
        DB::Insert($sql);
        
        //Receipts
        $sql="Insert Into ".$tmpDBName.$TableName."(PaymentType,TranNo,TranDate,LedgerID,Debit,Credit,LedgerType,Description)";
        $sql.="SELECT PaymentType,TranNo,TranDate,LedgerID,0 as Debit,TotalAmount as Credit,'Customer' as LedgerType,CONCAT('Payment received from  Customer',' (Receipt  ID #', TranNo, ').') as Description FROM ".$FYDBName."tbl_receipts  Order By TranDate";
        DB::Insert($sql);
    }
    public static function getTableName($tmpDBName){
        $rndStr=Helper::RandomString(5);
        $TableName="tbl_outstanding_".date("YmdHis")."_".$rndStr;
        $sql="Create Table ".$tmpDBName.$TableName."(SLNo int(11) Primary Key AUTO_INCREMENT,PaymentType enum('Advance','Order'), TranNo VarChar(50),TranDate Date,LedgerType VarChar(50),LedgerID VarChar(50),description text,Debit Double Default 0,Credit Double Default 0)";
        $status=DB::Statement($sql);
        if($status){
            self::tmpTableLog($tmpDBName,$TableName);
            return $TableName;
        }
        return "";
    }
    
    private static function tmpTableLog($tmpDBName,$TableName){
        if(Helper::checkTableExists($tmpDBName,"tbl_tmp_table_log")==false){
            $sql="Create Table ".$tmpDBName."tbl_tmp_table_log(TranDate Date,TableName VarChar(150))";
            DB::statement($sql);
        }
        DB::Table($tmpDBName."tbl_tmp_table_log")->insert(array("TranDate"=>date("Y-m-d"),"TableName"=>$TableName));
        $sql="Select * From ".$tmpDBName."tbl_tmp_table_log Where TranDate<'".date("Y-m-d")."'";
        $result=DB::SELECT($sql);
        foreach($result as $index=>$row){
            self::dropTable($row->TableName,$tmpDBName);
        }
    }

    public static function dropTable($TableName,$tmpDBName=""){
        $tmpDBName=$tmpDBName==""?Helper::getTmpDB():$tmpDBName;
        $isDelete=true;
        if(Helper::checkTableExists($tmpDBName,$TableName)==true){
            $sql="Drop Table ".$tmpDBName.$TableName;
            $isDelete= DB::statement($sql);
        }
        if($isDelete){
            DB::Table($tmpDBName."tbl_tmp_table_log")->where('TableName',$TableName)->delete();
        }
    }
}

