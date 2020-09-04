<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/',  [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/produtos',  [ProductController::class, 'index'])->name('products.index');
    Route::get('/produtos/listar',  [ProductController::class, 'getAll'])->name('products.getAll');
    Route::post('/produtos',  [ProductController::class, 'store'])->name('products.store');
    Route::put('/produtos/{product}',  [ProductController::class, 'update'])->name('products.update');
});

Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::get('/sair', [LoginController::class, 'logout'])->name('login.logout');
