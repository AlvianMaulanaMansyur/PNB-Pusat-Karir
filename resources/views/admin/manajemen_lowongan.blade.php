@extends('layouts.app')

@section('content')
<div class="flex">
    {{-- Sidebar --}}
    <aside class="w-64 h-screen bg-blue-900 text-white p-6 space-y-6">
        <div class="text-xl font-bold mb-6">🎓 PNB Pusat Karir</div>
        <nav class="space-y-4">
            <a href="#" class="flex items-center gap-2 hover:text-yellow-300">
                🏠 DASHBOARD
            </a>
            <a href="#" class="flex items-center gap-2 hover:text-yellow-300">
                🔒 VERIFIKASI AKUN EMPLOYER
            </a>
            <a href="#" class="flex items-center gap-2 text-yellow-300 font-semibold">
                📄 MANAJEMEN LOWONGAN
            </a>
            <a href="#" class="flex items-center gap-2 hover:text-yellow-300">
                📅 MANAJEMEN EVENT
            </a>
        </nav>
    </aside>

    {{-- Main content --}}
    <main class="flex-1 bg-gray-100 p-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold">MANAJEMEN LOWONGAN</h1>
            <div class="text-gray-600 text-2xl">👤</div>
        </div>

        <div class="flex items-center gap-4 mb-6">
            <input type="text" placeholder="Telusuri" class="w-full max-w-md border rounded-lg px-4 py-2 shadow">
            <button class="bg-blue-900 text-white p-2 rounded-full hover:bg-blue-800">➕</button>
        </div>

        <div class="space-y-4">
            @foreach ($lowongans as $job)
                <div class="bg-white rounded-lg shadow p-4 flex justify-between items-center">
                    <div class="flex items-start gap-4">
                        <div class="text-4xl text-blue-900">📄</div>
                        <div>
                            <h2 class="font-bold">{{ $job['posisi'] }}</h2>
                            <p class="text-sm text-gray-600">{{ $job['perusahaan'] }}</p>
                            <p class="text-sm text-gray-500">DESKRIPSI : Lorem ipsum dst...</p>
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