<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PNB Pusat Karir</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="flex flex-col md:flex-row w-full max-w-6xl h-screen md:h-[600px] bg-white shadow-lg overflow-hidden rounded-lg border border-gray-200">
        
        <!-- Kiri (Form Login) -->
        <div class="md:w-1/2 w-full bg-blue-900 text-white px-10 py-12 flex flex-col justify-center md:rounded-tr-[150px] md:rounded-br-[150px]">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-3 text-center">LOGIN</h1>
            <p class="text-lg md:text-xl mb-8 text-center">Silakan masukkan username dan password Anda</p>
            @error('username')
        <div class="text-sm text-red-300 mt-1">{{ $message }}</div>
    @enderror

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
    @csrf

    <!-- Input Username -->
    <x-text-input name="username" type="text" placeholder="Username"
        class="w-full px-4 py-2 rounded-lg bg-white text-black border focus:ring-2 focus:ring-blue-300 focus:outline-none transition"
        :value="old('username')" />

    <!-- Input Password -->
    <x-text-input id="password" type="password" name="password" required autocomplete="current-password"
        placeholder="Masukkan Password"
        class="w-full px-4 py-2 rounded-lg bg-white text-black border focus:ring-2 focus:ring-blue-300 focus:outline-none transition" />
    @error('password')
        <div class="text-sm text-red-300 mt-1">{{ $message }}</div>
    @enderror

    <!-- Tombol Login -->
    <button type="submit"
        class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition-all">
        LOG IN
    </button>
</form>

        </div>

        <!-- Kanan (Info Admin) -->
        <div class="md:w-1/2 w-full bg-white flex flex-col items-center justify-center px-10 py-12">
            <div class="flex items-center gap-4 mb-6">
                <img src="{{ asset('images/PNBLogo.png') }}" alt="Logo" class="h-20 w-auto">
                <span class="text-3xl md:text-4xl font-black text-blue-900 leading-tight">PNB<br>PUSAT KARIR</span>
            </div>
            <h2 class="text-2xl font-bold mb-2 text-gray-800">Halo, Admin!</h2>
            <p class="text-center text-sm text-gray-600 px-4">Untuk melanjutkan ke dashboard, silakan login menggunakan akun Anda.</p>
        </div>
    </div>
</body>

</html>