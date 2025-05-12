@props([
    'name' => 'jenis_pekerjaan',
    'selected' => null,
])

@php
    $jenisPekerjaan = [
        'Penuh Waktu' => 'Penuh Waktu',
        'Paruh Waktu' => 'Paruh Waktu',
        'Kontrak' => 'Kontrak',
        'Magang' => 'Magang',
        'Freelance' => 'Freelance',
        'Sukarela' => 'Sukarela',
        'Lainnya' => 'Lainnya',
    ];
@endphp

<div>
    <select name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge(['class' => 'border-gray-700  focus:border-[#7397EA] focus:ring-[#7397EA] rounded-md shadow-sm']) }}>
        <option value="">-</option>
        @foreach ($jenisPekerjaan as $key => $value)
            <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>
</div>
