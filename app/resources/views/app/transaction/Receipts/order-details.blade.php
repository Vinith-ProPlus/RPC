<div class="row">
    <div class="col-12 col-sm-12 col-lg-12">
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
                    <div class="col-4">Additional Amount </div>
                    <div class="col-1">:</div>
                    <div class="col-3 text-right" id="divAdditionalAmount">{{NumberFormat($OData->AdditionalCost,$Settings['price-decimals'])}}</div>
                </div>
                <div class="row mt-10 fw-800 fs-17 mr-10 justify-content-end text-success">
                    <div class="col-4">Net Amount</div>
                    <div class="col-1">:</div>
                    <div class="col-3 text-right" id="divOverAllAmount">{{NumberFormat($OData->NetAmount,$Settings['price-decimals'])}}</div>
                </div>
            </div>
        </div>
    </div>
</div>