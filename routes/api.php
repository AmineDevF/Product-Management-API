<?php

use App\Http\Controllers\Api\AuthController as ApiAuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RouleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('admin')->middleware(['auth:sanctum'])->group(function () {
 
    Route::get('/panel', [RouleController::class, 'dashboard']);
    Route::put('/upadteProfeil/{id}', [RouleController::class, 'update']);
    Route::post('/createProfeil', [RouleController::class, 'createProfeil']);

// Route::get('/panel', [RouleController::class, 'dashboard']);
});

Route::middleware(['auth:sanctum','isAdmin'])->group(function(){

Route::get('/user', [ApiAuthController::class, 'getUser']);
Route::get('/dashboard/customers-count', [DashboardController::class, 'activeCustomers']);
Route::get('/dashboard/products-count', [DashboardController::class, 'activeProducts']);
Route::get('/dashboard/orders-count', [DashboardController::class, 'paidOrders']);
Route::get('/dashboard/income-amount', [DashboardController::class, 'totalIncome']);
Route::get('/dashboard/orders-by-country', [DashboardController::class, 'ordersByCountry']);
Route::get('/dashboard/latest-customers', [DashboardController::class, 'latestCustomers']);
Route::get('/dashboard/latest-orders', [DashboardController::class, 'latestOrders']);
Route::get('/orders', [DashboardController::class, 'ordrin']);    
Route::get('orders/{order}', [DashboardController::class, 'view']);    
Route::apiResource('products', ProductController::class);
Route::apiResource('categories', CategoryController::class)->except('show');
Route::get('/countries', [CategoryController::class, 'countries']);
Route::get('/categories/tree', [CategoryController::class, 'getAsTree']);
Route::apiResource('users', UserController::class);
Route::apiResource('customers', CustomerController::class);
Route::post('/logout', [ApiAuthController::class, 'logout']);
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);

// email verificationn otification


// Route::post('/email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');
// Route::get('/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');

// product crud 
Route::middleware(['auth:sanctum'])->group(function () {
Route::post('/image',[ProductController::class, 'imageStore']);
Route::delete('/force_delete_product/{id}',[ProductController::class, 'forceDelete']);
Route::get('/trached_product',[ProductController::class, 'onlyTrachedProduct']);
});

// cart  && order

Route::apiResource('carts', CartController::class)->except(['update', 'index']);
// Route::apiResource('orders', OrderController::class)->except(['update', 'destroy','store'])->middleware('auth:api');
Route::post('/cartspro/', [ CartController::class ,'addProducts']);
Route::post('/carts/{cartKey}/checkout', [CartController::class, 'checkout']);

// Route::post('/registerform', [AuthController::class, 'register'])->name('register.form');
