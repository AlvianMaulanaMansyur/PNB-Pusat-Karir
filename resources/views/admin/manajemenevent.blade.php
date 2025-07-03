@extends('admin.layouts.app')

@section('content')
<div class="flex">
    {{-- Main Content --}}
    <main class="flex-1 bg-white p-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold">MANAJEMEN EVENT</h1>
        </div>

        <div class="flex items-center gap-4 mb-6">
            <input type="text" placeholder="Telusuri" class="w-full max-w-md border rounded-lg px-4 py-2 shadow">
            <form action="{{ route('admin.event.create') }}">
                <button type="submit" class="bg-blue-900 text-white p-2 rounded-full hover:bg-blue-800 text-lg">
                    ➕
                </button>
            </form>
        </div>

        <div class="space-y-4">
            @foreach ($joblisting as $job)
                <div class="bg-white rounded-xl shadow border p-4 flex justify-between items-center">
                    <div class="flex items-start gap-4">
                        <div class="h-12 w-12 bg-gray-200 rounded-md flex items-center justify-center text-2xl text-blue-800">📄</div>
                        <div>
                            <h2 class="font-bold text-lg">{{ $job->posisi }}</h2>
                            <p class="text-sm text-gray-700 font-semibold">{{ $job->user->username }}</p>
                            <p class="text-sm text-gray-500">{{ $job->deskripsi }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 text-sm">
                        <button class="bg-gray-100 hover:bg-gray-200 px-4 py-1 rounded font-semibold">👁️ LIHAT</button>
                        <button class="bg-yellow-100 hover:bg-yellow-200 px-4 py-1 rounded font-semibold">✏️ EDIT</button>
                        <button class="bg-red-100 hover:bg-red-200 px-4 py-1 rounded font-semibold">🗑️ HAPUS</button>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
</div>
@endsection