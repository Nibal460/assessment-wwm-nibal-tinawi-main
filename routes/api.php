<?php

/**
 * @OA\Info(
 *     title="Meine API",
 *     version="1.0.0",
 *     description="API Dokumentation für mein Projekt"
 * )
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\OrderController;



Route::middleware('auth:sanctum')->group(function () {

    // Diese Routes geben JSON zurück
    Route::get('/profile', [ProfileController::class, 'edit']);
    Route::patch('/profile', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);

    // Produkte-API
    Route::apiResource('products', ProductController::class);

    // Kategorien-API
    Route::apiResource('categories', CategoryController::class);


    Route::post('/orders', [OrderController::class, 'store']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products/search', [ProductController::class, 'search']);


