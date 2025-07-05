<x-jobseeker-layout>
    <div class="max-w-screen-lg mx-auto px-5 my-10">

        {{-- alert --}}
        @foreach (['error', 'success', 'warning', 'info'] as $type)
            @if (session($type))
                <x-alert.session-alert :type="$type" :message="session($type)" />
            @endif
        @endforeach

        <a href="{{ route('employee.lowongan') }}" class="text-blue-500 underline mb-4 inline-block">← Kembali</a>

        <div class="border-2 border-gray-300 p-6 bg-white rounded-xl shadow space-y-5">
            {{-- Header --}}
            <div class="flex gap-6 items-start">
                <img src="{{ asset('storage/' . $job->employer->photo_profile) }}" alt="Foto perusahaan"
                    class="w-40 h-40 object-cover rounded-lg shadow-md border" />

                <div class="flex-1 items">
                    <h1 class="text-3xl font-bold text-primaryColor mb-1">{{ $job->nama_lowongan }}</h1>
                    <p class="text-xl text-gray-800">{{ $job->employer->company_name }}</p>
                    <p class="text-md text-gray-500">{{ $job->industry }}</p>
                    <p class="text-md text-gray-500 flex items-center gap-1 mt-1">
                        <i class="fa-solid fa-location-dot"></i> {{ $job->employer->alamat_perusahaan }}
                    </p>

                    {{-- Gaji + Jenis Lowongan --}}
                    <div class="mt-3 flex flex-wrap items-center gap-5">
                        <div class="flex items-center gap-2 text-sm text-gray-800">
                            <i class="fa-regular fa-money-bill-1"></i>
                            Rp. {{ number_format($job->gaji, 0, ',', '.') }}
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-800">
                            <i class="fa-solid fa-briefcase"></i>
                            {{ $job->jenislowongan }}
                        </div>
                        <div class="text-sm text-gray-800">
                            Batas: <span
                                class="bg-red-400 text-white px-1 rounded-full">{{ \Carbon\Carbon::parse($job->deadline)->format('d M Y') }}</span>

                        </div>
                    </div>
                    <div class="text-sm text-gray-500 mt-2">
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
                <h3 class="text-2xl font-semibold mb-2 text-gray-800">Deskripsi Pekerjaan</h3>
                <div class="text-xl text-gray-800 leading-relaxed whitespace-pre-line">
                    {{ $job->deskripsi }}
                </div>
            </div>

            {{-- Tanggung Jawab --}}
            <div>
                <h3 class="text-2xl font-semibold mb-2 text-gray-800">Tanggung Jawab</h3>
                <div class="text-xl text-gray-800 leading-relaxed whitespace-pre-line">
                    {!! nl2br(e($job->responsibility)) !!}
                </div>
            </div>

            {{-- Kualifikasi --}}
            <div>
                <h3 class="text-2xl font-semibold mb-2 text-gray-800">Kualifikasi</h3>
                <div class="text-xl text-gray-800 leading-relaxed whitespace-pre-line">
                    {!! nl2br(e($job->detailkualifikasi)) !!}

                </div>
            </div>

            {{-- Benefit --}}
            <div>
                <h3 class="text-2xl font-semibold mb-2 text-gray-800">Benefit</h3>
                <div class="text-xl text-gray-800 leading-relaxed whitespace-pre-line">
                    {!! nl2br(e($job->benefit)) !!}

                </div>
            </div>
        </div>


        <div x-data="{ showForm: false }" class=" rounded-lg p-5 my-6">
            <h3 class="text-gray-700 text-2xl font-bold mb-2"> Hati-hati Penipuan</h3>
            <p class="my-2 text-xl">Jangan berikan detail bank atau kartu kredit kamu saat mengirimkan lamaran kerja.
            </p>

            <button @click="showForm = !showForm"
                class="flex items-center text-xl text-gray-800 hover:text-gray-700 font-semibold transition underline mb-3">
                Laporkan iklan lowongan ini
                <svg :class="{ 'rotate-180': showForm }" class="w-4 h-4 ml-2 transition-transform duration-300"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="showForm" x-transition x-cloak class="mt-4">
                <form action="{{ route('report.job', $job->id) }}" method="POST" class="mt-8 space-y-4">
                    @csrf

                    {{-- Email Pelapor --}}
                    <div class="lg:col-span-3">
                        <x-label-required for="email" :value="__('Alamat Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            value="{{ Auth::user()->email }}" required readonly />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    {{-- dropdown alasan --}}
                    <div class="lg:col-span-3">
                        <x-label-required for="report_reason" :value="__('Alasan Laporan')" />
                        <x-dropdown.report-reasson name="report_reason" id="report_reason" :selected="old('report_reason')"
                            class="block mt-1 w-full " required />
                        <x-input-error :messages="$errors->get('report_reason')" class="mt-2" />
                    </div>

                    {{-- Detail Alasan Melapor --}}
                    <div class="lg:col-span-3">
                        <x-label-required for="reason" :value="__('Komentar Tambahan')" />
                        <x-text-area-input name="detailreason" id="detailreason"
                            class="w-full mt-1 placeholder:opacity-70" rows="4"
                            placeholder="Tulis alasan laporan..." required />
                        <div
                            class="flex gap-2 p-4 text-yellow-800 bg-yellow-50 border border-yellow-300 rounded-md mt-2">
                            <i class="fa-solid fa-triangle-exclamation mt-1"></i>
                            <p class="text-xl">
                                Untuk membantu mempercepat proses penyelidikan, kami akan sangat menghargai jika Anda
                                bisa menambahkan informasi lainnya yang menunjukkan bahwa iklan ini terindikasi sebagai
                                penipuan, menyesatkan, atau diskriminatif.
                            </p>
                        </div>
                        <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                    </div>

                    {{-- Tombol Kirim --}}
                    <div>
                        <x-primary-button type="submit">
                            {{ __('Laporkan Lowongan') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-jobseeker-layout>
