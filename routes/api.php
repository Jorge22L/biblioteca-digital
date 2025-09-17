<?php

use App\Http\Controllers\LibroController;
use Illuminate\Support\Facades\Route;

Route::apiResource('libros', LibroController::class);