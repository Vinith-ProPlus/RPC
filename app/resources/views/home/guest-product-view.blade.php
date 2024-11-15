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
                                <div
                                    style="text-align: center; display: flex; justify-content: center; align-items: center;">
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
                            <div class="prod-thumbnail owl-dots">
                                <div class="owl-dot video-thumbnail">
                                    <img loading="lazy" alt="{{ $product->ProductName }}"
                                         src="{{ $product->ProductImage }}"/>
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

                                <div class="ratings-container">
                                    <div class="product-ratings">
                                        <span class="ratings" style="width:{{ Rand(50,100) }}%"></span>
                                    </div>
                                </div>

                                <hr class="short-divider">
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

                                <div class="product-action">
                                    <div class="row col-12">
                                        <div class="col-8">
                                            <a href="#" onclick="$('#loginBtn').click();"
                                               class="btn btn-dark mr-2 product-type-simple btn-shop"
                                               title="Add to Cart" id="{{ $product->ProductID }}">ADD TO CART
                                            </a>
                                            <a href="#" class="btn view-cart d-none">View cart</a>
                                        </div>
                                        <div class="col-4 text-right">
                                            @if($product->ProductBrochure)
                                                <a href="{{ $product->ProductBrochure }}" class="btn btn-dark" target="new">
                                                    View Brochure
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{--                <hr class="divider mb-0 mt-0">--}}

                                {{--                <div class="product-single-share mb-0">--}}
                                {{--                    <a href="#" class="btn-icon-wish add-wishlist {{ $product->IsInWishlist ? 'added-wishlist' : '' }}" title="{{ $product->IsInWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}"><i--}}
                                {{--                            class="icon-wishlist-2"></i><span>{{ $product->IsInWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}</span></a>--}}
                                {{--                </div>--}}
                            </div>
                        </div>

                        <button title="Close (Esc)" type="button" class="mfp-close">
                            ×
                        </button>
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
                                            <img loading="lazy" src="{{ $relatedProduct->ProductImage }}" width="300"
                                                 height="300" alt="product">
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
                                                <span class="ratings" style="width:{{ rand(0, 100) }}%"></span>
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

