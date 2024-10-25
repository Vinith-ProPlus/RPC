<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\chatController;
Route::controller(chatController::class)->group(function () {
    Route::get('/', 'chatView')->name('admin.chat');
    Route::group(['prefix'=>'get'],function (){
        Route::Post('/chat-list', 'getChatList')->name('admin.chat.get.chat-list');
    });
});