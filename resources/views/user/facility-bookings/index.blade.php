<x-app-layout>
    <x-slot name="header">
        <div class="relative flex items-center gap-4">
            <!-- Icon Circle with subtle outlined background -->
            <div class="relative z-10">
                <!-- Outer outline ring -->
                <div class="absolute inset-0 scale-110 rounded-full ring-2 ring-teal-600 dark:ring-teal-500"></div>

                <!-- Main Icon Circle -->
                <div
                    class="w-14 h-14 bg-teal-600 dark:bg-teal-500 rounded-full flex items-center justify-center shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-7 h-7 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                    </svg>
                </div>
            </div>

            <!-- Header Text -->
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                My Facility Booking Requests
            </h2>
        </div>
    </x-slot>

    <div class="py-6 px-6">
        <x-breadcrumbs :items="[
        ['label' => auth()->user()->role === 'admin' ? 'Admin Dashboard' : 'User Dashboard', 'url' => auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard')],
        ['label' => 'Facility Bookings']
    ]" />

        <div class="max-w-5xl mx-auto space-y-6">

            <div class="flex justify-end">
                <a href="{{ route('user.facility-bookings.create') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    + New Booking
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="relative ring-2 ring-teal-500 rounded-3xl">
                <div class="absolute inset-0 translate-x-2 translate-y-2 bg-teal-500 rounded-3xl z-0"></div>
                <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 overflow-x-auto z-10">
                    <!-- Keep the rest of the table code exactly the same -->
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-100">
                            <tr>

                                <th class="px-4 py-2 text-left font-medium">Facility</th>
                                <th class="px-4 py-2 text-left font-medium">Date</th>
                                <th class="px-4 py-2 text-left font-medium">Start Time</th>
                                <th class="px-4 py-2 text-left font-medium">End Time</th>
                                <th class="px-4 py-2 text-left font-medium">Status</th>
                                <th class="px-4 py-2 text-left font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody
                            class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($bookings as $booking)
                                <tr>

                                    <td class="px-4 py-2">{{ $booking->facility }}</td>
                                    <td class="px-4 py-2">{{ $booking->date }}</td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}
                                    </td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}
                                    </td>
                                    <td class="px-4 py-2"> @php
                                        $statusColor = match ($booking->status) {
                                            'approved' => 'bg-green-100 text-green-800 dark:bg-green-100',
                                            'rejected' => 'bg-red-100 text-red-800 dark:bg-red-100',
                                            default => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-100',
                                        };
                                    @endphp
                                        <span
                                            class="px-2 py-1 rounded-full text-xs bg-gray-200 dark:bg-gray-700 {{ $statusColor }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td class="flex text-center px-4 py-2 space-x-2">
                                        <a href="{{ route('user.facility-bookings.show', $booking->id) }}"
                                            class="flex items-center text-blue-500 hover:underline"><svg
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </a>

                                        @if($booking->status === 'pending')

                                            <form id="cancelBookingForm-{{ $booking->id }}"
                                                action="{{ route('user.facility-bookings.destroy', $booking->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="window.confirmModal.open(
                                                                                                'Cancel Booking',
                                                                                                'Are you sure you want to cancel this pending request?',
                                                                                                () => document.getElementById('cancelBookingForm-{{ $booking->id }}').submit(),
                                                                                                'danger'
                                                                                            )"
                                                    class="text-red-500 hover:underline">
                                                                                                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                                </button>
                                            </form>

                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center px-4 py-4 text-gray-500 dark:text-gray-300">
                                        You have not made any facility booking requests yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $bookings->links() }}</div>
                </div>

            </div>
        </div>

    </div>

    <div class="py-2 px-14">
        <h3 class="text-lg font-bold mb-4 mt-10 text-gray-800 dark:text-gray-200">Booking Calendar</h3>

        <div class="flex items-center space-x-4 mb-4">
            <div class="flex items-center space-x-2">
                <div class="w-4 h-4 bg-green-500 rounded-sm"></div>
                <span class="text-sm text-gray-700 dark:text-gray-200">Approved</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-4 h-4 bg-yellow-500 rounded-sm"></div>
                <span class="text-sm text-gray-700 dark:text-gray-200">Pending</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-4 h-4 bg-red-500 rounded-sm"></div>
                <span class="text-sm text-gray-700 dark:text-gray-200">Rejected</span>
            </div>
        </div>

        <div class="max-w-7xl mx-auto relative ring-2 ring-teal-500 rounded-3xl">
            <div class="absolute inset-0 translate-x-2 translate-y-2 bg-teal-500 rounded-3xl z-0"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-4 z-10">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    @vite(['resources/js/calendar.js'])
    @push('styles')
        <style>
            .dark .fc .fc-daygrid-day-number,
            .dark .fc .fc-daygrid-day,
            .dark .fc .fc-toolbar-title,
            .dark .fc .fc-col-header-cell-cushion {
                color: #f9fafb !important;
            }

            .dark .fc .fc-col-header-cell {
                background-color: #1f2937 !important;
            }

            .dark .fc .fc-event {
                color: #f9fafb !important;
            }
        </style>
    @endpush


    </div>
</x-app-layout>