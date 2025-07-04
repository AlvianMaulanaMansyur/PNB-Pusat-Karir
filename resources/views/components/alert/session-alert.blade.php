@props(['type' => 'info', 'message' => null])

@php
    $colorClasses = [
        'error' => 'bg-red-100 border-red-400 text-red-700',
        'success' => 'bg-green-100 border-green-400 text-green-700',
        'info' => 'bg-blue-100 border-blue-400 text-blue-700',
        'warning' => 'bg-yellow-100 border-yellow-400 text-yellow-700',
    ];

    $classes = $colorClasses[$type] ?? $colorClasses['info'];
@endphp

@if ($message)
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
        class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 px-4 py-3 rounded shadow border {{ $classes }}">
        <p class="text-sm font-medium">{{ $message }}</p>
    </div>
@endif
