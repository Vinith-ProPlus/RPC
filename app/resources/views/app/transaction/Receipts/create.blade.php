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
					<li class="breadcrumb-item"><a href="{{route('admin.transaction.receipts')}}" data-original-title="" title="">{{$PageTitle}}</a></li>
                    <li class="breadcrumb-item">@if($isEdit) Update @else Create @endif</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row d-flex justify-content-center">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header text-center"><h5 class="mt-10">{{$PageTitle}}</h5></div>
				<div class="card-body" >
                    <div class="row">
                        <div class="col-sm-2 mt-15">
                            <div class="form-group">
                                <label for="dtpTranDate">Payment Date <span class="required"> * </span></label>
                                <input type="date" max="{{date('Y-m-d')}}" class="form-control" id="dtpTranDate" value="<?php if($isEdit){ echo date("Y-m-d",strtotime($EditData->TranDate)); }else{ echo date("Y-m-d"); } ?>">
                                <div class="errors text-sm" id="dtpTranDate-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-15">
                            <div class="form-group">
                                <label for="lstLedger">Ledger Name <span class="required"> * </span></label>
                                <select class="form-control select2" id="lstLedger" data-selected="<?php if($isEdit){ echo $EditData->LedgerID; } ?>"> 
                                    <option value="">Select a Ledger</option>
                                </select>
                                <div class="errors text-sm" id="lstLedger-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-2 mt-15 @if($Settings['enable-advance-receipts']==false)  d-none @endif ">
                            <div class="form-group">
                                <label for="dtpTranDate">Advance Available </label>
                                <input type="number" class="form-control" id="txtAdvanceAmt" value="" disabled>
                                <div class="errors text-sm" id="txtAdvanceAmt-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-2 mt-15">
                            <div class="form-group">
                                <label for="lstMOP">Mode Of Payment <span class="required"> * </span></label>
                                <select class="form-control select2" id="lstMOP" > 
                                    <option value="">Select a MOP</option>
                                    <option value="Cash"  @if($isEdit) @if($EditData->MOP=="Cash") selected @endif @endif >Cash</option>
                                    <option value="Cheque"  @if($isEdit) @if($EditData->MOP=="Cheque") selected @endif @endif>Cheque</option>
                                    <option value="RTGS"  @if($isEdit) @if($EditData->MOP=="RTGS") selected @endif @endif>RTGS</option>
                                    <option value="IMPS"  @if($isEdit) @if($EditData->MOP=="IMPS") selected @endif @endif>IMPS</option>
                                    <option value="NEFT"  @if($isEdit) @if($EditData->MOP=="NEFT") selected @endif @endif>NEFT</option>
                                    <option value="UPI"  @if($isEdit) @if($EditData->MOP=="UPI") selected @endif @endif>UPI</option>
                                    <option value="Digital Wallet"  @if($isEdit) @if($EditData->MOP=="Digital Wallet") selected @endif @endif>Digital Wallet</option>
                                </select>
                                <div class="errors text-sm" id="lstMOP-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-2  mt-15" id="divChequeDate" style="display:none;">
                            <div class="form-group">
                                <label for="dtpChequeDate">Cheque Date <span class="required"> * </span></label>
                                <input type="date" min="<?php if($isEdit){echo date("Y-m-01",strtotime($EditData->TranDate));}else{ echo date("Y-m-01");} ?>" class="form-control" id="dtpChequeDate" value="<?php if($isEdit){ echo date("Y-m-d",strtotime($EditData->ChequeDate)); }else{ echo date("Y-m-d"); } ?>">
                                <div class="errors text-sm" id="dtpChequeDate-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-2 mt-15" id="divMOPRefNo" style="display:none;">
                            <div class="form-group">
                                <label for="txtMOPRefNo">MOP Ref. No </label>
                                <input type="text"  class="form-control" id="txtMOPRefNo" value="<?php if($isEdit){ echo $EditData->MOPRefNo; } ?>">
                                <div class="errors text-sm" id="txtMOPRefNo-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-12"><hr></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-sm min-padding" id="tblDetails">
                                <thead>
                                    <tr>
                                        <th class="text-center">Order No</th>
                                        <th class="text-center">Order. Date</th>
                                        <th class="text-center">Order Amount</th>
                                        <th class="text-center  display-none">Paid Amount</th>
                                        <th class="text-center">Balance</th>
                                        <th class="text-center @if($Settings['enable-advance-receipts']==false)  d-none @endif ">Less From Advance</th>
                                        <th class="text-center">Pay Amount</th>
                                        <th class="text-center @if($Settings['enable-advance-receipts']==false)  d-none @endif ">Total Paid</th>
                                        <th class="text-center">New Balance</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-20">
                        <div class="col-sm-12"><hr></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="txtRemakrs">Remarks</label>
                                <textarea class="form-control" rows=4 id="txtRemarks"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row justify-content-end mt-20 fw-600 fs-14 mr-10">
                                <div class="col-sm-5">Total Balance Amount <span class="cright">:</span></div>
                                <div class="col-sm-4 text-right" id="divTotalBalanceAmount"> {{NumberFormat(0,$Settings['price-decimals'])}}</div>
                            </div>
                            <div class="row justify-content-end mt-20 fw-600 fs-14 mr-10  @if($Settings['enable-advance-receipts']==false)  d-none @endif ">
                                <div class="col-sm-5">Total Pay Amount <span class="cright">:</span></div>
                                <div class="col-sm-4 text-right" id="divTotalPayAmount"> {{NumberFormat(0,$Settings['price-decimals'])}}</div>
                            </div>
                            <div class="row justify-content-end mt-20 fw-600 fs-14 mr-10  @if($Settings['enable-advance-receipts']==false)  d-none @endif ">
                                <div class="col-sm-5">Total Less from Advance <span class="cright">:</span></div>
                                <div class="col-sm-4 text-right" id="divTotalAdvancePaidAmount"> {{NumberFormat(0,$Settings['price-decimals'])}}</div>
                            </div>
                            <div class="row justify-content-end mt-20 fw-700 fs-17 mr-10 text-success">
                                <div class="col-sm-5">Total Paid Amount <span class="cright">:</span></div>
                                <div class="col-sm-4 text-right" id="divTotalPaidAmount"> {{NumberFormat(0,$Settings['price-decimals'])}}</div>
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
        var AvaiableAdvPayment=0;
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
                data:{"TranNo":"<?php if($isEdit){ echo $TranNo;} ?>"},
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.LedgerID==$('#lstLedger').attr('data-selected')){selected="selected";}
                        $('#lstLedger').append('<option '+selected+' data-adv-amt="'+NumberFormat(Item.AdvanceAmount,'price')+'" data-state="'+Item.StateID+'"  value="'+Item.LedgerID+'">'+Item.LedgerName+'( '+Item.MobileNumber+' ) </option>');
                    }
                    if($('#lstLedger').val()!=""){$('#lstLedger').trigger('change');}
                }
            });
            $('#lstLedger').select2();
        }
        const showModel=async(title,html1)=>{
            bootbox.dialog({
                title:title,
                closeButton: true,
                size: 'large',
                message: html1,
                buttons: {}
            });
        }
        const getOrders=async()=>{
            $('#tblDetails tbody tr').remove();
            $.ajax({
                type:"post",
                url:"{{route('admin.transaction.receipts.order.get.orders')}}",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:{LedgerID:$('#lstLedger').val(),"TranNo":"<?php if($isEdit){ echo $TranNo;} ?>"},
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){

                    for(Item of response){
                        if(parseFloat(Item.BalanceAmount)>0){
                            let html ='';
                                html+='<tr data-id="'+Item.OrderID+'">'
                                //html+='<td>'+Item.InvoiceNo+'<div class="text-center"><a href="#" data-id="'+Item.InvoiceID+'" class="mr-10 mt-5 fw-700 fs-11 text-primary view-goods-received" title="view Goods Received No in this Invoice">GR</a><a href="#" data-id="'+Item.OrderID+'" class="mr-10 mt-5 fw-700 fs-11 text-success view-purchase-order" title="view Purchase Order No in this Invoice"> PO</a></div><span id="spa'+Item.OrderID+'" class="display-none">'+JSON.stringify(Item)+'</span></td>'
                                html+='<td>'+Item.OrderNo+'<div class="text-center"><a href="#" data-id="'+Item.OrderID+'" class="mr-10 mt-5 fw-700 fs-11 text-primary order-details" title="View order Details">Details</a></div></td>'
                                html+='<td>'+Item.OrderDate.toString().toCustomFormat("{{$Settings['date-format']}}")+'</td>';
                                html+='<td class="text-right">'+NumberFormat(Item.NetAmount,"price")+'</td>';
                                html+='<td class="text-right display-none">'+NumberFormat(Item.PaidAmount,"price")+'</td>';
                                html+='<td class="text-right">'+NumberFormat(Item.BalanceAmount,"price")+'</td>';
                                html+='<td class=" @if($Settings['enable-advance-receipts']==false)  d-none @endif "><div class="input-group"><input type="number" steps="{{NumberSteps($Settings["price-decimals"])}}" data-balance-amount="'+NumberFormat(Item.BalanceAmount,"price")+'" data-id="'+Item.OrderID+'"  class="form-control txtAdvanceAmount" id="txtAdvanceAmount-'+Item.OrderID+'" value="'+NumberFormat(Item.PayLessFromAdvance,'price')+'"></div><div class="errors err-sm '+Item.OrderID+' text-sm" id="txtAdvanceAmount-'+Item.OrderID+'-err">&nbsp;</div></td>';
                                html+='<td><input type="number" steps="{{NumberSteps($Settings["price-decimals"])}}" class="form-control txtPayAmount" data-balance-amount="'+NumberFormat(Item.BalanceAmount,"price")+'" id="txtPA-'+Item.OrderID+'" data-id="'+Item.OrderID+'"  value="'+NumberFormat(Item.PayPaidAmount,'price')+'"><div class="errors err-sm  '+Item.OrderID+' text-sm" id="txtPA-'+Item.OrderID+'-err">&nbsp;</div></td>';
                                
                                html+='<td class=" @if($Settings['enable-advance-receipts']==false)  d-none @endif "><input class="form-control txtTotalAmount" steps="{{NumberSteps($Settings["price-decimals"])}}" data-balance-amount="'+NumberFormat(Item.BalanceAmount,"price")+'" type="number" data-id="'+Item.OrderID+'" id="txtTP-'+Item.OrderID+'"    disabled value="'+NumberFormat(0,'price')+'"><div class="errors err-sm  '+Item.OrderID+' text-sm" id="txtTP-'+Item.OrderID+'-err">&nbsp;</div></td>';
                                html+='<td><input class="form-control txtNewBalAmount" steps="{{NumberSteps($Settings["price-decimals"])}}" data-balance-amount="'+NumberFormat(Item.BalanceAmount,"price")+'" type="number" data-id="'+Item.OrderID+'" id="txtNB-'+Item.OrderID+'"   value="'+NumberFormat(Item.BalanceAmount,"price")+'" disabled "><div class="errors err-sm  '+Item.OrderID+' text-sm" id="txtNB-'+Item.OrderID+'-err">&nbsp;</div></td>';
                                html+='</tr>'
                                $('#tblDetails tbody').append(html);
                        }
                    }
                    formCalculation();
                }
            });
        }
        const getData=()=>{
            let Details=[];
            let TotalAmount=0;
            let AvaiableAdvPayment=$('#txtAdvanceAmt').val();
                AvaiableAdvPayment=isNaN(parseFloat(AvaiableAdvPayment))==false?parseFloat(AvaiableAdvPayment):0;
            $('#tblDetails tbody tr').each(function(){
                let OrderID=$(this).attr('data-id');
                
                let BalanceAmount=$('#txtPA-'+OrderID).attr('data-balance-amount');
                let PaidAmount=$('#txtPA-'+OrderID).val();
                let LessFromAdvance=$('#txtAdvanceAmount-'+OrderID).val();
                

                BalanceAmount=isNaN(parseFloat(BalanceAmount))==false?parseFloat(BalanceAmount):0;
                PaidAmount=isNaN(parseFloat(PaidAmount))==false?parseFloat(PaidAmount):0;
                LessFromAdvance=isNaN(parseFloat(LessFromAdvance))==false?parseFloat(LessFromAdvance):0;

                let Amount=parseFloat(PaidAmount)+parseFloat(LessFromAdvance);

                Amount=isNaN(parseFloat(Amount))==false?parseFloat(Amount):0;
                if(Amount>0){
                    Details[Details.length]={
                        OrderID,BalanceAmount,PaidAmount,LessFromAdvance,Amount
                    }
                }
                TotalAmount+=Amount;
            });
            let formData={};
                formData.TranDate=$('#dtpTranDate').val();
                formData.LedgerType=$('#lstLedgerType').val();
                formData.LedgerID=$('#lstLedger').val();
                formData.AvaiableAdvPayment=AvaiableAdvPayment;
                formData.MOP=$('#lstMOP').val();
                formData.Remarks=$('#txtRemarks').val();
                formData.ChequeDate=$('#dtpChequeDate').val();
                formData.MOPRefNo=$('#txtMOPRefNo').val();
                formData.Details=JSON.stringify(Details);
                formData.PaymentType='Order';
                formData.TotalAmount=TotalAmount;
                return formData;

        }
        const formValidation=(data)=>{
            let status=true;
            let details=data.Details!=undefined?JSON.parse(data.Details):[];
            $('.errors').html('');
            if(data.TranDate==""){
                $('#dtpTranDate-err').html('Payment Date is required');status=false;
            }
            if(data.Supplier==""){
                $('#lstLedger-err').html('Supplier is required');status=false;
            }
            if(data.MOP==""){
                $('#lstMOP-err').html('Mode of Payment is required');status=false;
            }

            if((details=="")||(details.length<=0)){
                status=false;
                toastr.error('Items not found. Atleast one item required.', "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
            }
            if(status==false){$("html, body").animate({ scrollTop: 0 }, "slow");}
            return status;
        }
        const formCalculation=()=>{
            let TotalBalAmount=0,TotalPayAmount=0,TotalAdvanceAmount=0,TotalPaidAmount=0;
			let myTable 	= document.getElementById('tblDetails');
            let totrows		= $('#tblDetails tbody tr').length;
            $('#tblDetails tbody tr').each(function(){
                let pID=$(this).attr('data-id');
                let BalanceAmount=$('#txtPA-'+pID).attr('data-balance-amount');
                let PayAmount=$('#txtPA-'+pID).val();
                let AdvPayment=$('#txtAdvanceAmount-'+pID).val();
                let TotalAmount=$('#txtTP-'+pID).val();

                BalanceAmount=isNaN(parseFloat(BalanceAmount))==false?parseFloat(BalanceAmount):0;
                PayAmount=isNaN(parseFloat(PayAmount))==false?parseFloat(PayAmount):0;
                AdvPayment=isNaN(parseFloat(AdvPayment))==false?parseFloat(AdvPayment):0;
                TotalAmount=isNaN(parseFloat(TotalAmount))==false?parseFloat(TotalAmount):0;

                TotalBalAmount+=parseFloat(BalanceAmount);
                TotalPayAmount+=parseFloat(PayAmount),
                TotalAdvanceAmount+=parseFloat(AdvPayment),
                TotalPaidAmount+=parseFloat(TotalAmount);
            });

            $('#divTotalBalanceAmount').html(NumberFormat(TotalBalAmount,'price'));
            $('#divTotalPayAmount').html(NumberFormat(TotalPayAmount,'price'));
            $('#divTotalAdvancePaidAmount').html(NumberFormat(TotalAdvanceAmount,'price'));
            $('#divTotalPaidAmount').html(NumberFormat(TotalPaidAmount,'price'));
        }
        const ItemValidation=()=>{
            let status=true;
            var AvaiableAdv=AvaiableAdvPayment;
            $('#tblDetails tbody tr').each(function(){
                let pID=$(this).attr('data-id');
                let BalanceAmount=$('#txtPA-'+pID).attr('data-balance-amount');
                let PayAmount=$('#txtPA-'+pID).val();
                let AdvPayment=$('#txtAdvanceAmount-'+pID).val();
                let TotalAmount=0;
                $('.errors.'+pID).html('&nbsp;');
                
                if(PayAmount!=""){
                    if($.isNumeric(PayAmount)==false){
                        $('#txtPA-'+pID+'-err').html('The pay amount must be a numeric value.');status=false;
                    }else if(parseFloat(PayAmount)>parseFloat(BalanceAmount)){
                        $('#txtPA-'+pID+'-err').html('The pay amount must be equal or less than Balance amount.');status=false;
                    }
                }
                if(AdvPayment!=""){
                    if($.isNumeric(AdvPayment)==false){
                        $('#txtAdvanceAmount-'+pID+'-err').html('Less from  Advance amount must be a numeric value.');status=false;
                    }else if(parseFloat(AdvPayment)>parseFloat(AvaiableAdv)){
                        $('#txtAdvanceAmount-'+pID+'-err').html('The Less from Advance amount must be equal or less than Avaiable Advance amount.');status=false;
                    }else if(parseFloat(AdvPayment)>parseFloat(BalanceAmount)){
                        $('#txtAdvanceAmount-'+pID+'-err').html('The Less from  Advance amount must be equal or less than Balance amount');status=false;
                    }else{
                        AvaiableAdv-=AdvPayment;
                    }
                }
                
                TotalAmount+=isNaN(parseFloat(PayAmount))==false?parseFloat(PayAmount):0;
                TotalAmount+=isNaN(parseFloat(AdvPayment))==false?parseFloat(AdvPayment):0;
                let NB=BalanceAmount-TotalAmount;
                $('#txtTP-'+pID).val(NumberFormat(TotalAmount,'price'));
                $('#txtNB-'+pID).val(NumberFormat(NB,'price'));
                if(TotalAmount!=""){
                    if($.isNumeric(TotalAmount)==false){
                        $('#txtTP-'+pID+'-err').html('Less from  Advance amount must be a numeric value.');status=false;
                    }else if(parseFloat(TotalAmount)>parseFloat(BalanceAmount)){
                        $('#txtTP-'+pID+'-err').html('The Total amount must be equal or less than Balance amount');status=false;
                    }
                }
            });
            if(status){
                $('#btnSave').removeAttr('disabled')
            }else{
                $('#btnSave').attr('disabled','disabled')
            }
            formCalculation();
        }
        $(document).on('change','#lstLedger',function(){
            AvaiableAdvPayment=$('#lstLedger option:selected').attr('data-adv-amt');
            AvaiableAdvPayment=isNaN(parseFloat(AvaiableAdvPayment))==false?parseFloat(AvaiableAdvPayment):0;
            $('#txtAdvanceAmt').val(NumberFormat(AvaiableAdvPayment,'price'));
            getOrders();
        });
        $(document).on('change','#lstMOP',function(){
            $('#divMOPRefNo').hide();
            $('#divChequeDate').hide();
            $('#lstMOP-err').html('');
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
            }else if($('#lstMOP').val()==""){
                $('#lstMOP-err').html('Mode of Payment is required');
            }
        });
        $(document).on('change','.InvAmount',function(){
            formCalculation();
        })
        $(document).on('keyup','.InvAmount',function(){formCalculation();})
        $(document).on('click','#btnSave',function(){
            let formData=getData();
            let status=formValidation(formData);
            if(status){
                swal({
                    title: "Are you sure?",
                    text: "You want @if($isEdit==true)Update @else Save @endif this payment!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, @if($isEdit==true) Update @else Save @endif it!",
                    closeOnConfirm: false
                },function(){
                    swal.close();
                    btnLoading($('#btnSave'));
                    $.ajax({
                        type:"post",
                        url:"<?php if($isEdit){ echo route('admin.transaction.receipts.update',$TranNo); }else{ echo route('admin.transaction.receipts.save');} ?>",
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
                                        if(key=="MOP"){$('#lstMOP-err').html(KeyValue);}
                                        if(key=="MOPRefNo"){$('#txtMOPRefNo-err').html(KeyValue);}
                                        if(key=="ChequeDate"){$('#dtpChequeDate-err').html(KeyValue);}
                                    });
                                }
                            }
                        }
                    });
                });
            }
        });
		$(document).on('click','.order-details',function(e){
            e.preventDefault();
            let id=$(this).attr('data-id');
            $.ajax({
                type:"post",
                url:"{{route('admin.transaction.receipts.get.order-details','__ID__')}}".replace('__ID__',id),
                data:{OrderID:id},
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"html",
                async:true,
                error:function(e, x, settings, exception){},
                success:async(response)=>{
                    if(response!=""){
                        let title="Order Details" ;
                        bootbox.dialog({
                            title:title,
                            closeButton: true,
                            size: 'large',
                            className:'width-per-100',
                            message: response,
                            buttons: {}
                        });
                    }
                }
            });
		});
        $(document).on('keyup','.txtPayAmount',function(){
            ItemValidation();
        });
        $(document).on('change','.txtPayAmount',function(){
            ItemValidation();
        });
        $(document).on('keyup','.txtAdvanceAmount',function(){
            ItemValidation();
        });
        $(document).on('change','.txtAdvanceAmount',function(){
           // ItemValidation();
        });
        appInit();
    });
</script>
@endsection
