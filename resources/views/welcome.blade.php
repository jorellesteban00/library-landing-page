<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'VerdeLib') }} - Nature Styled Library</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800|playfair-display:700i&display=swap"
        rel="stylesheet" />

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <style>
        .font-serif-accent {
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>

<body class="bg-[#FDFCF8] text-gray-800 antialiased font-sans flex flex-col min-h-screen">
    @php
        $isStaff = auth()->check() && (auth()->user()->role === 'staff' || auth()->user()->role === 'librarian');
    @endphp

    <!-- Navigation -->
    <nav class="w-full py-6 px-6 md:px-12 bg-[#FDFCF8] z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center text-brand-600 shadow-sm group-hover:bg-emerald-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.292a8.96 8.96 0 00-6-2.292c-1.052 0-2.062.18-3 .512v14.25c.938-.332 1.948-.512 3-.512 2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25c-.938-.332-1.948-.512-3-.512-2.305 0-4.408.867-6 2.292m0-14.25v14.25"></path>
                    </svg>
                </div>
                <span class="text-2xl font-black tracking-tighter group-hover:opacity-80 transition-opacity">
                    <span class="text-brand-600">Verde</span><span class="text-gray-900">Lib</span><span class="text-emerald-400">.</span>
                </span>
            </a>

            <!-- Center Navigation Links (Pages + Menus) -->
            <div class="hidden md:flex items-center gap-1">
                @if(isset($pages) && count($pages) > 0)
                    @foreach($pages as $page)
                        <a href="{{ route('pages.show', $page->slug) }}" 
                           class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-colors">
                            {{ $page->title }}
                        </a>
                    @endforeach
                @endif
                @if(isset($menus) && count($menus) > 0)
                    @foreach($menus as $menu)
                        <a href="{{ $menu->url }}" 
                           target="{{ $menu->target ?? '_self' }}"
                           class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-colors flex items-center gap-1"
                           @if($menu->link_type === 'external') rel="noopener noreferrer" @endif>
                            {{ $menu->label }}
                            @if($menu->target === '_blank')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            @endif
                        </a>
                    @endforeach
                @endif
            </div>

            <!-- Auth Buttons -->
            <div class="flex items-center gap-4">
                @auth
                    <!-- User Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-3 focus:outline-none group">
                            <div class="text-right hidden sm:block">
                                <div class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</div>
                                <div class="text-[10px] font-bold tracking-wider text-gray-400 uppercase">{{ Auth::user()->role }}</div>
                            </div>
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" 
                                     alt="{{ Auth::user()->name }}"
                                     class="h-10 w-10 rounded-full object-cover border border-gray-200 shadow-sm">
                            @else
                                <div class="h-10 w-10 bg-gray-50 border border-gray-200 rounded-full flex items-center justify-center text-gray-700 font-bold uppercase shadow-sm">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                            <svg class="w-4 h-4 text-gray-400 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50"
                             style="display: none;">
                            
                            @php
                                $dashboardRoute = match(Auth::user()->role) {
                                    'librarian' => 'librarian.dashboard',
                                    'staff' => 'staff.dashboard',
                                    default => 'dashboard',
                                };
                            @endphp

                            <a href="{{ route($dashboardRoute) }}" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                                View Dashboard
                            </a>

                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Account Settings
                            </a>

                            <div class="border-t border-gray-100 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors w-full font-medium">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('register') }}"
                        class="text-sm font-bold text-brand-700 hover:text-brand-800 transition">Sign Up</a>
                    <a href="{{ route('login') }}"
                        class="px-6 py-3 text-sm font-bold text-white bg-brand-600 rounded-full hover:bg-brand-700 transition shadow-lg shadow-brand-600/20">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="flex-grow">
        <section class="relative pt-24 pb-56 px-6 overflow-hidden">
            <div class="max-w-5xl mx-auto text-center relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-50 text-brand-700 text-xs font-bold tracking-wide uppercase mb-6 animate-fade-in-up">
                    <span class="w-2 h-2 rounded-full bg-brand-500"></span>
                    Welcome to VerdeLib
                </div>
                
                <h1 class="text-6xl md:text-7xl lg:text-8xl font-black text-gray-900 mb-8 tracking-tight leading-[1.1]">
                    @if(isset($content['hero_title']))
                        {{ $content['hero_title'] }}
                    @else
                        Discover, Learn,<br>
                        and Grow <span class="font-serif-accent italic text-brand-600 relative inline-block">
                            Naturally.
                            <svg class="absolute -bottom-2 left-0 w-full h-3 text-brand-300/50" viewBox="0 0 100 10" preserveAspectRatio="none"><path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="4" fill="none" /></svg>
                        </span>
                    @endif
                </h1>
                
                <p class="max-w-2xl mx-auto text-lg md:text-xl text-gray-500 mb-12 leading-relaxed font-medium">
                    {{ $content['hero_subtitle'] ?? 'Access a world of knowledge, community events, and digital resources through our modern eco-conscious library portal.' }}
                </p>

                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#books" class="px-8 py-4 bg-brand-600 text-white rounded-full font-bold shadow-xl shadow-brand-600/30 hover:bg-brand-700 hover:-translate-y-1 transition-all flex items-center gap-2">
                        <span>Explore Collection</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="#team" class="px-8 py-4 bg-white text-gray-900 rounded-full font-bold border border-gray-200 hover:border-brand-200 hover:shadow-lg transition-all">
                        Meet Our Team
                    </a>
                </div>
            </div>

            <!-- Background Decorations -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
                <div class="absolute top-[-10%] right-[-5%] w-[600px] h-[600px] bg-brand-100/40 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-[-10%] left-[-10%] w-[500px] h-[500px] bg-emerald-100/40 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s"></div>
                <!-- Floating Leaves (CSS animation needed or simple positioning) -->
                <div class="absolute top-20 left-[10%] opacity-20 transform rotate-12">
                    <svg class="w-16 h-16 text-brand-400" fill="currentColor" viewBox="0 0 24 24"><path d="M17,8C8,10,5.9,16.17,3.82,21.34L5.71,22l1-2.3A4.49,4.49,0,0,0,8,20C19,20,22,3,22,3,21,5,14,5.25,9,6.25S2,11.5,2,13.5a6.22,6.22,0,0,0,1.75,3.75C7,8,17,8,17,8Z"/></svg>
                </div>
                <div class="absolute bottom-40 right-[15%] opacity-20 transform -rotate-45">
                     <svg class="w-24 h-24 text-emerald-400" fill="currentColor" viewBox="0 0 24 24"><path d="M17,8C8,10,5.9,16.17,3.82,21.34L5.71,22l1-2.3A4.49,4.49,0,0,0,8,20C19,20,22,3,22,3,21,5,14,5.25,9,6.25S2,11.5,2,13.5a6.22,6.22,0,0,0,1.75,3.75C7,8,17,8,17,8Z"/></svg>
                </div>
            </div>
            <!-- Wave Divider -->
            <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none z-10">
                <svg class="relative block w-[calc(100%+1.3px)] h-[60px] text-white" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="currentColor"></path>
                </svg>
            </div>
        </section>

        <!-- Features / Stats Section -->
        <section class="py-20 bg-white relative z-20">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <!-- Vision -->
                    <div class="flex flex-col items-center text-center group p-8 rounded-[2rem_0.5rem] hover:bg-brand-50/50 transition-colors duration-500">
                        <div class="w-16 h-16 bg-brand-100 rounded-2xl flex items-center justify-center text-brand-600 mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg shadow-brand-100/50">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </div>
                        <h3 class="text-2xl font-black text-gray-900 mb-3 font-serif-accent italic">Our Vision</h3>
                        <div class="text-gray-500 text-base leading-relaxed max-w-xs mx-auto prose prose-sm">
                            {!! $content['vision'] ?? 'To be a pioneer in sustainable knowledge management and community engagement.' !!}
                        </div>
                    </div>
                    <!-- Mission -->
                    <div class="flex flex-col items-center text-center group p-8 rounded-[0.5rem_2rem] hover:bg-emerald-50/50 transition-colors duration-500">
                        <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 mb-6 group-hover:scale-110 group-hover:-rotate-3 transition-all duration-300 shadow-lg shadow-emerald-100/50">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <h3 class="text-2xl font-black text-gray-900 mb-3 font-serif-accent italic">Our Mission</h3>
                        <div class="text-gray-500 text-base leading-relaxed max-w-xs mx-auto prose prose-sm">
                            {!! $content['mission'] ?? 'To foster a culture of lifelong learning through accessible, green resources.' !!}
                        </div>
                    </div>
                     <!-- Goals -->
                    <div class="flex flex-col items-center text-center group p-8 rounded-[2rem_0.5rem] hover:bg-lime-50/50 transition-colors duration-500">
                        <div class="w-16 h-16 bg-lime-100 rounded-2xl flex items-center justify-center text-lime-600 mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg shadow-lime-100/50">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-2xl font-black text-gray-900 mb-3 font-serif-accent italic">Our Goals</h3>
                        <div class="text-gray-500 text-base leading-relaxed max-w-xs mx-auto prose prose-sm">
                            {!! $content['goals'] ?? 'Promoting environmental awareness while preserving human knowledge.' !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- New Arrivals Section -->
        <section id="books" class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-5xl font-black text-gray-900 mb-4">New <span
                            class="font-serif-accent italic text-brand-600">Arrivals.</span></h2>
                    <p class="text-gray-500 max-w-2xl mx-auto">Explore the freshest additions to our sustainable
                        collection.</p>
                </div>

                @if(count($books) > 0)
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                        @foreach($books as $book)
                            <a href="{{ route('books.show', $book) }}" class="group cursor-pointer block">
                                <div
                                    class="bg-gray-100 rounded-2xl aspect-[3/4] mb-4 overflow-hidden relative shadow-sm group-hover:shadow-xl transition-all duration-500">
                                    <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : 'https://via.placeholder.com/300x450?text=' . urlencode($book->title) }}"
                                        alt="{{ $book->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                                <h3
                                    class="font-bold text-gray-900 text-lg leading-tight group-hover:text-brand-600 transition-colors">
                                    {{ $book->title }}</h3>
                                <p class="text-gray-500 text-sm mt-1">{{ $book->author }}</p>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-20 bg-gray-50 rounded-3xl">
                        <p class="text-gray-400 font-medium">Our collection is growing. Check back soon for featured books!
                        </p>
                    </div>
                @endif
            </div>
        </section>

        <!-- News Section -->
        <section id="news" class="py-24 bg-[#FDFCF8]">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-5xl font-black text-gray-900 mb-4">Latest <span
                            class="font-serif-accent italic text-brand-600">News.</span></h2>
                    <p class="text-gray-500 max-w-2xl mx-auto">Stay updated with the latest happenings at our library.</p>
                </div>

                @if(count($news) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach($news as $item)
                            <a href="{{ route('news.show', $item) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100 block">
                                <!-- Image -->
                                <div class="aspect-video overflow-hidden bg-gray-100">
                                    @if($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" 
                                             alt="{{ $item->title }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-brand-50">
                                            <svg class="w-12 h-12 text-brand-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Content -->
                                <div class="p-6">
                                    <div class="flex items-center gap-2 text-xs text-gray-400 mb-3">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $item->published_date ? \Carbon\Carbon::parse($item->published_date)->format('M d, Y') : $item->created_at->format('M d, Y') }}
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-brand-600 transition-colors line-clamp-2">{{ $item->title }}</h3>
                                    <p class="text-gray-500 text-sm line-clamp-3">{!! Str::limit(strip_tags($item->content), 120) !!}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-20 bg-white rounded-3xl border border-gray-100">
                        <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                        <p class="text-gray-400 font-medium">No news yet. Check back soon for updates!</p>
                    </div>
                @endif
            </div>
        </section>

        <!-- Team Section -->
        <section id="team" class="py-24 bg-[#FDFCF8]">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-5xl font-black text-gray-900 mb-4">Meet our <span
                            class="font-serif-accent italic text-brand-600">Team.</span></h2>
                    <p class="text-gray-500 max-w-2xl mx-auto">Dedicated professionals committed to serving our
                        community.</p>
                </div>

                @if(count($staff) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                        @foreach($staff as $person)
                            <div class="text-center group">
                                <div class="w-48 h-48 mx-auto mb-6 relative">
                                    <div
                                        class="absolute inset-0 bg-brand-200 rounded-full blur-2xl opacity-0 group-hover:opacity-50 transition-opacity duration-500">
                                    </div>
                                    <img src="{{ $person->image ? asset('storage/' . $person->image) : 'https://ui-avatars.com/api/?name=' . urlencode($person->name) . '&background=059669&color=fff' }}"
                                        alt="{{ $person->name }}"
                                        class="w-full h-full object-cover rounded-full relative z-10 border-4 border-white shadow-lg group-hover:-translate-y-2 transition-transform duration-500">
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $person->name }}</h3>
                                <p class="text-brand-600 font-medium tracking-wide uppercase text-sm mt-2">
                                    {{ $person->role_text }}</p>
                                <p class="text-gray-500 mt-4 leading-relaxed max-w-xs mx-auto text-sm">
                                    {{ Str::limit($person->bio, 80) }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 border-2 border-dashed border-gray-200 rounded-3xl">
                        <p class="text-gray-400">Our team list is being updated.</p>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-brand-50/50 py-20 border-t border-brand-100">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <!-- Brand -->
                <div class="col-span-1 md:col-span-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 mb-6">
                        <div class="w-8 h-8 bg-brand-100/50 rounded-lg flex items-center justify-center text-brand-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.292a8.96 8.96 0 00-6-2.292c-1.052 0-2.062.18-3 .512v14.25c.938-.332 1.948-.512 3-.512 2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25c-.938-.332-1.948-.512-3-.512-2.305 0-4.408.867-6 2.292m0-14.25v14.25"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-black tracking-tighter">
                            <span class="text-brand-600">Verde</span><span class="text-gray-900">Lib</span><span class="text-emerald-400">.</span>
                        </span>
                    </a>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6">
                        Empowering our community with knowledge, digital tools, and a space for lifelong learning.
                    </p>
                    <div class="text-gray-500 text-sm leading-relaxed mb-6 prose prose-sm">
                        {!! $content['contact_info'] ?? '' !!}
                    </div>
                    <div class="flex gap-4">
                        <a href="#"
                            class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded-full text-gray-600 hover:bg-brand-600 hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
                            </svg>
                        </a>
                        <!-- Add other social icons similarly -->
                    </div>
                </div>

                <!-- Spacer -->
                <div class="hidden md:block"></div>

                <!-- Digital Resources -->
                <div>
                    <h4 class="font-bold text-gray-900 uppercase tracking-wider text-xs mb-6">Digital Resources</h4>
                    <ul class="space-y-4">
                        @forelse($resources as $resource)
                            <li>
                                <a href="{{ $resource->resource_url }}" target="_blank" 
                                   class="text-gray-500 hover:text-brand-600 text-sm transition-colors flex items-center gap-2">
                                    {{ $resource->title }}
                                    @if($resource->type === 'document' || $resource->type === 'image')
                                        <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    @endif
                                </a>
                            </li>
                        @empty
                            <li><span class="text-gray-400 text-sm">Coming soon...</span></li>
                        @endforelse
                    </ul>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-bold text-gray-900 uppercase tracking-wider text-xs mb-6">Quick Links</h4>
                    <ul class="space-y-4">
                        @foreach($menus as $menu)
                            <li>
                                <a href="{{ $menu->url }}"
                                   target="{{ $menu->target ?? '_self' }}"
                                   class="text-gray-500 hover:text-brand-600 text-sm transition-colors inline-flex items-center gap-1"
                                   @if($menu->link_type === 'external') rel="noopener noreferrer" @endif>
                                    {{ $menu->label }}
                                    @if($menu->target === '_blank')
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div
                class="border-t border-gray-100 mt-16 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-400 text-xs">&copy; {{ date('Y') }} VerdeLib. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="text-gray-400 hover:text-gray-600 text-xs">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-gray-600 text-xs">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>