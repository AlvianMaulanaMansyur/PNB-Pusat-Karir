<section class="bg-gray-50 py-4 px-2">
    <form action="{{ route('employee.lowongan') }}" method="GET"
        class="flex flex-col md:flex-row md:items-center border-2 border-black rounded-xl shadow-sm overflow-hidden max-w-4xl mx-auto bg-white">

        <!-- Search Field -->
        <div class="flex items-center px-4 py-3 md:py-4 w-full border-b md:border-b-0 md:border-r border-gray-300">
            <svg class="w-6 h-6 text-gray-900 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" name="keyword" value="{{ request('keyword') }}"
                placeholder="Job title, keywords, or company"
                class="w-full bg-transparent text-sm text-gray-800 placeholder-gray-500 border-none outline-none focus:ring-0" />
        </div>

        <!-- Location Field -->
        <div class="flex items-center px-4 py-3 md:py-4 w-full border-b md:border-b-0 md:border-r border-gray-300">
            <svg class="w-6 h-6 text-gray-900 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <input type="text" name="location" value="{{ request('location') }}" placeholder="Kota, kodepos, negara"
                class="w-full bg-transparent text-sm text-gray-800 placeholder-gray-500 border-none outline-none focus:ring-0" />
        </div>

        <!-- Search Button -->
        <div class="w-full md:w-auto px-4 py-3 md:py-0">
            <x-primary-button type="submit"
                class="w-full md:w-auto rounded-lg text-white px-5 py-2 font-semibold hover:bg-blue-900 transition-colors">
                Cari
            </x-primary-button>
        </div>
    </form>
</section>
