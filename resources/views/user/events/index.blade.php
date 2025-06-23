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
                Community Events
            </h2>
        </div>
    </x-slot>

    <div class="py-6 px-6" x-data="{ tab: 'upcoming' }">
        <x-breadcrumbs :items="[
        ['label' => auth()->user()->role === 'admin' ? 'Admin Dashboard' : 'User Dashboard', 'url' => auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard')],
        ['label' => 'Community Events']
    ]" />

        <div x-data="{
    current: 0,
    total: {{ $latestEvents->count() }},
    get indexes() {
        return Array.from({ length: this.total }, (_, i) => i)
    },
    next() { this.current = (this.current + 1) % this.total },
    prev() { this.current = (this.current - 1 + this.total) % this.total },
    autoplay() { setInterval(() => this.next(), 5000) }
}" x-init="autoplay()" class="relative w-full max-w-7xl mx-auto mb-10 overflow-hidden rounded-3xl shadow-lg">
            <div class="relative w-full h-64 sm:h-80 lg:h-96">
                @foreach ($latestEvents as $index => $event)
                    <div x-show="current === {{ $index }}" x-transition:enter="transition-opacity duration-1000"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition-opacity duration-500" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" class="w-full h-64 sm:h-80 lg:h-96 absolute inset-0">
                        <a href="{{ route('user.events.show', $event->id) }}">
                            <img src="{{ $event->picture ? asset('storage/' . $event->picture) : 'https://via.placeholder.com/800x400?text=No+Image' }}"
                                alt="{{ $event->event_name }}" class="w-full h-full object-cover">
                            <div
                                class="absolute bottom-0 left-0 bg-black bg-opacity-60 text-white px-4 py-2 text-lg font-semibold w-full">
                                {{ $event->event_name }}
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Navigation Arrows -->
            <!-- Left Arrow Button -->
            <button @click="prev"
                class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black text-white p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </button>

            <!-- Right Arrow Button -->
            <button @click="next"
                class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black text-white p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </button>

            <!-- Navigation Dots -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2">
                <template x-for="index in indexes" :key="index">
                    <button @click="current = index" :class="current === index
        ? 'w-3 h-3 rounded-full bg-purple-600'
        : 'w-3 h-3 rounded-full bg-gray-300 dark:bg-gray-600'" class="transition duration-300">
                    </button>
                </template>

            </div>


        </div>


        <!-- Toggle Tabs -->
        <div class="flex justify-center mb-6 space-x-4">
            <button @click="tab = 'upcoming'" :class="tab === 'upcoming' ? 'bg-purple-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300'"
                class="px-4 py-2 rounded-full text-sm font-semibold transition focus:outline-none">
                Upcoming Events
            </button>
            <button @click="tab = 'past'" :class="tab === 'past' ? 'bg-purple-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300'"
                class="px-4 py-2 rounded-full text-sm font-semibold transition focus:outline-none">
                Past Events
            </button>
        </div>

        {{-- Upcoming Events --}}
        <div x-show="tab === 'upcoming'" x-cloak>
            <h3 class="text-xl font-bold text-purple-600 dark:text-purple-400 mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                </svg>
                Upcoming Events
            </h3>
            <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($upcomingEvents as $event)
                    @include('user.events._card', ['event' => $event])
                @empty
                    <p class="text-center text-gray-600 dark:text-gray-300 col-span-full">No upcoming events.</p>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $upcomingEvents->appends(['past' => $pastEvents->currentPage()])->links() }}
            </div>

        </div>

        {{-- Past Events --}}
        <div x-show="tab === 'past'" x-cloak>
            <h3 class="text-xl font-bold text-gray-600 dark:text-gray-400 mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                Past Events
            </h3>
            <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($pastEvents as $event)
                    @include('user.events._card', ['event' => $event])
                @empty
                    <p class="text-center text-gray-600 dark:text-gray-300 col-span-full">No past events.</p>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $pastEvents->appends(['upcoming' => $upcomingEvents->currentPage()])->links() }}
            </div>

        </div>

    </div>
    </div>
</x-app-layout>