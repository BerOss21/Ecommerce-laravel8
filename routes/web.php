<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// Route::get('/', function () {
//     return Inertia::render('Home', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::middleware(['auth:sanctum','verified','isAdmin'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::resource('dashboard/products','App\Http\Controllers\ProductController');
Route::resource('dashboard/categories','App\Http\Controllers\CategoryController');
Route::resource('dashboard/orders','App\Http\Controllers\OrderController');
Route::resource('dashboard/coupons','App\Http\Controllers\CouponController');
Route::resource('dashboard/orders','App\Http\Controllers\OrderController');
Route::get('/orders','App\Http\Controllers\OrderController@myOrders')->name("myOrders");
Route::get('/','App\Http\Controllers\HomeController@index')->name("home");
Route::get('/detail/{id}','App\Http\Controllers\HomeController@show')->name("show");
Route::get('/cart','App\Http\Controllers\HomeController@cart')->name("cart");
Route::get('/checkout','App\Http\Controllers\CheckoutController@index')->name("checkout");
Route::post('/checkout/create','App\Http\Controllers\CheckoutController@create')->name("checkout.create");
Route::get('/coupon/{code}','App\Http\Controllers\HomeController@getCoupon');