@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">General Master</li>
					<li class="breadcrumb-item"><a href="{{url('/')}}/admin/master/general/city/" data-original-title="" title="">{{$PageTitle}}</a></li>
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
                                <label class="txtCityName">City Name <span class="required"> * </span></label>
                                <input type="text" class="form-control  {{$Theme['input-size']}}" id="txtCityName" value="<?php if($isEdit==true){ echo $EditData[0]->CityName;} ?>">
                                <div class="errors" id="txtCityName-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-6 mt-20">
                            <div class="form-group">
                                <label for="lstCountry">Country <span class="required"> * </span> <span class="addOption" id="btnReloadCountry" title="Reload Country" ><i class="fa fa-refresh"></i></span>  @if($OtherCruds['Country']['add']==1)  <span class="addOption" id="btnAddCountry" title="add new country" ><i class="fa fa-plus"></i></span> @endif</label>
                                <select class="form-control select2" id="lstCountry" data-selected="<?php if($isEdit){echo $EditData[0]->CountryID;} ?>">
                                    <option value="">Select a Country</option>
                                </select>
                                <span class="errors MAddress" id="lstCountry-err"></span>
                            </div>
                        </div>
                        <div class="col-sm-6 mt-20">
                            <div class="form-group">
                                <label for="lstState">State <span class="required"> * </span> <span class="addOption" id="btnReloadState" title="Reload State" ><i class="fa fa-refresh"></i></span>  @if($OtherCruds['States']['add']==1)  <span class="addOption" id="btnAddState" title="add new state" ><i class="fa fa-plus"></i></span> @endif</label>
                                <select class="form-control select2 " id="lstState" data-country-id="lstCountry" data-selected="<?php if($isEdit){echo $EditData[0]->StateID;} ?>">
                                    <option value="">Select a State</option>
                                </select>
                                <span class="errors MAddress" id="lstState-err"></span>
                            </div>
                        </div>
                        <div class="col-sm-6 mt-20">
                            <div class="form-group">
                                <label for="lstDistrict">District <span class="required"> * </span> <span class="addOption" id="btnReloadDistrict" title="Reload District" ><i class="fa fa-refresh"></i></span>  @if($OtherCruds['Districts']['add']==1)  <span class="addOption" id="btnAddDistrict" title="add new district" ><i class="fa fa-plus"></i></span> @endif</label>
                                <select class="form-control select2 " id="lstDistrict"  data-country-id="lstCountry" data-state-id="lstState" data-selected="<?php if($isEdit){echo $EditData[0]->DistrictID;} ?>">
                                    <option value="">Select a District</option>
                                </select>
                                <span class="errors MAddress" id="lstDistrict-err"></span>
                            </div>
                        </div>
                        <div class="col-sm-6 mt-20">
                            <div class="form-group">
                                <label for="lstTaluk"> Taluk <span class="required"> * </span> <span  class="addOption" id="btnReloadTaluk" title="Reload Taluk" ><i class="fa fa-refresh"></i></span>  @if($OtherCruds['Taluks']['add']==1)  <span class="addOption" id="btnAddTaluk" title="add new taluk" ><i class="fa fa-plus"></i></span> @endif</label>
                                <select class="form-control  {{$Theme['input-size']}} select2" id="lstTaluk" data-country-id="lstCountry" data-state-id="lstState" data-district-id="lstDistrict" data-selected="<?php if($isEdit){echo $EditData[0]->TalukID;} ?>">
                                    <option value="">Select a Taluk</option>
                                </select>
                                <div class="errors" id="lstTaluk-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-6 mt-20">
                            <div class="form-group">
                                <label for="lstPostalCode">Postal Code <span class="required"> * </span> <span class="addOption" id="btnReloadPostalCode" title="Reload Postal Code" ><i class="fa fa-refresh"></i></span>  @if($OtherCruds['PostalCodes']['add']==1)  <span class="addOption" id="btnAddPostalCode" title="add new postal code" ><i class="fa fa-plus"></i></span> @endif</label>
                                <select class="form-control mselect2Tag " id="lstPostalCode" data-country-id="lstCountry" data-state-id="lstState" data-district-id="lstDistrict" data-selected="<?php if($isEdit){echo $EditData[0]->PostalID;} ?>">
                                    <option value="">Select a Postal Code or enter</option>
                                </select>
                                <span class="errors MAddress" id="lstPostalCode-err"></span>
                            </div>
                        </div>
                        <div class="col-sm-6 mt-20">
                            <div class="form-group">
                                <label class="lstActiveStatus"> Active Status</label>
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
                            <a href="{{url('/')}}/master/general/city" class="btn {{$Theme['button-size']}} btn-outline-dark mr-10" id="btnCancel">Back</a>
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
        const getCountry=()=>{
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/country",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajax_errors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    $('#lstCountry').select2('destroy');
                    $('#lstCountry option').remove();
                    $('#lstCountry').append('<option value="" selected>Select a Country</option>');
                    for(let Item of response){
                        let selected="";
                        if($('#lstCountry').attr('data-selected')!=""){if(Item.CountryID==$('#lstCountry').attr('data-selected')){selected="selected";}}else{if(Item.sortname){if(Item.sortname.toString().toLowerCase()=='in'){selected="selected";}}}
                        $('#lstCountry').append('<option '+selected+' data-phone-code="'+Item.PhoneCode+'" data-phone-length="'+Item.PhoneLength+'" value="'+Item.CountryID+'">'+Item.CountryName+'('+Item.sortname+')'+' </option>');
                    }
                    $('#lstCountry').select2();
                    if($('#lstCountry').val()!=""){
                        $('#lstCountry').trigger('change');
                    }
                }
            });
        }
        const getStates=()=>{
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/states",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                data:{CountryID:$('#lstCountry').val()},
                async:true,
                error:function(e, x, settings, exception){ajax_errors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    $('#lstState').select2('destroy');
                    $('#lstState option').remove();
                    $('#lstState').append('<option value="" selected>Select a State</option>');
                    for(let Item of response){
                        let selected="";
                        if($('#lstState').attr('data-selected')!=""){if(Item.StateID==$('#lstState').attr('data-selected')){selected="selected";}}else{if(Item.StateName.toString().toLowerCase()=='tamil nadu'){selected="selected";}} 
                        $('#lstState').append('<option '+selected+'  value="'+Item.StateID+'">'+Item.StateName+' </option>');
                    }
                    $('#lstState').select2();
                    if($('#lstState').val()!=""){
                        $('#lstState').trigger('change');
                    }
                }
            });
        }
        const getDistrict=()=>{
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/districts",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                data:{CountryID:$('#lstDistrict').val(),StateID:$('#lstState').val()},
                async:true,
                error:function(e, x, settings, exception){ajax_errors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    $('#lstDistrict').select2('destroy');
                    $('#lstDistrict option').remove();
                    $('#lstDistrict').append('<option value="" selected>Select a District</option>');
                    for(let Item of response){
                        let selected="";
                        if(Item.DistrictID==$('#lstDistrict').attr('data-selected')){selected="selected";}
                        $('#lstDistrict').append('<option '+selected+'  value="'+Item.DistrictID+'">'+Item.DistrictName+' </option>');
                    }
                    $('#lstDistrict').select2();
                    if($('#lstDistrict').val()!=""){
                        $('#lstDistrict').trigger('change');
                    }
                    
                }
            });
        }
        const getTaluk=async()=>{
            $('#lstTaluk').select2('destroy');
            $('#lstTaluk option').remove();
            $('#lstTaluk').append('<option value="">Select a Taluk</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/taluks",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                data:{StateID:$('#lstState').val(),DistrictID:$('#lstDistrict').val()},
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.TalukID==$('#lstTaluk').attr('data-selected')){selected="selected";}
                        $('#lstTaluk').append('<option '+selected+' value="'+Item.TalukID+'">'+Item.TalukName+' </option>');
                    }
                }
            });
            $('#lstTaluk').select2();
        }
        const getPostalCode=()=>{
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/postal-code",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                data:{DistrictID:$('#lstDistrict').val()},
                async:true,
                error:function(e, x, settings, exception){ajax_errors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    $('#lstPostalCode').select2('destroy');
                    $('#lstPostalCode option').remove();
                    $('#lstPostalCode').append('<option value="" selected>Select a Postal Code</option>');
                    for(let Item of response){
                        let selected="";
                        if(Item.PID==$('#lstPostalCode').attr('data-selected')){selected="selected";}
                        $('#lstPostalCode').append('<option '+selected+'  value="'+Item.PID+'">'+Item.PostalCode+' </option>');
                    }
                    if(($('#lstPostalCode').attr('data-selected')!="")&&($('#lstPostalCode').attr('data-selected')!=undefined)){
                        if($('#lstPostalCode option[value="'+$('#lstPostalCode').attr('data-selected')+'"]').length<=0){
                            $('#lstPostalCode').append('<option selected value="'+$('#lstPostalCode').attr('data-selected')+'" data-select2-tag="true">'+$('#lstPostalCode').attr('data-selected')+'</option>');
                        }
                    }
                    $('#lstPostalCode').select2({tags: true});
                }
            });
        }
        $(document).on('change','#lstCountry',function(){
            getStates();
        });
        $(document).on('change','#lstState',function(){
            getDistrict();
        });
        $(document).on('change','#lstDistrict',function(){
            getTaluk();
            getPostalCode();
        });
        const formValidation=()=>{
            $('.errors').html('');
            let status=true;
            let CityName=$('#txtCityName').val();
            let CountryID=$('#lstCountry').val();
            let StateID=$('#lstState').val();
            let DistrictID=$('#lstDistrict').val();
            let TalukID=$('#lstTaluk').val();
            let PostalCodeID=$('#lstPostalCode').val();
            if(CityName==""){
                $('#txtCityName-err').html('The City Name is required.');status=false;
            }else if(CityName.length<3){
                $('#txtCityName-err').html('City Name must be greater than 3 characters');status=false;
            }else if(CityName.length>100){
                $('#txtCityName-err').html('City Name may not be greater than 100 characters');status=false;
            }
            if(CountryID==""){
                $('#lstCountry-err').html('The Country field is required.');status=false;
            }
            if(StateID==""){
                $('#lstState-err').html('The State field is required.');status=false;
            }
            if(DistrictID==""){
                $('#lstDistrict-err').html('The District field is required.');status=false;
            }
            if(TalukID==""){
                $('#lstTaluk-err').html('The Taluk field is required.');status=false;
            }
            if(PostalCodeID==""){
                $('#lstPostalCode-err').html('The Postal Code field is required.');status=false;
            }
            if(status==false){$("html, body").animate({ scrollTop: 0 }, "slow");}
            return status;
        }
        $('#btnSave').click(function(){
            let status=formValidation();
            if(status){
                swal({
                    title: "Are you sure?",
                    text: "You want @if($isEdit==true)Update @else Save @endif this City!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, @if($isEdit==true)Update @else Save @endif it!",
                    closeOnConfirm: false
                },function(){
                    swal.close();
                    btnLoading($('#btnSave'));
                    let postUrl=@if($isEdit==true) "{{url('/')}}/admin/master/general/city/edit/{{$EditData[0]->CityID}}"; @else "{{url('/')}}/admin/master/general/city/create"; @endif
                    let formData=new FormData();
                    formData.append('CityName',$('#txtCityName').val());
                    formData.append('CountryID',$('#lstCountry').val());
                    formData.append('StateID',$('#lstState').val());
                    formData.append('DistrictID',$('#lstDistrict').val());
                    formData.append('TalukID',$('#lstTaluk').val());
                    formData.append('PostalCodeID',$('#lstPostalCode').val());
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
                                        window.location.replace("{{url('/')}}/admin/master/general/city");
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
                                        if(key=="CityName"){$('#txtCityName-err').html(KeyValue);}                          
                                    });
                                }
                            }
                        }
                    });
                });
            }
        });
        $('.select2').select2();
        $('.mselect2Tag').select2({tags: true});
        getCountry();
    });
</script>
@endsection