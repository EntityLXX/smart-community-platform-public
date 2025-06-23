<x-app-layout>
    <x-slot name="header">
        <div class="relative flex items-center gap-4">
            <!-- Icon Circle with subtle outlined background -->
            <div class="relative z-10">
                <!-- Outer outline ring -->
                <div class="absolute inset-0 scale-110 rounded-full ring-2 ring-blue-600 dark:ring-blue-500"></div>

                <!-- Main Icon Circle -->
                <div
                    class="w-14 h-14 bg-blue-600 dark:bg-blue-500 text-white rounded-full flex items-center justify-center shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="size-10">
                    <path d="m9 12 2 2 4-4" />
                    <path d="M5 7c0-1.1.9-2 2-2h10a2 2 0 0 1 2 2v12H5V7Z" />
                    <path d="M22 19H2" />
                    </svg>
                </div>
            </div>

            <!-- Header Text -->
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Create New Voting
            </h2>
        </div>
    </x-slot>

    <div class="py-12 px-6">
        <x-breadcrumbs :items="[
        ['label' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Voting', 'url' => route('admin.votings.index')],
        ['label' => 'Create Voting']
    ]" />
        <div class="relative max-w-3xl mx-auto ring-2 ring-blue-500 rounded-3xl">
            <div class="absolute inset-0 translate-x-2 translate-y-2 bg-blue-500 rounded-3xl z-0"></div>
            <div
                class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 text-gray-800 dark:text-white z-10">

                {{-- Back button --}}
                <div class="flex mb-4">
                    <a href="{{ route('admin.votings.index') }}"
                        class="inline-block px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded hover:bg-gray-300 dark:hover:bg-gray-600">
                        ← Back to Voting List
                    </a>
                </div>

                {{-- Voting Form --}}
                <form id="votingCreateForm" action="{{ route('admin.votings.store') }}" method="POST">
                    @csrf

                    {{-- Title --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:text-black @error('title') border-red-500 @enderror">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                        <textarea name="description" rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:text-black @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Start Date --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:text-black @error('start_date') border-red-500 @enderror">
                        @error('start_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- End Date --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date</label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:text-black @error('end_date') border-red-500 @enderror">
                        @error('end_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Start Time --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Time</label>
                        <input type="time" name="start_time" value="{{ old('start_time') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:text-black @error('start_time') border-red-500 @enderror">
                        @error('start_time')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- End Time --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Time</label>
                        <input type="time" name="end_time" value="{{ old('end_time') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:text-black @error('end_time') border-red-500 @enderror">
                        @error('end_time')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- Status --}}
                    <!-- <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select name="status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:text-black @error('status') border-red-500 @enderror">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div> -->

                    {{-- Choices Section --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Voting Choices</label>

                        <div id="choicesWrapper" class="space-y-2 mt-2">
                            <input type="text" name="choices[]" placeholder="Choice 1"
                                class="block w-full rounded-md border-gray-300 shadow-sm dark:text-black" required>
                        </div>

                        <button type="button" onclick="addChoiceField()"
                            class="mt-2 flex items-center gap-1 px-4 py-1.5 text-sm rounded-full font-medium text-white bg-blue-600 hover:bg-blue-700 transition shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Add another choice </button>

                        @error('choices')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <script>
                        function addChoiceField() {
                            const wrapper = document.getElementById('choicesWrapper');
                            const input = document.createElement('input');
                            input.type = 'text';
                            input.name = 'choices[]';
                            input.placeholder = 'New choice';
                            input.className = 'block w-full rounded-md border-gray-300 dark:text-black mt-2';
                            input.required = true;
                            wrapper.appendChild(input);
                        }
                    </script>




                    {{-- Submit Button --}}
                    <div class="flex justify-end">
                        <button type="button" onclick="window.confirmModal.open(
                            'Create Voting',
                            'Are you sure you want to create this voting session?',
                            () => document.getElementById('votingCreateForm').submit(),
                            'info'
                        )" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Create Voting
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>