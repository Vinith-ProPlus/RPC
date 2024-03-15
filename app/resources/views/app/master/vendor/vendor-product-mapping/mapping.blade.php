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
		<div class="col-12 col-sm-12 col-lg-10">
			<div class="card">
				<div class="card-header text-center"><h5>{{$PageTitle}}</h5></div>
				<div class="card-body">
					<div class="row justify-content-center">
						<div class="col-sm-2">
							<div class="form-group">
								<label for="lstVendor">Vendor Name<span class="required">*</span></label>
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
							<table class="table  table-bordered" id="tblVendProdMapping">
								<thead>
									<tr>
										<th class="text-center align-middle">Products</th>
										<th class="text-center align-middle">Availablity</th>
										<th class="text-center align-middle">Price</th>
									</tr>
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
		
		let VendorProductData ={};
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
		const getVendorProducts = async () => {
			let FormData = {
				VendorID: $("#lstVendor").val(),
			};

			let status = false;

			try {
				const response = await $.ajax({
					type: "post",
					url: "{{url('/')}}/admin/master/vendor/vendor-product-mapping/get/vendor-products",
					headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
					dataType: "json",
					data: FormData,
					async: true,
				});

				VendorProductData = response;
				status = true;
			} catch (error) {
				ajaxErrors(error);
			}
			return status;
		};
		const LoadProductData = async () => {
			$(".errors").html("");
			let VendorID=$("#lstVendor").val();
			let status = await getVendorProducts();
			if(status){
				const tableBody = $("#tblVendProdMapping tbody");
				if(VendorID){
					let FormData = {
						PCID:$("#lstVendor").find("option:selected").attr("data-pcid").split(","),
						PSCID:$("#lstVendor").find("option:selected").attr("data-pscid").split(","),
					}
					$.ajax({
						type: "post",
						url: "{{url('/')}}/admin/master/vendor/vendor-product-mapping/get/product-data",
						headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
						dataType: "json",
						data: FormData,
						async: false,
						error: function (e, x, settings, exception) {
							ajaxErrors(e, x, settings, exception);
						},
						complete: function (e, x, settings, exception) {},
						success: async function (response) {
							tableBody.html("");
							for (let SubCategory in response) {
								const SubCategoryRow = `<tr data-pcid="${response[SubCategory][0].PCID}" data-pscid="${response[SubCategory][0].PSCID}"><th colspan="3" class="text-dark font-weight-bold fs-15">${response[SubCategory][0].PCName} - ${SubCategory}</th></tr>`;
								tableBody.append(SubCategoryRow);
	
								for (let item of response[SubCategory]) {
									let newRow = `<tr data-product-id="${item.ProductID}" data-pcid="${item.PCID}" data-pscid="${item.PSCID}">
													<td><span class="pl-15">${item.ProductName}</span></td>
													<td class="align-middle">
														<div class="flex-grow-1 text-center icon-state switch-outline pt-10">
															<label class="switch">
																<input class="chkAvailable" type="checkbox"><span class="switch-state bg-secondary"></span>
															</label>
														</div>
													</td>
													<td>
														<div class="row justify-content-center">
															<div class="col-sm-4">
																<input class="form-control txtPrice" type="number" value="${item.PRate}" disabled>
																<span class="errors txtPrice-err"></span>
															</div>
														</div>
													</td>
												</tr>`;
									tableBody.append(newRow);
									if(VendorProductData.length > 0) {
										const matchingProduct = VendorProductData.find(product => product.ProductID === item.ProductID && product.VendorID === VendorID);
										if (matchingProduct) {
											const checkbox = tableBody.find(`[data-product-id="${item.ProductID}"] .chkAvailable`);
											const priceInput = tableBody.find(`[data-product-id="${item.ProductID}"] .txtPrice`);
		
											checkbox.prop('checked', true);
											priceInput.val(matchingProduct.VendorPrice).prop('disabled', false);
										}
									}
								}
							}
						},
	
					});
				}else{
					tableBody.html("");
				}
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

			$("#tblVendProdMapping tbody tr").each(function () {
				if ((PCID && $(this).attr('data-pcid') !== PCID) || (PSCID && $(this).attr('data-pscid') !== PSCID)) {
					$(this).addClass('d-none');
				} else {
					$(this).removeClass('d-none');
				}
			});
        }

		const validateGetData=()=>{
			$(".errors").html("");
			let status = true;
			let productData=[];
			let nothingSelected = true;
			let VendorID = $("#lstVendor").val();
			if(!VendorID) {
				$("#lstVendor-err").html("Vendor Name is required");status = false;
			}
			$("#tblVendProdMapping tbody tr").each(function () {
				let isChecked = $(this).find(".chkAvailable").prop("checked");
				let Price = $(this).find(".txtPrice").val();
				if(isChecked){
					nothingSelected = false;
					if(!Price){
						$(this).find(".txtPrice-err").html("Price is required");status = false;
						return false;
					}else{
						let PData = {
							ProductID : $(this).attr("data-product-id"),
							PCID : $(this).attr("data-pcid"),
							PSCID : $(this).attr("data-pscid"),
							VendorPrice : $(this).find(".txtPrice").val(),
						}
						productData.push(PData);
					}
				}
			});
			if(VendorID && nothingSelected){
				toastr.error("Select a Product", "Failed", {
					positionClass: "toast-top-right",
					containerId: "toast-top-right",
					showMethod: "slideDown",
					hideMethod: "slideUp",
					progressBar: !0
				});
				status = false;
			}
			if(status==false){$("html, body").animate({ scrollTop: 0 }, "slow");}
			let formData = new FormData();
			formData.append('VendorID', VendorID);
			formData.append('ProductData', JSON.stringify(productData));
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
			LoadProductData();
		});
		$(document).on('change', '.chkAvailable', function() {
			const priceInput = $(this).closest('tr').find('.txtPrice');
			priceInput.prop('disabled', !this.checked);
		});
		$('#btnSave').click(async function(){
			let { formData , status } = await validateGetData();
            if(status){
				var postUrl="{{ url('/') }}/admin/master/vendor/vendor-product-mapping/update";
                swal({
                    title: "Are you sure?",
                    text: "You want @if($isEdit==true)Update @else Save @endif this Products!",
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