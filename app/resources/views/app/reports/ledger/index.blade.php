@extends('layouts.app')
@section('content')
<style>
    .date-link {
        background-color: transparent;  /* Light background color */
        border: none;
        padding: 5px 10px;
        border-radius: 3px;
        color: var(--bs-link-color);  /* Text color */
        text-decoration: none;  /* Remove underline */
        cursor: pointer;  /* Make it look clickable */
        text-align:center;
    }

    .date-link:hover,
    .date-link:focus {
        border: none;
        box-shadow:none;
        background-color: transparent;  /* Change background on hover */
    }
</style>
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
                                <label style="margin-bottom:0px;">Filter</label>
                                <div>
                                    <select id="lstLedgerFilter" class="form-control">
                                        <option value="all">All Ledgers</option>
                                        <option value="non-zero" selected>Non-Zero Balances Only</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-30">
                        <div class="col-12 col-md-12 col-lg-12 table-responsive">
                            <table class="table table-sm" id="tblLedger">
                                <thead>
                                    <tr>
                                        <th class="text-center">Ledger Name</th>
                                        <th class="text-center">Opening</th>
                                        <th class="text-center" >Debit</th>
                                        <th class="text-center" >Credit</th>
                                        <th class="text-center">Balance</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-right">Total ==></th>
                                        <th class="text-right" id="totOpening">0</th>
                                        <th class="text-right" id="totDebit">0</th>
                                        <th class="text-right" id="totCredit">0</th>
                                        <th class="text-right" id="totBalance">0</th>
                                    </tr>
                                </tfoot>
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
        var tblLedger=null;
        const init=async()=>{
            LoadTable();
        }
        
        const LoadTable=async()=>{
			@if($crud['view']==1)
				if(tblLedger!=null){
					tblLedger.fnDestroy();
				}
				tblLedger=$('#tblLedger').dataTable( {
					bProcessing: true,
					bServerSide: true,
					ajax: {
						data:{
                            FromDate:$('#dtpFromDate').val(),
                            ToDate:$('#dtpToDate').val(),
                            LedgerType:$('#lstLedgerType').val(),
                            Filter:$('#lstLedgerFilter').val()
                        },
						url: "{{route('admin.reports.ledger.data')}}?_token="+$('meta[name=_token]').attr('content'),
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
                        {"className": "dt-right", "targets":[1,2,3,4]}
					],
                    fnDrawCallback: function( oSettings ) {
                        $('#totOpening').html(oSettings.json.total.opening)
                        $('#totDebit').html(oSettings.json.total.debit)
                        $('#totCredit').html(oSettings.json.total.credit)
                        $('#totBalance').html(oSettings.json.total.Balance)
                    }
				});
			@endif
        }
        init();
        $(document).on('change','#dtpFromDate',function(){
            $('#dtpToDate').attr('min',$('#dtpFromDate').val());
            LoadTable();
        });
        $(document).on('change','#dtpToDate',function(){LoadTable();});
        $(document).on('change','#lstLedgerType',function(){
            LoadTable();
        });
        $(document).on('change','#lstLedgerFilter',function(){LoadTable();});
        $(document).on('click','.btnLedgerDetails',function(e){
            e.preventDefault();
            let href=$(this).attr('href');
            let fromDate=$('#dtpFromDate').val();
            let toDate=$('#dtpToDate').val();
            let ltype=$('#lstLedgerType').val();
            href+="?ltype="+ltype+"&from="+fromDate+"&to="+toDate;
            window.location.replace(href);
        });
    });
</script>
@endsection