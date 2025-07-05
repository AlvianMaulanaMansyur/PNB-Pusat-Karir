<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard Admin</title>
        @vite('resources/css/app.css')
        <script src="//unpkg.com/alpinejs" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
<body class="bg-gray-100 font-sans">
    <div class="h-screen">
        <!-- Main content -->
    @include('admin.layouts.sidebar')
    <div class="pl-64 bg-gray-100 min-h-screen p-2">
    @include ('admin.layouts.header')
    @yield ('content')
    </div>
    </div>
    <!-- Tambahkan di bagian bawah sebelum </body> -->
<script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>

</body>
</html>