@props([
    'name' => 'jabatan',
    'selected' => null,
])

@php
    $jabatan = [
        'Manajemen Senior' => 'Manajemen Senior',
        'Manajemen Menengah' => 'Manajemen Menengah',
        'Manajemer' => 'Manajemer',
        'Profesional' => 'Profesional',
        'Senior Eksekutif' => 'Senior Eksekutif',
        'Eksekutif' => 'Eksekutif',
        'Junior Eksekutif' => 'Junior Eksekutif',
        'Non-Eksekutif' => 'Non-Eksekutif',
        'Baru/Tingkat Pemula' => 'Baru/Tingkat Pemula',
    ];

@endphp
<div>
    <select name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge(['class' => 'border-gray-700  focus:border-[#7397EA] focus:ring-[#7397EA] rounded-md shadow-sm']) }}>
        <option value="">-</option>
        @foreach ($jabatan as $key => $value)
            <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>
</div>
