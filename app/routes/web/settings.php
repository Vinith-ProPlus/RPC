<?php

use App\Http\Controllers\web\Settings\CompanyController;

Route::group(['prefix'=>'company'],function (){
    Route::controller(CompanyController::class)->group(function () {
        Route::get('/', 'Edit');
        Route::POST('/update', 'Update');
    });
});