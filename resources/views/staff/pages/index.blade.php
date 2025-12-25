<x-librarian-layout>
    <div class="p-8 bg-[#F8F7F4] min-h-screen">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <span
                    class="inline-block py-1 px-3 rounded-full bg-gray-900 text-white text-xs font-bold tracking-wide mb-2">ADMIN
                    PANEL</span>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">System Pages</h1>
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
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                <div class="flex-1 w-full md:max-w-md">
                    <input type="text" placeholder="Search pages..."
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition">
                </div>
                <div class="flex items-center gap-3">
                    <select
                        class="px-4 py-3 border border-gray-200 rounded-xl bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
                        <option>All Status</option>
                        <option>Published</option>
                        <option>Draft</option>
                    </select>
                    <a href="{{ route('staff.pages.create') }}"
                        class="flex items-center gap-2 px-5 py-3 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl transition shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        New Page
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-4 p-4 bg-brand-50 text-brand-700 rounded-xl border border-brand-100">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Title</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Slug</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Status</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Updated</th>
                            <th class="px-4 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @php
                            $colors = ['bg-indigo-500', 'bg-orange-500', 'bg-teal-500', 'bg-pink-500', 'bg-purple-500', 'bg-blue-500'];
                        @endphp
                        @forelse ($pages as $index => $page)
                            <tr class="hover:bg-gray-50/50 transition group">
                                <td class="px-4 py-5">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="h-10 w-10 rounded-lg {{ $colors[$index % count($colors)] }} flex items-center justify-center text-white font-bold text-sm shadow-sm">
                                            {{ strtoupper(substr($page->title, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800">{{ $page->title }}</p>
                                            <p class="text-xs text-gray-400">Created by {{ $page->user->name ?? 'Unknown' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-5">
                                    <span class="text-gray-500 text-sm">{{ $page->slug }}</span>
                                </td>
                                <td class="px-4 py-5">
                                    @if($page->is_published)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-brand-50 text-brand-600">
                                            <span class="w-2 h-2 mr-1.5 bg-brand-500 rounded-full"></span>
                                            Published
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500">
                                            Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-5">
                                    <span class="text-gray-500 text-sm">{{ $page->updated_at->format('M d, Y') }}</span>
                                </td>
                                <td class="px-4 py-5">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('staff.pages.edit', $page) }}"
                                            class="p-2 text-gray-400 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition"
                                            title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('pages.show', $page) }}" target="_blank"
                                            class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition"
                                            title="View">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('staff.pages.destroy', $page) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this page?');">
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
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <p class="font-medium">No pages found</p>
                                        <a href="{{ route('staff.pages.create') }}"
                                            class="mt-2 text-brand-500 hover:text-brand-600 font-bold">Create your first
                                            page</a>
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