<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EducationController;
use App\Livewire\HomeScreen;
use App\Livewire\TtdCheckin;
use App\Livewire\CycleTracker;
use App\Livewire\ProgressChart;
use App\Livewire\EducationList;
use App\Livewire\ProfilePage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;

// Test routes untuk debugging
Route::get('/test', function () {
    return response()->json(['status' => 'ok', 'message' => 'Laravel is working']);
});

Route::get('/test-view', function () {
    try {
        return view('landing');
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});

Route::get('/test-view-simple', function () {
    return view('test-simple');
});

Route::get('/test-simple', function () {
    return '<h1>Simple HTML</h1><p>This works!</p>';
});

Route::get('/test-asset', function () {
    return response()->json([
        'icon_path' => asset('images/icon.png'),
        'icon_exists' => file_exists(public_path('images/icon.png'))
    ]);
});

Route::get('/test-route-helper', function () {
    try {
        $loginUrl = route('login');
        return response()->json(['login_url' => $loginUrl, 'status' => 'ok']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

// Serve education images from storage (fallback route if symlink doesn't work)
Route::get('/images/educations/{path}', function ($path) {
    // Decode URL-encoded path
    $path = urldecode($path);
    
    // Construct full path
    $fullPath = 'educations/' . $path;
    
    // Log for debugging
    \Log::debug('Requesting education image: ' . $fullPath);
    
    if (!\Storage::disk('public')->exists($fullPath)) {
        \Log::warning('Education image not found: ' . $fullPath);
        abort(404, 'Image not found: ' . $fullPath);
    }
    
    try {
        $file = \Storage::disk('public')->get($fullPath);
        $type = \Storage::disk('public')->mimeType($fullPath);
        
        if (!$type) {
            // Try to detect mime type from extension
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $mimeTypes = [
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'webp' => 'image/webp',
            ];
            $type = $mimeTypes[strtolower($extension)] ?? 'image/jpeg';
        }
        
        return response($file, 200)
            ->header('Content-Type', $type)
            ->header('Cache-Control', 'public, max-age=31536000');
    } catch (\Exception $e) {
        \Log::error('Error serving education image: ' . $e->getMessage(), [
            'path' => $fullPath,
            'trace' => $e->getTraceAsString()
        ]);
        abort(404, 'Error loading image');
    }
})->where('path', '.*')->name('education.image');

// Also handle direct /storage/educations/ requests (in case browser requests old URLs)
Route::get('/storage/educations/{path}', function ($path) {
    // Decode URL-encoded path
    $path = urldecode($path);
    $fullPath = 'educations/' . $path;
    
    \Log::debug('Requesting education image from /storage/: ' . $fullPath);
    
    if (!\Storage::disk('public')->exists($fullPath)) {
        \Log::warning('Education image not found in /storage/: ' . $fullPath);
        // Redirect to image route
        return redirect()->route('education.image', ['path' => $path]);
    }
    
    try {
        $file = \Storage::disk('public')->get($fullPath);
        $type = \Storage::disk('public')->mimeType($fullPath);
        
        if (!$type) {
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $mimeTypes = [
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'webp' => 'image/webp',
            ];
            $type = $mimeTypes[strtolower($extension)] ?? 'image/jpeg';
        }
        
        return response($file, 200)
            ->header('Content-Type', $type)
            ->header('Cache-Control', 'public, max-age=31536000');
    } catch (\Exception $e) {
        \Log::error('Error serving education image from /storage/: ' . $e->getMessage());
        // Fallback to image route
        return redirect()->route('education.image', ['path' => $path]);
    }
})->where('path', '.*');

// Landing page (public)
Route::get('/', function () {
    // Check auth dengan error handling yang lebih aman
    $isAuthenticated = false;
    try {
        // Check if user is authenticated without throwing error
        if (auth()->check()) {
            $isAuthenticated = true;
        }
    } catch (\Exception $e) {
        // Ignore auth errors - session mungkin belum siap atau belum diinisialisasi
        \Log::debug('Auth check skipped: ' . $e->getMessage());
    }
    
    if ($isAuthenticated) {
        try {
            return redirect()->route('home');
        } catch (\Exception $e) {
            // Jika redirect gagal, tetap tampilkan landing page
            \Log::warning('Redirect to home failed: ' . $e->getMessage());
        }
    }
    
    return view('landing');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Register
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Password Reset
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');
    
    Route::post('/forgot-password', function (\Illuminate\Http\Request $request) {
        $request->validate(['email' => 'required|email']);
        
        $status = Password::sendResetLink(
            $request->only('email')
        );
        
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    })->name('password.email');
    
    Route::get('/reset-password/{token}', function (\Illuminate\Http\Request $request) {
        return view('auth.reset-password', ['request' => $request]);
    })->name('password.reset');
    
    Route::post('/reset-password', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::min(8)],
        ]);
        
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => \Illuminate\Support\Facades\Hash::make($password)
                ])->save();
            }
        );
        
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    })->name('password.store');
});

// Email Verification (can be accessed without auth when clicking from email)
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware('signed')
    ->name('verification.verify');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Email Verification Notice & Resend (requires auth)
    Route::get('/email/verify', [AuthController::class, 'showVerificationNotice'])->name('verification.notice');
    Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])->name('verification.send');
    
    // Main routes
    Route::get('/home', HomeScreen::class)->name('home');
    Route::get('/checkin', TtdCheckin::class)->name('checkin');
    Route::get('/cycle', CycleTracker::class)->name('cycle');
    Route::get('/progress', ProgressChart::class)->name('progress');
    Route::get('/education', EducationList::class)->name('education');
    Route::get('/education/{slug}', [EducationController::class, 'show'])->name('education.show');
    Route::get('/profile', ProfilePage::class)->name('profile');
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin routes
Route::prefix('admin')->group(function () {
    // Admin login (guest only)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [\App\Http\Controllers\AdminController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [\App\Http\Controllers\AdminController::class, 'login']);
    });

    // Admin protected routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
        Route::get('/users/{id}', [\App\Http\Controllers\AdminController::class, 'showUser'])->name('admin.user.show');
        Route::delete('/users/{id}', [\App\Http\Controllers\AdminController::class, 'deleteUser'])->name('admin.user.delete');
        Route::get('/analytics', [\App\Http\Controllers\AdminController::class, 'analytics'])->name('admin.analytics');
        Route::get('/educations', [\App\Http\Controllers\AdminController::class, 'educations'])->name('admin.educations');
        Route::get('/educations/create', [\App\Http\Controllers\AdminController::class, 'createEducation'])->name('admin.education.create');
        Route::post('/educations', [\App\Http\Controllers\AdminController::class, 'storeEducation'])->name('admin.education.store');
        Route::get('/educations/{id}/edit', [\App\Http\Controllers\AdminController::class, 'editEducation'])->name('admin.education.edit');
        Route::put('/educations/{id}', [\App\Http\Controllers\AdminController::class, 'updateEducation'])->name('admin.education.update');
        Route::delete('/educations/{id}', [\App\Http\Controllers\AdminController::class, 'deleteEducation'])->name('admin.education.delete');
        Route::post('/logout', [\App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');
    });
});
