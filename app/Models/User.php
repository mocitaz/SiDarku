<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'date_of_birth',
        'phone',
        'occupation',
        'marital_status',
        'role',
        'email_ttd_reminder_enabled',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'email_ttd_reminder_enabled' => 'boolean',
        ];
    }

    /**
     * Get the TTD logs for the user.
     */
    public function ttdLogs()
    {
        return $this->hasMany(TTDLog::class);
    }

    /**
     * Get the cycles for the user.
     */
    public function cycles()
    {
        return $this->hasMany(Cycle::class);
    }

    /**
     * Get the TTD reminder logs for the user.
     */
    public function ttdReminderLogs()
    {
        return $this->hasMany(TtdReminderLog::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
