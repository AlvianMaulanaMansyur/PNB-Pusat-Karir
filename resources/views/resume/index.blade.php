<x-jobseeker-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Resume Saya</h1>
            <div x-data="{ open: false }" class="relative">

                <!-- Tombol Trigger Modal -->
                <button @click="open = true"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow transition">
                    + Buat CV Baru
                </button>

                <!-- Overlay Modal -->
                <div x-show="open" x-cloak x-transition.opacity
                    class="fixed inset-0 z-40 bg-black bg-opacity-50 flex items-center justify-center"
                    style="display: none;">
                    <!-- Modal Box -->
                    <div @click.away="open = false" class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 z-50">
                        <h2 class="text-xl font-bold mb-4">Buat Resume Baru</h2>

                        <form action="{{ route('resumes.store') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul
                                    Resume</label>
                                <input type="text" id="title" name="title" value="{{ old('title') }}" required
                                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                @error('title')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex justify-end space-x-2">
                                <button type="button" @click="open = false"
                                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
                            {{-- @dd($resume->preview_url) --}}
                            <img src="{{ $resume->preview_url ?? asset('images/default-resume-preview.png') }}"
                                alt="CV Preview" class="object-cover w-full h-full" />
                        </div>

                        <div class="p-4">
                            <h3 class="font-semibold text-lg text-gray-800">{{ $resume->title }}</h3>
                            <p class="text-sm text-gray-500">Terakhir Diperbarui:
                                {{ $resume->updated_at->diffForHumans() }}</p>
                            {{-- <p class="text-green-600 font-medium mt-1">Selesai</p> --}}

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

    <!-- Modal Buat Resume Baru -->
    <div x-data="{ open: false }">
        <!-- Tombol trigger tetap di atas -->
        <!-- ... -->

        <!-- Modal -->
        <div x-show="open" x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="open = false" class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
                <h2 class="text-xl font-bold mb-4">Buat Resume Baru</h2>

                <form action="{{ route('resumes.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="title" class="block font-semibold text-sm mb-1">Judul Resume:</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('title')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
                            Simpan
                        </button>
                        <button type="button" @click="open = false"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-jobseeker-layout>
