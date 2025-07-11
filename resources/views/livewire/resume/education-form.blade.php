<div>
    <div id="education-section" class="panel-container">
        <div class="panel-header flex justify-between items-center">
            <h3 class="flex items-center text-xl font-semibold">
                <img src="{{ asset('images/resume-icons/graduation.png') }}" alt="Icon"
                    class="icon-resume icon-resume--large">
                Education
            </h3>
        </div>

        <div class="panel-body">
            <div id="existing-educations" class="panel-item">
                @forelse ($educations as $education)
                    <div class="education-item border rounded-lg p-3 mb-3 relative bg-white shadow-sm hover:bg-gray-50 cursor-pointer transition duration-200"
                    wire:key="{{ $education['id'] }}" x-data="{ open: false }" @click="open = !open">
                        <div class="flex justify-between items-center">
                            <div class="overflow-hidden max-w-[85%]">
                                <h4 class="text-md font-medium truncate">
                                    {{ $education['institution'] ?? '' }}
                                </h4>
                                <p class="text-sm text-gray-600 truncate">
                                    {{ $education['dicipline'] ?? '' }}
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <button @click.stop="open = !open"
                                        class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 rounded-lg"
                                        type="button">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 16 3">
                                        <path d="M2 0a1.5 1.5 0 1 1 0 3A1.5 1.5 0 0 1 2 0Zm6.041 0a1.5 1.5 0 1 1 0 3A1.5 1.5 0 0 1 8.041 0ZM14 0a1.5 1.5 0 1 1 0 3A1.5 1.5 0 0 1 14 0Z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div x-cloak x-show="open" @click.outside="open = false" x-transition
                            class="z-20 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 absolute right-0 mt-2">
                            <ul class="py-2 text-sm text-gray-700">
                                <li>
                                    <button type="button"
                                        class="w-full flex items-center px-4 py-2 hover:bg-gray-100"
                                        wire:click="openModal('{{ $education['id'] }}')">
                                        <i class="fas fa-edit mr-3 text-gray-500"></i> Edit
                                    </button>
                                </li>
                                <li>
                                    <button type="button"
                                        class="w-full flex items-center px-4 py-2 hover:bg-gray-100"
                                        wire:click="duplicateEducation('{{ $education['id'] }}')">
                                        <i class="far fa-copy mr-3 text-gray-500"></i> Copy
                                    </button>
                                </li>
                                <li>
                                    <button type="button"
                                        class="w-full flex items-center px-4 py-2 text-red-600 hover:bg-red-50"
                                        wire:click="removeEducation('{{ $education['id'] }}')">
                                        <i class="fas fa-trash-alt mr-3"></i> Remove
                                    </button>
                                </li>
                            </ul>
                        </div>

                       
                    </div>
                @empty
                    <p id="no-education-message" class="text-gray-500 text-center py-4">No education entries added yet.</p>
                @endforelse
            </div>

            <div class="text-center mt-6">
                <button class="add-item-btn bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                    wire:click="openModal()">Add a new education</button>
            </div>
        </div>
    </div>

    <div x-data="{ show: @entangle('showModal').live }" x-show="show" x-transition x-cloak
        class="fixed inset-0 z-50 bg-gray-900 bg-opacity-50 flex items-center justify-center overflow-y-auto px-4">
        <div @click.away="show = false"
            class="relative bg-white rounded-lg shadow-lg w-full max-w-2xl max-h-[90vh] overflow-hidden">

            <div class="flex justify-between items-center px-6 py-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    {{ $editingEducationId ? 'Edit Education' : 'Add New Education' }}
                </h3>
                <button @click="show = false" type="button"
                    class="text-gray-500 hover:text-gray-900 bg-transparent rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <div class="px-6 py-4 overflow-y-auto max-h-[70vh]">
                <form wire:submit.prevent="saveEducation">
                    <div class="mb-4">
                        <label for="institution" class="block text-sm font-medium text-gray-700">Institution</label>
                        <input type="text" id="institution" wire:model="form.institution"
                            class="form-input w-full p-2 border rounded @error('form.institution') border-red-500 @enderror" />
                        @error('form.institution')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="degrees" class="block text-sm font-medium text-gray-700">Degree</label>
                        <input type="text" id="degrees" wire:model="form.degrees"
                            class="form-input w-full p-2 border rounded @error('form.degrees') border-red-500 @enderror" />
                        @error('form.degrees')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="dicipline" class="block text-sm font-medium text-gray-700">Discipline / Field</label>
                        <input type="text" id="dicipline" wire:model="form.dicipline"
                            class="form-input w-full p-2 border rounded @error('form.dicipline') border-red-500 @enderror" />
                        @error('form.dicipline')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="sertifications" class="block text-sm font-medium text-gray-700">Certifications</label>
                        <input type="text" id="sertifications" wire:model="form.sertifications"
                            class="form-input w-full p-2 border rounded @error('form.sertifications') border-red-500 @enderror" />
                        @error('form.sertifications')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="end_date" class="block text-sm font-medium text-gray-700">Graduation Date</label>
                        <input type="date" id="end_date" wire:model="form.end_date"
                            class="form-input w-full p-2 border rounded @error('form.end_date') border-red-500 @enderror" />
                        @error('form.end_date')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description / Achievements</label>
                        <textarea id="description" wire:model="form.description" rows="5"
                            class="form-textarea w-full p-2 border rounded @error('form.description') border-red-500 @enderror"></textarea>
                        @error('form.description')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>
                </form>
            </div>

            <div class="flex justify-end items-center px-6 py-2 border-t rounded-b space-x-2">
                <button type="button" wire:click="closeModal"
                    class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">Cancel</button>
                <button type="submit" wire:click="saveEducation"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="saveEducation">
                        {{ $editingEducationId ? 'Update Education' : 'Add Education' }}
                    </span>
                    <span wire:loading wire:target="saveEducation">Saving...</span>
                </button>
            </div>
        </div>
    </div>
</div>
