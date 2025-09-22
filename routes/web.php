<?php

// Placeholder routes for dashboard links
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/orders', fn() => view('placeholders.orders'))->name('orders.index');
    Route::get('/quotes', fn() => view('placeholders.quotes'))->name('quotes.index');
    Route::get('/shipments', fn() => view('placeholders.shipments'))->name('shipments.index');
    Route::get('/invoices', fn() => view('placeholders.invoices'))->name('invoices.index');
    Route::get('/quick-order', fn() => view('placeholders.quick_order'))->name('quick-order.show');
    Route::get('/bom-upload', fn() => view('placeholders.bom_upload'))->name('bom.upload');
    Route::get('/quotes/create', fn() => view('placeholders.quote_create'))->name('quotes.create');
    Route::get('/lists/create', fn() => view('placeholders.list_create'))->name('lists.create');
});

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// Dashboard with widgets (main landing page)
use App\Http\Controllers\DashboardController;
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
