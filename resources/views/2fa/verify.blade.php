<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Two-Factor Authentication</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }
    </style>
</head>
<body class="bg-white flex items-center justify-center min-h-screen px-4">
    <div class="w-full max-w-md p-8 border border-gray-200 shadow-lg rounded-xl space-y-6">
        <!-- Logo -->
        <div class="flex justify-center mb-4">
            <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg" class="h-8" alt="Microsoft Logo">
        </div>

        <!-- Heading -->
        <div class="text-center">
            <h1 class="text-2xl font-semibold text-gray-800">Verifikasi Identitas Anda</h1>
            <p class="text-sm text-gray-600 mt-1">Masukkan kode dari aplikasi Authenticator Anda</p>
        </div>

        <!-- Error Message -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-800 text-sm rounded px-4 py-2">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('2fa.verify') }}" class="space-y-4">
            @csrf
            <div>
                <label for="otp" class="block text-sm text-gray-700 mb-1">Kode Verifikasi</label>
                <input
                    type="text"
                    name="otp"
                    id="otp"
                    maxlength="6"
                    inputmode="numeric"
                    pattern="[0-9]*"
                    autofocus
                    required
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="123 456"
                />
            </div>

            <button
                type="submit"
                class="w-full bg-blue-600 text-white text-sm font-semibold py-2 rounded-md hover:bg-blue-700 transition">
                Verifikasi
            </button>
        </form>

        <!-- Help text -->
        <div class="text-center text-sm text-gray-500 mt-4">
            Mengalami masalah? Hubungi administrator Anda.
        </div>
    </div>
</body>
</html>
