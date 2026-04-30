<?php

use App\Services\GroqService;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LoanController;
use App\Http\Controllers\Api\AiController;
use App\Http\Middleware\EnsureUserRole;
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

// Book CRUD - public read, admin-only write
Route::get('books', [BookController::class, 'index']);
Route::get('books/{id}', [BookController::class, 'show']);
Route::get('books/recommend', [BookController::class, 'recommend']);
Route::middleware(['auth:web', EnsureUserRole::class . ':admin'])->group(function () {
    Route::post('books', [BookController::class, 'store']);
    Route::put('books/{id}', [BookController::class, 'update']);
    Route::delete('books/{id}', [BookController::class, 'destroy']);
});

// Category CRUD - public read, admin-only write
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{id}', [CategoryController::class, 'show']);
Route::middleware(['auth:web', EnsureUserRole::class . ':admin'])->group(function () {
    Route::post('categories', [CategoryController::class, 'store']);
    Route::put('categories/{id}', [CategoryController::class, 'update']);
    Route::delete('categories/{id}', [CategoryController::class, 'destroy']);
});

// Loans (peminjaman) - require session auth for loan actions
Route::middleware('auth:web')->group(function () {
    Route::get('loans', [LoanController::class, 'index']);
    Route::post('loans', [LoanController::class, 'store']);
    Route::get('loans/{id}', [LoanController::class, 'show']);
    Route::put('loans/{id}', [LoanController::class, 'update']);
    Route::delete('loans/{id}', [LoanController::class, 'destroy']);
});

// AI endpoints (require session auth + web middleware for session/CSRF)
Route::middleware(['web', 'auth:web'])->group(function () {
    Route::post('ai/recommend', [AiController::class, 'recommend']);
    Route::post('ai/summarize', [AiController::class, 'summarize']);
    Route::post('ai/chat', [AiController::class, 'chat']);
});
