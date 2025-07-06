<x-jobseeker-layout>
    <section class="mb-20">
        <div class="w-full max-w-screen-xl mx-auto mt-10 md:px-20">
            <x-breadcrumb :links="[['label' => 'Home', 'url' => route('employee.lowongan')], ['label' => 'Notifikasi']]" />
        </div>
        <div class="w-full max-w-screen-xl mx-auto mt-10 ">
            <a href="{{ url()->previous() }}" class="text-blue-500  mb-4 inline-block">← Kembali</a>
            <h2 class="text-2xl font-bold mb-4">Notifikasi Anda</h2>

            @forelse ($notifications as $notification)
                <div class="bg-white p-4 shadow rounded-xl mb-4 border-2 border-gray-400">
                    <h3 class="text-lg font-semibold">{{ $notification->data['title'] }}</h3>
                    <p>{{ $notification->data['message'] }}</p>

                    <div class="mt-2">
                        @if (isset($notification->data['job_id']))
                            <a href="{{ route('applied.index', ['selected' => $notification->data['job_id']]) }}"
                                class="text-sm text-blue-600 hover:underline">
                                Lihat Lamaran Terkait...
                            </a>
                        @endif
                    </div>

                    <p class="text-xs text-gray-500 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <p class="text-gray-600">Tidak ada notifikasi.</p>
            @endforelse

        </div>
    </section>
</x-jobseeker-layout>
