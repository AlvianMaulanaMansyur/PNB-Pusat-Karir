{{-- resources/views/livewire/resume/skills-form.blade.php --}}

<div>
    <div id="skills-section" class="panel-container">
        <div class="panel-header flex justify-between items-center">
            <h3 class="flex items-center text-xl font-semibold">
                <img src="{{ asset('images/resume-icons/skills.png') }}" alt="Icon"
                    class="icon-resume icon-resume--large">
                Skill
            </h3>
        </div>

        <div class="panel-body" >
            <div id="existing-skills" class="panel-item">
                @php
                    $allSkills = $skills ?? [];
                @endphp

                {{-- @dd($skills) --}}

                @if (count($allSkills) > 0)
                    @foreach ($allSkills as $skill)
                        <div class="skill-item border rounded-lg p-3 mb-3 relative bg-white shadow-sm hover:bg-gray-50 cursor-pointer transition duration-200"
                        wire:key="{{ $skill['id'] }}" x-data="{ open: false }" @click="open = !open">
                            <div class="flex justify-between items-center">
                                <div class="overflow-hidden max-w-[85%]">
                                    <h4 class="text-md font-medium truncate">
                                        {{ $skill['name'] ?? '' }}
                                    </h4>
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
                                            wire:click="openModal('{{ $skill['id'] }}')">
                                            <i class="fas fa-edit mr-3 text-gray-500"></i> Edit
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button"
                                            class="w-full flex items-center px-4 py-2 hover:bg-gray-100"
                                            wire:click="duplicateSkill('{{ $skill['id'] }}')">
                                            <i class="far fa-copy mr-3 text-gray-500"></i> Copy
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button"
                                            class="w-full flex items-center px-4 py-2 text-red-600 hover:bg-red-50"
                                            wire:click="removeSkill('{{ $skill['id'] }}')">
                                            <i class="fas fa-trash-alt mr-3"></i> Remove
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p id="no-skills-message" class="text-gray-500 text-center py-4">No skills added yet. Click "Add New
                        Skill" to get started.</p>
                @endif
            </div>

            <div class="text-center mt-6">
                <button class="add-item-btn bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                    wire:click="openModal()">Add New Skill</button>
            </div>
        </div>
    </div>

    {{-- Modal Form Skill --}}
    <div x-data="{ show: @entangle('showModal').live }" x-show="show" x-transition x-cloak
        class="fixed inset-0 z-50 bg-gray-900 bg-opacity-50 flex items-center justify-center overflow-y-auto px-4">

        <div @click.away="show = false"
            class="relative bg-white rounded-lg shadow-lg w-full max-w-xl max-h-[90vh] overflow-hidden">

            {{-- Header --}}
            <div class="flex justify-between items-center px-6 py-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    @if ($editingSkillId)
                        Edit Skill
                    @else
                        Add New Skill
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
                <form wire:submit.prevent="saveSkill">
                    {{-- Nama Skill --}}
                    <div class="mb-4">
                        <label for="skill_name" class="block text-sm font-medium text-gray-700">Skill Name</label>
                        <input type="text" id="skill_name" wire:model="form.name"
                            class="form-input w-full p-2 border rounded @error('form.name') border-red-500 @enderror" />
                        @error('form.name')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
            </div>

            {{-- Footer --}}
            <div class="flex justify-end items-center px-6 py-2 border-t rounded-b space-x-2">
                <button type="button" wire:click="closeModal"
                    class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">Cancel</button>
                <button type="submit" wire:click="saveSkill"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="saveSkill">
                        @if ($editingSkillId)
                            Update Skill
                        @else
                            Add Skill
                        @endif
                    </span>
                    <span wire:loading wire:target="saveSkill">Saving...</span>
                </button>
            </div>
        </div>
    </div>
</div>
