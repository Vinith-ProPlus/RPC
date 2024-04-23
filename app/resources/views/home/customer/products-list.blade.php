@extends('home.home-layout')
@section('content')
    <link rel="stylesheet" href="{{url('/')}}/home/assets/css/product-style.css">
    <input type="hidden" style="display:none!important" id="SCID" value="{{ $SCID ?? '' }}">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('products.customer.categoriesList') }}">Categories</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('products.customer.subCategoryList') }}">Sub Categories</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Products</li>
                </ol>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 main-content" id="productDetailsDiv">
                    <div class="sticky-wrapper">
                        <nav class="toolbox sticky-header" data-sticky-options="{'mobile': true}">
                            <div class="toolbox-left">
                                <div class="toolbox-item toolbox-sort">
                                    <label for="orderBySelect">Sort By:</label>
                                    <div class="select-custom">
                                        <select name="orderby" class="form-control" id="orderBySelect">
                                            <option value="" selected="selected">Default sorting</option>
                                            <option value="new">Sort by newness</option>
                                            <option value="popularity">Sort by popularity</option>
                                            {{--                                        <option value="rating">Sort by average rating</option>--}}
                                        </select>
                                    </div><!-- End .select-custom -->
                                </div><!-- End .toolbox-item -->
                            </div><!-- End .toolbox-left -->

                            <div class="toolbox-right">
                                <div class="toolbox-item toolbox-show">
                                    <label>Show:</label>

                                    <div class="select-custom">
                                        <select name="count" class="form-control" id="productCountSelect">
                                            <option value="12">12</option>
                                            <option value="24">24</option>
                                            <option value="36">36</option>
                                        </select>
                                    </div><!-- End .select-custom -->
                                </div><!-- End .toolbox-item -->

                                <div class="toolbox-item layout-modes">
                                    <a href="#" class="layout-btn btn-grid active" title="Grid">
                                        <i class="icon-mode-grid"></i>
                                    </a>
                                    <a href="#" class="layout-btn btn-list" title="List">
                                        <i class="icon-mode-list"></i>
                                    </a>
                                </div><!-- End .layout-modes -->
                            </div><!-- End .toolbox-right -->
                        </nav>
                    </div>

                    <div class="row no-gutters">

                    </div><!-- End .row -->

                    <nav class="toolbox toolbox-pagination">
                        <div class="toolbox-item toolbox-show">
                            <label class="mt-0">Show:</label>

                            <div class="select-custom">
                                <select name="count" class="form-control">
                                    <option value="12">12</option>
                                    <option value="24">24</option>
                                    <option value="36">36</option>
                                </select>
                            </div><!-- End .select-custom -->
                        </div><!-- End .toolbox-item -->

                        <ul class="pagination toolbox-item">
                            <li class="page-item disabled">
                                <a class="page-link page-link-btn" href="#"><i class="icon-angle-left"></i></a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1 <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><span class="page-link">...</span></li>
                            <li class="page-item">
                                <a class="page-link page-link-btn" href="#"><i class="icon-angle-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div><!-- End .col-lg-9 -->

                <div class="sidebar-overlay"></div>
{{--                <aside class="sidebar-shop col-lg-3 order-lg-first mobile-sidebar">--}}
{{--                    <div class="pin-wrapper" style="height: 904.35px;">--}}
{{--                        <div class="sidebar-wrapper" style="border-bottom: 0px rgb(119, 119, 119); width: 335px;">--}}
{{--                            <div class="widget">--}}
{{--                                <h3 class="widget-title">--}}
{{--                                    <a data-toggle="collapse" href="#widget-body-1" role="button" aria-expanded="true"--}}
{{--                                       aria-controls="widget-body-1">Categories</a>--}}
{{--                                </h3>--}}

{{--                                <div class="collapse show" id="widget-body-1">--}}
{{--                                    <div class="widget-body" id="categories-widget">--}}
{{--                                        <ul class="cat-list">--}}
{{--                                        </ul>--}}
{{--                                    </div><!-- End .widget-body -->--}}
{{--                                </div><!-- End .collapse -->--}}
{{--                            </div><!-- End .widget -->--}}
{{--                        </div>--}}
{{--                    </div><!-- End .sidebar-wrapper -->--}}
{{--                </aside><!-- End .col-lg-3 -->--}}
            </div><!-- End .row -->

            <div class="mb-4"></div>
        </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            var sub_category_id = $('#SCID').val();

            var current_page_no = 1;
            var viewType = 'Grid';
            const LoadProducts = async () => {
                var formData = new FormData();

                formData.append('PostalID', $('#customerSelectedAddress').attr('data-selected-postal-id'));
                formData.append('AID', $('#customerSelectedAddress').attr('data-aid'));
                if(sub_category_id){
                    formData.append('SubCategoryID', sub_category_id);
                }
                formData.append('productCount', $('#productCountSelect').val());
                formData.append('orderBy', $('#orderBySelect').val());
                formData.append('viewType', viewType);
                formData.append('pageNo', current_page_no);

                $.ajax({
                    url: '{{ route('products.customer.productsListHtml') }}',
                    headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#productDetailsDiv').html(response);
                        $('#productCountSelect').change(function () {
                            var selectedValue = $(this).val();
                            $('#productCountSelect2').val(selectedValue);
                        });
                        $('#productCountSelect2').change(function () {
                            var selectedValue = $(this).val();
                            $('#productCountSelect').val(selectedValue);
                        });
                        $('#productCountSelect').change(function () {
                            LoadProducts();
                        });
                        $('#productCountSelect2').change(function () {
                            LoadProducts();
                        });
                        $('#orderBySelect').change(function () {
                            LoadProducts();
                        });
                        $('.changePage').click(function () {
                            current_page_no = $(this).attr('data-page-no');
                            LoadProducts();
                        });
                        $('.changeView').click(function () {
                            viewType = $(this).attr('title');
                            LoadProducts();
                        });
                        $('.prevPage').click(function () {
                            current_page_no = parseInt(current_page_no) - 1;
                            LoadProducts();
                        });
                        $('.nextPage').click(function () {
                            current_page_no = parseInt(current_page_no) + 1;
                            LoadProducts();
                        });
                    },
                    error: function (xhr, status, error) {
                        if (xhr.status === 419) {
                            window.location.reload();
                        } else {
                            console.log('An error occurred: ' + xhr.responseText);
                        }
                    }
                });
            }

            LoadProducts();

            var observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'data-selected-postal-id') {
                        LoadProducts();
                    }
                });
            });
            var config = { attributes: true };
            observer.observe(document.getElementById('customerSelectedAddress'), config);
            {{--$('.productPageLink').on('click', function(){--}}
            {{--    window.location.replace("{{ url('/') }}/customer/product/view/"+ $(this).data('id'));--}}
            {{--});--}}
        });
    </script>
@endsection
