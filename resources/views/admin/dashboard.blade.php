    @extends('admin.layouts.app')
    @section('content')
            <!-- Content -->
            <main class="p-6 space-y-6">
                <!-- Info Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white p-4 rounded shadow text-center">
                        <p class="text-gray-500">Akun Terverifikasi</p>
                        <div class="flex justify-center items-center gap-2">
                            <span class="text-3xl font-bold">500</span>
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M16.707 9.293a1 1 0 00-1.414 0L11 13.586 8.707 11.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l5-5a1 1 0 000-1.414z"/></svg>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded shadow text-center">
                        <p class="text-gray-500">Lowongan Aktif</p>
                        <div class="flex justify-center items-center gap-2">
                            <span class="text-3xl font-bold">25</span>
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12a5 5 0 100-10 5 5 0 000 10zm0 2c-4.42 0-8 2.015-8 4.5V20h16v-1.5c0-2.485-3.58-4.5-8-4.5z"/></svg>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded shadow text-center">
                        <p class="text-gray-500">Event Aktif</p>
                        <div class="flex justify-center items-center gap-2">
                            <span class="text-3xl font-bold">10</span>
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 100 20 10 10 0 000-20zm4.293 6.293L10 14.586l-2.293-2.293-1.414 1.414L10 17.414l8-8-1.414-1.414z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Table Verifikasi -->
                <div class="bg-white p-4 rounded shadow">
                    <h2 class="text-lg font-semibold mb-4">Verifikasi Akun Employer</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left border">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 border">NAMA</th>
                                    <th class="px-4 py-2 border">EMAIL</th>
                                    <th class="px-4 py-2 border">TANGGAL REGISTRASI</th>
                                    <th class="px-4 py-2 border">STATUS</th>
                                    <th class="px-4 py-2 border">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-t">
                                    <td class="px-4 py-2">EMPLOYER 1</td>
                                    <td class="px-4 py-2">employer1@gmail.com</td>
                                    <td class="px-4 py-2">2025-01-21</td>
                                    <td class="px-4 py-2 text-green-600 font-semibold">TERVERIFIKASI</td>
                                    <td class="px-4 py-2">
                                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2l4 -4" /></svg>
                                    </td>
                                </tr>
                                <tr class="border-t">
                                    <td class="px-4 py-2">EMPLOYER 2</td>
                                    <td class="px-4 py-2">employer2@gmail.com</td>
                                    <td class="px-4 py-2">2025-03-24</td>
                                    <td class="px-4 py-2 text-green-600 font-semibold">TERVERIFIKASI</td>
                                    <td class="px-4 py-2">
                                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2l4 -4" /></svg>
                                    </td>
                                </tr>
                                <tr class="border-t">
                                    <td class="px-4 py-2">EMPLOYER 3</td>
                                    <td class="px-4 py-2">employer3@gmail.com</td>
                                    <td class="px-4 py-2">2025-04-23</td>
                                    <td class="px-4 py-2 text-red-600 font-semibold">DITOLAK</td>
                                    <td class="px-4 py-2">
                                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M6 6l12 12M6 18L18 6" /></svg>
                                    </td>
                                </tr>
                                <tr class="border-t">
                                    <td class="px-4 py-2">EMPLOYER 4</td>
                                    <td class="px-4 py-2">employer4@gmail.com</td>
                                    <td class="px-4 py-2">2025-05-04</td>
                                    <td class="px-4 py-2 text-yellow-600 font-semibold">MENUNGGU</td>
                                    <td class="px-4 py-2">
                                        <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 6v6l4 2" /></svg>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="text-right">
                    <button class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"/></svg>
                        TAMBAH BARU
                    </button>
                </div>
            </main>
    @endsection