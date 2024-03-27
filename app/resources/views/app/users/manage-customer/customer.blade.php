@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
                    <li class="breadcrumb-item">Master</li>
                    <li class="breadcrumb-item"><a href="{{ url('/') }}/admin/users-and-permissions/manage-customers" data-original-title="" title="">{{$PageTitle}}</a></li>
                    <li class="breadcrumb-item">@if($isEdit==true)Update @else Create @endif</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row d-flex justify-content-center">
		<div class="col-sm-9">
			<div class="card">
				<div class="card-header text-center"><h5 class="mt-10" id="pageTitle">{{$PageTitle}}</h5></div>
				<div class="card-body " >
                    <div class="row">
                        <div class="col-sm-12">
                            <form class="form-wizard" id="Leads" action="#" method="POST">
                                <div class="tab" data-page="{{$PageTitle}}">
                                    <div class="row mb-30  d-flex justify-content-center">
                                        <div class="col-sm-4">
                                            <input type="file" class="dropify imageScrop" data-aspect-ratio="{{$Settings['image-crop-ratio']['w']/$Settings['image-crop-ratio']['h']}}" data-remove="0" data-is-cover-image="1" id="txtCustomerImage" data-default-file="<?php if($isEdit==true){if($EditData->CustomerImage!=""){ echo url('/')."/".$EditData->CustomerImage;}}?>"  data-allowed-file-extensions="<?php echo implode(" ",$FileTypes['category']['Images']) ?>" >
                                            <div class="errors" id="txtCustomerImage-err"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="txtCustomerName">Customer Name <span class="required">*</span></label>
                                                <input type="text" id="txtCustomerName" class="form-control " placeholder="Customer Name" value="<?php if($isEdit==true){ echo $EditData->CustomerName;} ?>">
                                                <span class="errors Customer err-sm" id="txtCustomerName-err"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="txtEmail">Email <span class="required">*</span></label>
                                                <input type="text" id="txtEmail" class="form-control " placeholder="Email"  value="<?php if($isEdit==true){ echo $EditData->Email;} ?>">
                                                <span class="errors Customer err-sm" id="txtEmail-err"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-20">
                                            <div class="form-group">
                                                <label for="txtMobileNo1">Mobile Number <span class="required">*</span></label>
                                                <input type="text" id="txtMobileNo1" class="form-control " placeholder="Mobile Number"  value="<?php if($isEdit==true){ echo $EditData->MobileNo1;} ?>">
                                                <span class="errors Customer err-sm" id="txtMobileNo1-err"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-20">
                                            <div class="form-group">
                                                <label for="txtMobileNo2">Alternate Mobile Number </label>
                                                <input type="text" id="txtMobileNo2" class="form-control " placeholder="Alternate Mobile Number"  value="<?php if($isEdit==true){ echo $EditData->MobileNo2;} ?>">
                                                <span class="errors Customer err-sm" id="txtMobileNo2-err"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-20">
                                            <div class="form-group">
                                                <label for="lstGender">Gender <span class="required">*</span></label>
                                                <select class="form-control {{$Theme['input-size']}} select2" id="lstGender" data-selected="{{ $isEdit ? $EditData->GenderID : '' }}">
                                                    <option value="">Select Gender</option>
                                                </select>
                                                <span class="errors Customer err-sm" id="lstGender-err"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-20">
                                            <div class="form-group">
                                                <label for="txtDOB">DOB <span class="required">*</span></label>
                                                <input type="date" id="txtDOB" class="form-control " placeholder="Select DOB" value="{{ $isEdit ? ($EditData->DOB ?? '') : '' }}">
                                                <span class="errors Customer err-sm" id="txtDOB-err"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-20">
                                            <div class="form-group">
                                                <label for="lstConTypeIDs">Construction Type <span class="required">*</span></label>
                                                <select class="form-control {{$Theme['input-size']}} select2" id="lstConTypeIDs" data-selected="{{ $isEdit ? ($EditData->ConTypeIDs ?? '') : '' }}">
                                                    <option value="">Select a Construction Type</option>
                                                </select>
                                                <span class="errors Customer err-sm" id="lstConTypeIDs-err"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-20">
                                            <div class="form-group">
                                                <label for="lstCusType">Customer Type <span class="required">*</span></label>
                                                <select class="form-control {{$Theme['input-size']}} select2" id="lstCusType" data-selected="<?php if($isEdit){ echo $EditData->CusTypeID;} ?>">
                                                    <option value="">Select a Customer Type</option>
                                                </select>
                                                <span class="errors Customer err-sm" id="lstCusType-err"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-20">
                                            <div class="form-group">
                                                <label for="lstCreditLimitStatus">Credit Limit Status <span class="required"></span></label>
                                                <select class="form-control " id="lstCreditLimitStatus">
                                                    <option value="1" {{ $isEdit ? (($EditData->isEnableCreditLimit == "Enabled") ? 'selected' : '') : '' }}>Enabled</option>
                                                    <option {{ $isEdit ? (($EditData->isEnableCreditLimit != "Enabled") ? 'selected' : '') : 'selected' }} value="0">Disabled</option>
                                                </select>
                                                <span class="errors" id="lstCreditLimitStatus-err"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-20">
                                            <div class="form-group">
                                                <label for="txtCreditLimit">Credit Limit <span class="required">*</span></label>
                                                <input type="number" id="txtCreditLimit" class="form-control" disabled placeholder="Credit Limit"
                                                       value="{{ NumberFormat(($isEdit ? $EditData->CreditLimit : $SETTINGS['customer-default-credit-limit']),$Settings['price-decimals']) }}">
                                                <span class="errors Customer" id="txtCreditLimit-err"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-20">
                                            <div class="form-group">
                                                <label for="lstCreditOverDraft">Credit Over Draft <span class="required"></span></label>
                                                <select class="form-control " id="lstCreditOverDraft">
                                                    <option value="1" {{ $isEdit ? (($EditData->CreditDays > 0) ? 'selected' : '') : '' }}>Enabled</option>
                                                    <option value="0" {{ $isEdit ? (($EditData->CreditDays == 0) ? 'selected' : '') : 'selected' }}>Disabled</option>
                                                </select>
                                                <span class="errors" id="lstCreditOverDraft-err"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-20">
                                            <div class="form-group">
                                                <label for="txtCreditDays">Credit Days <span class="required">*</span></label>
                                                <input type="number" id="txtCreditDays" class="form-control " placeholder="Credit Days"
                                                       value="{{ $isEdit ? $EditData->CreditDays : $SETTINGS['default-customers-credit-days'] }}">
                                                <span class="errors Customer" id="txtCreditDays-err"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-20">
                                            <label for="lstActiveStatus">Active Status</label>
                                            <select class="form-control " id="lstActiveStatus">
                                                <option value="Active" @if($isEdit==true) @if($EditData->ActiveStatus=="Active") selected @endif @endif >Active</option>
                                                <option value="Inactive" @if($isEdit==true) @if($EditData->ActiveStatus=="Inactive") selected @endif @endif>Inactive</option>
                                            </select>
                                            <span class="errors Customer err-sm" id="lstActiveStatus-err"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab" data-page="Billing Address">
                                    <div class="row">
                                        <div class="col-sm-12 mt-20">
                                            <label for="txtAddress">Billing Address <span class="required">*</span></label>
                                            <textarea  id="txtAddress" rows="3" class="form-control"><?php if($isEdit){ echo $EditData->Address;} ?></textarea>
                                            <span class="errors BA err-sm" id="txtAddress-err"></span>
                                        </div>
                                        <div class="col-sm-6 mt-20">
                                            <div class="form-group">
                                                <label for="txtPostalCode">Postal Code <span class="required">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" id="txtPostalCode" class="form-control" placeholder="Postal Code" value="<?php if($isEdit){ echo $EditData->PostalCode;} ?>">
                                                    <button type="button" class="btn btn-outline-dark" id="btnGSearchPostalCode">Search <i class="fa fa-search"></i></button>
                                                </div>
                                                <div class="errors BA err-sm" id="txtPostalCode-err"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-20">
                                            <div class="form-group">
                                                <label for="lstCity">City <span class="required">*</span></label>
                                                <select class="form-control {{$Theme['input-size']}} select2" id="lstCity" data-selected="<?php if($isEdit){ echo $EditData->CityID;} ?>">
                                                    <option value="">Select a City</option>
                                                </select>
                                                <div class="errors BA err-sm" id="lstCity-err"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-20">
                                            <div class="form-group">
                                                <label for="lstTaluk">Taluk <span class="required">*</span></label>
                                                <select class="form-control {{$Theme['input-size']}} select2" id="lstTaluk" data-selected="<?php if($isEdit){ echo $EditData->TalukID;} ?>">
                                                    <option value="">Select a Taluk</option>
                                                </select>
                                                <div class="errors BA err-sm" id="lstTaluk-err"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-20">
                                            <div class="form-group">
                                                <label for="lstDistrict">District <span class="required">*</span></label>
                                                <select class="form-control {{$Theme['input-size']}} select2" id="lstDistricts" data-selected="<?php if($isEdit){ echo $EditData->DistrictID;} ?>">
                                                    <option value="">Select a District</option>
                                                </select>
                                                <div class="errors BA err-sm" id="lstDistricts-err"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-20">
                                            <div class="form-group">
                                                <label for="lstState">State <span class="required">*</span></label>
                                                <select class="form-control {{$Theme['input-size']}} select2" id="lstState"  data-selected="<?php if($isEdit){ echo $EditData->StateID;} ?>">
                                                    <option value="">Select a State</option>
                                                </select>
                                                <div class="errors BA err-sm" id="lstState-err"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-20">
                                            <div class="form-group">
                                                <label for="lstCountry">Country <span class="required">*</span></label>
                                                <select class="form-control {{$Theme['input-size']}} select2" id="lstCountry" data-selected="<?php if($isEdit){ echo $EditData->CountryID;} ?>">
                                                    <option value="">Select a Country</option>
                                                </select>
                                                <div class="errors BA err-sm" id="lstCountry-err"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab" data-page="Shipping Address">
                                    <div class="row">
                                        <div class="col-sm-12 text-right">
                                            <button class="btn btn-sm btn-outline-info btnAddAddress" type="button" data-title="Shipping Address">Add</button>
                                        </div>
                                    </div>
                                    <div class="row mt-10">
                                        <div class="col-sm-12">
                                            <table class="table" id="tblShippingAddress">
                                                <tbody>
                                                    @if($isEdit)
                                                        @foreach ($EditData->SAddress as $key => $item)
                                                            <tr id="{{ $key + 1 }}" data-aid="{{ $item->AID }}">
                                                                <td class="text-right checkbox1">
                                                                    <div class="radio radio-primary">
                                                                        <input id="chkSA{{ $key + 1 }}" data-aid="{{ $item->AID }}" type="radio" name="SAddress" value="{{ $key + 1 }}" {{ $item->isDefault == 1 ? 'checked' : '' }}>
                                                                        <label for="chkSA{{ $key + 1 }}"></label>
                                                                    </div>
                                                                </td>
                                                                <td class="pointer">
                                                                    <b>{{ $item->Address }}</b>,<br>
                                                                    {{ $item->CityName }}, {{ $item->TalukName }},<br>
                                                                    {{ $item->DistrictName }}, {{ $item->StateName }},<br>
                                                                    {{ $item->CountryName }} - {{ $item->PostalCode }}.
                                                                </td>
                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-sm btn-outline-success m-5 btnEditSAddress"><i class="fa fa-pencil"></i></button>
                                                                    <button type="button" class="btn btn-sm btn-outline-danger m-5 btnDeleteSAddress"><i class="fa fa-trash"></i></button>
                                                                </td>
                                                                <td class="d-none">{{ json_encode($item) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mt-30">
                                    <div class="col-sm-6">
                                        <a href="{{url('/')}}/admin/users-and-permissions/manage-customers" class="btn btn-sm btn-outline-dark" id="btnCancel">Back</a>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="text-right btn-mb">
                                            <button class="btn btn-outline-secondary" id="prevBtn" type="button" style="display: none;">Previous</button>
                                            <button class="btn btn-outline-success" id="nextBtn" type="button" >Next</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center" id="divStepIndicator">
                                    <span class="step active"></span>
                                </div>
                            </form>
                        </div>
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
            aspectRatio: 16/9,
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
        $(document).on('click','.dropify-clear',function(){
            $(this).parent().find('input[type="file"]').attr('data-remove',1);
        });

    });
</script>
<!-- Image Crop Script End -->
<script>
    $(document).ready(function(){
        $('#lstConTypeIDs').select2({
            multiple: true,
            placeholder: 'Select a Construction Type'
        });
        let EditRow=null;
		var currentTab = 0;
		showTab(currentTab);
		function showTab(n) {
			var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = @if($isEdit) "Update" @else "Submit" @endif;
                $('#btnPreview').show();
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
                $('#btnPreview').hide();
            }
            fixStepIndicator(n);
            let page=x[currentTab].getAttribute('data-page');
            $('#pageTitle').html(page);
		}
		async function nextPrev(n) {
			var x = document.getElementsByClassName("tab");
            if (n == 1 && !validateForm()) return false;
            if ((parseInt(currentTab) + parseInt(n)) >= x.length) {
                Save();
                return false;
            }
			x[currentTab].style.display = "none";
			currentTab = currentTab + n;
			showTab(currentTab);

		}
		function validateForm() {
			let status=true;
			let x = document.getElementsByClassName("tab");
            let page=x[currentTab].getAttribute('data-page');
            if((page=="Manage Customers")){
                $('.errors.Customer').html('');
                let CustomerName=$('#txtCustomerName').val();
                let MobileNo1=$('#txtMobileNo1').val();
                let MobileNo2=$('#txtMobileNo2').val();
                let Email=$('#txtEmail').val();
                let Gender=$('#lstGender').val();
                let DOB=$('#txtDOB').val();
                let ConType=$('#lstConTypeIDs').val();
                let CusTypeID=$('#lstCusType').val();
                let CreditDays=$('#txtCreditDays').val();
                let CreditLimit=$('#txtCreditLimit').val();
                if(!CustomerName){
                    $('#txtCustomerName-err').html('Customer Name is required');status=false;
                }else if(CustomerName.length<2){
                    $('#txtCustomerName-err').html('The Customer Name is must be greater than 2 characters.');status=false;
                }else if(CustomerName.length>100){
                    $('#txtCustomerName-err').html('The Customer Name is not greater than 100 characters.');status=false;
                }
                let mobilePattern = /^\d{10}$/;
                if(!MobileNo1){
                    $('#txtMobileNo1-err').html('Mobile Number is required.');status=false;
                }else if (!mobilePattern.test(MobileNo1)){
                    $("#txtMobileNo1-err").html("Mobile Number must be 10 digit");
                }
                if (MobileNo2.length > 0 && !mobilePattern.test(MobileNo2)){
                    $("#txtMobileNo2-err").html("Alternate Mobile Number must be 10 digit");status=false;
                }
                let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if(!Email){
                    $('#txtEmail-err').html('Email is required.');status=false;
                }else if (!emailPattern.test(Email)) {
                    $("#txtEmail-err").html("Enter a valid email address");status=false;
                }
                if(!CusTypeID){
                    $('#lstCusType-err').html('Customer Type is required.');status=false;
                }
                if(Gender === ""){
                    $('#lstGender-err').html('Gender is required.');status=false;
                }
                if(DOB === ""){
                    $('#txtDOB-err').html('DOB is required.');status=false;
                }
                if(ConType.length === 0){
                    $('#lstConTypeIDs-err').html('Construction type is required.');status=false;
                }
                if($('#lstCreditOverDraft').val()==1){
                    if(CreditDays==""){
                        $('#txtCreditDays-err').html('Credit Days is required');status=false;
                    }else if(parseInt(CreditDays)<0){
                        $('#txtCreditDays-err').html('The Credit Days must be  equal or greater than 0.');status=false;
                    }
                }
                if($('#lstCreditLimitStatus').val()==1){
                    if(CreditLimit==""){
                        $('#txtCreditLimit-err').html('Credit Limit is required');status=false;
                    }
                }
                if(status==false){$("html, body").animate({ scrollTop: 0 }, "slow");}
            }else if(page=="Billing Address"){
                $('.errors.BA').html('');
                Address=$('#txtAddress').val();
                PostalCode=$('#lstCity option:selected').attr('data-postal');
                CityID=$('#lstCity').val();
                TalukID=$('#lstTaluk').val();
                DistrictID=$('#lstDistricts').val();
                StateID=$('#lstState').val();
                CountryID=$('#lstCountry').val();
                if(!PostalCode){
                    $('#txtPostalCode-err').html('Postal Code is required.');status=false;isAddress=true;
                }
                if(CityID==""){
                    $('#lstCity-err').html('City is required.');status=false;isAddress=true;
                }
                if(TalukID==""){
                    $('#lstTaluk-err').html('Taluk is required.');status=false;isAddress=true;
                }
                if(DistrictID==""){
                    $('#lstDistricts-err').html('District is required.');status=false;isAddress=true;
                }
                if(StateID==""){
                    $('#lstState-err').html('State is required.');status=false;isAddress=true;
                }
                if(CountryID==""){
                    $('#lstCountry-err').html('Country is required.');status=false;isAddress=true;
                }
                if(Address==""){
                    $('#txtAddress-err').html('Address is required.');status=false;
                }else if(Address.length<5){
                    $('#txtAddress-err').html('Address must be greater than 5 characters');status=false;isAddress=true;
                }
                if(status==false){$("html, body").animate({ scrollTop: 0 }, "slow");}
            }else if(page=="Shipping Address"){
                let TotRows=$('#tblShippingAddress tbody tr').length;
                let isSelectedDefaultShipping=$('input[type="radio"][name="SAddress"]:checked').length
                if(TotRows<=0){
                    toastr.error('Shipping address is required', "Failed", {
                        positionClass: "toast-top-right",
                        containerId: "toast-top-right",
                        showMethod: "slideDown",
                        hideMethod: "slideUp",
                        progressBar: !0
                    });
                    status=false;
                }else if(isSelectedDefaultShipping<=0){
                    toastr.error('please select default shipping address', "Failed", {
                        positionClass: "toast-top-right",
                        containerId: "toast-top-right",
                        showMethod: "slideDown",
                        hideMethod: "slideUp",
                        progressBar: !0
                    });
                    status=false;
                }
                if(status==false){$("html, body").animate({ scrollTop: 0 }, "slow");}
            }
			// return true;
			return status;
		}
		function fixStepIndicator(n) {
			$('#divStepIndicator').html('');
			var tabs = document.getElementsByClassName("tab");
			for (let i = 0; i < tabs.length; i++) {
				$('#divStepIndicator').append('<span class="step"></span>');
			}

			var i, x = document.getElementsByClassName("step");
			for (i = 0; i < x.length; i++) {
				x[i].className = x[i].className.replace(" active", "");
			}
			x[n].className += " active";
		}


        const getGender=async(data,id)=>{
            $('#'+id+' option').remove();
            $('#'+id).append('<option value="">Select a Gender</option>');
            $.ajax({
                type:"post",
                url:"{{ route('getGender') }}",
                headers: { 'X-CSRF-Token' : '{{ csrf_token() }}' },
                data:data,
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for (let Item of response) {
                        let selected = "";
                        if (Item.GID  === $('#' + id).attr('data-selected')) {
                            selected = "selected";
                        }
                        $('#' + id).append('<option ' + selected + ' value="' + Item.GID + '">' + Item.Gender + ' </option>');
                    }
                    if ($('#' + id).val() != "") {
                        $('#' + id).trigger('change');
                    }
                }
            });
        }
        const getConType = async (data, id) => {
            $('#'+id).select2('destroy');
            $('#' + id + ' option').remove();
            $.ajax({
                type: "post",
                url: "{{ route('getConstructionType') }}",
                headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                data: data,
                dataType: "json",
                async: true,
                error: function (e, x, settings, exception) {
                    ajaxErrors(e, x, settings, exception);
                },
                complete: function (e, x, settings, exception) {
                },
                success: function (response) {
                    for (let Item of response.data) {
                        var selectedValues = $('#' + id).attr('data-selected');
                        var selectedValuesArray = selectedValues.split(',');
                        if (selectedValuesArray.includes(Item.ConTypeID)) {
                            $('#' + id).append('<option selected value="' + Item.ConTypeID + '">' + Item.ConTypeName + ' </option>');
                        } else {
                            $('#' + id).append('<option value="' + Item.ConTypeID + '">' + Item.ConTypeName + ' </option>');
                        }
                    }
                    if ($('#' + id).val() != "") {
                        $('#' + id).trigger('change');
                    }
                    $('#' + id).select2({
                        multiple: true,
                        placeholder: 'Select a Construction Type'
                    });
                }
            });
        }
        const getCustomerType=async()=>{
            $('#lstCusType').select2('destroy');
            $('#lstCusType option').remove();
            $('#lstCusType').append('<option value="" selected>Select a Customer Type</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/users-and-permissions/manage-customers/get/customer-type",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.CusTypeID==$('#lstCusType').attr('data-selected')){selected="selected";}
                        $('#lstCusType').append('<option '+selected+' value="'+Item.CusTypeID+'">'+Item.CusTypeName+' </option>');
                    }
                }
            });
            $('#lstCusType').select2();
        }
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
        $(document).on('click', '#btnSaveAddress', function () {
            SaveAddress();
        });
        $(document).on('click', '.btnEditSAddress', function () {
            let Row=$(this).closest('tr');
            let EditData=JSON.parse($(this).closest('tr').find("td:eq(3)").html());
            EditData.EditID=Row.attr('id');
            EditData.AID=Row.attr('data-aid');
            getAddressModal(EditData);
        });
        $(document).on('click', '.btnDeleteSAddress', function () {
            $(this).closest('tr').remove();
        });
        const SaveAddress = async () => {
            let { status, formData, Address } = await ValidateGetAddress();
            // console.log(formData);

            if (status) {
                let index = formData.EditID ? formData.EditID : $('#tblShippingAddress tbody tr').length + 1;

                let html = `<tr id="${index}" data-aid="${formData.AID}">
                                <td class="text-right checkbox1">
                                    <div class="radio radio-primary">
                                        <input id="chkSA${index}" data-aid="${formData.AID}" type="radio" name="SAddress" value="${index}">
                                        <label for="chkSA${index}"></label>
                                    </div>
                                </td>
                                <td class="pointer">
                                    <b>${formData.Address}</b>,<br>
                                    ${formData.CityName}, ${formData.TalukName},<br>
                                    ${formData.DistrictName}, ${formData.StateName},<br>
                                    ${formData.CountryName} - ${formData.PostalCode}.
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-outline-success m-5 btnEditSAddress"><i class="fa fa-pencil"></i></button>
                                    <button type="button" class="btn btn-sm btn-outline-danger m-5 btnDeleteSAddress"><i class="fa fa-trash"></i></button>
                                </td>
                                <td class="d-none">${JSON.stringify(formData)}</td>
                            </tr>`;

                if (formData.EditID) {
                    $("#tblShippingAddress tbody tr").each(function () {
                        let SNo = $(this).attr('id');
                        if (SNo == formData.EditID) {
                            $(this).replaceWith(html);
                            return false;
                        }
                    });
                } else {
                    $('#tblShippingAddress tbody').append(html);
                }

                bootbox.hideAll();
            }
        };
        const ValidateGetAddress = async () => {
            $(".errors.Address").html("");
            let status = true;
            let formData={};
            formData.EditID=$("#btnSaveAddress").attr('data-edit-id');
            formData.AID=$("#btnSaveAddress").attr('data-aid');
            formData.Address=$('#txtADAddress').val();
            formData.CountryID=$('#lstADCountry').val();
            formData.CountryName=$('#lstADCountry option:selected').attr('data-country-name');
            formData.StateID=$('#lstADState').val();
            formData.StateName=$('#lstADState option:selected').text();
            formData.DistrictID=$('#lstADDistrict').val();
            formData.DistrictName=$('#lstADDistrict option:selected').text();
            formData.TalukID=$('#lstADTaluk').val();
            formData.TalukName=$('#lstADTaluk option:selected').text();
            formData.CityID=$('#lstADCity').val();
            formData.CityName=$('#lstADCity option:selected').text();
            formData.PostalCode=$('#txtADPostalCode').val();
            formData.PostalCodeID=$('#lstADCity option:selected').attr('data-postal-id');
            // console.log(formData);
            let Address ="";
            if(formData.Address==""){
                $('#txtADAddress-err').html('Address is required');status=false;
            }else if(formData.Address.length<5){
                $('#txtADAddress-err').html('The Address must be greater than 5 characters.');status=false;
            }else{
                Address+=",<br>"+formData.Address;
            }
            if(formData.CityID==""){
                $('#lstADCity-err').html('City is required');status=false;
            }else{
                Address+=",<br>"+formData.CityName;
            }
            if(formData.TalukID==""){
                $('#lstADTaluk-err').html('Taluk is required');status=false;
            }else{
                Address+=",<br>"+formData.TalukName;
            }
            if(formData.DistrictID==""){
                $('#lstADDistrict-err').html('District is required');status=false;
            }else{
                Address+=",<br>"+formData.DistrictName;
            }
            if(formData.StateID==""){
                $('#lstADState-err').html('State is required');status=false;
            }else{
                Address+=",<br>"+formData.StateName;
            }
            if(formData.CountryID==""){
                $('#lstADCountry-err').html('Country is required');status=false;
            }else{
                Address+=","+formData.CountryName;
            }
            if(formData.PostalCode==""){
                $('#txtADPostalCode-err').html('Postal Code is required');status=false;
            }else{
                Address+=" - "+formData.PostalCode;
            }
            // status = true;
            return { status, formData, Address };
        };
		$('#prevBtn').click(function() {
			nextPrev(-1);
		});
		$('#nextBtn').click(function() {
			nextPrev(1);
		});
        const getData=async ()=>{
            let tmp=await UploadImages();
            let formData=new FormData();
            formData.append('CustomerName',$('#txtCustomerName').val());
            formData.append('MobileNo1',$('#txtMobileNo1').val());
            formData.append('MobileNo2',$('#txtMobileNo2').val());
            formData.append('Email',$('#txtEmail').val());
            formData.append('GenderID', $('#lstGender').val());
            formData.append('DOB', $('#txtDOB').val());
            formData.append('CusTypeID',$('#lstCusType').val());
            formData.append('ConTypeIDs', $('#lstConTypeIDs').val());
            formData.append('isEnableCreditLimit',$('#lstCreditLimitStatus').val());
            formData.append('CreditLimit',$('#txtCreditLimit').val());
            formData.append('CreditDays',$('#txtCreditDays').val());
            formData.append('ActiveStatus',$('#lstActiveStatus').val());
            formData.append('Address',$('#txtAddress').val());
            formData.append('PostalCodeID',$('#lstCity option:selected').attr('data-postal'));
            formData.append('CityID',$('#lstCity').val());
            formData.append('TalukID',$('#lstTaluk').val());
            formData.append('DistrictID',$('#lstDistricts').val());
            formData.append('StateID',$('#lstState').val());
            formData.append('CountryID',$('#lstCountry').val());
            formData.append('removeCustomerImage', $('#txtCustomerImage').attr('data-remove'));
            if(tmp.coverImage.uploadPath!=""){
                formData.append('CustomerImage', JSON.stringify(tmp.coverImage));
            }

            let SAddress = [];
            $("#tblShippingAddress tbody tr").each(function() {
                let Address = JSON.parse($(this).find("td:eq(3)").html());
                let isSelectedDefaultShipping = $(this).find('input[type="radio"][name="SAddress"]:checked').length;
                Address.isDefault = isSelectedDefaultShipping ? 1 : 0;
                SAddress.push(Address);
            });
            formData.append('SAddress',JSON.stringify(SAddress));
            return formData;
        }
        const Save=async()=>{
            let formData=await getData();
            swal({
                title: "Are you sure?",
                text: "You want @if($isEdit==true)Update @else Save @endif this customer!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-outline-success",
                confirmButtonText: "Yes, @if($isEdit==true) Update @else Save @endif it!",
                closeOnConfirm: false
            },function(){
                swal.close();
                btnLoading($('#nextBtn'));
                let postUrl=@if($isEdit) "{{url('/')}}/admin/users-and-permissions/manage-customers/edit/{{$CustomerID}}" @else "{{url('/')}}/admin/users-and-permissions/manage-customers/create" @endif;
                $.ajax({
                    type:"post",
                    url:postUrl,
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    data:formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    error:function(e, x, settings, exception){ajax_errors(e, x, settings, exception);},
                    complete: function(e, x, settings, exception){btnReset($('#nextBtn'));ajaxindicatorstop();$("html, body").animate({ scrollTop: 0 }, "slow");},
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
                                    window.location.replace("{{url('/')}}/admin/users-and-permissions/manage-customers");
                                @else
                                    window.location.reload();
                                @endif
                            });
                        }else{
                            $('.tab').hide();
                            currentTab = 0;
                            showTab(currentTab);
                            setTimeout(() => {
                                $('#nextBtn').html('Next');
                            }, 100);
                            toastr.error(response.message, "Failed", {
                                positionClass: "toast-top-right",
                                containerId: "toast-top-right",
                                showMethod: "slideDown",
                                hideMethod: "slideUp",
                                progressBar: !0
                            })
                            if(response['errors']!=undefined){
                                $('.errors').html('');
                                $.each( response['errors'], function( KeyName, KeyValue ) {
                                    var key=KeyName;
                                    if(key=="Email"){$('#txtEmail-err').html(KeyValue);}
                                    if(key=="MobileNo1"){$('#txtMobileNo1-err').html(KeyValue);}
                                    if(key=="CustomerImage"){$('#txtCustomerImage-err').html(KeyValue);}

                                });
                            }
                        }
                    }
                });
            });
        }
        const getAddressModal=(data={})=>{
            $.ajax({
                type:"post",
                url:"{{url('/')}}/shipping-address-form",
                data:{"data":JSON.stringify(data)},
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"html",
                async:true,
                error:function(e, x, settings, exception){},
                success:async(response)=>{
                    if(response!=""){
                        bootbox.dialog({
                            title:"Shipping Address",
                            closeButton: true,
                            message: response,
                            className:"AddressModal",
                            buttons: {}
                        });
                    }
                }
            });
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
                    error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
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
        getCountry({},'lstCountry');
        getConType({},'lstConTypeIDs');
        getGender({},'lstGender');
        getCustomerType();

        $('#lstCreditLimitStatus').change(function(){
            if($(this).val() == 0){
                $('#txtCreditLimit').prop('disabled',true);
                $('#txtCreditLimit').val('');
            }else{
                $('#txtCreditLimit').prop('disabled',false);
{{--                $('#txtCreditLimit').val('{{NumberFormat($SETTINGS['customer-default-credit-limit'],$Settings['price-decimals'])}}');--}}
                $('#txtCreditLimit').val('{{ NumberFormat(($isEdit ? $EditData->CreditLimit : $SETTINGS['customer-default-credit-limit']),$Settings['price-decimals']) }}');
            }
        });
        $('#lstCreditOverDraft').change(function(){
            if($(this).val() == 0){
                $('#txtCreditDays').prop('disabled',true);
                $('#txtCreditDays').val('');
            }else{
                $('#txtCreditDays').prop('disabled',false);
                {{--$('#txtCreditDays').val('{{$SETTINGS['default-customers-credit-days']}}');--}}
                $('#txtCreditDays').val('{{ $isEdit ? $EditData->CreditDays : $SETTINGS['default-customers-credit-days'] }}');
            }
        });
        @if($isEdit)
        $('#lstCreditLimitStatus').trigger('change');
        $('#lstCreditOverDraft').trigger('change');
        $('#btnGSearchPostalCode').trigger('click');
        @endif

    });
</script>
@endsection
