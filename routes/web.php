<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\ResultController;
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

    Route::get('/member/dashboard', [MemberDashboardController::class, 'index'])
        ->middleware('role:member')
        ->name('member.dashboard');

    Route::post('/member/challenges/{challenge}/join', [MemberDashboardController::class, 'join'])
        ->middleware('role:member')
        ->name('member.challenges.join');

    Route::get('/member/challenges/{challenge}/result', [ResultController::class, 'create'])
        ->middleware('role:member')
        ->name('member.results.create');

    Route::post('/member/challenges/{challenge}/result', [ResultController::class, 'store'])
        ->middleware('role:member')
        ->name('member.results.store');

    Route::get('/member/progress', [MemberDashboardController::class, 'progress'])
        ->middleware('role:member')
        ->name('member.progress');

    Route::get('/coach/dashboard', function () {
        return view('dashboard');
    })->middleware('role:coach')->name('coach.dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});