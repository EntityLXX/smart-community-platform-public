<x-app-layout>
    <x-slot name="header">
        <div class="relative flex items-center gap-4">
            <div class="relative z-10">
                <div class="absolute inset-0 scale-110 rounded-full ring-2 ring-red-600 dark:ring-red-500"></div>
                <div class="w-14 h-14 bg-red-600 dark:bg-red-500 rounded-full flex items-center justify-center shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-7 h-7 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
            </div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">Edit User</h2>
        </div>
    </x-slot>

    <div class="py-6 px-6">
        <x-breadcrumbs :items="[
            ['label' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'User Management', 'url' => route('admin.users.index')],
            ['label' => 'Edit User']
        ]" />

        <div class="relative max-w-2xl mx-auto ring-2 ring-red-500 rounded-3xl">
            <div class="absolute inset-0 translate-x-2 translate-y-2 bg-red-500 rounded-3xl z-0"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 space-y-6 z-10">
                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Name</label>
                        <input type="text" value="{{ $user->name }}" disabled
                            class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 text-gray-700 dark:text-white" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                        <input type="email" value="{{ $user->email }}" disabled
                            class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 text-gray-700 dark:text-white" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Role</label>
                        <select name="role"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-white text-gray-700 dark:text-black">
                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    @if ($user->role === 'admin')
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" id="can_manage_facility" name="can_manage_facility" value="1" {{ $user->can_manage_facility ? 'checked' : '' }}
                                class="rounded border-gray-300 text-teal-600 shadow-sm focus:ring-teal-500">
                            <label for="can_manage_facility" class="text-gray-700 dark:text-gray-200">
                                Can Manage Financial Transactions
                            </label>
                        </div>
                    @endif



                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('admin.users.index') }}"
                            class="inline-block px-4 py-2 bg-gray-300 text-black rounded hover:bg-gray-400">Cancel</a>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Save
                            Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
