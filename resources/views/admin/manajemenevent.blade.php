@extends('admin.layouts.app')

@section('content')
<div class="flex justify-center bg-gray-100 min-h-screen">
    <main class="w-full max-w-7xl bg-white p-8 mt-6 shadow-md rounded-lg">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-6 border-b pb-4">
            <h1 class="text-3xl font-bold text-gray-800">📅 Manajemen Event</h1>
        </div>

        {{-- Search & Add Button --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <form action="{{ route('admin.manajemenevent') }}" method="GET" class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Telusuri event..."
        class="w-full md:max-w-md border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">

    <button type="submit" class="flex items-center gap-2 bg-blue-900 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-800 transition">
        🔍 <span class="hidden sm:inline">Cari</span>
    </button>
</form>
            
            <form action="{{ route('admin.event.create') }}">
                <button type="submit" class="flex items-center gap-2 bg-blue-900 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-800 transition">
                    ➕ <span class="hidden sm:inline">Tambah Event</span>
                </button>
            </form>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border border-gray-200 rounded-lg shadow-sm">
                <thead class="bg-gray-50 text-gray-700 font-semibold">
                    <tr>
                        <th class="px-4 py-3 border">#</th>
                        <th class="px-4 py-3 border">Nama Event</th>
                        <th class="px-4 py-3 border">Jenis</th>
                        <th class="px-4 py-3 border">Tanggal</th>
                        <th class="px-4 py-3 border">Waktu</th>
                        <th class="px-4 py-3 border">Lokasi</th>
                        <th class="px-4 py-3 border">Registrasi</th>
                        <th class="px-4 py-3 border">Status</th>
                        <th class="px-4 py-3 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($events as $event)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="border px-4 py-3 text-center">{{ $loop->iteration }}</td>
                            <td class="border px-4 py-3">{{ $event->title }}</td>
                            <td class="border px-4 py-3 capitalize">{{ $event->event_type }}</td>
                            <td class="border px-4 py-3">{{ $event->event_date->format('d M Y') }}</td>
                            <td class="border px-4 py-3">{{ \Carbon\Carbon::parse($event->event_time)->format('H:i') }}</td>
                            <td class="border px-4 py-3">{{ $event->location }}</td>
                            <td class="border px-4 py-3 text-center">
                                <span class="{{ $event->needs_registration ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                                    {{ $event->needs_registration ? 'Ya' : 'Tidak' }}
                                </span>
                            </td>
                            <td class="border px-4 py-3 text-center">
                                <span class="{{ $event->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} px-2 py-1 rounded text-xs font-semibold">
                                    {{ $event->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td class="border px-4 py-3 text-center space-x-2">
    <a href="{{ route('admin.event.detail', $event->id) }}" class="text-blue-600 hover:underline text-sm">Detail</a>
    <a href="{{ route('admin.event.edit', $event->id) }}" class="text-yellow-600 hover:underline text-sm">Edit</a>
   <button 
    onclick="confirmDelete({{ $event->id }})"
    class="text-red-600 hover:underline text-sm"
    type="button"
>
    Hapus
</button>

<form id="delete-form-{{ $event->id }}" action="{{ route('admin.event.destroy', $event->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center px-4 py-6 text-gray-500 italic">Belum ada event yang tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>
<script>
    function confirmDelete(eventId) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data event akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + eventId).submit();
            }
        });
    }
</script>

@endsection
