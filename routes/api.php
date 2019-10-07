<?php

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

Route::post('/user', 'UserController@store')->name('register');
Route::post('/session', 'SessionController@store')->name('login');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/user/me', 'UserController@me');

    Route::get('/task', 'TaskController@index')->name('task-index');
    Route::post('/task', 'TaskController@store')->name('task-store');

    Route::post('/completion', 'CompletionController@store')->name('completion-store');
});
