@extends('home.home-layout')
@section('content')

    <div class="container">
        <ul class="checkout-progress-bar d-flex justify-content-center flex-wrap">
            <li class="active">
                <a href="#">Requested Quotations</a>
            </li>
        </ul>

        <div class="row">
            <div class="col-lg-12 col-sm-12">
                    <table class="table table-sm" id="tblQuotations">
                        <thead>
                        <tr>
                            <th class="text-center">Enquiry No</th>
                            <th class="text-center">Enquiry Date</th>
                            <th class="text-center">Expected Delivery</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
{{--                        @if(count($Cart) > 0)--}}
{{--                            @foreach ($Cart as $item)--}}
{{--                                <tr class="product">--}}
{{--                                    <td>--}}
{{--                                        <figure class="product-image-container">--}}
{{--                                            <a href="#" class="product-image">--}}
{{--                                                <img src="{{$item->ProductImage}}" alt="product" height="100px" width="100px">--}}
{{--                                            </a>--}}

{{--                                            <a href="#" class="btn-remove icon-cancel btnRemoveCart" title="Remove Product" id="{{$item->ProductID}}"></a>--}}
{{--                                        </figure>--}}
{{--                                    </td>--}}
{{--                                    <td class="product-col align-middle">--}}
{{--                                        <h5 class="product-title">--}}
{{--                                            <a href="#">{{$item->ProductName}}</a>--}}
{{--                                        </h5>--}}
{{--                                    </td>--}}

{{--                                    <td class="align-middle text-center">--}}
{{--                                        <div class="product-single-qty">--}}
{{--                                            <input class="form-control txtUpdateQty" type="number" value="{{$item->Qty}}" id="{{$item->ProductID}}" style="width: 100%;">--}}
{{--                                            --}}{{-- <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected"><span class="input-group-btn input-group-prepend"><button class="btn btn-outline btn-down-icon bootstrap-touchspin-down" type="button"></button></span><input class="horizontal-quantity form-control" type="text"><span class="input-group-btn input-group-append"><button class="btn btn-outline btn-up-icon bootstrap-touchspin-up" type="button"></button></span></div> --}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                    <td class="text-center align-middle"><span class="subtotal-price">{{$item->UName}} ({{$item->UName}})</span></td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            let RootUrl=$('#txtRootUrl').val();
            const LoadTable=async()=>{
                $('#tblQuotations').dataTable({
                    "bProcessing": true,
                    "bServerSide": true,
                    "ajax": {"url": "{{url('/')}}/requested-quotations/data?_token="+$('meta[name=_token]').attr('content'),"headers":{ 'X-CSRF-Token' : $('meta[name=_token]').attr('content') } ,"type": "POST"},
                    deferRender: true,
                    responsive: true,
                    dom: 'Bfrtip',
                    "iDisplayLength": 10,
                    "lengthMenu": [[10, 25, 50,100,250,500, -1], [10, 25, 50,100,250,500, "All"]],
                    buttons: ['pageLength'],
                    columnDefs: [
                        {"className": "dt-center", "targets": [0, 1, 2, 3, 4]},
                    ]
                });
            }
            $(document).on('click','.btnView',function(){
                window.location.replace("{{url('/')}}/requested-quotations/view/"+ $(this).attr('data-id'));
            });
            {{--$(document).on('click','.btnVendorQuoteView',function(){--}}
            {{--    window.location.replace("{{url('/')}}/admin/transaction/quote-enquiry/view/vendor-quote/"+ $(this).attr('data-id'));--}}
            {{--});--}}

            {{--$(document).on('click','.btnDelete',function(){--}}
            {{--    let ID=$(this).attr('data-id');--}}
            {{--    swal({--}}
            {{--            title: "Are you sure?",--}}
            {{--            text: "You want to Cancel this Quotation!",--}}
            {{--            type: "warning",--}}
            {{--            showCancelButton: true,--}}
            {{--            confirmButtonClass: "btn-outline-danger",--}}
            {{--            confirmButtonText: "Yes, Cancel it!",--}}
            {{--            closeOnConfirm: false--}}
            {{--        },--}}
            {{--        function(){swal.close();--}}
            {{--            $.ajax({--}}
            {{--                type:"post",--}}
            {{--                url:"{{url('/')}}/admin/transaction/quote-enquiry/delete/"+ID,--}}
            {{--                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },--}}
            {{--                dataType:"json",--}}
            {{--                success:function(response){--}}
            {{--                    swal.close();--}}
            {{--                    if(response.status==true){--}}
            {{--                        $('#tblQuoteEnquiry').DataTable().ajax.reload();--}}
            {{--                        toastr.success(response.message, "Success", {--}}
            {{--                            positionClass: "toast-top-right",--}}
            {{--                            containerId: "toast-top-right",--}}
            {{--                            showMethod: "slideDown",--}}
            {{--                            hideMethod: "slideUp",--}}
            {{--                            progressBar: !0--}}
            {{--                        })--}}
            {{--                    }else{--}}
            {{--                        toastr.error(response.message, "Failed", {--}}
            {{--                            positionClass: "toast-top-right",--}}
            {{--                            containerId: "toast-top-right",--}}
            {{--                            showMethod: "slideDown",--}}
            {{--                            hideMethod: "slideUp",--}}
            {{--                            progressBar: !0--}}
            {{--                        })--}}
            {{--                    }--}}
            {{--                }--}}
            {{--            });--}}
            {{--        });--}}
            // });
            LoadTable();
        });
    </script>
@endsection
