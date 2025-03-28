<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorVerifyController extends Controller
{
    public function form()
    {
        return view('auth.verify-2fa');
    }

    public function check(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $user = Auth::user();
        $google2fa = new Google2FA();

        if ($google2fa->verifyKey($user->google2fa_secret, $request->otp)) {
            Session::put('2fa_passed', true);
            return Redirect::to('/admin')->with('success', 'OTP valid. Anda berhasil login!');
        }

        return Redirect::back()->withErrors(['otp' => 'Kode OTP salah.']);
    }
}
