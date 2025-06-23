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
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Thread: {{ $thread->title }}
            </h2>
        </div>
    </x-slot>


    <div class="py-6 px-6">
        <x-breadcrumbs :items="[
        ['label' => auth()->user()->role === 'admin' ? 'Admin Dashboard' : 'User Dashboard', 'url' => auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard')],
        ['label' => 'Communication Hub', 'url' => route('threads.index')],
        ['label' => 'Thread Details']
    ]" />

        <div class="max-w-3xl mx-auto space-y-10">

            {{-- Wrapping container with ONE Alpine scope --}}
            <div x-data="{ moderateThread: false }" class="mb-6">

                {{-- Button Row --}}
                <div class="flex justify-between items-center">
                    {{-- Back Button --}}
                    <div>
                        <a href="{{ route('threads.index') }}"
                            class="inline-block px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                            &larr; Back to Threads
                        </a>
                    </div>

                    {{-- Thread Controls --}}
                    <div class="flex text-center gap-1">
                        @if (auth()->id() === $thread->user_id)
                            <a href="{{ route('threads.edit', $thread) }}"
                                class="flex text-center gap-1 text-yellow-500 hover:underline text-sm mr-4"><svg
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg> Edit Thread</a>

                            <form id="deleteThreadForm" action="{{ route('threads.destroy', $thread) }}" method="POST"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="window.confirmModal.open(
                                                                                                            'Delete Thread',
                                                                                                            'Are you sure you want to delete this thread?',
                                                                                                            () => document.getElementById('deleteThreadForm').submit(),
                                                                                                            'danger'
                                                                                                        )"
                                    class="flex text-center gap-1 text-red-600 hover:underline text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg> Delete Thread
                                </button>
                            </form>
                        @elseif(auth()->user()?->role === 'admin')
                            <button @click="moderateThread = true"
                                class="flex items-center gap-1 text-red-600 hover:underline text-sm"> <svg
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-exclamation-octagon" viewBox="0 0 16 16">
                                    <path
                                        d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1z" />
                                    <path
                                        d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
                                </svg> Moderate
                                Thread</button>
                        @endif
                    </div>
                </div>

                {{-- Moderation Form (Below Buttons) --}}
                @if(auth()->user()?->role === 'admin')
                    <div x-show="moderateThread" x-cloak class="mt-4">
                        <form action="{{ route('threads.destroyWithReason', $thread) }}" method="POST"
                            class="space-y-2 bg-white dark:bg-gray-800 p-4 rounded shadow">
                            @csrf
                            @method('DELETE')
                            <label class="block text-sm text-gray-700 dark:text-gray-300">Reason for deletion:</label>
                            <input type="text" name="reason" required
                                class="w-full border rounded p-2 dark:bg-gray-700 dark:text-white"
                                placeholder="Enter reason...">
                            <div class="flex justify-end space-x-2">
                                <button type="button" @click="moderateThread = false"
                                    class="bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white px-3 py-1 rounded hover:bg-gray-400 text-sm">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
                                    Delete
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

            </div>

            @php
                $totalViews = $thread->views_count; // Comes from loadCount('views')
                $totalComments = $comments->count() + $comments->sum(fn($c) => $c->replies->count());
            @endphp

            <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 gap-4">

                <!-- Thread Views Card -->
                <div class="bg-indigo-100 dark:bg-indigo-800 p-4 rounded shadow text-center">
                    <h4 class="text-lg font-semibold text-indigo-800 dark:text-white flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        Thread Views
                    </h4>
                    <p class="text-2xl font-bold text-indigo-900 dark:text-white">{{ $totalViews }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Users Have Viewed</p>
                </div>

                <!-- Comments Card -->
                <div class="bg-pink-100 dark:bg-pink-800 p-4 rounded shadow text-center">
                    <h4 class="text-lg font-semibold text-pink-800 dark:text-white flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                        </svg>
                        Comments
                    </h4>
                    <p class="text-2xl font-bold text-pink-900 dark:text-white">{{ $totalComments }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Including Replies</p>
                </div>
            </div>

            {{-- Thread Content --}}
            <div class="relative ring-2 ring-yellow-500 rounded-3xl">
                <div class="absolute inset-0 translate-x-2 translate-y-2 bg-yellow-500 rounded-3xl z-0"></div>
                <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 space-y-4 z-10">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $thread->title }}</h1>
                    @if ($thread->description)
                        <p class="text-sm text-gray-500 dark:text-gray-400 italic">{{ $thread->description }}</p>
                    @endif
                    <div class="text-gray-700 dark:text-gray-300 whitespace-pre-line">
                        {!! nl2br(e($thread->content)) !!}
                    </div>
                    <div class="flex items-center gap-3 text-xs text-gray-400 dark:text-gray-500 mt-4">
                        <img src="{{ $thread->user->profile_photo_url }}" alt="Author" class="w-8 h-8 rounded-full">
                        <span>
                            Posted by <span
                                class="font-medium text-gray-600 dark:text-gray-300">{{ $thread->user->name }}</span>
                            • {{ $thread->created_at->diffForHumans() }}
                        </span>
                    </div>

                </div>
            </div>

            {{-- Comments --}}
            <div class="relative ring-2 ring-yellow-500 rounded-3xl">
                <div class="absolute inset-0 translate-x-2 translate-y-2 bg-yellow-500 rounded-3xl z-0"></div>
                <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 space-y-4 z-10">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Comments</h2>

                    @forelse ($comments as $comment)
                        <div x-data="{ editing: false, moderate: false, content: @js($comment->content) }"
                            class="border-b border-gray-200 dark:border-gray-700 pb-3 mb-3">

                            <div class="flex items-center gap-3 mb-1">
                                <img src="{{ $comment->user->profile_photo_url }}" alt="Profile"
                                    class="w-8 h-8 rounded-full shadow-sm border border-gray-300 dark:border-gray-600">
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>{{ $comment->user->name }}</strong>
                                    <span class="text-xs text-gray-500">({{ $comment->created_at->diffForHumans() }})</span>
                                </div>
                            </div>



                            <div x-show="!editing" class="text-gray-700 dark:text-gray-300">
                                <div x-data="{ expanded: false }">
                                    <div
                                        class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-xl p-3 break-words max-w-full">
                                        <template x-if="content.length <= 300 || expanded">
                                            <span>
                                                <span x-text="content"></span>
                                                <template x-if="content.length > 300">
                                                    <button @click="expanded = false"
                                                        class="text-blue-500 text-xs ml-2 hover:underline">Show
                                                        less</button>
                                                </template>
                                            </span>
                                        </template>

                                        <template x-if="!expanded && content.length > 300">
                                            <span>
                                                <span x-text="content.slice(0, 300) + '...'"></span>
                                                <button @click="expanded = true"
                                                    class="text-blue-500 text-xs ml-1 hover:underline">Show more</button>
                                            </span>
                                        </template>
                                    </div>
                                </div>


                                @php
                                    $isOwner = auth()->id() === $comment->user_id;
                                    $isAdmin = auth()->user()?->role === 'admin';
                                @endphp

                                @if ($isOwner || $isAdmin)
                                    <div class="text-xs mt-2 flex justify-end gap-1">
                                        <button @click="editing = true"
                                            class="flex items-center text-yellow-500 hover:underline"><svg
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg> Edit</button>

                                        @if ($isAdmin && !$isOwner)
                                            {{-- Admin moderating others --}}
                                            <button @click="moderate = true"
                                                class="flex items-center gap-1 text-red-500 hover:underline ml-2"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                    class="bi bi-exclamation-octagon" viewBox="0 0 16 16">
                                                    <path
                                                        d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1z" />
                                                    <path
                                                        d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
                                                </svg>
                                                Moderate</button>

                                            <div x-show="moderate" x-cloak class="mt-2 w-full">
                                                <form action="{{ route('comments.destroyWithReason', $comment) }}" method="POST"
                                                    class="space-y-2 w-full">
                                                    @csrf
                                                    @method('DELETE')
                                                    <label class="block text-sm text-gray-700 dark:text-gray-300">Reason:</label>
                                                    <input type="text" name="reason" required
                                                        class="w-full border rounded p-2 dark:bg-gray-700 dark:text-white"
                                                        placeholder="Enter reason..." />
                                                    <div class="flex justify-end space-x-2">
                                                        <button type="button" @click="moderate = false"
                                                            class="bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white px-3 py-1 rounded hover:bg-gray-400 text-sm">Cancel</button>
                                                        <button type="submit"
                                                            class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @else
                                            {{-- Regular delete (admin or user deleting own comment) --}}
                                            <form id="deleteCommentForm-{{ $comment->id }}"
                                                action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    onclick="window.confirmModal.open(
                                                                                                                                                                                                                                                                    'Delete Comment',
                                                                                                                                                                                                                                                                    'Are you sure you want to delete this comment?',
                                                                                                                                                                                                                                                                    () => document.getElementById('deleteCommentForm-{{ $comment->id }}').submit(),
                                                                                                                                                                                                                                                                    'danger'
                                                                                                                                                                                                                                                                )"
                                                    class="flex items-center text-red-500 hover:underline ml-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg> Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            {{-- Edit mode --}}
                            <div x-show="editing" x-cloak>
                                <form action="{{ route('comments.update', $comment) }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('PUT')
                                    <textarea name="content" x-model="content" rows="3"
                                        class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white"></textarea>
                                    <div class="mt-2 flex justify-end space-x-2">
                                        <button type="submit"
                                            class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm">Save</button>
                                        <button type="button" @click="editing = false"
                                            class="bg-gray-300 text-gray-700 px-3 py-1 rounded hover:bg-gray-400 text-sm dark:bg-gray-600 dark:text-white">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                            {{-- Reply toggle & form --}}
                            <div x-data="{ showReply: false }" class="mt-2 ml-6">
                                <button @click="showReply = !showReply"
                                    class="flex items-center gap-1 text-xs text-blue-500 hover:underline"><svg
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m15 15-6 6m0 0-6-6m6 6V9a6 6 0 0 1 12 0v3" />
                                    </svg>

                                    Reply</button>

                                <div x-show="showReply" x-cloak class="mt-2">
                                    <form action="{{ route('comments.store', $thread) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                        <textarea name="content" rows="2"
                                            class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white"
                                            placeholder="Write your reply..." required></textarea>
                                        <div class="mt-1 flex justify-end">
                                            <button type="submit"
                                                class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">Reply</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- Nested Replies --}}
                            @if ($comment->replies->isNotEmpty())
                                <div class="mt-4 ml-6 border-l-2 border-yellow-300 dark:border-yellow-600 pl-4 space-y-3">
                                    @foreach ($comment->replies as $reply)
                                        <div x-data="{ editing: false, moderate: false, content: @js($reply->content) }"
                                            class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded-xl p-3 text-sm">

                                            <div class="flex items-center gap-2 mb-1">
                                                <img src="{{ $reply->user->profile_photo_url }}" class="w-6 h-6 rounded-full">
                                                <div>
                                                    <strong>{{ $reply->user->name }}</strong>
                                                    <span class="text-xs text-gray-500">•
                                                        {{ $reply->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>

                                            {{-- Show content or edit box --}}
                                            <div x-show="!editing">
                                                <p class="ml-8 text-sm break-words" x-text="content"></p>
                                            </div>

                                            {{-- Edit form --}}
                                            <div x-show="editing" x-cloak class="ml-8 mt-2">
                                                <form action="{{ route('comments.update', $reply) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <textarea name="content" x-model="content" rows="3"
                                                        class="w-full p-2 border rounded dark:bg-gray-800 dark:text-white"></textarea>
                                                    <div class="mt-2 flex justify-end space-x-2">
                                                        <button type="submit"
                                                            class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm">Save</button>
                                                        <button type="button" @click="editing = false"
                                                            class="bg-gray-300 text-gray-700 px-3 py-1 rounded hover:bg-gray-400 text-sm dark:bg-gray-600 dark:text-white">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>

                                            {{-- Edit/Delete buttons --}}
                                            @php
                                                $isOwner = auth()->id() === $reply->user_id;
                                                $isAdmin = auth()->user()?->role === 'admin';
                                            @endphp
                                            @if ($isOwner || $isAdmin)
                                                <div class="text-xs mt-2 flex justify-end gap-3">
                                                    <button @click="editing = true"
                                                        class="flex items-center text-yellow-500 hover:underline gap-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                                                        </svg>
                                                        Edit
                                                    </button>

                                                    @if ($isAdmin && !$isOwner)
                                                        <!-- Admin moderation form toggle -->
                                                        <button @click="moderate = true"
                                                            class="flex items-center text-red-500 hover:underline gap-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                fill="currentColor" class="bi bi-exclamation-octagon" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1z" />
                                                                <path
                                                                    d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
                                                            </svg> Moderate
                                                        </button>

                                                        <!-- Moderation form -->
                                                        <div x-show="moderate" x-cloak class="mt-2 w-full">
                                                            <form action="{{ route('comments.destroyWithReason', $reply) }}" method="POST"
                                                                class="space-y-2 w-full">
                                                                @csrf
                                                                @method('DELETE')
                                                                <label
                                                                    class="block text-sm text-gray-700 dark:text-gray-300">Reason:</label>
                                                                <input type="text" name="reason" required
                                                                    class="w-full border rounded p-2 dark:bg-gray-800 dark:text-white"
                                                                    placeholder="Enter reason..." />
                                                                <div class="flex justify-end space-x-2">
                                                                    <button type="button" @click="moderate = false"
                                                                        class="bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white px-3 py-1 rounded hover:bg-gray-400 text-sm">
                                                                        Cancel
                                                                    </button>
                                                                    <button type="submit"
                                                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
                                                                        Delete
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    @else
                                                        <!-- Normal delete for owner or admin -->
                                                        <form id="deleteReplyForm-{{ $reply->id }}"
                                                            action="{{ route('comments.destroy', $reply) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                onclick="window.confirmModal.open('Delete Reply', 'Are you sure?', () => document.getElementById('deleteReplyForm-{{ $reply->id }}').submit(), 'danger')"
                                                                class="flex items-center text-red-500 hover:underline gap-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                                </svg>
                                                                Delete
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            @endif

                                        </div>

                                    @endforeach
                                </div>
                            @endif

                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400">No comments yet.</p>
                    @endforelse

                </div>
            </div>

            {{-- Add Comment --}}
            <div class="relative max-w-4xl mx-auto ring-2 ring-yellow-500 rounded-3xl">
                <div class="absolute inset-0 translate-x-2 translate-y-2 bg-yellow-500 rounded-3xl z-0"></div>
                <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 space-y-6 z-10">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Leave a Comment</h2>

                    <form action="{{ route('comments.store', $thread) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <textarea name="content" rows="4"
                                class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm"
                                placeholder="Write your comment here..." required>{{ old('content') }}</textarea>
                            @error('content')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                Post Comment
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>