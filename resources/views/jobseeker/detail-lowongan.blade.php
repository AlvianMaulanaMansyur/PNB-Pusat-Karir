<x-jobseeker-layout>
    <div class="max-w-screen-lg mx-auto px-5 my-10">
        <a href="{{ route('employee.lowongan') }}" class="text-blue-500 underline mb-4 inline-block">← Kembali</a>

        <div class="border-2 border-gray-300 p-6 bg-white rounded-xl shadow space-y-5">
            {{-- Header --}}
            <div class="flex gap-6 items-start">
                <img src="{{ asset('storage/' . $job->employer->photo_profile) }}" alt="Foto perusahaan"
                    class="w-40 h-40 object-cover rounded-lg shadow-md border" />

            <div class="flex-1 items">
                    <h1 class="text-2xl font-bold text-primaryColor mb-1">{{ $job->nama_lowongan }}</h1>
                    <p class="text-lg text-gray-800">{{ $job->employer->company_name }}</p>
                    <p class="text-sm text-gray-500">{{ $job->industry }}</p>
                    <p class="text-sm text-gray-500 flex items-center gap-1 mt-1">
                        <i class="fa-solid fa-location-dot text-red-500"></i> {{ $job->employer->alamat_perusahaan }}
                    </p>

                    {{-- Gaji + Jenis Lowongan --}}
                    <div class="mt-3 flex flex-wrap items-center gap-5">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="fa-regular fa-money-bill-1"></i>
                            Rp. {{ number_format($job->gaji, 0, ',', '.') }}
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="fa-solid fa-briefcase"></i>
                            {{ $job->jenislowongan }}
                        </div>
                        <div class="text-sm text-gray-600">
                            Batas: <span class="bg-red-400 text-white px-1 rounded-full">{{ \Carbon\Carbon::parse($job->deadline)->format('d M Y') }}</span>

                        </div>
                    </div>
                    <div class="text-xs text-gray-400 mt-2">
                        Diposting: {{ $job->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="flex gap-4 pt-3 border-t mt-4">
                    <a href="{{ route('job-apply', ['id' => $job->id]) }}" target="_blank">
                        <x-primary-button type="button">
                            {{ __('Lamar') }}
                        </x-primary-button>
                    </a>

                    <x-secondary-button>Simpan Lowongan</x-secondary-button>
            </div>


            {{-- Deskripsi --}}
            <div>
                <h3 class="text-lg font-semibold mb-2 text-gray-800">Deskripsi Pekerjaan</h3>
                <div class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                    {{{ $job->deskripsi }}}
                </div>
            </div>

            {{-- Tanggung Jawab --}}
            <div>
                <h3 class="text-lg font-semibold mb-2 text-gray-800">Tanggung Jawab</h3>
                <div class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                    {!! nl2br(e($job->responsibility)) !!}
                </div>
            </div>

            {{-- Kualifikasi --}}
            <div>
                <h3 class="text-lg font-semibold mb-2 text-gray-800">Kualifikasi</h3>
                <div class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                {!! nl2br(e($job->detailkualifikasi)) !!}

                </div>
            </div>

            {{-- Benefit --}}
            <div>
                <h3 class="text-lg font-semibold mb-2 text-gray-800">Benefit</h3>
                <div class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                {!! nl2br(e($job->benefit)) !!}

                </div>
            </div>
        </div>


        <div x-data="{ showForm: false }" class=" rounded-lg p-5 my-6">
            <h3 class="text-gray-700 text-lg font-bold mb-2"> Hati-hati Penipuan</h3>

            <button @click="showForm = !showForm"
                class="flex items-center text-sm text-gray-600 hover:text-gray-700 font-semibold transition mb-3">
                Laporkan iklan lowongan ini
                <svg :class="{ 'rotate-180': showForm }" class="w-4 h-4 ml-2 transition-transform duration-300"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="showForm" x-transition x-cloak class="mt-4">
                <form action="" method="POST" class="space-y-3">
                    @csrf
                    <div class="border border-gray-300 rounded-lg p-4 bg-gray-50 flex flex-col gap-4">

                        <input type="email" name="email" value="{{ $user->email }}" readonly
                            class="border border-gray-300 rounded-lg p-2 w-full bg-gray-100 text-gray-600 cursor-not-allowed">

                        <input type="text" name="report_reason" placeholder="Alasan pelaporan"
                            class="border border-gray-300 rounded-lg p-2 w-full placeholder:opacity-50" required>

                        <textarea name="additional_info" rows="3" placeholder="Informasi tambahan (opsional)"
                            class="border border-gray-300 rounded-lg p-2 w-full resize-none placeholder:opacity-50"></textarea>

                        <div class="flex gap-2">
                            <x-primary-button type="submit"
                                class="bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                Kirim Laporan
                            </x-primary-button>
                            <x-secondary-button type="button" @click="showForm = false"
                                class="text-gray-600 hover:underline text-sm mt-2">
                                Batal
                            </x-secondary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-jobseeker-layout>
