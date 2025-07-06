@extends('admin.layouts.app')

@section('content')
<div class="p-6">

    @if (session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 px-4 py-3 bg-red-100 border border-red-300 text-red-800 rounded shadow-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <h1 class="text-3xl font-bold text-gray-800 mb-6">Verifikasi Akun Employer</h1>

    <div class="overflow-hidden rounded-lg shadow border border-gray-200 bg-white">
        <table class="w-full table-auto text-sm">
            <thead class="bg-blue-900 text-white uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">Nama</th>
                    <th class="px-6 py-3 text-center">Email</th>
                    <th class="px-6 py-3 text-center">Tanggal Registrasi</th>
                    <th class="px-6 py-3 text-center">Role</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @foreach ($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-left font-medium">{{ $user->username }}</td>
                    <td class="px-6 py-4 text-center">{{ $user->email }}</td>
                    <td class="px-6 py-4 text-center">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-center">{{ strtoupper($user->role) }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                            {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $user->is_active ? 'TERVERIFIKASI' : 'DITOLAK' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center space-x-2">
                        <button data-modal-target="popup-{{ $user->id }}" data-modal-toggle="popup-{{ $user->id }}"
                            class="text-purple-600 hover:underline hover:text-purple-800 transition">
                            Ubah Status
                        </button>
                        <form action="{{ route('admin.verifikasi.destroy', $user->id) }}" method="POST" class="inline"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-red-600 hover:underline hover:text-red-800 transition">
                                Hapus
                            </button>
                        </form>

                        <!-- Modal -->
                        <div id="popup-{{ $user->id }}" tabindex="-1"
                            class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/50 flex justify-center items-center px-4">
                            <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg relative">
                                <div class="flex justify-between items-center border-b pb-3 mb-4">
                                    <h3 class="text-lg font-semibold text-gray-800">Verifikasi Akun</h3>
                                    <button type="button" class="text-gray-500 hover:text-gray-800"
                                        data-modal-hide="popup-{{ $user->id }}">
                                        ✖
                                    </button>
                                </div>
                                <form action="{{ route('admin.verifikasi.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <p class="text-sm mb-4">
                                        Apakah Anda ingin mengubah status akun
                                        <strong>{{ $user->username }}</strong>?
                                    </p>

                                    <select name="is_active"
                                        class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400 mb-4">
                                        <option value="1" {{ $user->is_active ? 'selected' : '' }}>Terverifikasi</option>
                                        <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Ditolak</option>
                                    </select>

                                    <div class="flex justify-end gap-2">
                                        <button type="button" data-modal-hide="popup-{{ $user->id }}"
                                            class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-100 transition">
                                            Batal
                                        </button>
                                        <button type="submit"
                                            class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition">
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