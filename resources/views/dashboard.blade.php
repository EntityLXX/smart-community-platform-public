<x-app-layout>
    <!-- Hero Section -->
    <section class="relative h-[80vh] bg-cover bg-center"
        style="background-image: url('/storage/images/surau-sign-and-hospital.jpg');">
        <div
            class="absolute inset-0 bg-black bg-opacity-20 flex flex-col items-center justify-center text-center text-white px-4">
            <h1 class="text-4xl md:text-5xl font-bold drop-shadow-lg">Welcome to the Smart Community Platform for Taman
                Suria Tropika</h1>
            <p class="mt-4 text-xl">Connecting the Residents of Taman Suria Tropika</p>

            <img src="{{ asset('storage/images/selamat_datang.jpg') }}" alt="Welcome Cartoon Taman Suria Tropika"
                class="mt-6 w-[50px] h-[50px] md:w-[220px] md:h-[220px] rounded-full border-4 border-white shadow-lg object-cover">

            <!--<a href="{{ route('login') }}" class="mt-6 px-6 py-3 bg-green-600 hover:bg-green-700 rounded text-white font-semibold shadow">Get Started</a> -->
        </div>

        <!-- Laravel Cloud-style gradient at the bottom -->
        <!-- Laravel Cloud-style enhanced bottom gradient -->
        <div
            class="absolute bottom-0 left-0 right-0 h-40 bg-gradient-to-t from-black/80 to-transparent pointer-events-none">
        </div>

    </section>


    <!-- About Section -->
    <section class="relative py-20 bg-gray-50 dark:bg-gray-900">
        <div
            class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-black/80 to-transparent z-0 pointer-events-none">
        </div>

        <div class="max-w-6xl mx-auto px-6">
            <div class="relative group">
                <!-- Yellow Offset Layer -->
                <div class="absolute inset-0 translate-x-2 translate-y-2 bg-purple-600 rounded-3xl z-0 transition duration-300 group-hover:translate-x-3 group-hover:translate-y-3"></div>

                <!-- Main Card -->
                <div class="relative bg-black text-white p-10 rounded-3xl shadow-lg z-10 block
                            ring-purple-600 ring-2 ring-offset-2 ring-offset-black
                            transition duration-300 ease-in-out group-hover:scale-[1.02] group-hover:shadow-xl">
                                <div class="md:flex md:items-start md:gap-12">
                                    <!-- Left: Text Content -->
                                    <div class="md:w-1/2 mb-10 md:mb-0">
                                        <h2 class="text-3xl md:text-4xl font-bold mb-4 leading-snug">
                                            About Taman Suria Tropika
                                        </h2>
                                        <p class="text-gray-300 mb-6 text-base md:text-lg leading-relaxed">
                                            Taman Suria Tropika is a thriving community in Seri Kembangan, Selangor, known for
                                            its active residents and close-knit atmosphere.
                                        </p>

                                    </div>

                                    <!-- Right: Slide Show with Staggered Grid and Individual Images -->
                                    <div class="md:w-1/2" x-data="{
                                        current: 0,
                                        total: 5,
                                        get indexes() {
                                            return Array.from({ length: this.total }, (_, i) => i)
                                        },
                                        next() { this.current = (this.current + 1) % this.total },
                                        prev() { this.current = (this.current - 1 + this.total) % this.total }
                                    }">
                                        <div class="relative w-full overflow-hidden rounded-3xl shadow-xl h-[370px] md:h-[400px]">
                                            <!-- Slide 0: Staggered Grid -->
                                            <div x-show="current === 0" x-transition class="absolute inset-0 flex gap-4 p-2">
                                                <!-- Column 1 -->
                                                <div class="flex flex-col gap-4 w-1/2">
                                                    <img src="{{ asset('storage/images/event-raya.jpg') }}" alt="Gallery 1"
                                                        class="rounded-xl ring-2 ring-purple-400 object-cover w-full h-32 md:h-40 shadow-md">
                                                    <img src="{{ asset('storage/images/eating_together.jpg') }}" alt="Gallery 3"
                                                        class="rounded-xl ring-2 ring-green-400 object-cover w-full h-48 md:h-56 shadow-md">
                                                </div>

                                                <!-- Column 2 -->
                                                <div class="flex flex-col gap-4 w-1/2 mt-8">
                                                    <img src="{{ asset('storage/images/arena_together.jpg') }}" alt="Gallery 2"
                                                        class="rounded-xl ring-2 ring-yellow-400 object-cover w-full h-40 md:h-52 shadow-md">
                                                    <img src="{{ asset('storage/images/variety_stalls.jpg') }}" alt="Gallery 4"
                                                        class="rounded-xl ring-2 ring-blue-400 object-cover w-full h-36 md:h-44 shadow-md">
                                                </div>
                                            </div>

                                            <!-- Slide 1 -->
                                            <div x-show="current === 1" x-transition class="absolute inset-0">
                                                <img src="{{ asset('storage/images/event-raya.jpg') }}" alt="Gallery 1"
                                                    class="w-full h-full object-cover rounded-xl shadow-md">
                                            </div>

                                            <!-- Slide 2 -->
                                            <div x-show="current === 2" x-transition class="absolute inset-0">
                                                <img src="{{ asset('storage/images/eating_together.jpg') }}" alt="Gallery 3"
                                                    class="w-full h-full object-cover rounded-xl shadow-md">
                                            </div>

                                            <!-- Slide 3 -->
                                            <div x-show="current === 3" x-transition class="absolute inset-0">
                                                <img src="{{ asset('storage/images/arena_together.jpg') }}" alt="Gallery 2"
                                                    class="w-full h-full object-cover rounded-xl shadow-md">
                                            </div>

                                            <!-- Slide 4 -->
                                            <div x-show="current === 4" x-transition class="absolute inset-0">
                                                <img src="{{ asset('storage/images/variety_stalls.jpg') }}" alt="Gallery 4"
                                                    class="w-full h-full object-cover rounded-xl shadow-md">
                                            </div>

                                            <!-- Navigation Arrows -->
                                            <button @click="prev"
                                                class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black text-white p-2 rounded-full z-20">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15.75 19.5 8.25 12l7.5-7.5" />
                                                </svg>
                                            </button>
                                            <button @click="next"
                                                class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black text-white p-2 rounded-full z-20">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                                </svg>
                                            </button>

                                            <!-- Navigation Dots -->
                                            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2 z-20">
                                                <template x-for="index in indexes" :key="index">
                                                    <button @click="current = index" :class="current === index
                                                        ? 'w-3 h-3 rounded-full bg-yellow-400'
                                                        : 'w-3 h-3 rounded-full bg-gray-300 dark:bg-gray-600'"
                                                        class="transition duration-300">
                                                    </button>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>




    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-12">~Platform Highlights~</h2>
        </div>

        <div class="max-w-5xl mx-auto grid grid-cols-1 gap-8">
            <div class="flex justify-center mb-4">
                <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}"
                class="px-4 py-1.5 text-sm rounded-full font-medium text-white bg-rose-600 hover:bg-rose-700 transition shadow">
                    Go to Dashboard
                </a>
            </div>

            <!-- Top Row -->
            <div class="flex justify-center">
                <div class="w-full sm:w-1/3">
                    <x-dashboard-card title="Community Events" description="Stay updated on upcoming surau and community events." color="bg-purple-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-20">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 2.994v2.25m10.5-2.25v2.25m-14.252 13.5V7.491a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v11.251m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5m-6.75-6h2.25m-9 2.25h4.5m.002-2.25h.005v.006H12v-.006Zm-.001 4.5h.006v.006h-.006v-.005Zm-2.25.001h.005v.006H9.75v-.006Zm-2.25 0h.005v.005h-.006v-.005Zm6.75-2.247h.005v.005h-.005v-.005Zm0 2.247h.006v.006h-.006v-.006Zm2.25-2.248h.006V15H16.5v-.005Z" />
                        </svg>
                    </x-dashboard-card>
                </div>
            </div>

            <!-- Middle Row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 max-w-3xl mx-auto">
                <x-dashboard-card title="Financial Records" description="Manage the surau's financial records and donation." color="bg-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-20">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </x-dashboard-card>

                <x-dashboard-card title="Facility Booking" description="Request and manage bookings for facilities conveniently." color="bg-teal-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-20">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                    </svg>
                </x-dashboard-card>
            </div>



            <!-- Bottom Row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">


                <x-dashboard-card title="Voting & Polls" description="Participate in active community votings."
                    color="bg-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-20">
                        <path d="m9 12 2 2 4-4" />
                        <path d="M5 7c0-1.1.9-2 2-2h10a2 2 0 0 1 2 2v12H5V7Z" />
                        <path d="M22 19H2" />
                    </svg>
                </x-dashboard-card>

                <x-dashboard-card title="Communication Hub"
                    description="Get important notices, updates, and converse with the community."
                    color="bg-yellow-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-20">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 12a9.75 9.75 0 1 1 18.356 5.112c-.203.35-.313.75-.313 1.163V21l-4.226-2.111a9.749 9.749 0 0 1-13.817-6.889z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 11.25h.008v.008H8v-.008zm4 0h.008v.008H12v-.008zm4 0h.008v.008H16v-.008z" />
                    </svg>
                </x-dashboard-card>
            </div>
        </div>
    </section>

        <!-- About Section -->
    <section class="relative py-20 bg-gray-50 dark:bg-gray-900">


        <div class="max-w-6xl mx-auto px-6">
            <div class="relative group">
                <!-- Yellow Offset Layer -->
                <div class="absolute inset-0 translate-x-2 translate-y-2 bg-blue-600 rounded-3xl z-0 transition duration-300 group-hover:translate-x-3 group-hover:translate-y-3"></div>

                <!-- Main Card -->
                <div class="relative bg-black text-white p-10 rounded-3xl shadow-lg z-10 block
                            ring-blue-600 ring-2 ring-offset-2 ring-offset-black
                            transition duration-300 ease-in-out group-hover:scale-[1.02] group-hover:shadow-xl">
                                <div class="md:flex md:items-start md:gap-12">
                                    <!-- Left: Text Content -->
                                    <div class="md:w-1/2 mb-10 md:mb-0">
                                        <h2 class="text-3xl md:text-4xl font-bold mb-4 leading-snug">
                                            About Surau Al-Ansar
                                        </h2>
                                        <p class="text-gray-300 mb-6 text-base md:text-lg leading-relaxed">
                                        Surau Al-Ansar is a community prayer hall located in Taman Suria Tropika, near the Shell station along the SKVE highway and adjacent to Andorra Hospital. 
                                        Beyond serving as a place of worship for daily prayers and religious gatherings, it also acts as a vital hub for fostering community bonds among residents.                                        </p>

                                    </div>

                                    <!-- Right: Slide Show with Staggered Grid and Individual Images -->
                                    <div class="md:w-1/2" x-data="{
                                        current: 0,
                                        total: 5,
                                        get indexes() {
                                            return Array.from({ length: this.total }, (_, i) => i)
                                        },
                                        next() { this.current = (this.current + 1) % this.total },
                                        prev() { this.current = (this.current - 1 + this.total) % this.total }
                                    }">
                                        <div class="relative w-full overflow-hidden rounded-3xl shadow-xl h-[370px] md:h-[400px]">
                                            <!-- Slide 0: Staggered Grid -->
                                            <div x-show="current === 0" x-transition class="absolute inset-0 flex gap-4 p-2">
                                                <!-- Column 1 -->
                                                <div class="flex flex-col gap-4 w-1/2">
                                                    <img src="{{ asset('storage/images/surau-gold-sign.jpg') }}" alt="Gallery 1"
                                                        class="rounded-xl ring-2 ring-purple-400 object-cover w-full h-32 md:h-40 shadow-md">
                                                    <img src="{{ asset('storage/images/jemaah-one.jpg') }}" alt="Gallery 3"
                                                        class="rounded-xl ring-2 ring-green-400 object-cover w-full h-48 md:h-56 shadow-md">
                                                </div>

                                                <!-- Column 2 -->
                                                <div class="flex flex-col gap-4 w-1/2 mt-8">
                                                    <img src="{{ asset('storage/images/surau-makan.jpg') }}" alt="Gallery 2"
                                                        class="rounded-xl ring-2 ring-yellow-400 object-cover w-full h-40 md:h-52 shadow-md">
                                                    <img src="{{ asset('storage/images/bacaan.jpg') }}" alt="Gallery 4"
                                                        class="rounded-xl ring-2 ring-blue-400 object-cover w-full h-36 md:h-44 shadow-md">
                                                </div>
                                            </div>

                                            <!-- Slide 1 -->
                                            <div x-show="current === 1" x-transition class="absolute inset-0">
                                                <img src="{{ asset('storage/images/surau-gold-sign.jpg') }}" alt="Gallery 1"
                                                    class="w-full h-full object-cover rounded-xl shadow-md">
                                            </div>

                                            <!-- Slide 2 -->
                                            <div x-show="current === 2" x-transition class="absolute inset-0">
                                                <img src="{{ asset('storage/images/jemaah-one.jpg') }}" alt="Gallery 3"
                                                    class="w-full h-full object-cover rounded-xl shadow-md">
                                            </div>

                                            <!-- Slide 3 -->
                                            <div x-show="current === 3" x-transition class="absolute inset-0">
                                                <img src="{{ asset('storage/images/surau-makan.jpg') }}" alt="Gallery 2"
                                                    class="w-full h-full object-cover rounded-xl shadow-md">
                                            </div>

                                            <!-- Slide 4 -->
                                            <div x-show="current === 4" x-transition class="absolute inset-0">
                                                <img src="{{ asset('storage/images/bacaan.jpg') }}" alt="Gallery 4"
                                                    class="w-full h-full object-cover rounded-xl shadow-md">
                                            </div>

                                            <!-- Navigation Arrows -->
                                            <button @click="prev"
                                                class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black text-white p-2 rounded-full z-20">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15.75 19.5 8.25 12l7.5-7.5" />
                                                </svg>
                                            </button>
                                            <button @click="next"
                                                class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black text-white p-2 rounded-full z-20">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                                </svg>
                                            </button>

                                            <!-- Navigation Dots -->
                                            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2 z-20">
                                                <template x-for="index in indexes" :key="index">
                                                    <button @click="current = index" :class="current === index
                                                        ? 'w-3 h-3 rounded-full bg-yellow-400'
                                                        : 'w-3 h-3 rounded-full bg-gray-300 dark:bg-gray-600'"
                                                        class="transition duration-300">
                                                    </button>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>



    

    <section class="py-16 bg-white dark:bg-gray-900">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-12">~Surau Al-Ansar Organizational
                Information (2024 to 2026)~</h2>

                <!-- Surau Info Box with hover effect -->
                <div class="relative group mb-10">
                    <!-- Offset background -->
                    <div class="absolute inset-0 translate-x-2 translate-y-2 bg-yellow-400 rounded-3xl z-0 transition duration-300 group-hover:translate-x-3 group-hover:translate-y-3"></div>

                    <!-- Main content card -->
                    <div
                        class="relative bg-black text-white p-6 md:p-10 rounded-3xl shadow-lg z-10 ring-2 ring-yellow-400 ring-offset-2 ring-offset-black
                            transition duration-300 ease-in-out group-hover:scale-[1.02] group-hover:shadow-xl">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm sm:text-base text-left">
                            <div>
                                <p class="text-yellow-300 font-semibold">Surau</p>
                                <p class="text-white">Al-Ansar</p>
                            </div>
                            <div>
                                <p class="text-yellow-300 font-semibold">Kariah Masjid</p>
                                <p class="text-white">Masjid Meranti</p>
                            </div>
                            <div>
                                <p class="text-yellow-300 font-semibold">Alamat</p>
                                <p class="text-white">Taman Suria Tropika</p>
                            </div>
                            <div>
                                <p class="text-yellow-300 font-semibold">Daerah</p>
                                <p class="text-white">Sepang</p>
                            </div>
                        </div>

                        <!-- Legal text -->
                        <p class="mt-6 text-gray-300 text-sm leading-relaxed">
                            “Menurut kuasa di bawah subperaturan 27(2) dan Peraturan 28, Peraturan-Peraturan Masjid dan Surau (Negeri Selangor) 2017, Majlis dengan ini melantik anggota Jawatankuasa Surau dan Pemeriksa Kira-Kira seperti senarai berikut untuk mentadbir dan menguruskan apa-apa perkara yang berhubungan dengan surau.”
                        </p>
                    </div>
                </div>


            <div class="flex flex-col items-center gap-10">
                <!-- Chair & Vice -->
                <div class="space-y-6">
                    @include('components.org-card', [
                        'role' => 'Pengerusi',
                        'name' => 'Izam Bin Md Aris',
                        'color' => 'bg-yellow-500'
                    ])
                    @include('components.org-card', [
                        'role' => 'Timbalan Pengerusi',
                        'name' => 'Dr. Borhannudin Bin Abdullah',
                        'color' => 'bg-yellow-500'
                    ])
                </div>

                    <!-- Imam & Bilal -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @include('components.org-card', ['role' => 'Imam 1', 'name' => 'Mohd Zaki Bin Suliman', 'color' => 'bg-blue-600'])
                    @include('components.org-card', ['role' => 'Imam 2', 'name' => 'Dr. Adi Yasran Bin Abdul Aziz', 'color' => 'bg-blue-600'])
                    @include('components.org-card', ['role' => 'Bilal 1', 'name' => 'Mohd Asri Bin Nun', 'color' => 'bg-teal-600'])
                    @include('components.org-card', ['role' => 'Bilal 2', 'name' => 'Zainuddin Bin Abdul Aziz', 'color' => 'bg-teal-600'])
                </div>
  
                 <!--  Siak -->
                <div class="grid grid-cols-2 gap-6">
                    @include('components.org-card', ['role' => 'Siak 1', 'name' => 'Che Azmi Bin Abdul Hamid', 'color' => 'bg-purple-600'])
                    @include('components.org-card', ['role' => 'Siak 2', 'name' => 'Mohd Zulaila Bin Mohd Zain', 'color' => 'bg-purple-600'])
                </div>
  
                  <!-- Finance -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @include('components.org-card', ['role' => 'Bendahari', 'name' => 'Norazlan Bin Ithnin', 'color' => 'bg-green-600'])
                    @include('components.org-card', ['role' => 'Penolong Bendahari', 'name' => 'Nor Shahril Bin Abdul Rahman', 'color' => 'bg-green-600'])
                    @include('components.org-card', ['role' => 'Wakil Pemuda', 'name' => 'Abbas Bin Abdul Shukur', 'color' => 'bg-green-600'])
                </div>
   
                 <!-- Women Section -->
                <div class="grid grid-cols-2 gap-6">
                    @include('components.org-card', ['role' => 'Wakil Muslimat', 'name' => 'Mathnah Binti Jalil', 'color' => 'bg-pink-500'])
                    @include('components.org-card', ['role' => 'Pengurus Jenazah Muslimat', 'name' => 'Kamariah Binti Samat', 'color' => 'bg-pink-500'])
                </div>
   
                 <!-- AJK -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @include('components.org-card', ['role' => 'AJK', 'name' => 'Shamsuddin Bin Md Sarif', 'color' => 'bg-indigo-600'])
                    @include('components.org-card', ['role' => 'AJK', 'name' => 'Azmir Bin Kassim', 'color' => 'bg-indigo-600'])
                    @include('components.org-card', ['role' => 'AJK', 'name' => 'Zaidi Bin Md Zain', 'color' => 'bg-indigo-600'])
                </div>
    
            <!-- Pemeriksa Kira-Kira -->
            <div class="grid grid-cols-2 gap-6">
                @include('components.org-card', ['role' => 'Pemeriksa Kira-Kira I', 'name' => 'Md Farishzan Bin Ismail', 'color' => 'bg-red-600'])
                @include('components.org-card', ['role' => 'Pemeriksa Kira-Kira II', 'name' => 'Azam Bin Abdul Shukor', 'color' => 'bg-red-600'])
            </div>
        </div>
    </div>
</section>


</x-app-layout>