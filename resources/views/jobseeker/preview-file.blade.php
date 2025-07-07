<x-jobseeker-layout>
    <x-alert.session-alert type="error" :message="session('error')" />
    <x-jobseeker.stepper :current="2" />

    <section class="py-4">
        <div class="container max-w-3xl mx-auto border-2 border-gray-300 p-6 rounded-lg shadow-md bg-white">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                <img src="{{ $job->employer->photo_profile === 'images/default_employer.png'
                    ? asset('images/default_employer.png')
                    : asset('storage/' . $job->employer->photo_profile) }}"
                    alt="Poster lowongan" class="w-28 h-28 object-cover rounded-lg shadow-md">

                <div class="text-center md:text-left">
                    <p class="text-sm text-gray-500">Melamar Untuk</p>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $job->nama_lowongan }}</h2>
                    <p class="text-gray-700">{{ $job->employer->company_name }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-4">
        <div
            class="container max-w-screen-lg  mx-auto border-2 border-gray-300 py-6 rounded-lg shadow-md bg-white px-10">
            <h3 class="font-semibold text-2xl text-primaryColor py-4">Ringkasan Profil</h3>
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 sm:gap-7">
                {{-- Foto Profil --}}
                <div class="w-28 h-28 rounded-full overflow-hidden flex-shrink-0">
                    <img src="{{ $employeeData->photo_profile === 'image/user.png'
                        ? asset($employeeData->photo_profile)
                        : asset('storage/' . $employeeData->photo_profile) }}"
                        alt="Foto Profil" class="w-full h-full object-cover">
                </div>

                {{-- Nama dan Ringkasan --}}
                <div class="flex-1 text-center sm:text-left px-2">
                    <p class="text-gray-800 text-2xl md:text-4xl font-semibold capitalize leading-snug">
                        {{ $employeeData->first_name . ' ' . $employeeData->last_name . ' ' . $employeeData->suffix }}
                    </p>

                    @if (!empty($employeeSummary->summary))
                        <p class="text-gray-800 text-md text-justify  whitespace-pre-line">
                            {{ $employeeSummary->summary }}
                        </p>
                    @else
                        <p class="text-gray-500 italic">Belum ada ringkasan profil.</p>
                    @endif
                </div>
            </div>

            {{-- Kontak --}}
            <section class="mt-12">
                <h3 class="font-semibold text-2xl text-primaryColor mb-1">Kontak</h3>
                <hr class="border-t-2 border-gray-300 mb-4">

                <div class="space-y-3 ps-2 sm:ps-4">
                    {{-- Email --}}
                    <div class="flex items-center gap-3">
                        <i class="fa-regular fa-envelope text-xl text-primaryColor"></i>
                        <p class="text-gray-800 text-sm">{{ $employeeData->user->email }}</p>
                    </div>

                    {{-- Phone --}}
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primaryColor" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0   0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                        </svg>
                        <p class="text-gray-800 text-sm">{{ $employeeData->phone }}</p>
                    </div>
                </div>
            </section>


            {{-- Work Experience --}}
            <section class="mt-12">
                <h3 class="font-semibold text-2xl text-primaryColor mb-1">Pengalaman Pekerjaan</h3>
                <hr class="border-t-2 border-gray-300 mb-4">

                <div class="space-y-8">
                    @foreach ($workExperience as $experience)
                        <div class="space-y-2">
                            {{-- Jabatan dan Tanggal --}}
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <h2 class="text-xl font-semibold text-gray-900">{{ $experience->position }}</h2>
                                <p class="text-sm text-gray-900 mt-1 sm:mt-0">
                                    {{ \Carbon\Carbon::parse($experience->start_date)->translatedFormat('F Y') }} –
                                    {{ \Carbon\Carbon::parse($experience->end_date)->translatedFormat('F Y') }}
                                </p>
                            </div>

                            {{-- Nama Perusahaan --}}
                            <p class="text-lg text-gray-700 italic">{{ $experience->company }}</p>
                            {{-- <p class="text-sm text-gray-500">{{ $experience->location }}</p> --}}

                            {{-- Deskripsi --}}
                            <div class="mt-2">
                                <h4 class="text-lg font-medium text-gray-800 mb-1">Deskripsi Pekerjaan</h4>
                                <p class="text-md leading-relaxed text-gray-700 text-justify">
                                    {!! nl2br(e($experience->description)) !!}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- pendidikan --}}
            <section class="mt-12">
                <h3 class="font-semibold text-2xl text-primaryColor py-2">Pendidikan</h3>
                <hr class="border-t-2 border-gray-300 mb-4">

                {{-- Garis vertikal utama --}}
                <div class="container p-4">
                    <div class="relative">
                        {{-- Garis vertikal utama --}}
                        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-300"></div>

                        @foreach ($employeeEducations as $index => $education)
                            <div class="relative flex items-start mb-8 {{ $loop->last ? 'mb-0' : '' }}">
                                {{-- Dot/lingkaran --}}
                                <div
                                    class="relative z-10 flex items-center justify-center w-8 h-8 bg-white border-2 border-gray-400 rounded-full mr-4">
                                    <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                                </div>

                                {{-- Konten pendidikan --}}
                                <div class="flex-1 min-w-0">
                                    <p class="text-gray-700 text-md">{{ $education->institution }}</p>
                                    <h2 class="font-semibold text-xl">{{ $education->sertifications }}</h2>
                                    <p class="text-sm text-gray-500 mb-2">
                                        {{ \Carbon\Carbon::parse($education->end_date)->translatedFormat('F Y') }}
                                    </p>

                                    <div class="flex items-center gap-3 mb-2">
                                        <i class="fa-solid fa-graduation-cap text-gray-700"></i>
                                        <p>{{ $education->degrees }}</p>
                                    </div>
                                    <div class="flex items-center gap-3 mb-3">
                                        <i class="fa-solid fa-book text-gray-700"></i>
                                        <p>{{ $education->dicipline }}</p>
                                    </div>

                                    <div class="py-2">
                                        <h3 class="font-semibold text-md mb-2">Deskripsi Pengalaman:</h3>
                                        <p class="text-justify text-md text-gray-800 leading-relaxed">
                                            {!! nl2br(e($education->description)) !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- Keahlian --}}
            <section class="mt-12">
                <h3 class="font-semibold text-2xl text-primaryColor py-2">Keahlian</h3>
                <hr class="border-t-2 border-gray-300 mb-4">

                <div class="flex flex-wrap gap-3">
                    @foreach ($skills as $skill)
                        <span
                            class="bg-gray-200 text-gray-800 px-3 py-1 rounded-xl text-md font-medium">{{ $skill->name }}</span>
                    @endforeach
                </div>

                <form action="" method="POST">
                    @csrf
                    {{-- surat lamaran --}}
                    <div class="mt-12">
                        <h3 class="font-semibold text-2xl text-primaryColor py-2">Surat Lamaran</h3>
                        <hr class="border-t-2 border-gray-300 mb-4">
                        <div class="border-2 border-gray-300 p-4 rounded-lg  bg-white">
                            <p class="text-md">{{ session('suratLamaran') }}</p>
                        </div>
                    </div>

                    <div class="mt-12">
                        <h3 class="font-semibold text-2xl text-primaryColor py-2">CV (Currirculum Vitae)</h3>
                        <hr class="border-t-2 border-gray-300 mb-4">

                        <div class="border-2 border-gray-300 p-4 rounded-lg bg-white flex items-center gap-2">
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.6998 22.1001H5.69979C4.37431 22.1001 3.2998 21.0256 3.2998 19.7001L3.2999 5.30013C3.29991 3.97466 4.37442 2.90015 5.6999 2.90015H16.5002C17.8256 2.90015 18.9002 3.97466 18.9002 5.30015V10.1001M7.50018 7.70015H14.7002M7.50018 11.3001H14.7002M14.7002 16.0541V18.9985C14.7002 20.4534 16.2516 21.7879 17.7065 21.7879C19.1615 21.7879 20.7002 20.4535 20.7002 18.9985V15.2793C20.7002 14.509 20.2574 13.7273 19.2723 13.7273C18.2186 13.7273 17.7065 14.509 17.7065 15.2793V18.8435M7.50018 14.9001H11.1002"
                                    stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>

                            <p class="text-md">{{ session('cv') }}</p>
                        </div>
                    </div>

                    <div class="mt-12">
                        <h3 class="font-semibold text-2xl text-primaryColor py-2">Dokumen Tambahan</h3>
                        <hr class="border-t-2 border-gray-300 mb-4">

                        <ul>
                            @foreach (session('sertifikat', []) as $name)
                                <div
                                    class="border-2 border-gray-300 p-4 rounded-lg bg-white flex items-center gap-2 mb-2">
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.6998 22.1001H5.69979C4.37431 22.1001 3.2998 21.0256 3.2998 19.7001L3.2999 5.30013C3.29991 3.97466 4.37442 2.90015 5.6999 2.90015H16.5002C17.8256 2.90015 18.9002 3.97466 18.9002 5.30015V10.1001M7.50018 7.70015H14.7002M7.50018 11.3001H14.7002M14.7002 16.0541V18.9985C14.7002 20.4534 16.2516 21.7879 17.7065 21.7879C19.1615 21.7879 20.7002 20.4535 20.7002 18.9985V15.2793C20.7002 14.509 20.2574 13.7273 19.2723 13.7273C18.2186 13.7273 17.7065 14.509 17.7065 15.2793V18.8435M7.50018 14.9001H11.1002"
                                            stroke="black" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    <li>{{ $name }}</li>
                                </div>
                            @endforeach
                        </ul>
                    </div>
                    <div class="flex justify-end py-7">
                        <x-primary-button>
                            {{ __('Kirim Lamaran') }}
                        </x-primary-button>
                    </div>
                </form>
        </div>

    </section>
</x-jobseeker-layout>
