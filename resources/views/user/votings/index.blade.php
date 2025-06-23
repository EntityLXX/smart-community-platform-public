<x-app-layout>
    <x-slot name="header">
        <div class="relative flex items-center gap-4">
            <!-- Icon Circle with subtle outlined background -->
            <div class="relative z-10">
                <!-- Outer outline ring -->
                <div class="absolute inset-0 scale-110 rounded-full ring-2 ring-blue-600 dark:ring-blue-500"></div>

                <!-- Main Icon Circle -->
                <div
                    class="w-14 h-14 bg-blue-600 dark:bg-blue-500 text-white rounded-full flex items-center justify-center shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="size-10">
                    <path d="m9 12 2 2 4-4" />
                    <path d="M5 7c0-1.1.9-2 2-2h10a2 2 0 0 1 2 2v12H5V7Z" />
                    <path d="M22 19H2" />
                    </svg>
                </div>
            </div>

            <!-- Header Text -->
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Community Votings
            </h2>
        </div>
    </x-slot>


    <div class="py-6 px-6">
        <x-breadcrumbs :items="[
        ['label' => auth()->user()->role === 'admin' ? 'Admin Dashboard' : 'User Dashboard', 'url' => auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard')],
        ['label' => 'Voting']
    ]" />

        <div class="max-w-4xl mx-auto space-y-6">
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Voting List --}}
            @forelse ($votings as $voting)
                <div class="relative ring-2 ring-blue-500 rounded-3xl">
                    <!-- Offset Background -->
                    <div class="absolute inset-0 translate-x-2 translate-y-2 bg-blue-500 rounded-3xl z-0"></div>

                    <!-- Foreground Voting Card -->
                    <div class="relative bg-black text-white p-6 rounded-3xl z-10 shadow-lg space-y-4">
                        <div class="flex justify-between items-center">
                            <h2 class="text-lg font-semibold">{{ $voting->title }}</h2>
                            
                            <!-- Status Badge -->
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $voting->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($voting->status) }}
                            </span>
                        </div>


                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            <strong>From:</strong>
                            {{ \Carbon\Carbon::parse($voting->start_date)->format('d M Y') }}
                            {{ $voting->start_time ? 'at ' . \Carbon\Carbon::parse($voting->start_time)->format('h:i A') : '' }}
                            <br>
                            <strong>To:</strong>
                            {{ \Carbon\Carbon::parse($voting->end_date)->format('d M Y') }}
                            {{ $voting->end_time ? 'at ' . \Carbon\Carbon::parse($voting->end_time)->format('h:i A') : '' }}
                        </p>

                        <p class="text-gray-700 dark:text-gray-400">
                            {{ Str::limit($voting->description, 150) }}
                        </p>

                        <div class="mt-4 flex justify-between items-center">
                            @if ($voting->hasVoted)
                                <div class="w-full">
                                    <p class="flex items-center gap-1 text-sm text-green-600 mb-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
                                        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                        <path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                                    </svg>
                                    You have voted</p>

                                    {{-- Show Results --}}
                                    <div class="w-full">
                                        <h4 class="flex items-center gap-1 font-bold text-sm text-gray-800 dark:text-white mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart-steps" viewBox="0 0 16 16">
                                            <path d="M.5 0a.5.5 0 0 1 .5.5v15a.5.5 0 0 1-1 0V.5A.5.5 0 0 1 .5 0M2 1.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-4a.5.5 0 0 1-.5-.5zm2 4a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5zm2 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-6a.5.5 0 0 1-.5-.5zm2 4a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5z"/>
                                            </svg> Voting Results</h4>
                                        @forelse ($voting->results as $result)
                                            <div class="mb-3">
                                                <div class="flex justify-between text-xs text-gray-600 dark:text-gray-300">
                                                    <span>{{ $result['name'] }}</span>
                                                    <span>{{ $result['votes'] }} votes ({{ $result['percentage'] }}%)</span>
                                                </div>
                                                <div class="w-full bg-gray-200 rounded h-2 mt-1">
                                                    <div class="bg-green-500 h-2 rounded"
                                                        style="width: {{ $result['percentage'] }}%;"></div>
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-xs text-gray-500 dark:text-gray-300">No votes yet.</p>
                                        @endforelse
                                    </div>
                                    <a href="{{ route('user.votings.show', $voting) }}"
                                    class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                        Modify Vote
                                    </a>
                                </div>
                            @elseif ($voting->isAvailable)
                                <a href="{{ route('user.votings.show', $voting) }}"
                                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                                    Vote Now
                                </a>
                            @else
                                <span class="flex items-center text-sm text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
                                    <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
                                    </svg> 
                                    Voting not active
                                </span>
                            @endif
                        </div>
                    </div>
                </div>


            @empty
                <p class="text-center px-4 py-4 text-gray-500 dark:text-gray-300">No votings are available at this time.</p>
            @endforelse

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $votings->links() }}
            </div>

        </div>
    </div>
</x-app-layout>