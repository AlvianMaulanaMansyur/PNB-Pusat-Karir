<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CV - {{ $personalInformation->full_name ?? 'CV' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20mm;
            font-size: 10pt;
            line-height: 1.5; /* Tambahkan sedikit line-height untuk keterbacaan */
        }
        h1, h2, h3 {
            color: #333;
            margin-bottom: 0.5em; /* Sedikit spasi di bawah judul */
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            /* Pastikan gambar diakses dari path publik */
            /* Untuk Dompdf, gunakan public_path() atau base_path() */
            /* Jika storage/profile_photos terhubung ke public/storage */
        }
        .section {
            margin-bottom: 15px;
            page-break-inside: avoid; /* Hindari pemisahan bagian di tengah halaman */
        }
        .section-title {
            font-size: 14pt;
            font-weight: bold;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            margin-bottom: 10px;
            color: #555; /* Warna yang lebih soft */
        }
        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        li {
            margin-bottom: 5px;
        }
        .item-block { /* Kelas umum untuk item pengalaman/pendidikan/organisasi */
            margin-bottom: 10px;
        }
        .item-block h4 {
            margin: 0;
            font-size: 11pt; /* Sedikit lebih kecil dari section-title */
        }
        .item-block p {
            margin: 2px 0;
            font-size: 9pt;
            color: #666; /* Warna yang lebih soft untuk teks */
        }
        .description-text {
            font-size: 9.5pt;
            line-height: 1.4;
            margin-top: 5px;
        }
        .tag-list span {
            display: inline-block;
            background-color: #f0f0f0;
            padding: 3px 8px;
            border-radius: 3px;
            margin-right: 5px;
            margin-bottom: 5px;
            font-size: 8.5pt;
        }
    </style>
</head>
<body>
    <div class="header">
        @if ($personalInformation->profile_photo)
            {{-- Dompdf memerlukan path fisik, bukan URL Storage::url() --}}
            <img src="{{ public_path('storage/' . $personalInformation->profile_photo) }}" alt="Foto Profil">
        @endif
        <h1>{{ $personalInformation->full_name ?? 'Nama Lengkap' }}</h1>
        <p>
            @if ($personalInformation->email) {{ $personalInformation->email }} @endif
            @if ($personalInformation->phone_number) | {{ $personalInformation->phone_number }} @endif
            @if ($personalInformation->address) | {{ $personalInformation->address }} @endif
        </p>
        @if ($personalInformation->linkedin_url)
            <p>LinkedIn: <a href="{{ $personalInformation->linkedin_url }}">{{ $personalInformation->linkedin_url }}</a></p>
        @endif
        @if ($personalInformation->portfolio_url)
            <p>Portfolio: <a href="{{ $personalInformation->portfolio_url }}">{{ $personalInformation->portfolio_url }}</a></p>
        @endif
    </div>

    @if ($personalInformation->summary)
    <div class="section">
        <div class="section-title">Ringkasan</div>
        <p class="description-text">{{ $personalInformation->summary }}</p>
    </div>
    @endif

    @if ($workExperiences->isNotEmpty())
        <div class="section">
            <div class="section-title">Pengalaman Kerja</div>
            @foreach ($workExperiences as $experience)
                <div class="item-block">
                    <h4>{{ $experience->position }} di {{ $experience->company_name }}</h4>
                    <p>
                        {{ $experience->start_month }} {{ $experience->start_year }} -
                        @if ($experience->currently_working)
                            Sekarang
                        @else
                            {{ $experience->end_month }} {{ $experience->end_year }}
                        @endif
                        @if ($experience->location) | {{ $experience->location }} @endif
                    </p>
                    @if ($experience->portfolio_description)
                        <p class="description-text">{!! nl2br(e($experience->portfolio_description)) !!}</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    @if ($educations->isNotEmpty())
        <div class="section">
            <div class="section-title">Pendidikan</div>
            @foreach ($educations as $education)
                <div class="item-block">
                    <h4>{{ $education->degree_level }} di {{ $education->school_name }}</h4>
                    <p>
                        {{ $education->start_month }} {{ $education->start_year }} -
                        {{ $education->graduation_month }} {{ $education->graduation_year }}
                        @if ($education->location) | {{ $education->location }} @endif
                    </p>
                    @if ($education->gpa && $education->gpa_max)
                        <p>GPA: {{ $education->gpa }} / {{ $education->gpa_max }}</p>
                    @endif
                    @if ($education->description)
                        <p class="description-text">{!! nl2br(e($education->description)) !!}</p>
                    @endif
                    @if ($education->activities)
                        <p>Aktivitas: {!! nl2br(e($education->activities)) !!}</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    @if ($organizationExperiences->isNotEmpty())
        <div class="section">
            <div class="section-title">Pengalaman Organisasi</div>
            @foreach ($organizationExperiences as $org)
                <div class="item-block">
                    <h4>{{ $org->position }} di {{ $org->organization_name }}</h4>
                    <p>
                        {{ $org->start_month }} {{ $org->start_year }} -
                        @if ($org->is_active)
                            Sekarang
                        @else
                            {{ $org->end_month }} {{ $org->end_year }}
                        @endif
                        @if ($org->location) | {{ $org->location }} @endif
                    </p>
                    @if ($org->job_description)
                        <p class="description-text">{!! nl2br(e($org->job_description)) !!}</p>
                    @endif
                    @if ($org->organization_description)
                        <p class="description-text">Deskripsi Organisasi: {!! nl2br(e($org->organization_description)) !!}</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    @php
        // Kelompokkan otherExperiences berdasarkan kategori
        $groupedOtherExperiences = $otherExperiences->groupBy('category');
    @endphp

    @if ($groupedOtherExperiences->isNotEmpty())
        @foreach(['Skill', 'Penghargaan', 'Proyek', 'Aktivitas', 'Lainnya'] as $category)
            @if ($groupedOtherExperiences->has($category) && $groupedOtherExperiences[$category]->isNotEmpty())
                <div class="section">
                    <div class="section-title">{{ $category }}</div>
                    <ul>
                        @foreach ($groupedOtherExperiences[$category] as $other)
                            <li>
                                {{ $other->description }}
                                @if ($other->year) ({{ $other->year }}) @endif
                                @if ($other->document_path)
                                    <a href="{{ public_path('storage/' . $other->document_path) }}" target="_blank">Dokumen</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endforeach
    @endif

</body>
</html>