<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TtdReminderLog extends Model
{
    protected $fillable = [
        'user_id',
        'user_email',
        'user_name',
        'is_intensive',
        'status',
        'reason',
        'reminder_date',
    ];

    protected function casts(): array
    {
        return [
            'is_intensive' => 'boolean',
            'reminder_date' => 'date',
        ];
    }

    /**
     * Get the user that owns the reminder log.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
