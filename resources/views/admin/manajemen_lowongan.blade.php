@extends('admin.layouts.app')

@section('content')
<div class="flex">
    {{-- Main content --}}
    <main class="flex-1 bg-gray-100 p-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold mb-4">MANAJEMEN LOWONGAN</h1>
        </div>

        <div class="flex items-center gap-4 mb-6">
            <<form action="{{ route('admin.manajemen-lowongan') }}" method="GET" class="flex items-center gap-4 mb-6 w-full">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Telusuri"
        class="w-full max-w-md border rounded-lg px-4 py-2 shadow">
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Cari</button>
</form>
            <form action="{{ route('tambah-lowongan.create') }}" method="GET">
                <button type="submit" class="bg-blue-900 text-white p-2 rounded-full hover:bg-blue-800">
                    ➕
                </button>
            </form>
        </div>

        <div class="space-y-4">
            @forelse ($joblisting as $job)
                <div class="bg-white rounded-lg shadow p-4 flex justify-between items-center">
                    <div class="flex items-start gap-4">
                        <div class="text-4xl text-blue-900">📄</div>
                        <div>
                            <h2 class="font-bold">{{ $job->nama_lowongan }}</h2>
                            <p class="text-sm text-gray-600">
                                {{ $job->user->username ?? 'Perusahaan tidak ditemukan' }}
                            </p>
                            <p class="text-sm text-gray-500 line-clamp-2">
                                {{ \Illuminate\Support\Str::limit($job->deskripsi, 100) }}
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 text-sm text-center">
                        <a href="{{ route('admin.detail-lowongan', $job->slug) }}"
                           class="bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded">👁️ LIHAT</a>
                        <a href="{{ route('admin.edit-lowongan', $job->slug) }}"
                           class="bg-yellow-100 hover:bg-yellow-200 px-3 py-1 rounded">✏️ EDIT</a>
                        <form action="{{ route('admin.destroy-lowongan', $job->slug) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus lowongan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-100 hover:bg-red-200 px-3 py-1 rounded">🗑️ HAPUS</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 italic">Belum ada lowongan yang tersedia.</p>
            @endforelse
        </div>
    </main>
</div>
@endsection