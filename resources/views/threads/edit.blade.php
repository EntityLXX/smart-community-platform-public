<x-app-layout>
    <x-slot name="header">
        <div class="relative flex items-center gap-4">
            <!-- Icon Circle with subtle outlined background -->
            <div class="relative z-10">
                <!-- Outer outline ring -->
                <div class="absolute inset-0 scale-110 rounded-full ring-2 ring-yellow-600 dark:ring-yellow-500"></div>

                <!-- Main Icon Circle -->
                <div
                    class="w-14 h-14 bg-yellow-600 dark:bg-yellow-500 rounded-full flex items-center justify-center shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-7 h-7 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 12a9.75 9.75 0 1 1 18.356 5.112c-.203.35-.313.75-.313 1.163V21l-4.226-2.111a9.749 9.749 0 0 1-13.817-6.889z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 11.25h.008v.008H8v-.008zm4 0h.008v.008H12v-.008zm4 0h.008v.008H16v-.008z" />
                    </svg>
                </div>
            </div>

            <!-- Header Text -->
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
                Edit Thread
            </h2>
        </div>
    </x-slot>


    <div class="py-6 px-6">
        <x-breadcrumbs :items="[
        ['label' => auth()->user()->role === 'admin' ? 'Admin Dashboard' : 'User Dashboard', 'url' => auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard')],
        ['label' => 'Communication Hub', 'url' => route('threads.index')],
        ['label' => 'Edit Thread']
    ]" />

    </div>

    <div class="relative max-w-3xl mx-auto ring-2 ring-yellow-500 rounded-3xl">
        <div class="absolute inset-0 translate-x-2 translate-y-2 bg-yellow-500 rounded-3xl z-0"></div>
        <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 space-y-6 z-10">


            <form id="editThreadForm" method="POST" action="{{ route('threads.update', $thread) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block font-semibold text-sm dark:text-white">Thread Title</label>
                    <input id="title" name="title" type="text" class="w-full mt-1 rounded border-gray-300"
                        value="{{ old('title', $thread->title) }}" required>
                </div>

                <div>
                    <label for="description" class="block font-semibold text-sm dark:text-white">Short
                        Description</label>
                    <textarea id="description" name="description" rows="2" class="w-full mt-1 rounded border-gray-300"
                        required>{{ old('description', $thread->description) }}</textarea>
                </div>

                <div>
                    <label for="content" class="block font-semibold text-sm dark:text-white">Content</label>
                    <textarea id="content" name="content" rows="5" class="w-full mt-1 rounded border-gray-300"
                        required>{{ old('content', $thread->content) }}</textarea>
                </div>

                @if (auth()->user()->role === 'admin')
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="type" value="announcement" id="type" {{ $thread->type === 'announcement' ? 'checked' : '' }}>
                        <label for="type" class="text-sm dark:text-white">Post as Announcement</label>
                    </div>
                @else
                    <input type="hidden" name="type" value="normal">
                @endif

                <div class="flex justify-end gap-4">
                    <a href="{{ route('threads.show', $thread) }}"
                        class="inline-block px-4 py-2 bg-gray-300 text-black rounded hover:bg-gray-400">Cancel</a>
                    <button type="button" onclick="window.confirmModal.open(
                                'Update Thread',
                                'Are you sure you want to apply the changes to this thread?',
                                () => document.getElementById('editThreadForm').submit(),
                                'warning'
                            )" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>