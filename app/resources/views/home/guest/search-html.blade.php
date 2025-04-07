@foreach($PCategories as $PCategory)
    <a href="{{ route('products.guest.subCategoryList', [ 'CID' => $PCategory->PCID ]) }}" class="d-flex align-items-center mb-2 text-decoration-none text-dark">
        <img loading="lazy" src="{{ file_exists($PCategory->ThumbnailImg) ? url('/'.$PCategory->ThumbnailImg) : $PCategory->PCImage }}" alt="{{ $PCategory->PCName }}" class="me-2 rounded" style="width: 40px; height: 40px; object-fit: cover;">
        <span class="ml-3">{{ $PCategory->PCName }}</span>
    </a>
@endforeach
@foreach($PSCategories as $PSCategory)
    <a href="{{ route('products.guest.productsList', ['SCID' => $PSCategory->PSCID]) }}" class="d-flex align-items-center mb-2 text-decoration-none text-dark">
        <img loading="lazy" src="{{ file_exists($PSCategory->ThumbnailImg) ? url('/'.$PSCategory->ThumbnailImg) : $PSCategory->PSCImage }}" alt="{{ $PSCategory->PSCName }}" class="me-2 rounded" style="width: 40px; height: 40px; object-fit: cover;">
        <span class="ml-3">{{ $PSCategory->PSCName }}</span>
    </a>
@endforeach
@foreach($Products as $Product)
    <a href="{{ route('guest.products.quickView', $Product->ProductID) }}" class="d-flex align-items-center mb-2 text-decoration-none text-dark btn-quickview" title="Quick View">
        <img loading="lazy" src="{{ file_exists($Product->ThumbnailImg) ? url('/'.$Product->ThumbnailImg) : $Product->ProductImage }}" alt="{{ $Product->ProductName }}" class="me-2 rounded" style="width: 40px; height: 40px; object-fit: cover;">
        <span class="ml-3">{{ $Product->ProductName }}</span>
    </a>
@endforeach
