@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/plugins/ratings/star-rating-svg.css">
<style>
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
</style>
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-6">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Transaction</li>
					<li class="breadcrumb-item"><a href="{{route('admin.transaction.orders')}}" data-original-title="" title="">{{$PageTitle}}</a></li>
                    <li class="breadcrumb-item">Order View</li>
				</ol>
			</div>
            <div class="col-sm-6 text-right">
                @if($crud['view']==true)
                    <a href="{{route('admin.transaction.orders')}}" class="btn {{$Theme['button-size']}} btn-outline-dark m-5" >Back</a>
                @endif
                @if($OData->Status!="Cancelled" && $OData->Status!="Delivered")
                    <button class="btn {{$Theme['button-size']}} btn-outline-danger m-5 btnCancelOrder" data-id="{{$OrderID}}">Cancel Order</button>
                    <button class="btn {{$Theme['button-size']}} btn-outline-success btn-air-success m-5 btnMarkAsDelivered" data-id="{{$OrderID}}">Mark as Delivered</button>
                @endif
            </div>
		</div>
	</div>
</div>
<?php 
    $vendorAdditionalCharges=[];
?>
<div class="container-fluid">
	<div class="row d-flex justify-content-center">
		<div class="col-12 col-sm-12 col-lg-12">
			<div class="card">
				<div class="card-header text-center"><h5 class="mt-10">{{$PageTitle}} ( {{$OData->OrderNo}} )</h5></div>
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
                                                'Contact Number' => $OData->MobileNo1 ,
                                                'Expected Delivery' => date($Settings['date-format'], strtotime($OData->ExpectedDelivery)),
                                                'Contact Person' => ($OData->ReceiverName!="")? $OData->ReceiverName." <span> (".$OData->ReceiverMobNo.")</span>":"",
                                            ] as $label => $value)
                                                @if($value!="")
                                                    <div class="row my-1 mt-5">
                                                        <div class="col-sm-5 fw-600">{{ $label }}</div>
                                                        <div class="col-sm-1 fw-600 text-center">:</div>
                                                        <div class="col-sm-6"><?php echo $value ?></div>
                                                    </div>
                                                @endif
                                            @endforeach
                                            <div class="row my-1">
                                                <div class="col-sm-5 fw-600 d-flex align-items-center"><span class="mr-5">Ratings</span> @if($OData->isRated==1) <a href="#"  class="btnReadReview" title="Read Review" data-title="Customer Rating"  data-rating="{{$OData->Ratings}}" data-review="{{$OData->Review}}"><i class="fa fa-eye" ></i></a> @endif</div>
                                                <div class="col-sm-1 fw-600 text-center d-flex align-items-center">:</div>
                                                <div class="col-sm-6">
                                                    @if($OData->isRated==1)
                                                        <div id="CustomerRating" data-rating="{{$OData->Ratings}}" ></div>
                                                    @else
                                                        <span class="badge badge-danger">Not Rated</span> 
                                                    @endif
                                                </div>
                                            </div>
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
                                <div class="col-sm-4">
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
                                    <table class="table" id="tblOrderDetails">
                                        <thead>
                                            <tr class="valign-top">
                                                <th class="text-center align-middle">S.No</th>
                                                <th class="text-center align-middle">Product Name</th>
                                                <th class="text-center align-middle">Qty</th>
                                                <th class="text-center align-middle">Price<br> (₹)</th>
                                                <th class="text-center align-middle">Tax Type</th>
                                                <th class="text-center align-middle">Taxable<br> (₹)</th>
                                                <!---->
                                                @if(count($OData->Details)>0)
                                                    @if(floatval($OData->Details[0]->IGSTAmt)<=0)
                                                        <th class="text-center align-middle">CGST<br> (₹)</th>
                                                        <th class="text-center align-middle">SGST<br> (₹)</th>
                                                    @else
                                                        <th class="text-center align-middle">IGST<br> (₹)</th>
                                                    @endif
                                                @else
                                                    <th class="text-center align-middle">Tax Amount<br> (₹)</th>
                                                @endif
                                                <th class="text-center align-middle">Total Amount<br> (₹)</th>
                                                <th class="text-center align-middle">Allocated To</th>
                                                <th class="text-center align-middle">Status</th>
                                                <th class="text-center align-middle">Delivered On</th>
                                                @if($OData->Status=="New" && $crud['delete']==true)
                                                    <th class="text-center align-middle">Action</th>
                                                @endif
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
                                                    <td class="text-right">{{NumberFormat($item->Price, $Settings['price-decimals'])}}</td>
                                                    <td>{{$item->TaxType}}</td>
                                                    <td class="text-right">{{ $item->Status == 'Cancelled' ? '--' : NumberFormat($item->Taxable, $Settings['price-decimals']) }}</td>
                                                    @if(count($OData->Details)>0)
                                                        @if(floatval($item->IGSTAmt)<=0)
                                                            <td class="text-right">
                                                                <div>{{ $item->Status == 'Cancelled' ? '--' : NumberFormat($item->CGSTAmt, $Settings['price-decimals']) }} </div>
                                                                <div class="fs-11">{{ $item->Status == 'Cancelled' ? '' : "(".NumberFormat($item->CGSTPer, $Settings['price-decimals'])." %)" }}</div>
                                                            </td>
                                                            <td class="text-right">
                                                                <div>{{ $item->Status == 'Cancelled' ? '--' : NumberFormat($item->SGSTAmt, $Settings['price-decimals']) }} </div>
                                                                <div class="fs-11">{{ $item->Status == 'Cancelled' ? '' : "(".NumberFormat($item->SGSTPer, $Settings['price-decimals'])." %)" }}</div>
                                                            </td>
                                                        @else
                                                            <td class="text-right">
                                                                <div>{{ $item->Status == 'Cancelled' ? '--' : NumberFormat($item->IGSTAmt, $Settings['price-decimals']) }} </div>
                                                                <div class="fs-11">{{ $item->Status == 'Cancelled' ? '' : "(".NumberFormat($item->IGSTPer, $Settings['price-decimals'])." %)" }}</div>
                                                            </td>
                                                        @endif
                                                    @else
                                                        <td class="text-right">{{ $item->Status == 'Cancelled' ? '--' : NumberFormat(0, $Settings['price-decimals']) }}</td>
                                                    @endif
                                                    <td class="text-right">{{ $item->Status == 'Cancelled' ? '--' : NumberFormat($item->TotalAmt, $Settings['price-decimals']) }} </td>
                                                    <td><span class=" fw-600 text-info text-center">{{$item->VendorName}}</span></td>
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
                                                            {{date($Settings['date-format'],strtotime($item->DeliveredOn))}}
                                                        @else
                                                            --
                                                        @endif
                                                    </td>
                                                    @if($OData->Status!="Delivered" && $OData->Status!="Cencelled"  && $item->Status=="New" && $crud['delete']==true)
                                                        <td class="text-center">
                                                            <button type="button"  data-vendor-id="{{$item->VendorID}}" data-additional-charge="<?php if(array_key_exists($item->VendorID,$OData->AdditionalCharges)){ echo $OData->AdditionalCharges[$item->VendorID];}else{ echo 0;} ?>" data-detail-id="{{$item->DetailID}}" data-order-no="{{$item->ProductName}}" data-id="{{$item->OrderID}}" class="btn m-5 btn-outline-success btnItemMarkDelivered" title="Mark this item as Delivered"><i class="fa fa-check"></i></button>
                                                            <button type="button"  data-vendor-id="{{$item->VendorID}}" data-additional-charge="<?php if(array_key_exists($item->VendorID,$OData->AdditionalCharges)){ echo $OData->AdditionalCharges[$item->VendorID];}else{ echo 0;} ?>" data-detail-id="{{$item->DetailID}}" data-order-no="{{$item->ProductName}}" data-id="{{$item->OrderID}}" class="btn m-5 btn-outline-danger btnOItemDelete" -title="Item Cancel"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                            
                                                        </td>
                                                    @endif
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
                                        <div class="col-sm-6 ">
                                            <div class="card shadow-sm">
                                                <div class="card-body p-5">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">Vendor Name</th>
                                                                        <th class="text-center">Additional Charges  @if($OData->Status=="New")<a href="#" id="btnEditVACharges" title="Update Vendor's Additional Costs"><i class="fa fa-pencil" ></i></a> @endif</th>
                                                                        <th class="text-center">Admin Ratings</th>
                                                                        <th class="text-center"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($vendorAdditionalCharges as $VendorID=>$VData)
                                                                        <tr>
                                                                            <td>{{$VData['name']}}</td>
                                                                            <td class="text-right">{{Helper::NumberFormat($VData['amount'],$Settings['price-decimals'])}}</td>
                                                                            <td class="text-center">
                                                                                <?php
                                                                                    $vIsRated="0";
                                                                                    $vOrderStatus="New";
                                                                                    $vReview="";
                                                                                    $vRatings=0;
                                                                                    if(array_key_exists($VendorID,$OData->orderStatus)){
                                                                                        $vIsRated=$OData->orderStatus[$VendorID]['isRated'];
                                                                                        $vOrderStatus=$OData->orderStatus[$VendorID]['Status'];
                                                                                        $vReview=$OData->orderStatus[$VendorID]['Review'];
                                                                                        $vRatings=$OData->orderStatus[$VendorID]['Ratings'];
                                                                                    }
                                                                                ?>
                                                                                @if($vOrderStatus=="Delivered")
                                                                                    <div class="vendor-rating" data-vendor-id="{{$VendorID}}" data-is-rated="{{$vIsRated}}" data-rating="{{$vRatings}}" data-status='{{$vOrderStatus}}' title="{{$vReview}}"></div>
                                                                                @elseif($vOrderStatus=="New")
                                                                                    
                                                                                    <span class="badge badge-danger">Not Delivered</span> 
                                                                                @else
                                                                                    <span class="badge badge-danger">{{$vOrderStatus}}</span> 
                                                                                    
                                                                                @endif
                                                                            </td>
                                                                            <td class="text-center">
                                                                                @if($vIsRated==1)
                                                                                    <a href="#" class="btnReadReview" title="Read Review" data-title="Admin Vendor Rating"  data-rating="{{$vRatings}}" data-review="{{$vReview}}"><i class="fa fa-eye" ></i></a>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-sm-6">
                                            <div class="row fw-500 fs-13 mr-10 justify-content-end">
                                                <div class="col-4">Sub Total</div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divSubTotal">{{NumberFormat($OData->SubTotal,$Settings['price-decimals'])}}</div>
                                            </div>
                                            @if(count($OData->Details)>0)
                                                @if(floatval($OData->IGSTAmount)<=0)
                                                    <div class="row mt-10 fw-500 fs-13 mr-10 justify-content-end">
                                                        <div class="col-4">CGST</div>
                                                        <div class="col-1">:</div>
                                                        <div class="col-3 text-right" id="divCGSTAmount">{{NumberFormat($OData->CGSTAmount,$Settings['price-decimals'])}}</div>
                                                    </div>
                                                    <div class="row mt-10 fw-500 fs-13 mr-10 justify-content-end">
                                                        <div class="col-4">SGST</div>
                                                        <div class="col-1">:</div>
                                                        <div class="col-3 text-right" id="divSGSTAmount">{{NumberFormat($OData->SGSTAmount,$Settings['price-decimals'])}}</div>
                                                    </div>
                                                @else
                                                    <div class="row mt-10 fw-500 fs-13 mr-10 justify-content-end">
                                                        <div class="col-4">IGST</div>
                                                        <div class="col-1">:</div>
                                                        <div class="col-3 text-right" id="divIGSTAmount">{{NumberFormat($OData->IGSTAmount,$Settings['price-decimals'])}}</div>
                                                    </div>
                                                @endif
                                            @else
                                            
                                                <div class="row mt-10 fw-500 fs-13 mr-10 justify-content-end">
                                                    <div class="col-4">Tax Amount</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col-3 text-right" id="divTaxAmount">{{NumberFormat($OData->TaxAmount,$Settings['price-decimals'])}}</div>
                                                </div>
                                            @endif
                                            <div class="row mt-10 fw-600 fs-14 mr-10 justify-content-end">
                                                <div class="col-4">Total Amount</div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divTotalAmount">{{NumberFormat($OData->TotalAmount,$Settings['price-decimals'])}}</div>
                                            </div>
                                            <div class="row mt-10 fw-500 fs-13 mr-10 justify-content-end">
                                                <div class="col-4">Additional Amount @if($OData->Status=="New") <a href="#" class="ml-5" id="btnEditCustomerCost" title="Click here to edit customer additional charges."><i class="fa fa-pencil"></i></a> @endif</div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divAdditionalAmount">{{NumberFormat($OData->AdditionalCost,$Settings['price-decimals'])}}</div>
                                            </div>
                                            <div class="row mt-10 fw-600 fs-15 mr-10 justify-content-end">
                                                <div class="col-4">Net Amount</div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divOverAllAmount">{{NumberFormat($OData->NetAmount,$Settings['price-decimals'])}}</div>
                                            </div>
                                            <div class="row mt-10 fw-500 fs-13 mr-10 justify-content-end">
                                                <div class="col-4">Paid Amount </div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divPaidAmount">{{NumberFormat($OData->TotalPaidAmount,$Settings['price-decimals'])}}</div>
                                            </div>
                                            <div class="row mt-10 fw-800 fs-17 mr-10 justify-content-end @if($OData->PaymentStatus=='Paid') text-success @elseif($OData->PaymentStatus=='Partial Paid') text-primary @else text-danger @endif">
                                                <div class="col-4">Balance</div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divBalanceAmount">{{NumberFormat($OData->BalanceAmount,$Settings['price-decimals'])}}</div>
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
                                <a href="{{route('admin.transaction.orders')}}" class="btn {{$Theme['button-size']}} btn-outline-dark m-5" >Back</a>
                            @endif
                            @if($OData->Status!="Cancelled" && $OData->Status!="Delivered")
                                @if($crud['delete'])
                                    <button class="btn {{$Theme['button-size']}} btn-outline-danger m-5 btnCancelOrder" data-id="{{$OrderID}}">Cancel Order</button>
                                @endif
                                @if($crud['edit'])
                                    <button class="btn {{$Theme['button-size']}} btn-outline-success btn-air-success m-5 btnMarkAsDelivery" data-id="{{$OrderID}}">Mark as Delivered</button>
                                @endif
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
                                <input type="number" step="{{Helper::NumberSteps($Settings['price-decimals'])}}" id="txtMVACost" class="form-control" >
                                <span class="input-group-text"> for <span id="spaVNoOfItems" class="mr-5 ml-5">0</span>  Items</span>
                            </div>
                            <div class="errors err-sm order-cancel-err" id="txtMVACost-err"></div>
						</div>
					</div>
					<div class="col-12 mt-10 divMCACharge">
						<div class="form-group">
							<label for="txtMCACost">Customer Additional Charge</label>
							<div class="input-group">
                                <input type="number" step="{{Helper::NumberSteps($Settings['price-decimals'])}}" id="txtMCACost" class="form-control" value="<?php  echo NumberFormat($OData->AdditionalCost,$Settings['price-decimals']);?>">
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
                                <input type="number" step="{{Helper::NumberSteps($Settings['price-decimals'])}}" id="txtMCACost1" class="form-control" value="<?php  echo NumberFormat($OData->AdditionalCost,$Settings['price-decimals']);?>">
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
<div class="modal fade  ratingModal" id="ratingModal"  tabindex="-1">
	<div class="modal-dialog medium modal-fullscreen-lg-down">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-15 fw-600" id="ratingModalLabel">Admin Vendor Rating</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body ">
                <input type="hidden" id="txtMRVendorID">
                <input type="hidden" id="txtMRRating">
                <div class="row mb-10">
                    <label class="fw-700" for="">Rating</label>
                    <div class="col-12  mt-4" id="divRating">
                    </div>
                </div>
                <div class="row txtMRReview">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="txtMRReview">Review</label>
                            <textarea class="form-control" id="txtMRReview" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row divMRReview" style="display:none">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="fw-700 mb-1">Review</label>
                            <div id="divMRReview" style="text-align:justify;"></div>
                        </div>
                    </div>
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-outline-primary btn-sm" id="btnRatingSubmit">Submit</button>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script src="{{url('/')}}/assets/plugins/ratings/jquery.star-rating-svg.js"></script>
<script>
    $(document).ready(function(){
        let isItemCancel=false;
        let isItemDelivered=false;
		var cancelReasons={};
        var ResendOTP=false;
        const enableOTPVerify=@if($Settings['enable-Order-Delivery-verify']) true @else false @endif;
        const OTPResendDuration=parseInt("{{$Settings['otp-resend-duration']}}");
        var countdownValue =OTPResendDuration;
        const init=async()=>{
            initRatings();
            getCancelReason();
            OTPInput();
        }
        const initReviewRating=async(currentRating)=>{
            $('#ReviewRating').starRating({
                initialRating: currentRating,
                ratedColor:'gold',
                starShape: 'rounded',
                strokeWidth: 10,
                starSize: 30,
                useFullStars:true,
                disableAfterRate:false,
                readOnly:0,
                callback: function(currentRating1, el1){
                    $('#txtMRRating').val(currentRating1);
                    $('#divRating').html('<div id="ReviewRating"></div>');
                    initReviewRating(currentRating1);
                }
            });
        }
        const initRatings=async()=>{
            if($('#CustomerRating').length>0){
                let rating="{{$OData->Ratings}}";
                    rating=isNaN(parseFloat(rating))==false?parseFloat(rating):0;
                $('#CustomerRating').starRating({
                    initialRating: rating,
                    ratedColor:'gold',
                    starShape: 'rounded',
                    strokeWidth: 10,
                    starSize: 20,
                    useFullStars:true,
                    disableAfterRate:false,
                    readOnly:1
                });
            }
            $('.vendor-rating').each(function(){
                let isRated=$(this).data('is-rated')
                let rating=$(this).data('rating')
                let status=$(this).data('status')
                $(this).starRating({
                    initialRating: isNaN(parseFloat(rating))==false?parseFloat(rating):0,
                    ratedColor:'gold',
                    starShape: 'rounded',
                    strokeWidth: 10,
                    starSize: 30,
                    useFullStars:true,
                    disableAfterRate:false,
                    readOnly:parseInt(isRated)==1?1:0,
                    callback: function(currentRating, el){
                        let vID=$(el).data('vendor-id')
                        $('#txtMRVendorID').val(vID);
                        $('#txtMRRating').val(currentRating);
                        $('#divRating').html('<div id="ReviewRating"></div>');
                        setTimeout(() => {
                            initReviewRating(currentRating);
                            $('#btnRatingSubmit').show();
                            $('.txtMRReview').show();
                            $('.divMRReview').hide();
                            $('#ratingModalLabel').html('Admin Vendor Rating')
                            $('#ratingModal').modal('show');
                        }, 100);
                    }
                });
            });
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
                                    html+='<td class="text-right"><input type="number" data-vendor-id="'+vendorId+'" class="form-control txtMVACosts" steps="{{Helper::NumberSteps($Settings['price-decimals'])}}" value="'+tdata.amount+'"></td>';
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
        //admin review
        $(document).on('click','.btnReadReview',function(e){
            e.preventDefault();
            let rating=$(this).data('rating');
            let review=$(this).data('review');
            let title=$(this).data('title');

            $('#btnRatingSubmit').hide();
            $('.txtMRReview').hide();
            $('.divMRReview').show();
            $('#divMRReview').html(review);
            
            $('#divRating').html('<div id="ReviewRating"></div>'); console.log(rating)
            $('#ReviewRating').starRating({
                initialRating: rating,
                ratedColor:'gold',
                starShape: 'rounded',
                strokeWidth: 10,
                starSize: 30,
                useFullStars:true,
                readOnly:1
            });
            $('#ratingModalLabel').html(title);
            $('#ratingModal').modal('show');
        });
        $(document).on('click','#btnRatingSubmit',function(){
            let formData={}
            formData.OrderID="{{$OrderID}}";
            formData.VendorID=$('#txtMRVendorID').val();
            formData.Rating=$('#txtMRRating').val();
            formData.Review=$('#txtMRReview').val();
            $.ajax({
                type:"post",
                url: "{{route('admin.transaction.orders.vendor.rating.submit')}}",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:formData,
                dataType:"json",
                async:true,
                beforeSend:function(){
                    ajaxIndicatorStart ("The process of submitting the admin's rating for the vendor is currently in progress. Please wait a few seconds.")
                },
                complete: function(e, x, settings, exception){ajaxIndicatorStop ()},
                success:function(response){
                    if(response.status){
                        $('#ratingModal').modal('hide');
                        toastr.success(response.message, "", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
                        window.location.reload();
                    }else{
                        toastr.error(response.message, "", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
                    }
                }
            });
        });
    });
</script>
@endsection