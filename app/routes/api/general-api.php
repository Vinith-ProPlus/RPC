<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\GeneralAPIController;

Route::controller(GeneralAPIController::class)->group(function () {
    Route::post('/get/google-auth-secret','getGoogleAuthSecret');
    Route::post('/get/gender','getGender');

    Route::post('/get/country','getCountry');
    Route::post('/get/states','getState');
    Route::post('/get/districts','getDistrict');
    Route::post('/get/taluks','getTaluk');
    Route::post('/get/city','getCity');
    Route::post('/get/postal-code','getPostalCode');
    Route::post('/get/vehicle-type','getVehicleType');
    Route::post('/get/vehicle-brand','getVehicleBrand');
    Route::post('/get/vehicle-model','getVehicleModel');

    Route::post('/get/category','getCategory');
    Route::post('/get/sub-category','getSubCategory');
    Route::post('/get/products','getProducts');

    Route::post('/get/vendor-type','getVendorType');
    Route::post('/tmp/file-upload','tmpFileUpload');
    Route::post('/get/max-file-size','getMaxFileSize');

    Route::post('/get/stages','getStages');
    Route::post('/get/building-measurements','getBuildingMeasurements');

    Route::post('/get/reject-reason-type','getRejectReasonType');
    Route::post('/get/reject-reason','getRejectReason');

    Route::post('/get/support-type','getSupportType');
    Route::post('/get/cms','getCMS');
    Route::post('/get/banner-images','getBannerImages');
    Route::post('/get/stepper-images','getStepperImages');

    Route::post('/get/co-ordinates','getCoordinates');
    Route::post('/get/distance','calculateDistance');
    Route::get('/get/company-details','getCompanyDetails');
});
