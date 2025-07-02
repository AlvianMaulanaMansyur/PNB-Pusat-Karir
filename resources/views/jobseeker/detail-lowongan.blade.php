<x-jobseeker-layout>
    <div class="max-w-[1280px] mx-auto px-5 mt-10">
        <a href="{{ url()->previous() }}" class="text-blue-500 underline mb-4 inline-block">← Kembali</a>

        <div class="card border-2 p-6 bg-white rounded-xl space-y-3">
            {{-- Foto --}}
            <div class="flex mb-4">
                <img src="{{ asset('storage/' . $job->employer->photo_profile) }}" alt="Poster lowongan"
                    class="w-24 h-24 object-cover rounded-lg shadow-md">
            </div>

            {{-- Judul --}}
            <a href="{{ url('/job-detail/' . $job->id) }}"
                class="text-2xl font-bold text-blue-700 hover:underline block w-fit">
                {{ $job->nama_lowongan }}
            </a>

            {{-- Nama Perusahaan --}}
            <p class="text-gray-800 text-lg">{{ $job->employer->company_name }}</p>

            {{-- Jenis Industri --}}
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                </svg>
                <p class="text-sm text-gray-500">{{ $job->industry }}</p>
            </div>

            {{-- Alamat Perusahaan --}}
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
                <p class="text-sm text-gray-500">{{ $job->employer->alamat_perusahaan }}</p>
            </div>

            {{-- Jenis Lowongan --}}
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <div class="text-sm text-gray-600">{{ $job->jenislowongan }}</div>
            </div>

            {{-- Gaji --}}
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                </svg>
                <div class="text-sm text-gray-600">
                    Rp. {{ number_format($job->gaji, 0, ',', '.') }}
                </div>
            </div>

            <div class="text-xs text-gray-400">{{ $job->created_at }}</div>

            {{-- Tombol --}}
            <div class="py-6">
                <x-primary-button>Lamar Cepat</x-primary-button>
                <x-secondary-button class="ml-2">Simpan</x-secondary-button>
            </div>

            {{-- Deskripsi --}}
            <div>
                <h3 class="text-lg font-semibold mb-2">Deskripsi Pekerjaan</h3>
                <div class="text-sm text-gray-400">{{ $job->deskripsi }}</div>
            </div>

            {{-- Tanggung Jawab --}}
            <div>
                <h3 class="text-lg font-semibold mb-2">Tanggung Jawab</h3>
                <div class="text-sm text-gray-400">{{ $job->tanggung_jawab }}</div>
            </div>

            {{-- Kualifikasi --}}
            <div>
                <h3 class="text-lg font-semibold mb-2">Kualifikasi</h3>
                <div class="text-sm text-gray-400">{{ $job->detail_kualifikasi }}</div>
            </div>

            {{-- Benefit --}}
            <div>
                <h3 class="text-lg font-semibold mb-2">Benefit</h3>
                <div class="text-sm text-gray-400">{{ $job->benefit }}</div>
            </div>
        </div>
    </div>
</x-jobseeker-layout>
