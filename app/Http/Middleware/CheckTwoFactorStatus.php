<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckTwoFactorStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return $next($request);
        }

        // Sudah aktif MFA, tapi belum verifikasi OTP
        if ($user->google2fa_secret && !session()->get('2fa_passed') && !$request->is('2fa/verify')) {
            return redirect('/2fa/verify');
        }

        // Belum aktif MFA
        if (!$user->google2fa_secret && !$request->is('2fa/setup')) {
            return redirect('/2fa/setup');
        }

        return $next($request);
    }
}
