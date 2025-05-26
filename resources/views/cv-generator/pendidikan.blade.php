<x-cv-generator-layout :activeStep="$activeStep" :currentCv="$currentCv">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-bold">Pendidikan</h2>
        <p class="text-sm text-gray-600 mb-6">Masukkan riwayat pendidikan kamu</p>
        <div class="mb-6" id="edukasi-form-container">
            <input type="hidden" id="current_cv_slug" value="{{ $currentCv->slug ?? '' }}">
            <div class="edukasi-item bg-white p-6 rounded-lg border mb-5">
                {{-- Nama Sekolah/Universitas --}}
                <div class="mb-4">
                    <x-input-label for="school_name_1" :value="__('Nama Sekolah/Universitas')" />
                    <x-text-input id="school_name_1" name="edukasi[1][school_name]" type="text"
                        class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Contoh: Universitas Indonesia"
                        required />
                </div>

                {{-- Lokasi --}}
                <div class="mb-4">
                    <x-input-label for="location_1" :value="__('Lokasi Sekolah/Universitas')" />
                    <x-text-input id="location_1" name="edukasi[1][location]" type="text"
                        class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Contoh: Jakarta, Indonesia"
                        required />
                </div>

                {{-- Tanggal Mulai --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <x-input-label for="start_month_1" :value="__('Mulai Bulan')" />
                        <x-text-input id="start_month_1" name="edukasi[1][start_month]" type="text"
                            class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Contoh: Agustus" required />
                    </div>
                    <div>
                        <x-input-label for="start_year_1" :value="__('Mulai Tahun')" />
                        <x-text-input id="start_year_1" name="edukasi[1][start_year]" type="number"
                            class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Contoh: 2018" required />
                    </div>
                </div>

                {{-- Tanggal Kelulusan --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <x-input-label for="graduation_month_1" :value="__('Kelulusan Bulan')" />
                        <x-text-input id="graduation_month_1" name="edukasi[1][graduation_month]" type="text"
                            class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Contoh: Juni" required />
                    </div>
                    <div>
                        <x-input-label for="graduation_year_1" :value="__('Kelulusan Tahun')" />
                        <x-text-input id="graduation_year_1" name="edukasi[1][graduation_year]" type="number"
                            class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Contoh: 2022" required />
                    </div>
                </div>

                {{-- Tingkat Pendidikan --}}
                <div class="mb-4">
                    <x-input-label for="degree_level_1" :value="__('Tingkat Pendidikan')" />
                    <x-text-input id="degree_level_1" name="edukasi[1][degree_level]" type="text"
                        class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Contoh: S1 Teknik Informatika"
                        required />
                </div>

                {{-- Deskripsi --}}
                <div class="mb-4">
                    <x-input-label for="description_1" :value="__('Deskripsi Pendidikan')" />
                    <textarea id="description_1" name="edukasi[1][description]" rows="3"
                        class="block mt-1 w-full text-sm 2xl:text-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        placeholder="Deskripsi jurusan atau pencapaian akademik" required></textarea>
                </div>

                {{-- IPK --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <x-input-label for="gpa_1" :value="__('IPK (Opsional)')" />
                        <x-text-input id="gpa_1" name="edukasi[1][gpa]" type="number" step="0.01"
                            class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Contoh: 3.75" />
                    </div>
                    <div>
                        <x-input-label for="gpa_max_1" :value="__('IPK Maksimal')" />
                        <x-text-input id="gpa_max_1" name="edukasi[1][gpa_max]" type="number" step="0.1"
                            class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Contoh: 4.00" required />
                    </div>
                </div>

                {{-- Aktivitas --}}
                <div class="mb-4">
                    <x-input-label for="activities_1" :value="__('Aktivitas dan Pencapaian')" />
                    <textarea id="activities_1" name="edukasi[1][activities]" rows="3"
                        class="block mt-1 w-full text-sm 2xl:text-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        placeholder="Contoh: Ketua Himpunan Mahasiswa, Juara Lomba Coding" required></textarea>
                </div>

                <button type="button" class="mt-2 text-red-500 text-sm remove-edukasi hidden">
                    Hapus Pendidikan
                </button>

            </div>
        </div>

        <button type="button" id="tambah-edukasi"
            class="w-full border border-dashed border-indigo-500 text-indigo-600 px-4 py-2 rounded-md text-sm hover:bg-indigo-50">
            + Tambah Pendidikan
        </button>

        <div class="flex justify-end">
            {{-- Kembali Button --}}
            <div class="mt-8 flex justify-end">
                <a href="{{ route('cv.experiences', ['slug' => $currentCv->slug]) }}"
                    class="inline-flex items-center px-6 py-3 bg-white border border-indigo-600 rounded-md font-semibold text-base text-indigo-600 uppercase tracking-widest hover:bg-indigo-50 focus:bg-indigo-50 active:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-4">
                    Kembali
                </a>
            </div>

            {{-- Save & Continue Button --}}
            <div class="mt-8 flex justify-end">
                <button type="button" id="saveEdukasiBtn"
                    class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Simpan & Lanjutkan
                </button>
            </div>
        </div>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let edukasiCounter = 1;
            const maxEdukasi = 5;
            let debounceTimer;
            const cvSlug = document.getElementById('current_cv_slug').value;

            const edukasiTemplate = (counter) => `
                <div class="edukasi-item bg-white p-6 rounded-lg border mb-5">
                        <h2 class="text-lg font-bold">Pendidikan</h2>
                        <p class="text-sm text-gray-600 mb-6">Masukkan riwayat pendidikan kamu</p>

                        <div class="mb-4">
                            <x-input-label for="school_name_${counter}" :value="__('Nama Sekolah/Universitas')" />
                            <x-text-input id="school_name_${counter}" 
                                name="edukasi[${counter}][school_name]" type="text"
                                class="block mt-1 w-full text-sm 2xl:text-lg" 
                                placeholder="Contoh: Universitas Indonesia" required />
                        </div>

                        {{-- Lokasi --}}
                        <div class="mb-4">
                            <x-input-label for="location_${counter}" :value="__('Lokasi Sekolah/Universitas')" />
                            <x-text-input id="location_${counter}" name="edukasi[${counter}][location]" type="text"
                                class="block mt-1 w-full text-sm 2xl:text-lg"
                                placeholder="Contoh: Jakarta, Indonesia" required />
                        </div>

                        {{-- Tanggal Mulai --}}
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="start_month_${counter}" :value="__('Mulai Bulan')" />
                                <x-text-input id="start_month_${counter}" name="edukasi[${counter}][start_month]" type="text"
                                    class="block mt-1 w-full text-sm 2xl:text-lg"
                                    placeholder="Contoh: Agustus" required />
                            </div>
                            <div>
                                <x-input-label for="start_year_${counter}" :value="__('Mulai Tahun')" />
                                <x-text-input id="start_year_${counter}" name="edukasi[${counter}][start_year]" type="number"
                                    class="block mt-1 w-full text-sm 2xl:text-lg"
                                    placeholder="Contoh: 2018" required />
                            </div>
                        </div>

                        {{-- Tanggal Kelulusan --}}
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="graduation_month_${counter}" :value="__('Kelulusan Bulan')" />
                                <x-text-input id="graduation_month_${counter}" name="edukasi[${counter}][graduation_month]" type="text"
                                    class="block mt-1 w-full text-sm 2xl:text-lg"
                                    placeholder="Contoh: Juni" required />
                            </div>
                            <div>
                                <x-input-label for="graduation_year_${counter}" :value="__('Kelulusan Tahun')" />
                                <x-text-input id="graduation_year_${counter}" name="edukasi[${counter}][graduation_year]" type="number"
                                    class="block mt-1 w-full text-sm 2xl:text-lg"
                                    placeholder="Contoh: 2022" required />
                            </div>
                        </div>

                        {{-- Tingkat Pendidikan --}}
                        <div class="mb-4">
                            <x-input-label for="degree_level_${counter}" :value="__('Tingkat Pendidikan')" />
                            <x-text-input id="degree_level_${counter}" name="edukasi[${counter}][degree_level]" type="text"
                                class="block mt-1 w-full text-sm 2xl:text-lg"
                                placeholder="Contoh: S1 Teknik Informatika" required />
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <x-input-label for="description_${counter}" :value="__('Deskripsi Pendidikan')" />
                            <textarea id="description_${counter}" name="edukasi[${counter}][description]" rows="3"
                                class="block mt-1 w-full text-sm 2xl:text-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Deskripsi jurusan atau pencapaian akademik" required></textarea>
                        </div>

                        {{-- IPK --}}
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="gpa_${counter}" :value="__('IPK (Opsional)')" />
                                <x-text-input id="gpa_${counter}" name="edukasi[${counter}][gpa]" type="number" step="0.01"
                                    class="block mt-1 w-full text-sm 2xl:text-lg"
                                    placeholder="Contoh: 3.75" />
                            </div>
                            <div>
                                <x-input-label for="gpa_max_${counter}" :value="__('IPK Maksimal')" />
                                <x-text-input id="gpa_max_${counter}" name="edukasi[${counter}][gpa_max]" type="number" step="0.1"
                                    class="block mt-1 w-full text-sm 2xl:text-lg"
                                    placeholder="Contoh: 4.00" required />
                            </div>
                        </div>

                        {{-- Aktivitas --}}
                        <div class="mb-4">
                            <x-input-label for="activities_${counter}" :value="__('Aktivitas dan Pencapaian')" />
                            <textarea id="activities_${counter}" name="edukasi[${counter}][activities]" rows="3"
                                class="block mt-1 w-full text-sm 2xl:text-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Contoh: Ketua Himpunan Mahasiswa, Juara Lomba Coding" required></textarea>
                        </div>

                        <button type="button" 
                            class="mt-2 text-red-500 text-sm remove-edukasi">
                            Hapus Pendidikan
                        </button>
                </div>
            `;

            // Tambah Pendidikan
            document.getElementById('tambah-edukasi').addEventListener('click', () => {
                if (edukasiCounter >= maxEdukasi) {
                    alert(`Maksimal ${maxEdukasi} riwayat pendidikan`);
                    return;
                }

                edukasiCounter++;
                const newItem = document.createElement('div');
                newItem.innerHTML = edukasiTemplate(edukasiCounter);
                document.getElementById('edukasi-form-container').appendChild(newItem.firstElementChild);

                updateDeleteButtons();
                saveEdukasiToSession();
            });

            // Hapus Pendidikan
            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('remove-edukasi')) {
                    if (document.querySelectorAll('.edukasi-item').length > 1) {
                        e.target.closest('.edukasi-item').remove();
                        edukasiCounter--;
                        updateDeleteButtons();
                        saveEdukasiToSession();
                    }
                }
            });

            // Update Tombol Hapus
            function updateDeleteButtons() {
                const items = document.querySelectorAll('.edukasi-item');
                items.forEach((item, index) => {
                    const btn = item.querySelector('.remove-edukasi');
                    btn.classList.toggle('hidden', items.length === 1);
                });
            }

            // Simpan ke Session
            function saveEdukasiToSession() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    const edukasiData = [];

                    document.querySelectorAll('.edukasi-item').forEach((item, index) => {
                        const data = {
                            school_name: item.querySelector('[name*="school_name"]').value,
                            location: item.querySelector('[name*="location"]').value,
                            start_month: item.querySelector('[name*="start_month"]').value,
                            start_year: item.querySelector('[name*="start_year"]').value,
                            graduation_month: item.querySelector('[name*="graduation_month"]')
                                .value,
                            graduation_year: item.querySelector('[name*="graduation_year"]')
                                .value,
                            degree_level: item.querySelector('[name*="degree_level"]').value,
                            description: item.querySelector('[name*="description"]').value,
                            gpa: item.querySelector('[name*="gpa"]').value,
                            gpa_max: item.querySelector('[name*="gpa_max"]').value,
                            activities: item.querySelector('[name*="activities"]').value
                        };
                        edukasiData.push(data);
                    });

                    fetch('{{ route('save.session.realtime') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            field: 'edukasi', // Keep 'edukasi' for the session key if your backend expects it
                            value: edukasiData,
                            slug: cvSlug
                        })
                    }).then(updatePreview);
                }, 500);
            }

            // Update Preview
            function updatePreview() {
                fetch(`/load-session-data/${cvSlug}`)
                    .then(response => response.json())
                    .then(data => {
                        const container = document.getElementById('preview-edukasi');
                        if (data.edukasi?.length > 0) {
                            container.innerHTML = data.edukasi.map(e => `
                                <div class="mt-4 border-b pb-4">
                                    <h3 class="font-bold text-lg">${e.degree_level}</h3>
                                    <p class="text-gray-600 mt-1">
                                        ${e.school_name} | 
                                        ${e.start_month} ${e.start_year} - ${e.graduation_month} ${e.graduation_year}
                                    </p>
                                    <p class="text-gray-500 text-sm mt-1">${e.location}</p>
                                    ${e.gpa ? `<p class="text-gray-700 mt-2">IPK: ${e.gpa}/${e.gpa_max}</p>` : ''}
                                    <p class="text-gray-700 mt-2">${e.description}</p>
                                    ${e.activities ? `<div class="mt-2 text-blue-600 text-sm">${e.activities}</div>` : ''}
                                </div>
                            `).join('');
                        } else {
                            container.innerHTML = '<p class="text-gray-500">Belum ada riwayat pendidikan</p>';
                        }
                    });
            }

            // Event Input
            document.addEventListener('input', (e) => {
                if (e.target.closest('.edukasi-item')) {
                    saveEdukasiToSession();
                }
            });


            document.getElementById('saveEdukasiBtn').addEventListener('click', async () => {
                if (!cvSlug) {
                    alert('CV Slug tidak ditemukan. Tidak dapat menyimpan pendidikan.');
                    return;
                }

                const edukasiData = [];
                document.querySelectorAll('.edukasi-item').forEach((item, index) => {
                    const data = {
                        school_name: item.querySelector('[name*="school_name"]').value,
                        location: item.querySelector('[name*="location"]').value,
                        start_month: item.querySelector('[name*="start_month"]').value,
                        start_year: item.querySelector('[name*="start_year"]').value,
                        graduation_month: item.querySelector('[name*="graduation_month"]')
                            .value,
                        graduation_year: item.querySelector('[name*="graduation_year"]')
                            .value,
                        degree_level: item.querySelector('[name*="degree_level"]').value,
                        description: item.querySelector('[name*="description"]').value,
                        gpa: item.querySelector('[name*="gpa"]').value || null,
                        gpa_max: item.querySelector('[name*="gpa_max"]').value,
                        activities: item.querySelector('[name*="activities"]').value
                    };
                    edukasiData.push(data);
                });

                try {
                    const response = await fetch(`/cv/${cvSlug}/educations/store`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            educations: edukasiData // Changed 'pendidikan' to 'educations' for consistency with input names
                        })
                    });

                    const result = await response.json();

                    if (response.ok) {
                        alert(result.message);
                        if (result.redirect_url) {
                            window.location.href = result.redirect_url;
                        }
                    } else {
                        let errorMessage = result.message || 'Gagal menyimpan data pendidikan';
                        if (result.errors) {
                            errorMessage += '\n\n' + Object.values(result.errors).flat().join('\n');
                        }
                        alert(errorMessage);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan jaringan');
                }
            });

            if (cvSlug) {
                fetch(`/cv/${cvSlug}/educations/load`)
                    .then(response => response.json())
                    .then(data => {
                        const container = document.querySelector('#edukasi-form-container');
                        container.innerHTML = '';

                        console.log(data);
                        if (data.educations && data.educations.length >
                            0) { // Changed 'pendidikan' to 'educations'
                            console.log('haja');
                            data.educations.forEach((e, index) => {
                                const counter = index + 1;
                                const newItem = document.createElement('div');
                                newItem.innerHTML = edukasiTemplate(counter);
                                const item = newItem.firstElementChild;

                                // Mapping data
                                item.querySelector('[name*="school_name"]').value = e.school_name ||
                                    '';
                                item.querySelector('[name*="location"]').value = e.location || '';
                                item.querySelector('[name*="start_month"]').value = e.start_month || '';
                                item.querySelector('[name*="start_year"]').value = e.start_year || '';
                                item.querySelector('[name*="graduation_month"]').value = e
                                    .graduation_month ||
                                    '';
                                item.querySelector('[name*="graduation_year"]').value = e
                                    .graduation_year ||
                                    '';
                                item.querySelector('[name*="degree_level"]').value = e.degree_level ||
                                    '';
                                item.querySelector('[name*="description"]').value = e.description || '';
                                item.querySelector('[name*="gpa"]').value = e.gpa || '';
                                item.querySelector('[name*="gpa_max"]').value = e.gpa_max ||
                                    '';
                                item.querySelector('[name*="activities"]').value = e.activities || '';

                                container.appendChild(item);
                            });
                            edukasiCounter = data.educations.length;
                            updateDeleteButtons();
                        } else {
                            // Jika tidak ada data dari database, inisialisasi satu form kosong
                            const initialItem = document.createElement('div');
                            initialItem.innerHTML = edukasiTemplate(1);
                            container.appendChild(initialItem.firstElementChild);
                            edukasiCounter = 1; // Reset counter
                        }
                    })
                    .catch(error => {
                        console.error('Error loading educations:', error);
                        // Jika terjadi error saat memuat, pastikan setidaknya ada satu form kosong
                        const container = document.querySelector('#edukasi-form-container');
                        if (!container.querySelector('.edukasi-item')) {
                            const initialItem = document.createElement('div');
                            initialItem.innerHTML = edukasiTemplate(1);
                            container.appendChild(initialItem.firstElementChild);
                            edukasiCounter = 1;
                        }
                        updateDeleteButtons();
                    });
            }

            // Load Awal
            fetch(`/load-session-data/${cvSlug}`)
                .then(response => response.json())
                .then(data => {
                    console.log('halo');
                    if (data.edukasi?.length > 0) {
                        document.querySelector('#edukasi-form-container').innerHTML = '';
                        data.edukasi.forEach((e, index) => {
                            const counter = index + 1;
                            const newItem = document.createElement('div');
                            newItem.innerHTML = edukasiTemplate(counter);
                            const item = newItem.firstElementChild;

                            Object.entries(e).forEach(([key, value]) => {
                                const el = item.querySelector(`[name*="${key}"]`);
                                if (el) el.value = value || '';
                            });

                            document.getElementById('edukasi-form-container').appendChild(item);
                        });
                        edukasiCounter = data.edukasi.length;
                        updateDeleteButtons();
                        updatePreview();
                    }
                });
        });
    </script>
</x-cv-generator-layout>
