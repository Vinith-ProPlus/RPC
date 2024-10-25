<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\chatController;
Route::controller(chatController::class)->group(function () {
    Route::get('/', 'chatView')->name('admin.chat');
});