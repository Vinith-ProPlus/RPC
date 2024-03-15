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
		<div class="col-12 col-sm-12 col-lg-10">
			<div class="card">
				<div class="card-header text-center">
					<div class="row">
						<div class="col-sm-4">	</div>
						<div class="col-sm-4 my-2"><h5>{{$PageTitle}}</h5></div>
						<div class="col-sm-4 my-2 text-right text-md-right">
							@if($crud['restore']==1)
								<a href="{{ url('/') }}/admin/transaction/quotation/trash" class="btn  btn-outline-dark {{$Theme['button-size']}} m-r-10" type="button" > Cancelled Quotations </a>
							@endif
							@if($crud['add']==1)
								<a href="{{ url('/') }}/admin/transaction/quotation/create" class="btn  btn-outline-success btn-air-success {{$Theme['button-size']}}" type="button" >Create</a>
							@endif
						</div>
					</div>
				</div>
				<div class="card-body " >
					<div class="row">
						<div class="col-12 col-sm-12 col-lg-12">
                            <table class="table" id="tblQuote">
                                <thead>
                                    <tr>
                                        <th class="text-center">Quote No</th>
                                        <th class="text-center">Quote Date</th>
										<th class="text-center">Cotact Person</th>
                                        <th class="text-center">Contact Number</th>
                                        <th class="text-center">Alternate Number</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Allocated To</th>
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
        const LoadTable=async()=>{
			@if($crud['view']==1)
			$('#tblQuote').dataTable( {
				"bProcessing": true,
				"bServerSide": true,
                "ajax": {"url": "{{url('/')}}/admin/transaction/quotation/data?_token="+$('meta[name=_token]').attr('content'),"headers":{ 'X-CSRF-Token' : $('meta[name=_token]').attr('content') } ,"type": "POST"},
				deferRender: true,
				responsive: true,
				dom: 'Bfrtip',
				"iDisplayLength": 10,
				"lengthMenu": [[10, 25, 50,100,250,500, -1], [10, 25, 50,100,250,500, "All"]],
				buttons: [
					'pageLength' 
					@if($crud['excel']==1) ,{extend: 'excel',className:"{{$Theme['button-size']}}",footer: true,title: "{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif 
					@if($crud['copy']==1) ,{extend: 'copy',className:"{{$Theme['button-size']}}",footer: true,title: "{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					@if($crud['csv']==1) ,{extend: 'csv',className:"{{$Theme['button-size']}}",footer: true,title: "{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					@if($crud['print']==1) ,{extend: 'print',className:"{{$Theme['button-size']}}",footer: true,title: "{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					@if($crud['pdf']==1) ,{extend: 'pdf',className:"{{$Theme['button-size']}}",footer: true,title: "{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
				],
				columnDefs: [
					{"className": "dt-center", "targets":[6,7,8]},
				]
			});
			@endif
        }
		$(document).on('click','.btnView',function(){
			window.location.replace("{{url('/')}}/admin/transaction/quotation/view/"+ $(this).attr('data-id'));
		});
		$(document).on('click','.btnVendorQuoteView',function(){
			window.location.replace("{{url('/')}}/admin/transaction/quotation/view/vendor-quote/"+ $(this).attr('data-id'));
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
                    url:"{{url('/')}}/admin/transaction/quotation/delete/"+ID,
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    dataType:"json",
                    success:function(response){
                    	swal.close();
                    	if(response.status==true){
                    		$('#tblQuote').DataTable().ajax.reload();
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
        LoadTable();
    });
	
</script>
@endsection