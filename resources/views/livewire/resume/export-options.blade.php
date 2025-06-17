<div class="export-options">
    <div style="margin-bottom: 15px;">
        <h4>PDF</h4>
        <p style="font-size: 0.9em; color: #555;">Download a PDF of your resume.</p>
        {{-- Menggunakan properti $resume dari komponen Livewire --}}
        <a href="{{ route('resumes.export.pdf', $this->resume->slug) }}"
            style="display: block; padding: 8px 15px; background-color: #007bff; color: white; text-align: center; border-radius: 4px; text-decoration: none;">Download
            PDF</a>
        {{-- <a href="{{ route('resumes.view.pdf', $this->resume->slug) }}"
            style="display: block; padding: 8px 15px; background-color: #007bff; color: white; text-align: center; border-radius: 4px; text-decoration: none;">Download
            PDF</a> --}}
    </div>
</div>
