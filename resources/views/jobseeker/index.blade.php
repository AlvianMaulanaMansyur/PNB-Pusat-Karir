<x-jobseeker-layout>

    <x-alert.session-alert type="error" :message="session('error')" />
    <div class="border-b py-10 w-full max-w-screen">
        @include('components.jobseeker.searchBar')
    </div>
    <div class="w-full max-w-screen-xl mx-auto mt-10">
        <x-alert type="success" :message="session('success')" />
        <div x-data="{ selectedJob: null }" class="grid grid-cols-2 min-h-screen">
            {{-- Kolom 1: daftar lowongan --}}
            <div class="p-4 space-y-4 ">
                @foreach ($jobs as $job)
                    <div class="card p-10 border-2 border-[#9A9A9A] cursor-pointer rounded-3xl "
                        @click="selectedJob = {{ $job->id }}">
                        <div class="flex items-start space-x-4">
                            {{-- Poster --}}
                            <div class="">
                                @if ($job->poster)
                                    <img src="{{ asset('storage/' . $job->poster) }}" alt="Poster"
                                        class="w-28 h-28 object-cover rounded-md border">
                                @else
                                    <span class="text-gray-400 italic">Tidak ada poster</span>
                                @endif
                            </div>

                            {{-- Informasi Lowongan --}}
                            <div class="space-y-1">
                                <p class="text-2xl font-semibold">{{ $job->nama_lowongan }}</p>
                                <p class="text-gray-800">{{ $job->employer->company_name }}</p>

                                <div class="flex items-center text-sm text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-5 h-5 mr-1"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                                    </svg>
                                    <span>{{ $job->employer->industry }}</span>
                                </div>

                                <div class="flex items-center text-sm text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-5 h-5 mr-1"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                    <span>{{ $job->employer->alamat ?? 'Alamat tidak tersedia' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex text-sm mt-4 space-x-2 items-center">
                            <div
                                class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-medium capitalize">
                                {{ $job->jenislowongan }}
                            </div>
                        </div>
                        <span class="text-sm text-gray-500 flex items-center justify-end mb-0  mt-2">
                            {{ $job->created_at->diffForHumans() }}
                        </span>

                    </div>
                @endforeach
            </div>

            {{-- Kolom 2: konten dinamis --}}
            <div class="h-screen overflow-y-auto sticky top-0 p-4 bg-gray-100">
                <template x-if="selectedJob === null">
                    <div class="text-center text-gray-500 mt-20">
                        <p class="text-xl font-semibold">Pilih lowongan untuk ditampilkan</p>
                    </div>
                </template>

                <template x-if="selectedJob !== null">
                    <div class="card border p-6">
                        <h2 class="text-2xl font-bold mb-4">Detail Lowongan</h2>
                        <p>Ini adalah detail dari lowongan ke-<span x-text="selectedJob"></span>.</p>
                        <div class="mt-6 text-sm text-gray-400">Scroll untuk lihat lebih banyak...</div>
                        <div class="h-[1500px] bg-gray-200 mt-4"></div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</x-jobseeker-layout>
