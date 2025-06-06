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
<div class="flex flex-col w-full lg:w-2/3 mx-4 md:mx-10 lg:mx-20 lg:ml-28 mt-6 mb-12">
    <div class="overflow-x-auto bg-white border border-gray-200 rounded-lg shadow-sm">
        <table class="min-w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100 border-b border-gray-200">
                <tr>
                    <th class="px-5 py-3 font-medium">Poster</th>
                    <th class="px-5 py-3 font-medium">Nama Lowongan</th>
                    <th class="px-5 py-3 font-medium">Posisi</th>
                    <th class="px-5 py-3 font-medium">Jenis</th>
                    <th class="px-5 py-3 font-medium">Deadline</th>
                    <th class="px-5 py-3 font-medium text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse ($joblisting as $lowongan)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-4">
                        @if ($lowongan->poster)
                        <img src="{{ asset('storage/' . $lowongan->poster) }}" alt="Poster" class="w-16 h-16 object-cover rounded-md border">
                        @else
                        <span class="text-gray-400 italic">Tidak ada</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 font-semibold text-gray-800">{{ $lowongan->nama_lowongan }}</td>
                    <td class="px-5 py-4">{{ $lowongan->posisi }}</td>
                    <td class="px-5 py-4">{{ $lowongan->jenislowongan }}</td>
                    <td class="px-5 py-4">{{ \Carbon\Carbon::parse($lowongan->deadline)->format('d M Y') }}</td>
                    <td class="px-5 py-4 text-center space-x-2">
                        {{-- Tombol Edit --}}
                        <a href="{{ route('employer.edit-lowongan', $lowongan->slug) }}"
                            class="inline-block px-3 py-1 text-xs font-semibold text-gray-800 bg-[#FACC15] rounded hover:bg-yellow-400 transition">
                            Edit
                        </a>

                        {{-- Tombol Hapus dengan class btn-delete --}}
                        <form action="{{ route('employer.destroy-lowongan', $lowongan->slug) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                onclick="showDeleteModal(this.closest('form'))"
                                class="inline-block px-3 py-1 text-xs text-white bg-[#E02D3C] rounded hover:opacity-90 transition">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-4 text-center text-gray-500">Belum ada lowongan ditambahkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Konfirmasi Hapus --}}
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
                <h3 class="mb-2 text-lg font-medium text-gray-700">
                    Apakah Anda yakin ingin menghapus lowongan ini?
                </h3>
                <p class="text-sm text-gray-500 mb-6">
                    Tindakan ini tidak dapat dibatalkan.
                </p>

                <button type="button" id="confirm-delete"
                    class="bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-6 py-2.5 rounded-md transition shadow">
                    Ya, Hapus
                </button>

                <button type="button" onclick="hideModal()"
                    class="ml-3 px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-100 transition">
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