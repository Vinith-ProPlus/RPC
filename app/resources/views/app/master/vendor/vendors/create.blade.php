@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@icon/dashicons@0.9.0-alpha.4/dashicons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.css">
<style>
    .body{
        background:#f0f0f1;
    }
    #StockPointAccordion {
        --bs-accordion-btn-color: #e8ebf2 ;
        --bs-accordion-btn-bg: #0288d1;
        --bs-accordion-active-color: #0288d1;
        --bs-accordion-active-bg: #e8ebf2 ;
    }
    .registration .custom input,.custom select,.custom textarea{
        border-radius:0px !important;
    }
    .registration .card{
        border-radius:0px !important;
        position: relative;
        border: 1px solid #c3c4c7;
        background: #fff;
    }
    .card{
        box-shadow: 0 1px 1px rgba(0,0,0,.04);
    }
    .registration .card .card-header{
        font-size: 14px;
        padding: 8px 10px;
        margin: 0;
        line-height: 1.4;
        position: relative;
        border-bottom: 1px solid #c3c4c7;
    }
    .card .card-header .options{
        position: absolute;
        right: 10px;
        top: 0px;
        display: flex;
        height: 100%;
        align-items: center;
        margin: 0px;
        font-size: 17px;
    }
    .card .card-header .options span{
        cursor: pointer;
    }
    .card .card-header .options span.trash:hover{
        color:var(--bs-danger);
    }
    .card .card-header .options span.add:hover{
        color:var(--bs-success);
    }
    .registration .card .card-body{
        padding:5px;
        overflow:hidden;
    }
    .registration .card .card-header h3{
        font-size: 14px;
        margin: 0;
        line-height: 1.4;
    }
    .woo-commerce-style > ul::after{
        content: "";
        display: block;
        width: 100%;
        height: 9999em;
        position: absolute;
        bottom: -9999em;
        left: 0;
        background-color: #fafafa;
        border-right: 1px solid #eee;
    }
    .woo-commerce-style ul.woo-commerce-style{
        margin: 0;
        width: 20%;
        float: left;
        line-height: 1em;
        padding: 0 0 10px;
        position: relative;
        background-color: #fafafa;
        border-right: 1px solid #eee;
        box-sizing: border-box;
    }

    .woo-commerce-style ul.woo-commerce-style li{
        margin: 0;
        padding: 0;
        display: block;
        position: relative;
    }
    .woo-commerce-style ul.woo-commerce-style li a{
        margin: 0;
        padding: 10px;
        display: block;
        box-shadow: none;
        text-decoration: none;
        line-height: 20px!important;
        border-bottom: 1px solid #eee;
        color:#2271b1;
        display: flex;
    align-items: center;
    }
    .woo-commerce-style ul.woo-commerce-style li a:before{
        font-family:"dashicons";
        speak: never;
        font-weight: 400;
        font-variant: normal;
        text-transform: none;
        line-height: 1;
        -webkit-font-smoothing: antialiased;
        content: "\eacc";
        text-decoration: none;
    }
    .woo-commerce-style ul.woo-commerce-style li.general_options a:before{
        content: "\eacc";
    }
    .woo-commerce-style ul.woo-commerce-style li.short_description_options a:before{
        content: "\eb31";
    }
    .woo-commerce-style ul.woo-commerce-style li.description_options a:before{
        content: "\eb31";
    }
    .woo-commerce-style ul.woo-commerce-style li.attribute_options a:before{
        content: "\eaa6";
    }
    .woo-commerce-style ul.woo-commerce-style li.variation_options a:before{
        content: "\eab8";
    }
    .woo-commerce-style ul.woo-commerce-style  li.active a{
        color: #555;
        position: relative;
        background-color: #eee;
    }
    .woo-commerce-style ul.woo-commerce-style  li a span{
        margin-left: 0.618em;
        margin-right: 0.618em;
    }
    .woo-commerce-style .tab-contents{
        float: left;
        width: 80%;
        display:none;
        padding:10px 20px 30px 20px;
        background:#fff;
    }
    .woo-commerce-style .tab-contents.active{
        display:block;
    }
    .woo-commerce-style #variations-tab[data-status="1"] #btnGenerateVariations{
        display:block;
    }
    .woo-commerce-style #variations-tab[data-status="0"] #btnGenerateVariations,
    .woo-commerce-style #variations-tab[data-status="1"] .no-attributes-found{
        display:none;
    }
    .woo-commerce-style #variations-tab[data-status="0"] .no-attributes-found{
        display:flex;
    }
    .vehicle_images_container{
        padding: 0 0 0 9px;
        position: relative;
    }
    .vehicle_images_container.main_product{
        min-height:250px;
    }
    .vehicle_images_container ul.vehicle_images{
        display:none;
    }
    .vehicle_images_container ul.vehicle_images:has(li){
        display:block;
    }
    .vehicle_images_container .no-gallery-images{
        display:flex;
        width:100%;
        height:250px;
        min-height:250px;
    }
    .vehicle_images_container ul.vehicle_images:has(li)+ .no-gallery-images{
        display:none;
    }
    .vehicle_images_container ul{
        margin: 0;
        padding: 0;
    }
    .vehicle_images_container ul:before{
        content: " ";
        display: table;
    }
    .vehicle_images_container ul li.image{
        width: 80px;
        height:80px;
        float: left;
        cursor: move;
        border: 1px solid #d5d5d5;
        margin: 9px 9px 0 0;
        background: #f7f7f7;
        border-radius: 2px;
        position: relative;
        box-sizing: border-box;
        display:flex;
        align-items:center;
        background:#fff;
        overflow: hidden;
    }
    .vehicle_images_container ul li.image img{
        width: 100%;
        height: auto;
        display: block;
    }
    .vehicle_images_container ul .actions {
        position: absolute;
        top:0;
        left:0;
        width:100%;
        height:100%;
        display:none;
        align-items:center;
        justify-content:center;
        background:rgba(255,255,255,1)

    }
    .vehicle_images_container ul li:hover .actions {
        display:flex;
    }
    .vehicle_images_container ul li:hover .actions li{
        margin:0px 2px;
    }
    .vehicle_images_container ul li:hover .actions li a{
        background: #999;
        /* width: 40px; */
        /* height: 40px; */
        font-size: 11px;
        padding: 1px 3px 3px;
        border-radius: 3px;
        color: #fff;
    }
    .vehicle_images_container ul li:hover .actions li a:hover{
        background:#a00;
    }
    .form-group label {
        margin-bottom:2px;
    }
    .input-group .select2{
        width:75% !important;
        max-width:75% !important;
    }
    ..dropify-wrapper{
        height:auto !important;
    }
    .registration .accordion-item,
    .accordion-item:first-child,
    .accordion-item:last-child
    {
        border-left:0px;
        border-right:0px;
        border-radius:0px;
    }
    .registration .accordion-button{
        font-weight:700;
    }
    .registration .accordion-button:not(.collapsed){
        color: var(--bs-accordion-btn-color);
        background-color: var(--bs-accordion-btn-bg);
    }

    .accordion-item .accordion-header .options{
        position: absolute;
        right: 60px;
        top: 0px;
        display: flex;
        height: 100%;
        align-items: center;
        color: #8392a5;
        margin: 0px;
        font-size: 17px;
    }
    .accordion-item .accordion-header .options span{
        cursor: pointer;
    }
    .accordion-item .accordion-header .options span.trash:hover{
        color:var(--bs-danger);
    }
    .registration .accordion-button{
        box-shadow: inset 0 calc(-1 * var(--bs-accordion-border-width)) 0 var(--bs-accordion-border-color);
    }
    .registration .accordion-button:focus{
        box-shadow: inset 0 calc(-1 * var(--bs-accordion-border-width)) 0 var(--bs-accordion-border-color);
    }
    /*
    #btnGenerateVariations span{
        display: none;
    }
    #btnGenerateVariations[data-status="0"] span.generate-variation {
        display: block;
    }

    #btnGenerateVariations[data-status="1"] span.regenerate-variation {
        display: block;
    }*/
    #btnGenerateVariations[data-status="0"]::after {
        content: "Generate Variations";
    }

    #btnGenerateVariations[data-status="1"]::after {
        content: "Regenerate Variations";
    }
    #variations-tab .no-attributes-found{
        min-height:250px;
        width:100%;
        display:flex;
        align-items:center;
        justify-content:center;
        text-align:center;
    }
    #attributes-tab .no-sub-category-found{
        min-height:250px;
        width:100%;
        display:flex;
        align-items:center;
        justify-content:center;
        text-align:center;
    }

    .woo-commerce-style #attributes-tab[data-status="1"] .product-attributes{
        display:flex;
    }
    .woo-commerce-style #attributes-tab[data-status="0"] .product-attributes,
    .woo-commerce-style #attributes-tab[data-status="1"] .no-sub-category-found{
        display:none;
    }
    .woo-commerce-style #attributes-tab[data-status="0"] .no-sub-category-found{
        display:flex;
    }
</style>
<div class="container-fluid d-block d-sm-none">
    <div class="row">
        <div class="col-12 text-center fw-700 fs-16 mt-30">
            Sorry! screen resolution not supported
        </div>
    </div>
</div>
<div class="container-fluid d-none d-sm-block">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Vendor Master</li>
					<li class="breadcrumb-item"><a href="{{url('/')}}/admin/master/vendor/vendors">{{$PageTitle}}</a></li>
                    <li class="breadcrumb-item">@if($isEdit)Update @else Create @endif</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid d-none d-sm-block pl-20 pr-20 custom">
  <div class="row d-flex justify-content-center">
    <div class="col-12 col-sm-12 col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="stepwizard my-3">
            <div class="stepwizard-row setup-panel">
              <div class="stepwizard-step"><a class="btn-primary btn btn-light" href="#registration"><i class="fa fa-user"></i> Registration</a>
              </div>
              <div class="stepwizard-step"><a class="btn-primary btn" href="#stockPoints"><i class="fa fa-bars"></i> Stock Points</a>
              </div>
              <div class="stepwizard-step"><a class="btn-primary btn" href="#productMapping"><i class="fa fa-product-hunt"></i> Product Mapping</a>
              </div>
              <div class="stepwizard-step"><a class="btn-primary btn" href="#stockUpdate"><i class="fa fa-arrow-right"></i> Stock Update</a>
              </div>
            </div>
          </div>
          <div class="setup-content registration" id="registration" style="">
            <div class="row d-flex justify-content-center">
              <div class="col-12 col-sm-9 col-md-9 col-lg-9 mb-10">
                <input type="text" class="d-none" id="txtVendorID" value="<?php if($isEdit){ echo $data->VendorID;} ?>">
                  <div class="row">
                      <div class="col-12 p-0">
                          <div class="form-group">
                              <label for="txtVendorName">Vendor Name <span class="required"> * </span></label>
                              <input type="text" class="form-control form-control-lg" id="txtVendorName" placeholder="Vendor Name" value="<?php if($isEdit){ echo $data->VendorName;} ?>">
                              <div class="errors err-sm" id="txtVendorName-err"></div>
                          </div>
                      </div>
                  </div>
          
                  <div class="row d-none d-md-flex mt-20">
                      <div class="col-12 p-0">
                          <div class="card">
                              <div class="card-header">
                                  <div class="row">
                                      <div class="col-18 col-sm-8 col-md-6 col-lg-5 col-xl-4 d-flex align-items-center">
                                          <div class=" fw-700 text-nowrap pr-10">Vendor Data </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="card-body p-0 woo-commerce-style">
                                  <ul class="woo-commerce-style">
                                      <li class="general_options active"><a href="#general-tab"><span>General</span></a></li>
                                      <li class="address_options "><a href="#address-tab"><span>Address</span></a></li>
                                      <li class="transport_details_options "><a href="#transport-tab"><span>Transport Details</span></a></li>
                                      <li class="supply_details_options  " ><a href="#supply-details-tab"><span>Supply Details</span></a></li>
                                      <li class="documents_options " ><a href="#vendor-documents-tab"><span>Documents</span></a></li>
                                  </ul>
                                  <div class="tab-contents" id="general-tab">
                                      <div class="row mt-20">
                                          <div class="col-4 col-lg-2 d-flex align-items-center"><div >Company Name <span class="required"> * </span></div></div>
                                          <div class="col-6 col-lg-8">
                                              <input type="text" id="txtCoName" class="form-control" placeholder="Company Name" value="<?php if($isEdit){ echo $data->VendorCoName;} ?>">
                                              <div class="errors err-sm" id="txtCoName-err"></div>
                                          </div>
                                          <div class="col-1 col-lg-2 d-flex align-items-center"></div>
                                      </div>
                                      <div class="row mt-20">
                                          <div class="col-4 col-lg-2 d-flex align-items-center"><div >GST Number {{-- <span class="required"> * </span> --}}</div></div>
                                          <div class="col-6 col-lg-8">
                                              <input type="text" id="txtGSTNo" class="form-control" placeholder="GST Number" value="<?php if($isEdit){ echo $data->GSTNo;} ?>">
                                              <div class="errors err-sm" id="txtGSTNo-err"></div>
                                          </div>
                                          <div class="col-1 col-lg-2 d-flex align-items-center"></div>
                                      </div>
                                      <div class="row mt-20">
                                          <div class="col-4 col-lg-2 d-flex align-items-center"><div >Vendor Category  <span class="required"> * </span></div></div>
                                          <div class="col-6 col-lg-8">
                                              <select class="form-control {{$Theme['input-size']}} select2" id="lstCategory" data-selected="<?php if($isEdit){ echo $data->CID;} ?>">
                                                  <option value="">Select a Category</option>
                                              </select>
                                              <div class="errors err-sm" id="lstCategory-err"></div>
                                          </div>
                                          <div class="col-1 col-lg-2 d-flex align-items-center"></div>
                                      </div>
                                      <div class="row mt-20">
                                          <div class="col-4 col-lg-2 d-flex align-items-center"><div >Vendor Type  <span class="required"> * </span></div></div>
                                          <div class="col-6 col-lg-8">
                                              <select class="form-control {{$Theme['input-size']}} select2" id="lstVendorType"  data-selected="<?php if($isEdit){ echo $data->VendorTypeID;} ?>">
                                                  <option value="">Select a Vendor Type</option>
                                              </select>
                                              <div class="errors err-sm" id="lstVendorType-err"></div>
                                          </div>
                                          <div class="col-1 col-lg-2 d-flex align-items-center"></div>
                                      </div>
                                      <div class="row mt-20">
                                          <div class="col-4 col-lg-2 d-flex align-items-center"><div >E-Mail <span class="required"> * </span></div></div>
                                          <div class="col-6 col-lg-8">
                                              <input type="email" id="txtEmail" class="form-control" placeholder="Email" value="<?php if($isEdit){ echo $data->Email;} ?>">
                                              <div class="errors err-sm" id="txtEmail-err"></div>
                                          </div>
                                          <div class="col-1 col-lg-2 d-flex align-items-center"></div>
                                      </div>
                                      <div class="row mt-20">
                                          <div class="col-4 col-lg-2 d-flex align-items-center"><div >Mobile Number 1 <span class="required"> * </span></div></div>
                                          <div class="col-6 col-lg-8">
                                              <input type="text" id="txtMobileNumber1" class="form-control" placeholder="Mobile Number" value="<?php if($isEdit){ echo $data->MobileNumber1;} ?>">
                                              <div class="errors err-sm" id="txtMobileNumber1-err"></div>
                                          </div>
                                          <div class="col-1 col-lg-2 d-flex align-items-center"></div>
                                      </div>
                                      <div class="row mt-20">
                                          <div class="col-4 col-lg-2 d-flex align-items-center"><div >Mobile Number 2</div></div>
                                          <div class="col-6 col-lg-8">
                                              <input type="text" id="txtMobileNumber2" class="form-control" placeholder="Mobile Number" value="<?php if($isEdit){ echo $data->MobileNumber2;} ?>">
                                              <div class="errors err-sm" id="txtMobileNumber2-err"></div>
                                          </div>
                                          <div class="col-1 col-lg-2 d-flex align-items-center"></div>
                                      </div>
                                      <div class="row mt-20">
                                          <div class="col-4 col-lg-2 d-flex align-items-center"><div >Credit Days <span class="required"> * </span></div></div>
                                          <div class="col-6 col-lg-8">
                                              <div class="input-group">
                                                  <input type="number" id="txtCreditDays" class="form-control" placeholder="Credit Days" value="<?php if($isEdit){ echo $data->CreditDays;} ?>">
                                                  <span class="input-group-text">Days</span>
                                              </div>
      
                                              <div class="errors err-sm" id="txtCreditDays-err"></div>
                                          </div>
                                          <div class="col-1 col-lg-2 d-flex align-items-center"></div>
                                      </div>
                                      <div class="row mt-20">
                                          <div class="col-4 col-lg-2 d-flex align-items-center"><div >Credit Limit <span class="required"> * </span></div></div>
                                          <div class="col-6 col-lg-8">
                                              <input type="number" id="txtCreditLimit" class="form-control" placeholder="Credit Limit" value="<?php if($isEdit){ echo $data->CreditLimit;} ?>">
                                              <div class="errors err-sm" id="txtCreditLimit-err"></div>
                                          </div>
                                          <div class="col-1 col-lg-2 d-flex align-items-center"></div>
                                      </div>
                                      <div class="row mt-20">
                                          <div class="col-4 col-lg-2 d-flex align-items-center"><div >Commission <span class="required"> * </span></div></div>
                                          <div class="col-6 col-lg-8">
                                              <div class="input-group">
                                                  <input type="number" min=0 max=100 step="{{NumberSteps($Settings['percentage-decimals'])}}" id="txtCommissionPercentage" class="form-control" placeholder="Commission Percentage" value="<?php if($isEdit){ echo $data->CommissionPercentage;} ?>">
                                                  <span class="input-group-text"> % </span>
                                              </div>
      
                                              <div class="errors err-sm" id="txtCommissionPercentage-err"></div>
                                          </div>
                                          <div class="col-1 col-lg-2 d-flex align-items-center"></div>
                                      </div>
                                      <div class="row mt-20">
                                          <div class="col-4 col-lg-2 d-flex align-items-center"><div >Status</div></div>
                                          <div class="col-6 col-lg-8">
                                              <select class="form-control" id="lstActiveStatus">
                                                  <option value="Active" @if($isEdit) @if($data->ActiveStatus=="Active") selected @endif @endif>Active</option>
                                                  <option value="Inactive" @if($isEdit) @if($data->ActiveStatus=="Inactive") selected @endif @endif>Inactive</option>
                                              </select>
                                              <div class="errors err-sm" id="lstActiveStatus-err"></div>
                                          </div>
                                          <div class="col-1 col-lg-2 d-flex align-items-center">
                                          </div>
                                      </div>
                                      <div class="row mt-20">
                                          <div class="col-4 col-lg-2 d-flex align-items-center"><div>Reference</div></div>
                                          <div class="col-6 col-lg-8">
                                              <input type="text" id="txtReference" class="form-control" placeholder="Reference" value="<?php if($isEdit){ echo $data->Reference;} ?>">
                                              <div class="errors err-sm" id="txtReference-err"></div>
                                          </div>
                                          <div class="col-1 col-lg-2 d-flex align-items-center"></div>
                                      </div>
                                  </div>
                                  <div class="tab-contents" id="address-tab">
                                      <div class="row mt-20">
                                          <div class="col-4 col-lg-2 d-flex align-items-center"><div >Address <span class="required"> * </span></div></div>
                                          <div class="col-6 col-lg-8">
                                              <textarea  id="txtAddress"  rows="3" class="form-control"><?php if($isEdit){ echo $data->Address;} ?></textarea>
                                              <div class="errors err-sm" id="txtAddress-err"></div>
                                          </div>
                                          <div class="col-1 col-lg-2 d-flex align-items-center"></div>
                                      </div>
                                      <div class="row mt-20">
                                          <div class="col-4 col-lg-2 d-flex align-items-center"><div >Postal Code <span class="required"> * </span></div></div>
                                          <div class="col-6 col-lg-8">
                                              <div class="input-group">
                                                  <input type="text" id="txtPostalCode" class="form-control" placeholder="Postal Code" value="<?php if($isEdit){ echo $data->PostalCode;} ?>">
                                                  <button type="button" class="btn btn-outline-dark" id="btnGSearchPostalCode">Search <i class="fa fa-search"></i></button>
                                              </div>
                                              <div class="errors err-sm" id="txtPostalCode-err"></div>
                                          </div>
                                          <div class="col-1 col-lg-2 d-flex align-items-center"></div>
                                      </div>
                                      <div class="row mt-20">
                                          <div class="col-4 col-lg-2 d-flex align-items-center"><div >City <span class="required"> * </span></div></div>
                                          <div class="col-6 col-lg-8">
                                              <select class="form-control {{$Theme['input-size']}} select2" id="lstCity" data-selected="<?php if($isEdit){ echo $data->CityID;} ?>">
                                                  <option value="">Select a City</option>
                                              </select>
                                              <div class="errors err-sm" id="lstCity-err"></div>
                                          </div>
                                          <div class="col-1 col-lg-2 d-flex align-items-center"></div>
                                      </div>
                                      <div class="row mt-20">
                                          <div class="col-4 col-lg-2 d-flex align-items-center"><div >Taluks <span class="required"> * </span></div></div>
                                          <div class="col-6 col-lg-8">
                                              <select class="form-control {{$Theme['input-size']}} select2" id="lstTaluk" data-selected="<?php if($isEdit){ echo $data->TalukID;} ?>">
                                                  <option value="">Select a Taluk</option>
                                              </select>
                                              <div class="errors err-sm" id="lstTaluk-err"></div>
                                          </div>
                                          <div class="col-1 col-lg-2 d-flex align-items-center"></div>
                                      </div>
                                      <div class="row mt-20">
                                          <div class="col-4 col-lg-2 d-flex align-items-center"><div >Districts <span class="required"> * </span></div></div>
                                          <div class="col-6 col-lg-8">
                                              <select class="form-control {{$Theme['input-size']}} select2" id="lstDistricts" data-selected="<?php if($isEdit){ echo $data->DistrictID;} ?>">
                                                  <option value="">Select a District</option>
                                              </select>
                                              <div class="errors err-sm" id="lstDistricts-err"></div>
                                          </div>
                                          <div class="col-1 col-lg-2 d-flex align-items-center"></div>
                                      </div>
                                      <div class="row mt-20">
                                          <div class="col-4 col-lg-2 d-flex align-items-center"><div >State <span class="required"> * </span></div></div>
                                          <div class="col-6 col-lg-8">
                                              <select class="form-control {{$Theme['input-size']}} select2" id="lstState"  data-selected="<?php if($isEdit){ echo $data->StateID;} ?>">
                                                  <option value="">Select a State</option>
                                              </select>
                                              <div class="errors err-sm" id="lstState-err"></div>
                                          </div>
                                          <div class="col-1 col-lg-2 d-flex align-items-center"></div>
                                      </div>
                                      <div class="row mt-20">
                                          <div class="col-4 col-lg-2 d-flex align-items-center"><div >Country <span class="required"> * </span></div></div>
                                          <div class="col-6 col-lg-8">
                                              <select class="form-control {{$Theme['input-size']}} select2" id="lstCountry" data-category-id="lstCategory" data-selected="<?php if($isEdit){ echo $data->CountryID;} ?>">
                                                  <option value="">Select a Country</option>
                                              </select>
                                              <div class="errors err-sm" id="lstCountry-err"></div>
                                          </div>
                                          <div class="col-1 col-lg-2 d-flex align-items-center"></div>
                                      </div>
                                  </div>
                                  <div class="tab-contents" id="transport-tab">
                                      <div class="row justify-content-center mt-20 ">
                                          <div class="col-12 text-center">
                                              <button id="btnAddVehicle" class="btn btn-sm btn-outline-primary">Add Vehicle</button>
                                          </div>
                                      </div>
                                      <div class="col-12 mh-150">
                                          <div class="accordion accordion-flush" id="vehicleAccordion">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="tab-contents" id="supply-details-tab">
                                      <div class="row mt-20 justify-content-center">
                                          <div class="col-sm-4">
                                              <div class="form-group">
                                                  <label for="lstPCategory">Product Category <span class="required"> * </span></label>
                                                  <select class="form-control  {{$Theme['input-size']}} select2" id="lstPCategory">
                                                      <option value="">Select a Product Category</option>
                                                  </select>
                                                  <div class="errors SupplyDetails err-sm" id="lstPCategory-err"></div>
                                              </div>
                                          </div>
                                          <div class="col-sm-4">
                                              <div class="form-group">
                                                  <label for="lstPSubCategory"> Product Sub Category <span class="required"> * </span></label>
                                                  <select size=1 class="form-control  {{$Theme['input-size']}} select2" id="lstPSubCategory" multiple>
                                                      <option value="">Select a Product Sub Category</option>
                                                  </select>
                                                  <div class="errors SupplyDetails err-sm" id="lstPSubCategory-err"></div>
                                              </div>
                                          </div>
                                          <div class="col-sm-2 d-flex align-items-center justify-content-center">
                                              <button type="button" class="btn btn-sm btn-outline-info btnAddSupply mt-20" data-id="">Add</button>
                                          </div>
                                      </div>
                                      <div class="row mt-20">
                                          <div class="col-sm-12">
                                              <table class="table" id="tblSupplyDetails">
                                                  <thead>
                                                      <tr>
                                                          <th>Product Category</th>
                                                          <th>Product Sub Category</th>
                                                          <th>Action</th>
                                                          <th class="d-none">Data</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody></tbody>
                                              </table>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="tab-contents" id="vendor-documents-tab">
                                      <div class="row mt-15 mb-15" id="divDocuments">
                                      </div>
                                      <div class="row justify-content-center mt-20 ">
                                          <div class="col-12 text-center">
                                              <button id="btnAddDocuments" class="btn btn-sm btn-outline-primary">Add Documents</button>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-12 text-right">
                          <a href="{{url('/')}}/admin/master/vendor/vendors" class="btn btn-outline-dark mr-10">Cancel</a>
                          <button type="button" class="btn btn-outline-success mr-10" id="btnSave">@if($isEdit)Update  @else Save @endif</button>
                      </div>
                  </div>
              </div>
              <div class="col-12 col-sm-3 col-md-3 col-lg-3 pt-22">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header"> <h3>Vendor Logo</h3> </div>
                            <div class="card-body vendor-logo ">
                                <div class="row">
                                    <div class="col-12">
                                        <input type="file" class="dropify"  data-remove="0" data-is-cover-image="1" id="txtVendorLogo" data-default-file="<?php if($isEdit){ echo url('/')."/".$data->Logo;} ?>"   data-allowed-file-extensions="<?php echo implode(" ",$FileTypes['category']['Images']) ?>" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
          </div>
          <div class="setup-content" id="stockPoints" style="display: none;">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-end">
                                <div class="col-12 col-sm-12 my-2" id="divStockPoint">
                                    <div class="accordion" id="StockPointAccordion">
                                        <div class="accordion-item">
                                          <h2 class="accordion-header text-right" id="headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#SPCreate" aria-expanded="false" aria-controls="collapseOne" id="btnCreateSP">
                                              Create New Stock Point 
                                            </button>
                                          </h2>
                                          <div id="SPCreate" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-sm-3 mt-20">
                                                                <label for="txtCSPPointName">Stock Point Name <span class="required">*</span></label>
                                                                <input type="text" class="form-control" id="txtCSPPointName" value="">
                                                                <span class="errors err-sm" id="txtCSPPointName-err"></span>
                                                            </div>
                                                            <div class="col-sm-9 mt-20">
                                                                <label for="txtCSPMapUrl">Map Url</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control  {{$Theme['input-size']}}" id="txtCSPMapUrl" value="">
                                                                    <button class="input-group-text btn-outline-primary px-4 position-relative" id="btnMapSubmit"><i class="fa fa-map-marker"></i></button>
                                                                </div>
                                                                <span class="errors err-sm" id="txtCSPMapUrl-err"></span>
                                                            </div>
                                                            {{-- MAP --}}
                                                            <div class="col-sm-12 mt-20">
                                                                <div id="MapArea" style="height: 450px;"></div>
                                                                <div class="errors mt-10" id="txtCSPMap-err"></div>
                                                            </div>
                                                            <div class="col-sm-12 mt-20">
                                                                <label for="txtCSPAddress">Address <span class="required">*</span></label>
                                                                <textarea  id="txtCSPAddress" rows="3" class="form-control"></textarea>
                                                                <span class="errors err-sm" id="txtCSPAddress-err"></span>
                                                            </div>
                                                            <div class="col-sm-4 mt-20">
                                                                <div class="form-group">
                                                                    <label for="txtCSPPostalCode">Postal Code <span class="required">*</span></label>
                                                                    <div class="input-group">
                                                                        <input type="text" id="txtCSPPostalCode" class="form-control" placeholder="Postal Code" value="">
                                                                        <button type="button" class="btn btn-outline-dark" id="btnGSearchPostalCode">Search <i class="fa fa-search"></i></button>
                                                                    </div>
                                                                    <div class="errors err-sm" id="txtCSPPostalCode-err"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4 mt-20">
                                                                <div class="form-group">
                                                                    <label for="lstCSPCity">City <span class="required">*</span></label>
                                                                    <select class="form-control {{$Theme['input-size']}} select2" id="lstCSPCity" data-selected="">
                                                                        <option value="">Select a City</option>
                                                                    </select>
                                                                    <div class="errors err-sm" id="lstCSPCity-err"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4 mt-20">
                                                                <div class="form-group">
                                                                    <label for="lstCSPTaluk">Taluk <span class="required">*</span></label>
                                                                    <select class="form-control {{$Theme['input-size']}} select2" id="lstCSPTaluk" data-selected="">
                                                                        <option value="">Select a Taluk</option>
                                                                    </select>
                                                                    <div class="errors err-sm" id="lstCSPTaluk-err"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4 mt-20">
                                                                <div class="form-group">
                                                                    <label for="lstCSPDistricts">District <span class="required">*</span></label>
                                                                    <select class="form-control {{$Theme['input-size']}} select2" id="lstCSPDistricts" data-selected="">
                                                                        <option value="">Select a District</option>
                                                                    </select>
                                                                    <div class="errors err-sm" id="lstCSPDistricts-err"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4 mt-20">
                                                                <div class="form-group">
                                                                    <label for="lstCSPState">State <span class="required">*</span></label>
                                                                    <select class="form-control {{$Theme['input-size']}} select2" id="lstCSPState"  data-selected="">
                                                                        <option value="">Select a State</option>
                                                                    </select>
                                                                    <div class="errors err-sm" id="lstCSPState-err"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4 mt-20">
                                                                <div class="form-group">
                                                                    <label for="lstCSPCountry">Country <span class="required">*</span></label>
                                                                    <select class="form-control {{$Theme['input-size']}} select2" id="lstCSPCountry" data-selected="">
                                                                        <option value="">Select a Country</option>
                                                                    </select>
                                                                    <div class="errors err-sm" id="lstCSPCountry-err"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row mt-10 mb-20">
                                                            <input id="txtCSPLatitude" class="d-none" value="">
                                                            <input id="txtCSPLongitude" class="d-none" value="">
                                                            <textarea id="txtCSPMapData" class="d-none"></textarea>
                                                        </div>
                                                        <div class="row justify-content-center mt-20">
                                                            <div class="col-12 col-sm-8 col-md-7 col-lg-4 text-center card-body">
                                                                <label class="d-block" for="edo-ani">
                                                                    <input class="radio_animated chkServiceBy" id="edo-ani" type="radio" name="rdo-ani" data-value="District" data-target="divDistrict"><span class="fw-500 fs-17">District</span>
                                                                </label>
                                                            </div>
                                                            <div class="col-12 col-sm-8 col-md-7 col-lg-4 text-center card-body">
                                                                <label class="d-block" for="edo-ani1">
                                                                    <input class="radio_animated chkServiceBy" id="edo-ani1" type="radio" name="rdo-ani" data-value="PostalCode" data-target="divPostalCode"><span class="fw-500 fs-17">Postal Code</span>
                                                                </label>
                                                            </div>
                                                            <div class="col-12 col-sm-8 col-md-7 col-lg-4 text-center card-body">
                                                                <label class="d-block" for="edo-ani2">
                                                                    <input class="radio_animated chkServiceBy" id="edo-ani2" type="radio" name="rdo-ani" data-value="Radius" data-target="divRadius"><span class="fw-500 fs-17">Radius</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="row d-none divServiceBy my-2" id="divDistrict">
                                                            <div class="col-sm-12">
                                                                <div class="row justify-content-center mt-20">
                                                                    <div class="col-12 col-sm-8 col-md-7 col-lg-4">
                                                                        <select  class="form-control select2" id="lstCSPSLDCountry" data-selected="">
                                                                            <option value="">Select a Country</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-12 col-sm-8 col-md-7 col-lg-4">
                                                                        <select  class="form-control select2" id="lstCSPSLDState" data-selected="">
                                                                            <option value="">Select a State</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-10 mb-20">
                                                                    <div class="col-12">
                                                                        <div class="accordion" id="ServiceLocationDAccordion">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row d-none divServiceBy my-2" id="divPostalCode">
                                                            <div class="col-sm-12">
                                                                <div class="row justify-content-center mt-20">
                                                                    <div class="col-12 col-sm-8 col-md-7 col-lg-4">
                                                                        <select  class="form-control select2" id="lstCSPSLPCountry" data-selected="">
                                                                            <option value="">Select a Country</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-12 col-sm-8 col-md-7 col-lg-4">
                                                                        <select  class="form-control select2" id="lstCSPSLPState" data-selected="">
                                                                            <option value="">Select a State</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-12 col-sm-8 col-md-7 col-lg-4">
                                                                        <select  class="form-control select2" id="lstCSPSLPDistrict" data-selected="">
                                                                            <option value="">Select a District</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-10 mb-20">
                                                                    <div class="col-12">
                                                                        <div class="accordion" id="ServiceLocationPAccordion">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row d-none divServiceBy my-2 justify-content-center" id="divRadius">
                                                            <div class="col-sm-4">
                                                                <div class="form-row">
                                                                    <label for="txtCSPRange">Range in KM <span class="required">*</span></label>
                                                                    <input type="number" class="form-control" id="txtCSPRange" value="0">
                                                                    <span class="errors err-sm" id="txtCSPRange-err"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="row">
                                                            <div class="col-sm-12 text-right">
                                                                <button class="btn {{$Theme['button-size']}} btn-outline-dark mr-10" id="btnCSPCancel">Cancel</button>
                                                                <button class="btn {{$Theme['button-size']}} btn-outline-success btn-air-success" id="btnCSPSave">Save</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body " >
                            <table class="table {{$Theme['table-size']}}" id="tblStockPoints">
                                <thead>
                                    <tr>
                                        <th>Stock Point ID</th>
                                        <th>Point Name</th>
                                        <th>Address</th>
                                        <th class="text-center">Service By</th>
                                        <th class="text-center">Active Status</th>
                                        <th class="text-center noExport">action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <div class="setup-content" id="productMapping" style="display: none;">
            <div class="row justify-content-center">
              <div class="col-12 col-sm-12 col-lg-10">
                <div class="card">
                  <div class="card-body">
                    <div class="row justify-content-center">
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label for="lstPMPCategory">Product Category</label>
                          <select  class="form-control select2" id="lstPMPCategory" data-selected="">
                            <option value="">Select a Product Category</option>
                          </select>
                            <span class="errors" id="lstPMPCategory-err"></span>
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label for="lstPMPSubCategory">Product Sub Category</label>
                          <select  class="form-control select2" id="lstPMPSubCategory" data-selected="">
                            <option value="">Select a Product Sub Category</option>
                          </select>
                            <span class="errors" id="lstPMPSubCategory-err"></span>
                        </div>
                      </div>
                    </div>
                    <div class="row mt-50">
                      <div class="col-12 col-sm-12">
                        <table class="table  table-bordered" id="tblVendProdMapping">
                          <thead>
                            <tr>
                              <th class="align-middle">Products</th>
                              <th class="text-center align-middle">Availablity</th>
                              <th class="text-center align-middle">Price</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="row">
                      <div class="col-sm-12 text-right">
                        <button id="btnPMSave" type="button" class="btn {{$Theme['button-size']}} btn-outline-success btn-air-success">@if($isEdit) Update @else Save @endif</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="setup-content" id="stockUpdate" style="display: none;">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="lstSUPCategory">Product Category</label>
                                        <select  class="form-control select2" id="lstSUPCategory" data-selected="">
                                            <option value="">Select a Product Category</option>
                                        </select>
                                            <span class="errors" id="lstSUPCategory-err"></span>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="lstSUPSubCategory">Product Sub Category</label>
                                        <select  class="form-control select2" id="lstSUPSubCategory" data-selected="">
                                            <option value="">Select a Product Sub Category</option>
                                        </select>
                                            <span class="errors" id="lstSUPSubCategory-err"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-50">
                                <div class="col-12 col-sm-12" id="divVendStockTable">
                                    <table class="table table-bordered" id="tblVendStockUpdate">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12 text-right">
                                    <button id="btnSUSave" type="button" class="btn {{$Theme['button-size']}} btn-outline-success btn-air-success">@if($isEdit) Update  @else Save @endif</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<input type="file" data-uuid="" id="txtVehicleImages" class="d-none" multiple accept="<?php if(count($FileTypes['category']['Images'])>0) {echo ".".implode(",.",$FileTypes['category']['Images']);} ?>">
<input type="file" data-uuid="" id="txtDocuments" class="d-none" multiple accept="<?php if(count($FileTypes['category']['Documents'])>0) {echo ".".implode(",.",$FileTypes['category']['Documents']);} ?>">
@endsection
@section('scripts')
<script src="{{url('/')}}/assets/js/form-wizard/form-wizard-five.js"></script>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.js"></script>
<!-- Image Crop Script Start -->

<script>
    var $image=null;
    $(document).ready(function() {
        var uploadedImageURL;
        var URL = window.URL || window.webkitURL;
        var $dataRotate = $('#dataRotate');
        var $dataScaleX = $('#dataScaleX');
        var $dataScaleY = $('#dataScaleY');
        var options = {
            aspectRatio: 16/9,
            preview: '.img-preview'
        };
        $image = $('#ImageCrop').cropper(options);
        $('#ImgCrop').modal({backdrop: 'static',keyboard: false});
        $('#ImgCrop').modal('hide');
        $(document).on('change', '.imageScrop', function() {
            let id = $(this).attr('id');
            let pType=$(this).attr('data-product-type')
            let uuid=$(this).attr('data-uuid')
            $('#'+id).attr('data-remove',0);
            if($('#'+id).attr('data-aspect-ratio')!=undefined){
                options.aspectRatio=$('#'+id).attr('data-aspect-ratio')
            }
            $image.attr('data-id', id);
            $image.attr('data-is-url', 0);
            $image.attr('data-product-type', pType);
            $image.attr('data-uuid', uuid);
            $('#ImgCrop').modal('show');
            var files = this.files;
            if (files && files.length) {
                file = files[0];
                if (/^image\/\w+$/.test(file.type)) {
                    uploadedImageName = file.name;
                    uploadedImageType = file.type;
                    if (uploadedImageURL) {
                        URL.revokeObjectURL(uploadedImageURL);
                    }
                    uploadedImageURL = URL.createObjectURL(file);
                    $image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
                } else {
                    window.alert('Please choose an image file.');
                }
            }
        });
        $(document).on('click','.actions a.crop',function(e){
            e.preventDefault();
            let aid=$(this).attr('data-attachment_id')
            let pType=$(this).attr('data-product-type')
            let uuid=$(this).attr('data-uuid')
            if($(this).attr('data-aspect-ratio')!=undefined){
                options.aspectRatio=$(this).attr('data-aspect-ratio')
            }
            let url=$(this).attr('href');
            if(url!="#"){
                $image.attr('data-is-url', 1);
                $image.attr('data-is-url', 1);
                $image.attr('data-attachment_id', aid);
                $image.attr('data-product-type', pType);
                $image.attr('data-uuid', uuid);
                $('#ImgCrop').modal('show');
                var request = new XMLHttpRequest();
                request.open('GET', url, true);
                request.responseType = 'blob';
                request.onload = function() {
                    var reader = new FileReader();
                    reader.onload =  function(e){
                        $image.cropper('destroy').attr('src', reader.result).cropper(options);
                    };
                    reader.readAsDataURL(request.response);
                };
                request.send();
            }
        });
        $('.docs-buttons').on('click', '[data-method]', function() {
            var $this = $(this);
            var data = $this.data();
            var cropper = $image.data('cropper');
            var cropped;
            var $target;
            var result;
            if (cropper && data.method) {
                data = $.extend({}, data);
                if (typeof data.target !== 'undefined') {
                    $target = $(data.target);
                    if (typeof data.option === 'undefined') {
                        try {
                            data.option = JSON.parse($target.val());
                        } catch (e) {
                            console.log(e.message);
                        }
                    }
                }
                cropped = cropper.cropped;
                switch (data.method) {
                    case 'rotate':
                        if (cropped && options.viewMode > 0) {
                            $image.cropper('clear');
                        }
                        break;
                    case 'getCroppedCanvas':
                        if (uploadedImageType === 'image/jpeg') {
                            if (!data.option) {
                                data.option = {};
                            }
                            data.option.fillColor = '#fff';
                        }
                        break;
                }
                result = $image.cropper(data.method, data.option, data.secondOption);
                switch (data.method) {
                    case 'rotate':
                        if (cropped && options.viewMode > 0) {
                            $image.cropper('crop');
                        }
                        break;
                    case 'scaleX':
                    case 'scaleY':
                        $(this).data('option', -data.option);
                        break;
                    case 'getCroppedCanvas':
                        if (result) {
                            $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);
                            if (!$download.hasClass('disabled')) {
                                download.download = uploadedImageName;
                                $download.attr('href', result.toDataURL(uploadedImageType));
                            }
                        }
                        break;
                }
            }
        });
        $('#inputImage').change(function() {
            var files = this.files;
            var file;
            if (!$image.data('cropper')) {
                return;
            }
            if (files && files.length) {
                file = files[0];
                if (/^image\/\w+$/.test(file.type)) {
                    uploadedImageName = file.name;
                    uploadedImageType = file.type;
                    if (uploadedImageURL) {
                        URL.revokeObjectURL(uploadedImageURL);
                    }
                    uploadedImageURL = URL.createObjectURL(file);
                    $image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
                    $('#inputImage').val('');
                } else {
                    window.alert('Please choose an image file.');
                }
            }
        });
        $(document).on('click', '#btnUploadImage', function() {
            $('#inputImage').trigger('click')
        });
        $("#btnCropApply").on('click', function() {

        });
        $(document).on('click','#btnCropModelClose',function(){
            let  id = $image.attr('data-id');
            let isUrl=$image.attr('data-is-url');
            let aid=$image.attr('data-attachment_id');
            if(isUrl=="0"){
                $('#' + id).val("");
                $('#' + id).attr('src', "");
                $('#' + id).parent().find('img').attr('src', "");
                $('#' + id).parent().find('.dropify-clear').trigger('click');
            }
            $('#ImgCrop').modal('hide');
        });
    });
</script>
<!-- Image Crop Script End -->

{{-- Map Script --}}
<script>
    var map;
    var marker;

    function initMap() {
        map = new google.maps.Map(document.getElementById('MapArea'), {
            center: { lat: 11.196, lng: 77.316 },
            zoom: 7
        });

        marker = new google.maps.Marker({
            map: map,
            draggable: true
        });

        map.addListener('click', function (event) {
            updateMarker(event.latLng);
        });

        marker.addListener('dragend', function () {
            updateAddress(marker.getPosition());
        });
    }

    function updateMarker(latLng) {
        marker.setPosition(latLng);
        updateAddress(latLng);
    }

    function updateAddress(latLng) {
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({ 'location': latLng }, function (results, status) {
            if (status === 'OK' && results[0]) {
                var formattedAddress = results[0].formatted_address;
                var addressComponents = formattedAddress.split(', ');
                var simplifiedAddress = addressComponents.slice(0, -2).join(', ');
                $('#txtCSPAddress').val(simplifiedAddress);
                $('#txtCSPLatitude').val(latLng.lat());
                $('#txtCSPLongitude').val(latLng.lng());
                $('#txtCSPMapData').val(JSON.stringify(results[0]));
                var postalCode = extractPostalCodeFromAddressComponents(results[0]);
                if (postalCode) {
                    $('#txtCSPPostalCode').val(postalCode);
                    $('#btnGSearchPostalCode').click();
                }
            }
        });
    }

    function extractPostalCodeFromAddressComponents(result) {
        for (var i = 0; i < result.address_components.length; i++) {
            var addressComponent = result.address_components[i];
            if (addressComponent.types.includes('postal_code')) {
                return addressComponent.long_name;
            }
        }
        return null;
    }

    function markLocationFromUrl(url) {
        var matches = url.match(/@([-0-9.]+),([-0-9.]+)/);
        if (matches && matches.length === 3) {
            var lat = parseFloat(matches[1]);
            var lng = parseFloat(matches[2]);
            var latLng = new google.maps.LatLng(lat, lng);
            marker.setPosition(latLng);
            map.setCenter(latLng);
            updateAddress(latLng);
        } else {
            $('#txtCSPMapUrl-err').html('Enter a valid Map URL!');
        }
    }

    $(document).on('click', '#btnMapSubmit', function () {
        $('#txtCSPMapUrl-err').html('');
        var mapUrl = $('#txtCSPMapUrl').val();
        if (!mapUrl) {
            $('#txtCSPMapUrl-err').html('Enter a Map URL!');
        } else {
            markLocationFromUrl(mapUrl);
        }
    });

</script>
<script async src="https://maps.googleapis.com/maps/api/js?key={{ config('app.map_api_key') }}&callback=initMap"></script>
{{-- End Map Script --}}


<script>
    $(document).ready(function(){
        // Stock Points Scripts

        var tblStockPoints=null;
        const SPLoadTable=async()=>{
			@if($crud['view']==1)
			let vendorID = $("#txtVendorID").val();
			$('#tblStockPoints').DataTable().destroy();
				$('#tblStockPoints').dataTable({
					"bProcessing": true,
					"bServerSide": true,
					"ajax": {"url":"{{url('/')}}/admin/master/vendor/stock-points/data?_token="+$('meta[name=_token]').attr('content'),data:{VendorID : vendorID},"headers":{ 'X-CSRF-Token' : $('meta[name=_token]').attr('content') } ,"type": "POST"},
					deferRender: true,
					responsive: true,
					dom: 'Bfrtip',
					"iDisplayLength": 10,
					"lengthMenu": [[10, 25, 50,100,250,500, -1], [10, 25, 50,100,250,500, "All"]],
					buttons: [],
					columnDefs: [
						{"className": "dt-center", "targets":[3,4,5]}
					],
                    info:false,
                    searching:false,
                    ordering:false
				});
			@endif
        }
		$(document).on('click','#btnCSPCancel',function(){
			ClearSPData();
		});
		$(document).on('click','.btnEdit',function(){
			loadCSPData($(this).attr('data-id'));

            $('#btnCSPSave').attr('data-id', $(this).attr('data-id'));
            $('#btnCSPSave').html("Update");
            $('#btnCreateSP').hasClass('collapsed') ? $('#btnCreateSP').trigger('click') : null;
		});
		$(document).on('click','.btnDelete',function(){
			let ID=$(this).attr('data-id');
			swal({
                title: "Are you sure?",
                text: "You want Delete this Stock Point!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-outline-danger",
                confirmButtonText: "Yes, Delete it!",
                closeOnConfirm: false
            },
            function(){swal.close();
            	$.ajax({
            		type:"post",
                    url:"{{url('/')}}/admin/master/vendor/stock-points/delete/"+ID,
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    dataType:"json",
                    success:function(response){
                    	swal.close();
                    	if(response.status==true){
                    		$('#tblStockPoints').DataTable().ajax.reload();
                    		toastr.success(response.message, "Success", { positionClass: "toast-top-right", containerId: "toast-top-right", showMethod: "slideDown", hideMethod: "slideUp", progressBar: !0 })
                    	}else{
                    		toastr.error(response.message, "Failed", { positionClass: "toast-top-right", containerId: "toast-top-right", showMethod: "slideDown", hideMethod: "slideUp", progressBar: !0 })
                    	}
                    }
            	});
            });
		});
		$(document).on('change', '.btnActiveStatus', function() {
			let ID = $(this).attr('data-id');
			let ActiveStatus = $(this).prop('checked') ? 1 : 0;
			
			let Switch = $(this).closest('.switch').find('span');
			ActiveStatus ? $(Switch).addClass('bg-success').removeClass('bg-danger') : $(Switch).addClass('bg-danger').removeClass('bg-success');

			$.ajax({
				type: "post",
				url: "{{url('/')}}/admin/master/vendor/stock-points/active-status",
				headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
				data: { StockPointID: ID, ActiveStatus: ActiveStatus },
				dataType: "json",
				success: function(response) {
					swal.close();
					if (response.status) {
						// $('#tblStockPoints').DataTable().ajax.reload();
						toastr.success(response.message, "Success", { positionClass: "toast-top-right", containerId: "toast-top-right", showMethod: "slideDown", hideMethod: "slideUp", progressBar: true });
					} else {
						toastr.error(response.message, "Failed", { positionClass: "toast-top-right", containerId: "toast-top-right", showMethod: "slideDown", hideMethod: "slideUp", progressBar: true});
					}
				}
			});
		});
        
        const getCSPCity=async(data)=>{
            return await new Promise((resolve,reject)=>{
                $.ajax({
                    type:"post",
                    url:"{{url('/')}}/get/city",
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    data:data,
                    dataType:"json",
                    async:true,
                    error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                    complete: function(e, x, settings, exception){},
                    success:function(response){
                        resolve(response)
                    }
                });
            });
        }
        const getCSPTaluks=async(data,id)=>{
            $('#'+id).select2('destroy');
            $('#'+id+' option').remove();
            $('#'+id).append('<option value="">Select a Taluk</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/taluks",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:data,
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.TalukID==$('#'+id).attr('data-selected')){selected="selected";}
                        $('#'+id).append('<option '+selected+' data-taluk=""  value="'+Item.TalukID+'">'+Item.TalukName+' </option>');
                    }
                    if($('#'+id).val()!=""){
                        $('#'+id).trigger('change');
                    }
                }
            });
            $('#'+id).select2();
        }
        const getCSPDistricts=async(data,id)=>{
            let Data = [];
            $('#'+id).select2('destroy');
            $('#'+id+' option').remove();
            $('#'+id).append('<option value="">Select a District</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/districts",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:data,
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.DistrictID==$('#'+id).attr('data-selected')){selected="selected";}
                        $('#'+id).append('<option '+selected+' data-taluk=""  value="'+Item.DistrictID+'">'+Item.DistrictName+' </option>');
                    }
                    if($('#'+id).val()!=""){
                        $('#'+id).trigger('change');
                    }
                    Data = response;
                }
            });
            $('#'+id).select2();
            return Data;
        }
        const getCSPStates=async(data,id)=>{
            $('#'+id).select2('destroy');
            $('#'+id+' option').remove();
            $('#'+id).append('<option value="">Select a State</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/states",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:data,
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.StateID==$('#'+id).attr('data-selected')){selected="selected";}
                        $('#'+id).append('<option '+selected+'  value="'+Item.StateID+'">'+Item.StateName+' </option>');
                    }
                    if($('#'+id).val()!=""){
                        $('#'+id).trigger('change');
                    }
                }
            });
            $('#'+id).select2();
        }
        const getCSPCountry=async(data,id)=>{
            $('#'+id).select2('destroy');
            $('#'+id+' option').remove();
            $('#'+id).append('<option value="">Select a Country</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/country",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:data,
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.CountryID==$('#'+id).attr('data-selected')){selected="selected";}
                        $('#'+id).append('<option '+selected+' value="'+Item.CountryID+'">'+Item.CountryName+' </option>');
                    }
                    if($('#'+id).val()!=""){
                        $('#'+id).trigger('change');
                    }
                }
            });
            $('#'+id).select2();
        }
        $(document).on('click','#btnGSearchPostalCode',async function(){
            $('#txtCSPPostalCode-err').html('')
            let PostalCode=$('#txtCSPPostalCode').val();
            if(PostalCode!=""){
                $('#btnGSearchPostalCode').attr('disabled','disabled');
                $('#btnGSearchPostalCode').html('<i class="fa fa-spinner fa-pulse"></i>');
                let response=await getCSPCity({PostalCode});
                if(response.length>0){
                    $('#lstCSPCity').select2('destroy');
                    $('#lstCSPCity option').remove();
                    $('#lstCSPCity').append('<option value="">Select a City</option>');
                    for(let Item of response){
                        let selected="";
                        if(Item.CityID==$('#lstCSPCity').attr('data-selected')){selected="selected";}
                        $('#lstCSPCity').append('<option '+selected+' data-postal="'+Item.PostalID+'" data-taluk="'+Item.TalukID+'" data-district="'+Item.DistrictID+'" data-state="'+Item.StateID+'" data-country="'+Item.CountryID+'" data-city-name="'+Item.CityName+'" value="'+Item.CityID+'">'+Item.CityName+' </option>');
                    }
                    $('#lstCSPCity').select2();
                    if($('#lstCSPCity').val()!=""){
                        $('#lstCSPCity').trigger('change');
                    }
                }else{
                    $('#txtCSPPostalCode-err').html('Postal Code does not exists.')
                }
                setTimeout(() => {
                    $('#btnGSearchPostalCode').html('Search <i class="fa fa-search"></i>');
                    $('#btnGSearchPostalCode').removeAttr('disabled');
                }, 100);
            }else{
                $('#txtCSPPostalCode-err').html('Postal Code is required.')
            }
        });
        $(document).on("change",'#lstCSPCity',function(){
            $('.errors').html("");
            let CountryID=$('#lstCSPCity option:selected').attr('data-country');
            let StateID=$('#lstCSPCity option:selected').attr('data-state');
            let DistrictID=$('#lstCSPCity option:selected').attr('data-district');
            let TalukID=$('#lstCSPCity option:selected').attr('data-taluk');
            $('#lstCSPTaluk').attr('data-selected',TalukID);
            $('#lstCSPDistricts').attr('data-selected',DistrictID);
            $('#lstCSPState').attr('data-selected',StateID);
            $('#lstCSPCountry').attr('data-selected',CountryID);
            $('#lstCSPCountry').val(CountryID).trigger('change');

            if (!$('.chkServiceBy:checked').length) {
                setTimeout(function() {
                    $('.chkServiceBy[data-value="PostalCode"]').prop('checked', true).trigger('change');
                },3000)
            }
        });
        $(document).on("change",'#lstCSPDistricts',function(){
            getCSPTaluks({CountryID:$('#lstCSPCountry').val(),StateID:$('#lstCSPState').val(),DistrictID:$('#lstCSPDistricts').val()},'lstCSPTaluk');
        });
        $(document).on("change",'#lstCSPState',function(){
            getCSPDistricts({CountryID:$('#lstCSPCountry').val(),StateID:$('#lstCSPState').val()},'lstCSPDistricts');
        });
        $(document).on("change",'#lstCSPCountry',function(){
            getCSPStates({CountryID:$('#lstCSPCountry').val()},'lstCSPState');
        });
        getCSPCountry({},'lstCSPCountry');

        // Service By District
        const AddDServiceLocations=async(CountryID,StateID,StateName,DistrictIDs)=>{
            let AddressStateID =  $("#lstCSPState").val();
            let AddressDistrictID = $("#lstCSPDistrict").val();

            let html = `<div class="accordion-item" data-country-id="${CountryID}" data-state-id="${StateID}">
                            <h2 class="accordion-header" id="${StateID}-heading">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panel-${StateID}" aria-expanded="true" aria-controls="panel-${StateID}">
                                    ${StateName} 
                                    <span class="options">
                                        <span class="trash state-trash" data-state-id="${StateID}"><i class="fa fa-trash"></i></span>
                                    </span>
                                </button>
                            </h2>
                            <div id="panel-${StateID}" class="accordion-collapse collapse" aria-labelledby="${StateID}-heading">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="lstCSPSLDDistricts-${StateID}">Districts</label>
                                            <div class="form-group">
                                                <select id="lstCSPSLDDistricts-${StateID}" class="form-control select2 lstCSPSLDDistricts" data-selected="${(AddressStateID == StateID ? AddressDistrictID : '')}" multiple></select>
                                            </div>
                                        </div>
                                        <span class="errors err-sm"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
            `;

            $('#ServiceLocationDAccordion').append(html);

            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/districts",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:{CountryID : CountryID, StateID : StateID},
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);resolve([])},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(DistrictIDs){
                            if(DistrictIDs.indexOf(Item.DistrictID)!=-1){
                                selected="selected";
                            }
                        }else if(Item.DistrictID==$('#lstCSPSLDDistricts-'+StateID).attr('data-selected')){
                            selected="selected";
                        }
                        $('#lstCSPSLDDistricts-'+StateID).append('<option '+selected+' value="'+Item.DistrictID+'">'+Item.DistrictName+' </option>');
                    }
                }
            });
            $('#lstCSPSLDDistricts-'+StateID).select2();
        }
        $(document).on("change",'#lstCSPSLDCountry',async function(){
            getCSPStates({CountryID : $(this).val()},"lstCSPSLDState")
        });
        $(document).on("change",'#lstCSPSLDState',async function(){
            $(".errors").html('');
            let CountryID=$("#lstCSPSLDCountry").val();
            let StateID=$(this).val();
            if(StateID){
                let StateName=$(this).find('option:selected').html();
                $('#lstCSPSLDState').select2('destroy');
                $('#lstCSPSLDState option[value="'+StateID+'"]').attr('disabled','disabled');
                $('#lstCSPSLDState').val("").trigger("change");
                $('#lstCSPSLDState').select2();
                $('#ServiceLocationDAccordion .accordion-item[data-state-id="' + StateID + '"]').length === 0 ? AddDServiceLocations(CountryID, StateID, StateName) : null;
            }
        });
        $(document).on('click','.state-trash',function(){
            let StateID=$(this).attr('data-state-id');
            $('#lstCSPSLDState').select2('destroy');
            $('#ServiceLocationDAccordion .accordion-item[data-state-id="'+StateID+'"]').remove();
            $('#lstCSPSLDState option[value="'+StateID+'"]').removeAttr('disabled');
            $('#lstCSPSLDState').select2();
        });

        // Service By Postal Code
        const AddPServiceLocations=async(CountryID,StateID,DistrictID,DistrictName,PostalCodeIDs)=>{
            let AddressDistrictID = $("#lstCSPDistrict").val();
            let AddressPostalCodeID = $("#lstCSPCity option:selected").attr('data-postal');
            let html = `<div class="accordion-item" data-country-id="${CountryID}" data-state-id="${StateID}" data-district-id="${DistrictID}">
                            <h2 class="accordion-header" data-district-id="${DistrictID}" id="${DistrictID}-heading">
                                <button class="accordion-button" type="button" data-district-id="${DistrictID}" data-bs-toggle="collapse" data-bs-target="#panel-${DistrictID}" aria-expanded="true" aria-controls="panel-${DistrictID}">
                                    ${DistrictName} 
                                    <span class="options">
                                        <span class="trash district-trash" data-district-id="${DistrictID}"><i class="fa fa-trash"></i></span>
                                    </span>
                                </button>
                            </h2>
                            <div id="panel-${DistrictID}" class="accordion-collapse collapse" aria-labelledby="${DistrictID}-heading">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="lstCSPSLPPostalCodes-${DistrictID}">Postal Code</label>
                                            <div class="form-group">
                                                <select id="lstCSPSLPPostalCodes-${DistrictID}" data-district-id="${DistrictID}" class="form-control select2 lstCSPSLPPostalCodes" data-selected="${(AddressDistrictID == DistrictID ? AddressPostalCodeID : '')}" multiple></select>
                                            </div>
                                        </div>
                                        <span class="errors err-sm"></span>
                                    </div>
                                    <div class="row mt-15 mb-10 ">
                                        <div class="col-12 text-center d-flex justify-content-center align-items-center">
                                            <button class="btn btn-sm btn-outline-primary mr-10  btnPCodeSelectAll">Select All</button>
                                            <button class="btn btn-sm btn-outline-primary mr-10 btnPCodeDeselectAll">Deselect All</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            `;

            $('#ServiceLocationPAccordion').append(html);

            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/postal-code",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:{CountryID : CountryID, StateID : StateID, DistrictID : DistrictID},
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);resolve([])},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(PostalCodeIDs){
                            if(PostalCodeIDs.indexOf(Item.PID)!=-1){
                                selected="selected";
                            }
                        }else if(Item.PID==$('#lstCSPSLPPostalCodes-'+DistrictID).attr('data-selected')){
                            selected="selected";
                        }
                        $('#lstCSPSLPPostalCodes-'+DistrictID).append('<option '+selected+' value="'+Item.PID+'">'+Item.PostalCode+' </option>');
                    }
                }
            });
            $('#lstCSPSLPPostalCodes-'+DistrictID).select2();
        }
        $(document).on("change",'#lstCSPSLPCountry',async function(){
            getCSPStates({CountryID : $(this).val()},"lstCSPSLPState")
        });
        $(document).on("change",'#lstCSPSLPState',async function(){
            $(".errors").html('');
            let ExistingDistricts = [];
            $('#ServiceLocationPAccordion .accordion-item').each(function(){
                ExistingDistricts.push($(this).attr('data-district-id'));
            });
            $('#lstCSPSLPDistrict').select2('destroy');
            $('#lstCSPSLPDistrict option').remove();
            $('#lstCSPSLPDistrict').append('<option value="">Select a District</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/districts",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:{CountryID : $('#lstCSPSLPCountry').val(), StateID : $(this).val()},
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);resolve([])},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let disabled="";
                        let selected="";
                        if(ExistingDistricts.indexOf(Item.DistrictID)!=-1){disabled="disabled";}
                        if(Item.DistrictID==$('#lstCSPSLPDistrict').attr('data-selected')){selected="selected";}
                        $('#lstCSPSLPDistrict').append('<option '+selected+' '+disabled+' value="'+Item.DistrictID+'">'+Item.DistrictName+' </option>');
                    }
                    if($('#lstCSPSLPDistrict').val()!=""){
                        $('#lstCSPSLPDistrict').trigger('change');
                    }
                }
            });
            $('#lstCSPSLPDistrict').select2();
        });
        $(document).on("change",'#lstCSPSLPDistrict',function(){
            $(".errors").html('');
            let CountryID=$("#lstCSPSLPCountry").val();
            let StateID=$("#lstCSPSLPState").val();
            let DistrictID=$(this).val();
            if(DistrictID){
                let DistrictName=$(this).find('option:selected').html();
                $('#lstCSPSLPDistrict').select2('destroy');
                $('#lstCSPSLPDistrict option[value="'+DistrictID+'"]').attr('disabled','disabled');
                $('#lstCSPSLPDistrict').val("").trigger("change");
                $('#lstCSPSLPDistrict').select2();
                $('#ServiceLocationPAccordion .accordion-item[data-district-id="' + DistrictID + '"]').length === 0 ? AddPServiceLocations(CountryID,StateID,DistrictID,DistrictName) : null;
            }
        });
        $(document).on('click','.district-trash',function(){
            let DistrictID=$(this).attr('data-district-id');
            $('#lstCSPSLPDistrict').select2('destroy');
            $('#ServiceLocationPAccordion .accordion-item[data-district-id="'+DistrictID+'"]').remove();
            $('#lstCSPSLPDistrict option[value="'+DistrictID+'"]').removeAttr('disabled');
            $('#lstCSPSLPDistrict').select2();
        });
        $(document).on('click', '.btnPCodeSelectAll', function () {
            let accordionBody = $(this).closest('.accordion-body');
            
            accordionBody.find('.lstCSPSLPPostalCodes').select2('destroy');
            accordionBody.find('.lstCSPSLPPostalCodes option').prop('selected', true);
            accordionBody.find('.lstCSPSLPPostalCodes').select2();
        });
        $(document).on('click','.btnPCodeDeselectAll',function(){
            let accordionBody = $(this).closest('.accordion-body');
            
            accordionBody.find('.lstCSPSLPPostalCodes').select2('destroy');
            accordionBody.find('.lstCSPSLPPostalCodes option').prop('selected', false);
            accordionBody.find('.lstCSPSLPPostalCodes').select2();
        });
        $(".chkServiceBy").change(function() {
            var target = $(this).data('target');
            var Value = $(this).data('value');
            $(".divServiceBy").not("#"+target).addClass('d-none');
            $("#"+target).removeClass('d-none');

            let Country = $("#lstCSPCountry").val();
            let State = $("#lstCSPState").val();
            let District = $("#lstCSPDistrict").val();

            if(Value == "District"){
                let SLDCountry = $("#lstCSPSLPCountry").val();
                $("#lstCSPSLDCountry").attr("data-selected",Country);
                $("#lstCSPSLDState").attr("data-selected",State);
                getCSPCountry({},"lstCSPSLDCountry");
            }else if(Value == "PostalCode"){
                let SLPCountry = $("#lstCSPSLPCountry").val();
                let SLPState = $("#lstCSPSLPState").val();
                $("#lstCSPSLPCountry").attr("data-selected",Country);
                $("#lstCSPSLPState").attr("data-selected",State);
                $("#lstCSPSLPDistrict").attr("data-selected",District);
                getCSPCountry({},"lstCSPSLPCountry");
            }
        });

        const loadCSPData=async(stockPointID)=>{
            $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/master/vendor/stock-points/get/service-data",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:{StockPointID:stockPointID},
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    if(response){
                        $('#txtCSPPointName').val(response.PointName);
                        $('#txtCSPAddress').val(response.Address);
                        $('#txtCSPPostalCode').val(response.PostalCode);
                        $('#lstCSPCity').attr('data-selected',response.CityID);
                        
                        $('#txtCSPLatitude').val(response.Latitude);
                        $('#txtCSPRange').val(response.Range);
                        $('#txtCSPLongitude').val(response.Longitude);
                        $('#txtCSPMapData').val(response.MapData);
                        $('#btnGSearchPostalCode').trigger('click');
                        $('.chkServiceBy[data-value="'+response.ServiceBy+'"]').prop('checked', true).trigger('change');

                        var latLng = new google.maps.LatLng(response.Latitude, response.Longitude);
                        marker.setPosition(latLng);
                        map.setCenter(latLng);
                        updateAddress(latLng);
                    }
                    if(response.ServiceData.length>0){
                        for(let item of response.ServiceData){
                            let DistrictIDs = [];
                            if(response.ServiceBy == "District"){
                                for (let district of item.Districts) {
                                    DistrictIDs.push(district.DistrictID);
                                }
                                $('#ServiceLocationDAccordion .accordion-item[data-state-id ="' + item.StateID + '"]').length == 0 ? AddDServiceLocations(item.CountryID,item.StateID,item.StateName,DistrictIDs) : null;
                            }else if (response.ServiceBy == "PostalCode") {
                                for (let district of item.Districts) {
                                    $('#ServiceLocationPAccordion .accordion-item[data-district-id="' + district.DistrictID + '"]').length === 0 ? AddPServiceLocations(item.CountryID, item.StateID, district.DistrictID, district.DistrictName, district.PostalCodeIDs) : null;
                                }
                            }
                        }
                    }
                }
            });
            
        }
        const ClearSPData=async()=>{
            $('.errors').html("");
            $('#btnCreateSP').hasClass('collapsed') ? null : $('#btnCreateSP').trigger('click');
            $('#btnCSPSave').attr('data-id', "");
            $('#txtCSPPointName').val("");
            $('#txtCSPMapUrl').val("");
            $('#txtCSPAddress').val("");
            $('#txtCSPPostalCode').val("");
            $('#lstCSPCity').attr('data-selected',"");
            
            $('#txtCSPLatitude').val("");
            $('#txtCSPRange').val("");
            $('#txtCSPLongitude').val("");
            $('#txtCSPMapData').val("");
            $('#txtCSPRange').val(0);
            $('#ServiceLocationDAccordion').html("");
            $('#ServiceLocationPAccordion').html("");
            $('#btnCSPSave').html("Save");
            $('.chkServiceBy').prop('checked', false);
            initMap();
        }
        const CSPformValidation=async()=>{
            $('.errors').html('');
            let status=true;
            let Vendor=$('#txtVendorID').val();
            let PointName=$('#txtCSPPointName').val();
            let Address=$('#txtCSPAddress').val();
            let PostalCode=$('#lstCSPCity option:selected').attr('data-postal');
            let CityID=$('#lstCSPCity').val();
            let TalukID=$('#lstCSPTaluk').val();
            let DistrictID=$('#lstCSPDistricts').val();
            let StateID=$('#lstCSPState').val();
            let CountryID=$('#lstCSPCountry').val();
            let Latitude = $('#txtCSPLatitude').val();
            if(!Latitude){
                $('#txtCSPMap-err').html('Mark your stock point in Map.');status=false;
            }
            if(!PostalCode){
                $('#txtCSPPostalCode-err').html('Postal Code is required.');status=false;
            }
            if(CityID==""){
                $('#lstCSPCity-err').html('City is required.');status=false;
            }
            if(TalukID==""){
                $('#lstCSPTaluk-err').html('Taluk is required.');status=false;
            }
            if(DistrictID==""){
                $('#lstCSPDistricts-err').html('District is required.');status=false;
            }
            if(StateID==""){
                $('#lstCSPState-err').html('State is required.');status=false;
            }
            if(CountryID==""){
                $('#lstCSPCountry-err').html('Country is required.');status=false;
            }
            if(Address==""){
                $('#txtCSPAddress-err').html('Address is required.');status=false;
            }else if(Address.length<5){
                $('#txtCSPAddress-err').html('Address must be greater than 5 characters');status=false;
            }
            if(!PointName){
                $('#txtCSPPointName-err').html('The Stock point name is required.');status=false;
            }else if(PointName.length < 3){
                $('#txtCSPPointName-err').html('The Stock point name must be greater than 3 characters.');status=false;
            }
            if(!Vendor){
                $('#lstCSPVendor-err').html('The Vendor Name is required.');status=false;
            }
            if (!$('.chkServiceBy:checked').length && status) {
                toastr.error("Please select any Services", "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0});
                status = false;
            } else if ($('.chkServiceBy:checked[data-value="District"]').length) { 
                if ($('#ServiceLocationDAccordion .accordion-item').length == 0) {
                    toastr.error("Please select any State in District Services!", "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0});
                    status = false;
                } else {
                    $('#ServiceLocationDAccordion .accordion-item').each(function () {
                        if ($(this).find('.lstCSPSLDDistricts').val().length == 0) {
                            $(this).find('.accordion-button').hasClass('collapsed') ? $(this).find('.accordion-button').trigger('click') : null;
                            $(this).find('.lstCSPSLDDistricts').focus();
                            $(this).find('.errors').html('Select a District!');
                            status = false;
                        }
                    });
                }
            } else if ($('.chkServiceBy:checked[data-value="PostalCode"]').length) {
                if ($('#ServiceLocationPAccordion .accordion-item').length == 0) {
                    toastr.error("Please select any District in PostalCode Services!", "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0});
                    status = false;
                } else {
                    $('#ServiceLocationPAccordion .accordion-item').each(function () {
                        if ($(this).find('.lstCSPSLPPostalCodes').val().length == 0) {
                            $(this).find('.accordion-button').hasClass('collapsed') ? $(this).find('.accordion-button').trigger('click') : null;
                            $(this).find('.lstCSPSLPPostalCodes').focus();
                            $(this).find('.errors').html('Select a PostalCode!');
                            status = false;
                        }
                    });
                }
            } else if ($('.chkServiceBy:checked[data-value="Radius"]').length){
                let Range = $('#txtCSPRange').val().trim();
                if (Range === "") {
                    $('#txtCSPRange-err').html('Range is required.');
                    status = false;
                } else {
                    Range = Number(Range);
                    if (Range <= 0 || isNaN(Range)) {
                        $('#txtCSPRange-err').html('Range must be a number greater than 0.');
                        status = false;
                    }
                }

            }
            return status;

            if(status==false){$("html, body").animate({ scrollTop: 0 }, "slow");}
        }
        const GetCSPData=async ()=>{
            let ServiceData = [];
            let ServiceBy = $('.chkServiceBy:checked').data('value');

            let formData=new FormData();
            formData.append('VendorID',$('#txtVendorID').val());
            formData.append('PointName',$('#txtCSPPointName').val());
            formData.append('ServiceBy',ServiceBy);
            formData.append('Range',$('#txtCSPRange').val());
            formData.append('MapData',$('#txtCSPMapData').val());
            formData.append('Latitude',$('#txtCSPLatitude').val());
            formData.append('Longitude',$('#txtCSPLongitude').val());
            formData.append('Address',$('#txtCSPAddress').val());
            formData.append('PostalID',$('#lstCSPCity option:selected').attr('data-postal'));
            formData.append('CityID',$('#lstCSPCity').val());
            formData.append('TalukID',$('#lstCSPTaluk').val());
            formData.append('DistrictID',$('#lstCSPDistricts').val());
            formData.append('StateID',$('#lstCSPState').val());
            formData.append('CountryID',$('#lstCSPCountry').val());

            if(ServiceBy == "District"){
                $('#ServiceLocationDAccordion .accordion-item').each(function () {
                    let serviceData = {
                            CountryID: $(this).attr('data-country-id'),
                            StateID: $(this).attr('data-state-id'),
                            Districts: [],
                        };

                    let DistrictIDs = $(this).find('.lstCSPSLDDistricts').val();
                    DistrictIDs.forEach(function (districtID) {
                        serviceData.Districts.push({DistrictID : districtID});
                    });
                    ServiceData.push(serviceData);
                });
            } else if(ServiceBy == "PostalCode"){
                $('#ServiceLocationPAccordion .accordion-item').each(function () {
                    let serviceData = {
                            CountryID: $(this).attr('data-country-id'),
                            StateID: $(this).attr('data-state-id'),
                            Districts: [{
                                DistrictID : $(this).attr('data-district-id'),
                                PostalCodeIDs : $(this).find('.lstCSPSLPPostalCodes').val(),
                            }],
                        };
                    ServiceData.push(serviceData);
                });
            }
            formData.append('ServiceData',JSON.stringify(ServiceData));
            return formData;
        }
        $(document).on('click','#btnCSPSave',async function(){
            let StockPointID = $(this).attr('data-id');
            let status= await CSPformValidation();
            if(status){
                let formData=await GetCSPData();
                swal({
                    title: "Are you sure?",
                    text: "You want to " + (StockPointID ? "Update" : "Save") + " this Stock Point!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, " + (StockPointID ? "Update" : "Save") + " it!",
                    closeOnConfirm: false
                },async function(){
                    swal.close();
                    btnLoading($('#btnCSPSave'));
                    let postUrl= StockPointID ? "{{url('/')}}/admin/master/vendor/stock-points/edit/"+StockPointID : "{{url('/')}}/admin/master/vendor/stock-points/create";
                    $.ajax({
                        type:"post",
                        url:postUrl,
                        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                        data:formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        xhr: function() {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function(evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = (evt.loaded / evt.total) * 100;
                                    percentComplete=parseFloat(percentComplete).toFixed(2);
                                    $('#divProcessText').html(percentComplete+'% Completed.<br> Please wait for until upload process complete.');
                                    //Do something with upload progress here
                                }
                            }, false);
                            return xhr;
                        },
                        /* beforeSend: function() {
                            ajaxIndicatorStart("Please wait Upload Process on going.");

                            var percentVal = '0%';
                            setTimeout(() => {
                            $('#divProcessText').html(percentVal+' Completed.<br> Please wait for until upload process complete.');
                            }, 100);
                        }, */
                        error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                        complete: function(e, x, settings, exception){btnReset($('#btnCSPSave'));ajaxIndicatorStop();$("html, body").animate({ scrollTop: 0 }, "slow");},
                        success:function(response){
                            if(response.status==true){
                                ClearSPData();
                                $('#tblStockPoints').DataTable().ajax.reload();                                
                                toastr.success(response.message, "Success", { positionClass: "toast-top-right", containerId: "toast-top-right", showMethod: "slideDown", hideMethod: "slideUp", progressBar: !0});
                            }else{
                                toastr.error(response.message, "Failed", { positionClass: "toast-top-right", containerId: "toast-top-right", showMethod: "slideDown", hideMethod: "slideUp", progressBar: !0});
                            }
                        }
                    });
                });
            }
        });

        // Product Mapping Scripts

        let VendorProductData ={};
		const getVendorProducts = async () => {
			let FormData = {
				VendorID: $("#txtVendorID").val(),
			};

			let status = false;

			try {
				const response = await $.ajax({
					type: "post",
					url: "{{url('/')}}/admin/master/vendor/vendor-product-mapping/get/vendor-products",
					headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
					dataType: "json",
					data: FormData,
					async: true,
				});

				VendorProductData = response;
				status = true;
			} catch (error) {
				ajaxErrors(error);
			}
			return status;
		};
		const LoadPMProductData = async () => {
			$(".errors").html("");
			let VendorID=$("#txtVendorID").val();
			let status = await getVendorProducts();
			if(status){
				const tableBody = $("#tblVendProdMapping tbody");
				if(VendorID){
					let FormData = {
						PCID:[],
						PSCID:[],
					}
					$('#tblSupplyDetails tbody tr td.tdata').each(function(index){
						let t=JSON.parse($(this).html());
						if (!FormData.PCID.includes(t.PCID)) {
							FormData.PCID.push(t.PCID);
						}
						if (!FormData.PSCID.includes(t.PSCID)) {
							FormData.PSCID.push(t.PSCID);
						}
					});
					$.ajax({
						type: "post",
						url: "{{url('/')}}/admin/master/vendor/vendor-product-mapping/get/product-data",
						headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
						dataType: "json",
						data: FormData,
						async: false,
						error: function (e, x, settings, exception) {
							ajaxErrors(e, x, settings, exception);
						},
						complete: function (e, x, settings, exception) {},
						success: async function (response) {
							tableBody.html("");
							for (let SubCategory in response) {
								const SubCategoryRow = `<tr data-pcid="${response[SubCategory][0].PCID}" data-pscid="${response[SubCategory][0].PSCID}"><th colspan="3" class="text-dark font-weight-bold fs-15">${response[SubCategory][0].PCName} - ${SubCategory}</th></tr>`;
								tableBody.append(SubCategoryRow);
	
								for (let item of response[SubCategory]) {
									let newRow = `<tr data-product-id="${item.ProductID}" data-pcid="${item.PCID}" data-pscid="${item.PSCID}">
													<td><span class="pl-15">${item.ProductName}</span></td>
													<td class="align-middle">
														<div class="flex-grow-1 text-center icon-state switch-outline pt-10">
															<label class="switch">
																<input class="chkAvailable" type="checkbox"><span class="switch-state bg-secondary"></span>
															</label>
														</div>
													</td>
													<td>
														<div class="row justify-content-center">
															<div class="col-sm-4">
																<input class="form-control txtPrice" type="number" value="${item.PRate}" disabled>
																<span class="errors txtPrice-err"></span>
															</div>
														</div>
													</td>
												</tr>`;
									tableBody.append(newRow);
									if(VendorProductData.length > 0) {
										const matchingProduct = VendorProductData.find(product => product.ProductID === item.ProductID && product.VendorID === VendorID);
										if (matchingProduct) {
											const checkbox = tableBody.find(`[data-product-id="${item.ProductID}"] .chkAvailable`);
											const priceInput = tableBody.find(`[data-product-id="${item.ProductID}"] .txtPrice`);
		
											checkbox.prop('checked', true);
											priceInput.val(matchingProduct.VendorPrice).prop('disabled', false);
										}
									}
								}
							}
						},
	
					});
				}else{
					tableBody.html("");
				}
			}
		}
		const getPMPCategory=async()=>{
			let PCIDs = [];
			$('#tblSupplyDetails tbody tr td.tdata').each(function(index){
				let t=JSON.parse($(this).html());
				if (!PCIDs.includes(t.PCID)) {
					PCIDs.push(t.PCID);
				}
			});
            $('#lstPMPCategory').select2('destroy');
            $('#lstPMPCategory option').remove();
            $('#lstPMPCategory').append('<option value="" selected>Select a Product Category</option>');
            if(PCIDs.length > 0){
                $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/master/product/category/get/PCategory",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                    let selected="";
                    if(Item.PCID==$('#lstPMPCategory').attr('data-selected')){selected="selected";}
                    if(PCIDs.indexOf(Item.PCID)!=-1){
                        $('#lstPMPCategory').append('<option '+selected+' value="'+Item.PCID+'">'+Item.PCName+' </option>');
                    }
                    }
                }
                });
            }
            $('#lstPMPCategory').select2();
            if($('#lstPMPCategory').val()!=""){
                $('#lstPMPCategory').trigger('change');
            }
        }
        const getPMPSubCategory=async()=>{
            let PSCIDs = [];
            let PCID = $('#lstPMPCategory').val();
            $('#tblSupplyDetails tbody tr td.tdata').each(function(index){
                let t=JSON.parse($(this).html());
                if (PCID == t.PCID && !PSCIDs.includes(t.PSCID)) {
                PSCIDs.push(t.PSCID);
                }
            });
            $('#lstPMPSubCategory').select2('destroy');
            $('#lstPMPSubCategory option').remove();
            $('#lstPMPSubCategory').append('<option value="">Select a Product Sub Category</option>');
            if(PSCIDs.length > 0){
                $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/master/product/sub-category/get/PSubCategory",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                data : {PCID : PCID},
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success: function (response) {
                    for (let Item of response) {
                    let selected="";
                    if(Item.PSCID==$('#lstPMPSubCategory').attr('data-selected')){selected="selected";}
                    if(PSCIDs.indexOf(Item.PSCID)!=-1){
                        $('#lstPMPSubCategory').append('<option '+selected+' value="' + Item.PSCID + '">' + Item.PSCName + ' </option>');
                    }
                    }
                }
                });
            }
            $('#lstPMPSubCategory').select2();
        }
		const PMShowHideRows=async()=>{
			$(".errors").html("");
			let PCID = $('#lstPMPCategory').val();
			let PSCID = $('#lstPMPSubCategory').val();

			$("#tblVendProdMapping tbody tr").each(function () {
				if ((PCID && $(this).attr('data-pcid') !== PCID) || (PSCID && $(this).attr('data-pscid') !== PSCID)) {
					$(this).addClass('d-none');
				} else {
					$(this).removeClass('d-none');
				}
			});
        }
		const validatePMGetData=()=>{
			$(".errors").html("");
			let status = true;
			let productData=[];
			let nothingSelected = true;
			let VendorID = $("#txtVendorID").val();
			if(!VendorID) {
				$("#txtVendorID-err").html("Vendor Name is required");status = false;
			}
			$("#tblVendProdMapping tbody tr").each(function () {
				let isChecked = $(this).find(".chkAvailable").prop("checked");
				let Price = $(this).find(".txtPrice").val();
				if(isChecked){
					nothingSelected = false;
					if(!Price){
						$(this).find(".txtPrice-err").html("Price is required");status = false;
						return false;
					}else{
						let PData = {
							ProductID : $(this).attr("data-product-id"),
							PCID : $(this).attr("data-pcid"),
							PSCID : $(this).attr("data-pscid"),
							VendorPrice : $(this).find(".txtPrice").val(),
						}
						productData.push(PData);
					}
				}
			});
			if(VendorID && nothingSelected){
				toastr.error("Select a Product", "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0});
				status = false;
			}
			if(status==false){$("html, body").animate({ scrollTop: 0 }, "slow");}
			let formData = new FormData();
			formData.append('VendorID', VendorID);
			formData.append('ProductData', JSON.stringify(productData));
			return {formData , status};
		}
		$(document).on('change','#lstPMPCategory',function(){
            getPMPSubCategory();
            PMShowHideRows();
        });
		$(document).on('change','#lstPMPSubCategory',function(){
			PMShowHideRows();
        });
		$(document).on('change', '.chkAvailable', function() {
			const priceInput = $(this).closest('tr').find('.txtPrice');
			priceInput.prop('disabled', !this.checked);
		});
		$('#btnPMSave').click(async function(){
			let { formData , status } = await validatePMGetData();
            if(status){
                var postUrl="{{ url('/') }}/admin/master/vendor/vendor-product-mapping/update";
                swal({
                    title: "Are you sure?",
                    text: "You want @if($isEdit==true)Update @else Save @endif these Products!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, @if($isEdit==true)Update @else Save @endif it!",
                    closeOnConfirm: false
                },function(){
                    swal.close();
                    btnLoading($('#btnPMSave'));
                    $.ajax({
                        type:"post",
                        url:postUrl,
                        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                        data:formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                        complete: function(e, x, settings, exception){btnReset($('#btnPMSave'));ajaxIndicatorStop();$("html, body").animate({ scrollTop: 0 }, "slow");},
                        success:function(response){
                            document.documentElement.scrollTop = 0;
                            if(response.status==true){
                                toastr.success(response.message, "Success", { positionClass: "toast-top-right", containerId: "toast-top-right", showMethod: "slideDown", hideMethod: "slideUp", progressBar: !0});
                            }else{
                                toastr.error(response.message, "Failed", { positionClass: "toast-top-right", containerId: "toast-top-right", showMethod: "slideDown", hideMethod: "slideUp", progressBar: !0});
                            }
                        }
                    });
                });
            }
        });

        // Stock Update Scripts

        let stockUpdateTable = null;
		let VendorStockData ={};

		const getVendorStockData = async (vendorID) => {
			VendorStockData ={};
			let FormData = {VendorID: vendorID};
			let status = false;
			try {
				const response = await $.ajax({
					type: "post",
					url: "{{url('/')}}/admin/master/vendor/vendor-stock-update/get/vendor-stock-data",
					headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
					dataType: "json",
					data: FormData,
					async: true,
				});
				VendorStockData = response;
				status = true;
			} catch (error) {
				ajaxErrors(error);
			}
			return status;
		};
		const recreateSUTable=async ()=> {
			$('#divVendStockTable').empty();
			var table = $('<table>').addClass('table table-bordered').attr('id', 'tblVendStockUpdate');
			var thead = $('<thead>');
			var tbody = $('<tbody>');

			table.append(thead).append(tbody);
			$('#divVendStockTable').append(table);
		}
		const LoadStockData = async () => {
			$(".errors").html("");
			await recreateSUTable();
			let VendorID=$("#txtVendorID").val();
			let stockUpdateTable = $("#tblVendStockUpdate");
			let stockUpdateTableHead = $("#tblVendStockUpdate thead");
			let stockUpdateTableBody = $("#tblVendStockUpdate tbody");

			if(VendorID){
				let status = await getVendorStockData(VendorID);
				if(status){
					let FormData = {
						VendorID: VendorID,
					}
					$.ajax({
						type: "post",
						url: "{{url('/')}}/admin/master/vendor/vendor-stock-update/get/vendor-products",
						headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
						dataType: "json",
						data: FormData,
						async: false,
						error: function (e, x, settings, exception) {
							ajaxErrors(e, x, settings, exception);
						},
						complete: function (e, x, settings, exception) {},
						success: async function (response) {
							let StockPointData = response.StockPointData;
							let ProductData = response.ProductData;

							if (StockPointData.length > 0 && ProductData) {
								let html = `<tr>
												<th class="align-middle" rowspan="2">Products</th>
												<th class="align-middle" rowspan="2">UOM</th>`;

								for (let item of StockPointData) {
									html += `<th class="text-center align-middle" data-spid="${item.StockPointID}">${item.PointName}</th>`;
								}

								html += `</tr>
										<tr>`;

								for (let item of StockPointData) {
									html += `<th class="text-center align-middle">Qty</th>`;
								}	
								html += `</tr>`;

								stockUpdateTableHead.append(html);

								for (let SubCategory in ProductData) {

									for (let item of ProductData[SubCategory]) {
										let newRow = `<tr data-product-id="${item.ProductID}" data-pcid="${item.PCID}" data-pscid="${item.PSCID}">
														<td><span class="pl-15">${item.ProductName}</span></td>
														<td data-uom-id="${item.UID}">${item.UName} (${item.UCode})</td>`;

										for (let row of StockPointData) {
											let matchingData = VendorStockData.find(data =>
												data.ProductID === item.ProductID &&
												data.StockPointID === row.StockPointID
											);

											let qtyValue = matchingData ? matchingData.Qty : 0;
											let priceValue = matchingData ? matchingData.Price : item.VendorPrice;

											newRow += `<td class="align-middle divInput">
															<div class="row justify-content-center">
																<div class="col-6">
																	<input class="form-control txtQty" type="number" value="${qtyValue}" data-spid="${row.StockPointID}">
																	<span class="errors err-sm txtQty-err"></span>
																</div>
															</div>
														</td>`;
										}

										newRow += `</tr>`;
										stockUpdateTableBody.append(newRow);
									}
								}
								stockUpdateTable=$("#tblVendStockUpdate").dataTable({
									paging: false,
									fixedHeader: {
										header: true,
										footer: false
									},
									scrollY: 300,
									scrollX: true,
									scrollCollapse: true,
									fixedColumns: {
										leftColumns: 2
									}
								});
							}

						},
					});
				}
			}
		}
		const getSUPCategory=async()=>{
			let PCIDs = [];
			$('#tblSupplyDetails tbody tr td.tdata').each(function(index){
				let t=JSON.parse($(this).html());
				if (!PCIDs.includes(t.PCID)) {
					PCIDs.push(t.PCID);
				}
			});
            $('#lstSUPCategory').select2('destroy');
            $('#lstSUPCategory option').remove();
            $('#lstSUPCategory').append('<option value="" selected>Select a Product Category</option>');
			if(PCIDs.length > 0){
				$.ajax({
					type:"post",
					url:"{{url('/')}}/admin/master/product/category/get/PCategory",
					headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
					dataType:"json",
					async:true,
					error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
					complete: function(e, x, settings, exception){},
					success:function(response){
						for(let Item of response){
							let selected="";
							if(Item.PCID==$('#lstSUPCategory').attr('data-selected')){selected="selected";}
							if(PCIDs.indexOf(Item.PCID)!=-1){
								$('#lstSUPCategory').append('<option '+selected+' value="'+Item.PCID+'">'+Item.PCName+' </option>');
							}
						}
					}
				});
			}
            $('#lstSUPCategory').select2();
            if($('#lstSUPCategory').val()!=""){
                $('#lstSUPCategory').trigger('change');
            }
        }
        const getSUPSubCategory=async()=>{
            let PSCIDs = [];
            let PCID = $('#lstSUPCategory').val();
            $('#tblSupplyDetails tbody tr td.tdata').each(function(index){
                let t=JSON.parse($(this).html());
                if (PCID == t.PCID && !PSCIDs.includes(t.PSCID)) {
                PSCIDs.push(t.PSCID);
                }
            });
            $('#lstSUPSubCategory').select2('destroy');
            $('#lstSUPSubCategory option').remove();
			$('#lstSUPSubCategory').append('<option value="">Select a Product Sub Category</option>');
			if(PSCIDs.length > 0){
				$.ajax({
					type:"post",
					url:"{{url('/')}}/admin/master/product/sub-category/get/PSubCategory",
					headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
					dataType:"json",
					data : {PCID : PCID},
					async:true,
					error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
					complete: function(e, x, settings, exception){},
					success: function (response) {
						for (let Item of response) {
							let selected="";
							if(Item.PSCID==$('#lstSUPSubCategory').attr('data-selected')){selected="selected";}
							if(PSCIDs.indexOf(Item.PSCID)!=-1){
								$('#lstSUPSubCategory').append('<option '+selected+' value="' + Item.PSCID + '">' + Item.PSCName + ' </option>');
							}
						}
					}
				});
			}
            
            $('#lstSUPSubCategory').select2();
        }
		const SUShowHideRows=async()=>{
			$(".errors").html("");
			let PCID = $('#lstSUPCategory').val();
			let PSCID = $('#lstSUPSubCategory').val();

			$("#tblVendStockUpdate tbody tr").each(function () {
				(PCID && $(this).attr('data-pcid') !== PCID) || (PSCID && $(this).attr('data-pscid') !== PSCID) ? $(this).addClass('d-none') : $(this).removeClass('d-none');
			});
        }
		const validateSUGetData=()=>{
			let status = true;
			let StockData=[];
			let VendorID=$("#txtVendorID").val();
			if(!VendorID) {
				$("#lstVendor-err").html("Vendor Name is required");status = false;
			}else{
				$(".errors").each(function () {
					if ($(this).html()) {
						let Element = $(this).closest('.divInput').find('input');
						Element.focus();
						status = false;
						return false;
					}
				});
			}
			$("#tblVendStockUpdate tbody tr").each(function () {
				let stockData = {
					ProductID: $(this).attr("data-product-id"),
					UOMID: $(this).find('td:eq(1)').attr("data-uom-id"),
					PCID: $(this).attr("data-pcid"),
					PSCID: $(this).attr("data-pscid"),
				};
				$(this).find(".txtQty").each(function () {
					let stockPointData = {
						StockPointID: $(this).attr("data-spid"),
						Qty: $(this).val(),
						Price: $(this).closest('tr').find(`.txtPrice[data-spid='${$(this).attr("data-spid")}']`).val(),
					};
					if (stockData.ProductID) {
						StockData.push({ ...stockData, ...stockPointData });
					}
				});
			});
			let formData = new FormData();
			formData.append('VendorID', VendorID);
			formData.append('StockData', JSON.stringify(StockData));
			return {formData , status};
		}
		$(document).on('change','#lstSUPCategory',function(){
            getSUPSubCategory();
			SUShowHideRows();
        });
		$(document).on('change','#lstSUPSubCategory',function(){
			SUShowHideRows();
        });
		$(document).on('input', '.txtQty', function () {
			let errorElement = $(this).closest('.divInput').find('.txtQty-err');
			let inputValue = parseFloat($(this).val());
			if (isNaN(inputValue)) {inputValue = 0;}
			if (inputValue < 0) {errorElement.text("Quantity cannot be less than 0");} else {errorElement.text("");}
			$(this).val(inputValue);
		});
		$(document).on('input', '.txtPrice', function () {
			let errorElement = $(this).closest('.divInput').find('.txtPrice-err');
			let inputValue = parseFloat($(this).val());
			if (isNaN(inputValue)) {inputValue = 0;}
			if ($(this).val() < 0) {errorElement.text("Price cannot be less than 0");} else {errorElement.text("");}
			$(this).val(inputValue);
		});

		$('#btnSUSave').click(async function(){
			let { formData , status } = await validateSUGetData();
            if(status){
				var postUrl="{{ url('/') }}/admin/master/vendor/vendor-stock-update/update";
                swal({
                    title: "Are you sure?",
                    text: "You want @if($isEdit==true)Update @else Save @endif this Stock Update!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, @if($isEdit==true)Update @else Save @endif it!",
                    closeOnConfirm: false
                },function(){
                    swal.close();
                    btnLoading($('#btnSUSave'));
                    $.ajax({
                        type:"post",
                        url:postUrl,
                        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                        data:formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                        complete: function(e, x, settings, exception){btnReset($('#btnSUSave'));ajaxIndicatorStop();$("html, body").animate({ scrollTop: 0 }, "slow");},
                        success:function(response){
                            document.documentElement.scrollTop = 0;
                            if(response.status==true){
                                toastr.success(response.message, "Success", { positionClass: "toast-top-right", containerId: "toast-top-right", showMethod: "slideDown", hideMethod: "slideUp", progressBar: !0 });                                
                            }else{
                                toastr.error(response.message, "Failed", { positionClass: "toast-top-right", containerId: "toast-top-right", showMethod: "slideDown", hideMethod: "slideUp", progressBar: !0 });
                            }
                        }
                    });
                });
            }
        });

        // Registration Scripts

        let Images={
            vehicle:{},
            documents:{}
        };
        let vehiclesCount=1;
        let vehiclesData={};
        var ProductDetails=[];
        let deletedImages={
            documents:[],
            vehicle:[],

        };
        let TotalImagesCount=0;
        const init=async()=>{
            showTabs();
            getVendorCategory();
            getVendorType();
            getCountry({},'lstCountry');
            getPCategory();
            getVendor();
            setTimeout(() => {
                $('#btnGSearchPostalCode').trigger('click')
            }, 100);
        }
        const showTabs=async()=>{
            $('.woo-commerce-style .tab-contents').hide('slow');
            let activeTabs=$('.woo-commerce-style ul.woo-commerce-style li.active a').attr('href');
            $('.woo-commerce-style '+activeTabs).show('slow')
            if(activeTabs=="#attributes-tab"){

                let cid=$('#lstCategory').val();
                let scid=$('#lstSubCategory').val();
                if(cid!="" && scid!=""){
                    $('.woo-commerce-style '+activeTabs).attr('data-status',1)
                }else{
                    $('.woo-commerce-style '+activeTabs).attr('data-status',0)
                }
            }else if(activeTabs=="#variations-tab"){
                $('.woo-commerce-style '+activeTabs).attr('data-status',0)
                if($('#variationAccordion .accordion-item').length>0){
                    $('.woo-commerce-style '+activeTabs).attr('data-status',1)
                }else{
                    let variationList=await getVariationList();
                    if(Object.keys(variationList).length>0){
                        $('.woo-commerce-style '+activeTabs).attr('data-status',1)
                    }
                }
            }
        }
        const generateUUID=()=> {
            var d = new Date().getTime();
            var uuid = 'Ixxxxxxxx-xxxxxx-xx'.replace(/[xy]/g, function(c) {
                var r = (d + Math.random()*16)%16 | 0;
                d = Math.floor(d/16);
                return (c=='x' ? r : (r&0x3|0x8)).toString(16);
            });
            return uuid;
        }
        const generateVariationID=()=> {
            var d = new Date().getTime();
            var uuid = 'Ixxxxxxxxxx-xx'.replace(/[xy]/g, function(c) {
                var r = (d + Math.random()*16)%16 | 0;
                d = Math.floor(d/16);
                return (c=='x' ? r : (r&0x3|0x8)).toString(16);
            });
            return uuid;
        }
        const tmpImageUpload=async(formData)=>{
            $.ajax({
                type: "post",
                url: "{{url('/')}}/tmp/upload-image",
                headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')},
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType:"json",
                async:true,
                error: function(e, x, settings, exception) {ajaxErrors(e, x, settings, exception);},
                success:function(response){
                    response.referData=JSON.parse(response.referData);
                    response.referData.isTemp=1;
                    let referData=response.referData;

                    if(referData.pType=="logo"){
                        if($('#' + response.referData.id).length>0){
                            try {
                                if(Images.productImage.data.referData.isTemp==0){
                                    TotalImagesCount++;
                                }
                            } catch (error) {
                                TotalImagesCount++;
                            }
                            $('#' + response.referData.id).attr('data-remove',0);
                            $('#' + response.referData.id).parent().find('img').attr('src', "{{url('/')}}/"+response.uploadPath)
                            Images.productImage.data=response;
                            Images.productImage.isDeleted=0;
                        }
                    }else if(referData.pType=="vehicle-images"){
                        if(Images.vehicle[referData.uuid]==undefined){
                            Images.vehicle[referData.uuid]={};
                        }
                        Images.vehicle[referData.uuid][referData.imgID]=response;
                        AddVehicleImages(referData.uuid,referData.imgID,response);

                    }else if(referData.pType=="vendor-documents"){
                        Images.documents[referData.imgID]=response;
                        AddVendorDocuments(referData.imgID,response);

                    }
                }
            });
        }
        const loadData=async(data)=>{
            let VehicleTypes=await getVehicleType();
            if(data.length>0){
                data=data[0];
                for(let item of data.Vehicles){
                    await AddVehicle(item.UUID,VehicleTypes);
                }
                for(let item of data.SupplyDetails){
                    let data={
                        PCID:item.PCID,
                        PCName:item.PCName,
                        PSCID:item.PSCID,
                        PSCName:item.PSCName
                    }
                    let html = '<tr >';
                        html += '<td>' + data.PCName + '</td>';
                        html += '<td data-id="' + data.PSCID + '">' + data.PSCName + '</td>';
                        html += '<td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger btnDeleteSupply"><i class="fa fa-trash"></i></button></td>';
                        html += '<td class="d-none tdata">' + JSON.stringify({ PCID: data.PCID, PSCID: data.PSCID }) + '</td>';
                        html += '</tr>';
                        $('#tblSupplyDetails tbody').append(html);
                }
                for(let item of data.Vehicles){
                    let uuid=item.UUID;
                    $('#txtVehicleNumber-'+uuid).val(item.VNumber);
                    $('#lstVehicleType-'+uuid).attr('data-selected',item.VTypeID);
                    $('#lstVehicleBrand-'+uuid).attr('data-selected',item.VBrandID);
                    $('#lstVehicleModel-'+uuid).attr('data-selected',item.VModelID);
                    $('#txtVehicleLength-'+uuid).val(item.VLength);
                    $('#txtVehicleDepth-'+uuid).val(item.VDepth);
                    $('#txtVehicleWidth-'+uuid).val(item.VWidth);
                    $('#txtVehicleCapacity-'+uuid).val(item.VCapacity);
                    for(let image of item.Images){
                        item.gImage=image.gImage.replace("{{url('/')}}/","");
                        let tdata={
                            uploadPath:image.gImage,
                            fileName:image.fileName,
                            ext:image.ext,
                            referData:{isTemp:0,imgID:image.ImgID,pType:"vehicle-images"}
                        }
                        if(Images.vehicle[uuid]==undefined){
                            Images.vehicle[uuid]={};
                        }
                        Images.vehicle[uuid][image.ImgID]=tdata;
                        AddVehicleImages(uuid,image.ImgID,tdata);
                    }
                    setTimeout(() => {
                        $('#lstVehicleType-'+uuid).val(item.VTypeID).trigger('change');

                    }, 10);
                }
                for(let item of data.Documents){
                    item.documents=item.documents.replace("{{url('/')}}/","");
                    let tdata={
                        uploadPath:item.documents,
                        fileName:item.fileName,
                        DocName:item.DocName,
                        ext:item.ext,
                        referData:{isTemp:0,imgID:item.ImgID,pType:"vendor-documents"}
                    }
                    Images.documents[item.ImgID]=tdata;
                    AddVendorDocuments(item.ImgID,tdata);
                }
                setTimeout(() => {
                    $('.txtVehicleNumber').trigger('keyup');
                }, 10);
            }
        }
        const getVendor=async()=>{
            $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/master/vendor/vendors/get/vendor",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:{VendorID:"<?php if($isEdit){ echo $VendorID;} ?>"},
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    loadData(response);
                }
            });
        }
        const AddVehicle=async(tmpUUID=null,tmpVehicleTypes=null)=>{
            let uuid=tmpUUID!=null?tmpUUID:generateUUID();
            let VehicleTypes=tmpVehicleTypes!=null?tmpVehicleTypes:await getVehicleType();
            let html='';
                html+='<div class="accordion-item" data-uuid="'+uuid+'">';
                    html+='<h5 class="accordion-header" id="'+uuid+'-heading">';
                        html+='<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#'+uuid+'" aria-expanded="false" aria-controls="'+uuid+'"> <span class="vehicle-name">Vehicle '+vehiclesCount+'</span><span class="options"> <span class="vehicle-trash trash" data-uuid="'+uuid+'"><i class="fa fa-trash"></i></span></span> </button>';
                    html+='</h5>';
                    html+='<div id="'+uuid+'" class="accordion-collapse collapse" aria-labelledby="'+uuid+'-heading" data-bs-parent="#vehicleAccordion">';
                        html+='<div class="accordion-body">';
                            html+='<div class="row mt-10">';
                                html+='<div class="col-sm-3 mt-20">';
                                    html+='<div class="form-group">';
                                        html+='<label for="txtVehicleNumber-'+uuid+'"> Vehicle Number </label>';
                                        html+='<input type="text" class="form-control   txtVehicleNumber" data-uuid="'+uuid+'" id="txtVehicleNumber-'+uuid+'" value="">';
                                        html+='<div class="errors err-sm" id="txtVehicleNumber-'+uuid+'-err"></div>';
                                    html+='</div>';
                                html+='</div>';
                                html+='<div class="col-sm-3 mt-20">';
                                    html+='<div class="form-group">';
                                        html+='<label for="lstVehicleType-'+uuid+'"> Vehicle Type <span class="required"> * </span> <span  class="addOption btnReloadVehicleType"  title="Reload Vehicle Type" ><i class="fa fa-refresh"></i></span>   <span class="addOption btnAddVehicleType"  title="Add New Vehicle Type" ><i class="fa fa-plus"></i></span> </label>';
                                        html+='<select class="form-control   dselect2 lstVehicleType" data-uuid="'+uuid+'" id="lstVehicleType-'+uuid+'" data-selected="">';
                                            html+='<option value="">Select a Vehicle Type</option>';
                                            for(let item of VehicleTypes){
                                                html+='<option value="'+item.VehicleTypeID+'">'+item.VehicleType+'</option>';
                                            }
                                        html+='</select>';
                                        html+='<div class="errors err-sm" id="lstVehicleType-'+uuid+'-err"></div>';
                                    html+='</div>';
                                html+='</div>';
                                html+='<div class="col-sm-3 mt-20">';
                                    html+='<div class="form-group">';
                                        html+='<label for="lstVehicleBrand-'+uuid+'"> Vehicle Brand <span class="required"> * </span> <span  class="addOption btnReloadVehicleBrand"   title="Reload Vehicle Brand" ><i class="fa fa-refresh"></i></span>   <span class="addOption btnAddVehicleBrand"  title="Add New Vehicle Brand" ><i class="fa fa-plus"></i></span> </label>';
                                        html+='<select class="form-control   dselect2 lstVehicleBrand" data-uuid="'+uuid+'" id="lstVehicleBrand-'+uuid+'" data-vehicle-type-id="lstVehicleType-'+uuid+'" data-selected="">';
                                            html+='<option value="">Select a Vehicle Brand</option>';
                                        html+='</select>';
                                        html+='<div class="errors err-sm" id="lstVehicleBrand-'+uuid+'-err"></div>';
                                    html+='</div>';
                                html+='</div>';
                                html+='<div class="col-sm-3 mt-20">';
                                    html+='<div class="form-group">';
                                        html+='<label for="lstVehicleModel-'+uuid+'"> Vehicle Model <span class="required"> * </span> <span  class="addOption btnReloadVehicleModel" id="btnReloadVehicleModel-'+uuid+'"  title="Reload Vehicle Model" ><i class="fa fa-refresh"></i></span>   <span class="addOption btnAddVehicleModel" id="btnAddVehicleModel-'+uuid+'" title="Add New Vehicle Model" ><i class="fa fa-plus"></i></span> </label>';
                                        html+='<select class="form-control   dselect2 lstVehicleModel" data-uuid="'+uuid+'" id="lstVehicleModel-'+uuid+'" data-vehicle-type-id="lstVehicleType-'+uuid+'" data-vehicle-brand-id="lstVehicleBrand-'+uuid+'" data-selected="">';
                                            html+='<option value="">Select a Vehicle Model</option>';
                                        html+='</select>';
                                        html+='<div class="errors err-sm" id="lstVehicleModel-'+uuid+'-err"></div>';
                                    html+='</div>';
                                html+='</div>';
                                html+='<div class="col-sm-3 mt-20">';
                                    html+='<div class="form-group">';
                                        html+='<label class="txtVehicleLength-'+uuid+'"> Vehicle Length <span class="required"> * </span></label>';
                                        html+='<div class="input-group">';
                                            html+='<input type="number" class="form-control  " data-uuid="'+uuid+'" id="txtVehicleLength-'+uuid+'" value="">';
                                            html+='<span class="input-group-text">in meters</span>';
                                        html+='</div>';
                                        html+='<div class="errors err-sm" id="txtVehicleLength-'+uuid+'-err"></div>';
                                    html+='</div>';
                                html+='</div>';
                                html+='<div class="col-sm-3 mt-20">';
                                    html+='<div class="form-group">';
                                        html+='<label class="txtVehicleDepth-'+uuid+'"> Vehicle Depth <span class="required"> * </span></label>';
                                        html+='<div class="input-group">';
                                            html+='<input type="number" class="form-control  " data-uuid="'+uuid+'" id="txtVehicleDepth-'+uuid+'" value="">';
                                            html+='<span class="input-group-text">in meters</span>';
                                        html+='</div>';
                                        html+='<div class="errors err-sm" id="txtVehicleDepth-'+uuid+'-err"></div>';
                                    html+='</div>';
                                html+='</div>';
                                html+='<div class="col-sm-3 mt-20">';
                                    html+='<div class="form-group">';
                                        html+='<label class="txtVehicleWidth-'+uuid+'"> Vehicle Width <span class="required"> * </span></label>';
                                        html+='<div class="input-group">';
                                            html+='<input type="number" class="form-control  " data-uuid="'+uuid+'" id="txtVehicleWidth-'+uuid+'" value="">';
                                            html+='<span class="input-group-text">in meters</span>';
                                        html+='</div>';
                                        html+='<div class="errors err-sm" id="txtVehicleWidth-'+uuid+'-err"></div>';
                                    html+='</div>';
                                html+='</div>';
                                html+='<div class="col-sm-3 mt-20">';
                                    html+='<div class="form-group">';
                                        html+='<label for="txtVehicleCapacity-'+uuid+'"> Vehicle Capacity <span class="required"> * </span> </label>';
                                        html+='<div class="input-group">';
                                            html+='<input type="number" class="form-control  " data-uuid="'+uuid+'" id="txtVehicleCapacity-'+uuid+'" value="">';
                                            html+='<span class="input-group-text">in Kg</span>';
                                        html+='</div>';
                                        html+='<div class="errors err-sm" id="txtVehicleCapacity-'+uuid+'-err"></div>';
                                    html+='</div>';
                                html+='</div>';
                            html+='</div>';
                            html+='<div class="row mt-20">';
                                html+='<div class="col-12 text-center fw-600"> Vehicle Images</div>';
                                html+='<div class="col-12 mt-10">';
                                    html+='<div class="vehicle_images_container">';
                                        html+='<ul class="vehicle_images"  data-uuid="'+uuid+'" id="VImages-'+uuid+'">';
                                        html+='</ul>';
                                    html+='</div>';
                                html+='</div>';
                                html+='<div class="col-12 mt-10 text-center"><button class="btn btn-sm btn-outline-primary addVehicleImages"  data-uuid="'+uuid+'">Add Vehicle Images</button></div>';
                            html+='</div>';
                        html+='</div>';
                    html+='</div>';
                html+='</div>';
            $('#vehicleAccordion').append(html);
                setTimeout(() => {
                    $('#txtVImage-'+uuid).dropify();
                    $('.dselect2[data-uuid="'+uuid+'"]').select2();
                }, 10);
            vehiclesCount++;
        }
        const AddVehicleImages=async(uuid,imgID,tdata)=>{
            let html='';
            if($('ul#VImages-'+uuid+' li[data-attachment_id="'+imgID+'"]').length>0){
                    html+='<img loading="lazy" src="{{url("/")}}/'+tdata.uploadPath+'">';
                    html+='<div class="actions">';
                        html+='<ul class="actions">';
                            html+='<li><a href="{{url("/")}}/'+tdata.uploadPath+'" data-uuid="'+uuid+'" data-attachment_id="'+imgID+'" data-lightbox="Product Gallery" class="view" title="view image"><i class="fa fa-eye" aria-hidden="true"></i></a></li>';
                            html+='<li><a href="#" class="delete" data-uuid="'+uuid+'" data-product-type="vehicle-images" data-attachment_id="'+imgID+'" title="Delete image"><i class="fa fa-trash" aria-hidden="true"></i></a></li>';
                        html+='</ul>';
                    html+='</div>';
                $('ul#VGalleries-'+uuid+' li[data-attachment_id="'+imgID+'"]').html(html);
            }else{
                html+='<li class="image" data-attachment_id="'+imgID+'" style="cursor: default;">';
                    html+='<img loading="lazy" src="{{url("/")}}/'+tdata.uploadPath+'">';
                    html+='<div class="actions">';
                        html+='<ul class="actions">';
                            html+='<li><a href="{{url("/")}}/'+tdata.uploadPath+'" data-uuid="'+uuid+'" data-attachment_id="'+imgID+'" data-lightbox="Product Gallery" class="view" title="view image"><i class="fa fa-eye" aria-hidden="true"></i></a></li>';
                            html+='<li><a href="#" class="delete" data-product-type="vehicle-images" data-uuid="'+uuid+'" data-attachment_id="'+imgID+'" title="Delete image"><i class="fa fa-trash" aria-hidden="true"></i></a></li>';
                        html+='</ul>';
                    html+='</div>';
                html+='</li>';
                $('ul#VImages-'+uuid).append(html);
            }
        }
        const AddVendorDocumentsWithDocName = async (imgID, data) => {
            let html = '';
            if ($(`#divDocuments .vendor-documents[data-attachment_id="${imgID}"]`).length > 0) {
                html += `
                    <div class="form-group">
                        <input type="file" class="dropify" data-id="${imgID}" id="txtVD-${imgID}" data-product-type="vendor-documents"
                            data-default-file="${data.uploadPath}" accept="<?php echo "." . implode(",.", $FileTypes['category']['Documents']) ?>"
                            data-allowed-file-extensions="<?php echo implode(" ", $FileTypes['category']['Documents']) ?>">
                    </div>
                    <div class="form-group mt-5">
                        <input type="text" class="form-control" id="docName-${imgID}" placeholder="Doc Name" value="${data.DocName ? data.DocName : ""}">
                    </div>`;
                $(`#divDocuments .vendor-documents[data-attachment_id="${imgID}"]`).append(html);
            } else {
                html += `
                    <div class="col-md-2 m-5 vendor-documents" data-attachment_id="${imgID}">
                        <div class="form-group">
                            <input type="file" class="dropify" data-id="${imgID}" id="txtVD-${imgID}" data-product-type="vendor-documents"
                                data-default-file="${data.uploadPath}" accept="<?php echo "." . implode(",.", $FileTypes['category']['Documents']) ?>"
                                data-allowed-file-extensions="<?php echo implode(" ", $FileTypes['category']['Documents']) ?>">
                        </div>
                        <div class="form-group mt-5">
                            <input type="text" class="form-control" id="docName-${imgID}" placeholder="Doc Name" value="${data.DocName ? data.DocName : ""}">
                        </div>
                    </div>`;
                $('#divDocuments').append(html);
            }

            setTimeout(() => {
                $(`#txtVD-${imgID}`).dropify();
            }, 10);
        };
        const AddVendorDocuments = async (imgID, data) => {
            let html = '';
            if ($(`#divDocuments .vendor-documents[data-attachment_id="${imgID}"]`).length > 0) {
                html += `
                    <div class="form-group">
                        <input type="file" class="dropify" data-id="${imgID}" id="txtVD-${imgID}" data-product-type="vendor-documents"
                            data-default-file="${data.uploadPath}" accept="<?php echo "." . implode(",.", $FileTypes['category']['Documents']) ?>"
                            data-allowed-file-extensions="<?php echo implode(" ", $FileTypes['category']['Documents']) ?>">
                    </div>`;
                $(`#divDocuments .vendor-documents[data-attachment_id="${imgID}"]`).append(html);
            } else {
                html += `
                    <div class="col-md-2 m-5 vendor-documents" data-attachment_id="${imgID}">
                        <div class="form-group">
                            <input type="file" class="dropify" data-id="${imgID}" id="txtVD-${imgID}" data-product-type="vendor-documents"
                                data-default-file="${data.uploadPath}" accept="<?php echo "." . implode(",.", $FileTypes['category']['Documents']) ?>"
                                data-allowed-file-extensions="<?php echo implode(" ", $FileTypes['category']['Documents']) ?>">
                        </div>
                    </div>`;
                $('#divDocuments').append(html);
            }

            setTimeout(() => {
                $(`#txtVD-${imgID}`).dropify();
            }, 10);
        };

        const updateVehicleAccordionTitle=async()=>{
            let rowIndex=1;
            $('#vehicleAccordion .accordion-item').each(function(index){
                let uuid1=$(this).attr('data-uuid');
                let Title=$('#txtVehicleNumber-'+uuid1).val();
                if(Title=="" || Title==undefined || Title==null ){
                    Title="Vehicle "+rowIndex;
                    rowIndex++;
                }
                $('#vehicleAccordion .accordion-item[data-uuid="'+uuid1+'"] .accordion-header button span.vehicle-name').html(Title);
            });
            vehiclesCount=rowIndex;
        }
        const getVendorCategory=async()=>{
            $('#lstCategory').select2('destroy');
            $('#lstCategory option').remove();
            $('#lstCategory').append('<option value="" selected>Select a Vendor Category</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/master/vendor/vendors/get/vendor-category",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.VCID==$('#lstCategory').attr('data-selected')){selected="selected";}
                        $('#lstCategory').append('<option '+selected+' value="'+Item.VCID+'">'+Item.VCName+' </option>');
                    }
                    if($('#lstCategory').val()!=""){
                        $('#lstCategory').trigger('change');
                    }
                }
            });
            $('#lstCategory').select2();
        }
        const getVendorType=async()=>{
            $('#lstVendorType').select2('destroy');
            $('#lstVendorType option').remove();
            $('#lstVendorType').append('<option value="" selected>Select a Vendor Type</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/master/vendor/vendors/get/vendor-type",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.VendorTypeID==$('#lstVendorType').attr('data-selected')){selected="selected";}
                        $('#lstVendorType').append('<option '+selected+' value="'+Item.VendorTypeID+'">'+Item.VendorType+' </option>');
                    }
                    if($('#lstVendorType').val()!=""){
                        $('#lstVendorType').trigger('change');
                    }
                }
            });
            $('#lstVendorType').select2();
        }
        const getCity=async(data)=>{
            return await new Promise((resolve,reject)=>{
                $.ajax({
                    type:"post",
                    url:"{{url('/')}}/get/city",
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    data:data,
                    dataType:"json",
                    async:true,
                    error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);resolve([])},
                    complete: function(e, x, settings, exception){},
                    success:function(response){
                        resolve(response)
                    }
                });
            });
        }
        const getTaluks=async(data,id)=>{
            $('#'+id).select2('destroy');
            $('#'+id+' option').remove();
            $('#'+id).append('<option value="">Select a Taluk</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/taluks",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:data,
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);resolve([])},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.TalukID==$('#'+id).attr('data-selected')){selected="selected";}
                        $('#'+id).append('<option '+selected+' data-taluk=""  value="'+Item.TalukID+'">'+Item.TalukName+' </option>');
                    }
                    if($('#'+id).val()!=""){
                        $('#'+id).trigger('change');
                    }
                }
            });
            $('#'+id).select2();
        }
        const getDistricts=async(data,id)=>{
            let Data = [];
            $('#'+id).select2('destroy');
            $('#'+id+' option').remove();
            $('#'+id).append('<option value="">Select a District</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/districts",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:data,
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);resolve([])},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.DistrictID==$('#'+id).attr('data-selected')){selected="selected";}
                        $('#'+id).append('<option '+selected+' data-taluk=""  value="'+Item.DistrictID+'">'+Item.DistrictName+' </option>');
                    }
                    if($('#'+id).val()!=""){
                        $('#'+id).trigger('change');
                    }
                    Data = response;
                }
            });
            $('#'+id).select2();
            return Data;
        }
        const getStates=async(data,id)=>{
            $('#'+id).select2('destroy');
            $('#'+id+' option').remove();
            $('#'+id).append('<option value="">Select a State</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/states",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:data,
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);resolve([])},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.StateID==$('#'+id).attr('data-selected')){selected="selected";}
                        $('#'+id).append('<option '+selected+'  value="'+Item.StateID+'">'+Item.StateName+' </option>');
                    }
                    if($('#'+id).val()!=""){
                        $('#'+id).trigger('change');
                    }
                }
            });
            $('#'+id).select2();
        }
        const getCountry=async(data,id)=>{
            $('#'+id).select2('destroy');
            $('#'+id+' option').remove();
            $('#'+id).append('<option value="">Select a Country</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/country",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:data,
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);resolve([])},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.CountryID==$('#'+id).attr('data-selected')){selected="selected";}
                        $('#'+id).append('<option '+selected+' value="'+Item.CountryID+'">'+Item.CountryName+' </option>');
                    }
                    if($('#'+id).val()!=""){
                        $('#'+id).trigger('change');
                    }
                }
            });
            $('#'+id).select2();
        }
        const getVehicleType=async()=>{
            return await new Promise((resolve,reject)=>{
                $.ajax({
                    type:"post",
                    url:"{{url('/')}}/get/vehicle-type",
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    dataType:"json",
                    async:true,
                    error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);resolve([])},
                    complete: function(e, x, settings, exception){},
                    success:function(response){
                        resolve(response)
                    }
                });
            });
        }
        const getVehicleBrand=async(data,id)=>{
            $('#'+id).select2('destroy');
            $('#'+id+' option').remove();
            $('#'+id).append('<option value="">Select a vehicle brand</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/vehicle-brand",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:data,
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);resolve([])},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.VehicleBrandID==$('#'+id).attr('data-selected')){selected="selected";}
                        $('#'+id).append('<option '+selected+' value="'+Item.VehicleBrandID+'">'+Item.VehicleBrandName+' </option>');
                    }
                    if($('#'+id).val()!=""){
                        $('#'+id).trigger('change');
                    }
                }
            });
            $('#'+id).select2();
        }
        const getVehicleModal=async(data,id)=>{
            $('#'+id).select2('destroy');
            $('#'+id+' option').remove();
            $('#'+id).append('<option value="">Select a vehicle model</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/vehicle-model",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:data,
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);resolve([])},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.VehicleModelID==$('#'+id).attr('data-selected')){selected="selected";}
                        $('#'+id).append('<option '+selected+' value="'+Item.VehicleModelID+'">'+Item.VehicleModel+' </option>');
                    }
                    if($('#'+id).val()!=""){
                        $('#'+id).trigger('change');
                    }
                }
            });
            $('#'+id).select2();
        }

        const getPCategory=async()=>{
            $('#lstPCategory').select2('destroy');
            $('#lstPCategory option').remove();
            $('#lstPCategory').append('<option value="" selected>Select a Product Category</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/master/product/category/get/PCategory",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.PCID==$('#lstPCategory').attr('data-selected')){selected="selected";}
                        $('#lstPCategory').append('<option '+selected+' value="'+Item.PCID+'">'+Item.PCName+' </option>');
                    }
                }
            });
            $('#lstPCategory').select2();
            if($('#lstPCategory').val()!=""){
                $('#lstPCategory').trigger('change');
            }
        }
        const getPSubCategory=async()=>{
            let PCID = $('#lstPCategory').val();
            $('#lstPSubCategory').select2('destroy');
            $('#lstPSubCategory option').remove();
            $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/master/product/sub-category/get/PSubCategory",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                data : {PCID : PCID},
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success: function (response) {
                    for (let Item of response) {
                        let isAlreadyInTable = isPSCIDInTable(Item.PSCID);
                        if (!isAlreadyInTable) {
                            $('#lstPSubCategory').append('<option value="' + Item.PSCID + '">' + Item.PSCName + ' </option>');
                        }
                    }
                }
            });
            $('#lstPSubCategory').select2();
        }
        const isPSCIDInTable=(PSCID)=> {
            let isExists = false;
            $('#tblSupplyDetails tbody tr').each(function (index) {
                let existingValue = $(this).find('td:eq(1)').attr('data-id');
                if (existingValue === PSCID.trim()) {
                    isExists = true;
                    return false;
                }
            });
            return isExists;
        }
        const formValidation=async()=>{
            $('.errors').html('');
            let status=true;
            let isGeneral=false;
            let isAddress=false;
            let isVehicles=false;
            let data={}
            data.VendorName=$('#txtVendorName').val();
            data.CoName=$('#txtCoName').val();
            data.GSTNo=$('#txtGSTNo').val();
            data.CID=$('#lstCategory').val();
            data.VendorType=$('#lstVendorType').val();
            data.Email=$('#txtEmail').val();
            data.MobileNumber1=$('#txtMobileNumber1').val();
            data.MobileNumber2=$('#txtMobileNumber2').val();
            data.CreditDays=$('#txtCreditDays').val();
            data.CreditLimit=$('#txtCreditLimit').val();
            data.Address=$('#txtAddress').val();
            data.PostalCode=$('#lstCity option:selected').attr('data-postal');
            data.CityID=$('#lstCity').val();
            data.TalukID=$('#lstTaluk').val();
            data.DistrictID=$('#lstDistricts').val();
            data.StateID=$('#lstState').val();
            data.CountryID=$('#lstCountry').val();
            data.CommissionPercentage=$('#txtCommissionPercentage').val();
            if(data.VendorName==""){
                $('#txtVendorName-err').html('Vendor name is required.');status=false;
            }else if(data.VendorName.length<2){
                $('#txtVendorName-err').html('Vendor Name must be greater than 2 characters');status=false;
            }else if(data.VendorName.length>100){
                $('#txtVendorName-err').html('Vendor Name may not be greater than 100 characters');status=false;
            }
            /* if(data.GSTNo==""){
                $('#txtGSTNo-err').html('GST Number is required.');status=false;isGeneral=true;
            } */
            if(data.CID==""){
                $('#lstCategory-err').html('Category is required.');status=false;isGeneral=true;
            }
            if(data.VendorType==""){
                $('#lstVendorType-err').html('Vendor Type is required.');status=false;isGeneral=true;
            }
            if(!data.CoName){
                $('#txtCoName-err').html('Company Name is required.');status=false;isGeneral=true;
            }
            if(!data.Email){
                $('#txtEmail-err').html('Email is required.');status=false;isGeneral=true;
            }

            if(data.CreditDays==""){
                $('#txtCreditDays-err').html('Credit Days is required.');status=false;isGeneral=true;
            }else if($.isNumeric(data.CreditDays)==false){
                $('#txtCreditDays-err').html('Credit Days is must be numeric value');status=false;isGeneral=true;
            }else if(parseFloat(data.CreditDays)<0){
                $('#txtCreditDays-err').html('Credit Days is must be equal or  greater than 0.');status=false;isGeneral=true;
            }
            if(data.CreditLimit==""){
                $('#txtCreditLimit-err').html('Credit Limit is required.');status=false;isGeneral=true;
            }else if($.isNumeric(data.CommissionPercentage)==false){
                $('#txtCreditLimit-err').html('Credit Limit is must be numeric value');status=false;isGeneral=true;
            }else if(parseFloat(data.CommissionPercentage)<0){
                $('#txtCreditLimit-err').html('Credit Limit is must be equal or  greater than 0.');status=false;isGeneral=true;
            }
            if(data.CommissionPercentage==""){
                $('#txtCommissionPercentage-err').html('Commission Percentage is required.');status=false;isGeneral=true;
            }else if($.isNumeric(data.CommissionPercentage)==false){
                $('#txtCommissionPercentage-err').html('Commission Percentage is must be numeric value');status=false;isGeneral=true;
            }else if(parseFloat(data.CommissionPercentage)<0){
                $('#txtCommissionPercentage-err').html('Commission Percentage is must be equal or  greater than 0.');status=false;isGeneral=true;
            }else if(parseFloat(data.CommissionPercentage)>100){
                $('#txtCommissionPercentage-err').html('Commission Percentage is must be  not greater than 100.');status=false;isGeneral=true;
            }
            if(!data.PostalCode){
                $('#txtPostalCode-err').html('Postal Code is required.');status=false;isAddress=true;
            }
            if(data.CityID==""){
                $('#lstCity-err').html('City is required.');status=false;isAddress=true;
            }
            if(data.TalukID==""){
                $('#lstTaluk-err').html('Taluk is required.');status=false;isAddress=true;
            }
            if(data.DistrictID==""){
                $('#lstDistricts-err').html('District is required.');status=false;isAddress=true;
            }
            if(data.StateID==""){
                $('#lstState-err').html('State is required.');status=false;isAddress=true;
            }
            if(data.CountryID==""){
                $('#lstCountry-err').html('Country is required.');status=false;isAddress=true;
            }
            if(data.Address==""){
                $('#txtAddress-err').html('Address is required.');status=false;
            }else if(data.Address.length<5){
                $('#txtAddress-err').html('Address must be greater than 5 characters');status=false;isAddress=true;
            }
            let errorUUID=null;
            $('#vehicleAccordion .accordion-item').each(function(index){/*
                let uuid=$(this).attr('data-uuid');
                let VNo=$('#txtVehicleNumber-'+uuid).val();
                let VType=$('#lstVehicleType-'+uuid).val();
                let VBrand=$('#lstVehicleBrand-'+uuid).val();
                let VModel=$('#lstVehicleModel-'+uuid).val();
                let VLength=$('#txtVehicleLength-'+uuid).val();
                let VDepth=$('#txtVehicleDepth-'+uuid).val();
                let VWidth=$('#txtVehicleWidth-'+uuid).val();
                let VCapacity=$('#txtVehicleCapacity-'+uuid).val();
                if (VType === "") {
                    $('#lstVehicleType-'+uuid+'-err').html('Vehicle Type is required');status = false;isVehicles=true;
                }
                if (VBrand=== "") {
                    $('#lstVehicleBrand-'+uuid+'-err').html('Vehicle Brand is required');status = false;isVehicles=true;
                }

                if (VModel === "") {
                    $('#lstVehicleModel-'+uuid+'-err').html('Vehicle Model is required');status = false;isVehicles=true;
                }
                if (VLength=== "") {
                    $('#txtVehicleLength-'+uuid+'-err').html('Vehicle Length is required');status = false;isVehicles=true;
                }
                if (VDepth === "") {
                    $('#txtVehicleDepth-'+uuid+'-err').html('Vehicle Depth is required');status = false;isVehicles=true;
                }
                if (VWidth === "") {
                    $('#txtVehicleWidth-'+uuid+'-err').html('Vehicle Width is required');status = false;isVehicles=true;
                }
                if (VNo === "") {
                    $('#txtVehicleNumber-'+uuid+'-err').html('Vehicle Number is required');status = false;isVehicles=true;
                }
                if (VCapacity === "") {
                    $('#txtVehicleCapacity-'+uuid+'-err').html('Vehicle Capacity is required');status = false;isVehicles=true;
                }
                errorUUID=(status==false && errorUUID==null)?uuid:errorUUID;*/
            });

            if(isGeneral==true && status==false){
                if($('.woo-commerce-style ul.woo-commerce-style li.general_options').hasClass('active')==false){
                    $('.woo-commerce-style ul.woo-commerce-style li').removeClass('active');
                    $('.woo-commerce-style ul.woo-commerce-style li.general_options').addClass('active');
                    showTabs();
                }
            }else if(isGeneral==false && isAddress==true && status==false){
                if($('.woo-commerce-style ul.woo-commerce-style li.address_options').hasClass('active')==false){
                    $('.woo-commerce-style ul.woo-commerce-style li').removeClass('active');
                    $('.woo-commerce-style ul.woo-commerce-style li.address_options').addClass('active');
                    showTabs();
                }

            }else if(isGeneral==false && isAddress==false && errorUUID!=null && isVehicles==true && status==false){
                if($('.woo-commerce-style ul.woo-commerce-style li.transport_details_options').hasClass('active')==false){
                    $('.woo-commerce-style ul.woo-commerce-style li').removeClass('active');
                    $('.woo-commerce-style ul.woo-commerce-style li.transport_details_options').addClass('active');
                    showTabs();
                    if( $('#'+errorUUID+'-heading button').hasClass('collapsed')){
                        $('#'+errorUUID+'-heading button').trigger('click');
                    }
                }
            }

            if(status){
                status = await MobNoValidation(data.MobileNumber1);
            }
            if(status){
                status = await EmailValidation(data.Email);
            }
            if(status){
                status = await CoNameValidation(data.CoName);
            }
            return status;
        }
        const getData=async()=>{
            let Vehicles=[];
            let supplyDetails=[];
            $('#vehicleAccordion .accordion-item').each(function(index){
                let t={};
                let tmpImages=[];
                let uuid=$(this).attr('data-uuid');
                if(Images.vehicle[uuid]!=undefined){
                    tmpImages=Images.vehicle[uuid];
                }
                t.uuid=uuid
                t.VNo=$('#txtVehicleNumber-'+uuid).val();
                t.VType=$('#lstVehicleType-'+uuid).val();
                t.VBrand=$('#lstVehicleBrand-'+uuid).val();
                t.VModel=$('#lstVehicleModel-'+uuid).val();
                t.VLength=$('#txtVehicleLength-'+uuid).val();
                t.VDepth=$('#txtVehicleDepth-'+uuid).val();
                t.VWidth=$('#txtVehicleWidth-'+uuid).val();
                t.VCapacity=$('#txtVehicleCapacity-'+uuid).val();

                t.Images=tmpImages;
                Vehicles.push(t);
            });
            $('#tblSupplyDetails tbody tr td.tdata').each(function(index){
                try {
                    let t=JSON.parse($(this).html());
                    supplyDetails.push(t);
                } catch (error) {
                    console.log(error);
                }
            });

            let formData=new FormData();

            formData.append('VendorName',$('#txtVendorName').val());
            formData.append('VendorCoName',$('#txtCoName').val());
            formData.append('GSTNo',$('#txtGSTNo').val());
            formData.append('CID',$('#lstCategory').val());
            formData.append('VendorType',$('#lstVendorType').val());
            formData.append('Email',$('#txtEmail').val());
            formData.append('MobileNumber1',$('#txtMobileNumber1').val());
            formData.append('MobileNumber2',$('#txtMobileNumber2').val());
            formData.append('CreditDays',$('#txtCreditDays').val());
            formData.append('CreditLimit',$('#txtCreditLimit').val());
            formData.append('CommissionPercentage',$('#txtCommissionPercentage').val());
            formData.append('PostalCode',$('#lstCity option:selected').attr('data-postal'));
            formData.append('Address',$('#txtAddress').val());
            formData.append('CityID',$('#lstCity').val());
            formData.append('TalukID',$('#lstTaluk').val());
            formData.append('DistrictID',$('#lstDistricts').val());
            formData.append('StateID',$('#lstState').val());
            formData.append('CountryID',$('#lstCountry').val());
            formData.append('ActiveStatus',$('#lstActiveStatus').val());
            formData.append('Reference',$('#txtReference').val());
            formData.append('VehicleData',JSON.stringify(Vehicles));
            formData.append('SupplyDetails',JSON.stringify(supplyDetails));
            formData.append('Documents',JSON.stringify(Images.documents));
            formData.append('deletedImages',JSON.stringify(deletedImages));

            formData.append('removeLogo', $('#txtVendorLogo').attr('data-remove'));
            if($('#txtVendorLogo').val()!=""){
                formData.append('Logo', $('#txtVendorLogo')[0].files[0]);
            }
            return formData;
        }
        init();

        $(document).on('click','.woo-commerce-style ul.woo-commerce-style a',function(e){
            e.preventDefault();
            $('.woo-commerce-style ul.woo-commerce-style li').removeClass('active');
            $(this).parent().addClass('active');
            showTabs();
        });
        $(document).on('click','#btnAddVehicle',function(){
            AddVehicle();
        });
        $(document).on('click','.addVehicleImages',function(){
            let uuid=$(this).attr('data-uuid');

            $('#txtVehicleImages').attr('data-uuid',uuid);
            $('#txtVehicleImages').trigger('click');

        });
        $(document).on('change','#txtVehicleImages',async function(){
            let uuid=$('#txtVehicleImages').attr('data-uuid');
            var files = this.files;
            for(let file of files){
                TotalImagesCount++;
                let referData={};
                referData.imgID= await generateUUID();
                referData.pType= "vehicle-images";
                referData.uuid= uuid;
                let formData=new FormData();
                formData.append('referData',JSON.stringify(referData));
                formData.append('image',file);
                tmpImageUpload(formData);
            }

            $('#txtVehicleImages').attr('data-uuid',"");
            $('#txtVehicleImages').val("");
        });
        $(document).on('click','.actions a.delete',function(e){
            e.preventDefault();
            let aid=$(this).attr('data-attachment_id');
            let PType=$(this).attr('data-product-type');
            let uuid=$(this).attr('data-uuid');
            $('li[data-attachment_id="'+aid+'"]').remove();
            if(['vehicle-images'].indexOf(PType)>=0){
                $('li[data-attachment_id="'+aid+'"]').remove();
                if(PType=="vehicle-images"){
                    if(Images.vehicle[uuid]!=undefined){
                        if (Images.vehicle[uuid].hasOwnProperty(aid)) {
                            deletedImages.vehicle.push({ImgID:aid,uuid});
                            delete Images.vehicle[uuid][aid];
                        }
                    }
                }
            }
        });
        $(document).on('click','.vehicle-trash',function(){
            let uuid=$(this).attr('data-uuid')
            $('#vehicleAccordion .accordion-item[data-uuid="'+uuid+'"]').remove();
            updateVehicleAccordionTitle();
        });

        $(document).on('keyup','.txtVehicleNumber',function(){updateVehicleAccordionTitle();});

        $(document).on('click','#btnAddDocuments',function(){
            $('#txtDocuments').trigger('click');
        });
        $(document).on('change','#txtDocuments',async function(){
            console.log(this.files[0]);

            var files = this.files;
            for(let file of files){
                TotalImagesCount++;
                let referData={};
                referData.imgID= await generateUUID();
                referData.pType= "vendor-documents";
                referData.uuid= "";
                let formData=new FormData();
                formData.append('referData',JSON.stringify(referData));
                formData.append('image',file);
                tmpImageUpload(formData);
            }
            $('#txtDocuments').attr('data-uuid',"");
            $('#txtDocuments').val("");
        });
        $("#btnCropApply").on('click', function() {
            btnLoading($('#btnCropApply'));
            setTimeout(() => {
                var base64 = $image.cropper('getCroppedCanvas').toDataURL();
                var id = $image.attr('data-id');
                let isUrl=$image.attr('data-is-url');
                let aid=$image.attr('data-attachment_id');
                let pType=$image.attr('data-product-type');
                let uuid=$image.attr('data-uuid');
                    let referData={};
                    referData.imgID= aid;
                    referData.id= id;
                    referData.isUrl= isUrl;
                    referData.pType= pType;
                    referData.uuid= uuid;

                    let formData=new FormData();
                    formData.append('referData',JSON.stringify(referData));
                    formData.append('image',base64);
                    tmpImageUpload(formData);
                $('#ImgCrop').modal('hide');
                setTimeout(() => {
                    btnReset($('#btnCropApply'));
                }, 100);
            }, 100);
        });
        $(document).on('click','#btnGSearchPostalCode',async function(){
            $('#txtPostalCode-err').html('')
            let PostalCode=$('#txtPostalCode').val();
            if(PostalCode!=""){
                $('#btnGSearchPostalCode').attr('disabled','disabled');
                $('#btnGSearchPostalCode').html('<i class="fa fa-spinner fa-pulse"></i>');
                let response=await getCity({PostalCode});
                if(response.length>0){
                    $('#lstCity').select2('destroy');
                    $('#lstCity option').remove();
                    $('#lstCity').append('<option value="">Select a City</option>');
                    for(let Item of response){
                        let selected="";
                        if(Item.CityID==$('#lstCity').attr('data-selected')){selected="selected";}
                        $('#lstCity').append('<option '+selected+' data-postal="'+Item.PostalID+'" data-taluk="'+Item.TalukID+'" data-district="'+Item.DistrictID+'" data-state="'+Item.StateID+'" data-country="'+Item.CountryID+'" data-city-name="'+Item.CityName+'" value="'+Item.CityID+'">'+Item.CityName+' </option>');
                    }
                    $('#lstCity').select2();
                    if($('#lstCity').val()!=""){
                        $('#lstCity').trigger('change');
                    }
                }else{
                    $('#txtPostalCode-err').html('Postal Code does not exists.')
                }
                setTimeout(() => {
                    $('#btnGSearchPostalCode').html('Search <i class="fa fa-search"></i>');
                    $('#btnGSearchPostalCode').removeAttr('disabled');
                }, 100);
            }else{
                $('#txtPostalCode-err').html('Postal Code is required.')
            }
        });
        $(document).on("change",'#lstCity',function(){
            let CountryID=$('#lstCity option:selected').attr('data-country');
            let StateID=$('#lstCity option:selected').attr('data-state');
            let DistrictID=$('#lstCity option:selected').attr('data-district');
            let TalukID=$('#lstCity option:selected').attr('data-taluk');
            $('#lstTaluk').attr('data-selected',TalukID);
            $('#lstDistricts').attr('data-selected',DistrictID);
            $('#lstState').attr('data-selected',StateID);
            $('#lstCountry').attr('data-selected',CountryID);
            $('#lstCountry').val(CountryID).trigger('change');

            if (!$('.chkServiceBy:checked').length) {
                $('.chkServiceBy[data-value="PostalCode"]').prop('checked', true).trigger('change');
                setTimeout(function() {
                },2000)
            }
        });
        $(document).on("change",'#lstDistricts',function(){
            getTaluks({CountryID:$('#lstCountry').val(),StateID:$('#lstState').val(),DistrictID:$('#lstDistricts').val()},'lstTaluk');
        });
        $(document).on("change",'#lstState',function(){
            getDistricts({CountryID:$('#lstCountry').val(),StateID:$('#lstState').val()},'lstDistricts');
        });
        $(document).on("change",'#lstCountry',function(){
            getStates({CountryID:$('#lstCountry').val()},'lstState');
        });
        $(document).on('change','.lstVehicleType',function(){
            let uuid=$(this).attr('data-uuid');
            let VehicleTypeID=$('#lstVehicleType-'+uuid).val();
            getVehicleBrand({VehicleTypeID},'lstVehicleBrand-'+uuid);
        });
        $(document).on('change','.lstVehicleBrand',function(){
            let uuid=$(this).attr('data-uuid');
            let VehicleTypeID=$('#lstVehicleType-'+uuid).val();
            let VehicleBrandID=$('#lstVehicleBrand-'+uuid).val();
            getVehicleModal({VehicleTypeID,VehicleBrandID},'lstVehicleModel-'+uuid);
        });
        $(document).on('click','#btnSPPostalCode',async function(){
            $('#txtSPPostalCode-err').html('')
            let PostalCode=$('#txtSPPostalCode').val()
            if(PostalCode!=""){
                $('#btnSPPostalCode').attr('disabled','disabled');
                $('#btnSPPostalCode').html('<i class="fa fa-spinner fa-pulse"></i>');
                let response=await getCity({PostalCode});
                if(response.length>0){
                    $('#lstSPCity').select2('destroy');
                    $('#lstSPCity option').remove();
                    $('#lstSPCity').append('<option value="">Select a City</option>');
                    for(let Item of response){
                        let selected="";
                        if(Item.CityID==$('#lstSPCity').attr('data-selected')){selected="selected";}
                        $('#lstSPCity').append('<option '+selected+' data-postal="'+Item.PostalID+'" data-taluk="'+Item.TalukID+'" data-district="'+Item.DistrictID+'" data-state="'+Item.StateID+'" data-country="'+Item.CountryID+'" data-city-name="'+Item.CityName+'" value="'+Item.CityID+'">'+Item.CityName+'</option>');
                    }
                    $('#lstSPCity').select2();
                    if($('#lstSPCity').val()!=""){
                        $('#lstSPCity').trigger('change');
                    }
                }else{
                    $('#txtSPPostalCode-err').html('Postal Code does not exists.')
                }
                setTimeout(() => {
                    $('#btnSPPostalCode').html('<i class="fa fa-search"></i>');
                    $('#btnSPPostalCode').removeAttr('disabled');
                }, 100);
            }else{
                $('#txtSPPostalCode-err').html('Postal Code is required.')
            }
        });
        $(document).on('click', '.btnAddSupply', async function () {
            $('.errors.SupplyDetails').html('');
            let status = true;
            let ExistStatus = false;
            let PCID = $('#lstPCategory').val();
            let PSCID = $('#lstPSubCategory').val();

            if (PCID == "") {
                $('#lstPCategory-err').html('Product Category is required');status = false;
            }
            if (PSCID.length == 0) {
                $('#lstPSubCategory-err').html('Product Sub Category is required');status = false;
            }

            if (status) {
                let PData = [];
                for (let item of PSCID) {
                    ExistStatus = await isPSCIDInTable(item);
                    if (!ExistStatus) {
                        PData.push({
                            PCID: PCID,
                            PCName: $('#lstPCategory option:selected').text(),
                            PSCID: item,
                            PSCName: $('#lstPSubCategory option[value="' + item + '"]').text(),
                        });
                    }
                }
                if (status && !ExistStatus) {
                    let TableLength = $("#tblSupplyDetails tbody tr").length;
                    if (TableLength == 1){
                        //let table = $('#tblSupplyDetails').DataTable();
                        //table.destroy();
                    }
                    PData.forEach(function (data) {
                        let html = '<tr >';
                        html += '<td>' + data.PCName + '</td>';
                        html += '<td data-id="' + data.PSCID + '">' + data.PSCName + '</td>';
                        html += '<td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger btnDeleteSupply"><i class="fa fa-trash"></i></button></td>';
                        html += '<td class="d-none tdata">' + JSON.stringify({ PCID: data.PCID, PSCID: data.PSCID }) + '</td>';
                        html += '</tr>';
                        $('#tblSupplyDetails tbody').append(html);
                    });
                    //$('#tblSupplyDetails').DataTable();

                    $('#lstPCategory').val('').trigger('change');
                }

            }
        });
        $(document).on('click', '.btnDeleteSupply', function () {
            $(this).closest("tr").remove();
        });
        $(document).on('change','#lstPCategory',function(){
            $('.errors.SupplyDetails').html('');
            getPSubCategory();
        });
        $(document).on('click','.vendor-logo .dropify-clear',function(){
            $(this).parent().find('input[type="file"]').attr('data-remove',1);
        });
        $(document).on('click','#divDocuments .dropify-clear',function(){
            let aid=$(this).parent().find('input.dropify').attr('data-id');
            $('#divDocuments .vendor-documents[data-attachment_id="'+aid+'"]').remove();
            if (Images.documents.hasOwnProperty(aid)) {
                deletedImages.documents.push({ImgID:aid});
                delete Images.documents[aid];
            }
        });
        $(document).on('click','#btnSave',async function(){
            let status=await formValidation();
            if(status){
                swal({
                    title: "Are you sure?",
                    text: "You want @if($isEdit==true)Update @else Save @endif this Vendor!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, @if($isEdit==true)Update @else Save @endif it!",
                    closeOnConfirm: false
                },async function(){
                    swal.close();
                    let formData=await getData();
                    btnLoading($('#btnSave'));
                    let postUrl= @if($isEdit) "{{url('/')}}/admin/master/vendor/vendors/edit/{{$VendorID}}";  @else "{{url('/')}}/admin/master/vendor/vendors/create"; @endif
                    $.ajax({
                        type:"post",
                        url:postUrl,
                        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                        data:formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        xhr: function() {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function(evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = (evt.loaded / evt.total) * 100;
                                    percentComplete=parseFloat(percentComplete).toFixed(2);
                                    $('#divProcessText').html(percentComplete+'% Completed.<br> Please wait for until upload process complete.');
                                    //Do something with upload progress here
                                }
                            }, false);
                            return xhr;
                        },
                        beforeSend: function() {
                            ajaxIndicatorStart("Please wait Upload Process on going.");

                            var percentVal = '0%';
                            setTimeout(() => {
                            $('#divProcessText').html(percentVal+' Completed.<br> Please wait for until upload process complete.');
                            }, 100);
                        },
                        error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                        complete: function(e, x, settings, exception){btnReset($('#btnSave'));ajaxIndicatorStop();$("html, body").animate({ scrollTop: 0 }, "slow");},
                        success:function(response){
                            if(response.status==true){
                                $('#txtVendorID').val(response.VendorID);
                                toastr.success(response.message, "Success", { positionClass: "toast-top-right", containerId: "toast-top-right", showMethod: "slideDown", hideMethod: "slideUp", progressBar: !0});
                            }else{
                                toastr.error(response.message, "Failed", { positionClass: "toast-top-right", containerId: "toast-top-right", showMethod: "slideDown", hideMethod: "slideUp", progressBar: !0});
                                if(response['errors']!=undefined){
                                    $('.errors').html('');
                                    $.each( response['errors'], function( KeyName, KeyValue ) {
                                        var key=KeyName;
                                        if(key=="VendorName"){$('#txtVendorName-err').html(KeyValue);}
                                        if(key=="GSTNo"){$('#txtGSTNo-err').html(KeyValue);}
                                        if(key=="CID"){$('#lstCategory-err').html(KeyValue);}
                                        if(key=="VendorType"){$('#lstVendorType-err').html(KeyValue);}
                                        if(key=="Email"){$('#txtEmail-err').html(KeyValue);}
                                        if(key=="MobileNumber1"){$('#txtMobileNumber1-err').html(KeyValue);}
                                        if(key=="MobileNumber2"){$('#txtMobileNumber2-err').html(KeyValue);}
                                        if(key=="Address"){$('#txtAddress-err').html(KeyValue);}
                                        if(key=="PostalCode"){$('#txtPostalCode-err').html(KeyValue);}
                                        if(key=="CityID"){$('#lstCity-err').html(KeyValue);}
                                        if(key=="TalukID"){$('#lstTaluk-err').html(KeyValue);}
                                        if(key=="DistrictID"){$('#lstDistricts-err').html(KeyValue);}
                                        if(key=="StateID"){$('#lstState-err').html(KeyValue);}
                                        if(key=="CountryID"){$('#lstCountry-err').html(KeyValue);}
                                        if(key=="ActiveStatus"){$('#lstActiveStatus-err').html(KeyValue);}
                                    });
                                }
                            }
                        }
                    });
                });
            }
        });

        const MobNoValidation = async (MobNo) => {
            if (!MobNo) {
                $('#txtMobileNumber1-err').removeClass('text-success fw-600 fs-12').addClass('errors').html('Mobile Number is required.');
                return false;
            } else if (MobNo.length != 10) {
                $('#txtMobileNumber1-err').removeClass('text-success fw-600 fs-12').addClass('errors').html('Mobile Number must be 10 digits.');
                return false;
            } else {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        type: "post",
                        url: "{{url('/')}}/admin/master/vendor/vendors/unique-validation",
                        headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
                        dataType: "json",
                        data: { MobNo: MobNo, VendorID : "@if($isEdit){{$data->VendorID}}@endif"},
                        success: function (response) {
                            if (response) {
                                $('#txtMobileNumber1-err').removeClass('text-success fw-600 fs-12').addClass('errors').html('Mobile Number already exists!');
                                resolve(false);
                            } else {
                                $('#txtMobileNumber1-err').removeClass('errors').addClass('text-success fw-600 fs-12').html('Mobile Number available.');
                                resolve(true);
                            }
                        },
                        error: function (e, x, settings, exception) {
                            ajaxErrors(e, x, settings, exception);
                            reject(e);
                        }
                    });
                });
            }
        };

        const CoNameValidation=async(CoName)=>{
            if(!CoName){
                $('#txtCoName-err').removeClass('text-success fw-600 fs-12').addClass('errors').html('Company Name is required.');
                return false;
            }else if(CoName.length < 4){
                $('#txtCoName-err').removeClass('text-success fw-600 fs-12').addClass('errors').html('Company Name must be greater than 3 characters.');
                return false;
            }else {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        type: "post",
                        url: "{{url('/')}}/admin/master/vendor/vendors/unique-validation",
                        headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
                        dataType: "json",
                        data : {CoName : CoName, VendorID : "@if($isEdit){{$data->VendorID}}@endif"},
                        success: function (response) {
                            if (response) {
                                $('#txtCoName-err').removeClass('text-success fw-600 fs-12').addClass('errors').html('Company Name already exists!');
                                resolve(false);
                            } else {
                                $('#txtCoName-err').removeClass('errors').addClass('text-success fw-600 fs-12').html('Company Name available.');status=true;
                                resolve(true);
                            }
                        },
                        error: function (e, x, settings, exception) {
                            ajaxErrors(e, x, settings, exception);
                            reject(e);
                        }
                    });
                });
            }
        }

        const EmailValidation=async(Email)=>{
            let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if(!Email){
                $('#txtEmail-err').removeClass('text-success fw-600 fs-12').addClass('errors').html('Email is required.');
                return false;
            }else if (Email.length > 0 && !emailPattern.test(Email)) {
                $("#txtEmail-err").removeClass('text-success fw-600 fs-12').addClass('errors').html("Enter a valid email address!");
                return false;
            }else {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        type: "post",
                        url: "{{url('/')}}/admin/master/vendor/vendors/unique-validation",
                        headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
                        dataType: "json",
                        data : {Email : Email, VendorID : "@if($isEdit){{$data->VendorID}}@endif"},
                        success: function (response) {
                            if (response) {
                                $('#txtEmail-err').removeClass('text-success fw-600 fs-12').addClass('errors').html('This Email already exists!');
                                resolve(false);
                            } else {
                                $('#txtEmail-err').removeClass('errors').addClass('text-success fw-600 fs-12').html('Email available.');
                                resolve(true);
                            }
                        },
                        error: function (e, x, settings, exception) {
                            ajaxErrors(e, x, settings, exception);
                            reject(e);
                        }
                    });
                });
            }
        }

        $("#txtMobileNumber1").keyup(function () {
            MobNoValidation($(this).val());
        });
        $("#txtEmail").keyup(function () {
            EmailValidation($(this).val());
        });
        $("#txtCoName").keyup(function () {
            CoNameValidation($(this).val());
        });

        $('.stepwizard-step a').on('click', function(e) {
            var targetStep = $(this).attr('href').substring(1);
            let VendorID = $('#txtVendorID').val();
            if (targetStep === 'stockPoints') {
                if(!VendorID){
                    toastr.error("Please Complete Vendor Registration First!", "Failed", { positionClass: "toast-top-right", containerId: "toast-top-right", showMethod: "slideDown", hideMethod: "slideUp", progressBar: !0});
                    $('div.setup-panel div a.btn-primary').first().trigger('click');
                }
                SPLoadTable();
            } else if (targetStep === 'productMapping') {
                if(!VendorID){
                    toastr.error("Please Complete Vendor Registration First!", "Failed", { positionClass: "toast-top-right", containerId: "toast-top-right", showMethod: "slideDown", hideMethod: "slideUp", progressBar: !0});
                    $('div.setup-panel div a.btn-primary').first().trigger('click');
                }
                getPMPCategory();
                LoadPMProductData();
            } else if (targetStep === 'stockUpdate') {
                if(!VendorID){
                    toastr.error("Please Complete Vendor Registration First!", "Failed", { positionClass: "toast-top-right", containerId: "toast-top-right", showMethod: "slideDown", hideMethod: "slideUp", progressBar: !0});
                    $('div.setup-panel div a.btn-primary').first().trigger('click');
                }
                getSUPCategory();
                LoadStockData();
            }
        });

    });
</script>
@endsection