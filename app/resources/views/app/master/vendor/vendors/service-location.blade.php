@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@icon/dashicons@0.9.0-alpha.4/dashicons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.css">
<style>
    .body{
        background:#f0f0f1;
    }
    .custom input,.custom select,.custom textarea{
        border-radius:0px !important;
    }
    .card{    
        border-radius:0px !important;
        position: relative;
        border: 1px solid #c3c4c7;
        box-shadow: 0 1px 1px rgba(0,0,0,.04);
        background: #fff;
        border
    }
    .card .card-header{
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
    .card .card-body{
        padding:5px;
        overflow:hidden;
    }
    .card .card-header h3{
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
    .accordion-item,
    .accordion-item:first-child,
    .accordion-item:last-child
    {
        border-left:0px;
        border-right:0px;
        border-radius:0px;
    }
    .accordion-button{
        font-weight:700;
    }
    .accordion-button:not(.collapsed){
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
    .accordion-button{
        box-shadow: inset 0 calc(-1 * var(--bs-accordion-border-width)) 0 var(--bs-accordion-border-color);
    }
    .accordion-button:focus{
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
					<li class="breadcrumb-item"><a href="{{url('/')}}/admin/master/vendor/manage-vendors">{{$PageTitle}}</a></li>
                    <li class="breadcrumb-item">@if($isEdit==true)Update @else Create @endif</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid d-none d-sm-block pl-20 pr-20 custom">
	<div class="row d-flex justify-content-center">
		<div class="col-12 col-sm-9 col-md-9 col-lg-9 mb-10">
            <div class="row">
                <div class="col-12 p-0">
                    <div class="form-group">
                        <label for="txtVendorName">Vendor Name  <span class="required"> * </span></label>
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
                                    <div class=" fw-700 text-nowrap pr-10">Vendor Data  </div>
                                </div>
                            </div> 
                        </div>
                        <div class="card-body p-0 woo-commerce-style">
                            <ul class="woo-commerce-style">
                                <li class="service_location_options active" ><a href="#service-location-tab"><span>Service Locations</span></a></li>
                            </ul>
                            <div class="tab-contents" id="service-location-tab">
                                <div class="row justify-content-center mt-20">
                                    <div class="col-12 col-sm-8 col-md-7 col-lg-4">
                                        <select class="form-control select2" id="lstSLCountry" data-selected="">
                                            <option value="">Select a Country</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-8 col-md-7 col-lg-4">
                                        <select  class="form-control select2" id="lstSLState" data-selected="">
                                            <option value="">Select a State</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-8 col-md-7 col-lg-4">
                                        <select  class="form-control select2" id="lstSLDistrict" data-selected="">
                                            <option value="">Select a District</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-10 mb-20">
                                    <div class="col-12">
                                        <div class="accordion" id="ServiceLocationAccordin">
                                        </div>
                                        <span class="errors" id="divServiceLocation-err"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-right">
                    <a href="{{url('/')}}/admin/master/vendor/manage-vendors" class="btn btn-outline-dark mr-10">Cancel</a>
                    <button type="button" class="btn btn-outline-success mr-10" id="btnSave">Update</button>
                </div>
            </div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script src="{{url('/')}}/assets/js/form-wizard/form-wizard-five.js"></script>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.js"></script>
<script>
    $(document).ready(function(){
        let VendorDefaultDistrict = "";
        const init=async()=>{
            showTabs();
            getVendor();
        }
        const showTabs=async()=>{
            $('.woo-commerce-style .tab-contents').hide('slow');
            let activeTabs=$('.woo-commerce-style ul.woo-commerce-style li.active a').attr('href');
            $('.woo-commerce-style '+activeTabs).show('slow')
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
        const loadData=async(data)=>{
            if(data.length>0){
                data=data[0];
                VendorDefaultDistrict=data.DistrictID;
                $("#lstSLCountry").attr('data-selected',data.CountryID);
                $("#lstSLState").attr('data-selected',data.StateID);
                getCountry({},"lstSLCountry");
                getStates({CountryID : data.CountryID},"lstSLState");

                for(let item of data.ServiceLocations){
                    let ExistingDistricts = [];
                    $('#ServiceLocationAccordin .accordion-item').each(function(){
                        ExistingDistricts.push($(this).attr('data-district-id'));
                    });
                    if(ExistingDistricts.indexOf(item.DistrictID)== -1){
                        AddServiceLocations(item.CountryID,item.StateID,item.DistrictID,item.DistrictName,item.PostalCodeIDs);
                    }
                }
            }
        }
        const getVendor=async()=>{
            $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/master/vendor/manage-vendors/get/vendor",
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
        const getData = async () => {
            let ServiceLocation = [];
            let formData = "";
            
            $('#ServiceLocationAccordin .accordion-item').each(function () {
                let countryID = $(this).attr('data-country-id');
                let stateID = $(this).attr('data-state-id');
                let districtID = $(this).attr('data-district-id');
                let postalcodeIDs = $(this).find('.lstSLPostalCodes').val();

                postalcodeIDs.forEach(function (postalcodeID) {
                    let serviceData = {
                        CountryID: countryID,
                        StateID: stateID,
                        DistrictID: districtID,
                        PostalCodeID: postalcodeID,
                    };
                    ServiceLocation.push(serviceData);
                });
            });
            console.log(ServiceLocation);
            if(ServiceLocation.length> 0){
                let jsonData = JSON.stringify(ServiceLocation);
                formData = new FormData();
                formData.append("ServiceLocations", jsonData);
            }
            return formData;
        };

        init();

        $(document).on('click','.woo-commerce-style ul.woo-commerce-style a',function(e){
            e.preventDefault();
            $('.woo-commerce-style ul.woo-commerce-style li').removeClass('active');
            $(this).parent().addClass('active');
            showTabs();
        });
        $(document).on('click','#btnSave',async function(){ 
            $(".errors").html('');
            let status=true;
            let formData=await getData();
            if(formData == ""){
                $('#divServiceLocation-err').text('Select a Postal Code');status=false;
            }
            if(status){
                swal({
                    title: "Are you sure?",
                    text: "You want to Update Vendor Service Location!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, Update it!",
                    closeOnConfirm: false
                },async function(){
                    swal.close();
                    btnLoading($('#btnSave'));
                    let postUrl="{{url('/')}}/admin/master/vendor/manage-vendors/edit/service-location/{{$VendorID}}";

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
                                swal({
                                    title: "SUCCESS",
                                    text: response.message,
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonClass: "btn-outline-success",
                                    confirmButtonText: "Okay",
                                    closeOnConfirm: false
                                },function(){
                                    @if($isEdit==true)
                                        window.location.replace("{{url('/')}}/admin/master/vendor/manage-vendors  ");
                                    @else
                                        window.location.reload();
                                    @endif
                                });
                                
                            }else{
                                toastr.error(response.message, "Failed", {
                                    positionClass: "toast-top-right",
                                    containerId: "toast-top-right",
                                    showMethod: "slideDown",
                                    hideMethod: "slideUp",
                                    progressBar: !0
                                })
                            }
                        }
                    });
                });
            }
        });

        // Service Locations

        const AddServiceLocations=async(CountryID,StateID,DistrictID,DistrictName,PostalCodeIDs)=>{
            let AddressDistrictID = VendorDefaultDistrict;
            let AddressPostalCodeID = $("#lstPostalCodes").val();
            let html = `<div class="accordion-item" data-country-id="${CountryID}" data-state-id="${StateID}" data-district-id="${DistrictID}">
                            <h2 class="accordion-header" data-district-id="${DistrictID}" id="${DistrictID}-heading">
                                <button class="accordion-button" type="button" data-district-id="${DistrictID}" data-bs-toggle="collapse" data-bs-target="#panel-${DistrictID}" aria-expanded="true" aria-controls="panel-${DistrictID}">
                                    ${DistrictName} 
                                    <span class="options">
                                        ${(AddressDistrictID != DistrictID) ? `<span class="trash district-trash" data-district-id="${DistrictID}"><i class="fa fa-trash"></i></span>` : ''}
                                    </span>
                                </button>
                            </h2>
                            <div id="panel-${DistrictID}" class="accordion-collapse collapse" aria-labelledby="${DistrictID}-heading">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="lstSLPostalCodes-${DistrictID}">Postal Code</label>
                                            <div class="form-group">
                                                <select id="lstSLPostalCodes-${DistrictID}" data-district-id="${DistrictID}" class="form-control select2 lstSLPostalCodes" data-selected="${(AddressDistrictID == DistrictID ? AddressPostalCodeID : '')}" multiple></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-15 mb-10 ">
                                        <div class="col-12 text-center d-flex justify-content-center align-items-center">
                                            <button class="btn btn-sm btn-outline-primary mr-10  btnAttrSelectAll" data-attribute-id="AT2024-0000001">Select All</button>
                                            <button class="btn btn-sm btn-outline-primary mr-10 btnAttrDeselectAll" data-attribute-id="AT2024-0000001">Deselect All</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;

                        $('#ServiceLocationAccordin').append(html);

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
                                    }else if(Item.PID==$('#lstSLPostalCodes-'+DistrictID).attr('data-selected')){
                                        selected="selected";
                                    }
                                    $('#lstSLPostalCodes-'+DistrictID).append('<option '+selected+' value="'+Item.PID+'">'+Item.PostalCode+' </option>');
                                }
                            }
                        });
                        $('#lstSLPostalCodes-'+DistrictID).select2();
        }
        $(document).on("change",'#lstSLCountry',async function(){
            getStates({CountryID : $(this).val()},"lstSLState")
        });
        $(document).on("change",'#lstSLState',async function(){
            $(".errors").html('');
            let ExistingDistricts = [];
            $('#ServiceLocationAccordin .accordion-item').each(function(){
                ExistingDistricts.push($(this).attr('data-district-id'));
            });

            $('#lstSLDistrict').select2('destroy');
            $('#lstSLDistrict option').remove();
            $('#lstSLDistrict').append('<option value="">Select a District</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/districts",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:{CountryID : $('#lstSLCountry').val(), StateID : $(this).val()},
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);resolve([])},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let disabled="";
                        let selected="";
                        if(ExistingDistricts.indexOf(Item.DistrictID)!=-1){disabled="disabled";}
                        if(Item.DistrictID==$('#lstSLDistrict').attr('data-selected')){selected="selected";}
                        $('#lstSLDistrict').append('<option '+selected+' '+disabled+' value="'+Item.DistrictID+'">'+Item.DistrictName+' </option>');
                    }
                    if($('#lstSLDistrict').val()!=""){
                        $('#lstSLDistrict').trigger('change');
                    }
                }
            });
            $('#lstSLDistrict').select2();
        });
        $(document).on("change",'#lstSLDistrict',function(){
            $(".errors").html('');
            let CountryID=$("#lstSLCountry").val();
            let StateID=$("#lstSLState").val();
            let DistrictID=$(this).val();
            let DistrictName=$(this).find('option:selected').html();
            let ExistingDistricts = [];
            $('#ServiceLocationAccordin .accordion-item').each(function(){
                ExistingDistricts.push($(this).attr('data-district-id'));
            });
            if(DistrictID && ExistingDistricts.indexOf(DistrictID) == -1){
                $('#lstSLDistrict').select2('destroy');
                $('#lstSLDistrict option[value="'+DistrictID+'"]').attr('disabled','disabled');
                $('#lstSLDistrict').val("").trigger("change");
                $('#lstSLDistrict').select2();
                AddServiceLocations(CountryID,StateID,DistrictID,DistrictName);
            }
        });
        $(document).on('click','.district-trash',function(){
            let DistrictID=$(this).attr('data-district-id');
            $('#lstSLDistrict').select2('destroy');
            $('#ServiceLocationAccordin .accordion-item[data-district-id="'+DistrictID+'"]').remove();
            $('#lstSLDistrict option[value="'+DistrictID+'"]').removeAttr('disabled');
            $('#lstSLDistrict').select2();
        });
        $(document).on('click', '.btnAttrSelectAll', function () {
            let accordionBody = $(this).closest('.accordion-body');
            
            accordionBody.find('.lstSLPostalCodes').select2('destroy');
            accordionBody.find('.lstSLPostalCodes option').prop('selected', true);
            accordionBody.find('.lstSLPostalCodes').select2();
        });
        $(document).on('click','.btnAttrDeselectAll',function(){
            let accordionBody = $(this).closest('.accordion-body');
            
            accordionBody.find('.lstSLPostalCodes').select2('destroy');
            accordionBody.find('.lstSLPostalCodes option').prop('selected', false);
            accordionBody.find('.lstSLPostalCodes').select2();
        });
    });
</script>
@endsection
