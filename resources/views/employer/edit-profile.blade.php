@extends('employer.layouts.app')

@section('content')

{{-- Header Judul Halaman --}}
<div class="flex flex-col w-full lg:w-2/3 text-left mx-4 md:mx-10 lg:mx-20 lg:ml-28">
    <p class="my-3 text-md 2xl:text-xl text-gray-600">Kelola informasi profil Anda di sini</p>
    <p class="font-semibold text-xl 2xl:text-3xl my-2 text-gray-800">Edit Profil</p>
    <div class="w-20 h-1 bg-blue-500 rounded mb-4"></div>

    <!-- Box Informasi Tambahan Employer -->
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 mb-4 rounded shadow-sm text-yellow-900">
        <h3 class="font-semibold text-lg mb-2">Catatan Penting untuk Edit Profil Employer</h3>
        <ul class="list-disc list-inside space-y-1 text-sm">
            <li>Pastikan informasi kontak perusahaan seperti email dan nomor telepon selalu aktif dan dapat dihubungi.</li>
            <li>Gunakan alamat lengkap dan valid agar pelamar dapat mengetahui lokasi kantor dengan jelas.</li>
            <li>Periksa kembali nama perusahaan dan deskripsi agar sesuai dengan profil bisnis Anda.</li>
            <li>Setelah melakukan perubahan, jangan lupa klik tombol <strong>Simpan Perubahan</strong> untuk menyimpan data.</li>
            <li>Profil yang lengkap dan akurat akan meningkatkan kepercayaan pelamar terhadap perusahaan Anda.</li>
        </ul>
    </div>

    <a href="javascript:history.back()"
        class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium mt-2 transition duration-300">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Halaman Sebelumnya
    </a>
</div>

{{-- Form Edit Profil Employer (Kosong) --}}
<div class="w-full lg:w-2/3 bg-white p-6 mt-6 rounded-xl shadow-md border border-gray-200 mx-4 md:mx-10 lg:mx-20 lg:ml-28">
    <form action="#" method="POST">
        @csrf
        @method('PUT')

        <!-- Nama -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2" for="nama">
                <i class="fas fa-building mr-2 text-blue-500"></i> Nama
            </label>
            <input type="text" name="nama" id="nama" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Nama Perusahaan -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2" for="nama_perusahaan">
                <i class="fas fa-building mr-2 text-blue-500"></i> Nama Perusahaan
            </label>
            <input type="text" name="nama_perusahaan" id="nama_perusahaan" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Email Perusahaan -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2" for="email">
                <i class="fas fa-envelope mr-2 text-blue-500"></i> Email Perusahaan
            </label>
            <input type="email" name="email" id="email" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Deskripsi singkat Perusahaan -->
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2" for="deskripsi">
                <i class="fas fa-align-left mr-2 text-blue-500"></i> Deskripsi Singkat Perusahaan
            </label>
            <textarea name="deskripsi" id="deskripsi" rows="4" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
        </div>

        <!-- Alamat -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2" for="alamat">
                <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i> Alamat
            </label>
            <textarea name="alamat" id="alamat" rows="3" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
        </div>

        <!-- Provinsi -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2" for="Provinsi">
                <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i> Provinsi
            </label>
            <textarea name="Provinsi" id="Provinsi" rows="3" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
        </div>

        <!-- kabupaten atau kota -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2" for="kabupaten">
                <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i> Kabupaten/Kota
            </label>
            <textarea name="kabupaten" id="kabupaten" rows="3" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
        </div>


        <!-- Tombol Simpan -->
        <div class="text-right">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-300">
                Simpan Perubahan
            </button>
        </div>
    </form>
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