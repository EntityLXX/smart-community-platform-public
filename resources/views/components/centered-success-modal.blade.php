@if(session('success'))
<div 
    x-data="{ open: true, countdown: 1 }" 
    x-init="
        let timer = setInterval(() => {
            countdown--;
            if (countdown <= 0) {
                clearInterval(timer);
                open = false;
            }
        }, 1000);
    " 
    x-show="open"
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
>
    <div class="bg-white dark:bg-gray-800 p-8 rounded-lg text-center shadow-lg max-w-sm w-full">
        {{-- Animated SVG or fallback --}}
        <div class="mb-4 flex justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
            <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
        </svg>
        </div>
        <h2 class="text-2xl font-bold text-green-600">Success</h2>
        <p class="text-gray-700 dark:text-gray-300 mt-2">{{ session('success') }}</p>
        <button 
            x-text="`OK (${countdown}s)`" 
            @click="open = false"
            class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
        </button>
    </div>
</div>
@endif
