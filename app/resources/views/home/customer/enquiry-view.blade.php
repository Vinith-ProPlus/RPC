@extends('home.home-layout')
@section('content')
    <style>
        .stamp-badge {
            padding: 3px 6px;
            margin: -10px;
            z-index: 1;
        }

        td {
            text-align: center;
        }

        .checkout-progress-bar {
            margin: 2.7rem 0 -2.9rem;
            font-size: 0;
            line-height: 1.4;
        }

        .checkout-progress-bar li a {
            color: #0f43b0 !important;
        }

        .download-table-container .btn,
        .order-detail-container .btn,
        .order-table-container .btn {
            padding:8px 12px;
            font-size:14px;
            font-weight:400
        }
        .order-table-container .btn-dark {
            min-width:200px;
            padding:16px 0 15px;
            font-size:15px;
            letter-spacing:-0.015em;
            text-align:center;
            font-family:"Open Sans",sans-serif;
            font-weight:700
        }
        .table.table-striped {
            margin-top:2rem;
            margin-bottom:5.9rem
        }
        .table.table-striped td,
        .table.table-striped th {
            padding:1.1rem 1.2rem
        }
        .table.table-striped tr:nth-child(odd) {
            background-color:#f9f9f9
        }

        .table.table-size tbody tr td,
        .table.table-size thead tr th {
            border:0;
            color:#21293c;
            font-size:1.4rem;
            letter-spacing:0.005em;
            text-transform:uppercase
        }
        .table.table-size thead tr th {
            padding:2.8rem 1.5rem 1.7rem;
            background-color:#f4f4f2;
            font-weight:600
        }
        .table.table-size tbody tr td {
            padding:1.1rem 1.5rem;
            background-color:#fff;
            font-weight:700
        }
        .table.table-size tbody tr:nth-child(2n) td {
            background-color:#ebebeb
        }
        @media (min-width:992px) {
            .product-both-info .row .col-lg-12 {
                margin-bottom:4px
            }
            .main-content .col-lg-7 {
                -ms-flex:0 0 54%;
                flex:0 0 54%;
                max-width:54%
            }
            .main-content .col-lg-5 {
                -ms-flex:0 0 46%;
                flex:0 0 46%;
                max-width:46%
            }
            .product-full-width {
                padding-right:3.5rem
            }
            .product-full-width .product-single-details .product-title {
                font-size:4rem
            }
            .table.table-size thead tr th {
                padding-top:2.9rem;
                padding-bottom:2.9rem
            }
            .table.table-size tbody tr td,
            .table.table-size thead tr th {
                padding-right:4.2rem;
                padding-left:3rem
            }
        }
        @media (max-width:767px) {
            .product-size-content .table.table-size {
                margin-top:3rem
            }
        }

        .table.table-downloads,
        .table.table-order {
            margin-bottom:1px;
            font-size:14px
        }
        .table.table-downloads thead th,
        .table.table-order thead th {
            border-top:none;
            border-bottom-width:1px;
            padding:1.3rem 1rem;
            font-weight:700;
            color:#222524
        }
        .table.table-downloads tbody td,
        .table.table-order tbody td {
            vertical-align:middle
        }

        .table.table-order-detail th {
            font-weight:600
        }
        .table.table-order-detail td,
        .table.table-order-detail th {
            padding:1rem;
            font-size:1.4rem;
            line-height:24px
        }
        .table.table-order-detail thead th {
            border:none
        }
        .table.table-order-detail .product-title {
            display:inline;
            color:#08C;
            font-size:1.4rem;
            font-weight:400
        }
        .table.table-order-detail .product-count {
            color:#08C
        }
        @media (max-width:767px) {
            .table.table-order thead {
                display:none
            }
            .table.table-order td {
                display:block;
                border-top:none;
                text-align:center
            }
            .table.table-order .product-thumbnail img {
                display:inline
            }
            .table.table-order tbody tr {
                position:relative;
                display:block;
                padding:10px 0
            }
            .table.table-order tbody tr:not(:first-child) {
                border-top:1px solid #ddd
            }
            .table.table-order .product-remove {
                position:absolute;
                top:12px;
                right:0
            }
        }

        .table.table-cart tr td,
        .table.table-cart tr th,
        .table.table-wishlist tr td,
        .table.table-wishlist tr th {
            vertical-align:middle
        }
        .table.table-cart tr th,
        .table.table-wishlist tr th {
            border:0;
            color:#222529;
            font-weight:700;
            line-height:2.4rem;
            text-transform:uppercase
        }
        .table.table-cart tr td,
        .table.table-wishlist tr td {
            border-top:1px solid #e7e7e7
        }
        .table.table-cart tr td.product-col,
        .table.table-wishlist tr td.product-col {
            padding:2rem 0.8rem 1.8rem 0
        }
        .table.table-cart tr.product-action-row td,
        .table.table-wishlist tr.product-action-row td {
            padding:0 0 2.2rem;
            border:0
        }
        .table.table-cart .product-image-container,
        .table.table-wishlist .product-image-container {
            position:relative;
            width:8rem;
            margin:0
        }
        .table.table-cart .product-title,
        .table.table-wishlist .product-title {
            margin-bottom:0;
            padding:0;
            font-family:"Open Sans",sans-serif;
            font-weight:400;
            line-height:1.75
        }
        .table.table-cart .product-title a,
        .table.table-wishlist .product-title a {
            color:inherit
        }
        .table.table-cart .product-single-qty,
        .table.table-wishlist .product-single-qty {
            margin:0.5rem 4px 0.5rem 1px
        }
        .table.table-cart .product-single-qty .form-control,
        .table.table-wishlist .product-single-qty .form-control {
            height:48px;
            width:44px;
            font-size:1.6rem;
            font-weight:700
        }
        .table.table-cart .subtotal-price,
        .table.table-wishlist .subtotal-price {
            color:#222529;
            font-size:1.6rem;
            font-weight:600
        }
        .table.table-cart .btn-remove,
        .table.table-wishlist .btn-remove {
            right:-10px;
            font-size:1.1rem
        }
        .table.table-cart tfoot td,
        .table.table-wishlist tfoot td {
            padding:2rem 0.8rem 1rem
        }
        .table.table-cart tfoot .btn,
        .table.table-wishlist tfoot .btn {
            padding:1.2rem 2.4rem 1.3rem 2.5rem;
            font-family:"Open Sans",sans-serif;
            font-size:1.3rem;
            font-weight:700;
            height:43px;
            letter-spacing:-0.018em
        }
        .table.table-cart tfoot .btn+.btn,
        .table.table-wishlist tfoot .btn+.btn {
            margin-left:1rem
        }
        .table.table-cart .bootstrap-touchspin.input-group,
        .table.table-wishlist .bootstrap-touchspin.input-group {
            margin-right:auto;
            margin-left:auto
        }
        .table.table-wishlist tr th {
            padding:10px 5px 10px 16px
        }
        .table.table-wishlist tr th.thumbnail-col {
            width:10%
        }
        .table.table-wishlist tr th.product-col {
            width:29%
        }
        .table.table-wishlist tr th.price-col {
            width:13%
        }
        .table.table-wishlist tr th.status-col {
            width:19%
        }
        .table.table-wishlist tr td {
            padding:20px 5px 23px 16px
        }
        .table.table-wishlist .product-price {
            color:inherit;
            font-size:1.4rem;
            font-weight:400
        }
        .table.table-wishlist .price-box {
            margin-bottom:0
        }
        .table.table-wishlist .stock-status {
            color:#222529;
            font-weight:600
        }
    </style>
<div class="container mt-2">
	<div class="row d-flex justify-content-center">
		<div class="col-12 col-sm-12 col-lg-12">
			<div class="card">
                <ul class="checkout-progress-bar d-flex justify-content-center flex-wrap">
                    <li class="active">
                        <a href="#">Quote Enquiry - ( {{$EnqData->EnqNo}} )</a>
                    </li>
                </ul>
				<div class="card-body pb-0">
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
                                                'Receiver Name' => $EnqData->ReceiverName,
                                                'Contact Number' => $EnqData->ReceiverMobNo ,
                                                'Quote Enquiry Date' => date('d-M-Y', strtotime($EnqData->EnqDate)),
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
{{--                                        <div class="card-body">--}}
{{--                                            <?php--}}
{{--                                                $Address="";--}}
{{--                                                if($EnqData->Address!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$EnqData->Address;}--}}
{{--                                                if($EnqData->CityName!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$EnqData->CityName;}--}}
{{--                                                if($EnqData->TalukName!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$EnqData->TalukName;}--}}
{{--                                                if($EnqData->DistrictName!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$EnqData->DistrictName;}--}}
{{--                                                if($EnqData->StateName!=""){if($Address!=""){$Address.=",<br>";}$Address.=$EnqData->StateName;}--}}
{{--                                                if($EnqData->CountryName!=""){if($Address!=""){$Address.=", ";}$Address.=$EnqData->CountryName;}--}}
{{--                                                if($EnqData->PostalCode!=""){if($Address!=""){$Address.=" - ";}$Address.=$EnqData->PostalCode;}--}}
{{--                                                if($Address!=""){$Address.=".";}--}}
{{--                                                echo  $Address;--}}
{{--                                            ?>--}}
{{--                                        </div>--}}

                                        <div class="card-body">
                                            <?php
                                            $Address = "";

                                            if(isset($EnqData->Address) && $EnqData->Address != "") {
                                                $Address .= $EnqData->Address;
                                            }

                                            if(isset($EnqData->CityName) && $EnqData->CityName != "") {
                                                if($Address != "") {
                                                    $Address .= ",<br>";
                                                }
                                                $Address .= $EnqData->CityName;
                                            }

                                            if(isset($EnqData->TalukName) && $EnqData->TalukName != "") {
                                                if($Address != "") {
                                                    $Address .= ",<br>";
                                                }
                                                $Address .= $EnqData->TalukName;
                                            }

                                            if(isset($EnqData->DistrictName) && $EnqData->DistrictName != "") {
                                                if($Address != "") {
                                                    $Address .= ",<br>";
                                                }
                                                $Address .= $EnqData->DistrictName;
                                            }

                                            if(isset($EnqData->StateName) && $EnqData->StateName != "") {
                                                if($Address != "") {
                                                    $Address .= ",<br>";
                                                }
                                                $Address .= $EnqData->StateName;
                                            }

                                            if(isset($EnqData->CountryName) && $EnqData->CountryName != "") {
                                                if($Address != "") {
                                                    $Address .= ", ";
                                                }
                                                $Address .= $EnqData->CountryName;
                                            }

                                            if(isset($EnqData->PostalCode) && $EnqData->PostalCode != "") {
                                                if($Address != "") {
                                                    $Address .= " - ";
                                                }
                                                $Address .= $EnqData->PostalCode;
                                            }

                                            if($Address != "") {
                                                $Address .= ".";
                                            }

                                            echo $Address;
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
                                                if($EnqData->DAddress!=""){if($DAddress!=""){$DAddress.=",<br> ";}$DAddress.=$EnqData->DAddress;}
                                                if($EnqData->DCityName!=""){if($DAddress!=""){$DAddress.=",<br> ";}$DAddress.=$EnqData->DCityName;}
                                                if($EnqData->DTalukName!=""){if($DAddress!=""){$DAddress.=",<br> ";}$DAddress.=$EnqData->DTalukName;}
                                                if($EnqData->DDistrictName!=""){if($DAddress!=""){$DAddress.=",<br> ";}$DAddress.=$EnqData->DDistrictName;}
                                                if($EnqData->DStateName!=""){if($DAddress!=""){$DAddress.=",<br>";}$DAddress.=$EnqData->DStateName;}
                                                if($EnqData->DCountryName!=""){if($DAddress!=""){$DAddress.=", ";}$DAddress.=$EnqData->DCountryName;}
                                                if($EnqData->DPostalCode!=""){if($DAddress!=""){$DAddress.=" - ";}$DAddress.=$EnqData->DPostalCode;}
                                                if($DAddress!=""){$DAddress.=".";}
                                                echo  $DAddress;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (count($FinalQuoteData) == 0)
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="text-center bold fw-700">Product Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-wishlist" id="tblProductDetails">
                                            <thead>
                                                <tr>
                                                    <th class="text-center align-middle">S.No</th>
                                                    <th class="text-center align-middle">Product</th>
                                                    <th class="text-center align-middle">Qty</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($PData as $key=>$row)
                                                    <tr data-product-id="{{$row->ProductID}}" data-pcid="{{$row->CID}}" data-pscid="{{$row->SCID}}">
                                                        <td>{{$key + 1}}</td>
                                                        <td>{{$row->ProductName}}</td>
                                                        <td class="text-center" data-uom-id ="{{$row->UID}}" data-qty="{{$row->Qty}}">{{$row->Qty}}( {{$row->UCode}} )</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-sm-12 text-right">
                    <a href="{{ route('my-account', ['tab'=> 'quotations']) }}"
                       class="btn btn-sm btn-outline-dark mb-1" id="btnCancel">Back</a>
                </div>
            </div>
		</div>
	</div>
</div>

@endsection
@section('scripts')
{{--<script>--}}
{{--    $(document).ready(function(){--}}

{{--        const camelCaseToWords=(text)=> {--}}
{{--            return text.replace(/([a-z])([A-Z])/g, '$1 $2');--}}
{{--        }--}}
{{--        const generateStarRating = (rating) => {--}}
{{--            const maxStars = 5;--}}
{{--            const filledStars = Math.floor(rating);--}}
{{--            let starsHtml = '';--}}

{{--            let contextualClass = 'text-primary';--}}

{{--            if (rating < 3) {--}}
{{--                contextualClass = 'text-danger';--}}
{{--            } else if (rating < 4) {--}}
{{--                contextualClass = 'text-warning';--}}
{{--            } else if (rating < 5) {--}}
{{--                contextualClass = 'text-success';--}}
{{--            }--}}

{{--            for (let i = 0; i < filledStars; i++) {--}}
{{--                starsHtml += `<i class="fa fa-star filled-star ${contextualClass}"></i>`;--}}
{{--            }--}}

{{--            return starsHtml;--}}
{{--        };--}}
{{--        /* const generateStarRating = (rating) => {--}}
{{--            const maxStars = 5;--}}
{{--            const filledStars = Math.floor(rating);--}}
{{--            const remainder = rating % 1;--}}
{{--            const emptyStars = maxStars - filledStars - (remainder > 0 ? 1 : 0);--}}
{{--            let starsHtml = '';--}}

{{--            for (let i = 0; i < maxStars; i++) {--}}
{{--                starsHtml += '<i class="far fa-star"></i>';--}}
{{--            }--}}

{{--            for (let i = 0; i < filledStars; i++) {--}}
{{--                starsHtml = starsHtml.replace('<i class="far fa-star"></i>', '<i class="fas fa-star filled-star"></i>');--}}
{{--            }--}}

{{--            if (remainder > 0) {--}}
{{--                starsHtml = starsHtml.replace('<i class="far fa-star"></i>', '<i class="fas fa-star-half-alt filled-star"></i>');--}}
{{--            }--}}

{{--            return starsHtml;--}}
{{--        }; */--}}
{{--        /* $("#tblVendorQuote").DataTable({--}}
{{--            searching: false,--}}
{{--            lengthChange: false,--}}
{{--            paging: false--}}
{{--        }); */--}}

{{--        /* $(document).on('click', '.btnQuoteView', function (e) {--}}
{{--            e.preventDefault();--}}
{{--            let QNo = $(this).closest('tr').find('td:eq(0)').html();--}}
{{--            let VendorName = $(this).closest('tr').find('td:eq(1)').html();--}}
{{--            let AllocateButton = $(this).closest('tr').find('.btnQuoteConvert').clone();--}}
{{--            $.ajax({--}}
{{--                type: "post",--}}
{{--                url: "{{url('/')}}/admin/transaction/quote-enquiry/get/vendor-quote-details",--}}
{{--                data: { QuoteSentID: $(this).attr('data-id'), VendorID: $(this).attr('data-vendor-id') },--}}
{{--                headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },--}}
{{--                success: function (response) {--}}
{{--                    let modalContent = $('<div>').append(response);--}}

{{--                    let table = $('<table class="table">');--}}
{{--                    let thead = $('<thead>').html(`<tr>--}}
{{--                                                        <th class="text-center align-middle">S.No</th>--}}
{{--                                                        <th class="text-center align-middle">Product Name</th>--}}
{{--                                                        <th class="text-center align-middle">Qty</th>--}}
{{--                                                        <th class="text-center align-middle">UOM</th>--}}
{{--                                                        <th class="text-center align-middle">Price per Unit<br> (₹)</th>--}}
{{--                                                        <th class="text-center align-middle">Tax Type</th>--}}
{{--                                                        <th class="text-center align-middle">Taxable<br> (₹)</th>--}}
{{--                                                        <th class="text-center align-middle">Tax Amount<br> (₹)</th>--}}
{{--                                                        <th class="text-center align-middle">CGST %</th>--}}
{{--                                                        <th class="text-center align-middle">CGST Amount<br> (₹)</th>--}}
{{--                                                        <th class="text-center align-middle">SGST %</th>--}}
{{--                                                        <th class="text-center align-middle">SGST Amount<br> (₹)</th>--}}
{{--                                                        <th class="text-center align-middle">Total Amount<br> (₹)</th>--}}
{{--                                                    </tr>`);--}}
{{--                    let tbody = $('<tbody>');--}}

{{--                    response.forEach(function (item, index) {--}}
{{--                    let row = $('<tr>').html(--}}
{{--                        `<td>${index + 1}</td>--}}
{{--                        <td>${item.ProductName}</td>--}}
{{--                        <td class="text-right">${item.Qty}</td>--}}
{{--                        <td>${item.UName} (${item.UCode})</td>--}}
{{--                        <td class="text-right">${Number(item.Price).toFixed({{2}})}</td>--}}
{{--                        <td>${item.TaxType}</td>--}}
{{--                        <td class="text-right">${Number(item.Taxable).toFixed({{2}})}</td>--}}
{{--                        <td class="text-right">${Number(item.TaxAmount).toFixed({{2}})}</td>--}}
{{--                        <td class="text-right">${Number(item.CGSTPer).toFixed({{2}})}</td>--}}
{{--                        <td class="text-right">${Number(item.CGSTAmount).toFixed({{2}})}</td>--}}
{{--                        <td class="text-right">${Number(item.SGSTPer).toFixed({{2}})}</td>--}}
{{--                        <td class="text-right">${Number(item.SGSTAmount).toFixed({{2}})}</td>--}}
{{--                        <td class="text-right">${Number(item.Amount).toFixed({{2}})}</td>`--}}
{{--                    );--}}
{{--                    tbody.append(row);--}}
{{--                    });--}}

{{--                    let totalPrice = response.reduce((total, item) => total + item.Amount, 0);--}}
{{--                    let totalTaxable = response.reduce((total, item) => total + item.Taxable, 0);--}}
{{--                    let totalCGST = response.reduce((total, item) => total + item.CGSTAmount, 0);--}}
{{--                    let totalSGST = response.reduce((total, item) => total + item.SGSTAmount, 0);--}}
{{--                    let totalIGST = 0;--}}

{{--                    let tfoot = $('<div>').html(`--}}
{{--                        <div class="row justify-content-end">--}}
{{--                            <div class="col-sm-6">--}}
{{--                                <div class="row mt-20 fw-600 fs-15 mr-10 justify-content-end">--}}
{{--                                    <div class="col-4">Sub Total</div>--}}
{{--                                    <div class="col-1">:</div>--}}
{{--                                    <div class="col-3 text-right" id="divSubTotal">${totalTaxable.toFixed({{2}})}</div>--}}
{{--                                </div>--}}
{{--                                <div class="row mt-10 fw-600 fs-15 mr-10 justify-content-end">--}}
{{--                                    <div class="col-4">CGST</div>--}}
{{--                                    <div class="col-1">:</div>--}}
{{--                                    <div class="col-3 text-right" id="divCGSTAmount">${totalCGST.toFixed({{2}})}</div>--}}
{{--                                </div>--}}
{{--                                <div class="row mt-10 fw-600 fs-15 mr-10 justify-content-end">--}}
{{--                                    <div class="col-4">SGST</div>--}}
{{--                                    <div class="col-1">:</div>--}}
{{--                                    <div class="col-3 text-right" id="divSGSTAmount">${totalSGST.toFixed({{2}})}</div>--}}
{{--                                </div>--}}
{{--                                <div class="row mt-10 fw-600 fs-15 mr-10 justify-content-end">--}}
{{--                                    <div class="col-4">IGST</div>--}}
{{--                                    <div class="col-1">:</div>--}}
{{--                                    <div class="col-3 text-right" id="divIGSTAmount">${totalIGST.toFixed({{2}})}</div>--}}
{{--                                </div>--}}
{{--                                <div class="row mt-10 fw-600 fs-16 mr-10 justify-content-end text-success">--}}
{{--                                    <div class="col-4">Total Amount</div>--}}
{{--                                    <div class="col-1">:</div>--}}
{{--                                    <div class="col-3 text-right" id="divTotalAmount">${totalPrice.toFixed({{2}})}</div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>`);--}}

{{--                    modalContent.append(table.append(thead).append(tbody)).append(tfoot);--}}
{{--                    let modalFooter = $('<div class="modal-footer">').html(AllocateButton);--}}

{{--                    let dialog = bootbox.dialog({--}}
{{--                        title: 'Quotation Details ( ' + VendorName + ' - ' + QNo + ' )',--}}
{{--                        closeButton: true,--}}
{{--                        message: modalContent,--}}
{{--                        className: 'modal-xl',--}}
{{--                    });--}}
{{--                    $(".modal-xl").css("max-width", "90% !important");--}}
{{--                    dialog.find('.modal-content').append(modalFooter);--}}

{{--                    modalFooter.on('click', 'button', function () {--}}
{{--                        dialog.modal('hide');--}}
{{--                    });--}}
{{--                }--}}
{{--            });--}}
{{--        }); */--}}
{{--        $(document).on('click', '#btnQuoteConvert', function (e) {--}}
{{--            let status = false;--}}
{{--            $('#tblVendorQuote tbody tr').each(function () {--}}
{{--                if ($(this).find('.chkAmount:checked').length == 0) {--}}
{{--                    status = false;toastr.error("Select All Product Prices!", "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})--}}
{{--                    return false;--}}
{{--                } else {--}}
{{--                    status = true;--}}
{{--                }--}}
{{--            });--}}

{{--            if(status){--}}
{{--                let FinalQuote = [];--}}
{{--                $('#tblVendorQuote tbody tr').each(function () {--}}
{{--                    let  PData = {--}}
{{--                        ProductID : $(this).attr('data-product-id'),--}}
{{--                        Qty : $(this).attr('data-qty'),--}}
{{--                        VendorID : $(this).find('.chkAmount:checked').val(),--}}
{{--                        FinalPrice : $(this).find('.chkAmount:checked').closest('.divPriceInput').find('.txtFinalPrice').val(),--}}
{{--                        VQuoteID : $(this).find('.chkAmount:checked').attr('data-vendor-quote-id'),--}}
{{--                        DetailID : $(this).find('.chkAmount:checked').attr('data-quote-detail-id'),--}}
{{--                    }--}}
{{--                    FinalQuote.push(PData);--}}
{{--                });--}}
{{--                AdditionalCost = [];--}}
{{--                $('.txtAdditionalCost:not(:disabled)').each(function () {--}}
{{--                    AdditionalCost.push({--}}
{{--                        VendorID: $(this).data('vendor-id'),--}}
{{--                        ACost: $(this).val()--}}
{{--                    });--}}
{{--                });--}}


{{--                console.log(FinalQuote);--}}
{{--                let formData = new FormData();--}}
{{--                formData.append('AdditionalCost', JSON.stringify(AdditionalCost));--}}
{{--                formData.append('FinalQuote', JSON.stringify(FinalQuote));--}}
{{--                swal({--}}
{{--                    title: "Are you sure?",--}}
{{--                    text: "You want to Convert Quotation",--}}
{{--                    type: "warning",--}}
{{--                    showCancelButton: true,--}}
{{--                    confirmButtonClass: "btn-outline-success",--}}
{{--                    confirmButtonText: "Yes, Convert it!",--}}
{{--                    closeOnConfirm: false--}}
{{--                },function(){--}}
{{--                    swal.close();--}}
{{--                    btnLoading($('#btnQuoteConvert'));--}}
{{--                    let postUrl="{{ url('/') }}/admin/transaction/quote-enquiry/quote-convert/{{$EnqData->EnqID}}";--}}
{{--                    $.ajax({--}}
{{--                        type:"post",--}}
{{--                        url:postUrl,--}}
{{--                        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },--}}
{{--                        data:formData,--}}
{{--                        cache: false,--}}
{{--                        processData: false,--}}
{{--                        contentType: false,--}}
{{--                        error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},--}}
{{--                        complete: function(e, x, settings, exception){btnReset($('#btnQuoteConvert'));ajaxIndicatorStop();$("html, body").animate({ scrollTop: 0 }, "slow");},--}}
{{--                        success:function(response){--}}
{{--                            if(response.status==true){--}}
{{--                                swal({--}}
{{--                                    title: "SUCCESS",--}}
{{--                                    text: response.message,--}}
{{--                                    type: "success",--}}
{{--                                    showCancelButton: false,--}}
{{--                                    confirmButtonClass: "btn-outline-success",--}}
{{--                                    confirmButtonText: "Okay",--}}
{{--                                    closeOnConfirm: false--}}
{{--                                },function(){--}}
{{--                                    window.location.replace("{{url('/')}}/admin/transaction/quote-enquiry");--}}
{{--                                });--}}

{{--                            }else{--}}
{{--                                toastr.error(response.message, "Failed", {--}}
{{--                                    positionClass: "toast-top-right",--}}
{{--                                    containerId: "toast-top-right",--}}
{{--                                    showMethod: "slideDown",--}}
{{--                                    hideMethod: "slideUp",--}}
{{--                                    progressBar: !0--}}
{{--                                })--}}
{{--                            }--}}
{{--                        }--}}
{{--                    });--}}
{{--                });--}}
{{--            }--}}
{{--        });--}}

{{--        const validateGetData=()=>{--}}
{{--			let status = true;--}}
{{--            let SelectedVendors = [];--}}
{{--            $('.chkVendors').each(function () {--}}
{{--                if ($(this).is(':checked')) {--}}
{{--                    status1 = true;--}}
{{--                    SelectedVendors.push($(this).attr('id'));--}}
{{--                }--}}
{{--            });--}}
{{--            if(SelectedVendors.length == 0) {--}}
{{--                status = false;--}}
{{--                toastr.error("Please select a Vendor!", "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})--}}
{{--            }--}}
{{--            $(".errors").each(function () {--}}
{{--                if ($(this).html()) {--}}
{{--                    let Element = $(this).closest('.divInput').find('input');--}}
{{--                    Element.focus();--}}
{{--                    status = false;--}}
{{--                    return false;--}}
{{--                }--}}
{{--            });--}}
{{--			let ProductDetails=[];--}}
{{--			$("#tblProductDetails tbody tr").each(function () {--}}
{{--				let PData = {--}}
{{--					ProductID: $(this).attr("data-product-id"),--}}
{{--					UOMID: $(this).find('td:eq(2)').attr("data-uom-id"),--}}
{{--					Qty: $(this).find('td:eq(2)').attr("data-qty"),--}}
{{--					PCID: $(this).attr("data-pcid"),--}}
{{--					PSCID: $(this).attr("data-pscid"),--}}
{{--					// Qty: $(this).find(".txtQty").val(),--}}
{{--					// Qty: $(this).find('td:eq(2)').html(),--}}
{{--				};--}}
{{--                ProductDetails.push(PData);--}}
{{--			});--}}
{{--			let formData = new FormData();--}}
{{--			formData.append('SelectedVendors', JSON.stringify(SelectedVendors));--}}
{{--			formData.append('ProductDetails', JSON.stringify(ProductDetails));--}}
{{--			return {formData , status};--}}
{{--		}--}}
{{--        $(document).on('input', '.txtQty', function () {--}}
{{--			let errorElement = $(this).closest('.divInput').find('.txtQty-err');--}}
{{--			let inputValue = parseFloat($(this).val());--}}
{{--			if (isNaN(inputValue)) {inputValue = 0;}--}}
{{--			if (inputValue < 0) {errorElement.text("Quantity cannot be less than 0");} else {errorElement.text("");}--}}
{{--			$(this).val(inputValue);--}}
{{--		});--}}
{{--        $(document).on('blur', '.txtFinalPrice', function () {--}}
{{--            let errorElement = $(this).closest('.divPriceInput').find('.errors');--}}
{{--			let DefaultPrice = $(this).data('price');--}}
{{--			let inputValue = parseFloat($(this).val());--}}
{{--			if (inputValue < DefaultPrice) {errorElement.text("Price cannot be less than Vendor Price");$(this).val(DefaultPrice);} else {errorElement.text("");}--}}
{{--		});--}}

{{--        const LoadAdditionalCost = () => {--}}
{{--            $('.txtAdditionalCost').each(function () {--}}
{{--                let vendorId = $(this).data('vendor-id');--}}
{{--                let VendorCount=$('.chkAmount:checked[data-vendor-id="' + vendorId + '"]').length;--}}
{{--                if (VendorCount > 0) {--}}
{{--                    $(this).prop('disabled', false);--}}
{{--                } else {--}}
{{--                    $(this).prop('disabled', true);--}}
{{--                }--}}
{{--                $('.SelectedItemCount[data-vendor-id="' + vendorId + '"]').text('Items(' + VendorCount + ')');--}}
{{--            });--}}
{{--        };--}}

{{--        $(document).on('change', '.chkAmount', function () {--}}
{{--            LoadAdditionalCost();--}}
{{--        });--}}

{{--        $(document).on('click', '.btnVendorRatings', function (e) {--}}
{{--            e.preventDefault();--}}
{{--            let VendorName = $(this).attr('data-vendor-name');--}}
{{--            $.ajax({--}}
{{--                type: "post",--}}
{{--                url: "{{url('/')}}/admin/transaction/quote-enquiry/get/vendor-ratings",--}}
{{--                data: { VendorID: $(this).attr('data-vendor-id') },--}}
{{--                headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },--}}
{{--                success: function (response) {--}}
{{--                    let modalContent = $('<div></div>');--}}
{{--                    let row = $('<div class="row my-3 justify-content-center">').html(--}}
{{--                            `<div class="row">--}}
{{--                                <div class="col-12 text-center">--}}
{{--                                    <img src="{{ url('/') }}/${response.Logo}" alt="Vendor Logo" class="img-fluid rounded" height="150" width="150">--}}
{{--                                </div>--}}
{{--                                <div class="row mt-20">--}}
{{--                                    <div class="col-7">--}}
{{--                                        <h6 class="text-center my-2">Vendor Info</h6>--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col-sm-5 fs-15 fw-600">Vendor Name</div>--}}
{{--                                            <div class="col-sm-1 fs-15 fw-600 text-center">:</div>--}}
{{--                                            <div class="col-sm-5 fs-15">${response.VendorName}</div>--}}
{{--                                        </div>--}}
{{--                                        <div class="row my-1">--}}
{{--                                            <div class="col-sm-5 fs-15 fw-600">Address</div>--}}
{{--                                            <div class="col-sm-1 fs-15 fw-600 text-center">:</div>--}}
{{--                                            <div class="col-sm-5 fs-15">${response.Address}, ${response.CityName}<br>${response.TalukName}, ${response.DistrictName}<br>${response.StateName}-${response.PostalCode}</div>--}}
{{--                                        </div>--}}
{{--                                        <div class="row my-1">--}}
{{--                                            <div class="col-sm-5 fs-15 fw-600">GST No</div>--}}
{{--                                            <div class="col-sm-1 fs-15 fw-600 text-center">:</div>--}}
{{--                                            <div class="col-sm-5 fs-15">${response.GSTNo}</div>--}}
{{--                                        </div>--}}
{{--                                        <div class="row my-1">--}}
{{--                                            <div class="col-sm-5 fs-15 fw-600">Mobile No</div>--}}
{{--                                            <div class="col-sm-1 fs-15 fw-600 text-center">:</div>--}}
{{--                                            <div class="col-sm-5 fs-15">${response.MobileNumber1}</div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-5">--}}
{{--                                        <h6 class="text-center my-2">Key Points</h6>--}}
{{--                                        <div class="mt-2 fs-15">• ${response.VendorName} is with us since <b>${response.TotalYears}.</b></div>--}}
{{--                                        <div class="my-2 fs-15">• Has completed <b>${response.TotalOrders}</b> orders worth INR <b>${Number(response.OrderValue).toFixed({{2}})}.</b></div>--}}
{{--                                        <div class="my-2 fs-15">• Has ${generateStarRating(response.CustomerRating)} Customer rating and ${generateStarRating(response.AdminRating)} Admin Rating.</div>--}}
{{--                                        <div class="my-2 fs-15">• Has outstanding of <b>INR ${Number(response.Outstanding).toFixed({{2}})}.</b></div>--}}
{{--                                        <div class="my-2 fs-15">• Has an Overall Rating of <b>${response.OverAll}.</b></div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>`);--}}
{{--                        modalContent.append(row);--}}

{{--                    /* Object.keys(response).forEach(function (key) {--}}
{{--                        let item = response[key];--}}
{{--                        let formattedKey = camelCaseToWords(key);--}}

{{--                        let rowContent;--}}
{{--                        if (key === 'CustomerRating' || key === 'AdminRating') {--}}
{{--                            rowContent = generateStarRating(item);--}}
{{--                        }else if (key === 'Outstanding' || key === 'OrderValue') {--}}
{{--                            rowContent = Number(item).toFixed({{2}});--}}
{{--                        }else if (key === 'OverAll') {--}}
{{--                            rowContent = '<span class="fw-600">'+item+'</span>';--}}
{{--                        }else {--}}
{{--                            rowContent = item;--}}
{{--                        }--}}
{{--                    }); */--}}

{{--                    let dialog = bootbox.dialog({--}}
{{--                        title: "Vendor Details",--}}
{{--                        // title: VendorName+' - Ratings',--}}
{{--                        closeButton: true,--}}
{{--                        message: modalContent,--}}
{{--                        className: 'modal-xl',--}}
{{--                    });--}}
{{--                    dialog.find('.modal-title').css({ 'margin': '0 auto', 'display': 'inline-block' });--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--        $(document).on('click', '.btnVendorPrice', function (e) {--}}
{{--            e.preventDefault();--}}
{{--            let VendorID = $(this).data('vendor-id');--}}
{{--            let VendorName = $(this).data('vendor-name');--}}
{{--            $.ajax({--}}
{{--                type: "post",--}}
{{--                url: "{{url('/')}}/admin/transaction/quote-enquiry/get/vendor-quote",--}}
{{--                data: { VendorID: VendorID, EnqID : "{{$EnqData->EnqID}}" },--}}
{{--                headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },--}}
{{--                success: function (response) {--}}
{{--                    let card = $('<div class="card"></div>');--}}
{{--                    let cardBody = $('<div class="card-body"></div>');--}}

{{--                    let table = $('<table class="table" id="tblVendorPriceUpdate"></table>');--}}
{{--                    let thead = $('<thead><tr><th class="text-center align-middle">S.No</th><th class="text-center align-middle">Product</th><th class="text-center align-middle">Qty</th><th class="text-center align-middle">Price</th></tr></thead>');--}}
{{--                    table.append(thead);--}}

{{--                    let tbody = $('<tbody></tbody>');--}}
{{--                    response.ProductData.forEach((product, index) => {--}}
{{--                        let row = $('<tr data-product-id="' + product.ProductID + '"></tr>');--}}
{{--                        row.append('<td>' + (index + 1) + '</td>');--}}
{{--                        row.append('<td>' + product.ProductName + '</td>');--}}
{{--                        row.append('<td class="text-center">' + product.Qty + ' ( ' + product.UCode + ' )</td>');--}}
{{--                        let formattedPrice = product.VendorPrice.toFixed(2);--}}
{{--                        row.append(`<td class="align-items-center align-middle">--}}
{{--                                        <div class="row d-flex align-items-center justify-content-center">--}}
{{--                                            <div class="col-6">--}}
{{--                                                <input type="number" class="form-control txtVendorPrice" value="${formattedPrice}" step="0.01">--}}
{{--                                                <span class="errors err-sm"></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <span class="errors err-sm"></span>--}}
{{--                                    </td>`);--}}
{{--                        tbody.append(row);--}}
{{--                    });--}}
{{--                    table.append(tbody);--}}
{{--                    cardBody.append(table);--}}

{{--                    let costInputs = $(`<div class="row mt-20 justify-content-center">--}}
{{--                                            <div class="col-sm-5">--}}
{{--                                                <label for="txtTransportCost" class="fw-700">Transport Cost :</label>--}}
{{--                                                <input type="number" class="form-control" id="txtTransportCost" step="0.01">--}}
{{--                                                <div class="errors" id="txtTransportCost-err"></div>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-sm-5">--}}
{{--                                                <label for="txtLabourCost" class="fw-700">Labour Cost :</label>--}}
{{--                                                <input type="number" class="form-control" id="txtLabourCost" step="0.01">--}}
{{--                                                <div class="errors" id="txtLabourCost-err"></div>--}}
{{--                                            </div>--}}
{{--                                        </div>`);--}}
{{--                    cardBody.append(costInputs);--}}

{{--                    card.append(cardBody);--}}

{{--                    let cardFooter = $('<div class="card-footer text-right pt-10"></div>');--}}

{{--                    let rejectButton = $('<button type="button" class="btn btn-danger mr-2" data-vendor-id="' + VendorID + '" data-vendor-quote-id="' + response.VQuoteID + '" id="btnRejectQuote">Reject Quote</button>');--}}

{{--                    let submitButton = $('<button type="button" class="btn btn-primary" data-vendor-id="' + VendorID + '" data-vendor-quote-id="' + response.VQuoteID + '" id="btnAddVendorPrice">Submit</button>');--}}

{{--                    cardFooter.append(rejectButton);--}}
{{--                    cardFooter.append(submitButton);--}}

{{--                    card.append(cardFooter);--}}

{{--                    let dialog = bootbox.dialog({--}}
{{--                        title: 'Quote Price Update (' + response.EnqNo + ') - '+ VendorName,--}}
{{--                        closeButton: true,--}}
{{--                        message: card,--}}
{{--                        className: 'modal-xl',--}}
{{--                    });--}}
{{--                    dialog.find('.modal-title').css({ 'margin': '0 auto', 'display': 'inline-block' });--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}

{{--        $(document).on('click', '#btnAddVendorPrice', function () {--}}
{{--            let status = true;--}}
{{--            let ProductData =[];--}}
{{--            $('#tblVendorPriceUpdate tbody tr').each(function(){--}}
{{--                let product = {--}}
{{--                    ProductID : $(this).data('product-id'),--}}
{{--                    Price : $(this).find('.txtVendorPrice').val(),--}}
{{--                }--}}
{{--                ProductData.push(product);--}}
{{--            });--}}
{{--            let formData = new FormData();--}}
{{--            formData.append('VendorID',$(this).data('vendor-id'));--}}
{{--            formData.append('VQuoteID',$(this).data('vendor-quote-id'));--}}
{{--            formData.append('TransportCost',$('#txtTransportCost').val());--}}
{{--            formData.append('LabourCost',$('#txtLabourCost').val());--}}
{{--            formData.append('ProductData',JSON.stringify(ProductData));--}}
{{--            if(status){--}}
{{--                swal({--}}
{{--                    title: "Are you sure?",--}}
{{--                    text: "You want to Submit Vendor Price!",--}}
{{--                    type: "warning",--}}
{{--                    showCancelButton: true,--}}
{{--                    confirmButtonClass: "btn-outline-success",--}}
{{--                    confirmButtonText: "Yes, Submit it!",--}}
{{--                    closeOnConfirm: false--}}
{{--                },function(){--}}
{{--                    swal.close();--}}
{{--                    btnLoading($('#btnAddVendorPrice'));--}}
{{--                    let postUrl="{{ url('/') }}/admin/transaction/quote-enquiry/add-quote-price";--}}
{{--                    $.ajax({--}}
{{--                        type:"post",--}}
{{--                        url:postUrl,--}}
{{--                        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },--}}
{{--                        data:formData,--}}
{{--                        cache: false,--}}
{{--                        processData: false,--}}
{{--                        contentType: false,--}}
{{--                        xhr: function() {--}}
{{--                            var xhr = new window.XMLHttpRequest();--}}
{{--                            xhr.upload.addEventListener("progress", function(evt) {--}}
{{--                                if (evt.lengthComputable) {--}}
{{--                                    var percentComplete = (evt.loaded / evt.total) * 100;--}}
{{--                                    percentComplete=parseFloat(percentComplete).toFixed(2);--}}
{{--                                    $('#divProcessText').html(percentComplete+'% Completed.<br> Please wait for until upload process complete.');--}}
{{--                                    //Do something with upload progress here--}}
{{--                                }--}}
{{--                            }, false);--}}
{{--                            return xhr;--}}
{{--                        },--}}
{{--                        beforeSend: function() {--}}
{{--                            ajaxIndicatorStart("Please wait Upload Process on going.");--}}

{{--                            var percentVal = '0%';--}}
{{--                            setTimeout(() => {--}}
{{--                            $('#divProcessText').html(percentVal+' Completed.<br> Please wait for until upload process complete.');--}}
{{--                            }, 100);--}}
{{--                        },--}}
{{--                        error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},--}}
{{--                        complete: function(e, x, settings, exception){btnReset($('#btnAddVendorPrice'));ajaxIndicatorStop();$("html, body").animate({ scrollTop: 0 }, "slow");},--}}
{{--                        success:function(response){--}}
{{--                            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera--}}
{{--                            if(response.status==true){--}}
{{--                                swal({--}}
{{--                                    title: "SUCCESS",--}}
{{--                                    text: response.message,--}}
{{--                                    type: "success",--}}
{{--                                    showCancelButton: false,--}}
{{--                                    confirmButtonClass: "btn-outline-success",--}}
{{--                                    confirmButtonText: "Okay",--}}
{{--                                    closeOnConfirm: false--}}
{{--                                },function(){--}}
{{--                                    window.location.replace("{{url('/')}}/admin/transaction/quote-enquiry/view/{{$EnqData->EnqID}}");--}}
{{--                                });--}}

{{--                            }else{--}}
{{--                                toastr.error(response.message, "Failed", {--}}
{{--                                    positionClass: "toast-top-right",--}}
{{--                                    containerId: "toast-top-right",--}}
{{--                                    showMethod: "slideDown",--}}
{{--                                    hideMethod: "slideUp",--}}
{{--                                    progressBar: !0--}}
{{--                                })--}}
{{--                            }--}}
{{--                        }--}}
{{--                    });--}}
{{--                });--}}
{{--            }--}}
{{--        });--}}
{{--        $(document).on('click', '#btnRejectQuote', function () {--}}
{{--            let formData = new FormData();--}}
{{--            formData.append('VendorID',$(this).data('vendor-id'));--}}
{{--            formData.append('VQuoteID',$(this).data('vendor-quote-id'));--}}

{{--            swal({--}}
{{--                title: "Are you sure?",--}}
{{--                text: "You want to Reject this Quote!",--}}
{{--                type: "warning",--}}
{{--                showCancelButton: true,--}}
{{--                confirmButtonClass: "btn-outline-success",--}}
{{--                confirmButtonText: "Yes, Reject it!",--}}
{{--                closeOnConfirm: false--}}
{{--            },function(){--}}
{{--                swal.close();--}}
{{--                let postUrl="{{ url('/') }}/admin/transaction/quote-enquiry/reject-quote";--}}
{{--                $.ajax({--}}
{{--                    type:"post",--}}
{{--                    url:postUrl,--}}
{{--                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },--}}
{{--                    data:formData,--}}
{{--                    cache: false,--}}
{{--                    processData: false,--}}
{{--                    contentType: false,--}}
{{--                    error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},--}}
{{--                    complete: function(e, x, settings, exception){ajaxIndicatorStop();$("html, body").animate({ scrollTop: 0 }, "slow");},--}}
{{--                    success:function(response){--}}
{{--                        document.documentElement.scrollTop = 0;--}}
{{--                        if(response.status==true){--}}
{{--                            swal({--}}
{{--                                title: "SUCCESS",--}}
{{--                                text: response.message,--}}
{{--                                type: "success",--}}
{{--                                showCancelButton: false,--}}
{{--                                confirmButtonClass: "btn-outline-success",--}}
{{--                                confirmButtonText: "Okay",--}}
{{--                                closeOnConfirm: false--}}
{{--                            },function(){--}}
{{--                                window.location.replace("{{url('/')}}/admin/transaction/quote-enquiry/view/{{$EnqData->EnqID}}");--}}
{{--                            });--}}

{{--                        }else{--}}
{{--                            toastr.error(response.message, "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})--}}
{{--                        }--}}
{{--                    }--}}
{{--                });--}}
{{--            });--}}
{{--        });--}}
{{--        $('#btnRequestQuote').click(async function(){--}}
{{--            let { formData , status } = await validateGetData();--}}
{{--            if(status){--}}
{{--                swal({--}}
{{--                    title: "Are you sure?",--}}
{{--                    text: "You want to Send Quote Request!",--}}
{{--                    type: "warning",--}}
{{--                    showCancelButton: true,--}}
{{--                    confirmButtonClass: "btn-outline-success",--}}
{{--                    confirmButtonText: "Yes, Send it!",--}}
{{--                    closeOnConfirm: false--}}
{{--                },function(){--}}
{{--                    swal.close();--}}
{{--                    btnLoading($('#btnRequestQuote'));--}}
{{--                    let postUrl="{{ url('/') }}/admin/transaction/quote-enquiry/request-quote/{{$EnqData->EnqID}}";--}}
{{--                    $.ajax({--}}
{{--                        type:"post",--}}
{{--                        url:postUrl,--}}
{{--                        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },--}}
{{--                        data:formData,--}}
{{--                        cache: false,--}}
{{--                        processData: false,--}}
{{--                        contentType: false,--}}
{{--                        xhr: function() {--}}
{{--                            var xhr = new window.XMLHttpRequest();--}}
{{--                            xhr.upload.addEventListener("progress", function(evt) {--}}
{{--                                if (evt.lengthComputable) {--}}
{{--                                    var percentComplete = (evt.loaded / evt.total) * 100;--}}
{{--                                    percentComplete=parseFloat(percentComplete).toFixed(2);--}}
{{--                                    $('#divProcessText').html(percentComplete+'% Completed.<br> Please wait for until upload process complete.');--}}
{{--                                    //Do something with upload progress here--}}
{{--                                }--}}
{{--                            }, false);--}}
{{--                            return xhr;--}}
{{--                        },--}}
{{--                        beforeSend: function() {--}}
{{--                            ajaxIndicatorStart("Please wait Upload Process on going.");--}}

{{--                            var percentVal = '0%';--}}
{{--                            setTimeout(() => {--}}
{{--                            $('#divProcessText').html(percentVal+' Completed.<br> Please wait for until upload process complete.');--}}
{{--                            }, 100);--}}
{{--                        },--}}
{{--                        error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},--}}
{{--                        complete: function(e, x, settings, exception){btnReset($('#btnRequestQuote'));ajaxIndicatorStop();$("html, body").animate({ scrollTop: 0 }, "slow");},--}}
{{--                        success:function(response){--}}
{{--                            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera--}}
{{--                            if(response.status==true){--}}
{{--                                swal({--}}
{{--                                    title: "SUCCESS",--}}
{{--                                    text: response.message,--}}
{{--                                    type: "success",--}}
{{--                                    showCancelButton: false,--}}
{{--                                    confirmButtonClass: "btn-outline-success",--}}
{{--                                    confirmButtonText: "Okay",--}}
{{--                                    closeOnConfirm: false--}}
{{--                                },function(){--}}
{{--                                    window.location.replace("{{url('/')}}/admin/transaction/quote-enquiry");--}}
{{--                                });--}}

{{--                            }else{--}}
{{--                                toastr.error(response.message, "Failed", {--}}
{{--                                    positionClass: "toast-top-right",--}}
{{--                                    containerId: "toast-top-right",--}}
{{--                                    showMethod: "slideDown",--}}
{{--                                    hideMethod: "slideUp",--}}
{{--                                    progressBar: !0--}}
{{--                                })--}}
{{--                                if(response['errors']!=undefined){--}}
{{--                                    $('.errors').html('');--}}
{{--                                    $.each( response['errors'], function( KeyName, KeyValue ) {--}}
{{--                                        var key=KeyName;--}}
{{--                                        if(key=="TaxName"){$('#txtTaxName-err').html(KeyValue);}--}}
{{--                                        if(key=="Percentage"){$('#txtPercentage-err').html(KeyValue);}--}}

{{--                                    });--}}
{{--                                }--}}
{{--                            }--}}
{{--                        }--}}
{{--                    });--}}
{{--                });--}}
{{--            }--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}
@endsection
