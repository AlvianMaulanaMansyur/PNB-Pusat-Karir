@props(['value', 'hint' => null])

<label {{ $attributes->merge(['class' => 'flex justify-between items-center font-medium text-sm text-gray-700']) }}>
    <span>
        {{ $value ?? $slot }}
        <span class="text-red-500"> *</span>
    </span>

    @if ($hint)
        <div class="relative group inline-block cursor-pointer ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
            </svg>
            <div
                class="absolute bottom-full mb-1 right-0 transform hidden group-hover:block bg-gray-700 text-white text-xs rounded py-1 px-2 w-max max-w-xs z-10">
                {{ $hint }}
            </div>
        </div>
    @endif
</label>
