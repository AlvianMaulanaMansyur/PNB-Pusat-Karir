<x-jobseeker-layout>
    <!-- Hero Section with Parallax -->
    <section class="relative h-screen w-full overflow-hidden">
        <!-- Background Image with Parallax Effect -->
        <div class="absolute inset-0 bg-fixed bg-center bg-cover bg-no-repeat"
            style="background-image: url('{{ asset('images/campus.jpg') }}');">
            <div class="absolute inset-0 bg-black opacity-60"></div>
        </div>

        <!-- Content Centered -->
        <div class="relative z-10 h-full flex items-center justify-center text-center px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto px-4">
                <h1 class="text-white text-4xl sm:text-5xl md:text-4xl font-bold mb-6 leading-tight drop-shadow-lg">
                    Sistem Informasi Lowongan Kerja
                </h1>
                <p class="text-white text-lg sm:text-xl md:text-xl mb-8 drop-shadow-md">
                    Untuk Mahasiswa & Alumni Politeknik Negeri Bali
                </p>
                <a href="{{ route('employee.lowongan') }}"
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-8 rounded-lg transition duration-300 transform hover:scale-105">
                    Lihat Lowongan
                </a>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="bg-gradient-to-b from-blue-50 to-white py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Stats Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-20">
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300">
                    <div class="text-blue-600 text-4xl font-bold mb-3">500+</div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Perusahaan Mitra</h3>
                    <p class="text-gray-600">Bekerja sama dengan berbagai perusahaan terkemuka di berbagai industri</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300">
                    <div class="text-blue-600 text-4xl font-bold mb-3">2,000+</div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Lowongan Tersedia</h3>
                    <p class="text-gray-600">Berbagai posisi dari entry level hingga manajerial untuk alumni dan
                        mahasiswa</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300">
                    <div class="text-blue-600 text-4xl font-bold mb-3">85%</div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Tingkat Penempatan</h3>
                    <p class="text-gray-600">Alumni PNB yang mendapatkan pekerjaan melalui pusat karir kami</p>
                </div>
            </div>

            <!-- Job Listings Section -->
            <div id="lowongan" class="mb-20">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Lowongan Terbaru</h2>
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Lihat Semua →</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($jobs as $job)
                        <div
                            class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                            <div class="p-6">
                                <div class="flex items-center mb-4">
                                    <div>
                                        <h3 class="font-bold text-lg text-gray-800">{{ $job->nama_lowongan }}</h3>
                                        <p class="text-gray-600">{{ $job->jenislowongan }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span
                                        class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Rp.
                                        {{ number_format($job->gaji, 0, ',', '.') }}</span>
                                    <span
                                        class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $job->location }}</span>
                                    @if ($job->is_remote)
                                        <span
                                            class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded">Remote</span>
                                    @endif
                                </div>
                                <p class="text-gray-600 mb-4 line-clamp-2">{{ $job->description }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">Deadline:
                                        {{ \Carbon\Carbon::parse($job->deadline)->translatedFormat('F Y') }}
                                    </span>
                                    <a href="{{ route('employee.lowongan') }}"
                                        class="text-blue-600 hover:text-blue-800 font-medium text-sm">Detail →</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- How It Works Section -->
            <div class="mb-20">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Bagaimana Cara Kerjanya?</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="bg-blue-100 w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4">
                            <span class="text-blue-600 text-2xl font-bold">1</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Daftar Akun</h3>
                        <p class="text-gray-600">Buat akun sebagai alumni atau mahasiswa aktif PNB dengan verifikasi
                            email</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-blue-100 w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4">
                            <span class="text-blue-600 text-2xl font-bold">2</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Lengkapi Profil</h3>
                        <p class="text-gray-600">Isi data pendidikan, pengalaman, dan keahlian untuk rekomendasi
                            lowongan</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-blue-100 w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4">
                            <span class="text-blue-600 text-2xl font-bold">3</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Lamaran Kerja</h3>
                        <p class="text-gray-600">Temukan dan lamar pekerjaan yang sesuai, pantau status lamaran Anda</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-jobseeker-layout>
