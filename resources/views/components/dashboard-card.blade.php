@props(['title', 'description', 'color', 'route' => null, 'icon' => null])

@php
    $ringMap = [
        'bg-purple-600' => 'ring-purple-600',
        'bg-green-600' => 'ring-green-600',
        'bg-teal-600' => 'ring-teal-600',
        'bg-blue-600' => 'ring-blue-600',
        'bg-yellow-600' => 'ring-yellow-600',
        'bg-red-600' => 'ring-red-600',
        'bg-pink-500' => 'ring-pink-500',
        'bg-emerald-600' => 'ring-emerald-600',
    ];

    $hoverMap = [
        'bg-purple-600' => 'hover:bg-purple-600',
        'bg-green-600' => 'hover:bg-green-600',
        'bg-teal-600' => 'hover:bg-teal-600',
        'bg-blue-600' => 'hover:bg-blue-600',
        'bg-yellow-600' => 'hover:bg-yellow-600',
        'bg-red-600' => 'hover:bg-red-600',
        'bg-pink-500' => 'hover:bg-pink-500',
        'bg-emerald-600' => 'hover:bg-emerald-600',
    ];

    $ringColor = $ringMap[$color] ?? 'ring-blue-600';
    $hoverClass = $hoverMap[$color] ?? 'hover:bg-blue-600';
@endphp

<div class="relative group">
    <!-- Offset Background Layer (colored shadow) -->
    <div class="absolute inset-0 translate-x-2 translate-y-2 {{ $color }} rounded-3xl z-0 transition duration-300 group-hover:translate-x-3 group-hover:translate-y-3"></div>

    <!-- Main Card -->
    <div class="relative bg-black text-white p-6 rounded-3xl shadow-lg z-10 block {{ $ringColor }} ring-2 ring-offset-2 ring-offset-black transition duration-300 ease-in-out group-hover:scale-[1.02] group-hover:shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold mb-2">{{ $title }}</h3>
                <p class="text-sm text-white/80">{{ $description }}</p>
            </div>
            <div class="opacity-40 flex-shrink-0 ml-6">
                {{ $slot }}
            </div>
        </div>

        @if (str_contains(Route::currentRouteName(), 'admin.dashboard'))
            <div class="mt-6 flex gap-2">
                @php
                    $userRoutes = [
                        'Event Management' => route('user.events.index'),
                        'Facility Booking' => route('user.facility-bookings.index'),
                        'Voting & Polls' => route('user.votings.index'),
                        'Communication Hub' => route('threads.index'),
                        'Notifications' => route('notifications.index'),
                    ];
                    $adminRoutes = [
                        'Event Management' => route('admin.events.index'),
                        'Financial Records' => route('admin.finance.index'),
                        'Facility Booking' => route('admin.facility-bookings.index'),
                        'Voting & Polls' => route('admin.votings.index'),
                        'User Management' => route('admin.users.index'),
                    ];
                @endphp

                @if (isset($userRoutes[$title]))
                    <a href="{{ $userRoutes[$title] }}"
                       class="bg-white text-black text-xs font-semibold px-3 py-1 rounded-full transition {{ $hoverClass }}">
                        {{ $title === 'Notifications' ? 'Personal Inbox' : 'Public View' }}
                    </a>
                @endif

                @if (isset($adminRoutes[$title]))
                    <a href="{{ $adminRoutes[$title] }}"
                       class="bg-white text-black text-xs font-semibold px-3 py-1 rounded-full transition {{ $hoverClass }}">
                        Admin Tools
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
