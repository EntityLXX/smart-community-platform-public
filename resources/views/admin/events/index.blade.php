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
                Event Management
            </h2>
        </div>
    </x-slot>


    <div class="py-6 px-6">
        <x-breadcrumbs :items="[
        ['label' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Events']
    ]" />

        <div class="max-w-7xl mx-auto space-y-6">


            <div class="flex justify-end mb-4">
                <a href="{{ route('admin.events.create') }}"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    + Create Event
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="relative ring-2 ring-purple-500 rounded-3xl">
                <div class="absolute inset-0 translate-x-2 translate-y-2 bg-purple-500 rounded-3xl z-0"></div>
                <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 space-y-6 z-10">


                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left font-medium">No.</th>
                                <th class="px-4 py-2 text-left font-medium">Picture</th>
                                <th class="px-4 py-2 text-left font-medium">Event Name</th>
                                <th class="px-4 py-2 text-left font-medium">Description</th>
                                <th class="px-4 py-2 text-left font-medium">Date</th>
                                <th class="px-4 py-2 text-left font-medium">Time</th>
                                <th class="px-4 py-2 text-left font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody
                            class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($events as $index => $event)
                                <tr>
                                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2" x-data="{ showModal: false }">
                                        @if ($event->picture)
                                            {{-- Thumbnail (click to open modal) --}}
                                            <img @click="showModal = true" src="{{ asset('storage/' . $event->picture) }}"
                                                alt="Event Poster"
                                                class="w-16 h-16 object-cover rounded cursor-pointer transition hover:scale-105 duration-200 shadow" />

                                            {{-- Modal --}}
                                            <div x-show="showModal" x-transition x-cloak
                                                @keydown.escape.window="showModal = false"
                                                class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50 px-4">

                                                <div
                                                    class="relative max-w-4xl w-full max-h-[90vh] overflow-auto p-4 bg-white rounded shadow-lg">

                                                    <!-- ✕ Close Button -->
                                                    <button @click="showModal = false"
                                                        class="absolute top-0 right-0 z-10 text-black text-3xl font-bold rounded hover:text-red-600 focus:outline-none">
                                                        ✕
                                                    </button>

                                                    <!-- Full Image -->
                                                    <img src="{{ asset('storage/' . $event->picture) }}" alt="Event Poster Full"
                                                        class="w-full h-auto object-contain rounded">

                                                    <!-- Optional Back Button -->
                                                    <div class="mt-4 text-center">
                                                        <button @click="showModal = false"
                                                            class="inline-block px-6 py-2 bg-gray-700 text-white text-sm rounded hover:bg-gray-600 transition">
                                                            ← Back
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic">No image</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">{{ Str::limit($event->event_name) }}</td>
                                    <td class="px-4 py-2">{{ Str::limit($event->description, 30) }}</td>
                                    <td class="px-4 py-2">{{ $event->date }}</td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</td>
                                    <td class="px-4 py-2">
                                        <div class="flex gap-2">
                                        <a href="{{ route('admin.events.edit', $event->id) }}"
                                            class="text-yellow-500 hover:underline">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </a>
                                        <form id="deleteForm-{{ $event->id }}"
                                            action="{{ route('admin.events.destroy', $event->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="window.confirmModal.open(
                                                        'Delete Event',
                                                        'Are you sure you want to delete the event: {{ addslashes($event->event_name) }}?',
                                                        () => document.getElementById('deleteForm-{{ $event->id }}').submit(),
                                                         'danger'
                                                    )" class="text-red-500 hover:underline">
                                                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $events->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>