<div class="sticky-wrapper">
            <nav class="toolbox sticky-header" data-sticky-options="{`mobile`: true}">
                <div class="toolbox-left">
                    <a href="#" class="sidebar-toggle">
                        <svg data-name="Layer 3" id="Layer_3" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                        </svg>
                        <span>Filter</span>
                    </a>

                    <div class="toolbox-item toolbox-sort">
                        <label>Sort By:</label>
                        <div class="select-custom">
                            <select name="orderby" class="form-control" id="orderBySelect">
                                <option value="">Default sorting</option>
                                <option value="new" {{ ($orderBy=='new') ? 'selected' : '' }}>Sort by newness</option>
                                <option value="popularity" {{ ($orderBy=='popularity') ? 'selected' : '' }}>Sort by popularity</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="toolbox-right">
                    <div class="toolbox-item toolbox-show">
                        <label>Show:</label>
                        <div class="select-custom">
                            <select name="count" class="form-control" id="productCountSelect">
                                <option value="12" {{ ($productCount == '12') ? 'selected' : '' }}>12</option>
                                <option value="24" {{ ($productCount == '24') ? 'selected' : '' }}>24</option>
                                <option value="36" {{ ($productCount == '36') ? 'selected' : '' }}>36</option>
                            </select>
                        </div>
                    </div>

                    <div class="toolbox-item layout-modes">
                        <a href="#" class="layout-btn btn-grid changeView active" title="Grid">
                            <i class="icon-mode-grid"></i>
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        @if(count($PSubCatagories) > 0)
            <div class="row no-gutters">
                @foreach($PSubCatagories as $PSubCatagory)
                    @php $rating = rand(50, 100); @endphp
                    <div class="col-6 col-sm-4 col-lg-3" style="padding: 15px;">
                        <a href="{{ route('products.customer.productsList', ['SCID' => $PSubCatagory->PSCID]) }}">
                            <div class="product-default inner-quickview inner-icon product-div">
                                <figure>
                                    <div class="image-container">
                                        <img src="{{ $PSubCatagory->PSCImage }}" alt="{{ $PSubCatagory->PSCName }}">
                                    </div>
                                    <div class="label-group"></div>
                                </figure>
                                <div class="product-details">
                                    <h3 class="product-title">
                                        <a href="#">{{ $PSubCatagory->PSCName  }}</a>
                                    </h3>
{{--                                    <div class="ratings-container">--}}
{{--                                        <div class="product-ratings">--}}
{{--                                            <span class="ratings" style="width: {{ $rating }}%"></span>--}}
{{--                                            <span class="tooltiptext tooltip-top"></span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <p>No Sub-Category found.</p>
        @endif

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
                        <a class="page-link {{ ($i == $pageNo) ? '' : 'changePage' }}" href="#" data-page-no="{{ $i }}">{{ $i }}</a>
                    </li>
                @endfor

                @if ($end < $totalPages)
                    @if ($end < $totalPages - 1)
                        <li class="page-item"><span class="page-link">...</span></li>
                    @endif
                    <li class="page-item"><a class="page-link changePage" href="#" data-page-no="{{ $totalPages }}">{{ $totalPages }}</a></li>
                @endif

                <li class="page-item {{ ($pageNo == $totalPages) ? 'disabled' : '' }}">
                    <a class="page-link page-link-btn nextPage" href="#"><i class="icon-angle-right"></i></a>
                </li>
            </ul>
        </nav>

