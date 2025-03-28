<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamInviteController;

Route::get('/', function () {
    return view('pages.home');
});

// Маршруты для профиля
Route::middleware(['auth'])->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/undo', [ProfileController::class, 'undo'])->name('profile.undo');
        Route::post('/cleanup', [ProfileController::class, 'cleanup'])->name('profile.cleanup');
    });

    // Маршруты для управления командой
    Route::post('/team', [TeamController::class, 'create'])->name('team.create');
    Route::delete('/team/{team}', [TeamController::class, 'destroy'])->name('team.destroy');
    Route::post('/team/invite', [TeamController::class, 'createInvite'])->name('team.invite');

    // Маршруты для приглашений
    Route::get('/team/invite/{uid}', [TeamInviteController::class, 'show'])->name('team.invite.show');
    Route::post('/team/invite/{uid}/accept', [TeamInviteController::class, 'accept'])->name('team.invite.accept');
    Route::get('/team/invite/{uid}/reject', [TeamInviteController::class, 'reject'])->name('team.invite.reject');
});

// Маршруты аутентификации
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
