import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        events: '/admin/facility-bookings/calendar-data',
        height: 'auto',

        eventClick: function (info) {
            const { title, extendedProps, start } = info.event;

            // Remove any existing modal (avoid duplicates)
            const existingModal = document.getElementById('calendarModal');
            if (existingModal) existingModal.remove();

            // Create the modal HTML
            const modalHtml = `
                <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70 px-4" id="calendarModal">
                    <div class="relative max-w-xl w-full max-h-[90vh] overflow-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                        <!-- Close Button -->
                        <button onclick="document.getElementById('calendarModal').remove()"
                                class="absolute top-4 right-4 text-black dark:text-white text-3xl font-bold rounded hover:text-red-600 focus:outline-none z-10">
                            ✕
                        </button>

                        <!-- Modal Content -->
                        <h3 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">${title}</h3>

                        <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                            <p><strong>Date:</strong> ${start.toLocaleDateString()}</p>
                            <p><strong>Time:</strong> ${start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</p>
                            <p><strong>Status:</strong> ${extendedProps.status}</p>
                            <p><strong>Purpose:</strong> ${extendedProps.purpose}</p>
                            <p><strong>Admin Notes:</strong> ${extendedProps.notes ?? 'None'}</p>
                        </div>

                        <!-- Optional "Close" button at bottom -->
                        <div class="mt-6 text-center">
                            <button onclick="document.getElementById('calendarModal').remove()"
                                    class="inline-block px-6 py-2 bg-gray-700 text-white text-sm rounded hover:bg-gray-600 transition">
                                ← Back
                            </button>
                        </div>
                    </div>
                </div>
            `;

            document.body.insertAdjacentHTML('beforeend', modalHtml);
        }

    });

    calendar.render();

    window.addEventListener('sidebar-toggled', () => {
        setTimeout(() => {
            calendar.updateSize(); // This forces FullCalendar to re-layout
        }, 300); // Allow time for sidebar animation
    });

});
