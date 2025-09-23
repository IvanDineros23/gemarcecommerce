<?php
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
});

// Dashboard search route (demo)
Route::get('/dashboard/search', function (\Illuminate\Http\Request $request) {
    $q = $request->input('q');
    // For demo, just return the query
    return view('dashboard.search', ['q' => $q]);
})->name('dashboard.search');
// Cart page route for users
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/cart', fn() => view('placeholders.cart'))->name('cart.index');
});

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

Route::get('/shop', function () {
    return view('shop.index');
})->name('shop.index');

require __DIR__.'/auth.php';
