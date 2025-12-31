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

    <style>
        .play-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
            cursor: pointer;
        }

        .play-icon svg {
            fill: #ffffff;
        }

    </style>
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
                {{-- <div class="header-dropdown ">
                    <a href="#"></a>
                    <div class="header-menu">
                        <ul>
                            <li><a href="#">45, Eden Garden, Ganapathy, Coimbatore. 641006</a></li>
                            <li><a href="#">R.S.Puram, 3rd Cross, Coimbatore. 641003</a></li>
                        </ul>
                    </div>
                </div> --}}

                <div class="header-right header-dropdowns ml-0 ml-md-auto w-md-100">
                    <div class="header-dropdown mr-auto mr-md-0">
                        <div class="header-menu">

                        </div><!-- End .header-menu -->
                    </div><!-- End .header-dropown -->
                    <ul class="d-none d-xl-flex mb-0 pr-2 align-items-center">
                        <li>
                            <a href="#" style="font-size: 12px;"><i
                                    class="icon-help-circle" style="font-size: 18px;" onclick="$('#loginBtn').click();"></i>&nbsp;Help</a>
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
        <div class="container">
            <link rel="stylesheet" href="{{url('/')}}/home/assets/css/single-product.css">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Products</li>
                    </ol>
                </div>
            </nav>
            <div class="container">
                <div class="product-single-container product-single-default product-quick-view mb-0 custom-scrollbar">
                    <div class="row">
                        <div class="col-md-5 product-single-gallery mb-md-0">
                            <div class="product-slider-container">
                                <div class="product-single-carousel owl-carousel owl-theme show-nav-hover">
                                    <div class="product-item">
                                        <img loading="lazy" class="product-single-image"
                                             src="{{ $product->ProductImage }}"
                                             data-zoom-image="{{ $product->ProductImage }}"/>
                                    </div>
                                    @if($product->VideoURL != "")
                                        <div class="product-item">
                                            @php
                                                $urlParts = explode("/", parse_url($product->VideoURL, PHP_URL_PATH));
                                                $videoId = end($urlParts);
                                            @endphp
                                            <img loading="lazy" class="product-single-image"
                                                 src="https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg"
                                                 alt="{{ $product->ProductName }}"
                                                 data-zoom-image="https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg"/>
                                        </div>
                                    @endif
                                    @foreach($product->GalleryImages as $galleryImage)
                                        <div class="product-item">
                                            <img loading="lazy" class="product-single-image" src="{{ $galleryImage }}"
                                                 alt="{{ $product->ProductName }}"
                                                 data-zoom-image="{{ $galleryImage }}"/>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="prod-thumbnail product-owl-gallery owl-dots">
                                <div class="owl-dot video-thumbnail">
                                    <img loading="lazy" alt="{{ $product->ProductName }}" src="{{ $product->ProductImage }}"/>
                                </div>
                                @if($product->VideoURL != "")
                                    <div class="owl-dot">
                                        @php
                                            $urlParts = explode("/", parse_url($product->VideoURL, PHP_URL_PATH));
                                            $videoId = end($urlParts);
                                        @endphp
                                        <div class="play-icon youtubeVideoURL"
                                             data-url="{{ $product->VideoURL }}"
                                             data-toggle="modal" data-target="#videoModal"
                                             data-video-id="{{ $videoId }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="48px" height="48px">
                                                <path d="M8 5v14l11-7z"/>
                                            </svg>
                                        </div>
                                        <img loading="lazy" alt="{{ $product->ProductName }}"
                                             src="https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg"/>
                                    </div>
                                @endif
                                @foreach($product->GalleryImages as $galleryImage)
                                    <div class="owl-dot">
                                        <img loading="lazy" alt="{{ $product->ProductName }}"
                                             src="{{ $galleryImage }}"/>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="product-single-details mb-0 ml-md-4 product-div">
                                <h1 class="product-title"> {{ $product->ProductName }}</h1>
                                <div class="ratings-container mb-1">
                                    <div class="product-ratings">
                                        <span class="ratings" style="width:100%"></span>
                                    </div>
                                </div>
                                <div class="product-action">
                                    <div class="row col-12 p-0">
                                        <div class="col-lg-4 col-md-4 col-6 mb-1 order-lg-1 order-sm-1 order-md-1 order-1 pl-0 pr-md-3">
                                            <a href="#" onclick="$('#loginBtn').click();" class="btn btn-dark mr-2 product-type-simple btn-shop w-100" title="BUY NOW" id="{{ $product->ProductID }}">
                                                BUY NOW
                                            </a>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-12 order-lg-2 order-sm-3 order-md-2 order-3 p-0 pr-md-3">
                                            <a href="#" onclick="$('#loginBtn').click();"
                                               class="btn btn-dark mr-2 product-type-simple btn-shop w-100"
                                               title="Add to Cart" id="{{ $product->ProductID }}">ADD TO CART
                                            </a>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-6 mb-1 order-lg-3 order-sm-2 order-md-3 order-2 pr-0 pr-md-0">
                                            @if($product->ProductBrochure)
                                                <a href="{{ $product->ProductBrochure }}" class="btn btn-dark w-100" target="new">
                                                    View Brochure
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <hr class="short-divider" style="border-top: 1px solid #e7e7e7; width: 100%;">
                                <div class="product-desc">
                                    {!! $product->ShortDescription !!}
                                </div>

                                <ul class="single-info-list">
                                    <li>
                                        CATEGORY:
                                        <strong>
                                            <a href="{{ route('products.guest.subCategoryList', ['CID' => $product->PCID]) }}"
                                               class="product-category">{{ $product->CategoryName }}</a>
                                        </strong>
                                    </li>
                                    <li>
                                        SUB CATEGORY:
                                        <strong>
                                            <a href="{{ route('products.guest.productsList', ['SCID' => $product->PSCID]) }}"
                                               class="product-category">{{ $product->SubCategoryName }}</a>
                                        </strong>
                                    </li>
                                </ul>


                                {{--                <hr class="divider mb-0 mt-0">--}}

                                {{--                <div class="product-single-share mb-0">--}}
                                {{--                    <a href="#" class="btn-icon-wish add-wishlist {{ $product->IsInWishlist ? 'added-wishlist' : '' }}" title="{{ $product->IsInWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}"><i--}}
                                {{--                            class="icon-wishlist-2"></i><span>{{ $product->IsInWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}</span></a>--}}
                                {{--                </div>--}}
                            </div>
                        </div>
                    </div><!-- End .row -->
                </div>
                <!-- End .product-single-container -->


                <div class="mt-lg-3 wpb_custom_3df3a217ba8228c65da804bd5a0f04b6">
                    <div class="woocommerce-tabs woocommerce-tabs-kktu2rb5 resp-htabs" id="product-tab"
                         style="display: block; width: 100%;">
                        <ul class="resp-tabs-list" role="tablist">
                            <li class="description_tab resp-tab-item resp-tab-active" id="tab-title-description"
                                role="tab" aria-controls="tab_item-0">
                                Description
                            </li>
                            {{--                    <li class="additional_information_tab resp-tab-item" id="tab-title-additional_information" role="tab" aria-controls="tab_item-1">--}}
                            {{--                        Additional information				</li>--}}
                            {{--                    <li class="reviews_tab resp-tab-item" id="tab-title-reviews" role="tab" aria-controls="tab_item-2">--}}
                            {{--                        Reviews (0)				</li>--}}

                        </ul>
                        <div class="resp-tabs-container">

                            <h2 class="resp-accordion resp-tab-active" role="tab" aria-controls="tab_item-0"><span
                                    class="resp-arrow"></span>
                                Description </h2>
                            <div class="tab-content resp-tab-content resp-tab-content-active" id="tab-description"
                                 aria-labelledby="tab_item-0" style="display:block">

                                <h2>Description</h2>

                                <div class="wpb-content-wrapper">
                                    {!! $product->Description !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <section class="product-section1 recently">
                    <div class="container">
                        <h2 class="title title-underline pb-1 appear-animate" data-animation-name="fadeInLeftShorter">
                            Related Products</h2>
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
                            @foreach ($RelatedProducts->shuffle()->take(6) as $relatedProduct)
                                <div class="product-default inner-quickview inner-icon product-div">
                                    <figure>
                                        <a href="{{ route('guest.product.view', $relatedProduct->ProductID) }}">
                                            <img loading="lazy" src="{{ file_exists($relatedProduct->ThumbnailImg)? url('/'.$relatedProduct->ThumbnailImg): $relatedProduct->ProductImage }}" width="300" height="300" alt="product">
                                        </a>
                                        <div class="label-group">
                                            {{-- <span class="product-label label-sale">-13%</span> --}}
                                        </div>
                                        <div class="btn-icon-group">
                                            <a href="#" class="btn-icon btn-add-cart product-type-simple btnAddCart"
                                               id="{{ $relatedProduct->ProductID }}"><i
                                                    class="icon-shopping-cart"></i></a>
                                        </div>
                                        <a href="{{ route('guest.products.quickView', $relatedProduct->ProductID) }}"
                                           class="btn-quickview" title="Quick View">Quick View</a>
                                    </figure>
                                    <div class="product-details">
                                        <div class="category-wrap">
                                            <div class="category-list">
                                                <a href="{{ route('products.guest.productsList', ['SCID' => $relatedProduct->PSCID]) }}">{{ $relatedProduct->PSCName }}</a>
                                            </div>
                                            {{--                    <a href="#" class="btn-icon-wish {{ $relatedProduct->IsInWishlist ? 'added-wishlist' : '' }}" title="wishlist"><i class="icon-heart"></i></a>--}}
                                        </div>
                                        <h3 class="product-title">
                                            <a href="{{ route('guest.product.view', $relatedProduct->ProductID) }}">{{ $relatedProduct->ProductName }}</a>
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
            </div>
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
                                    <span class="contact-info-label">Email:</span> <a href="#"><span
                                            class="__cf_email__"
                                        >{{$Company['E-Mail']}}</span></a>
                                </li>
                            </ul>
                            <div class="social-icons">
                                @if(array_key_exists('facebook', $Company) && $Company['facebook'])
                                    <a href="{{$Company['facebook']}}" class="social-icon social-facebook icon-facebook"
                                       target="_blank" title="Facebook"></a>
                                @endif

                                @if(array_key_exists('instagram', $Company) && $Company['instagram'])
                                    <a href="{{$Company['instagram']}}"
                                       class="social-icon social-instagram icon-instagram" target="_blank"
                                       title="Instagram"></a>
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
        <a href="#" title="Cart" class="dropdown-toggle dropdown-arrow cart-toggle" role="button" data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false" data-display="static">
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

<!-- Modal -->
<div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body text-center" style="height: auto !important;">
            </div>
        </div>
    </div>
</div>

<script src="{{url('/home/assets/js/jquery.min.js')}}"></script>
<script src="{{url('/home/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{url('/home/assets/js/optional/isotope.pkgd.min.js')}}"></script>
<script src="{{url('/home/assets/js/plugins.min.js')}}"></script>
<script src="{{url('/home/assets/js/jquery.appear.min.js')}}"></script>
<script src="{{url('/home/assets/js/jquery.plugin.min.js')}}"></script>
<script src="{{url('/home/assets/js/main.js')}}"></script>
<script>
    $(document).ready(function () {
        $('.youtubeVideoURL').on('click', function () {
            var videoId = $(this).data('video-id');
            var iframe = document.createElement('iframe');
            iframe.src = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';
            var closeButton = `<div class="row mb-2"><button type="button" class="close ml-1" data-dismiss="modal" aria-label="Close" style="position: absolute; top: 10px; right: 10px;"><span aria-hidden="true">×</span></button></div>`;
            var screenWidth = $(window).width();
            var screenHeight = $(window).height();
            var width, height;
            if (screenWidth < 768) {
                width = screenWidth * 0.9;
                height = screenHeight * 0.5;
            } else {
                width = screenWidth * 0.49;
                height = screenHeight * 0.56;
            }
            iframe.width = width;
            iframe.height = height;
            iframe.frameborder = 0;
            iframe.allow = 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture';
            iframe.allowFullscreen = true;
            $('#videoModal .modal-body').append(closeButton, iframe);
            $('#videoModal').on('hidden.bs.modal', function () {
                $('#videoModal .modal-body').empty();
                var activeDot = $('.owl-dot.active');
                var nextItem = activeDot.closest('.owl-item').next('.owl-item');
                if (!nextItem.length) {
                    nextItem = $('.owl-item').first();
                }
                activeDot.removeClass('active');
                var nextDot = nextItem.find('.owl-dot');
                if (!nextDot.length) {
                    nextDot = $('.owl-dot').first();
                }
                nextDot.click();
            });
        });

        $('.redirectLogin').on('click', function(){
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

        $('#btnClearPincode').on('click', function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('removePostalCodeInSession') }}",
                headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                processData: false,
                contentType: false,
                type: "POST",
                success: function (response) {
                    if (response.status === true) {
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

