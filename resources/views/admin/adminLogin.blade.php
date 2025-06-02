<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PNB Pusat Karir</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="flex flex-col md:flex-row w-full h-screen bg-white border border-gray-300">
        <!-- Kiri (Form Login) -->
        <div class="md:w-1/2 w-full bg-blue-900 text-white p-10 flex flex-col justify-center rounded-tr-[150px] md:rounded-tr-[150px] md:rounded-br-[150px]">
            <h1 class="text-5xl font-bold mb-4 text-center">LOGIN</h1>
            <p class="text-xl mb-10 text-center">Silahkan lengkapi username dan password</p>

            <form action="" method="POST" class="space-y-4">
                @csrf
                <x-text-input name="username" type="text" placeholder="Username" class="w-full px-4 py-2 rounded bg-white text-black focus:outline-none" />
                <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Masukan Password"
                              class="w-full px-4 py-2 rounded bg-white text-black focus:outline-none" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded hover:bg-blue-700">LOG IN</button>
            </form>
        </div>

        <!-- Kanan (Info Admin) -->
        <div class="md:w-1/2 w-full flex flex-col items-center justify-center p-10">
            <div class="flex items-start gap-3">
                <img src="{{ asset('images/PNBLogo.png') }}" alt="Logo" class="h-20 w-auto">
                <span class="text-5xl font-black text-gray-800">PNB PUSAT KARIR</span>
        </div>
            <h1 class="text-2xl font-bold mb-2">Halo Admin!</h1>
            <p class="text-center text-sm">Untuk melanjutkan, silahkan login terlebih dahulu</p>
        </div>
    </div>
</body>
</html>