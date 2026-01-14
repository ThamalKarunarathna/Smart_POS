<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemPriceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\DeliveryNoteController;
use App\Http\Controllers\GrnController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ChartOfAccountController;
use App\Http\Controllers\JournalEntryController;
use App\Http\Controllers\BillEntryController;
use App\Http\Controllers\PaymentVoucherController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ReportController;



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

    // Receipts Routes
    Route::get('/pos/receipts', [ReceiptController::class, 'index']);
    Route::get('/pos/receipts/create', [ReceiptController::class, 'create']);
    Route::post('/pos/receipts', [ReceiptController::class, 'store']);
    Route::get('/pos/receipts/customer-orders', [ReceiptController::class, 'getCustomerUnpaidOrders']);

    // Delivery Notes Routes
    Route::get('/delivery-notes', [DeliveryNoteController::class, 'index'])->name('delivery_notes.index');
    Route::get('/delivery-notes/{id}', [DeliveryNoteController::class, 'show'])->name('delivery_notes.show');
    Route::get('/delivery-notes/{id}/print', [DeliveryNoteController::class, 'print'])->name('delivery_notes.print');

    // PO Approval Route
    Route::get('/inventory/po/approval', [PurchaseOrderController::class, 'approvalIndex'])->name('po.approval');

    // GRN Approval Route
    Route::get('/inventory/grn/approval', [GrnController::class, 'approvalIndex'])->name('grn.approval');

    // Payment Voucher Approval Route
    Route::get('/finance/payment_vouchers/approval', [PaymentVoucherController::class, 'approvalIndex'])->name('payment_vouchers.approval');


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
    Route::get('/finance/chart_of_accounts', [ChartOfAccountController::class, 'index']);
    Route::get('/finance/chart_of_accounts/create', [ChartOfAccountController::class, 'create']);
    Route::post('/finance/chart_of_accounts', [ChartOfAccountController::class, 'store']);
    Route::get('/finance/chart_of_accounts/{id}/edit', [ChartOfAccountController::class, 'edit']);
    Route::put('/finance/chart_of_accounts/{id}', [ChartOfAccountController::class, 'update']);

    // Bill Entries Routes
    Route::get('/finance/bill_entries', [BillEntryController::class, 'index']);
    Route::get('/finance/bill_entries/create', [BillEntryController::class, 'create']);
    Route::post('/finance/bill_entries', [BillEntryController::class, 'store']);
    Route::get('/finance/bill_entries/{id}/edit', [BillEntryController::class, 'edit']);
    Route::put('/finance/bill_entries/{id}', [BillEntryController::class, 'update']);
    Route::get('/finance/bill_entries/{id}', [BillEntryController::class, 'show']);
    Route::delete('/finance/bill_entries/{id}', [BillEntryController::class, 'destroy']);

    // Journal Entries Routes
    Route::get('/finance/journal_entries', [JournalEntryController::class, 'index']);
    Route::get('/finance/journal_entries/create', [JournalEntryController::class, 'create']);
    Route::post('/finance/journal_entries', [JournalEntryController::class, 'store']);
    Route::get('/finance/journal_entries/{id}/edit', [JournalEntryController::class, 'edit']);
    Route::put('/finance/journal_entries/{id}', [JournalEntryController::class, 'update']);
    Route::get('/finance/journal_entries/{id}', [JournalEntryController::class, 'show']);
    Route::delete('/finance/journal_entries/{id}', [JournalEntryController::class, 'destroy']);

    // Payment Vouchers Routes
    Route::get('payment_vouchers/pending', [PaymentVoucherController::class, 'pending'])->name('payment_vouchers.pending');
    Route::get('/finance/payment_vouchers', [PaymentVoucherController::class, 'index']);
    Route::get('/finance/payment_vouchers/create', [PaymentVoucherController::class, 'create']);
    Route::post('/finance/payment_vouchers', [PaymentVoucherController::class, 'store']);
    Route::get('/finance/payment_vouchers/{id}/edit', [PaymentVoucherController::class, 'edit']);
    Route::put('/finance/payment_vouchers/{id}', [PaymentVoucherController::class, 'update']);
    Route::get('/finance/payment_vouchers/{id}', [PaymentVoucherController::class, 'show']);
    Route::get('/finance/payment_vouchers/showapproval/{id}', [PaymentVoucherController::class, 'show_approval'])->name('payment_voucher.show_approval');
    Route::delete('/finance/payment_vouchers/{id}', [PaymentVoucherController::class, 'destroy']);

    // Payment Voucher Approval Routes


    // IMPORTANT: use model binding param {voucher} to match controller approve(PaymentVoucher $voucher)
    Route::post('/finance/payment_vouchers/{voucher}/approve', [PaymentVoucherController::class, 'approve'])->name('payment_vouchers.approve');
    Route::post('/finance/payment_vouchers/{voucher}/reject', [PaymentVoucherController::class, 'reject'])->name('payment_vouchers.reject');

    // Reports Routes
    Route::get('/reports/sales', [ReportController::class, 'salesReport'])->name('reports.sales');
    Route::get('/reports/stock', [ReportController::class, 'stockReport'])->name('reports.stock');
    Route::get('/reports/customer-details', [ReportController::class, 'customerDetailsReport'])->name('reports.customer-details');
});

require __DIR__ . '/auth.php';
