<?php

use App\Http\Controllers\web\reports\LedgerController;
use App\Http\Controllers\web\reports\OutstandingsController;


Route::group(['prefix'=>'ledger'],function (){
    Route::controller(LedgerController::class)->group(function () {
        Route::get('/', 'index')->name('admin.reports.ledger');
        Route::get('/details/{LedgerID}', 'details')->name('admin.reports.ledger.details');
        Route::POST('/accounts', 'getLedgerAccounts')->name('admin.reports.ledger.get.accounts');
        Route::POST('/data', 'TableView')->name('admin.reports.ledger.data');
        Route::POST('/ledger-view', 'LedgerTableView')->name('admin.reports.ledger.ledger-view');
    });
});

Route::group(['prefix'=>'outstandings'],function (){
    Route::controller(OutstandingsController::class)->group(function () {
        Route::get('/', 'index')->name('admin.reports.outstandings');
        Route::POST('/data', 'TableView')->name('admin.reports.outstandings.data');
    });
});