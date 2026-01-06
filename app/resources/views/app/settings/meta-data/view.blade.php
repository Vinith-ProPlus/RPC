@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i
                                    class="f-16 fa fa-home"></i></a></li>
                        <li class="breadcrumb-item">General Master</li>
                        <li class="breadcrumb-item">{{ $PageTitle }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-sm-12 col-lg-10">
                <div class="card">
                    <div class="card-header text-center">
                        <div class="row">
                            <div class="col-sm-4"> </div>
                            <div class="col-sm-4 my-2">
                                <h5>{{ $PageTitle }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="order_filter" class="form-row justify-content-center m-20">
                            <div class="col-sm-2">
                                <div class="form-group text-center mh-60">
                                    <label style="margin-bottom:0px;">Content</label><br>
                                    <select id="lstFActiveStatus" class="form-control multiselect">
                                        <option value="home-content">Home Content</option>
                                        <option value="category">Category</option>
                                        <option value="sub-category">Sub Category</option>
                                        <option value="products">Products</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-lg-12">
                                <table class="table {{ $Theme['table-size'] }}" id="tblMetadata">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th id="thName">Name</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center noExport">Description</th>
                                            <th class="text-center noExport">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            let RootUrl = $('#txtRootUrl').val();
            var tblMetadata = null;


            const makeActiveStatus = async () => {
                $('#lstFActiveStatus').multiselect({
                    buttonClass: 'btn btn-link',
                    maxHeight: 250,
                    onChange: async () => {
                        LoadTable();
                    }
                });
            }
            makeActiveStatus();

            const LoadTable = async () => {
                @if ($crud['view'] == 1)
                    if (tblMetadata != null) {
                        tblMetadata.fnDestroy();
                    }
                    let filterOptions = {
                        ActiveStatus: $('#lstFActiveStatus').val(),
                    }
                    
                    // Update table header based on selected content type
                    const contentType = $('#lstFActiveStatus').val();
                    let headerName = 'Name';
                    if (contentType === 'category') {
                        headerName = 'Category';
                    } else if (contentType === 'sub-category') {
                        headerName = 'Sub Category';
                    } else if (contentType === 'products') {
                        headerName = 'Product Slug';
                    } else if (contentType === 'home-content') {
                        headerName = 'Page';
                    }
                    $('#thName').text(headerName);
                    
                    tblMetadata = $('#tblMetadata').dataTable({
                        bProcessing: true,
                        bServerSide: true,
                        ajax: {
                            url: "{{ url('/') }}/admin/settings/meta-data/data?_token=" + $(
                                'meta[name=_token]').attr('content'),
                            data: filterOptions,
                            headers: {
                                'X-CSRF-Token': $('meta[name=_token]').attr('content')
                            },
                            type: "POST"
                        },
                        deferRender: true,
                        responsive: true,
                        dom: 'Bfrtip',
                        iDisplayLength: 10,
                        lengthMenu: [
                            [10, 25, 50, 100, 250, 500, -1],
                            [10, 25, 50, 100, 250, 500, "All"]
                        ],
                        buttons: [
                            'pageLength'
                        ],
                        columnDefs: [{
                                targets: [0],
                                visible: false,
                                searchable: false
                            },
                            {
                                "className": "dt-center",
                                "targets": [2, 3]
                            },
                        ]
                    });
                @endif
            }

            $(document).on('click', '.btn-edit', function(e) {
                e.preventDefault();

                let ID = $(this).data('id') || null;
                let row = $(this).closest('tr');

                let pageId = $(this).data('page-id');
                let content = row.find('td:first').text();
                let title = row.find('.meta-title').val();
                let description = row.find('.meta-description').val();
                let isHomeContent = $('#lstFActiveStatus').val() === 'home-content' ? 1 : 0;

                $.ajax({
                    type: "POST",
                    url: "{{ url('/') }}/admin/settings/meta-data/edit/" + (ID ?? 0),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    data: {
                        page_id: pageId,
                        meta_title: title,
                        meta_description: description,
                        is_home_content: isHomeContent,
                        updated_content: content
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === true) {
                            toastr.success(response.message, "Success", {
                                positionClass: "toast-top-right",
                                progressBar: true
                            });
                        } else {
                            toastr.error(response.message ?? 'Operation failed');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        toastr.error('Server error');
                    }
                });
            });

            LoadTable();
        });
    </script>
@endsection
