<?php

use App\Services\GroqService;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\LoanController;
use App\Http\Controllers\Api\AiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/groq/test', function () {
    $groq = new GroqService();

    $result = $groq->complete('Halo, jawab singkat saja: APA KABAR?');

    return response()->json($result);
});

// Book CRUD
Route::get('books/recommend', [BookController::class, 'recommend']);
Route::apiResource('books', BookController::class);

// Loans (peminjaman)
Route::apiResource('loans', LoanController::class);

// AI endpoints
Route::post('ai/recommend', [AiController::class, 'recommend']);
Route::post('ai/summarize', [AiController::class, 'summarize']);
Route::post('ai/chat', [AiController::class, 'chat']);
