<x-librarian-layout>
    <div class="p-8 bg-[#F8F7F4] min-h-screen">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <a href="{{ route('staff.books.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 text-sm mb-4 group">
                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Back to Books
                </a>
                <span class="inline-block py-1 px-3 rounded-full bg-yellow-400 text-yellow-900 text-xs font-bold tracking-wide mb-2">ACTION REQUIRED</span>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Pending Requests</h1>
                <p class="text-gray-500 mt-2">Approve or reject book borrowing requests</p>
            </div>
            <div class="flex gap-3">
                 <a href="{{ route('staff.borrowings.index') }}" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 font-bold rounded-xl transition shadow-sm">
                    View All History
                 </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
             <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Borrowings Table Card -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
             
             @if($borrowings->isEmpty())
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">No Pending Requests</h3>
                    <p class="text-gray-500">All caught up! There are no new borrowing requests.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider">Member</th>
                                <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider">Book Requested</th>
                                <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider">Request Date</th>
                                <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($borrowings as $borrowing)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-full bg-brand-100 flex items-center justify-center text-brand-700 font-bold shrink-0">
                                                {{ substr($borrowing->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-900">{{ $borrowing->user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $borrowing->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-14 bg-gray-200 rounded shadow-sm overflow-hidden shrink-0">
                                                 @if($borrowing->book->cover_image)
                                                    <img src="{{ asset('storage/' . $borrowing->book->cover_image) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-300">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-900 line-clamp-1">{{ $borrowing->book->title }}</div>
                                                <div class="text-sm text-gray-500 line-clamp-1">{{ $borrowing->book->author }}</div>
                                                <div class="mt-1 text-xs text-brand-600 bg-brand-50 px-2 py-0.5 rounded-full inline-block">{{ $borrowing->book->available_quantity }} available</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="text-sm space-y-1">
                                            <div class="flex items-center gap-2 text-gray-600">
                                                <span class="font-medium">{{ $borrowing->created_at->format('M d, Y') }}</span>
                                                <span class="text-gray-400">({{ $borrowing->created_at->diffForHumans() }})</span>
                                            </div>
                                            <div class="flex items-center gap-2 text-gray-600">
                                                <span class="text-xs uppercase tracking-wide text-gray-400">Target Return:</span>
                                                <span class="font-medium">{{ $borrowing->due_date->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <form action="{{ route('staff.borrowings.approve', $borrowing) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-500 hover:bg-green-600 text-white font-bold text-sm rounded-xl transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('staff.borrowings.reject', $borrowing) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border-2 border-red-100 text-red-600 hover:bg-red-50 hover:border-red-200 font-bold text-sm rounded-xl transition-all shadow-sm hover:shadow-md">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-6 border-t border-gray-100 bg-gray-50">
                    {{ $borrowings->links() }}
                </div>
            @endif
        </div>

    </div>
</x-librarian-layout>
