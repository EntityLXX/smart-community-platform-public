<x-app-layout>
    <x-slot name="header">
        <div class="relative flex items-center gap-4">
            <!-- Icon Circle with subtle outlined background -->
            <div class="relative z-10">
                <!-- Outer outline ring -->
                <div class="absolute inset-0 scale-110 rounded-full ring-2 ring-purple-600 dark:ring-purple-500"></div>

                <!-- Main Icon Circle -->
                <div
                    class="w-14 h-14 bg-purple-600 dark:bg-purple-500 rounded-full flex items-center justify-center shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-7 h-7 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 2.994v2.25m10.5-2.25v2.25m-14.252 13.5V7.491a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v11.251m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5m-6.75-6h2.25m-9 2.25h4.5m.002-2.25h.005v.006H12v-.006Zm-.001 4.5h.006v.006h-.006v-.005Zm-2.25.001h.005v.006H9.75v-.006Zm-2.25 0h.005v.005h-.006v-.005Zm6.75-2.247h.005v.005h-.005v-.005Zm0 2.247h.006v.006h-.006v-.006Zm2.25-2.248h.006V15H16.5v-.005Z" />
                    </svg>
                </div>
            </div>

            <!-- Header Text -->
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Event
            </h2>
        </div>
    </x-slot>


    <div class="py-6 px-6">
        <x-breadcrumbs :items="[
        ['label' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Events', 'url' => route('admin.events.index')],
        ['label' => 'Edit Event']
    ]" />

        <div class="relative max-w-4xl mx-auto ring-2 ring-purple-500 rounded-3xl">
            <div class="absolute inset-0 translate-x-2 translate-y-2 bg-purple-500 rounded-3xl z-0"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 space-y-6 z-10">
                <form id="eventEditForm" action="{{ route('admin.events.update', $event->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Event Name --}}
                    <div class="mb-4">
                        <label for="event_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Event
                            Name</label>
                        <input type="text" name="event_name" id="event_name"
                            value="{{ old('event_name', $event->event_name) }}"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 @error('event_name') border-red-500 @enderror">
                        @error('event_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label for="description"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 @error('description') border-red-500 @enderror">{{ old('description', $event->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Date --}}
                    <div class="mb-4">
                        <label for="date"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                        <input type="date" name="date" id="date" value="{{ old('date', $event->date) }}"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 @error('date') border-red-500 @enderror">
                        @error('date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Time --}}
                    <div class="mb-4">
                        <label for="time"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Time</label>
                        <input type="time" name="time" id="time" value="{{ old('time', $event->time) }}"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 @error('time') border-red-500 @enderror">
                        @error('time')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Location --}}
                    <div class="mb-4">
                        <label for="location"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Location</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 @error('location') border-red-500 @enderror">
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Current Picture Preview --}}
                    @if ($event->picture)
                        <div class="mb-4">
                            <p class="text-sm text-gray-300">Current Poster:</p>
                            <img src="{{ asset('storage/' . $event->picture) }}" alt="Event Poster"
                                class="w-32 h-auto rounded shadow border mb-2">
                        </div>
                    @endif

                    {{-- Optional Picture Upload --}}
                    <div class="mb-4">
                        <label for="picture" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Change
                            Picture (optional)</label>
                        <input type="file" name="picture" id="picture"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:text-white @error('picture') border-red-500 @enderror">
                        @error('picture')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.events.index') }}"
                            class="inline-block px-4 py-2 bg-gray-300 text-black rounded hover:bg-gray-400">Cancel</a>
                        <button type="button" onclick="window.confirmModal.open(
                            'Confirm Update',
                            'Are you sure you want to update this event?',
                            () => document.getElementById('eventEditForm').submit(),
                            'warning'
                        )" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            Save Changes
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>