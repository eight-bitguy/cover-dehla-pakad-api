<?php

use Illuminate\Support\Facades\Broadcast;
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

Route::get('/health', 'HealthController@health');

Route::post('/user', 'UserController@create');
Route::post('/login', 'LoginController@login');

Broadcast::routes(['middleware' => 'jwt.verify']);
Route::get('/user/me', 'UserController@me')->middleware(['jwt.verify']);
Route::post('/room', 'RoomController@create')->middleware(['jwt.verify']);
Route::post('/room/{roomCode}/join', 'RoomController@join')->middleware(['jwt.verify']);
Route::get('/room/{roomCode}/users', 'RoomController@getJoinedUsers')->middleware(['jwt.verify']);
Route::post('/room/{roomCode}/start', 'RoomController@start')->middleware(['jwt.verify']);
Route::get('/room/{roomCode}/user/initial-cards', 'GameController@initialCards')->middleware(['jwt.verify']);
Route::post('/room/{roomCode}/play', 'GameController@play')->middleware(['jwt.verify']);
Route::get('/room/{roomCode}/scores', 'GameController@getScores')->middleware(['jwt.verify']);
