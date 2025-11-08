<?php

namespace App\Livewire;

use App\Models\TTDLog;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TtdCheckin extends Component
{
    public $logDate;
    public $isConsumed = false;
    public $notes = '';
    public $alreadyCheckedIn = false;
    public $successMessage = '';

    public function mount()
    {
        $this->logDate = Carbon::today()->format('Y-m-d');
        $this->checkExistingLog();
    }

    public function checkExistingLog()
    {
        $user = Auth::user();
        $existingLog = TTDLog::where('user_id', $user->id)
            ->whereDate('log_date', $this->logDate)
            ->first();
        
        if ($existingLog) {
            $this->alreadyCheckedIn = true;
            $this->isConsumed = $existingLog->is_consumed;
            $this->notes = $existingLog->notes ?? '';
        }
    }

    public function updatedLogDate()
    {
        $this->alreadyCheckedIn = false;
        $this->checkExistingLog();
    }

    public function saveCheckin()
    {
        $user = Auth::user();
        
        // Prevent duplicate check-in for the same date
        $existingLog = TTDLog::where('user_id', $user->id)
            ->whereDate('log_date', $this->logDate)
            ->first();
        
        if ($existingLog && !$this->alreadyCheckedIn) {
            $this->addError('logDate', 'Anda sudah melakukan check-in untuk tanggal ini.');
            return;
        }

        TTDLog::updateOrCreate(
            [
                'user_id' => $user->id,
                'log_date' => $this->logDate,
            ],
            [
                'is_consumed' => $this->isConsumed,
                'notes' => $this->notes,
            ]
        );

        $this->successMessage = $this->isConsumed 
            ? 'Check-in berhasil! Terima kasih sudah minum TTD hari ini ✨'
            : 'Check-in disimpan. Jangan lupa minum TTD ya! 💕';
        
        $this->alreadyCheckedIn = true;
        
        // Dispatch event to refresh home screen and progress chart
        $this->dispatch('checkin-saved');
        
        // Redirect to home after 2 seconds to show updated cycle status
        $this->dispatch('redirect-home');
    }

    public function render()
    {
        return view('livewire.ttd-checkin')
            ->layout('layouts.app');
    }
}
