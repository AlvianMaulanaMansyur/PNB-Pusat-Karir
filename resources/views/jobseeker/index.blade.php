<x-jobseeker-layout>
    {{-- Notifikasi error --}}
    <x-alert.session-alert type="error" :message="session('error')" />

    {{-- Search bar --}}
    <div class="border-b py-10 w-full max-w-screen">
        @include('components.jobseeker.searchBar')
    </div>

    {{-- Main content --}}
    <div class="w-full max-w-screen-xl mx-auto mt-10">
        <div x-data="{
            selectedJob: null,
            goToDetail(job) {
                if (window.innerWidth < 768) {
                    window.location.href = '/job-detail/' + job.id;
                } else {
                    this.selectedJob = job;
                }
            },
            getDeadlineCountdown(deadline) {
                if (!deadline) return '-';
        
                const now = new Date();
                const target = new Date(deadline);
                const diffTime = target - now;
        
                if (diffTime <= 0) return 'Sudah lewat';
        
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                return `${diffDays} hari lagi`;
            },
        }" class="grid grid-cols-12 gap-4 min-h-screen">

            {{-- Kolom kiri: daftar lowongan --}}
            <div class="col-span-12 md:col-span-5 p-4 space-y-4">
                @foreach ($jobs as $job)
                    <div class="card p-6 border-4 rounded-3xl cursor-pointer transition-all duration-200"
                        :class="selectedJob?.id === {{ $job->id }} ?
                            'border-primaryColor ring-2 ring-primaryColor' :
                            'border-[#9A9A9A] hover:border-darkBlue'"
                        @click='goToDetail({
                            id: {{ $job->id }},
                            nama_lowongan: @json($job->nama_lowongan),
                            company_name: @json($job->employer->company_name),
                            industry: @json($job->employer->industry),
                            alamat_perusahaan: @json($job->employer->alamat_perusahaan ?? 'Alamat tidak tersedia'),
                            jenislowongan: @json($job->jenislowongan),
                            profile: @json(asset($job->profile)),
                            deskripsi: @json(nl2br(e($job->deskripsi))),
                            tanggung_jawab: @json(nl2br(e($job->responsibility))),
                            kualifikasi: @json($job->kualifikasi),
                            detail_kualifikasi: @json(nl2br(e($job->detailkualifikasi))),
                            gaji: @json($job->gaji),
                            benefit: @json(nl2br(e($job->benefit))),
                            photo_profile: @json(
                                $job->employer->photo_profile === 'images/default_employer.png'
                                    ? asset('images/default_employer.png')
                                    : asset('storage/' . $job->employer->photo_profile)),

                            deadline: @json($job->deadline),
                            poster: @json($job->poster),
                            created_at: @json($job->created_at->diffForHumans())
                        })'>


                        {{-- Poster dan informasi lowongan --}}
                        <div class="flex items-start space-x-4">
                            {{-- Proflie pic --}}
                            <div>
                                <img src="{{ $job->employer->photo_profile === 'images/default_employer.png'
                                    ? asset('images/default_employer.png')
                                    : asset('storage/' . $job->employer->photo_profile) }}"
                                    alt="Foto Profil"
                                    class="w-28 h-28 object-cover rounded-lg border border-gray-300 shadow-sm">
                            </div>

                            {{-- Informasi lowongan --}}
                            <div class="space-y-1">
                                <p class="text-2xl font-semibold">{{ $job->nama_lowongan }}</p>
                                <p class="text-gray-800">{{ $job->employer->company_name }}</p>
                                <div class="flex items-center">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                                        </svg>
                                        <div class="text-sm text-gray-600">{{ $job->employer->industry }}</div>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                    <div class="text-sm text-gray-600">
                                        {{ $job->employer->alamat_perusahaan ?? 'Alamat tidak tersedia' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- bubble kualifikasi --}}
                        <div class="flex  text-sm mt-4 space-x-2 items-center">
                            <div
                                class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-medium capitalize">
                                {{ $job->jenislowongan }}
                            </div>
                            <div
                                class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-medium capitalize">
                                {{ $job->posisi }}
                            </div>
                            <div
                                class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-medium capitalize">
                                {{ $job->kualifikasi }}
                            </div>

                        </div>
                        <span class="text-sm text-gray-500 flex items-center justify-end mt-2">
                            {{ $job->created_at->diffForHumans() }}
                        </span>
                    </div>
                @endforeach

                {{-- pagination  --}}
                @include('components.jobseeker.pagination', ['paginator' => $jobs])
            </div>

            {{-- Kolom kanan: detail lowongan (desktop only) --}}
            <div class="hidden md:block col-span-7 h-screen overflow-y-auto sticky top-0 p-4 ">
                <template x-if="selectedJob === null">
                    <div class="text-center text-gray-700 mt-20">
                        <p class="text-xl font-semibold">Pilih lowongan untuk ditampilkan</p>
                    </div>
                </template>

                <template x-if="selectedJob !== null">
                    <div class="card p-6 bg-white rounded-xl space-y-3">
                        {{-- foto --}}
                        <div class="flex mb-4">
                            <img :src="selectedJob.photo_profile" alt="profile pict"
                                class="w-32 h-32 object-cover rounded-lg shadow-md">
                        </div>
                        {{-- Judul yang bisa diklik ke halaman detail --}}
                        <a :href="'/job-detail/' + selectedJob.id"
                            class="text-3xl font-bold text-blue-700 underline block w-fit">
                            <span x-text="selectedJob.nama_lowongan"></span>
                        </a>

                        <p class="text-gray-800 text-xl" x-text="selectedJob.company_name"></p>

                        {{-- jenis industri --}}
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                            </svg>
                            <p class="text-lg text-gray-700" x-text="selectedJob.industry"></p>
                        </div>

                        {{-- Alamat Perusahaan --}}
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            <p class="text-lg text-gray-700" x-text="selectedJob.alamat_perusahaan"></p>
                        </div>

                        {{-- /Jenis Lowongan --}}
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>

                            <div class="text-lg text-gray-700" x-text="selectedJob.jenislowongan"></div>
                        </div>

                        {{-- Gaji --}}
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                            </svg>


                            <div class="text-lg text-gray-600"
                                x-text="'Rp. ' + Number(selectedJob.gaji).toLocaleString('id-ID')"></div>
                        </div>
                        <div class="text-lg text-gray-800">
                            Batas:
                            <span class="bg-red-600 text-white px-1 rounded-full"
                                x-text="new Date(selectedJob.deadline).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })">
                            </span>
                        </div>

                        {{-- poster --}}
                        <div class="text-lg text-gray-800">
                            Pamflet:
                            <template x-if="selectedJob.poster">
                                <a :href="'/storage/posters/' + selectedJob.poster" target="_blank"
                                    class="text-blue-600 hover:underline font-semibold">
                                    Lihat Informasi Lebih Lanjut
                                </a>

                            </template>
                            <template x-if="!selectedJob.poster">
                                <span class="text-gray-500">-</span>
                            </template>

                            <div class="text-md text-gray-400" x-text="selectedJob.created_at"></div>
                        </div>


                        {{-- button lamar --}}
                        <div class="py-6 flex">
                            <template x-if="new Date(selectedJob.deadline) > new Date()">
                                <a :href="'/id/apply-job/' + selectedJob.id" target="_blank">
                                    <x-primary-button>
                                        {{ __('Lamar') }}
                                    </x-primary-button>
                                </a>
                            </template>

                            <template x-if="new Date(selectedJob.deadline) <= new Date()">
                                <x-primary-button disabled class="bg-red-500 hover:bg opacity-50 cursor-not-allowed">
                                    Ditutup
                                </x-primary-button>
                            </template>
                            <x-secondary-button class="ml-2"
                                x-text="getDeadlineCountdown(selectedJob.deadline)"></x-secondary-button>
                        </div>

                        {{-- deskripsi --}}
                        <div>
                            <h3 class="text-2xl font-semibold mb-2">Deskripsi Pekerjaan</h3>
                            <div class="text-lg text-gray-800" x-html="selectedJob.deskripsi"></div>
                        </div>

                        {{-- Tanggung Jawab --}}
                        <div>
                            <h3 class="text-2xl font-semibold mb-2">Tanggung Jawab</h3>
                            <div class="text-lg text-gray-800" x-html="selectedJob.tanggung_jawab"></div>
                        </div>

                        {{-- Kualifikasi --}}
                        <div>
                            <h3 class="text-2xl font-semibold mb-2">Kualifikasi</h3>
                            <div class="text-lg text-gray-800" x-html="selectedJob.detail_kualifikasi"></div>
                        </div>

                        {{-- Benefit --}}
                        <div>
                            <h3 class="text-2xl font-semibold mb-2">Benefit</h3>
                            <div class="text-lg text-gray-800" x-html="selectedJob.benefit"></div>
                            {{-- <div class=""></div> --}}
                        </div>

                        <div x-data="{ showForm: false }" class=" rounded-lg p-5 my-6">
                            <h3 class="text-gray-700 text-2xl font-bold mb-2"> Hati-hati Penipuan</h3>
                            <p class="my-2 text-xl">Jangan berikan detail bank atau kartu kredit kamu saat
                                mengirimkan
                                lamaran kerja.
                            </p>

                            <button @click="showForm = !showForm"
                                class="flex items-center text-xl text-gray-800 hover:text-gray-700 font-semibold transition underline mb-3">
                                Laporkan iklan lowongan ini
                                <svg :class="{ 'rotate-180': showForm }"
                                    class="w-4 h-4 ml-2 transition-transform duration-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="showForm" x-transition x-cloak class="mt-4">
                                <form :action="'/report-job/' + selectedJob.id" method="POST"z`
                                    class="mt-8 space-y-4">
                                    @csrf

                                    {{-- Email Pelapor --}}
                                    <div class="lg:col-span-3">
                                        <x-label-required for="email" :value="__('Alamat Email')" />
                                        <x-text-input id="email" class="block mt-1 w-full" type="email"
                                            name="email" value="{{ Auth::user()->email }}" required readonly />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    {{-- dropdown alasan --}}
                                    <div class="lg:col-span-3">
                                        <x-label-required for="report_reason" :value="__('Alasan Laporan')" />
                                        <x-dropdown.report-reasson name="report_reason" id="report_reason"
                                            :selected="old('report_reason')" class="block mt-1 w-full " required />
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
                                                Untuk membantu mempercepat proses penyelidikan, kami akan sangat
                                                menghargai jika Anda
                                                bisa menambahkan informasi lainnya yang menunjukkan bahwa iklan ini
                                                terindikasi sebagai
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
                </template>

            </div>
        </div>
    </div>
</x-jobseeker-layout>
