<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;


Route::post('ads/{ad}/comments', [CommentController::class, 'store'])->name('comments.store');


Route::resource('ads', AdController::class);
Route::get('/', [AdController::class, 'index'])->name('home');
Route::get('/ads', [AdController::class, 'index']);

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


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/search', [AdController::class, 'search'])->name('ads.search');

Route::middleware('auth:sanctum')->get('/my-ads', [UserController::class, 'myAds']);

// Добавление объявления в избранное
Route::middleware('auth:sanctum')->post('/ads/{adId}/favorites', [UserController::class, 'addFavorite']);

// Удаление объявления из избранного
Route::middleware('auth:sanctum')->delete('/ads/{adId}/favorites', [UserController::class, 'removeFavorite']);

// Получение списка избранных объявлений
Route::middleware('auth:sanctum')->get('/favorites', [UserController::class, 'favoriteAds']);



