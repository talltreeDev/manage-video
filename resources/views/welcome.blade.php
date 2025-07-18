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

    @livewireStyles
</head>
<body class="bg-gray-100 text-gray-900 antialiased">
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="w-full max-w-2xl">
            <h1 class="text-2xl font-bold mb-4 text-center">Video Upload + Convert</h1>
            <livewire:video-upload />
        </div>
    </div>

    @livewireScripts
</body>
</html>
