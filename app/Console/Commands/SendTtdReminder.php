<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\TTDLog;
use App\Models\Cycle;
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

        foreach ($users as $user) {
            // Check if user already checked in today
            $todayLog = TTDLog::where('user_id', $user->id)
                ->whereDate('log_date', $today)
                ->where('is_consumed', true)
                ->first();

            if ($todayLog) {
                continue; // User already consumed TTD today
            }

            // Check if user is menstruating (intensive reminder - send daily)
            $isMenstruating = $this->isUserMenstruating($user, $today);
            
            // If menstruating, send reminder daily
            // If not menstruating, send reminder weekly (7 days since last consumption)
            if ($isMenstruating || $this->isWeeklyReminderTime($user, $today)) {
                $this->sendReminder($user, $isMenstruating);
                $reminderCount++;
                $this->line("  → Reminder sent to {$user->name} ({$user->email})");
            } else {
                $lastLog = TTDLog::where('user_id', $user->id)
                    ->where('is_consumed', true)
                    ->orderBy('log_date', 'desc')
                    ->first();
                
                if ($lastLog) {
                    $daysSince = Carbon::parse($lastLog->log_date)->diffInDays($today);
                    $this->line("  → Skipped {$user->name}: Last consumption {$daysSince} days ago (need 7 days)");
                } else {
                    $this->line("  → Skipped {$user->name}: No previous consumption");
                }
            }
        }

        $this->info("Sent {$reminderCount} reminders.");
        Log::info("TTD Reminder: Sent {$reminderCount} reminders on " . $today->toDateString());
        
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
        }
    }
}
