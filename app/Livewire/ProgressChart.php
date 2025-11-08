<?php

namespace App\Livewire;

use App\Models\TTDLog;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProgressChart extends Component
{
    public $complianceRate = 0;
    public $currentStreak = 0;
    public $longestStreak = 0;
    public $monthlyData = [];
    public $currentMonth;
    public $calendarData = [];

    public function mount()
    {
        $this->currentMonth = Carbon::now()->format('Y-m');
        $this->loadProgressData();
        $this->loadCalendarData();
    }

    public function loadProgressData()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        
        // Get logs from this month
        $logs = TTDLog::where('user_id', $user->id)
            ->whereBetween('log_date', [$startOfMonth, $today])
            ->where('is_consumed', true)
            ->orderBy('log_date', 'asc')
            ->get();
        
        // Calculate compliance rate (should be weekly, so 4 times per month minimum)
        $daysInMonth = Carbon::now()->daysInMonth;
        $expectedChecks = ceil($daysInMonth / 7); // At least once per week
        $actualChecks = $logs->count();
        $this->complianceRate = $expectedChecks > 0 
            ? min(100, round(($actualChecks / $expectedChecks) * 100))
            : 0;
        
        // Calculate streaks
        $this->calculateStreaks($user);
        
        // Monthly data for chart
        $this->monthlyData = $this->getMonthlyData($user);
    }

    protected function calculateStreaks($user)
    {
        // Calculate current streak (consecutive days from today backwards)
        $currentStreak = 0;
        $currentDate = Carbon::today();
        
        while (true) {
            $log = TTDLog::where('user_id', $user->id)
                ->whereDate('log_date', $currentDate)
                ->where('is_consumed', true)
                ->first();
            
            if (!$log) {
                break;
            }
            
            $currentStreak++;
            $currentDate->subDay();
        }
        
        $this->currentStreak = $currentStreak;
        
        // Calculate longest streak
        $logs = TTDLog::where('user_id', $user->id)
            ->where('is_consumed', true)
            ->orderBy('log_date', 'asc')
            ->get();

        if ($logs->isEmpty()) {
            $this->longestStreak = 0;
            return;
        }

        $maxStreak = 0;
        $tempStreak = 1;
        $previousDate = null;

        foreach ($logs as $log) {
            $currentDate = Carbon::parse($log->log_date);
            
            if ($previousDate) {
                $dayDiff = $previousDate->diffInDays($currentDate);
                
                if ($dayDiff == 1) {
                    $tempStreak++;
                } else {
                    $maxStreak = max($maxStreak, $tempStreak);
                    $tempStreak = 1;
                }
            }
            
            $previousDate = $currentDate;
        }
        
        $this->longestStreak = max($maxStreak, $tempStreak);
    }

    protected function getMonthlyData($user)
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        
        $logs = TTDLog::where('user_id', $user->id)
            ->whereBetween('log_date', [$startDate, $endDate])
            ->where('is_consumed', true)
            ->get();
        
        // Group by week
        $weeks = [];
        $currentWeek = $startDate->copy()->startOfWeek(Carbon::MONDAY);
        $weekNumber = 1;
        
        while ($currentWeek <= $endDate) {
            $weekEnd = $currentWeek->copy()->endOfWeek(Carbon::MONDAY);
            
            $weekLogs = $logs->filter(function($log) use ($currentWeek, $weekEnd) {
                $logDate = Carbon::parse($log->log_date);
                return $logDate->between($currentWeek, $weekEnd);
            });
            
            $weeks[] = [
                'week' => 'Minggu ' . $weekNumber,
                'count' => $weekLogs->count(),
            ];
            
            $currentWeek->addWeek();
            $weekNumber++;
            
            // Prevent infinite loop
            if ($weekNumber > 6) break;
        }
        
        // Ensure at least 4 weeks of data
        if (count($weeks) < 4) {
            for ($i = count($weeks); $i < 4; $i++) {
                $weeks[] = [
                    'week' => 'Minggu ' . ($i + 1),
                    'count' => 0,
                ];
            }
        }
        
        return $weeks;
    }

    public function loadCalendarData()
    {
        $user = Auth::user();
        $startOfMonth = Carbon::parse($this->currentMonth)->startOfMonth();
        $endOfMonth = Carbon::parse($this->currentMonth)->endOfMonth();
        
        $logs = TTDLog::where('user_id', $user->id)
            ->whereBetween('log_date', [$startOfMonth, $endOfMonth])
            ->where('is_consumed', true)
            ->pluck('log_date')
            ->map(function($date) {
                return Carbon::parse($date)->format('Y-m-d');
            })
            ->toArray();
        
        $this->calendarData = $logs;
    }

    public function changeMonth($direction)
    {
        $date = Carbon::parse($this->currentMonth);
        if ($direction === 'next') {
            $date->addMonth();
        } else {
            $date->subMonth();
        }
        $this->currentMonth = $date->format('Y-m');
        $this->loadCalendarData();
    }

    public function render()
    {
        return view('livewire.progress-chart')
            ->layout('layouts.app');
    }
}
