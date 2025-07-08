<x-jobseeker-layout>
    <div class="min-h-screen flex flex-col justify-between bg-gray-50">
        
        <div class="max-w-screen-xl w-full mx-auto px-4 sm:px-6 lg:px-32 py-10 flex-grow">
            {{-- Breadcrumb --}}
            <div class="mb-4">
                <x-breadcrumb :links="[['label' => 'Home', 'url' => route('employee.lowongan')], ['label' => 'Dashboard']]" />
            </div>

            {{-- Header --}}
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Selamat datang,
                        {{ $employeeData->first_name }}{{ $employeeData->last_name }}{{ $employeeData->suffix }}</h2>
                    <p class="text-gray-600 text-sm">Berikut adalah ringkasan status lamaran pekerjaanmu.</p>
                </div>
            </div>

            {{-- Cards 2 atas, 2 bawah --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                {{-- Lowongan Dilamar --}}
                <div
                    class="bg-white rounded-2xl shadow-lg border-l-4 border-blue-500 p-6 hover:shadow-xl transform hover:scale-[1.02] transition duration-200 ease-in-out">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 font-medium">Lowongan Dilamar</p>
                            <h2 class="text-4xl font-extrabold text-gray-800 mt-1">{{ $pending }}</h2>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10 3h4a1 1 0 011 1v2h3a2 2 0 012 2v2H4V8a2 2 0 012-2h3V4a1 1 0 011-1zM4 12h16v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Sedang Interview --}}
                <div
                    class="bg-white rounded-2xl shadow-lg border-l-4 border-yellow-500 p-6 hover:shadow-xl transform hover:scale-[1.02] transition duration-200 ease-in-out">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 font-medium">Sedang Interview</p>
                            <h2 class="text-4xl font-extrabold text-gray-800 mt-1">{{ $interview }}</h2>
                        </div>
                        <div class="bg-yellow-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3M4 11h16M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Ditolak --}}
                <div
                    class="bg-white rounded-2xl shadow-lg border-l-4 border-red-500 p-6 hover:shadow-xl transform hover:scale-[1.02] transition duration-200 ease-in-out">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 font-medium">Ditolak</p>
                            <h2 class="text-4xl font-extrabold text-gray-800 mt-1">{{ $rejected }}</h2>
                        </div>
                        <div class="bg-red-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Diterima --}}
                <div
                    class="bg-white rounded-2xl shadow-lg border-l-4 border-green-500 p-6 hover:shadow-xl transform hover:scale-[1.02] transition duration-200 ease-in-out">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 font-medium">Diterima</p>
                            <h2 class="text-4xl font-extrabold text-gray-800 mt-1">{{ $accepted }}</h2>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2l4 -4M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-jobseeker-layout>
