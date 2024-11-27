<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

Route::get('/', [AdController::class, 'index'])->name('home');

Route::resource('ads', AdController::class)->only(['index', 'show']);

Route::get('/search', [AdController::class, 'search'])->name('ads.search');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('ads', AdController::class)->except(['index', 'show']);

    Route::get('/my-ads', [UserController::class, 'myAds'])->name('user.my_ads');

    Route::prefix('/ads/{adId}/favorites')->group(function () {
        Route::post('/', [UserController::class, 'addFavorite'])->name('favorites.add');
        Route::delete('/', [UserController::class, 'removeFavorite'])->name('favorites.remove');
    });
    Route::get('/favorites', [UserController::class, 'favoriteAds'])->name('favorites.list');

    Route::post('/ads/{ad}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

Auth::routes();
