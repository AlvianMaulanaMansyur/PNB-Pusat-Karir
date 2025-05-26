@props([
    'name' => 'ketersediaan_bekerja',
    'selected' => null,
])

@php
    $ketersediaan = [
        'Tersedia saat ini' => 'Tersedia saat ini',
        '1 minggu' => '1 minggu',
        '2 minggu' => '2 minggu',
        '1 bulan' => '1 bulan',
        '2 bulan' => '2 bulan',
        '3 bulan' => '3 bulan',
    ];
@endphp

<div>
    <select name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge(['class' => 'border-gray-700  focus:border-[#7397EA] focus:ring-[#7397EA] rounded-md shadow-sm']) }}>
        <option value="">-</option>
        @foreach ($ketersediaan as $key => $value)
            <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>
</div>
