@extends('admin.layouts.app')

@section('content')
    <div class="flex justify-center">
        <x-alert.session-alert type="error" :message="session('error')" />
        <main class="w-full max-w-4xl bg-white p-8 shadow-md rounded-lg">
            <h1 class="text-3xl font-bold text-center mb-8">Tambah Event</h1>

            <form action="{{ route('admin.event.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Title --}}
                <div>
                    <label for="title" class="block font-semibold text-gray-700 mb-1">Nama Event</label>
                    <input type="text" name="title" id="title" maxlength="100"
                        class="w-full border-gray-300 rounded-lg px-4 py-2 shadow-sm" required>
                </div>

                {{-- Event Type --}}
                <div>
                    <label for="event_type" class="block font-semibold text-gray-700 mb-1">Jenis Event</label>
                    <select name="event_type" id="event_type" class="w-full border-gray-300 rounded-lg px-4 py-2 shadow-sm"
                        required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="webinar">Webinar</option>
                        <option value="jobfair">Job Fair</option>
                        <option value="workshop">Workshop</option>
                    </select>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="description" class="block font-semibold text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full border-gray-300 rounded-lg px-4 py-2 shadow-sm" required></textarea>
                </div>

                {{-- Tanggal & Waktu --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="event_date" class="block font-semibold text-gray-700 mb-1">Tanggal Event</label>
                        <input type="date" name="event_date" id="event_date"
                            class="w-full border-gray-300 rounded-lg px-4 py-2 shadow-sm" required>
                    </div>
                    <div>
                        <label for="event_time" class="block font-semibold text-gray-700 mb-1">Waktu Event</label>
                        <input type="time" name="event_time" id="event_time"
                            class="w-full border-gray-300 rounded-lg px-4 py-2 shadow-sm" required>
                    </div>
                </div>

                {{-- Lokasi --}}
                <div>
                    <label for="location" class="block font-semibold text-gray-700 mb-1">Lokasi</label>
                    <input type="text" name="location" id="location" maxlength="100"
                        class="w-full border-gray-300 rounded-lg px-4 py-2 shadow-sm" required>
                </div>

                {{-- Registrasi --}}

                {{-- Max Peserta & Link Registrasi --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="max_participants" class="block font-semibold text-gray-700 mb-1">Maksimal Peserta
                            (Opsional)</label>
                        <input type="number" name="max_participants" id="max_participants"
                            class="w-full border-gray-300 rounded-lg px-4 py-2 shadow-sm">
                    </div>
                    <div>
                        <label for="registration_link" class="block font-semibold text-gray-700 mb-1">Link Pendaftaran
                            (Opsional)</label>
                        <input type="url" name="registration_link" id="registration_link"
                            class="w-full border-gray-300 rounded-lg px-4 py-2 shadow-sm">
                    </div>
                </div>

                {{-- Flyer Upload --}}
                <div>
                    <label for="flyer" class="block font-semibold text-gray-700 mb-1">Flyer (Gambar)</label>
                    <input type="file" name="flyer" id="flyer" accept="image/*"
                        class="w-full border-gray-300 rounded-lg px-4 py-2 shadow-sm" required>
                </div>

                {{-- Aktif / Tidak --}}
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Status</label>
                    <label><input type="checkbox" name="is_active" value="1" checked class="mr-2">Aktif</label>
                </div>

                {{-- Tombol Simpan --}}
                <div class="text-right">
                    <button type="submit"
                        class="bg-blue-900 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-800">
                        Simpan Event
                    </button>
                </div>
            </form>
        </main>
    </div>
@endsection
