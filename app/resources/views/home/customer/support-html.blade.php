<div class="sticky-wrapper">
    <nav class="toolbox sticky-header" data-sticky-options="{`mobile`: true}">
        <div class="toolbox-left">
            <div class="toolbox-item toolbox-sort">
                <label>Sort By:</label>
                <div class="select-custom">
                    <select name="orderby" class="form-control" id="supportOrderBySelect">
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
                <label for="supportProductCountSelect">Show:</label>
                <div class="select-custom">
                    <select name="count" class="form-control" id="supportProductCountSelect">
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
        <th class="product-col">Subject</th>
        <th class="status-col">Priority</th>
        <th class="action-col">Status</th>
        <th class="action-col">Created On</th>
        <th class="action-col">Action</th>
    </tr>
    </thead>
    <tbody>
    @if(count($supportDetails) > 0)
        @foreach($supportDetails as $supportDetail)
            <tr class="product-row product-div">
                <td>{{ $supportDetail->Subject }}</td>
                <td>{{ $supportDetail->Priority }}</td>
                <td>{{ $supportDetail->Status }}</td>
                <td>{{ $supportDetail->CreatedOn }}</td>
                <td><button class="btn btn-dark product-type-simple btnDetails" id="{{ $supportDetail->SupportID }}">
                        VIEW
                    </button></td>
            </tr>
        @endforeach
    @else
        <tr class="product-row product-div">
            <td colspan="5" style="text-align: center !important;">Support is Empty!</td>
        </tr>
    @endif
    </tbody>
</table>

<nav class="toolbox toolbox-pagination">
    <div class="toolbox-item toolbox-show">
        <label>Show:</label>
        <div class="select-custom">
            <select name="count" class="form-control" id="supportProductCountSelect2">
                <option value="12" {{ ($productCount == '12') ? 'selected' : '' }}>12</option>
                <option value="24" {{ ($productCount == '24') ? 'selected' : '' }}>24</option>
                <option value="36" {{ ($productCount == '36') ? 'selected' : '' }}>36</option>
            </select>
        </div>
    </div>
    <ul class="pagination toolbox-item">
        <li class="page-item {{ ($pageNo == 1) ? 'disabled' : '' }}">
            <a class="page-link page-link-btn supportPrevPage" href="#"><i class="icon-angle-left"></i></a>
        </li>
        @php
            $start = max(1, $pageNo - $range);
            $end = min($totalPages, $pageNo + $range);
        @endphp
        @if ($start > 1)
            <li class="page-item"><a class="page-link supportChangePage" href="#" data-page-no="1">1</a></li>
            @if ($start > 2)
                <li class="page-item"><span class="page-link">...</span></li>
            @endif
        @endif

        @for ($i = $start; $i <= $end; $i++)
            <li class="page-item {{ ($i == $pageNo) ? 'active' : '' }}">
                <a class="page-link {{ ($i == $pageNo) ? '' : 'supportChangePage' }}" href="#"
                   data-page-no="{{ $i }}">{{ $i }}</a>
            </li>
        @endfor

        @if ($end < $totalPages)
            @if ($end < $totalPages - 1)
                <li class="page-item"><span class="page-link">...</span></li>
            @endif
            <li class="page-item"><a class="page-link supportChangePage" href="#"
                                     data-page-no="{{ $totalPages }}">{{ $totalPages }}</a></li>
        @endif

        <li class="page-item {{ ($pageNo == $totalPages) ? 'disabled' : '' }}">
            <a class="page-link page-link-btn supportNextPage" href="#"><i class="icon-angle-right"></i></a>
        </li>
    </ul>
</nav>

