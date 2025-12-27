<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\UserController; // FIXED: Added

/**
 * PUBLIC ROUTES
 */
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/**
 * PROTECTED ROUTES (Require Sanctum Token)
 */
Route::middleware('auth:sanctum')->group(function () {

    // User Profile
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/user/profile', [UserController::class, 'profile']);
     Route::put('/user/profile', [UserController::class, 'updateProfile']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    /**
     * Categories
     */
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{id}/products', [CategoryController::class, 'products']);

    /**
     * Products
     */
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);

    /**
     * Cart
     */
    Route::get('/cart', [CartController::class, 'cartList']);
    Route::post('/cart/add', [CartController::class, 'addToCart']);
    Route::post('/cart/update', [CartController::class, 'updateCart']);
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeCartItem']);

    /**
     * Orders
     */
    Route::post('/orders/place', [OrderController::class, 'placeOrder']);
    Route::get('/orders', [OrderController::class, 'orderHistory']);
    Route::get('/orders/{id}', [OrderController::class, 'orderDetails']);

    /**
     * Reviews
     */
    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::put('/reviews/{id}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);
    Route::get('/user/reviews', [ReviewController::class, 'userReviews']);

    /**
     * Address
     */
    Route::post('/address', [AddressController::class, 'addAddress']);
    Route::get('/my-addresses', [AddressController::class, 'myAddresses']);
    Route::put('/address/{id}', [AddressController::class, 'updateAddress']);
    Route::delete('/address/{id}', [AddressController::class, 'deleteAddress']);
    Route::patch('/address/{id}/default', [AddressController::class, 'setDefaultAddress']);
            
});

// Route::prefix('admin')->middleware(['auth:sanctum','admin'])->group(function(){
//     // Products
//     Route::get('/products', [\App\Http\Controllers\Api\Admin\ProductController::class,'index']);
//     Route::post('/products', [\App\Http\Controllers\Api\Admin\ProductController::class,'store']);
//     Route::get('/products/{id}', [\App\Http\Controllers\Api\Admin\ProductController::class,'show']);
//     Route::put('/products/{id}', [\App\Http\Controllers\Api\Admin\ProductController::class,'update']);
//     Route::delete('/products/{id}', [\App\Http\Controllers\Api\Admin\ProductController::class,'destroy']);

//     // Categories
//     Route::get('/categories', [\App\Http\Controllers\Api\Admin\CategoryController::class,'index']);
//     Route::post('/categories', [\App\Http\Controllers\Api\Admin\CategoryController::class,'store']);
//     Route::put('/categories/{id}', [\App\Http\Controllers\Api\Admin\CategoryController::class,'update']);
//     Route::delete('/categories/{id}', [\App\Http\Controllers\Api\Admin\CategoryController::class,'destroy']);

//     // Orders
//     Route::get('/orders', [\App\Http\Controllers\Api\Admin\OrderController::class,'index']);
//     Route::put('/orders/{id}/status', [\App\Http\Controllers\Api\Admin\OrderController::class,'updateStatus']);

//      Route::get('/dashboard', [DashboardController::class, 'stats']);
// });
