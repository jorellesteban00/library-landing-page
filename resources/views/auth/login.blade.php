<x-guest-layout>
    <div class="mb-10">
        <h2 class="text-4xl font-bold text-gray-900 tracking-tight">Welcome back</h2>
        <p class="mt-2 text-gray-500">Please enter your details to sign in.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status
        class="mb-6 p-4 rounded-xl bg-brand-50 text-brand-700 border border-brand-100 text-sm font-medium"
        :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <x-input-label for="email" :value="__('Email Address')"
                class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1" />

            <div class="relative group">
                <div
                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors duration-200 group-focus-within:text-brand-500">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-brand-500 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                        </path>
                    </svg>
                </div>
                <!-- Adding pl-11 to make room for icon -->
                <x-text-input id="email"
                    class="block w-full pl-11 py-3.5 border-gray-200 bg-gray-50/50 focus:bg-white transition-all shadow-sm"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                    placeholder="name@company.com" />
            </div>

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <div class="flex justify-between items-center ml-1">
                <x-input-label for="password" :value="__('Password')"
                    class="text-xs font-bold text-gray-500 uppercase tracking-wider" />
            </div>

            <div class="relative group">
                <div
                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors duration-200 group-focus-within:text-brand-500">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-brand-500 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                        </path>
                    </svg>
                </div>
                <x-text-input id="password"
                    class="block w-full pl-11 py-3.5 border-gray-200 bg-gray-50/50 focus:bg-white transition-all shadow-sm"
                    type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Options Row -->
        <div class="flex items-center justify-between pt-2">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <div class="relative flex items-start">
                    <div class="flex items-center h-5">
                        <input id="remember_me" type="checkbox"
                            class="w-4 h-4 rounded border-gray-300 text-brand-600 shadow-sm focus:ring-brand-500 cursor-pointer group-hover:border-brand-400 transition"
                            name="remember">
                    </div>
                </div>
                <span
                    class="ms-2 text-sm text-gray-600 font-medium group-hover:text-gray-800 transition">{{ __('Remember me') }}</span>
            </label>

            <!-- 
            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-brand-600 hover:text-brand-700 hover:underline decoration-2 underline-offset-4 transition" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif 
            -->
        </div>

        <div class="pt-4">
            <x-primary-button
                class="w-full justify-center py-4 text-base bg-gradient-to-r from-brand-600 to-emerald-500 hover:from-brand-700 hover:to-emerald-600 border-0 shadow-xl shadow-brand-500/20 transform hover:-translate-y-0.5 transition-all duration-200">
                {{ __('Sign In') }}
                <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                    </path>
                </svg>
            </x-primary-button>
        </div>

    </form>
</x-guest-layout>