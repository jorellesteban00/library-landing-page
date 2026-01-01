<x-librarian-layout>
    <!-- Quill Editor -->
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <style>
        .ql-editor {
            min-height: 150px;
            font-size: 16px;
            line-height: 1.6;
            background: white;
        }

        .ql-toolbar {
            border-radius: 0.75rem 0.75rem 0 0;
            border-color: #e5e7eb;
            background: #f9fafb;
        }

        .ql-container {
            border-radius: 0 0 0.75rem 0.75rem;
            border-color: #e5e7eb;
            background: white;
        }

        /* Fix for multiple editors on page */
        .quill-wrapper {
            display: flex;
            flex-direction: column;
        }
    </style>

    <div class="p-8 bg-[#F8F7F4] min-h-screen">
        <form action="{{ route('staff.site-content.store') }}" method="POST">
            @csrf

            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <span
                        class="inline-block py-1 px-3 rounded-full bg-brand-600 text-white text-xs font-bold tracking-wide mb-2">ADMIN/STAFF
                        PANEL</span>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Site Content</h1>
                    <p class="text-gray-500 mt-1">Edit your website's core content sections</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('home') }}" target="_blank"
                        class="px-6 py-3 bg-blue-50 border border-blue-200 text-blue-700 font-bold rounded-xl hover:bg-blue-100 transition shadow-sm flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                        View Site
                    </a>
                    <button type="submit"
                        class="px-6 py-3 bg-brand-500 text-white font-bold rounded-xl hover:bg-brand-600 transition shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Save All Changes
                    </button>
                </div>
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Main Content (2 cols) -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Hero Section Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                            <div
                                class="w-10 h-10 bg-brand-100 rounded-xl flex items-center justify-center text-brand-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Hero Section</h3>
                                <p class="text-sm text-gray-500">Main banner content at the top of the homepage</p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label for="hero_title" class="block text-sm font-bold text-gray-700 mb-2">Hero
                                    Title</label>
                                <input type="text" name="hero_title" id="hero_title"
                                    value="{{ $content['hero_title'] ?? 'Welcome to Our Library' }}"
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                                    placeholder="Enter the main headline...">
                            </div>

                            <div>
                                <label for="hero_subtitle" class="block text-sm font-bold text-gray-700 mb-2">Hero
                                    Subtitle</label>
                                <textarea name="hero_subtitle" id="hero_subtitle" rows="2"
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                                    placeholder="Enter a brief tagline...">{{ $content['hero_subtitle'] ?? 'Discover a world of knowledge and imagination.' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Vision, Mission & Goals Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                            <div
                                class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Vision, Mission & Goals</h3>
                                <p class="text-sm text-gray-500">Your library's core values displayed on the homepage
                                </p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label for="vision" class="block text-sm font-bold text-gray-700">
                                        <span class="flex items-center gap-2">
                                            <span
                                                class="w-6 h-6 bg-brand-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </span>
                                            Our Vision
                                        </span>
                                    </label>
                                    <button type="button" id="toggle-vision-source"
                                        class="px-3 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition flex items-center gap-2">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                        </svg>
                                        <span id="vision-source-btn-text">View Source</span>
                                    </button>
                                </div>
                                <!-- Vision Editor -->
                                <div class="quill-wrapper">
                                    <div id="editor-vision"></div>
                                    <textarea id="html-vision-source"
                                        class="hidden w-full px-4 py-3 border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50 font-mono text-sm"
                                        style="border-radius: 0.75rem; min-height: 150px;" rows="6"
                                        placeholder="HTML source code..."></textarea>
                                    <input type="hidden" name="vision" id="vision"
                                        value="{{ $content['vision'] ?? 'To be a pioneer in sustainable knowledge management and community engagement.' }}">
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label for="mission" class="block text-sm font-bold text-gray-700">
                                        <span class="flex items-center gap-2">
                                            <span
                                                class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                </svg>
                                            </span>
                                            Our Mission
                                        </span>
                                    </label>
                                    <button type="button" id="toggle-mission-source"
                                        class="px-3 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition flex items-center gap-2">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                        </svg>
                                        <span id="mission-source-btn-text">View Source</span>
                                    </button>
                                </div>
                                <!-- Mission Editor -->
                                <div class="quill-wrapper">
                                    <div id="editor-mission"></div>
                                    <textarea id="html-mission-source"
                                        class="hidden w-full px-4 py-3 border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50 font-mono text-sm"
                                        style="border-radius: 0.75rem; min-height: 150px;" rows="6"
                                        placeholder="HTML source code..."></textarea>
                                    <input type="hidden" name="mission" id="mission"
                                        value="{{ $content['mission'] ?? 'To foster a culture of lifelong learning through accessible, green resources.' }}">
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label for="goals" class="block text-sm font-bold text-gray-700">
                                        <span class="flex items-center gap-2">
                                            <span
                                                class="w-6 h-6 bg-lime-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-lime-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </span>
                                            Our Goals
                                        </span>
                                    </label>
                                    <button type="button" id="toggle-goals-source"
                                        class="px-3 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition flex items-center gap-2">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                        </svg>
                                        <span id="goals-source-btn-text">View Source</span>
                                    </button>
                                </div>
                                <!-- Goals Editor -->
                                <div class="quill-wrapper">
                                    <div id="editor-goals"></div>
                                    <textarea id="html-goals-source"
                                        class="hidden w-full px-4 py-3 border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50 font-mono text-sm"
                                        style="border-radius: 0.75rem; min-height: 150px;" rows="6"
                                        placeholder="HTML source code..."></textarea>
                                    <input type="hidden" name="goals" id="goals"
                                        value="{{ $content['goals'] ?? 'Promoting environmental awareness while preserving human knowledge.' }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                            <div
                                class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Contact Information</h3>
                                <p class="text-sm text-gray-500">Contact details shown in the footer</p>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label for="contact_info" class="block text-sm font-bold text-gray-700">Contact
                                    Details</label>
                                <button type="button" id="toggle-contact-source"
                                    class="px-3 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition flex items-center gap-2">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                    </svg>
                                    <span id="contact-source-btn-text">View Source</span>
                                </button>
                            </div>
                            <!-- Contact Info Editor -->
                            <div class="quill-wrapper">
                                <div id="editor-contact_info"></div>
                                <textarea id="html-contact-source"
                                    class="hidden w-full px-4 py-3 border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50 font-mono text-sm"
                                    style="border-radius: 0.75rem; min-height: 150px;" rows="10"
                                    placeholder="HTML source code..."></textarea>
                                <input type="hidden" name="contact_info" id="contact_info"
                                    value="{{ $content['contact_info'] ?? '123 Library St, Booktown' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar (1 col) -->
                <div class="space-y-6">

                    <!-- Preview Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Preview</h3>
                        <p class="text-sm text-gray-500 mb-4">See how your changes look on the live site.</p>
                        <a href="{{ route('home') }}" target="_blank"
                            class="block w-full py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition text-center">
                            Open Homepage
                        </a>
                    </div>

                    <!-- Quick Tips -->
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
                                <h4 class="font-bold text-blue-900 text-sm mb-2">Content Tips</h4>
                                <ul class="text-xs text-blue-700 space-y-1">
                                    <li>• Keep your Vision, Mission & Goals concise</li>
                                    <li>• Use clear, inspiring language</li>
                                    <li>• Changes take effect immediately after saving</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- What Gets Updated -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Sections Updated</h3>
                        <ul class="space-y-3">
                            <li class="flex items-center gap-3 text-sm text-gray-600">
                                <span class="w-2 h-2 bg-brand-500 rounded-full"></span>
                                Homepage Hero Banner
                            </li>
                            <li class="flex items-center gap-3 text-sm text-gray-600">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                                Vision Card
                            </li>
                            <li class="flex items-center gap-3 text-sm text-gray-600">
                                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                Mission Card
                            </li>
                            <li class="flex items-center gap-3 text-sm text-gray-600">
                                <span class="w-2 h-2 bg-lime-500 rounded-full"></span>
                                Goals Card
                            </li>
                            <li class="flex items-center gap-3 text-sm text-gray-600">
                                <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                                Footer Contact Info
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Quill Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Function to initialize a Quill editor
            function initQuill(containerId, inputId, placeholder, toggleBtnId, sourceBtnTextId, htmlSourceId) {
                // Custom image handler
                function imageHandler() {
                    const input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');
                    input.click();

                    input.onchange = async () => {
                        const file = input.files[0];
                        if (file) {
                            const range = this.quill.getSelection(true);
                            this.quill.insertText(range.index, 'Uploading image...', { 'italic': true });

                            const formData = new FormData();
                            formData.append('file', file);
                            formData.append('_token', '{{ csrf_token() }}');

                            try {
                                // Reuse the pages image upload endpoint
                                const response = await fetch('{{ route("staff.pages.upload-image") }}', {
                                    method: 'POST',
                                    body: formData
                                });

                                if (response.ok) {
                                    const result = await response.json();
                                    this.quill.deleteText(range.index, 'Uploading image...'.length);
                                    this.quill.insertEmbed(range.index, 'image', result.location);
                                    this.quill.setSelection(range.index + 1);
                                } else {
                                    this.quill.deleteText(range.index, 'Uploading image...'.length);
                                    alert('Failed to upload image.');
                                }
                            } catch (error) {
                                console.error('Error:', error);
                                this.quill.deleteText(range.index, 'Uploading image...'.length);
                                alert('Error uploading image.');
                            }
                        }
                    };
                }

                var quill = new Quill('#' + containerId, {
                    theme: 'snow',
                    placeholder: placeholder,
                    modules: {
                        toolbar: {
                            container: [
                                ['bold', 'italic', 'underline'],
                                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
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
                var input = document.getElementById(inputId);
                if (input.value) {
                    quill.root.innerHTML = input.value;
                }

                // Update input on change
                quill.on('text-change', function () {
                    input.value = quill.root.innerHTML;
                });

                // --- Source Code Toggle Logic ---
                let isSourceView = false;
                const toggleBtn = document.getElementById(toggleBtnId);
                const sourceBtnText = document.getElementById(sourceBtnTextId);
                const editorContainer = document.getElementById(containerId).previousElementSibling || document.getElementById(containerId).parentElement; // The wrapper or the toolbar needs handling. Wait, the containerId is the editor div.
                // Quill adds a toolbar sibling before the editor container.
                const quillContainer = document.getElementById(containerId);
                // The toolbar is the previous sibling of the quill container if using default structure, BUT we wrapped it in .quill-wrapper.
                // Actually quill attaches the toolbar before the container.

                const htmlSource = document.getElementById(htmlSourceId);

                toggleBtn.addEventListener('click', function () {
                    isSourceView = !isSourceView;
                    const toolbar = quillContainer.previousElementSibling; // Quill toolbar

                    if (isSourceView) {
                        // Switch to source view
                        htmlSource.value = quill.root.innerHTML;

                        // Hide Quill
                        quillContainer.classList.add('hidden');
                        if (toolbar) toolbar.classList.add('hidden');

                        // Show Source
                        htmlSource.classList.remove('hidden');

                        // Update Button
                        sourceBtnText.textContent = 'Visual Editor';
                        toggleBtn.classList.remove('bg-gray-100', 'hover:bg-gray-200');
                        toggleBtn.classList.add('bg-brand-500', 'text-white', 'hover:bg-brand-600');
                    } else {
                        // Switch back to visual editor
                        quill.root.innerHTML = htmlSource.value;

                        // Show Quill
                        quillContainer.classList.remove('hidden');
                        if (toolbar) toolbar.classList.remove('hidden');

                        // Hide Source
                        htmlSource.classList.add('hidden');

                        // Update Button
                        sourceBtnText.textContent = 'View Source';
                        toggleBtn.classList.remove('bg-brand-500', 'text-white', 'hover:bg-brand-600');
                        toggleBtn.classList.add('bg-gray-100', 'hover:bg-gray-200');
                    }
                });

                // Update input when editing source textarea
                htmlSource.addEventListener('input', function () {
                    input.value = this.value;
                });

                return quill;
            }

            // Initialize all editors
            initQuill('editor-vision', 'vision', 'Describe your library\'s vision...', 'toggle-vision-source', 'vision-source-btn-text', 'html-vision-source');
            initQuill('editor-mission', 'mission', 'Describe your library\'s mission...', 'toggle-mission-source', 'mission-source-btn-text', 'html-mission-source');
            initQuill('editor-goals', 'goals', 'Describe your library\'s goals...', 'toggle-goals-source', 'goals-source-btn-text', 'html-goals-source');
            initQuill('editor-contact_info', 'contact_info', 'Enter address, phone, email, etc.', 'toggle-contact-source', 'contact-source-btn-text', 'html-contact-source');
        });
    </script>
</x-librarian-layout>