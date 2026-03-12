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
        $sql="Insert Into ".$tmpDBName.$TableName."(PaymentType,TranNo,TranDate,LedgerID,Debit,Credit,LedgerType,Description,CreatedOn)";
        $sql.="SELECT 'Order',OrderID,OrderDate,CustomerID,NetAmount as Debit,0 as Credit,'Customer' as LedgerType,CONCAT('Order #', OrderID, '.') AS Description,CreatedOn FROM ".$FYDBName."tbl_order  Where Status<>'Cancelled' Order By OrderDate";
        DB::Insert($sql); 
        
        //Vendor Orders
        $sql="Insert Into ".$tmpDBName.$TableName."(PaymentType,TranNo,TranDate,LedgerID,Debit,Credit,LedgerType,Description,CreatedOn)";
        $sql.="SELECT 'Order',VOrderID,OrderDate,VendorID,0 as Debit,NetAmount as Credit,'Vendor' as LedgerType,CONCAT('Order #', VOrderID, '.') AS Description,CreatedOn FROM ".$FYDBName."tbl_vendor_orders  Where Status<>'Cancelled'  Order By OrderDate";
        DB::Insert($sql);
        
        //Payments
        $sql="Insert Into ".$tmpDBName.$TableName."(PaymentType,TranNo,TranDate,LedgerID,Debit,Credit,LedgerType,Description,CreatedOn)";
        $sql.="SELECT  PaymentType,TranNo,TranDate,LedgerID,TotalAmount as Debit,0 as Credit,'Vendor' as LedgerType,CONCAT(CONCAT(CASE WHEN PaymentType='Advance' THEN  'Advance ' ELSE '' END , 'Payment Paid '),' (Payment  ID #', TranNo, ').') AS Description,CreatedOn FROM ".$FYDBName."tbl_payments  Order By TranDate";
        DB::Insert($sql);
        
        //Receipts
        $sql="Insert Into ".$tmpDBName.$TableName."(PaymentType,TranNo,TranDate,LedgerID,Debit,Credit,LedgerType,Description,CreatedOn)";
        $sql.="SELECT PaymentType,TranNo,TranDate,LedgerID,0 as Debit,TotalAmount as Credit,'Customer' as LedgerType,CONCAT(CONCAT(CASE WHEN PaymentType='Advance' THEN  'Advance ' ELSE '' END , 'Payment received '),' (Receipt  ID #', TranNo, ').') as Description,CreatedOn FROM ".$FYDBName."tbl_receipts  Order By TranDate";
        DB::Insert($sql);

        $sql="Insert Into ".$tmpDBName.$TableName."(PaymentType,TranNo,TranDate,LedgerID,Debit,Credit,LedgerType,Description,CreatedOn)";
        $sql.="SELECT 'Advance' as PaymentType,TranNo,Date(CreatedOn),LedgerID, ";
        $sql.="CASE WHEN TranType='Receipts' THEN Amount ELSE 0 END as Debit, ";
        $sql.="CASE WHEN TranType='Payments' THEN Amount ELSE 0 END as Credit,  ";
        $sql.="CASE WHEN TranType='Receipts' THEN 'Customer' WHEN TranType='Payments' THEN 'Vendor' END AS LedgerType,  ";
        $sql.="CASE WHEN TranType='Receipts' THEN  CONCAT('Advance amount Rs.',Amount,' Used to Receipt (Receipt ID #',PaymentID,')') WHEN TranType='Payments' THEN CONCAT('Advance amount Rs.',Amount,' Used to Payments (Payment ID #',PaymentID,')') END  as Description, ";
        $sql.="CreatedOn FROM ".$FYDBName."tbl_advance_amount_log ";
        DB::Insert($sql);
    }
    public static function getTableName($tmpDBName){
        $rndStr=Helper::RandomString(5);
        $TableName="tbl_outstanding_".date("YmdHis")."_".$rndStr;//TEMPORARY
        $sql="CREATE TEMPORARY TABLE IF NOT EXISTS  ".$tmpDBName.$TableName."(SLNo int(11) Primary Key AUTO_INCREMENT,PaymentType enum('Advance','Order'), TranNo VarChar(50),TranDate Date,LedgerType VarChar(50),LedgerID VarChar(50),description text,Debit Double Default 0,Credit Double Default 0,CreatedOn timestamp)";
        $status=DB::Statement($sql);
        return $TableName;
        /*
        if($status){
            self::tmpTableLog($tmpDBName,$TableName);
            return $TableName;
        }
        return "";*/
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

