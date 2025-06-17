<div class="export-options">
    <div style="margin-bottom: 15px;">
        <h4>JSON</h4>
        <p style="font-size: 0.9em; color: #555;">Download a JSON snapshot of your resume.</p>
        <a href="{{ route('resumes.export.json', $resume->slug) }}"
           style="display: block; padding: 8px 15px; background-color: #28a745; color: white; text-align: center; border-radius: 4px; text-decoration: none;">Download JSON</a>
    </div>

    <div style="margin-bottom: 15px;">
        <h4>PDF</h4>
        <p style="font-size: 0.9em; color: #555;">Download a PDF of your resume.</p>
        <a href="{{ route('resumes.export.pdf', $resume->slug) }}"
           style="display: block; padding: 8px 15px; background-color: #007bff; color: white; text-align: center; border-radius: 4px; text-decoration: none;">Download PDF</a>
    </div>
</div>