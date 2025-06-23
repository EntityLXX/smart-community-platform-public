@props(['role', 'name', 'color'])

<div class="relative group w-full">
    <!-- Offset Background -->
    <div class="absolute inset-0 translate-x-2 translate-y-2 {{ $color }} rounded-3xl z-0 transition duration-300 group-hover:translate-x-3 group-hover:translate-y-3"></div>

    <!-- Foreground Box -->
    <div class="relative bg-black text-white p-4 rounded-3xl shadow-lg z-10 block
                ring-2 ring-offset-2 ring-offset-black {{ $color }}
                transition duration-300 ease-in-out group-hover:scale-[1.02] group-hover:shadow-xl text-center space-y-1">
        <div class="text-lg font-bold">{{ $role }}</div>
        <div class="text-white/90 text-sm">{{ $name }}</div>
    </div>
</div>
