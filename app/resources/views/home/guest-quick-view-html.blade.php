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
            <div class="prod-thumbnail product-owl-gallery owl-dots">
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
                        <span class="ratings" style="width:100%"></span>
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
                    <div class="row col-12">
                        <div class="col-6">
                            <a href="#" class="btn btn-dark add-cart mr-2" onclick="$('#loginBtn').click();" title="Add to Cart" id="{{ $product->ProductID }}">Add to Cart</a>
                        </div>
                        @if($product->ProductBrochure)
                            <div class="col-6 text-right">
                                <a href="{{ $product->ProductBrochure }}" class="btn btn-dark" target="new">
                                    View Brochure
                                </a>
                            </div>
                        @endif
                        <div class="col-12 my-2">
                            <a href="#" class="btn btn-block btn-dark mr-2" onclick="$('#loginBtn').click();" title="Buy Now" id="{{ $product->ProductID }}">Buy Now</a>
                        </div>
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
    $(document).ready(function () {
        $('.product-quick-view').on('click', function(event) {
            event.stopPropagation();
        });
        $('.mfp-close').on('click', function() {
            $('.product-quick-view').magnificPopup('close');
        });
        $('.prod-thumbnail .owl-stage-outer .owl-stage').each(function () {
            var existingStyle = $(this).attr('style');
            var updatedStyle = existingStyle.replace(/width:[^;]*/i, 'width: 1500px !important');
            $(this).attr('style', updatedStyle);
        });

        $('.redirectLogin').on('click', function () {
            $('.openLoginModal').click();
        });
    });
</script>
