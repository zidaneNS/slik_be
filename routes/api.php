<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\KreditController;
use App\Http\Controllers\SlikController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);

    Route::apiResource('forms', FormController::class);
    Route::apiResource('sliks', SlikController::class);
    Route::apiResource('kredits', KreditController::class);
    Route::apiResource('categories', CategoryController::class);
});