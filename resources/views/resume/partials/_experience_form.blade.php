<div id="experience-section" x-data="experienceModal()">
    <div class="panel-header flex justify-between items-center">
        <h3>Experience</h3>
        <button class="menu-icon">☰</button>
    </div>

    <div class="panel-body">
        <div id="existing-experiences">
            @forelse($resume->resume_data['experiences'] ?? [] as $experience)
                <div class="experience-item border rounded p-3 mb-3" data-id="{{ $experience['id'] }}">
                    <h4 class="text-lg font-bold">{{ $experience['title'] ?? 'Untitled' }}</h4>
                    <p class="text-sm text-gray-600">
                        {{ $experience['company'] ?? 'N/A' }}
                        ({{ $experience['start_date'] ?? '' }} - {{ $experience['end_date'] ?? 'Present' }})
                    </p>
                    <div class="mt-2 space-x-2">
                        <button class="btn btn-warning btn-sm"
                            @click="$data.editExperience('{{ $experience['id'] }}')">Edit</button>
                        <button class="btn btn-danger btn-sm"
                            @click="$data.removeExperience('{{ $experience['id'] }}')">Remove</button>
                    </div>
                </div>
            @empty
                <p id="no-experience-message">No experience added yet.</p>
            @endforelse
        </div>

        <button class="add-item-btn mt-4" @click="openModal">Add a new item</button>
    </div>

    <!-- Modal -->
    <div x-show="show" x-transition
        class="fixed inset-0 z-50 bg-gray-600 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-lg mx-auto" @click.away="closeModal">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Add New Experience</h2>
                <button @click="closeModal" class="text-gray-500 hover:text-gray-800">&times;</button>
            </div>
            <form @submit.prevent="submitForm">
                <template x-for="field in ['title', 'company', 'start_date', 'end_date']" :key="field">
                    <div class="mb-4">
                        <label :for="field" class="block text-sm font-medium text-gray-700"
                            x-text="field.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())"></label>
                        <input :type="field.includes('date') ? 'date' : 'text'" :name="field"
                            x-model="form[field]" class="form-input w-full" required />
                    </div>
                </template>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea x-model="form.description" name="description" rows="4" class="form-textarea w-full"></textarea>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" @click="closeModal"
                        class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                        <span x-text="form.id ? 'Update Experience' : 'Add Experience'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('experienceModal', () => ({
            show: false,
            isLoading: false,
            errors: {},
            form: {
                id: null,
                title: '',
                company: '',
                start_date: '',
                end_date: '',
                description: ''
            },

            get isEdit() {
                return !!this.form.id;
            },

            get baseUrl() {
                return `{{ url('resumes/' . $resume->slug . '/experience') }}`;
            },

            get csrfToken() {
                return document.querySelector('meta[name="csrf-token"]').content;
            },

            defaultForm: {
                id: null,
                title: '',
                company: '',
                start_date: '',
                end_date: '',
                description: ''
            },

            init() {
                console.log('Experience modal initialized');
            },

            openModal(reset = true) {
                this.show = true;
                if (reset) this.resetForm();
                this.errors = {};
                document.body.style.overflow = 'hidden';
            },

            closeModal() {
                this.show = false;
                this.resetForm();
                this.errors = {};
                document.body.style.overflow = '';
            },

            resetForm() {
                this.form = {
                    ...this.defaultForm
                };
            },

            async fetchJson(url, options = {}) {
                const response = await fetch(url, options);
                const data = await response.json();
                if (!response.ok) {
                    const err = new Error(data.message || 'Request failed');
                    err.data = data;
                    throw err;
                }
                return data;
            },

            async submitForm() {
                this.isLoading = true;
                this.errors = {};
                const url = this.isEdit ? `${this.baseUrl}/${this.form.id}` : this.baseUrl;
                const method = this.isEdit ? 'PUT' : 'POST';

                try {
                    const data = await this.fetchJson(url, {
                        method,
                        headers: {
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(this.form)
                    });

                    alert(data.message || 'Experience saved!');

                    // Update Alpine store
                    if (this.isEdit) {
                        const index = Alpine.store('resume').experiences.findIndex(exp => exp
                            .id == data.experience.id);
                        if (index !== -1) {
                            Alpine.store('resume').experiences[index] = data.experience;
                        }
                    } else {
                        Alpine.store('resume').experiences.push(data.experience);
                    }

                    this.closeModal();

                } catch (err) {
                    if (err.data?.errors) {
                        this.errors = err.data.errors;
                    } else {
                        console.error(err);
                        alert('Error: ' + err.message);
                    }
                } finally {
                    this.isLoading = false;
                }
            },

            async editExperience(id) {
                try {
                    const data = await this.fetchJson(`${this.baseUrl}/${id}`, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });

                    this.openModal(false);
                    this.form = {
                        id: data.experience.id,
                        title: data.experience.title,
                        company: data.experience.company,
                        start_date: data.experience.start_date,
                        end_date: data.experience.end_date,
                        description: data.experience.description || ''
                    };
                } catch (err) {
                    console.error(err);
                    alert('Could not load experience: ' + err.message);
                }
            },

            async removeExperience(id) {
                if (!confirm('Are you sure you want to delete this experience?')) return;

                try {
                    const data = await this.fetchJson(`${this.baseUrl}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Accept': 'application/json'
                        }
                    });

                    alert(data.message || 'Experience deleted successfully!');
                    document.querySelector(`.experience-item[data-id="${id}"]`)?.remove();

                    if (document.querySelectorAll('.experience-item').length === 0) {
                        const container = document.getElementById('existing-experiences');
                        const p = document.createElement('p');
                        p.id = 'no-experience-message';
                        p.textContent = 'No experience added yet.';
                        container.appendChild(p);
                    }

                    location.reload();
                } catch (err) {
                    console.error(err);
                    alert('Error: ' + err.message);
                }
            }
        }));
    });
</script>
