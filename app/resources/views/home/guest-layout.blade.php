<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{$Company['CompanyName']}}</title>

    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="{{$Company['CompanyName']}}">
    <meta name="author" content="SW-THEMES">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{url('/')}}/{{$Company['Logo']}}">
    <link rel="preload" href="{{url('/')}}/home/assets/vendor/fontawesome-free/webfonts/fa-regular-400.woff2" as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="{{url('/')}}/home/assets/vendor/fontawesome-free/webfonts/fa-solid-900.woff2" as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="{{url('/')}}/home/assets/vendor/fontawesome-free/webfonts/fa-brands-400.woff2" as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="stylesheet" href="{{url('/')}}/home/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{url('/')}}/home/assets/css/slider.css">
    <link rel="stylesheet" href="{{url('/')}}/home/assets/css/demo42.min.css">
    <link rel="stylesheet" href="{{url('/')}}/home/assets/css/toastr.css">
    {{-- <link rel="stylesheet" href="{{url('/')}}/home/assets/css/style.min.css"> --}}
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/home/assets/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/plugins/image-cropper/cropper.css?r={{date('YmdHis')}}">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/plugins/dropify/css/dropify.min.css?r={{date('YmdHis')}}">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/select2.css?r={{date('YmdHis')}}">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/select2.css?r={{date('YmdHis')}}">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/datatables.css?r={{date('YmdHis')}}">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/plugins/dataTable/css/responsive.dataTables.min.css?r={{date('YmdHis')}}">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/plugins/dataTable/css/fixedHeader.dataTables.min.css?r={{date('YmdHis')}}">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/plugins/dataTable/css/fixedColumns.dataTables.min.css?r={{date('YmdHis')}}">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/plugins/dataTable/css/bootstrap5.dataTables.min.css?r={{date('YmdHis')}}">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/datatable-extension.css?r={{date('YmdHis')}}">
    {{-- <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/bootstrap.css?r={{date('YmdHis')}}"> --}}
    <script>
        WebFontConfig = {
            google: { families: [ 'Open+Sans:400,600', 'Poppins:400,500,600,700' ] }
        };
        ( function ( d ) {
            var wf = d.createElement( 'script' ), s = d.scripts[ 0 ];
            wf.src = '{{url('/')}}/home/assets/js/webfont.js';
            wf.async = true;
            s.parentNode.insertBefore( wf, s );
        } )( document );
    </script>

</head>

<body>
<input type="hidden" style="display:none!important" id="txtRootUrl" value="{{url('/')}}/">
<div class="page-wrapper">
{{--    <div class="top-notice bg-dark text-white pt-3">--}}
{{--        <div class="container text-center d-flex align-items-center justify-content-center flex-wrap">--}}
{{--            <h4 class="text-uppercase font-weight-bold mr-2">Deal of the week</h4>--}}
{{--            <h6>- 15% OFF in All Construction Materials, -</h6>--}}

{{--            <a href="#" class="ml-2">Shop Now</a>--}}
{{--        </div><!-- End .container -->--}}
{{--    </div><!-- End .top-notice -->--}}

    <header class="header">
        <div class="header-top">
            <div class="container">
                <div class="header-left d-md-block">
                @if(auth()->check())
                    <div class="align-middle" style="display: inline-block;">
                        <div class="info-box info-box-icon-left justify-content-start">
                            <i class="icon-location" style="color:#ff6840;"></i>
                            <div class="align-middle" style="display: inline-block; height: 20px; vertical-align: middle !important;">
                                <h6 class="font-weight-bold text-dark" style="line-height: 18px;">Delivery Location - </h6>
                            </div>
                        </div>
                    </div>

                    <div class="header-dropdown" style="display: inline-block;margin-left:0">
                        @if(isset($ShippingAddress) && (count($ShippingAddress) > 0))
                            <a href="#" style="margin-top:10px" id="customerSelectedAddress"
                                data-selected-postal-id="{{ $ShippingAddress[0]->PostalCodeID }}" data-selected-latitude="{{ '11.048274' }}" data-selected-longitude="{{ '76.9885352' }}">
                                {{ $ShippingAddress[0]->Address ?? '' }}
                                , {{ $ShippingAddress[0]->CityName }}, {{ $ShippingAddress[0]->TalukName }}
                                , {{ $ShippingAddress[0]->DistrictName }}, {{ $ShippingAddress[0]->StateName }}
                                ,{{ $ShippingAddress[0]->CountryName }} - {{ $ShippingAddress[0]->PostalCode }}.
                            </a>
                            <ul id="changeCustomerAddressUl">
                                @foreach ($ShippingAddress as $key => $item)
                                    <li><a href="#" data-postal-id="{{ $item->PostalCodeID }}" data-latitude="{{ $key.'11.048274' }}" data-longitude="{{ $key.'76.9885352' }}">
                                            {{ $item->Address }}, {{ $item->CityName }}
                                            , {{ $item->TalukName }}, {{ $item->DistrictName }}
                                            , {{ $item->StateName }},{{ $item->CountryName }}
                                            - {{ $item->PostalCode }}.</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @elseif($PostalCode)
                    <div class="align-middle" style="display: inline-block;">
                        <div class="info-box info-box-icon-left justify-content-start">
                            <i class="icon-location" style="color:#ff6840;"></i>
                            <div class="align-middle" style="display: inline-block; height: 20px; vertical-align: middle !important;">
                                <h6 class="d-flex font-weight-bold text-dark" style="line-height: 18px; position: relative;">
                                            <span class="delivery-location-sm-hide">Delivery Location - &nbsp;</span> {{$PostalCode}}
                                                <span id="btnClearPincode" class="px-3">
                                                    <i class="fas fa-times text-danger" style="font-size: 12px;"></i>
                                                </span>
                                        </h6>
                            </div>
                        </div>
                    </div>
                @endif
                </div>
                <div class="header-right header-dropdowns ml-0 ml-md-auto w-md-100">
                    <div class="header-dropdown mr-auto mr-md-0">
                        <div class="header-menu">

                        </div><!-- End .header-menu -->
                    </div><!-- End .header-dropown -->
                    <ul class="d-none d-xl-flex mb-0 pr-2 align-items-center">
                        <li>
                            <a href="{{url('/')}}/social/auth/google" style="font-size: 12px;"><i
                                    class="icon-help-circle" style="font-size: 18px;"></i>&nbsp;Help</a>
                        </li>
                    </ul>


                    <span class="separator d-none d-md-block mr-0 ml-4"></span>

                    <div class="social-icons">
                        <a href="{{$Company['facebook']}}" class="social-icon social-facebook icon-facebook" target="_blank" title="facebook"></a>
                        <a href="{{$Company['instagram']}}" class="social-icon social-instagram icon-instagram" target="_blank" title="instagram"></a>
                        <a href="{{$Company['youtube']}}" class="social-icon social-youtube fab fa-youtube" target="_blank" title="YouTube"></a>
                    </div><!-- End .social-icons -->
                </div><!-- End .header-right -->
            </div><!-- End .container -->
        </div><!-- End .header-top -->

        <div class="header-middle sticky-header" data-sticky-options="{'mobile': true}">
            <div class="container">
                <div class="header-left col-lg-2 w-auto pl-0">

                    <a href="{{url('/')}}" class="logo">
                        <img loading="lazy" src="{{url('/')}}/{{$Company['Logo']}}" width="50" height="50" alt="{{$Company['CompanyName']}}">
                    </a>
                    <span class="ml-3 font-weight-bold">{{$Company['CompanyName']}}</span>
                </div><!-- End .header-left -->

                <div class="header-right w-lg-max">
                    <div class="header-icon header-search header-search-inline header-search-category w-lg-max text-right mb-0">
                        <a href="#" class="search-toggle" role="button"><i class="icon-search-3"></i></a>
                        <div class="header-search-wrapper">
                            <input class="form-control" placeholder="Search..." type="text" id="homeSearch" name="homeSearch">
                            <div id="searchResults" class="search-results"></div>
                            <button class="btn icon-magnifier p-0" title="search"></button>
                        </div>
                    </div>

                    <span class="separator d-none d-lg-block"></span>

                    <div class="sicon-box mb-0 d-none d-lg-flex align-items-center pr-3 mr-1">
                        <div class=" sicon-default">
                            <i class="icon-phone-1"></i>
                        </div>
                        <div class="sicon-header">
                            <h4 class="sicon-title ls-n-25">CALL US NOW</h4>
                            <p>+91 {{$Company['Phone-Number']}}</p>
                        </div>
                    </div>

                    <span class="separator d-none d-lg-block mr-4"></span>
                    @if(auth()->check())
                        <a href="{{url('/')}}/customer-profile" class="d-lg-block d-none">
                            <div class="header-user">
                                <i class="icon-user-2"></i>
                            </div>
                        </a>
                    @else
                        <a href="{{url('/')}}/social/auth/google" class="d-lg-block d-none" id="loginBtn">
                            <div class="header-user">
                                <div class="header-userinfo">
                                    <span>Welcome</span>
                                    <h4>Sign In / Register</h4>
                                </div>
                            </div>
                        </a>
                    @endif

                    <span class="separator d-block"></span>

                    <div class="dropdown cart-dropdown">
                        <a href="#" title="Cart" class="dropdown-toggle dropdown-arrow cart-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                            <i class="icon-cart-thick"></i>
                            {{-- <i class="fa-regular fa-cart-shopping"></i> --}}
                            {{-- <span class="cart-count badge-circle">3</span> --}}
                        </a>

                        <div class="cart-overlay"></div>

                        <div class="dropdown-menu mobile-cart">
                            <a href="#" title="Close (Esc)" class="btn-close">×</a>

                            <div class="dropdownmenu-wrapper custom-scrollbar">
                                <div class="dropdown-cart-header">Shopping Cart</div>

                                <span>Your Cart is Empty!</span>

                                <div class="dropdown-cart-action">
                                        <a href="{{ route('products.guest.productsList') }}" class="btn btn-dark btn-block">Add to Cart</a>
                                    </div><!-- End .dropdown-cart-total -->
                            </div><!-- End .dropdownmenu-wrapper -->
                        </div><!-- End .dropdown-menu -->
                    </div><!-- End .dropdown -->
                </div><!-- End .header-right -->
            </div><!-- End .container -->
        </div><!-- End .header-middle -->

        <div class="header-bottom sticky-header d-none d-lg-flex" data-sticky-options="{'mobile': false}">
            <div class="container">
                <nav class="main-nav w-100">
                    <ul class="menu w-100">
                        <li class="menu-item d-flex align-items-center">
                            <a href="#" class="d-inline-flex align-items-center sf-with-ul">
                                <i class="custom-icon-toggle-menu d-inline-table"></i><span>All
                                        Categories</span></a>
                            <div class="menu-depart">
                                @foreach ($PCategories->take(5) as $row)
                                    <a href="{{ route('products.guest.subCategoryList', [ 'CID' => $row->PCID ]) }}">{{$row->PCName}}</a>
                                @endforeach
                                    <div style="text-align: center; display: flex; justify-content: center; align-items: center;">
                                        <a href="{{ route('products.guest.categoriesList') }}" class="text-center">More</a>
                                    </div>
                            </div>
                        </li>
                        <li class="active">
                            <a href="{{ route('homepage') }}">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('guest.products') }}">Products</a>
                        </li>
                    </ul>
                </nav>
            </div><!-- End .container -->
        </div><!-- End .header-bottom -->
    </header><!-- End .header -->

    <main class="main">
        @yield('content')
    </main>
    <!-- End .main -->

    <footer class="footer bg-dark position-relative">
        <div class="footer-middle">
            <div class="container position-static">
                <div class="row">
                    <div class="col-lg-2 col-sm-6 pb-2 pb-sm-0 d-flex align-items-center">
                        <div class="widget m-b-3">
                            <img loading="lazy" src="{{url('/')}}/{{$Company['Logo']}}" alt="Logo" width="202" height="54" class="logo-footer">

                        </div><!-- End .widget -->
                    </div><!-- End .col-lg-3 -->

                    <div class="col-lg-3 col-sm-6 pb-4 pb-sm-0">
                        <div class="widget mb-2">
                            <h4 class="widget-title mb-1 pb-1">Get In Touch</h4>
                            <ul class="contact-info">
                                <li>
                                    <span class="contact-info-label">Address:</span>{{$Company['Address']}}<br>{{$Company['AddressData']->CityName}}, {{$Company['AddressData']->DistrictName}}, {{$Company['AddressData']->StateName}}, {{$Company['AddressData']->CountryName}} - {{$Company['AddressData']->PostalCode}}.
                                </li>
                                <li>
                                    <span class="contact-info-label">Phone:</span><a href="#">+91 {{$Company['Phone-Number']}}@if($Company['Mobile-Number']), +91 {{$Company['Mobile-Number']}} @endif</a>
                                </li>
                                  <li>
                                    <span class="contact-info-label">Email:</span>
                                    <a href="mailto:{{$Company['E-Mail']}}"><span
                                            class="__cf_email__"
                                            >{{$Company['E-Mail']}}</span></a>
                                </li>
                            </ul>
                        </div><!-- End .widget -->
                    </div><!-- End .col-lg-3 -->

                    <div class="col-lg-3 col-sm-6 pb-2 pb-sm-0">
                        <div class="widget">
                            <h4 class="widget-title pb-1">Customer Service</h4>

                            <ul class="links">
                                @foreach(DB::table('tbl_page_content')->select('Slug', 'PageName')->get() as $Policy)
                                    <li><a href="{{ route('policies', $Policy->Slug) }}">{{ $Policy->PageName ?? '' }}</a></li>
                                @endforeach
                            </ul>
                        </div><!-- End .widget -->
                    </div><!-- End .col-lg-3 -->

                    <div class="col-lg-4 col-sm-6 pb-0 text-center">
                           <div class="social-icons">
                                @if(array_key_exists('facebook', $Company) && $Company['facebook'])
                                    <a href="{{$Company['facebook']}}" class="social-icon social-facebook icon-facebook" target="_blank" title="Facebook"></a>
                                @endif

                                @if(array_key_exists('instagram', $Company) && $Company['instagram'])
                                    <a href="{{$Company['instagram']}}" class="social-icon social-instagram icon-instagram" target="_blank" title="Instagram"></a>
                                @endif

                                @if(array_key_exists('youtube', $Company) && $Company['youtube'])
                                    <a href="{{$Company['youtube']}}" class="social-icon social-youtube fab fa-youtube" target="_blank" title="YouTube"></a>
                                @endif

                                @if(array_key_exists('twitter', $Company) && $Company['twitter'])
                                    <a href="{{$Company['twitter']}}" class="social-icon social-twitter fab fa-twitter" target="_blank" title="Twitter"></a>
                                @endif

                                @if(array_key_exists('linkedin', $Company) && $Company['linkedin'])
                                    <a href="{{$Company['linkedin']}}" class="social-icon social-linkedin fab fa-linkedin-in" target="_blank" title="Linkedin"></a>
                                @endif
                            </div><!-- End .social-icons -->
                        </div><!-- End .col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .footer-middle -->

        <div class="container">
            <div class="footer-bottom bg-dark text-center">
                <div class="footer-left">
                    <span class="footer-copyright">{{$Company['CompanyName']}}. © 2024. All Rights Reserved</span>
                </div>
            </div>
        </div><!-- End .footer-bottom -->
    </footer>
</div><!-- End .page-wrapper -->

<div class="loading-overlay">
    <div class="bounce-loader">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>

<div class="mobile-menu-overlay"></div>
<div class="sticky-navbar">
        <div class="sticky-info">
            <a href="{{ route('homepage') }}">
                <i class="icon-home"></i>Home
            </a>
        </div>
        <div class="sticky-info">
            <a href="{{ route('products.guest.categoriesList') }}" class="">
                <i class="icon-bars"></i>Categories
            </a>
        </div>
        <div class="sticky-info">
            <a href="{{url('/')}}/social/auth/google" class="">
                <i class="icon-user-2"></i>Account
            </a>
        </div>
        <div class="sticky-info">
            <a href="{{ route('products.guest.productsList') }}" class="">
                <i class="icon-category-saddle"></i>Products
            </a>
        </div>
        <div class="sticky-info">
            <a href="#" title="Cart" class="dropdown-toggle dropdown-arrow cart-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                <i class="icon-shopping-cart position-relative"></i>Cart
            </a>
        </div>
    </div>
{{--<div class="newsletter-popup mfp-hide bg-img p-0 h-auto" id="newsletter-popup-form" style="background: #f1f1f1 no-repeat center/cover">--}}
{{--    <div class="row">--}}
{{--        <div class="col-sm-7">--}}
{{--            <div class="row justify-content-center mt-3">--}}
{{--                <div class="col-6">--}}
{{--                    <img loading="lazy" src="{{url('/')}}/{{$Company['Logo']}}" alt="Logo" class="logo-newsletter" width="50" height="50">--}}
{{--                    <span class="ml-3 font-weight-bold text-dark">{{$Company['CompanyName']}}</span>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="row justify-content-center my-3">--}}
{{--                <div class="col-8">--}}
{{--                    <h2>Select a location </h2>--}}
{{--                    <p>to see product availability and delivery options</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="row justify-content-center">--}}
{{--                <div class="col-6 justify-content-center">--}}
{{--                    <a href="{{url('/')}}/social/auth/google"><button type="button" class="btn btn-info btn-block rounded">Sign in to select address</button></a>--}}

{{--                    --}}{{-- <input type="button" class="btn btn-warning" value="Submit" id="btnCurrentPincode"> --}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="row justify-content-center">--}}
{{--                <div class="col-4">--}}
{{--                    <h5 class="text-center my-3">or</h5>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="row justify-content-center">--}}
{{--                <div class="col-8 newsletter-popup-content" id="divLocationInputs">--}}
{{--                    <div class="input-group">--}}
{{--                        <input type="text" class="form-control" id="txtCurrentPincode" placeholder="Enter your pincode" required>--}}
{{--                        <input type="button" class="btn btn-warning" value="Submit" id="btnCurrentPincode">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-sm-5">--}}
{{--            <img loading="lazy" src="{{url('/')}}/home/assets/images/location-pop-up/MapAnime.gif" alt="">--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <button title="Close (Esc)" type="button" class="mfp-close" id="modal-close-btn">×</button>--}}
{{--</div>--}}


<a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>

<script src="{{url('/')}}/home/assets/js/jquery.min.js"></script>
<script src="{{url('/')}}/assets/js/jquery-3.7.1.min.js?r={{date('YmdHis')}}"></script>
<script src="{{url('/')}}/home/assets/js/bootstrap.bundle.min.js"></script>
<script src="{{url('/')}}/home/assets/js/optional/isotope.pkgd.min.js"></script>
<script src="{{url('/')}}/home/assets/js/plugins.min.js"></script>
<script src="{{url('/')}}/home/assets/js/jquery.appear.min.js"></script>
<script src="{{url('/')}}/home/assets/js/jquery.plugin.min.js"></script>
<script src="{{url('/')}}/home/assets/js/main.js"></script>
<script src="{{url('/')}}/home/assets/js/toastr.js"></script>
<script src="{{url('/')}}/assets/plugins/dropify/js/dropify.js?r={{date('YmdHis')}}"></script>
<script src="{{url('/')}}/assets/plugins/image-cropper/cropper.js?r={{date('YmdHis')}}"></script>
<script src="{{url('/')}}/assets/js/address-web.js?r={{date('YmdHis')}}"></script>
{{--<script src="{{url('/')}}/assets/js/nouislider.min.js?r={{date('YmdHis')}}"></script>--}}
<script src="{{url('/')}}/assets/plugins/bootbox-js/bootbox.min.js?r={{date('YmdHis')}}"></script>
<script src="{{url('/')}}/assets/js/select2/select2.full.min.js?r={{date('YmdHis')}}"></script>
<script src="{{url('/')}}/assets/plugins/dataTable/js/jquery.dataTables.min.js?r={{date('YmdHis')}}"></script>
<script src="{{url('/')}}/assets/js/datatable/datatable-extension/dataTables.buttons.min.js?r={{date('YmdHis')}}"></script>
<script src="{{url('/')}}/assets/js/datatable/datatable-extension/buttons.colVis.min.js?r={{date('YmdHis')}}"></script>
<script src="{{url('/')}}/assets/js/datatable/datatable-extension/dataTables.autoFill.min.js?r={{date('YmdHis')}}"></script>
<script src="{{url('/')}}/assets/js/datatable/datatable-extension/dataTables.select.min.js?r={{date('YmdHis')}}"></script>
<script src="{{url('/')}}/assets/js/datatable/datatable-extension/buttons.bootstrap4.min.js?r={{date('YmdHis')}}"></script>
<script src="{{url('/')}}/assets/js/datatable/datatable-extension/buttons.html5.min.js?r={{date('YmdHis')}}"></script>
<script src="{{url('/')}}/assets/js/datatable/datatable-extension/buttons.print.min.js?r={{date('YmdHis')}}"></script>
<script src="{{url('/')}}/assets/js/datatable/datatable-extension/dataTables.rowReorder.min.js?r={{date('YmdHis')}}"></script>
<script src="{{url('/')}}/assets/plugins/dataTable/js/dataTables.responsive.min.js?r={{date('YmdHis')}}"></script>
<script src="{{url('/')}}/assets/plugins/dataTable/js/dataTables.fixedHeader.min.js?r={{date('YmdHis')}}"></script>
<script src="{{url('/')}}/assets/plugins/dataTable/js/dataTables.fixedColumns.min.js?r={{date('YmdHis')}}"></script>
<script src="{{url('/')}}/assets/plugins/dataTable/js/dataTables.bootstrap5.min.js?r={{date('YmdHis')}}"></script>

<script src="{{url('/')}}/assets/plugins/dataTable/js/dataTableExport.js?r={{date('YmdHis')}}"></script>
<script>
    $(document).ready(function() {
        $('.redirectLogin').on('click', function(){
            window.location.replace($('#loginBtn').attr('href'));
        });

        const UpdateItemQtyCount = (count) => {
            const itemCountSpan = $('#divCartItemCount');
            if (count > 0) {
                itemCountSpan.text(count);
                $('#divCartAction').html(`<a href="{{url('/')}}/checkout" class="btn btn-secondary btn-block">Quote Request</a>`);
            } else {
                itemCountSpan.text('');
                $('#divCartAction').html(`<a href="{{ auth()->check() ? route('products.customer.productsList') : route('products.guest.productsList') }}" class="btn btn-dark btn-block">Add to Cart</a>`);
            }
        };

        const LoadCart = (data) => {
            let Parent = $('#divCart');
            Parent.html('');

            data.forEach((item) => {
                let Content = `<div class="product">
                                        <div class="product-details">
                                            <h4 class="product-title">
                                                <a href="#">${item.ProductName}</a>
                                            </h4>

                                            <span class="cart-product-info">
                                                <span class="cart-product-qty">
                                                    <div class="input-group" style="width: 80%;">
                                                        <input class="form-control txtUpdateQty" type="number" min="1" value="${item.Qty}" id="${item.ProductID}">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">${item.UName} (${item.UName})</span>
                                                        </div>
                                                    </div>
                                                </span>
                                            </span>
                                        </div>

                                        <figure class="product-image-container">
                                            <a href="#" class="product-image">
                                                <img loading="lazy" src="${item.ProductImage}" alt="product" width="80" height="80">
                                            </a>
                                            <a href="#" class="btn-remove btnRemoveCart" title="Remove Product" id="${item.ProductID}"><span>×</span></a>
                                        </figure>
                                    </div>`;
                Parent.append(Content);
            });
        };

        $(document).on('click', '.btnAddCart', function () {

            let FormData = {
                'ProductID': $(this).attr('id'),
            }
            $.ajax({
                type: "post",
                data: FormData,
                url: "{{ route('add-cart') }}",
                headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')},
                dataType: "json",
                error: function (e, x, settings, exception) {
                    ajaxErrors(e, x, settings, exception);
                },
                complete: function (e, x, settings, exception) {
                },
                success: function (response) {
                    if (response.status) {
                        thiss.text("Added in cart");
                        thiss.removeClass('btnAddCart btn-add-cart');
                        LoadCart(response.data);
                        UpdateItemQtyCount(response.data.length);
                    }
                }
            });
        });

        $(document).on('input', '.txtUpdateQty', function () {
            let Qty = $(this).val();
            if((Qty > 0) && Number.isInteger(parseFloat(Qty))){
                let FormData = {
                    'ProductID' : $(this).attr('id'),
                    'Qty' : parseInt(Qty),
                }
                $.ajax({
                    type:"post",
                    data: FormData,
                    url:"{{url('/')}}/update-cart",
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    dataType:"json",
                    error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                    complete: function(e, x, settings, exception){},
                    success:function(response){
                        if(response.status){
                            // LoadCart(response.data);
                        }
                    }
                });
            }
        });
        $(document).on('blur', '.txtUpdateQty', function () {
            let Qty = $(this).val();
            if((Qty < 0) || !Number.isInteger(parseFloat(Qty))){
                $(this).val(1);
            }
        });
        $(document).on('click', '.btnRemoveCart', function () {
            $(this).closest('.product').remove();
            let FormData = {
                'ProductID' : $(this).attr('id'),
            }
            $.ajax({
                type:"post",
                data: FormData,
                url:"{{url('/')}}/delete-cart",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    if(response.status){
                        UpdateItemQtyCount(response.data.length);
                    }
                }
            });
            let Parent = $('#divCart');
            if (Parent.find('.product').length === 0) {
                Parent.html('<span>Your Cart is Empty!</span>');
            }
        });

        $('#changeCustomerAddressUl li a').on('click', function(e){
            e.preventDefault();
            let selectedAddress = $('#customerSelectedAddress');
            selectedAddress.attr('data-selected-postal-id', $(this).data('postal-id'));
            selectedAddress.attr('data-selected-latitude', $(this).data('latitude'));
            selectedAddress.attr('data-selected-longitude', $(this).data('longitude'));
            selectedAddress.html($(this).html());
        });

        function performSearch(resultsElementId, searchText) {
            var formData = new FormData();
            formData.append('SearchText', searchText);
            $.ajax({
                url: "{{ route('guestHomeSearch') }}",
                method: 'POST',
                headers: { 'X-CSRF-Token': '{{ csrf_token() }}' },
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    let searchResults = $('#' + resultsElementId);
                    searchResults.empty();
                    searchResults.append((response.searchResults !== "") ? response.searchResults : "No results found");
                    searchResults.show();
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        $('#homeSearch').on('keyup', function () {
            performSearch('searchResults', $(this).val());
        });

        $('#mblHomeSearch').on('keyup', function () {
            performSearch('mblSearchResults', $(this).val());
        });

        $('.search-toggle-btn').on('click', function(){
            var mblSearchDiv = $("#mbl-header-search-div")
            if(mblSearchDiv.hasClass('d-none')){
                mblSearchDiv.removeClass('d-none');
            } else {
                mblSearchDiv.addClass('d-none');
            }
        });

        $(document).on('click', function(event) {
            if (!$(event.target).closest('.header-search-wrapper').length) {
                $('#searchResults').hide();
            }
        });

        $('#btnCurrentPincode').on('click', function(e){
            e.preventDefault();
            let Pincode = $('#txtCurrentPincode');
            let formData=new FormData();
            formData.append('Pincode', Pincode);
            $.ajax({
                url: "{{ route('setPostalCodeInSession') }}",
                headers: { 'X-CSRF-Token' : '{{ csrf_token() }}' },
                processData: false,
                contentType: false,
                type: "POST",
                data: formData,
                success: function(response) {
                    // console.log(response.message);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
        $('#btnClearPincode').on('click', function(e){
                e.preventDefault();
                $.ajax({
                    url: "{{ route('removePostalCodeInSession') }}",
                    headers: { 'X-CSRF-Token' : '{{ csrf_token() }}' },
                    processData: false,
                    contentType: false,
                    type: "POST",
                    success: function(response) {
                        if(response.status == true){
                            window.location.reload();
                        }
                    }
                });
            });
    });
</script>

@yield('scripts')
</body>

</html>
