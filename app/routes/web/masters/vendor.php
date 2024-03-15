<?php

use App\Http\Controllers\web\masters\vendor\DepartmentsController;
use App\Http\Controllers\web\masters\vendor\VendorCategoryController;
use App\Http\Controllers\web\masters\vendor\VendorProductMappingController;
use App\Http\Controllers\web\masters\vendor\VendorsController;
use App\Http\Controllers\web\masters\vendor\VendorStockUpdateController;
use App\Http\Controllers\web\masters\vendor\VendorTypeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'departments'],function (){
    Route::controller(DepartmentsController::class)->group(function () {
        Route::get('/', 'view');
        Route::get('/trash', 'TrashView');
        Route::get('/create', 'Create');
        Route::get('/edit/{ID}', 'Edit');

        Route::post('/data', 'TableView');
        Route::post('/create', 'Save');
        Route::POST('/edit/{ID}', 'Update');
        Route::POST('/delete/{ID}', 'Delete');
        Route::POST('/restore/{ID}', 'Restore');
        Route::post('/trash-data', 'TrashTableView');

        Route::post('/create-form','GetNewVendorCategory');
        Route::post('/get/VCategory','GetVendorCategory');
    });
});
Route::group(['prefix'=>'category'],function (){
    Route::controller(VendorCategoryController::class)->group(function () {
        Route::get('/', 'view');
        Route::get('/trash', 'TrashView');
        Route::get('/create', 'Create');
        Route::get('/edit/{ID}', 'Edit');

        Route::post('/data', 'TableView');
        Route::post('/create', 'Save');
        Route::POST('/edit/{ID}', 'Update');
        Route::POST('/delete/{ID}', 'Delete');
        Route::POST('/restore/{ID}', 'Restore');
        Route::post('/trash-data', 'TrashTableView');

        Route::post('/create-form','GetNewVendorCategory');
        Route::post('/get/VCategory','GetVendorCategory');
    });
});
Route::group(['prefix'=>'manage-vendors'],function (){
    Route::controller(VendorsController::class)->group(function () {
        Route::get('/', 'view');
        Route::get('/view', 'view');
        Route::get('/trash', 'TrashView');
        Route::get('/create', 'Create');
        Route::get('/edit/{VendorID}', 'edit');
        Route::get('/edit/service-location/{VendorID}', 'editServiceLocation');
        
        Route::post('/data', 'TableView');
        Route::post('/create', 'save');
        Route::post('/edit/{VendorID}', 'update');
        Route::post('/edit/service-location/{VendorID}', 'updateServiceLocation');
        Route::POST('/approve/{ID}', 'Approve');
        Route::POST('/delete/{ID}', 'Delete');
        Route::POST('/restore/{ID}', 'Restore');
        Route::post('/trash-data', 'TrashTableView');

        Route::post('/get/vendor', 'getVendorDetails');
        Route::post('/get/vendors', 'getVendors');
        Route::post('/get/vendor-category', 'getVendorCategory');
        Route::post('/get/vendor-type', 'getVendorType');
        /*
        Route::get('/edit/{SupplierID}', 'Edit');

        Route::post('/create', 'Save');
        Route::POST('/edit/{SupplierID}', 'Update');
        Route::POST('/delete/{SupplierID}', 'Delete');
        Route::POST('/restore/{SupplierID}', 'Restore');
        Route::post('/trash-data', 'TrashTableView');
        */
    });
});

Route::group(['prefix'=>'vendor-type'],function (){
    Route::controller(VendorTypeController::class)->group(function () {
        Route::get('/', 'view');
        Route::get('/trash', 'TrashView');
        Route::get('/create', 'Create');
        Route::get('/edit/{ID}', 'Edit');

        Route::post('/data', 'TableView');
        Route::post('/create', 'Save');
        Route::POST('/edit/{ID}', 'Update');
        Route::POST('/delete/{ID}', 'Delete');
        Route::POST('/restore/{ID}', 'Restore');
        Route::post('/trash-data', 'TrashTableView');

        Route::post('/get/VendorType','getVendorType');
    });
});

Route::group(['prefix'=>'vendor-product-mapping'],function (){
    Route::controller(VendorProductMappingController::class)->group(function () {
        Route::get('/', 'view');
        Route::get('/edit/{ID}', 'Edit');

        Route::post('/update', 'Update');

        Route::post('/get/vendor-products', 'getVendorProducts');
        Route::post('/get/product-data', 'getProducts');
    });
});

Route::group(['prefix'=>'vendor-stock-update'],function (){
    Route::controller(VendorStockUpdateController::class)->group(function () {
        Route::get('/', 'view');
        Route::get('/edit/{ID}', 'Edit');

        Route::post('/update', 'Update');

        Route::post('/get/vendor-stock-data', 'getVendorStockData');
        Route::post('/get/vendor-products', 'getVendorProducts');
    });
});
