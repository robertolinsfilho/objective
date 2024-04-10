<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiContasController;
use App\Http\Controllers\ApiTransacoesController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('conta', [ApiContasController::class,'store']);
Route::get('conta/{id}', [ApiContasController::class,'show']);
Route::post('transacao', [ApiTransacoesController::class,'store']);
