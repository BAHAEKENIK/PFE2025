<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Provider\DashboardController as ProviderDashboardController;
use Illuminate\Support\Facades\Route;


// Routes d'authentification
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name("login.post");
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// routes/web.php


// Applique le middleware 'guest' à ces deux routes
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

// Routes de réinitialisation de mot de passe (Flux personnalisé)
Route::get('forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request'); // Étape 1: Formulaire email
Route::post('forgot-password', [PasswordResetController::class, 'sendResetCodeEmail'])->name('password.email'); // Étape 2: Envoi du code
Route::get('reset-password/code', [PasswordResetController::class, 'showCodeForm'])->name('password.code.form'); // Étape 3: Formulaire code
Route::post('reset-password/code', [PasswordResetController::class, 'verifyCode'])->name('password.code.verify'); // Étape 4: Vérification code
Route::get('reset-password/new', [PasswordResetController::class, 'showResetForm'])->name('password.reset.form'); // Étape 5: Formulaire nouveau mdp
Route::post('reset-password/new', [PasswordResetController::class, 'reset'])->name('password.update'); // Étape 6: Mise à jour mdp

// Routes des Dashboards (Protégées par l'authentification)
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/client/dashboard', [ClientDashboardController::class, 'index'])->name('client.dashboard');
    Route::get('/provider/dashboard', [ProviderDashboardController::class, 'index'])->name('provider.dashboard');

    // Route générique de redirection après login si nécessaire (ou gérée dans LoginController)
    Route::get('/dashboard', [LoginController::class, 'redirectToDashboard'])->name('dashboard');
});

// Optionnel: Route par défaut ou page d'accueil
Route::get('/', function () {
    return view('welcome'); // Ou rediriger vers le login si non authentifié
});
