<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/statistics', 'App\Http\Controllers\StatisticController@index');

Route::post('/signin', 'App\Http\Controllers\AuthController@login');
Route::post('/signup', 'App\Http\Controllers\AuthController@register');
Route::post('/signout', 'App\Http\Controllers\AuthController@logout')->middleware('auth:sanctum');