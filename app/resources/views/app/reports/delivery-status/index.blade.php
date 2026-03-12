@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Reports</li>
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
						<div class="col-12 col-sm-4">	</div>
						<div class="col-12 col-sm-4 my-2"><h5>{{$PageTitle}}</h5></div>
						<div class="col-12 col-sm-4 my-2 text-right">
						</div>
					</div>
				</div>
				<div class="card-body " >
                    <div id="order_filter" class="row d-flex justify-content-center m-5 mb-2">
                        <div class="col-sm-2 justify-content-Center">
                            <div class="form-group text-center mh-60">
                                <label style="margin-bottom:0px;">From Date</label>
                                <input type="date" id="dtpFromDate" class="form-control " value="{{date('Y-m-d',strtotime($FY->FromDate))}}" min="{{date('Y-m-d',strtotime($FY->FromDate))}}" max="{{date('Y-m-d',strtotime($FY->ToDate))}}">
                            </div>
                        </div>
                        <div class="col-sm-2 justify-content-Center">
                            <div class="form-group text-center mh-60">
                                <label style="margin-bottom:0px;">To Date</label>
                                <input type="date" id="dtpToDate" class="form-control"  value="{{date('Y-m-d',strtotime($FY->ToDate))}}"  min="{{date('Y-m-d',strtotime($FY->FromDate))}}" max="{{date('Y-m-d',strtotime($FY->ToDate))}}">
                            </div>
                        </div>
                        <div class="col-sm-2 justify-content-Center">
                            <div class="form-group text-center mh-60">
                                <label style="margin-bottom:0px;">Status</label>
                                <div>
                                    <select id="lstStatus" class="form-control"  multiple>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 justify-content-Center">
                            <div class="form-group text-center mh-60">
                                <label style="margin-bottom:0px;">Vendor</label>
                                <div>
                                    <select id="lstVendor" class="form-control"   multiple>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 justify-content-Center">
                            <div class="form-group text-center mh-60">
                                <label style="margin-bottom:0px;">Customer</label>
                                <div>
                                    <select id="lstCustomer" class="form-control"  multiple>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-30">
                        <div class="col-12 col-md-12 col-lg-12">
                            <table class="table table-sm" id="tblDeliveryStatus">
                                <thead>
                                    <tr>
                                        <th class="text-left">Order No</th>
                                        <th class="text-left">Order Date</th>
                                        <th class="text-left">Vendor Name</th>
                                        <th class="text-left">Customer Name</th>
                                        <th class="text-right">Order Value</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Delivered On</th>
                                        <th class="text-right">Days From Order</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
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
        let tblDeliveryStatus=null;
		let filters={
			FromDate : [],
            ToDate : [],
            vendorIDs:[],
			customerIDs:[],
			status:[]
		}
        const appInit=async()=>{
            makeStatus();
            makeVendor();
            makeCustomer();

            getFilters();
            getStatus();
        }
		const makeStatus=async()=>{
			$('#lstStatus').multiselect({
				enableFiltering: true,
				maxHeight: 250,
				buttonClass: 'btn btn-link',
				onChange: function (element, checked) {
					getFilters();
					getVendors();
				}
			});
		}
		const makeVendor=async()=>{
			$('#lstVendor').multiselect({
				enableFiltering: true,
				maxHeight: 250,
				buttonClass: 'btn btn-link',
				onChange: function (element, checked) {
					getFilters();
					getCustomers();
				}
			});
		}
		const makeCustomer=async()=>{
			$('#lstCustomer').multiselect({
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
			let status=$('#lstStatus').val();
            let vendors=$('#lstVendor').val();
			let customers=$('#lstCustomer').val();

			status= $.isArray(status)?status:[];
			vendors= $.isArray(vendors)?vendors:[];
			customers= $.isArray(customers)?customers:[];

			filters.FromDate=$('#dtpFromDate').val();
			filters.ToDate=$('#dtpToDate').val();
			filters.customerIDs=JSON.stringify(customers);
			filters.status=JSON.stringify(status);
			filters.vendorIDs=JSON.stringify(vendors);
		}
		const getStatus=async()=>{
			$.ajax({
                type:"post",
                url:"{{route('admin.reports.delivery-status.get.filter.status')}}",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
				data:filters,
                dataType:"json",
                async:true,
				beforeSend:function(){
					$('#lstStatus').parent().hide();
					$('#lstStatus').parent().parent().append('<div id="divStatusLoader" class="Cloader"></div>');
				},
                complete: function(e, x, settings, exception){
					$('#lstStatus').parent().show();
					$('#divStatusLoader').remove();
				},
                success:function(response){ 
					$('#lstStatus option').remove();
					let tmp=JSON.parse(filters.status); 
					for(let item of response){
						let selected="";
						if(tmp.indexOf(item.Status)>=0){selected="selected";}
						$('#lstStatus').append('<option '+selected+' value="'+item.Status+'">'+item.StatusText+'</option>');
					}
					$('#lstStatus').multiselect('rebuild');
                }
            });
			getVendors();
		}
		const getVendors=async()=>{
			$.ajax({
                type:"post",
                url:"{{route('admin.reports.delivery-status.get.filter.vendor')}}",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
				data:filters,
                dataType:"json",
                async:true,
				beforeSend:function(){
					$('#lstVendor').parent().hide();
					$('#lstVendor').parent().parent().append('<div id="divVendorLoader" class="Cloader"></div>');
				},
                complete: function(e, x, settings, exception){
					$('#lstVendor').parent().show();
					$('#divVendorLoader').remove();
				},
                success:function(response){ 
					$('#lstVendor option').remove();
					let tmp=JSON.parse(filters.vendorIDs); 
					for(let item of response){
						let selected="";
						if(tmp.indexOf(item.VendorID)>=0){selected="selected";}
						$('#lstVendor').append('<option '+selected+' value="'+item.VendorID+'">'+item.VendorName+'</option>');
					}
					$('#lstVendor').multiselect('rebuild');
                }
            });
			getCustomers();
		}
		const getCustomers=async()=>{
			$.ajax({
                type:"post",
                url:"{{route('admin.reports.delivery-status.get.filter.customer')}}",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
				data:filters,
                dataType:"json",
                async:true,
				beforeSend:function(){
					$('#lstCustomer').parent().hide();
					$('#lstCustomer').parent().parent().append('<div id="divCustomerLoader" class="Cloader"></div>');
				},
                complete: function(e, x, settings, exception){
					$('#lstCustomer').parent().show();
					$('#divCustomerLoader').remove();
				},
                success:function(response){ 
					$('#lstCustomer option').remove();
					let tmp=JSON.parse(filters.customerIDs); 
					for(let item of response){
						let selected="";
						if(tmp.indexOf(item.CustomerID)>=0){selected="selected";}
						$('#lstCustomer').append('<option '+selected+' value="'+item.CustomerID+'">'+item.CustomerName+'</option>');
					}
					$('#lstCustomer').multiselect('rebuild');
                }
            });
			LoadTable();
		}
        const LoadTable=async()=>{
			@if($crud['view']==1)
				if(tblDeliveryStatus!=null){
					tblDeliveryStatus.fnDestroy();
				}
				tblDeliveryStatus=$('#tblDeliveryStatus').dataTable( {
					bProcessing: true,
					bServerSide: true,
					ajax: {
						data:filters,
						url: "{{route('admin.reports.delivery-status.data')}}?_token="+$('meta[name=_token]').attr('content'),
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
                        {"className": "dt-right", "targets":[4,7]},
                        {"className": "dt-center", "targets":[5,6]}
					]
				});
			@endif
        }
        appInit();
    });
</script>
@endsection