@extends('employer.layouts.app')

@section('content')


{{-- Judul Halaman --}}
<div class="flex justify-start">
    <div class="flex flex-col w-full lg:w-2/3 text-left mx-4 md:mx-10 lg:mx-20 lg:ml-28">
        <p class="text-md text-gray-600">Selamat datang di halaman</p>
        <p class="font-semibold text-2xl 2xl:text-3xl my-2 text-gray-800">Manajemen Interview Pelamar</p>
        <div class="w-28 h-1 bg-blue-500 rounded mb-4"></div>
        <p class="text-gray-600 text-sm mb-3">Kelola proses interview pelamar yang telah mendaftar ke lowongan pekerjaan Anda.</p>

        <div class="flex items-start space-x-4 border-l-4 border-blue-600 bg-blue-50 rounded-md p-5 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600 flex-shrink-0" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
            </svg>
            <div>
                <h3 class="text-blue-700 font-semibold text-lg mb-1">Informasi Tambahan</h3>
                <p class="text-blue-800 text-sm leading-relaxed max-w-prose">
                    Halaman ini menampilkan daftar pelamar yang sedang menunggu jadwal interview. Anda dapat melihat nama pelamar, tanggal interview yang telah dijadwalkan, serta menindaklanjuti proses interview sesuai kebutuhan.
                </p>
            </div>
        </div>

        <a href="{{ route('employer.dashboard') }}"
            class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium mt-2 transition duration-300 mb-4">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Halaman Utama
        </a>

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

        {{-- Tabel Interview dari Data Asli --}}
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
                    @forelse ($applications as $jobApps)
                    @foreach ($jobApps as $app)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="px-6 py-4">{{ $no++ }}</td>
                        <td class="px-6 py-4">
                            {{ $app->employee->first_name }} {{ $app->employee->last_name }}
                        </td>
                        <td class="px-6 py-4">
                            @if ($app->interview_date)
                            {{ \Carbon\Carbon::parse($app->interview_date)->translatedFormat('d M Y, H:i') }}
                            @else
                            <span class="italic text-gray-400">Belum dijadwalkan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if ($app->status === 'interview')
                            <span class="px-2 py-1 text-xs font-semibold rounded bg-green-300 text-green-800">
                                Dijadwalkan
                            </span>
                            @else
                            <span class="px-2 py-1 text-xs font-semibold rounded bg-yellow-300 text-yellow-800">
                                Menunggu
                            </span>
                            @endif
                        </td>
                        <!-- Aksi -->
                        <td class="px-6 py-4 space-x-3">
                            <!-- Tombol untuk membuka modal detail -->
                            <button onclick="document.getElementById('modal-detail-{{ $app->slug }}').classList.remove('hidden')" class="text-blue-600 hover:underline text-sm">
                                Detail
                            </button>

                            <!-- Modal Detail -->
                            <div id="modal-detail-{{ $app->slug }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                                <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
                                    <!-- Tombol Tutup -->
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
                                            @if ($app->status === 'interview')
                                            <span class="px-2 py-1 text-xs font-semibold rounded bg-green-300 text-green-800">Dijadwalkan</span>
                                            @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded bg-yellow-300 text-yellow-800">Menunggu</span>
                                            @endif
                                        </p>
                                        <p><strong>Tanggal Interview:</strong>
                                            @if ($app->interview_date)
                                            {{ \Carbon\Carbon::parse($app->interview_date)->translatedFormat('d M Y, H:i') }}
                                            @else
                                            <span class="italic text-gray-400">Belum dijadwalkan</span>
                                            @endif
                                        </p>
                                        <p><strong>CV:</strong> {{ $app->cv_file }}</p>
                                    </div>

                                    <div class="mt-6 flex justify-end">
                                        <button onclick="document.getElementById('modal-detail-{{ $app->slug }}').classList.add('hidden')" class="px-4 py-2 bg-gray-200 text-sm rounded hover:bg-gray-300">
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol trigger modal -->
                            <button onclick="document.getElementById('modal-{{ $app->slug }}').classList.remove('hidden')" class="text-blue-600 hover:underline text-sm">
                                Jadwal Ulang
                            </button>

                            <!-- Modal -->
                            <!-- Modal -->
                            <div id="modal-{{ $app->slug }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                                <div class="bg-white rounded-lg shadow p-6 w-full max-w-md">
                                    <h2 class="text-lg font-semibold mb-4">Atur Ulang Tanggal Interview</h2>
                                    <form action="{{ route('employer.updateInterviewDate', $app->slug) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <label class="block mb-2 text-sm font-medium text-gray-700">Tanggal & Waktu Interview</label>

                                        @php
                                        $now = \Carbon\Carbon::now()->format('Y-m-d\TH:i');
                                        @endphp

                                        <input
                                            type="datetime-local"
                                            name="interview_date"
                                            value="{{ $app->interview_date ? \Carbon\Carbon::parse($app->interview_date)->format('Y-m-d\TH:i') : '' }}"
                                            min="{{ $now }}"
                                            class="w-full border-gray-300 rounded px-3 py-2 mb-4">

                                        <div class="flex justify-end gap-2">
                                            <button type="button" onclick="document.getElementById('modal-{{ $app->slug }}').classList.add('hidden')" class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                                                Batal
                                            </button>
                                            <button type="button" id="open-confirm"
                                                class="bg-primaryColor hover:bg-darkBlue text-white text-sm font-semibold px-6 py-2.5 rounded-md transition shadow-customblue">
                                                Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada pelamar yang sedang dalam proses interview.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- Modal Konfirmasi --}}
<div id="confirm-modal" tabindex="-1"
    class="hidden fixed top-0 left-0 right-0 z-50 flex items-center justify-center w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur-sm">
    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-xl shadow-xl border border-gray-200">
            <button type="button"
                class="absolute top-2.5 right-2.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition rounded-full w-8 h-8 flex items-center justify-center"
                aria-label="Tutup" onclick="hideModal()">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 14 14">
                    <path d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>

            <div class="p-6 text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" fill="none" viewBox="0 0 20 20">
                    <path d="M10 11V6m0 0h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <h3 class="mb-5 text-lg font-medium text-gray-700">Apakah kamu yakin ingin menyimpan jadwal interview ini?</h3>

                <button type="button" id="confirm-submit"
                    class="bg-primaryColor hover:bg-darkBlue text-white text-sm font-semibold px-6 py-2.5 rounded-md transition shadow-customblue">
                    Ya, Simpan
                </button>

                <button type="button" onclick="hideModal()"
                    class="ml-3 px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-100 transition">
                    Batal
                </button>
            </div>
        </div>
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
    // Tampilkan tombol "Kembali ke Atas" setelah scroll 300px
    window.addEventListener('scroll', () => {
        const btn = document.getElementById('backToTop');
        btn.style.display = window.scrollY > 300 ? 'flex' : 'none';
    });
</script>

<script>
    const confirmModal = document.getElementById('confirm-modal');
    const openConfirmBtn = document.getElementById('open-confirm');
    const confirmSubmitBtn = document.getElementById('confirm-submit');

    // Form yang ingin kita submit nanti
    const formInterview = document.querySelector('#modal-{{ $app->slug }} form');

    // Fungsi buka modal konfirmasi
    function showModal() {
        confirmModal.classList.remove('hidden');
    }

    // Fungsi tutup modal konfirmasi
    function hideModal() {
        confirmModal.classList.add('hidden');
    }

    openConfirmBtn.addEventListener('click', function() {
        showModal();
    });

    confirmSubmitBtn.addEventListener('click', function() {
        formInterview.submit();
    });
</script>


@endsection