@extends('layouts.app')
@section('content')
<style>
    .stamp-badge {
        padding: 3px 6px;
        margin: -10px;
        z-index: 1;
    }
    .valign-top th{
        vertical-align:top !important;
    }
    .otp-form .inputs input {
        width: 40px;
        height: 40px
    }

    .otp-form input[type=number]::-webkit-inner-spin-button,
    .otp-form input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0
    }
    .otp-form .form-control:focus {
        box-shadow: none;
        border: 2px solid red
    }
    .otp-form  .validate {
        border-radius: 20px;
        height: 40px;
        background-color: red;
        border: 1px solid red;
        width: 140px
    }
</style>
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Transaction</li>
					<li class="breadcrumb-item">{{$PageTitle}}</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row d-flex justify-content-center">
		<div class="col-12 col-sm-12 col-lg-12">
			<div class="card">
				<div class="card-header text-center">
					<div class="row">
						<div class="col-sm-4"></div>
						<div class="col-sm-4 my-2"><h5>{{$PageTitle}}</h5></div>
						<div class="col-sm-4 my-2 text-right text-md-right">
							{{-- @if($crud['restore']==1)
								<a href="{{ url('/') }}/admin/transaction/quotation/trash" class="btn btn-outline-dark {{$Theme['button-size']}} m-r-10" type="button" > Cancelled Quotations </a>
							@endif
							@if($crud['add']==1)
								<a href="{{ url('/') }}/admin/transaction/quotation/create" class="btn btn-outline-success btn-air-success {{$Theme['button-size']}} m-r-10" type="button" >Create</a>
								<a href="{{ url('/') }}/admin/transaction/image-quotation/create" class="btn btn-outline-success btn-air-success {{$Theme['button-size']}}" type="button" >Image Quote Create</a>
							@endif --}}
						</div>
					</div>
				</div>
				<div class="card-body " >
					<div id="order_filter" class="row d-flex justify-content-center m-5 mb-2">
						<div class="col-sm-2 justify-content-Center">
							<div class="form-group text-center mh-60"
								<label style="margin-bottom:0px;">Order Status</label>
								<div>
									<select id="lstFOrderStatus" class="form-control multiselect" multiple >
									</select>
								</div>
							</div>
						</div>
						<div class="col-sm-2 justify-content-Center">
							<div class="form-group text-center mh-60"
								<label style="margin-bottom:0px;">Payment Status</label>
								<div>
									<select id="lstFPaymentStatus" class="form-control multiselect" multiple >
									</select>
								</div>
							</div>
						</div>
						<div class="col-sm-2 justify-content-Center">
							<div class="form-group text-center mh-60"
								<label style="margin-bottom:0px;">Customers</label>
								<div>
									<select id="lstFCustomers" class="form-control multiselect" multiple >
									</select>
								</div>
							</div>
						</div>
						<div class="col-sm-2 justify-content-Center">
							<div class="form-group text-center mh-60"
								<label style="margin-bottom:0px;">Order Dates</label>
								<div>
									<select id="lstFOrderDates" class="form-control multiselect" multiple >
									</select>
								</div>
							</div>
						</div>
						<div class="col-sm-2 justify-content-Center">
							<div class="form-group text-center mh-60"
								<label style="margin-bottom:0px;">Delivery Expected</label>
								<div>
									<select id="lstFDeliveryDates" class="form-control multiselect" multiple >
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="row mt-20">
						<div class="col-12 col-sm-12 col-lg-12">
                            <table class="table table-sm" id="tblOrders">
                                <thead>
                                    <tr class="valign-top">
                                        <th class="text-center">Order No</th>
                                        <th class="text-center">Order Date</th>
										<th class="text-center">Customer Name</th>
                                        <th class="text-center">Contact Number</th>
                                        <th class="text-center">Expected Date</th>
                                        <th class="text-center">Order Amount</th>
                                        <th class="text-center">Paid Amount</th>
                                        <th class="text-center">Balance</th>
                                        <th class="text-center">Order Status</th>
                                        <th class="text-center">Payment Status</th>
                                        <th class="text-center noExport">action</th>
                                    </tr>
                                </thead>
                                <tbody>
								</tbody>
                            </table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade OrderCancelModel" id="OrderCancelModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-15 fw-600" id="OrderCancelModelLabel">Quote Cancel</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="txtMOrderID">
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label for="txtCancelReason">Reason <span class="required">*</span></label>
							<select id="lstMCancelReason" class="form-control select2" data-parent=".OrderCancelModel">
								<option value="">Select a reason</option>
							</select>
                            <div class="errors err-sm order-cancel-err" id="lstMCancelReason-err"></div>
						</div>
					</div>
					<div class="col-12 mt-10">
						<div class="form-group">
							<label for="txtMDescription">Description</label>
							<textarea name="" id="txtMDescription" rows=4 class="form-control"></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="btnCancelOrder">Proceed to Cancel Order</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade  DeliveryConfirmModal" id="DeliveryConfirmModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
	<div class="modal-dialog medium modal-fullscreen-lg-down">
		<div class="modal-content">
			<div class="modal-body text-center otp-form">
                <h6>Please enter the one-time password <br> to confirm delivery </h6>
                <div class="fs-12"> <span>The verification code has been sent to </span> <small id="spaMMobileNo"></small> </div>
                <div id="otp" class="inputs d-flex flex-row justify-content-center mt-20 w-100"> 
                    <input class="m-2 text-center form-control rounded otp-input" type="text" id="txtFirst" maxlength="1" /> 
                    <input class="m-2 text-center form-control rounded otp-input" type="text" id="txtSecond" maxlength="1" /> 
                    <input class="m-2 text-center form-control rounded otp-input" type="text" id="txtThird" maxlength="1" /> 
                    <input class="m-2 text-center form-control rounded otp-input" type="text" id="txtFourth" maxlength="1" /> 
                    <input class="m-2 text-center form-control rounded otp-input" type="text" id="txtFifth" maxlength="1" /> 
                    <input class="m-2 text-center form-control rounded otp-input" type="text" id="txtSixth" maxlength="1" /> 
                </div>
                <p class="resend text-muted fs-13 mb-0 mt-20">Didn't receive code? <a href="#" id="btnResend">Resend again <span id="countdown"></span></a>
                <input type="hidden" id="txtMDOrderID" value="">
                <input type="hidden" id="txtMDDetailID" value="">
                <input type="hidden" id="txtMDMobileNumber" value="">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-outline-primary btn-sm" id="btnMarkAsDelivered">Confirm</button>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
		let tblOrders=null;
        var ResendOTP=false;
        const enableOTPVerify=@if($Settings['enable-Order-Delivery-verify']) true @else false @endif;
        const OTPResendDuration=parseInt("{{$Settings['otp-resend-duration']}}");
		let filters={
			orderStatus : [],
            payemtStatus : [],
            customers:[],
			orderDates:[],
			deliveryDates:[]
		}
		var cancelReasons={};
		const init=async()=>{
			
			makeOrderStatus();
            makePaymentStatus();
			makeCustomers();
			makeOrderDates();
            makeDeliveryDates();
			
			getFilters();
			getOrderStatus();
			getCancelReason();
			OTPInput();
		}
		const makeOrderStatus=async()=>{
			$('#lstFOrderStatus').multiselect({
				enableFiltering: true,
				maxHeight: 250,
				buttonClass: 'btn btn-link',
				onChange: function (element, checked) {
					getFilters();
					getPaymentStatus();
				}
			});
		}
		const makePaymentStatus=async()=>{
			$('#lstFPaymentStatus').multiselect({
				enableFiltering: true,
				maxHeight: 250,
				buttonClass: 'btn btn-link',
				onChange: function (element, checked) {
					getFilters();
					getCustomers();
				}
			});
		}
		const makeCustomers=async()=>{
			$('#lstFCustomers').multiselect({
				enableFiltering: true,
				maxHeight: 250,
				buttonClass: 'btn btn-link',
				onChange: function (element, checked) {
					getFilters();
					getOrderDates();
				}
			});
		}
		const makeOrderDates=async()=>{
			$('#lstFOrderDates').multiselect({
				enableFiltering: true,
				maxHeight: 250,
				buttonClass: 'btn btn-link',
				onChange: function (element, checked) {
					getFilters();
					getDeliveryDates();
				}
			});
		}
		const makeDeliveryDates=async()=>{
			$('#lstFDeliveryDates').multiselect({
				enableFiltering: true,
				maxHeight: 250,
				buttonClass: 'btn btn-link',
				onChange: function (element, checked) {
					getFilters();
					LoadTable();
				}
			});
		}
		
		const getFilters=()=>{
			let orderStatus=$('#lstFOrderStatus').val();
            let paymentStatus=$('#lstFPaymentStatus').val();
			let customers=$('#lstFCustomers').val();
			let orderDates=$('#lstFOrderDates').val();
            let deliveryDates=$('#lstFDeliveryDates').val();

			orderStatus= $.isArray(orderStatus)?orderStatus:[];
			paymentStatus= $.isArray(paymentStatus)?paymentStatus:[];
			customers= $.isArray(customers)?customers:[];
			orderDates= $.isArray(orderDates)?orderDates:[];
			deliveryDates= $.isArray(deliveryDates)?deliveryDates:[];

			filters.orderStatus=JSON.stringify(orderStatus);
			filters.paymentStatus=JSON.stringify(paymentStatus);
			filters.customers=JSON.stringify(customers);
			filters.orderDates=JSON.stringify(orderDates);
			filters.deliveryDates=JSON.stringify(deliveryDates);
		}
		const getOrderStatus=async()=>{
			$.ajax({
                type:"post",
                url:"{{route('admin.transaction.orders.filter.order-status')}}",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
				data:filters,
                dataType:"json",
                async:true,
				beforeSend:function(){
					$('#lstFOrderStatus').parent().hide();
					$('#lstFOrderStatus').parent().parent().append('<div id="divFOrderStatusLoader" class="Cloader"></div>');
				},
                complete: function(e, x, settings, exception){
					$('#lstFOrderStatus').parent().show();
					$('#divFOrderStatusLoader').remove();
				},
                success:function(response){ console.log(response)
					$('#lstFOrderStatus option').remove();
					let tmp=JSON.parse(filters.orderStatus); 
					for(let item of response){
						let selected="";
						if(tmp.indexOf(item.Status)>=0){selected="selected";}
						$('#lstFOrderStatus').append('<option '+selected+' value="'+item.Status+'">'+item.Status+'</option>');
					}
					$('#lstFOrderStatus').multiselect('rebuild');
                }
            });
			getPaymentStatus();
		}
		const getPaymentStatus=async()=>{
			$.ajax({
                type:"post",
                url:"{{route('admin.transaction.orders.filter.payment-status')}}",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
				data:filters,
                dataType:"json",
                async:true,
				beforeSend:function(){
					$('#lstFPaymentStatus').parent().hide();
					$('#lstFPaymentStatus').parent().parent().append('<div id="divFPaymentStatusLoader" class="Cloader"></div>');
				},
                complete: function(e, x, settings, exception){
					$('#lstFPaymentStatus').parent().show();
					$('#divFPaymentStatusLoader').remove();
				},
                success:function(response){ console.log(response)
					$('#lstFPaymentStatus option').remove();
					let tmp=JSON.parse(filters.paymentStatus); 
					for(let item of response){
						let selected="";
						if(tmp.indexOf(item.Status)>=0){selected="selected";}
						$('#lstFPaymentStatus').append('<option '+selected+' value="'+item.Status+'">'+item.Status+'</option>');
					}
					$('#lstFPaymentStatus').multiselect('rebuild');
                }
            });
			getCustomers();
		}
		const getCustomers=async()=>{
			$.ajax({
                type:"post",
                url:"{{route('admin.transaction.orders.filter.customers')}}",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
				data:filters,
                dataType:"json",
                async:true,
				beforeSend:function(){
					$('#lstFCustomers').parent().hide();
					$('#lstFCustomers').parent().parent().append('<div id="divFCustomersLoader" class="Cloader"></div>');
				},
                complete: function(e, x, settings, exception){
					$('#lstFCustomers').parent().show();
					$('#divFCustomersLoader').remove();
				},
                success:function(response){ console.log(response)
					$('#lstFCustomers option').remove();
					let tmp=JSON.parse(filters.customers); 
					for(let item of response){
						let selected="";
						if(tmp.indexOf(item.CustomerID)>=0){selected="selected";}
						$('#lstFCustomers').append('<option '+selected+' value="'+item.CustomerID+'">'+item.CustomerName+'</option>');
					}
					$('#lstFCustomers').multiselect('rebuild');
                }
            });
			getOrderDates();
		}
		const getOrderDates=async()=>{
			$.ajax({
                type:"post",
                url:"{{route('admin.transaction.orders.filter.order-dates')}}",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
				data:filters,
                dataType:"json",
                async:true,
				beforeSend:function(){
					$('#lstFOrderDates').parent().hide();
					$('#lstFOrderDates').parent().parent().append('<div id="divFOrderDatesLoader" class="Cloader"></div>');
				},
                complete: function(e, x, settings, exception){
					$('#lstFOrderDates').parent().show();
					$('#divFOrderDatesLoader').remove();
				},
                success:function(response){ 
					$('#lstFOrderDates option').remove();
					let tmp=JSON.parse(filters.orderDates); 
					for(let item of response){
						let selected="";
						if(tmp.indexOf(item.OrderDate.toCustomFormat("Y-m-d"))>=0){selected="selected";}
						$('#lstFOrderDates').append('<option '+selected+' value="'+item.OrderDate.toCustomFormat("Y-m-d")+'">'+item.OrderDate.toCustomFormat("{{$Settings['date-format']}}")+'</option>');
					}
					$('#lstFOrderDates').multiselect('rebuild');
                }
            });
			getDeliveryDates();
		}
		const getDeliveryDates=async()=>{
			$.ajax({
                type:"post",
                url:"{{route('admin.transaction.orders.filter.delivery-dates')}}",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
				data:filters,
                dataType:"json",
                async:true,
				beforeSend:function(){
					$('#lstFDeliveryDates').parent().hide();
					$('#lstFDeliveryDates').parent().parent().append('<div id="divFDeliveryDatesLoader" class="Cloader"></div>');
				},
                complete: function(e, x, settings, exception){
					$('#lstFDeliveryDates').parent().show();
					$('#divFDeliveryDatesLoader').remove();
				},
                success:function(response){ 
					$('#lstFDeliveryDates option').remove();
					let tmp=JSON.parse(filters.deliveryDates); 
					for(let item of response){
						let selected="";
						if(tmp.indexOf(item.DeliveryDate.toCustomFormat("Y-m-d"))>=0){selected="selected";}
						$('#lstFDeliveryDates').append('<option '+selected+' value="'+item.DeliveryDate.toCustomFormat("Y-m-d")+'">'+item.DeliveryDate.toCustomFormat("{{$Settings['date-format']}}")+'</option>');
					}
					$('#lstFDeliveryDates').multiselect('rebuild');
                }
            });
			LoadTable();
		}
        const LoadTable=async()=>{
			@if($crud['view']==1)
				if(tblOrders!=null){
					tblOrders.fnDestroy();
				}
				tblOrders=$('#tblOrders').dataTable( {
					bProcessing: true,
					bServerSide: true,
					ajax: {
						data:filters,
						url: "{{route('admin.transaction.orders.data')}}?_token="+$('meta[name=_token]').attr('content'),
						headers:{ 'X-CSRF-Token' : $('meta[name=_token]').attr('content') } ,
						type: "POST"
					},
					deferRender: true,
					responsive: true,
					dom: 'Bfrtip',
					iDisplayLength: 10,
					lengthMenu: [[10, 25, 50,100,250,500, -1], [10, 25, 50,100,250,500, "All"]],
					buttons: [
						'pageLength' 
						@if($crud['excel']==1) ,{extend: 'excel',className:"{{$Theme['button-size']}}",footer: true,title: "{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif 
						@if($crud['copy']==1) ,{extend: 'copy',className:"{{$Theme['button-size']}}",footer: true,title: "{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
						@if($crud['csv']==1) ,{extend: 'csv',className:"{{$Theme['button-size']}}",footer: true,title: "{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
						@if($crud['print']==1) ,{extend: 'print',className:"{{$Theme['button-size']}}",footer: true,title: "{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
						@if($crud['pdf']==1) ,{extend: 'pdf',className:"{{$Theme['button-size']}}",footer: true,title: "{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					],
					columnDefs: [
						{"className": "dt-center", "targets":[8,9,10]},
                        {"className": "dt-right", "targets":[5,6,7]}
					]
				});
			@endif
        }
		const getCancelReason=async()=>{
			cancelReasons={};
			$('#lstMCancelReason').select2('destroy');
			$('#lstMCancelReason option').remove();
			$('#lstMCancelReason').append('<option value="">Select a reason</option>');
			$.ajax({
            	type:"post",
                url:"{{route('admin.transaction.orders.get.cancel-reasons')}}",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                success:function(response){
					for(let item of response){
						let selected="";
						cancelReasons[item.RReasonID]=item;
						if(item.RReasonID==$('#lstMCancelReason').attr('data-selected')){selected="selected";}
						$('#lstMCancelReason').append('<option '+selected+' value="'+item.RReasonID+'">'+item.RReason+'</option>');
					}
                }
            });
			$('#lstMCancelReason').select2({scrollAfterSelect: false, dropdownParent: $('.OrderCancelModel')});
		}
        const OTPInput = () => {
            const inputs = document.querySelectorAll('#otp > .otp-input');
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener('keydown', function(event) {
                    if (event.keyCode >= 96 && event.keyCode <= 105) {
                        inputs[i].value = event.key;
                        if (i !== inputs.length - 1) inputs[i + 1].focus();
                        event.preventDefault();
                        return;
                    }
                    if (event.key === "Backspace") {
                        inputs[i].value = '';
                        if (i !== 0) inputs[i - 1].focus();
                    } else {
                        if (i === inputs.length - 1 && inputs[i].value !== '') {
                            return true;
                        } else if (event.keyCode > 47 && event.keyCode < 58) {
                            inputs[i].value = event.key;
                            if (i !== inputs.length - 1) inputs[i + 1].focus();
                            event.preventDefault();
                        } else if (event.keyCode > 64 && event.keyCode < 91) {
                            inputs[i].value = String.fromCharCode(event.keyCode);
                            if (i !== inputs.length - 1) inputs[i + 1].focus();
                            event.preventDefault();
                        }
                    }
                });
            }
        }
        const sendOTP = async () => {
            return await new Promise(async(resolve,reject)=>{
                let MobileNumber =  $('#txtMDMobileNumber').val();
                $.ajax({
                    type: "post",
                    url: "{{route('admin.transaction.orders.send-otp')}}",
                    headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')},
                    data: {OrderID:$('#txtMDOrderID').val(),detailID:$('#txtMDDetailID').val(),MobileNumber},
                    dataType: "json",
                    async: true,
                    error:(e, x, settings, exception)=>{resolve({status:false});},
                    success:(response)=>{
                        $('#txtFirst').focus();
                        $('#btnResend').addClass('text-secondary');
                        timerStart();
                        resolve(response);
                    }
                });
            });
        }
        const getOTP=()=>{
            let OTP ="";
                OTP+=$('#txtFirst').val().toString();
                OTP+=$('#txtSecond').val().toString();
                OTP+=$('#txtThird').val().toString();
                OTP+=$('#txtFourth').val().toString();
                OTP+=$('#txtFifth').val().toString();
                OTP+=$('#txtSixth').val().toString();
            return OTP;
        }
        const timerStart=async()=>{console.log(12);
            const getTimerFormat=()=>{ 
                var minutes = Math.floor(countdownValue / 60);
                var remainingSeconds = countdownValue % 60;
                        
                // Add leading zeros for single-digit minutes and seconds
                minutes = minutes < 10 ? "0" + minutes : minutes;
                remainingSeconds = remainingSeconds < 10 ? "0" + remainingSeconds : remainingSeconds;
                // Update the display
                $("#countdown").text(" ("+minutes + ":" + remainingSeconds+")");
            }
            const updateCountdown=async()=>{
                getTimerFormat();
                countdownValue--;
                if (countdownValue < 0) {
                    $('#btnResend').css('cursor','pointer');
                    clearInterval(timerInterval);
                    ResendOTP=true;
                    $('#btnResend').removeClass('text-secondary');
                    $('#countdown').text("");
                }
            }
            countdownValue = OTPResendDuration;
            $('#btnResend').css('cursor','unset');
            var timerInterval = setInterval(updateCountdown, 1000);
            ResendOTP=false;
        }
        const markAsDelivered=async()=>{
            let OrderID=$('#txtMDOrderID').val(),detailID=$('#txtMDDetailID').val(),OTP=getOTP();
            $.ajax({
                type:"post",
                url: "{{route('admin.transaction.orders.mark-delivered')}}",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:{OrderID,detailID,OTP},
                dataType:"json",
                async:true,
                beforeSend:function(){
                    ajaxIndicatorStart ("The process of moving the order to delivery is currently in progress. Please wait for a few minutes.")
                },
                complete: function(e, x, settings, exception){ajaxIndicatorStop ()},
                success:function(response){
                    if(response.status){
                        $('#DeliveryConfirmModal').modal('hide');
                        toastr.success(response.message, "", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
                        window.location.reload();
                    }else{
                        toastr.error(response.message, "", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
                    }
                }
            });
        }
        init();
		$(document).on('click','.btnCancelOrder',function(){
			let ID=$(this).attr('data-id');
			let OrderNo=$(this).attr('data-order-no');
			let OrderCancelModelLabel="Order Cancel "
			OrderCancelModelLabel+=OrderNo!=""?" - "+OrderNo:"";
			$('#OrderCancelModelLabel').html(OrderCancelModelLabel);
			$('#txtMOrderID').val(ID);
			$('#OrderCancelModel').modal('show');
		});
		$(document).on('click','#btnCancelOrder',function(){
            const validate=(formData)=>{
                let status=true;
                $('.order-cancel-err').html('');
                if(formData.ReasonID==""){
                    $('#lstMCancelReason-err').html('Reason is required.');status=false;
                }
                return status;
            }
			let formData={};
			formData.OrderID=$('#txtMOrderID').val();
			formData.ReasonID=$('#lstMCancelReason').val();
			formData.Description=$('#txtMDescription').val();
            if(validate(formData)==true){
                $.ajax({
                    type:"post",
                    url:"{{route('admin.transaction.orders.cancel','__ID__')}}".replace("__ID__",formData.OrderID),
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    data:formData,
                    dataType:"json",
                    async:true,
                    beforeSend:function(){
                        ajaxIndicatorStart ("Quotation Cancellation on process.")
                    },
                    complete: function(e, x, settings, exception){
                        ajaxIndicatorStop ()
                    },
                    success:function(response){ 
                        if(response.status){
                            $('#OrderCancelModel').modal('hide');
                            toastr.success(response.message, "", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
                            getFilters();
                            getOrderStatus();
                        }else{
                            toastr.error(response.message, "", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
                        }
                    }
                });
            }
		});
		$(document).on('change','#lstMCancelReason',function(){
			try {
				let ReasonID=$('#lstMCancelReason').val();
				$('#txtMDescription').text(cancelReasons[ReasonID].Description);
			} catch (error) {
				console.log(error);
			}
		});
        $(document).on('click','.btnMarkAsDelivery',function(){
            $('#txtMDDetailID').val("");
			$('#txtMDOrderID').val($(this).attr('data-id'));
			$('#txtMDMobileNumber').val($(this).attr('data-mobile-no'));
            isItemDelivered=false;
            swal({
                title: "Are you sure?",
                text: "Would you like to mark this order as Delivered?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-outline-success",
                confirmButtonText: "Continue",
                closeOnConfirm: false
            },function(){
                swal.close();
                if(enableOTPVerify){
                    sendOTP();
                    $('#DeliveryConfirmModal').modal('show');
                    setTimeout(() => {
                        $('#txtFirst').focus();
                    }, 1000);
                }else{
                    markAsDelivered();
                }
            });
        });
        $(document).on('click','#btnMarkAsDelivered',function(){
            markAsDelivered();
        });
		
        $(document).on('click', '#btnResend', function(e) {
            e.preventDefault();
            if(ResendOTP){
                sendOTP();
            }
                    
        });
    });
</script>
@endsection
