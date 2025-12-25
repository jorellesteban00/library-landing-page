<x-librarian-layout>
    <!-- Trix Editor Resources -->
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <style>
        trix-editor {
            min-height: 300px;
            border-color: #e5e7eb;
            border-radius: 0.75rem;
        }

        trix-toolbar .trix-button--icon {
            color: #6b7280;
        }

        trix-toolbar .trix-button--icon.trix-active {
            color: #10b981;
        }
    </style>

    <div class="p-8 bg-[#F8F7F4] min-h-screen">
        <form action="{{ route('staff.pages.update', $page) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <span
                        class="inline-block py-1 px-3 rounded-full bg-gray-900 text-white text-xs font-bold tracking-wide mb-2">ADMIN
                        PANEL</span>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Page</h1>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('staff.pages.index') }}"
                        class="px-6 py-2 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition shadow-sm">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-brand-500 text-white font-bold rounded-xl hover:bg-brand-600 transition shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Update Page
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Main Content (2 cols) -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Page Information Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Page Information
                        </h3>

                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Page Title <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="title" id="title" value="{{ old('title', $page->title) }}"
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                                    required>
                            </div>

                            <div>
                                <label for="slug" class="block text-sm font-bold text-gray-700 mb-2">Slug <span
                                        class="text-red-500">*</span></label>
                                <div class="flex items-center">
                                    <span
                                        class="px-4 py-3 bg-gray-100 border border-r-0 border-gray-200 rounded-l-xl text-gray-500 text-sm">/</span>
                                    <input type="text" name="slug" id="slug" value="{{ old('slug', $page->slug) }}"
                                        class="w-full px-4 py-3 rounded-r-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50">
                                </div>
                                <p class="text-xs text-gray-400 mt-2">URL-friendly identifier.</p>
                            </div>

                            <div>
                                <label for="meta_description" class="block text-sm font-bold text-gray-700 mb-2">Meta
                                    Description</label>
                                <textarea name="meta_description" id="meta_description" rows="3"
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                                    placeholder="Brief summary for search results...">{{ old('meta_description') }}</textarea>
                                <p class="text-xs text-gray-400 mt-2">Used for search engine listings.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Page Content Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Page Content</h3>

                        <div class="prose max-w-none">
                            <input id="content" type="hidden" name="content"
                                value="{{ old('content', $page->content) }}">
                            <trix-editor input="content" class="min-h-[300px]"></trix-editor>
                        </div>
                    </div>
                </div>

                <!-- Sidebar (1 col) -->
                <div class="space-y-8">

                    <!-- Page Status Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Page Status</h3>

                        <div class="space-y-4">
                            <label class="flex items-start cursor-pointer group">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" name="is_published" value="1" {{ $page->is_published ? 'checked' : '' }}
                                        class="w-5 h-5 text-brand-500 border-gray-300 rounded focus:ring-brand-500 transition">
                                </div>
                                <div class="ml-3 text-sm">
                                    <span
                                        class="font-bold text-gray-700 group-hover:text-brand-600 transition">Published</span>
                                    <p class="text-gray-400 text-xs mt-1">Visible to all visitors</p>
                                </div>
                            </label>

                            <div class="text-sm text-gray-500 pt-2 border-t border-gray-50">
                                Status:
                                @if($page->is_published)
                                    <span class="font-bold text-brand-500">Published</span>
                                @else
                                    <span class="font-bold text-gray-500">Draft</span>
                                @endif
                                <br>
                                <span class="text-xs text-gray-400">Created:
                                    {{ $page->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Quick Actions
                        </h3>

                        <button type="button"
                            class="w-full py-3 bg-blue-50 text-blue-600 font-bold rounded-xl hover:bg-blue-100 transition mb-3">
                            Preview Page
                        </button>

                        <form action="{{ route('staff.pages.destroy', $page) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this page?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full py-3 bg-red-50 text-red-600 font-bold rounded-xl hover:bg-red-100 transition">
                                Delete Page
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </form>
    </div>
</x-librarian-layout>