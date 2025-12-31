<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\Settings\BannersController;
use App\Http\Controllers\web\Settings\CMSController;
use App\Http\Controllers\web\Settings\CompanyController;
use App\Http\Controllers\web\Settings\GeneralSettingsController;
use App\Http\Controllers\web\Settings\StepperController;
use App\Http\Controllers\web\Settings\ChatSuggestionsController;

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


Route::group(['prefix'=>'chat-suggestions'],function (){
    Route::controller(ChatSuggestionsController::class)->group(function () {
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

        Route::post('/get/chat-suggestions', 'GetChatSuggestions');
    });
});
