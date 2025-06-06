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

<!-- Wrapper dengan Grid 2 Kolom di Layar Lebar -->
<div class="w-full flex justify-center mt-6 px-2 md:px-4">
    <div class="w-full max-w-7xl grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Form di Kiri (2/3 Kolom) -->
        <div class="col-span-2 bg-white rounded-2xl shadow-lg p-6 md:p-10 border border-gray-200">
            <form method="POST" action="{{ route('employer.update', $employer->slug) }}">
                @csrf
                @method('PUT')

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

                <!-- Email, Phone, Username -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <x-label-required for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email"
                            class="mt-1 block w-full bg-gray-100 text-gray-500 cursor-not-allowed"
                            value="{{ old('email', $user->email) }}" readonly />
                    </div>
                    <div>
                        <x-label-required for="phone" :value="__('No. Telepon')" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                            value="{{ old('phone', $employer->phone) }}" />
                    </div>
                    <div>
                        <x-label-required for="username" :value="__('Username')" />
                        <x-text-input id="username" name="username" type="text"
                            class="mt-1 block w-full bg-gray-100 text-gray-500 cursor-not-allowed"
                            value="{{ old('username', $user->username) }}" readonly />
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="button" onclick="showModal()"
                        class="bg-primaryColor hover:bg-darkBlue text-white text-sm font-semibold px-6 py-2.5 rounded-md transition shadow-customblue">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
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

        {{-- Modal Konfirmasi --}}
        <div id="confirm-modal" tabindex="-1"
            class="hidden fixed top-0 left-0 right-0 z-50 flex items-center justify-center w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur-sm">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-xl shadow-xl border border-gray-200">
                    <button type="button"
                        class="absolute top-2.5 right-2.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition rounded-full w-8 h-8 flex items-center justify-center"
                        onclick="hideModal()">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 14 14">
                            <path d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>

                    <div class="p-6 text-center">
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" fill="none" viewBox="0 0 20 20">
                            <path d="M10 11V6m0 0h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <h3 class="mb-5 text-lg font-medium text-gray-700">Apakah kamu yakin ingin menyimpan perubahan profil ini?</h3>

                        <button type="button" onclick="submitForm()"
                            class="bg-primaryColor hover:bg-darkBlue text-white text-sm font-semibold px-6 py-2.5 rounded-md transition shadow-customblue">
                            Ya, Simpan
                        </button>

                        <button type="button" onclick="hideModal()"
                            class="ml-3 px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-100 transition">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
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

<script>
    function showModal() {
        document.getElementById('confirm-modal').classList.remove('hidden');
    }

    function hideModal() {
        document.getElementById('confirm-modal').classList.add('hidden');
    }

    function submitForm() {
        hideModal();
        document.querySelector('form').submit();
    }
</script>

@endsection