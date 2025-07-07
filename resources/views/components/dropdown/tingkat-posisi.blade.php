@props([
    'name' => 'posisi',
    'selected' => null,
])

@php
    $tingkatposisi = [
        'Internship' => 'Internship',
        'Staff' => 'Staff',
        'Junior Staff' => 'Junior Staff',
        'Senior Staff' => 'Senior Staff',
        'Supervisor' => 'Supervisor',
        'Assistant Manager' => 'Assistant Manager',
        'Manager' => 'Manager',
        'Senior Manager' => 'Senior Manager',
        'Department Head' => 'Department Head',
        'Director' => 'Director',
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
