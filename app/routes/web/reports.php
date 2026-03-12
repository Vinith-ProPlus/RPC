<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\reports\LedgerController;
use App\Http\Controllers\web\reports\OutstandingsController;
use App\Http\Controllers\web\reports\CommissionRptController;
use App\Http\Controllers\web\reports\DeliveryStatusRptController;
use App\Http\Controllers\web\reports\OrderDueRptController;
use App\Http\Controllers\web\reports\PerformanceAnalysisRptController;

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
Route::group(['prefix'=>'commision-report'],function (){
    Route::controller(CommissionRptController::class)->group(function () {
        Route::get('/', 'index')->name('admin.reports.commision');
        Route::POST('/data', 'TableView')->name('admin.reports.commision.data');
        Route::POST('/get/vendors', 'getVendors')->name('admin.reports.commision.get.vendors');
    });
});
Route::group(['prefix'=>'performance-analysis'],function (){
    Route::controller(PerformanceAnalysisRptController::class)->group(function () {
        Route::get('/', 'index')->name('admin.reports.performance');
        Route::POST('/data', 'TableView')->name('admin.reports.performance.data');
    });
});
Route::group(['prefix'=>'orders-due-report'],function (){
    Route::controller(OrderDueRptController::class)->group(function () {
        Route::get('/', 'index')->name('admin.reports.orders-due');
        Route::POST('/data', 'TableView')->name('admin.reports.orders-due.data');
    });
});
Route::group(['prefix'=>'delivery-status-report'],function (){
    Route::controller(DeliveryStatusRptController::class)->group(function () {
        Route::get('/', 'index')->name('admin.reports.delivery-status');
        
        Route::POST('/data', 'TableView')->name('admin.reports.delivery-status.data');

        
        Route::post('/get/filter/status', 'getStatus')->name('admin.reports.delivery-status.get.filter.status');
        Route::post('/get/filter/vendor', 'getVendors')->name('admin.reports.delivery-status.get.filter.vendor');
        Route::post('/get/filter/customer', 'getCustomers')->name('admin.reports.delivery-status.get.filter.customer');
    });
});