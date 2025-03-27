<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;

class SetupTwoFactor extends Page
{
    protected static string $view = 'filament.pages.setup-two-factor';

    public string $qrCode = '';

    public function mount(): void
    {
        $user = Auth::user();

        if (!$user->google2fa_secret) {
            $google2fa = new Google2FA();
            $secret = $google2fa->generateSecretKey();
            $user->google2fa_secret = $secret;
            $user->save();

            $qrCodeUrl = $google2fa->getQRCodeUrl(
                'Laravel 2FA Demo',
                $user->email,
                $secret
            );

            $writer = new Writer(
                new ImageRenderer(
                    new RendererStyle(200),
                    new SvgImageBackEnd()
                )
            );

            $this->qrCode = $writer->writeString($qrCodeUrl);
        }
    }
}
