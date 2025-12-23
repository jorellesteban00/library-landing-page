<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Library') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts (Alpine.js & Tailwind) -->
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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        .glass-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
        }
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased font-sans flex flex-col min-h-screen">

    <!-- Header -->
    <header class="glass-header sticky top-0 z-50 transition-all duration-300">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-brand-600 to-accent-DEFAULT flex items-center justify-center text-white font-bold text-lg shadow-lg group-hover:scale-110 transition-transform duration-200">
                            L
                        </div>
                        <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-brand-900 to-brand-600">
                            Library
                        </span>
                    </a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <!-- Dashboard Links -->
                            @if(Auth::user()->role === 'librarian')
                                <a href="{{ route('librarian.dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-brand-600 transition-colors">
                                    Librarian Dashboard
                                </a>
                            @elseif(Auth::user()->role === 'staff')
                                <a href="{{ route('staff.dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-brand-600 transition-colors">
                                    Staff Dashboard
                                </a>
                            @endif

                            <!-- User Dropdown -->
                            <div x-data="{ open: false }" class="relative ml-3">
                                <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-brand-700 focus:outline-none transition-colors py-2 px-3 rounded-full hover:bg-gray-100">
                                    <span>{{ Auth::user()->name }}</span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg ring-1 ring-black ring-opacity-5 py-1 z-50 transform origin-top-right focus:outline-none"
                                     style="display: none;">

                                    <div class="px-4 py-3 border-b border-gray-100">
                                        <p class="text-xs text-gray-500">Signed in as</p>
                                        <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->email }}</p>
                                    </div>

                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-brand-600 transition-colors">
                                        {{ __('Profile') }}
                                    </a>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                            {{ __('Log Out') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-3">
                                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-brand-600 transition-colors">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-bold text-white bg-brand-600 rounded-lg hover:bg-brand-700 shadow-md shadow-brand-500/30 transition-all hover:-translate-y-0.5 focus:ring-4 focus:ring-brand-500/30">
                                        Get Started
                                    </a>
                                @endif
                            </div>
                        @endauth
                    @endif
                </div>
            </div>
        </nav>
    </header>

    @php
        $isStaff = auth()->check() && (auth()->user()->role === 'staff' || auth()->user()->role === 'librarian');
        $staffType = auth()->check() ? auth()->user()->staff_type : null;
    @endphp

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-b from-brand-50 to-white pt-20 pb-32 overflow-hidden">
        <!-- Decoration -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
             <div class="absolute -top-[50%] -left-[10%] w-[50%] h-[100%] rounded-full bg-brand-200/20 blur-3xl"></div>
             <div class="absolute top-[20%] -right-[10%] w-[40%] h-[80%] rounded-full bg-accent-DEFAULT/5 blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            @if($isStaff)
                 <!-- Staff Edit Hint could go here -->
            @endif
            
            <h1 class="text-5xl md:text-7xl font-extrabold text-gray-900 tracking-tight mb-6">
                {{ $content['hero_title'] ?? 'Welcome to Our Library' }}
            </h1>
            <p class="max-w-2xl mx-auto text-xl text-gray-600 mb-10 leading-relaxed">
                {{ $content['hero_subtitle'] ?? 'Discover a world of knowledge and imagination. Explore our vast collection of books, resources, and community events.' }}
            </p>
            
            <div class="flex justify-center gap-4">
                <a href="#new-arrivals" class="px-8 py-4 text-base font-bold text-white bg-brand-600 rounded-xl hover:bg-brand-700 shadow-lg shadow-brand-500/40 transition-all hover:-translate-y-1">
                    Explore Books
                </a>
                <a href="#our-team" class="px-8 py-4 text-base font-bold text-brand-700 bg-brand-50 rounded-xl hover:bg-brand-100 transition-all hover:-translate-y-1">
                    Meet the Team
                </a>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-12 -mt-24 relative z-10 px-4">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-8">
            <!-- Vision -->
            <div class="bg-white/80 backdrop-blur-md p-8 rounded-2xl shadow-xl border border-white/50 relative overflow-hidden group hover:shadow-2xl transition-all duration-300">
                <div class="absolute top-0 right-0 w-32 h-32 bg-brand-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-150 duration-500"></div>
                <div class="relative">
                    <div class="w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center text-brand-600 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">Our Vision</h2>
                    <p class="text-gray-600 leading-relaxed">{{ $content['vision'] ?? 'To be a center of excellence in information provision.' }}</p>
                </div>
            </div>

            <!-- Mission -->
            <div class="bg-white/80 backdrop-blur-md p-8 rounded-2xl shadow-xl border border-white/50 relative overflow-hidden group hover:shadow-2xl transition-all duration-300">
                <div class="absolute top-0 right-0 w-32 h-32 bg-accent-DEFAULT/10 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-150 duration-500"></div>
                <div class="relative">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center text-accent-DEFAULT mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">Our Mission</h2>
                    <p class="text-gray-600 leading-relaxed">{{ $content['mission'] ?? 'To provide quality resources and services to our community.' }}</p>
                </div>
            </div>
        </div>
        
        @if($isStaff)
            <div class="text-center mt-8">
                <a href="{{ route('staff.site-content.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Edit Content
                </a>
            </div>
        @endif
    </section>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 w-full grid grid-cols-1 lg:grid-cols-12 gap-12">
        
        <!-- Left Sidebar: News -->
        <aside class="lg:col-span-4 space-y-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-accent-DEFAULT" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                        Latest News
                    </h2>
                    @if($isStaff && ($staffType == 'news' || !$staffType))
                        <a href="{{ route('staff.news.create') }}" class="text-xs font-bold text-brand-600 hover:bg-brand-50 px-3 py-1.5 rounded-lg transition-colors">
                            + Add News
                        </a>
                    @endif
                </div>

                <div class="space-y-6" id="news-feed">
                    @foreach($news as $item)
                        <article class="group relative pl-4 border-l-2 border-gray-100 hover:border-brand-500 transition-colors" data-id="{{ $item->id }}">
                            <div class="news-item-inner">
                                @if($isStaff && ($staffType == 'news' || !$staffType))
                                    <a href="{{ route('staff.news.edit', $item) }}" class="absolute -right-2 top-0 opacity-0 group-hover:opacity-100 bg-gray-900 text-white text-xs px-2 py-1 rounded shadow z-10">Edit</a>
                                @endif

                                @if($item->image)
                                    <div class="rounded-xl overflow-hidden mb-3 h-32 w-full">
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    </div>
                                @endif
                                <h3 class="font-bold text-gray-900 group-hover:text-brand-600 transition-colors">{{ $item->title }}</h3>
                                <time class="text-xs text-gray-400 block mb-2">{{ $item->published_date }}</time>
                                <p class="text-sm text-gray-600 line-clamp-3 leading-relaxed">{{ \Illuminate\Support\Str::limit($item->content, 120) }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </aside>

        <!-- Right Content: Books & Staff -->
        <div class="lg:col-span-8 space-y-16">
            
            <!-- New Arrivals -->
            <section id="new-arrivals">
                <div class="flex justify-between items-end mb-8">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900">New Arrivals</h2>
                        <p class="text-gray-500 mt-2">Fresh additions to our collection</p>
                    </div>
                    @if($isStaff && ($staffType == 'books' || !$staffType))
                        <a href="{{ route('staff.books.create') }}" class="inline-flex items-center px-4 py-2 bg-brand-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-700 shadow-lg shadow-brand-500/30 transition-all">
                            + Add Book
                        </a>
                    @endif
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6" id="books-grid">
                    @foreach($books as $book)
                        <div class="group relative bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300" data-id="{{ $book->id }}">
                            @if($isStaff && ($staffType == 'books' || !$staffType))
                                <a href="{{ route('staff.books.edit', $book) }}" class="absolute top-2 right-2 z-20 bg-black/70 text-white text-xs px-2 py-1 rounded backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity">Edit</a>
                            @endif
                            <div class="relative aspect-[2/3] overflow-hidden bg-gray-100">
                                <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : 'https://via.placeholder.com/300x450?text=No+Cover' }}" 
                                     alt="{{ $book->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                            <div class="p-4">
                                <p class="text-xs font-semibold text-brand-600 mb-1 uppercase tracking-wider">{{ $book->genre }}</p>
                                <h3 class="font-bold text-gray-900 leading-tight mb-1 truncate" title="{{ $book->title }}">{{ $book->title }}</h3>
                                <p class="text-sm text-gray-500">{{ $book->author }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Our Team -->
            <section id="our-team" class="pt-8 border-t border-gray-100">
                 <div class="flex justify-between items-end mb-10">
                    <div class="text-center md:text-left w-full">
                        <h2 class="text-3xl font-bold text-gray-900">Our Team</h2>
                        <p class="text-gray-500 mt-2">Meet the people behind the shelves</p>
                    </div>
                    @if($isStaff)
                        <a href="{{ route('staff.staff-profiles.create') }}" class="whitespace-nowrap ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition-all">
                            + Add Staff
                        </a>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="staff-grid">
                    @foreach($staff as $person)
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center hover:shadow-lg transition-shadow duration-300 relative group" data-id="{{ $person->id }}">
                             @if($isStaff)
                                <a href="{{ route('staff.staff-profiles.edit', $person) }}" class="absolute top-2 right-2 bg-gray-100 text-gray-600 hover:bg-gray-200 px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity">Edit</a>
                            @endif
                            <div class="w-24 h-24 mx-auto mb-4 relative">
                                <div class="absolute inset-0 bg-brand-100 rounded-full animate-pulse"></div>
                                <img src="{{ $person->image ? asset('storage/' . $person->image) : 'https://via.placeholder.com/150' }}" 
                                     alt="{{ $person->name }}" 
                                     class="w-full h-full object-cover rounded-full relative z-10 border-4 border-white shadow-md">
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $person->name }}</h3>
                            <p class="text-sm text-brand-600 font-medium mb-3">{{ $person->role_text }}</p>
                            <p class="text-sm text-gray-500 leading-relaxed">{{ $person->bio }}</p>
                        </div>
                    @endforeach
                </div>
            </section>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-500 text-sm">
                &copy; {{ date('Y') }} Library System. All rights reserved.
            </p>
            <div class="flex gap-6 text-gray-400">
                <a href="#" class="hover:text-brand-600 transition-colors"><span class="sr-only">Facebook</span><svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"/></svg></a>
                <a href="#" class="hover:text-brand-600 transition-colors"><span class="sr-only">Twitter</span><svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg></a>
            </div>
        </div>
    </footer>

    <!-- Logout Modal -->
    <x-logout-modal />

    <!-- Staff Helper Scripts -->
    @if($isStaff)
         <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Function to init sortable
                const initSortable = (elId, routeName) => {
                    const el = document.getElementById(elId);
                    if (el) {
                        new Sortable(el, {
                            animation: 150,
                            ghostClass: 'bg-brand-50',
                            onEnd: function (evt) {
                                const newOrder = Array.from(el.querySelectorAll('[data-id]')).map(item => item.getAttribute('data-id'));
                                fetch(routeName, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({ ids: newOrder })
                                })
                                .then(response => {
                                    if (!response.ok) alert('Failed to save new order.');
                                })
                                .catch(error => console.error('Error:', error));
                            }
                        });
                    }
                };

                initSortable('staff-grid', '{{ route("staff.staff-profiles.reorder") }}');
                initSortable('books-grid', '{{ route("staff.books.reorder") }}');
                initSortable('news-feed', '{{ route("staff.news.reorder") }}');
            });
        </script>
    @endif
</body>
</html>