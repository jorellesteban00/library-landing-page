<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $news->title }} - {{ config('app.name', 'VerdeLib') }}</title>

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
        <!-- Featured Image -->
        @if($news->image)
            <div class="w-full h-64 md:h-80 overflow-hidden">
                <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}"
                    class="w-full h-full object-cover">
            </div>
        @else
            <div class="w-full h-48 bg-gradient-to-r from-brand-100 to-emerald-100"></div>
        @endif

        <!-- Article Content -->
        <div class="max-w-4xl mx-auto px-6 -mt-16 relative z-10">
            <article class="bg-white rounded-3xl shadow-2xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
                <div class="p-8 md:p-12">
                    <!-- Meta -->
                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            {{ $news->published_date ? \Carbon\Carbon::parse($news->published_date)->format('F d, Y') : $news->created_at->format('F d, Y') }}
                        </span>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-brand-100 text-brand-700">
                            News
                        </span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-8 leading-tight">
                        {{ $news->title }}
                    </h1>

                    <!-- Content -->
                    <div class="prose max-w-none text-gray-600 leading-relaxed text-lg">
                        {!! $news->content !!}
                    </div>
                </div>
            </article>

            <!-- Share Section -->
            <div class="mt-8 text-center">
                <p class="text-gray-500 text-sm mb-4">Share this article</p>
                <div class="flex items-center justify-center gap-3">
                    <a href="#"
                        class="w-10 h-10 bg-gray-100 hover:bg-brand-100 text-gray-500 hover:text-brand-600 rounded-full flex items-center justify-center transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                        </svg>
                    </a>
                    <a href="#"
                        class="w-10 h-10 bg-gray-100 hover:bg-brand-100 text-gray-500 hover:text-brand-600 rounded-full flex items-center justify-center transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                        </svg>
                    </a>
                    <a href="#"
                        class="w-10 h-10 bg-gray-100 hover:bg-brand-100 text-gray-500 hover:text-brand-600 rounded-full flex items-center justify-center transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-24">
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