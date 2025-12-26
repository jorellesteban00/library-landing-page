<x-app-layout>
    <div class="py-12 bg-[#F8F7F4] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Header -->
            <div class="flex justify-between items-center mb-10 px-4 sm:px-0">
                <div>
                    <h1 class="text-3xl font-black text-gray-900 tracking-tight">Welcome back, {{ Auth::user()->name }}!</h1>
                    <p class="text-gray-500 mt-2">Here's what's happening with your library account today.</p>
                </div>
                <a href="{{ route('home') }}" class="text-sm font-bold text-brand-600 hover:text-brand-700 flex items-center gap-1 bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Visit Homepage
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 px-4 sm:px-0">
                
                <!-- Main Content (Active Borrowings) -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100">
                        <div class="p-8">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    Active Loans
                                </h2>
                                <a href="{{ route('borrowings.index') }}" class="text-xs font-bold uppercase tracking-wider text-brand-600 hover:text-brand-700">View History</a>
                            </div>

                            @if($activeBorrowings->count() > 0)
                                <div class="space-y-4">
                                    @foreach($activeBorrowings as $loan)
                                        <div class="flex items-start gap-4 p-4 rounded-2xl bg-gray-50 border border-gray-100 hover:border-brand-200 transition-colors group">
                                            <!-- Book Cover Thumb -->
                                             <div class="w-16 h-20 bg-gray-200 rounded-lg overflow-hidden shrink-0 shadow-sm">
                                                @if($loan->book->cover_image)
                                                    <img src="{{ asset('storage/' . $loan->book->cover_image) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center bg-brand-100 text-brand-400">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div class="flex-1 min-w-0">
                                                <h3 class="font-bold text-gray-900 group-hover:text-brand-600 transition-colors truncate">{{ $loan->book->title }}</h3>
                                                <p class="text-sm text-gray-500 mb-2">{{ $loan->book->author }}</p>
                                                <div class="flex items-center gap-3 text-xs">
                                                     <span class="flex items-center gap-1 text-gray-500">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        Due: <span class="{{ $loan->due_date->isPast() ? 'text-red-600 font-bold' : 'font-medium' }}">{{ $loan->due_date->format('M d, Y') }}</span>
                                                     </span>
                                                     @if($loan->due_date->isPast())
                                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-600 uppercase tracking-wide">Overdue</span>
                                                     @else
                                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-600 uppercase tracking-wide">On Time</span>
                                                     @endif
                                                </div>
                                            </div>

                                            <div>
                                                 <form action="{{ route('borrowings.return', $loan) }}" method="POST" onsubmit="return confirm('Confirm return?')">
                                                     @csrf
                                                     @method('PATCH')
                                                     <button type="submit" class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Return Book">
                                                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                     </button>
                                                 </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                     <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                                         <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                     </div>
                                     <p class="text-gray-500 font-medium mb-4">You have no active loans.</p>
                                     <a href="{{ route('home') }}#books" class="inline-flex items-center px-4 py-2 bg-brand-600 text-white font-bold rounded-xl text-sm shadow-md hover:bg-brand-700 transition">
                                         Browse Books
                                     </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    </div>

                    <!-- New Arrivals -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100">
                        <div class="p-8">
                             <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2 mb-6">
                                <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                New Arrivals
                            </h2>
                            <div class="space-y-4">
                                @forelse($recentBooks as $book)
                                    <div class="flex gap-4 p-4 rounded-2xl bg-gray-50 hover:bg-white border border-transparent hover:border-gray-200 shadow-sm transition-all group">
                                         <div class="w-16 h-24 bg-gray-200 rounded-lg overflow-hidden shrink-0 shadow-sm">
                                            @if($book->cover_image)
                                                <img src="{{ asset('storage/' . $book->cover_image) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-brand-100 text-brand-400">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-bold text-gray-900 group-hover:text-brand-600 transition truncate">{{ $book->title }}</h3>
                                            <p class="text-sm text-gray-500 mb-2">{{ $book->author }}</p>
                                            <p class="text-xs text-gray-400 line-clamp-2">{{ Str::limit($book->description, 100) }}</p>
                                        </div>
                                        <div class="self-center">
                                            <a href="{{ route('books.show', $book) }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-brand-50 hover:text-brand-700 hover:border-brand-200 transition">
                                                View
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500">No new books available at the moment.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar (Quick Actions) -->
                <div class="space-y-6">
                    <!-- Profile Card -->
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                         <div class="flex items-center gap-4 mb-4">
                             @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-12 h-12 rounded-full object-cover">
                            @else
                                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center font-bold text-gray-500">{{ substr(Auth::user()->name, 0, 1) }}</div>
                            @endif
                            <div>
                                <h3 class="font-bold text-gray-900">{{ Auth::user()->name }}</h3>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">{{ Auth::user()->email }}</p>
                            </div>
                         </div>
                         <div class="grid grid-cols-1 gap-2">
                             <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-center text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-xl font-bold transition">
                                 Edit Profile
                             </a>
                         </div>
                    </div>

                    <!-- Helpful Links -->
                     <div class="bg-gradient-to-br from-brand-600 to-emerald-600 p-6 rounded-3xl shadow-lg text-white">
                         <h3 class="font-bold text-lg mb-2">Need Help?</h3>
                         <p class="text-brand-100 text-sm mb-4 leading-relaxed">Check out our library guide or contact support for assistance.</p>
                         <button disabled class="w-full py-3 bg-white/20 hover:bg-white/30 rounded-xl font-bold text-sm transition backdrop-blur-sm">
                             Contact Librarian
                         </button>
                     </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
