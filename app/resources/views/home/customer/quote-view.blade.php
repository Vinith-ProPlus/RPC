@extends('home.home-layout')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        .checkout-progress-bar {
            margin: 2.7rem 0 -2.9rem;
            font-size: 0;
            line-height: 1.4;
        }

        .checkout-progress-bar li a {
            color: #0f43b0 !important;
        }

        .stamp-badge {
            padding: 3px 6px;
            margin: -10px;
            z-index: 1;
        }

        .valign-top th {
            vertical-align: top !important;
        }

        td {
            text-align: center;
        }

        .table.table-striped td,
        .table.table-striped th {
            padding: 1.1rem 1.2rem
        }

        .table.table-striped tr:nth-child(odd) {
            background-color: #f9f9f9
        }

        .table.table-size tbody tr td,
        .table.table-size thead tr th {
            border: 0;
            color: #21293c;
            font-size: 1.4rem;
            letter-spacing: 0.005em;
            text-transform: uppercase
        }

        .table.table-size thead tr th {
            padding: 2.8rem 1.5rem 1.7rem;
            background-color: #f4f4f2;
            font-weight: 600
        }

        .table.table-size tbody tr td {
            padding: 1.1rem 1.5rem;
            background-color: #fff;
            font-weight: 700
        }

        .table.table-size tbody tr:nth-child(2n) td {
            background-color: #ebebeb
        }

        @media (min-width: 992px) {
            .product-both-info .row .col-lg-12 {
                margin-bottom: 4px
            }

            .main-content .col-lg-7 {
                -ms-flex: 0 0 54%;
                flex: 0 0 54%;
                max-width: 54%
            }

            .main-content .col-lg-5 {
                -ms-flex: 0 0 46%;
                flex: 0 0 46%;
                max-width: 46%
            }

            .product-full-width {
                padding-right: 3.5rem
            }

            .product-full-width .product-single-details .product-title {
                font-size: 4rem
            }

            .table.table-size thead tr th {
                padding-top: 2.9rem;
                padding-bottom: 2.9rem
            }

            .table.table-size tbody tr td,
            .table.table-size thead tr th {
                padding-right: 4.2rem;
                padding-left: 3rem
            }
        }

        @media (max-width: 767px) {
            .product-size-content .table.table-size {
                margin-top: 3rem
            }
        }

        .table.table-downloads,
        .table.table-order {
            margin-bottom: 1px;
            font-size: 14px
        }

        .table.table-downloads thead th,
        .table.table-order thead th {
            border-top: none;
            border-bottom-width: 1px;
            padding: 1.3rem 1rem;
            font-weight: 700;
            color: #222524
        }

        .table.table-downloads tbody td,
        .table.table-order tbody td {
            vertical-align: middle
        }

        .table.table-order-detail th {
            font-weight: 600
        }

        .table.table-order-detail td,
        .table.table-order-detail th {
            padding: 1rem;
            font-size: 1.4rem;
            line-height: 24px
        }

        .table.table-order-detail thead th {
            border: none
        }

        .table.table-order-detail .product-title {
            display: inline;
            color: #08C;
            font-size: 1.4rem;
            font-weight: 400
        }

        .table.table-order-detail .product-count {
            color: #08C
        }

        @media (max-width: 767px) {
            .table.table-order thead {
                display: none
            }

            .table.table-order td {
                display: block;
                border-top: none;
                text-align: center
            }

            .table.table-order .product-thumbnail img {
                display: inline
            }

            .table.table-order tbody tr {
                position: relative;
                display: block;
                padding: 10px 0
            }

            .table.table-order tbody tr:not(:first-child) {
                border-top: 1px solid #ddd
            }

            .table.table-order .product-remove {
                position: absolute;
                top: 12px;
                right: 0
            }
        }

        .table.table-cart tr td,
        .table.table-cart tr th,
        .table.table-wishlist tr td,
        .table.table-wishlist tr th {
            vertical-align: middle
        }

        .table.table-cart tr th,
        .table.table-wishlist tr th {
            border: 0;
            color: #222529;
            font-weight: 700;
            line-height: 2.4rem;
            text-transform: uppercase
        }

        .table.table-cart tr td,
        .table.table-wishlist tr td {
            border-top: 1px solid #e7e7e7
        }

        .table.table-cart tr td.product-col,
        .table.table-wishlist tr td.product-col {
            padding: 2rem 0.8rem 1.8rem 0
        }

        .table.table-cart tr.product-action-row td,
        .table.table-wishlist tr.product-action-row td {
            padding: 0 0 2.2rem;
            border: 0
        }

        .table.table-cart .product-image-container,
        .table.table-wishlist .product-image-container {
            position: relative;
            width: 8rem;
            margin: 0
        }

        .table.table-cart .product-title,
        .table.table-wishlist .product-title {
            margin-bottom: 0;
            padding: 0;
            font-family: "Open Sans", sans-serif;
            font-weight: 400;
            line-height: 1.75
        }

        .table.table-cart .product-title a,
        .table.table-wishlist .product-title a {
            color: inherit
        }

        .table.table-cart .product-single-qty,
        .table.table-wishlist .product-single-qty {
            margin: 0.5rem 4px 0.5rem 1px
        }

        .table.table-cart .product-single-qty .form-control,
        .table.table-wishlist .product-single-qty .form-control {
            height: 48px;
            width: 44px;
            font-size: 1.6rem;
            font-weight: 700
        }

        .table.table-cart .subtotal-price,
        .table.table-wishlist .subtotal-price {
            color: #222529;
            font-size: 1.6rem;
            font-weight: 600
        }

        .table.table-cart .btn-remove,
        .table.table-wishlist .btn-remove {
            right: -10px;
            font-size: 1.1rem
        }

        .table.table-cart tfoot td,
        .table.table-wishlist tfoot td {
            padding: 2rem 0.8rem 1rem
        }

        .table.table-cart tfoot .btn,
        .table.table-wishlist tfoot .btn {
            padding: 1.2rem 2.4rem 1.3rem 2.5rem;
            font-family: "Open Sans", sans-serif;
            font-size: 1.3rem;
            font-weight: 700;
            height: 43px;
            letter-spacing: -0.018em
        }

        .table.table-cart tfoot .btn + .btn,
        .table.table-wishlist tfoot .btn + .btn {
            margin-left: 1rem
        }

        .table.table-cart .bootstrap-touchspin.input-group,
        .table.table-wishlist .bootstrap-touchspin.input-group {
            margin-right: auto;
            margin-left: auto
        }

        .table.table-wishlist tr th {
            padding: 10px 5px 10px 16px
        }

        .table.table-wishlist tr th.thumbnail-col {
            width: 10%
        }

        .table.table-wishlist tr th.product-col {
            width: 29%
        }

        .table.table-wishlist tr th.price-col {
            width: 13%
        }

        .table.table-wishlist tr th.status-col {
            width: 19%
        }

        .table.table-wishlist tr td {
            padding: 20px 5px 23px 16px
        }

        .table.table-wishlist .product-price {
            color: inherit;
            font-size: 1.4rem;
            font-weight: 400
        }

        .table.table-wishlist .price-box {
            margin-bottom: 0
        }

        .table.table-wishlist .stock-status {
            color: #222529;
            font-weight: 600
        }

        #QuoteCancelModelLabel {
            font-size: 2rem !important;
        }

        #updateCAChargesLabel {
            font-size: 2rem !important;
        }

        .select2-container--default .select2-selection--single
        {
            border: solid black 1px !important;
            outline: 0;
            background-color: white !important;
            border: 1px solid #dfdfdf !important;
            border-radius: 0px !important;
            cursor: text;
        }
        .select2-search__field {
            min-height: 35px !important; /* Adjust the font size as needed */
            padding: .375rem .75rem !important;
            padding-left: 0.75rem !important;
            padding-left: 0.75rem !important;
            font-size: 1.2rem !important;
            font-weight: 400 !important;
        }

        .select2-container {
            width: 100% !important;
        }
    </style>
    <?php
    $vendorAdditionalCharges = [];
    ?>
    <div class="container mt-2">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <ul class="checkout-progress-bar d-flex justify-content-center flex-wrap">
                        <li class="active">
                            {{--                        <a href="#">Order - ( {{$OData->OrderNo}} )</a>--}}
                            <a href="#">Quotation - ( {{$QData->QNo}} )</a>
                        </li>
                    </ul>
                    {{--				<div class="card-header text-center"><h5 class="mt-10">Quotation - ( {{$QData->QNo}} )</h5></div>--}}
                    <div class="card-body mb-0 pb-0">
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
                                                    'Contact Person' => ($QData->ReceiverName!="")? $QData->ReceiverName." <span> (".$QData->ReceiverMobNo.")</span>":"",
                                                    'Contact Number' => $QData->MobileNo1 ,
                                                    'Quote Expiry Date' => date('d-M-Y', strtotime($QData->QExpiryDate)),
                                                ] as $label => $value)
                                                    @if($value!="")
                                                        <div class="row my-1">
                                                            <div class="col-sm-5 fw-600">{{ $label }}</div>
                                                            <div class="col-sm-1 fw-600 text-center">:</div>
                                                            <div class="col-sm-6"><?php echo $value ?></div>
                                                        </div>
                                                    @endif
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
                                                $Address = "";
                                                // if($QData->CustomerName!=""){$Address.="<b>".$QData->CustomerName."</b>";}
                                                if ($QData->BAddress != "") {
                                                    if ($Address != "") {
                                                        $Address .= ",<br> ";
                                                    }
                                                    $Address .= $QData->BAddress;
                                                }
                                                if ($QData->BCityName != "") {
                                                    if ($Address != "") {
                                                        $Address .= ",<br> ";
                                                    }
                                                    $Address .= $QData->BCityName;
                                                }
                                                if ($QData->BTalukName != "") {
                                                    if ($Address != "") {
                                                        $Address .= ",<br> ";
                                                    }
                                                    $Address .= $QData->BTalukName;
                                                }
                                                if ($QData->BDistrictName != "") {
                                                    if ($Address != "") {
                                                        $Address .= ",<br> ";
                                                    }
                                                    $Address .= $QData->BDistrictName;
                                                }
                                                if ($QData->BStateName != "") {
                                                    if ($Address != "") {
                                                        $Address .= ",<br>";
                                                    }
                                                    $Address .= $QData->BStateName;
                                                }
                                                if ($QData->BCountryName != "") {
                                                    if ($Address != "") {
                                                        $Address .= ", ";
                                                    }
                                                    $Address .= $QData->BCountryName;
                                                }
                                                if ($QData->BPostalCode != "") {
                                                    if ($Address != "") {
                                                        $Address .= " - ";
                                                    }
                                                    $Address .= $QData->BPostalCode;
                                                }
                                                if ($Address != "") {
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
                                                $DAddress = "";
                                                if ($QData->DAddress != "") {
                                                    if ($DAddress != "") {
                                                        $DAddress .= ",<br> ";
                                                    }
                                                    $DAddress .= $QData->DAddress;
                                                }
                                                if ($QData->DCityName != "") {
                                                    if ($DAddress != "") {
                                                        $DAddress .= ",<br> ";
                                                    }
                                                    $DAddress .= $QData->DCityName;
                                                }
                                                if ($QData->DTalukName != "") {
                                                    if ($DAddress != "") {
                                                        $DAddress .= ",<br> ";
                                                    }
                                                    $DAddress .= $QData->DTalukName;
                                                }
                                                if ($QData->DDistrictName != "") {
                                                    if ($DAddress != "") {
                                                        $DAddress .= ",<br> ";
                                                    }
                                                    $DAddress .= $QData->DDistrictName;
                                                }
                                                if ($QData->DStateName != "") {
                                                    if ($DAddress != "") {
                                                        $DAddress .= ",<br>";
                                                    }
                                                    $DAddress .= $QData->DStateName;
                                                }
                                                if ($QData->DCountryName != "") {
                                                    if ($DAddress != "") {
                                                        $DAddress .= ", ";
                                                    }
                                                    $DAddress .= $QData->DCountryName;
                                                }
                                                if ($QData->DPostalCode != "") {
                                                    if ($DAddress != "") {
                                                        $DAddress .= " - ";
                                                    }
                                                    $DAddress .= $QData->DPostalCode;
                                                }
                                                if ($DAddress != "") {
                                                    $DAddress .= ".";
                                                }
                                                echo $DAddress;
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="text-center fw-700">Quotation</h6>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-wishlist" id="tblQuoteDetails">
                                            <thead>
                                            <tr class="valign-top">
                                                <th class="text-center align-middle">S.No</th>
                                                <th class="text-center align-middle">Product Name</th>
                                                <th class="text-center align-middle">Qty</th>
                                                <th class="text-center align-middle">Price<br> (₹)</th>
                                                <th class="text-center align-middle">Tax Type</th>
                                                <th class="text-center align-middle">Taxable<br> (₹)</th>
                                                <th class="text-center align-middle">Tax Amount<br> (₹)</th>
                                                <th class="text-center align-middle">Total Amount<br> (₹)</th>
                                                @if($QData->Status=="New")
                                                    <th class="text-center align-middle">Action</th>
                                                @endif
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($QData->Details as $key=>$item)
                                                <tr data-vendor-id="{{$item->VendorID}}"
                                                    data-detail-id="{{$item->DetailID}}">
                                                    <td>{{$key + 1}}</td>
                                                    <td>{{$item->ProductName}}</td>
                                                    <td>{{$item->Qty}} {{$item->UCode}}</td>
                                                    <td>{{!$item->isCancelled ? NumberFormat($item->Price, 2) : '--'}}</td>
                                                    <td>{{!$item->isCancelled ? $item->TaxType : '--'}}</td>
                                                    <td>{{!$item->isCancelled ? NumberFormat($item->Taxable, 2) : '--'}}</td>
                                                    <td>{{NumberFormat($item->TaxAmt, 2)}}</td>
                                                    <td>{{!$item->isCancelled ? NumberFormat($item->TotalAmt, 2) : '--'}}</td>
                                                    @if($QData->Status=="New")
                                                        <td class="text-center">
                                                            @if(!$item->isCancelled)
                                                                <button type="button"
                                                                        data-vendor-id="{{$item->VendorID}}"
                                                                        data-additional-charge="<?php if(array_key_exists($item->VendorID,$QData->AdditionalCharges)){ echo $QData->AdditionalCharges[$item->VendorID];}else{ echo 0;} ?>"
                                                                        data-detail-id="{{$item->DetailID}}"
                                                                        data-qno="{{$item->ProductName}}"
                                                                        data-id="{{$item->QID}}"
                                                                        class="btn btn-outline-danger btnQItemDelete"
                                                                        data-original-title="Delete"><i
                                                                        class="fa fa-trash" aria-hidden="true"></i>
                                                                </button>
                                                            @else
                                                                <span
                                                                    class=" fw-600 text-danger text-center">Cancelled</span>
                                                            @endif
                                                        </td>
                                                    @endif
                                                        <?php
                                                        $tmpAmount = 0;
                                                        if (array_key_exists($item->VendorID, $QData->AdditionalCharges)) {
                                                            $tmpAmount = $QData->AdditionalCharges[$item->VendorID];
                                                        }
                                                        $vendorAdditionalCharges[$item->VendorID] = ["name" => $item->VendorName, "amount" => $tmpAmount]
                                                        ?>
                                                    <td class="tdata"
                                                        style="display:none"><?php echo json_encode($item); ?></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <div class="row justify-content-end mt-20">
                                            <div class="col-sm-6">
                                                <div class="row fw-500 fs-13 mr-10 justify-content-end">
                                                    <div class="col-4">Sub Total</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col-3 text-right"
                                                         id="divSubTotal">{{NumberFormat($QData->SubTotal,2)}}</div>
                                                </div>
                                                <div class="row mt-1 fw-500 fs-13 mr-10 justify-content-end">
                                                    <div class="col-4">Tax Amount</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col-3 text-right"
                                                         id="divTaxAmount">{{NumberFormat($QData->TaxAmount,2)}}</div>
                                                </div>
                                                <div class="row mt-1 fw-600 fs-14 mr-10 justify-content-end">
                                                    <div class="col-4">Total Amount</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col-3 text-right"
                                                         id="divTotalAmount">{{NumberFormat($QData->TotalAmount,2)}}</div>
                                                </div>
                                                <div class="row mt-1 fw-500 fs-13 mr-10 justify-content-end">
                                                    <div class="col-4">Additional Amount @if($QData->Status=="New")
                                                            <a href="#" class="ml-5" id="btnEditCustomerCost"
                                                               title="Click here to edit customer additional charges."><i
                                                                    class="fa fa-pencil"></i></a>
                                                        @endif</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col-3 text-right"
                                                         id="divAdditionalAmount">{{NumberFormat($QData->AdditionalCost,2)}}</div>
                                                </div>
                                                <div
                                                    class="row mt-1 fw-800 fs-17 mr-10 justify-content-end text-success">
                                                    <div class="col-4">Net Amount</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col-3 text-right"
                                                         id="divOverAllAmount">{{NumberFormat($QData->NetAmount,2)}}</div>
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
                                <a href="{{ route('my-account', ['tab'=> 'quotations']) }}"
                                   class="btn btn-sm btn-outline-dark m-3">Back</a>
                                @if($QData->Status=="New")
                                    <button class="btn btn-sm btn-outline-danger m-3 btnCancelQuote" data-id="{{$QID}}">
                                        Cancel Quote
                                    </button>
                                    <button class="btn btn-sm btn-outline-success m-3 btnOrderConvert" data-id="{{$QID}}">
                                        Approve Quote
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade QuoteCancelModel" id="QuoteCancelModel" data-bs-backdrop="static" data-bs-keyboard="false"
         tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-md-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="QuoteCancelModelLabel">Quote Cancel</h1>
                    <button type="button" class="btn-close d-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="txtMQID" value="{{$QID}}">
                    <input type="hidden" id="txtMEnqID" value="{{$QData->EnqID}}">
                    <input type="hidden" id="txtMQDID">
                    <input type="hidden" id="txtMVendorID">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="txtCancelReason">Reason <span class="required">*</span></label>
                                <select id="lstMCancelReason" class="form-control select2"
                                        data-parent=".QuoteCancelModel">
                                    <option value="">Select a reason</option>
                                </select>
                                <div class="errors err-sm quote-cancel-err" id="lstMCancelReason-err"></div>
                            </div>
                        </div>
                        <div class="col-12 mt-1">
                            <div class="form-group">
                                <label for="txtMDescription">Description</label>
                                <textarea name="" id="txtMDescription" rows=4 class="form-control"></textarea>
                                <div class="errors err-sm quote-cancel-err" id="txtMDescription-err"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="btnSingleItemCloseM" data-bs-dismiss="modal">Close
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btnCancelQuote">Cancel Quote
                    </button>
                </div>
            </div>
        </div>
    </div>
{{--    <div class="modal fade  updateAdditionalCharges" id="updateAdditionalCharges" data-bs-backdrop="static"--}}
{{--         data-bs-keyboard="false" tabindex="-1">--}}
{{--        <div class="modal-dialog medium modal-fullscreen-lg-down">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h1 class="modal-title fs-15 fw-600" id="updateAdditionalChargesLabel">Additional Charges--}}
{{--                        Update</h1>--}}
{{--                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-12 table-responsive">--}}
{{--                            <table class="table table-sm" id="tblVACharges">--}}
{{--                                <thead>--}}
{{--                                <tr class="valign-top">--}}
{{--                                    <th class="text-center bg-dark  pl-5 pr-5">Vendor Name</th>--}}
{{--                                    <th class="text-center bg-dark pl-5 pr-5">Items</th>--}}
{{--                                    <th class="text-center bg-dark pl-5 pr-5">Additional Charges</th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody></tbody>--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close--}}
{{--                    </button>--}}
{{--                    <button type="button" class="btn btn-outline-primary btn-sm" id="btnUpdateCost">Update</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="modal fade  updateCACharges" id="updateCACharges" data-bs-backdrop="static" data-bs-keyboard="false"--}}
{{--         tabindex="-1">--}}
{{--        <div class="modal-dialog medium modal-fullscreen-lg-down">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h1 class="modal-title fs-15 fw-600" id="updateCAChargesLabel">Additional Charges Update</h1>--}}
{{--                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-12 mt-10">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="txtMCACost1">Customer Additional Charge</label>--}}
{{--                                <div class="input-group">--}}
{{--                                    <input type="number" step="{{Helper::NumberSteps(2)}}" id="txtMCACost1"--}}
{{--                                           class="form-control"--}}
{{--                                           value="<?php  echo NumberFormat($QData->AdditionalCost,2);?>">--}}
{{--                                    <span class="input-group-text"> for <span--}}
{{--                                            class="mr-5 ml-5">{{count($QData->Details)}}</span>  Items</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close--}}
{{--                    </button>--}}
{{--                    <button type="button" class="btn btn-outline-primary btn-sm" id="btnUpdateCustomerCost">Update--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="modal fade ApproveOrder" id="ApproveOrder" data-bs-backdrop="static" data-bs-keyboard="false"
         tabindex="-1">
        <div class="modal-dialog medium modal-fullscreen-lg-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="updateCAChargesLabel">Order Details</h1>
                    <button type="button" class="btn-close d-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mt-1">
                            <div class="form-group">
                                <label for="dtpDeliveryExpected">Expected Delivery</label>
                                <input type="date" id="dtpDeliveryExpected" class="form-control" min="{{date('Y-m-d')}}"
                                       value="<?php echo date("Y-m-d",strtotime(intval(10)." days")); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-1">
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="btnApproveCloseM" data-bs-dismiss="modal">Close
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btnMoveOrder">Proceed to Order
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('#lstMCancelReason').select2();
            let isItemCancel = false;
            var cancelReasons = {};
            const init = async () => {
                getCancelReason();
            }
            const getCancelReason = async () => {
                cancelReasons = {};
                $('#lstMCancelReason').select2('destroy');
                $('#lstMCancelReason option').remove();
                $('#lstMCancelReason').append('<option value="">Select a reason</option>');
                $.ajax({
                    type: "post",
                    url: "{{route('customer.quotes.get.cancel-reasons')}}",
                    headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                    dataType: "json",
                    success: function (response) {
                        for (let item of response) {
                            let selected = "";
                            cancelReasons[item.RReasonID] = item;
                            if (item.RReasonID == $('#lstMCancelReason').attr('data-selected')) {
                                selected = "selected";
                            }
                            $('#lstMCancelReason').append('<option ' + selected + ' value="' + item.RReasonID + '">' + item.RReason + '</option>');
                        }
                    }
                });
                $('#lstMCancelReason').select2({dropdownParent: $('.QuoteCancelModel')});
            }
            init();
            $(document).on('click', '#btnEditCustomerCost', function (e) {
                e.preventDefault();
                $('#updateCACharges').modal('show');
            });
            {{--$(document).on('click', '#btnUpdateCustomerCost', function (e) {--}}
            {{--    let formData = {};--}}
            {{--    formData.QID = "{{$QID}}";--}}
            {{--    formData.AdditionalCharges = $('#txtMCACost1').val();--}}
            {{--    $.ajax({--}}
            {{--        type: "post",--}}
            {{--        url: "{{route('customer.quotes.update.customer-cost',$QID)}}",--}}
            {{--        headers: {'X-CSRF-Token': '{{ csrf_token() }},--}}
            {{--        data: formData,--}}
            {{--        dataType: "json",--}}
            {{--        async: true,--}}
            {{--        beforeSend: function () {--}}
            {{--            ajaxIndicatorStart("The process of updating customer additional cost is currently in progress. Please wait a few seconds.")--}}
            {{--        },--}}
            {{--        complete: function (e, x, settings, exception) {--}}
            {{--            ajaxIndicatorStop()--}}
            {{--        },--}}
            {{--        success: function (response) {--}}
            {{--            if (response.status) {--}}
            {{--                $('#updateCACharges').modal('hide');--}}
            {{--                toastr.success(response.message, "", {--}}
            {{--                    positionClass: "toast-top-right",--}}
            {{--                    containerId: "toast-top-right",--}}
            {{--                    showMethod: "slideDown",--}}
            {{--                    hideMethod: "slideUp",--}}
            {{--                    progressBar: !0--}}
            {{--                })--}}
            {{--                window.location.reload();--}}
            {{--            } else {--}}
            {{--                toastr.error(response.message, "", {--}}
            {{--                    positionClass: "toast-top-right",--}}
            {{--                    containerId: "toast-top-right",--}}
            {{--                    showMethod: "slideDown",--}}
            {{--                    hideMethod: "slideUp",--}}
            {{--                    progressBar: !0--}}
            {{--                })--}}
            {{--            }--}}
            {{--        }--}}
            {{--    });--}}
            {{--});--}}
            $(document).on('click', '#btnEditVACharges', function (e) {
                e.preventDefault();
                const loadVAData = async () => {
                    $('#tblVACharges tbody tr').remove()
                    try {
                        let t = JSON.parse('<?php echo json_encode($vendorAdditionalCharges); ?>');
                        Object.keys(t).forEach(vendorId => {
                            let tdata = t[vendorId];
                            let VNoOfItems = $('#tblQuoteDetails tbody tr[data-vendor-id="' + vendorId + '"]').length;
                            let html = "<tr>";
                            html += '<td>' + tdata.name + '</td>';
                            html += '<td  class="text-right">' + VNoOfItems + '</td>';
                            html += '<td><input type="number" data-vendor-id="' + vendorId + '" class="form-control txtMVACosts" steps="{{Helper::NumberSteps(2)}}" value="' + tdata.amount + '"></td>';
                            html += '</tr>';
                            console.log(html);
                            $('#tblVACharges tbody').append(html);
                        })
                    } catch (error) {
                        console.log(error)
                    }
                }
                loadVAData();
                $('#updateAdditionalCharges').modal('show');
            });
            {{--$(document).on('click', '#btnUpdateCost', function (e) {--}}
            {{--    let details = {};--}}
            {{--    $('#tblVACharges tbody tr input.txtMVACosts').each(function (index) {--}}
            {{--        let VID = $(this).attr('data-vendor-id');--}}
            {{--        details[VID] = $(this).val()--}}
            {{--    });--}}
            {{--    let formData = {};--}}
            {{--    formData.QID = "{{$QID}}";--}}
            {{--    formData.EnqID = "{{$QData->EnqID}}";--}}
            {{--    formData.details = JSON.stringify(details);--}}
            {{--    $.ajax({--}}
            {{--        type: "post",--}}
            {{--        url: "{{route('customer.quotes.update.vendor-cost',$QID)}}",--}}
            {{--        headers: {'X-CSRF-Token': '{{ csrf_token() }},--}}
            {{--        data: formData,--}}
            {{--        dataType: "json",--}}
            {{--        async: true,--}}
            {{--        beforeSend: function () {--}}
            {{--            ajaxIndicatorStart("The process of updating vendor additional cost is currently in progress. Please wait a few seconds.")--}}
            {{--        },--}}
            {{--        complete: function (e, x, settings, exception) {--}}
            {{--            ajaxIndicatorStop()--}}
            {{--        },--}}
            {{--        success: function (response) {--}}
            {{--            if (response.status) {--}}
            {{--                $('#updateAdditionalCharges').modal('hide');--}}
            {{--                toastr.success(response.message, "", {--}}
            {{--                    positionClass: "toast-top-right",--}}
            {{--                    containerId: "toast-top-right",--}}
            {{--                    showMethod: "slideDown",--}}
            {{--                    hideMethod: "slideUp",--}}
            {{--                    progressBar: !0--}}
            {{--                })--}}
            {{--                window.location.reload();--}}
            {{--            } else {--}}
            {{--                toastr.error(response.message, "", {--}}
            {{--                    positionClass: "toast-top-right",--}}
            {{--                    containerId: "toast-top-right",--}}
            {{--                    showMethod: "slideDown",--}}
            {{--                    hideMethod: "slideUp",--}}
            {{--                    progressBar: !0--}}
            {{--                })--}}
            {{--            }--}}
            {{--        }--}}
            {{--    });--}}
            {{--});--}}
            $(document).on('click', '.btnQItemDelete', function () {

                isItemCancel = true;
                let ID = $(this).attr('data-id');
                let DID = $(this).attr('data-detail-id');
                let vendorId = $(this).attr('data-vendor-id');
                let AdditionalCharges = $(this).attr('data-additional-charge');
                let VNoOfItems = $('#tblQuoteDetails tbody tr[data-vendor-id="' + vendorId + '"]').length - 1
                let CNoOfItems = $('#tblQuoteDetails tbody tr').length - 1
                let QNo = $(this).attr('data-qno');
                let QuoteCancelModelLabel = "Item Cancel "
                QuoteCancelModelLabel += QNo != "" ? " - " + QNo : "";
                $('#QuoteCancelModelLabel').html(QuoteCancelModelLabel);
                $('#txtMQDID').val(DID);
                $('#txtMVendorID').val(vendorId);
                $('#txtMVACost').val(AdditionalCharges);
                $('#spaVNoOfItems').html(VNoOfItems);
                $('#spaCNoOfItems').html(CNoOfItems);
                if (VNoOfItems <= 0) {
                    $('.divMVACharge').hide();
                } else {
                    $('.divMVACharge').show();
                }
                if (CNoOfItems <= 0) {
                    $('.divMCACharge').hide();
                } else {
                    $('.divMCACharge').show();
                }
                $('#btnCancelQuote').html('Cancel Item');
                $('#QuoteCancelModel').modal('show');
            });
            $(document).on('click', '.btnCancelQuote', function () {
                isItemCancel = false;
                let ID = $(this).attr('data-id');
                let QNo = $(this).attr('data-qno');
                let QuoteCancelModelLabel = "Quote Cancel "
                QuoteCancelModelLabel += QNo != "" ? " - " + QNo : "";
                $('#QuoteCancelModelLabel').html(QuoteCancelModelLabel);
                $('#txtMQDID').val("");
                $('#txtMVendorID').val("");
                $('#btnCancelQuote').html('Cancel Quote');
                $('.divMVACharge').hide();
                $('.divMCACharge').hide();
                $('#QuoteCancelModel').modal('show');
            });
            $(document).on('click', '#btnCancelQuote', function () {
                debugger
                const validate = (formData) => {
                    let status = true;
                    $('.quote-cancel-err').html('');
                    if (formData.ReasonID == "") {
                        $('#lstMCancelReason-err').html('Reason is required.');
                        status = false;
                    }
                    // if (isItemCancel) {
                    //     if (formData.VACharges == "") {
                    //         $('#txtMVACost-err').html('The Vendor Additional Charge is required.');
                    //         status = false;
                    //     } else if ($.isNumeric(formData.VACharges) == false) {
                    //         $('#txtMVACost-err').html('The Vendor Additional Charge must be a numeric value.');
                    //         status = false;
                    //     } else if (parseFloat(formData.VACharges) < 0) {
                    //         $('#txtMVACost-err').html('The Vendor Additional Charge must be greater than or equal to 0.');
                    //         status = false;
                    //     }
                    //     if (formData.CACharges == "") {
                    //         $('#txtMCACost-err').html('The Customer Additional Charge is required.');
                    //         status = false;
                    //     } else if ($.isNumeric(formData.CACharges) == false) {
                    //         $('#txtMCACost-err').html('The Customer Additional Charge must be a numeric value.');
                    //         status = false;
                    //     } else if (parseFloat(formData.CACharges) < 0) {
                    //         $('#txtMCACost-err').html('The Customer Additional Charge must be greater than or equal to 0.');
                    //         status = false;
                    //     }
                    // }
                    return status;
                }
                let formData = {};
                formData.QID = $('#txtMQID').val();
                formData.QDID = $('#txtMQDID').val();
                formData.ReasonID = $('#lstMCancelReason').val();
                formData.Description = $('#txtMDescription').val();
                // formData.VACharges = $('#txtMVACost').val();
                // formData.CACharges = $('#txtMCACost').val();
                formData.EnqID = $('#txtMEnqID').val();
                formData.VendorID = $('#txtMVendorID').val();
                if (validate(formData) == true) {
                    $.ajax({
                        type: "post",
                        url: isItemCancel ? "{{route('customer.quotes.cancel-item','__ID__')}}".replace("__ID__", formData.QDID) : "{{route('customer.quotes.cancel','__ID__')}}".replace("__ID__", formData.QID),
                        headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                        data: formData,
                        dataType: "json",
                        async: true,
                        beforeSend: function () {
                            let text = isItemCancel ? "Quotation Item Cancellation on process." : "Quotation Cancellation on process.";
                            ajaxIndicatorStart(text)
                        },
                        complete: function (e, x, settings, exception) {
                            ajaxIndicatorStop()
                        },
                        success: function (response) {
                            if (response.status) {
                                $('#QuoteCancelModel').modal('hide');
                                toastr.success(response.message, "", {
                                    positionClass: "toast-top-right",
                                    containerId: "toast-top-right",
                                    showMethod: "slideDown",
                                    hideMethod: "slideUp",
                                    progressBar: !0
                                })
                                if(isItemCancel){
                                    toastr.success("Quotation Item Canceled successfully!.");
                                    window.location.reload();
                                } else {
                                    toastr.success("Quotation Canceled successfully!.")
                                    window.location.replace("{{ route('my-account', ['tab'=> 'quotations']) }}");
                                }
                            } else {
                                toastr.error(response.message, "", {
                                    positionClass: "toast-top-right",
                                    containerId: "toast-top-right",
                                    showMethod: "slideDown",
                                    hideMethod: "slideUp",
                                    progressBar: !0
                                })
                            }
                        }
                    });
                }
            });
            $(document).on('change', '#lstMCancelReason', function () {
                console.log(cancelReasons)
                try {
                    let ReasonID = $('#lstMCancelReason').val();
                    $('#txtMDescription').text(cancelReasons[ReasonID].Description);
                } catch (error) {
                    console.log(error);
                }
            });
            $(document).on('click', '.btnOrderConvert', function () {
                $('#ApproveOrder').modal('show');
            });
            $(document).on('click', '#btnSingleItemCloseM', function () {
                $('#QuoteCancelModel').modal('hide');
            });
            $(document).on('click', '#btnApproveCloseM', function () {
                $('#ApproveOrder').modal('hide');
            });
            $(document).on('click', '#btnMoveOrder', function () {
                swal({
                    title: "Are you sure?",
                    text: "You want to approve this order?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willApprove) => {
                        if (willApprove) {
                            $.ajax({
                                type: "post",
                                url: "{{route('customer.quotes.approve',$QID)}}",
                                headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                                data: {ExpectedDelivery: $('#dtpDeliveryExpected').val()},
                                dataType: "json",
                                async: true,
                                beforeSend: function () {
                                    ajaxIndicatorStart("The process of moving the quote to the order is currently in progress. Please wait for a few seconds.")
                                },
                                complete: function (e, x, settings, exception) {
                                    ajaxIndicatorStop()
                                },
                                success: function (response) {
                                    if (response.status) {
                                        $('#ApproveOrder').modal('hide');
                                        toastr.success(response.message, "", {
                                            positionClass: "toast-top-right",
                                            containerId: "toast-top-right",
                                            showMethod: "slideDown",
                                            hideMethod: "slideUp",
                                            progressBar: !0
                                        });
                                        toastr.success("Quotation order placed!.");
                                        window.location.replace("{{ url("/") }}/order/view/"+response.OrderID);
                                    } else {
                                        toastr.error(response.message, "", {
                                            positionClass: "toast-top-right",
                                            containerId: "toast-top-right",
                                            showMethod: "slideDown",
                                            hideMethod: "slideUp",
                                            progressBar: !0
                                        });
                                    }
                                }
                            });
                        } else {
                            swal.close();
                        }
                    });

                {{--swal({--}}
                {{--    title: "Are you sure?",--}}
                {{--    text: "Do you want to move this quote to an order?",--}}
                {{--    type: "warning",--}}
                {{--    showCancelButton: true,--}}
                {{--    confirmButtonClass: "btn-outline-success",--}}
                {{--    confirmButtonText: "Move",--}}
                {{--    closeOnConfirm: false--}}
                {{--}, function () {--}}
                {{--    swal.close();--}}
                {{--    $.ajax({--}}
                {{--        type: "post",--}}
                {{--        url: "{{route('customer.quotes.approve',$QID)}}",--}}
                {{--        headers: {'X-CSRF-Token': '{{ csrf_token() }}'},--}}
                {{--        data: {ExpectedDelivery: $('#dtpDeliveryExpected').val()},--}}
                {{--        dataType: "json",--}}
                {{--        async: true,--}}
                {{--        beforeSend: function () {--}}
                {{--            ajaxIndicatorStart("The process of moving the quote to the order is currently in progress. Please wait for a few seconds.")--}}
                {{--        },--}}
                {{--        complete: function (e, x, settings, exception) {--}}
                {{--            ajaxIndicatorStop()--}}
                {{--        },--}}
                {{--        success: function (response) {--}}
                {{--            if (response.status) {--}}
                {{--                $('#ApproveOrder').modal('hide');--}}
                {{--                toastr.success(response.message, "", {--}}
                {{--                    positionClass: "toast-top-right",--}}
                {{--                    containerId: "toast-top-right",--}}
                {{--                    showMethod: "slideDown",--}}
                {{--                    hideMethod: "slideUp",--}}
                {{--                    progressBar: !0--}}
                {{--                })--}}
                {{--                window.location.reload();--}}
                {{--            } else {--}}
                {{--                toastr.error(response.message, "", {--}}
                {{--                    positionClass: "toast-top-right",--}}
                {{--                    containerId: "toast-top-right",--}}
                {{--                    showMethod: "slideDown",--}}
                {{--                    hideMethod: "slideUp",--}}
                {{--                    progressBar: !0--}}
                {{--                })--}}
                {{--            }--}}
                {{--        }--}}
                {{--    });--}}
                {{--});--}}
            });
        });
    </script>
@endsection
