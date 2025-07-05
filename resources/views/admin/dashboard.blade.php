@extends('admin.layouts.app')

@section('content')
<main class="p-6 space-y-8 bg-gray-50 min-h-screen">
    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @php
            $verifiedCount = $users->where('is_active', 1)->count();
        @endphp

        <!-- Card 1 -->
        <div class="bg-blue-900 text-white p-6 rounded-xl shadow-lg flex flex-col items-center transition-transform hover:scale-[1.02]">
            <p class="uppercase text-sm tracking-wider font-semibold">Akun Terverifikasi</p>
            <div class="flex items-center gap-3 mt-3">
                <span class="text-4xl font-bold">{{ $verifiedCount }}</span>
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M16.707 9.293a1 1 0 00-1.414 0L11 13.586 8.707 11.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l5-5a1 1 0 000-1.414z"/>
                </svg>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-blue-900 text-white p-6 rounded-xl shadow-lg flex flex-col items-center transition-transform hover:scale-[1.02]">
            <p class="uppercase text-sm tracking-wider font-semibold">Lowongan Aktif</p>
            <div class="flex items-center gap-3 mt-3">
                <span class="text-4xl font-bold">{{ $jobCount }}</span>
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12a5 5 0 100-10 5 5 0 000 10zm0 2c-4.42 0-8 2.015-8 4.5V20h16v-1.5c0-2.485-3.58-4.5-8-4.5z"/>
                </svg>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-blue-900 text-white p-6 rounded-xl shadow-lg flex flex-col items-center transition-transform hover:scale-[1.02]">
            <p class="uppercase text-sm tracking-wider font-semibold">Event Aktif</p>
            <div class="flex items-center gap-3 mt-3">
                <span class="text-4xl font-bold">{{ $eventCount }}</span>
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm4.293 6.293L10 14.586l-2.293-2.293-1.414 1.414L10 17.414l8-8-1.414-1.414z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Tabel Verifikasi -->
    <div class="bg-white p-6 rounded-xl shadow border border-gray-200">
        <h2 class="text-xl font-semibold uppercase border-b pb-3 mb-4 text-gray-800">Verifikasi Akun Employer</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm table-auto">
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
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2 text-left">{{ $user->username }}</td>
                        <td class="px-4 py-2 text-center">{{ $user->email }}</td>
                        <td class="px-4 py-2 text-center">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="text-center uppercase">{{ $user->role }}</td>
                        <td class="px-4 py-2 text-center">
                            <span class="font-semibold text-{{ $user->is_active ? 'green' : 'yellow' }}-600">
                                {{ $user->is_active ? 'TERVERIFIKASI' : 'DITOLAK' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button data-modal-target="popup-{{ $user->id }}"
                                    data-modal-toggle="popup-{{ $user->id }}"
                                    class="text-purple-600 hover:underline">
                                UBAH STATUS
                            </button>

                            <!-- Modal -->
                            <div id="popup-{{ $user->id }}" tabindex="-1"
                                 class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/40 flex items-center justify-center px-4">
                                <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg relative">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-xl font-semibold">Verifikasi Akun</h3>
                                        <button type="button" class="text-gray-500 hover:text-red-600"
                                                data-modal-hide="popup-{{ $user->id }}">✖</button>
                                    </div>
                                    <form action="{{ route('admin.verifikasi.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <p class="text-sm mb-4">Ubah status akun <strong>{{ $user->username }}</strong>?</p>

                                        <select name="is_active" class="w-full border border-gray-300 rounded px-3 py-2 mb-4">
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
</main>
@endsection