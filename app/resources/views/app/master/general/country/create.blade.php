@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">General Master</li>
					<li class="breadcrumb-item"><a href="{{url('/')}}/admin/master/general/country/" data-original-title="" title="">{{$PageTitle}}</a></li>
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
                    <div class="row">
                        <div class="col-sm-12 mt-20">
                            <div class="form-group">
                                <label class="txtCountryName">Country Name <span class="required"> * </span></label>
                                <input type="text" class="form-control  {{$Theme['input-size']}}" id="txtCountryName" value="<?php if($isEdit==true){ echo $EditData[0]->CountryName;} ?>">
                                <div class="errors" id="txtCountryName-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-6 mt-20">
                            <div class="form-group">
                                <label class="txtShortName">Short Name <span class="required"> * </span></label>
                                <input type="text" class="form-control  {{$Theme['input-size']}}" id="txtShortName" value="<?php if($isEdit==true){ echo $EditData[0]->sortname;} ?>">
                                <div class="errors" id="txtShortName-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-6 mt-20">
                            <div class="form-group">
                                <label class="txtPhoneCode">Phone Code <span class="required"> * </span></label>
                                <input type="number" class="form-control  {{$Theme['input-size']}}" id="txtPhoneCode" value="<?php if($isEdit==true){ echo $EditData[0]->PhoneCode;} ?>">
                                <div class="errors" id="txtPhoneCode-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-6 mt-20">
                            <div class="form-group">
                                <label class="txtPhoneLength">Phone Length</label>
                                <input type="number" class="form-control  {{$Theme['input-size']}}" id="txtPhoneLength" value="<?php if($isEdit==true){ echo $EditData[0]->PhoneLength;} ?>">
                                <div class="errors" id="txtPhoneLength-err"></div>  
                            </div>
                        </div>
                        <div class="col-sm-6 mt-20">
                            <div class="form-group">
                                <label class="lstActiveStatus">Active Status</label>
                                <select class="form-control {{$Theme['input-size']}}" id="lstActiveStatus">
                                    <option value="Active" @if($isEdit==true) @if($EditData[0]->ActiveStatus=="Active") selected @endif @endif >Active</option>
                                    <option value="Inactive" @if($isEdit==true) @if($EditData[0]->ActiveStatus=="Inactive") selected @endif @endif>Inactive</option>
                                </select>
                                <div class="errors" id="lstActiveStatus-err"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-20">
                        <div class="col-sm-12 text-right">
                            @if($crud['view']==true)
                            <a href="{{url('/')}}/admin/master/general/country" class="btn {{$Theme['button-size']}} btn-outline-dark mr-10" id="btnCancel">Back</a>
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
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){

        const formValidation=()=>{
            $('.errors').html('');
            let status=true;
            let CountryName=$('#txtCountryName').val();
            let ShortName=$('#txtShortName').val();
            let PhoneCode=$('#txtPhoneCode').val();
            let PhoneLength=$('#txtPhoneLength').val();
            if(CountryName==""){
                $('#txtCountryName-err').html('Country Name is required.');status=false;
            }else if(CountryName.length<3){
                $('#txtCountryName-err').html('Country Name must be greater than 3 characters');status=false;
            }else if(CountryName.length>100){
                $('#txtCountryName-err').html('Country Name may not be greater than 100 characters');status=false;
            }
            if(ShortName==""){
                $('#txtShortName-err').html('Short Name is required.');status=false;
            }
            if(PhoneCode==""){
                $('#txtPhoneCode-err').html('Phone Code is required.');status=false;
            }
            if(status==false){$("html, body").animate({ scrollTop: 0 }, "slow");}
            return status;
        }

        $('#txtShortName').on('input', function () {
            $(this).val($(this).val().toUpperCase());
        });

        $('#btnSave').click(function(){
            let status=formValidation();
            if(status){
                swal({
                    title: "Are you sure?",
                    text: "You want @if($isEdit==true)Update @else Save @endif this Country!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, @if($isEdit==true)Update @else Save @endif it!",
                    closeOnConfirm: false
                },function(){
                    swal.close();
                    btnLoading($('#btnSave'));
                    let postUrl=@if($isEdit==true) "{{url('/')}}/admin/master/general/country/edit/{{$EditData[0]->CountryID}}"; @else "{{url('/')}}/admin/master/general/country/create"; @endif
                    let formData=new FormData();
                    formData.append('CountryName',$('#txtCountryName').val());
                    formData.append('ShortName',$('#txtShortName').val());
                    formData.append('PhoneCode',$('#txtPhoneCode').val());
                    formData.append('PhoneLength',$('#txtPhoneLength').val());
                    formData.append('ActiveStatus',$('#lstActiveStatus').val());

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
                                    @if($isEdit==true)
                                        window.location.replace("{{url('/')}}/admin/master/general/country");
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
                                        if(key=="CountryName"){$('#txtCountryName-err').html(KeyValue);}
                                        if(key=="ShortName"){$('#txtShortName-err').html(KeyValue);}
                                        if(key=="PhoneCode"){$('#txtPhoneCode-err').html(KeyValue);}
                                    });
                                }
                            }
                        }
                    });
                });
            }
        });

    });
</script>
@endsection