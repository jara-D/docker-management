<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContainerController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/container',[ContainerController::class,'index'] );

Route::post('/containers/sync',[ContainerController::class,'sync'] );
Route::post('/containers/{id}/start',[ContainerController::class,'start'] );
Route::post('/containers/{id}/stop',[ContainerController::class,'stop'] );
