<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MangaController;
use App\Http\Controllers\Admin\NotificationController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Manga Management
    Route::resource('mangas', MangaController::class);
    
    // Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('mark-as-read');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('destroy');
        Route::delete('/', [NotificationController::class, 'destroyAll'])->name('destroy-all');
        
        // AJAX endpoints for notification actions
        Route::post('/{notification}/mark-as-read-ajax', [NotificationController::class, 'markAsReadAjax'])
            ->name('mark-as-read-ajax');
        Route::post('/mark-all-read-ajax', [NotificationController::class, 'markAllAsReadAjax'])
            ->name('mark-all-read-ajax');
    });
    
    // API Routes for Notifications
    Route::prefix('api')->name('api.')->group(function () {
        Route::post('notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
        Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    });
});
