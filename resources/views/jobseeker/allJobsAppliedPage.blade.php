<x-jobseeker-layout>
    <div x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 1000)">
        <!-- Spinner -->
        <div x-show="loading" class="flex justify-center items-center h-[70vh]">
            <!-- SVG Spinner -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" class="w-20 h-20">
                <circle fill="#858082" stroke="#858082" stroke-width="15" r="15" cx="40" cy="100">
                    <animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;"
                        keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.4" />
                </circle>
                <circle fill="#858082" stroke="#858082" stroke-width="15" r="15" cx="100" cy="100">
                    <animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;"
                        keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="-.2" />
                </circle>
                <circle fill="#858082" stroke="#858082" stroke-width="15" r="15" cx="160" cy="100">
                    <animate attributeName="opacity" calcMode="spline" dur="2" values="1;0;1;"
                        keySplines=".5 0 .5 1;.5 0 .5 1" repeatCount="indefinite" begin="0" />
                </circle>
            </svg>
        </div>

        <div x-show="!loading" x-transition>
            <div x-data="{ showSidebar: false, selected: null, highlightedId: null }" x-init="const urlParams = new URLSearchParams(window.location.search);
            const selectedId = urlParams.get('selected');
            if (selectedId) {
                highlightedId = parseInt(selectedId);
                $nextTick(() => {
                    const el = document.getElementById(`job-card-${highlightedId}`);
                    if (el) {
                        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        setTimeout(() => { highlightedId = null }, 1500);
                    }
                });
            }
            window.history.replaceState({}, document.title, window.location.pathname);" class="relative min-h-screen">

                <div class="py-3 px-6 lg:px-20 ">
                    <x-breadcrumb :links="[['label' => 'Home', 'url' => route('employee.lowongan')], ['label' => 'Aktivitas']]" />
                </div>

                <div class="w-full px-4 sm:px-6 lg:px-20 max-w-4xl mx-auto">

                    {{-- Filter dropdown --}}
                    <section class="flex justify-end max-w-2xl mx-auto">
                        <div x-data="{ open: false, selected: '{{ $filterStatus ?? 'Semua' }}' }" class="relative inline-block text-left mb-6">
                            <!-- Trigger: Ikon -->
                            <button @click="open = !open" type="button"
                                class="inline-flex justify-center items-center w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"
                                id="options-menu" aria-haspopup="true" aria-expanded="true">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 text-gray-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                                </svg>
                                <span x-text="selected || 'Semua'"></span>
                            </button>

                            <!-- Dropdown -->
                            <div x-show="open" @click.away="open = false"
                                class="origin-top-left absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
                                x-transition>
                                <form method="GET" action="">
                                    <ul class="py-1 text-sm text-gray-700">
                                        <li>
                                            <button type="submit" name="status" value=""
                                                class="w-full text-left px-4 py-2 hover:bg-gray-100"
                                                @click="selected = 'Semua'; open = false">Semua</button>
                                        </li>
                                        @foreach ($statusMap as $key => $label)
                                            <li>
                                                <button type="submit" name="status" value="{{ $key }}"
                                                    class="w-full text-left px-4 py-2 hover:bg-gray-100"
                                                    @click="selected = '{{ $label }}'; open = false">
                                                    {{ $label }}
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>
                                </form>
                            </div>
                        </div>
                    </section>
                    @php
                        $hasData = false;
                    @endphp

                    @foreach ($statusOrder as $status)
                        @if ($jobApplied->has($status) && $jobApplied[$status]->count())
                            @php $hasData = true; @endphp

                            <h2 class="text-lg font-semibold text-gray-800 max-w-2xl mx-auto">
                                {{ $statusMap[$status] ?? ucfirst($status) }}
                            </h2>

                            @foreach ($jobApplied[$status] as $key)
                                <section id="job-card-{{ $key->id }}"
                                    class="max-w-2xl mx-auto bg-white/70 backdrop-blur-md border border-gray-200 rounded-2xl p-6 shadow-lg my-4 transition duration-300"
                                    :class="{ 'animate-pulse': highlightedId === {{ $key->id }} }">

                                    <p class="text-xs text-gray-600"> Melamar untuk posisi:</p>

                                    <div class="flex justify-between items-start mb-4">
                                        <div>
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
                                                <span class="font-semibold">Rp.
                                                    {{ number_format($key->job->gaji, 0, ',', '.') }}</span> per bulan
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
                        @endif
                    @endforeach

                    @unless ($hasData)
                        <div class="flex flex-col items-center justify-center h-[60vh] text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 mb-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 00-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <p class="text-lg font-medium">Belum ada lamaran pekerjaan</p>
                        </div>
                    @endunless
                </div>

                {{-- OVERLAY HITAM --}}
                <template x-if="showSidebar">
                    <div @click="showSidebar = false" class="fixed inset-0 bg-black bg-opacity-50 z-40"
                        x-transition:enter="transition-opacity ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition-opacity ease-in duration-200"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
                </template>

                {{-- SIDEBAR DETAIL --}}
                <template x-if="showSidebar">
                    <div class="fixed inset-y-0 right-0 w-[85%] max-w-4xl bg-white border-l border-gray-200 shadow-xl z-50 p-6 overflow-y-auto"
                        x-transition:enter="transform transition ease-out duration-300"
                        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                        x-transition:leave="transform transition ease-in duration-200"
                        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
                        <button @click="showSidebar = false"
                            class="mb-4 text-sm text-gray-500 hover:text-red-600 font-semibold">← Kembali</button>

                        @foreach ($statusOrder as $status)
                            @if ($jobApplied->has($status))
                                @foreach ($jobApplied[$status] as $key)
                                    <div x-show="selected === {{ $key->id }}" x-cloak>
                                        <p class="text-md text-gray-600">Lamaran untuk</p>
                                        <h2 class="text-2xl font-bold text-primaryColor mb-2">
                                            {{ $key->job->nama_lowongan }}
                                        </h2>
                                        <p>{{ $key->job->employer->company_name }}</p>
                                        <p class="text-sm text-gray-600">{{ $key->job->employer->alamat_perusahaan }}
                                        </p>
                                        <p><strong>Gaji:</strong> Rp. {{ number_format($key->job->gaji, 0, ',', '.') }}
                                        </p>

                                        <hr class="my-3">

                                        <p><strong>Status:</strong>
                                            <x-status-badge :status="$key->status" :deadline="$key->job->deadline" />
                                        </p>

                                        @if ($key->status === 'interview' && $key->interview_date)
                                            <div class="mt-2 flex items-center gap-2 text-green-700">
                                                <i class="fa-solid fa-calendar-check"></i>
                                                <p>Jadwal Interview: <span class="font-semibold">
                                                        {{ \Carbon\Carbon::parse($key->interview_date)->translatedFormat('l, d F Y - H:i') }}
                                                    </span></p>
                                            </div>
                                        @endif

                                        <p><strong>Dilamar pada:</strong> {{ $key->created_at->format('d F Y') }}</p>

                                        <hr class="my-4">

                                        <div class="flex text-md gap-2 items-center mt-2">
                                            <i class="fa-solid fa-file-lines text-gray-500"></i>
                                            <a href="{{ asset('storage/' . $key->cv_file) }}" target="_blank"
                                                class="text-blue-600 hover:underline font-medium">File CV Anda</a>
                                        </div>

                                        @php
                                            $filteredCertificates = $serticificate->where('job_id', $key->job_id);
                                        @endphp

                                        @if ($filteredCertificates->count())
                                            <p class="mt-4 font-medium text-gray-700">Dokumen terkait:</p>
                                            @foreach ($filteredCertificates as $sertifikat)
                                                <div class="mt-2 flex items-center gap-2">
                                                    <i class="fa-solid fa-award text-yellow-600"></i>
                                                    <p class="text-gray-600 font-medium">
                                                        {{ $sertifikat->file_name ?? 'Tanpa nama' }}</p>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="mt-4 text-gray-500 italic">Tidak ada sertifikat untuk lamaran
                                                ini.
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                </template>
            </div>
        </div>
    </div>
</x-jobseeker-layout>
