<footer>
    <div class="bg-darkBlue text-white py-10 md:py-10 px-7 md:px-20">
        <div class="w-full max-w-screen-xl mx-auto">
            <div class="grid md:grid-cols-2 gap-10">
                {{-- Kolom Kiri --}}
                <div>
                    <div class="flex items-center gap-4 justify-center md:justify-start">
                        <x-pnb-logo class="w-10" />
                        <p class="text-xl font-semibold">Pusat PNB Karir</p>
                    </div>
                    <div class="pt-5 md:pe-10 text-justify  text-xs">
                        <p>
                            Politeknik Negeri Bali (PNB) yang lebih dikenal dengan nama Poltek Bali merupakan lembaga
                            pendidikan tinggi bidang vokasi yang lebih mengedepankan praktik daripada teori.
                            Pembelajaran di
                            PNB menerapkan pola praktik sesuai dengan tuntutan industri (60%-70%) dan teori (30%-40%)
                            agar lulusan mampu mengisi kebutuhan industri baik dalam negeri maupun luar negeri.
                        </p>
                    </div>
                </div>

                {{-- Kolom Kanan (Follow Us) --}}
                <div class="flex flex-col items-center justify-center text-center space-y-4">
                    <p class="font-semibold text-xl">Follow Us</p>
                    <div class="flex flex-wrap justify-center gap-5 text-3xl">
                        {{-- WWW Logo --}}
                        <a href="#">
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M15 2.5C21.9 2.5 27.5 8.1 27.5 15C27.5 21.9 21.9 27.5 15 27.5C8.1 27.5 2.5 21.9 2.5 15C2.5 8.1 8.1 2.5 15 2.5ZM5.2627 12.7627C5.10021 13.4876 5 14.2251 5 15C5 20.1 8.81252 24.2996 13.75 24.9121V22.5C12.375 22.5 11.25 21.375 11.25 20V18.75L5.2627 12.7627ZM18.75 6.25C18.75 7.625 17.625 8.75 16.25 8.75H13.75V11.25C13.75 11.9375 13.1875 12.5 12.5 12.5H10V15H17.5C18.1875 15 18.75 15.5625 18.75 16.25V20H20C21.1249 20 22.0499 20.7249 22.375 21.7373C23.9999 19.9623 25 17.5999 25 15C25 10.8125 22.4125 7.2248 18.75 5.7373V6.25Z"
                                    fill="white" />
                            </svg>
                        </a>

                        {{-- Email --}}
                        <a href="https://pnb.ac.id"><i class="fa-regular fa-envelope"></i></a>

                        {{-- LinkedIn --}}
                        <a href="#"><i class="fa-brands fa-linkedin text-white"></i></a>

                        {{-- Facebook --}}
                        <a href="#"><i class="fa-brands fa-facebook text-white"></i></a>

                        {{-- Instagram --}}
                        <a href="#"><i class="fa-brands fa-instagram text-white"></i></a>

                        {{-- YouTube --}}
                        <a href="#"><i class="fa-brands fa-youtube text-white"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="w-full flex justify-center bg-darkBlue ">
    <p class="text-center text-sm text-gray-400 mt-8">&copy; {{ date('Y') }} PNB Pusat Karir. All rights reserved.
    </p>
</div>
