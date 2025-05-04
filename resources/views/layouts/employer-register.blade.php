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

<body class="font-sans antialiased mx-10 md:mx-20 mt-4 ">
    <div class="flex items-center gap-2">
        <div class="w-7 2xl:w-12 h-auto ">
            <img src="{{ asset('images/PNBLogo.png') }}" alt="">
        </div>
        <div class="font-extrabold text-sm 2xl:text-2xl ">
            <p> PNB Pusat Karir</p>
        </div>

    </div>
    <div
        class="flex flex-col lg:flex-row justify-center items-center lg:items-start md:justify-between mt-10 2xl:mt-20 ">
        <div class="flex flex-col lg:mt-24 2xl:mt-23 lg:ms-20 md:px-10 sm:px-0 lg:sticky  top-0 lg:top-20">
            <p class="font-semibold text-3xl 2xl:text-5xl mb-2">Buat Akun Pemberi Kerja</p>
            <p class="my-3 text-md 2xl:text-xl">Kelola lowongan dan kandidat Anda dengan solusi rekrutmen terpercaya.
            </p>
            <p class="text-sm">Sudah terdaftar?</p>
            <a href="{{ route('login') }}" class="">Masuk ke akun Anda!</a>
            <div class=" hidden lg:flex self-center  lg:w-[200px] 2xl:w-[300px]">
                <img src="{{ asset('images/HumanRegister.png') }}" alt="3D Human">
            </div>
        </div>
        <div class="flex flex-col items-center w-full">
            <div class="w-full mt-10 lg:mt-20 flex flex-col justify-center items-center">
                <div class="w-full sm:rounded-lg">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
    @stack('scripts')
</body>

</div>

</html>
