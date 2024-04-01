<div class="product-single-container product-single-default product-quick-view mb-0 custom-scrollbar">
    <div class="row">
        <div class="col-md-6 product-single-gallery mb-md-0">
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
                    <a href="#" class="btn btn-dark mr-2 product-type-simple btn-shop {{ $cartProducts->contains('ProductID', $product->ProductID) ? 'added-in-cart' : 'wishlistCartBtn btnAddCart' }}" title="Add to Cart" id="{{ $product->ProductID }}">
                        {{ $cartProducts->contains('ProductID', $product->ProductID) ? 'Added in Cart' : 'ADD TO CART' }}
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
</div><!-- End .product-single-container -->
<script>
    $(document).ready(function(){
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
