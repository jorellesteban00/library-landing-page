<x-librarian-layout>
    <div class="p-8 bg-[#F8F7F4] min-h-screen">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Add Digital Resource</h1>
                    <p class="text-gray-500 mt-1">Share useful links, documents, or media with the community.</p>
                </div>
                <a href="{{ route('staff.resources.index') }}"
                    class="px-6 py-3 bg-white text-gray-700 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 hover:border-gray-300 transition shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Resources
                </a>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <form action="{{ route('staff.resources.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    @if($errors->any())
                        <div
                            class="mb-6 bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-xl flex items-start gap-3">
                            <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h4 class="font-bold text-sm">Please correct the following errors:</h4>
                                <ul class="list-disc list-inside text-sm mt-1 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Title -->
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Resource Title <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                                placeholder="e.g. library-guide-2024.pdf" required>
                        </div>

                        <!-- Type Selection -->
                        <div>
                            <label for="resource-type" class="block text-sm font-bold text-gray-700 mb-2">Resource Type
                                <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="type" id="resource-type"
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50 appearance-none cursor-pointer"
                                    style="background-image: none !important;" required>
                                    <option value="link" {{ old('type') === 'link' ? 'selected' : '' }}>External Link
                                    </option>
                                    <option value="video" {{ old('type') === 'video' ? 'selected' : '' }}>Video URL
                                    </option>
                                    <option value="document" {{ old('type') === 'document' ? 'selected' : '' }}>Document
                                        File</option>
                                    <option value="image" {{ old('type') === 'image' ? 'selected' : '' }}>Image File
                                    </option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Spacer/Empty (for layout) -->
                        <div class="hidden md:block"></div>
                    </div>

                    <!-- URL Field -->
                    <div id="url-field">
                        <label for="url" class="block text-sm font-bold text-gray-700 mb-2">External URL
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-400 sm:text-sm">https://</span>
                            </div>
                            <input type="url" name="url" id="url" value="{{ old('url') }}"
                                class="w-full pl-16 px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                                placeholder="example.com/resource">
                        </div>
                    </div>

                    <!-- File Upload Field -->
                    <div id="file-field" style="display: none;">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Upload File
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="w-full">
                            <label for="file"
                                class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-2xl cursor-pointer bg-gray-50 hover:bg-gray-100 hover:border-brand-300 transition group">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <div
                                        class="w-10 h-10 mb-2 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 group-hover:bg-brand-100 group-hover:text-brand-600 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                            </path>
                                        </svg>
                                    </div>
                                    <p class="text-sm text-gray-500"><span class="font-bold text-gray-700">Click to
                                            upload</span> or drag and drop</p>
                                </div>
                                <input id="file" name="file" type="file" class="hidden"
                                    onchange="document.getElementById('file-chosen').textContent = this.files[0].name" />
                            </label>
                            <span id="file-chosen" class="block text-center text-xs text-gray-500 mt-2">No file
                                chosen</span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                            placeholder="Optional details about this resource...">{{ old('description') }}</textarea>
                    </div>

                    <!-- Publishing -->
                    <div class="pt-4 border-t border-gray-100">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative flex items-center">
                                <input type="checkbox" name="is_published" value="1" checked
                                    class="w-5 h-5 text-brand-600 border-gray-300 rounded focus:ring-brand-500 transition">
                            </div>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Publish
                                immediately</span>
                        </label>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end pt-4">
                        <button type="submit"
                            class="px-8 py-3 bg-brand-600 text-white font-bold rounded-xl hover:bg-brand-700 transition shadow-lg shadow-brand-600/30 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Save Resource
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.getElementById('resource-type');
            const urlField = document.getElementById('url-field');
            const fileField = document.getElementById('file-field');

            function toggleFields() {
                const value = typeSelect.value;
                if (value === 'document' || value === 'image') {
                    urlField.style.display = 'none';
                    fileField.style.display = 'block';
                } else {
                    urlField.style.display = 'block';
                    fileField.style.display = 'none';
                    // Focus URL on switch if needed, but maybe not on page load
                }
            }

            typeSelect.addEventListener('change', toggleFields);

            // Run on load to handle pre-filled values
            toggleFields();
        });
    </script>
</x-librarian-layout>