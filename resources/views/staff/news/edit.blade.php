<x-librarian-layout>
    <!-- Quill Editor (No API Required) -->
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <style>
        .ql-editor {
            min-height: 250px;
            font-size: 16px;
            line-height: 1.6;
        }

        .ql-toolbar {
            border-radius: 0.75rem 0.75rem 0 0;
            border-color: #e5e7eb;
            background: #f9fafb;
        }

        .ql-container {
            border-radius: 0 0 0.75rem 0.75rem;
            border-color: #e5e7eb;
        }
    </style>

    <div class="p-8 bg-[#F8F7F4] min-h-screen">
        <form id="news-form" action="{{ route('staff.news.update', $news) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <div class="mb-4">
                        <a href="{{ route('staff.news.index') }}"
                            class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 text-sm group">
                            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7">
                                </path>
                            </svg>
                            Back to News
                        </a>
                    </div>
                    <span
                        class="inline-block py-1 px-3 rounded-full bg-brand-600 text-white text-xs font-bold tracking-wide mb-2">ADMIN/STAFF
                        PANEL</span>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit News Article</h1>
                    <p class="text-gray-500 mt-1">Editing: <span class="font-medium">{{ $news->title }}</span></p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('news.show', $news) }}" target="_blank"
                        class="px-6 py-3 bg-blue-50 border border-blue-200 text-blue-700 font-bold rounded-xl hover:bg-blue-100 transition shadow-sm flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                        View
                    </a>
                    <a href="{{ route('staff.news.index') }}"
                        class="px-6 py-3 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition shadow-sm">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-3 bg-brand-500 text-white font-bold rounded-xl hover:bg-brand-600 transition shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Update
                    </button>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Main Content (2 cols) -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Title & Excerpt -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Headline <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="title" id="title" value="{{ old('title', $news->title) }}"
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                                    required>
                            </div>

                            <div>
                                <label for="excerpt" class="block text-sm font-bold text-gray-700 mb-2">Excerpt /
                                    Summary</label>
                                <textarea name="excerpt" id="excerpt" rows="2"
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                                    placeholder="Short summary shown in news listings...">{{ old('excerpt', $news->excerpt) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Content Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Article Content
                        </h3>
                        <div>
                            <!-- Quill Editor Container -->
                            <div id="editor-container"></div>
                            <!-- Hidden input to store content -->
                            <input type="hidden" name="content" id="content">
                        </div>
                    </div>
                </div>

                <!-- Sidebar (1 col) -->
                <div class="space-y-6">

                    <!-- Publishing Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Publishing</h3>

                        <div class="space-y-4">
                            <div class="p-3 bg-green-50 rounded-xl flex items-center gap-2">
                                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                <span class="text-sm font-medium text-green-700">Published</span>
                            </div>

                            <div>
                                <label for="published_date" class="block text-sm font-bold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Publish Date
                                </label>
                                <input type="date" name="published_date" id="published_date"
                                    value="{{ old('published_date', $news->published_date ? \Carbon\Carbon::parse($news->published_date)->format('Y-m-d') : '') }}"
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50">
                                <p class="text-xs text-gray-400 mt-2">Created:
                                    {{ $news->created_at->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Featured Image
                        </h3>

                        @if ($news->image)
                            <div class="mb-4 relative group">
                                <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}"
                                    class="w-full h-40 object-cover rounded-xl">
                                <div
                                    class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition rounded-xl flex items-center justify-center">
                                    <span class="text-white text-sm">Upload new to replace</span>
                                </div>
                            </div>
                        @endif

                        <div>
                            <label for="image"
                                class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-200 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6"
                                    id="upload-placeholder">
                                    <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                        </path>
                                    </svg>
                                    <p class="text-sm text-gray-500"><span class="font-semibold">Click to
                                            upload</span></p>
                                </div>
                                <img id="image-preview" class="hidden w-full h-full object-cover rounded-xl" />
                                <input id="image" name="image" type="file" class="hidden" accept="image/*" />
                            </label>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-6">
                        <h3 class="text-lg font-bold text-red-700 mb-4">Danger Zone</h3>
                        <p class="text-sm text-gray-600 mb-4">Permanently delete this news article.</p>
                        <button type="button" onclick="confirmDelete()"
                            class="w-full px-4 py-3 bg-red-50 text-red-600 font-bold rounded-xl hover:bg-red-100 transition">
                            Delete Article
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Delete Form (hidden) -->
        <form id="delete-form" action="{{ route('staff.news.destroy', $news) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <!-- Quill Initialization -->
    <script>
        function confirmDelete() {
            if (confirm('Are you sure you want to delete this article? This action cannot be undone.')) {
                document.getElementById('delete-form').submit();
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Quill editor
            var quill = new Quill('#editor-container', {
                theme: 'snow',
                placeholder: 'Write your article content here...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ 'align': [] }],
                        ['blockquote', 'code-block'],
                        ['link', 'image'],
                        ['clean']
                    ]
                }
            });

            // Set initial content
            quill.root.innerHTML = {!! json_encode(old('content', $news->content ?? '')) !!};

            // Update hidden input before form submit
            document.getElementById('news-form').addEventListener('submit', function () {
                document.getElementById('content').value = quill.root.innerHTML;
            });

            // Image preview functionality
            document.getElementById('image').addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        document.getElementById('image-preview').src = e.target.result;
                        document.getElementById('image-preview').classList.remove('hidden');
                        document.getElementById('upload-placeholder').classList.add('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
</x-librarian-layout>