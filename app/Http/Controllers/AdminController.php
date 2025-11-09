<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Education;
use App\Models\TTDLog;
use App\Models\Cycle;
use App\Models\TtdReminderLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
     * Show TTD reminder logs
     */
    public function ttdReminderLogs(Request $request)
    {
        $query = TtdReminderLog::with('user')->latest('reminder_date')->latest('created_at');

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->has('date') && $request->date) {
            $query->whereDate('reminder_date', $request->date);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('user_name', 'like', '%' . $request->search . '%')
                  ->orWhere('user_email', 'like', '%' . $request->search . '%');
            });
        }

        $logs = $query->paginate(50);

        // Statistics
        $stats = [
            'total_sent' => TtdReminderLog::where('status', 'sent')->count(),
            'total_skipped' => TtdReminderLog::where('status', 'skipped')->count(),
            'total_disabled' => TtdReminderLog::where('status', 'disabled')->count(),
            'today_sent' => TtdReminderLog::where('status', 'sent')
                ->whereDate('reminder_date', today())
                ->count(),
            'today_disabled' => TtdReminderLog::where('status', 'disabled')
                ->whereDate('reminder_date', today())
                ->count(),
        ];

        // Users who disabled reminders
        $usersWithDisabledReminders = User::where('email_ttd_reminder_enabled', false)
            ->where('role', 'user')
            ->get();

        // Check reminder status
        $reminderStatus = $this->getReminderStatus();

        return view('admin.ttd-reminder-logs', compact('logs', 'stats', 'usersWithDisabledReminders', 'reminderStatus'));
    }

    /**
     * Check reminder status (refresh)
     */
    public function checkReminderStatus(Request $request)
    {
        $status = $this->getReminderStatus();

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json($status);
        }

        return redirect()->route('admin.ttd-reminder-logs')->with('reminder_status', $status);
    }

    /**
     * Get current reminder status
     */
    private function getReminderStatus()
    {
        Carbon::setLocale('id');
        $now = Carbon::now('Asia/Jakarta');
        $today = Carbon::today('Asia/Jakarta');
        $scheduledHour = 12;
        $scheduledMinute = 0;

        // Check today's logs
        $todayLogs = TtdReminderLog::whereDate('reminder_date', $today)->get();
        $todaySent = $todayLogs->where('status', 'sent')->count();
        $todaySkipped = $todayLogs->where('status', 'skipped')->count();
        $todayDisabled = $todayLogs->where('status', 'disabled')->count();

        // Check if already sent today
        $alreadySent = $todaySent > 0;

        // Get current day of week (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
        $currentDayOfWeek = $now->dayOfWeek; // 1 = Monday, 4 = Thursday
        $isMonday = $currentDayOfWeek === Carbon::MONDAY;
        $isThursday = $currentDayOfWeek === Carbon::THURSDAY;
        $isScheduledDay = $isMonday || $isThursday;

        // Get today's scheduled time if it's a scheduled day
        $todayScheduledTime = null;
        if ($isScheduledDay) {
            $todayScheduledTime = $today->copy()->setTime($scheduledHour, $scheduledMinute, 0);
        }

        // Determine next scheduled time (Monday or Thursday at 12:00)
        $nextScheduledTime = $this->getNextScheduledTime($now, $isScheduledDay, $todayScheduledTime, $alreadySent);

        // Check if it's time to send today
        $isTimeToSend = false;
        $isBeforeSchedule = false;
        
        if ($isScheduledDay && $todayScheduledTime) {
            $isTimeToSend = $now->greaterThanOrEqualTo($todayScheduledTime) && !$alreadySent;
            $isBeforeSchedule = $now->lessThan($todayScheduledTime);
        }

        // Calculate countdown to next scheduled time
        $totalSeconds = $now->diffInSeconds($nextScheduledTime, false);
        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $seconds = $totalSeconds % 60;

        $countdown = [
            'hours' => str_pad(max(0, $hours), 2, '0', STR_PAD_LEFT),
            'minutes' => str_pad(max(0, $minutes), 2, '0', STR_PAD_LEFT),
            'seconds' => str_pad(max(0, $seconds), 2, '0', STR_PAD_LEFT),
            'total_seconds' => max(0, $totalSeconds),
        ];

        $timeUntilSend = null;
        if ($isBeforeSchedule && $isScheduledDay) {
            $timeUntilSend = $now->diffForHumans($todayScheduledTime, true);
        } elseif ($isTimeToSend) {
            $timeUntilSend = 'Sudah waktunya!';
        } else {
            $nextDayName = $nextScheduledTime->locale('id')->isoFormat('dddd');
            $timeUntilSend = $now->diffForHumans($nextScheduledTime, true) . " ({$nextDayName})";
        }

        // Get last sent time
        $lastSent = TtdReminderLog::where('status', 'sent')
            ->whereDate('reminder_date', $today)
            ->latest('created_at')
            ->first();

        // Calculate next scheduled datetime in ISO format for JavaScript
        $nextScheduledDatetime = $nextScheduledTime->copy()->setTimezone('Asia/Jakarta');
        $nextDayName = $nextScheduledTime->locale('id')->isoFormat('dddd');
        $todayDayName = $now->locale('id')->isoFormat('dddd');

        $status = [
            'current_time' => $now->format('H:i:s'),
            'current_date' => $now->format('d M Y'),
            'scheduled_time' => sprintf('%02d:%02d', $scheduledHour, $scheduledMinute),
            'scheduled_days' => 'Senin & Kamis',
            'next_scheduled_day' => $nextDayName,
            'next_scheduled_date' => $nextScheduledTime->format('d M Y'),
            'scheduled_datetime' => $isScheduledDay && $todayScheduledTime 
                ? $todayScheduledTime->copy()->setTimezone('Asia/Jakarta')->toIso8601String() 
                : null,
            'next_scheduled_datetime' => $nextScheduledDatetime->toIso8601String(),
            'timezone' => 'WIB (Asia/Jakarta)',
            'is_time_to_send' => $isTimeToSend,
            'is_before_schedule' => $isBeforeSchedule,
            'is_scheduled_day' => $isScheduledDay,
            'already_sent' => $alreadySent,
            'time_until_send' => $timeUntilSend,
            'countdown' => $countdown,
            'today_sent' => $todaySent,
            'today_skipped' => $todaySkipped,
            'today_disabled' => $todayDisabled,
            'last_sent_at' => $lastSent ? $lastSent->created_at->setTimezone('Asia/Jakarta')->format('H:i:s') : null,
            'message' => $this->getStatusMessage($alreadySent, $isTimeToSend, $isBeforeSchedule, $timeUntilSend, $todaySent, $isScheduledDay, $todayDayName, $nextDayName),
        ];

        return $status;
    }

    /**
     * Get next scheduled time (Monday or Thursday at 12:00)
     */
    private function getNextScheduledTime(Carbon $now, bool $isScheduledDay, ?Carbon $todayScheduledTime, bool $alreadySent): Carbon
    {
        $scheduledHour = 12;
        $scheduledMinute = 0;
        $currentDayOfWeek = $now->dayOfWeek;
        
        // If today is a scheduled day
        if ($isScheduledDay && $todayScheduledTime) {
            // If already sent today, or past 12:00, get next scheduled day
            if ($alreadySent || $now->greaterThanOrEqualTo($todayScheduledTime)) {
                // Get next scheduled day
                if ($currentDayOfWeek === Carbon::MONDAY) {
                    // Next is Thursday (3 days later)
                    return $now->copy()->addDays(3)->setTime($scheduledHour, $scheduledMinute, 0);
                } else { // Thursday
                    // Next is Monday (4 days later)
                    return $now->copy()->addDays(4)->setTime($scheduledHour, $scheduledMinute, 0);
                }
            } else {
                // Before 12:00 today, next is today
                return $todayScheduledTime;
            }
        }
        
        // Today is not a scheduled day, find next Monday or Thursday
        $nextMonday = $now->copy()->next(Carbon::MONDAY)->setTime($scheduledHour, $scheduledMinute, 0);
        $nextThursday = $now->copy()->next(Carbon::THURSDAY)->setTime($scheduledHour, $scheduledMinute, 0);
        
        // Return the closer one
        if ($nextMonday->lessThan($nextThursday)) {
            return $nextMonday;
        } else {
            return $nextThursday;
        }
    }

    /**
     * Get status message
     */
    private function getStatusMessage($alreadySent, $isTimeToSend, $isBeforeSchedule, $timeUntilSend, $todaySent, $isScheduledDay, $todayDayName, $nextDayName)
    {
        if ($alreadySent && $isScheduledDay) {
            return "Hari ini ({$todayDayName}) sudah terkirim {$todaySent} email reminder pada jam 12:00 WIB. Sistem akan mengirim lagi pada {$nextDayName} jam 12:00 WIB.";
        } elseif ($isTimeToSend && $isScheduledDay) {
            return "Sistem akan mengirim reminder otomatis pada jam 12:00 WIB. Email akan terkirim dalam beberapa saat.";
        } elseif ($isBeforeSchedule && $isScheduledDay) {
            return "Email reminder akan dikirim otomatis oleh sistem hari ini ({$todayDayName}) pada jam 12:00 WIB. Silakan tunggu sampai waktu yang ditentukan.";
        } elseif ($isScheduledDay) {
            return "Hari ini adalah hari schedule ({$todayDayName}). Email reminder akan dikirim otomatis pada jam 12:00 WIB.";
        } else {
            return "Email reminder akan dikirim otomatis pada {$nextDayName} jam 12:00 WIB. Sistem mengirim reminder 2 kali seminggu (Senin & Kamis).";
        }
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
