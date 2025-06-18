<x-jobseeker-layout>
    <div class="container">
        <h1>Create New Resume</h1>

        <form action="{{ route('resumes.store') }}" method="POST" style="margin-top: 20px;">
            @csrf

            <div style="margin-bottom: 15px;">
                <label for="title" style="display: block; margin-bottom: 5px; font-weight: bold;">Resume Title:</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required
                       style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                @error('title')
                    <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                    style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Create Resume
            </button>
            <a href="{{ route('resumes.index') }}"
               style="display: inline-block; padding: 10px 20px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 4px; margin-left: 10px;">
                Cancel
            </a>
        </form>
    </div>
</x-jobseeker-layout>
