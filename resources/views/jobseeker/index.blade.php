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
            }
        }" class="grid grid-cols-12 gap-4 min-h-screen">

            {{-- Kolom kiri: daftar lowongan --}}
            <div class="col-span-12 md:col-span-5 p-4 space-y-4">
                @foreach ($jobs as $job)
                    <div class="card p-6 border-4 border-[#9A9A9A] cursor-pointer rounded-3xl hover:border-darkBlue"
                        @click='goToDetail({
                            id: {{ $job->id }},
                            nama_lowongan: @json($job->nama_lowongan),
                            company_name: @json($job->employer->company_name),
                            industry: @json($job->employer->industry),
                            alamat_perusahaan: @json($job->employer->alamat_perusahaan ?? 'Alamat tidak tersedia'),
                            jenislowongan: @json($job->jenislowongan),
                            profile: @json(asset($job->profile)),
                            deskripsi: @json($job->deskripsi),
                            photo_profile: @json(asset($job->employer->photo_profile)),
                            created_at: @json($job->created_at->diffForHumans())
                        })'>
                        {{-- Poster dan informasi lowongan --}}
                        <div class="flex items-start space-x-4">
                            {{-- Poster --}}
                            <div>
                                <img src="{{ asset($job->employer->photo_profile) }}" alt="Poster lowongan"
                                    class="w-24 h-24 object-cover rounded-lg shadow-md">
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

                        <div class="flex text-sm mt-4 space-x-2 items-center">
                            <div
                                class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-medium capitalize">
                                {{ $job->jenislowongan }}
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
                    <div class="text-center text-gray-500 mt-20">
                        <p class="text-xl font-semibold">Pilih lowongan untuk ditampilkan</p>
                    </div>
                </template>

                <template x-if="selectedJob !== null">
                    <div class="card border-2 p-6 bg-white rounded-xl space-y-3">
                        {{-- foto --}}
                        <div class="flex mb-4">
                            <img :src="selectedJob.photo_profile" alt="Poster lowongan"
                                class="w-32 h-32 object-cover rounded-lg shadow-md">
                        </div>
                        {{-- Judul yang bisa diklik ke halaman detail --}}
                        <a :href="'/job-detail/' + selectedJob.id"
                            class="text-2xl font-bold text-blue-700 hover:underline block w-fit">
                            <span x-text="selectedJob.nama_lowongan"></span>
                        </a>

                        <p class="text-gray-800 text-lg" x-text="selectedJob.company_name"></p>

                        {{-- jenis industri --}}
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                            </svg>
                            <p class="text-sm text-gray-500" x-text="selectedJob.industry"></p>
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
                            <p class="text-sm text-gray-500" x-text="selectedJob.alamat_perusahaan"></p>
                        </div>

                        {{-- /Jenis Lowongan --}}
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>

                            <div class="text-sm text-gray-600" x-text="selectedJob.jenislowongan"></div>
                        </div>

                        <div class="text-xs text-gray-400" x-text="selectedJob.created_at"></div>

                        {{-- button lamar dan save --}}
                        <div class="py-6">
                            <x-primary-button>Lamar Cepat</x-primary-button>
                            <x-secondary-button class="ml-2">Simpan</x-secondary-button>
                        </div>

                        {{-- poster --}}

                        {{-- deskripsi --}}
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Deskripsi Pekerjaan</h3>
                            <div class="text-sm text-gray-400" x-text="selectedJob.deskripsi"></div>
                        </div>

                        {{-- Tanggung Jawab --}}
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Tanggung Jawab</h3>
                            <div class="text-sm text-gray-400">Tanggung jawab pekerjaan akan ditampilkan di sini...
                            </div>
                        </div>

                        {{-- Kualifikasi --}}
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Kualifikasi</h3>
                            <div class="text-sm text-gray-400">Kualifikasi pekerjaan akan ditampilkan di sini...
                            </div>
                        </div>

                        {{-- Benefit --}}
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Benefit</h3>
                            <div class="text-sm text-gray-400">Benefit pekerjaan akan ditampilkan di sini...</div>
                            {{-- <div class=""></div> --}}
                        </div>
                </template>

            </div>
        </div>
    </div>
</x-jobseeker-layout>
