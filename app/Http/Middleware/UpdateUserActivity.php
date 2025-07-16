<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UpdateUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $now = now();
            
            // Only update the database every minute to reduce load
            $lastUpdate = Cache::get('user_activity_' . $user->id);
            
            if (!$lastUpdate || $now->diffInMinutes($lastUpdate) >= 1) {
                $user->last_activity = $now;
                $user->is_online = true;
                $user->save();
                
                // Cache the update time
                Cache::put('user_activity_' . $user->id, $now, now()->addMinutes(5));
            }
            
            // Update the cache with the latest activity
            Cache::put('user_online_' . $user->id, true, now()->addMinutes(5));
        }

        return $next($request);
    }
}
