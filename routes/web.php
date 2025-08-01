<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MangaController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [MangaController::class, 'search'])->name('manga.search');
Route::get('/sobre', [HomeController::class, 'about'])->name('about');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/recent-additions', [HomeController::class, 'recentAdditions'])->name('recent.additions');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'App\Http\Controllers\Auth\LoginController@login');
    
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
    Route::post('logout', 'App\\Http\\Controllers\\Auth\\LoginController@logout')->name('logout');
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

// Manga Routes
Route::get('/manga', [App\Http\Controllers\MangaController::class, 'index'])->name('manga.index');
Route::get('/manga/{id}', [App\Http\Controllers\MangaController::class, 'show'])->name('manga.show');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    
    Route::get('/dashboard', 'App\Http\Controllers\Admin\DashboardController@index')->name('dashboard');
    
    // Manga Routes
    Route::resource('mangas', 'App\Http\Controllers\Admin\MangaController')->except(['show']);
    Route::get('mangas/{manga}/confirm-delete', 'App\Http\Controllers\Admin\MangaController@confirmDelete')->name('mangas.confirm-delete');
    
    // Genre Routes
    Route::get('genres', 'App\Http\Controllers\Admin\GenreController@index')->name('genres.index');
    Route::get('genres/create', 'App\Http\Controllers\Admin\GenreController@create')->name('genres.create');
    Route::post('genres', 'App\Http\Controllers\Admin\GenreController@store')->name('genres.store');
    Route::get('genres/{genre}/edit', 'App\Http\Controllers\Admin\GenreController@edit')->name('genres.edit');
    Route::put('genres/{genre}', 'App\Http\Controllers\Admin\GenreController@update')->name('genres.update');
    Route::delete('genres/{genre}', 'App\Http\Controllers\Admin\GenreController@destroy')->name('genres.destroy');
    Route::get('genres/{genre}/confirm-delete', 'App\Http\Controllers\Admin\GenreController@confirmDelete')->name('genres.confirm-delete');
});

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

// Admin Routes
require __DIR__.'/admin.php';

// Notification routes
Route::middleware(['auth'])->group(function () {
    // Mark single notification as read
    Route::post('/notifications/{notification}/mark-as-read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])
        ->name('notifications.mark-as-read');
        
    // Mark all notifications as read
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])
        ->name('notifications.mark-all-read');
        
    // AJAX endpoints
    Route::post('/notifications/{notification}/mark-as-read-ajax', [\App\Http\Controllers\NotificationController::class, 'markAsReadAjax'])
        ->name('notifications.mark-as-read-ajax');
        
    Route::post('/notifications/mark-all-read-ajax', [\App\Http\Controllers\NotificationController::class, 'markAllAsReadAjax'])
        ->name('notifications.mark-all-read-ajax');
        
    // View all notifications
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])
        ->name('notifications.index');
        
    // Delete notifications
    Route::delete('/notifications/{notification}', [\App\Http\Controllers\NotificationController::class, 'destroy'])
        ->name('notifications.destroy');
        
    Route::delete('/notifications', [\App\Http\Controllers\NotificationController::class, 'destroyAll'])
        ->name('notifications.destroy-all');
});
