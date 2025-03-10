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

    {{-- updated --}}
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/toastr.css">

    {{-- <link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/css/bootstrap.css?r={{date('YmdHis')}}"> --}}


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
    <style>
        #homeBannerList {
            display: none !important;
        }

        a.btn.text-right.text-white:hover {
            background-color: #0f3b70 !important;
        }
    </style>

</head>

<body>
<input type="hidden" style="display:none!important" id="txtRootUrl" value="{{url('/')}}/">
<div class="page-wrapper">
    <header class="header">
        <div class="header-top">
            <div class="container">
                <div class="header-left d-md-block">
                    @if($PostalCode)
                        <div class="align-middle" style="display: inline-block;">
                            <div class="info-box info-box-icon-left justify-content-start">
                                <i class="icon-location" style="color:#ff6840;"></i>
                                <div class="align-middle"
                                     style="display: inline-block; height: 20px; vertical-align: middle !important;">
                                    <h6 class="d-flex font-weight-bold text-dark"
                                        style="line-height: 18px; position: relative;">
                                        <span
                                            class="delivery-location-sm-hide">Delivery Location - &nbsp;</span> {{$PostalCode}}
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
                        <a href="{{$Company['facebook']}}" class="social-icon social-facebook icon-facebook"
                           target="_blank" title="facebook"></a>
                        <a href="{{$Company['instagram']}}" class="social-icon social-instagram icon-instagram"
                           target="_blank" title="instagram"></a>
                        <a href="{{$Company['youtube']}}" class="social-icon social-youtube fab fa-youtube"
                           target="_blank" title="YouTube"></a>
                    </div><!-- End .social-icons -->
                </div><!-- End .header-right -->
            </div><!-- End .container -->
        </div><!-- End .header-top -->

        <div class="header-middle sticky-header" data-sticky-options="{'mobile': true}">
            <div class="container">
                <div class="header-left col-lg-2 w-auto pl-0">
                    <a href="{{url('/')}}" class="logo">
                        <img loading="lazy" src="{{url('/')}}/{{$Company['Logo']}}" width="50" height="50"
                             alt="{{$Company['CompanyName']}}">
                    </a>
                    <span class="ml-3 font-weight-bold">{{$Company['CompanyName']}}</span>
                </div><!-- End .header-left -->

                <div class="header-right w-lg-max">
                    <div
                        class="header-icon header-search header-search-inline header-search-category w-lg-max text-right mb-0">
                        <a href="#" class="search-toggle-btn d-md-none d-lg-none" role="button"><i
                                class="icon-search-3"></i></a>
                        <div class="header-search-wrapper" id="webSearchDiv">
                            <input class="form-control" placeholder="Search..." type="text" id="homeSearch"
                                   name="homeSearch">
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
                    <div class="dropdown mobileVendorDropdown ml-0 pr-5">
                        <a href="#" role="button" id="threeDotsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right hide" aria-labelledby="threeDotsDropdown" x-placement="bottom-end"
                             style="position: absolute; transform: translate3d(-76px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                            <a class="dropdown-item border-bottom" href="#AppLinkDiv" style="font-size: 1.4rem;" id="btnBecVen">Become&nbsp;a&nbsp;vendor</a>
                            <a class="dropdown-item border-bottom btnPlanServ" href="#" style="font-size: 1.4rem;">FREE&nbsp;Building&nbsp;Plan</a>
                            <a class="dropdown-item btnConstructionServ" href="#" style="font-size: 1.4rem;">Construction&nbsp;Service&nbsp;Plan</a>
                        </div>
                    </div>
                    <div class="dropdown cart-dropdown">
                        <a href="#" title="Cart" class="dropdown-toggle dropdown-arrow cart-toggle" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                            <i class="icon-cart-thick"></i>
                        </a>

                        <div class="cart-overlay"></div>

                        <div class="dropdown-menu mobile-cart">
                            <a href="#" title="Close (Esc)" class="btn-close">×</a>

                            <div class="dropdownmenu-wrapper custom-scrollbar">
                                <div class="dropdown-cart-header">Shopping Cart</div>
                                <span>Your Cart is Empty!</span>
                                <div class="dropdown-cart-action">
                                    <a href="{{ route('products.guest.productsList') }}" class="btn btn-dark btn-block">Add
                                        to Cart</a>
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
                    <div class="py-2">
                        <div class="input-group" style="width: 100% !important;">
                            <input class="form-control" placeholder="Search..." type="text" id="mblHomeSearch"
                                   name="homeSearch">
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
                        <a href="#" class="btn btn-md text-white mx-2 btnHighLight btnPlanServ"
                           style="background-color: #03489c;white-space: nowrap;width: auto !important;">FREE&nbsp;Building&nbsp;Plan</a>
                        <a href="#" class="btn btn-md text-white mx-2 btnHighLight btnConstructionServ"
                           style="background-color: #ff8800;">Construction&nbsp;Service&nbsp;Plan</a>
                    </div>
                </div>
            </div>
        </div><!-- End .header-bottom -->
    </header><!-- End .header -->

        <main class="main">
        <section class="intro-section">
                <div id="bannerCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($Banners as $Banner)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <img class="d-block w-100" src="{{ $Banner->BannerImage }}" alt="Banner {{ $loop->iteration }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

        <section class="building-modeling">
            <div class="container">
                <div class="row my-5">
                    @foreach($steppers as $index => $stepper)
                        <div class="col-sm-4">
                            <div class="row d-flex justify-content-center align-items-center m-4">
                                <div class="circle">{{ $index + 1 }}</div>
                                <div class="step">{{ $stepper->StepperTitle }}</div>
                            </div>
                            <img loading="lazy" src="{{ $stepper->StepperImage }}" alt="Step {{ $index + 1 }}"
                                 height="176px" width="418px">
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="category-section container">
            <div class="d-lg-flex align-items-center appear-animate" data-animation-name="fadeInLeftShorter">
                <h2 class="title title-underline divider">Shop Categories</h2>
                <a href="{{ route('products.guest.categoriesList') }}" class="sicon-title">VIEW CATEGORIES<i
                        class="fas fa-arrow-right"></i></a>
            </div>
            <div class="owl-carousel owl-theme appear-animate" data-owl-options="{
                    'loop': false,
                    'dots': false,
                    'nav': true,
                    'responsive': {
                        '0': {
                            'items': 2
                        },
                        '576': {
                            'items': 3
                        },
                        '991': {
                            'items': 4
                        }
                    }
                }">
                @foreach ($PCategories->take(4) as $category)
                    <div class="product-category">
                        <a href="{{ route('products.guest.subCategoryList', ['CID' => $category->PCID]) }}">
                            <figure>
                                <img loading="lazy"
                                     src="{{ file_exists($category->ThumbnailImg)? url('/'.$category->ThumbnailImg):$category->PCImage }}"
                                     alt="{{ $category->PCName }}" width="25" height="25">
                            </figure>
                        </a>
                        <div class="category-content">
                            <h3 class="category-title">{{ $category->PCName }}</h3>
                            <ul class="sub-categories">
                                @foreach ($category->PSCData->take(4) as $subCategory)
                                    <li>
                                        <a href="{{ route('products.guest.productsList', ['SCID' => $subCategory->PSCID]) }}">{{ $subCategory->PSCName }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        <section class="product-section1" style="background-color: #f4f4f4;">
            <div class="container">
                <h2 class="title title-underline pb-1 appear-animate" data-animation-name="fadeInLeftShorter">Hot
                    Deals</h2>
                <div class="owl-carousel owl-theme appear-animate" data-owl-options="{
                    'loop': false,
                    'dots': false,
                    'nav': true,
                    'margin': 20,
                    'responsive': {
                        '0': {
                            'items': 2
                        },
                        '576': {
                            'items': 4
                        },
                        '991': {
                            'items': 6
                        }
                    }
                }">
                    @foreach ($HotProducts->shuffle()->take(6) as $hotProduct)
                        <div class="product-default inner-quickview inner-icon">
                            <figure>
                                <a href="{{ route('guest.product.view', $hotProduct->ProductID) }}">
                                    <img loading="lazy"
                                         src="{{ file_exists($hotProduct->ThumbnailImg)? url('/'.$hotProduct->ThumbnailImg):$hotProduct->ProductImage }}"
                                         width="300" height="300" alt="product">
                                </a>
                                <div class="label-group">
                                    {{-- <span class="product-label label-sale">-13%</span> --}}
                                </div>
                                <div class="btn-icon-group">
                                    <a href="#" class="btn-icon redirectLogin product-type-simple"><i
                                            class="icon-shopping-cart"></i></a>
                                </div>
                                <a href="{{ route('guest.products.quickView', $hotProduct->ProductID) }}"
                                   class="btn-quickview" title="Quick View">Quick View</a>
                            </figure>
                            <div class="product-details">
                                <div class="category-wrap">
                                    <div class="category-list">
                                        <a href="{{ route('products.guest.productsList', ['SCID' => $hotProduct->PSCID]) }}">{{ $hotProduct->PSCName }}</a>
                                    </div>
                                    {{--                                    <a href="#" class="btn-icon-wish" title="wishlist"><i class="icon-heart"></i></a>--}}
                                </div>
                                <h3 class="product-title">
                                    <a href="{{ route('guest.product.view', $hotProduct->ProductID) }}">{{ $hotProduct->ProductName }}</a>
                                </h3>
                                <div class="ratings-container">
                                    <div class="product-ratings">
                                        <span class="ratings" style="width:100%"></span>
                                        <span class="tooltiptext tooltip-top"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="call-section appear-animate" style="background-color: #212529;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <h4 class="text-white text-uppercase">looking for help to find construction materials?</h4>
                        <h2 class="text-white">Best raw materials providers</h2>
                        <h3>Call Us or Drop Us a Message Through Our Contact Form</h3>
                    </div>
                    <div class="col-lg-5 call-action">
                        <div class="d-inline-flex align-items-center text-left divider">
                            <i class="icon-phone-1 text-white mr-2"></i>
                            <h6 class="pt-1 line-height-1 text-uppercase text-white">
                                Call us now
                                <a href="tel:{{ $Company['Phone-Number'] ?? ($Company['Mobile-Number'] ?? '') }}"
                                   class="d-block text-white ls-10 pt-2">+91 {{ $Company['Phone-Number'] ?? ($Company['Mobile-Number'] ?? '') }}</a>
                            </h6>
                        </div>
                        <a href="sms:91{{ $Company['Phone-Number'] ?? ($Company['Mobile-Number'] ?? '') }}"
                           class="btn btn-borders btn-rounded btn-outline-white ls-25">Send Us a
                            Message</a>
                    </div>
                </div>
            </div>
            <svg class="custom-svg-3 appear-animate" data-animation-name="fadeIn" version="1.1"
                 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 viewBox="0 0 649 578">
                <path fill="#0f43b0"
                      d="M-225.5,154.7l358.45,456.96c7.71,9.83,21.92,11.54,31.75,3.84l456.96-358.45c9.83-7.71,11.54-21.92,3.84-31.75
                        L267.05-231.66c-7.71-9.83-21.92-11.54-31.75-3.84l-456.96,358.45C-231.49,130.66-233.2,144.87-225.5,154.7z">
                </path>
                <path class="appear-animate appear-animate-svg" data-animation-name="customLineAnim"
                      data-animation-delay="300" data-animation-duration="5000" fill="none" stroke="#FFF"
                      stroke-width="1.5" stroke-miterlimit="10"
                      d="M416-21l202.27,292.91c5.42,7.85,3.63,18.59-4.05,24.25L198,603"></path>
            </svg>
        </section>
        <section class="product-section1 recently">
            <div class="container">
                <h2 class="title title-underline pb-1 appear-animate" data-animation-name="fadeInLeftShorter">Recently
                    Arrived</h2>
                <div class="owl-carousel owl-theme appear-animate"
                     data-owl-options="{'loop': false,'dots': false,'nav': true,'margin': 20,'responsive': {'0': {'items': 2},'576': {'items': 4},'991': {'items': 6 }}}">
                    @foreach ($RecentProducts->shuffle()->take(6) as $recentProduct)
                        <div class="product-default inner-quickview inner-icon">
                            <figure>
                                <a href="{{ route('guest.product.view', $recentProduct->ProductID) }}">
                                    <img loading="lazy"
                                         src="{{ file_exists($recentProduct->ThumbnailImg)? url('/'.$recentProduct->ThumbnailImg):$recentProduct->ProductImage }}"
                                         width="300" height="300" alt="product">
                                </a>
                                <div class="label-group">
                                    {{-- <span class="product-label label-sale">-13%</span> --}}
                                </div>
                                <div class="btn-icon-group">
                                    <a href="#" class="btn-icon redirectLogin product-type-simple"><i
                                            class="icon-shopping-cart"></i></a>
                                </div>
                                <a href="{{ route('guest.products.quickView', $recentProduct->ProductID) }}"
                                   class="btn-quickview" title="Quick View">Quick View</a>
                            </figure>
                            <div class="product-details">
                                <div class="category-wrap">
                                    <div class="category-list">
                                        <a href="{{ route('products.guest.productsList', ['SCID' => $recentProduct->PSCID]) }}">{{ $recentProduct->PSCName }}</a>
                                    </div>
                                    {{--                                <a href="#" class="btn-icon-wish" title="wishlist"><i class="icon-heart"></i></a>--}}
                                </div>
                                <h3 class="product-title">
                                    <a href="{{ route('guest.product.view', $recentProduct->ProductID) }}">{{ $recentProduct->ProductName }}</a>
                                </h3>
                                <div class="ratings-container">
                                    <div class="product-ratings">
                                        <span class="ratings" style="width:100%"></span>
                                        <span class="tooltiptext tooltip-top"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="subcats-section container">
            <div class="row">
                <div class="col-md-4 part-item appear-animate" data-animation-name="fadeInLeftShorter">
                    <div class="col-md-12">
                        <h4>Popular Categories:</h4>
                        <br>
                        <ul class="list-unstyled mb-0">
                            @foreach ($PCategories->take(4) as $category)
                                <li>
                                    <a href="{{ route('products.guest.subCategoryList', ['CID' => $category->PCID]) }}">{{ $category->PCName }}</a>
                                </li>
                            @endforeach
                            <li><a class="show-action" href="{{ route('products.guest.categoriesList') }}">Show All</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 part-item appear-animate" data-animation-name="fadeInLeftShorter"
                     data-animation-delay="200">
                    <div class="col-md-12">
                        <h3>Popular Sub-Categories:</h3>
                        <br>
                        <ul class="list-unstyled mb-0">
                            @foreach ($PCategories->shuffle()->take(4) as $category)
                                <li>
                                    <a href="{{ route('products.guest.subCategoryList', ['CID' => $category->PCID]) }}">{{ $category->PCName }}</a>
                                </li>
                            @endforeach
                            <li><a class="show-action" href="{{ route('products.guest.categoriesList') }}">Show All</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 part-item appear-animate" data-animation-name="fadeInLeftShorter"
                     data-animation-delay="400">
                    <div class="col-md-12">
                        <h3>Popular Products:</h3>
                        <br>
                        <ul class="list-unstyled mb-0">
                            @foreach ($PCategories->shuffle()->take(4) as $category)
                                <li>
                                    <a href="{{ route('products.guest.subCategoryList', ['CID' => $category->PCID]) }}">{{ $category->PCName }}</a>
                                </li>
                            @endforeach
                            <li><a class="show-action" href="{{ route('products.guest.categoriesList') }}">Show All</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
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
                        <button type="button" class="sent-me-link-btn btn">Send me the link</button>
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
                            <img loading="lazy" src="{{url('/')}}/{{$Company['Logo']}}"
                                 alt="{{$Company['CompanyName']}}" width="202" height="54" class="logo-footer">
                        </div><!-- End .widget -->
                    </div><!-- End .col-lg-3 -->

                    <div class="col-lg-3 col-sm-6 pb-4 pb-sm-0">
                        <div class="widget mb-2">
                            <h4 class="widget-title mb-1 pb-1">Get In Touch</h4>
                            <ul class="contact-info">
                                <li>
                                    <span class="contact-info-label">Address:</span>{{$Company['Address']}}
                                    <br>{{$Company['AddressData']->CityName}}, {{$Company['AddressData']->DistrictName}}
                                    , {{$Company['AddressData']->StateName}}, {{$Company['AddressData']->CountryName}}
                                    - {{$Company['AddressData']->PostalCode}}.
                                </li>
                                <li>
                                    <span class="contact-info-label">Phone:</span><a
                                        href="#">+91 {{$Company['Phone-Number']}}@if($Company['Mobile-Number'])
                                            , +91 {{$Company['Mobile-Number']}}
                                        @endif</a>
                                </li>
                                <li>
                                    <span class="contact-info-label">Email:</span>
                                    <a href="mailto:{{$Company['E-Mail']}}"><span
                                            class="__cf_email__">{{$Company['E-Mail']}}</span></a>
                                </li>
                            </ul>
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

                    <div class="col-lg-4 col-sm-6 pb-0 text-center">
                        <div class="social-icons">
                            @if(array_key_exists('facebook', $Company) && $Company['facebook'])
                                <a href="{{$Company['facebook']}}" class="social-icon social-facebook icon-facebook"
                                   target="_blank" title="Facebook"></a>
                            @endif

                            @if(array_key_exists('instagram', $Company) && $Company['instagram'])
                                <a href="{{$Company['instagram']}}" class="social-icon social-instagram icon-instagram"
                                   target="_blank" title="Instagram"></a>
                            @endif

                            @if(array_key_exists('youtube', $Company) && $Company['youtube'])
                                <a href="{{$Company['youtube']}}" class="social-icon social-youtube fab fa-youtube"
                                   target="_blank" title="YouTube"></a>
                            @endif

                            @if(array_key_exists('twitter', $Company) && $Company['twitter'])
                                <a href="{{$Company['twitter']}}" class="social-icon social-twitter fab fa-twitter"
                                   target="_blank" title="Twitter"></a>
                            @endif

                            @if(array_key_exists('linkedin', $Company) && $Company['linkedin'])
                                <a href="{{$Company['linkedin']}}"
                                   class="social-icon social-linkedin fab fa-linkedin-in" target="_blank"
                                   title="Linkedin"></a>
                            @endif
                        </div>
                        <!-- End .social-icons -->
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
        <a href="#" class="openLoginModal">
            <i class="icon-user-2"></i>Account
        </a>
    </div>
    <div class="sticky-info">
        <a href="{{ route('products.guest.productsList') }}" class="">
            <i class="icon-category-saddle"></i>Products
        </a>
    </div>
    <div class="sticky-info">
        <a href="#" title="Cart" class="dropdown-toggle dropdown-arrow cart-toggle" role="button" data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false" data-display="static">
            <i class="icon-shopping-cart position-relative"></i>Cart
        </a>
    </div>
</div>
@if(!$PostalCode)
    <div class="newsletter-popup mfp-hide bg-img p-0 h-auto" id="newsletter-popup-form"
         style="background: #f1f1f1 no-repeat center/cover">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-7">
                    <div class="row justify-content-center mt-3">
                        <div class="col-md-6">
                            <img loading="lazy" src="{{url('/')}}/{{$Company['Logo']}}"
                                 alt="{{$Company['CompanyName']}}" class="logo-newsletter" width="50" height="50">
                            <span class="ml-3 font-weight-bold text-dark">{{$Company['CompanyName']}}</span>
                        </div>
                    </div>
                    <div class="row justify-content-center my-3">
                        <div class="col-md-8">
                            <h2>Select a location </h2>
                            <p>to see product availability and delivery options</p>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6 justify-content-center">
                            <a href="#" onclick="$('#loginBtn').click();">
                                <button type="button" class="btn btn-info btn-block rounded">Sign in to select address
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <h5 class="text-center my-3">or</h5>
                        </div>
                    </div>
                    <div class="row justify-content-center mb-3">
                        <div class="col-md-8 newsletter-popup-content" id="divLocationInputs">
                            <div class="input-group">
                                <input type="text" class="form-control" id="txtCurrentPincode"
                                       placeholder="Enter your pincode" required="">
                                <input type="button" class="btn btn-warning" value="Submit" id="btnCurrentPincode">
                            </div>
                            <div class="errors err-sm text-center" id="txtCurrentPincode-err"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 text-center d-none d-md-block d-lg-block p-0">
                    <img class="centered-image" loading="lazy"
                         src="{{url('/')}}/home/assets/images/location-pop-up/MapAnime.gif" alt="">
                </div>
            </div>
        </div>
        <button title="Close (Esc)" type="button" class="mfp-close" id="modal-close-btn">×</button>
    </div>
@endif
<div class="newsletter-popup mfp-hide modal-sm bg-img p-0 h-auto" id="guest-login-form"
     style="background: #f1f1f1 no-repeat center/cover">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="row justify-content-center mt-3">
                    <div class="col-md-4">
                        <img loading="lazy" src="{{url('/')}}/{{$Company['Logo']}}" alt="{{$Company['CompanyName']}}"
                             class="logo-newsletter" width="50" height="50">
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
                        <a href="{{url('/')}}/social/auth/google"
                           class="d-flex justify-content-center align-items-center text-center">
                            <img src="{{ url('/assets/images/logo/google_sign_in_logo.png') }}" style="width: 50%;"
                                 class="img-fluid" alt="Google SignIn">
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
                            <input type="text" class="form-control" id="txtUserMobileNumber"
                                   placeholder="Enter your mobile number"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '');" inputmode="numeric"
                                   required>
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
                            <button type="button" class="btn btn-link" id="btnResendOtp"
                                    onclick="$('#btnSubmitMobileNumber').click();">Resend OTP
                            </button>
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
                            Construction Service Plan</h4></div>
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
                                    <label for="lstConServiceType" class="text-nowrap-430">Do you require any service related to construction<span class="hide-at-580-885">(Please click here)</span>:
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

<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="{{url('/')}}/home/assets/js/jquery.min.js"></script>
<script src="{{url('/')}}/home/assets/js/bootstrap.bundle.min.js"></script>
<script src="{{url('/')}}/home/assets/js/optional/isotope.pkgd.min.js"></script>
<script src="{{url('/')}}/home/assets/js/plugins.min.js"></script>
<script src="{{url('/')}}/home/assets/js/jquery.appear.min.js"></script>
<script src="{{url('/')}}/home/assets/js/jquery.plugin.min.js"></script>
<script src="{{url('/')}}/home/assets/js/main.js"></script>
<script src="{{url('/')}}/assets/js/toastr.min.js"></script>

<script>
    $(document).ready(function () {
        var bannerCurrentIndex = 0;
        var totalBannerSlides = $('#homeBannerList li').length;

        function showNextSlide() {
            bannerCurrentIndex = (bannerCurrentIndex + 1) % totalBannerSlides;
            $('#homeBannerList li').eq(bannerCurrentIndex).click();
        }

        setInterval(showNextSlide, 5000);

        $('.redirectLogin').on('click', function () {
            $('#loginBtn').click();
        });

        function performSearch(resultsElementId, searchText) {
            var formData = new FormData();
            formData.append('SearchText', searchText);
            $.ajax({
                url: "{{ route('guestHomeSearch') }}",
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

        $('#btnCurrentPincode').on('click', function (e) {
            e.preventDefault();
            $('.errors').html('');

            let Pincode = $('#txtCurrentPincode').val();
            if (!Pincode) {
                $('#txtCurrentPincode-err').html("Please enter a Pincode");
            } else {
                let formData = new FormData();
                formData.append('Pincode', Pincode);
                $.ajax({
                    url: "{{ route('setPostalCodeInSession') }}",
                    headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                    processData: false,
                    contentType: false,
                    type: "POST",
                    data: formData,
                    success: function (response) {
                        if (response.status == true) {
                            window.location.reload();
                        } else {
                            $('#txtCurrentPincode-err').html(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        });
        $('#btnClearPincode').on('click', function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('removePostalCodeInSession') }}",
                headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                processData: false,
                contentType: false,
                type: "POST",
                success: function (response) {
                    if (response.status == true) {
                        window.location.reload();
                    }
                }
            });
        });

        $('#btnSubmitMobileNumber').click(function () {
            var mobileNumber = $('#txtUserMobileNumber').val();
            if (mobileNumber === '') {
                $('#txtUserMobileNumber-err').text('Please enter your mobile number.');
                return;
            }
            let formData = new FormData();
            formData.append('MobileNumber', mobileNumber);
            formData.append('LoginType', 'Customer');
            $.ajax({
                url: '{{ route('web.mobile.login') }}',
                method: 'POST',
                headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                processData: false,
                contentType: false,
                data: formData,
                success: function (response) {
                    if (response.status) {
                        $('#divMobileNumber').addClass('d-none');
                        $('#divOtpInput').removeClass('d-none');
                        $('#btnResendOtp').removeClass('d-none');
                        $('#txtUserMobileNumber-err').text('');
                        $('#txtUserOtp').val('');
                        $('#txtUserOtp-err').text('');
                        alert("OTP sent successfully!");
                    } else {
                        $('#txtUserMobileNumber-err').text(response.message);
                    }
                },
                error: function () {
                    $('#txtUserMobileNumber-err').text('Error sending OTP. Please try again.');
                }
            });
        });

        $('#txtUserOtp').on('input', function () {
            let numericValue = $(this).val().replace(/[^0-9]/g, '');
            if (numericValue.length > 6) {
                numericValue = numericValue.slice(0, 6);
            }
            $(this).val(numericValue);
            if (numericValue.length >= 6) {
                $('#btnVerifyOtp').click();
            }
        });

        $('#btnVerifyOtp').click(function () {
            var mobileNumber = $('#txtUserMobileNumber').val();
            var otp = $('#txtUserOtp').val();
            if (otp === '') {
                $('#txtUserOtp-err').text('Please enter the OTP.');
                return;
            }
            let formData = new FormData();
            formData.append('MobileNumber', mobileNumber);
            formData.append('LoginType', 'Customer');
            formData.append('OTP', otp);
            $.ajax({
                url: '{{ route('web.mobile.login') }}',
                method: 'POST',
                headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                processData: false,
                contentType: false,
                data: formData,
                success: function (response) {
                    if (response.status) {
                        $('#txtUserOtp-err').text('');
                        window.location.href = '{{ url('/') }}';
                    } else {
                        $('#txtUserOtp-err').text(response.message);
                    }
                },
                error: function () {
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
