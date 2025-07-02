@extends('admin.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-6">DETAIL AKUN</h2>

    <form method="POST" action="#">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold">Nama</label>
            <input type="text" value="{{ $user->name ?? '-' }}" class="w-full border rounded p-2 bg-gray-100" disabled>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Email</label>
            <input type="text" value="{{ $user->email ?? '-' }}" class="w-full border rounded p-2 bg-gray-100" disabled>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Tanggal Registrasi</label>
            <input type="text" value="{{ $user->created_at ? $user->created_at->format('d-m-Y') : '-' }}" class="w-full border rounded p-2 bg-gray-100" disabled>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-2">Status Verifikasi</label>
            <div class="flex gap-4">
                <label class="flex items-center">
                    <input type="radio" name="status" value="terverifikasi" {{ $user->status_verifikasi == 'terverifikasi' ? 'checked' : '' }} disabled>
                    <span class="ml-2">Terverifikasi</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="status" value="ditolak" {{ $user->status_verifikasi == 'ditolak' ? 'checked' : '' }} disabled>
                    <span class="ml-2">Ditolak</span>
                </label>
            </div>
        </div>

        <div class="flex justify-start gap-4 mt-6">
            <a href="#" class="border border-gray-400 px-6 py-2 rounded hover:bg-gray-100">Kembali</a>
        </div>
    </form>
</div>
@endsection