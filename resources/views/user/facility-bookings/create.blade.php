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
                Create Booking Request
            </h2>
        </div>
    </x-slot>

    <div class="py-6 px-6">
        <x-breadcrumbs :items="[
        ['label' => auth()->user()->role === 'admin' ? 'Admin Dashboard' : 'User Dashboard', 'url' => auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard')],
        ['label' => 'Facility Bookings', 'url' => route('user.facility-bookings.index')],
        ['label' => 'Create Booking Request']
    ]" />

        <div class="relative max-w-3xl mx-auto">
            <!-- Teal-colored offset background -->
            <div class="absolute inset-0 translate-x-2 translate-y-2 bg-teal-500 rounded-3xl z-0"></div>

            <!-- Foreground card with teal ring -->
            <div
                class="relative bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-lg z-10 ring-2 ring-teal-600 ring-offset-2 ring-offset-white dark:ring-offset-gray-900">


                {{-- all form fields remain unchanged --}}
                <form id="facilityBookingForm" action="{{ route('user.facility-bookings.store') }}" method="POST">
                    @csrf

                    {{-- Facility Name --}}
                    <div class="mb-4">
                        <label for="facility"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Facility</label>
                        <input type="text" name="facility" id="facility" value="{{ old('facility') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('facility') border-red-500 @enderror">
                        @error('facility')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Purpose --}}
                    <div class="mb-4">
                        <label for="purpose"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Purpose</label>
                        <textarea name="purpose" id="purpose" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('purpose') border-red-500 @enderror">{{ old('purpose') }}</textarea>
                        @error('purpose')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Date --}}
                    <div class="mb-4">
                        <label for="date"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                        <input type="date" name="date" id="date" value="{{ old('date') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('date') border-red-500 @enderror">
                        @error('date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Start Time --}}
                    <div class="mb-4">
                        <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start
                            Time</label>
                        <input type="time" name="start_time" id="start_time" value="{{ old('start_time') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('start_time') border-red-500 @enderror">
                        @error('start_time')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- End Time --}}
                    <div class="mb-4">
                        <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End
                            Time</label>
                        <input type="time" name="end_time" id="end_time" value="{{ old('end_time') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('end_time') border-red-500 @enderror">
                        @error('end_time')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- Buttons --}}
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('user.facility-bookings.index') }}"
                            class="inline-block px-4 py-2 bg-gray-300 text-black rounded hover:bg-gray-400">Cancel</a>
                        <button type="button" onclick="window.confirmModal.open(
                                'Submit Booking Request',
                                'Are you sure you want to submit this facility booking request?',
                                () => document.getElementById('facilityBookingForm').submit(),
                                'info'
                            )" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>