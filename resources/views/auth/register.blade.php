<x-employer-register-layout>
    <form method="POST" action="{{ route('register-employer') }}">
        @csrf
        <div class="lg:grid col-1 md:grid-col-4 lg:grid-cols-6 gap-2 lg:max-w-3xl  sm:max-w-xl flex flex-col mx-auto">
            <!-- Name -->
            <div class="mt-4 lg:col-span-3 md:grid-col-2  ">
                <x-label-required for="name" :value="__('Nama Perusahaan')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="nameCompany" :value="old('name')"
                    required autofocus autocomplete="nameCompany" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- No Pendaftaran Bisnis -->
            <div class="mt-4 lg:col-span-3 md:grid-col-2">
                <x-required-hint-label for="noPendaftaran" :value="__('No Pendaftaran Bisnis')" :hint="__('Nomor resmi terdaftar yang dikeluarkan oleh kementrian setempat')" />
                <x-text-input id="noPendaftaranBisnis" class="block mt-1 w-full" type="text"
                    name="noPendaftaranBisnis" :value="old('noPendaftaranBisnis')" />
                <x-input-error :messages="$errors->get('noPendaftaranBisnis')" class="mt-2" />
            </div>

            <!-- Industri -->
            <div class="mt-4 lg:col-span-3 md:grid-col-2">
                <x-label-required for="industri" :value="__('Industri')" />
                <x-dropdown.industry-dropdown name="industry" :value="old('industry')" class="block mt-1 w-full" />
                <x-input-error :messages="$errors->get('industry')" class="mt-2" />
            </div>

            <!-- Website Perusahaan -->
            <div class="mt-4 lg:col-span-3 md:grid-col-2">
                <x-required-hint-label for="website" :value="__('Website Perusahaan')" :hint="__('Harus menyertakan https://')" />
                <x-text-input id="website" class="block mt-1 w-full" type="text" name="website" :value="old('website')"
                    required autocomplete="website" />
                <x-input-error :messages="$errors->get('website')" class="mt-2" />
            </div>

            <!-- Jenis Organisasi Perusahaan -->
            <div class="mt-4 lg:col-span-3 md:grid-col-2">
                <x-label-required for="organisasi" :value="__('Jenis Organisasi')" />
                <x-dropdown.organisasi-dropdown name="organisasi" :value="old('organisasi')" class="block mt-1 w-full" />
                <x-input-error :messages="$errors->get('organisasi')" class="mt-2" />
            </div>

            {{-- Kekuatan Staff --}}
            <div class="mt-4 lg:col-span-3 md:grid-col-2">
                <x-label-required for="staff" :value="__('Kekuatan Staff')" />
                <x-dropdown.staff-strength-dropdown name="kekuatan" :value="old('kekuatan')" class="block mt-1 w-full" />
                <x-input-error :messages="$errors->get('kekuatan')" class="mt-2" />
            </div>

            {{-- Negara --}}
            <div class="mt-4 lg:col-span-3 md:grid-col-2">
                <x-label-required for="negara" :value="__('Negara')" />
                <x-dropdown.negara-dropdown name="negara" :value="old('negara')" class="block mt-1 w-full" />
                <x-input-error :messages="$errors->get('negara')" class="mt-2" />
            </div>

            {{-- Kota --}}
            <div class="mt-4 lg:col-span-3 md:grid-col-2">
                <x-label-required for="kota" :value="__('Kota')" />
                <x-dropdown.kota-dropdown name="kota" :value="old('kota')" class="block mt-1 w-full" />
                <x-input-error :messages="$errors->get('kota')" class="mt-2" />
            </div>

            <!-- Profil Perusahaan -->
            <div class="mt-4 lg:col-span-6 md:grid-col-4">
                <x-label-required for="Profil Perusahaan" :value="__('Profil Perusahaan')" />
                <x-text-area-input id="profil_perusahaan" name="profil_perusahaan" rows="6" required>
                    {{ old('profil_perusahaan') }}
                </x-text-area-input>
                <x-input-error :messages="$errors->get('profil_perusahaan')" class="mt-2" />
            </div>

            <!-- sapaan -->
            <div class="mt-4  lg:grid-col-1">
                <x-label-required for="sapaan" :value="__('Sapaan')" />
                <x-dropdown.sapaan-dropdown name="sapaan" :value="old('sapaan')" class="block mt-1 w-full" />
                <x-input-error :messages="$errors->get('sapaan')" class="mt-2" />
            </div>

            <!-- Nama Depan -->
            <div class="mt-4  md:col-span-2">
                <x-label-required for="Nama Depan" :value="__('Nama Depan')" />
                <x-text-input id="nama_depan" class="block mt-1 w-full" type="text" name="nama_depan"
                    :value="old('nama_depan')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('nama_depan')" class="mt-2" />
            </div>

            <!-- Nama Belakang -->
            <div class="mt-4 lg:col-span-2">
                <x-label-required for="Nama Belakang" :value="__('Nama Belakang')" />
                <x-text-input id="nama_belakang" class="block mt-1 w-full" type="text" name="nama_belakang"
                    :value="old('nama_belakang')" required />
                <x-input-error :messages="$errors->get('nama_belakang')" class="mt-2" />
            </div>

            <!-- akhiran -->
            <div class="mt-4 md:grid-col-2 lg:grid-col-1">
                <x-input-label for="akhiran" :value="__('akhiran')" />
                <x-text-input id="akhiran" class="block mt-1 w-full" type="text" name="akhiran"
                    :value="old('akhiran')" />
                <x-input-error :messages="$errors->get('Akhiran')" class="mt-2" />
            </div>

            <!-- Pekerjaan -->
            <div class="mt-4 md:grid-col-2 lg:col-span-3">
                <x-label-required for="pekerjaan" :value="__('pekerjaan')" />
                <x-text-input id="Pekerjaan" class="block mt-1 w-full" type="text" name="pekerjaan"
                    :value="old('akhiran')" required />
                <x-input-error :messages="$errors->get('pekerjaan')" class="mt-2" />
            </div>

            <!-- Departement -->
            <div class="mt-4 md:grid-col-2 lg:col-span-3">
                <x-label-required for="departemen" :value="__('Departemen')" />
                <x-text-input id="departemen" class="block mt-1 w-full" type="text" name="departemen"
                    :value="old('departemen')" required />
                <x-input-error :messages="$errors->get('departemen')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4 lg:col-span-3 md:grid-col-2">
                <x-label-required for="email" :value="__('Alamat Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                    :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4 lg:col-span-3 md:grid-col-2">
                <x-label-required for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                    :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Username -->
            <div class="mt-4 lg:col-span-6 md:grid-col-2">
                <x-label-required for="email" :value="__('Username')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                    :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4 lg:col-span-3 md:grid-col-2">
                <x-label-required for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4 lg:col-span-3 md:grid-col-2">
                <x-label-required for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-end justify-end mt-4">
                <x-primary-button class="ms-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </div>
    </form>
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $.get('/get-countries', function(data) {
                    data.forEach(function(country) {
                        $('#country').append(new Option(country.name, country.name));
                    });
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
                            $('#city').append(new Option(city, city));
                        });
                    });
                });
            });
        </script>
    @endpush

    </x-employer-register-lay>
