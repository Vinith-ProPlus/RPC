@extends('layouts.app')
@section('content')
<style>
    .stamp-badge {
        padding: 3px 6px;
        margin: -10px;
        z-index: 1;
    }
    .valign-top th{
        vertical-align:top !important;
    }
</style>
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-6">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Transaction</li>
					<li class="breadcrumb-item"><a href="{{ url('/') }}/admin/transaction/quotation/" data-original-title="" title="">{{$PageTitle}}</a></li>
                    <li class="breadcrumb-item">Quote View</li>
				</ol>
			</div>
            <div class="col-sm-6 text-right">
                @if($crud['view']==true)
                    <a href="{{url('/')}}/admin/transaction/quotation" class="btn {{$Theme['button-size']}} btn-outline-dark m-5" >Back</a>
                @endif
                @if($QData->Status=="New")
                    <button class="btn {{$Theme['button-size']}} btn-outline-danger m-5 btnCancelQuote" data-id="{{$QID}}">Cancel Quote</button>
                    <button class="btn {{$Theme['button-size']}} btn-outline-success btn-air-success m-5 btnOrderConvert" data-id="{{$QID}}">Move to Order</button>
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
                                                'Customer Name' => $QData->CustomerName,

                                                'Email' => $QData->Email,
                                                'Contact Number' => $QData->MobileNo1 ,
                                                'Quote Expiry Date' => date($Settings['date-format'], strtotime($QData->QExpiryDate)),
                                                'Contact Person' => ($QData->ReceiverName!="")? $QData->ReceiverName." <span> (".$QData->ReceiverMobNo.")</span>":"",
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
                                                $Address="";
                                                // if($QData->CustomerName!=""){$Address.="<b>".$QData->CustomerName."</b>";}
                                                if($QData->BAddress!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$QData->BAddress;}
                                                if($QData->BCityName!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$QData->BCityName;}
                                                if($QData->BTalukName!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$QData->BTalukName;}
                                                if($QData->BDistrictName!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$QData->BDistrictName;}
                                                if($QData->BStateName!=""){if($Address!=""){$Address.=",<br>";}$Address.=$QData->BStateName;}
                                                if($QData->BCountryName!=""){if($Address!=""){$Address.=", ";}$Address.=$QData->BCountryName;}
                                                if($QData->BPostalCode!=""){if($Address!=""){$Address.=" - ";}$Address.=$QData->BPostalCode;}
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
                                    <h6 class="text-center fw-700">Quotation</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table" id="tblQuoteDetails">
                                        <thead>
                                            <tr class="valign-top">
                                                <th class="text-center align-middle">S.No</th>
                                                <th class="text-center align-middle">Product Name</th>
                                                <th class="text-center align-middle">Qty</th>
                                                <th class="text-center align-middle">Price<br> (₹)</th>
                                                <th class="text-center align-middle">Tax Type</th>
                                                <th class="text-center align-middle">Taxable<br> (₹)</th>
                                                <!---->
                                                @if(count($QData->Details)>0)
                                                    @if(floatval($QData->Details[0]->IGSTAmt)<=0)
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
                                                @if($QData->Status=="New" && $crud['delete']==true)
                                                <th class="text-center align-middle">Action</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($QData->Details as $key=>$item)
                                                <tr data-vendor-id="{{$item->VendorID}}" data-detail-id="{{$item->DetailID}}">
                                                    <td>{{$key + 1}}</td>
                                                    <td>{{$item->ProductName}}</td>
                                                    <td class="text-right">{{$item->Qty}} {{$item->UCode}}</td>
                                                    <td class="text-right">{{!$item->isCancelled ? NumberFormat($item->Price, $Settings['price-decimals']) : '--'}}</td>
                                                    <td>{{!$item->isCancelled ? $item->TaxType : '--'}}</td>
                                                    <td class="text-right">{{!$item->isCancelled ? NumberFormat($item->Taxable, $Settings['price-decimals']) : '--'}}</td>
                                                    <!--<td class="text-right">{{!$item->isCancelled ? NumberFormat($item->TaxAmt, $Settings['price-decimals']) : '--'}}</td>-->
                                                    @if(count($QData->Details)>0)
                                                        @if(floatval($item->IGSTAmt)<=0)
                                                            <td class="text-right">
                                                                <div>{{NumberFormat($item->CGSTAmt, $Settings['price-decimals'])}}</div>
                                                                <div class="fs-11">({{floatval(NumberFormat($item->CGSTPer, $Settings['percentage-decimals']))}}%)</div>
                                                            </td>
                                                            <td class="text-right">
                                                                <div>{{NumberFormat($item->SGSTAmt, $Settings['price-decimals'])}}</div>
                                                                <div class="fs-11">({{floatval(NumberFormat($item->SGSTPer, $Settings['percentage-decimals']))}}%)</div>
                                                            </td>
                                                        @else
                                                            <td class="text-right">
                                                                <div>{{NumberFormat($item->IGSTAmt, $Settings['price-decimals'])}}</div>
                                                                <div class="fs-11">({{floatval(NumberFormat($item->IGSTPer, $Settings['percentage-decimals']))}}%)</div>
                                                            </td>
                                                        @endif
                                                    @else
                                                        <td class="text-right">{{NumberFormat(0, $Settings['price-decimals'])}}</td>
                                                    @endif
                                                    <td class="text-right">{{!$item->isCancelled ? NumberFormat($item->TotalAmt, $Settings['price-decimals']) : '--'}}</td>
                                                    <td><span class=" fw-600 text-info text-center">{{$item->VendorName}}</span></td>
                                                    @if($QData->Status=="New"  && $crud['delete']==true)
                                                        <td class="text-center">
                                                            @if(!$item->isCancelled)
                                                                <button type="button"  data-vendor-id="{{$item->VendorID}}" data-additional-charge="<?php if(array_key_exists($item->VendorID,$QData->AdditionalCharges)){ echo $QData->AdditionalCharges[$item->VendorID];}else{ echo 0;} ?>" data-detail-id="{{$item->DetailID}}" data-qno="{{$item->ProductName}}" data-id="{{$item->QID}}" class="btn btn-outline-danger btnQItemDelete" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                            @else
                                                                <span class=" fw-600 text-danger text-center">Cancelled</span>
                                                            @endif
                                                        </td>
                                                    @endif
                                                    <?php
                                                        $tmpAmount=0;
                                                        if(array_key_exists($item->VendorID,$QData->AdditionalCharges)){ $tmpAmount=$QData->AdditionalCharges[$item->VendorID];}
                                                        $vendorAdditionalCharges[$item->VendorID]=["name"=>$item->VendorName,"amount"=>$tmpAmount]
                                                    ?>
                                                    <td class="tdata" style="display:none"><?php echo json_encode($item); ?></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="row justify-content-end mt-20">
                                        <div class="col-sm-6 ">
                                            <div class="card shadow-sm">
                                                <div class="card-header">
                                                    <div class="row">
                                                        <div class="col-2"></div>
                                                        <div class="col-8 text-center fw-600">Vendor Additional Charges</div>
                                                        <div class="col-2 text-right"> @if($QData->Status=="New")<a href="#" id="btnEditVACharges" title="Update Vendor's Additional Costs"><i class="fa fa-pencil" ></i></a> @endif</div>
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
                                        <div class="col-sm-6">
                                            <div class="row fw-500 fs-13 mr-10 justify-content-end">
                                                <div class="col-4">Sub Total</div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divSubTotal">{{NumberFormat($QData->SubTotal,$Settings['price-decimals'])}}</div>
                                            </div>
                                            @if(count($QData->Details)>0)
                                                @if(floatval($QData->IGSTAmount)<=0)
                                                    <div class="row mt-10 fw-500 fs-13 mr-10 justify-content-end">
                                                        <div class="col-4">CGST</div>
                                                        <div class="col-1">:</div>
                                                        <div class="col-3 text-right" id="divCGSTAmount">{{NumberFormat($QData->CGSTAmount,$Settings['price-decimals'])}}</div>
                                                    </div>
                                                    <div class="row mt-10 fw-500 fs-13 mr-10 justify-content-end">
                                                        <div class="col-4">SGST</div>
                                                        <div class="col-1">:</div>
                                                        <div class="col-3 text-right" id="divSGSTAmount">{{NumberFormat($QData->SGSTAmount,$Settings['price-decimals'])}}</div>
                                                    </div>
                                                @else
                                                    <div class="row mt-10 fw-500 fs-13 mr-10 justify-content-end">
                                                        <div class="col-4">IGST</div>
                                                        <div class="col-1">:</div>
                                                        <div class="col-3 text-right" id="divIGSTAmount">{{NumberFormat($QData->IGSTAmount,$Settings['price-decimals'])}}</div>
                                                    </div>
                                                @endif
                                            @else

                                                <div class="row mt-10 fw-500 fs-13 mr-10 justify-content-end">
                                                    <div class="col-4">Tax Amount</div>
                                                    <div class="col-1">:</div>
                                                    <div class="col-3 text-right" id="divTaxAmount">{{NumberFormat($QData->TaxAmount,$Settings['price-decimals'])}}</div>
                                                </div>
                                            @endif
                                            <div class="row mt-10 fw-600 fs-14 mr-10 justify-content-end">
                                                <div class="col-4">Total Amount</div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divTotalAmount">{{NumberFormat($QData->TotalAmount,$Settings['price-decimals'])}}</div>
                                            </div>
                                            <div class="row mt-10 fw-500 fs-13 mr-10 justify-content-end">
                                                <div class="col-4">Additional Amount @if($QData->Status=="New") <a href="#" class="ml-5" id="btnEditCustomerCost" title="Click here to edit customer additional charges."><i class="fa fa-pencil"></i></a> @endif</div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divAdditionalAmount">{{NumberFormat($QData->AdditionalCost,$Settings['price-decimals'])}}</div>
                                            </div>
                                            <div class="row mt-10 fw-800 fs-17 mr-10 justify-content-end text-success">
                                                <div class="col-4">Net Amount</div>
                                                <div class="col-1">:</div>
                                                <div class="col-3 text-right" id="divOverAllAmount">{{NumberFormat($QData->NetAmount,$Settings['price-decimals'])}}</div>
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
                                <a href="{{url('/')}}/admin/transaction/quotation" class="btn {{$Theme['button-size']}} btn-outline-dark m-5" >Back</a>
                            @endif
                            @if($QData->Status=="New")
                                @if($crud['delete'])
                                    <button class="btn {{$Theme['button-size']}} btn-outline-danger m-5 btnCancelQuote" data-id="{{$QID}}">Cancel Quote</button>
                                @endif
                                @if($OtherCRUD['order']['add']==true)
                                    <button class="btn {{$Theme['button-size']}} btn-outline-success btn-air-success m-5 btnOrderConvert" data-id="{{$QID}}">Move to Order</button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade QuoteCancelModel" id="QuoteCancelModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered modal-fullscreen-md-down">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-15 fw-600" id="QuoteCancelModelLabel">Quote Cancel</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
							<select id="lstMCancelReason" class="form-control select2" data-parent=".QuoteCancelModel">
								<option value="">Select a reason</option>
							</select>
                            <div class="errors err-sm quote-cancel-err" id="lstMCancelReason-err"></div>
						</div>
					</div>
					<div class="col-12 mt-10">
						<div class="form-group">
							<label for="txtMDescription">Description</label>
							<textarea name="" id="txtMDescription" rows=4 class="form-control"></textarea>
                            <div class="errors err-sm quote-cancel-err" id="txtMDescription-err"></div>
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
                            <div class="errors err-sm quote-cancel-err" id="txtMVACost-err"></div>
						</div>
					</div>
					<div class="col-12 mt-10 divMCACharge">
						<div class="form-group">
							<label for="txtMCACost">Customer Additional Charge</label>
							<div class="input-group">
                                <input type="number" step="{{Helper::NumberSteps($Settings['price-decimals'])}}" id="txtMCACost" class="form-control" value="<?php  echo NumberFormat($QData->AdditionalCost,$Settings['price-decimals']);?>">
                                <span class="input-group-text"> for <span id="spaCNoOfItems" class="mr-5 ml-5">{{count($QData->Details)}}</span>  Items</span>
                            </div>
                            <div class="errors err-sm quote-cancel-err" id="txtMCACost-err"></div>
						</div>
					</div>
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-outline-primary btn-sm" id="btnCancelQuote">Cancel Quote</button>
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
                                <input type="number" step="{{Helper::NumberSteps($Settings['price-decimals'])}}" id="txtMCACost1" class="form-control" value="<?php  echo NumberFormat($QData->AdditionalCost,$Settings['price-decimals']);?>">
                                <span class="input-group-text"> for <span  class="mr-5 ml-5">{{count($QData->Details)}}</span>  Items</span>
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
<div class="modal fade  ApproveOrder" id="ApproveOrder" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
	<div class="modal-dialog medium modal-fullscreen-lg-down">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-15 fw-600" id="updateCAChargesLabel">Order Details</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
                <div class="row">
					<div class="col-12 mt-10">
						<div class="form-group">
							<label for="dtpDeliveryExpected">Expected Delivery</label>
                            <input type="date"  id="dtpDeliveryExpected" class="form-control" min="{{date('Y-m-d')}}" value="<?php echo date("Y-m-d",strtotime(intval($Settings['Order-Delivery-Expected-days'])." days")); ?>">
						</div>
					</div>
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-outline-primary btn-sm" id="btnMoveOrder">Proceed to Order</button>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        let isItemCancel=false;
		var cancelReasons={};
        const init=async()=>{
            getCancelReason();
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
			$('#lstMCancelReason').select2({ dropdownParent: $('.QuoteCancelModel')});
		}
        init();
        $(document).on('click','#btnEditCustomerCost',function(e){
            e.preventDefault();
            $('#updateCACharges').modal('show');
        });
        $(document).on('click','#btnUpdateCustomerCost',function(e){
			let formData={};
			formData.QID="{{$QID}}";
			formData.AdditionalCharges=$('#txtMCACost1').val();
			$.ajax({
                type:"post",
                url: "{{route('admin.transaction.quotes.update.customer-cost',$QID)}}",
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
                        let VNoOfItems=$('#tblQuoteDetails tbody tr[data-vendor-id="'+vendorId+'"]').length;
                        let html="<tr>";
                                html+='<td>'+tdata.name+'</td>';
                                html+='<td  class="text-right">'+VNoOfItems+'</td>';
                                html+='<td class="text-right"><input type="number" data-vendor-id="'+vendorId+'" class="form-control txtMVACosts" steps="{{Helper::NumberSteps($Settings['price-decimals'])}}" value="'+tdata.amount+'"></td>';
                            html+='</tr>';
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
        $(document).on('click','#btnUpdateCost',function(e){
            let details={};
            $('#tblVACharges tbody tr input.txtMVACosts').each(function(index){
                let VID=$(this).attr('data-vendor-id');
                details[VID]=$(this).val()
            });
			let formData={};
			formData.QID="{{$QID}}";
			formData.EnqID="{{$QData->EnqID}}";
			formData.details=JSON.stringify(details);
			$.ajax({
                type:"post",
                url: "{{route('admin.transaction.quotes.update.vendor-cost',$QID)}}",
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
		$(document).on('click','.btnQItemDelete',function(){

            isItemCancel=true;
			let ID=$(this).attr('data-id');
			let DID=$(this).attr('data-detail-id');
			let vendorId=$(this).attr('data-vendor-id');
            let AdditionalCharges=$(this).attr('data-additional-charge');
            let VNoOfItems=$('#tblQuoteDetails tbody tr[data-vendor-id="'+vendorId+'"]').length-1
            let CNoOfItems=$('#tblQuoteDetails tbody tr').length-1
			let QNo=$(this).attr('data-qno');
			let QuoteCancelModelLabel="Item Cancel "
			QuoteCancelModelLabel+=QNo!=""?" - "+QNo:"";
			$('#QuoteCancelModelLabel').html(QuoteCancelModelLabel);
			$('#txtMQDID').val(DID);
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
            $('#btnCancelQuote').html('Cancel Item');
			$('#QuoteCancelModel').modal('show');
		});
		$(document).on('click','.btnCancelQuote',function(){
            isItemCancel=false;
			let ID=$(this).attr('data-id');
			let QNo=$(this).attr('data-qno');
			let QuoteCancelModelLabel="Quote Cancel "
			QuoteCancelModelLabel+=QNo!=""?" - "+QNo:"";
			$('#QuoteCancelModelLabel').html(QuoteCancelModelLabel);
			$('#txtMQDID').val("");
			$('#txtMVendorID').val("");
            $('#btnCancelQuote').html('Cancel Quote');
            $('.divMVACharge').hide();
            $('.divMCACharge').hide();
			$('#QuoteCancelModel').modal('show');
		});
		$(document).on('click','#btnCancelQuote',function(){
            const validate=(formData)=>{
                let status=true;
                $('.quote-cancel-err').html('');
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
			formData.QID=$('#txtMQID').val();
			formData.QDID=$('#txtMQDID').val();
			formData.ReasonID=$('#lstMCancelReason').val();
			formData.Description=$('#txtMDescription').val();
			formData.VACharges=$('#txtMVACost').val();
			formData.CACharges=$('#txtMCACost').val();
			formData.EnqID=$('#txtMEnqID').val();
			formData.VendorID=$('#txtMVendorID').val();
            if(validate(formData)==true){
                $.ajax({
                    type:"post",
                    url: isItemCancel?"{{route('admin.transaction.quotes.cancel-item','__ID__')}}".replace("__ID__",formData.QDID):"{{route('admin.transaction.quotes.cancel','__ID__')}}".replace("__ID__",formData.QID),
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    data:formData,
                    dataType:"json",
                    async:true,
                    beforeSend:function(){
                        let text=isItemCancel?"Quotation Item Cancellation on process.":"Quotation Cancellation on process.";
                        ajaxIndicatorStart (text)
                    },
                    complete: function(e, x, settings, exception){
                        ajaxIndicatorStop ()
                    },
                    success:function(response){
                        if(response.status){
                            $('#QuoteCancelModel').modal('hide');
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
        $(document).on('click','.btnOrderConvert',function(){
            $('#ApproveOrder').modal('show');
        });
        $(document).on('click','#btnMoveOrder',function(){
            swal({
                title: "Are you sure?",
                text: "Do you want to move this quote to an order?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-outline-success",
                confirmButtonText: "Move",
                closeOnConfirm: false
            },function(){
                swal.close();
                $.ajax({
                    type:"post",
                    url: "{{route('admin.transaction.quotes.approve',$QID)}}",
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    data:{ExpectedDelivery:$('#dtpDeliveryExpected').val()},
                    dataType:"json",
                    async:true,
                    beforeSend:function(){
                        ajaxIndicatorStart ("The process of moving the quote to the order is currently in progress. Please wait for a few minutes.")
                    },
                    complete: function(e, x, settings, exception){
                        ajaxIndicatorStop ()
                    },
                    success:function(response){
                        if(response.status){
                            $('#ApproveOrder').modal('hide');
                            toastr.success(response.message, "", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
                            window.location.reload();
                        }else{
                            toastr.error(response.message, "", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0})
                        }
                    }
                });
            });
        });
    });
</script>
@endsection
