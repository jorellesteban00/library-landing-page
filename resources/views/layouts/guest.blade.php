<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-white selection:bg-brand-500 selection:text-white">
    <div class="flex min-h-screen">
        <!-- Left Side: Visual Branding (Corporate/Nature) -->
        <div class="hidden lg:flex lg:w-5/12 relative overflow-hidden bg-brand-900">
            <!-- Background Image: Modern Architectural Library with Nature -->
            <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?q=80&w=2000&auto=format&fit=crop"
                alt="Modern Library"
                class="absolute inset-0 w-full h-full object-cover opacity-50 mix-blend-overlay scale-105 transition-transform duration-[20s] hover:scale-100 ease-linear">

            <div class="absolute inset-0 bg-gradient-to-t from-brand-900 via-brand-900/40 to-transparent opacity-90">
            </div>

            <!-- Content Overlay -->
            <div class="relative z-10 w-full h-full flex flex-col justify-between p-12 text-white">
                <!-- Top Logo -->
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white/10 backdrop-blur-md rounded-lg border border-white/20">
                        <svg class="w-6 h-6 text-brand-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.292a8.96 8.96 0 00-6-2.292c-1.052 0-2.062.18-3 .512v14.25c.938-.332 1.948-.512 3-.512 2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25c-.938-.332-1.948-.512-3-.512-2.305 0-4.408.867-6 2.292m0-14.25v14.25">
                            </path>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-white/90">VerdeLib.</span>
                </div>

                <!-- Middle Quote -->
                <div class="mb-12">
                    <h1 class="text-5xl font-extrabold mb-6 leading-tight tracking-tight">
                        Cultivating <br>
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-brand-300 to-emerald-100">Wisdom</span>
                    </h1>
                    <div class="w-20 h-1 bg-brand-500 rounded-full mb-6"></div>
                    <p class="text-lg text-brand-100 font-light leading-relaxed max-w-sm">
                        "The library is the temple of learning, and learning has liberated more people than all other
                        wars in history."
                    </p>
                </div>

                <!-- Bottom Footer -->
                <div
                    class="flex justify-between items-end text-xs text-brand-300/60 font-medium uppercase tracking-widest">
                    <span>Est. 2025</span>
                    <span>Pro Edition</span>
                </div>
            </div>

            <!-- Decor Circle -->
            <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-brand-500/20 rounded-full blur-3xl"></div>
        </div>

        <!-- Right Side: Form (Modern Clean) -->
        <div class="w-full lg:w-7/12 flex flex-col min-h-screen bg-[#FCFCFD] relative">
            <!-- Subtle Mesh Gradient Background -->
            <div
                class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-brand-50/40 via-transparent to-transparent pointer-events-none">
            </div>

            <!-- Top Navigation Bar -->
            <div class="w-full flex justify-between items-center p-6 md:p-8 relative z-20">
                <!-- Mobile Logo (Visible only on mobile/tablet) -->
                <a href="/" class="lg:hidden flex items-center gap-2 group">
                    <div class="p-1.5 bg-brand-100 rounded-lg text-brand-600 group-hover:bg-brand-200 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.292a8.96 8.96 0 00-6-2.292c-1.052 0-2.062.18-3 .512v14.25c.938-.332 1.948-.512 3-.512 2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25c-.938-.332-1.948-.512-3-.512-2.305 0-4.408.867-6 2.292m0-14.25v14.25">
                            </path>
                        </svg>
                    </div>
                    <span
                        class="text-xl font-bold tracking-tight text-gray-900 group-hover:text-brand-700 transition">VerdeLib.</span>
                </a>

                <!-- Spacer for layout balance on Desktop -->
                <div class="hidden lg:block"></div>

                <!-- Back to Home Link -->
                <a href="/"
                    class="flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-brand-600 transition px-4 py-2 rounded-full hover:bg-white hover:shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Home
                </a>
            </div>

            <!-- Content Area (Centered) -->
            <div class="flex-1 flex flex-col justify-center items-center p-6 md:p-12 relative z-10 w-full">
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer Links (Static Flow) -->
            <div class="py-6 text-center">
                <div class="flex justify-center gap-6 text-xs text-gray-400 font-medium tracking-wide">
                    <a href="#" class="hover:text-brand-600 transition">Privacy Policy</a>
                    <a href="#" class="hover:text-brand-600 transition">Terms of Service</a>
                    <a href="#" class="hover:text-brand-600 transition">Contact</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>