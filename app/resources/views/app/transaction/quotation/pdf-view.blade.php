@extends('layouts.pdf')
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
</style>
<?php
    $vendorAdditionalCharges=[];
?>
<div class="container-fluid">
	<div class="row d-flex justify-content-center">
		<div class="col-12 col-sm-12 col-lg-12">
			<div class="card" id="pdf">
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
                                                <div class="col-4">Additional Amount </div>
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
			</div>
		</div>
	</div>
</div>
<div class="modal fade QuoteEditModel" id="QuoteEditModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered modal-fullscreen-md-down">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-15 fw-600" >Update</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="txtMQEID" value="{{$QID}}">
				<input type="hidden" id="txtMQEDID">
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label for="txtMQEProductName">Product Name <span class="required">*</span></label>
							<input type="text" class="form-control" id="txtMQEProductName" disabled>
                            <div class="errors err-sm quote-edit-err" id="txtMQEProductName-err"></div>
						</div>
					</div>
					<div class="col-6 mt-15">
						<div class="form-group">
							<label for="txtMQEQty">Qty <span class="required">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="txtMQEQty" >
                                <span class="input-group-text" id="spaUOM">Kg</span>
                            </div>
                            <div class="errors err-sm quote-edit-err" id="txtMQEQty-err"></div>
						</div>
					</div>
					<div class="col-6 mt-15">
						<div class="form-group">
							<label for="txtMQEPrice">Price <span class="required">*</span></label>
							<input type="number" steps="{{Helper::NumberSteps($Settings['price-decimals'])}}" class="form-control" id="txtMQEPrice"  disabled >
                            <div class="errors err-sm quote-edit-err" id="txtMQEPrice-err"></div>
						</div>
					</div>
					<div class="col-6 mt-15">
						<div class="form-group">
							<label for="txtMQETaxType">Tax Type <span class="required">*</span></label>
							<input type="text" class="form-control" id="txtMQETaxType" disabled>
                            <div class="errors err-sm quote-edit-err" id="txtMQETaxType-err"></div>
						</div>
					</div>
					<div class="col-6 mt-15">
						<div class="form-group">
							<label for="txtMQETaxPercenatge">Tax Percentage <span class="required">*</span></label>
							<input type="number"  steps="{{Helper::NumberSteps($Settings['percentage-decimals'])}}" class="form-control" id="txtMQETaxPercenatge" disabled>
                            <div class="errors err-sm quote-edit-err" id="txtMQETaxPercenatge-err"></div>
						</div>
					</div>
					<div class="col-6 mt-15">
						<div class="form-group">
							<label for="txtMQETaxable">Taxable<span class="required">*</span></label>
							<input type="number" steps="{{Helper::NumberSteps($Settings['price-decimals'])}}" class="form-control" id="txtMQETaxable" disabled>
                            <div class="errors err-sm quote-edit-err" id="txtMQETaxable-err"></div>
						</div>
					</div>
					<div class="col-6 mt-15">
						<div class="form-group">
							<label for="txtMQETaxAmount">Tax Amount <span class="required">*</span></label>
							<input type="number" steps="{{Helper::NumberSteps($Settings['price-decimals'])}}" class="form-control" id="txtMQETaxAmount" disabled>
                            <div class="errors err-sm quote-edit-err" id="txtMQETaxAmount-err"></div>
						</div>
					</div>
					<div class="col-12 mt-15">
						<div class="form-group">
							<label for="txtMQEAmount">Amount <span class="required">*</span></label>
							<input type="number" steps="{{Helper::NumberSteps($Settings['price-decimals'])}}" class="form-control" id="txtMQEAmount" disabled>
                            <div class="errors err-sm quote-edit-err" id="txtMQEAmount-err"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-outline-primary btn-sm" id="btnQuoteItemUpdate">Update</button>
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
<script src="{{url('/')}}/assets/plugins/ratings/jquery.star-rating-svg.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<script>
   
   $(document).ready(async function() {
        const pdfBlob = await new Promise((resolve, reject) => {
            let element = document.querySelector('#pdf');
            let opt = {
                margin: 0,
                filename: '{{$QData->QNo}}.pdf',
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { scale: 5, useCORS: true },
                jsPDF: { unit: 'in', format: 'a4', orientation: 'landscape' }
            };

            window.html2pdf()
                .set(opt)
                .from(element)
                .toPdf()
                .get('pdf') // Get the PDF instance
                .output('blob') // Directly call output to get a blob
                .then(blob => {
                    resolve(blob); // Resolve the blob
                })
                .catch(reject); // Handle any errors in PDF generation
        });

        const formData = new FormData();
        formData.append('QID', '{{$QData->QID}}');
        formData.append('pdf', pdfBlob, '{{$QData->QNo}}.pdf');

        $.ajax({
            type: "post",
            url: "{{route('admin.chat.save.quote.pdf')}}",
            headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
            dataType: "json",
            data: formData,
            processData: false, // Important for FormData
            contentType: false, // Important for FormData
            success: function(response) {
                if (response.status) {
                    window.close();
                } else {
                    alert("Failed to save the PDF. Please try again.");
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert("An error occurred. Please try again.");
            }
        });
    });


</script>
@endsection
