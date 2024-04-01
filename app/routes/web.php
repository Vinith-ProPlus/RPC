<?php

use App\Http\Controllers\Home\HomeAuthController;
use App\Http\Controllers\Home\HomeTransactionController;
use App\Http\Controllers\Home\WishlistController;
use App\Http\Controllers\web\CustomerSupportController;
use App\Http\Controllers\web\loginController;
use App\Http\Controllers\web\dashboardController;
use App\Http\Controllers\web\generalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\web\SupportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cleared!";
});
Route::controller(generalController::class)->group(function () {
    Route::post('/get/country','getCountry');
    Route::post('/get/states','getState');
    Route::post('/get/districts','getDistrict');
    Route::post('/get/taluks','getTaluk');
    Route::post('/get/city','getCity');
    Route::post('/get/postal-code','getPostalCode');
    Route::post('/get/gender','getGender')->name('getGender');
    Route::POST('/get/tax', 'getTax');
    Route::POST('/get/uom', 'getUOM');
    Route::post('/get/bank-type','getBankType');
    Route::post('/get/bank','getBank');
    Route::post('/get/bank-branch','getBankBranch');
    Route::post('/get/bank-account-type','getBankAccountType');
    Route::POST('/get/customer-groups', 'getCustomerGroups');
    Route::POST('/get/product-grades', 'getProductGrades');
    Route::POST('/get/products', 'getProducts');
    Route::POST('/get/financial-years', 'getFinancialYear');
    Route::post('/get/construction-type','getConstructionType')->name('getConstructionType');

    Route::post('/tmp/upload-image','tmpUploadImage');

    Route::POST('/country/create-form','getNewCountry');
    Route::POST('/country/create','createCountry');

    Route::POST('/states/create-form','getNewState');
    Route::POST('/states/create','createState');

    Route::POST('/districts/create-form','getNewDistrict');
    Route::POST('/districts/create','createDistrict');

    Route::POST('/taluks/create-form','getNewTaluk');
    Route::POST('/taluks/create','createTaluk');

    Route::POST('/city/create-form','getNewCity');
    Route::POST('/city/create','createCity');

    Route::POST('/postal-code/create-form','getNewPostalCode');
    Route::POST('/postal-code/create','createPostalCode');

    Route::POST('/gender/create-form','getNewGender');
    Route::POST('/gender/create','createGender');


    Route::post('/get/vehicle-type','getVehicleType');
    Route::post('/get/vehicle-brand','getVehicleBrand');
    Route::post('/get/vehicle-model','getVehicleModel');

    Route::POST('/vehicle-type/create-form','getNewVehicleType');
    Route::POST('/vehicle-type/create','createVehicleType');

    Route::POST('/vehicle-brand/create-form','getNewVehicleBrand');
    Route::POST('/vehicle-brand/create','createVehicleBrand');

    Route::POST('/vehicle-model/create-form','getNewVehicleModel');
    Route::POST('/vehicle-model/create','createVehicleModel');

    Route::POST('/tax/create-form','getNewTax');
    Route::POST('/uom/create-form','getNewUOM');

    Route::POST('/bank-type/create-form','getNewBankType');
    Route::POST('/bank-type/create','createBankType');

    Route::POST('/bank/create-form','getNewBank');
    Route::POST('/bank/create','createBank');

    Route::POST('/bank-branch/create-form','getNewBankBranch');
    Route::POST('/bank-branch/create','createBankBranch');

    Route::POST('/bank-account-type/create-form','getNewBankAccountType');
    Route::POST('/bank-account-type/create','createBankAccountType');

    Route::POST('address-form','getNewAddress');
    Route::POST('shipping-address-form','getNewShippingAddress');
    Route::POST('review-form','getNewReview');

    Route::middleware('auth')->group(function () {
        Route::post('/theme/update','themeUpdate');
        Route::POST('/financial-year/update-active','updateActiveFinancialYear');
    });
});
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'GuestView')->name('homepage');
});

Route::controller(HomeAuthController::class)->group(function () {
    Route::get('/customer-register', 'Register')->name('customer-register');
    Route::get('/customer-profile', 'Profile');
    Route::post('/save', 'Save');
    Route::post('/update', 'Update');
    Route::get('/customer-home', 'Home');

    Route::post('/get/cart','getCart');
    Route::post('/add-cart','AddCart')->name('add-cart');
    Route::post('/update-cart','UpdateCart');
    Route::post('/delete-cart','DeleteCart');
    Route::get('/checkout', 'Checkout')->name('checkout');

    Route::post('/place-order','PlaceOrder');
});

Route::post('setAidInSession', [HomeController::class, 'setAidInSession'])->name('setAidInSession');
Route::get('policies/{Slug}', [HomeController::class, 'policies'])->name('policies');
Route::get('get/iframe-contents/{Slug}', [HomeController::class, 'policiesContent'])->name('policiesContent');
Route::get('guest/products', [HomeController::class, 'products'])->name('guest.products');
Route::get('guest/products/quickView/html/{PID}', [HomeController::class, 'quickViewHtml'])->name('guest.products.quickView');
Route::post('guest/products/get/categories/html', [HomeController::class, 'categoriesHtml'])->name('guest.products.categoriesHtml');
Route::post('guest/products/get/products/html', [HomeController::class, 'productsHtml'])->name('guest.products.productsHtml');
Route::get('products/category-list', [HomeController::class, 'categoryList'])->name('products.categoriesList');
Route::get('products/sub-category-list', [HomeController::class, 'subCategoryList'])->name('products.subCategoryList');
Route::get('products/products-list', [HomeController::class, 'productsList'])->name('products.productsList');
Route::post('products/category-list-html', [HomeController::class, 'categoryListHtml'])->name('products.categoriesListHtml');
Route::post('products/sub-category-list-html', [HomeController::class, 'subCategoryListHtml'])->name('products.subCategoriesListHtml');
Route::post('products/products-list-html', [HomeController::class, 'productsListHtml'])->name('products.productsListHtml');

Route::get('guest/products/category-list', [HomeController::class, 'guestCategoryList'])->name('products.guest.categoriesList');
Route::get('guest/products/sub-category-list', [HomeController::class, 'guestSubCategoryList'])->name('products.guest.subCategoryList');
Route::get('guest/products/products-list', [HomeController::class, 'guestProductsList'])->name('products.guest.productsList');
Route::post('guest/products/category-list-html', [HomeController::class, 'guestCategoryListHtml'])->name('products.guest.categoriesListHtml');
Route::post('guest/products/sub-category-list-html', [HomeController::class, 'guestSubCategoryListHtml'])->name('products.guest.subCategoriesListHtml');
Route::post('guest/products/products-list-html', [HomeController::class, 'guestProductsListHtml'])->name('products.guest.productsListHtml');
Route::get('guest/product/view/{ID}', [HomeController::class, 'guestProductView'])->name('guest.product.view');


Route::get('customer/products/category-list', [HomeAuthController::class, 'customerCategoryList'])->name('products.customer.categoriesList');
Route::get('customer/products/sub-category-list', [HomeAuthController::class, 'customerSubCategoryList'])->name('products.customer.subCategoryList');
Route::get('customer/products/products-list', [HomeAuthController::class, 'customerProductsList'])->name('products.customer.productsList');
Route::post('customer/products/category-list-html', [HomeAuthController::class, 'customerCategoryListHtml'])->name('products.customer.categoriesListHtml');
Route::post('customer/products/sub-category-list-html', [HomeAuthController::class, 'customerSubCategoryListHtml'])->name('products.customer.subCategoriesListHtml');
Route::post('customer/products/products-list-html', [HomeAuthController::class, 'customerProductsListHtml'])->name('products.customer.productsListHtml');
Route::post('customer/order/review/save', [HomeAuthController::class, 'customerReviewSave'])->name('customer.order.review.save');
Route::get('customer/product/view/{ID}', [HomeAuthController::class, 'customerProductView'])->name('customer.product.view');



Route::get('products', [HomeAuthController::class, 'products'])->name('products');
Route::get('products/quickView/html/{PID}', [HomeAuthController::class, 'quickViewHtml'])->name('products.quickView');
Route::post('products/get/categories/html', [HomeAuthController::class, 'categoriesHtml'])->name('products.categoriesHtml');
Route::post('products/get/products/html', [HomeAuthController::class, 'productsHtml'])->name('products.productsHtml');
Route::post('products/wishlist/add', [WishlistController::class, 'addWishlist'])->name('products.addWishlist');
Route::post('products/wishlist/remove', [WishlistController::class, 'removeWishlist'])->name('products.removeWishlist');
Route::get('requested-quotations', [HomeTransactionController::class, 'quotations'])->name('requested-quotations');
Route::post('requested-quotations/data', [HomeTransactionController::class, 'quotationData'])->name('requested-quotations.data');
Route::get('quotations/view/{EnqID}', [HomeAuthController::class, 'CustomerQuoteView'])->name('customer.quotations.QuoteView');
Route::get('my-account', [HomeTransactionController::class, 'myAccount'])->name('my-account');
Route::post('profileHtml', [HomeAuthController::class, 'profileHtml'])->name('profileHtml');
Route::get('wishlist', [HomeTransactionController::class, 'wishlist'])->name('wishlist');
Route::post('wishlistTableHtml', [HomeAuthController::class, 'wishlistTableHtml'])->name('wishlistTableHtml');
Route::post('supportTableHtml', [HomeAuthController::class, 'supportTableHtml'])->name('supportTableHtml');
Route::post('quotationTableHtml', [HomeAuthController::class, 'quotationTableHtml'])->name('quotationTableHtml');
Route::post('orderTableHtml', [HomeAuthController::class, 'orderTableHtml'])->name('orderTableHtml');
Route::get('order/view/{OrderID}', [HomeAuthController::class, 'CustomerOrderView'])->name('CustomerOrderView');
Route::post('customerHomeSearch', [HomeAuthController::class, 'customerHomeSearch'])->name('customerHomeSearch');
Route::post('guestHomeSearch', [HomeController::class, 'guestHomeSearch'])->name('guestHomeSearch');
Route::post('UpdateShippingAddress', [HomeAuthController::class, 'UpdateShippingAddress'])->name('UpdateShippingAddress');
Route::post('SetAddressDefault', [HomeAuthController::class, 'SetAddressDefault'])->name('SetAddressDefault');
Route::post('DeleteShippingAddress', [HomeAuthController::class, 'DeleteShippingAddress'])->name('DeleteShippingAddress');
Route::post('getNotifications', [HomeAuthController::class, 'getNotifications'])->name('getNotifications');
Route::get('productShortDescription/{PID}', [HomeController::class, 'productShortDescription'])->name('productShortDescription');
Route::get('productDescription/{PID}', [HomeController::class, 'productDescription'])->name('productDescription');

//Customer Support details
Route::post('customer/support/get/details', [CustomerSupportController::class, 'getDetails'])->name('customer.support.getDetails');
Route::post('customer/support/new-ticket', [CustomerSupportController::class, 'NewTicket'])->name('customer.support.NewTicket');
Route::post('customer/support/new-ticket/save', [CustomerSupportController::class, 'SaveTicket'])->name('customer.support.SaveTicket');
Route::post('customer/support/details/save', [CustomerSupportController::class, 'SupportDetailsSave'])->name('customer.support.SupportDetailsSave');
Route::get('customer/support/details/{SID}', [CustomerSupportController::class, 'SupportDetailsView'])->name('customer.support.SupportDetailsView');

// Customer Quotation
Route::post('/cancel/{QID}', [HomeAuthController::class, 'QuoteCancel'])->name('customer.quotes.cancel');
Route::post('/approve/{QID}', [HomeAuthController::class, 'QuoteApprove'])->name('customer.quotes.approve');
Route::post('/cancel-item/{DetailID}', [HomeAuthController::class, 'QuoteItemCancel'])->name('customer.quotes.cancel-item');
Route::post('/get/cancel-reasons', [HomeAuthController::class, 'getCancelReasons'])->name('customer.quotes.get.cancel-reasons');


Route::controller(SocialController::class)->group(function () {
    Route::get('/social/auth/{provider}', 'redirect');
    Route::get('/social/callback/{provider}', 'callback');
});
Route::group(['prefix'=>'admin'],function (){
    Route::controller(loginController::class)->group(function () {
        Route::post('/auth/login', 'login');
    });
    Route::middleware('auth')->group(function () {
        Route::controller(dashboardController::class)->group(function () {
            Route::get('/','dashboard')->name('admin.dashboard');
            Route::get('/dashboard','dashboard');
            Route::post('/dashboard/get/dashboard-stats','getDashboardStats')->name('admin.dashboard.get.dashboard-stats');
            Route::post('/dashboard/get/recent/quote-enquiry','getRecentQuoteEnquiry')->name('admin.dashboard.get.recent.quote-enquiry');
            Route::post('/dashboard/get/recent/orders','getRecentOrders')->name('admin.dashboard.get.recent.orders');
            Route::post('/dashboard/get/orders/stats','getOrderStats')->name('admin.dashboard.get.orders.stats');
            Route::post('/dashboard/get/payments/stats','getPaymentStats')->name('admin.dashboard.get.payments.stats');
            Route::get('/dashboard/get/upcoming/payments','getUpcomingPayments')->name('admin.dashboard.get.upcoming.payments');
            Route::POST('/dashboard/get/circle/stats/enquiry','getEnquiryCircleStats')->name('admin.dashboard.get.circle.stats.enquiry');
            Route::POST('/dashboard/get/circle/stats/orders','getOrdersCircleStats')->name('admin.dashboard.get.circle.stats.orders');
            Route::POST('/dashboard/get/circle/stats/delivery','getDeliveryCircleStats')->name('admin.dashboard.get.circle.stats.delivery');
        });
        Route::group(['prefix'=>'settings'],function (){
            require __DIR__.'/web/settings.php';
        });
        Route::group(['prefix'=>'support'],function (){
            Route::controller(SupportController::class)->group(function () {
                Route::get('/', 'SupportView');
                Route::post('/data', 'TableView');
                Route::post('/get/details', 'getDetails');
                Route::post('/new-ticket', 'NewTicket');
                Route::post('/new-ticket/save', 'SaveTicket');
                Route::post('/details/save', 'SupportDetailsSave');
                Route::post('/delete/{SID}', 'DeleteSupport');
                Route::post('/activate/{SID}', 'ActivateSupport');
                Route::post('/deactivate/{SID}', 'DeactivateSupport');
                Route::get('/details/{SID}', 'SupportDetailsView');
            });
        });
        Route::group(['prefix'=>'master'],function (){
            require __DIR__.'/web/masters/master.php';
        });
        Route::group(['prefix'=>'transaction'],function (){
            require __DIR__.'/web/transaction.php';
        });
        Route::group(['prefix'=>'reports'],function (){
            require __DIR__.'/web/reports.php';
        });
        Route::group(['prefix'=>'home'],function (){
            require __DIR__.'/web/home.php';
        });
        Route::group(['prefix'=>'users-and-permissions'],function (){
            require __DIR__.'/web/users.php';
        });

    });
});
require __DIR__.'/auth.php';
