<?php

use App\Http\Controllers\api\vendor\VendorAPIController;
use App\Http\Controllers\api\vendor\VendorAuthController;
use App\Http\Controllers\api\vendor\VendorStockPointController;
use App\Http\Controllers\api\vendor\VendorTransactionAPIController;

Route::controller(VendorAuthController::class)->group(function () {
    Route::post('/register','Register');
    Route::post('/register-update','RegisterUpdate');
    Route::post('/update','Update');
    Route::post('/get/user-info','getUserInfo');
    Route::post('/registered-details','RegisteredDetails');
    Route::post('/documents','VendorDocuments');
    Route::post('/vendor-data','getVendorData');

    Route::post('/get/vehicle-data','getVehicleData');
    Route::post('/add-vehicle','AddVehicle');
    Route::post('/update-vehicle','UpdateVehicle');
    Route::post('/delete-vehicle','DeleteVehicle');

    Route::post('/get/vendor-mapped-products','getVendorMappedProducts');
    Route::post('/add-product','AddProduct');
    Route::post('/update-product','UpdateProduct');
    Route::post('/delete-product','DeleteProduct');

    Route::post('/get/vendor-stock-data','getVendorStockData');
    Route::post('/update-stock-data','UpdateStockData');
    
    Route::post('/get/vendor-home','getVendorHome');
    Route::post('/get/notifications','getNotifications');
    Route::post('/notification-read','NotificationRead');

    Route::post('/get/vendor-products-search','getVendorProductSearch');
});

Route::controller(VendorStockPointController::class)->group(function () {
    Route::post('/get/stockpoint-data','getStockpointData');
    Route::post('/add-stockpoint','AddStockpoint');
    Route::post('/update-stockpoint','UpdateStockpoint');
    Route::post('/delete-stockpoint','DeleteStockpoint');
});
Route::controller(VendorAPIController::class)->group(function () {
    Route::post('/login','Login');
    Route::post('/google-register','GoogleRegister');
});

Route::controller(VendorTransactionAPIController::class)->group(function () {

    Route::post('/get/quote-request','getQuoteRequest');
    Route::post('/get/all-quotations','getAllQuotations');
    Route::post('/add-quote-price','AddQuotePrice');
    Route::post('/reject-quote','RejectQuote');
    Route::post('/stock-list','index');
    
    Route::post('/get/orders','getOrders');
    Route::post('/get/current-orders','getCurrentOrders');
    Route::post('/get/completed-orders','getCompletedOrders');
    
    Route::post('/order/mark-as-delivered','MarkasDelivered');
    Route::post('/order/delivered','Delivered');

    Route::post('/request-payment','RequestPayment');
    Route::post('/get/transaction-history','getTransactionHistory');
    Route::post('/get/withdrawal-request','getWithdrawalRequest');
    Route::post('/get/settlement-history','getSettlementHistory');

});


