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
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height:40px;
        text-align: left;
    }
</style>
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-6">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Reports</li>
					<li class="breadcrumb-item">Ledger</li>
					<li class="breadcrumb-item">Details</li>
				</ol>
			</div>
            <div class="col-sm-6 text-right">
                <?php 
                    $backUrl=route('admin.reports.ledger');
                    if($back=="rpt-os"){
                        $backUrl=route('admin.reports.outstandings');
                    }
                ?>
                <a href="{{$backUrl}}" class="btn btn-outline-dark {{$Theme['button-size']}}">Back</a>
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
                                <input type="date" id="dtpFromDate" class="form-control " value="{{date('Y-m-d',strtotime($fromDate))}}" min="{{date('Y-m-d',strtotime($FY->FromDate))}}" max="{{date('Y-m-d',strtotime($FY->ToDate))}}">
                            </div>
                        </div>
                        <div class="col-sm-2 justify-content-Center">
                            <div class="form-group text-center mh-60">
                                <label style="margin-bottom:0px;">To Date</label>
                                <input type="date" id="dtpToDate" class="form-control"  value="{{date('Y-m-d',strtotime($toDate))}}"  min="{{date('Y-m-d',strtotime($FY->FromDate))}}" max="{{date('Y-m-d',strtotime($FY->ToDate))}}">
                            </div>
                        </div>
                        <div class="col-sm-2 justify-content-Center">
                            <div class="form-group text-center mh-60">
                                <label style="margin-bottom:0px;">Ledger Type</label>
                                <div>
                                    <select id="lstLedgerType" class="form-control"  >
                                        <option value="Customer" @if($LedgerType=='Customer') selected @endif>Customer</option>
                                        <option value="Vendor" @if($LedgerType=='Vendor') selected @endif>Vendor</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 justify-content-Center">
                            <div class="form-group text-center mh-60">
                                <label style="margin-bottom:0px;">Ledger</label>
                                <div>
                                    <select id="lstLedger" class="form-control select2" data-selected="{{$LedgerID}}">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-30">
                        <div class="col-12 col-md-12 col-lg-12">
                            <table class="table table-sm" id="tblLedger">
                                <thead>
                                    <tr>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Time</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Debit</th>
                                        <th class="text-center">Credit</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-right">Opening ==></th>
                                        <th class="text-right" id="tdOpenDebit"></th>
                                        <th class="text-right" id="tdOpenCredit"></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-right">Total ==></th>
                                        <th class="text-right" id="tdTotalDebit"></th>
                                        <th class="text-right" id="tdTotalCredit"></th>
                                    </tr>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-right">Balance ==></th>
                                        <th class="text-right" id="tdBalanceDebit"></th>
                                        <th class="text-right" id="tdBalanceCredit"></th>
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
            getAccounts();
        }
        const getAccounts=async()=>{
            $('#lstLedger').select2('destroy');
            $('#lstLedger option').remove();
            $.ajax({
                type: "post",
                url: "{{route('admin.reports.ledger.get.accounts')}}",
                headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')},
                data: {LedgerType:$('#lstLedgerType').val()},
                dataType: "json",
                async: true,
                error:(e, x, settings, exception)=>{resolve({status:false});},
                success:(response)=>{
                    for(let item of response){
                        let selected='';
                        if(item.LedgerID==$('#lstLedger').attr('data-selected')){selected="selected";}
                        $('#lstLedger').append('<option '+selected+' value="'+item.LedgerID+'">'+item.LedgerName+' ('+item.MobileNumber+')</option>');
                        
                    }
                    if($('#lstLedger').val()!=""){
                        $('#lstLedger').trigger('change');
                    }
                }
            });
            $('#lstLedger').select2();
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
                            LedgerID:$('#lstLedger').val()
                        },
						url: "{{route('admin.reports.ledger.ledger-view')}}?_token="+$('meta[name=_token]').attr('content'),
						headers:{ 'X-CSRF-Token' : $('meta[name=_token]').attr('content') } ,
						type: "POST"
					},
					deferRender: true,
					responsive: true,
					dom: 'Bfrtip',
                    searching: false,
                    info: false,
                    paging: true,
                    sort:false,
					lengthMenu: [[10, 25, 50,100,250,500, -1], [10, 25, 50,100,250,500, "All"]],
					buttons: [
                        'pageLength','csv',
						@if($crud['excel']==1) ,{extend: 'excel',className:"{{$Theme['button-size']}}",footer: true,title: "{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif 
						@if($crud['copy']==1) ,{extend: 'copy',className:"{{$Theme['button-size']}}",footer: true,title: "{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
						@if($crud['csv']==1) ,{extend: 'csv',className:"{{$Theme['button-size']}}",footer: true,title: "{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
						@if($crud['print']==1) ,{extend: 'print',className:"{{$Theme['button-size']}}",footer: true,title: "{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
						@if($crud['pdf']==1) ,{extend: 'pdf',className:"{{$Theme['button-size']}}",footer: true,title: "{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					],
					columnDefs: [
                        {"className": "dt-right", "targets":[3,4]}
					],
                    "fnDrawCallback": function( oSettings ) {
                        if(oSettings.json.totals.OpenDebit==0 && oSettings.json.totals.OpenCredit==0){
                            oSettings.json.totals.OpenCredit=NumberFormat(0,'price');
                        }
                        $('#tdOpenDebit').html(oSettings.json.totals.OpenDebit)
                        $('#tdOpenCredit').html(oSettings.json.totals.OpenCredit)
                        $('#tdTotalDebit').html(oSettings.json.totals.TotalDebit)
                        $('#tdTotalCredit').html(oSettings.json.totals.TotalCredit)
                        $('#tdBalanceDebit').html(oSettings.json.totals.TotalDebitBalance)
                        $('#tdBalanceCredit').html(oSettings.json.totals.TotalCreditBalance)
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
        $(document).on('change','#lstLedgerType',function(){getAccounts();});
        $(document).on('change','#lstLedger',function(){LoadTable();});

    });
</script>
@endsection