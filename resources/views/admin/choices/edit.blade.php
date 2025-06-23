<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Choice
        </h2>
    </x-slot>

    <div class="py-12 px-6">
        <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">

            {{-- Back Button --}}
            <div class="flex mb-4">
                <a href="{{ route('admin.votings.show', $voting) }}"
                   class="inline-block px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                    ← Back to Voting Details
                </a>
            </div>

            {{-- Form --}}
            <form action="{{ route('admin.votings.choices.update', [$voting, $choice]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Choice Name
                    </label>
                    <input type="text" name="name"
                        class="mt-1 block w-full rounded border-gray-300 dark:bg-gray-700 dark:text-white dark:border-gray-600 shadow-sm @error('name') border-red-500 @enderror"
                        value="{{ old('name', $choice->name) }}" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                        Update Choice
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
