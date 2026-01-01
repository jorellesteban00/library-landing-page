<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Library CMS') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/translation-widget.js'])
</head>

<body class="font-sans antialiased bg-[#F8F7F4]" x-data>
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside
            class="w-64 flex-shrink-0 bg-[#F2F0EB] text-gray-600 flex flex-col justify-between border-r border-gray-200">
            <!-- Brand -->
            <div class="p-6">
                <!-- AddLib Logo -->
                <div class="flex items-center gap-3">
                    <div class="bg-brand-100 p-2 rounded-lg text-brand-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.292a8.96 8.96 0 00-6-2.292c-1.052 0-2.062.18-3 .512v14.25c.938-.332 1.948-.512 3-.512 2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25c-.938-.332-1.948-.512-3-.512-2.305 0-4.408.867-6 2.292m0-14.25v14.25">
                            </path>
                        </svg>
                    </div>
                    <span class="text-2xl font-black tracking-tight leading-none text-gray-900">
                        <span class="text-brand-600">Verde</span>Lib<span class="text-brand-500">.</span>
                    </span>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
                <a href="{{ route('home') }}"
                    class="flex items-center px-4 py-3 hover:bg-white hover:text-gray-900 rounded-xl transition-all group text-gray-500">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span class="font-medium">Home</span>
                </a>

                @php
                    $dashboardRoute = Auth::user()->role === 'staff' ? 'staff.dashboard' : 'librarian.dashboard';
                @endphp
                <a href="{{ route($dashboardRoute) }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs($dashboardRoute) ? 'bg-white text-brand-600 shadow-sm' : 'hover:bg-white hover:text-gray-900' }} rounded-xl transition-all group">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                <!-- Borrowings (Visible to Staff & Librarian) -->
                @if(Auth::user()->role === 'librarian' || Auth::user()->staff_type !== 'news')
                    <a href="{{ route('staff.borrowings.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('staff.borrowings.*') ? 'bg-white text-brand-600 shadow-sm' : 'hover:bg-white hover:text-gray-900' }} rounded-xl transition-all group">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        <span class="font-medium">Borrowings</span>
                    </a>
                @endif

                <!-- Checkouts/Books (Visible to All) -->
                @if(Auth::user()->role === 'librarian' || Auth::user()->staff_type !== 'news')
                    <a href="{{ route('staff.books.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('staff.books.*') ? 'bg-white text-brand-600 shadow-sm' : 'hover:bg-white hover:text-gray-900' }} rounded-xl transition-all group">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        <span class="font-medium">Books</span>
                    </a>
                @endif

                <!-- News Link (Visible to All) -->
                @if(Auth::user()->role === 'librarian' || Auth::user()->staff_type !== 'books')
                    <a href="{{ route('staff.news.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('staff.news.*') ? 'bg-white text-brand-600 shadow-sm' : 'hover:bg-white hover:text-gray-900' }} rounded-xl transition-all group">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                            </path>
                        </svg>
                        <span class="font-medium">News</span>
                    </a>
                @endif

                @if(Auth::user()->role === 'librarian')
                    <div class="px-4 py-2 mt-4 text-xs font-bold text-gray-400 uppercase tracking-wider">
                        Management
                    </div>

                    <a href="{{ route('staff.pages.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('staff.pages.*') ? 'bg-white text-brand-600 shadow-sm' : 'hover:bg-white hover:text-gray-900' }} rounded-xl transition-all group">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <span class="font-medium">Pages</span>
                    </a>

                    <a href="{{ route('staff.menus.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('staff.menus.*') ? 'bg-white text-brand-600 shadow-sm' : 'hover:bg-white hover:text-gray-900' }} rounded-xl transition-all group">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <span class="font-medium">Menus</span>
                    </a>

                    <a href="{{ route('staff.staff-profiles.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('staff.staff-profiles.*') ? 'bg-white text-brand-600 shadow-sm' : 'hover:bg-white hover:text-gray-900' }} rounded-xl transition-all group">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        <span class="font-medium">Staff Profiles</span>
                    </a>

                    <a href="{{ route('librarian.accounts.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('librarian.accounts.*') ? 'bg-white text-brand-600 shadow-sm' : 'hover:bg-white hover:text-gray-900' }} rounded-xl transition-all group">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        <span class="font-medium">Accounts</span>
                    </a>

                    <a href="{{ route('staff.resources.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('staff.resources.*') ? 'bg-white text-brand-600 shadow-sm' : 'hover:bg-white hover:text-gray-900' }} rounded-xl transition-all group">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                            </path>
                        </svg>
                        <span class="font-medium">Resources</span>
                    </a>

                    <a href="{{ route('staff.site-content.index') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('staff.site-content.*') ? 'bg-white text-brand-600 shadow-sm' : 'hover:bg-white hover:text-gray-900' }} rounded-xl transition-all group">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        <span class="font-medium">Site Content</span>
                    </a>
                @endif
            </nav>

            <!-- User -->
            <div class="px-6 py-4 border-t border-gray-200">
                <div class="flex items-center mb-4">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}"
                            class="h-10 w-10 rounded-full object-cover">
                    @else
                        <div
                            class="h-10 w-10 rounded-full bg-brand-500 flex items-center justify-center text-white font-bold text-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="ml-3">
                        <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                    </div>
                </div>

                <div class="space-y-1">
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center text-sm text-gray-500 hover:text-gray-900 py-1">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Account Settings
                    </a>

                    <button @click="$dispatch('open-logout-modal')"
                        class="w-full flex items-center text-sm text-red-600 hover:text-red-700 hover:bg-red-50 py-2 px-3 rounded-lg transition-colors font-medium cursor-pointer">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H3"></path>
                        </svg>
                        Sign Out
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 h-full overflow-y-auto">
            {{ $slot }}
        </main>
    </div>

    <x-logout-modal />
</body>

</html>