<?php

use App\Http\Controllers\web\Home\BannerController;

Route::group(['prefix'=>'banner'],function (){
    Route::controller(BannerController::class)->group(function () {
        Route::get('/', 'view');
        Route::get('/trash', 'TrashView');
        Route::get('/create', 'Create');
        Route::get('/edit/{ID}', 'Edit');
        Route::POST('/delete/{ID}', 'Delete');
        Route::POST('/restore/{ID}', 'Restore');
        Route::get('/view/{ID}', 'OrderView');
    });
});