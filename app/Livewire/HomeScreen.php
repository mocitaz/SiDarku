<?php

namespace App\Livewire;

use App\Models\TTDLog;
use App\Models\Cycle;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeScreen extends Component
{
    public $todayConsumed = false;
    public $currentCycleDay = null;
    public $cycleStatus = 'nonhaid'; // haid, prahaid, nonhaid
    public $nextPeriodPrediction = null;
    public $motivationalQuote = '';
    public $currentStreak = 0;
    public $monthlyCheckIns = 0;
    public $maxStreak = 0;
    public $weeklyProgress = [];
    public $weeklyCompliance = 0;
    public $dailyTip = '';

    public function mount()
    {
        $user = Auth::user();
        
        // Check today's TTD consumption
        $todayLog = TTDLog::where('user_id', $user->id)
            ->whereDate('log_date', Carbon::today())
            ->first();
        
        $this->todayConsumed = $todayLog ? $todayLog->is_consumed : false;

        // Calculate current streak
        $this->currentStreak = $this->calculateStreak($user);

        // Calculate monthly check-ins
        $this->monthlyCheckIns = TTDLog::where('user_id', $user->id)
            ->whereMonth('log_date', Carbon::now()->month)
            ->whereYear('log_date', Carbon::now()->year)
            ->where('is_consumed', true)
            ->count();

        // Calculate max streak
        $this->maxStreak = $this->calculateMaxStreak($user);

        // Get weekly progress
        $this->calculateWeeklyProgress($user);

        // Get current cycle information
        $this->calculateCycleInfo($user);
        
        // Set motivational quote
        $quotes = [
            'Kesehatanmu adalah investasi terbaik untuk masa depanmu ✨',
            'Setiap langkah kecil menuju kesehatan adalah kemenangan besar 💪',
            'Kamu kuat, kamu mampu, dan kamu layak untuk sehat selalu 🌸',
            'Merawat diri adalah bentuk cinta yang paling indah 💕',
            'Hari ini adalah kesempatan baru untuk menjadi versi terbaik dirimu 🌟',
        ];
        $this->motivationalQuote = $quotes[array_rand($quotes)];

        // Set daily tips (banyak tips berdasarkan status)
        $this->dailyTip = $this->getDailyTip();
    }

    protected function getDailyTip()
    {
        $tips = [
            'haid' => [
                'Sedang haid? Konsumsi TTD lebih intensif untuk mencegah anemia.',
                'Periode menstruasi adalah waktu terbaik untuk konsumsi suplemen zat besi. Jangan lupa TTD mu.',
                'Istirahat cukup dan konsumsi TTD teratur saat haid untuk menjaga energi.',
                'Minum air putih minimal 8 gelas dan jangan lupa TTD saat menstruasi.',
                'Konsumsi makanan tinggi zat besi seperti bayam, daging merah, dan jangan lewatkan TTD.',
                'Hindari kafein berlebihan saat haid dan rutin konsumsi TTD untuk kesehatan optimal.',
                'Olahraga ringan seperti yoga dapat membantu mengurangi nyeri haid. Plus, jangan lupa TTD.',
                'Kompres hangat di perut bawah dan konsumsi TTD teratur membantu mengurangi kram.',
            ],
            'prahaid' => [
                'Menjelang haid, jaga nutrisi dan tetap aktif untuk mengurangi PMS.',
                'Fase PMS? Konsumsi TTD sekarang untuk persiapan menstruasi yang lebih sehat.',
                'Kurangi garam dan gula untuk mengurangi kembung PMS, dan rutin konsumsi TTD.',
                'Tidur cukup 7-8 jam sangat penting saat PMS. Jangan lupa TTD.',
                'Konsumsi vitamin B6 dan TTD dapat membantu mengurangi gejala PMS.',
                'Olahraga teratur membantu mood saat PMS. Lengkapi dengan konsumsi TTD.',
                'Mengelola stres dengan meditasi dan konsumsi TTD rutin untuk PMS yang lebih ringan.',
                'Makan makanan bergizi seimbang dan TTD teratur membantu stabilkan hormon.',
            ],
            'nonhaid' => [
                'Jangan lupa TTD minimal 1x/minggu untuk mencegah anemia.',
                'Fase normal adalah waktu terbaik membangun kebiasaan sehat. Konsumsi TTD teratur.',
                'Tetap jaga kesehatan dengan konsumsi TTD mingguan, bahkan saat tidak haid.',
                'Zat besi perlu dijaga sepanjang bulan, bukan hanya saat haid. Rutin TTD.',
                'Konsumsi TTD teratur membantu mencegah anemia defisiensi besi jangka panjang.',
                'Kombinasikan TTD dengan vitamin C untuk penyerapan zat besi lebih maksimal.',
                'Cek kesehatan rutin dan jaga konsumsi TTD untuk pencegahan anemia.',
                'Bangun habit sehat: TTD mingguan + nutrisi seimbang = tubuh kuat.',
                'Konsumsi TTD sekarang sebagai investasi kesehatan jangka panjang.',
                'Jangan tunggu sampai anemia! Konsumsi TTD secara preventif lebih baik.',
            ],
        ];

        $cycleSpecificTips = $tips[$this->cycleStatus] ?? $tips['nonhaid'];
        return $cycleSpecificTips[array_rand($cycleSpecificTips)];
    }

    protected function calculateWeeklyProgress($user)
    {
        // Get start of current week (Monday)
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::MONDAY);
        
        // Get all logs for this week
        $weekLogs = TTDLog::where('user_id', $user->id)
            ->whereBetween('log_date', [$startOfWeek, $endOfWeek])
            ->where('is_consumed', true)
            ->pluck('log_date')
            ->map(fn($date) => Carbon::parse($date)->format('Y-m-d'))
            ->toArray();
        
        // Build 7-day array (Mon-Sun)
        $progress = [];
        for ($i = 0; $i < 7; $i++) {
            $currentDate = $startOfWeek->copy()->addDays($i);
            $dateStr = $currentDate->format('Y-m-d');
            $progress[] = [
                'day' => $currentDate->locale('id')->isoFormat('ddd'),
                'consumed' => in_array($dateStr, $weekLogs),
                'date' => $dateStr,
            ];
        }
        
        $this->weeklyProgress = $progress;
        
        // Calculate weekly compliance (at least 1 per week = 100%)
        $consumed = count($weekLogs);
        $this->weeklyCompliance = min(100, $consumed * 100);
    }

    protected function calculateStreak($user)
    {
        $streak = 0;
        $currentDate = Carbon::today();
        
        while (true) {
            $log = TTDLog::where('user_id', $user->id)
                ->whereDate('log_date', $currentDate)
                ->where('is_consumed', true)
                ->first();
            
            if (!$log) {
                break;
            }
            
            $streak++;
            $currentDate->subDay();
        }
        
        return $streak;
    }

    protected function calculateMaxStreak($user)
    {
        $logs = TTDLog::where('user_id', $user->id)
            ->where('is_consumed', true)
            ->orderBy('log_date', 'asc')
            ->get();

        if ($logs->isEmpty()) {
            return 0;
        }

        $maxStreak = 0;
        $currentStreak = 1;
        $previousDate = null;

        foreach ($logs as $log) {
            $currentDate = Carbon::parse($log->log_date);
            
            if ($previousDate) {
                $dayDiff = $previousDate->diffInDays($currentDate);
                
                if ($dayDiff == 1) {
                    $currentStreak++;
                } else {
                    $maxStreak = max($maxStreak, $currentStreak);
                    $currentStreak = 1;
                }
            }
            
            $previousDate = $currentDate;
        }
        
        $maxStreak = max($maxStreak, $currentStreak);
        
        return $maxStreak;
    }

    protected function calculateCycleInfo($user)
    {
        // Get the most recent cycle
        $latestCycle = Cycle::where('user_id', $user->id)
            ->orderBy('start_date', 'desc')
            ->first();

        if (!$latestCycle) {
            return;
        }

        $today = Carbon::today();
        $latestStartDate = Carbon::parse($latestCycle->start_date);
        
        // Calculate average cycle length using shared method
        $avgCycleLength = Cycle::calculateAverageCycleLength($user->id);
        
        // Predict next period using shared method for consistency
        $predictedDate = Cycle::predictNextPeriod($user->id);
        $this->nextPeriodPrediction = $predictedDate ? $predictedDate->format('Y-m-d') : null;
        $daysUntilNext = $predictedDate ? $today->diffInDays($predictedDate, false) : null;
        
        // Check if cycle has ended or is ongoing
        if ($latestCycle->end_date) {
            // Cycle has ended
            $endDate = Carbon::parse($latestCycle->end_date);
            $daysSinceEnd = $today->diffInDays($endDate);
            
            // Check if we're in the predicted period window (0-7 days after prediction)
            if ($daysUntilNext !== null) {
                if ($daysUntilNext <= 0 && $daysUntilNext >= -7) {
                    $this->cycleStatus = 'haid';
                    $this->currentCycleDay = abs($daysUntilNext) + 1;
                } elseif ($daysUntilNext > 0 && $daysUntilNext <= 3) {
                    $this->cycleStatus = 'prahaid';
                    $this->currentCycleDay = $avgCycleLength - $daysUntilNext;
                } else {
                    $this->cycleStatus = 'nonhaid';
                    $this->currentCycleDay = max(1, $avgCycleLength - $daysUntilNext);
                }
            } else {
                $this->cycleStatus = 'nonhaid';
            }
        } else {
            // Cycle is still ongoing (no end_date)
            $daysSinceStart = $today->diffInDays($latestStartDate);
            $this->currentCycleDay = $daysSinceStart + 1;
            
            // Typically period lasts 3-7 days
            if ($daysSinceStart < 7) {
                $this->cycleStatus = 'haid';
            } else {
                $this->cycleStatus = 'nonhaid';
            }
            
            // If period should have started but hasn't ended yet, update prediction
            // This handles the case where user hasn't marked period as ended
            if ($daysUntilNext !== null && $daysUntilNext <= 0) {
                // Period predicted to start, but user hasn't ended current cycle
                // Prediction might need to be recalculated, but we'll keep it for now
            }
        }
    }

    public function render()
    {
        return view('livewire.home-screen')
            ->layout('layouts.app');
    }
}
