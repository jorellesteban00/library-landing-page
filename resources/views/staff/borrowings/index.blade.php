<x-librarian-layout>
    <div class="p-8 bg-[#F8F7F4] min-h-screen" x-data="{ showReturnModal: false, returnUrl: '' }">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <a href="{{ route(Auth::user()->role === 'librarian' ? 'librarian.dashboard' : 'staff.dashboard') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 text-sm mb-4 group">
                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Back to Dashboard
                </a>
                <span class="inline-block py-1 px-3 rounded-full bg-brand-600 text-white text-xs font-bold tracking-wide mb-2">ADMIN/STAFF PANEL</span>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Manage Borrowings</h1>
                <p class="text-gray-500 mt-2">Track issued books, process returns, and view history</p>
            </div>
            <div class="flex gap-3">
                 <!-- Maybe a "New Issue" button linking to Members or Book list? 
                      Currently issuing is done via Book page by user or manually. 
                      Let's leave it as is for now. -->
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
             <!-- Filters / Toolbar could go here -->
             
             @if($borrowings->isEmpty())
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">No Borrowings Found</h3>
                    <p class="text-gray-500">There are no active or historic borrowing records.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider">Member</th>
                                <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider">Book Details</th>
                                <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider">Dates</th>
                                <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Status</th>
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
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="text-sm space-y-1">
                                            @if($borrowing->status === 'pending')
                                                <div class="flex items-center gap-2 text-gray-600">
                                                    <span class="text-xs uppercase tracking-wide text-gray-400 w-14">Requested</span>
                                                    <span class="font-medium">{{ $borrowing->created_at->format('M d, Y') }}</span>
                                                </div>
                                            @else
                                                <div class="flex items-center gap-2 text-gray-600">
                                                    <span class="text-xs uppercase tracking-wide text-gray-400 w-14">Issued</span>
                                                    <span class="font-medium">{{ $borrowing->borrowed_at?->format('M d, Y') ?? '-' }}</span>
                                                </div>
                                            @endif
                                            <div class="flex items-center gap-2 {{ $borrowing->due_date->isPast() && $borrowing->status === 'borrowed' ? 'text-red-600 font-bold' : 'text-gray-600' }}">
                                                <span class="text-xs uppercase tracking-wide text-gray-400 w-14">Due</span>
                                                <span class="font-medium">{{ $borrowing->due_date->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                         @if($borrowing->status === 'pending')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Pending
                                            </span>
                                        @elseif($borrowing->status === 'rejected')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Rejected
                                            </span>
                                        @elseif($borrowing->status === 'returned')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Returned
                                            </span>
                                            <div class="text-[10px] text-gray-400 mt-1 uppercase tracking-wide">
                                                {{ $borrowing->returned_at ? $borrowing->returned_at->format('M d') : '-' }}
                                            </div>
                                        @elseif($borrowing->due_date->isPast())
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Overdue
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Active
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        @if($borrowing->status === 'pending')
                                            <div class="flex items-center justify-end gap-2">
                                                <form action="{{ route('staff.borrowings.approve', $borrowing) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-bold text-sm rounded-xl transition-all shadow-sm">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                        Approve
                                                    </button>
                                                </form>
                                                <form action="{{ route('staff.borrowings.reject', $borrowing) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-white border-2 border-red-100 text-red-600 hover:bg-red-50 hover:border-red-200 font-bold text-sm rounded-xl transition-all shadow-sm">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        Reject
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($borrowing->status === 'borrowed')
                                            <button 
                                                @click="showReturnModal = true; returnUrl = '{{ route('borrowings.return', $borrowing) }}'"
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-white border-2 border-green-100 text-green-600 hover:bg-green-50 hover:border-green-200 hover:text-green-700 font-bold text-sm rounded-xl transition-all shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Mark Returned
                                            </button>
                                        @else
                                            <span class="text-gray-300">
                                                <svg class="w-6 h-6 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </span>
                                        @endif
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


    <!-- Return Book Modal -->
    <div x-show="showReturnModal" 
            style="background-color: rgba(0, 0, 0, 0.5); display: none;" 
            class="fixed inset-0 z-[100] flex items-center justify-center backdrop-blur-sm"
            x-show="showReturnModal"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-cloak>
        
        <!-- Modal Panel -->
        <div class="bg-white rounded-xl shadow-2xl p-8 max-w-sm w-full mx-4 transform transition-all"
                @click.away="showReturnModal = false"
                x-show="showReturnModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            <div class="flex items-center justify-center mb-6">
                <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            
            <div class="text-center">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Confirm Return</h3>
                <p class="text-gray-600 mb-8">Are you sure you want to mark this book as returned? The stock count will be updated immediately.</p>
            </div>

            <div class="flex justify-end space-x-3">
                <button @click="showReturnModal = false" 
                        class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Cancel
                </button>
                
                <form :action="returnUrl" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="px-5 py-2.5 text-sm font-semibold text-white bg-green-600 hover:bg-green-700 rounded-lg shadow-lg shadow-green-200 transition-all focus:outline-none focus:ring-2 focus:ring-green-500">
                        Confirm Return
                    </button>
                </form>
            </div>
        </div>
    </div>
    </div>
</x-librarian-layout>
