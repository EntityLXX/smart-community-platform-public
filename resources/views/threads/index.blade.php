<x-app-layout>
    <x-slot name="header">
        <div class="relative flex items-center gap-4">
            <!-- Icon Circle with subtle outlined background -->
            <div class="relative z-10">
                <!-- Outer outline ring -->
                <div class="absolute inset-0 scale-110 rounded-full ring-2 ring-yellow-600 dark:ring-yellow-500"></div>

                <!-- Main Icon Circle -->
                <div
                    class="w-14 h-14 bg-yellow-600 dark:bg-yellow-500 rounded-full flex items-center justify-center shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-7 h-7 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 12a9.75 9.75 0 1 1 18.356 5.112c-.203.35-.313.75-.313 1.163V21l-4.226-2.111a9.749 9.749 0 0 1-13.817-6.889z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 11.25h.008v.008H8v-.008zm4 0h.008v.008H12v-.008zm4 0h.008v.008H16v-.008z" />
                    </svg>
                </div>
            </div>

            <!-- Header Text -->
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
                Communication Hub
            </h2>
        </div>
    </x-slot>


    <div class="py-6 px-6">
        <x-breadcrumbs :items="[
        ['label' => auth()->user()->role === 'admin' ? 'Admin Dashboard' : 'User Dashboard', 'url' => auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard')],
        ['label' => 'Communication Hub']
    ]" />


        <div class="max-w-7xl mx-auto space-y-6">
            <div class="flex justify-end items-center">
                <a href="{{ route('threads.create') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">+
                    Post Thread</a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Announcements --}}
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col lg:flex-row gap-6">
                    <div class="w-full lg:w-1/2 space-y-4">
                        <div
                            class="px-3 py-2 bg-yellow-100 dark:bg-yellow-700 rounded-lg inline-flex items-center gap-2">

                            <h4 class="flex items-center gap-2 font-semibold text-gray-700 dark:text-gray-300"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-megaphone" viewBox="0 0 16 16">
                                    <path
                                        d="M13 2.5a1.5 1.5 0 0 1 3 0v11a1.5 1.5 0 0 1-3 0v-.214c-2.162-1.241-4.49-1.843-6.912-2.083l.405 2.712A1 1 0 0 1 5.51 15.1h-.548a1 1 0 0 1-.916-.599l-1.85-3.49-.202-.003A2.014 2.014 0 0 1 0 9V7a2.02 2.02 0 0 1 1.992-2.013 75 75 0 0 0 2.483-.075c3.043-.154 6.148-.849 8.525-2.199zm1 0v11a.5.5 0 0 0 1 0v-11a.5.5 0 0 0-1 0m-1 1.35c-2.344 1.205-5.209 1.842-8 2.033v4.233q.27.015.537.036c2.568.189 5.093.744 7.463 1.993zm-9 6.215v-4.13a95 95 0 0 1-1.992.052A1.02 1.02 0 0 0 1 7v2c0 .55.448 1.002 1.006 1.009A61 61 0 0 1 4 10.065m-.657.975 1.609 3.037.01.024h.548l-.002-.014-.443-2.966a68 68 0 0 0-1.722-.082z" />
                                </svg> Announcements
                            </h4>
                        </div>
                        @forelse ($announcements as $thread)
                            <div class="relative group">
                                <!-- Offset Background Layer (color shadow) -->
                                <div
                                    class="absolute inset-0 translate-x-2 translate-y-2 bg-yellow-500 rounded-3xl z-0 transition duration-300 group-hover:translate-x-3 group-hover:translate-y-3">
                                </div>

                                <!-- Main Card (moves with hover) -->
                                <a href="{{ route('threads.show', $thread) }}"
                                    class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-lg z-10 block p-6
                                                                        ring-2 ring-yellow-500 ring-offset-2 ring-offset-white dark:ring-offset-gray-900
                                                                        transition duration-300 ease-in-out group-hover:scale-[1.02] group-hover:shadow-xl">

                                    @php
                                        $totalComments = $thread->comments_count + $thread->comments->sum(fn($c) => $c->replies->count());
                                    @endphp

                                    <div class="flex justify-between items-start gap-4 flex-wrap">
                                        <!-- Left Section -->
                                        <div class="space-y-1 max-w-[75%]">
                                            <h3 class="text-blue-600 font-bold hover:underline text-lg">
                                                {{ $thread->title }}
                                            </h3>
                                            <div class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                                                <img src="{{ $thread->user->profile_photo_url }}" alt="User Photo"
                                                    class="w-8 h-8 rounded-full object-cover">
                                                <span>
                                                    Posted by {{ $thread->user->name }} on
                                                    {{ $thread->created_at->format('d M Y, h:i A') }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Right Side Stats -->
                                        <div class="text-right text-sm text-gray-600 dark:text-gray-300 whitespace-nowrap">
                                            <div class="flex items-center justify-end gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                                <span
                                                    class="text-gray-600 dark:text-gray-400">{{ number_format($thread->views_count) }}
                                                </span>
                                            </div>
                                            <div class="flex items-center justify-end gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                                                </svg>

                                                <span
                                                    class="text-gray-600 dark:text-gray-400">{{ number_format($totalComments) }}
                                                </span>
                                            </div>

                                        </div>
                                    </div>

                                </a>
                            </div>
                        @empty
                            <p class="text-center text-sm text-gray-500">No announcements yet.</p>
                        @endforelse
                        <div class="mt-4">
                            {{ $announcements->appends(['threads' => $threads->currentPage()])->links() }}
                        </div>

                    </div>

                    {{-- Regular Threads --}}
                    <div class="w-full lg:w-1/2 space-y-4">
                        <div
                            class="px-3 py-2 bg-yellow-100 dark:bg-yellow-700 rounded-lg inline-flex items-center gap-2">

                            <h4 class="flex items-center gap-2 ont-semibold text-gray-700 dark:text-gray-300"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-chat-text" viewBox="0 0 16 16">
                                    <path
                                        d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105" />
                                    <path
                                        d="M4 5.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8m0 2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5" />
                                </svg> Threads</h4>
                        </div>
                        @forelse ($threads as $thread)
                            <div class="relative group">
                                <!-- Offset Background Layer (color shadow) -->
                                <div
                                    class="absolute inset-0 translate-x-2 translate-y-2 bg-yellow-500 rounded-3xl z-0 transition duration-300 group-hover:translate-x-3 group-hover:translate-y-3">
                                </div>

                                <!-- Main Card (moves with hover) -->

                                <a href="{{ route('threads.show', $thread) }}"
                                    class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-lg z-10 block p-6
                                            ring-2 ring-yellow-500 ring-offset-2 ring-offset-white dark:ring-offset-gray-900
                                            transition duration-300 ease-in-out group-hover:scale-[1.02] group-hover:shadow-xl">

                                    @php
                                        $totalComments = $thread->comments_count + $thread->comments->sum(fn($c) => $c->replies->count());
                                    @endphp

                                    <div class="flex justify-between items-start gap-4 flex-wrap">
                                        <!-- Left: Title & Poster Info -->
                                        <div class="space-y-1 max-w-[75%]">
                                            <h3 class="text-blue-600 font-bold hover:underline text-lg">{{ $thread->title }}
                                            </h3>
                                            <div class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                                                <img src="{{ $thread->user->profile_photo_url }}" alt="User Photo"
                                                    class="w-8 h-8 rounded-full object-cover">
                                                <span>
                                                    Posted by {{ $thread->user->name }} on
                                                    {{ $thread->created_at->format('d M Y, h:i A') }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Right: View & Comment Stats -->
                                        <div class="text-right text-sm text-gray-600 dark:text-gray-300 whitespace-nowrap">
                                            <div class="flex items-center justify-end gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                                <span
                                                    class="text-gray-600 dark:text-gray-400">{{ number_format($thread->views_count) }}</span>
                                            </div>
                                            <div class="flex items-center justify-end gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                                                </svg>
                                                <span
                                                    class="text-gray-600 dark:text-gray-400">{{ number_format($totalComments) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <p class="text-center text-sm text-gray-500">No threads posted yet.</p>
                        @endforelse
                        <div class="mt-4">
                            {{ $threads->appends(['announcements' => $announcements->currentPage()])->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
</x-app-layout>