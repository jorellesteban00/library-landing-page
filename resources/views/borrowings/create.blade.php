<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Request to Borrow') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#FDFCF8] min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <a href="{{ route('books.show', $book) }}"
                class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-900 mb-8 transition font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Book Details
            </a>

            <div
                class="bg-white overflow-hidden shadow-xl sm:rounded-3xl border border-gray-100 grid grid-cols-1 md:grid-cols-3">

                <!-- Book Preview -->
                <div
                    class="p-8 bg-gray-50 md:col-span-1 border-r border-gray-100 flex flex-col items-center text-center">
                    <div class="w-40 aspect-[2/3] bg-white rounded-xl shadow-md overflow-hidden mb-6">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-brand-50 text-brand-200">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1 leading-tight">{{ $book->title }}</h3>
                    <p class="text-sm text-gray-500">{{ $book->author }}</p>
                </div>

                <!-- Borrow Form -->
                <div class="p-8 md:col-span-2">
                    <h3 class="text-2xl font-black text-gray-900 mb-6 tracking-tight">Request to Borrow</h3>

                    <form action="{{ route('borrowings.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">

                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 mb-6">
                            <p class="text-blue-800 text-sm font-medium">
                                <span class="font-bold">Note:</span> Your request will be sent to the library staff for
                                approval. You will be notified once it's approved.
                            </p>
                        </div>

                        <div>
                            <label for="due_date" class="block text-sm font-bold text-gray-700 mb-2">Select Return
                                Date</label>
                            <input type="date" name="due_date" id="due_date"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition"
                                min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                value="{{ date('Y-m-d', strtotime('+14 days')) }}" required>
                            <p class="text-xs text-gray-400 mt-2">Standard borrowing period is 14 days.</p>
                        </div>

                        <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-4">
                            <a href="{{ route('books.show', $book) }}"
                                class="px-6 py-3 font-bold text-gray-500 hover:text-gray-800 transition">Cancel</a>
                            <button type="submit"
                                class="px-8 py-3 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl transition shadow-lg shadow-brand-500/30 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Submit Request
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>