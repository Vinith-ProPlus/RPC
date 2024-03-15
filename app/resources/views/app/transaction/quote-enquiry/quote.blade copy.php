@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Transaction</li>
					<li class="breadcrumb-item"><a href="{{ url('/') }}/admin/transaction/quotation/" data-original-title="" title="">{{$PageTitle}}</a></li>
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
				<div class="card-body">
                    <div class="row justify-content-center">
                        {{-- <div class="col-sm-12 mt-20">
                            <div class="form-group">
                                <label class="txtQuotationName"> Quotation Name <span class="required"> * </span></label>
                                <input type="text" class="form-control  {{$Theme['input-size']}}" id="txtQuotationName" value="<?php if($isEdit==true){ echo $EditData[0]->QuotationName;} ?>">
                                <div class="errors" id="txtQuotationName-err"></div>
                            </div>
                        </div> --}}
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-outline-info" id="btnAddAddress">Add New Address</button>
                        </div>

                    </div>
                    <div class="row mt-20">
                        <div class="col-sm-12 text-right">
                            @if($crud['view']==true)
                            <a href="{{url('/')}}/admin/transaction/quotation" class="btn {{$Theme['button-size']}} btn-outline-dark mr-10" id="btnCancel">Back</a>
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
            let TaxName=$('#txtTaxName').val();
            let Percentage=$('#txtPercentage').val();
            if(TaxName==""){
                $('#txtTaxName-err').html('The category name is required.');status=false;
            }else if(TaxName.length<2){
                $('#txtTaxName-err').html('TaxName  must be greater than 2 characters');status=false;
            }else if(TaxName.length>100){
                $('#txtTaxName-err').html('Category Name may not be greater than 100 characters');status=false;
            }
                        
            if(Percentage==""){
                $('#txtPercentage-err').html('The Percentage  is required.');status=false;
            }else if($.isNumeric(Percentage)==false){
                $('#txtPercentage-err').html('The Percentage  is must be numeric.');status=false;
            }else if(Percentage.length>100){
                $('#txtPercentage-err').html('Percentage  may not be greater than 100 characters');status=false;
            }
            if(status==false){$("html, body").animate({ scrollTop: 0 }, "slow");}
            return status;
        }
        $('#btnSave').click(function(){
            let status=formValidation();
            if(status){
                swal({
                    title: "Are you sure?",
                    text: "You want @if($isEdit==true)Update @else Save @endif this Tax!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, @if($isEdit==true)Update @else Save @endif it!",
                    closeOnConfirm: false
                },function(){
                    swal.close();
                    btnLoading($('#btnSave'));
                    let postUrl=@if($isEdit==true) "{{url('/')}}/admin/transaction/quotation/edit/{{$EditData[0]->TaxID}}"; @else "{{url('/')}}/admin/transaction/quotation/create"; @endif
                    let formData=new FormData();
                    formData.append('TaxName',$('#txtTaxName').val());
                    formData.append('Percentage',$('#txtPercentage').val());
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
                                        window.location.replace("{{url('/')}}/admin/transaction/quotation");
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
                                        if(key=="TaxName"){$('#txtTaxName-err').html(KeyValue);}
                                        if(key=="Percentage"){$('#txtPercentage-err').html(KeyValue);}
                          
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