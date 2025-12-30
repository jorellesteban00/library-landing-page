<x-librarian-layout>
    <div class="p-8 bg-[#F8F7F4] min-h-screen">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <span
                    class="inline-block py-1 px-3 rounded-full bg-gray-900 text-white text-xs font-bold tracking-wide mb-2">ADMIN/STAFF
                    PANEL</span>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">News</h1>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-2 px-6 rounded-full transition shadow-lg">
                    Sign Out
                </button>
            </form>
        </div>

        <!-- Content Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

            <!-- Search and Filters -->
            <div class="flex justify-between items-center gap-4 mb-6">
                <div class="flex-1 max-w-md">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <input type="text" placeholder="Search news..."
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition bg-gray-50 text-sm">
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('staff.news.create') }}"
                        class="flex items-center gap-2 px-5 py-3 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl transition shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Create News
                    </a>
                </div>
            </div>

            @if (session('status'))
                <div class="mb-4 p-4 bg-brand-50 text-brand-700 rounded-xl border border-brand-100 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th
                                class="px-4 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider w-1/3">
                                Title</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Status</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Author</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Date</th>
                            <th class="px-4 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($newsItems as $news)
                            <tr class="hover:bg-gray-50/50 transition group">
                                <td class="px-4 py-5">
                                    <div>
                                        <p class="font-bold text-gray-800 mb-1">{{ $news->title }}</p>
                                        <p class="text-xs text-gray-400 line-clamp-1">
                                            {{ Str::limit(strip_tags($news->content), 80) }}
                                        </p>
                                    </div>
                                </td>
                                <td class="px-4 py-5">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-brand-50 text-brand-600">
                                        <span class="w-2 h-2 mr-1.5 bg-brand-500 rounded-full"></span>
                                        Published
                                    </span>
                                </td>
                                <td class="px-4 py-5">
                                    <span
                                        class="text-gray-600 text-sm font-medium">{{ $news->user->name ?? 'Unknown' }}</span>
                                </td>
                                <td class="px-4 py-5">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-gray-600 text-sm font-medium">{{ $news->created_at->format('M d, Y') }}</span>
                                        <span class="text-gray-400 text-xs">{{ $news->created_at->format('H:i') }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-5">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('staff.news.edit', $news) }}"
                                            class="p-2 text-gray-400 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition"
                                            title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('staff.news.destroy', $news) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this news item?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition"
                                                title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-12 text-center text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 mb-4 text-gray-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                                            </path>
                                        </svg>
                                        <p class="font-medium">No news items found</p>
                                        <a href="{{ route('staff.news.create') }}"
                                            class="mt-2 text-brand-500 hover:text-brand-600 font-bold">Create your first
                                            news item</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-librarian-layout>