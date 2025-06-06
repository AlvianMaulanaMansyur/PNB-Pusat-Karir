<aside class="w-64 bg-blue-900 text-white shadow-md flex flex-col">
    <!-- Logo & Title -->
    <div class="h-20 flex items-center justify-center border-b border-blue-700 px-4">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/PNBLogo.png') }}" alt="Logo" class="h-12 w-auto">
            <span class="text-sm font-black">PNB PUSAT KARIR</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-4 space-y-4 font-semibold text-sm uppercase">
        <a href="{{route('admin.dashboard')}}" class="flex items-center gap-2 px-2 py-2 rounded hover:bg-blue-800 transition">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2L2 8h2v8h5V12h2v4h5V8h2L10 2z"/>
            </svg>
            Dashboard
        </a>
        <a href="{{route('admin.verifikasi-akun')}}" class="flex items-center gap-2 px-2 py-2 rounded hover:bg-blue-800 transition">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M16.707 9.293a1 1 0 00-1.414 0L11 13.586 8.707 11.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l5-5a1 1 0 000-1.414z"/>
            </svg>
            Verifikasi Akun Employer
        </a>
        <a href="manajemen-lowongan" class="flex items-center gap-2 px-2 py-2 rounded hover:bg-blue-800 transition">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M6 3a2 2 0 00-2 2v1H3a1 1 0 000 2h1v7a2 2 0 002 2h10a2 2 0 002-2V8h1a1 1 0 100-2h-1V5a2 2 0 00-2-2H6z"/>
            </svg>
            Manajemen Lowongan
        </a>
        <a href="#" class="flex items-center gap-2 px-2 py-2 rounded hover:bg-blue-800 transition">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M3 6h18v2H3V6zm0 5h18v2H3v-2zm0 5h18v2H3v-2z"/>
            </svg>
            Manajemen Event
        </a>
    </nav>
</aside>