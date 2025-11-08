<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TTDReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $isMenstruating;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, bool $isMenstruating = false)
    {
        $this->user = $user;
        $this->isMenstruating = $isMenstruating;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = $this->isMenstruating 
            ? '💕 Reminder: Jangan Lupa Minum TTD Hari Ini!'
            : '✨ Reminder: Waktunya Minum Tablet Tambah Darah';

        return $this->subject($subject)
                    ->view('emails.ttd-reminder')
                    ->with([
                        'user' => $this->user,
                        'isMenstruating' => $this->isMenstruating,
                    ]);
    }
}

