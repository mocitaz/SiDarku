<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\TTDLog;
use App\Models\Cycle;
use App\Models\TtdReminderLog;
use App\Mail\TTDReminderMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendTtdReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ttd:remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send TTD reminder notifications to users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Sending TTD reminders...');
        
        // Set timezone to Asia/Jakarta (WIB)
        Carbon::setLocale('id');
        $today = Carbon::today('Asia/Jakarta');
        
        $users = User::where('role', 'user')->get();
        $reminderCount = 0;
        $skippedCount = 0;
        $disabledCount = 0;

        foreach ($users as $user) {
            // Check if user has disabled email reminders
            // Default true jika null (untuk kompatibilitas dengan user lama)
            $isEnabled = $user->email_ttd_reminder_enabled !== null 
                ? (bool) $user->email_ttd_reminder_enabled 
                : true;
            
            if (!$isEnabled) {
                $this->logReminder($user, 'disabled', 'User has disabled email reminders', false);
                $disabledCount++;
                $this->line("  → Skipped {$user->name}: Email reminders disabled");
                continue;
            }
            
            // Jika null, set ke true di database (update untuk user lama)
            if ($user->email_ttd_reminder_enabled === null) {
                $user->update(['email_ttd_reminder_enabled' => true]);
            }

            // Check if user already checked in today
            $todayLog = TTDLog::where('user_id', $user->id)
                ->whereDate('log_date', $today)
                ->where('is_consumed', true)
                ->first();

            if ($todayLog) {
                $this->logReminder($user, 'skipped', 'User already checked in today', false);
                $skippedCount++;
                $this->line("  → Skipped {$user->name}: Already checked in today");
                continue;
            }

            // Check if user is menstruating (intensive reminder - send daily)
            $isMenstruating = $this->isUserMenstruating($user, $today);
            
            // If menstruating, send reminder daily
            // If not menstruating, send reminder weekly (7 days since last consumption)
            if ($isMenstruating || $this->isWeeklyReminderTime($user, $today)) {
                $this->sendReminder($user, $isMenstruating);
                $this->logReminder($user, 'sent', null, $isMenstruating);
                $reminderCount++;
                $this->line("  → Reminder sent to {$user->name} ({$user->email})" . ($isMenstruating ? ' [Intensive]' : ''));
            } else {
                $lastLog = TTDLog::where('user_id', $user->id)
                    ->where('is_consumed', true)
                    ->orderBy('log_date', 'desc')
                    ->first();
                
                $reason = 'Not time for reminder yet';
                if ($lastLog) {
                    $daysSince = Carbon::parse($lastLog->log_date)->diffInDays($today);
                    $reason = "Last consumption {$daysSince} days ago (need 7 days)";
                } else {
                    $reason = 'No previous consumption';
                }
                
                $this->logReminder($user, 'skipped', $reason, false);
                $skippedCount++;
                $this->line("  → Skipped {$user->name}: {$reason}");
            }
        }

        $this->info("Sent {$reminderCount} reminders.");
        $this->info("Skipped {$skippedCount} reminders.");
        $this->info("Disabled {$disabledCount} reminders.");
        Log::info("TTD Reminder: Sent {$reminderCount}, Skipped {$skippedCount}, Disabled {$disabledCount} reminders on " . $today->toDateString());
        
        return Command::SUCCESS;
    }

    /**
     * Check if it's time for weekly reminder (7 days since last consumption)
     */
    protected function isWeeklyReminderTime(User $user, Carbon $today): bool
    {
        $lastLog = TTDLog::where('user_id', $user->id)
            ->where('is_consumed', true)
            ->orderBy('log_date', 'desc')
            ->first();

        if (!$lastLog) {
            // No previous log, send reminder
            return true;
        }

        $daysSinceLastConsumption = Carbon::parse($lastLog->log_date)->diffInDays($today);
        
        // Send reminder if 7 days have passed (weekly consumption)
        return $daysSinceLastConsumption >= 7;
    }

    /**
     * Check if user is currently menstruating
     */
    protected function isUserMenstruating(User $user, Carbon $today): bool
    {
        $activeCycle = Cycle::where('user_id', $user->id)
            ->whereNull('end_date')
            ->orderBy('start_date', 'desc')
            ->first();

        if (!$activeCycle) {
            return false;
        }

        $startDate = Carbon::parse($activeCycle->start_date);
        $daysSinceStart = $startDate->diffInDays($today);

        // Typically menstruation lasts 3-7 days
        return $daysSinceStart < 7;
    }

    /**
     * Send reminder notification via email
     */
    protected function sendReminder(User $user, bool $isIntensive = false)
    {
        try {
            Mail::to($user->email)->send(new TTDReminderMail($user, $isIntensive));
            Log::info("TTD Reminder email sent to {$user->email}");
        } catch (\Exception $e) {
            Log::error("Failed to send TTD reminder to {$user->email}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Log reminder activity
     */
    protected function logReminder(User $user, string $status, ?string $reason = null, bool $isIntensive = false): void
    {
        TtdReminderLog::create([
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_name' => $user->name,
            'is_intensive' => $isIntensive,
            'status' => $status,
            'reason' => $reason,
            'reminder_date' => Carbon::today('Asia/Jakarta'),
        ]);
    }
}
