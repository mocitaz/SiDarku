<?php

namespace App\Console\Commands;

use App\Mail\TTDReminderMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestTTDReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ttd:test-email {email} {--menstruating : Send as menstruating reminder}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test TTD reminder email by sending to a specific email address';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $isMenstruating = $this->option('menstruating');

        $this->info("Sending test TTD reminder email to: {$email}");
        $this->info("Menstruating mode: " . ($isMenstruating ? 'Yes' : 'No'));

        // Create a dummy user object for testing
        $dummyUser = new User();
        $dummyUser->name = 'Test User';
        $dummyUser->email = $email;

        try {
            Mail::to($email)->send(new TTDReminderMail($dummyUser, $isMenstruating));
            $this->info("✅ Email sent successfully to {$email}!");
            $this->line("Check your inbox (and spam folder) for the test email.");
        } catch (\Exception $e) {
            $this->error("❌ Failed to send email: " . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}

