@extends('employer.layouts.app')

@section('content')
{{-- Tampilkan pesan success --}}
@if (session('success'))
<x-alert.session-alert type="success" :message="session('success')" />
@endif

{{-- Tampilkan pesan error umum --}}
@if (session('error'))
<x-alert.session-alert type="error" :message="session('error')" />
@endif

{{-- Tampilkan error validasi (opsional, tampilkan error pertama) --}}
@if ($errors->any())
<x-alert.session-alert type="error" :message="$errors->first()" />
@endif

{{-- Judul Halaman --}}
<div class="flex justify-start">
    <div class="flex flex-col w-full lg:w-2/3 text-left mx-4 md:mx-10 lg:mx-20 lg:ml-28">
        <p class="text-md text-gray-600">Selamat datang di halaman</p>
        <p class="font-semibold text-2xl 2xl:text-3xl my-2 text-gray-800">Temukan Kandidat</p>
        <div class="w-32 h-1 bg-blue-500 rounded mb-4"></div>
        <p class="text-gray-600 text-sm mb-3">Cari dan telusuri profil pelamar kerja yang sesuai dengan kriteria Anda.</p>

        <div class="flex items-start space-x-4 border-l-4 border-blue-600 bg-blue-50 rounded-md p-5 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 mt-1" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
            </svg>
            <div>
                <h3 class="text-blue-700 font-semibold text-base mb-1">Informasi Tambahan</h3>
                <p class="text-blue-800 text-sm leading-relaxed">
                    Halaman ini memudahkan Anda untuk menemukan kandidat terbaik berdasarkan jurusan, keahlian, dan data lainnya yang tersedia dalam sistem. Gunakan fitur pencarian untuk menelusuri pelamar yang paling sesuai dengan kebutuhan lowongan Anda.
                </p>
            </div>
        </div>

        <a href="{{ route('employer.dashboard') }}"
            class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium mt-2 transition duration-300">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Halaman Utama
        </a>
    </div>
</div>

{{-- Multi-select Skill Filter --}}
{{-- Filter Skill Kandidat --}}
<section class="mt-12 flex justify-center px-4">
    <form id="skill-filter-form" method="GET" action="{{ route('employer.temukan-kandidat') }}"
        class="w-full max-w-5xl bg-white border border-gray-200 rounded-2xl shadow-sm p-6 space-y-6">

        {{-- Judul Form --}}
        <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-1">Filter Kandidat</h2>
            <p class="text-sm text-gray-500">Pilih satu atau beberapa skill untuk menemukan kandidat yang sesuai.</p>
        </div>

        {{-- Select Skill --}}
        <div>
            <label for="skills" class="block text-sm font-medium text-gray-700 mb-2">Pilih Skill</label>
            <div class="relative">
                <select id="skills" name="skills[]" multiple placeholder="Ketik atau pilih skill..."
                    class="tom-select w-full border border-gray-300 rounded-full shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    @foreach ($skills as $skill)
                    <option value="{{ $skill->id }}"
                        {{ in_array($skill->id, (array) request('skills')) ? 'selected' : '' }}>
                        {{ $skill->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Tombol Submit --}}
        <div class="flex justify-end">
            <button type="submit"
                class="inline-flex items-center gap-2 bg-primaryColor hover:bg-darkBlue text-white text-sm font-semibold px-6 py-2.5 rounded-md transition shadow-customblue">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" />
                </svg>
                Cari Kandidat
            </button>
        </div>
    </form>
</section>

{{-- Tampilkan jika ada filter pencarian --}}
@if(request()->has('skills') && count(request('skills')) > 0)

{{-- Judul Daftar Kandidat --}}
<section class="mt-12 flex justify-center px-4">
    <div class="w-full max-w-5xl">
        <h2 class="text-lg font-semibold text-gray-800">Hasil Pencarian Kandidat</h2>
        <p class="text-sm text-gray-500">Berikut adalah daftar pelamar berdasarkan skill yang Anda pilih.</p>
    </div>
</section>

{{-- Tabel Kandidat --}}
<section class="mt-4 flex justify-center px-4">
    <div class="w-full max-w-5xl overflow-x-auto bg-white border border-gray-200 rounded-xl shadow-sm">
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-gray-100 text-gray-600 text-xs uppercase">
                <tr>
                    <th class="px-5 py-3 text-left">-</th>
                    <th class="px-5 py-3 text-left">Nama</th>
                    <th class="px-5 py-3 text-left">Email</th>
                    <th class="px-5 py-3 text-left">Negara</th>
                    <th class="px-5 py-3 text-left">Kota</th>
                    <th class="px-5 py-3 text-left">Skill</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($candidates as $index => $candidate)
                <tr class="border-t hover:bg-gray-50">
                    {{-- Ganti angka dengan ikon detail --}}
                    <td class="px-5 py-3 text-center">
                        <a href="{{ route('employer.detail-kandidat', ['slug' => Auth::user()->employer->slug, 'id' => $candidate->id]) }}?{{ http_build_query(['skills' => request('skills')]) }}"
                            class="text-blue-600 hover:text-blue-800 transition"
                            title="Lihat Detail">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 3c-5 0-9 5-9 7s4 7 9 7 9-5 9-7-4-7-9-7zm0 12a5 5 0 110-10 5 5 0 010 10z" />
                                <path d="M10 7a3 3 0 100 6 3 3 0 000-6z" />
                            </svg>
                        </a>
                    </td>

                    {{-- Nama kandidat --}}
                    <td class="px-5 py-3">{{ $candidate->first_name }} {{ $candidate->last_name ?? '-' }}</td>

                    {{-- Email --}}
                    <td class="px-5 py-3">{{ $candidate->email ?? '-' }}</td>

                    {{-- Country --}}
                    <td class="px-5 py-3">{{ $candidate->country ?? '-' }}</td>

                    {{-- City --}}
                    <td class="px-5 py-3">{{ $candidate->city ?? '-' }}</td>

                    {{-- Skills --}}
                    <td class="px-5 py-3">{{ $candidate->skills ?? '-' }}</td>

                    {{-- Aksi (hanya tombol Invite) --}}
                    <td class="px-5 py-3 text-right">
                        <button type="button"
                            onclick="document.getElementById('invite-modal-{{ $index }}').classList.remove('hidden')"
                            class="px-4 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition">
                            Invite Kandidat
                        </button>
                    </td>
                </tr>

                {{-- Modal Undang Kandidat ke Lowongan --}}
                <div id="invite-modal-{{ $index }}" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center">
                    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 relative">

                        {{-- Tombol Close --}}
                        <button type="button"
                            onclick="document.getElementById('invite-modal-{{ $index }}').classList.add('hidden')"
                            class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <h3 class="text-lg font-semibold mb-4">Pilih Lowongan untuk Mengundang</h3>

                        <form method="POST" id="invite-form-{{ $index }}"
                            action="{{ route('employer.send-invitation', ['jobId' => $jobListings->first()->id ?? 0, 'userId' => $candidate->user_id]) }}">
                            @csrf

                            <div class="mb-4">
                                <label for="job_id_{{ $index }}" class="block text-sm font-medium text-gray-700">Lowongan</label>
                                <select name="job_id" id="job_id_{{ $index }}" required class="w-full mt-1 p-2 border rounded"
                                    onchange="updateInviteAction({{ $index }}, this.value, {{ $candidate->user_id }})">
                                    @forelse ($jobListings as $job)
                                    <option value="{{ $job->id }}">{{ $job->nama_lowongan }}</option>
                                    @empty
                                    <option disabled>Tidak ada lowongan tersedia</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="text-right">
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                                    Kirim Undangan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @empty
                <tr class="border-t">
                    <td colspan="5" class="px-5 py-4 text-center text-gray-500">Tidak ada kandidat ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

@else
{{-- Pesan jika belum melakukan pencarian --}}
<div class="mt-16 text-center text-sm text-gray-500">
    Silakan pilih satu atau beberapa skill untuk menampilkan kandidat yang sesuai.
</div>
@endif



<!-- Tombol Kembali ke Atas -->
<button id="backToTop" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
    class="hidden fixed bottom-6 right-6 z-50 bg-gradient-to-tr from-blue-600 to-indigo-600 text-white p-3 rounded-full shadow-xl hover:scale-110 hover:shadow-2xl transition-all duration-300"
    title="Kembali ke atas" aria-label="Kembali ke atas">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
    </svg>
</button>

<script>
    // Tampilkan tombol setelah scroll 300px
    window.addEventListener('scroll', () => {
        const btn = document.getElementById('backToTop');
        btn.style.display = window.scrollY > 300 ? 'flex' : 'none';
    });
</script>

<script>
    new TomSelect("#skills", {
        create: true, // Allow user to add custom skill not in list
        persist: false,
        maxItems: null,
        plugins: ['remove_button'],
        valueField: 'value',
        labelField: 'text',
        searchField: ['text'],
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('skill-filter-form');

        form.addEventListener('submit', function(e) {
            e.preventDefault(); // cegah form submit langsung

            // Tampilkan loading
            Swal.fire({
                title: 'Mencari Kandidat...',
                text: 'Silakan tunggu sebentar.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                    form.submit(); // submit form setelah Swal tampil
                }
            });
        });
    });
</script>
<script>
    function updateInviteAction(index, jobId, userId) {
        const form = document.getElementById('invite-form-' + index);
        form.action = `/employer/send-invitation/${jobId}/${userId}`;
    }
</script>

@endsection