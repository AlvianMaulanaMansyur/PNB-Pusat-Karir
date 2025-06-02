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
        <a href="javascript:history.back()" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium transition duration-300 mb-4">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Halaman Sebelumnya
        </a>
    </div>
</div>


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
                        {{-- Tombol Edit - Kuning --}}
                        <a href="{{ route('employer.edit-lowongan', $lowongan->slug) }}"
                            class="inline-block px-3 py-1 text-xs font-semibold text-gray-800 bg-[#FACC15] rounded hover:bg-yellow-400 transition">
                            Edit
                        </a>

                        {{-- Tombol Hapus - Merah --}}
                        <form action="{{ route('employer.destroy-lowongan', $lowongan->slug) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
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