<?php
function dateFormat($date,$format){
    return date($format,strtotime($date));
}
function NumberFormat($Value,$Decimal){
    if($Decimal!="auto"){
        return number_format($Value,$Decimal,".","");
    }else{
        return $Value;
    }
}
function NumberSteps($Decimal){
    $Value="1";
    if($Decimal!="auto"){
        if($Decimal==0){
            return 1;
        }else{
            return "0.".str_pad($Value,$Decimal,"0",STR_PAD_LEFT);
        }
    }else{
        return $Value;
    }
}
?>