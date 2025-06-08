<x-jobseeker-layout>
    <x-jobseeker.stepper :current="1" />

    {{-- tujuan lamaran --}}
    <section class="py-6">
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

    {{-- data diri --}}
    <section class="">
        <div class="container max-w-3xl mx-auto border-2 border-gray-300 p-6 rounded-lg shadow-md bg-white">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pribadi</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama"
                        value="{{ $employeeData->first_name }} {{ $employeeData->last_name }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="akhiran" class="block text-sm font-medium text-gray-700">Akhiran</label>
                    <input type="text" id="akhiran" name="akhiran" value="{{ $employeeData->suffix }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div class=" md:col-span-2">
                    <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi</label>
                    <input type="text" id="lokasi" name="lokasi"
                        value="{{ $employeeData->city }}, {{ $employeeData->country }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ $employeeData->user->email }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div ">
                    <label for="telepon" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                    <input type="text" id="telepon" name="telepon" value="{{ $employeeData->phone }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>
        </div>
    </section>


</x-jobseeker-layout>
