<x-app-layout>
    <div class="py-12 bg-[#F8F7F4] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header & Search -->
            <div class="mb-8 px-4 sm:px-0">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center gap-2 text-brand-600 hover:text-brand-700 font-medium mb-3 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Dashboard
                        </a>
                        <h1 class="text-3xl font-black text-gray-900 tracking-tight">Library Catalogue</h1>
                        <p class="text-gray-500 mt-2">Explore our vast collection of books.</p>
                    </div>
                </div>

                <!-- Search Form -->
                <div class="mt-8 bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
                    <form action="{{ route('books.catalogue') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                        <div class="w-full md:w-48">
                            <div class="relative">
                                <select name="genre"
                                    class="w-full pl-4 pr-10 py-3 bg-gray-50 border-transparent focus:bg-white focus:border-brand-300 focus:ring focus:ring-brand-200/50 rounded-xl transition-all h-[50px]"
                                    style="appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 24 24%27 stroke=%27%239ca3af%27%3e%3cpath stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%272%27 d=%27M19 9l-7 7-7-7%27/%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1.25rem;">
                                    <option value="">All Genres</option>
                                    @foreach($genres as $genre)
                                        <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>
                                            {{ $genre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="w-full md:w-72 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 {{ request('search') ? 'text-brand-500' : 'text-gray-400' }}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search by title, author, isbn..."
                                class="w-full pl-10 pr-4 py-3 bg-gray-50 border-transparent focus:bg-white focus:border-brand-300 focus:ring focus:ring-brand-200/50 rounded-xl transition-all h-[50px] {{ request('search') ? 'bg-white border-brand-300 ring ring-brand-200/50' : '' }}">
                        </div>
                        <button type="submit"
                            class="px-8 py-3 bg-brand-600 text-white font-bold rounded-xl shadow-md hover:bg-brand-700 hover:shadow-lg transition-all transform hover:-translate-y-0.5 h-[50px]">
                            Filter
                        </button>
                        @if(request('search') || request('genre'))
                            <a href="{{ route('books.catalogue') }}"
                                class="px-6 py-3 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-colors flex items-center justify-center h-[50px]">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Books Grid -->
            <div
                class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 px-4 sm:px-0">
                @forelse($books as $book)
                    <a href="{{ route('books.show', $book) }}"
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow group flex flex-col h-full">
                        <!-- Cover Image -->
                        <div class="aspect-[2/3] bg-gray-100 relative overflow-hidden">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-brand-50 text-brand-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-3">
                                <span
                                    class="text-white text-xs font-bold truncate w-full">{{ $book->genre ?? 'General' }}</span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-3 flex-1 flex flex-col">
                            <h3 class="text-sm font-bold text-gray-900 leading-tight mb-1 group-hover:text-brand-600 transition-colors line-clamp-2"
                                title="{{ $book->title }}">
                                {{ $book->title }}
                            </h3>
                            <p class="text-xs text-gray-500 mb-3 truncate">{{ $book->author }}</p>

                            <div class="mt-auto flex items-center justify-between">
                                <div class="flex items-center gap-1.5">
                                    @if($book->available_quantity > 0)
                                        <span
                                            class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-md bg-green-50 text-green-700 text-[10px] font-bold">
                                            <span class="w-1 h-1 rounded-full bg-green-500"></span>
                                            Available
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-md bg-red-50 text-red-700 text-[10px] font-bold">
                                            <span class="w-1 h-1 rounded-full bg-red-500"></span>
                                            Unavailable
                                        </span>
                                    @endif
                                </div>
                                <div class="p-1.5 text-brand-600 hover:bg-brand-50 rounded-lg transition-colors"
                                    title="View Details">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-12 text-center">
                        <div
                            class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">No books found</h3>
                        <p class="text-gray-500">Try adjusting your search filters.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8 px-4 sm:px-0">
                {{ $books->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>