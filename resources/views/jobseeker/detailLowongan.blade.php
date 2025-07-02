<x-jobseeker-layout>
    <div class="w-full px-4 sm:px-6 lg:px-8 mt-10 mb-5">

        @foreach ( $jobApplied as $key )

        <section class="max-w-2xl mx-auto border rounded p-5 shadow bg-white my-4">
            <p class="text-xl font-semibold text-gray-800">{{ $key->status }}</p>
            <p>{{ $key->job->nama_lowongan }}</p>
            <p>{{ $key->job->nama_lowongan }}</p>

        </section>
        @endforeach
    </div>

</x-jobseeker-layout>
