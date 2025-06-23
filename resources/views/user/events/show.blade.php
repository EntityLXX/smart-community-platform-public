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
                Event Details
            </h2>
        </div>
    </x-slot>

    <div class="py-6 px-6">
        <x-breadcrumbs :items="[
        ['label' => auth()->user()->role === 'admin' ? 'Admin Dashboard' : 'User Dashboard', 'url' => auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard')],
        ['label' => 'Events', 'url' => route('user.events.index')],
        ['label' => 'Event Details']
    ]" />


        <div class="relative max-w-3xl mx-auto">
            <!-- Offset background -->
            <div class="absolute inset-0 translate-x-2 translate-y-2 bg-purple-600 rounded-3xl z-0"></div>

            <!-- Foreground card with purple ring -->
            <div
                class="relative bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 p-6 rounded-3xl shadow-lg ring-2 ring-purple-600 dark:ring-purple-500 z-10">
                <div class="mb-6">
                    <a href="{{ route('user.events.index') }}"
                        class="inline-block px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                        ← Back to Events
                    </a>
                </div>

                @if ($event->picture)
                    <div x-data="{ showLightbox: false }">
                        <!-- Thumbnail -->
                        <img @click="showLightbox = true" src="{{ asset('storage/' . $event->picture) }}"
                            alt="{{ $event->event_name }}"
                            class="max-w-full max-h-[70vh] w-auto h-auto object-contain rounded mx-auto mb-6 cursor-zoom-in transition duration-200 hover:scale-105" />

                        <!-- Lightbox Modal -->
                        <div x-show="showLightbox" x-transition x-cloak @keydown.escape.window="showLightbox = false"
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-80 px-4">
                            <div
                                class="relative max-w-4xl w-full max-h-[90vh] overflow-auto p-4 bg-white rounded shadow-lg">

                                <!-- Large Visible Close Button -->
                                <button @click="showLightbox = false"
                                    class="absolute top-0 right-0 z-10 text-black text-3xl font-bold rounded hover:text-red-600 focus:outline-none">
                                    ✕
                                </button>

                                <!-- Image -->
                                <img src="{{ asset('storage/' . $event->picture) }}" alt="Zoomed Poster"
                                    class="w-full h-auto object-contain rounded">

                                <!-- Optional "Back" Button Below Image -->
                                <div class="mt-4 text-center">
                                    <button @click="showLightbox = false"
                                        class="inline-block px-6 py-2 bg-gray-700 text-white text-sm rounded hover:bg-gray-600 transition">
                                        ← Back
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                @endif

                <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">{{ $event->event_name }}</h3>
                <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $event->description }}</p>

                <div class="text-sm text-gray-500 dark:text-gray-400 space-y-1">
                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</p>
                    <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</p>
                    <p><strong>Location:</strong> {{ $event->location }}</p>
                </div>


            </div>
        </div> <!-- Foreground card -->
    </div> <!-- Wrapper with offset background -->

    </div>
</x-app-layout>