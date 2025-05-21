@props(['label'])

<div x-data="{ open: false }" class="relative inline-block text-left">
    <button @click="open = !open"
        class="font-semibold flex">
        {{ $label }}
        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div x-show="open" @click.away="open = false"
        class="absolute mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
        <div class="py-1 text-gray-700">
            {{ $slot }}
        </div>
    </div>
</div>
