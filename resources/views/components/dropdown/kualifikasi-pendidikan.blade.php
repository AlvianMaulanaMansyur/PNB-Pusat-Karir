@props([
'name' => 'kualifikasi',
'selected' => null,
])

@php
$kualifikasi = [
'Programmer / Developer' => 'Programmer / Developer',
'IT Support' => 'IT Support',
'UI/UX Designer' => 'UI/UX Designer',
'Cyber Security' => 'Cyber Security',
'Data Analyst' => 'Data Analyst',

'Admin Umum' => 'Admin Umum',
'Sekretaris' => 'Sekretaris',
'Resepsionis' => 'Resepsionis',

'Akuntan' => 'Akuntan',
'Staf Keuangan' => 'Staf Keuangan',
'Auditor' => 'Auditor',

'Sales Executive' => 'Sales Executive',
'Digital Marketing' => 'Digital Marketing',
'Customer Service' => 'Customer Service',
'Brand Manager' => 'Brand Manager',

'Tutor Privat' => 'Tutor Privat',
'Staff Akademik' => 'Staff Akademik',

'Operator Produksi' => 'Operator Produksi',
'Teknik Mesin' => 'Teknik Mesin',
'Teknik Elektro' => 'Teknik Elektro',
'Quality Control' => 'Quality Control',

'Desainer Grafis' => 'Desainer Grafis',
'Fotografer' => 'Fotografer',
'Videografer' => 'Videografer',
'Content Creator' => 'Content Creator',

'Tour Guide' => 'Tour Guide',
'Resepsionis Hotel' => 'Resepsionis Hotel',
'Chef / Cook' => 'Chef / Cook',
'Housekeeping' => 'Housekeeping',


];
@endphp
<div>
    <select id="kualifikasi-select" name="{{ $name }}"
        {{ $attributes->merge(['class' => 'border-gray-700  focus:border-[#7397EA] focus:ring-[#7397EA] rounded-md shadow-sm']) }}>
        <option value="">-</option>
        @foreach ($kualifikasi as $key => $value)
        <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        new TomSelect('#kualifikasi-select', {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    });
</script>
<!-- <div>
    <select name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge(['class' => 'border-gray-700  focus:border-[#7397EA] focus:ring-[#7397EA] rounded-md shadow-sm']) }}>
        <option value="">-</option>
        @foreach ($kualifikasi as $key => $value)
        <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>
</div> -->