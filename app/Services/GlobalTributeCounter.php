<?php

namespace App\Services;

use App\Models\Tribute;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class GlobalTributeCounter
{
    /**
     * Get the count of all pending tributes across the entire site.
     * The result is cached for 1 minute to improve performance.
     *
     * @return int
     */
    public function count(): int
    {
        // We use a cache to avoid hitting the database on every single page load.
        // The cache will automatically clear when a new tribute is made or moderated,
        // but this provides a good performance boost.
        return Cache::remember('all_pending_tributes_count', 60, function () {
            return Tribute::where('status', 'pending')->count();
        });
    }

    /**
     * Get the count of pending tributes for the currently authenticated user's memorials.
     *
     * @return int
     */
    public function personalCount(): int
    {
        if (!Auth::check()) {
            return 0;
        }

        $user = Auth::user();
        $cacheKey = 'user_' . $user->id . '_pending_tributes_count';

        return Cache::remember($cacheKey, 60, function () use ($user) {
            $memorialIds = $user->memorials()->pluck('id');
            return Tribute::whereIn('memorial_id', $memorialIds)
                ->where('status', 'pending')
                ->count();
        });
    }
}