@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">VERIFIKASI AKUN</h1>

    <table class="w-full table-auto border rounded shadow text-sm">
        <thead class="bg-blue-900 text-white">
            <tr>
                <th class="px-4 py-2 text-left">NAMA</th>
                <th class="px-4 py-2">EMAIL</th>
                <th class="px-4 py-2">TANGGAL REGISTRASI</th>
                <th class="px-4 py-2">STATUS</th>
                <th class="px-4 py-2">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employers as $employer)
            <tr class="border-b">
                <td class="px-4 py-2">{{ $employer->name }}</td>
                <td class="px-4 py-2">{{ $employer->email }}</td>
                <td class="px-4 py-2">{{ $employer->registration_date }}</td>
                <td class="px-4 py-2">
                    <span class="font-semibold text-{{ $employer->status == 'TERVERIFIKASI' ? 'green' : ($employer->status == 'DITOLAK' ? 'red' : 'yellow') }}-600">
                        {{ $employer->status }}
                    </span>
                </td>
                <td class="px-4 py-2 text-center">
                    <a href="{{ route('employers.edit', $employer->id) }}" class="text-blue-600 hover:underline">📝</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection