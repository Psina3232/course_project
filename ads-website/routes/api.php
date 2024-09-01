<?php
/*
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

// Регистрация нового пользователя
Route::post('/register', [RegisterController::class, 'register']);

// Вход пользователя
Route::post('/login', [LoginController::class, 'login']);

// Маршрут для выхода из системы (требуется аутентификация)
Route::middleware('auth:sanctum')->post('/logout', [LoginController::class, 'logout']);

// Создание нового объявления (требуется аутентификация)
Route::middleware('auth:sanctum')->post('/ads', [AdController::class, 'store']);

// Получение списка объявлений
Route::get('/ads', [AdController::class, 'index']);

// Получение одного объявления
Route::get('/ads/{ad}', [AdController::class, 'show']);

// Обновление объявления (требуется аутентификация)
Route::middleware('auth:sanctum')->put('/ads/{ad}', [AdController::class, 'update']);

// Удаление объявления (требуется аутентификация)
Route::middleware('auth:sanctum')->delete('/ads/{ad}', [AdController::class, 'destroy']);

// Создание комментария к объявлению (требуется аутентификация)
Route::middleware('auth:sanctum')->post('/ads/{ad}/comments', [CommentController::class, 'store']);

// Получение моих объявлений (требуется аутентификация)
Route::middleware('auth:sanctum')->get('/my-ads', [UserController::class, 'myAds']); -->
*/