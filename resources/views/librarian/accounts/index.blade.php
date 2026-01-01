<x-librarian-layout>
    <div class="p-8 bg-[#F8F7F4] min-h-screen">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <span
                    class="inline-block py-1 px-3 rounded-full bg-brand-600 text-white text-xs font-bold tracking-wide mb-2">ADMIN/STAFF
                    PANEL</span>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Account Management</h1>
                <p class="text-gray-500 mt-1">Manage user roles and privileges.</p>
            </div>
            <button type="button" @click="$dispatch('open-logout-modal')"
                class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-2 px-6 rounded-full transition shadow-lg">
                Sign Out
            </button>
        </div>

        @if (session('status'))
            <div class="mb-6 p-4 bg-brand-50 text-brand-700 rounded-xl border border-brand-100 flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('status') }}
            </div>
        @endif

        <div class="mb-6">
            <form action="{{ route('librarian.accounts.index') }}" method="GET" class="w-full md:max-w-md">
                <div class="relative flex gap-2">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by name or email..."
                        class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition bg-white">
                    <button type="submit"
                        class="px-4 py-3 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl transition">
                        Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('librarian.accounts.index') }}"
                            class="px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold rounded-xl transition">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Current Role
                            </th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($users as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-brand-100 flex items-center justify-center text-brand-600 font-bold mr-3">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div class="font-bold text-gray-900">{{ $user->name }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $badgeColor = 'bg-gray-100 text-gray-800';
                                        $roleLabel = 'User';
                                        if ($user->role === 'librarian') {
                                            $badgeColor = 'bg-purple-100 text-purple-800';
                                            $roleLabel = 'Librarian';
                                        } elseif ($user->role === 'staff') {
                                            if ($user->staff_type === 'books') {
                                                $badgeColor = 'bg-blue-100 text-blue-800';
                                                $roleLabel = 'Staff (Books)';
                                            } elseif ($user->staff_type === 'news') {
                                                $badgeColor = 'bg-emerald-100 text-emerald-800';
                                                $roleLabel = 'Staff (News)';
                                            } else {
                                                $badgeColor = 'bg-yellow-100 text-yellow-800';
                                                $roleLabel = 'Staff (General)';
                                            }
                                        }
                                    @endphp
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeColor }}">
                                        {{ $roleLabel }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('librarian.accounts.update', $user) }}" method="POST"
                                        class="flex items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <select name="role_selection"
                                            class="text-sm border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg shadow-sm"
                                            onchange="this.form.submit()">
                                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User
                                            </option>
                                            <option value="librarian" {{ $user->role === 'librarian' ? 'selected' : '' }}>
                                                Librarian</option>
                                            <option value="staff_books" {{ $user->role === 'staff' && $user->staff_type === 'books' ? 'selected' : '' }}>
                                                Book Staff</option>
                                            <option value="staff_news" {{ $user->role === 'staff' && $user->staff_type === 'news' ? 'selected' : '' }}>
                                                News Staff</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-librarian-layout>
