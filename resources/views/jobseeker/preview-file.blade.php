<x-jobseeker-layout>
    <x-jobseeker.stepper :current="2" />

    <section class="py-4">
        <div class="container max-w-3xl mx-auto border-2 border-gray-300 p-6 rounded-lg shadow-md bg-white">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                <img src="{{ asset($job->employer->photo_profile) }}" alt="Poster lowongan"
                    class="w-28 h-28 object-cover rounded-lg shadow-md">

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
            <h3 class="font-semibold text-lg text-primaryColor py-4">Ringkasan Profile</h3>
            <div class="flex items-center gap-7">
                <div class="w-28 h-auto rounded-full overflow-hidden  ">
                    <img src="{{ $employeeData->photo_profile }}" alt="">
                </div>
                <div class="w-full mx-4 ">
                    <p class="text-gray-800 text-xl font-semibold capitalize">
                        {{ $employeeData->first_name . ' ' . $employeeData->last_name . '' . $employeeData->suffix }}
                    </p>
                    <p class="text-gray-600 text-md">-</p>
                </div>
            </div>
            <h3 class="font-semibold text-lg text-primaryColor py-2">Kontak</h3>
            <div class="flex items-center gap-5 ms-5 py-2">
                <i class="fa-regular fa-envelope text-xl"></i>
                <p class="text-gray-800 ml-2">{{ $employeeData->user->email }}</p>
            </div>
            <div class="flex items-center gap-5 ms-5 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0   0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                </svg>
                <p class="text-gray-800 ml-1">{{ $employeeData->phone }}</p>
            </div>
            {{-- pendidikan --}}
            <h3 class="font-semibold text-lg text-primaryColor py-2">Pendidikan</h3>
            <p>-</p>

            {{-- surat lamaran --}}
            <div>
                <h3 class="font-semibold text-lg text-primaryColor py-2">Surat Lamaran</h3>
                <div class="border-2 border-gray-300 p-4 rounded-lg  bg-white">
                    <p class="text-md">{{ session('suratLamaran') }}</p>
                </div>
            </div>

            <div>
                <h3 class="font-semibold text-lg text-primaryColor py-2">CV (Currirculum Vitae)</h3>
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

            <div>
                <h3 class="font-semibold text-lg text-primaryColor py-2">Dokumen Tambahan</h3>
                <ul>
                    @foreach (session('sertifikat', []) as $name)
                        <div class="border-2 border-gray-300 p-4 rounded-lg bg-white flex items-center gap-2 mb-2">
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.6998 22.1001H5.69979C4.37431 22.1001 3.2998 21.0256 3.2998 19.7001L3.2999 5.30013C3.29991 3.97466 4.37442 2.90015 5.6999 2.90015H16.5002C17.8256 2.90015 18.9002 3.97466 18.9002 5.30015V10.1001M7.50018 7.70015H14.7002M7.50018 11.3001H14.7002M14.7002 16.0541V18.9985C14.7002 20.4534 16.2516 21.7879 17.7065 21.7879C19.1615 21.7879 20.7002 20.4535 20.7002 18.9985V15.2793C20.7002 14.509 20.2574 13.7273 19.2723 13.7273C18.2186 13.7273 17.7065 14.509 17.7065 15.2793V18.8435M7.50018 14.9001H11.1002"
                                    stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
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
        </div>

    </section>
</x-jobseeker-layout>
