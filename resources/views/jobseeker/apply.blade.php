<x-jobseeker-layout>
    <x-alert.session-alert type="error" :message="session('error')" />

    <x-jobseeker.stepper :current="1" />

    {{-- tujuan lamaran --}}
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

    {{-- data diri --}}
    <section class="py-4">
        <div class="container max-w-3xl mx-auto border-2 border-gray-300 p-6 rounded-lg shadow-md bg-white">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pribadi</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Nama Lengkap -->
                <div>
                    <x-input-label for="nama" :value="'Nama Lengkap'" />
                    <x-text-input :disabled="true" required readonly id="nama" name="nama" type="text"
                        :value="$employeeData->first_name . ' ' . $employeeData->last_name" class="mt-1 block w-full cursor-not-allowed opacity-70" />
                </div>

                <!-- Akhiran -->
                <div>
                    <x-input-label for="akhiran" :value="'Akhiran'" />
                    <x-text-input :disabled="true" class="cursor-not-allowed opacity-50" required readonly
                        id="akhiran" name="akhiran" type="text" :value="$employeeData->suffix"
                        class="mt-1 block w-full cursor-not-allowed opacity-70" />
                </div>

                <!-- Lokasi -->
                <div class="md:col-span-2">
                    <x-input-label for="lokasi" :value="'Lokasi'" />
                    <x-text-input :disabled="true" class="cursor-not-allowed opacity-50" required readonly
                        id="lokasi" name="lokasi" type="text" :value="$employeeData->city . ', ' . $employeeData->country"
                        class="mt-1 block w-full cursor-not-allowed opacity-70" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="'Email'" />
                    <x-text-input :disabled="true" class="cursor-not-allowed opacity-50" required readonly
                        id="email" name="email" type="email" :value="$employeeData->user->email"
                        class="mt-1 block w-full cursor-not-allowed opacity-70" />
                </div>

                <!-- Telepon -->
                <div>
                    <x-input-label for="telepon" :value="'Nomor Telepon'" />
                    <x-text-input :disabled="true" class="cursor-not-allowed opacity-50" required readonly
                        id="telepon" name="telepon" type="text" :value="$employeeData->phone"
                        class="mt-1 block w-full cursor-not-allowed opacity-70" />
                </div>
            </div>
        </div>
    </section>

    {{-- lamaran --}}
    <section class="py-4">
        <div class="container max-w-3xl mx-auto border-2 border-gray-300 p-6 rounded-lg shadow-md bg-white">
            <form action="{{ route('job-apply.step-one', ['id' => $job->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div>
                    <x-input-label id="suratLamaran" :value="__('Surat Lamaran')" />
                    <x-text-area-input id="suratLamaran" name="suratLamaran" required class="mt-1 block w-full"
                        placeholder="Apa yang ingin Anda sampaikan..." rows="6" :value="old('suratLamaran')">
                        {{ old('suratLamaran') }}
                    </x-text-area-input>
                </div>
                <div>
                    <x-file-input name="cv" label="CV (Curriculum Vitae)" accept="application/pdf" required />
                </div>
                <div>
                    <x-multi-file-input name="certificates" label="Upload Sertifikat" />
                </div>
                <div class="flex justify-end mt-4 mb-5">
                    <x-primary-button>
                        {{ __('Selanjutnya') }}
                    </x-primary-button>
                </div>
            </form>
    </section>


</x-jobseeker-layout>
