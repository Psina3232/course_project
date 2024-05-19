<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

Route::post('ads/{ad}/comments', [CommentController::class, 'store'])->name('comments.store');


Route::resource('ads', AdController::class);
Route::get('/', [AdController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('ads', AdController::class);
    Route::post('/ads/{ad}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/ads/{ad}/edit', [AdController::class, 'edit'])->name('ads.edit');
    Route::put('/ads/{ad}', [AdController::class, 'update'])->name('ads.update');
    Route::delete('/ads/{ad}', [AdController::class, 'destroy'])->name('ads.destroy');
});

Route::get('/ads/{ad}', [AdController::class, 'show'])->name('ads.show');
Route::get('/search', [AdController::class, 'search'])->name('ads.search');

Auth::routes();


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/search', [AdController::class, 'search'])->name('ads.search');

Route::get('/my-ads', [UserController::class, 'myAds'])->middleware('auth')->name('user.my_ads');



