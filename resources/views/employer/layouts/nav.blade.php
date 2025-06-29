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
            <a href="{{ route('employer.kelolawawancara', ['slug' => auth()->user()->employer->slug]) }}"
                class="hover:text-blue-600 cursor-pointer" title="Kelola Interview">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 2xl:w-8 2xl:h-8" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5h6m-6 4h6m-6 4h6m2 4a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2h10z" />
                </svg>
            </a>

            {{-- Ikon Notifikasi --}}
            @php
            use App\Models\EmployerNotification;

            $employer = auth()->user()->employer ?? null;
            $unreadCount = 0;

            if ($employer) {
            $unreadCount = EmployerNotification::where('employer_id', $employer->id)
            ->where('is_read', false)
            ->count();
            }
            @endphp

            {{-- Ikon Notifikasi --}}
            <a href="{{ route('employer.notifications') }}" class="relative hover:text-blue-600 cursor-pointer" title="Notifikasi">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 2xl:w-8 2xl:h-8 text-gray-700"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path d="M18 8a6 6 0 00-12 0c0 7-3 9-3 9h18s-3-2-3-9"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M13.73 21a2 2 0 01-3.46 0"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>

                {{-- Badge notifikasi jika ada yang belum dibaca --}}
                @if ($unreadCount > 0)
                <span class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px] font-bold rounded-full px-1.5 py-0.5">
                    {{ $unreadCount }}
                </span>
                @endif
            </a>

            {{-- Foto User atau Ikon --}}
            <a href="{{ route('employer.edit-profile', ['slug' => auth()->user()->employer->slug]) }}"
                class="hover:opacity-80 cursor-pointer" title="Edit Profile">
                @php
                $photo = auth()->user()->employer->photo_profile;
                @endphp

                @if ($photo)
                <img src="{{ asset('storage/' . $photo) }}"
                    alt="Foto Profil"
                    class="w-8 h-8 2xl:w-10 2xl:h-10 rounded-full object-cover border border-gray-300 shadow-sm" />
                @else
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 2xl:w-8 2xl:h-8 text-gray-700" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0" />
                </svg>
                @endif
            </a>

            {{-- Ikon Logout --}}
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="hover:text-red-600 cursor-pointer" title="Logout" role="img"
                    aria-label="Logout Icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 2xl:w-8 2xl:h-8" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M18 12H9m9 0l-3-3m3 3l-3 3" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>
