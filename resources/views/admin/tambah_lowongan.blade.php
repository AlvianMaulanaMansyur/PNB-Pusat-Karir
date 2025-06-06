@extends('layouts.app')

@section('content')
<div class="flex">
    {{-- Sidebar --}}
    <aside class="w-64 h-screen bg-blue-900 text-white p-6 space-y-6">
        <div class="text-xl font-bold mb-6">🎓 PNB Pusat Karir</div>
        <nav class="space-y-4">
            <a href="#" class="flex items-center gap-2 hover:text-yellow-300">🏠 DASHBOARD</a>
            <a href="#" class="flex items-center gap-2 hover:text-yellow-300">🔒 VERIFIKASI AKUN EMPLOYER</a>
            <a href="#" class="flex items-center gap-2 text-yellow-300 font-semibold">📄 MANAJEMEN LOWONGAN</a>
            <a href="#" class="flex items-center gap-2 hover:text-yellow-300">📅 MANAJEMEN EVENT</a>
        </nav>
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 bg-gray-100 p-8">
        <h1 class="text-3xl font-bold mb-6">MANAJEMEN LOWONGAN</h1>
        <h2 class="text-xl font-semibold mb-4">TAMBAH LOWONGAN</h2>

        <form class="space-y-4">
            <div>
                <label class="block font-semibold">Nama Perusahaan<span class="text-red-500">*</span></label>
                <input type="text" placeholder="Nama Perusahaan" class="w-full border rounded px-4 py-2">
            </div>

            <div>
                <label class="block font-semibold">Posisi<span class="text-red-500">*</span></label>
                <input type="text" placeholder="Posisi" class="w-full border rounded px-4 py-2">
            </div>

            <div>
                <label class="block font-semibold">Kualifikasi<span class="text-red-500">*</span></label>
                <textarea placeholder="Kualifikasi" class="w-full border rounded px-4 py-2 h-24"></textarea>
            </div>

            <div>
                <label class="block font-semibold">Deskripsi Lowongan<span class="text-red-500">*</span></label>
                <textarea placeholder="Deskripsi Lowongan" class="w-full border rounded px-4 py-2 h-24"></textarea>
            </div>

            <div>
                <label class="block font-semibold">Flyer atau Poster<span class="text-red-500">*</span></label>
                <input type="file" class="w-full border rounded px-4 py-2 bg-white">
                <small class="text-sm text-gray-500">Poster berbentuk jpg atau png</small>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-900 text-white px-6 py-2 rounded hover:bg-blue-800">
                    POSTING LOWONGAN
                </button>
            </div>
        </form>
    </main>
</div>
@endsection
