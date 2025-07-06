<!-- Header -->
<header class="h-20 bg-white shadow flex items-center justify-between px-8 border-b border-gray-200">
    <h1 class="text-3xl font-bold tracking-wide text-gray-800">Dashboard</h1>
    <div class="flex items-center gap-6">

      <!-- Profile Dropdown -->
<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="hover:text-blue-700 transition-colors focus:outline-none">
        <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 12a5 5 0 100-10 5 5 0 000 10zm0 2c-4.42 0-8 2.015-8 4.5V20h16v-1.5c0-2.485-3.58-4.5-8-4.5z" />
        </svg>
    </button>

    <!-- Dropdown menu -->
    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-md z-20">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                Logout
            </button>
        </form>
    </div>
</div>

    </div>
</header>