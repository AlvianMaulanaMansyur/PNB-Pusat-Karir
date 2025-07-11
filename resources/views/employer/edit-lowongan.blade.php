@extends('employer.layouts.app')

@section('content')

{{-- Judul Halaman --}}
<div class="flex justify-start">
    <div class="flex flex-col w-full lg:w-2/3 text-left mx-4 md:mx-10 lg:mx-20 lg:ml-28">
        <p class="text-md text-gray-600">Selamat datang di halaman</p>
        <p class="font-semibold text-2xl 2xl:text-3xl my-2 text-gray-800">Edit Lowongan Pekerjaan</p>
        <div class="w-28 h-1 bg-blue-500 rounded mb-4"></div>
        <p class="text-gray-600 text-sm mb-3">Ubah detail dan informasi lowongan pekerjaan yang sudah Anda buat sebelumnya.</p>
        <div class="flex items-start space-x-4 border-l-4 border-blue-600 bg-blue-50 rounded-md p-5 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            <div>
                <h3 class="text-blue-700 font-semibold text-lg mb-1">Informasi Tambahan</h3>
                <p class="text-blue-800 text-sm leading-relaxed max-w-prose">
                    Halaman ini memungkinkan Anda untuk memperbarui data lowongan pekerjaan, seperti posisi, deskripsi, kualifikasi, dan tanggal penutupan lamaran. Pastikan semua informasi sudah benar sebelum menyimpan perubahan.
                </p>
            </div>
        </div>
        <a href="javascript:history.back()" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium transition duration-300 mb-4">
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

<form id="form-update-lowongan" action="{{ route('employer.update-lowongan', $lowongan->slug) }}" method="POST" enctype="multipart/form-data"
    class="w-full lg:w-2/3 mx-4 md:mx-10 lg:mx-20 lg:ml-28 bg-white p-6 rounded-lg shadow-md" novalidate>
    @csrf
    @method('PUT')

    {{-- Nama Lowongan --}}
    <div class="mb-4">
        <x-label-required for="nama_lowongan" :value="__('Nama Lowongan')" />
        <x-text-input id="nama_lowongan" name="nama_lowongan" type="text"
            :value="old('nama_lowongan', $lowongan->nama_lowongan)"
            class="block mt-1 w-full text-sm" required />
        @error('nama_lowongan')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Deskripsi --}}
    <div class="mb-4">
        <x-label-required for="deskripsi" :value="__('Deskripsi')" />
        <textarea name="deskripsi" id="deskripsi" rows="4"
            class="block mt-1 w-full rounded-md border-black-300 focus:ring-2 focus:ring-blue-500 text-sm"
            required>{{ old('deskripsi', $lowongan->deskripsi) }}</textarea>
        @error('deskripsi')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Jenis Pekerjaan --}}
    <div class="mb-4">
        <x-label-required for="jenislowongan" :value="__('Jenis Lowongan')" />
        <x-dropdown.jenis-lowongan
            :selected="old('jenislowongan', $lowongan->jenislowongan)"
            class="block mt-1 w-full text-sm border-black-300" />
        @error('jenislowongan')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Posisi Jabatan --}}
    <div class="mb-4">
        <x-label-required for="posisi" :value="__('Posisi Jabatan')" />
        <x-dropdown.tingkat-posisi
            :selected="old('posisi', $lowongan->posisi)"
            class="block mt-1 w-full text-sm border-gray-300" />
        @error('posisi')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Responsibility --}}
    <div class="mb-4">
        <x-label-required for="responsibility" :value="__('Tanggung Jawab')" />
        <textarea name="responsibility" id="responsibility" rows="4"
            class="block mt-1 w-full rounded-md border-black-300 focus:ring-2 focus:ring-blue-500 text-sm"
            required>{{ old('responsibility', $lowongan->responsibility) }}</textarea>
        @error('responsibility')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Kualifikasi Pendidikan --}}
    <div class="mb-4">
        <x-label-required for="kualifikasi" :value="__('Kualifikasi')" />
        <x-dropdown.kualifikasi-pendidikan
            :selected="old('kualifikasi', $lowongan->kualifikasi)"
            class="block mt-1 w-full text-sm" />
        @error('kualifikasi')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Detail Kualifikasi --}}
    <div class="mb-4">
        <x-label-required for="detailkualifikasi" :value="__('Detail Kualifikasi')" />
        <textarea name="detailkualifikasi" id="detailkualifikasi" rows="4"
            class="block mt-1 w-full rounded-md border-black-300 focus:ring-2 focus:ring-blue-500 text-sm"
            required>{{ old('detailkualifikasi', $lowongan->detailkualifikasi) }}</textarea>
        @error('detailkualifikasi')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- gaji --}}
    <div class="mb-4">
        <x-label-required for="gaji" :value="__('Gaji')" />
        <x-text-input id="gaji" name="gaji" type="text"
            :value="old('gaji', 'Rp ' . number_format((int) preg_replace('/[^0-9]/', '', $lowongan->gaji), 0, ',', '.'))"
            class="block mt-1 w-full text-sm" required />
        <p class="text-xs text-gray-500 mt-1">Masukkan nominal gaji. Contoh: Rp 5.000.000</p>
        @error('gaji')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Benefit --}}
    <div class="mb-4">
        <x-label-required for="benefit" :value="__('Benefit')" />
        <textarea name="benefit" id="benefit" rows="4"
            class="block mt-1 w-full rounded-md border-black-300 focus:ring-2 focus:ring-blue-500 text-sm"
            required>{{ old('benefit', $lowongan->benefit) }}</textarea>
        @error('benefit')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Deadline --}}
    <div class="mb-4">
        <x-label-required for="deadline" :value="__('Deadline')" />
        <x-text-input id="deadline" name="deadline" type="date"
            :value="old('deadline', $lowongan->deadline)"
            min="{{ date('Y-m-d') }}"
            class="block mt-1 w-full text-sm border-gray-300" required />
        @error('deadline')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Gambar Poster (Opsional) --}}
    <div class="mb-6">
        <label for="poster" class="block text-sm font-medium text-gray-700">Poster (opsional)</label>
        @if ($lowongan->poster)
        <div class="my-2">
            <img src="{{ asset('storage/' . $lowongan->poster) }}" alt="Poster Lowongan" class="w-32 rounded shadow-sm">
        </div>
        @endif
        <input type="file" name="poster" id="poster"
            class="block mt-1 w-full text-sm text-gray-600
                file:mr-4 file:py-2 file:px-4
                file:rounded-md file:border-0
                file:text-sm file:font-semibold
                file:bg-blue-50 file:text-blue-700
                hover:file:bg-blue-100">
        @error('poster')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Tombol Submit (ubah jadi button untuk intercept) --}}
    <div class="flex justify-end">
        <button type="button" id="btn-submit-update"
            class="bg-primaryColor hover:bg-darkBlue text-white text-sm font-semibold px-6 py-2.5 rounded-md transition shadow-customblue">
            Simpan Perubahan
        </button>
    </div>
</form>

{{-- Modal Konfirmasi Update --}}
<div id="modal-confirm-update" tabindex="-1"
    class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto backdrop-blur-md bg-black/30">
    <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-gray-200 transition-all duration-300 ease-out">

        {{-- Tombol Tutup --}}
        <button type="button"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full w-9 h-9 flex items-center justify-center transition"
            aria-label="Tutup" onclick="hideModalUpdate()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- Konten Modal --}}
        <div class="p-6 sm:p-8 text-center">
            {{-- Ikon Informasi --}}
            <div class="mx-auto mb-5 flex items-center justify-center w-16 h-16 rounded-full bg-yellow-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v2m0 4h.01M12 5a7 7 0 100 14 7 7 0 000-14z" />
                </svg>
            </div>

            <h3 class="text-xl font-semibold text-gray-800 mb-2">
                Simpan Perubahan Lowongan?
            </h3>
            <p class="text-sm text-gray-500 mb-6">
                Apakah kamu yakin ingin menyimpan perubahan pada lowongan ini? Pastikan semua data sudah benar.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <button type="button" id="confirm-update"
                    class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white bg-primaryColor hover:bg-darkBlue rounded-md shadow-customblue transition">
                    Ya, Simpan
                </button>

                <button type="button" onclick="hideModalUpdate()"
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
    const btnSubmitUpdate = document.getElementById('btn-submit-update');
    const formUpdate = document.getElementById('form-update-lowongan');
    const modalUpdate = document.getElementById('modal-confirm-update');
    const btnConfirmUpdate = document.getElementById('confirm-update');

    function showModalUpdate() {
        modalUpdate.classList.remove('hidden');
    }

    function hideModalUpdate() {
        modalUpdate.classList.add('hidden');
    }

    btnSubmitUpdate.addEventListener('click', () => {
        if (formUpdate.checkValidity()) {
            showModalUpdate();
        } else {
            formUpdate.reportValidity();
        }
    });

    btnConfirmUpdate.addEventListener('click', () => {
        formUpdate.submit();
    });
</script>
<script>
    document.getElementById('gaji').addEventListener('input', function(e) {
        this.value = this.value.replace(/\D/g, '');
    });
</script>
<script>
    const gajiInput = document.getElementById('gaji');

    gajiInput.addEventListener('input', function(e) {
        // Hilangkan semua karakter non-digit
        let value = this.value.replace(/[^0-9]/g, '');

        if (value) {
            // Format jadi ribuan
            let formatted = new Intl.NumberFormat('id-ID').format(value);
            this.value = 'Rp ' + formatted;
        } else {
            this.value = '';
        }
    });

    // Saat submit form, bersihkan Rp dan titik agar hanya angka tersimpan
    document.getElementById('form-update-lowongan').addEventListener('submit', function() {
        let cleanValue = gajiInput.value.replace(/[^0-9]/g, '');
        gajiInput.value = cleanValue;
    });
</script>


@endsection