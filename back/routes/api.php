<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


Route::middleware("auth:sanctum")->group(function () {
    Route::apiResource('todos', TodoController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::patch('/todos/{id}/toggleStatus', [TodoController::class, 'toggleStatus']);
    Route::get('/userName', [AuthenticatedSessionController::class, 'index']);
    Route::patch('/profile', [AuthenticatedSessionController::class, 'update']);
    Route::post('/passwordAuth', [AuthenticatedSessionController::class, 'passwordAuth']);
    
});

Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);




