<div class="row">
    <div class="col-sm-12 table-responsive">
        <table class="table table-sm">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center" >GR No</th>
                    <th class="text-center" >PO No</th>
                    <th class="text-center" >Product</th>
                    <th class="text-center" >GR Qty / Order qty</th>
                    <th class="text-center" >Price</th>
                    <th class="text-center " >Tax Type</th>
                    <th class="text-center" >Taxable</th>
                    <th class="text-center" >CGST Amount</th>
                    <th class="text-center" >SGST  Amount</th>
                    <th class="text-center" >IGST  Amount</th>
                    <th class="text-center" >Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $GRNo="";
                    $PONo="";
                    $Taxable=0;
                    $CGSTAmount=0;
                    $SGSTAmount=0;
                    $IGSTAmount=0;
                    $Amount=0;
                    $TotTaxable=0;
                    $TotCGSTAmount=0;
                    $TotSGSTAmount=0;
                    $TotIGSTAmount=0;
                    $TotAmount=0;
                @endphp
                @for($i=0;$i<count($data);$i++)
                    <tr>
                        <td>
                            @php
                             if($GRNo!=$data[$i]->GRNo){
                                $GRNo=$data[$i]->GRNo;$PONo="";
                                echo $data[$i]->GRNo;
                             }
                            @endphp

                        </td>
                        <td>
                            @php
                             if($PONo!=$data[$i]->PONo){
                                $PONo=$data[$i]->PONo;
                                echo $data[$i]->PONo;
                             }
                            @endphp
                        </td>
                        <td>{{$data[$i]->PName}}</td>
                        <td class="text-right">{{$data[$i]->GRQty}} / {{$data[$i]->POQty}} {{$data[$i]->UCode}}</td>
                        <td class="text-right">{{NumberFormat($data[$i]->Price,$Settings['PRICE-DECIMALS'])}}</td>
                        <td class="text-center">
                            @if($data[$i]->TaxType==1)
                                Exclude
                            @else 
                             Include
                            @endif
                        </td>
                        <td class="text-right">{{NumberFormat($data[$i]->Taxable,$Settings['PRICE-DECIMALS'])}}</td>
                        <td class="text-right">{{NumberFormat($data[$i]->CGSTAmount,$Settings['PRICE-DECIMALS'])}}</td>
                        <td class="text-right">{{NumberFormat($data[$i]->SGSTAmount,$Settings['PRICE-DECIMALS'])}}</td>
                        <td class="text-right">{{NumberFormat($data[$i]->IGSTAmount,$Settings['PRICE-DECIMALS'])}}</td>
                        <td class="text-right">{{NumberFormat($data[$i]->Amount,$Settings['PRICE-DECIMALS'])}}</td>
                    </tr>
                    <?php
                        $Taxable+=$data[$i]->Taxable;
                        $CGSTAmount+=$data[$i]->CGSTAmount;
                        $SGSTAmount+=$data[$i]->SGSTAmount;
                        $IGSTAmount+=$data[$i]->IGSTAmount;
                        $Amount+=$data[$i]->Amount;
                        $isShow=false;
                        if(count($data)==($i+1)){
                            $isShow=true;
                        }else if(count($data)>($i+1)){
                            if($GRNo!=$data[$i+1]->GRNo){
                                $isShow=true;
                            }
                        }
                        
                        if($isShow==true){
                            ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="text-right fw-600 text-dark">Sub Total</td>
                                <td class="text-right fw-600 text-dark"></td>
                                <td class="text-right fw-600 text-dark"></td>
                                <td class="text-right fw-600 text-dark"></td>
                                <td class="text-right fw-600 text-dark">{{NumberFormat($Taxable,$Settings['PRICE-DECIMALS'])}}</td>
                                <td class="text-right fw-600 text-dark">{{NumberFormat($CGSTAmount,$Settings['PRICE-DECIMALS'])}}</td>
                                <td class="text-right fw-600 text-dark">{{NumberFormat($SGSTAmount,$Settings['PRICE-DECIMALS'])}}</td>
                                <td class="text-right fw-600 text-dark">{{NumberFormat($IGSTAmount,$Settings['PRICE-DECIMALS'])}}</td>
                                <td class="text-right fw-600 text-dark">{{NumberFormat($Amount,$Settings['PRICE-DECIMALS'])}}</td>
                            </tr>
                            <?php
                            $TotTaxable+=$Taxable;
                            $TotCGSTAmount+=$CGSTAmount;
                            $TotSGSTAmount+=$SGSTAmount;
                            $TotIGSTAmount+=$IGSTAmount;
                            $TotAmount+=$Amount;
                            
                            $Taxable=0;
                            $CGSTAmount=0;
                            $SGSTAmount=0;
                            $IGSTAmount=0;
                            $Amount=0;
                        }
                    ?>
                @endfor
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-right text-primary fw-700" colspan=3>Grand Total</th>
                    <th class="text-right text-primary fw-700" ></th>
                    <th class="text-right text-primary fw-700" ></th>
                    <th class="text-right text-primary fw-700" ></th>
                    <th class="text-right text-primary fw-700" >{{NumberFormat($TotTaxable,$Settings['PRICE-DECIMALS'])}}</th>
                    <th class="text-right text-primary fw-700" >{{NumberFormat($TotCGSTAmount,$Settings['PRICE-DECIMALS'])}}</th>
                    <th class="text-right text-primary fw-700" >{{NumberFormat($TotSGSTAmount,$Settings['PRICE-DECIMALS'])}}</th>
                    <th class="text-right text-primary fw-700" >{{NumberFormat($TotIGSTAmount,$Settings['PRICE-DECIMALS'])}}</th>
                    <th class="text-right text-primary fw-700" >{{NumberFormat($TotAmount,$Settings['PRICE-DECIMALS'])}}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>