@extends('employer.layouts.app')

@section('content')
@section('content')
{{-- Tampilkan pesan success --}}
@if (session('success'))
<x-alert.session-alert type="success" :message="session('success')" />
@endif

{{-- Tampilkan pesan error umum --}}
@if (session('error'))
<x-alert.session-alert type="error" :message="session('error')" />
@endif

{{-- Tampilkan error validasi (opsional, tampilkan error pertama) --}}
@if ($errors->any())
<x-alert.session-alert type="error" :message="$errors->first()" />
@endif

<div class="bg-white py-10">
    <div class="mx-auto w-full max-w-6xl px-4 md:px-10">
        {{-- Header Halaman --}}
        <div class="mb-10">
            <p class="text-base text-gray-600">Selamat datang di halaman</p>
            <h2 class="text-3xl font-semibold text-gray-800">Detail Kandidat</h2>
            <div class="w-24 h-1 bg-blue-500 rounded mt-2"></div>
            <p class="text-base text-gray-500 mt-2">Informasi lengkap pelamar yang tersedia di sistem.</p>
        </div>

        {{-- Kartu Profil --}}
        <div class="bg-white border border-gray-200 shadow-md rounded-2xl p-8 space-y-8">

            {{-- Atas --}}
            <div class="flex items-center justify-between border-b pb-5">
                <div class="flex items-center gap-6">
                    <img src="{{ $candidate->photo_profile 
                        ? asset('storage/' . $candidate->photo_profile) 
                        : asset('images/profile.png') }}"
                        alt="Foto Kandidat"
                        class="w-20 h-20 rounded-full border shadow object-cover">

                    <div>
                        <h1 class="text-2xl font-semibold text-gray-800">
                            {{ $candidate->first_name }} {{ $candidate->last_name ?? '-' }}
                        </h1>
                        <p class="text-base text-gray-600">{{ $candidate->email }}</p>
                        <p class="text-base text-gray-600">{{ $candidate->phone ?? '-' }}</p>
                    </div>
                </div>

                <a href="{{ route('employer.temukan-kandidat') }}?{{ http_build_query(['skills' => request('skills')]) }}"
                    class="text-base text-blue-600 hover:underline font-medium">
                    ← Kembali
                </a>
            </div>

            {{-- Informasi Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-base text-gray-700">
                @php
                $fields = [
                'Negara' => $candidate->country,
                'Kota' => $candidate->city,
                'Pendidikan Terakhir' => $candidate->highest_education,
                'Pengalaman' => $candidate->years_of_experience . ' tahun',
                'Industri Terakhir' => $candidate->current_or_previous_industry,
                'Posisi Terakhir' => $candidate->current_or_previous_position,
                'Jenis Pekerjaan yang Dicari' => $candidate->current_or_previous_job_type,
                'Ketersediaan' => $candidate->availability,
                ];
                @endphp

                @foreach($fields as $label => $value)
                <div>
                    <p class="text-sm text-gray-500">{{ $label }}</p>
                    <p class="mt-1 font-medium text-gray-800">{{ $value ?? '-' }}</p>
                </div>
                @endforeach
            </div>

            {{-- Ringkasan Profil --}}
            @if (!empty($candidate->summary))
            <div>
                <p class="text-sm text-gray-500 mb-1">Ringkasan Profil</p>
                <div class="bg-gray-50 border border-gray-200 p-4 rounded-md text-base shadow-inner whitespace-pre-line">
                    {{ $candidate->summary }}
                </div>
            </div>
            @endif


            <!-- {{-- Sosial --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">LinkedIn</p>
                    @if (!empty($candidate->linkedin))
                    <a href="{{ $candidate->linkedin }}" target="_blank" class="text-base text-blue-600 hover:underline">
                        {{ $candidate->linkedin }}
                    </a>
                    @else
                    <p class="text-base text-gray-400 italic">Tidak tersedia</p>
                    @endif
                </div>
                <div>
                    <p class="text-sm text-gray-500">Website</p>
                    @if (!empty($candidate->website))
                    <a href="{{ $candidate->website }}" target="_blank" class="text-base text-blue-600 hover:underline">
                        {{ $candidate->website }}
                    </a>
                    @else
                    <p class="text-base text-gray-400 italic">Tidak tersedia</p>
                    @endif
                </div>
            </div> -->

            {{-- Skills --}}
            @if (!empty($candidate->skills))
            <div>
                <p class="text-sm text-gray-500 mb-1">Skills</p>
                <div class="flex flex-wrap gap-2">
                    @foreach (explode(',', $candidate->skills) as $skill)
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium shadow-sm">
                        {{ trim($skill) }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endif

            @if ($educations->count())
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Riwayat Pendidikan</h3>
                <ul class="space-y-4">
                    @foreach ($educations as $edu)
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

            <h3 class="text-lg font-semibold mb-2">Pengalaman Kerja</h3>
            @forelse($workExperiences as $exp)
            <div class="mb-4">
                <p class="font-medium">{{ $exp->position }} di {{ $exp->company }}</p>
                <p class="text-sm text-gray-600">
                    {{ \Carbon\Carbon::parse($exp->start_date)->translatedFormat('F Y') }}
                    -
                    {{ $exp->is_current ? 'Sekarang' : \Carbon\Carbon::parse($exp->end_date)->translatedFormat('F Y') }}
                </p>
                <p class="text-sm text-gray-700">{{ $exp->description }}</p>
            </div>
            @empty
            <p class="text-sm text-gray-500">Belum ada pengalaman kerja.</p>
            @endforelse

            {{-- Form Undangan --}}
            @if($jobListings && count($jobListings) > 0)
            <div class="pt-6 border-t">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Undang Kandidat ke Lowongan</h3>
                <form method="POST" id="invite-form"
                    action="{{ route('employer.send-invitation', ['jobId' => $jobListings->first()->id ?? 0, 'userId' => $candidate->user_id]) }}">
                    @csrf

                    <div class="mb-4">
                        <label for="job_id" class="block text-sm font-medium text-gray-700">Lowongan</label>
                        <select name="job_id" id="job_id" required class="w-full mt-1 p-2 border rounded"
                            onchange="updateInviteAction(this.value, {{ $candidate->user_id }})">
                            @forelse ($jobListings as $job)
                            <option value="{{ $job->id }}">{{ $job->nama_lowongan }}</option>
                            @empty
                            <option disabled>Tidak ada lowongan tersedia</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="text-right">
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition">
                            Kirim Undangan
                        </button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
<script>
    function updateInviteAction(jobId, userId) {
        const form = document.getElementById('invite-form');
        form.action = `/employer/send-invitation/${jobId}/${userId}`;
    }
</script>
@endsection