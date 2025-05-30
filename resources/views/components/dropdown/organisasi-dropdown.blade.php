@props([
    'name' => 'organisasi',
    'selected' => null,
])

@php

    $organisasi = [
        'starup' => 'Startup',
        'Usaha Kecil dan Menengah(UMKM)' => 'Usaha kecil menengah',
        'Korporasi multi-nasional' => 'Korporasi multi-nasional',
    ];
@endphp

<div>
    <select name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge(['class' => 'border-gray-700  focus:border-[#7397EA] focus:ring-[#7397EA] rounded-md shadow-sm']) }}>
        <option value="">-- Pilih Organisasi --</option>
        @foreach ($organisasi as $key => $value)
            <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>
</div>
