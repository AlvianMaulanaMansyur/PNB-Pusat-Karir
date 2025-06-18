<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Builder</title>
    @vite(['resources/css/app.css', 'resources/css/resume-builder.css', 'resources/js/app-resume.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src='https://unpkg.com/panzoom@9.4.0/dist/panzoom.min.js'></script>
    @livewireStyles
</head>

<body class="font-sans antialiased text-gray-800 bg-gray-50">

    @livewire('resume.resume-builder', ['resume' => $resume ?? null]) 

    @yield('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const elem = document.getElementById('resume-preview');
            const container = elem?.parentElement;
            if (!elem || !container) return;

            const panzoomInstance = panzoom(elem, {
                maxZoom: 2,
                minZoom: 0.5,
                bounds: true,
                boundsPadding: 0.1,
                zoomDoubleClickSpeed: 1,
                smoothScroll: false
            });

            container.addEventListener('wheel', panzoomInstance.zoomWithWheel, {
                passive: false
            });

            document.getElementById('zoom-in')?.addEventListener('click', () =>
                panzoomInstance.smoothZoom(elem.clientWidth / 2, elem.clientHeight / 2, 1.2)
            );
            document.getElementById('zoom-out')?.addEventListener('click', () =>
                panzoomInstance.smoothZoom(elem.clientWidth / 2, elem.clientHeight / 2, 0.8)
            );
            document.getElementById('reset-zoom')?.addEventListener('click', () => {
                panzoomInstance.zoomAbs(0, 0, 1);
                panzoomInstance.moveTo(0, 0);
            });
        });
    </script>

    @livewireScripts

</body>

</html>