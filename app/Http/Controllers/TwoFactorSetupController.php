<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;

class TwoFactorSetupController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if (!$user->google2fa_secret) {
            $google2fa = new Google2FA();
            $secret = $google2fa->generateSecretKey();

            $user->google2fa_secret = $secret;
            $user->save();

            $qrCodeUrl = $google2fa->getQRCodeUrl(
                config('app.name'),
                $user->email,
                $secret
            );

            $writer = new Writer(
                new ImageRenderer(
                    new RendererStyle(200),
                    new SvgImageBackEnd()
                )
            );

            $qrCode = $writer->writeString($qrCodeUrl);
        } else {
            $qrCode = null;
        }

        return view('auth.setup-2fa', compact('qrCode'));
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $user = Auth::user();
        $google2fa = new Google2FA();

        if ($google2fa->verifyKey($user->google2fa_secret, $request->otp)) {
            Session::put('2fa_passed', true);
            return Redirect::to('/admin')->with('success', '2FA berhasil diaktifkan!');
        }

        return Redirect::back()->withErrors(['otp' => 'Kode OTP salah, coba lagi.']);
    }
}
