@props(['title', 'description', 'color', 'route', 'icon' => null])

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

    $ringColor = $ringMap[$color] ?? 'ring-blue-600';
@endphp

<div
    class="relative group cursor-pointer"
    onclick="window.location.href='{{ $route }}'"
    role="link"
    aria-label="Go to {{ $title }}"
>
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
    </div>
</div>
