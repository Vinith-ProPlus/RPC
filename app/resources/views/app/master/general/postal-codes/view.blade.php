@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">General Master</li>
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
								<a href="{{url('/')}}/admin/master/general/postal-codes/trash" class="btn  btn-outline-dark {{$Theme['button-size']}} m-r-10" type="button" > Trash </a>
							@endif
							@if($crud['add']==1)
								<a href="{{url('/')}}/admin/master/general/postal-codes/create" class="btn  btn-outline-success btn-air-success {{$Theme['button-size']}}" type="button" >Create</a>
							@endif
						</div>
					</div>
				</div>
				<div class="card-body">
					<div id="order_filter" class="form-row justify-content-center m-20">
						<div class="col-sm-2">
							<div class="form-group text-center mh-60">
								<label style="margin-bottom:0px;">Country</label>
								<div id="divFCountry">
									<select id="lstFCountry" class="form-control multiselect"  >
									</select>
								</div>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group text-center mh-60">
								<label style="margin-bottom:0px;">State</label>
								<div id="divFState">
									<select id="lstFState" class="form-control multiselect"  >
									</select>
								</div>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group text-center mh-60">
								<label style="margin-bottom:0px;">District</label>
								<div id="divFDistrict">
									<select id="lstFDistrict" class="form-control multiselect"  >
									</select>
								</div>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group text-center mh-60">
								<label style="margin-bottom:0px;">Active Status</label><br>
                                <select id="lstFActiveStatus" class="form-control multiselect">
                                    <option value="">All</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12 col-sm-12 col-lg-12">
                            <table class="table {{$Theme['table-size']}}" id="tblPostalCodes">
                                <thead>
                                    <tr>
                                        <th class="text-center">Postal Code ID</th>
                                        <th class="text-center">Postal Code</th>
                                        <th class="text-center">District Name</th>
                                        <th class="text-center">State Name</th>
                                        <th class="text-center">Country Name</th>
                                        <th class="text-center">Active Status</th>
                                        <th class="text-center noExport">Action</th>
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
        var tblPostalCodes=null;

        const appInit=async()=>{
            getCountry();
            makeActiveStatus();
        }

        const makeCountry=async()=>{
            $('#lstFCountry').multiselect({
                buttonClass: 'btn btn-link',
                enableFiltering:true,
                maxHeight:250,
                onChange:async()=>{
                    getFilters();
                    getState();
                }
            });
            getState();
        }

        const makeState=async()=>{
            $('#lstFState').multiselect({
                buttonClass: 'btn btn-link',
                enableFiltering:true,
                maxHeight:250,
                onChange:async()=>{
                    getDistrict();
                }
            });
            getDistrict();
        }

        const makeDistrict=async()=>{
            $('#lstFDistrict').multiselect({
                buttonClass: 'btn btn-link',
                enableFiltering:true,
                maxHeight:250,
                onChange:async()=>{
                    LoadTable();
                }
            });
            LoadTable();
        }

        const makeActiveStatus=async()=>{
            $('#lstFActiveStatus').multiselect({
                buttonClass: 'btn btn-link',
                maxHeight:250,
                onChange:async()=>{
					LoadTable();
                }
            });
        }

        const getCountry=async()=>{
            $('#divFCountry').html('<div id="divFCountryLoader" class="Cloader"></div>');
            await createElem('select','lstFCountry','form-control multiselect',$('#divFCountry'));
            $('#lstFCountry').hide();
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/country",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                async:true,
                success:function(response){
                    for(item of response){
                        let selected="";
                        if(item.CountryID == "{{$Company['CountryID']}}"){selected="selected";}
                        $('#lstFCountry').append('<option '+selected+'  value="'+item.CountryID+'">'+item.CountryName+'</option>');
                    }
                    $('#lstFCountry').show();
                    makeCountry();
                    removeLoader('divFCountryLoader');
                }
            });
        }

        const getState=async()=>{
            $('#divFState').html('<div id="divFStateLoader" class="Cloader"></div>');
            await createElem('select','lstFState','form-control multiselect',$('#divFState'));
            $('#lstFState').hide();
            let filterOptions = {
                CountryID: $('#lstFCountry').val() == null ? "{{$Company['CountryID']}}" : $('#lstFCountry').val(),
            }
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/states",
                data:filterOptions,
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                async:true,
                success:function(response){
                    for(item of response){
                        let selected="";
                        if(item.StateID == "{{$Company['StateID']}}" && item.CountryID == "{{$Company['CountryID']}}"){selected="selected";}
                        $('#lstFState').append('<option '+selected+'  value="'+item.StateID+'">'+item.StateName+'</option>');
                    }
                    $('#lstFState').show();
                    makeState();
                    removeLoader('divFStateLoader');
                }
            });
        }

        const getDistrict=async()=>{
            $('#divFDistrict').html('<div id="divFDistrictLoader" class="Cloader"></div>');
            await createElem('select','lstFDistrict','form-control multiselect',$('#divFDistrict'));
            $('#lstFDistrict').hide();
            let filterOptions = {
                CountryID: $('#lstFCountry').val() == null ? "{{$Company['CountryID']}}" : $('#lstFCountry').val(),
                StateID: $('#lstFState').val() == null ? "{{$Company['StateID']}}" : $('#lstFState').val(),
            }
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/districts",
                data:filterOptions,
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                async:true,
                success:function(response){
                    $('#lstFDistrict').append('<option value="">None Selected</option>');
                    for(item of response){
                        let selected="";
                        $('#lstFDistrict').append('<option '+selected+'  value="'+item.DistrictID+'">'+item.DistrictName+'</option>');
                    }
                    $('#lstFDistrict').show();
                    makeDistrict();
                    removeLoader('divFDistrictLoader');
                }
            });
        }

        const LoadTable=async()=>{
			@if($crud['view']==1)
			if(tblPostalCodes!=null){
				tblPostalCodes.fnDestroy();
			}
			let filterOptions = {
                CountryID: $('#lstFCountry').val() == null ? "{{$Company['CountryID']}}" : $('#lstFCountry').val(),
                StateID: $('#lstFState').val() == null ? "{{$Company['StateID']}}" : $('#lstFState').val(),
                DistrictID: $('#lstFDistrict').val(),
                ActiveStatus: $('#lstFActiveStatus').val(),
            }
			tblPostalCodes=$('#tblPostalCodes').dataTable({
				"bProcessing": true,
				"bServerSide": true,
                "ajax": {"url": "{{url('/')}}/admin/master/general/postal-codes/data?_token="+$('meta[name=_token]').attr('content'),data:filterOptions,"headers":{ 'X-CSRF-Token' : $('meta[name=_token]').attr('content') } ,"type": "POST"},
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
					{"className": "dt-center", "targets":[5,6]},
				]
			});
			@endif
        }

        const createElem=async(elem,id,classList,parent)=>{
            let el=document.createElement(elem);
            parent.append(el);
            el.setAttribute('id',id);
            if(Array.isArray(classList)){
                if(classList.length>0){
                    $('#'+id).addClass(classList.join(" "));
                }
                
            }else{
                if(classList!=""){
                    $('#'+id).addClass(classList);
                }
            }
            return el;
        }

        const removeLoader=async(id)=>{
            $('#'+id).remove();
        }

		$(document).on('click','.btnEdit',function(){
			window.location.replace("{{url('/')}}/admin/master/general/postal-codes/edit/"+ $(this).attr('data-id'));
		});
		
		$(document).on('click','.btnDelete',function(){
			let ID=$(this).attr('data-id');
			swal({
                title: "Are you sure?",
                text: "You want Delete this Postal Code!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-outline-danger",
                confirmButtonText: "Yes, Delete it!",
                closeOnConfirm: false
            },
            function(){swal.close();
            	$.ajax({
            		type:"post",
                    url:"{{url('/')}}/admin/master/general/postal-codes/delete/"+ID,
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    dataType:"json",
                    success:function(response){
                    	swal.close();
                    	if(response.status==true){
                    		$('#tblPostalCodes').DataTable().ajax.reload();
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
		appInit();
    });
</script>
@endsection