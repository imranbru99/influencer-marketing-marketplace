<?php

namespace App\Http\Middleware;

use Closure;
use Cache;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LastUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()) {
            $expiresAt = now()->addMinutes(1);
            Cache::put('user_last_seen' . Auth::user()->id, true, $expiresAt);
            User::where('id', Auth::user()->id)->update(['user_last_seen' => now()]);
        }
        return $next($request);
    }
}
