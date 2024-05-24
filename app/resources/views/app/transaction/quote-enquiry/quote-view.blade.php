@extends('layouts.app')
@section('content')
<style>
    .stamp-badge {
        padding: 3px 6px;
        margin: -10px;
        z-index: 1;
    }
    .width-max-content {
        width: max-content;
    }
    .width-min-content {
        width: min-content;
    }

    .right-modal .modal-dialog {
        position: fixed;
        right: 0;
        margin: 0;
        width: 50%;
        max-width: 100%;
        height: 100%;
    }
    
    .right-modal .modal-content {
        height: 100%;
    }
    
    .right-modal .modal-body {
        height: auto;
        overflow-y: auto;
    }

</style>
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Transaction</li>
					<li class="breadcrumb-item"><a href="{{ url('/') }}/admin/transaction/quote-enquiry/" data-original-title="" title="">{{$PageTitle}}</a></li>
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
				<div class="card-header text-center"><h5 class="mt-10">Quote Enquiry ( {{$EnqData->EnqNo}} )</h5></div>
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
                                                'Customer Name' => $EnqData->ReceiverName,
                                                'Email' => $EnqData->Email,
                                                'Contact Number' => $EnqData->ReceiverMobNo ,
                                                'Quote Enquiry Date' => date($Settings['date-format'], strtotime($EnqData->EnqDate)),
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
                                            @foreach ($EnqData->BillingAddress as $row)
                                                <div class="row my-1">
                                                    <div class="col-sm-12 fw-500">{{ $row }}@if (!$loop->last), @else.@endif </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-header p-6">
                                            <p class="text-center fs-16 fw-500">Shipping Address</p>
                                        </div>
                                        <div class="card-body">
                                            @foreach ($EnqData->ShippingAddress as $row)
                                                <div class="row my-1">
                                                    <div class="col-sm-12 fw-500">{{ $row }}@if (!$loop->last), @else.@endif </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (count($FinalQuoteData) == 0)
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-4">
                                            </div>
                                            <div class="col-4">
                                                <h6 class="text-center fw-700">Product Details</h6>
                                            </div>
                                            <div class="col-4 text-end">
                                                @if($EnqData->isImageQuote)
                                                    <button type="button" id="btnViewQuoteImage" title="View Quote Image" data-image="{{$EnqData->QuoteImage ? url('/').'/'.$EnqData->QuoteImage : ''}}" class="btn btn-outline-dark mr-10"><i class="fa fa-image"></i></button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <table class="table width-max-content" id="tblProductDetails">
                                            <thead>
                                                <tr>
                                                    <th class="text-center align-middle">S.No</th>
                                                    <th class="text-center align-middle">Product</th>
                                                    <th class="text-center align-middle">Qty</th>
                                                    <th class="text-center align-middle">Vendors List</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $AllVendors=[];
                                                @endphp
                                                @foreach ($PData as $key=>$row)
                                                    <tr data-product-id="{{$row->ProductID}}" data-pcid="{{$row->CID}}" data-pscid="{{$row->SCID}}">
                                                        <td>{{$key + 1}}</td>
                                                        <td>{{$row->ProductName}}</td>
                                                        <td class="text-center" data-uom-id ="{{$row->UID}}" data-qty="{{$row->Qty}}">{{$row->Qty}}( {{$row->UCode}} )</td>
                                                        {{-- <td class="divInput">
                                                            <input class="form-control txtQty" type="number" value="{{$row->Qty}}">
                                                            <span class="errors txtQty-err err-sm"></span>
                                                        </td> --}}
                                                        <td>
                                                            @foreach ($row->AvailableVendors as $item)
                                                                <span class="badge rounded-pill badge-secondary">{{$item['VendorName']}}</span>
                                                                @php
                                                                    $vendorID = $item['VendorID'];
                                                                    $vendorExists = false;

                                                                    foreach ($AllVendors as &$vendor) {
                                                                        if ($vendor['VendorID'] === $vendorID) {
                                                                            $vendor['VendorCount']++;
                                                                            $vendorExists = true;
                                                                            break;
                                                                        }
                                                                    }

                                                                    if (!$vendorExists) {
                                                                        $Vendors = [
                                                                            'VendorID' => $vendorID,
                                                                            'VendorName' => $item['VendorName'],
                                                                            'Rating' => $item['OverAll'],
                                                                            'VendorCount' => 1
                                                                        ];
                                                                        $AllVendors[] = $Vendors;
                                                                    }
                                                                @endphp
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer d-flex">
                                        <div class="row">
                                            @foreach ($AllVendors as $item)
                                                <div class="col width-min-content">
                                                    <div class="card width-max-content">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-9 width-max-content">
                                                                    <span class="fs-16 fw-500 text-dark">{{$item['VendorName']}}</span>
                                                                    <button type="button" title="View Vendor Ratings" data-vendor-id="{{$item['VendorID']}}" data-vendor-name="{{$item['VendorName']}}" class="btn btnVendorRatings"><i class="fa fa-eye text-dark"></i></button><br>
                                                                    <span class="fs-12 text-dark">Available Products ({{ $item['VendorCount'] }} / {{count($PData)}})</span>
                                                                </div>
                                                                @if (count($FinalQuoteData) == 0 && !in_array($item['VendorID'], $RequestedVendors))
                                                                    <div class="col-3 width-max-content">
                                                                        <span class="checkbox checkbox-secondary">
                                                                            <input class="chkVendors" id="{{$item['VendorID']}}" type="checkbox">
                                                                            <label for="{{$item['VendorID']}}"></label>
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="stamp-badge position-absolute top-0 start-0 bg-success text-white rounded">
                                                            {{$item['Rating']}}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @if(count($VendorQuote)>0)
                                                <div class="col d-flex align-items-center">
                                                    <div class="card shadow-none">
                                                        <div class="card-body">
                                                            <button type="button" class="btn btn-block btn-outline-danger btnRequestQuote">Request Quote Again</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (count($VendorQuote)>0 && count($FinalQuoteData) == 0)
                                <div class="col-12 col-sm-12 col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="text-center fw-700">Recieved Quotations</h6>
                                        </div>
                                        <div class="card-body table-responsive">
                                            <table class="table table-sm width-max-content" id="tblVendorQuote">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center align-middle">S.No</th>
                                                        <th class="text-center align-middle">Product</th>
                                                        <th class="text-center align-middle">Qty</th>
                                                        @foreach ($VendorQuote as $quote)
                                                            <th class="text-center align-middle">
                                                                {{ $quote->VendorName }} <br>

                                                                @if($quote->Status == 'Requested')
                                                                    <button type="button" data-vendor-id="{{ $quote->VendorID }}" data-vendor-name="{{ $quote->VendorName }}" class="btn btn-outline-primary btn-xs btnVendorPrice"> Add Vendor Price</button>
                                                                @endif

                                                            </th>
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($PData as $key => $row)
                                                        <tr data-product-id="{{ $row->ProductID }}" data-pcid="{{ $row->CID }}" data-pscid="{{ $row->SCID }}" data-qty="{{ $row->Qty }}">
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $row->ProductName }}</td>
                                                            <td class="text-center">{{ $row->Qty }} ( {{ $row->UCode }} )</td>
                                                            @foreach ($VendorQuote as $quote)
                                                                @php $found = false; @endphp
                                                                @foreach ($quote->ProductData as $item)
                                                                    @if ($row->ProductID === $item->ProductID)
                                                                        @if($quote->Status == 'Rejected')
                                                                        <td class="text-center align-middle text-danger">Vendor Rejected</td>
                                                                        @else
                                                                            <td class="align-items-center align-middle">
                                                                                <div class="row d-flex align-items-center justify-content-center">
                                                                                    <div class="col-6 divPriceInput">
                                                                                        <div class="input-group">
                                                                                            <div class="input-group-text">
                                                                                                <input class="chkAmount" @if(!$item->Price) disabled @endif id="radio_{{ $loop->parent->index }}_{{ $loop->index }}" type="radio" name="amount_{{ $row->ProductID }}" value="{{ $quote->VendorID }}" data-vendor-id="{{ $quote->VendorID }}" data-vendor-quote-id="{{ $item->VQuoteID }}" data-quote-detail-id="{{ $item->DetailID }}">
                                                                                            </div>
                                                                                            <input type="number" class="form-control txtFinalPrice" data-price="{{ NumberFormat($item->Price, $Settings['price-decimals']) }}" value="{{ NumberFormat($item->Price, $Settings['price-decimals']) }}" step="0.01" @if(!$item->Price) disabled @endif>
                                                                                        </div>
                                                                                        <span class="errors err-sm"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        @endif
                                                                        @php $found = true; break; @endphp
                                                                    @endif
                                                                @endforeach
                                                                @unless ($found)
                                                                    <td> </td>
                                                                @endunless
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th class="text-right align-middle" colspan="3">Additional Cost ==></th>
                                                        @foreach ($VendorQuote as $quote)
                                                            @if($quote->Status !== 'Rejected' && $quote->AdditionalCost)
                                                                <th class="text-right align-middle">
                                                                    <div class="row d-flex align-items-center justify-content-center">
                                                                        <div class="col-9">
                                                                            <div class="input-group">
                                                                                <div class="input-group-text SelectedItemCount" data-vendor-id="{{ $quote->VendorID }}">
                                                                                    Items(0)
                                                                                </div>
                                                                                <input type="number" class="form-control txtAdditionalCost" value="{{ NumberFormat($quote->AdditionalCost, $Settings['price-decimals']) }}" step="0.01" data-vendor-id="{{ $quote->VendorID }}" disabled>
                                                                            </div>
                                                                            <span class="errors err-sm"></span>
                                                                        </div>
                                                                    </div>
                                                                </th>
                                                            @else
                                                            <th></th>
                                                            @endif
                                                        @endforeach
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="col-12 col-sm-12 col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="text-center fw-700">Allocated Quotation</h6>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <table class="table width-max-content" id="tblAllocatedQuote">
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
                        @endif
                    </div>
				</div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            @if($crud['view']==true)
                                <a href="{{url('/')}}/admin/transaction/quote-enquiry" class="btn {{$Theme['button-size']}} btn-outline-dark mr-10" id="btnCancel">Back</a>
                            @endif

                            @if($crud['add']==true && count($VendorQuote)==0 && count($FinalQuoteData) == 0)
                                <button class="btn {{$Theme['button-size']}} btn-outline-success btnRequestQuote">Request Quote</button>
                            @elseif(count($VendorQuote)>0 && count($FinalQuoteData) == 0)
                                <button class="btn {{$Theme['button-size']}} btn-outline-info" id="btnQuoteConvert">Convert to Quotation</button>
                            @endif
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
                    let postUrl="{{ url('/') }}/admin/transaction/quote-enquiry/quote-convert/{{$EnqData->EnqID}}";
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
        $('#btnViewQuoteImage').on('click', function() {
            var $button = $(this).find('i');
            $button.addClass('fa-spinner fa-spin').removeClass('fa-image');

            var imageUrl = $(this).data('image');
            if (imageUrl) {
                var img = new Image();
                img.onload = function() {
                    var modalWidth = Math.min(this.naturalWidth, $(window).width());
                    var modalHeight = Math.min(this.naturalHeight, $(window).height());
                    if (modalWidth <= 400) {
                        modalWidth = 400;
                        modalHeight = 400;
                    } else if (modalWidth > 1000) {
                        modalWidth = 1000;
                        modalHeight = (1000 / this.naturalWidth) * this.naturalHeight;
                    }

                    var dialogContent = '<img id="quoteImage" src="' + imageUrl + '" class="img-fluid" alt="Quote Image">';

                    var dialog = bootbox.dialog({
                        title: 'Quote Image',
                        message: dialogContent,
                        size: 'medium',
                        className: 'right-modal'
                    });

                    dialog.init(function() {
                        $('.right-modal .modal-dialog').css({
                            width: modalWidth + 'px',
                            height: modalHeight >= 400 ? modalHeight : 400 + 'px'
                        });
                    });

                    dialog.on('shown.bs.modal', function() {
                        $button.removeClass('fa-spinner fa-spin').addClass('fa-image');
                    });
                };

                img.onerror = function() {
                    $button.removeClass('fa-spinner fa-spin').addClass('fa-image');
                    bootbox.alert('Failed to load the image.');
                };

                img.src = imageUrl;
            } else {
                bootbox.alert('No image available');
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

        $(document).on('change', '.chkAmount', function () {
            LoadAdditionalCost();
        });

        $(document).on('click', '.btnVendorRatings', function (e) {
            e.preventDefault();
            let VendorName = $(this).attr('data-vendor-name');
            $.ajax({
                type: "post",
                url: "{{url('/')}}/admin/transaction/quote-enquiry/get/vendor-ratings",
                data: { VendorID: $(this).attr('data-vendor-id') },
                headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
                success: function (response) {
                    let modalContent = $('<div></div>');
                    let row = $('<div class="row my-3 justify-content-center">').html(
                            `<div class="row">
                                <div class="col-12 text-center">
                                    <img loading="lazy" src="{{ url('/') }}/${response.Logo}" alt="Vendor Logo" class="img-fluid rounded" height="150" width="150">
                                </div>
                                <div class="row mt-20">
                                    <div class="col-7">
                                        <h6 class="text-center my-2">Vendor Info</h6>
                                        <div class="row">
                                            <div class="col-sm-5 fs-15 fw-600">Vendor Name</div>
                                            <div class="col-sm-1 fs-15 fw-600 text-center">:</div>
                                            <div class="col-sm-5 fs-15">${response.VendorName}</div>
                                        </div>
                                        <div class="row my-1">
                                            <div class="col-sm-5 fs-15 fw-600">Address</div>
                                            <div class="col-sm-1 fs-15 fw-600 text-center">:</div>
                                            <div class="col-sm-5 fs-15">${response.Address}, ${response.CityName}<br>${response.TalukName}, ${response.DistrictName}<br>${response.StateName}-${response.PostalCode}</div>
                                        </div>
                                        <div class="row my-1">
                                            <div class="col-sm-5 fs-15 fw-600">GST No</div>
                                            <div class="col-sm-1 fs-15 fw-600 text-center">:</div>
                                            <div class="col-sm-5 fs-15">${response.GSTNo}</div>
                                        </div>
                                        <div class="row my-1">
                                            <div class="col-sm-5 fs-15 fw-600">Mobile No</div>
                                            <div class="col-sm-1 fs-15 fw-600 text-center">:</div>
                                            <div class="col-sm-5 fs-15">${response.MobileNumber1}</div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <h6 class="text-center my-2">Key Points</h6>
                                        <div class="mt-2 fs-15">• ${response.VendorName} is with us since <b>${response.TotalYears}.</b></div>
                                        <div class="my-2 fs-15">• Has completed <b>${response.TotalOrders}</b> orders worth INR <b>${Number(response.OrderValue).toFixed({{$Settings['price-decimals']}})}.</b></div>
                                        <div class="my-2 fs-15">• Has ${generateStarRating(response.CustomerRating)} Customer rating and ${generateStarRating(response.AdminRating)} Admin Rating.</div>
                                        <div class="my-2 fs-15">• Has outstanding of <b>INR ${Number(response.Outstanding).toFixed({{$Settings['price-decimals']}})}.</b></div>
                                        <div class="my-2 fs-15">• Has an Overall Rating of <b>${response.OverAll}.</b></div>
                                    </div>
                                </div>
                            </div>`);
                        modalContent.append(row);

                    let dialog = bootbox.dialog({
                        title: "Vendor Details",
                        // title: VendorName+' - Ratings',
                        closeButton: true,
                        message: modalContent,
                        className: 'modal-xl',
                    });
                    dialog.find('.modal-title').css({ 'margin': '0 auto', 'display': 'inline-block' });
                }
            });
        });
        $(document).on('click', '.btnVendorPrice', function (e) {
            e.preventDefault();
            let VendorID = $(this).data('vendor-id');
            let VendorName = $(this).data('vendor-name');
            $.ajax({
                type: "post",
                url: "{{url('/')}}/admin/transaction/quote-enquiry/get/vendor-quote",
                data: { VendorID: VendorID, EnqID : "{{$EnqData->EnqID}}" },
                headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
                success: function (response) {
                    let card = $('<div class="card"></div>');
                    let cardBody = $('<div class="card-body"></div>');

                    let table = $('<table class="table" id="tblVendorPriceUpdate"></table>');
                    let thead = $('<thead><tr><th class="text-center align-middle">S.No</th><th class="text-center align-middle">Product</th><th class="text-center align-middle">Qty</th><th class="text-center align-middle">Price</th></tr></thead>');
                    table.append(thead);

                    let tbody = $('<tbody></tbody>');
                    response.ProductData.forEach((product, index) => {
                        let row = $('<tr data-product-id="' + product.ProductID + '"></tr>');
                        row.append('<td>' + (index + 1) + '</td>');
                        row.append('<td>' + product.ProductName + '</td>');
                        row.append('<td class="text-center" data-qty = '+ product.Qty +'>' + product.Qty + ' ( ' + product.UCode + ' )</td>');
                        let formattedPrice = product.VendorPrice.toFixed(2);
                        row.append(`<td class="align-items-center align-middle">
                                        <div class="row d-flex align-items-center justify-content-center">
                                            <div class="col-6">
                                                <input type="number" class="form-control txtVendorPrice" value="${formattedPrice}" step="0.01">
                                                <span class="errors err-sm"></span>
                                            </div>
                                        </div>
                                        <span class="errors err-sm"></span>
                                    </td>`);
                        tbody.append(row);
                    });
                    table.append(tbody);
                    cardBody.append(table);

                    let costInputs = $(`<div class="row mt-20 justify-content-center">
                                            <div class="col-sm-5">
                                                <label for="txtTransportCost" class="fw-700">Transport Cost :</label>
                                                <input type="number" class="form-control" id="txtTransportCost" step="0.01">
                                                <div class="errors" id="txtTransportCost-err"></div>
                                            </div>
                                            <div class="col-sm-5">
                                                <label for="txtLabourCost" class="fw-700">Labour Cost :</label>
                                                <input type="number" class="form-control" id="txtLabourCost" step="0.01">
                                                <div class="errors" id="txtLabourCost-err"></div>
                                            </div>
                                        </div>`);
                    cardBody.append(costInputs);

                    card.append(cardBody);

                    let cardFooter = $('<div class="card-footer text-right pt-10"></div>');

                    let rejectButton = $('<button type="button" class="btn btn-danger mr-2" data-vendor-id="' + VendorID + '" data-vendor-quote-id="' + response.VQuoteID + '" id="btnRejectQuote">Reject Quote</button>');

                    let submitButton = $('<button type="button" class="btn btn-primary" data-vendor-id="' + VendorID + '" data-vendor-quote-id="' + response.VQuoteID + '" id="btnAddVendorPrice">Submit</button>');

                    cardFooter.append(rejectButton);
                    cardFooter.append(submitButton);

                    card.append(cardFooter);

                    let dialog = bootbox.dialog({
                        title: 'Quote Price Update (' + response.EnqNo + ') - '+ VendorName,
                        closeButton: true,
                        message: card,
                        className: 'modal-xl',
                    });
                    dialog.find('.modal-title').css({ 'margin': '0 auto', 'display': 'inline-block' });
                }
            });
        });

        $(document).on('click', '#btnAddVendorPrice', function () {
            let status = true;
            let ProductData =[];
            $('#tblVendorPriceUpdate tbody tr').each(function(){
                let product = {
                    ProductID : $(this).data('product-id'),
                    Qty : $(this).find('td:eq(2)').data('qty'),
                    Price : $(this).find('.txtVendorPrice').val(),
                }
                ProductData.push(product);
            });
            let formData = new FormData();
            formData.append('VendorID',$(this).data('vendor-id'));
            formData.append('VQuoteID',$(this).data('vendor-quote-id'));
            formData.append('TransportCost',$('#txtTransportCost').val());
            formData.append('LabourCost',$('#txtLabourCost').val());
            formData.append('ProductData',JSON.stringify(ProductData));
            if(status){
                swal({
                    title: "Are you sure?",
                    text: "You want to Submit Vendor Price!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, Submit it!",
                    closeOnConfirm: false
                },function(){
                    swal.close();
                    btnLoading($('#btnAddVendorPrice'));
                    let postUrl="{{ url('/') }}/admin/transaction/quote-enquiry/add-quote-price";
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
                        complete: function(e, x, settings, exception){btnReset($('#btnAddVendorPrice'));ajaxIndicatorStop();$("html, body").animate({ scrollTop: 0 }, "slow");},
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
                                    window.location.replace("{{url('/')}}/admin/transaction/quote-enquiry/view/{{$EnqData->EnqID}}");
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
                let postUrl="{{ url('/') }}/admin/transaction/quote-enquiry/delete-quote-item";
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
                                window.location.replace("{{url('/')}}/admin/transaction/quote-enquiry/view/{{$EnqData->EnqID}}");
                            });

                        }else{
                            toastr.error(response.message, "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
                        }
                    }
                });
            });
        });
        $(document).on('click', '#btnRejectQuote', function () {
            let formData = new FormData();
            formData.append('VendorID',$(this).data('vendor-id'));
            formData.append('VQuoteID',$(this).data('vendor-quote-id'));

            swal({
                title: "Are you sure?",
                text: "You want to Reject this Quote!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-outline-success",
                confirmButtonText: "Yes, Reject it!",
                closeOnConfirm: false
            },function(){
                swal.close();
                let postUrl="{{ url('/') }}/admin/transaction/quote-enquiry/reject-quote";
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
                                window.location.replace("{{url('/')}}/admin/transaction/quote-enquiry/view/{{$EnqData->EnqID}}");
                            });

                        }else{
                            toastr.error(response.message, "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
                        }
                    }
                });
            });
        });
        $('.btnRequestQuote').click(async function(){
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
                    btnLoading($('.btnRequestQuote'));
                    let postUrl="{{ url('/') }}/admin/transaction/quote-enquiry/request-quote/{{$EnqData->EnqID}}";
                    $.ajax({
                        type:"post",
                        url:postUrl,
                        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content')},
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
                        complete: function(e, x, settings, exception){btnReset($('.btnRequestQuote'));ajaxIndicatorStop();$("html, body").animate({ scrollTop: 0 }, "slow");},
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
                                    @if(count($VendorQuote)>0)
                                        window.location.reload();
                                    @else
                                        window.location.replace("{{url('/')}}/admin/transaction/quote-enquiry");
                                    @endif
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
