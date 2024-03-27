@extends('home.home-layout')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <div class="container">
    <ul class="checkout-progress-bar d-flex justify-content-center flex-wrap">
        <li class="active">
            <a href="#">Shopping Cart</a>
        </li>
        <li class="disabled">
            <a href="#">Quote Request</a>
        </li>
    </ul>

    <div class="row">
        <div class="col-lg-8">
            <div class="cart-table-container">
                <table class="table table-cart">
                    <thead>
                        <tr>
                            <th class="thumbnail-col"></th>
                            <th class="product-col">Product</th>
                            <th class="qty-col text-center">Quantity</th>
                            <th class="text-center">Unit of Measurement</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($Cart) > 0)
                            @foreach ($Cart as $item)
                                <tr class="product">
                                    <td>
                                        <figure class="product-image-container">
                                            <a href="#" class="product-image">
                                                <img src="{{$item->ProductImage}}" alt="product" height="100px" width="100px">
                                            </a>

                                            <a href="#" class="btn-remove icon-cancel btnRemoveCart" title="Remove Product" id="{{$item->ProductID}}"></a>
                                        </figure>
                                    </td>
                                    <td class="product-col align-middle">
                                        <h5 class="product-title">
                                            <a href="#">{{$item->ProductName}}</a>
                                        </h5>
                                    </td>

                                    <td class="align-middle text-center">
                                        <div class="product-single-qty">
                                            <input class="form-control txtUpdateQty" type="number" value="{{$item->Qty}}" id="{{$item->ProductID}}" style="width: 100%;">
                                            {{-- <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected"><span class="input-group-btn input-group-prepend"><button class="btn btn-outline btn-down-icon bootstrap-touchspin-down" type="button"></button></span><input class="horizontal-quantity form-control" type="text"><span class="input-group-btn input-group-append"><button class="btn btn-outline btn-up-icon bootstrap-touchspin-up" type="button"></button></span></div> --}}
                                        </div>
                                    </td>
                                    <td class="text-center align-middle"><span class="subtotal-price">{{$item->UName}} ({{$item->UName}})</span></td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>


                    {{-- <tfoot>
                        <tr>
                            <td colspan="5" class="clearfix">
                                <div class="float-left">
                                    <div class="cart-discount">
                                        <form action="#">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" placeholder="Coupon Code" required="">
                                                <div class="input-group-append">
                                                    <button class="btn btn-sm" type="submit">Apply
                                                        Coupon</button>
                                                </div>
                                            </div><!-- End .input-group -->
                                        </form>
                                    </div>
                                </div><!-- End .float-left -->

                                <div class="float-right">
                                    <button type="submit" class="btn btn-shop btn-update-cart">
                                        Update Cart
                                    </button>
                                </div><!-- End .float-right -->
                            </td>
                        </tr>
                    </tfoot> --}}
                </table>
            </div><!-- End .cart-table-container -->
        </div><!-- End .col-lg-8 -->

        <div class="col-lg-4">
            <div class="cart-summary">
                <h3 class="text-center">Order Details</h3>

                <table class="table table-totals">
                    <tbody>
                        <tr>
                            <td colspan="2" class="text-left">
                                <form action="#">
                                    <div class="form-group form-group-sm">
                                        <label for="receiver_name"><strong>Receiver Name</strong></label>
                                        <input type="text" class="form-control" id="receiver_name" placeholder="Receiver name" value="">
                                    </div>
                                    <div class="form-group form-group-sm">
                                        <label for="receiver_mobile_no"><strong>Receiver Mobile No</strong></label>
                                        <input type="number" class="form-control" id="receiver_mobile_no" placeholder="Receiver mobile no" value="">
                                    </div>
                                    <div class="form-group form-group-sm">
                                        <label for="expected_date"><strong>Expected Delivery Date</strong></label>
                                        <input type="date" class="form-control" id="expected_date" placeholder="Expected date" value="{{date('Y-m-d', strtotime('+15 days'))}}">
                                    </div>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-left">
                                <h5 class="text-center">BILLING ADDRESS</h5>

                                <b>{{ $CustomerData->CustomerName }}</b>,<br>
                                {{ $CustomerData->Address }},<br>
                                {{ $CustomerData->CityName }}, {{ $CustomerData->TalukName }},<br>
                                {{ $CustomerData->DistrictName }}, {{ $CustomerData->StateName }},<br>
                                {{ $CustomerData->CountryName }} - {{ $CustomerData->PostalCode }}. <br>
                                <br>
                                Contact No : <strong>{{ $CustomerData->MobileNo1}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-left">
                                <h5 class="text-center">DELIVERY ADDRESS</h5>

                                <b>{{ $CustomerData->CustomerName }}</b>,<br>
                                {{ $DeliveryAddress->Address }},<br>
                                {{ $DeliveryAddress->CityName }}, {{ $DeliveryAddress->TalukName }},<br>
                                {{ $DeliveryAddress->DistrictName }}, {{ $DeliveryAddress->StateName }},<br>
                                {{ $DeliveryAddress->CountryName }} - {{ $DeliveryAddress->PostalCode }}.
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="checkout-methods">
                    <a href="#" class="btn btn-block btn-dark" id="btnQuoteRequest">Request Quotation
                        <i class="fa fa-arrow-right"></i></a>
                </div>
            </div><!-- End .cart-summary -->
        </div><!-- End .col-lg-4 -->
    </div><!-- End .row -->

    <div id="confirm-modal" class="newsletter-popup mfp-hide bg-img p-6 h-auto" style="background: #f1f1f1 no-repeat center/cover">
        <h2>Are you sure you want to request a quote?</h2>
        <div class="modal-buttons">
            <button id="btnMConfirm" class="btn btn-primary">Confirm</button>
            <button id="btnMCancel" class="btn btn-secondary">Cancel</button>
        </div>
    </div>

</div>

@endsection
@section('scripts')
<script>
    $(document).ready(function(){

        /* $(document).on('click', '#btnQuoteRequest', async function () {
            let formData = {};
            let status = true
            if (status) {
                if (confirm('Are you sure you want to request a quote?')) {
                    let postUrl = "{{url('/')}}/place-order";
                    $.ajax({
                        type: "post",
                        url: postUrl,
                        headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        error: function (e, x, settings, exception) { ajax_errors(e, x, settings, exception); },
                        complete: function (e, x, settings, exception) { $("html, body").animate({ scrollTop: 0 }, "slow"); },
                        success: function (response) {
                            if (response.status == true) {
                                window.location.replace("{{url('/')}}/customer-home");
                            } else {
                                $("html, body").animate({ scrollTop: 0 }, "slow");
                            }
                        }
                    });
                }
            }

        }); */
        $('#btnQuoteRequest').on('click', function () {
            $.magnificPopup.open({
                items: {
                    src: '#confirm-modal'
                },
                type: 'inline',
                mainClass: 'mfp',
                removalDelay: 350
            });
        });

        $('#btnMConfirm').on('click', function () {
            let receiver_name = $('#receiver_name').val();
            let receiver_mobile_no = $('#receiver_mobile_no').val();
            let expected_date = $('#expected_date').val();
            var errorStatus = true;
            if (!receiver_name) {
                toastr.warning("Receiver name should not be empty!");
                errorStatus = false;
            }
            if (!receiver_mobile_no && !/^\d+$/.test(receiver_mobile_no)) {
                toastr.warning("Receiver mobile number should not be empty and contain only numbers!!");
                errorStatus = false;
            }
            if (!expected_date) {
                toastr.warning("Expected date should not be empty!");
                errorStatus = false;
            }

            if (errorStatus) {
                let formData = new FormData();
                formData.append('ReceiverName', $('#receiver_name').val());
                formData.append('ReceiverMobNo', $('#receiver_mobile_no').val());
                formData.append('ExpectedDeliveryDate', $('#expected_date').val());
                $.ajax({
                    type: "post",
                    url: "{{url('/')}}/place-order",
                    headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')},
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    error: function (e, x, settings, exception) {
                        ajaxErrors(e, x, settings, exception);
                    },
                    complete: function (e, x, settings, exception) {
                        $("html, body").animate({scrollTop: 0}, "slow");
                    },
                    success: function (response) {
                        if (response.status == true) {
                            window.location.replace("{{url('/')}}");
                        } else {
                            $("html, body").animate({scrollTop: 0}, "slow");
                        }
                    }
                });
            } else {
                $("html, body").animate({scrollTop: 0}, "slow");
                $('#btnMCancel').click();
            }
        });

        $('#btnMCancel').on('click', function () {
            $.magnificPopup.close();
        });

    });
</script>
@endsection
