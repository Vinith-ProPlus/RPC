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
                    <select name="orderby" class="form-control" id="quotationOrderBySelect">
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
                <label for="quotationProductCountSelect">Show:</label>
                <div class="select-custom">
                    <select name="count" class="form-control" id="quotationProductCountSelect">
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
{{--        <th class="product-col">EnqNo</th>--}}
        <th class="status-col">Date</th>
        <th class="action-col">Expected Delivery Date</th>
        <th class="action-col">Status</th>
        <th class="action-col">Action</th>
    </tr>
    </thead>
    <tbody>
    @if(count($quotationDetails) > 0)
        @foreach($quotationDetails as $quotationDetail)
            <tr class="product-row product-div">
{{--                <td>{{ $quotationDetail->EnqNo }}</td>--}}
                <td>{{ $quotationDetail->EnqDate }}</td>
                <td>{{ $quotationDetail->ExpectedDeliveryDate }}</td>
                @php
                    $status = $quotationDetail->Status;
                    if($status == "New"){
                        $statusText = "Quote Requested";
                    } elseif ($status == "Converted to Quotation"){
                        $statusText = "Price Updated";
                    } elseif ($status == "Accepted"){
                        $statusText = "Accepted";
                    } elseif ($status == "Rejected"){
                        $statusText = "Rejected";
                    } else {
                        $statusText = "Pending";
                    }
                @endphp
                <td>{{ $statusText }}</td>
                <td><button class="btn btn-dark product-type-simple btnQuoteView" data-id="{{ $quotationDetail->EnqID }}">
                        VIEW
                    </button></td>
            </tr>
        @endforeach
    @else
        <tr class="product-row product-div">
            <td colspan="5" style="text-align: center !important;">Quotation is Empty!</td>
        </tr>
    @endif
    </tbody>
</table>

<nav class="toolbox toolbox-pagination">
    <div class="toolbox-item toolbox-show">
        <label>Show:</label>
        <div class="select-custom">
            <select name="count" class="form-control" id="quotationProductCountSelect2">
                <option value="12" {{ ($productCount == '12') ? 'selected' : '' }}>12</option>
                <option value="24" {{ ($productCount == '24') ? 'selected' : '' }}>24</option>
                <option value="36" {{ ($productCount == '36') ? 'selected' : '' }}>36</option>
            </select>
        </div>
    </div>
    <ul class="pagination toolbox-item">
        <li class="page-item {{ ($pageNo == 1) ? 'disabled' : '' }}">
            <a class="page-link page-link-btn quotationPrevPage" href="#"><i class="icon-angle-left"></i></a>
        </li>
        @php
            $start = max(1, $pageNo - $range);
            $end = min($totalPages, $pageNo + $range);
        @endphp
        @if ($start > 1)
            <li class="page-item"><a class="page-link quotationChangePage" href="#" data-page-no="1">1</a></li>
            @if ($start > 2)
                <li class="page-item"><span class="page-link">...</span></li>
            @endif
        @endif

        @for ($i = $start; $i <= $end; $i++)
            <li class="page-item {{ ($i == $pageNo) ? 'active' : '' }}">
                <a class="page-link {{ ($i == $pageNo) ? '' : 'quotationChangePage' }}" href="#"
                   data-page-no="{{ $i }}">{{ $i }}</a>
            </li>
        @endfor

        @if ($end < $totalPages)
            @if ($end < $totalPages - 1)
                <li class="page-item"><span class="page-link">...</span></li>
            @endif
            <li class="page-item"><a class="page-link quotationChangePage" href="#"
                                     data-page-no="{{ $totalPages }}">{{ $totalPages }}</a></li>
        @endif

        <li class="page-item {{ ($pageNo == $totalPages) ? 'disabled' : '' }}">
            <a class="page-link page-link-btn quotationNextPage" href="#"><i class="icon-angle-right"></i></a>
        </li>
    </ul>
</nav>

