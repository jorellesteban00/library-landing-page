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
        <div class="flex justify-between items-center mb-8">
            <div>
                <span
                    class="inline-block py-1 px-3 rounded-full bg-gray-900 text-white text-xs font-bold tracking-wide mb-2">ADMIN
                    PANEL</span>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit News</h1>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('staff.news.index') }}"
                    class="px-6 py-2 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition shadow-sm">
                    Cancel
                </a>
                <button form="edit-news-form" type="submit"
                    class="px-6 py-2 bg-brand-500 text-white font-bold rounded-xl hover:bg-brand-600 transition shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update News
                </button>
            </div>
        </div>

        <form id="edit-news-form" action="{{ route('staff.news.update', $news) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Main Content (2 cols) -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Title & Excerpt -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Title <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="title" id="title" value="{{ old('title', $news->title) }}"
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                                    required>
                            </div>

                            <div>
                                <label for="excerpt" class="block text-sm font-bold text-gray-700 mb-2">Excerpt</label>
                                <textarea name="excerpt" id="excerpt" rows="2"
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                                    placeholder="Short summary of the news...">{{ old('excerpt') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Content Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Content</h3>

                        <div class="prose max-w-none">
                            <input id="content" type="hidden" name="content"
                                value="{{ old('content', $news->content) }}">
                            <trix-editor input="content" class="min-h-[300px]"></trix-editor>
                        </div>
                    </div>
                </div>

                <!-- Sidebar (1 col) -->
                <div class="space-y-8">

                    <!-- Publishing Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Publishing</h3>

                        <div class="space-y-4">
                            <label class="flex items-start cursor-pointer group">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" name="publish_immediately" checked
                                        class="w-5 h-5 text-brand-500 border-gray-300 rounded focus:ring-brand-500 transition">
                                </div>
                                <div class="ml-3 text-sm">
                                    <span class="font-bold text-gray-700 group-hover:text-brand-600 transition">Publish
                                        immediately</span>
                                </div>
                            </label>

                            <div>
                                <label for="published_date"
                                    class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Publish
                                    At (Optional)</label>
                                <input type="date" name="published_date" id="published_date"
                                    value="{{ old('published_date', $news->published_date ? \Carbon\Carbon::parse($news->published_date)->format('Y-m-d') : '') }}"
                                    class="w-full px-4 py-2 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50 text-sm">
                                <p class="text-xs text-gray-400 mt-2">Currently published since:
                                    {{ $news->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Featured Image
                        </h3>

                        @if($news->image)
                            <div class="mb-4">
                                <p class="text-xs font-bold text-gray-400 mb-2">Current Image:</p>
                                <img src="{{ asset('storage/' . $news->image) }}"
                                    class="w-full h-48 object-cover rounded-xl border border-gray-100">
                            </div>
                        @endif

                        <div class="space-y-4">
                            <label
                                class="block w-full cursor-pointer bg-gray-50 hover:bg-gray-100 border-2 border-dashed border-gray-300 hover:border-brand-400 rounded-xl p-6 transition group text-center">
                                <span class="group-hover:text-brand-600 text-gray-500 font-medium">Change File</span>
                                <input type="file" name="image" class="hidden">
                            </label>
                        </div>
                    </div>

                    <!-- SEO/URL Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">SEO / URL</h3>

                        <div>
                            <label for="custom_slug"
                                class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Custom Slug
                                (Optional)</label>
                            <input type="text" name="custom_slug" id="custom_slug"
                                class="w-full px-4 py-2 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50 text-sm"
                                placeholder="my-news-article">
                        </div>
                    </div>

                    <!-- Delete Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Delete News</h3>
                        <button type="button"
                            onclick="if(confirm('Are you sure?')) document.getElementById('delete-form').submit()"
                            class="w-full py-3 bg-red-50 text-red-600 font-bold rounded-xl hover:bg-red-100 transition">
                            Delete News
                        </button>
                    </div>

                </div>
            </div>
        </form>

        <form id="delete-form" action="{{ route('staff.news.destroy', $news) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</x-librarian-layout>