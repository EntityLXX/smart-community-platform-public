<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{
          theme: localStorage.getItem('theme') || 'light',
          toggleTheme() {
              this.theme = this.theme === 'light' ? 'dark' : 'light';
              localStorage.setItem('theme', this.theme);
              document.documentElement.classList.toggle('dark', this.theme === 'dark');
          }
      }"
      x-init="
          document.documentElement.classList.toggle('dark', theme === 'dark');
          $watch('theme', val => {
              localStorage.setItem('theme', val);
              document.documentElement.classList.toggle('dark', val === 'dark');
          })
      ">
      
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')
        <div x-data="sidebarController()" x-init="init()" x-id="['sidebar']" class="min-h-screen flex" x-ref="layout">


            {{-- Sidebar --}}
            <aside :class="{ 'w-64': sidebarOpen, 'w-16': !sidebarOpen }" class="sticky top-0 h-screen transition-all duration-300 bg-white dark:bg-gray-800 p-4 border-r border-gray-200 dark:border-gray-700 overflow-y-auto z-30">
                
                {{-- Toggle Button --}}
                <button @click="toggleSidebar()"
                        class="mb-6 text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                    <svg x-show="!sidebarOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5m-16.5 7.5h16.5m-16.5 7.5h16.5" />
                    </svg>
                    <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>



                {{-- Theme Toggle + Navigation Links --}}
                <nav class="flex flex-col space-y-2 items-stretch">
                    {{-- Theme Toggle --}}
                    <button @click="toggleTheme()"
                            class="flex items-center gap-3 py-2 px-0.5 rounded-md transition text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 w-full">

                        <!-- Expanded view with label and mode-specific icon -->
                        <span x-show="sidebarOpen" class="flex items-center gap-2">
                            <template x-if="theme === 'light'">
                                <span class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-moon text-gray-700 dark:text-white" viewBox="0 0 16 16">
                                        <path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278"/>
                                    </svg>
                                    Enable Dark Mode
                                </span>
                            </template>

                            <template x-if="theme === 'dark'">
                                <span class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-brightness-high text-gray-700 dark:text-white" viewBox="0 0 16 16">
                                        <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708"/>
                                    </svg>
                                    Enable Light Mode
                                </span>
                            </template>
                        </span>

                        <!-- Collapsed view with single icon -->
                        <span x-show="!sidebarOpen" class="w-10 h-10 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-highlights text-gray-700 dark:text-white" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 0 0 8a8 8 0 0 0 16 0m-8 5v1H4.5a.5.5 0 0 0-.093.009A7 7 0 0 1 3.1 13zm0-1H2.255a7 7 0 0 1-.581-1H8zm-6.71-2a7 7 0 0 1-.22-1H8v1zM1 8q0-.51.07-1H8v1zm.29-2q.155-.519.384-1H8v1zm.965-2q.377-.54.846-1H8v1zm2.137-2A6.97 6.97 0 0 1 8 1v1z"/>
                            </svg>
                        </span>
                    </button>

                    {{-- Navigation Links --}}

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 py-2 px-0.5 rounded-md hover:bg-rose-100 dark:hover:bg-rose-700 transition duration-150
                            {{ request()->routeIs('admin.dashboard') 
                                ? 'bg-rose-600 dark:bg-rose-600 text-white dark:text-white font-semibold' 
                                : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        
                            <!-- Expanded view -->
                            <span x-show="sidebarOpen" class="flex items-center gap-2 whitespace-nowrap">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-laptop" viewBox="0 0 16 16">
                                    <path d="M13.5 3a.5.5 0 0 1 .5.5V11H2V3.5a.5.5 0 0 1 .5-.5zm-11-1A1.5 1.5 0 0 0 1 3.5V12h14V3.5A1.5 1.5 0 0 0 13.5 2zM0 12.5h16a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 12.5"/>
                                </svg>
                                Dashboard
                            </span>

                            <!-- Collapsed view -->
                            <span x-show="!sidebarOpen" class="w-10 h-10 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-laptop text-gray-700 dark:text-white" viewBox="0 0 16 16">
                                    <path d="M13.5 3a.5.5 0 0 1 .5.5V11H2V3.5a.5.5 0 0 1 .5-.5zm-11-1A1.5 1.5 0 0 0 1 3.5V12h14V3.5A1.5 1.5 0 0 0 13.5 2zM0 12.5h16a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 12.5"/>
                                </svg>
                            </span>
                        </a>
                    @else
                        <a href="{{ route('user.dashboard') }}"
                        class="flex items-center gap-3 py-2 px-0.5 rounded-md transition duration-150
                            {{ request()->routeIs('user.dashboard') 
                                ? 'bg-rose-600 dark:bg-rose-600 text-white dark:text-white font-semibold' 
                                : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        
                            <!-- Expanded view -->
                            <span x-show="sidebarOpen" class="flex items-center gap-2 whitespace-nowrap">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-laptop" viewBox="0 0 16 16">
                                    <path d="M13.5 3a.5.5 0 0 1 .5.5V11H2V3.5a.5.5 0 0 1 .5-.5zm-11-1A1.5 1.5 0 0 0 1 3.5V12h14V3.5A1.5 1.5 0 0 0 13.5 2zM0 12.5h16a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 12.5"/>
                                </svg>
                                Dashboard
                            </span>

                            <!-- Collapsed view -->
                            <span x-show="!sidebarOpen" class="w-10 h-10 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-laptop text-gray-700 dark:text-white" viewBox="0 0 16 16">
                                    <path d="M13.5 3a.5.5 0 0 1 .5.5V11H2V3.5a.5.5 0 0 1 .5-.5zm-11-1A1.5 1.5 0 0 0 1 3.5V12h14V3.5A1.5 1.5 0 0 0 13.5 2zM0 12.5h16a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 12.5"/>
                                </svg>
                            </span>
                        </a>
                    @endif


                    {{-- Shared: Community Events link with role label --}}
                    <a href="{{ route('user.events.index') }}"
                    class="flex items-center gap-3 py-2 px-0.5 rounded-md hover:bg-purple-100 dark:hover:bg-purple-700 transition duration-150
                            {{ request()->routeIs('user.events.*') ? 'bg-purple-600 dark:bg-purple-600 text-white dark:text-white font-semibold' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        
                        <!-- Icon and label when sidebar is expanded -->
                        <span x-show="sidebarOpen" class="flex items-center gap-2 whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 2.994v2.25m10.5-2.25v2.25m-14.252 13.5V7.491a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v11.251m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5m-6.75-6h2.25m-9 2.25h4.5m.002-2.25h.005v.006H12v-.006Zm-.001 4.5h.006v.006h-.006v-.005Zm-2.25.001h.005v.006H9.75v-.006Zm-2.25 0h.005v.005h-.006v-.005Zm6.75-2.247h.005v.005h-.005v-.005Zm0 2.247h.006v.006h-.006v-.006Zm2.25-2.248h.006V15H16.5v-.005Z" />
                            </svg>
                            Community Events
                        </span>

                        <!-- Icon-only view when sidebar is collapsed -->
                        <span x-show="!sidebarOpen" class="w-10 h-10 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-700 dark:text-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 2.994v2.25m10.5-2.25v2.25m-14.252 13.5V7.491a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v11.251m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5m-6.75-6h2.25m-9 2.25h4.5m.002-2.25h.005v.006H12v-.006Zm-.001 4.5h.006v.006h-.006v-.005Zm-2.25.001h.005v.006H9.75v-.006Zm-2.25 0h.005v.005h-.006v-.005Zm6.75-2.247h.005v.005h-.005v-.005Zm0 2.247h.006v.006h-.006v-.006Zm2.25-2.248h.006V15H16.5v-.005Z" />
                            </svg>
                        </span>
                    </a>


                    {{-- Shared: Facility Bookings --}}
                    <a href="{{ route('user.facility-bookings.index') }}" 
                        class="flex items-center gap-3 py-2 px-0.5 rounded-md hover:bg-teal-100 dark:hover:bg-teal-700 transition duration-150 
                        {{ request()->routeIs('user.facility-bookings.*') 
                            ? 'bg-teal-600 dark:bg-teal-600 text-white dark:text-white font-semibold' 
                            : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        
                        <!-- Expanded view: icon + label -->
                        <span x-show="sidebarOpen" class="flex items-center gap-2 whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                    d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                            </svg>
                            Facility Booking Requests
                        </span>

                        <!-- Collapsed view: icon only, centered -->
                        <span x-show="!sidebarOpen" class="w-10 h-10 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-700 dark:text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                    d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                            </svg>
                        </span>
                    </a>


                    {{-- Shared: Go to User Voting Page --}}
                    <a href="{{ route('user.votings.index') }}"
                        class="flex items-center gap-3 py-2 px-0.5 rounded-md transition duration-150
                            {{ request()->routeIs('user.votings.*')
                                ? 'bg-blue-600 dark:bg-blue-600 text-white dark:text-white font-semibold'
                                : 'text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-blue-700' }}">
                        
                        <!-- Expanded view: icon + label -->
                        <span x-show="sidebarOpen" class="flex items-center gap-2 whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" 
                                fill="none" stroke="currentColor" stroke-width="1.5" 
                                stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                                <path d="m9 12 2 2 4-4" />
                                <path d="M5 7c0-1.1.9-2 2-2h10a2 2 0 0 1 2 2v12H5V7Z" />
                                <path d="M22 19H2" />
                            </svg>
                            Community Votings
                        </span>

                        <!-- Collapsed view: icon only, centered -->
                        <span x-show="!sidebarOpen" class="w-10 h-10 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" 
                                fill="none" stroke="currentColor" stroke-width="1.5" 
                                stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-gray-700 dark:text-white">
                                <path d="m9 12 2 2 4-4" />
                                <path d="M5 7c0-1.1.9-2 2-2h10a2 2 0 0 1 2 2v12H5V7Z" />
                                <path d="M22 19H2" />
                            </svg>
                        </span>
                    </a>


                    {{-- Shared: Community Hub --}}
                    <a href="{{ route('threads.index') }}" 
                    class="flex items-center gap-3 py-2 px-0.5 rounded-md hover:bg-yellow-100 dark:hover:bg-yellow-700 transition duration-150 
                        {{ request()->routeIs('threads.*') 
                            ? 'bg-yellow-600 dark:bg-yellow-600 text-white dark:text-white font-semibold' 
                            : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        
                        <!-- Expanded view: icon + label -->
                        <span x-show="sidebarOpen" class="flex items-center gap-2 whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 12a9.75 9.75 0 1 1 18.356 5.112c-.203.35-.313.75-.313 1.163V21l-4.226-2.111a9.749 9.749 0 0 1-13.817-6.889z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 11.25h.008v.008H8v-.008zm4 0h.008v.008H12v-.008zm4 0h.008v.008H16v-.008z" />
                            </svg>
                            Communication Hub
                        </span>

                        <!-- Collapsed view: icon only, centered -->
                        <span x-show="!sidebarOpen" class="w-10 h-10 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-700 dark:text-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 12a9.75 9.75 0 1 1 18.356 5.112c-.203.35-.313.75-.313 1.163V21l-4.226-2.111a9.749 9.749 0 0 1-13.817-6.889z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 11.25h.008v.008H8v-.008zm4 0h.008v.008H12v-.008zm4 0h.008v.008H16v-.008z" />
                            </svg>
                        </span>
                    </a>


                    {{-- Shared: Notifications --}}
                    <a href="{{ route('notifications.index') }}" 
                        class="relative flex items-center gap-3 py-2 px-0.5 rounded-md hover:bg-pink-100 dark:hover:bg-pink-700 transition duration-150 
                        {{ request()->routeIs('notifications.*') 
                            ? 'bg-pink-500 dark:bg-pink-500 text-white dark:text-white font-semibold' 
                            : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        
                        <!-- Expanded view: icon + label -->
                        <span x-show="sidebarOpen" class="flex items-center gap-2 whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6 6 0 1 0-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9" />
                            </svg>
                            Notifications

                            @if(isset($unreadNotifications) && $unreadNotifications > 0)
                                <span class="ml-auto text-xs bg-red-600 text-white rounded-full px-2 py-0.5 transition-all duration-200">
                                    {{ $unreadNotifications }}
                                </span>
                            @endif
                        </span>

                        <!-- Collapsed view: icon only, centered -->
                        <span x-show="!sidebarOpen" class="w-10 h-10 flex items-center justify-center relative">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-700 dark:text-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6 6 0 1 0-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9" />
                            </svg>

                            @if(isset($unreadNotifications) && $unreadNotifications > 0)
                                <span class="absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 text-[10px] bg-red-600 text-white rounded-full px-1.5 py-0.5 transition-all duration-200">
                                    {{ $unreadNotifications }}
                                </span>
                            @endif
                        </span>
                    </a>


                    {{-- Add more shared links around here --}}

                    <form method="POST" action="{{ route('logout') }}" class="mt-4">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 py-2 px-0.5 rounded-md text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-700 transition w-full">
                            
                            <!-- Expanded view -->
                            <span x-show="sidebarOpen" class="flex items-center gap-2 whitespace-nowrap">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-door-open" viewBox="0 0 16 16">
                                    <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1"/>
                                    <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117M11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5M4 1.934V15h6V1.077z"/>
                                </svg>
                                Logout
                            </span>

                            <!-- Collapsed view -->
                            <span x-show="!sidebarOpen" class="w-10 h-10 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-door-open text-red-600 dark:text-red-400" viewBox="0 0 16 16">
                                    <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1"/>
                                    <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117M11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5M4 1.934V15h6V1.077z"/>
                                </svg>
                            </span>
                        </button>
                    </form>

                </nav>
            </aside>

            {{-- Main Content --}}
            <div class="flex-1">

                @isset($header)
                    <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="max-w-7xl mx-auto py-1.5 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main>
                    {{ $slot }}
                </main>

                @stack('scripts')

            </div>
        </div>

        <x-centered-success-modal />
        <x-centered-error-modal />

        <x-confirm-modal />

        <script>
            function sidebarController() {
                return {
                    sidebarOpen: JSON.parse(localStorage.getItem('sidebarOpen')) ?? false,
                    toggleSidebar() {
                        this.sidebarOpen = !this.sidebarOpen;
                        localStorage.setItem('sidebarOpen', JSON.stringify(this.sidebarOpen));

                        // Dispatch custom event to notify other scripts
                        window.dispatchEvent(new Event('sidebar-toggled'));
                    },
                    init() {
                        // Trigger resize after initial load for safety
                        setTimeout(() => window.dispatchEvent(new Event('sidebar-toggled')), 100);
                    }
                }
            }
        </script>

    </body>
</html>
