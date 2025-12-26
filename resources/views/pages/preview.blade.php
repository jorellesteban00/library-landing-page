<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Preview: {{ $page->title }} - {{ config('app.name', 'VerdeLib') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800|playfair-display:700i&display=swap"
        rel="stylesheet" />

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#FDFCF8] text-gray-800 antialiased font-sans">
    <!-- Preview Banner -->
    <div class="fixed top-0 left-0 right-0 z-50 bg-amber-500 text-white py-3 px-6 shadow-lg">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                    </path>
                </svg>
                <span class="font-bold">PREVIEW MODE</span>
                <span class="text-amber-100">— This page is not yet public</span>
            </div>
            <div class="flex items-center gap-4">
                <span
                    class="px-3 py-1 rounded-full text-xs font-bold {{ $page->status_color === 'green' ? 'bg-green-600' : ($page->status_color === 'blue' ? 'bg-blue-600' : 'bg-gray-600') }}">
                    {{ $page->status_label }}
                </span>
                <a href="{{ route('staff.pages.edit', $page) }}"
                    class="px-4 py-2 bg-white text-amber-600 font-bold rounded-lg hover:bg-amber-50 transition text-sm">
                    ← Back to Editor
                </a>
            </div>
        </div>
    </div>

    <!-- Spacer for fixed banner -->
    <div class="h-14"></div>

    <!-- Navigation -->
    <nav class="w-full py-6 px-6 md:px-12 bg-[#FDFCF8] z-40">
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
        </div>
    </nav>

    <!-- Page Content -->
    <main class="py-12">
        <article class="max-w-4xl mx-auto px-6">
            <!-- Breadcrumbs -->
            @if ($page->parent)
                <nav class="mb-6">
                    <ol class="flex items-center gap-2 text-sm text-gray-500">
                        <li><a href="{{ route('home') }}" class="hover:text-brand-600">Home</a></li>
                        @foreach ($page->getBreadcrumbs() as $crumb)
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                                @if ($crumb->id === $page->id)
                                    <span class="font-medium text-gray-900">{{ $crumb->title }}</span>
                                @else
                                    <a href="{{ route('pages.show', $crumb) }}"
                                        class="hover:text-brand-600">{{ $crumb->title }}</a>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </nav>
            @endif

            <!-- Featured Image -->
            @if ($page->featured_image)
                <div class="mb-8 rounded-2xl overflow-hidden shadow-xl">
                    <img src="{{ asset('storage/' . $page->featured_image) }}" alt="{{ $page->title }}"
                        class="w-full h-[400px] object-cover">
                </div>
            @endif

            <!-- Title -->
            <header class="mb-8">
                <h1 class="text-5xl font-black text-gray-900 mb-4 leading-tight">{{ $page->title }}</h1>
                @if ($page->meta_description)
                    <p class="text-xl text-gray-500 leading-relaxed">{{ $page->meta_description }}</p>
                @endif
            </header>

            <!-- Content -->
            <div class="prose prose-lg max-w-none 
                        prose-headings:font-bold prose-headings:text-gray-900
                        prose-p:text-gray-600 prose-p:leading-relaxed
                        prose-a:text-brand-600 prose-a:no-underline hover:prose-a:underline
                        prose-img:rounded-xl prose-img:shadow-lg
                        prose-blockquote:border-brand-500 prose-blockquote:bg-brand-50 prose-blockquote:py-1 prose-blockquote:px-6 prose-blockquote:rounded-r-xl
                        prose-code:bg-gray-100 prose-code:px-2 prose-code:py-1 prose-code:rounded
                        prose-pre:bg-gray-900 prose-pre:text-gray-100">
                {!! $page->content !!}
            </div>

            <!-- Child Pages -->
            @if ($page->visibleChildren->count() > 0)
                <div class="mt-16 pt-8 border-t border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Pages</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($page->visibleChildren as $child)
                            <a href="{{ route('pages.show', $child) }}"
                                class="block p-6 bg-white rounded-xl border border-gray-100 hover:border-brand-200 hover:shadow-lg transition group">
                                <h3
                                    class="text-lg font-bold text-gray-900 group-hover:text-brand-600 transition mb-2">
                                    {{ $child->title }}</h3>
                                @if ($child->meta_description)
                                    <p class="text-gray-500 text-sm">{{ Str::limit($child->meta_description, 100) }}
                                    </p>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </article>
    </main>

    <!-- Footer -->
    <footer class="bg-brand-50/50 py-12 border-t border-brand-100 mt-16">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} VerdeLib. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
