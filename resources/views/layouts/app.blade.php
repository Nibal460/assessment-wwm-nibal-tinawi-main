<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Alpine cloak style -->
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <!-- Tailwind CSS & JS einbinden via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Optional: Fonts oder Icons hier einbinden -->
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{-- So funktioniert @yield für normale Blade-Dateien --}}
            @yield('content')

            {{-- Für Blade-Komponenten, die $slot nutzen, z.B. <x-app-layout> --}}
            {{ $slot ?? '' }}
        </main>
    </div>
    <!-- Alpine.js direkt laden (ohne npm) -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</body>
</html>
