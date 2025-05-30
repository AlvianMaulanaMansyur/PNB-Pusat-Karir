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

    {{-- DaisyUI --}}

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
        class="flex flex-col lg:flex-row justify-center items-center lg:items-start md:justify-between mt-10 2xl:mt-20">
        <div class="flex flex-col lg:mt-24 2xl:mt-32 lg:ms-20 md:px-10 sm:max-w-md sm:px-0">
            <p class="font-semibold text-3xl 2xl:text-5xl mb-2">Selamat Datang !</p>
            <p class="my-3 text-md 2xl:text-xl">Temukan peluang baru atau rekrut talenta <br> terbaik bersama kami.</p>
            <p class="text-sm">Masuk ke akun Anda dan mari lanjutkan petualangan ini!</p>
            <div class=" hidden lg:flex ms-48 2xl:ms-48  mt-5 2xl:mt-20 lg:w-[300px] 2xl:w-[480px]">
                <img src="{{ asset('images/HumanLogin.png') }}" alt="3D Human">
            </div>
        </div>
        <div class="flex flex-col items-center w-full">
            <div class="w-full  lg:mx-20 mt-10 lg:mt-20 flex flex-col justify-center items-center">
                <div class="w-full sm:max-w-md sm:rounded-lg">
                    {{ $slot }}
                </div>
            </div>



        </div>

    </div>
</body>
</div>

</html>
