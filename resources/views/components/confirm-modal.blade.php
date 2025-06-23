{{-- resources/views/components/confirm-modal.blade.php --}}
<div x-data x-init="
    Alpine.store('confirmModal', {
        show: false,
        title: '',
        message: '',
        action: () => {},
        open(title, message, action, theme = 'info') {
            this.title = title;
            this.message = message;
            this.action = action;
            this.theme = theme;
            this.show = true;
        },
        close() {
            this.show = false;
        }
    });
    window.confirmModal = Alpine.store('confirmModal');
" x-cloak>

    <div x-show="$store.confirmModal.show"

         x-transition
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70 px-4">
        <div class="relative max-w-md w-full bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 text-center">
            <button @click="window.confirmModal.close()"
                    class="absolute top-4 right-4 text-black dark:text-white text-2xl font-bold hover:text-red-600">
                ✕
            </button>
            <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white"
                x-text="window.confirmModal.title"></h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6"
               x-text="window.confirmModal.message"></p>
            <div class="flex justify-center gap-4">
                <button @click="window.confirmModal.close()"
                        class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-500">Cancel</button>
                <button
                    :class="{
                        'bg-red-600 hover:bg-red-700': $store.confirmModal.theme === 'danger',
                        'bg-yellow-500 hover:bg-yellow-600': $store.confirmModal.theme === 'warning',
                        'bg-blue-600 hover:bg-blue-700': $store.confirmModal.theme === 'info'
                    }"
                    class="px-4 py-2 text-white rounded"
                    @click="$store.confirmModal.action(); $store.confirmModal.close()"
                >
                    Confirm
                </button>
            </div>
        </div>
    </div>
</div>
