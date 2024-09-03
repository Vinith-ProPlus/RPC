<?php

use App\Http\Controllers\api\customer\GuestController;
use Illuminate\Support\Facades\Route;

Route::controller(GuestController::class)->group(function () {

    Route::post('/get/postal-code-id','getPostalCodeID');
    Route::post('/get/category','getCategory');
    Route::post('/get/sub-category','getSubCategory');
    Route::post('/get/products','getProducts');
    Route::post('/get/category/search','getCategorySearch');
    Route::post('/get/sub-category/search','getSubCategorySearch');
    Route::post('/get/all-products','getAllProducts');
    Route::post('/get/single-product','getSingleProduct');

    Route::post('/get/guest-home','getGuestHome');
    Route::post('/get/guest-home-search','getGuestHomeSearch');
});


