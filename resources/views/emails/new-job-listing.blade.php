@component('mail::message')
    # Lowongan Baru Tersedia!

    Kami baru saja menambahkan lowongan baru:

    **{{ $jobListing->nama_lowongan }}**

    Posisi: {{ $jobListing->posisi }}
    Deadline: {{ \Carbon\Carbon::parse($jobListing->deadline)->format('d M Y') }}

    @component('mail::button', ['url' => route('job.detail', $jobListing->id)])
        Lihat Lowongan
    @endcomponent


    Terima kasih,<br>
    {{ config('app.name') }}
@endcomponent
