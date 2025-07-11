<x-jobseeker-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">

        {{-- SECTION: Buat Resume Baru --}}
        <div class="bg-white p-6 mb-10 ">
            <h2 class="text-xl font-bold mb-2 text-center">Bagaimana Anda ingin membuat CV Anda?</h2>
            <p class="text-center text-gray-500 mb-6">
                Anda dapat menggunakan data dari profil Anda, atau memulai dari kosong.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Buat dari Profil -->
                <form action="{{ route('resumes.storeFromProfile') }}" method="POST"
                    class="border border-gray-300 rounded-lg p-6 text-center hover:shadow-lg transition hover:border-indigo-600 hover:ring-2 hover:ring-indigo-100">
                    @csrf
                    <div class="flex flex-col items-center justify-center gap-2">
                        <i class="fas fa-user-circle text-4xl text-darkBlue"></i>
                        <h3 class="text-lg font-semibold text-gray-800">Buat dari Profil Saya</h3>
                        <p class="text-sm text-gray-600">
                            Kami akan menggunakan informasi dari profil Anda (seperti data pribadi, pengalaman kerja,
                            dan pendidikan) untuk membuat CV dasar.
                        </p>
                        <input type="hidden" name="title" value="Resume" />
                        <button type="submit"
                            class="mt-4 bg-darkBlue hover:bg-darkBlue text-white text-sm px-4 py-2 rounded shadow">
                            Gunakan Profil
                        </button>
                    </div>
                </form>

                <!-- Mulai dari Kosong -->
                <form action="{{ route('resumes.store') }}" method="POST"
                    class="border border-gray-300 rounded-lg p-6 text-center hover:shadow-lg transition hover:border-indigo-600 hover:ring-2 hover:ring-indigo-100">
                    @csrf
                    <div class="flex flex-col items-center justify-center gap-2">
                        <i class="fas fa-file-alt text-4xl text-darkBlue"></i>
                        <h3 class="text-lg font-semibold text-gray-800">Mulai dari Kosong</h3>
                        <p class="text-sm text-gray-600">
                            Buat CV baru tanpa data sebelumnya dan isi semuanya dari awal.
                        </p>
                        <input type="hidden" name="title" value="Resume" />
                        <button type="submit"
                            class="mt-4 bg-darkBlue hover:bg-darkBlue text-white text-sm px-4 py-2 rounded shadow">
                            Mulai Sekarang
                        </button>
                    </div>
                </form>
            </div>

            {{-- Tombol Edit Resume Sebelumnya --}}
            @if (auth()->user()->employee->resumes()->exists())
                @php
                    $resume = auth()->user()->employee->resumes()->first();
                @endphp

                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-500 mb-2">Sudah pernah membuat resume sebelumnya?</p>
                    <a href="{{ route('resumes.edit', $resume->slug) }}"
                        class="inline-block bg-darkBlue text-white text-sm px-4 py-2 rounded shadow border border-gray-300">
                        Edit Resume Sebelumnya
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-jobseeker-layout>
