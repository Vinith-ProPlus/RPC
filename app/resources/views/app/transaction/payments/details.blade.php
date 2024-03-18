@php 
    $TotalAmount=0; 
    $LessFromAdvance=0; 
    $PaidAmount=0; 
    $Details=array();
    if(count($Data)>0){
        if(array_key_exists("Details",$Data[0])){
            $Details=$Data[0]['Details'];
        }
    }
@endphp
<div class="row">
    <div class="col-sm-12">
        <table class="table">
            <thead>
                <tr>
                    <th class="text-center">Invoice No</th>
                    <th class="text-center">Less From Advance</th>
                    <th class="text-center">Amount Paid</th>
                    <th class="text-center">Sub Amount</th>
                </tr>
            </thead>
            <tbody>
                @for($i=0;$i<count($Details);$i++)
                    <tr>
                        <td>{{$Details[$i]['InvoiceNo']}}</td>
                        <td class="text-right">{{NumberFormat($Details[$i]['LessFromAdvance'],$Settings['price-decimals'])}}</td>
                        <td class="text-right">{{NumberFormat($Details[$i]['PaidAmount'],$Settings['price-decimals'])}}</td>
                        <td class="text-right">{{NumberFormat($Details[$i]['Amount'],$Settings['price-decimals'])}}</td>
                    </tr>
                    @php 
                        $TotalAmount+=floatval($Details[$i]['Amount']); 
                        $LessFromAdvance+=floatval($Details[$i]['LessFromAdvance']);
                        $PaidAmount+=floatval($Details[$i]['PaidAmount']);
                    @endphp
                @endfor
            </tbody>
            <tfoot>
                <tr>
                    <th  class="text-right">Total Amount ==></th>
                    <th class="text-right fw-700 fs-16">{{NumberFormat($LessFromAdvance,$Settings['price-decimals'])}}</th>
                    <th class="text-right fw-700 fs-16">{{NumberFormat($PaidAmount,$Settings['price-decimals'])}}</th>
                    <th class="text-right fw-700 fs-16">{{NumberFormat($TotalAmount,$Settings['price-decimals'])}}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>