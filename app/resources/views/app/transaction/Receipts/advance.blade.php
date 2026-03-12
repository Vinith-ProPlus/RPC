@extends('layouts.app')
@section('content')
@php $RowIndex=1; @endphp
<style>
    label{
        margin-bottom:0px;
    }
</style>
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Transaction</li>
					<li class="breadcrumb-item"><a href="{{route('admin.transaction.receipts')}}">{{$PageTitle}}</a></li>
					<li class="breadcrumb-item">Advance</li>
                    <li class="breadcrumb-item">@if($isEdit) Update @else Create @endif</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row d-flex justify-content-center">
		<div class="col-sm-5 col-12">
			<div class="card">
				<div class="card-header text-center"><h5 class="mt-10">Advance {{$PageTitle}}</h5></div>
				<div class="card-body" >
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="dtpTranDate">Payment Date <span class="required"> * </span></label>
                                <input type="date" max="{{date('Y-m-d')}}" class="form-control" id="dtpTranDate" value="<?php if($isEdit){ echo date("Y-m-d",strtotime($EditData->TranDate)); }else{ echo date("Y-m-d"); } ?>">
                                <div class="errors text-sm" id="dtpTranDate-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-15">
                            <div class="form-group">
                                <label for="lstLedger">Ledger Name <span class="required"> * </span></label>
                                <select class="form-control select2" @if($isEdit) disabled @endif id="lstLedger" data-selected="<?php if($isEdit){ echo $EditData->LedgerID; } ?>"> 
                                    <option value="">Select a Ledger</option>
                                </select>
                                <div class="errors text-sm" id="lstLedger-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-15">
                            <div class="form-group">
                                <label for="lstMOP">Mode Of Payment <span class="required"> * </span></label>
                                <select class="form-control select2" id="lstMOP" > 
                                    <option value="">Select a MOP</option>
                                    <option value="Cash"  @if($isEdit) @if($EditData->MOP=="Cash") selected @endif @else selected  @endif >Cash</option>
                                    <option value="Cheque"  @if($isEdit) @if($EditData->MOP=="Cheque") selected @endif   @endif>Cheque</option>
                                    <option value="RTGS"  @if($isEdit) @if($EditData->MOP=="RTGS") selected @endif   @endif>RTGS</option>
                                    <option value="IMPS"  @if($isEdit) @if($EditData->MOP=="IMPS") selected @endif   @endif>IMPS</option>
                                    <option value="NEFT"  @if($isEdit) @if($EditData->MOP=="NEFT") selected @endif   @endif>NEFT</option>
                                    <option value="UPI"  @if($isEdit) @if($EditData->MOP=="UPI") selected @endif   @endif>UPI</option>
                                    <option value="Digital Wallet"  @if($isEdit) @if($EditData->MOP=="Digital Wallet") selected @endif   @endif>Digital Wallet</option>
                                </select>
                                <div class="errors text-sm" id="lstMOP-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-15" id="divChequeDate" style="display:none;">
                            <div class="form-group">
                                <label for="dtpChequeDate">Cheque Date <span class="required"> * </span></label>
                                <input type="date" min="<?php if($isEdit){echo date("Y-m-01",strtotime($EditData->TranDate));}else{ echo date("Y-m-01");} ?>" class="form-control" id="dtpChequeDate" value="<?php if($isEdit){ echo date("Y-m-d",strtotime($EditData->ChequeDate)); }else{ echo date("Y-m-d"); } ?>">
                                <div class="errors text-sm" id="dtpChequeDate-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-15" id="divMOPRefNo" style="display:none;">
                            <div class="form-group">
                                <label for="txtMOPRefNo">MOP Ref. No </label>
                                <input type="text"  class="form-control" id="txtMOPRefNo" value="<?php if($isEdit){ echo $EditData->MOPRefNo; } ?>">
                                <div class="errors text-sm" id="txtMOPRefNo-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-15">
                            <div class="form-group">
                                <label for="txtTotalAmount">Amount <span class="required"> * </span></label>
                                <input type="number" steps="{{Helper::NumberSteps($Settings['price-decimals'])}}"  class="form-control" id="txtTotalAmount" value="<?php if($isEdit){ echo Helper::NumberFormat($EditData->TotalAmount,$Settings['price-decimals']); } ?>">
                                <div class="errors text-sm" id="txtTotalAmount-err"></div>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            @if($crud['view']==true)
                                <a href="{{route('admin.transaction.receipts')}}" class="btn btn-sm btn-outline-dark m-5">Back</a>
                            @endif
                            @if(($crud['add']==true)||($crud['edit']==true))
                                <button type="button" class="btn btn-sm btn-outline-success btn-air-success m-5" id="btnSave">@if($isEdit) Update @else Create @endif</button>
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
        let fstatus=true;
        let editRow=null;
        let rowIndex=1;
        const appInit=()=>{
            getLedger();
        }
        const getLedger=async()=>{
            $('#lstLedger').select2('destroy');
            $('#lstLedger option').remove();
            $('#lstLedger').append('<option value="" selected>Select a Ledger Name</option>');
            $.ajax({
                type:"post",
                url:"{{route('admin.transaction.receipts.get.ledger')}}",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajax_errors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.LedgerID==$('#lstLedger').attr('data-selected')){selected="selected";}
                        $('#lstLedger').append('<option '+selected+' data-state="'+Item.StateID+'"  value="'+Item.LedgerID+'">'+Item.LedgerName+'( '+Item.MobileNumber+' ) </option>');
                    }
                    if($('#lstLedger').val()!=""){$('#lstLedger').trigger('change');}
                }
            });
            $('#lstLedger').select2();
        }
        const getData=async()=>{
            let Details=JSON.stringify([]);
            let TranDate=$('#dtpTranDate').val();
            let LedgerID=$('#lstLedger').val();
            let MOP=$('#lstMOP').val();
            let ChequeDate=$('#dtpChequeDate').val();
            let MOPRefNo=$('#txtMOPRefNo').val();
            let TotalAmount=$('#txtTotalAmount').val();
            let PaymentType='Advance';
            TotalAmount=isNaN(parseFloat(TotalAmount))==false?parseFloat(TotalAmount):0;
            let LessFromAdvance=0;
            let formData={
                TranDate,
                PaymentType,
                LedgerID,
                MOP,
                ChequeDate,
                MOPRefNo,
                TotalAmount,
                Details
            };
            return formData;
        }

        const formValidation=async(data)=>{
            let status=true;
            let details=JSON.parse(data.Details);
            $('.errors').html('');
            if(data.TranDate==""){
                $('#dtpTranDate-err').html('Payment Date is required');status=false;
            }

            if(data.LedgerID==""){
                $('#lstLedger-err').html('Ledger Name is required');status=false;
            }
            if(data.MOP==""){
                $('#lstMOP-err').html('Mode of payment is required');status=false;
            }
            if(data.ChequeDate==""){
                $('#dtpChequeDate-err').html('Cheque date is required');status=false;
            }
			if(data.TotalAmount==""){
				$('#txtTotalAmount-err').html('Amount is  required.');status=false;
			}else if($.isNumeric(data.TotalAmount)==false){
				$('#txtTotalAmount-err').html('The amount must be a numeric value.');status=false;
			}
            if(status==false){$("html, body").animate({ scrollTop: 0 }, "slow");}
            return status;
        }
        $(document).on('change','#lstMOP',function(){
            $('#divMOPRefNo').hide();
            $('#divChequeDate').hide();
            if($('#lstMOP').val()=="Cheque"){
                $('#divMOPRefNo').show();
                $('#divChequeDate').show();
            }else if($('#lstMOP').val()=="RTGS"){
                $('#divMOPRefNo').show();
            }else if($('#lstMOP').val()=="IMPS"){
                $('#divMOPRefNo').show();
            }else if($('#lstMOP').val()=="NEFT"){
                $('#divMOPRefNo').show();
            }else if($('#lstMOP').val()=="UPI"){
                $('#divMOPRefNo').show();
            }else if($('#lstMOP').val()=="Digital Wallet"){
                $('#divMOPRefNo').show();
            }
        });
        $(document).on('click','#btnSave',async function(){
            let formData=await getData();
            let status=await formValidation(formData);
            if(status){
                swal({
                    title: "Are you sure?",
                    text: "You want @if($isEdit==true)Update @else Save @endif this Advance payament!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, @if($isEdit==true) Update @else Save @endif it!",
                    closeOnConfirm: false
                },function(){
                    swal.close();
                    btnLoading($('#btnSave'));
                    let postUrl= "<?php if($isEdit){ echo route('admin.transaction.receipts.update',$TranNo); }else{ echo route('admin.transaction.receipts.save');} ?>";
                    $.ajax({
                        type:"post",
                        url:postUrl,
                        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                        data:formData,
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
                                        window.location.replace("{{route('admin.transaction.receipts')}}");
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
                                        if(key=="TranDate"){$('#dtpTranDate-err').html(KeyValue);}
                                        if(key=="LedgerID"){$('#lstLedger-err').html(KeyValue);}
                                        if(key=="ChequeDate"){$('#dtpChequeDate-err').html(KeyValue);}
                                        if(key=="MOP"){$('#lstMOP-err').html(KeyValue);}
                                        if(key=="MOPRefNo"){$('#txtMOPRefNo-err').html(KeyValue);}
                                        if(key=="Amount"){$('#txtTotalAmount-err').html(KeyValue);}
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
