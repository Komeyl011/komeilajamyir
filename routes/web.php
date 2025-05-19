<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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

Route::group(['middleware' => 'web'], function () {
    Route::post('/change-lang', \App\Http\Controllers\ChangeLangController::class)->name('language.change');

    Route::get('/download', function () {
        return Storage::download('public/telBot/links_gen_bot/' . $_GET['uri']);
    })->name('file.download');

    Route::post('/contact', \App\Http\Controllers\ContactMeController::class)->name('contact-form.store')->domain(env('APP_URL'));

    Route::group(['namespace' => 'App\Livewire'], function () {
        Route::domain(env('APP_URL'))->group(function () {
            Route::get('/', 'Main')->name('home');
        });

        // Route::get('chatbot', 'ChatBotWeb')->name('chat-bot.show');

        // Website's blog routes
        Route::group(['prefix' => 'blog'], function () {
            Route::get('/', 'BlogMain')->name('blog.home');
            Route::get('post/{slug}', 'ShowPost')->name('blog.post.show');
        });
    });

    Route::get('/email/verify/{id}/{hash}', [\App\Http\Controllers\Auth\EmailVerificationController::class, 'verifyEmail'])
        ->middleware(['auth', 'signed'])->name('verification.verify');
});

/**
 * Telegram Bot Routes
 */
Route::group(['prefix' => 'bot'], function () {
    Route::group(['namespace' => 'App\Http\Controllers\Bot'], function () {
        // Routes for LinksGen telegram bot
        Route::post('/6713833321:AAGv2SeCiy6WEvNpK0iArB8xNrDzbqjgEls', 'LinksBotController')->name('links-generator-bot.init');

        // Routes for ChatBot telegram bot
        Route::post('/7536836506:AAFfSsCJnWPB4Tr7E2PD_7EkmgX3Myf_NhU', 'ChatBotController@index')->name('chatbot.init');

        // Routes for PersonalManager Bot
        Route::post('/7523647310:AAFJXucIsv_-LVdj0pe1_sYFV_Gfb2iJZXQ', 'PersonalManagerController')->name('personalbot.init');
    });
});
