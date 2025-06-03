<x-cv-generator-layout :activeStep="$activeStep" :currentCv="$currentCv">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-bold">Work Experience</h2>
        <p class="text-sm text-gray-600 mb-6">Enter your work experience</p>
        <div class="mb-6 " id="pengalaman-form-container">
            <input type="hidden" id="current_cv_slug" value="{{ $currentCv->slug ?? '' }}">
            <div>
                <div class="pengalaman-item bg-white p-4 rounded-lg mb-4 border">

                    {{-- Company Name --}}
                    <div class="mb-4">
                        <x-input-label for="company_name_1" :value="__('Company Name')" />
                        <x-text-input id="company_name_1" name="experiences[1][company_name]" type="text"
                            class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Enter Company Name" />
                    </div>

                    {{-- Position --}}
                    <div class="mb-4">
                        <x-input-label for="position_1" :value="__('Job Title/Internship/Position')" />
                        <x-text-input id="position_1" name="experiences[1][position]" type="text"
                            class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Enter Position or Job Title" />
                    </div>

                    {{-- Location --}}
                    <div class="mb-4">
                        <x-input-label for="location_1" :value="__('Company Location (City, Country)')" />
                        <x-text-input id="location_1" name="experiences[1][location]" type="text"
                            class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Enter Company Location" />
                    </div>

                    {{-- Company Profile --}}
                    <div class="mb-4">
                        <x-input-label for="company_profile_1" :value="__('Company Profile')" />
                        <textarea id="company_profile_1" name="experiences[1][company_profile]" rows="3"
                            class="block mt-1 w-full text-sm 2xl:text-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            placeholder="Enter Company Profile"></textarea>
                    </div>

                    {{-- Start Date --}}
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <x-input-label for="start_month_1" :value="__('Start Month')" />
                            <x-text-input id="start_month_1" name="experiences[1][start_month]" type="text"
                                class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Example: January" />
                        </div>
                        <div>
                            <x-input-label for="start_year_1" :value="__('Start Year')" />
                            <x-text-input id="start_year_1" name="experiences[1][start_year]" type="number"
                                class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Example: 2020" />
                        </div>
                    </div>

                    {{-- End Date --}}
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <x-input-label for="end_month_1" :value="__('End Month')" />
                            <x-text-input id="end_month_1" name="experiences[1][end_month]" type="text"
                                class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Example: December" />
                        </div>
                        <div>
                            <x-input-label for="end_year_1" :value="__('End Year')" />
                            <x-text-input id="end_year_1" name="experiences[1][end_year]" type="number"
                                class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Example: 2023" />
                        </div>
                    </div>

                    {{-- Checkbox --}}
                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="experiences[1][currently_working]"
                                class="rounded text-indigo-600 shadow-sm border-gray-300 focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-700">I currently work here</span>
                        </label>
                    </div>

                    {{-- Portfolio --}}
                    <div class="mb-4">
                        <x-input-label for="portfolio_1" :value="__('Work Portfolio')" />
                        <x-text-input id="portfolio_1" name="experiences[1][portfolio_description]" type="text"
                            class="block mt-1 w-full text-sm 2xl:text-lg"
                            placeholder="Example: Developed inventory application" />
                    </div>

                    <button type="button" class="mt-2 text-red-500 text-sm remove-pengalaman hidden">
                        Delete Experience
                    </button>
                </div>
            </div>


        </div>
        <button type="button" id="tambah-pengalaman"
            class="w-full border border-dashed border-indigo-500 text-indigo-600 px-4 py-2 rounded-md text-sm hover:bg-indigo-50">
            + Add Experience
        </button>

        <div class="flex justify-end">
        {{-- Kembali Button --}}

        <div class="mt-8 flex justify-end">
            <a href="{{ route('cv.personal-info', ['slug' => $currentCv->slug]) }}"
               class="inline-flex items-center px-6 py-3 bg-white border border-indigo-600 rounded-md font-semibold text-base text-indigo-600 uppercase tracking-widest hover:bg-indigo-50 focus:bg-indigo-50 active:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-4">
                Kembali
            </a>
        </div>

        {{-- Save & Continue Button --}}
        <div class="mt-8 flex justify-end">
            <button type="button" id="savePengalamanBtn"
                class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Simpan & Lanjutkan
            </button>
        </div>
    </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let experienceCounter = 1; // Changed variable name for consistency
            const maxExperiences = 5; // Changed variable name for consistency
            let debounceTimer;
            const cvSlug = document.getElementById('current_cv_slug').value;

            // Changed "pengalamanTemplate" to "experienceTemplate"
            const experienceTemplate = (counter) => ` 
                <div class="pengalaman-item bg-white p-6 rounded-lg mb-5 border">

                        {{-- Company Name --}}
                        <div class="mb-4">
                            <x-input-label for="company_name_${counter}" :value="__('Company Name')" />
                            <x-text-input id="company_name_${counter}" name="experiences[${counter}][company_name]" type="text"
                                class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Enter Company Name" />
                        </div>

                        {{-- Position --}}
                        <div class="mb-4">
                            <x-input-label for="position_${counter}" :value="__('Job Title/Internship/Position')" />
                            <x-text-input id="position_${counter}" name="experiences[${counter}][position]" type="text"
                                class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Enter Position or Job Title" />
                        </div>

                        {{-- Location --}}
                        <div class="mb-4">
                            <x-input-label for="location_${counter}" :value="__('Company Location (City, Country)')" />
                            <x-text-input id="location_${counter}" name="experiences[${counter}][location]" type="text"
                                class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Enter Company Location" />
                        </div>

                        {{-- Company Profile --}}
                        <div class="mb-4">
                            <x-input-label for="company_profile_${counter}" :value="__('Company Profile')" />
                            <textarea id="company_profile_${counter}" name="experiences[${counter}][company_profile]" rows="3"
                                class="block mt-1 w-full text-sm 2xl:text-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Enter Company Profile"></textarea>
                        </div>

                        {{-- Start Date --}}
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="start_month_${counter}" :value="__('Start Month')" />
                                <x-text-input id="start_month_${counter}" name="experiences[${counter}][start_month]" type="text"
                                    class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Example: January" />
                            </div>
                            <div>
                                <x-input-label for="start_year_${counter}" :value="__('Start Year')" />
                                <x-text-input id="start_year_${counter}" name="experiences[${counter}][start_year]" type="number"
                                    class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Example: 2020" />
                            </div>
                        </div>

                        {{-- End Date --}}
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="end_month_${counter}" :value="__('End Month')" />
                                <x-text-input id="end_month_${counter}" name="experiences[${counter}][end_month]" type="text"
                                    class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Example: December" />
                            </div>
                            <div>
                                <x-input-label for="end_year_${counter}" :value="__('End Year')" />
                                <x-text-input id="end_year_${counter}" name="experiences[${counter}][end_year]" type="number"
                                    class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Example: 2023" />
                            </div>
                        </div>

                        {{-- Checkbox --}}
                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="experiences[${counter}][currently_working]"
                                    class="rounded text-indigo-600 shadow-sm border-gray-300 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700">I currently work here</span>
                            </label>
                        </div>

                        {{-- Portfolio --}}
                        <div class="mb-4">
                            <x-input-label for="portfolio_${counter}" :value="__('Work Portfolio')" />
                            <x-text-input id="portfolio_${counter}" name="experiences[${counter}][portfolio_description]" type="text"
                                class="block mt-1 w-full text-sm 2xl:text-lg"
                                placeholder="Example: Developed inventory application" />
                        </div>

                        <button type="button" 
                            class="mt-2 text-red-500 text-sm remove-pengalaman">
                            Delete Experience
                        </button>
                </div>
            `;

            // Add Experience
            document.getElementById('tambah-pengalaman').addEventListener('click', () => {
                if (experienceCounter >= maxExperiences) {
                    alert(`Maximum ${maxExperiences} experiences`);
                    return;
                }

                experienceCounter++;
                const newItem = document.createElement('div');
                newItem.innerHTML = experienceTemplate(experienceCounter);
                document.getElementById('pengalaman-form-container').appendChild(newItem.firstElementChild);

                updateDeleteButtons();
                saveExperiencesToSession(); // Save to session after adding
            });

            // Delete Experience
            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('remove-pengalaman')) {
                    if (document.querySelectorAll('.pengalaman-item').length > 1) {
                        e.target.closest('.pengalaman-item').remove();
                        experienceCounter--;
                        updateDeleteButtons();
                        saveExperiencesToSession(); // Save to session after deleting
                    }
                }
            });

            // Update Delete Buttons
            function updateDeleteButtons() {
                const items = document.querySelectorAll('.pengalaman-item');
                items.forEach((item, index) => {
                    const btn = item.querySelector('.remove-pengalaman');
                    // Hide delete button if there's only one item
                    btn.classList.toggle('hidden', items.length === 1);
                });
            }

            // Save to Session (debounce for performance)
            function saveExperiencesToSession() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    const experiencesData = [];

                    document.querySelectorAll('.pengalaman-item').forEach((item, index) => {
                        const data = {
                            company_name: item.querySelector('[name*="company_name"]').value,
                            position: item.querySelector('[name*="position"]').value,
                            location: item.querySelector('[name*="location"]').value,
                            company_profile: item.querySelector('[name*="company_profile"]')
                                .value,
                            start_month: item.querySelector('[name*="start_month"]').value,
                            start_year: item.querySelector('[name*="start_year"]').value,
                            end_month: item.querySelector('[name*="end_month"]').value,
                            end_year: item.querySelector('[name*="end_year"]').value,
                            currently_working: item.querySelector('[name*="currently_working"]')
                                .checked,
                            portfolio_description: item.querySelector(
                                '[name*="portfolio_description"]').value
                        };
                        experiencesData.push(data);
                    });

                    fetch('{{ route('save.session.realtime') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                field: 'pengalaman_kerja', // Changed field name
                                value: experiencesData,
                                slug: cvSlug
                            })
                        })
                        .then(response => response.json()) // Important: Parse response if you need it
                        .then(data => {
                            console.log('Session saved:', data); // For debugging
                            updatePreview(); // Update preview after session is saved
                        })
                        .catch(error => console.error('Error saving session:', error));
                }, 500); // 500ms delay
            }

            // Update Preview
            function updatePreview() {
                fetch(`/load-session-data/${cvSlug}`)
                    .then(response => response.json())
                    .then(data => {
                        const container = document.getElementById('preview-pengalaman');
                        if (container) { // Ensure preview element exists
                            if (data.pengalaman_kerja?.length > 0) { // Changed data key
                                container.innerHTML = data.pengalaman_kerja.map(p => `
                                    <div class="mt-4 border-b pb-4">
                                        <h3 class="font-bold text-lg">${p.company_name}</h3>
                                        <p class="text-gray-600 mt-1">
                                            ${p.position} | 
                                            ${p.start_month} ${p.start_year} - 
                                            ${p.currently_working ? 'Present' : `${p.end_month} ${p.end_year}`}
                                        </p>
                                        <p class="text-gray-500 text-sm mt-1">${p.location}</p>
                                        <p class="text-gray-700 mt-2">${p.company_profile}</p>
                                        ${p.portfolio_description ? `<p class="text-blue-600 text-sm mt-1">${p.portfolio_description}</p>` : ''}
                                    </div>
                                `).join('');
                            } else {
                                container.innerHTML = '<p class="text-gray-500">No work experience yet</p>';
                            }
                        }
                    })
                    .catch(error => console.error('Error loading session data for preview:', error));
            }

            // Event listener for input (to save to session in real-time)
            document.addEventListener('input', (e) => {
                // Ensure input originates from within .pengalaman-item
                if (e.target.closest('.pengalaman-item')) {
                    saveExperiencesToSession();
                }
            });


            // --- Code for Saving to Database ---
            document.getElementById('savePengalamanBtn').addEventListener('click', async () => {
                if (!cvSlug) {
                    alert('CV Slug not found. Cannot save work experience.');
                    return;
                }

                const experiencesData = [];
                document.querySelectorAll('.pengalaman-item').forEach((item, index) => {
                    const data = {
                        company_name: item.querySelector('[name*="company_name"]').value,
                        position: item.querySelector('[name*="position"]').value,
                        location: item.querySelector('[name*="location"]').value,
                        company_profile: item.querySelector('[name*="company_profile"]')
                            .value,
                        start_month: item.querySelector('[name*="start_month"]').value,
                        start_year: item.querySelector('[name*="start_year"]').value,
                        end_month: item.querySelector('[name*="end_month"]').value,
                        end_year: item.querySelector('[name*="end_year"]').value,
                        currently_working: item.querySelector('[name*="currently_working"]')
                            .checked,
                        portfolio_description: item.querySelector(
                            '[name*="portfolio_description"]').value
                    };
                    experiencesData.push(data);
                });

                try {
                    const response = await fetch(
                        `/cv/${cvSlug}/work-experiences`, { // Adjust URL to your route
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                work_experiences: experiencesData // Send pengalaman_kerja array as per validation
                            })
                        });

                    const result = await response.json();

                    if (response.ok) {
                        alert(result.message);
                        if (result.redirect_url) {
                            window.location.href = result.redirect_url;
                        }
                    } else {
                        // Handle validation errors or other server errors
                        let errorMessage = result.message ||
                            'An error occurred while saving work experience.';
                        if (result.errors) {
                            errorMessage += '\n\nError Details:\n' + Object.values(result.errors).map(
                                e => e.join(', ')).join('\n');
                        }
                        alert(errorMessage);
                        console.error('Error saving work experience:', result);
                    }
                } catch (error) {
                    console.error('Network or server error occurred:', error);
                    alert('A network or server error occurred while saving work experience.');
                }
            });

            if (cvSlug) {
                fetch(`/cv/${cvSlug}/work-experiences/load`) // Adjust URL to your route
                    .then(response => response.json())
                    .then(data => {
                        const container = document.querySelector('#pengalaman-form-container');
                        container.innerHTML = ''; // Clear form container
                        console.log(data);
                        if (data.pengalaman_kerja && data.pengalaman_kerja.length > 0) { // Changed data key
                            console.log('hll');
                            data.pengalaman_kerja.forEach((p, index) => {
                                const counter = index + 1;
                                const newItem = document.createElement('div');
                                newItem.innerHTML = experienceTemplate(counter);
                                const item = newItem.firstElementChild;

                                // Inside fetch load work experiences data:
                                item.querySelector(`[name*="company_name"]`).value = p
                                    .company_name || ''; // Adjust to database field name
                                item.querySelector(`[name*="position"]`).value = p.position || '';
                                item.querySelector(`[name*="location"]`).value = p.location || '';
                                item.querySelector(`[name*="company_profile"]`).value = p
                                    .company_profile || '';
                                item.querySelector(`[name*="start_month"]`).value = p.start_month || '';
                                item.querySelector(`[name*="start_year"]`).value = p.start_year || '';
                                item.querySelector(`[name*="end_month"]`).value = p.end_month || '';
                                item.querySelector(`[name*="end_year"]`).value = p.end_year || '';
                                item.querySelector(`[name*="currently_working"]`).checked = p
                                    .currently_working || false; // Ensure boolean
                                item.querySelector(`[name*="portfolio_description"]`).value = p
                                    .portfolio_description || '';

                                container.appendChild(item);
                            });
                            experienceCounter = data.pengalaman_kerja.length;
                        } else {
                            // If no data from database, initialize one empty form
                            const initialItem = document.createElement('div');
                            initialItem.innerHTML = experienceTemplate(1);
                            container.appendChild(initialItem.firstElementChild);
                            experienceCounter = 1; // Reset counter
                        }
                        updateDeleteButtons(); // Update delete button display
                        // saveExperiencesToSession(); // Save loaded data to session as well (for preview)
                    })
                    .catch(error => {
                        console.error('Error loading work experiences:', error);
                        // If error occurs while loading, ensure at least one empty form
                        const container = document.querySelector('#pengalaman-form-container');
                        if (!container.querySelector('.pengalaman-item')) {
                            const initialItem = document.createElement('div');
                            initialItem.innerHTML = experienceTemplate(1);
                            container.appendChild(initialItem.firstElementChild);
                            experienceCounter = 1;
                        }
                        updateDeleteButtons();
                    });
            } else {
                // If CV slug is not present (maybe new CV), ensure there's one empty form
                if (!document.querySelector('.pengalaman-item')) {
                    const initialItem = document.createElement('div');
                    initialItem.innerHTML = experienceTemplate(1);
                    document.getElementById('pengalaman-form-container').appendChild(initialItem.firstElementChild);
                    experienceCounter = 1;
                }
                updateDeleteButtons();
                // saveExperiencesToSession(); // Save initial empty form to session
            }

            // Initial Load
            fetch(`/load-session-data/${cvSlug}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data.pengalaman_kerja);
                    if (data.pengalaman_kerja?.length > 0) {
                        document.querySelector('#pengalaman-form-container').innerHTML = '';
                        data.pengalaman_kerja.forEach((p, index) => {
                            const counter = index + 1;
                            const newItem = document.createElement('div');
                            newItem.innerHTML = experienceTemplate(counter);
                            const item = newItem.firstElementChild;

                            // Fill values
                            Object.entries(p).forEach(([key, value]) => {
                                const el = item.querySelector(`[name*="${key}"]`);
                                if (el) {
                                    if (el.type === 'checkbox') {
                                        el.checked = value;
                                    } else {
                                        el.value = value || '';
                                    }
                                }
                            });

                            document.getElementById('pengalaman-form-container').appendChild(item);
                        });
                        experienceCounter = data.pengalaman_kerja.length;
                        updateDeleteButtons();
                        updatePreview();
                    }
                });
        });
    </script>
</x-cv-generator-layout>
