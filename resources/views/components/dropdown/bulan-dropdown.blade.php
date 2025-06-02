@props([
    'name' => 'education',
    'selected' => null,
])

@php
    $pendidikan = [
        'Januari' => 'Januari',
        'Februari' => 'Februari',
        'Maret' => 'Maret',
        'April' => 'April',
        'Mei' => 'Mei',
        'Juni' => 'Juni',
        'Juli' => 'Juli',
        'Agustus' => 'Agustus',
        'September' => 'September',
        'Oktober' => 'Oktober',
        'November' => 'November',
        'Desember' => 'Desember',
    ];
@endphp
<div>
    <select name="{{ $name }}"
        {{ $attributes->merge(['class' => 'border-gray-700  focus:border-[#7397EA] focus:ring-[#7397EA] rounded-md shadow-sm']) }}>
        <option value="">Pilih Bulan</option>
        @foreach ($pendidikan as $key => $value)
            <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>
</div>
