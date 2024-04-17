<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [\App\Http\Controllers\UserController::class,'logout']);
    Route::post('/create', [\App\Http\Controllers\AdvController::class,'store']);
    Route::post('/get-ads', [\App\Http\Controllers\AdvController::class,'getAds']);
    Route::post('/deleteAd', [\App\Http\Controllers\AdvController::class,'delete']);
    Route::post('/update/{id}', [\App\Http\Controllers\AdvController::class,'update']);
    Route::get('/users', [\App\Http\Controllers\AdvController::class,'getUsers']);
    Route::get('/messages', [\App\Http\Controllers\Message::class,'index']);
    Route::post('/createMessage', [\App\Http\Controllers\Message::class,'store']);
});

Route::post('/ads', [\App\Http\Controllers\AdvController::class,'index']);

Route::get('/ad/{id}', [\App\Http\Controllers\AdvController::class,'getAd']);
Route::get('/popular-ads', [\App\Http\Controllers\AdvController::class,'popular']);
Route::get('/new-ads', [\App\Http\Controllers\AdvController::class,'newAds']);

Route::get('/image/{url}', [\App\Http\Controllers\ImageController::class,'getImagePath']);

Route::post('/register', [\App\Http\Controllers\UserController::class,'store']);
Route::post('/login', [\App\Http\Controllers\UserController::class,'login']);
Route::get('/section', [\App\Http\Controllers\SectionController::class,'index']);
Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index']);
Route::get('/cities', [\App\Http\Controllers\CityController::class, 'index']);
