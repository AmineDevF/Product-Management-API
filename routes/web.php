<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarteController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[AppController::class,'index'])->name('app.index');
Route::get('/test',[AppController::class,'test'])->name('app.test');
Route::post('/checkout',[ShopController::class,'checkout'])->name('shop.checkout');
Route::get('/checkout/success', [ShopController::class, 'success'])->name('checkout.success');
Route::get('/checkout/cancel', [ShopController::class, 'cancel'])->name('checkout.cancel');
Route::post('/registerform', [AuthController::class, 'register'])->name('register.form');
Route::post('/loginform', [AuthController::class, 'login'])->name('login.form');
Route::get('/register', [AuthController::class, 'registerurl'])->name('register');
Route::get('/login', [AuthController::class, 'loginurl'])->name('login');
Route::get('/shop',[ShopController::class,'index'])->name('shop.index');
Route::get('/serch',[ShopController::class,'search'])->name('product.search');
Route::get('/product/{slug}',[ShopController::class,'productDetials'])->name('shop.product.details');
Route::get('/cart-wishlist-count',[ShopController::class,'getCartAndWishlistCount'])->name('shop.cart.wishlist.count');
Route::get('/cart-total',[ShopController::class,'getCartTotal'])->name('shop.cart.total');
Route::get('/cart',[CarteController::class,'index'])->name('cart.index');
Route::get('/precess/checkout',[CarteController::class,'check'])->name('cart.precess');
Route::post('/cart/store', [CarteController::class, 'addToCart'])->name('cart.store');
Route::put('/cart/update', [CarteController::class, 'updateCart'])->name('cart.update');
Route::post('/apply-coupon', [CarteController::class, 'applyCoupon'])->name('apply.coupon');

Route::delete('/cart/remove', [CarteController::class, 'removeItem'])->name('cart.remove');
Route::delete('/cart/clear', [CarteController::class, 'clearCart'])->name('cart.clear');
Route::post('/wishlist/add',[WishlistController::class,'addProductToWishlist'])->name('wishlist.store');
Route::get('/wishlist',[WishlistController::class,'getWishlistedProducts'])->name('wishlist.list');
Route::delete('/wishlist/remove',[WishlistController::class,'removeProductFromWishlist'])->name('wishlist.remove');
Route::delete('/wishlist/clear',[WishlistController::class,'clearWishlist'])->name('wishlist.clear');
Route::post('/wishlist/move-to-cart',[WishlistController::class,'moveToCart'])->name('wishlist.move.to.cart');
// Route::view('/login',"auth.login")->name('login');
// Route::view('/register',"welcome")->name('register');

Route::middleware('auth')->group(function(){
    Route::get('/my-account',[AuthController::class,'index'])->name('user.index');
});

Route::middleware(['auth','auth.admin'])->group(function(){
    Route::get('/admin',[AuthController::class,'admin'])->name('admin.index');
});
// Route::view('/amine',"home");

Route::resource('products', ProductController::class);