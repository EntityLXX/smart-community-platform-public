@if(session('error'))
<div 
    x-data="{ open: true, countdown: 3 }" 
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
        <div class="mb-4 flex justify-center text-red-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.25-8.25-3.286Zm0 13.036h.008v.008H12v-.008Z" />
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-red-600">Access Denied</h2>
        <p class="text-gray-700 dark:text-gray-300 mt-2">{{ session('error') }}</p>
        <button 
            x-text="`OK (${countdown}s)`" 
            @click="open = false"
            class="mt-4 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
        </button>
    </div>
</div>
@endif
