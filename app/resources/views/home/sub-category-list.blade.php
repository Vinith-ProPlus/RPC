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
    <input type="hidden" id="CID" value="{{ $CID }}">
    <div id="pageContent">

    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            const LoadSubCategories= async () => {
                var formData = new FormData();

                formData.append('PostalID', $('#customerSelectedAddress').attr('data-selected-postal-id'));
                formData.append('CID', $('#CID').val());
                $.ajax({
                    url: '{{ route('products.subCategoriesListHtml') }}',
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
