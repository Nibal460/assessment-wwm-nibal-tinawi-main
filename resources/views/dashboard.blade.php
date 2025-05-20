<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-indigo-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Begrüßung -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-2">🎉 Willkommen zurück, {{ Auth::user()->name }}!</h3>
                <p class="text-gray-700">Du bist erfolgreich eingeloggt.</p>
            </div>

            <!-- Hauptbereich mit Karten -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Produktkarte -->
                <div class="bg-white shadow rounded-lg p-6 hover:shadow-md transition">
                    <h4 class="text-lg font-semibold text-gray-800">📦 Produkte</h4>
                    <p class="text-sm text-gray-600 mt-1">Verwalte deine Produkte.</p>
                    <a href="{{ route('products.index') }}" class="mt-3 inline-block text-indigo-600 hover:underline text-sm">Zur Produktübersicht →</a>
                </div>

                <!-- Kategorienkarte -->
                <div class="bg-white shadow rounded-lg p-6 hover:shadow-md transition">
                    <h4 class="text-lg font-semibold text-gray-800">📂 Kategorien</h4>
                    <p class="text-sm text-gray-600 mt-1">Verwalte deine Kategorien.</p>
                    <a href="{{ route('categories.index') }}" class="mt-3 inline-block text-indigo-600 hover:underline text-sm">Zur Kategorienübersicht →</a>
                </div>

                <!-- Profilkarte -->
                <div class="bg-white shadow rounded-lg p-6 hover:shadow-md transition">
                    <h4 class="text-lg font-semibold text-gray-800">👤 Profil</h4>
                    <p class="text-sm text-gray-600 mt-1">Bearbeite dein Profil und Passwort.</p>
                    <a href="{{ route('profile.edit') }}" class="mt-3 inline-block text-indigo-600 hover:underline text-sm">Zum Profil →</a>
                </div>

                <!-- Weitere Karte -->
                <div class="bg-white shadow rounded-lg p-6 hover:shadow-md transition">
                    <h4 class="text-lg font-semibold text-gray-800">📝 Aktivität</h4>
                    <p class="text-sm text-gray-600 mt-1">Noch keine Aktivität vorhanden.</p>
                </div>
            </div>

           

        </div>
    </div>
</x-app-layout>
