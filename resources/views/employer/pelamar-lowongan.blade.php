@extends('employer.layouts.app')

@section('content')

{{-- Judul Halaman --}}
<div class="flex justify-start">
    <div class="flex flex-col w-full lg:w-2/3 text-left mx-4 md:mx-10 lg:mx-20 lg:ml-28">
        <p class="text-md text-gray-600">Selamat datang di halaman</p>
        <p class="font-semibold text-2xl 2xl:text-3xl my-2 text-gray-800">Manajemen Pelamar Lowongan</p>
        <div class="w-28 h-1 bg-blue-500 rounded mb-4"></div>
        <p class="text-gray-600 text-sm mb-3">Lihat dan kelola semua pelamar yang mendaftar ke lowongan pekerjaan Anda.</p>
        <div class="flex items-start space-x-4 border-l-4 border-blue-600 bg-blue-50 rounded-md p-5 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z" />
            </svg>
            <div>
                <h3 class="text-blue-700 font-semibold text-lg mb-1">Informasi Tambahan</h3>
                <p class="text-blue-800 text-sm leading-relaxed max-w-prose">
                    Halaman ini digunakan oleh pemberi kerja untuk melihat daftar pelamar yang telah mengajukan lamaran ke lowongan pekerjaan Anda. Anda dapat meninjau profil pelamar, mengunduh CV, serta memberikan keputusan atau tindak lanjut terhadap lamaran yang masuk.
                </p>
            </div>
        </div>
        <a href="javascript:history.back()" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium transition duration-300 mb-4">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Halaman Sebelumnya
        </a>
    </div>
</div>

{{-- Daftar Tabel Pelamar Per Lowongan --}}
<div class="flex flex-col w-full lg:w-2/3 mx-4 md:mx-10 lg:mx-20 lg:ml-28">
    @forelse ($applications as $jobId => $jobApps)
    <div class="mb-10">
        <div class="flex items-center justify-between mb-2">
            <h2 class="text-lg font-semibold text-gray-800">
                Lowongan: {{ $jobApps->first()->job->nama_lowongan }} ({{ $jobApps->first()->job->posisi }})
            </h2>
            <span class="text-sm text-gray-500">Total Pelamar: {{ $jobApps->count() }}</span>
        </div>

        <div class="overflow-x-auto bg-white border border-gray-200 rounded-lg shadow-sm">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 font-medium">Nama Pelamar</th>
                        <th class="px-5 py-3 font-medium">Status Aplikasi</th>
                        <th class="px-5 py-3 font-medium">Tanggal Melamar</th>
                        <th class="px-5 py-3 font-medium">CV</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($jobApps as $app)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-4">
                            {{ $app->employee->first_name }} {{ $app->employee->last_name }}
                        </td>
                        <td class="px-5 py-4 capitalize">
                            <form action="{{ route('employer.updateStatus', $app->slug) }}" method="POST" id="form-{{ $app->slug }}">
                                @csrf
                                @method('PATCH')

                                <select name="status" class="text-sm border rounded px-2 py-1"
                                    onchange="handleStatusChange('{{ $app->slug }}', this.value)">
                                    <option value="pending" {{ $app->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="reviewed" {{ $app->status === 'reviewed' ? 'selected' : '' }}>Interview</option>
                                    <option value="accepted" {{ $app->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="rejected" {{ $app->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>

                                {{-- Show input only if status is reviewed --}}
                                <div id="interview-container-{{ $app->slug }}" class="{{ $app->status === 'reviewed' ? '' : 'hidden' }} mt-2">
                                    <input type="datetime-local" name="interview_date"
                                        value="{{ $app->interview_date ? \Carbon\Carbon::parse($app->interview_date)->format('Y-m-d\TH:i') : '' }}"
                                        class="block border rounded px-2 py-1 text-sm">
                                    <button type="submit"
                                        class="mt-2 inline-block bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </td>
                        <td class="px-5 py-4">
                            {{ $app->applied_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-5 py-4">
                            @if ($app->cv_file)
                            <a href="{{ asset('storage/cv_files/' . $app->cv_file) }}" target="_blank"
                                class="text-blue-600 underline">Download CV</a>
                            @else
                            <span class="text-gray-400 italic">Tidak ada</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-5 py-4 text-center text-gray-500">Belum ada pelamar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @empty
    <p class="text-center text-gray-500 mt-10">Belum ada pelamar untuk semua lowongan.</p>
    @endforelse
</div>


<!-- Tombol Kembali ke Atas -->
<button id="backToTop"
    onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
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
    function handleStatusChange(slug, value) {
        const container = document.getElementById(`interview-container-${slug}`);
        const form = document.getElementById(`form-${slug}`);

        if (value === 'reviewed') {
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
            form.submit();
        }
    }
</script>

@endsection