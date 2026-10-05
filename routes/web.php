<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoachChallengeController;
use App\Http\Controllers\CoachResultController;
use App\Http\Controllers\LeaderboardController;
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

    Route::get('/member/challenges/{challenge}/leaderboard', [LeaderboardController::class, 'memberShow'])
        ->middleware('role:member')
        ->name('member.leaderboards.show');

    Route::middleware('role:coach')->group(function () {
        Route::get('/coach/dashboard', function () {
            return redirect()->route('coach.challenges.index');
        })->name('coach.dashboard');

        Route::get('/coach/challenges', [CoachChallengeController::class, 'index'])
            ->name('coach.challenges.index');

        Route::get('/coach/challenges/create', [CoachChallengeController::class, 'create'])
            ->name('coach.challenges.create');

        Route::post('/coach/challenges', [CoachChallengeController::class, 'store'])
            ->name('coach.challenges.store');

        Route::get('/coach/challenges/{challenge}/edit', [CoachChallengeController::class, 'edit'])
            ->name('coach.challenges.edit');

        Route::put('/coach/challenges/{challenge}', [CoachChallengeController::class, 'update'])
            ->name('coach.challenges.update');

        Route::delete('/coach/challenges/{challenge}', [CoachChallengeController::class, 'destroy'])
            ->name('coach.challenges.destroy');

        Route::get('/coach/results', [CoachResultController::class, 'index'])
            ->name('coach.results.index');

        Route::patch('/coach/results/{result}/status', [CoachResultController::class, 'updateStatus'])
            ->name('coach.results.status');

        Route::get('/coach/challenges/{challenge}/leaderboard', [LeaderboardController::class, 'coachShow'])
            ->name('coach.leaderboards.show');

        Route::patch('/coach/challenges/{challenge}/leaderboard/publish', [LeaderboardController::class, 'publish'])
            ->name('coach.leaderboards.publish');

        Route::patch('/coach/challenges/{challenge}/leaderboard/unpublish', [LeaderboardController::class, 'unpublish'])
            ->name('coach.leaderboards.unpublish');
    });

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});