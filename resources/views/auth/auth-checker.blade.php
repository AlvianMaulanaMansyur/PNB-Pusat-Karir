<x-guest-layout>
    <div class="font-semibold text-2xl mb-3">
        <p>Cek Ketersediaan Akun</p>
    </div>
    <form method="POST" action="{{ route('account-checker') }}">
        @csrf
        <div>
            <x-text-input class="block mt-1 w-full text-sm 2xl:text-lg" type="hidden" value="{{ $role }}"
                name="role" required />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full text-sm 2xl:text-lg" type="email" name="email"
                :value="old('email')" required autofocus placeholder="Masukan Email" autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full md:text-sm 2xl:text-lg" type="text" name="username"
                required autocomplete="current-username" placeholder="Masukan username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>


        <div class="flex items-center justify-end mt-4">

            <x-primary-button class="w-full flex justify-center items-center shadow-customblue">
                {{ __('Cek Akun Anda') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
