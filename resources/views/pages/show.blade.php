<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page->title }} - {{ config('app.name', 'VerdeLib') }}</title>

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

        .prose h1 {
            font-size: 2em;
            font-weight: bold;
            margin-bottom: 0.5em;
            color: #111827;
        }

        .prose h2 {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 0.5em;
            color: #111827;
        }

        .prose h3 {
            font-size: 1.25em;
            font-weight: bold;
            margin-bottom: 0.5em;
            color: #111827;
        }

        .prose p {
            margin-bottom: 1em;
        }

        .prose ul {
            list-style-type: disc;
            margin-left: 1.5em;
            margin-bottom: 1em;
        }

        .prose ol {
            list-style-type: decimal;
            margin-left: 1.5em;
            margin-bottom: 1em;
        }

        .prose blockquote {
            border-left: 4px solid #10b981;
            padding-left: 1em;
            color: #6b7280;
            font-style: italic;
            margin: 1em 0;
        }

        .prose a {
            color: #059669;
            text-decoration: underline;
        }

        .prose img {
            border-radius: 1rem;
            margin: 1.5em 0;
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
    <main class="flex-grow">
        <!-- Hero Section -->
        <div class="bg-gradient-to-b from-brand-50/50 to-transparent py-16">
            <div class="max-w-4xl mx-auto px-6">
                <h1 class="text-5xl font-black text-gray-900 mb-4">
                    {{ $page->title }}
                </h1>
                <div class="flex items-center gap-4 text-sm text-gray-500">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        {{ $page->updated_at->format('F d, Y') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="max-w-4xl mx-auto px-6 pb-24">
            <article class="bg-white p-8 md:p-12 rounded-3xl shadow-xl shadow-gray-100/50 border border-gray-100">
                <div class="prose max-w-none text-gray-600 leading-relaxed text-lg">
                    {!! $page->content !!}
                </div>
            </article>
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