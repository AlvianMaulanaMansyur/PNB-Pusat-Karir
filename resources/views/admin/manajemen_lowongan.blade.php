@extends('admin.layouts.app')

@section('content')

<div class="flex">
    {{-- Main content --}}
    <main class="flex-1 bg-gray-100 p-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold mb-4">MANAJEMEN LOWONGAN</h1>
        </div>

        <div class="flex items-center gap-4 mb-6">
            <input type="text" placeholder="Telusuri" class="w-full max-w-md border rounded-lg px-4 py-2 shadow">
            <form action="{{ route('tambah-lowongan.create') }}" method="GET">
    <button type="submit" class="bg-blue-900 text-white p-2 rounded-full hover:bg-blue-800">
        ➕
    </button>
</form>
        </div>

        <div class="space-y-4">
            @foreach ($joblisting as $job)
                <div class="bg-white rounded-lg shadow p-4 flex justify-between items-center">
                    <div class="flex items-start gap-4">
                        <div class="text-4xl text-blue-900">📄</div>
                        <div>
                            <h2 class="font-bold">{{ $job->posisi}}</h2>
                            <p class="text-sm text-gray-600">{{ $job->user->username}}</p>
                            <p class="text-sm text-gray-500">{{ $job->deskripsi}}</p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 text-sm">
                        <button class="bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded">👁️ LIHAT</button>
                        <button class="bg-yellow-100 hover:bg-yellow-200 px-3 py-1 rounded">✏️ EDIT</button>
                        <button class="bg-red-100 hover:bg-red-200 px-3 py-1 rounded">🗑️ HAPUS</button>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
</div>
@endsection