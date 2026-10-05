<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->isCoach()) {
            return redirect('/coach/dashboard');
        }

        return redirect('/member/dashboard');
    })->name('dashboard');

    Route::get('/member/dashboard', function () {
        return view('dashboard');
    })->middleware('role:member')->name('member.dashboard');

    Route::get('/coach/dashboard', function () {
        return view('dashboard');
    })->middleware('role:coach')->name('coach.dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});