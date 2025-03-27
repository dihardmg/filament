@component('mail::message')
# Reset 2FA

Hai {{ $user->name }},

Autentikasi dua faktor (2FA) pada akun Anda telah direset.

@component('mail::button', ['url' => $actionUrl])
Setup Ulang 2FA
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
