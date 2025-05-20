<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CategoryController;

Route::middleware('auth:sanctum')->group(function () {

    // Profil-Routen (Web/Blade, falls du sie API-mäßig angepasst hast, dann auch verschieben)
    Route::get('/profile', [ProfileController::class, 'edit']);
    Route::patch('/profile', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);

    // Produkte-API
    Route::apiResource('products', ProductController::class);

    // Kategorien-API
    Route::apiResource('categories', CategoryController::class);
});
