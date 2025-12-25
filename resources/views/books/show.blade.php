<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $book->title }} - {{ config('app.name', 'VerdeLib') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800|playfair-display:700i&display=swap"
        rel="stylesheet" />

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-serif-accent {
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>

<body class="bg-[#FDFCF8] text-gray-800 antialiased font-sans flex flex-col min-h-screen">

    <!-- Navigation -->
    <nav class="w-full py-6 px-6 md:px-12 bg-[#FDFCF8] z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div
                    class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center text-brand-600 shadow-sm group-hover:bg-emerald-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.292a8.96 8.96 0 00-6-2.292c-1.052 0-2.062.18-3 .512v14.25c.938-.332 1.948-.512 3-.512 2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25c-.938-.332-1.948-.512-3-.512-2.305 0-4.408.867-6 2.292m0-14.25v14.25">
                        </path>
                    </svg>
                </div>
                <span class="text-2xl font-black tracking-tighter group-hover:opacity-80 transition-opacity">
                    <span class="text-brand-600">Verde</span><span class="text-gray-900">Lib</span><span
                        class="text-emerald-400">.</span>
                </span>
            </a>

            <!-- Back to Home -->
            <a href="{{ route('home') }}"
                class="flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-brand-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Home
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow py-16">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

                <!-- Book Cover -->
                <div class="sticky top-8">
                    <div
                        class="bg-white rounded-3xl shadow-2xl shadow-gray-200/50 overflow-hidden border border-gray-100 aspect-[3/4]">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                class="w-full h-full object-cover">
                        @else
                            <div
                                class="w-full h-full bg-gradient-to-br from-brand-100 to-emerald-100 flex items-center justify-center">
                                <svg class="w-24 h-24 text-brand-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Book Details -->
                <div>
                    <!-- Category Badge -->
                    @if($book->genre)
                        <span
                            class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-brand-100 text-brand-700 mb-4">
                            {{ $book->genre }}
                        </span>
                    @endif

                    <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-4 leading-tight">
                        {{ $book->title }}
                    </h1>

                    <p class="text-xl text-gray-500 mb-6">by <span
                            class="text-gray-800 font-semibold">{{ $book->author }}</span></p>

                    <!-- Meta Info -->
                    <div class="flex flex-wrap gap-4 mb-8">
                        @if($book->isbn)
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                    </path>
                                </svg>
                                ISBN: {{ $book->isbn }}
                            </div>
                        @endif

                        <div class="flex items-center gap-2 text-sm">
                            @if($book->status === 'available')
                                <span
                                    class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-100 text-brand-700 font-semibold">
                                    <span class="w-2 h-2 bg-brand-500 rounded-full"></span>
                                    Available
                                </span>
                            @elseif($book->status === 'borrowed')
                                <span
                                    class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 font-semibold">
                                    <span class="w-2 h-2 bg-yellow-500 rounded-full"></span>
                                    Borrowed
                                </span>
                            @else
                                <span
                                    class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 text-gray-700 font-semibold">
                                    <span class="w-2 h-2 bg-gray-500 rounded-full"></span>
                                    {{ ucfirst($book->status) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    @if($book->description)
                        <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 mb-8">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Description
                            </h3>
                            <p class="text-gray-600 leading-relaxed">{{ $book->description }}</p>
                        </div>
                    @endif

                    <!-- Borrow Button (if available and user is logged in) -->
                    @auth
                        @if($book->status === 'available')
                            <a href="{{ route('borrowings.create', $book) }}"
                                class="inline-flex items-center gap-3 px-8 py-4 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-2xl transition shadow-lg shadow-brand-500/30">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                                Borrow This Book
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center gap-3 px-8 py-4 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded-2xl transition shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Login to Borrow
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-auto">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="flex items-center justify-center gap-3 mb-4">
                <div class="w-8 h-8 bg-brand-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.292a8.96 8.96 0 00-6-2.292c-1.052 0-2.062.18-3 .512v14.25c.938-.332 1.948-.512 3-.512 2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25c-.938-.332-1.948-.512-3-.512-2.305 0-4.408.867-6 2.292m0-14.25v14.25">
                        </path>
                    </svg>
                </div>
                <span class="text-xl font-bold">VerdeLib</span>
            </div>
            <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} VerdeLib. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>