<div class="px-6 lg:px-20 mt-4">
    <div class="flex justify-between items-center mb-10">
        {{-- Kiri: Logo dan Judul --}}
        <div class="flex items-center gap-3">
            <div class="w-7 2xl:w-12 h-auto">
                <img src="{{ asset('images/PNBLogo.png') }}" alt="Logo PNB">
            </div>
            <div class="font-extrabold text-sm 2xl:text-2xl">
                <p>PNB Pusat Karir</p>
            </div>
        </div>

        {{-- Kanan: Ikon Manage Lowongan + User + Logout --}}
        <div class="flex items-center gap-8 text-gray-700">
            {{-- Ikon Manage Lowongan --}}
            <a href="{{ route('employer.kelolawawancara', ['slug' => auth()->user()->employer->slug]) }}" class="hover:text-blue-600 cursor-pointer" title="Kelola Interview">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 2xl:w-8 2xl:h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5h6m-6 4h6m-6 4h6m2 4a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2h10z" />
                </svg>
            </a>

            {{-- Ikon User --}}
            <a href="{{ route('employer.edit-profile', ['slug' => auth()->user()->employer->slug]) }}" class="hover:text-blue-600 cursor-pointer" role="img" aria-label="User Icon" title="Edit Profile">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 2xl:w-8 2xl:h-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0" />
                </svg>
            </a>

            {{-- Ikon Logout --}}
            <a href="#" class="hover:text-red-600 cursor-pointer" title="Logout" role="img" aria-label="Logout Icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 2xl:w-8 2xl:h-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M18 12H9m9 0l-3-3m3 3l-3 3" />
                </svg>
            </a>
        </div>
    </div>
</div>