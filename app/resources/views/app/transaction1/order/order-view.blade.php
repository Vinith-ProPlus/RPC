@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Transaction</li>
					<li class="breadcrumb-item"><a href="{{ url('/') }}/admin/transaction/order/" data-original-title="" title="">{{$PageTitle}}</a></li>
                    <li class="breadcrumb-item">Order View</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row d-flex justify-content-center">
		<div class="col-12 col-sm-12 col-lg-12">
			<div class="card">
				<div class="card-header text-center"><h5 class="mt-10">Order ( {{$OData->OrderNo}} )</h5></div>
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
                                                'Customer Name' => $OData->CustomerName,
                                                'Email' => $OData->Email,
                                                'Contact Number' => $OData->MobileNo1 . ($OData->MobileNo2 ? ', ' . $OData->MobileNo2 : ''),
                                                'Order Date' => date($Settings['DATE-FORMAT'], strtotime($OData->OrderDate)),
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
                                                // if($OData->CustomerName!=""){$Address.="<b>".$OData->CustomerName."</b>";}
                                                if($OData->Address!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$OData->Address;}
                                                if($OData->CityName!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$OData->CityName;}
                                                if($OData->TalukName!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$OData->TalukName;}
                                                if($OData->DistrictName!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$OData->DistrictName;}
                                                if($OData->StateName!=""){if($Address!=""){$Address.=",<br>";}$Address.=$OData->StateName;}
                                                if($OData->CountryName!=""){if($Address!=""){$Address.=", ";}$Address.=$OData->CountryName;}
                                                if($OData->PostalCode!=""){if($Address!=""){$Address.=" - ";}$Address.=$OData->PostalCode;}
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
                                    <h6 class="text-center fw-700">Order Details</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table" id="tblOrder">
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
                                            @foreach ($OrderData as $key=>$item)
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
                                            <h4 class="">Quotation allocated to <span class="text-info">{{$OrderData[0]->VendorName}}</span></h4>
                                        </div> --}}
                                        <div class="col-sm-6">
                                            <div class="row mt-20 fw-600 fs-15 mr-10 justify-content-end">
                                                <div class="col-4">Sub Total</div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divSubTotal">{{NumberFormat($OrderData[0]->SubTotal,$Settings['PRICE-DECIMALS'])}}</div>
                                            </div>
                                            <div class="row mt-10 fw-600 fs-15 mr-10 justify-content-end">
                                                <div class="col-4">CGST</div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divCGSTAmount">{{NumberFormat($OrderData[0]->CGSTAmt,$Settings['PRICE-DECIMALS'])}}</div>
                                            </div>
                                            <div class="row mt-10 fw-600 fs-15 mr-10 justify-content-end">
                                                <div class="col-4">SGST</div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divSGSTAmount">{{NumberFormat($OrderData[0]->SGSTAmt,$Settings['PRICE-DECIMALS'])}}</div>
                                            </div>
                                            <div class="row mt-10 fw-600 fs-15 mr-10 justify-content-end">
                                                <div class="col-4">IGST</div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divIGSTAmount">{{NumberFormat($OrderData[0]->IGSTAmt,$Settings['PRICE-DECIMALS'])}}</div>
                                            </div>
                                            <div class="row mt-10 fw-600 fs-16 mr-10 justify-content-end text-success">
                                                <div class="col-4">Total Amount</div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divTotalAmount">{{NumberFormat($OrderData[0]->TotalAmount,$Settings['PRICE-DECIMALS'])}}</div>
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
                            <a href="{{url('/')}}/admin/transaction/order" class="btn {{$Theme['button-size']}} btn-outline-dark mr-10" id="btnCancel">Back</a>
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
</script>
@endsection