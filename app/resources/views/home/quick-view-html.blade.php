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
<div class="product-single-container product-single-default product-quick-view mb-0 custom-scrollbar">
    <div class="row">
        <div class="col-md-6 product-single-gallery mb-md-0">
            <div class="product-slider-container">
                <div class="product-single-carousel owl-carousel owl-theme show-nav-hover">
                    <div class="product-item">
                        <img loading="lazy" class="product-single-image" src="{{ $product->ProductImage }}"
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
                        <a href="{{ $product->VideoURL }}" target="new">
                            <div class="play-icon youtubeVideoURL">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                     width="48px" height="48px">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                            <img loading="lazy" alt="{{ $product->ProductName }}"
                                 src="https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg"/>
                        </a>
                    </div>
                @endif
                @foreach($product->GalleryImages as $galleryImage)
                    <div class="owl-dot">
                        <img loading="lazy" src="{{ $galleryImage }}"/>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-6">
            <div class="product-single-details mb-0 ml-md-4 product-div">
                <h1 class="product-title"> {{ $product->ProductName }}</h1>

                <div class="ratings-container">
                    <div class="product-ratings">
                        <span class="ratings" style="width:{{ Rand(50,100) }}%"></span>
                    </div>
                </div>

                <hr class="short-divider">
                <div class="product-desc">
                    {!! $product->Description !!}
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
                        <div class="col-6">
                            <a href="#" class="btn btn-dark mr-2 product-type-simple btn-shop {{ $cartProducts->contains('ProductID', $product->ProductID) ? 'added-in-cart' : 'wishlistCartBtn btnAddCart' }}" title="Add to Cart" id="{{ $product->ProductID }}">
                                {{ $cartProducts->contains('ProductID', $product->ProductID) ? 'Added in Cart' : 'ADD TO CART' }}
                            </a>
                            <a href="#" class="btn view-cart d-none">View cart</a>
                        </div>
                        @if($product->ProductBrochure)
                            <div class="col-6 text-right">
                                <a href="{{ $product->ProductBrochure }}" class="btn btn-dark" target="new">
                                    View Brochure
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <button title="Close (Esc)" type="button" class="mfp-close">
            ×
        </button>
    </div><!-- End .row -->
</div><!-- End .product-single-container -->
<script>
    $(document).ready(function(){
        $('.product-quick-view').on('click', function(event) {
            event.stopPropagation();
        });
        $('.prod-thumbnail .owl-stage-outer .owl-stage').each(function() {
            var existingStyle = $(this).attr('style');
            var updatedStyle = existingStyle.replace(/width:[^;]*/i, 'width: 1500px !important');
            $(this).attr('style', updatedStyle);
        });

        $('.add-cart').click(function() {
            $(this).attr('title', "Added to Cart");
            $(this).text("Added to Cart");
        });

        $('.view-cart').click(function() {
            $('.mfp-close').click();
            $('.icon-cart-thick').click();
        });
    });
</script>
