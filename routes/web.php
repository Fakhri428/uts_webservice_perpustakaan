<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Middleware\EnsureUserRole;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        // Redirect to role-specific dashboard
        $user = auth()->user();
        if ($user && $user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.dashboard');
    })->name('dashboard');

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->middleware(EnsureUserRole::class . ':admin')
        ->name('admin.dashboard');

    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])
        ->middleware(EnsureUserRole::class . ':user')
        ->name('user.dashboard');
    
    // Simple web UI pages for the app
    Route::get('/app/books', function () { return view('books'); })->name('app.books');
    Route::get('/app/loans', function () { return view('loans'); })->name('app.loans');
    Route::get('/app/ai', function () { return view('ai'); })->name('app.ai');
});
