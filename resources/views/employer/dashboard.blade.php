@extends('employer.layouts.app')

@section('content')
    {{--  notifikasi error session --}}
    <x-alert.session-alert type="error" :message="session('error')" />

    {{-- Konten Utama --}}
    <div class="flex flex-col lg:flex-row items-center justify-between mt-20 2xl:mt-32 gap-12 px-10 lg:px-32">

        <div class="w-full lg:w-3/5 space-y-6">
            <p class="text-gray-600 text-lg 2xl:text-xl">Selamat datang di website</p>
            <h1 class="text-4xl 2xl:text-5xl font-bold text-gray-900">PNB Pusat Karir</h1>
            <p class="text-gray-700 text-base 2xl:text-lg leading-relaxed">
                PNB Pusat Karir adalah platform yang menyediakan informasi mengenai lowongan pekerjaan dan
                kesempatan magang bagi mahasiswa dan alumni Politeknik Negeri Bali.
            </p>
        </div>
        <div class="hidden lg:block w-[300px] 2xl:w-[420px]">
            <img src="{{ asset('images/HumanLogin.png') }}" alt="3D Human">
        </div>
    </div>
    {{-- Akses Halaman Cari Pelamar --}}
    {{-- CTA Temukan Kandidat --}}
    <div class="mt-40 px-10 lg:px-32">
        <a href="{{ route('employer.temukan-kandidat') }}"
            class="group flex items-center justify-between bg-white border border-indigo-100 rounded-2xl p-6 shadow-md transition duration-300 ease-in-out transform hover:shadow-lg hover:-translate-y-1 hover:border-indigo-300">

            {{-- Konten Kiri --}}
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-xl shadow transition duration-300 ease-in-out group-hover:bg-indigo-200 group-hover:rotate-6">
                    <i class="fas fa-search"></i>
                </div>
                <div>
                    <h3
                        class="text-base font-semibold text-gray-800 transition-colors duration-300 ease-in-out group-hover:text-indigo-700">
                        Temukan Kandidat
                    </h3>
                    <p class="text-sm text-gray-500">
                        Telusuri pelamar berdasarkan skill dan pengalaman yang sesuai kebutuhan Anda.
                    </p>
                </div>
            </div>

            {{-- Chevron kanan --}}
            <i
                class="fas fa-chevron-right text-gray-400 text-base transition duration-300 ease-in-out group-hover:text-indigo-600 group-hover:translate-x-1"></i>
        </a>
    </div>
    {{-- Box Informasi Tambahan --}}
    <div class="mt-6 px-10 lg:px-32">
        <div class="bg-white border border-blue-200 rounded-xl shadow-md p-6">
            <div class="flex items-center mb-3">
                <i class="fas fa-info-circle text-blue-500 text-2xl mr-3"></i>
                <h3 class="text-xl font-semibold text-gray-800">Informasi Tambahan</h3>
            </div>
            <p class="text-gray-600 text-base">
                Halaman ini dirancang khusus untuk employer guna mempermudah dalam mengelola lowongan pekerjaan. Melalui
                halaman ini, employer dapat menambahkan lowongan baru, mengelola lowongan yang sudah dipublikasikan, serta
                melihat daftar pelamar yang telah mengajukan diri.
            </p>
        </div>
    </div>

    {{-- Fitur Tersedia --}}
    <div class="mt-24 flex justify-center">
        <div class="bg-white border border-indigo-100 rounded-2xl shadow-lg px-6 py-6 text-center w-full sm:w-3/4 lg:w-1/2" data-aos="fade-up">
            <h2 class="text-2xl font-semibold text-gray-800 mb-1">Fitur-fitur yang Tersedia</h2>
            <p class="text-sm text-gray-500">Berbagai alat bantu untuk mempermudah proses rekrutmen Anda.</p>
        </div>
    </div>

    {{-- Box Fungsional --}}
    <div class="mt-12 flex flex-wrap justify-center gap-6 px-10 lg:px-32">

        <!-- Tambah Lowongan -->
        <a href="{{ route('employer.tambahlowongan') }}"
            class="group bg-gradient-to-br from-green-400 to-green-500 hover:from-green-500 hover:to-green-600 text-white w-full sm:w-1/3 md:w-1/4 lg:w-1/5 rounded-xl p-5 text-center shadow-md transition-all duration-300 hover:scale-105"
            data-aos="fade-up" data-aos-delay="100">
            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3 transition-transform group-hover:scale-110">
                <i class="fas fa-plus-circle text-2xl text-white"></i>
            </div>
            <h3 class="text-base font-semibold mb-1">Tambah Lowongan</h3>
            <p class="text-sm text-white/90">Buat dan publikasikan lowongan baru dengan cepat.</p>
        </a>

        <!-- Manajemen Lowongan -->
        <a href="{{ route('employer.manajemen-lowongan') }}"
            class="group bg-gradient-to-br from-yellow-300 to-yellow-400 hover:from-yellow-400 hover:to-yellow-500 text-gray-800 w-full sm:w-1/3 md:w-1/4 lg:w-1/5 rounded-xl p-5 text-center shadow-md transition-all duration-300 hover:scale-105"
            data-aos="fade-up" data-aos-delay="200">
            <div class="w-12 h-12 bg-white/30 rounded-full flex items-center justify-center mx-auto mb-3 transition-transform group-hover:scale-110">
                <i class="fas fa-tasks text-2xl text-gray-800"></i>
            </div>
            <h3 class="text-base font-semibold mb-1">Manajemen Lowongan</h3>
            <p class="text-sm text-gray-700">Kelola semua lowongan Anda disini.</p>
        </a>

        <!-- Pelamar Lowongan -->
        <a href="{{ route('employer.pelamar-lowongan', ['slug' => auth()->user()->employer->slug]) }}"
            class="group bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white w-full sm:w-1/3 md:w-1/4 lg:w-1/5 rounded-xl p-5 text-center shadow-md transition-all duration-300 hover:scale-105"
            data-aos="fade-up" data-aos-delay="300">
            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3 transition-transform group-hover:scale-110">
                <i class="fas fa-users text-2xl text-white"></i>
            </div>
            <h3 class="text-base font-semibold mb-1">Pelamar Lowongan</h3>
            <p class="text-sm text-white/90">Lihat daftar pelamar dan kelola proses seleksi.</p>
        </a>

    </div>

    {{-- Detail fitur tambahan --}}
    <div class="mt-20 px-10 lg:px-32">
        <div class="flex flex-col lg:flex-row gap-12 items-center justify-end">
            <!-- Gambar kiri agak ke tengah -->
            <div class="hidden lg:block w-[300px] 2xl:w-[420px] ml-16">
                <img src="{{ asset('images/people.png') }}" alt="3D Human" class="w-full h-auto">
            </div>

            <!-- Semua box fitur di kanan -->
            <div class="w-full lg:w-3/4 max-w-[950px] ml-auto space-y-10">
                <!-- Box 1 -->
                <div class="bg-green-50 border border-green-300 rounded-xl p-6 shadow-md">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-plus-circle text-green-500 text-2xl mr-3"></i>
                        <h3 class="text-lg font-semibold text-green-800">Tambah Lowongan</h3>
                    </div>
                    <p class="text-green-700 text-base">
                        Fitur ini memungkinkan employer untuk menambahkan lowongan pekerjaan baru ke dalam sistem. Employer
                        dapat mengisi informasi seperti judul lowongan, deskripsi, kualifikasi, dan tanggal kadaluwarsa
                        lowongan.
                    </p>
                </div>

                <!-- Box 2 -->
                <div class="bg-yellow-50 border border-yellow-300 rounded-xl p-6 shadow-md">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-tasks text-yellow-500 text-2xl mr-3"></i>
                        <h3 class="text-lg font-semibold text-yellow-800">Manajemen Lowongan</h3>
                    </div>
                    <p class="text-yellow-700 text-base">
                        Fitur ini menyediakan antarmuka bagi employer untuk mengelola semua lowongan yang telah
                        dipublikasikan. Employer dapat mengedit, menghapus, atau memperpanjang masa aktif lowongan sesuai
                        kebutuhan.
                    </p>
                </div>

                <!-- Box 3 -->
                <div class="bg-blue-50 border border-blue-300 rounded-xl p-6 shadow-md">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-users text-blue-500 text-2xl mr-3"></i>
                        <h3 class="text-lg font-semibold text-blue-800">Pelamar Lowongan</h3>
                    </div>
                    <p class="text-blue-700 text-base">
                        Fitur ini memungkinkan employer untuk melihat daftar pelamar yang sudah mengajukan lamaran ke
                        lowongan yang dipublikasikan. Employer dapat meninjau CV dan dokumen lain yang dilampirkan pelamar.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Kembali ke Atas -->
    <button id="backToTop" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
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
