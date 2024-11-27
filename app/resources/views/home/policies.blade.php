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
{{--            <h6>- 15% OFF in All Construction Materials -</h6>--}}

{{--            <a href="{{ route('products') }}" class="ml-2">Shop Now</a>--}}
{{--        </div>--}}
{{--    </div>--}}

    <header class="header">
        <div class="header-top">
            <div class="container">
                {{-- @if(!$isRegister)
                    <div class="header-left d-md-block">
                        <div class="info-box info-box-icon-left text-primary justify-content-start p-0">
                            <i class="icon-location" style="color:#ff6840;"></i>
                            <h6 class="font-weight-bold text-dark">Delivery Location - </h6>
                            <span><a href="#" class="text-dark">45,Eden Garden, R.S.Puram, 3rd Cross, Coimbatore. 641006</a></span>
                            <i class="fa fa-arrow"></i>
                        </div>
                    </div>
                    <div class="header-dropdown ">
                        <a href="#"></a>
                        <div class="header-menu">
                            <ul>
                                <li>45, Eden Garden, Ganapathy, Coimbatore. 641006</li>
                                <li><a href="#">R.S.Puram, 3rd Cross, Coimbatore. 641003</a></li>
                            </ul>
                        </div>
                    </div>
                @endif --}}
                @if(!$isRegister)
                    <div class="header-left d-md-block">
                        <div class="align-middle" style="display: inline-block;">
                            <div class="info-box info-box-icon-left justify-content-start">
                                <i class="icon-location" style="color:#ff6840;"></i>
                                <div class="align-middle" style="display: inline-block; height: 20px; vertical-align: middle !important;">
                                    <h6 class="font-weight-bold text-dark" style="line-height: 18px;"><span class="delivery-location-sm-hide">Delivery Location - &nbsp;</span> {{ $PostalCode ?? ''}}
                                        @if(isset($PostalCode))
                                                <span id="btnClearPincode" class="px-3">
                                                    <i class="fas fa-times text-danger" style="font-size: 12px;"></i>
                                                </span>
                                        @endif
                                    </h6>
                                </div>
                            </div>
                        </div>


                        <div class="header-dropdown px-3" style="display: inline-block; margin-left:0">
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
                                        <li><a href="#" data-postal-id="{{ $item->PostalCodeID }}" data-aid="{{ $item->AID }}" data-latitude="{{ $key.'11.048274' }}" data-longitude="{{ $key.'76.9885352' }}">
                                                {{ $item->Address }}, {{ $item->CityName }}
                                                , {{ $item->TalukName }}, {{ $item->DistrictName }}
                                                , {{ $item->StateName }},{{ $item->CountryName }}
                                                - {{ $item->PostalCode }}.</a></li>
                                    @endforeach
                                        <li class="text-center"><a href="#" style="background-color: #2e578f; color: white;" class="addressAddHeaderBtn btnAddAddress">Add Address</a></li>
                                </ul>
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
{{--                        <li>--}}
{{--                            <a href="{{url('/')}}/social/auth/google" style="font-size: 12px;"><i--}}
{{--                                    class="icon-help-circle" style="font-size: 18px;"></i>&nbsp;Help</a>--}}
{{--                        </li>--}}
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
{{--                    <a href="@if($isRegister && !$isEdit) {{ url('/') }} @else {{ url('/') }}/customer-home @endif" class="logo">--}}
                    <a href="{{ url('/') }}" class="logo">
                        <img loading="lazy" src="{{url('/')}}/{{$Company['Logo']}}" width="50" height="50" alt="{{$Company['CompanyName']}}">
                    </a>
                    <span class="ml-3 font-weight-bold" style="color:rgb(7, 54, 163)">{{$Company['CompanyName']}}</span>
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

                    @if($isRegister)
                        <a href="#" class="d-lg-block d-none openLoginModal" id="loginBtn">
                            <div class="header-user">
                                <div class="header-userinfo">
                                    <span>Welcome</span>
                                    <h4>Sign In / Register</h4>
                                </div>
                            </div>
                        </a>
                    @else
                        <a href="{{url('/')}}/customer-profile" class="d-lg-block d-none">
                            <div class="header-user">
                                <i class="icon-user-2"></i>
                            </div>
                        </a>
                    @endif

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
                                                        <a href="#">{{$item->ProductName}}</a>
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
                                                    <a href="{{url('/')}}" class="product-image">
                                                        <img loading="lazy" src="{{ file_exists($item->ThumbnailImg)? url('/'.$item->ThumbnailImg): $item->ProductImage}}" alt="product" width="80" height="80">
                                                    </a>
                                                    <a href="#" class="btn-remove btnRemoveCart" title="Remove Product" id="{{$item->ProductID}}"><span>×</span></a>
                                                </figure>
                                            </div>
                                        @endforeach
                                    @else
                                        <span>Your Cart is Empty!</span>
                                    @endif
                                </div>

                                <div class="dropdown-cart-action" id="divCartAction">
                                    @if(count($Cart) > 0)
                                        <a href="{{url('/')}}/checkout" class="btn btn-secondary btn-block">Request Quote</a>
                                    @else
                                        <a href="{{ auth()->check() ? route('products.customer.productsList') : route('products.guest.productsList') }}" class="btn btn-dark btn-block">Add to Cart</a>
                                    @endif
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
                    <ul class="menu w-100" id="customerNavigationBar">
                        <li class="menu-item d-flex align-items-center">
                            <a href="#" class="d-inline-flex align-items-center sf-with-ul">
                                <i class="custom-icon-toggle-menu d-inline-table"></i><span>All
                                        Categories</span></a>
                            <div class="menu-depart">
                                @foreach ($PCategories->take(5) as $row)
                                    <a href="{{ route('products.guest.subCategoryList', [ 'CID' => $row->PCID ]) }}">{{$row->PCName}}</a>
                                @endforeach
                                    <div style="text-align: center; display: flex; justify-content: center; align-items: center;">
                                        <a href="{{ auth()->check() ? route('products.customer.categoriesList') : route('products.guest.categoriesList') }}" class="text-center">More</a>
                                    </div>
                            </div>
                        </li>
                        <li class="">
                            <a href="{{ route('homepage') }}">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('products') }}">Products</a>
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
                                                    <li><a href="{{ auth()->check() ? route('products.customer.subCategoryList', ['CID' => $category->PCID]) : route('products.guest.subCategoryList', ['CID' => $category->PCID]) }}">{{ $category->PCName }}</a></li>
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
                        </li>
                        @if(auth()->check() && !$isRegister)
                            <li>
                                <a href="{{ route('my-account') }}">My Account</a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div><!-- End .container -->
        </div><!-- End .header-bottom -->
    </header><!-- End .header -->

    <main class="main">
        <section class="product-section1" style="background-color: #f4f4f4;">
            <div class="container">
                <iframe id="contentFrame" src="{{ route('policiesContent', $Slug) }}" style="width: 100%; min-height: 200px; overflow: hidden;" frameborder="0"></iframe>
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

<div class="mobile-menu-overlay"></div>

<div class="sticky-navbar">
        <div class="sticky-info">
            <a href="{{ route('homepage') }}">
                <i class="icon-home"></i>Home
            </a>
        </div>
        <div class="sticky-info">
            <a href="{{ auth()->check() ? route('products.customer.categoriesList') : route('products.guest.categoriesList') }}" class="">
                <i class="icon-bars"></i>Categories
            </a>
        </div>
        <div class="sticky-info">
            <a href="{{ auth()->check() ? url('/customer-profile') : '#' }} " class="" onclick="$('#loginBtn').click();">
                <i class="icon-user-2"></i>Account
            </a>
        </div>
        <div class="sticky-info">
            <a href="{{ auth()->check() ? route('products.customer.productsList') : route('products.guest.productsList') }}" class="">
                <i class="icon-category-saddle"></i>Products
            </a>
        </div>
        <div class="sticky-info">
            <a href="#" title="Cart" class="dropdown-toggle dropdown-arrow cart-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                <i class="icon-shopping-cart position-relative"></i>Cart
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

<div class="newsletter-popup mfp-hide modal-sm bg-img p-0 h-auto" id="guest-login-form" style="background: #f1f1f1 no-repeat center/cover">
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
    $(document).ready(function () {
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

        function adjustIframeHeight() {
            var iframe = document.getElementById('contentFrame');
            var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
            var body = iframeDocument.querySelector('body');
            iframe.style.height = (body.scrollHeight+10) + 'px';
        }

        // Adjust iframe height after content is loaded
        window.addEventListener('load', adjustIframeHeight);
        // Also adjust iframe height when the window is resized
        window.addEventListener('resize', adjustIframeHeight);

        $('.redirectLogin').on('click', function(){
            $('#loginBtn').click();
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
                            if("{{ Route::currentRouteName() }}" !== "customer-profile"){
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

@yield('scripts')

</body>

</html>
