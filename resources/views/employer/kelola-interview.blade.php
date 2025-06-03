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

        <a href="javascript:history.back()" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium transition duration-300 mb-6">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Halaman Sebelumnya
        </a>

        {{-- Tabel Interview dengan Data Dummy --}}
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
                    <tr class="border-b hover:bg-gray-100">
                        <td class="px-6 py-4">1</td>
                        <td class="px-6 py-4">Dewa Gede Pradnyana</td>
                        <td class="px-6 py-4">27 Mei 2025, 10:00</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded bg-yellow-300 text-yellow-800">Menunggu</span>
                        </td>
                        <td class="px-6 py-4 space-x-3">
                            <a href="#" class="text-blue-600 hover:underline text-sm">Detail</a>
                            <a href="#" class="text-blue-600 hover:underline text-sm">Jadwal Ulang</a>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-100">
                        <td class="px-6 py-4">2</td>
                        <td class="px-6 py-4">Ni Kadek Ayu Lestari</td>
                        <td class="px-6 py-4">28 Mei 2025, 14:30</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded bg-green-300 text-green-800">Dijadwalkan</span>
                        </td>
                        <td class="px-6 py-4 space-x-3">
                            <a href="#" class="text-blue-600 hover:underline text-sm">Detail</a>
                            <a href="#" class="text-blue-600 hover:underline text-sm">Jadwal Ulang</a>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-100">
                        <td class="px-6 py-4">3</td>
                        <td class="px-6 py-4">I Putu Wira Adnyana</td>
                        <td class="px-6 py-4">30 Mei 2025, 09:00</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded bg-yellow-300 text-yellow-800">Menunggu</span>
                        </td>
                        <td class="px-6 py-4 space-x-3">
                            <a href="#" class="text-blue-600 hover:underline text-sm">Detail</a>
                            <a href="#" class="text-blue-600 hover:underline text-sm">Jadwal Ulang</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>


@endsection