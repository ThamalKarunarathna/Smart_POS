<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemPriceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'admin'])->group(function () {

    // Items CRUD
    Route::get('/items', [ItemController::class, 'index']);
    Route::get('/items/create', [ItemController::class, 'create']);
    Route::post('/items', [ItemController::class, 'store']);
    Route::get('/items/{id}/edit', [ItemController::class, 'edit']);
    Route::put('/items/{id}', [ItemController::class, 'update']);
    Route::delete('/items/{id}', [ItemController::class, 'destroy']);

    // Item Prices
    Route::get('/items/{id}/prices', [ItemPriceController::class, 'create']);
    Route::post('/items/{id}/prices', [ItemPriceController::class, 'store']);

    // Customers CRUD
    Route::get('/customers', [CustomerController::class, 'index']);
    Route::get('/customers/create', [CustomerController::class, 'create']);
    Route::post('/customers', [CustomerController::class, 'store']);
    Route::get('/customers/{id}/edit', [CustomerController::class, 'edit']);
    Route::put('/customers/{id}', [CustomerController::class, 'update']);
    Route::patch('/customers/{id}/toggle', [CustomerController::class, 'toggleActive']);
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy']);

    // Orders CRUD
    Route::get('/pos/orders', [OrderController::class, 'index']);
    Route::get('/pos/orders/create', [OrderController::class, 'create']);
    Route::post('/pos/orders', [OrderController::class, 'store']);

    Route::get('/pos/orders/{id}/edit', [OrderController::class, 'edit']);
    Route::put('/pos/orders/{id}', [OrderController::class, 'update']);

    Route::patch('/pos/orders/{id}/cancel', [OrderController::class, 'cancel']);
    Route::get('/pos/orders/{id}/print', [OrderController::class, 'print']);
});

require __DIR__.'/auth.php';
