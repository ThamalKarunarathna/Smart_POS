<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemPriceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\GrnController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ChartOfAccountController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

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

    // PO Approval Route
    Route::get('/inventory/po/approval', [PurchaseOrderController::class, 'approvalIndex'])->name('po.approval');

    // GRN Approval Route
    Route::get('/inventory/grn/approval', [GrnController::class, 'approvalIndex'])->name('grn.approval');

    // PO Routes
    Route::get('/inventory/po', [PurchaseOrderController::class, 'index'])->name('po.index');
    Route::get('/inventory/po/create', [PurchaseOrderController::class, 'create'])->name('po.create');
    Route::post('/inventory/po', [PurchaseOrderController::class, 'store'])->name('po.store');

    Route::get('/inventory/po/{po}', [PurchaseOrderController::class, 'show'])->name('po.show');
    Route::get('/inventory/po/{po}/edit', [PurchaseOrderController::class, 'edit'])->name('po.edit');
    Route::put('/inventory/po/{po}', [PurchaseOrderController::class, 'update'])->name('po.update');
    Route::delete('/inventory/po/{po}', [PurchaseOrderController::class, 'destroy'])->name('po.destroy');

    // PO Status flow
    Route::post('/inventory/po/{po}/submit', [PurchaseOrderController::class, 'submit'])->name('po.submit');

    // PO Approval
    Route::post('/inventory/po/{po}/approve', [PurchaseOrderController::class, 'approve'])->name('po.approve');
    Route::post('/inventory/po/{po}/reject', [PurchaseOrderController::class, 'reject'])->name('po.reject');


    // GRN Pending PO Route
    Route::get('/inventory/grn/pending', [GrnController::class, 'pendingIndex'])->name('grn.pending_grn');

    // GRN
    Route::get('/inventory/grn', [GrnController::class, 'index'])->name('grn.index');

    // Create GRN against approved PO
    Route::get('/inventory/po/{po}/grn/create', [GrnController::class, 'create'])->name('grn.create');
    Route::post('/inventory/po/{po}/grn', [GrnController::class, 'store'])->name('grn.store');

    Route::get('/inventory/grn/{grn}', [GrnController::class, 'show'])->name('grn.show');
    Route::get('/inventory/grn/{grn}/edit', [GrnController::class, 'edit'])->name('grn.edit');
    Route::put('/inventory/grn/{grn}', [GrnController::class, 'update'])->name('grn.update');
    Route::delete('/inventory/grn/{grn}', [GrnController::class, 'destroy'])->name('grn.destroy');

    // Submit + approve
    Route::post('/inventory/grn/{grn}/submit', [GrnController::class, 'submit'])->name('grn.submit');
    Route::post('/inventory/grn/{grn}/approve', [GrnController::class, 'approve'])->name('grn.approve');
    Route::post('/inventory/grn/{grn}/reject', [GrnController::class, 'reject'])->name('grn.reject');

    // Supplier Routes
    Route::get('/suppliers', [SupplierController::class, 'index']);
    Route::get('/suppliers/create', [SupplierController::class, 'create']);
    Route::post('/suppliers', [SupplierController::class, 'store']);
    Route::get('/suppliers/{id}/edit', [SupplierController::class, 'edit']);
    Route::put('/suppliers/{id}', [SupplierController::class, 'update']);
    Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy']);

    // Chart of Accounts Routes
    Route::get('/finance/chart_of_accounts', [App\Http\Controllers\ChartOfAccountController::class, 'index']);
    Route::get('/finance/chart_of_accounts/create', [App\Http\Controllers\ChartOfAccountController::class, 'create']);
    Route::post('/finance/chart_of_accounts', [App\Http\Controllers\ChartOfAccountController::class, 'store']);
    Route::get('/finance/chart_of_accounts/{id}/edit', [App\Http\Controllers\ChartOfAccountController::class, 'edit']);
    Route::put('/finance/chart_of_accounts/{id}', [App\Http\Controllers\ChartOfAccountController::class, 'update']);



});

require __DIR__.'/auth.php';
