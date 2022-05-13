<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::group([
    'middleware' => 'jwt.auth'
], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
});

// Users
Route::group([
    //'middleware' => 'jwt.auth'
], function(){
    Route::get('/users', [UserController::class, 'getAllusers']);
    Route::get('/users/{id}', [UserController::class, 'getusersById']);
    Route::post('/users', [UserController::class, 'createNewUser']);
    Route::put('/users/{id}', [UserController::class, 'updateUserById']);
    Route::delete('/users/{id}', [UserController::class, 'deleteUserById']);
});