<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Cycle extends Model
{
    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    /**
     * Get the user that owns the cycle.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate average cycle length for a user based on consecutive start dates.
     * Cycle length is calculated as days from start_date of one cycle to start_date of next cycle.
     * 
     * @param int $userId
     * @param int $maxCycles Maximum number of recent cycles to consider (default: 6)
     * @return int Average cycle length in days (default: 28 if insufficient data)
     */
    public static function calculateAverageCycleLength(int $userId, int $maxCycles = 6): int
    {
        $allCycles = static::where('user_id', $userId)
            ->orderBy('start_date', 'asc')
            ->get();

        if ($allCycles->count() < 2) {
            return 28; // Default cycle length
        }

        // Get last N cycles for average (more recent cycles are more relevant)
        $recentCycles = $allCycles->take(-min($maxCycles, $allCycles->count()));
        $totalDays = 0;
        $count = 0;

        // Calculate cycle length as days from start_date to next start_date
        for ($i = 0; $i < $recentCycles->count() - 1; $i++) {
            $currentCycleStart = Carbon::parse($recentCycles[$i]->start_date);
            $nextCycleStart = Carbon::parse($recentCycles[$i + 1]->start_date);
            $cycleLength = $currentCycleStart->diffInDays($nextCycleStart);

            // Only count valid cycle lengths (between 21-45 days is reasonable)
            if ($cycleLength >= 21 && $cycleLength <= 45) {
                $totalDays += $cycleLength;
                $count++;
            }
        }

        if ($count > 0) {
            return (int) round($totalDays / $count);
        }

        return 28; // Default if no valid cycles found
    }

    /**
     * Predict next period start date for a user.
     * 
     * @param int $userId
     * @return \Carbon\Carbon|null Predicted next period start date, or null if no cycles exist
     */
    public static function predictNextPeriod(int $userId): ?Carbon
    {
        $latestCycle = static::where('user_id', $userId)
            ->orderBy('start_date', 'desc')
            ->first();

        if (!$latestCycle) {
            return null;
        }

        $latestStartDate = Carbon::parse($latestCycle->start_date);
        $avgCycleLength = static::calculateAverageCycleLength($userId);

        return $latestStartDate->copy()->addDays($avgCycleLength);
    }
}
