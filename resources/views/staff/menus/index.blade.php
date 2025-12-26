<x-librarian-layout>
    <div class="p-8 bg-[#F8F7F4] min-h-screen">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <span
                    class="inline-block py-1 px-3 rounded-full bg-gray-900 text-white text-xs font-bold tracking-wide mb-2">ADMIN
                    PANEL</span>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Menu & Navigation</h1>
                <p class="text-gray-500 mt-1">Manage your website's navigation structure</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-2 px-6 rounded-full transition shadow-lg">
                    Sign Out
                </button>
            </form>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-brand-50 text-brand-700 rounded-xl border border-brand-100 flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center text-brand-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $menus->count() }}</p>
                        <p class="text-sm text-gray-500">Total Menu Items</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $menus->where('is_visible', true)->count() + $menus->flatMap->children->where('is_visible', true)->count() }}
                        </p>
                        <p class="text-sm text-gray-500">Visible Items</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $menus->where('link_type', 'external')->count() + $menus->flatMap->children->where('link_type', 'external')->count() }}
                        </p>
                        <p class="text-sm text-gray-500">External Links</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <div class="flex justify-between items-end mb-6">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Menu Structure</h2>
                    <p class="text-gray-500 text-sm mt-1">Drag items to reorder. Click to edit.</p>
                </div>
                <a href="{{ route('staff.menus.create') }}"
                    class="px-5 py-3 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl transition shadow-md flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                        </path>
                    </svg>
                    New Menu Item
                </a>
            </div>

            <!-- Menu List -->
            <div id="menu-list" class="space-y-4">
                @forelse($menus as $menu)
                    <div class="menu-item group" data-id="{{ $menu->id }}">
                        <div
                            class="flex items-center justify-between p-5 bg-white border border-gray-100 rounded-2xl hover:border-brand-200 hover:shadow-sm transition {{ !($menu->is_visible ?? true) ? 'opacity-50' : '' }}">
                            <div class="flex items-center gap-4">
                                <!-- Drag Handle -->
                                <div
                                    class="cursor-grab active:cursor-grabbing text-gray-300 hover:text-gray-500 drag-handle">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 8h16M4 16h16"></path>
                                    </svg>
                                </div>

                                <!-- Menu Info -->
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-brand-600 transition">
                                            {{ $menu->label }}
                                        </h3>
                                        @if ($menu->link_type === 'external')
                                            <span
                                                class="px-2 py-0.5 bg-blue-50 text-blue-600 text-xs font-medium rounded-full">External</span>
                                        @endif
                                        @if ($menu->target === '_blank')
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                                </path>
                                            </svg>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-400 font-mono">{{ $menu->url }}</p>
                                    @if ($menu->description)
                                        <p class="text-sm text-gray-500 mt-1">{{ Str::limit($menu->description, 60) }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <!-- Visibility Badge -->
                                @if ($menu->is_visible ?? true)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        Visible
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                            </path>
                                        </svg>
                                        Hidden
                                    </span>
                                @endif

                                <!-- Edit Button -->
                                <a href="{{ route('staff.menus.edit', $menu) }}"
                                    class="p-2 text-gray-400 hover:text-gray-900 rounded-lg hover:bg-gray-100 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('staff.menus.destroy', $menu) }}" method="POST"
                                    onsubmit="return confirm('Delete this menu item and all its children?');">
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

                        <!-- Child Menu Items -->
                        @if ($menu->children->count() > 0)
                            <div class="ml-12 mt-2 space-y-2">
                                @foreach ($menu->children as $child)
                                    <div
                                        class="flex items-center justify-between p-4 bg-gray-50 border border-gray-100 rounded-xl group {{ !($child->is_visible ?? true) ? 'opacity-50' : '' }}">
                                        <div class="flex items-center gap-3">
                                            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                                            </svg>
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span class="font-medium text-gray-700">{{ $child->label }}</span>
                                                    @if ($child->link_type === 'external')
                                                        <span
                                                            class="px-1.5 py-0.5 bg-blue-50 text-blue-600 text-[10px] font-medium rounded">External</span>
                                                    @endif
                                                </div>
                                                <span class="text-xs text-gray-400 font-mono">{{ $child->url }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            @if (!($child->is_visible ?? true))
                                                <span class="text-[10px] text-gray-400 uppercase tracking-wider">Hidden</span>
                                            @endif
                                            <a href="{{ route('staff.menus.edit', $child) }}"
                                                class="p-1.5 text-gray-400 hover:text-gray-700 rounded hover:bg-white transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('staff.menus.destroy', $child) }}" method="POST"
                                                onsubmit="return confirm('Delete this menu item?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-1.5 text-gray-400 hover:text-red-600 rounded hover:bg-red-50 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-16 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <h3 class="text-lg font-bold text-gray-700 mb-2">No Menu Items Yet</h3>
                        <p class="text-gray-500 mb-6">Start building your navigation by adding your first menu item.
                        </p>
                        <a href="{{ route('staff.menus.create') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-brand-500 text-white font-bold rounded-xl hover:bg-brand-600 transition shadow-lg shadow-brand-500/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            Add First Menu
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Help Section -->
        <div class="mt-8 bg-blue-50 rounded-2xl p-6 border border-blue-100">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-blue-900 mb-1">How Menu Management Works</h4>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li>• <strong>Internal links</strong> point to pages within your website (e.g., /about,
                            /contact)</li>
                        <li>• <strong>External links</strong> point to other websites (e.g., https://google.com)</li>
                        <li>• Use <strong>parent menus</strong> to create dropdown navigation</li>
                        <li>• Toggle <strong>visibility</strong> to hide items without deleting them</li>
                        <li>• <strong>Drag and drop</strong> items to reorder them</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Sortable JS for drag and drop -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuList = document.getElementById('menu-list');
            if (menuList) {
                new Sortable(menuList, {
                    handle: '.drag-handle',
                    animation: 150,
                    ghostClass: 'opacity-50',
                    onEnd: function (evt) {
                        const items = menuList.querySelectorAll('.menu-item');
                        const ids = Array.from(items).map(item => item.dataset.id);

                        fetch('{{ route('staff.menus.reorder') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                ids: ids
                            })
                        }).then(response => response.json()).then(data => {
                            if (data.status === 'success') {
                                console.log('Menu order saved');
                            }
                        });
                    }
                });
            }
        });
    </script>
</x-librarian-layout>