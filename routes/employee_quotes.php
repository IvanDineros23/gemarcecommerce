<?php
use Illuminate\Support\Facades\Route;

// Employee Quote Management Placeholder
Route::middleware(['auth', 'verified'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/quotes', function () {
        return view('placeholders.employee_quotes');
    })->name('quotes.index');
});
