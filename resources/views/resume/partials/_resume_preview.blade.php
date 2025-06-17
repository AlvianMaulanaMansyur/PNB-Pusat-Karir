<div class="resume-content" x-data x-ref="resumePreview">
    <!-- Personal Details -->
    <div class="flex items-center space-x-4 mb-4"
         x-effect="updateTimestamp = Date.now()">
        <template x-if="$store.resume.personalDetails?.profile_photo">
            <img :src="$store.resume.personalDetails.profile_photo + '?t=' + updateTimestamp" 
                 alt="Profile Photo" 
                 class="w-24 h-24 object-cover rounded-full">
        </template>

        <div>
            <pre class="text-xs text-gray-500" x-text="JSON.stringify($store.resume.personalDetails, null, 2)"></pre>

            <h1 class="text-3xl font-bold" x-text="$store.resume.personalDetails?.name"></h1>
            <p class="text-gray-600" x-text="$store.resume.personalDetails?.email"></p>
            <p class="text-gray-600" x-text="$store.resume.personalDetails?.phone"></p>
            <p class="text-gray-600" x-text="$store.resume.personalDetails?.address"></p>
            <button @click="console.log($store.resume.personalDetails)">Check Store</button>
        </div>
    </div>
  

    <!-- Summary -->
    <div class="mb-6">
        <p class="text-gray-700" x-text="$store.resume.personalDetails?.summary"></p>
    </div>

    <!-- Experiences -->
    <h2 class="text-xl font-bold text-gray-800 border-b border-gray-300 pb-2 mb-4">Experience</h2>
    <template x-if="$store.resume.experiences?.length > 0">
        <template x-for="experience in $store.resume.experiences" :key="experience.id">
            <div class="mb-6">
                <div class="flex justify-between">
                    <h3 class="text-lg font-semibold" 
                        x-text="`${experience.title || 'Job Title'} at ${experience.company || 'Company Name'}`">
                    </h3>
                    <span class="text-gray-500 text-sm"
                        x-text="`${experience.start_date || ''} - ${experience.end_date || 'Present'}`">
                    </span>
                </div>
                <p class="text-gray-600 mt-1" x-text="experience.description || ''"></p>
            </div>
        </template>
    </template>
    <template x-if="!$store.resume.experiences?.length">
        <p class="text-gray-500">No experience to display yet.</p>
    </template>

    <!-- Skills -->
    <h2 class="text-xl font-bold text-gray-800 border-b border-gray-300 pb-2 mb-4">Skills</h2>
    <div class="flex flex-wrap gap-2">
        <template x-if="$store.resume.skills?.length > 0">
            <template x-for="skill in $store.resume.skills" :key="skill.name">
                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm"
                    x-text="skill.name || ''">
                </span>
            </template>
        </template>
        <template x-if="!$store.resume.skills?.length">
            <p class="text-gray-500">No skills to display yet.</p>
        </template>
    </div>
</div>