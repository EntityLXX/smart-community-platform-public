<x-app-layout>
    <x-slot name="header">
        <div class="relative flex items-center gap-4">
            <!-- Icon Circle with subtle outlined background -->
            <div class="relative z-10">
                <!-- Outer outline ring -->
                <div class="absolute inset-0 scale-110 rounded-full ring-2 ring-green-600 dark:ring-green-500"></div>

                <!-- Main Icon Circle -->
                <div
                    class="w-14 h-14 bg-green-600 dark:bg-green-500 rounded-full flex items-center justify-center shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-7 h-7 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 
                          1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 
                          12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 
                          0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 
                          0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>

            <!-- Header Text -->
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Full Transaction History
            </h2>
        </div>
    </x-slot>

    <div class="py-6 px-6">
        <x-breadcrumbs :items="[
        ['label' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Finance', 'url' => route('admin.finance.index')],
        ['label' => 'Transaction History']
    ]" />

        <div class="max-w-7xl mx-auto space-y-6">

            <div class="flex mb-4">
                <a href="{{ route('admin.finance.index') }}"
                    class="inline-block px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                    ← Back to Summary
                </a>
            </div>


            {{-- Tabs & Filters --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex space-x-2">
                    <a href="{{ route('admin.finance.history') }}"
                        class="px-4 py-2 rounded {{ request('type') === null ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 dark:text-white' }}">
                        All
                    </a>
                    <a href="{{ route('admin.finance.history', ['type' => 'income']) }}"
                        class="px-4 py-2 rounded {{ request('type') === 'income' ? 'bg-green-600 text-white' : 'bg-gray-200 dark:bg-gray-700 dark:text-white' }}">
                        Income
                    </a>
                    <a href="{{ route('admin.finance.history', ['type' => 'expense']) }}"
                        class="px-4 py-2 rounded {{ request('type') === 'expense' ? 'bg-red-600 text-white' : 'bg-gray-200 dark:bg-gray-700 dark:text-white' }}">
                        Expense
                    </a>
                    <a href="{{ route('admin.finance.export') }}"
                        class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Download as Excel
                    </a>


                </div>

                <form method="GET" action="{{ route('admin.finance.history') }}"
                    class="flex flex-wrap gap-2 items-center">
                    <input type="text" name="search" placeholder="Search description..." value="{{ request('search') }}"
                        class="border-gray-300 dark:bg-gray-700 dark:text-white rounded-md shadow-sm text-sm px-3 py-1.5">

                    <select name="category"
                        class="border-gray-300 dark:bg-gray-700 dark:text-white text-sm rounded-md shadow-sm">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit"
                        class="bg-blue-600 text-white px-3 py-1.5 rounded hover:bg-blue-700 text-sm">Filter</button>
                </form>
            </div>

            {{-- Table --}}
            <div class="relative ring-2 ring-green-500 rounded-3xl">
                <div class="absolute inset-0 translate-x-2 translate-y-2 bg-green-500 rounded-3xl z-0"></div>
                <div
                    class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-4 overflow-x-auto text-gray-800 dark:text-white z-10">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left font-medium">Date</th>
                                <th class="px-4 py-2 text-left font-medium">Type</th>
                                <th class="px-4 py-2 text-left font-medium">Category</th>
                                <th class="px-4 py-2 text-left font-medium">Description</th>
                                <th class="px-4 py-2 text-left font-medium">Amount</th>
                                <th class="px-4 py-2 text-left font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody
                            class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($transactions as $tx)
                                <tr>
                                    <td class="px-4 py-2">{{ $tx->date->format('Y-m-d') }}</td>
                                    <td class="px-4 py-2">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full {{ $tx->type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($tx->type) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">{{ $tx->category }}</td>
                                    <td class="px-4 py-2">{{ $tx->description }}</td>
                                    <td class="px-4 py-2">RM {{ number_format($tx->amount, 2) }}</td>
                                    <td class="px-4 py-2 flex space-x-2">
                                        <a href="{{ route('admin.finance.edit', $tx->id) }}"
                                            class="text-yellow-500 hover:underline"><svg
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </a>
                                        <form id="deleteForm-{{ $tx->id }}" method="POST"
                                            action="{{ route('admin.finance.destroy', $tx->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="window.confirmModal.open(
                                                            'Delete Transaction',
                                                            'Are you sure you want to delete this transaction ({{ $tx->category }} - RM {{ number_format($tx->amount, 2) }})?',
                                                            () => document.getElementById('deleteForm-{{ $tx->id }}').submit(),
                                                            'danger'
                                                        )" class="text-red-600 hover:underline">
                                                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-2 text-gray-500 dark:text-gray-300 text-center">No
                                        transactions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</x-app-layout>