@extends('layouts.app')
@section('content')
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
				<div class="card-header text-center"><h5 class="mt-10">Quote ( {{$QData->QNo}} )</h5></div>
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
                                                'Customer Name' => $QData->CustomerName,
                                                'Email' => $QData->Email,
                                                'Contact Number' => $QData->MobileNo1 . ($QData->MobileNo2 ? ', ' . $QData->MobileNo2 : ''),
                                                'Quote Date' => date($Settings['DATE-FORMAT'], strtotime($QData->QDate)),
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
                                            <p class="text-center fs-16 fw-500">Address</p>
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
                                            <p class="text-center fs-16 fw-500">Delivery Address</p>
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
                        @if (count($AllocatedQData) == 0)
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="text-center fw-700">Product Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <table class="table" id="tblProductDetails">
                                            <thead>
                                                <tr>
                                                    <th class="text-center align-middle">S.No</th>
                                                    <th class="text-center align-middle">Product</th>
                                                    <th class="text-center align-middle">Qty</th>
                                                    <th class="text-center align-middle">Unit of Measurement</th>
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
                                                        <td class="text-right">{{$row->Qty}}</td>
                                                        {{-- <td class="divInput">
                                                            <input class="form-control txtQty" type="number" value="{{$row->Qty}}">
                                                            <span class="errors txtQty-err err-sm"></span>
                                                        </td> --}}
                                                        <td data-uom-id="{{$row->UID}}">{{$row->UName}} ( {{$row->UCode}} )</td>
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
                                        @foreach ($AllVendors as $item)
                                        <div class="card w-auto">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-9 w-auto">
                                                        <span class="fs-16 fw-500 text-dark">{{$item['VendorName']}}</span>
                                                        <button type="button" title="View Vendor Ratings" data-vendor-id="{{$item['VendorID']}}" data-vendor-name="{{$item['VendorName']}}" class="btn btnVendorRatings"><i class="fa fa-eye text-dark"></i></button><br>
                                                        <span class="fs-12 text-dark">Available Products ({{ $item['VendorCount'] }} / {{count($PData)}})</span>
                                                    </div>
                                                    @if (count($VendorQuote)==0)
                                                        <div class="col-3 w-auto">
                                                            <span class="checkbox checkbox-secondary">
                                                                <input class="chkVendors" id="{{$item['VendorID']}}" type="checkbox">
                                                                <label for="{{$item['VendorID']}}"></label>
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @if (count($VendorQuote)>0)
                                <div class="col-12 col-sm-12 col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="text-center fw-700">Recieved Quotations</h6>
                                        </div>
                                        <div class="card-body">
                                            <table class="table" id="tblVendorQuote">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center align-middle">S.No</th>
                                                        <th class="text-center align-middle">Product</th>
                                                        <th class="text-center align-middle">Qty</th>
                                                        <th class="text-center align-middle">Unit of Measurement</th>
                                                        <th class="text-center align-middle">Vendors Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- @foreach ($VendorQuote as $key=>$item)
                                                        <tr>
                                                            <td>{{$QData->QNo}}</td>
                                                            <td>{{$item->VendorName}}</td>
                                                            <td>{{$QData->QNo}} - {{$key + 1}}</td>
                                                            <td class="text-right">{{$item->TotalAmount ? NumberFormat($item->TotalAmount,$Settings['PRICE-DECIMALS']) : ""}}
                                                                @if($item->isQuoteReceived && $item->TotalAmount) 
                                                                    <button type="button" title="View Quotation Details" data-vendor-id="{{$item->VendorID}}" data-id="{{$item->QuoteSentID}}" class="btn btnQuoteView"><i class="fa fa-eye text-dark"></i></button> 
                                                                @endif
                                                            </td>
                                                            <td class="text-right">{{$item->ItemCount}}</td>
                                                            <td></td>
                                                            <td class="text-center">@if($item->isQuoteReceived && $item->TotalAmount) <button type="button" data-vendor-id="{{$item->VendorID}}" data-vendor-name="{{$item->VendorName}}" data-id="{{$item->QuoteSentID}}" class="btn btn-outline-info {{$Theme['button-size']}} btnAllocate">Allocate</button> @endif</td>
                                                        </tr>
                                                    @endforeach --}}
                                                    @foreach ($PData as $key=>$row)
                                                    <tr data-product-id="{{$row->ProductID}}" data-pcid="{{$row->CID}}" data-pscid="{{$row->SCID}}">
                                                        <td>{{$key + 1}}</td>
                                                        <td>{{$row->ProductName}}</td>
                                                        <td class="text-right">{{$row->Qty}}</td>
                                                        {{-- <td class="divInput">
                                                            <input class="form-control txtQty" type="number" value="{{$row->Qty}}">
                                                            <span class="errors txtQty-err err-sm"></span>
                                                        </td> --}}
                                                        <td data-uom-id="{{$row->UID}}">{{$row->UName}} ( {{$row->UCode}} )</td>
                                                        <td>
                                                        </td>
                                                    </tr>                                        
                                                @endforeach
                                                </tbody>
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($AllocatedQData as $key=>$item)
                                                    <tr>
                                                        <td>{{$key + 1}}</td>
                                                        <td>{{$item->ProductName}}</td>
                                                        <td class="text-right">{{$item->Qty}}</td>
                                                        <td>{{$item->UName}} ({{$item->UCode}})</td>
                                                        <td class="text-right">{{NumberFormat($item->Price,$Settings['PRICE-DECIMALS'])}}</td>
                                                        <td>{{$item->TaxType}}</td>
                                                        <td class="text-right">{{NumberFormat($item->Taxable,$Settings['PRICE-DECIMALS'])}}</td>
                                                        <td class="text-right">{{NumberFormat($item->TaxAmount,$Settings['PRICE-DECIMALS'])}}</td>
                                                        <td class="text-right">{{NumberFormat($item->CGSTPer,$Settings['PERCENTAGE-DECIMALS'])}}</td>
                                                        <td class="text-right">{{NumberFormat($item->CGSTAmount,$Settings['PRICE-DECIMALS'])}}</td>
                                                        <td class="text-right">{{NumberFormat($item->SGSTPer,$Settings['PERCENTAGE-DECIMALS'])}}</td>
                                                        <td class="text-right">{{NumberFormat($item->SGSTAmount,$Settings['PRICE-DECIMALS'])}}</td>
                                                        <td class="text-right">{{NumberFormat($item->IGSTPer,$Settings['PERCENTAGE-DECIMALS'])}}</td>
                                                        <td class="text-right">{{NumberFormat($item->IGSTAmount,$Settings['PRICE-DECIMALS'])}}</td>
                                                        <td class="text-right">{{NumberFormat($item->Amount,$Settings['PRICE-DECIMALS'])}}</td>
                                                        </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="row justify-content-end">
                                            {{-- <div class="col-sm-1"></div>
                                            <div class="col-sm-5 d-flex align-items-center">
                                                <h4 class="">Quotation allocated to <span class="text-info">{{$AllocatedQData[0]->VendorName}}</span></h4>
                                            </div> --}}
                                            <div class="col-sm-6">
                                                <div class="row mt-20 fw-600 fs-15 mr-10 justify-content-end">
                                                    <div class="col-4">Sub Total</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col-3 text-right" id="divSubTotal">{{NumberFormat($AllocatedQData[0]->SubTotal,$Settings['PRICE-DECIMALS'])}}</div>
                                                </div>
                                                <div class="row mt-10 fw-600 fs-15 mr-10 justify-content-end">
                                                    <div class="col-4">CGST</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col-3 text-right" id="divCGSTAmount">{{NumberFormat($AllocatedQData[0]->CGSTAmt,$Settings['PRICE-DECIMALS'])}}</div>
                                                </div>
                                                <div class="row mt-10 fw-600 fs-15 mr-10 justify-content-end">
                                                    <div class="col-4">SGST</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col-3 text-right" id="divSGSTAmount">{{NumberFormat($AllocatedQData[0]->SGSTAmt,$Settings['PRICE-DECIMALS'])}}</div>
                                                </div>
                                                <div class="row mt-10 fw-600 fs-15 mr-10 justify-content-end">
                                                    <div class="col-4">IGST</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col-3 text-right" id="divIGSTAmount">{{NumberFormat($AllocatedQData[0]->IGSTAmt,$Settings['PRICE-DECIMALS'])}}</div>
                                                </div>
                                                <div class="row mt-10 fw-600 fs-16 mr-10 justify-content-end text-success">
                                                    <div class="col-4">Total Amount</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col-3 text-right" id="divTotalAmount">{{NumberFormat($AllocatedQData[0]->TotalAmount,$Settings['PRICE-DECIMALS'])}}</div>
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
                            <a href="{{url('/')}}/admin/admin/transaction/quotation" class="btn {{$Theme['button-size']}} btn-outline-dark mr-10" id="btnCancel">Back</a>
                            @endif
                            
                            @if($crud['add']==true && count($VendorQuote)==0 && count($AllocatedQData) == 0)
                                <button class="btn {{$Theme['button-size']}} btn-outline-success" id="btnSave">Request Quote</button>
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
        $("#tblVendorQuote").DataTable({
            searching: false,
            lengthChange: false
        });
        
        $(document).on('click', '.btnQuoteView', function (e) {
            e.preventDefault();
            let QNo = $(this).closest('tr').find('td:eq(0)').html();
            let VendorName = $(this).closest('tr').find('td:eq(1)').html();
            let AllocateButton = $(this).closest('tr').find('.btnAllocate').clone();
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
                        <td class="text-right">${Number(item.Price).toFixed({{$Settings['PRICE-DECIMALS']}})}</td>
                        <td>${item.TaxType}</td>
                        <td class="text-right">${Number(item.Taxable).toFixed({{$Settings['PRICE-DECIMALS']}})}</td>
                        <td class="text-right">${Number(item.TaxAmount).toFixed({{$Settings['PRICE-DECIMALS']}})}</td>
                        <td class="text-right">${Number(item.CGSTPer).toFixed({{$Settings['PRICE-DECIMALS']}})}</td>
                        <td class="text-right">${Number(item.CGSTAmount).toFixed({{$Settings['PRICE-DECIMALS']}})}</td>
                        <td class="text-right">${Number(item.SGSTPer).toFixed({{$Settings['PRICE-DECIMALS']}})}</td>
                        <td class="text-right">${Number(item.SGSTAmount).toFixed({{$Settings['PRICE-DECIMALS']}})}</td>
                        <td class="text-right">${Number(item.Amount).toFixed({{$Settings['PRICE-DECIMALS']}})}</td>`
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
                                    <div class="col-3 text-right" id="divSubTotal">${totalTaxable.toFixed({{$Settings['PRICE-DECIMALS']}})}</div>
                                </div>
                                <div class="row mt-10 fw-600 fs-15 mr-10 justify-content-end">
                                    <div class="col-4">CGST</div>
                                    <div class="col-1">:</div>
                                    <div class="col-3 text-right" id="divCGSTAmount">${totalCGST.toFixed({{$Settings['PRICE-DECIMALS']}})}</div>
                                </div>
                                <div class="row mt-10 fw-600 fs-15 mr-10 justify-content-end">
                                    <div class="col-4">SGST</div>
                                    <div class="col-1">:</div>
                                    <div class="col-3 text-right" id="divSGSTAmount">${totalSGST.toFixed({{$Settings['PRICE-DECIMALS']}})}</div>
                                </div>
                                <div class="row mt-10 fw-600 fs-15 mr-10 justify-content-end">
                                    <div class="col-4">IGST</div>
                                    <div class="col-1">:</div>
                                    <div class="col-3 text-right" id="divIGSTAmount">${totalIGST.toFixed({{$Settings['PRICE-DECIMALS']}})}</div>
                                </div>
                                <div class="row mt-10 fw-600 fs-16 mr-10 justify-content-end text-success">
                                    <div class="col-4">Total Amount</div>
                                    <div class="col-1">:</div>
                                    <div class="col-3 text-right" id="divTotalAmount">${totalPrice.toFixed({{$Settings['PRICE-DECIMALS']}})}</div>
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
        });
        $(document).on('click', '.btnAllocate', function (e) {
            let VendorName = $(this).attr('data-vendor-name');
            let QuoteSentID = $(this).attr('data-id');
            let formData = new FormData();
			formData.append('VendorID', $(this).attr('data-vendor-id'));
            swal({
                title: "Are you sure?",
                text: "You want to Allocate the Quotation of "+VendorName+"",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-outline-success",
                confirmButtonText: "Yes, Allocate it!",
                closeOnConfirm: false
            },function(){
                swal.close();
                btnLoading($('#btnSave'));
                let postUrl="{{ url('/') }}/admin/transaction/quotation/allocate/"+QuoteSentID;
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
                                window.location.replace("{{url('/')}}/admin/transaction/quotation");
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
					UOMID: $(this).find('td:eq(3)').attr("data-uom-id"),
					PCID: $(this).attr("data-pcid"),
					PSCID: $(this).attr("data-pscid"),
					// Qty: $(this).find(".txtQty").val(),
					Qty: $(this).find('td:eq(2)').html(),
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
        $(document).on('click', '.btnVendorRatings', function (e) {
            e.preventDefault();
            let VendorName = $(this).attr('data-vendor-name');
            $.ajax({
                type: "post",
                url: "{{url('/')}}/admin/transaction/quotation/get/vendor-ratings",
                data: { VendorID: $(this).attr('data-vendor-id') },
                headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
                success: function (response) {
                    let modalContent = $('<div></div>');
                    let row = $('<div class="row my-3 justify-content-center">').html(
                            `<div class="row">
                                <div class="col-12 text-center">
                                    <img src="{{ url('/') }}/${response.Logo}" alt="Vendor Logo" class="img-fluid rounded" height="150" width="150">
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
                                        <div class="my-2 fs-15">• Has completed <b>${response.TotalOrders}</b> orders worth INR <b>${Number(response.OrderValue).toFixed({{$Settings['PRICE-DECIMALS']}})}.</b></div>
                                        <div class="my-2 fs-15">• Has ${generateStarRating(response.CustomerRating)} Customer rating and ${generateStarRating(response.AdminRating)} Admin Rating.</div>
                                        <div class="my-2 fs-15">• Has outstanding of <b>INR ${Number(response.Outstanding).toFixed({{$Settings['PRICE-DECIMALS']}})}.</b></div>
                                        <div class="my-2 fs-15">• Has an Overall Rating of <b>${response.OverAll}.</b></div>
                                    </div>
                                </div>                                
                            </div>`);
                        modalContent.append(row);

                    /* Object.keys(response).forEach(function (key) {
                        let item = response[key];
                        let formattedKey = camelCaseToWords(key);

                        let rowContent;
                        if (key === 'CustomerRating' || key === 'AdminRating') {
                            rowContent = generateStarRating(item);
                        }else if (key === 'Outstanding' || key === 'OrderValue') {
                            rowContent = Number(item).toFixed({{$Settings['PRICE-DECIMALS']}});
                        }else if (key === 'OverAll') {
                            rowContent = '<span class="fw-600">'+item+'</span>';
                        }else {
                            rowContent = item;
                        }
                    }); */

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

        $('#btnSave').click(async function(){
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
                    btnLoading($('#btnSave'));
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
                                    window.location.replace("{{url('/')}}/admin/transaction/quotation");
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