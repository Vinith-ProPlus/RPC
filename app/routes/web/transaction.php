<?php

use App\Http\Controllers\web\Transaction\EnquiryController;
use App\Http\Controllers\web\Transaction\OrderController;
use App\Http\Controllers\web\Transaction\PaymentController;
use App\Http\Controllers\web\Transaction\QuotationController;
use App\Http\Controllers\web\Transaction\QuoteEnquiryController;
use App\Http\Controllers\web\Transaction\PaymentRequestController;

Route::group(['prefix'=>'enquiry'],function (){
    Route::controller(EnquiryController::class)->group(function () {
        Route::get('/', 'view');
        Route::get('/trash', 'TrashView');
        Route::get('/create', 'Create');
        Route::get('/edit/{ID}', 'Edit');
        Route::get('/view/{ID}', 'EnqView');

        Route::POST('/convert/{ID}', 'Convert');
        Route::POST('/delete/{ID}', 'Delete');
        Route::POST('/restore/{ID}', 'Restore');

        Route::post('/data', 'TableView');
        Route::post('/trash-data', 'TrashTableView');
    });
});

Route::group(['prefix'=>'quote-enquiry'],function (){
    Route::controller(QuoteEnquiryController::class)->group(function () {
        Route::get('/', 'view');
        Route::get('/trash', 'TrashView');
        Route::get('/create', 'Create');
        Route::get('/edit/{ID}', 'Edit');
        Route::get('/view/{ID}', 'QuoteView');
        Route::post('/save', 'Save');

        Route::get('/image-quote/create', 'ImageQuoteCreate');

        Route::post('/data', 'TableView');
        Route::post('/request-quote/{ID}', 'RequestQuote');
        Route::POST('/quote-convert/{ID}', 'QuoteConvert');
        Route::POST('/delete/{ID}', 'Delete');
        Route::POST('/restore/{ID}', 'Restore');
        Route::post('/trash-data', 'TrashTableView');

        Route::post('/get/Quotation', 'GetQuotation');
        Route::post('/get/vendor-quote-details', 'GetVendorQuoteDetails');
        Route::post('/get/vendor-ratings', 'GetVendorRatings');
        Route::post('/get/vendor-quote', 'GetVendorQuote');
        Route::post('/add-quote-price','AddQuotePrice');
        Route::post('/reject-quote','RejectQuote');
        Route::post('/delete-quote-item','DeleteQuoteItem');

        Route::post('/get/customers', 'GetCustomers');
        
        Route::post('/get/category', 'GetCategory');
        Route::post('/get/sub-category', 'GetSubCategory');
        Route::post('/get/products', 'GetProducts');
    });
});

Route::group(['prefix'=>'payments'],function (){
    Route::controller(PaymentController::class)->group(function () {
        Route::get('/', 'view');
        Route::get('/trash/view/', 'TrashView');

        Route::post('/data', 'TableView');
        Route::post('/get/vendor', 'getVendor');
        Route::post('/get/order-details/{OrderID}', 'getOrderDetails');
        Route::post('/create', 'Save');
        Route::post('/edit/{TranNo}', 'Update');
        Route::post('/delete/{TranNo}', 'delete');
        Route::post('/details/view', 'getDetails');

        Route::group(['prefix'=>'advance-payment'],function (){
            Route::get('/create', 'advancePaymentView');
            Route::get('/edit/{TranNo}', 'AdvanceEdit');
        });
        Route::group(['prefix'=>'order-payment'],function (){
            Route::get('/create', 'orderPaymentView');
            Route::get('/edit/{TranNo}', 'Edit');
            Route::post('/get/orders', 'getOrders');
        });
    });
});

Route::group(['prefix'=>'quotation'],function (){
    Route::controller(QuotationController::class)->group(function () {
        Route::get('/', 'view')->name('admin.transaction.quotes');
        Route::get('/details/{QID}', 'QuoteView')->name('admin.transaction.quotes.details');

        Route::post('/data', 'TableView')->name('admin.transaction.quotes.data');
        Route::post('/update/vendor/cost/{QID}', 'updateVendorAdditionalCost')->name('admin.transaction.quotes.update.vendor-cost');
        Route::post('/update/customer/cost/{QID}', 'updateCustomerAdditionalCost')->name('admin.transaction.quotes.update.customer-cost');
        Route::post('/cancel/{QID}', 'QuoteCancel')->name('admin.transaction.quotes.cancel');
        Route::post('/approve/{QID}', 'QuoteApprove')->name('admin.transaction.quotes.approve');
        Route::post('/cancel-item/{DetailID}', 'QuoteItemCancel')->name('admin.transaction.quotes.cancel-item');

        Route::post('/get/cancel-reasons', 'getCancelReasons')->name('admin.transaction.quotes.get.cancel-reasons');
        Route::POST('/get/filters/status', 'getSearchStatus')->name('admin.transaction.quotes.filter.status');
        Route::POST('/get/filters/customers', 'getSearchCustomers')->name('admin.transaction.quotes.filter.customers');
        Route::POST('/get/filters/quote-dates', 'getSearchQuoteDates')->name('admin.transaction.quotes.filter.quote-dates');
    });
});

Route::group(['prefix'=>'order'],function (){
    Route::controller(OrderController::class)->group(function () {
        Route::get('/', 'view')->name('admin.transaction.orders');
        Route::get('/details/{OrderID}', 'OrderView')->name('admin.transaction.orders.details');

        Route::post('/data', 'TableView')->name('admin.transaction.orders.data');
        Route::post('/cancel/{OrderID}', 'OrderCancel')->name('admin.transaction.orders.cancel');
        Route::post('/update/vendor/cost/{OrderID}', 'updateVendorAdditionalCost')->name('admin.transaction.orders.update.vendor-cost');
        Route::post('/update/customer/cost/{OrderID}', 'updateCustomerAdditionalCost')->name('admin.transaction.orders.update.customer-cost');
        Route::post('/mark-as-delivered', 'MarkAsDelivered')->name('admin.transaction.orders.mark-delivered');
        Route::post('/mark-as-delivered/item', 'ItemMarkAsDelivered')->name('admin.transaction.orders.mark-delivered.item');
        Route::post('/cancel-item/{DetailID}', 'OrderItemCancel')->name('admin.transaction.orders.cancel-item');
        Route::post('/send-otp', 'sendOTP')->name('admin.transaction.orders.send-otp');

        Route::post('/get/cancel-reasons', 'getCancelReasons')->name('admin.transaction.orders.get.cancel-reasons');
        Route::POST('/get/filters/order-status', 'getSearchOrderStatus')->name('admin.transaction.orders.filter.order-status');
        Route::POST('/get/filters/payment-status', 'getSearchPaymentStatus')->name('admin.transaction.orders.filter.payment-status');
        Route::POST('/get/filters/customers', 'getSearchCustomers')->name('admin.transaction.orders.filter.customers');
        Route::POST('/get/filters/order-dates', 'getSearchOrderDates')->name('admin.transaction.orders.filter.order-dates');
        Route::POST('/get/filters/delivery-dates', 'getSearchDeliveryDates')->name('admin.transaction.orders.filter.delivery-dates');
    });
});Route::group(['prefix'=>'payment-request'],function (){
    Route::controller(PaymentRequestController::class)->group(function () {
        Route::get('/', 'view')->name('admin.transaction.payment-requests');

        Route::post('/data', 'TableView')->name('admin.transaction.payment-requests.data');
        Route::post('/update-status', 'updateStatus')->name('admin.transaction.payment-requests.status.update');

        Route::POST('/get/filters/status', 'getSearchStatus')->name('admin.transaction.payment-requests.filter.status');
    });
});