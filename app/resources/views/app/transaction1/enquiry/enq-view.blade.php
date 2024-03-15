@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Transaction</li>
					<li class="breadcrumb-item"><a href="{{ url('/') }}/admin/transaction/enquiry/" data-original-title="" title="">{{$PageTitle}}</a></li>
                    <li class="breadcrumb-item">Enquiry View</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row d-flex justify-content-center">
		<div class="col-12 col-sm-12 col-lg-12">
			<div class="card">
				<div class="card-header text-center"><h5 class="mt-10">Enquiry ( {{$EnqData->EnqNo}} )</h5></div>
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
                                                'Customer Name' => $EnqData->CustomerName,
                                                'Email' => $EnqData->Email,
                                                'Contact Number' => $EnqData->MobileNo1 . ($EnqData->MobileNo2 ? ', ' . $EnqData->MobileNo2 : ''),
                                                'Enquiry Date' => date($Settings['DATE-FORMAT'], strtotime($EnqData->EnqDate)),
                                            ] as $label => $value)
                                                <div class="row my-1">
                                                    <div class="col-sm-5 fw-600">{{ $label }}</div>
                                                    <div class="col-sm-1 fw-600 text-center">:</div>
                                                    <div class="col-sm-6">{{ $value }}.</div>
                                                </div>
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
                                                // if($EnqData->CustomerName!=""){$Address.="<b>".$EnqData->CustomerName."</b>";}
                                                if($EnqData->Address!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$EnqData->Address;}
                                                if($EnqData->CityName!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$EnqData->CityName;}
                                                if($EnqData->TalukName!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$EnqData->TalukName;}
                                                if($EnqData->DistrictName!=""){if($Address!=""){$Address.=",<br> ";}$Address.=$EnqData->DistrictName;}
                                                if($EnqData->StateName!=""){if($Address!=""){$Address.=",<br>";}$Address.=$EnqData->StateName;}
                                                if($EnqData->CountryName!=""){if($Address!=""){$Address.=", ";}$Address.=$EnqData->CountryName;}
                                                if($EnqData->PostalCode!=""){if($Address!=""){$Address.=" - ";}$Address.=$EnqData->PostalCode;}
                                                if($Address!=""){$Address.=".";}
                                                echo  $Address;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-header p-6">
                                            <p class="text-center fs-16 fw-500">Delivery Address</p>
                                        </div>
                                        <div class="card-body">
                                            <?php 
                                                $DAddress="";
                                                if($EnqData->DAddress!=""){if($DAddress!=""){$DAddress.=",<br> ";}$DAddress.=$EnqData->DAddress;}
                                                if($EnqData->DCityName!=""){if($DAddress!=""){$DAddress.=",<br> ";}$DAddress.=$EnqData->DCityName;}
                                                if($EnqData->DTalukName!=""){if($DAddress!=""){$DAddress.=",<br> ";}$DAddress.=$EnqData->DTalukName;}
                                                if($EnqData->DDistrictName!=""){if($DAddress!=""){$DAddress.=",<br> ";}$DAddress.=$EnqData->DDistrictName;}
                                                if($EnqData->DStateName!=""){if($DAddress!=""){$DAddress.=",<br>";}$DAddress.=$EnqData->DStateName;}
                                                if($EnqData->DCountryName!=""){if($DAddress!=""){$DAddress.=", ";}$DAddress.=$EnqData->DCountryName;}
                                                if($EnqData->DPostalCode!=""){if($DAddress!=""){$DAddress.=" - ";}$DAddress.=$EnqData->DPostalCode;}
                                                if($DAddress!=""){$DAddress.=".";}
                                                echo  $DAddress;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="text-center fw-700">Product Details</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table" id="tblProductDetails">
                                        <thead>
                                            <tr>
                                                <th class="text-center align-middle">S.No</th>
                                                <th class="text-center align-middle">Product</th>
                                                <th class="text-center align-middle">Qty</th>
                                                <th class="text-center align-middle">Unit of Measurement</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $AllVendors=[];
                                            @endphp
                                            @foreach ($PData as $key=>$row)
                                                <tr data-product-id="{{$row->ProductID}}" data-pcid="{{$row->CID}}" data-pscid="{{$row->SCID}}">
                                                    <td>{{$key + 1}}</td>
                                                    <td>{{$row->ProductName}}</td>
                                                    <td class="text-right">{{$row->Qty}}</td>
                                                    {{-- <td class="divInput">
                                                        <input class="form-control txtQty" type="number" value="{{$row->Qty}}">
                                                        <span class="errors txtQty-err err-sm"></span>
                                                    </td> --}}
                                                    <td data-uom-id="{{$row->UID}}">{{$row->UName}} ( {{$row->UCode}} )</td>
                                                </tr>                                        
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
                
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            @if($crud['view']==true)
                            <a href="{{url('/')}}/admin/transaction/enquiry" class="btn {{$Theme['button-size']}} btn-outline-dark mr-10" id="btnCancel">Back</a>
                            @endif
                            
                            @if($crud['add']==true && $EnqData->Status == 'New')
                                <button class="btn {{$Theme['button-size']}} btn-outline-success" id="btnSave">Convert to Quotation</button>
                            @endif
                        </div>
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

        $('#btnSave').click(async function(){
            let status = true;
            if(status){
                swal({
                    title: "Are you sure?",
                    text: "You want to Convert to Quotation!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, Convert it!",
                    closeOnConfirm: false
                },function(){
                    swal.close();
                    btnLoading($('#btnSave'));
                    let postUrl="{{ url('/') }}/admin/transaction/enquiry/convert/{{$EnqData->EnqID}}";
                    $.ajax({
                        type:"post",
                        url:postUrl,
                        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
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
                            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
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
                                    window.location.replace("{{url('/')}}/admin/transaction/enquiry");
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