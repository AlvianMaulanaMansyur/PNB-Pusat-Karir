<x-jobseeker-layout>

    <div class="border-b py-10 w-full max-w-screen">
        @include('components.jobseeker.searchBar')
    </div>
    <div class="w-full max-w-screen-xl mx-auto mt-10">
        <div x-data="{ selectedJob: null }" class="grid grid-cols-2 min-h-screen">
            {{-- Kolom 1: daftar lowongan --}}
            <div class="p-4 space-y-4">
                @foreach (range(1, 10) as $i)
                    <div class="card p-10 border cursor-pointer hover:bg-gray-100"
                        @click="selectedJob = {{ $i }}">
                        <p>Lowongan {{ $i }}</p>
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
