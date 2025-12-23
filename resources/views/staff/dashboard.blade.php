<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staff Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Quick Actions</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <a href="{{ route('home') }}"
                            class="block p-6 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition">
                            <h4 class="font-bold text-blue-700 mb-2">Manage Page Content</h4>
                            <p class="text-sm text-gray-600">Go to the Landing Page to add/edit News, Books, and Staff
                                profiles directly.</p>
                        </a>



                        <div
                            class="block p-6 bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100 transition">
                            <h4 class="font-bold text-purple-700 mb-2">General Site Content</h4>
                            <p class="text-sm text-gray-600">Edit core site information (Vision, Mission, Hero Text,
                                etc).</p>
                            <form action="{{ route('staff.site-content.store') }}" method="GET">
                                <!-- Hacky link to get to the edit view since I didn't make a dedicated GET route for edit, reusing index? 
                                      Wait, SiteContentController::index returns the view. So just link to a route that calls index.
                                      But index is not defined in routes?
                                      Route::post('/site-content', ...)->name('site-content.store');
                                      I need a GET route for the edit page. -->
                                <button type="button"
                                    onclick="window.location='{{ route('staff.site-content.index') }}'"
                                    class="mt-2 text-purple-600 font-bold underline">Edit Content</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>