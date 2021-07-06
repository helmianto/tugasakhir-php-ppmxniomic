<?php

use App\Http\Controllers\BiodataController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('biodatas', [BiodataController::class, 'index']);
Route::post('biodatas', [BiodataController::class, 'store']);
Route::put('biodatas/{id}', [BiodataController::class, 'update']);
Route::delete('biodatas/{id}', [BiodataController::class, 'destroy']);
