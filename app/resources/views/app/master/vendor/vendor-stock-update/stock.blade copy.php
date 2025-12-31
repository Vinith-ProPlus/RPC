@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}/"><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Vendor Master</li>
					<li class="breadcrumb-item">{{$PageTitle}}</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-12 col-sm-12 col-lg-12">
			<div class="card">
				<div class="card-header text-center"><h5>{{$PageTitle}}</h5></div>
				<div class="card-body">
					<div class="row justify-content-center">
						<div class="col-sm-2">
							<div class="form-group">
								<label for="lstVendor">Vendor Name <span class="required">*</span></label>
								<select  class="form-control select2" id="lstVendor" data-selected="@if($isEdit){{$VendorID}}@endif">
									<option value="">Select a Vendor Name</option>
								</select>
									<span class="errors" id="lstVendor-err"></span>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<label for="lstPCategory">Product Category</label>
								<select  class="form-control select2" id="lstPCategory" data-selected="">
									<option value="">Select a Product Category</option>
								</select>
									<span class="errors" id="lstPCategory-err"></span>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<label for="lstPSubCategory">Product Sub Category</label>
								<select  class="form-control select2" id="lstPSubCategory" data-selected="">
									<option value="">Select a Product Sub Category</option>
								</select>
									<span class="errors" id="lstPSubCategory-err"></span>
							</div>
						</div>
					</div>
					<div class="row mt-50">
						<div class="col-12 col-sm-12">
							<table class="table table-bordered" id="tblVendStockUpdate">
								<thead>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<div class="row">
						<div class="col-sm-12 text-right">
							<button id="btnSave" type="button" class="btn {{$Theme['button-size']}} btn-outline-success btn-air-success">Save</button>
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
		let table = null;
		let VendorStockData ={};

		const init=async()=>{
			getVendors();
		}
		const getVendors=async()=>{
            $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/master/vendor/manage-vendors/get/vendors",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.VendorID==$('#lstVendor').attr('data-selected')){selected="selected";}
                        $('#lstVendor').append('<option '+selected+' data-pcid="'+Item.PCIDs+'" data-pscid="'+Item.PSCIDs+'" value="'+Item.VendorID+'">'+Item.VendorName+' </option>');
                    }
                    if($('#lstVendor').val()!=""){
                        $('#lstVendor').trigger('change');
                    }
                }
            });
        }
		const getVendorStockData = async (vendorID) => {
			let FormData = {VendorID: vendorID};
			let status = false;
			try {
				const response = await $.ajax({
					type: "post",
					url: "{{url('/')}}/admin/master/vendor/vendor-stock-update/get/vendor-stock-data",
					headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
					dataType: "json",
					data: FormData,
					async: true,
				});
				VendorStockData = response;
				status = true;
			} catch (error) {
				ajaxErrors(error);
			}
			return status;
		};
		const LoadStockData = async () => {
			$(".errors").html("");
			let VendorID=$("#lstVendor").val();
			let table = $("#tblVendStockUpdate");
			let tableHead = $("#tblVendStockUpdate thead");
			let tableBody = $("#tblVendStockUpdate tbody");
			if ($.fn.DataTable.isDataTable('#tblVendStockUpdate')) {
				$('#tblVendStockUpdate').DataTable().destroy();
				table.html("");
				table.html(`<thead>
								</thead>
								<tbody>
							</tbody>`);
			}
			tableHead.html("");
			tableBody.html("");
			if(VendorID){
				let status = await getVendorStockData(VendorID);
				if(status){
					let FormData = {
						VendorID: VendorID,
					}
					$.ajax({
						type: "post",
						url: "{{url('/')}}/admin/master/vendor/vendor-stock-update/get/vendor-products",
						headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
						dataType: "json",
						data: FormData,
						async: false,
						error: function (e, x, settings, exception) {
							ajaxErrors(e, x, settings, exception);
						},
						complete: function (e, x, settings, exception) {},
						success: async function (response) {
							let StockPointData = response.StockPointData;
							let ProductData = response.ProductData;

							if (StockPointData.length > 0 && ProductData) {
								let html = `<tr>
												<th class="text-center align-middle" rowspan="2">Products</th>
												<th class="text-center align-middle" rowspan="2">UOM</th>`;

								for (let item of StockPointData) {
									html += `<th class="text-center align-middle" colspan="2" data-spid="${item.StockPointID}">${item.PointName}</th>`;
								}

								html += `</tr>
										<tr>`;

								for (let item of StockPointData) {
									html += `<th class="text-center align-middle">Qty</th>
											<th class="text-center align-middle">Price</th>`;
								}	
								html += `</tr>`;

								tableHead.append(html);

								for (let SubCategory in ProductData) {
									/* const SubCategoryRow = `<tr data-pcid="${ProductData[SubCategory][0].PCID}" data-pscid="${ProductData[SubCategory][0].PSCID}">
																<th colspan="${(StockPointData.length * 2) + 2}" class="text-dark font-weight-bold fs-15">${ProductData[SubCategory][0].PCName} - ${SubCategory}</th>
															</tr>`;
									tableBody.append(SubCategoryRow); */

									for (let item of ProductData[SubCategory]) {
										let newRow = `<tr data-product-id="${item.ProductID}" data-pcid="${item.PCID}" data-pscid="${item.PSCID}">
														<td><span class="pl-15">${item.ProductName}</span></td>
														<td data-uom-id="${item.UID}">${item.UName} (${item.UCode})</td>`;

										for (let row of StockPointData) {
											let matchingData = VendorStockData.find(data =>
												data.ProductID === item.ProductID &&
												data.StockPointID === row.StockPointID
											);

											let qtyValue = matchingData ? matchingData.Qty : 0;
											let priceValue = matchingData ? matchingData.Price : item.VendorPrice;

											newRow += `<td class="align-middle divInput">
															<input class="form-control txtQty" type="number" value="${qtyValue}" data-spid="${row.StockPointID}">
															<span class="errors err-sm txtQty-err"></span>
														</td>
														<td class="align-middle divInput">
															<input class="form-control txtPrice" type="number" value="${priceValue}" data-spid="${row.StockPointID}">
															<span class="errors err-sm txtPrice-err"></span>
														</td>`;
										}

										newRow += `</tr>`;
										tableBody.append(newRow);
									}
								}
								table=$("#tblVendStockUpdate").dataTable({
									paging: false,
									fixedHeader: {
										header: true,
										footer: false
									},
									scrollY: 300,
									scrollX: true,
									scrollCollapse: true,
									fixedColumns: {
										leftColumns: 2
									}
								});
							}

						},
					});
				}
			}else{
				tableBody.html("");
				tableHead.html("");
			}
		}
		const getPCategory=async()=>{
			let PCIDs = $("#lstVendor").find("option:selected").attr("data-pcid") ? $("#lstVendor").find("option:selected").attr("data-pcid").split(",") : [];
            $('#lstPCategory').select2('destroy');
            $('#lstPCategory option').remove();
            $('#lstPCategory').append('<option value="" selected>Select a Product Category</option>');
			if(PCIDs.length > 0){
				$.ajax({
					type:"post",
					url:"{{url('/')}}/admin/master/product/category/get/PCategory",
					headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
					dataType:"json",
					async:true,
					error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
					complete: function(e, x, settings, exception){},
					success:function(response){
						for(let Item of response){
							let selected="";
							if(Item.PCID==$('#lstPCategory').attr('data-selected')){selected="selected";}
							if(PCIDs.indexOf(Item.PCID)!=-1){
								$('#lstPCategory').append('<option '+selected+' value="'+Item.PCID+'">'+Item.PCName+' </option>');
							}
						}
					}
				});
			}
            $('#lstPCategory').select2();
            if($('#lstPCategory').val()!=""){
                $('#lstPCategory').trigger('change');
            }
        }
        const getPSubCategory=async()=>{
			let PSCIDs = $("#lstVendor").find("option:selected").attr("data-pscid") ? $("#lstVendor").find("option:selected").attr("data-pscid").split(",") : [];
            let PCID = $('#lstPCategory').val();
            $('#lstPSubCategory').select2('destroy');
            $('#lstPSubCategory option').remove();
			$('#lstPSubCategory').append('<option value="">Select a Product Sub Category</option>');
			if(PSCIDs.length > 0){
				$.ajax({
					type:"post",
					url:"{{url('/')}}/admin/master/product/sub-category/get/PSubCategory",
					headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
					dataType:"json",
					data : {PCID : PCID},
					async:true,
					error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
					complete: function(e, x, settings, exception){},
					success: function (response) {
						for (let Item of response) {
							let selected="";
							if(Item.PSCID==$('#lstPSubCategory').attr('data-selected')){selected="selected";}
							if(PSCIDs.indexOf(Item.PSCID)!=-1){
								$('#lstPSubCategory').append('<option '+selected+' value="' + Item.PSCID + '">' + Item.PSCName + ' </option>');
							}
						}
					}
				});
			}
            
            $('#lstPSubCategory').select2();
        }
		const ShowHideRows=async()=>{
			$(".errors").html("");
			let PCID = $('#lstPCategory').val();
			let PSCID = $('#lstPSubCategory').val();

			$("#tblVendStockUpdate tbody tr").each(function () {
				(PCID && $(this).attr('data-pcid') !== PCID) || (PSCID && $(this).attr('data-pscid') !== PSCID) ? $(this).addClass('d-none') : $(this).removeClass('d-none');
			});
        }

		const validateGetData=()=>{
			let status = true;
			let StockData=[];
			let VendorID = $("#lstVendor").val();
			if(!VendorID) {
				$("#lstVendor-err").html("Vendor Name is required");status = false;
			}else{
				$(".errors").each(function () {
					if ($(this).html()) {
						let Element = $(this).closest('.divInput').find('input');
						Element.focus();
						status = false;
						return false;
					}
				});
			}
			$("#tblVendStockUpdate tbody tr").each(function () {
				let stockData = {
					ProductID: $(this).attr("data-product-id"),
					UOMID: $(this).find('td:eq(1)').attr("data-uom-id"),
					PCID: $(this).attr("data-pcid"),
					PSCID: $(this).attr("data-pscid"),
				};
				$(this).find(".txtQty").each(function () {
					let stockPointData = {
						StockPointID: $(this).attr("data-spid"),
						Qty: $(this).val(),
						Price: $(this).closest('tr').find(`.txtPrice[data-spid='${$(this).attr("data-spid")}']`).val(),
					};
					if (stockData.ProductID) {
						StockData.push({ ...stockData, ...stockPointData });
					}
				});
			});
			let formData = new FormData();
			formData.append('VendorID', VendorID);
			formData.append('StockData', JSON.stringify(StockData));
			return {formData , status};
		}
		$(document).on('change','#lstPCategory',function(){
            getPSubCategory();
			ShowHideRows();
        });
		$(document).on('change','#lstPSubCategory',function(){
			ShowHideRows();
        });
		$("#lstVendor").change(function () {
			getPCategory();
			LoadStockData();
		});
		$(document).on('input', '.txtQty', function () {
			let errorElement = $(this).closest('.divInput').find('.txtQty-err');
			let inputValue = parseFloat($(this).val());
			if (isNaN(inputValue)) {inputValue = 0;}
			if (inputValue < 0) {errorElement.text("Quantity cannot be less than 0");} else {errorElement.text("");}
			$(this).val(inputValue);
		});
		$(document).on('input', '.txtPrice', function () {
			let errorElement = $(this).closest('.divInput').find('.txtPrice-err');
			let inputValue = parseFloat($(this).val());
			if (isNaN(inputValue)) {inputValue = 0;}
			if ($(this).val() < 0) {errorElement.text("Price cannot be less than 0");} else {errorElement.text("");}
			$(this).val(inputValue);
		});

		$('#btnSave').click(async function(){
			let { formData , status } = await validateGetData();
            if(status){
				var postUrl="{{ url('/') }}/admin/master/vendor/vendor-stock-update/update";
                swal({
                    title: "Are you sure?",
                    text: "You want @if($isEdit==true)Update @else Save @endif this Stock Update!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, @if($isEdit==true)Update @else Save @endif it!",
                    closeOnConfirm: false
                },function(){
                    swal.close();
                    btnLoading($('#btnSave'));

                    $.ajax({
                        type:"post",
                        url:postUrl,
                        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                        data:formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                        complete: function(e, x, settings, exception){btnReset($('#btnSave'));ajaxIndicatorStop();$("html, body").animate({ scrollTop: 0 }, "slow");},
                        success:function(response){
                            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
                            if(response.status==true){
                                swal({
                                    title: "SUCCESS",
                                    text: response.message,
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonClass: "btn-outline-success",
                                    confirmButtonText: "Okay",
                                    closeOnConfirm: false
                                },function(){
                                	window.location.reload();
                                });
                                
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
            }
        });
		init();
	});
</script>
@endsection