<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-indigo-800 leading-tight">
            {{ __('Profilverwaltung') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-10">

            {{-- Profilinformationen --}}
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-700 mb-4 flex items-center">
                    <svg class="w-6 h-6 text-indigo-500 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M5.121 17.804A3 3 0 018 21h8a3 3 0 012.879-3.196M15 11a3 3 0 00-6 0m6 0a6 6 0 11-6 0" />
                    </svg>
                    {{ __('Profilinformationen aktualisieren') }}
                </h3>
                <div class="max-w-2xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Passwort ändern --}}
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-700 mb-4 flex items-center">
                    <svg class="w-6 h-6 text-red-500 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M12 11c0-2.21 1.79-4 4-4s4 1.79 4 4v2h-8v-2zM6 11V9a6 6 0 0112 0v2H6zM5 13h14v6a2 2 0 01-2 2H7a2 2 0 01-2-2v-6z" />
                    </svg>
                    {{ __('Passwort ändern') }}
                </h3>
                <div class="max-w-2xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Konto löschen --}}
            <div class="bg-white shadow-md rounded-lg p-6 border border-red-200">
                <h3 class="text-xl font-semibold text-red-600 mb-4 flex items-center">
                    <svg class="w-6 h-6 text-red-600 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    {{ __('Konto löschen') }}
                </h3>
                <div class="max-w-2xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
