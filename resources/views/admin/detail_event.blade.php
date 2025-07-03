@extends('admin.layouts.app')

@section('content')
<div class="flex">
    {{-- Main Content --}}
    <main class="flex-1 bg-white p-8">
        <h1 class="text-3xl font-bold mb-6 border-b pb-2">MANAJEMEN LOWONGAN</h1>

        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">DETAIL EVENT</h2>

            <div class="flex items-start gap-4 mb-6">
                <div class="h-20 w-20 bg-gray-200 rounded-md flex items-center justify-center text-3xl text-blue-800">
                    📄
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block font-semibold mb-1">Nama Event*</label>
                    <input type="text" value="{{ $job->posisi }}" disabled class="w-full border rounded px-4 py-2 bg-gray-100" />
                </div>

                <div>
                    <label class="block font-semibold mb-1">Nama Penyelenggara*</label>
                    <input type="text" value="{{ $job->user->username }}" disabled class="w-full border rounded px-4 py-2 bg-gray-100" />
                </div>

                <div>
                    <label class="block font-semibold mb-1">Deskripsi Event*</label>
                    <textarea rows="4" disabled class="w-full border rounded px-4 py-2 bg-gray-100">{{ $job->deskripsi }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex gap-4">
            <a href="#" class="bg-blue-900 text-white px-6 py-2 rounded hover:bg-blue-800">EDIT EVENT</a>
            <form action="#" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-500">HAPUS</button>
            </form>
            <a href="{{ route('admin.event.index') }}" class="bg-gray-200 px-6 py-2 rounded hover:bg-gray-300">KEMBALI</a>
        </div>
    </main>
</div>
@endsection
