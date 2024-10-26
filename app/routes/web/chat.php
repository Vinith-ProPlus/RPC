<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\chatController;
Route::controller(chatController::class)->group(function () {
    Route::get('/', 'chatView')->name('admin.chat');
    Route::Post('/send/message/{ChatID}', 'sendMessage')->name('admin.chat.send.message');
    Route::group(['prefix'=>'get'],function (){
        Route::Post('/chat-list', 'getChatList')->name('admin.chat.get.chat-list');
        Route::Post('/account-details/{ChatID}', 'getAccountDetails')->name('admin.chat.get.account-details');
        Route::Post('/chat-history/{ChatID}', 'getChatHistory')->name('admin.chat.get.chat-history');
    });
});