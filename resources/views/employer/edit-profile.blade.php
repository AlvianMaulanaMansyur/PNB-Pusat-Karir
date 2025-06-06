@extends('employer.layouts.app')

@section('content')
{{-- Header Judul Halaman --}}
<div class="flex flex-col w-full lg:w-2/3 text-left mx-4 md:mx-10 lg:mx-20 lg:ml-28">
    <p class="my-3 text-md 2xl:text-xl text-gray-600">Kelola informasi profil Anda di sini</p>
    <p class="font-semibold text-xl 2xl:text-3xl my-2 text-gray-800">Edit Profil</p>
    <div class="w-20 h-1 bg-blue-500 rounded mb-4"></div>

    <!-- Box Informasi Tambahan Employer -->
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 mb-4 rounded shadow-sm text-yellow-900">
        <h3 class="font-semibold text-lg mb-2">Catatan Penting untuk Edit Profil Employer</h3>
        <ul class="list-disc list-inside space-y-1 text-sm">
            <li>Pastikan informasi kontak perusahaan seperti email dan nomor telepon selalu aktif dan dapat dihubungi.
            </li>
            <li>Gunakan alamat lengkap dan valid agar pelamar dapat mengetahui lokasi kantor dengan jelas.</li>
            <li>Periksa kembali nama perusahaan dan deskripsi agar sesuai dengan profil bisnis Anda.</li>
            <li>Setelah melakukan perubahan, jangan lupa klik tombol <strong>Simpan Perubahan</strong> untuk menyimpan
                data.</li>
            <li>Profil yang lengkap dan akurat akan meningkatkan kepercayaan pelamar terhadap perusahaan Anda.</li>
        </ul>
    </div>

    <a href="{{ route('employer.dashboard') }}"
        class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium mt-2 transition duration-300">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Halaman Utama
    </a>
</div>

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Memproses...',
            text: 'Silakan tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
            }
        });

        // Setelah 1.5 detik, tutup loading lalu tampilkan alert sukses
        setTimeout(() => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                confirmButtonText: 'OK'
            });
        }, 1500);
    });
</script>
@endif

<!-- Wrapper dengan Grid 2 Kolom di Layar Lebar -->
<div class="w-full flex justify-center mt-6 px-2 md:px-4">
    <div class="w-full max-w-7xl grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Konten Kiri (2/3 Kolom) -->
        <div class="col-span-2">
            <!-- FORMULIR -->
            <div class="bg-white rounded-2xl shadow-lg p-6 md:p-10 border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800 mb-6 text-center">Profile Perusahaan</h2>
                <form method="POST" action="{{ route('employer.update', $employer->slug) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- FOTO PROFIL DI DALAM FORM -->
                    <div class="flex justify-center mb-4">
                        <img
                            src="{{ $employer->photo_profile ? asset('storage/' . $employer->photo_profile) : asset('images/default_employer.png') }}"
                            alt="Foto Profil"
                            class="w-32 h-32 object-cover rounded-full border border-gray-300 shadow" />
                    </div>


                    <!-- Nama Perusahaan -->
                    <div class="mb-4">
                        <x-label-required for="company_name" :value="__('Nama Perusahaan')" />
                        <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name"
                            value="{{ old('company_name', $employer->company_name) }}" required />
                    </div>

                    <!-- No. Pendaftaran Bisnis -->
                    <div class="mb-4">
                        <x-label-required for="business_registration_number" :value="__('No. Pendaftaran Bisnis')" />
                        <x-text-input id="business_registration_number" class="block mt-1 w-full" type="text"
                            name="business_registration_number"
                            value="{{ old('business_registration_number', $employer->business_registration_number) }}"
                            required />
                    </div>

                    <!-- Industri -->
                    <div class="mb-4">
                        <x-label-required for="industry" :value="__('Industri')" />
                        <x-dropdown.industry-dropdown name="industry" :selected="old('industry', $employer->industry)" class="block mt-1 w-full" />
                    </div>

                    <!-- Website Perusahaan -->
                    <div class="mb-4">
                        <x-required-hint-label for="company_website" :value="__('Website Perusahaan')" :hint="__('Harus menyertakan https://')" />
                        <x-text-input id="company_website" name="company_website" type="url" class="mt-1 block w-full"
                            value="{{ old('company_website', $employer->company_website) }}" />
                    </div>

                    <!-- Jenis Organisasi -->
                    <div class="mb-4">
                        <x-label-required for="organization_type" :value="__('Jenis Organisasi')" />
                        <x-dropdown.organisasi-dropdown name="organization_type" :selected="old('organization_type', $employer->organization_type)"
                            class="block mt-1 w-full" />
                    </div>

                    <!-- Kekuatan Staff -->
                    <div class="mb-4">
                        <x-label-required for="staff_strength" :value="__('Kekuatan Staff')" />
                        <x-dropdown.staff-strength-dropdown name="staff_strength" :selected="old('staff_strength', $employer->staff_strength)"
                            class="block mt-1 w-full" />
                    </div>

                    <!-- Negara & Kota -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <x-label-required for="country" :value="__('Negara')" />
                            <x-dropdown.negara-dropdown name="country" :selected="old('country', $employer->country)" class="block mt-1 w-full" />
                        </div>
                        <div>
                            <x-label-required for="city" :value="__('Kota')" />
                            <x-dropdown.kota-dropdown name="city" :selected="old('city', $employer->city)" class="block mt-1 w-full" />
                        </div>
                    </div>

                    <!-- Profil Perusahaan -->
                    <div class="mb-4">
                        <x-label-required for="company_profile" :value="__('Profil Perusahaan')" />
                        <textarea id="company_profile" name="company_profile" rows="4"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('company_profile', $employer->company_profile) }}</textarea>
                    </div>

                    <!-- Informasi Kontak -->
                    <div class="mb-4">
                        <x-label-required for="salutation" :value="__('Sapaan')" />
                        <x-dropdown.sapaan-dropdown name="salutation" :selected="old('salutation', $employer->salutation)" class="block mt-1 w-full" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <x-label-required for="first_name" :value="__('Nama Depan')" />
                            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full"
                                value="{{ old('first_name', $employer->first_name) }}" />
                        </div>
                        <div>
                            <x-input-label for="last_name" value="Nama Belakang" />
                            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full"
                                value="{{ old('last_name', $employer->last_name) }}" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <x-input-label for="suffix" value="Akhiran" />
                            <x-text-input id="suffix" name="suffix" type="text" class="mt-1 block w-full"
                                value="{{ old('suffix', $employer->suffix) }}" />
                        </div>
                        <div>
                            <x-label-required for="job_title" :value="__('Pekerjaan')" />
                            <x-text-input id="job_title" name="job_title" type="text" class="mt-1 block w-full"
                                value="{{ old('job_title', $employer->job_title) }}" />
                        </div>
                        <div>
                            <x-input-label for="department" value="Departemen" />
                            <x-text-input id="department" name="department" type="text" class="mt-1 block w-full"
                                value="{{ old('department', $employer->department) }}" />
                        </div>
                    </div>
                    <!-- Alamat Perusahaan -->
                    <div class="mb-4">
                        <x-label-required for="alamat_perusahaan" :value="__('Alamat Perusahaan')" />
                        <x-text-input id="alamat_perusahaan" class="block mt-1 w-full" type="text" name="alamat_perusahaan"
                            value="{{ old('alamat_perusahaan', $employer->alamat_perusahaan) }}" required />
                    </div>

                    <!-- Email, Phone, Username -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <x-label-required for="phone" :value="__('No. Telepon')" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                                value="{{ old('phone', $employer->phone) }}" />
                        </div>
                        <div>
                            <x-label-required for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email"
                                class="mt-1 block w-full bg-gray-100 text-gray-500 cursor-not-allowed"
                                value="{{ old('email', $user->email) }}" readonly />
                        </div>
                        <div>
                            <x-label-required for="username" :value="__('Username')" />
                            <x-text-input id="username" name="username" type="text"
                                class="mt-1 block w-full bg-gray-100 text-gray-500 cursor-not-allowed"
                                value="{{ old('username', $user->username) }}" readonly />
                        </div>
                    </div>

                    <!-- Foto Profil Perusahaan (Minimalis dan Elegan) -->
                    <div class="mb-6">
                        <x-label-required for="photo_profile" :value="__('Foto Profil Perusahaan')" />

                        <div class="flex flex-col items-start gap-3 mt-2">
                            <!-- Gambar profil atau default -->
                            <img
                                src="{{ $employer->photo_profile ? asset('storage/' . $employer->photo_profile) : asset('images/default_employer.png') }}"
                                alt="Foto Profil"
                                class="w-24 h-24 object-cover rounded-full border border-gray-300 shadow-sm">

                            <!-- Tombol hapus hanya jika foto profil ada -->
                            @if ($employer->photo_profile)
                            <button type="submit" name="remove_photo" value="1"
                                class="inline-flex items-center gap-2 px-3 py-1.5 bg-red-50 text-red-600 border border-red-200 rounded-md hover:bg-red-100 transition text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Hapus Foto
                            </button>
                            @endif

                            <!-- Input file -->
                            <x-text-input id="photo_profile" name="photo_profile" type="file"
                                class="block w-full text-sm file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:rounded-md file:text-sm file:text-gray-700 file:cursor-pointer hover:file:bg-gray-200 transition" />
                        </div>
                    </div>


                    <!-- tombol simpan -->
                    <div class="flex justify-end mt-6">
                        <button type="submit"
                            class="bg-primaryColor hover:bg-darkBlue text-white text-sm font-semibold px-6 py-2.5 rounded-md transition shadow-customblue">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Box Informasi di Kanan (1/3 Kolom) -->
        <div class="bg-blue-50 border border-blue-200 rounded-2xl shadow p-6 h-fit">
            <h2 class="text-lg font-semibold text-blue-700 mb-4">🛈 Aturan Pengisian Form</h2>
            <ul class="list-disc list-inside text-sm text-blue-800 space-y-2">
                <li>Kolom bertanda * wajib diisi.</li>
                <li>Gunakan format URL yang benar untuk kolom Website.</li>
                <li>Pastikan data sesuai dengan dokumen resmi.</li>
                <li>Gunakan angka untuk Kekuatan Staff.</li>
                <li>Email harus aktif dan bisa dihubungi.</li>
                <li>Username harus unik dan tidak mengandung spasi.</li>
            </ul>
        </div>
    </div>
</div>



<!-- Tombol Kembali ke Atas -->
<button id="backToTop" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
    class="hidden fixed bottom-6 right-6 z-50 bg-gradient-to-tr from-blue-600 to-indigo-600 text-white p-3 rounded-full shadow-xl hover:scale-110 hover:shadow-2xl transition-all duration-300"
    title="Kembali ke atas" aria-label="Kembali ke atas">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
    </svg>
</button>
<script>
    // Tampilkan tombol setelah scroll 300px
    window.addEventListener('scroll', () => {
        const btn = document.getElementById('backToTop');
        btn.style.display = window.scrollY > 300 ? 'flex' : 'none';
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Ambil nilai yang dipilih dari Blade
        let selectedCountry = "{{ old('country', $employer->country) }}";
        let selectedCity = "{{ old('city', $employer->city) }}";

        $.get('/get-countries', function(data) {
            $('#country').empty().append('<option value="">Pilih Negara</option>');

            data.forEach(function(country) {
                let option = new Option(country.name, country.name);
                if (country.name === selectedCountry) {
                    option.selected = true;
                }
                $('#country').append(option);
            });

            // Trigger event change agar kota ikut terisi
            $('#country').trigger('change');
        });

        $('#country').on('change', function() {
            let country = $(this).val();

            $('#city').empty().append('<option value="">Loading...</option>');

            $.get('/get-cities', {
                _token: '{{ csrf_token() }}',
                country: country
            }, function(data) {
                $('#city').empty().append('<option value="">Pilih Kota</option>');
                data.forEach(function(city) {
                    let option = new Option(city, city);
                    if (city === selectedCity) {
                        option.selected = true;
                    }
                    $('#city').append(option);
                });
            });
        });
    });
</script>

@endsection