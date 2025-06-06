<x-jobseeker-layout>
    <div class="w-full max-w-screen-xl mx-auto mt-10">
        <a href="{{ url()->previous() }}" class="text-blue-500 underline mb-4 inline-block">← Kembali</a>

        <h1 class="text-3xl font-bold mb-2">{{ $job->nama_lowongan }}</h1>
        <p class="text-gray-700">{{ $job->employer->company_name }}</p>
        <p class="text-gray-500">{{ $job->employer->alamat_perusahaan }}</p>
        <div class="mt-4 text-sm text-gray-600">{{ $job->jenislowongan }}</div>
        {{-- <div class="mt-4 text-sm text-gray-600">{{ $job->deskripsi }}</div> --}}


        <div class="mt-6 text-sm text-gray-400">Deskripsi lengkap lowongan...</div>
        <div class="h-[600px] bg-gray-100 rounded-md mt-4"></div>
    </div>
</x-jobseeker-layout>
