<x-librarian-layout>
    <div class="p-8 bg-[#F8F7F4] min-h-screen">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <a href="{{ route('staff.menus.index') }}"
                    class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 text-sm mb-4 group">
                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    Back to Menus
                </a>
                <span
                    class="inline-block py-1 px-3 rounded-full bg-gray-900 text-white text-xs font-bold tracking-wide mb-2">ADMIN
                    PANEL</span>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Menu Item</h1>
                <p class="text-gray-500 mt-2">Modify the navigation link: <span
                        class="font-medium text-gray-700">{{ $menu->label }}</span></p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 max-w-3xl">
            <form action="{{ route('staff.menus.update', $menu) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="space-y-6">
                    <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3">Basic Information</h3>

                    <!-- Label -->
                    <div>
                        <label for="label" class="block text-sm font-bold text-gray-700 mb-2">Menu Label <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="label" id="label" value="{{ old('label', $menu->label) }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition"
                            placeholder="e.g., About Us, Contact, Resources" required>
                        @error('label')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Link Type -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Link Type <span
                                class="text-red-500">*</span></label>
                        <div class="grid grid-cols-2 gap-4">
                            <label
                                class="relative flex items-center gap-3 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-brand-300 transition has-[:checked]:border-brand-500 has-[:checked]:bg-brand-50">
                                <input type="radio" name="link_type" value="internal"
                                    {{ old('link_type', $menu->link_type ?? 'internal') === 'internal' ? 'checked' : '' }}
                                    class="w-4 h-4 text-brand-600 focus:ring-brand-500" id="link_type_internal">
                                <div>
                                    <span class="block font-medium text-gray-900">Internal Page</span>
                                    <span class="text-sm text-gray-500">Link to a page within this website</span>
                                </div>
                            </label>
                            <label
                                class="relative flex items-center gap-3 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-brand-300 transition has-[:checked]:border-brand-500 has-[:checked]:bg-brand-50">
                                <input type="radio" name="link_type" value="external"
                                    {{ old('link_type', $menu->link_type ?? 'internal') === 'external' ? 'checked' : '' }}
                                    class="w-4 h-4 text-brand-600 focus:ring-brand-500" id="link_type_external">
                                <div>
                                    <span class="block font-medium text-gray-900">External Resource</span>
                                    <span class="text-sm text-gray-500">Link to another website or URL</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- URL / Page Select -->
                    <div x-data="{ linkType: '{{ old('link_type', $menu->link_type ?? 'internal') }}' }">
                        <div x-show="linkType === 'internal'" class="space-y-2">
                            <label for="page_select" class="block text-sm font-bold text-gray-700">Select Page</label>
                            <select name="page_url" id="page_select"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition">
                                <option value="">-- Select a page or use URL below --</option>
                                <option value="/" {{ $menu->url === '/' ? 'selected' : '' }}>Home</option>
                                <option value="#books" {{ $menu->url === '#books' ? 'selected' : '' }}>Books Section
                                </option>
                                <option value="#news" {{ $menu->url === '#news' ? 'selected' : '' }}>News Section
                                </option>
                                <option value="#team" {{ $menu->url === '#team' ? 'selected' : '' }}>Team Section
                                </option>
                                @foreach ($pages as $page)
                                    <option value="{{ route('pages.show', $page->slug, false) }}"
                                        {{ $menu->url === route('pages.show', $page->slug, false) ? 'selected' : '' }}>
                                        {{ $page->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <label for="url" class="block text-sm font-bold text-gray-700 mb-2">
                                <span x-show="linkType === 'internal'">Or Enter Custom URL</span>
                                <span x-show="linkType === 'external'">External URL <span
                                        class="text-red-500">*</span></span>
                            </label>
                            <input type="text" name="url" id="url" value="{{ old('url', $menu->url) }}"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition"
                                :placeholder="linkType === 'internal' ? '/pages/about or /custom-path' :
                                    'https://example.com'"
                                required>
                            @error('url')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const internalRadio = document.getElementById('link_type_internal');
                                const externalRadio = document.getElementById('link_type_external');
                                const pageSelect = document.getElementById('page_select');
                                const urlInput = document.getElementById('url');

                                function updateLinkType() {
                                    if (internalRadio.checked) {
                                        document.querySelector('[x-data]').__x.$data.linkType = 'internal';
                                    } else {
                                        document.querySelector('[x-data]').__x.$data.linkType = 'external';
                                    }
                                }

                                internalRadio.addEventListener('change', updateLinkType);
                                externalRadio.addEventListener('change', updateLinkType);

                                pageSelect.addEventListener('change', function() {
                                    if (this.value) {
                                        urlInput.value = this.value;
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>

                <!-- Additional Options -->
                <div class="space-y-6 pt-6 border-t border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900">Additional Options</h3>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description
                            (Optional)</label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition"
                            placeholder="Brief description of this menu item (shown in some themes)">{{ old('description', $menu->description) }}</textarea>
                    </div>

                    <!-- Parent Menu -->
                    <div>
                        <label for="parent_id" class="block text-sm font-bold text-gray-700 mb-2">Parent Menu
                            (Optional)</label>
                        <select name="parent_id" id="parent_id"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition">
                            <option value="">-- Top Level Menu --</option>
                            @foreach ($parentMenus as $parent)
                                <option value="{{ $parent->id }}"
                                    {{ old('parent_id', $menu->parent_id) == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->label }}</option>
                            @endforeach
                        </select>
                        <p class="text-gray-400 text-sm mt-1">Leave empty for top-level navigation</p>
                    </div>

                    <!-- Open in New Tab -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                        <div>
                            <span class="block font-medium text-gray-900">Open in New Tab</span>
                            <span class="text-sm text-gray-500">Link will open in a new browser tab</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="target" value="_self">
                            <input type="checkbox" name="target" value="_blank"
                                {{ old('target', $menu->target) === '_blank' ? 'checked' : '' }} class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-brand-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-600">
                            </div>
                        </label>
                    </div>

                    <!-- Visibility -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                        <div>
                            <span class="block font-medium text-gray-900">Visible on Website</span>
                            <span class="text-sm text-gray-500">Show this menu item in the navigation</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_visible" value="1"
                                {{ old('is_visible', $menu->is_visible ?? true) ? 'checked' : '' }}
                                class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-brand-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-600">
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center gap-4 pt-6 border-t border-gray-100">
                    <button type="submit"
                        class="px-8 py-4 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl transition shadow-lg shadow-brand-600/20 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Menu Item
                    </button>
                    <a href="{{ route('staff.menus.index') }}"
                        class="px-6 py-4 text-gray-600 hover:text-gray-900 font-medium transition">Cancel</a>
                </div>
            </form>
        </div>

        <!-- Danger Zone -->
        <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-8 max-w-3xl mt-8">
            <h3 class="text-lg font-bold text-red-700 mb-4">Danger Zone</h3>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-700 font-medium">Delete this menu item</p>
                    <p class="text-sm text-gray-500">This action cannot be undone. Any child menu items will also be
                        deleted.</p>
                </div>
                <form action="{{ route('staff.menus.destroy', $menu) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this menu item? This cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-6 py-3 bg-red-50 hover:bg-red-100 text-red-600 font-bold rounded-xl transition">
                        Delete Menu
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-librarian-layout>