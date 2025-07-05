<section>
    <div x-data="skillSection()" x-init="loadExistingSkills()" class="relative">
        <!-- Tombol Tambah -->
        <button @click="sidebarOpen = true" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Tambah Keahlian
        </button>

        <!-- Skill Tampil di Luar Sidebar -->
        <div class="flex flex-wrap gap-2 mt-4">
            <template x-for="(skill, index) in savedSkills" :key="skill.id">
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm flex items-center gap-2">
                    <span x-text="skill.skill_name"></span>
                </span>
            </template>
        </div>

        <!-- Sidebar -->
        <div x-show="sidebarOpen" x-transition class="fixed inset-0 z-50 bg-black/30 flex justify-end">
            <div class="bg-white h-full w-full md:w-1/2 max-w-[50%] shadow-lg p-6 overflow-y-auto relative">
                <h3 class="text-xl font-semibold mb-4">Tambah Keahlian</h3>

                <!-- Input -->
                <div class="flex gap-2 mb-4">
                    <input type="text" x-model="newSkill" placeholder="Contoh: Laravel"
                        class="flex-1 px-3 py-2 border rounded" />
                    <button @click="addSkill" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Tambah
                    </button>
                </div>

                <!-- List Skill -->
                <div class="flex flex-wrap gap-2">
                    <template x-for="(skill, index) in skills" :key="'local-'+index">
                        <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm flex items-center gap-2">
                            <span x-text="skill"></span>
                            <button @click="skills.splice(index, 1)" type="button" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </div>
                    </template>

                    <template x-for="(skill, index) in savedSkills" :key="'saved-'+skill.id">
                        <div class="bg-blue-200 text-blue-900 px-3 py-1 rounded-full text-sm flex items-center gap-2">
                            <span x-text="skill.skill_name"></span>
                            <button @click="deleteSkill(skill.id, index)" type="button" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </div>
                    </template>
                </div>

                <!-- Simpan -->
                <div class="mt-6 flex justify-between">
                    <button @click="saveSkills" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Simpan
                    </button>
                    <button @click="sidebarOpen = false" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
                        Tutup
                    </button>
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
            skills: [],
            savedSkills: [],

            async loadExistingSkills() {
                try {
                    const res = await fetch('{{ route('skill.fetch') }}');
                    const data = await res.json();
                    this.savedSkills = data.skills;
                } catch (e) {
                    console.error('Gagal memuat keahlian:', e);
                }
            },

            addSkill() {
                const trimmed = this.newSkill.trim();
                if (trimmed && !this.skills.includes(trimmed)) {
                    this.skills.push(trimmed);
                    this.newSkill = '';
                }
            },

            async saveSkills() {
                if (this.skills.length === 0) return;

                try {
                    const res = await fetch('{{ route('skill.add') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({ skills: this.skills })
                    });

                    const data = await res.json();
                    if (data.success) {
                        this.savedSkills = [...this.savedSkills, ...data.savedSkills];
                        this.skills = [];
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

            async deleteSkill(id, index) {
                const confirm = await Swal.fire({
                    title: 'Hapus keahlian?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                });

                if (confirm.isConfirmed) {
                    try {
                        const res = await fetch('/my-profile/delete-skill/' + id, {
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
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
            }
        };
    }
</script>
