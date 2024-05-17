@extends('home.guest-layout')
@section('content')
    <style>
        .image-container {
            width: 300px;
            height: 300px;
            background-size: cover;
            background-position: center;
        }
    </style>
    <div id="pageContent">

    </div>
{{--        <nav aria-label="breadcrumb" class="breadcrumb-nav">--}}
{{--            <div class="container">--}}
{{--                <ol class="breadcrumb">--}}
{{--                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>--}}
{{--                    <li class="breadcrumb-item active" aria-current="page">Categories</li>--}}
{{--                </ol>--}}
{{--            </div>--}}
{{--        </nav>--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                @foreach($PCategories as $PCategory)--}}
{{--                    @php $rating = rand(50, 100); @endphp--}}
{{--                    <div class="col-6 col-sm-4 col-lg-3">--}}
{{--                        <a href="{{ route('products.subCategoryList', ['CID' => $PCategory->PCID]) }}">--}}
{{--                            <div class="product-default inner-quickview inner-icon product-div">--}}
{{--                                <figure>--}}
{{--                                    <div class="image-container">--}}
{{--                                        <img loading="lazy" src="{{ $PCategory->PCImage }}" alt="{{ $PCategory->PCName }}">--}}
{{--                                    </div>--}}
{{--                                    <div class="label-group"></div>--}}
{{--                                </figure>--}}
{{--                                <div class="product-details">--}}
{{--                                    <h3 class="product-title">--}}
{{--                                        {{ $PCategory->PCName  }}--}}
{{--                                    </h3>--}}
{{--                                    <div class="ratings-container">--}}
{{--                                        <div class="product-ratings">--}}
{{--                                            <span class="ratings" style="width: {{ $rating }}%"></span>--}}
{{--                                            <span class="tooltiptext tooltip-top"></span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
{{--            </div>--}}
{{--            <div class="mb-4"></div>--}}
{{--        </div>--}}

@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            const LoadCategories= async () => {
                var formData = new FormData();

                formData.append('PostalID', $('#customerSelectedAddress').attr('data-selected-postal-id'));
                formData.append('AID', $('#customerSelectedAddress').attr('data-aid'));
                $.ajax({
                    url: '{{ route('products.categoriesListHtml') }}',
                    headers: { 'X-CSRF-Token' : '{{ csrf_token() }}' },
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#pageContent').html(response);
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 419) {
                            console.error('CSRF token mismatch. Reloading page...');
                            window.location.replace("{{ route('homepage') }}");
                        } else {
                            console.log('An error occurred: ' + xhr.responseText);
                        }
                    }
                });
            }

            LoadCategories();

            var observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'data-selected-postal-id') {
                        LoadCategories();
                    }
                });
            });
            var config = { attributes: true };
            observer.observe(document.getElementById('customerSelectedAddress'), config);
        });
    </script>
@endsection
