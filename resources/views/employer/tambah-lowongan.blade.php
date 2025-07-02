@extends('employer.layouts.app')

@section('content')

{{-- Header Judul Halaman --}}
<div class="flex justify-start mt-10 2xl:mt-10">
    <div class="flex flex-col w-full lg:w-2/3 text-left mx-4 md:mx-10 lg:mx-20 lg:ml-28">
        <p class="my-3 text-md 2xl:text-xl text-gray-600">Selamat datang di halaman</p>
        <p class="font-semibold text-xl 2xl:text-3xl my-2 text-gray-800">Tambah Lowongan Baru</p>
        <div class="w-20 h-1 bg-blue-500 rounded mb-4"></div>
        <a href="javascript:history.back()"
            class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium mt-2 transition duration-300">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Halaman Sebelumnya
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

{{-- Form dan layout sama seperti milikmu --}}
<div class="flex flex-col lg:flex-row justify-start mt-10 mx-4 md:mx-10 lg:mx-20 lg:ml-28 gap-8">

    {{-- Form Tambah Lowongan --}}
    <div class="w-full lg:w-2/3 bg-white p-6 rounded-xl shadow-md border border-gray-200">
        <form id="form-lowongan" action="{{ route('employer.storelowongan') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            {{-- Nama Lowongan --}}
            <div class="mb-5">
                <x-label-required for="nama_lowongan" :value="__('Nama Lowongan')" />
                <x-text-input id="nama_lowongan" name="nama_lowongan" type="text"
                    class="block mt-1 w-full rounded-md border-gray-300 focus:ring-2 focus:ring-blue-500 text-sm"
                    placeholder="Contoh: Staff Marketing" required />
            </div>

            {{-- Deskripsi --}}
            <div class="mb-5">
                <x-label-required for="deskripsi" :value="__('Deskripsi')" />
                <x-text-area-input id="deskripsi" name="deskripsi"
                    class="block mt-1 w-full rounded-md border-gray-300 focus:ring-2 focus:ring-blue-500 text-sm"
                    placeholder="Masukkan ringkasan pekerjaan yang jelas dan menarik." required />
            </div>

            {{-- Jenis Pekerjaan --}}
            <div class="mb-5">
                <x-label-required for="jenislowongan" :value="__('Jenis Lowongan')" />
                <x-dropdown.jenis-lowongan class="block mt-1 w-full text-sm" />
            </div>

            {{-- Posisi Jabatan--}}
            <div class="mb-5">
                <x-label-required for="posisi" :value="__('Posisi Lowongan')" />
                <x-dropdown.tingkat-posisi class="block mt-1 w-full text-sm" />
            </div>

            {{-- Responsibility --}}
            <div class="mb-5">
                <x-label-required for="responsibility" :value="__('Tanggung Jawab')" />
                <x-text-area-input id="responsibility" name="responsibility"
                    class="block mt-1 w-full rounded-md border-gray-300 focus:ring-2 focus:ring-blue-500 text-sm"
                    placeholder="Tulis tanggung jawab utama posisi ini, misalnya: mengatur jadwal, menyusun laporan, dll." required />
            </div>

            {{-- Kualifikasi Pendidikan --}}
            <div class="mb-5">
                <x-label-required for="kualifikasi" :value="__('Kualifikasi Pendidikan')" />
                <x-dropdown.kualifikasi-pendidikan class="block mt-1 w-full text-sm" />
            </div>

            {{-- Detail Kualifikasi --}}
            <div class="mb-5">
                <x-label-required for="detailkualifikasi" :value="__('Detail Kualifikasi')" />
                <x-text-area-input id="detailkualifikasi" name="detailkualifikasi"
                    class="block mt-1 w-full rounded-md border-gray-300 focus:ring-2 focus:ring-blue-500 text-sm"
                    placeholder="Contoh: Minimal lulusan S1 Teknik Informatika atau jurusan terkait." required />
            </div>

            {{-- Gaji --}}
            <div class="mb-5">
                <x-label-required for="gaji" :value="__('Gaji')" />
                <x-text-input id="gaji" name="gaji" type="text"
                    class="block mt-1 w-full rounded-md border-gray-300 focus:ring-2 focus:ring-blue-500 text-sm"
                    placeholder="Contoh: 5000000" value="{{ old('gaji', $job->gaji ?? '') }}" required />
                <p class="text-xs text-gray-500 mt-1">Masukkan nominal angka saja, tanpa titik atau simbol. Misal: 5000000</p>
            </div>

            {{-- Benefit --}}
            <div class="mb-5">
                <x-label-required for="benefit" :value="__('Benefit')" />
                <x-text-area-input id="benefit" name="benefit"
                    class="block mt-1 w-full rounded-md border-gray-300 focus:ring-2 focus:ring-blue-500 text-sm"
                    placeholder="Tulis benefit seperti asuransi, bonus, cuti tambahan, jenjang karir, dll." required />
            </div>

            {{-- Deadline --}}
            <div class="mb-6">
                <x-label-required for="deadline" :value="__('Tenggat Pendaftaran')" />
                <x-text-input id="deadline" name="deadline" type="date"
                    :min="now()->toDateString()"
                    class="block mt-1 w-full rounded-md border-gray-300 focus:ring-2 focus:ring-blue-500 text-sm"
                    required />
            </div>

            {{-- Poster / Flayer --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2" for="poster">
                    <i class="fas fa-image mr-1 text-blue-500"></i> Poster atau Flayer
                </label>
                <input type="file" name="poster" id="poster" accept="image/*"
                    class="block w-full text-sm text-gray-700 border border-gray-300 rounded-md p-2 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            {{-- Tombol Simpan: ubah jadi type button supaya tidak langsung submit --}}
            <div class="text-right">
                <button id="btn-simpan" type="button"
                    class="bg-primaryColor hover:bg-darkBlue text-white text-sm font-semibold px-6 py-2.5 rounded-md transition shadow-customblue">
                    Simpan Lowongan
                </button>
            </div>
        </form>
    </div>

    {{-- Box Informasi Tambahan --}}
    <div class="w-full lg:w-1/3 bg-gradient-to-r from-blue-50 via-white to-blue-100 border border-blue-300 rounded-lg p-6 shadow-lg">
        <div class="text-3xl mb-3 text-blue-500">
            <i class="fas fa-info-circle"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-800">Informasi Tambahan</h3>
        <p class="mt-2 text-sm text-gray-700 leading-relaxed">
            Di halaman ini, Anda dapat menambahkan informasi lowongan pekerjaan secara lengkap seperti judul, deskripsi pekerjaan, lokasi penempatan, dan batas waktu pendaftaran.
            <br><br>
            Pastikan seluruh data yang dimasukkan benar agar dapat membantu pencari kerja menemukan lowongan Anda dengan mudah.
        </p>
    </div>
</div>

<div id="confirm-modal" tabindex="-1"
    class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto backdrop-blur-md bg-black/30">
    <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-gray-200 transition-all duration-300 ease-out">
        {{-- Tombol Tutup --}}
        <button type="button"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full w-9 h-9 flex items-center justify-center transition"
            onclick="hideModal()" aria-label="Tutup">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- Konten Modal --}}
        <div class="p-6 sm:p-8 text-center">
            {{-- Ikon Info --}}
            <div class="mx-auto mb-5 flex items-center justify-center w-16 h-16 rounded-full bg-yellow-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v2m0 4h.01M12 5a7 7 0 100 14 7 7 0 000-14z" />
                </svg>
            </div>

            <h3 class="text-xl font-semibold text-gray-800 mb-2">Simpan Lowongan?</h3>
            <p class="text-sm text-gray-500 mb-6">
                Apakah kamu yakin ingin menyimpan lowongan ini? Pastikan semua data sudah benar.
            </p>

            {{-- Tombol Aksi --}}
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <button id="confirm-submit" type="button"
                    class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white bg-primaryColor hover:bg-darkBlue rounded-md shadow-customblue transition">
                    Ya, Simpan
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

{{-- Script --}}
<script>
    const btnSimpan = document.getElementById('btn-simpan');
    const form = document.getElementById('form-lowongan');
    const modal = document.getElementById('confirm-modal');
    const btnConfirmSubmit = document.getElementById('confirm-submit');

    // Fungsi tampilkan modal
    function showModal() {
        modal.classList.remove('hidden');
    }

    // Fungsi sembunyikan modal
    function hideModal() {
        modal.classList.add('hidden');
    }

    btnSimpan.addEventListener('click', () => {
        // cek validasi form
        if (form.checkValidity()) {
            // semua valid, tampilkan modal konfirmasi
            showModal();
        } else {
            // tidak valid, trigger validasi browser tampil
            form.reportValidity();
        }
    });

    btnConfirmSubmit.addEventListener('click', () => {
        // submit form saat user klik konfirmasi
        form.submit();
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const gajiInput = document.getElementById('gaji');

        gajiInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Hapus semua selain angka
            if (value !== '') {
                e.target.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(Number(value));
            } else {
                e.target.value = '';
            }
        });
    });
</script>


@endsection