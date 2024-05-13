<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\users\CustomerController;
use App\Http\Controllers\web\users\userRoleController;
use App\Http\Controllers\web\users\userController;
use App\Http\Controllers\web\users\PasswordChangeController;

Route::group(['prefix'=>'user-roles'],function (){
    Route::controller(userRoleController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/view', 'index');
        Route::post('/data', 'TableView');
        Route::get('/create', 'Create');
        Route::get('/edit/{RoleID}', 'Edit');
        Route::POST('/json/{RoleID}', 'RoleData');
        Route::post('/create', 'Save');
        Route::POST('/edit/{RoleID}', 'Update');

        Route::POST('get/menus-data', 'getMenuData');
    });
});

Route::group(['prefix'=>'users'],function (){
    Route::controller(userController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/view', 'index');
        Route::get('/create', 'create');
        Route::get('/edit/{UserID}', 'edit');
        Route::get('/restore', 'restoreView');


        Route::post('/data', 'TableView');
        Route::post('/restore-data', 'RestoreTableView');
        Route::post('/create', 'save');
        Route::post('/edit/{UserID}', 'update');
        Route::post('/delete/{UserID}', 'Delete');
        Route::post('/restore/{UserID}', 'Restore');

        Route::post('/get/user-roles', 'getUserRoles');
        Route::post('/get/password', 'getPassword');
        Route::post('/validate/{Type}', 'getValidate');
    });
});
Route::controller(PasswordChangeController::class)->group(function () {
    Route::get('/change-password', 'PasswordChange');
    Route::post('/change-password', 'PasswordUpdate');
});

Route::group(['prefix'=>'manage-customers'],function (){
    Route::controller(CustomerController::class)->group(function () {
        Route::get('/', 'view');
        Route::post('/data', 'TableView');

        Route::get('/create', 'create');
        Route::get('/edit/{CID}', 'edit');
        Route::post('/create', 'save');
        Route::post('/edit/{CID}', 'update');
        Route::post('/delete/{CID}', 'delete');
        Route::post('/set-default-address', 'SetDefaultAddress');
        Route::get('/trash-view/', 'TrashView');
        Route::post('/trash-data', 'TrashTableView');
        Route::post('/restore/{CID}', 'Restore');

        Route::post('/address-view','addressView');
        Route::post('/get/customer-type','getCustomerType')->name('getCustomerType');

        Route::post('/get/customer-data','getCustomerData');

    });
});
