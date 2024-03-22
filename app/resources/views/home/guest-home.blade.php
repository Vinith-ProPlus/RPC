<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>RPC Construction</title>

    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="RPC Construction">
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
        <div class="top-notice bg-dark text-white pt-3">
            <div class="container text-center d-flex align-items-center justify-content-center flex-wrap">
                <h4 class="text-uppercase font-weight-bold mr-2">Deal of the week</h4>
                <h6>- 15% OFF in All Construction Materials, -</h6>

                <a href="#" class="ml-2">Shop Now</a>
            </div><!-- End .container -->
        </div><!-- End .top-notice -->

        <header class="header">
            <div class="header-top">
                <div class="container">
                    <div class="header-left d-md-block">
                        <div class="info-box info-box-icon-left text-primary justify-content-start p-0">
							<i class="fa fa-arrow"></i>
                        </div>
                    </div>
                    <div class="header-right header-dropdowns ml-0 ml-md-auto w-md-100">
                        <div class="header-dropdown mr-auto mr-md-0">
                            <div class="header-menu">

                            </div><!-- End .header-menu -->
                        </div><!-- End .header-dropown -->
						<ul class="top-links mega-menu d-none d-xl-flex mb-0 pr-2">
                            <li class="menu-item menu-item-type-post_type menu-item-object-page narrow">
                                <a href="#"><i class="icon-help-circle"></i>Help</a></li>
                        </ul>


                        <span class="separator d-none d-md-block mr-0 ml-4"></span>

                        <div class="social-icons">
                            <a href="{{$Company['facebook']}}" class="social-icon social-facebook icon-facebook" target="_blank"
                                title="facebook"></a>
                            <a href="{{$Company['twitter']}}" class="social-icon social-twitter icon-twitter" target="_blank"
                                title="twitter"></a>
                            <a href="{{$Company['instagram']}}" class="social-icon social-instagram icon-instagram mr-0" target="_blank"
                                title="instagram"></a>
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
                        <a href="demo42.html" class="logo">
							<img src="{{url('/')}}/{{$Company['Logo']}}" width="50" height="50" alt="RPC">
                        </a>
						<span class="ml-3 font-weight-bold">RPC Construction</span>
                    </div><!-- End .header-left -->

                    <div class="header-right w-lg-max">
                        <div
                            class="header-icon header-search header-search-inline header-search-category w-lg-max text-right mb-0">
                            <a href="#" class="search-toggle" role="button"><i class="icon-search-3"></i></a>
                            <form action="#" method="get">
                                <div class="header-search-wrapper">
                                    <input type="search" class="form-control" name="q" id="q" placeholder="Search..."
                                        required>

                                    <button class="btn icon-magnifier p-0" title="search" type="submit"></button>
                                </div><!-- End .header-search-wrapper -->
                            </form>
                        </div><!-- End .header-search -->

                        <span class="separator d-none d-lg-block"></span>

                        <div class="sicon-box mb-0 d-none d-lg-flex align-items-center pr-3 mr-1">
                            <div class=" sicon-default">
                                <i class="icon-phone-1"></i>
                            </div>
                            <div class="sicon-header">
                                <h4 class="sicon-title ls-n-25">CALL US NOW</h4>
                                <p>0422 234688</p>
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
                                        <a href="cart.html" class="btn btn-gray btn-block view-cart">Add to Cart</a>
                                        <a href="checkout.html" class="btn btn-dark btn-block">Checkout</a>
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
                                                    <a href="{{ route('guest.products') }}" class="btn btn-sm btn-dark mr-0">View More</a>
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

            <section class="intro-section">
                <div class="home-slider slide-animate owl-carousel owl-theme owl-carousel-lazy dot-inside" data-owl-options="{
                    'nav': false,
                    'dots': true,
                    'responsive': {
                        '576': {
                            'dots': false
                        }
                    }
                }">
                    @foreach($Banners as $Banner)
                        <div class="home-slide banner" style="background-image: url('{{ $Banner->BannerImage }}');"></div>
                    @endforeach
                </div>

                <div class="home-slider-sidebar d-none d-sm-block">
                    <div class="container">
                        <ul>
                            @foreach($Banners as $index => $Banner)
                                <li {{ ($index == 0) ? "class=active" : '' }}>{{ $Banner->BannerTitle }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </section>
            <section class="building-modeling">
                <div class="container">
                    <div class="row my-5">
                        <div class="col-sm-4 d-flex justify-content-center align-items-center">
                            <div class="circle">1</div>
                            <div class="step">STEP 1</div>
                        </div>
                        <div class="col-sm-4 d-flex justify-content-center align-items-center">
                            <div class="circle">2</div>
                            <div class="step">STEP 2</div>

                        </div>
                        <div class="col-sm-4 d-flex justify-content-center align-items-center">
                            <div class="circle">3</div>
                            <div class="step">STEP 3</div>
                        </div>
                    </div>
                    <div class="row my-5">
                        <div class="col-sm-4">
                            <img src="{{url('/')}}/home/assets/images/step/step1.png" alt="" height="176px" width="418px">
                        </div>
                        <div class="col-sm-4">
                            <img src="{{url('/')}}/home/assets/images/step/step2.png" alt="" height="176px" width="418px">
                        </div>
                        <div class="col-sm-4">
                            <img src="{{url('/')}}/home/assets/images/step/step3.png" alt="" height="176px" width="418px">
                        </div>
                    </div>
                </div>
            </section>

            <section class="category-section container">
                <div class="d-lg-flex align-items-center appear-animate" data-animation-name="fadeInLeftShorter">
                    <h2 class="title title-underline divider">Shop Categories</h2>
                    <a href="{{ route('products.guest.categoriesList') }}" class="sicon-title">VIEW CATEGORIES<i class="fas fa-arrow-right"></i></a>
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
                                    <img src="{{ $category->PCImage }}" alt="{{ $category->PCName }}" width="25" height="25">
                                </figure>
                            </a>
                            <div class="category-content">
                                <h3 class="category-title">{{ $category->PCName }}</h3>
                                <ul class="sub-categories">
                                    @foreach ($category->PSCData->take(4) as $subCategory)
                                        <li><a href="{{ route('products.guest.productsList', ['SCID' => $subCategory->PSCID]) }}">{{ $subCategory->PSCName }}</a></li>
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

                    @for ($i = 0; $i < 6; $i++)
                        @php
                            $hotProduct = $HotProducts[$i];
                            $ratingWidth = rand(0, 100);
                        @endphp
                        <div class="product-default inner-quickview inner-icon">
                            <figure>
                                <a href="#">
                                    <img src="{{ $hotProduct->ProductImage }}" width="300" height="300" alt="product">
                                </a>
                                <div class="label-group">
                                    {{-- <span class="product-label label-sale">-13%</span> --}}
                                </div>
                                <div class="btn-icon-group">
                                    <a href="#" class="btn-icon redirectLogin product-type-simple"><i
                                            class="icon-shopping-cart"></i></a>
                                </div>
                                <a href="{{ route('products.quickView', $hotProduct->ProductID) }}" class="btn-quickview" title="Quick View">Quick View</a>
                            </figure>
                            <div class="product-details">
                                <div class="category-wrap">
                                    <div class="category-list">
                                        <a href="#">{{ $hotProduct->PSCName }}</a>
                                    </div>
                                    <a href="#" class="btn-icon-wish" title="wishlist"><i class="icon-heart"></i></a>
                                </div>
                                <h3 class="product-title">
                                    <a href="#">{{ $hotProduct->ProductName }}</a>
                                </h3>
                                <div class="ratings-container">
                                    <div class="product-ratings">
                                        <span class="ratings" style="width:{{ $ratingWidth }}%"></span>
                                        <span class="tooltiptext tooltip-top"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor


                    </div>
                </div>
            </section>
            <section class="call-section appear-animate" style="background-color: #212529;">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-7">
                            <h4 class="text-white text-uppercase">looking for help to
                                find construction materials?</h4>
                            <h2 class="text-white">Best raw materials providers</h2>
                            <h3>Call Us or Drop Us a Message Through Our Contact Form</h3>
                        </div>
                        <div class="col-lg-5 call-action">
                            <div class="d-inline-flex align-items-center text-left divider">
                                <i class="icon-phone-1 text-white mr-2"></i>
                                <h6 class="pt-1 line-height-1 text-uppercase text-white">Call us now<a href="tel:#"
                                        class="d-block text-white ls-10 pt-2">+91 8058975232</a></h6>
                            </div>
                            <a href="#" class="btn btn-borders btn-rounded btn-outline-white ls-25">Send Us a
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
                    <h2 class="title title-underline pb-1 appear-animate" data-animation-name="fadeInLeftShorter">
                        Recently Arrived</h2>
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
                @for ($i = 0; $i < 6; $i++)
                    @php
                        $recentProduct = $RecentProducts[$i];
                        $ratingWidth = rand(0, 100);
                    @endphp
                    <div class="product-default inner-quickview inner-icon">
                        <figure>
                            <a href="#">
                                <img src="{{ $recentProduct->ProductImage }}" width="300" height="300" alt="product">
                            </a>
                            <div class="label-group">
                                {{-- <span class="product-label label-sale">-13%</span> --}}
                            </div>
                            <div class="btn-icon-group">
                                <a href="#" class="btn-icon redirectLogin product-type-simple"><i
                                        class="icon-shopping-cart"></i></a>
                            </div>
                            <a href="{{ route('products.quickView', $recentProduct->ProductID) }}" class="btn-quickview" title="Quick View">Quick View</a>
                        </figure>
                        <div class="product-details">
                            <div class="category-wrap">
                                <div class="category-list">
                                    <a href="#">{{ $recentProduct->PSCName }}</a>
                                </div>
                                <a href="#" class="btn-icon-wish" title="wishlist"><i class="icon-heart"></i></a>
                            </div>
                            <h3 class="product-title">
                                <a href="#">{{ $recentProduct->ProductName }}</a>
                            </h3>
                            <div class="ratings-container">
                                <div class="product-ratings">
                                    <span class="ratings" style="width:{{ $ratingWidth }}%"></span>
                                    <span class="tooltiptext tooltip-top"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
                    </div>
                </div>
            </section>
            <section class="subcats-section container">
                <div class="row">
                    <div class="col-md-4 part-item appear-animate" data-animation-name="fadeInLeftShorter">
                        <h4>Popular Categories:</h4>
                        <ul class="list-unstyled mb-0">
                            @foreach ($PCategories->take(4) as $category)
                                <li><a href="{{ route('products.guest.subCategoryList', ['CID' => $category->PCID]) }}">{{ $category->PCName }}</a></li>
                            @endforeach
                            <li><a class="show-action" href="{{ route('products.guest.categoriesList') }}">Show All</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 part-item appear-animate" data-animation-name="fadeInLeftShorter"
                        data-animation-delay="200">
                        <h3>Popular Brands:</h3>
                        <ul class="list-unstyled mb-0">
                            <li><a href="#">Dalmia</a></li>
                            <li><a href="#">UltraTech</a></li>
                            <li><a href="#">Bharathi Cements</a></li>
                            <li><a href="#">ACC</a></li>
                            <li><a class="show-action" href="{{ route('guest.products') }}">Show All</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 part-item appear-animate" data-animation-name="fadeInLeftShorter"
                        data-animation-delay="400">
                        <h3>Popular Products:</h3>
                        <ul class="list-unstyled mb-0">
                            @foreach ($PCategories->shuffle()->take(4) as $category)
                                <li><a href="{{ route('products.guest.subCategoryList', ['CID' => $category->PCID]) }}">{{ $category->PCName }}</a></li>
                            @endforeach
                            <li><a class="show-action" href="{{ route('products.guest.categoriesList') }}">Show All</a></li>
                        </ul>
                    </div>

                </div>
            </section>

        </main>
        <!-- End .main -->

        <footer class="footer bg-dark position-relative">
            <div class="footer-middle">
                <div class="container position-static">
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 pb-2 pb-sm-0 d-flex align-items-center">
                            <div class="widget m-b-3">
									<img src="{{url('/')}}/{{$Company['Logo']}}" alt="Logo" width="202" height="54" class="logo-footer">

                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-3 -->

                        <div class="col-lg-3 col-sm-6 pb-4 pb-sm-0">
                            <div class="widget mb-2">
                                <h4 class="widget-title mb-1 pb-1">Get In Touch</h4>
                                <ul class="contact-info">
                                    <li>
										<span class="contact-info-label">Address:</span>45, RPC Building, Erode,<br>TamilNadu.638001.
                                    </li>
                                    <li>
                                        <span class="contact-info-label">Phone:</span><a href="tel:0422-4567890">0422-4567890</a>
                                    </li>
                                    <li>
                                        <span class="contact-info-label">Email:</span>
                                        <a href="mailto:{{$Company['E-Mail']}}"><span
                                                class="__cf_email__"
                                                data-cfemail="f895999194b89d80999588949dd69b9795">{{$Company['E-Mail']}}</span></a>
                                    </li>
                                    <li>
                                        <span class="contact-info-label">Working Days/Hours:</span>
                                        Mon - Sun / 9:00 AM - 8:00 PM
                                    </li>
                                </ul>
                                <div class="social-icons">
									<a href="{{$Company['facebook']}}" class="social-icon social-facebook icon-facebook" target="_blank" title="Facebook"></a>

									<a href="{{$Company['instagram']}}" class="social-icon social-instagram icon-instagram" target="_blank" title="Instagram"></a>

                                    <a href="{{$Company['linkedin']}}" class="social-icon social-linkedin fab fa-linkedin-in" target="_blank" title="Linkedin"></a>
                                </div><!-- End .social-icons -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-3 -->

                        <div class="col-lg-3 col-sm-6 pb-2 pb-sm-0">
                            <div class="widget">
                                <h4 class="widget-title pb-1">Customer Services</h4>

                                <ul class="links">
                                    @foreach(DB::table('tbl_page_content')->select('Slug', 'PageName')->get() as $Policy)
                                        <li><a href="{{ route('policies', $Policy->Slug) }}">{{ $Policy->PageName ?? '' }}</a></li>
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
                        <span class="footer-copyright">RPC Construction. © 2024. All Rights Reserved</span>
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

    {{-- <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="fa fa-times"></i></span>
            <nav class="mobile-nav">
                <ul class="mobile-menu">
                    <li><a href="demo42.html">Home</a></li>
                    <li>
                        <a href="demo42-shop.html" title="shop">Categories</a>
                        <ul>
                            <li><a href="category.html">Full Width Banner</a></li>
                            <li><a href="category-banner-boxed-slider.html">Boxed Slider Banner</a></li>
                            <li><a href="category-banner-boxed-image.html">Boxed Image Banner</a></li>
                            <li><a href="https://www.portotheme.com/html/porto_ecommerce/category-sidebar-left.html">Left Sidebar</a></li>
                            <li><a href="category-sidebar-right.html">Right Sidebar</a></li>
                            <li><a href="category-off-canvas.html">Off Canvas Filter</a></li>
                            <li><a href="category-horizontal-filter1.html">Horizontal Filter 1</a></li>
                            <li><a href="category-horizontal-filter2.html">Horizontal Filter 2</a></li>
                            <li><a href="#">List Types</a></li>
                            <li><a href="category-infinite-scroll.html">Ajax Infinite Scroll<span
                                        class="tip tip-new">New</span></a></li>
                            <li><a href="demo42-shop.html" title="shop">3 Columns Products</a></li>
                            <li><a href="category-4col.html">4 Columns Products</a></li>
                            <li><a href="category-5col.html">5 Columns Products</a></li>
                            <li><a href="category-6col.html">6 Columns Products</a></li>
                            <li><a href="category-7col.html">7 Columns Products</a></li>
                            <li><a href="category-8col.html">8 Columns Products</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="demo42-product.html">Products</a>
                        <ul>
                            <li>
                                <a href="#" class="nolink">PRODUCT PAGES</a>
                                <ul>
                                    <li><a href="product.html">SIMPLE PRODUCT</a></li>
                                    <li><a href="product-variable.html">VARIABLE PRODUCT</a></li>
                                    <li><a href="product.html">SALE PRODUCT</a></li>
                                    <li><a href="product.html">FEATURED & ON SALE</a></li>
                                    <li><a href="product-sticky-info.html">WIDTH CUSTOM TAB</a></li>
                                    <li><a href="product-sidebar-left.html">WITH LEFT SIDEBAR</a></li>
                                    <li><a href="product-sidebar-right.html">WITH RIGHT SIDEBAR</a></li>
                                    <li><a href="product-addcart-sticky.html">ADD CART STICKY</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="nolink">PRODUCT LAYOUTS</a>
                                <ul>
                                    <li><a href="product-extended-layout.html">EXTENDED LAYOUT</a></li>
                                    <li><a href="product-grid-layout.html">GRID IMAGE</a></li>
                                    <li><a href="product-full-width.html">FULL WIDTH LAYOUT</a></li>
                                    <li><a href="product-sticky-info.html">STICKY INFO</a></li>
                                    <li><a href="product-sticky-both.html">LEFT & RIGHT STICKY</a></li>
                                    <li><a href="product-transparent-image.html">TRANSPARENT IMAGE</a></li>
                                    <li><a href="product-center-vertical.html">CENTER VERTICAL</a></li>
                                    <li><a href="#">BUILD YOUR OWN</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>

                <ul class="mobile-menu">
                    <li><a href="login.html">My Account</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                    <li><a href="blog.html">Blog</a></li>
                    <li><a href="wishlist.html">My Wishlist</a></li>
                    <li><a href="cart.html">Cart</a></li>
                    <li><a href="login.html" class="login-link">Log In</a></li>
                </ul>
            </nav><!-- End .mobile-nav -->

            <form class="search-wrapper mb-2" action="#">
                <input type="text" class="form-control mb-0" placeholder="Search..." required />
                <button class="btn icon-search text-white bg-transparent p-0" title="submit" type="submit"></button>
            </form>

            <div class="social-icons">
                <a href="#" class="social-icon social-facebook icon-facebook" target="_blank" title="facebook">
                </a>
                <a href="#" class="social-icon social-twitter icon-twitter" target="_blank" title="twitter">
                </a>
                <a href="#" class="social-icon social-instagram icon-instagram" target="_blank" title="instagram">
                </a>
            </div>
        </div><!-- End .mobile-menu-wrapper -->
    </div> --}}<!-- End .mobile-menu-container -->

    <div class="sticky-navbar">
        <div class="sticky-info">
            <a href="demo42.html">
                <i class="icon-home"></i>Home
            </a>
        </div>
        <div class="sticky-info">
            <a href="demo42-shop.html" class="">
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

    {{-- <div class="newsletter-popup mfp-hide bg-img p-0 h-auto" id="newsletter-popup-form" style="background: #f1f1f1 no-repeat center/cover">
        <div class="row">
			<div class="col-sm-7">
				<div class="row justify-content-center mt-3">
					<div class="col-6">
						<img src="{{url('/')}}/{{$Company['Logo']}}" alt="Logo" class="logo-newsletter" width="50" height="50">
						<span class="ml-3 font-weight-bold text-dark">RPC Construction</span>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-9">
						<h2>KINDLY TURN ON YOUR LOCATION</h2>
						<p>for location Offers!</p>
					</div>
				</div>
				<div class="row my-1 justify-content-center">
					<div class="col-12 newsletter-popup-content">
						<div class="input-group">
							<input type="email" class="form-control" id="newsletter-email" name="newsletter-email" placeholder="Enter your delivery location" required />
							<input type="submit" class="btn btn-warning" value="locate me" />
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-5">
				<img src="{{url('/')}}/home/assets/images/location-pop-up/MapAnime.gif" alt="">
			</div>
		</div>
        <button title="Close (Esc)" type="button" class="mfp-close">×</button>
    </div> --}}
    <div class="newsletter-popup mfp-hide bg-img p-0 h-auto" id="newsletter-popup-form" style="background: #f1f1f1 no-repeat center/cover">
        <div class="row">
            <div class="col-sm-7">
                <div class="row justify-content-center mt-3">
                    <div class="col-6">
                        <img src="{{url('/')}}/{{$Company['Logo']}}" alt="Logo" class="logo-newsletter" width="50" height="50">
                        <span class="ml-3 font-weight-bold text-dark">RPC Construction</span>
                    </div>
                </div>
                <div class="row justify-content-center my-3">
                    <div class="col-8">
                        <h2>Select a location </h2>
                        <p>to see product availability and delivery options</p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-6 justify-content-center">
                        <a href="{{url('/')}}/social/auth/google"><button type="button" class="btn btn-info btn-block rounded">Sign in to select address</button></a>

                        {{-- <input type="button" class="btn btn-warning" value="Submit" id="btnCurrentPincode"> --}}
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-4">
                        <h5 class="text-center my-3">or</h5>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-8 newsletter-popup-content" id="divLocationInputs">
                        <div class="input-group">
                            <input type="text" class="form-control" id="txtCurrentPincode" placeholder="Enter your pincode" required>
                            <input type="button" class="btn btn-warning" value="Submit" id="btnCurrentPincode">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <img src="{{url('/')}}/home/assets/images/location-pop-up/MapAnime.gif" alt="">
            </div>
        </div>
        <button title="Close (Esc)" type="button" class="mfp-close" id="modal-close-btn">×</button>
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
    <script>
         $(document).ready(function() {
             $('.redirectLogin').on('click', function(){
                 window.location.replace($('#loginBtn').attr('href'));
             });
        });
    </script>
</body>

</html>
