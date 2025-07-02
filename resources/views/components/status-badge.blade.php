@php
    $statusColor = [
        'pending' => 'bg-blue-200 text-blue-800',
        'reviewed' => 'bg-sky-200 text-sky-800',
        'interviewed' => 'bg-yellow-200 text-yellow-800',
        'accepted' => 'bg-green-200 text-green-800',
    ];


    $isExpired = $deadline && \Carbon\Carbon::parse($deadline)->lt(now());
    $label = $isExpired ? 'Berakhir' : ucfirst($status);
    $color = $isExpired ? 'bg-gray-200 text-gray-600' : ($statusColor[$status] ?? 'bg-gray-100 text-gray-800');
@endphp

<span class="text-xs {{ $color }} rounded-full px-2 py-1 font-semibold">
    {{ $label }}
</span>
