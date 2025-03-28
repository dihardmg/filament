<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>2FA Authentication</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeInUp 0.6s ease-out both;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md p-6 bg-white rounded-2xl shadow-lg space-y-6 fade-in">

        <!-- Logo -->
        <div class="flex justify-center">
            <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg" class="h-6 md:h-8"
                alt="Company Logo">
        </div>

        <!-- Heading -->
        <div class="text-center space-y-1">
            <h1 class="text-2xl font-semibold text-gray-800">Verifikasi 2FA</h1>
            <p class="text-sm text-gray-500">Masukkan kode dari aplikasi Authenticator Anda</p>
        </div>

        <!-- Error -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-300 text-red-600 text-sm rounded-md px-4 py-2">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- OTP Form -->
        <form method="POST" action="{{ route('2fa.verify') }}" class="space-y-4">
            @csrf
            <div>
                <label for="otp" class="block text-sm text-gray-700 mb-1">Kode Verifikasi</label>
                <input type="text" name="otp" id="otp" maxlength="6" inputmode="numeric" pattern="[0-9]*"
                    oninput="validateOtp(this)" autofocus required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="123456" />
            </div>
            <!-- Script -->
            <script>
                function validateOtp(input) {
                    // Hapus semua non-digit
                    input.value = input.value.replace(/\D/g, '');

                    // Maksimal 6 digit
                    if (input.value.length > 6) {
                        input.value = input.value.slice(0, 6);
                    }
                }
            </script>

            <button type="submit"
                class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-md transition">
                Verifikasi
            </button>
        </form>

        <!-- Help Text -->
        <p class="text-center text-xs text-gray-400">
            Tidak menerima kode? Hubungi admin atau coba lagi.
        </p>
    </div>
</body>

</html>
