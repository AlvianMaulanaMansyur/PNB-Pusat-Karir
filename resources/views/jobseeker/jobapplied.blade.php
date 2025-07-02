<x-jobseeker-layout>
    <x-jobseeker.stepper :current="3" />

    <section class="py-12">
        <div class="flex justify-center">
            <div
                class="bg-gradient-to-b from-[#0f1c48] to-[#0967b0] text-white rounded-3xl px-10 py-16 w-full max-w-screen-lg text-center shadow-lg">
                <div class="flex flex-col items-center space-y-6">
                    <!-- Ikon centang -->
                    <svg width="101" height="100" viewBox="0 0 101 100" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M88 50C88 70.7107 71.2107 87.5 50.5 87.5C29.7893 87.5 13 70.7107 13 50C13 29.2893 29.7893 12.5 50.5 12.5C56.3836 12.5 61.9506 13.855 66.9062 16.2698M80.9688 26.5625L48.1562 59.375L38.7812 50"
                            stroke="white" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    <!-- Teks -->
                    <p class="text-xl font-semibold">Lamaran Anda telah dikirim!</p>
                    <p class="text-sm">Cek notifikasi secara berkala untuk tindakan berikutnya.</p>
                </div>
            </div>
        </div>

        <!-- Tombol -->
        <div class="flex justify-center mt-6">
            <a href="{{ route('employee.lowongan') }}">
                <x-primary-button>
                    {{ __('Kembali ke Beranda') }}
                </x-primary-button>
            </a>
        </div>
    </section>
</x-jobseeker-layout>

