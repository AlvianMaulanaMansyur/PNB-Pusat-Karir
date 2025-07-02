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
        <!-- Header -->
        <div class="flex justify-between items-center mb-8 border-b pb-4 border-gray-200">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Detail Pelamar</h1>
                <p class="text-sm text-gray-500">Informasi lengkap mengenai kandidat</p>
            </div>
            <a href="{{ route('employer.pelamar-lowongan', $application->job->employer->slug) }}"
                class="inline-flex items-center text-sm text-blue-600 hover:underline font-medium">
                ← Kembali ke Daftar Pelamar
            </a>
        </div>

        <!-- Foto dan Identitas -->
        <div class="flex items-center gap-6 mb-6">
            @if ($application->employee->photo_profile)
                <img src="{{ asset('storage/' . $application->employee->photo_profile) }}"
                    alt="Foto Pelamar"
                    class="w-24 h-24 rounded-full object-cover border shadow">
            @else
                <img src="{{ asset('images/profile.png') }}"
                    alt="Foto Default"
                    class="w-24 h-24 rounded-full object-cover border shadow">
            @endif
            <div>
                <p class="text-xl font-semibold text-gray-800">
                    {{ $application->employee->first_name }} {{ $application->employee->last_name }}
                </p>
                <p class="text-sm text-gray-500">{{ $application->employee->email }}</p>
                <p class="text-sm text-gray-500">{{ $application->employee->phone ?? '-' }}</p>
            </div>
        </div>

        <!-- Detail Tambahan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm text-gray-700 mb-6">
            <div>
                <p class="text-gray-500">Tanggal Melamar</p>
                <p class="mt-1">{{ $application->applied_at->format('d M Y H:i') }}</p>
            </div>
            <div>
                <p class="text-gray-500">Status Lamaran</p>
                <span class="inline-block mt-1 bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs capitalize">
                    {{ $application->status }}
                </span>
            </div>
            @if ($application->interview_date)
                <div>
                    <p class="text-gray-500">Tanggal Wawancara</p>
                    <p class="mt-1">{{ $application->interview_date->format('d M Y H:i') }}</p>
                </div>
            @endif

            <div>
                <p class="text-gray-500">Pendidikan Terakhir</p>
                <p class="mt-1">{{ $application->employee->highest_education ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Pengalaman Kerja</p>
                <p class="mt-1">{{ $application->employee->years_of_experience ?? '-' }} tahun</p>
            </div>
            <div>
                <p class="text-gray-500">Industri Terakhir</p>
                <p class="mt-1">{{ $application->employee->current_or_previous_industry ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Posisi Terakhir</p>
                <p class="mt-1">{{ $application->employee->current_or_previous_position ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Jenis Pekerjaan yang Dicari</p>
                <p class="mt-1">{{ $application->employee->current_or_previous_job_type ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Negara</p>
                <p class="mt-1">{{ $application->employee->country ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Kota</p>
                <p class="mt-1">{{ $application->employee->city ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Ketersediaan Kerja</p>
                <p class="mt-1">{{ $application->employee->availability ?? '-' }}</p>
            </div>
        </div>

        <!-- Cover Letter -->
        <div class="mb-6">
            <p class="text-gray-500 mb-1">Cover Letter</p>
            <div class="bg-gray-50 border border-gray-200 p-4 rounded-md text-sm max-h-52 overflow-y-auto whitespace-pre-line shadow-inner">
                {{ $application->cover_letter ?? '-' }}
            </div>
        </div>

        <!-- CV -->
        @if ($application->cv_file)
            <div class="mb-6">
                <p class="text-gray-500 mb-1">CV</p>
                <a href="{{ asset('storage/' . $application->cv_file) }}" target="_blank"
                   class="text-blue-600 hover:underline text-sm">📄 Lihat CV</a>
            </div>
        @endif

        <!-- Skills -->
        @if ($application->employee->skills && count($application->employee->skills))
            <div>
                <p class="text-gray-500 mb-1">Skills</p>
                <div class="flex flex-wrap gap-2">
                    @foreach ($application->employee->skills as $skill)
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">
                            {{ $skill->nama }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
