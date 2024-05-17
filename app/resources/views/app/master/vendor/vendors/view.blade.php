@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Vendor Master</li>
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
							@if($crud['restore']==1)
								<a href="{{ url('/') }}/admin/master/vendor/manage-vendors/trash" class="btn  btn-outline-dark {{$Theme['button-size']}} mr-10" type="button" > Trash </a>
							@endif
							@if($crud['add']==1)
								<a href="{{ url('/') }}/admin/master/vendor/manage-vendors/create" class="btn  btn-outline-success btn-air-success {{$Theme['button-size']}}" type="button" >Create</a> <!-- full-right -->
							@endif
						</div>
					</div>
				</div>
				<div class="card-body " >
					<div class="row">
						<div class="col-12 col-sm-12 col-lg-12">
							<table class="table {{$Theme['table-size']}}" id="tblVendors">
								<thead>
									<tr>
										<th>Company Name</th>
										<th>Vendor Name</th>
										<th>Mobile Number</th>
										<th>Vendor Type</th>
										<th>District Name</th>
										<th>Created Date</th>
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
			$('#tblVendors').dataTable( {
				"bProcessing": true,
				"bServerSide": true,
                "ajax": {"url":"{{url('/')}}/admin/master/vendor/manage-vendors/data?_token="+$('meta[name=_token]').attr('content'),"headers":{ 'X-CSRF-Token' : $('meta[name=_token]').attr('content') } ,"type": "POST"},
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
					@if($crud['print']==1) ,{extend: 'print',className:"{{$Theme['button-size']}}",footer: true,title:  "{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
					@if($crud['pdf']==1) ,{extend: 'pdf',className:"{{$Theme['button-size']}}",footer: true,title:  "{{$PageTitle}}","action": DataTableExportOption,exportOptions: {columns: "thead th:not(.noExport)"}} @endif
				],
				columnDefs: [
					{"className": "dt-center", "targets": [7,6]},
				]
			});
			@endif
        }
		$(document).on('click','.btnEdit',function(){
			window.location.replace("{{url('/')}}/admin/master/vendor/manage-vendors/edit/"+ $(this).attr('data-id'));
		});
		$(document).on('click','.btnEditServiceLocation',function(){
			window.location.replace("{{url('/')}}/admin/master/vendor/manage-vendors/edit/service-location/"+ $(this).attr('data-id'));
		});
		$(document).on('click','.btnEditProductMap',function(){
			window.location.replace("{{url('/')}}/admin/master/vendor/vendor-product-mapping/edit/"+ $(this).attr('data-id'));
		});
		$(document).on('click', '.btnVendorInfo', function (e) {
            e.preventDefault();
            let VendorName = $(this).attr('data-vendor-name');
            $.ajax({
                type: "post",
                url: "{{url('/')}}/admin/master/vendor/manage-vendors/get/vendor-info",
                data: { VendorID: $(this).attr('data-id') },
                headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
                success: function (response) {
                    let modalContent = $('<div></div>');
                    let row = $('<div class="row my-3 justify-content-center">').html(`
								<div class="row">
									<div class="col-sm-12 text-center">
										<img loading="lazy" src="{{ url('/') }}/${response.Logo}" alt="Vendor Logo" class="img-fluid rounded" height="150" width="150">
									</div>
									<div class="row mt-20 justify-content-center">
										<div class="col-sm-5">
											<div class="row">
												<div class="col-sm-6 fs-15 fw-600">Vendor Name</div>
												<div class="col-sm-1 fs-15 fw-600 text-center">:</div>
												<div class="col-sm-5 fs-15">${response.VendorName}</div>
											</div>
											<div class="row my-2">
												<div class="col-sm-6 fs-15 fw-600">Email</div>
												<div class="col-sm-1 fs-15 fw-600 text-center">:</div>
												<div class="col-sm-5 fs-15">${response.Email}</div>
											</div>
											<div class="row my-2">
												<div class="col-sm-6 fs-15 fw-600">Address</div>
												<div class="col-sm-1 fs-15 fw-600 text-center">:</div>
												<div class="col-sm-5 fs-15">${response.Address}, ${response.CityName}<br>${response.TalukName}, ${response.DistrictName}<br>${response.StateName}-${response.PostalCode}</div>
											</div>
											<div class="row my-2">
												<div class="col-sm-6 fs-15 fw-600">GST No</div>
												<div class="col-sm-1 fs-15 fw-600 text-center">:</div>
												<div class="col-sm-5 fs-15">${response.GSTNo}</div>
											</div>
											<div class="row my-2">
												<div class="col-sm-6 fs-15 fw-600">Mobile No</div>
												<div class="col-sm-1 fs-15 fw-600 text-center">:</div>
												<div class="col-sm-5 fs-15">${response.MobileNumber1}</div>
											</div>
											${response.StockPoints.length > 0 ?
												`<div class="row my-2">
													<div class="col-sm-6 fs-15 fw-600">Primary Stock Point</div>
													<div class="col-sm-1 fs-15 fw-600 text-center">:</div>
													<div class="col-sm-5 fs-15">${response.StockPoints[0].Address}, ${response.StockPoints[0].CityName}<br>${response.StockPoints[0].TalukName}, ${response.StockPoints[0].DistrictName}<br>${response.StockPoints[0].StateName}-${response.StockPoints[0].PostalCode}.<br><span class></span></div>
												</div>` :
												''
											}
										</div>
									</div>
								</div>`);

                        modalContent.append(row);
						let documentsRow = $('<div class="row my-3 justify-content-center">');
							documentsRow.append(`<div class="col-sm-12 my-2"><h5 class="text-center text-info">Vendor Documents</h5></div>`);

						response.Documents.forEach(function (document) {
							let documentElement;
							documentElement = `<a href="${document.documents}" target="_blank"><img loading="lazy" src="${document.DefaultImage}" alt="${document.DisplayName}" class="img-fluid rounded" height="150" width="150"></a>`;
							documentsRow.append(`
								<div class="col-sm-3 text-center">
									<h6>${document.DisplayName}</h6>
									${documentElement}
								</div>
							`);
						});
						modalContent.append("<hr>");
						modalContent.append(documentsRow);

                    let dialog = bootbox.dialog({
                        title: "Vendor ( " + VendorName + " )",
                        closeButton: true,
                        message: modalContent,
                        className: 'modal-xl',
                    });
                    dialog.find('.modal-title').css({ 'margin': '0 auto', 'display': 'inline-block' });
                }
            });
        });
		$(document).on('click','.btnApprove',function(){
			let ID=$(this).attr('data-id');
			swal({
                title: "Are you sure?",
                text: "You want Approve this vendor!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-outline-success",
                confirmButtonText: "Yes, Approve it!",
                closeOnConfirm: false
            },
            function(){swal.close();
            	$.ajax({
            		type:"post",
                    url:"{{url('/')}}/admin/master/vendor/manage-vendors/approve/"+ID,
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    dataType:"json",
                    success:function(response){
                    	swal.close();
                    	if(response.status==true){
                    		$('#tblVendors').DataTable().ajax.reload();
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
		$(document).on('click','.btnDelete',function(){
			let ID=$(this).attr('data-id');
			swal({
                title: "Are you sure?",
                text: "You want Delete this vendor!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-outline-danger",
                confirmButtonText: "Yes, Delete it!",
                closeOnConfirm: false
            },
            function(){swal.close();
            	$.ajax({
            		type:"post",
                    url:"{{url('/')}}/admin/master/vendor/manage-vendors/delete/"+ID,
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    dataType:"json",
                    success:function(response){
                    	swal.close();
                    	if(response.status==true){
                    		$('#tblVendors').DataTable().ajax.reload();
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
