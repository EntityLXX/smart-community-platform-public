<div class="h-full group">
    <a href="{{ route('user.events.show', $event->id) }}" class="block h-full">
        <div class="relative h-full">
            <!-- Offset background layer that shifts on hover -->
            <div class="absolute inset-0 translate-x-2 translate-y-2 bg-purple-500 rounded-3xl z-0 transition duration-300 group-hover:translate-x-3 group-hover:translate-y-3"></div>

            <!-- Foreground event card with animated outline -->
            <div class="relative flex flex-col h-full bg-black text-white rounded-3xl shadow-lg z-10 overflow-hidden
                        ring-2 ring-purple-600 ring-offset-2 ring-offset-black
                        transition duration-300 ease-in-out group-hover:scale-[1.01] group-hover:shadow-xl">

                @if ($event->picture)
                    <img src="{{ asset('storage/' . $event->picture) }}" alt="{{ $event->event_name }}"
                        class="w-full h-48 object-cover rounded-t-3xl">
                @else
                    <div class="w-full h-48 bg-gray-700 flex items-center justify-center text-gray-400 rounded-t-3xl">
                        No Image
                    </div>
                @endif

                <div class="p-6 flex flex-col flex-1 justify-between space-y-4">
                    <div>
                        <h3 class="text-lg font-bold">{{ $event->event_name }}</h3>
                        <p class="text-sm text-gray-300">{{ Str::limit($event->description, 100) }}</p>
                    </div>

                    <div class="text-sm text-gray-400">
                        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</p>
                        <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</p>
                        <p><strong>Location:</strong> {{ $event->location }}</p>
                    </div>

                    <div>
                        <span
                            class="inline-block bg-black border border-purple-500 text-purple-500 px-4 py-2 rounded-lg text-sm hover:bg-purple-500 hover:text-black transition">
                            Details
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
