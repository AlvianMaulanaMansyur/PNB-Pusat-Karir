<x-jobseeker-layout>
    <div x-data="{
        showSidebar: false,
        selected: null,
        highlightedId: null,
        init() {
            const urlParams = new URLSearchParams(window.location.search);
            const selectedId = urlParams.get('selected');
            if (selectedId) {
                this.highlightedId = parseInt(selectedId);

                // Scroll ke elemen
                this.$nextTick(() => {
                    const el = document.getElementById(`job-card-${this.highlightedId}`);
                    if (el) {
                        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        // Hapus highlight setelah 1.5 detik
                        setTimeout(() => {
                            this.highlightedId = null;
                        }, 1500);
                    }
                });
            }
        }
    }" x-init="init() window.history.replaceState({}, document.title, window.location.pathname);" class="relative">
        {{-- ========= MAIN CONTENT ========= --}}
        <div class="py-3 px-20 ">
            {{-- Breadcrumb Navigation --}}
            <x-breadcrumb :links="[['label' => 'Home', 'url' => route('employee.lowongan')], ['label' => 'Dilamar']]" />
        </div>
        <h1 class="text-xl text-gray-800 mb-6 font-semibold">Aktivitas</h1>
        <div class="w-full px-4 sm:px-6 lg:px-8 mt-10 mb-5">

            @foreach ($jobApplied as $key)
                <section id="job-card-{{ $key->id }}"
                    class="max-w-2xl mx-auto bg-white/70 backdrop-blur-md border border-gray-200 rounded-2xl p-6 shadow-lg my-6 transition duration-300"
                    :class="{ 'animate-pulse': highlightedId === {{ $key->id }} }">

                    <p class="text-xs text-gray-600"> Melamar untuk posisi:</p>

                    <div class="flex justify-between items-start mb-4">
                        <div>
                            {{-- NAMA LOWONGAN KLIKABLE --}}
                            <button @click="showSidebar = true; selected = {{ $key->id }}"
                                class="text-2xl font-semibold text-primaryColor underline hover:text-blue-700 transition duration-200">
                                {{ $key->job->nama_lowongan }}
                            </button>

                            <p class="text-sm text-gray-700">
                                <i class="fa-solid fa-building text-gray-500 mr-1"></i>
                                {{ $key->job->employer->company_name }}
                            </p>
                            <p class="text-sm text-gray-700">
                                <i class="fa-solid fa-location-dot text-red-400 mr-1"></i>
                                {{ $key->job->employer->alamat_perusahaan }}
                            </p>
                            <p class="text-sm text-gray-700">
                                <i class="fa-regular fa-money-bill-1 mr-1"></i>
                                <span class="font-semibold">Rp. {{ number_format($key->job->gaji, 0, ',', '.') }}</span>
                                per bulan
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="text-xs text-gray-500">Dilamar pada:</p>
                            <p class="text-sm font-medium text-gray-800">
                                <i class="fa-solid fa-calendar-days mr-1 text-gray-500"></i>
                                {{ $key->created_at->format('d F Y') }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-gray-700">
                            <i class="fa-solid fa-circle-info text-indigo-400 mr-1"></i>Status:
                        </p>
                        <x-status-badge :status="$key->status" :deadline="$key->job->deadline" />
                    </div>
                </section>
            @endforeach
        </div>

        {{-- ========= OVERLAY HITAM ========= --}}
        <template x-if="showSidebar">
            <div @click="showSidebar = false" class="fixed inset-0 bg-black bg-opacity-50 z-40"
                x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
        </template>

        {{-- ========= SIDEBAR DETAIL ========= --}}
        <template x-if="showSidebar">
            <div class="fixed inset-y-0 right-0 w-[85%] max-w-4xl bg-white border-l border-gray-200 shadow-xl z-50 p-6 overflow-y-auto"
                x-transition:enter="transform transition ease-out duration-300"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in duration-200" x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full">
                <button @click="showSidebar = false"
                    class="mb-4 text-sm text-gray-500 hover:text-red-600 font-semibold">
                    ← Kembali
                </button>

                @foreach ($jobApplied as $key)
                    <div x-show="selected === {{ $key->id }}" x-cloak>
                        <p class="text-lg text-gray-600">Lamaran untuk</p>

                        <h2 class="text-2xl font-bold text-primaryColor mb-2">
                            {{ $key->job->nama_lowongan }}
                        </h2>
                        <div class="text-lg text-gray-700 space-y-2">
                            <p><strong>Perusahaan:</strong> {{ $key->job->employer->company_name }}</p>
                            <p><strong>Alamat:</strong> {{ $key->job->employer->alamat_perusahaan }}</p>
                            <p><strong>Gaji:</strong> Rp. {{ number_format($key->job->gaji, 0, ',', '.') }}</p>

                            <hr class="my-3">

                            <p><strong>Status:</strong> <x-status-badge :status="$key->status" :deadline="$key->job->deadline" /></p>
                            <p><strong>Dilamar pada:</strong> {{ $key->created_at->format('d F Y') }}</p>

                            <p>Dokumen terkirim</p>

                            <div class="flex text-md gap-2 items-center">
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11.6998 22.1001H5.69979C4.37431 22.1001 3.2998 21.0256 3.2998 19.7001L3.2999 5.30013C3.29991 3.97466 4.37442 2.90015 5.6999 2.90015H16.5002C17.8256 2.90015 18.9002 3.97466 18.9002 5.30015V10.1001M7.50018 7.70015H14.7002M7.50018 11.3001H14.7002M14.7002 16.0541V18.9985C14.7002 20.4534 16.2516 21.7879 17.7065 21.7879C19.1615 21.7879 20.7002 20.4535 20.7002 18.9985V15.2793C20.7002 14.509 20.2574 13.7273 19.2723 13.7273C18.2186 13.7273 17.7065 14.509 17.7065 15.2793V18.8435M7.50018 14.9001H11.1002"
                                        stroke="black" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                <a href="{{ asset('storage/' . $key->cv_file) }}" target="_blank"
                                    class="text-blue-600 hover:underline font-medium">
                                    File CV Anda
                                </a>

                            </div>

                        </div>
                    </div>
                @endforeach
                @foreach ($serticificate as $sertifikat)
                    <div class="mt-4">
                        <a href="{{ asset('storage/' . $sertifikat->portofolio_path) }}" target="_blank"
                            class="text-blue-600 hover:underline font-medium">
                            Sertifikat ke-{{ $loop->iteration }}  ({{ $sertifikat->file_name ?? 'Tidak ada nama' }})
                        </a>
                    </div>
                @endforeach
            </div>
        </template>
    </div>
</x-jobseeker-layout>
