<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('/', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
    });

    Route::group(['prefix' => 'role', 'middleware' => 'is-admin'], function () {
        Route::get('/', 'RoleController@index');
    });
    Route::group(['prefix' => 'user', 'middleware' => 'is-admin'], function () {
        Route::get('/dashboard/total-user', 'UserController@totalUsers');
        Route::get('/', 'UserController@index');
        Route::post('/', 'UserController@create');
        Route::get('{id}', 'UserController@show');
        Route::put('{id}', 'UserController@update');
        Route::delete('{id}', 'UserController@destroy');
    });
});
