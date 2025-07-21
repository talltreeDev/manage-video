<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Video Uploader</title>

    <!-- Fonts & Tailwind -->
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-900 antialiased">
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="w-full max-w-2xl text-center">
            <h1 class="text-2xl font-bold mb-4">Video Upload + Convert</h1>

            @auth
                <livewire:video-upload />
            @else
                <p class="mb-4 text-lg">Please log in to upload videos.</p>
                <a href="{{ route('login') }}" class="text-blue-500 underline mr-4">Login</a>
                <a href="{{ route('register') }}" class="text-blue-500 underline">Register</a>
            @endauth
        </div>
    </div>
</body>
</html>
