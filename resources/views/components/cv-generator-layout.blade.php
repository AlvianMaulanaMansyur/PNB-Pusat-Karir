{{-- resources/views/components/cv-generator-layout.blade.php --}}

@props(['activeStep', 'currentCv' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">

        <x-cv-generator.step-navigation :activeStep="$activeStep" />

        <div class="flex {{ $activeStep === 'review' ? 'justify-center' : '' }}">
            @if ($activeStep !== 'review')
                <div class="md:w-1/2 p-6">
                    {{ $slot }}
                </div>
            @endif

            <div class="{{ $activeStep === 'review' ? 'w-full max-w-4xl' : 'md:w-1/2' }} p-6">
                @if ($activeStep === 'review')
                    <div class="mb-6 text-center">
                        <h1 class="text-3xl font-bold mb-4">Review CV Anda</h1>
                        {{-- Pastikan $currentCv tidak null sebelum mengakses slug --}}
                        @if ($currentCv)
                            <form action="{{ route('cv.download', $currentCv->slug) }}" method="POST">
                                @csrf

                                <div class="flex justify-center">
                                    {{-- Kembali Button --}}
                                    <div class="mt-6 flex justify-end">
                                        <a href="{{ route('cv.other-experiences', ['slug' => $currentCv->slug]) }}"
                                            class="inline-flex items-center px-6 py-3 bg-white border border-indigo-600 rounded-md font-semibold text-base text-indigo-600 uppercase tracking-widest hover:bg-indigo-50 focus:bg-indigo-50 active:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-4">
                                            Kembali
                                        </a>
                                    </div>

                                    {{-- Save & Continue Button --}}
                                    <div class="mt-6 flex justify-end">
                                        <button type="submit"
                                            class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Download CV as PDF
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @else
                            {{-- Opsional: Tampilkan pesan jika CV tidak ditemukan --}}
                            <p class="text-red-500">Error: CV tidak tersedia untuk diunduh.</p>
                        @endif
                    </div>
                @endif

                <x-cv-generator.cv-preview :currentCv="$currentCv" />
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>
