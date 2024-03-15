@extends('layouts.app')
@section('content')
@php $RowIndex=1; @endphp
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Transaction</li>
					<li class="breadcrumb-item"><a href="{{ url('/') }}/admin/transaction/payments/" data-original-title="" title="">{{$PageTitle}}</a></li>
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
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="dtpTranDate">Payment Date <span class="required"> * </span></label>
                                <input type="date" max="{{date('Y-m-d')}}" class="form-control" id="dtpTranDate" value="<?php if($isEdit){ echo date("Y-m-d",strtotime($EditData[0]['TranDate'])); }else{ echo date("Y-m-d"); } ?>">
                                <div class="errors text-sm" id="dtpTranDate-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="lstSupplier">Supplier <span class="required"> * </span></label>
                                <select class="form-control select2" id="lstSupplier" data-selected="<?php if($isEdit){ echo $EditData[0]['SupplierID']; } ?>"> 
                                    <option value="">Select a Supplier</option>
                                </select>
                                <div class="errors text-sm" id="lstSupplier-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="lstMOP">Mode Of Payment <span class="required"> * </span></label>
                                <select class="form-control select2" id="lstMOP" > 
                                    <option value="">Select a MOP</option>
                                    {{-- <option value="Credit" @if($isEdit) @if($EditData[0]['MOP']=="Credit") selected @endif  @else selected @endif>Credit</option> --}}
                                    <option value="Cash"  @if($isEdit) @if($EditData[0]['MOP']=="Cash") selected @endif @endif >Cash</option>
                                    <option value="Cheque"  @if($isEdit) @if($EditData[0]['MOP']=="Cheque") selected @endif @endif>Cheque</option>
                                    <option value="RTGS"  @if($isEdit) @if($EditData[0]['MOP']=="RTGS") selected @endif @endif>RTGS</option>
                                    <option value="IMPS"  @if($isEdit) @if($EditData[0]['MOP']=="IMPS") selected @endif @endif>IMPS</option>
                                    <option value="NEFT"  @if($isEdit) @if($EditData[0]['MOP']=="NEFT") selected @endif @endif>NEFT</option>
                                    <option value="UPI"  @if($isEdit) @if($EditData[0]['MOP']=="UPI") selected @endif @endif>UPI</option>
                                    <option value="Digital Wallet"  @if($isEdit) @if($EditData[0]['MOP']=="Digital Wallet") selected @endif @endif>Digital Wallet</option>
                                </select>
                                <div class="errors text-sm" id="lstMOP-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-2" id="divChequeDate" style="display:none;">
                            <div class="form-group">
                                <label for="dtpChequeDate">Cheque Date <span class="required"> * </span></label>
                                <input type="date" min="<?php if($isEdit){echo date("Y-m-01",strtotime($EditData[0]['TranDate']));}else{ echo date("Y-m-01");} ?>" class="form-control" id="dtpChequeDate" value="<?php if($isEdit){ echo date("Y-m-d",strtotime($EditData[0]['ChequeDate'])); }else{ echo date("Y-m-d"); } ?>">
                                <div class="errors text-sm" id="dtpChequeDate-err"></div>
                            </div>
                        </div>
                        <div class="col-sm-2 " id="divMOPRefNo" style="display:none;">
                            <div class="form-group">
                                <label for="txtMOPRefNo">MOP Ref. No </label>
                                <input type="text"  class="form-control" id="txtMOPRefNo" value="<?php if($isEdit){ echo $EditData[0]['MOPRefNo']; } ?>">
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
                                        <th class="text-center">Inv. No</th>
                                        <th class="text-center">Inv. Date</th>
                                        <th class="text-center display-none">GR</th>
                                        <th class="text-center display-none">Order</th>
                                        <th class="text-center">Invoice Amount</th>
                                        <th class="text-center  display-none">Paid Amount</th>
                                        <th class="text-center">Balance Amount</th>
                                        <th class="text-center">Less From Advance</th>
                                        <th class="text-center">Pay Amount</th>
                                        <th class="text-center">Total Paid</th>
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
                                <div class="col-sm-4 text-right" id="divTotalBalanceAmount"> {{NumberFormat(0,$Settings['PRICE-DECIMALS'])}}</div>
                            </div>
                            <div class="row justify-content-end mt-20 fw-600 fs-14 mr-10">
                                <div class="col-sm-5">Total Pay Amount <span class="cright">:</span></div>
                                <div class="col-sm-4 text-right" id="divTotalPayAmount"> {{NumberFormat(0,$Settings['PRICE-DECIMALS'])}}</div>
                            </div>
                            <div class="row justify-content-end mt-20 fw-600 fs-14 mr-10">
                                <div class="col-sm-5">Total Less from Advance <span class="cright">:</span></div>
                                <div class="col-sm-4 text-right" id="divTotalAdvancePaidAmount"> {{NumberFormat(0,$Settings['PRICE-DECIMALS'])}}</div>
                            </div>
                            <div class="row justify-content-end mt-20 fw-700 fs-17 mr-10 text-success">
                                <div class="col-sm-5">Total Paid Amount <span class="cright">:</span></div>
                                <div class="col-sm-4 text-right" id="divTotalPaidAmount"> {{NumberFormat(0,$Settings['PRICE-DECIMALS'])}}</div>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            @if($crud['view']==true)
                                <a href="{{url('/admin/transaction/payments/')}}" class="btn btn-sm btn-outline-dark m-5">Back</a>
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
        const appInit=()=>{
            getSupplier();
        }
        const getSupplier=async()=>{
            $('#lstSupplier').select2('destroy');
            $('#lstSupplier option').remove();
            $('#lstSupplier').append('<option value="" selected>Select a Supplier</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/transaction/payments/get/supplier",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajax_errors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.SupplierID==$('#lstSupplier').attr('data-selected')){selected="selected";}
                        $('#lstSupplier').append('<option '+selected+' data-state="'+Item.StateID+'"  value="'+Item.SupplierID+'">'+Item.SupplierName+' </option>');
                    }
                    if($('#lstSupplier').val()!=""){$('#lstSupplier').trigger('change');}
                }
            });
            $('#lstSupplier').select2();
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
        const getInvoices=async()=>{
            $('#tblDetails tbody tr').remove();
            $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/transaction/payments/invoice-payment/get/invoices",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:{SupplierID:$('#lstSupplier').val(),"TranNo":"<?php if($isEdit){ echo $TranNo;} ?>"},
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajax_errors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){

                    for(Item of response){
                        let html ='';
                            html+='<tr data-id="'+Item.InvoiceID+'">'
                            //html+='<td>'+Item.InvoiceNo+'<div class="text-center"><a href="#" data-id="'+Item.InvoiceID+'" class="mr-10 mt-5 fw-700 fs-11 text-primary view-goods-received" title="view Goods Received No in this Invoice">GR</a><a href="#" data-id="'+Item.InvoiceID+'" class="mr-10 mt-5 fw-700 fs-11 text-success view-purchase-order" title="view Purchase Order No in this Invoice"> PO</a></div><span id="spa'+Item.InvoiceID+'" class="display-none">'+JSON.stringify(Item)+'</span></td>'
                            html+='<td>'+Item.InvoiceNo+'<div class="text-center"><a href="#" data-id="'+Item.InvoiceID+'" class="mr-10 mt-5 fw-700 fs-11 text-primary invoice-details" title="View Invoice Details">Details</a></div></td>'
                            html+='<td>'+Item.InvoiceDate.toString().toCustomFormat("{{$Settings['DATE-FORMAT']}}")+'</td>';
                            html+='<td class="text-right">'+NumberFormat(Item.TotalAmount,"price")+'</td>';
                            html+='<td class="text-right display-none">'+NumberFormat(Item.PaidAmount,"price")+'</td>';
                            html+='<td class="text-right">'+NumberFormat(Item.BalanceAmount,"price")+'</td>';
                            html+='<td><div class="input-group"><input type="number" steps="{{NumberSteps($Settings["PRICE-DECIMALS"])}}" data-balance-amount="'+NumberFormat(Item.BalanceAmount,"price")+'" data-id="'+Item.InvoiceID+'"  class="form-control txtAdvanceAmount" id="txtAdvanceAmount-'+Item.InvoiceID+'" value="'+NumberFormat(Item.PayLessFromAdvance,'price')+'"><div class="input-group-append"><span class="input-group-text" title="Avaiable of Advance Amount" id="txtAvaiableAdvAmt-'+Item.InvoiceID+'">'+NumberFormat(Item.AdvanceAmt,'price')+'</span></div></div><div class="errors '+Item.InvoiceID+' text-sm" id="txtAdvanceAmount-'+Item.InvoiceID+'-err">&nbsp;</div></td>';
                            html+='<td><input type="number" steps="{{NumberSteps($Settings["PRICE-DECIMALS"])}}" class="form-control txtPayAmount" data-balance-amount="'+NumberFormat(Item.BalanceAmount,"price")+'" id="txtPA-'+Item.InvoiceID+'" data-id="'+Item.InvoiceID+'"  value="'+NumberFormat(Item.PayPaidAmount,'price')+'"><div class="errors '+Item.InvoiceID+' text-sm" id="txtPA-'+Item.InvoiceID+'-err">&nbsp;</div></td>';
                            
                            html+='<td><input class="form-control txtTotalAmount" steps="{{NumberSteps($Settings["PRICE-DECIMALS"])}}" data-balance-amount="'+NumberFormat(Item.BalanceAmount,"price")+'" type="number" data-id="'+Item.InvoiceID+'" id="txtTP-'+Item.InvoiceID+'"   value="'+NumberFormat(Item.PayTotalPaidAmount,'price')+'" disabled value="'+NumberFormat(0,'price')+'"><div class="errors '+Item.InvoiceID+' text-sm" id="txtTP-'+Item.InvoiceID+'-err">&nbsp;</div></td>';
                            html+='</tr>'
                            $('#tblDetails tbody').append(html);
                    }
                    formCalculation();
                }
            });
        }
        const getData=()=>{
            let Details=[];
            let TotalAmount=0;
            $('#tblDetails tbody tr').each(function(){
                let InvoiceID=$(this).attr('data-id');
                
                let BalanceAmount=$('#txtPA-'+InvoiceID).attr('data-balance-amount');
                let AvaiableAdvPayment=$('#txtAvaiableAdvAmt-'+InvoiceID).html();
                let PaidAmount=$('#txtPA-'+InvoiceID).val();
                let LessFromAdvance=$('#txtAdvanceAmount-'+InvoiceID).val();
                

                BalanceAmount=isNaN(parseFloat(BalanceAmount))==false?parseFloat(BalanceAmount):0;
                AvaiableAdvPayment=isNaN(parseFloat(AvaiableAdvPayment))==false?parseFloat(AvaiableAdvPayment):0;
                PaidAmount=isNaN(parseFloat(PaidAmount))==false?parseFloat(PaidAmount):0;
                LessFromAdvance=isNaN(parseFloat(LessFromAdvance))==false?parseFloat(LessFromAdvance):0;

                let Amount=parseFloat(PaidAmount)+parseFloat(LessFromAdvance);

                Amount=isNaN(parseFloat(Amount))==false?parseFloat(Amount):0;
                if(Amount>0){
                    Details[Details.length]={
                        InvoiceID,BalanceAmount,AvaiableAdvPayment,PaidAmount,LessFromAdvance,Amount
                    }
                }
                TotalAmount+=Amount;
            });
            let formData={};
                formData.TranDate=$('#dtpTranDate').val();
                formData.Supplier=$('#lstSupplier').val();
                formData.MOP=$('#lstMOP').val();
                formData.Remarks=$('#txtRemarks').val();
                formData.ChequeDate=$('#dtpChequeDate').val();
                formData.MOPRefNo=$('#txtMOPRefNo').val();
                formData.Details=JSON.stringify(Details);
                formData.PaymentType='Invoice';
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
                $('#lstSupplier-err').html('Supplier is required');status=false;
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
                let AvaiableAdvPayment=$('#txtAvaiableAdvAmt-'+pID).val();
                let TotalAmount=$('#txtTP-'+pID).val();

                BalanceAmount=isNaN(parseFloat(BalanceAmount))==false?parseFloat(BalanceAmount):0;
                PayAmount=isNaN(parseFloat(PayAmount))==false?parseFloat(PayAmount):0;
                AdvPayment=isNaN(parseFloat(AdvPayment))==false?parseFloat(AdvPayment):0;
                AvaiableAdvPayment=isNaN(parseFloat(AvaiableAdvPayment))==false?parseFloat(AvaiableAdvPayment):0;
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
        const ItemValidation=async()=>{
            let status=true;
            
            $('#tblDetails tbody tr').each(function(){
                let pID=$(this).attr('data-id');
                let BalanceAmount=$('#txtPA-'+pID).attr('data-balance-amount');
                let AvaiableAdvPayment=$('#txtAvaiableAdvAmt-'+pID).html();
                let PayAmount=$('#txtPA-'+pID).val();
                let AdvPayment=$('#txtAdvanceAmount-'+pID).val();
                let TotalAmount=0;
                $('.errors.'+pID).html('&nbsp;');

                BalanceAmount=isNaN(parseFloat(BalanceAmount))==false?parseFloat(BalanceAmount):0;
                AvaiableAdvPayment=isNaN(parseFloat(AvaiableAdvPayment))==false?parseFloat(AvaiableAdvPayment):0;
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
                    }else if(parseFloat(AdvPayment)>parseFloat(AvaiableAdvPayment)){
                        $('#txtAdvanceAmount-'+pID+'-err').html('The Less from Advance amount must be equal or less than Avaiable Advance amount.');status=false;
                    }else if(parseFloat(AdvPayment)>parseFloat(BalanceAmount)){
                        $('#txtAdvanceAmount-'+pID+'-err').html('The Less from  Advance amount must be equal or less than Balance amount');status=false;
                    }
                }
                
                TotalAmount+=isNaN(parseFloat(PayAmount))==false?parseFloat(PayAmount):0;
                TotalAmount+=isNaN(parseFloat(AdvPayment))==false?parseFloat(AdvPayment):0;
                $('#txtTP-'+pID).val(NumberFormat(TotalAmount,'price'));
                if(TotalAmount!=""){
                    if($.isNumeric(TotalAmount)==false){
                        $('#txtTP-'+pID+'-err').html('Less from  Advance amount must be a numeric value.');status=false;
                    }else if(parseFloat(TotalAmount)>parseFloat(BalanceAmount)){
                        $('#txtTP-'+pID+'-err').html('The Total amount must be equal or less than Balance amount');status=false;
                    }
                }
            });
            formCalculation();
        }
        $(document).on('change','#lstSupplier',function(){
            getInvoices();
        });
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
                    let postUrl=@if($isEdit) "{{url('/')}}/admin/transaction/payments/edit/{{$TranNo}}" @else "{{url('/')}}/admin/transaction/payments/create" @endif;
                    $.ajax({
                        type:"post",
                        url:postUrl,
                        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                        data:formData,
                        error:function(e, x, settings, exception){ajax_errors(e, x, settings, exception);},
                        complete: function(e, x, settings, exception){btnReset($('#btnSave'));ajaxindicatorstop();$("html, body").animate({ scrollTop: 0 }, "slow");},
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
                                        window.location.replace("{{url('/')}}/admin/transaction/payments");
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
                                        if(key=="Supplier"){$('#lstSupplier-err').html(KeyValue);}
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
        /*
        $(document).on('click','.view-purchase-order',function(e){
            e.preventDefault();
            let id=$(this).attr('data-id');
            try {
                let data=$('#spa'+id).html();
                data=JSON.parse(data);
                let Taxable=0,IGSTAmount=0,CGSTAmount=0,SGSTAmount=0,TotalAmount=0;
                let html=''
                    html+='<table class="table table-sm"><thead><tr><th class="text-center">Order No</th><th class="text-center">Order Date</th><th class="text-center">Taxable</th><th class="text-center">CGST Amount</th><th class="text-center">SGST Amount</th><th class="text-center">IGST Amount</th><th class="text-center">Amount</th></tr></thead><tbody>';
                    $.each( data.POInfo, function( KeyName, KeyValue ) {
                        html+='<tr><td>'+KeyValue.PONo+' </td><td> '+KeyValue.PODate.toString().toCustomFormat("{{$Settings['DATE-FORMAT']}}")+'</td><td class="text-right">'+NumberFormat(KeyValue.Taxable,'price')+'</td><td class="text-right">'+NumberFormat(KeyValue.CGSTAmount,'price')+'</td><td class="text-right">'+NumberFormat(KeyValue.SGSTAmount,'price')+'</td><td class="text-right">'+NumberFormat(KeyValue.IGSTAmount,'price')+'</td><td class="text-right">'+NumberFormat(KeyValue.TotalAmount,'price')+'</td></tr>'
                        Taxable+=parseFloat(KeyValue.Taxable);
                        IGSTAmount+=parseFloat(KeyValue.IGSTAmount);
                        CGSTAmount+=parseFloat(KeyValue.CGSTAmount);
                        SGSTAmount+=parseFloat(KeyValue.SGSTAmount);
                        TotalAmount+=parseFloat(KeyValue.TotalAmount);
                    })
                    html+='</tbody><tfoot><tr><th class="text-right" colspan=2>Total</th><th class="text-right">'+NumberFormat(Taxable,'price')+'</th><th class="text-right">'+NumberFormat(CGSTAmount,'price')+'</th><th class="text-right">'+NumberFormat(SGSTAmount,'price')+'</th><th class="text-right">'+NumberFormat(IGSTAmount,'price')+'</th><th class="text-right">'+NumberFormat(TotalAmount,'price')+'</th></tr></tfoot></table>';
                    html='<div class="row"><div class="col-sm-12 table-responsive">'+html+'</div></div>';
                    showModel('Purchase Order Details',html);
            } catch (error) {
                console.log(error);
            }
        });
        $(document).on('click','.view-goods-received',function(e){
            e.preventDefault();
            let id=$(this).attr('data-id');
            try {
                let data=$('#spa'+id).html();
                data=JSON.parse(data);
                let GRInfo=data.POInfo;
                let Taxable=0,IGSTAmount=0,CGSTAmount=0,SGSTAmount=0,TotalAmount=0;
                let html=''
                    html+='<table class="table table-sm"><thead><tr><th class="text-center">GR No</th><th class="text-center">GR Date</th><th class="text-center">Taxable</th><th class="text-center">CGST Amount</th><th class="text-center">SGST Amount</th><th class="text-center">IGST Amount</th><th class="text-center">Amount</th></tr></thead><tbody>';
                    $.each( data.GRInfo, function( KeyName, KeyValue ) {
                        html+='<tr><td>'+KeyValue.GRNo+' </td><td> '+KeyValue.GRDate.toString().toCustomFormat("{{$Settings['DATE-FORMAT']}}")+'</td><td class="text-right">'+NumberFormat(KeyValue.Taxable,'price')+'</td><td class="text-right">'+NumberFormat(KeyValue.CGSTAmount,'price')+'</td><td class="text-right">'+NumberFormat(KeyValue.SGSTAmount,'price')+'</td><td class="text-right">'+NumberFormat(KeyValue.IGSTAmount,'price')+'</td><td class="text-right">'+NumberFormat(KeyValue.TotalAmount,'price')+'</td></tr>'
                        Taxable+=parseFloat(KeyValue.Taxable);
                        IGSTAmount+=parseFloat(KeyValue.IGSTAmount);
                        CGSTAmount+=parseFloat(KeyValue.CGSTAmount);
                        SGSTAmount+=parseFloat(KeyValue.SGSTAmount);
                        TotalAmount+=parseFloat(KeyValue.TotalAmount);
                    })
                    html+='</tbody><tfoot><tr><th class="text-right" colspan=2>Total</th><th class="text-right">'+NumberFormat(Taxable,'price')+'</th><th class="text-right">'+NumberFormat(CGSTAmount,'price')+'</th><th class="text-right">'+NumberFormat(SGSTAmount,'price')+'</th><th class="text-right">'+NumberFormat(IGSTAmount,'price')+'</th><th class="text-right">'+NumberFormat(TotalAmount,'price')+'</th></tr></tfoot></table>';
                    html='<div class="row"><div class="col-sm-12 table-responsive">'+html+'</div></div>';
                    showModel('Goods Received Details',html);
            } catch (error) {
                console.log(error);
            }
        });*/
		$(document).on('click','.invoice-details',function(e){
            e.preventDefault();
            let id=$(this).attr('data-id');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/transaction/payments/get/invoice-details/"+id,
                data:{InvoiceID:id},
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"html",
                async:true,
                error:function(e, x, settings, exception){},
                success:async(response)=>{
                    if(response!=""){
                        let title="Invoice Details" ;
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
            ItemValidation();
        });
        appInit();
    });
</script>
@endsection
