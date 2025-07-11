<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sobre', [HomeController::class, 'about'])->name('about');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/recent-additions', [HomeController::class, 'recentAdditions'])->name('recent.additions');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'App\Http\Controllers\Auth\LoginController@login');
    Route::post('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
    
    // Registration Routes...
    Route::get('register', 'App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'App\Http\Controllers\Auth\RegisterController@register');
    
    // Password Reset Routes...
    Route::get('password/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.update');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // User Management
    Route::get('users', 'App\Http\Controllers\UserController@index')->name('users.index');
    Route::get('users/{user}', 'App\Http\Controllers\UserController@show')->name('users.show');
    
    // Profile
    Route::get('profile', 'App\Http\Controllers\ProfileController@show')->name('profile.show');
    Route::get('profile/edit', 'App\Http\Controllers\ProfileController@edit')->name('profile.edit');
    Route::put('profile/update', 'App\Http\Controllers\ProfileController@update')->name('profile.update');
    Route::get('profile/change-password', 'App\Http\Controllers\ProfileController@showChangePasswordForm')->name('password.change');
    Route::post('profile/change-password', 'App\Http\Controllers\ProfileController@changePassword')->name('password.update');
});

// Updates Route
Route::get('/updates', [App\Http\Controllers\UpdatesController::class, 'index'])->name('updates');

// Library Route
Route::get('/library', [App\Http\Controllers\LibraryController::class, 'index'])->name('library.index');

// Other routes
Route::get('/bookmarks', 'App\Http\Controllers\BookmarksController@index')->name('bookmarks');
Route::get('/groups', 'App\Http\Controllers\GroupsController@index')->name('groups.index');
Route::get('/history', 'App\Http\Controllers\HistoryController@index')->name('history');

// Group Routes
Route::get('/groups/community', 'App\Http\Controllers\GroupsController@community')->name('groups.community');

// API Routes
Route::prefix('api')->group(function () {
    Route::get('/search/manga', 'App\Http\Controllers\HomeController@searchManga')->name('api.search.manga');
    
    Route::middleware('auth')->group(function () {
        Route::post('/library', 'App\Http\Controllers\LibraryController@store')->name('api.library.store');
        Route::post('/library/update-view-mode', 'App\Http\Controllers\LibraryController@updateViewMode')->name('library.update-view-mode');
        Route::post('/library/{manga}/update-status', 'App\Http\Controllers\LibraryController@updateStatus')->name('library.update-status');
        Route::delete('/library/{manga}', 'App\Http\Controllers\LibraryController@destroy')->name('api.library.destroy');
    });
});

// Random Manga
Route::get('/random', 'App\Http\Controllers\HomeController@random')->name('random');

// Forum Route
Route::get('/forum', 'App\Http\Controllers\HomeController@forum')->name('forum');

// Latest Updates Route
Route::get('/latest-updates', 'App\Http\Controllers\HomeController@latestUpdates')->name('latest.updates');

// Advanced Search Route
Route::get('/advanced-search', 'App\Http\Controllers\HomeController@advancedSearch')->name('advanced.search');
