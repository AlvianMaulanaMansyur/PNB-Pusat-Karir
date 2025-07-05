@extends('admin.layouts.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Detail Lowongan</h1>

    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
        <h2 class="text-xl font-semibold text-blue-800 mb-2">{{ $lowongan->nama_lowongan }}</h2>
        <p class="text-sm text-gray-500 mb-4">
            Diposting oleh: {{ $lowongan->user->username ?? 'Tidak diketahui' }} |
            Tanggal: {{ $lowongan->created_at->format('d M Y') }}
        </p>

        <div class="mb-4">
            <h3 class="font-semibold">Deskripsi:</h3>
            <p>{{ $lowongan->deskripsi }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <h3 class="font-semibold">Jenis Lowongan:</h3>
                <p>{{ $lowongan->jenislowongan }}</p>
            </div>
            <div>
                <h3 class="font-semibold">Posisi:</h3>
                <p>{{ $lowongan->posisi }}</p>
            </div>
            <div>
                <h3 class="font-semibold">Kualifikasi:</h3>
                <p>{{ $lowongan->kualifikasi }}</p>
            </div>
            <div>
                <h3 class="font-semibold">Gaji:</h3>
                <p>Rp {{ number_format((int) $lowongan->gaji, 0, ',', '.') }}</p>
            </div>
            <div>
                <h3 class="font-semibold">Deadline:</h3>
                <p>{{ \Carbon\Carbon::parse($lowongan->deadline)->format('d M Y') }}</p>
            </div>
        </div>

        <div class="mb-4">
            <h3 class="font-semibold">Detail Kualifikasi:</h3>
            <p>{{ $lowongan->detailkualifikasi }}</p>
        </div>

        <div class="mb-4">
            <h3 class="font-semibold">Responsibility:</h3>
            <p>{{ $lowongan->responsibility }}</p>
        </div>

        <div class="mb-4">
            <h3 class="font-semibold">Benefit:</h3>
            <p>{{ $lowongan->benefit }}</p>
        </div>

        @if ($lowongan->poster)
            <div class="mb-4">
                <h3 class="font-semibold">Poster:</h3>
                <img src="{{ asset('storage/poster/' . $lowongan->poster) }}" alt="Poster" class="w-full max-w-md rounded shadow">
            </div>
        @endif

        <a href="{{ route('admin.manajemen-lowongan') }}" class="inline-block mt-4 text-blue-600 hover:underline">
            ← Kembali ke Manajemen Lowongan
        </a>
    </div>
</div>
@endsection