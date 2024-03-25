@extends('home.home-layout')
@section('content')
<style>
    .checkout-progress-bar {
        margin: 2.7rem 0 -2.9rem;
        font-size: 0;
        line-height: 1.4;
    }

    .stamp-badge {
        padding: 3px 6px;
        margin: -10px;
        z-index: 1;
    }
    .valign-top th{
        vertical-align:top !important;
    }
    .otp-form .inputs input {
        width: 40px;
        height: 40px
    }

    .otp-form input[type=number]::-webkit-inner-spin-button,
    .otp-form input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0
    }
    .otp-form .form-control:focus {
        box-shadow: none;
        border: 2px solid red
    }
    .otp-form  .validate {
        border-radius: 20px;
        height: 40px;
        background-color: red;
        border: 1px solid red;
        width: 140px
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

    td {
        text-align: center;
    }
</style>
{{--<div class="container">--}}
{{--	<div class="page-header">--}}
{{--		<div class="row">--}}
{{--			<div class="col-sm-6">--}}
{{--				<ol class="breadcrumb">--}}
{{--					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>--}}
{{--                    <li class="breadcrumb-item"><a href="{{ route('my-account', ['tab' => 'orders']) }}" data-original-title="" title="">My Account</a></li>--}}
{{--					<li class="breadcrumb-item"><a href="{{ url('/') }}/admin/transaction/order/" data-original-title="" title="">{{$PageTitle}}</a></li>--}}
{{--                    <li class="breadcrumb-item">Order View</li>--}}
{{--				</ol>--}}
{{--			</div>--}}
{{--            <div class="col-sm-6 text-right">--}}
{{--                    <a href="{{ route('my-account', ['tab' => 'orders']) }}" class="btn btn-sm btn-outline-dark m-5">Back</a>--}}
{{--                @if($OData->Status!="Cancelled" && $OData->Status!="Delivered")--}}
{{--                    <button class="btn btn-sm btn-outline-danger m-5 btnCancelOrder" data-id="{{$OrderID}}">Cancel Order</button>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--		</div>--}}
{{--	</div>--}}
{{--</div>--}}
<?php
    $vendorAdditionalCharges=[];
?>
<div class="container">
	<div class="row d-flex justify-content-center">
		<div class="col-12 col-sm-12 col-lg-12">
			<div class="card">
                <ul class="checkout-progress-bar d-flex justify-content-center flex-wrap">
                    <li class="active">
                        <a href="#">Order - ( {{$OData->OrderNo}} )</a>
                    </li>
                </ul>
{{--				<div class="card-header text-center"><h5 class="mt-10"> Order - ( {{$OData->OrderNo}} )</h5></div>--}}
				<div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row justify-content-center">
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-header p-6">
                                            <p class="text-center fs-16 fw-500">Billing Address</p>
                                        </div>
                                        <div class="card-body">
                                            <?php
                                                $Address="";
                                                // if($OData->CustomerName!=""){$Address.="<b>".$OData->CustomerName."</b>";}
                                                if($OData->BAddress!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$OData->BAddress;}
                                                if($OData->BCityName!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$OData->BCityName;}
                                                if($OData->BTalukName!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$OData->BTalukName;}
                                                if($OData->BDistrictName!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$OData->BDistrictName;}
                                                if($OData->BStateName!=""){if($Address!=""){$Address.=",<br>";}$Address.=$OData->BStateName;}
                                                if($OData->BCountryName!=""){if($Address!=""){$Address.=", ";}$Address.=$OData->BCountryName;}
                                                if($OData->BPostalCode!=""){if($Address!=""){$Address.=" - ";}$Address.=$OData->BPostalCode;}
                                                if($Address!=""){$Address.=".";}
                                                echo  $Address;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-header p-6">
                                            <p class="text-center fs-16 fw-500">Shipping Address</p>
                                        </div>
                                        <div class="card-body">
                                            <?php
                                                $DAddress="";
                                                if($OData->DAddress!=""){if($DAddress!=""){$DAddress.=",<br> ";}$DAddress.=$OData->DAddress;}
                                                if($OData->DCityName!=""){if($DAddress!=""){$DAddress.=",<br> ";}$DAddress.=$OData->DCityName;}
                                                if($OData->DTalukName!=""){if($DAddress!=""){$DAddress.=",<br> ";}$DAddress.=$OData->DTalukName;}
                                                if($OData->DDistrictName!=""){if($DAddress!=""){$DAddress.=",<br> ";}$DAddress.=$OData->DDistrictName;}
                                                if($OData->DStateName!=""){if($DAddress!=""){$DAddress.=",<br>";}$DAddress.=$OData->DStateName;}
                                                if($OData->DCountryName!=""){if($DAddress!=""){$DAddress.=", ";}$DAddress.=$OData->DCountryName;}
                                                if($OData->DPostalCode!=""){if($DAddress!=""){$DAddress.=" - ";}$DAddress.=$OData->DPostalCode;}
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
                                    <h6 class="text-center fw-700">Order</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-wishlist" id="tblOrderDetails">
                                        <thead>
                                            <tr class="valign-top">
                                                <th class="text-center align-middle">S.No</th>
                                                <th class="text-center align-middle">Product Name</th>
                                                <th class="text-center align-middle">Qty</th>
                                                <th class="text-center align-middle">Price<br> (₹)</th>
                                                <th class="text-center align-middle">Tax Type</th>
                                                <th class="text-center align-middle">Taxable<br> (₹)</th>
                                                <!---->
{{--                                                @if(count($OData->Details)>0)--}}
{{--                                                    @if(floatval($OData->Details[0]->IGSTAmt)<=0)--}}
{{--                                                        <th class="text-center align-middle">CGST<br> (₹)</th>--}}
{{--                                                        <th class="text-center align-middle">SGST<br> (₹)</th>--}}
{{--                                                    @else--}}
{{--                                                        <th class="text-center align-middle">IGST<br> (₹)</th>--}}
{{--                                                    @endif--}}
{{--                                                @else--}}
                                                    <th class="text-center align-middle">Tax Amount<br> (₹)</th>
{{--                                                @endif--}}
                                                <th class="text-center align-middle">Total Amount<br> (₹)</th>
{{--                                                <th class="text-center align-middle">Allocated To</th>--}}
                                                <th class="text-center align-middle">Status</th>
                                                <th class="text-center align-middle">Delivered On</th>
{{--                                                @if($OData->Status=="New")--}}
{{--                                                    <th class="text-center align-middle">Action</th>--}}
{{--                                                @endif--}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($OData->Details as $key=>$item)
                                                <?php
                                                $item->Status =$OData->Status=="Cancelled"?$OData->Status:$item->Status;
                                                ?>
                                                <tr data-status="{{$item->Status}}" data-vendor-id="{{$item->VendorID}}" data-detail-id="{{$item->DetailID}}">
                                                    <td>{{$key + 1}}</td>
                                                    <td>{{$item->ProductName}}</td>
                                                    <td class="text-right">{{$item->Qty}} {{$item->UCode}}</td>
                                                    <td class="text-right">{{NumberFormat($item->Price, 2)}}</td>
                                                    <td>{{$item->TaxType}}</td>
                                                    <td class="text-right">{{ $item->Status == 'Cancelled' ? '--' : NumberFormat($item->Taxable, 2) }}</td>
                                                    {{--                                                    @if(count($OData->Details)>0)--}}
                                                    {{--                                                        @if(floatval($item->IGSTAmt)<=0)--}}
                                                    {{--                                                            <td class="text-right">--}}
                                                    {{--                                                                <div>{{ $item->Status == 'Cancelled' ? '--' : NumberFormat($item->CGSTAmt, 2) }} </div>--}}
                                                    {{--                                                                <div class="fs-11">{{ $item->Status == 'Cancelled' ? '' : "(".NumberFormat($item->CGSTPer, 2)." %)" }}</div>--}}
                                                    {{--                                                            </td>--}}
                                                    {{--                                                            <td class="text-right">--}}
                                                    {{--                                                                <div>{{ $item->Status == 'Cancelled' ? '--' : NumberFormat($item->SGSTAmt, 2) }} </div>--}}
                                                    {{--                                                                <div class="fs-11">{{ $item->Status == 'Cancelled' ? '' : "(".NumberFormat($item->SGSTPer, 2)." %)" }}</div>--}}
                                                    {{--                                                            </td>--}}
                                                    {{--                                                        @else--}}
                                                    {{--                                                            <td class="text-right">--}}
                                                    {{--                                                                <div>{{ $item->Status == 'Cancelled' ? '--' : NumberFormat($item->IGSTAmt, 2) }} </div>--}}
                                                    {{--                                                                <div class="fs-11">{{ $item->Status == 'Cancelled' ? '' : "(".NumberFormat($item->IGSTPer, 2)." %)" }}</div>--}}
                                                    {{--                                                            </td>--}}
                                                    {{--                                                        @endif--}}
                                                    {{--                                                    @else--}}
                                                    <td class="text-right">{{ $item->Status == 'Cancelled' ? '--' : NumberFormat(($item->TaxAmt ?? 0), 2) }}</td>
                                                    {{--                                                    @endif--}}
                                                    <td class="text-right">{{ $item->Status == 'Cancelled' ? '--' : NumberFormat($item->TotalAmt, 2) }} </td>
                                                    {{--                                                    <td><span class=" fw-600 text-info text-center">{{$item->VendorName}}</span></td>--}}
                                                    <td>
                                                        @if($item->Status=="Cancelled")
                                                            <span class="badge badge-danger">Cancelled</span>
                                                        @elseif($item->Status=="Delivered")
                                                            <span class="badge badge-success">Delivered</span>
                                                        @else
                                                            <span class="badge badge-primary">Not Delivered</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if($item->Status=="Delivered")
                                                            {{date('d-M-Y',strtotime($item->DeliveredOn))}}
                                                        @else
                                                            --
                                                        @endif
                                                    </td>
{{--                                                    @if($OData->Status!="Delivered" && $OData->Status!="Cencelled"  && $item->Status=="New")--}}
{{--                                                        <td class="text-center">--}}
{{--                                                            <button type="button"  data-vendor-id="{{$item->VendorID}}" data-additional-charge="<?php if(array_key_exists($item->VendorID,$OData->AdditionalCharges)){ echo $OData->AdditionalCharges[$item->VendorID];}else{ echo 0;} ?>" data-detail-id="{{$item->DetailID}}" data-order-no="{{$item->ProductName}}" data-id="{{$item->OrderID}}" class="btn m-5 btn-outline-success btnItemMarkDelivered" title="Mark this item as Delivered"><i class="fa fa-check"></i></button>--}}
{{--                                                            <button type="button"  data-vendor-id="{{$item->VendorID}}" data-additional-charge="<?php if(array_key_exists($item->VendorID,$OData->AdditionalCharges)){ echo $OData->AdditionalCharges[$item->VendorID];}else{ echo 0;} ?>" data-detail-id="{{$item->DetailID}}" data-order-no="{{$item->ProductName}}" data-id="{{$item->OrderID}}" class="btn m-5 btn-outline-danger btnOItemDelete" -title="Item Cancel"><i class="fa fa-trash" aria-hidden="true"></i></button>--}}

{{--                                                        </td>--}}
{{--                                                    @endif--}}
                                                    <?php
                                                        if($item->Status!="Cancelled"){
                                                            $tmpAmount=0;
                                                            if(array_key_exists($item->VendorID,$OData->AdditionalCharges)){ $tmpAmount=$OData->AdditionalCharges[$item->VendorID];}
                                                            $vendorAdditionalCharges[$item->VendorID]=["name"=>$item->VendorName,"amount"=>$tmpAmount];
                                                        }
                                                    ?>
                                                    <td class="tdata" style="display:none"><?php echo json_encode($item); ?></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="row justify-content-end mt-20">
                                        @if(count($vendorAdditionalCharges)>0)
                                        <div class="col-sm-6 d-none">
                                            <div class="card shadow-sm">
                                                <div class="card-header">
                                                    <div class="row">
                                                        <div class="col-2"></div>
                                                        <div class="col-8 text-center fw-600">Vendor Additional Charges</div>
                                                        <div class="col-2 text-right"> @if($OData->Status=="New")<a href="#" id="btnEditVACharges" title="Update Vendor's Additional Costs"><i class="fa fa-pencil" ></i></a> @endif</div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    @foreach ($vendorAdditionalCharges as $VendorID=>$VData)
                                                        <div class="row mt-10">
                                                            <div class="col-4">{{$VData['name']}}</div>
                                                            <div class="col-8 d-flex align-items-center">: {{$VData['amount']}}</div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-sm-6">
                                            <div class="row fw-500 fs-13 mr-10 justify-content-end">
                                                <div class="col-4">Sub Total</div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divSubTotal">{{NumberFormat($OData->SubTotal,2)}}</div>
                                            </div>
{{--                                            @if(count($OData->Details)>0)--}}
{{--                                                @if(floatval($OData->IGSTAmount)<=0)--}}
{{--                                                    <div class="row mt-1 fw-500 fs-13 mr-10 justify-content-end">--}}
{{--                                                        <div class="col-4">CGST</div>--}}
{{--                                                        <div class="col-1">:</div>--}}
{{--                                                        <div class="col-3 text-right" id="divCGSTAmount">{{NumberFormat($OData->CGSTAmount,2)}}</div>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="row mt-1 fw-500 fs-13 mr-10 justify-content-end">--}}
{{--                                                        <div class="col-4">SGST</div>--}}
{{--                                                        <div class="col-1">:</div>--}}
{{--                                                        <div class="col-3 text-right" id="divSGSTAmount">{{NumberFormat($OData->SGSTAmount,2)}}</div>--}}
{{--                                                    </div>--}}
{{--                                                @else--}}
{{--                                                    <div class="row mt-1 fw-500 fs-13 mr-10 justify-content-end">--}}
{{--                                                        <div class="col-4">IGST</div>--}}
{{--                                                        <div class="col-1">:</div>--}}
{{--                                                        <div class="col-3 text-right" id="divIGSTAmount">{{NumberFormat($OData->IGSTAmount,2)}}</div>--}}
{{--                                                    </div>--}}
{{--                                                @endif--}}
{{--                                            @else--}}

                                                <div class="row mt-1 fw-500 fs-13 mr-10 justify-content-end">
                                                    <div class="col-4">Tax Amount</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col-3 text-right" id="divTaxAmount">{{NumberFormat($OData->TaxAmount,2)}}</div>
                                                </div>
{{--                                            @endif--}}
                                            <div class="row mt-1 fw-600 fs-14 mr-10 justify-content-end">
                                                <div class="col-4">Total Amount</div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divTotalAmount">{{NumberFormat($OData->TotalAmount,2)}}</div>
                                            </div>
                                            <div class="row mt-1 fw-500 fs-13 mr-10 justify-content-end">
                                                <div class="col-4">Additional Amount @if($OData->Status=="New") <a href="#" class="ml-5" id="btnEditCustomerCost" title="Click here to edit customer additional charges."><i class="fa fa-pencil"></i></a> @endif</div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divAdditionalAmount">{{NumberFormat($OData->AdditionalCost,2)}}</div>
                                            </div>
                                            <div class="row mt-1 fw-800 fs-17 mr-10 justify-content-end text-success">
                                                <div class="col-4">Net Amount</div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divOverAllAmount">{{NumberFormat($OData->NetAmount,2)}}</div>
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
                                <a href="{{ route('my-account', ['tab' => 'orders']) }}" class="btn btn-sm btn-outline-dark m-5" >Back</a>
                            @if($OData->Status!="Cancelled" && $OData->Status!="Delivered")
{{--                                    <button class="btn btn-sm btn-outline-danger m-5 btnCancelOrder" data-id="{{$OrderID}}">Cancel Order</button>--}}
                            @endif
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade OrderCancelModel" id="OrderCancelModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered modal-fullscreen-md-down">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-15 fw-600" id="OrderCancelModelLabel">Order Cancel</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="txtMOrderID" value="{{$OrderID}}">
				<input type="hidden" id="txtMEnqID" value="{{$OData->EnqID}}">
				<input type="hidden" id="txtMODID">
				<input type="hidden" id="txtMVendorID">
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label for="txtCancelReason">Reason <span class="required">*</span></label>
							<select id="lstMCancelReason" class="form-control select2" data-parent=".OrderCancelModel">
								<option value="">Select a reason</option>
							</select>
                            <div class="errors err-sm order-cancel-err" id="lstMCancelReason-err"></div>
						</div>
					</div>
					<div class="col-12 mt-10">
						<div class="form-group">
							<label for="txtMDescription">Description</label>
							<textarea name="" id="txtMDescription" rows=4 class="form-control"></textarea>
                            <div class="errors err-sm order-cancel-err" id="txtMDescription-err"></div>
						</div>
					</div>
				</div>
                <div class="row">
					<div class="col-12 mt-10 divMVACharge">
						<div class="form-group">
							<label for="spaVNoOfItems">Vendor Additional Charge</label>
							<div class="input-group">
                                <input type="number" step="{{Helper::NumberSteps(2)}}" id="txtMVACost" class="form-control" >
                                <span class="input-group-text"> for <span id="spaVNoOfItems" class="mr-5 ml-5">0</span>  Items</span>
                            </div>
                            <div class="errors err-sm order-cancel-err" id="txtMVACost-err"></div>
						</div>
					</div>
					<div class="col-12 mt-10 divMCACharge">
						<div class="form-group">
							<label for="txtMCACost">Customer Additional Charge</label>
							<div class="input-group">
                                <input type="number" step="{{Helper::NumberSteps(2)}}" id="txtMCACost" class="form-control" value="<?php  echo NumberFormat($OData->AdditionalCost,2);?>">
                                <span class="input-group-text"> for <span id="spaCNoOfItems" class="mr-5 ml-5">{{count($OData->Details)}}</span>  Items</span>
                            </div>
                            <div class="errors err-sm order-cancel-err" id="txtMCACost-err"></div>
						</div>
					</div>
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-outline-primary btn-sm" id="btnCancelOrder">Cancel Order</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade  updateAdditionalCharges" id="updateAdditionalCharges" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
	<div class="modal-dialog medium modal-fullscreen-lg-down">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-15 fw-600" id="updateAdditionalChargesLabel">Additional Charges Update</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-sm" id="tblVACharges">
                            <thead>
                                <tr class="valign-top">
                                    <th class="text-center bg-dark  pl-5 pr-5">Vendor Name</th>
                                    <th class="text-center bg-dark pl-5 pr-5">Items</th>
                                    <th class="text-center bg-dark pl-5 pr-5">Additional Charges</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-outline-primary btn-sm" id="btnUpdateCost">Update</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade  updateCACharges" id="updateCACharges" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
	<div class="modal-dialog medium modal-fullscreen-lg-down">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-15 fw-600" id="updateCAChargesLabel">Additional Charges Update</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
                <div class="row">
					<div class="col-12 mt-10">
						<div class="form-group">
							<label for="txtMCACost1">Customer Additional Charge</label>
							<div class="input-group">
                                <input type="number" step="{{Helper::NumberSteps(2)}}" id="txtMCACost1" class="form-control" value="<?php  echo NumberFormat($OData->AdditionalCost,2);?>">
                                <span class="input-group-text"> for <span d="spaCNoOfItems1" class="mr-5 ml-5">{{count($OData->Details)}}</span>  Items</span>
                            </div>
						</div>
					</div>
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-outline-primary btn-sm" id="btnUpdateCustomerCost">Update</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade  DeliveryConfirmModal" id="DeliveryConfirmModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
	<div class="modal-dialog medium modal-fullscreen-lg-down">
		<div class="modal-content">
			<div class="modal-body text-center otp-form">
                <h6>Please enter the one-time password <br> to confirm delivery </h6>
                <div class="fs-12"> <span>The verification code has been sent to </span> <small><?php echo '*******' . substr($OData->MobileNo1, -4); ?></small> </div>
                <div id="otp" class="inputs d-flex flex-row justify-content-center mt-20 w-100">
                    <input class="m-2 text-center form-control rounded otp-input" type="text" id="txtFirst" maxlength="1" />
                    <input class="m-2 text-center form-control rounded otp-input" type="text" id="txtSecond" maxlength="1" />
                    <input class="m-2 text-center form-control rounded otp-input" type="text" id="txtThird" maxlength="1" />
                    <input class="m-2 text-center form-control rounded otp-input" type="text" id="txtFourth" maxlength="1" />
                    <input class="m-2 text-center form-control rounded otp-input" type="text" id="txtFifth" maxlength="1" />
                    <input class="m-2 text-center form-control rounded otp-input" type="text" id="txtSixth" maxlength="1" />
                </div>
                <p class="resend text-muted fs-13 mb-0 mt-20">Didn't receive code? <a href="#" id="btnResend">Resend again <span id="countdown"></span></a>
                <input type="hidden" id="txtMDOrderID" value="{{$OrderID}}">
                <input type="hidden" id="txtMDDetailID" value="">
                <input type="hidden" id="txtMDMobileNumber" value="{{$OData->PhoneCode.$OData->MobileNo1}}">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-outline-primary btn-sm" id="btnMarkAsDelivered">Confirm</button>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        let isItemCancel=false;
        let isItemDelivered=false;
		var cancelReasons={};
        var ResendOTP=false;
        const enableOTPVerify = true;
        const OTPResendDuration=parseInt(40);
        var countdownValue =OTPResendDuration;
        const init=async()=>{
            getCancelReason();
            OTPInput();
        }
		const getCancelReason=async()=>{
			cancelReasons={};
			$('#lstMCancelReason').select2('destroy');
			$('#lstMCancelReason option').remove();
			$('#lstMCancelReason').append('<option value="">Select a reason</option>');
			$.ajax({
            	type:"post",
                url:"{{route('admin.transaction.quotes.get.cancel-reasons')}}",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                success:function(response){
					for(let item of response){
						let selected="";
						cancelReasons[item.RReasonID]=item;
						if(item.RReasonID==$('#lstMCancelReason').attr('data-selected')){selected="selected";}
						$('#lstMCancelReason').append('<option '+selected+' value="'+item.RReasonID+'">'+item.RReason+'</option>');
					}
                }
            });
			$('#lstMCancelReason').select2({ dropdownParent: $('.OrderCancelModel')});
		}
        const timerStart=async()=>{console.log(12);
            const getTimerFormat=()=>{
                var minutes = Math.floor(countdownValue / 60);
                var remainingSeconds = countdownValue % 60;

                // Add leading zeros for single-digit minutes and seconds
                minutes = minutes < 10 ? "0" + minutes : minutes;
                remainingSeconds = remainingSeconds < 10 ? "0" + remainingSeconds : remainingSeconds;
                // Update the display
                $("#countdown").text(" ("+minutes + ":" + remainingSeconds+")");
            }
            const updateCountdown=async()=>{
                getTimerFormat();
                countdownValue--;
                if (countdownValue < 0) {
                    $('#btnResend').css('cursor','pointer');
                    clearInterval(timerInterval);
                    ResendOTP=true;
                    $('#btnResend').removeClass('text-secondary');
                    $('#countdown').text("");
                }
            }
            countdownValue = OTPResendDuration;
            $('#btnResend').css('cursor','unset');
            var timerInterval = setInterval(updateCountdown, 1000);
            ResendOTP=false;
        }
        const OTPInput = () => {
            const inputs = document.querySelectorAll('#otp > .otp-input');
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener('keydown', function(event) {
                    if (event.keyCode >= 96 && event.keyCode <= 105) {
                        inputs[i].value = event.key;
                        if (i !== inputs.length - 1) inputs[i + 1].focus();
                        event.preventDefault();
                        return;
                    }
                    if (event.key === "Backspace") {
                        inputs[i].value = '';
                        if (i !== 0) inputs[i - 1].focus();
                    } else {
                        if (i === inputs.length - 1 && inputs[i].value !== '') {
                            return true;
                        } else if (event.keyCode > 47 && event.keyCode < 58) {
                            inputs[i].value = event.key;
                            if (i !== inputs.length - 1) inputs[i + 1].focus();
                            event.preventDefault();
                        } else if (event.keyCode > 64 && event.keyCode < 91) {
                            inputs[i].value = String.fromCharCode(event.keyCode);
                            if (i !== inputs.length - 1) inputs[i + 1].focus();
                            event.preventDefault();
                        }
                    }
                });
            }
        }
        const sendOTP = async () => {
            return await new Promise(async(resolve,reject)=>{
                let MobileNumber =  $('#txtMDMobileNumber').val();
                $.ajax({
                    type: "post",
                    url: "{{route('admin.transaction.orders.send-otp')}}",
                    headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')},
                    data: {OrderID:"{{$OrderID}}",detailID:$('#txtMDDetailID').val(),MobileNumber},
                    dataType: "json",
                    async: true,
                    error:(e, x, settings, exception)=>{resolve({status:false});},
                    success:(response)=>{
                        $('#txtFirst').focus();
                        $('#btnResend').addClass('text-secondary');
                        timerStart();
                        resolve(response);
                    }
                });
            });
        }
        const getOTP=()=>{
            let OTP ="";
                OTP+=$('#txtFirst').val().toString();
                OTP+=$('#txtSecond').val().toString();
                OTP+=$('#txtThird').val().toString();
                OTP+=$('#txtFourth').val().toString();
                OTP+=$('#txtFifth').val().toString();
                OTP+=$('#txtSixth').val().toString();
            return OTP;
        }
        const markAsDelivered=async()=>{
            let OrderID="{{$OrderID}}",detailID=$('#txtMDDetailID').val(),OTP=getOTP();
            $.ajax({
                type:"post",
                url: isItemDelivered? "{{route('admin.transaction.orders.mark-delivered.item')}}":"{{route('admin.transaction.orders.mark-delivered')}}",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:{OrderID,detailID,OTP},
                dataType:"json",
                async:true,
                beforeSend:function(){
                    ajaxIndicatorStart ("The process of moving the order to delivery is currently in progress. Please wait for a few minutes.")
                },
                complete: function(e, x, settings, exception){ajaxIndicatorStop ()},
                success:function(response){
                    if(response.status){
                        $('#DeliveryConfirmModal').modal('hide');
                        toastr.success(response.message, "", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
                        window.location.reload();
                    }else{
                        toastr.error(response.message, "", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
                    }
                }
            });
        }
        init();
        $(document).on('click','#btnEditCustomerCost',function(e){
            e.preventDefault();
            let CNoOfItems=$('#tblOrderDetails tbody tr:not([data-status="Cancelled"]').length-1
            $('#spaCNoOfItems1').html(CNoOfItems);
            $('#updateCACharges').modal('show');
        });
        $(document).on('click','#btnUpdateCustomerCost',function(e){
			let formData={};
			formData.OrderID="{{$OrderID}}";
			formData.AdditionalCharges=$('#txtMCACost1').val();
			$.ajax({
                type:"post",
                url: "{{route('admin.transaction.orders.update.customer-cost',$OrderID)}}",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
				data:formData,
                dataType:"json",
                async:true,
				beforeSend:function(){
					ajaxIndicatorStart ("The process of updating customer additional cost is currently in progress. Please wait a few seconds.")
				},
                complete: function(e, x, settings, exception){
					ajaxIndicatorStop ()
				},
                success:function(response){
					if(response.status){
						$('#updateCACharges').modal('hide');
						toastr.success(response.message, "", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
                        window.location.reload();
					}else{
						toastr.error(response.message, "", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
					}
                }
            });
        });
        $(document).on('click','#btnEditVACharges',function(e){
            e.preventDefault();
            const loadVAData=async()=>{
                $('#tblVACharges tbody tr').remove()
                try {
                    let t=JSON.parse('<?php echo json_encode($vendorAdditionalCharges); ?>');
                    Object.keys(t).forEach(vendorId => {
                        let tdata=t[vendorId];
                        let VNoOfItems=$('#tblOrderDetails tbody tr[data-vendor-id="'+vendorId+'"]:not([data-status="Cancelled"]').length;
                        if(VNoOfItems>0){
                            let html="<tr>";
                                    html+='<td>'+tdata.name+'</td>';
                                    html+='<td  class="text-right">'+VNoOfItems+'</td>';
                                    html+='<td class="text-right"><input type="number" data-vendor-id="'+vendorId+'" class="form-control txtMVACosts" steps="{{Helper::NumberSteps(2)}}" value="'+tdata.amount+'"></td>';
                                html+='</tr>';
                                console.log(html);
                                $('#tblVACharges tbody').append(html);
                        }
                    })
                } catch (error) {
                    console.log(error)
                }
            }
            loadVAData();
            $('#updateAdditionalCharges').modal('show');
        });
        $(document).on('click','#btnUpdateCost',function(e){
            let details={};
            $('#tblVACharges tbody tr input.txtMVACosts').each(function(index){
                let VID=$(this).attr('data-vendor-id');
                details[VID]=$(this).val()
            });
			let formData={};
			formData.OrderID="{{$OrderID}}";
			formData.EnqID="{{$OData->EnqID}}";
			formData.details=JSON.stringify(details);
			$.ajax({
                type:"post",
                url: "{{route('admin.transaction.orders.update.vendor-cost',$OrderID)}}",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
				data:formData,
                dataType:"json",
                async:true,
				beforeSend:function(){
					ajaxIndicatorStart ("The process of updating vendor additional cost is currently in progress. Please wait a few seconds.")
				},
                complete: function(e, x, settings, exception){
					ajaxIndicatorStop ()
				},
                success:function(response){
					if(response.status){
						$('#updateAdditionalCharges').modal('hide');
						toastr.success(response.message, "", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
                        window.location.reload();
					}else{
						toastr.error(response.message, "", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
					}
                }
            });
        });
		$(document).on('click','.btnOItemDelete',function(){

            isItemCancel=true;
			let ID=$(this).attr('data-id');
			let DID=$(this).attr('data-detail-id');
			let vendorId=$(this).attr('data-vendor-id');
            let AdditionalCharges=$(this).attr('data-additional-charge');
            let VNoOfItems=$('#tblOrderDetails tbody tr[data-vendor-id="'+vendorId+'"]:not([data-status="Cancelled"]').length-1
            let CNoOfItems=$('#tblOrderDetails tbody tr:not([data-status="Cancelled"]').length-1
			let OrderNo=$(this).attr('data-order-no');
			let OrderCancelModelLabel="Item Cancel "
			OrderCancelModelLabel+=OrderNo!=""?" - "+OrderNo:"";
			$('#OrderCancelModelLabel').html(OrderCancelModelLabel);
			$('#txtMODID').val(DID);
			$('#txtMVendorID').val(vendorId);
			$('#txtMVACost').val(AdditionalCharges);
			$('#spaVNoOfItems').html(VNoOfItems);
            $('#spaCNoOfItems').html(CNoOfItems);
            if(VNoOfItems<=0){
                $('.divMVACharge').hide();
            }else{
                $('.divMVACharge').show();
            }
            if(CNoOfItems<=0){
                $('.divMCACharge').hide();
            }else{
                $('.divMCACharge').show();
            }
            $('#btnCancelOrder').html('Cancel Item');
			$('#OrderCancelModel').modal('show');
		});
		$(document).on('click','.btnCancelOrder',function(){
            isItemCancel=false;
			let ID=$(this).attr('data-id');
			let OrderNo=$(this).attr('data-order-no');
			let OrderCancelModelLabel="Order Cancel "
			OrderCancelModelLabel+=OrderNo!=""?" - "+OrderNo:"";
			$('#OrderCancelModelLabel').html(OrderCancelModelLabel);
			$('#txtMODID').val("");
			$('#txtMVendorID').val("");
            $('#btnCancelOrder').html('Cancel Order');
            $('.divMVACharge').hide();
            $('.divMCACharge').hide();
			$('#OrderCancelModel').modal('show');
		});
		$(document).on('click','#btnCancelOrder',function(){
            const validate=(formData)=>{
                let status=true;
                $('.order-cancel-err').html('');
                if(formData.ReasonID==""){
                    $('#lstMCancelReason-err').html('Reason is required.');status=false;
                }
                if(isItemCancel){
                    if(formData.VACharges==""){
                        $('#txtMVACost-err').html('The Vendor Additional Charge is required.');status=false;
                    }else if($.isNumeric(formData.VACharges)==false){
                        $('#txtMVACost-err').html('The Vendor Additional Charge must be a numeric value.');status=false;
                    }else if(parseFloat(formData.VACharges)<0){
                        $('#txtMVACost-err').html('The Vendor Additional Charge must be greater than or equal to 0.');status=false;
                    }
                    if(formData.CACharges==""){
                        $('#txtMCACost-err').html('The Customer Additional Charge is required.');status=false;
                    }else if($.isNumeric(formData.CACharges)==false){
                        $('#txtMCACost-err').html('The Customer Additional Charge must be a numeric value.');status=false;
                    }else if(parseFloat(formData.CACharges)<0){
                        $('#txtMCACost-err').html('The Customer Additional Charge must be greater than or equal to 0.');status=false;
                    }
                }
                return status;
            }
			let formData={};
			formData.OrderID=$('#txtMOrderID').val();
			formData.ODID=$('#txtMODID').val();
			formData.ReasonID=$('#lstMCancelReason').val();
			formData.Description=$('#txtMDescription').val();
			formData.VACharges=$('#txtMVACost').val();
			formData.CACharges=$('#txtMCACost').val();
			formData.EnqID=$('#txtMEnqID').val();
			formData.VendorID=$('#txtMVendorID').val();
            if(validate(formData)==true){
                $.ajax({
                    type:"post",
                    url: isItemCancel?"{{route('admin.transaction.orders.cancel-item','__ID__')}}".replace("__ID__",formData.ODID):"{{route('admin.transaction.orders.cancel','__ID__')}}".replace("__ID__",formData.OrderID),
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    data:formData,
                    dataType:"json",
                    async:true,
                    beforeSend:function(){
                        let text=isItemCancel?"Order Item Cancellation on process.":"Order Cancellation on process.";
                        ajaxIndicatorStart (text)
                    },
                    complete: function(e, x, settings, exception){
                        ajaxIndicatorStop ()
                    },
                    success:function(response){
                        if(response.status){
                            $('#OrderCancelModel').modal('hide');
                            toastr.success(response.message, "", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
                            window.location.reload();
                        }else{
                            toastr.error(response.message, "", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
                        }
                    }
                });
            }
		});
		$(document).on('change','#lstMCancelReason',function(){ console.log(cancelReasons)
			try {
				let ReasonID=$('#lstMCancelReason').val();
				$('#txtMDescription').text(cancelReasons[ReasonID].Description);
			} catch (error) {
				console.log(error);
			}
		});
        $(document).on('click', '#btnResend', function(e) {
            e.preventDefault();
            if(ResendOTP){
                sendOTP();
            }

        });
        $(document).on('click','.btnItemMarkDelivered',function(){
            isItemDelivered=true;
            let DetailID=$(this).attr('data-detail-id');
            $('#txtMDDetailID').val(DetailID);
            swal({
                title: "Are you sure?",
                text: isItemDelivered?"do you want mark as Delivered this Order item":"Would you like to mark this order as Delivered?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-outline-success",
                confirmButtonText: "Continue",
                closeOnConfirm: false
            },function(){
                swal.close();
                if(enableOTPVerify){
                    sendOTP();
                    $('#DeliveryConfirmModal').modal('show');
                    setTimeout(() => {
                        $('#txtFirst').focus();
                    }, 1000);
                }else{
                    markAsDelivered();
                }
            });
        });
        $(document).on('click','.btnMarkAsDelivery',function(){
            $('#txtMDDetailID').val("");
            isItemDelivered=false;
            swal({
                title: "Are you sure?",
                text: isItemDelivered?"do you want mark as Delivered this Order item":"Would you like to mark this order as Delivered?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-outline-success",
                confirmButtonText: "Continue",
                closeOnConfirm: false
            },function(){
                swal.close();
                if(enableOTPVerify){
                    sendOTP();
                    $('#DeliveryConfirmModal').modal('show');
                    setTimeout(() => {
                        $('#txtFirst').focus();
                    }, 1000);
                }else{
                    markAsDelivered();
                }
            });
        });
        $(document).on('click','#btnMarkAsDelivered',function(){
            markAsDelivered();
        });
    });
</script>
@endsection
