@props([
    'name' => 'report_reason',
    'selected' => null,
])

@php
    $reasons = [
        'Penipuan' => 'Penipuan',
        'Diskriminasi' => 'Diskriminasi',
        'Iklan Menyesatkan' => 'Iklan Menyesatkan',
        'Lainnya' => 'Lainnya',
    ];
@endphp

<div>
    <select name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge(['class' => 'border-gray-700 focus:border-[#7397EA] focus:ring-primaryColor rounded-md shadow-sm']) }}>
        <option value="">-</option>
        @foreach ($reasons as $key => $value)
            <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get($name)" class="mt-2" />
</div>
