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

Route::get('tasks', [App\Http\Controllers\TasksController::class, 'index']);
Route::post('store', [App\Http\Controllers\TasksController::class, 'store']);
Route::get('tasks/{id}', [App\Http\Controllers\TasksController::class, 'show']);
Route::put('tasks/{id}', [App\Http\Controllers\TasksController::class, 'update']);
Route::delete('tasks/{id}', [App\Http\Controllers\TasksController::class, 'destroy']);
Route::put('tasks/completed/{id}', [App\Http\Controllers\TasksController::class, 'completeTask']);
