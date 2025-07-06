<section>
    <div x-data="skillSection()" x-init="loadExistingSkills()" class="relative">
        <p class="text-blue-700 text-3xl font-semibold py-2">Keahlian</p>
        <p class="text-lg text-gray-600 ">Tambahkan keahlian Anda sebanyak mungkin untuk memudahkan rekruter
            menemukan Anda!</p>

        <!-- Skill yang Sudah Disimpan -->
        <div class="flex flex-wrap gap-2 my-4">
            <template x-for="(skill, index) in savedSkills" :key="skill.id">
                <div class="bg-blue-100 text-blue-800 px-3 p-2 rounded-2xl text-lg flex items-center gap-2">
                    <span x-text="skill.name"></span>
                </div>
            </template>
        </div>

        <!-- Tombol Tambah -->
        <button @click="sidebarOpen = true"
            class="px-4 mt-3 py-2 border-2 border-primaryColor text-primaryColor font-semibold rounded-lg hover:bg-slate-100">
            Tambah Keahlian
        </button>

        <!-- Sidebar -->
        <div x-show="sidebarOpen" x-transition class="fixed inset-0 z-50 bg-black/30 flex justify-end"
            style="display: none;">
            <div class="bg-white h-full w-full md:w-1/2 max-w-[50%] shadow-lg px-10 py-20 overflow-y-auto relative ">
                <!-- Tombol Close -->
                <button @click="confirmCancelSidebar"
                    class="absolute top-4 right-4 text-gray-500 hover:text-red-500 text-xl">
                    <i class="fas fa-times"></i>
                </button>

                <h3 class="text-4xl font-semibold mb-4">Tambah Keahlian</h3>
                <p class="text-lg text-gray-700 mb-5">Bantu rekruter menemukan Anda dengan menampilkan semua keahlian
                    Anda.
                </p>

                <!-- Input dan Tombol Tambah -->
                <div class="mb-6">
                    <!-- Input + Button -->
                    <div class="flex gap-2 items-center">
                        <x-text-input type="text" x-model="newSkill" @input="validateLength"
                            @keydown.down="arrowDown" @keydown.up="arrowUp" placeholder="Masukan Keahlian Anda"
                            class="flex-1 px-3 py-2 border rounded placeholder:opacity-50" autocomplete="off" />

                        <x-primary-button @click="addSkill" class="py-3" type="button">
                            Tambah
                        </x-primary-button>
                    </div>

                    <!-- Error message -->
                    <p x-show="inputError" x-text="inputError" class="text-sm text-red-600 mt-1"></p>

                    <!-- Note -->
                    <div class="text-md text-gray-500 py-2">
                        Tekan <span class="font-semibold">Tambah</span> untuk menambahkan keahlian
                    </div>
                </div>



                <!-- Hint -->
                <ul x-show="filteredSkills.length > 0"
                    class="border border-gray-300 rounded mt-1 bg-white shadow-md max-h-48 overflow-y-auto">
                    <template x-for="(skill, index) in filteredSkills" :key="skill.id">
                        <li :class="{ 'bg-blue-100': index === selectedIndex }"
                            class="px-4 py-2 cursor-pointer hover:bg-blue-200" @click="selectSkillFromList(skill)"
                            x-text="skill.name"></li>
                    </template>
                </ul>

                <!-- Daftar Skill Terpilih -->
                <p class="text-xl font-bold text-gray-600">
                    Keahlian yang ditambahkan (
                    <span x-text="totalSkills + ' / 25'" class="font-semibold "></span>)
                </p>
                <div class="flex flex-wrap gap-2 mt-4">
                    <!-- Skill lokal yang baru ditambahkan -->
                    <template x-for="(skill, index) in selectedSkills" :key="'local-' + index">
                        <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-2xl text-lg flex items-center gap-4">
                            <span x-text="skill.name"></span>
                            <button @click="selectedSkills.splice(index, 1)" type="button"
                                class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-times text-lg"></i>
                            </button>
                        </div>
                    </template>

                    <!-- Skill yang sudah tersimpan di DB -->
                    <template x-for="(skill, index) in savedSkills" :key="'saved-' + skill.id">
                        <div class="bg-blue-100 text-blue-900 px-3 py-2 rounded-2xl text-lg flex items-center gap-4">
                            <span x-text="skill.name"></span>
                            <button @click="deleteSkill(skill.id, index)" type="button"
                                class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-times text-lg"></i>
                            </button>
                        </div>
                    </template>
                </div>
                <div>
                    <p class="text-gray-700 text-lg mt-10">Jaga diri Anda. Jangan sertakan informasi pribadi sensitif
                        seperti
                        dokumen identitas, kesehatan,
                        ras, agama, atau data keuangan.</p>
                </div>
                <!-- Tombol Simpan -->
                <div class="mt-5">
                    <x-primary-button @click="saveSkills" class="py-3 text-lg">
                        Simpan
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function skillSection() {
        return {
            sidebarOpen: false,
            newSkill: '',
            filteredSkills: [],
            selectedIndex: 0,
            selectedSkills: [],
            savedSkills: [],

            get totalSkills() {
                return this.savedSkills.length + this.selectedSkills.length;
            },

            async loadExistingSkills() {
                try {
                    const res = await fetch('{{ route('skill.fetch') }}');
                    const data = await res.json();
                    this.savedSkills = data.skills;
                } catch (e) {
                    console.error('Gagal memuat keahlian:', e);
                }
            },

            async searchSkills() {
                if (this.newSkill.length < 1) {
                    this.filteredSkills = [];
                    return;
                }
                const res = await fetch(`{{ route('skill.search') }}?keyword=${this.newSkill}`);
                const data = await res.json();
                this.filteredSkills = data.skills;
                this.selectedIndex = 0;
            },

            arrowDown() {
                if (this.selectedIndex < this.filteredSkills.length - 1) this.selectedIndex++;
            },

            arrowUp() {
                if (this.selectedIndex > 0) this.selectedIndex--;
            },

            addSkill() {
                const trimmed = this.newSkill.trim();

                if (!trimmed) return;

                if (trimmed.length > 100) {
                    this.inputError = 'Maksimal 100 karakter.';
                    return;
                }

                if (this.selectedSkills.some(s => s.name.toLowerCase() === trimmed.toLowerCase())) {
                    Swal.fire('Info', 'Keahlian sudah ada di daftar.', 'info');
                    this.newSkill = '';
                    this.filteredSkills = [];
                    return;
                }

                const matchedSkill = this.filteredSkills.find(s => s.name.toLowerCase() === trimmed.toLowerCase());

                if (matchedSkill) {
                    this.selectedSkills.push(matchedSkill);
                } else {
                    this.selectedSkills.push({
                        id: null,
                        name: trimmed
                    });
                }

                this.newSkill = '';
                this.filteredSkills = [];
                this.inputError = ''; // reset error saat berhasil
            },

            selectSkillFromList(skill) {
                if (!this.selectedSkills.some(s => s.name === skill.name) &&
                    !this.savedSkills.some(s => s.name === skill.name)) {
                    this.selectedSkills.push(skill);
                }
                this.newSkill = '';
                this.filteredSkills = [];
            },

            async saveSkills() {
                if (this.selectedSkills.length === 0) {
                    Swal.fire('Info', 'Tidak ada keahlian untuk disimpan.', 'info');
                    return;
                }

                try {
                    const res = await fetch('{{ route('skill.add') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            skills: this.selectedSkills
                        })
                    });

                    const data = await res.json();

                    if (data.success) {
                        // Tambahkan skill yang berhasil disimpan ke savedSkills
                        this.savedSkills = [...this.savedSkills, ...data.savedSkills];
                        this.selectedSkills = [];
                        this.sidebarOpen = false;
                        Swal.fire('Berhasil', 'Keahlian ditambahkan.', 'success');
                    } else {
                        Swal.fire('Gagal', 'Gagal menyimpan keahlian.', 'error');
                    }
                } catch (e) {
                    console.error(e);
                    Swal.fire('Error', 'Terjadi kesalahan.', 'error');
                }
            },

            async deleteSkill(skillId, index) {
                const confirm = await Swal.fire({
                    title: 'Hapus keahlian?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#ffffff',
                    customClass: {
                        cancelButton: 'text-gray-900 hover:text-gray-700',
                    }
                });


                if (confirm.isConfirmed) {
                    try {
                        const res = await fetch('/my-profile/skills/delete-skill/' + skillId, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                        });

                        const data = await res.json();

                        if (data.success) {
                            this.savedSkills.splice(index, 1);
                            Swal.fire('Berhasil', 'Keahlian dihapus.', 'success');
                        } else {
                            Swal.fire('Gagal', 'Gagal menghapus keahlian.', 'error');
                        }
                    } catch (e) {
                        console.error(e);
                        Swal.fire('Error', 'Terjadi kesalahan.', 'error');
                    }
                }
            },

            async confirmCancelSidebar() {
                const confirm = await Swal.fire({
                    title: 'Batalkan perubahan?',
                    text: 'Keahlian yang belum disimpan akan hilang.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, batalkan',
                    cancelButtonText: 'Lanjutkan',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#ffffff',
                    customClass: {
                        cancelButton: 'text-gray-900 hover:text-gray-700',
                    }
                });

                if (confirm.isConfirmed) {
                    this.newSkill = '';
                    this.selectedSkills = [];
                    this.sidebarOpen = false;
                }
            },
            validateLength() {
                if (this.newSkill.length > 100) {
                    this.inputError = 'Maksimal 100 karakter.';
                } else {
                    this.inputError = '';
                }
            },

        };
    }
</script>
