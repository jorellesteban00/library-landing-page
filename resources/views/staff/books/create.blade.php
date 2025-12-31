<x-librarian-layout>
    <div class="p-8 bg-[#F8F7F4] min-h-screen">
        <form action="{{ route('staff.books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Add Book</h1>
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
                        Save Book
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
                            <input type="text" name="title" id="title"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                                placeholder="e.g. To Kill a Mockingbird" required>
                        </div>

                        <div>
                            <label for="author" class="block text-sm font-bold text-gray-700 mb-2">Author <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="author" id="author"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                                placeholder="e.g. Harper Lee" required>
                        </div>

                        <div>
                            <label for="isbn" class="block text-sm font-bold text-gray-700 mb-2">ISBN</label>
                            <input type="text" name="isbn" id="isbn"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                                placeholder="978-0-...">
                        </div>

                        <div>
                            <label for="description"
                                class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                                placeholder="Brief summary of the book..."></textarea>
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
                            <option value="Fiction">Fiction</option>
                            <option value="Non-Fiction">Non-Fiction</option>
                            <option value="Mystery">Mystery</option>
                            <option value="Thriller">Thriller</option>
                            <option value="Science Fiction">Science Fiction</option>
                            <option value="Fantasy">Fantasy</option>
                            <option value="Adventure">Adventure</option>
                            <option value="Romance">Romance</option>
                            <option value="Horror">Horror</option>
                            <option value="Young Adult">Young Adult</option>
                            <option value="Children's">Children's</option>
                            <option value="Finance">Finance</option>
                            <option value="Biography">Biography</option>
                            <option value="History">History</option>
                            <option value="Science">Science</option>
                            <option value="Technology">Technology</option>
                            <option value="Programming">Programming</option>
                            <option value="Educational">Educational</option>
                            <option value="Literature">Literature</option>
                            <option value="Philippine Literature">Philippine Literature</option>
                            <option value="Graphic Novel">Graphic Novel</option>
                            <option value="Self-Help">Self-Help</option>
                        </select>
                    </div>

                    <!-- Copies -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Copies</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Total Copies <span
                                        class="text-red-500">*</span></label>
                                <input type="number" name="total_quantity" value="{{ old('total_quantity', 1) }}"
                                    min="1"
                                    class="w-full px-4 py-2 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50 text-sm"
                                    required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Available Copies <span
                                        class="text-red-500">*</span></label>
                                <input type="number" name="available_quantity"
                                    value="{{ old('available_quantity', 1) }}" min="0"
                                    class="w-full px-4 py-2 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50 text-sm"
                                    required>
                            </div>
                        </div>
                    </div>

                    <!-- Publishing -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Publishing</h3>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="status" value="available" checked
                                class="w-5 h-5 text-brand-500 rounded focus:ring-brand-500 border-gray-300">
                            <span class="text-sm font-medium text-gray-700">Publish to catalog</span>
                        </label>
                        <!-- Hidden input to ensure status is sent if unchecked, defaults to 'available' if checked, else? fallback -->
                        <input type="hidden" name="status" value="available">
                        <!-- Force available for now as schema is limited -->
                    </div>


                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Cover Image</h3>

                        <!-- Image Preview -->
                        <div id="image-preview-container" class="mb-4 hidden">
                            <img id="cover-preview" src="#" alt="Cover Preview"
                                class="w-full h-48 object-cover rounded-xl border border-gray-100 shadow-sm">
                        </div>

                        <label
                            class="block w-full cursor-pointer bg-brand-50 hover:bg-brand-100 border border-brand-200 rounded-xl p-4 transition group text-center">
                            <span class="text-brand-700 font-bold text-sm block mb-1">Choose File</span>
                            <span id="file-name" class="text-xs text-gray-500 block">No file chosen</span>
                            <input type="file" name="cover_image" id="cover_image" class="hidden" accept="image/*">
                        </label>
                        <p class="text-xs text-gray-400 mt-2">Upload a cover image</p>
                    </div>

                    <script>
                        document.getElementById('cover_image').addEventListener('change', function (e) {
                            const file = e.target.files[0];
                            const previewContainer = document.getElementById('image-preview-container');
                            const previewImage = document.getElementById('cover-preview');
                            const fileName = document.getElementById('file-name');

                            if (file) {
                                fileName.textContent = file.name;
                                const reader = new FileReader();
                                reader.onload = function (e) {
                                    previewImage.src = e.target.result;
                                    previewContainer.classList.remove('hidden');
                                }
                                reader.readAsDataURL(file);
                            } else {
                                fileName.textContent = 'No file chosen';
                                previewContainer.classList.add('hidden');
                            }
                        });
                    </script>

                </div>
            </div>
        </form>
    </div>
</x-librarian-layout>