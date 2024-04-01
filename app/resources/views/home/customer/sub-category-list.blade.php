@extends('home.home-layout')
@section('content')
    <link rel="stylesheet" href="{{url('/')}}/home/assets/css/product-style.css">
    <input type="hidden" style="display:none!important" id="CID" value="{{ $CID ?? '' }}">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('products.customer.categoriesList') }}">Categories</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Sub Categories</li>
                </ol>
            </div>
        </nav>
        <div class="mb-2"></div>
        <div class="container">
            <div class="row">
        <div class="col-lg-12 main-content" id="subCategoriesDiv">
            <div class="sticky-wrapper"><nav class="toolbox sticky-header" data-sticky-options="{'mobile': true}">
                    <div class="toolbox-left">
                        <a href="#" class="sidebar-toggle"><svg data-name="Layer 3" id="Layer_3" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                <line x1="15" x2="26" y1="9" y2="9" class="cls-1"></line>
                                <line x1="6" x2="9" y1="9" y2="9" class="cls-1"></line>
                                <line x1="23" x2="26" y1="16" y2="16" class="cls-1"></line>
                                <line x1="6" x2="17" y1="16" y2="16" class="cls-1"></line>
                                <line x1="17" x2="26" y1="23" y2="23" class="cls-1"></line>
                                <line x1="6" x2="11" y1="23" y2="23" class="cls-1"></line>
                                <path d="M14.5,8.92A2.6,2.6,0,0,1,12,11.5,2.6,2.6,0,0,1,9.5,8.92a2.5,2.5,0,0,1,5,0Z" class="cls-2"></path>
                                <path d="M22.5,15.92a2.5,2.5,0,1,1-5,0,2.5,2.5,0,0,1,5,0Z" class="cls-2"></path>
                                <path d="M21,16a1,1,0,1,1-2,0,1,1,0,0,1,2,0Z" class="cls-3"></path>
                                <path d="M16.5,22.92A2.6,2.6,0,0,1,14,25.5a2.6,2.6,0,0,1-2.5-2.58,2.5,2.5,0,0,1,5,0Z" class="cls-2"></path>
                            </svg>
                            <span>Filter</span>
                        </a>

                        <div class="toolbox-item toolbox-sort">
                            <label>Sort By:</label>

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
                </nav></div>

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
            </div>
            <div class="mb-4"></div>
        </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            var CID = $('#CID').val();
            var current_page_no = 1;
            var viewType = 'Grid';
            const LoadSubCategories = async () => {
                var formData = new FormData();

                formData.append('PostalID', $('#customerSelectedAddress').attr('data-selected-postal-id'));
                formData.append('AID', $('#customerSelectedAddress').attr('data-aid'));
                formData.append('CID', CID);
                formData.append('productCount', $('#productCountSelect').val());
                formData.append('orderBy', $('#orderBySelect').val());
                formData.append('viewType', viewType);
                formData.append('pageNo', current_page_no);
                $.ajax({
                    url: '{{ route('products.customer.subCategoriesListHtml') }}',
                    headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#subCategoriesDiv').html(response);
                        $('#productCountSelect').change(function () {
                            var selectedValue = $(this).val();
                            $('#productCountSelect2').val(selectedValue);
                        });
                        $('#productCountSelect2').change(function () {
                            var selectedValue = $(this).val();
                            $('#productCountSelect').val(selectedValue);
                        });
                        $('#productCountSelect').change(function () {
                            LoadSubCategories();
                        });
                        $('#productCountSelect2').change(function () {
                            LoadSubCategories();
                        });
                        $('#orderBySelect').change(function () {
                            LoadSubCategories();
                        });
                        $('.changePage').click(function () {
                            current_page_no = $(this).attr('data-page-no');
                            LoadSubCategories();
                        });
                        $('.prevPage').click(function () {
                            current_page_no = parseInt(current_page_no) - 1;
                            LoadSubCategories();
                        });
                        $('.nextPage').click(function () {
                            current_page_no = parseInt(current_page_no) + 1;
                            LoadSubCategories();
                        });
                    },
                    error: function (xhr, status, error) {
                        if (xhr.status === 419) {
                            console.error('CSRF token mismatch. Reloading page...');
                            window.location.reload();
                        } else {
                            console.log('An error occurred: ' + xhr.responseText);
                        }
                    }
                });
            }

            LoadSubCategories();

            var observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'data-selected-postal-id') {
                        LoadSubCategories();
                    }
                });
            });
            var config = { attributes: true };
            observer.observe(document.getElementById('customerSelectedAddress'), config);
        });
    </script>
@endsection
