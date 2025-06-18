@extends('admin.layouts.app')

@section('content')
<div class="flex">
{{-- Tampilkan pesan success --}}
@if (session('success'))
<x-alert.session-alert type="success" :message="session('success')" />
@endif

{{-- Tampilkan pesan error umum --}}
@if (session('error'))
<x-alert.session-alert type="error" :message="session('error')" />
@endif

{{-- Tampilkan error validasi (opsional, tampilkan error pertama) --}}
@if ($errors->any())
<x-alert.session-alert type="error" :message="$errors->first()" />
@endif

    {{-- Main Content --}}
    <main class="flex-1 bg-gray-100 p-8">
        <h1 class="text-3xl font-bold mb-6">MANAJEMEN LOWONGAN</h1>
        <h2 class="text-xl font-semibold mb-4">TAMBAH LOWONGAN</h2>

        {{-- Form Tambah Lowongan (centered) --}}
        <div class="flex justify-center">
            <div class="w-full lg:w-2/3 bg-white p-6 rounded-xl shadow-md border border-gray-200">
                <form action="{{ route('admin.storelowongan') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf

                    {{-- Nama Lowongan --}}
                    <x-label-required for="nama_lowongan" :value="__('Nama Lowongan')" />
                    <x-text-input id="nama_lowongan" name="nama_lowongan" type="text" class="mt-1 w-full" required />

                    {{-- Deskripsi --}}
                    <x-label-required for="deskripsi" :value="__('Deskripsi')" class="mt-4" />
                    <x-text-area-input id="deskripsi" name="deskripsi" class="mt-1 w-full" required />

                    {{-- Jenis Lowongan --}}
                    <x-label-required for="jenis_lowongan" :value="__('Jenis Lowongan')" class="mt-4" />
                    <x-dropdown.jenis-lowongan class="mt-1 w-full" />

                    {{-- Posisi --}}
                    <x-label-required for="posisi" :value="__('Posisi')" class="mt-4" />
                    <x-dropdown.tingkat-posisi class="mt-1 w-full" />

                    {{-- Responsibility --}}
                    <x-label-required for="responsibility" :value="__('Responsibility')" class="mt-4" />
                    <x-text-area-input id="responsibility" name="responsibility" class="mt-1 w-full" required />

                    {{-- Kualifikasi --}}
                    <x-label-required for="kualifikasi" :value="__('Kualifikasi')" class="mt-4" />
                    <x-dropdown.kualifikasi-pendidikan class="mt-1 w-full" />

                    {{-- Detail Kualifikasi --}}
                    <x-label-required for="detailkualifikasi" :value="__('Detail Kualifikasi')" class="mt-4" />
                    <x-text-area-input id="detailkualifikasi" name="detailkualifikasi" class="mt-1 w-full" required />

                    {{-- Gaji --}}
                    <x-label-required for="gaji" :value="__('Gaji')" class="mt-4" />
                    <x-text-input id="gaji" name="gaji" type="text" class="mt-1 w-full" required />
                    <p class="text-xs text-gray-500 mt-1">Masukkan angka tanpa titik/koma, contoh: 5000000</p>

                    {{-- Benefit --}}
                    <x-label-required for="benefit" :value="__('Benefit')" class="mt-4" />
                    <x-text-area-input id="benefit" name="benefit" class="mt-1 w-full" required />

                    {{-- Deadline --}}
                    <x-label-required for="deadline" :value="__('Deadline')" class="mt-4" />
                    <x-text-input id="deadline" name="deadline" type="date" min="{{ now()->toDateString() }}" class="mt-1 w-full" required />

                    {{-- Poster --}}
                    <label for="poster" class="block text-sm font-medium text-gray-700 mt-4">Poster (opsional)</label>
                    <input type="file" name="poster" id="poster" accept="image/*" class="block w-full text-sm text-gray-700 border rounded p-2" />

                    {{-- Tombol Simpan --}}
                    <div class="text-right mt-6">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-md shadow">
                            Simpan Lowongan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
@endsection