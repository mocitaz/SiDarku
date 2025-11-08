<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TTDLog extends Model
{
    protected $table = 'ttd_logs';
    
    protected $fillable = [
        'user_id',
        'log_date',
        'is_consumed',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'log_date' => 'date',
            'is_consumed' => 'boolean',
        ];
    }

    /**
     * Get the user that owns the TTD log.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
