<x-jobseeker-layout>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Bagian Gambar Besar -->
        <div>
            <x-breadcrumb :links="[['label' => 'Home', 'url' => route('employee.lowongan')], ['label' => 'Acara']]" />
        </div>
        <div class="mb-8 rounded-lg overflow-hidden shadow-lg mt-10">
            @if ($event->flyer)
                <img src="{{ asset('storage/' . $event->flyer) }}" alt="Flyer {{ $event->title }}"
                    class="w-full h-auto max-h-[500px] object-cover rounded-md">
            @else
                <div class="w-full h-64 bg-gray-200 flex items-center justify-center rounded-md">
                    <span class="text-gray-500 text-xl">No Image Available</span>
                </div>
            @endif
        </div>

        <!-- Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            <!-- Area Utama -->
            <div class="lg:col-span-3">
                <h1 class="text-4xl font-bold mb-4">{{ $event->title }}</h1>

                <div class="flex items-center mb-6 gap-2 flex-wrap">
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                        {{ $event->event_type }}
                    </span>

                    @if ($event->is_active)
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                            Active
                        </span>
                    @else
                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                            Inactive
                        </span>
                    @endif
                </div>

                <div class="prose max-w-none mb-8 text-justify">
                    {!! nl2br(e($event->description)) !!}
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                    <h3 class="text-xl font-bold mb-4 border-b pb-2">Detail Acara</h3>

                    <div class="space-y-4 text-sm text-gray-700">
                        <!-- Tanggal -->
                        <div>
                            <p class="font-semibold text-gray-500">Tanggal & Waktu</p>
                            <p class="mt-1 flex items-start">
                                <svg class="w-5 h-5 mr-2 text-gray-600 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $event->event_date->format('l, d F Y') }}<br>{{ $event->event_time->format('H:i') }}
                                    WIB</span>
                            </p>
                        </div>

                        <!-- Lokasi -->
                        <div>
                            <p class="font-semibold text-gray-500">Lokasi</p>
                            <p class="mt-1 flex items-start">
                                <svg class="w-5 h-5 mr-2 text-gray-600 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $event->location }}</span>
                            </p>
                        </div>

                        <!-- Registrasi -->
                        <div>
                            <p class="font-semibold text-gray-500">Link Pendaftaran</p>
                            @if ($event->registration_link)
                                <a href="{{ $event->registration_link }}" target="_blank"
                                    class="text-blue-600 hover:underline break-words">
                                    {{ $event->registration_link }}
                                </a>
                            @else
                                <p class="text-gray-400">Tidak tersedia</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-jobseeker-layout>
