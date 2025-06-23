<x-app-layout>
    <x-slot name="header">
        <div class="relative flex items-center gap-4">
            <!-- Icon Circle with subtle outlined background -->
            <div class="relative z-10">
                <!-- Outer outline ring -->
                <div class="absolute inset-0 scale-110 rounded-full ring-2 ring-green-600 dark:ring-green-500"></div>

                <!-- Main Icon Circle -->
                <div
                    class="w-14 h-14 bg-green-600 dark:bg-green-500 rounded-full flex items-center justify-center shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-7 h-7 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 
                          1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 
                          12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 
                          0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 
                          0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>

            <!-- Header Text -->
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Financial Management
            </h2>
        </div>
    </x-slot>


    <div class="py-6 px-6">
        <x-breadcrumbs :items="[
        ['label' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Finance']
    ]" />
        <div class="max-w-7xl mx-auto space-y-10">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Chart & Summary Section (side-by-side) --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Chart Container --}}
                <div class="relative ring-2 ring-green-500 rounded-3xl lg:col-span-2 h-fit self-start">
                    <div class="absolute inset-0 translate-x-2 translate-y-2 bg-green-500 rounded-3xl z-0"></div>
                    <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 z-10">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Financial Overview</h3>
                            <div class="flex gap-2">
                                <button onclick="toggleChart('pie')"
                                    class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                                    Pie Chart
                                </button>
                                <button onclick="toggleChart('bar')"
                                    class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                                    Bar Chart
                                </button>
                            </div>
                        </div>

                        <div class="w-full">
                            <canvas id="financeChart"
                                class="w-full max-w-md max-h-[300px] mx-auto dark:text-white"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Summary Container --}}
                <div class="relative ring-2 ring-green-500 rounded-3xl h-fit self-start">
                    <div class="absolute inset-0 translate-x-2 translate-y-2 bg-green-500 rounded-3xl z-0"></div>
                    <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 space-y-4 z-10">
                        {{-- Add Income / Expense Buttons --}}
                        <div class="flex justify-end gap-4 mb-6">
                            <a href="{{ route('admin.finance.create', ['type' => 'income']) }}"
                                class="bg-green-600 text-white px-4 py-2 flex gap-2 rounded hover:bg-green-700 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Add Income
                            </a>
                            <a href="{{ route('admin.finance.create', ['type' => 'expense']) }}"
                                class="bg-red-600 text-white px-4 py-2 flex gap-2 rounded hover:bg-red-700 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                </svg>
                                Add Expense
                            </a>
                        </div>
                        <div class="bg-green-100 dark:bg-green-900 rounded shadow p-4">
                            <p class="text-green-700 dark:text-green-300 text-sm">Total Income</p>
                            <p class="text-xl font-bold text-green-900 dark:text-white">RM
                                {{ number_format($income, 2) }}
                            </p>
                        </div>
                        <div class="bg-red-100 dark:bg-red-900 rounded shadow p-4">
                            <p class="text-red-700 dark:text-red-300 text-sm">Total Expense</p>
                            <p class="text-xl font-bold text-red-900 dark:text-white">RM
                                {{ number_format($expense, 2) }}
                            </p>
                        </div>
                        <div class="bg-gray-300 dark:bg-gray-500 rounded shadow p-4">
                            <p class="text-gray-600 dark:text-gray-300 text-sm">Total Balance</p>
                            <p class="text-xl font-bold text-gray-800 dark:text-white">RM
                                {{ number_format($balance, 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Transactions --}}
            <div class="relative ring-2 ring-green-500 rounded-3xl lg:col-span-2 h-fit self-start">
                <div class="absolute inset-0 translate-x-2 translate-y-2 bg-green-500 rounded-3xl z-0"></div>
                <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 z-10">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Recent Transactions</h3>
                        <a href="{{ route('admin.finance.history') }}"
                            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">View More</a>
                    </div>

                    <div class="bg-white dark:bg-gray-800 shadow rounded overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left font-medium">Date</th>
                                    <th class="px-4 py-2 text-left font-medium">Type</th>
                                    <th class="px-4 py-2 text-left font-medium">Category</th>
                                    <th class="px-4 py-2 text-left font-medium">Description</th>
                                    <th class="px-4 py-2 text-left font-medium">Amount (RM)</th>
                                </tr>
                            </thead>
                            <tbody
                                class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($transactions as $tx)
                                    <tr>
                                        <td class="px-4 py-2">{{ $tx->date->format('Y-m-d') }}</td>
                                        <td class="px-4 py-2 capitalize">
                                            <span
                                                class="px-2 py-1 rounded-full text-xs {{ $tx->type === 'income' ? 'bg-green-200 text-green-900 dark:bg-green-200 dark:text-green-900' : 'bg-red-200 text-red-900 dark:bg-red-200 dark:text-red-900' }}">
                                                {{ $tx->type }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2">{{ $tx->category }}</td>
                                        <td class="px-4 py-2">{{ $tx->description }}</td>
                                        <td class="px-4 py-2">RM {{ number_format($tx->amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center px-4 py-2 text-gray-500 dark:text-gray-300">No transactions
                                            found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Chart.js Script --}}
    {{-- Chart.js Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let chartInstance = null;

        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('financeChart').getContext('2d');

            // Default chart on load
            renderChart('pie', ctx);
        });

        function toggleChart(type) {
            const ctx = document.getElementById('financeChart').getContext('2d');

            if (chartInstance) {
                chartInstance.destroy(); // Destroy existing chart before rendering a new one
            }

            renderChart(type, ctx);
        }

        function renderChart(type, ctx) {
            if (type === 'pie') {
                chartInstance = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Income', 'Expense'],
                        datasets: [{
                            data: [{{ $income }}, {{ $expense }}],
                            backgroundColor: ['#16a34a', '#dc2626'],
                            borderColor: ['#10b981', '#f87171'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: document.documentElement.classList.contains('dark') ? '#fff' : '#000'
                                }
                            },
                            title: {
                                display: true,
                                text: 'Current Financial Breakdown',
                                color: document.documentElement.classList.contains('dark') ? '#fff' : '#000'
                            }
                        }
                    }
                });
            } else if (type === 'bar') {
                chartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($categoryTotals->pluck('category')) !!},
                        datasets: [{
                            label: 'Total per Category (RM)',
                            data: {!! json_encode($categoryTotals->pluck('total')) !!},
                            backgroundColor: '#3b82f6'
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Category-wise Totals',
                                color: document.documentElement.classList.contains('dark') ? '#fff' : '#000'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: document.documentElement.classList.contains('dark') ? '#fff' : '#000'
                                }
                            },
                            x: {
                                ticks: {
                                    color: document.documentElement.classList.contains('dark') ? '#fff' : '#000'
                                }
                            }
                        }
                    }
                });
            }
        }
    </script>


</x-app-layout>