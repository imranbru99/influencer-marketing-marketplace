<?php

namespace App\Http\Middleware;

use Closure;
use Cache;
use App\Models\Influencer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LastInfluencerActivity
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
        if(Auth::guard('influencer')->check()) {
            $expiresAt = now()->addMinutes(1);
            Cache::put('last_seen' . Auth::guard('influencer')->user()->id, true, $expiresAt);
            Influencer::where('id', Auth::guard('influencer')->user()->id)->update(['last_seen' => now()]);
        }
        return $next($request);
    }
}
