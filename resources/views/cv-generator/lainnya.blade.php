<x-cv-generator-layout :activeStep="$activeStep" :currentCv="$currentCv">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-bold">Kemampuan, Penghargaan & Pengalaman Lain</h2>
        <p class="text-sm text-gray-600 mb-6">Tambahkan kemampuan, penghargaan, atau pengalaman lain yang relevan
        </p>
        <div class="mb-6" id="pengalaman-lain-container">
            <input type="hidden" id="current_cv_slug" value="{{ $currentCv->slug ?? '' }}">
            <div class="pengalaman-item bg-white p-6 rounded-lg border mb-5">

                {{-- Kategori --}}
                <div class="mb-4">
                    <x-input-label for="category_1" :value="__('Kategori')" />
                    <select id="category_1" name="pengalaman_lain[1][category]"
                        class="block mt-1 w-full text-sm 2xl:text-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        required>
                        <option value="">Pilih Kategori</option>
                        <option value="Kemampuan">Kemampuan</option>
                        <option value="Penghargaan">Penghargaan</option>
                        <option value="Proyek">Proyek</option>
                        <option value="Aktivitas">Aktivitas</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                {{-- Tahun --}}
                <div class="mb-4">
                    <x-input-label for="year_1" :value="__('Tahun')" />
                    
                    <x-dropdown.tahun-dropdown id="year_1" :name="__('pengalaman_lain[1][year]')" class="mt-1 w-full text-sm 2xl:text-lg" />
                </div>

                {{-- Deskripsi --}}
                <div class="mb-4">
                    <x-input-label for="description_1" :value="__('Deskripsi')" />
                    <textarea id="description_1" name="pengalaman_lain[1][description]" rows="3"
                        class="block mt-1 w-full text-sm 2xl:text-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        placeholder="Deskripsi kemampuan, penghargaan, atau pengalaman" required></textarea>
                </div>

                {{-- Upload Dokumen --}}
                <div class="mb-4">
                    <x-input-label for="document_path_1" :value="__('URL Dokumen Pendukung (Opsional)')" />
                    <input type="url" id="document_path_1" name="pengalaman_lain[1][document_path]"
                        class="block mt-1 w-full text-sm 2xl:text-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        placeholder="https://example.com/dokumen.pdf">
                    <p class="text-xs text-gray-500 mt-1">Masukkan URL dokumen yang valid</p>
                </div>

            </div>

            <button type="button" class="mt-2 text-red-500 text-sm remove-pengalaman hidden">
                Hapus Pengalaman
            </button>
        </div>

        <button type="button" id="tambah-pengalaman"
            class="w-full border border-dashed border-indigo-500 text-indigo-600 px-4 py-2 rounded-md text-sm hover:bg-indigo-50">
            + Tambah Pengalaman
        </button>

        <div class="flex justify-end">
            {{-- Kembali Button --}}
            <div class="mt-8 flex justify-end">
                <a href="{{ route('cv.organizations', ['slug' => $currentCv->slug]) }}"
                    class="inline-flex items-center px-6 py-3 bg-white border border-indigo-600 rounded-md font-semibold text-base text-indigo-600 uppercase tracking-widest hover:bg-indigo-50 focus:bg-indigo-50 active:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-4">
                    Kembali
                </a>
            </div>

            {{-- Save & Continue Button --}}
            <div class="mt-8 flex justify-end">
                <button type="button" id="savePengalamanLainBtn"
                    class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Simpan & Lanjutkan
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let pengalamanCounter = 1;
            const maxPengalaman = 10;
            let debounceTimer;
            const cvSlug = document.getElementById('current_cv_slug').value;

            const pengalamanTemplate = (counter) => `
                <div class="pengalaman-item bg-white p-6 rounded-lg border mb-5">

                        {{-- Kategori --}}
                        <div class="mb-4">
                            <x-input-label for="category_${counter}" :value="__('Kategori')" />
                            <select id="category_${counter}" name="pengalaman_lain[${counter}][category]"
                                class="block mt-1 w-full text-sm 2xl:text-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Kemampuan">Kemampuan</option>
                                <option value="Penghargaan">Penghargaan</option>
                                <option value="Proyek">Proyek</option>
                                <option value="Aktivitas">Aktivitas</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        {{-- Tahun --}}
                        <div class="mb-4">
                            <x-input-label for="year_${counter}" :value="__('Tahun')" />
                            <x-dropdown.tahun-dropdown id="year_${counter}" :name="__('pengalaman_lain[${counter}][year]')" class="mt-1 w-full text-sm 2xl:text-lg" />
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <x-input-label for="description_${counter}" :value="__('Deskripsi')" />
                            <textarea id="description_${counter}" name="pengalaman_lain[${counter}][description]" rows="3"
                                class="block mt-1 w-full text-sm 2xl:text-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Deskripsi kemampuan, penghargaan, atau pengalaman" required></textarea>
                        </div>

                        {{-- Upload Dokumen --}}
                        <div class="mb-4">
                            <x-input-label for="document_path_${counter}" :value="__('URL Dokumen Pendukung (Opsional)')" />
                            <input type="url" id="document_path_${counter}" name="pengalaman_lain[${counter}][document_path]"
                                class="block mt-1 w-full text-sm 2xl:text-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="https://example.com/dokumen.pdf">
                            <p class="text-xs text-gray-500 mt-1">Masukkan URL dokumen yang valid</p>
                        </div>

                        <button type="button"
                            class="mt-2 text-red-500 text-sm remove-pengalaman">
                            Hapus Pengalaman
                        </button>
                </div>
            `;

            // Tambah Pengalaman
            document.getElementById('tambah-pengalaman').addEventListener('click', () => {
                if (pengalamanCounter >= maxPengalaman) {
                    alert(`Maksimal ${maxPengalaman} pengalaman`);
                    return;
                }

                pengalamanCounter++;
                const newItem = document.createElement('div');
                newItem.innerHTML = pengalamanTemplate(pengalamanCounter);
                document.getElementById('pengalaman-lain-container').appendChild(newItem.firstElementChild);

                updateDeleteButtons();
                savePengalamanToSession();
            });

            // Hapus Pengalaman
            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('remove-pengalaman')) {
                    if (document.querySelectorAll('.pengalaman-item').length > 1) {
                        e.target.closest('.pengalaman-item').remove();
                        pengalamanCounter--;
                        updateDeleteButtons();
                        savePengalamanToSession();
                    }
                }
            });

            // Upload Dokumen Button
            document.addEventListener('click', (e) => {
                if (e.target.closest('button') && e.target.closest('button').textContent.includes(
                        'Tambahkan Dokumen/Sertifikat')) {
                    const fileInput = e.target.closest('div').querySelector('input[type="file"]');
                    fileInput.click();
                }
            });

            // Update Tombol Hapus
            function updateDeleteButtons() {
                const items = document.querySelectorAll('.pengalaman-item');
                items.forEach((item, index) => {
                    const btn = item.querySelector('.remove-pengalaman');
                    btn.classList.toggle('hidden', items.length === 1);
                });
            }

            // Simpan ke Session
            function savePengalamanToSession() {
                // const cvSlug = document.getElementById('current_cv_slug').value;
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    const pengalamanData = [];

                    document.querySelectorAll('.pengalaman-item').forEach((item, index) => {
                        const data = {
                            category: item.querySelector('[name*="[category]"]').value,
                            year: item.querySelector('[name*="[year]"]').value,
                            description: item.querySelector('[name*="[description]"]').value,
                            document_path: item.querySelector('[name*="[document_path]"]')
                                .value,
                        };
                        pengalamanData.push(data);
                    });

                    fetch('{{ route('save.session.realtime') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            field: 'pengalaman_lain',
                            value: pengalamanData,
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
                        const container = document.getElementById('preview-pengalaman-lain');
                        if (data.pengalaman_lain?.length > 0) {
                            container.innerHTML = data.pengalaman_lain.map(p => `
                                <div class="mt-4 border-b pb-4">
                                    <h3 class="font-bold text-lg">${p.category} (${p.year})</h3>
                                    <p class="text-gray-700 mt-2">${p.description}</p>
                                    ${p.document_path ? `<p class="text-blue-600 text-sm mt-2">Dokumen: ${p.document_path}</p>` : ''}
                                </div>
                            `).join('');
                        } else {
                            container.innerHTML = '<p class="text-gray-500">Belum ada pengalaman tambahan</p>';
                        }
                    });
            }

            // Event Input
            document.addEventListener('input', (e) => {
                if (e.target.closest('.pengalaman-item')) {
                    savePengalamanToSession();
                }
            });

            document.getElementById('savePengalamanLainBtn').addEventListener('click', async () => {
                if (!cvSlug) {
                    alert('CV Slug tidak ditemukan. Tidak dapat menyimpan pengalaman.');
                    return;
                }

                const pengalamanData = [];
                document.querySelectorAll('.pengalaman-item').forEach((item, index) => {
                    const data = {
                        category: item.querySelector('[name*="[category]"]').value,
                        year: item.querySelector('[name*="[year]"]').value,
                        description: item.querySelector('[name*="[description]"]').value,
                        document_path: item.querySelector('[name*="[document_path]"]').value
                    };

                    pengalamanData.push(data);
                });

                try {

                    const response = await fetch(`/cv/${cvSlug}/other-experiences/store`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            other_experiences: pengalamanData
                        })
                    });

                    const result = await response.json();

                    if (response.ok) {
                        alert(result.message);
                        if (result.redirect_url) {
                            window.location.href = result.redirect_url;
                        }
                    } else {
                        let errorMessage = result.message || 'Gagal menyimpan data pengalaman';
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
                fetch(`/cv/${cvSlug}/other-experiences/load`)
                    .then(response => response.json())
                    .then(data => {
                        const container = document.querySelector('#pengalaman-lain-container');
                        container.innerHTML = '';

                        if (data.other_experiences && data.other_experiences.length > 0) {
                            data.other_experiences.forEach((exp, index) => {
                                const counter = index + 1;
                                const newItem = document.createElement('div');
                                newItem.innerHTML = pengalamanTemplate(counter);
                                const item = newItem.firstElementChild;

                                // Mapping data
                                item.querySelector('[name*="[category]"]').value = exp.category || '';
                                item.querySelector('[name*="[year]"]').value = exp.year || '';
                                item.querySelector('[name*="[description]"]').value = exp.description ||
                                    '';
                                item.querySelector('[name*="[document_path]"]').value = exp
                                    .document_path || '';

                                container.appendChild(item);
                            });
                            pengalamanCounter = data.other_experiences.length;
                            updateDeleteButtons();
                        } else {
                            // Jika tidak ada data dari database, inisialisasi satu form kosong
                            const initialItem = document.createElement('div');
                            initialItem.innerHTML = pengalamanTemplate(1);
                            container.appendChild(initialItem.firstElementChild);
                            pengalamanCounter = 1; // Reset counter
                        }
                    })
                    .catch(error => {
                        console.error('Error loading work experiences:', error);
                        // Jika terjadi error saat memuat, pastikan setidaknya ada satu form kosong
                        const container = document.querySelector('#pengalaman-lain-container');
                        if (!container.querySelector('.pengalaman-item')) {
                            const initialItem = document.createElement('div');
                            initialItem.innerHTML = pengalamanTemplate(1);
                            container.appendChild(initialItem.firstElementChild);
                            pengalamanCounter = 1;
                        }
                        updateDeleteButtons();
                    });
            }

            // Load Awal
            fetch(`/load-session-data/${cvSlug}`)
                .then(response => response.json())
                .then(data => {
                    if (data.pengalaman_lain?.length > 0) {
                        console.log(data.pengalaman_lain);
                        document.querySelector('#pengalaman-lain-container').innerHTML = '';
                        data.pengalaman_lain.forEach((p, index) => {
                            const counter = index + 1;
                            const newItem = document.createElement('div');
                            newItem.innerHTML = pengalamanTemplate(counter);
                            const item = newItem.firstElementChild;

                            // Set values
                            item.querySelector('[name*="[category]"]').value = p.category || '';
                            item.querySelector('[name*="[year]"]').value = p.year || '';
                            item.querySelector('[name*="[description]"]').value = p.description || '';
                            item.querySelector('[name*="[document_path]"]').value = p.document_path ||
                                '';

                            document.getElementById('pengalaman-lain-container').appendChild(item);
                        });
                        pengalamanCounter = data.pengalaman_lain.length;
                        updateDeleteButtons();
                        updatePreview();
                    }
                });
        });
    </script>
</x-cv-generator-layout>
