<x-librarian-layout>
    <div class="p-8 bg-[#F8F7F4] min-h-screen" x-data="{ showDeleteModal: false, deleteUrl: '' }">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <span
                    class="inline-block py-1 px-3 rounded-full bg-gray-900 text-white text-xs font-bold tracking-wide mb-2">ADMIN
                    PANEL</span>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Staff Members</h1>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-2 px-6 rounded-full transition shadow-lg">
                    Sign Out
                </button>
            </form>
        </div>

        @if (session('status'))
            <div class="mb-6 p-4 bg-brand-50 text-brand-700 rounded-xl border border-brand-100 flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('status') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            <!-- Add New Card -->
            <a href="{{ route('staff.staff-profiles.create') }}"
                class="group flex flex-col items-center justify-center h-full min-h-[300px] border-2 border-dashed border-brand-200 hover:border-brand-500 rounded-2xl bg-brand-50/50 hover:bg-brand-50 transition p-6 cursor-pointer">
                <div
                    class="h-16 w-16 bg-white rounded-full flex items-center justify-center text-brand-400 group-hover:text-brand-600 group-hover:scale-110 transition shadow-sm mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-brand-700">Add Staff Member</h3>
                <p class="text-sm text-brand-400 mt-1">Create a new profile</p>
            </a>

            <!-- Staff Cards -->
            @foreach($staffProfiles as $profile)
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center hover:shadow-md transition group h-full">
                    <div class="relative mb-4">
                        <div class="h-24 w-24 rounded-full overflow-hidden border-4 border-gray-50 shadow-inner">
                            @if($profile->image)
                                <img src="{{ asset('storage/' . $profile->image) }}" class="h-full w-full object-cover">
                            @else
                                <div class="h-full w-full bg-gray-200 flex items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <!-- Status Dot (Optional visual) -->
                        <span
                            class="absolute bottom-1 right-1 h-4 w-4 bg-green-500 border-2 border-white rounded-full"></span>
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $profile->name }}</h3>
                    <p class="text-sm font-bold text-brand-500 bg-brand-50 px-3 py-1 rounded-full mb-3">
                        {{ $profile->role_text }}
                    </p>

                    <div class="flex-1 w-full border-t border-gray-50 pt-4 mt-2">
                        <p class="text-sm text-gray-500 line-clamp-3 mb-4">
                            {{ $profile->bio ?? 'No biography available.' }}
                        </p>
                    </div>

                    <div class="w-full flex items-center justify-between gap-2 mt-auto pt-4 border-t border-gray-100">
                        <a href="{{ route('staff.staff-profiles.edit', $profile) }}"
                            class="flex-1 py-2 text-sm font-bold text-gray-600 hover:text-brand-600 hover:bg-gray-50 rounded-lg transition">Edit</a>
                        <button
                            @click="showDeleteModal = true; deleteUrl = '{{ route('staff.staff-profiles.destroy', $profile) }}'"
                            class="flex-1 py-2 text-sm font-bold text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                            Delete
                        </button>
                    </div>
                </div>
            @endforeach

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
                    <p class="text-gray-600 mb-8">Are you sure you want to delete this staff profile? This action cannot
                        be undone.</p>
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