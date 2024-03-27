@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Settings</li>
					<li class="breadcrumb-item">Company</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row d-flex justify-content-center">
		<div class="col-12 col-sm-12 col-lg-8">
			<div class="card">
				<div class="card-header text-center"><h5 class="mt-10">{{$PageTitle}}</h5></div>
				<div class="card-body">
                    <div class="row">
                        <div class="row mb-30 d-flex justify-content-center">
                            <div class="col-sm-6">
                                <input type="file" class="dropify imageScrop" data-aspect-ratio="{{$Settings['image-crop-ratio']['w']/$Settings['image-crop-ratio']['h']}}" data-remove="0" data-is-cover-image="1" id="txtCompanyLogo" data-default-file="<?php if($isEdit==true){if($EditData[0]->KeyValue!=""){ echo url('/')."/".$EditData[0]->KeyValue;}}?>"  data-allowed-file-extensions="<?php echo implode(" ",$FileTypes['category']['Images']) ?>" >
                                <div class="errors" id="txtCompanyLogo-err"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 my-2">
                                <div class="form-group">
                                    <label for="txtCompanyName">Company Name <span class="required"> * </span></label>
                                    <input type="text" class="form-control {{$Theme['input-size']}}" id="txtCompanyName" value="{{$EditData[1]->KeyValue}}">
                                    <div class="errors" id="txtCompanyName-err"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 my-2">
                                <div class="form-group">
                                    <label for="txtAddress">Address <span class="required"> * </span></label>
                                    <textarea class="form-control {{$Theme['input-size']}}" id="txtAddress" rows="3">{{$EditData[2]->KeyValue}}</textarea>
                                    <div class="errors" id="txtAddress-err"></div>
                                </div>
                            </div>
                            <div class="col-sm-4 my-2">
                                <div class="form-group">
                                    <label for="txtPostalCode">Postal Code <span class="required"> * </span> <span class="addOption" id="btnReloadPostalCode" title="Reload Postal Code" ><i class="fa fa-refresh"></i></span>  @if($OtherCruds['PostalCodes']['add']==1)  <span class="addOption" id="btnAddPostalCode" title="add new postal code" ><i class="fa fa-plus"></i></span> @endif</label>
                                    <div class="input-group">
                                        <input type="text" id="txtPostalCode" class="form-control" placeholder="Postal Code" value="{{$PostalCode}}" data-id="{{$EditData[6]->KeyValue}}">
                                        <button type="button" class="btn btn-outline-dark" id="btnPostalCode">Search <i class="fa fa-search"></i></button>
                                    </div>
                                    <span class="errors MAddress" id="txtPostalCode-err"></span>
                                </div>
                            </div>
                            <div class="col-sm-4 my-2">
                                <div class="form-group">
                                    <label for="lstCity"> City <span class="required"> * </span> <span  class="addOption" id="btnReloadCity" title="Reload City" ><i class="fa fa-refresh"></i></span>  @if($OtherCruds['City']['add']==1)  <span class="addOption" id="btnAddCity" title="add new taluk" ><i class="fa fa-plus"></i></span> @endif</label>
                                    <select class="form-control  {{$Theme['input-size']}} select2" id="lstCity" data-country-id="lstCountry" data-state-id="lstState" data-district-id="lstDistrict" data-taluk-id="lstTaluk" data-postalcode-id="txtPostalCode" data-selected="{{$EditData[5]->KeyValue}}">
                                        <option value="">Select a City</option>
                                    </select>
                                    <div class="errors MAddress" id="lstCity-err"></div>
                                </div>
                            </div>
                            <div class="col-sm-4 my-2">
                                <div class="form-group">
                                    <label for="lstTaluk">Taluk <span class="required"> * </span> <span  class="addOption" id="btnReloadTaluk" title="Reload Taluk" ><i class="fa fa-refresh"></i></span>  @if($OtherCruds['Taluks']['add']==1)  <span class="addOption" id="btnAddTaluk" title="add new taluk" ><i class="fa fa-plus"></i></span> @endif</label>
                                    <select class="form-control  {{$Theme['input-size']}} select2" id="lstTaluk" data-country-id="lstCountry" data-state-id="lstState" data-district-id="lstDistrict" data-selected="{{$EditData[4]->KeyValue}}">
                                        <option value="">Select a Taluk</option>
                                    </select>
                                    <div class="errors MAddress" id="lstTaluk-err"></div>
                                </div>
                            </div>
                            <div class="col-sm-4 my-2">
                                <div class="form-group">
                                    <label for="lstDistrict">District <span class="required"> * </span> <span class="addOption" id="btnReloadDistrict" title="Reload District" ><i class="fa fa-refresh"></i></span>  @if($OtherCruds['Districts']['add']==1)  <span class="addOption" id="btnAddDistrict" title="add new district" ><i class="fa fa-plus"></i></span> @endif</label>
                                    <select class="form-control select2 " id="lstDistrict"  data-country-id="lstCountry" data-state-id="lstState" data-selected="{{$EditData[5]->KeyValue}}">
                                        <option value="">Select a District</option>
                                    </select>
                                    <span class="errors MAddress" id="lstDistrict-err"></span>
                                </div>
                            </div>
                            <div class="col-sm-4 my-2">
                                <div class="form-group">
                                    <label for="lstState">State <span class="required"> * </span> <span class="addOption" id="btnReloadState" title="Reload State" ><i class="fa fa-refresh"></i></span>  @if($OtherCruds['States']['add']==1)  <span class="addOption" id="btnAddState" title="add new state" ><i class="fa fa-plus"></i></span> @endif</label>
                                    <select class="form-control select2 " id="lstState" data-country-id="lstCountry" data-selected="{{$EditData[4]->KeyValue}}">
                                        <option value="">Select a State</option>
                                    </select>
                                    <span class="errors MAddress" id="lstState-err"></span>
                                </div>
                            </div>
                            <div class="col-sm-4 my-2">
                                <div class="form-group">
                                    <label for="lstCountry">Country <span class="required"> * </span> <span class="addOption" id="btnReloadCountry" title="Reload Country" ><i class="fa fa-refresh"></i></span>  @if($OtherCruds['Country']['add']==1)  <span class="addOption" id="btnAddCountry" title="add new country" ><i class="fa fa-plus"></i></span> @endif</label>
                                    <select class="form-control select2" id="lstCountry" data-selected="{{$EditData[3]->KeyValue}}">
                                        <option value="">Select a Country</option>
                                    </select>
                                    <span class="errors MAddress" id="lstCountry-err"></span>
                                </div>
                            </div>
                            <div class="col-sm-4 my-2">
                                <div class="form-group">
                                    <label for="txtGSTNumber">GST Number <span class="required"> * </span></label>
                                    <input type="text" class="form-control {{$Theme['input-size']}}" id="txtGSTNumber" value="{{$EditData[7]->KeyValue}}">
                                    <div class="errors" id="txtGSTNumber-err"></div>
                                </div>
                            </div>
                            <div class="col-sm-4 my-2">
                                <div class="form-group">
                                    <label for="txtPanNumber">PAN Number <span class="required"> * </span></label>
                                    <input type="text" class="form-control {{$Theme['input-size']}}" id="txtPanNumber" value="{{$EditData[11]->KeyValue}}">
                                    <div class="errors" id="txtPanNumber-err"></div>
                                </div>
                            </div>
                            <div class="col-sm-4 my-2">
                                <div class="form-group">
                                    <label for="txtEmail">Email<span class="required"> * </span></label>
                                    <input type="text" class="form-control {{$Theme['input-size']}}" id="txtEmail" value="{{$EditData[10]->KeyValue}}">
                                    <div class="errors" id="txtEmail-err"></div>
                                </div>
                            </div>
                            <div class="col-sm-4 my-2">
                                <div class="form-group">
                                    <label for="txtMobileNumber">Mobile Number <span class="required"> * </span></label>
                                    <input type="text" class="form-control {{$Theme['input-size']}}" id="txtMobileNumber" value="{{$EditData[8]->KeyValue}}">
                                    <div class="errors" id="txtMobileNumber-err"></div>
                                </div>
                            </div>
                            <div class="col-sm-4 my-2">
                                <div class="form-group">
                                    <label for="txtAMobileNumber">Alternative Mobile Number</label>
                                    <input type="text" class="form-control {{$Theme['input-size']}}" id="txtAMobileNumber" value="{{$EditData[9]->KeyValue}}">
                                    <div class="errors" id="txtAMobileNumber-err"></div>
                                </div>
                            </div>
                            <div class="col-sm-4 my-2">
                                <div class="form-group">
                                    <label for="lstBankType">Bank Type <span class="required"> * </span><span  class="addOption btnReloadBankType" id="btnReloadBankType" title="Reload Bank Type" ><i class="fa fa-refresh"></i></span> <span class="addOption btnAddBankType" id="btnAddBankType" title="Add New Bank Type" ><i class="fa fa-plus"></i></span> </label> 
                                    <select class="form-control  {{$Theme['input-size']}} select2" id="lstBankType" data-selected="{{$EditData[24]->KeyValue}}">
                                        <option value="">Select a Bank Type</option>
                                    </select>
                                    <div class="errors" id="lstBankType-err"></div>
                                </div>
                            </div>
                            <div class="col-sm-4 my-2">
                                <div class="form-group">
                                    <label for="lstBank">Bank <span class="required"> * </span><span  class="addOption btnReloadBank" id="btnReloadBank" title="Reload Bank" ><i class="fa fa-refresh"></i></span> <span class="addOption btnAddBank" id="btnAddBank" title="Add New Bank" ><i class="fa fa-plus"></i></span> </label> 
                                    <select class="form-control  {{$Theme['input-size']}} select2" id="lstBank" data-bank-type-id="lstBankType" data-selected="{{$EditData[12]->KeyValue}}">
                                        <option value="">Select a Bank</option>
                                    </select>
                                    <div class="errors" id="lstBank-err"></div>
                                </div>
                            </div>
                            <div class="col-sm-4 my-2">
                                <div class="form-group">
                                    <label for="lstBankBranch">Bank Branch <span class="required"> * </span><span  class="addOption btnReloadBankBranch" id="btnReloadBankBranch" title="Reload Bank Branch" ><i class="fa fa-refresh"></i></span> <span class="addOption btnAddBankBranch" id="btnAddBankBranch" title="Add New Bank Branch" ><i class="fa fa-plus"></i></span> </label> 
                                    <select class="form-control  {{$Theme['input-size']}} select2" id="lstBankBranch" data-bank-type-id="lstBankType" data-bank-id="lstBank" data-selected="{{$EditData[13]->KeyValue}}">
                                        <option value="">Select a Bank Branch</option>
                                    </select>
                                    <div class="errors" id="lstBankBranch-err"></div>
                                </div>
                            </div>
                            <div class="col-sm-4 my-2">
                                <div class="form-group">
                                    <label for="lstBankAccType">Bank Account Type <span class="required"> * </span><span  class="addOption btnReloadBankAccType" id="btnReloadBankAccType" title="Reload Bank Account Type" ><i class="fa fa-refresh"></i></span> <span class="addOption btnAddBankAccType" id="btnAddBankAccType" title="Add New Bank Account Type" ><i class="fa fa-plus"></i></span> </label> 
                                    <select class="form-control  {{$Theme['input-size']}} select2" id="lstBankAccType" data-selected="{{$EditData[15]->KeyValue}}">
                                        <option value="">Select a Bank Account Type</option>
                                    </select>
                                    <div class="errors" id="lstBankAccType-err"></div>
                                </div>
                            </div>
                            <div class="col-sm-4 my-2">
                                <div class="form-group">
                                    <label for="txtBankAccNo">Account Number<span class="required"> * </span></label>
                                    <input type="text" class="form-control {{$Theme['input-size']}}" id="txtBankAccNo" value="{{$EditData[14]->KeyValue}}">
                                    <div class="errors" id="txtBankAccNo-err"></div>
                                </div>
                            </div>
                            <div class="col-sm-4 my-2">
                                <div class="form-group">
                                    <label for="txtFacebook">Facebook</label>
                                    <input type="text" class="form-control {{$Theme['input-size']}}" id="txtFacebook" value="{{$EditData[16]->KeyValue}}">
                                    <div class="errors" id="txtFacebook-err"></div>
                                </div>
                            </div>
                            <div class="col-sm-4 my-2">
                                <div class="form-group">
                                    <label for="txtTwitter">Twitter</label>
                                    <input type="text" class="form-control {{$Theme['input-size']}}" id="txtTwitter" value="{{$EditData[17]->KeyValue}}">
                                    <div class="errors" id="txtTwitter-err"></div>
                                </div>
                            </div>
                            <div class="col-sm-4 my-2">
                                <div class="form-group">
                                    <label for="txtInstagram">Instagram</label>
                                    <input type="text" class="form-control {{$Theme['input-size']}}" id="txtInstagram" value="{{$EditData[18]->KeyValue}}">
                                    <div class="errors" id="txtInstagram-err"></div>
                                </div>
                            </div>
                            <div class="col-sm-4 my-2">
                                <div class="form-group">
                                    <label for="txtYouTube">YouTube</label>
                                    <input type="text" class="form-control {{$Theme['input-size']}}" id="txtYouTube" value="{{$EditData[19]->KeyValue}}">
                                    <div class="errors" id="txtYouTube-err"></div>
                                </div>
                            </div>
                            <div class="col-sm-4 my-2">
                                <div class="form-group">
                                    <label for="txtLinkedIn">LinkedIn</label>
                                    <input type="text" class="form-control {{$Theme['input-size']}}" id="txtLinkedIn" value="{{$EditData[20]->KeyValue}}">
                                    <div class="errors" id="txtLinkedIn-err"></div>
                                </div>
                            </div>
                            <div class="col-sm-4 my-2">
                                <div class="form-group">
                                    <label for="txtPinterest">Pinterest</label>
                                    <input type="text" class="form-control {{$Theme['input-size']}}" id="txtPinterest" value="{{$EditData[21]->KeyValue}}">
                                    <div class="errors" id="txtPinterest-err"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            @if((($crud['add']==true) && ($crud['edit']==true) && ($isEdit==true)))
                                <button class="btn {{$Theme['button-size']}} btn-outline-success btn-air-success" id="btnSave">Update</button>
                            @endif
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
    });
</script>
<!-- Image Crop Script End -->
<script>
    $(document).ready(function(){
        
        const appInit = async()=>{
            $('#btnReloadBankType').trigger('click');
            $('#btnReloadBankAccType').trigger('click');
            $("#btnPostalCode").click();
        }
        const getCity=async()=>{
            let PostalCode = $("#txtPostalCode").val();
            $('#lstCity').select2('destroy');
            $('#lstCity option').remove();
            $('#lstCity').append('<option value="" selected>Select a City</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/city",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                data:{PostalCode:PostalCode},
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    if (response.error) {
                        $('#txtPostalCode-err').html(response.error);
                    } else {
                        for (let Item of response) {
                            let selected = "";
                            if (Item.CityID == $('#lstCity').attr('data-selected')) { selected = "selected"; }
                            $('#lstCity').append('<option ' + selected + ' value="' + Item.CityID + '" data-country-id="'+Item.CountryID+'" data-state-id="'+Item.StateID+'" data-district-id="'+Item.DistrictID+'" data-taluk-id="'+Item.TalukID+'" data-postal-id="'+Item.PostalID+'">' + Item.CityName + '</option>');
                        }
                    }
                }
            });
            $('#lstCity').select2();
            setTimeout(() => {
                $('#lstCity').trigger('change');
            }, 2000);
        }
        
        const formValidation=()=>{
            $('.errors').html('');
            let status=true;
            let CompanyName=$('#txtCompanyName').val();
            let Address=$('#txtAddress').val();
            let GSTNumber=$('#txtGSTNumber').val();
            let PanNumber=$('#txtPanNumber').val();
            let Email=$('#txtEmail').val();
            let MobileNumber=$('#txtMobileNumber').val();
            let AMobileNumber=$('#txtAMobileNumber').val();
            let PostalCode = $('#txtPostalCode').attr('data-id');
            let City = $('#lstCity').val();
            let Taluk = $('#lstTaluk').val();
            let District = $('#lstDistrict').val();
            let State = $('#lstState').val();
            let Country = $('#lstCountry').val();
            let BankType=$('#lstBankType').val();
            let Bank=$('#lstBank').val();
            let BankBranch=$('#lstBankBranch').val();
            let BankAccType=$('#lstBankAccType').val();
            let BankAccNo=$('#txtBankAccNo').val();

            if(CompanyName==""){
                $('#txtCompanyName-err').html('The Company name is required.');status=false;
            }else if(CompanyName.length<2){
                $('#txtCompanyName-err').html('Company Name must be greater than 2 characters');status=false;
            }else if(CompanyName.length>100){
                $('#txtCompanyName-err').html('Company Name may not be greater than 100 characters');status=false;
            }
            if(Address==""){
                $('#txtAddress-err').html('The Address is required.');status=false;
            }
            if(GSTNumber==""){
                $('#txtGSTNumber-err').html('The GST Number is required.');status=false;
            }
            if(PanNumber === "") {
                $('#txtPanNumber-err').html('The PAN Number is required.');status = false;
            }
            if(Email === "") {
                $('#txtEmail-err').html('The Email is required.');status = false;
            }
            if(MobileNumber === "") {
                $('#txtMobileNumber-err').html('The Mobile Number is required.');status = false;
            }
            if(AMobileNumber === "") {
                $('#txtAMobileNumber-err').html('The Alternative Mobile Number is required.');status = false;
            }
            if(PostalCode === "") {
                $('#txtPostalCode-err').html('Postal Code is required.');status = false;
            }
            if(City === "") {
                $('#lstCity-err').html('City is required.');status = false;
            }
            if(Taluk === "") {
                $('#lstTaluk-err').html('Taluk is required.');status = false;
            }
            if(District === "") {
                $('#lstDistrict-err').html('District is required.');status = false;
            }
            if(State === "") {
                $('#lstState-err').html('State is required.');status = false;
            }
            if(Country === "") {
                $('#lstCountry-err').html('Country is required.');status = false;
            }
            if(BankType === "") {
                $('#lstBankType-err').html('The Bank Type is required.');status = false;
            }
            if(Bank === "") {
                $('#lstBank-err').html('The Bank is required.');status = false;
            }
            if(BankBranch === "") {
                $('#lstBankBranch-err').html('The Bank Branch is required.');status = false;
            }
            if(BankAccType === "") {
                $('#lstBankAccType-err').html('The Bank Account Type is required.');status = false;
            }
            if(BankAccNo === "") {
                $('#txtBankAccNo-err').html('The Bank Account Number is required.');status = false;
            }

            if(status==false){$("html, body").animate({ scrollTop: 0 }, "slow");}
            return status;
        }
        const getData = async () => {
            let tmp = await UploadImages();
            let formData = new FormData();

            formData.append('CompanyName', $('#txtCompanyName').val());
            formData.append('Address', $('#txtAddress').val());
            formData.append('GSTNumber', $('#txtGSTNumber').val());
            formData.append('PanNumber', $('#txtPanNumber').val());
            formData.append('Email', $('#txtEmail').val());
            formData.append('MobileNumber', $('#txtMobileNumber').val());
            formData.append('AMobileNumber', $('#txtAMobileNumber').val());
            formData.append('PostalCode', $('#txtPostalCode').attr('data-id'));
            formData.append('City', $('#lstCity').val());
            formData.append('Taluk', $('#lstTaluk').val());
            formData.append('District', $('#lstDistrict').val());
            formData.append('State', $('#lstState').val());
            formData.append('Country', $('#lstCountry').val());
            formData.append('BankType', $('#lstBankType').val());
            formData.append('Bank', $('#lstBank').val());
            formData.append('BankBranch', $('#lstBankBranch').val());
            formData.append('BankAccType', $('#lstBankAccType').val());
            formData.append('BankAccNo', $('#txtBankAccNo').val());
            formData.append('Facebook', $('#txtFacebook').val());
            formData.append('Twitter', $('#txtTwitter').val());
            formData.append('Instagram', $('#txtInstagram').val());
            formData.append('YouTube', $('#txtYouTube').val());
            formData.append('LinkedIn', $('#txtLinkedIn').val());
            formData.append('Pinterest', $('#txtPinterest').val());
            formData.append('removeCompanyLogo', $('#txtCompanyLogo').attr('data-remove'));

            if (tmp.coverImage.uploadPath !== "") {
                formData.append('CompanyLogo', JSON.stringify(tmp.coverImage));
            }

            return formData;
        };

        $(document).on('change','#lstBankType',function(){
            $('#btnReloadBank').trigger('click');
        });
        $(document).on('change','#lstBank',function(){
            $('#btnReloadBankBranch').trigger('click');
        });
        $(document).on('keydown', '#txtPostalCode', function () {
            $('.errors').html("");
            if (event.keyCode === 13) {
                $("#btnPostalCode").click();
            }
        });
        $(document).on('click', '#btnPostalCode', function () {
            $('.errors').html("");
            let PostalCode = $("#txtPostalCode").val();
            if(!PostalCode){
                $('#txtPostalCode-err').html('Postal Code is required');
            }else{
                getCity();
            }
        });
        $(document).on('change', '#lstCity', function () {
            if($(this).val()){
                let SelectedElem=$(this).find("option:selected");
                $("#lstCountry").attr('data-selected', SelectedElem.attr('data-country-id'));
                $("#lstState").attr('data-selected', SelectedElem.attr('data-state-id'));
                $("#lstDistrict").attr('data-selected', SelectedElem.attr('data-district-id'));
                $("#lstTaluk").attr('data-selected', SelectedElem.attr('data-taluk-id'));
                $("#txtPostalCode").attr('data-id', SelectedElem.attr('data-postal-id'));
                $("#btnReloadCountry").trigger('click');
            }else{
                $("#lstCountry").attr('data-selected', "");
                $("#lstState").attr('data-selected', "");
                $("#lstDistrict").attr('data-selected', "");
                $("#lstTaluk").attr('data-selected', "");
                $("#txtPostalCode").attr('data-id', "");
                $("#btnReloadCountry").trigger('click');
            }
        });
        $(document).on('click','.dropify-clear',function(){
            $(this).parent().find('input[type="file"]').attr('data-remove',1);
        });
        $('#btnSave').click(function(){
            let status=formValidation();
            if(status){
                swal({
                    title: "Are you sure?",
                    text: "You want @if($isEdit==true)Update @else Save @endif this Company Settings!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, @if($isEdit==true)Update @else Save @endif it!",
                    closeOnConfirm: false
                },async function(){
                    swal.close();
                    const formData=await getData();
                    btnLoading($('#btnSave'));
                    let postUrl="{{url('/')}}/admin/settings/company/update";
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
                                    window.location.reload();
                                });
                                
                            }else{
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
                                        if(key=="CompanyName"){$('#txtCompanyName-err').html(KeyValue);}
                                        if(key=="CompanyLogo"){$('#txtCompanyLogo-err').html(KeyValue);}
                                    });
                                }
                            }
                        }
                    });
                });
            }
        });
        appInit();

    });
</script>
@endsection