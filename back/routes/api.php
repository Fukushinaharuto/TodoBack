<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/api', function() {
    return response()->json([
        "success" => true,
        "message" => "hello laravel",
        "hello" => "連携完了最高"
    ]);
});

Route::get('/todos', [TodoController::class, 'index']);