@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Product Master</li>
					<li class="breadcrumb-item"><a href="{{ url('/') }}/admin/master/product/category/" data-original-title="" title="">{{$PageTitle}}</a></li>
					<li class="breadcrumb-item">Trash</li>
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
						<div class="col-sm-4 my-2"><h5>{{$PageTitle}} Trash</h5></div>
						<div class="col-sm-4 my-2 text-right text-md-right">
							@if($crud['view']==1)
							<a href="{{ url('/') }}/admin/master/product/category/" class="btn  btn-outline-dark {{$Theme['button-size']}}" type="button" > Back </a>
							@elseif($crud['add']==1)
							<a href="{{ url('/') }}/admin/master/product/category/create" class="btn  btn-outline-dark {{$Theme['button-size']}}" type="button" >Back</a> <!-- full-right -->
							@endif
						</div>
					</div>
				</div>
				<div class="card-body " >
					<div class="row">
						<div class="col-12 col-sm-12 col-lg-12">
							<table class="table {{$Theme['table-size']}}" id="tblCategory">
								<thead>
									<tr>
										<th class="text-center">ID</th>
										<th class="text-center">Category</th>
										<th class="text-center">Active Status</th>
										<th class="text-center noExport">action</th>
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
        const LoadTable=async()=>{
			@if($crud['view']==1)
			$('#tblCategory').dataTable( {
				"bProcessing": true,
				"bServerSide": true,
                "ajax": {"url": "{{url('/')}}/admin/master/product/category/trash-data?_token="+$('meta[name=_token]').attr('content'),"headers":{ 'X-CSRF-Token' : $('meta[name=_token]').attr('content') } ,"type": "POST"},
				deferRender: true,
				responsive: true,
				dom: 'Bfrtip',
				"iDisplayLength": 10,
				"lengthMenu": [[10, 25, 50,100,250,500, -1], [10, 25, 50,100,250,500, "All"]],
				buttons: [
					'pageLength' 
					@if($crud['excel']==1) ,{extend: 'excel',className:"{{$Theme['button-size']}}",footer: true,title: "{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif 
					@if($crud['copy']==1) ,{extend: 'copy',className:"{{$Theme['button-size']}}",footer: true,title:"{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					@if($crud['csv']==1) ,{extend: 'csv',className:"{{$Theme['button-size']}}",footer: true,title: "{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					@if($crud['print']==1) ,{extend: 'print',className:"{{$Theme['button-size']}}",footer: true,title:"{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					@if($crud['pdf']==1) ,{extend: 'pdf',className:"{{$Theme['button-size']}}",footer: true,title: "{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
				],
				columnDefs: [
					{"className": "dt-center", "targets":2},
					{"className": "dt-center", "targets":3}
				]
			});
			@endif
        }
		$(document).on('click','.btnRestore',function(){
			let ID=$(this).attr('data-id');
			swal({
                title: "Are you sure?",
                text: "You want Restore this Item!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-outline-success",
                confirmButtonText: "Yes, Restore it!",
                closeOnConfirm: false
            },
            function(){
                swal.close();
            	$.ajax({
            		type:"post",
                    url:"{{url('/')}}/admin/master/product/category/restore/"+ID,
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    dataType:"json",
                    error:function(e, x, settings, exception){ajax_errors(e, x, settings, exception);swal.close();},
                    success:function(response){
                    	swal.close();
                    	if(response.status==true){
                    		$('#tblCategory').DataTable().ajax.reload();
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