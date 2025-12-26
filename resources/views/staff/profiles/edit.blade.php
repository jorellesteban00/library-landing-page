<x-librarian-layout>
    <div class="p-8 bg-[#F8F7F4] min-h-screen">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Staff Member</h1>
                    <p class="text-gray-500 mt-1">Update profile details for {{ $staffProfile->name }}</p>
                </div>
                <a href="{{ route('staff.staff-profiles.index') }}"
                    class="px-6 py-3 bg-white text-gray-700 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 hover:border-gray-300 transition shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Staff
                </a>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <form action="{{ route('staff.staff-profiles.update', $staffProfile) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ $staffProfile->name }}"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50"
                                required>
                        </div>

                        <!-- Role Selection -->
                        <div>
                            <label for="role_text" class="block text-sm font-bold text-gray-700 mb-2">Role /
                                Title</label>
                            <div class="relative">
                                <select name="role_text" id="role_text"
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50 appearance-none cursor-pointer"
                                    required>
                                    <option value="Head Librarian" {{ $staffProfile->role_text == 'Head Librarian' ? 'selected' : '' }}>Head Librarian</option>
                                    <option value="Assistant Librarian" {{ $staffProfile->role_text == 'Assistant Librarian' ? 'selected' : '' }}>Assistant Librarian</option>
                                    <option value="Archivist" {{ $staffProfile->role_text == 'Archivist' ? 'selected' : '' }}>Archivist</option>
                                    <option value="Staff" {{ $staffProfile->role_text == 'Staff' ? 'selected' : '' }}>
                                        Staff</option>
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
                    </div>

                    <!-- Bio -->
                    <div>
                        <label for="bio" class="block text-sm font-bold text-gray-700 mb-2">Biography</label>
                        <textarea name="bio" id="bio" rows="4"
                            class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 transition bg-gray-50 resize-y">{{ $staffProfile->bio }}</textarea>
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Profile Photo</label>
                        <div class="flex flex-col items-center gap-4 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                            @if($staffProfile->image)
                                <img src="{{ asset('storage/' . $staffProfile->image) }}"
                                    class="w-32 h-32 rounded-full object-cover shadow-md border-4 border-white">
                            @else
                                <div
                                    class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="w-full">
                                <label for="image"
                                    class="block w-full text-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 cursor-pointer transition">
                                    Change Photo
                                    <input id="image" name="image" type="file" class="hidden" accept="image/*"
                                        onchange="document.getElementById('file-chosen').textContent = this.files[0].name" />
                                </label>
                                <span id="file-chosen" class="block text-center text-xs text-gray-500 mt-2">No file
                                    chosen</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                        <button type="button"
                            onclick="if(confirm('Are you sure you want to delete this staff member?')) document.getElementById('delete-staff-form').submit()"
                            class="text-red-600 hover:text-red-900 font-bold px-4 py-2 rounded-lg hover:bg-red-50 transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            Delete Profile
                        </button>

                        <button type="submit"
                            class="px-8 py-3 bg-brand-600 text-white font-bold rounded-xl hover:bg-brand-700 transition shadow-lg shadow-brand-600/30 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Profile
                        </button>
                    </div>
                </form>

                <form id="delete-staff-form" action="{{ route('staff.staff-profiles.destroy', $staffProfile) }}"
                    method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</x-librarian-layout>