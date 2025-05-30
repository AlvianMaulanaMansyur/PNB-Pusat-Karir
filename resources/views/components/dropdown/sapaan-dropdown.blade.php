@props([
    'name' => 'sapaan',
    'selected' => null,
])

@php
    $sapaan = [
        'Mr' => 'Mr',
        'Ms' => 'Ms',
        'Mrs' => 'Mrs',
        'Mx' => 'Mx',
    ];
@endphp
<div>
    <select name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge(['class' => 'border-gray-700  focus:border-[#7397EA] focus:ring-[#7397EA] rounded-md shadow-sm']) }}>
        <option value="">-</option>
        @foreach ($sapaan as $key => $value)
            <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>
</div>
