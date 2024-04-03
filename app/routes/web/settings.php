<?php

use App\Http\Controllers\web\Settings\BannersController;
use App\Http\Controllers\web\Settings\CMSController;
use App\Http\Controllers\web\Settings\CompanyController;
use App\Http\Controllers\web\Settings\GeneralSettingsController;
use App\Http\Controllers\web\Settings\StepperController;

Route::group(['prefix'=>'company'],function (){
    Route::controller(CompanyController::class)->group(function () {
        Route::get('/', 'Edit');
        Route::POST('/update', 'Update');
    });
});
Route::group(['prefix'=>'cms'],function (){
    Route::controller(CMSController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/edit/{ID}', 'edit');


        Route::post('/data', 'TableView');
        Route::Post('/edit/{ID}', 'Update');
    });
});

Route::group(['prefix'=>'general'],function (){
    Route::controller(GeneralSettingsController::class)->group(function () {
        Route::get('/', 'index');
        Route::Post('/', 'Update');
    });
});
Route::group(['prefix'=>'banners'],function (){
    Route::controller(BannersController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/upload', 'create');
        Route::get('/edit/{TranNo}', 'edit');
        Route::post('/upload', 'save');
        Route::POST('/edit/{TranNo}', 'update');
        Route::POST('/delete/{TranNo}', 'Delete');
    });
});

Route::group(['prefix' => 'steppers'], function () {
    Route::get('/', [StepperController::class, 'index'])->name('steppers.index');
    Route::get('/edit/{TranNo}', [StepperController::class, 'edit'])->name('steppers.edit');
    Route::POST('/edit/{TranNo}', [StepperController::class, 'update'])->name('steppers.update');
});
