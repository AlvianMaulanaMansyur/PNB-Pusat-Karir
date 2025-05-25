@props(['label'])

<div x-data="{ open: false }" class="relative inline-block text-left">
    <button @click="open = !open"
        class="font-semibold flex items-center space-x-2 hover:underline underline-offset-8 decoration-6 decoration-[#5A4FF3] transition-all hover:text-[#5A4FF3]">
        <span>{{ $label }}</span>

        <!-- Ikon panah bawah jika tertutup -->
        <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>

        <!-- Ikon panah atas jika terbuka -->
        <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
        </svg>
    </button>

    <div x-show="open" @click.away="open = false"
        class="absolute right-0 mt-2 min-w-max px-10 py-4 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-50 z-50 text-md">
        <div class="text-gray-700">
            {{ $slot }}
        </div>
    </div>
</div>
