<div class="sticky-wrapper">
    <nav class="toolbox sticky-header" data-sticky-options="{`mobile`: true}">
        <div class="toolbox-left">
            <a href="#" class="sidebar-toggle">
                <svg data-name="Layer 3" id="Layer_3" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <!-- Sidebar toggle SVG content -->
                </svg>
                <span>Filter</span>
            </a>

            <div class="toolbox-item toolbox-sort">
                <label>Sort By:</label>
                <div class="select-custom">
                    <select name="orderby" class="form-control" id="orderBySelect">
                        <option value="">Default sorting</option>
                        <option value="new" {{ ($orderBy=='new') ? 'selected' : '' }}>Sort by newness</option>
                        <option value="popularity" {{ ($orderBy=='popularity') ? 'selected' : '' }}>Sort by popularity
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <div class="toolbox-right">
            <div class="toolbox-item toolbox-show">
                <label for="productCountSelect">Show:</label>
                <div class="select-custom">
                    <select name="count" class="form-control" id="productCountSelect">
                        <option value="12" {{ ($productCount == '12') ? 'selected' : '' }}>12</option>
                        <option value="24" {{ ($productCount == '24') ? 'selected' : '' }}>24</option>
                        <option value="36" {{ ($productCount == '36') ? 'selected' : '' }}>36</option>
                    </select>
                </div>
            </div>

            <div class="toolbox-item layout-modes">
                <a href="#" class="layout-btn btn-list active"
                   title="List">
                    <i class="icon-mode-list"></i>
                </a>
            </div>
        </div>
    </nav>
</div>

<table class="table table-wishlist mb-0">
    <thead>
    <tr>
        <th class="thumbnail-col"></th>
        <th class="product-col">Product</th>
        <th class="status-col">Stock Status</th>
        <th class="action-col">Actions</th>
    </tr>
    </thead>
    <tbody>
    @if(count($wishListDetails) > 0)
        @foreach($wishListDetails as $product)
            <tr class="product-row product-div">
                <td>
                    <figure class="product-image-container">
                        <img src="{{ $product->ProductImage }}" alt="product">
                        <a href="#" class="btn-remove icon-cancel btn-icon-wish added-wishlist"
                           title="Remove Product"></a>
                    </figure>
                </td>
                <td>
                    <h5 class="product-title">
                        {{ $product->ProductName }}
                    </h5>
                </td>
                <td>
                    <span class="stock-status">In stock</span>
                </td>
                <td class="action">
                    <a href="{{ route('products.quickView', $product->ProductID) }}"
                       class="btn btn-quickview mt-1 mt-md-0"
                       title="Quick View">Quick
                        View</a>
                    <button
                        class="btn btn-dark product-type-simple btn-shop {{ $cartProducts->contains('ProductID', $product->ProductID) ? 'added-in-cart' : 'wishlistCartBtn btn-add-cart btnAddCart' }}"
                        id="{{ $product->ProductID }}">
                        {{ $cartProducts->contains('ProductID', $product->ProductID) ? 'Added in Cart' : 'ADD TO CART' }}
                    </button>
                </td>
            </tr>
        @endforeach
    @else
        <tr class="product-row product-div">
            <td colspan="4" style="text-align: center !important;">Wishlist is Empty!</td>
        </tr>
    @endif
    </tbody>
</table>


{{--@if(count($productDetails) > 0)--}}
{{--    <div class="row no-gutters">--}}
{{--        @foreach($productDetails as $product)--}}
{{--            @php $rating = rand(50, 100); @endphp--}}
{{--            @if ($viewType == 'Grid')--}}
{{--                <div class="col-6 col-sm-4 col-lg-3">--}}
{{--                    <div class="product-default inner-quickview inner-icon product-div">--}}
{{--                        <figure>--}}
{{--                            <a href="#">--}}
{{--                                <img src="{{ $product->ProductImage }}" width="300" height="300" alt="{{ $product->ProductName }}">--}}
{{--                            </a>--}}
{{--                            <div class="label-group"></div>--}}
{{--                            <div class="btn-icon-group">--}}
{{--                                <a href="#" class="btn-icon btn-add-cart product-type-simple btnAddCart" id="{{ $product->ProductID }}">--}}
{{--                                    <i class="icon-shopping-cart"></i>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <a href="{{ route('products.quickView', $product->ProductID) }}" class="btn-quickview" title="Quick View">Quick View</a>--}}
{{--                        </figure>--}}
{{--                        <div class="product-details">--}}
{{--                            <div class="category-wrap">--}}
{{--                                <div class="category-list">--}}
{{--                                    <a href="#">{{ $product->SubCategoryName }}</a>--}}
{{--                                </div>--}}
{{--                                <a href="#" class="btn-icon-wish {{ $product->IsInWishlist ? 'added-wishlist' : '' }}" title="wishlist">--}}
{{--                                    <i class="icon-heart"></i>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <h3 class="product-title">--}}
{{--                                <a href="#">{{ $product->ProductName }}</a>--}}
{{--                            </h3>--}}
{{--                            <div class="ratings-container">--}}
{{--                                <div class="product-ratings">--}}
{{--                                    <span class="ratings" style="width: {{ $rating }}%"></span>--}}
{{--                                    <span class="tooltiptext tooltip-top"></span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @else--}}
{{--                <div class="col-sm-12 col-6 product-default left-details product-list mb-2 product-div">--}}
{{--                    <figure>--}}
{{--                        <a href="#">--}}
{{--                            <img src="{{ $product->ProductImage }}" width="250" height="250" alt="product">--}}
{{--                        </a>--}}
{{--                    </figure>--}}
{{--                    <div class="product-details">--}}
{{--                        <div class="category-list">--}}
{{--                            <a href="#" class="product-category">{{ $product->SubCategoryName }}</a>--}}
{{--                        </div>--}}
{{--                        <h3 class="product-title"><a href="#"> {{ $product->ProductName }}</a></h3>--}}
{{--                        <div class="ratings-container">--}}
{{--                            <div class="product-ratings">--}}
{{--                                <span class="ratings" style="width:{{ $rating }}%"></span>--}}
{{--                                <span class="tooltiptext tooltip-top"></span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <p class="product-description">{!! $product->Description !!}</p>--}}
{{--                        <div class="price-box"></div>--}}
{{--                        <div class="product-action">--}}
{{--                            <a href="#" class="btn-icon btn-add-cart product-type-simple btnAddCart" id="{{ $product->ProductID }}">--}}
{{--                                <i class="icon-shopping-cart"></i>--}}
{{--                                <span>ADD TO CART</span>--}}
{{--                            </a>--}}
{{--                            <a href="#" class="btn-icon-wish {{ $product->IsInWishlist ? 'added-wishlist' : '' }}" title="wishlist">--}}
{{--                                <i class="icon-heart"></i>--}}
{{--                            </a>--}}
{{--                            <a href="{{ route('products.quickView', $product->ProductID) }}" class="btn-quickview" title="Quick View">--}}
{{--                                <i class="fas fa-external-link-alt"></i>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        @endforeach--}}
{{--    </div>--}}
{{--@else--}}
{{--    <p>No products found.</p>--}}
{{--@endif--}}

<nav class="toolbox toolbox-pagination">
    <div class="toolbox-item toolbox-show">
        <label>Show:</label>
        <div class="select-custom">
            <select name="count" class="form-control" id="productCountSelect2">
                <option value="12" {{ ($productCount == '12') ? 'selected' : '' }}>12</option>
                <option value="24" {{ ($productCount == '24') ? 'selected' : '' }}>24</option>
                <option value="36" {{ ($productCount == '36') ? 'selected' : '' }}>36</option>
            </select>
        </div>
    </div>
    <ul class="pagination toolbox-item">
        <li class="page-item {{ ($pageNo == 1) ? 'disabled' : '' }}">
            <a class="page-link page-link-btn prevPage" href="#"><i class="icon-angle-left"></i></a>
        </li>
        @php
            $start = max(1, $pageNo - $range);
            $end = min($totalPages, $pageNo + $range);
        @endphp
        @if ($start > 1)
            <li class="page-item"><a class="page-link changePage" href="#" data-page-no="1">1</a></li>
            @if ($start > 2)
                <li class="page-item"><span class="page-link">...</span></li>
            @endif
        @endif

        @for ($i = $start; $i <= $end; $i++)
            <li class="page-item {{ ($i == $pageNo) ? 'active' : '' }}">
                <a class="page-link {{ ($i == $pageNo) ? '' : 'changePage' }}" href="#"
                   data-page-no="{{ $i }}">{{ $i }}</a>
            </li>
        @endfor

        @if ($end < $totalPages)
            @if ($end < $totalPages - 1)
                <li class="page-item"><span class="page-link">...</span></li>
            @endif
            <li class="page-item"><a class="page-link changePage" href="#"
                                     data-page-no="{{ $totalPages }}">{{ $totalPages }}</a></li>
        @endif

        <li class="page-item {{ ($pageNo == $totalPages) ? 'disabled' : '' }}">
            <a class="page-link page-link-btn nextPage" href="#"><i class="icon-angle-right"></i></a>
        </li>
    </ul>
</nav>

