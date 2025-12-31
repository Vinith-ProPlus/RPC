@foreach($PCategories as $PCategory)
    <a href="{{ route('products.guest.subCategoryList', [ 'CID' => $PCategory->PCID ]) }}">{{ $PCategory->PCName }}</a>
@endforeach
@foreach($PSCategories as $PSCategory)
    <a href="{{ route('products.guest.productsList', ['SCID' => $PSCategory->PSCID]) }}">{{ $PSCategory->PSCName }}</a>
@endforeach
@foreach($Products as $Product)
    <a href="{{ route('guest.products.quickView', $Product->ProductID) }}" class="btn-quickview" title="Quick View">{{ $Product->ProductName }}</a>
@endforeach
