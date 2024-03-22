<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [\App\Http\Controllers\UserController::class,'logout']);
    Route::post('/create', [\App\Http\Controllers\AdvController::class,'store']);
});


Route::post('/register', [\App\Http\Controllers\UserController::class,'store']);
Route::post('/login', [\App\Http\Controllers\UserController::class,'login']);
Route::get('/section', [\App\Http\Controllers\SectionController::class,'index']);
Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index']);
Route::get('/cities', [\App\Http\Controllers\CityController::class, 'index']);
