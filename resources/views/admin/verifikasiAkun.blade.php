@extends('admin.layouts.app')

@section('content')

<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">VERIFIKASI AKUN</h1>

    <div class="overflow-hidden rounded-lg shadow"> <!-- Tambahkan wrapper rounded -->
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

@endsection