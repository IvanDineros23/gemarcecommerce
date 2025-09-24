<?php
use App\Http\Controllers\SavedListController;
// Saved Items (Wishlist)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/saved', [SavedListController::class, 'index'])->name('saved.index');
    Route::post('/saved', [SavedListController::class, 'store'])->name('saved.store');
    Route::delete('/saved/{id}', [SavedListController::class, 'destroy'])->name('saved.destroy');
});



// Employee Management (Inventory, Products, Quotes)
use App\Http\Controllers\EmployeeInventoryController;
use App\Http\Controllers\EmployeeProductController;
Route::middleware(['auth', 'verified'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/inventory', [EmployeeInventoryController::class, 'index'])->name('inventory.index');
    Route::patch('/inventory/{product}', [EmployeeInventoryController::class, 'update'])->name('inventory.update');
    Route::get('/products', [EmployeeProductController::class, 'index'])->name('products.index');
    Route::post('/products', [EmployeeProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [EmployeeProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [EmployeeProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [EmployeeProductController::class, 'destroy'])->name('products.destroy');
    // Employee Quote Management (controller-based)
});

// Employee chat/messages management page
Route::middleware(['auth', 'verified'])->get('/employee/chats', function () {
    return view('dashboard.employee_chat');
})->name('employee.chat.page');

// User chat/messages page
Route::middleware(['auth', 'verified'])->get('/chats', function () {
    return view('dashboard.chat');
})->name('chat.page');

// Employee chat user list route
Route::middleware(['auth', 'verified'])->get('/chat/users', [App\Http\Controllers\ChatController::class, 'userList']);

// Chat routes for user dashboard
use App\Http\Controllers\ChatController;
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/chat/fetch', [ChatController::class, 'fetch']);
    Route::post('/chat/send', [ChatController::class, 'send']);
    Route::post('/chat/clear', [ChatController::class, 'clear']);
});

// Dashboard search route (demo)
Route::get('/dashboard/search', function (\Illuminate\Http\Request $request) {
    $q = $request->input('q');
    // For demo, just return the query
    return view('dashboard.search', ['q' => $q]);
})->name('dashboard.search');
// Cart page route for users
use App\Http\Controllers\CartController;
use App\Http\Controllers\SettingsController;

use App\Http\Controllers\QuoteController;
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/orders/{order}', [CartController::class, 'orderReceipt'])->name('orders.receipt');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/cart/checkout', [CartController::class, 'processCheckout'])->name('cart.checkout.process');
    Route::post('/cart/place-order', [CartController::class, 'processCheckout'])->name('cart.place-order');
    Route::view('/settings', 'dashboard.settings')->name('settings');
    Route::post('/settings/delivery-address', [SettingsController::class, 'saveDeliveryAddress'])->name('settings.saveDeliveryAddress');
    Route::post('/settings/payment-details', [SettingsController::class, 'savePaymentDetails'])->name('settings.savePaymentDetails');

    // Quote creation and PDF
    Route::get('/quotes/create', [QuoteController::class, 'create'])->name('quotes.create');
    Route::post('/quotes', [QuoteController::class, 'store'])->name('quotes.store');
    Route::get('/quotes/pdf/{quote}', [QuoteController::class, 'pdf'])->name('quotes.pdf');
});

// Employee fetch quotes
Route::middleware(['auth', 'verified'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/quotes', [QuoteController::class, 'employeeIndex'])->name('quotes.index');
    Route::get('/quotes/{quote}', [QuoteController::class, 'employeeShow'])->name('quotes.show');
});

// Placeholder routes for dashboard links (quotes routes removed to avoid conflict)
use App\Http\Controllers\OrderController;
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/shipments', fn() => view('placeholders.shipments'))->name('shipments.index');
    Route::get('/invoices', fn() => view('placeholders.invoices'))->name('invoices.index');
    Route::get('/quick-order', fn() => view('placeholders.quick_order'))->name('quick-order.show');
    Route::get('/bom-upload', fn() => view('placeholders.bom_upload'))->name('bom.upload');
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

// Admin dashboard routes
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

Route::middleware(['auth', 'verified', 'can:access-admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::view('/settings', 'admin.placeholders.settings')->name('settings');
    Route::view('/users', 'admin.placeholders.users')->name('users');
    Route::view('/orders', 'admin.placeholders.orders')->name('orders');
    Route::view('/products', 'admin.placeholders.products')->name('products');
    Route::view('/analytics', 'admin.placeholders.analytics')->name('analytics');
    Route::view('/quotes', 'admin.placeholders.quotes')->name('quotes');
    Route::view('/uploads', 'admin.placeholders.uploads')->name('uploads');
    Route::view('/approvals', 'admin.placeholders.approvals')->name('approvals');
    Route::view('/export', 'admin.placeholders.export')->name('export');
    Route::view('/stock', 'admin.placeholders.stock')->name('stock');
    Route::view('/pricing', 'admin.placeholders.pricing')->name('pricing');
    Route::view('/documents', 'admin.placeholders.documents')->name('documents');
    Route::view('/brands', 'admin.placeholders.brands')->name('brands');
    Route::view('/roles', 'admin.placeholders.roles')->name('roles');
    Route::view('/business', 'admin.placeholders.business')->name('business');
    Route::view('/audit', 'admin.placeholders.audit')->name('audit');
    Route::view('/freight', 'admin.placeholders.freight')->name('freight');
    Route::view('/site-settings', 'admin.placeholders.site_settings')->name('site_settings');
    Route::view('/user-management', 'admin.placeholders.user_management')->name('user_management');
});

use App\Models\Product;
Route::get('/shop', function (\Illuminate\Http\Request $request) {
    $q = $request->input('q');
    $products = Product::where('is_active', 1)
        ->when($q, function ($query, $q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%$q%")
                    ->orWhere('description', 'like', "%$q%")
                    ->orWhere('price', 'like', "%$q%")
                    ;
            });
        })
        ->orderByDesc('created_at')
        ->get();
    return view('shop.index', compact('products', 'q'));
})->name('shop.index');

// Example route to show real-time date and time using Carbon
use Carbon\Carbon;
Route::get('/realtime-date', function () {
    $now = Carbon::now();
    return 'Current Date and Time: ' . $now->format('F d, Y h:i A');
});

require __DIR__.'/auth.php';
