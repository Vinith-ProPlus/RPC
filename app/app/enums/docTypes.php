<?php
namespace App\enums;

enum docTypes:string{
    case Country="Country";
    case States="States";
    case Districts="Districts";
    case Taluks="Taluks";
    case City="City";
    case PostalCodes="Postal-Codes";
    case Gender="Gender";
    case Bank="Banks";
    case BankType="Bank-Type";
    case BankAccountType="Bank-Account-Type";
    case BankBranch="Bank-Branches";
    case Stages="Stages";
    case RejectReason="Reject-Reason";

    case Departments="Departments";
    case VendorCategory="Vendor-Category";
    case VendorType="Vendor-Type";
    case Vendor="Vendor";
    case VendorVehicle="Vendor-Vehicle";
    case VendorVehicleImages="Vendor-Vehicle-Images";
    case VendorSupply="Vendor-Supply";
    case VendorStockPoint="Vendor-Stock-Point";
    case VendorDocuments="Vendor-Documents";
    case VendorServiceLocation="Vendor-Service-Location";
    case VendorProductMapping="Vendor-Product-Mapping";
    case VendorStockUpdate="Vendor-Stock-Update";

    case Tax="Tax";
    case UOM="UoM";
    case ProductCategory="Product-Category";
    case ProductSubCategory="Product-Sub-Category";
    case Brands="Brands";
    case Attributes="Attributes";
    case AttributeValues="Attribute-Values";
    case AttributeValueCategory="Attribute-Value-Category";
    
    case Product="Products";
    case ProductAttributes="Product-Attributes";
    case ProductStages="Product-Stages";
    case ProductGallery="Product-Gallery";
    case ProductVariation="Product-Variation";
    case ProductVariationDetails="Product-Variation-Details";
    case ProductVariationGallery="Product-Variation-Gallery";
    
    case VehicleType="Vehicle-Type";
    case VehicleBrand="Vehicle-Brand";
    case VehicleModel="Vehicle-Model";

    case Enquiry="Enquiry";
    case EnquiryDetails="Enquiry-Details";
    case Quotation="Quotation";
    case QuotationDetails="Quotation-Details";
    case VendorQuotation="Vendor-Quotation";
    case VendorQuotationDetails="Vendor-Quotation-Details";
    case Order="Order";
    case OrderDetails="Order-Details";
    case Payments="Payments";
    case PaymentsDetails="Payment-Details";

    case UserRoles="User-Roles";
    case Users="Users";
    case Log="Log";
    case Customer="Customer";
    case CustomerAddress="Customer-Address";
    case LeadSource="Lead-Source";
    case Charges="Charges";
    
    case Support="Support";
    case SupportDetails="Support-Details";
    case SupportAttachments="Support-Attachments";
    
    case Withdraw="Withdraw";

}