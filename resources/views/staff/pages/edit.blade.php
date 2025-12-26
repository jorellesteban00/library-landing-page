<x-librarian-layout>
    <!-- Quill Editor (No API Required) -->
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <style>
        .ql-editor {
            min-height: 300px;
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
        <form action="{{ route('staff.pages.update', $page) }}" method="POST" enctype="multipart/form-data"
            id="page-form">
            @csrf
            @method('PUT')

            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <a href="{{ route('staff.pages.index') }}"
                        class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 text-sm mb-4 group">
                        <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                        Back to Pages
                    </a>
                    <span
                        class="inline-block py-1 px-3 rounded-full bg-gray-900 text-white text-xs font-bold tracking-wide mb-2">ADMIN
                        PANEL</span>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Page</h1>
                    <p class="text-gray-500 mt-1">Editing: <span class="font-medium">{{ $page->title }}</span></p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('staff.pages.preview', $page) }}" target="_blank"
                        class="px-6 py-3 bg-blue-50 border border-blue-200 text-blue-700 font-bold rounded-xl hover:bg-blue-100 transition shadow-sm flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                        Preview
                    </a>
                    <a href="{{ route('staff.pages.index') }}"
                        class="px-6 py-3 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition shadow-sm">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-3 bg-brand-500 text-white font-bold rounded-xl hover:bg-brand-600 transition shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Update Page
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

                    <!-- Page Information Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Page Information
                        </h3>

                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Page Title <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="title" id="title"
                                    value="{{ old('title', $page->title) }}"
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                                    placeholder="e.g. About Our Library" required>
                            </div>

                            <div>
                                <label for="slug" class="block text-sm font-bold text-gray-700 mb-2">URL Slug</label>
                                <div class="flex items-center">
                                    <span
                                        class="px-4 py-3 bg-gray-100 border border-r-0 border-gray-200 rounded-l-xl text-gray-500 text-sm">/pages/</span>
                                    <input type="text" name="slug" id="slug"
                                        value="{{ old('slug', $page->slug) }}"
                                        class="w-full px-4 py-3 rounded-r-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                                        placeholder="about-us">
                                </div>
                                <p class="text-xs text-gray-400 mt-2">Current URL: <a
                                        href="{{ route('pages.show', $page) }}" target="_blank"
                                        class="text-brand-600 hover:underline">{{ route('pages.show', $page) }}</a></p>
                            </div>

                            <div>
                                <label for="meta_description" class="block text-sm font-bold text-gray-700 mb-2">Meta
                                    Description</label>
                                <textarea name="meta_description" id="meta_description" rows="2"
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                                    placeholder="Brief summary for search results (recommended: 150-160 characters)">{{ old('meta_description', $page->meta_description) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Page Content Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                            <h3 class="text-lg font-bold text-gray-900">Page Content</h3>
                            <button type="button" id="toggle-source" 
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                </svg>
                                <span id="source-btn-text">View Source</span>
                            </button>
                        </div>
                        <div>
                            <!-- Quill Editor Container -->
                            <div id="editor-container"></div>
                            <!-- HTML Source Editor (hidden by default) -->
                            <textarea id="html-source" 
                                class="hidden w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50 font-mono text-sm"
                                rows="20"
                                placeholder="HTML source code..."></textarea>
                            <!-- Hidden input to store content -->
                            <input type="hidden" name="content" id="content">
                        </div>
                    </div>
                </div>

                <!-- Sidebar (1 col) -->
                <div class="space-y-6">

                    <!-- Status Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-4">Status</h3>

                        <!-- Current Status Display -->
                        <div class="mb-4 p-4 rounded-xl {{ $page->status_color === 'green' ? 'bg-green-50' : ($page->status_color === 'blue' ? 'bg-blue-50' : 'bg-gray-50') }}">
                            <div class="flex items-center gap-2">
                                @if ($page->status_color === 'green')
                                    <span class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></span>
                                    <span class="font-bold text-green-700">Published</span>
                                @elseif ($page->status_color === 'blue')
                                    <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                                    <span class="font-bold text-blue-700">Scheduled</span>
                                @else
                                    <span class="w-3 h-3 bg-gray-400 rounded-full"></span>
                                    <span class="font-bold text-gray-600">Draft</span>
                                @endif
                            </div>
                            @if ($page->isScheduled())
                                <p class="text-sm text-blue-600 mt-2">
                                    Will publish: {{ $page->publish_at->format('M d, Y \a\t g:i A') }}
                                </p>
                            @endif
                        </div>

                        <div class="space-y-5">
                            <!-- Status Toggle -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                <div>
                                    <span class="block font-medium text-gray-900">Publish Page</span>
                                    <span class="text-sm text-gray-500">Make visible to visitors</span>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_published" value="1"
                                        {{ old('is_published', $page->is_published) ? 'checked' : '' }}
                                        class="sr-only peer" id="is_published">
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-brand-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-600">
                                    </div>
                                </label>
                            </div>

                            <!-- Schedule Publishing -->
                            <div>
                                <label for="publish_at" class="block text-sm font-bold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Schedule Publishing
                                </label>
                                <input type="datetime-local" name="publish_at" id="publish_at"
                                    value="{{ old('publish_at', $page->publish_at ? $page->publish_at->format('Y-m-d\TH:i') : '') }}"
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50">
                                <p class="text-xs text-gray-400 mt-2">Leave empty to publish immediately.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Page Hierarchy Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Page Hierarchy
                        </h3>

                        <div>
                            <label for="parent_id" class="block text-sm font-bold text-gray-700 mb-2">Parent Page</label>
                            <select name="parent_id" id="parent_id"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50">
                                <option value="">— No Parent (Top Level) —</option>
                                @foreach ($parentPages as $parent)
                                    <option value="{{ $parent->id }}"
                                        {{ old('parent_id', $page->parent_id) == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @if ($page->children->count() > 0)
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <p class="text-sm font-bold text-gray-700 mb-2">Child Pages:</p>
                                <ul class="space-y-2">
                                    @foreach ($page->children as $child)
                                        <li class="flex items-center gap-2 text-sm">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                            <a href="{{ route('staff.pages.edit', $child) }}"
                                                class="text-brand-600 hover:underline">{{ $child->title }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <!-- Featured Image Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Featured Image
                        </h3>

                        <div>
                            @if ($page->featured_image)
                                <div class="mb-4 relative group" id="current-image-container">
                                    <img src="{{ asset('storage/' . $page->featured_image) }}"
                                        alt="{{ $page->title }}" class="w-full h-40 object-cover rounded-xl">
                                    <div
                                        class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition rounded-xl flex items-center justify-center gap-3">
                                        <span class="text-white text-sm">Upload new to replace</span>
                                    </div>
                                    <!-- Remove Image Button -->
                                    <button type="button" 
                                        onclick="removeFeaturedImage()"
                                        class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition shadow-lg z-10"
                                        title="Remove image">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                                <!-- Hidden input to signal image removal -->
                                <input type="hidden" name="remove_featured_image" id="remove_featured_image" value="0">
                            @endif

                            <label for="featured_image"
                                class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-200 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6" id="upload-placeholder">
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
                                <input id="featured_image" name="featured_image" type="file" class="hidden"
                                    accept="image/*" />
                            </label>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-6">
                        <h3 class="text-lg font-bold text-red-700 mb-4">Danger Zone</h3>
                        <p class="text-sm text-gray-600 mb-4">Deleting this page cannot be undone. Child pages will be
                            moved to the top level.</p>
                        <button type="button" onclick="confirmDelete()"
                            class="w-full px-4 py-3 bg-red-50 text-red-600 font-bold rounded-xl hover:bg-red-100 transition">
                            Delete Page
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Delete Form (hidden) -->
        <form id="delete-form" action="{{ route('staff.pages.destroy', $page) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <!-- Quill Initialization -->
    <script>
        function confirmDelete() {
            if (confirm('Are you sure you want to delete this page? This action cannot be undone.')) {
                document.getElementById('delete-form').submit();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Custom image handler for Quill
            function imageHandler() {
                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.click();

                input.onchange = async () => {
                    const file = input.files[0];
                    if (file) {
                        // Show loading indicator
                        const range = quill.getSelection(true);
                        quill.insertText(range.index, 'Uploading image...', { 'italic': true });
                        
                        // Create form data
                        const formData = new FormData();
                        formData.append('file', file);
                        formData.append('_token', '{{ csrf_token() }}');

                        try {
                            const response = await fetch('{{ route("staff.pages.upload-image") }}', {
                                method: 'POST',
                                body: formData
                            });

                            if (response.ok) {
                                const result = await response.json();
                                // Remove loading text
                                quill.deleteText(range.index, 'Uploading image...'.length);
                                // Insert the uploaded image
                                quill.insertEmbed(range.index, 'image', result.location);
                                quill.setSelection(range.index + 1);
                            } else {
                                // Remove loading text and show error
                                quill.deleteText(range.index, 'Uploading image...'.length);
                                alert('Failed to upload image. Please try again.');
                            }
                        } catch (error) {
                            console.error('Image upload error:', error);
                            quill.deleteText(range.index, 'Uploading image...'.length);
                            alert('Failed to upload image. Please try again.');
                        }
                    }
                };
            }

            // Initialize Quill editor with custom image handler
            var quill = new Quill('#editor-container', {
                theme: 'snow',
                placeholder: 'Write your page content here...',
                modules: {
                    toolbar: {
                        container: [
                            [{ 'header': [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ 'color': [] }, { 'background': [] }],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            [{ 'align': [] }],
                            ['blockquote', 'code-block'],
                            ['link', 'image'],
                            ['clean']
                        ],
                        handlers: {
                            image: imageHandler
                        }
                    }
                }
            });

            // Set initial content
            quill.root.innerHTML = {!! json_encode(old('content', $page->content ?? '')) !!};

            // Update hidden input before form submit
            document.getElementById('page-form').addEventListener('submit', function() {
                document.getElementById('content').value = quill.root.innerHTML;
            });

            // Image preview functionality
            document.getElementById('featured_image').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('image-preview').src = e.target.result;
                        document.getElementById('image-preview').classList.remove('hidden');
                        document.getElementById('upload-placeholder').classList.add('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Toggle between WYSIWYG and HTML source view
            let isSourceView = false;
            const toggleBtn = document.getElementById('toggle-source');
            const sourceBtnText = document.getElementById('source-btn-text');
            const editorContainer = document.getElementById('editor-container');
            const htmlSource = document.getElementById('html-source');

            toggleBtn.addEventListener('click', function() {
                isSourceView = !isSourceView;
                
                if (isSourceView) {
                    // Switch to source view
                    htmlSource.value = quill.root.innerHTML;
                    editorContainer.classList.add('hidden');
                    htmlSource.classList.remove('hidden');
                    sourceBtnText.textContent = 'Visual Editor';
                    toggleBtn.classList.remove('bg-gray-100', 'hover:bg-gray-200');
                    toggleBtn.classList.add('bg-brand-500', 'text-white', 'hover:bg-brand-600');
                } else {
                    // Switch back to visual editor
                    quill.root.innerHTML = htmlSource.value;
                    htmlSource.classList.add('hidden');
                    editorContainer.classList.remove('hidden');
                    sourceBtnText.textContent = 'View Source';
                    toggleBtn.classList.remove('bg-brand-500', 'text-white', 'hover:bg-brand-600');
                    toggleBtn.classList.add('bg-gray-100', 'hover:bg-gray-200');
                }
            });

            // Update form submission to include source view changes
            const originalSubmitHandler = document.getElementById('page-form').onsubmit;
            document.getElementById('page-form').addEventListener('submit', function(e) {
                // If in source view, update content from textarea
                if (isSourceView) {
                    quill.root.innerHTML = htmlSource.value;
                }
                document.getElementById('content').value = quill.root.innerHTML;
            });
        });

        // Function to remove featured image
        function removeFeaturedImage() {
            if (confirm('Are you sure you want to remove the featured image?')) {
                document.getElementById('current-image-container').remove();
                document.getElementById('remove_featured_image').value = '1';
            }
        }
    </script>
</x-librarian-layout>