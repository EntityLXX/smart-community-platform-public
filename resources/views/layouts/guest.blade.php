<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    </head>
<body class="font-sans text-gray-900 antialiased bg-white dark:bg-gray-900">
    <div class="min-h-screen flex flex-col lg:flex-row">

        {{-- Left Illustration Section --}}
        <div class="hidden lg:flex lg:w-1/2 bg-cover bg-top"
             style="background-image: url('{{ asset('storage/images/view_of_tst.png') }}');">
        </div>

        {{-- Right Login Form Section --}}
        <div class="flex w-full lg:w-1/2 justify-center items-center p-8 bg-white dark:bg-gray-900">
            <div class="w-full max-w-md space-y-6">

            @php
                $isLogin = request()->routeIs('login');
                $isRegister = request()->routeIs('register');
            @endphp

            <div class="flex justify-center mb-6 space-x-4">
                <a href="{{ route('login') }}"
                class="px-4 py-2 rounded-full text-sm font-semibold transition focus:outline-none
                        {{ $isLogin ? 'bg-purple-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                    Log in
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                    class="px-4 py-2 rounded-full text-sm font-semibold transition focus:outline-none
                            {{ $isRegister ? 'bg-purple-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                        Register
                    </a>
                @endif
            </div>


                <div class="text-center">
                    <!--<img src="{{ asset('storage/images/orbit-logo.png') }}" 
                         alt="Logo" 
                         class="mx-auto w-40 mb-2">-->
                    <p class="text-sm text-gray-500 dark:text-gray-300">Streamline your community system</p>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
