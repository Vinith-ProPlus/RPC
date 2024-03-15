<?php

use App\Http\Controllers\web\masters\product\AttributesController;
use App\Http\Controllers\web\masters\product\BrandsController;
use App\Http\Controllers\web\masters\product\ProductCategoryController;
use App\Http\Controllers\web\masters\product\ProductsController;
use App\Http\Controllers\web\masters\product\ProductSubCategoryController;
use App\Http\Controllers\web\masters\product\TaxController;
use App\Http\Controllers\web\masters\product\UOMController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'category'],function (){
    Route::controller(ProductCategoryController::class)->group(function () {
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

        Route::post('/create-form','GetNewProductCategory');
        Route::post('/get/PCategory','GetProductCategory');
    });
});
Route::group(['prefix'=>'sub-category'],function (){
    Route::controller(ProductSubCategoryController::class)->group(function () {
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

        Route::post('/create-form','GetNewProductSubCategory');
        Route::post('/get/PSubCategory','GetProductSubCategory');
    });
});
Route::group(['prefix'=>'tax'],function (){
    Route::controller(TaxController::class)->group(function () {
        Route::get('/', 'view');
        Route::get('/view', 'view');
        Route::get('/trash', 'TrashView');
        Route::get('/create', 'Create');
        Route::get('/edit/{ID}', 'Edit');

        Route::post('/data', 'TableView');
        Route::post('/create', 'Save');
        Route::POST('/edit/{ID}', 'Update');
        Route::POST('/delete/{ID}', 'Delete');
        Route::POST('/restore/{ID}', 'Restore');
        Route::post('/trash-data', 'TrashTableView');

        Route::post('/get/Tax', 'GetTax');
    });
});
Route::group(['prefix'=>'unit-of-measurement'],function (){
    Route::controller(UOMController::class)->group(function () {
        Route::get('/', 'view');
        Route::get('/view', 'view');
        Route::get('/trash', 'TrashView');
        Route::get('/create', 'Create');
        Route::get('/edit/{ID}', 'Edit');

        Route::post('/data', 'TableView');
        Route::post('/create', 'Save');
        Route::POST('/edit/{ID}', 'Update');
        Route::POST('/delete/{ID}', 'Delete');
        Route::POST('/restore/{ID}', 'Restore');
        Route::post('/trash-data', 'TrashTableView');

        Route::post('/get/UOM', 'GetUOM');
    });
});
Route::group(['prefix'=>'brands'],function (){
    Route::controller(BrandsController::class)->group(function () {
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

        Route::post('/create-form','GetNewProductCategory');
        Route::post('/get/PCategory','GetProductCategory');

        Route::post('/get/Brand', 'GetBrand');
    });
});
Route::group(['prefix'=>'attributes'],function (){
    Route::controller(AttributesController::class)->group(function () {
        Route::get('/', 'view');
        Route::get('/trash', 'TrashView');
        Route::get('/create', 'Create');
        Route::get('/edit/{ID}', 'Edit');

        Route::post('/data', 'TableView');
        Route::post('/create', 'Save');
        Route::POST('/edit/{ID}', 'Update');
        Route::POST('/delete/{ID}', 'Delete');
        Route::POST('/active-status/{ID}', 'ActiveStatus');
        Route::POST('/restore/{ID}', 'Restore');
        Route::post('/trash-data', 'TrashTableView');

        Route::post('/create-form','GetNewProductCategory');
        Route::post('/get/PCategory','GetProductCategory');

        Route::post('/get/Attribute', 'GetAttribute');
        Route::post('/get/AttrValue', 'GetAttrValue');
    });
});
Route::group(['prefix'=>'products'],function (){
    Route::controller(ProductsController::class)->group(function () {
        Route::get('/', 'view');
        Route::get('/view', 'view');
        Route::get('/trash', 'TrashView');
        Route::get('/create', 'Create');
        Route::get('/edit/{ID}', 'Edit');

        Route::post('/data', 'TableView');
        Route::post('/create', 'Save');
        Route::POST('/edit/{ID}', 'Update');
        Route::POST('/delete/{ID}', 'Delete');
        Route::POST('/restore/{ID}', 'Restore');
        Route::post('/trash-data', 'TrashTableView');

        //get 
        Route::get('/get/process-status', 'getSaveProcessStatus');
        Route::POST('/get/product-details/{ProductID}', 'getProductDetails');
        Route::post('/get/category', 'getCategory');
        Route::post('/get/sub-category', 'getSubCategory');
        Route::post('/get/brands', 'getBrands');
        Route::post('/get/tax', 'getTax');
        Route::post('/get/uom', 'getUOM');
        Route::post('/get/attributes', 'getAttributes');
        Route::post('/get/attribute-details', 'getAttributeDetails');

    });
});