<?php
Route::group(['prefix'=>'general'],function (){
    require __DIR__.'/general.php';
});
Route::group(['prefix'=>'vendor'],function (){
    require __DIR__.'/vendor.php';
});
Route::group(['prefix'=>'product'],function (){
    require __DIR__.'/product.php';
});