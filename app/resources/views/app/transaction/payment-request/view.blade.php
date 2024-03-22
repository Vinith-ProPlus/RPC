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
	.multiselect-container input.form-check-input{
		width: 1em !important;
    	height: 1em !important;
	}
	.multiselect-option.dropdown-item{
		background:transparent !important;
		
	}
	.multiselect-option.dropdown-item .form-check-label{
		color:black !important;
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
					</div>
					<div class="row mt-20">
						<div class="col-12 col-sm-12 col-lg-12">
                            <table class="table table-sm" id="tblOrders">
                                <thead>
                                    <tr class="valign-top">
                                        <th class="text-center">Req. ID</th>
                                        <th class="text-center">Req. Date</th>
										<th class="text-center">Vendor Name</th>
                                        <th class="text-center">Contact Number</th>
                                        <th class="text-center">Req. Amount</th>
                                        <th class="text-center">Status</th>
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
		let tblOrders=null;
		let filters={
			status : [],
		}
		var cancelReasons={};
		const init=async()=>{
			
			makeStatus();
			
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
					LoadTable();
				}
			});
		}
		
		const getFilters=()=>{
			let status=$('#lstFStatus').val();

			status= $.isArray(status)?status:[];
			console.log($('#lstFStatus').val())
			console.log(filters.status)
			filters.status=JSON.stringify(status);
		}
		const getStatus=async()=>{
			$.ajax({
                type:"post",
                url:"{{route('admin.transaction.payment-requests.filter.status')}}",
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
                success:function(response){
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
						url: "{{route('admin.transaction.payment-requests.data')}}?_token="+$('meta[name=_token]').attr('content'),
						headers:{ 'X-CSRF-Token' : $('meta[name=_token]').attr('content') } ,
						type: "POST"
					},
					deferRender: true,
					responsive: true,
					order: [[1, 'desc']],
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
						{"className": "dt-center", "targets":[4,5]},
					],
					fnDrawCallback:(settings)=>{
						$('.lstTStatus').multiselect({
							enableFiltering: false,
							maxHeight: 250,
							buttonClass: 'btn btn-link',
							onChange: function (element, checked) {
								try {
									let ReqID=$(element).parent().parent().parent().find('.lstTStatus').attr('data-id');
									let status=$(element).parent().parent().parent().find('.lstTStatus').val();
									updateStatus(ReqID,status);
								} catch (error) {
									console.log(error)
								}
							}
						});
						//lstTStatus
					}
				});
			@endif
        }
		const updateStatus=async(ReqID,Status)=>{
			$.ajax({
                type:"post",
                url:"{{route('admin.transaction.payment-requests.status.update')}}",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
				data:{ReqID,Status},
                dataType:"json",
                async:true,
                complete: function(e, x, settings, exception){
					getFilters();
					getStatus();
				},
            });
		}
        init();
    });
</script>
@endsection
