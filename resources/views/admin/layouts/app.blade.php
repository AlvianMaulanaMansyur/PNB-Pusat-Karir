<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard Admin</title>
        @vite('resources/css/app.css')
    </head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <!-- Main content -->
    @include('admin.layouts.sidebar')
    <div class="flex-1 flex flex-col">
    @include ('admin.layouts.header')
    @yield ('content')
    </div>
    </div>
</body>
</html>