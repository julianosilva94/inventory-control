<?php

use App\Http\Controllers\API\StockMovementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('adicionar-produtos', [StockMovementController::class, 'add'])->name('api.stock-movement.add');
Route::post('baixar-produtos', [StockMovementController::class, 'remove'])->name('api.stock-movement.remove');
