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
    case ConstructionType="Construction-Type";

    case VendorCategory="Vendor-Category";
    case VendorType="Vendor-Type";
    case ManageVendors="Manage-Vendors";
    case Vendors="Vendors";
    case VendorProductMapping="Vendor-Product-Mapping";
    case VendorStockUpdate="Vendor-Stock-Update";
    case StockPoints="Stock-Points";

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
    case Supplier="Manage-Suppliers";
    case PaymentRequest="Payment-Request";

    case rptLedger="Ledger";
    case rptOutstandings="Outstandings";
    case rptPerformanceAnalysis="Performance-Analysis";
    case rptOrdersDue="Orders-Due-Report";
    case rptDeliveryStatus="Delivery-Status-Report";
    case rptCommision="Commision-Report";

    case UserRoles="User-and-Roles";
    case Users="Users";
    case Profile="Profile";
    case ManageCustomers="Manage-Customers";
    case UnregisteredUsers="Unregistered-Users";
    case PasswordChange="Change-Password";
    case PlanningServices="Planning-Services";
    case ConstructionServicePlan="Construction-Service-Plan";

    case Company="Company-Settings";
    case SupportTickets="Support-Tickets";
    case ChatSuggestions="Chat-Suggestions";

}
