<?php

use App\Http\Controllers\api\customer\CustomerAuthController;
use App\Http\Controllers\api\customer\CustomerAPIController;
use App\Http\Controllers\api\customer\CustomerTransactionAPIController;

Route::controller(CustomerAuthController::class)->group(function () {
    
    Route::post('/get/user-info','getUserInfo');
    Route::post('/register','Register');
    Route::post('/get/customer-data','CustomerData');
    Route::post('/update','Update');

    Route::post('/get/construction-type','getConstructionType');
    Route::post('/get/customer-type','getCustomerType');
    Route::post('/get/category','getCategory');
    Route::post('/get/sub-category','getSubCategory');
    Route::post('/get/products','getProducts');
    Route::post('/get/category/search','getCategorySearch');
    Route::post('/get/sub-category/search','getSubCategorySearch');
    Route::post('/get/products/search','getProductsSearch');

    Route::post('/get/cart','getCart');
    Route::post('/add-cart','AddCart');
    Route::post('/update-cart','UpdateCart');
    Route::post('/delete-cart','DeleteCart');

    Route::post('/get/customer-home','getCustomerHome');
    Route::post('/get/customer-home-search','getCustomerHomeSearch');


});

Route::controller(CustomerAPIController::class)->group(function () {
    Route::post('/login','Login');
    Route::post('/google-register','GoogleRegister');
});

Route::controller(CustomerTransactionAPIController::class)->group(function () {
    Route::post('/place-order','PlaceOrder');
    Route::post('/cancel-quote-enquiry','CancelQuoteEnquiry');
    Route::post('/get/quote-enquiry','getQuoteEnquiry');
    Route::post('/get/quotation','getQuotation');
    
    Route::post('/accept-quote','AcceptQuote');
    Route::post('/reject-quote','RejectQuote');
    Route::post('/reject-quote-item','RejectQuoteItem');

    Route::post('/get/order','getOrder');
    // Route::post('/get/category','getCategory');
});


