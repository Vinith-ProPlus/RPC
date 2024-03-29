@extends('layouts.app')
@section('content')
<link href='//fonts.googleapis.com/css?family=Open+Sans:100,200,300,400,500,600,700|Montserrat:100,200,300,400,500,600,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/support-ticket.css">
<style>
    body,.page-body{
        background-color: #F3F3F3 !important;
        background: #F3F3F3 !important;
    }
    .card{
        font-family: "Montserrat",sans-serif !important;
        font-weight: 400 !important;
        line-height: 1.2 !important;
    }
</style>
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">{{$PageTitle}}</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row d-flex justify-content-center">
		<div class="col-12 col-sm-12 col-lg-11">
			<div class="card">
				<div class="card-header text-center">
					<div class="row">
						<div class="col-sm-4"></div>
						<div class="col-sm-4 my-2"><h5>{{$PageTitle}}</h5></div>
						<div class="col-sm-4 my-2 text-right text-md-right">
                            @if($crud['add']==1)
                                <button type="button" id="btnNewTicket" class="btn btn-outline-success btn-min-width box-shadow-2 round">New Ticket</button>
                            @endif
						</div>
					</div>
				</div>
				<div class="card-body">
                    <div class="row d-flex justify-content-center my-3">
                        <div class="col-sm-2">
                            <div class="form-group text-center mh-60">
                                <label class="mb-6">From Date</label>
                                <input type="date" class="form-control" id="dtpFromDate" value="{{date('Y-m-d',strtotime('-30 days'))}}">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group text-center mh-60">
                                <label class="mb-6">To Date</label>
                                <input type="date" class="form-control" id="dtpToDate" value="{{date('Y-m-d')}}">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group text-center mh-60">
                                <label class="mb-6">Ticket From</label>
                                <select class="form-control" id="lstFTicketFor">
                                    <option value="">All</option>
                                    <option value="Vendor">Vendor</option>
                                    <option value="Customer">Customer</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group text-center mh-60">
                                <label class="mb-6">User</label>
                                <select class="form-control select2" id="lstUser">
                                    <option value="">All Users</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->UserID}}">{{$user->Name}} ( {{$user->MobileNumber}} )</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group text-center mh-60">
                                <label class="mb-6">Priority</label>
                                <select class="form-control" id="lstFPriority">
                                    <option value="">All</option>
                                    <option value="High">High</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Low">Low</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group text-center mh-60">
                                <label class="mb-6">Status</label>
                                <select class="form-control" id="lstStatus">
                                    <option value="">All</option>
                                    <option value="New">New</option>
                                    <option value="Opened">Opened</option>
                                    <option value="Closed">Closed</option>
                                    <option value="deleted">Deleted</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row SupportTicket" style="margin-bottom:80px;">
                        <div class="col-sm-12">
                            <table class="table" id="tblrequests">
                                <thead>
                                    <tr>
                                        <th>Ticket From</th>
                                        <th>User Name</th>
                                        <th>Subjects</th>
                                        <th>Type</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Creation Date</th>
                                        <th></th>
                                        <th class="text-center d-none"></th>
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
    <button class="display-none" id="btnReload"></button>
</div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            let Table=null;
            let TicketFor = "Vendor";
            const init_DataTable=async()=>{
                if(Table!=null){
                    Table.fnDestroy();
                }
                let data={
                    FromDate:$('#dtpFromDate').val(),
                    ToDate:$('#dtpToDate').val(),
                    User:$('#lstUser').val(),
                    Priority:$('#lstFPriority').val(),
                    TicketFor:$('#lstFTicketFor').val(),
                    Status:$('#lstStatus').val()
                }
                Table=$('#tblrequests').dataTable({
                    "bProcessing": true,
                    deferRender: true,
				    responsive: true,
                    dom: 'Bfrtip',
                    "searching": true,
                    "info": false,
                    "order": [[ 0, "desc" ]],
                    "iDisplayLength": 10,
                    "lengthMenu": [[20,  50,100,250], [10, 25, 50,100,250]],
                    "bServerSide": true,
                    createdRow: function (row, data, index) {
                        // console.log(data);
                        $(row).addClass('btnDetails');
                        $(row).attr('id',data[8]);
                        $(row).find('td:eq(8)').addClass('d-none');
                        /*let t2=$(row).children()[0];
                        let t=data[0].split('-');
                        t2.innerHTML="#"+t[1].replace(/^0+/, '');*/
                    },
                    "ajax": {"url":"{{url('/')}}/admin/support/data?_token="+$('meta[name=_token]').attr('content'),"headers":{ 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },data:data ,"type": "POST"},
                    buttons: [], 
                });
            }
            $('#btnReload').click(function(){
                $('#tblrequests').DataTable().ajax.reload();
            });
            $('#lstStatus').change(function(){
                init_DataTable();
            });
            $('#lstUser').change(function(){
                init_DataTable();
            });
            $('#lstFPriority').change(function(){
                init_DataTable();
            });
            $('#lstFTicketFor').change(function(){
                init_DataTable();
            });
            $('#dtpFromDate').change(function(){
                init_DataTable();
            });
            $('#dtpToDate').change(function(){
                init_DataTable();
            });
            $(document).on('click','.btnDetails',function(e){
                var CID=$(this).attr('id');
                let t=$(e.target);
                if((t.hasClass('SupportTicketReopen')==false)&&(t.hasClass('SupportTicketDelete')==false)&&(t.hasClass('SupportTicketClose')==false)){
                    window.location.replace("{{url('/')}}/admin/support/details/"+CID);
                }
            });
            $(document).on('click','.SupportTicketReopen',function(){
                var CID=$(this).attr('data-id');
                $.ajax({
                    type:"post",
                    url:"{{url('/')}}/admin/support/activate/"+CID,
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success:function(response){
                        $('#tblrequests').DataTable().ajax.reload();
                    }
                });
            });
            $(document).on('click','.SupportTicketClose',function(){
                var CID=$(this).attr('data-id');
                $.ajax({
                    type:"post",
                    url:"{{url('/')}}/admin/support/deactivate/"+CID,
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success:function(response){
                        $('#tblrequests').DataTable().ajax.reload();
                    }
                });
            });
            $(document).on('click','.SupportTicketDelete',function(){
                var CID=$(this).attr('data-id');
                swal({
                    title: "Are you sure?",
                    text: "You want Delete this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                },
                function(){
                    $.ajax({
                        type:"post",
                        url:"{{url('/')}}/admin/support/delete/"+CID,
                        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                        success:function(response){
                            $('#tblrequests').DataTable().ajax.reload();
                            swal.close();
                        }
                    });
                });
            });
            $('#btnNewTicket').click(function(e){
                e.preventDefault();
                $.ajax({
                    type:"post",
                    url:"{{url('/')}}/admin/support/new-ticket",
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    success:function(response){
                        if(response!=""){
                            bootbox.dialog({
                                title: 'Support',
                                size:'large',
                                closeButton: true,
                                message: response,
                                buttons: {
                                }
                            });
                        }
                    }
                })
            });
            
            $(document).on('change','#lstTicketFor',function(){
                TicketFor = $(this).val();
                if(TicketFor == 'Vendor'){
                    $('#divCustomer').addClass('d-none');
                    $('#divVendor').removeClass('d-none');
                }else{
                    $('#divVendor').addClass('d-none');
                    $('#divCustomer').removeClass('d-none');
                }
            });
            
            init_DataTable();
        });
    </script>
@endsection