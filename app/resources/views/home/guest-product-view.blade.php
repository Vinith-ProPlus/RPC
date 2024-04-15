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
    <div class="top-notice bg-dark text-white pt-3">
        <div class="container text-center d-flex align-items-center justify-content-center flex-wrap">
            <h4 class="text-uppercase font-weight-bold mr-2">Deal of the week</h4>
            <h6>- 15% OFF in All Construction Materials, -</h6>

            <a href="{{ route('guest.products') }}" class="ml-2">Shop Now</a>
        </div><!-- End .container -->
    </div><!-- End .top-notice -->

    <header class="header">
        <div class="header-top">
            <div class="container">
                <div class="header-left d-md-block">
                    <div class="info-box info-box-icon-left text-primary justify-content-start p-0">
                        {{-- <i class="icon-location" style="color:#ff6840;"></i>
                        <h6 class="font-weight-bold text-dark">Delivery Location - </h6> --}}
                        {{-- <span><a href="#" class="text-dark">45,Eden Garden, R.S.Puram, 3rd Cross, Coimbatore. 641006</a></span> --}}
                        <i class="fa fa-arrow"></i>
                    </div>
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
                    <button class="mobile-menu-toggler text-dark mr-2" type="button">
                        <i class="fas fa-bars"></i>
                    </button>
                    <a href="#" class="logo">
                        <img src="{{url('/')}}/{{$Company['Logo']}}" width="50" height="50" alt="RPC">
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
                    <a href="{{url('/')}}/social/auth/google" class="d-lg-block d-none" id="loginBtn">
                        <div class="header-user">
                            <div class="header-userinfo">
                                <span>Welcome</span>
                                <h4>Sign In / Register</h4>
                            </div>
                        </div>
                    </a>

                    {{-- <span class="separator d-none d-lg-block mr-4"></span>
                    <a href="{{url('/')}}/login" class="d-lg-block d-none">
                        <div class="header-user">
                            <i class="icon-user-2"></i>
                        </div>
                    </a> --}}

                    <span class="separator d-block"></span>

                    <div class="dropdown cart-dropdown">
                        <a href="#" title="Cart" class="dropdown-toggle dropdown-arrow cart-toggle" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
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
                        <li class="{{ (Route::currentRouteName() == "homepage") ? 'active' : '' }}">
                            <a href="{{ route('homepage') }}">Home</a>
                        </li>
                        <li>
                            <a href="#">Products</a>
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
                                                    <li><a href="{{ route('products.guest.subCategoryList', ['CID' => $category->PCID]) }}">{{ $category->PCName }}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                    <div class="col-lg-12 p-1">
                                        <div class="row justify-content-end">
                                            <div class="col-lg-4">
                                                <a href="{{ route('products') }}" class="btn btn-sm btn-dark mr-0">View
                                                    More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End .row -->
                            </div><!-- End .megamenu -->
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
                                        <img class="product-single-image" src="{{ $product->ProductImage }}"
                                             data-zoom-image="{{ $product->ProductImage }}"/>
                                    </div>
                                    @foreach($product->GalleryImages as $galleryImage)
                                        <div class="product-item">
                                            <img class="product-single-image" src="{{ $galleryImage }}"
                                                 data-zoom-image="{{ $galleryImage }}"/>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="prod-thumbnail owl-dots">
                                <div class="owl-dot">
                                    <img src="{{ $product->ProductImage }}"/>
                                </div>
                                @foreach($product->GalleryImages as $galleryImage)
                                    <div class="owl-dot">
                                        <img src="{{ $galleryImage }}"/>
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
                                            <a href="{{ route('products.guest.subCategoryList', ['CID' => $product->PCID]) }}" class="product-category">{{ $product->CategoryName }}</a>
                                        </strong>
                                    </li>
                                    <li>
                                        SUB CATEGORY:
                                        <strong>
                                            <a href="{{ route('products.guest.productsList', ['SCID' => $product->PSCID]) }}" class="product-category">{{ $product->SubCategoryName }}</a>
                                        </strong>
                                    </li>
                                </ul>

                                <div class="product-action">
                                    <a href="#"
                                       class="btn btn-dark mr-2 product-type-simple btn-shop"
                                       title="Add to Cart" id="{{ $product->ProductID }}">ADD TO CART
                                    </a>
                                    <a href="#" class="btn view-cart d-none">View cart</a>
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
                    <div class="woocommerce-tabs woocommerce-tabs-kktu2rb5 resp-htabs" id="product-tab" style="display: block; width: 100%;">
                        <ul class="resp-tabs-list" role="tablist">
                            <li class="description_tab resp-tab-item resp-tab-active" id="tab-title-description" role="tab" aria-controls="tab_item-0">
                                Description				</li>
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
                                            <img src="{{ $relatedProduct->ProductImage }}" width="300" height="300" alt="product">
                                        </a>
                                        <div class="label-group">
                                            {{-- <span class="product-label label-sale">-13%</span> --}}
                                        </div>
                                        <div class="btn-icon-group">
                                            <a href="#" class="btn-icon btn-add-cart product-type-simple btnAddCart" id="{{ $relatedProduct->ProductID }}"><i
                                                    class="icon-shopping-cart"></i></a>
                                        </div>
                                        <a href="{{ route('products.quickView', $relatedProduct->ProductID) }}" class="btn-quickview" title="Quick View">Quick View</a>
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
                            <img src="{{url('/')}}/{{$Company['Logo']}}" alt="Logo" width="202" height="54"
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
                                    <span class="contact-info-label">Phone:</span><a href="#">{{$Company['Phone-Number']}}@if($Company['Mobile-Number']), {{$Company['Mobile-Number']}} @endif</a>
                                </li>
                                <li>
                                    <span class="contact-info-label">Email:</span> <a href="#"><span
                                            class="__cf_email__"
                                            data-cfemail="f895999194b89d80999588949dd69b9795">{{$Company['E-Mail']}}</span></a>
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
                            <h4 class="widget-title pb-1">Customer Services</h4>

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
        <a href="wishlist.html" class="">
            <i class="icon-wishlist-2"></i>Wishlist
        </a>
    </div>
    <div class="sticky-info">
        <a href="login.html" class="">
            <i class="icon-user-2"></i>Account
        </a>
    </div>
    <div class="sticky-info">
        <a href="cart.html" class="">
            <i class="icon-shopping-cart position-relative">
                <span class="cart-count badge-circle">3</span>
            </i>Cart
        </a>
    </div>
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
            window.location.replace($('#loginBtn').attr('href'));
        });

        $('#homeSearch').on('keyup', function() {
            var formData = new FormData();
            formData.append('SearchText', $(this).val());
            $.ajax({
                url: "{{ route('guestHomeSearch') }}",
                method: 'POST',
                headers: { 'X-CSRF-Token' : '{{ csrf_token() }}' },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    let searchResults = $('#searchResults');
                    searchResults.empty();
                    searchResults.append((response.searchResults !== "") ? response.searchResults : "No results found");
                    searchResults.show();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });

        $(document).on('click', function(event) {
            if (!$(event.target).closest('.header-search-wrapper').length) {
                $('#searchResults').hide();
            }
        });
    });
</script>
</body>
</html>

