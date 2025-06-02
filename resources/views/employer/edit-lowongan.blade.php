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
<form action="{{ route('employer.update-lowongan', $lowongan->slug) }}" method="POST" enctype="multipart/form-data" class="w-full lg:w-2/3 mx-4 md:mx-10 lg:mx-20 lg:ml-28 bg-white p-6 rounded-lg shadow-md">
    @csrf
    @method('PUT')

    {{-- Nama Lowongan --}}
    <div class="mb-4">
        <x-label-required for="nama_lowongan" :value="__('Nama Lowongan')" />
        <x-text-input id="nama_lowongan" name="nama_lowongan" type="text"
            :value="old('nama_lowongan', $lowongan->nama_lowongan)"
            class="block mt-1 w-full text-sm" />
        @error('nama_lowongan')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Posisi --}}
    <div class="mb-4">
        <x-label-required for="posisi" :value="__('Posisi')" />
        <x-text-input id="posisi" name="posisi" type="text"
            :value="old('posisi', $lowongan->posisi)"
            class="block mt-1 w-full text-sm" />
        @error('posisi')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Jenis Lowongan --}}
    <div class="mb-4">
        <x-label-required for="jenislowongan" :value="__('Jenis Lowongan')" />
        <x-dropdown.jenis-lowongan
            :selected="old('jenislowongan', $lowongan->jenislowongan)"
            class="block mt-1 w-full text-sm border-gray-300" />
        @error('jenislowongan')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Deadline --}}
    <div class="mb-4">
        <x-label-required for="deadline" :value="__('Deadline')" />
        <x-text-input id="deadline" name="deadline" type="date"
            :value="old('deadline', $lowongan->deadline)"
            min="{{ date('Y-m-d') }}"
            class="block mt-1 w-full text-sm" />
        @error('deadline')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Kualifikasi --}}
    <div class="mb-4">
        <x-label-required for="kualifikasi" :value="__('Kualifikasi')" />
        <x-dropdown.kualifikasi-pendidikan
            :selected="old('kualifikasi', $lowongan->kualifikasi)"
            class="block mt-1 w-full text-sm" />
        @error('kualifikasi')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Deskripsi --}}
    <div class="mb-4">
        <x-label-required for="deskripsi" :value="__('Deskripsi')" />
        <textarea name="deskripsi" id="deskripsi" rows="4"
            class="block mt-1 w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('deskripsi', $lowongan->deskripsi) }}</textarea>
        @error('deskripsi')
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

    {{-- Tombol Submit --}}
    <div class="flex justify-end">
        <button type="submit"
            class="bg-primaryColor hover:bg-darkBlue text-white text-sm font-semibold px-6 py-2.5 rounded-md transition shadow-customblue">
            Simpan Perubahan
        </button>
    </div>
</form>


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

@endsection