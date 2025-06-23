<nav class="border-b bg-white sticky top-0 z-40">
    <div class="w-full max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo dan Judul -->
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/PNBLogo.png') }}" alt="Logo" class="w-10 h-auto">
                <p class="font-bold text-lg">PNB Pusat Karir</p>
            </div>

            <!-- Menu Utama Desktop -->
            <div class="hidden md:flex items-center gap-5 font-semibold">
                <x-navlink href="#">Tracer Study</x-navlink>
                <x-navlink href="#">Tentang Kami</x-navlink>
                <x-navlink href="{{ route('resumes.index') }}">Generate CV</x-navlink>

                <x-dropdown.nav-dropdown label="acara">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Acara Saya</a>
                </x-dropdown.nav-dropdown>

                <x-dropdown.nav-dropdown label="pekerjaan">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Lowongan Pekerjaan</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Lamaran Saya</a>
                </x-dropdown.nav-dropdown>

                {{-- notification --}}
                @auth
                    @php
                        $employee = Auth::user()->dataEmployees;
                        $unreadCount = $employee?->unreadNotifications->count() ?? 0;
                    @endphp

                    <x-navlink href="{{ route('notifikasi.jobseeker') }}" class="relative">
                        <i class="fa-regular fa-bell text-xl "></i>

                        @if ($unreadCount > 0)
                            <span
                                class="absolute top-0 right-0 block h-2 w-2 rounded-full ring-2 ring-white bg-red-500 animate-ping"></span>
                        @endif
                    </x-navlink>

                @endauth
                <!-- Dropdown Profil -->
                <div x-data="{ open: false }" class="relative inline-block text-left">
                    <a href="#" @click.prevent="open = !open" class="flex items-center space-x-2">
                        <img src="{{ $employeeData->photo_profile === 'image/user.png'
                            ? asset($employeeData->photo_profile)
                            : asset('storage/' . $employeeData->photo_profile) }}"
                            {{-- Use the user's profile photo URL --}} alt="Profile"
                            class="rounded-full w-10 h-10 object-cover border-2 border-gray-200" />
                        <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform duration-200"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50 py-1">
                        <a href="{{ route('jobseeker.profiles') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil
                            Saya</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pengaturan</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Hamburger Menu Button (Mobile) -->
            <div x-data="{ mobileMenuOpen: false }" class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="p-2 rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Mobile Menu -->
                <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false"
                    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="fixed inset-0 bg-white z-50 overflow-y-auto pt-10 px-4">
                    <div class="space-y-4 font-semibold">

                        {{-- submenu Profile --}}
                        <div class="flex justify-end">
                            <button @click="mobileMenuOpen = false" class="me-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="icon/navigation/close_24px">
                                        <path id="icon/navigation/close_24px_2"
                                            d="M18.3 5.71002C18.1131 5.52276 17.8595 5.41753 17.595 5.41753C17.3305 5.41753 17.0768 5.52276 16.89 5.71002L12 10.59L7.10997 5.70002C6.92314 5.51276 6.66949 5.40753 6.40497 5.40753C6.14045 5.40753 5.8868 5.51276 5.69997 5.70002C5.30997 6.09002 5.30997 6.72002 5.69997 7.11002L10.59 12L5.69997 16.89C5.30997 17.28 5.30997 17.91 5.69997 18.3C6.08997 18.69 6.71997 18.69 7.10997 18.3L12 13.41L16.89 18.3C17.28 18.69 17.91 18.69 18.3 18.3C18.69 17.91 18.69 17.28 18.3 16.89L13.41 12L18.3 7.11002C18.68 6.73002 18.68 6.09002 18.3 5.71002Z"
                                            fill="#6D7D8B" />
                                    </g>
                                </svg>
                            </button>
                        </div>
                        <div x-data="{ submenuOpen: false }" class="border-b pb-2">
                            <button @click= "submenuOpen = !submenuOpen"
                                class="flex  justify-between items-center w-full  px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                                <div class="flex items-center ">
                                    <img src="{{ $employeeData->photo_profile ? asset('images/profile.png') : asset('storage/' . $employeeData->photo_profile) }}"
                                        alt="Profile"
                                        class="rounded-full w-10 h-10 object-cover border-2 border-gray-200 mr-3" />
                                    <span class="text-gray-700 font-medium">Nama Pengguna</span>
                                </div>
                                <span>
                                    <svg :class="submenuOpen ? 'rotate-180' : ''"
                                        class="w-5 h-5 transition-transform duration-200" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </button>
                            <div x-show="submenuOpen" x-collapse class="pl-4 space-y-2 mt-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="#"
                                        class="block px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">Profil
                                        Saya</a>
                                    <a href="#"
                                        class="block px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">Pengaturan</a>
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-red-600 hover:bg-red-100 rounded-lg transition">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                        <a href="#"
                            class="block px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">Generate
                            CV</a>
                        <a href="#"
                            class="block px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">Tentang
                            Kami</a>

                        <!-- Mobile Dropdown Acara -->
                        <div x-data="{ submenuOpen: false }" class="border-b pb-2">
                            <button @click="submenuOpen = !submenuOpen"
                                class="flex items-center justify-between w-full px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                                <span>Acara</span>
                                <svg :class="submenuOpen ? 'rotate-180' : ''"
                                    class="w-5 h-5 transition-transform duration-200" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="submenuOpen" x-collapse class="pl-4 space-y-2 mt-2">
                                <a href="#"
                                    class="block px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">Acara
                                    Saya</a>
                            </div>
                        </div>

                        <!-- Mobile Dropdown Pekerjaan -->
                        <div x-data="{ submenuOpen: false }" class="border-b pb-2">
                            <button @click="submenuOpen = !submenuOpen"
                                class="flex items-center justify-between w-full px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                                <span>Pekerjaan</span>
                                <svg :class="submenuOpen ? 'rotate-180' : ''"
                                    class="w-5 h-5 transition-transform duration-200" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="submenuOpen" x-collapse class="pl-4 space-y-2 mt-2">
                                <a href="#"
                                    class="block px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">Lowongan
                                    Pekerjaan</a>
                                <a href="#"
                                    class="block px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">Lamaran
                                    Saya</a>
                            </div>
                        </div>

                        <!-- Notification Button -->
                        <a href="#"
                            class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg" class="mr-3">
                                <path
                                    d="M9.33333 20.0909C10.041 20.6562 10.9755 21 12 21C13.0245 21 13.959 20.6562 14.6667 20.0909M4.50763 17.1818C4.08602 17.1818 3.85054 16.5194 4.10557 16.1514C4.69736 15.2975 5.26855 14.0451 5.26855 12.537L5.29296 10.3517C5.29296 6.29145 8.29581 3 12 3C15.7588 3 18.8058 6.33993 18.8058 10.4599L18.7814 12.537C18.7814 14.0555 19.3329 15.3147 19.9006 16.169C20.1458 16.5379 19.9097 17.1818 19.4933 17.1818H4.50763Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            Notifikasi
                            {{-- <span
                                class="ml-auto bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span> --}}
                        </a>
                    </div>

                    <!-- Close Button -->
                    <div class="mt-8 flex justify-center">
                        <button @click="mobileMenuOpen = false"
                            class="px-6 py-2 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition">
                            Tutup Menu
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
