@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Transaction</li>
					<li class="breadcrumb-item">Payments</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="row">
				<div class="col-sm-12">
					<div class="card">
						<div class="card-header text-center">
							<div class="form-row align-items-center">
								<div class="col-md-4">	</div>
								<div class="col-md-4 my-2">
									<h5>{{$PageTitle}}</h5>
								</div>
								<div class="col-md-4 my-2 text-right text-md-right">
									@if($crud['restore']==1)
										<a href="{{ url('/') }}/admin/transaction/payments/trash/view" class="btn  btn-outline-light btn-sm m-r-10" type="button" > Trash view </a>
									@endif
									@if($crud['add']==1)
										<a href="{{ url('/') }}/admin/transaction/payments/advance-payment/create" class="btn  btn-outline-primary mr-10  btn-sm" type="button" title="Advance Payment" >Advance Payment</a>
										<a href="{{ url('/') }}/admin/transaction/payments/invoice-payment/create" class="btn  btn-outline-success btn-air-success btn-sm" type="button" title="Payment  For Invoice" >Invoice Payment</a>
									@endif
								</div>
							</div>
						</div>
						<div class="card-body " >
                            <table class="table" id="tblPayments">
                                <thead>
                                    <tr>
                                        <th class="text-center">Payment ID</th>
                                        <th class="text-center">Payment Date</th>
										<th class="text-center">Vendor</th>
										<th class="text-center">MOP</th>
										<th class="text-center">Ref No</th>
										<th class="text-center">Payment Type</th>
                                        <th class="text-center">Paid Amount</th>
                                        <th class="text-center">Action</th>
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
        const LoadTable=async()=>{
			@if($crud['view']==1)
			$('#tblPayments').dataTable( {
				"bProcessing": true,
				"bServerSide": true,
                "ajax": {"url": "{{url('/')}}/admin/transaction/payments/data?_token="+$('meta[name=_token]').attr('content'),"headers":{ 'X-CSRF-Token' : $('meta[name=_token]').attr('content') } ,"type": "POST"},
				deferRender: true,
				responsive: true,
				dom: 'Bfrtip',
				order: [[0, 'desc']],
				"iDisplayLength": 10,
				"lengthMenu": [[10, 25, 50,100,250,500, -1], [10, 25, 50,100,250,500, "All"]],
				buttons: [
					'pageLength'
					@if($crud['excel']==1) ,{extend: 'excel',footer: true,title: 'Payments',"action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					@if($crud['copy']==1) ,{extend: 'copy',footer: true,title: 'Payments',"action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					@if($crud['csv']==1) ,{extend: 'csv',footer: true,title: 'Payments',"action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					@if($crud['print']==1) ,{extend: 'print',footer: true,title: 'Payments',"action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					@if($crud['pdf']==1) ,{extend: 'pdf',footer: true,title: 'Payments',"action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
				],
				columnDefs: [
					{"className": "dt-center", "targets":5},
					{"className": "dt-right", "targets":6},
					{"className": "dt-center", "targets":7}
				]
			});
			@endif
        }
		$(document).on('click','.btnEdit',function(){
			let pType=$(this).attr('data-payment-type');
			if(pType=="Advance"){
				window.location.replace("{{url('/')}}/admin/transaction/payments/advance-payment/edit/"+ $(this).attr('data-id'));
			}else{
				window.location.replace("{{url('/')}}/admin/transaction/payments/invoice-payment/edit/"+ $(this).attr('data-id'));
			}
		});
		$(document).on('click','.btnDetailView',function(){
			let TranNo=$(this).attr('data-id');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/transaction/payments/details/view",
                data:{TranNo},
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"html",
                async:true,
                error:function(e, x, settings, exception){},
                success:async(response)=>{
                    if(response!=""){
                        let title="Payment Details   " ;
                        if(TranNo!=""){title+=' Of '+TranNo;}
                        bootbox.dialog({
                            title:title,
                            closeButton: true,
							className:'medium',
                            message: response,
                            buttons: {}
                        });
                    }
                }
            });
		});
		$(document).on('click','.btnDelete',function(){
			let ID=$(this).attr('data-id');
			swal({
                title: "Are you sure?",
                text: "You want delete this payment!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-outline-danger",
                confirmButtonText: "Yes, Delete it!",
                closeOnConfirm: false
            },
            function(){swal.close();
            	$.ajax({
            		type:"post",
                    url:"{{url('/')}}/admin/transaction/payments/delete/"+ID,
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    dataType:"json",
                    success:function(response){
                    	swal.close();
                    	if(response.status==true){
                    		$('#tblPayments').DataTable().ajax.reload();
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