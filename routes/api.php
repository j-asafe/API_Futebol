<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIFutController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/jogadores', [APIFutController::class, 'index']);
Route::get('/jogadores/{id}', [APIFutController::class, 'show']);
Route::post('/criarJogadores', [APIFutController::class, 'store']);
Route::put('/upJogadores/{id}', [APIFutController::class, 'update']);
Route::delete('/delJogadores/{id}', [APIFutController::class, 'destroy']);  