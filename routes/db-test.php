<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

Route::get('/db-test', function () {
    $connection = config('database.default');
    $config = config("database.connections.{$connection}");
    
    try {
        DB::connection()->getPdo();
        $success = true;
        $error = null;
    } catch (\Exception $e) {
        $success = false;
        $error = $e->getMessage();
    }
    
    return [
        'connection' => $connection,
        'config' => $config,
        'connected' => $success,
        'error' => $error,
        'database_name' => $success ? DB::connection()->getDatabaseName() : null,
    ];
});
