<?php

use App\Http\Controllers\LibroController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [UsuarioController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function() {
    Route::apiResource('libros', LibroController::class);
    Route::apiResource('usuarios', UsuarioController::class);
    Route::apiResource('prestamos', PrestamoController::class);
    Route::post('/logout', [UsuarioController::class, 'logout'])->name('logout');
    Route::get('/me', [UsuarioController::class, 'me'])->name('me');
});