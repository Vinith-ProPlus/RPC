<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\masters\general\CityController;
use App\Http\Controllers\web\masters\general\CountryController;
use App\Http\Controllers\web\masters\general\DistrictsController;
use App\Http\Controllers\web\masters\general\PostalCodesController;
use App\Http\Controllers\web\masters\general\RejectReasonController;
use App\Http\Controllers\web\masters\general\StagesController;
use App\Http\Controllers\web\masters\general\StatesController;
use App\Http\Controllers\web\masters\general\TaluksController;

Route::group(['prefix'=>'country'],function (){
    Route::controller(CountryController::class)->group(function () {
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
    });
});

Route::group(['prefix'=>'states'],function (){
    Route::controller(StatesController::class)->group(function () {
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

    });
});

Route::group(['prefix'=>'districts'],function (){
    Route::controller(DistrictsController::class)->group(function () {
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

    });
});

Route::group(['prefix'=>'taluks'],function (){
    Route::controller(TaluksController::class)->group(function () {
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

    });
});

Route::group(['prefix'=>'city'],function (){
    Route::controller(CityController::class)->group(function () {
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

    });
});

Route::group(['prefix'=>'postal-codes'],function (){
    Route::controller(PostalCodesController::class)->group(function () {
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

    });
});

Route::group(['prefix'=>'stages'],function (){
    Route::controller(StagesController::class)->group(function () {
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
        
        Route::post('/get/stage', 'GetStage');
    });
});
Route::group(['prefix'=>'reject-reason'],function (){
    Route::controller(RejectReasonController::class)->group(function () {
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
        
        Route::post('/get/reject-reason', 'GetRejectReason');
    });
});
