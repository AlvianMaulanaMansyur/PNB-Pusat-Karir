@props(['activeStep' => 'informasi-pribadi'])

@php
    // Langkah-langkah dan slug URL-nya
    $steps = [
        ['label' => 'Informasi<br>Pribadi', 'slug' => 'informasi-pribadi', 'icon' => 'M7 21h10a2 2 0 002-2V9a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.414-1.414A1 1 0 0013.586 4H10.414a1 1 0 00-.707.293L8.293 5.707A1 1 0 017.586 6H6a2 2 0 00-2 2v11a2 2 0 002 2zM15 13.5c0 .276-.112.534-.293.72l-2 2a1 1 0 01-1.414 0l-2-2a1 1 0 010-1.414l2-2a1 1 0 011.414 0l2 2c.181.186.293.444.293.72zM10.293 11.293a1 1 0 011.414 0L13 12.586l1.293-1.293a1 1 0 011.414 1.414l-2 2a1 1 0 01-1.414 0l-2-2a1 1 0 010-1.414z'], // Contoh ikon folder upload
        ['label' => 'Profesional', 'slug' => 'profesional', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'], // Contoh ikon dokumen
        ['label' => 'Pendidikan', 'slug' => 'pendidikan', 'icon' => 'M12 14c2.761 0 5-2.239 5-5S14.761 4 12 4 7 6.239 7 9s2.239 5 5 5zM12 14a8 8 0 00-8 8h16a8 8 0 00-8-8z'], // Contoh ikon pendidikan (topi wisuda atau buku)
        ['label' => 'Organisasi', 'slug' => 'organisasi', 'icon' => 'M4 17V7a2 2 0 012-2h12a2 2 0 012 2v10m-4 4h-4m2 0v-4m-7 0h7a2 2 0 01-2 2H6a2 2 0 01-2-2z'], // Contoh ikon organisasi
        ['label' => 'Lainnya', 'slug' => 'lainnya', 'icon' => 'M5 12h14M12 5l7 7-7 7'], // Contoh ikon lainnya (panah kanan)
        ['label' => 'Review', 'slug' => 'review', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'], // Contoh ikon review (checklist)
    ];
@endphp

<div class="flex justify-between max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8 items-center">
    @foreach ($steps as $index => $step)
        @php
            $isActive = $step['slug'] === $activeStep;
            $isCompleted = array_search($activeStep, array_column($steps, 'slug')) > $index;
            $iconColor = $isActive || $isCompleted ? 'text-white' : 'text-gray-600';
            $bgColor = $isActive || $isCompleted ? 'bg-indigo-600' : 'bg-gray-200';
            $url = url("/cv-generator/{$step['slug']}");
        @endphp

        <a href="{{ $url }}" class="flex flex-col items-center text-center group relative z-10">
            <div
                class="w-16 h-16 flex items-center justify-center rounded-full {{ $bgColor }} transition-all duration-300 ease-in-out
                {{ $isActive ? 'shadow-lg ring-4 ring-indigo-300' : '' }}
                {{ $isCompleted ? 'bg-indigo-600' : 'bg-gray-200' }}">
                <svg class="w-8 h-8 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}"></path>
                </svg>
            </div>
           
        </a>
        {{-- <div>
            <span class="mt-3 text-sm font-semibold whitespace-nowrap
                {{ $isActive ? 'text-blue-600' : 'text-gray-700' }}
                group-hover:text-blue-700 transition-colors duration-200"
            >{!! $step['label'] !!}</span>
        </div> --}}

        @if (!$loop->last)
            {{-- Garis penghubung --}}
            <div class="flex-grow h-1 bg-gray-200 relative -ml-8 -mr-8 z-0">
                <div class="absolute inset-y-0 left-0 {{ $isCompleted ? 'bg-indigo-600' : '' }}"
                    style="width: {{ $isCompleted ? '100%' : '0%' }}; transition: width 0.3s ease-in-out;"></div>
            </div>
        @endif
    @endforeach
</div>