<x-employer-register-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="lg:grid lg:grid-cols-2 gap-2">


            <!-- Name -->
            <div class="mt-4">
                <x-label-required for="name" :value="__('Nama Perusahaan')" />
                <x-text-input disabled id="name" class="block mt-1 w-full" type="text" name="name"
                    :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- No Pendaftaran Bisnis -->
            <div class="mt-4">
                <x-required-hint-label for="noPendaftaran" :value="__('No Pendaftaran Bisnis')" :hint="__('Nomor resmi terdaftar yang dikeluarkan oleh kementrian setempat')" />
                <x-text-input id="noPendaftaran" class="block mt-1 w-full" type="text" :value="old('noPendaftaranm')" />
                <x-input-error :messages="$errors->get('noPendaftaran')" class="mt-2" />
            </div>

            <!-- Industri -->
            <div class="mt-4">
                <x-label-required for="industri" :value="__('Industri')" />
                <x-dropdown.industry-dropdown name="industry" :value="old('industry')" class="block mt-1 w-full" />
                <x-input-error :messages="$errors->get('industry')" class="mt-2" />
            </div>

            <!-- Website Perusahaan -->
            <div class="mt-4">
                <x-required-hint-label for="website" :value="__('Website Perusahaan')" :hint="__('Harus menyertakan https://')" />
                <x-text-input id="website" class="block mt-1 w-full" type="text" name="website" :value="old('website')"
                    required autocomplete="website" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Jenis Organisasi Perusahaan -->
            <div class="mt-4">
                <x-label-required for="organisasi" :value="__('organisasi')" />
                <x-dropdown.organisasi-dropdown name="industry" :value="old('industry')" class="block mt-1 w-full" />
                <x-input-error :messages="$errors->get('industry')" class="mt-2" />
            </div>

            {{-- Kekuatan Staff --}}
            <div class="mt-4">
                <x-label-required for="industri" :value="__('Industri')" />
                <x-dropdown.industry-dropdown name="industry" :value="old('industry')" class="block mt-1 w-full" />
                <x-input-error :messages="$errors->get('industry')" class="mt-2" />
            </div>

            {{-- Negara --}}
            <div class="mt-4">
                <x-label-required for="industri" :value="__('Industri')" />
                <x-dropdown.industry-dropdown name="industry" :value="old('industry')" class="block mt-1 w-full" />
                <x-input-error :messages="$errors->get('industry')" class="mt-2" />
            </div>

            {{-- Kota --}}
            <div class="mt-4">
                <x-label-required for="industri" :value="__('Industri')" />
                <x-dropdown.industry-dropdown name="industry" :value="old('industry')" class="block mt-1 w-full" />
                <x-input-error :messages="$errors->get('industry')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>


            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ms-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </div>
    </form>
    </x-employer-register-lay>
