<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Middleware\EnsureUserRole;
use Illuminate\Support\Facades\Auth;

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

    Route::get('/admin/books', function () { return view('admin.books'); })
        ->middleware(EnsureUserRole::class . ':admin')
        ->name('admin.books');

    Route::get('/admin/loans', function () { return view('admin.loans'); })
        ->middleware(EnsureUserRole::class . ':admin')
        ->name('admin.loans');

    Route::get('/admin/ai', function () { return view('admin.ai'); })
        ->middleware(EnsureUserRole::class . ':admin')
        ->name('admin.ai');

    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])
        ->middleware(EnsureUserRole::class . ':user')
        ->name('user.dashboard');

    Route::get('/user/books', function () { return view('user.books'); })
        ->middleware(EnsureUserRole::class . ':user')
        ->name('user.books');

    Route::get('/user/loans', function () { return view('user.loans'); })
        ->middleware(EnsureUserRole::class . ':user')
        ->name('user.loans');

    Route::get('/user/ai', function () { return view('user.ai'); })
        ->middleware(EnsureUserRole::class . ':user')
        ->name('user.ai');

    // Backward-compatible aliases
    Route::get('/app/books', function () {
        return redirect()->route(auth()->user()?->role === 'admin' ? 'admin.books' : 'user.books');
    })->name('app.books');

    Route::get('/app/loans', function () {
        return redirect()->route(auth()->user()?->role === 'admin' ? 'admin.loans' : 'user.loans');
    })->name('app.loans');

    Route::get('/app/ai', function () {
        return redirect()->route(auth()->user()?->role === 'admin' ? 'admin.ai' : 'user.ai');
    })->name('app.ai');
});
