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
                                                <select id="lstCustomer" class="form-control select2" data-selected="<?php if($isEdit==true){ echo $EditData[0]['CustomerID'];} ?>">
                                                    <option value="">Select a Customer</option>
                                                </select>
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
                                                            <div class="text-center fs-17 fw-600">Billing Address
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
                                        <label class="lstCategory">Category <span class="required"> * </span></label>
                                        <select class="form-control select2" id="lstCategory">
                                            <option value ="">Select a Category </option>
                                        </select>
                                        <div class="errors details text-sm" id="lstCategory-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label class="lstSubCategory">Sub Category <span class="required"> * </span></label>
                                        <select class="form-control select2" id="lstSubCategory">
                                            <option value ="">Select a Sub Category </option>
                                        </select>
                                        <div class="errors details text-sm" id="lstSubCategory-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label class="lstProduct">Product <span class="required"> * </span></label>
                                        <select class="form-control select2" id="lstProduct">
                                            <option value ="">Select a Product </option>
                                        </select>
                                        <div class="errors details text-sm" id="lstProduct-err"></div>
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
                                            <input type="number" class="form-control"  step="{{NumberSteps($Settings['qty-decimals'])}}" id="txtIQty">
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
                                                <input type="number" class="form-control" step="{{NumberSteps($Settings['price-decimals'])}}" id="txtShippingCharge" value="<?php if($isEdit){ echo $EditData[0]['ShippingCharges'];} ?>">
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
                                                    <input type="number" class="form-control" step="{{NumberSteps($Settings['percentage-decimals'])}}" id="txtDiscount" value="<?php if($isEdit){ if($EditData[0]['DiscountType']=="Fixed"){echo $EditData[0]['DiscountAmount'];}else{echo $EditData[0]['DiscountPer'];}} ?>">
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
                                        <div class="col-sm-4 text-right" id="divSubTotal"> {{NumberFormat(0,$Settings['price-decimals'])}}</div>
                                    </div>
                                    <div class="row justify-content-end mt-20 fw-600 fs-16 mr-10">
                                        <div class="col-sm-4">CGST <span class="cright">:</span></div>
                                        <div class="col-sm-4 text-right"  id="divCGSTAmount"> {{NumberFormat(0,$Settings['price-decimals'])}}</div>
                                    </div>
                                    <div class="row justify-content-end mt-20 fw-600 fs-16 mr-10">
                                        <div class="col-sm-4">SGST <span class="cright">:</span></div>
                                        <div class="col-sm-4 text-right"  id="divSGSTAmount"> {{NumberFormat(0,$Settings['price-decimals'])}}</div>
                                    </div>
                                    <div class="row justify-content-end mt-20 fw-600 fs-16 mr-10">
                                        <div class="col-sm-4">IGST <span class="cright">:</span></div>
                                        <div class="col-sm-4 text-right"  id="divIGSTAmount"> {{NumberFormat(0,$Settings['price-decimals'])}}</div>
                                    </div>
                                    <div class="row justify-content-end mt-20 fw-600 fs-16 mr-10 divAddShippingCharges" style="display:none">
                                        <div class="col-sm-4">Shipping & Package <span class="cright">:</span></div>
                                        <div class="col-sm-4 text-right"  id="divShippingChargesAmount"> {{NumberFormat(0,$Settings['price-decimals'])}}</div>
                                    </div>
                                    <div class="row justify-content-end mt-20 fw-600 fs-16 mr-10 divAddDiscount"  style="display:none">
                                        <div class="col-sm-4 ">Discount <span id="divDiscountPercentage" data-percentage="0"></span> <span class="cright">:</span></div>
                                        <div class="col-sm-4 text-right"  id="divDiscountAmount"> {{NumberFormat(0,$Settings['price-decimals'])}}</div>
                                    </div>
                                    <div class="row justify-content-end mt-20  fw-700 fs-18 mr-10 text-success">
                                        <div class="col-sm-4">Total Amount <span class="cright">:</span></div>
                                        <div class="col-sm-4 text-right"  id="divTotalAmount"> {{NumberFormat(0,$Settings['price-decimals'])}} </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="card-footer row mt-20">
                    <div class="col-sm-12 text-right">
                        @if($crud['view']==true)
                        <a href="{{url('/')}}/transaction/quote-enquiry" class="btn {{$Theme['button-size']}} btn-outline-dark mr-10" id="btnCancel">Back</a>
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
        const getCustomer=async()=>{
            $('#lstCustomer').select2('destroy');
            $('#lstCustomer option').remove();
            $('#lstCustomer').append('<option value="" >Select a Customer</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/transaction/quotation/get/customers",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajax_errors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.CustomerID==$('#lstCustomer').attr('data-selected')){selected="selected";}  
                        $('#lstCustomer').append('<option '+selected+' data-mobile="'+Item.MobileNo1+'"  value="'+Item.CustomerID+'">'+Item.CustomerName +'( '+Item.MobileNo1+' )'+' </option>');
                    }
                    if($('#lstCustomer').val() !=""){
                        $('#lstCustomer').trigger('change')
                    }
                }
            });
            $('#lstCustomer').select2();
        }
        const getCategory=async()=>{
            $('#lstCategory').select2('destroy');
            $('#lstCategory option').remove();
            $('#lstCategory').append('<option value="" selected>Select a Category</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/master/product/products/get/category",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.PCID==$('#lstCategory').attr('data-selected')){selected="selected";}
                        $('#lstCategory').append('<option '+selected+' value="'+Item.PCID+'">'+Item.PCName+' </option>');
                    }
                    if($('#lstCategory').val()!=""){
                        $('#lstCategory').trigger('change');
                    }
                }
            });
            $('#lstCategory').select2();
        };
        const getSubCategory=async()=>{
            let CID=$('#lstCategory').val();
            $('#lstSubCategory').select2('destroy');
            $('#lstSubCategory option').remove();
            $('#lstSubCategory').append('<option value="" selected>Select a sub category</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/master/product/products/get/sub-category",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:{CID},
                dataType:"json",
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.PSCID==$('#lstSubCategory').attr('data-selected')){selected="selected";}
                        $('#lstSubCategory').append('<option '+selected+' value="'+Item.PSCID+'">'+Item.PSCName+' </option>');
                    }
                    if($('#lstSubCategory').val()!=""){
                        $('#lstSubCategory').trigger('change');
                    }
                }
            });
            $('#lstSubCategory').select2();
        };
        const getProduct=async()=>{
            let CID=$('#lstCategory').val();
            let SCID=$('#lstSubCategory').val();

            $('#lstProduct').select2('destroy');
            $('#lstProduct option').remove();
            $('#lstProduct').append('<option value="" selected>Select a sub category</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/master/product/products/get/products",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content')},
                data:{CID,SCID},
                dataType:"json",
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.PSCID==$('#lstProduct').attr('data-selected')){selected="selected";}
                        $('#lstProduct').append('<option '+selected+' value="'+Item.PSCID+'">'+Item.PSCName+' </option>');
                    }
                    if($('#lstProduct').val()!=""){
                        $('#lstProduct').trigger('change');
                    }
                }
            });
            $('#lstProduct').select2();
        };
        const LoadCustomerData=async(CustomerID)=>{
            console.log(CustomerID);
        }

        $('#lstCustomer').change(function () {
            LoadCustomerData($(this).val());
        });
        $(document).on('change','#lstCategory',function(){
            $('#lstCategory-err').html('');
            if($('#lstCategory').val()==""){
                $('#lstCategory-err').html('Category is required');
            }
            getSubCategory();
        });
        $(document).on('change','#lstSubCategory',function(){
            $('#lstSubCategory-err').html('');
            if($('#lstSubCategory').val()==""){
                $('#lstSubCategory-err').html('Sub Category is required');
            }
            getProduct();
        });
        $(document).on('change','#lstProduct',function(){
            $('#lstProduct-err').html('');
            if($('#lstProduct').val()==""){
                $('#lstProduct-err').html('Product is required');
            }
            Load();
        });

        getCustomer();
        getCategory();
    });

</script>
@endsection