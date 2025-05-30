@props([
    'name' => 'education',
    'selected' => null,
])

@php
    $pendidikan = [
        'Gelar Doktoral' => 'Gelar Doktoral',
        'Gelar Magister' => 'Gelar Magister',
        'Gelar Sarjana' => 'Gelar Sarjana',
        'Gelar Diploma lanjutan' => 'Gelar Diploma lanjutan',
        'Diploma' => 'Diploma',
        'SMA dan Dibawah' => 'SMA dan Dibawah',
    ];
@endphp
<div>
    <select name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge(['class' => 'border-gray-700  focus:border-[#7397EA] focus:ring-[#7397EA] rounded-md shadow-sm']) }}>
        <option value="">-</option>
        @foreach ($pendidikan as $key => $value)
            <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>
</div>
