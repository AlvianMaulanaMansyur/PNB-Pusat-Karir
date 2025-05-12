<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="font-semibold text-2xl mb-3">
        <p>Login</p>
    </div>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full text-sm 2xl:text-lg" type="email" name="email"
                :value="old('email')" required autofocus placeholder="Masukan Email" autocomplete="username" />
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

    <!-- Divider -->
    <div class="mt-8 flex items-center w-full max-w-md px-4">
        <hr class="flex-grow border-t border-gray-300" />
        <span class="mx-4 text-gray-500 text-sm">OR</span>
        <hr class="flex-grow border-t border-gray-300" />
    </div>
    <!-- End Divider -->

    {{-- link untuk mendaftar sebagai pencari kerja atau pemberi kerja --}}
    <div class="flex flex-col items-center mt-5 gap-4">

        {{-- link untuk mendaftar pencari kerja --}}
        <a href="{{ route('jobseeker-register') }}"
            class="flex items-center space-x-2 text-[#1B0462] hover:underline text-sm sm:text-base">
            <span>Daftar sebagai pencari kerja</span>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M12.3313 7.49793C12.4753 7.49793 12.6203 7.53893 12.7493 7.62593C13.9783 8.45293 16.8403 10.5349 16.8403 11.9999C16.8403 13.4649 13.9783 15.5449 12.7483 16.3709C12.4043 16.6019 11.9383 16.5099 11.7083 16.1659C11.4773 15.8219 11.5683 15.3559 11.9123 15.1249C13.0875 14.335 14.1933 13.4176 14.8178 12.75L7.91984 12.75C7.50584 12.75 7.16984 12.414 7.16984 12C7.16984 11.586 7.50584 11.25 7.91984 11.25L14.8259 11.25C14.2028 10.5879 13.0923 9.66463 11.9113 8.86993C11.5673 8.63893 11.4773 8.17293 11.7083 7.82893C11.8523 7.61393 12.0903 7.49793 12.3313 7.49793Z"
                    fill="currentColor"></path>
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M22 12C22 4.617 19.383 2 12 2C4.617 2 2 4.617 2 12C2 19.383 4.617 22 12 22C19.383 22 22 19.383 22 12ZM20.5 12C20.5 18.514 18.514 20.5 12 20.5C5.486 20.5 3.5 18.514 3.5 12C3.5 5.486 5.486 3.5 12 3.5C18.514 3.5 20.5 5.486 20.5 12Z"
                    fill="currentColor"></path>
            </svg>
        </a>

        {{-- link untuk mendaftar pemberi kerja --}}
        <a href="{{ route('register-employer') }}"
            class="flex items-center space-x-2 text-[#1B0462] hover:underline text-sm sm:text-base">
            <span>Daftar sebagai pemeberi kerja</span>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M12.3313 7.49793C12.4753 7.49793 12.6203 7.53893 12.7493 7.62593C13.9783 8.45293 16.8403 10.5349 16.8403 11.9999C16.8403 13.4649 13.9783 15.5449 12.7483 16.3709C12.4043 16.6019 11.9383 16.5099 11.7083 16.1659C11.4773 15.8219 11.5683 15.3559 11.9123 15.1249C13.0875 14.335 14.1933 13.4176 14.8178 12.75L7.91984 12.75C7.50584 12.75 7.16984 12.414 7.16984 12C7.16984 11.586 7.50584 11.25 7.91984 11.25L14.8259 11.25C14.2028 10.5879 13.0923 9.66463 11.9113 8.86993C11.5673 8.63893 11.4773 8.17293 11.7083 7.82893C11.8523 7.61393 12.0903 7.49793 12.3313 7.49793Z"
                    fill="currentColor"></path>
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M22 12C22 4.617 19.383 2 12 2C4.617 2 2 4.617 2 12C2 19.383 4.617 22 12 22C19.383 22 22 19.383 22 12ZM20.5 12C20.5 18.514 18.514 20.5 12 20.5C5.486 20.5 3.5 18.514 3.5 12C3.5 5.486 5.486 3.5 12 3.5C18.514 3.5 20.5 5.486 20.5 12Z"
                    fill="currentColor"></path>
            </svg>

        </a>
    </div>
</x-guest-layout>
