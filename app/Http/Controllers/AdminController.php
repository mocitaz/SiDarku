<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Education;
use App\Models\TTDLog;
use App\Models\Cycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Show admin login form
     */
    public function showLoginForm()
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    /**
     * Handle admin login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            
            if ($user->role !== 'admin') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akses ditolak. Hanya admin yang dapat login.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $totalUsers = User::where('role', 'user')->count() ?: 0;
        $totalEducations = Education::count() ?: 0;
        $totalCheckins = TTDLog::count() ?: 0;
        $totalCycles = Cycle::count() ?: 0;
        
        // Additional stats
        $activeUsers = User::where('role', 'user')
            ->whereHas('ttdLogs', function($query) {
                $query->where('created_at', '>=', now()->subDays(30));
            })
            ->count() ?: 0;
        
        $todayCheckins = TTDLog::whereDate('created_at', today())->count() ?: 0;
        $thisMonthCheckins = TTDLog::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count() ?: 0;
        
        $thisMonthUsers = User::where('role', 'user')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count() ?: 0;
        
        $recentUsers = User::where('role', 'user')
            ->latest()
            ->take(5)
            ->get();
        
        // Recent check-ins
        $recentCheckins = TTDLog::with('user')
            ->latest()
            ->take(5)
            ->get();
        
        // Top categories
        $topCategories = Education::selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->take(5)
            ->get();

        // Chart data for mini charts
        $usersByMonth = User::where('role', 'user')
            ->where('created_at', '>=', now()->subMonths(6))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        $userRegistrationLabels = [];
        $userRegistrationData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $monthLabel = now()->subMonths($i)->locale('id')->isoFormat('MMM');
            $userRegistrationLabels[] = $monthLabel;
            $userRegistrationData[] = $usersByMonth->firstWhere('month', $month)->count ?? 0;
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalEducations',
            'totalCheckins',
            'totalCycles',
            'activeUsers',
            'todayCheckins',
            'thisMonthCheckins',
            'thisMonthUsers',
            'recentUsers',
            'recentCheckins',
            'topCategories',
            'userRegistrationLabels',
            'userRegistrationData'
        ));
    }

    /**
     * Show users management page
     */
    public function users(Request $request)
    {
        $query = User::where('role', 'user');

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(15);

        return view('admin.users', compact('users'));
    }

    /**
     * Show user details
     */
    public function showUser($id)
    {
        $user = User::where('role', 'user')->findOrFail($id);
        
        $checkins = $user->ttdLogs()->latest()->take(10)->get();
        $cycles = $user->cycles()->latest()->take(10)->get();
        
        $stats = [
            'total_checkins' => $user->ttdLogs()->count(),
            'total_cycles' => $user->cycles()->count(),
            'current_streak' => $this->calculateStreak($user),
            'compliance_rate' => $this->calculateComplianceRate($user),
        ];

        return view('admin.user-detail', compact('user', 'checkins', 'cycles', 'stats'));
    }

    /**
     * Delete user
     */
    public function deleteUser($id)
    {
        $user = User::where('role', 'user')->findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus.');
    }

    /**
     * Show analytics page
     */
    public function analytics()
    {
        $totalUsers = User::where('role', 'user')->count();
        $activeUsers = User::where('role', 'user')
            ->whereHas('ttdLogs', function($query) {
                $query->where('created_at', '>=', now()->subDays(30));
            })
            ->count();
        
        $totalCheckins = TTDLog::count();
        $totalCycles = Cycle::count();

        // Chart 1: User Registration per Bulan (6 bulan terakhir)
        $usersByMonth = User::where('role', 'user')
            ->where('created_at', '>=', now()->subMonths(6))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        $userRegistrationLabels = [];
        $userRegistrationData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $monthLabel = now()->subMonths($i)->locale('id')->isoFormat('MMM YYYY');
            $userRegistrationLabels[] = $monthLabel;
            $userRegistrationData[] = $usersByMonth->firstWhere('month', $month)->count ?? 0;
        }

        // Chart 2: Check-ins per Bulan (6 bulan terakhir)
        $monthlyCheckins = TTDLog::where('created_at', '>=', now()->subMonths(6))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        $checkinsLabels = [];
        $checkinsData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $monthLabel = now()->subMonths($i)->locale('id')->isoFormat('MMM YYYY');
            $checkinsLabels[] = $monthLabel;
            $checkinsData[] = $monthlyCheckins->firstWhere('month', $month)->count ?? 0;
        }

        // Chart 3: Cycles per Bulan (6 bulan terakhir)
        $monthlyCycles = Cycle::where('created_at', '>=', now()->subMonths(6))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        $cyclesLabels = [];
        $cyclesData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $monthLabel = now()->subMonths($i)->locale('id')->isoFormat('MMM YYYY');
            $cyclesLabels[] = $monthLabel;
            $cyclesData[] = $monthlyCycles->firstWhere('month', $month)->count ?? 0;
        }

        // Chart 4: Check-ins per Hari (30 hari terakhir)
        $dailyCheckins = TTDLog::where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        $dailyLabels = [];
        $dailyData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dateLabel = now()->subDays($i)->locale('id')->isoFormat('D MMM');
            $dailyLabels[] = $dateLabel;
            $dailyData[] = $dailyCheckins->firstWhere('date', $date)->count ?? 0;
        }

        $topUsers = User::where('role', 'user')
            ->withCount('ttdLogs')
            ->orderBy('ttd_logs_count', 'desc')
            ->take(10)
            ->get();

        return view('admin.analytics', compact(
            'totalUsers',
            'activeUsers',
            'totalCheckins',
            'totalCycles',
            'topUsers',
            'userRegistrationLabels',
            'userRegistrationData',
            'checkinsLabels',
            'checkinsData',
            'cyclesLabels',
            'cyclesData',
            'dailyLabels',
            'dailyData'
        ));
    }

    /**
     * Show educations list
     */
    public function educations()
    {
        $educations = Education::latest()->paginate(15);
        return view('admin.educations', compact('educations'));
    }

    /**
     * Show create education form
     */
    public function createEducation()
    {
        return view('admin.education-form');
    }

    /**
     * Store education
     */
    public function storeEducation(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category' => ['required', 'in:Anemia,Menstruasi,TTD,Nutrisi,Tips Sehat'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $education = new Education();
        $education->title = $validated['title'];
        // Generate unique slug
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Education::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        $education->slug = $slug;
        $education->content = $validated['content'];
        $education->category = $validated['category'];

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('educations', $imageName, 'public');
            $education->image = $imagePath;
        }

        $education->save();

        return redirect()->route('admin.educations')->with('success', 'Artikel edukasi berhasil ditambahkan.');
    }

    /**
     * Show edit education form
     */
    public function editEducation($id)
    {
        $education = Education::findOrFail($id);
        return view('admin.education-form', compact('education'));
    }

    /**
     * Update education
     */
    public function updateEducation(Request $request, $id)
    {
        $education = Education::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category' => ['required', 'in:Anemia,Menstruasi,TTD,Nutrisi,Tips Sehat'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        // Generate unique slug if title changed
        $oldTitle = $education->title;
        $education->title = $validated['title'];
        
        if ($oldTitle !== $validated['title']) {
            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;
            $counter = 1;
            while (Education::where('slug', $slug)->where('id', '!=', $education->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            $education->slug = $slug;
        }
        $education->content = $validated['content'];
        $education->category = $validated['category'];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($education->image) {
                Storage::disk('public')->delete($education->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('educations', $imageName, 'public');
            $education->image = $imagePath;
        }

        $education->save();

        return redirect()->route('admin.educations')->with('success', 'Artikel edukasi berhasil diperbarui.');
    }

    /**
     * Delete education
     */
    public function deleteEducation($id)
    {
        $education = Education::findOrFail($id);
        
        // Delete image
        if ($education->image) {
            Storage::disk('public')->delete($education->image);
        }

        $education->delete();

        return redirect()->route('admin.educations')->with('success', 'Artikel edukasi berhasil dihapus.');
    }

    /**
     * Handle admin logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    /**
     * Calculate user streak
     */
    private function calculateStreak($user)
    {
        $logs = $user->ttdLogs()
            ->where('is_consumed', true)
            ->orderBy('log_date', 'desc')
            ->get();

        if ($logs->isEmpty()) {
            return 0;
        }

        $streak = 0;
        $expectedDate = now()->toDateString();

        foreach ($logs as $log) {
            $logDate = \Carbon\Carbon::parse($log->log_date)->toDateString();
            if ($logDate === $expectedDate) {
                $streak++;
                $expectedDate = \Carbon\Carbon::parse($expectedDate)->subDay()->toDateString();
            } else {
                break;
            }
        }

        return $streak;
    }

    /**
     * Calculate compliance rate
     */
    private function calculateComplianceRate($user)
    {
        $totalDays = 30; // Last 30 days
        $consumedDays = $user->ttdLogs()
            ->where('is_consumed', true)
            ->where('log_date', '>=', now()->subDays($totalDays))
            ->count();

        return $totalDays > 0 ? round(($consumedDays / $totalDays) * 100, 1) : 0;
    }
}
