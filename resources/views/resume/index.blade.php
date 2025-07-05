<x-jobseeker-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Resume Saya</h1>
        </div>

        {{-- SECTION: Buat Resume Baru --}}
        <div class="bg-white p-6 rounded-lg shadow mb-10">
            <h2 class="text-xl font-bold mb-2 text-center">Are you uploading an existing CV?</h2>
            <p class="text-center text-gray-500 mb-6">Just review, edit, and update it with new information</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Upload CV -->
                <a href=""
                    class="border border-gray-300 rounded-lg p-6 text-center hover:shadow-lg transition hover:border-indigo-600 hover:ring-2 hover:ring-indigo-100">
                    <div class="flex flex-col items-center justify-center gap-2">
                        <img src="{{ asset('icons/upload-icon.png') }}" alt="Upload Icon" class="w-10 h-10" />
                        <h3 class="text-lg font-semibold text-gray-800">Yes, upload from my CV</h3>
                        <p class="text-sm text-gray-600">
                            We'll give you expert guidance to fill out your info and enhance your CV, from start to finish.
                        </p>
                    </div>
                </a>

                <!-- Start from Scratch -->
                <form action="{{ route('resumes.store') }}" method="POST"
                    class="border border-indigo-600 ring-2 ring-indigo-100 rounded-lg p-6 text-center hover:shadow-lg transition">
                    @csrf
                    <div class="flex flex-col items-center justify-center gap-2">
                        <img src="{{ asset('icons/edit-icon.png') }}" alt="Edit Icon" class="w-10 h-10" />
                        <h3 class="text-lg font-semibold text-gray-800">No, start from scratch</h3>
                        <p class="text-sm text-gray-600">
                            We'll guide you through the whole process so your skills can shine.
                        </p>
                        <input type="hidden" name="title" value="Untitled Resume" />
                        <button type="submit"
                            class="mt-4 bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-4 py-2 rounded shadow">
                            Start Now
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- SECTION: Daftar Resume --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-800 border border-green-200 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if ($resumes->isEmpty())
            <p class="text-gray-600">Kamu belum membuat resume.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($resumes as $resume)
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                        <div class="h-40 bg-gray-100 flex items-center justify-center text-gray-400 text-sm">
                            <img src="{{ $resume->preview_url ?? asset('images/default-resume-preview.png') }}"
                                alt="CV Preview" class="object-cover w-full h-full" />
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-lg text-gray-800">{{ $resume->title }}</h3>
                            <p class="text-sm text-gray-500">Terakhir Diperbarui:
                                {{ $resume->updated_at->diffForHumans() }}</p>

                            <div class="mt-4 flex flex-wrap gap-2">
                                <a href="{{ route('resumes.edit', $resume->slug) }}"
                                    class="px-4 py-2 text-white bg-indigo-600 hover:bg-indigo-700 rounded text-sm">
                                    Edit
                                </a>
                                <a href="{{ route('resumes.export.pdf', $resume->slug) }}"
                                    class="px-4 py-2 bg-gray-800 text-white rounded text-sm">
                                    Unduh
                                </a>
                                <form action="{{ route('resumes.destroy', $resume->slug) }}" method="POST"
                                    onsubmit="return confirm('Hapus resume ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-2 text-sm text-white bg-red-600 hover:bg-red-700 rounded">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-jobseeker-layout>
