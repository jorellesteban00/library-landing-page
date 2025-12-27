<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page->title }} - {{ config('app.name', 'VerdeLib') }}</title>
    @if ($page->meta_description)
        <meta name="description" content="{{ $page->meta_description }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800|playfair-display:700i&display=swap"
        rel="stylesheet" />

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-serif-accent {
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>

<body class="bg-[#FDFCF8] text-gray-800 antialiased font-sans flex flex-col min-h-screen">

    <!-- Navigation -->
    <nav class="w-full py-6 px-6 md:px-12 bg-[#FDFCF8] z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div
                    class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center text-brand-600 shadow-sm group-hover:bg-emerald-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.292a8.96 8.96 0 00-6-2.292c-1.052 0-2.062.18-3 .512v14.25c.938-.332 1.948-.512 3-.512 2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25c-.938-.332-1.948-.512-3-.512-2.305 0-4.408.867-6 2.292m0-14.25v14.25">
                        </path>
                    </svg>
                </div>
                <span class="text-2xl font-black tracking-tighter group-hover:opacity-80 transition-opacity">
                    <span class="text-brand-600">Verde</span><span class="text-gray-900">Lib</span><span
                        class="text-emerald-400">.</span>
                </span>
            </a>

            <!-- Back to Home -->
            <a href="{{ route('home') }}"
                class="flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-brand-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Home
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        <!-- Hero Section -->
        <div class="bg-gradient-to-b from-brand-50/50 to-transparent py-16">
            <div class="max-w-4xl mx-auto px-6">
                <!-- Breadcrumbs -->
                @if ($page->parent)
                    <nav class="mb-6">
                        <ol class="flex items-center gap-2 text-sm text-gray-500">
                            <li><a href="{{ route('home') }}" class="hover:text-brand-600">Home</a></li>
                            @foreach ($page->getBreadcrumbs() as $crumb)
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    @if ($crumb->id === $page->id)
                                        <span class="font-medium text-gray-900">{{ $crumb->title }}</span>
                                    @else
                                        <a href="{{ route('pages.show', $crumb) }}"
                                            class="hover:text-brand-600">{{ $crumb->title }}</a>
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                    </nav>
                @endif

                <h1 class="text-5xl font-black text-gray-900 mb-4">
                    {{ $page->title }}
                </h1>
                @if ($page->meta_description)
                    <p class="text-xl text-gray-500 mb-4">{{ $page->meta_description }}</p>
                @endif
                <div class="flex items-center gap-4 text-sm text-gray-500">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        {{ $page->updated_at->format('F d, Y') }}
                    </span>


                </div>
            </div>
        </div>

        <!-- Featured Image -->
        @if ($page->featured_image)
            <div class="max-w-4xl mx-auto px-6 -mt-8 mb-8">
                <div class="rounded-2xl overflow-hidden shadow-xl">
                    <img src="{{ asset('storage/' . $page->featured_image) }}" alt="{{ $page->title }}"
                        class="w-full h-[400px] object-cover">
                </div>
            </div>
        @endif

        <!-- Content -->
        <div class="max-w-4xl mx-auto px-6 pb-16">
            <article class="bg-white p-8 md:p-12 rounded-3xl shadow-xl shadow-gray-100/50 border border-gray-100">
                <div class="relative group" id="content-wrapper">
                    <div id="content-display" class="prose prose-lg max-w-none 
                                prose-headings:font-bold prose-headings:text-gray-900
                                prose-p:text-gray-600 prose-p:leading-relaxed
                                prose-a:text-brand-600 prose-a:no-underline hover:prose-a:underline
                                prose-img:rounded-xl prose-img:shadow-lg
                                prose-blockquote:border-brand-500 prose-blockquote:bg-brand-50 prose-blockquote:py-1 prose-blockquote:px-6 prose-blockquote:rounded-r-xl
                                prose-code:bg-gray-100 prose-code:px-2 prose-code:py-1 prose-code:rounded
                                prose-pre:bg-gray-900 prose-pre:text-gray-100
                                prose-ul:list-disc prose-ol:list-decimal">
                        {!! $page->content !!}
                    </div>

                    @auth
                        @if(auth()->user()->role === 'librarian')
                            <!-- Editor Container (Hidden by default) -->
                            <div id="editor-container" class="hidden bg-white"></div>
                            
                            <!-- Edit Controls -->
                            <div class="absolute -top-12 right-0 flex items-center gap-3">
                                <div class="flex items-center gap-2 bg-white px-3 py-1.5 rounded-full shadow-sm border border-gray-100">
                                    <span class="text-xs font-bold text-gray-500 uppercase">Edit Mode</span>
                                    <button id="toggle-edit" class="relative inline-flex h-6 w-11 items-center rounded-full bg-gray-200 transition-colors focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
                                        <span class="sr-only">Enable editing</span>
                                        <span id="toggle-circle" class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform translate-x-1"></span>
                                    </button>
                                </div>
                                <button id="save-content" class="hidden px-4 py-1.5 bg-brand-600 text-white rounded-full text-xs font-bold shadow-lg hover:bg-brand-700 transition flex items-center gap-2">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Save Changes
                                </button>
                            </div>
                        @endif
                    @endauth
                </div>

                @auth
                    @if(auth()->user()->role === 'librarian')
                        <!-- Quill Scripts -->
                        <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
                        <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
                        <style>
                            .ql-toolbar { border-radius: 0.5rem 0.5rem 0 0; border-color: #f3f4f6 !important; background-color: #f9fafb; }
                            .ql-container { border-radius: 0 0 0.5rem 0.5rem; border-color: #f3f4f6 !important; font-size: 1.125rem; }
                            .ql-editor { min-height: 200px; }
                        </style>
                            <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const toggleBtn = document.getElementById('toggle-edit');
                                const toggleCircle = document.getElementById('toggle-circle');
                                const saveBtn = document.getElementById('save-content');
                                const displayDiv = document.getElementById('content-display');
                                const editorDiv = document.getElementById('editor-container');
                                let quill = null;
                                let isEditing = false;

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

                                toggleBtn.addEventListener('click', function() {
                                    isEditing = !isEditing;
                                    
                                    if (isEditing) {
                                        // Enable Edit Mode
                                        toggleBtn.classList.remove('bg-gray-200');
                                        toggleBtn.classList.add('bg-brand-500');
                                        toggleCircle.classList.remove('translate-x-1');
                                        toggleCircle.classList.add('translate-x-6');
                                        
                                        saveBtn.classList.remove('hidden');
                                        displayDiv.classList.add('hidden');
                                        editorDiv.classList.remove('hidden');

                                        // Initialize Quill if not already done
                                        if (!quill) {
                                            editorDiv.innerHTML = displayDiv.innerHTML;
                                            quill = new Quill('#editor-container', {
                                                theme: 'snow',
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
                                        }
                                    } else {
                                        // Disable Edit Mode (Cancel)
                                        toggleBtn.classList.add('bg-gray-200');
                                        toggleBtn.classList.remove('bg-brand-500');
                                        toggleCircle.classList.add('translate-x-1');
                                        toggleCircle.classList.remove('translate-x-6');
                                        
                                        saveBtn.classList.add('hidden');
                                        displayDiv.classList.remove('hidden');
                                        editorDiv.classList.add('hidden');
                                    }
                                });

                                // Save Content
                                saveBtn.addEventListener('click', async function() {
                                    const newContent = quill.root.innerHTML;
                                    const originalText = saveBtn.innerHTML;
                                    saveBtn.innerHTML = 'Saving...';
                                    saveBtn.disabled = true;

                                    try {
                                        const response = await fetch('{{ route("staff.pages.update-content", $page) }}', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            body: JSON.stringify({ content: newContent })
                                        });

                                        if (response.ok) {
                                            // Update display
                                            displayDiv.innerHTML = newContent;
                                            
                                            // Turn off edit mode
                                            toggleBtn.click();
                                            
                                            // Show success toast
                                            alert('Page updated successfully!');
                                        } else {
                                            alert('Failed to save content. Please try again.');
                                        }
                                    } catch (error) {
                                        console.error('Error:', error);
                                        alert('An error occurred.');
                                    } finally {
                                        saveBtn.innerHTML = originalText;
                                        saveBtn.disabled = false;
                                    }
                                });
                            });
                        </script>
                    @endif
                @endauth
            </article>

            <!-- Child Pages -->
            @if ($page->visibleChildren->count() > 0)
                <div class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Pages</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($page->visibleChildren as $child)
                            <a href="{{ route('pages.show', $child) }}"
                                class="block p-6 bg-white rounded-xl border border-gray-100 hover:border-brand-200 hover:shadow-lg transition group">
                                @if ($child->featured_image)
                                    <div class="h-32 rounded-lg overflow-hidden mb-4">
                                        <img src="{{ asset('storage/' . $child->featured_image) }}"
                                            alt="{{ $child->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition">
                                    </div>
                                @endif
                                <h3
                                    class="text-lg font-bold text-gray-900 group-hover:text-brand-600 transition mb-2">
                                    {{ $child->title }}</h3>
                                @if ($child->meta_description)
                                    <p class="text-gray-500 text-sm">{{ Str::limit($child->meta_description, 100) }}
                                    </p>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-auto">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="flex items-center justify-center gap-3 mb-4">
                <div class="w-8 h-8 bg-brand-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.292a8.96 8.96 0 00-6-2.292c-1.052 0-2.062.18-3 .512v14.25c.938-.332 1.948-.512 3-.512 2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25c-.938-.332-1.948-.512-3-.512-2.305 0-4.408.867-6 2.292m0-14.25v14.25">
                        </path>
                    </svg>
                </div>
                <span class="text-xl font-bold">VerdeLib</span>
            </div>
            <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} VerdeLib. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>