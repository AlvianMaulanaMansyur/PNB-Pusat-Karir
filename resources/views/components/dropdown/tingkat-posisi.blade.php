@props([
    'name' => 'posisi',
    'selected' => null,
])

@php
    $tingkatposisi = [
        'Internship / Magang' => 'Internship / Magang',
        'Entry Level / Staf' => 'Entry Level / Staf',
        'Junior Staff' => 'Junior Staff',
        'Senior Staff' => 'Senior Staff',
        'Supervisor / Koordinator' => 'Supervisor / Koordinator',
        'Assistant Manager' => 'Assistant Manager',
        'Manager' => 'Manager',
        'Senior Manager' => 'Senior Manager',
        'Department Head' => 'Department Head',
        'Director / Executive' => 'Director / Executive',
    ];
@endphp
<div>
    <select name="{{ $name }}"
        {{ $attributes->merge(['class' => 'border-gray-700  focus:border-[#7397EA] focus:ring-[#7397EA] rounded-md shadow-sm']) }}>
        <option value="" class="bg-grey">-</option>
        @foreach ($tingkatposisi as $key => $value)
            <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>
</div>
