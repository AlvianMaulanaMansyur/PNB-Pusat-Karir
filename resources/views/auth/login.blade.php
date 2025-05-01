<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="font-semibold text-2xl mb-7">
        <p>Log in</p>
    </div>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full text-sm 2xl:text-lg" type="email" name="email"
                :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full md:text-sm 2xl:text-lg" type="password"
                name="password" required autocomplete="current-password" placeholder="Masukan Password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="flex flex-col items-end  mt-4">
            @if (Route::has('password.request'))
                <a class="text-xs 2xl:text-sm text-gray-600 hover:text-purple-900 hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>
        <div class="flex items-center justify-end mt-4">

            <x-primary-button class="w-full flex justify-center items-center shadow-customblue">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
