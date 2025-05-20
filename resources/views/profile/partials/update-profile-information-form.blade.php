<section class="space-y-6">
    <header>
        <h2 class="text-xl font-semibold text-indigo-800">
            {{ __('Profilinformationen') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Aktualisiere deinen Namen und deine E-Mail-Adresse.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        {{-- Name --}}
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
            />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('E-Mail')" />
            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
            />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 bg-yellow-50 border border-yellow-300 text-yellow-800 p-3 rounded-md">
                    <p class="text-sm">
                        {{ __('Deine E-Mail-Adresse ist noch nicht verifiziert.') }}
                        <button
                            form="send-verification"
                            class="ml-2 underline text-sm text-yellow-800 hover:text-yellow-900"
                        >
                            {{ __('Hier klicken, um den Verifizierungslink erneut zu senden.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Ein neuer Verifizierungslink wurde an deine E-Mail-Adresse gesendet.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Button + Erfolgsmeldung --}}
        <div class="flex items-center gap-4">
            <x-primary-button>
                {{ __('Speichern') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-green-600"
                >
                    {{ __('Gespeichert.') }}
                </p>
            @endif
        </div>
    </form>
</section>
