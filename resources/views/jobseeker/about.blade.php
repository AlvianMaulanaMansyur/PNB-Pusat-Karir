<x-jobseeker-layout>
    <div class="max-w-screen-xl w-full mx-auto px-4 sm:px-6 lg:px-32 py-10 flex-grow">
        <div>
            <x-breadcrumb :links="[['label' => 'Home', 'url' => route('employee.lowongan')], ['label' => 'Tentang Kami']]" />
        </div>

        <section>
            <img src="{{ asset('images/campus.jpg') }}" alt="Tentang Kami"
                class="rounded-xl shadow-md w-3/4 mx-auto my-8 mb-20">
            <div class="my-10">
                <h2 class="text-lg font-bold mb-3">Tentang Kami</h2>
                <p class="text-justify">Selamat datang di portal kami, tempat pendidikan yang memiliki keunggulan.
                    Didirikan dengan visi
                    untuk membina para pemimpin dan pemikir masa depan, kami berkomitmen untuk menyediakan pengalaman
                    belajar transformatif yang memiliki daya saing Internasional.</p>
            </div>

            <div class="text-justify my-5">
                <p><span class="font-bold">Misi Kami:</span> Untuk menginspirasi, berinovasi, dan menanamkan minat
                    terhadap
                    pengetahuan, membekali siswa dengan keterampilan dan pola pikir untuk berkembang dalam dunia yang
                    dinamis.
                </p>
            </div>

            <div>
                <h1 class="text-lg font-bold mb-3">Nilai-Nilai Inti</h1>
                <ol class="list-decimal pl-5 space-y-2">
                    <li><span class="font-bold">Keunggulan:</span> Mengejar keunggulan akademik dan penelitian untuk
                        memberdayakan mahasiswa serta
                        berkontribusi pada kemajuan masyarakat.</li>
                    <li><span class="font-bold">Keberagaman dan Inklusi:</span> Mendorong komunitas yang dinamis dan
                        inklusif yang merayakan perbedaan
                        dalam pemikiran, budaya, dan latar belakang.</li>
                    <li><span class="font-bold">Integritas:</span> Menjunjung tinggi standar etika tertinggi dalam semua
                        aspek pendidikan, penelitian,
                        dan keterlibatan masyarakat.</li>
                    <li><span class="font-bold">Inovasi:</span> Merangkul kreativitas dan melampaui batas-batas
                        pemikiran konvensional untuk mendorong
                        perubahan positif.</li>
                </ol>
            </div>

            <div class="my-10 text-justify" >
                <h1 class="font-bold text-lg mb-5">Tim Kami:</h1>
                <p>
                    Tim kami terdiri dari para pendidik, peneliti, dan profesional berpengalaman yang memiliki semangat
                    tinggi dalam membentuk masa depan para mahasiswa.
                </p>
                <p class="mt-7">
                    Bersama-sama, kami berkomitmen untuk menginspirasi, menantang, dan mempersiapkan mahasiswa agar
                    sukses di dunia yang terus berkembang. Jelajahi berbagai kemungkinan di portal kami, tempat di mana
                    keunggulan tidak mengenal batas.
                </p>

            </div>

        </section>
    </div>

</x-jobseeker-layout>
