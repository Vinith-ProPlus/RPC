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
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/home/assets/vendor/fontawesome-free/css/all.min.css">
    {{-- <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/bootstrap.css?r={{date('YmdHis')}}"> --}}

    <style>
        .image-container {
            width: 300px;
            height: 300px;
            background-size: cover;
            background-position: center;
        }
    </style>

    <link rel="stylesheet" href="{{url('/')}}/home/assets/css/product-style.css">
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
<input type="hidden" style="display:none!important" id="CID" value="{{ $CID ?? '' }}">
<div class="page-wrapper">
    <header class="header">
        <div class="header-top">
            <div class="container">
                <div class="header-left d-md-block">
                    @if($PostalCode)
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
                            <a href="#" style="font-size: 12px;" onclick="$('#loginBtn').click();"><i
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
                            <a href="#" class="search-toggle-btn d-md-none d-lg-none" role="button"><i class="icon-search-3"></i></a>
                            <div class="header-search-wrapper" id="webSearchDiv">
                                <input class="form-control" placeholder="Search..." type="text" id="homeSearch" name="homeSearch">
                                <div id="searchResults" class="search-results"></div>
                                <button class="btn icon-magnifier p-0" title="search"></button>
                            </div>
                        </div>

                        <span class="separator d-none d-lg-block"></span>

                        <div class="sicon-box mb-0 d-none d-lg-flex align-items-center pr-3 mr-1">
                            <div class="sicon-default">
                                <i class="icon-phone-1"></i>
                            </div>
                            <div class="sicon-header">
                                <h4 class="sicon-title ls-n-25">CALL US NOW</h4>
                                <p>+91 {{$Company['Phone-Number']}}</p>
                            </div>
                        </div>

                        <span class="separator d-none d-lg-block mr-4"></span>
                        <a href="#" class="d-lg-block d-none openLoginModal" id="loginBtn">
                            <div class="header-user">
                                <div class="header-userinfo">
                                    <span>Welcome</span>
                                    <h4>Sign In / Register</h4>
                                </div>
                            </div>
                        </a>
                        <span class="separator d-block"></span>

                        <div class="dropdown cart-dropdown">
                            <a href="#" title="Cart" class="dropdown-toggle dropdown-arrow cart-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                <i class="icon-cart-thick"></i>
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
            <div class="container d-none" id="mbl-header-search-div">
                <div class="row col-12">
                    <div class="col-12">
                        <div class="py-2" >
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
                <!-- Navigation and Category Menu -->
                <div class="row align-items-center w-100">
                    <!-- Main Navigation -->
                    <div class="col-4">
                        <nav class="main-nav">
                            <ul class="menu list-unstyled sf-js-enabled sf-arrows" style="touch-action: pan-y;">
                                <li class="menu-item d-flex align-items-center">
                                    <a href="#" class="d-inline-flex align-items-center sf-with-ul">
                                        <i class="custom-icon-toggle-menu d-inline-table"></i>
                                        <span>All Categories</span>
                                    </a>
                                    <!-- Category Dropdown -->
                                    <div class="menu-depart">
                                        @foreach ($PCategories->take(5) as $row)
                                            <a href="{{ route('products.guest.subCategoryList', [ 'CID' => $row->PCID ]) }}">{{$row->PCName}}</a>
                                        @endforeach
                                        <div
                                            style="text-align: center; display: flex; justify-content: center; align-items: center;">
                                            <a href="{{ route('products.guest.categoriesList') }}" class="text-center">More</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="{{ (Route::currentRouteName() === "homepage") ? 'active' : '' }}">
                                    <a href="{{ route('homepage') }}">Home</a>
                                </li>
                                <li>
                                    <a href="{{ route('guest.products') }}">Products</a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <!-- Buttons Section -->
                    <div class="col-8 d-flex text-right justify-content-end p-0">
                        <a href="#AppLinkDiv" class="btn btn-md text-white mx-2 btnHighLight" id="btnBecVen"
                           style="background-color: #ff8800;">Become&nbsp;a&nbsp;vendor</a>
                        <a href="#" class="btn btn-md text-white mx-2 btnHighLight" id="btnPlanServ"
                           style="background-color: #03489c;white-space: nowrap;width: auto !important;">FREE&nbsp;Building&nbsp;Plan</a>
                        <a href="#" class="btn btn-md text-white mx-2 btnHighLight" id="btnConstructionServ"
                           style="background-color: #ff8800;">Construction&nbsp;Service&nbsp;Plan</a>
                    </div>
                </div>
            </div>
        </div><!-- End .header-bottom -->
    </header><!-- End .header -->

    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('products.guest.categoriesList') }}">Categories</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Sub Categories</li>
                </ol>
            </div>
        </nav>
        <div class="mb-2"></div>
        <div class="container">
            <div class="row">
        <div class="col-lg-12 main-content" id="subCategoriesDiv">
            <div class="sticky-wrapper"><nav class="toolbox sticky-header" data-sticky-options="{'mobile': true}">
                    <div class="toolbox-left">
                        <a href="#" class="sidebar-toggle"><svg data-name="Layer 3" id="Layer_3" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                <line x1="15" x2="26" y1="9" y2="9" class="cls-1"></line>
                                <line x1="6" x2="9" y1="9" y2="9" class="cls-1"></line>
                                <line x1="23" x2="26" y1="16" y2="16" class="cls-1"></line>
                                <line x1="6" x2="17" y1="16" y2="16" class="cls-1"></line>
                                <line x1="17" x2="26" y1="23" y2="23" class="cls-1"></line>
                                <line x1="6" x2="11" y1="23" y2="23" class="cls-1"></line>
                                <path d="M14.5,8.92A2.6,2.6,0,0,1,12,11.5,2.6,2.6,0,0,1,9.5,8.92a2.5,2.5,0,0,1,5,0Z" class="cls-2"></path>
                                <path d="M22.5,15.92a2.5,2.5,0,1,1-5,0,2.5,2.5,0,0,1,5,0Z" class="cls-2"></path>
                                <path d="M21,16a1,1,0,1,1-2,0,1,1,0,0,1,2,0Z" class="cls-3"></path>
                                <path d="M16.5,22.92A2.6,2.6,0,0,1,14,25.5a2.6,2.6,0,0,1-2.5-2.58,2.5,2.5,0,0,1,5,0Z" class="cls-2"></path>
                            </svg>
                            <span>Filter</span>
                        </a>

                        <div class="toolbox-item toolbox-sort">
                            <label>Sort By:</label>

                            <div class="select-custom">
                                <select name="orderby" class="form-control" id="orderBySelect">
                                    <option value="" selected="selected">Default sorting</option>
                                    <option value="new">Sort by newness</option>
                                    <option value="popularity">Sort by popularity</option>
                                    {{--                                        <option value="rating">Sort by average rating</option>--}}
                                </select>
                            </div><!-- End .select-custom -->


                        </div><!-- End .toolbox-item -->
                    </div><!-- End .toolbox-left -->

                    <div class="toolbox-right">
                        <div class="toolbox-item toolbox-show">
                            <label>Show:</label>

                            <div class="select-custom">
                                <select name="count" class="form-control" id="productCountSelect">
                                    <option value="12">12</option>
                                    <option value="24">24</option>
                                    <option value="36">36</option>
                                </select>
                            </div><!-- End .select-custom -->
                        </div><!-- End .toolbox-item -->

                        <div class="toolbox-item layout-modes">
                            <a href="#" class="layout-btn btn-grid active" title="Grid">
                                <i class="icon-mode-grid"></i>
                            </a>
                            <a href="#" class="layout-btn btn-list" title="List">
                                <i class="icon-mode-list"></i>
                            </a>
                        </div><!-- End .layout-modes -->
                    </div><!-- End .toolbox-right -->
                </nav></div>

            <div class="row no-gutters">

            </div><!-- End .row -->

            <nav class="toolbox toolbox-pagination">
                <div class="toolbox-item toolbox-show">
                    <label class="mt-0">Show:</label>

                    <div class="select-custom">
                        <select name="count" class="form-control">
                            <option value="12">12</option>
                            <option value="24">24</option>
                            <option value="36">36</option>
                        </select>
                    </div><!-- End .select-custom -->
                </div><!-- End .toolbox-item -->

                <ul class="pagination toolbox-item">
                    <li class="page-item disabled">
                        <a class="page-link page-link-btn" href="#"><i class="icon-angle-left"></i></a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href="#">1 <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><span class="page-link">...</span></li>
                    <li class="page-item">
                        <a class="page-link page-link-btn" href="#"><i class="icon-angle-right"></i></a>
                    </li>
                </ul>
            </nav>
        </div><!-- End .col-lg-9 -->
            </div>
            <div class="mb-4"></div>
        </div>
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
                            <img loading="lazy" src="{{url('/')}}/{{$Company['Logo']}}" alt="{{$Company['CompanyName']}}" width="202" height="54" class="logo-footer">

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
            <a href="{{ route('products.guest.categoriesList') }}" class="">
                <i class="icon-bars"></i>Categories
            </a>
        </div>
        <div class="sticky-info">
            <a href="#" class="" onclick="$('#loginBtn').click();">
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

<div class="newsletter-popup mfp-hide bg-img p-0 h-auto" id="guest-login-form" style="background: #f1f1f1 no-repeat center/cover">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="row justify-content-center mt-3">
                    <div class="col-md-4">
                        <img loading="lazy" src="{{url('/')}}/{{$Company['Logo']}}" alt="{{$Company['CompanyName']}}" class="logo-newsletter" width="50" height="50">
                        <span class="ml-3 font-weight-bold text-dark">{{$Company['CompanyName']}}</span>
                    </div>
                </div>
                <div class="row justify-content-center my-3">
                    <div class="">
                        <h2>Sign In</h2>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6 justify-content-center">
                        <a href="{{url('/')}}/social/auth/google" class="d-flex justify-content-center align-items-center text-center" onclick="localStorage.setItem('rpc_guest_redirect_url', window.location.href);">
                        <img src="{{ url('/assets/images/logo/google_sign_in_logo.png') }}" style="width: 60%;" class="img-fluid" alt="Google SignIn">
                    </a>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <h5 class="text-center my-3">or</h5>
                    </div>
                </div>
                <div class="row justify-content-center mb-3">
                    <div class="col-md-8 newsletter-popup-content" id="divMobileNumber">
                        <div class="input-group">
                            <input type="text" class="form-control" id="txtUserMobileNumber" placeholder="Enter your mobile number" oninput="this.value = this.value.replace(/[^0-9]/g, '');" inputmode="numeric" required>
                            <input type="button" class="btn btn-warning" value="Submit" id="btnSubmitMobileNumber">
                        </div>
                        <div class="errors err-sm text-center" id="txtUserMobileNumber-err"></div>
                    </div>
                    <div class="col-md-8 newsletter-popup-content d-none" id="divOtpInput">
                        <div class="input-group">
                            <input type="text" class="form-control" id="txtUserOtp" placeholder="Enter OTP" required="">
                            <input type="button" class="btn btn-warning" value="Verify" id="btnVerifyOtp">
                        </div>
                        <div class="errors err-sm text-center" id="txtUserOtp-err"></div>
                        <div class="text-center mt-2">
                            <button type="button" class="btn btn-link" id="btnResendOtp" onclick="$('#btnSubmitMobileNumber').click();">Resend OTP</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button title="Close (Esc)" type="button" class="mfp-close" id="modal-close-btn">×</button>
</div>

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

<script src="{{url('/')}}/home/assets/js/jquery.min.js"></script>
<script src="{{url('/')}}/home/assets/js/bootstrap.bundle.min.js"></script>
<script src="{{url('/')}}/home/assets/js/optional/isotope.pkgd.min.js"></script>
<script src="{{url('/')}}/home/assets/js/plugins.min.js"></script>
<script src="{{url('/')}}/home/assets/js/jquery.appear.min.js"></script>
<script src="{{url('/')}}/home/assets/js/jquery.plugin.min.js"></script>
<script src="{{url('/')}}/home/assets/js/main.js"></script>
<script>
    $(document).ready(function() {
        $('.redirectLogin').on('click', function(){
            $('#loginBtn').click();
        });
    });
</script>

<script>
    $(document).ready(function() {
        var sub_category_id = "";
        var CID = $('#CID').val();
        var current_page_no = 1;
        var viewType = 'Grid';
        const LoadSubCategories = async () => {
            var formData = new FormData();

            formData.append('PostalID', $('#customerSelectedAddress').attr('data-selected-postal-id'));
            formData.append('AID', $('#customerSelectedAddress').attr('data-aid'));
            formData.append('CID', CID);
            formData.append('productCount', $('#productCountSelect').val());
            formData.append('orderBy', $('#orderBySelect').val());
            formData.append('viewType', viewType);
            formData.append('pageNo', current_page_no);
            $.ajax({
                url: '{{ route('products.guest.subCategoriesListHtml') }}',
                headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#subCategoriesDiv').html(response);
                    $('#productCountSelect').change(function () {
                        var selectedValue = $(this).val();
                        $('#productCountSelect2').val(selectedValue);
                    });
                    $('#productCountSelect2').change(function () {
                        var selectedValue = $(this).val();
                        $('#productCountSelect').val(selectedValue);
                    });
                    $('#productCountSelect').change(function () {
                        LoadSubCategories();
                    });
                    $('#productCountSelect2').change(function () {
                        LoadSubCategories();
                    });
                    $('#orderBySelect').change(function () {
                        LoadSubCategories();
                    });
                    $('.changePage').click(function () {
                        current_page_no = $(this).attr('data-page-no');
                        LoadSubCategories();
                    });
                    $('.prevPage').click(function () {
                        current_page_no = parseInt(current_page_no) - 1;
                        LoadSubCategories();
                    });
                    $('.nextPage').click(function () {
                        current_page_no = parseInt(current_page_no) + 1;
                        LoadSubCategories();
                    });
                },
                error: function (xhr, status, error) {
                    if (xhr.status === 419) {
                        console.error('CSRF token mismatch. Reloading page...');
                        window.location.reload();
                    } else {
                        console.log('An error occurred: ' + xhr.responseText);
                    }
                }
            });
        }

        LoadSubCategories();

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

        $('#btnSubmitMobileNumber').click(function() {
            var mobileNumber = $('#txtUserMobileNumber').val();
            if (mobileNumber === '') {
                $('#txtUserMobileNumber-err').text('Please enter your mobile number.');
                return;
            }
            let formData=new FormData();
            formData.append('MobileNumber', mobileNumber);
            formData.append('LoginType', 'Customer');
            $.ajax({
                url: '{{ route('web.mobile.login') }}',
                method: 'POST',
                headers: { 'X-CSRF-Token' : '{{ csrf_token() }}' },
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    if (response.status) {
                        $('#divMobileNumber').addClass('d-none');
                        $('#divOtpInput').removeClass('d-none');
                        $('#btnResendOtp').removeClass('d-none');
                        $('#txtUserMobileNumber-err').text('');
                        $('#txtUserOtp').val('');
                        $('#txtUserOtp-err').text('');
                        alert("OTP sent successfully!");
                    } else {
                        $('#txtUserMobileNumber-err').text(response.message)
                    }
                },
                error: function() {
                    $('#txtUserMobileNumber-err').text('Error sending OTP. Please try again.');
                }
            });
        });

        $('#btnVerifyOtp').click(function() {
            var mobileNumber = $('#txtUserMobileNumber').val();
            var otp = $('#txtUserOtp').val();
            if (otp === '') {
                $('#txtUserOtp-err').text('Please enter the OTP.');
                return;
            }
            let formData=new FormData();
            formData.append('MobileNumber', mobileNumber);
            formData.append('LoginType', 'Customer');
            formData.append('OTP', otp);
            $.ajax({
                url: '{{ route('web.mobile.login') }}',
                method: 'POST',
                headers: { 'X-CSRF-Token' : '{{ csrf_token() }}' },
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    if (response.status) {
                        $('#txtUserOtp-err').text('');
                        localStorage.setItem('rpc_guest_redirect_url', window.location.href);
                        window.location.href = '{{ url('/') }}';
                    } else {
                        $('#txtUserOtp-err').text(response.message);
                    }
                },
                error: function() {
                    $('#txtUserOtp-err').text('Error verifying OTP. Please try again.');
                }
            });
        });

        const getDistricts = async (data, id) => {
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
        const getStates = async (data, id) => {
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

        getStates({CountryID: 'C2020-00000101'}, 'lstPlanState');
        $(document).on("change", '#lstPlanState', function () {
            getDistricts({CountryID: 'C2020-00000101', StateID: $('#lstPlanState').val()}, 'lstPlanDistricts');
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

        getStates({CountryID: 'C2020-00000101'}, 'lstConState');
        $(document).on("change", '#lstConState', function () {
            getDistricts({CountryID: 'C2020-00000101', StateID: $('#lstConState').val()}, 'lstConDistricts');
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
</body>

</html>
