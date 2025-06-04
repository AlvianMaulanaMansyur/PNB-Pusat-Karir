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
            goToDetail(jobId) {
                if (window.innerWidth < 768) {
                    window.location.href = '/job-detail/' + jobId;
                } else {
                    this.selectedJob = jobId;
                }
            }
        }" class="grid grid-cols-12 gap-4 min-h-screen">
            {{-- Kolom kiri: daftar lowongan --}}
            <div class="col-span-12 md:col-span-5 p-4 space-y-4">
                @foreach ($jobs as $job)
                    <div class="card p-6 border-4 border-[#9A9A9A] cursor-pointer rounded-3xl hover:border-darkBlue"
                        @click="goToDetail({{ $job->id }})">
                        <div class="flex items-start space-x-4">
                            {{-- Poster --}}
                            <div>
                                @if ($job->photo_profile)
                                    <img src="{{ asset('storage/' . $job->profile) }}" alt="Poster"
                                        class="w-28 h-28 object-cover rounded-md border">
                                @else
                                    <span class="text-gray-400 italic">Tidak ada poster</span>
                                @endif
                            </div>

                            {{-- Informasi lowongan --}}
                            <div class="space-y-1">
                                <p class="text-2xl font-semibold">{{ $job->nama_lowongan }}</p>
                                <p class="text-gray-800">{{ $job->employer->company_name }}</p>

                                <div class="flex items-center text-sm text-gray-600">

                                    <span>{{ $job->employer->industry }}</span>
                                </div>

                                <div class="flex items-center text-sm text-gray-600">

                                    <span>{{ $job->employer->alamat_perusahaan ?? 'Alamat tidak tersedia' }}</span>
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
            </div>

            {{-- Kolom kanan: detail lowongan (desktop only) --}}
            <div class="hidden md:block col-span-7 h-screen overflow-y-auto sticky top-0 p-4 bg-gray-100">
                <template x-if="selectedJob === null">
                    <div class="text-center text-gray-500 mt-20">
                        <p class="text-xl font-semibold">Pilih lowongan untuk ditampilkan</p>
                    </div>
                </template>

                <template x-if="selectedJob !== null">
                    <div class="card border p-6 bg-white rounded-xl">
                        <h2 class="text-2xl font-bold mb-4">Detail Lowongan</h2>
                        <p>Ini adalah detail dari lowongan dengan ID <span x-text="selectedJob"></span>.</p>
                        <div class="mt-6 text-sm text-gray-400">Scroll untuk lihat lebih banyak...</div>
                        <div class="h-[800px] bg-gray-200 mt-4 rounded-md"></div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</x-jobseeker-layout>
