@props(['currentCv'])

<div class="bg-white p-6 rounded-md shadow-md">
    <div class="mt-6" id="informasi-pribadi-container">
        <div id="preview-informasi-pribadi">
            @php
                $info = $currentCv->personalInformation ?? session("cv_data.{$currentCv->slug}.informasi_pribadi");
            @endphp

            @if ($info)
                <div class="mt-4">
                    <div class="flex items-center">
                        @if (isset($info['profile_photo']) || ($info instanceof \App\Models\CvPersonalInformation && $info->profile_photo))
                            <img src="{{ asset('storage/' . ($info['profile_photo'] ?? $info->profile_photo)) }}" alt="Foto Profil"
                                class="w-20 h-20 rounded-full object-cover mr-4">
                        @endif
                        <div>
                            <h3 class="font-bold text-lg">{{ $info['full_name'] ?? ($info->full_name ?? '') }}</h3>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <p class="font-semibold">Kontak</p>
                            <p class="text-gray-600">{{ $info['phone_number'] ?? ($info->phone_number ?? '') }}</p>
                            <p class="text-gray-600">{{ $info['email'] ?? ($info->email ?? '') }}</p>
                            <p class="text-gray-600">{{ $info['address'] ?? ($info->address ?? '') }}</p>
                        </div>
                        <div>
                            <p class="font-semibold">Media Profesional</p>
                            <p class="text-gray-600">
                                {{ ($info['linkedin_url'] ?? ($info->linkedin_url ?? false)) ? 'LinkedIn: ' . ($info['linkedin_url'] ?? $info->linkedin_url) : '' }}
                            </p>
                            <p class="text-gray-600">
                                {{ ($info['portfolio_url'] ?? ($info->portfolio_url ?? false)) ? 'Portofolio: ' . ($info['portfolio_url'] ?? $info->portfolio_url) : '' }}
                            </p>
                        </div>
                    </div>

                    @if (isset($info['summary']) || ($info instanceof \App\Models\CvPersonalInformation && $info->summary))
                        <div class="mt-4">
                            <p class="font-semibold">Tentang Saya</p>
                            <p class="text-gray-700">{{ $info['summary'] ?? $info->summary }}</p>
                        </div>
                    @endif
                </div>
            @else
                <p class="mt-2 text-gray-700">Informasi pribadi akan muncul di sini.</p>
            @endif
        </div>
    </div>

    <div class="mt-6" id="pengalaman-container">
        <h2 class="text-xl font-bold border-b-2 border-gray-200 pb-2">Pengalaman Kerja</h2>
        <div id="preview-pengalaman">
            @php
                $workExperiences = $currentCv->workExperiences ?? session("cv_data.{$currentCv->slug}.pengalaman_kerja");
            @endphp
            @if ($workExperiences)
                @foreach ($workExperiences as $pengalaman)
                    <div class="mt-4">
                        <h3 class="font-bold">{{ $pengalaman['company_name'] ?? ($pengalaman->company_name ?? '') }}</h3>
                        <p class="text-gray-600">
                            {{ $pengalaman['position'] ?? ($pengalaman->position ?? '') }} |
                            {{ $pengalaman['start_month'] ?? ($pengalaman->start_month ?? '') }} {{ $pengalaman['start_year'] ?? ($pengalaman->start_year ?? '') }} -
                            @if (($pengalaman['currently_working'] ?? ($pengalaman->currently_working ?? false)))
                                Sekarang
                            @else
                                {{ $pengalaman['end_month'] ?? ($pengalaman->end_month ?? '') }} {{ $pengalaman['end_year'] ?? ($pengalaman->end_year ?? '') }}
                            @endif
                        </p>
                        <p class="text-gray-600">{{ $pengalaman['location'] ?? ($pengalaman->location ?? '') }}</p>
                        <p class="mt-2">{{ $pengalaman['company_profile'] ?? ($pengalaman->company_profile ?? '') }}</p>
                        <p class="mt-1 text-sm">{{ $pengalaman['portfolio_description'] ?? ($pengalaman->portfolio_description ?? '') }}</p>
                    </div>
                @endforeach
            @else
                <p class="mt-2 text-gray-700">Pengalaman kerja akan muncul di sini.</p>
            @endif
        </div>
    </div>

    <div class="mt-6" id="edukasi-container">
        <h2 class="text-xl font-bold border-b-2 border-gray-200 pb-2">Edukasi</h2>
        <div id="preview-edukasi">
            @php
                $educations = $currentCv->educations ?? session("cv_data.{$currentCv->slug}.edukasi");

            @endphp
            @if ($educations)
                @foreach ($educations as $edukasi)
                    <div class="mt-4">
                        <h3 class="font-bold">{{ $edukasi['school_name'] ?? ($edukasi->school_name ?? '') }}</h3>
                        <p class="text-gray-600">
                            {{ $edukasi['location'] ?? ($edukasi->location ?? '') }} |
                            {{ $edukasi['start_month'] ?? ($edukasi->start_month ?? '') }} {{ $edukasi['start_year'] ?? ($edukasi->start_year ?? '') }} -
                            {{ $edukasi['graduation_month'] ?? ($edukasi->graduation_month ?? '') }} {{ $edukasi['graduation_year'] ?? ($edukasi->graduation_year ?? '') }}
                        </p>
                        <p class="text-gray-600">{{ $edukasi['degree_level'] ?? ($edukasi->degree_level ?? '') }}</p>
                        <p class="mt-2">{{ $edukasi['description'] ?? ($edukasi->description ?? '') }}</p>
                        <p class="mt-1 text-sm">
                            @if (isset($edukasi['gpa']) || ($edukasi instanceof \App\Models\CvEducation && $edukasi->gpa))
                                GPA: {{ $edukasi['gpa'] ?? $edukasi->gpa }}
                                @if (isset($edukasi['gpa_max']) || ($edukasi instanceof \App\Models\CvEducation && $edukasi->gpa_max))
                                    / {{ $edukasi['gpa_max'] ?? $edukasi->gpa_max }}
                                @endif
                            @endif
                        </p>
                        <p class="mt-1 text-sm">{{ $edukasi['activities'] ?? ($edukasi->activities ?? '') }}</p>
                    </div>
                @endforeach
            @else
                <p class="mt-2 text-gray-700">Edukasi akan muncul di sini.</p>
            @endif
        </div>
    </div>

    <div class="mt-6" id="organisasi-container">
        <div id="preview-organisasi">
            @php
                $organizationExperiences = $organizationExperiences->personalInformation ?? session("cv_data.{$currentCv->slug}.pengalaman_organisasi");
            @endphp
            @if ($organizationExperiences)
        <h2 class="text-xl font-bold border-b-2 border-gray-200 pb-2">Pengalaman Organisasi</h2>

                @foreach ($organizationExperiences as $organisasi)
                    <div class="mt-4">
                        <h3 class="font-bold">{{ $organisasi['organization_name'] ?? ($organisasi->organization_name ?? '') }}</h3>
                        <p class="text-gray-600">
                            {{ $organisasi['position'] ?? ($organisasi->position ?? '') }} |
                            {{ $organisasi['start_month'] ?? ($organisasi->start_month ?? '') }} {{ $organisasi['start_year'] ?? ($organisasi->start_year ?? '') }} -
                            @if (($organisasi['is_active'] ?? ($organisasi->is_active ?? false)))
                                Sekarang
                            @else
                                {{ $organisasi['end_month'] ?? ($organisasi->end_month ?? '') }} {{ $organisasi['end_year'] ?? ($organisasi->end_year ?? '') }}
                            @endif
                        </p>
                        <p class="text-gray-600">{{ $organisasi['location'] ?? ($organisasi->location ?? '') }}</p>
                        @if (isset($organisasi['organization_description']) || ($organisasi instanceof \App\Models\CvOrganizationExperience && $organisasi->organization_description))
                            <p class="mt-2">{{ $organisasi['organization_description'] ?? $organisasi->organization_description }}</p>
                        @endif
                        <p class="mt-1 text-sm">{{ $organisasi['job_description'] ?? ($organisasi->job_description ?? '') }}</p>
                    </div>
                @endforeach
            @else
                {{-- <p class="mt-2 text-gray-700">Pengalaman organisasi akan muncul di sini.</p> --}}
            @endif
        </div>
    </div>

    <div class="mt-6" id="pengalaman-lain-container">
        <h2 class="text-xl font-bold border-b-2 border-gray-200 pb-2">Kemampuan & Penghargaan</h2>
        <div id="preview-pengalaman-lain">
            @php
                $otherExperiences = $currentCv->otherExperiences ?? session("cv_data.{$currentCv->slug}.pengalaman_lain");
            @endphp
            @if ($otherExperiences)
                @foreach ($otherExperiences as $item)
                    <div class="mt-4 border-b pb-4">
                        <h3 class="font-bold">{{ $item['category'] ?? ($item->category ?? '') }} ({{ $item['year'] ?? ($item->year ?? '') }})</h3>
                        <p class="text-gray-600 mt-1">{{ $item['description'] ?? ($item->description ?? '') }}</p>
                        {{-- @if (isset($item['document_path']) && !empty($item['document_path']))
                            <div class="mt-2 text-sm text-blue-600">
                                <div><a href="{{ asset('storage/' . $item['document_path']) }}" target="_blank">Lihat Dokumen</a></div>
                            </div>
                        @endif --}}
                    </div>
                @endforeach
            @else
                <p class="mt-2 text-gray-700">Informasi tambahan akan muncul di sini.</p>
            @endif
        </div>
    </div>
</div>