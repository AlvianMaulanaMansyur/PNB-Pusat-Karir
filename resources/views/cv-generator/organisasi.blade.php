<x-cv-generator-layout :activeStep="$activeStep" :currentCv="$currentCv">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-bold">Pengalaman Organisasi</h2>
        <p class="text-sm text-gray-600 mb-6">Masukkan pengalaman organisasi kamu</p>
        <div class="mb-6" id="organisasi-form-container">
            <input type="hidden" id="current_cv_slug" value="{{ $currentCv->slug ?? '' }}">
            <div class="organisasi-item bg-white p-6 rounded-lg border mb-5">
                {{-- Organisasi/Nama Acara --}}
                <div class="mb-4">
                    <x-input-label for="organization_name_1" :value="__('Organisasi/Nama Acara')" />
                    <x-text-input id="organization_name_1" name="organisasi[1][organization_name]" type="text"
                        class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Masukkan Nama Organisasi/Acara" />
                </div>

                {{-- Posisi/Gelar Jabatan --}}
                <div class="mb-4">
                    <x-input-label for="position_1" :value="__('Posisi/Gelar Jabatan')" />
                    <x-text-input id="position_1" name="organisasi[1][position]" type="text"
                        class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Masukkan Posisi atau Jabatan" />
                </div>

                {{-- Deskripsi Organisasi --}}
                <div class="mb-4">
                    <x-input-label for="organization_description_1" :value="__('Deskripsi Organisasi (Opsional)')" />
                    <textarea id="organization_description_1" name="organisasi[1][organization_description]" rows="3"
                        class="block mt-1 w-full text-sm 2xl:text-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        placeholder="Masukkan Deskripsi Organisasi"></textarea>
                </div>

                {{-- Lokasi Organisasi --}}
                <div class="mb-4">
                    <x-input-label for="location_1" :value="__('Aktivitas/Acara/Lokasi Organisasi (Kota/Negara)')" />
                    <x-text-input id="location_1" name="organisasi[1][location]" type="text"
                        class="block mt-1 w-full text-sm 2xl:text-lg" placeholder="Masukkan Lokasi Kegiatan" />
                </div>

                {{-- Tanggal Mulai --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <x-input-label for="start_month_1" :value="__('Tanggal Mulai (Bulan)')" />
                        <x-dropdown.bulan-dropdown id="start_month_1" name="organisasi[1][start_month]" class="block mt-1 w-full text-sm 2xl:text-lg"/>
                    </div>
                    <div>
                        <x-input-label for="start_year_1" :value="__('Tanggal Mulai (Tahun)')" />
                        <x-dropdown.tahun-dropdown id="start_year_1" :name="__('organisasi[1][start_year]')"
                            class="mt-1 w-full text-sm 2xl:text-lg" />
                    </div>
                </div>

                {{-- Tanggal Selesai --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <x-input-label for="end_month_1" :value="__('Tanggal Selesai (Bulan)')" />
                        <x-dropdown.bulan-dropdown id="end_month_1" name="organisasi[1][end_month]" class="block mt-1 w-full text-sm 2xl:text-lg"/>
                        
                    </div>
                    <div>
                        <x-input-label for="end_year_1" :value="__('Tanggal Selesai (Tahun)')" />
                        <x-dropdown.tahun-dropdown id="end_year_1" :name="__('organisasi[1][end_year]')"
                            class="mt-1 w-full text-sm 2xl:text-lg" />
                    </div>
                </div>

                {{-- Checkbox --}}
                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="organisasi[1][is_active]"
                            class="rounded text-indigo-600 shadow-sm border-gray-300 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Saat ini saya aktif di sini</span>
                    </label>
                </div>

                {{-- Deskripsi Pekerjaan --}}
                <div class="mb-4">
                    <x-input-label for="job_description_1" :value="__('Deskripsi Pekerjaan')" />
                    <x-text-input id="job_description_1" name="organisasi[1][job_description]" type="text"
                        class="block mt-1 w-full text-sm 2xl:text-lg"
                        placeholder="Contoh: Mengorganisir acara tahunan" />
                </div>

                <button type="button" class="mt-2 text-red-500 text-sm remove-organisasi hidden">
                    Hapus Organisasi
                </button>
            </div>
        </div>

        <button type="button" id="tambah-organisasi"
            class="w-full border border-dashed border-indigo-500 text-indigo-600 px-4 py-2 rounded-md text-sm hover:bg-indigo-50">
            + Tambah Pengalaman
        </button>

        <div class="flex justify-end">
            {{-- Kembali Button --}}
            <div class="mt-8 flex justify-end">
                <a href="{{ route('cv.educations', ['slug' => $currentCv->slug]) }}"
                    class="inline-flex items-center px-6 py-3 bg-white border border-indigo-600 rounded-md font-semibold text-base text-indigo-600 uppercase tracking-widest hover:bg-indigo-50 focus:bg-indigo-50 active:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-4">
                    Kembali
                </a>
            </div>

            {{-- Save & Continue Button --}}
            <div class="mt-8 flex justify-end">
                <button type="button" id="saveOrganisasiBtn"
                    class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Simpan & Lanjutkan
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let organisasiCounter = 1;
            const maxOrganisasi = 5;
            let debounceTimer;
            const cvSlug = document.getElementById('current_cv_slug').value;

            const organisasiTemplate = (counter) => `
                <div class="organisasi-item bg-white p-6 rounded-lg border mb-5">
                        <div class="mb-4">
                            <x-input-label for="organization_name_${counter}" :value="__('Organisasi/Nama Acara')" />
                            <x-text-input id="organization_name_${counter}" 
                                name="organisasi[${counter}][organization_name]" type="text"
                                class="block mt-1 w-full text-sm 2xl:text-lg" 
                                placeholder="Masukkan Nama Organisasi/Acara" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="position_${counter}" :value="__('Posisi/Gelar Jabatan')" />
                            <x-text-input id="position_${counter}" name="organisasi[${counter}][position]" type="text"
                                class="block mt-1 w-full text-sm 2xl:text-lg" 
                                placeholder="Masukkan Posisi atau Jabatan" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="organization_description_${counter}" :value="__('Deskripsi Organisasi (Opsional)')" />
                            <textarea id="organization_description_${counter}" name="organisasi[${counter}][organization_description]" rows="3"
                                class="block mt-1 w-full text-sm 2xl:text-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Masukkan Deskripsi Organisasi"></textarea>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="location_${counter}" :value="__('Aktivitas/Acara/Lokasi Organisasi (Kota/Negara)')" />
                            <x-text-input id="location_${counter}" name="organisasi[${counter}][location]" type="text"
                                class="block mt-1 w-full text-sm 2xl:text-lg"
                                placeholder="Masukkan Lokasi Kegiatan" />
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="start_month_${counter}" :value="__('Tanggal Mulai (Bulan)')" />
                                <x-dropdown.bulan-dropdown id="start_month_${counter}" name="organisasi[${counter}][start_month]" class="block mt-1 w-full text-sm 2xl:text-lg"/>
                            </div>
                            <div>
                                <x-input-label for="start_year_${counter}" :value="__('Tanggal Mulai (Tahun)')" />
                                <x-dropdown.tahun-dropdown id="start_year_${counter}" :name="__('organisasi[${counter}][start_year]')" class="mt-1 w-full text-sm 2xl:text-lg" />
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="end_month_${counter}" :value="__('Tanggal Selesai (Bulan)')" />
                                <x-dropdown.bulan-dropdown id="end_month_${counter}" name="organisasi[${counter}][end_month]" class="block mt-1 w-full text-sm 2xl:text-lg"/>
                            </div>
                            <div>
                                <x-input-label for="end_year_${counter}" :value="__('Tanggal Selesai (Tahun)')" />
                                <x-dropdown.tahun-dropdown id="end_year_${counter}" :name="__('organisasi[${counter}][end_year]')" class="mt-1 w-full text-sm 2xl:text-lg" />
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="organisasi[${counter}][is_active]" 
                                    class="rounded text-indigo-600 shadow-sm border-gray-300 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700">Saat ini saya aktif di sini</span>
                            </label>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="job_description_${counter}" :value="__('Deskripsi Pekerjaan')" />
                            <x-text-input id="job_description_${counter}" name="organisasi[${counter}][job_description]" type="text"
                                class="block mt-1 w-full text-sm 2xl:text-lg"
                                placeholder="Contoh: Mengorganisir acara tahunan" />
                        </div>

                        <button type="button" 
                            class="mt-2 text-red-500 text-sm remove-organisasi">
                            Hapus Organisasi
                        </button>
                </div>
            `;

            // Tambah Organisasi
            document.getElementById('tambah-organisasi').addEventListener('click', () => {
                if (organisasiCounter >= maxOrganisasi) {
                    alert(`Maksimal ${maxOrganisasi} organisasi`);
                    return;
                }

                organisasiCounter++;
                const newItem = document.createElement('div');
                newItem.innerHTML = organisasiTemplate(organisasiCounter);
                document.getElementById('organisasi-form-container').appendChild(newItem.firstElementChild);

                updateDeleteButtons();
                saveOrganisasiToSession();
            });

            // Hapus Organisasi
            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('remove-organisasi')) {
                    if (document.querySelectorAll('.organisasi-item').length > 1) {
                        e.target.closest('.organisasi-item').remove();
                        organisasiCounter--;
                        updateDeleteButtons();
                        saveOrganisasiToSession();
                    }
                }
            });

            // Update Tombol Hapus
            function updateDeleteButtons() {
                const items = document.querySelectorAll('.organisasi-item');
                items.forEach((item, index) => {
                    const btn = item.querySelector('.remove-organisasi');
                    btn.classList.toggle('hidden', items.length === 1);
                });
            }

            // Simpan ke Session
            function saveOrganisasiToSession() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    const organisasiData = [];

                    document.querySelectorAll('.organisasi-item').forEach((item, index) => {
                        const data = {
                            organization_name: item.querySelector('[name*="organization_name"]')
                                .value,
                            position: item.querySelector('[name*="position"]').value,
                            organization_description: item.querySelector(
                                '[name*="organization_description"]').value,
                            location: item.querySelector('[name*="location"]')
                                .value,
                            start_month: item.querySelector('[name*="start_month"]').value,
                            start_year: item.querySelector('[name*="start_year"]').value,
                            end_month: item.querySelector('[name*="end_month"]').value,
                            end_year: item.querySelector('[name*="end_year"]').value,
                            is_active: item.querySelector('[name*="is_active"]').checked,
                            job_description: item.querySelector(
                                '[name*="job_description"]').value
                        };
                        organisasiData.push(data);
                    });

                    fetch('{{ route('save.session.realtime') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            field: 'pengalaman_organisasi',
                            value: organisasiData,
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
                        const container = document.getElementById('preview-organisasi');
                        if (data.pengalaman_organisasi?.length > 0) {
                            container.innerHTML = data.pengalaman_organisasi.map(p => `
                                <div class="mt-4 border-b pb-4">
                                    <h3 class="font-bold text-lg">${p.organization_name}</h3>
                                    <p class="text-gray-600 mt-1">
                                        ${p.position} | 
                                        ${p.start_month} ${p.start_year} - 
                                        ${p.is_active ? 'Sekarang' : `${p.end_month} ${p.end_year}`}
                                    </p>
                                    <p class="text-gray-500 text-sm mt-1">${p.location}</p>
                                    ${p.organization_description ? `<p class="text-gray-700 mt-2">${p.organization_description}</p>` : ''}
                                    ${p.job_description ? `<p class="text-blue-600 text-sm mt-1">${p.job_description}</p>` : ''}
                                </div>
                            `).join('');
                        } else {
                            container.innerHTML =
                                '<p class="text-gray-500">Belum ada pengalaman organisasi</p>';
                        }
                    });
            }

            // Event Input
            document.addEventListener('input', (e) => {
                if (e.target.closest('.organisasi-item')) {
                    saveOrganisasiToSession();
                }
            });



            // ==================== SIMPAN KE DATABASE ====================
            document.getElementById('saveOrganisasiBtn').addEventListener('click', async () => {
                if (!cvSlug) {
                    alert('CV Slug tidak ditemukan. Tidak dapat menyimpan organisasi.');
                    return;
                }

                const organisasiData = [];
                document.querySelectorAll('.organisasi-item').forEach((item, index) => {
                    const data = {
                        organization_name: item.querySelector('[name*="organization_name"]')
                            .value,
                        position: item.querySelector('[name*="position"]').value,
                        organization_description: item.querySelector(
                            '[name*="organization_description"]').value,
                        location: item.querySelector('[name*="location"]').value,
                        start_month: item.querySelector('[name*="start_month"]').value,
                        start_year: item.querySelector('[name*="start_year"]').value,
                        end_month: item.querySelector('[name*="end_month"]').value,
                        end_year: item.querySelector('[name*="end_year"]').value,
                        is_active: item.querySelector('[name*="is_active"]').checked ? 1 :
                            0,
                        job_description: item.querySelector('[name*="job_description"]')
                            .value
                    };
                    organisasiData.push(data);
                });

                try {
                    const response = await fetch(`/cv/${cvSlug}/organizations/store`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            organizations: organisasiData
                        })
                    });

                    const result = await response.json();

                    if (response.ok) {
                        alert(result.message);
                        if (result.redirect_url) {
                            window.location.href = result.redirect_url;
                        }
                    } else {
                        let errorMessage = result.message || 'Gagal menyimpan data organisasi';
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

            // ==================== LOAD DATA DARI DATABASE ====================
            if (cvSlug) {
                fetch(`/cv/${cvSlug}/organizations/load`)
                    .then(response => response.json())
                    .then(data => {
                        const container = document.querySelector('#organisasi-form-container');
                        container.innerHTML = '';

                        if (data.organizations && data.organizations.length > 0) {
                            data.organizations.forEach((o, index) => {
                                const counter = index + 1;
                                const newItem = document.createElement('div');
                                newItem.innerHTML = organisasiTemplate(counter);
                                const item = newItem.firstElementChild;

                                // Mapping data
                                item.querySelector('[name*="organization_name"]').value = o
                                    .organization_name || '';
                                item.querySelector('[name*="position"]').value = o.position || '';
                                item.querySelector('[name*="organization_description"]').value = o
                                    .organization_description || '';
                                item.querySelector('[name*="location"]').value = o.location ||
                                    '';
                                item.querySelector('[name*="start_month"]').value = o.start_month || '';
                                item.querySelector('[name*="start_year"]').value = o.start_year || '';
                                item.querySelector('[name*="end_month"]').value = o.end_month || '';
                                item.querySelector('[name*="end_year"]').value = o.end_year || '';
                                item.querySelector('[name*="is_active"]').checked = o.is_active;
                                item.querySelector('[name*="job_description"]').value = o
                                    .job_description || '';

                                container.appendChild(item);
                            });
                            organisasiCounter = data.organizations.length;
                            updateDeleteButtons();
                        } else {
                            // Jika tidak ada data dari database, inisialisasi satu form kosong
                            const initialItem = document.createElement('div');
                            initialItem.innerHTML = organisasiTemplate(1);
                            container.appendChild(initialItem.firstElementChild);
                            organisasiCounter = 1; // Reset counter
                        }
                    })
                    .catch(error => {
                        console.error('Error loading work experiences:', error);
                        // Jika terjadi error saat memuat, pastikan setidaknya ada satu form kosong
                        const container = document.querySelector('#organisasi-form-container');
                        if (!container.querySelector('.organisasi-item')) {
                            const initialItem = document.createElement('div');
                            initialItem.innerHTML = organisasiTemplate(1);
                            container.appendChild(initialItem.firstElementChild);
                            organisasiCounter = 1;
                        }
                        updateDeleteButtons();
                    });
            }

            // Load Awal
            fetch(`/load-session-data/${cvSlug}`)
                .then(response => response.json())
                .then(data => {
                    if (data.pengalaman_organisasi?.length > 0) {
                        document.querySelector('#organisasi-form-container').innerHTML = '';
                        data.pengalaman_organisasi.forEach((p, index) => {
                            const counter = index + 1;
                            const newItem = document.createElement('div');
                            newItem.innerHTML = organisasiTemplate(counter);
                            const item = newItem.firstElementChild;

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

                            document.getElementById('organisasi-form-container').appendChild(item);
                        });
                        organisasiCounter = data.pengalaman_organisasi.length;
                        updateDeleteButtons();
                        updatePreview();
                    }
                });
        });
    </script>
</x-cv-generator-layout>
