@extends('home.home-layout')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
    .select2-container--default .select2-selection--multiple
    {
        border: solid black 1px !important;
        outline: 0;
        background-color: white !important;
        border: 1px solid #dfdfdf !important;
        border-radius: 0px !important;
        cursor: text;
    }
    .select2-search__field {
        min-height: 35px !important; /* Adjust the font size as needed */
        padding: .375rem .75rem !important;
        padding-left: 0.75rem !important;
        font-size: 1.2rem !important;
        font-weight: 400 !important;
    }
</style>
<div class="container-fluid">
	<div class="row d-flex justify-content-center">
		<div class="col-sm-9 mt-3">
			<div class="card">
				<div class="card-header text-center"><h4 class="m-0">@if($isEdit) Profile @else Registration Form @endif</h4></div>
				<div class="card-body">
                    <div class="row customerRegister">
                        <div class="col-sm-12">
                            <div class="row mb-3 d-flex justify-content-center">
                                {{-- <div class="col-sm-4">
                                    <input type="file" class="dropify imageScrop" data-aspect-ratio="1" data-remove="0" data-is-cover-image="1" id="txtCustomerImage" data-default-file="@if($UserData->ProfileImage){{$UserData->ProfileImage}}@endif">
                                    <div class="errors" id="txtCustomerImage-err"></div>
                                </div> --}}
                                <div class="col-sm-4 d-flex justify-content-center">
                                    <div style="position: relative; display: inline-block;">
                                        <img loading="lazy" src="@if($isEdit){{$EditData->CustomerImage}} @elseif($UserData->ProfileImage){{$UserData->ProfileImage}}@endif" alt="" class="rounded-circle border border-secondary" height="200px" width="200px">
                                        <input type="file" class="imageScrop d-none" data-aspect-ratio="1" data-remove="0" data-is-cover-image="1" id="txtCustomerImage">
                                        <button id="btnEditImage" class="btn btn-sm btn-warning rounded-circle">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="txtCustomerName">Customer Name <span class="required">*</span></label>
                                        <input type="text" id="txtCustomerName" class="form-control" placeholder="Customer Name" value="@if($isEdit){{$EditData->CustomerName}} @elseif($UserData->Name){{$UserData->Name}}@endif">
                                        <span class="errors Customer err-sm" id="txtCustomerName-err"></span>
                                    </div>
                                </div>
                                @if($isEdit)
                                    <div class="col-sm-6">
                                        <div class="row col-sm-12">
                                            <div class="col-sm-10">
                                                <div class="form-group">
                                                    <label for="txtEmail">Email <span class="required">*</span></label>
                                                    <input type="text" id="txtEmail" class="form-control"
                                                           placeholder="Email"
                                                           value="@if($isEdit){{$EditData->Email}} @elseif($UserData->EMail){{$UserData->EMail}}@endif"
                                                           disabled>
                                                    <span class="errors Customer err-sm" id="txtEmail-err"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 d-flex align-items-center">
                                                <div class="form-group">
                                                    <button class="btn btn-success changeModelBtn" data-change="email address">
                                                        Change
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-20">
                                        <div class="row col-sm-12">
                                            <div class="col-sm-10">
                                                <div class="form-group">
                                                    <label for="txtMobileNo1">Mobile Number <span
                                                            class="required">*</span></label>
                                                    <input type="text" id="txtMobileNo1" class="form-control"
                                                           placeholder="Mobile Number" disabled
                                                           value="@if($isEdit){{$EditData->MobileNo1}} @elseif($UserData->MobileNumber){{$UserData->MobileNumber}}@endif">
                                                    <span class="errors Customer err-sm" id="txtMobileNo1-err"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 d-flex align-items-center">
                                                <div class="form-group">
                                                    <button class="btn btn-success changeModelBtn"
                                                            data-change="mobile number">Change
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="txtEmail">Email <span class="required">*</span></label>
                                            <input type="text" id="txtEmail" class="form-control"
                                                   placeholder="Email"
                                                   value="@if($UserData->EMail){{$UserData->EMail}}@endif"
                                                   @disabled($UserData->EMail)>
                                            <span class="errors Customer err-sm" id="txtEmail-err"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-20">
                                        <div class="form-group">
                                            <label for="txtMobileNo1">Mobile Number <span
                                                    class="required">*</span></label>
                                            <input type="text" id="txtMobileNo1" class="form-control"
                                                   placeholder="Mobile Number"
                                                   value="@if($UserData->MobileNumber){{$UserData->MobileNumber}}@endif"
                                                @disabled($UserData->MobileNumber)>
                                            <span class="errors Customer err-sm" id="txtMobileNo1-err"></span>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-sm-6 mt-20">
                                    <div class="form-group">
                                        <label for="txtMobileNo2">Alternate Mobile Number </label>
                                        <input type="text" id="txtMobileNo2" class="form-control" placeholder="Alternate Mobile Number" value="@if($isEdit){{$EditData->MobileNo2}}@endif">
                                        <span class="errors Customer err-sm" id="txtMobileNo2-err"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-20">
                                    <div class="form-group">
                                        <label for="lstGender">Gender <span class="required">*</span></label>
                                        <select class="form-control" id="lstGender" data-selected="{{ $isEdit ? $EditData->GenderID : '' }}">
                                            <option value="">Select Gender</option>
                                        </select>
                                        <span class="errors Customer err-sm" id="lstGender-err"></span>
                                    </div>
                                </div>
                                @php
                                    $minDOB = Carbon\Carbon::now()->subYears(150)->format('Y-m-d');
                                    $maxDOB = Carbon\Carbon::now()->subYears(10)->format('Y-m-d');
                                @endphp
                                <div class="col-sm-6 mt-20">
                                    <div class="form-group">
                                        <label for="txtDOB">DOB <span class="required">*</span></label>
                                        <input type="date" id="txtDOB" class="form-control" placeholder="Select DOB" min="{{ $minDOB }}" max="{{ $maxDOB }}" value="{{ $isEdit ? ($EditData->DOB ?? '') : '' }}">
                                        <span class="errors Customer err-sm" id="txtDOB-err"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-20">
                                    <div class="form-group">
                                        <label for="lstCusType">Customer Type <span class="required">*</span></label>
                                        <select class="form-control" id="lstCusType" data-selected="{{ $isEdit ? ($EditData->CusTypeID ?? '') : '' }}">
                                            <option value="">Select a Customer Type</option>
                                        </select>
                                        <span class="errors Customer err-sm" id="lstCusType-err"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-20">
                                    <div class="form-group">
                                        <label for="lstConTypeIDs">Construction Type <span class="required">*</span></label>
                                        <select class="form-control" id="lstConTypeIDs" data-selected="{{ $isEdit ? ($EditData->ConTypeIDs ?? '') : '' }}">
                                            <option value="">Select a Construction Type</option>
                                        </select>
                                        <span class="errors Customer err-sm" id="lstConTypeIDs-err"></span>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-20">
                                    <label for="txtAddress">Billing Address <span class="required">*</span></label>
                                    <textarea  id="txtAddress" class="form-control">@if($isEdit){{$EditData->Address}}@endif</textarea>
                                    <span class="errors BA err-sm" id="txtAddress-err"></span>
                                </div>
                                <div class="col-sm-6 mt-20">
                                    <div class="form-group">
                                        <label for="txtPostalCode">Postal Code <span class="required">*</span></label>
                                        <div class="input-group">
                                            <input type="text" id="txtPostalCode" class="form-control" placeholder="Postal Code" value="@if($isEdit){{$EditData->PostalCode}}@endif">
                                            <button type="button" class="btn btn-sm btn-outline-dark" id="btnGSearchPostalCode">Search <i class="fa fa-search"></i></button>
                                        </div>
                                        <div class="errors BA err-sm" id="txtPostalCode-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-20">
                                    <div class="form-group">
                                        <label for="lstCity">City <span class="required">*</span></label>
                                        <select class="form-control" id="lstCity" data-selected="@if($isEdit){{$EditData->CityID}}@endif">
                                            <option value="">Select a City</option>
                                        </select>
                                        <div class="errors BA err-sm" id="lstCity-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-20">
                                    <div class="form-group">
                                        <label for="lstTaluk">Taluk <span class="required">*</span></label>
                                        <select class="form-control" id="lstTaluk" data-selected="@if($isEdit){{$EditData->TalukID}}@endif">
                                            <option value="">Select a Taluk</option>
                                        </select>
                                        <div class="errors BA err-sm" id="lstTaluk-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-20">
                                    <div class="form-group">
                                        <label for="lstDistrict">District <span class="required">*</span></label>
                                        <select class="form-control" id="lstDistricts" data-selected="@if($isEdit){{$EditData->DistrictID}}@endif">
                                            <option value="">Select a District</option>
                                        </select>
                                        <div class="errors BA err-sm" id="lstDistricts-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-20">
                                    <div class="form-group">
                                        <label for="lstState">State <span class="required">*</span></label>
                                        <select class="form-control" id="lstState"  data-selected="@if($isEdit){{$EditData->StateID}}@endif">
                                            <option value="">Select a State</option>
                                        </select>
                                        <div class="errors BA err-sm" id="lstState-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-20">
                                    <div class="form-group">
                                        <label for="lstCountry">Country <span class="required">*</span></label>
                                        <select class="form-control" id="lstCountry" data-selected="@if($isEdit){{$EditData->CountryID}}@endif">
                                            <option value="">Select a Country</option>
                                        </select>
                                        <div class="errors BA err-sm" id="lstCountry-err"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-12 text-center">
                                    <button class="btn btn-outline-info btnAddAddress" data-title="Shipping Address">Add Shipping Address</button>
                                    <div class="errors err-sm" id="btnAddAddress-err"></div>
                                </div>
                            </div>
                            <div class="row mt-2 justify-content-center">
                                <div class="col-sm-8 d-flex justify-content-center">
                                    <table class="table" id="tblShippingAddress">
                                        <tbody>
                                            @if($isEdit)
                                                @foreach ($EditData->SAddress as $key => $item)
                                                    <tr id="{{ $key + 1 }}" data-aid="{{ $item->AID }}">
                                                        <td class="text-right checkbox1 align-middle">
                                                            <div class="radio radio-primary">
                                                                <input id="chkSA{{ $key + 1 }}" data-aid="{{ $item->AID }}" class="defaultAddress" type="radio" name="SAddress" value="{{ $key + 1 }}" {{ ($item->isDefault == "1") ? "checked=checked" : '' }}>
                                                                <label for="chkSA{{ $key + 1 }}"></label>
                                                            </div>
                                                        </td>
                                                        <td class="pointer">
                                                            <b>{{ $item->AddressType ?? '' }}</b><br>
                                                            <b>{{ $item->Address }}</b>,<br>
                                                            {{ $item->CityName }}, {{ $item->PostalCode }}.
                                                        </td>
                                                        <td class="text-center align-middle">
{{--                                                            <button type="button" class="btn btn-sm btn-outline-success m-2 btnEditSAddress"><i class="fas fa-pencil-alt"></i></button>--}}
                                                            <button type="button" class="btn btn-sm btn-outline-danger m-2 btnDeleteSAddress" data-aid="{{ $item->AID }}"><i class="fas fa-trash-alt"></i></button>
                                                        </td>
                                                        <td class="d-none">{{ json_encode($item) }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-8 errors err-sm" id="tblShippingAddress-err"></div>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="card-footer">
                    <div class="text-right">
                        <button class="btn btn-success" id="btnSave" type="button" >@if($isEdit) Update @else Register @endif</button>
                    </div>
                </div>
			</div>
		</div>
	</div>
    <div id="confirm-modal" class="newsletter-popup mfp-hide bg-img p-6 h-auto" style="background: #f1f1f1 no-repeat center/cover">
        <h2>Are you sure you want to @if($isEdit) Update @else Register @endif ?</h2>
        <div class="modal-buttons text-center">
            <button id="btnMConfirm" class="btn btn-primary mr-3">@if($isEdit) Update @else Register @endif</button>
            <button id="btnMCancel" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
    <div id="change-modal" class="newsletter-popup mfp-hide bg-img p-6 h-auto" style="background: #f1f1f1 no-repeat center/cover">
        <div class="current-contact mb-1">
            <h2 id="currentContactLabel"></h2>
            <p id="currentContactValue" class="mb-1"></p>
        </div>
        <h2 style="margin-top: 0;">New <span id="changeModalType">email</span></h2>
        <input type="text" id="changeModalField" class="form-control" value="">
        <input type="text" id="otpField" class="form-control d-none" placeholder="Enter OTP">
        <div class="modal-buttons text-center">
            <button id="btnChangeSubmit" class="btn btn-primary mr-3">Submit</button>
            <button id="btnChangeCancel" class="btn btn-secondary">Cancel</button>
        </div>
        <div class="text-center mt-1">
            <button type="button" class="btn btn-link" id="btnResendOtp">Resend OTP</button>
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
            const btnReset=async($this)=> {
                $('.waves-ripple').remove();
                $this.html($this.data('original-text'));
                $this.removeAttr('disabled');
            }
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
            $('.dropify').dropify();
        });
</script>
<!-- Image Crop Script End -->
<script>
    $(document).ready(function(){
        $('#lstConTypeIDs').select2({
            multiple: true,
            placeholder: 'Select a Construction Type'
        });
        const ajaxIndicatorStart =async(text="") =>{
            var basepath=$('#txtRootUrl').val();
            if ($('body').find('#resultLoading').attr('id') != 'resultLoading') {
                if(text==""){text="Processing";}
                $('body').append('<div id="resultLoading" style="display:none"><div style="font-weight: 700;"><img loading="lazy" src="' + basepath + '/assets/images/ajax-loader.gif"><div id="divProcessText">'+text+'</div></div><div class="bg"></div></div>');
            }
            $('#resultLoading').css({
                'width': '100%',
                'height': '100%',
                'position': 'fixed',
                'z-index': '10000000',
                'top': '0',
                'left': '0',
                'right': '0',
                'bottom': '0',
                'margin': 'auto'
            });
            $('#resultLoading .bg').css({
                'background': '#000000',
                'opacity': '0.7',
                'width': '100%',
                'height': '100%',
                'position': 'absolute',
                'top': '0'
            });
            $('#resultLoading>div:first').css({
                'width': '50%',
                'height': '75px',
                'text-align': 'center',
                'position': 'fixed',
                'top': '0',
                'left': '0',
                'right': '0',
                'bottom': '0',
                'margin': 'auto',
                'font-size': '16px',
                'z-index': '10',
                'color': '#ffffff'
            });
            $('#resultLoading .bg').height('100%');
            $('#resultLoading').fadeIn(300);
            $('body').css('cursor', 'wait');
        }
        const ajaxIndicatorStop=async()=> {
            $('#resultLoading .bg').height('100%');
            $('#resultLoading').fadeOut(300);
            $('body').css('cursor', 'default');
        }
        const UploadImages = async () => {
            let RootUrl=$('#txtRootUrl').val();
            let uploadImages=await new Promise((resolve,reject)=>{
                ajaxIndicatorStart("% Completed. Please wait for until upload process complete.");
                setTimeout(() => {
                    let count = $("input.imageScrop").length;
                    let completed = 0;
                    let rowIndex=0;
                    let images={profileImage:{uploadPath:"",fileName:""},coverImage:{uploadPath:"",fileName:""},gallery:[]};
                    const uploadComplete=async(e, x, settings, exception)=>{
                        completed++;
                        let percentage=(100*completed)/count;
                        $('#divProcessText').html(percentage + '% Completed. Please wait for until upload process complete.');
                        checkUploadCompleted();
                    }
                    const checkUploadCompleted=async()=>{
                        if(count<=completed){
                            ajaxIndicatorStop();
                            resolve(images);
                        }
                    }
                    const upload=async(formData)=>{
                        console.log(formData);
                        $.ajax({
                            type: "post",
                            url: RootUrl+"tmp/upload-image",
                            headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')},
                            data: formData,
                            dataType:"json",
                            error: function(e, x, settings, exception) {ajaxErrors(e, x, settings, exception);},
                            complete: uploadComplete,
                            success:function(response){
                                if(response.referData.isProfileImage==1){
                                    images.profileImage={uploadPath:response.uploadPath,fileName:response.fileName};
                                }else if(response.referData.isCoverImage==1){
                                    images.coverImage={uploadPath:response.uploadPath,fileName:response.fileName};
                                }else{
                                    images.gallery.push({uploadPath:response.uploadPath,fileName:response.fileName,slno:response.referData.slno});
                                }
                            }
                        });
                    }
                    $("input.imageScrop").each(function (index){
                        let id = $(this).attr('id');
                        if ($('#' + id).val() != "" ) {
                            let isProfileImage=$('#'+id).attr('data-is-profile-image');
                            let isCoverImage=$('#'+id).attr('data-is-cover-image');
                            isProfileImage=isNaN(parseInt(isProfileImage))==false?isProfileImage:0;
                            isCoverImage=isNaN(parseInt(isCoverImage))==false?isCoverImage:0;
                            rowIndex++;
                            let formData = {};
                                formData.image = $('#'+id).attr('src');
                                formData.referData = {index:rowIndex,id:id,slno:$('#'+id).attr('data-slno'),isProfileImage:isProfileImage,isCoverImage:isCoverImage};
                                upload(formData);
                        }else{
                            completed++;
                            let percentage=(100*completed)/count;
                            $('#divProcessText').html(percentage + '% Completed. Please wait for until upload process complete.');
                            checkUploadCompleted();
                        }
                    });
                }, 200);


            });
            return uploadImages;
        }
		function validateForm() {
            $('.errors').html('');
			let status=true;
            let CustomerName=$('#txtCustomerName').val();
            let MobileNo1=$('#txtMobileNo1').val();
            let MobileNo2=$('#txtMobileNo2').val();
            let Email=$('#txtEmail').val();
            let Gender=$('#lstGender').val();
            let DOB=$('#txtDOB').val();
            let CusType=$('#lstCusType').val();
            let ConType=$('#lstConTypeIDs').val();
            let AddressType=$('#txtADAddressType').val();
            let Address=$('#txtAddress').val();
            let PostalCode=$('#lstCity option:selected').attr('data-postal');
            let CityID=$('#lstCity').val();
            let TalukID=$('#lstTaluk').val();
            let DistrictID=$('#lstDistricts').val();
            let StateID=$('#lstState').val();
            let CountryID=$('#lstCountry').val();
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
            if(Email === ""){
                $('#txtEmail').html('Email is required.');status=false;
            }
            if(AddressType === ""){
                $('#txtADAddressType').html('Address Type is required.');status=false;
            }
            if(Gender === ""){
                $('#lstGender-err').html('Gender is required.');status=false;
            }

            if (DOB === "") {
                $('#txtDOB-err').html('DOB is required.');status = false;
            } else {
                let minDOB = new Date("{{ $minDOB }}");
                let maxDOB = new Date("{{ $maxDOB }}");
                let enteredDOB = new Date(DOB);
                if (enteredDOB < minDOB || enteredDOB > maxDOB) {
                    $('#txtDOB-err').html('DOB must be between 10 and 150 years ago.');status = false;
                }
            }

            if(CusType === ""){
                $('#lstCusType-err').html('Customer type is required.');status=false;
            }
            if(ConType.length === 0){
                $('#lstConTypeIDs-err').html('Construction type is required.');status=false;
            }
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
            }else if(Address.length<10){
                $('#txtAddress-err').html('Address must be greater than 10 characters');status=false;isAddress=true;
            }
            let TotRows=$('#tblShippingAddress tbody tr').length;
            let isSelectedDefaultShipping=$('input[type="radio"][name="SAddress"]:checked').length
            if(TotRows<=0){
                $('#btnAddAddress-err').html('Shipping address is required');status=false;
            }else if(isSelectedDefaultShipping<=0){
                $('#tblShippingAddress-err').html('Select a default shipping address');status=false;
            }
            if(status==false){$("html, body").animate({ scrollTop: 0 }, "slow");}

			return status;
		}
        $(document).on('click','#btnGSearchPostalCode',async function(){
            $('#txtPostalCode-err').html('')
            let PostalCode=$('#txtPostalCode').val();
            if(PostalCode!=""){
                $('#btnGSearchPostalCode').attr('disabled','disabled');
                $('#btnGSearchPostalCode').html('<i class="fa fa-spinner fa-pulse"></i>');
                let response=await getCity({PostalCode});
                if(response.length>0){
                    $('#lstCity option').remove();
                    $('#lstCity').append('<option value="">Select a City</option>');
                    for(let Item of response){
                        let selected="";
                        if(Item.CityID==$('#lstCity').attr('data-selected')){selected="selected";}
                        $('#lstCity').append('<option '+selected+' data-postal="'+Item.PostalID+'" data-taluk="'+Item.TalukID+'" data-district="'+Item.DistrictID+'" data-state="'+Item.StateID+'" data-country="'+Item.CountryID+'" data-city-name="'+Item.CityName+'" value="'+Item.CityID+'">'+Item.CityName+' </option>');
                    }
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

        $(document).on('click', '.btnEditSAddress', function () {
            let Row=$(this).closest('tr');
            let EditData=JSON.parse($(this).closest('tr').find("td:eq(3)").html());
            EditData.EditID=Row.attr('id');
            EditData.AID=Row.attr('data-aid');
            getAddressModal(EditData);
        });
        $(document).on('click', '#btnEditImage', function () {
            $('#txtCustomerImage').trigger('click');
        });
        $('#btnSave').on('click',async function () {
            let status = await validateForm();
            if (status) {
                $.magnificPopup.open({
                    items: {
                        src: '#confirm-modal'
                    },
                    type: 'inline',
                    mainClass: 'mfp mfp-custom-width',
                    removalDelay: 350
                });
            }
        });
        $('.changeModelBtn').on('click',async function () {
            var contactType = $(this).data('change');

            $('#changeModalType').text(contactType === 'email address' ? 'email address' : 'mobile number');
            $('#changeModalField').attr('type', contactType === 'email address' ? 'text' : 'number');
            $('#changeModalField').val('').attr('readonly', false);
            $('#otpField').val('').addClass('d-none');
            $('#btnChangeSubmit').text('SEND OTP');
            $('#btnResendOtp').addClass('d-none');

            $('#currentContactLabel').text('Current ' + (contactType === 'email address' ? 'email address' : 'mobile Number'));
            if (contactType === 'mobile number') {
                $('#currentContactValue').text($('#txtMobileNo1').val());
            } else {
                $('#currentContactValue').text($('#txtEmail').val());
            }

            $.magnificPopup.open({
                    items: {
                        src: '#change-modal'
                    },
                    type: 'inline',
                    mainClass: 'mfp mfp-custom-width',
                    removalDelay: 350
                });
        });

        $('#btnChangeSubmit').on('click', function() {
            var contactType = $('#changeModalType').text();
            var value = $('#changeModalField').val();
            var otp = $('#otpField').val();
            var valid = false;

            if (contactType === 'email address') {
                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                valid = emailPattern.test(value);
            } else {
                var mobilePattern = /^[0-9]{10}$/;
                valid = mobilePattern.test(value);
            }

            if (valid) {
                var formData = new FormData();
                formData.append('contactType', contactType);
                formData.append('contactValue', value);
                if (!$('#otpField').hasClass('d-none')) {
                    formData.append('OTP', otp);
                }

                $.ajax({
                    type: "post",
                    url: '{{ route('customer-update.contact.details') }}',
                    headers: { 'X-CSRF-Token': "{{ csrf_token() }}" },
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    error: function (e, x, settings, exception) {
                        ajaxErrors(e, x, settings, exception);
                    },
                    complete: function (e, x, settings, exception) {
                        btnReset($('#btnChangeSubmit'));
                        if ($('#otpField').hasClass('d-none')) {
                            $.magnificPopup.close();
                        }
                        ajaxIndicatorStop();
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                    },
                    success: function (response) {
                        if (response.status === true) {
                            if ($('#otpField').hasClass('d-none')) {
                                $('#changeModalField').attr('readonly', true);
                                $('#otpField').removeClass('d-none').val('');
                                $('#btnResendOtp').removeClass('d-none');
                                $('#btnChangeSubmit').text('SUBMIT');
                            } else {
                                $.magnificPopup.close();
                                if (contactType === 'mobile number') {
                                    $('#txtMobileNo1').val(value);
                                } else {
                                    $('#txtEmail').val(value);
                                }
                            }
                            toastr.success(response.message);
                        } else {
                            if(response.message === "OTP has Expired!"){
                                $.magnificPopup.close();
                            }
                            toastr.warning(response.message);
                        }
                    }
                });
            } else {
                toastr.warning('Please enter a valid ' + contactType);
            }
        });
        $('#btnResendOtp').on('click', function() {
            var contactType = $('#changeModalType').text();
            var value = $('#changeModalField').val();
            var valid = false;

            if (contactType === 'email address') {
                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                valid = emailPattern.test(value);
            } else {
                var mobilePattern = /^[0-9]{10}$/;
                valid = mobilePattern.test(value);
            }

            if (valid) {
                var formData = new FormData();
                formData.append('contactType', contactType);
                formData.append('contactValue', value);
                $.ajax({
                    type: "post",
                    url: '{{ route('customer-update.contact.details') }}',
                    headers: { 'X-CSRF-Token': "{{ csrf_token() }}" },
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    error: function (e, x, settings, exception) {
                        ajaxErrors(e, x, settings, exception);
                    },
                    complete: function (e, x, settings, exception) {
                        btnReset($('#btnChangeSubmit'));
                        ajaxIndicatorStop();
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                    },
                    success: function (response) {
                        if (response.status === true) {
                            if ($('#otpField').hasClass('d-none')) {
                                $('#changeModalField').attr('readonly', true);
                                $('#otpField').removeClass('d-none');
                                $('#btnResendOtp').removeClass('d-none');
                                $('#btnChangeSubmit').text('SUBMIT');
                            }
                            $('#otpField').val('');
                            toastr.success(response.message);
                        } else {
                            toastr.warning(response.message);
                        }
                    }
                });
            } else {
                toastr.warning('Please enter a valid ' + contactType);
            }
        });

        $('#btnChangeCancel').on('click', function() {
            $.magnificPopup.close();
        });

        $('#btnMConfirm').on('click',async function () {
            let formData = await getData();
            let postUrl = @if($isEdit) "{{url('/')}}/update" @else "{{url('/')}}/save" @endif;
            $.ajax({
                type: "post",
                url: postUrl,
                headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                error: function (e, x, settings, exception) { ajaxErrors(e, x, settings, exception); },
                complete: function (e, x, settings, exception) { btnReset($('#btSave')); ajaxIndicatorStop(); $("html, body").animate({ scrollTop: 0 }, "slow"); },
                success: function (response) {
                    if (response.status == true) {
                        window.location.replace("{{url('/')}}");
                    } else {
                        $.magnificPopup.close();
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                        if (response['errors'] != undefined) {
                            $('.errors').html('');
                            $.each(response['errors'], function (KeyName, KeyValue) {
                                var key = KeyName;
                                if (key == "Email") { $('#txtEmail-err').html(KeyValue); }
                                if (key == "MobileNo1") { $('#txtMobileNo1-err').html(KeyValue); }
                                if (key == "CustomerImage") { $('#txtCustomerImage-err').html(KeyValue); }
                            });
                        }
                    }
                }
            });
        });

        $('#btnMCancel').on('click', function () {
            $.magnificPopup.close();
        });

        const getData=async ()=>{
            let status = await validateForm();
            if(status){
                let tmp=await UploadImages();
                let formData=new FormData();
                formData.append('CustomerName',$('#txtCustomerName').val());
                formData.append('MobileNo1',$('#txtMobileNo1').val());
                formData.append('MobileNo2',$('#txtMobileNo2').val());
                formData.append('Email',$('#txtEmail').val());
                formData.append('GenderID', $('#lstGender').val());
                formData.append('DOB', $('#txtDOB').val());
                formData.append('CusTypeID', $('#lstCusType').val());
                formData.append('ConTypeIDs', $('#lstConTypeIDs').val());
                formData.append('AddressType',$('#txtADAddressType').val());
                formData.append('Address',$('#txtAddress').val());
                formData.append('PostalCodeID',$('#lstCity option:selected').attr('data-postal'));
                formData.append('CityID',$('#lstCity').val());
                formData.append('TalukID',$('#lstTaluk').val());
                formData.append('DistrictID',$('#lstDistricts').val());
                formData.append('StateID',$('#lstState').val());
                formData.append('CountryID',$('#lstCountry').val());
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
        }
        $(document).on('keyup change', 'input, select', function () {
            $('.errors').html('');
        });

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
                    error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);resolve([])},
                    complete: function(e, x, settings, exception){},
                    success:function(response){
                        resolve(response)
                    }
                });
            });
        }
        const getTaluks=async(data,id)=>{
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
        }
        const getDistricts=async(data,id)=>{
            let Data = [];
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
            return Data;
        }
        const getStates=async(data,id)=>{
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
        }
        const getCountry=async(data,id)=>{
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

        const getCusType = async (data, id) => {
            $('#' + id + ' option').remove();
            $('#' + id).append('<option value="">Select a Customer Type</option>');
            $.ajax({
                type: "post",
                url: "{{ route('getCustomerType') }}",
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
                    for (let Item of response) {
                        let selected = "";
                        if (Item.CusTypeID === $('#' + id).attr('data-selected')) {
                            selected = "selected";
                        }
                        $('#' + id).append('<option ' + selected + ' value="' + Item.CusTypeID + '">' + Item.CusTypeName + ' </option>');
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

        getCountry({},'lstCountry');
        getGender({},'lstGender');
        getCusType({},'lstCusType');
        getConType({},'lstConTypeIDs');
        @if($isEdit)
        $('#btnGSearchPostalCode').trigger('click');
        $('input.defaultAddress[data-aid="' + '{{ $defaultAddressAID }}' + '"]').prop('checked', true);
        @endif

    });
</script>
@endsection
