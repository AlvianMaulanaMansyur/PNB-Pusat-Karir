{{-- resources/views/livewire/resume/education-form.blade.php --}}

<div>
    <div id="education-section" class="panel-container">
        <div class="panel-header flex justify-between items-center">
            <h3>Education</h3>
        </div>

        <div class="panel-body">
            <div id="existing-educations">
                @if (count($educations) > 0)
                    @foreach ($educations as $education)
                        <div class="education-item border rounded-lg p-3 mb-3 relative bg-white shadow-sm"
                            wire:key="{{ $education['id'] }}" x-data="{ open: false }">
                            {{-- Main Content Item AND Buttons --}}
                            <div class="flex justify-between items-start">
                                {{-- Text Section (Institution & Degree/Dates) --}}
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900">{{ $education['institution'] ?? 'Untitled Institution' }}</h4>
                                    <p class="text-sm text-gray-600">
                                        {{ $education['degree'] ?? '' }} @if($education['field_of_study']) in {{ $education['field_of_study'] }} @endif
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($education['start_date'])->format('M Y') }} -
                                        {{ ($education['is_current'] ?? false) ? 'Present' : (\Carbon\Carbon::parse($education['end_date'])->format('M Y') ?? '') }}
                                    </p>
                                    @if ($education['gpa'])
                                        <p class="text-xs text-gray-500 mt-1">
                                            GPA: {{ $education['gpa'] }}
                                        </p>
                                    @endif
                                </div>

                                {{-- Dropdown Button --}}
                                <div>
                                    <button @click="open = !open"
                                        class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50"
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
                            @if ($education['description'])
                                <div class="mt-2 text-sm text-gray-700 prose prose-sm max-w-none">
                                    {!! Str::markdown($education['description']) !!}
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <p id="no-education-message" class="text-gray-500 text-center py-4">No education entries added yet.</p>
                @endif
            </div>

            <div class="text-center mt-6">
                <button class="add-item-btn bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                    wire:click="openModal()">Add a new education</button>
            </div>
        </div>
    </div>

    {{-- Modal Form Education --}}
    <div x-data="{ show: @entangle('showModal').live }" x-show="show" x-transition x-cloak
        class="fixed inset-0 z-50 bg-gray-900 bg-opacity-50 flex items-center justify-center overflow-y-auto px-4">

        <div @click.away="show = false"
            class="relative bg-white rounded-lg shadow-lg w-full max-w-2xl max-h-[90vh] overflow-hidden">

            {{-- Header --}}
            <div class="flex justify-between items-center px-6 py-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    @if ($editingEducationId)
                        Edit Education
                    @else
                        Add New Education
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
                <form wire:submit="saveEducation">
                    <div class="mb-4">
                        <label for="institution" class="block text-sm font-medium text-gray-700">Institution</label>
                        <input type="text" id="institution" wire:model="form.institution"
                            class="form-input w-full p-2 border rounded @error('form.institution') border-red-500 @enderror" />
                        @error('form.institution')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="degree" class="block text-sm font-medium text-gray-700">Degree</label>
                        <input type="text" id="degree" wire:model="form.degree"
                            class="form-input w-full p-2 border rounded @error('form.degree') border-red-500 @enderror" />
                        @error('form.degree')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="field_of_study" class="block text-sm font-medium text-gray-700">Field of Study</label>
                        <input type="text" id="field_of_study" wire:model="form.field_of_study"
                            class="form-input w-full p-2 border rounded @error('form.field_of_study') border-red-500 @enderror" />
                        @error('form.field_of_study')
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
                            <input type="date" id="end_date" wire:model.live="form.end_date"
                                class="form-input w-full p-2 border rounded @error('form.end_date') border-red-500 @enderror"
                                {{ $form['is_current'] ? 'disabled' : '' }} /> {{-- Disable if is_current is checked --}}
                            @error('form.end_date')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <input type="checkbox" id="is_current" wire:model.live="form.is_current" class="mr-2" />
                        <label for="is_current" class="text-sm font-medium text-gray-700">Currently Studying Here</label>
                    </div>

                    <div class="mb-4">
                        <label for="gpa" class="block text-sm font-medium text-gray-700">GPA (Optional, e.g., 3.8)</label>
                        <input type="text" id="gpa" wire:model="form.gpa" placeholder="e.g., 3.8"
                            class="form-input w-full p-2 border rounded @error('form.gpa') border-red-500 @enderror" />
                        @error('form.gpa')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description / Achievements (Optional, supports Markdown)</label>
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
                <button type="submit" wire:click="saveEducation"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="saveEducation">
                        @if ($editingEducationId)
                            Update Education
                        @else
                            Add Education
                        @endif
                    </span>
                    <span wire:loading wire:target="saveEducation">Saving...</span>
                </button>
            </div>
        </div>
    </div>
</div>