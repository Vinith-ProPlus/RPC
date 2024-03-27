<?php
namespace App\enums;
enum activeMenuNames:string{
    case Dashboard="Dashboard";
    case Country="Country";
    case States="States";
    case Districts="Districts";
    case Taluks="Taluks";
    case City="City";
    case PostalCodes="Postal-Codes";
    case Stages="Stages";
    case RejectReason="Reject-Reason";

    case VendorCategory="Vendor-Category";
    case VendorType="Vendor-Type";
    case Vendors="Manage-Vendors";
    case VendorProductMapping="Vendor-Product-Mapping";
    case VendorStockUpdate="Vendor-Stock-Update";

    case Tax="Tax";
    case UOM="Unit-Of-Measurement";
    case ProductCategory="Product-Category";
    case ProductSubCategory="Product-Sub-Category";
    case Brands="Brands";
    case Attributes="Attributes";
    case Products="Products";
    
    case QuoteEnquiry="Quote-Enquiry";
    case Quotation="Quotation";
    case Order="Order";
    case Payments="Payments";
    case Receipts="Receipts";
    case ProductGroupPrice="Product-Group-Price";
    case CustomerGroups="Customer-Groups";
    case ManageCustomers="Manage-Customers";
    case Supplier="Manage-Suppliers";
    case PaymentRequest="Payment-Request";
    
    case UserRoles="User-and-Roles";
    case Users="Users";
    case Profile="Profile";
    case PasswordChange="Change-Password";

    case Company="Company-Settings";
    case SupportTickets="Support-Tickets";

}