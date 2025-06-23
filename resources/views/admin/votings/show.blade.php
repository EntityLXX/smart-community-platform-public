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
                Voting Details
            </h2>
        </div>
    </x-slot>

    <div class="py-12 px-6">
        <x-breadcrumbs :items="[
        ['label' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Voting', 'url' => route('admin.votings.index')],
        ['label' => 'Show Voting']
    ]" />

        <div class="max-w-4xl mx-auto space-y-8">

            {{-- Back Button --}}
            <div>
                <a href="{{ route('admin.votings.index') }}"
                    class="inline-block px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                    &larr; Back to Votings</a>
            </div>

            {{-- Voting Details --}}
            <div class="relative ring-2 ring-blue-500 rounded-3xl">
                <div class="absolute inset-0 translate-x-2 translate-y-2 bg-blue-500 rounded-3xl z-0"></div>
                <div
                    class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 space-y-4 text-gray-800 dark:text-white z-10">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $voting->title }}</h3>

                    <p class="text-gray-600 dark:text-gray-300">
                        <span class="font-semibold">Start Date:</span>
                        {{ \Carbon\Carbon::parse($voting->start_date)->format('d M Y') }}
                    </p>
                    <p class="text-gray-600 dark:text-gray-300">
                        <span class="font-semibold">End Date:</span>
                        {{ \Carbon\Carbon::parse($voting->end_date)->format('d M Y') }}
                    </p>

                    <div>
                        <span class="font-semibold text-gray-700 dark:text-gray-300">Status:</span>
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $voting->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($voting->status) }}
                        </span>
                        @if ($voting->status === 'active')
                            <form id="endVotingForm-{{ $voting->id }}" action="{{ route('admin.votings.end', $voting) }}"
                                method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="button" onclick="window.confirmModal.open(
                                                                'End Voting Session',
                                                                'Are you sure you want to end the voting session and notify all users?',
                                                                () => document.getElementById('endVotingForm-{{ $voting->id }}').submit(),
                                                                'danger'
                                                            )"
                                    class="mt-4 flex items-center gap-1 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 9.563C9 9.252 9.252 9 9.563 9h4.874c.311 0 .563.252.563.563v4.874c0 .311-.252.563-.563.563H9.564A.562.562 0 0 1 9 14.437V9.564Z" />
                                    </svg>
                                    End Voting & Notify Users
                                </button>
                            </form>
                        @else
                            <p class="mt-4 text-green-600 font-semibold">This voting session has ended.</p>
                        @endif

                    </div>

                    @if ($voting->description)
                        <div>
                            <h4 class="font-semibold text-gray-700 dark:text-gray-300 mt-4 mb-2">Description:</h4>
                            <p class="text-gray-600 dark:text-gray-400">{{ $voting->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Choices --}}
            <div class="relative ring-2 ring-blue-500 rounded-3xl">
                <div class="absolute inset-0 translate-x-2 translate-y-2 bg-blue-500 rounded-3xl z-0"></div>
                <div
                    class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 space-y-4 text-gray-800 dark:text-white z-10">

                    {{-- Header --}}
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Voting Choices</h3>

                        <a href="{{ route('admin.votings.choices.create', $voting) }}"
                            class="flex items-center gap-1 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
</svg>
Add Choice
                        </a>
                    </div>

                    {{-- Choices List --}}
                    @if($voting->choices->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($voting->choices as $choice)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded p-4 flex justify-between items-center">
                                    <div class="text-gray-800 dark:text-white">
                                        {{ $choice->name }}
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.votings.choices.edit', [$voting, $choice]) }}"
                                            class="text-yellow-500 hover:underline text-sm"><svg
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </a>
                                        <form id="deleteChoiceForm-{{ $choice->id }}"
                                            action="{{ route('admin.votings.choices.destroy', [$voting, $choice]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="window.confirmModal.open(
                                                    'Delete Choice',
                                                    'Are you sure you want to delete the choice: {{ addslashes($choice->name) }}?',
                                                    () => document.getElementById('deleteChoiceForm-{{ $choice->id }}').submit(),
                                                    'danger'
                                                )"
                                                class="text-red-500 hover:underline text-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>

                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-300">No choices added yet.</p>
                    @endif

                </div>
            </div>

            {{-- Voting Results --}}
            <div class="relative ring-2 ring-blue-500 rounded-3xl">
                <div class="absolute inset-0 translate-x-2 translate-y-2 bg-blue-500 rounded-3xl z-0"></div>
                <div
                    class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 space-y-4 text-gray-800 dark:text-white z-10">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">📊 Voting Results</h3>

                    @forelse ($results as $result)
                        <div class="mb-4">
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-300">
                                <span>{{ $result['name'] }}</span>
                                <span>{{ $result['votes'] }} votes ({{ $result['percentage'] }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded h-4 mt-1">
                                <div class="bg-green-500 h-4 rounded" style="width: {{ $result['percentage'] }}%;"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-300">No votes have been cast yet.</p>
                    @endforelse
                </div>
            </div>


        </div>
    </div>
</x-app-layout>