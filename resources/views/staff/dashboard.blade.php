<x-librarian-layout>
    <div class="p-8 bg-[#F8F7F4] min-h-screen">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <span
                    class="inline-block py-1 px-3 rounded-full bg-brand-600 text-white text-xs font-bold tracking-wide mb-2">STAFF
                    PANEL</span>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Welcome back, {{ Auth::user()->name }}!
                </h1>
                <p class="text-gray-500 mt-1">Manage your library content from here.</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-2 px-6 rounded-full transition shadow-lg">
                    Sign Out
                </button>
            </form>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Pages -->
            <a href="{{ route('staff.pages.index') }}"
                class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition group">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Pages</p>
                        <h3 class="text-3xl font-black text-gray-800">{{ \App\Models\Page::count() }}</h3>
                        <p class="text-brand-500 text-sm font-bold mt-2 group-hover:underline">Manage →</p>
                    </div>
                    <div class="p-3 bg-brand-50 rounded-xl">
                        <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- News -->
            <a href="{{ route('staff.news.index') }}"
                class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition group">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">News</p>
                        <h3 class="text-3xl font-black text-gray-800">{{ \App\Models\NewsItem::count() }}</h3>
                        <p class="text-emerald-500 text-sm font-bold mt-2 group-hover:underline">Manage →</p>
                    </div>
                    <div class="p-3 bg-emerald-50 rounded-xl">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                            </path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Books -->
            <a href="{{ route('staff.books.index') }}"
                class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition group">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Books</p>
                        <h3 class="text-3xl font-black text-gray-800">{{ \App\Models\Book::count() }}</h3>
                        <p class="text-blue-500 text-sm font-bold mt-2 group-hover:underline">Manage →</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-xl">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Staff -->
            <a href="{{ route('staff.staff-profiles.index') }}"
                class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition group">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Staff</p>
                        <h3 class="text-3xl font-black text-gray-800">{{ \App\Models\StaffProfile::count() }}</h3>
                        <p class="text-purple-500 text-sm font-bold mt-2 group-hover:underline">Manage →</p>
                    </div>
                    <div class="p-3 bg-purple-50 rounded-xl">
                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </a>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Activity Card -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Quick Actions
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('staff.news.create') }}"
                        class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-brand-50 transition group">
                        <div class="p-2 bg-brand-100 rounded-lg mr-4 group-hover:bg-brand-200 transition">
                            <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">Add News Article</p>
                            <p class="text-sm text-gray-500">Create a new announcement</p>
                        </div>
                    </a>
                    <a href="{{ route('staff.books.create') }}"
                        class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-blue-50 transition group">
                        <div class="p-2 bg-blue-100 rounded-lg mr-4 group-hover:bg-blue-200 transition">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">Add New Book</p>
                            <p class="text-sm text-gray-500">Add a book to the collection</p>
                        </div>
                    </a>
                    <a href="{{ route('staff.site-content.index') }}"
                        class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-purple-50 transition group">
                        <div class="p-2 bg-purple-100 rounded-lg mr-4 group-hover:bg-purple-200 transition">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">Edit Site Content</p>
                            <p class="text-sm text-gray-500">Update vision, mission, hero text</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- View Website Card -->
            <div
                class="bg-gradient-to-br from-brand-600 to-emerald-600 rounded-2xl p-6 shadow-lg text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-12 -mb-12"></div>

                <div class="relative z-10">
                    <h3 class="text-xl font-bold mb-2">View Your Website</h3>
                    <p class="text-white/80 mb-6">See how your changes look on the live site.</p>

                    <a href="{{ route('home') }}" target="_blank"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-white text-brand-600 font-bold rounded-xl hover:bg-gray-100 transition shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        Open Website
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-librarian-layout>