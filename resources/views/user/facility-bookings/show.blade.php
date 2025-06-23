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
                My Booking Request Details
            </h2>
        </div>
    </x-slot>

    <div class="py-6 px-6">
        <x-breadcrumbs :items="[
        ['label' => auth()->user()->role === 'admin' ? 'Admin Dashboard' : 'User Dashboard', 'url' => auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard')],
        ['label' => 'Facility Bookings', 'url' => route('user.facility-bookings.index')],
        ['label' => 'Booking Details']
    ]" />

        <div class="relative max-w-3xl mx-auto">
            <!-- Teal-colored offset background -->
            <div class="absolute inset-0 translate-x-2 translate-y-2 bg-teal-500 rounded-3xl z-0"></div>

            <!-- Foreground card with teal ring -->
            <div
                class="relative bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-lg z-10 ring-2 ring-teal-600 ring-offset-2 ring-offset-white dark:ring-offset-gray-900">


                {{-- all form fields remain unchanged --}}

                <div class="mb-6">
                    <a href="{{ route('user.facility-bookings.index') }}"
                        class="inline-block px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                        &larr; Back to My Requests</a>
                </div>


                <dl class="space-y-4">
                    <div>
                        <dt class="font-bold text-gray-700 dark:text-gray-300">Facility:</dt>
                        <dd class="text-gray-900 dark:text-gray-100">{{ $booking->facility }}</dd>
                    </div>

                    <div>
                        <dt class="font-bold text-gray-700 dark:text-gray-300">Purpose:</dt>
                        <dd class="text-gray-900 dark:text-gray-100">{{ $booking->purpose }}</dd>
                    </div>

                    <div>
                        <dt class="font-bold text-gray-700 dark:text-gray-300">Date:</dt>
                        <dd class="text-gray-900 dark:text-gray-100">{{ $booking->date }}</dd>
                    </div>

                    <div>
                        <dt class="font-bold text-gray-700 dark:text-gray-300">Start Time:</dt>
                        <dd class="text-gray-900 dark:text-gray-100">
                            {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}</dd>
                    </div>

                    <div>
                        <dt class="font-bold text-gray-700 dark:text-gray-300">End Time:</dt>
                        <dd class="text-gray-900 dark:text-gray-100">
                            {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}</dd>
                    </div>


                    <div>
                        <dt class="font-bold text-gray-700 dark:text-gray-300">Status:</dt>
                        <dd class="capitalize text-gray-900 dark:text-gray-100">{{ $booking->status }}</dd>
                    </div>

                    @if($booking->admin_notes)
                        <div>
                            <dt class="font-bold text-gray-700 dark:text-gray-300">Admin Notes:</dt>
                            <dd class="text-gray-900 dark:text-gray-100">{{ $booking->admin_notes }}</dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>

    </div>
    </div>

</x-app-layout>