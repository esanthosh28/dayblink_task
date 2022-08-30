<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/register',[UserController::class, 'index']);
Route::get('/',[UserController::class, 'login']);
Route::post('/register/form',[UserController::class, 'register']);
Route::post('/login/verify',[UserController::class, 'loginVerify']);
Route::post('/login/customLogin',[UserController::class, 'customLogin']);

 Route::resource('products', ProjectController::class);

Route::group(['middleware' => ['auth.basic']], function() {

   
    Route::get('/product_list', [ProjectController::class, 'product_list']);
    Route::get('/product/{id}', [ProjectController::class, 'product']);
    Route::get('/product/{id}/edit', [ProjectController::class, 'edit']);
    Route::post('/addToCart', [CartController::class,'addToCart']);
    Route::post('/placeOrder', [CartController::class,'placeOrder']);
    Route::get('/cart', [ProjectController::class,'cart']);
});

