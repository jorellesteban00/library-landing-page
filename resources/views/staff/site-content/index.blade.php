<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Site Content') }}
            <a href="{{ url()->previous() }}" class="float-right text-sm text-blue-600 hover:text-blue-900">Back</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('staff.site-content.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Hero Title</label>
                            <input type="text" name="hero_title"
                                value="{{ $content['hero_title'] ?? 'Welcome to Our Library' }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Hero Subtitle</label>
                            <textarea name="hero_subtitle" rows="2"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $content['hero_subtitle'] ?? 'Discover a world of knowledge and imagination.' }}</textarea>
                        </div>

                        <!-- Add Vision/Mission if needed -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Vision</label>
                            <textarea name="vision" rows="3"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $content['vision'] ?? 'To be a center of excellence in information provision.' }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Mission</label>
                            <textarea name="mission" rows="3"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $content['mission'] ?? 'To provide quality resources and services to our community.' }}</textarea>
                        </div>

                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Save Content
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>