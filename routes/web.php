<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


// Authentication Routes
// Page de login
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);

// Mot de passe oublié
Route::get('password/reset', [AuthController::class, 'showForgetPasswordForm'])->name('password.request');
Route::post('password/email', [AuthController::class, 'sendResetLink'])->name('password.email');

// Réinitialisation du mot de passe
Route::get('password/reset/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('password/reset', [AuthController::class, 'resetPassword'])->name('password.update');

// Dashboard après connexion (accès selon rôle)
Route::get('dashboard', [DashboardController::class, 'index'])->middleware('auth');
