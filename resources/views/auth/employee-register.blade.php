<x-job-seeker-register>
    <form method="POST" action="{{ route('jobseeker-register') }}">
        @csrf
        <div class="lg:grid col-1 md:grid-col-4 lg:grid-cols-6 gap-2 lg:max-w-3xl  sm:max-w-xl flex flex-col mx-auto">

            <!-- sapaan -->
            <div class="mt-4  lg:grid-col-1">
                <x-label-required for="sapaan" :value="__('Sapaan')" />
                <x-dropdown.sapaan-dropdown name="sapaan" :selected="old('sapaan')" class="block mt-1 w-full" />
                <x-input-error :messages="$errors->get('sapaan')" class="mt-2" />
            </div>

            <!-- Nama Depan -->
            <div class="mt-4  md:col-span-2">
                <x-label-required for="Nama Depan" :value="__('Nama Depan')" />
                <x-text-input id="nama_depan" class="block mt-1 w-full" type="text" name="nama_depan"
                    :value="old('nama_depan')" required />
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

            <!-- Username -->
            <div class="mt-4 lg:col-span-6 md:grid-col-2">
                <x-label-required for="username" :value="__('Username')" />
                <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('email')"
                    required />
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4 lg:col-span-3 md:grid-col-2">
                <x-label-required for="email" :value="__('Alamat Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- telephone Address -->
            <div class="mt-4 lg:col-span-3 md:grid-col-2">
                <x-label-required for="phone" :value="__('Phone Number')" />
                <x-text-input id="phone" name="phone" type="number" class="block mt-1 w-full" :value="old('phone')"
                    required />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4 lg:col-span-3 md:grid-col-2">
                <x-label-required for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4 lg:col-span-3 md:grid-col-2">
                <x-label-required for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            {{-- Negara --}}
            <div class="mt-4 lg:col-span-3 md:grid-col-2">
                <x-label-required for="negara" :value="__('Negara')" />
                <x-dropdown.negara-dropdown name="negara" :selected="old('negara')" class="block mt-1 w-full" required />
                <x-input-error :messages="$errors->get('negara')" class="mt-2" />
            </div>

            {{-- Kota --}}
            <div class="mt-4 lg:col-span-3 md:grid-col-2">
                <x-label-required for="kota" :value="__('Kota')" />
                <x-dropdown.kota-dropdown name="kota" :selected="old('kota')" class="block mt-1 w-full" required />
                <x-input-error :messages="$errors->get('kota')" class="mt-2" />
            </div>

            {{-- Pendidikan Tertinggi --}}
            <div class="mt-4 lg:col-span-3 md:grid-col-2">
                <x-label-required for="Pendidikan" :value="__('Pendidikan Tertinggi')" />
                <x-dropdown.pendidikan-dropdown :selected="old('education')" class="block mt-1 w-full" />
                <x-input-error :messages="$errors->get('education')" class="mt-2" />
            </div>

            {{-- keahlian Utama --}}
            <div class="mt-4 lg:col-span-3 md:grid-col-2">
                <x-required-hint-label for="keahlian" :value="__('Keahlian Utama')" :hint="__('Bidang keahlian utama, spesialisasi, bidang studi utama yang Anda kuasai.')" />
                <x-dropdown.disiplin-utama :selected="old('bidang')" class="block mt-1 w-full" required />
                <x-input-error :messages="$errors->get('bidang')" class="mt-2" />
            </div>

            {{-- Industri pekerjaan sebelumnya/saat ini --}}
            <div class="mt-4 lg:col-span-3 md:grid-col-2">
                <x-label-required for="industri-before" :value="__('Industri pekerjaan sebelumnya/saat ini')" />
                <x-dropdown.previous-industry :selected="old('previous_job')" class="block mt-1 w-full" />
                <x-input-error :messages="$errors->get('bidang')" class="mt-2" />
            </div>

            {{-- Tipe pekerjaan --}}
            <div class="mt-4 lg:col-span-3 md:grid-col-2">
                <x-label-required for="jenis_pekerjaan" :value="__('Tipe Pekerjaan')" />
                <x-dropdown.jenis-pekerjaan-dropdown :selected="old('jenis_pekerjaan')" class="block mt-1 w-full" />
                <x-input-error :messages="$errors->get('jenis_pekerjaan')" class="mt-2" />
            </div>


            {{-- Jabatan Sebelumnya --}}
            <div class="mt-4 lg:col-span-3 md:grid-col-2">
                <x-label-required for="jabatan" :value="__('Jabatan sebelumnya/saat ini')" />
                <x-dropdown.jabatan-dropdown :selected="old('jabatan')" class="block mt-1 w-full" />
                <x-input-error :messages="$errors->get('jabatan')" class="mt-2" />
            </div>

            {{-- status pekerjaan --}}
            <div class="mt-4 lg:col-span-3 md:grid-col-2">
                <x-label-required for="status" :value="__('Status Pekerjaan')" />
                <x-dropdown.status-pekerjaan-dropdown :selected="old('status')" class="block mt-1 w-full" />
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>

            <!-- Tahun Pengalaman -->
            <div class="mt-4 lg:col-span-3 md:grid-col-2">
                <x-label-required for="Tahun_pengalaman" :value="__('Tahun Pengalaman')" />
                <x-text-input id="tahun_pengalaman" class="block mt-1 w-full" type="number" name="tahun_pengalaman"
                    :value="old('tahun_pengalaman')" required />
                <x-input-error :messages="$errors->get('tahun pengalaman')" class="mt-2" />
            </div>

            <!-- Ketersediaan Bekerja -->
            <div class="mt-4 lg:col-span-3 md:grid-col-2">
                <x-required-hint-label for="ketersediaan" :value="__('Ketersediaan')" :hint="__('Kapan Anda bisa mulai bekerja?')" />
                <x-dropdown.ketersediaan-bekerja :selected="old('ketersediaan_bekerja')" class="block mt-1 w-full" />
                <x-input-error :messages="$errors->get('ketersediaan')" class="mt-2" />
            </div>

            {{-- toggle syarat --}}
            <div class="col-span-6" x-data="{ syarat: false, kebijakan: false }">
                <!-- Toggle Syarat -->
                <div class="flex flex-col lg:flex-row lg:items-center lg:gap-5 mt-4">
                    <div class="flex items-center space-x-3 mb-2">
                        <x-toggle name="syarat" id="syaratKetentuan" x-model="syarat" />
                        <p class="text-sm text-gray-600">
                            Saya setuju dengan
                            <a href="#" class="text-purple-800 underline">syarat dan ketentuan</a>
                        </p>
                    </div>

                    <!-- Toggle Kebijakan -->
                    <div class="flex items-center space-x-3 mb-4">
                        <x-toggle name="kebijakan" id="kebijakanPrivasi" x-model="kebijakan" />
                        <p class="text-sm text-gray-600">
                            Saya setuju dengan
                            <a href="#" class="text-purple-800 underline">kebijakan privasi</a>
                        </p>
                    </div>
                </div>

                <!--Button register -->
                <div class="flex flex-col lg:flex-row lg:items-center lg:gap-5 mt-4">
                    <div class="col-span-6 flex justify-start">
                        <x-primary-button class=" disabled:opacity-50 disabled:cursor-not-allowed  shadow-customblue"
                            id="buttonRegister" x-bind:disabled="!(syarat && kebijakan)">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                    <p class="text-xs text-red-500">Harap isi semua form yang ditandai dengan (*)</p>
                </div>
            </div>
        </div>
    </form>
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $.get('/get-countries', function(data) {
                    // console.log(data);
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
</x-job-seeker-register>
