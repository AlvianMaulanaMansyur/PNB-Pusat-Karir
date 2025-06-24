<x-jobseeker-layout>
    <section>
        <x-alert.session-alert class="session-alert" type="success" :message="session('success')" />
        <div class="max-w-screen-xl w-full mx-auto px-4 sm:px-6  lg:px-32">
            <div class="py-3">
                <x-breadcrumb :links="[['label' => 'Home', 'url' => route('employee.landing-page')], ['label' => 'Profile']]" />
            </div>
            <div class="container border-2 shadow rounded-xl p-5 py-5  bg-darkBlue  md:px-20">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 py-7">
                    <div class="flex flex-col sm:flex-row items-center gap-6">
                        <div class="border-4 rounded-full p-2">
                            <img src="{{ $employeeData->photo_profile === 'image/user.png'
                                ? asset($employeeData->photo_profile)
                                : asset('storage/' . $employeeData->photo_profile) }}"
                                alt="Profile" class="rounded-full w-28 h-28 object-cover border-2 border-gray-200" />
                        </div>

                        <div class="flex flex-col gap-2 text-center sm:text-left text-white">
                            <div class="font-semibold text-3xl sm:text-4xl">
                                {{ $employeeData->first_name }} {{ $employeeData->last_name }}
                                {{ $employeeData->suffix }}
                            </div>
                            <div class="flex items-center justify-center sm:justify-start gap-2">
                                <i class="fa-solid fa-location-dot" style="color: #ffffff;"></i>
                                <p class="text-md">{{ $employeeData->country }}, {{ $employeeData->city }}</p>
                            </div>
                            <div class="flex items-center justify-center sm:justify-start gap-2">
                                <i class="fa-regular fa-envelope" style="color: #ffffff;"></i>
                                <p class="text-md">{{ $employeeData->user->email }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Kanan: Tombol -->
                    <div class="flex justify-center md:justify-end mt-4 md:mt-0">
                        @include('components.jobseeker.modal-UpdateProfiles')
                    </div>
                </div>
            </div>
            <div class="py-4">
                <p class="text-blue-700 text-2xl font-semibold py-2">Ringkasan Diri</p>
                @include('components.jobseeker.modal-add-update-summary', [
                    'summary' => $employeeProfile->summary ?? '',
                ])
            </div>
            <div>
                <p class="text-blue-700 text-2xl font-semibold py-2">Pendidikan</p>
                @include('components.jobseeker.education-seciton')
            </div>
    </section>
</x-jobseeker-layout>
