<!-- Logout Modal (Global) -->
<div x-data="{ show: false }" x-show="show" @open-logout-modal.window="show = true"
    @keydown.escape.window="show = false"
    class="fixed inset-0 z-[9999] flex items-center justify-center bg-black bg-opacity-60" style="display: none;"
    x-cloak>
    <div class="bg-white rounded-xl shadow-2xl p-8 max-w-sm w-full mx-4 transform transition-all"
        @click.away="show = false" x-show="show" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        <h3 class="text-xl font-bold text-gray-900 mb-2">Confirm Logout</h3>
        <p class="text-gray-600 mb-8">Are you sure you want to end your session?</p>
        <div class="flex justify-end space-x-3">
            <button @click="show = false"
                class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300">
                Cancel
            </button>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="px-5 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow-lg shadow-red-200 transition-all focus:outline-none focus:ring-2 focus:ring-red-500">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</div>