<x-app-layout>
    <x-slot name="header">
        <div class="relative flex items-center gap-4">
            <!-- Icon Circle with subtle outlined background -->
            <div class="relative z-10">
                <!-- Outer outline ring -->
                <div class="absolute inset-0 scale-110 rounded-full ring-2 ring-red-600 dark:ring-red-500"></div>

                <!-- Main Icon Circle -->
                <div
                    class="w-14 h-14 bg-red-600 dark:bg-red-500 rounded-full flex items-center justify-center shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-7 h-7 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
            </div>

            <!-- Header Text -->
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                User Management
            </h2>
        </div>
    </x-slot>


    <div class="py-6 px-6">
        <x-breadcrumbs :items="[
        ['label' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'User Management']
    ]" />

        <div class="max-w-5xl mx-auto space-y-6">

            {{-- 🔍 Search & Filter (aligned right) --}}
            <div class="flex justify-end mb-4">
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap items-center gap-2">
                    <input type="text" name="search" placeholder="Search by name/email" value="{{ request('search') }}"
                        class="border-gray-300 rounded px-3 py-1.5 text-sm dark:bg-gray-700 dark:text-white" />

                    <select name="role"
                        class="border-gray-300 rounded px-3 py-1.5 text-sm dark:bg-gray-700 dark:text-white">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                    </select>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-1.5 rounded text-sm hover:bg-blue-700">
                        Filter
                    </button>
                </form>
            </div>

            {{-- User Table --}}
            <div class="relative ring-2 ring-red-500 rounded-3xl">
                <div class="absolute inset-0 translate-x-2 translate-y-2 bg-red-500 rounded-3xl z-0"></div>
                <div
                    class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-x-auto text-gray-800 dark:text-white p-6 z-10">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left font-medium">Profile</th>
                                <th class="px-4 py-2 text-left font-medium">Name</th>
                                <th class="px-4 py-2 text-left font-medium">Email</th>
                                <th class="px-4 py-2 text-left font-medium">Role</th>
                                <th class="px-4 py-2 text-left font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody
                            class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="px-4 py-2">
                                        <img src="{{ $user->profilePhotoUrl }}" alt="Profile"
                                            class="w-10 h-10 rounded-full">
                                    </td>
                                    <td class="px-4 py-2">{{ $user->name }}</td>
                                    <td class="px-4 py-2">{{ $user->email }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 text-xs rounded-full
                                                @if ($user->isSuperAdmin())
                                                    bg-red-200 text-red-800
                                                @elseif ($user->role === 'admin')
                                                    bg-blue-200 text-blue-800
                                                @else
                                                    bg-gray-300 text-gray-700
                                                @endif">
                                            {{ $user->isSuperAdmin() ? 'Super Admin' : ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-3 flex-wrap">

                                            {{-- Edit Button - Only Super Admin can edit Admins and other users --}}
                                            @php
                                                $auth = auth()->user();
                                                $canEdit = $auth->isSuperAdmin() || (!$user->isAdmin() && $auth->id !== $user->id);
                                            @endphp

                                            @if ($canEdit)
                                                <a href="{{ route('admin.users.edit', $user) }}"
                                                    class="text-yellow-600 hover:underline flex items-center gap-1 text-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                    Edit
                                                </a>
                                            @else
                                                <span class="flex items-center gap-1 text-gray-400 text-sm italic">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                    Protected
                                                </span>
                                            @endif

                                            {{-- Delete Button - Only for non-admins --}}
                                            @if (!$user->isAdmin())
                                                <form id="deleteForm-{{ $user->id }}"
                                                    action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="window.confirmModal.open(
                                                            'Delete User',
                                                            'Are you sure you want to delete the user: {{ addslashes($user->name) }}?',
                                                            () => document.getElementById('deleteForm-{{ $user->id }}').submit(),
                                                            'danger'
                                                        )" class="text-red-500 hover:underline flex items-center gap-1 text-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            @else
                                                <span class="flex items-center gap-1 text-gray-400 text-sm italic">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                    Protected
                                                </span>
                                            @endif

                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-4 text-center text-gray-500 dark:text-gray-300">
                                        No users found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- 📄 Pagination --}}
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>

</x-app-layout>