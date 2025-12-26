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
        <form action="{{ route('staff.pages.store') }}" method="POST" enctype="multipart/form-data" id="page-form">
            @csrf

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
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Create New Page</h1>
                </div>
                <div class="flex gap-3">
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
                        Save Page
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
                                <input type="text" name="title" id="title" value="{{ old('title') }}"
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                                    placeholder="e.g. About Our Library" required>
                            </div>

                            <div>
                                <label for="slug" class="block text-sm font-bold text-gray-700 mb-2">URL Slug</label>
                                <div class="flex items-center">
                                    <span
                                        class="px-4 py-3 bg-gray-100 border border-r-0 border-gray-200 rounded-l-xl text-gray-500 text-sm">/pages/</span>
                                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                                        class="w-full px-4 py-3 rounded-r-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                                        placeholder="about-us">
                                </div>
                                <p class="text-xs text-gray-400 mt-2">Leave empty to auto-generate from title.</p>
                            </div>

                            <div>
                                <label for="meta_description" class="block text-sm font-bold text-gray-700 mb-2">Meta
                                    Description</label>
                                <textarea name="meta_description" id="meta_description" rows="2"
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                                    placeholder="Brief summary for search results (recommended: 150-160 characters)">{{ old('meta_description') }}</textarea>
                                <p class="text-xs text-gray-400 mt-2">Used for SEO and search engine listings.</p>
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

                    <!-- Publish Settings Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Publish Settings
                        </h3>

                        <div class="space-y-5">
                            <!-- Status Toggle -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                <div>
                                    <span class="block font-medium text-gray-900">Publish Page</span>
                                    <span class="text-sm text-gray-500">Make visible to visitors</span>
                                </div>
                                </label>
                            </div>

                            <!-- Add to Navigation -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                <div>
                                    <span class="block font-medium text-gray-900">Add to Menu</span>
                                    <span class="text-sm text-gray-500">Auto-create a navigation link</span>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="add_to_menu" value="1"
                                        {{ old('add_to_menu') ? 'checked' : '' }} class="sr-only peer">
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
                                    Schedule Publishing (Optional)
                                </label>
                                <input type="datetime-local" name="publish_at" id="publish_at"
                                    value="{{ old('publish_at') }}"
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50">
                                <p class="text-xs text-gray-400 mt-2">Leave empty to publish immediately when saved.</p>
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
                                        {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->title }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-400 mt-2">Create nested pages by selecting a parent.</p>
                        </div>
                    </div>

                    <!-- Featured Image Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Featured Image
                        </h3>

                        <div>
                            <label for="featured_image"
                                class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-200 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6" id="upload-placeholder">
                                    <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                        </path>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to
                                            upload</span></p>
                                    <p class="text-xs text-gray-400">PNG, JPG or WebP (max 2MB)</p>
                                </div>
                                <img id="image-preview" class="hidden w-full h-full object-cover rounded-xl" />
                                <input id="featured_image" name="featured_image" type="file" class="hidden"
                                    accept="image/*" />
                            </label>
                        </div>
                    </div>

                    <!-- Help Card -->
                    <div class="bg-blue-50 rounded-2xl p-6 border border-blue-100">
                        <div class="flex items-start gap-3">
                            <div
                                class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-blue-900 text-sm mb-1">Tips</h4>
                                <ul class="text-xs text-blue-700 space-y-1">
                                    <li>• Use the toolbar to format text and add links</li>
                                    <li>• Schedule pages to publish automatically at a future date</li>
                                    <li>• Create sub-pages by selecting a parent page</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Quill Initialization -->
    <script>
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

            // Set initial content if exists
            @if(old('content'))
                quill.root.innerHTML = {!! json_encode(old('content')) !!};
            @endif

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
            document.getElementById('page-form').addEventListener('submit', function(e) {
                // If in source view, update content from textarea
                if (isSourceView) {
                    quill.root.innerHTML = htmlSource.value;
                }
                document.getElementById('content').value = quill.root.innerHTML;
            });
        });
    </script>
</x-librarian-layout>