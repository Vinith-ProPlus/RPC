@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Transaction</li>
					<li class="breadcrumb-item"><a href="{{ url('/') }}/transaction/quote-enquiry/" data-original-title="" title="">{{$PageTitle}}</a></li>
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
                                                <label>Quote No</label>
                                                <input type="text" disabled class="form-control" id="txtQNo" value="<?php if($isEdit==true){ echo $EditData[0]['QNo'];}else{ echo $QNo;} ?>">
                                                <div class="errors err-sm" id="txtQNo-err"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Enquiry Date</label>
                                                <input type="date" class="form-control" id="dtpEnqDate" min="<?php if($isEdit==true){ echo date("Y-m-d",strtotime($EditData[0]['QExpiryDate']));}else{ echo date("Y-m-d",strtotime('-5 days'));} ?>" value="<?php if($isEdit==true){ echo date("Y-m-d",strtotime($EditData[0]['ExpectedDeliveryDate']));}else{ echo date("Y-m-d");} ?>">
                                                <div class="errors err-sm" id="dtpEnqDate-err"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Expected Delivery Date</label>
                                                <input type="date" class="form-control" id="dtpExpDate" min="<?php if($isEdit==true){ echo date("Y-m-d",strtotime($EditData[0]['QDate']));}else{ echo date("Y-m-d",strtotime('-5 days'));} ?>" value="<?php if($isEdit==true){ echo date("Y-m-d",strtotime($EditData[0]['QExpiryDate']));}else{ echo date('Y-m-d',strtotime($Settings['Quote-Valid'].' days'));} ?>" >
                                                <div class="errors err-sm" id="dtpExpDate-err"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mt-20">
                                            <div class="form-group">
                                                <label>Customer Name</label>
                                                <select id="lstCustomer" class="form-control select2" data-selected="<?php if($isEdit==true){ echo $EditData[0]['CustomerID'];} ?>">
                                                    <option value="">Select a Customer</option>
                                                    @foreach ($Customers as $row)
                                                        <option value="{{$row->CustomerID}}">{{$row->CustomerName}} ({{$row->MobileNo1}})</option>
                                                    @endforeach
                                                </select>
                                                <div class="errors err-sm" id="lstCustomer-err"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mt-20">
                                            <div class="form-group">
                                                <label>Mobile No</label>
                                                <input type="number" class="form-control" id="txtMobileNo" value="<?php if($isEdit==true){ echo $EditData[0]['ReceiverMobNo'];} ?>">
                                                <div class="errors err-sm" id="txtMobileNo-err"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mt-20">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" class="form-control" id="txtEmail" value="<?php if($isEdit==true){ echo $EditData[0]['Email'];} ?>" disabled>
                                                <div class="errors err-sm" id="txtEmail-err"></div>
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
                                                            <div id="divBillingAddress" class="fs-15 fw-500 p-6"><?php if($isEdit){ echo $tmp;} ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-20">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="card shadow-sm">
                                                        <div class="card-header p-7">
                                                            <div class="row">
                                                                <div class="col-2">

                                                                </div>
                                                                <div class="col-8 text-center fs-17 fw-600 align-middle">
                                                                    Shipping Address
                                                                </div>
                                                                <div class="col-2">
                                                                    <button id="btnSAChange" title="Change the shipping address" class="btn btn-sm btn-link full-right mr-10">
                                                                        <i class="fa fa-pencil"></i>
                                                                    </button>
                                                                </div>
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
                                                            <div id="divShippingAddress" data-aid="" class="fs-15 fw-500 p-6"><?php if($isEdit){ echo $tmp;} ?></div>
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
                            <div class="row mt-20 mb-20">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label class="lstCategory">Category <span class="required"> * </span></label>
                                        <select class="form-control select2" id="lstCategory">
                                            <option value ="">Select a Category </option>
                                        </select>
                                        <div class="errors details err-sm" id="lstCategory-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label class="lstSubCategory">Sub Category <span class="required"> * </span></label>
                                        <select class="form-control select2" id="lstSubCategory">
                                            <option value ="">Select a Sub Category </option>
                                        </select>
                                        <div class="errors details err-sm" id="lstSubCategory-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label class="lstProduct">Product <span class="required"> * </span></label>
                                        <select class="form-control select2" id="lstProduct">
                                            <option value ="">Select a Product </option>
                                        </select>
                                        <div class="errors details err-sm" id="lstProduct-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="txtDescription">Description</label>
                                        <textarea class="form-control" rows=1 id="txtDescription"></textarea>
                                        <div class="errors details err-sm" id="txtDescription-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label class="txtQty">Qty <span class="required"> * </span></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control"  step="{{NumberSteps($Settings['qty-decimals'])}}" id="txtQty">
                                            <input type="text" class="form-control" id="txtUOM" disabled>
                                        </div>
                                        <div class="errors details err-sm" id="txtQty-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-1 pt-20 text-center">
                                    <button class="btn btn-sm btn-outline-danger m-5 d-none" id="btnCancelProduct">Cancel</button>
                                    <button class="btn btn-sm btn-outline-info m-5" data-edit-id="" id="btnAddProduct">Add</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 pb-20 table-responsive">
                                    <table class="table table-sm" id="tblProduct">
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
        const formatAddress = async (address) => {
            var parts = address.split(',');

            parts = parts.map(part => part.trim());

            var lastPartIndex = parts.length - 1;
            var thirdFromLastPartIndex = parts.length - 3;
            parts.splice(lastPartIndex, 0, '<br>');
            parts.splice(thirdFromLastPartIndex, 0, '<br>');

            parts = parts.map(function(part, index) {
                if (index > 0 && parts[index - 1] === '<br>') {
                    return part.replace(',', '');
                }
                return part;
            });

            var formattedAddress = parts.join(', ');
            console.log(formattedAddress);
            return formattedAddress;
        }
        const getCustomer=async()=>{
            $('#lstCustomer').select2('destroy');
            $('#lstCustomer option').remove();
            $('#lstCustomer').append('<option value="" >Select a Customer</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/transaction/quote-enquiry/get/customers",
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
            $('.errors').html('');
            let AID=$('#divShippingAddress').attr('data-aid');
            $('#lstCategory').select2('destroy');
            $('#lstCategory option').remove();
            $('#lstCategory').append('<option value="" selected>Select a Category</option>');
            if(AID){
                console.log(AID);
                $.ajax({
                    type:"post",
                    url:"{{url('/')}}/admin/transaction/quote-enquiry/get/category",
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content')},
                    data:{AID},
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
            }
            $('#lstCategory').select2();
            $('#lstCategory').trigger('change');
        };
        const getSubCategory=async()=>{ 
            $('.errors').html('');
            let AID = $('#divShippingAddress').attr('data-aid');
            let PCID=$('#lstCategory').val();

            $('#lstSubCategory').select2('destroy');
            $('#lstSubCategory option').remove();
            $('#lstSubCategory').append('<option value="" selected>Select a sub category</option>');
            if(PCID){
                $.ajax({
                    type:"post",
                    url:"{{url('/')}}/admin/transaction/quote-enquiry/get/sub-category",
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    data:{AID,PCID},
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
            }
            $('#lstSubCategory').select2();
            $('#lstSubCategory').trigger('change');
        };
        const getProduct=async()=>{
            $('.errors').html('');
            let AID = $('#divShippingAddress').attr('data-aid');
            let PCID = $('#lstCategory').val();
            let PSCID = $('#lstSubCategory').val();

            $('#lstProduct').select2('destroy');
            $('#lstProduct option').remove();
            $('#lstProduct').append('<option value="" selected>Select a Product</option>');
            if(PSCID){
                $.ajax({
                    type:"post",
                    url:"{{url('/')}}/admin/transaction/quote-enquiry/get/products",
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content')},
                    data:{AID,PCID,PSCID},
                    dataType:"json",
                    error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                    complete: function(e, x, settings, exception){},
                    success:function(response){
                        for(let Item of response){
                            let selected="";
                            if(Item.ProductID==$('#lstProduct').attr('data-selected')){selected="selected";}
                            $('#lstProduct').append('<option '+selected+' data-uom="'+Item.UName+'('+Item.UCode+')" value="'+Item.ProductID+'">'+Item.ProductName+' </option>');
                        }
                        if($('#lstProduct').val()!=""){
                            $('#lstProduct').trigger('change');
                        }
                    }
                });
            }
            $('#lstProduct').select2();
        };
        const LoadCustomerData=async(CustomerID)=>{
            $('#txtMobileNo').val("");
            $('#txtEmail').val("");
            $('#divBillingAddress').html("");
            $('#divShippingAddress').html("");
            $('#divShippingAddress').attr("data-aid","");
            if(CustomerID){
                $.ajax({
                    type:"post",
                    url:"{{url('/')}}/admin/users-and-permissions/manage-customers/get/customer-data",
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    data:{'CustomerID':CustomerID},
                    dataType:"json",
                    error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                    complete: function(e, x, settings, exception){},
                    success:function(response){
                        $('#txtMobileNo').val(response.MobileNo1);
                        $('#txtEmail').val(response.Email);
                        if (response.CompleteAddress !== null && response.CompleteAddress !== undefined) {
                            $('#divBillingAddress').html(response.CompleteAddress);
                        }
                        if (response.DefaultSAddress.CompleteAddress !== null && response.DefaultSAddress.CompleteAddress !== undefined) {
                            $('#divShippingAddress').html(response.DefaultSAddress.CompleteAddress);
                        }
                        $('#divShippingAddress').attr('data-aid', response.DefaultSAddress.AID);
                    }
                });
            }
            return true;
        }
        $(document).on('click','#btnSAChange',function(){
            let CustomerID = $('#lstCustomer').val();
            if(CustomerID){
                $.ajax({
                    type:"post",
                    url:"{{url('/')}}/admin/users-and-permissions/manage-customers/get/customer-data",
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    data:{'CustomerID':CustomerID},
                    dataType:"json",
                    error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                    complete: function(e, x, settings, exception){},
                    success:function(response){
                        var modalContent = $('<div>');
                        var table = $('<table>').addClass('table');
                        var tbody = $('<tbody>');
    
                        $.each(response.SAddress, function(index, item) {
                            var tr = $('<tr>');
                            var td1 = $('<td>').addClass('pointer').html('<b>' + item.Address + '</b>,<br>' +
                                item.CityName + ', ' + item.TalukName + ',<br>' +
                                item.DistrictName + ', ' + item.StateName + ',<br>' +
                                item.CountryName + ' - ' + item.PostalCode + '.');
                            var td2 = $('<td>').addClass('text-center').html('<button type="button" class="btn btn-sm btn-outline-danger m-5 btnSelectSAddress" data-id="' + item.AID + '">Select</button>');
    
                            tr.append(td1).append(td2);
                            tbody.append(tr);
                        });
    
                        table.append(tbody);
                        modalContent.append(table);
    
                        bootbox.dialog({
                            title: 'Select Shipping Address',
                            message: modalContent,
                            size: 'medium'
                        });
                    }
                });
            }
        });
        $(document).on('click','.btnSelectSAddress',function(){
            let CustomerID = $('#lstCustomer').val();
            if(CustomerID){
                $.ajax({
                    type:"post",
                    url:"{{url('/')}}/admin/users-and-permissions/manage-customers/set-default-address",
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    data:{'CustomerID':CustomerID,AID : $(this).attr('data-id')},
                    dataType:"json",
                    error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                    complete: function(e, x, settings, exception){},
                    success:function(response){
                        if(response.status){
                            $('#lstCustomer').trigger('change');
                            bootbox.hideAll();
                        }
                    }
                });
            }
        });
        $('#lstCustomer').change(async function () {
            let status = await LoadCustomerData($(this).val());
            if(status){
                setTimeout(() => {
                    getCategory();
                }, 2000);
            }
        });
        $(document).on('change','#lstCategory',function(){
            /* $('#lstCategory-err').html('');
            if($('#lstCategory').val()==""){
                $('#lstCategory-err').html('Category is required');
            } */
            getSubCategory();
        });
        $(document).on('change','#lstSubCategory',function(){
            /* $('#lstSubCategory-err').html('');
            if($('#lstSubCategory').val()==""){
                $('#lstSubCategory-err').html('Sub Category is required');
            } */
            getProduct();
        });
        $(document).on('change','#lstProduct',function(){
            $('#lstProduct-err').html('');
            let EditID = $('#btnAddProduct').attr('data-edit-id');
            $('#tblProduct tbody tr').each(function(){
                let currentProductId = $(this).data('product-id');
                if(!EditID && currentProductId == FormData.ProductID) {
                    $('#lstProduct-err').html('Product already exists');status = false;
                    return false;
                } else if(EditID && EditID !== $(this).find('td:first').html() && currentProductId == FormData.ProductID) {
                    $('#lstProduct-err').html('Product already exists');status = false;
                    return false;
                }
            });
            $('#txtUOM').val($(this).find('option:selected').attr('data-uom'));
        });
        const ProductValidation = async () => {
            $('.errors').html('');
            let status = true;
            let FormData = {
                PCID : $("#lstCategory").val(),
                PSCID : $("#lstSubCategory").val(),
                ProductID : $("#lstProduct").val(),
                Description : $("#txtDescription").val(),
                Qty : $("#txtQty").val(),
                PCName : $("#lstCategory option:selected").html(),
                PSCName : $("#lstSubCategory option:selected").html(),
                ProductName : $("#lstProduct option:selected").html(),
                UOM : $("#txtUOM").val(),
            }
            if(!FormData.PCID){
                $('#lstCategory-err').html('Category is required');status = false;
            }
            if(!FormData.PSCID){
                $('#lstSubCategory-err').html('Sub Category is required');status = false;
            }
            if(!FormData.Qty){
                $('#txtQty-err').html('Qty is required');status = false;
            }else if(FormData.Qty < 1){
                $('#txtQty-err').html('Qty must be greater than 0');status = false;
            }
            if(!FormData.ProductID){
                $('#lstProduct-err').html('Product is required');status = false;
            }
            if(status){
                let EditID = $('#btnAddProduct').attr('data-edit-id');
                $('#tblProduct tbody tr').each(function(){
                    let currentProductId = $(this).data('product-id');
                    if(!EditID && currentProductId == FormData.ProductID) {
                        $('#lstProduct-err').html('Product already exists');status = false;
                        return false;
                    } else if(EditID && EditID !== $(this).find('td:first').html() && currentProductId == FormData.ProductID) {
                        $('#lstProduct-err').html('Product already exists');status = false;
                        return false;
                    }
                });
            }
            return { status, FormData };
        };
        const AddProduct = async (EditID) => {
            let { status, FormData } = await ProductValidation();
            if (status) {
                let index = ($("#tblProduct tbody tr").length) + 1;
                let html = `<tr data-product-id = ${FormData.ProductID}>`;
                html += `<td>${EditID ? EditID : index}</td>`;
                html += `<td>${FormData.PCName} </td>`;
                html += `<td>${FormData.PSCName} </td>`;
                html += `<td>${FormData.ProductName} (${FormData.UOM})</td>`;
                html += `<td>${FormData.Qty} </td>`;
                html += `<td class="text-center align-middle"><button type="button" class="btn btn-outline-success btnEditProduct"><i class="fa fa-pencil"></i></button> <button type="button" class="btn btn-outline-danger btnDeleteProduct"><i class="fa fa-trash"></i></button></td>`;
                html += `<td class="d-none tdata">${JSON.stringify(FormData)}</td>`;
                html += "</tr>";
                if(EditID){
                    $("#tblProduct tbody tr").each(function () {
                        let MatchID = $(this).find("td:first").html();
                        if (MatchID === EditID) {
                            $(this).replaceWith(html);
                            $('.btnEditProduct, .btnDeleteProduct').removeClass('d-none');
                            return false;
                        }
                    });
                    $("#btnAddProduct").attr('data-edit-id', "").html("Add");
                    $("#btnCancelProduct").addClass('d-none');
                }else{
                    $('#tblProduct tbody').append(html);
                }
                clearProductDetails();
            }
        };
        const clearProductDetails=async()=>{
            $('#lstProduct').attr("data-selected","");
            $("#txtQty, #txtDescription, #txtUOM").val("");
            $('#lstProduct').val("").trigger('change');
            getProduct();
        }
        $(document).on('click', '#btnAddProduct', function () {            
            let EditID=$(this).attr('data-edit-id');
            AddProduct(EditID);
        });
        $(document).on('click', '.btnEditProduct', function () {
            let Row=$(this).closest('tr');
            $('.btnEditProduct, .btnDeleteProduct').addClass('d-none');
            let EditData=JSON.parse($(this).closest('tr').find("td:eq(6)").html());
            $('#txtQty').val(EditData.Qty);
            $('#lstCategory').attr("data-selected",EditData.PCID);
            $('#lstSubCategory').attr("data-selected",EditData.PSCID);
            $('#lstProduct').attr("data-selected",EditData.ProductID);
            $("#txtDescription").val(EditData.Description);
            getCategory();
            $("#btnAddProduct").attr('data-edit-id', Row.find("td:first").html()).html("Update");
            $("#btnCancelProduct").removeClass('d-none');
        });
        $(document).on('click', '.btnDeleteProduct', function () {
            $(this).closest("tr").remove();
            $("#tblProduct tbody tr").each(function (index) {
                $(this).find("td:eq(0)").text(index + 1);
            });
        });
        $(document).on('click', '#btnCancelProduct', function () {
            $('.errors').html("");
            $('.btnEditProduct, .btnDeleteProduct').removeClass('d-none');
            $("#btnAddProduct").attr('data-edit-id', "").html("Add");
            $("#btnCancelProduct").addClass('d-none');  
            clearProductDetails();
        });
        const formValidation=async()=>{
            $('.errors').html('');
            let status=true;
                let data={}
                data.EnqDate=$('#dtpEnqDate').val();
                data.ExpDate=$('#dtpExpDate').val();
                data.Customer=$('#lstCustomer').val();
                data.MobileNo=$('#txtMobileNo').val();
                data.Email=$('#txtEmail').val();

                if(!data.Customer){
                    $('#lstCustomer-err').html('Customer is required.');status=false;
                }
                if(!data.EnqDate){
                    $('#dtpEnqDate-err').html('Enquiry Date is required.');status=false;
                }
                if(!data.ExpDate){
                    $('#dtpExpDate-err').html('Expected Date is required.');status=false;
                }
                if(!data.Email){
                    $('#txtEmail-err').html('Email is required.');status=false;
                }
                if(!data.MobileNo){
                    $('#txtMobileNo-err').html('Mobile Number is required.');status=false;
                }
               
            if (!$('#tblProduct tbody tr').length && status) {
                toastr.error("Please add a Product", "Failed", {positionClass: "toast-top-right",containerId: "toast-top-right",showMethod: "slideDown",hideMethod: "slideUp",progressBar: !0});
                status = false;
            }
            return status;
        }
        const getData=async()=>{
            let ProductData=[];
            $('#tblProduct tbody tr td.tdata').each(function(index){
                try {
                    let t=JSON.parse($(this).html());
                    ProductData.push(t);
                } catch (error) {
                    console.log(error);
                }
            });
            
            let formData=new FormData();

            formData.append('CustomerID',$('#lstCustomer').val());
            formData.append('ExpectedDeliveryDate',$('#dtpExpDate').val());
            formData.append('dtpEnqDate',$('#dtpEnqDate').val());
            formData.append('ReceiverMobNo',$('#txtMobileNo').val());
            formData.append('AID',$('#divShippingAddress').data('aid'));
            formData.append('ProductData',JSON.stringify(ProductData));
            return formData;
        }
        $(document).on('click','#btnSave',async function(){ 
            let status=await formValidation();
            if(status){
                getData();
                swal({
                    title: "Are you sure?",
                    text: "You want @if($isEdit==true)Update @else Save @endif this Quote Enquiry!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, @if($isEdit==true)Update @else Save @endif it!",
                    closeOnConfirm: false
                },async function(){
                    swal.close();
                    let formData=await getData();

                    btnLoading($('#btnSave'));
                    let postUrl="{{url('/')}}/admin/transaction/quote-enquiry/save";
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
                                    @if($isEdit==true)
                                        window.location.replace("{{url('/')}}/admin/transaction/quote-enquiry");
                                    @else
                                        window.location.reload();
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
                            }
                        }
                    });
                });
            }
        });

    });

</script>
@endsection