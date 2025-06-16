<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SearchController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rotas de API para busca
Route::prefix('search')->group(function () {
    Route::get('/manga', [SearchController::class, 'searchManga'])->name('api.search.manga');
});

// Rotas de API que requerem autenticação
Route::middleware('auth:sanctum')->group(function () {
    // Rotas da biblioteca do usuário
    Route::prefix('library')->group(function () {
        Route::post('/', [\App\Http\Controllers\LibraryController::class, 'store'])->name('api.library.store');
        Route::delete('/{manga}', [\App\Http\Controllers\LibraryController::class, 'destroy'])->name('api.library.destroy');
    });
});
