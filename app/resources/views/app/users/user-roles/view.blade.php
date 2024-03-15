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
	<div class="row justify-content-center">
		<div class="col-12 col-sm-12 col-lg-12">
			<div class="card">
				<div class="card-header text-center">
					<div class="form-row align-items-center">
						<div class="col-sm-4">	</div>
						<div class="col-sm-4 my-2"><h5>User Roles</h5></div>
						<div class="col-sm-4 my-2 text-right text-md-right">
							@if($crud['add']==1)
								<a href="{{ url('/') }}/admin/users-and-permissions/user-roles/create" class="btn  btn-outline-dark {{$Theme['button-size']}} " type="button" >Add New Role</a>
							@endif
						</div>
					</div>
				</div>
				<div class="card-body " >
                    <table class="table  {{$Theme['table-size']}}" id="tblUserRoles">
                    	<thead>
                            <tr>
                            	<th class="text-center">Role ID</th>
                                <th class="text-center">Role Name</th>
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
@endsection
@section('scripts')
<script src="{{url('/')}}/assets/js/user-roles.js"></script>
<script>
    $(document).ready(function(){
        const LoadTable=async()=>{
			@if($crud['view']==1)
			$('#tblUserRoles').dataTable( {
				"bProcessing": true,
				"bServerSide": true,
                "ajax": {"url": "{{url('/')}}/admin/users-and-permissions/user-roles/data?_token="+$('meta[name=_token]').attr('content'),"headers":{ 'X-CSRF-Token' : $('meta[name=_token]').attr('content') } ,"type": "POST"},
				deferRender: true,
				responsive: true,
				dom: 'Bfrtip',
				"iDisplayLength": 10,
				"lengthMenu": [[10, 25, 50,100,250,500, -1], [10, 25, 50,100,250,500, "All"]],
				buttons: [
					'pageLength' 
					@if($crud['excel']==1) ,{extend: 'excel',className:"{{$Theme['button-size']}}",footer: true,title: 'User Roles',"action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif 
					@if($crud['copy']==1) ,{extend: 'copy',className:"{{$Theme['button-size']}}",footer: true,title: 'User Roles',"action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					@if($crud['csv']==1) ,{extend: 'csv',className:"{{$Theme['button-size']}}",footer: true,title: 'User Roles',"action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					@if($crud['print']==1) ,{extend: 'print',className:"{{$Theme['button-size']}}",footer: true,title: 'User Roles',"action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					@if($crud['pdf']==1) ,{extend: 'pdf',className:"{{$Theme['button-size']}}",footer: true,title: 'User Roles',"action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
				],
				columnDefs: [
					{"className": "dt-center", "targets":2}
				]
			});
			@endif
        }
		$(document).on('click','.btnEdit',function(){
			window.location.replace("{{url('/')}}/admin/users-and-permissions/user-roles/edit/"+ $(this).attr('data-id'));
		});
        LoadTable();
    });
</script>
@endsection