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
                                <label style="margin-bottom:0px;">Ledger Type</label>
                                <div>
                                    <select id="lstLedgerType" class="form-control"  >
                                        <option value="Customer" select>Customer</option>
                                        <option value="Vendor">Vendor</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 justify-content-Center">
                            <div class="form-group text-center mh-60">
                                <label style="margin-bottom:0px;">Long Standing Days</label>
                                <div>
                                    <input type="number" steps=1  id="txtMinDays" class="form-control" value="" min=0>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-30">
                        <div class="col-12 col-md-12 col-lg-12 ">
                            <table class="table table-sm" id="tblOrderDue">
                                <thead>
                                    <tr>
                                        <th class="text-left">Order No</th>
                                        <th class="text-left">Order Date</th>
                                        <th class="text-left" >Ledger Name</th>
                                        <th class="text-right" >Amount</th>
                                        <th class="text-right">Paid Amount</th>
                                        <th class="text-right">Balance Amount</th>
                                        <th class="text-right">Days Outstandings</th>
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
        var tblOrderDue=null;
        const init=async()=>{
            LoadTable();
        }
        
        const LoadTable=async()=>{
			@if($crud['view']==1)
				if(tblOrderDue!=null){
					tblOrderDue.fnDestroy();
				}
				tblOrderDue=$('#tblOrderDue').dataTable( {
					bProcessing: true,
					bServerSide: true,
					ajax: {
						data:{
                            FromDate:$('#dtpFromDate').val(),
                            ToDate:$('#dtpToDate').val(),
							LedgerType:$('#lstLedgerType').val(),
							minDays:isNaN(parseFloat($('#txtMinDays').val()))==false?parseFloat($('#txtMinDays').val()):0
                        },
						url: "{{route('admin.reports.orders-due.data')}}?_token="+$('meta[name=_token]').attr('content'),
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
                        {"className": "dt-right", "targets":[3,4,5,6]}
					]
				});
			@endif
        }
        init();
        $(document).on('change','#lstLedgerType',function(){
			LoadTable();
		});
        $(document).on('keyup','#txtMinDays',function(){LoadTable();});
    });
</script>
@endsection