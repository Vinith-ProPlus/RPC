@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Transaction</li>
					<li class="breadcrumb-item">Receipts</li>
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
									@if($crud['add']==1)
										@if($Settings['enable-advance-receipts'])
											<a href="{{route('admin.transaction.receipts.advance.create')}}" class="btn  btn-outline-primary mr-10  btn-sm" type="button" title="Advance entry from customers" >Advance</a>
										@endif
										<a href="{{route('admin.transaction.receipts.order.create')}}" class="btn  btn-outline-success btn-air-success btn-sm" type="button" title="Receipt entry for order" >Receipt</a>
									@endif
								</div>
							</div>
						</div>
						<div class="card-body " >
                            <table class="table" id="tblReceipts">
                                <thead>
                                    <tr>
                                        <th class="text-center">Receipt ID</th>
                                        <th class="text-center">Receipt Date</th>
										<th class="text-center">Customer</th>
										<th class="text-center">MOP</th>
										<th class="text-center">Ref No</th>
										<th class="text-center">Receipt Type</th>
                                        <th class="text-center">Receipt Amount</th>
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
			$('#tblReceipts').dataTable( {
				"bProcessing": true,
				"bServerSide": true,
                "ajax": {"url": "{{route('admin.transaction.receipts.data')}}?_token="+$('meta[name=_token]').attr('content'),"headers":{ 'X-CSRF-Token' : $('meta[name=_token]').attr('content') } ,"type": "POST"},
				deferRender: true,
				responsive: true,
				dom: 'Bfrtip',
				order: [[0, 'desc']],
				"iDisplayLength": 10,
				"lengthMenu": [[10, 25, 50,100,250,500, -1], [10, 25, 50,100,250,500, "All"]],
				buttons: [
					'pageLength'
					@if($crud['excel']==1) ,{extend: 'excel',footer: true,title: 'receipts',"action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					@if($crud['copy']==1) ,{extend: 'copy',footer: true,title: 'receipts',"action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					@if($crud['csv']==1) ,{extend: 'csv',footer: true,title: 'receipts',"action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					@if($crud['print']==1) ,{extend: 'print',footer: true,title: 'receipts',"action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					@if($crud['pdf']==1) ,{extend: 'pdf',footer: true,title: 'receipts',"action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
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
			let ID=$(this).attr('data-id');
			if(pType=="Advance"){
				window.location.replace("{{route('admin.transaction.receipts.advance.edit','__ID__')}}".replace("__ID__",ID) );
			}else{
				window.location.replace("{{route('admin.transaction.receipts.order.edit','__ID__')}}".replace("__ID__",ID) );
			}
		});
		$(document).on('click','.btnDetailView',function(){
			let TranNo=$(this).attr('data-id');
            $.ajax({
                type:"post",
                url:"{{route('admin.transaction.receipts.details-view')}}",
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
                text: "You want delete this receipt!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-outline-danger",
                confirmButtonText: "Yes, Delete it!",
                closeOnConfirm: false
            },
            function(){swal.close();
            	$.ajax({
            		type:"post",
                    url:"{{route('admin.transaction.receipts.delete','__ID__')}}".replace("__ID__",ID),
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    dataType:"json",
                    success:function(response){
                    	swal.close();
                    	if(response.status==true){
                    		$('#tblReceipts').DataTable().ajax.reload();
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
