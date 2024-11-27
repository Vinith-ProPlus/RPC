<nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('products.categoriesList') }}">Categories</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sub Categories</li>
        </ol>
    </div>
</nav>
<div class="container">
    <div class="row">
        @foreach($PSubCatagories as $PSubCatagory)
            @php $rating = rand(50, 100); @endphp
            <div class="col-6 col-sm-4 col-lg-3">
                <a href="{{ route('products.productsList', ['SCID' => $PSubCatagory->PSCID]) }}">
                    <div class="product-default inner-quickview inner-icon product-div">
                        <figure>
                            <div class="image-container">
                                <img loading="lazy" src="{{ file_exists($PSubCatagory->ThumbnailImg)? $PSubCatagory->ThumbnailImg : $PSubCatagory->PSCImage }}" alt="{{ $PSubCatagory->PSCName }}">
                            </div>
                            <div class="label-group"></div>
                        </figure>
                        <div class="product-details">
                            <h3 class="product-title">
                                <a href="#">{{ $PSubCatagory->PSCName  }}</a>
                            </h3>
                            <div class="ratings-container">
                                <div class="product-ratings">
                                    <span class="ratings" style="width: {{ $rating }}%"></span>
                                    <span class="tooltiptext tooltip-top"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    <div class="mb-4"></div>
</div>
