@extends('admin.layouts.app')

@section('content')
<div class="p-8 max-w-4xl mx-auto bg-white shadow-lg rounded-xl">
    {{-- Judul --}}
    <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">Detail Event</h1>

    {{-- Informasi Umum --}}
    <div class="space-y-6 text-gray-700">
        <div>
            <h2 class="text-lg font-semibold">📌 Nama Event</h2>
            <p class="text-xl font-medium">{{ $event->title }}</p>
        </div>

        <div>
            <h2 class="text-lg font-semibold">🎯 Jenis Event</h2>
            <p class="capitalize">{{ $event->event_type }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold">📅 Tanggal</h2>
                <p>{{ $event->event_date->format('d M Y') }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold">⏰ Waktu</h2>
                <p>{{ \Carbon\Carbon::parse($event->event_time)->format('H:i') }}</p>
            </div>
        </div>

        <div>
            <h2 class="text-lg font-semibold">📍 Lokasi</h2>
            <p>{{ $event->location }}</p>
        </div>

        <div>
            <h2 class="text-lg font-semibold">📝 Deskripsi</h2>
            <p class="whitespace-pre-line">{{ $event->description }}</p>
        </div>
    </div>

    {{-- Informasi Tambahan --}}
    <div class="mt-10 space-y-6 text-gray-700">
        <div>
            <h2 class="text-lg font-semibold">🧾 Perlu Registrasi</h2>
            <p>{{ $event->needs_registration ? 'Ya' : 'Tidak' }}</p>
        </div>

        @if($event->needs_registration)
        <div>
            <h2 class="text-lg font-semibold">🔗 Link Pendaftaran</h2>
            <a href="{{ $event->registration_link }}" class="text-blue-600 hover:underline" target="_blank">
                {{ $event->registration_link }}
            </a>
        </div>
        @endif

        @if($event->max_participants)
        <div>
            <h2 class="text-lg font-semibold">👥 Maksimal Peserta</h2>
            <p>{{ $event->max_participants }}</p>
        </div>
        @endif

        <div>
            <h2 class="text-lg font-semibold">📶 Status</h2>
            <span class="{{ $event->is_active ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' }}">
                {{ $event->is_active ? 'Aktif' : 'Tidak Aktif' }}
            </span>
        </div>

        <div>
            <h2 class="text-lg font-semibold">👤 Dibuat oleh</h2>
            <p>{{ $event->posted_by ? 'User #' . $event->posted_by : 'Tidak diketahui' }}</p>
        </div>

        @if($event->flyer)
        <div>
            <h2 class="text-lg font-semibold">🖼️ Flyer</h2>
            <img src="{{ asset('storage/flyers/' . $event->flyer) }}" alt="Flyer Event" class="mt-2 rounded-lg shadow-md max-h-[500px] object-contain">
        </div>
        @endif
    </div>

    {{-- Tombol Navigasi --}}
    <div class="mt-10 flex justify-between items-center">
        <a href="{{ route('admin.manajemenevent') }}" class="bg-gray-200 text-gray-700 px-5 py-2 rounded-md hover:bg-gray-300 transition">
            ← Kembali
        </a>
        <a href="{{ route('admin.event.edit', $event->id) }}" class="bg-yellow-500 text-white px-5 py-2 rounded-md hover:bg-yellow-600 transition">
            ✏️ Edit Event
        </a>
    </div>
</div>
@endsection