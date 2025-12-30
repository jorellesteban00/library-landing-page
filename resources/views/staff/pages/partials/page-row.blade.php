<div class="page-item" data-id="{{ $page->id }}">
    <div
        class="flex items-center justify-between p-4 bg-white border border-gray-100 rounded-xl hover:border-brand-200 hover:shadow-sm transition group {{ $level > 0 ? 'ml-' . ($level * 8) : '' }}">
        <div class="flex items-center gap-4">
            <!-- Drag Handle -->
            <div class="cursor-grab active:cursor-grabbing text-gray-300 hover:text-gray-500 drag-handle">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                </svg>
            </div>

            <!-- Hierarchy Indicator -->
            @if ($level > 0)
                <div class="text-gray-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            @endif

            <!-- Page Info -->
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-lg bg-brand-100 flex items-center justify-center text-brand-600 font-bold">
                    {{ strtoupper(substr($page->title, 0, 1)) }}
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 group-hover:text-brand-600 transition">{{ $page->title }}</h3>
                    <p class="text-sm text-gray-400 font-mono">/pages/{{ $page->slug }}</p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <!-- Status Badge -->
            @if ($page->status_color === 'green')
                <span
                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-600">
                    <span class="w-1.5 h-1.5 mr-1.5 bg-green-500 rounded-full animate-pulse"></span>
                    Published
                </span>
            @elseif ($page->status_color === 'blue')
                <span
                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-600">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $page->publish_at->format('M d') }}
                </span>
            @else
                <span
                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                    Draft
                </span>
            @endif

            <!-- Child count -->
            @if ($page->children->count() > 0)
                <span class="text-xs text-gray-400">{{ $page->children->count() }} sub-page(s)</span>
            @endif

            <!-- Preview Button -->
            <a href="{{ route('staff.pages.preview', $page) }}" target="_blank"
                class="p-2 text-gray-400 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition" title="Preview">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                    </path>
                </svg>
            </a>

            <!-- Edit Button -->
            <a href="{{ route('staff.pages.edit', $page) }}"
                class="p-2 text-gray-400 hover:text-brand-600 rounded-lg hover:bg-brand-50 transition" title="Edit">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
            </a>

            <!-- Delete Button -->
            <button @click="showDeleteModal = true; deleteUrl = '{{ route('staff.pages.destroy', $page) }}'"
                class="p-2 text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition" title="Delete">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Child Pages (Recursive) -->
    @if ($page->children->count() > 0)
        <div class="ml-8 mt-2 space-y-2 border-l-2 border-gray-100 pl-4">
            @foreach ($page->children as $child)
                @include('staff.pages.partials.page-row', ['page' => $child, 'level' => $level + 1])
            @endforeach
        </div>
    @endif
</div>