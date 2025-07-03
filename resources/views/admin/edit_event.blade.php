@extends('admin.layouts.app')

@section('content')
<div class="flex">
    {{-- Main Content --}}
    <main class="flex-1 bg-white p-8">
        <h1 class="text-3xl font-bold mb-6 border-b pb-2">MANAJEMEN EVENT</h1>

        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">EDIT EVENT</h2>

            <form action="{{ route('admin.event.update', $job->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-semibold mb-1">Nama Event*</label>
                    <input type="text" name="posisi" value="{{ old('posisi', $job->posisi) }}" class="w-full border rounded px-4 py-2" required>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Nama Perusahaan*</label>
                    <input type="text" name="username" value="{{ old('username', $job->user->username) }}" class="w-full border rounded px-4 py-2" disabled>
                    <p class="text-sm text-gray-500">Data ini tidak dapat diubah.</p>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Deskripsi Event*</label>
                    <textarea name="deskripsi" rows="4" class="w-full border rounded px-4 py-2" required>{{ old('deskripsi', $job->deskripsi) }}</textarea>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Flyer atau Poster*</label>
                    <input type="file" name="poster" class="w-full border rounded px-4 py-2 bg-white">
                    <p class="text-sm text-gray-500">Kosongkan jika tidak ingin mengganti poster.</p>
                </div>

                <div>
                    <button type="submit" class="bg-blue-900 text-white px-6 py-2 rounded hover:bg-blue-800">
                        UPDATE EVENT
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection
