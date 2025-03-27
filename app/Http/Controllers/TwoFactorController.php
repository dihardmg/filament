<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends Controller
{
    // Tampilkan form OTP
    public function showVerifyForm()
    {
        return view('2fa.verify');
    }

    // Proses verifikasi OTP
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required',
        ]);

        $google2fa = new Google2FA();
        $user = Auth::user();

        if ($google2fa->verifyKey($user->google2fa_secret, $request->otp)) {
            session(['2fa_passed' => true]);
            return redirect()->intended('/admin');
        }

        return back()->withErrors(['otp' => 'Kode OTP salah']);
    }
}
