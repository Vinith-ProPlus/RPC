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
                    <select name="orderby" class="form-control" id="orderOrderBySelect">
                        <option value="">Default sorting</option>
                        <option value="desc" {{ ($orderBy=='desc') ? 'selected' : '' }}>Sort by newness</option>
                        <option value="asc" {{ ($orderBy=='asc') ? 'selected' : '' }}>Sort by oldest
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <div class="toolbox-right">
            <div class="toolbox-item toolbox-show">
                <label for="orderProductCountSelect">Show:</label>
                <div class="select-custom">
                    <select name="count" class="form-control" id="orderProductCountSelect">
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

<table class="table table-wishlist mb-0" id="ordersTable">
    <thead>
    <tr>
        <th class="status-col">Order No</th>
        <th class="status-col">Order Date</th>
        <th class="action-col">Expected Delivery Date</th>
        <th class="action-col">Status</th>
{{--        <th class="action-col">PaymentStatus</th>--}}
        <th class="action-col">Action</th>
    </tr>
    </thead>
    <tbody>
    @if(count($orderDetails) > 0)
        @foreach($orderDetails as $orderDetail)
            <tr class="product-row product-div">
                <td>{{ $orderDetail->OrderNo }}</td>
                <td>{{ $orderDetail->OrderDate }}</td>
                <td>{{ $orderDetail->ExpectedDelivery }}</td>
                <td>{{ $orderDetail->Status }}</td>
{{--                <td>{{ $orderDetail->PaymentStatus }}</td>--}}
                <td class="d-flex">
                    <button class="btn btn-dark product-type-simple btnOrderView mr-2" data-id="{{ $orderDetail->OrderID }}" title="View order">
                        VIEW
                    </button>
                    <button class="btn btn-dark product-type-simple {{ ($orderDetail->Status == "Delivered" && $orderDetail->isRated == "0") ? 'btnOrderReview' : 'disabled' }}"
                            data-id="{{ $orderDetail->OrderID }}"
                            title="{{ ($orderDetail->Status == "Delivered" && $orderDetail->isRated == "0") ? 'Rate Order' : (($orderDetail->Status != "Delivered") ? 'Product not delivered fully' : 'Already Rated') }}"
                    >
                        Review
                    </button>
                </td>
            </tr>
        @endforeach
    @else
        <tr class="product-row product-div">
            <td colspan="6" style="text-align: center !important;">Order is Empty!</td>
        </tr>
    @endif
    </tbody>
</table>

<nav class="toolbox toolbox-pagination">
    <div class="toolbox-item toolbox-show">
        <label for="orderProductCountSelect2">Show:</label>
        <div class="select-custom">
            <select name="count" class="form-control" id="orderProductCountSelect2">
                <option value="12" {{ ($productCount == '12') ? 'selected' : '' }}>12</option>
                <option value="24" {{ ($productCount == '24') ? 'selected' : '' }}>24</option>
                <option value="36" {{ ($productCount == '36') ? 'selected' : '' }}>36</option>
            </select>
        </div>
    </div>
    <ul class="pagination toolbox-item">
        <li class="page-item {{ ($pageNo == 1) ? 'disabled' : '' }}">
            <a class="page-link page-link-btn orderPrevPage" href="#"><i class="icon-angle-left"></i></a>
        </li>
        @php
            $start = max(1, $pageNo - $range);
            $end = min($totalPages, $pageNo + $range);
        @endphp
        @if ($start > 1)
            <li class="page-item"><a class="page-link orderChangePage" href="#" data-page-no="1">1</a></li>
            @if ($start > 2)
                <li class="page-item"><span class="page-link">...</span></li>
            @endif
        @endif

        @for ($i = $start; $i <= $end; $i++)
            <li class="page-item {{ ($i == $pageNo) ? 'active' : '' }}">
                <a class="page-link {{ ($i == $pageNo) ? '' : 'orderChangePage' }}" href="#"
                   data-page-no="{{ $i }}">{{ $i }}</a>
            </li>
        @endfor

        @if ($end < $totalPages)
            @if ($end < $totalPages - 1)
                <li class="page-item"><span class="page-link">...</span></li>
            @endif
            <li class="page-item"><a class="page-link orderChangePage" href="#"
                                     data-page-no="{{ $totalPages }}">{{ $totalPages }}</a></li>
        @endif

        <li class="page-item {{ ($pageNo == $totalPages) ? 'disabled' : '' }}">
            <a class="page-link page-link-btn orderNextPage" href="#"><i class="icon-angle-right"></i></a>
        </li>
    </ul>
</nav>

