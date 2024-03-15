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
        <div class="home-slide banner" style="background-image: url('{{url('/')}}/home/assets/images/slider/post-4.jpg');">
            <div class="banner-layer banner-layer-middle">
                <div class="container banner-content">
                    <h2 class="font1 font-weight-normal text-uppercase mb-0 appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="200">
                    </h2>
                    <h1 class="font1 font-weight-bold text-uppercase appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="500">
                        
                    </h1>
                    <h2 class="font1 font-weight-normal text-uppercase mb-3 appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="800">
                        </h2>
                    {{-- <a class="btn btn-dark btn-buy appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="1100" href="#"></a> --}}
                </div>
            </div>
        </div>

        <div class="home-slide banner" style="background-image: url('{{url('/')}}/home/assets/images/slider/post-5.jpg');">
            {{-- <div class="home-slide banner" style="background-image: url('{{ file_exists(public_path('/assets/home/images/demoes/demo21/slider/slide3.jpg')) ? asset('/assets/home/images/demoes/demo21/slider/slide3.jpg') : asset('/assets/images/no-image-b.png') }}');"> --}}
            <div class="banner-layer banner-layer-middle">
                <div class="container banner-content">
                    <h2 class="font1 font-weight-normal text-uppercase mb-0 appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="200">we are hiring</h2>
                    <h1 class="font1 font-weight-bold text-uppercase appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="500">
                        talents
                    </h1>
                    <h2 class="font1 font-weight-normal text-uppercase mb-3 appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="800">for
                        <strong>Service Engineer</strong></h2>
                    <a class="btn btn-dark btn-buy appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="1100" href="#">APPLY NOW</a>
                </div>
            </div>
        </div>

        <div class="home-slide banner" style="background-image: url('{{url('/')}}/home/assets/images/slider/post-6.jpg');">
            <div class="banner-layer banner-layer-middle">
                <div class="container banner-content">
                    <h2 class="font1 font-weight-normal text-uppercase mb-0 appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="200">to promote your business
                    </h2>
                    <h1 class="font1 font-weight-bold text-uppercase appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="500">
                        Advertise here
                    </h1>
                    {{-- <h2 class="font1 font-weight-normal text-uppercase mb-3 appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="800">from
                        <strong>$19</strong></h2> --}}
                    <a class="btn btn-dark btn-buy appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="1100" href="#">Contact Us</a>
                </div>
            </div>
        </div>
    </div>

    <div class="home-slider-sidebar d-none d-sm-block">
        <div class="container">
            <ul>
                <li class="active">Why Us</li>
                <li>New Updates</li>
                <li>Advertise Here</li>
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
        <a href="demo42-shop.html" class="sicon-title">VIEW CATEGORIES<i class="fas fa-arrow-right"></i></a>
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
    @for ($i = 0; $i < 4; $i++)
        @php
            $category = $PCategories[$i];
        @endphp
        <div class="product-category">
            <a href="#">
                <figure>
                    <img src="{{ $category->PCImage }}" alt="{{ $category->PCName }}" width="25" height="25">
                </figure>
            </a>
            <div class="category-content">
                <h3 class="category-title">{{ $category->PCName }}</h3>
                <ul class="sub-categories">
                    @foreach ($category->PSCData as $subCategory)
                        @if ($loop->index < 4)
                            <li><a href="#">{{ $subCategory->PSCName }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    @endfor

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
                        <a href="#" class="btn-icon btn-add-cart product-type-simple btnAddCart" id="{{$hotProduct->ProductID}}"><i
                                class="icon-shopping-cart"></i></a>
                    </div>
                    <a href="#" class="btn-quickview" title="Quick View">Quick View</a>
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
        <path fill="#f26100"
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
                    <a href="#" class="btn-icon btn-add-cart product-type-simple btnAddCart" id="{{$hotProduct->ProductID}}"><i
                            class="icon-shopping-cart"></i></a>
                </div>
                <a href="#" class="btn-quickview" title="Quick View">Quick View</a>
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
                @for ($i = 0; $i < 4; $i++)
                    @php
                        $category = $PCategories[$i];
                    @endphp
                    <li><a href="#">{{$category->PCName}}</a></li>
                @endfor
                <li><a class="show-action" href="#">Show All</a></li>
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
                <li><a class="show-action" href="#">Show All</a></li>
            </ul>
        </div>
        <div class="col-md-4 part-item appear-animate" data-animation-name="fadeInLeftShorter"
            data-animation-delay="400">
            <h3>Popular Products:</h3>
            <ul class="list-unstyled mb-0">
                @for ($i = 0; $i < 4; $i++)
                    @php
                        $hotProducts = $HotProducts[$i];
                    @endphp
                    <li><a href="#">{{$hotProducts->ProductName}}</a></li>
                @endfor
                <li><a class="show-action" href="#">Show All</a></li>
            </ul>
        </div>

    </div>
</section>  
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){

            

        });
    </script>
@endsection
