<x-guest-layout>
    <!-- Form Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Create Account</h2>
        <p class="text-gray-500">Join VerdeLib and start your learning journey.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-gray-600 font-medium" />
            <x-text-input id="name"
                class="block mt-2 w-full rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 py-3"
                type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                placeholder="Enter your full name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-600 font-medium" />
            <x-text-input id="email"
                class="block mt-2 w-full rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 py-3"
                type="email" name="email" :value="old('email')" required autocomplete="username"
                placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-600 font-medium" />
            <x-text-input id="password"
                class="block mt-2 w-full rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 py-3"
                type="password" name="password" required autocomplete="new-password"
                placeholder="Create a strong password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')"
                class="text-gray-600 font-medium" />
            <x-text-input id="password_confirmation"
                class="block mt-2 w-full rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 py-3"
                type="password" name="password_confirmation" required autocomplete="new-password"
                placeholder="Confirm your password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between pt-4">
            <a class="text-sm text-gray-500 hover:text-brand-600 transition font-medium underline underline-offset-4"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button
                class="px-8 py-3 rounded-xl font-bold uppercase tracking-wide shadow-lg shadow-brand-500/30">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>