<?php

use App\Http\Controllers\UrlResolverController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/url/{hash}', [UrlResolverController::class, 'show']);
