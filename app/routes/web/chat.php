<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\chatController;
Route::controller(chatController::class)->group(function () {
    Route::get('/', 'chatView')->name('admin.chat');
    Route::get('/pdf', 'pdfView')->name('admin.chat.pdf');
    Route::Post('/send/message/{ChatID}', 'sendMessage')->name('admin.chat.send.message');
    Route::Post('/send/attachment/{ChatID}', 'sendAttachment')->name('admin.chat.send.attachment');
    Route::Post('/delete/chat/{ChatID}', 'deleteChat')->name('admin.chat.delete');
    Route::Post('/block/chat/{ChatID}', 'blockChat')->name('admin.chat.block');
    Route::Post('/unblock/chat/{ChatID}', 'unblockChat')->name('admin.chat.unblock');
    Route::group(['prefix'=>'get'],function (){
        Route::Post('/chat-list', 'getChatList')->name('admin.chat.get.chat-list');
        Route::Post('/account-details/{ChatID}', 'getAccountDetails')->name('admin.chat.get.account-details');
        Route::Post('/chat-history/{ChatID}', 'getChatHistory')->name('admin.chat.get.chat-history');
    });
});