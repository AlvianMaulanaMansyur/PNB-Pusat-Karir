<div>
    {{-- Header Section: Name, Contact, Photo --}}
    <div
        class="flex flex-col md:flex-row items-center md:items-start md:justify-between mb-6 pb-4 border-b border-gray-300">
        <div class="text-center md:text-left mb-4 md:mb-0">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight">
                {{ $resumeData['personal_details']['name'] ?? '' }}
            </h1>
            <p class="text-md text-gray-700 mt-1">
                {{ $resumeData['personal_details']['email'] ?? '' }}
                @if (!empty($resumeData['personal_details']['phone']))
                    <span class="mx-2 text-gray-400">|</span> {{ $resumeData['personal_details']['phone'] }}
                @endif
            </p>
            @if (!empty($resumeData['personal_details']['address']))
                <p class="text-md text-gray-700">{{ $resumeData['personal_details']['address'] }}</p>
            @endif
            @if (!empty($resumeData['personal_details']['linkedin_url']))
                <p class="text-md text-gray-700 mt-1">
                    <a href="{{ $resumeData['personal_details']['linkedin_url'] }}" target="_blank"
                        class="text-blue-600 hover:underline flex items-center justify-center md:justify-start">
                        <i class="fab fa-linkedin mr-2 text-lg"></i> LinkedIn Profile
                    </a>
                </p>
            @endif
            @if (!empty($resumeData['personal_details']['github_url']))
                <p class="text-md text-gray-700 mt-1">
                    <a href="{{ $resumeData['personal_details']['github_url'] }}" target="_blank"
                        class="text-blue-600 hover:underline flex items-center justify-center md:justify-start">
                        <i class="fab fa-github mr-2 text-lg"></i> GitHub Profile
                    </a>
                </p>
            @endif
            @if (!empty($resumeData['personal_details']['portfolio_url']))
                <p class="text-md text-gray-700 mt-1">
                    <a href="{{ $resumeData['personal_details']['portfolio_url'] }}" target="_blank"
                        class="text-blue-600 hover:underline flex items-center justify-center md:justify-start">
                        <i class="fas fa-globe mr-2 text-lg"></i> Portfolio
                    </a>
                </p>
            @endif
        </div>
        @if ($profilePhotoUrl)
            <div class="flex-shrink-0">
                <img src="{{ $profilePhotoUrl }}" alt="Profile Photo"
                    class="w-28 h-28 md:w-36 md:h-36 object-cover rounded-full shadow-lg border-2 border-gray-200">
            </div>
        @endif
    </div>

    {{-- Summary --}}
    @if (!empty($resumeData['personal_details']['summary']))
        <section class="section-summary mb-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-3 border-b-2 border-blue-500 pb-1">Summary</h3>
            <p class="text-gray-700 leading-relaxed">{{ $resumeData['personal_details']['summary'] }}</p>
        </section>
    @endif

    {{-- Experience --}}
    @if (!empty($resumeData['experiences']))
        <section class="section-experience mb-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-3 border-b-2 border-blue-500 pb-1">Experience</h3>
            @foreach ($resumeData['experiences'] as $experience)
                <div class="mb-5 pb-3 border-b border-gray-200 last:border-b-0 last:pb-0">
                    <div class="flex justify-between items-baseline mb-1">
                        <h4 class="text-lg font-bold text-gray-900">{{ $experience['position'] ?? 'Untitled Position' }}
                        </h4>
                        <span class="text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($experience['start_date'])->format('M Y') }} -
                            @if (!empty($experience['is_current']))
                                Present
                            @else
                                {{ \Carbon\Carbon::parse($experience['end_date'])->format('M Y') }}
                            @endif
                        </span>
                    </div>
                    <p class="text-gray-700 text-md font-medium">{{ $experience['company'] ?? 'Unknown Company' }}</p>
                    <p class="text-gray-700 text-sm italic mb-2">{{ $experience['location'] ?? '' }}</p>
                    @if (!empty($experience['description']))
                        <div class="text-gray-800 text-sm prose prose-sm max-w-none">
                            {{-- Mengasumsikan deskripsi dapat mengandung daftar poin yang dipisahkan oleh baris baru --}}
                            {!! Str::markdown($experience['description']) !!}
                        </div>
                    @endif
                </div>
            @endforeach
        </section>
    @endif

    @php use Carbon\Carbon; @endphp

    @if (!empty($resumeData['educations']))
        <section class="section-education mb-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-3 border-b-2 border-blue-500 pb-1">Education</h3>
            @foreach ($resumeData['educations'] as $education)
                <div class="mb-5 pb-3 border-b border-gray-200 last:border-b-0 last:pb-0">
                    <div class="flex justify-between items-baseline mb-1">
                        <h4 class="text-lg font-bold text-gray-900">
                            {{ $education['degrees'] ?? 'N/A' }}
                            @if (!empty($education['dicipline']))
                                <span class="font-normal"> in {{ $education['dicipline'] }}</span>
                            @endif
                        </h4>
                        @if (!empty($education['end_date']))
                            <span class="text-sm text-gray-600">
                                {{ Carbon::parse($education['end_date'])->format('M Y') }}
                            </span>
                        @endif
                    </div>
                    <p class="text-gray-700 text-md font-medium">
                        {{ $education['institution'] ?? 'N/A' }}
                    </p>
                    @if (!empty($education['sertifications']))
                        <p class="text-sm text-gray-600 mt-1">
                            Certifications: {{ $education['sertifications'] }}
                        </p>
                    @endif
                    @if (!empty($education['description']))
                        <div class="text-gray-800 text-sm prose prose-sm max-w-none mt-2">
                            {!! Str::markdown($education['description']) !!}
                        </div>
                    @endif
                </div>
            @endforeach
        </section>
    @endif

    {{-- Skills --}}
    @if (!empty($resumeData['skills']) && is_array($resumeData['skills']) && count($resumeData['skills']) > 0)
        <section class="section-skills mb-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-3 border-b-2 border-blue-500 pb-1">Skills</h3>

            <div class="flex flex-wrap gap-2">
                @foreach ($resumeData['skills'] as $skill)
                    <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full shadow-sm">
                        {{ $skill['name'] }}
                    </span>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Projects --}}
    @if (!empty($resumeData['projects']))
        <section class="section-projects mb-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-3 border-b-2 border-blue-500 pb-1">Projects</h3>
            @foreach ($resumeData['projects'] as $project)
                <div class="mb-5 pb-3 border-b border-gray-200 last:border-b-0 last:pb-0">
                    <div class="flex justify-between items-baseline mb-1">
                        <h4 class="text-lg font-bold text-gray-900">
                            {{ $project['project_name'] ?? 'Untitled Project' }}</h4>
                        <span class="text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($project['start_date'])->format('M Y') }} -
                            {{ $project['is_current'] ?? false ? 'Present' : \Carbon\Carbon::parse($project['end_date'])->format('M Y') ?? '' }}
                        </span>
                    </div>
                    @if ($project['role'])
                        <p class="text-gray-700 text-md font-medium mb-1">{{ $project['role'] }}</p>
                    @endif
                    @if ($project['technologies_used'])
                        <p class="text-sm text-gray-600 mb-2">
                            <span class="font-semibold">Technologies:</span> {{ $project['technologies_used'] }}
                        </p>
                    @endif
                    @if ($project['description'])
                        <div class="text-gray-800 text-sm prose prose-sm max-w-none">
                            {!! Str::markdown($project['description']) !!}
                        </div>
                    @endif
                    <div class="flex flex-wrap gap-x-4 gap-y-2 mt-2 text-sm">
                        @if ($project['project_url'])
                            <a href="{{ $project['project_url'] }}" target="_blank"
                                class="text-blue-600 hover:underline flex items-center">
                                <i class="fas fa-external-link-alt mr-1"></i> Live Project
                            </a>
                        @endif
                        @if ($project['github_url'])
                            <a href="{{ $project['github_url'] }}" target="_blank"
                                class="text-blue-600 hover:underline flex items-center">
                                <i class="fab fa-github mr-1"></i> GitHub Repo
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </section>
    @endif

    {{-- Certifications & Licenses --}}
    @if (!empty($resumeData['certifications']))
        <section class="section-certifications mb-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-3 border-b-2 border-blue-500 pb-1">
                Certifications & Licenses
            </h3>
            @foreach ($resumeData['certifications'] as $certification)
                <div class="mb-5 pb-3 border-b border-gray-200 last:border-b-0 last:pb-0">
                    <h4 class="text-lg font-bold text-gray-900">
                        {{ $certification['title'] ?? 'Untitled Certification' }}
                    </h4>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ $certification['issuer'] ?? 'N/A' }} |
                        Issued:
                        {{ !empty($certification['date_issued']) ? \Carbon\Carbon::parse($certification['date_issued'])->format('M Y') : '' }}
                        @if (!empty($certification['expiry_date']))
                            | Expires: {{ \Carbon\Carbon::parse($certification['expiry_date'])->format('M Y') }}
                        @endif
                    </p>

                    @if (!empty($certification['description']))
                        <p class="text-gray-700 text-sm mt-1">
                            {{ $certification['description'] }}
                        </p>
                    @endif
                </div>
            @endforeach
        </section>
    @endif

    {{-- Awards & Recognition --}}
    @if (!empty($resumeData['awards']))
        <section class="section-awards mb-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-3 border-b-2 border-blue-500 pb-1">Awards & Recognition</h3>
            @foreach ($resumeData['awards'] as $award)
                <div class="mb-5 pb-3 border-b border-gray-200 last:border-b-0 last:pb-0">
                    <div class="flex justify-between items-baseline mb-1">
                        <h4 class="text-lg font-bold text-gray-900">{{ $award['name'] ?? 'Untitled Award' }}</h4>
                        <span class="text-sm text-gray-600">
                            Received: {{ \Carbon\Carbon::parse($award['date_received'])->format('M Y') ?? '' }}
                        </span>
                    </div>
                    <p class="text-gray-700 text-md font-medium">{{ $award['awarding_organization'] ?? 'N/A' }}</p>
                    @if ($award['description'])
                        <div class="text-gray-800 text-sm prose prose-sm max-w-none mt-2">
                            {!! Str::markdown($award['description']) !!}
                        </div>
                    @endif
                </div>
            @endforeach
        </section>
    @endif

    {{-- Volunteering Experience --}}
    @if (!empty($resumeData['volunteering']))
        <section class="section-volunteering mb-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-3 border-b-2 border-blue-500 pb-1">Volunteering Experience
            </h3>
            @foreach ($resumeData['volunteering'] as $volunteering)
                <div class="mb-5 pb-3 border-b border-gray-200 last:border-b-0 last:pb-0">
                    <div class="flex justify-between items-baseline mb-1">
                        <h4 class="text-lg font-bold text-gray-900">
                            {{ $volunteering['organization_name'] ?? 'Untitled Organization' }}</h4>
                        <span class="text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($volunteering['start_date'])->format('M Y') ?? '' }} -
                            {{ $volunteering['is_current'] ?? false ? 'Present' : \Carbon\Carbon::parse($volunteering['end_date'])->format('M Y') ?? '' }}
                        </span>
                    </div>
                    <p class="text-gray-700 text-md font-medium">{{ $volunteering['role'] ?? 'Volunteer' }}</p>
                    @if ($volunteering['description'])
                        <div class="text-gray-800 text-sm prose prose-sm max-w-none mt-2">
                            {!! Str::markdown($volunteering['description']) !!}
                        </div>
                    @endif
                </div>
            @endforeach
        </section>
    @endif

    {{-- Interests & Hobbies --}}
    @if (!empty($resumeData['interests']))
        <section class="section-interests mb-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-3 border-b-2 border-blue-500 pb-1">Interests & Hobbies</h3>
            <div class="flex flex-wrap gap-2">
                @foreach ($resumeData['interests'] as $interest)
                    <span class="bg-gray-100 text-gray-800 text-sm font-medium px-3 py-1 rounded-full shadow-sm">
                        {{ $interest['interest'] ?? 'Untitled Interest' }}
                    </span>
                @endforeach
            </div>
        </section>
    @endif
</div>
