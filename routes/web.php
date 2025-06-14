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
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/welcome', function () {
    return view('welcome');
});

// Seguindo Routes
Route::get('/updates', [UpdatesController::class, 'index'])->name('updates');
Route::get('/library', [LibraryController::class, 'index'])->name('library');
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
