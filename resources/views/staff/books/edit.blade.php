<x-librarian-layout>
    <div class="p-8 bg-[#F8F7F4] min-h-screen" x-data="{ showDeleteModal: false }">
        <form action="{{ route('staff.books.update', $book) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <div class="mb-4">
                        <a href="{{ route('staff.books.index') }}"
                            class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 text-sm group">
                            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7">
                                </path>
                            </svg>
                            Back to Books
                        </a>
                    </div>
                    <span
                        class="inline-block py-1 px-3 rounded-full bg-brand-600 text-white text-xs font-bold tracking-wide mb-2">ADMIN/STAFF
                        PANEL</span>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Book</h1>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('staff.books.index') }}"
                        class="px-6 py-2 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition shadow-sm">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-brand-500 text-white font-bold rounded-xl hover:bg-brand-600 transition shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Update Book
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Main Content (2 cols) -->
                <div class="lg:col-span-2 space-y-8">

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-6">
                        <div>
                            <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Title <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                                required>
                        </div>

                        <div>
                            <label for="author" class="block text-sm font-bold text-gray-700 mb-2">Author <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                                required>
                        </div>

                        <div>
                            <label for="isbn" class="block text-sm font-bold text-gray-700 mb-2">ISBN</label>
                            <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn) }}"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50">
                        </div>

                        <div>
                            <label for="description"
                                class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50">{{ old('description', $book->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Sidebar (1 col) -->
                <div class="space-y-8">

                    <!-- Category -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <label for="genre" class="block text-sm font-bold text-gray-700 mb-2">Category</label>
                        <select name="genre" id="genre"
                            class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50">
                            <option value="">Select Category</option>
                            @foreach([
                                    'Fiction',
                                    'Non-Fiction',
                                    'Mystery',
                                    'Thriller',
                                    'Science Fiction',
                                    'Fantasy',
                                    'Adventure',
                                    'Romance',
                                    'Horror',
                                    'Young Adult',
                                    'Children\'s',
                                    'Finance',
                                    'Biography',
                                    'History',
                                    'Science',
                                    'Technology',
                                    'Programming',
                                    'Educational',
                                    'Literature',
                                    'Philippine Literature',
                                    'Graphic Novel',
                                    'Self-Help'
                                ] as $cat)
                                                    <option value="{{ $cat }}" {{ (old('genre', $book->genre) == $cat) ? 'selected' : '' }}>
                                                        {{ $cat }}
                                                    </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Copies -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Copies</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Total Copies <span
                                        class="text-red-500">*</span></label>



                                                              
                                                              
                                                               <input type="number" name="total_quantity"
                                    value="{{ old('total_quantity', $book->total_quantity ?? 1) }}" min="1"
                                    class="w-full px-4 py-2 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50 text-sm"
                                    required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Available Copies <span
                                        class="text-red-500">*</span></label>
                                <input type="number" name="available_quantity"
                                    value="{{ old('available_quantity', $book->available_quantity ?? 1) }}" min="0"
                                    class="w-full px-4 py-2 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50 text-sm"
                                    required>
                            </div>
                        </div>
                    </div>

                    <!-- Publishing -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Publishing</h3>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="status" value="available" {{ $book->status == 'available' ? 'checked' : '' }}
                                class="w-5 h-5 text-brand-500 rounded focus:ring-brand-500 border-gray-300">
                            <span class="text-sm font-medium text-gray-700">Publish to catalog</span>
                        </label>
                        <input type="hidden" name="status"
                            value="{{ $book->status == 'available' ? 'available' : $book->status }}">
                    </div>

                    <!-- Cover Image -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Cover Image</h3>

                        <!-- Image Display/Preview -->
                        <div id="preview-container" class="mb-4 {{ $book->cover_image ? '' : 'hidden' }}">
                            <p class="text-xs font-bold text-gray-400 mb-2" id="preview-label">
                                {{ $book->cover_image ? 'Current Cover:' : 'New Cover Preview:' }}
                            </p>
                            <img id="cover-preview"
                                src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : '#' }}"
                                class="w-full h-48 object-cover rounded-xl border border-gray-100 shadow-sm">
                        </div>

                        <label
                            class="block w-full cursor-pointer bg-brand-50 hover:bg-brand-100 border border-brand-200 rounded-xl p-4 transition group text-center">
                            <span class="text-brand-700 font-bold text-sm block mb-1">Change File</span>
                            <span id="file-name" class="text-xs text-gray-500 block">No file chosen</span>
                            <input type="file" name="cover_image" id="cover_image" class="hidden" accept="image/*">
                        </label>
                        <p class="text-xs text-gray-400 mt-2">Upload new image to replace</p>
                    </div>

                    <script>
                        document.getElementById('cover_image').addEventListener('change', function (e) {
                            const file = e.target.files[0];
                            const previewContainer = document.getElementById('preview-container');
                            const previewImage = document.getElementById('cover-preview');
                            const previewLabel = document.getElementById('preview-label');
                            const fileName = document.getElementById('file-name');

                            if (file) {
                                fileName.textContent = file.name;
                                const reader = new FileReader();
                                reader.onload = function (e) {
                                    previewImage.src = e.target.result;
                                    previewLabel.textContent = 'New Cover Preview:';
                                    previewContainer.classList.remove('hidden');
                                }
                                reader.readAsDataURL(file);
                            }
                        });
                    </script>

                    <!-- Delete Book -->
                    <!-- Danger Zone -->
                    <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-6">
                        <h3 class="text-lg font-bold text-red-700 mb-4 border-b border-red-100 pb-2">Danger Zone</h3>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-700 font-medium">Delete this book</p>
                                <p class="text-sm text-gray-500">This action cannot be undone. This will permanently
                                    remove the book from the database.</p>
                            </div>
                            <button type="button" @click="showDeleteModal = true"
                                class="px-6 py-3 bg-red-50 hover:bg-red-100 text-red-600 font-bold rounded-xl transition">
                                Delete Book
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </form>

        <form id="delete-book-form" action="{{ route('staff.books.destroy', $book) }}" method="POST" class="hidden">
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
                    <p class="text-gray-600 mb-8">Are you sure you want to delete this book? This action cannot be
                        undone.</p>
                </div>

                <div class="flex justify-end space-x-3">
                    <button @click="showDeleteModal = false"
                        class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Cancel
                    </button>

                    <button type="button" onclick="document.getElementById('delete-book-form').submit()"
                        class="px-5 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow-lg shadow-red-200 transition-all focus:outline-none focus:ring-2 focus:ring-red-500">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-librarian-layout>