@props([
    'name' => 'staff',
    'selected' => null,
])

@php
    $kekuatan = [
        '1-10' => '1-10',
        '11-50' => '11-50',
        '51-200' => '51-200',
        '201-500' => '201-500',
        '501-1000' => '501-1000',
        '1001-5000' => '1001-5000',
        '5001-10000' => '5001-10000',
        '10001+' => '10001+',
    ];
@endphp

<div>
    <select name="{{ $name }}" id="{{ $name }}" required
        {{ $attributes->merge(['class' => 'border-gray-700  focus:border-[#7397EA] focus:ring-[#7397EA] rounded-md shadow-sm']) }}>
        <option value="">-</option>
        @foreach ($kekuatan as $key => $value)
            <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>
</div>
