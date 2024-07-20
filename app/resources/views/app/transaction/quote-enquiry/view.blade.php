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
							@if($crud['restore']==1)
								<a href="{{ url('/') }}/admin/transaction/quote-enquiry/trash" class="btn btn-outline-dark {{$Theme['button-size']}} m-r-10" type="button" > Cancelled Quotations </a>
							@endif
							@if($crud['add']==1)
								<a href="{{ url('/') }}/admin/transaction/quote-enquiry/create" class="btn btn-outline-success btn-air-success {{$Theme['button-size']}} m-r-10" type="button" >Create</a>
								<a href="{{ url('/') }}/admin/transaction/quote-enquiry/image-quote/create" class="btn btn-outline-success btn-air-success {{$Theme['button-size']}}" type="button" >Image Quote Create</a>
							@endif
						</div>
					</div>
				</div>
				<div class="card-body">
					<div id="order_filter" class="row d-flex justify-content-center m-5 mb-2">
						<div class="col-sm-2 justify-content-Center">
							<div class="form-group text-center mh-60">
								<label style="margin-bottom:0px;">Status</label>
								<div>
									<select id="lstFStatus" class="form-control multiselect" multiple >
									</select>
								</div>
							</div>
						</div>
						<div class="col-sm-2 justify-content-Center">
							<div class="form-group text-center mh-60">
								<label style="margin-bottom:0px;">Customers</label>
								<div>
									<select id="lstFCustomers" class="form-control multiselect" multiple >
									</select>
								</div>
							</div>
						</div>
						<div class="col-sm-2 justify-content-Center">
							<div class="form-group text-center mh-60">
								<label style="margin-bottom:0px;">Quote Enquiry Dates</label>
								<div>
									<select id="lstFQuoteDates" class="form-control multiselect" multiple>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="row mt-20">
						<div class="col-12 col-sm-12 col-lg-12">
                            <table class="table" id="tblQuoteEnquiry">
                                <thead>
                                    <tr>
                                        <th>Enquiry No</th>
                                        <th>Enquiry Date</th>
										<th>Customer Name</th>
                                        <th>Contact Number</th>
                                        <th>Email</th>
                                        <th>Expected Delivery</th>
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
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        let RootUrl=$('#txtRootUrl').val();
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
                url:"{{route('admin.transaction.enquiry.filter.status')}}",
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
                url:"{{route('admin.transaction.enquiry.filter.customers')}}",
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
                url:"{{route('admin.transaction.enquiry.filter.quote-dates')}}",
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
				tblQuotes=$('#tblQuoteEnquiry').dataTable( {
					bProcessing: true,
					bServerSide: true,
					ajax: {
						data:filters,
						url: "{{route('admin.transaction.enquiry.data')}}?_token="+$('meta[name=_token]').attr('content'),
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
		$(document).on('click','.btnView',function(){
			window.location.replace("{{url('/')}}/admin/transaction/quote-enquiry/view/"+ $(this).attr('data-id'));
		});
		$(document).on('click','.btnVendorQuoteView',function(){
			window.location.replace("{{url('/')}}/admin/transaction/quote-enquiry/view/vendor-quote/"+ $(this).attr('data-id'));
		});

		$(document).on('click','.btnDelete',function(){
			let ID=$(this).attr('data-id');
			swal({
                title: "Are you sure?",
                text: "You want to Cancel this Quotation!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-outline-danger",
                confirmButtonText: "Yes, Cancel it!",
                closeOnConfirm: false
            },
            function(){swal.close();
            	$.ajax({
            		type:"post",
                    url:"{{url('/')}}/admin/transaction/quote-enquiry/delete/"+ID,
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    dataType:"json",
                    success:function(response){
                    	swal.close();
                    	if(response.status==true){
                    		$('#tblQuoteEnquiry').DataTable().ajax.reload();
                    		toastr.success(response.message, "Success", {
                                positionClass: "toast-top-right",
                                containerId: "toast-top-right",
                                showMethod: "slideDown",
                                hideMethod: "slideUp",
                                progressBar: !0
                            })
                    	}else{
                    		toastr.error(response.message, "Failed", {
                                positionClass: "toast-top-right",
                                containerId: "toast-top-right",
                                showMethod: "slideDown",
                                hideMethod: "slideUp",
                                progressBar: !0
                            })
                    	}
                    }
            	});
            });
		});
        init();
    });
</script>
@endsection
