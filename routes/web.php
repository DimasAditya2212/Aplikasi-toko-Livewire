<?php

use App\Http\Livewire\Cart;
use App\Http\Livewire\Edit;
use App\Http\Livewire\Product;
use App\Http\Livewire\ProductIndex;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardProductController;

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



Route::group(['middleware' => ['auth']], function () {
    Route::get("/productstambah", ProductIndex::class);
    Route::resource('/products', DashboardProductController::class);
    Route::get("/cart", Cart::class);
    // Route::view('edit', 'livewire.edit');
    // Route::get("/edit", Edit::class);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


    // Route::get('/edits/{id}/edit', Edit::class);
    // Route::put('/edits', Edit::class, 'update');
});

// Route::resource('/edits', ProductController::class)->only([
//     'destroy', 'edit', 'update'
// ]);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
