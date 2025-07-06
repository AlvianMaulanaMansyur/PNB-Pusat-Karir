@extends('admin.layouts.app')

@section('content')
<div class="flex justify-center">
    <main class="w-full max-w-4xl bg-white p-8 shadow-md rounded-lg">
        <h1 class="text-3xl font-bold text-center mb-8">Edit Event</h1>

        <form action="{{ route('admin.event.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div>
                <label for="title" class="block font-semibold text-gray-700 mb-1">Nama Event</label>
                <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" maxlength="100" class="w-full border-gray-300 rounded-lg px-4 py-2 shadow-sm" required>
            </div>

            {{-- Event Type --}}
            <div>
                <label for="event_type" class="block font-semibold text-gray-700 mb-1">Jenis Event</label>
                <select name="event_type" id="event_type" class="w-full border-gray-300 rounded-lg px-4 py-2 shadow-sm" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="webinar" {{ $event->event_type == 'webinar' ? 'selected' : '' }}>Webinar</option>
                    <option value="jobfair" {{ $event->event_type == 'jobfair' ? 'selected' : '' }}>Job Fair</option>
                    <option value="workshop" {{ $event->event_type == 'workshop' ? 'selected' : '' }}>Workshop</option>
                </select>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="description" class="block font-semibold text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" id="description" rows="4" class="w-full border-gray-300 rounded-lg px-4 py-2 shadow-sm" required>{{ old('description', $event->description) }}</textarea>
            </div>

            {{-- Tanggal & Waktu --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="event_date" class="block font-semibold text-gray-700 mb-1">Tanggal Event</label>
                    <input type="date" name="event_date" id="event_date" value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}" class="w-full border-gray-300 rounded-lg px-4 py-2 shadow-sm" required>
                </div>
                <div>
                    <label for="event_time" class="block font-semibold text-gray-700 mb-1">Waktu Event</label>
                    <input type="time" name="event_time" id="event_time" value="{{ old('event_time', $event->event_time->format('H:i')) }}" class="w-full border-gray-300 rounded-lg px-4 py-2 shadow-sm" required>
                </div>
            </div>

            {{-- Lokasi --}}
            <div>
                <label for="location" class="block font-semibold text-gray-700 mb-1">Lokasi</label>
                <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}" maxlength="100" class="w-full border-gray-300 rounded-lg px-4 py-2 shadow-sm" required>
            </div>

            {{-- Registrasi --}}
            <div>
                <label class="block font-semibold text-gray-700 mb-1">Perlu Registrasi?</label>
                <div class="flex items-center gap-4">
                    <label><input type="radio" name="needs_registration" value="1" {{ $event->needs_registration ? 'checked' : '' }}> Ya</label>
                    <label><input type="radio" name="needs_registration" value="0" {{ !$event->needs_registration ? 'checked' : '' }}> Tidak</label>
                </div>
            </div>

            {{-- Max Peserta & Link --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="max_participants" class="block font-semibold text-gray-700 mb-1">Maksimal Peserta (Opsional)</label>
                    <input type="number" name="max_participants" id="max_participants" value="{{ old('max_participants', $event->max_participants) }}" class="w-full border-gray-300 rounded-lg px-4 py-2 shadow-sm">
                </div>
                <div>
                    <label for="registration_link" class="block font-semibold text-gray-700 mb-1">Link Pendaftaran (Opsional)</label>
                    <input type="url" name="registration_link" id="registration_link" value="{{ old('registration_link', $event->registration_link) }}" class="w-full border-gray-300 rounded-lg px-4 py-2 shadow-sm">
                </div>
            </div>

            {{-- Flyer Upload --}}
            <div>
                <label for="flyer" class="block font-semibold text-gray-700 mb-1">Flyer (Gambar)</label>
                @if ($event->flyer)
                    <img src="{{ asset('storage/flyers/' . $event->flyer) }}" alt="Flyer" class="mb-2 max-h-60 rounded shadow">
                @endif
                <input type="file" name="flyer" id="flyer" accept="image/*" class="w-full border-gray-300 rounded-lg px-4 py-2 shadow-sm">
            </div>

            {{-- Status --}}
            <div>
                <label class="block font-semibold text-gray-700 mb-1">Status</label>
                <label><input type="checkbox" name="is_active" value="1" {{ $event->is_active ? 'checked' : '' }} class="mr-2">Aktif</label>
            </div>

            {{-- Tombol Simpan --}}
            <div class="text-right">
                <button type="submit" class="bg-blue-900 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-800">
                    Update Event
                </button>
            </div>
        </form>
    </main>
</div>
@endsection