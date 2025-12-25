<x-app-layout>
    <div class="py-12 bg-[#FDFCF8] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <nav class="mb-8 flex items-center text-sm font-medium text-gray-500">
                @php
                    $dashboardRoute = match (Auth::user()->role) {
                        'librarian' => 'librarian.dashboard',
                        'staff' => 'staff.dashboard',
                        default => 'dashboard',
                    };
                @endphp
                <a href="{{ route($dashboardRoute) }}"
                    class="hover:text-brand-600 transition-colors flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    Dashboard
                </a>
                <svg class="w-4 h-4 mx-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-brand-600">Account Settings</span>
            </nav>

            <!-- Custom Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center p-3 bg-brand-50 rounded-2xl mb-4 shadow-sm">
                    <div
                        class="h-12 w-12 bg-brand-100 rounded-xl flex items-center justify-center text-brand-600 shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.292a8.96 8.96 0 00-6-2.292c-1.052 0-2.062.18-3 .512v14.25c.938-.332 1.948-.512 3-.512 2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25c-.938-.332-1.948-.512-3-.512-2.305 0-4.408.867-6 2.292m0-14.25v14.25">
                            </path>
                        </svg>
                    </div>
                </div>
                <h2 class="text-4xl font-black text-gray-900 mb-2">
                    Account <span class="font-serif-accent italic text-brand-600">Settings</span>
                </h2>
                <p class="text-gray-500 max-w-xl mx-auto">Manage your profile information, password, and account
                    security.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">

                <!-- Left Column: Profile Information -->
                <div class="md:col-span-1 space-y-8">
                    <div
                        class="p-8 bg-white shadow-xl shadow-brand-100/50 rounded-[2rem_0.5rem] border border-brand-100/50 relative overflow-hidden">
                        <!-- Decorative Blob -->
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-brand-50 rounded-full blur-2xl -mr-16 -mt-16 pointer-events-none">
                        </div>

                        <div class="relative z-10">
                            <div class="mb-6 flex items-center gap-3 text-brand-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <h3 class="font-bold text-lg">Personal Details</h3>
                            </div>
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>

                <!-- Right Column: Security -->
                <div class="md:col-span-2 space-y-8">

                    <!-- Update Password -->
                    <div
                        class="p-8 bg-white shadow-xl shadow-emerald-100/50 rounded-[0.5rem_2rem] border border-emerald-100/50 relative overflow-hidden">
                        <div
                            class="absolute bottom-0 left-0 w-32 h-32 bg-emerald-50 rounded-full blur-2xl -ml-16 -mb-16 pointer-events-none">
                        </div>

                        <div class="relative z-10">
                            <div class="mb-6 flex items-center gap-3 text-emerald-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                <h3 class="font-bold text-lg">Security</h3>
                            </div>
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <!-- Delete Account -->
                    <div
                        class="p-8 bg-red-50/30 border border-red-100 rounded-3xl opacity-90 hover:opacity-100 transition-opacity">
                        <div class="mb-6 flex items-center gap-3 text-red-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            <h3 class="font-bold text-lg">Danger Zone</h3>
                        </div>
                        @include('profile.partials.delete-user-form')
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>