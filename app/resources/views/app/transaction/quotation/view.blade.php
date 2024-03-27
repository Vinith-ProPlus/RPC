@extends('layouts.app')
@section('content')
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
						</div>
					</div>
				</div>
				<div class="card-body " >
					<div id="order_filter" class="row d-flex justify-content-center m-5 mb-2">
						<div class="col-sm-2 justify-content-Center">
							<div class="form-group text-center mh-60"
								<label style="margin-bottom:0px;">Status</label>
								<div>
									<select id="lstFStatus" class="form-control multiselect" multiple >
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
								<label style="margin-bottom:0px;">Quote Dates</label>
								<div>
									<select id="lstFQuoteDates" class="form-control multiselect" multiple >
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="row mt-20">
						<div class="col-12 col-sm-12 col-lg-12">
                            <table class="table" id="tblQuotes">
                                <thead>
                                    <tr>
                                        <th class="text-center">Quote No</th>
                                        <th class="text-center">Quote Date</th>
										<th class="text-center">Customer Name</th>
                                        <th class="text-center">Contact Number</th>
                                        <th class="text-center">Expected Delivery</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Status</th>
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
<div class="modal fade QuoteCancelModel" id="QuoteCancelModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-15 fw-600" id="QuoteCancelModelLabel">Quote Cancel</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="txtMQID">
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label for="txtCancelReason">Reason <span class="required">*</span></label>
							<select id="lstMCancelReason" class="form-control select2" data-parent=".QuoteCancelModel">
								<option value="">Select a reason</option>
							</select>
                            <div class="errors err-sm quote-cancel-err" id="lstMCancelReason-err"></div>
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
				<button type="button" class="btn btn-primary" id="btnCancelQuote">Cancel Quote</button>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
		let tblQuotes=null;
		let filters={
			status : [],
            customers:[],
			quoteDates:[]
		}
		var cancelReasons={};
		const init=async()=>{
			
			makeStatus();
			makeCustomers();
			makeQuoteDates();
			
			getFilters();
			getStatus();
			getCancelReason();
		}
		const makeStatus=async()=>{
			$('#lstFStatus').multiselect({
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
					getQuoteDates();
				}
			});
		}
		const makeQuoteDates=async()=>{
			$('#lstFQuoteDates').multiselect({
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
			let status=$('#lstFStatus').val();
			let customers=$('#lstFCustomers').val();
			let quoteDates=$('#lstFQuoteDates').val();
			status= $.isArray(status)?status:[];
			customers= $.isArray(customers)?customers:[];
			quoteDates= $.isArray(quoteDates)?quoteDates:[];


			filters.status=JSON.stringify(status);
			filters.customers=JSON.stringify(customers);
			filters.quoteDates=JSON.stringify(quoteDates);
		}
		const getStatus=async()=>{
			$.ajax({
                type:"post",
                url:"{{route('admin.transaction.quotes.filter.status')}}",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
				data:filters,
                dataType:"json",
                async:true,
				beforeSend:function(){
					$('#lstFStatus').parent().hide();
					$('#lstFStatus').parent().parent().append('<div id="divFStatusLoader" class="Cloader"></div>');
				},
                complete: function(e, x, settings, exception){
					$('#lstFStatus').parent().show();
					$('#divFStatusLoader').remove();
				},
                success:function(response){ console.log(response)
					$('#lstFStatus option').remove();
					let tmp=JSON.parse(filters.status); 
					for(let item of response){
						let selected="";
						if(tmp.indexOf(item.Status)>=0){selected="selected";}
						$('#lstFStatus').append('<option '+selected+' value="'+item.Status+'">'+item.Status+'</option>');
					}
					$('#lstFStatus').multiselect('rebuild');
                }
            });
			getCustomers();
		}
		const getCustomers=async()=>{
			$.ajax({
                type:"post",
                url:"{{route('admin.transaction.quotes.filter.customers')}}",
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
			getQuoteDates();
		}
		const getQuoteDates=async()=>{
			$.ajax({
                type:"post",
                url:"{{route('admin.transaction.quotes.filter.quote-dates')}}",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
				data:filters,
                dataType:"json",
                async:true,
				beforeSend:function(){
					$('#lstFQuoteDates').parent().hide();
					$('#lstFQuoteDates').parent().parent().append('<div id="divFQuoteDatesLoader" class="Cloader"></div>');
				},
                complete: function(e, x, settings, exception){
					$('#lstFQuoteDates').parent().show();
					$('#divFQuoteDatesLoader').remove();
				},
                success:function(response){ 
					$('#lstFQuoteDates option').remove();
					let tmp=JSON.parse(filters.customers); 
					for(let item of response){
						let selected="";
						if(tmp.indexOf(item.QuoteDate.toCustomFormat("Y-m-d"))>=0){selected="selected";}
						$('#lstFQuoteDates').append('<option '+selected+' value="'+item.QuoteDate.toCustomFormat("Y-m-d")+'">'+item.QuoteDate.toCustomFormat("{{$Settings['date-format']}}")+'</option>');
					}
					$('#lstFQuoteDates').multiselect('rebuild');
                }
            });
			LoadTable();
		}
        const LoadTable=async()=>{
			@if($crud['view']==1)
				if(tblQuotes!=null){
					tblQuotes.fnDestroy();
				}
				tblQuotes=$('#tblQuotes').dataTable( {
					bProcessing: true,
					bServerSide: true,
					ajax: {
						data:filters,
						url: "{{route('admin.transaction.quotes.data')}}?_token="+$('meta[name=_token]').attr('content'),
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
						{"className": "dt-center", "targets":[6,7]},
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
                url:"{{route('admin.transaction.quotes.get.cancel-reasons')}}",
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
			$('#lstMCancelReason').select2({scrollAfterSelect: false, dropdownParent: $('.QuoteCancelModel')});
		}
        init();
		$(document).on('click','.btnCancelQuote',function(){
			let ID=$(this).attr('data-id');
			let QNo=$(this).attr('data-qno');
			let QuoteCancelModelLabel="Quote Cancel "
			QuoteCancelModelLabel+=QNo!=""?" - "+QNo:"";
			$('#QuoteCancelModelLabel').html(QuoteCancelModelLabel);
			$('#txtMQID').val(ID);
			$('#QuoteCancelModel').modal('show');
		});
		$(document).on('click','#btnCancelQuote',function(){
			
            const validate=(formData)=>{
                let status=true;
                $('.quote-cancel-err').html('');
                if(formData.ReasonID==""){
                    $('#lstMCancelReason-err').html('Reason is required.');status=false;
                }
                return status;
            }
			let formData={};
			formData.QID=$('#txtMQID').val();
			formData.ReasonID=$('#lstMCancelReason').val();
			formData.Description=$('#txtMDescription').val();
			if(validate(formData)==true){
				$.ajax({
					type:"post",
					url:"{{route('admin.transaction.quotes.cancel','__ID__')}}".replace("__ID__",formData.QID),
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
							$('#QuoteCancelModel').modal('hide');
							toastr.success(response.message, "", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
							getFilters();
							getStatus();
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
    });
</script>
@endsection
