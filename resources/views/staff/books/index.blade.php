<x-librarian-layout>
    <div class="p-8 bg-[#F8F7F4] min-h-screen" x-data="{ showDeleteModal: false, deleteUrl: '' }">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <span
                    class="inline-block py-1 px-3 rounded-full bg-brand-600 text-white text-xs font-bold tracking-wide mb-2">ADMIN/STAFF
                    PANEL</span>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Books</h1>
            </div>
            <button type="button" @click="$dispatch('open-logout-modal')"
                class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-2 px-6 rounded-full transition shadow-lg">
                Sign Out
            </button>
        </div>

        <!-- Content Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

            <!-- Search and Action Buttons -->
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                <div class="flex-1 w-full md:max-w-md">
                    <form action="{{ route('staff.books.index') }}" method="GET">
                        <div class="relative flex gap-2">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search books..."
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition bg-gray-50">
                            <button type="submit"
                                class="px-4 py-3 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl transition">
                                Search
                            </button>
                            @if(request('search'))
                                <a href="{{ route('staff.books.index') }}"
                                    class="px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold rounded-xl transition">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('staff.borrowings.pending') }}"
                        class="px-5 py-3 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold rounded-xl transition shadow-sm flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                        Pending Requests
                    </a>
                    <a href="{{ route('staff.borrowings.index') }}"
                        class="px-5 py-3 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl transition shadow-sm flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        Active Loans <span
                            class="bg-white text-brand-500 rounded-full px-2 py-0.5 text-xs ml-1">{{ $activeLoansCount }}</span>
                    </a>
                    <a href="{{ route('staff.books.create') }}"
                        class="px-5 py-3 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl transition shadow-md flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Add Book
                    </a>
                </div>
            </div>

            @if (session('status'))
                <div class="mb-4 p-4 bg-brand-50 text-brand-700 rounded-xl border border-brand-100">
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
                                Author</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Category</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Availability</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Status</th>
                            <th class="px-4 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($books as $book)
                            <tr class="hover:bg-gray-50/50 transition group">
                                <td class="px-4 py-5">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="h-12 w-10 bg-gray-200 rounded flex items-center justify-center text-gray-400 shadow-sm overflow-hidden">
                                            @if($book->cover_image)
                                                <img src="{{ asset('storage/' . $book->cover_image) }}"
                                                    class="h-full w-full object-cover">
                                            @else
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                                    </path>
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800">{{ $book->title }}</p>
                                            <p class="text-xs text-gray-400">ISBN: {{ $book->isbn ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-5">
                                    <span class="text-gray-600 text-sm">{{ $book->author }}</span>
                                </td>
                                <td class="px-4 py-5">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700">
                                        {{ $book->genre ?? 'General' }}
                                    </span>
                                </td>
                                <td class="px-4 py-5">
                                    <span class="text-gray-800 font-bold text-sm">{{ $book->available_quantity }} /
                                        {{ $book->total_quantity }}</span>
                                </td>
                                <td class="px-4 py-5">
                                    @if($book->status === 'available')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-brand-50 text-brand-600">
                                            <span class="w-2 h-2 mr-1.5 bg-brand-500 rounded-full"></span>
                                            Published
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-50 text-yellow-600">
                                            <span class="w-2 h-2 mr-1.5 bg-yellow-500 rounded-full"></span>
                                            {{ ucfirst($book->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-5">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('staff.books.edit', $book) }}"
                                            class="p-2 text-gray-400 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition"
                                            title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                        </a>
                                        <button
                                            @click="showDeleteModal = true; deleteUrl = '{{ route('staff.books.destroy', $book) }}'"
                                            class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition"
                                            title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-12 text-center text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 mb-4 text-gray-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                            </path>
                                        </svg>
                                        <p class="font-medium">No books found</p>
                                        <a href="{{ route('staff.books.create') }}"
                                            class="mt-2 text-brand-500 hover:text-brand-600 font-bold">Add your first
                                            book</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div x-show="showDeleteModal" style="background-color: rgba(0, 0, 0, 0.5); display: none;"
            class="fixed inset-0 z-[100] flex items-center justify-center backdrop-blur-sm"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>

            <!-- Modal Panel -->
            <div class="bg-white rounded-xl shadow-2xl p-8 max-w-sm w-full mx-4 transform transition-all"
                @click.away="showDeleteModal = false" x-show="showDeleteModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <div class="flex items-center justify-center mb-6">
                    <div class="h-12 w-12 rounded-full bg-red-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                </div>

                <div class="text-center">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Confirm Delete</h3>
                    <p class="text-gray-600 mb-8">Are you sure you want to delete this book? This action cannot be
                        undone.</p>
                </div>

                <div class="flex justify-end space-x-3">
                    <button @click="showDeleteModal = false"
                        class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Cancel
                    </button>

                    <form :action="deleteUrl" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-5 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow-lg shadow-red-200 transition-all focus:outline-none focus:ring-2 focus:ring-red-500">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-librarian-layout>