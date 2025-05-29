<?php

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

Route::middleware('auth:sanctum')->get('tasks', [App\Http\Controllers\TasksController::class, 'index']);
Route::middleware('auth:sanctum')->post('store', [App\Http\Controllers\TasksController::class, 'store']);
Route::middleware('auth:sanctum')->get('tasks/{id}', [App\Http\Controllers\TasksController::class, 'show']);
Route::middleware('auth:sanctum')->put('tasks/{id}', [App\Http\Controllers\TasksController::class, 'update']);
Route::middleware('auth:sanctum')->delete('tasks/{id}', [App\Http\Controllers\TasksController::class, 'destroy']);
Route::middleware('auth:sanctum')->put('tasks/completed/{id}', [App\Http\Controllers\TasksController::class, 'completeTask']);


/* Rotas de Testes */
Route::middleware('auth:sanctum')->post('QRCode', [App\Http\Controllers\QrCodeController::class, 'generateQrCode']);
Route::middleware('auth:sanctum')->post('QRCodeImg', [App\Http\Controllers\QrCodeController::class, 'generateQrCodeImage']);

/* Rota para fazer testar requisição http */
Route::middleware('auth:sanctum')->get('ip', [App\Http\Controllers\IpController::class, 'getIp']);

/* Login */
Route::post('register', [App\Http\Controllers\LoginController::class, 'register']);
Route::post('login', [App\Http\Controllers\LoginController::class, 'login']);

Route::middleware('auth:sanctum')->get('users', [App\Http\Controllers\LoginController::class, 'getUsers']);