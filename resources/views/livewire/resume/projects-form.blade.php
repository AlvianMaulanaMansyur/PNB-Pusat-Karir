{{-- resources/views/livewire/resume/projects-form.blade.php --}}

<div>
    <div id="projects-section" class="panel-container">
        <div class="panel-header flex justify-between items-center">
            <h3 class="flex items-center text-xl font-semibold">
                <img src="{{ asset('images/resume-icons/projects.png') }}" alt="Icon"
                    class="icon-resume icon-resume--large">
                Project
            </h3>
        </div>

        <div class="panel-body">
            <div id="existing-projects" class="panel-item">
                @if (count($projects) > 0)
                    @foreach ($projects as $project)
                        <div class="project-item border rounded-lg p-3 mb-3 relative bg-white shadow-sm hover:bg-gray-50 cursor-pointer transition duration-200"
                        wire:key="{{ $project['id'] }}" x-data="{ open: false }" @click="open = !open">

                            <div class="flex justify-between items-center">

                                <div class="overflow-hidden max-w-[85%]">
                                    <h4 class="text-md font-medium truncate">
                                        {{ $project['project_name'] ?? '' }}
                                    </h4>
                                    <p class="text-sm text-gray-600 truncate">
                                        {{ $project['role'] ?? '' }}
                                    </p>
                                </div>

                                <div class="flex-shrink-0">
                                    <button @click.stop="open = !open"
                                        class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 rounded-lg"
                                        type="button">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 16 3">
                                            <path
                                                d="M2 0a1.5 1.5 0 1 1 0 3A1.5 1.5 0 0 1 2 0Zm6.041 0a1.5 1.5 0 1 1 0 3A1.5 1.5 0 0 1 8.041 0ZM14 0a1.5 1.5 0 1 1 0 3A1.5 1.5 0 0 1 14 0Z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Dropdown Menu --}}
                            <div x-cloak x-show="open" @click.outside="open = false" x-transition
                                class="z-20 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 absolute right-0 mt-2">
                                <ul class="py-2 text-sm text-gray-700">
                                    <li>
                                        <button type="button"
                                            class="w-full flex items-center px-4 py-2 hover:bg-gray-100"
                                            wire:click="openModal('{{ $project['id'] }}')">
                                            <i class="fas fa-edit mr-3 text-gray-500"></i> Edit
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button"
                                            class="w-full flex items-center px-4 py-2 hover:bg-gray-100"
                                            wire:click="duplicateProject('{{ $project['id'] }}')">
                                            <i class="far fa-copy mr-3 text-gray-500"></i> Copy
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button"
                                            class="w-full flex items-center px-4 py-2 text-red-600 hover:bg-red-50"
                                            wire:click="removeProject('{{ $project['id'] }}')">
                                            <i class="fas fa-trash-alt mr-3"></i> Remove
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p id="no-project-message" class="text-gray-500 text-center py-4">No projects added yet.</p>
                @endif
            </div>

            <div class="text-center mt-6">
                <button class="add-item-btn bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                    wire:click="openModal()">Add a new project</button>
            </div>
        </div>
    </div>

    {{-- Modal Form Project --}}
    <div x-data="{ show: @entangle('showModal').live }" x-show="show" x-transition x-cloak
        class="fixed inset-0 z-50 bg-gray-900 bg-opacity-50 flex items-center justify-center overflow-y-auto px-4">

        <div @click.away="show = false"
            class="relative bg-white rounded-lg shadow-lg w-full max-w-2xl max-h-[90vh] overflow-hidden">

            {{-- Header --}}
            <div class="flex justify-between items-center px-6 py-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    @if ($editingProjectId)
                        Edit Project
                    @else
                        Add New Project
                    @endif
                </h3>
                <button @click="show = false" type="button"
                    class="text-gray-500 hover:text-gray-900 bg-transparent rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="px-6 py-4 overflow-y-auto max-h-[70vh]">
                <form wire:submit="saveProject">
                    <div class="mb-4">
                        <label for="project_name" class="block text-sm font-medium text-gray-700">Project Name</label>
                        <input type="text" id="project_name" wire:model="form.project_name"
                            class="form-input w-full p-2 border rounded @error('form.project_name') border-red-500 @enderror" />
                        @error('form.project_name')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="role" class="block text-sm font-medium text-gray-700">Your Role (Optional)</label>
                        <input type="text" id="role" wire:model="form.role"
                            class="form-input w-full p-2 border rounded @error('form.role') border-red-500 @enderror" />
                        @error('form.role')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" id="start_date" wire:model="form.start_date"
                                class="form-input w-full p-2 border rounded @error('form.start_date') border-red-500 @enderror" />
                            @error('form.start_date')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" id="end_date" wire:model="form.end_date"
                                class="form-input w-full p-2 border rounded @error('form.end_date') border-red-500 @enderror"
                                {{ $form['is_current'] ? 'disabled' : '' }} /> {{-- Nonaktifkan jika is_current --}}
                            @error('form.end_date')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <input type="checkbox" id="is_current" wire:model.live="form.is_current" class="mr-2" />
                        <label for="is_current" class="text-sm font-medium text-gray-700">This is an ongoing project</label>
                    </div>

                    <div class="mb-4">
                        <label for="technologies_used" class="block text-sm font-medium text-gray-700">Technologies Used (e.g., PHP, Laravel, Vue.js)</label>
                        <input type="text" id="technologies_used" wire:model="form.technologies_used"
                            class="form-input w-full p-2 border rounded @error('form.technologies_used') border-red-500 @enderror" />
                        @error('form.technologies_used')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="project_url" class="block text-sm font-medium text-gray-700">Project URL (e.g., Live Demo, Website)</label>
                        <input type="url" id="project_url" wire:model="form.project_url" placeholder="https://www.yourproject.com"
                            class="form-input w-full p-2 border rounded @error('form.project_url') border-red-500 @enderror" />
                        @error('form.project_url')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="github_url" class="block text-sm font-medium text-gray-700">GitHub Repository URL</label>
                        <input type="url" id="github_url" wire:model="form.github_url" placeholder="https://github.com/yourusername/yourproject"
                            class="form-input w-full p-2 border rounded @error('form.github_url') border-red-500 @enderror" />
                        @error('form.github_url')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description (Use bullet points for clarity)</label>
                        <textarea id="description" wire:model="form.description" rows="5"
                            class="form-textarea w-full p-2 border rounded @error('form.description') border-red-500 @enderror"></textarea>
                        @error('form.description')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
            </div>

            {{-- Footer --}}
            <div class="flex justify-end items-center px-6 py-2 border-t rounded-b space-x-2">
                <button type="button" wire:click="closeModal"
                    class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">Cancel</button>
                <button type="submit" wire:click="saveProject"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="saveProject">
                        @if ($editingProjectId)
                            Update Project
                        @else
                            Add Project
                        @endif
                    </span>
                    <span wire:loading wire:target="saveProject">Saving...</span>
                </button>
            </div>
        </div>
    </div>

</div>