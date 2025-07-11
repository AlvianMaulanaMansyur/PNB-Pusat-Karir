{{-- resources/views/livewire/resume/personal-details-form.blade.php --}}

<div>
    <div id="personal-details-section">
        <div class="panel-header flex justify-between items-center mb-4">
            <h3 class="flex items-center text-xl font-semibold">
                <img src="{{ asset('images/resume-icons/personal-details.png') }}" alt="Icon"
                    class="icon-resume icon-resume--large">
                Personal Details
            </h3>
        </div>
        <div class="panel-body">
            <div class="gap-6">
                {{-- Right Column (Form Inputs) --}}
                <div class="md:col-span-1 space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" id="name" wire:model.live="form.name"
                            class="form-input w-full p-2 border rounded @error('form.name') border-red-500 @enderror">
                        @error('form.name')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" wire:model.live="form.email"
                            class="form-input w-full p-2 border rounded @error('form.email') border-red-500 @enderror">
                        @error('form.email')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" id="phone" wire:model.live="form.phone"
                            class="form-input w-full p-2 border rounded @error('form.phone') border-red-500 @enderror">
                        @error('form.phone')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                        <input type="text" id="address" wire:model.live="form.address"
                            class="form-input w-full p-2 border rounded @error('form.address') border-red-500 @enderror">
                        @error('form.address')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                
            </div>

            <div class="mt-4">
                <label for="summary" class="block text-sm font-medium text-gray-700">Professional Summary</label>
                <textarea id="summary" wire:model.live="form.summary" rows="5"
                    class="form-textarea w-full p-2 border rounded @error('form.summary') border-red-500 @enderror"></textarea>
                @error('form.summary')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Left Column (Photo) --}}
            <div class="md:col-span-1 flex flex-col items-center">
                <label for="profilePhotoFile" class="block text-sm font-medium text-gray-700 mb-2">Profile
                    Photo</label>
                <div
                    class="relative w-32 h-32 rounded-full overflow-hidden border-2 border-gray-300 flex items-center justify-center bg-gray-100">
                    @if ($profilePhotoPreview)
                        <img src="{{ $profilePhotoPreview }}" alt="Profile Photo"
                            class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-user-circle text-6xl text-gray-400"></i>
                    @endif
                    <input type="file" id="profilePhotoFile" wire:model.live="profilePhotoFile"
                        class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*">
                    <span class="absolute bottom-0 right-0 bg-blue-500 text-white rounded-full p-2 text-xs">
                        <i class="fas fa-camera"></i>
                    </span>
                </div>
                @error('profilePhotoFile')
                    <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                @enderror
                @if ($profilePhotoPreview)
                    <button type="button" wire:click="removePhoto"
                        class="text-red-600 text-sm mt-2 hover:underline">Remove Photo</button>
                @endif
                <div wire:loading wire:target="profilePhotoFile" class="text-blue-600 text-sm mt-2">Uploading
                    photo...</div>
            </div>
        </div>
    </div>
</div>
