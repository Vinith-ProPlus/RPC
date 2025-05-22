@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-6">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}/admin"><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Settings</li>
					<li class="breadcrumb-item">{{$PageTitle}}</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid mt-40">
	<div class="row d-flex justify-content-center">
		<div class="col-12 col-sm-8 col-lg-5">
            <div class="card">
				<div class="card-header text-center">
					<div class="form-row align-items-center">
						<div class="col-md-4">	</div>
						<div class="col-md-4 my-2"><h5>{{$PageTitle}}</h5></div>
						<div class="col-md-4 my-2 text-right text-md-right"></div>
					</div>
				</div>
                <div class="card-body">
                    <div class="row justify-content-center" >
                        <div class="col-6 text-center">
                            <label>Image </label>
                            <input type="file" class="dropify" id="txtImage" @if($crud['edit']==0 ) disabled @endif  data-default-file="<?php if($data->Image !=""){ echo url('/')."/".$data->Image;}?>"  data-allowed-file-extensions="jpeg jpg png gif webp">
                                <div class="errors err-sm" id="txtImage-err"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Title <span class="required"> * </span> </label>
                                <input type="text" class="form-control" id="txtTitle" value="{{$data->Title}}" @if($crud['edit']==0 ) disabled @endif>
                                <div class="errors err-sm" id="txtTitle-err"></div>
                            </div>
                        </div>
                        <div class="col-12 mt-5">
                            <div class="form-group">
                                <label for="">Description <span class="required"> * </span> </label>
                                <textarea class="form-control" id="txtDescription"  rows="3" @if($crud['edit']==0 ) disabled @endif>{{$data->Description}}</textarea>
                                <div class="errors err-sm" id="txtDescription-err"></div>
                            </div>
                        </div>
                        <div class="col-6 mt-5">
                            <div class="form-group">
                                <label for="txtCurrentVersion">Current Version</label>
                                <input type="text" disabled class="form-control" id="txtCurrentVersion" value="{{$data->NewVersion}}">
                                <div class="errors err-sm" id="txtCurrentVersion-err"></div>
                            </div>
                        </div>
                        <div class="col-6 mt-5">
                            <div class="form-group">
                                <label for="txtNewVersion">New Version <span class="required"> * </span> </label>
                                <input type="text" class="form-control" id="txtNewVersion" value="" @if($crud['edit']==0 ) disabled @endif>
                                <div class="errors err-sm" id="txtNewVersion-err"></div>
                            </div>
                        </div>
                        <div class="col-6 mt-5">
                            <div class="form-group">
                                <label for="txtAndroidLink">Android Link </label>
                                <input type="url"  class="form-control" id="txtAndroidLink" value="{{$data->AndroidLink}}" @if($crud['edit']==0 ) disabled @endif>
                                <div class="errors err-sm" id="txtAndroidLink-err"></div>
                            </div>
                        </div>
                        <div class="col-6 mt-5">
                            <div class="form-group">
                                <label for="txtIOSLink">IOS Link </label>
                                <input type="url" class="form-control" id="txtIOSLink" value="{{$data->IOSLink}}" @if($crud['edit']==0 ) disabled @endif>
                                <div class="errors err-sm" id="txtIOSLink-err"></div>
                            </div>
                        </div>
                        <div class="col-6 mt-5">
                            <div class="form-group">
                                <label for="txtSubmitText">Submit Text <span class="required"> * </span> </label>
                                <input type="text"  class="form-control" id="txtSubmitText" value="{{$data->SubmitText}}" @if($crud['edit']==0 ) disabled @endif>
                                <div class="errors err-sm" id="txtSubmitText-err"></div>
                            </div>
                        </div>
                        <div class="col-6 mt-5">
                            <div class="form-group">
                                <label for="txtIgnoreText">Ignore Text <span class="required"> * </span> </label>
                                <input type="text" class="form-control" id="txtIgnoreText" value="{{$data->IgnoreText}}" @if($crud['edit']==0 ) disabled @endif>
                                <div class="errors err-sm" id="txtIgnoreText-err"></div>
                            </div>
                        </div>
                        <div class="col-6 mt-5">
                            <div class="form-group">
                                <label for="">Force Update <span class="required"> * </span> </label>
                                <select name="lstForceUpdate" id="lstForceUpdate" class="form-control" @if($crud['edit']==0 ) disabled @endif>
                                    <option value="1"  @if($data->forceUpdate=="1") selected @endif>Enable</option>
                                    <option value="0" @if($data->forceUpdate=="0") selected @endif>Disable</option>
                                </select>
                                <div class="errors err-sm" id="lstForceUpdate-err"></div>
                            </div>
                        </div>
                        <div class="col-6 mt-5">
                            <div class="form-group">
                                <label for="">Update To <span class="required"> * </span> </label>
                                <select name="lstUpdateTo" id="lstUpdateTo" class="form-control" @if($crud['edit']==0 ) disabled @endif>
                                    <option value="All"  @if($data->UpdateTo=="All") selected @endif>Android and IOS</option>
                                    <option value="Android"  @if($data->UpdateTo=="Android") selected @endif>Android Only</option>
                                    <option value="IOS" @if($data->UpdateTo=="IOS") selected @endif>IOS Only</option>
                                </select>
                                <div class="errors err-sm" id="lstUpdateTo-err"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($crud['edit']==1 )
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <button class="btn btn-sm btn-outline-success btn-air-success" id="btnSave">Save </button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        function isValidURL(url) {
            try {
                new URL(url);
                return true;
            } catch (_) {
                return false;
            }
        }

        const formValidation = () => {
            let status = true;

            let Title = $('#txtTitle').val().trim();
            let Description = $('#txtDescription').val().trim();
            let CurrentVersion = $('#txtCurrentVersion').val().trim();
            let NewVersion = $('#txtNewVersion').val().trim();
            let AndroidLink = $('#txtAndroidLink').val().trim();
            let IOSLink = $('#txtIOSLink').val().trim();
            let SubmitText = $('#txtSubmitText').val().trim();
            let IgnoreText = $('#txtIgnoreText').val().trim();
            let forceUpdate = $('#lstForceUpdate').val().trim();
            let UpdateTo = $('#lstUpdateTo').val().trim();

            // Clear all previous error messages
            $('.error-message').html('');

            // Title validation
            if (Title === "") {
                $('#txtTitle-err').html('Title is required');
                status = false;
            } else if (Title.length < 2) {
                $('#txtTitle-err').html('The title must be at least 2 characters.');
                status = false;
            } else if (Title.length > 50) {
                $('#txtTitle-err').html('The title must not exceed 50 characters.');
                status = false;
            }

            // Description validation
            if (Description === "") {
                $('#txtDescription-err').html('Description is required');
                status = false;
            } else if (Description.length < 10) {
                $('#txtDescription-err').html('The description must be at least 10 characters.');
                status = false;
            }

            // NewVersion validation
            if (NewVersion === "") {
                $('#txtNewVersion-err').html('New Version is required');
                status = false;
            }

            // SubmitText validation
            if (SubmitText === "") {
                $('#txtSubmitText-err').html('Submit text is required');
                status = false;
            } else if (SubmitText.length < 2) {
                $('#txtSubmitText-err').html('The submit text must be at least 2 characters.');
                status = false;
            } else if (SubmitText.length > 50) {
                $('#txtSubmitText-err').html('The submit text must not exceed 50 characters.');
                status = false;
            }

            // IgnoreText validation
            if (IgnoreText === "") {
                $('#txtIgnoreText-err').html('Ignore text is required');
                status = false;
            } else if (IgnoreText.length < 2) {
                $('#txtIgnoreText-err').html('The ignore text must be at least 2 characters.');
                status = false;
            } else if (IgnoreText.length > 100) {
                $('#txtIgnoreText-err').html('The ignore text must not exceed 100 characters.');
                status = false;
            }

            // Android Link validation
            if (AndroidLink !== "" && !isValidURL(AndroidLink)) {
                $('#txtAndroidLink-err').html('Android link is not a valid URL');
                status = false;
            }

            // iOS Link validation
            if (IOSLink !== "" && !isValidURL(IOSLink)) {
                $('#txtIOSLink-err').html('iOS link is not a valid URL');
                status = false;
            }

            // Force Update validation
            if (forceUpdate === "") {
                $('#lstForceUpdate-err').html('Force update is required');
                status = false;
            }

            // UpdateTo validation
            if (UpdateTo === "") {
                $('#lstUpdateTo-err').html('Update To is required');
                status = false;
            }
            return status;
        }

        const getData=()=>{
            let formData=new FormData();
            formData.append('Title',$('#txtTitle').val());
            formData.append('Description',$('#txtDescription').val());
            formData.append('CurrentVersion',$('#txtCurrentVersion').val());
            formData.append('NewVersion',$('#txtNewVersion').val());
            formData.append('AndroidLink',$('#txtAndroidLink').val());
            formData.append('IOSLink',$('#txtIOSLink').val());
            formData.append('SubmitText',$('#txtSubmitText').val());
            formData.append('IgnoreText',$('#txtIgnoreText').val());
            formData.append('forceUpdate',$('#lstForceUpdate').val());
            formData.append('UpdateTo',$('#lstUpdateTo').val());

            if($('#txtImage').val()!=""){
                formData.append('Image',$('#txtImage')[0].files[0]);
            }

            return formData;
        }
        $(document).on('click','#btnSave',function(){
            let status=formValidation();
            if(status==true){

                swal({
                    title: "Are you sure?",
                    text: "You want Save !",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, Confirm",
                    closeOnConfirm: false
                },function(){
                    swal.close();
                    btnLoading($('#btnUpload'));
                    let formData=getData();
                    let posturl="{{ url('/') }}/admin/settings/app-update/update/{{$data->SLNO}}";
                    $.ajax({
                        type:"post",
                        url:posturl,
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
                        complete: function(e, x, settings, exception){btnReset($('#nextBtn'));ajaxIndicatorStop();},
                        success:function(response){
                            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
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
                                        if(key=="Title"){$('#txtTitle-err').html(KeyValue);}
                                        if(key=="Description"){$('#txtDescription-err').html(KeyValue);}
                                        if(key=="CurrentVersion"){$('#txtCurrentVersion-err').html(KeyValue);}
                                        if(key=="NewVersion"){$('#txtNewVersion-err').html(KeyValue);}
                                        if(key=="AndroidLink"){$('#txtAndroidLink-err').html(KeyValue);}
                                        if(key=="IOSLink"){$('#txtIOSLink-err').html(KeyValue);}
                                        if(key=="SubmitText"){$('#txtSubmitText-err').html(KeyValue);}
                                        if(key=="IgnoreText"){$('#txtIgnoreText-err').html(KeyValue);}
                                        if(key=="forceUpdate"){$('#lstForceUpdate-err').html(KeyValue);}
                                        if(key=="UpdateTo"){$('#lstUpdateTo-err').html(KeyValue);}
                                        if(key=="Image"){$('#txtImage-err').html(KeyValue);}
                                    });
                                }
                            }
                        }
                    });
                })
            }else{
                toastr.error('Some fields are required.', "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
            }
        });
    });
</script>
@endsection
