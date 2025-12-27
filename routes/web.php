<?php
// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\WebDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\AddressController;
use App\Http\Controllers\Admin\ReviewController;

// Home Route
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ✅ Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ✅ Admin Routes (Protected)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    
    // ==================== DASHBOARD ====================
    Route::get('/dashboard', [WebDashboardController::class, 'index'])->name('dashboard');
    
    // ==================== USERS MANAGEMENT ====================
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/toggle-admin', [UserController::class, 'toggleAdmin'])->name('toggleAdmin');
    });
    
    // ==================== CATEGORIES MANAGEMENT ====================
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    });
    
    // ==================== PRODUCTS MANAGEMENT ====================
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
    });
    
    // ==================== ORDERS MANAGEMENT ====================
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{id}', [OrderController::class, 'show'])->name('show');
        Route::put('/{id}/status', [OrderController::class, 'updateStatus'])->name('updateStatus');
        Route::put('/{id}/payment-status', [OrderController::class, 'updatePaymentStatus'])->name('updatePaymentStatus');
        Route::put('/{id}/shipping-info', [OrderController::class, 'updateShippingInfo'])->name('updateShippingInfo');
        Route::delete('/{id}', [OrderController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-update', [OrderController::class, 'bulkUpdate'])->name('bulkUpdate');
    });
    
    // ==================== CARTS MANAGEMENT ====================
    Route::prefix('carts')->name('carts.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::get('/{id}', [CartController::class, 'show'])->name('show');
        Route::delete('/{id}', [CartController::class, 'destroy'])->name('destroy');
    });
    
    // ==================== ADDRESSES MANAGEMENT ====================
    Route::prefix('addresses')->name('addresses.')->group(function () {
        Route::get('/', [AddressController::class, 'index'])->name('index');
        Route::get('/{id}', [AddressController::class, 'show'])->name('show');
        Route::delete('/{id}', [AddressController::class, 'destroy'])->name('destroy');
    });
    
    // ==================== REVIEWS MANAGEMENT ====================
    // Check if product_reviews table exists
    if (\Illuminate\Support\Facades\Schema::hasTable('product_reviews')) {
        Route::prefix('reviews')->name('reviews.')->group(function () {
            Route::get('/', [ReviewController::class, 'index'])->name('index');
            Route::get('/{id}', [ReviewController::class, 'show'])->name('show');
            Route::delete('/{id}', [ReviewController::class, 'destroy'])->name('destroy');
        });
    }
});