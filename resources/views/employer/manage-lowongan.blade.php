@extends('employer.layouts.app')

@section('content')


{{-- Judul Halaman --}}
<div class="flex justify-start">
    <div class="flex flex-col w-full lg:w-2/3 text-left mx-4 md:mx-10 lg:mx-20 lg:ml-28">
        <p class="text-md text-gray-600">Selamat datang di halaman</p>
        <p class="font-semibold text-2xl 2xl:text-3xl my-2 text-gray-800">Manajemen Lowongan Pekerjaan</p>
        <div class="w-28 h-1 bg-blue-500 rounded mb-4"></div>
        <p class="text-gray-600 text-sm mb-3">Kelola semua lowongan pekerjaan Anda di sini.</p>
        <div class="flex items-start space-x-4 border-l-4 border-blue-600 bg-blue-50 rounded-md p-5 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
            </svg>
            <div>
                <h3 class="text-blue-700 font-semibold text-lg mb-1">Informasi Tambahan</h3>
                <p class="text-blue-800 text-sm leading-relaxed max-w-prose">
                    Halaman Manajemen Lowongan Pekerjaan ini digunakan untuk mengelola seluruh informasi lowongan kerja yang ditampilkan pada portal karir PNB. Anda dapat mencari, menambah, mengedit, dan menghapus lowongan dengan mudah dan cepat melalui halaman ini.
                </p>
            </div>
        </div>
        <a href="{{ route('employer.dashboard') }}"
            class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium mt-2 transition duration-300">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Halaman Utama
        </a>
    </div>
</div>

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


{{-- Tabel Daftar Lowongan --}}
<div class="flex flex-col w-full lg:w-2/3 mx-auto mt-6 mb-12">

    {{-- Tombol Tambah --}}
    <div class="flex justify-end mb-4">
        <a href="{{ route('employer.tambahlowongan') }}"
           class="inline-flex items-center px-4 py-2 bg-gradient-to-br from-green-400 to-green-500 hover:from-green-500 hover:to-green-600 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Lowongan
        </a>
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto bg-white border border-gray-200 rounded-xl shadow">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
            <thead class="bg-gray-50 text-gray-600 uppercase tracking-wider text-xs">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Poster</th>
                    <th class="px-6 py-3 text-left font-semibold">Nama Lowongan</th>
                    <th class="px-6 py-3 text-left font-semibold">Posisi</th>
                    <th class="px-6 py-3 text-left font-semibold">Jenis</th>
                    <th class="px-6 py-3 text-left font-semibold">Gaji</th>
                    <th class="px-6 py-3 text-left font-semibold">Deadline</th>
                    <th class="px-6 py-3 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($joblisting as $lowongan)
                <tr class="hover:bg-blue-50 transition">
                    <td class="px-6 py-4">
                        @if ($lowongan->poster)
                            <img src="{{ asset('storage/' . $lowongan->poster) }}" alt="Poster"
                                 class="w-14 h-14 object-cover rounded-md border">
                        @else
                            <span class="text-gray-400 italic">Tidak ada</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 truncate max-w-xs" title="{{ $lowongan->nama_lowongan }}">
                        {{ $lowongan->nama_lowongan }}
                    </td>
                    <td class="px-6 py-4">{{ $lowongan->posisi }}</td>
                    <td class="px-6 py-4">{{ $lowongan->jenislowongan }}</td>
                    <td class="px-6 py-4 text-green-600 font-semibold">
                        <div class="inline-flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.333.667-4 2-4 4s2.667 3.333 4 4 4-1.333 4-4-2.667-3.333-4-4z" />
                            </svg>
                            {{ 'Rp ' . number_format((int) str_replace('.', '', $lowongan->gaji), 0, ',', '.') }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="inline-flex items-center gap-1 text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M8 7V3m8 4V3m-9 4h10M5 11h14M5 19h14M5 15h14" />
                            </svg>
                            {{ \Carbon\Carbon::parse($lowongan->deadline)->format('d M Y') }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center items-center gap-2 flex-wrap">
                            <a href="{{ route('employer.edit-lowongan', $lowongan->slug) }}"
                               class="px-3 py-1 text-xs font-semibold text-yellow-800 bg-yellow-200 rounded hover:bg-yellow-300 transition">
                                Edit
                            </a>
                            <form action="{{ route('employer.destroy-lowongan', $lowongan->slug) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        onclick="showDeleteModal(this.closest('form'))"
                                        class="px-3 py-1 text-xs font-semibold text-white bg-red-600 rounded hover:bg-red-700 transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada lowongan ditambahkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>




{{-- Modal Konfirmasi Hapus --}}
<div id="confirm-modal" tabindex="-1"
    class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto backdrop-blur-md bg-black/30">
    <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-gray-200 transition-all duration-300 ease-out">
        
        {{-- Tombol Tutup --}}
        <button type="button"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full w-9 h-9 flex items-center justify-center transition"
            aria-label="Tutup" onclick="hideModal()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- Konten Modal --}}
        <div class="p-6 sm:p-8 text-center">
            {{-- Ikon Peringatan --}}
            <div class="mx-auto mb-5 flex items-center justify-center w-16 h-16 rounded-full bg-red-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v2m0 4h.01M12 5a7 7 0 100 14 7 7 0 000-14z" />
                </svg>
            </div>

            <h3 class="text-xl font-semibold text-gray-800 mb-2">
                Apakah Anda yakin ingin menghapus lowongan ini?
            </h3>
            <p class="text-sm text-gray-500 mb-6">
                Tindakan ini tidak dapat dibatalkan.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <button type="button" id="confirm-delete"
                    class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-md shadow transition">
                    Ya, Hapus
                </button>

                <button type="button" onclick="hideModal()"
                    class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-100 transition">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>



<!-- Tombol Kembali ke Atas -->
<button id="backToTop"
    onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
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

<script>
    let deleteForm = null;

    function showDeleteModal(formElement) {
        deleteForm = formElement;
        document.getElementById('confirm-modal').classList.remove('hidden');
    }

    function hideModal() {
        document.getElementById('confirm-modal').classList.add('hidden');
        deleteForm = null;
    }

    document.getElementById('confirm-delete')?.addEventListener('click', function() {
        if (deleteForm) {
            deleteForm.submit();
        }
    });
</script>


@endsection