<?php

use App\Http\Controllers\Api\UrlShortenerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('index', [UrlShortenerController::class, 'index']);
Route::post('store', [UrlShortenerController::class, 'store']);
Route::delete('delete/{url}', [UrlShortenerController::class, 'delete']);
