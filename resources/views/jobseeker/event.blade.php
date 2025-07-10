<x-jobseeker-layout>

    @if ($events->isEmpty())
        <div class="flex flex-col items-center justify-center h-[50vh] w-full text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-3 text-gray-400" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
            </svg>

            <h1 class="text-lg font-medium">Event belum ditambahkan</h1>
        </div>
    @else
        <div class="max-w-7xl mx-auto px-20 py-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($events as $event)
                    <div
                        class="flex flex-col border rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <!-- Gambar dengan ukuran konsisten -->
                        @if ($event->flyer)
                            <div class="w-full h-48 overflow-hidden">
                                <img src="{{ asset('storage/' . $event->flyer) }}" alt="Flyer {{ $event->title }}"
                                    class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500">No Image</span>
                            </div>
                        @endif

                        <!-- Detail Event -->
                        <div class="p-4 flex-grow">
                            <h2 class="text-xl font-bold mb-2 line-clamp-2">{{ $event->title }}</h2>
                            <p class="text-sm text-gray-600 mb-1">{{ $event->event_type }}</p>

                            <div class="my-2 text-sm">
                                <p class="flex items-center mb-1">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    {{ $event->event_date->format('d M Y') }} {{ $event->event_time->format('H:i') }}
                                </p>
                                <p class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ Str::limit($event->location, 30) }}
                                </p>
                            </div>
                        </div>

                        <!-- Button Lihat Detail -->
                        <div class="px-4 pb-4">
                            <a href="{{ route('employee.event.detail' , $event->id) }}"
                                class="w-full block text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-md transition-colors duration-300">
                                Lihat Acara
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</x-jobseeker-layout>
