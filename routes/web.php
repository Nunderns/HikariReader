<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UpdatesController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\BookmarksController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\HistoryController;

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::get('register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);
    Route::get('password/reset', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
});

// Authentication Routes (Authenticated)
Route::middleware('auth')->group(function () {
    Route::post('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    
    // Profile Routes
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', [\App\Http\Controllers\ProfileController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/profile/change-password', [\App\Http\Controllers\ProfileController::class, 'changePassword'])->name('password.update');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sobre', [HomeController::class, 'about'])->name('about');
Route::get('/recent-additions', [HomeController::class, 'recentAdditions'])->name('recent.additions');
Route::get('/welcome', function () {
    return view('welcome');
});

// Seguindo Routes
Route::get('/updates', [UpdatesController::class, 'index'])->name('updates');

// Rotas da Biblioteca
Route::prefix('library')->name('library.')->group(function () {
    // Rota principal que redireciona para a visualização apropriada
    Route::get('/', [LibraryController::class, 'index'])->name('index');
    
    // Rotas que requerem autenticação
    Route::middleware('auth')->group(function () {
        Route::post('/store', [LibraryController::class, 'store'])->name('store');
        Route::delete('/{manga}', [LibraryController::class, 'destroy'])->name('destroy');
        
        // Atualizar modo de visualização
        Route::post('/update-view-mode', [LibraryController::class, 'updateViewMode'])
            ->name('update-view-mode');
            
        // Atualizar status de leitura
        Route::post('/update-status/{manga}', [LibraryController::class, 'updateStatus'])
            ->name('update-status');
    });
});

Route::get('/bookmarks', [BookmarksController::class, 'index'])->name('bookmarks');
Route::get('/groups', [GroupsController::class, 'index'])->name('groups.index');
Route::get('/history', [HistoryController::class, 'index'])->name('history');

// Group Routes
Route::get('/groups/community', [GroupsController::class, 'community'])->name('groups.community');

// Títulos Routes
Route::get('/advanced-search', [HomeController::class, 'advancedSearch'])->name('advanced.search');
Route::get('/recent-additions', [HomeController::class, 'recentAdditions'])->name('recent.additions');
Route::get('/latest-updates', [HomeController::class, 'latestUpdates'])->name('latest.updates');
Route::get('/random', [HomeController::class, 'random'])->name('random');

// Comunidade Routes
Route::get('/forum', [HomeController::class, 'forum'])->name('forum');
Route::get('/users', [HomeController::class, 'users'])->name('users');

// HikariReader Routes
Route::get('/about', [HomeController::class, 'about'])->name('about');
