<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Transaction
        </h2>
    </x-slot>

    <div class="py-12 px-6">
        <x-breadcrumbs :items="[
            ['label' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Finance', 'url' => route('admin.finance.index')],
            ['label' => 'Edit Transaction']
        ]"
        />

        <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
            
            {{-- Back Button --}}
            <a href="{{ route('admin.finance.history') }}"
               class="inline-block mb-4 text-sm text-blue-600 hover:underline">&larr; Back to History</a>

            <form method="POST" id="financeEditForm" action="{{ route('admin.finance.update', $transaction->id) }}">
                @csrf
                @method('PUT')

                {{-- Type --}}
                <div class="mb-4">
                    <label class="block font-semibold text-sm text-gray-700 dark:text-gray-200 mb-1">
                        Type
                    </label>
                    <select name="type" class="w-full rounded border-gray-300 bg-white text-gray-900 dark:bg-white dark:text-gray-900">
                        <option value="income" {{ $transaction->type === 'income' ? 'selected' : '' }}>Income</option>
                        <option value="expense" {{ $transaction->type === 'expense' ? 'selected' : '' }}>Expense</option>
                    </select>
                </div>

                {{-- Category --}}
                @php
                    $defaultCategories = ['Utility', 'Donation', 'Maintenance', 'Event']; // Add your categories
                    $currentCategory = old('category', $transaction->category);
                    $isCustomCategory = !in_array($currentCategory, $defaultCategories);
                @endphp

                <div class="mb-4">
                    <label class="block font-semibold text-sm text-gray-700 dark:text-gray-200 mb-1">Category</label>

                    {{-- Hidden final category field --}}
                    <input type="hidden" name="category" id="categoryInput" value="{{ old('category', $transaction->category) }}">

                    {{-- Select dropdown --}}
                    <select id="categorySelect"
                        class="w-full rounded border-gray-300 bg-white text-gray-900 dark:bg-white dark:text-gray-900"
                        onchange="handleCategoryChange(this.value)">
                        @foreach ($defaultCategories as $cat)
                            <option value="{{ $cat }}" {{ $currentCategory === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                        <option value="Other" {{ $isCustomCategory ? 'selected' : '' }}>Other</option>
                    </select>

                    {{-- Text input for custom category --}}
                    <input type="text" id="otherCategoryInput" placeholder="Enter custom category"
                        class="mt-3 w-full rounded border-gray-300 bg-white text-gray-900 dark:bg-white dark:text-gray-900"
                        value="{{ $isCustomCategory ? $currentCategory : '' }}"
                        style="{{ $isCustomCategory ? '' : 'display: none;' }}">
                </div>



                {{-- Description --}}
                <div class="mb-4">
                    <label class="block font-semibold text-sm text-gray-700 dark:text-gray-200 mb-1">
                        Description
                    </label>
                    <textarea name="description" rows="3"
                              class="w-full rounded border-gray-300 bg-white text-gray-900 dark:bg-white dark:text-gray-900"
                              required>{{ old('description', $transaction->description) }}</textarea>
                </div>

                {{-- Amount --}}
                <div class="mb-4">
                    <label class="block font-semibold text-sm text-gray-700 dark:text-gray-200 mb-1">
                        Amount
                    </label>
                    <div class="flex rounded-md shadow-sm">
                        <span class="inline-flex items-center px-3 bg-gray-100 dark:bg-gray-700 border border-r-0 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-white text-sm rounded-l-md">
                            RM
                        </span>
                        <input type="number" step="0.01" name="amount" value="{{ old('amount', $transaction->amount) }}"
                            class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border-gray-300 bg-white text-gray-900 dark:bg-white dark:text-gray-900 @error('amount') border-red-500 @enderror" required>
                    </div>
                </div>


                {{-- Date --}}
                <div class="mb-4">
                    <label class="block font-semibold text-sm text-gray-700 dark:text-gray-200 mb-1">
                        Date
                    </label>
                    <input type="date" name="date" value="{{ old('date',\Carbon\Carbon::parse($transaction->date)->format('Y-m-d')) }}"
                           class="w-full rounded border-gray-300 bg-white text-gray-900 dark:bg-white dark:text-gray-900" required>
                </div>

                {{-- Submit --}}
                <div class="flex justify-end">
                    <button type="button"
                            onclick="window.confirmModal.open(
                                'Confirm Update',
                                'Are you sure you want to update this transaction?',
                                () => document.getElementById('financeEditForm').submit(),
                                'warning'
                            )"
                            class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                        💾 Update Transaction
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
            categoryInput.value = otherInput.value; // fallback until typing
        } else {
            otherInput.style.display = 'none';
            categoryInput.value = value;
        }
    }

    // Keep the hidden field updated when typing in "Other"
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('categorySelect');
        const otherInput = document.getElementById('otherCategoryInput');
        const categoryInput = document.getElementById('categoryInput');

        select.dispatchEvent(new Event('change')); // init state

        otherInput.addEventListener('input', function () {
            categoryInput.value = otherInput.value;
        });
    });
</script>
