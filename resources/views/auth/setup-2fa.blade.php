<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Aktivasi 2FA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white min-h-screen flex items-center justify-center px-4">

    <div class="bg-gray-800 p-6 rounded-2xl shadow-lg max-w-md w-full space-y-6 fade-in">
        <div class="text-center space-y-2">
            <h2 class="text-3xl font-bold tracking-tight">Aktivasi Autentikasi 2FA</h2>
            <p class="text-sm text-gray-400">Scan QR dan masukkan kode OTP dari aplikasi Authenticator (Google/Microsoft).</p>
        </div>

        @if ($qrCode)
            <div class="flex justify-center">
                <div class="bg-white p-3 rounded-lg shadow">
                    {!! $qrCode !!}
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('2fa.setup.verify') }}" class="space-y-4">
            @csrf
            <div>
                <label for="otp" class="block text-sm font-medium text-gray-300 mb-1">Kode OTP</label>
                <input
                    type="text"
                    name="otp"
                    id="otp"
                    inputmode="numeric"
                    maxlength="6"
                    required
                    autofocus
                    placeholder="123456"
                    class="w-full px-4 py-2 rounded-lg border border-gray-600 bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-amber-500 transition"
                >
            </div>

            <button type="submit"
                class="w-full py-2 px-4 bg-amber-500 hover:bg-amber-600 rounded-lg font-semibold text-gray-900 transition shadow hover:shadow-md">
                Verifikasi & Masuk
            </button>
        </form>

        @if ($errors->any())
            <div class="text-center text-sm text-red-400">
                {{ $errors->first() }}
            </div>
        @endif
    </div>

</body>
</html>
