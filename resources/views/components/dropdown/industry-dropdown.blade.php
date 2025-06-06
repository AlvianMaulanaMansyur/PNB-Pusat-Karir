@props([
    'name' => 'industry',
    'selected' => null,
])

@php
    $industries = [
        'Akuntansi' => 'Akuntansi',
        'Arsitektur' => 'Arsitektur',
        'Asuransi' => 'Asuransi',
        'Bioteknologi' => 'Bioteknologi',
        'Bahan Kimia' => 'Bahan Kimia',
        'Desain Interior' => 'Desain Interior',
        'Dirgantara' => 'Dirgantara',
        'E-commerce' => 'E-commerce',
        'Elektronik' => 'Elektronik',
        'Energi' => 'Energi',
        'Farmasi' => 'Farmasi',
        'Fasilitas & Pemeliharaan' => 'Fasilitas & Pemeliharaan',
        'Fotografi' => 'Fotografi',
        'Garmen & Tekstil' => 'Garmen & Tekstil',
        'Grosir' => 'Grosir',
        'Hiburan' => 'Hiburan',
        'Hotel & Perjalanan' => 'Hotel & Perjalanan',
        'Ilmu Komputer' => 'Ilmu Komputer',
        'Industri Kreatif' => 'Industri Kreatif',
        'Jasa Hukum' => 'Jasa Hukum',
        'Jasa Makanan & Minuman' => 'Jasa Makanan & Minuman',
        'Kesehatan' => 'Kesehatan',
        'Konstruksi' => 'Konstruksi',
        'Keuangan & Investasi' => 'Keuangan & Investasi',
        'Layanan Konsultasi' => 'Layanan Konsultasi',
        'Logistik & Distribusi' => 'Logistik & Distribusi',
        'Manufaktur' => 'Manufaktur',
        'Media & Komunikasi' => 'Media & Komunikasi',
        'Minyak & Gas' => 'Minyak & Gas',
        'Organisasi Non-Profit' => 'Organisasi Non-Profit',
        'Pendidikan' => 'Pendidikan',
        'Perbankan' => 'Perbankan',
        'Pertanian' => 'Pertanian',
        'Periklanan & Pemasaran' => 'Periklanan & Pemasaran',
        'Perdagangan Internasional' => 'Perdagangan Internasional',
        'Properti & Real Estate' => 'Properti & Real Estate',
        'Riset & Pengembangan' => 'Riset & Pengembangan',
        'Retail' => 'Retail',
        'Seni & Budaya' => 'Seni & Budaya',
        'Sosial & Kemanusiaan' => 'Sosial & Kemanusiaan',
        'Teknologi Informasi' => 'Teknologi Informasi',
        'Telekomunikasi' => 'Telekomunikasi',
        'Transportasi' => 'Transportasi',
        'Veteriner' => 'Veteriner',
        'Wisata' => 'Wisata',
        'Yayasan & Lembaga Sosial' => 'Yayasan & Lembaga Sosial',
    ];
@endphp

<div>
    <select name="{{ $name }}" id="{{ $name }}" required
        {{ $attributes->merge(['class' => 'border-gray-700  focus:border-[#7397EA] focus:ring-[#7397EA] rounded-md shadow-sm']) }}>
        <option value="">-</option>
        @foreach ($industries as $key => $value)
            <option value="{{ $key }}" {{ $selected === $key ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach
    </select>
</div>
