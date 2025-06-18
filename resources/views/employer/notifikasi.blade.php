@extends('employer.layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    {{-- Tombol Kembali --}}
    <div class="mb-6">
        <a href="{{ route('employer.dashboard') }}"
           class="inline-flex items-center text-sm text-blue-600 hover:underline hover:text-blue-800 transition duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Dashboard
        </a>
    </div>

    {{-- Judul --}}
    <h1 class="text-3xl font-bold text-gray-900 mb-6 flex items-center gap-2">
        📬 Notifikasi Anda
    </h1>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 text-sm px-4 py-3 rounded mb-4 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Daftar Notifikasi --}}
    @if($notifications->count() > 0)
    <div class="bg-white border border-gray-200 rounded-xl shadow p-4 space-y-4 max-h-[600px] overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
        @foreach ($notifications as $notif)
        <div class="flex justify-between items-start gap-4 border-l-4 px-4 py-3 rounded-md transition hover:bg-gray-50
            {{ $notif->is_read ? 'bg-white border-gray-300' : 'bg-blue-50 border-blue-500' }}">

            <div class="flex-1">
                <p class="{{ $notif->is_read ? 'text-gray-700 text-sm' : 'text-blue-900 font-semibold text-sm' }}">
                    {{ $notif->message }}
                </p>
                <p class="text-xs text-gray-400 mt-1">
                    {{ $notif->created_at->diffForHumans() }}
                </p>
            </div>

            <div class="flex items-center gap-2">
                @if ($latestUnread && $notif->id === $latestUnread->id)
                <span class="bg-blue-100 text-blue-600 text-xs font-semibold px-2 py-0.5 rounded-full">
                    Baru
                </span>
                @endif

                {{-- Tombol Hapus --}}
                <form action="{{ route('employer.notifikasi.destroy', $notif->id) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm delete-btn" title="Hapus Notifikasi">
                        🗑️
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center bg-yellow-50 border border-yellow-300 text-yellow-800 rounded-md p-6 shadow-sm">
        Tidak ada notifikasi saat ini 📭
    </div>
    @endif
</div>
@endsection

{{-- Tambahkan SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Alert Success --}}
@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Memproses...',
            text: 'Silakan tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
            }
        });

        setTimeout(() => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: @json(session('success')),
                confirmButtonText: 'OK'
            });
        }, 1500);
    });
</script>
@endif

{{-- Script Konfirmasi Penghapusan --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteForms = document.querySelectorAll('.delete-form');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Notifikasi ini akan dihapus permanen.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
