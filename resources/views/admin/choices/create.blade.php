<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Add New Choice for "{{ $voting->title }}"
        </h2>
    </x-slot>

    <div class="py-6 px-6">
        <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">

            {{-- Back Button --}}
            <div class="flex mb-4">
                <a href="{{ route('admin.votings.show', $voting) }}"
                    class="inline-block px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                    ← Back to Voting Details
                </a>
            </div>

            {{-- Form --}}
            <form action="{{ route('admin.votings.choices.store', $voting) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Choice Name
                    </label>
                    <input type="text" name="name"
                        class="mt-1 block w-full rounded border-gray-300 dark:bg-gray-700 dark:text-white dark:border-gray-600 shadow-sm @error('title') border-red-500 @enderror"
                        value="{{ old('title') }}" required>
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="flex items-center gap-1 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Add Choice
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>