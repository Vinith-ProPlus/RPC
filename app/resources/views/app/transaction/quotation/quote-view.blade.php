@extends('layouts.app')
@section('content')
<style>
    .stamp-badge {
    padding: 3px 6px;
    margin: -10px;
    z-index: 1;
}
</style>
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Transaction</li>
					<li class="breadcrumb-item"><a href="{{ url('/') }}/admin/transaction/quotation/" data-original-title="" title="">{{$PageTitle}}</a></li>
                    <li class="breadcrumb-item">Quote View</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row d-flex justify-content-center">
		<div class="col-12 col-sm-12 col-lg-12">
			<div class="card">
				<div class="card-header text-center"><h5 class="mt-10">{{$PageTitle}} ( {{$QData->QNo}} )</h5></div>
				<div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row justify-content-center">
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-header p-6">
                                            <p class="text-center fs-16 fw-500">Contact Info</p>
                                        </div>
                                        <div class="card-body">
                                            @foreach([
                                                'Customer Name' => $QData->ReceiverName,
                                                'Email' => $QData->Email,
                                                'Contact Number' => $QData->ReceiverMobNo ,
                                                'Quote Expiry Date' => date($Settings['date-format'], strtotime($QData->QExpiryDate)),
                                            ] as $label => $value)
                                                <div class="row my-1">
                                                    <div class="col-sm-5 fw-600">{{ $label }}</div>
                                                    <div class="col-sm-1 fw-600 text-center">:</div>
                                                    <div class="col-sm-6">{{ $value }}</div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-header p-6">
                                            <p class="text-center fs-16 fw-500">Billing Address</p>
                                        </div>
                                        <div class="card-body">
                                            <?php 
                                                $Address="";
                                                // if($QData->CustomerName!=""){$Address.="<b>".$QData->CustomerName."</b>";}
                                                if($QData->Address!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$QData->Address;}
                                                if($QData->CityName!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$QData->CityName;}
                                                if($QData->TalukName!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$QData->TalukName;}
                                                if($QData->DistrictName!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$QData->DistrictName;}
                                                if($QData->StateName!=""){if($Address!=""){$Address.=",<br>";}$Address.=$QData->StateName;}
                                                if($QData->CountryName!=""){if($Address!=""){$Address.=", ";}$Address.=$QData->CountryName;}
                                                if($QData->PostalCode!=""){if($Address!=""){$Address.=" - ";}$Address.=$QData->PostalCode;}
                                                if($Address!=""){$Address.=".";}
                                                echo  $Address;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-header p-6">
                                            <p class="text-center fs-16 fw-500">Shipping Address</p>
                                        </div>
                                        <div class="card-body">
                                            <?php 
                                                $DAddress="";
                                                if($QData->DAddress!=""){if($DAddress!=""){$DAddress.=",<br> ";}$DAddress.=$QData->DAddress;}
                                                if($QData->DCityName!=""){if($DAddress!=""){$DAddress.=",<br> ";}$DAddress.=$QData->DCityName;}
                                                if($QData->DTalukName!=""){if($DAddress!=""){$DAddress.=",<br> ";}$DAddress.=$QData->DTalukName;}
                                                if($QData->DDistrictName!=""){if($DAddress!=""){$DAddress.=",<br> ";}$DAddress.=$QData->DDistrictName;}
                                                if($QData->DStateName!=""){if($DAddress!=""){$DAddress.=",<br>";}$DAddress.=$QData->DStateName;}
                                                if($QData->DCountryName!=""){if($DAddress!=""){$DAddress.=", ";}$DAddress.=$QData->DCountryName;}
                                                if($QData->DPostalCode!=""){if($DAddress!=""){$DAddress.=" - ";}$DAddress.=$QData->DPostalCode;}
                                                if($DAddress!=""){$DAddress.=".";}
                                                echo  $DAddress;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="text-center fw-700">Allocated Quotation</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table" id="tblAllocatedQuote">
                                        <thead>
                                            <tr>
                                                <th class="text-center align-middle">S.No</th>
                                                <th class="text-center align-middle">Product Name</th>
                                                <th class="text-center align-middle">Qty</th>
                                                <th class="text-center align-middle">UOM</th>
                                                <th class="text-center align-middle">Price per Unit<br> (₹)</th>
                                                <th class="text-center align-middle">Tax Type</th>
                                                <th class="text-center align-middle">Taxable<br> (₹)</th>
                                                <th class="text-center align-middle">Tax Amount<br> (₹)</th>
                                                <th class="text-center align-middle">CGST %</th>
                                                <th class="text-center align-middle">CGST Amount<br> (₹)</th>
                                                <th class="text-center align-middle">SGST %</th>
                                                <th class="text-center align-middle">SGST Amount<br> (₹)</th>
                                                <th class="text-center align-middle">IGST %</th>
                                                <th class="text-center align-middle">IGST Amount<br> (₹)</th>
                                                <th class="text-center align-middle">Total Amount<br> (₹)</th>
                                                <th class="text-center align-middle">Allocated To</th>
                                                <th class="text-center align-middle">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($FinalQuoteData as $key=>$item)
                                                <tr>
                                                    <td>{{$key + 1}}</td>
                                                    <td>{{$item->ProductName}}</td>
                                                    <td class="text-right">{{$item->Qty}}</td>
                                                    <td>{{$item->UName}} ({{$item->UCode}})</td>
                                                    <td class="text-right">{{!$item->isCancelled ? NumberFormat($item->Price, $Settings['price-decimals']) : '--'}}</td>
                                                    <td>{{!$item->isCancelled ? $item->TaxType : '--'}}</td>
                                                    <td class="text-right">{{!$item->isCancelled ? NumberFormat($item->Taxable, $Settings['price-decimals']) : '--'}}</td>
                                                    <td class="text-right">{{!$item->isCancelled ? NumberFormat($item->TaxAmt, $Settings['price-decimals']) : '--'}}</td>
                                                    <td class="text-right">{{!$item->isCancelled ? NumberFormat($item->CGSTPer, $Settings['percentage-decimals']) : '--'}}</td>
                                                    <td class="text-right">{{!$item->isCancelled ? NumberFormat($item->CGSTAmt, $Settings['price-decimals']) : '--'}}</td>
                                                    <td class="text-right">{{!$item->isCancelled ? NumberFormat($item->SGSTPer, $Settings['percentage-decimals']) : '--'}}</td>
                                                    <td class="text-right">{{!$item->isCancelled ? NumberFormat($item->SGSTAmt, $Settings['price-decimals']) : '--'}}</td>
                                                    <td class="text-right">{{!$item->isCancelled ? NumberFormat($item->IGSTPer, $Settings['percentage-decimals']) : '--'}}</td>
                                                    <td class="text-right">{{!$item->isCancelled ? NumberFormat($item->IGSTAmt, $Settings['price-decimals']) : '--'}}</td>
                                                    <td class="text-right">{{!$item->isCancelled ? NumberFormat($item->TotalAmt, $Settings['price-decimals']) : '--'}}</td>
                                                    <td><span class=" fw-600 text-info text-center">{{$item->VendorName}}</span></td>
                                                    <td class="text-center">
                                                        @if(!$item->isCancelled)
                                                        <button type="button" data-detail-id="{{$item->DetailID}}" data-q-id="{{$FinalQuoteData[0]->QID}}" class="btn btn-outline-danger btnQItemDelete" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                        @else
                                                        <span class=" fw-600 text-danger text-center">Cancelled</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="row justify-content-end">
                                        <div class="col-sm-6">
                                            <div class="row mt-20 fw-600 fs-15 mr-10 justify-content-end">
                                                <div class="col-4">Sub Total</div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divSubTotal">{{NumberFormat($FinalQuoteData[0]->SubTotal,$Settings['price-decimals'])}}</div>
                                            </div>
                                            <div class="row mt-10 fw-600 fs-15 mr-10 justify-content-end">
                                                <div class="col-4">CGST</div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divCGSTAmount">{{NumberFormat($FinalQuoteData[0]->CGSTAmount,$Settings['price-decimals'])}}</div>
                                            </div>
                                            <div class="row mt-10 fw-600 fs-15 mr-10 justify-content-end">
                                                <div class="col-4">SGST</div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divSGSTAmount">{{NumberFormat($FinalQuoteData[0]->SGSTAmount,$Settings['price-decimals'])}}</div>
                                            </div>
                                            <div class="row mt-10 fw-600 fs-15 mr-10 justify-content-end">
                                                <div class="col-4">IGST</div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divIGSTAmount">{{NumberFormat($FinalQuoteData[0]->IGSTAmount,$Settings['price-decimals'])}}</div>
                                            </div>
                                            <div class="row mt-10 fw-600 fs-16 mr-10 justify-content-end text-success">
                                                <div class="col-4">Total Amount</div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divTotalAmount">{{NumberFormat($FinalQuoteData[0]->TotalAmount,$Settings['price-decimals'])}}</div>
                                            </div>
                                            <div class="row mt-10 fw-600 fs-15 mr-10 justify-content-end">
                                                <div class="col-4">Additional Amount</div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divAdditionalAmount">{{NumberFormat($FinalQuoteData[0]->AdditionalCost,$Settings['price-decimals'])}}</div>
                                            </div>
                                            <div class="row mt-10 fw-800 fs-17 mr-10 justify-content-end text-success">
                                                <div class="col-4">Overall Amount</div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divOverAllAmount">{{NumberFormat($FinalQuoteData[0]->OverAllAmount,$Settings['price-decimals'])}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            @if($crud['view']==true)
                            <a href="{{url('/')}}/admin/admin/transaction/quote-enquiry" class="btn {{$Theme['button-size']}} btn-outline-dark mr-10" id="btnCancel">Back</a>
                            @endif
                            
                            <button class="btn {{$Theme['button-size']}} btn-outline-primary" id="btnOrderConvert">Convert to Order</button>
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

        const camelCaseToWords=(text)=> {
            return text.replace(/([a-z])([A-Z])/g, '$1 $2');
        }
        const generateStarRating = (rating) => {
            const maxStars = 5;
            const filledStars = Math.floor(rating);
            let starsHtml = '';

            let contextualClass = 'text-primary';

            if (rating < 3) {
                contextualClass = 'text-danger';
            } else if (rating < 4) {
                contextualClass = 'text-warning';
            } else if (rating < 5) {
                contextualClass = 'text-success';
            }

            for (let i = 0; i < filledStars; i++) {
                starsHtml += `<i class="fa fa-star filled-star ${contextualClass}"></i>`;
            }

            return starsHtml;
        };
        /* const generateStarRating = (rating) => {
            const maxStars = 5;
            const filledStars = Math.floor(rating);
            const remainder = rating % 1;
            const emptyStars = maxStars - filledStars - (remainder > 0 ? 1 : 0);
            let starsHtml = '';

            for (let i = 0; i < maxStars; i++) {
                starsHtml += '<i class="far fa-star"></i>';
            }

            for (let i = 0; i < filledStars; i++) {
                starsHtml = starsHtml.replace('<i class="far fa-star"></i>', '<i class="fas fa-star filled-star"></i>');
            }

            if (remainder > 0) {
                starsHtml = starsHtml.replace('<i class="far fa-star"></i>', '<i class="fas fa-star-half-alt filled-star"></i>');
            }

            return starsHtml;
        }; */
        /* $("#tblVendorQuote").DataTable({
            searching: false,
            lengthChange: false,
            paging: false
        }); */
        
        /* $(document).on('click', '.btnQuoteView', function (e) {
            e.preventDefault();
            let QNo = $(this).closest('tr').find('td:eq(0)').html();
            let VendorName = $(this).closest('tr').find('td:eq(1)').html();
            let AllocateButton = $(this).closest('tr').find('.btnQuoteConvert').clone();
            $.ajax({
                type: "post",
                url: "{{url('/')}}/admin/transaction/quotation/get/vendor-quote-details",
                data: { QuoteSentID: $(this).attr('data-id'), VendorID: $(this).attr('data-vendor-id') },
                headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
                success: function (response) {
                    let modalContent = $('<div>').append(response);

                    let table = $('<table class="table">');
                    let thead = $('<thead>').html(`<tr>
                                                        <th class="text-center align-middle">S.No</th>
                                                        <th class="text-center align-middle">Product Name</th>
                                                        <th class="text-center align-middle">Qty</th>
                                                        <th class="text-center align-middle">UOM</th>
                                                        <th class="text-center align-middle">Price per Unit<br> (₹)</th>
                                                        <th class="text-center align-middle">Tax Type</th>
                                                        <th class="text-center align-middle">Taxable<br> (₹)</th>
                                                        <th class="text-center align-middle">Tax Amount<br> (₹)</th>
                                                        <th class="text-center align-middle">CGST %</th>
                                                        <th class="text-center align-middle">CGST Amount<br> (₹)</th>
                                                        <th class="text-center align-middle">SGST %</th>
                                                        <th class="text-center align-middle">SGST Amount<br> (₹)</th>
                                                        <th class="text-center align-middle">Total Amount<br> (₹)</th>
                                                    </tr>`);
                    let tbody = $('<tbody>');

                    response.forEach(function (item, index) {
                    let row = $('<tr>').html(
                        `<td>${index + 1}</td>
                        <td>${item.ProductName}</td>
                        <td class="text-right">${item.Qty}</td>
                        <td>${item.UName} (${item.UCode})</td>
                        <td class="text-right">${Number(item.Price).toFixed({{$Settings['price-decimals']}})}</td>
                        <td>${item.TaxType}</td>
                        <td class="text-right">${Number(item.Taxable).toFixed({{$Settings['price-decimals']}})}</td>
                        <td class="text-right">${Number(item.TaxAmount).toFixed({{$Settings['price-decimals']}})}</td>
                        <td class="text-right">${Number(item.CGSTPer).toFixed({{$Settings['price-decimals']}})}</td>
                        <td class="text-right">${Number(item.CGSTAmount).toFixed({{$Settings['price-decimals']}})}</td>
                        <td class="text-right">${Number(item.SGSTPer).toFixed({{$Settings['price-decimals']}})}</td>
                        <td class="text-right">${Number(item.SGSTAmount).toFixed({{$Settings['price-decimals']}})}</td>
                        <td class="text-right">${Number(item.Amount).toFixed({{$Settings['price-decimals']}})}</td>`
                    );
                    tbody.append(row);
                    });

                    let totalPrice = response.reduce((total, item) => total + item.Amount, 0);
                    let totalTaxable = response.reduce((total, item) => total + item.Taxable, 0);
                    let totalCGST = response.reduce((total, item) => total + item.CGSTAmount, 0);
                    let totalSGST = response.reduce((total, item) => total + item.SGSTAmount, 0);
                    let totalIGST = 0;

                    let tfoot = $('<div>').html(`
                        <div class="row justify-content-end">
                            <div class="col-sm-6">
                                <div class="row mt-20 fw-600 fs-15 mr-10 justify-content-end">
                                    <div class="col-4">Sub Total</div>
                                    <div class="col-1">:</div>
                                    <div class="col-3 text-right" id="divSubTotal">${totalTaxable.toFixed({{$Settings['price-decimals']}})}</div>
                                </div>
                                <div class="row mt-10 fw-600 fs-15 mr-10 justify-content-end">
                                    <div class="col-4">CGST</div>
                                    <div class="col-1">:</div>
                                    <div class="col-3 text-right" id="divCGSTAmount">${totalCGST.toFixed({{$Settings['price-decimals']}})}</div>
                                </div>
                                <div class="row mt-10 fw-600 fs-15 mr-10 justify-content-end">
                                    <div class="col-4">SGST</div>
                                    <div class="col-1">:</div>
                                    <div class="col-3 text-right" id="divSGSTAmount">${totalSGST.toFixed({{$Settings['price-decimals']}})}</div>
                                </div>
                                <div class="row mt-10 fw-600 fs-15 mr-10 justify-content-end">
                                    <div class="col-4">IGST</div>
                                    <div class="col-1">:</div>
                                    <div class="col-3 text-right" id="divIGSTAmount">${totalIGST.toFixed({{$Settings['price-decimals']}})}</div>
                                </div>
                                <div class="row mt-10 fw-600 fs-16 mr-10 justify-content-end text-success">
                                    <div class="col-4">Total Amount</div>
                                    <div class="col-1">:</div>
                                    <div class="col-3 text-right" id="divTotalAmount">${totalPrice.toFixed({{$Settings['price-decimals']}})}</div>
                                </div>
                            </div>
                        </div>`);

                    modalContent.append(table.append(thead).append(tbody)).append(tfoot);
                    let modalFooter = $('<div class="modal-footer">').html(AllocateButton);

                    let dialog = bootbox.dialog({
                        title: 'Quotation Details ( ' + VendorName + ' - ' + QNo + ' )',
                        closeButton: true,
                        message: modalContent,
                        className: 'modal-xl',
                    });
                    $(".modal-xl").css("max-width", "90% !important");
                    dialog.find('.modal-content').append(modalFooter);

                    modalFooter.on('click', 'button', function () {
                        dialog.modal('hide');
                    });
                }
            });
        }); */
        $(document).on('click', '#btnQuoteConvert', function (e) {
            let status = false;
            $('#tblVendorQuote tbody tr').each(function () {
                if ($(this).find('.chkAmount:checked').length == 0) {
                    status = false;toastr.error("Select All Product Prices!", "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
                    return false;
                } else {
                    status = true;
                }
            });

            if(status){
                let FinalQuote = [];
                $('#tblVendorQuote tbody tr').each(function () {
                    let  PData = {
                        ProductID : $(this).attr('data-product-id'),
                        Qty : $(this).attr('data-qty'),
                        VendorID : $(this).find('.chkAmount:checked').val(),
                        FinalPrice : $(this).find('.chkAmount:checked').closest('.divPriceInput').find('.txtFinalPrice').val(),
                        VQuoteID : $(this).find('.chkAmount:checked').attr('data-vendor-quote-id'),
                        DetailID : $(this).find('.chkAmount:checked').attr('data-quote-detail-id'),
                    }
                    FinalQuote.push(PData);
                });
                AdditionalCost = [];
                $('.txtAdditionalCost:not(:disabled)').each(function () {
                    AdditionalCost.push({
                        VendorID: $(this).data('vendor-id'),
                        ACost: $(this).val()
                    });
                });


                console.log(FinalQuote);
                let formData = new FormData();
                formData.append('AdditionalCost', JSON.stringify(AdditionalCost));
                formData.append('FinalQuote', JSON.stringify(FinalQuote));
                swal({
                    title: "Are you sure?",
                    text: "You want to Convert Quotation",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, Convert it!",
                    closeOnConfirm: false
                },function(){
                    swal.close();
                    btnLoading($('#btnQuoteConvert'));
                    let postUrl="{{ url('/') }}/admin/transaction/quotation/quote-convert/{{$QData->QID}}";
                    $.ajax({
                        type:"post",
                        url:postUrl,
                        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                        data:formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                        complete: function(e, x, settings, exception){btnReset($('#btnQuoteConvert'));ajaxIndicatorStop();$("html, body").animate({ scrollTop: 0 }, "slow");},
                        success:function(response){
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
                                    window.location.replace("{{url('/')}}/admin/transaction/quote-enquiry");
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

        const validateGetData=()=>{
			let status = true;
            let SelectedVendors = [];
            $('.chkVendors').each(function () {
                if ($(this).is(':checked')) {
                    status1 = true;
                    SelectedVendors.push($(this).attr('id'));
                }
            });
            if(SelectedVendors.length == 0) {
                status = false;
                toastr.error("Please select a Vendor!", "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
            }
            $(".errors").each(function () {
                if ($(this).html()) {
                    let Element = $(this).closest('.divInput').find('input');
                    Element.focus();
                    status = false;
                    return false;
                }
            });
			let ProductDetails=[];
			$("#tblProductDetails tbody tr").each(function () {
				let PData = {
					ProductID: $(this).attr("data-product-id"),
					UOMID: $(this).find('td:eq(2)').attr("data-uom-id"),
					Qty: $(this).find('td:eq(2)').attr("data-qty"),
					PCID: $(this).attr("data-pcid"),
					PSCID: $(this).attr("data-pscid"),
					// Qty: $(this).find(".txtQty").val(),
					// Qty: $(this).find('td:eq(2)').html(),
				};
                ProductDetails.push(PData);
			});
			let formData = new FormData();
			formData.append('SelectedVendors', JSON.stringify(SelectedVendors));
			formData.append('ProductDetails', JSON.stringify(ProductDetails));
			return {formData , status};
		}
        $(document).on('input', '.txtQty', function () {
			let errorElement = $(this).closest('.divInput').find('.txtQty-err');
			let inputValue = parseFloat($(this).val());
			if (isNaN(inputValue)) {inputValue = 0;}
			if (inputValue < 0) {errorElement.text("Quantity cannot be less than 0");} else {errorElement.text("");}
			$(this).val(inputValue);
		});
        $(document).on('blur', '.txtFinalPrice', function () {
            let errorElement = $(this).closest('.divPriceInput').find('.errors');
			let DefaultPrice = $(this).data('price');
			let inputValue = parseFloat($(this).val());
			if (inputValue < DefaultPrice) {errorElement.text("Price cannot be less than Vendor Price");$(this).val(DefaultPrice);} else {errorElement.text("");}
		});

        const LoadAdditionalCost = () => {
            $('.txtAdditionalCost').each(function () {
                let vendorId = $(this).data('vendor-id');
                let VendorCount=$('.chkAmount:checked[data-vendor-id="' + vendorId + '"]').length;
                if (VendorCount > 0) {
                    $(this).prop('disabled', false);
                } else {
                    $(this).prop('disabled', true);
                }
                $('.SelectedItemCount[data-vendor-id="' + vendorId + '"]').text('Items(' + VendorCount + ')');
            });
        };


        $(document).on('click', '.btnQItemDelete', function () {
            let formData = new FormData();
            formData.append('DetailID',$(this).data('detail-id'));
            formData.append('QID',$(this).data('q-id'));

            swal({
                title: "Are you sure?",
                text: "You want to Delete this Quote Item!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-outline-success",
                confirmButtonText: "Yes, Delete it!",
                closeOnConfirm: false
            },function(){
                swal.close();
                let postUrl="{{ url('/') }}/admin/transaction/quotation/delete-quote-item";
                $.ajax({
                    type:"post",
                    url:postUrl,
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    data:formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                    complete: function(e, x, settings, exception){ajaxIndicatorStop();$("html, body").animate({ scrollTop: 0 }, "slow");},
                    success:function(response){
                        document.documentElement.scrollTop = 0;
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
                                window.location.replace("{{url('/')}}/admin/transaction/quotation/view/{{$QData->QID}}");
                            });
                            
                        }else{
                            toastr.error(response.message, "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
                        }
                    }
                });
            });
        });
        $('#btnRequestQuote').click(async function(){
            let { formData , status } = await validateGetData();
            if(status){
                swal({
                    title: "Are you sure?",
                    text: "You want to Send Quote Request!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, Send it!",
                    closeOnConfirm: false
                },function(){
                    swal.close();
                    btnLoading($('#btnRequestQuote'));
                    let postUrl="{{ url('/') }}/admin/transaction/quotation/request-quote/{{$QData->QID}}";
                    $.ajax({
                        type:"post",
                        url:postUrl,
                        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                        data:formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        xhr: function() {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function(evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = (evt.loaded / evt.total) * 100;
                                    percentComplete=parseFloat(percentComplete).toFixed(2);
                                    $('#divProcessText').html(percentComplete+'% Completed.<br> Please wait for until upload process complete.');
                                    //Do something with upload progress here
                                }
                            }, false);
                            return xhr;
                        },
                        beforeSend: function() {
                            ajaxIndicatorStart("Please wait Upload Process on going.");

                            var percentVal = '0%';
                            setTimeout(() => {
                            $('#divProcessText').html(percentVal+' Completed.<br> Please wait for until upload process complete.');
                            }, 100);
                        },
                        error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                        complete: function(e, x, settings, exception){btnReset($('#btnRequestQuote'));ajaxIndicatorStop();$("html, body").animate({ scrollTop: 0 }, "slow");},
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
                                    window.location.replace("{{url('/')}}/admin/transaction/quote-enquiry");
                                });
                                
                            }else{
                                toastr.error(response.message, "Failed", {
                                    positionClass: "toast-top-right",
                                    containerId: "toast-top-right",
                                    showMethod: "slideDown",
                                    hideMethod: "slideUp",
                                    progressBar: !0
                                })
                                if(response['errors']!=undefined){
                                    $('.errors').html('');
                                    $.each( response['errors'], function( KeyName, KeyValue ) {
                                        var key=KeyName;
                                        if(key=="TaxName"){$('#txtTaxName-err').html(KeyValue);}
                                        if(key=="Percentage"){$('#txtPercentage-err').html(KeyValue);}
                          
                                    });
                                }
                            }
                        }
                    });
                });
            }
        });
    });
</script>
@endsection