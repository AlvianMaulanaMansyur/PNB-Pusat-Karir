<x-jobseeker-layout>
    <h2 class="text-2xl font-bold mb-4">Notifikasi Anda</h2>

    @forelse ($notifications as $notification)
        <div class="bg-white p-4 shadow rounded mb-4">
            <h3 class="text-lg font-semibold">{{ $notification->data['title'] }}</h3>
            <p>{{ $notification->data['message'] }}</p>
            <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
        </div>
    @empty
        <p class="text-gray-600">Tidak ada notifikasi.</p>
    @endforelse
</x-jobseeker-layout>
