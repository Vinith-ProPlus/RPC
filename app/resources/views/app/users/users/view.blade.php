@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}/"><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Users & Permissions</li>
					<li class="breadcrumb-item">{{$PageTitle}}</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid mt-40">
	<div class="row">
		<div class="col-sm-12">
			<div class="row">
				<div class="col-sm-12">
					<div class="card">
						<div class="card-header text-center">
							<div class="form-row align-items-center">
								<div class="col-sm-4">	</div>
								<div class="col-sm-4 my-2">
									<h5>{{$PageTitle}}</h5>
								</div>
								<div class="col-sm-4 my-2 text-right text-md-right">
									@if($crud['restore']==1)
										<a href="{{ url('/') }}/users-and-permissions/users/restore" class="btn  btn-outline-dark {{$Theme['button-size']}}  mr-10" type="button" >Restore</a>
									@endif
									@if($crud['add']==1)
										<a href="{{ url('/') }}/users-and-permissions/users/create" class="btn  btn-outline-success {{$Theme['button-size']}} btn-air-success " type="button" >Create</a>
									@endif
								</div>
							</div>
						</div>
						<div class="card-body " >
                            <table class="table {{$Theme['table-size']}}" id="tblUsers">
                                <thead>
                                    <tr>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Mobile Number</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Address</th>
                                        <th class="text-center">Password</th>
                                        <th class="text-center">User Role</th>
                                        <th class="text-center">User Status</th>
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
        const LoadTable=async()=>{
			@if($crud['view']==1)
			$('#tblUsers').dataTable( {
				"bProcessing": true,
				"bServerSide": true,
                "ajax": {"url": "{{url('/')}}/users-and-permissions/users/data?_token="+$('meta[name=_token]').attr('content'),"headers":{ 'X-CSRF-Token' : $('meta[name=_token]').attr('content') } ,"type": "POST"},
				deferRender: true,
				responsive: true,
				dom: 'Bfrtip',
				"iDisplayLength": 10,
				"lengthMenu": [[10, 25, 50,100,250,500, -1], [10, 25, 50,100,250,500, "All"]],
				buttons: [
					'pageLength' 
					@if($crud['excel']==1) ,{extend: 'excel',className:"{{$Theme['button-size']}}",footer: true,title: "{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif 
					@if($crud['copy']==1) ,{extend: 'copy',className:"{{$Theme['button-size']}}",footer: true,title:  "{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					@if($crud['csv']==1) ,{extend: 'csv',className:"{{$Theme['button-size']}}",footer: true,title:  "{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					@if($crud['print']==1) ,{extend: 'print',className:"{{$Theme['button-size']}}",footer: true,title:  "{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					@if($crud['pdf']==1) ,{extend: 'pdf',className:"{{$Theme['button-size']}}",footer: true,title:  "{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
				],
				columnDefs: [
					{"className": "dt-center", "targets":4},
					{"className": "dt-center", "targets":5},
					{"className": "dt-center", "targets":6}
				]
			});
			@endif
        }
		$(document).on('click','.btnEdit',function(){
			window.location.replace("{{url('/')}}/users-and-permissions/users/edit/"+ $(this).attr('data-id'));
		});
		$(document).on('click','.btnPassword',function(){
			let ID=$(this).attr('data-id');
			$.ajax({
            	type:"post",
                url:"{{url('/')}}/users-and-permissions/users/get/password",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
				data:{UserID:ID},
                dataType:"json",
                success:function(response){
					$('#pwd-'+ID).html(response.password);
                }
            });
		});
		$(document).on('click','.btnDelete',function(e){
        	e.preventDefault();
            var id = $(this).attr("data-id");
            swal({
                title: "Are you sure?",
                text: "You want to Delete this User!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-outline-success",
                confirmButtonText: "Yes, Delete it!",
                closeOnConfirm: false
            },function(){
                swal.close();
                $.ajax({
                    type: "post",
                	headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    url: "{{url('/')}}/users-and-permissions/users/delete/"+ id,
                    success: function (response) {
                        if(response.status==true){
                            toastr.success(response.message, "Success", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",})
                        	$('#tblUsers').DataTable().ajax.reload();
                		}else{
							toastr.error(response.message, "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",})
						}
					}
            	});
        	});
		});
        LoadTable();
    });
</script>
@endsection