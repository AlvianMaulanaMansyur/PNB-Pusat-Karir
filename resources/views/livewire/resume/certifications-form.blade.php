{{-- resources/views/livewire/resume/certifications-form.blade.php --}}

<div>
    <div id="certifications-section" class="panel-container">
        <div class="panel-header flex justify-between items-center">
            <h3>Certifications & Licenses</h3>
        </div>

        <div class="panel-body">
            <div id="existing-certifications">
                @if (count($certifications) > 0)
                    @foreach ($certifications as $certification)
                        <div class="certification-item border rounded-lg p-3 mb-3 relative bg-white shadow-sm"
                            wire:key="{{ $certification['id'] }}" x-data="{ open: false }">
                            {{-- Konten Utama Item DAN Tombol --}}
                            <div class="flex justify-between items-start">
                                {{-- Bagian Teks --}}
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900">{{ $certification['name'] ?? 'Untitled Certification' }}</h4>
                                    <p class="text-sm text-gray-600">
                                        {{ $certification['issuing_organization'] ?? 'N/A' }} |
                                        Issued: {{ $certification['issue_date'] ?? '' }}
                                        @if ($certification['expiration_date'])
                                            | Expires: {{ $certification['expiration_date'] }}
                                        @endif
                                    </p>
                                    @if ($certification['credential_id'])
                                        <p class="text-xs text-gray-500 mt-1">Credential ID: {{ $certification['credential_id'] }}</p>
                                    @endif
                                    @if ($certification['credential_url'])
                                        <a href="{{ $certification['credential_url'] }}" target="_blank" class="text-blue-500 hover:underline text-sm block mt-1">Verify Credential</a>
                                    @endif
                                </div>

                                {{-- Tombol Dropdown --}}
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
                                            wire:click="openModal('{{ $certification['id'] }}')">
                                            <i class="fas fa-edit mr-3 text-gray-500"></i> Edit
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button"
                                            class="w-full flex items-center px-4 py-2 hover:bg-gray-100"
                                            wire:click="duplicateCertification('{{ $certification['id'] }}')">
                                            <i class="far fa-copy mr-3 text-gray-500"></i> Copy
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button"
                                            class="w-full flex items-center px-4 py-2 text-red-600 hover:bg-red-50"
                                            wire:click="removeCertification('{{ $certification['id'] }}')">
                                            <i class="fas fa-trash-alt mr-3"></i> Remove
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p id="no-certification-message" class="text-gray-500 text-center py-4">No certifications or licenses added yet.</p>
                @endif
            </div>

            <div class="text-center mt-6">
                <button class="add-item-btn bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                    wire:click="openModal()">Add a new certification</button>
            </div>
        </div>
    </div>

    {{-- Modal Form Certification --}}
    <div x-data="{ show: @entangle('showModal').live }" x-show="show" x-transition x-cloak
        class="fixed inset-0 z-50 bg-gray-900 bg-opacity-50 flex items-center justify-center overflow-y-auto px-4">

        <div @click.away="show = false"
            class="relative bg-white rounded-lg shadow-lg w-full max-w-2xl max-h-[90vh] overflow-hidden">

            {{-- Header --}}
            <div class="flex justify-between items-center px-6 py-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    @if ($editingCertificationId)
                        Edit Certification
                    @else
                        Add New Certification
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
                <form wire:submit="saveCertification">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Certification/Course Name</label>
                        <input type="text" id="name" wire:model="form.name"
                            class="form-input w-full p-2 border rounded @error('form.name') border-red-500 @enderror" />
                        @error('form.name')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="issuing_organization" class="block text-sm font-medium text-gray-700">Issuing Organization</label>
                        <input type="text" id="issuing_organization" wire:model="form.issuing_organization"
                            class="form-input w-full p-2 border rounded @error('form.issuing_organization') border-red-500 @enderror" />
                        @error('form.issuing_organization')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="issue_date" class="block text-sm font-medium text-gray-700">Issue Date</label>
                            <input type="date" id="issue_date" wire:model="form.issue_date"
                                class="form-input w-full p-2 border rounded @error('form.issue_date') border-red-500 @enderror" />
                            @error('form.issue_date')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="expiration_date" class="block text-sm font-medium text-gray-700">Expiration Date (Optional)</label>
                            <input type="date" id="expiration_date" wire:model="form.expiration_date"
                                class="form-input w-full p-2 border rounded @error('form.expiration_date') border-red-500 @enderror" />
                            @error('form.expiration_date')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="credential_id" class="block text-sm font-medium text-gray-700">Credential ID (Optional)</label>
                        <input type="text" id="credential_id" wire:model="form.credential_id"
                            class="form-input w-full p-2 border rounded @error('form.credential_id') border-red-500 @enderror" />
                        @error('form.credential_id')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="credential_url" class="block text-sm font-medium text-gray-700">Credential URL (Optional)</label>
                        <input type="url" id="credential_url" wire:model="form.credential_url" placeholder="https://www.credly.com/badges/..."
                            class="form-input w-full p-2 border rounded @error('form.credential_url') border-red-500 @enderror" />
                        @error('form.credential_url')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
            </div>

            {{-- Footer --}}
            <div class="flex justify-end items-center px-6 py-2 border-t rounded-b space-x-2">
                <button type="button" wire:click="closeModal"
                    class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">Cancel</button>
                <button type="submit" wire:click="saveCertification"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="saveCertification">
                        @if ($editingCertificationId)
                            Update Certification
                        @else
                            Add Certification
                        @endif
                    </span>
                    <span wire:loading wire:target="saveCertification">Saving...</span>
                </button>
            </div>
        </div>
    </div>
</div>