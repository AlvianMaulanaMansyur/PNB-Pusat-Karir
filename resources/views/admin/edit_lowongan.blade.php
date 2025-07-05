@extends('admin.layouts.app')

@section('content')
<div class="flex">
    {{-- Pesan session --}}
    @foreach (['success', 'error'] as $type)
        @if (session($type))
            <x-alert.session-alert :type="$type" :message="session($type)" />
        @endif
    @endforeach
    @if ($errors->any())
        <x-alert.session-alert type="error" :message="$errors->first()" />
    @endif

    {{-- Main Content --}}
    <main class="flex-1 bg-gray-100 p-8">
        <h1 class="text-3xl font-bold mb-6">Edit Lowongan</h1>

        <div class="flex justify-center">
            <div class="w-full lg:w-2/3 bg-white p-6 rounded-xl shadow-md border border-gray-200">
                <form action="{{ route('admin.update-lowongan', $lowongan->slug) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Nama Lowongan --}}
                    <x-label-required for="nama_lowongan" :value="__('Nama Lowongan')" />
                    <x-text-input name="nama_lowongan" type="text" class="mt-1 w-full" required :value="old('nama_lowongan', $lowongan->nama_lowongan)" />

                    {{-- Deskripsi --}}
                    <x-label-required for="deskripsi" :value="__('Deskripsi')" class="mt-4" />
                    <x-text-area-input name="deskripsi" class="mt-1 w-full" required :value="old('deskripsi', $lowongan->deskripsi)" />

                    {{-- Jenis Lowongan --}}
                    <x-label-required for="jenislowongan" :value="__('Jenis Lowongan')" class="mt-4" />
                    <x-dropdown.jenis-lowongan :selected="old('jenislowongan', $lowongan->jenislowongan)" class="mt-1 w-full" />

                    {{-- Posisi --}}
                    <x-label-required for="posisi" :value="__('Posisi')" class="mt-4" />
                    <x-dropdown.tingkat-posisi :selected="old('posisi', $lowongan->posisi)" class="mt-1 w-full" />

                    {{-- Responsibility --}}
                    <x-label-required for="responsibility" :value="__('Responsibility')" class="mt-4" />
                    <x-text-area-input name="responsibility" class="mt-1 w-full" required :value="old('responsibility', $lowongan->responsibility)" />

                    {{-- Kualifikasi --}}
                    <x-label-required for="kualifikasi" :value="__('Kualifikasi')" class="mt-4" />
                    <x-dropdown.kualifikasi-pendidikan :selected="old('kualifikasi', $lowongan->kualifikasi)" class="mt-1 w-full" />

                    {{-- Detail Kualifikasi --}}
                    <x-label-required for="detailkualifikasi" :value="__('Detail Kualifikasi')" class="mt-4" />
                    <x-text-area-input name="detailkualifikasi" class="mt-1 w-full" required :value="old('detailkualifikasi', $lowongan->detailkualifikasi)" />

                    {{-- Gaji --}}
                    <x-label-required for="gaji" :value="__('Gaji')" class="mt-4" />
                    <x-text-input name="gaji" type="text" class="mt-1 w-full" required :value="old('gaji', $lowongan->gaji)" />
                    <p class="text-xs text-gray-500 mt-1">Masukkan angka tanpa titik/koma</p>

                    {{-- Benefit --}}
                    <x-label-required for="benefit" :value="__('Benefit')" class="mt-4" />
                    <x-text-area-input name="benefit" class="mt-1 w-full" required :value="old('benefit', $lowongan->benefit)" />

                    {{-- Deadline --}}
                    <x-label-required for="deadline" :value="__('Deadline')" class="mt-4" />
                    <x-text-input
                        name="deadline"
                        type="date"
                        min="{{ now()->toDateString() }}"
                        class="mt-1 w-full"
                        required
                        :value="old('deadline', \Carbon\Carbon::parse($lowongan->deadline)->format('Y-m-d'))"
                    />

                    {{-- Poster --}}
                    <label for="poster" class="block text-sm font-medium text-gray-700 mt-4">Poster (opsional)</label>
                    <input type="file" name="poster" id="poster" accept="image/*" class="block w-full text-sm text-gray-700 border rounded p-2" />
                    @if ($lowongan->poster)
                        <div class="mt-2">
                            <p class="text-sm">Poster saat ini:</p>
                            <img src="{{ asset('storage/poster/' . $lowongan->poster) }}" alt="Poster" class="w-32 border rounded shadow-sm mt-1">
                        </div>
                    @endif

                    {{-- Submit --}}
                    <div class="text-right mt-6">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-md shadow">
                            Update Lowongan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
@endsection