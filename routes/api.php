<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
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

// Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::group([
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
});

// Users
Route::group([
    'middleware' => 'jwt.auth'
], function(){
    Route::get('/users', [UserController::class, 'getAllusers']);
    Route::get('/users/{id}', [UserController::class, 'getusersById']);
    Route::post('/users', [UserController::class, 'createNewUser']);
    Route::put('/users/{id}', [UserController::class, 'updateUserById']);
    Route::delete('/users/{id}', [UserController::class, 'deleteUserById']);
});

// Games
Route::group([
    'middleware' => 'jwt.auth'
], function(){
    Route::post('/game', [GameController::class, 'newGame']);
    Route::get('/game', [GameController::class, 'getGames']);
    Route::get('/game/{id}', [GameController::class, 'gameById']); //user id
    Route::get('/game/title/{title}', [GameController::class, 'gameByTitle']); //title 
    Route::put('/game/{id}', [GameController::class, 'updateGame']);
    Route::delete('/game/{id}', [GameController::class, 'deleteGame']);
});

// Parties
Route::group([
    'middleware' => 'jwt.auth'
], function(){
Route::post('/party', [PartyController::class, 'createParty']);
Route::get('/party/{id}', [PartyController::class, 'getPartyById']);
Route::get('/parties', [PartyController::class, 'getAllParties']);
Route::patch('/party/{id}', [PartyController::class, 'updateParty']);
Route::delete('/party/{id}', [PartyController::class, 'deleteParty']);
});