<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class KycMiddleware
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
        $user = authInfluencer();
        if ($request->is('api/*') && ($user->kv == 0 || $user->kv == 2)) {
            $notify[] = 'You are unable to withdraw due to KYC verification';
            return response()->json([
                'remark' => 'kyc_verification',
                'status' => 'error',
                'message' => ['error' => $notify],
            ]);
        }
        if ($user->kv == 0) {
            $notify[] = ['error', 'You are not KYC verified. For being KYC verified, please provide these information'];
            return to_route('influencer.kyc.form')->withNotify($notify);
        }
        if ($user->kv == 2) {
            $notify[] = ['warning', 'Your documents for KYC verification is under review. Please wait for admin approval'];
            return to_route('influencer.home')->withNotify($notify);
        }
        return $next($request);
    }
}
