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

{{-- Konten Utama: Form + Box Info --}}
<div class="flex flex-col lg:flex-row justify-start mt-10 mx-4 md:mx-10 lg:mx-20 lg:ml-28 gap-8">

    {{-- Form Tambah Lowongan --}}
    <div class="w-full lg:w-2/3 bg-white p-6 rounded-xl shadow-md border border-gray-200">
        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Nama Lowongan -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="nama_lowongan">
                    <i class="fas fa-briefcase mr-2 text-blue-500"></i> Nama Lowongan
                </label>
                <input type="text" name="nama_lowongan" id="nama_lowongan" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Deskripsi -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="deskripsi">
                    <i class="fas fa-align-left mr-2 text-blue-500"></i> Deskripsi Pekerjaan
                </label>
                <textarea name="deskripsi" id="deskripsi" rows="5" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
            </div>

            <!-- Posisi Lowongan -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="posisi">
                    <i class="fas fa-user-tie mr-2 text-blue-500"></i> Posisi Lowongan
                </label>
                <input type="text" name="posisi" id="posisi" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Kualifikasi -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="kualifikasi">
                    <i class="fas fa-graduation-cap mr-2 text-blue-500"></i> Kualifikasi
                </label>
                <input type="text" name="kualifikasi" id="kualifikasi" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Jenis Lowongan -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="jenis">
                    <i class="fas fa-clipboard-list mr-2 text-blue-500"></i> Jenis Lowongan
                </label>
                <input type="text" name="jenis" id="jenis" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Tanggal Deadline -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2" for="deadline">
                    <i class="fas fa-calendar-alt mr-2 text-blue-500"></i> Batas Pendaftaran
                </label>
                <input type="date" name="deadline" id="deadline" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Poster atau Flayer -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2" for="poster">
                    <i class="fas fa-image mr-2 text-blue-500"></i> Poster atau Flayer
                </label>
                <input type="file" name="poster" id="poster" accept="image/*" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Tombol Submit -->
            <div class="text-right">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-300">
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