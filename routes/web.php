<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/dashboard/staff', function () {
    return view('dashboard-staff');
})->middleware(['auth'])->name('dashboard.staff');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Produkt-Routen
Route::resource('products', ProductController::class)->middleware('auth');

// Kategorie-Routen hinzufügen
Route::resource('categories', CategoryController::class)->middleware('auth');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

