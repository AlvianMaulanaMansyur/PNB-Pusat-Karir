<nav>
    <div class="m-5 min-w-screen flex items-center justify-between">
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/PNBLogo.png') }}" alt="Logo" class="w-10 h-auto">
            <p class="font-bold text-lg">PNB Pusat Karir</p>
        </div>
        <div class="flex font-semibold gap-5">
            <a href="#">Tentang Kami</a>
            <a href="#">Generate CV</a>
            <x-dropdown.nav-dropdown label="acara">
                <a href="#">acara saya</a>
            </x-dropdown.nav-dropdown>
        </div>
    </div>
</nav>
