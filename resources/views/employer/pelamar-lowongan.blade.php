@extends('employer.layouts.app')

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

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Memproses...',
            text: 'Silakan tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
            }
        });

        // Setelah 1.5 detik, tutup loading lalu tampilkan alert sukses
        setTimeout(() => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                confirmButtonText: 'OK'
            });
        }, 1500);
    });
</script>
@endif

{{-- Judul Halaman --}}
<div class="flex justify-start">
    <div class="flex flex-col w-full lg:w-2/3 text-left mx-4 md:mx-10 lg:mx-20 lg:ml-28">
        <p class="text-md text-gray-600">Selamat datang di halaman</p>
        <p class="font-semibold text-2xl 2xl:text-3xl my-2 text-gray-800">Manajemen Pelamar Lowongan</p>
        <div class="w-28 h-1 bg-blue-500 rounded mb-4"></div>
        <p class="text-gray-600 text-sm mb-3">Lihat dan kelola semua pelamar yang mendaftar ke lowongan pekerjaan Anda.</p>
        <div class="flex items-start space-x-4 border-l-4 border-blue-600 bg-blue-50 rounded-md p-5 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
            </svg>
            <div>
                <h3 class="text-blue-700 font-semibold text-lg mb-1">Informasi Tambahan</h3>
                <p class="text-blue-800 text-sm leading-relaxed max-w-prose">
                    Halaman ini digunakan oleh pemberi kerja untuk melihat daftar pelamar yang telah mengajukan lamaran ke lowongan pekerjaan Anda. Anda dapat meninjau profil pelamar, mengunduh CV, serta memberikan keputusan atau tindak lanjut terhadap lamaran yang masuk.
                </p>
            </div>
        </div>
        <a href="{{ route('employer.dashboard') }}"
            class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium mt-2 transition duration-300 mb-4">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Halaman Utama
        </a>
    </div>
</div>

<div class="flex flex-col w-full lg:w-2/3 mx-4 md:mx-10 lg:mx-auto">
    {{-- Judul Statistik --}}
    <div class="text-center my-6">
        <h2 class="text-2xl font-semibold text-gray-800">Statistik Pelamar</h2>
        <p class="text-sm text-gray-500">Ringkasan data pelamar berdasarkan status aplikasi</p>
    </div>

    {{-- Ringkasan Statistik Pelamar --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 w-full lg:w-2/3 mx-4 md:mx-10 lg:mx-auto mb-8">
        <div class="bg-white rounded-lg shadow p-4 text-center border-t-4 border-blue-500">
            <p class="text-sm text-gray-600">Total Pelamar</p>
            <p class="text-xl font-bold text-blue-700">{{$summary['total']}}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center border-t-4 border-indigo-500">
            <p class="text-sm text-gray-600">Interview</p>
            <p class="text-xl font-bold text-indigo-700">{{$summary['interview']}}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center border-t-4 border-green-500">
            <p class="text-sm text-gray-600">Diterima</p>
            <p class="text-xl font-bold text-green-700">{{$summary['accepted']}}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center border-t-4 border-red-500">
            <p class="text-sm text-gray-600">Ditolak</p>
            <p class="text-xl font-bold text-red-700">{{$summary['rejected']}}</p>
        </div>
    </div>

    <!-- Filter Form Mulai -->
    <form method="GET" action="{{ url()->current() }}" class="mb-8">
        <div class="flex flex-col md:flex-row md:items-end gap-4 bg-white border border-gray-100 shadow-sm rounded-2xl p-6 transition-all duration-300">

            {{-- Input Pencarian Lowongan --}}
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-600 mb-1">Cari Lowongan</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                    placeholder="Nama atau posisi lowongan"
                    class="w-full px-4 py-2 text-sm rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 text-gray-800 transition shadow-sm placeholder:text-gray-400" />
            </div>

            {{-- Filter Status --}}
            <div class="flex-1">
                <label for="statusFilter" class="block text-sm font-medium text-gray-600 mb-1">Status Pelamar</label>
                <select name="status" id="statusFilter" onchange="this.form.submit()"
                    class="w-full px-4 py-2 text-sm rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 text-gray-800 transition shadow-sm">
                    <option value="" {{ request('status') == '' ? 'selected' : '' }}>Semua</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                    <option value="interview" {{ request('status') == 'interview' ? 'selected' : '' }}>Interview</option>
                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            {{-- Tombol Cari --}}
            <div class="w-full md:w-auto">
                <button type="submit"
                    class="flex items-center justify-center gap-2 w-full md:w-auto bg-primaryColor hover:bg-darkBlue text-white text-sm font-semibold px-6 py-2.5 rounded-lg transition duration-300 shadow-customblue focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryColor">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35M17 10.5A6.5 6.5 0 104 10.5a6.5 6.5 0 0013 0z" />
                    </svg>
                    Cari
                </button>
            </div>
        </div>
    </form>

    <!-- Filter Form Selesai -->
    @forelse ($applications as $jobId => $jobApps)
    <div class="mb-12">
        <div class="flex items-center justify-between mb-4 border-b border-gray-300 pb-2">
            <h2 class="text-xl font-semibold text-gray-900">
                {{ $jobApps->first()->job->nama_lowongan }} ({{ $jobApps->first()->job->posisi }})
            </h2>
            <span class="text-sm text-gray-600 font-medium">
                Total Pelamar: {{ $jobApps->count() }}
            </span>
        </div>

        <div class="overflow-x-auto bg-white border border-gray-300 rounded-lg shadow-md">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-50 border-b border-gray-300">
                    <tr>
                        <th class="px-6 py-3 font-semibold uppercase tracking-wider">Nama Pelamar</th>
                        <th class="px-6 py-3 font-semibold uppercase tracking-wider">Status Aplikasi</th>
                        <th class="px-6 py-3 font-semibold uppercase tracking-wider">Tanggal Melamar</th>
                        <th class="px-6 py-3 font-semibold uppercase tracking-wider">CV</th>
                        <th class="px-6 py-3 font-semibold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($jobApps as $app)
                    <tr class="hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            <div class="flex items-center gap-3">
                                <!-- Tombol Detail dengan ikon mata -->
                                <a href="{{ route('employer.detail-pelamar', ['slug' => $app->job->employer->slug, 'jobId' => $app->job->id, 'userId' => $app->employee_id]) }}"
                                    class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 transition group"
                                    title="Lihat Detail">
                                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <!-- Ikon mata -->
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5
                    c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7
                    -4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <span>{{ $app->employee->first_name }} {{ $app->employee->last_name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-800">
                            @php
                            $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'reviewed' => 'bg-blue-100 text-blue-800',
                            'interview' => 'bg-indigo-100 text-indigo-800',
                            'accepted' => 'bg-green-100 text-green-800',
                            'rejected' => 'bg-red-100 text-red-800',
                            ];
                            $colorClass = $statusColors[$app->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold {{ $colorClass }}">
                                {{ ucfirst($app->status) }}
                            </span>
                            @if ($app->status === 'interview' && $app->interview_date)
                            <br>
                            <span class="text-xs text-gray-500 mt-1 block">
                                ({{ \Carbon\Carbon::parse($app->interview_date)->format('d M Y H:i') }})
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ $app->applied_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            @if ($app->cv_file)
                            <a href="{{ route('cv.download', basename($app->cv_file)) }}" target="_blank"
                                class="text-blue-600 underline hover:text-blue-800 transition">
                                Download CV
                            </a>
                            @else
                            <span class="text-gray-400 italic">Tidak ada</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 space-y-2">
                            <!-- Form Update Status -->
                            <form action="{{ route('employer.updateStatus', $app->slug) }}" method="POST" id="form-{{ $app->slug }}">
                                @csrf
                                @method('PATCH')

                                <select name="status" id="status-select-{{ $app->slug }}"
                                    data-initial="{{ $app->status }}"
                                    class="text-sm border border-gray-300 rounded-md px-3 py-2 w-full mb-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    onchange="handleStatusChange('{{ $app->slug }}', this.value)">
                                    <option value="pending" {{ $app->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="reviewed" {{ $app->status === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                    <option value="interview" {{ $app->status === 'interview' ? 'selected' : '' }}>Interview</option>
                                    <option value="accepted" {{ $app->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="rejected" {{ $app->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>

                                <!-- Input Interview Date -->
                                <div id="interview-container-{{ $app->slug }}" class="{{ $app->status === 'interview' ? '' : 'hidden' }}">
                                    <input type="datetime-local" name="interview_date"
                                        id="interview-date-{{ $app->slug }}"
                                        value="{{ $app->interview_date ? \Carbon\Carbon::parse($app->interview_date)->format('Y-m-d\TH:i') : '' }}"
                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}"
                                        class="block w-full border border-gray-300 rounded-md px-3 py-2 text-sm mb-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                                        onchange="handleStatusChange('{{ $app->slug }}', document.getElementById('status-select-{{ $app->slug }}').value)">
                                </div>

                                <!-- Tombol Simpan -->
                                <div id="save-button-container-{{ $app->slug }}" class="hidden">
                                    <button type="button"
                                        data-modal-target="popup-modal-{{ $app->slug }}"
                                        data-modal-toggle="popup-modal-{{ $app->slug }}"
                                        class="bg-primaryColor hover:bg-darkBlue text-white text-sm font-semibold px-6 py-2.5 rounded-md transition shadow-customblue">
                                        Simpan
                                    </button>
                                </div>
                                <!-- Modal Konfirmasi -->
                                <div id="popup-modal-{{ $app->slug }}" tabindex="-1"
                                    class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-transparent backdrop-blur-md overflow-y-auto">

                                    <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-gray-200 transition-all duration-300 ease-out">

                                        {{-- Tombol Tutup --}}
                                        <button type="button"
                                            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full w-9 h-9 flex items-center justify-center transition"
                                            data-modal-hide="popup-modal-{{ $app->slug }}" aria-label="Tutup">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>

                                        {{-- Konten Modal --}}
                                        <div class="p-6 sm:p-8 text-center">
                                            {{-- Ikon --}}
                                            <div class="mx-auto mb-5 flex items-center justify-center w-16 h-16 rounded-full bg-yellow-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 9v2m0 4h.01M12 5a7 7 0 100 14 7 7 0 000-14z" />
                                                </svg>
                                            </div>

                                            <h3 class="text-lg font-semibold text-gray-800 mb-3">
                                                Yakin ingin menyimpan perubahan status pelamar ini?
                                            </h3>

                                            <div class="flex flex-col sm:flex-row justify-center gap-3">
                                                <button type="button"
                                                    onclick="document.getElementById('form-{{ $app->slug }}').submit()"
                                                    data-modal-hide="popup-modal-{{ $app->slug }}"
                                                    class="bg-primaryColor hover:bg-darkBlue text-white text-sm font-semibold px-6 py-2.5 rounded-md transition shadow-customblue">
                                                    Ya, Simpan
                                                </button>

                                                <button type="button"
                                                    class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-100 transition"
                                                    data-modal-hide="popup-modal-{{ $app->slug }}">
                                                    Batal
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-gray-500 italic">Belum ada pelamar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @empty
    <div class="text-center text-gray-500 py-10 italic">
        Belum ada pelamar untuk semua lowongan.
    </div>
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
        // Tampilkan tombol "Kembali ke Atas" setelah scroll 300px
        window.addEventListener('scroll', () => {
            const btn = document.getElementById('backToTop');
            btn.style.display = window.scrollY > 300 ? 'flex' : 'none';
        });
    </script>

    <script>
        // Simpan nilai awal tiap form untuk deteksi perubahan
        const initialValues = {};

        document.addEventListener('DOMContentLoaded', () => {
            @foreach($applications as $jobApps)
            @foreach($jobApps as $app)
            initialValues['{{ $app->slug }}'] = {
                status: '{{ $app->status }}',
                interview_date: '{{ $app->interview_date ? \Carbon\Carbon::parse($app->interview_date)->format("Y-m-d\\TH:i") : "" }}',
            };
            @endforeach
            @endforeach
        });


        function handleStatusChange(slug, newStatus) {
            const form = document.getElementById('form-' + slug);
            const saveButton = form.querySelector('button[type="submit"]');
            const interviewContainer = document.getElementById('interview-container-' + slug);
            const interviewInput = interviewContainer.querySelector('input[name="interview_date"]');

            // Tampilkan/ sembunyikan input tanggal interview
            if (newStatus === 'interview') {
                interviewContainer.classList.remove('hidden');
            } else {
                interviewContainer.classList.add('hidden');
                // Reset tanggal interview kalau status bukan interview
                if (interviewInput) interviewInput.value = '';
            }

            // Cek apakah ada perubahan dari nilai awal
            const initial = initialValues[slug];
            const currentInterviewDate = interviewInput ? interviewInput.value : '';

            if (newStatus !== initial.status || currentInterviewDate !== initial.interview_date) {
                saveButton.style.display = 'block';
            } else {
                saveButton.style.display = 'none';
            }
        }
    </script>
    <script>
        function handleStatusChange(slug, currentStatus) {
            const statusSelect = document.getElementById(`status-select-${slug}`);
            const interviewInput = document.getElementById(`interview-date-${slug}`);
            const saveButtonContainer = document.getElementById(`save-button-container-${slug}`);
            const interviewContainer = document.getElementById(`interview-container-${slug}`);

            const initialStatus = statusSelect.dataset.initial;
            const initialDate = interviewInput?.dataset.initial || '';
            const currentDate = interviewInput?.value || '';

            // Tampilkan input datetime kalau interview
            if (currentStatus === 'interview') {
                interviewContainer.classList.remove('hidden');
            } else {
                interviewContainer.classList.add('hidden');
            }

            // Cek apakah ada perubahan
            const statusChanged = currentStatus !== initialStatus;
            const interviewChanged = currentStatus === 'interview' && currentDate !== initialDate;

            if (statusChanged || interviewChanged) {
                saveButtonContainer.classList.remove('hidden');
            } else {
                saveButtonContainer.classList.add('hidden');
            }
        }
    </script>



    @endsection