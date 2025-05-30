@props([
    'name',
])

<div x-data="{ show: false }" class="relative">
    <input
        :type="show ? 'text' : 'password'"
        name = "{{ $name }}"
        {{ $attributes->merge([
            'class' => 'w-full pr-10 border-gray-700 focus:border-[#7397EA] focus:ring-[#7397EA] rounded-md shadow-sm',
        ]) }}
    />

    <!-- Ikon mata di dalam input -->
    <button
        type="button"
        @click="show = !show"
        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-600"
        tabindex="-1"
    >
        <!-- Mata tertutup -->
        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943
                  9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        </svg>

        <!-- Mata terbuka -->
        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477
                  0-8.268-2.943-9.542-7a9.97 9.97 0
                  012.457-4.134M6.18 6.18A9.954 9.954 0
                  0112 5c4.478 0 8.268 2.943
                  9.542 7a9.964 9.964 0
                  01-4.068 5.317M6.18 6.18l11.64 11.64"/>
        </svg>
    </button>
</div>

