<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Resume Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Pesan Status (dari session) --}}
            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            @if (session('warning'))
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <strong class="font-bold">Perhatian!</strong>
                    <span class="block sm:inline">{{ session('warning') }}</span>
                </div>
            @endif

            {{-- Tombol "Buat CV Baru" dan Batas Maksimal CV --}}
            <div class="mb-8">
                @if (!$canCreateNewCv)
                    <div class="p-4 mb-6 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 1 1-2 0V6a1 1 0 0 1 2 0v5Z" />
                        </svg>
                        <span class="sr-only">Info</span>
                        <div>
                            <span class="font-medium">Anda sudah mencapai limit batas maksimal
                                {{ $maxCvLimit }}.</span>
                        </div>
                    </div>
                @endif

                {{-- Ganti link dengan button untuk trigger modal --}}
                <button type="button" id="create-cv-button"
                    class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150
                          {{ !$canCreateNewCv ? 'opacity-50 cursor-not-allowed' : '' }}"
                    {{ !$canCreateNewCv ? 'disabled' : '' }}>
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Buat CV Baru
                </button>
            </div>

            {{-- Modal untuk input judul CV --}}
            <div id="create-cv-modal" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black bg-opacity-50">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow">
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Beri Judul CV Baru
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                data-modal-hide="create-cv-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <div class="p-4 md:p-5">
                            <form id="create-cv-form" action="{{ route('cv.create-new') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="cv-title" class="block mb-2 text-sm font-medium text-gray-900">Judul CV</label>
                                    <input type="text" name="title" id="cv-title"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5"
                                        placeholder="Misal: CV Software Engineer" required />
                                </div>
                                <button type="submit"
                                    class="w-full text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                    Buat CV Baru
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Resume Saya --}}
            <div class="mt-10">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Resume saya ({{ $userCvs->count() }})</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse ($userCvs as $cv)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                            <div class="h-48 bg-gray-100 flex items-center justify-center text-gray-400">
                                <img src="{{ asset('storage/cv_previews/default.png') }}" alt="CV Preview"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="p-4">
                                <h4 class="font-semibold text-gray-800 text-base truncate mb-1">{{ $cv->title }}</h4>
                                <p class="text-xs text-gray-500 mb-2">Terakhir Diperbarui:
                                    {{ $cv->updated_at->diffForHumans() }}</p>
                                <div class="flex items-center text-sm mb-4">
                                    <span
                                        class="text-green-500 font-bold mr-2">{{ $cv->status === 'completed' ? 'Selesai' : ucfirst($cv->status) }}</span>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('cv.edit', $cv->slug) }}"
                                        class="flex-1 bg-indigo-500 hover:bg-indigo-600 text-white py-2 px-3 rounded-md text-center text-sm">
                                        <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.232z">
                                            </path>
                                        </svg>
                                        Edit
                                    </a>

                                    <form action="{{ route('cv.download', $cv->slug) }}" method="POST">
                                        @csrf
                                        <div class="flex justify-center">
                                            <div class="flex justify-end">
                                                <button type="submit"
                                                    class="flex-1 bg-gray-700 hover:bg-gray-800 text-white py-2 px-3 rounded-md text-center text-sm">
                                                    <svg class="inline-block w-4 h-4 mr-1" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                                                        </path>
                                                    </svg>
                                                    Unduh
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="relative">
                                        <button id="dropdownMenuButton-{{ $cv->id }}"
                                            data-dropdown-toggle="dropdownDots-{{ $cv->id }}"
                                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50"
                                            type="button">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="currentColor" viewBox="0 0 16 3">
                                                <path
                                                    d="M2 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm6 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm6 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z" />
                                            </svg>
                                        </button>
                                        <div id="dropdownDots-{{ $cv->id }}"
                                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-40 absolute right-0 mt-2">
                                            <ul class="py-2 text-sm text-gray-700"
                                                aria-labelledby="dropdownMenuButton-{{ $cv->id }}">
                                                <li>
                                                    <a href="#"
                                                        class="block px-4 py-2 hover:bg-gray-100">Duplikat</a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="block px-4 py-2 hover:bg-gray-100 text-red-600"
                                                        onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus CV ini?')) { document.getElementById('delete-cv-{{ $cv->id }}-form').submit(); }">Hapus</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <form id="delete-cv-{{ $cv->id }}-form"
                                            action="{{ route('cv.destroy', $cv->slug) }}" method="POST"
                                            class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="col-span-full text-center text-gray-600">Anda belum membuat CV apapun. Klik "Buat CV
                            Baru" untuk memulai!</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Handle dropdowns
            document.querySelectorAll('[data-dropdown-toggle]').forEach(button => {
                const dropdownId = button.getAttribute('data-dropdown-toggle');
                const dropdownEl = document.getElementById(dropdownId);
                if (dropdownEl) {
                    button.addEventListener('click', (event) => {
                        event.stopPropagation();
                        document.querySelectorAll('.z-10.hidden').forEach(otherDropdown => {
                            if (otherDropdown.id !== dropdownId) {
                                otherDropdown.classList.add('hidden');
                            }
                        });
                        dropdownEl.classList.toggle('hidden');
                    });
                }
            });

            document.addEventListener('click', (event) => {
                document.querySelectorAll('[data-dropdown-toggle]').forEach(button => {
                    const dropdownId = button.getAttribute('data-dropdown-toggle');
                    const dropdownEl = document.getElementById(dropdownId);
                    if (dropdownEl && !dropdownEl.contains(event.target) && !button.contains(event.target)) {
                        dropdownEl.classList.add('hidden');
                    }
                });
            });

            // Handle CV creation modal
            const createCvButton = document.getElementById('create-cv-button');
            const modal = document.getElementById('create-cv-modal');
            const form = document.getElementById('create-cv-form');
            
            // Open modal when button is clicked
            if (createCvButton) {
                createCvButton.addEventListener('click', () => {
                    if (!createCvButton.disabled) {
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                        document.body.classList.add('overflow-hidden');
                    }
                });
            }

            // Close modal when clicking outside
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    document.body.classList.remove('overflow-hidden');
                }
            });

            // Close modal when close button is clicked
            const closeButtons = document.querySelectorAll('[data-modal-hide="create-cv-modal"]');
            closeButtons.forEach(button => {
                button.addEventListener('click', () => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    document.body.classList.remove('overflow-hidden');
                });
            });

            // Handle form submission
            if (form) {
                form.addEventListener('submit', function(e) {
                    const titleInput = document.getElementById('cv-title');
                    if (!titleInput.value.trim()) {
                        e.preventDefault();
                        alert('Judul CV tidak boleh kosong');
                        titleInput.focus();
                    }
                });
            }
        });
    </script>
</x-app-layout>