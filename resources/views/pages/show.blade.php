<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page->title }} - {{ config('app.name', 'Library') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            900: '#312e81',
                        },
                        accent: {
                            DEFAULT: '#f43f5e',
                            hover: '#e11d48',
                        }
                    },
                    fontFamily: {
                        sans: ['Figtree', 'sans-serif'],
                    },
                },
            },
        }
    </script>

    <!-- Trix Styles for content rendering -->
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <style>
        .trix-content h1 {
            font-size: 2em;
            font-weight: bold;
            margin-bottom: 0.5em;
        }

        .trix-content h2 {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 0.5em;
        }

        .trix-content ul {
            list-style-type: disc;
            margin-left: 1.5em;
        }

        .trix-content ol {
            list-style-type: decimal;
            margin-left: 1.5em;
        }

        .trix-content blockquote {
            border-left: 4px solid #ccc;
            padding-left: 1em;
            color: #666;
        }

        .trix-content a {
            color: #4f46e5;
            text-decoration: underline;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased font-sans flex flex-col min-h-screen">

    <!-- Header -->
    <header class="bg-white/95 backdrop-blur shadow-sm sticky top-0 z-50">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <div
                            class="w-8 h-8 rounded-lg bg-gradient-to-br from-brand-600 to-accent-DEFAULT flex items-center justify-center text-white font-bold text-lg shadow-lg">
                            L</div>
                        <span
                            class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-brand-900 to-brand-600">Library</span>
                    </a>
                </div>

                <!-- Navigation Links (Dynamic would be ideal here too, but for now simple home link) -->
                <div class="hidden md:flex gap-8 items-center">
                    <a href="{{ route('home') }}"
                        class="text-sm font-medium text-gray-700 hover:text-brand-600 transition-colors">Home</a>
                    @if(auth()->check())
                        <a href="{{ route('dashboard') }}"
                            class="text-sm font-medium text-gray-700 hover:text-brand-600 transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm font-medium text-gray-700 hover:text-brand-600 transition-colors">Login</a>
                    @endif
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-grow max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">
        <article class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-6">{{ $page->title }}</h1>

            <div class="trix-content prose max-w-none text-gray-600 leading-relaxed">
                {!! $page->content !!}
            </div>
        </article>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-12 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} Library System. All rights reserved.
        </div>
    </footer>

</body>

</html>