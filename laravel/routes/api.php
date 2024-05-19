<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class)->middleware('auth:sanctum');

Route::post('/login', [AdminController::class, 'login']);
Route::post('/logout', [AdminController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/is-token-valid', [AdminController::class, 'token_check'])->middleware('auth:sanctum');
