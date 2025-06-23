<x-app-layout>
<x-slot name="header">
    <div class="relative flex items-center gap-4">
        <!-- Icon Circle with subtle outlined background -->
        <div class="relative z-10">
            <!-- Outer outline ring -->
            <div class="absolute inset-0 scale-110 rounded-full ring-2 ring-pink-600 dark:ring-pink-500"></div>

            <!-- Main Icon Circle -->
            <div class="w-14 h-14 bg-pink-500 dark:bg-pink-500 rounded-full flex items-center justify-center shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6 6 0 1 0-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9" />
                </svg>
            </div>
        </div>

        <!-- Header Text -->
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Notifications
        </h2>
    </div>
</x-slot>


<div class="py-6 px-6">
    <x-breadcrumbs :items="[
        ['label' => auth()->user()->role === 'admin' ? 'Admin Dashboard' : 'User Dashboard', 'url' => auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard')],
        ['label' => 'Notifications']
    ]" />
</div>

<div class="py-1 px-6 max-w-4xl mx-auto">
    <!-- Filter Tabs -->
    <div class="flex justify-center mb-6 space-x-4">
        <a href="{{ route('notifications.index', ['filter' => 'all']) }}"
           class="px-4 py-2 rounded-full text-sm font-semibold transition focus:outline-none
           {{ request('filter') === 'unread' || request('filter') === 'read' ? 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' : 'bg-pink-600 text-white' }}">
            All
        </a>
        <a href="{{ route('notifications.index', ['filter' => 'unread']) }}"
           class="px-4 py-2 rounded-full text-sm font-semibold transition focus:outline-none
           {{ request('filter') === 'unread' ? 'bg-pink-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
            Unread
        </a>
        <a href="{{ route('notifications.index', ['filter' => 'read']) }}"
           class="px-4 py-2 rounded-full text-sm font-semibold transition focus:outline-none
           {{ request('filter') === 'read' ? 'bg-pink-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
            Read
        </a>
    </div>
</div>



    <div class="py-1 px-6 max-w-4xl mx-auto space-y-4">
        @if ($notifications->where('read', false)->count() > 0)
            <form action="{{ route('notifications.markAll') }}" method="POST" class="mb-4">
                @csrf
                @method('PATCH')
                <button class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">
                    Mark All as Read
                </button>
            </form>
        @endif

        @forelse ($notifications as $notification)
            <div class="p-4 rounded shadow {{ $notification->read ? 'bg-gray-100' : 'bg-blue-100 dark:bg-blue-100' }}">
                <h3 class="font-semibold text-gray-800 dark:text-black">{{ $notification->title }}</h3>
                <p class="text-gray-600 dark:text-gray-600 text-sm">{{ $notification->message }}</p>
                <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>

                @if (!$notification->read)
                    <form action="{{ route('notifications.read', $notification) }}" method="POST" class="mt-2">
                        @csrf
                        @method('PATCH')
                        <button class="text-sm text-blue-600 hover:underline">Mark as Read</button>
                    </form>
                @endif
            </div>
        @empty
            <p class="text-center text-gray-500 dark:text-gray-400">You have no notifications.</p>
        @endforelse
    </div>
    
</x-app-layout>
