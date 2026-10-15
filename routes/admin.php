<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| GuhangaAkazi Admin Routes
|--------------------------------------------------------------------------
| All routes here are prefixed with /admin and named with "admin."
|--------------------------------------------------------------------------
*/

// ----- Guest routes (login) -----
Route::middleware('guest:admin')->group(function () {
    Route::get('login',  [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.submit');
});

// ----- Authenticated admin routes -----
Route::middleware('admin')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    })->name('home');

    Route::get('dashboard', function () {
        return 'Dashboard coming in Step 32. Logged in as: '
            . auth('admin')->user()->email;
    })->name('dashboard');
});
