@extends('layouts.app')
@section('content')
<style>
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
</style>
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Vendor Master</li>
					<li class="breadcrumb-item"><a href="{{url('/')}}/admin/master/vendor/stock-points">{{$PageTitle}}</a></li>
                    <li class="breadcrumb-item">@if($isEdit==true)Update @else Create @endif</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row d-flex justify-content-center">
		<div class="col-12 col-sm-12 col-lg-9">
			<div class="card">
				<div class="card-header text-center"><h5 class="mt-10">{{$PageTitle}}</h5></div>
				<div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 mt-20">
                            <label for="txtPointName">Stock Point Name <span class="required">*</span></label>
                            <input type="text" class="form-control" id="txtPointName" value="<?php if($isEdit){ echo $EditData->PointName;} ?>">
                            <span class="errors err-sm" id="txtPointName-err"></span>
                        </div>
                        <div class="col-sm-12 mt-20">
                            <label for="txtAddress">Address <span class="required">*</span></label>
                            <textarea  id="txtAddress" rows="3" class="form-control"><?php if($isEdit){ echo $EditData->Address;} ?></textarea>
                            <span class="errors err-sm" id="txtAddress-err"></span>
                        </div>
                        <div class="col-sm-4 mt-20">
                            <div class="form-group">
                                <label for="txtPostalCode">Postal Code <span class="required">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="txtPostalCode" class="form-control" placeholder="Postal Code" value="<?php if($isEdit){ echo $EditData->PostalCode;} ?>">
                                    <button type="button" class="btn btn-outline-dark" id="btnGSearchPostalCode">Search <i class="fa fa-search"></i></button>
                                </div>
                                <div class="errors err-sm" id="txtPostalCode-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-20">
                            <div class="form-group">
                                <label for="lstCity">City <span class="required">*</span></label>
                                <select class="form-control {{$Theme['input-size']}} select2" id="lstCity" data-selected="<?php if($isEdit){ echo $EditData->CityID;} ?>">
                                    <option value="">Select a City</option>
                                </select>
                                <div class="errors err-sm" id="lstCity-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-20">
                            <div class="form-group">
                                <label for="lstTaluk">Taluk <span class="required">*</span></label>
                                <select class="form-control {{$Theme['input-size']}} select2" id="lstTaluk" data-selected="<?php if($isEdit){ echo $EditData->TalukID;} ?>">
                                    <option value="">Select a Taluk</option>
                                </select>
                                <div class="errors err-sm" id="lstTaluk-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-20">
                            <div class="form-group">
                                <label for="lstDistrict">District <span class="required">*</span></label>
                                <select class="form-control {{$Theme['input-size']}} select2" id="lstDistricts" data-selected="<?php if($isEdit){ echo $EditData->DistrictID;} ?>">
                                    <option value="">Select a District</option>
                                </select>
                                <div class="errors err-sm" id="lstDistricts-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-20">
                            <div class="form-group">
                                <label for="lstState">State <span class="required">*</span></label>
                                <select class="form-control {{$Theme['input-size']}} select2" id="lstState"  data-selected="<?php if($isEdit){ echo $EditData->StateID;} ?>">
                                    <option value="">Select a State</option>
                                </select>
                                <div class="errors err-sm" id="lstState-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-20">
                            <div class="form-group">
                                <label for="lstCountry">Country <span class="required">*</span></label>
                                <select class="form-control {{$Theme['input-size']}} select2" id="lstCountry" data-selected="<?php if($isEdit){ echo $EditData->CountryID;} ?>">
                                    <option value="">Select a Country</option>
                                </select>
                                <div class="errors err-sm" id="lstCountry-err"></div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row justify-content-center mt-20">
                        <div class="col-12 col-sm-8 col-md-7 col-lg-4 text-center card-body">
                            <label class="d-block" for="edo-ani">
                                <input class="radio_animated chkServiceBy" @if($isEdit && $data->ServiceBy == "District") checked @endif id="edo-ani" type="radio" name="rdo-ani" data-value="District" data-target="divDistrict"><span class="fw-500 fs-17">District</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-8 col-md-7 col-lg-4 text-center card-body">
                            <label class="d-block" for="edo-ani1">
                                <input class="radio_animated chkServiceBy" @if($isEdit && $data->ServiceBy == "PostalCode") checked @endif id="edo-ani1" type="radio" name="rdo-ani" data-value="PostalCode" data-target="divPostalCode"><span class="fw-500 fs-17">Postal Code</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-8 col-md-7 col-lg-4 text-center card-body">
                            <label class="d-block" for="edo-ani2">
                                <input class="radio_animated chkServiceBy" @if($isEdit && $data->ServiceBy == "Radius") checked @endif id="edo-ani2" type="radio" name="rdo-ani" data-value="Radius" data-target="divRadius"><span class="fw-500 fs-17">Radius</span>
                            </label>
                        </div>
                    </div>
                    <div class="row @if($isEdit && $data->ServiceBy == "District") @else d-none @endif divServiceBy my-2" id="divDistrict">
                        <div class="col-sm-12">
                            <div class="row justify-content-center mt-20">
                                <div class="col-12 col-sm-8 col-md-7 col-lg-4">
                                    <select  class="form-control select2" id="lstSLDCountry" data-selected="">
                                        <option value="">Select a Country</option>
                                    </select>
                                </div>
                                <div class="col-12 col-sm-8 col-md-7 col-lg-4">
                                    <select  class="form-control select2" id="lstSLDState" data-selected="@if($isEdit){{$data->StateID}}@endif">
                                        <option value="">Select a State</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-10 mb-20">
                                <div class="col-12">
                                    <div class="accordion" id="ServiceLocationDAccordion">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row @if($isEdit && $data->ServiceBy == "PostalCode") @else d-none @endif divServiceBy my-2" id="divPostalCode">
                        <div class="col-sm-12">
                            <div class="row justify-content-center mt-20">
                                <div class="col-12 col-sm-8 col-md-7 col-lg-4">
                                    <select  class="form-control select2" id="lstSLPCountry" data-selected="">
                                        <option value="">Select a Country</option>
                                    </select>
                                </div>
                                <div class="col-12 col-sm-8 col-md-7 col-lg-4">
                                    <select  class="form-control select2" id="lstSLPState" data-selected="@if($isEdit){{$data->StateID}}@endif">
                                        <option value="">Select a State</option>
                                    </select>
                                </div>
                                <div class="col-12 col-sm-8 col-md-7 col-lg-4">
                                    <select  class="form-control select2" id="lstSLPDistrict" data-selected="@if($isEdit){{$data->DistrictID}}@endif">
                                        <option value="">Select a District</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-10 mb-20">
                                <div class="col-12">
                                    <div class="accordion" id="ServiceLocationPAccordion">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row @if($isEdit && $data->ServiceBy == "Radius") @else d-none @endif divServiceBy my-2 justify-content-center" id="divRadius">
                        <div class="col-sm-4">
                            <div class="form-row">
                                <label for="txtRange">Range in KM <span class="required">*</span></label>
                                <input type="number" class="form-control" id="txtRange" value="@if($isEdit) {{$data->Range}}@else 0 @endif">
                                <span class="errors err-sm" id="txtRange-err"></span>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            @if($crud['view']==true)
                            <a href="{{url('/')}}/admin/master/vendor/stock-points/" class="btn {{$Theme['button-size']}} btn-outline-dark mr-10" id="btnCancel">Back</a>
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

<script>
    
    $(document).ready(function(){
        let df = null;
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
            $('.errors').html("");
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
                setTimeout(function() {
                    $('.chkServiceBy[data-value="PostalCode"]').prop('checked', true).trigger('change');
                },3000)
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
        getCountry({},'lstCountry');
        // Service By District
        const AddDServiceLocations=async(CountryID,StateID,StateName,DistrictIDs)=>{
            let AddressStateID =  @if($isEdit)"{{$data->StateID}}" @else $("#lstState").val() @endif;
            let AddressDistrictID =  @if($isEdit)"{{$data->DistrictID}}" @else $("#lstDistrict").val() @endif;

            let html = `<div class="accordion-item" data-country-id="${CountryID}" data-state-id="${StateID}">
                            <h2 class="accordion-header" id="${StateID}-heading">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panel-${StateID}" aria-expanded="true" aria-controls="panel-${StateID}">
                                    ${StateName} 
                                    <span class="options">
                                        ${(AddressStateID != StateID) ? `<span class="trash state-trash" data-state-id="${StateID}"><i class="fa fa-trash"></i></span>` : ''}
                                    </span>
                                </button>
                            </h2>
                            <div id="panel-${StateID}" class="accordion-collapse collapse" aria-labelledby="${StateID}-heading">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="lstSLDDistricts-${StateID}">Districts</label>
                                            <div class="form-group">
                                                <select id="lstSLDDistricts-${StateID}" class="form-control select2 lstSLDDistricts" data-selected="${(AddressStateID == StateID ? AddressDistrictID : '')}" multiple></select>
                                            </div>
                                        </div>
                                        <span class="errors err-sm"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
            `;

            $('#ServiceLocationDAccordion').append(html);

            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/districts",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:{CountryID : CountryID, StateID : StateID},
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);resolve([])},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(DistrictIDs){
                            if(DistrictIDs.indexOf(Item.DistrictID)!=-1){
                                selected="selected";
                            }
                        }else if(Item.DistrictID==$('#lstSLDDistricts-'+StateID).attr('data-selected')){
                            selected="selected";
                        }
                        $('#lstSLDDistricts-'+StateID).append('<option '+selected+' value="'+Item.DistrictID+'">'+Item.DistrictName+' </option>');
                    }
                }
            });
            $('#lstSLDDistricts-'+StateID).select2();
        }
        $(document).on("change",'#lstSLDCountry',async function(){
            getStates({CountryID : $(this).val()},"lstSLDState")
        });
        $(document).on("change",'#lstSLDState',async function(){
            $(".errors").html('');
            let CountryID=$("#lstSLDCountry").val();
            let StateID=$(this).val();
            if(StateID){
                let StateName=$(this).find('option:selected').html();
                $('#lstSLDState').select2('destroy');
                $('#lstSLDState option[value="'+StateID+'"]').attr('disabled','disabled');
                $('#lstSLDState').val("").trigger("change");
                $('#lstSLDState').select2();
                $('#ServiceLocationDAccordion .accordion-item[data-state-id="' + StateID + '"]').length === 0 ? AddDServiceLocations(CountryID, StateID, StateName) : null;
            }
        });
        $(document).on('click','.state-trash',function(){
            let StateID=$(this).attr('data-state-id');
            $('#lstSLDState').select2('destroy');
            $('#ServiceLocationDAccordion .accordion-item[data-state-id="'+StateID+'"]').remove();
            $('#lstSLDState option[value="'+StateID+'"]').removeAttr('disabled');
            $('#lstSLDState').select2();
        });

        // Service By Postal Code
        const AddPServiceLocations=async(CountryID,StateID,DistrictID,DistrictName,PostalCodeIDs)=>{
            let AddressDistrictID = @if($isEdit)"{{$data->DistrictID}}" @else $("#lstDistrict").val() @endif;
            let AddressPostalCodeID = @if($isEdit)"{{$data->PostalCodeID}}" @else $("#lstCity option:selected").attr('data-postal') @endif;
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
                                            <label for="lstSLPPostalCodes-${DistrictID}">Postal Code</label>
                                            <div class="form-group">
                                                <select id="lstSLPPostalCodes-${DistrictID}" data-district-id="${DistrictID}" class="form-control select2 lstSLPPostalCodes" data-selected="${(AddressDistrictID == DistrictID ? AddressPostalCodeID : '')}" multiple></select>
                                            </div>
                                        </div>
                                        <span class="errors err-sm"></span>
                                    </div>
                                    <div class="row mt-15 mb-10 ">
                                        <div class="col-12 text-center d-flex justify-content-center align-items-center">
                                            <button class="btn btn-sm btn-outline-primary mr-10  btnPCodeSelectAll">Select All</button>
                                            <button class="btn btn-sm btn-outline-primary mr-10 btnPCodeDeselectAll">Deselect All</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            `;

            $('#ServiceLocationPAccordion').append(html);

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
                        }else if(Item.PID==$('#lstSLPPostalCodes-'+DistrictID).attr('data-selected')){
                            selected="selected";
                        }
                        $('#lstSLPPostalCodes-'+DistrictID).append('<option '+selected+' value="'+Item.PID+'">'+Item.PostalCode+' </option>');
                    }
                }
            });
            $('#lstSLPPostalCodes-'+DistrictID).select2();
        }
        $(document).on("change",'#lstSLPCountry',async function(){
            getStates({CountryID : $(this).val()},"lstSLPState")
        });
        $(document).on("change",'#lstSLPState',async function(){
            $(".errors").html('');
            let ExistingDistricts = [];
            $('#ServiceLocationPAccordion .accordion-item').each(function(){
                ExistingDistricts.push($(this).attr('data-district-id'));
            });
            $('#lstSLPDistrict').select2('destroy');
            $('#lstSLPDistrict option').remove();
            $('#lstSLPDistrict').append('<option value="">Select a District</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/districts",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:{CountryID : $('#lstSLPCountry').val(), StateID : $(this).val()},
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);resolve([])},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let disabled="";
                        let selected="";
                        if(ExistingDistricts.indexOf(Item.DistrictID)!=-1){disabled="disabled";}
                        if(Item.DistrictID==$('#lstSLPDistrict').attr('data-selected')){selected="selected";}
                        $('#lstSLPDistrict').append('<option '+selected+' '+disabled+' value="'+Item.DistrictID+'">'+Item.DistrictName+' </option>');
                    }
                    if($('#lstSLPDistrict').val()!=""){
                        $('#lstSLPDistrict').trigger('change');
                    }
                }
            });
            $('#lstSLPDistrict').select2();
        });
        $(document).on("change",'#lstSLPDistrict',function(){
            $(".errors").html('');
            let CountryID=$("#lstSLPCountry").val();
            let StateID=$("#lstSLPState").val();
            let DistrictID=$(this).val();
            if(DistrictID){
                let DistrictName=$(this).find('option:selected').html();
                $('#lstSLPDistrict').select2('destroy');
                $('#lstSLPDistrict option[value="'+DistrictID+'"]').attr('disabled','disabled');
                $('#lstSLPDistrict').val("").trigger("change");
                $('#lstSLPDistrict').select2();
                $('#ServiceLocationPAccordion .accordion-item[data-district-id="' + DistrictID + '"]').length === 0 ? AddPServiceLocations(CountryID,StateID,DistrictID,DistrictName) : null;
            }
        });
        $(document).on('click','.district-trash',function(){
            let DistrictID=$(this).attr('data-district-id');
            $('#lstSLPDistrict').select2('destroy');
            $('#ServiceLocationPAccordion .accordion-item[data-district-id="'+DistrictID+'"]').remove();
            $('#lstSLPDistrict option[value="'+DistrictID+'"]').removeAttr('disabled');
            $('#lstSLPDistrict').select2();
        });
        $(document).on('click', '.btnPCodeSelectAll', function () {
            let accordionBody = $(this).closest('.accordion-body');
            
            accordionBody.find('.lstSLPPostalCodes').select2('destroy');
            accordionBody.find('.lstSLPPostalCodes option').prop('selected', true);
            accordionBody.find('.lstSLPPostalCodes').select2();
        });
        $(document).on('click','.btnPCodeDeselectAll',function(){
            let accordionBody = $(this).closest('.accordion-body');
            
            accordionBody.find('.lstSLPPostalCodes').select2('destroy');
            accordionBody.find('.lstSLPPostalCodes option').prop('selected', false);
            accordionBody.find('.lstSLPPostalCodes').select2();
        });
        $(".chkServiceBy").change(function() {
            var target = $(this).data('target');
            var Value = $(this).data('value');
            $(".divServiceBy").not("#"+target).addClass('d-none');
            $("#"+target).removeClass('d-none');

            let Country = @if($isEdit)"{{$data->CountryID}}" @else $("#lstCountry").val() @endif;
            let State = @if($isEdit)"{{$data->StateID}}" @else $("#lstState").val() @endif;
            let District = @if($isEdit)"{{$data->DistrictID}}" @else $("#lstDistrict").val() @endif;

            if(Value == "District"){
                let SLDCountry = $("#lstSLPCountry").val();
                $("#lstSLDCountry").attr("data-selected",Country);
                getCountry({},"lstSLDCountry");
            }else if(Value == "PostalCode"){
                let SLPCountry = $("#lstSLPCountry").val();
                let SLPState = $("#lstSLPState").val();
                $("#lstSLPCountry").attr("data-selected",Country);
                $("#lstSLPState").attr("data-selected",State);
                $("#lstSLPDistrict").attr("data-selected",District);
                getCountry({},"lstSLPCountry");
            }else{

            }
        });

        const appInit=async()=>{
            let TData=[];
            @if($isEdit==true)
                TData=JSON.parse($('#txtAData').val());
            @endif
            df=$('#dynamicForm').dynamicForm({Columns:2,isValidate:true,Data:TData,BaseUrl:"{{url('/')}}/"});
        }
        const formValidation=async()=>{
            $('.errors').html('');
            let status=true;
            let VendorType=$('#txtVendorType').val();

            let Address=$('#txtAddress').val();
            let PostalCode=$('#lstCity option:selected').attr('data-postal');
            let CityID=$('#lstCity').val();
            let TalukID=$('#lstTaluk').val();
            let DistrictID=$('#lstDistricts').val();
            let StateID=$('#lstState').val();
            let CountryID=$('#lstCountry').val();
            if(!PostalCode){
                $('#txtPostalCode-err').html('Postal Code is required.');status=false;
            }
            if(CityID==""){
                $('#lstCity-err').html('City is required.');status=false;
            }
            if(TalukID==""){
                $('#lstTaluk-err').html('Taluk is required.');status=false;
            }
            if(DistrictID==""){
                $('#lstDistricts-err').html('District is required.');status=false;
            }
            if(StateID==""){
                $('#lstState-err').html('State is required.');status=false;
            }
            if(CountryID==""){
                $('#lstCountry-err').html('Country is required.');status=false;
            }
            if(Address==""){
                $('#txtAddress-err').html('Address is required.');status=false;
            }else if(Address.length<5){
                $('#txtAddress-err').html('Address must be greater than 5 characters');status=false;
            }
            if(VendorType==""){
                $('#txtVendorType-err').html('The Vendor Type is required.');status=false;
            }
            if (!$('.chkServiceBy:checked').length && status) {
                toastr.error("Please select any Services", "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0});
                status = false;
            } else if ($('.chkServiceBy:checked[data-value="District"]').length) { 
                if ($('#ServiceLocationDAccordion .accordion-item').length == 0) {
                    toastr.error("Please select any State in District Services!", "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0});
                    status = false;
                } else {
                    $('#ServiceLocationDAccordion .accordion-item').each(function () {
                        if ($(this).find('.lstSLDDistricts').val().length == 0) {
                            $(this).find('.accordion-button').hasClass('collapsed') ? $(this).find('.accordion-button').trigger('click') : null;
                            $(this).find('.lstSLDDistricts').focus();
                            $(this).find('.errors').html('Select a District!');
                            status = false;
                        }
                    });
                }
            } else if ($('.chkServiceBy:checked[data-value="PostalCode"]').length) {
                if ($('#ServiceLocationPAccordion .accordion-item').length == 0) {
                    toastr.error("Please select any District in PostalCode Services!", "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0});
                    status = false;
                } else {
                    $('#ServiceLocationPAccordion .accordion-item').each(function () {
                        if ($(this).find('.lstSLPPostalCodes').val().length == 0) {
                            $(this).find('.accordion-button').hasClass('collapsed') ? $(this).find('.accordion-button').trigger('click') : null;
                            $(this).find('.lstSLPPostalCodes').focus();
                            $(this).find('.errors').html('Select a PostalCode!');
                            status = false;
                        }
                    });
                }
            } else if ($('.chkServiceBy:checked[data-value="Radius"]').length){
                let Range=$('#txtRange').val();
                if(Range == ""){
                    $('#txtRange-err').html('Range is required.');status=false;
                }
            }
            console.log(status);
            return status;

            if(status==false){$("html, body").animate({ scrollTop: 0 }, "slow");}
        }
        const getData=async ()=>{
            let formData=new FormData();
            formData.append('PointName',$('#txtPointName').val());
            formData.append('MobileNo1',$('#txtMobileNo1').val());
            formData.append('Address',$('#txtAddress').val());
            formData.append('PostalCodeID',$('#lstCity option:selected').attr('data-postal'));
            formData.append('CityID',$('#lstCity').val());
            formData.append('TalukID',$('#lstTaluk').val());
            formData.append('DistrictID',$('#lstDistricts').val());
            formData.append('StateID',$('#lstState').val());
            formData.append('CountryID',$('#lstCountry').val());

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
        $('#btnSave').click(async function(){
            let status= await formValidation();
            if(status){
                let formData=await GetData();

                swal({
                    title: "Are you sure?",
                    text: "You want @if($isEdit==true)Update @else Save @endif this Category!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, @if($isEdit==true)Update @else Save @endif it!",
                    closeOnConfirm: false
                },async function(){
                    swal.close();
                    btnLoading($('#btnSave'));
                    let postUrl= @if($isEdit) "{{url('/')}}/admin/master/vendor/stock-points/edit/{{$EditData[0]->VendorTypeID}}"; @else "{{url('/')}}/admin/master/vendor/stock-points/create"; @endif
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
                                        window.location.replace("{{url('/')}}/admin/master/vendor/stock-points");
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
                                        if(key=="VendorType"){$('#txtVendorType-err').html(KeyValue);}
                                        if(key=="STImage"){$('#txtSTImage-err').html(KeyValue);}
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