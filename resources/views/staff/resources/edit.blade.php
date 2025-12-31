<x-librarian-layout>
    <div class="p-8 bg-[#F8F7F4] min-h-screen" x-data="{ showDeleteModal: false, type: '{{ old('type', $resource->type) }}' }">
        <form action="{{ route('staff.resources.update', $resource) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <a href="{{ route('staff.resources.index') }}"
                        class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 text-sm mb-4 group">
                        <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                        Back to Resources
                    </a>
                    <span
                        class="inline-block py-1 px-3 rounded-full bg-gray-900 text-white text-xs font-bold tracking-wide mb-2">ADMIN
                        PANEL</span>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Resource</h1>
                    <p class="text-gray-500 mt-2">Update information for: <span
                            class="font-medium text-gray-700">{{ $resource->title }}</span></p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('staff.resources.index') }}"
                        class="px-6 py-2 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition shadow-sm">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-brand-500 text-white font-bold rounded-xl hover:bg-brand-600 transition shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Update Resource
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

                    <!-- Resource Details -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-4">Resource Details</h3>

                        <div>
                            <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Title <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title', $resource->title) }}"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                                required>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50">{{ old('description', $resource->description) }}</textarea>
                        </div>

                        <!-- Dynamic Fields based on Type -->
                        <div x-show="type === 'link' || type === 'video'" x-transition>
                            <label for="url" class="block text-sm font-bold text-gray-700 mb-2">URL <span
                                    class="text-red-500">*</span></label>
                            <input type="url" name="url" id="url" value="{{ old('url', $resource->url) }}"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                                placeholder="https://example.com">
                        </div>

                        <div x-show="type === 'document' || type === 'image'" x-transition>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Upload File</label>
                            
                            @if($resource->file_path)
                                <div class="mb-3 p-3 bg-gray-50 rounded-lg border border-gray-200 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Current File</p>
                                            <p class="text-xs text-gray-500">{{ basename($resource->file_path) }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/' . $resource->file_path) }}" target="_blank" class="text-brand-600 hover:text-brand-800 text-sm font-bold">View</a>
                                </div>
                            @endif

                            <label class="block w-full cursor-pointer bg-brand-50 hover:bg-brand-100 border border-brand-200 rounded-xl p-4 transition group text-center border-dashed">
                                <span class="text-brand-700 font-bold text-sm block mb-1">
                                    <span x-show="type === 'image'">Upload Image</span>
                                    <span x-show="type === 'document'">Upload Document</span>
                                </span>
                                <span class="text-xs text-gray-500 block">Click to select a new file to replace the current one</span>
                                <input type="file" name="file" class="hidden">
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Sidebar (1 col) -->
                <div class="space-y-8">

                    <!-- Configuration -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-6">
                        <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-4">Configuration</h3>

                        <div>
                            <label for="type" class="block text-sm font-bold text-gray-700 mb-2">Resource Type <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="type" id="type" x-model="type"
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50 appearance-none bg-none cursor-pointer">
                                    <option value="link">Link</option>
                                    <option value="document">Document (PDF, Doc)</option>
                                    <option value="video">Video</option>
                                    <option value="image">Image</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Visibility -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div>
                                <span class="block font-medium text-gray-900">Published</span>
                                <span class="text-sm text-gray-500">Visible to users</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_published" value="1"
                                    {{ old('is_published', $resource->is_published) ? 'checked' : '' }}
                                    class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-brand-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-600">
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-6">
                        <h3 class="text-lg font-bold text-red-700 mb-4 border-b border-red-100 pb-2">Danger Zone</h3>
                        <div class="flex flex-col gap-4">
                            <div>
                                <p class="text-gray-700 font-medium">Delete this resource</p>
                                <p class="text-sm text-gray-500">This action cannot be undone. Any associated files will be
                                    permanently removed.</p>
                            </div>
                            <button type="button" @click="showDeleteModal = true"
                                class="w-full px-6 py-3 bg-red-50 hover:bg-red-100 text-red-600 font-bold rounded-xl transition text-center">
                                Delete Resource
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </form>

        <!-- Delete Form (hidden) -->
        <form id="delete-resource-form" action="{{ route('staff.resources.destroy', $resource) }}" method="POST"
            class="hidden">
            @csrf
            @method('DELETE')
        </form>

        <!-- Delete Confirmation Modal -->
        <div x-show="showDeleteModal" style="display: none;"
            class="fixed inset-0 z-[100] flex items-center justify-center backdrop-blur-sm bg-black/50"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>

            <!-- Modal Panel -->
            <div class="bg-white rounded-xl shadow-2xl p-8 max-w-sm w-full mx-4 transform transition-all"
                @click.away="showDeleteModal = false" x-show="showDeleteModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <div class="flex items-center justify-center mb-6">
                    <div class="h-12 w-12 rounded-full bg-red-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                </div>

                <div class="text-center">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Confirm Delete</h3>
                    <p class="text-gray-600 mb-8">Are you sure you want to delete this resource? This action cannot be
                        undone.</p>
                </div>

                <div class="flex justify-end space-x-3">
                    <button @click="showDeleteModal = false"
                        class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Cancel
                    </button>

                    <button type="button" onclick="document.getElementById('delete-resource-form').submit()"
                        class="px-5 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow-lg shadow-red-200 transition-all focus:outline-none focus:ring-2 focus:ring-red-500">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-librarian-layout>