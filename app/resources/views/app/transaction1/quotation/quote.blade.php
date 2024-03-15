@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Transaction</li>
					<li class="breadcrumb-item"><a href="{{ url('/') }}/transaction/quotation/" data-original-title="" title="">{{$PageTitle}}</a></li>
                    <li class="breadcrumb-item">@if($isEdit==true)Update @else Create @endif</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row d-flex justify-content-center">
		<div class="col-12 col-sm-12 col-lg-12">
			<div class="card">
				<div class="card-header text-center"><h5 class="mt-10">{{$PageTitle}}</h5></div>
                <div class="card-body ">
                    <div class="row">
                    {{-- <div class="col-sm-12 mt-20">
                        <div class="form-group">
                            <label class="txtQuotationName"> Quotation Name <span class="required"> * </span></label>
                            <input type="text" class="form-control  {{$Theme['input-size']}}" id="txtQuotationName" value="<?php if($isEdit==true){ echo $EditData[0]->QuotationName;} ?>">
                            <div class="errors" id="txtQuotationName-err"></div>
                        </div>
                    </div> --}}
                    <div class="col-sm-2">
                        {{-- <button type="button" class="btn btn-outline-info btnAddAddress">Add New Address</button> --}}
                    </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Quote No {{-- @if($isEdit==false) <span class="err-sm" style="color:#f5970b">( Quote No may be Change )</span> @endif --}}</label>
                                                <input type="text" disabled class="form-control" id="txtQNo" value="<?php if($isEdit==true){ echo $EditData[0]['QNo'];}else{ echo $QNo;} ?>">
                                                <div class="errors" id="txtQNo-err"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Quote Date</label>
                                                <input type="date" class="form-control" id="dtpQDate" min="<?php if($isEdit==true){ echo date("Y-m-d",strtotime($EditData[0]['QDate']));}else{ echo date("Y-m-d",strtotime('-5 days'));} ?>" value="<?php if($isEdit==true){ echo date("Y-m-d",strtotime($EditData[0]['QDate']));}else{ echo date("Y-m-d");} ?>">
                                                <div class="errors" id="dtpQDate-err"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Quote  Expiry</label>
                                                <input type="date" class="form-control" id="dtpQExpiry" min="<?php if($isEdit==true){ echo date("Y-m-d",strtotime($EditData[0]['QExpiryDate']));}else{ echo date("Y-m-d",strtotime('-5 days'));} ?>" data-expiry-days="{{$Settings['Quote-Valid']}}" value="<?php if($isEdit==true){ echo date("Y-m-d",strtotime($EditData[0]['QExpiryDate']));}else{ echo date('Y-m-d',strtotime($Settings['Quote-Valid'].' days'));} ?>">
                                                <div class="errors" id="dtpQExpiry-err"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mt-20">
                                            <div class="form-group">
                                                <label>Customer Name</label>
                                                <input type="text" class="form-control" id="txtCustomerName" value="<?php if($isEdit==true){ echo $EditData[0]['CustomerName'];} ?>">
                                                <div class="errors" id="lstCustomer-err"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mt-20">
                                            <div class="form-group">
                                                <label>Mobile No</label>
                                                <input type="text" class="form-control" id="txtMobileNo" value="<?php if($isEdit==true){ echo $EditData[0]['MobileNo1'];} ?>">
                                                <div class="errors" id="lstPlaceOfSupply-err"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mt-20">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" class="form-control" id="txtGSTNo" value="<?php if($isEdit==true){ echo $EditData[0]['GSTNo'];} ?>">
                                                <div class="errors" id="txtGSTNo-err"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6 pl-20">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="card shadow-sm">
                                                        <div class="card-header p-10">
                                                            <div class="text-center fs-17 fw-600">Billing Address <button id="btnBAChange" title="Change the billing address" class="btn btn-sm btn-link full-right mr-10 pt-5 btnAddAddress">
                                                                    <i class="fa fa-pencil"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="card-body mh-130 p-10">
                                                            <?php
                                                                $BData=array();
                                                                if($isEdit){
                                                                    $tmp=$EditData[0]['BAttention']!=""?"<span class='fs-15 fw-700'>".$EditData[0]['BAttention']."</span>,<br>":"";
            
                                                                    $tmp.=$EditData[0]['BAddress']!=""?$EditData[0]['BAddress'].",<br>":"";
            
                                                                    $tmp.=$EditData[0]['BCityName'];
            
                                                                    if($tmp!=""){$tmp.=", ";}
                                                                    $tmp.=$EditData[0]['BStateName'];
            
                                                                    if($tmp!=""){$tmp.=",<br> ";}
                                                                    $tmp.=$EditData[0]['BCountryName'];
            
                                                                    if($tmp!=""){$tmp.="- ";}
                                                                    $tmp.=$EditData[0]['BPostalCode'];
            
                                                                    if($tmp!=""){$tmp.=".";}
                                                                            
                                                                    $BData=array("Title"=>"","Attention"=>$EditData[0]['BAttention'],"Address"=>$EditData[0]['BAddress'],"CityID"=>$EditData[0]['BCityID'],"CityName"=>$EditData[0]['BCityName'],"StateName"=>$EditData[0]['BStateName'],"StateID"=>$EditData[0]['BStateID'],"CountryName"=>$EditData[0]['BCountryName'],"CountryID"=>$EditData[0]['BCountryID'],"PostalCode"=>$EditData[0]['BPostalCode'],"PostalCodeID"=>$EditData[0]['BPostalCodeID']);
                                                                }
                                                            ?>
                                                            <div id="divBillingAddress"><?php if($isEdit){ echo $tmp;} ?></div>
                                                            <div class="display-none" id="divBillingData"><?php if($isEdit){ echo json_encode($BData);} ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-20">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="card shadow-sm">
                                                        <div class="card-header p-10">
                                                            <div class="text-center fs-17 fw-600">Shipping Address <button id="btnSAChange" title="Change the shipping address" class="btn btn-sm btn-link full-right mr-10 pt-5 btnAddAddress">
                                                                    <i class="fa fa-pencil"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="card-body mh-130 p-10">
                                                            
                                                            <?php
                                                                $SData=array();
                                                                if($isEdit){
                                                                    $tmp=$EditData[0]['SAttention']!=""?"<span class='fs-15 fw-700'>".$EditData[0]['SAttention']."</span>,<br>":"";
                
                                                                    $tmp.=$EditData[0]['SAddress']!=""?$EditData[0]['SAddress'].",<br>":"";
                
                                                                    $tmp.=$EditData[0]['SCityName'];
                
                                                                    if($tmp!=""){$tmp.=", ";}
                                                                    $tmp.=$EditData[0]['SStateName'];
                
                                                                    if($tmp!=""){$tmp.=",<br> ";}
                                                                    $tmp.=$EditData[0]['SCountryName'];
                
                                                                    if($tmp!=""){$tmp.="- ";}
                                                                    $tmp.=$EditData[0]['SPostalCode'];
                
                                                                    if($tmp!=""){$tmp.=".";}
                                                                                
                                                                    $SData=array("Title"=>"","Attention"=>$EditData[0]['SAttention'],"Address"=>$EditData[0]['SAddress'],"CityID"=>$EditData[0]['SCityID'],"CityName"=>$EditData[0]['SCityName'],"StateName"=>$EditData[0]['SStateName'],"StateID"=>$EditData[0]['SStateID'],"CountryName"=>$EditData[0]['SCountryName'],"CountryID"=>$EditData[0]['SCountryID'],"PostalCode"=>$EditData[0]['SPostalCode'],"PostalCodeID"=>$EditData[0]['SPostalCodeID']);
                                                                }
                                                            ?>
                                                            <div id="divShippingAddress"><?php if($isEdit){ echo $tmp;} ?></div>
                                                            <div class="display-none" id="divShippingData"><?php if($isEdit){ echo json_encode($SData);} ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label class="lstICategory">Category <span class="required"> * </span></label>
                                        <select class="form-control select2" id="lstICategory">
                                            <option value ="">Select a Category </option>
                                        </select>
                                        <div class="errors details text-sm" id="lstICategory-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label class="lstISubCategory">Sub Category <span class="required"> * </span></label>
                                        <select class="form-control select2" id="lstISubCategory">
                                            <option value ="">Select a Sub Category </option>
                                        </select>
                                        <div class="errors details text-sm" id="lstISubCategory-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label class="lstIProduct">Product <span class="required"> * </span></label>
                                        <select class="form-control select2" id="lstIProduct">
                                            <option value ="">Select a Product </option>
                                        </select>
                                        <div class="errors details text-sm" id="lstIProduct-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="txtIDescription">Description</label>
                                        <textarea class="form-control" rows=1 id="txtIDescription"></textarea>
                                        <div class="errors details text-sm" id="txtIDescription-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label class="txtIQty">Qty <span class="required"> * </span></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control"  step="{{NumberSteps($Settings['QTY-DECIMALS'])}}" id="txtIQty">
                                            <select disabled class="form-control" id="lstIUOM">
                                            </select>
                                        </div>
                                        <div class="errors details text-sm" id="txtIQty-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-1 pt-20 text-center">
                                    <button class="btn btn-sm btn-outline-danger m-5" id="btnICancel" style="display:none;">Cancel</button>
                                    <button class="btn btn-sm btn-outline-info m-5" id="btnIAdd">Add</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 pb-20 table-responsive">
                                    <table class="table table-sm" id="tblDetails">
                                        <thead>
                                            <tr>
                                                <th class="text-center">SNo</th>
                                                <th class="text-center">Category</th>
                                                <th class="text-center">Sub Category</th>
                                                <th class="text-center">Product</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-center">Action</th>
                                                <th class="text-center display-none"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($isEdit)

                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="col-sm-6 ">
                                    <div class="row display-none">
                                        <div class="col-sm-6">
                                            <div class="checkbox checkbox-primary">
                                                <input  id="chkAddShippingCharges" type="checkbox" @if($isEdit)@if($EditData[0]['isShippingCharges']) checked @endif @endif><label for="chkAddShippingCharges"> Add  Shipping Charges</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 divAddShippingCharges"  style="@if($isEdit)@if($EditData[0]['isShippingCharges']==0) display:none @endif @else display:none @endif">
                                            <div class="form-group">
                                                <input type="number" class="form-control" step="{{NumberSteps($Settings['PRICE-DECIMALS'])}}" id="txtShippingCharge" value="<?php if($isEdit){ echo $EditData[0]['ShippingCharges'];} ?>">
                                                <div class="errors text-sm" id="txtShippingCharge-err"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row display-none">
                                        <div class="col-sm-6">
                                            <div class="checkbox checkbox-primary">
                                                <input  id="chkAddDiscount" type="checkbox" @if($isEdit)@if($EditData[0]['isAddDiscount']) checked @endif @endif><label for="chkAddDiscount"> Add  Discount</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 divAddDiscount"   style="@if($isEdit)@if($EditData[0]['isAddDiscount']==0) display:none @endif @else display:none @endif">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="number" class="form-control" step="{{NumberSteps($Settings['PERCENTAGE-DECIMALS'])}}" id="txtDiscount" value="<?php if($isEdit){ if($EditData[0]['DiscountType']=="Fixed"){echo $EditData[0]['DiscountAmount'];}else{echo $EditData[0]['DiscountPer'];}} ?>">
                                                    <select class="form-control" id="lstDiscountType">
                                                        <option value="Percentage" @if($isEdit) @if($EditData[0]['DiscountType']=="Percentage") selected @endif @endif>Percentage</option>
                                                        <option value="Fixed"  @if($isEdit) @if($EditData[0]['DiscountType']=="Fixed") selected @endif @endif>Fixed</option>
                                                    </select>
                                                </div>
                                                <div class="errors text-sm" id="txtDiscount-err"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row display-none">
                                        <div class="col-sm-6">
                                            <div class="checkbox checkbox-primary">
                                                <input  id="chkSubjectReverseCharge" type="checkbox" @if($isEdit)@if($EditData[0]['isSubjectReverse']) checked @endif @endif><label for="chkSubjectReverseCharge"> Subject to Reverse Charge</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="checkbox checkbox-primary">
                                                <input  id="chkOtherRef" type="checkbox" @if($isEdit)@if($EditData[0]['isOtherRef']) checked @endif @endif><label for="chkOtherRef"> Other Ref.</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6" id="divOtherRef" style="@if($isEdit)@if($EditData[0]['isOtherRef']==0) display:none @endif @else display:none @endif">
                                            <div class="form-group">
                                                <textarea rows=1 class="form-control"  id="txtOtherRef"><?php if($isEdit){ echo $EditData[0]['OtherRef'];} ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="checkbox checkbox-primary">
                                                <input  id="chkAddTermOfDelivery" type="checkbox" @if($isEdit)@if($EditData[0]['isTermOfDelivery']) checked @endif @endif><label for="chkAddTermOfDelivery"> Term of Delivery</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6" id="divAddTermOfDelivery" style="@if($isEdit)@if($EditData[0]['isTermOfDelivery']==0) display:none @endif @else display:none @endif">
                                            <div class="form-group">
                                                <textarea rows=1 class="form-control"  id="txtAddTermOfDelivery"><?php if($isEdit){ echo $EditData[0]['TermOfDelivery'];} ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="checkbox checkbox-primary">
                                                <input  id="chkDispatchThrough" type="checkbox" @if($isEdit)@if($EditData[0]['isDispatchThrough']) checked @endif @endif><label for="chkDispatchThrough"> Dispatch Through</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6" id="divDispatchThrough" style="@if($isEdit)@if($EditData[0]['isDispatchThrough']==0) display:none @endif @else display:none @endif">
                                            <div class="form-group">
                                                <textarea rows=1 class="form-control"  id="txtDispatchThrough"><?php if($isEdit){ echo $EditData[0]['DispatchThrough'];} ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="checkbox checkbox-primary">
                                                <input  id="chkPaymentTerms" type="checkbox" @if($isEdit)@if($EditData[0]['isPaymentTerms']) checked @endif @endif><label for="chkPaymentTerms"> Payment Terms</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6" id="divPaymentTerms" style="@if($isEdit)@if($EditData[0]['isPaymentTerms']==0) display:none @endif @else display:none @endif">
                                            <div class="form-group">
                                                <textarea rows=1 class="form-control"  id="txtPaymentTerms"><?php if($isEdit){ echo $EditData[0]['PaymentTerms'];} ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row display-none">
                                        <div class="col-sm-6">
                                            <div class="checkbox checkbox-primary">
                                                <input  id="chkTransportLabels" type="checkbox" @if($isEdit)@if($EditData[0]['isTransportLabels']) checked @endif @endif><label for="chkTransportLabels"> Transport Labels</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6"></div>
                                    </div>
                                    <div id="divTransportLabels"  style="@if($isEdit)@if($EditData[0]['isTransportLabels']==0) display:none @endif @else display:none @endif" class=" ml-20">
                                        <div class="row mt-20">
                                            <div class="col-sm-4">
                                                <select class="form-control" id="lstTranType">
                                                    <option value="Waybill No." @if($isEdit) @if($EditData[0]['TranBillType']=="Waybill No.") selected @endif @endif>Waybill No.</option>
                                                    <option value="e-Sugam No." @if($isEdit) @if($EditData[0]['TranBillType']=="e-Sugam No.") selected @endif @endif>e-Sugam No.</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6"><input type="text" class="form-control" id="txtTransBillNo" name="txtTransBillNo" value="<?php if($isEdit){ echo $EditData[0]['TranBillNo'];} ?>"><div class="errors text-sm" id="txtTransBillNo-err"></div></div>
                                        </div>
                                        <div class="row mt-20">
                                            <div class="col-sm-4"><label class="pt-10" >LR. No.</label></div>
                                            <div class="col-sm-6 "><input type="text" class="form-control" id="txtTransLRNo" value="<?php if($isEdit){ echo $EditData[0]['LRNo'];} ?>" ><div class="errors text-sm" id="txtTransLRNo-err"></div></div>
                                        </div>
                                        <div class="row mt-20">
                                            <div class="col-sm-4"><label class="pt-10" >Challan No.</label></div>
                                            <div class="col-sm-6 "><input type="text" class="form-control" id="txtTransChallenNo" value="<?php if($isEdit){ echo $EditData[0]['ChellanNo'];} ?>"><div class="errors text-sm" id="txtTransChallenNo-err"></div></div>
                                        </div>
                                        <div class="row mt-20">
                                            <div class="col-sm-4"><label class="pt-10" >Vehicle No.</label></div>
                                            <div class="col-sm-6 "><input type="text" class="form-control" id="txtTransVehicleNo" value="<?php if($isEdit){ echo $EditData[0]['VehicleNo'];} ?>"><div class="errors text-sm" id="txtTransVehicleNo-err"></div></div>
                                        </div>
                                        <div class="row mt-20">
                                            <div class="col-sm-4"><label class="pt-10" >Ship by</label></div>
                                            <div class="col-sm-6 "><input type="text" class="form-control" id="txtTransShipBy" value="<?php if($isEdit){ echo $EditData[0]['ShipBy'];} ?>"><div class="errors text-sm" id="txtTransShipBy-err"></div></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row justify-content-end mt-20 fw-600 fs-16 mr-10">
                                        <div class="col-sm-4">Sub Total <span class="cright">:</span></div>
                                        <div class="col-sm-4 text-right" id="divSubTotal"> {{NumberFormat(0,$Settings['PRICE-DECIMALS'])}}</div>
                                    </div>
                                    <div class="row justify-content-end mt-20 fw-600 fs-16 mr-10">
                                        <div class="col-sm-4">CGST <span class="cright">:</span></div>
                                        <div class="col-sm-4 text-right"  id="divCGSTAmount"> {{NumberFormat(0,$Settings['PRICE-DECIMALS'])}}</div>
                                    </div>
                                    <div class="row justify-content-end mt-20 fw-600 fs-16 mr-10">
                                        <div class="col-sm-4">SGST <span class="cright">:</span></div>
                                        <div class="col-sm-4 text-right"  id="divSGSTAmount"> {{NumberFormat(0,$Settings['PRICE-DECIMALS'])}}</div>
                                    </div>
                                    <div class="row justify-content-end mt-20 fw-600 fs-16 mr-10">
                                        <div class="col-sm-4">IGST <span class="cright">:</span></div>
                                        <div class="col-sm-4 text-right"  id="divIGSTAmount"> {{NumberFormat(0,$Settings['PRICE-DECIMALS'])}}</div>
                                    </div>
                                    <div class="row justify-content-end mt-20 fw-600 fs-16 mr-10 divAddShippingCharges" style="display:none">
                                        <div class="col-sm-4">Shipping & Package <span class="cright">:</span></div>
                                        <div class="col-sm-4 text-right"  id="divShippingChargesAmount"> {{NumberFormat(0,$Settings['PRICE-DECIMALS'])}}</div>
                                    </div>
                                    <div class="row justify-content-end mt-20 fw-600 fs-16 mr-10 divAddDiscount"  style="display:none">
                                        <div class="col-sm-4 ">Discount <span id="divDiscountPercentage" data-percentage="0"></span> <span class="cright">:</span></div>
                                        <div class="col-sm-4 text-right"  id="divDiscountAmount"> {{NumberFormat(0,$Settings['PRICE-DECIMALS'])}}</div>
                                    </div>
                                    <div class="row justify-content-end mt-20  fw-700 fs-18 mr-10 text-success">
                                        <div class="col-sm-4">Total Amount <span class="cright">:</span></div>
                                        <div class="col-sm-4 text-right"  id="divTotalAmount"> {{NumberFormat(0,$Settings['PRICE-DECIMALS'])}} </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="card-footer row mt-20">
                    <div class="col-sm-12 text-right">
                        @if($crud['view']==true)
                        <a href="{{url('/')}}/transaction/quotation" class="btn {{$Theme['button-size']}} btn-outline-dark mr-10" id="btnCancel">Back</a>
                        @endif
                        
                        @if((($crud['add']==true) && ($isEdit==false))||(($crud['edit']==true) && ($isEdit==true)))
                            <button class="btn {{$Theme['button-size']}} btn-outline-success" id="btnSave">@if($isEdit==true) Update @else Save @endif</button>
                        @endif
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
        
    });

    let Vendors = {
        General : {
            "VendorID" : "",
            "VendorName" : "",
            "GSTNo" : "",
            "CID" : "",
            "VendorType" : "",
            "MobileNumber1": "9754029132",
            "MobileNumber2": "",
            "Address": "6, Aandal St,",
            "PostalCodeID": "PC2023-0015260",
            "CityID": "CI2023-0115272",
            "TalukID": "T2023-00007979",
            "DistrictID": "DT2023-00000497",
            "StateID": "S2020-00000035",
            "CountryID": "C2020-00000101",
        },
        SupplyDetails : [
            {
                "DetailID": "",
                "PCID": "PC2023-0000001",
                "PSCID": "PSC2023-0000001",
            },
            {
                "DetailID": "",
                "PCID": "PC2024-0000003",
                "PSCID": "PSC2024-0000002",
            },
        ],
        StockPoints :  [
            {
                "DetailID": "",
                "UUID": "I052813f0-96cf99-69",
                "PointName": "Peelamedu Point",
                "Address": "34, Ganesh Layout",
                "PostalID": "PC2023-0015260",
                "CityID": "CI2023-0115272",
                "TalukID": "T2023-00007979",
                "DistrictID": "DT2023-00000497",
                "StateID": "S2020-00000035",
                "CountryID": "C2020-00000101",
            },
            {
                "DetailID": "",
                "VendorID": "V2024-00000020",
                "UUID": "Id8d18e1a-2bdf45-f8",
                "PointName": "Gandhima Nagar Point",
                "Address": "6, Aandal St,",
                "PostalID": "PC2023-0015260",
                "CityID": "CI2023-0115343",
                "TalukID": "T2023-00007979",
                "DistrictID": "DT2023-00000497",
                "StateID": "S2020-00000035",
                "CountryID": "C2020-00000101",
            }
        ],
        Documents :  [
            "AadharFront": {
                "uploadPath": "uploads/tmp/20240205/f1c726aa67f1336c69e90d96e30f7b5c-tmp.jpg",
                "fileName": "f1c726aa67f1336c69e90d96e30f7b5c.jpg",
                "ext": "jpg",
                "referData": null
            },
            "AadharBack": {
                "uploadPath": "uploads/tmp/20240205/f1c726aa67f1336c69e90d96e30f7b5c-tmp.jpg",
                "fileName": "f1c726aa67f1336c69e90d96e30f7b5c.jpg",
                "ext": "jpg",
                "referData": null
            },
        ],
    }

</script>
@endsection