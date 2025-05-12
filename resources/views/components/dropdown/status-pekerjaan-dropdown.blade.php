@props([
    'name' => 'status',
    'selected' => null,
])

@php
    $statusPekerjaan = [
        'Bekerja' => 'Bekerja',
        'Wirausaha' => 'Wirausaha',
        'Belum Bekerja' => 'Belum Bekerja',
        'Dirumahkan' => 'Dirumahkan',
        'Masih Kuliah' => 'Masih Kuliah',
    ];
@endphp

<div>
    <select name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge(['class' => 'border-gray-700  focus:border-[#7397EA] focus:ring-[#7397EA] rounded-md shadow-sm']) }}>
        <option value="">-</option>
        @foreach ($statusPekerjaan as $key => $value)
            <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>
</div>
