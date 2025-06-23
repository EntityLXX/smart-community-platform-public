@props(['items'])

<nav class="text-sm text-gray-600 dark:text-gray-300 mb-4" aria-label="Breadcrumb">
    <ol class="list-none p-0 inline-flex items-center space-x-1">
        <li>
            <a href="{{ route('dashboard') }}" class="hover:underline text-blue-600 dark:text-blue-400">Home</a>
        </li>
        @foreach ($items as $item)
            <li class="mx-1">/</li>
            <li>
                @if (isset($item['url']))
                    <a href="{{ $item['url'] }}" class="hover:underline text-blue-600 dark:text-blue-400">
                        {{ $item['label'] }}
                    </a>
                @else
                    <span class="text-gray-700 dark:text-white">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
