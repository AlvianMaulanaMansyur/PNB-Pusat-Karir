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

<body class="font-sans antialiased">
    <div class="flex items-center mt-5 ms-5">
        <div class="w-8 md:w-12 h-auto ">
            <img src="{{ asset('images/PNBLogo.png') }}" alt="">
        </div>
        <div class="font-extrabold text-sm md:text-2xl ">
            <p> PNB Pusat Karir</p>
        </div>
    </div>
    <div class="flex">
        <div class="md:mt-52 md:ms-96">
            <div class="font-extrabold text-lg md:text-4xl">
                <p>Seamat Datang !</p>
            </div>
            <div class="">
                <p>Temukan peluang baru atau rekrut talenta terbaik bersama kami</p>
            </div>
            <div class="">
                <p>Masuk ke akun Anda dan mari lanjutkan petualangan ini!</p>
            </div>
            <img src="{{ asset('images/HumanLogin.png') }}" alt="3D Human" class="w-96">
        </div>
        <div class="">
            <form action="">
                <input type="text">
            </form>
        </div>
    </div>
    {{-- <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div> --}}
</body>

</html>
