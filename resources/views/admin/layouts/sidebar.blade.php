<aside class="w-64 h-screen fixed top-0 left-0 bg-blue-900 text-white shadow-lg flex flex-col overflow-y-auto z-40">
    <!-- Logo & Title -->
    <div class="h-20 flex items-center justify-center border-b border-blue-700 px-4">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/PNBLogo.png') }}" alt="Logo" class="h-12 w-auto">
            <span class="text-sm font-extrabold tracking-wide">PNB PUSAT KARIR</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-4 font-medium text-sm uppercase tracking-wide">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-800 transition-colors">
            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2L2 8h2v8h5V12h2v4h5V8h2L10 2z" />
            </svg>
            Dashboard
        </a>

        <!-- Manajemen Akun Dropdown -->
        <div x-data="{ open: false }" class="space-y-1">
            <button @click="open = !open"
                class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-800 transition-colors w-full text-left focus:outline-none">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M16.707 9.293a1 1 0 00-1.414 0L11 13.586 8.707 11.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l5-5a1 1 0 000-1.414z" />
                </svg>
                <span>Manajemen Akun</span>
                <svg class="w-4 h-4 ml-auto transform transition-transform duration-200"
                    :class="open ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <!-- Submenu -->
            <div x-show="open" x-transition class="pl-6 space-y-1 text-gray-200 text-xs" x-cloak>
                <a href="{{ route('admin.verifikasi-employer') }}"
                    class="block px-2 py-1 rounded-md hover:bg-blue-700 transition">
                    Verifikasi Akun Employer
                </a>
                <a href="{{ route('admin.verifikasi-employee') }}"
                    class="block px-2 py-1 rounded-md hover:bg-blue-700 transition">
                    Verifikasi Akun Employee
                </a>
            </div>
        </div>

        <!-- Manajemen Lowongan -->
        <a href="{{ route('admin.manajemen-lowongan') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-800 transition-colors">
            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M6 3a2 2 0 00-2 2v1H3a1 1 0 000 2h1v7a2 2 0 002 2h10a2 2 0 002-2V8h1a1 1 0 100-2h-1V5a2 2 0 00-2-2H6z" />
            </svg>
            Manajemen Lowongan
        </a>

        <!-- Manajemen Event -->
        <a href="{{ route('admin.manajemenevent') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-800 transition-colors">
            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M3 6h18v2H3V6zm0 5h18v2H3v-2zm0 5h18v2H3v-2z" />
            </svg>
            Manajemen Event
        </a>
    </nav>
</aside>