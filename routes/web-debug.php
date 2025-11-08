<?php
// Temporary debug routes - HAPUS setelah debugging selesai!

use Illuminate\Support\Facades\Route;

// Test route sederhana
Route::get('/test-simple', function () {
    return 'Hello World - Laravel is working!';
});

// Test route dengan JSON
Route::get('/test-json', function () {
    return response()->json(['status' => 'ok', 'message' => 'Laravel is working']);
});

// Test route dengan view sederhana
Route::get('/test-view', function () {
    return response('<h1>Test View</h1><p>Laravel is working!</p>');
});

// Test route dengan auth check (tanpa redirect)
Route::get('/test-auth', function () {
    try {
        $isAuth = auth()->check();
        return response()->json(['authenticated' => $isAuth]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

