<x-librarian-layout>
    <div class="p-8 bg-[#F8F7F4] min-h-screen">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <span
                    class="inline-block py-1 px-3 rounded-full bg-brand-600 text-white text-xs font-bold tracking-wide mb-2">ADMIN/STAFF
                    PANEL</span>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">System Overview</h1>
            </div>
            <button type="button" @click="$dispatch('open-logout-modal')"
                class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-2 px-6 rounded-full transition shadow-lg">
                Sign Out
            </button>
        </div>

        <!-- Stats Grid Rank 1 -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Total Pages -->
            <div
                class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Total Pages</p>
                        <h3 class="text-4xl font-black text-gray-800">{{ $stats['total_pages'] }}</h3>
                        <p class="text-brand-500 text-sm font-bold mt-2">{{ $stats['published_pages'] }} Published</p>
                    </div>
                    <div class="p-3 bg-brand-50 rounded-xl">
                        <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- News Updates -->
            <div
                class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">News Updates</p>
                        <h3 class="text-4xl font-black text-gray-800">{{ $stats['total_news'] }}</h3>
                        <p class="text-brand-500 text-sm font-bold mt-2">Announcements</p>
                    </div>
                    <div class="p-3 bg-brand-50 rounded-xl">
                        <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Staff Members -->
            <div
                class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Staff Members</p>
                        <h3 class="text-4xl font-black text-gray-800">{{ $stats['total_staff'] }}</h3>
                        <p class="text-brand-500 text-sm font-bold mt-2">Active Profiles</p>
                    </div>
                    <div class="p-3 bg-brand-50 rounded-xl">
                        <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Grid Rank 2 -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Books -->
            <div
                class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Total Books</p>
                        <h3 class="text-4xl font-black text-gray-800">{{ $stats['total_books'] }}</h3>
                        <p class="text-brand-500 text-sm font-bold mt-2">In Collection</p>
                    </div>
                    <div class="p-3 bg-brand-50 rounded-xl">
                        <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Available Copies -->
            <div
                class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Available Copies</p>
                        <h3 class="text-4xl font-black text-gray-800">{{ $stats['copies_available'] }}</h3>
                        <p class="text-brand-500 text-sm font-bold mt-2">Ready to Borrow</p>
                    </div>
                    <div class="p-3 bg-brand-50 rounded-xl">
                        <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Currently Borrowed -->
            <div
                class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Currently Borrowed</p>
                        <h3 class="text-4xl font-black text-gray-800">{{ $stats['active_loans'] }}</h3>
                        <p class="text-orange-500 text-sm font-bold mt-2">Active Loans</p>
                    </div>
                    <div class="p-3 bg-orange-50 rounded-xl">
                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Layout 2 Columns: Recent Pages & Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Recent Pages Table -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Recent Pages</h3>
                    <a href="{{ route('staff.pages.index') }}"
                        class="text-sm font-bold text-brand-500 hover:text-brand-600 flex items-center">
                        View All <span class="ml-1">&rarr;</span>
                    </a>
                </div>

                <div class="divide-y divide-gray-100">
                    @php
                        $colors = ['bg-indigo-500', 'bg-orange-500', 'bg-teal-500', 'bg-pink-500', 'bg-purple-500', 'bg-blue-500'];
                    @endphp
                    @forelse($recentPages as $index => $page)
                        <div class="py-4 flex items-center justify-between group">
                            <div class="flex items-center gap-4">
                                <div
                                    class="h-10 w-10 rounded-lg {{ $colors[$index % count($colors)] }} flex items-center justify-center text-white font-bold text-sm shadow-sm">
                                    {{ strtoupper(substr($page->title, 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 group-hover:text-brand-600 transition">
                                        {{ $page->title }}
                                    </h4>
                                    <p class="text-xs text-gray-400 mt-1">Updated {{ $page->updated_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <div>
                                @if($page->is_published)
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-brand-50 text-brand-600">
                                        <span class="w-2 h-2 mr-1.5 bg-brand-500 rounded-full"></span> Published
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500">
                                        Draft
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="py-12 flex flex-col items-center justify-center text-center">
                            <svg class="w-12 h-12 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <p class="font-medium text-gray-500 mb-2">No pages found</p>
                            <a href="{{ route('staff.pages.create') }}"
                                class="text-brand-500 hover:text-brand-600 font-bold text-sm">Create your first page</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Quick Actions</h3>

                    <div class="space-y-3">
                        <a href="{{ route('staff.pages.create') }}"
                            class="block w-full text-left px-5 py-4 bg-white border border-gray-100 hover:border-brand-500 hover:shadow-md rounded-xl text-gray-700 hover:text-brand-600 font-bold transition flex items-center group">
                            <span
                                class="p-2 bg-blue-50 text-blue-600 rounded-lg mr-4 group-hover:bg-brand-50 group-hover:text-brand-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                            </span>
                            New Page
                        </a>

                        <a href="{{ route('staff.news.create') }}"
                            class="block w-full text-left px-5 py-4 bg-white border border-gray-100 hover:border-brand-500 hover:shadow-md rounded-xl text-gray-700 hover:text-brand-600 font-bold transition flex items-center group">
                            <span
                                class="p-2 bg-green-50 text-green-600 rounded-lg mr-4 group-hover:bg-brand-50 group-hover:text-brand-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                    </path>
                                </svg>
                            </span>
                            Post News
                        </a>

                        <a href="{{ route('staff.staff-profiles.create') }}"
                            class="block w-full text-left px-5 py-4 bg-white border border-gray-100 hover:border-brand-500 hover:shadow-md rounded-xl text-gray-700 hover:text-brand-600 font-bold transition flex items-center group">
                            <span
                                class="p-2 bg-purple-50 text-purple-600 rounded-lg mr-4 group-hover:bg-brand-50 group-hover:text-brand-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                    </path>
                                </svg>
                            </span>
                            Add Staff
                        </a>

                        <a href="{{ route('staff.books.create') }}"
                            class="block w-full text-left px-5 py-4 bg-white border border-gray-100 hover:border-brand-500 hover:shadow-md rounded-xl text-gray-700 hover:text-brand-600 font-bold transition flex items-center group">
                            <span
                                class="p-2 bg-indigo-50 text-indigo-600 rounded-lg mr-4 group-hover:bg-brand-50 group-hover:text-brand-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </span>
                            Add Book
                        </a>

                        <a href="{{ route('staff.menus.index') }}"
                            class="block w-full text-left px-5 py-4 bg-white border border-gray-100 hover:border-brand-500 hover:shadow-md rounded-xl text-gray-700 hover:text-brand-600 font-bold transition flex items-center group">
                            <span
                                class="p-2 bg-cyan-50 text-cyan-600 rounded-lg mr-4 group-hover:bg-brand-50 group-hover:text-brand-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </span>
                            Manage Navigation
                        </a>

                        <a href="{{ route('staff.site-content.index') }}"
                            class="block w-full text-left px-5 py-4 bg-white border border-gray-100 hover:border-brand-500 hover:shadow-md rounded-xl text-gray-700 hover:text-brand-600 font-bold transition flex items-center group">
                            <span
                                class="p-2 bg-emerald-50 text-emerald-600 rounded-lg mr-4 group-hover:bg-brand-50 group-hover:text-brand-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </span>
                            Edit Site Content
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-librarian-layout>