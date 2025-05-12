@props([
    'name' => 'previous_industry',
    'selected' => null,
])

@php
    $jobExperiences = [
        'Belum Pernah Bekerja' => 'Belum Pernah Bekerja',
        'Magang / PKL' => 'Magang / PKL',
        'Freelancer' => 'Freelancer',
        'Wiraswasta' => 'Wiraswasta',
        'Pegawai Swasta' => 'Pegawai Swasta',
        'Pegawai Negeri Sipil (PNS)' => 'Pegawai Negeri Sipil (PNS)',
        'Guru / Dosen' => 'Guru / Dosen',
        'Tenaga Kesehatan' => 'Tenaga',
        'Teknisi / Operator' => 'Teknisi / Operator',
        'Analis / Konsultan' => 'Analis / Konsultan',
        'Staf Administrasi' => 'Staf Administrasi',
        'Manajer / Supervisor' => 'Manajer / Supervisor',
        'Sales / Marketing' => 'Sales / Marketing',
        'Customer Service' => 'Customer Service',
        'IT Support / Helpdesk' => 'IT Support / Helpdesk',
        'Programmer / Developer' => 'Programmer / Developer',
        'Desainer Grafis' => 'Desainer Grafis',
        'Arsitek' => 'Arsitek',
        'Insinyur / Engineer' => 'Insinyur / Engineer',
        'Pekerja Lapangan / Proyek' => 'Pekerja Lapangan / Proyek',
        'Peneliti / Riset' => 'Peneliti / Riset',
        'Penulis / Editor' => 'Penulis / Editor',
        'Pekerja Lepas (Freelance)' => 'Pekerja Lepas (Freelance)',
        'Tidak Bekerja / Menganggur' => 'Tidak Bekerja / Menganggur',
        'Lainnya ' => 'Lainnya',
    ];
@endphp
<div>
    <select name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge(['class' => 'border-gray-700  focus:border-[#7397EA] focus:ring-[#7397EA] rounded-md shadow-sm']) }}>
        <option value="">-</option>
        @foreach ($jobExperiences as $key => $value)
            <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>
</div>
