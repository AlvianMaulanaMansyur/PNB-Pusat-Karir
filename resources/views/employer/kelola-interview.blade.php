@extends('employer.layouts.app')

@section('content')

<div class="flex justify-start">
    <div class="flex flex-col w-full lg:w-2/3 text-left mx-4 md:mx-10 lg:mx-20 lg:ml-28">
        <p class="text-md text-gray-600">Selamat datang di halaman</p>
        <p class="font-semibold text-2xl 2xl:text-3xl my-2 text-gray-800">Manajemen Interview Pelamar</p>
        <div class="w-28 h-1 bg-blue-500 rounded mb-4"></div>
        <p class="text-gray-600 text-sm mb-3">Kelola proses interview pelamar yang telah mendaftar ke lowongan pekerjaan Anda.</p>

        <a href="{{ route('employer.dashboard') }}"
            class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium mt-2 transition duration-300 mb-4">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Halaman Utama
        </a>

        @if (session('success'))
            <x-alert.session-alert type="success" :message="session('success')" />
        @endif

        @if (session('error'))
            <x-alert.session-alert type="error" :message="session('error')" />
        @endif

        @if ($errors->any())
            <x-alert.session-alert type="error" :message="$errors->first()" />
        @endif

        {{-- Loop berdasarkan lowongan --}}
        @forelse ($applications as $jobId => $jobApps)
            @php $job = $jobApps->first()->job; @endphp

            <div class="mt-10 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">
                    Lowongan: {{ $job->nama_lowongan }} ({{ $job->posisi }}) - {{ $jobApps->count() }} Pelamar
                </h2>

                <div class="overflow-x-auto bg-white shadow rounded-lg">
                    <table class="min-w-full text-sm text-left text-gray-700">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-6 py-3">No</th>
                                <th class="px-6 py-3">Nama Pelamar</th>
                                <th class="px-6 py-3">Tanggal Interview</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($jobApps as $app)
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="px-6 py-4">{{ $no++ }}</td>
                                    <td class="px-6 py-4">{{ $app->employee->first_name }} {{ $app->employee->last_name }}</td>
                                    <td class="px-6 py-4">
                                        @if ($app->interview_date)
                                            {{ \Carbon\Carbon::parse($app->interview_date)->translatedFormat('d M Y, H:i') }}
                                        @else
                                            <span class="italic text-gray-400">Belum dijadwalkan</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs font-semibold rounded bg-green-300 text-green-800">Dijadwalkan</span>
                                    </td>
                                    <td class="px-6 py-4 space-x-3">
                                        {{-- Tombol Detail --}}
                                        <button onclick="document.getElementById('modal-detail-{{ $app->slug }}').classList.remove('hidden')" class="text-blue-600 hover:underline text-sm">Detail</button>

                                        {{-- Modal Detail --}}
                                        <div id="modal-detail-{{ $app->slug }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                                            <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
                                                <button onclick="document.getElementById('modal-detail-{{ $app->slug }}').classList.add('hidden')" class="absolute top-2 right-2 text-gray-600 hover:text-gray-800">
                                                    &times;
                                                </button>
                                                <h2 class="text-xl font-semibold mb-4">Detail Lamaran</h2>
                                                <div class="space-y-2 text-sm text-gray-700">
                                                    <p><strong>Nama:</strong> {{ $app->employee->first_name }} {{ $app->employee->last_name }}</p>
                                                    <p><strong>Email:</strong> {{ $app->employee->user->email }}</p>
                                                    <p><strong>Nomor Telepon:</strong> {{ $app->employee->phone }}</p>
                                                    <p><strong>Judul Lowongan:</strong> {{ $app->job->nama_lowongan }}</p>
                                                    <p><strong>Posisi Dilamar:</strong> {{ $app->job->posisi }}</p>
                                                    <p><strong>Status:</strong>
                                                        <span class="px-2 py-1 text-xs font-semibold rounded bg-green-300 text-green-800">Dijadwalkan</span>
                                                    </p>
                                                    <p><strong>Tanggal Interview:</strong>
                                                        {{ \Carbon\Carbon::parse($app->interview_date)->translatedFormat('d M Y, H:i') }}
                                                    </p>
                                                    <p><strong>CV:</strong> {{ $app->cv_file }}</p>
                                                </div>
                                                <div class="mt-6 flex justify-end">
                                                    <button onclick="document.getElementById('modal-detail-{{ $app->slug }}').classList.add('hidden')" class="px-4 py-2 bg-gray-200 text-sm rounded hover:bg-gray-300">Tutup</button>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Tombol Jadwal Ulang --}}
                                        <button onclick="document.getElementById('modal-{{ $app->slug }}').classList.remove('hidden')" class="text-blue-600 hover:underline text-sm">Jadwal Ulang</button>

                                        {{-- Modal Jadwal Ulang --}}
                                        <div id="modal-{{ $app->slug }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                                            <div class="bg-white rounded-lg shadow p-6 w-full max-w-md">
                                                <h2 class="text-lg font-semibold mb-4">Atur Ulang Tanggal Interview</h2>
                                                <form action="{{ route('employer.updateInterviewDate', ['slug' => $app->slug]) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')

                                                    <label class="block mb-2 text-sm font-medium text-gray-700">Tanggal & Waktu Interview</label>

                                                    @php
                                                        $now = \Carbon\Carbon::now()->format('Y-m-d\TH:i');
                                                    @endphp

                                                    <input type="datetime-local" name="interview_date" value="{{ $app->interview_date ? \Carbon\Carbon::parse($app->interview_date)->format('Y-m-d\TH:i') : '' }}" min="{{ $now }}" class="w-full border-gray-300 rounded px-3 py-2 mb-4">

                                                    <div class="flex justify-end gap-2">
                                                        <button type="button" onclick="document.getElementById('modal-{{ $app->slug }}').classList.add('hidden')" class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                                                            Batal
                                                        </button>
                                                        <button type="submit" class="bg-primaryColor hover:bg-darkBlue text-white text-sm font-semibold px-6 py-2.5 rounded-md transition shadow-customblue">
                                                            Simpan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 mt-6">Tidak ada pelamar dalam proses interview.</p>
        @endforelse
    </div>
</div>

{{-- Tombol Kembali ke Atas --}}
<button id="backToTop"
    onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
    class="hidden fixed bottom-6 right-6 z-50 bg-gradient-to-tr from-blue-600 to-indigo-600 text-white p-3 rounded-full shadow-xl hover:scale-110 hover:shadow-2xl transition-all duration-300"
    title="Kembali ke atas" aria-label="Kembali ke atas">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
    </svg>
</button>

<script>
    window.addEventListener('scroll', () => {
        const btn = document.getElementById('backToTop');
        btn.style.display = window.scrollY > 300 ? 'flex' : 'none';
    });
</script>

@endsection
