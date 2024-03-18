<ul class="cat-list">
    @foreach ($categories as $category)
            @php
            $totalProductCount = $category->PSCData->reduce(function ($carry, $subcategory) {
                return $carry + count($subcategory->ProductData);
            }, 0);
            @endphp
        <li>
            <a href="#widget-category-{{ $category->PCID }}" data-toggle="collapse" role="button" aria-expanded="true"
               aria-controls="widget-category-{{ $category->PCID }}">
                {{ $category->PCName }}<span class="products-count">({{ $totalProductCount }})</span>
                <span class="toggle"></span>
            </a>
            <div class="collapse show" id="widget-category-{{ $category->PCID }}">
                @foreach ($category->PSCData as $subcategory)
                        @php $subcategoryProductCount = count($subcategory->ProductData); @endphp
                    <ul class="cat-sublist">
                        <li>
                            <a href="#" class="sub-category" data-sub-category-id="{{ $subcategory->PSCID }}">
                                {{ $subcategory->PSCName }}<span class="products-count">({{ $subcategoryProductCount }})</span>
                            </a>
                        </li>
                    </ul>
                @endforeach
            </div>
        </li>
    @endforeach
</ul>
