<div class="product-single-container product-single-default product-quick-view mb-0 custom-scrollbar">
    <div class="row">
        <div class="col-md-6 product-single-gallery mb-md-0">
            <div class="product-slider-container">
                <div class="product-single-carousel owl-carousel owl-theme show-nav-hover">
                    <div class="product-item">
                        <img loading="lazy" class="product-single-image" src="{{ $product->ProductImage }}"
                             data-zoom-image="{{ $product->ProductImage }}"/>
                    </div>
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
                    <a href="#" class="btn btn-dark add-cart mr-2 redirectLogin" title="Add to Cart" id="{{ $product->ProductID }}">Add to Cart</a>
                </div><!-- End .product-action -->

{{--                <hr class="divider mb-0 mt-0">--}}

{{--                <div class="product-single-share mb-0">--}}
{{--                    <a href="#" class="guest-btn-icon-wish redirectLogin add-wishlist" title="Add to Wishlist"><i--}}
{{--                            class="icon-wishlist-2"></i><span>Add to Wishlist</span></a>--}}
{{--                </div>--}}
            </div>
        </div>

        <button title="Close (Esc)" type="button" class="mfp-close">
            ×
        </button>
    </div><!-- End .row -->
</div><!-- End .product-single-container -->
<script>
    $(document).ready(function () {
        $('.prod-thumbnail .owl-stage-outer .owl-stage').each(function () {
            var existingStyle = $(this).attr('style');
            var updatedStyle = existingStyle.replace(/width:[^;]*/i, 'width: 1500px !important');
            $(this).attr('style', updatedStyle);
        });

        $('.redirectLogin').on('click', function () {
            window.location.replace($('#loginBtn').attr('href'));
        });
    });
</script>
