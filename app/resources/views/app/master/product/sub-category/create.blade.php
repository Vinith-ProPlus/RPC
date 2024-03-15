@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Product Master</li>
					<li class="breadcrumb-item"><a href="{{url('/')}}/admin/master/product/sub-category">{{$PageTitle}}</a></li>
                    <li class="breadcrumb-item">@if($isEdit==true)Update @else Create @endif</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row d-flex justify-content-center">
		<div class="col-12 col-sm-12 col-lg-6">
			<div class="card">
				<div class="card-header text-center"><h5 class="mt-10">{{$PageTitle}}</h5></div>
				<div class="card-body " >
                    <div class="row mb-30  d-flex justify-content-center">
                        <div class="col-sm-6">
                            <input type="file" class="dropify imageScrop" data-aspect-ratio="{{$Settings['image-crop-ratio']['w']/$Settings['image-crop-ratio']['h']}}" data-remove="0" data-is-cover-image="1" id="txtPSCImage" data-default-file="<?php if($isEdit==true){if($EditData[0]->PSCImage!=""){ echo url('/')."/".$EditData[0]->PSCImage;}}?>"  data-allowed-file-extensions="<?php echo implode(" ",$FileTypes['category']['Images']) ?>" >
                            <div class="errors" id="txtPSCImage-err"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="txtPSCName"> Product Sub Category Name <span class="required"> * </span></label>
                                <input type="text" class="form-control  {{$Theme['input-size']}}" id="txtPSCName" value="<?php if($isEdit==true){ echo $EditData[0]->PSCName;} ?>">
                                <div class="errors" id="txtPSCName-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-20">
                            <div class="form-group">
                                <label for="lstPCategory"> Product Category <span class="required"> * </span> <span  class="addOption" id="btnReloadPCategory"  title="Reload Product Category" ><i class="fa fa-refresh"></i></span>  @if($OtherCruds['PCategory']['add']==1)  <span class="addOption" id="btnAddPCategory" title="add new product category" ><i class="fa fa-plus"></i></span> @endif</label>
                                <select class="form-control  {{$Theme['input-size']}} select2" id="lstPCategory" data-selected="<?php if($isEdit){echo $EditData[0]->PCID;} ?>">
                                    <option value="">Select a Product Category</option>
                                </select>
                                <div class="errors" id="lstPCategory-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-20">
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <button class="btn {{$Theme['button-size']}} btn-outline-info btn-air-info" id="btnAddVideoUrl">Add Video URL</button>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row" id="divVideoUrls">
                                        @if($isEdit && $EditData[0]->VideoURLs)
                                            @foreach ($EditData[0]->VideoURLs as $item)
                                                <div class="col-12 mt-10 divVideoInputs">
                                                    <div class="row">
                                                        <div class="col-sm-11">
                                                            <div class="input-group my-2">
                                                                <input type="text" class="form-control txtVideoUrl" placeholder="Video URL" value="{{$item}}">
                                                                <button class="btn btn-outline-danger {{$Theme['button-size']}} btnPlayVideo" title="Play Video"><i class="fa fa-play"></i></button>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-1 d-flex align-items-center justify-content-center">
                                                            <button class="btn btnDeleteVideo" title="Delete Video"><i class="fa fa-trash"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="errors Video err-sm"></div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-20">
                            <div class="form-group">
                                <label class="lstActiveStatus"> Active Status</label>
                                <select class="form-control  {{$Theme['input-size']}}" id="lstActiveStatus">
                                    <option value="Active" @if($isEdit==true) @if($EditData[0]->ActiveStatus=="Active") selected @endif @endif >Active</option>
                                    <option value="Inactive" @if($isEdit==true) @if($EditData[0]->ActiveStatus=="Inactive") selected @endif @endif>Inactive</option>
                                </select>
                                <div class="errors" id="txtCategory-err"></div>
                            </div>
                        </div>
                    </div>
                    <div id="dynamicForm"></div>
				</div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            @if($crud['view']==true)
                            <a href="{{url('/')}}/admin/master/product/sub-category/" class="btn {{$Theme['button-size']}} btn-outline-dark mr-10" id="btnCancel">Back</a>
                            @endif
                            
                            @if((($crud['add']==true) && ($isEdit==false))||(($crud['edit']==true) && ($isEdit==true)))
                                <button class="btn {{$Theme['button-size']}} btn-outline-success btn-air-success" id="btnSave">@if($isEdit==true) Update @else Save @endif</button>
                            @endif
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
<textarea style="display:none" id="txtAData">
    <?php 
        if($isEdit){
            if(isset($EditData[0]->AdditionalSetting)){
                echo json_encode(unserialize($EditData[0]->AdditionalSetting));
            }else{
                echo json_encode(array());
            }
        }
    ?>
</textarea>
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
        let df = null;
        function extractYouTubeVideoId(url) {
            var videoIdMatch = url.match(/[?&]v=([^&]+)/);
            return videoIdMatch ? videoIdMatch[1] : null;
        }
        function isYouTubeUrl(url) {
            return /^(https?:\/\/)?(www\.)?(youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/i.test(url);
        }
        function isValidURL(url) {
            const urlPattern = /^(ftp|http|https):\/\/[^ "]+$/;
            return urlPattern.test(url);
        }
        const appInit=async()=>{
            getCategory();
            let TData=[];
            @if($isEdit==true)
                TData=JSON.parse($('#txtAData').val());
            @endif
            df=$('#dynamicForm').dynamicForm({Columns:2,isValidate:true,Data:TData,BaseUrl:"{{url('/')}}/"});
        }
        const getCategory=async()=>{
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
        }
        const formValidation=async()=>{
            $('.errors').html('');
            let status=await df.Validate();
            let PSCName=$('#txtPSCName').val();
            let Category=$('#lstPCategory').val();
            let VideoUrl=$('.txtVideoUrl');
            if(PSCName==""){
                $('#txtPSCName-err').html('The Product Sub Category Name is required.');status=false;
            }else if(PSCName.length<2){
                $('#txtPSCName-err').html('Product Sub Category Name must be greater than 2 characters');status=false;
            }else if(PSCName.length>100){
                $('#txtPSCName-err').html('Product Sub Category Name may not be greater than 100 characters');status=false;
            }
            if(Category==""){
                $('#lstPCategory-err').html('The Product Category Name is required.');status=false;
            }
            if(VideoUrl.length > 0){
                VideoUrl.each(function(){
                    let Url = $(this).val();
                    if(!Url){
                        $(this).closest('.divVideoInputs').find('.errors').html('Enter a video URL!');status=false;
                        return false;
                    }else if(Url && !isValidURL(Url)){
                        $(this).closest('.divVideoInputs').find('.errors').html('Enter a Valid URL!');status=false;
                        return false;
                    }
                });
            }
            if(status==false){$("html, body").animate({ scrollTop: 0 }, "slow");}
            return status;
        }
        const GetData=async()=>{
            let tmp=await UploadImages();
            let formData=await df.getFormData();
            let AData=await df.getData();
            let VideoURLs = [];
            $('.txtVideoUrl').each(function(){
                VideoURLs.push($(this).val());
            });
            formData.append('AData',JSON.stringify(AData));
            formData.append('VideoURLs',JSON.stringify(VideoURLs));
            formData.append('PSCName',$('#txtPSCName').val());
            formData.append('PCategory',$('#lstPCategory').val());
            formData.append('ActiveStatus',$('#lstActiveStatus').val());
            formData.append('removePSCImage', $('#txtPSCImage').attr('data-remove'));
            if(tmp.coverImage.uploadPath!=""){
                formData.append('PSCImage', JSON.stringify(tmp.coverImage));
            }
            return formData;
        }
        $(document).on('click','.dropify-clear',function(){
            $(this).parent().find('input[type="file"]').attr('data-remove',1);
        });
        $('#btnSave').click(async function(){
            let status=await formValidation();
            if(status){
                swal({
                    title: "Are you sure?",
                    text: "You want @if($isEdit==true)Update @else Save @endif this Product Sub Category!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, @if($isEdit==true)Update @else Save @endif it!",
                    closeOnConfirm: false
                },async function(){
                    swal.close();
                    btnLoading($('#btnSave'));
                    let formData=await GetData();
                    let postUrl= @if($isEdit==true) "{{url('/')}}/admin/master/product/sub-category/edit/{{$PSCID}}"; @else "{{url('/')}}/admin/master/product/sub-category/create";@endif
                    
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
                                        window.location.replace("{{url('/')}}/admin/master/product/sub-category");
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
                                if(response['errors']!=undefined){
                                    $('.errors').html('');
                                    $.each( response['errors'], function( KeyName, KeyValue ) {
                                        var key=KeyName;
                                        if(key=="PSCName"){$('#txtPSCName-err').html(KeyValue);}
                                        if(key=="Category"){$('#lstPCategory-err').html(KeyValue);}
                                        if(key=="PSCImage"){$('#txtPSCImage-err').html(KeyValue);}
                                    });
                                }
                            }
                        }
                    });
                });
            }
        });
        $('#btnAddVideoUrl').click(function() {
            let html = `<div class="col-12 mt-10 divVideoInputs">
                            <div class="row">
                                <div class="col-sm-11">
                                    <div class="input-group my-2">
                                        <input type="text" class="form-control txtVideoUrl" placeholder="Video URL">
                                        <button class="btn btn-outline-danger {{$Theme['button-size']}} btnPlayVideo" title="Play Video"><i class="fa fa-play"></i></button>
                                    </div>
                                </div>
                                <div class="col-sm-1 d-flex align-items-center justify-content-center">
                                    <button class="btn btnDeleteVideo" title="Delete Video"><i class="fa fa-trash"></i></button>
                                </div>
                            </div>
                            <div class="errors Video err-sm"></div>
                        </div>`;
            $('#divVideoUrls').append(html);
        });


        $(document).on('click','.btnDeleteVideo',function(){
            $(this).closest('.divVideoInputs').remove();
        });
        $(document).on('click','.btnPlayVideo',function(){
            $('.errors.Video').html("");
            var Url = $(this).closest('.divVideoInputs').find('.txtVideoUrl').val();
            if(!Url){
                $(this).closest('.divVideoInputs').find('.errors').html('Enter a video URL!');
            }else if(Url && !isValidURL(Url)){
                $(this).closest('.divVideoInputs').find('.errors').html('Enter a Valid URL!');
            }else{
                var embedUrl = Url;
    
                if(isYouTubeUrl(Url)){
                    var videoId = extractYouTubeVideoId(Url);
                    embedUrl = 'https://www.youtube.com/embed/' + videoId;
                }

                var videoPlayerHtml = '<iframe width="100%" height="400" src="' + embedUrl + '" frameborder="0" allowfullscreen></iframe>';
                
                bootbox.dialog({
                    title: 'Video Player',
                    message: videoPlayerHtml,
                    className: 'video-modal',
                    closeButton: true,
                }).find('.modal-dialog').css('--bs-modal-width', '900px');
                
            }
        });

        appInit();
    });
</script>
@endsection