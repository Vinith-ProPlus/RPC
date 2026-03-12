@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Transaction</li>
					<li class="breadcrumb-item"><a href="{{ url('/') }}/admin/transaction/quote-enquiry/" data-original-title="" title="">{{$PageTitle}}</a></li>
                    <li class="breadcrumb-item">@if($isEdit==true)Update @else Create @endif</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row d-flex justify-content-center">
		<div class="col-12 col-sm-12 col-lg-12">
			<div class="card">
				<div class="card-header text-center"><h5 class="mt-10">{{$PageTitle}}</h5></div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Quote No</label>
                                                <input type="text" disabled class="form-control" id="txtQNo" value="<?php if($isEdit==true){ echo $EditData[0]['QNo'];}else{ echo $QNo;} ?>">
                                                <div class="errors err-sm" id="txtQNo-err"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Enquiry Date</label>
                                                <input type="date" class="form-control" id="dtpEnqDate" min="<?php if($isEdit==true){ echo date("Y-m-d",strtotime($EditData[0]['QExpiryDate']));}else{ echo date("Y-m-d",strtotime('-5 days'));} ?>" value="<?php if($isEdit==true){ echo date("Y-m-d",strtotime($EditData[0]['ExpectedDeliveryDate']));}else{ echo date("Y-m-d");} ?>">
                                                <div class="errors err-sm" id="dtpEnqDate-err"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Expected Delivery Date</label>
                                                <input type="date" class="form-control" id="dtpExpDate" min="<?php if($isEdit==true){ echo date("Y-m-d",strtotime($EditData[0]['QDate']));}else{ echo date("Y-m-d",strtotime('-5 days'));} ?>" value="<?php if($isEdit==true){ echo date("Y-m-d",strtotime($EditData[0]['QExpiryDate']));}else{ echo date('Y-m-d',strtotime($Settings['Quote-Valid'].' days'));} ?>" >
                                                <div class="errors err-sm" id="dtpExpDate-err"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mt-20">
                                            <div class="form-group">
                                                <label>Customer Name</label>
                                                <select id="lstCustomer" class="form-control select2" data-selected="<?php if($isEdit==true){ echo $EditData[0]['CustomerID'];} ?>">
                                                    <option value="">Select a Customer</option>
                                                    @foreach ($Customers as $row)
                                                        <option value="{{$row->CustomerID}}">{{$row->CustomerName}} ({{$row->MobileNo1}})</option>
                                                    @endforeach
                                                </select>
                                                <div class="errors err-sm" id="lstCustomer-err"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mt-20">
                                            <div class="form-group">
                                                <label>Mobile No</label>
                                                <input type="number" class="form-control" id="txtMobileNo" value="<?php if($isEdit==true){ echo $EditData[0]['ReceiverMobNo'];} ?>">
                                                <div class="errors err-sm" id="txtMobileNo-err"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mt-20">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" class="form-control" id="txtEmail" value="<?php if($isEdit==true){ echo $EditData[0]['Email'];} ?>" disabled>
                                                <div class="errors err-sm" id="txtEmail-err"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6 pl-20">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="card shadow-sm">
                                                        <div class="card-header p-10">
                                                            <div class="text-center fs-17 fw-600">Billing Address
                                                            </div>
                                                        </div>
                                                        <div class="card-body mh-130 p-10">
                                                            <?php
                                                                $BData=array();
                                                                if($isEdit){
                                                                    $tmp=$EditData[0]['BAttention']!=""?"<span class='fs-15 fw-700'>".$EditData[0]['BAttention']."</span>,<br>":"";
            
                                                                    $tmp.=$EditData[0]['BAddress']!=""?$EditData[0]['BAddress'].",<br>":"";
            
                                                                    $tmp.=$EditData[0]['BCityName'];
            
                                                                    if($tmp!=""){$tmp.=", ";}
                                                                    $tmp.=$EditData[0]['BStateName'];
            
                                                                    if($tmp!=""){$tmp.=",<br> ";}
                                                                    $tmp.=$EditData[0]['BCountryName'];
            
                                                                    if($tmp!=""){$tmp.="- ";}
                                                                    $tmp.=$EditData[0]['BPostalCode'];
            
                                                                    if($tmp!=""){$tmp.=".";}
                                                                            
                                                                    $BData=array("Title"=>"","Attention"=>$EditData[0]['BAttention'],"Address"=>$EditData[0]['BAddress'],"CityID"=>$EditData[0]['BCityID'],"CityName"=>$EditData[0]['BCityName'],"StateName"=>$EditData[0]['BStateName'],"StateID"=>$EditData[0]['BStateID'],"CountryName"=>$EditData[0]['BCountryName'],"CountryID"=>$EditData[0]['BCountryID'],"PostalCode"=>$EditData[0]['BPostalCode'],"PostalCodeID"=>$EditData[0]['BPostalCodeID']);
                                                                }
                                                            ?>
                                                            <div id="divBillingAddress" class="fs-15 fw-500 p-6"><?php if($isEdit){ echo $tmp;} ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-20">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="card shadow-sm">
                                                        <div class="card-header p-7">
                                                            <div class="row">
                                                                <div class="col-2">

                                                                </div>
                                                                <div class="col-8 text-center fs-17 fw-600 align-middle">
                                                                    Shipping Address
                                                                </div>
                                                                <div class="col-2">
                                                                    <button id="btnSAChange" title="Change the shipping address" class="btn btn-sm btn-link full-right mr-10">
                                                                        <i class="fa fa-pencil"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-body mh-130 p-10">
                                                            <?php
                                                                $SData=array();
                                                                if($isEdit){
                                                                    $tmp=$EditData[0]['SAttention']!=""?"<span class='fs-15 fw-700'>".$EditData[0]['SAttention']."</span>,<br>":"";
                
                                                                    $tmp.=$EditData[0]['SAddress']!=""?$EditData[0]['SAddress'].",<br>":"";
                
                                                                    $tmp.=$EditData[0]['SCityName'];
                
                                                                    if($tmp!=""){$tmp.=", ";}
                                                                    $tmp.=$EditData[0]['SStateName'];
                
                                                                    if($tmp!=""){$tmp.=",<br> ";}
                                                                    $tmp.=$EditData[0]['SCountryName'];
                
                                                                    if($tmp!=""){$tmp.="- ";}
                                                                    $tmp.=$EditData[0]['SPostalCode'];
                
                                                                    if($tmp!=""){$tmp.=".";}
                                                                                
                                                                    $SData=array("Title"=>"","Attention"=>$EditData[0]['SAttention'],"Address"=>$EditData[0]['SAddress'],"CityID"=>$EditData[0]['SCityID'],"CityName"=>$EditData[0]['SCityName'],"StateName"=>$EditData[0]['SStateName'],"StateID"=>$EditData[0]['SStateID'],"CountryName"=>$EditData[0]['SCountryName'],"CountryID"=>$EditData[0]['SCountryID'],"PostalCode"=>$EditData[0]['SPostalCode'],"PostalCodeID"=>$EditData[0]['SPostalCodeID']);
                                                                }
                                                            ?>
                                                            <div id="divShippingAddress" data-aid="" class="fs-15 fw-500 p-6"><?php if($isEdit){ echo $tmp;} ?></div>
                                                            <div class="display-none" id="divShippingData"><?php if($isEdit){ echo json_encode($SData);} ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row mt-20 mb-20 row justify-content-center">
                                <div class="col-sm-6">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-12">
                                            <label>Quote Image </label>
                                            <input type="file" class="dropify imageScrop custom-height" id="txtQImage" data-default-file="@if($isEdit && $EditData[0]->BannerType == "Web") {{url('/')."/".$EditData[0]->BannerImage}} @endif" data-is-cover-image="1" data-allowed-file-extensions="jpeg jpg png gif">
                                            <div class="errors err-sm" id="txtQImage-err"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row mt-20 mb-20 row justify-content-center">
                                        <div class="col-sm-7">
                                            <div class="form-group">
                                                <label class="txtItemsCount">Items Count <span class="required"> * </span></label>
                                                <input type="number" class="form-control  {{$Theme['input-size']}}" id="txtItemsCount" value="@if($isEdit) {{$EditData->ItemCount}} @endif">
                                                <div class="errors err-sm" id="txtItemsCount-err"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-7 mt-10">
                                            <div class="form-group">
                                                <label>Vendors <span class="required"> * </span></label>
                                                <select id="lstVendor" class="form-control select2 h-100" data-selected="<?php if($isEdit==true){ echo $EditData[0]['VendorID'];} ?>" multiple>
                                                    <option value="">Select a Vendor</option>
                                                    @foreach ($Vendors as $row)
                                                        <option value="{{$row->VendorID}}">{{$row->VendorName}} ({{$row->MobileNumber1}})</option>
                                                    @endforeach
                                                </select>
                                                <div class="errors err-sm" id="lstVendor-err"></div>
                                                <div class="mt-20">
                                                    <div class="text-warning text-center">Verify availability of products in the above quotation image and connect with vendors offering them</div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer row mt-20">
                    <div class="col-sm-12 text-right">
                        @if($crud['view']==true)
                        <a href="{{url('/')}}/admin/transaction/quote-enquiry" class="btn {{$Theme['button-size']}} btn-outline-dark mr-10" id="btnCancel">Back</a>
                        @endif
                        
                        @if((($crud['add']==true) && ($isEdit==false))||(($crud['edit']==true) && ($isEdit==true)))
                            <button class="btn {{$Theme['button-size']}} btn-outline-success" id="btnSave">@if($isEdit==true) Update @else Save @endif</button>
                        @endif
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<!-- Image Crop Script Start -->
<script>
    $(document).ready(function() {
        var uploadedImageURL;
        var URL = window.URL || window.webkitURL;
        var $dataRotate = $('#dataRotate');
        var $dataScaleX = $('#dataScaleX');
        var $dataScaleY = $('#dataScaleY');
        var options = {
            // aspectRatio: 16/9,
            preview: '.img-preview'
        };
        var $image = $('#ImageCrop').cropper(options);
        $('#ImgCrop').modal({backdrop: 'static',keyboard: false});
        $('#ImgCrop').modal('hide');
        $(document).on('change', '.imageScrop', function() {
            let id = $(this).attr('id');
            $('#'+id).attr('data-remove',0); 
            if($('#'+id).attr('data-aspect-ratio')!=undefined){
                options.aspectRatio=$('#'+id).attr('data-aspect-ratio')
            }
            $image.attr('data-id', id);
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
                    uploadedImageURL = URL.createObjectURL(file); console.log(options)
                    $image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
                } else {
                    window.alert('Please choose an image file.');
                }
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
            btnLoading($('#btnCropApply'));
            setTimeout(() => {
                var base64 = $image.cropper('getCroppedCanvas').toDataURL();
                var id = $image.attr('data-id');
                $('#' + id).attr('src', base64);
                $('#' + id).parent().find('img').attr('src', base64)
                $('#ImgCrop').modal('hide');
                setTimeout(() => {
                    btnReset($('#btnCropApply'));
                }, 100);
            }, 100);
        });
        $(document).on('click','#btnCropModelClose',function(){
            var id = $image.attr('data-id');
            $('#' + id).val("");
            $('#' + id).attr('src', "");
            $('#' + id).parent().find('img').attr('src', "");
            $('#' + id).parent().find('.dropify-clear').trigger('click');
            $('#ImgCrop').modal('hide');
        });
    });
</script>
<!-- Image Crop Script End -->
<script>
    $(document).ready(function(){
        const LoadCustomerData=async(CustomerID)=>{
            $('#txtMobileNo').val("");
            $('#txtEmail').val("");
            $('#divBillingAddress').html("");
            $('#divShippingAddress').html("");
            $('#divShippingAddress').attr("data-aid","");
            if(CustomerID){
                $.ajax({
                    type:"post",
                    url:"{{url('/')}}/admin/users-and-permissions/manage-customers/get/customer-data",
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    data:{'CustomerID':CustomerID},
                    dataType:"json",
                    error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                    complete: function(e, x, settings, exception){},
                    success:function(response){
                        $('#txtMobileNo').val(response.MobileNo1);
                        $('#txtEmail').val(response.Email);
                        if (response.CompleteAddress !== null && response.CompleteAddress !== undefined) {
                            $('#divBillingAddress').html(response.CompleteAddress);
                        }
                        if (response.DefaultSAddress.CompleteAddress !== null && response.DefaultSAddress.CompleteAddress !== undefined) {
                            $('#divShippingAddress').html(response.DefaultSAddress.CompleteAddress);
                        }
                        $('#divShippingAddress').attr('data-aid', response.DefaultSAddress.AID);
                    }
                });
            }
            return true;
        }
        $(document).on('click','#btnSAChange',function(){
            let CustomerID = $('#lstCustomer').val();
            if(CustomerID){
                $.ajax({
                    type:"post",
                    url:"{{url('/')}}/admin/users-and-permissions/manage-customers/get/customer-data",
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    data:{'CustomerID':CustomerID},
                    dataType:"json",
                    error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                    complete: function(e, x, settings, exception){},
                    success:function(response){
                        var modalContent = $('<div>');
                        var table = $('<table>').addClass('table');
                        var tbody = $('<tbody>');
    
                        $.each(response.SAddress, function(index, item) {
                            var tr = $('<tr>');
                            var td1 = $('<td>').addClass('pointer').html('<b>' + item.Address + '</b>,<br>' +
                                item.CityName + ', ' + item.TalukName + ',<br>' +
                                item.DistrictName + ', ' + item.StateName + ',<br>' +
                                item.CountryName + ' - ' + item.PostalCode + '.');
                            var td2 = $('<td>').addClass('text-center').html('<button type="button" class="btn btn-sm btn-outline-danger m-5 btnSelectSAddress" data-id="' + item.AID + '">Select</button>');
    
                            tr.append(td1).append(td2);
                            tbody.append(tr);
                        });
    
                        table.append(tbody);
                        modalContent.append(table);
    
                        bootbox.dialog({
                            title: 'Select Shipping Address',
                            message: modalContent,
                            size: 'medium'
                        });
                    }
                });
            }
        });
        $(document).on('click','.btnSelectSAddress',function(){
            let CustomerID = $('#lstCustomer').val();
            if(CustomerID){
                $.ajax({
                    type:"post",
                    url:"{{url('/')}}/admin/users-and-permissions/manage-customers/set-default-address",
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    data:{'CustomerID':CustomerID,AID : $(this).attr('data-id')},
                    dataType:"json",
                    error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                    complete: function(e, x, settings, exception){},
                    success:function(response){
                        if(response.status){
                            $('#lstCustomer').trigger('change');
                            bootbox.hideAll();
                        }
                    }
                });
            }
        });
        $('#lstCustomer').change(async function () {
            $('.errors').html('');
            LoadCustomerData($(this).val());
        });
        const formValidation=async()=>{
            $('.errors').html('');
            let status=true;
                let data={}
                data.EnqDate=$('#dtpEnqDate').val();
                data.ExpDate=$('#dtpExpDate').val();
                data.Customer=$('#lstCustomer').val();
                data.MobileNo=$('#txtMobileNo').val();
                data.Email=$('#txtEmail').val();
                data.QuoteImage=$('#txtQImage').val();
                data.ItemsCount=$('#txtItemsCount').val();
                data.Vendor=$('#lstVendor').val();

                if(!data.Customer){
                    $('#lstCustomer-err').html('Customer is required.');status=false;
                }
                if(!data.EnqDate){
                    $('#dtpEnqDate-err').html('Enquiry Date is required.');status=false;
                }
                if(!data.ExpDate){
                    $('#dtpExpDate-err').html('Expected Date is required.');status=false;
                }
                if(!data.Email){
                    $('#txtEmail-err').html('Email is required.');status=false;
                }
                if(!data.MobileNo){
                    $('#txtMobileNo-err').html('Mobile Number is required.');status=false;
                }
                if(!data.QuoteImage){
                    $('#txtQImage-err').html('Upload an Image.');status=false;
                }
                if(!data.ItemsCount){
                    $('#txtItemsCount-err').html('Items Count is required.');status=false;
                }
                if(data.Vendor.length == 0){
                    $('#lstVendor-err').html('Vendor is required.');status=false;
                }
            return status;
        }
        const getData=async()=>{
            let tmp=await UploadImages();
            let formData=new FormData();

            formData.append('CustomerID',$('#lstCustomer').val());
            formData.append('ExpectedDeliveryDate',$('#dtpExpDate').val());
            formData.append('EnqDate',$('#dtpEnqDate').val());
            formData.append('ReceiverMobNo',$('#txtMobileNo').val());
            formData.append('AID',$('#divShippingAddress').data('aid'));
            formData.append('VendorIDs',JSON.stringify($('#lstVendor').val()));
            if(tmp.coverImage.uploadPath!=""){
                formData.append('QuoteImage', JSON.stringify(tmp.coverImage));
            }
            return formData;
        }
        $(document).on('click','#btnSave',async function(){ 
            let status=await formValidation();
            if(status){
                swal({
                    title: "Are you sure?",
                    text: "You want @if($isEdit==true)Update @else Save @endif this Image Quote Enquiry!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, @if($isEdit==true)Update @else Save @endif it!",
                    closeOnConfirm: false
                },async function(){
                    swal.close();
                    let formData=await getData();

                    btnLoading($('#btnSave'));
                    let postUrl="{{url('/')}}/admin/transaction/quote-enquiry/image-quote/save";
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
                                        window.location.replace("{{url('/')}}/admin/transaction/quote-enquiry");
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

    });

</script>
@endsection