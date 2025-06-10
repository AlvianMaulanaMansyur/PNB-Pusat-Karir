@props([
    'current' => 1,
])

@php
    $steps = [
        1 => [
            'label' => 'Pilih Dokumen',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>',
        ],
        2 => [
            'label' => 'Pratinjau Dokumen',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>',
        ],
        3 => [
            'label' => 'Selesai',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7"/>
                    </svg>',
        ],
    ];
@endphp

<div class="max-w-3xl mx-auto mb-8 mt-10">
    <div class="relative flex items-center justify-between">
        {{-- Garis Horizontal --}}
        <div class="absolute top-5 left-0 right-0 h-0.5 z-0">
            <div class="w-full h-full bg-gray-300"></div>
            <div class="absolute top-0 left-0 h-full bg-primaryColor transition-all duration-300"
                style="width: {{ (($current - 1) / (count($steps) - 1)) * 100 }}%;">
            </div>
        </div>

        @foreach ($steps as $step => $data)
            <div class="relative z-10 flex flex-col items-center">
                {{-- Circle --}}
                <div
                    class="flex items-center justify-center w-10 h-10 rounded-full border-2
                    {{ $step <= $current ? 'bg-primaryColor text-white border-primaryColor' : 'bg-white text-gray-600 border-gray-300' }}">
                    {!! $data['icon'] !!}
                </div>
                {{-- Label --}}
                <div
                    class="mt-2 text-sm font-medium text-center whitespace-nowrap
                    {{ $step <= $current ? 'text-primaryColor' : 'text-gray-500' }}">
                    {{ $data['label'] }}
                </div>
            </div>
        @endforeach
    </div>
</div>
