<?php

use App\Http\Livewire\Cart;
use App\Http\Livewire\Edit;
use App\Http\Livewire\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return view('home');
})->middleware('auth');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get("/products", Product::class);
    Route::get("/cart", Cart::class);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Route::get('/edits/{id}/edit', Edit::class);
    // Route::put('/edits', Edit::class, 'update');
});

Route::resource('/edits', ProductController::class)->only([
    'destroy', 'edit', 'update'
]);
