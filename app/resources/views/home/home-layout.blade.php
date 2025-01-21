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
    <meta name="_token" content="{{ csrf_token() }}"/>


    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{url('/')}}/{{$Company['Logo']}}">
    <link rel="preload" href="{{url('/')}}/home/assets/vendor/fontawesome-free/webfonts/fa-regular-400.woff2" as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="{{url('/')}}/home/assets/vendor/fontawesome-free/webfonts/fa-solid-900.woff2" as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="{{url('/')}}/home/assets/vendor/fontawesome-free/webfonts/fa-brands-400.woff2" as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="stylesheet" href="{{url('/')}}/home/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{url('/')}}/home/assets/css/slider.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/sweetalert2.css?r={{date('YmdHis')}}">
    <link rel="stylesheet" href="{{url('/')}}/home/assets/css/demo42.min.css">
    <link rel="stylesheet" href="{{url('/')}}/home/assets/css/toastr.css">
    <link rel="stylesheet" href="{{url('/')}}/assets/home/vendor/simple-line-icons/css/simple-line-icons.min.css">
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

    <style>
        .dropify-wrapper {
            border-radius: unset !important;
        }

        .dropify-message p {
            display: none !important;
        }

        /* CSS used here will be applied after bootstrap.css */

        .dropdown {
            display:inline-block;
            margin-left:20px;
            padding:10px;
        }


        .glyphicon-bell {

            font-size:1.5rem;
        }

        .notifications {
            min-width:420px;
        }

        .notifications-wrapper {
            overflow:auto;
            max-height:250px;
        }

        /*.menu-title {*/
        /*    color: #5b5b5b;*/
        /*    font-size: 1.5rem;*/
        /*    display: inline-block;*/
        /*}*/
        .menu-title {
            color: #2d5aba;
            font-size: 1.5rem;
            display: inline-block;
        }

        .glyphicon-circle-arrow-right {
            margin-left:10px;
        }


        .notification-heading, .notification-footer  {
            padding:2px 10px;
        }


        .dropdown-menu.divider {
            margin:5px 0;
        }

        .item-title {

            font-size:1.3rem;
            color:#000;

        }

        .notifications a.content {
            text-decoration:none;
            background:#ccc;

        }

        .notification-item {
            padding:10px;
            margin:5px;
            background:#ccc;
            border-radius:0px;
        }

        /*.badge-notification {*/
        /*    position: absolute;*/
        /*    top: 15px;*/
        /*    right: 142px;*/
        /*    width: 1.6rem;*/
        /*    border-radius: 75%;*/
        /*    color: #fff;*/
        /*    background: #ff5b5b;*/
        /*    font-weight: 600;*/
        /*    font-size: 1.1rem;*/
        /*    line-height: 1.6rem;*/
        /*    font-family: "Open Sans", sans-serif;*/
        /*    text-align: center;*/
        /*}*/

        /*.badge-notification {*/
        /*    position: absolute;*/
        /*    top: 20%;*/
        /*    right: 12%;*/
        /*    width: 1.6rem;*/
        /*    border-radius: 75%;*/
        /*    color: #fff;*/
        /*    background: #ff5b5b;*/
        /*    font-weight: 600;*/
        /*    font-size: 1.1rem;*/
        /*    line-height: 1.6rem;*/
        /*    font-family: "Open Sans", sans-serif;*/
        /*    text-align: center;*/
        /*}*/

        /*@media (max-width: 1220px) {*/
        /*    .notification-count {*/
        /*        right: 13%;*/
        /*    }*/
        /*}*/
        /*@media (max-width: 1195px) {*/
        /*    .notification-count {*/
        /*        right: 15%;*/
        /*    }*/
        /*}*/
        /*@media (max-width: 1190px) {*/
        /*    .notification-count {*/
        /*        right: 15%;*/
        /*    }*/
        /*}*/
        /*@media (max-width: 995px) {*/
        /*    .notification-count {*/
        /*        right: 10%;*/
        /*    }*/
        /*}*/
        /*@media (max-width: 992px) {*/
        /*    .notification-count {*/
        /*        right: 13%;*/
        /*    }*/
        /*}*/
        /*@media (max-width: 974px) {*/
        /*    .notification-count {*/
        /*        right: 10%;*/
        /*    }*/
        /*}*/
        /*@media (max-width: 967px) {*/
        /*    .notification-count {*/
        /*        right: 10%;*/
        /*    }*/
        /*}*/
        /*@media (max-width: 940px) {*/
        /*    .notification-count {*/
        /*        right: 13%;*/
        /*    }*/
        /*}*/
        /*@media (max-width: 660px) {*/
        /*    .notification-count {*/
        /*        right: 15%;*/
        /*    }*/
        /*}*/
        /*@media (max-width: 488px) {*/
        /*    .notification-count {*/
        /*        right: 15%;*/
        /*    }*/
        /*}*/
        /*@media (max-width: 495px) {*/
        /*    .notification-count {*/
        /*        right: 17%;*/
        /*    }*/
        /*}*/
        /*@media (max-width: 460px) {*/
        /*    .notification-count {*/
        /*        right: 19%;*/
        /*    }*/
        /*}*/
        /*@media (max-width: 442px) {*/
        /*    .notification-count {*/
        /*        right: 22%;*/
        /*    }*/
        /*}*/
        /*@media (max-width: 378px) {*/
        /*    .notification-count {*/
        /*        right: 26%;*/
        /*    }*/
        /*}*/

        .btn-wrapper {
            position: relative;
            display: inline-block;
        }

        .unread-badge {
            position: absolute;
            top: 20px;
            right: 17px;
            width: 1.6rem;
            height: 10px;
            background-color: #ff5b5b;
            border-radius: 50%;
        }
        #homeBannerList {
            display: none !important;
        }
    </style>
</head>

<body>
<input type="hidden" style="display:none!important" id="txtRootUrl" value="{{url('/')}}/">

<div class="page-wrapper">
    <header class="header">
        <div class="header-top">
            <div class="container">
                @if(!$isRegister)
                    <div class="header-left d-md-block">
                        <div class="align-middle" style="display: inline-block;">
                            <div class="info-box info-box-icon-left justify-content-start">
                                <i class="icon-location" style="color:#ff6840;"></i>
                                <div class="align-middle" style="display: inline-block; height: 20px; vertical-align: middle !important;">
                                    <h6 class="font-weight-bold text-dark" style="line-height: 18px;"><span class="delivery-location-sm-hide">Delivery Location - &nbsp;</span></h6>
                                </div>
                            </div>
                        </div>

                        <div class="header-dropdown px-3" style="display: inline-block;margin-left:0">
                            @if(isset($ShippingAddress) && (count($ShippingAddress) > 0))
                                <a href="#" style="margin-top:10px" id="customerSelectedAddress"
                                   data-selected-postal-id="{{ $ShippingAddress[0]->PostalCodeID }}" data-aid="{{ $ShippingAddress[0]->AID }}" data-selected-latitude="{{ '11.048274' }}" data-selected-longitude="{{ '76.9885352' }}">
                                    {{ $ShippingAddress[0]->Address ?? '' }}
                                    , {{ $ShippingAddress[0]->CityName }}, {{ $ShippingAddress[0]->TalukName }}
                                    , {{ $ShippingAddress[0]->DistrictName }}, {{ $ShippingAddress[0]->StateName }}
                                    ,{{ $ShippingAddress[0]->CountryName }} - {{ $ShippingAddress[0]->PostalCode }}.
                                </a>
                                @if(Route::currentRouteName() !== 'checkout')
                                    <ul id="changeCustomerAddressUl">
                                        @foreach ($ShippingAddress as $key => $item)
                                            <li><a href="#" data-postal-id="{{ $item->PostalCodeID }}" data-aid="{{ $item->AID }}" data-latitude="{{ $key.'11.048274' }}" data-longitude="{{ $key.'76.9885352' }}">
                                                    {{ $item->Address }}, {{ $item->CityName }}
                                                    , {{ $item->TalukName }}, {{ $item->DistrictName }}
                                                    , {{ $item->StateName }},{{ $item->CountryName }}
                                                    - {{ $item->PostalCode }}.</a></li>
                                        @endforeach
                                            <li class="text-center"><a href="#" style="background-color: #2e578f; color: white;" class="addressAddHeaderBtn btnAddAddress">Add Address</a></li>
                                    </ul>
                                @endif
                            @endif
                        </div>
                    </div>
                @endif

                <div class="header-right header-dropdowns ml-0 ml-md-auto w-md-100">
                    <div class="header-dropdown mr-auto mr-md-0">
                        <div class="header-menu">

                        </div><!-- End .header-menu -->
                    </div><!-- End .header-dropown -->
                    <ul class="d-none d-xl-flex mb-0 pr-2 align-items-center">
{{--                        @if(!$isRegister)--}}
{{--                            <li>--}}
{{--                                <a href="{{url('/')}}/social/auth/google" style="font-size: 12px;"><i class="icon-help-circle" style="font-size: 18px;"></i>&nbsp;Help</a>--}}
{{--                            </li>--}}
{{--                        @endif--}}
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
                    <a href="{{ route('homepage') }}" class="logo">
                        <img loading="lazy" src="{{url('/')}}/{{$Company['Logo']}}" width="50" height="50" alt="{{$Company['CompanyName']}}">
                    </a>
                    <span class="ml-3 font-weight-bold" style="color:rgb(7, 54, 163)">{{$Company['CompanyName']}}</span>
                </div>
                <div class="header-right w-lg-max">

                    <div class="header-icon header-search header-search-inline header-search-category w-lg-max text-right mb-0">
                        @if(!$isRegister)
                        <a href="#" class="search-toggle-btn d-lg-none px-3" role="button"><i class="icon-search-3"></i></a>
                        <div class="header-search-wrapper" id="webSearchDiv">
                                <input class="form-control" placeholder="Search..." type="text" id="homeSearch" name="homeSearch">
                                <div id="searchResults" class="search-results"></div>
                                <button class="btn icon-magnifier p-0" title="search"></button>
                            </div>
                        @endif
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

                    @if(!$isRegister)
                        <span class="separator d-none d-lg-block mr-4"></span>

                        <div class="btn-wrapper">
                            <button type="button" class="btn btn-default bg-white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="sicon-bell" style="font-size: 2.8rem;"></i>
                            </button>
                            <span class="unread-badge" style="display: none;"></span>
                            <ul class="dropdown-menu notifications" id="customerNotificationUl" role="menu" aria-labelledby="dLabel">
                                <div class="notification-heading"><h4 class="menu-title">Notifications</h4></div>
                                <li class="divider"></li>
                                <div class="notifications-wrapper" id="customerNotification"></div>
                            </ul>
                        </div>
                    @endif

                    <span class="separator d-none d-lg-block mr-4"></span>

                    <a href="@if($isRegister && !$isEdit) # @else {{url('/')}}/customer-profile @endif" class="d-lg-block d-none">
                        <div class="header-user">
                            <i class="icon-user-2"></i>
                        </div>
                    </a>

                    @if(!$isRegister)
                        <span class="separator d-block"></span>

                        <div class="dropdown cart-dropdown">
                            <a href="#" title="Cart" class="dropdown-toggle dropdown-arrow cart-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                <i class="icon-cart-thick"></i>
                                <i class="fa-regular fa-cart-shopping"></i>
                                <span class="cart-count badge-circle" id="divCartItemCount">@if(count($Cart) > 0){{count($Cart)}}@endif</span>
                            </a>

                            <div class="cart-overlay"></div>

                            <div class="dropdown-menu mobile-cart">
                                <a href="#" title="Close (Esc)" class="btn-close">×</a>

                                <div class="dropdownmenu-wrapper custom-scrollbar">
                                    <div class="dropdown-cart-header">Shopping Cart</div>
                                    <div class="dropdown-cart-products" id="divCart">
                                        @if(count($Cart) > 0)
                                            @foreach($Cart as $item)
                                                <div class="product">
                                                    <div class="product-details">
                                                        <h4 class="product-title">
                                                            <a href="{{ route('products.quickView', $item->ProductID) }}" class="btn-quickview">{{$item->ProductName}}</a>
                                                        </h4>

                                                        <span class="cart-product-info">
                                                                <span class="cart-product-qty">
                                                                    <div class="input-group" style="width: 80%;">
                                                                        <input class="form-control txtUpdateQty" type="number" min="1" value="{{$item->Qty}}" id="{{$item->ProductID}}">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text">{{$item->UName}} ({{$item->UName}})</span>
                                                                        </div>
                                                                    </div>
                                                                </span>
                                                            </span>
                                                    </div>

                                                    <figure class="product-image-container">
                                                        <a href="{{ route('products.quickView', $item->ProductID) }}" class="product-image btn-quickview">
                                                            <img loading="lazy" src="{{ file_exists($item->ThumbnailImg)? url('/'.$item->ThumbnailImg): $item->ProductImage }}" alt="product" width="80" height="80">
                                                        </a>
                                                        <a href="#" class="btn-remove btnRemoveCart" title="Remove Product" id="{{ $item->ProductID }}"><span>×</span></a>
                                                    </figure>
                                                </div>
                                            @endforeach
                                        @else
                                            <span>Your Cart is Empty!</span>
                                        @endif
                                    </div>

                                    <div class="dropdown-cart-action" id="divCartAction">
                                        @if(count($Cart) > 0)
                                            <a href="{{url('/')}}/checkout" class="btn btn-secondary btn-block" data-checkOutUrl="{{ route('checkout') }}">Request Quote</a>
                                        @else
                                            <a href="{{ auth()->check() ? route('products.customer.productsList') : route('products.guest.productsList') }}" class="btn btn-dark btn-block" data-checkOutUrl="{{ route('checkout') }}">Add to Cart</a>
                                        @endif
                                    </div><!-- End .dropdown-cart-total -->
                                </div><!-- End .dropdownmenu-wrapper -->
                            </div><!-- End .dropdown-menu -->
                        </div>
                    @endif
                    <span class="separator d-none d-lg-block mr-4"></span>

                    <a class="d-lg-block">
                        <div class="header-user" id="btnLogout">
                            <i class="sicon-logout fa-flip-horizontal"></i>
                        </div>
                    </a>
                </div><!-- End .header-right -->
            </div><!-- End .container -->
        </div><!-- End .header-middle -->

        <div class="container d-none" id="mbl-header-search-div">
            <div class="row col-12">
                <div class="col-12">
                    <div class="py-2">
                        <div class="input-group" style="width: 100% !important;">
                            <input class="form-control" placeholder="Search..." type="text" id="mblHomeSearch" name="homeSearch">
                            <div class="input-group-append">
                                <button class="btn icon-magnifier px-3" title="search"></button>
                            </div>
                        </div>
                    </div>
                    <div id="mblSearchResults" class="search-results"></div>
                </div>
            </div>
        </div>

        <div class="header-bottom sticky-header d-none d-lg-flex" data-sticky-options="{'mobile': false}">
            <div class="container px-0">
                <div class="row align-items-center w-100">
                    <div class="col-8">
                        <nav class="main-nav">
                            <ul class="menu list-unstyled sf-js-enabled sf-arrows" id="customerNavigationBar">
                                @if(auth()->check() && !$isRegister)
                                <li class="menu-item d-flex align-items-center">
                                    <a href="#" class="d-inline-flex align-items-center sf-with-ul">
                                        <i class="custom-icon-toggle-menu d-inline-table"></i><span>All
                                                Categories</span></a>
                                    <div class="menu-depart">
                                        @foreach ($PCategories->take(5) as $row)
                                            <a href="{{ route('products.customer.subCategoryList', [ 'CID' => $row->PCID ]) }}">{{$row->PCName}}</a>
                                        @endforeach
                                            <div style="text-align: center; display: flex; justify-content: center; align-items: center;">
                                                <a href="{{ route('products.customer.categoriesList') }}" class="text-center">More</a>
                                            </div>
                                    </div>
                                </li>
                                <li class="{{ (Route::currentRouteName() == "homepage") ? 'active' : '' }}">
                                    <a href="{{ route('homepage') }}">Home</a>
                                </li>
                                <li>
                                    <a href="{{ (Route::currentRouteName() == "customer-register") ? '#' : route('products') }}">Products</a>
                                    @if(Route::currentRouteName() != "customer-register")
                                    <div class="megamenu megamenu-fixed-width">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <a href="#" class="nolink">PRODUCT CATEGORIES</a>
                                            </div>

                                            @php
                                                $PCategories = $PCategories->take(9);
                                                $chunks = $PCategories->chunk(3);
                                            @endphp

                                            @foreach ($chunks as $chunk)
                                                <div class="col-lg-4">
                                                    <ul class="submenu">
                                                        @foreach ($chunk as $category)
                                                            <li><a href="{{ route('products.customer.subCategoryList', ['CID' => $category->PCID]) }}">{{ $category->PCName }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach

                                            <div class="col-lg-12 p-1">
                                                <div class="row justify-content-end">
                                                    <div class="col-lg-4">
                                                        <a href="{{ route('products') }}" class="btn btn-sm btn-dark mr-0">View More</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- End .row -->
                                    </div><!-- End .megamenu -->
                                    @endif
                                </li>
                                <li>
                                    <a href="{{ route('my-account') }}">My Account</a>
                                </li>
                            @endif
                            </ul>
                        </nav>
                    </div>
                    <div class="col-4 d-flex text-right justify-content-end p-0">
                        <a href="#AppLinkDiv" class="btn btn-md text-white mx-2 btnHighLight" id="btnBecVen"
                           style="background-color: #ff8800;">Become&nbsp;a&nbsp;vendor</a>
                        <a href="#" class="btn btn-md text-white mx-2 btnHighLight" id="btnPlanServ"
                           style="background-color: #03489c;white-space: nowrap;width: auto !important;">FREE&nbsp;Building&nbsp;Plan</a>
                        <a href="#" class="btn btn-md text-white mx-2 btnHighLight" id="btnConstructionServ"
                           style="background-color: #ff8800;">Construction&nbsp;Service&nbsp;Plan</a>
                    </div>
                </div>
            </div><!-- End .container -->
        </div><!-- End .header-bottom -->
    </header><!-- End .header -->

    <main class="main">
        @yield('content')
    </main>
    <!-- End .main -->
    <div class="container" id="AppLinkDiv" style="border-top: 1px solid #e7e7e7;">
        <div class="row" style="padding: 50px 15px;">
            <div class="col-md-4 col-sm-12 d-flex justify-content-center align-items-center">
                <div style="padding: 15px;">
                    <img src="{{url('assets/images/rpc-apps.png')}}" alt="Get RPC App" class="app-img">
                </div>
            </div>
            <div class="col-md-8 col-sm-12 d-flex justify-content-center align-items-center">
                <div id="get-app">
                    <h3><b>Get RPC App</b></h3>
                    <p class="mt-1">Search for products/services and connect with verified sellers on the go!</p>
                    <div id="send-app-link-mobile">
                        <label style="font-weight: 600; margin: 0;">+91</label>
                        <input type="text" placeholder="Enter Mobile Number" id="appLinkMobileNumberInput"
                               maxlength="10" autocomplete="off">
                        <button class="sent-me-link-btn btn">Sent me the link</button>
                        <div id="app-link-err-msg"></div>
                        <p class="mt-1">We will send you a link, open it on your phone to download the App</p>
                    </div>
                    <div id="download-app-buttons" style="width: 150px !important;">
                        <a target="_blank" href="{{ $AndroidAppUrl ?? '#' }}"><img alt="Google PlayStore logo"
                                                                                   src="{{ url('assets/images/logo/google-play-badge-logo.png') }}"
                                                                                   style="width:150px;"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

<div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

<div class="sticky-navbar">
    <div class="sticky-info">
        <a href="{{ route('homepage') }}">
            <i class="icon-home"></i>Home
        </a>
    </div>
    <div class="sticky-info">
        <a href="{{ route('products.customer.categoriesList') }}" class="">
            <i class="icon-bars"></i>Categories
        </a>
    </div>
    <div class="sticky-info">
        <a href="{{ url('/customer-profile') }} " class="">
            <i class="icon-user-2"></i>Account
        </a>
    </div>
    <div class="sticky-info">
        <a href="{{ route('products.customer.productsList') }}" class="">
            <i class="icon-category-saddle"></i>Products
        </a>
    </div>
    <div class="sticky-info">
        <a href="#" title="Cart" class="dropdown-toggle dropdown-arrow cart-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
            <i class="icon-shopping-cart position-relative">
                <span class="cart-count badge-circle" id="divMblCartItemCount">@if(count($Cart) > 0){{count($Cart)}}@endif</span>
            </i>Cart
        </a>
    </div>
</div>
<div class="modal  medium" tabindex="-1" role="dialog" id="ImgCrop">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header pt-10 pb-10">
                <h5 class="modal-title">Image Crop</h5>
                <button type="button" class="close display-none" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <img loading="lazy" style="width:100%" src="" id="ImageCrop" data-id="">
                    </div>
                </div>
                <div class="row mt-10 d-flex justify-content-center">
                    <div class="col-sm-12 docs-buttons d-flex justify-content-center">
                        <div class="btn-group">
                            <button class="btn btn-outline-primary" type="button" data-method="rotate" data-option="-45" title="Rotate Left"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="$().cropper(&quot;rotate&quot;, -45)"><span class="fa fa-rotate-left"></span></span></button>
                            <button class="btn btn-outline-primary" type="button" data-method="rotate" data-option="45" title="Rotate Right"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="$().cropper(&quot;rotate&quot;, 45)"><span class="fa fa-rotate-right"></span></span></button>
                            <button class="btn btn-outline-primary" type="button" data-method="scaleX" data-option="-1" title="Flip Horizontal"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="$().cropper(&quot;scaleX&quot;, -1)"><span class="fa fa-arrows-h"></span></span></button>
                            <button class="btn btn-outline-primary" type="button" data-method="scaleY" data-option="-1" title="Flip Vertical"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="$().cropper(&quot;scaleY&quot;, -1)"><span class="fa fa-arrows-v"></span></span></button>
                            <button class="btn btn-outline-primary" type="button" data-method="reset" title="Reset"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="$().cropper(&quot;reset&quot;)"><span class="fa fa-refresh"></span></span></button>
                            <button class="btn btn-outline-primary btn-upload" id="btnUploadImage" title="Upload image file"><span class="docs-tooltip" data-bs-toggle="tooltip" data-animation="false" title="Import image with Blob URLs"><span class="fa fa-upload"></span></span></button>
                            <?php
                            $Images=array("jpg","jpeg","png","gif","bmp","tiff");
                            if(isset($FileTypes)){
                                if(array_key_exists("category",$FileTypes)){
                                    if(array_key_exists("Images",$FileTypes['category'])){
                                        $Images=$FileTypes['category']['Images'];
                                    }
                                }
                            }
                            $Images=".".implode(",.",$Images);
                            ?>
                            <input class="sr-only display-none" id="inputImage" type="file" name="file" accept="{{$Images}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark"  id="btnCropModelClose">Close</button>
                <button type="button" class="btn btn-outline-info" id="btnCropApply">Apply</button>
            </div>
        </div>
    </div>
</div>
<form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
@php
    $ServiceProvided = DB::table('tbl_service_provided')->where('ActiveStatus','Active')->where('DFlag',0)->get();
    $ConServiceCategories = DB::table('tbl_construction_service_category')->where('ActiveStatus','Active')->where('DFlag',0)->get();
    $AndroidAppUrl = DB::table('tbl_settings')->where('KeyName','android-app-url')->value('KeyValue');
@endphp
<div class="newsletter-popup mfp-hide modal-sm bg-img p-0 h-auto" id="plan-serv-form"
     style="background: #ffffff no-repeat center/cover">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card border-0 mt-4">
                    <div class="card-header text-center border-0" @style('background:#ffffff')><h4 class="m-0">Get a
                            FREE Building Plan</h4></div>
                    <div class="card-body">
                        <div class="row my-3">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="txtPlanCustomerName">Name <span class="required">*</span></label>
                                    <input type="text" id="txtPlanCustomerName" class="form-control" placeholder="Name">
                                    <span class="errors Customer err-sm" id="txtPlanCustomerName-err"></span>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-20">
                                <div class="form-group">
                                    <label for="txtPlanMobileNo1">Mobile Number <span class="required">*</span></label>
                                    <input type="number" id="txtPlanMobileNo1" class="form-control"
                                           placeholder="Mobile Number">
                                    <span class="errors Customer err-sm" id="txtPlanMobileNo1-err"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="txtPlanEmail">Email</label>
                                    <input type="text" id="txtPlanEmail" class="form-control" placeholder="Email" value="">
                                    <span class="errors Customer err-sm" id="txtPlanEmail-err"></span>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-20">
                                <div class="form-group">
                                    <label for="lstPlanServices">Services <span class="required">*</span></label>
                                    <select class="form-control" id="lstPlanServices">
                                        <option value="">Select a Service</option>
                                        @foreach($ServiceProvided as $items)
                                            <option value="{{$items->ServiceID}}">{{$items->ServiceName}}</option>
                                        @endforeach
                                    </select>
                                    <span class="errors Customer err-sm" id="lstPlanServices-err"></span>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-20">
                                <div class="form-group">
                                    <label for="lstPlanState">State <span class="required">*</span></label>
                                    <select class="form-control" id="lstPlanState">
                                        <option value="">Select a State</option>
                                    </select>
                                    <span class="errors Customer err-sm" id="lstPlanState-err"></span>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-20">
                                <div class="form-group">
                                    <label for="lstPlanDistricts">District <span class="required">*</span></label>
                                    <select class="form-control" id="lstPlanDistricts">
                                        <option value="">Select a District</option>
                                    </select>
                                    <span class="errors Customer err-sm" id="lstPlanDistricts-err"></span>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="txtPlanMessage">Message <span class="required">*</span></label>
                                    <textarea class="form-control" id="txtPlanMessage" cols="0" rows="0"
                                              placeholder="Message"></textarea>
                                    <span class="errors Customer err-sm" id="txtPlanMessage-err"></span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-success mr-2" id="btnPlanServSave" type="button">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button title="Close (Esc)" type="button" class="mfp-close mr-2" id="modal-close-btn">×</button>
</div>
<div class="newsletter-popup mfp-hide modal-sm bg-img p-0 h-auto" id="construction-serv-form"
     style="background: #ffffff no-repeat center/cover; max-width: 940px;">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card border-0 mt-4">
                    <div class="card-header text-center border-0" style="background: #ffffff;"><h4 class="m-0">Get a
                            Construction Service Plan</h4></div>
                    <div class="card-body">
                        <div class="row my-3">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="txtConCustomerName">Name <span class="required">*</span></label>
                                    <input type="text" id="txtConCustomerName" class="form-control" placeholder="Name">
                                    <span class="errors ConCustomer err-sm" id="txtConCustomerName-err"></span>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-20">
                                <div class="form-group">
                                    <label for="txtConMobileNo1">Mobile Number <span class="required">*</span></label>
                                    <input type="number" id="txtConMobileNo1" class="form-control"
                                           placeholder="Mobile Number">
                                    <span class="errors ConCustomer err-sm" id="txtConMobileNo1-err"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="txtConEmail">Email (Optional)</label>
                                    <input type="text" id="txtConEmail" class="form-control" placeholder="Email" value="">
                                    <span class="errors ConCustomer err-sm" id="txtConEmail-err"></span>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-20">
                                <div class="form-group">
                                    <label for="lstConServiceType" class="text-nowrap">Do you require any service related to construction(Please click here):
                                        <span class="required">*</span></label>
                                    <select class="form-control" id="lstConServiceType">
                                        <option value="">Select a Construction Type</option>
                                        @foreach($ConServiceCategories as $items)
                                            <option value="{{$items->ConServCatID}}">{{$items->ConServCatName}}</option>
                                        @endforeach
                                    </select>
                                    <span class="errors ConCustomer err-sm" id="lstConServiceType-err"></span>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-20">
                                <div class="form-group">
                                    <label for="lstConService">Construction Service (Please click here):
                                        <span class="required">*</span></label>
                                    <select class="form-control" id="lstConService">
                                        <option value="">Select a Construction Service</option>
                                    </select>
                                    <span class="errors ConCustomer err-sm" id="lstConService-err"></span>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-20">
                                <div class="form-group">
                                    <label for="lstConState">State <span class="required">*</span></label>
                                    <select class="form-control" id="lstConState">
                                        <option value="">Select a State</option>
                                    </select>
                                    <span class="errors ConCustomer err-sm" id="lstConState-err"></span>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-20">
                                <div class="form-group">
                                    <label for="lstConDistricts">District <span class="required">*</span></label>
                                    <select class="form-control" id="lstConDistricts">
                                        <option value="">Select a District</option>
                                    </select>
                                    <span class="errors ConCustomer err-sm" id="lstConDistricts-err"></span>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="txtConMessage">Message <span class="required">*</span></label>
                                    <textarea class="form-control" id="txtConMessage" cols="0" rows="0"
                                              placeholder="Message"></textarea>
                                    <span class="errors ConCustomer err-sm" id="txtConMessage-err"></span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-success mr-2" id="btnConServSave" type="button">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button title="Close (Esc)" type="button" class="mfp-close mr-2" id="modal-close-btn" style="font-weight: bolder !important;">×</button>
</div>

<a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>
<input type="hidden" id="notificationPageNo" value="1">
<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
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
<script src="{{url('/')}}/assets/js/custom.js?r={{date('YmdHis')}}"></script>
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
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js"></script>
<script src="{{url('/assets/firebase.full.js')}}"></script>


<script>
    $(document).ready(function () {
        $('.notifications').on('click', function (event) {
            event.stopPropagation();
        });
        const UpdateItemQtyCount = (count) => {
            const itemCountSpan = $('#divCartItemCount');
            const itemMblCountSpan = $('#divMblCartItemCount');
            if (count > 0) {
                itemCountSpan.text(count);
                itemMblCountSpan.text(count);
                $('#divCartAction').html(`<a href="{{ route('checkout') }}" class="btn btn-secondary btn-block" data-checkOutUrl="{{ route('checkout') }}">Quote Request</a>`);
            } else {
                itemCountSpan.text('');
                itemMblCountSpan.text('');
                $('#divCartAction').html(`<a href="{{ auth()->check() ? route('products.customer.productsList') : route('products.guest.productsList') }}" class="btn btn-dark btn-block" data-checkOutUrl="{{ route('checkout') }}">Add to Cart</a>`);
            }
        };

        const LoadCart = (data) => {
            let Parent = $('#divCart');
            Parent.html('');

            data.forEach((item) => {
                let Content = `<div class="product">
                                        <div class="product-details">
                                            <h4 class="product-title">
                                                <a href="{{url('/').'/products/quickView/html/' }}${item.ProductID}" class="btn-quickview">${item.ProductName}</a>
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
                                            <a href="{{url('/').'/products/quickView/html/' }}${item.ProductID}" class="product-image btn-quickview">
                                                <img loading="lazy" src="${item.ProductImage}" alt="product" width="80" height="80">
                                            </a>
                                            <a href="#" class="btn-remove btnRemoveCart" title="Remove Product" id="${item.ProductID}"><span>×</span></a>
                                        </figure>
                                    </div>`;
                Parent.append(Content);
            });
        };

        $(document).on('click', '.btnAddCart', function () {
            let thiss = $(this);
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
                        if (thiss.hasClass('wishlistCartBtn')) {
                            thiss.text("Added in cart");
                        }
                        if ($('#wishlistTableHtml').length) {
                            var $wishlistButton = $('#wishlistTableHtml').find('.btnAddCart#' + thiss.attr('id'));
                            thiss.removeClass('wishlistCartBtn btnAddCart btn-add-cart add-cart');
                            thiss.addClass('btn-added-cart added-in-cart');
                            $wishlistButton.attr('class', thiss.attr('class'));
                            $wishlistButton.html(thiss.html());
                        }
                        thiss.find('span').text(function (_, text) {
                            return text.trim() === 'ADD TO CART' ? 'ADDED IN CART' : text;
                        });
                        thiss.addClass('btn-added-cart added-in-cart');
                        thiss.removeClass('wishlistCartBtn btnAddCart btn-add-cart add-cart');
                        LoadCart(response.data);
                        UpdateItemQtyCount(response.data.length);
                    }
                }
            });
        });
        $('.btnBuyNow').click(function () {
            let thiss = $(this);
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
                    window.location.replace("{{ route('checkout') }}");
                    if (response.status) {
                    }
                }
            });
        });

        $(document).on('input', '.txtUpdateQty', function () {
            let Qty = $(this).val();
            if ((Qty > 0) && Number.isInteger(parseFloat(Qty))) {
                let FormData = {
                    'ProductID': $(this).attr('id'),
                    'Qty': parseInt(Qty),
                }
                $.ajax({
                    type: "post",
                    data: FormData,
                    url: "{{url('/')}}/update-cart",
                    headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')},
                    dataType: "json",
                    error: function (e, x, settings, exception) {
                        ajaxErrors(e, x, settings, exception);
                    },
                    complete: function (e, x, settings, exception) {
                    },
                    success: function (response) {
                        if (response.status) {
                            // LoadCart(response.data);
                        }
                    }
                });
            }
        });
        $(document).on('blur', '.txtUpdateQty', function () {
            let Qty = $(this).val();
            if ((Qty < 0) || !Number.isInteger(parseFloat(Qty))) {
                $(this).val(1);
            }
        });
        $(document).on('click', '.btnRemoveCart', function () {
            $(this).closest('.product').remove();
            let ProductID = $(this).attr('id');
            var deletedCartElement = $('#' + ProductID);
            if (deletedCartElement.hasClass('added-in-cart')) {
                deletedCartElement.removeClass('btn-added-cart added-in-cart').addClass('btn-add-cart btnAddCart');
                deletedCartElement.find('span').text(function (_, text) {
                    return text.trim() === 'ADDED IN CART' ? 'ADD TO CART' : text;
                });
            }
            let FormData = {
                'ProductID': ProductID,
            }
            $.ajax({
                type: "post",
                data: FormData,
                url: "{{url('/')}}/delete-cart",
                headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')},
                dataType: "json",
                error: function (e, x, settings, exception) {
                    ajaxErrors(e, x, settings, exception);
                },
                complete: function (e, x, settings, exception) {
                },
                success: function (response) {
                    if (response.status) {
                        UpdateItemQtyCount(response.data.length);
                    }
                }
            });
            let Parent = $('#divCart');
            if (Parent.find('.product').length === 0) {
                Parent.html('<span>Your Cart is Empty!</span>');
            }
        });

        function setCookie(name, value, days) {
            var expires = '';
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = '; expires=' + date.toUTCString();
            }
            document.cookie = name + '=' + value + expires + '; path=/';
        }

        function getCookie(name) {
            const cookieValue = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
            return cookieValue ? cookieValue.pop() : '';
        }

        function emptyCart() {
            $.ajax({
                url: "{{ route('empty-cart') }}",
                headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                processData: false,
                contentType: false,
                type: "POST",
                data: {},
                success: function () {
                    window.location.reload();
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }

        $('#changeCustomerAddressUl li a').on('click', function (e) {
            e.preventDefault();
            if ($(this).hasClass('addressAddHeaderBtn')) {
                return;
            }
            let selectedAddress = $('#customerSelectedAddress');
            selectedAddress.attr('data-aid', $(this).data('aid'));
            selectedAddress.attr('data-selected-postal-id', $(this).data('postal-id'));
            selectedAddress.attr('data-selected-latitude', $(this).data('latitude'));
            selectedAddress.attr('data-selected-longitude', $(this).data('longitude'));
            selectedAddress.html($(this).html());
            setCookie('selected_aid', $(this).data('aid'), 30);
            let formData = new FormData();
            formData.append('aid', $(this).data('aid'));
            $.ajax({
                url: "{{ route('setAidInSession') }}",
                headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                processData: false,
                contentType: false,
                type: "POST",
                data: formData,
                success: function (response) {
                    if (response.isChanged) {
                        emptyCart();
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        });

        function performSearch(resultsElementId, searchText) {
            var formData = new FormData();
            formData.append('AID', $('#customerSelectedAddress').attr('data-aid'));
            formData.append('SearchText', searchText);
            $.ajax({
                url: "{{ route('customerHomeSearch') }}",
                method: 'POST',
                headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
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

        $('.search-toggle-btn').on('click', function () {
            var mblSearchDiv = $("#mbl-header-search-div")
            if (mblSearchDiv.hasClass('d-none')) {
                mblSearchDiv.removeClass('d-none');
            } else {
                mblSearchDiv.addClass('d-none');
            }
        });

        $(document).on('click', function (event) {
            if (!$(event.target).closest('.header-search-wrapper').length) {
                $('#searchResults').hide();
            }
        });

        let selected_aid = getCookie('selected_aid');
        if (selected_aid !== "") {
            $('#changeCustomerAddressUl li a[data-aid="' + selected_aid + '"]').click();
        }

        function updateNotificationsDropdown(response) {
            var dropdownMenu = $('#customerNotificationUl');
            dropdownMenu.html(response);
        }

        function fetchNotifications(currentNotificationPage) {
            $.ajax({
                type: "POST",
                url: "{{ route('getNotifications') }}",
                dataType: "html",
                headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                data: {PageNo: currentNotificationPage},
                success: function (response) {
                    updateNotificationsDropdown(response);
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }

        fetchNotifications($('#notificationPageNo').val());

        getNotificationCount();

        function getNotificationCount() {
            $.ajax({
                type: "POST",
                url: "{{ route('getNotificationsCount') }}",
                dataType: "json",
                headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                cache: false,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status === true) {
                        if (response.UnReadCount === 0) {
                            if ($('.unread-badge').is(':visible')) {
                                $('.unread-badge').hide();
                            }
                        } else {
                            $('.unread-badge').show();
                        }
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }


        $('#notificationPageNo').on('change', function () {
            fetchNotifications($('#notificationPageNo').val());
        });

        $('#customerNotificationBtn').on('click', function () {
            $('#customerNotification').attr('style', 'top: 160px !important;');
        });

        $(document).on('click', '#btnLogout', async (e) => {
            e.preventDefault();
            $('#logoutForm').submit();
        });
        $(document).on('click', '#btnSaveAddress', function () {
            SaveAddress();
        });
        $(document).on('click', '.defaultAddress', function () {
            SetDefaultAddress($(this));
        });
        $(document).on('click', '.btnDeleteSAddress', function () {
            var thiss = $(this);
            DeleteAddress(thiss);
        });

        const SaveAddress = async () => {
            let { status, formData, Address } = await ValidateGetAddress();
            if (status) {
                $.ajax({
                    type:"post",
                    url:"{{ route('UpdateShippingAddress') }}",
                    data: formData,
                    headers: { 'X-CSRF-Token' : '{{ csrf_token() }}' },
                    async:true,
                    error:function(e, x, settings, exception){},
                    success:async(response)=>{
                        if(response.status === true){
                            if(!["customer-profile", "customer-register"].includes("{{ Route::currentRouteName() }}")){
                                setCookie('selected_aid', response.AID, 30);
                                window.location.reload();
                            } else {
                                let index = formData.EditID ? formData.EditID : $('#tblShippingAddress tbody tr').length + 1;

                                $('.defaultAddress').prop('checked', false);

                                let html = `<tr id="${index}" data-aid="${response.AID}">
                                <td class="text-right checkbox1 align-middle">
                                    <div class="radio radio-primary">
                                        <input id="chkSA${index}" data-aid="${response.AID}" class="defaultAddress" type="radio" name="SAddress" value="${index}" checked>
                                        <label for="chkSA${index}"></label>
                                    </div>
                                </td>
                                <td class="pointer">
                                    <b>${formData.AddressType}</b><br>
                                    <b>${response.data.Address}</b>,<br>
                                    ${formData.CityName},${formData.PostalCode}.
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-outline-danger m-2 btnDeleteSAddress" data-aid="${response.AID}"><i class="fas fa-trash-alt"></i></button>
                                </td>
                                <td class="d-none">${JSON.stringify(formData)}</td>
                            </tr>`;

                                if (formData.EditID) {
                                    $("#tblShippingAddress tbody tr").each(function () {
                                        let SNo = $(this).attr('id');
                                        if (SNo == formData.EditID) {
                                            $(this).replaceWith(html);
                                            return false;
                                        }
                                    });
                                } else {
                                    $('#tblShippingAddress tbody').append(html);
                                    if ($('#tblShippingAddress tbody tr').length === 1) {
                                        $('#tblShippingAddress tbody tr').first().find('.defaultAddress').click();
                                    }
                                }
                                toastr.success("Address added successfully!.");
                            }
                        } else {
                            toastr.warning("Error!.");
                        }
                    }
                });
                bootbox.hideAll();
            }
        };
        const DeleteAddress = async (thiss) => {
            let { status, formData, Address } = await ValidateDeleteAddress(thiss.attr('data-aid'));
            $.ajax({
                type:"post",
                url:"{{ route('DeleteShippingAddress') }}",
                data: formData,
                headers: { 'X-CSRF-Token' : '{{ csrf_token() }}' },
                async:true,
                error:function(e, x, settings, exception){},
                success:async(response)=>{
                    if(response.status === true){
                        toastr.success('Shipping address deleted');
                        $('tr[data-aid="' + thiss.attr('data-aid') + '"]').remove();
                    } else {
                        toastr.warning(response.message);
                    }
                }
            });
        };
        const SetDefaultAddress = async (thiss) => {
            let { status, formData, Address } = await ValidateDefaultAddress(thiss.attr('data-aid'));
            $.ajax({
                type:"post",
                url:"{{ route('SetAddressDefault') }}",
                data: formData,
                headers: { 'X-CSRF-Token' : '{{ csrf_token() }}' },
                async:true,
                error:function(e, x, settings, exception){},
                success:async(response)=>{
                    if(response.status === true){
                        toastr.success('Default address changed!.');
                        // $('tr[data-aid="' + thiss.attr('data-aid') + '"]').remove();
                    } else {
                        toastr.warning(response.message);
                    }
                }
            });
        };
        const ValidateDeleteAddress = async (AID) => {
            let status = true;
            let Address = "";
            var formData={};
            formData.AID=AID;
            return { status, formData, Address };
        };
        const ValidateDefaultAddress = async (AID) => {
            let status = true;
            let Address = "";
            var formData={};
            formData.AID=AID;
            return { status, formData, Address };
        };

        const ValidateGetAddress = async () => {
            $(".errors.Address").html("");
            let status = true;
            var formData={};
            formData.EditID=$("#btnSaveAddress").attr('data-edit-id');
            formData.AID=$("#btnSaveAddress").attr('data-aid');
            formData.AddressType=$('#txtADAddressType').val();
            formData.OtherAddressType= $('#txtOtherADAddressType').val();
            formData.Address=$('#txtADAddress').val();
            formData.CompleteAddress=$('#txtADAddress').val();
            formData.Latitude=$('#txtADLatitude').val();
            formData.Longitude=$('#txtADLongitude').val();
            formData.mapData=$('#mapData').val();
            formData.CityID=$('#lstADCity').val();
            formData.CityName=$('#lstADCity option:selected').text();
            formData.PostalCode=$('#txtADPostalCode').val();
            formData.PostalCodeID=$('#lstADCity option:selected').attr('data-postal-id');
            let Address ="";
            if(formData.Address==""){
                $('#txtADAddress-err').html('Address is required');status=false;
            }else if(formData.Address.length<5){
                $('#txtADAddress-err').html('The Address must be greater than 5 characters.');status=false;
            }else{
                Address+=",<br>"+formData.Address;
            }
            if(formData.CityID==""){
                $('#lstADCity-err').html('City is required');status=false;
            }else{
                Address+=",<br>"+formData.CityName;
            }

            if (formData.AddressType == "") {
                $('#txtADAddressType-err').html('Address type is required');
                status = false;
            } else if (formData.AddressType === 'Others') {
                if (formData.OtherAddressType === "") {
                    $('#txtOtherADAddressType-err').html('Please specify the address type.');
                    status = false;
                } else {
                    formData.AddressType = formData.OtherAddressType;
                }
            }

            if(formData.Latitude==="" || formData.Latitude===""){
                $('#txtADMap-err').html('Delivery location is required');status=false;
            }
            if(formData.PostalCode==""){
                $('#txtADPostalCode-err').html('Postal Code is required');status=false;
            }else{
                Address+=" - "+formData.PostalCode;
            }
            return { status, formData, Address };
        };

        const getGeneralDistricts = async (data, id) => {
            $('#' + id + ' option').remove();
            $('#' + id).append('<option value="">Select a District</option>');
            $.ajax({
                type: "post",
                url: "{{url('/')}}/get/districts",
                headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                data: data,
                dataType: "json",
                async: true,
                complete: function (e, x, settings, exception) {
                },
                success: function (response) {
                    for (let Item of response) {
                        let selected = "";
                        if (Item.DistrictID == $('#' + id).attr('data-selected')) {
                            selected = "selected";
                        }
                        $('#' + id).append('<option ' + selected + ' data-taluk=""  value="' + Item.DistrictID + '">' + Item.DistrictName + ' </option>');
                    }
                    if ($('#' + id).val() != "") {
                        $('#' + id).trigger('change');
                    }
                }
            });
        }
        const getGeneralStates = async (data, id) => {
            $('#' + id + ' option').remove();
            $('#' + id).append('<option value="">Select a State</option>');
            $.ajax({
                type: "post",
                url: "{{url('/')}}/get/states",
                headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                data: data,
                dataType: "json",
                async: true,
                complete: function (e, x, settings, exception) {
                },
                success: function (response) {
                    for (let Item of response) {
                        let selected = "";
                        if (Item.StateID == $('#' + id).attr('data-selected')) {
                            selected = "selected";
                        }
                        $('#' + id).append('<option ' + selected + '  value="' + Item.StateID + '">' + Item.StateName + ' </option>');
                    }
                    if ($('#' + id).val() != "") {
                        $('#' + id).trigger('change');
                    }
                }
            });
        }
        $('#btnPlanServSave').click(function () {
            $('.errors.Customer').text('');
            var customerName = $('#txtPlanCustomerName').val().trim();
            var customerMobile = $('#txtPlanMobileNo1').val();
            var customerEmail = $('#txtPlanEmail').val().trim();
            var customerServices = $('#lstPlanServices').val();
            var StateID = $('#lstPlanState').val();
            var DistrictID = $('#lstPlanDistricts').val();
            var customerMessage = $('#txtPlanMessage').val();
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            let status = true;
            if (!customerName) {
                status = false;
                $('#txtPlanCustomerName-err').text('Name is required!');
            }
            if (!customerMobile) {
                status = false;
                $('#txtPlanMobileNo1-err').text('Mobile Number is required!');
            }
            if (customerMobile && customerMobile.length !== 10) {
                status = false;
                $('#txtPlanMobileNo1-err').text('Invalid Mobile Number!');
            }
            if (customerEmail && !emailPattern.test(customerEmail)) {
                status = false;
                $('#txtPlanEmail-err').text('Invalid Email!');
            }
            if (!customerServices) {
                status = false;
                $('#lstPlanServices-err').text('Service is required!');
            }
            if (!StateID) {
                status = false;
                $('#lstPlanState-err').text('State is required!');
            }
            if (!DistrictID) {
                status = false;
                $('#lstPlanDistricts-err').text('District is required!');
            }
            if (!customerMessage) {
                status = false;
                $('#txtPlanMessage-err').text('Message is required!');
            }

            let formData = new FormData();

            formData.append('CustomerName', customerName);
            formData.append('CustomerMobile', customerMobile);
            formData.append('CustomerEmail', customerEmail);
            formData.append('CustomerServices', customerServices);
            formData.append('StateID', StateID);
            formData.append('DistrictID', DistrictID);
            formData.append('CustomerMessage', customerMessage);

            if (status) {
                $.ajax({
                    url: '{{ route('save-planning-services') }}',
                    method: 'POST',
                    headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        toastr.success(`${response.message}`, "", {
                            positionClass: "toast-top-right",
                            containerId: "toast-top-right",
                            showMethod: "slideDown",
                            hideMethod: "slideUp",
                            progressBar: !0
                        })
                        if (response.status) {
                            $.magnificPopup.close();
                            $('#txtPlanCustomerName, #txtPlanMobileNo1, #txtPlanEmail, #lstPlanServices, #txtPlanMessage').val('');
                            $('.errors.Customer').text('');
                        }
                    },
                    error: function () {
                        toastr.error(`Error occured while saving!`, "", {
                            positionClass: "toast-top-right",
                            containerId: "toast-top-right",
                            showMethod: "slideDown",
                            hideMethod: "slideUp",
                            progressBar: !0
                        })
                    }
                });
            }

        });

        getGeneralStates({CountryID: 'C2020-00000101'}, 'lstPlanState');
        $(document).on("change", '#lstPlanState', function () {
            getGeneralDistricts({CountryID: 'C2020-00000101', StateID: $('#lstPlanState').val()}, 'lstPlanDistricts');
        });

        $('#btnConServSave').click(function () {
            $('.errors.ConCustomer').text('');
            var customerName = $('#txtConCustomerName').val().trim();
            var customerMobile = $('#txtConMobileNo1').val();
            var customerEmail = $('#txtConEmail').val().trim();
            var ConServiceType = $('#lstConServiceType').val();
            var ConService = $('#lstConService').val();
            var StateID = $('#lstConState').val();
            var DistrictID = $('#lstConDistricts').val();
            var customerMessage = $('#txtConMessage').val();
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            let status = true;
            if (!customerName) {
                status = false;
                $('#txtConCustomerName-err').text('Name is required!');
            }
            if (!customerMobile) {
                status = false;
                $('#txtConMobileNo1-err').text('Mobile Number is required!');
            }
            if (customerMobile && customerMobile.length !== 10) {
                status = false;
                $('#txtConMobileNo1-err').text('Invalid Mobile Number!');
            }
            if (customerEmail && !emailPattern.test(customerEmail)) {
                status = false;
                $('#txtConEmail-err').text('Invalid Email!');
            }
            if (!ConServiceType) {
                status = false;
                $('#lstConServiceType-err').text('Construction Service Type is required!');
            }
            if (!ConService) {
                status = false;
                $('#lstConService-err').text('Construction Service is required!');
            }
            if (!StateID) {
                status = false;
                $('#lstConState-err').text('State is required!');
            }
            if (!DistrictID) {
                status = false;
                $('#lstConDistricts-err').text('District is required!');
            }
            if (!customerMessage) {
                status = false;
                $('#txtConMessage-err').text('Message is required!');
            }

            let formData = new FormData();

            formData.append('CustomerName', customerName);
            formData.append('CustomerMobile', customerMobile);
            formData.append('CustomerEmail', customerEmail);
            formData.append('ConServiceType', ConServiceType);
            formData.append('ConService', ConService);
            formData.append('StateID', StateID);
            formData.append('DistrictID', DistrictID);
            formData.append('CustomerMessage', customerMessage);

            if (status) {
                $.ajax({
                    url: '{{ route('save-construction-services') }}',
                    method: 'POST',
                    headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        toastr.success(`${response.message}`, "", {
                            positionClass: "toast-top-right",
                            containerId: "toast-top-right",
                            showMethod: "slideDown",
                            hideMethod: "slideUp",
                            progressBar: !0
                        })
                        if (response.status) {
                            $.magnificPopup.close();
                            $('#txtConCustomerName, #txtConMobileNo1, #txtConEmail, #lstConServiceType, #lstConService, #txtConMessage').val('');
                            $('.errors.ConCustomer').text('');
                        }
                    },
                    error: function () {
                        toastr.error(`Error occurred while saving!`, "", {
                            positionClass: "toast-top-right",
                            containerId: "toast-top-right",
                            showMethod: "slideDown",
                            hideMethod: "slideUp",
                            progressBar: !0
                        })
                    }
                });
            }
        });

        getGeneralStates({CountryID: 'C2020-00000101'}, 'lstConState');
        $(document).on("change", '#lstConState', function () {
            getGeneralDistricts({CountryID: 'C2020-00000101', StateID: $('#lstConState').val()}, 'lstConDistricts');
        });

        const getConService = async (data, id) => {
            $('#' + id + ' option').remove();
            $('#' + id).append('<option value="">Select a Construction Service</option>');
            $.ajax({
                type: "post",
                url: "{{route('getConstructionService')}}",
                headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                data: data,
                dataType: "json",
                async: true,
                complete: function (e, x, settings, exception) {
                },
                success: function (response) {
                    for (let Item of response) {
                        let selected = "";
                        if (Item.ConServID == $('#' + id).attr('data-selected')) {
                            selected = "selected";
                        }
                        $('#' + id).append('<option ' + selected + ' value="' + Item.ConServID + '">' + Item.ConServName + ' </option>');
                    }
                    if ($('#' + id).val() != "") {
                        $('#' + id).trigger('change');
                    }
                }
            });
        }

        $(document).on("change", '#lstConServiceType', function () {
            getConService({ConServCatID: $('#lstConServiceType').val()}, 'lstConService');
        });
    });
</script>

@yield('scripts')

</body>

</html>
