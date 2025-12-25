<x-librarian-layout>
    <div class="p-8 bg-[#F8F7F4] min-h-screen">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <span
                    class="inline-block py-1 px-3 rounded-full bg-gray-900 text-white text-xs font-bold tracking-wide mb-2">ADMIN
                    PANEL</span>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Navigation Menus</h1>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-2 px-6 rounded-full transition shadow-lg">
                    Sign Out
                </button>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <div class="flex justify-between items-end mb-6">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Menu Structure</h2>
                    <p class="text-gray-500 text-sm mt-1">Organize and manage your website navigation</p>
                </div>
                <a href="{{ route('staff.menus.create') }}"
                    class="px-5 py-3 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl transition shadow-md flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    New Menu Item
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-brand-50 text-brand-700 rounded-xl border border-brand-100 flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-4">
                @forelse($menus as $menu)
                    <div
                        class="flex items-center justify-between p-5 bg-white border border-gray-100 rounded-2xl hover:border-brand-200 hover:shadow-sm transition group">
                        <div class="flex items-center gap-4">
                            <div class="cursor-move text-gray-300 hover:text-gray-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 8h16M4 16h16"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-brand-600 transition">
                                    {{ $menu->label }}</h3>
                                <p class="text-sm text-gray-400 font-mono">{{ $menu->url }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-600">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                Visible
                            </span>

                            <a href="{{ route('staff.menus.edit', $menu) }}"
                                class="p-2 text-gray-400 hover:text-gray-900 rounded-lg hover:bg-gray-100 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </a>

                            <form action="{{ route('staff.menus.destroy', $menu) }}" method="POST"
                                onsubmit="return confirm('Delete this menu item?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="p-2 text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <p class="text-gray-500">No menu items found.</p>
                        <a href="{{ route('staff.menus.create') }}" class="text-brand-500 font-bold hover:underline">Add one
                            now</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-librarian-layout>