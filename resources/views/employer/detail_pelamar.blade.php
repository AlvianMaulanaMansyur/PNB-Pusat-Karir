@extends('employer.layouts.app')

@section('content')
{{-- Header dan Petunjuk --}}
<div class="bg-white py-10">
    <div class="flex flex-col w-full lg:w-2/3 text-left mx-4 md:mx-10 lg:mx-20 lg:ml-28 mb-10">
        <p class="text-md text-gray-600">Selamat datang di halaman</p>
        <p class="font-semibold text-2xl 2xl:text-3xl my-2 text-gray-800">Detail Pelamar</p>
        <div class="w-28 h-1 bg-blue-500 rounded mb-4"></div>
        <p class="text-gray-600 text-sm mb-3">
            Lihat informasi lengkap pelamar yang telah mengajukan lamaran pada lowongan Anda.
        </p>

        <div class="flex items-start space-x-4 border-l-4 border-blue-600 bg-blue-50 rounded-md p-5 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600 flex-shrink-0" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <h3 class="text-blue-700 font-semibold text-lg mb-1">Petunjuk Penggunaan</h3>
                <p class="text-blue-800 text-sm leading-relaxed max-w-prose">
                    Anda dapat meninjau detail pelamar seperti identitas, kontak, status lamaran, hingga dokumen yang mereka lampirkan. Gunakan informasi ini untuk memproses pelamar lebih lanjut.
                </p>
            </div>
        </div>
    </div>

    {{-- Konten Utama --}}
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-md">

        {{-- Atas --}}
        <div class="flex items-center justify-between border-b pb-5 mb-8">
            <div class="flex items-center gap-6">
                <img src="{{ $application->employee->photo_profile 
                ? asset('storage/' . $application->employee->photo_profile) 
                : asset('images/profile.png') }}"
                    alt="Foto Pelamar"
                    class="w-20 h-20 rounded-full border shadow object-cover">

                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">
                        {{ $application->employee->first_name }} {{ $application->employee->last_name }}
                    </h1>
                    <p class="text-base text-gray-600">{{ $application->employee->email }}</p>
                    <p class="text-base text-gray-600">{{ $application->employee->phone ?? '-' }}</p>
                </div>
            </div>

            <a href="{{ route('employer.pelamar-lowongan', $application->job->employer->slug) }}" class="text-base text-blue-600 hover:underline font-medium">
                ← Kembali
            </a>
        </div>

        {{-- Informasi Pelamar --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-base text-gray-700 mb-8">
            @php
            $fields = [
            'Tanggal Melamar' => $application->applied_at->format('d M Y H:i'),
            'Status Lamaran' => ucfirst($application->status),
            'Pendidikan Terakhir' => $application->employee->highest_education,
            'Pengalaman' => $application->employee->years_of_experience . ' tahun',
            'Industri Terakhir' => $application->employee->current_or_previous_industry,
            'Posisi Terakhir' => $application->employee->current_or_previous_position,
            'Jenis Pekerjaan yang Dicari' => $application->employee->current_or_previous_job_type,
            'Ketersediaan' => $application->employee->availability,
            'Negara' => $application->employee->country,
            'Kota' => $application->employee->city,
            ];
            @endphp

            @foreach($fields as $label => $value)
            <div>
                <p class="text-sm text-gray-500">{{ $label }}</p>
                <p class="mt-1 font-medium text-gray-800">{{ $value ?? '-' }}</p>
            </div>
            @endforeach
        </div>

        {{-- Ringkasan --}}
        @if ($application->employee->summary)
        <div class="mb-6">
            <p class="text-sm text-gray-500 mb-1">Ringkasan Profil</p>
            <div class="bg-gray-50 border border-gray-200 p-4 rounded-md text-base shadow-inner whitespace-pre-line">
                {{ $application->employee->summary }}
            </div>
        </div>
        @endif

        {{-- Sosial --}}
        <!-- <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
        <div>
            <p class="text-sm text-gray-500">LinkedIn</p>
            @if ($application->employee->linkedin)
            <a href="{{ $application->employee->linkedin }}" target="_blank" class="text-base text-blue-600 hover:underline">
                {{ $application->employee->linkedin }}
            </a>
            @else
            <p class="text-base text-gray-400 italic">Tidak tersedia</p>
            @endif
        </div>
        <div>
            <p class="text-sm text-gray-500">Website</p>
            @if ($application->employee->website)
            <a href="{{ $application->employee->website }}" target="_blank" class="text-base text-blue-600 hover:underline">
                {{ $application->employee->website }}
            </a>
            @else
            <p class="text-base text-gray-400 italic">Tidak tersedia</p>
            @endif
        </div>
    </div> -->

        {{-- Skills --}}
        @if ($application->employee->skills && count($application->employee->skills))
        <div class="mb-6">
            <p class="text-sm text-gray-500 mb-1">Skills</p>
            <div class="flex flex-wrap gap-2">
                @foreach ($application->employee->skills as $skill)
                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium shadow-sm">
                    {{ $skill->name }}
                </span>
                @endforeach
            </div>
        </div>
        @endif



        {{-- Pendidikan --}}
        @if ($application->employee->educations && $application->employee->educations->count())
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Riwayat Pendidikan</h3>
            <ul class="space-y-4">
                @foreach ($application->employee->educations as $edu)
                <li class="border-l-4 border-blue-500 pl-4">
                    <p class="text-base font-medium text-gray-900">{{ $edu->institution }}</p>
                    <p class="text-sm text-gray-600">
                        {{ $edu->degrees ?? '-' }} - {{ $edu->dicipline ?? '-' }}<br>
                        Selesai: {{ $edu->end_date ? \Carbon\Carbon::parse($edu->end_date)->format('M Y') : '-' }}
                    </p>
                    @if ($edu->description)
                    <p class="text-sm text-gray-500 mt-1">{{ $edu->description }}</p>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Cover Letter --}}
        @if ($application->cover_letter)
        <div class="mb-8">
            <p class="text-sm text-gray-500 mb-1">Cover Letter</p>
            <div class="bg-gray-50 border border-gray-200 p-4 rounded-md text-base whitespace-pre-line shadow-inner">
                {{ $application->cover_letter }}
            </div>
        </div>
        @endif

        {{-- CV --}}
        @if ($application->cv_file)
        <div class="mb-8">
            <p class="text-sm text-gray-500 mb-1">CV</p>
            <a href="{{ route('cv.download', basename($application->cv_file)) }}" target="_blank" class="text-base text-blue-600 hover:underline">
                📄 Lihat CV
            </a>
        </div>
        @endif

        <h3 class="text-lg font-semibold mb-4">Sertifikat / Portofolio</h3>
        @forelse ($certificates as $cert)
        <div class="mb-4">
            <p class="font-medium text-gray-800">{{ $cert->file_name }}</p>
            <a href="{{ asset('storage/' . $cert->portofolio_path) }}"
                target="_blank"
                class="text-blue-600 hover:underline text-sm">
                Lihat Sertifikat
            </a>
        </div>
        @empty
        <p class="text-sm text-gray-500">Tidak ada sertifikat yang diunggah.</p>
        @endforelse


    </div>



    <!-- Tombol Kembali ke Atas -->
    <button id="backToTop" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="hidden fixed bottom-6 right-6 z-50 bg-gradient-to-tr from-blue-600 to-indigo-600 text-white p-3 rounded-full shadow-xl hover:scale-110 hover:shadow-2xl transition-all duration-300"
        title="Kembali ke atas" aria-label="Kembali ke atas">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
        </svg>
    </button>

    <script>
        // Tampilkan tombol setelah scroll 300px
        window.addEventListener('scroll', () => {
            const btn = document.getElementById('backToTop');
            btn.style.display = window.scrollY > 300 ? 'flex' : 'none';
        });
    </script>
    @endsection