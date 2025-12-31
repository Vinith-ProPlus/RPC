@extends('layouts.app')
@section('content')
<style>
	
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height:40px;
        text-align: left;
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
                        <div class="col-sm-2 ">
                            <div class="form-group text-center mh-60">
                                <label style="margin-bottom:0px;">From Date</label>
                                <input type="date" id="dtpFromDate" class="form-control " value="{{date('Y-m-d',strtotime($FY->FromDate))}}" min="{{date('Y-m-d',strtotime($FY->FromDate))}}" max="{{date('Y-m-d',strtotime($FY->ToDate))}}">
                            </div>
                        </div>
                        <div class="col-sm-2 ">
                            <div class="form-group text-center mh-60">
                                <label style="margin-bottom:0px;">To Date</label>
                                <input type="date" id="dtpToDate" class="form-control"  value="{{date('Y-m-d',strtotime($FY->ToDate))}}"  min="{{date('Y-m-d',strtotime($FY->FromDate))}}" max="{{date('Y-m-d',strtotime($FY->ToDate))}}">
                            </div>
                        </div>
                        <div class="col-sm-3 justify-content-Center">
                            <div class="form-group  mh-60">
                                <label style="margin-bottom:0px;">Vendor</label>
                                <div>
                                    <select id="lstVendor" class="form-control select2" data-selected="">
                                        <option value="">All</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 justify-content-Center">
                            <div class="form-group text-center mh-60 animate-chk d-flex align-items-center">
								<label class="d-block mt-20" for="chkIncludeZero">
                          			<input class="checkbox_animated" id="chkIncludeZero" type="checkbox" checked>Include Zero
                        		</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-30">
                        <div class="col-12 col-md-12 col-lg-12 table-responsive">
                            <table class="table table-sm" id="tblLedger">
                                <thead>
                                    <tr>
                                        <th class="text-left">Order Date</th>
                                        <th class="text-left">Order No</th>
                                        <th class="text-left">Customer Name</th>
                                        <th class="text-right">Order Value</th>
                                        <th class="text-right">Commission Percentage</th>
                                        <th class="text-right">Commission Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-right"></th>
                                        <th class="text-right"></th>
                                        <th class="text-right">Total ==></th>
                                        <th class="text-right" id="tdTotOrderValue">0</th>
                                        <th class="text-right" ></th>
                                        <th class="text-right" id="tdTotCommission">0</th>
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
		let VendorID="";
        const init=async()=>{
            LoadTable();
			getVendors();
        }
        
        const getVendors=async()=>{ 
            $('#lstVendor').select2('destroy');
            $('#lstVendor option').remove();
            $('#lstVendor').append('<option value="">All Vendors</option>');
            $.ajax({
                type: "post",
                url: "{{route('admin.reports.commision.get.vendors')}}",
                headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')},
				data:{fromData:$('#dtpFromDate').val(),toDate:$('#dtpToDate').val()},
                dataType: "json",
                async: true,
                error:(e, x, settings, exception)=>{resolve({status:false});},
                success:(response)=>{
                    for(let item of response){
                        let selected='';
                        if(item.VendorID==VendorID){selected="selected";}
                        $('#lstVendor').append('<option '+selected+' value="'+item.VendorID+'">'+item.VendorName+' ('+item.MobileNumber+')</option>');
                        
                    }
                    if($('#lstVendor').val()!=""){
                        $('#lstVendor').trigger('change');
                    }
                }
            });
            $('#lstVendor').select2();
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
							VendorID:$('#lstVendor').val(),
							includeZero:$('#chkIncludeZero').prop('checked')?1:0
                        },
						url: "{{route('admin.reports.commision.data')}}?_token="+$('meta[name=_token]').attr('content'),
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
                        {"className": "dt-right", "targets":[3,4,5]}
					],
                    fnDrawCallback: function( oSettings ) {
						$('#tdTotOrderValue').html(NumberFormat(oSettings.json.total.orderValues,'price'))
						$('#tdTotCommission').html(NumberFormat(oSettings.json.total.CommissionAmount,'price'))
                    }
				});
			@endif
        }
        init();
        $(document).on('change','#dtpFromDate',function(){
            $('#dtpToDate').attr('min',$('#dtpFromDate').val());
			getVendors();
            LoadTable();
        });
        $(document).on('change','#dtpToDate',function(){getVendors();LoadTable();});
        $(document).on('change','#lstVendor',function(){
			VendorID=$(this).val()
			LoadTable();
		});
        $(document).on('change','#chkIncludeZero',function(){LoadTable();});
    });
</script>
@endsection