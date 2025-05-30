<nav class="border-b">
    <div class=" min-w-[1280px] max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo dan Judul -->
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/PNBLogo.png') }}" alt="Logo" class="w-10 h-auto">
                <p class="font-bold text-lg">PNB Pusat Karir</p>
            </div>

            <!-- Menu Utama -->
            <div class="hidden md:flex items-center gap-5 font-semibold me-12">
                <x-navlink href="#">Tentang Kami</x-navlink>
                <x-navlink href="#">Generate CV</x-navlink>

                <x-dropdown.nav-dropdown label="acara">
                    <a href="#">acara saya</a>
                </x-dropdown.nav-dropdown>
                <x-dropdown.nav-dropdown label="pekerjaan">
                    <a href="#">acara saya</a>
                </x-dropdown.nav-dropdown>

                <x-navlink href="#">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M9.33333 20.0909C10.041 20.6562 10.9755 21 12 21C13.0245 21 13.959 20.6562 14.6667 20.0909M4.50763 17.1818C4.08602 17.1818 3.85054 16.5194 4.10557 16.1514C4.69736 15.2975 5.26855 14.0451 5.26855 12.537L5.29296 10.3517C5.29296 6.29145 8.29581 3 12 3C15.7588 3 18.8058 6.33993 18.8058 10.4599L18.7814 12.537C18.7814 14.0555 19.3329 15.3147 19.9006 16.169C20.1458 16.5379 19.9097 17.1818 19.4933 17.1818H4.50763Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </x-navlink>

                <!-- Dropdown Profil -->
                <div x-data="{ open: false }" class="relative inline-block text-left">
                    <a href="#" @click.prevent="open = !open" class="flex items-center space-x-2">
                        <img src="{{ asset('images/profile.png') }}" alt="Profile"
                            class="rounded-full w-12 h-12 object-cover" />
                        <svg :class="open ? 'rotate-180' : ''" class="w-5 h-5 transition-transform duration-200"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50 py-2">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil
                            Saya</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pengaturan</a>
                        <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-100">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
