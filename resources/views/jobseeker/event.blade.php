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
        @foreach ($events as $event)
            <div class="p-4 border rounded-lg shadow mb-4">
                <h2 class="text-xl font-bold">{{ $event->title }}</h2>
                <p class="text-gray-600">{{ $event->event_type }}</p>
                <p>{{ $event->description }}</p>
                <p><strong>Waktu:</strong> {{ $event->event_date->format('d M Y') }}
                    {{ $event->event_time->format('H:i') }}
                </p>
                <p><strong>Lokasi:</strong> {{ $event->location }}</p>

                @if ($event->needs_registration)
                    <p class="text-sm text-blue-600">Perlu registrasi: <a href="{{ $event->registration_link }}"
                            target="_blank" class="underline">Daftar</a></p>
                @endif

                @if ($event->flyer)
                    <img src="{{ asset('storage/' . $event->flyer) }}" alt="Flyer {{ $event->title }}"
                        class="mt-2 w-64">
                @endif
            </div>
        @endforeach
    @endif

</x-jobseeker-layout>
