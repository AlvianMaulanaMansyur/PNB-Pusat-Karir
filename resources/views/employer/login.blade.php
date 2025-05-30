<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased mx-20 mt-4 ">
    <div class="flex items-center gap-2">
        <div class="w-7 2xl:w-12 h-auto ">
            <img src="{{ asset('images/PNBLogo.png') }}" alt="">
        </div>
        <div class="font-extrabold text-sm 2xl:text-2xl ">
            <p> PNB Pusat Karir</p>
        </div>
    </div>
    <div class="flex justify-between 2xl:mt-10">
        <!-- Bagian Selamat Datang -->
        <div class="flex flex-col md:mt-28 2xl:mt-32 lg:ms-20 px-10">
            <p class="font-semibold text-3xl 2xl:text-5xl my-2">Selamat Datang !</p>
            <p class="my-3 text-md 2xl:text-xl">Temukan peluang baru atau rekrut talenta <br> terbaik bersama kami.</p>
            <p class="text-sm">Masuk ke akun Anda dan mari lanjutkan petualangan ini!</p>
            <div class="hidden lg:flex ms-52  mt-10 2xl:mt-20 lg:w-[300px] 2xl:w-[480px]">
                <img src="{{ asset('images/HumanLogin.png') }}" alt="3D Human" class="">
            </div>
        </div>

        <!-- Form Login -->
        <div class="w-1/2 2xl:w-1/4 mx-20 2xl:me-60 2xl:mb-72 mb-20 flex flex-col justify-center items-center">
            <h2 class="text-2xl font-semibold mb-4">Login</h2>
            <form action="{{ route('login') }}" method="POST" class="w-full">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md" placeholder="Masukkan email Anda">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md" placeholder="Masukkan password Anda">
                </div>
                <div class="flex items-center justify-between mb-4">
                    <div class="text-sm">
                        <a href="#" class="font-medium text-gray-600 hover:text-gray-400">Lupa password?</a>
                    </div>
                </div>
                <button type="submit" class="w-full bg-[#4d47c3] text-white font-semibold py-2 rounded-lg hover:bg-[#2A22D4] transition duration-200">Masuk</button>
            </form>

            <!-- Link ke halaman register -->
            <p class="mt-4 text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ url('/employer/register') }}" class="text-[#2A22D4] hover:underline font-medium">Daftar di sini</a>
            </p>
        </div>

    </div>

</body>

</html>