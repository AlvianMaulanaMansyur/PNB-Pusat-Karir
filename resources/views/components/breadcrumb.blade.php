<div class="text-sm text-gray-600 mb-4" aria-label="Breadcrumb">
    <ol class="list-reset flex items-center space-x-2">
        @foreach ($links as $index => $link)
            @if ($index < count($links) - 1)
                <li>
                    <a href="{{ $link['url'] }}" class="text-blue-600 hover:underline">{{ $link['label'] }}</a>
                </li>
                <li>></li>
            @else
                <li class="text-gray-500">{{ $link['label'] }}</li>
            @endif
        @endforeach
    </ol>
</nav>
