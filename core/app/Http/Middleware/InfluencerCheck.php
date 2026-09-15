<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InfluencerCheck
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
        if (Auth::guard('influencer')->check()) {
            $influencer = authInfluencer();
            if ($influencer->status  && $influencer->ev  && $influencer->sv  && $influencer->tv) {
                return $next($request);
            } else {
                if ($request->is('api/*')) {
                    $notify[] = 'You need to verify your account first.';
                    return response()->json([
                        'remark' => 'unverified',
                        'status' => 'error',
                        'message' => ['error' => $notify],
                        'data' => [
                            'is_ban' => $influencer->status,
                            'email_verified' => $influencer->ev,
                            'mobile_verified' => $influencer->sv,
                            'twofa_verified' => $influencer->tv,
                        ],
                    ]);
                } else {
                    return to_route('influencer.authorization');
                }
            }
        }
        abort(403);
    }
}
