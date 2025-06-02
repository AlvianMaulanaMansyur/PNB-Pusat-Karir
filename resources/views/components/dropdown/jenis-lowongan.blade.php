@props([
    'name' => 'jenislowongan',
    'selected' => null,
])

@php
    $jenis_lowongan = [
        'Full Time' => 'Full Time',
        'Part Time' => 'Part Time',
        'Freelance' => 'Freelance',
        'Internship (Magang)' => 'Internship (Magang)',
        'Contract' => 'Contract',
        'Temporary' => 'Temporary',
        'Remote' => 'Remote',
        'Hybrid' => 'Hybrid',
    ];
@endphp
<div>
    <select name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge(['class' => 'focus:ring-[#7397EA] rounded-md shadow-sm']) }}>
        <option value="">-</option>
        @foreach ($jenis_lowongan as $key => $value)
            <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>
</div>