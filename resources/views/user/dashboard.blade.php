<x-app-layout>
    <x-slot name="header">
        <div class="relative flex items-center gap-4">
            <!-- Icon Circle with subtle outlined background -->
            <div class="relative z-10">
                <!-- Outer outline ring -->
                <div class="absolute inset-0 scale-110 rounded-full ring-2 ring-rose-600 dark:ring-rose-600"></div>

                <!-- Main Icon Circle -->
                <div class="w-14 h-14 bg-rose-600 dark:bg-rose-600 rounded-full flex items-center justify-center shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                        fill="currentColor" class="w-7 h-7 text-white bi bi-laptop">
                        <path d="M13.5 3a.5.5 0 0 1 .5.5V11H2V3.5a.5.5 0 0 1 .5-.5zm-11-1A1.5 1.5 0 0 0 1 3.5V12h14V3.5A1.5 1.5 0 0 0 13.5 2zM0 12.5h16a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 12.5"/>
                    </svg>
                </div>
            </div>

            <!-- Header Text -->
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                User Dashboard
            </h2>
        </div>
    </x-slot>

    <div class="py-6 px-6">
        <x-breadcrumbs :items="[
            ['label' => 'User Dashboard']
            
        ]" />

        <div class="max-w-7xl mx-auto">
            <div class="mb-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Events -->
                <div class="bg-purple-100 dark:bg-purple-800 p-4 rounded shadow text-center">
                    <h4 class="text-lg font-semibold text-purple-800 dark:text-white flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 2.994v2.25m10.5-2.25v2.25m-14.252 13.5V7.491a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v11.251m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5m-6.75-6h2.25m-9 2.25h4.5m.002-2.25h.005v.006H12v-.006Zm-.001 4.5h.006v.006h-.006v-.005Zm-2.25.001h.005v.006H9.75v-.006Zm-2.25 0h.005v.005h-.006v-.005Zm6.75-2.247h.005v.005h-.005v-.005Zm0 2.247h.006v.006h-.006v-.006Zm2.25-2.248h.006V15H16.5v-.005Z" />
                        </svg>
                        Events
                    </h4>
                    <p class="text-2xl font-bold text-purple-900 dark:text-white">{{ $eventCount }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">This Month</p>
                </div>

                <!-- Bookings -->
                <div class="bg-teal-100 dark:bg-teal-800 p-4 rounded shadow text-center">
                    <h4 class="text-lg font-semibold text-teal-800 dark:text-white flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                        </svg>
                        Bookings
                    </h4>
                    <p class="text-2xl font-bold text-teal-900 dark:text-white">{{ $bookingCount }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">This Month</p>
                </div>

                <!-- Votings -->
                <div class="bg-blue-100 dark:bg-blue-800 p-4 rounded shadow text-center">
                    <h4 class="text-lg font-semibold text-blue-800 dark:text-white flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" 
                            fill="none" stroke="currentColor" stroke-width="1.5" 
                            stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                            <path d="m9 12 2 2 4-4" />
                            <path d="M5 7c0-1.1.9-2 2-2h10a2 2 0 0 1 2 2v12H5V7Z" />
                            <path d="M22 19H2" />
                        </svg>
                        Votings
                    </h4>
                    <p class="text-2xl font-bold text-blue-900 dark:text-white">{{ $votingCount }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">This Month</p>
                </div>

                <!-- Notifications -->
                <div class="bg-emerald-100 dark:bg-emerald-800 p-4 rounded shadow text-center">
                    <h4 class="text-lg font-semibold text-emerald-800 dark:text-white flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6 6 0 1 0-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9" />
                        </svg>
                        Unread Notifications
                    </h4>
                    <p class="text-2xl font-bold text-emerald-900 dark:text-white">{{ $unreadNotifications }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <x-user-dashboard-card
                    title="Events"
                    description="View upcoming surau and community events."
                    route="{{ route('user.events.index') }}"
                    color="bg-purple-600"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-20">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 2.994v2.25m10.5-2.25v2.25m-14.252 13.5V7.491a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v11.251m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5m-6.75-6h2.25m-9 2.25h4.5m.002-2.25h.005v.006H12v-.006Zm-.001 4.5h.006v.006h-.006v-.005Zm-2.25.001h.005v.006H9.75v-.006Zm-2.25 0h.005v.005h-.006v-.005Zm6.75-2.247h.005v.005h-.005v-.005Zm0 2.247h.006v.006h-.006v-.006Zm2.25-2.248h.006V15H16.5v-.005Z" />
                    </svg>
                </x-user-dashboard-card>

                <x-user-dashboard-card
                    title="Facility Booking"
                    description="Submit and track your booking requests."
                    route="{{ route('user.facility-bookings.index') }}"
                    color="bg-teal-600"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-20">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                    </svg>


                </x-user-dashboard-card>

                <x-user-dashboard-card
                    title="Voting & Polls"
                    description="Participate in active community votings."
                    route="{{ route('user.votings.index') }}"
                    color="bg-blue-600"
                >
                    <svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="size-20">
                    <path d="m9 12 2 2 4-4" />
                    <path d="M5 7c0-1.1.9-2 2-2h10a2 2 0 0 1 2 2v12H5V7Z" />
                    <path d="M22 19H2" />
                    </svg>

                </x-user-dashboard-card>

                <x-user-dashboard-card
                    title="Communication Hub"
                    description="Engage in discussions and community updates."
                    route="{{ route('threads.index') }}"
                    color="bg-yellow-600"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-20">
                    <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 12a9.75 9.75 0 1 1 18.356 5.112c-.203.35-.313.75-.313 1.163V21l-4.226-2.111a9.749 9.749 0 0 1-13.817-6.889z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 11.25h.008v.008H8v-.008zm4 0h.008v.008H12v-.008zm4 0h.008v.008H16v-.008z" />
                    </svg>

                </x-user-dashboard-card>

                <x-user-dashboard-card
                    title="Notifications"
                    description="View messages and alerts from the system."
                    route="{{ route('notifications.index') }}"
                    color="bg-emerald-600"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-20">
                    <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6 6 0 1 0-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9" />
                    </svg>

                </x-user-dashboard-card>

            </div>
        </div>
    </div>
</x-app-layout>
