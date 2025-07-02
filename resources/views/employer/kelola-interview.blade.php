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
                        <tr class="border-b hover:bg-gray-50">
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
                                <button onclick="document.getElementById('modal-detail-{{ $app->slug }}').classList.remove('hidden')"
                                    class="text-blue-600 hover:underline text-sm">Detail</button>

                                {{-- Tombol Jadwal Ulang --}}
                                <button onclick="document.getElementById('modal-{{ $app->slug }}').classList.remove('hidden')"
                                    class="text-blue-600 hover:underline text-sm">Jadwal Ulang</button>

                                {{-- MODAL DETAIL --}}
                                <div id="modal-detail-{{ $app->slug }}"
                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity duration-300 hidden overflow-y-auto py-10 px-4">
                                    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl p-6 relative animate-fadeIn">
                                        <!-- Tombol Tutup -->
                                        <button type="button"
                                            onclick="document.getElementById('modal-detail-{{ $app->slug }}').classList.add('hidden')"
                                            class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-xl font-bold transition">&times;
                                        </button>

                                        <!-- Judul -->
                                        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Detail Interview</h2>

                                        <!-- Konten -->
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700">
                                            <div><span class="font-medium">Nama:</span><br>{{ $app->employee->first_name }} {{ $app->employee->last_name }}</div>
                                            <div><span class="font-medium">Email:</span><br>{{ $app->employee->user->email }}</div>
                                            <div><span class="font-medium">Telepon:</span><br>{{ $app->employee->phone }}</div>
                                            <div><span class="font-medium">Lowongan:</span><br>{{ $app->job->nama_lowongan }}</div>
                                            <div><span class="font-medium">Posisi:</span><br>{{ $app->job->posisi }}</div>
                                            <div>
                                                <span class="font-medium">Tanggal Interview:</span><br>
                                                {{ \Carbon\Carbon::parse($app->interview_date)->translatedFormat('d M Y, H:i') }}
                                            </div>
                                            <div>
                                                <span class="font-medium">Status:</span><br>
                                                <span class="inline-block mt-1 px-2 py-1 text-xs font-semibold rounded bg-emerald-100 text-emerald-700">
                                                    Dijadwalkan
                                                </span>
                                            </div>
                                            <div class="sm:col-span-2">
                                                <span class="font-medium">CV:</span><br>
                                                <a href="{{ asset('storage/' . $app->cv_file) }}" target="_blank"
                                                    class="text-blue-600 hover:underline">{{ $app->cv_file }}</a>
                                            </div>
                                        </div>

                                        <!-- Tombol Tutup -->
                                        <div class="mt-6 text-end">
                                            <button onclick="document.getElementById('modal-detail-{{ $app->slug }}').classList.add('hidden')"
                                                class="inline-flex items-center px-4 py-2 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                                Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                {{-- MODAL JADWAL ULANG --}}
                                {{-- MODAL JADWAL ULANG --}}
                                <div id="modal-{{ $app->slug }}"
                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity duration-300 hidden overflow-y-auto py-10 px-4">
                                    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 relative animate-fadeIn">
                                        <!-- Tombol Tutup -->
                                        <button onclick="document.getElementById('modal-{{ $app->slug }}').classList.add('hidden')"
                                            class="absolute top-3 right-4 text-gray-400 hover:text-gray-600 transition text-xl font-bold">&times;
                                        </button>

                                        <!-- Judul -->
                                        <h2 class="text-lg font-semibold mb-4 text-gray-800">Atur Ulang Tanggal Interview</h2>

                                        <!-- Form -->
                                        <form action="{{ route('employer.updateInterviewDate', ['slug' => $app->slug]) }}" method="POST">
                                            @csrf
                                            @method('PATCH')

                                            @php
                                                $now = \Carbon\Carbon::now()->format('Y-m-d\TH:i');
                                            @endphp

                                            <label class="block mb-2 text-sm font-medium text-gray-700">Tanggal & Waktu Interview</label>
                                            <input type="datetime-local"
                                                name="interview_date"
                                                value="{{ $app->interview_date ? \Carbon\Carbon::parse($app->interview_date)->format('Y-m-d\TH:i') : '' }}"
                                                min="{{ $now }}"
                                                class="w-full border-gray-300 rounded px-3 py-2 mb-4 shadow-sm focus:ring-primaryColor focus:border-primaryColor">

                                            <!-- Tombol -->
                                            <div class="flex justify-end gap-2 mt-2">
                                                <button type="button"
                                                    onclick="document.getElementById('modal-{{ $app->slug }}').classList.add('hidden')"
                                                    class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                                                    Batal
                                                </button>
                                                <button type="submit"
                                                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-6 py-2.5 rounded-md transition shadow">
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
