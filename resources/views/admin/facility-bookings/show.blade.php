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
                Booking Request Details
            </h2>
        </div>
    </x-slot>

    <div class="py-12 px-6">
        <x-breadcrumbs :items="[
        ['label' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Facility Bookings', 'url' => route('admin.facility-bookings.index')],
        ['label' => 'Booking Details']
    ]" />
        <div class="relative max-w-3xl mx-auto ring-2 ring-teal-500 rounded-3xl">
            <div class="absolute inset-0 translate-x-2 translate-y-2 bg-teal-500 rounded-3xl z-0"></div>
            <div
                class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 text-gray-800 dark:text-white z-10">
                {{-- Back Button --}}
                <div class="mb-6">
                    <a href="{{ route('admin.facility-bookings.index') }}"
                        class="inline-block px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                        &larr; Back to List
                    </a>
                </div>

                <dl class="space-y-4">
                    <div>
                        <dt class="font-bold">User:</dt>
                        <dd>{{ $booking->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold">Facility:</dt>
                        <dd>{{ $booking->facility }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold">Purpose:</dt>
                        <dd>{{ $booking->purpose }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold">Date:</dt>
                        <dd>{{ $booking->date }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold">Start Time:</dt>
                        <dd>{{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold">End time:</dt>
                        <dd>{{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold">Status:</dt>
                        <dd>{{ ucfirst($booking->status) }}</dd>
                    </div>
                    @if($booking->admin_notes)
                        <div>
                            <dt class="font-bold">Admin Notes:</dt>
                            <dd>{{ $booking->admin_notes }}</dd>
                        </div>
                    @endif
                </dl>

                @if ($booking->status === 'pending')
                    <div x-data="{ modalAction: null }" class="mt-6 flex flex-col justify-end sm:flex-row gap-4">
                        <!-- Reject Button (triggers modal) -->
                        <button @click="modalAction = 'reject'"
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 w-full sm:w-auto">
                            Reject
                        </button>
                    
                        <!-- Approve Button (triggers modal) -->
                        <button @click="modalAction = 'approve'"
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 w-full sm:w-auto">
                            Approve
                        </button>



                        <!-- Modal -->
                        <div x-show="modalAction" x-cloak x-transition
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70 px-4">
                            <div class="relative max-w-xl w-full ring-2 ring-teal-500 rounded-3xl">
                                <div class="absolute inset-0 translate-x-2 translate-y-2 bg-teal-500 rounded-3xl z-0">
                                </div>
                                <div
                                    class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 max-h-[90vh] overflow-auto text-gray-800 dark:text-white z-10">
                                    <!-- Close Button -->
                                    <button @click="modalAction = null"
                                        class="absolute top-4 right-4 text-black text-3xl font-bold rounded hover:text-red-600 focus:outline-none z-10">
                                        ✕
                                    </button>

                                    <!-- Conditional Heading -->
                                    <h2 class="text-xl font-semibold text-gray-800 mb-4"
                                        x-text="modalAction === 'approve' ? 'Approval Notes' : 'Rejection Notes'"></h2>

                                    <!-- Form for Approve -->
                                    <form x-show="modalAction === 'approve'"
                                        action="{{ route('admin.facility-bookings.approve', $booking->id) }}" method="POST"
                                        class="space-y-4">
                                        @csrf
                                        @method('PATCH')

                                        <label for="approve_notes" class="block font-semibold text-sm text-gray-700 dark:text-white">
                                            Notes for Approval (optional):
                                        </label>
                                        <textarea name="admin_notes" id="approve_notes" rows="3"
                                            class="w-full rounded border-gray-300 focus:ring-green-500 focus:border-green-500 dark:text-black"></textarea>

                                        <div class="flex justify-end gap-4 pt-2">
                                            <button @click.prevent="modalAction = null"
                                                class="inline-block px-4 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-500">
                                                Cancel
                                            </button>
                                            <button type="submit"
                                                class="px-6 py-2 bg-green-700 text-white rounded hover:bg-green-800">
                                                Confirm Approval
                                            </button>
                                        </div>
                                    </form>

                                    <!-- Form for Reject -->
                                    <form x-show="modalAction === 'reject'"
                                        action="{{ route('admin.facility-bookings.reject', $booking->id) }}" method="POST"
                                        class="space-y-4">
                                        @csrf
                                        @method('PATCH')

                                        <label for="reject_notes" class="block font-semibold text-sm text-gray-700 dark:text-white">
                                            Notes for Rejection (optional):
                                        </label>
                                        <textarea name="admin_notes" id="reject_notes" rows="3"
                                            class="w-full rounded border-gray-300 focus:ring-red-500 focus:border-red-500 dark:text-black"></textarea>

                                        <div class="flex justify-end gap-4 pt-2">
                                            <button @click.prevent="modalAction = null"
                                                class="inline-block px-4 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-500">
                                                Cancel
                                            </button>
                                            <button type="submit"
                                                class="px-6 py-2 bg-red-700 text-white rounded hover:bg-red-800">
                                                Confirm Rejection
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="mt-6 p-4 bg-gray-100 dark:bg-gray-700 rounded text-gray-700 dark:text-gray-300">
                        This booking has already been <strong>{{ ucfirst($booking->status) }}</strong>.
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>
</x-app-layout>