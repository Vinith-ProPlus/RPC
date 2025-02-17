<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use docTypes;
use Helper;
class DocNum extends Model{
    public static function getDocNum($DocType,$DBName="",$FY=null){
        $FY = $FY === null ? date('Y') : $FY;
        $result = DB::Select("SELECT SLNO,DocType,Prefix,Length,CurrNum,IFNULL(Suffix,'') as Suffix,IFNULL(Year,'') as Year FROM ".$DBName."tbl_docnum Where DocType='".$DocType."'");
        if(count($result)>0){
            $DocNum=$result[0];
            if(!empty($DocNum->Year) && (int)$DocNum->Year !== (int)date("Y")){
                DB::table($DBName.'tbl_docnum')->where('DocType', $DocType)->update(array("Year"=>date("Y")));
                return self::getDocNum($DocType,$DBName,$FY);
            }
            $return=$DocNum->Prefix.$FY."-".str_pad($DocNum->CurrNum, $DocNum->Length, '0', STR_PAD_LEFT);
            if(self::checkDocNum($DocType, $return, $DBName)){
                self::updateDocNum($DocType,$DBName);
                return self::getDocNum($DocType,$DBName);
            }
            return $return;
        }
        return '';
    }
    public static function updateDocNum($DocType,$DBName=""){
		$sql="Update ".$DBName."tbl_docnum SET CurrNum=CurrNum+1 WHERE DocType='".$DocType."'";
		$result=DB::statement($sql);
    }
    public static function checkDocNum($DocType,$DocNum,$DBName=""){
        if($DocType==docTypes::UserRoles->value){
			$t=DB::Table($DBName.'tbl_user_roles')->where('RoleID',$DocNum)->get();
			return count($t)>0?true:false;
        }elseif($DocType==docTypes::Users->value){
			$t=DB::Table($DBName.'users')->where('UserID',$DocNum)->get();
			return count($t)>0?true:false;
        }elseif($DocType==docTypes::Log->value){
			$logTable=Helper::getLogTableName();
			$t=DB::Table($DBName.$logTable)->where('LogID',$DocNum)->get();
			return count($t)>0?true:false;
        }elseif($DocType==docTypes::Product->value){
			$t=DB::Table($DBName.'tbl_products')->where('ProductID',$DocNum)->get();
			return count($t)>0?true:false;
        }elseif($DocType==docTypes::ProductAttributes->value){
			$t=DB::Table($DBName.'tbl_products_attributes')->where('DetailID',$DocNum)->get();
			return count($t)>0?true:false;
        }elseif($DocType==docTypes::ProductStages->value){
			$t=DB::Table($DBName.'tbl_products_stages')->where('DetailID',$DocNum)->get();
			return count($t)>0?true:false;
        }elseif($DocType==docTypes::ProductGallery->value){
			$t=DB::Table($DBName.'tbl_products_gallery')->where('SLNo',$DocNum)->get();
			return count($t)>0?true:false;
        }elseif($DocType==docTypes::VendorServiceLocation->value){
			$t=DB::Table($DBName.'tbl_vendors_service_locations')->where('DetailID',$DocNum)->get();
			return count($t)>0?true:false;
        }elseif($DocType==docTypes::RejectReason->value){
			$t=DB::Table($DBName.'tbl_reject_reason')->where('RReasonID',$DocNum)->get();
			return count($t)>0?true:false;
        }elseif($DocType==docTypes::RejectReason->value){
			$t=DB::Table($DBName.'tbl_reject_reason')->where('RReasonID',$DocNum)->get();
			return count($t)>0?true:false;
        }elseif($DocType==docTypes::ConstructionType->value){
			$t=DB::Table($DBName.'tbl_construction_type')->where('ConTypeID',$DocNum)->get();
			return count($t)>0?true:false;
        }elseif($DocType==docTypes::VendorCategory->value){
			$t=DB::Table($DBName.'tbl_vendor_category')->where('VCID',$DocNum)->get();
			return count($t)>0?true:false;
        }elseif($DocType==docTypes::VendorType->value){
			$t=DB::Table($DBName.'tbl_vendor_type')->where('VendorTypeID',$DocNum)->get();
			return count($t)>0?true:false;
        }elseif($DocType==docTypes::Vendor->value){
			$t=DB::Table($DBName.'tbl_vendors')->where('VendorID',$DocNum)->get();
			return count($t)>0?true:false;
        }elseif($DocType==docTypes::VendorVehicle->value){
			$t=DB::Table($DBName.'tbl_vendors_vehicle')->where('VehicleID',$DocNum)->get();
			return count($t)>0?true:false;
        }elseif($DocType==docTypes::VendorVehicleImages->value){
			$t=DB::Table($DBName.'tbl_vendors_vehicle_images')->where('SLNO',$DocNum)->get();
			return count($t)>0?true:false;
        }elseif($DocType==docTypes::VendorSupply->value){
			$t=DB::Table($DBName.'tbl_vendors_supply')->where('DetailID',$DocNum)->get();
			return count($t)>0?true:false;
        }elseif($DocType==docTypes::VendorStockPoint->value){
			$t=DB::Table($DBName.'tbl_vendors_stock_point')->where('StockPointID',$DocNum)->get();
			return count($t)>0?true:false;
        }elseif($DocType==docTypes::VendorDocuments->value){
			$t=DB::Table($DBName.'tbl_vendors_document')->where('SLNO',$DocNum)->get();
			return count($t)>0?true:false;
        }elseif($DocType==docTypes::VendorProductMapping->value){
			$t=DB::Table($DBName.'tbl_vendors_product_mapping')->where('DetailID',$DocNum)->get();
			return count($t)>0?true:false;
        }elseif($DocType==docTypes::ProductCategory->value){
			$t=DB::Table($DBName.'tbl_product_category')->where('PCID',$DocNum)->get();
			return count($t)>0?true:false;
        }elseif($DocType==docTypes::ProductSubCategory->value){
			$t=DB::Table($DBName.'tbl_product_subcategory')->where('PSCID',$DocNum)->get();
			return count($t)>0?true:false;
        }elseif($DocType==docTypes::AttributeValues->value){
			$t=DB::Table($DBName.'tbl_attributes_details')->where('ValueID',$DocNum)->get();
			return count($t)>0?true:false;
        }elseif($DocType==docTypes::Attributes->value){
			$t=DB::Table($DBName.'tbl_attributes')->where('AttrID',$DocNum)->get();
			return count($t)>0?true:false;
        }elseif($DocType==docTypes::VendorQuotation->value){
			$t=DB::Table($DBName.'tbl_vendor_quotation')->where('VQuoteID',$DocNum)->get();
			return count($t)>0?true:false;
        }elseif($DocType==docTypes::VendorOrderDetails->value){
			$t=DB::Table($DBName.'tbl_vendor_order_details')->where('DetailID',$DocNum)->get();
			return count($t)>0?true:false;
        }
        return false;
    }
	public static function getInvNo($DocType){
		$InvNo="";
		$ActiveFY=Helper::getActiveFinancialYear();
		if($ActiveFY->FromDate=="" && $ActiveFY->ToDate==""){
			$t=Helper::getCurrentFYDates();
			$ActiveFY->FromDate=date("Y-m-d",strtotime($t->FromDate));
			$ActiveFY->ToDate=date("Y-m-d",strtotime($t->ToDate));
		}
		$FYName=date("y",strtotime($ActiveFY->FromDate)).date("y",strtotime($ActiveFY->ToDate));

		$result=DB::Table(Helper::getcurrfyDB().'tbl_auto_number')->where('DocType',$DocType)->first();
		if($result){
			$InvNo=$result->Prefix."-".$FYName."-".$result->Suffix."-".$result->CurrNum;
		}
		return $InvNo;
	}
	public static function updateInvNo($DocType){
		$sql="Update ".Helper::getcurrfyDB()."tbl_auto_number SET CurrNum=CurrNum+1 WHERE DocType='".$DocType."'";
		$result=DB::statement($sql);
	}
}
