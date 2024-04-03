@extends('layouts.app')
@section('content')
<style xmlns="http://www.w3.org/1999/html">
    .dropify-wrapper{
        height:300px;
    }
    .cropper{
        min-height:300px
    }
</style>
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-6">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}/admin"><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Home</li>
					<li class="breadcrumb-item"><a href="{{ url('/') }}/admin/settings/steppers">{{$PageTitle}}</a></li>
					<li class="breadcrumb-item">Edit</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid mt-40">
	<div class="row d-flex justify-content-center">
		<div class="col-sm-5 col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row" id="divAdd">
                        <div class="col-sm-12 text-center">
                            <label for="lstStepperType">Stepper Type</label>
                            <select id="lstStepperType" class="form-control">
                                <option @if($isEdit && $EditData[0]->StepperType == "Web") selected @endif value="Web">Web</option>
                                <option @if($isEdit && $EditData[0]->StepperType == "Mobile") selected @endif value="Mobile">Mobile</option>
                            </select>
                        </div>
                        <div class="col-sm-12 text-center mt-10">
                            <label for="txtTitle">Stepper Title</label>
                            <input type="text" class="form-control" id="txtTitle" value="{{ isset($EditData[0]->StepperTitle) ? $EditData[0]->StepperTitle : '' }}" required>
                        </div>
                        <div class="col-sm-12 text-center mt-20 @if($isEdit && $EditData[0]->StepperType == "Mobile") d-none @endif" id="divWeb">
                            <label class="mt-20">Web Stepper Image <span class="fs-13" style="color:rgba(0,0,0,0.75)" id="lblStepper"> (Upload Size=1580px X 700px, Radio=12:5)</span></label>
                            <input type="file" class="dropify imageScrop" id="txtStepper" data-min-width=1580 data-min-height=700 data-max-width=1580 data-max-height=700 data-default-file="@if($isEdit && $EditData[0]->StepperType == "Web") {{url('/')."/".$EditData[0]->StepperImage}} @endif"  data-allowed-file-extensions="jpeg jpg png gif">
                        </div>
                        <div class="col-sm-12 text-center mt-20 @if($isEdit && $EditData[0]->StepperType == "Web") d-none @elseif(!$isEdit) d-none @endif" id="divMobile">
                            <label for="txtDescription">Description</label>
                            <textarea class="form-control" id="txtDescription" required>{{ isset($EditData[0]->Description) ? $EditData[0]->Description : '' }}</textarea>
                            <label for="txtMStepper" class="mt-10">Mobile Stepper Image <span class="fs-13" style="color:rgba(0,0,0,0.75)" id="lblStepper"></span></label>
                            <input type="file" class="dropify imageScrop" id="txtMStepper" data-default-file="@if($isEdit && $EditData[0]->StepperType == "Mobile") {{url('/')."/".$EditData[0]->StepperImage}} @endif"  data-allowed-file-extensions="jpeg jpg png gif">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            @if($crud['view']==1)
                                <a href="{{ url('/') }}/admin/settings/steppers" class="btn btn-sm btn-outline-dark mr-10">Cancel</a>
                            @endif
                            @if($crud['edit']==1 || $crud['add']==1)
                                <button class="btn btn-sm btn-outline-success btn-air-success" id="btnUpload">Update </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>

<div class="modal medium" tabindex="-1" role="dialog" id="ImgCrop">
	<div class="modal-dialog modal-dialog-centered max-width-50" role="document">
		<div class="modal-content">
			<div class="modal-header pt-10 pb-10">
				<h5 class="modal-title">Image Crop</h5>
				<button type="button" class="close display-none" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <img style="width:100%" src="" id="ImageCrop" data-id="">
                    </div>
                </div>
                <div class="row mt-10 d-flex justify-content-center">
                    <div class="col-sm-12 docs-buttons d-flex justify-content-center">
                        <div class="btn-group">
                            <button class="btn btn-outline-primary" type="button" data-method="rotate" data-option="-45" title="Rotate Left"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="$().cropper(&quot;rotate&quot;, -45)"><span class="fa fa-rotate-left"></span></span><div class="fs-12"></div></button>
                            <button class="btn btn-outline-primary" type="button" data-method="rotate" data-option="45" title="Rotate Right"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="$().cropper(&quot;rotate&quot;, 45)"><span class="fa fa-rotate-right"></span></span><div class="fs-12"> </div></button>
                            <button class="btn btn-outline-primary" type="button" data-method="scaleX" data-option="-1" title="Flip Horizontal"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="$().cropper(&quot;scaleX&quot;, -1)"><span class="fa fa-arrows-h"></span></span><div class="fs-12"></div></button>
                            <button class="btn btn-outline-primary" type="button" data-method="scaleY" data-option="-1" title="Flip Vertical"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="$().cropper(&quot;scaleY&quot;, -1)"><span class="fa fa-arrows-v"></span></span><div class="fs-12"></div></button>
                            <button class="btn btn-outline-primary" type="button" data-method="reset" title="Reset"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="$().cropper(&quot;reset&quot;)"><span class="fa fa-refresh"></span></span> <div class="fs-12"></div></button>
                            <!--<button class="btn btn-outline-warning btn-upload" id="btnUploadImage" title="Upload image file"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="Import image with Blob URLs"><span class="fa fa-upload"></span></span><div class="fs-12"></div></button>-->
                            <input class="sr-only display-none" id="inputImage" type="file" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
                        </div>
                    </div>
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-dark" id="btnCropCancel">Cancel</button>
				<button type="button" class="btn btn-outline-info" id="btnCropApply">Apply</button>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $(document).on('change','#lstStepperType',function(){
            let StepperType = $("#lstStepperType").val();
            if(StepperType == 'Mobile'){
                $('#divWeb').addClass('d-none');
                $('#divMobile').removeClass('d-none');
            }else{
                $('#divMobile').addClass('d-none');
                $('#divWeb').removeClass('d-none');
            }
        });
        $("#lstStepperType").change();

        const getData=()=>{
            let StepperType = $("#lstStepperType").val();
            let formData=new FormData();
            formData.append('StepperTitle', $('#txtTitle').val());
            formData.append('StepperType', StepperType);
            if(StepperType !== "Web"){
                formData.append('Description', $("#txtDescription").val());
            }
            formData.append('StepperImage', StepperType == "Web" ? $('#txtStepper')[0].files[0] : $('#txtMStepper')[0].files[0]);
            return formData;
        }

        $(document).on('click','#btnUpload',function(){
            let StepperType = $("#lstStepperType").val();
            let validation = true;
            let title = $('#txtTitle').val();
            let description = $("#txtDescription").val();

            if(!title){
                toastr.error('Stepper title is required', "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
                validation = false;
            }
            if(StepperType === "Web"){
                let webImage = $('#txtStepper').val();
                if(!webImage){
                    toastr.error('Image not selected', "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
                    validation = false;
                }
            } else {
                if(!description){
                    toastr.error('Description is required', "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
                    validation = false;
                }
                let mobileImage = $('#txtMStepper').val();
                if(!mobileImage){
                    toastr.error('Image not selected', "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
                    validation = false;
                }
            }

            if(validation){
                swal({
                    title: "Are you sure?",
                    text: "You want @if($isEdit==true)Update @else Save @endif this stepper!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, @if($isEdit==true)Update @else Save @endif it!",
                    closeOnConfirm: false
                },function(){
                    swal.close();
                    btnLoading($('#btnUpload'));
                    let formData=getData();
                    let posturl = "{{ url('/') }}/admin/settings/steppers/{{ $isEdit ? 'edit/'.$TranNo : 'upload' }}";
                    $.ajax({
                        type:"post",
                        url:posturl,
                        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                        data:formData,
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
                        complete: function(e, x, settings, exception){btnReset($('#nextBtn'));ajaxIndicatorStop();},
                        success:function(response){
                            document.documentElement.scrollTop = 0;
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
                                        window.location.replace("{{ url('/') }}/admin/settings/steppers");
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
                })
            }
        });
    });
</script>
@endsection
