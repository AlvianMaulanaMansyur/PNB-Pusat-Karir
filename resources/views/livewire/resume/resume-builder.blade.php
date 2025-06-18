<div x-data="{
    isDesktop() { return window.innerWidth >= 1024; },
        initPanelStates() {
            @this.set('showLeftPanel', this.isDesktop());
            @this.set('showRightPanel', this.isDesktop());
            document.body.style.overflow = '';
        },
        // Deklarasikan variabel untuk menyimpan konteks `this` dari x-data
        // agar bisa diakses di dalam listener.
        // Atau bisa juga langsung memanggil `isDesktop()` tanpa `this` jika dideklarasikan di sini.
}" x-init="initPanelStates();

// Listen for browser events from Livewire to manage body scroll
window.addEventListener('toggle-body-scroll', event => {
    document.body.style.overflow = event.detail.action === 'hide' ? 'hidden' : '';
});

// Re-evaluate panel visibility on resize for desktop/mobile transitions
// Gunakan panah fungsi untuk mempertahankan `this` dari scope x-data
window.addEventListener('resize', () => {
    @this.set('showLeftPanel', isDesktop()); // Panggil langsung isDesktop()
    @this.set('showRightPanel', isDesktop()); // Panggil langsung isDesktop()
    document.body.style.overflow = '';
});" class="flex h-screen overflow-hidden lg:flex-row flex-col">

    {{-- Overlay for mobile panels --}}
    <template x-if="(@this.showLeftPanel || @this.showRightPanel) && !isDesktop()">
        <div class="overlay" @click="@this.set('showLeftPanel', false); @this.set('showRightPanel', false)"></div>
    </template>

    {{-- LEFT PANEL --}}
    <div id="left-panel" x-cloak
        :class="{
            'fixed inset-y-0 left-0 w-[320px] z-50 transform transition-transform duration-300 ease-out': !isDesktop(),
            'translate-x-0': @this.showLeftPanel && !isDesktop(),
            '-translate-x-full': !@this.showLeftPanel && !isDesktop(),
            'relative flex-shrink-0': isDesktop()
        }"
        :style="isDesktop() ? `width: ${@this.leftWidth}px;` : ''"
        class="bg-white border-r border-gray-200 p-6 overflow-y-auto custom-scrollbar">
        <div class="bg-white pb-4 z-10 border-b border-gray-200 -mx-6 px-6">
            <h2 class="text-xl font-semibold mb-4 flex justify-between items-center">
                Resume Sections
                <button x-show="!isDesktop()" wire:click="toggleLeftPanel" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </h2>
        </div>
        <div class="pt-4">
            <div class="panel-section">
                @livewire('resume.personal-details-form', [
                    'id' => $resumeId,
                ])
            </div>

            <div class="panel-section">
                @livewire('resume.experience-form', [
                    'id' => $resumeId,
                ])
            </div>

            <div class="panel-section">
                @livewire('resume.education-form', [
                    'id' => $resumeId,
                ])
            </div>

            <div class="panel-section">
                @livewire('resume.skills-form', [
                    'id' => $resumeId,
                ])
            </div>

            <div class="panel-section">
                @livewire('resume.projects-form', [
                    'id' => $resumeId,
                ])
            </div>

            <div class="panel-section">
                @livewire('resume.certifications-form', [
                    'id' => $resumeId,
                ])
            </div>

            <div class="panel-section">
                @livewire('resume.awards-form', [
                    'id' => $resumeId,
                ])
            </div>

            <div class="panel-section">
                @livewire('resume.volunteering-form', [
                    'id' => $resumeId,
                ])
            </div>

            <div class="panel-section">
                @livewire('resume.interests-form', [
                    'id' => $resumeId,
                ])
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT (RESUME PREVIEW) --}}
    <div id="main-content" x-cloak
        :class="{
            'flex-1 flex flex-col p-3 items-center justify-start bg-gray-100 overflow-hidden relative': true,
            'w-full': !isDesktop() // Ambil lebar penuh di mobile
        }">
        <div class="h-full w-full max-w-[210mm] relative overflow-y-auto overflow-x-hidden custom-scrollbar">
            <div id="resume-wrapper" class="h-full w-full flex justify-center items-start overflow-hidden">
                <div id="resume-preview" class="resume-preview bg-white shadow-lg border border-gray-200"
                    style="padding: 20mm;">
                    {{-- Ini akan diisi oleh Livewire Component ResumePreview --}}
                    @livewire('resume.resume-preview', ['resumeData' => $resumeData])
                </div>
            </div>
        </div>

        {{-- Zoom Controls (bottom-center) - Panzoom handled by regular JS --}}
        <div
            class="absolute bottom-6 left-1/2 -translate-x-1/2 flex items-center bg-gray-800 text-white p-2 rounded-lg shadow-xl z-20">
            <button id="zoom-out" class="px-3 py-1 bg-gray-700 rounded-l-md hover:bg-gray-600">-</button>
            <span class="px-3">Zoom</span>
            <button id="zoom-in" class="px-3 py-1 bg-gray-700 hover:bg-gray-600">+</button>
            <button id="reset-zoom" class="px-3 py-1 bg-gray-700 rounded-r-md hover:bg-gray-600 ml-2">Reset</button>
        </div>

        {{-- Mobile Toggles for Panels --}}
        <div class="lg:hidden absolute top-6 flex w-full justify-between px-6 z-30">
            <button wire:click="toggleLeftPanel"
                class="p-2 bg-white rounded-md shadow-md text-gray-700 hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
            <button wire:click="toggleRightPanel"
                class="p-2 bg-white rounded-md shadow-md text-gray-700 hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    {{-- RIGHT PANEL --}}
    <div id="right-panel" x-cloak
        :class="{
            'fixed inset-y-0 right-0 w-[280px] z-50 transform transition-transform duration-300 ease-out': !isDesktop(),
            'translate-x-0': @this.showRightPanel && !isDesktop(),
            'translate-x-full': !@this.showRightPanel && !isDesktop(),
            'relative flex-shrink-0': isDesktop()
        }"
        :style="isDesktop() ? `width: ${@this.rightWidth}px;` : ''"
        class="bg-white border-l border-gray-200 p-6 overflow-y-auto custom-scrollbar">
        <div class="sticky top-0 bg-white pb-4 z-10 border-b border-gray-200 -mx-6 px-6">
            <h2 class="text-xl font-semibold mb-4 flex justify-between items-center">
                Options & Export
                <button x-show="!isDesktop()" wire:click="toggleRightPanel" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </h2>
        </div>
        <div class="pt-4">
            @livewire('resume.export-options', ['resume' => $resume])
        </div>
    </div>

</div>

<script>
    
</script>
