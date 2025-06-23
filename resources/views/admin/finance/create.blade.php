<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Add {{ ucfirst($type) }}
        </h2>
    </x-slot>

    <div class="py-12 px-6">
        <x-breadcrumbs :items="[
            ['label' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Finance', 'url' => route('admin.finance.index')],
            ['label' => 'Add Transaction']
        ]"
        />
        <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
            {{-- Back button --}}
            <div class="flex mb-4">
                <a href="{{ route('admin.finance.index') }}"
                    class="inline-block px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                    ← Back to Summary
                </a>
            </div>
            <form id="financeCreateForm" action="{{ route('admin.finance.store') }}" method="POST">
                @csrf

                <input type="hidden" name="type" value="{{ $type }}">

                @php
                    $defaultCategories = ['Utility', 'Donation', 'Maintenance', 'Event']; // Define your preset categories
                    $oldCategory = old('category');
                    $isCustomCategory = $oldCategory && !in_array($oldCategory, $defaultCategories);
                @endphp

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Category</label>

                    {{-- Hidden field used for submission --}}
                    <input type="hidden" name="category" id="categoryInput" value="{{ $oldCategory }}">

                    {{-- Dropdown for preset categories --}}
                    <select id="categorySelect"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300bg-white text-gray-900 dark:bg-white dark:text-gray-900 @error('category') border-red-500 @enderror"
                            onchange="handleCategoryChange(this.value)">
                        <option disabled {{ $oldCategory ? '' : 'selected' }}>-- Select Category --</option>
                        @foreach ($defaultCategories as $cat)
                            <option value="{{ $cat }}" {{ $oldCategory === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                        <option value="Other" {{ $isCustomCategory ? 'selected' : '' }}>Other</option>
                    </select>

                    {{-- Custom category input --}}
                    <input type="text" id="otherCategoryInput"
                        placeholder="Enter custom category"
                        class="mt-2 block w-full rounded-md shadow-sm border-gray-300 bg-white text-gray-900 dark:bg-white dark:text-gray-900"
                        style="{{ $isCustomCategory ? '' : 'display:none;' }}"
                        value="{{ $isCustomCategory ? $oldCategory : '' }}">

                    @error('category')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Description</label>
                    <textarea name="description" rows="3"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 bg-white text-gray-900 dark:bg-white dark:text-gray-900 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Amount</label>
                    <div class="flex rounded-md shadow-sm">
                        <span class="inline-flex items-center px-3 bg-gray-100 dark:bg-gray-700 border border-r-0 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-white text-sm rounded-l-md">
                            RM
                        </span>
                        <input type="number" name="amount" step="0.01" value="{{ old('amount') }}"
                            class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border-gray-300 bg-white text-gray-900 dark:bg-white dark:text-gray-900 @error('amount') border-red-500 @enderror">
                    </div>
                    @error('amount')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <div class="mb-6">
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Date</label>
                    <input type="date" name="date" value="{{ old('date') }}"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 bg-white text-gray-900 dark:bg-white dark:text-gray-900 @error('date') border-red-500 @enderror">
                    @error('date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end items-center">

                    <button type="button"
                        onclick="window.confirmModal.open(
                            'Confirm {{ ucfirst($type) }}',
                            'Are you sure you want to add this {{ strtolower($type) }} transaction?',
                            () => document.getElementById('financeCreateForm').submit(),
                            'info'
                        )"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Add {{ ucfirst($type) }}
                    </button>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
    function handleCategoryChange(value) {
        const categoryInput = document.getElementById('categoryInput');
        const otherInput = document.getElementById('otherCategoryInput');

        if (value === 'Other') {
            otherInput.style.display = 'block';
            otherInput.focus();
            categoryInput.value = otherInput.value;
        } else {
            otherInput.style.display = 'none';
            categoryInput.value = value;
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('categorySelect');
        const otherInput = document.getElementById('otherCategoryInput');
        const categoryInput = document.getElementById('categoryInput');

        select.dispatchEvent(new Event('change')); // trigger initial state

        otherInput.addEventListener('input', function () {
            categoryInput.value = otherInput.value;
        });
    });
</script>


