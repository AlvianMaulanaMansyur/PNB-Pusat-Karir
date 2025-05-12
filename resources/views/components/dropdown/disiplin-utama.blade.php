@props([
    'selected' => null,
    'name' => 'bidang',
])

@php
    $bidang = [
        'Akuntansi' => 'Akuntansi',
        'Arsitektur' => 'Arsitektur',
        'Bisnis dan Pengembangan Usaha' => 'Bisnis dan Pengembangan Usaha',
        'Desain Grafis' => 'Desain Grafis',
        'Desain Interior' => 'Desain Interior',
        'Desain Produk' => 'Desain Produk',
        'Ekonomi' => 'Ekonomi',
        'Farmasi' => 'Farmasi',
        'Hukum' => 'Hukum',
        'Hubungan Masyarakat (Humas)' => 'Hubungan Masyarakat (Humas)',
        'Ilmu Komunikasi' => 'Ilmu Komunikasi',
        'Ilmu Komputer' => 'Ilmu Komputer',
        'Ilmu Lingkungan' => 'Ilmu Lingkungan',
        'Ilmu Pendidikan' => 'Ilmu Pendidikan',
        'Ilmu Politik' => 'Ilmu Politik',
        'Keuangan' => 'Keuangan',
        'Kesehatan Masyarakat' => 'Kesehatan Masyarakat',
        'Kesehatan dan Keperawatan' => 'Kesehatan',
        'Logistik' => 'Logistik',
        'Manajemen Konstruksi' => 'Manajemen Konstruksi',
        'Manajemen Proyek' => 'Manajemen Proyek',
        'Manufaktur dan Produksi' => 'Manufaktur dan Produksi',
        'Marketing dan Pemasaran' => 'Marketing dan Pemasaran',
        'Pariwisata dan Perhotelan' => 'Pariwisata dan Perhotelan',
        'Pengembangan Perangkat Lunak' => 'Pengembangan Perangkat Lunak',
        'Pengembangan Produk' => 'Pengembangan Produk',
        'Pendidikan dan Pengajaran' => 'Pendidikan dan Pengajaran',
        'Perdagangan dan Penjualan' => 'Perdagangan dan Penjualan',
        'Psikologi' => 'Psikologi',
        'Riset dan Pengembangan' => 'Riset dan Pengembangan',
        'Sains Data' => 'Sains Data',
        'Sistem Informasi' => 'Sistem Informasi',
        'Sosiologi' => 'Sosiologi',
        'Statistika' => 'Statistika',
        'Sumber Daya Manusia' => 'Sumber Daya Manusia',
        'Teknik Elektro' => 'Teknik Elektro',
        'Teknik Industri' => 'Teknik Industri',
        'Teknik Informatika' => 'Teknik Informatika',
        'Teknik Lingkungan' => 'Teknik Lingkungan',
        'Teknik Mesin' => 'Teknik Mesin',
        'Teknik Sipil' => 'Teknik Sipil',
        'Teknologi Informasi' => 'Teknologi Informasi',
        'Transportasi' => 'Transportasi',
        'Lainnya ' => 'Lainnya',
    ];
@endphp

<div>
    <select name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge(['class' => 'border-gray-700  focus:border-[#7397EA] focus:ring-[#7397EA] rounded-md shadow-sm']) }}>
        <option value="">-</option>
        @foreach ($bidang as $key => $value)
            <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>
</div>
