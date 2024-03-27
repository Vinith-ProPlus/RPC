<?php

use App\Http\Controllers\web\Transaction\EnquiryController;
use App\Http\Controllers\web\Transaction\OrderController;
use App\Http\Controllers\web\Transaction\PaymentController;
use App\Http\Controllers\web\Transaction\ReceiptsController;
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
        Route::post('/image-quote/save', 'ImageQuoteSave');

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
        Route::get('/', 'view')->name('admin.transaction.payments');
        Route::get('/trash/view/', 'TrashView')->name('admin.transaction.payments.trash');

        Route::post('/data', 'TableView')->name('admin.transaction.payments.data');
        
        Route::post('/create', 'Save')->name('admin.transaction.payments.save');
        Route::post('/edit/{TranNo}', 'Update')->name('admin.transaction.payments.update');
        Route::post('/delete/{TranNo}', 'delete')->name('admin.transaction.payments.delete');
        Route::post('/details/view', 'getDetails')->name('admin.transaction.payments.details-view');

        Route::group(['prefix'=>'advance'],function (){
            Route::get('/create', 'advancePaymentView')->name('admin.transaction.payments.advance.create');
            Route::get('/edit/{TranNo}', 'AdvanceEdit')->name('admin.transaction.payments.advance.edit');
        });
        Route::group(['prefix'=>'payment'],function (){
            Route::get('/create', 'create')->name('admin.transaction.payments.payment.create');
            Route::get('/edit/{TranNo}', 'Edit')->name('admin.transaction.payments.payment.edit');
            Route::post('/get/orders', 'getOrders')->name('admin.transaction.payments.payment.get.orders');
        });

        Route::post('/get/ledger', 'getLedger')->name('admin.transaction.payments.get.ledger');
        Route::post('/get/order-details/{OrderID}', 'getOrderDetails')->name('admin.transaction.payments.get.order-details');
    });
});
Route::group(['prefix'=>'receipts'],function (){
    Route::controller(ReceiptsController::class)->group(function () {
        Route::get('/', 'view')->name('admin.transaction.receipts');
        Route::get('/trash/view/', 'TrashView')->name('admin.transaction.receipts.trash');

        Route::post('/data', 'TableView')->name('admin.transaction.receipts.data');
        
        Route::post('/create', 'Save')->name('admin.transaction.receipts.save');
        Route::post('/edit/{TranNo}', 'Update')->name('admin.transaction.receipts.update');
        Route::post('/delete/{TranNo}', 'delete')->name('admin.transaction.receipts.delete');
        Route::post('/details/view', 'getDetails')->name('admin.transaction.receipts.details-view');

        Route::group(['prefix'=>'advance'],function (){
            Route::get('/create', 'advancePaymentView')->name('admin.transaction.receipts.advance.create');
            Route::get('/edit/{TranNo}', 'AdvanceEdit')->name('admin.transaction.receipts.advance.edit');
        });
        Route::group(['prefix'=>'order'],function (){
            Route::get('/create', 'create')->name('admin.transaction.receipts.order.create');
            Route::get('/edit/{TranNo}', 'Edit')->name('admin.transaction.receipts.order.edit');
            Route::post('/get/orders', 'getOrders')->name('admin.transaction.receipts.order.get.orders');
        });

        Route::post('/get/ledger', 'getLedger')->name('admin.transaction.receipts.get.ledger');
        Route::post('/get/order-details/{OrderID}', 'getOrderDetails')->name('admin.transaction.receipts.get.order-details');
    });
});

Route::group(['prefix'=>'quotation'],function (){
    Route::controller(QuotationController::class)->group(function () {
        Route::get('/', 'view')->name('admin.transaction.quotes');
        Route::get('/details/{QID}', 'QuoteView')->name('admin.transaction.quotes.details');

        Route::post('/data', 'TableView')->name('admin.transaction.quotes.data');
        Route::post('/update/item/{DetailID}', 'itemUpdate')->name('admin.transaction.quotes.item.update');
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


        Route::post('/admin/rating/save', 'adminRatingSave')->name('admin.transaction.orders.vendor.rating.submit');
        
        Route::post('/get/cancel-reasons', 'getCancelReasons')->name('admin.transaction.orders.get.cancel-reasons');
        Route::POST('/get/filters/order-status', 'getSearchOrderStatus')->name('admin.transaction.orders.filter.order-status');
        Route::POST('/get/filters/payment-status', 'getSearchPaymentStatus')->name('admin.transaction.orders.filter.payment-status');
        Route::POST('/get/filters/customers', 'getSearchCustomers')->name('admin.transaction.orders.filter.customers');
        Route::POST('/get/filters/order-dates', 'getSearchOrderDates')->name('admin.transaction.orders.filter.order-dates');
        Route::POST('/get/filters/delivery-dates', 'getSearchDeliveryDates')->name('admin.transaction.orders.filter.delivery-dates');
    });
});
Route::group(['prefix'=>'payment-request'],function (){
    Route::controller(PaymentRequestController::class)->group(function () {
        Route::get('/', 'view')->name('admin.transaction.payment-requests');

        Route::post('/data', 'TableView')->name('admin.transaction.payment-requests.data');
        Route::post('/update-status', 'updateStatus')->name('admin.transaction.payment-requests.status.update');

        Route::POST('/get/filters/status', 'getSearchStatus')->name('admin.transaction.payment-requests.filter.status');
    });
});
