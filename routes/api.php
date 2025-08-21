<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);


Route::middleware('auth:sanctum')->controller(UserController::class)->group(function () {
    Route::get('/profile', 'profile');
    Route::get('/logout', 'logout');
    Route::resource('/tasks', TaskController::class);
});
