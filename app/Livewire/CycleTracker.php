<?php

namespace App\Livewire;

use App\Models\Cycle;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CycleTracker extends Component
{
    public $startDate;
    public $endDate = null;
    public $currentCycle = null;
    public $cycleDay = null;
    public $nextPeriodPrediction = null;
    public $averageCycleLength = 28;
    public $isMenstruating = false;
    public $cycles = [];

    public function mount()
    {
        $this->loadCycles();
        $this->calculateCycleInfo();
    }

    public function loadCycles()
    {
        $user = Auth::user();
        $this->cycles = Cycle::where('user_id', $user->id)
            ->orderBy('start_date', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
        
        // Get current active cycle (without end_date)
        $this->currentCycle = Cycle::where('user_id', $user->id)
            ->whereNull('end_date')
            ->orderBy('start_date', 'desc')
            ->first();
        
        if ($this->currentCycle) {
            $this->startDate = $this->currentCycle->start_date->format('Y-m-d');
            $this->endDate = $this->currentCycle->end_date?->format('Y-m-d');
        }
    }

    public function calculateCycleInfo()
    {
        $user = Auth::user();
        $today = Carbon::today();
        
        // Calculate average cycle length using shared method
        $this->averageCycleLength = Cycle::calculateAverageCycleLength($user->id);
        
        // Predict next period using shared method for consistency
        $predictedDate = Cycle::predictNextPeriod($user->id);
        $this->nextPeriodPrediction = $predictedDate ? $predictedDate->format('Y-m-d') : null;
        
        // Get latest cycle
        $latestCycle = Cycle::where('user_id', $user->id)
            ->orderBy('start_date', 'desc')
            ->first();
        
        if ($latestCycle) {
            $latestStartDate = Carbon::parse($latestCycle->start_date);
            
            if ($latestCycle->end_date) {
                // Cycle has ended
                $endDate = Carbon::parse($latestCycle->end_date);
                $daysSinceEnd = $today->diffInDays($endDate);
                
                // Calculate current day in cycle (since last period ended)
                if ($daysSinceEnd >= 0 && $daysSinceEnd < $this->averageCycleLength) {
                    $this->cycleDay = $daysSinceEnd + 1;
                }
            } else {
                // Cycle is ongoing (no end_date)
                $daysSinceStart = $today->diffInDays($latestStartDate);
                $this->cycleDay = $daysSinceStart + 1;
                $this->isMenstruating = $daysSinceStart < 7; // Typically 3-7 days
            }
        }
    }

    public function startCycle()
    {
        $this->validate([
            'startDate' => 'required|date',
        ]);

        $user = Auth::user();
        
        // End any active cycle
        Cycle::where('user_id', $user->id)
            ->whereNull('end_date')
            ->update(['end_date' => Carbon::parse($this->startDate)->subDay()]);

        // Create new cycle
        Cycle::create([
            'user_id' => $user->id,
            'start_date' => $this->startDate,
            'end_date' => null,
        ]);

        $this->loadCycles();
        $this->calculateCycleInfo();
        
        session()->flash('message', 'Siklus menstruasi baru dimulai! 💕');
    }

    public function endCycle()
    {
        if (!$this->currentCycle) {
            return;
        }

        // Get start date from current cycle
        $cycleStartDate = Carbon::parse($this->currentCycle->start_date);
        $endDateInput = Carbon::parse($this->endDate);

        // Validate that endDate is provided
        $this->validate([
            'endDate' => 'required|date',
        ]);

        // Custom validation: endDate must be after or equal to startDate
        if ($endDateInput->lt($cycleStartDate)) {
            $this->addError('endDate', 'Tanggal selesai haid tidak boleh sebelum tanggal mulai haid. Tanggal mulai haid: ' . $cycleStartDate->locale('id')->isoFormat('D MMMM YYYY'));
            return;
        }

        // Validate: endDate should not be more than 30 days before startDate (back date protection)
        // This handles cases where user might accidentally select a date in the past
        $daysDifference = $cycleStartDate->diffInDays($endDateInput);
        
        // Normal period is typically 3-7 days, but we allow up to 15 days for safety
        // If endDate is more than 15 days after startDate, it's likely an error
        if ($daysDifference > 15) {
            $this->addError('endDate', 'Tanggal selesai haid terlalu jauh dari tanggal mulai. Periode haid biasanya 3-7 hari. Jika lebih dari 15 hari, mohon periksa kembali tanggal yang dimasukkan.');
            return;
        }

        // Additional validation: endDate should not be too far in the future (more than 15 days from start)
        // This prevents accidental future dates
        $today = Carbon::today();
        if ($endDateInput->gt($today->copy()->addDays(1))) {
            $this->addError('endDate', 'Tanggal selesai haid tidak boleh lebih dari 1 hari di masa depan. Silakan pilih tanggal yang valid.');
            return;
        }

        // All validations passed, update the cycle
        $this->currentCycle->update([
            'end_date' => $this->endDate,
        ]);

        $this->loadCycles();
        $this->calculateCycleInfo();
        
        session()->flash('message', 'Siklus menstruasi selesai dicatat! ✨');
    }

    public function resetCycles()
    {
        $user = Auth::user();
        
        // Delete all cycles for the user
        Cycle::where('user_id', $user->id)->delete();
        
        // Reset component properties
        $this->startDate = null;
        $this->endDate = null;
        $this->currentCycle = null;
        $this->cycleDay = null;
        $this->nextPeriodPrediction = null;
        $this->averageCycleLength = 28;
        $this->isMenstruating = false;
        $this->cycles = [];
        
        // Reload data (will be empty now)
        $this->loadCycles();
        $this->calculateCycleInfo();
        
        session()->flash('message', 'Riwayat siklus telah dihapus. Mulai tracking siklus baru sekarang! 🔄');
    }

    public function render()
    {
        return view('livewire.cycle-tracker')
            ->layout('layouts.app');
    }
}
