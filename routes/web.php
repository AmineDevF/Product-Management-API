<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
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

Route::post('/registerform', [AuthController::class, 'register'])->name('register.form');
Route::post('/loginform', [AuthController::class, 'login'])->name('login.form');
Route::get('/register', [AuthController::class, 'registerurl'])->name('register');
Route::get('/login', [AuthController::class, 'loginurl'])->name('login');

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