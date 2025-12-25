<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Resource') }}
            <a href="{{ route('staff.resources.index') }}"
                class="float-right text-sm text-blue-600 hover:text-blue-900">Back</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('staff.resources.update', $resource) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @if($errors->any())
                            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                <ul class="list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Title *</label>
                            <input type="text" name="title" value="{{ old('title', $resource->title) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                            <textarea name="description" rows="3"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description', $resource->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Type *</label>
                            <select name="type" id="resource-type"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                                <option value="link" {{ old('type', $resource->type) === 'link' ? 'selected' : '' }}>Link
                                </option>
                                <option value="document" {{ old('type', $resource->type) === 'document' ? 'selected' : '' }}>Document</option>
                                <option value="video" {{ old('type', $resource->type) === 'video' ? 'selected' : '' }}>
                                    Video</option>
                                <option value="image" {{ old('type', $resource->type) === 'image' ? 'selected' : '' }}>
                                    Image</option>
                            </select>
                        </div>

                        <div class="mb-4" id="url-field">
                            <label class="block text-gray-700 text-sm font-bold mb-2">URL</label>
                            <input type="url" name="url" value="{{ old('url', $resource->url) }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="https://example.com">
                        </div>

                        <div class="mb-4" id="file-field">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Upload New File</label>
                            @if($resource->file_path)
                                <p class="text-sm text-gray-500 mb-2">Current file: {{ basename($resource->file_path) }}</p>
                            @endif
                            <input type="file" name="file"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_published" value="1" {{ $resource->is_published ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">Published</span>
                            </label>
                        </div>

                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Update Resource
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleFields() {
            const type = document.getElementById('resource-type').value;
            const urlField = document.getElementById('url-field');
            const fileField = document.getElementById('file-field');

            if (type === 'document' || type === 'image') {
                urlField.style.display = 'none';
                fileField.style.display = 'block';
            } else {
                urlField.style.display = 'block';
                fileField.style.display = 'none';
            }
        }

        document.getElementById('resource-type').addEventListener('change', toggleFields);
        toggleFields(); // Run on page load
    </script>
</x-app-layout>