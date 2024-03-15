@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}" data-original-title="" title=""><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Transaction</li>
					<li class="breadcrumb-item"><a href="{{ url('/') }}/transaction/quotation/" data-original-title="" title="">{{$PageTitle}}</a></li>
                    <li class="breadcrumb-item">Vendor Quote View</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row d-flex justify-content-center">
		<div class="col-12 col-sm-12 col-lg-12">
			<div class="card">
				<div class="card-header text-center"><h5 class="mt-10">Quote ( {{$QData->QuoteNo}} )</h5></div>
				<div class="card-body">
                    <table class="table" id="tblVendorQuote">
                        <thead>
                            <tr>
                                <th class="text-center align-middle">Quotation No</th>
                                <th class="text-center align-middle">Vendor Name</th>
                                <th class="text-center align-middle">Quote No</th>
                                <th class="text-center align-middle">Quote Value</th>
                                <th class="text-center align-middle">Items</th>
                                <th class="text-center align-middle">Quote Rating</th>
                                <th class="text-center align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($VendorQuote as $key=>$item)
                                <tr>
                                    <td>{{$QData->QuoteNo}}</td>
                                    <td>{{$item->VendorName}}</td>
                                    <td>{{$QData->QuoteNo}} - {{$key + 1}}</td>
                                    <td class="text-right">{{$item->QuoteValue ? NumberFormat($item->QuoteValue,$Settings['PRICE-DECIMALS']) : ""}}
                                        @if($item->isQuoteReceived && $item->QuoteValue) 
                                            <button type="button" title="View Quotation Details" data-vendor-id="{{$item->VendorID}}" data-id="{{$item->QuoteSentID}}" class="btn btnQuoteView"><i class="fa fa-eye text-dark"></i></button> 
                                        @endif
                                    </td>
                                    <td class="text-right">{{$item->ItemCount}}</td>
                                    <td></td>
                                    <td class="text-center">@if($item->isQuoteReceived && $item->QuoteValue) <button type="button" data-vendor-id="{{$item->VendorID}}" data-vendor-name="{{$item->VendorName}}" data-id="{{$item->QuoteSentID}}" class="btn btn-outline-info {{$Theme['button-size']}} btnAllocate">Allocate</button> @endif</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
				</div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            @if($crud['view']==true)
                            <a href="{{url('/')}}/transaction/quotation" class="btn {{$Theme['button-size']}} btn-outline-dark mr-10" id="btnCancel">Back</a>
                            @endif
                            
                            {{-- @if($crud['add']==true)
                                <button class="btn {{$Theme['button-size']}} btn-outline-success" id="btnSave">Request Quote</button>
                            @endif --}}
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
    $(document).ready(function(){
    });
</script>
@endsection