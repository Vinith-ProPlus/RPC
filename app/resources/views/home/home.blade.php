@extends('home.home-layout')
@section('content')

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
            <ul id="homeBannerList">
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
            @foreach($steppers as $index => $stepper)
                <div class="col-sm-4">
                    <div class="row d-flex justify-content-center align-items-center m-4">
                        <div class="circle">{{ $index + 1 }}</div>
                        <div class="step">{{ $stepper->StepperTitle }}</div>
                    </div>
                    <img loading="lazy" src="{{ $stepper->StepperImage }}" alt="Step {{ $index + 1 }}" height="176px" width="418px">
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="category-section container">
    <div class="d-lg-flex align-items-center appear-animate" data-animation-name="fadeInLeftShorter">
        <h2 class="title title-underline divider">Shop Categories</h2>
        <a href="{{ route('products.customer.categoriesList') }}" class="sicon-title">VIEW CATEGORIES<i class="fas fa-arrow-right"></i></a>
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
{{--    @for ($i = 0; $i < 4; $i++)--}}
{{--        @php--}}
{{--            $category = $PCategories[$i];--}}
{{--        @endphp--}}
{{--        <div class="product-category">--}}
{{--            <a href="#">--}}
{{--                <figure>--}}
{{--                    <img loading="lazy" src="{{ file_exists($category->ThumbnailImg)? url('/'.$category->ThumbnailImg):$category->PCImage }}" alt="{{ $category->PCName }}" width="25" height="25">--}}
{{--                </figure>--}}
{{--            </a>--}}
{{--            <div class="category-content">--}}
{{--                <h3 class="category-title">{{ $category->PCName }}</h3>--}}
{{--                <ul class="sub-categories">--}}
{{--                    @foreach ($category->PSCData as $subCategory)--}}
{{--                        @if ($loop->index < 4)--}}
{{--                            <li><a href="#">{{ $subCategory->PSCName }}</a></li>--}}
{{--                        @endif--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endfor--}}

        @foreach ($PCategories->take(4) as $category)
            <div class="product-category">
                <a href="{{ route('products.customer.subCategoryList', ['CID' => $category->PCID]) }}">
                    <figure>
                        <img loading="lazy" src="{{ file_exists($category->ThumbnailImg)? url('/'.$category->ThumbnailImg):$category->PCImage }}" alt="{{ $category->PCName }}" width="25" height="25">
                    </figure>
                </a>
                <div class="category-content">
                    <h3 class="category-title">{{ $category->PCName }}</h3>
{{--                    <ul class="sub-categories">--}}
{{--                        @foreach ($category->PSCData->take(4) as $subCategory)--}}
{{--                            <li><a href="{{ route('products.customer.productsList', ['SCID' => $subCategory->PSCID]) }}">{{ $subCategory->PSCName }}</a></li>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
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
                <div class="product-default inner-quickview inner-icon product-div">
                    <figure>
                        <a href="{{ route('customer.product.view', $hotProduct->ProductID) }}">
                            <img loading="lazy" src="{{ file_exists($hotProduct->ThumbnailImg)?url('/'.$hotProduct->ThumbnailImg):$hotProduct->ProductImage }}" width="300" height="300" alt="product">
                        </a>
                        <div class="label-group">
                            {{-- <span class="product-label label-sale">-13%</span> --}}
                        </div>
                        <div class="btn-icon-group">
                            <a href="#" class="btn-icon btn-add-cart product-type-simple btnAddCart" id="{{$hotProduct->ProductID}}"><i
                                    class="icon-shopping-cart"></i></a>
                        </div>
                        <a href="{{ route('products.quickView', $hotProduct->ProductID) }}" class="btn-quickview" title="Quick View">Quick View</a>
                    </figure>
                    <div class="product-details">
                        <div class="category-wrap">
                            <div class="category-list">
                                <a href="{{ route('products.customer.productsList', ['SCID' => $hotProduct->PSCID]) }}">{{ $hotProduct->PSCName }}</a>
                            </div>
                            {{--                        <a href="#" class="btn-icon-wish {{ $hotProduct->IsInWishlist ? 'added-wishlist' : '' }}" title="wishlist"><i class="icon-heart"></i></a>--}}
                        </div>
                        <h3 class="product-title">
                            <a href="{{ route('customer.product.view', $hotProduct->ProductID) }}">{{ $hotProduct->ProductName }}</a>
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
                <h4 class="text-white text-uppercase">looking for help to
                    find construction materials?</h4>
                <h2 class="text-white">Best raw materials providers</h2>
                <h3>Call Us or Drop Us a Message Through Our Contact Form</h3>
            </div>
            <div class="col-lg-5 call-action">
                <div class="d-inline-flex align-items-center text-left divider">
                    <i class="icon-phone-1 text-white mr-2"></i>
                    <h6 class="pt-1 line-height-1 text-uppercase text-white">Call us now<a href="tel:{{ $Company['Phone-Number'] ?? ($Company['Mobile-Number'] ?? '') }}"
                            class="d-block text-white ls-10 pt-2">+91 {{ $Company['Phone-Number'] ?? ($Company['Mobile-Number'] ?? '') }}</a></h6>
                </div>
                <a href="sms:91{{ $Company['Phone-Number'] ?? ($Company['Mobile-Number'] ?? '') }}" class="btn btn-borders btn-rounded btn-outline-white ls-25">Send Us a
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
            @foreach ($RecentProducts->shuffle()->take(6) as $recentProduct)
                <div class="product-default inner-quickview inner-icon product-div">
                    <figure>
                        <a href="{{ route('customer.product.view', $recentProduct->ProductID) }}">
                            <img loading="lazy" src="{{ file_exists($recentProduct->ThumbnailImg)?url('/'.$recentProduct->ThumbnailImg):$recentProduct->ProductImage }}" width="300" height="300" alt="product">
                        </a>
                        <div class="label-group">
                            {{-- <span class="product-label label-sale">-13%</span> --}}
                        </div>
                        <div class="btn-icon-group">
                            <a href="#" class="btn-icon btn-add-cart product-type-simple btnAddCart" id="{{ $recentProduct->ProductID }}"><i
                                    class="icon-shopping-cart"></i></a>
                        </div>
                        <a href="{{ route('products.quickView', $recentProduct->ProductID) }}" class="btn-quickview" title="Quick View">Quick View</a>
                    </figure>
                    <div class="product-details">
                        <div class="category-wrap">
                            <div class="category-list">
                                <a href="{{ route('products.customer.productsList', ['SCID' => $recentProduct->PSCID]) }}">{{ $recentProduct->PSCName }}</a>
                            </div>
                            {{--                    <a href="#" class="btn-icon-wish {{ $recentProduct->IsInWishlist ? 'added-wishlist' : '' }}" title="wishlist"><i class="icon-heart"></i></a>--}}
                        </div>
                        <h3 class="product-title">
                            <a href="{{ route('customer.product.view', $recentProduct->ProductID) }}">{{ $recentProduct->ProductName }}</a>
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
            <ul class="list-unstyled mb-0">
                <h4>Popular Categories:</h4>
                <br>
                @foreach ($PCategories->shuffle()->take(4) as $category)
                    <li>
                        <a href="{{ route('products.customer.subCategoryList', ['CID' => $category->PCID]) }}">{{ $category->PCName }}</a>
                    </li>
                @endforeach
                <li><a class="show-action" href="{{ route('products.customer.categoriesList') }}">Show All</a></li>
            </ul>
        </div>
        <div class="col-md-4 part-item appear-animate" data-animation-name="fadeInLeftShorter"
            data-animation-delay="200">
            <ul class="list-unstyled mb-0">
                <h3>Popular Sub-Categories:</h3>
                <br>
                @foreach ($PCategories->shuffle()->take(4) as $category)
                    <li>
                        <a href="{{ route('products.customer.subCategoryList', ['CID' => $category->PCID]) }}">{{ $category->PCName }}</a>
                    </li>
                @endforeach
                <li><a class="show-action" href="{{ route('products.customer.categoriesList') }}">Show All</a></li>
            </ul>
        </div>
        <div class="col-md-4 part-item appear-animate" data-animation-name="fadeInLeftShorter"
            data-animation-delay="400">
            <ul class="list-unstyled mb-0">
                <h3>Popular Products:</h3>
                <br>
                @foreach ($PCategories->shuffle()->take(4) as $category)
                    <li>
                        <a href="{{ route('products.customer.subCategoryList', ['CID' => $category->PCID]) }}">{{ $category->PCName }}</a>
                    </li>
                @endforeach
                <li><a class="show-action" href="{{ route('products.customer.categoriesList') }}">Show All</a></li>
            </ul>
        </div>

    </div>
</section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){

            var bannerCurrentIndex = 0;
            var totalBannerSlides = $('#homeBannerList li').length;

            function showNextSlide() {
                bannerCurrentIndex = (bannerCurrentIndex + 1) % totalBannerSlides;
                $('#homeBannerList li').eq(bannerCurrentIndex).click();
            }

            setInterval(showNextSlide, 5000);
        });
    </script>
@endsection
