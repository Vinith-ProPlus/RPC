<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{$Company['CompanyName']}}</title>

    <meta name="keywords" content="HTML5 Template"/>
    <meta name="description" content="{{$Company['CompanyName']}}">
    <meta name="author" content="SW-THEMES">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{url('/')}}/{{$Company['Logo']}}">
    <link rel="preload" href="{{url('/')}}/home/assets/vendor/fontawesome-free/webfonts/fa-regular-400.woff2" as="font"
          type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="{{url('/')}}/home/assets/vendor/fontawesome-free/webfonts/fa-solid-900.woff2" as="font"
          type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="{{url('/')}}/home/assets/vendor/fontawesome-free/webfonts/fa-brands-400.woff2" as="font"
          type="font/woff2" crossorigin="anonymous">
    <link rel="stylesheet" href="{{url('/')}}/home/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{url('/')}}/home/assets/css/slider.css">
    <link rel="stylesheet" href="{{url('/')}}/home/assets/css/demo42.min.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/home/assets/vendor/fontawesome-free/css/all.min.css">

    {{-- <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/bootstrap.css?r={{date('YmdHis')}}"> --}}


    <link rel="stylesheet" href="{{url('/')}}/home/assets/css/product-style.css">
    <script>
        WebFontConfig = {
            google: {families: ['Open+Sans:400,600', 'Poppins:400,500,600,700']}
        };
        (function (d) {
            var wf = d.createElement('script'), s = d.scripts[0];
            wf.src = '{{url('/')}}/home/assets/js/webfont.js';
            wf.async = true;
            s.parentNode.insertBefore(wf, s);
        })(document);
    </script>

</head>

<body>
<input type="hidden" style="display:none!important" id="txtRootUrl" value="{{url('/')}}/">
<div class="page-wrapper">
    {{--    <div class="top-notice bg-dark text-white pt-3">--}}
{{--        <div class="container text-center d-flex align-items-center justify-content-center flex-wrap">--}}
{{--            <h4 class="text-uppercase font-weight-bold mr-2">Deal of the week</h4>--}}
{{--            <h6>- 15% OFF in All Construction Materials, -</h6>--}}

{{--            <a href="{{ route('guest.products') }}" class="ml-2">Shop Now</a>--}}
{{--        </div><!-- End .container -->--}}
{{--    </div><!-- End .top-notice -->--}}

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
                        <div class=" sicon-default">
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
                        <li class="{{ (Route::currentRouteName() == "homepage") ? 'active' : '' }}">
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

        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Products</li>
                </ol>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-lg-9 main-content" id="productDetailsDiv">
                    <div class="sticky-wrapper">
                        <nav class="toolbox sticky-header" data-sticky-options="{'mobile': true}">
                            <div class="toolbox-left">
                                <a href="#" class="sidebar-toggle">
                                    <svg data-name="Layer 3" id="Layer_3" viewBox="0 0 32 32"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <line x1="15" x2="26" y1="9" y2="9" class="cls-1"></line>
                                        <line x1="6" x2="9" y1="9" y2="9" class="cls-1"></line>
                                        <line x1="23" x2="26" y1="16" y2="16" class="cls-1"></line>
                                        <line x1="6" x2="17" y1="16" y2="16" class="cls-1"></line>
                                        <line x1="17" x2="26" y1="23" y2="23" class="cls-1"></line>
                                        <line x1="6" x2="11" y1="23" y2="23" class="cls-1"></line>
                                        <path
                                            d="M14.5,8.92A2.6,2.6,0,0,1,12,11.5,2.6,2.6,0,0,1,9.5,8.92a2.5,2.5,0,0,1,5,0Z"
                                            class="cls-2"></path>
                                        <path d="M22.5,15.92a2.5,2.5,0,1,1-5,0,2.5,2.5,0,0,1,5,0Z" class="cls-2"></path>
                                        <path d="M21,16a1,1,0,1,1-2,0,1,1,0,0,1,2,0Z" class="cls-3"></path>
                                        <path
                                            d="M16.5,22.92A2.6,2.6,0,0,1,14,25.5a2.6,2.6,0,0,1-2.5-2.58,2.5,2.5,0,0,1,5,0Z"
                                            class="cls-2"></path>
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
{{--                                    <a href="#" class="layout-btn btn-list" title="List">--}}
{{--                                        <i class="icon-mode-list"></i>--}}
{{--                                    </a>--}}
                                </div><!-- End .layout-modes -->
                            </div><!-- End .toolbox-right -->
                        </nav>
                    </div>

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

                <div class="sidebar-overlay"></div>
                <aside class="sidebar-shop col-lg-3 order-lg-first mobile-sidebar">
                    <div class="pin-wrapper" style="height: 904.35px;">
                        <div class="sidebar-wrapper" style="border-bottom: 0px rgb(119, 119, 119); width: 335px;">
                            <div class="widget">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-body-1" role="button" aria-expanded="true"
                                       aria-controls="widget-body-1">Categories</a>
                                </h3>

                                <div class="collapse show" id="widget-body-1">
                                    <div class="widget-body" id="categories-widget" style="height: 700px; overflow-y: auto;">
                                        <ul class="cat-list">
                                        </ul>
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->
                        </div>
                    </div><!-- End .sidebar-wrapper -->
                </aside><!-- End .col-lg-3 -->
            </div><!-- End .row -->

            <div class="mb-4"></div>
        </div>
    </main>
    <!-- End .main -->

    <footer class="footer bg-dark position-relative">
        <div class="footer-middle">
            <div class="container position-static">
                <div class="row">
                    <div class="col-lg-2 col-sm-6 pb-2 pb-sm-0 d-flex align-items-center">
                        <div class="widget m-b-3">
                            <img loading="lazy" src="{{url('/')}}/{{$Company['Logo']}}" alt="{{$Company['CompanyName']}}" width="202" height="54"
                                 class="logo-footer">

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
                                    <span class="contact-info-label">Email:</span> <a href="#"><span
                                            class="__cf_email__"
                                            >{{$Company['E-Mail']}}</span></a>
                                </li>
                                <li>
                                    <span class="contact-info-label">Working Days/Hours:</span>
                                    Mon - Sun / 9:00 AM - 8:00 PM
                                </li>
                            </ul>
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
                        </div><!-- End .widget -->
                    </div><!-- End .col-lg-3 -->

                    <div class="col-lg-3 col-sm-6 pb-2 pb-sm-0">
                        <div class="widget">
                            <h4 class="widget-title pb-1">Customer Service</h4>

                            <ul class="links">
                                @foreach(DB::table('tbl_page_content')->select('Slug', 'PageName')->get() as $Policy)
                                    <li>
                                        <a href="{{ route('policies', $Policy->Slug) }}">{{ $Policy->PageName ?? '' }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div><!-- End .widget -->
                    </div><!-- End .col-lg-3 -->

                    <div class="col-lg-4 col-sm-6 pb-0">
                        <div class="widget widget-newsletter mb-1 mb-sm-3">
                            <h4 class="widget-title">Subscribe Newsletter</h4>

                            <p class="mb-2">Get all the latest information on events, sales and offers.
                                Sign up for newsletter:</p>
                            <form action="#" class="d-flex mb-0 w-100">
                                <input type="email" class="form-control mb-0" placeholder="Email address"
                                       required="">

                                <input type="submit" class="btn shadow-none" value="OK">
                            </form>
                        </div><!-- End .widget -->
                    </div><!-- End .col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .footer-middle -->

        <div class="container">
            <div class="footer-bottom d-sm-flex align-items-center bg-dark">
                <div class="footer-left">
                    <span class="footer-copyright">{{$Company['CompanyName']}}. © 2024. All Rights Reserved</span>
                </div>

                <div class="footer-right ml-auto mt-1 mt-sm-0">
                    <div class="payment-icons">
                            <span class="payment-icon visa"
                                  style="background-image: url({{url('/')}}/home/assets/images/payments/payment-visa.svg)"></span>
                        <span class="payment-icon paypal"
                              style="background-image: url({{url('/')}}/home/assets/images/payments/payment-paypal.svg)"></span>
                        <span class="payment-icon stripe"
                              style="background-image: url({{url('/')}}/home/assets/images/payments/payment-stripe.png)"></span>
                        <span class="payment-icon verisign"
                              style="background-image:  url({{url('/')}}/home/assets/images/payments/payment-verisign.svg)"></span>
                    </div>
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
            <a href="#" onclick="$('#loginBtn').click();">
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
                        <a href="{{url('/')}}/social/auth/google"><button type="button" class="btn btn-info btn-block rounded">Google</button></a>
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
<a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>

<script src="{{url('/')}}/home/assets/js/jquery.min.js"></script>
<script src="{{url('/')}}/home/assets/js/bootstrap.bundle.min.js"></script>
<script src="{{url('/')}}/home/assets/js/optional/isotope.pkgd.min.js"></script>
<script src="{{url('/')}}/home/assets/js/plugins.min.js"></script>
<script src="{{url('/')}}/home/assets/js/jquery.appear.min.js"></script>
<script src="{{url('/')}}/home/assets/js/jquery.plugin.min.js"></script>
<script src="{{url('/')}}/home/assets/js/main.js"></script>
<script>
    $(document).ready(function () {
        $('.redirectLogin').on('click', function () {
            $('.openLoginModal').click();
        });
    });

    $(document).ready(function () {
        var sub_category_id = "";
        var current_page_no = 1;
        var viewType = 'Grid';
        const LoadCategories = async () => {
            var formData = new FormData();
            formData.append('PostalID', $('#customerSelectedAddress').attr('data-selected-postal-id'));
            formData.append('AID', $('#customerSelectedAddress').attr('data-aid'));
            $.ajax({
                type: "post",
                url: "{{url('/')}}/guest/products/get/categories/html",
                headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#categories-widget').html(response);
                    $(".sub-category").on('click', function (e) {
                        e.preventDefault();
                        sub_category_id = $(this).data('sub-category-id');
                        current_page_no = 1;
                        LoadProducts();
                    });
                }
            });
        }

        const LoadProducts = async () => {
            var formData = new FormData();

            formData.append('PostalID', $('#customerSelectedAddress').attr('data-selected-postal-id'));
            formData.append('AID', $('#customerSelectedAddress').attr('data-aid'));
            formData.append('SubCategoryID', sub_category_id);
            formData.append('productCount', $('#productCountSelect').val());
            formData.append('orderBy', $('#orderBySelect').val());
            formData.append('viewType', viewType);
            formData.append('pageNo', current_page_no);

            $.ajax({
                url: '{{ route('guest.products.productsHtml') }}',
                headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#productDetailsDiv').html(response);
                    $('#productCountSelect').change(function () {
                        var selectedValue = $(this).val();
                        $('#productCountSelect2').val(selectedValue);
                    });
                    $('#productCountSelect2').change(function () {
                        var selectedValue = $(this).val();
                        $('#productCountSelect').val(selectedValue);
                    });
                    $('#productCountSelect').change(function () {
                        LoadProducts();
                    });
                    $('#productCountSelect2').change(function () {
                        LoadProducts();
                    });
                    $('#orderBySelect').change(function () {
                        LoadProducts();
                    });
                    $('.changePage').click(function () {
                        current_page_no = $(this).attr('data-page-no');
                        LoadProducts();
                    });
                    $('.changeView').click(function () {
                        viewType = $(this).attr('title');
                        LoadProducts();
                    });
                    $('.prevPage').click(function () {
                        current_page_no = parseInt(current_page_no) - 1;
                        LoadProducts();
                    });
                    $('.nextPage').click(function () {
                        current_page_no = parseInt(current_page_no) + 1;
                        LoadProducts();
                    });
                },
                error: function (xhr, status, error) {
                    if (xhr.status === 419) {
                        window.location.replace("{{ route('homepage') }}");
                    } else {
                        console.log('An error occurred: ' + xhr.responseText);
                    }
                }
            });
        }

        LoadCategories();
        LoadProducts();

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
    });
</script>
</body>
</html>

