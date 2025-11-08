<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\VerifyEmailMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Show registration form
     */
    public function showRegisterForm()
    {
        try {
            return view('auth.register');
        } catch (\Exception $e) {
            \Log::error('Error loading register form: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return response('Error loading registration page. Please check logs.', 500);
        }
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'date_of_birth' => ['required', 'date', 'before:' . now()->subYears(10)->format('Y-m-d')],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
            'terms' => ['required', 'accepted'],
        ], [
            'date_of_birth.before' => 'Anda harus berusia minimal 10 tahun untuk menggunakan aplikasi ini.',
            'terms.accepted' => 'Anda harus menyetujui ketentuan dan kebijakan privasi.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'date_of_birth' => $validated['date_of_birth'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        // Send verification email
        Mail::to($user->email)->send(new VerifyEmailMail($user));

        Auth::login($user);

        return redirect()->route('verification.notice')->with('message', 'Silakan verifikasi email Anda. Kami telah mengirimkan link verifikasi ke email Anda.');
    }

    /**
     * Show login form
     */
    public function showLoginForm()
    {
        try {
            // Auto-redirect admin if already logged in
            if (auth()->check() && auth()->user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            
            return view('auth.login');
        } catch (\Exception $e) {
            \Log::error('Error loading login form: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return response('Error loading login page. Please check logs.', 500);
        }
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            $request->session()->regenerate();
            
            // Auto-detect role: Admin always goes to admin dashboard
            if ($user->role === 'admin') {
                // Clear any intended URL and force redirect to admin dashboard
                $request->session()->forget('url.intended');
                return redirect()->route('admin.dashboard');
            }
            
            // Regular users go to home
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Show email verification notice
     */
    public function showVerificationNotice()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return redirect()->route('home');
        }
        return view('auth.verify-email');
    }

    /**
     * Verify email
     */
    public function verifyEmail(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        // Hash verification (signed URL is already verified by middleware)
        if (!hash_equals((string) $hash, sha1($user->email))) {
            return redirect()->route('login')->with('error', 'Hash verifikasi tidak valid.');
        }

        if ($user->hasVerifiedEmail()) {
            // Auto login if not already logged in
            if (!auth()->check()) {
                Auth::login($user);
            }
            return redirect()->route('home')->with('message', 'Email Anda sudah terverifikasi.');
        }

        if ($user->markEmailAsVerified()) {
            // Auto login after verification
            if (!auth()->check()) {
                Auth::login($user);
            }
            return redirect()->route('home')->with('message', 'Email berhasil diverifikasi! Selamat datang di SiDarku! 🎉');
        }

        return redirect()->route('login')->with('error', 'Gagal memverifikasi email. Silakan coba lagi.');
    }

    /**
     * Resend verification email
     */
    public function resendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        Mail::to($request->user()->email)->send(new VerifyEmailMail($request->user()));

        return back()->with('message', 'Link verifikasi baru telah dikirim ke email Anda.');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
