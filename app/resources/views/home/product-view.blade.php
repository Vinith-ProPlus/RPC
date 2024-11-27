@extends('home.home-layout')
@section('content')
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
                            <img loading="lazy" class="product-single-image" src="{{ $product->ProductImage }}" data-zoom-image="{{ $product->ProductImage }}"/>
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
                                     data-zoom-image="{{ $galleryImage }}"/>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="prod-thumbnail owl-dots">
                    <div class="owl-dot">
                        <img loading="lazy" src="{{ $product->ProductImage }}"/>
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
                            <img loading="lazy" src="{{ $galleryImage }}"/>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-7">
                <div class="product-single-details mb-0 ml-md-4 product-div">
                    <h1 class="product-title"> {{ $product->ProductName }}</h1>

                    <div class="ratings-container">
                        <div class="product-ratings">
                            <span class="ratings" style="width:100%"></span>
                        </div>
                    </div>

                    <hr class="short-divider">
                    <div class="product-desc">
{{--                        <iframe id="productIFrame" src="{{ route('productShortDescription', $product->ProductID) }}" style="width: 100%; min-height: 200px; overflow: hidden;" frameborder="0"></iframe>--}}
                        {!! $product->ShortDescription !!}
                    </div>

                    <ul class="single-info-list">
                        <li>
                            CATEGORY:
                            <strong>
                                <a href="{{ route('products.customer.subCategoryList', ['CID' => $product->PCID]) }}" class="product-category">{{ $product->CategoryName }}</a>
                            </strong>
                        </li>
                        <li>
                            SUB CATEGORY:
                            <strong>
                                <a href="{{ route('products.customer.productsList', ['SCID' => $product->PSCID]) }}" class="product-category">{{ $product->SubCategoryName }}</a>
                            </strong>
                        </li>
                    </ul>

                    <div class="product-action">
                        <div class="row col-12">
                            <div class="col-8">
                                <a href="#"
                                   class="btn btn-dark mr-2 product-type-simple btn-shop {{ $cartProducts->contains('ProductID', $product->ProductID) ? 'added-in-cart' : 'wishlistCartBtn btnAddCart' }}"
                                   title="Add to Cart" id="{{ $product->ProductID }}">
                                    {{ $cartProducts->contains('ProductID', $product->ProductID) ? 'Added in Cart' : 'ADD TO CART' }}
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
                                <a href="{{ route('customer.product.view', $relatedProduct->ProductID) }}">
                                    <img loading="lazy" src="{{ file_exists($relatedProduct->ThumbnailImg)? url('/'.$relatedProduct->ThumbnailImg): $relatedProduct->ProductImage }}" width="300" height="300" alt="product">
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
                                        <a href="{{ route('products.customer.productsList', ['SCID' => $relatedProduct->PSCID]) }}">{{ $relatedProduct->PSCName }}</a>
                                    </div>
                                    {{--                    <a href="#" class="btn-icon-wish {{ $relatedProduct->IsInWishlist ? 'added-wishlist' : '' }}" title="wishlist"><i class="icon-heart"></i></a>--}}
                                </div>
                                <h3 class="product-title">
                                    <a href="{{ route('customer.product.view', $relatedProduct->ProductID) }}">{{ $relatedProduct->ProductName }}</a>
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
@endsection
@section('scripts')
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

            // function adjustIframeHeight() {
            //     var iframe = document.getElementById('productIFrame');
            //     var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
            //     var body = iframeDocument.querySelector('body');
            //     iframe.style.height = (body.scrollHeight+10) + 'px';
            // }
            //
            // // Adjust iframe height after content is loaded
            // window.addEventListener('load', adjustIframeHeight);
            // // Also adjust iframe height when the window is resized
            // window.addEventListener('resize', adjustIframeHeight); function adjustIframeHeight() {
            //     var iframe = document.getElementById('productIFrame');
            //     var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
            //     var body = iframeDocument.querySelector('body');
            //     iframe.style.height = (body.scrollHeight+10) + 'px';
            // }
            //
            // // Adjust iframe height after content is loaded
            // window.addEventListener('load', adjustIframeHeight);
            // // Also adjust iframe height when the window is resized
            // window.addEventListener('resize', adjustIframeHeight);

            var observer = new MutationObserver(function (mutations) {
                mutations.forEach(function (mutation) {
                    if (mutation.attributeName === 'data-selected-postal-id') {
                        LoadProducts();
                    }
                });
            });
            var config = {attributes: true};
            observer.observe(document.getElementById('customerSelectedAddress'), config);
        });
    </script>
@endsection
