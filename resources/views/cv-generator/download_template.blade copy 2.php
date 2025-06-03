<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CV - {{ $personalInformation->full_name ?? 'CV' }}</title>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 20mm; /* Sesuai dengan margin kertas A4 standar */
            font-size: 10pt;
            line-height: 1.6; /* Menyesuaikan dengan line-height dari style sebelumnya */
            color: #333; /* Warna teks utama */
        }

        /* CV Container */
        .cv-container {
            background-color: #fff;
            /* Untuk template unduhan, box-shadow dan border-radius mungkin tidak begitu berpengaruh pada PDF,
               tapi tetap disertakan jika diunduh sebagai HTML */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 24px; /* Menyesuaikan dengan p-6 */
        }

        /* Section Spacing */
        .section-spacing {
            margin-top: 24px; /* Menyesuaikan dengan mt-6 */
        }

        /* Section Headers */
        .section-title {
            font-size: 1.25rem; /* text-xl */
            font-weight: bold; /* font-bold */
            border-bottom: 2px solid #e2e8f0; /* border-b-2 border-gray-200 */
            padding-bottom: 8px; /* pb-2 */
            margin-bottom: 16px; /* Menambahkan margin bawah */
            color: #333; /* Warna judul lebih gelap */
        }

        /* Personal Information Header */
        .personal-info-header {
            display: flex; /* flex */
            align-items: center; /* items-center */
            margin-bottom: 16px; /* Spasi bawah untuk header info pribadi */
        }

        .profile-photo {
            width: 80px; /* w-20 */
            height: 80px; /* h-20 */
            border-radius: 9999px; /* rounded-full */
            object-fit: cover; /* object-cover */
            margin-right: 16px; /* mr-4 */
        }

        .full-name {
            font-weight: bold; /* font-bold */
            font-size: 1.5rem; /* Ukuran yang sedikit lebih besar untuk nama */
            margin: 0;
            color: #333;
        }

        .contact-info p {
            margin: 2px 0;
            font-size: 0.9em;
            color: #555;
        }

        .contact-info a {
            color: #007bff; /* Warna link */
            text-decoration: none;
        }
        .contact-info a:hover {
            text-decoration: underline;
        }

        /* Summary Section */
        .summary-section {
            margin-top: 16px;
        }

        .summary-text {
            color: #444;
        }

        /* Item Blocks (Work Experience, Education, Organization) */
        .item-block {
            margin-bottom: 16px; /* Spasi antar item */
            page-break-inside: avoid; /* Hindari pemisahan item di tengah halaman */
        }

        .item-block h3 { /* Menggunakan h3 untuk judul item seperti company_name/school_name */
            font-weight: bold;
            font-size: 1.1em; /* Sedikit lebih besar dari teks biasa */
            margin: 0 0 4px 0;
            color: #333;
        }

        .item-subtitle {
            color: #555; /* text-gray-600 */
            font-size: 0.95em;
            margin: 0 0 4px 0;
        }

        .item-description {
            margin-top: 8px; /* mt-2 */
            color: #444; /* text-gray-700 */
            font-size: 0.95em;
        }

        .item-small-text {
            margin-top: 4px; /* mt-1 */
            font-size: 0.875rem; /* text-sm */
            color: #666;
        }

        /* Other Experiences / Grouped Items */
        .other-experience-item {
            margin-bottom: 8px; /* Spasi antar item dalam daftar */
        }

        .other-experience-item:last-child {
            margin-bottom: 0; /* Hapus margin bawah pada item terakhir */
        }

        .no-data-message {
            margin-top: 8px;
            color: #444;
            font-style: italic;
        }

        /* Specific styles for PDF generation adjustments */
        /* Dompdf may not fully support all CSS, so keep it simple */
        a {
            color: #007bff; /* Ensures links are visible */
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="cv-container">
        <div class="personal-info-header">
            @if ($personalInformation->profile_photo)
                {{-- Dompdf memerlukan path fisik, bukan URL Storage::url() --}}
                <img src="{{ public_path('storage/' . $personalInformation->profile_photo) }}" alt="Foto Profil" class="profile-photo">
            @endif
            <div>
                <h1 class="full-name">{{ $personalInformation->full_name ?? 'Nama Lengkap' }}</h1>
                <div class="contact-info">
                    @if ($personalInformation->email)
                        <p>{{ $personalInformation->email }}</p>
                    @endif
                    @if ($personalInformation->phone_number)
                        <p>{{ $personalInformation->phone_number }}</p>
                    @endif
                    @if ($personalInformation->address)
                        <p>{{ $personalInformation->address }}</p>
                    @endif
                    @if ($personalInformation->linkedin_url)
                        <p>LinkedIn: <a href="{{ $personalInformation->linkedin_url }}">{{ $personalInformation->linkedin_url }}</a></p>
                    @endif
                    @if ($personalInformation->portfolio_url)
                        <p>Portofolio: <a href="{{ $personalInformation->portfolio_url }}">{{ $personalInformation->portfolio_url }}</a></p>
                    @endif
                </div>
            </div>
        </div>

        @if ($personalInformation->summary)
        <div class="section-spacing">
            <h2 class="section-title">Tentang Saya</h2>
            <p class="item-description">{{ $personalInformation->summary }}</p>
        </div>
        @endif

        @if ($workExperiences->isNotEmpty())
            <div class="section-spacing">
                <h2 class="section-title">Pengalaman Kerja</h2>
                @foreach ($workExperiences as $experience)
                    <div class="item-block">
                        <h3>{{ $experience->position }} di {{ $experience->company_name }}</h3>
                        <p class="item-subtitle">
                            {{ $experience->start_month }} {{ $experience->start_year }} -
                            @if ($experience->currently_working)
                                Sekarang
                            @else
                                {{ $experience->end_month }} {{ $experience->end_year }}
                            @endif
                            @if ($experience->location) | {{ $experience->location }} @endif
                        </p>
                        @if ($experience->portfolio_description)
                            <p class="item-description">{!! nl2br(e($experience->portfolio_description)) !!}</p>
                        @endif
                        @if ($experience->company_profile)
                            <p class="item-small-text">{{ $experience->company_profile }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
             <p class="no-data-message section-spacing">Pengalaman kerja akan muncul di sini.</p>
        @endif

        @if ($educations->isNotEmpty())
            <div class="section-spacing">
                <h2 class="section-title">Edukasi</h2>
                @foreach ($educations as $education)
                    <div class="item-block">
                        <h3>{{ $education->degree_level }} di {{ $education->school_name }}</h3>
                        <p class="item-subtitle">
                            {{ $education->start_month }} {{ $education->start_year }} -
                            {{ $education->graduation_month }} {{ $education->graduation_year }}
                            @if ($education->location) | {{ $education->location }} @endif
                        </p>
                        @if ($education->gpa && $education->gpa_max)
                            <p class="item-small-text">GPA: {{ $education->gpa }} / {{ $education->gpa_max }}</p>
                        @endif
                        @if ($education->description)
                            <p class="item-description">{!! nl2br(e($education->description)) !!}</p>
                        @endif
                        @if ($education->activities)
                            <p class="item-small-text">Aktivitas: {!! nl2br(e($education->activities)) !!}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="no-data-message section-spacing">Edukasi akan muncul di sini.</p>
        @endif

        @if ($organizationExperiences->isNotEmpty())
            <div class="section-spacing">
                <h2 class="section-title">Pengalaman Organisasi</h2>
                @foreach ($organizationExperiences as $org)
                    <div class="item-block">
                        <h3>{{ $org->position }} di {{ $org->organization_name }}</h3>
                        <p class="item-subtitle">
                            {{ $org->start_month }} {{ $org->start_year }} -
                            @if ($org->is_active)
                                Sekarang
                            @else
                                {{ $org->end_month }} {{ $org->end_year }}
                            @endif
                            @if ($org->location) | {{ $org->location }} @endif
                        </p>
                        @if ($org->job_description)
                            <p class="item-description">{!! nl2br(e($org->job_description)) !!}</p>
                        @endif
                        @if ($org->organization_description)
                            <p class="item-small-text">Deskripsi Organisasi: {!! nl2br(e($org->organization_description)) !!}</p>
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
            <div class="section-spacing">
                <h2 class="section-title">Kemampuan & Penghargaan</h2>
                @foreach(['Skill', 'Penghargaan', 'Proyek', 'Aktivitas', 'Lainnya'] as $category)
                    @if ($groupedOtherExperiences->has($category) && $groupedOtherExperiences[$category]->isNotEmpty())
                        <div class="item-block">
                            <h3>{{ $category }}</h3>
                            <ul>
                                @foreach ($groupedOtherExperiences[$category] as $other)
                                    <li class="other-experience-item">
                                        {{ $other->description }}
                                        @if ($other->year) ({{ $other->year }}) @endif
                                        @if ($other->document_path)
                                            <a href="{{ public_path('storage/' . $other->document_path) }}" target="_blank">(Dokumen)</a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <p class="no-data-message section-spacing">Informasi tambahan akan muncul di sini.</p>
        @endif

    </div>
</body>
</html>