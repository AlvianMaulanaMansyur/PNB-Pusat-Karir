@extends('admin.layouts.app')

@section('content')
<main class="p-6 space-y-6">
    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1 -->
        @php
        $verifiedCount = $users
        ->where('is_active', 1)->count();
        @endphp

        <div class="bg-blue-900 text-white p-4 rounded-md shadow flex flex-col items-center">
            <p class="uppercase text-sm font-semibold">Akun Terverifikasi</p>
            <div class="flex items-center gap-2 mt-2">
                <span class="text-4xl font-bold">{{ $verifiedCount }}</span>
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M16.707 9.293a1 1 0 00-1.414 0L11 13.586 8.707 11.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l5-5a1 1 0 000-1.414z"/>
                </svg>
            </div>
        </div>


        <!-- Card 2 -->
        <div class="bg-blue-900 text-white p-4 rounded-md shadow flex flex-col items-center">
            <p class="uppercase text-sm font-semibold">Lowongan Aktif</p>
            <div class="flex items-center gap-2 mt-2">
                <span class="text-4xl font-bold">25</span>
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12a5 5 0 100-10 5 5 0 000 10zm0 2c-4.42 0-8 2.015-8 4.5V20h16v-1.5c0-2.485-3.58-4.5-8-4.5z"/>
                </svg>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-blue-900 text-white p-4 rounded-md shadow flex flex-col items-center">
            <p class="uppercase text-sm font-semibold">Event Aktif</p>
            <div class="flex items-center gap-2 mt-2">
                <span class="text-4xl font-bold">10</span>
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm4.293 6.293L10 14.586l-2.293-2.293-1.414 1.414L10 17.414l8-8-1.414-1.414z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="text-right">
        <a href="{{ route('admin.employer.create') }}"
        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 flex items-center gap-2 uppercase font-semibold">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"/>
            </svg>
            TAMBAH AKUN BARU
        </a>
    </div>

    <!-- Table Verifikasi -->
    <div class="bg-white p-4 rounded-md shadow border border-gray-300">
        <h2 class="text-lg font-bold uppercase border-b pb-2 mb-4">Verifikasi Akun Employer</h2>
        <div class="overflow-x-auto">
            <table class="w-full table-auto text-sm">
            <thead class="bg-blue-900 text-white">
                <tr>
                    <th class="px-4 py-2 text-left">NAMA</th>
                    <th class="px-4 py-2 text-center">EMAIL</th>
                    <th class="px-4 py-2 text-center">TANGGAL REGISTRASI</th>
                    <th class="px-4 py-2 text-center">ROLE</th>
                    <th class="px-4 py-2 text-center">STATUS</th>
                    <th class="px-4 py-2 text-center">AKSI</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($users as $user)
                <tr>
                    <td class="px-4 py-2 text-left">{{ $user->username }}</td>
                    <td class="px-4 py-2 text-center">{{ $user->email }}</td>
                    <td class="px-4 py-2 text-center">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="text-center">{{ strtoupper($user->role) }}</td>
                    <td class="px-4 py-2 text-center">
                        <span class="font-semibold text-{{ $user->is_active ? 'green' : 'yellow' }}-600">
                            {{ $user->is_active ? 'TERVERIFIKASI' : 'DITOLAK' }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-center">
                        <button data-modal-target="popup-{{ $user->id }}" data-modal-toggle="popup-{{ $user->id }}"
                            class="text-purple-600 hover:underline">
                            UBAH STATUS
                        </button>

                        <!-- Modal -->
                        <div id="popup-{{ $user->id }}" tabindex="-1"
                            class="fixed inset-0 z-50 hidden overflow-y-auto overflow-x-hidden bg-black/50 flex justify-center items-center">
                            <div class="relative w-full max-w-md p-4 bg-white rounded-lg shadow">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-xl font-semibold text-gray-900">
                                        Verifikasi Akun
                                    </h3>
                                    <button type="button" class="text-gray-400 hover:text-gray-900"
                                        data-modal-hide="popup-{{ $user->id }}">
                                        ✖
                                    </button>
                                </div>
                                <form action="{{ route('admin.verifikasi.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <p class="mb-4 text-sm">Apakah Anda ingin mengubah status akun <strong>{{ $user->username }}</strong>?</p>

                                    <select name="is_active" class="w-full p-2 border rounded mb-4">
                                        <option value="1" {{ $user->is_active ? 'selected' : '' }}>Terverifikasi</option>
                                        <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Ditolak</option>
                                    </select>

                                    <div class="flex justify-end gap-2">
                                        <button type="button" data-modal-hide="popup-{{ $user->id }}"
                                            class="px-4 py-2 border rounded hover:bg-gray-100">
                                            Batal
                                        </button>
                                        <button type="submit"
                                            class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>

    <!-- CTA Button -->
</main>
@endsection