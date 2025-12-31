<div class="row ml-10 mr-10">
    @for($i=0;$i<count($Address);$i++)
        <div class="col-sm-6 p-20">
            <div class="row p-10 br-5" style="border:1px solid #ccc">
                <div class="col-sm-12 mh-140">
                    <?php

                    $tmp=$Address[$i]->Address;

                    $tmp.=$Address[$i]->CityName;

                    if($tmp!=""){$tmp.=",<br> ";}
                    $tmp.=$Address[$i]->TalukName;
                    
                    if($tmp!=""){$tmp.=", ";}
                    $tmp.=$Address[$i]->DistrictName;

                    if($tmp!=""){$tmp.=", ";}
                    $tmp.=$Address[$i]->StateName;

                    if($tmp!=""){$tmp.=",<br> ";}
                    $tmp.=$Address[$i]->CountryName;

                    if($tmp!=""){$tmp.="- ";}
                    $tmp.=$Address[$i]->PostalCode;

                    if($tmp!=""){$tmp.=".";}
                    echo $tmp;
                    ?>
                </div>
                <div class="col-sm-12"><button data-slno="{{$Address[$i]->AID}}" class="btn btn-sm mt-10 btn-outline-success btnChangeAddress">Use this address</button></div>
            </div>
        </div>
    @endfor
</div>